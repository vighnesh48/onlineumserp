<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\IOFactory;

class Canteen extends CI_Controller 
{
    var $currentModule="";
    var $title="";
    var $table_name="canteen_master";
    var $model_name="Canteen_model";
    var $model;
    var $view_dir='Canteen/';
    var $data=array();
    public function __construct() 
    {
        global $menudata;

        parent:: __construct();
        
        $this->load->model('Canteen_model');
        //error_reporting(E_ALL);
        //ini_set('display_errors', 1);
        $this->load->helper("url");		
        $this->load->library('form_validation');
        		$this->load->library('excel');

     if($this->uri->segment(2)!="" && $this->uri->segment(2)!="submit" && !in_array($this->uri->segment(2), $this->skipActions))
           $title=$this->uri->segment(2);                   //Second segment of uri for action,In case of edit,view,add etc.
		else
           $title=$this->master_arr['index'];
       
        $this->currentModule=$this->uri->segment(1);        
        $this->data['currentModule']=$this->currentModule;
        $this->data['model_name']=$this->model_name;
        
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $model = $this->load->model($this->model_name);
         $this->load->model('Ums_admission_model');
        $menu_name=$this->uri->segment(1);        
        $this->data['my_privileges']=$this->retrieve_privileges($menu_name);
    }
    
    public function index()
    {
        $this->load->view('header',$this->data);        
        $this->data['canteens']= $this->Canteen_model->get_all_canteens_with_student_count();
		// print_r($this->data['canteens']); die;
        $this->load->view($this->view_dir.'view',$this->data);
        $this->load->view('footer');
    }


    public function add_canteen()
    {
        $this->load->view('header',$this->data);
        $this->load->view($this->view_dir.'add_canteen',$this->data);
        $this->load->view('footer');
    }

    public function edit_canteen()
    {
        $this->load->view('header',$this->data);
        $canteen_id=base64_decode($this->uri->segment(3)); 
        $this->data['canteen_details']= $this->Canteen_model->get_canteen($canteen_id);
        // print_r($this->data['canteen_details']); die;
        $this->load->view($this->view_dir.'edit_canteen',$this->data);
        $this->load->view('footer');
    }

