<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Project extends CI_Controller 
{
    var $currentModule="";
    var $title="";
    var $table_name="project_details";
    var $model_name="Project_model";
    var $model;
    var $view_dir='Project/';
    var $data=array();
    public function __construct() 
    {
        global $menudata;
        parent:: __construct();
        
        $this->load->helper("url");		
        $this->load->library('form_validation');
        date_default_timezone_set('Asia/Kolkata');
        
        if($this->uri->segment(2)!="" && $this->uri->segment(2)!="submit" && !in_array($this->uri->segment(2), $this->skipActions))
           $title=$this->uri->segment(2);                   //Second segment of uri for action,In case of edit,view,add etc.
       else
           $title=$this->master_arr['index'];
       
        $this->load->helper('form');
        $this->currentModule=$this->uri->segment(1);        
        $this->data['currentModule']=$this->currentModule;
		$this->load->model('Subject_model');
		$this->load->model('Timetable_model'); 		
        $this->load->model('Subject_allocation_model');  		
        $this->data['model_name']=$this->model_name;
        
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $model = $this->load->model($this->model_name);
        
        $menu_name=$this->uri->segment(1);        
        $this->data['my_privileges']=$this->retrieve_privileges($menu_name);
        $this->load->library('Awssdk');
        $this->bucket_name =  'erp-asset';
        date_default_timezone_set('Asia/Kolkata');
		$this->db= $this->load->database('umsdb', TRUE);
    }

    public function index()
    {

        $this->load->library('pagination');
    
        // Get search keyword and number of rows per page from request
        $search = $this->input->get('search');
        $limit = $this->input->get('limit') ? (int)$this->input->get('limit') : 150; // Default 10 rows per page
        $offset = $this->uri->segment(3) ? (int)$this->uri->segment(3) : 0; // Page offset
		
		$acad   = $_REQUEST['academic_year'] ?: (defined('ACADEMIC_YEAR') ? ACADEMIC_YEAR : '');
        $school =  $_REQUEST['school'];
		$stream_id =  $_REQUEST['stream_id'];
		
		 $isFilterRequest = ($_REQUEST['academic_year'] || $_REQUEST['school'] || $this->input->get('search'));

    if ($isFilterRequest) {
        $limit  = null; // no limit
        $offset = 0;    // start from first record
    }

		
    
        // Fetch events with pagination
        $config['base_url'] = base_url('Project/index');
        $config['total_rows'] = $this->Project_model->count_projects($search, $acad, $school,$stream_id);
        $config['per_page'] = $limit;
        $config['uri_segment'] = 3;
        $config['query_string_segment'] = 'page';
        $config['reuse_query_string'] = TRUE;
    
        // Bootstrap pagination styles
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

        // print_r($this->session->userdata()); die;
        //$this->data['course_details']= $this->Subject_model->getCollegeCourse();	
        $this->data['projects'] = $this->Project_model->get_projects($limit, $offset, $search, $acad, $school,$stream_id);
		$this->data['acad']   = $acad;
        $this->data['school'] = $school;
		$this->data['stream_id'] = $stream_id;
        $this->data['departments']         = $school ? $this->Project_model->get_departments($school) : [];
        $this->data['selected_stream_id']  = $stream_id;
		
		$this->data['school_list'] = $this->Project_model->get_all_schools();
        $this->data['academic_year']=$this->Project_model->get_acadamic_years();
        $this->data['pagination_links'] = $this->pagination->create_links();
        $this->data['search'] = $search;
        $this->data['limit'] = $limit;

        $this->load->view('header', $this->data);
        $this->load->view($this->view_dir . 'view', $this->data);
        $this->load->view('footer');
    }
    
	
	 public function summarize_listing()
    {

        $this->load->library('pagination');
    
        // Get search keyword and number of rows per page from request
        $search = $this->input->get('search');
        $limit = $this->input->get('limit') ? (int)$this->input->get('limit') : 150; // Default 10 rows per page
        $offset = $this->uri->segment(3) ? (int)$this->uri->segment(3) : 0; // Page offset
		
		$acad   = $_REQUEST['academic_year'] ?: (defined('ACADEMIC_YEAR') ? ACADEMIC_YEAR : '');
        $school =  $_REQUEST['school'];
		$stream_id =  $_REQUEST['stream_id'];
		
		 $isFilterRequest = ($_REQUEST['academic_year'] || $_REQUEST['school'] || $this->input->get('search'));

    if ($isFilterRequest) {
        $limit  = null; // no limit
        $offset = 0;    // start from first record
    }

		
    
        // Fetch events with pagination
        $config['base_url'] = base_url('Project/summarize_listing');
        $config['total_rows'] = $this->Project_model->count_projects($search, $acad, $school,$stream_id);
        $config['per_page'] = $limit;
        $config['uri_segment'] = 3;
        $config['query_string_segment'] = 'page';
        $config['reuse_query_string'] = TRUE;
    
        // Bootstrap pagination styles
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

        // print_r($this->session->userdata()); die;
        //$this->data['course_details']= $this->Subject_model->getCollegeCourse();	
        $this->data['projects'] = $this->Project_model->get_projects_summary($limit, $offset, $search, $acad, $school,$stream_id);
		$this->data['acad']   = $acad;
        $this->data['school'] = $school;
		$this->data['stream_id'] = $stream_id;
        $this->data['departments']         = $school ? $this->Project_model->get_departments($school) : [];
        $this->data['selected_stream_id']  = $stream_id;
		
		$this->data['school_list'] = $this->Project_model->get_all_schools();
        $this->data['academic_year']=$this->Project_model->get_acadamic_years();
        $this->data['pagination_links'] = $this->pagination->create_links();
        $this->data['search'] = $search;
        $this->data['limit'] = $limit;

        $this->load->view('header', $this->data);
        $this->load->view($this->view_dir . 'view_summary', $this->data);
        $this->load->view('footer');
    }
    
	
	
	
	
	
	
	
	
	
    public function download_sample_excel(){

        $this->load->view($this->view_dir . 'project_details_sample_excel', $this->data);

    }

    public function upload_project_details(){
        $this->load->view('header', $this->data);
        $this->data['academic_year']=$this->Project_model->get_acadamic_years();
        $this->load->view($this->view_dir . 'upload_project_details', $this->data);
        $this->load->view('footer');
    }

    function getDayNumber($day) {
        $days = [
            "monday" => 1,
            "tuesday" => 2,
            "wednesday" => 3,
            "thursday" => 4,
            "friday" => 5,
            "saturday" => 6,
            "sunday" => 7
        ];
    
        $day = strtolower($day);
        return $days[$day] ?? null;
    }
    
    function getDayName($number) {
        $days = [
            1 => "monday",
            2 => "tuesday",
            3 => "wednesday",
            4 => "thursday",
            5 => "friday",
            6 => "saturday",
            7 => "sunday"
        ];
    
        return $days[$number] ?? null;
    }


   public function add_project_details(){
    $this->load->view('header', $this->data);
    $this->data['academic_year']=$this->Project_model->get_acadamic_years();
	$this->data['faculty_list']=$this->Timetable_model->get_faculty_list();
	$this->data['school']=$this->Project_model->get_all_schools();
	
	$role=$this->session->userdata("role_id") ;
	$sccode='';
	if($role==10){
    $emp_id = $this->session->userdata("name");
	$ex =explode("_",$emp_id);
	$sccode = $ex[1];
	}
	elseif($role==20){
		$emp_id=$this->session->userdata("aname");
		$get_details_of_school=$this->Subject_model->loadempschool($emp_id);
		if(!empty($get_details_of_school)){
			$sccode =$get_details_of_school[0]['school_code'];
		}
	
	}
	$faculty_items = [];        // [{label:"1001, John, CSE", value:"1001, John, CSE", id:"1001"}, ...]
    $facMap        = [];     
	
	
	$this->data['departments']=$this->Project_model->get_departments($sccode);
    $this->load->view($this->view_dir . 'add_project_details', $this->data);
    $this->load->view('footer');
   }
   
   public function load_departments()
{
    if (!$this->input->is_ajax_request()) { show_404(); }

    $school = $this->security->xss_clean($this->input->post('school', TRUE));

    // Get departments ('' => all)
    $rows = $this->Project_model->get_departments($school);

    $out = [];
    foreach ($rows as $r) {
        $out[] = [
            'stream_id'   => (string)$r['stream_id'],
            'stream_name' => (string)$r['stream_name'],
        ];
    }

    $this->output
        ->set_content_type('application/json; charset=utf-8')
        ->set_output(json_encode($out));
}
   
   public function add_project_detaileeee() {
	  
	 
    $this->load->helper(['security', 'form']);
    $this->load->library('form_validation');

    // Validate form-level inputs
		$this->form_validation->set_rules('academic_year', 'Academic Year', 'required|trim');
		$this->form_validation->set_rules('project_title', 'Project Title', 'required|trim|regex_match[/^[a-zA-Z0-9\s&:-]+$/]');
		$this->form_validation->set_rules('faculty_code', 'Faculty Code', 'required|trim');
		//$this->form_validation->set_rules('project_day', 'Project Day', 'required|trim|integer|greater_than[0]|less_than[8]');
		$this->form_validation->set_rules(
    'domain',
    'Domain',
    'required|trim|regex_match[/^[a-zA-Z0-9\s,&:-]+$/]'
);

$this->form_validation->set_rules(
    'industry_sponsored',
    'Industry Sponsored',
    'required|trim|regex_match[/^[a-zA-Z0-9\s,&:-]+$/]'
);

$this->form_validation->set_rules(
    'programminglanguage',
    'Programming Language',
    'trim|required|max_length[50]|regex_match[/^[A-Za-z0-9\s,&:+\-]+$/u]'
);
		$this->form_validation->set_rules('Bl_level', 'Bloom level', 'trim');
		


    /*$enrollment_nos = $this->input->post('enrollment_no', TRUE);

    if (!is_array($enrollment_nos) || empty($enrollment_nos)) {
        $this->session->set_flashdata('message_project_error', 'Please provide at least one enrollment number.');
        redirect('Project/add_project_details');
        return;
    }

    // Check for duplicates in submitted list
    if (count($enrollment_nos) !== count(array_unique($enrollment_nos))) {
        $this->session->set_flashdata('message_project_error', 'Duplicate enrollment numbers in the submitted list.');
        redirect('Project/add_project_details');
        return;
    }

    // Validate enrollment numbers
    foreach ($enrollment_nos as $enr) {
        if (!preg_match('/^[0-9]{12}$/', $enr)) {
            $this->session->set_flashdata('message_project_error', "Invalid enrollment number: $enr. Must be 12-digit numeric.");
            redirect('Project/add_project_details');
            return;
        }
    }*/

    if ($this->form_validation->run() == FALSE) {
        
	 $msg = trim($this->form_validation->error_string()); // already plain text per delimiters
	 $errs = $this->form_validation->error_array();
 
	
    $this->session->set_flashdata('message_project_error', $msg);
        redirect('Project/add_project_details');
        return;
    }

    // Clean inputs
    

$academic_year       = $this->security->xss_clean($this->input->post('academic_year', TRUE));
$project_title       = $this->security->xss_clean($this->input->post('project_title', TRUE));
$faculty_code        = $this->security->xss_clean($this->input->post('faculty_code', TRUE));
$day                 = (int) $this->security->xss_clean($this->input->post('project_day', TRUE));
$domain              = $this->security->xss_clean($this->input->post('domain', TRUE));
$industry_sponsored  = $this->security->xss_clean($this->input->post('industry_sponsored', TRUE));
$programminglanguage  = $this->security->xss_clean($this->input->post('programminglanguage', TRUE));
$Bl_level  = $this->security->xss_clean($this->input->post('Bl_level', TRUE));
$faculty_code_parts = explode(',', $faculty_code);
$faculty_code_first = trim($faculty_code_parts[0]);

    if (!preg_match('/^[0-9]+$/', $faculty_code_first)) {
    $this->session->set_flashdata('message_project_error', 'Invalid faculty code format. Please pick from suggestions.');
    redirect('Project/add_project_details');
    return;
}


$this->db->from('sandipun_ums.vw_faculty'); // or your actual faculty table/view
$this->db->where('emp_id', $faculty_code_first);

// If you want to restrict to current user’s school (you already computed $sccode):
// $this->db->where('college_id', $sccode);  // adjust column name if different

$fac = $this->db->get()->row_array();
if (empty($fac)) {
    $this->session->set_flashdata('message_project_error', 'Faculty not found. Please select a valid faculty.');
    redirect('Project/add_project_details');
    return;;
}


    // Begin Transaction
    $this->db->trans_start();
	$role=$this->session->userdata("role_id") ;
	if($role==10){
    $emp_id = $this->session->userdata("name");
	$ex =explode("_",$emp_id);
	$sccode = $ex[1];
	}
	elseif($role==20){
		$emp_id=$this->session->userdata("aname");
		$get_details_of_school=$this->Subject_model->loadempschool($emp_id);
		if(!empty($get_details_of_school)){
			$sccode =$get_details_of_school[0]['school_code'];
		}
	
	}
    // Check or insert project
    $this->db->where([
        'project_title' => $project_title,
        'academic_year' => $academic_year
    ]);
    $query = $this->db->get('project_details');

    if ($query->num_rows() > 0) {
    $this->session->set_flashdata('message_project_error', 'Project Title is already added');
    redirect('Project/add_project_details');
    return;;
    } else {
        $this->db->insert('project_details', [
            'project_title' => $project_title,
            'faculty_id' => $faculty_code_first ,
            'project_day' => $day,
            'academic_year' => $academic_year,
            'domain' => $domain,
            'industry_sponsored' => $industry_sponsored,
			'Bl_level' => $Bl_level,
            'programminglanguage' => $programminglanguage,
            'created_by' => $this->session->userdata('uid'),
            'created_at' => date('Y-m-d H:i:s'),
			'school' => $sccode
        ]);
        $project_id = $this->db->insert_id();
    }

    // Insert all student mappings
    /* foreach ($student_ids as $student_id) {
        $this->db->insert('project_student_details', [
            'project_details_id' => $project_id,
            'student_id' => $student_id,
            'faculty_id' => $faculty_code,
            'created_by' => $this->session->userdata('uid'),
            'created_at' => date('Y-m-d H:i:s')
        ]);
    } */

    // Commit transaction
    $this->db->trans_complete();

    if ($this->db->trans_status() === FALSE) {
        $this->session->set_flashdata('message_project_error', 'Something went wrong. Project not saved.');
    } else {
        $this->session->set_flashdata('message_project_success', 'Project added successfully.');
    }

    redirect('Project/add_project_details');
}

   
   
   public function add_project_detail()
{
    $this->load->helper(['security', 'form']);
    $this->load->library('form_validation');

    // Make validation errors plain text (no <p> tags)
    $this->form_validation->set_error_delimiters('', '');

    // (Optional) friendlier regex error message for all regex_match rules
    $this->form_validation->set_message('regex_match', '{field} may include letters, numbers, spaces, commas, &, :, and - only.');

    // Rules
    $this->form_validation->set_rules('academic_year', 'Academic Year', 'required|trim');
    $this->form_validation->set_rules('project_title', 'Project Title', 'required|trim|regex_match[/^[a-zA-Z0-9\s&:-]+$/]');
    $this->form_validation->set_rules('faculty_code', 'Faculty Code', 'required|trim');
	$this->form_validation->set_rules('stream_id', 'Department', 'required');
    $this->form_validation->set_rules('domain', 'Domain', 'required|trim|regex_match[/^[a-zA-Z0-9\s,&:-]+$/]');
    $this->form_validation->set_rules('industry_sponsored', 'Industry Sponsored', 'required|trim|regex_match[/^[a-zA-Z0-9\s,&:-]+$/]');
    $this->form_validation->set_rules('programminglanguage', 'Programming Language', 'trim|required|max_length[50]|regex_match[/^[A-Za-z0-9\s,&:+\-]+$/u]');
    $this->form_validation->set_rules('Bl_level', 'Bloom level', 'trim');

    // Fail fast on validation errors (pack into one multiline message for Toastr)
    if ($this->form_validation->run() === FALSE) {
        $errs = array_values(array_filter($this->form_validation->error_array()));
        $msg  = !empty($errs)
              ? "Please fix:\n• " . implode("\n• ", $errs)
              : "Please check the form and try again.";
        $this->session->set_flashdata('message_project_error', $msg);
        redirect('Project/add_project_details');
        return;
    }

    // Clean inputs
    $academic_year        = $this->security->xss_clean($this->input->post('academic_year', TRUE));
    $project_title        = $this->security->xss_clean($this->input->post('project_title', TRUE));
    $faculty_code         = $this->security->xss_clean($this->input->post('faculty_code', TRUE));
	$stream_id         = $this->security->xss_clean($this->input->post('stream_id', TRUE));
    $day                  = (int) $this->security->xss_clean($this->input->post('project_day', TRUE));
    $domain               = $this->security->xss_clean($this->input->post('domain', TRUE));
    $industry_sponsored   = $this->security->xss_clean($this->input->post('industry_sponsored', TRUE));
    $programminglanguage  = $this->security->xss_clean($this->input->post('programminglanguage', TRUE));
    $Bl_level             = $this->security->xss_clean($this->input->post('Bl_level', TRUE));

    // Faculty code (first part before comma, must be numeric)
    $faculty_code_parts = explode(',', $faculty_code);
    $faculty_code_first = trim($faculty_code_parts[0]);
    if (!preg_match('/^[0-9]+$/', $faculty_code_first)) {
        $this->session->set_flashdata('message_project_error', 'Invalid faculty code format. Please pick from suggestions.');
        redirect('Project/add_project_details');
        return;
    }

    // Verify faculty exists
    $this->db->from('sandipun_ums.vw_faculty');
    $this->db->where('emp_id', $faculty_code_first);
    $fac = $this->db->get()->row_array();
    if (empty($fac)) {
        $this->session->set_flashdata('message_project_error', 'Faculty not found. Please select a valid faculty.');
        redirect('Project/add_project_details');
        return;
    }

    // Get school code based on role (adjust to your session structure)
    $sccode = null;
    $role   = $this->session->userdata('role_id');
    if ($role == 10) {
        // e.g., session "name" like "EMP_SC01"
        $emp_id_str = (string)$this->session->userdata('name');
        $ex = explode('_', $emp_id_str);
        $sccode = isset($ex[1]) ? $ex[1] : null;
    } elseif ($role == 20) {
        $emp_id = $this->session->userdata('aname');
        $schoolRows = $this->Subject_model->loadempschool($emp_id);
        if (!empty($schoolRows)) {
            $sccode = $schoolRows[0]['school_code'] ?? null;
        }
    }

    // Start Txn
    $this->db->trans_start();

    // Duplicate check (title + academic year)
    $this->db->where([
        'project_title' => $project_title,
        'academic_year' => $academic_year
    ]);
    if ($this->db->get('project_details')->num_rows() > 0) {
        $this->db->trans_complete();
        $this->session->set_flashdata('message_project_error', 'Project Title is already added');
        redirect('Project/add_project_details');
        return;
    }

    // Insert project
    $this->db->insert('project_details', [
        'project_title'       => $project_title,
        'faculty_id'          => $faculty_code_first,
		'stream_id'          =>  $stream_id,
		'faculty_details'          => $faculty_code,
		
        'project_day'         => $day,
        'academic_year'       => $academic_year,
        'domain'              => $domain,
        'industry_sponsored'  => $industry_sponsored,
        'Bl_level'            => $Bl_level,
        'programminglanguage' => $programminglanguage,
        'school'              => $sccode,
        'created_by'          => $this->session->userdata('uid'),
        'created_at'          => date('Y-m-d H:i:s'),
    ]);

    $this->db->trans_complete();

    if ($this->db->trans_status() === FALSE) {
        $this->session->set_flashdata('message_project_error', 'Something went wrong. Project not saved.');
    } else {
        $this->session->set_flashdata('message_project_success', 'Project added successfully.');
    }

    redirect('Project/add_project_details');
}

   
  public function edit($id)
{
    $id = (int)$id;

    
      $this->load->view('header', $this->data);

    // Fetch the record
    $project = $this->db->get_where('project_details', ['id' => $id])->row_array();
	
    if (!$project) {
        $this->session->set_flashdata('message_project_error', 'Project not found.');
        redirect('Project');
        return;
    }
    $role=$this->session->userdata("role_id") ;
	$sccode='';
	if($role==10){
    $emp_id = $this->session->userdata("name");
	$ex =explode("_",$emp_id);
	$sccode = $ex[1];
	}
	elseif($role==20){
		$emp_id=$this->session->userdata("aname");
		$get_details_of_school=$this->Subject_model->loadempschool($emp_id);
		if(!empty($get_details_of_school)){
			$sccode =$get_details_of_school[0]['school_code'];
		}
	
	}
   $this->data['academic_year']=$this->Project_model->get_acadamic_years();
   $this->data['faculty_list']=$this->Timetable_model->get_faculty_list();
   
   $this->data['departments'] = $this->Project_model->get_departments($sccode);
    $this->data['project']       = $project;
    // Edit mode flags + data
   $this->data['mode']    = 'edit';
   $this->data['storedEmpId'] = $project['faculty_id'] ?? '';
   $this->data['facDisplay']  = $project['faculty_details'] ?? $project['faculty_id']; 

    // Reuse the same form view
    $this->load->view($this->view_dir.'add_project_details', $this->data);
	 $this->load->view('footer');
}
 
   
   
   
   
   public function add_project_detailss() {
    $this->load->helper(['security', 'form']);
    $this->load->library('form_validation');

    // Validation rules
    $this->form_validation->set_rules('academic_year', 'Academic Year', 'required|trim|xss_clean');
    $this->form_validation->set_rules('project_title', 'Project Title', 'required|trim|xss_clean|regex_match[/^[a-zA-Z0-9\s&:-]+$/]');
    $this->form_validation->set_rules('enrollment_no', 'Enrollment Number', 'required|trim|xss_clean|numeric|exact_length[12]');
    $this->form_validation->set_rules('faculty_code', 'Faculty Code', 'required|trim|xss_clean|numeric');
    $this->form_validation->set_rules('project_day', 'Project Day', 'required|trim|xss_clean|integer|greater_than[0]|less_than[8]');
	$this->form_validation->set_rules('domain', 'Domain', 'required|trim|xss_clean|regex_match[/^[a-zA-Z0-9\s&:-]+$/]');
$this->form_validation->set_rules('industry_sponsored', 'Industry Sponsored', 'required|trim|xss_clean|regex_match[/^[a-zA-Z0-9\s&:-]+$/]');


    if ($this->form_validation->run() == FALSE) {
        $this->session->set_flashdata('message_project_error', validation_errors());
        redirect('Project/upload_project_details');
        return;
    }

    // Clean inputs
    $academic_year = $this->input->post('academic_year', TRUE);
    $project_title = $this->input->post('project_title', TRUE);
    $enrollment_no = $this->input->post('enrollment_no', TRUE);
    $faculty_code = $this->input->post('faculty_code', TRUE);
    $day = (int) $this->input->post('project_day', TRUE);
	$domain = $this->input->post('domain', TRUE);
    $industry_sponsored = $this->input->post('industry_sponsored', TRUE);
    $enrollment_nos = $this->input->post('enrollment_no', TRUE);
	
    // Escape data
    $project_title = $this->db->escape_str($project_title);

    // Check or insert project
    $this->db->where([
        'project_title' => $project_title,
        'faculty_id' => $faculty_code,
        'academic_year' => $academic_year
    ]);
    $query = $this->db->get('project_details');

    if ($query->num_rows() > 0) {
        $project_id = $query->row()->id;
    } else {
        $data_project = [
            'project_title' => $project_title,
            'faculty_id' => $faculty_code,
            'project_day' => $day,
            'academic_year' => $academic_year,
			'domain' => $this->db->escape_str($domain),
            'industry_sponsored'   => $this->db->escape_str($industry_sponsored),			
            'created_by' => $this->session->userdata('uid'),
            'created_at' => date('Y-m-d H:i:s')
        ];
        $this->db->insert('project_details', $data_project);
        $project_id = $this->db->insert_id();
    }

    // Get student ID
    $student_id = $this->Project_model->get_student_id($enrollment_no);
    if (!$student_id) {
        $this->session->set_flashdata('message_project_error', "Student not found for enrollment number $enrollment_no.");
        redirect('Project/upload_project_details');
        return;
    }

    // Check if student already assigned
    $this->db->select('psd.id');
    $this->db->from('project_student_details psd');
    $this->db->join('project_details pd', 'psd.project_details_id = pd.id');
    $this->db->where('psd.student_id', $student_id);
    $this->db->where('pd.academic_year', $academic_year);
    $check = $this->db->get();

    if ($check->num_rows() > 0) {
        $this->session->set_flashdata('message_project_error', "Student already assigned on a project for $academic_year.");
        redirect('Project/upload_project_details');
        return;
    }

    // Insert student-project mapping
    $this->db->insert('project_student_details', [
        'project_details_id' => $project_id,
        'student_id' => $student_id,
        'faculty_id' => $faculty_code,
        'created_by' => $this->session->userdata('uid'),
        'created_at' => date('Y-m-d H:i:s')
    ]);

    $this->session->set_flashdata('message_project_success', "Project assigned successfully.");
    redirect('Project/upload_project_details');
}



    public function import_excel() {
        $this->load->helper('security');
    
        // Get input data
        $academic_year = $this->input->post('academic_year', TRUE);
    
        // Validation rules
        $this->form_validation->set_rules('academic_year', 'Academic Year', 'required|trim');
    
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('message_project_error', 'Project Details Not Added. Please Provide Proper Input');
            redirect('Project/upload_project_details');;
            return;
        }
    
        // Check if a file was uploaded
        if (!isset($_FILES["file"]["name"]) || $_FILES["file"]["error"] != 0) {
            $this->session->set_flashdata('message_project_error', 'Error uploading file. Please try again.');
            redirect('Project/upload_project_details');;
            return;
        }
    
        // File validation
        $allowedMimeTypes = [
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        ];
        $fileType = $_FILES["file"]["type"];
        $fileSize = $_FILES["file"]["size"];
        $maxSize = 5 * 1024 * 1024; // 5MB
    
        if (!in_array($fileType, $allowedMimeTypes)) {
            $this->session->set_flashdata('message_project_error', 'Invalid file format. Please upload an Excel file (.xls or .xlsx).');
            redirect('Project/upload_project_details');;
            return;
        }
    
        if ($fileSize > $maxSize) {
            $this->session->set_flashdata('message_project_error', 'File size exceeds the maximum limit of 5MB.');
            redirect('Project/upload_project_details');;
            return;
        }
    
        // Load Excel library
        $this->load->library("excel");
    
        $path = $_FILES["file"]["tmp_name"];
        $object = PHPExcel_IOFactory::load($path);
    
        $insertedCount = 0;
        $errorEntries = [];
    
        foreach ($object->getWorksheetIterator() as $worksheet) {
            $highestRow = $worksheet->getHighestRow();

            // echo $highestRow; die;
    
            for ($row = 5; $row <= $highestRow; $row++) { // Start reading from row 5
                $SrNo = trim($worksheet->getCellByColumnAndRow(0, $row)->getValue());
                $project_title = trim($worksheet->getCellByColumnAndRow(1, $row)->getValue());
                $enrollment_no = trim($worksheet->getCellByColumnAndRow(2, $row)->getValue());
                $faculty_code = trim($worksheet->getCellByColumnAndRow(3, $row)->getValue());
                $day = trim($worksheet->getCellByColumnAndRow(4, $row)->getValue());
                $day = strtolower($day);

                if (empty($project_title) || empty($enrollment_no) || empty($faculty_code)) {
                    echo "Missing Check";
                    $errorEntries[] = "Sr No.  $SrNo: Missing required data (Project Title, Enrollment No, or Faculty Code).";
                    continue;
                }
    
                // Check if project already exists
                $this->db->where('project_title', $project_title);
                $this->db->where('faculty_id', $faculty_code);
                $this->db->where('academic_year', $academic_year);
                $query = $this->db->get('project_details');
    
                if ($query->num_rows() > 0) {
                    // Project exists, get its ID
                    $project = $query->row();
                    $project_id = $project->id;
                } else {
                    // Insert new project
                    $data_project = [
                        'project_title' => $project_title,
                        'faculty_id' => $faculty_code,
                        'project_day' => $this->getDayNumber($day),
                        'academic_year' => $academic_year,
                        'created_by' => $this->session->userdata('uid'),
                        'created_at' => date('Y-m-d H:i:s')

                    ];
                    $this->db->insert('project_details', $data_project);
                    $project_id = $this->db->insert_id();
                }
    
                // Get student ID from enrollment number
                $student_id = $this->Project_model->get_student_id($enrollment_no);
    
                if (!$student_id) {
                    echo "Student_check";
                    $errorEntries[] = "Sr No. $SrNo: Student ID not found for Enrollment No: $enrollment_no.";
                    continue;
                }
    
                // Check if student is already assigned to a project in the same academic year
                $this->db->select('psd.id');
                $this->db->from('project_student_details psd');
                $this->db->join('project_details pd', 'psd.project_details_id = pd.id');
                $this->db->where('psd.student_id', $student_id);
                $this->db->where('pd.academic_year', $academic_year);
                $check_student = $this->db->get();
    
                if ($check_student->num_rows() > 0) {
                    echo "Project_check";
                    $errorEntries[] = "Sr No. $SrNo: Student already assigned a project for Academic Year: $academic_year.";
                    continue;
                }
    
                // Insert student details linked to the project
                $data_student = [
                    'project_details_id' => $project_id,
                    'student_id' => $student_id,
                    'faculty_id' => $faculty_code,
                    'created_by' => $this->session->userdata('uid'),
                    'created_at' => date('Y-m-d H:i:s')
                ];
                $this->db->insert('project_student_details', $data_student);
                $insertedCount++;
            }
        }
    
        if ($insertedCount > 0) {
            $successMessage = "$insertedCount records imported successfully!";
            $this->session->set_flashdata('message_project_success', $successMessage);
        } else {
            $successMessage = "No records were inserted.";
        }
    
        // Show error messages if any
        if (!empty($errorEntries)) {

            $errorMessage = "Some entries could not be inserted:<br>" . implode("<br>", $errorEntries);
            $toastErrorMessage = "Some Entries could not be inserted";
        } else {
            $errorMessage = "";
        }
    
        
        if ($errorMessage) {
            $this->session->set_flashdata('message_project_error', $toastErrorMessage);
            $this->session->set_flashdata('message_project_model_error', $errorMessage);
        }
    
        redirect('Project/upload_project_details'); // Replace with your actual page
    }



    public function view_project_students($project_id='',$academic_year='') {

        $project_id = base64_decode($project_id);
		$academic_year = base64_decode($academic_year);
        
        $this->load->view('header', $this->data);

        $this->data['project_details'] = $this->Project_model->get_project_details($project_id);
        $this->data['project_students'] = $this->Project_model->get_project_students($project_id, $faculty_code = '', $academic_year = '');

        // print_r($this->data['project_details']); die;

        $this->load->view($this->view_dir . 'view_project_students', $this->data);
        $this->load->view('footer');
    }
    
	
	
   public function view_project_attendence()
{
    // --- Inputs ---
    $role_id       = (int)$this->session->userdata('role_id');
    $session_fac   = $this->session->userdata('name'); // faculty code in session
    $faculty_code  = $this->input->post('faculty_code') ?: $session_fac;
    $academic_year = $this->input->post('academic_year') ?: (defined('ACADEMIC_YEAR') ? ACADEMIC_YEAR : '');
    $dateYmd       = $this->input->post('today_date') ?: $this->input->post('date') ?: date('Y-m-d');
    $dayName       = date('l', strtotime($dateYmd));

    $is_today_applicable = 0;
    $today_slots = [];

    if ($faculty_code && $academic_year) {
        // Build query carefully
        $this->db->start_cache();
        $this->db->select('ps.proj_slot_id, ps.from_time, ps.to_time');
        $this->db->from('project_timetable pt');
        $this->db->join('project_details pd', 'pd.id = pt.project_id', 'inner'); // <-- confirm table is actually "projectdetails"
        $this->db->join('project_slot ps', 'ps.proj_slot_id = pt.proj_slot_id', 'inner');
        $this->db->where('pd.faculty_id', $faculty_code);
        $this->db->where('pt.academic_year', $academic_year);
        $this->db->where('pt.wday', $dayName);
        $this->db->where('ps.is_active', 'Y');
        if ($this->db->field_exists('status','project_timetable')) {
            $this->db->where('pt.status', 'Y');
        }
        $this->db->stop_cache();

        // Group/order (use separate calls for maximum compatibility)
        $this->db->group_by('ps.proj_slot_id');
        $this->db->group_by('ps.from_time');
        $this->db->group_by('ps.to_time');
        $this->db->order_by('ps.from_time', 'asc');

        $q = $this->db->get();
        $this->db->flush_cache();

        if ($q !== false) {
            foreach ($q->result_array() as $r) {
                $today_slots[] = [
                    'proj_slot_id' => (int)$r['proj_slot_id'],
                    'label'        => $r['from_time'].' - '.$r['to_time'],
                ];
            }
            $is_today_applicable = count($today_slots) ? 1 : 0;
        } else {
            // Log the DB error so you can see why it failed
            $err = $this->db->error(); // ['code'] and ['message']
            log_message('error', 'view_project_attendence slots query FAILED: '
                . ($err['code'] ?? '') . ' ' . ($err['message'] ?? '')
                . ' | SQL: ' . $this->db->last_query());
            // Keep $is_today_applicable=0 and $today_slots=[]
        }
    }

    // --- Pass to view ---
    $this->data['is_today_applicable'] = $is_today_applicable;   // 1/0
    $this->data['today_slots']         = $today_slots;           // [] or [{proj_slot_id,label}]
    $this->data['today_date']          = $dateYmd;
    $this->data['today_day']           = $dayName;

    // Existing data
    $this->data['projects']  = $this->Project_model->get_projects_dropdown();
    $this->data['faculties'] = $this->Project_model->get_faculties_for_mark_attendence();
    $this->data['slots']     = $this->Project_model->getSlots();

    // Render
    $this->load->view('header', $this->data);
    $this->load->view($this->view_dir . 'view_project_attendence', $this->data);
    $this->load->view('footer');
}

    public function search_project_students()
    {   
        if($_POST['faculty_code']){
            $faculty_code = $_POST['faculty_code'];
        }else{
            $faculty_code = $this->session->userdata("name");
        }
		
		//print_r($_POST);
		//exit;
        $this->load->view('header',$this->data);                    
		$this->data['slot_no'] = $_POST['slot_no'];
        // $this->data['projects'] = $this->Project_model->get_projects_dropdown();
        $this->data['slots'] = $this->Project_model->getSlots();
        $project_id=$this->data['project_id'] = $_POST['project_id'];
		$td=$_POST['today_date'];
		
		$curr_session= $this->Project_model->getCurrentSession();
		;
		$this->data['academic_year'] = ACADEMIC_YEAR;
        $this->data['faculties'] = $this->Project_model->get_faculties_for_mark_attendence();
        $this->data['faculty_code'] = $faculty_code;

        $this->data['project_students']= $this->Project_model->get_project_students($project_id, $faculty_code, $this->data['academic_year']);

        $this->load->view($this->view_dir.'view_project_attendence',$this->data);
		
        $this->load->view('footer');
    } 

    public function markAttendance()
    {  
         
	
		$DB1 = $this->load->database('umsdb', TRUE);
        if($_POST['faculty_code'] ==''){
            $emp_id = $this->session->userdata("name");
        } else{
            $emp_id = $_POST['faculty_code'];
        }
		$today = $_POST['today_date'];
		$project_id = $_POST['project_id'];
        $checked_stud = json_decode($this->input->post('chk_stud'), true);
        $uncheck_stud = json_decode($this->input->post('chk_unstud'), true);
		$slot = $_POST['slot'];
        $report_desc = $_POST['report_desc'];
		$academic_year = $_POST['academic_year'];


		$CntDup = $this->Project_model->check_dup_attendance($today, $project_id, $emp_id);

		if(count($CntDup) == 0){
          
            if (!empty($_FILES['report']['name'])) {
                // Load AWS SDK
                $this->load->library('awssdk'); // Ensure you have AWS SDK loaded
            
                // Generate a unique file name
                $file_extension = pathinfo($_FILES['report']['name'], PATHINFO_EXTENSION);
                $unique_file_name = time() . '_' . uniqid() . '.' . $file_extension;
            
                // Define S3 file path
                $s3_file_path = 'uploads/project_report/'. $unique_file_name;
            
                // S3 Bucket details
                $bucket_name = $this->bucket_name;
                $file_tmp_path = $_FILES['report']['tmp_name'];
            
                try {
                    // Upload file to S3
                    $result = $this->awssdk->uploadFile($bucket_name, $s3_file_path, $file_tmp_path);
            
                    // Store unique file name in the database
                    $data['report'] = $unique_file_name;
            
                } catch (Exception $e) {
                    return ['status' => false, 'error' => 'File upload failed: ' . $e->getMessage()];
                }
            }
            

            if(!empty($checked_stud)){

                foreach($checked_stud as $key => $stud_checked){

                    $data['stud_id'] = $stud_checked['stud_id'];
                    $data['slot'] = $slot;
                    $data['project_details_id'] = $stud_checked['project_details_id'];
                    $data['academic_year'] = $_POST['academic_year'];
                    $data['attendance_date'] = $today;
                    $data['is_present'] = 'Y';
                    $data['remark'] = $stud_checked['remark'];
                    $data['created_at'] = date('Y-m-d H:i:s');
                    $data['faculty_code'] = $emp_id;
                    $data['report_desc'] = $report_desc;

    
                    $this->Project_model->markAttendance($data);
                }
            }

            if(!empty($uncheck_stud)){

                foreach($uncheck_stud as $key => $stud_unchecked){

                    $data['stud_id'] = $stud_unchecked['stud_id'];
                    $data['slot'] = $slot;
                    $data['project_details_id'] = $stud_unchecked['project_details_id'];
                    $data['academic_year'] = $_POST['academic_year'];
                    $data['attendance_date'] = $today;
                    $data['is_present'] = 'N';
                    $data['remark'] = $stud_unchecked['remark'];
                    $data['created_at'] = date('Y-m-d H:i:s');
                    $data['faculty_code'] = $emp_id;
                    $data['report_desc'] = $report_desc;

    
                    $this->Project_model->markAttendance($data);
                }
            }




		}else{
			echo "dupyes";
		}

    } 


    public function report_attendance_view(){
        $this->load->view('header', $this->data);
        $this->data['academic_years'] = $this->Project_model->get_acadamic_years();
		
		$role=$this->session->userdata("role_id") ;
	$sccode='';
	if($role==10){
    $emp_id = $this->session->userdata("name");
	$ex =explode("_",$emp_id);
	$sccode = $ex[1];
	}
	elseif($role==20){
		$emp_id=$this->session->userdata("aname");
		$get_details_of_school=$this->Subject_model->loadempschool($emp_id);
		if(!empty($get_details_of_school)){
			$sccode =$get_details_of_school[0]['school_code'];
		}
	
	}
	
         $this->data['projects'] = $this->Project_model->get_projects_dropdown($sccode);
		 
		
		
        // $this->data['faculties'] = $this->Project_model->get_faculties();
        $this->load->view($this->view_dir . 'report_attendance', $this->data);
        $this->load->view('footer');
    }

    public function search_project_attendance()
    {

        $academic_year = $this->input->post('academic_year');
        $project_details_id = $this->input->post('project_details_id');
        $faculty_code = $this->input->post('faculty_code');
		if($faculty_code ==''){
			$faculty_code = $this->session->userdata("name");
		}else{
			$this->data['faculty_code'] = $faculty_code;
		}

        
        
        $this->load->view('header',$this->data);  


		// $this->data['sb']= $this->Attendance_model->get_project_details($project_id);
        // $this->data['projects'] = $this->Project_model->get_projects_dropdown();
		$this->data['attCnt']= $this->Project_model->fetchFacAttDates($faculty_code,$academic_year,$project_details_id);
		
		
        // print_r($this->data['attCnt']);
        $this->data['academic_years'] = $this->Project_model->get_acadamic_years();
        $this->data['academic_year'] = $academic_year;
        $this->data['project_details_id'] = $project_details_id;


		
		for($i=0;$i<count($this->data['attCnt']);$i++){
			$attendance_date = $this->data['attCnt'][$i]['attendance_date'];
			$slot = $this->data['attCnt'][$i]['slot'];
			$this->data['attCnt'][$i]['P_attCnt']= $this->Project_model->fetchFacAttPresent($attendance_date,$project_details_id,$faculty_code,$slot,$academic_year);
			$this->data['attCnt'][$i]['A_attCnt']= $this->Project_model->fetchFacAttAbsent($attendance_date,$project_details_id,$faculty_code,$slot,$academic_year);
		}
        // echo "<pre>";
        // print_r($this->data['attCnt']); exit;

        $this->load->view($this->view_dir.'report_attendance',$this->data);
        $this->load->view('footer');
    } 

    public function fetchDateSlotwiseAttDetails()
    {    

		if(!empty($_POST['empId'])){
			$emp_id = $_POST['empId'];
		}else{
			$emp_id = $this->session->userdata("name");	
		}	

		$att_date = $_POST['att_date'];
		$project_details_id = $_POST['project_details_id'];
		$slot = $_POST['slot'];
        $academic_year = $_POST['academic_year'];

		
		$stud_att = $this->Project_model->fetchDateSlotwiseAttDetails($att_date,$project_details_id,$slot,$emp_id, $academic_year);

        // print_r($stud_att); exit;
		//echo count($CntDup);
		if(!empty($stud_att)){			
			$allstd = array();
			$allstd['ss'] = $stud_att;
			$str4 = json_encode($allstd);
			echo $str4;
		}else{
			echo "dupyes";
		}
    }

    public function fetch_project_faculty(){
        $academic_year = $this->input->post('academic_year');

        $sql = "SELECT DISTINCT pd.faculty_id as faculty_code, em.fname, em.mname, em.lname FROM project_details pd JOIN vw_faculty em ON em.emp_id=pd.faculty_id WHERE academic_year='".$academic_year."'";
        
        $query = $this->db->query($sql);
        $result = $query->result_array();
        echo json_encode($result);
        
    }

    public function fetch_facultyWise_projects(){
        $faculty_code = $this->input->post('faculty_code');
        $academic_year = $this->input->post('academic_year');

        $sql = "SELECT pd.id, pd.project_title FROM project_details pd WHERE pd.faculty_id='".$faculty_code."' AND pd.academic_year='".$academic_year."'";
        // echo $sql; exit;
        $query = $this->db->query($sql);
        $result = $query->result_array();
        echo json_encode($result);
    }

    /* project report start*/
