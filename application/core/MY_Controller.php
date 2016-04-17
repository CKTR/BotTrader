<?php

/**
 * core/MY_Controller.php
 *
 * Default application controller
 *
 * @author		Kelly Liu
 * @copyright           2015-2016
 * ------------------------------------------------------------------------
 */
class Application extends CI_Controller {

    protected $data = array();      // parameters for view components
    protected $id;                  // identifier for our content

    /**
     * Constructor.
     * Establish view parameters & load common helpers
     */

    function __construct() {
        parent::__construct();

        // load parser library
        $this->load->library('parser');

        // Create data
        $this->data = array();
        $this->data['title'] = 'BotTrader WebApp';

        // Create error arrays
        $this->errors = array();
        // login and logout function
        $this->login();
    }

    /**
     * Render this page
     */
    function render() {
        // create the menu bar based on if an user is logged in or not
        $this->build_menubar();
        $this->data['content'] = $this->parser->parse($this->data['pagebody'], $this->data, true);

        // finally, build the browser page!
        $this->data['data'] = &$this->data;
        $this->parser->parse('_template', $this->data);
    }

    function login() {
        // Set welcome message to null so nothing will be displayed
        $this->data['welcome_txt'] = NULL;
        // Set login message to null so nothing will be displayed when no one is logged in
        $this->data['login_msg'] = NULL;
        // get the login and action from get/post
        $username = $this->input->get_post('username');
        $action = $this->input->get_post('action');
        $this->data['debug'] = print_r($username, TRUE);

        if ($this->session->userdata('username') && $action === 'logout') {
            // if someone is logged in and wants to logout, remove login session data
            $this->session->unset_userdata('username');
            $this->data['logout_msg'] = 'Logout successful!';
        } else if (!empty($username) && $action === 'login') {
            // if an user is log in, check against users       
            $this->load->model('player');

            // if user exists, log in by adding session data  
            $this->session->set_userdata('username', $username);
            $this->data['login_msg'] = 'Log in successful!';
        }
    }

    
    function register() {
        echo '123';
        // Set registration message to null so nothing will be displayed when no registration
        $this->data['registration_msg'] = NULL;
        // get the registration and action from get/post
        $team = $this->input->get_post('team');
        $name = $this->input->get_post('name');
        $password = $this->input->get_post('password');
        $regaction = $this->input->get_post('regaction');
        $this->data['debug'] = print_r($name, TRUE);

        if ($this->session->userdata('name') && $team === 'A09' && $password === 'tuesday' && $regaction === 'register') {
            // if an agent registers a team with the correct field, register the agent        ,
            $this->data['registration_msg'] = 'Registeration successful, please login to play!';
        } else {
            $this->data['registration_msg'] = 'Registeration failed, please try again.';
        }
    }

    function playerRegistration() {
        // Set registration message to null so nothing will be displayed when no registration
        $this->data['registration_msg'] = NULL;
        // get the registration and action from get/post and add the information to the database        
        $regaction = $this->input->get_post('regaction');
        $obj = $this->create();
        $obj->player = $this->input->get_post('username');
        // temporarily hard coded for testing 
        $obj->peanuts = '200';        

        if ($this->session->userdata('username') && $regaction === 'register') {
            // if someone wants to register as a player with the correct field, register the player   
            $this->add($obj);
            $this->data['registration_msg'] = 'Registeration successful, please login to play!';
        } else {
            $this->data['registration_msg'] = 'Registeration failed, please try again.';
        }
    }

    /**
     * Create the menu bar, including the login and registration box
     */
    function build_menubar() {
        // get the menu bar data from config
        $i = $this->config->item('menu_choices');
        $t = $i['menudata'];
        $this->data['menudata'] = $t;
        $action = $this->input->get_post('action');
        // check if anyone is logged in
        if ($this->session->userdata('username') && $action === 'login') {
            // if so, display logout button
            $this->data['welcome_txt'] = 'Welcome, ' . $this->session->userdata('username');
            $this->data['login_submit_txt'] = 'Logout';
            $this->data['login_btn_appear'] = 'none';
            $this->data['login_action'] = 'logout';
        } else {
            // if no one is logged in, display the login box
            $this->data['welcome_text'] = '';
            $this->data['login_submit_txt'] = 'Login';
            $this->data['login_btn_appear'] = 'initial';
            $this->data['login_action'] = 'login';
        }

        // always display the register button      
        $this->data['register_submit_txt'] = 'Register';
        $this->data['register_action'] = 'register';


        // parse the menu bar
        $this->data['menubar'] = $this->parser->parse('_menubar', $this->data, true); //$this->config->item('menu_choices')
    }

}
