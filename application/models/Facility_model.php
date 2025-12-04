<?php
class Facility_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
        
        $DB1 = $this->load->database('umsdb', TRUE); 
    }
    
   function get_hstudent_list()
   {
       
       $acyear = date('Y');
      $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sm.stud_id,sm.first_name,sm.middle_name,sm.last_name,sm.form_number,sm.admission_year,sm.enrollment_no,stm.stream_name,cm.course_name");
		$DB1->from('student_master as sm');
		$DB1->join('stream_master as stm','sm.admission_stream = stm.stream_id','left');
			$DB1->join('course_master as cm','cm.course_id = stm.course_id','left');
			$DB1->join('admission_details as ad','sm.stud_id = ad.student_id','left');	
		
			$DB1->where("ad.hostel_required",'Y');	    
		
		//	$DB1->where("sm.admission_year", $year);	   	    
	
		$DB1->order_by("sm.stud_id", "asc");
		$query=$DB1->get();
//echo $DB1->last_query();
//		 die();   
	//	echo $DB1->last_query();
		//die();  
		$result=$query->result_array();
		
		  for($i=0;$i<count($result);$i++)
    {
      $result[$i]['fee_paid'] =$this->total_feepaid_typeid($result[$i]['stud_id'],3);
        
    }

return $result;
       
   }
   
   function total_feepaid_typeid($std_id,$type_id)
   {
       $DB1 = $this->load->database('umsdb',TRUE);
       $DB1->select('sum(amount) as fee_paid');
       $DB1->from('fees_details');
       $DB1->where('student_id',$std_id);
       $DB1->where('type_id',$type_id);
       $query = $DB1->get();
       return $query->row_array();
       
   }
   
   
   function load_hostel_students()
   {
       
       
       $check= $this->fetch_student_data($_POST['prn']);
       
       if($check['student_prn']=='')
       {
           
           
           
       if($_POST['org']=="SU" )
       {
            $DB1 = $this->load->database('umsdb',TRUE);
            
          	$DB1->select("sm.stud_id,sm.first_name,sm.middle_name,sm.last_name,sm.form_number,sm.admission_year,sm.enrollment_no,stm.stream_name,cm.course_name");
		$DB1->from('student_master as sm');
		$DB1->join('stream_master as stm','sm.admission_stream = stm.stream_id','left');
			$DB1->join('course_master as cm','cm.course_id = stm.course_id','left');
			$DB1->join('admission_details as ad','sm.stud_id = ad.student_id','left');	
    
       $DB1->where('sm.enrollment_no',$_POST['prn']);
     //  $DB1->where('type_id',$type_id);
       $query = $DB1->get();
    //   echo $DB1->last_query();
     $data= $query->row_array();
            
       }
      // elseif($_POST['org']=="SF")
      else
       {
          $this->db->select("*");
        $this->db->from("sf_student_master sm");
         $this->db->where("enrollment_no",$prn);
         	$this->db->join('sf_program_detail as spd','sm.program_id = spd.sf_program_id','left');
        $result = $this->db->get();
         $data=$result->row_array();
         
         
      
           
           //$DB1 = $this->load->database('umsdb',TRUE); 
       }
       
       if($data['enrollment_no']=='')
       {
           echo "PRN number does not exist";
           exit();
       }
       $data['stat']='N';
       
       }
       else
       {
           
            $this->db->select("sandipun_ums.student_master.*,sandipun_erp.sf_student_facilities.*");

    $this->db->from("sandipun_ums.student_master");

    $this->db->join("sandipun_erp.sf_student_facilities", "sandipun_ums.student_master.enrollment_no = sandipun_erp.sf_student_facilities.student_prn");

    $this->db->where("sandipun_ums.student_master.enrollment_no", "170112038");
  $query = $this->db->get();
        echo $this->db->last_query();
         $data=$query->row_array();
         
           
           
           
             $data['stat']='Y';
       }
      var_dump($data);
   //   return $data;
       
   }
   
   
   
   function fetch_student_data($prn,$facolity_id)
   {
       
       $this->db->select("*");
        $this->db->from("sf_student_facilities");
         $this->db->where("student_prn",$prn);
        $result = $this->db->get();
         $data=$result->row_array();
       return $data;
   }
   

   
   function test()
   {
        $DB1 = $this->load->database('umsdb',TRUE);
            $DB2 = $this->load->database('default',TRUE);
           
            $this->db->select("sandipun_ums.student_master.*,sandipun_erp.sf_student_facilities.*");

    $this->db->from("sandipun_ums.student_master");

    $this->db->join("sandipun_erp.sf_student_facilities", "sandipun_ums.student_master.enrollment_no = sandipun_erp.sf_student_facilities.student_prn");

    $this->db->where("sandipun_ums.student_master.enrollment_no", "170112038");

    //$this->db->order_by('database2.tablename.id', 'DESC');

    $query = $this->db->get();
        echo $this->db->last_query();
        //   $result = $this->db->get();
         $data=$query->row_array();
         var_dump($data);
         
   }
    
}

?>