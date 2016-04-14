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
class State extends CI_Model {

    protected $state;
    protected $round;
    protected $gamestate;
    protected $desc;
    protected $countdown;
    protected $current;
    protected $duration;
    protected $upcoming;
    protected $alarm;
    protected $now;
    

    // Constructor

    function __construct() {
        parent::__construct();
        $this->state = 'http://botcards.jlparry.com/status';
        $this->state_data = $this->get_data($this->state);
        $this->round = (string) $this->state_data->round;
    $this->gamestate= (string) $this->state_data->state ;
    $this->desc = (string) $this->state_data->desc;
    $this->countdown = (string) $this->state_data->countdown;
    $this->current = (string) $this->state_data->current;
    $this->duration = (string) $this->state_data->duration;
    $this->upcoming = (string) $this->state_data->upcoming;
    $this->alarm = (string) $this->state_data->alarm;
    $this->now= (string) $this->state_data->now;

    }
   



function get_data($url) {
    $file = file_get_contents($url);
    $xml = simplexml_load_string($file);
    return $xml;
}

function get_round() {
    return $this->round;
}

function get_state() {
    return $this->gamestate;
}

function get_desc() {
    return $this->desc;
}

function get_countdown() {
    return $this->countdown;
}

function get_current() {
    return $this->current;
}
function get_duration() {
    return $this->duration;
}
function get_upcoming() {
    return $this->upcoming;
}
function get_alarm() {
    return $this->alarm;
}
function get_now() {
    return $this->now;
}
}

$autoload['model'] = array('state');


