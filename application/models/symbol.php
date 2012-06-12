<?php

use ChromePhp as console;

class Symbol {

    public $name;
    public $file;

    const TIME_BETWEEN_UPDATES  = 86400;
    const FURTHEST_BACK  = 157788000;

    function __construct($name)
    {
        $this->name = $name;
        $this->file = 'storage/symbols/' . $name . '.data';
    }


    public static function lookup_symbol_by_query($query) {

        $callback = 'YAHOO.Finance.SymbolSuggest.ssCallback';
        $url =  'http://d.yimg.com/autoc.finance.yahoo.com/autoc';
        $url .= '?query=' . $query;
        $url .= '&callback=' . $callback;

        $response = Requests::get($url);
        $body = $response->body;

        // incoming data is wrapped in JSONP callback
        // so strip that off and decode like normal.

        $body = substr($body, strlen($callback) + 1, -1);
        $data = json_decode($body, true);
        $out  = array();

        if ($data === false ||
            !isset($data['ResultSet']) ||
            !isset($data['ResultSet']['Result']) ||
            empty($data['ResultSet']['Result'])) {

            return '';
        }

        // We have results, lets loop through them
        // and format them properly for output.

        foreach ($data['ResultSet']['Result'] as $symbol) {

            $out[] = array('full'    => $symbol['symbol'] . " : " . $symbol['name'],
                           'symbol'  => $symbol['symbol'],
                           'company' => $symbol['name']);

        }

        return $out;

    }

    public static function lookup_companyinfo_by_query($query)
    {

        $out = array('wiki' => '', 'description' => '', 'website' => '');

        // Fetch the Wikipedia article for this company by querying
        // the wikipedia open search (their autocomplete).

        $url  = "http://en.wikipedia.org/w/api.php?action=opensearch";
        $url .= "&search=" . $query;

        $response = Requests::get($url);
        $body = json_decode($response->body);

        if (empty($body) || empty($body[0])) {
            return $out;
        }

        // If the search returned nothing, then pop the last
        // word off the search and try again until we either
        // get SOMETHING or NOTHING.

        if (!isset($body[1][0])) {

            // strip the last word off the search again
            $arr = explode(' ', $query); array_pop($arr);
            return self::lookup_companyinfo_by_query(implode(' ', $arr));

        }

        $first_result = $body[1][0];
        $clean_result = preg_replace('/\s/', '_', $first_result);
        $out['wiki'] = "en.wikipedia.org/wiki/" . $clean_result;

        // Fetch that Wiki page and pull some description and other
        // information from it using Simple HTML Dom.

        $wiki_response = Requests::get('http://' . $out['wiki']);

        $dom = new simple_html_dom();
        $dom->load($wiki_response->body);

        // Scrape the DOM for the first content paragraph.

        $content = $dom->find('div#mw-content-text', 0);
        if (count($content) === 0) { return $out; }

        $info = $content->find('p',0);
        if (count($info) === 0) { return $out; }

        $desc = $info->plaintext;
        $desc = preg_replace("/\[\d+\]/", "", $desc);
        $desc = preg_replace("/\([^)]*\) /", "", $desc);
        $out['description'] = $desc;

        // Scrape the DOM for the Website in the infobox.

        $table = $dom->find('table.infobox', 0);
        if (count($table) === 0) { return $out; }

        $rows = $table->find('tr');
        if (count($rows) === 0) { return $out; }

        foreach($rows as $row) {
            $th = $row->find('th', 0);
            if (count($th) === 1) {
                if (strtolower(trim($th->plaintext)) === "website") {
                    $out['website'] = parse_url(strtolower($row->find('a', 0)->href), PHP_URL_HOST);
                    break;
                }
            }
        }

        return $out;

    }

    public function last_price()
    {
        $history = $this->history();
        $data = json_decode($history);
        $last = array_pop($data);

        $out = array('date'  => $last[0],
                     'price' => $last[1]);

        return $out;

    }


    public function history()
    {

        // Fetch data from the local storage
        $local = $this->_load_local_history();
        if (!empty($local)) {
            return $local;
        }

        // If we don't have local, then pull it
        // from remote API and then write it.
        $history = $this->_load_remote_history();
        if (!empty($history)) {
            $json = json_encode($history);
            File::put($this->file, $json);
            return $json;
        }

    }

    protected function _load_local_history()
    {
        if (!File::exists($this->file)) {
            return false;
        }

        // File exists, check to see if it's up to date
        // If not, update it with the missing back data.

        $mtime = File::modified($this->file);
        if ($mtime + self::TIME_BETWEEN_UPDATES < time()) {
            $this->_update_local_history();
        }

        return File::get($this->file);

    }

    protected function _update_local_history()
    {
        // Our local file is out of date.  Decode the stored JSON
        // and grab the most recent date out of the array.  Use
        // that date to fetch a block up new data from the API.

        $json = File::get($this->file);
        $data = json_decode($json, true);

        $last = end($data);
        $last_date = $last[0]/1000;
        $more_data = $this->_load_remote_history($last_date);

        foreach($more_data as $index => $new_entry) {
            if ($index === 0) { continue; } // first entry is a duplicate
            $data[] = $new_entry;
        }

        // Write the whole array to the symbol storage
        File::put($this->file, json_encode($data));

    }

    protected function _load_remote_history($startDate = false, $endDate = false)
    {

        $startDate = ($startDate) ? $startDate : time() - self::FURTHEST_BACK;
        $endDate = ($endDate) ? $endDate : time();

        $url = array();
        $url[] = "http://finance.google.com/finance/historical";
        $url[] = "?q=" . $this->name;
        $url[] = "&startdate=" . date("F+j+Y", $startDate);
        $url[] = "&enddate=" . date("F+j+Y", $endDate);
        $url[] = "&output=csv";

        $api_url = implode('', $url);
        $raw_csv = file_get_contents($api_url);
        $lines = array_reverse(explode("\n", $raw_csv));
        $output = array();

        foreach ($lines as $index => $line) {

            if ($index === 0 || empty($line)) { continue; }

            $cells = str_getcsv($line);
            $date = (strtotime($cells[0]) * 1000);
            $cost = (float) $cells[4];

            if ($date === 0) { continue; }

            $output[] = array($date, $cost);

        }

        return $output;

    }

}