function get_attendance_mark_report(){
//error_reporting(E_ALL);

$this->data['sch_list']= $this->Project_model->get_school_list();
$this->data['academic_year']=$this->Project_model->get_acadamic_years();  

$this->load->view('header',$this->data);        
$this->load->view($this->view_dir.'project_attendance_mark_report',$this->data);
$this->load->view('footer');
}

function get_courses(){
$crs_list = $this->Project_model->get_course_list($_REQUEST['school_id']);
echo "<option value=''>Select All Courses</option>";
foreach ($crs_list as $key => $value) {
echo "<option value='".$value['course_id']."'>".$value['course_short_name']."</option>";
}
}

function get_stream(){
$stm_list = $this->Project_model->get_stream_list($_REQUEST['course_id'],$_REQUEST['sch_id']);
echo "<option value=''>Select All Streams</option>";
foreach ($stm_list as $key => $value) {
echo "<option value='".$value['stream_id']."'>".$value['stream_name']."</option>";
}

}

function get_mark_report() {
// Enable error reporting for debugging
// error_reporting(E_ALL);

// Validate and sanitize input
$academic_year = isset($_REQUEST['acd_yer']) ? $this->db->escape_str($_REQUEST['acd_yer']) : '';
$school_code = isset($_REQUEST['sch_id']) ? intval($_REQUEST['sch_id']) : 0;
$course_id = isset($_REQUEST['curs']) ? intval($_REQUEST['curs']) : 0;
$stream_id = isset($_REQUEST['strm']) ? intval($_REQUEST['strm']) : 0;
$from_date = isset($_REQUEST['fdt']) ? $this->db->escape_str($_REQUEST['fdt']) : '';
$to_date = isset($_REQUEST['tdt']) ? $this->db->escape_str($_REQUEST['tdt']) : '';

// Ensure mandatory fields are present
if (!$academic_year || !$from_date || !$to_date ) {
die("Error: Missing required parameters.");
}

$result =  $this->Project_model->get_attendance_data($academic_year, $school_code, $course_id, $stream_id, $from_date, $to_date);
//echo '<pre>';
//print_r($result); die;


$result = $this->transformAttendance($result);


// Store the result
$this->data['attendance'] = $result;

// Load the view
$this->load->view($this->view_dir . 'ajax_student_report', $this->data);
}

