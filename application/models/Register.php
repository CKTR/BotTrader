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
    protected $token;
    protected $buy_receipt;
    protected $team;
    protected $name;
    protected $password;
    protected $player;

    // Constructor

    function __construct() {
        parent::__construct();
        $this->register = 'http://botcards.jlparry.com/register';
        $this->team = 'A09';
        $this->name = 'Kobe';
        $this->password = 'tuesday';
        $this->player = 'hahaha';
    }

    function _register() {
        $_POST['team'] = $this->team;
        $_POST['name'] = $this->name;
        $_POST['password'] = $this->password;

        $fields = array(
            'team' => urlencode($_POST['team']),
            'name' => urlencode($_POST['name']),
            'password' => urlencode($_POST['password'])
        );
        $results = $this->send($fields);
        $this->token = (string) $results->token;
        
    }

    // get token function 
    function get_token() {
        return $this->token;
    }
    function buy(){
         $_POST['team'] = $this->team;
        $_POST['token'] = $this->token;
        $_POST['player'] = $this->player;
        $fields = array(
            'team' => urlencode($_POST['team']),
            'token' => urlencode($_POST['name']),
            'player' => urlencode($_POST['player'])
        );
        $results = $this->send($fields);
        echo $results;
    }
    
    function send($fields){
        $fields_string='';
//url-ify the data for the POST
        foreach ($fields as $key => $value) {
            $fields_string .= $key . '=' . $value . '&';
        }
        rtrim($fields_string, '&');

        //open connection
        $ch = curl_init();

        //set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $this->register);
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);

        //execute post
        $result = curl_exec($ch);

        //close connection
        curl_close($ch);
        return $result;
    }

}
