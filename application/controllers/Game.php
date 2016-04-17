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


        //old data
        $this->data['playerlist'] = $trans;
        $this->data['parts11'] = $part11;
        $this->data['parts13'] = $part13;
        $this->data['parts22'] = $part22;
        $this->data['packs'] = $packs;
        $this->data['collect'] = $partlist;

        //game stats
        $this->data['round'] = $this->state->get_round();
        $this->data['state'] = $this->state->get_state();
        $this->data['countdown'] = $this->state->get_countdown();
        $this->data['current'] = $this->state->get_current();
        $this->data['duration'] = $this->state->get_duration();
        $this->data['upcoming'] = $this->state->get_upcoming();
        $this->data['alarm'] = $this->state->get_alarm();
        $this->data['now'] = $this->state->get_now();
        
        $this->data['opened'] = $this->info->get_pack_opened();
        $this->data['sold'] = $this->info->get_pack_sold();
        
        //current player status, which includes player name, equity, and transaction log
        if (is_null($this->info->get_player_trans("hahaha"))) {
            $this->data['currplayer'] = "We do not have a current player";
        } else {
            $playerstat = $this->info->get_player_trans("hahaha");
            $details = array();
            foreach ($playerstat as $d) {
                $this1 = array(
                    'time' => $d['datetime'],
                    'series' => $d['series'],
                    'trans' => $d['trans']
                );
                $details[] = $this1;
            }
            //name and equity for current player
            $this->data['playername'] = $playerstat[0]['player'];
            $this->data['playerequity'] = $this->info->get_player_equity("hahaha");
            
            //generate view
            $this->data['brief'] = $details;
            $this->data['currplayer'] = $this->parser->parse('_singleplayer', $this->data, TRUE);
        }
        
        //lists the series data and current trade stats
        $seriesinfo = $this->info->get_series_data();
        $si = array();
        foreach($seriesinfo as $d){
            $this1 = array(
                'type' => $d['code'],
                'soldbot' =>$this->info->count_bot_sold($d['code']),
                'price' =>$d['value']
            );
            $si[]=$this1;
        }
        $this->data['bott'] = $si;
        
        //list all player data
        $this->data['listplayer'] = "Currently there is no player enlisted";
        
        //old views
        
        $this->data['knownpieces'] = $this->parser->parse('_knownpieces', $this->data, TRUE);
        $this->data['equitylist'] = $this->parser->parse('_equitylist', $this->data, TRUE);
        
        //new views
        $this->data['currstats'] = $this->parser->parse('_serverstatus', $this->data, TRUE);
        $this->data['currparts'] = $this->parser->parse('_partinfo', $this->data, TRUE);
//       $this->data['debug'] = print_r();
        $this->render();
    }

}