function transformAttendancefsfdf($data) {
$attendance = [];

foreach ($data as $entry) {




$courseKey = $entry['school_short_name'];

if (!isset($attendance[$courseKey])) {
$attendance[$courseKey] = [
'school' => $entry['school_short_name'], // Adjust as needed
'course' => $entry['course_short_name'],
'stream' => $entry['stream_name'],
'dates' => []
];
}

$dateKey = $entry['attendance_date']; // Group by date

if (!isset($attendance[$courseKey]['dates'][$dateKey])) {
$attendance[$courseKey]['dates'][$dateKey] = [
'faculty' => []
];
}

// Assign students under respective faculty
$facultyName = $entry['faculty_name']."-".$entry['project_title'];

if (!isset($attendance[$courseKey]['dates'][$dateKey]['faculty'][$facultyName])) {
$attendance[$courseKey]['dates'][$dateKey]['faculty'][$facultyName] = [];
}

// Add student details under the faculty
$attendance[$courseKey]['dates'][$dateKey]['faculty'][$facultyName][] = [
'prn' => $entry['enrollment_no'],
'name' => $entry['student_name'],
'attendance' => ($entry['is_present'] === 'Y') ? 'P' : 'A',
'remark' => $entry['remark']
];
}

return $attendance;
}


	
	function transformAttendance111($data) {
    $attendance = [];

    foreach ($data as $entry) {
        $schoolKey = $entry['school_short_name'];
        $courseKey = $entry['course_short_name'];
        $dateKey = $entry['attendance_date'];
        $facultyName = $entry['faculty_name']."-".$entry['project_title'];;

        // Initialize school level
        if (!isset($attendance[$schoolKey])) {
            $attendance[$schoolKey] = [];
        }

        // Initialize course level under school
        if (!isset($attendance[$schoolKey][$courseKey])) {
            $attendance[$schoolKey][$courseKey] = [
                'course' => $courseKey,
                'stream' => $entry['stream_name'],
                'dates' => []
            ];
        }

        // Initialize date level under course
        if (!isset($attendance[$schoolKey][$courseKey]['dates'][$dateKey])) {
            $attendance[$schoolKey][$courseKey]['dates'][$dateKey] = [
                'faculty' => []
            ];
        }

        // Initialize faculty level under date
        if (!isset($attendance[$schoolKey][$courseKey]['dates'][$dateKey]['faculty'][$facultyName])) {
            $attendance[$schoolKey][$courseKey]['dates'][$dateKey]['faculty'][$facultyName] = [];
        }

        // Add student details under the faculty
        $attendance[$schoolKey][$courseKey]['dates'][$dateKey]['faculty'][$facultyName][] = [
            'prn' => $entry['enrollment_no'],
            'name' => $entry['student_name'],
            'attendance' => ($entry['is_present'] === 'Y') ? 'P' : 'A',
            'remark' => $entry['remark']
        ];
    }

    return $attendance;
}

    
	function transformAttendance($data) {
    $attendance = [];

    foreach ($data as $entry) {
        $schoolKey = $entry['school_short_name'];
        $courseKey = $entry['course_short_name'];
        $dateKey = $entry['attendance_date'];
        $facultyName = $entry['faculty_name'];
        $projectTitle = $entry['project_title'];

        // Initialize school level
        if (!isset($attendance[$schoolKey])) {
            $attendance[$schoolKey] = [];
        }

        // Initialize course level under school
        if (!isset($attendance[$schoolKey][$courseKey])) {
            $attendance[$schoolKey][$courseKey] = [
                'course' => $courseKey,
                'stream' => $entry['stream_name'],
                'dates' => []
            ];
        }

        // Initialize date level under course
        if (!isset($attendance[$schoolKey][$courseKey]['dates'][$dateKey])) {
            $attendance[$schoolKey][$courseKey]['dates'][$dateKey] = [
                'faculty' => []
            ];
        }

        // Initialize faculty level under date
        if (!isset($attendance[$schoolKey][$courseKey]['dates'][$dateKey]['faculty'][$facultyName])) {
            $attendance[$schoolKey][$courseKey]['dates'][$dateKey]['faculty'][$facultyName] = [
                'project_title' => $projectTitle,
                'students' => []
            ];
        }

        // Add student details under the faculty
        $attendance[$schoolKey][$courseKey]['dates'][$dateKey]['faculty'][$facultyName]['students'][] = [
            'prn' => $entry['enrollment_no'],
            'name' => $entry['student_name'],
            'attendance' => ($entry['is_present'] === 'Y') ? 'P' : 'A',
            'remark' => $entry['remark']
        ];
    }

    return $attendance;
}

	function transformAttendancerevised($data) {
    $attendance = [];

    foreach ($data as $entry) {
        $schoolKey = $entry['school_short_name'];
        $courseKey = $entry['course_short_name'];
        $dateKey = $entry['attendance_date'];
        $facultyName = $entry['faculty_name'];
        $projectTitle = $entry['project_title'];

        // Initialize school level
        if (!isset($attendance[$schoolKey])) {
            $attendance[$schoolKey] = [];
        }

        // Initialize course level under school
        if (!isset($attendance[$schoolKey][$courseKey])) {
            $attendance[$schoolKey][$courseKey] = [
                'course' => $courseKey,
                'stream' => $entry['stream_name'],
                'dates' => []
            ];
        }

        // Initialize date level under course
        if (!isset($attendance[$schoolKey][$courseKey]['dates'][$dateKey])) {
            $attendance[$schoolKey][$courseKey]['dates'][$dateKey] = [
                'faculty' => []
            ];
        }

        // Initialize faculty level under date
        if (!isset($attendance[$schoolKey][$courseKey]['dates'][$dateKey]['faculty'][$facultyName])) {
            $attendance[$schoolKey][$courseKey]['dates'][$dateKey]['faculty'][$facultyName] = [
                'project_title' => $projectTitle,
                'students' => []
            ];
        }

        // Add student details under the faculty
        $attendance[$schoolKey][$courseKey]['dates'][$dateKey]['faculty'][$facultyName]['students'][] = [
            'prn' => $entry['enrollment_no'],
            'name' => $entry['student_name'],
            'attendance' => ($entry['is_present'] === 'Y') ? 'P' : 'A',
            'remark' => $entry['remark'],'link'=> $entry['report']
        ];
    }

    return $attendance;
}


    function get_faculties($school_code){
        $sql = "SELECT DISTINCT
                    pd.faculty_id,
                    CONCAT_WS(
                        ' ',
                        vwf.fname,
                        NULLIF(vwf.mname, ''),
                        vwf.lname
                    ) AS faculty_name,
                    vwf.designation_name
                FROM
                    sandipun_erp.project_details pd
                JOIN vw_faculty vwf ON
                    vwf.emp_id = pd.faculty_id"
                . " WHERE vwf.emp_school = '" . $school_code . "'";

        $query = $this->db->query($sql);
        $result = $query->result_array();
        echo json_encode($result);
    }
	
	
	public function allocate_students()
    {
		$trigger_search = false;
        $this->load->view('header', $this->data);          
		
      
	    
		$this->data['course_details']= $this->Subject_model->getCollegeCourse($college_id);		   
		$this->data['academic_year']= $this->Subject_model->getAcademicYear(); 
		
		
		if(!empty($_POST)){
				$academic_year = explode('-',$_POST['academic_year']);
		        $academic_year =$academic_year[0];				
				$course_id=$_POST['course_id'];
				$stream_id=$_POST['stream_id'];	
                $selected_year =$_POST['academic_year'];
				$semester = $_POST['semester'];
				$selected_course = $course_id;
				$selected_stream = $stream_id;
			 
			$this->data['studlist']= $this->Subject_allocation_model->get_stud_list($stream_id,$semester,$academic_year);		
			$this->data['allcated_studlist']= $this->Project_model->get_allcated_studlist($_POST['academic_year']);
            $this->data['projects']= $this->Project_model->get_projects('','','',$_POST['academic_year']);	
		    $this->data['assigned_project_ids'] = $this->Project_model->get_assigned_project_ids($_POST['academic_year'] ?? ACADEMIC_YEAR);
			 $this->data['assigned_counts'] = $this->Project_model->get_project_assignment_counts($_POST['academic_year']);
		}
		else{
			$selected_year = $this->session->userdata('alloc_academic_year');
			$selected_course = $this->session->userdata('alloc_course_id');
			$selected_stream = $this->session->userdata('alloc_stream_id');
			$semester = $this->session->userdata('alloc_semester');
			if ($this->session->userdata('trigger_search_once')) {
			$trigger_search = true;
			$this->session->unset_userdata('trigger_search_once'); // ✅ clear it!
			}
            $this->data['assigned_counts'] = $this->Project_model->get_project_assignment_counts($selected_year);
			// clear the data used for dropdowns too (optional)
			$this->session->unset_userdata(['alloc_academic_year', 'alloc_course_id', 'alloc_stream_id','alloc_semester']);
			
		}
		
		
		if (!empty($selected_year) && !empty($selected_course) && !empty($selected_stream)) {
		$this->data['SAacademic_year']=	$selected_year;
		$this->data['selected_course'] = $selected_course;
		$this->data['selected_stream'] = $selected_stream;
		$this->data['selected_semester'] = $semester;
		}
		$this->data['trigger_search'] = $trigger_search;     
		
		
		   
        $this->load->view($this->view_dir.'allocate_students',$this->data);
        $this->load->view('footer');
    } 

   
   
   public function assign_projectToStudent()
{
    $this->load->model('Project_model');
	
    $student_ids = $this->input->post('chk_stud');
    $project_id = $this->input->post('chk_sub'); 
    $faculty_map = $this->input->post('faculty_id_map');
    $academic_year = $this->input->post('acad_year');
	
	$this->session->set_userdata([
		'alloc_academic_year' => $this->input->post('acad_year'),
		'alloc_course_id'     => $this->input->post('course_id'),
		'alloc_stream_id'     => $this->input->post('stream_id'),
		'alloc_semester'     => $this->input->post('semester'),		
		'trigger_search_once' => true 
		]);


    if (empty($student_ids) || empty($project_id)) {
        $this->session->set_flashdata('message_project_error', 'Please select at least one student and one project.');
        redirect('Project/allocate_students');
        return;
    }

	
    $MAX_CAPACITY = 5;

    $this->db->trans_begin();
	
	// Lock the project row to serialize allocations
    $this->db->query("SELECT id FROM project_details WHERE id = ? FOR UPDATE", [$project_id]);
	
	// Current count for this project+year
	 $row = $this->db->query(
        "SELECT COUNT(*) AS cnt
         FROM project_student_details
         WHERE project_details_id = ? AND academic_year = ?",
        [$project_id, $academic_year]
    )->row_array();
	
	 $current   = (int)($row['cnt'] ?? 0);
    $remaining = max(0, $MAX_CAPACITY - $current);
	
	if (count($student_ids) > $remaining) {
        $this->db->trans_rollback();
        $this->session->set_flashdata(
            'message_project_error',
            "Only {$remaining} slot(s) left for this project in {$academic_year}. Please reduce your selection."
        );
        redirect('Project/allocate_students'); return;
    }
	
    foreach ($student_ids as $stud_id) {

        // Check if already assigned in this academic year
        $check = $this->db->select('psd.id')
            ->from('project_student_details psd')
            ->join('project_details pd', 'psd.project_details_id = pd.id')
            ->where('psd.student_id', $stud_id)
            ->where('pd.academic_year', $academic_year)
			 ->where('psd.academic_year', $academic_year)
            ->get();

        if ($check->num_rows() > 0) {
            $enr = $this->Project_model->get_enrollment_by_studid($stud_id);
            $this->session->set_flashdata('message_project_error', "Student with enrollment $enr is already assigned in $academic_year.");
            redirect('Project/allocate_students');
            return;
        }
		
		 // Extra safety: skip if this exact mapping exists
        $existsSameProject = $this->db->get_where('project_student_details', [
            'project_details_id' => $project_id,
            'academic_year'      => $academic_year,
            'student_id'         => $stud_id
        ])->row();
		
		if ($existsSameProject) { continue; }
		
		$faculty_id = $this->input->post('faculty_id_map')[$project_id] ?? null;
		$data = [
		'student_id' => $stud_id,
		'project_details_id' => $project_id,
		'faculty_id' => $faculty_id,
		'academic_year' => $academic_year,
		'created_by' => $this->session->userdata('uid'),
		'created_at' => date('Y-m-d H:i:s')
		];

      $this->db->insert('project_student_details', $data);

       if ($this->db->trans_status() === FALSE) {
        $this->db->trans_rollback();
        $this->session->set_flashdata('message_project_error', 'Assignment failed. Please try again.');
        redirect('Project/allocate_students'); return;
    }

    $this->db->trans_commit();
    }
		
		
		
    $this->session->set_flashdata('Smessage', 'Project assigned successfully!');
    redirect('Project/allocate_students');
}

   public function timetable()
    {
       
         $this->load->view('header', $this->data);      

        // dropdown data
        $this->data['academic_years'] = $this->Project_model->get_acadamic_years();  // from model
        $this->data['slots']          = $this->Project_model->getSlots();

        // Restore last filters (optional)
        $sel_year    = $this->session->userdata('PT_academic_year') ?: '';
        $sel_project =  '';

        $this->data['sel_year']    = $sel_year;
        $this->data['sel_project'] = $sel_project;
		 $role=$this->session->userdata("role_id") ;
	$sccode='';
	if($role==10){
    $emp_id = $this->session->userdata("name");
	$ex =explode("_",$emp_id);
	$sccode = $ex[1];
	}
	elseif($role==20){
		$emp_id=$this->session->userdata("aname");
		$get_details_of_school=$this->Subject_model->loadempschool($emp_id);
		if(!empty($get_details_of_school)){
			$sccode =$get_details_of_school[0]['school_code'];
		}
	
	}
  
   
        $this->data['departments'] = $this->Project_model->get_departments($sccode);		
        $this->data['projects']    = $sel_year ? $this->Project_model->get_projects_for_dropdown($sel_year) : $this->Project_model->get_projects_for_dropdown(ACADEMIC_YEAR);
         
        // List data
        $filters = [];
        if ($sel_year)    $filters['academic_year'] = $sel_year;
        if ($sel_project) $filters['project_id']    = $sel_project;
        $this->data['rows'] = $this->Project_model->list_timetable($filters);

        $this->load->view($this->view_dir.'project_timetable_form', $this->data);
        $this->load->view('footer');
    }
	
	
	
	public function load_projects_by_stream()
{
    if (!$this->input->is_ajax_request()) { show_404(); }

    $stream_id     = (int) $this->security->xss_clean($this->input->post('stream_id', TRUE));
    $academic_year = $this->security->xss_clean($this->input->post('academic_year', TRUE)); // optional

    // Get projects for this department (and optional AY)
    $rows = $this->Project_model->get_projects_by_stream($stream_id, $academic_year);

    // Normalize payload for the view
    $out = [];
    foreach ($rows as $r) {
        $out[] = [
            'id'     => (string)$r['id'],
            'title'  => (string)$r['project_title'],
            'domain' => (string)($r['domain'] ?? ''),
        ];
    }

    $this->output
        ->set_content_type('application/json; charset=utf-8')
        ->set_output(json_encode($out));
}
	
	
	public function timetable_savehhh()
{
    // Basic required fields
    $p = $this->input->post();
    $id = (int)($p['id'] ?? 0);

    // persist filters for next load
    $this->session->set_userdata('PT_academic_year', $p['academic_year'] ?? '');
    $this->session->set_userdata('PT_project_id',    $p['project_id'] ?? '');

    // Normalize payload
    $data = [
        'academic_year'   => trim($p['academic_year'] ?? ''),
        'project_id'      => (int)($p['project_id'] ?? 0),
        'proj_slot_id' => (int)($p['proj_slot_id'] ?? 0),
        'wday'            => trim($p['wday'] ?? ''),
        'building_name'   => trim($p['building_name'] ?? ''),
        'floor_no'        => trim($p['floor_no'] ?? ''),
        'room_no'         => trim($p['room_no'] ?? ''),
    ];

    // quick validation (server-side)
    if (!$data['academic_year'] || !$data['project_id'] || !$data['proj_slot_id'] || !$data['wday']) {
        $this->session->set_flashdata('dup_msg', 'Please fill all required fields.');
        return redirect('Project/timetable');
    }

    // Insert vs Update
    if ($id > 0) {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $data['updated_by'] = $this->session->userdata('uid');

        $ok = $this->db->where('id', $id)->update('project_timetable', $data);
        if ($ok) {
            $this->session->set_flashdata('Tmessage', 'Project timetable updated.');
        } else {
            // bubble up DB error (e.g., unique constraint)
            $err = $this->db->error();
            $msg = !empty($err['message']) ? $err['message'] : 'Update failed (duplicate or DB error).';
            $this->session->set_flashdata('dup_msg', $msg);
        }
        return redirect('Project/timetable');
    }

    // Create
    $data['created_at'] = date('Y-m-d H:i:s');
    $data['created_by'] = $this->session->userdata('uid');

    $ok = $this->db->insert('project_timetable', $data);
    if ($ok) {
        $this->session->set_flashdata('Tmessage', 'Project timetable added.');
    } else {
        $err = $this->db->error();
        // Friendly duplicate message for the unique key on (academic_year, project_id, wday, lecture_slot_id)
        $msg = !empty($err['message']) ? $err['message'] : 'Duplicate entry for Project + Day + Slot in the same Academic Year.';
        $this->session->set_flashdata('dup_msg', $msg);
    }
    return redirect('Project/timetable');
}

