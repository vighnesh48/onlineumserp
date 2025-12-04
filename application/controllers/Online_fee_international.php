<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Online_fee_international extends CI_Controller 
{

    var $currentModule="Online_fee_international";
    var $title="";
    var $table_name="campus_master";
    var $model_name="Online_feemodel_international";
    var $model;
    var $view_dir='Online_fee_International/';
    
    public function __construct() 
    {
        global $menudata;
        parent:: __construct();
     //   echo $_SERVER['REMOTE_ADDR'];
    // var_dump($_SESSION);
   //  error_reporting(E_ALL);
   // ini_set('display_errors', 1);
        $this->load->helper("url");		
        $this->load->library('form_validation');
        $this->load->library('someclass');
		$this->load->library('session');
		
        if($this->uri->segment(2)!="" && $this->uri->segment(2)!="submit" && !in_array($this->uri->segment(2),
		 $this->skipActions))
           $title=$this->uri->segment(2);                   //Second segment of uri for action,In case of edit,view,add etc.
       else
           $title=$this->master_arr['index'];
       
        
        $this->currentModule=$this->uri->segment(1);
        $this->data['currentModule']=$this->currentModule;
        $this->data['model_name']=$this->model_name;
        
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $model = $this->load->model($this->model_name);
        $this->load->model('Challan_model');
		$this->load->model('Phd_challan_model');
	    $this->load->model('Online_feemodel_International');
		$this->load->model('online_transport_feemodel');
        $menu_name=$this->uri->segment(1);        
        $this->data['my_privileges']=$this->retrieve_privileges($menu_name);
    }
    
    public function indexold() // Renamed by to indexold as new index is down 
    {  
        global $model;
        $this->load->view('header',$this->data);    
         $this->data['emp_list']= $this->Online_feemodel_International->getFeesdata();
      //    var_dump($this->Online_feemodel_International->getFeesdata());
       // $this->data['campus_details']= $this->campus_model->get_campus_details();                        
        $this->load->view($this->view_dir.'fee_listing',$this->data);
        $this->load->view('footer');
    }
	
	public function index(){ 
	//print_r($_SESSION);
	//exit;
	if($this->session->userdata("role_id")==5 || $this->session->userdata("role_id")==6 || $this->session->userdata("role_id")==40){
		}else{
			redirect('home');
		}
        global $model;
        $this->load->view('header',$this->data);    
		
	 $this->data['product_info']= $this->Online_feemodel_international->product_info();                 
        $this->load->view($this->view_dir.'fees_listing',$this->data);
        $this->load->view('footer');
    }
	
	
	 public function getOnlineFeeDetail()
    {
     // $this->load->model('Online_feesmodel');
      $pdate = strip_tags($this->input->post('pdate'));
      $pstatus = strip_tags($this->input->post('pstatus'));
      $Type_status=$this->input->post('Type_status');
      $Verify_status=$this->input->post('Verify_status');
	  $pyear=$this->input->post('pyear');
      $list = $this->Online_feemodel_international->get_datatables('', $pstatus, $pdate,$Type_status,$Verify_status,$pyear);
   //  print_r($list);
	// exit();
      $data = array();
      $no = $_POST['start'];
      foreach ($list as $students) {
		  
		 // $adm_id=$students->adm_id;
		//if(!empty($adm_id))
		{
		  
		  
        $no++;
        $row = array();
        $row[] = $no;
        $row[] = $students->receipt_no;
        $row[] = $students->bank_ref_num;
		if(($students->productinfo=="New_Admission")||($students->productinfo=="Online_Admission_Form")){$row[] ='';}else{
		$row[] = $students->registration_no;
		}
        $row[] = $students->firstname;
		$row[] = $students->phone;
        $row[] = $students->amount_usd;
		$row[] = $students->academic_year;
        $row[] = $students->pg_type;
        $row[] = $students->payment_status;
        $row[] = $students->payment_date;
		 
		/*if(!empty($students->examsession)){
			$exam_session=$students->exam_month.'-'.$students->exam_year;
		}else{
			$exam_session ='';
		}*/
		
		if(($students->productinfo=="Re-Registration")||($students->productinfo=="Admission")){
			$a='';$r='';
			if($students->productinfo=="Re-Registration"){
				$r="selected";
			}else{
				$a="selected";
			}
			
			$row[] ='<select name="produc" id="produc" lang="'.$students->payment_id.'" onchange="change_productinfo(this)">
			<option value="Admission" '.$a.'>Admission</option>
			<option value="Re-Registration" '.$r.'>Re-Registration</option>
			</select>';
		}else{
        $row[] = $students->productinfo;//.' '.$exam_session
			}
		
		
        $apStatus = $students->fees_id;
		/*$adm_id=$students->adm_id;
		if(empty($adm_id)){
			$row[] = 'Pending';
		}else{
			$row[] = 'Done';
		}*/
		$row[] = 'Pending';
       
	    if($apStatus == NULL) {
        	$row[] = 'Pending';
        } else {
        	$row[] = 'Approved';
        }

        $verifyStatus = '';
        $verification_status = $students->verification_status;
        $payment_status = $students->payment_status;
		
		
        if($payment_status == 'success') {
        	if($apStatus != NULL) {
        		$verifyStatus .= $students->college_receiptno;
        	} else {
				if($students->productinfo=="Online_Admission_Form"){
				$studentVerify = base_url()."Online_fee_international/External_challan/".$students->payment_id."/".$students->productinfo;
				}else{
        		$studentVerify = base_url()."Online_fee_international/Challan/".$students->payment_id."/".$students->productinfo;
				}
        		//$verifyStatus .= '<a  href="'.$studentVerify.'" title="Verify" target="_blank"><i class="fa fa-book" aria-hidden="true"></i>Verify</a>';
				$verifyStatus="Document Pending";
        	}
        }

        if ($students->payment_status == 'failure') {
        	$verifyStatus .= '<a href="#" onclick="remove_list('.$students->payment_id.')">Remove</a>';
        }
		$dtpass='';
		$role_id=$this->session->userdata('role_id');
		
		$con='';
		$con1='';
		if($role_id!=50)
		{
			$con1='style="display:none;"';
			$con=' disabled';
			
			
		}        	$dtpass = '<input '.$con.' type="text" id="pass_'.$students->payment_id.'"
             value="'.$students->passport.'"
			><a href="#" '.$con1.'  onclick="add_passport('.$students->payment_id.')">Add Passport</a>';
       
		$uploadimg='';
		if(!empty($students->document)){
			$uploadimg.='<a href="'.base_url().'uploads/internationalpaymentdocuments/'.$students->document.'" download>Download</a><br>';
		}
		$uploadimg.= '<input '.$con1.' id="avatar_up_'.$students->payment_id.'" type="file" name="avatar_up_'.$students->payment_id.'" />
        <button '.$con1.' class= "btn upload" style="color:blue" id="up_'.$students->payment_id.'">Upload</button>';
		
		$action='---';
        if(!empty($students->passport)){
			$check_data=$this->Online_feemodel_international->check_data_in_sm($students->passport);
			if(!empty($check_data)){
				$student_id=$check_data->stud_id;
				$enrollment_no=$check_data->enrollment_no;
				$data_tp['student_id']=$student_id;
				$data_tp['registration_no']=$enrollment_no;
				$data_tp['amount']=$students->amount_usd;
				$this->Online_feemodel_international->update_inOpi($students->payment_id,$data_tp);
				//$check_entry_in_op=$this->Online_feemodel_international->check_entry_in_op($students);
				
				if($role_id!=50){
				$action='<a href="'.base_url().'Online_fee/Challan/'.$students->payment_id.'/International_Admission">Verify</a>';
				}
			}
			
		}
		
		
		
        $row[] = $verifyStatus;
		$row[] = $dtpass;
		$row[] = $uploadimg;
		$row[]=$action;
		$data[] = $row;
      }
	  }
 
      $output = array(
              "draw" => $_POST['draw'],
              "recordsTotal" => $this->Online_feemodel_international->count_all(),
              "recordsFiltered" => $this->Online_feemodel_international->count_filtered('', $pstatus, $pdate,$Type_status,$Verify_status,$pyear),
              "data" => $data,
          );

      echo json_encode($output);
    }
	
	
	
	
	public function Challan(){
		//echo '';
		//exit();
		//echo 'TEts';
		$this->load->model('Challan_model');
	    global $model;
         $this->load->view('header',$this->data);    
		 $recepit=$this->uri->segment(3);
		 $productinfo =$this->uri->segment(4);
		 $this->data['productinfo']=$this->uri->segment(4);
		//exit();
		if($productinfo=="International_Admission"){
		$this->data['user_details']=$this->Online_feemodel_international->get_details($recepit);
		$dats=$this->data['user_details'];
			}/*else{
		$this->data['user_details']=$this->Online_feemodel_international->get_details_register($recepit);
		$dats=$this->data['user_details'];
		}*/
		
		
		//print_r($this->data['user_details']);
		//exit();
		$this->data['facility_details']=$this->Challan_model->get_facility_types();
		$this->data['depositedto_details']=$this->Challan_model->get_depositedto();
		$this->data['academic_details']=$this->Challan_model->get_academic_details();
		//$this->data['examsession']=$this->Challan_model->get_examsession();
		$this->data['bank_details']= $this->Challan_model->getbanks();
		
		//if(($dats[0]['admission_cycle']=="")||($dats[0]['admission_cycle']==NULL)){
			//print_r($this->data['user_details']);
		//exit();
		$this->data['examsession']=$this->Challan_model->get_examsession();
		$this->load->view('Online_fee_International/add_fees_challan_details_new',$this->data);
		//}else{
		//$this->data['examsession']=$this->Challan_model->get_examsession_phd();
		//$this->load->view($this->view_dir.'add_fees_challan_details_new_phd',$this->data);
		//}
        $this->load->view('footer');
	}
	public function students_data()
	{
		$std_details = $this->Online_feemodel_international->students_data($_POST);   
		//var_dump($std_details);
	   	echo json_encode(array("std_details"=>$std_details));
	}
	
	public function get_fee_details_new()
	{
	 //    error_reporting(E_ALL);
//ini_set('display_errors', 1);

$academic=$_REQUEST['academic'];
$facility=$_REQUEST['facility'];
$enroll=$_REQUEST['enroll'];
$stud=$_REQUEST['stud'];
$curr_yr=$_REQUEST['curr_yr'];
$admission_session=$_REQUEST['admission_session'];

//$check_current=$this->Challan_model->check_current($_POST);
//if($check_current[0]['Total']==0){
	$fee_details =array();$this->Online_feemodel_international->get_fee_details($_POST);
//}else{
	$fee_details_new = $this->Online_feemodel_international->fee_details($_POST);
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
	
	
	public function addpassport(){
		$DB1 = $this->load->database('umsdb', TRUE);
		$payment_id=$_POST['payment_id'];
		$passport=$_POST['passport'];
		 $DB1->where('payment_id', $payment_id);
         $DB1->update('online_payment_international', array('passport' => $passport));
	}
	
	public function uploadimage(){
		//print_r($_POST);
		//echo 'avatar_'.$_POST['id'];
		//print_r($_FILES);
		$DB1 = $this->load->database('umsdb', TRUE);
		 if(!empty($_FILES['file']['name'])){
			 $filenm='INT_'.$_POST['id'].'_'.strtotime(date('h:s',strtotime())).'_'.$_FILES['file']['name'];
			 $config['upload_path'] = 'uploads/internationalpaymentdocuments/';
                $config['allowed_types'] = 'doc|docx|pdf|txt|jpg|jpeg|png';
                $config['overwrite']= false;
                $config['max_size']= "2048000";
                //$config['file_name'] = $_FILES['profile_img']['name'];
                $config['file_name'] = $filenm;
				$this->load->library('upload',$config);
                $this->upload->initialize($config);
				if($this->upload->do_upload('file')){
                    $uploadData = $this->upload->data();
                    $document= $uploadData['file_name'];
					$_POST['id']= str_replace("up_", "",$_POST['id']);
					$DB1->where('payment_id', $_POST['id']);
                    $DB1->update('online_payment_international', array('document' => $document));
                  
                }else{
                    
				}
				
		}
		else{
			//echo "empty";
		}
		
	}
	
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
}
?>