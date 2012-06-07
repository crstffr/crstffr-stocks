<?php

class Symbol {

    public $name;
    public $file;

    function __construct($name)
    {
        $this->name = $name;
        $this->file = 'storage/symbols/'.$name;
    }

    public function history()
    {

        $local = $this->_load_local_history();

        if (!empty($local)) {
            return $local;
        }

        $remote = $this->_load_remote_history();

        if (!empty($remote)) {

            $this->_write_local_history($remote);
            return $remote;

        }

    }

    protected function _load_local_history()
    {
        if (!File::exists($this->file)) {
            return false;
        }

        return File::get($this->file);

    }

    protected function _write_local_history($data) {

        File::put($this->file, $data);

    }

    protected function _load_remote_history()
    {

        $url = array();
        $url[] = "http://finance.google.com/finance/historical";
        $url[] = "?q=" . $this->name;
        $url[] = "&startdate=June+6+2008";
        $url[] = "&enddate=June+6+2012";
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

        return json_encode($output);

    }

}