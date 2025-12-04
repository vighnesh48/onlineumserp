<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('getStudentYear'))
{
	function getStudentYear($studentId)
	{
		$CI =& get_instance();
	    // You may need to load the model if it hasn't been pre-loaded
	    $CI->load->model('Ums_admission_model');
	    $data = $CI->Ums_admission_model->get_student_year($studentId);
	    return $data;
	}


}

if (!function_exists('clean'))
{
	function clean($string) {
       $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

       return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }
}


if (!function_exists('remove_dot_filename'))
{
	function remove_dot_filename($filename) {
        $lastDot = strrpos($filename, ".");
		$string = str_replace(".", "", substr($filename, 0, $lastDot)) . substr($filename, $lastDot);
		return $string;
    }
}
 if (!function_exists('fetch_searching_data'))
{
     function fetch_searching_data()
	{
		$CI = & get_instance();
		$DB1 = $CI->load->database('s_erp', TRUE);
		$DB1->select('*');
		$DB1->from('menu_master');
		$DB1->where('status','Y');
		$DB1->order_by("menu_name","ASC");
		$query = $DB1->get();
		return $query->result_array();
	}
}