<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Google_auth extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('Google_api');
        $this->load->helper('url');
        $this->load->database();
    }

    // Redirect user to Google for authorization
    public function login() {
        // optionally, who is signing in (the google account email you'll use to create events)
        $this->session->set_userdata('google_auth_email', ''); // optional: use input or set dynamically

        $client = $this->google_api->getClient();
        $authUrl = $client->createAuthUrl();
        redirect($authUrl);
    }

    // Google will redirect back here
    public function callback() {
        $client = $this->google_api->getClient();
        if ($this->input->get('code')) {
            $code = $this->input->get('code');
            $token = $client->fetchAccessTokenWithAuthCode($code);

            if (array_key_exists('error', $token)) {
                show_error('Google token error: ' . json_encode($token));
            }

            // get userinfo (email) to tie tokens to an email
            $oauth2 = new \Google\Service\Oauth2($client);
            $userinfo = $oauth2->userinfo->get();
            $email = $userinfo->email;

            // Save tokens to DB via library
            $this->google_api->saveTokenToDb($email, $token);

            // Optionally set a flag in session that integration is ready
            $this->session->set_flashdata('message', 'Google connected for ' . $email);

            // Redirect to admin page or wherever
            redirect('live_session/admin_list');
        } else {
            show_error('No code parameter returned from Google.');
        }
    }
}
