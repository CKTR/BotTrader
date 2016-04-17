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

    // loop to test the ability to buy & sell cards and populate data    
    $this->register->_register();

        //$this->register->sell('115d6', '14cf9', '12293');
        for($i=0; $i < 5;$i++ ){
            $this->register->buy();
        }
        
              $this->render();
        
        
    }


}
