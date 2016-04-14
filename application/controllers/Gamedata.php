<?php

/**
 * Our homepage.
 * 
 * Present a summary of the completed orders.
 * 
 * controllers/welcome.php
 *
 * ------------------------------------------------------------------------
 */
class Gamedata extends Application {

    function __construct() {
        parent::__construct();
    }

    //-------------------------------------------------------------
    //  The normal pages
    //-------------------------------------------------------------

    function index() {
        $this->data['title'] = 'GameData';
        $this->data['pagebody'] = 'gamedata';
        $this->data['info'] = print_r($this->test->get_series_data());

              $this->render();
        
        
    }


}
