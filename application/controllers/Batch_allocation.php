<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Batch_allocation extends CI_Controller 
{
    var $currentModule="";
    var $title="";
    var $table_name="subject_master";
    var $model_name="Batch_allocation_model";
    var $model;
    var $view_dir='Batch_allocation/';
    var $data=array();
    public function __construct() 
    {
        global $menudata;
        parent:: __construct();
        
        $this->load->helper("url");		
        $this->load->library('form_validation');
        
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
        
        $menu_name=$this->uri->segment(1);        
        $this->data['my_privileges']=$this->retrieve_privileges($menu_name);
    }
    //view
    public function index()
    {
		$this->load->view('header',$this->data); 
		$this->load->model('Subject_model');
		$this->data['course_details']= $this->Subject_model->getCollegeCourse($college_id);	
        $this->load->view($this->view_dir.'allocate_batch',$this->data);
        $this->load->view('footer');

	}
    //search
    public function search_subAndStudent()
    {
		$this->load->model('Subject_model');
		$this->load->model('Attendance_model');
        $this->load->view('header',$this->data);                
        $stream_id = $_POST['stream_id'];
		$semester = $_POST['semester'];
		$subject_id = explode('-', $_POST['subject']);
		
		$this->data['courseId'] = $_POST['course_id'];
		$this->data['streamId'] = $_POST['stream_id'];
		$this->data['semesterNo'] = $_POST['semester'];
		$this->data['subject_req'] = $_POST['subject'];
		
		$this->data['subCode'] = $subject_id[0];
		$this->data['class'] = $subject_id[1];
		$this->data['division'] = $subject_id[2];
		$this->data['batch'] = $subject_id[3];
		//$batch_code = $subject_id[1].'-'.$subject_id[2];
		$batch_code = $subject_id[1].'-'.$subject_id[2].'-'.$subject_id[3];
		$this->data['subdetails']= $this->Attendance_model->getsubdetails($subject_id[0]);
		if(!empty($stream_id) && !empty($semester)){
			$this->data['studlist']= $this->Batch_allocation_model->get_stud_list($stream_id, $semester,$subject_id[0]);
			$this->data['studbatch_allot_list']= $this->Batch_allocation_model->get_studbatch_allot_list($batch_code);			
		}
		
		$this->data['course_details']= $this->Subject_model->getCollegeCourse($college_id);		    

        $this->load->view($this->view_dir.'allocate_batch',$this->data);
        $this->load->view('footer');
    }    
	// load subject
	public function load_subject(){
		$streamId = $_POST['streamId'];
		$course_id = $_POST['course'];
		$semesterId = $_POST['semesterId'];
		$division = $_POST['division'];
		$this->data['emp']= $this->Batch_allocation_model->load_subject($course_id, $streamId, $semesterId, $division);
	}
	// load streams

	function load_streams() {
        if (isset($_POST["course_id"]) && !empty($_POST["course_id"])) {
            //Get all city data
            $stream = $this->Batch_allocation_model->get_course_streams($_POST["course_id"]);
            
            //Count total number of rows
            $rowCount = count($stream);

            //Display cities list
            if ($rowCount > 0) {
                echo '<option value="">Select Stream</option>';
                foreach ($stream as $value) {
                    echo '<option value="' . $value['stream_id'] . '">' . $value['stream_name'] . '</option>';
                }
            } else {
                echo '<option value="">stream not available</option>';
            }
        }
    }
	function load_streams_faculty_allocation() {
        if (isset($_POST["course_id"]) && !empty($_POST["course_id"])) {
            //Get all city data
            $stream = $this->Batch_allocation_model->get_course_streams_faculty_allocation($_POST["course_id"],$_POST["school_code"]);
            
            //Count total number of rows
            $rowCount = count($stream);

            //Display cities list
            if ($rowCount > 0) {
                echo '<option value="">Select Stream</option>';
                foreach ($stream as $value) {
                    echo '<option value="' . $value['stream_id'] . '">' . $value['stream_name'] . '</option>';
                }
            } else {
                echo '<option value="">stream not available</option>';
            }
        }
    }	
    // insert and update
    public function assign_batchToStudent()
    {    
		
		$checked_stud = $_POST['chk_stud'];
		$sem_id = $_POST['sem'];
		$sub_code = $_POST['sub_code'];
		$stream_id = $_POST['stream'];
		$batchcode = $_POST['classa'].'-'.$_POST['division'].'-'.$_POST['batch'];
		foreach ($checked_stud as $stud) {
			
				$data['sub_applied_id'] = $stud;
				$data['batch_code'] = $_POST['classa'].'-'.$_POST['division'].'-'.$_POST['batch'];
				$data['semester'] = $sem_id;
				$data['academic_year'] = ACADEMIC_YEAR;
				$data['entry_on'] = date('Y-m-d H:i:s');
				$data['entry_by'] = $_SESSION['uid'];
				
				$dup_exist1 = $this->Batch_allocation_model->chk_dupbatchToStudent($data);
				$dup_exist =count($dup_exist1);
				//print_r($data);exit;
				if($dup_exist < 1){
					$this->Batch_allocation_model->assign_batchToStudent($data);
				}else{
					//echo "dup";echo "<br>";
				}
		}
		if(!empty($stream_id) && !empty($sem_id)){
			$all_stud= $this->Batch_allocation_model->get_stud_list($stream_id, $sem_id,$sub_code);
			$allocated_list= $this->Batch_allocation_model->get_studbatch_allot_list($batchcode);			
		}
		$allstd = array();
		$allstd['ss'] = $all_stud;
		$allstd['astd'] = $allocated_list;
		
		$str_output = json_encode($allstd);
		echo $str_output;
		//redirect('Batch_allocation/');
    } 
	//remove
	public function removeStudFromBatch($studId)
	{
        $this->load->view('header',$this->data); 
		$checked_stud = $_POST['chk_stud_batch'];
		foreach ($checked_stud as $stud) {
			$this->Batch_allocation_model->removeStudent($stud);
		}
		redirect('batch_allocation/');
	}
	public function load_division(){
		
		$room_no = $_POST['room_no'];
		$semesterId = $_POST['semesterId'];
		$sub_details = $this->Batch_allocation_model->load_division($room_no, $semesterId);
		$rowCount = count($sub_details);

            //Display cities list
            if ($rowCount > 0) {
                echo '<option value="">Select Division</option>';
                foreach ($sub_details as $sub) {
					
					echo '<option value="'.$sub['division'].'">'.$sub['division'].'</option>';
				}
            } else {
                echo '<option value="">Division not available</option>';
            }
	}	
}
?>