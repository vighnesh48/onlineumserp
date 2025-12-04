<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Cia_exam_session extends CI_Controller
{
    var $currentModule = "";
    var $title = "";
    var $table_name = "cia_exam_session";
    var $model_name = "Cia_examsession_model";
    var $model;
    var $view_dir = 'Cia_exam_session/';
    var $data = array();
    public function __construct()
    {
        global $menudata;
        parent::__construct();
        date_default_timezone_set('Asia/Kolkata');
        $this->load->helper("url");
        $this->load->library('form_validation');
        $this->load->library("session");
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

    public function index()
    {
        $this->load->view('header', $this->data);
        $this->data['cia_exam_session_details'] = $this->Cia_examsession_model->get_cia_exam_session_details();
        // echo "<pre>";
        // print_r($this->data['cia_exam_session_details']);exit;

        $this->load->view($this->view_dir . 'view', $this->data);
        $this->load->view('footer');
    }

    public function add()
    {

        $this->data['ac_sessions'] = $this->Cia_examsession_model->get_academic_session();
      //  print_r($this->data['ac_sessions']);exit;
        $this->load->view('header', $this->data);
        $this->load->view($this->view_dir . 'add', $this->data);
        $this->load->view('footer');
    }

    public function view()
    {
        $this->load->view('header', $this->data);
        $this->data['cia_exam_session_details'] = $this->Cia_examsession_model->get_cia_exam_session_details();
        $this->load->view($this->view_dir . 'view', $this->data);
        $this->load->view('footer');
    }

    public function edit($id)
    {
        // error_reporting(E_ALL);
        $this->load->view('header', $this->data);
        $id = $this->uri->segment(3);
        $this->data['cia_exam_session'] = ($this->Cia_examsession_model->get_cia_exam_session_details($id));
        // print_r($this->data['exam_session']->exam_id);
        $this->data['ses_details'] = $this->Cia_examsession_model->get_ex_ses_details($id);
        // echo "<pre>";		
        // print_r($this->data['ses_details']);exit;
        $this->load->view($this->view_dir . 'edit', $this->data);
        $this->load->view('footer');
    }

    public function disable()
    {
        $this->load->view('header', $this->data);
        $id = $this->uri->segment(3);
        $update_array = array("is_active" => "N");
        $secondDB = $this->load->database('umsdb', TRUE);
        $where = array("cia_exam_id" => $id);
        $secondDB->where($where);

        if ($secondDB->update($this->table_name, $update_array)) {
            redirect(base_url($this->view_dir . "view?error=0"));
        } else {
            redirect(base_url($this->view_dir . "view?error=1"));
        }
        $this->load->view('footer');
    }

    public function enable()
    {
        $this->load->view('header', $this->data);
        $id = $this->uri->segment(3);
        $update_array = array("is_active" => "Y");
        $where = array("cia_exam_id" => $id);
        $secondDB = $this->load->database('umsdb', TRUE);

        $secondDB->where($where);

        if ($secondDB->update($this->table_name, $update_array)) {
            redirect(base_url($this->view_dir . "view?error=0"));
        } else {
            redirect(base_url($this->view_dir . "view?error=1"));
        }
        $this->load->view('footer');
    }



    public function disableactive_for_cia_exam()
    {
        $this->load->view('header', $this->data);
        $id = $this->uri->segment(3);
        $update_array = array("active_for_exam" => "N");
        $secondDB = $this->load->database('umsdb', TRUE);
        $where = array("cia_exam_id" => $id);
        //  print_r($where);exit;

        $secondDB->where($where);

        if ($secondDB->update($this->table_name, $update_array)) {
            redirect(base_url($this->view_dir . "view?error=0"));
        } else {
            redirect(base_url($this->view_dir . "view?error=1"));
        }
        $this->load->view('footer');
    }

    public function enableactive_for_cia_exam()
    {
		
        $this->load->view('header', $this->data);
        $id = $this->uri->segment(3);
        $update_array = array("active_for_exam" => "Y");
        // print_r($update_array);exit;                               
        $where = array("cia_exam_id" => $id);
        //  print_r($where);exit;
        $secondDB = $this->load->database('umsdb', TRUE);

        $secondDB->where($where);

        if ($secondDB->update($this->table_name, $update_array)) {
			//echo $secondDB->last_query();exit;
            redirect($this->view_dir . "view?error=0");
        } else {
            redirect($this->view_dir . "view?error=1");
        }
        $this->load->view('footer');
    }


    public function submit()
    {
        //error_reporting(E_ALL);

        $this->load->helper('security');

        $post_array = $this->input->post();

        //echo "<pre>"; print_r($post_array); die;

        $config = array(
            array(
                'field' => 'cia_exam_type',
                'label' => 'Exam type',
                'rules' => 'trim|required|xss_clean'
            )
        );

        //print_r($this->input->post()); die; 

        $this->form_validation->set_rules($config);

        $exam_id = $this->input->post('cia_exam_id');

        if ($exam_id == "") {

            if ($this->form_validation->run() == FALSE) {
                $this->load->view('header', $this->data);
                $this->load->view($this->view_dir . 'add', $this->data);
                $this->load->view('footer');
            } else {
                //check for already_exits


                $insert_array = $this->input->post();
                $doesnot_exists = $this->Cia_examsession_model->check_already_exists($insert_array);
                if ($doesnot_exists) {
                    $insert_array['academic_year'] = $this->input->post('academic_year');
                    $insert_array['ac_session'] = $this->input->post('ac_session');
                    unset($insert_array['cia_exam_id']);
                    $insert_array['is_active'] = 'Y';
                    $insert_array['max_marks'] = $this->input->post('max_marks');
                    // print_r($insert_array);exit;
                    $last_inserted_id = $this->Cia_examsession_model->add_cia_exam_session_details($insert_array);
                    if ($last_inserted_id) {
                        redirect(base_url($this->view_dir . "view?error=0"));
                    } else {
                        redirect(base_url($this->view_dir . 'view?error=1'));
                    }
                } else {
                    $this->session->set_flashdata('message', 'Data already exists of these type');
                    $this->load->view('header', $this->data);
                    $this->load->view($this->view_dir . 'add', $this->data);
                    $this->load->view('footer');
                }
            }
        } else {

            $this->load->view('header', $this->data);
            $this->load->view($this->view_dir . 'add', $this->data);
            $this->load->view('footer');

        }
    }

    public function search()
    {
        $para = $this->input->post("title");
        $state_details = $this->state_model->get_state_details($para);
        echo json_encode(array("state_details" => $state_details));
    }
    public function update_cia_exam_dates()
    {
        error_reporting(E_ALL);
        $this->load->helper('security');
        $post_array = $this->input->post();
        //echo "<pre>"; print_r($post_array); die;
        $config = array(
            array(
                'field' => 'cia_start_date',
                'label' => 'cia start date',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'cia_end_date',
                'label' => 'cia end date',
                'rules' => 'trim|required|xss_clean'
            )
        );
        //print_r($this->input->post()); die; 
        $this->form_validation->set_rules($config);
        $exam_id = $this->input->post('cia_exam_id');



        if ($this->form_validation->run() == FALSE) {
            $this->load->view('header', $this->data);
            $this->load->view($this->view_dir . 'edit', $this->data);
            $this->load->view('footer');
        } else {
            //check for already_exits


            $insert_array1 = $this->input->post();
            $doesnot_exists = $this->Cia_examsession_model->check_already_exists_dates($insert_array1);
            //print_r($doesnot_exists);exit;
            if (empty($doesnot_exists)) {
                //echo "inside1";exit;
                $insert_array['cia_exam_id'] = $this->input->post('exam_id');
                $insert_array['start_date'] = $this->input->post('cia_start_date');
                $insert_array['end_date'] = $this->input->post('cia_end_date');
                $insert_array['create_date'] = date('Y-m-d H:i:s');
                $insert_array['created_by'] = $this->session->userdata('um_id');
                $insert_array['status'] = 'Y';
                $last_inserted_id = $this->Cia_examsession_model->add_cia_exam_session_details_dates($insert_array);
                if ($last_inserted_id) {
                    redirect(base_url($this->view_dir . "view?error=0"));
                } else {
                    redirect(base_url($this->view_dir . 'view?error=1'));
                }
            } else {
                //echo "outside";exit;
                $update_array['cia_exam_id'] = $this->input->post('cia_exam_id');
                $update_array['start_date'] = $this->input->post('cia_start_date');
                $update_array['end_date'] = $this->input->post('cia_end_date');
                $update_array['update_date'] = date('Y-m-d H:i:s');
                $update_array['updated_by'] = $this->session->userdata('um_id');
                // echo "<pre>"; print_r($update_array); die;
                $last_inserted_id = $this->Cia_examsession_model->update_cia_exam_session_details_dates($update_array);
                // echo $last_inserted_id;exit;
                $this->session->set_flashdata('message', 'Data updated successfully');
                redirect(base_url($this->view_dir . "view?error=0"));
            }
        }
    }


}
?>