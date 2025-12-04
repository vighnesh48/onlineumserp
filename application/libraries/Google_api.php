<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use Google\Client;
use Google\Service\Calendar;

class Google_api {
    protected $CI;
    protected $credentials_path;

    public function __construct() {
        $this->CI =& get_instance();
        // path to credentials.json
        $this->credentials_path = APPPATH . 'credentials/credentials.json';
        // ensure Composer autoload available
        if (!class_exists('\Google\Client')) {
            // attempt to include Composer autoload
            $autoload = FCPATH . 'vendor/autoload.php';
            if (file_exists($autoload)) {
                require_once $autoload;
            } else {
                show_error('Composer autoload not found. Run composer install.');
            }
        }
    }

    /**
     * Returns configured Google Client (optionally with token loaded from DB).
     * $loadTokenFromDb: if provided with user_email it will load tokens and set them on client.
     */
    public function getClient($loadTokenFromDb = null) {
        $client = new Client();
        $client->setAuthConfig($this->credentials_path);
        $client->setRedirectUri(site_url('google_auth/callback'));
        $client->setAccessType('offline'); // request refresh token
        $client->setPrompt('consent'); // force refresh token for testing; remove if you don't want re-consent
        $client->setScopes([
    Google\Service\Calendar::CALENDAR,
    'https://www.googleapis.com/auth/userinfo.email',
    'https://www.googleapis.com/auth/userinfo.profile'
]);

        if ($loadTokenFromDb) {
            $tokenRow = $this->CI->db->get_where('google_tokens', ['user_email' => $loadTokenFromDb])->row();
            if ($tokenRow) {
                $tokenArr = json_decode($tokenRow->access_token, true);
                if (!$tokenArr) {
                    // older schema store tokens separately; handle both:
                    $tokenArr = [
                        'access_token' => $tokenRow->access_token,
                        'refresh_token' => $tokenRow->refresh_token,
                        'expires_in' => $tokenRow->expires_in
                    ];
                }
                $client->setAccessToken($tokenArr);

                // refresh if expired
                if ($client->isAccessTokenExpired()) {
                    if ($client->getRefreshToken()) {
                        $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
                        // save new token back to DB
                        $newToken = $client->getAccessToken();
                        $this->saveTokenToDb($loadTokenFromDb, $newToken);
                    } else {
                        // no refresh token - tokens invalid; remove DB row or force re-auth
                        // caller should handle redirecting to auth
                    }
                }
            }
        }

        return $client;
    }

    /**
     * Save tokens into DB for given user_email.
     * $token should be array from getAccessToken()
     */
    public function saveTokenToDb($user_email, $token) {
        $exists = $this->CI->db->get_where('google_tokens', ['user_email' => $user_email])->row();
        $payload = [
            'user_email' => $user_email,
            'access_token' => json_encode($token),
            'refresh_token' => isset($token['refresh_token']) ? $token['refresh_token'] : null,
            'expires_in' => isset($token['expires_in']) ? $token['expires_in'] : null,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        if ($exists) {
            $this->CI->db->where('id', $exists->id)->update('google_tokens', $payload);
        } else {
            $payload['created_at'] = date('Y-m-d H:i:s');
            $this->CI->db->insert('google_tokens', $payload);
        }
    }
}
