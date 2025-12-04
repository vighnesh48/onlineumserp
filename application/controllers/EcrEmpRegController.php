<?php
class EcrEmpRegController extends CI_Controller
{

    /////////////////////////////////////////////////// code by JP ////////////////////////////////////////////////


    public function __construct()
    {
        parent::__construct();
        $this->load->model('EcrRenumerationModel'); // Load the model
        $this->load->model('EcrEmpRegModel');
        $menu_name = $this->uri->segment(1);
        $this->data['my_privileges'] = $this->retrieve_privileges($menu_name);
		        $user_name = $this->session->userdata('name'); // this should be email
        // echo $user_name;
    
        // Store center_id in session if matching active entry exists

        $centerData = $this->EcrEmpRegModel->getCenterIdIfUserExists($user_name);

        if (!empty($centerData)) {
            $center_ids = array_column($centerData, 'center_id'); // extract only center_id values
            $this->session->set_userdata('center_ids', $center_ids);
        }
        $center_ids = $this->session->userdata('center_ids');


    }

    public function index()
    {
        $filters = [
            'exam_id' => $this->input->get('exam_id'),
            'center_id' => $this->input->get('center_id'),
            'ecr_role_id' => $this->input->get('ecr_role_id')
        ];
        //    print_r($filters);exit;
        $data['exam_sessions'] = $this->EcrEmpRegModel->getExamSessions();
        $data['exam_centers'] = $this->EcrEmpRegModel->getExamCenters();
        $data['ecr_roles'] = $this->EcrEmpRegModel->getEcrRoles();
        $data['schools'] = $this->EcrEmpRegModel->getSchools();

        $data['employees'] = $this->EcrEmpRegModel->getFilteredEmployees($filters);
        $this->load->view('header', $this->data);
        $this->load->view('Ecr/ecr_emp_reg_listing', $data);
        $this->load->view('footer', $this->data);

    }
    public function getEmployeeSuggestions()
    {
		// echo 'hii';exit;
        $query = $this->input->post('query');
        if ($query) {
            $employees = $this->EcrEmpRegModel->searchEmployeeByIdOrName($query);
            echo json_encode($employees);
        } else {
            echo json_encode([]);
        }
    }
    public function searchEmployee()
    {
        $employee_id = $this->input->post('employee_id');
        $data['employee_details'] = $this->EcrEmpRegModel->getEmployeeDetails($employee_id);
        echo json_encode($data['employee_details']);  // Return data as JSON for displaying in the form
    }

    public function searchEmployeeAjax()
    {
        // Get the search term and exam_id from the request
        $search_term = $this->input->post('search');
        $exam_id = $this->input->post('exam_id');

        // Validate input
        if (empty($search_term)) {
            echo json_encode([]);
            return;
        }

        // Search in the employee_master table for matching employee IDs or names
        $this->load->model('EmployeeModel');
        $employees = $this->EcrEmpRegModel->searchEmployees($search_term);

        // Format the data for Select2
        $results = [];
        foreach ($employees as $employee) {
            $results[] = [
                'employee_id' => $employee->employee_id,
                'name' => $employee->name
            ];
        }

        // Return the results as a JSON response
        echo json_encode($results);
    }


    public function addEcrEmployee()
    {
        // Get session data
        $role_id = $this->session->userdata('role_id');
        $user_id = $this->session->userdata('uid');

        //    print_r($_POST);exit;
        // Get form input data
        $exam_id = $this->input->post('exam_id');
        $center_id = $this->input->post('center_id');
        $school_id = $this->input->post('school_id');
        $ecr_role_id = $this->input->post('ecr_role_id');
        $emp_id = $this->input->post('employee_id');
        $name = $this->input->post('name');
        $email = $this->input->post('emal');
        $mobile = $this->input->post('mobile');
        $bank_name = $this->input->post('bank_name');
        $acc_no = $this->input->post('acc_no');
        $ifsc = $this->input->post('ifsc');
        $branch_name = $this->input->post('branch_name');

        // 1. Check if the combination of emp_id, exam_id, and ecr_role already exists in the database
		if(!empty($emp_id)){

			$exists = $this->EcrEmpRegModel->checkEmployeeExistence($emp_id, $exam_id);
			
			if ($exists) {
				// If entry exists, set a flash message and redirect
				$this->session->set_flashdata('error', 'Employee already exists.');
				redirect('EcrEmpRegController/index');
				return; // Stop further processing
			}
		}

        // 2. If role_id is 1 or 2, check if any record exists with the same exam_id and ecr_role_id (to avoid duplicates)

        //   print_r($ecr_role_id);exit;

        // if ($ecr_role_id == 1 || $ecr_role_id == 2) {
        //     $roleCheck = $this->EcrEmpRegModel->checkRoleExistence($exam_id, $ecr_role_id);
        //     if ($roleCheck) {
        //         // If record exists for role 1 or 2, do not allow insertion
        //         $this->session->set_flashdata('error', 'For This Role Entry Already Exist For This Exam.');
        //         redirect('EcrEmpRegController/index');
        //         return; // Stop further processing
        //     }
        // }
        // Auto-generate emp_id if role is 6 or 9
        if (in_array($ecr_role_id, [6, 9])) {
            $emp_id = $this->EcrEmpRegModel->generateEmployeeId($ecr_role_id);
        }
		// echo $emp_id;exit;
        // Prepare data to insert into ecr_emp_reg table
        $data = [
            'exam_id' => $exam_id,
            'center_id' => $center_id,
            'school_id' => $school_id,
            'ecr_role' => $ecr_role_id,
            'emp_id' => $emp_id,
            'name' => $name,
            'email' => $email,
            'mobile' => $mobile,
            'inserted_by' => $user_id, // Assuming logged-in user ID
        ];
        if (in_array($ecr_role_id, [6, 9])) {
            $employee_id = $this->EcrEmpRegModel->generateEmployeeId($ecr_role_id);
         //   echo $emp_id;exit;
            $data['emp_id'] = $employee_id;
            $data['bank_name'] = $bank_name;
            $data['acc_no'] = $acc_no;
            $data['ifsc'] = $ifsc;
            $data['branch_name'] = $branch_name;
        }
        //  print_r($data);exit;
        // Insert data into ecr_emp_reg table
        $this->EcrEmpRegModel->insertEcrEmployee($data);

        // If role_id is 15, insert into user_master table
        $Userdata = [
            'username' => $email,
            'password' => $mobile,  // Assuming password is mobile number
            'roles_id' => 25,
        ];
        if ($role_id == 15) {
            $this->EcrEmpRegModel->insertUserMaster($Userdata);
        }

        // Redirect to the employee registration index page
        redirect('EcrEmpRegController/index');

    }
	
