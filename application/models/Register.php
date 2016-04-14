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
class Register extends CI_Model {

    protected $register;
    protected $buy;
    protected $token;
    protected $buy_receipt;
    protected $team;
    protected $name;
    protected $password;
    protected $player;

    // Constructor

    function __construct() {
        parent::__construct();
        $this->buy='http://botcards.jlparry.com/buy';
        $this->register = 'http://botcards.jlparry.com/register';
        $this->team = 'A09';
        $this->name = 'Kobe';
        $this->password = 'tuesday';
        $this->player = 'hahaha';
    }

    function _register() {

        $fields = array(
            'team' => $this->team,
            'name' => $this->name,
            'password' => $this->password
        );
        $result = $this->curl->simple_post($this->register, $fields);
        echo $result;
        $this->token = (string) $result->token;
        /*
        $results = $this->send($fields);
        $this->token = (string) $results->token;
         * */
         
    }

    // get token function 
    function get_token() {
        return $this->token;
    }

    function buy() {
        $fields = array(
            'team' => $this->team,
            //'token' => 'af17db2c9717f8520a8859cc06df40f1',
            'token' => $this->token,
            'player' => $this->player
        );
        $result = $this->curl->simple_post($this->buy, $fields);
        $this->buy_receipt = $result;
        echo $result;
        /*$results = $this->send($fields);
        echo $results;*/
    }



}
