<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\IOFactory;

class OnlineApplicationForms extends CI_Controller 
{
    var $currentModule="";
    var $title="";
    var $table_name="online_payment";
    var $model_name="Onlineapplicationforms_model";
    var $model;
    var $view_dir='OnlineApplicationForm/';
    var $data=array();
    public function __construct() 
    {
        global $menudata;

        parent:: __construct();
        
        $this->load->model('Onlineapplicationforms_model');
        
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
         $this->load->model('Ums_admission_model');
        $menu_name=$this->uri->segment(1);        
        $this->data['my_privileges']=$this->retrieve_privileges($menu_name);
    }
    
    public function index()
    {   
        $filter_application_type = $this->input->get('filter_application_type');
        
        $this->load->view('header',$this->data);        
      // print_r($filter_application_type);exit;

        $this->data['applications']= $this->Onlineapplicationforms_model->getApplications($filter_application_type);
      //  $this->data['application_forms'] = $this->OnlineApplicationForms_model->get_application_formss();
        $this->data['application_forms'] = $this->Onlineapplicationforms_model->get_application_forms();
      //  print_r($this->data['application_forms']);exit;
		
        $this->load->view($this->view_dir.'view',$this->data);
        $this->load->view('footer');
    }

    public function sendConfirmationMail() {
       
        $enrollment_no = $this->input->post('enrollment_no');
        $to_email = $this->input->post('to_email');
       // $to_email = 'hemant.kolte@sandipuniversity.edu.in';
        $table_name = $this->input->post('table_name');
        $txtid = $this->input->post('txtid');
        $certificateId = $this->input->post('certificateId');
        
        $student_data = $this->Onlineapplicationforms_model->getStudentData($txtid);
        // print_r($student_data);exit;
        if ($student_data && $to_email) { 
           // echo "hii";exit;
            $this->sendConfirmationMailLetter($to_email, $student_data);
            $this->Onlineapplicationforms_model->updateApplicationStatus($txtid);
            echo json_encode(['message' => 'Confirmation Mail sent successfully.']);
        } else {
            echo json_encode(['message' => 'Failed to send Confirmation Mail. ']);
        }
    }

    public function sendCollectionMail() {
     
        $enrollment_no = $this->input->post('enrollment_no');
        $to_email = $this->input->post('to_email');
       // $to_email = 'hemant.kolte@sandipuniversity.edu.in';

        $table_name = $this->input->post('table_name');
        $txtid = $this->input->post('txtid');
        
        $student_data = $this->Onlineapplicationforms_model->getStudentData($txtid);
        
        if ($student_data && $to_email) { 
           
            $this->sendCollectionMailLetter($to_email, $student_data);
            $this->Onlineapplicationforms_model->updateApplicationSubmitStatus($txtid);
            echo json_encode(['message' => 'Collection Mail sent successfully.']);
        } else {
            echo json_encode(['message' => 'Failed to send Confirmation Mail. ']);
        }
    }


