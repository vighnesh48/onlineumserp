<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('get_hostel_owners')) {
    function get_hostel_owners($hostel_id) {
        $CI =& get_instance();
        $CI->load->database();
        return $CI->db
                  ->where('hostel_id', $hostel_id)
                  ->where('status', 'Y')  // Optional if you're using status column
                  ->get('sf_hostel_owners')
                  ->result_array();
    }
}

