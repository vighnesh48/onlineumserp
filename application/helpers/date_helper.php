<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Common Helper
 * @author		Mahesh Verma
 */

/**
 * Get Current Academic Year For School Admission
 * @param		
 * @return      int
 * @author		Mahesh Verma
 * @link		
 */
function test()
{
	echo "hello";die;
	/*$CI = & get_instance();
 	$DB1 = $CI->load->database('umsdb', TRUE);
	$DB1->select('session');
	$DB1->where('currently_active', 'Y');
	$DB1->from('academic_year');
	$DB1->order_by("id","DESC");
	$DB1->limit(1);
	$query = $DB1->get();
 	$academicYear = $query->row_array();
 	$academicYear = $academicYear['session'];

 	return $academicYear;
*/}