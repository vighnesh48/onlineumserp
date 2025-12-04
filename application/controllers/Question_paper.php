<?php

defined('BASEPATH') OR exit('No direct script access allowed');

   // error_reporting(E_ALL);
class Question_paper extends CI_Controller {


    var $currentModule = "";
    var $title = "";
    var $table_name = "campus_master";
    var $model_name = "Admin_model";
    var $model;
    var $view_dir = 'Question_Paper/';

    public function __construct() {
        global $menudata;
        parent:: __construct();

        $this->load->helper("url");
        $this->load->library('form_validation');
		$this->load->library('Awssdk');
        $this->bucket_name = 'erp-asset';

        if (!$this->session->has_userdata('uid'))
            redirect('login');
        if ($this->uri->segment(2) != "" && $this->uri->segment(2) != "submit" && !in_array($this->uri->segment(2), $this->skipActions))
            $title = $this->uri->segment(2);                   //Second segment of uri for action,In case of edit,view,add etc.
        else
            $title = $this->master_arr['index'];


        $this->currentModule = $this->uri->segment(1);
        $this->data['currentModule'] = $this->currentModule;
        $this->data['model_name'] = $this->model_name;

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $model = $this->load->model($this->model_name);

        $menu_name = $this->uri->segment(1);
        $this->data['my_privileges'] = $this->retrieve_privileges($menu_name);
    }

    public function index() {
        global $model;
		$this->load->model('Faculty_model');
		$this->load->model('Timetable_model');
        $this->load->model('Question_paper_model');
        $this->load->view('header', $this->data);
		$this->data['academic_year']= $this->Timetable_model->fetch_Allacademic_session();
        /*echo "<pre>";
print_r($this->session->all_userdata());
echo "</pre>";exit;*/
        $rid=$this->session->userdata('role_id');
        $fname=$this->session->userdata('name');

        if($rid==21){
              $this->data['sub_list']= $this->Question_paper_model->get_faculty_subject_list($fname);
              $this->load->view($this->view_dir . 'sub_list_for_faculty', $this->data);    

            }
       else{

        $this->data['sub_list']= $this->Question_paper_model->get_faculty_subject_list();
        $this->load->view($this->view_dir . 'sub_list_for_faculty', $this->data);
		/**/
    }
        $this->load->view('footer');
    }


    public function add_new_qp(){
            
        global $model;
        $this->load->model('Faculty_model');
        $this->load->model('Timetable_model');
        $this->load->model('Question_paper_model');
        $this->load->model('Exam_timetable_model');
        $this->load->view('header', $this->data);
        $this->data['academic_year']= $this->Timetable_model->fetch_Allacademic_session();
        $this->data['exam_session']= $this->Exam_timetable_model->fetch_exam_session_for_qp();

        if(!empty($_POST)){
            $this->data['courseId'] = $_POST['course_id'];
            $this->data['streamId'] = $_POST['stream_id'];
            $this->data['semesterNo'] = $_POST['semester'];
            $this->data['academicyear'] =$_POST['academic_year'];
            $this->data['exam_type'] =$_POST['exam_type'];   
            $this->data['faculty_list'] =$this->Faculty_model->getFacultyList_from_qp($_POST['stream_id'],$_POST['academic_year']);   
            $this->data['sub_list']= $this->Timetable_model->get_tt_subdetails_qp($_POST['course_id'],$_POST['stream_id'],$_POST['exam_type'],$_POST['semester'],$_POST['academic_year']);                    
            $this->load->view($this->view_dir . 'faculty_list_frm_lt', $this->data);
        }else{
            $this->data['sub_list']= '';                        
            $this->load->view($this->view_dir . 'faculty_list_frm_lt', $this->data);
        }

        $this->load->view('footer');



    }

    public function view() {
        $this->load->view('header', $this->data);
        $this->data['campus_details'] = $this->campus_model->get_campus_details();
        $this->load->view($this->view_dir . 'view', $this->data);
        $this->load->view('footer');
    }

    public function add() {
        $this->load->model('Ums_admission_model');
		$this->load->model('Faculty_model');
        $this->load->view('header', $this->data);
        // $this->data['org_list']= $this->Admin_model->getAllOrganizations();		 
        $this->data['school_list'] = $this->Admin_model->getAllschool();
        $this->data['states'] = $this->Ums_admission_model->fetch_states();
        $this->data['dept_list'] = $this->Admin_model->getAllDepartments();
		$this->data['desig_list']= $this->Admin_model->getAllDesignations();
        //$this->load->model("Admission_model");
		$this->data['emp_new_id'] = $this->Faculty_model->getFacultynewId();
        $this->data['category'] = $this->Faculty_model->getcategorylist();
        if (!empty($_REQUEST['id']) && !empty($_REQUEST['status'])) { //for update
            //echo $_REQUEST['id'];
            $this->data['update_flg'] = $_REQUEST['flag'];
            $this->data['emp'] = $this->Faculty_model->getFacultyById($_REQUEST['id'], $_REQUEST['status']);
			$this->data['addr'] = $this->Faculty_model->getFacultyAddr($_REQUEST['id']);
        }
        /* else{
          echo "direct";
          } */
        $this->load->view($this->view_dir . 'professor_master', $this->data);
        $this->load->view('footer');
    }

    public function getStatewiseCity() {
        $id = $_REQUEST['state_id'];
        if (isset($_REQUEST['state_id'])) {
            $this->data['city_list'] = $this->Admin_model->getStateCity($id);
            /* print_r($this->data['city_list']);
              die(); */
            $this->load->view($this->view_dir . 'state_wise_city', $this->data);
        }
    }

    public function getdepartmentByschool() {
        $id = $_REQUEST['school_id'];

        if (isset($_REQUEST['school_id'])) {
            $this->data['deptBYschool_list'] = $this->Admin_model->getdepartmentByschool($id); //schoolwise department
            //schoolwise =>related department wise employee list
            // $this->data['emp_list']=$this->Admin_model->getSchoolDepartmentWiseEmployeeList($id,$this->data['deptBYschool_list']);
            $this->load->view($this->view_dir . 'school_wise_department', $this->data);
        }
    }

    public function insert_faculty() { 
	
	  $this->load->model('Faculty_model');
        $this->load->view('header', $this->data);
        $picture = array();
        if (!empty($_POST)) {

            //for profile Image
            if (!empty($_FILES['profile_img']['name'])) {
                $filenm = $_POST['FacultyID'] . '-' . 'profile-' . $_FILES['profile_img']['name'];
                $config['upload_path'] = 'uploads/employee_profilephotos/';
                $config['allowed_types'] = 'jpg|jpeg|png';
                $config['overwrite'] = TRUE;
                $config['max_size'] = "2048000";
                //$config['file_name'] = $_FILES['profile_img']['name'];
                $config['file_name'] = $filenm;

                //Load upload library and initialize configuration
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if ($this->upload->do_upload('profile_img')) {
                    $uploadData = $this->upload->data();
                    $picture['profile_pic'] = $uploadData['file_name'];
                } else {
                    $picture['profile_pic'] = "";
                }
            } else {
                //$picture = '';
                $picture['profile_pic'] = "";
            }
            
            if (isset($_POST['update_flg']) && !empty($_POST['update_flg'])) {   //for updation************************************
                //echo"In Emp Updation";
                $empolyee = $this->Faculty_model->update_faculty($_POST, $picture);
                /* print_r($empolyee);
                  die(); */
                if (!empty($empolyee) && $empolyee > 0) {
                    $this->session->set_flashdata('message1', 'Employee Details Updated Successfully..');
                    redirect('Faculty/visitor_list');
                } else {
                    $this->session->set_flashdata('message1', 'Some problem occured please try again ..');
                    redirect('Faculty/visitor_list');
                }
            } else {                  //for addition of employee************************************		
                //first check availability of emp_id
                $check = $this->Faculty_model->checkEmployeeIDAvailable($_POST['FacultyID']);
                if (!empty($check)) {
                    $this->session->set_flashdata('message1', 'Employee Id Is already alloted......');
                    redirect('Faculty/visitor_list');
                }

                //for addition of employee			
                //echo"In Emp Addition";
                /* Employee Login Credentials Generation */
                $temp = array();
                $temp['username'] = $_POST['FacultyID'];
                $temp['password'] = strtoUpper($_POST['fname']) . strtoUpper($_POST['lname']) . $_POST['FacultyID'];
                //$temp['password']=MD5(strtoUpper($_POST['fname']).strtoUpper($_POST['lname']).$_POST['employeeID']);
                /* print_r($temp);
                  exit; */
                /* End of Employee Login Credentials */
                $empolyee = $this->Faculty_model->add_nem_employee($_POST, $picture, $temp);
                /*  print_r($empolyee);
                  die(); */
                if (!empty($empolyee) && $empolyee > 0) {
                    //send email to the employee forits username and password



                    $this->session->set_flashdata('message1', 'Employee Registered Successfully..');
                    redirect('Faculty/visitor_list');
                }else {
                    $this->session->set_flashdata('message1', 'Some problem occured please try again ..');
                    redirect('Faculty/visitor_list');
                }
            }//end for addition
        }
        $this->load->view('footer');
    }

