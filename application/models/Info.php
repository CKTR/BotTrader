<?php

/**
 * core/MY_Model.php
 *
 * Generic domain model.
 *
 * Intended to model both a single domain entity as well as a table.
 * This is consistent with CodeIgniter's interpretation of the Active Record
 * pattern, even though some of the functions are at the table level
 * while others are at the record level :-/
 *
 * Each such model is bound to a specific database table, using a designated
 * key field as the associative array index internally.
 */
class Info extends CI_Model {

    protected $series;
    protected $certificates;
    protected $transactions;
    protected $series_data;
    protected $certificates_data;
    protected $transaction_data;

    // Constructor

    function __construct() {
        parent::__construct();
        $this->series = 'http://botcards.jlparry.com/data/series';
        $this->certificates = 'http://botcards.jlparry.com/data/certificates';
        $this->transactions = 'http://botcards.jlparry.com/data/transactions';
        $this->series_data = $this->_retrieve_data($this->series);
        $this->certificates_data = $this->_retrieve_data($this->certificates);
        $this->transactions_data = $this->_retrieve_data($this->transactions);
    }

    function get_series_data() {
        return $this->series_data;
    }

    function get_certificates_data() {
        return $this->certificates_data;
    }

    function get_transactions_data() {
        return $this->transactions_data;
    }

    function get_player_recent_trans($player, $num) {
        $_arr;
        $player_trans;
        foreach ($this->transactions_data as $t) {
            if ($t['player'] == $player)
                $player_trans[] = $t;
        }
        ksort($player_trans);
        $_arr = array_slice($player_trans, 0, $num);
        return $_arr;
    }

    //get functions for play
    function get_all_bot_names() {
        $_arr;
        foreach ($this->series_data as $t) {

            $_arr[] = $t['description'];
        }
        return $_arr;
    }

    function get_all_bot_codes() {
        $_arr;
        foreach ($this->series_data as $t) {

            $_arr[] = $t['code'];
        }
        return $_arr;
    }

    function get_all_frequency() {
        $_arr;
        foreach ($this->series_data as $t) {

            $_arr[] = $t['frequency'];
        }
        return $_arr;
    }

    function get_all_value() {
        $_arr;
        foreach ($this->series_data as $t) {

            $_arr[] = $t['value'];
        }
        return $_arr;
    }

    function get_bot_by_code($code) {
        $_arr;
        foreach ($this->series_data as $t) {
            if ($t['code'] == $code) {
                $_arr = $t;
            }
        }
        return $_arr;
    }

    function get_bot_by_name($name) {
        $_arr;
        foreach ($this->series_data as $t) {
            if ($t['name'] == $name) {
                $_arr = $t;
            }
        }
        return $_arr;
    }

    function get_bot_value($code) {
        $value;
        foreach ($this->series_data as $t) {
            if ($t['code'] == $code) {
                $value = $t['value'];
            }
        }
        return $value;
    }

    function get_bot_frequency($code) {
        $value;
        foreach ($this->series_data as $t) {
            if ($t['code'] == $code) {
                $value = $t['frequency'];
            }
        }
        return $value;
    }

    /*
      function get_bot_by_code($code){
      $_arr;
      foreach($array as $t){

      $_arr[]= $t['code'];
      }
      return $_arr;
      }
     * */

    /*
      function get_all_players() {
      $list = [];
      foreach ($this->certificates_data as $c) {
      $list[] = $c['player'];
      }
      $list = array_unique($list);
      return $list;
      }
     */

    function _retrieve_data($url) {
        $response = $this->get_data($url);
        $arr = $this->format_content($response);
        return $arr;
    }

    function format_content($response) {
        $_arr = [];
        $Data = str_getcsv($response, "\n"); //parse the rows 
        foreach ($Data as &$Row) {
            $Row = str_getcsv($Row);
            $_arr[] = $Row;
        }
        $arr = $this->_format($_arr);
        return $arr;
    }

    function _format($arr) {
        //$_arr = [];
        $_arr_list = [];
        //echo count(array_keys($arr));
        for ($x = 1; $x < count(array_keys($arr)); $x++) {

            $_arr_list[] = array_combine($arr[0], $arr[$x]);
            //print_r($_arr);
        }
        return $_arr_list;
    }

    function get_data($url) {
        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

}



