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

    // Constructor

    function __construct() {
        parent::__construct();
        $this->register = 'http://botcards.jlparry.com/register';
    }

    function _register() {
        $_POST['team'] = 'A09';
        $_POST['name'] = 'Kobe';
        $_POST['password'] = 'tuesday';

        $fields = array(
            'team' => urlencode($_POST['team']),
            'name' => urlencode($_POST['name']),
            'password' => urlencode($_POST['password'])
        );

        //url-ify the data for the POST
        foreach ($fields as $key => $value) {
            $fields_string .= $key . '=' . $value . '&';
        }
        rtrim($fields_string, '&');

        //open connection
        $ch = curl_init();

        //set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);

        //execute post
        $this->token = curl_exec($ch);

        //close connection
        curl_close($ch);
    }

    // get token function 
    function get_token() {
        return $this->token;
    }

}