public function timetable_save()
{
    $p  = $this->input->post();
    $id = (int)($p['id'] ?? 0);

    // --- read inputs ---
    $academic_year = trim($p['academic_year'] ?? '');
    $proj_slot_id  = (int)($p['proj_slot_id'] ?? 0);
    $wday          = trim($p['wday'] ?? '');
   

    // project_id is now MULTI
    $project_ids_input = $p['project_id'] ?? [];
    if (!is_array($project_ids_input)) {
        // support old single-select submissions just in case
        $project_ids_input = [$project_ids_input];
    }

    // --- basic required checks (except project yet; we may expand "all") ---
    if (!$academic_year || !$proj_slot_id || !$wday) {
        $this->session->set_flashdata('dup_msg', 'Please fill all required fields.');
        return redirect('Project/timetable');
    }

    // --- expand "all" if present ---
    $project_ids = [];
    if (in_array('all', $project_ids_input, true)) {
        // Pull all eligible projects for the selected academic year
        $all = $this->db->select('id')->from('project_details')
                        ->where('academic_year', $academic_year)
                        ->get()->result_array();
        foreach ($all as $row) {
            $project_ids[] = (int)$row['id'];
        }
    } else {
        foreach ($project_ids_input as $pid) {
            if ($pid !== '' && $pid !== null) {
                $project_ids[] = (int)$pid;
            }
        }
    }
    // de-dup
    $project_ids = array_values(array_unique(array_filter($project_ids, fn($x)=>$x>0)));

    if (empty($project_ids)) {
        $this->session->set_flashdata('dup_msg', 'Please select at least one Project.');
        return redirect('Project/timetable');
    }

    // Persist filters in session (store array safely)
    $this->session->set_userdata('PT_academic_year', $academic_year);
   // $this->session->set_userdata('PT_project_id',    $project_ids);

    // common columns
    $baseData = [
        'academic_year' => $academic_year,
        'proj_slot_id'  => $proj_slot_id,
        'wday'          => $wday
        
    ];

    // helper: does table have "status"?
    $hasStatus = $this->db->field_exists('status', 'project_timetable');

    // === UPDATE path (id > 0) ===
    if ($id > 0) {
        $this->db->trans_start();

        // 1) Update the current row with the FIRST selected project
        $firstProjectId = $project_ids[0];
        $updateData = $baseData + [
            'project_id' => $firstProjectId,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => $this->session->userdata('uid'),
        ];

        $okUpdate = $this->db->where('id', $id)->update('project_timetable', $updateData);
        if (!$okUpdate) {
            $err = $this->db->error();
            $this->db->trans_complete();
            $this->session->set_flashdata('dup_msg', $err['message'] ?? 'Update failed (DB error).');
            return redirect('Project/timetable');
        }

        // 2) For any REMAINING selected projects, insert if not duplicate
        $remaining = array_slice($project_ids, 1);
        $added = 0; $skipped = 0;

        if (!empty($remaining)) {
            // Find conflicts: same (year, day, slot, project)
            $this->db->from('project_timetable')
                     ->where('academic_year', $academic_year)
                     ->where('proj_slot_id',  $proj_slot_id)
                     ->where('wday',          $wday)
                     ->where_in('project_id', $remaining);
            if ($hasStatus) $this->db->where('status', 'Y');
            $conflicts = $this->db->get()->result_array();
            $conflictIds = array_map(fn($r)=>(int)$r['project_id'], $conflicts);

            $toInsert = array_values(array_diff($remaining, $conflictIds));
            if (!empty($toInsert)) {
                $now = date('Y-m-d H:i:s');
                $uid = $this->session->userdata('uid');
                $rows = [];
                foreach ($toInsert as $pid) {
                    $rows[] = $baseData + [
                        'project_id' => $pid,
                        'created_at' => $now,
                        'created_by' => $uid,
                    ];
                }
                $this->db->insert_batch('project_timetable', $rows);
                $added = $this->db->affected_rows();
            }
            $skipped = count($remaining) - $added;
        }

        $this->db->trans_complete();

        $msg = 'Project timetable updated.';
        if ($added || $skipped) {
            $msg .= " Also added {$added} additional project(s)";
            if ($skipped) $msg .= ", skipped {$skipped} duplicate(s)";
            $msg .= '.';
        }
        $this->session->set_flashdata('Tmessage', $msg);
        return redirect('Project/ptlist');
    }

    // === CREATE path (id == 0) ===
    // Skip duplicates and insert only new rows
    $this->db->trans_start();

    // Find conflicts
    $this->db->from('project_timetable')
             ->where('academic_year', $academic_year)
             ->where('proj_slot_id',  $proj_slot_id)
             ->where('wday',          $wday)
             ->where_in('project_id', $project_ids);
    if ($hasStatus) $this->db->where('status', 'Y');
    $exist = $this->db->get()->result_array();
    $existingIds = array_map(fn($r)=>(int)$r['project_id'], $exist);

    $toInsertIds = array_values(array_diff($project_ids, $existingIds));

    $added = 0; $skipped = count($project_ids) - count($toInsertIds);
    if (!empty($toInsertIds)) {
        $now = date('Y-m-d H:i:s');
        $uid = $this->session->userdata('uid');
        $batch = [];
        foreach ($toInsertIds as $pid) {
            $batch[] = $baseData + [
                'project_id' => $pid,
                'created_at' => $now,
                'created_by' => $uid,
            ];
        }
        $this->db->insert_batch('project_timetable', $batch);
        $added = $this->db->affected_rows();
    }

    $this->db->trans_complete();

    if ($added > 0) {
        $msg = "Project timetable added for {$added} project(s)";
        if ($skipped > 0) $msg .= ", skipped {$skipped} duplicate(s).";
        else $msg .= '.';
        $this->session->set_flashdata('Tmessage', $msg);
    } else {
        // nothing inserted; everything was duplicate
        $this->session->set_flashdata('dup_msg', 'Duplicate: same Project + Day + Slot already exists for the selected Academic Year.');
    }

    return redirect('Project/ptlist');
}