    public function save_canteen()
    {
        // print_r($_POST); die;
        $canteen_name = strtoupper($this->input->post('cName', TRUE)); 
        $canteen_phone = $this->input->post('cPhone', TRUE); 
        $canteen_address = $this->input->post('cAddress', TRUE); 
        $canteen_code = $this->input->post('cId', TRUE); 
        $machine_id = $this->input->post('machine_id', TRUE); 
    
        $this->load->helper('security');
    
        // Validation rules
        $this->form_validation->set_rules('cName', 'Canteen Name', 'required|alpha_numeric_spaces');
        $this->form_validation->set_rules('cPhone', 'Canteen Phone', 'required|numeric|exact_length[10]');
        $this->form_validation->set_rules('cAddress', 'Canteen Address', 'required');
        $this->form_validation->set_rules('cId', 'Canteen Code', 'required|regex_match[/^[a-zA-Z0-9_]+$/]');
        $this->form_validation->set_rules('machine_id', 'Machine Id', 'required|alpha_numeric');
    
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('header',$this->data);
            $this->session->set_flashdata('message_canteen_2', 'Canteen Not Added. Please Provide Proper Input');
            $this->load->view($this->view_dir.'add_canteen',$this->data);
            $this->load->view('footer');
        } else {
            $insert_array = array(
                'cName' => $canteen_name,
                'cPhone' => $canteen_phone,
                'cAddress' => $canteen_address,
                'cId' => $canteen_code,
                'machine_id' => $machine_id
            );

            // print_r($insert_array);die;

            $this->db->insert('canteens', $insert_array);

            $last_inserted_id = $this->db->insert_id();
            
            if ($last_inserted_id) {
                // Success message and redirect
                $this->session->set_flashdata('message_canteen_1', 'Canteen Added Successfully.');
                redirect(base_url($this->view_dir.'add_canteen'));
            } else {
                // Error message and redirect
                $this->session->set_flashdata('message_canteen_2', 'Canteen Not Added Successfully.');
                redirect(base_url($this->view_dir.'add_canteen'));
            }
        }
    }
    
    public function update_canteen()
    {
        // Retrieving and sanitizing inputs
        $canteen_id = $this->input->post('id', TRUE);
        $canteen_name = strtoupper($this->input->post('cName', TRUE)); 
        $canteen_phone = $this->input->post('cPhone', TRUE); 
        $canteen_address = $this->input->post('cAddress', TRUE); 
        $canteen_code = $this->input->post('cId', TRUE); 
        $machine_id = $this->input->post('machine_id', TRUE);
    
        $this->load->helper('security');
    
        // Validation rules
        $this->form_validation->set_rules('cName', 'Canteen Name', 'required|alpha_numeric_spaces');
        $this->form_validation->set_rules('cPhone', 'Canteen Phone', 'required|numeric|exact_length[10]');
        $this->form_validation->set_rules('cAddress', 'Canteen Address', 'required');
        $this->form_validation->set_rules('cId', 'Canteen Code', 'required|regex_match[/^[a-zA-Z0-9_]+$/]');
        $this->form_validation->set_rules('machine_id', 'Machine Id', 'required|alpha_numeric');
    
        // Run validation
        if ($this->form_validation->run() == FALSE) {
            // Load form again with error messages
            $this->session->set_flashdata('message_canteen_2', 'Canteen Not Updated. Please Provide Proper Input');
            redirect(base_url($this->view_dir.'edit_canteen/'.base64_encode($canteen_id)));
        } else {
            // Prepare data for updating the canteen
            $update_data = array(
                'cName' => $canteen_name,
                'cPhone' => $canteen_phone,
                'cAddress' => $canteen_address,
                'cId' => $canteen_code,
                'machine_id' => $machine_id
            );
    
            // Updating the database
            $this->db->where('id', $canteen_id);
            $this->db->update('canteens', $update_data);
    
            // Check affected rows
            if ($this->db->affected_rows() > 0) {
                // Success message and redirect
                $this->session->set_flashdata('message_canteen_1', 'Canteen Updated Successfully.');
                redirect(base_url($this->view_dir.'edit_canteen/'.base64_encode($canteen_id)));
            } else {
                // No rows affected (either no changes or error)
                $this->session->set_flashdata('message_canteen_2', 'No changes made or update failed.');
                redirect(base_url($this->view_dir.'edit_canteen/'.base64_encode($canteen_id)));
            }
        }
    }
    

    public function view_allocated_students()
    {
        $this->load->view('header',$this->data);
        $canteen_id=base64_decode($this->uri->segment(3));
        $this->data['canteen_id']= $canteen_id;
        $this->data['academic_details']= $this->Canteen_model->get_academic_details();
        $this->data['canteen_details']= $this->Canteen_model->get_all_canteens();
        $this->load->view($this->view_dir.'student_list',$this->data);
        $this->load->view('footer');
    }

    public function export_allocated()
    {
        $this->data['stud_details']['prn'] = $_POST['arg_prn'];
        $this->data['stud_details']['institute'] = $_POST['arg_institute'];
        $this->data['stud_details']['org'] = $_POST['arg_org'];
        $this->data['stud_details']['acyear'] = $_POST['arg_acyear'];
        
        // Fetch the allocated student details
        $this->data['all_student_details'] = $this->Canteen_model->allocated_list_export($this->data['stud_details']);
        
        $canteen_id = $_POST['canteen_id']; // Assuming you are sending canteen_id as well
        $this->data['canteen_allocated_students_with_canteen_name'] = $this->Canteen_model->get_canteen_allocated_students($_POST['arg_canteen_name'],$_POST['arg_prn'],$_POST['arg_meal_type']);
        $this->data['canteen_allocated_students'] = array_column($this->data['canteen_allocated_students_with_canteen_name'], 'enrollment_no');
  
        // Get the canteen names mapped to their enrollment numbers
        $canteen_allocated_students = array_column($this->data['canteen_allocated_students_with_canteen_name'], 'canteens', 'enrollment_no');

        // Filter canteen-allocated students
        $filtered_students = array_filter($this->data['all_student_details'], function($student) {
            // $student['canteen_name'] = 
            return in_array($student['enrollment_no'], $this->data['canteen_allocated_students']);
        });

        $canteen_mapped_students = array_map(function($student) use ($canteen_allocated_students) {
            if (isset($canteen_allocated_students[$student['enrollment_no']])) {
                $student['canteen_name'] = $canteen_allocated_students[$student['enrollment_no']]; // Add canteen name
            } else {
                $student['canteen_name'] = 'N/A'; // Default if no canteen found
            }
            return $student;
        }, $filtered_students);

        $this->data['canteen_mapped_students'] = $canteen_mapped_students;
    
    
        // If no students are allocated, exit or handle accordingly
        if (empty($filtered_students)) {
            echo "No canteen-allocated students found.";
            exit;
        }
    
        // Check if export to PDF or Excel
        if (isset($_POST['btnPDF']) && $_POST['btnPDF'] == 'btnPDF') {
            // PDF Export Logic
            $this->load->library('m_pdf', $param);
            $this->data['filtered_students'] = $filtered_students; // Send filtered data to the view
            $html = $this->load->view($this->view_dir.'hostel_cancelled_pdf', $this->data, true);
            $pdfFilePath = "canteen_allocated_students_" . date('Ymd') . ".pdf";
            $this->m_pdf->pdf->WriteHTML($html);
            $this->m_pdf->pdf->Output($pdfFilePath, "D");
        } else {
            // Excel Export Logic
            $this->load->view($this->view_dir.'student_list_excelreport',$this->data);

        }
    }
    

    public function canteen_slot_price()
    {
        $this->load->view('header',$this->data);        
        $this->data['canteen_slot_price_details']= $this->Canteen_model->get_all_canteen_slot_price_detail();
		// print_r($this->data['canteen_slot_price_details'][0]['canteen_id']); die;
        $this->load->view($this->view_dir.'view_canteen_slot_price',$this->data);
        $this->load->view('footer');
    }

	public function add_canteen_slot_price()
    {
        $this->load->view('header',$this->data);        
        $this->data['canteen_details']= $this->Canteen_model->get_all_canteens();
		//echo "".print_r($this->data['hostel_details']);exit();
        $this->load->view($this->view_dir.'add_canteen_slot_price',$this->data);
        $this->load->view('footer');
    }

    public function edit_canteen_slot_price()
    {
        $this->load->view('header',$this->data); 
        $canteen_id=base64_decode($this->uri->segment(3));       
        $this->data['breakfast_slot_details']= $this->Canteen_model->get_canteen_breakfast_slot_price_detail($canteen_id);
        $this->data['lunch_slot_details']= $this->Canteen_model->get_canteen_lunch_slot_price_detail($canteen_id);
        $this->data['dinner_slot_details']= $this->Canteen_model->get_canteen_dinner_slot_price_detail($canteen_id);
        $this->data['canteen_id']=  $canteen_id;
        $this->data['canteen_name']= $this->Canteen_model->get_canteen_name($canteen_id);
        $this->data['canteen_encoded_id']= $this->uri->segment(3);
        // print_r($this->data['canteen_name']); die;
		//echo "".print_r($this->data['hostel_details']);exit();
        $this->load->view($this->view_dir.'edit_canteen_slot_price',$this->data);
        $this->load->view('footer');
    }

    public function save_canteen_slot_price()
    {
        $canteen_id = $this->input->post("canteen_name");
        $canteen_mtype = $this->input->post("canteen_mtype");
        $from_time = $this->input->post("canteen_from_time");
        $to_time = $this->input->post("canteen_to_time");
        $price = $this->input->post("canteen_price");
        
        // Load security helper
        $this->load->helper('security');

        // print_r($this->input->post());die;
        
        // Form validation rules
        $this->form_validation->set_rules('canteen_name', 'Canteen Name', 'required');
        $this->form_validation->set_rules('canteen_mtype', 'Meal Type', 'required');
        $this->form_validation->set_rules('canteen_from_time', 'From Time', 'required|callback_validate_time');
        $this->form_validation->set_rules('canteen_to_time', 'To Time', 'required|callback_validate_time');
        $this->form_validation->set_rules('canteen_price', 'Price', 'required|numeric|greater_than_equal_to[0]');
        
        if ($this->form_validation->run() == FALSE) {
            // Load view with validation errors
            $this->load->view('header', $this->data);
            $this->session->set_flashdata('message_canteen_2', 'Canteen Slot Not Added. Please Provide Proper Input');
            $this->load->view($this->view_dir.'add_canteen_slot_price', $this->data);
            $this->load->view('footer');
        } else {
            // Check if slot already exists
            $this->db->where('canteen_id', $canteen_id);
            $this->db->where('canteen_mtype', $canteen_mtype);
            $existing_slot = $this->db->get('canteen_slots_price')->row();
            if ($existing_slot) {
                // A slot already exists, return an error message
                $this->session->set_flashdata('message_canteen_2', 'A canteen slot already exists for this meal type.');
                redirect(base_url($this->view_dir.'add_canteen_slot_price'));
            }else{
            // Data to insert into database
            $insert_array = array(
                "canteen_id" => $canteen_id,
                "canteen_mtype" => $canteen_mtype,
                "from_time" => $from_time,
                "to_time" => $to_time,
                "price" => $price
            );
            
            // Insert data into canteen_slots_price table
            $this->db->insert("canteen_slots_price", $insert_array);
            
            // Get last inserted ID
            $last_inserted_id = $this->db->insert_id();
            
            if ($last_inserted_id) {
                // Success message and redirect
                $this->session->set_flashdata('message_canteen_1', 'Canteen Slot Added Successfully.');
                redirect(base_url($this->view_dir.'add_canteen_slot_price'));
            } else {
                // Error message and redirect
                $this->session->set_flashdata('message_canteen_2', 'Canteen Slot Not Added Successfully.');
                redirect(base_url($this->view_dir.'add_canteen_slot_price'));
            }
            }
        }
    }
    
    // Custom callback for time validation
    public function validate_time($time) 
    {
        if (preg_match("/^(2[0-3]|[01][0-9]):([0-5][0-9])$/", $time)) {
            return true;
        } else {
            $this->form_validation->set_message('validate_time', 'The {field} must be in the format HH:MM (24-hour).');
            return false;
        }
    }

    public function update_canteen_slot_price()
     {
        // Print data for debugging (remove in production)
        // print_r($this->input->post()); die;
    
        // Get Canteen ID
        
        $encoded_canteen_id=$this->input->post('canteen_id');
        $canteen_id = base64_decode($encoded_canteen_id);
        // echo $canteen_id; die;
    
        // Load security helper
        $this->load->helper('security');
    
        // Form validation for breakfast slot
        if ($this->input->post("breakfast_from_time") && $this->input->post("breakfast_to_time") && $this->input->post("breakfast_price")) {
            $this->form_validation->set_rules('breakfast_from_time', 'From Time', 'required|callback_validate_time');
            $this->form_validation->set_rules('breakfast_to_time', 'To Time', 'required|callback_validate_time');
            $this->form_validation->set_rules('breakfast_price', 'Price', 'required|numeric|greater_than_equal_to[0]');
        }
    
        // Form validation for lunch slot
        if ($this->input->post("lunch_from_time") && $this->input->post("lunch_to_time") && $this->input->post("lunch_price")) {
            $this->form_validation->set_rules('lunch_from_time', 'From Time', 'required|callback_validate_time');
            $this->form_validation->set_rules('lunch_to_time', 'To Time', 'required|callback_validate_time');
            $this->form_validation->set_rules('lunch_price', 'Price', 'required|numeric|greater_than_equal_to[0]');
        }
    
        // Form validation for dinner slot
        if ($this->input->post("dinner_from_time") && $this->input->post("dinner_to_time") && $this->input->post("dinner_price")) {
            $this->form_validation->set_rules('dinner_from_time', 'From Time', 'required|callback_validate_time');
            $this->form_validation->set_rules('dinner_to_time', 'To Time', 'required|callback_validate_time');
            $this->form_validation->set_rules('dinner_price', 'Price', 'required|numeric|greater_than_equal_to[0]');
        }
    
        // If form validation fails
        if ($this->form_validation->run() == FALSE) {
            // Reload the view with validation errors
            $this->load->view('header', $this->data);
            $this->session->set_flashdata('message_canteen_2', 'Canteen Slot Not Added Successfully.');
            redirect(base_url($this->view_dir.'edit_canteen_slot_price/'.$encoded_canteen_id));
            $this->load->view('footer');
        } else {
            // Only update the breakfast slot if the values are set in the form
            if ($this->input->post("breakfast_from_time") && $this->input->post("breakfast_to_time") && $this->input->post("breakfast_price")) {
                $breakfast_from_time = $this->input->post("breakfast_from_time");
                $breakfast_to_time = $this->input->post("breakfast_to_time");
                $breakfast_price = $this->input->post("breakfast_price");
                $this->Canteen_model->update_breakfast_slot_detail($canteen_id, $breakfast_from_time, $breakfast_to_time, $breakfast_price);
            }
    
            // Only update the lunch slot if the values are set in the form
            if ($this->input->post("lunch_from_time") && $this->input->post("lunch_to_time") && $this->input->post("lunch_price")) {
                $lunch_from_time = $this->input->post("lunch_from_time");
                $lunch_to_time = $this->input->post("lunch_to_time");
                $lunch_price = $this->input->post("lunch_price");
                $this->Canteen_model->update_lunch_slot_detail($canteen_id, $lunch_from_time, $lunch_to_time, $lunch_price);
            }
    
            // Only update the dinner slot if the values are set in the form
            if ($this->input->post("dinner_from_time") && $this->input->post("dinner_to_time") && $this->input->post("dinner_price")) {
                $dinner_from_time = $this->input->post("dinner_from_time");                                            
                $dinner_to_time = $this->input->post("dinner_to_time");
                $dinner_price = $this->input->post("dinner_price");
                $this->Canteen_model->update_dinner_slot_detail($canteen_id, $dinner_from_time, $dinner_to_time, $dinner_price);
            }
    
            // Set a success message and redirect (if needed)
            $this->session->set_flashdata('message_canteen_1', 'Canteen Slot Updated Successfully.');
            redirect(base_url($this->view_dir.'edit_canteen_slot_price/'.$encoded_canteen_id));
        }
    }

    public function delete_canteen_slot_price(){
        // print_r($_POST); die;
        $this->load->helper('security');
        $this->form_validation->set_rules('meal_type', 'Meal Type', 'required');
        
        $meal_type = $_POST['meal_type'];
        $canteen_id = $_POST['canteen_id'];
        if($this->Canteen_model->delete_canteen_slot_price($meal_type, $canteen_id)){
            $this->session->set_flashdata('message1', 'Canteen Slot Price Deleted Successfully.');
            redirect(base_url($this->view_dir.'canteen_slot_price'));
        }else{
            $this->session->set_flashdata('message2', 'Canteen Slot Price Not Deleted. Please Try Again.');
            redirect(base_url($this->view_dir.'canteen_slot_price'));
        }
        
    }

    public function load_canteen_students()
    {
        // print_r($_POST); die; // base64_decode($this->input->post('canteen_name')); die;
        // $this->data['stud_details']['enrollment_no']= str_replace("_","/",$_POST['prn']); 
        $this->data['stud_details']['canteen_name']= $_POST['canteen_name'];
		$this->data['stud_details']['academic_year']= $_POST['acyear']; 
        $this->data['student_list_ums'] = $this->Canteen_model->get_students_by_canteen_ums($_POST['acyear'], $_POST['canteen_name']);
        $this->data['student_list_ums_sijoul'] = $this->Canteen_model->get_students_by_canteen_ums_sijoul($_POST['acyear'], $_POST['canteen_name']);
   

        // Merge both student lists into one array
        $this->data['student_list'] = array_merge_recursive($this->data['student_list_ums'], $this->data['student_list_ums_sijoul']);

        redirect(base_url($this->view_dir.'view_allocated_students/'.base64_encode($_POST['canteen_name']), $this->data));

    
        // print_r($this->data['student_list']);
        // die;
        
    }

	
    public function student_list($enrollment_no='', $ac_year='', $org='')
    {
        //global $model;
        $this->load->view('header',$this->data);    
        //$this->data['student_list']= $this->hostel_model->get_hstudent_list();
		$this->data['academic_details']= $this->Canteen_model->get_academic_details();
		$this->data['canteen_details']= $this->Canteen_model->get_all_canteens();
		
		// // print_r($this->data['academic_details']);die;
        $this->load->view($this->view_dir.'student_list',$this->data);	
        $this->load->view('footer');
    }

    public function search_students_data()
	{	
		// echo '<pre>';print_r($_POST);

		// exit;
		$this->data['student_list'] = $this->Canteen_model->search_canteen_students_data($_POST); 
		
        // print_r($this->data['student_list']); die;
		$this->data['canteen_allocated_students_with_canteen_name'] = $this->Canteen_model->get_canteen_allocated_students($_POST['canteen_name'], null, $_POST['meal_type']);
		$this->data['canteen_allocated_students'] = array_column($this->data['canteen_allocated_students_with_canteen_name'], 'enrollment_no');
		$this->data['canteen_list'] = $this->Canteen_model->get_all_canteens();
		// print_r($this->data['canteen_allocated_students_with_canteen_name']); die;
		/*if($_POST['org']=="SF-SIJOUL"){
		///exit();    	
		}*/
	   $this->load->view($this->view_dir.'canteen_applied_list',$this->data);	
	}
	public function student_canteen()
	{
	    
	 //   error_reporting(E_ALL);

		$sf_std_id=$this->uri->segment(3);
		$this->data['stud_details']['enrollment_no']= str_replace("_","/",$this->uri->segment(3));//$this->uri->segment(3);
		$this->data['stud_details']['student_id']=$this->uri->segment(4);
		$this->data['stud_details']['org']=$this->uri->segment(5);
		$this->data['stud_details']['academic_year']=$this->uri->segment(6);
		
		$this->load->view('header',$this->data); 
		$this->data['academic_details']= $this->Canteen_model->get_academic_details();
		$this->data['canteen_id']= $this->Canteen_model->get_canteen_detail($this->data['stud_details']['enrollment_no'],$this->data['stud_details']['academic_year']);
		$this->data['canteen_details']= $this->Canteen_model->get_all_canteens();
		// $this->data['canteen_name']= $this->hostel_model->get_canteen_name($this->data['canteen']);
		// print_r($this->data); die;		
   

		$this->data['student_details']= array_shift($this->Canteen_model->get_student_details($this->data['stud_details']));
		// print_r($this->data['canteen_id']);die;
		$this->load->view($this->view_dir.'student_canteen_view',$this->data);
        $this->load->view('footer');
	}

    public function canteen_report()
    {
        $this->data['canteen_details']= $this->Canteen_model->get_all_canteens();
        $this->load->view('header',$this->data);
        $this->load->view($this->view_dir.'canteen_report',$this->data);
        $this->load->view('footer');
    }

    public function export_excel()
    {
        // Fetch posted data
        $Canteen_id = $this->input->post('canteen_name');
        $Canteen_id_main = $this->input->post('canteen_name');
        $year_month = $this->input->post('attend_date');
        $rtype = $this->input->post('rtype');
        
        // Split year and month
        $date_parts = explode('-', $year_month);
        $year = $date_parts[0];
        $month = $date_parts[1];
    
        // Handle case when Canteen_id is 0 (all canteens)
        if ($Canteen_id == 0) {
            // Get all canteen names from the database
            $all_canteens = $this->Canteen_model->get_all_canteens();
        } else {
            // Get the single canteen name
            $all_canteens = [$this->Canteen_model->get_canteen($Canteen_id)];
            // print_r($all_canteens);die;
        }
    
        // Initialize PDF if generating PDF report
        if ($rtype == 'pdf') {
            $this->load->library('m_pdf');
            ini_set("memory_limit", "-1");
            $this->m_pdf->pdf = new mPDF('', 'A4', '', '', 5, 5, 5, 5, 5, 5);
        }
    
        // Loop through canteens to generate reports
        foreach ($all_canteens as $canteen) {
            $Canteen_id = $canteen['id'];  // Update Canteen_id for each iteration
            $machine_id = $canteen['machine_id'];
            // print_r($Canteen_id);die;
            $this->data['canteen_name'] = $canteen['cName'];
            $this->data['year'] = $year;
            $this->data['month_no'] = $month;
            $this->data['month'] = $this->Canteen_model->get_month_name($month);
            
            // Fetch the required data for this canteen
            $this->data['student_count'] = $this->Canteen_model->get_canteen_student_count($Canteen_id);
            // print_r($this->data['student_count']);die;
            $this->data['canteen_slot_price_breakfast'] = $this->Canteen_model->get_canteen_breakfast_slot_price_detail($Canteen_id);
            $this->data['canteen_slot_price_lunch'] = $this->Canteen_model->get_canteen_lunch_slot_price_detail($Canteen_id);
            $this->data['canteen_slot_price_dinner'] = $this->Canteen_model->get_canteen_dinner_slot_price_detail($Canteen_id);
    
            // Get the punching details
            $this->data['punching_details'] = $this->Canteen_model->get_punching_data(
                $year, $month, $machine_id,
                $this->data['canteen_slot_price_breakfast'], 
                $this->data['canteen_slot_price_lunch'], 
                $this->data['canteen_slot_price_dinner']
            );

            // print_r($this->data['punching_details']);die;

            $canteen_data[] = [
                'canteen_name' => $canteen['cName'],
                'student_count' => $this->data['student_count'],
                'breakfast_price' => $this->data['canteen_slot_price_breakfast']['price'],
                'lunch_price' => $this->data['canteen_slot_price_lunch']['price'],
                'dinner_price' => $this->data['canteen_slot_price_dinner']['price'],
                'punching_details' => $this->data['punching_details']
            ];
    
            // Generate the report for this canteen
            if ($rtype == 'pdf') {
                // Generate HTML content
                $html1 = $this->load->view($this->view_dir.'canteen_report_pdf', $this->data, true);
    
                // Append canteen name to file name
                $pdfFilePath = 'canteen_payment_report_' . $this->data['canteen_name'] . ".pdf";
                
                // Write HTML to PDF
                $this->m_pdf->pdf->AddPage();
                $this->m_pdf->pdf->WriteHTML($html1);
            }
        }
    
        // Output combined or individual PDF(s)
        if ($rtype == 'pdf') {
            if ($Canteen_id_main == 0) {
                $this->m_pdf->pdf->Output("canteen_report_all.pdf", "D");  // Download as one combined PDF
            } else {
                 $this->m_pdf->pdf->Output("canteen_report_" . $this->data['canteen_name'] . ".pdf", "D");  
            }
        }else{
            $this->data['canteen_data'] = $canteen_data;
            // print_r($this->data['canteen_data']);die;
            $this->load->view($this->view_dir.'canteen_report_excel',$this->data);
        }
    }

    public function import(){

        $this->load->view('header',$this->data);        
        
        $this->load->view($this->view_dir.'canteen_import_students',$this->data);
        $this->load->view('footer');
    }

    public function import_students11(){
        $file_mimes = array(
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'text/xls',
            'text/xlsx'
        );

         // Check if the file is uploaded and has a valid MIME type
         if (isset($_FILES['excel_file']['name']) && in_array($_FILES['excel_file']['type'], $file_mimes)) {
            
            $file = $_FILES['excel_file']['tmp_name'];

            // Load the spreadsheet
            try {
                $spreadsheet = IOFactory::load($file);
                $sheetData = $spreadsheet->getActiveSheet()->toArray();

                  // Skip the first row (the header)
                  $header = true;
                  foreach ($sheetData as $row) {
                      if ($header) {
                          $header = false;
                          continue; // Skip the header row
                      };

                    //   print_r($row); die; 

                    if(isset($row[6]) || isset($row[7]) || isset($row[9])){
                          
                      
                        $row[6] = ($row[6] == 'ORANGE CANTEEN') ? 'ORANGE' : $row[6];
                        $row[7] = ($row[7] == 'ORANGE CANTEEN') ? 'ORANGE' : $row[7];
                        $row[9] = ($row[9] == 'ORANGE CANTEEN') ? 'ORANGE' : $row[9];

                      
                      $enrollment_no = $row[3];
                      $academic_year = substr(ACADEMIC_YEAR, 0, 4);
                      $canteen_id_breakfast = $this->Canteen_model->get_canteen_id(strtoupper($row[6]));
                      $canteen_id_lunch = $this->Canteen_model->get_canteen_id(strtoupper($row[7]));
                      $canteen_id_dinner = $this->Canteen_model->get_canteen_id(strtoupper($row[9]));
                      $sffm_id = 3;

                      $canteens = [
                        1 => ['meal' => 'Breakfast', 'canteen_id' => $canteen_id_breakfast],
                        2 => ['meal' => 'Lunch', 'canteen_id' => $canteen_id_lunch],
                        3 => ['meal' => 'Dinner', 'canteen_id' => $canteen_id_dinner]
                        ];

                      foreach ($canteens as $cs_id => $canteen) {
                        $meal_name = $canteen['meal'];
                        $canteen_id = $canteen['canteen_id'];
            
                        // Skip the slot if canteen ID is 0
                        if ($canteen_id == 0) {
                            continue;
                        }

                      

                          $insert_array = array(
					    	"enrollment_no" => $enrollment_no,
					    	"academic_year" => $academic_year,
					    	"allocated_id" => $canteen_id,
					    	"sffm_id" => $sffm_id,
					    	"cs_id" => $cs_id,
					    	"created_by" => $this->session->userdata("uid"),
					    	"created_on" => date("Y-m-d H:i:s"),
					    	"is_active" => "Y"
					      );
                        //   print_r($insert_array); die;

                          $this->db->insert('sf_student_facility_allocation', $insert_array);

                          
                     }
                }
            }

                    

            } catch (Exception $e) {
                die('Error loading file "' . pathinfo($file, PATHINFO_BASENAME) . '": ' . $e->getMessage());
            }

         }
    }
    
    public function check_exists()
	{
		echo $status=$this->Canteen_model->check_exists($_POST);
	}
    
    public function check_hcode_exist()
	{
		echo $status=$this->Canteen_model->check_hcode_exist($_POST);
	}
	