    public function add_holiday() {
        $this->load->view('header', $this->data);
        if (!empty($_POST)) {
            $holid = $this->Admin_model->addHoliday($_POST);
        }
        if (!empty($holid) && $holid > 0) {
            $this->session->set_flashdata('message1', 'New Holiday Added Successfully..');
            redirect('admin/holiday_list');
        } else {
            $this->session->set_flashdata('message1', 'Some problem occured please try again ..');
            redirect('admin/create_holiday');
        }
        $this->load->view('footer');
    }

    public function view_emp() {
        $this->load->view('header', $this->data);
        $emp_id = $_REQUEST['id'];
        $status = $_REQUEST['status'];
        $result['temp'] = $this->Admin_model->getEmployeeById($emp_id, $status);
        /* echo"<pre>";
          print_r($result);
          echo"</pre>";
          die(); */
        $this->load->view($this->view_dir . 'view_emp', $result);

        $this->load->view('footer');
    }

    public function deact_emp11() {
        $this->load->view('header', $this->data);
        $emp_id = $_REQUEST['id'];
        $status = $_REQUEST['status'];
        $result['temp'] = $this->Admin_model->changeEmployeeStatus($emp_id, $status);
        if ($result) {
            $this->session->set_flashdata('message1', 'profile Status Updated ');
            redirect('admin/employee_list');
        } else {
            $this->session->set_flashdata('message1', 'Some Problem Occured ...');
            redirect('admin/employee_list');
        }
        $this->load->view('footer');
    }

    public function department_list() {
        $this->load->view('header', $this->data);
        /*  $this->data['course_details']= $this->Admin_model->getCollegeCourse($college_id);
          $this->data['course_year']= $this->Admin_model->getCourseYRClg($college_id);
          $this->data['quota']= $this->Admin_model->getQuota($college_id); */

        $this->load->view($this->view_dir . 'department_list', $this->data);
        $this->load->view('footer');
    }

    public function holiday_list() {
        $this->load->view('header', $this->data);
        if (isset($_POST['search_dt1']) && !empty($_POST['search_dt1'])) {
            // $search_dt=$_POST['search_dt1'];
            //  $search_dt=$_POST['search_dt1'].'-01';
            // $time=strtotime($search_dt);
            // $month=date("F",$time);
            //   $year1=date("Y",$time);
            //echo $year;//die();
            $this->data['year'] = $_POST['search_dt1'];
        } else {
            $today = date('Y-m-d');
            $time = strtotime($today);
            $month = date("F", $time);
            $year = date("Y", $time);
            $this->data['year'] = '2017-18'; //default current year
            // $this->data['month']= $month;
        }

        $this->load->view($this->view_dir . 'holiday_list', $this->data);
        $this->load->view('footer');
    }

    public function del_holiday() {
        $hol_id = $_REQUEST['id'];
        $res = $this->Admin_model->del_Holiday($hol_id);
        if ($res == true) {
            $this->session->set_flashdata('message1', 'Holiday Deleted Successfully.. ');
            redirect('admin/holiday_list');
        } else {
            $this->session->set_flashdata('message1', 'Some Problem Occured ...');
            redirect('admin/create_holiday');
        }
    }

    public function del_holidaybyoid() {
        $hol_id = $_REQUEST['id'];
        $res = $this->Admin_model->del_Holiday_byoid($hol_id);
        if ($res == true) {
            $this->session->set_flashdata('message1', 'Holiday Deleted Successfully.. ');
            redirect('admin/holiday_list');
        } else {
            $this->session->set_flashdata('message1', 'Some Problem Occured ...');
            redirect('admin/create_holiday');
        }
    }

    function view_leave_application() {
        $application_id = $_REQUEST['id'];
        $this->load->view('header', $this->data);
        $this->data['leave'] = $this->Admin_model->getAllLeaveType();
        $this->data['details'] = $this->Admin_model->getLeaveDetailById($application_id);
        $this->load->view($this->view_dir . 'view_leave_application', $this->data);
        $this->load->view('footer');
    }

    function view_leave_application_reg() {
        $application_id = $_REQUEST['id'];
        $this->load->view('header', $this->data);
        $this->data['leave'] = $this->Admin_model->getAllLeaveType();
        $this->data['details'] = $this->Admin_model->getLeaveDetailById($application_id);
        $this->load->view($this->view_dir . 'view_leave_application_reg', $this->data);
        $this->load->view('footer');
    }

    function del_leave_app() {
        $application_id = $_REQUEST['id'];
        if (!empty($application_id)) {
            $res = $this->Admin_model->remove_leave_application($application_id);
        }
        if ($res == true) {
            $this->session->set_flashdata('message1', 'Leave Application Deleted Successfully.. ');
            redirect('admin/leave_applicant_list');
        } else {
            $this->session->set_flashdata('message1', 'Some Problem Occured ...');
            redirect('admin/leave_applicant_list');
        }
    }

    function del_od_app() {
        $application_id = $_REQUEST['id'];
        if (!empty($application_id)) {
            $res = $this->Admin_model->remove_od_application($application_id);
        }
        if ($res == true) {
            $this->session->set_flashdata('message1', 'OD Application Deleted Successfully.. ');
            redirect('admin/od_application_list');
        } else {
            $this->session->set_flashdata('message1', 'Some Problem Occured ...');
            redirect('admin/od_application_list');
        }
    }

    function update_leave_application() {

        if (!empty($_POST)) {
            $res = $this->Admin_model->update_leave_applicationDetails($_POST);
        }
        if ($res == 1) {
            /* //Deduct leave balance from staff allocated leave ///leave deduction will be done only leave approved by registrar only* */

            /* if($res['lstatus']=='Approved'){			   
              $deduct=$this->Admin_model->deductLeaveCount($res);
              } */
            $emp_detail = $this->Admin_model->getEmployeeById($_POST['emp_id'], 'Y');
            $reporting = $this->Admin_model->getROforLeave($_POST['emp_id']);
            /* echo"<pre>";print_r($reporting);echo"</pre>";
              echo"************************************************";
              echo"<pre>";print_r($emp_detail);echo"</pre>";
              die();
             */
            //send mail on leave approval/rejection by ro/admin
            /* using curl */
            $ch = curl_init("http://www.carrottech.in/mailer/mailer-sandip-erp-leave.php");
            $to = $emp_detail[0]['oemail']; //to staff
//$to = 'deepak.nagane@carrottech.in,jugal.singh@carrottech.in,mohini.patil@carrottech.in';
            $name = $reporting[0]['fname'] . " " . $reporting[0]['lname'];
            $frm_nm = $name; //$_POST['ename']
            $frm_email = $reporting[0]['oemail']; //$_POST['email']
            $encoded = 'send=true&from_name=' . urlencode($frm_nm) . '&from_email=' . urlencode($frm_email) . '&to=' . urlencode($to) . '&subject=Leave Application Processed';

            $emailId = $emp_detail[0]['oemail'];
            $contactNo = $emp_detail[0]['mobileNumber'];
            $body = 'Hello,<br>';
            $body .= 'Referring to the above mentioned subject,<br>';
            $body .= 'your application for Leave has been ' . $_POST['status'] . ' dated ' . $_POST['applied_on_date'] . ' with leave ID:' . $_POST['lid'];
            if ($_POST['status'] == 'Approved') {
                $body .= '<br> Now your Leave application is forwarded to the Registrar for final approval';
            }
            $body .= '<br>Thanking You.<br><br>';
            $encoded .= '&message=' . urlencode($body) . '&';
// chop off last ampersand
            $encoded = substr($encoded, 0, strlen($encoded) - 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $encoded);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_exec($ch);
            curl_close($ch);
            /* end curl */
            $this->session->set_flashdata('message1', 'Leave Application Updated Successfully.. ');
            redirect('admin/leave_applicant_list');
        } else {
            $this->session->set_flashdata('message1', 'Some Problem Occured ...');
            redirect('admin/leave_applicant_list');
        }
    }

