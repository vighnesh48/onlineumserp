<?php // error_reporting(E_ALL); 
/*ini_set("display_errors", "On");
error_reporting(1);
error_reporting(E_ALL); 
ini_set('display_errors', 1); 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); BONAFIDE CERTIFICATE
*/
class International_recepit extends CI_Controller{

	public function __construct(){
		 global $menudata;
		 parent:: __construct();
		 //$this->load->helper("url");
		 $this->load->helper('url', 'form');
		 $this->load->library('form_validation');
		 $menu_name = $this->uri->segment(1);
         $this->data['my_privileges'] = $this->retrieve_privileges($menu_name);
		 date_default_timezone_set("Asia/Kolkata");
		  if (empty($this->session->userdata('uid'))) {
            $this->session->set_flashdata('flash_data', 'Invalid Username / E-mail OR Incorrect Password ');
            redirect('login');
        }
		// $this->load->model('Enquiry_model');
		// $this->load->model('Challan_model');
		  $this->load->model('International_recepit_model');
		  
		// $this->load->model('Enquiry_model_sijoul');
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
	
	public function Recepit_view($date_par='',$type_param='',$cyear=''){
		   
		   
		$this->load->view('header',$this->data); 
		
		if($date_par !='' && $date_par !=0){
		$this->data['date'] =date("Y-m-d");	
		}
		
		if($type_param !=''){
		$this->data['type_param'] =$type_param;	
		}
		$this->data['current_ref'] = $this->International_recepit_model->current_ref();
		$this->data['Country_list'] = $this->International_recepit_model->Country_list();
		//$this->data['consultants_list'] =$this->International_recepit_model->consultants_list();
		$this->data['streams_yearwise'] =$this->International_recepit_model->streams_yearwise();
		//$this->data['cyear'] =$this->uri->segment(3);
		//$user_id = $this->session->userdata('user_id');
		 $this->data['role_id'] = $this->session->userdata('role_id'); //exit();
	//	$this->data['Enquiry_list'] =$this->Enquiry_model->Enquiry_list();
	//	$this->load->view('Enquiry/Enquiry_list',$this->data);
		$this->load->view('International_recepit/Recepit_view',$this->data);
        $this->load->view('footer');
	}
	
	public function ajax_list()
	{  
	    $role_id = $this->session->userdata('role_id'); //exit();
		$date=$_POST['date'];
		$type_param=$_POST['type_param'];
		$cyear=$_POST['cyear'];
		$list = $this->International_recepit_model->get_datatables($date,$type_param,$cyear);
		//print_r($list);exit();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $customers) {
			$no++;
			$row = array();
			$row[] = $no;
			
			//$row[] = '<a href="'.base_url().'Enquiry/New_Enquiry/'.$customers->status.'/'.$customers->status.'">'.$customers->status.'</a>';
			/*if($customers->status=='Y'){
			$row[] = '<div class="action-buttons" align="center">
                                            <a class="label bg-green font-11" style="cursor: pointer;" data-toggle="modal" data-target="#exampleModalCenter" onclick="javascript: return OpenDialouge('.$customers->bcd_id.');event.preventDefault();">Confirmed</a>
                                        </div>';
			}elseif($customers->status=='N'){
			
			$row[] = '<div class="action-buttons" align="center">
                                            <a class="label bg-grey font-11" style="cursor: pointer;" data-toggle="modal" data-target="#exampleModalCenter" onclick="javascript: return OpenDialouge('.$customers->bcd_id.');event.preventDefault();">Pending</a>
                                        </div>';
			}else{
				'<div class="action-buttons" align="center">
                                            <a class="label bg-red font-11" style="cursor: pointer;" data-toggle="modal" data-target="#exampleModalCenter" onclick="javascript: return OpenDialouge('.$customers->bcd_id.');event.preventDefault();">Canceled</a>
                                        </div>';
			}
			
			
			
			$row[] = ' <a href="'.base_url().'Bonafide/regenerate_bonafide/'.$customers->bcd_id.'" class="btn btn-success btn-sm" target="_blank" >
      <span class="glyphicon glyphicon-print"></span> Print 
    </a>';*/
			$row[] = $customers->Recepit_date;
			$row[] = $customers->academic_year;
			$row[] = $customers->country_name;
			$row[] = $customers->stream_name;
			
			$row[] = $customers->student_name;
			$row[] = $customers->admission_year;
			
			
			/*$row[] = $customers->stream_name;
			if($customers->admission_year==1){$addy="1st Year";}
			if($customers->admission_year==2){$addy="2nd Year";}
			if($customers->admission_year==3){$addy="3rd Year";}
			if($customers->admission_year==4){$addy="4th Year";}
			$row[] = $addy;*/
			
			$row[] = $customers->email_id;
			$row[] = $customers->mobile1;
		
			$row[] = $customers->Passport_No;
			$row[] = $customers->hostel_status;
			$row[] = '<a href="'.base_url().'/uploads/International_recepit/'.$customers->file_path.'" target="_blank">'.$customers->file_path.'</a>';
			$row[] = $customers->Amount;
			
			
		
			$row[] = '<a onclick="javascript: return OpenDialougeedit('.$customers->idr.');event.preventDefault();" title="Edit" ><i class="fa fa-edit"></i> &nbsp; </a>
		<a href="javascript:void(0);" title="Delete"  onclick="javascript: return OpenDialougedeleted('.$customers->idr.');event.preventDefault();"><i class="fa fa-trash-o"></i>&nbsp;  </a>';
			
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->International_recepit_model->count_all($cyear),
						"recordsFiltered" => $this->International_recepit_model->count_filtered($date,$type_param,$cyear),
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
	
	public function fetch_Bonafide(){
		$data =$this->International_recepit_model->fetch_Bonafide($_POST);
	//	print_r($data);
	    $bcd_id=$data[0]['bcd_id'];
		$status=$data[0]['status'];
		$date_in=$data[0]['date_in'];
		$status_date=$data[0]['status_date'];
		$status_remark=$data[0]['status_remark'];
		$acknowledgement_no=$data[0]['acknowledgement_no'];
		$Ysel='';$Nsel='';
		
		if($status=='Y'){
		$Ysel= 'selected="selected"';
		}elseif($status=='N'){
		$Nsel= 'selected="selected"';
		}else{
		$Csel= 'selected="selected"';
		}
		
		echo '<div>
		 <div class="form-group">
     <label class="col-sm-2">Update&nbsp;Status&nbsp;&nbsp;</label><div class="col-sm-2"><input type="radio" name="Updates_f" class="Updates_f" value="Statusf" checked="checked" /></div>
	 <label class="col-sm-4">Update&nbsp;Acknowledgement&nbsp;No&nbsp;&nbsp;</label><div class="col-sm-2"><input type="radio" name="Updates_f" class="Updates_f" value="Acknowledgement" /></div>
     </div>
	 <div class="Statusf">
     <div class="form-group">
	 <input type="hidden" id="bcd_id" name="bcd_id" value="'.$bcd_id.'"/>
     <label class="col-sm-1">&nbsp;Status&nbsp;</label>
     
	 <div class="col-sm-4">
	 <select name="status_m" id="status_m" class="form-control"  required="required">
     <option value="">Select Type</option><option value="Y" '.$Ysel.'>Confirmed</option><option value="N"  '.$Nsel.'>Pending</option><option value="C"  '.$Csel.'>Canceled</option>
     </select>
     </div>
	<label class="col-sm-1">&nbsp;Date&nbsp;</label>
    <div class="col-sm-4"><input type="text" id="Date_f" name="Date_f" value="'.$date_in.'" class="form-control" placeholder="Date" /></div>
    </div>
	<div class="form-group">
    <label class="col-sm-2">&nbsp;Remark&nbsp;</label>
    <div class="col-sm-5"><textarea name="Remark" id="Remark" >'.$status_remark.'</textarea></div>
    </div>
	</div>
    </div>
							   <div class="form-group Acknowledgement" style="display:none">
                                  <label class="col-sm-3">Acknowledgement&nbsp;No&nbsp;</label>
                                 <div class="col-sm-6"><input type="text" name="acknowledgement_no" id="acknowledgement_no" value="'.$acknowledgement_no.'"></div>
                                 
                              </div>
							  <div class="form-group">
							  <label class="col-sm-2"></label>
							  <div id="msg_save" style="color:#0C3"></div>
							  </div>';
							  echo '<script>
							  
							   $(".Updates_f").click(function(){
							  var m=$(this).val();
							  if(m=="Statusf"){
								  $(".Statusf").show();
								  $(".Acknowledgement").hide();
							  }else{
								    $(".Acknowledgement").show();
								  $(".Statusf").hide();
							  }
							   });
							   
							  $("#Date_f").datepicker({
     todayBtn:  1,       
        autoclose: true,
    format: "yyyy-mm-dd"/*,
     startDate: new Date() */
    })
	
	
	</script>';
	}
	
	
	
	public function save_status(){
		$mob = $this->International_recepit_model->save_status($_POST);
	}
	
	
	public function OpenDialougedeleted(){
		$data =$this->International_recepit_model->OpenDialougedeleted($_POST);
	}
	
	
	public function OpenDialougeedit(){
		
		
		$data =$this->International_recepit_model->fetch_Recepit($_POST);
		
		 $this->data['current_ref'] = $this->International_recepit_model->current_ref();
		//print_r($current_ref);
		//exit();
		$this->data['Country_list'] = $this->International_recepit_model->Country_list();
		//$this->data['consultants_list'] =$this->International_recepit_model->consultants_list();
		$this->data['streams_yearwise'] =$this->International_recepit_model->streams_yearwise();
		$this->data['edit_data'] =$data;
		
	//	$this->load->view('Bonafide/Bonafide_edit',$this->data);
				$this->load->view('International_recepit/Recepit_edit',$this->data);

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
		  $id=$this->uri->segment(3);     //	exit();
		$Enquiry = $this->Enquiry_model_sijoul->enquiry_by_stud_id($id);
		
		//
	
		//print_r($Enquiry);
		//exit();
		$this->data['Enquiry_data']=$Enquiry;
		/*$this->data['per'] = $this->Home_model->fetch_pd($stud_id);
		$this->data['qua'] = $this->Home_model->fetch_qualification_list($stud_id);
		$this->data['qualfg'] = $this->Home_model->fetch_qualification($stud_id);
		$this->data['course'] = $this->Home_model->fetch_course_list($stud_id);
		$this->data['pay'] = $this->Home_model->fetch_payment_for_verification($stud_id);
		$this->data['photo'] = $this->Home_model->fetch_profile_photo($stud_id);*/
		  $this->load->view('Enquiry/print_admission_form_view1', $this->data);
		//  $this->load->view('Enquiry_sijoul/print_admission_form_pdf', $this->data);
		// $this->load->view('Enquiry/pdf_generate', $this->data);
       // $this->load->view('Enquiry/pdf_generate', $this->data);
    }

function regenerate_bonafide()
{
	
	
 $id=$this->uri->segment(3); 
 $v['bcd_id']  =$id; 
// print_r($v);
    $s =$this->International_recepit_model->fetch_Bonafide_all($v);
	$Academic_Fees =$this->International_recepit_model->Academic_Fees($v,$s[0]['hostel_status'],$s[0]['hostel_type'],$s[0]['course_id'],$s[0]['course_duration'],$s[0]['admission_year']);
	$aadhar_card=$s[0]['aadhar_card'];
	$data['all_data']=$s;
	$data['Academic_Fees']=$Academic_Fees;
	// $html = $this->load->view('Bonafide/Admission_Letter_new',$data,true);
//	echo $html = $this->load->view('Bonafide/Bonfide_pdf',$data,true);
	// print_r($Academic_Fees);exit();
	//echo '<pre>';print_r($Academic_Fees);echo '<pre/>';
	//exit();
      /*$bddata = $this->Ums_admission_model->regenerate_bonafied($enroll);
      $gendata = $this->Ums_admission_model->list_bonafied($bid,$refid='');
      $data['bonafieddata']= $bddata;
      $subs=substr($bddata['academic_year'],-2);
      $data['curryear']=$bddata['academic_year'];
      $data['subyear']=$subs+1;
      
       $data['idate']=$gendata[0]['cert_date'] ;
        $data['purpose']=$gendata[0]['purpose'] ;
         $data['reg']= $gendata[0]['cert_reg'];*/
    //$html = $this->load->view('Bonafide/bonafiedpdf',$data,true);
	
	
//echo $html;
//exit();
//$html ="<div>gdf dfg df fdg fg dg gfdg gd fg</div>";
$this->load->library('m_pdf');
 $mpdf=new mPDF();
		  // $this->m_pdf->pdf = new mPDF('utf-8', 'A4', '6', '6', '6', '6', '50', '15');
			$this->m_pdf->pdf = new mPDF('utf-8', 'A4', '10', '10', '10', '10', '30', '5');
$files = array('1','2');
//print_r($files);
//exit();
 
			
foreach ($files as $key=>$val) {
	//echo $key;
	if($val==1){
    $html = $this->load->view('Bonafide/Bonfide_pdf',$data,true);
	}else{
	$html= $this->load->view('Bonafide/Admission_Letter_new',$data,true);
	}
	
	//echo '<embed src="http://URL_TO_PDF.com/pdf.pdf#toolbar=0&navpanes=0&scrollbar=0" width="500" height="500">';
	//$html= $this->load->view('Bonafide/Admission_Letter_new',$data,true);
    /*$pdfFilePath = "Bonafied Certificate.pdf";
    $param = '"en-GB-x","A4","","",0,0,0,0,-10,-10,P';
        //load mPDF library
        $this->load->library('m_pdf',$param);


        $this->m_pdf->pdf->AddPage();
       //generate the PDF from the given html
        $this->m_pdf->pdf->WriteHTML($file);
	ob_clean();
        //download it.
        $this->m_pdf->pdf->Output($pdfFilePath, "D");  
 $pdfFilePath = "output_pdf_name.pdf"; */
 
 $html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
 
            $this->m_pdf->pdf->useFixedNormalLineHeight = false;
            $this->m_pdf->pdf->useFixedTextBaseline = false;
            $this->m_pdf->pdf->normalLineheight = 2.7;
            $this->m_pdf->pdf->adjustFontDescLineheight = 2.7;
		    //$this->m_pdf->pdf->SetDefaultBodyCSS('line-height', 5.2);
			$this->m_pdf->pdf->PageNumSubstitutions[] = [
								'from' => 1,
								'reset' => 0,
								'type' => 'I',
								'suppress' => 'off'
							];
			$this->m_pdf->pdf->AddPage();
			
			$this->m_pdf->pdf->WriteHTML($html);
			
			 
			ob_clean();
			//header('Content-type: application/pdf');
   // header("Content-Disposition: inline; name=Test");
  //  header('Content-Transfer-Encoding: binary');
  //  header('Content-Length: ' . size($html));
   // header('Accept-Ranges: bytes');
   // header("Location: $file");
   // @readfile($html);
			
}
         $currtnt_time= date('y-m-d h:i:s');
			//$this->data['schoolname_new'];//date('y-m-d h:i:s');
		 $pdfFilePath1 =$currtnt_time.'_'.$aadhar_card."_Bonafied.pdf";
			
		 $this->m_pdf->pdf->Output($pdfFilePath1, "D");
 //////////////////////////////////////////////////////////////////////////////////////////////
 /*$htmll = $this->load->view('Bonafide/Admission_Letter_new',$data,true);
 echo $htmll;
 
//exit();
//$html ="<div>gdf dfg df fdg fg dg gfdg gd fg</div>";
    $pdfFilePathh = "Bonafied Certificate_m.pdf";
$paramm = '"en-GB-x","A4","","",0,0,0,0,-10,-10,P';
        //load mPDF library
        $this->load->library('m_pdf',$paramm);

       //generate the PDF from the given html
        $this->m_pdf->pdf->WriteHTML($htmll);

        //download it.
        $this->m_pdf->pdf->Output($pdfFilePathh, "D");  
      $pdfFilePathh = "output_pdf_namen.pdf"; */
}



function insert_st_direct(){
	$this->Enquiry_model->insert_st_direct();
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////


function insert_data(){ 
//print_r($_REQUEST);
         $image_info = getimagesize($_FILES["Recepit_Upload"]["name"]);
		 if(!empty($image_info)){
$ref_no=$this->input->post('ref_no');

            //$filenm=$std[0]['enrollment_no'].'.jpg'; //$std
			$new_image_name = time() . str_replace(str_split(' ()\\/,:*?"<>|'), '',$_FILES['Recepit_Upload']['name']);
		    $config['upload_path'] = 'uploads/International_recepit/';
            $config['allowed_types'] = '*';
            $config['overwrite']= TRUE;
           	
            /*$config['max_width'] = '1000';
			$config['max_height'] = '1000';
			$config['min_width'] = '350';
			$config['min_height'] = '350';*/
			
            $config['file_name'] = $new_image_name;
            $this->load->library('upload', $config);
		    if (!$this->upload->do_upload('Recepit_Upload')) {
				 $error = array('error' => $this->upload->display_errors()); 
				
			}else{ 
				
				//update data in student master
			
			} 
    $add['file_path'] = $new_image_name;
		 }


	//exit();
	// error_reporting(E_ALL); 
	$DB1 = $this->load->database('umsdb', TRUE);
	
	$add['Recepit_date'] = $this->input->post('Recepit_date');
	$add['academic_year'] = $this->input->post('academic_year');
	
    $add['Country'] = $this->input->post('Country');
	$add['Course'] = $this->input->post('Course');
	$add['admission_year'] =$this->input->post('admission_year');
	
    $add['ref_no'] = $this->input->post('ref_no');
    
    $add['student_name'] = $this->input->post('student_name');
    $add['email_id'] = $this->input->post('email_id');
    $add['mobile1'] = $this->input->post('mobile1');
   
    $add['Passport_No'] = $this->input->post('Passport_No');
    $add['gender'] = $this->input->post('gender');
    $add['hostel_status'] =$this->input->post('hostel_status');
	

    $add['Amount'] = $this->input->post('Amount');
	
    
	
	//$add['status'] = 'N';
	// $add['status_date'] = $this->input->post('Amount');
	// $add['status_remark'] = $this->input->post('Amount');
	 $create_by =$this->session->userdata('uid');
	 $add['create_on'] = date('Y-m-d h:i:s');
	 $add['create_by'] = $create_by;
	
	 $check=$this->International_recepit_model->check_adhar($this->input->post('Passport_No'));		
		if($check==0){		
				
	$DB1->insert('International_admission_recepit',$add);
	echo $student_id=$DB1->insert_id();
	echo $DB1->last_query();
	
		}else{
			echo 'C';
		}

    
}
/*public function update_data(){
		
		//print_r($_POST);
		$status =$this->Enquiry_model->update_data($_POST);
		redirect("Enquiry/New_Enquiry/".$status);
	}*/
function update_data(){
	//print_r($_POST);
	//exit();
	$DB1 = $this->load->database('umsdb', TRUE);
	
	
	//$image_info = getimagesize($_FILES["Recepit_Upload"]["name"]);
	$image_info = getimagesize($_FILES["Recepit_Upload"]["tmp_name"]);
	 getimagesize($_FILES['Recepit_Upload']['name']);
	 $size=$_FILES['Recepit_Upload']['size'];
	
	//exit();
if(!empty($size)){


            $new_image_name = time() . str_replace(str_split(' ()\\/,:*?"<>|'), '',$_FILES['Recepit_Upload']['name']);
		    $config['upload_path'] = 'uploads/International_recepit/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg|jpe|pdf|doc|docx|rtf|text|txt';
		   // $config['allowed_types'] = '*';
            $config['overwrite']= TRUE;
           	$config['max_size'] = '2024';
            
			/*$config['max_width'] = '1000';
			$config['max_height'] = '1000';
			$config['min_width'] = '350';
			$config['min_height'] = '350';*/
			
            $config['file_name'] = $new_image_name;
            $this->load->library('upload', $config);
		    if (!$this->upload->do_upload('Recepit_Upload')) {
				 $error = array('error' => $this->upload->display_errors()); 
				
			}else{ 
				
				$imageDetailArray = $this->upload->data();
				//print_r($imageDetailArray);
            //$image =  $imageDetailArray['file_name'];
			
			} 
	 $add['file_path'] = $new_image_name;
}
	
	
	
	
	$idr = $this->input->post('idr');
	$add['Recepit_date'] = $this->input->post('Recepit_date');
	$add['academic_year'] = $this->input->post('academic_year');
	
    $add['Country'] = $this->input->post('Country');
	$add['Course'] = $this->input->post('Course');
	$add['admission_year'] =$this->input->post('admission_year');
	
    $add['ref_no'] = $this->input->post('ref_no');
    
    $add['student_name'] = $this->input->post('student_name');
    $add['email_id'] = $this->input->post('email_id');
    $add['mobile1'] = $this->input->post('mobile1');
   
    $add['Passport_No'] = $this->input->post('Passport_No');
    $add['gender'] = $this->input->post('gender');
    $add['hostel_status'] =$this->input->post('hostel_status');
	
   
    $add['Amount'] = $this->input->post('Amount');
	
	 //$add['status'] = 'N';
	// $add['status_date'] = $this->input->post('Amount');
	// $add['status_remark'] = $this->input->post('Amount');
	 $create_by =$this->session->userdata('uid');
	 $add['update_on'] = date('Y-m-d h:i:s');
	 $add['update_by'] = $create_by;
	 
	 $DB1->where('idr', $idr);
	 $DB1->update('International_admission_recepit',$add);
	
	echo $DB1->affected_rows();

    
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////

}
?>