    public function updateStatus()
    {
        $emp_id = $this->input->post('emp_id');
        $is_active = $this->input->post('is_active');
        $DB1 = $this->load->database('umsdb', TRUE);

        if ($emp_id !== null && $is_active !== null) {

            $DB1->where('emp_id', $emp_id);
            $updated = $DB1->update('ecr_emp_reg', ['is_active' => $is_active]);
    
            if ($updated) {
                echo json_encode(['success' => true]);
                return;
            }
        }
    
        echo json_encode(['success' => false]);
    }

    public function editEcrEmployee()
{
        $data = $this->input->post();

        // Validate input
        // $this->form_validation->set_rules('exam_id', 'Exam Session', 'required');
        // $this->form_validation->set_rules('center_id', 'Exam Center', 'required');
        // $this->form_validation->set_rules('school_id', 'School', 'required');
        // $this->form_validation->set_rules('ecr_role_id', 'ECR Role', 'required');

        // if ($this->form_validation->run() == false) {
        //     $this->session->set_flashdata('error', validation_errors());
        //     redirect('EcrEmpRegController/index');
        // } else {
        
        $updateData = [
            'exam_id' => $data['exam_id'],
            'center_id' => $data['center_id'],
            'school_id' => $data['school_id'],
            'ecr_role' => $data['ecr_role_id'],
            'emp_id' => $data['employee_id'],
            'email' => $data['emal'],
            'mobile' => $data['mobile']
        ];

        if (in_array($data['ecr_role_id'], [6, 9])) {
            $updateData['bank_name'] = $data['bank_name'];
            $updateData['acc_no'] = $data['acc_no'];
            $updateData['ifsc'] = $data['ifsc'];
            $updateData['branch_name'] = $data['branch_name'];
        }
        $DB1 = $this->load->database('umsdb', TRUE);
       $DB1->where('emp_id', $data['employee_id']);
       $DB1->update('ecr_emp_reg', $updateData);

     //  echo $DB1->last_query();exit;

        $this->session->set_flashdata('success', 'Employee updated successfully.');
        redirect('EcrEmpRegController/index');
//    }
}


