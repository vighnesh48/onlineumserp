<?php

class Prospectus_fee_details_model extends CI_Model 

{

    function __construct()

    {

        parent::__construct();
        $db2=$this->load->database('icdb', TRUE);
         

    }

    
    //vikas fetech course from the different database table
    function  get_course_details($course_id='')
    {
      $db2 = $this->load->database('icdb', TRUE);
        $where = '(status="Yes")';
      
      $db2->select('course_id,course');
     $db2->from('school_course');
        /*if($course_id=='R')
        {
           $DB2->where('sp_status','Y'); 
        }*/
        /*else
        {*/
            $db2->where($where);
        /*}*/
         
        $query = $db2->get();
     //   echo $db2->last_query($query);
        return $query->result_array();  
    } 

    function get_mobilestudent_details($mobile){
      $db2 = $this->load->database('icdb', TRUE);
         $sql = "SELECT * FROM student_meet_details 
       WHERE  mobile1= '".$mobile."' ";
         $query = $db2->query($sql);
     // echo $db2->last_query();
        $res = $query->result_array();
        return $res;
    }
    //vikas insert propectus record
    public function insert_prospectusform($data,$picfile)
    {
		//print_r($data);
		//exit;
		$db2 = $this->load->database('icdb', TRUE);
		
		  $db2->trans_start();
       $mob =$this->get_mobilestudent_details($data['mobile']);
        $cnt_mob = count($mob);  
      if($cnt_mob > 0 )
      {
        //update student details in student_meet_details
        
        $update_array['updated_by']=($this->session->userdata("uid"));
        $update_array['updated_date']=date("Y-m-d H:i:s");
        $update_array['course_interested']=(stripcslashes($data['coursen']));
        $update_array['programme_id']=(stripcslashes($data['coursen']));
        $update_array['email']=(stripcslashes($data['email']));
        $update_array['admission_form_taken']='Y';
        $update_array['academic_year']=ACADEMIC_YEAR;
        $db2->where('id',$mob[0]['id']);
        $db2->where('mobile1',$mob[0]['mobile1']);
        $db2->update('student_meet_details',$update_array);

      }
      else
      {


            $insert_array['student_name']=(stripcslashes($data['sname']));
            $insert_array['course_interested']=(stripcslashes($data['coursen']));
            $update_array['programme_id']=(stripcslashes($data['coursen']));
            $insert_array['mobile1']=(stripcslashes($data['mobile']));
            $insert_array['email']=(stripcslashes($data['email']));
            $insert_array['admission_form_taken']='Y';
            $insert_array['academic_year']=ACADEMIC_YEAR;
            $insert_array['ic_code']='SU_MH_002';
			$insert_array['event_code']="EV/ADM-19";
            $insert_array['created_by']=$this->session->userdata("uid");
            $insert_array['created_date']=date("Y-m-d H:i:s");
            $db2->insert('student_meet_details', $insert_array);
            $insert_id = $db2->insert_id();

            

      }
	  
	  
      $course_type=(stripcslashes($data['course_type']));

     if($course_type=='R')
      { 
          
        $insert_array_prov['adm_form_no']=(stripcslashes($data['formno']));
        
      }
      else
      {
         $insert_array_prov['adm_form_no']=(stripcslashes($data['formno']));
         
      }
       
       if($insert_id)
       {
          $insert_array_prov['adm_id']=$insert_id;
       }
       else
       {
          $insert_array_prov['adm_id']=(stripcslashes($mob[0]['id']));
       }
       
         $insert_array_prov['admission_mode']=(stripcslashes($data['course_type']));
         $insert_array_prov['program_id']=(stripcslashes($data['coursen']));
         $insert_array_prov['admission_form_fees']=(stripcslashes($data['amount']));
         $insert_array_prov['year']=date("Y");
         $insert_array_prov['account_id']=$this->session->userdata("uid");
         $insert_array_prov['inserted_on']=date("Y-m-d H:i:s");
         $insert_array_prov['inserted_ip']=$this->input->ip_address();
         $insert_array_prov['admission_type']='FORM';
         $db2->insert('provisional_admission_details', $insert_array_prov);
         $insert_idd = $db2->insert_id();
/////////////////////////////////////////////////////////////////////////////////////////////////////////

            $insert_array_prov_fees_details['type_id']='1';
             if($insert_id)
            {
              $insert_array_prov_fees_details['student_id']=$insert_id;
            }
            else
            {
              $insert_array_prov_fees_details['student_id']=(stripcslashes($mob[0]['id']));
            }
            $insert_array_prov_fees_details['fees_paid_type']=(stripcslashes($data['paymentmode']));
            $insert_array_prov_fees_details['amount']=(stripcslashes($data['amount']));
            $insert_array_prov_fees_details['fees_date']=date("Y-m-d");
            $insert_array_prov_fees_details['academic_year']=date("Y");
            $insert_array_prov_fees_details['entry_from_ip']=$this->input->ip_address();

            $insert_array_prov_fees_details['account_id']=$this->session->userdata("uid");
            $insert_array_prov_fees_details['created_on']=date("Y-m-d H:i:s");
           
            $paymentmode=(stripcslashes($data['paymentmode']));
            if($paymentmode=="CHQ")
            {
               $insert_array_prov_fees_details['receipt_no']=(stripcslashes($data['check']));
              
            }
            else 
            {
               $insert_array_prov_fees_details['receipt_file']=(stripcslashes($picfile));
            }
			
              $db2->insert('provisional_fees_details', $insert_array_prov_fees_details);
              $insert_iddd = $db2->insert_id();
			  ///////////////////////////////////////////////////////////////////////////////////////////////////////
                 
				 if($data['counsellorid']!=""){
					 $courseid=$data['coursen'];
					// $sql="SELECT * From school_course WHERE course_id='".$data['coursen']."'";
					$schoolquery="SELECT * FROM school_course WHERE course_id='$courseid'";
					// $query= $db2->get();
					$query=$db2->query($schoolquery);
                     $result= $query->result_array();
					 
					// print_r($data);
					$cp['counsellor_id']=$data['counsellorid'];
					$cp['sname'] =$data['sname'];
					$cp['course_type'] =$data['course_type'];
					$cp['coursen'] =$data['coursen'];
					$cp['coursenname'] =$result[0]['course'];
					$cp['email'] =$data['email'];
					$cp['mobile']=$data['mobile'];
				    $cp['amount']=$data['amount'];
					$cp['formno'] =$data['formno'];
					$cp['paymentmode'] =$data['paymentmode'];
					$cp['ado_status'] ='Pending';
					$cp['date_time'] =date('Y-m-d h:i:s');
					$cp['forwardToAdmin'] =$data['TransToAdmin'];
					$cp['DateOfAdmin'] =$data['revisit_date'];
					$cp['Reason'] =$data['NoTranstoAdmin'];
					$db2->insert('admission_counsellor_Prospectus', $cp);
					
					//return 3;
					//$kp=3;
					
					if($data['TransToAdmin']=="Y"){
					$awd['permission_status']="Forward to Admission Center";
					$awd['admissionc_status']="Open";
					$awd['permission_out']='N';
					}else{
					$awd['permission_status']="Exit";
					$awd['admissionc_status']="Sucess";
					$awd['permission_out']='Y';
					}
					$db2->where('walking_mobile',$data['mobile']);
		            $db2->update('admission_walkin_details', $awd);
				 }
				 
				 $db2->trans_complete();
		 if($db2->trans_status() === FALSE) {
        return 1;
        }else{
		return 2;
	     }
				       
    }
    //get all student prospectus_fee_details
    public function student_prospectus_fees_details()
    {

        $year=date("Y");
        $db2 = $this->load->database('icdb', TRUE);

        $db2->select('smd.*,sandipun_univerdb.school_programs_new.sprogramm_name,pad.adm_form_no,pfd.fees_paid_type,pfd.amount,pad.inserted_on,pad.admission_mode');
        $db2->from('student_meet_details as smd
            ');
         $db2->join('provisional_admission_details pad','pad.adm_id =smd.id');
     $db2->join('sandipun_univerdb.school_programs_new', 'smd.course_interested =sandipun_univerdb.school_programs_new.sp_id');
     $db2->join('provisional_fees_details pfd','pfd.student_id =smd.id');
     $db2->where('pad.account_id is NOT NULL', NULL, FALSE);
      
        $db2->where('pfd.type_id','1');
        $db2->where('pad.year',$year);
       
		 // $db2->or_where('smd.online_admission_form_taken','Y');
     
           
	
    $db2->order_by("smd.id", "desc");
	
        $query= $db2->get();
		//echo $db2->last_query();
	    //exit;
        return $query->result_array();
    }
	
	
	 public function student_prospectus_fees_details_by($id)
    {
//print_r($id);
//exit;
       // $DB1 = $this->load->database('default', TRUE);
      $db2 = $this->load->database('icdb', TRUE);
        

        $db2->select('smd.*,sandipun_univerdb.school_programs_new.sprogramm_name,pad.adm_form_no,pfd.fees_paid_type,pfd.amount,pad.inserted_on,pad.admission_mode');
        $db2->from('student_meet_details as smd
            ');
         $db2->join('provisional_admission_details pad','pad.adm_id =smd.id',left);
     $db2->join('sandipun_univerdb.school_programs_new', 'pad.program_id =sandipun_univerdb.school_programs_new.sp_id');
     $db2->join('provisional_fees_details pfd','pfd.student_id =smd.id',left);
      $db2->where('pfd.type_id','1');
      $db2->where('pad.account_id is NOT NULL', NULL, FALSE);
        
       
      $db2->where('smd.id',$id);
		 $db2->or_where('smd.online_admission_form_taken','Y');
        
        
    $db2->order_by("smd.id", "desc");
	
        $query= $db2->get();
		//echo $db2->last_query();
	    //exit;
        return $query->result_array();
    }
	
	
    //get all student prospectus_fee_details
    public function online_admform_fees_details($id='')
    {

       // $DB1 = $this->load->database('default', TRUE);
       //  $DB2 = $this->load->database('univerdb', TRUE);
       
$db2 = $this->load->database('icdb', TRUE);
        $db2->select('smd.*,sandipun_univerdb.school_programs_new.sprogramm_name,pad.adm_form_no,pfd.fees_paid_type,pfd.receipt_no,pfd.amount,pad.inserted_on,pad.admission_mode');
        $db2->from('student_meet_details as smd
            ');
         $db2->join('provisional_admission_details pad','pad.adm_id =smd.id',left);
     $db2->join('sandipun_univerdb.school_programs_new', 'pad.program_id =sandipun_univerdb.school_programs_new.sp_id');
     $db2->join('provisional_fees_details pfd','pfd.student_id =smd.id',left);
     $db2->where('type_id','1');
     $db2->where('smd.online_admission_form_taken','Y');

          if($id!=='')
        {
          $db2->where('smd.id',$id);
        }
      
	
    $db2->order_by("smd.id", "desc");
	
        $query= $db2->get();
		//echo $db2->last_query();
	    //exit;
        return $query->result_array();
    }	
 function chek_mob_exist($mobile_no){
    // $db2->select('smd.*,pad.adm_form_no,sandipun_univerdb.school_programs_new.sprogramm_name,pad.admission_mode,pfd.fees_paid_type,pfd.amount'); 
    // $db2->from('student_meet_details as smd');
    // $db2->join('provisional_admission_details pad','pad.adm_id =smd.id',left);
    //  $db2->join('sandipun_univerdb.school_programs_new', 'smd.course_interested =sandipun_univerdb.school_programs_new.sp_id',left);
    //  $db2->join('provisional_fees_details pfd','pfd.student_id =smd.id',left);
    // $db2->where('mobile1', $mobile_no);
    // $db2->where('pfd.type_id', '1');
    //$db2->or_where('mobile2', $mobile_no);
  $db2 = $this->load->database('icdb', TRUE);
    $sql="select smd.*,pad.adm_form_no,sandipun_univerdb.school_programs_new.sprogramm_name,pad.admission_mode,pfd.fees_paid_type,pfd.amount
from student_meet_details as smd left join provisional_admission_details pad on smd.id=pad.adm_id
left join sandipun_univerdb.school_programs_new on smd.course_interested =sandipun_univerdb.school_programs_new.sp_id
left join provisional_fees_details pfd on pfd.student_id =smd.id
where (smd.mobile1='".$mobile_no."' OR smd.mobile2='".$mobile_no."' OR smd.pmobile_no='".$mobile_no."') and pfd.type_id='1'
     ";
      $query = $db2->query($sql);
    //$query = $db2->get();
    $result = $query->result_array();
  //echo $db2->last_query();exit;
    return $result;
  }  
   //check mobile
    function chek_formno_exist($formno){
      $db2 = $this->load->database('icdb', TRUE);
    $db2->select('adm_form_no'); 
    $db2->from('provisional_admission_details');
    $db2->where('adm_form_no', $formno);
    $query = $db2->get();
    $result = $query->result_array();
    ///echo $db2->last_query();//exit;
    return $result;
  } 

    function chek_formno_exist_withapprove($formno){
      $db2 = $this->load->database('icdb', TRUE);
    $db2->select('pros_serial_no'); 
    $db2->from('material_distribution_details');
    $db2->where('pros_serial_no', $formno);
    $db2->where('status', '1');
    $query = $db2->get();
    $result = $query->result_array();
    ///echo $db2->last_query();//exit;
    return $result;
  }
   //check serial no



}