public function edit_timetable($id)
{
    

    $row = $this->Project_model->get_row((int)$id);
    if (!$row) {
        $this->session->set_flashdata('dup_msg', 'Record not found.');
        return redirect('Project/timetable'); // or wherever your list lives
    }

    $data = [];
    $data['row']            = $row;
    $data['academic_years'] = $this->Project_model->get_acadamic_years();
    $data['slots']          = $this->Project_model->getSlots();
    $data['projects']       = $this->Project_model->get_projects_for_dropdown($row['academic_year']);
	$sccode='';
	if($role==10){
    $emp_id = $this->session->userdata("name");
	$ex =explode("_",$emp_id);
	$sccode = $ex[1];
	}
	elseif($role==20){
		$emp_id=$this->session->userdata("aname");
		$get_details_of_school=$this->Subject_model->loadempschool($emp_id);
		if(!empty($get_details_of_school)){
			$sccode =$get_details_of_school[0]['school_code'];
		}
	
	}
  
   
        $this->data['departments'] = $this->Project_model->get_departments($sccode);	

    $this->load->view('header', $data);
    // Reuse your existing view file:
    $this->load->view($this->view_dir.'project_timetable_form', $this->data);
    $this->load->view('footer');
}



public function ptlist()
{
    // permissions like your other actions
    if (!in_array($this->session->userdata("role_id"), [20,10,44,6,68,21,53])) {
        return redirect('home');
    }

    

    // Header
    
    $this->load->view('header', $this->data);

    // Dropdown data
    $this->data['academic_years'] = $this->Project_model->get_acadamic_years();

    // If POST, take filters from form; else use session; else defaults
    if (!empty($_POST['academic_year'])) {
        $sel_year    = $_POST['academic_year'];
        $sel_project = $_POST['project_id'] ?? '';

        // persist in session
        $this->session->set_userdata('PTL_academic_year', $sel_year);
        $this->session->set_userdata('PTL_project_id',    $sel_project);
    } else {
        $sel_year    = $this->session->userdata('PTL_academic_year') ?: '';
        $sel_project = $this->session->userdata('PTL_project_id') ?: '';
    }

    $this->data['sel_year']    = $sel_year;
    $this->data['sel_project'] = $sel_project;

    // Populate Projects dropdown for the selected year
   $this->data['projects']    = $sel_year ? $this->Project_model->get_projects_for_dropdown($sel_year) : $this->Project_model->get_projects_for_dropdown(ACADEMIC_YEAR);

    // Fetch listing
    $filters = [];
    if ($sel_year)    $filters['academic_year'] = $sel_year;
    if ($sel_project) $filters['project_id']    = $sel_project;

    $this->data['rows'] = $this->Project_model->list_timetable($filters);

    // View + footer
    $this->load->view($this->view_dir.'project_tt_view', $this->data);
    $this->load->view('footer');
}