    public function sendAppointmentOrder()
    {
        //    echo 'hii';exit;
        $emp_id = $this->input->post('emp_id');
        $to_email = $this->input->post('to_email');
        $exam_id = $this->input->post('exam_id');
        $role_id = $this->input->post('role_id');
        $center_id = $this->input->post('center_id');

        // Fetch employee details for email content
        $employee_data = $this->EcrEmpRegModel->getEmployeeData($emp_id, $exam_id); // Assume this function returns necessary employee data

        $DB1 = $this->load->database('umsdb', TRUE);

             $DB1->set('letter_sent', 1);
             $DB1->set('letter_sent_date', 'NOW()', false); // Use NOW() function for the current datetime
             $DB1->where(['emp_id' => $emp_id, 'exam_id' => $exam_id, 'role_id' => $role_id]);
             $DB1->update('duty_verification');
		$exam_details_time = $this->EcrEmpRegModel->getExamDetailsTime($exam_id);


        if ($employee_data && $to_email) {
            $this->sendAppointmentLetter($to_email, $employee_data,$exam_details_time, $center_id);
            echo json_encode(['message' => 'Appointment Order sent successfully.']);
        } else {
            echo json_encode(['message' => 'Failed to send Appointment Order. Employee data not found.']);
        }
    }
    private function sendAppointmentLetter($to_email, $employee_data,$exam_details_time, $center_id)
    {
        // Load PHPMailer and mPDF libraries
        $this->load->library('smtp');
        $this->load->library('phpmailer');
        $this->load->library('m_pdf');

        // Fetch additional employee details
        $additional_employees = $this->EcrEmpRegModel->getEmployeesByRoleAndExam($exam_details_time[0]['exam_id'], $center_id);
        $duiety_dates = $this->EcrEmpRegModel->getDuietyDates($employee_data);
        $ref_no = $this->EcrEmpRegModel->getNewRefNo($exam_details_time[0]['exam_id'], $employee_data['emp_id']);

        $new_ref_no = $ref_no['ref_no'];

        // Define logo URL before setting the header
        $logo_url = base_url('assets/images/SU_Logo-01.png');

        // Initialize mPDF with the specified margins
        $mpdf = new mPDF('L', 'A4', '', '', 15, 15, 35, 10, 5, 5);  // Increased top margin to fit the header

        $header = '
                    <div style="text-align: center; font-size: 16px; font-weight: bold; padding-top: 5px; margin-bottom: 15px;">
                                <table style="width: 100%; border: 1px solid black; border-collapse: collapse; font-size: 12px;">
                            <tr>
                                <td style="width: 20%; border: none; text-align: center;">
                                    <img src="' . base_url('assets/images/su-logo.png') . '" style="width: 80px; height: auto;">
                                </td>
                                <td style="width: 60%; border-left: 1px solid black;border-right: 1px solid black; text-align: center;">
                                    <div style="font-size: 24px; font-weight: bold;color: red;">Sandip University</div>
                                    <div style="font-size: 12px; color: #242424;">Mahiravani, Trimbak Road, Nashik - 422 213</div>
                                    <div style="font-weight: bold; font-size: 14px;">Office of the Controller of Examinations</div>
                                </td>
                                <td style="width: 20%; border: none; text-align: center;">
                                    <div style="font-size: 30px; font-weight: bold;">COE</div>
                                </td>
                            </tr>
                        </table>
                        <hr>
                    </div>
                ';
        // Set the header with logo and title
        $mpdf->SetHTMLHeader($header);

        // Set the footer with page numbering centered at the bottom
        $mpdf->SetHTMLFooter("<div style='text-align: center; font-size: 10px;'>Page {PAGENO} of {nbpg}</div>");

        // Generate the HTML content for the main body
        $html_content = $this->load->view('Ecr/appointment_letter_view', [
            'employee_data' => $employee_data,
            'additional_employees' => $additional_employees,
            'duiety_dates' => $duiety_dates,
            'new_ref_no' => $new_ref_no,
			'exam_details_time' => $exam_details_time  // pass the array here

        ], true);

        // Write the main content below the header
        $mpdf->WriteHTML($html_content);

        // Output the PDF as a string for attachment or direct output
        $pdf_content = $mpdf->Output('', 'S'); // 'S' option for string output

        // Send the PDF as an email attachment using PHPMailer
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'noreply11@sandipuniversity.edu.in'; // SMTP username
            $mail->Password = 'gqej udth gjpj nxvs'; // SMTP password, use an App Password if 2FA is enabled
            $mail->SMTPSecure = 'ssl'; // Enable SSL encryption
            $mail->Port = 465; // Set the SMTP port for the GMAIL server
            $mail->SMTPDebug = 2; // Debug level for detailed logs

            $mail->setFrom('noreply11@sandipuniversity.edu.in', 'Exam Management Team');
            $mail->addAddress($to_email);
            $mail->addAddress('erp.support@sandipuniversity.edu.in');
            $mail->isHTML(true);

            // Email content
            $mail->Subject = "Appointment Letter for ECR Role";
            $mail->Body = "
            <p>Dear " . $employee_data['name'] . ",</p>
            <p>We are pleased to inform you that you have been appointed as an ECR (Exam Center Role) at " . $employee_data['center_name'] . " for the upcoming exam session.</p>
            <p>Please find the details in the attached PDF.</p>
            <p>Best regards,<br/>Exam Management Team</p>
            ";

            // Attach the generated appointment letter PDF (as in-memory string)
            $mail->addStringAttachment($pdf_content, 'Appointment_Letter.pdf');

            // Attach the "CS - Examination Guidelines" PDF from the assets folder
            $examination_guidelines_pdf = FCPATH . 'assets/images/CS_Examination_Guidelines.pdf'; // Assuming the PDF is saved under assets/images
            if (file_exists($examination_guidelines_pdf)) {
                $mail->addAttachment($examination_guidelines_pdf, 'CS_Examination_Guidelines.pdf');
            } else {
                log_message('error', 'CS Examination Guidelines PDF not found in assets/images folder');
            }

            // Send the email
            if (!$mail->send()) {
                echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
                log_message('error', 'Failed to send appointment letter: ' . $mail->ErrorInfo);
            } else {
                echo 'Message has been sent';
                log_message('info', 'Appointment letter sent successfully to ' . $to_email);
            }
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            log_message('error', 'Exception error: ' . $e->getMessage());
        }
    }

    public function generateAppointmentOrder()
    {

        $emp_id = $this->input->get('emp_id') ?: $this->input->post('emp_id');
        $exam_id = $this->input->get('exam_id');
        $role_id = $this->input->get('role_id');
        $center_id = $this->input->get('center_id');
		
        // Load the umsdb database
        $DB1 = $this->load->database('umsdb', TRUE);

        // Fetch the current highest ref_no for the specific exam_id
        $DB1->select('ref_no')
            ->from('duty_verification')
            ->where('exam_id', $exam_id)
            ->order_by('ref_no', 'DESC')
            ->limit(1);
        $query = $DB1->get();
        $last_ref_no = $query->row();

        // Determine the next ref_no based on the result
        if ($last_ref_no) {
            // Increment the last reference number by 1
            $new_ref_no = str_pad((int) $last_ref_no->ref_no + 1, 3, '0', STR_PAD_LEFT);
        } else {
            // Start with '001' for a new exam_id
            $new_ref_no = '001';
        }

        // Update the duty_verification table with the is_verified, verified_date, and ref_no values
        $DB1->set('is_verified', 1);
        $DB1->set('verified_date', 'NOW()', false); // Use NOW() function for current datetime
        $DB1->set('ref_no', $new_ref_no);
        $DB1->where(['emp_id' => $emp_id, 'exam_id' => $exam_id, 'role_id' => $role_id]);
        $DB1->update('duty_verification'); 

        // Fetch employee details for the appointment letter
        $employee_data = $this->EcrEmpRegModel->getEmployeeData($emp_id, $exam_id); // Assume this function returns necessary employee data

         $exam_details_time = $this->EcrEmpRegModel->getExamDetailsTime($exam_id, $center_id);
       //  print_r($exam_details_time);exit;
        if ($employee_data) {
            $this->generateAppointmentLetter($employee_data, $new_ref_no, $exam_details_time, $center_id); // This will now handle PDF download
            //   exit;
        } else {
            echo json_encode(['message' => 'Failed to generate Appointment Order. Employee data not found.']);
        }

    }

    public function generateAppointmentLetter($employee_data, $new_ref_no, $exam_details_time, $center_id)
    {
        // Load necessary libraries
        $this->load->library('m_pdf');

        // Fetch additional employee details if necessary
        $additional_employees = $this->EcrEmpRegModel->getEmployeesByRoleAndExam($employee_data['exam_id'], $center_id);
        $duiety_dates = $this->EcrEmpRegModel->getDuietyDates($employee_data);

        // Define logo URL for header
        $logo_url = base_url('assets/images/SU_Logo-01.png');

        // Initialize mPDF for the appointment letter
        $mpdf = new mPDF('L', 'A4', '', '', 10, 10, 30, 15, 2, 1);

        // Set the header with logo and title
        $mpdf->SetHTMLHeader('
            <div style="text-align: center; font-size: 16px; font-weight: bold; padding-top: 0px; margin-bottom: 20px;">
                    <table style="width: 100%; border-collapse: collapse; font-size: 12px;">
                        <tr>
                            <td style="width: 20%; border: none; text-align: center;">
                                <img src="' . base_url('assets/images/su-logo.png') . '" style="width: 80px; height: auto;">
                            </td>
                            <td style="width: 60%; text-align: center;">
                                <div style="font-size: 24px; font-weight: bold;color: red;">Sandip University</div>
                                <div style="font-size: 12px; color: #242424;">Mahiravani, Trimbak Road, Nashik - 422 213</div>
                                <div style="font-weight: bold; font-size: 14px;">Office of the Controller of Examinations</div>
                            </td>
                            <td style="width: 20%; border: none; text-align: center;">
                                <div style="font-size: 30px; font-weight: bold;">COE</div>
                            </td>
                        </tr>
                    </table>
                    <hr>

                        
            </div>
        ');

        // Set the footer with page numbering
        $mpdf->SetHTMLFooter("<div style='text-align: center; font-size: 10px;'>Page {PAGENO} of {nbpg}</div>");

        // Load the main content for the PDF
         $html_content = $this->load->view('Ecr/appointment_letter_view', [
            'employee_data' => $employee_data,
            'additional_employees' => $additional_employees,
            'duiety_dates' => $duiety_dates,
            'new_ref_no' => $new_ref_no,
            'exam_details_time' => $exam_details_time  // pass the array here

        ], true);


        //   echo $html_content;exit;
        // Write the main content below the header
        $mpdf->WriteHTML($html_content);

        // Define the filename based on employee data
        $filename = "Appointment_order.pdf";

        // Output the generated PDF for direct download
        $mpdf->Output($filename, 'D'); // 'D' forces download

    }



    public function duetyAllocation()
    {
        // Fetch data for dropdowns
        $data['exam_sessions'] = $this->EcrEmpRegModel->getExamSessions();
        $data['sessions'] = $this->EcrEmpRegModel->getSessions();
        $data['duety_names'] = $this->EcrEmpRegModel->getEcrRoles();
        $data['exam_centers'] = $this->EcrEmpRegModel->getExamCenters();

        // Fetch the list of employees or other data you want to show in the list
        $filters = [

        ];
        $data['employees'] = $this->EcrEmpRegModel->getFilteredEmployees($filters);
        $this->load->view('header', $this->data);
        $this->load->view('Ecr/duety_allocation_view', $data);
        $this->load->view('footer', $this->data);

    }

    public function replace_employee()
    {
        // Fetch data for dropdowns
        $data['exam_sessions'] = $this->EcrEmpRegModel->getExamSessions();
        $data['sessions'] = $this->EcrEmpRegModel->getSessions();
        $data['duety_names'] = $this->EcrEmpRegModel->getEcrRoles();
        $data['exam_centers'] = $this->EcrEmpRegModel->getExamCenters();

        //    print_r($data['exam_centers']);exit;
        // Fetch the list of employees or other data you want to show in the list
        $filters = [

        ];
        $data['employees'] = $this->EcrEmpRegModel->getFilteredEmployees($filters);
        $this->load->view('header', $this->data);
        $this->load->view('Ecr/replace_employee', $data);
        $this->load->view('footer', $this->data);

    }
	public function getEmployeeSuggestionsForReplace()
    {
		// echo 'hii';exit;
        $query = $this->input->post('query');
        if ($query) {
            $employees = $this->EcrEmpRegModel->getEmployeeSuggestionsForReplace($query);
            echo json_encode($employees);
        } else {
            echo json_encode([]);
        }
    }
    public function duetyAllocationList_replace()
    {
        // Get the selected date and role from the form submission (GET request)

        $filter_date = $this->input->post('filter_date');
        $filter_role = $this->input->post('filter_role');
        $filter_exam = $this->input->post('filter_exam');
        $filter_center = $this->input->post('filter_center');
        $session = $this->input->post('session');

        if (!empty($filter_date) || !empty($filter_role)) {
        // Fetch the filtered duty allocations 
        $data['duty_allocations'] = $this->EcrEmpRegModel->getFilteredDutyAllocations($filter_date, $filter_role, $filter_exam, $filter_center, $session);
        }
        // Fetch all roles for the filter dropdown

        $data['filter_date'] = $filter_date;
        $data['filter_role'] = $filter_role;
        $data['filter_exam'] = $filter_exam;
        $data['filter_center'] = $filter_center;
        $data['ssn'] = $session;
        $data['roles'] = $this->EcrEmpRegModel->getEcrRoles();
        $data['exam_sessions'] = $this->EcrEmpRegModel->getExamSessions();
        $data['exam_centers'] = $this->EcrEmpRegModel->getExamCenters();


        $this->load->view('header', $this->data);
        $this->load->view('Ecr/replace_employee', $data);
        $this->load->view('footer', $this->data);
    }
    public function getBuildingsByCenter()
    {
        $center_id = $this->input->post('center_id');
        $buildings = $this->EcrEmpRegModel->getBuildingsByCenter($center_id);
        echo json_encode($buildings);
    }

    public function getFloorsByBuilding()
    {
        $building_id = $this->input->post('building_id');
        $floors = $this->EcrEmpRegModel->getFloorsByBuilding($building_id);

        echo json_encode($floors);



    }

    public function getHallsByFloor()
    {
        $building_id = $this->input->post('building_id');
        $floor = $this->input->post('floor');
        $halls = $this->EcrEmpRegModel->getHallsByFloor($building_id, $floor);
        echo json_encode($halls);
    }
    public function employee_hall_allocation()
    {
        // Get the selected date, role, and exam from the form submission (POST request)
        $filter_date = $this->input->post('filter_date');
        $filter_role = $this->input->post('filter_role');
        $filter_exam = $this->input->post('filter_exam');
		$session = $this->input->post('session');
		
        // Check if either role or exam is not selected
        if (empty($filter_role) || empty($filter_exam)) {
            // No role or exam selected, return an empty array for duty allocations
            $data['duty_allocations'] = [];
        } else {
            // Fetch the filtered duty allocations if both role and exam are selected
            $data['duty_allocations'] = $this->EcrEmpRegModel->getFilteredDutyAllocations_hall($filter_date, $filter_role, $filter_exam,$session);
        }

        // Pass the filter data and other data to the view
        $data['filter_date'] = $filter_date;
        $data['filter_role'] = $filter_role;
        $data['filter_exam'] = $filter_exam;
        $data['ssn'] = $session;

        // Fetch all roles, exam sessions, and centers for the filter dropdowns
        $data['roles'] = $this->EcrEmpRegModel->getAllEcrRoles();
        $data['exam_sessions'] = $this->EcrEmpRegModel->getExamSessions();
        $data['centers'] = $this->EcrEmpRegModel->getExamCenters();

        // Load the view
        $this->load->view('header', $this->data);
        $this->load->view('Ecr/employee_hall_allocation', $data);
        $this->load->view('footer', $this->data);
    }

    public function updateHallId()
    {
        $emp_id = $this->input->post('emp_id');
        $hall_id = $this->input->post('hall_id');
        $role_id = $this->input->post('role_id');
        $exam_id = $this->input->post('exam_id');
        $date = $this->input->post('date');
        $session = $this->input->post('session');
        
		//   echo $emp_id;
		
        //   echo $hall_id;exit;
		
       // print_r($_POST);exit;
		
        if ($emp_id && $hall_id) {
            $DB1 = $this->load->database('umsdb', TRUE);
            $DB1->where('emp_id', $emp_id);
            $DB1->where('duety_name', $role_id);
            $DB1->where('exam_id', $exam_id);
            $DB1->where('date', $date);
            $DB1->where('session', $session);
            $DB1->where('is_active', 1);
            $DB1->update('duety_allocation', ['hall_id' => $hall_id]);

            // echo $DB1->last_query();exit;
			
            // exit;
			
            if ($DB1->affected_rows() > 0) {
                echo json_encode(['status' => 'success', 'message' => 'Hall updated successfully']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to update hall']);
            }
        } else {
           $DB1 = $this->load->database('umsdb', TRUE);
            $DB1->where('emp_id', $emp_id);
            $DB1->where('duety_name', $role_id);
            $DB1->where('exam_id', $exam_id);
            $DB1->where('date', $date);
            $DB1->where('session', $session);
            $DB1->where('is_active', 1);
            $DB1->update('duety_allocation', ['hall_id' => '']);

            if ($DB1->affected_rows() > 0) {
                echo json_encode(['status' => 'success', 'message' => 'Hall Removed successfully']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to Removed hall']);
            }

        }
    }

public function duetyAllocationList_report()
{
    // Initialize variables for filters with default values (null or empty)
    $filter_date = $this->input->get('filter_date');
    $filter_role = $this->input->get('filter_role');
    $filter_exam = $this->input->get('filter_exam');
    $filter_center = $this->input->get('filter_center');
    $session = $this->input->get('session');

    // Initialize the duty_allocations data as empty
    $data['duty_allocations'] = [];

    // Check if POST data is available
    if (!empty($filter_date) || !empty($filter_role)) {
        // Fetch the filtered duty allocations only if POST data exists
        $data['duty_allocations'] = $this->EcrEmpRegModel->getFilteredDutyAllocations($filter_date, $filter_role, $filter_exam, $filter_center, $session);
    }

    // Fetch all roles, exam sessions, and exam centers for the filter dropdowns
    $data['roles'] = $this->EcrEmpRegModel->getAllEcrRoles();
    $data['exam_sessions'] = $this->EcrEmpRegModel->getExamSessions();
    $data['exam_centers'] = $this->EcrEmpRegModel->getExamCenters();

    // Load the views
    $this->load->view('header', $this->data);
    $this->load->view('Ecr/duety_allocation_report', $data);
    $this->load->view('footer', $this->data);
}

  /* 
   public function getEmployeesAndDatesByRole1()
    {
        //  print_r($_POST);exit;
        $exam_id = $this->input->post('exam_id');
        $role_id = $this->input->post('role_id');

        if ($exam_id && $role_id) {
            // Retrieve employees and dates for the specific exam_id and role_id
            $employees = $this->EcrEmpRegModel->getEmployeesByRole($role_id, $exam_id);
            $dates = $this->EcrEmpRegModel->getExamDatesBySession($exam_id);
            $allocations = $this->EcrEmpRegModel->getAllocations($exam_id, $role_id);

            //    print_r($allocations);exit;
            // Prepare data for AJAX response
            $response = [
                'employees' => $employees,
                'dates' => $dates,
                'allocations' => $allocations
            ];
            echo json_encode($response);
        } else {
            echo json_encode(['error' => 'Invalid exam or role selection.']);
        }
    }  

    */

    public function getEmployeesAndDatesByRole()
    {
        $exam_id = $this->input->post('exam_id');
        $role_id = $this->input->post('role_id');
        $center_id = $this->input->post('center_id');

        if ($exam_id && $role_id) {
            // Retrieve employees and dates
            $employees = $this->EcrEmpRegModel->getEmployeesByRole($role_id, $exam_id, $center_id);
            $dates = $this->EcrEmpRegModel->getExamDatesBySession($exam_id);
            $allocations = $this->EcrEmpRegModel->getAllocations($exam_id, $role_id, $center_id);
            $getEmployeesForVerification = $this->EcrEmpRegModel->isVerified($exam_id, $role_id);
            $getEmployeesForSentLetter = $this->EcrEmpRegModel->isLetterSent($exam_id, $role_id);
            //   print_r($allocations);exit;
            //    Include verification status in allocations
            //    foreach ($allocations as $emp_id => $dates_array) {
            //        foreach ($dates_array as $date => $sessions) {
            //          $is_verified = $this->EcrEmpRegModel->isVerified($emp_id, $exam_id, $role_id); // Check if allocation is verified
            //          $allocations['is_verified'] = $is_verified;
            //        }
            //    }
            //    print_r($allocations[$emp_id][$date]['is_verified']);exit;

            $response = [
                'employees' => $employees,
                'dates' => $dates,
                'allocations' => $allocations,
                'verified_emp' => $getEmployeesForVerification,
                'sent_letter' => $getEmployeesForSentLetter
            ];
            echo json_encode($response);
        } else {
            echo json_encode(['error' => 'Invalid exam or role selection.']);
        }
    }

    public function insertOrDeleteAllocation()
    {

        // print_r($_POST);exit;
        
        $emp_id = $this->input->post('emp_id');
        $date = $this->input->post('date');
        $session = $this->input->post('session');
        $duety_name = $this->input->post('duety_name');
        $exam_id = $this->input->post('exam_id');
        $is_checked = $this->input->post('is_checked');
        
        $DB1 = $this->load->database('umsdb', TRUE);
        
        // Check if the allocation already exists
        
        $existing_allocation = $DB1->where('emp_id', $emp_id)
            ->where('role_id', $duety_name)
            ->where('exam_id', $exam_id)
            ->where('emp_id', $emp_id)
            ->get('duty_verification')
            ->row();
       // echo $DB1->last_query();exit;
            // print_r($duety_name);exit;
        
        if (!$existing_allocation) {

            $DB1->insert('duty_verification', [
                'emp_id' => $emp_id,
                'role_id' => $duety_name,
                'exam_id' => $exam_id
            ]);
        
            // echo $DB1->last_query();exit;
        
        }

        if ($is_checked == 'true') {
        
            $existing_duty_allocation = $DB1->where('emp_id', $emp_id)
        
            ->where('date', $date)
            ->where('session', $session)
            ->where('duety_name', $duety_name)
            ->where('exam_id', $exam_id)
            ->get('duety_allocation')
            ->row();

            if (!$existing_duty_allocation) {
                
                $DB1->insert('duety_allocation', [
                    'emp_id' => $emp_id,
                    'date' => $date,
                    'session' => $session,
                    'duety_name' => $duety_name,
                    'exam_id' => $exam_id
                ]);

               // echo $DB1->last_query();exit;

            }else{ 
            
                $DB1->where('emp_id', $emp_id)
                ->where('date', $date)
                ->where('session', $session)
                ->where('duety_name', $duety_name)
                ->where('exam_id', $exam_id)
                ->update('duety_allocation', ['is_active' => 1]);
            
            }
           
        } else {

            // Delete if unchecked
            $DB1->where('emp_id', $emp_id)
            ->where('date', $date)
            ->where('duety_name', $duety_name)
            ->where('exam_id', $exam_id)
            ->where_in('session', $session)
            ->update('duety_allocation', ['is_active' => 0]);

        }
        
        echo json_encode(['status' => 'success']);
    }


    public function getExamDatesBySession()
    {
        $exam_id = $this->input->post('exam_id');  // Get exam_id from AJAX request

        // Fetch available dates for the selected exam session
        $dates = $this->EcrEmpRegModel->getExamDatesBySession($exam_id);

        // Return dates as a JSON response
        echo json_encode($dates);
    }

    public function submitDuetyAllocation2()
    {

        $selected_rows = $this->input->post('selected_rows');

        if (!empty($selected_rows)) {
            foreach ($selected_rows as $emp_id => $data) {
                foreach ($data as $date => $sessions) {
                    $session_value = is_array($sessions) ? implode(',', $sessions) : $sessions;  // Handle multiple sessions

                    $data = [
                        'emp_id' => $emp_id,
                        'date' => $date,
                        'session' => $session_value,
                        'duety_name' => $this->input->post('duety_name'),
                        'exam_id' => $this->input->post('exam_id')
                    ];
                    //   print_r($data);exit;
                    $this->EcrEmpRegModel->insertAllocation($data);
                }
            }
        }
        redirect('EcrEmpRegController/duetyAllocation');
    }

    public function submitDuetyAllocation()
    {
        $selected_rows = $this->input->post('selected_rows');

        if (!empty($selected_rows)) {
            foreach ($selected_rows as $emp_id => $data) {
                foreach ($data as $date => $sessions) {
                    // Check for each session individually
                    if (in_array("AN", $sessions)) {
                        $this->EcrEmpRegModel->insertOrDeleteAllocation($emp_id, $date, 'AN', $this->input->post('duety_name'), $this->input->post('exam_id'), $this->input->post('center_id'));
                    }
                    if (in_array("FN", $sessions)) {
                        $this->EcrEmpRegModel->insertOrDeleteAllocation($emp_id, $date, 'FN', $this->input->post('duety_name'), $this->input->post('exam_id'), $this->input->post('center_id'));
                    }
                }
            }
        }
        redirect('EcrEmpRegController/duetyAllocation');
    }


    public function duetyAllocationList()
    {
        // Get the selected date and role from the form submission (POST request)
        $filter_date = $this->input->post('filter_date');
        $filter_role = $this->input->post('filter_role');
        $filter_exam = $this->input->post('filter_exam');
        $filter_center = $this->input->post('filter_center');
        $session = $this->input->post('session');

        // Check if role or exam is not selected, and if so, return an empty table
        if (empty($filter_role) || empty($filter_exam)) {
            // No filter applied, so pass an empty array for duty allocations
            $data['duty_allocations'] = [];
        } else {
            // Fetch the filtered duty allocations if both role and exam are selected
            $data['duty_allocations'] = $this->EcrEmpRegModel->getFilteredDutyAllocations($filter_date, $filter_role, $filter_exam, $filter_center, $session);
        }

        // Pass the filters and other data to the view
        $data['filter_date'] = $filter_date;
        $data['filter_role'] = $filter_role;
        $data['filter_exam'] = $filter_exam;
        $data['filter_center'] = $filter_center;
        $data['ssn'] = $session;
       // print_r($data);exit;

        // Fetch all roles for the filter dropdown
        $data['roles'] = $this->EcrEmpRegModel->getEcrRoles();
        $data['exam_sessions'] = $this->EcrEmpRegModel->getExamSessions();
        $data['exam_centers'] = $this->EcrEmpRegModel->getExamCenters();

        // Load the view
        $this->load->view('header', $this->data);
        $this->load->view('Ecr/duety_allocation_list', $data);
        $this->load->view('footer', $this->data);
    }


    public function updateAttendance()
    {
        // Get selected attendance IDs and statuses from the form
        $attendance_ids = $this->input->post('attendance_ids');
        $attendance_ida = $this->input->post('attendance_ida');

        //   print_r($attendance_ida);
        /*   $attendance = array_merge(
               array_map(function($id) { return ['id' => $id, 'attendance' => 'P']; }, array_keys($attendance_ids ?? [])),
               array_map(function($id) { return ['id' => $id, 'attendance' => 'A']; }, array_keys($attendance_ida ?? []))
           ); */

        //  exit;
        // Retrieve the previously selected filters
        $filter_date = $this->input->post('filter_date');
        $filter_role = $this->input->post('filter_role');
        $filter_exam = $this->input->post('filter_exam');
        $filter_center = $this->input->post('filter_center');

        // Update attendance based on the submitted values
        $this->EcrEmpRegModel->markAttendance($attendance_ida);

        // Redirect back to the list after updating, passing the filters as query parameters
        redirect('EcrEmpRegController/duetyAllocationList?filter_date=' . $filter_date . '&filter_role=' . $filter_role . '&filter_exam=' . $filter_exam . '&filter_center=' . $filter_center);
    }

    public function searchEmployeeFromEcr()
    {
        $employee_id = $this->input->post('employee_id');
        $exam_id = $this->input->post('exam_id');
        $data['employee_details'] = $this->EcrEmpRegModel->getEmployeeDetailsFromEcr($employee_id, $exam_id);
        echo json_encode($data['employee_details']);  // Return data as JSON for displaying in the form
    }

    public function replaceEmployee1()
    {
        $user_id = $this->session->userdata('uid');
        $allocation_id = $this->input->post('allocation_id');
        $replace_employee_id = $this->input->post('employee_id');
        $filter_exam = $this->input->post('filter_exam');
        $filter_date = $this->input->post('filter_date');
        $filter_role = $this->input->post('filter_role');

        if (!empty($allocation_id) && !empty($replace_employee_id)) {
            // Update duety_allocation table
            $data = [
                'replace_emp_id' => $replace_employee_id,
                'is_replaced' => 1,
                'updated_by' => $user_id,  // Assuming logged-in user ID
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            $this->EcrEmpRegModel->updateAllocation($allocation_id, $data);
        }

        // Redirect back to the list after replacement
        redirect('EcrEmpRegController/duetyAllocationList_replace?filter_date=' . $filter_date . '&filter_role=' . $filter_role . '&filter_exam=' . $filter_exam);
    }
    public function replaceEmployee()
    {
        $user_id = $this->session->userdata('uid');
        $allocation_id = $this->input->post('allocation_id');
        $replace_employee_id = $this->input->post('employee_id');
        $filter_exam = $this->input->post('filter_exam');
        $filter_date = $this->input->post('filter_date');
        $filter_role = $this->input->post('filter_role');

        if (!empty($allocation_id) && !empty($replace_employee_id)) {

            //   echo '00000';exit;

            // Fetch the current role of the employee being replaced
            $current_allocation = $this->EcrEmpRegModel->getAllocationById($filter_role, $filter_exam, $allocation_id);


            $current_role_id = $current_allocation->duety_name;
            // print_r($current_role_id);exit;
            // Fetch the role of the replacement employee
            $replacement_employee = $this->EcrEmpRegModel->getEmployeeById($replace_employee_id);

            //    print_r($replacement_employee);exit;    
            if (!$replacement_employee) {

                //  echo '2222';exit;
                $this->session->set_flashdata('error', 'Replacement employee not found.');
                redirect('EcrEmpRegController/duetyAllocationList_replace?filter_date=' . $filter_date . '&filter_role=' . $filter_role . '&filter_exam=' . $filter_exam);
                return;

            }
            $replacement_role_id = $replacement_employee->ecr_role;

            // Check if the roles match
            if ($current_role_id != $replacement_role_id) {
                //    echo '3333';exit;
                $this->session->set_flashdata('error', 'Replacement employee must have the same role as the current employee.');
                redirect('EcrEmpRegController/duetyAllocationList_replace?filter_date=' . $filter_date . '&filter_role=' . $filter_role . '&filter_exam=' . $filter_exam);
                return;
            }

            // Proceed with replacement if roles match

            $data = [

                'replace_emp_id' => $replace_employee_id,
                'is_replaced' => 1,
                'updated_by' => $user_id,
                'updated_at' => date('Y-m-d H:i:s'),

            ];

            $this->EcrEmpRegModel->updateAllocation($allocation_id, $data);

            $this->session->set_flashdata('success', 'Employee replaced successfully.');
        } else {
            $this->session->set_flashdata('error', 'Invalid input for employee replacement.');
        }

        // Redirect back to the list after replacement
        redirect('EcrEmpRegController/duetyAllocationList_replace?filter_date=' . $filter_date . '&filter_role=' . $filter_role . '&filter_exam=' . $filter_exam);
    }
    /////////////////////////////////////////////////// end ////////////////////////////////////////////////

    public function generateDutyListPDF()
    {
        // Replace "null" string with actual null values
        $examId = $this->input->post('examId');
        $roleId = $this->input->post('roleId');
        $date = $this->input->post('date');
        $centerId = $this->input->post('centerId');
		
		$center_data = $this->EcrEmpRegModel->getExamCentersById($centerId);
        $this->data['center'] = $center_data['center_name'];

		
        $session = $this->input->post('session');
        $this->data['current_date'] = $date;
        $this->data['current_session'] = $session;
        // Load mPDF library
        $this->load->library('m_pdf');
        ini_set("memory_limit", "-1");
    
        // Initialize mPDF
        $mpdf = new mPDF('L', 'A4', '', '', 5, 5, 35, 15, 5, 5);
    
        // Register Bookman Old Style Font
        $mpdf->fontdata['bookman-old-style'] = [
            'R' => 'bookman-old-style.ttf',  // Regular
            'B' => 'bookman-old-style-bold.ttf', // Bold
            'I' => 'bookman-old-style-italic.ttf', // Italic
            'BI' => 'bookman-old-style-bolditalic.ttf' // Bold Italic
        ];
        $mpdf->default_font = 'bookman-old-style'; // Set default font
    
        $headerHTML = '
        <table style="width: 100%; border: 1px solid black; border-collapse: collapse; font-size: 12px;">
            <tr>
                <td style="width: 20%; border: none; text-align: center;">
                    <img src="' . base_url('assets/images/su-logo.png') . '" style="width: 80px; height: auto;">
                </td>
                <td style="width: 60%; border-left: 1px solid black;border-right: 1px solid black; text-align: center;">
                    <div style="font-size: 24px; font-weight: bold;color: red;">Sandip University</div>
                    <div style="font-size: 12px; color: #242424;">Mahiravani, Trimbak Road, Nashik - 422 213</div>
                    <div style="font-weight: bold; font-size: 14px;">Office of the Controller of Examinations</div>
                </td>
                <td style="width: 20%; border: none; text-align: center;">
                    <div style="font-size: 30px; font-weight: bold;">COE</div>
                </td>
            </tr>
        </table>
        <hr>';
    
        // Fetch duty list data
        $this->data['duty_list'] = $this->EcrEmpRegModel->getFilteredDutyAllocations_report($date, $roleId, $examId, $centerId, $session);
		// echo '<pre>';
	    // print_r($this->data['duty_list']);exit;
        $ttl = ($roleId == '') ? '' : $this->data['duty_list'][0]['role_name'];
        $this->data['title'] = $ttl . "Session Wise Duty List";
    
        // Check if there is data to display
        if (empty($this->data['duty_list'])) {
            echo "No records found for the selected filters.";
            return;
        }
    
        // Set Footer
        $footer = '
        <table width="100%" style="margin-top: 50px; font-size: 12px; border: none;">
            <tr>
                <td style="text-align: right; font-size: 12px; border: none;">
                   <b> Chief Superintendent </b>
                </td>
            </tr>
        </table>
        <div style="text-align: center; font-size: 10px;">
            Page {PAGENO} of {nbpg}
        </div>';
    
        $mpdf->SetHTMLHeader($headerHTML);
        $mpdf->SetHTMLFooter($footer);
    
        // Load the HTML view
        $html1 = $this->load->view('Ecr/duty_list_pdf', $this->data, true);
    
        // Apply "Bookman Old Style" font
        $mpdf->SetTitle($ttl . "Session Wise Duty List");
        $mpdf->WriteHTML($html1);
    
        // Output the PDF
        $mpdf->Output($ttl . "Session Wise Duty List " . date('Y-m-d') . ".pdf", "D");
    }
    

    public function generateDutyListDateWisePDF()
    {
        // Replace "null" string with actual null values
        $examId = $this->input->post('examId');
        $roleId = $this->input->post('roleId');
        $date = $this->input->post('date');
        $centerId = $this->input->post('centerId');
		 $center_data = $this->EcrEmpRegModel->getExamCentersById($centerId);
        
       //  print_r($center_data);exit;
        $this->data['center'] = $center_data['center_name'];


        // Load mPDF library
        $this->load->library('m_pdf');
        ini_set("memory_limit", "-1");
        $logo_url = base_url('assets/images/SU_Logo-01.png');

        $this->m_pdf->pdf = new mPDF('', 'A4', '', '', 15, 15, 50, 30, 15, 15);

        $this->m_pdf->pdf->SetHTMLHeader("
        <div style='text-align: center; font-size: 16px; font-weight: bold; padding-top: 5px; margin-bottom: 10px;'>
            <img src='$logo_url' alt='University Logo' style='width: 30%; height: auto; margin-bottom: 5px; display: block; margin: 0 auto;'>
            <p>Office of the Controller of Examinations</p>
            <hr>
            </br>
        </div>
    ");
        // Fetch duty list data
        $this->data['duty_list'] = $this->EcrEmpRegModel->getFilteredDutyAllocations_report($date, $roleId, $examId, $centerId);
        $ttl = ($roleId == '') ? '' : $this->data['duty_list'][0]['role_name'];

        $this->data['title'] = $ttl . " Duty List";
        //   $exam_session = $this->EcrEmpRegModel->getExamName($examId);
        //   $this->data['exam_name'] = $exam_session[0]['exam_name'];

        // print_r($this->data['duty_list']); die;

        if (empty($this->data['duty_list'])) {
            echo "No records found for the selected filters.";
            return;
        }
        // Set the footer with "Controller of Examinations" text and page numbers
        $footer = '
        <table width="100%" style="margin-top: 50px; font-size: 12px; border: none;">
            <tr>
                <td style="text-align: right; font-size: 12px; border: none;">
                   <b> Chief Superintendent </b>
                </td>
            </tr>
        </table>
        <div style="text-align: center; font-size: 10px;">
            Page {PAGENO} of {nbpg}
        </div>
    ';
        $this->m_pdf->pdf->SetHTMLFooter($footer);
        // Load the HTML view
        // $html1 = $this->load->view('Ecr/duty_list_pdf', $this->data, true);
        $html1 = $this->load->view('Ecr/duty_list_pdf_date_wise', $this->data, true);

        // Initialize mPDF
        $this->m_pdf->pdf->SetTitle($ttl . " Duty List");
        $this->m_pdf->pdf->WriteHTML($html1);

        // Output the PDF
        $this->m_pdf->pdf->Output($ttl . " Duty List " . date('Y-m-d') . ".pdf", "D");
    }

    public function generateDateWiseFacultyPDF()
    {
        // Load mPDF library
        $this->load->library('m_pdf');
        ini_set("memory_limit", "-1");
        $mpdf = new mPDF('L', 'A4', '', '', 5, 5, 35, 15, 5, 5);

        // Register Bookman Old Style Font
        $mpdf->fontdata['bookman-old-style'] = [
            'R' => 'bookman-old-style.ttf',  // Regular
            'B' => 'bookman-old-style-bold.ttf', // Bold
            'I' => 'bookman-old-style-italic.ttf', // Italic
            'BI' => 'bookman-old-style-bolditalic.ttf' // Bold Italic
        ];
        $mpdf->default_font = 'bookman-old-style'; // Set default font
    
        $headerHTML = '
        <table style="width: 100%; border: 1px solid black; border-collapse: collapse; font-size: 12px;">
            <tr>
                <td style="width: 20%; border: none; text-align: center;">
                    <img src="' . base_url('assets/images/su-logo.png') . '" style="width: 80px; height: auto;">
                </td>
                <td style="width: 60%; border-left: 1px solid black;border-right: 1px solid black; text-align: center;">
                    <div style="font-size: 24px; font-weight: bold;color: red;">Sandip University</div>
                    <div style="font-size: 12px; color: #242424;">Mahiravani, Trimbak Road, Nashik - 422 213</div>
                    <div style="font-weight: bold; font-size: 14px;">Office of the Controller of Examinations</div>
                </td>
                <td style="width: 20%; border: none; text-align: center;">
                    <div style="font-size: 30px; font-weight: bold;">COE</div>
                </td>
            </tr>
        </table>
        <hr>';


        // Set the footer with "Controller of Examinations" text and page numbers
        $footer = '
        <table width="100%" style="margin-top: 50px; font-size: 12px; border: none;">
            <tr>
                <td style="text-align: right; font-size: 12px; border: none;">
                   <b> Chief Superintendent </b>
                </td>
            </tr>
        </table>
        <div style="text-align: center; font-size: 10px;">
            Page {PAGENO} of {nbpg}
        </div>
    ';
        $mpdf->SetHTMLFooter($footer);
        $mpdf->SetHTMLHeader($headerHTML);

        // Fetch duty list data
        $examId = $this->input->post('examId');
        $date = $this->input->post('date');
        $roleId = $this->input->post('roleId');
        $centerId = $this->input->post('centerId');
		 $center_data = $this->EcrEmpRegModel->getExamCentersById($centerId);
        
       //  print_r($center_data);exit;
        $this->data['center'] = $center_data['center_name'];

        $this->data['duty_list'] = $this->EcrEmpRegModel->getDateWiseFaculty($date, $examId, $roleId, $centerId);

        $role = $this->EcrEmpRegModel->getRoleName($roleId);

        //    print_r($role['role_name']);exit;

        $ttl = ($roleId == '') ? '' : $role['role_name'];
        // Set PDF title
        $mpdf->SetTitle($ttl . " Faculty List");

        // Check if data is available
        if (empty($this->data['duty_list'])) {
            echo "No records found for the selected filters.";
            return;
        }

        $exam_session = $this->EcrEmpRegModel->getExamName($examId);
        // print_r($exam_session['exam_name']);exit;
        // Generate HTML content for each date and session
        foreach ($this->data['duty_list'] as $date => $sessions) {

            foreach ($sessions as $session => $facultyList) {

                // Load each date-session content from view as HTML
                $this->data['title'] = $ttl . ' Faculty List';
                $this->data['exam_session'] = $exam_session['exam_name'];
                $this->data['current_date'] = $date;
                $this->data['current_session'] = $session;
                $this->data['faculty_list'] = $facultyList;

                // Load the view and generate HTML
                $html = $this->load->view('Ecr/faculty_list_date_wise', $this->data, true);

                // Only write HTML to PDF if there is content
                if (trim($html) !== '') {
                    // Write HTML to PDF
                    $mpdf->AddPage();
                    $mpdf->WriteHTML($html);
                }

            }

        }

        // Output the PDF
        $mpdf->Output($ttl . " Duty List " . date('Y-m-d') . ".pdf", "D");
    }

}

?>