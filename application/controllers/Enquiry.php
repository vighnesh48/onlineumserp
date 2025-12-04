<?php
/*ini_set("display_errors", "On");
error_reporting(1);
error_reporting(E_ALL); 
ini_set('display_errors', 1); 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/
class Enquiry extends CI_Controller{

	public function __construct(){
		 global $menudata;
		 parent:: __construct();
		 $this->load->helper("url");
		 $this->load->library('form_validation');
		 $menu_name = $this->uri->segment(1);
         $this->data['my_privileges'] = $this->retrieve_privileges($menu_name);
		 date_default_timezone_set("Asia/Kolkata");
		  if (empty($this->session->userdata('uid'))) {
            $this->session->set_flashdata('flash_data', 'Invalid Username / E-mail OR Incorrect Password ');
            redirect('login');
        }
		 $this->load->model('Enquiry_model');
		 $this->load->model('Challan_model');
		/// $this->load->model('Challan_model');
	}
	
	
	 public function index($offSet = 0) {
       
        if (isset($_REQUEST['per_page'])) {
            $offSet = $_REQUEST['per_page'];
        }
        $this->load->view('header', $this->data);

        $this->data['eventList'] = $this->event_model->get_event_details($event_id = "", $offSet, $limit);

        $total = $this->event_model->fetch_cnt_events();

        $this->load->library('pagination');
        $config['first_url'] = base_url() . 'event/index/';
        $config['enable_query_strings'] = TRUE;
        $config['page_query_string'] = TRUE;
        $config['reuse_query_string'] = TRUE;
        $config['base_url'] = base_url() . 'event/index';
        $config['total_rows'] = $total;
        $config['per_page'] = $limit;
        $this->pagination->initialize($config);
        $this->data['paginglinks'] = $this->pagination->create_links();
        $config['offSet'] = $offSet;
        $this->data['sujee_int_cnt'] = $this->event_model->get_sujee_interest_count();
        $this->data['ic_list'] = $this->event_model->get_ic_bytype('ic');
        $this->load->view($this->view_dir . 'view', $this->data);
        $this->load->view('footer');
    }
	
	public function New_Enquiry(){
	 //  $this->load->view('header', $this->data);
	  // $this->load->view('Enquiry/New_Enquiry', $this->data);
      // $this->load->view('footer');
	     $csid='';
	     $mobile='';
		 $mobile=$_REQUEST['mobile'];
		 $csid=$_REQUEST['csid'];
		 
		$enquiry_id= $this->uri->segment(3);
		 $enquiry_no= $this->uri->segment(4);
		$enquiry_mobile= $this->uri->segment(5);
		//exit;
        $this->load->view('header',$this->data);    
       // $this->data['course_details']= $this->Prospectus_fee_details_model->get_course_details();
         if($enquiry_no!='')
        {
         $this->data['enquiryparamer']=$enquiry_no;
		 $this->data['mobilnparamer']=$enquiry_mobile;
        }
		
		
		
		$this->data['mobile_from']=$mobile;
		$this->data['counsellorid']=$csid;
		
		
		//$this->data['city'] = $this->Enquiry_model->getStatewiseDistrict();
	    //$this->data['city_sub'] = $this->Enquiry_model->getStateDwiseCity();
	    //$this->data['qual']= $this->Enquiry_model->fetch_stud_qualifications();
	    //$this->data['load_courses'] = $this->Enquiry_model->getschool_course();
	    //$this->data['stream']= $this->Enquiry_model->fetch_stcouse_details();
	   // $this->data['school_list']= $this->Enquiry_model->list_schools_data();
		
		$this->data['states'] = $this->Enquiry_model->fetch_states();
		$this->data['Scholarship_type'] =$this->Enquiry_model->Scholarship_type();
		$this->data['Scholarship_typee'] =$this->Enquiry_model->Scholarship_typee();
        $this->load->view('Enquiry/prospectus_details',$this->data);
        $this->load->view('footer');
	}
	
	public function Enquiry_list($date_par='',$type_param=''){
		   
		   
		$this->load->view('header',$this->data); 
		if($date_par !='' && $date_par !=0){
		$this->data['date'] =date("Y-m-d");	
		}
		if($type_param !=''){
		$this->data['type_param'] =$type_param;	
		}
	//	$this->data['Enquiry_list'] =$this->Enquiry_model->Enquiry_list();
		$this->load->view('Enquiry/Enquiry_list',$this->data);
        $this->load->view('footer');
	}
	
	public function ajax_list()
	{  
	  
		$date=$_POST['date'];
		$type_param=$_POST['type_param'];
		$list = $this->Enquiry_model->get_datatables($date,$type_param);
		//print_r($list);exit();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $customers) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = '<a href="'.base_url().'Enquiry/New_Enquiry/'.$customers->enquiry_id.'/'.$customers->enquiry_no.'">'.$customers->enquiry_no.'</a>';
			$row[] = $customers->form_no;
			$row[] = $customers->provisional_no;
			$row[] = $customers->first_name.'&nbsp;'.$customers->middle_name.'&nbsp;'.$customers->last_name;
			$row[] = $customers->mobile;
			/*$row[] = $customers->altarnet_mobile;*/
			/*$row[] = $customers->email_id;*/
			$row[] = $customers->school_name;
			$row[] = $customers->course_short_name;
			$row[] = $customers->vstream_name;
			$row[] = $customers->admission_type;
			/*$row[] = $customers->form_taken;*/
			
			/*$row[] = $customers->scholarship_allowed;*/
		//	$row[] = $customers->scholarship_status;
			
			$row[] = $customers->actual_fee;
			$row[] = $customers->scholarship_allowed;
			
			if($customers->scholarship_allowed=="YES"){  //str_replace('_',' ',$Enquiry_data["scholarship_type"])
			$row[] ='Rs '.$customers->scholarship_amount.' ('.str_replace('_',' ',$customers->scholarship_type).') <br/>'.$customers->scholarship_status;
			}else{
			$row[] = '-';
			}
			
			$row[] = $customers->actual_fee - $customers->scholarship_amount;
			
			//if($customers->form_no!=''){
			if($customers->provisional_no=="-"){
			$row[] = '<a href="'.base_url().'Enquiry/pay_money/'.$customers->enquiry_id.'/'.$customers->enquiry_no.'">Pay</a>';
			}else{
			$row[] = 'PAID | <a href="'.base_url().'Enquiry/download_admission_form/'.$customers->enquiry_id.'">Admission</a> | <a href="'.base_url().'Enquiry/download_provisional_form/'.$customers->enquiry_id.'">Provisional</a> | <a href="'.base_url().'Enquiry/send_admission_form/'.$customers->enquiry_id.'">Mail</a>';
			//$row[] = '<a href="'.base_url().'Enquiry/download_admission_form/'.$customers->enquiry_id.'">Admission Form</a>';
			//$row[] = '<a href="'.base_url().'Enquiry/download_provisional_form/'.$customers->enquiry_id.'">provisional Form</a>';
			//$row[] = '<a href="'.base_url().'Enquiry/send_admission_form/'.$customers->enquiry_id.'">SEND</a>';
			}
			//}else{
			//$row[] ='-';	
			//}
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->Enquiry_model->count_all($type_param),
						"recordsFiltered" => $this->Enquiry_model->count_filtered($date,$type_param),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	
	
	public function Enquiry_insert(){
		
		//print_r($_POST);
		$status =$this->Enquiry_model->Enquiry_insert($_POST);
		redirect("Enquiry/New_Enquiry/".$status);
	}
	
	public function Updated(){
		
		$status =$this->Enquiry_model->Enquiry_Updated($_POST);
		redirect("Enquiry/New_Enquiry/".$status);
	}
	
	
	
	  // check duplicate mobile no exist
        public function Serach_details(){
         
        $mobile_no = trim($_REQUEST['mobile_no']);
		$Enquiry_search = trim($_REQUEST['Enquiry_search']);
        //echo $state;
        $mob = $this->Enquiry_model->chek_mob_exist($mobile_no,$Enquiry_search);
      
        //$this->data['ic']  = $this->Sujee_model->get_ic_name();
        //print_r($mob);exit;
        $cnt_mob   = count($mob);
        //echo $mob[0]['sujee_apperaed'];
        if($cnt_mob > 0){
            
                echo json_encode($mob);
            } else{
                echo "no";
               
            }
    
    }
	
	public function getStatewiseDistrict(){

		$state=$_REQUEST['state_id'];
		$stt=$_REQUEST['stt'];
		//echo $state;
		$dist=$this->Enquiry_model->getStatewiseDistrict($state);
		//print_r($dist);exit;
		if(!empty($dist)){
			echo"<option value=''>Select District</option>";
			foreach($dist as $key=>$val){
				if($dist[$key]['district_id']==$stt){
				$sel='selected';
			}else{
		$sel='';
			}
				echo"<option value='".$dist[$key]['district_id']."' $sel>".$dist[$key]['district_name']."</option>";
			}		
		}
	}
	 public function getStateDwiseCity(){
		$state_id=$_REQUEST['state_id'];
		$dist_id=$_REQUEST['district_id'];
		$stt=$_REQUEST['stt'];
		//echo $state;
		$city=$this->Enquiry_model->getStateDwiseCity($state_id, $dist_id);
		//print_r($city);exit;
		if(!empty($city)){
			echo"<option value=''>Select City</option>";
			foreach($city as $key=>$val){
				if($city[$key]['taluka_id']==$stt){
				$sel='selected';
			}else{
		$sel='';
			}
				
				echo"<option value='".$city[$key]['taluka_id']."' $sel>".$city[$key]['taluka_name']."</option>";
			}		
		}
	}
	
	
	
	
	
	function fetch_school(){
		$data=$this->Enquiry_model->list_schools_data($_POST['val']);
		$schoola=$_POST['schoola'];
		$str=' <option value="">Select School</option>';
		if(!empty($data)){
		foreach ($data as $schools) {
			if($schools['school_id']==$schoola){
				$sel='selected';
			}else{
		$sel='';
			}
		$str.='<option value="' . $schools['school_id'] . '"' . $sel . '>' . $schools['school_name'] . '</option>';
		}
		echo $str;
	  }
	  
	}
	public function load_courses()
		{
		// global $model;	
		$schoola=$_POST['schoola'];    
		  $course_details =  $this->Enquiry_model->getschool_course($_POST['school'],$_POST['highest_qualification']);  
		   $opt ='<option value="">Select Course</option>';
			foreach ($course_details as $course) {
if($course['course_id']==$schoola){
				$sel='selected';
			}else{
		$sel='';
			}
		$opt .= '<option value="' . $course['course_id'] . '" '.$sel.'>' . $course['course_short_name'] . '</option>';
         }
          echo $opt;
		}
	
	
	
	 public function get_course_streams_yearwise()
		{
	  	  
	    $this->data['campus_details']= $this->Enquiry_model->get_course_streams_yearwise($_POST);     	    
		}
	
	
	
	
	  public function fetch_academic_fees_for_stream_year(){
	     
		$strm_id=$_REQUEST['strm_id'];
		$acyear=$_REQUEST['acyear'];
		$year=$_REQUEST['admission_type'];
		$fess =$this->Enquiry_model->fetch_academic_fees_for_stream_year($strm_id,$acyear,$year);
		
		echo json_encode($fess);
	}   	
	
	
	public function From(){
		 $id=$this->uri->segment(3);
		 
		 $this->load->view('header', $this->data);
	   $this->load->view('Enquiry/Enquiry_from', $this->data);
       $this->load->view('footer');
		
	}
	////////////////////////////////////////////////////////////////////////////////////
	
	
	  // check mobile exist
        public function chek_dupmobno_exist(){

            $mobile_no=$_REQUEST['mobile_no'];
           
            //echo $state;
            $mob =$this->Enquiry_model->chek_mob_exist($mobile_no);
            $cnt_mob = count($mob);
            if($cnt_mob > 0){
                echo "Duplicate~".json_encode($mob);
            }else{
                echo "regular~1";
            }
        }
      // check duplicate form no exist
        public function chek_formno_exist(){

            $formno=$_REQUEST['newforno'];
           
            //echo $state;
            $mob =$this->Enquiry_model->chek_formno_exist($formno);
            $cnt_mob = count($mob);
            if($cnt_mob > 0){
                echo "Duplicate~".json_encode($mob);
            }else{
                echo "regular~1";
            }
        }
               // check duplicate form no approve status exist
        public function chek_formno_exist_withapprove(){

            $formno=$_REQUEST['newforno'];
           
            //echo $state;
             $mob =$this->Enquiry_model->chek_formno_exist_withapprove($formno);
			//print_r($mob);
			//exit();
            $cnt_mob = count($mob);
            if($cnt_mob > 0){
                echo "regular~1".json_encode($mob);
            }else{
                echo "duplicate";
            }
        }
		
		
		
		public function pay_money(){
			 $id=$this->uri->segment(4);//exit();
		$this->data['enquery_no']=$id;
		 $this->load->view('header', $this->data);
		// $this->data['facility_details']=$this->Enquiry_model->get_facility_types();
		$this->data['depositedto_details']=$this->Enquiry_model->get_depositedto();
		//$this->data['academic_details']=$this->Enquiry_model->get_academic_details();
		$this->data['bank_details']= $this->Enquiry_model->getbanks();
	   $this->load->view('Enquiry/add_fees_challan_details_new', $this->data);
       $this->load->view('footer');
		}
		
		public function students_data()
	{
		$std_details = $this->Enquiry_model->students_data($_POST);   
		//var_dump($std_details);
	   	echo json_encode(array("std_details"=>$std_details));
	}
	
	
	
	
	 public function get_fee_details_new(){
	 //    error_reporting(E_ALL);
//ini_set('display_errors', 1);

$academic=$_REQUEST['academic'];
$facility=$_REQUEST['facility'];
$enroll=$_REQUEST['enroll'];
$stud=$_REQUEST['stud'];
$curr_yr=$_REQUEST['curr_yr'];
$admission_session=$_REQUEST['admission_session'];
$stream_id=$_REQUEST['stream_id'];

//$check_current=$this->Challan_model->check_current($_POST);
//if($check_current[0]['Total']==0){
	$fee_details = $this->Enquiry_model->get_fee_details($_POST);
	//exit();
//}else{
	$fee_details_new = $this->Enquiry_model->fee_details($_POST);
	if(empty($fee_details_new)){
		$details_new=array('fees_id'=>'');
	}else{
		$details_new=$fee_details_new;
		}
//}
//exit;

//exit;
		//$fee_details = $this->Challan_model->get_fee_details($_POST);
		//$fee=array_push($fee_details,$fee_details_new);
		$artists = array();
array_push($artists, $fee_details, $details_new);
//print_r($artists);
		//print_r($artists);
		//exit;
		
		echo json_encode($artists);
	}
