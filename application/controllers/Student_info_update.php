<?php
ini_set("display_errors", "On");
error_reporting(1);
defined('BASEPATH') OR exit('No direct script access allowed');
define("MODEL_NM","course_model");
class Student_info_update extends CI_Controller 
{
    var $currentModule="Student_info_update";
    var $title="";
    var $table_name="";
    var $model_name="Student_info_update_model";
    var $model;
    var $view_dir='Student_info_update/';
    var $data=array();
    public function __construct() 
    {
        global $menudata;
        parent:: __construct();
        
        $this->load->helper("url");		
        $this->load->library('form_validation');
        $this->load->library('session');
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
     
    public function index()
    {
        $id= $this->Student_info_update_model->get_student_id_by_prn($this->session->userdata('name'));
        $this->data['stud_id']=$id['stud_id']; 
		$this->data['old_mobile_no']=$id['mobile'];
		$this->data['email']=$id['email']; 
        //$this->data['stud_id']=10; 
        //$this->data['old_mobile_no']='8419941176';
        $this->load->view('header',$this->data);   
        $this->load->view('Student_info_update/student_update_mobile',$this->data);
        $this->load->view('footer');
    }
    
   public function verify_student_mobile()
    {   
        $result = $this->Student_info_update_model->verify_student_mobile($_POST); 
        echo $result;
    }
    public function verify_student_mobile_otp()
    {   
        $result = $this->Student_info_update_model->verify_student_mobile_otp($_POST); 
        echo $result;
    }
	
    
    public function verify_student_email_otp()
    {   
      //  echo "1"; exit;
        $result = $this->Student_info_update_model->verify_student_email_otp($_POST); 
        echo $result;
    }

    public function verify_student_email()
    {
       // echo "1"; exit;
        $result = $this->Student_info_update_model->verify_student_email($_POST); 
        echo $result;
    }

    public function upload_excel_student_data()
    {
     
        $this->load->view('header',$this->data);
        $this->load->library('Excel');

        if($_POST){
            //print_r($_POST);
            //print_r($_FILES); 
            $gen_arr=array('F','M');
            $path = $_FILES["file"]["tmp_name"];
            $object = PHPExcel_IOFactory::load($path);
           foreach($object->getWorksheetIterator() as $worksheet)
           {  
                $highestRow = $worksheet->getHighestRow();
                $highestColumn = $worksheet->getHighestColumn();
          
                for($row=2; $row<=$highestRow; $row++){
                    $data=array();

                    $prn=($worksheet->getCellByColumnAndRow(1, $row)->getValue());
                    //$prn ='170103011001';
                    $DB1 = $this->load->database('umsdb', TRUE);
                    $sql1 ="SELECT s.stud_id,vw.school_code,vw.stream_id FROM student_master AS s JOIN `vw_stream_details` 
                    AS vw ON s.admission_stream = vw.stream_id  WHERE s.enrollment_no='".$prn."' ";
                    //echo $sql1;die;
                    $query1=$DB1->query($sql1);
                    $result1=$query1->row_array();
                  // print_R($result1);die;

                    $data['student_id']=$result1['stud_id'];
                    $data['school_id']=$result1['school_code'];
                    $data['stream_id']=$result1['stream_id'];
                    $data['enrollment_no']=$prn;
                    $data['semester']=($worksheet->getCellByColumnAndRow(5, $row)->getValue()); 
                    $data['subject_id']=($worksheet->getCellByColumnAndRow(8, $row)->getValue());
                    //$data['subject_name']=($worksheet->getCellByColumnAndRow(9, $row)->getValue());
                    $data['subject_code']=($worksheet->getCellByColumnAndRow(10, $row)->getValue()); 
                    $data['exam_id']=($worksheet->getCellByColumnAndRow(12, $row)->getValue()); 
                    
                    $DB1 = $this->load->database('umsdb', TRUE);
                    $sql = "select * from exam_result_data where enrollment_no='".$prn."' 
                    and student_id='".$result1['stud_id']."' and stream_id='".$result1['stream_id']."' 
                    and subject_code='".$result1['subject_code']."' ";
                       // echo $sql; die;

                        $query1=$DB1->query($sql);
                        $chk=$query1->row();


                            if(empty($chk))
                            {
                                $DB1 = $this->load->database('umsdb', TRUE);
                                $DB1->insert('exam_result_data',$data);
                                //echo $DB1->last_query();die;
                               // echo $DB1->insert_id();exit;

                            }

                    }
              }
            echo "Successfully uploaded";
            exit;
        }
        $this->load->view($this->view_dir . 'student_data_import_excel', $this->data);
        $this->load->view('footer');     
    }


}
?>