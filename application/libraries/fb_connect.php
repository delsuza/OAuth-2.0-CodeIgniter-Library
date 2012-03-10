<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

//Load Fb php sdk
include(APPPATH . 'libraries/facebook/facebook.php');

class Fb_connect {

    //declare private variables
    private $CI;
    private $_api_key = NULL;
    private $_secret_key = NULL;
    //declare public variables
    public $user = NULL;
    public $user_profile = NULL;
    public $fbLoginURL = "";
    public $fbLogoutURL = "";
    public $fb = FALSE;
    public $appkey = 0;

    //constructor method.
    public function fb_connect() {
        
        //Using the CodeIgniter object, rather than creating a copy of it
        $this->CI = & get_instance();

        

        $this->_api_key = $this->CI->config->item('facebook_api_key');
        $this->_secret_key = $this->CI->config->item('facebook_secret_key');

        $this->appkey = $this->_api_key;

        //connect to facebook
        $this->fb = new Facebook(array(
                    'appId' => $this->_api_key,
                    'secret' => $this->_secret_key,
                    'cookie' => true,
                ));
        
        //store the return session from facebook
        
       $this->user = $this->fb->getUser();

        $me = null;
        // If a valid fbSession is returned, try to get the user information contained within.
        if ($this->user) {
            try {
                //get information from the fb object
               
                $this->user_profile = $this->fb->api('/me');

            } catch (FacebookApiException $e) {
                error_log($e);
                $this->user = null;
            }
        }

        // login or logout url will be needed depending on current user state.
        //(if using the javascript api as well, you may not need these.)
        if ($this->user) {
            $this->fbLogoutURL = $this->fb->getLogoutUrl();
        } else {
            $this->fbLoginURL = $this->fb->getLoginUrl();
        }
    }

//end Fb_connect() function
}

// end class