public function import_students(){
		$this->load->library('PHPExcel');
                   // $object = new PHPExcel();
                   

     $file_mimes = array(
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'text/xls',
            'text/xlsx'
        );
    
        // Check if the file is uploaded and has a valid MIME type
        if (isset($_FILES['excel_file']['name']) && in_array($_FILES['excel_file']['type'], $file_mimes)) {
            
            $file = $_FILES['excel_file']['tmp_name'];

    
            // Load the spreadsheet
            try {
                $objPHPExcel = PHPExcel_IOFactory::load($file);

			// Get the active sheet
			$sheetData = $objPHPExcel->getActiveSheet();
                // Prepare an array to hold the batch data
                $batch_data = [];
                
                
                 foreach ($sheetData->getRowIterator() as $row) {
                    
	 		$cia_marks = $sheetData->getCell('A' . $row->getRowIndex())->getValue();
            $breakfast_canteen = $sheetData->getCell('C' . $row->getRowIndex())->getValue();
            $lunch_canteen = $sheetData->getCell('D' . $row->getRowIndex())->getValue();
            $dinner_canteen = $sheetData->getCell('E' . $row->getRowIndex())->getValue();
			$stud = $this->Canteen_model->get_student_id($cia_marks);
			//print_r($stud['student_id']);
                    if (isset($cia_marks)) {
    
                        $enrollment_no = $cia_marks;
                        $academic_year = substr(ACADEMIC_YEAR, 0, 4);
                        $canteen_id_breakfast = $this->Canteen_model->get_canteen_id(strtoupper($breakfast_canteen));
                        $canteen_id_lunch = $this->Canteen_model->get_canteen_id(strtoupper($lunch_canteen));
                        $canteen_id_dinner = $this->Canteen_model->get_canteen_id(strtoupper($dinner_canteen));
                        $sffm_id = 3;
    
                        $canteens = [
                            1 => ['meal' => 'Breakfast', 'canteen_id' => $canteen_id_breakfast],
                            2 => ['meal' => 'Lunch', 'canteen_id' => $canteen_id_lunch],
                            3 => ['meal' => 'Dinner', 'canteen_id' => $canteen_id_dinner]
                        ];
    
                        foreach ($canteens as $cs_id => $canteen) {
                            $meal_name = $canteen['meal'];
                            $canteen_id = $canteen['canteen_id'];
    
                            // Skip the slot if canteen ID is 0
                            if ($canteen_id == 0) {
                                continue;
                            }
    
                            // Check if entry already exists for this enrollment_no, sffm_id, and cs_id (meal)
                            $existing_entry = $this->db->get_where('sf_student_facility_allocation', [
                                'enrollment_no' => $enrollment_no,
                                'student_id' => $stud['student_id'],
                                'sffm_id' => $sffm_id,
                                'cs_id' => $cs_id,
                                'allocated_id' => $canteen_id,
                                'academic_year' => $academic_year
                            ])->row_array();
    
                            if ($existing_entry) {
                                // Entry exists, skip this student
                                continue;
                            }
    
                            // Prepare data for batch insert
                            $batch_data[] = array(
                                "enrollment_no" => $enrollment_no,
								'student_id' => $stud['student_id'],
                                "academic_year" => $academic_year,
                                "allocated_id" => $canteen_id,
                                "sffm_id" => $sffm_id,
                                "cs_id" => $cs_id,
                                "created_by" => $this->session->userdata("uid"),
                                "created_on" => date("Y-m-d H:i:s"),
                                "is_active" => "Y"
                            );
                        }
                    }
                }

    //echo '<pre>';print_r($batch_data);exit;
                // Insert batch data into the database
                if (!empty($batch_data)) {
                    $this->db->insert_batch('sf_student_facility_allocation', $batch_data);
                    $this->session->set_flashdata('message1', 'Canteen Allocated Successfully.');
                    redirect(base_url($this->view_dir.'/'));

                }
    
            } catch (Exception $e) {
                die('Error loading file "' . pathinfo($file, PATHINFO_BASENAME) . '": ' . $e->getMessage());
            }
        }
    }

	//////////////////////////////
}
	
?>
