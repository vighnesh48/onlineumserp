<?php
/*ini_set("display_errors", "On");
error_reporting(1);
error_reporting(E_ALL); 
ini_set('display_errors', 1); 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); BONAFIDE CERTIFICATE
*/
class Collaboration_edu extends CI_Controller{

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
		 $this->load->model('Collaboration_edu_model');
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

	
	public function Collaboration_dataview($cyear=''){
		   
		   
		$this->load->view('header',$this->data); 
		$this->data['cyear'] =$this->uri->segment(3);
		 $this->data['role_id'] = $this->session->userdata('role_id'); //exit();
		$this->load->view('Collaboration_edu/Collaboration_dataview',$this->data);
        $this->load->view('footer');
	}
	
	public function ajax_list()
	{ 
	    $role_id = $this->session->userdata('role_id'); //exit();
		$cyear=$_POST['cyear'];
		$form_type=$_POST['form_type'];
		$list = $this->Collaboration_edu_model->get_datatables($cyear,$form_type);
		
		$data = array();
		$no = $_POST['start'];
		
		foreach ($list as $stud) {
			
			$no++;
			$row = array();
			
			$row[] = $no;
			$row[] = $stud->created_at;
			$row[] = $stud->academic_year;
			$row[] = $stud->full_name;
			$row[] = $stud->mobile;
			$row[] = $stud->email;
			$row[] = $stud->designation;
			$row[] = $stud->state_name;
			$row[] = $stud->city_name;
			$row[] = $stud->institution_type_names;
			$row[] = $stud->category_names;
			$row[] = $stud->institution_name;
			$row[] = $stud->institution_add;
			$data[] = $row;
			
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->Collaboration_edu_model->count_all($cyear,$form_type),
						"recordsFiltered" => $this->Collaboration_edu_model->count_filtered($cyear,$form_type),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	

	
	

}
?>