public function load_projects()
{
    $year = $this->input->post('academic_year');
 

    $rows = $this->Project_model->get_projects_for_dropdown($year);

    $html = '<option value="">Select Project</option>';
    foreach ($rows as $r) {
        $html .= '<option value="'.$r['id'].'">'.
                 htmlspecialchars($r['project_title'].' - '.$r['domain']).
                 '</option>';
    }
    echo $html;
}


public function delete_timetable($id)
{
    if (!in_array($this->session->userdata("role_id"), [20,10,44,6,68])) {
        return redirect('home');
    }

    $id = (int)$id;
    if ($id <= 0) {
        $this->session->set_flashdata('dup_msg', 'Invalid request.');
        return redirect('Project/ptlist');
    }

    $data = [
        'status'     => 'N',
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => $this->session->userdata('uid'),
    ];

    $ok = $this->db->where('id', $id)->update('project_timetable', $data);
    if ($ok) {
        $this->session->set_flashdata('Tmessage', 'Record disabled.');
    } else {
        $err = $this->db->error();
        $msg = !empty($err['message']) ? $err['message'] : 'Disable failed.';
        $this->session->set_flashdata('dup_msg', $msg);
    }

    return redirect('Project/ptlist');
}


public function restore_timetable($id)
{
    if (!in_array($this->session->userdata("role_id"), [20,10,44,6,68])) return redirect('home');

    $id = (int)$id;
    if ($id <= 0) { $this->session->set_flashdata('dup_msg','Invalid request.'); return redirect('Project/ptlist'); }

    $ok = $this->db->where('id',$id)->update('project_timetable', [
        'status'     => 'Y',
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => $this->session->userdata('uid')
    ]);

    $this->session->set_flashdata($ok ? 'Tmessage' : 'dup_msg', $ok ? 'Record restored.' : 'Restore failed.');
    return redirect('Project/ptlist');
}



