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

        
    $this->register->_register();

       $this->register->buy();
        //$this->register->sell('115d6', '14cf9', '12293');
        
        
              $this->render();
        
        
    }


}