    function update_leave_application_registrar() {
        if (!empty($_POST)) {
            $res = $this->Admin_model->update_leave_applicationByRegistrar($_POST);
        }

        if ($res['ures'] == 1) {
            //Deduct leave balance from staff allocated leave ///leave deduction will be done only leave approved by registrar only**/

            if ($res['lstatus'] == 'Approved') {
                $deduct = $this->Admin_model->deductLeaveCount($res);
            }
            $emp_detail = $this->Admin_model->getEmployeeById($_POST['emp_id'], 'Y');
            $reporting = $this->Admin_model->getROforLeave($_POST['emp_id']);
            /* echo"<pre>";print_r($reporting);echo"</pre>";
              echo"************************************************";
              echo"<pre>";print_r($emp_detail);echo"</pre>";
              die();
             */
            //send mail on leave approval/rejection by ro/admin
            /* using curl */
            $ch = curl_init("http://www.carrottech.in/mailer/mailer-sandip-erp-leave.php");
            $to = $emp_detail[0]['oemail']; //to staff
//$to = 'deepak.nagane@carrottech.in,jugal.singh@carrottech.in,mohini.patil@carrottech.in';
            $name = $reporting[0]['fname'] . " " . $reporting[0]['lname'];
            $frm_nm = $name; //$_POST['ename']
            $frm_email = $reporting[0]['oemail']; //$_POST['email']
            $encoded = 'send=true&from_name=' . urlencode($frm_nm) . '&from_email=' . urlencode($frm_email) . '&to=' . urlencode($to) . '&subject=Leave Application Processed';

            $emailId = $emp_detail[0]['oemail'];
            $contactNo = $emp_detail[0]['mobileNumber'];
            $body = 'Hello,<br>';
            //  $body .= 'Referring to the above mentioned subject,<br>';
            $body .= 'your application for Leave has been ' . $_POST['reg_approval_status'] . ' dated ' . $_POST['applied_on_date'] . 'with leave ID:' . $_POST['lid'];
            $body .= '<br>Thanking You.<br><br>';
            $encoded .= '&message=' . urlencode($body) . '&';
// chop off last ampersand
            $encoded = substr($encoded, 0, strlen($encoded) - 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $encoded);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_exec($ch);
            curl_close($ch);
            /* end curl */
            $this->session->set_flashdata('message1', 'Leave Application Updated Successfully.. ');
            redirect('admin/leave_applicant_list');
        } else {
            $this->session->set_flashdata('message1', 'Some Problem Occured ...');
            redirect('admin/leave_applicant_list');
        }
    }

    function update_od_application() {
        if (!empty($_POST)) {
            /* print_r($_POST);
              die(); */
            $res = $this->Admin_model->update_od_applicationDetails($_POST);
        }
        if ($res == true) {
            //send mail on leave approval/rejection by ro/admin
            $emp_detail = $this->Admin_model->getEmployeeById($_POST['emp_id'], 'Y');
            $reporting = $this->Admin_model->getROforLeave($_POST['emp_id']);
            /* echo"<pre>";print_r($reporting);echo"</pre>";
              echo"************************************************";
              echo"<pre>";print_r($emp_detail);echo"</pre>";
              die();
             */
            //send mail on leave approval/rejection by ro/admin
            /* using curl */
            $ch = curl_init("http://www.carrottech.in/mailer/mailer-sandip-erp-leave.php");
            $to = $emp_detail[0]['oemail']; //to staff
//$to = 'deepak.nagane@carrottech.in,jugal.singh@carrottech.in,mohini.patil@carrottech.in';
            $name = $reporting[0]['fname'] . " " . $reporting[0]['lname'];
            $frm_nm = $name; //$_POST['ename']
            $frm_email = $reporting[0]['oemail']; //$_POST['email']
            $encoded = 'send=true&from_name=' . urlencode($frm_nm) . '&from_email=' . urlencode($frm_email) . '&to=' . urlencode($to) . '&subject=OD Application Processed';

            $body = 'Hello,<br>';
            $body .= 'Referring to the above mentioned subject,<br>';
            $body .= 'your application for OD has been' . $_POST['status'] . 'dated' . $_POST['od_applied_on_date'] . 'with OD ID:' . $_POST['lid'];
            $body .= 'Thanking You.<br><br>';
            $encoded .= '&message=' . urlencode($body) . '&';
// chop off last ampersand
            $encoded = substr($encoded, 0, strlen($encoded) - 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $encoded);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_exec($ch);
            curl_close($ch);
            /* end curl */

            $this->session->set_flashdata('message1', 'OD Application Updated Successfully.. ');
            redirect('admin/od_application_list');
        } else {
            $this->session->set_flashdata('message1', 'Some Problem Occured ...');
            redirect('admin/od_application_list');
        }
    }

    public function leave_applicant_list() {
        $this->load->view('header', $this->data);
        if ($this->session->userdata("uid") == 1) {  //for Admin
            $this->data['applicant'] = $this->Admin_model->getAllLeaveApplicantList();
        } else {
            $this->data['applicant'] = $this->Admin_model->getLeaveApplicantList($this->session->userdata("role_id"), $this->session->userdata("name"));
        }

        $this->load->view($this->view_dir . 'leave_process', $this->data);
        $this->load->view('footer');
    }

    public function od_application_list() {
        $this->load->view('header', $this->data);
        if ($this->session->userdata("uid") == 1) {
            $this->data['applicant'] = $this->Admin_model->getAllODApplicantList();
        } else {
            $this->data['applicant'] = $this->Admin_model->getODApplicantList($this->session->userdata("uid"), $this->session->userdata("name"));
        }

        $this->load->view($this->view_dir . 'od_process', $this->data);
        $this->load->view('footer');
    }

    function view_od_application() {
        $application_id = $_REQUEST['id'];
        $this->load->view('header', $this->data);
        $this->data['details'] = $this->Admin_model->getODDetailById($application_id);
        $this->load->view($this->view_dir . 'view_od_application', $this->data);
        $this->load->view('footer');
    }

    //*****For Attendance*****/////
    public function dailycron() {
        //Copy data from device log table to System punching backup table//
        // first check for todays entry present or not
        $check = $this->Admin_model->check_todays();
        /* print_r($check);
          die(); */
        if (empty($check)) {
            $res = $this->Admin_model->backupDeviceLogDaily();
        }
    }

    public function attendance_all($offSet = 0) {
        $this->load->view('header', $this->data);
        $limit = 5; // set records per page
        if (isset($_REQUEST['per_page']) && !empty($_REQUEST['per_page'])) {
            $offSet = $_REQUEST['per_page'];
        }
        //Copy data from device log to System table//
        $check = $this->Admin_model->check_todays();

        if (empty($check)) {
            $res = $this->Admin_model->backupDeviceLogDaily();
        }

        //end of copy//
        //	$cnt=$this->Admin_model->getAttendance_AllDefault1(); // for getting count only
        $total = count($cnt);
        $total_pages = ceil($total / $limit);
        //	echo $total_pages; 
        $this->load->library('pagination');
        $config['first_url'] = $config['base_url'] . $config['suffix'];
        $config['enable_query_strings'] = TRUE;
        $config['page_query_string'] = TRUE;
        $config['reuse_query_string'] = TRUE;
        $config['base_url'] = base_url() . 'admin/attendance_all?';
        $config['total_rows'] = $total;
        $config['per_page'] = $limit;
        $this->pagination->initialize($config);
        $this->data['paginglinks'] = $this->pagination->create_links();
        $config['offSet'] = $offSet;
        $total = ceil($rows / $limit);
        $this->data['school_list'] = $this->Admin_model->getAllschool();
        $this->data['dept_list'] = $this->Admin_model->getAllDepartments();
        $this->data['desig_list'] = $this->Admin_model->getAllDesignations();
        //  $this->data['attendance']= $this->Admin_model->getAttendance_AllDefault($offSet,$limit); // for fetching result of punched

        $this->load->view($this->view_dir . 'display_attendance', $this->data);
        $this->load->view('footer');
    }

