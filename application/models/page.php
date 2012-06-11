<?php

use ChromePhp as console;

class Page {

    public $id;
    public $file;
    public $symbols;

    public static function new_id() {

        $file = 'storage/pages/current.id';
        $cur_id = File::get($file);
        $new_id = $cur_id + rand(25,250);

        File::put($file, $new_id);
        return self::hash_id($new_id);

    }

    public static function hash_id($int) {
        return base_convert($int, 10, 36);
    }

    function __construct($id)
    {
        $this->id = $id;
        $this->file = 'storage/pages/' . $id . '.data';
        $data = unserialize(File::get($this->file));
        $this->symbols = ($data) ? $data : array();
    }

    function __toString() {
        return serialize($this->symbols);
    }

    function symbols() {
        return $this->symbols;
    }

    function add_symbol($symbol) {
        $this->symbols[] = $symbol;
    }

    function buy_symbol($trade) {

        $index = $this->_get_symbol_index($trade['symbol']);
        $symbol = $this->symbols[$index];

        if (!isset($symbol['trades'])) {
            $symbol['trades'] = array();
        }

        $symbol['trades'][] = array(
            'type' => 'buy',
            'quantity' => $trade['quantity'],
            'price' => $trade['price'],
            'date' => strtotime($trade['date'])*1000,
            'fees' => $trade['fees'],
            'notes' => $trade['notes']
        );

        $this->symbols[$index] = $symbol;
    }

    function delete_symbol($symbol) {

        foreach($this->symbols as $index => $data) {
            if ($data['symbol'] == $symbol) {
                unset($this->symbols[$index]);
                break;
            }
        }

    }

    function save() {
        File::put($this->file, serialize($this->symbols));
    }


    protected function _get_symbol_index($symbol) {
        foreach($this->symbols as $index => $data) {
            if ($data['symbol'] == $symbol) {
                return $index;
            }
        }
        return false;
    }

}