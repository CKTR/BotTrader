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
    class Game extends Application {

    function __construct() {
        parent::__construct();
    }

    //-------------------------------------------------------------
    //  The normal pages
    //-------------------------------------------------------------

    function index() {
        $this->data['title'] = 'Game Stats';
        $this->data['pagebody'] = 'game';
        
        $dataTable = $this->access->getplayerdatatable();
        $trans = array();
        foreach ($dataTable as $d) {
            $this1 = array(
                'name' => $d->Player,
                'peanut' => $d->Peanuts,
                'equity' => $d->Equity,
            );
            $trans[] = $this1;
            }
        
            //get the list of pieces that have been obtained by each player
        $partlist = $this->access->getknownpiece();
        
        //values to populate game status
        $part11 = $this->access->parts11();
        $part13 = $this->access->parts13();
        $part22 = $this->access->parts22();
        $packs = $this->access->packsold();
            
        
        
        $this->data['playerlist'] = $trans;
        $this->data['parts11'] = $part11;
        $this->data['parts13'] = $part13;
        $this->data['parts22'] = $part22;
        $this->data['packs'] = $packs;
        $this->data['collect'] = $partlist;
        
        
        $this->data['round'] = $this->state->get_round();
        $this->data['state'] = $this->state->get_state();
        $this->data['countdown'] = $this->state->get_countdown();
        $this->data['current'] = $this->state->get_current();
        $this->data['duration'] = $this->state->get_duration();
        $this->data['upcoming'] = $this->state->get_upcoming();
        $this->data['alarm'] = $this->state->get_alarm();
        $this->data['now'] = $this->state->get_now();
        
        $this->data['currparts'] = $this->parser->parse('_partinfo', $this->data, TRUE);
        $this->data['knownpieces'] = $this->parser->parse('_knownpieces', $this->data, TRUE);
        $this->data['equitylist'] = $this->parser->parse('_equitylist', $this->data, TRUE);
        $this->data['currstats']  = $this->parser->parse('_serverstatus', $this->data,TRUE);
//        $this->data['debug'] = print_r($this->state->get_state_data(), TRUE);
        $this->render();
    }

}
