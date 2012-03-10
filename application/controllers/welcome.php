<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Welcome extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -  
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in 
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    public function index() {


        //verification si une session est active
        if ($this->session->userdata('login_user', 'mdp_user', 'id_user', 'statut_user', 'logged', 'ip')) {
            $login_user = $this->session->userdata('login_user');

            $mdp_user = $this->session->userdata('mdp_user');

            $id_user = $this->session->userdata('id_user');

            $statut_user = $this->session->userdata('statut_user');

            $logged = $this->session->userdata('logged');

            $ip_user = $this->session->userdata('ip');

            if ($logged) {

                $data['logged_user'] = true;
            }
        } else {
            //si il n'y a pas de session active on montre le form de connexion



            $this->twitter_connect->isLogged();



            $sess_fb_uid = $this->session->userdata('fb_uid');

            if ($sess_fb_uid != null && $sess_fb_uid == $this->fb_connect->user) {

                $data = array(
                    'logged_fb' => True,
                    'facebook' => $this->fb_connect->fb,
                    'user' => $this->fb_connect->user,
                    'fb_user' => $this->fb_connect->user_profile,
                    'fbLogoutURL' => $this->fb_connect->fbLogoutURL,
                    'fbLoginURL' => $this->fb_connect->fbLoginURL,
                    'base_url_login' => base_url() . 'login/facebook',
                    'base_url_logout' => base_url() . 'login/logout',
                    'appkey' => $this->fb_connect->appkey,
                    'twitter_islogged' => $this->session->userdata('islogged_twitter'),
                    'twitter_user' => $this->twitter_connect->user_profile,
                    'twitter_error' => $this->twitter_connect->error,
                    'logged_user' => false
                );
            } else {

                $data = array(
                    'logged_fb' => false,
                    'facebook' => $this->fb_connect->fb,
                    'user' => null,
                    'fbLogoutURL' => $this->fb_connect->fbLogoutURL,
                    'fbLoginURL' => $this->fb_connect->fbLoginURL,
                    'base_url_login' => base_url() . 'login/facebook',
                    'base_url_logout' => base_url() . 'login/logout',
                    'appkey' => $this->fb_connect->appkey,
                    'twitter_islogged' => $this->session->userdata('islogged_twitter'),
                    'twitter_user' => $this->twitter_connect->user_profile,
                    'twitter_error' => $this->twitter_connect->error,
                    'logged_user' => false
                );
            }
        }
        
        
        $this->load->view('view', $data);
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */