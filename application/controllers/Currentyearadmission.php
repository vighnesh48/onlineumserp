<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//ini_set('display_errors', 1);
class Currentyearadmission extends CI_Controller 
{

    var $currentModule="";
    var $title="";
    var $table_name="campus_master";
    var $model_name="Currentyearadmissionmodel";
    var $model;
    var $view_dir='Admission/';
    
    public function __construct() 
    {
        global $menudata; 
        parent:: __construct();
        $this->load->library('form_validation');

        if ($this->uri->segment(2) != "" && $this->uri->segment(2) != "submit" && !in_array($this->uri->segment(2), $this->skipActions))
           $title = $this->uri->segment(2); //Second segment of uri for action,In case of edit,view,add etc.
        else
           $title = $this->master_arr['index'];
       
        $this->currentModule = $this->uri->segment(1);
        $this->data['currentModule'] = $this->currentModule;
        $this->data['model_name'] = $this->model_name;

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $model = $this->load->model($this->model_name);
        $this->load->model("Admission_model");
        $this->load->library('Message_api');
        $menu_name = $this->uri->segment(1);        
        $this->data['my_privileges'] = $this->retrieve_privileges($menu_name);
    }

    public function index()
    {
        $this->load->view('header', $this->data);
        $this->load->view($this->view_dir.'currentyearadmissionlist');
        $this->load->view('footer');
    }

    public function CurrentYearAdmissionList()
    {
      $school_id = strip_tags($this->input->post('school_id'));
      $academicYear = strip_tags($this->input->post('academicYear'));
      $list = $this->Currentyearadmissionmodel->get_datatables('', $school_id, $academicYear);
      $role_id = $_SESSION['role_id'];
      //print_r($role_id);die;
      $deptName = $_SESSION['name'];
      //print_r($deptName);die;

      $data = array();
      $no = $_POST['start'];
      foreach ($list as $students) {
        $no++;
        $row = array();
        $row[] = '<input type="checkbox" value="'.$students->stud_id.'" name="lstd[]" class="checkBoxClass">';
        $row[] = $no;
        $row[] = $students->oldprn;
        $row[] = $students->prn;
        $row[] = $students->form_number;
        $row[] = $students->student_photo_path;
        $row[] = $students->first_name;
        $row[] = $students->stream_name;
        $row[] = $students->dob;
        $row[] = $students->mobile;
        $row[] = $students->reported_date;

        if($role_id == 15 || $role_id == 10 || $role_id == 6) {
          $studentSubject = base_url()."Subject_allocation/view_studSubject/".$students->stud_id;
          $row[] = '<a  href="'.$studentSubject.'" title="View" target="_blank"><i class="fa fa-book" aria-hidden="true"></i></a>';
        } else {
          $row[] = '';
        }

        $action = '';
        if($role_id == 1 || $role_id == 2 || $role_id == 6) {
            if($deptName == 'student_dept' || $deptName == 'suerp') {     
              $studentEdit = base_url()."ums_admission/edit_personalDetails/".$students->stud_id;
              $action .= '<a  href="'.$studentEdit.'" title="View" target="_blank"><i class="fa fa-edit"></i>  </a>';
            }
        }

        $studentView = base_url()."ums_admission/view_studentFormDetails/".$students->stud_id;
        $action .= '<a  href="'.$studentView.'" title="View" target="_blank"><i class="fa fa-eye"></i>  </a>';
        $row[] = $action;

        $data[] = $row;
      }

      $output = array(
              "draw" => $_POST['draw'],
              "recordsTotal" => $this->Currentyearadmissionmodel->count_all('', $schoolId, $academicYear),
              "recordsFiltered" => $this->Currentyearadmissionmodel->count_filtered('', $schoolId, $academicYear),
              "data" => $data,
          );

      echo json_encode($output);
    }
}
?>