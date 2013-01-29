<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class UserAuthorization {
	
	private $session;
	
    public function __construct($params)
    {
    	$this->session = $params["session_object"];
    }
    
    /* Return true if user is logged in. False, otherwise. */
    public function isUserLoggedIn(){
    	return $this->session->userdata('is_logged_in');
    }
    
    /* Return true if user is Admin. False, otherwise. */
    public function isUserAdmin(){
    	return $this->session->userdata('is_user_admin');
    }
    
    /* Return true if user is Moderator. False, otherwise. */
    public function isUserModerator(){
    	return null;
    }

    public function isUserActive(){
    	return $this->session->userdata('active');
    }
    
    public function getUserId(){
    	return $this->session->userdata('uid');
    }

    public function getUserName(){
    	return $this->session->userdata('usr');
    }

    public function getFirstName(){
    	return $this->session->userdata('firstname');
    }

    public function getLastName(){
    	return $this->session->userdata('lastname');
    }

    public function getEmail(){
    	return $this->session->userdata('email');
    }
}

/* End of file Someclass.php */