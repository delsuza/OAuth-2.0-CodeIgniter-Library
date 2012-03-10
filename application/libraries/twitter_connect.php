<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

//Load Twitter php sdk
include(APPPATH . 'libraries/twitter/twitteroauth.php');

class Twitter_connect {

    //declare private variables

    private $_api_key = NULL;
    private $_secret_key = NULL;
    private $_callback_url = NULL;
    //declare public variables
    public $user = NULL;
    public $user_profile = NULL;
    public $tw = FALSE;
    public $appkey = 0;
    public $token = null;
    public $error = null;
    public $islogged = false;
    protected $CI;



    public function twitter_co() {
        //Using the CodeIgniter object, rather than creating a copy of it
        $this->CI = & get_instance();

        $this->_api_key = $this->CI->config->item('consumer_key');
        $this->_secret_key = $this->CI->config->item('consumer_secret');
        $this->_callback_url = site_url();

        $this->CI->load->library('session');
        $this->CI->load->helper('url');

        //instanciation de l'objet twitter
        $this->tw = new TwitterOAuth($this->_api_key, $this->_secret_key);

        /* On demande les tokens à Twitter, et on passe l'URL de callback */
        $request_token = $this->tw->getRequestToken($this->_callback_url);

        /* On sauvegarde le tout en session */
        $this->token = $request_token['oauth_token'];

        $arr_token = array(
            'oauth_token' => $this->token,
            'oauth_token_secret' => $request_token['oauth_token_secret']
        );
        $this->CI->session->set_userdata($arr_token);


        /* On test le code de retour HTTP pour voir si la requête précédente a correctement fonctionné */

        switch ($this->tw->http_code) {

            case 200:

                /* On construit l'URL de callback avec les tokens en params GET */

                $url = $this->tw->getAuthorizeURL($this->token);



                redirect($url);

                break;

            default:

                $this->error = 'Impossible de se connecter à twitter ... Merci de renouveler votre demande plus tard.';

                break;
        }
    }

    public function isLogged() {
        //Using the CodeIgniter object, rather than creating a copy of it
        $this->CI = & get_instance();

        $this->CI->load->library('session');
        $this->CI->load->library('input');
        $this->CI->load->helper('url');

        $oauth_token = $this->CI->session->userdata('oauth_token');
        $oauth_token_secret = $this->CI->session->userdata('oauth_token_secret');

        if (!empty($_SESSION['access_token']) && !empty($_SESSION['access_token']['oauth_token']) && !empty($_SESSION['access_token']['oauth_token_secret'])) {
            // On a les tokens d'accès, l'authentification est OK.

            $access_token = $_SESSION['access_token'];


            /* On créé la connexion avec twitter en donnant les tokens d'accès en paramètres. */
            $this->tw = new TwitterOAuth($this->_api_key, $this->_secret_key, $access_token['oauth_token'], $access_token['oauth_token_secret']);

            /* On récupère les informations sur le compte twitter du visiteur */
            $this->user_profile = $this->tw->get('account/verify_credentials');
            $this->islogged = true;
            $data_arr = array("islogged_twitter" => true);
            $this->CI->session->set_userdata($data_arr);
            
        } elseif ($this->CI->input->get('oauth_token') && $oauth_token === $this->CI->input->get('oauth_token')) {
            // Les tokens d'accès ne sont pas encore stockés, il faut vérifier l'authentification

            /* On créé la connexion avec twitter en donnant les tokens d'accès en paramètres. */
            $this->tw = new TwitterOAuth($this->_api_key, $this->_secret_key, $oauth_token, $oauth_token_secret);

            /* On vérifie les tokens et récupère le token d'accès */

            $access_token = $this->tw->getAccessToken($this->CI->input->get('oauth_verifier', TRUE));

            /* On stocke en session les token d'accès et on supprime ceux qui ne sont plus utiles. */
            $_SESSION['access_token'] = $access_token;
            unset($_SESSION['oauth_token']);
            unset($_SESSION['oauth_token_secret']);

            if (200 == $this->tw->http_code) {
                $this->user_profile = $this->tw->get('account/verify_credentials');
                $this->islogged = true;
                $data_arr = array("islogged_twitter" => true);
                $this->CI->session->set_userdata($data_arr);
            } else {
                $this->islogged = false;
                $data_arr = array("islogged_twitter" => false);
                $this->CI->session->set_userdata($data_arr);
            }
        } else {
            $this->islogged = false;
            $data_arr = array("islogged_twitter" => false);
            $this->CI->session->set_userdata($data_arr);
        }
    }

}

?>