//////////////////////////////////////////////////////////////////////////////////	








public function add_fees_challan_submit(){
	//print_r($_POST);
	
	$data=$this->Enquiry_model->check_fees_challan_submit($_POST);
	
	////////////////////////////////////////////////////////////////////////////////////////
	
	$this->session->set_flashdata('message1','Fees Challan Generated Successfully.');
	//exit();
	//print_r($data);
	redirect('Challan');
	
}



public function download_admission_form($stud_id='') {
		 $id=$this->uri->segment(3);     
		$this->data['Enquiry_data'] = $this->Enquiry_model->enquiry_by_id($id);
		/*$this->data['per'] = $this->Home_model->fetch_pd($stud_id);
		$this->data['qua'] = $this->Home_model->fetch_qualification_list($stud_id);
		$this->data['qualfg'] = $this->Home_model->fetch_qualification($stud_id);
		$this->data['course'] = $this->Home_model->fetch_course_list($stud_id);
		$this->data['pay'] = $this->Home_model->fetch_payment_for_verification($stud_id);
		$this->data['photo'] = $this->Home_model->fetch_profile_photo($stud_id);*/
		
		
		$this->load->view('Enquiry/print_admission_form_view1', $this->data);
	//	$this->load->view('Enquiry/print_admission_form_view_provisional_form_manually', $this->data);
		// $this->load->view('Enquiry/pdf_generate', $this->data);
       // $this->load->view('Enquiry/pdf_generate', $this->data);
	  // redirect('Enquiry/Enquiry_list');
    }
	public function download_provisional_form($stud_id='') {
		 $id=$this->uri->segment(3);     
		$this->data['Enquiry_data'] = $this->Enquiry_model->enquiry_by_id($id);
		/*$this->data['per'] = $this->Home_model->fetch_pd($stud_id);
		$this->data['qua'] = $this->Home_model->fetch_qualification_list($stud_id);
		$this->data['qualfg'] = $this->Home_model->fetch_qualification($stud_id);
		$this->data['course'] = $this->Home_model->fetch_course_list($stud_id);
		$this->data['pay'] = $this->Home_model->fetch_payment_for_verification($stud_id);
		$this->data['photo'] = $this->Home_model->fetch_profile_photo($stud_id);*/
		
		
		//$this->load->view('Enquiry/print_admission_form_view1', $this->data);
		$this->load->view('Enquiry/print_admission_form_view_provisional_form_manually', $this->data);
		// $this->load->view('Enquiry/pdf_generate', $this->data);
       // $this->load->view('Enquiry/pdf_generate', $this->data);
	  // redirect('Enquiry/Enquiry_list');
    }

public function send_admission_form($stud_id='') {
		 $id=$this->uri->segment(3);     
		$this->data['Enquiry_data'] = $this->Enquiry_model->enquiry_by_id($id);
		/*$this->data['per'] = $this->Home_model->fetch_pd($stud_id);
		$this->data['qua'] = $this->Home_model->fetch_qualification_list($stud_id);
		$this->data['qualfg'] = $this->Home_model->fetch_qualification($stud_id);
		$this->data['course'] = $this->Home_model->fetch_course_list($stud_id);
		$this->data['pay'] = $this->Home_model->fetch_payment_for_verification($stud_id);
		$this->data['photo'] = $this->Home_model->fetch_profile_photo($stud_id);*/
		
		
		$this->load->view('Enquiry/print_admission_form_view2', $this->data);
		$this->load->view('Enquiry/print_admission_form_view_provisional_form_manually2', $this->data);
		// $this->load->view('Enquiry/pdf_generate', $this->data);
       // $this->load->view('Enquiry/pdf_generate', $this->data);
	   $this->session->set_flashdata('Msg','Mail Send');
	   redirect('Enquiry/Enquiry_list');
    }



}
?>