    public function view_attendance($offSet = 0) {
        $this->load->view('header', $this->data);
        $limit = 70; // set records per page

        $this->data['school_list'] = $this->Admin_model->getAllschool();
        $this->data['dept_list'] = $this->Admin_model->getAllDepartments();
        $this->data['desig_list'] = $this->Admin_model->getAllDesignations();

        if (isset($_REQUEST['per_page']) && !empty($_REQUEST['per_page'])) {
            $offSet = $_REQUEST['per_page'];
        }
        if (!empty($_POST)) {

            $temp = ['attend_date' => $_POST['attend_date'],
                'emp_school' => $_POST['emp_school'],
                'department' => $_POST['department']
            ];
            $this->session->set_userdata($temp);
        }
        $data['attend_date'] = $this->session->userdata("attend_date");
        $data['emp_school'] = $this->session->userdata("emp_school");
        $data['department'] = $this->session->userdata("department");

        //for all department and under that all schools attendance
        if (empty($data['emp_school']) && empty($data['department'])) {
            //echo "inside date";
            $this->data['attend_date'] = $data['attend_date'];
            //first check whether the attandance available in punching backup table
            $check_dt = $this->Admin_model->checkAvailableAttendance($this->data['attend_date']);

            if (!empty($check_dt)) {
                //get distinct schoolfrom employee master table for displaying attendance of all school
                $all_school = $this->Admin_model->getAllDistinctSchool(); //first get all school
                $this->data['all_school'] = $all_school;
                foreach ($all_school as $key => $val) {
                    $school[] = $all_school[$key]['emp_school'];
                }

                for ($i = 0; $i < count($school); $i++) {
                    $all_emp[$school[$i]] = $this->Admin_model->getEmpForAllSchool($school[$i], $data['attend_date']); //get all employee school wise 
                }

                $employeelist = array();
                foreach ($all_emp as $em) {
                    foreach ($em as $key => $val) {
                        $employeelist[] = array_merge($em[$key]);
                    }
                }
                asort($employeelist); //for sorting according to employee id ascending 
                $this->data['all_emp'] = $employeelist;
                foreach ($all_emp as $em) {

                    foreach ($em as $key => $val) {

                        $attendance[$em[$key]['emp_id']] = $this->Admin_model->getAttendanceForAllSchool($em[$key]['emp_id'], $data['attend_date']);
                    }
                }
                $this->data['attendance'] = $attendance;
            } elseif (empty($check_dt)) {
                $this->data['all_emp'] = "";
                $this->data['attendance'] = "";
            }
            $this->load->view($this->view_dir . 'display_attendance', $this->data);
        } elseif (!empty($data['emp_school']) && empty($data['department'])) { //for all deprtment under only selected School
            $this->data['attend_date'] = $data['attend_date'];
            //first check whether the attandance available in punching backup table
            $check_dt = $this->Admin_model->checkAvailableAttendance($this->data['attend_date']);

            if (!empty($check_dt)) {
                //get distinct school from employee master table for displaying attendance of selected school
                $all_emp = $this->Admin_model->getAllEmployeeUnderSchool($data['emp_school'], $data['attend_date']); //first get all employee under selected school
                $this->data['all_emp'] = $all_emp;
                for ($i = 0; $i < count($all_emp); $i++) {
                    $attendance[$all_emp[$i]['emp_id']] = $this->Admin_model->getAttendanceForAllSchool($all_emp[$i]['emp_id'], $data['attend_date']);
                }
                /* echo"<pre>";print_r($attendance);echo"</pre>";
                  die(); */
                $this->data['attendance'] = $attendance;
            } elseif (empty($check_dt)) {
                $this->data['all_emp'] = "";
                $this->data['attendance'] = "";
            }
            $this->load->view($this->view_dir . 'display_attendance', $this->data);
        } else {
            $this->data['attend_date'] = $data['attend_date'];
            //first check whether the attandance available in punching backup table
            $check_dt = $this->Admin_model->checkAvailableAttendance($this->data['attend_date']);

            if (!empty($check_dt)) {

                $all_emp = $this->Admin_model->getAttendance_All1($data);
                $total = count($all_emp);
                $total_pages = ceil($total / $limit);
                $this->load->library('pagination');
                $config['first_url'] = $config['base_url'] . $config['suffix'];
                $config['enable_query_strings'] = TRUE;
                $config['page_query_string'] = TRUE;
                $config['reuse_query_string'] = TRUE;
                $config['base_url'] = base_url() . 'admin/view_attendance?';
                $config['total_rows'] = $total;
                $config['per_page'] = $limit;
                $this->pagination->initialize($config);
                $this->data['paginglinks'] = $this->pagination->create_links();
                $config['offSet'] = $offSet;
                $total = ceil($rows / $limit);

                $this->data['attend_date'] = $data['attend_date'];
                $this->data['all_emp'] = $all_emp;
                $this->data['attendance'] = $this->Admin_model->getAttendance_All($data, $all_emp, $offSet, $limit);
                $this->load->view($this->view_dir . 'display_attendance', $this->data);
            } elseif (empty($check_dt)) {
                $this->data['all_emp'] = "";
                $this->data['attendance'] = "";
                $this->load->view($this->view_dir . 'display_attendance', $this->data);
            }
        }

        $this->load->view('footer');
    }

    function exporttoexcel() {
        $this->load->view($this->view_dir . 'exporttoexcel');
    }

    function exporttoexcelattend() {
        $this->load->view($this->view_dir . 'exporttoexcelattend');
    }

    //searching attendance of a user by Id and updating it
    public function search_attendance() {
        $this->load->view('header', $this->data);
        $this->data['org_list'] = $this->Admin_model->getAllOrganizations();
        $this->data['school_list'] = $this->Admin_model->getAllschool();
        $this->data['dept_list'] = $this->Admin_model->getAllDepartments();
        $this->data['desig_list'] = $this->Admin_model->getAllDesignations();
        $this->load->view($this->view_dir . 'search_attendance', $this->data);
        $this->load->view('footer');
    }

    public function fetch_attendance() {
        $this->load->view('header', $this->data);
        $this->data['org_list'] = $this->Admin_model->getAllOrganizations();
        $this->data['school_list'] = $this->Admin_model->getAllschool();
        $this->data['dept_list'] = $this->Admin_model->getAllDepartments();
        $this->data['desig_list'] = $this->Admin_model->getAllDesignations();
        if (isset($_POST) && !empty($_POST)) {
            $this->data['res'] = $this->Admin_model->getAttendanceForSearchID($_POST);
            $this->data['present'] = $this->Admin_model->getTotalPresentByID($_POST); // total present
            $this->data['abscent'] = $this->Admin_model->getTotalAbscentByID($_POST); // total abscent
            $this->data['outer'] = $this->Admin_model->getTotalOuterDutyByID($_POST); // total OD(outerDuty)
            $this->data['over'] = $this->Admin_model->getTotalOverTimeByID($_POST); // total OT(overtime)
            $this->data['late'] = $this->Admin_model->getTotalLatemarkByID($_POST); // total LT(Latemark)
            $this->data['leave'] = $this->Admin_model->getTotalLeaveByID($_POST); // total Leave(Leave)
            if (!empty($this->data['res'])) {
                $this->load->view($this->view_dir . 'search_attendance', $this->data);
            } else {

                $this->session->set_flashdata('message1', 'No Result Found...');
                redirect('admin/search_attendance');
            }
        }
        $this->load->view('footer');
    }

    public function update_attendance() {
        $emp_id1 = $_POST['emp_id'];
        $name1 = $_POST['name'];
        $adate1 = $_POST['adate'];
        $intime1 = $_POST['intime'];
        $outtime1 = $_POST['outtime'];
        $reason = $_POST['reason'];

        if (isset($_POST) && !empty($_POST)) {

            $res = $this->Admin_model->updateEmpAttendance($_POST);

            if ($res == true) {
                $this->session->set_flashdata('message1', 'Employee Attendance Status Updated...');
                redirect('admin/search_attendance', 'refresh');
            }
            if ($res == false) {
                $this->session->set_flashdata('message1', 'some problem occured try again...');
                redirect('admin/search_attendance');
            }
        }
    }

    //for calculating total monthly attendance i.e.total day present ,total day OD,Cl,PL,etc..

    public function total_monthly_attendance() {

        $this->load->view('header', $this->data);
        $this->data['school_list'] = $this->Admin_model->getAllschool();
        $this->data['dept_list'] = $this->Admin_model->getAllDepartments();
        $this->data['desig_list'] = $this->Admin_model->getAllDesignations();

        if (isset($_POST['submit'])) {

            $this->data['emp_school'] = $_POST['emp_school'];
            $this->data['department'] = $_POST['department'];
            $this->data['attend_date'] = $_POST['attend_date'];
            $check_dt = $this->Admin_model->checkAvailableAttendance($this->data['attend_date']);

            if (!empty($check_dt)) {
                /* calculate sundays and holidyas of a serched month and total working days,present days */
                $attend_date = $this->data['attend_date'];
                $date = $attend_date . "-01";
                $lt = date('t', strtotime($attend_date)); //get end date of month
                $end = $attend_date . "-" . $lt;
                $time = strtotime($attend_date);
                $d = date_parse_from_format("Y-m-d", $attend_date);
                $msearch = $d["month"]; //month number
                $ysearch = date("Y", strtotime($attend_date));
                $monthName = date('F', mktime(0, 0, 0, $msearch, 10)); // month name
                $totaldays = cal_days_in_month(CAL_GREGORIAN, $msearch, $ysearch); //total month days
                $i = 1;

                //calculate number of sundays in given month
                function total_sundays($monthName, $ysearch) {
                    $sundays = 0;
                    $total_days = cal_days_in_month(CAL_GREGORIAN, $monthName, $ysearch);
                    for ($i = 1; $i <= $total_days; $i++)
                        if (date('N', strtotime($ysearch . '-' . $monthName . '-' . $i)) == 7)
                            $sundays++;
                    return $sundays;
                }

                $total_sun = total_sundays($msearch, $ysearch);
                $total_holiday = $this->Admin_model->getTotalHoliday($msearch, $ysearch);
                //echo $total_holiday;
                $working_days = $totaldays - ($total_sun + $total_holiday);
                /*                 * *********************************end************************************* */



                $all_attend = $this->Admin_model->getAllTotalAttendance($_POST);

                for ($i = 0; $i < count($all_attend); $i++) {
                    $temp = $this->Admin_model->getremainingAllLeaveCountByEmp($all_attend[$i]['UserId'], $this->data['attend_date']);
                    $all_attend[$i]['total_CL'] = $temp['total_CL'];
                    $all_attend[$i]['total_ML'] = $temp['total_ML'];
                    $all_attend[$i]['total_EL'] = $temp['total_EL'];
                    $all_attend[$i]['total_Coff'] = $temp['total_Coff'];
                    $all_attend[$i]['total_SL'] = $temp['total_SL'];
                    $all_attend[$i]['total_VL'] = $temp['total_VL'];
                    $all_attend[$i]['total_leave'] = $temp['total_leave'];
                    $all_attend[$i]['total_LWP'] = $temp['total_LWP'];
                    $all_attend[$i]['total_STL'] = $temp['total_STL'];
                    $all_attend[$i]['month_days'] = $totaldays;
                    $all_attend[$i]['working_days'] = $working_days;
                    $all_attend[$i]['sunday'] = $total_sun;
                    $all_attend[$i]['holiday'] = $total_holiday;
                }

                /* till this fetched all count,now add/update */
                $result = $this->Admin_model->add_update_final_monthly_attendance($all_attend, $this->data['attend_date']);
                $this->data['all_attend'] = $this->Admin_model->fetch_employee_monthly($this->data['attend_date']);

                /* echo"<pre>";print_r($this->data['all_attend']);
                  die(); */
            } elseif (empty($check_dt)) {
                $this->data['all_attend'] = "";
            }
        }
        $this->load->view($this->view_dir . 'total_attendance', $this->data);
        $this->load->view('footer');
    }

    //day wise attendance
    public function daywise_attendance() {

        $this->load->view('header', $this->data);
        $this->data['school_list'] = $this->Admin_model->getAllschool();
        $this->data['dept_list'] = $this->Admin_model->getAllDepartments();


        if (isset($_POST['submit'])) {

            $this->data['emp_school'] = $_POST['emp_school'];
            $this->data['department'] = $_POST['department'];
            $this->data['attend_date'] = $_POST['attend_date'];
            $check_dt = $this->Admin_model->checkAvailableAttendanceDate($this->data['attend_date'], $_POST['emp_school'], $_POST['department']);
            // print_r($check_dt);
            // exit;
            if (!empty($check_dt)) {

                $this->data['all_attend'] = $this->Admin_model->checkAvailableAttendanceDate($this->data['attend_date'], $_POST['emp_school'], $_POST['department']);

                /* echo"<pre>";print_r($this->data['all_attend']);
                  die(); */
            } elseif (empty($check_dt)) {
                $this->data['all_attend'] = "";
            }
        }
        $this->load->view($this->view_dir . 'daywise_attendance', $this->data);
        $this->load->view('footer');
    }

    //staff for maunnal attendance
    public function mark_staff() {
        $this->load->view('header', $this->data);
        $this->data['emp_list'] = $this->Admin_model->getEmployees();
        if (isset($_POST['mark'])) {
            /* echo"<pre>";print_r($_POST);
              exit; */
            $marked = $this->Admin_model->mark_Employee_manually($_POST);

            if ($marked == 1) {
                $this->session->set_flashdata('message1', 'Selected employee marked for manual attendance');
                redirect('admin/mark_staff');
            } else {
                $this->session->set_flashdata('message1', '');
                redirect('admin/mark_staff');
            }
        }
        $this->load->view($this->view_dir . 'mark_emp_for_manual_attend', $this->data);
        $this->load->view('footer');
    }

    /*     * Assign staff manual attendnce for the searched month if other employees
      attendnce is available for that searched month from punching_backup  table* */

    public function staff_manual_attendance() {
        $this->load->view('header', $this->data);
        /* $this->data['school_list']= $this->Admin_model->getAllschool();	 
          $this->data['dept_list']= $this->Admin_model->getAllDepartments();
          $this->data['desig_list']= $this->Admin_model->getAllDesignations(); */
        if (isset($_POST['view'])) {
            //
            $jdt = $this->Admin_model->checkpunchingBackup_for_manualattend($_POST['for_month_year']);
            if ($jdt == 1) {

                $this->data['emp_list'] = $this->Admin_model->get_Marked_Emp_Manual();
                /*  //first check the attendnce is available for serched month year
                  for($i=0;$i<count($this->data['emp_list']);$i++){
                  $this->Admin_model->get_Marked_Emp_attendance();
                  } */

                $this->data['attend_date'] = $_POST['for_month_year'];
            }
            if ($jdt == 0) {
                $this->session->set_flashdata('message1', 'Sorry You can not add attendce now.You have to wait till Month end');
            }
        }

        // print_r($this->data['emp_list']);exit;
        if (isset($_POST['attend_submit'])) {

            $temp1 = $_POST;
            $temp = array();
            for ($i = 0; $i < count($temp1['eid']); $i++) {
                $temp[$i]['eid'] = $temp1['eid'][$i];
                $temp[$i]['ename'] = $temp1['ename'][$i];
                $temp[$i]['month_days'] = $temp1['month_days'][$i];
                $temp[$i]['present_days'] = $temp1['present_days'][$i];
                $temp[$i]['working_days'] = $temp1['working_days'][$i];
                $temp[$i]['sunday'] = $temp1['sundays'][$i];
                $temp[$i]['holiday'] = $temp1['holidays'][$i];
                $temp[$i]['OD'] = $temp1['OD'][$i];
                $temp[$i]['CL'] = $temp1['CL'][$i];
                $temp[$i]['ML'] = $temp1['ML'][$i];
                $temp[$i]['EL'] = $temp1['EL'][$i];
                $temp[$i]['C-Off'] = $temp1['C-Off'][$i];
                $temp[$i]['SL'] = $temp1['SL'][$i];
                $temp[$i]['VL'] = $temp1['VL'][$i];
                $temp[$i]['Leave'] = $temp1['Leave'][$i];
                $temp[$i]['LWP'] = $temp1['LWP'][$i];
                $temp[$i]['STL'] = $temp1['STL'][$i];
                $temp[$i]['Total'] = $temp1['Total'][$i];
            }
            /* echo"<pre>";print_r($temp);
              die(); */
            $add = $this->Admin_model->add_upd_Emp_Manual_Attendance($temp, $_POST['attend_date']);
            if ($add == 1) {
                $this->session->set_flashdata('message1', 'Employee manual attendance added successfully...');
                redirect('admin/staff_manual_attendance');
            }
        }
        $this->load->view($this->view_dir . 'assign_emp_manual_attend', $this->data);
        $this->load->view('footer');
    }

