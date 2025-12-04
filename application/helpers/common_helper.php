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
function getCurrentAcademicYear()
{
	$CI = & get_instance();
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
}


function getallAcademicYear()
{
	$CI = & get_instance();
 	$DB1 = $CI->load->database('umsdb', TRUE);
	$DB1->select('academic_year,session');
	$DB1->where('currently_active', 'Y');
	$DB1->from('academic_year');
	$DB1->order_by("id","DESC");
	
	$academicYear = $DB1->get()->result_array();
 	//$academicYear = $query->row_array();
 	//$academicYear = $academicYear['session'];

 	return $academicYear;
}


/**
 * Current and Successive Academic Year
 * @param		$int
 * @return      int 		
 * @author		Mahesh Verma
 * @link		
 */
function currentSuccessiveYear($year)
{
    $successiveYear = $year+1;
    $successiveYear = substr($successiveYear, -2);
    $currentSuccessiveYear = $year.'-'.$successiveYear;

    return $currentSuccessiveYear;
}

/**
 * Get All School Ids
 * @param		
 * @return      array 		
 * @author		Mahesh Verma
 * @link		
 */
function getAllSchoolIds()
{
	$CI = & get_instance();
 	$DB1 = $CI->load->database('umsdb', TRUE);
	$DB1->select('school_id');
	$DB1->where('is_active', 'Y');
	$DB1->from('school_master');
	$query = $DB1->get();
 	$schoolIds = $query->result_array();

	return $schoolIds;
}

/**
 * Get All School Names and Related Field Values
 * @param		
 * @return      array 		
 * @author		Mahesh Verma
 * @link		
 */
function getAllSchoolNames()
{
	$CI = & get_instance();
 	$DB1 = $CI->load->database('umsdb', TRUE);
	$DB1->select('school_id,school_code,school_code1,school_name,school_short_name');
	$DB1->where('is_active', 'Y');
	$DB1->from('school_master');
	$query = $DB1->get();
 	$schoolNames = $query->result_array();

 	return $schoolNames;
}

/**
 * Count Of Current Year Admissions School Wise
 * @param		$currentAcademicYear
 * @return      array 		
 * @author		Mahesh Verma
 * @link		
 */
function getAdmissionCountCurrentYear($currentAcademicYear)
{
	$CI = & get_instance();
 	$DB1 = $CI->load->database('umsdb', TRUE);

	$sql = "SELECT sm.school_short_name,
			count(stm.stud_id) as admissionCount, sm.school_id, sm.is_active
			FROM school_master as sm
			LEFT JOIN student_master as stm ON sm.school_id = stm.admission_school
			AND stm.cancelled_admission = 'N'
			AND stm.admission_session = '".$currentAcademicYear."'
			AND stm.academic_year = '".$currentAcademicYear."' 
			AND stm.admission_confirm = 'Y'
			WHERE sm.is_active = 'Y'
			GROUP BY sm.school_id";

	$query = $DB1->query($sql);
    $admissionCountSchoolWise = $query->result_array();
 	return $admissionCountSchoolWise;
}

/**
 * Merge Arrays Recursively with Same Keys
 * @param		$array1, $array2
 * @return      array 		
 * @author		Mahesh Verma
 * @link		
 */
function array_merge_recursive_ex(array $array1, array $array2)
{
    $merged = $array1;

    foreach ($array2 as $key => & $value) {
        if (is_array($value) && isset($merged[$key]) && is_array($merged[$key])) {
            $merged[$key] = array_merge_recursive_ex($merged[$key], $value);
        } else if (is_numeric($key)) {
             if (!in_array($value, $merged)) {
                $merged[] = $value;
             }
        } else {
            $merged[$key] = $value;
        }
    }

    return $merged;
}

/**
 * Color Array For Respective Schools
 * @param		
 * @return      array 		
 * @author		Mahesh Verma
 * @link		
 */
function getColorForSchool($schoolName)
{
	$schoolColor =  [
	                	"SOET" => "icon-big icon-primary text-center",
	                	"SOM" => "icon-big icon-red text-center",
	                	"SOL" => "icon-big icon-warning text-center",
	                	"SOCSE" => "icon-big icon-gray text-center",
	                	"SOS" => "icon-big icon-green text-center",
	                	"SOSS" => "icon-big icon-aqua text-center",
	                	"SOMS" => "icon-big icon-warning text-center",
	                	"SOFD" => "icon-big icon-pink text-center",
	                	"SOPS" => "icon-big icon-success text-center",
	                	"SOD" => "icon-big icon-purple text-center",
	                	"SOCE" => "icon-big icon-warning text-center",
	                	"SOID" => "icon-big icon-aqua text-center"
		            ];

	$color = "icon-big icon-gray text-center";
	if (array_key_exists($schoolName,$schoolColor)) {
	  	$color = $schoolColor[$schoolName];
	}

 	return $color;
}

/**
 * Get Academic Years From 2016
 * @param		
 * @return      int
 * @author		Mahesh Verma
 * @link		
 */
function getStartSuccessiveAcademicYear()
{
	$startYear = 2016;
	$currentYear = date('Y');
	$diffYear = $currentYear - $startYear;

	for($i = 0; $i <= $diffYear; $i++) {
		$successiveYear[] = currentSuccessiveYear($startYear);
		$startYear++;
	}

	return $successiveYear;
}

/**
 * Dump & Die 
 * @param		$field
 * @return      array 		
 * @author		Mahesh Verma
 * @link		
 */
function DD($field)
{
	echo "<pre>";
	print_r($field);
	die;
}
function fetch_exam_session_for_marks_entry()
{
	$CI = & get_instance();
 	$DB1 = $CI->load->database('umsdb', TRUE);
	$DB1->select("exam_month,exam_year,exam_id,exam_type");
	$DB1->from('exam_session');
	$DB1->where("active_for_marks_entry", 'Y');
	$query=$DB1->get();
	$result=$query->result_array();
		//echo $DB1->last_query();
	return $result;
}
function fetch_exam_session_for_result()
{
	$CI = & get_instance();
 	$DB1 = $CI->load->database('umsdb', TRUE);
	$DB1->select("exam_month,exam_year,exam_id,exam_type");
	$DB1->from('exam_session');
	$DB1->where("active_for_result", 'Y');
	$query=$DB1->get();
	$result=$query->result_array();
		//echo $DB1->last_query();
	return $result;
}

function fetch_active_year()
{
        $CI = & get_instance();
         $DB1 = $CI->load->database('umsdb', TRUE);
        $DB1->select("academic_year,session");
        $DB1->from('academic_year');
        $DB1->where("currently_active", 'Y');
        $query=$DB1->get();
        $result=$query->result_array();
        return $result;
}
if ( ! function_exists('numberToRoman'))
{
 function numberToRoman($num)  
	{ 
		// Be sure to convert the given parameter into an integer
		$n = intval($num);
		$result = ''; 
	 
		// Declare a lookup array that we will use to traverse the number: 
		$lookup = array(
			'M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 
			'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 
			'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1
		); 
	 
		foreach ($lookup as $roman => $value)  
		{
			// Look for number of matches
			$matches = intval($n / $value); 
	 
			// Concatenate characters
			$result .= str_repeat($roman, $matches); 
	 
			// Substract that from the number 
			$n = $n % $value; 
		} 

		return $result; 
	}
}