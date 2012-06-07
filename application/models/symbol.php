<?php

class Symbol {

    public $name;
    public $file;

    const TIME_BETWEEN_UPDATES  = 86400;
    const FURTHEST_BACK  = 157788000;

    function __construct($name)
    {
        $this->name = $name;
        $this->file = 'storage/symbols/'.$name;
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