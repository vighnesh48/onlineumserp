<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Letter extends CI_Controller 
{
    var $currentModule="";
    var $title="";
    var $table_name="";
    var $model_name="Bank_letter_model";
    var $model;
    var $view_dir='Bank_letter/';
    var $data=array();
    public function __construct() 
    {
        parent:: __construct();
		//error_reporting(E_ALL);
		//ini_set('display_errors', 1);
        // load form and url helpers
        $this->load->helper(array('form', 'url'));
        $this->load->model("Ums_admission_model");
        // load form_validation library
        $this->load->library('form_validation');
		$this->load->library('pagination');
		$this->currentModule=$this->uri->segment(1);        
       // $this->load->model("Bank_letter_model");
        $this->data['model_name']=$this->model_name;
		$this->load->model($this->model_name);
		$this->load->library('awssdk');
		$this->load->helper('year');
		$this->load->helper('currencyconvertor');
		
		 $this->load->library('M_pdf');
	}
	
	public function index()
    {
        
    }
	
	public function bank_letter_request()
	{				
		$this->data['studentData'] = $this->Ums_admission_model->getStudentByEnrollment($_SESSION['name']);				
		$this->data['type'] = $this->Bank_letter_model->get_types();				
		$this->load->view('header', $this->data);
		$this->load->view($this->view_dir . 'bank_letter_request', $this->data);
		$this->load->view('footer');
	}
	
	public function get_student_details()
	{	

        $enrollment_no=$_POST['enrollment_no'];	
		$data=$this->Ums_admission_model->getStudentByEnrollment($enrollment_no);		
        echo json_encode( $data);
		
	}
	
	
	
	
	public function save_request()
	{
		$studentData = $this->Ums_admission_model->getStudentByEnrollment($this->input->post('enrollmentNumber'));
		
		
		//$postData['enrollment_no'] = $studentData['enrollment_no_new'];
		$postData['academic_year'] = $this->input->post('current_academic_year');
		$postData['request_type'] = $this->input->post('request_type');		
		$postData['student_id'] = $studentData['stud_id'];
		$postData['created_by'] = $studentData['stud_id'];
		$postData['remark'] = $this->input->post('remark');
		$postData['state_code'] = $this->input->post('state_code');
		$postData['is_hostel'] = $this->input->post('is_hostel');
		$postData['created_on'] = date('Y-m-d H:i:s');
		$postData['entry_from_ip'] = $_SERVER['REMOTE_ADDR'];	
		$type=$array = explode('-', $postData['request_type']);
		$postData['request_type'] =$type[2];
		
	    

		$req_details=$this->generate_req($postData['academic_year'],$studentData['stud_id'],$postData['state_code'],$type[1],$type[2]);
		
		$postData['request_no']=$req_details['req_id'];
		$postData['incremented_no']=$req_details['id'];
		
	
		if ($postData['academic_year'] == '' || $postData['remark'] == '') {
			$this->session->set_flashdata('error', 'All fields are required, Please fill in all the fields.');
			redirect('Letter/bank_letter_request'); // Redirect to the view page
		}
		else{
		
		$entry=$this->Bank_letter_model->generate_request($postData);
			if (!empty($entry)) {
			$this->session->set_flashdata('success', 'Your Request saved successfully.');
			redirect('Letter/student_bank_letter_request_list'); // ✅ Desired redirect on success
			} else {
			$this->session->set_flashdata('error', 'Entry not done. Please try again.');
			redirect('Letter/student_bank_letter_request_list'); // 🔁 Stay on the same page if failure
			}
		}
		//
		
		
	

	}
	
	function generate_req($ac,$stud,$state_code,$request_type,$request_type_id){
		
		 $inc_id= $this->Bank_letter_model->get_next_id_formatted($state_code,$request_type_id);
		 $req_id="SUN/$ac/$request_type/$stud/".$state_code."$inc_id";
		 $array= array('id'=> (int)$inc_id,'req_id'=> $req_id);
	    
		return $array;
		
	}
	
		public function student_bank_letter_request_list()
		
		{
		
		
		$da = array(67, 2, 6);  // List of role IDs with full access
		$roleid = $this->session->userdata('role_id');

		if (in_array($roleid, $da)) {
		// Show all data (elevated roles)
		$total_rows = $this->Bank_letter_model->getStudentRefundRequestList('', true);
		} else {
		// Restricted view for other roles
		$total_rows = $this->Bank_letter_model->getStudentRefundRequestList($_SESSION['sname'], true); // Use filtered version if needed
		}

		
		
		// Pagination configuration
		$config = [];
		$config['base_url'] = base_url($this->currentModule.'/student_bank_letter_request_list');
		$config['total_rows'] = $total_rows;
		$config['per_page'] = 3000;
		$config['uri_segment'] = 3;
		// Styling
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$this->pagination->initialize($config);
		// Get current page
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		// Fetch paginated data
		if (in_array($roleid, $da)) {
		$this->data['Studentrequest'] = $this->Bank_letter_model->getStudentRefundRequestList('', false, $config['per_page'], $page);
		} else {
		$this->data['Studentrequest'] = $this->Bank_letter_model->getStudentRefundRequestList($_SESSION['sname'], false, $config['per_page'], $page);
		}
		
		
		$this->data['Studentrequest'] = $this->Bank_letter_model->getStudentRefundRequestList($_SESSION['sname'], false, $config['per_page'], $page);
		$this->data['pagination_links'] = $this->pagination->create_links();
		$this->load->view('header', $this->data);
		$this->load->view($this->view_dir . 'student_bankletter_request_list', $this->data);
		$this->load->view('footer');
		
		}
		
			public function upload_process_doc() {
			$requestId = $this->input->post('request_id');
			$folder_id = $this->input->post('folder_id');
			if(!empty($_FILES['process_doc']['name'])){
			
			$filenm = time() . str_replace(' ', '', $_FILES['process_doc']['name']);
			
			try{
			$bucket_name = 'erp-asset';
			$file_path = 'uploads/requests/'.$folder_id.'/'.$filenm;
			$src_file = $_FILES['process_doc']['tmp_name'];
			$result = $this->awssdk->uploadFile($bucket_name, $file_path, $src_file);
			$this->Bank_letter_model->update_data($requestId,$filenm);
			echo json_encode(['status' => 'success']);
			}catch(Exception $e){
			echo json_encode(['status' => 'error', 'message' => $e]);
			}
			}else{
               echo json_encode(['status' => 'error', 'message' => 'Image not found']);

			}


			}
		
			public function verify_request() {
			$request_id = $this->input->post('request_id');
			$success =  $this->Bank_letter_model->verify_request($request_id);
			if ($success) {
			echo 'success';
			} else {
			http_response_code(500);
			echo 'failure';
			}
			}
		
		
		public function generate_package_pdffff($stud_idd='',$streamd='',$sessiond='') {
			
		$stud_id = $this->input->post('stud_id');
		$stream = $this->input->post('admission_stream');
		$session = $this->input->post('admission_session');

        if(empty($stud_id)){
			$stud_id =$stud_idd;
		}
		if(empty($stream)){
			$stream =$streamd;
		}
		if(empty($session)){
			$session =$sessiond;
		}
        
		
		
		
		require_once FCPATH . '/phpqrcode/qrlib.php';
		if (!file_exists($qr_temp_path)) {
		mkdir($qr_temp_path, 0777, true);
		}
       $qr_temp_path = FCPATH . 'uploads/bankletter/QRcode/';
	   $qr_filename = $qr_temp_path .$stud_id. '_BANKLETTER.png';
		
		$qr_content = base_url('Letter/generate_package_pdf/'.$stud_id.'/'.$stream.'/'.$session);
		QRcode::png($qr_content, $qr_filename, QR_ECLEVEL_H, 4);

    $data = $this->Bank_letter_model->get_package_data($stud_id, $stream, $session);
	
    if (!$data) show_error('Invalid package or student data.');

      $html = $this->load->view('package_template', $data, true); // true = return as string
  
		
		

  
  
	
		$this->m_pdf->pdf = new mPDF('', '', 0, '', 3, 3, 3, 3, 3, 3);

		$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
		$this->m_pdf->pdf->SetFont('dejavusanscondensed');
$this->m_pdf->pdf->WriteHTML($html);
$this->m_pdf->pdf->Output('REQUEST_LETTER.pdf', 'D');
}
		
        public function generate_package_pdf($stud_idd='', $streamd='', $sessiond='', $pdfrqrt='', $request_id='') {
			
    $stud_id = $this->input->post('stud_id');
    $stream = $this->input->post('admission_stream');
    $session = $this->input->post('admission_session');
	$pdfrqrt = $this->input->post('pdfrqrt');
	$request_id = $this->input->post('request_id');

    // Fallback if post data is empty
    if (empty($stud_id)) $stud_id = $stud_idd;
    if (empty($stream)) $stream = $streamd;
    if (empty($session)) $session = $sessiond;
	if (empty($pdfrqrt)) $pdfrqrt = $pdfrqrt;
    if (empty($request_id)) $request_id = $request_id;

    // Prepare QR code path and content
    require_once FCPATH . '/phpqrcode/qrlib.php';
    $qr_temp_path = FCPATH . 'uploads/bankletter/QRcode/';
    if (!file_exists($qr_temp_path)) {
        mkdir($qr_temp_path, 0777, true);
    }

    $qr_filename = $qr_temp_path . $stud_id . '_BANKLETTER.png';
    $qr_url = base_url('Letter/generate_package_pdf/' . $stud_id . '/' . $stream . '/' . $session . '?mode=view');
	//$qr_url $qr_url 
	
    QRcode::png($qr_url, $qr_filename, QR_ECLEVEL_H, 4);

    // Get data
    $data = $this->Bank_letter_model->get_package_data($stud_id, $stream, $session, $request_id);
    if (!$data) show_error('Invalid package or student data.');

    // Render view to HTML
	if($pdfrqrt=='3'){
		 $html = $this->load->view('demand_template', $data, true);	
		
	}
	else{
		 $html = $this->load->view('package_template', $data, true);	
	}
	
   
    $html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');

    // PDF generation
    $this->m_pdf->pdf = new mPDF('', '', 0, '', 3, 3, 3, 3, 3, 3);
    $this->m_pdf->pdf->SetFont('dejavusanscondensed');
    $this->m_pdf->pdf->WriteHTML($html);

    // Check if it's QR or download
    $mode = $this->input->get('mode');
    if ($mode === 'view') {
        // View inline in browser
        $this->m_pdf->pdf->Output($stud_id . '_BANKLETTER.pdf', 'I'); 
    } else {
        // Download mode
        $this->m_pdf->pdf->Output('REQUEST_LETTER.pdf', 'D');
    }
}

}
?>