public function faculty_dashboard()
{
	
	
    // permissions like your others
    if (!in_array($this->session->userdata("role_id"), [20,10,44,6,68])) {
        return redirect('home');
    }

    // DO NOT reset $this->data (so left menu stays)
    $this->load->model('Project_model');

    // dropdown data
    $this->data['academic_years'] = $this->Project_model->get_acadamic_years();

    // restore last filters
    $sel_year    = $this->input->post('academic_year') ?: ($this->session->userdata('FD_academic_year') ?: ACADEMIC_YEAR);
    $sel_faculty = $this->input->post('faculty_id')    ?: ($this->session->userdata('FD_faculty_id')   ?: '');

    // persist selections
    $this->session->set_userdata('FD_academic_year', $sel_year);
    $this->session->set_userdata('FD_faculty_id',    $sel_faculty);

    // load faculty list for selected year
    $this->data['faculties'] = $sel_year
        ? $this->Project_model->get_faculties_by_year($sel_year)
        : [];

    $this->data['sel_year']    = $sel_year;
    $this->data['sel_faculty'] = $sel_faculty;

    // fetch day-wise report
    $this->data['rows'] = [];
    if ($sel_year && $sel_faculty) {
		
        $this->data['rows'] = $this->Project_model->get_faculty_daywise_report($sel_year, $sel_faculty);
    }

    $this->load->view('header', $this->data);
    $this->load->view($this->view_dir.'faculty_dashboard', $this->data);
    $this->load->view('footer');
	
	
	
	
	
}


