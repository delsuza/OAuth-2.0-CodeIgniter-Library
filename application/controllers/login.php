<?php

class Login extends CI_Controller {

    public function Login() {
        parent::__construct();
    }

   public function index() {
        redirect("welcome");

        
    }

    // function logout()
    //This won't destroy your facebook session
    public function logout() {
        $this->session->sess_destroy();
        $data['logged'] = false;
        $this->session->set_userdata($data);
        $this->index();
    }



    public function facebook_validate($uid) {
        //this query basically sees if the users facebook user id is associated with a user.
        $session_uid = $this->fb_connect->user;
        
        //$bQry = $this->your_model->validate_user_facebook($uid,$session_uid);
        
        if ($bQry) { // if the user's credentials validated...
            $data = array(
                'fb_uid' => $uid,
                'is_logged_in' => true,
                'list_type' => 'hot'
            );
            
            $this->session->set_userdata($data);

            $this->index();
            
        } else {
            $this->session->sess_destroy();
            // incorrect username or password
            $data = array();
            $data["login_failed"] = TRUE;
            $this->session->set_userdata($data);
            $this->index();
        }
    }

    public function facebook() {
        //1. Check to see if the facebook session has been declared

        if (!$this->fb_connect->user) {
            //2. If No, bounce back to login
            $this->index();
            
        } else {

            
            $fb_usr = $this->fb_connect->user;
            $fb_usr_profile = $this->fb_connect->user_profile;
            
            
            if ($fb_usr != null) {
              
                //3. If yes, see if the facebook id is associated with any existing account
                //$usr = $this->Users_model->get_user_by_fb_uid($fb_usr);
              
                if (is_array($usr) && count($usr) == 1) {
                    $usr = $usr[0]; //the model returns an object array, so get the first elemet of it which contains all of the data we need.
                    //3.a. if yes, log the person in
                    //echo "Logging in via facebook...";
                    
                    $this->facebook_validate($usr->fb_uid);
                } else {
                    //3.b. if no, register the new user.
                    //echo "Creating a new account...";
                    $name_s = $fb_usr_profile["first_name"];
                    $firstname_s = $fb_usr_profile["last_name"];
                    $fullname = $fb_usr_profile["name"];
                    $password_n = ''; //left blank so user can modify this later
                    $mail_s = $fb_usr_profile["email"];

                    
                    
                    //data ready, try to create the new user 
                    // $req = $this->your_model->create_user($params);
                    //
                    
                    
                    if ($query) {
                        $data['account_created'] = true;
                        //log user in
                     
                        $this->facebook_validate($fb_usr);
                    } else {
                        //Did not work, go back to login page
                        $this->index();
                    }
                }
            }
        }
    }
    
    public function twitter(){
        
        
        $this->twitter_connect->twitter_co();
    }

    public function validate_user(){

        if (isset($_POST['user_co'])) {
           
            $this->form_validation->set_rules('pseudo', 'Pseudo', 'trim|required|xss_clean');
            $this->form_validation->set_rules('pwd', 'Mot de passe', 'trim|required|xss_clean');
                
            if ($this->form_validation->run()) {
                
                $ip = $this->input->ip_address();
                $pseudo = $this->input->post('pseudo');
                $pwd = $this->input->post('pwd');
               
                //Your Auth normal connection

             
            }
        }
    }

}