    public function getEmpListMarked_Emp_Manual() {
        $school = $_REQUEST['school'];
        $department = $_REQUEST['department'];
        $this->data['emp_list'] = $this->Admin_model->get_Marked_Emp_Manual($school, $department);
        $emp = $this->data['emp_list'];
        if (!empty($emp)) {
            echo "<option  value='' >Select Employee </option>";
            foreach ($emp as $key => $val) {
                echo "<option  value=" . $emp[$key]['emp_id'] . ">" . $emp[$key]['fname'] . " " . $emp[$key]['mname'] . " " . $emp[$key]['lname'] . "</option>";
            }
        } else {
            echo "<option  value='' >No Employee Marked For Manual Attendance</option>";
        }
    }

    //Staff Leave Allocation
    public function staff_leave_allocation_list() {
        $this->load->view('header', $this->data);
        $this->data['all_emp_leave'] = $this->Admin_model->fetchAllEmpLeaves();
        /* echo"<pre>";print_r($this->data['all_emp_leave']);
          die(); */
        $this->load->view($this->view_dir . 'staff_leave_allocation_list', $this->data);
        $this->load->view('footer');
    }

    public function staff_leave_allocation() {
        $this->load->view('header', $this->data);
        $this->data['school_list'] = $this->Admin_model->getAllschool();
        $this->data['dept_list'] = $this->Admin_model->getAllDepartments();
        $this->data['desig_list'] = $this->Admin_model->getAllDesignations();
        $this->data['get_quarter'] = $this->Admin_model->getCurrentQuarterNo();
        if (isset($_REQUEST['lv_id'])) {
            $leave_track_id = $_REQUEST['lv_id'];
            $this->data['emp_leave_info'] = $this->Admin_model->getEmpleave_track($leave_track_id);
            // print_r($this->data['emp_leave_info']);exit;
        }
        if (isset($_POST['submit'])) {
            //print_r($_POST);exit;
            if (isset($_POST['inupdate'])) {
                $update = $this->Admin_model->update_allocated_StaffLeave($_POST);
                if ($update == 1) {
                    $this->session->set_flashdata('message1', 'Employee Leaves updated successsfully');
                    redirect('admin/staff_leave_allocation_list');
                }
            } else {
                $add = $this->Admin_model->allocateStaffLeave($_POST);
                if ($add == 1) {
                    $this->session->set_flashdata('message1', 'Employee Leaves added successsfully');
                    redirect('admin/staff_leave_allocation_list');
                }
            }
        }


        $this->load->view($this->view_dir . 'staff_leave_allocation', $this->data);
        $this->load->view('footer');
    }

    public function getjoiningdtEmp() {
        $emp_id = $_REQUEST['empl_id'];
        $jdt = $this->Admin_model->getEmpJoiningdt($emp_id);
        echo"<input type='hidden' name='joiningDate' value='" . $jdt . "'>";
    }

    //function to check punching backup for data available of searched date
    public function checkpunchingBackup() {
        $search_dt = $_REQUEST['search_dt'];
        $jdt = $this->Admin_model->checkpunchingBackup_for_manualattend($search_dt);
        if ($jdt == 1) {
            echo "continue";
        } elseif ($jdt == 0) {
            echo "stop";
        }
        //	echo"<input type='hidden' name='joiningDate' value='".$jdt."'>";
    }

    public function search() {
        $para = $this->input->post("title");
        $emp_details = $this->Admin_model->getEmployeeById($para, 'Y');
        echo json_encode(array("emp_details" => $emp_details));
    }

    public function table_exporttopdf() {
        //error_reporting(E_ALL);
        $content = '<style>

.attexl table th{
    border: 1px solid black;
    padding: 5px;
    background-color:grey;
    color: white;
}
.add-table tr td{border:0px}

.attexl table  td{
	 border: 1px solid black;
    padding: 5px;border-collapse: collapse
}
.bottom-table{padding:50px 0 20px 0}
.bottom-table-2{padding-top:20px}
</style>

<div class="row">

<div class="col-lg-12">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top" width="100"><img src="' . site_url() . 'assets/images/lg.png" alt="Sandip University" class="img-responsive"></td>
    <td valign="top" align="center">
    <span style="font-size:25px;text-align:center"><b>Sandip University</b></span><br>
    <span style="text-align:center;font-size:11px">Trimbak Road, A/p - Mahiravani, Nashik – 422 213</span><br>
    <span style="font-size:10px;text-align:center">Website : http://www.sandipuniversity.com | Email : info@sandipuniversity.com </span><br>
    <span style="font-size:15px;;text-align:center"><strong>Ph: (02594) 222 541 Fax: (02594) 222 555</strong></span>
    </td>
  </tr>
</table>
<hr  style="border-width:1px;">

</div>
<div class="col-lg-12">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
  <td align="right">
  <strong>Date :</strong> ___ /___ /_________
  </td>
  </tr>
  </table>
  
</div>
</div>';

        $content .= $_REQUEST['datatodisplay'];
        $content .= '
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" class="bottom-table"><strong>Prepared by:</strong></td>
    <td align="center" class="bottom-table"><strong>Varified by:</strong></td>
    <td align="center" class="bottom-table"><strong>Approved by:</strong></td>
  </tr>
  <tr>
    <td align="center" class="bottom-table-2"><strong>Establishment Clerk</strong></td>
    <td align="center" class="bottom-table-2"><strong>O.S.D.</strong></td>
    <td align="center" class="bottom-table-2"><strong>Register</strong></td>
  </tr>
  <tr>
    <td align="center">Sandip University</td>
    <td align="center">Sandip University</td>
    <td align="center">Sandip University</td>
  </tr>
</table>

        
        
        ';
        $html = $content; // render the view into HTML


        $this->load->library('M_pdf');

        //$data['result'] = $this->mod->getReport();


        $mpdf = new mPDF();

        $this->m_pdf->pdf = new mPDF('c', 'A4', '', '5', 10, 10, 10, 10, 10, 10);



        $this->m_pdf->pdf->WriteHTML($html);
        $pdfFilePath = 'MonthlyAttendance';
        //download it.
        $this->m_pdf->pdf->Output($pdfFilePath, "D");
    }

    public function inout_table_exporttopdf() {
        //error_reporting(E_ALL);
        ini_set('max_execution_time', 150000);
        ini_set('memory_limit', '5048M');

        $content = '<style>

.attexl table th{
    border: 1px solid black;
    padding: 5px;
    background-color:grey;
    color: white;
}
.add-table tr td{border:0px}

.attexl table  td{
	 border: 1px solid black;
    padding: 5px;border-collapse: collapse
}
.bottom-table{padding:50px 0 20px 0}
.bottom-table-2{padding-top:20px}
</style>

<div class="row">

<div class="col-lg-12">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top" width="100"><img src="' . site_url() . 'assets/images/lg.png" alt="Sandip University" class="img-responsive"></td>
    <td valign="top" align="center">
    <span style="font-size:25px;text-align:center"><b>Sandip University</b></span><br>
    <span style="text-align:center;font-size:11px">Trimbak Road, A/p - Mahiravani, Nashik – 422 213</span><br>
    <span style="font-size:10px;text-align:center">Website : http://www.sandipuniversity.com | Email : info@sandipuniversity.com </span><br>
    <span style="font-size:15px;;text-align:center"><strong>Ph: (02594) 222 541 Fax: (02594) 222 555</strong></span>
    </td>
  </tr>
</table>
<hr  style="border-width:1px;">

</div>
<div class="col-lg-12">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
  <td align="right">
  <strong>Date :</strong> ___ /___ /_________
  </td>
  </tr>
  </table>
  
</div>
</div>';

        $content .= $_REQUEST['datatodisplay'];



        $html = $content; // render the view into HTML


        $this->load->library('M_pdf');

        //$data['result'] = $this->mod->getReport();


        $mpdf = new mPDF();

        $this->m_pdf->pdf = new mPDF('L', 'A4-L', '', '5', 10, 10, 10, 10, 10, 10);



        $this->m_pdf->pdf->WriteHTML($html);
        $pdfFilePath = "MonthInOutTimeReport";
        //download it.
        $this->m_pdf->pdf->Output($pdfFilePath, "D");
    }
	// display visitor list  added on 25/09/17
	function visitor_list()
	{
		$this->load->model('Faculty_model');
        $menu = $this->uri->segment(1);
     $menu1 = $this->uri->segment(2);
     $this->data['my_privileges'] = $this->retrieve_privileges($menu."/".$menu1);
        $this->load->view('header', $this->data);
        $this->data['fac_list']= $this->Faculty_model->getVisitorFacultyList();                        
        $this->load->view($this->view_dir . 'visitor_list', $this->data);
        $this->load->view('footer');
	}
	// view employee
	public function view_visiting_emp(){
		$this->load->model('Faculty_model');
        $this->load->view('header',$this->data); 
            $emp_id=$_REQUEST['id'];
            $status=$_REQUEST['status'];
            $result['temp']=$this->Faculty_model->getEmployeeById($emp_id,$status);
            /* echo"<pre>";
            print_r($result);
            echo"</pre>";
            die();  */
             $this->load->view($this->view_dir.'view_visiting_emp',$result);
            
         $this->load->view('footer');
    }
	// deactvate visitor emp
	public function deact_emp() {
		$this->load->model('Faculty_model');
        $this->load->view('header', $this->data);
        $emp_id = $_REQUEST['id'];
        $status = $_REQUEST['status'];
        $result['temp'] = $this->Faculty_model->changeEmployeeStatus($emp_id, $status);
        if ($result) {
            $this->session->set_flashdata('message1', 'profile Status Updated ');
            redirect('Faculty/visitor_list');
        } else {
            $this->session->set_flashdata('message1', 'Some Problem Occured ...');
            redirect('Faculty/visitor_list');
        }
        $this->load->view('footer');
    }

