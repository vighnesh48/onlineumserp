<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Competitive_exam extends CI_Controller 
{
    var $currentModule="Competitive_exam";
    var $title="";
    var $table_name="";
    var $model_name="Competitive_exam_model";
    var $model;
    var $view_dir='Competitive/';
    var $data=array();
    public function __construct() 
    {
        parent:: __construct();
		
        // load form and url helpers
        $this->load->helper(array('form', 'url'));
         
        // load form_validation library
        $this->load->library('form_validation');
		$this->currentModule=$this->uri->segment(1);        
        $this->data['currentModule']=$this->currentModule;
        $this->data['model_name']=$this->model_name;
		$this->load->model($this->model_name);
	}
	
	public function index()
    {
        $this->student_list();
    }
	
	public function student_list()
    {
        $this->load->view('header',$this->data);
		$this->data['student_list']=$this->Competitive_exam_model->get_student_list();
        $this->load->view($this->view_dir.'student_list',$this->data);
        $this->load->view('footer');
    }
	
	// fetch qualification streams 
	public function fetch_qualification_streams(){
		//echo $state;
		$qul=$this->Competitive_exam_model->fetch_qualification_streams($_POST);
		//print_r($city);exit;
		if(!empty($qul)){
			echo"<option value=''>Select Stream</option>";
			foreach($qul as $key=>$val){
				echo"<option value='".$qul[$key]['qualification']."'>".$qul[$key]['qualification']."</option>";
			}		
		}
	}
	
	public function edit_student()
	{
		$id=$this->uri->segment(3);
        $this->load->view('header',$this->data);
		$this->data['academic_details']= $this->Competitive_exam_model->get_academic_details();
		$this->data['state']=$this->Competitive_exam_model->getAllState();
		$this->data['caste']=$this->Competitive_exam_model->getAllcaste();
		//$this->data['stream']=$this->Competitive_exam_model->get_stream_list_in_school();
		$this->data['publicmedia']=$this->Competitive_exam_model->getAllpublicmedia();
		$this->data['module_details']=$this->Competitive_exam_model->getmoduledetails();
		$this->data['school_details']=$this->Competitive_exam_model->get_school_details();		
        $this->data['student_list']= array_shift($this->Competitive_exam_model->get_student_list($id));
		$this->load->view($this->view_dir.'edit_student',$this->data);
        $this->load->view('footer');
	}
	
	public function registration_form()
    {
        $this->load->view('header',$this->data);
		$this->data['academic_details']= $this->Competitive_exam_model->get_academic_details();
		$this->data['state']=$this->Competitive_exam_model->getAllState();
		$this->data['caste']=$this->Competitive_exam_model->getAllcaste();
		$this->data['publicmedia']=$this->Competitive_exam_model->getAllpublicmedia();
		$this->data['module_details']=$this->Competitive_exam_model->getmoduledetails();
		$this->data['school_details']=$this->Competitive_exam_model->get_school_details();
        $this->load->view($this->view_dir.'registration_form',$this->data);
        $this->load->view('footer');
    }
	
	public function check_prn_exists()
	{
		$student_details=array_shift($this->Competitive_exam_model->check_prn_exists($_POST));
		echo json_encode(array("student_details"=>$student_details));
	}
	
	public function fetch_fees()
	{
		$fee_details=array_shift($this->Competitive_exam_model->fetch_fees($_POST));
		echo json_encode(array("fee_details"=>$fee_details));
	}
	
	public function get_stream_list_in_school()
	{
		$stream_details=$this->Competitive_exam_model->get_stream_list_in_school($_POST);
		echo json_encode(array("stream_details"=>$stream_details));
	}
	
	public function form_submit()
	{
		//error_reporting(E_ALL);
		//ini_set('display_errors', 1);
		if($_POST['stype']=='O')
			$org=$_POST['instute'];
		else
			$org=$_POST['org'];
		
		$dts=$this->Competitive_exam_model->get_last_reg_no();
		$reg_no=sprintf("18%04d", $dts+1);
		
		if(!empty($dts))
		{
			$dts++;
			$reg_no=$dts;
		}
	
		$insert_array=array("student_name"=>$_POST['slname'],"gender"=>$_POST['gender'],"student_mobileno"=>$_POST['mobile'],"parent_mobileno"=>$_POST['pmobile'],"email_id"=>$_POST['email'],"student_type"=>$_POST['stype'],"reg_no"=>$reg_no,"dob"=>date("Y-m-d", strtotime($_POST['dob'])),"address"=>$_POST['laddress'],"pincode"=>$_POST['lpincode'],"paddress"=>$_POST['paddress'],"ppincode"=>$_POST['ppincode'],"taluka_id"=>$_POST['lcity'],"pcity_id"=>$_POST['pcity'],"district_id"=>$_POST['ldistrict_id'],"state_id"=>$_POST['lstate_id'],"pdistrict_id"=>$_POST['pdistrict_id'],"pstate_id"=>$_POST['pstate_id'],"city"=>$_POST['city_name'],"district"=>$_POST['district_name'],"state"=>$_POST['state_name'],"pcity"=>$_POST['pcity_name'],"pdistrict"=>$_POST['pdistrict_name'],"pstate"=>$_POST['pstate_name'],"same"=>$_POST['same'],"stream"=>$_POST['hq_stream'],"school_id"=>$_POST['school'],"stream_id"=>$_POST['stream'],"school_name"=>$_POST['school_name'],"stream_name"=>$_POST['stream_name'],"student_org"=>$org,"student_prn"=>$_POST['prn'],"form_number"=>$_POST['formno'],"academic_year"=>'2018',"admission_date"=>date("Y-m-d", strtotime($_POST['ad_date'])),"entrance_type"=>$_POST['etype'],"other_specify"=>$_POST['e_other'],"category"=>$_POST['category'],"father_occupation"=>$_POST['occupation'],"mother_occupation"=>$_POST['moccupation'],"highest_qualification"=>$_POST['qualifcation'],"academic_achievement"=>$_POST['Achievement'],"curri_achievement"=>$_POST['curri'],"hobbies"=>$_POST['hobbies'],"upsc_exam"=>$_POST['upsc'],"module"=>$_POST['module_val'],"come_toknow"=>$_POST['media'],"applicable_fees"=>$_POST['fee'],"status"=>'Y',"created_by"=>$this->session->userdata("uid"),"created_on"=>date("Y-m-d H:i:s")); 
		
		//echo '<br/><br/>insert_array: <br/>\n';
		//var_dump($insert_array);exit();
		$last_inserted_id= $this->Competitive_exam_model->form_submit($insert_array);
		if($last_inserted_id)
			$this->session->set_flashdata('message1','Admission Form Submit Successfully.');
		else
			$this->session->set_flashdata('message2','Admission Form Not Submit Successfully.');
        redirect(base_url('Competitive_exam/student_list'));
	}
	
	public function update_form_submit()
	{
		if($_POST['stype']=='O')
			$org=$_POST['instute'];
		else
			$org=$_POST['org'];
	
		$id=$_POST['stud_id'];
		$update_array=array("student_name"=>$_POST['slname'],"gender"=>$_POST['gender'],"student_mobileno"=>$_POST['mobile'],"parent_mobileno"=>$_POST['pmobile'],"email_id"=>$_POST['email'],"student_type"=>$_POST['stype'],"reg_no"=>$reg_no,"dob"=>date("Y-m-d", strtotime($_POST['dob'])),"address"=>$_POST['laddress'],"pincode"=>$_POST['lpincode'],"paddress"=>$_POST['paddress'],"ppincode"=>$_POST['ppincode'],"taluka_id"=>$_POST['lcity'],"pcity_id"=>$_POST['pcity'],"district_id"=>$_POST['ldistrict_id'],"state_id"=>$_POST['lstate_id'],"pdistrict_id"=>$_POST['pdistrict_id'],"pstate_id"=>$_POST['pstate_id'],"city"=>$_POST['city_name'],"district"=>$_POST['district_name'],"state"=>$_POST['state_name'],"pcity"=>$_POST['pcity_name'],"pdistrict"=>$_POST['pdistrict_name'],"pstate"=>$_POST['pstate_name'],"same"=>$_POST['same'],"stream"=>$_POST['hq_stream'],"school_id"=>$_POST['school'],"stream_id"=>$_POST['stream'],"school_name"=>$_POST['school_name'],"stream_name"=>$_POST['stream_name'],"student_org"=>$org,"student_prn"=>$_POST['prn'],"form_number"=>$_POST['formno'],"academic_year"=>'2018',"admission_date"=>date("Y-m-d", strtotime($_POST['ad_date'])),"entrance_type"=>$_POST['etype'],"other_specify"=>$_POST['e_other'],"category"=>$_POST['category'],"father_occupation"=>$_POST['occupation'],"mother_occupation"=>$_POST['moccupation'],"highest_qualification"=>$_POST['qualifcation'],"academic_achievement"=>$_POST['Achievement'],"curri_achievement"=>$_POST['curri'],"hobbies"=>$_POST['hobbies'],"upsc_exam"=>$_POST['upsc'],"module"=>$_POST['module_val'],"come_toknow"=>$_POST['media'],"applicable_fees"=>$_POST['fee'],"status"=>'Y',"modified_by"=>$this->session->userdata("uid"),"modified_on"=>date("Y-m-d H:i:s")); 
		//
		
		//echo '<br/><br/>insert_array: <br/>\n';
		//var_dump($update_array);exit();
		$last_inserted_id= $this->Competitive_exam_model->update_form_submit($update_array,$id);
		if($last_inserted_id)
			$this->session->set_flashdata('message1','Admission Form Updated Successfully.');
		else
			$this->session->set_flashdata('message2','Admission Form Not Updated Successfully.');
        redirect(base_url('Competitive_exam/edit_student/'.$id));
	}
	
	public function view_std_payment()
	{
		//error_reporting(E_ALL);
		//ini_set('display_errors', 1);
		$sf_std_id=$this->uri->segment(3);
		$this->load->view('header',$this->data); 
		$this->data['academic_details']= $this->Competitive_exam_model->get_academic_details();
		$this->data['student_details']= array_shift($this->Competitive_exam_model->get_student_list($sf_std_id));
		//var_dump($this->data['student_details']);
		$this->data['bank_details']= $this->Competitive_exam_model->getbanks();
		//var_dump($this->data['bank_details']);
		//payment history
		$this->data['installment']= $this->Competitive_exam_model->fetch_fee_details($sf_std_id);
		//var_dump($this->data['installment']);
		//paid details
		$this->data['stud_faci_details']= $this->Competitive_exam_model->get_std_fc_details_byid($sf_std_id);
		//var_dump($this->data['stud_faci_details']);		
		//exit();
		$this->load->view($this->view_dir.'view_std_payment',$this->data);
        $this->load->view('footer');
	}
	
		// insert Payment installment
	public function pay_Installment()
    {
		//print_r($_FILES);exit;
        $stud_id= $_POST['stud_id'];
		//$enroll= $_POST['enrollment_no'];
		//$org= $_POST['org'];
		$academic= $_POST['acyear'];
		//var_dump($_POST);exit();
		$no_of_installment =1+$_POST['no_of_installment'];
		if(!empty($_FILES['payfile']['name'])){
			$filenm=$stud_id.'-'.$no_of_installment.'-'.$_FILES['payfile']['name'];
			$config['upload_path'] = 'uploads/Competitive/student_challans/';
			$config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
			$config['overwrite']= TRUE;
			$config['max_size']= "2048000";
			//$config['file_name'] = $_FILES['profile_img']['name'];
			$config['file_name'] = $filenm;

			//Load upload library and initialize configuration
			$this->load->library('upload',$config);
			$this->upload->initialize($config);

			if($this->upload->do_upload('payfile')){
				$uploadData = $this->upload->data();
				$payfile = $uploadData['file_name'];
			}else{
				$payfile = '';
			}
		}
		else{
			$payfile = '';
		}
		
		//echo "calling";exit();
        $last_inserted_id= $this->Competitive_exam_model->pay_Installment($_POST,$payfile );
		if($last_inserted_id)
		{
			$this->session->set_flashdata('message1','Fee Details Added Successfully.');
			redirect(base_url('Competitive_exam/view_std_payment/'.$stud_id));
		}
		else
		{
			$this->session->set_flashdata('message2','Fee Details Not Added Successfully.');
			redirect(base_url('Competitive_exam/view_std_payment/'.$stud_id));
		}
        //redirect('Hostel/view_std_payment/'.$stud_id);
    }
	
	public function edit_fdetails()
	{
		$this->data['stud_details']['student_id']=$_POST['stdid'];
		
		$feeid =$_POST['feeid'];

		$this->data['academic_details']= $this->Competitive_exam_model->get_academic_details();
		$this->data['bank_details']= $this->Competitive_exam_model->getbanks();
		$this->data['indet']= $this->Competitive_exam_model->fetch_examfee_details_byfid($feeid);

		$this->load->view($this->view_dir.'edit_fee',$this->data);
	}
	
	public function delete_fees()
	{
	      $this->Competitive_exam_model->delete_fees($_POST);  
	}
	
	public function update_inst($stud_id)
	{
		$stud_id= $_POST['student_id'];
		date_default_timezone_set('Asia/Kolkata');
        $stud_id= $_POST['sid'];
		//echo $stud_id;exit();
	//	$no_of_installment =1+$_POST['no_of_installment'];
		if(!empty($_FILES['epayfile']['name'])){
			$filenm=$stud_id.'-'.time().'-'.$_FILES['epayfile']['name'];
			$config['upload_path'] = 'uploads/Competitive/student_challans/';
			$config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
			$config['overwrite']= TRUE;
			$config['max_size']= "2048000";
			//$config['file_name'] = $_FILES['profile_img']['name'];
			$config['file_name'] = $filenm;

			//Load upload library and initialize configuration
			$this->load->library('upload',$config);
			$this->upload->initialize($config);

			if($this->upload->do_upload('epayfile')){
				$uploadData = $this->upload->data();
				$payfile = $uploadData['file_name'];
			}else{
				$payfile = '';
			}
		}
		else{
			$payfile = '';
		}
        $this->Competitive_exam_model->update_fee_det($_POST,$payfile );
        //redirect('ums_admission/viewPayments/'.$stud_id);
		$this->session->set_flashdata('message1','Competitive Fee Details Updated Successfully.');
		redirect(base_url('Competitive_exam/view_std_payment/'.$stud_id));
	}
	
	public function exam_fees_report()
    {
        $this->load->view('header',$this->data);    
        $this->load->view('Competitive/report/fees_report.php',$this->data);
        $this->load->view('footer');
    }
	
	public function get_exam_fees_report()
	{   
           // error_reporting(E_ALL);
//ini_set('display_errors', 1);
         $this->data['academic_year']=$_POST['academic_year'];
         //$this->data['campus']=$_POST['campus'];
        // $this->data['institute_name']=$_POST['institute_name'];
         $this->data['report_type']=$_POST['report_type'];
          
		  $param = '"en-GB-x","A4","","",0,0,0,0,-10,-10,L';
		$this->load->library('m_pdf', $param);
		
        if($_POST['report_type']=="2") 
        {
            $this->data['get_by']="";
            $this->data['fees']=$this->Competitive_exam_model->get_studentwise_Competitive_fees($this->data);
            if($_POST['act']=="view"){
                 $this->load->view('Competitive/report/fees_details',$this->data);
             }
			 else if($_POST['act']=="pdf"){
				 //echo 'hhhhhh';
                 $html = $this->load->view('Competitive/report/pdf_details',$this->data, true);
				 // echo $html;//exit();
				 $this->m_pdf->pdf->WriteHTML($html);
				 $pdfFilePath = 'Competitive Exam Fees StudentWise-'.$_POST['academic_year'].'.pdf';
				$this->m_pdf->pdf->Output($pdfFilePath, "D");
				$this->session->set_flashdata('pdfmsg', 'download');
             }
             else{
                $this->load->view('Competitive/report/excel_details',$this->data);
                 $this->session->set_flashdata('excelmsg', 'download');
             }
        }
        else if($_POST['report_type']=="4")
        { 
             $this->data['get_by']="";
             $this->data['fees']=$this->Competitive_exam_model->get_studentwise_Competitive_fees($this->data);
            if($_POST['act']=="view"){
                 $this->load->view('Competitive/report/fees_details',$this->data);
             }
			 else if($_POST['act']=="pdf"){
				 //echo 'hhhhhh';
                 $html = $this->load->view('Competitive/report/pdf_details',$this->data, true);
				 // echo $html;//exit();
				 $this->m_pdf->pdf->WriteHTML($html);
				 $pdfFilePath = 'Competitive Exam Outstanding Fees-'.$_POST['academic_year'].'.pdf';
				$this->m_pdf->pdf->Output($pdfFilePath, "D");
				$this->session->set_flashdata('pdfmsg', 'download');
             }
             else{
                $this->load->view('Competitive/report/excel_details',$this->data);
                 $this->session->set_flashdata('excelmsg', 'download');
             }
        }
       
        
    }
	
}

?>