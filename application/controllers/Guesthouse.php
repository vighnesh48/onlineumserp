<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Guesthouse extends CI_Controller 
{
    var $currentModule="";
    var $title="";
    var $table_name="";
    var $model_name="Guesthouse_model";
    var $model;
    var $view_dir='Guesthouse/';
    var $data=array();
    public function __construct() 
    {
        parent:: __construct();
	//	error_reporting(E_ALL);
	//	ini_set('display_errors', 1);
        // load form and url helpers
        $this->load->helper(array('form', 'url'));
        
        // load form_validation library
        $this->load->library('form_validation');
		$this->currentModule=$this->uri->segment(1);        
        $this->data['currentModule']=$this->currentModule;
        $this->data['model_name']=$this->model_name;
        $this->data['hostal_fee']='500';
		$this->load->model($this->model_name);
		$this->load->model('Challan_model');
		$this->load->library('Message_api');
	}
	
	public function index()
    {
        $this->view_guesthouse();
    }
	
	public function view_guesthouse()
    {
        $this->load->view('header',$this->data);
      //  print_r($_SESSION);
		$this->data['guesthouse_details']=$this->Guesthouse_model->get_guesthouse_details();
        $this->load->view($this->view_dir.'view_guesthouse',$this->data);
        $this->load->view('footer');
    }
	
	public function check_visitor_exists()
	{
		$vp_dts=array_shift($this->Guesthouse_model->check_visitor_exists($_POST));
		echo json_encode(array("visitor_details"=>$vp_dts));
	}
	
	public function booking_list_by_creteria()
	{
		$booking_list=$this->Guesthouse_model->get_booking_list($_POST);
		echo json_encode(array("booking_list"=>$booking_list));
	}
	
	
	public function check_availability()
    {  //error_reporting(E_ALL);
        $this->load->view('header',$this->data);
		$this->data['get_beds_available_gh']=$this->Guesthouse_model->get_guesthouse_details();
        $this->load->view($this->view_dir.'gh_availability',$this->data);
        $this->load->view('footer');
    }
	
	public function booking_list()
    {
        $this->load->view('header',$this->data);
		$this->data['guesthouse_details']=$this->Guesthouse_model->get_guesthouse_details();
		$this->data['booking_list']=$this->Guesthouse_model->get_booking_list();
        $this->load->view($this->view_dir.'booking_list',$this->data);
        $this->load->view('footer');
    }
	
	public function challan_pdf(){
		
		 $this->load->view('header',$this->data);
		$this->data['guesthouse_details']=$this->Guesthouse_model->get_guesthouse_details();
		//$this->data['booking_list']=$this->Guesthouse_model->get_booking_list();
        $this->load->view($this->view_dir.'booking_list',$this->data);
        $this->load->view('footer');
	}
	
	public function download_challan_pdf()
	{
		//load mPDF library
        $id=$this->uri->segment(3);
		
		
		$std_challan_details=$this->Guesthouse_model->fees_challan_list_byid($id);
		 
		 
		 $this->data['std_challan_details']= $std_challan_details;
		
		
		
		//$this->load->model('Ums_admission_model');
		//$param = '"en-GB-x","A4","","",0,0,0,0,-10,-10,P';
		//echo $hgp_id.','.$stud_prn.','.$stud_org;exit();
		$this->load->library('m_pdf', $param);
		
		
//$this->load->view($this->view_dir.'facility_challan_pdf', $this->data);

		 $html = $this->load->view($this->view_dir.'guesthouse_challan_pdf', $this->data, true);
	//	exit;
		$pdfFilePath = $this->data['std_challan_details'][0]['Booking_id']."_guesthouse_challan_pdf.pdf";

		//$mpdf->WriteHTML($stylesheet,1);
		//$this->m_pdf->pdf->WriteHTML($stylesheet,1);
		
		//$this->m_pdf->pdf=new mPDF('L','A4-L','','5',5,5,5,5,5,5);
		$this->m_pdf->pdf->AddPage('L', // L - landscape, P - portrait
            '', '', '', '',
            5, // margin_left
            5, // margin right
            5, // margin top
            5, // margin bottom
            5, // margin header
            5); // margin footer
		$this->m_pdf->pdf->WriteHTML($html);
		//download it.
		$this->m_pdf->pdf->Output($pdfFilePath, "D");
		
		// ob_end_flush(); 
		
	}
	
	
	
	public function dashboard()
	{
		//error_reporting(E_ALL);
		$this->load->view('header',$this->data);
		$this->data['guesthouse_details']=$this->Guesthouse_model->get_guesthouse_details();
		$arr['daywise']=date('Y-m-d');
		$this->data['dashboard_details']=$this->Guesthouse_model->dashboard($arr);
        $this->load->view($this->view_dir.'dashboard',$this->data);
        $this->load->view('footer');
	}
	
	public function dashboard_details_by_id()
	{
		$dashboard_details=$this->Guesthouse_model->dashboard($_POST);
		//echo json_encode(array("dashboard_details"=>$dashboard_details));
		foreach ($dashboard_details as $key => $value) { 
	
					echo '<div class="row details" >
<div class="col-md-2" style="padding:10px;text-align:center;">
<div class="hostel-logo"><br/><b>'.$value['campus'].'</b><br/><b>'.$value['guesthouse_name'].'</b></div>
<h4>Room No. ';
 echo $value['room_no'];
 echo '</h4>
</div>
<div class="col-md-7 col-sm-4">
<div class="row">
<div class="col-md-9 col-xs-9 "><h4>'.$value['visitor_name'].'</h4></div><div class="col-md-3 col-xs-3 ">&nbsp;&nbsp;';
 if($value['current_status']=='CHECK-IN'){
					$bc = 'style="color:orange;"';
				}elseif($value['current_status']=='CANCELLED'){
                     $bc = 'style="color:red;"';
				}elseif($value['current_status']=='CHECK-OUT'){
					$bc = 'style="color:blue;"';
				}else{
					$bc = 'style="color:green;"';
				} 
echo '<span '.$bc.' ><b>'.$value['current_status'].'</b></span></div>
</div>
<h6>'.$value['address'].',&nbsp;&nbsp;'.$value['state_name'].',&nbsp;&nbsp;'.$value['taluka_name'].'</h6>
<h6><b>'.$value['id_proof'].':</b> '.$value['id_ref_no'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b>Pin Code : </b>'.$value['pincode'].'</h6>
<h5>Charge: ';
 if($value['charges']!=' '){ 
 echo ' Rs. '.$value['charges'].'/- ';
  }else{ 
  echo ' -- ';
   } 
   echo '</h4>
<h5><b>Booking Date : ';
 if($value['proposed_in_date']!=''){  echo date('d M Y H:i',strtotime($value['proposed_in_date'])); } 
 echo '&nbsp; TO &nbsp;'; 
 if($value['proposed_out_date']!=''){  echo date('d M Y H:i',strtotime($value['proposed_out_date'])); } 
 echo ' &nbsp;&nbsp;&nbsp;&nbsp; Days: '.$value['no_of_days'].' &nbsp;&nbsp;&nbsp;&nbsp; Bed No.: '.$value['bed_no'].'</b></h4>

</div>
<div class="col-md-3 mg-tp">
<div class="col-md-6 col-xs-6 border-rgt">
<h6>CHECK-IN</h6>
<h3>';
 if($value['checkin_on']!='') { echo date('d',strtotime($value['checkin_on'])); } 
 echo '</h3>
<h5><b>'; if($value['checkin_on']!='') { echo date('F',strtotime($value['checkin_on'])); } 
echo '</b></h5>
<h6>'; if($value['checkin_on']!='') { echo date('l',strtotime($value['checkin_on'])); } 
echo '</h6>
</div>

<div class="col-md-6 col-xs-6">
<h6>CHECK-OUT</h6>
<h3>'; if($value['checkin_out']!='') { echo date('d',strtotime($value['checkin_out'])); } echo '</h3>
<h5><b>';
if($value['checkin_out']!='') { echo date('F',strtotime($value['checkin_out'])); } echo '</b></h5>
<h6>'; if($value['checkin_out']!='') { echo date('l',strtotime($value['checkin_out'])); } echo '</h6>
</div>
</div>
</div>';

 } 

	}
		
	public function add_guesthouse()
	{
		$this->load->view('header',$this->data);
		$get_distinct_hostel=$this->Guesthouse_model->get_all_hostel_allocated();
		
		foreach($get_distinct_hostel as $val){
			$hostel_details=explode('_',$val['hostel']);
			$hostelslist[]=$hostel_details[1];
		}
		//$this->data['hostel_details']=$this->Guesthouse_model->get_hostel_details($hostelslist,$_POST);
		
		$this->data['hostel_details']=$this->Guesthouse_model->get_hostel_details();
		$this->load->view($this->view_dir.'add_guesthouse_details',$this->data);
        $this->load->view('footer');
	}
	public function get_campus_hostel_list(){
		$camp=$_REQUEST['camp'];
		
		$hostel_details =$this->Guesthouse_model->get_hostel_details('',$camp);
		 echo '<option value="">Select hostel</option>';
foreach ($hostel_details as $key => $hostel) {
	 echo '<option value="'.$hostel['host_id'].'">'.$hostel['hostel_name'].'</option>'; 
}

	}
	public function get_room_details(){
		$arr['camp']= $_REQUEST['camp'];
		$arr['host']=$_REQUEST['host'];
		$arr['rm']=$_REQUEST['rm'];
		$rmdet = $this->Guesthouse_model->get_room_details_hostel($arr);
		echo $rmdet[0]['hostel_code']."_".$rmdet[0]['no_of_beds']."_".$rmdet[0]['floor_no'];

	}
	public function get_rooms_detailsbyhid()
	{
		/* SELECT `sfhrd`.`sf_room_id`, `sfhrd`.`room_no`, `sfhrd`.`host_id`, `sfhrd`.`hostel_code`, `sfhrd`.`floor_no`, `sfhrd`.`no_of_beds` as `numbeds`, `sfhrd`.`bed_number`, `sfhrd`.`room_type`, `sfhrd`.`category`, `sfhrd`.`is_active`, `sfhm`.*
		FROM `sf_hostel_room_details` as `sfhrd`
		JOIN `sf_hostel_master` as `sfhm` ON `sfhm`.`hostel_code` = `sfhrd`.`hostel_code`
		WHERE `sfhrd`.`category` = 'Guest House'
		AND `sfhrd`.`host_id` = '1'
		GROUP BY `floor_no`, CAST(`room_no` AS SIGNED) */
		$get_all_rooms_byhid=$this->Guesthouse_model->get_guesthouse_details();
		
		foreach($get_all_rooms_byhid as $val){
			$hostel_details=explode('_',$val['location']);
			if($hostel_details[1]==$_POST['host_id'])
			{$roomslist[]=$hostel_details[2];}
		}
		
		$rm_dts=$this->Guesthouse_model->get_rooms_detailsbyhid($roomslist,$_POST);
		echo json_encode(array("rm_dts"=>$rm_dts));
	}
	
	
	public function guesthouse_report()
	{
		$this->load->view('header',$this->data);  
		$this->data['guesthouse_details']=$this->Guesthouse_model->get_guesthouse_details();
		$this->load->view($this->view_dir.'guesthouse_report',$this->data);
        $this->load->view('footer');
	}
	
	public function book_guesthouse()
	{
		$this->load->view('header',$this->data);
		$this->data['existed_visitors']=$this->Guesthouse_model->visitors_master();
		$this->data['get_beds_available_gh']=$this->Guesthouse_model->get_beds_available_gh();
		$this->data['state']=$this->Guesthouse_model->getAllState();
		$this->load->view($this->view_dir.'add_visitor',$this->data);
        $this->load->view('footer');
	}
	
	public function get_ghouse_list_by_creteria()
	{
		//$this->data['get_beds_available_gh']=$this->Guesthouse_model->get_ghouse_list_by_creteria($_POST);
		if($_POST['gtype']!='')
		{
			$gtype=$_POST['gtype'];

		}
		else
		{
			$gtype='';

		}
		$a['campus']=$_POST['campus'];
		$a['host_typ']=$gtype;
		$a['g_id']=$_REQUEST['g_id'];
	
		$this->data['get_beds_available_gh']=$this->Guesthouse_model->get_guesthouse_details_individual($a);
		
		$this->data['no_of_person']=$_POST['nperson'];
		$this->data['fdate']=$_POST['cin'];
		$this->data['tdate']=$_POST['cout'];
		echo $this->load->view($this->view_dir.'search_avalability_of_room',$this->data,true);
		
		//echo json_encode(array("ghouse_list"=>$ghouse_list));
	}
	
	public function check_guesthouse_exists()
	{
		echo $this->Guesthouse_model->check_guesthouse_exists($_POST);
	}
	
	public function check_guesthouse_beds_remaining()
	{
		$details= $this->Guesthouse_model->check_guesthouse_beds_remaining($_POST);
		if(!empty($details))
			echo $details[0]['count'];
		else
			echo 0;
	}
	
	public function add_guesthouse_submit()
	{
		if($_POST['ghl']=='H')
		$loc=$_POST['ghl'].'_'.$_POST['hostel'].'_'.$_POST['room'];
	else
		$loc='T';

	if($_POST['ghl']=='T'){
		if($_POST['doubel_bed']!='0'){
		$number = range(1,$_POST['doubel_bed']);
	$st = implode(",", $number);
}else{
$st ='';
	}
	$rmn = $_POST['roomt'];

}else{
	$rmn = $_POST['room'];
}
		$insert_array=array("campus"=>$_POST['campus'],"guesthouse_name"=>$_POST['gname'],"bed_capacity"=>$_POST['capacity'],"guesthouse_type"=>$_POST['gtype'],"location"=>$loc,"bed_available"=>$_POST['capacity'],"room_no"=>$rmn,"floor"=>$_POST['floor'],"is_reserved"=>'NO',"current_status"=>'AVAILABLE',"doubel_bed"=>$st,"entry_by"=>$this->session->userdata("uid"),"entry_on"=>date("Y-m-d H:i:s"),"is_active"=>"Y"); 
		//var_dump($insert_array);exit();
        $last_inserted_id= $this->Guesthouse_model->add_guesthouse_submit($insert_array);
		if($last_inserted_id)
			$this->session->set_flashdata('message1','Guest House Details Added Successfully.');
		else
			$this->session->set_flashdata('message2','Guest House Details Not Added Successfully.');
        redirect(base_url($this->view_dir.'view_guesthouse'));
	}
	
	public function edit_guesthouse()
    {
		$id=$this->uri->segment(3);
        $this->load->view('header',$this->data);
		$this->data['hostel_details']=$this->Guesthouse_model->get_hostel_details();
		$this->data['guesthouse_details']=array_shift($this->Guesthouse_model->get_guesthouse_details($id));
        $this->load->view($this->view_dir.'edit_guesthouse_details',$this->data);
        $this->load->view('footer');
    }
	
	public function edit_guesthouse_submit()
	{
		//if($_POST['ghl']=='H')
		//$loc=$_POST['ghl'].'_'.$_POST['hostel'].'_'.$_POST['room'];
	//else
		//$loc='T';
		$id=$this->uri->segment(3);

		if($_POST['sghl']=='T'){
			if($_POST['doubel_bed']!='0'){
		$number = range(1,$_POST['doubel_bed']);
	$st = implode(",", $number);
}else{
$st ='';
	}
	
}
//print_r($st);exit;
		$update_array=array("guesthouse_name"=>$_POST['gname'],"bed_capacity"=>$_POST['capacity'],"bed_available"=>$_POST['capacity'],"doubel_bed"=>$st,"modified_by"=>$this->session->userdata("uid"),"modified_on"=>date("Y-m-d H:i:s"),"is_active"=>$_POST['status']); 
		//"bed_available"=>$_POST['capacity'],"is_reserved"=>'NO',"current_status"=>'AVAILABLE',
		//var_dump($insert_array);exit();
        $last_inserted_id= $this->Guesthouse_model->edit_guesthouse_submit($update_array,$id);
		if($last_inserted_id)
			$this->session->set_flashdata('message1','Guest House Details Updated Successfully.');
		else
			$this->session->set_flashdata('message2','Guest House Details Not Updated Successfully.');
        redirect(base_url($this->view_dir.'view_guesthouse'));
	}
	
	public function checkincheckout()
	{
		$id=$this->uri->segment(3);
		$this->load->view('header',$this->data);
		$this->data['visitor_details']=array_shift($this->Guesthouse_model->guesthouse_checkincheckout($id));
		$this->data['selected_guesthouse']=$this->Guesthouse_model->selected_guesthouse($id);
		$this->data['get_beds_available_gh']=$this->Guesthouse_model->get_beds_available_gh();
		$this->data['bank_details']= $this->Challan_model->getbanks();
		$this->load->view($this->view_dir.'checkin_checkout',$this->data);
        $this->load->view('footer');
	}
	function message_api($mobile,$content){
	 
				//$mob = mysql_real_escape_string($_POST['mobile_official']);
				/*echo $content="Test from controller
	Date". date('Y-m-d h:i:s')."  TimeZone-". date_default_timezone_get();*/
	            $test = NEW Message_api();
				$test->send_sms($mobile,$content);
	}
	public function guesthouse_checkincheckout()
	{
		$visitor_details=$this->Guesthouse_model->guesthouse_checkincheckout($_POST);
		echo json_encode(array("visitor_details"=>$visitor_details));
	}
	
	public function guesthouse_count_details()
	{
		$guesthouse_details=$this->Guesthouse_model->guesthouse_count_details($_POST);
		echo json_encode(array("guesthouse_details"=>$guesthouse_details));
	}
		
	public function add_visitor_submit()
	{
		//print_r($_FILES);
		//error_reporting(E_ALL);
		if($_POST['htype']=='h'){
if(!empty($_FILES['file_up']['name'])){
			$filenm= date('H_i_s').'-'.$_FILES['file_up']['name'];
			$config['upload_path'] = 'uploads/guesthouse/';
			$config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
			$config['overwrite']= False;
			$config['max_size']= "5048000";
			//$config['file_name'] = $_FILES['profile_img']['name'];
			$config['file_name'] = $filenm;

			//Load upload library and initialize configuration
			$this->load->library('upload',$config);
			$this->upload->initialize($config);

			if($this->upload->do_upload('file_up')){
				$uploadData = $this->upload->data();
				$payfile = $uploadData['file_name'];
				//echo 'yfuyfguy==='.$payfile;exit();
			}else{
				$payfile = '';
			}
		}
		else{
			$payfile = '';
		}
}
//echo $payfile;
	//	exit;
		$last_visitor_id=0;
		//for visitor master details
		if(isset($_POST['vid']) && !empty($_POST['vid']))
		{
			$last_visitor_id=$_POST['vid'];
			$update_array=array("visitor_name"=>$_POST['vname'],"gender"=>$_POST['gender'],"mobile"=>$_POST['mobile'],"email"=>$_POST['email'],"address"=>$_POST['address'],"id_proof"=>$_POST['pref'],"id_ref_no"=>$_POST['pno'],"proof_scan_img"=>$payfile,"pincode"=>$_POST['pincode'],"city"=>$_POST['hcity'],"district"=>$_POST['hdistrict_id'],"state"=>$_POST['hstate_id'],"modified_by"=>$this->session->userdata("uid"),"modified_on"=>date("Y-m-d H:i:s")); 
			//echo '<br/>update_array: <br/>\n';
			//var_dump($update_array);//exit();
			$rowsaffected= $this->Guesthouse_model->edit_visitmaster_submit($update_array,$_POST['vid']);
		}
		else
		{
			$insert_array=array("visitor_name"=>$_POST['vname'],"gender"=>$_POST['gender'],"mobile"=>$_POST['mobile'],"email"=>$_POST['email'],"address"=>$_POST['address'],"id_proof"=>$_POST['pref'],"id_ref_no"=>$_POST['pno'],"proof_scan_img"=>$payfile,"approved_by"=>$_POST['app_by'],"approved_mob_no"=>$_POST['amob_no'],"pincode"=>$_POST['pincode'],"city"=>$_POST['hcity'],"district"=>$_POST['hdistrict_id'],"state"=>$_POST['hstate_id'],"entry_by"=>$this->session->userdata("uid"),"entry_on"=>date("Y-m-d H:i:s")); 
			//echo '<br/><br/>insert_array: <br/>\n';
			//var_dump($insert_array);exit();
			$last_inserted_id= $this->Guesthouse_model->add_visitmaster_submit($insert_array);
			$last_visitor_id=$last_inserted_id;
		}
		
		//for visitor details
		if($_POST['htype']=='t'){

$inst_array=array("v_id"=>$last_visitor_id,"proposed_in_date"=>date("Y-m-d H:i:s", strtotime($_POST['pindate']." ".$_POST['chk_in_time'])),"proposed_out_date"=>date("Y-m-d H:i:s", strtotime($_POST['poutdate']." ".$_POST['chk_out_time'])),"no_of_days"=>$_POST['nod'],"no_of_person"=>$_POST['nop'],"reference_of"=>$_POST['ref'],"visiting_purpose"=>$_POST['purpose'],"room_allocated"=>'Y',"current_status"=>'BOOKING-DONE',"booking_typ"=>$_POST['htype'],"entry_by"=>$this->session->userdata("uid"),"entry_on"=>date("Y-m-d H:i:s")); 

		}else{

		$inst_array=array("v_id"=>$last_visitor_id,"proposed_in_date"=>date("Y-m-d H:i:s", strtotime($_POST['pindate']." ".$_POST['chk_in_time'])),"proposed_out_date"=>date("Y-m-d H:i:s", strtotime($_POST['poutdate']." ".$_POST['chk_out_time'])),"no_of_days"=>$_POST['nod'],"no_of_person"=>$_POST['nop'],"reference_of"=>$_POST['ref'],"visiting_purpose"=>$_POST['purpose'],"room_allocated"=>'Y',"current_status"=>'BOOKING-DONE',"is_chargeble"=>$_POST['ischrg'],"charges"=>$_POST['chrg'],"booking_typ"=>$_POST['htype'],"entry_by"=>$this->session->userdata("uid"),"entry_on"=>date("Y-m-d H:i:s")); 
	}
			//"room_allocated"=>$_POST['pno']
			//echo '<br/><br/>inst_array: <br/>\n';
		//var_dump($inst_array);//exit();
		$last_inserted_id1= $this->Guesthouse_model->add_visitordetails_submit($inst_array);
		//echo $this->db->last_qury();exit;
		//for visit room details
		$insrt_array = array();
		$nop = $this->input->post("nop");//exit;
		if(!empty($nop))
		{
			for($i = 0; $i < $nop; $i++)
			{
				$ghouse=explode('||',$_POST['ghouse'][$i]);
				$insrt_array[$i]=array("booking_id"=>$last_inserted_id1,"visitor_name"=>$_POST['vpname'][$i],"mobile"=>$_POST['vpmobile'][$i],"gh_id"=>$ghouse[0],"bed_no"=>$_POST['ghousebed'][$i],"current_status"=>'BOOKING-DONE',"entry_by"=>$this->session->userdata("uid"),"entry_on"=>date("Y-m-d H:i:s"));
				
				//$updt_array=array("bed_available"=>($ghouse[1]--),"gh_id"=>$ghouse[0],"current_status"=>'FULL');
			}
			//echo '<br/><br/>insrt_array: <br/>\n';
			//var_dump($insrt_array);echo '</br>\n';//exit();
			$last_inserted_id2=$this->Guesthouse_model->add_individual_visitor_ghouse_details($insrt_array);
		}
		
		//below is the code for updating remain_bed_available of correspond guesthouse
		$gh_update_array = array();
		//echo 're==='.$_POST['remain_bed_available'];exit;
		if($_POST['remain_bed_available']!='')
		{
			$ghouse_details=explode("[]",$_POST['remain_bed_available']);
			
			for($i = 0; $i < count($ghouse_details); $i++){
				//echo 'ghouse_details='.$ghouse_details[$i];
				$ghid_beds=explode("=",$ghouse_details[$i]);
				$gh=explode("_",$ghid_beds[0]);
				$ghid=$gh[0];
				$selcted_bed_cnt=$ghid_beds[1];
				$actual_bed=$gh[2];
				//echo '</br>'.$actual_bed.'check'.$selcted_bed_cnt;
				$remain_beds=(int)((int)$actual_bed - (int)$selcted_bed_cnt);
				
				if($remain_beds==0)$status='FULL';else $status='AVAILABLE';
				$gh_update_array[$i]=array("gh_id"=>$ghid,"bed_available"=>$remain_beds,"current_status"=>$status,"modified_by"=>$this->session->userdata("uid"),"modified_on"=>date("Y-m-d H:i:s"));
				//}
			}
			$updated_id2=$this->Guesthouse_model->update_ghouse_available_bed_details($gh_update_array);
		}
		/* echo '</br>';
		var_dump($gh_update_array);
		exit(); */
		if($last_inserted_id2){
		/* $test = NEW Message_api();
		 $content="Hello ".$_POST['vname'];
		 $content .="Your Booking has Been Confirmed. Your Booking Id is #".$last_inserted_id;
		 $content .="From".$_POST['pindate']." To ".$_POST['poutdate']." Your Hostel Name ".$ghouse[0];
		 $content .="Thank You";
		 $test->send_sms($_POST['mobile'],$content);*/
		 
		$this->session->set_flashdata('message1','Guest House Booked Successfully.');
		redirect(base_url($this->view_dir.'booking_list'));
			
		}else{
			exit;
			$this->session->set_flashdata('message2','Guest House Not Booked Successfully.');
			//redirect(base_url($this->view_dir.'booking_list'));
		}
	}
	
	public function update_visitor_submit()
	{
		//for visitor master table
		//echo '<pre>';print_r($_POST);exit;
		$update_array=array("visitor_name"=>$_POST['vname'],"gender"=>$_POST['gender'],"mobile"=>$_POST['mobile'],"email"=>$_POST['email'],"address"=>$_POST['address'],"id_proof"=>$_POST['pref'],"id_ref_no"=>$_POST['pno'],"approved_by"=>$_POST['app_by'],"approved_mob_no"=>$_POST['amob_no'],"pincode"=>$_POST['pincode'],"city"=>$_POST['hcity'],"district"=>$_POST['hdistrict_id'],"state"=>$_POST['hstate_id'],"modified_by"=>$this->session->userdata("uid"),"modified_on"=>date("Y-m-d H:i:s")); 
		$rowsaffected= $this->Guesthouse_model->edit_visitmaster_submit($update_array,$_POST['vid']);
		
		//for visitor details table
		$update_visit=array("proposed_in_date"=>date("Y-m-d H:i:s", strtotime($_POST['pindate']." ".$_POST['chk_in_time'])),"proposed_out_date"=>date("Y-m-d H:i:s", strtotime($_POST['poutdate']." ".$_POST['chk_out_time'])),"no_of_days"=>$_POST['nod'],"no_of_person"=>$_POST['nop'],"reference_of"=>$_POST['ref'],"visiting_purpose"=>$_POST['purpose'],"room_allocated"=>'Y',"is_chargeble"=>$_POST['ischrg'],"charges"=>$_POST['chrg'],"modified_by"=>$this->session->userdata("uid"),"modified_on"=>date("Y-m-d H:i:s")); //"current_status"=>'BOOKING-DONE',
		
		$last_inserted_id1= $this->Guesthouse_model->update_visitordetails_submit($update_visit,$_POST['visit_id']);
		
		//for visit room details
		$insrt_array = array();
		$update_visit_room = array();
		$nop = $this->input->post("nop");
		if(!empty($nop))
		{
			$z=0;
			for($i = 0; $i < $nop; $i++)
			{
				$ghouse=explode('_',$_POST['ghouse'][$i]);
				if($_POST['vr_id'][$i]!='')
				{
					$update_visit_room[$i]=array("vr_id"=>$_POST['vr_id'][$i],"visitor_name"=>$_POST['vpname'][$i],"mobile"=>$_POST['vpmobile'][$i],"gh_id"=>$ghouse[0],"bed_no"=>$_POST['ghousebed'][$i],"modified_by"=>$this->session->userdata("uid"),"modified_on"=>date("Y-m-d H:i:s"));//"current_status"=>'BOOKING-DONE',
				}
				else
				{
					
					$insrt_array[$i]=array("booking_id"=>$_POST['visit_id'],"visitor_name"=>$_POST['vpname'][$i],"mobile"=>$_POST['vpmobile'][$i],"gh_id"=>$ghouse[0],"bed_no"=>$_POST['ghousebed'][$i],"entry_by"=>$this->session->userdata("uid"),"entry_on"=>date("Y-m-d H:i:s"));//"current_status"=>'BOOKING-DONE',
					$z++;
				}
			}
			//var_dump($update_visit_room);echo '</br></br></br>\nfff';
			//var_dump($insrt_array);echo '</br>\n';
			//exit();
			
			$last_udated=$this->Guesthouse_model->update_existed_visitor_ghouse_details($update_visit_room);
			if(count($insrt_array)>0){
			
			$last_inserted_id2=$this->Guesthouse_model->add_individual_visitor_ghouse_details($insrt_array);
		}
		}
		
		//below is the code for updating remain_bed_available of correspond guesthouse
		$gh_update_array = array();
		//echo 'rrr='.$_POST['remain_bed_available'];
		if($_POST['remain_bed_available']!='')
		{
			$ghouse_details=explode("[]",$_POST['remain_bed_available']);
			//echo '</br>cnt==='.count($ghouse_details);
			for($i = 0; $i < count($ghouse_details); $i++){
				//echo 'ghouse_details='.$ghouse_details[$i];
				$ghid_beds=explode("=",$ghouse_details[$i]);
				$gh=explode("_",$ghid_beds[0]);
				$ghid=$gh[0];
				$selcted_bed_cnt=$ghid_beds[1];
				$actual_bed=$gh[2];
				//echo '</br>'.$actual_bed.'check'.$selcted_bed_cnt;
				$remain_beds=(int)((int)$actual_bed - (int)$selcted_bed_cnt);
				
				if($remain_beds==0)$status='FULL';else$status='AVAILABLE';
				$gh_update_array[$i]=array("gh_id"=>$ghid,"bed_available"=>$remain_beds,"current_status"=>$status,"modified_by"=>$this->session->userdata("uid"),"modified_on"=>date("Y-m-d H:i:s"));
				//}
			}
			
			$updated_id2=$this->Guesthouse_model->update_ghouse_available_bed_details($gh_update_array);
		}
		/* echo '</br>';
		var_dump($gh_update_array); */
		
		
		$gh_update_array1 = array();
		if($_POST['remain_bed_available1']!='')
		{
			$ghouse_details1=explode("[]",$_POST['remain_bed_available1']);
			//echo '</br>conut==='.count($ghouse_details1);
			for($i = 0; $i < count($ghouse_details1); $i++){
				echo 'ghouse_details1='.$ghouse_details1[$i];
				$ghid_beds=explode("=",$ghouse_details1[$i]);
				$gh=explode("_",$ghid_beds[0]);
				$ghid=$gh[0];
				$actual_bed=$gh[2];
				//echo '</br>'.$actual_bed.'check'.$selcted_bed_cnt;
				$remain_beds1=(int)((int)$actual_bed);
				
				if($remain_beds1==0)$status='FULL';else$status='AVAILABLE';
				$gh_update_array1[$i]=array("gh_id"=>$ghid,"bed_available"=>$remain_beds1,"current_status"=>$status,"modified_by"=>$this->session->userdata("uid"),"modified_on"=>date("Y-m-d H:i:s"));
				//}
			}
			
			$updated_id23=$this->Guesthouse_model->update_ghouse_available_bed_details($gh_update_array1);
		}
		
		/* echo '</br>';
		var_dump($gh_update_array1);
		exit(); */
		
		if($last_inserted_id1 || $updated_id2 || $last_udated || $last_inserted_id2){
			$this->session->set_flashdata('message1','Detail updated Successfully.');
			 redirect(base_url($this->view_dir.'booking_list'));
		}
		else{
			$this->session->set_flashdata('message2','Detail not updated  Successfully.');
		
        redirect(base_url($this->view_dir.'edit_booking_details/'.$_POST['visit_id']));
		}
	}
	
	public function get_guesthouse_report()
    {   
        // error_reporting(E_ALL);
		//ini_set('display_errors', 1);
         $this->data['report']=$_POST['report'];
         $this->data['selectby']=$_POST['selectby'];
         $this->data['daywise']=$_POST['daywise'];
         $this->data['fdate']=$_POST['fdate'];
		 $this->data['tdate']=$_POST['tdate'];
		 $this->data['campus']=$_POST['campus'];
           
        if($_POST['report']=="1")
        {
             $this->data['details']=$this->Guesthouse_model->get_booked_ghouses($this->data);
           
             if($_POST['act']=="view"){
                 $this->load->view($this->view_dir.'gh_report',$this->data);
             }
             else{
                 $this->load->view($this->view_dir.'excel_details',$this->data);
                 $this->session->set_flashdata('excelmsg', 'download');
             }

        }
        else if($_POST['report']=="2") 
        {
            $this->data['get_by']="";
            $this->data['details']=$this->Guesthouse_model->get_visitors($this->data);
            if($_POST['act']=="view"){
				 $this->load->view($this->view_dir.'gh_report',$this->data);
             }
             else{
                $this->load->view($this->view_dir.'excel_details',$this->data);
                 $this->session->set_flashdata('excelmsg', 'download');
             }
        }
         /* else if($_POST['report']=="3")
        {
             $this->data['get_by']="";
             $this->data['details']=$this->Guesthouse_model->get_visitor_rooms($this->data);
              if($_POST['act']=="view"){
                   $this->load->view($this->view_dir.'gh_report',$this->data);
             }
             else{
                 $this->load->view($this->view_dir.'excel_details',$this->data);
                  $this->session->set_flashdata('excelmsg', 'download');
             }
        } */
        else if($_POST['report']=="4")
        { 
             $this->data['get_by']="";
             $this->data['details']=$this->Guesthouse_model->get_visitor_history($_POST);
            if($_POST['act']=="view"){
                 $this->load->view($this->view_dir.'gh_report',$this->data);
             }
             else{
                $this->load->view($this->view_dir.'excel_details',$this->data);
                 $this->session->set_flashdata('excelmsg', 'download');
             }
        }
        else if($_POST['report']=="5")
        { 
            
             $this->data['get_by']="";
             $this->data['details']=$this->Guesthouse_model->get_ghouse_history($_POST);
            if($_POST['act']=="view"){
                 $this->load->view($this->view_dir.'gh_report',$this->data);
             }
             else{
                $this->load->view($this->view_dir.'excel_details',$this->data);
                 $this->session->set_flashdata('excelmsg', 'download');
             }
        }
	}
	
	public function update_checkin()
	{
		//print_r($_REQUEST);
		//exit;
		$id=$this->uri->segment(3);
		//var_dump($_POST['vr_id']);
		//var_dump($_POST['remain_bed_available']);exit();
		if(isset($_POST['remain_bed_available']) && $_POST['remain_bed_available']!='')
		{
			//below is the code for updating remain_bed_available of correspond guesthouse
			$gh_update_array = array();
			//echo 're==='.$_POST['remain_bed_available'];
			$ghouse_details=explode("[]",$_POST['remain_bed_available']);
			
			for($i = 0; $i < count($ghouse_details); $i++){
				//echo 'ghouse_details='.$ghouse_details[$i];
				$ghid_beds=explode("=",$ghouse_details[$i]);
				$gh=explode("_",$ghid_beds[0]);
				$ghid=$gh[0];
				$selcted_bed_cnt=$ghid_beds[1];
				$actual_bed=$gh[2];
				//echo '</br>'.$actual_bed.'check'.$selcted_bed_cnt;
				$remain_beds=(int)((int)$actual_bed - (int)$selcted_bed_cnt);
				
				if($remain_beds==0)$status='FULL';else$status='AVAILABLE';
				$gh_update_array[$i]=array("gh_id"=>$ghid,"bed_available"=>$remain_beds,"current_status"=>$status,"modified_by"=>$this->session->userdata("uid"),"modified_on"=>date("Y-m-d H:i:s"));
				
				$gh_update[$i]=array("gh_id"=>$ghid,"vr_id"=>$_POST['vr_id'][$i]);
				
				//}
			}
			//var_dump($gh_update);
			//echo '</br>';echo '</br>';
			//var_dump($gh_update_array);
		//exit();
			$update_id=$this->Guesthouse_model->update_ghouse_details_atcheckin($gh_update);
			
			$updated_id2=$this->Guesthouse_model->update_ghouse_available_bed_details($gh_update_array);
			
		}
		//exit();
		    $checkin['mode_of_payment']=$_REQUEST['epayment_type'];
			$checkin['pay_amount']=$_REQUEST['amt'];
			$checkin['balance']=$_REQUEST['Pendingamt'];
		    $checkin['receipt_no']=$_REQUEST['receipt_number'];
			$checkin['receipt_date']=$_REQUEST['fees_date'];
			$checkin['Bank_Name']=$_REQUEST['bank'];
			$checkin['Bank_Branch']=$_REQUEST['branch'];
			$checkin['Remark']=$_REQUEST['Remark'];
			$checkin['Deposite_bank']='1';
			
		$flag=$this->Guesthouse_model->update_checkin($id,$checkin);
		if($flag)
		{
			
		$visitor_details=($this->Guesthouse_model->guesthouse_checkincheckout($id));
			
			foreach($visitor_details as $val){
				
				$data['Guest_House']=$val['guesthouse_name'];
				//location=$val['location'];
				//v_id=$val['v_id'];
				
				$data['Name']=$val['visitor_name'];
				$data['Mobile']=$val['mobile'];
				$data['Email']=$val['email'];
				$data['Booking_id']=$val['booking_id'];
				$data['No_Days']=$val['no_of_days'];
				//proposed_in_date=$val['proposed_in_date'];
				//proposed_out_date=$val['proposed_out_date'];
				$data['No_Person']=$val['no_of_person'];
				$data['charges']=$val['charges'];
				
				$data['Out_Date']=$val['proposed_out_date'];
				$data['In_Date']=$val['checkin_on'];
				
				
			}
			
			
            $challan_digits=5;
			$data['Paid_charge']=$_REQUEST['amt'];
			$data['Balance']=$_REQUEST['Pendingamt'];
			if(!empty($_REQUEST['Pendingamt'])){
			$data['Balance_status']='Y';
			}
			$data['mode_of_payment']=$_REQUEST['epayment_type'];
			$data['receipt_no']=$_REQUEST['receipt_number'];
			$data['receipt_date']=$_REQUEST['fees_date'];
			$data['Bank_Name']=$_REQUEST['bank'];
			$data['Bank_Branch']=$_REQUEST['branch'];
			$data['Remark']=$_REQUEST['Remark'];
			$data['Deposite_bank']='1';
			$data['current_date']=date('Y-m-d');
			$data['create_by']=$this->session->userdata("uid");
			$data['create_date']=date("Y-m-d H:i:s");
			//$challan_no='19GH'.$addmision_type.$month_session.str_pad( $last_inserted_id, $challan_digits, "0", STR_PAD_LEFT );
			//$data['challan_No']
			$data['enter_ip']=$_SERVER['REMOTE_ADDR'];
			
			$last_inserted_id=$this->Guesthouse_model->Insert_challan($data);
            if($last_inserted_id){
            if($last_inserted_id>9999)
			{
				$challan_digits=strlen($last_inserted_id);
			}
            
            $current=date('ymd');
            $up_ch['challan_No']='19GH'.$current.str_pad( $last_inserted_id, $challan_digits, "0", STR_PAD_LEFT);
            $last_inserted_id=$this->Guesthouse_model->update_challan($last_inserted_id,$up_ch);	
			
			}
			
			$this->session->set_flashdata('message1','Visitor checked In Successfully.');
			redirect(base_url($this->view_dir.'booking_list'));
		}
		else
		{
			$this->session->set_flashdata('message2','Visitor Not checked In Successfully.');
			redirect(base_url($this->view_dir.'booking_list'));
		}
	}
	
	public function update_checkout()
	{
		$id=$this->uri->segment(3);
		$gh_update_array = array();
		
		$ghouse_details=explode("[]",$_POST['remain_bed_available']);
		
		for($i = 0; $i < count($ghouse_details); $i++){
			//echo 'ghouse_details='.$ghouse_details[$i];
			$ghid_beds=explode("=",$ghouse_details[$i]);
			$gh=explode("_",$ghid_beds[0]);
			$ghid=$gh[0];
			$selcted_bed_cnt=$ghid_beds[1];
			$actual_bed=$gh[2];
			//echo '</br>'.$actual_bed.'check'.$selcted_bed_cnt;
			$remain_beds=(int)((int)$actual_bed + (int)$selcted_bed_cnt);
			
			if($remain_beds==0)$status='FULL';else$status='AVAILABLE';
			
			$gh_update_array[$i]=array("gh_id"=>$ghid,"bed_available"=>$remain_beds,"current_status"=>$status,"modified_by"=>$this->session->userdata("uid"),"modified_on"=>date("Y-m-d H:i:s"));
		}
		$updated_id2=$this->Guesthouse_model->update_ghouse_available_bed_details($gh_update_array);
		   // $checkin['mode_of_payment']=$_REQUEST['epayment_type'];
			$checkin['pay_amount']=$_REQUEST['pay_amount'] + $_REQUEST['amt'];
			$checkin['balance']=$_REQUEST['Pendingamt'] - $_REQUEST['amt'];
		   // $checkin['receipt_no']=$_REQUEST['receipt_number'];
			//$checkin['receipt_date']=$_REQUEST['fees_date'];
			//$checkin['Bank_Name']=$_REQUEST['bank'];
			//$checkin['Bank_Branch']=$_REQUEST['branch'];
			//$checkin['Remark']=$_REQUEST['Remark'];
			//$checkin['Deposite_bank']='1';
		$flag=$this->Guesthouse_model->update_checkout($id,$checkin);
		if($flag)
		{
			$visitor_details=($this->Guesthouse_model->guesthouse_checkincheckout($id));
			
			foreach($visitor_details as $val){
				
				$data['Guest_House']=$val['guesthouse_name'];
				//location=$val['location'];
				//v_id=$val['v_id'];
				
				$data['Name']=$val['visitor_name'];
				$data['Mobile']=$val['mobile'];
				$data['Email']=$val['email'];
				$data['Booking_id']=$val['booking_id'];
				$data['No_Days']=$val['no_of_days'];
				//proposed_in_date=$val['proposed_in_date'];
				//proposed_out_date=$val['proposed_out_date'];
				$data['No_Person']=$val['no_of_person'];
				$data['charges']=$val['charges'];
				
				$data['Out_Date']=$val['proposed_out_date'];
				$data['In_Date']=$val['checkin_on'];
				
				
			}
			
            $challan_digits=5;
			$data['Paid_charge']=$_REQUEST['amt'];
			$data['Balance']=$_REQUEST['Pendingamt'] - $_REQUEST['amt'];
			if($_REQUEST['Pendingamt'] - $_REQUEST['amt']==0){
			$data['Balance_status']='N';
			}
			$data['mode_of_payment']=$_REQUEST['epayment_type'];
			$data['receipt_no']=$_REQUEST['receipt_number'];
			$data['receipt_date']=$_REQUEST['fees_date'];
			$data['Bank_Name']=$_REQUEST['bank'];
			$data['Bank_Branch']=$_REQUEST['branch'];
			$data['Remark']=$_REQUEST['Remark'];
			$data['Deposite_bank']='1';
			$data['current_date']=date('Y-m-d');
			$data['create_by']=$this->session->userdata("uid");
			$data['create_date']=date("Y-m-d H:i:s");
			//$challan_no='19GH'.$addmision_type.$month_session.str_pad( $last_inserted_id, $challan_digits, "0", STR_PAD_LEFT );
			//$data['challan_No']
			$data['enter_ip']=$_SERVER['REMOTE_ADDR'];
			
			$last_inserted_id=$this->Guesthouse_model->Insert_challan($data);
            if($last_inserted_id){
            if($last_inserted_id>9999)
			{
				$challan_digits=strlen($last_inserted_id);
			}
            
            $current=date('ymd');
            $up_ch['challan_No']='19GH'.$current.str_pad( $last_inserted_id, $challan_digits, "0", STR_PAD_LEFT);
            $last_inserted_id=$this->Guesthouse_model->update_challan($last_inserted_id,$up_ch);	
			
			}
			
			
			
			
			$this->session->set_flashdata('message1','Visitor checked Out Successfully.');
			redirect(base_url($this->view_dir.'booking_list'));
		}
		else
		{
			$this->session->set_flashdata('message2','Visitor Not checked Out Successfully.');
			redirect(base_url($this->view_dir.'booking_list'));
		}
	}
	
	public function cancellation()
	{
		$gh_update_array = array();
		$guesthouse_details=$this->Guesthouse_model->guesthouse_count_details($_POST);
		if(!empty($guesthouse_details)){
			$i = 0;
			foreach($guesthouse_details as $val){
				$remain_beds=(int)((int)$val['bed_available'] + (int)$val['bed_count']);
				if($remain_beds==0)$status='FULL';else$status='AVAILABLE';
				
				$gh_update_array[$i]=array("gh_id"=>$val['gh_id'],"bed_available"=>$remain_beds,"current_status"=>$status,"modified_by"=>$this->session->userdata("uid"),"modified_on"=>date("Y-m-d H:i:s"));
				$i++;
			}		
		}
		//print_r($gh_update_array); exit();
		$updated_id2=$this->Guesthouse_model->update_ghouse_available_bed_details($gh_update_array);
		
		$flag=$this->Guesthouse_model->cancellation($_POST);
		if($flag)
			echo 'Guesthouse Cancellation is done successfully';
		else
			echo 'Guesthouse Cancellation is not done successfully'; 
	}
	
	public function edit_booking_details()
	{
		$id=$this->uri->segment(3);
		$this->data['details']['visitor_id']=$this->uri->segment(3);
		$this->load->view('header',$this->data);
		$this->data['state']=$this->Guesthouse_model->getAllState();
		$get_beds_available_gh=$this->Guesthouse_model->get_beds_available_gh();
		$visitor_room_details=$this->Guesthouse_model->guesthouse_count_details($this->data['details']);
		
		$temp_v=$visitor_room_details;
		$temp=$get_beds_available_gh;
		$non_repeated_gh=array();
		for($i = 0; $i < count($temp_v); $i++)
		{
			if($temp_v[$i]['bed_available']==0)
			{
				$visitor_room_details[$i]['bed_available']=$temp_v[$i]['bed_count'];
				$non_repeated_gh=array($visitor_room_details[$i]);
			}
			//echo '</br>visitor ghih=='.$temp_v[$i]['gh_id'].'=='.$temp_v[$i]['bed_available'];
			for($j = 0; $j < count($temp); $j++)
			{
				//echo '</br> ghih=='.$temp[$j]['gh_id'];
				if($temp[$j]['gh_id']==$temp_v[$i]['gh_id'])
				{
					//echo "</br>bedav=".$temp[$i]['bed_available']." extbedcnt=".$temp_v[$j]['bed_count'];
					$bcount=$temp[$j]['bed_available']+$temp_v[$i]['bed_count'];
					$get_beds_available_gh[$j]['bed_available']=$bcount;
				}
			}
		}

		$this->data['get_beds']=array_merge($get_beds_available_gh,$non_repeated_gh);
		
		$this->data['visitor_details']=array_shift($this->Guesthouse_model->visitor_details($id));
		
        $this->load->view($this->view_dir.'edit_booking_details',$this->data);
        $this->load->view('footer');
	}
	
	public function visitor_room_details()
	{
		$visitor_room_details=$this->Guesthouse_model->visitor_room_details($_POST);
		echo json_encode(array("visitor_room_details"=>$visitor_room_details));
	}
	  public function get_hostel_room(){
	  // error_reporting(E_ALL);
		$arr['gh_id']=$_REQUEST['gh_id'];
		$arr['fd']=$_REQUEST['fd']." ".$_REQUEST['ft'];
		$arr['td']=$_REQUEST['td']." ".$_REQUEST['tt'];
		$arr['nps']=$_REQUEST['ps'];
		//$arr['ft']=
		$this->load->model('Student_Attendance_model');
		$ghl = $this->Guesthouse_model->get_guesthouse_details_rooms($arr);
		$ghd=$this->Guesthouse_model->get_guesthouse_details($_REQUEST['gh_id']);
		//$bcp = 
		$cnt = $ghd[0]['bed_capacity'];
		$hl = $ghd[0]['location'];
		if($hl=='T'){
			$dbed  = $ghd[0]['doubel_bed'];
			$dbed =explode(',', $dbed);
		}
		echo "<option value=''>Select Bed No </option>";
		for($i=1;$i<=$cnt;$i++){
			if($hl=='T' && in_array($i, $dbed)){
$d = '(Doubel Bed)';
			}else{
				$d='';
			}
			if(!in_array($i,$ghl)){
			echo "<option value='".$i."'>Bed No ".$i." ".$d."</option>";
			}
		}
	}
	function getghouse_list_creteria(){

		
		
		$arr['host_typ']=$_REQUEST['host_typ'];
		$arr['frmdt']=$_REQUEST['frmdt'];//substr($_REQUEST['frmdt'],0,-5);
		$arr['todt']=$_REQUEST['todt'];//substr($_REQUEST['todt'],0,-5);
		$arr['nop']=$_REQUEST['nop'];

		$glist  = $this->Guesthouse_model->get_availabel_gh_hostal($arr);
		
           for($i=1;$i<=$_REQUEST['nop'];$i++){
           	if($i=='1'){
   echo '<tr><td>'.$i.'</td><td><input style="width: 200px;" id="name_'.$i.'" class="vsname form-control" onkeyup="only_alpha(this.id)" name="vpname[]" type="text" placeholder="Name" value="'.$_REQUEST['vistr_name'].'" data-rule-required="true"  /><span style="color:RED;" id="errname_'.$i.'"></span></td><td><input id="mobile_'.$i.'" value="'.$_REQUEST['vistr_mobile'].'" class="vmobile form-control"  maxlength="10"   onkeyup="only_number(this.id)" placeholder="Mobile" style="width: 200px;" name="vpmobile[]" type="text"  data-rule-required="true" /><span style="color:RED;" id="errmobile_'.$i.'"></span></td><td><select  data-rule-required="true" style="width: 150px;" id="gh_'.$i.'" class="vsghouse form-control" name="ghouse[]" onchange="match_count(this.id)"><option value="">Select GuestHouse</option>';
foreach ($glist as $key => $value) {
			echo "<option value='".$value['gh_id']."_".$value['guesthouse_name']."_".$value['NEW_BAL']."' >".$value['guesthouse_name']."</option>";
		}
		echo '</select><span style="color:RED;" id="errgh_'.$i.'"></span></td><td><select   style="width: 150px;" id="ghrn_'.$i.'" class="vsghouse form-control" name="ghousebed[]"  ><option value="">Select Bed No</option></select><span style="color:RED;" id="errghbd_'.$i.'"></span></td></tr>';
           	}else{
		echo '<tr><td>'.$i.'</td><td><input style="width: 200px;" id="name_'.$i.'" class="vsname form-control" onkeyup="only_alpha(this.id)" name="vpname[]" type="text" placeholder="Name" value="'.$vistr_name.'" data-rule-required="true"  /><span style="color:RED;" id="errname_'.$i.'"></span></td><td><input id="mobile_'.$i.'" value="'.$vistr_mobile.'" class="vmobile form-control"  maxlength="10"   onkeyup="only_number(this.id)" placeholder="Mobile" style="width: 200px;" name="vpmobile[]" type="text"  data-rule-required="true" /><span style="color:RED;" id="errmobile_'.$i.'"></span></td><td><select  data-rule-required="true" style="width: 150px;" id="gh_'.$i.'" class="vsghouse form-control" name="ghouse[]" onchange="match_count(this.id)"><option value="">Select GuestHouse</option>';
foreach ($glist as $key => $value) {
			echo "<option value='".$value['gh_id']."_".$value['guesthouse_name']."_".$value['NEW_BAL']."' >".$value['guesthouse_name']."</option>";
		}
		echo '</select><span style="color:RED;" id="errgh_'.$i.'"></span></td><td><select   style="width: 150px;" id="ghrn_'.$i.'" class="vsghouse form-control" name="ghousebed[]"  ><option value="">Select Bed No</option></select><span style="color:RED;" id="errghbd_'.$i.'"></span></td></tr>';
	}
}

	}
	function getghouse_list_creteria_edit(){
		
		$arr['host_typ']=$_REQUEST['host_typ'];
		$arr['frmdt']=$_REQUEST['frmdt'];
		$arr['todt']=$_REQUEST['todt'];
		$arr['nop']=$_REQUEST['nop'];

		$glist  = $this->Guesthouse_model->get_availabel_gh_hostal($arr);

		$visitor_room_details=$this->Guesthouse_model->visitor_room_details($_POST);
		$len = count($visitor_room_details);
		$j=1;
           for($i=1;$i<=$_REQUEST['nop'];$i++){
           	if($i<=$len){ 
           		$hl = $visitor_room_details[$i-1]['location'];
           		if($hl=='T'){
			$dbed  = $visitor_room_details[$i-1]['doubel_bed'];
			$dbed =explode(',', $dbed);
		}
		
			if($hl=='T' && in_array($visitor_room_details[$i-1]['bed_no'], $dbed)){
$d = '(Doubel Bed)';
			}else{
				$d='';
			}
   echo '<tr><td>'.$i.'<input type="hidden" name="vr_id[]" id="vr_id'.$j.'" value="'.$visitor_room_details[$i-1]['vr_id'].'"/></td><td><input style="width: 200px;" id="name_'.$i.'" class="vsname form-control" onkeyup="only_alpha(this.id)" name="vpname[]" type="text" placeholder="Name" value="'.$visitor_room_details[$i-1]['visitor_name'].'" data-rule-required="true"  /><span style="color:RED;" id="errname_'.$i.'"></span></td><td><input id="mobile_'.$i.'" value="'.$visitor_room_details[$i-1]['mobile'].'" class="vmobile form-control"  maxlength="10"   onkeyup="only_number(this.id)" placeholder="Mobile" style="width: 200px;" name="vpmobile[]" type="text"  data-rule-required="true" /><span style="color:RED;" id="errmobile_'.$i.'"></span></td><td><select  data-rule-required="true" style="width: 150px;" id="gh_'.$i.'" class="vsghouse form-control" name="ghouse[]" onchange="match_count(this.id)"><option value="">Select GuestHouse</option><option value="'.$visitor_room_details[$i-1]['gh_id'].'_'.$visitor_room_details[$i-1]['guesthouse_name'].'" selected >'.$visitor_room_details[$i-1]['guesthouse_name'].'</option>';
foreach ($glist as $key => $value) {
	if($visitor_room_details[$i-1]['gh_id']==$value['gh_id']){
		$r='selected';
	}else{
		$r='';
	}
			echo "<option value='".$value['gh_id']."_".$value['guesthouse_name']."_".$value['NEW_BAL']."' ".$s." >".$value['guesthouse_name']."</option>";
		}
		echo '</select><span style="color:RED;" id="errgh_'.$i.'"></span></td><td><select   style="width: 150px;" id="ghrn_'.$i.'" class="vsghouse form-control" name="ghousebed[]"  ><option value="'.$visitor_room_details[$i-1]['bed_no'].'">'.$visitor_room_details[$i-1]['bed_no'].' '.$d.'</option></select><span style="color:RED;" id="errghbd_'.$i.'"></span></td></tr>';
           	}else{
		echo '<tr><td>'.$i.'<input type="hidden" name="vr_id[]" id="vr_id'.$j.'" value=""/></td><td><input style="width: 200px;" id="name_'.$i.'" class="vsname form-control" onkeyup="only_alpha(this.id)" name="vpname[]" type="text" placeholder="Name" value="'.$vistr_name.'" data-rule-required="true"  /><span style="color:RED;" id="errname_'.$i.'"></span></td><td><input id="mobile_'.$i.'" value="'.$vistr_mobile.'" class="vmobile form-control"  maxlength="10"   onkeyup="only_number(this.id)" placeholder="Mobile" style="width: 200px;" name="vpmobile[]" type="text"  data-rule-required="true" /><span style="color:RED;" id="errmobile_'.$i.'"></span></td><td><select  data-rule-required="true" style="width: 150px;" id="gh_'.$i.'" class="vsghouse form-control" name="ghouse[]" onchange="match_count(this.id)"><option value="">Select GuestHouse</option>';
foreach ($glist as $key => $value) {
			echo "<option value='".$value['gh_id']."_".$value['guesthouse_name']."_".$value['NEW_BAL']."' >".$value['guesthouse_name']."</option>";
		}
		echo '</select><span style="color:RED;" id="errgh_'.$i.'"></span></td><td><select   style="width: 150px;" id="ghrn_'.$i.'" class="vsghouse form-control" name="ghousebed[]"  ><option value="">Select Bed No</option></select><span style="color:RED;" id="errghbd_'.$i.'"></span></td></tr>';
	}
	$j++;
}

	}
	function getghouse_list_creteria_dropdown(){
		
		$arr['host_typ']=$_REQUEST['host_typ'];

		$rolid = $this->session->userdata("role_id");
		
   //	echo $exp[1];
		    
if($rolid=='6'){
               		$camp=$_REQUEST['camp'];   

                  }else{
$exp = explode("_",$this->session->userdata("name"));
                  	 if($exp[1]=="sijoul")
 {              
             $camp= 'SIJOUL';
        }elseif($exp[1]=="nashik")
        {
        	$camp='NASHIK';
           
        }

                  }
$arr['campus']=$camp;
		$glist  = $this->Guesthouse_model->get_guesthouse_details_individual($arr);
echo "<option value=''>Select All</option>";
		foreach ($glist as $key => $value) {
echo "<option value='".$value['gh_id']."' >".$value['guesthouse_name']."</option>";
					}

	}
	function get_booking_details()
	{
 $visitor_details=array_shift($this->Guesthouse_model->guesthouse_checkincheckout($_REQUEST['id']));
 	$selected_guesthouse=$this->Guesthouse_model->selected_guesthouse($_REQUEST['id']);
 //print_r($visitor_details);
 $rm=explode('_', $visitor_details['location']);
			echo '<div class="modal-content" style="width:800px;">
							  <div class="modal-header">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								<center><h4>&nbsp;'.$visitor_details['guesthouse_name'].' &nbsp; Room no: '.$rm[2].'
												</h4></center>
							  </div>
							  <div class="modal-body" id="">
								
								
									<div class="panel panel-success">
										<div class="panel-heading">
												<span class="panel-title pull-left">Name : &nbsp;</span>
												<span id="std_name" name="std_name">'.$visitor_details['visitor_name'].'  </span>
												<span class="panel-title pull-right">Status: '.$visitor_details['current_status'].'</span>
												
										</div>
							
							 
										<div class="panel-body">
											<div class="table-info">  
										
												
												    	
											<table class="table table-bordered">
											 <tbody> <tr>
						  <th>Address :</th>
						  <td class="col-sm-4"><span id="std_name">'.$visitor_details['address'].',&nbsp;'.$visitor_details['taluka_name'].',&nbsp;'.$visitor_details['state_name'].'</span></td>
						  <th>Mobile:</th>
						  <td class="col-sm-4"><span id="type">'.$visitor_details['mobile'].'</span></td>
						  
						</tr> 
						 <tr>
						 <th>Gender:</th>
						  <td class="col-sm-4"><span id="organisation">'.$visitor_details['gender'].'</span></td>
						  <th style="text-align: left;">Email:</th>
						  <td class="col-sm-4"><span id="acadmic">'.$visitor_details['email'].'</span></td>
						</tr>   
						<tr>
						  <th style="text-align: left;">Reference Of:</th>
						  <td class="col-sm-4"><span id="prn_num">'.$visitor_details['reference_of'].'</span></td>
						   <th style="text-align: left;">Visiting Purpose:</th>
						   <td class="col-sm-4"><span id="reason">'.$visitor_details['visiting_purpose'].'</span></td>
						</tr>
						
						<tr>
						  <th>Proposed In Date:</th>
						  <td class="col-sm-4"><span id="fdate">'.$visitor_details['proposed_in_date'].'</span></td>
						  <th style="text-align: left;">Proposed Out Date:</th>
						  <td class="col-sm-4"><span id="tdate">'.$visitor_details['proposed_out_date'].'</span></td>
						</tr>
						<tr>
						  <th>Check In Date:</th>
						  <td class="col-sm-4"><span id="fdate">'.$visitor_details['checkin_on'].'</span></td>
						  <th style="text-align: left;">Check Out Date:</th>
						  <td class="col-sm-4"><span id="tdate">'.$visitor_details['checkin_out'].'</span></td>
						</tr>
						
						<tr id="chck_date" style="display:none;">
						  <th>Check In Date:</th>
						  <td class="col-sm-4"><span id="cin_date"></span></td>
						  <th style="text-align: left;">Check Out Date:</th>
						  <td class="col-sm-4"><span id="cout_date"></span></td>
						</tr>
						
						<tr>
						  <th style="text-align: left;">No. Of Person:</th>
						  <td class="col-sm-4"><span id="nov">'.$visitor_details['no_of_person'].'</span></td>
						   <th style="text-align: left;">No. Of Days:</th>
						   <td class="col-sm-4"><span id="bkgh">'.$visitor_details['no_of_days'].'</span></td>
						</tr>	</tbody></table><table class="table table-bordered">
												<tbody><tr>
						<th>#</th>
						<th>Visitors Name</th>
						<th>Mobile</th>
						<th>GuestHouse</th><th>Bed No</th>
						</tr>
																							
												
												</tr></tbody>
												<tbody id="fee_details">';
												if(!empty($selected_guesthouse)){
								$i=1;
								foreach($selected_guesthouse as $gh){
									$ck = explode(',',$gm['doubel_bed']);
									if(in_array($gh['bed_no'], $ck)){
										$db = '(Doubel Bed)';
									}else{
										$db='';
									}
								echo '<tr>
									<td>'.$i.'</td>
									<td>'.$gh['visitor_name'].'</td>
									<td>'.$gh['mobile'].'</td>
									<td>';								
									
									echo $gh['guesthouse_name'];
									
									echo '</td>
									<td>'.$gh['bed_no'].'&nbsp;'.$db.'</td>
								</tr>';
								
									$i++;
								}
							} 

							echo '</tbody>
											</table>
											</form></div>
											
											<div class="col-sm-3">
												<button class="btn btn-primary form-control" type="submit" id="btn_submit" style="display:none;">Allocate</button>                                        
											</div>
											
											
										</div>
									</div>
								
								
								
							  </div>
							  <div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							  </div>
							</div>';
	}
	
	function ghouse_report(){
		
		  $this->load->view('header',$this->data);
		$this->data['guesthouse_details']=$this->Guesthouse_model->get_guesthouse_details();
		$this->data['booking_list']=$this->Guesthouse_model->get_booking_list();
        $this->load->view($this->view_dir.'ghouse_report',$this->data);
        $this->load->view('footer');
		
		}
		public function get_guesthouse_report_list()
    {   
        // error_reporting(E_ALL);
		//ini_set('display_errors', 1);
         $arr['htyp']=$_POST['htyp'];
         $arr['selectby']=$_POST['selectby'];
         $arr['daywise']=$_POST['daywise'];
         $arr['fdate']=$_POST['fdate'];
		 $arr['tdate']=$_POST['tdate'];
		 $arr['campus']=$_POST['campus'];
		 $arr['hostlit']=$_POST['hostlit'];
$this->data['report']=$_POST['report'];
if($_POST['report']=='1'){
           $this->data['details'] = $this->Guesthouse_model->get_report_list($arr);
         //   $this->data['details']=$this->Guesthouse_model->get_booked_ghouses($this->data);
            
            }else{

            	$rolid = $this->session->userdata("role_id");
if($rolid=='6'){
if($_POST['campus']!=''){
	$cm = array($_POST['campus']);
}else{
   $cm = array('SIJOUL','NASHIK');
}

}else{
	$exp = explode("_",$this->session->userdata("name"));
   //	echo $exp[1];
		     if($exp[1]=="sijoul")
        {              
              $cm = array('SIJOUL');
        }
        
            if($exp[1]=="nashik")
        {
        	$cm = array('NASHIK');       	
           
        }
}
//print_r($cm);
foreach ($cm as $k => $v) {
	$arr['campus'] = $v;

            	$h=array('H','T');
            	$sts = array('BOOKING-DONE','CANCELLED');
            	foreach ($h as  $val) {
            		$arr['hos_typ']= $val;
            	
            	foreach ($sts as  $value) {
            		$arr['curr_sts']=$value;
$cnt = $this->Guesthouse_model->get_campus_cnt($arr);
$this->data['details'][$v][$val][$value] = $cnt;
            	}
            	
            	}
            	
}

            }
            // if($_POST['act']=="view"){
                 $this->load->view($this->view_dir.'gh_report_list',$this->data);
             //}

           }
}

?>