public function load_faculties_by_year()
{
    $year = $this->input->post('academic_year');
    

    $rows = $year ? $this->Project_model->get_faculties_by_year($year) : [];
    $html = '<option value="">Select Faculty</option>';
    foreach ($rows as $r) {
        $label = htmlspecialchars($r['emp_id'].' - '.$r['fac_name']);
        $html .= '<option value="'.$r['emp_id'].'">'.$label.'</option>';
    }
    echo $html;
}

public function update($id)
{
    $id = (int) $id;

    // Ensure record exists
    $project = $this->db->get_where('project_details', ['id' => $id])->row_array();
    if (!$project) {
        $this->session->set_flashdata('message_project_error', 'Project not found.');
        redirect('Project');
        return;
    }

    // Load libs
    $this->load->helper(['security','form']);
    $this->load->library('form_validation');

    // Validation
    $this->form_validation->set_error_delimiters('', '');
    $this->form_validation->set_message('regex_match', '{field} may include letters, numbers, spaces, commas, &, :, and - only.');

    $this->form_validation->set_rules('academic_year',       'Academic Year',        'required|trim');
    $this->form_validation->set_rules('project_title',       'Project Title',        'required|trim|regex_match[/^[a-zA-Z0-9\s,&:-]+$/]');
    $this->form_validation->set_rules('faculty_code',        'Faculty Code',         'required|trim');
    $this->form_validation->set_rules('domain',              'Domain',               'required|trim|regex_match[/^[a-zA-Z0-9\s,&:-]+$/]');
    $this->form_validation->set_rules('industry_sponsored',  'Industry Sponsored',   'required|trim|regex_match[/^[a-zA-Z0-9\s,&:-]+$/]');
    $this->form_validation->set_rules('programminglanguage', 'Programming Language', 'trim|required|max_length[50]|regex_match[/^[A-Za-z0-9\s,&:+\-]+$/u]');
    $this->form_validation->set_rules('Bl_level',            'Bloom level',          'trim');
	$this->form_validation->set_rules('stream_id', 'Department', 'required');

    if ($this->form_validation->run() === FALSE) {
        $errs = array_values(array_filter($this->form_validation->error_array()));
        $msg  = !empty($errs) ? "Please fix:\n• " . implode("\n• ", $errs) : "Please check the form and try again.";
        $this->session->set_flashdata('message_project_error', $msg);
        redirect('Project/edit/'.$id);
        return;
    }

    // Clean inputs
    $academic_year        = $this->security->xss_clean($this->input->post('academic_year', TRUE));
    $project_title        = $this->security->xss_clean($this->input->post('project_title', TRUE));
	$stream_id        = $this->security->xss_clean($this->input->post('stream_id', TRUE));
    $faculty_code_raw     = $this->security->xss_clean($this->input->post('faculty_code', TRUE));
    $day                  = (int) $this->security->xss_clean($this->input->post('project_day', TRUE));
    $domain               = $this->security->xss_clean($this->input->post('domain', TRUE));
    $industry_sponsored   = $this->security->xss_clean($this->input->post('industry_sponsored', TRUE));
    $programminglanguage  = $this->security->xss_clean($this->input->post('programminglanguage', TRUE));
    $Bl_level             = $this->security->xss_clean($this->input->post('Bl_level', TRUE));

    // Parse faculty code: accept "12345, Name..." or just "12345"
    $faculty_code_first = $faculty_code_raw;
    if (strpos($faculty_code_raw, ',') !== false) {
        $faculty_code_first = trim(explode(',', $faculty_code_raw)[0]);
    }
    if (!preg_match('/^[0-9]+$/', $faculty_code_first)) {
        $this->session->set_flashdata('message_project_error', 'Invalid faculty code format. Please pick from suggestions.');
        redirect('Project/edit/'.$id);
        return;
    }

    // Verify faculty exists
    $fac = $this->db->get_where('sandipun_ums.vw_faculty', ['emp_id' => $faculty_code_first])->row_array();
    if (empty($fac)) {
        $this->session->set_flashdata('message_project_error', 'Faculty not found. Please select a valid faculty.');
        redirect('Project/edit/'.$id);
        return;
    }

    // School code based on role (same as add)
    $sccode = null;
    $role   = $this->session->userdata('role_id');
    if ($role == 10) {
        // e.g., session name "EMP_SC01"
        $emp_id_str = (string) $this->session->userdata('name');
        $ex = explode('_', $emp_id_str);
        $sccode = isset($ex[1]) ? $ex[1] : null;
    } elseif ($role == 20) {
        $emp_id = $this->session->userdata('aname');
        $schoolRows = $this->Subject_model->loadempschool($emp_id);
        if (!empty($schoolRows)) {
            $sccode = $schoolRows[0]['school_code'] ?? null;
        }
    }

    // Duplicate check: same (title, academic_year) but exclude current id
    $dup = $this->db->where('project_title', $project_title)
                    ->where('academic_year', $academic_year)
                    ->where('id !=', $id)
                    ->get('project_details')->num_rows() > 0;
    if ($dup) {
        $this->session->set_flashdata('message_project_error', 'Another project with the same title already exists for this academic year.');
        redirect('Project/edit/'.$id);
        return;
    }

    // Update
    $this->db->trans_start();
    $this->db->where('id', $id)->update('project_details', [
        'project_title'       => $project_title,
        'faculty_id'          => $faculty_code_first,
        'project_day'         => $day,
        'stream_id'          =>  $stream_id,
        'domain'              => $domain,
        'industry_sponsored'  => $industry_sponsored,
        'Bl_level'            => $Bl_level,
        'programminglanguage' => $programminglanguage,
        'faculty_details'          => $faculty_code_raw,
        'updated_by'          => $this->session->userdata('uid'),
        'updated_at'          => date('Y-m-d H:i:s'),
    ]);
	
	
    $this->db->trans_complete();

    if ($this->db->trans_status() === FALSE) {
		
		 
        $this->session->set_flashdata('message_project_error', 'Something went wrong. Project not updated.');
        redirect('Project/edit/'.$id);
        return;
    }

    $this->session->set_flashdata('message_project_success', 'Project updated successfully.');
    redirect('Project'); // back to listing
}


public function remove_student()
{
    // Allow only POST
    if (strtoupper($this->input->method()) !== 'POST') {
        show_error('Invalid request method', 405);
    }

    $this->load->helper(['security', 'url', 'form']);

    // Clean inputs
    $project_id    = (int) $this->security->xss_clean($this->input->post('project_id', TRUE));
    $student_id    = (int) $this->security->xss_clean($this->input->post('student_id', TRUE));
    $academic_year = $this->security->xss_clean($this->input->post('academic_year', TRUE));

    if (!$project_id || !$student_id || !$academic_year) {
        $this->session->set_flashdata('message_project_error', 'Missing required data.');
        redirect('Project');
        return;
    }

    // Optional: permission gate (mirror your Add Projects restriction)
    $role = $this->session->userdata('role_id');
    if (!in_array((int)$role, [10, 20, 1, 58])) { // adjust as you need
        $this->session->set_flashdata('message_project_error', 'You do not have permission to remove students.');
        redirect('Project');
        return;
    }

    // Verify mapping exists
    $map = $this->db->get_where('project_student_details', [
        'project_details_id' => $project_id,
        'student_id'         => $student_id,
        'academic_year'      => $academic_year,
    ])->row_array();

    if (!$map) {
        $this->session->set_flashdata('message_project_error', 'Mapping not found (already removed?).');
        // Redirect back to the same view page
        redirect('Project/view_project_students/' . base64_encode($project_id) . '/' . base64_encode($academic_year));
        return;
    }

    // Remove mapping
	
	$this->DB1 = $this->load->database('erpdel', TRUE);
    $this->DB1->trans_start();
    $this->DB1
        ->where('project_details_id', $project_id)
        ->where('student_id', $student_id)
        ->where('academic_year', $academic_year)
        ->delete('project_student_details');
    $this->DB1->trans_complete();

    if ($this->DB1->trans_status() === FALSE) {
        $this->session->set_flashdata('message_project_error', 'Could not remove student. Please try again.');
    } else {
        $this->session->set_flashdata('message_project_success', 'Student removed from project.');
    }

    redirect('Project/view_project_students/' . base64_encode($project_id) . '/' . base64_encode($academic_year));
}

public function delete_project()
{
    $project_id     = $this->input->post('id');
    $academic_year  = $this->input->post('academic_year');
    $user_id        = $this->session->userdata('uid');

    if (!$project_id) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid Project ID']);
        return;
    }

    // ✅ Load both databases once
    $this->umsdb  = $this->load->database('umsdb', TRUE);
    $this->erpdel = $this->load->database('erpdel', TRUE);

    // ✅ Start both transactions separately (since CI doesn’t support distributed transactions)
    $this->umsdb->trans_begin();
    $this->erpdel->trans_begin();

    try {
        // ---------------------------------------------------
        // 🔹 1. Update project_details in UMSDB
        // ---------------------------------------------------
        $this->umsdb->where('id', $project_id)->update('project_details', [
            'status'     => 'N',
            'updated_by' => $user_id,
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        // ---------------------------------------------------
        // 🔹 2. Delete related project_student_details in ERPDEL
        // ---------------------------------------------------
        $this->erpdel
            ->where('project_details_id', $project_id)
            ->where('academic_year', $academic_year)
            ->delete('project_student_details');

        // ---------------------------------------------------
        // 🔹 Check for errors individually
        // ---------------------------------------------------
        if ($this->umsdb->trans_status() === FALSE || $this->erpdel->trans_status() === FALSE) {
            throw new Exception('Transaction failed in one of the databases.');
        }

        // ✅ Commit both
        $this->umsdb->trans_commit();
        $this->erpdel->trans_commit();

        echo json_encode(['status' => 'success']);

    } catch (Exception $e) {
        // ❌ Rollback both
        $this->umsdb->trans_rollback();
        $this->erpdel->trans_rollback();

        echo json_encode([
            'status'  => 'error',
            'message' => $e->getMessage()
        ]);
    }
}


  /* project report end */
    
    
}
?>