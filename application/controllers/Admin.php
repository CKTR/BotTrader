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
    class Admin extends Application {

    function __construct() {
        parent::__construct();
    }

    //-------------------------------------------------------------
    //  The normal pages
    //-------------------------------------------------------------

    function index() {
        $this->data['title'] = 'Player Administration';
        $this->data['pagebody'] = 'admin';
        echo form_open('admin/edit');
        $players = $this->player->all();

        echo '<table>';

        foreach ($players as $p){
            echo '<tr>';
            echo '<td>';
            echo form_input($p->Player, $p->Player);
            echo '</td>';
            echo '<td>';
            echo form_input($p->Player . '_Peanuts', $p->Peanuts);
            echo '</td>';
            echo '<td>';
            echo form_input($p->Player . '_Type', $p->Type);
            echo '</td>';
                    echo '</tr>';

        }

        echo '</table>';
        echo form_submit('edit', 'Edit');
        $this->render();
    }
    /*
     * The problem I'm running into now is that updating the name will mean
     * wiping out the old player and replacing with the new one, and we won't 
     * be able to track which one is which. There's no good way of doing this 
     * without the foreign keys, but database setup isnt reall the scope of this course
     * so I'll just assume that the db->update function can update foreign keys
     * in cascade
     */
    /*
     * Alternatively, I can manaully create an ID column in our tables,
     * then use count+1 to update whenever a new record has to be inserted.
     * If we do this, we can keep track of which record is which through this.
     * But this will mean that we'll have to use ID to track transactions, which 
     * doesn't work when querying the server. After these considerations, I think
     * I'll just allow user info to be lost after update as building a better solution
     * requires too much effort outside the scope of this course
     */
    function edit(){
        $players = $this->player->all();
        $new_players;
        foreach($players as $p){

            $name = $p->Player;
            $peanuts = $p->Player . '_Peanuts';
            $type = $p->Player . '_Type';
            $obj = $this->player->create();
            $obj->Player = $this->input->post($name);
            $obj->Peanuts = $this->input->post($peanuts);
            $obj->Type = $this->input->post($type);

            $new_players[] = $obj;
            $this->player->delete($name);
        }
        foreach($new_players as $n){
            if(!$n->Player){continue;}
            $this->player->add($n);
        }
       redirect('/admin', 'refresh');
    }

}
