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
class Register extends MY_Model {

    protected $register;
    protected $buy;
    protected $token;
    protected $buy_receipt;
    protected $team;
    protected $name;
    protected $password;
    protected $player;
    protected $sell_receipt;
    protected $sell;
    // Constructor

    function __construct() {
        parent::__construct('agent', 'name');
        $this->buy='http://botcards.jlparry.com/buy';
        $this->sell='http://botcards.jlparry.com/sell';
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
        $xml = simplexml_load_string($result);
        $this->token = (string) $xml->token;
        //print_r($xml);
        //echo (string) $xml->token;
        if($this->get($this->name)){
        $this->delete($this->name);
        $obj = $this->create();
        $obj->team = $this->team;
        $obj->name = $this->name;
        $obj->password = $this->password;
        $obj->token = (string) $xml->token;
        print_r($obj);
        $this->add($obj);
        }
        
         
    }

    // get token function 
    function get_token() {
        return $this->token;
    }

    function buy() {
        //echo $this->name;
        //$this->get($this->name)->token;
        $fields = array(
            'team' => $this->team,
            'token' => $this->get($this->name)->token,
            'player' => $this->player
        );
        $result = $this->curl->simple_post($this->buy, $fields);

        $xml = simplexml_load_string($result);
        print_r($xml);
        $this->buy_receipt = $xml;
                foreach($xml as $card){
                    echo '<br />';
            echo $card->piece;
            echo ' ';
            echo $card->token;
            
        }
        

    }

    function sell($top='', $mid='', $bot='') {
        //echo $this->name;
        //$this->get($this->name)->token;
        $fields = array(
            'team' => $this->team,
            'token' => $this->get($this->name)->token,
            'player' => $this->player,
            'top' =>  $top,
            'middle' => $mid,
            'bottom' => $bot
        );
        $result = $this->curl->simple_post($this->sell, $fields);

        $xml = simplexml_load_string($result);
        $this->sell_receipt = $xml;

    }
    

}