    public function sendtofaculty(){
        $DB1 = $this->load->database('umsdb', TRUE); 
        //echo '<pre>';
        //print_r($_REQUEST);exit;
        $this->load->model('Question_paper_model');
        $this->load->model('Master_model');
        $semester = $_REQUEST['semester'];
        $facultyy = $_REQUEST['faculty_id'];
        $academicyear = $_REQUEST['academicyear'];
        $exam_session = $_REQUEST['exam_session'];
        $exam =explode('-',$_REQUEST['exam_session']);
        $streamId =   $_REQUEST['streamId'];
        $stream_details = $this->Master_model->get_stream_details($streamId);
        $fac = $this->Question_paper_model->get_faculty_details($facultyy);
		$faculty_email =$fac[0]['email_id']; 
		//print_r($fac);
		//exit;
        $course_type =   $stream_details[0]['course_type'];
        if($stream_details[0]['course_type'] == 'UG'){
         $price = 500;
         }elseif($stream_details[0]['course_type'] == 'PG'){
         $price = 700;
         }elseif($stream_details[0]['course_type'] == 'PHD'){
         $price = 1500;
         }else {
         $price = 400;
        }

        ////print_r($stream_details[0]['course_type']);exit; 

        $order_id =random_int(100000, 999999);
        $courseId = $_REQUEST['courseId'];
        $no_of_set = $_REQUEST['no_of_set'];
        $duration = $_REQUEST['duration'];
        $date_of_submit = $_REQUEST['date_of_submit'];
        $exam_month = $exam[0];
        $exam_year = $exam[1];
        $exam_id = $exam[2];
        $no_of_set = $_REQUEST['no_of_set'];
        $chk_sub = $_REQUEST['chk_sub'];
        //foreach ($_REQUEST['chk_sub'] as $sub ){
        for($i = 0; $i< count($chk_sub); $i++){    
          $data['subject_id'] = $chk_sub[$i];
          $data['stream_id'] = $streamId;
          $data['semester'] = $semester;
          $data['course_id'] = $courseId;
          $data['sesseion'] = $academicyear;
          $data['faculty_id'] = $facultyy;
          $data['last_date_of_submit'] = $date_of_submit;
          $data['duration'] = $duration;
          $data['no_of_sets'] = $no_of_set[$i];
          $data['exam_month'] = $exam_month;
          $data['exam_year'] = $exam_year;
          $data['price_per_set'] = $price;
          $data['order_id'] = $order_id;
          $data['exam_id'] = $exam_id;
          $data['course_type'] = $course_type;
          //$test=$this->db->insert('question_paper',$data);
          $insert_id =$this->Question_paper_model->add_nem_qp($data);
        }




          if(isset($order_id) && !empty($order_id)){
             $this->load->library('m_pdf');
                    //$html = "<span style='color:red;'>Note:This is an autogenerated mail,Please dont reply for this mail.</span>";
                    $this->data['qp_details'] = $this->Question_paper_model->get_qp_details($order_id);
                     $html = $this->load->view($this->view_dir.'question_papper_pdf',$this->data,true);
                    //$html = $this->load->view($this->view_dir.'ajax_student_att_commu_report_pdf',$this->data,true);
                    //$pdfFilePath = "qp".$insert_id.".pdf";
                    $mpdf=new mPDF('utf-8', 'A4', '10', '10', '10', '10', '10', '10');
                    $mpdf->autoScriptToLang = true;
                    $mpdf->baseScript = 1;  // Use values in classes/ucdn.php  1 = LATIN
                    $mpdf->autoVietnamese = true;
                    $mpdf->autoArabic = true;
                    $mpdf->autoLangToFont = true;
                    $mpdf->SetMargins(10,10,15);
                    $mpdf->SetDisplayMode('fullpage');                   
                    $html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
                    $mpdf->WriteHTML($html);
					$pdfData = $mpdf->Output('', 'S');
					$file="qp".$insert_id.".pdf";
                    //$mpdf->Output($_SERVER['DOCUMENT_ROOT'] . '/uploads/question_papper/'.$pdfFilePath, 'F');
                    //exit;
                   // $file=$_SERVER['DOCUMENT_ROOT'] . "/uploads/question_papper/".$pdfFilePath;
            $subject='Question Papper';
                        sleep(5);           
            $body="Dear all, 
                    Please find the attached file related to  Question Papper";
            $this->sendattachedemail($body,$faculty_email,$subject,$file,$pdfData);
             sleep(5);
            //echo 'HIIII0'.$insert_id;exit;
            $all_data = $this->Question_paper_model->get_qp_details($order_id);
            //echo 'HIIII0'.$insert_id;exit;
            for($k = 0; $k < count($all_data); $k++ ){ 
            //echo '<pre>';
            //echo $k;exit;
            //print_r($all_data[$k]);exit;
            $datanew['qp_id'] = $all_data[$k]['id'];
            $datanew['subject_id'] = $all_data[$k]['subject_id'];
            $datanew['stream_id'] = $all_data[$k]['stream_id'];
            $datanew['semester'] = $all_data[$k]['semester'];
            $datanew['course_id'] = $all_data[$k]['course_id'];
            $datanew['sesseion'] = $all_data[$k]['sesseion'];
            $datanew['last_date_of_submit'] = $all_data[$k]['last_date_of_submit'];
            $datanew['faculty_id'] = $all_data[$k]['faculty_id'];
            $datanew['duration'] = $all_data[$k]['duration'];
            $datanew['no_of_sets'] = $all_data[$k]['no_of_sets'];
            $datanew['updated_by'] = $this->session->userdata("uid");
            $datanew['updated_text'] = 'NEW ENTRY';
            $insert_idlog =$this->Question_paper_model->add_nem_qp_log($datanew);
            if($all_data[$k]['no_of_sets'] > 0){
             $i = 1;
              for($i ==1; $i <= $all_data[$k]['no_of_sets']; $i++ ){
                $doc_data['qp_id'] = $all_data[$k]['id'];
                $doc_data['created_by'] = $this->session->has_userdata('uid');
                $this->Question_paper_model->add_nem_qp_docs($doc_data);
              }

            
          }
      }

          }
          unset($data);
          unset($datanew);




        redirect('Question_paper'); 

        //$test=$this->db->insert('employee_monthly_final_attendance',$data1);
        //echo 1;exit;
    }


   public  function upload_docs($qp_id = ''){

        global $model;
        $this->load->model('Question_paper_model');
        $this->load->view('header', $this->data);
        $this->data['qp_data']= $this->Question_paper_model->get_qp_data($qp_id);
        $this->data['qp_data_docs']= $this->Question_paper_model->get_qp_data_docs($qp_id);
        $this->data['qp_check_lists']= $this->Question_paper_model->get_qp_check_list();

        //print_r($this->data['qp_data']['0']['no_of_sets']);exit;                        
        $this->load->view($this->view_dir . 'upload_docs', $this->data);
        
        $this->load->view('footer');
    }

