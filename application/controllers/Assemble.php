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
class Assemble extends Application {

    function __construct() {
        parent::__construct();
    }

    //-------------------------------------------------------------
    //  The normal pages
    //-------------------------------------------------------------

    function index() {
        $this->data['title'] = 'Assembly';
        $this->data['pagebody'] = 'assemble';

        //--------------Init------------------------------------
        if($this->session->userdata('username')){$playerName = $this->session->userdata('username');
                $this->render_page($playerName);
        }else
        {
            echo "Please Log In";
        }//If not specified use logged in usesr
        //------------------------------------------------------
        
    }
    function render_page($playerName){
        
       $toppiece = $this->access->gettop($playerName);
        $midpiece = $this->access->getmid($playerName);
        $botpiece = $this->access->getbot($playerName);
//        $this->data['debug'] = print_r($toppiece, TRUE);
        // and pass these on to the view
        $this->data['tops'] = $toppiece;
        $this->data['mids'] = $midpiece;
        $this->data['bots'] = $botpiece;
               $this->data['toplist'] = $this->parser->parse('_toplist', $this->data, TRUE);
        $this->data['midlist'] = $this->parser->parse('_midlist', $this->data, TRUE);
        $this->data['botlist'] = $this->parser->parse('_botlist', $this->data, TRUE);
        if ($this->input->post('toppart')) {
            $this->data['top_1'] = $this->input->post('toppart');
            $this->session->set_userdata(array('top_1' => $this->input->post('toppart')));
        } elseif ($this->session->userdata('top_1')) {
            $this->data['top_1'] = $this->session->userdata('top_1');
        }
        if ($this->input->post('midpart')
        ) {
            $this->data['middle'] = $this->input->post('midpart');
            $this->session->set_userdata(array('middle' => $this->input->post('midpart')));
        } elseif ($this->session->userdata('middle')) {
            $this->data['middle'] = $this->session->userdata('middle');
        }
        if ($this->input->post('botpart')) {
            $this->data['bottom'] = $this->input->post('botpart');
            $this->session->set_userdata(array('bottom' => $this->input->post('botpart')));
        }elseif ($this->session->userdata('bottom')) {
            $this->data['bottom'] = $this->session->userdata('bottom');
        }
 
        $this->data['assembleparts'] = $this->parser->parse('_assembleparts', $this->data, TRUE);
        //------------------------------------------------------

              $this->render();

    }

}
