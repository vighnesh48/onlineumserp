<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('encrypt_id')) {
    function encrypt_id($id) {
        $CI =& get_instance();
        $encrypted = $CI->encryption->encrypt($id);
        return rtrim(strtr(base64_encode($encrypted), '+/', '-_'), '='); // URL safe
    }
}

if (!function_exists('decrypt_id')) {
    function decrypt_id($encoded_id) {
        $CI =& get_instance();
        $decoded = base64_decode(strtr($encoded_id, '-_', '+/'));
        return $CI->encryption->decrypt($decoded);
    }
}