    public function update_docDetails()
    {
            //echo '<pre>';
            //print_r($_POST);exit;
            $this->load->model('Question_paper_model');
            if(!empty($_FILES['scandoc']['name'])){
                $date = str_replace(" ","_",date('Y-m-d H-i-s'));
            foreach($_FILES['scandoc']['name'] as $key => $val){
               // echo $_FILES['scandoc']['name'][$key]->getClientName();exit;
                $_FILES['userFile']['name'] = $date.'_'.$_FILES['scandoc']['name'][$key];
                $_FILES['userFile']['type'] = $_FILES['scandoc']['type'][$key];
                $_FILES['userFile']['tmp_name'] = $_FILES['scandoc']['tmp_name'][$key];
                $_FILES['userFile']['error'] = $_FILES['scandoc']['error'][$key];
                $_FILES['userFile']['size'] = $_FILES['scandoc']['size'][$key];
                if($_FILES['scandoc']['name'][$key] != ''){
                $filenm=str_replace(" ","_",$_FILES['userFile']['name']);
                }
				 try{
                    $file_path = 'uploads/student_document/questionpaper/'.$filenm;
                    $result = $this->awssdk->uploadFile($this->bucket_name, $file_path, $_FILES['userFile']['tmp_name']);
                    $arr1[$key] = $filenm;
                }catch(Exception $e){
                    $arr1[$key] = "";    
                }
            }
        }
        //echo '<pre>';
        //echo json_encode($_POST['check_list']);exit;
        //print_r($_POST);
        //print_r($arr1);exit;
        $this->Question_paper_model->update_qp_sets_docs($_POST, $arr1); 
        $msg5='Qp sets updated  successfully..';
        $this->session->set_flashdata('msg5', $msg5);
        redirect('Question_paper');
       
    }

    public function update_qp_status(){
        //print_r($_POST);exit();
        $this->load->model('Question_paper_model');
        $result = $this->Question_paper_model->update_qp_status($_POST);
        //print_r($result);exit(); 
        //$msg5='QP  updated  successfully..';
        //$this->session->set_flashdata('msg5', $msg5);
        //redirect('Question_paper');
        echo  $result; 
    } 
    public function update_qp_comment(){
        //print_r($_POST);exit();
        $this->load->model('Question_paper_model');
        $result = $this->Question_paper_model->update_qp_comment($_POST);
        //print_r($result);exit(); 
        //$msg5='QP  updated  successfully..';
        //$this->session->set_flashdata('msg5', $msg5);
        //redirect('Question_paper');
        echo  $result; 
    }

    public function update_setter_qp_comment(){
        //print_r($_POST);exit();
        $this->load->model('Question_paper_model');
        $result = $this->Question_paper_model->update_setter_qp_comment($_POST);
        //print_r($result);exit(); 
        //$msg5='QP  updated  successfully..';
        //$this->session->set_flashdata('msg5', $msg5);
        //redirect('Question_paper');
        echo  $result; 
    }


   public function get_commulative_attendance_report() {
        
                    $sfdt= date('Y-m-d');
                    $stdt= date('Y-m-d');
                    $arr['acd_yer']='2022-23~WINTER';
                    $arr['sch_id']=$_REQUEST['ssch_id'];
                    $arr['curs']=$_REQUEST['scurs'];
                    $arr['strm']=$_REQUEST['sstrm'];
                    $arr['sem']=$_REQUEST['ssem'];
                    $arr['divis']=$_REQUEST['sdivis'];
                    $arr['fdt']=$_REQUEST['sfdt'];
                    $arr['tdt']=$_REQUEST['stdt'];
                    $arr['rtyp']=$_REQUEST['srtyp'];
                    $arr['attendance_date']=$sfdt;
                    $day = date('l', strtotime($sfdt)); 
                    $this->data['sdate'] = $sfdt;
                    $this->data['day'] = $day ;
                    $this->data['pdata']=$arr;
                    $this->data['timtab']= $this->Student_Attendance_model->get_commu_attendance_list($arr);
                    $this->data['exp']='Y';
                    $this->load->library('m_pdf');
                    $html = "<span style='color:red;'>Note:This is an autogenerated mail,Please dont reply for this mail.</span>";
                    $html = $this->load->view($this->view_dir.'ajax_student_att_commu_report_pdf',$this->data,true);
                    $pdfFilePath = "school_wise_attandance_report_".$sfdt.".pdf";
                    $mpdf=new mPDF('utf-8', 'A4', '10', '10', '10', '10', '10', '10');
                    $mpdf->autoScriptToLang = true;
                    $mpdf->baseScript = 1;  // Use values in classes/ucdn.php  1 = LATIN
                    $mpdf->autoVietnamese = true;
                    $mpdf->autoArabic = true;
                    $mpdf->autoLangToFont = true;
                    $mpdf->SetMargins(10,10,15);
                    $mpdf->SetDisplayMode('fullpage');                   
                    $html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');

                    $mpdf->WriteHTML($html);
                    $mpdf->Output($_SERVER['DOCUMENT_ROOT'] . '/uploads/payment/attendance/notmarkattendance/'.$pdfFilePath, 'F');
                    $file=$_SERVER['DOCUMENT_ROOT'] . "/uploads/payment/attendance/notmarkattendance/".$pdfFilePath;
                      $subject='Daily Attendance Report';
                        sleep(5);
                        $body="Dear all, 
                           Please find the attached file of Daily Attendance Report";
                        $this->sendattachedemail($body,$email='balasaheb.lengare@carrottech.in',$subject,$file);
                        sleep(5);
        // ob_end_flush(); 
    }




     public function sendattachedemail($body,$email,$subject,$file,$pdfData='')
    {
        $path=$_SERVER["DOCUMENT_ROOT"].'/application/third_party/';
        require_once($path.'PHPMailer/class.phpmailer.php');
        date_default_timezone_set('Asia/Kolkata');
        require_once(APPPATH."third_party/PHPMailer/PHPMailerAutoload.php");
        //echo $file; exit;
        //Create a new PHPMailer instance
        $mail = new PHPMailer;
        //Tell PHPMailer to use SMTP
        $mail->isSMTP();
        //Enable SMTP debugging
        // 0 = off (for production use)
        // 1 = client messages
        // 2 = client and server messages
        //$mail->SMTPDebug = 4;
        //Set the hostname of the mail server
        $mail->Host = 'smtp.gmail.com';
        //Set the SMTP port number - likely to be 25, 465 or 587
        $mail->Port = 465;
        //Whether to use SMTP authentication
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'ssl';
        //Username to use for SMTP authentication
		 $mail->Username = 'NoReply5@sandipuniversity.edu.in'; 
        
        //Password to use for SMTP authentication
        //$mail->Password = '123Indi@';
          $mail->Password = 'n2sdMk3*5bW78@9YZ6z0';
        //Set who the message is to be sent from


        $mail->setFrom('NoReply5@sandipuniversity.edu.in', 'SANDIP UNIVERSITY');
        //Set an alternative reply-to address
        //$mail->addReplyTo('replyto@example.com', 'First Last');
        //Set who the message is to be sent to
        //$mail->addAddress($email);
        $mail->AddAddress('balasaheb.lengare@carrottech.in', 'balasaheb');
        $mail->AddAddress('coe@sandipuniversity.edu.in', 'COE');


        //$mail->AddAddress('pramod.karole@sandipuniversity.edu.in', 'Pramod');
        //Set the subject line
        $mail->Subject = $subject;
        //Read an HTML message body from an external file, convert referenced images to embedded,
        //convert HTML into a basic plain-text alternative body
        //$mail->msgHTML(file_get_contents('contents.html'), __DIR__);
        //Replace the plain text body with one created manually

        $mail->Body = $body;


        $mail->AltBody = 'This is a plain-text message body';
        //Attach an image file
        //$mail->addAttachment('images/phpmailer_mini.png');
        
        $mail->addStringAttachment($pdfData, $file, 'base64', 'application/pdf');
        //send the message, check for errors
        if (!$mail->send()) {
             //echo 1 ; exit;
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
             //echo 11 ; exit;
            echo 'Message sent!';
        }
    }

    public function get_qp_report_details(){
        global $model;
        $this->load->model('Question_paper_model');
        $this->load->view('header', $this->data);
        $this->data['claim_datas']= $this->Question_paper_model->get_qp_report_details();
        

        //$result = $this->Question_paper_model->get_qp_report_details();

        //print_r($this->data['qp_data']['0']['no_of_sets']);exit;                        
        $this->load->view($this->view_dir . 'claim_list', $this->data);
        
        $this->load->view('footer');
    }


    function excel_qp_report(){
        $this->load->model('Question_paper_model');
        // $this->load->view('header', $this->data);
        $this->data['claim_datas']= $this->Question_paper_model->get_qp_report_details();                       
        $this->load->view($this->view_dir .'claim_list_report_excel', $this->data);
    }



}
?>