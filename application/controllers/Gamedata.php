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
        //$this->data['info'] = print_r($this->test->get_all_bot_names());
        //print_r($this->test->get_bot_by_code('11'));
        //echo $this->test->get_bot_value('11');
        //print_r($this->test->get_certificates_data());
        //print_r($this->test->get_transactions_data());
        print_r($this->test->get_player_recent_trans('billy', 3));
        //print_r($this->test->get_series_data());
        //echo $this->state->get_round();
        //echo $this->state->get_round();

              $this->render();
        
        
    }


}