    private function sendConfirmationMailLetter($to_email, $student_data) {
        // echo "hiii";exit;
        $this->load->library('smtp');
        $this->load->library('phpmailer');
        $mail = new PHPMailer(true);
    
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'noreply6@sandipuniversity.edu.in';
            $mail->Password = 'mztvpmklamlhjtac';
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;
    
            $mail->setFrom('noreply6@sandipuniversity.edu.in', 'Student Section Team');
            $mail->addAddress($to_email);
            $mail->isHTML(true);
    
            $mail->Subject = "Confirmation for Application Form";
            $mail->Body = "
            <html>
            <head>
                <style>
                    body {
                        font-family: 'Arial', sans-serif;
                        background-color: #f9f9f9;
                        margin: 0;
                        padding: 0;
                    }
                    .email-container {
                        background-color: #ffffff;
                        max-width: 600px;
                        margin: 30px auto;
                        padding: 20px;
                        border-radius: 8px;
                        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
                    }
                    .email-header {
                        background-color: #FF5733;
                        color: #fff;
                        padding: 15px;
                        text-align: center;
                        border-radius: 8px 8px 0 0;
                    }
                    .email-content {
                        padding: 20px;
                        font-size: 14px;
                        color: #333;
                    }
                    .email-content h3 {
                        font-size: 16px;
                        color: #FF5733;
                    }
                    .email-content ul {
                        list-style-type: none;
                        padding-left: 0;
                    }
                    .email-content li {
                        padding: 5px 0;
                    }
                    .email-content a {
                        color: #FF5733;
                        text-decoration: none;
                    }
                    .email-footer {
                        background-color: #f1f1f1;
                        color: #888;
                        padding: 10px;
                        text-align: center;
                        font-size: 12px;
                        border-radius: 0 0 8px 8px;
                    }
                    .email-footer p {
                        margin: 0;
                    }
                    .btn {
                        display: inline-block;
                        padding: 10px 20px;
                        background-color: #FF5733;
                        color: white;
                        text-decoration: none;
                        border-radius: 5px;
                        font-size: 14px;
                        margin-top: 20px;
                        text-align: center;
                    }
                    .btn:hover {
                        background-color: #e74c3c;
                    }
                </style>
            </head>
            <body>
                <div class='email-container'>
                    <div class='email-header'>
                        <h2>Application Confirmation</h2>
                    </div>
                    <div class='email-content'>
                        <p>Dear {$student_data['firstname']},</p>
                        <p>Thank you for submitting your <strong>{$student_data['table_name']}</strong> application at CoE Office.</p>

                        <h3>Application Details:</h3>
                        <ul>
                            <li><strong>Enrollment No:</strong> {$student_data['registration_no']}</li>
                            <li><strong>Mobile:</strong> {$student_data['phone']}</li>
                            <li><strong>Email:</strong> {$student_data['email']}</li>
                        </ul>

                        <p>If you have any questions, feel free to <a href='mailto:support@sandipuniversity.edu.in'>contact us</a>.</p>
                        
                        <a href='http://sandipuniversity.edu.in' class='btn'>Visit Sandip University</a>
                    </div>
                    <div class='email-footer'>
                        <p>&copy; 2025 Sandip University | All Rights Reserved</p>
                    </div>
                </div>
            </body>
            </html>
        ";


              // echo $mail->Body;exit;

            if ($mail->send()) {
                log_message('info', 'Confirmation Mail sent successfully to ' . $to_email);
                return true;
            } else {
                log_message('error', 'Failed to send Confirmation Mail: ' . $mail->ErrorInfo);
                return false;
            }
    
        } catch (Exception $e) {
            log_message('error', 'Exception error: ' . $e->getMessage());
            return false;
        }
    }

    private function sendCollectionMailLetter($to_email, $student_data) {
        // echo "hiii";exit;
        $this->load->library('smtp');
        $this->load->library('phpmailer');
        $mail = new PHPMailer(true);
    
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'noreply6@sandipuniversity.edu.in';
            $mail->Password = 'mztvpmklamlhjtac';
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;
    
            $mail->setFrom('noreply6@sandipuniversity.edu.in', 'Student Section Team');
            $mail->addAddress($to_email);
            $mail->isHTML(true);
    
            $mail->Subject = "Collection of Certificate";
          
            $mail->Body = "
            <html>
            <head>
                <style>
                    body {
                        font-family: 'Arial', sans-serif;
                        background-color: #f9f9f9;
                        margin: 0;
                        padding: 0;
                    }
                    .email-container {
                        background-color: #ffffff;
                        max-width: 600px;
                        margin: 30px auto;
                        padding: 20px;
                        border-radius: 8px;
                        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
                    }
                    .email-header {
                        background-color: rgb(156, 30, 16); /* Red color */
                        color: #fff;
                        padding: 15px;
                        text-align: center;
                        border-radius: 8px 8px 0 0;
                    }
                    .email-content {
                        padding: 20px;
                        font-size: 14px;
                        color: #333;
                    }
                    .email-content h3 {
                        font-size: 16px;
                        color: rgb(156, 30, 16); /* Red color */
                    }
                    .email-content ul {
                        list-style-type: none;
                        padding-left: 0;
                    }
                    .email-content li {
                        padding: 5px 0;
                    }
                    .email-content a {
                        color: rgb(156, 30, 16); /* Red color */
                        text-decoration: none;
                    }
                    .email-footer {
                        background-color: #f1f1f1;
                        color: #888;
                        padding: 10px;
                        text-align: center;
                        font-size: 12px;
                        border-radius: 0 0 8px 8px;
                    }
                    .email-footer p {
                        margin: 0;
                    }
                    .btn {
                        display: inline-block;
                        padding: 10px 20px;
                        background-color: rgb(156, 30, 16); /* Red color */
                        color: white;
                        text-decoration: none;
                        border-radius: 5px;
                        font-size: 14px;
                        margin-top: 20px;
                        text-align: center;
                    }
                    .btn:hover {
                        background-color: #9c1e10; /* Darker red shade for hover */
                    }
                </style>
            </head>
            <body>
                <div class='email-container'>
                    <div class='email-header'>
                        <h2>Certificate Available for Collection</h2>
                    </div>
                    <div class='email-content'>
                        <p>Dear {$student_data['firstname']},</p>
                        <p>We are pleased to inform you that your <strong>{$student_data['table_name']}</strong> certificate is now available. Please collect it from the Student Section.</p>

                        <h3>Details:</h3>
                        <ul>
                            <li><strong>Enrollment No:</strong> {$student_data['registration_no']}</li>
                            <li><strong>Mobile:</strong> {$student_data['phone']}</li>
                            <li><strong>Email:</strong> {$student_data['email']}</li>
                        </ul>

                        <p>If you have any questions, feel free to <a href='mailto:support@sandipuniversity.edu.in'>contact us</a>.</p>
                        
                        <a href='http://sandipuniversity.edu.in' class='btn'>Visit Sandip University</a>
                    </div>
                    <div class='email-footer'>
                        <p>&copy; 2025 Sandip University | All Rights Reserved</p>
                    </div>
                </div>
            </body>
            </html>
        ";
              // echo $mail->Body;exit;

            if ($mail->send()) {
                log_message('info', 'Collection Mail sent successfully to ' . $to_email);
                return true;
            } else {
                log_message('error', 'Failed to send Collection Mail: ' . $mail->ErrorInfo);
                return false;
            }
    
        } catch (Exception $e) {
            log_message('error', 'Exception error: ' . $e->getMessage());
            return false;
        }
    }


    


	//////////////////////////////
}
	
?>
