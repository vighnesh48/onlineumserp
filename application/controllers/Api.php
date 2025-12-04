<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Kolkata');
		$this->load->Model('Admin_model');
		$this->load->Model('leave_model');
		$this->load->library('Awssdk');
    }
		
		
	 public function fetch_user_universal_id(){
            //$data = $this->input->post();
			$data = json_decode($this->input->raw_input_stream, true);
            $adhar_no = $data['adhar_no'];
            $res = $this->Admin_model->fetch_user_universal_id($adhar_no);

            if($res){
              $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode([
                          'status' => 'success',
                          'data' => $res
                        ]));
              return;
            }

            $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode([
                          'status' => 'error',
                          'message' => 'No data found'
                        ]));
            return;
          }
	
		

	  public function fetch_employee_attendance()
	{

    // Decode the incoming JSON request
    $data = json_decode($this->input->raw_input_stream, true);

    // Validate required parameters
      if (empty($data['attend_date']) || empty($data['empid'])) {
    $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode([
            'status' => 'error',
            'message' => 'Required parameters missing'
        ]));
    return;
  } 
		$attend_date = $data['attend_date'];
		$empid = $data['empid'];
	   // $check=$this->leave_model->fetch_emp_for_sutrack($empid);
		

		 /*  if(empty($check)){
            $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => 'error',
                'message' => 'Employee Id Not Found!!'
            ]));
        return;      	  
		} */  
      $db=$data['db'];
    // Check if attendance is available in the punching backup table
    $attendance_available = $this->Admin_model->checkAvailableAttendance_forSutrack($attend_date,$db);

    // Check if attendance is available in the punching backup table
    //$attendance_available = $this->Admin_model->checkAvailableAttendance($attend_date);

     if (empty($attendance_available)) {
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => 'error',
                'message' => 'Attendance not found for this month'
            ]));
        return;
    } 

    // Fetch attendance data for the given employee ID and date

    $attendance = $this->Admin_model->getAttendanceForAllSchool_forSutrack($empid, $attend_date,$db);
	
    if (!empty($attendance)) {
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => 'success',
                'message' => 'Attendance data fetched successfully',
                'data' => $attendance
            ]));
    } else {
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => 'error',
                'message' => 'No attendance data found for the given employee'
            ]));
        }
    }
	

 public function fetch_employee_leaves()
	{
		

    // Decode the incoming JSON request
    $data = json_decode($this->input->raw_input_stream, true);

    // Validate required parameters
     if (empty($data['empid'])) {
    $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode([
            'status' => 'error',
            'message' => 'Required parameters missing'
        ]));
    return;
  }

       $empid = $data['empid'];
       $db = $data['db'];
	   /* $check=$this->leave_model->fetch_emp_for_sutrack($empid);

		  if(empty($check)){
            $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => 'error',
                'message' => 'Employee Id Not Found!!'
            ]));
          return;      	  
		} */ 
    
     $leaves_data = $this->Admin_model->check_employee_leaves($empid,$db);
	 if (is_array($leaves_data) && !empty($leaves_data)) {
			// Add a new row for 'LWP' leave type
			$leaves_data[] = [
				'leave_type' => 'LWP',
				'leaves_allocated' => 0,
				'leave_used' => 0,
			];
		} else {
			// If no data is returned, initialize with a single 'LWP' leave type row
			$leaves_data = [
				[
					'leave_type' => 'LWP',
					'leaves_allocated' => 0,
					'leave_used' => 0,
				],
			];
		}
    if (!empty($leaves_data)) {
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => 'success',
                'message' => 'Leaves data fetched successfully',
                'data' => $leaves_data
            ]));
    } else {
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => 'error',
                'message' => 'No Leaves data found for the given employee'
            ]));
        }
    }
	
	public function fetch_campus()
	{
       $campus_list = $this->Admin_model->getpayrollBycampus();

    if (!empty($campus_list)) {
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => 'success',
                'message' => 'Campus data fetched successfully',
                'data' => $campus_list
            ]));
    } else {
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => 'error',
                'message' => 'No data found'
            ]));
        }
	}
	
	public function fetch_school()
	{
		
		  $data = json_decode($this->input->raw_input_stream, true);
    // Validate required fields
    if (empty($data['campus_id'])) {
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => 'error',
                'message' => 'Required parameters are missing'
            ]));
        return;
    }
       $school_list = $this->Admin_model->getAllschool($data['campus_id']);

    if (!empty($school_list)) {
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => 'success',
                'message' => 'School data fetched successfully',
                'data' => $school_list
            ]));
    } else {
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => 'error',
                'message' => 'No data found'
            ]));
        }
	}

	public function fetch_departments()
	{
		
		  $data = json_decode($this->input->raw_input_stream, true);
    // Validate required fields
    if (empty($data['school_id']) ) {
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => 'error',
                'message' => 'Required parameters are missing'
            ]));
        return;
    }
       $department_list = $this->Admin_model->getdepartmentByschool($data['school_id']);

    if (!empty($department_list)) {
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => 'success',
                'message' => 'Department data fetched successfully',
                'data' => $department_list
            ]));
    } else {
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => 'error',
                'message' => 'No data found'
            ]));
        }
	}
	
	public function fetch_school_deptwise_employees()
	{
		
		  $data = json_decode($this->input->raw_input_stream, true);
    // Validate required fields
    if (empty($data['campus_id']) ||empty($data['school_id']) ||empty($data['department_id'])  ) {
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => 'error',
                'message' => 'Required parameters are missing'
            ]));
        return;
    }
       $emp_list=$this->Admin_model->getSchoolDepartmentWiseEmployeeList($data['school_id'],$data['department_id'],'','',$data['campus_id']);

    if (!empty($emp_list)) {
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => 'success',
                'message' => 'School-deptwise Employees data fetched successfully',
                'data' => $emp_list
            ]));
    } else {
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => 'error',
                'message' => 'No data found'
            ]));
        }
	}
	

	
	public function insert_punching_log_data()
{

    // Decode incoming JSON request
    $data = json_decode($this->input->raw_input_stream, true);

    // Validate required fields
    if (empty($data['DeviceLogId']) || empty($data['DeviceId']) || empty($data['UserId']) || empty($data['LogDate'])) {
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => 'error',
                'message' => 'Required parameters are missing'
            ]));
        return;
    }

    // Prepare data for insertion
    $insert_data = [
        'DeviceLogId' => $data['DeviceLogId'],
        'DeviceId' => $data['DeviceId'],
        'UserId' => $data['UserId'],
        'LogDate' => $data['LogDate'] // Optional: Add a timestamp
    ];

  $db=$data['db'];
   /*  $check=$this->leave_model->fetch_emp_for_sutrack($data['UserId']);
       $insert_id='';
 
		  if(empty($check)){
            $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => 'error',
                'message' => 'Employee Id Not Found!!'
            ]));
        return;      	  
		}else{ */
  
			$insert_id = $this->Admin_model->insert_punching_log_data($insert_data,$db);
			$punch_count = $this->Admin_model->fetch_punching_log_data_count($insert_data,$db);
		//}

			if ($insert_id) {
				$this->output
					->set_content_type('application/json')
					->set_output(json_encode([
						'status' => 'success',
						'message' => 'Data inserted successfully',
						'insert_id' => $insert_id,
						'punch_count' => $punch_count
					]));
			} else {
				$this->output
					->set_content_type('application/json')
					->set_output(json_encode([
						'status' => 'error',
						'message' => 'Failed to insert data'
					]));
			  }
		  }



                            public function apply_leave() 
                   {
                       
                          //$data =json_decode(file_get_contents('php://input'), true);
                          $data =$this->input->post();
						  
						    $file = $_FILES['medical_cert'];
							$data['medical_cert']= '';
							if (isset($_FILES['medical_cert']) && !empty($_FILES['medical_cert']['name'])) {
							if(!empty($file['name'])){
							$od_certff=clean(trim($file['name']));
							$dname = explode(".", $file['name']);
							$ext = end($dname);
							$file_od='ML_'.$data['emp_id'].'_'.date('Ymdhis').'.'.$ext;

							try{
							$bucket_name = 'humanresourcemanagement';
							$file_path = 'uploads/employee_documents/'.$file_od;
							$src_file = $file['tmp_name'];
							$result = $this->awssdk->uploadFile($bucket_name, $file_path, $src_file);
							$data['medical_cert']= $file_od;
							}catch(Exception $e){
							$data['medical_cert']= '';
							}
						}
					}
					     $empid = $data['emp_id'];
					     $db = $data['db'];
			
					  /*  $check=$this->leave_model->fetch_emp_for_sutrack($empid);


						  if(empty($check)){
							$this->output
							->set_content_type('application/json')
							->set_output(json_encode([
								'status' => 'error',
								'message' => 'Employee Id Not Found!!'
							]));
						return;      	  
						} */
					           
            
						$res=$this->leave_model->api_sutrack_addEmpLeave($data,$db);
                          
						if($res>=1){
							
							$lst = $this->leave_model->update_used_leaves_forSuTrack($data['emp_id'],$data['leave_type'],'Pending',$data['no_days'],$data['leave_duration'],$this->config->item('current_year2'),$db);
						 $this->output
											->set_content_type('application/json')
											->set_output(json_encode([
											'status' => 'success',
											'message' => 'Your Leave Application Has been submitted...'
											]));
						return;

						}else{
						if($res=='lexd'){
						$this->output
											->set_content_type('application/json')
											->set_output(json_encode([
											'status' => 'error',
											'message' => 'CL leave is exceed for this month.'
											]));
						return;
						}elseif($res=='lAD'){

						$this->output
											->set_content_type('application/json')
											->set_output(json_encode([
											'status' => 'error',
											'message' => 'Leave/OD already applied on this date.'
											]));
						return;
						}elseif($res=='NOTREP'){
								   $this->output
										->set_content_type('application/json')
										->set_output(json_encode([
										'status' => 'error',
										'message' => 'Your Reporting/Leave is not Assigned. Please contact to Admin Dept.'
										]));
									  return;
								}elseif($res=='NOTLEAVE'){
								   $this->output
										->set_content_type('application/json')
										->set_output(json_encode([
										'status' => 'error',
										'message' => 'Already Used ALL Assigned leaves.'
										]));
									  return;
								}else{

						         $this->output
											->set_content_type('application/json')
											->set_output(json_encode([
											'status' => 'error',
											'message' => 'Something Went Wrong !!!.'
											]));
						    return;
                        }
                      }
                  } 
                  
            public function apply_OD() 
             {
                $data = $this->input->post();
                $file = $_FILES['od_cert'];
 
               if(!empty($file['name'])){
                $od_certff=clean(trim($file['name']));
                $dname = explode(".", $file['name']);
                $ext = end($dname);
                $file_od='OD_'.$data['emp_id'].'_'.date('Ymdhis').'.'.$ext;
                
                try{
                    $bucket_name = 'humanresourcemanagement';
                    $file_path = 'uploads/employee_documents/'.$file_od;
                    $src_file = $file['tmp_name'];
                    $result = $this->awssdk->uploadFile($bucket_name, $file_path, $src_file);
                    $data['od_cert']= $file_od;
                }catch(Exception $e){
                    $data['od_cert']= '';
                 }
              }
			  
			      $empid = $data['emp_id'];
			      $db = $data['db'];
			
					   /* $check=$this->leave_model->fetch_emp_for_sutrack($empid);


						  if(empty($check)){
							$this->output
							->set_content_type('application/json')
							->set_output(json_encode([
								'status' => 'error',
								'message' => 'Employee Id Not Found!!'
							]));
						return;      	  
						} */
            
					$res=$this->leave_model->api_sutrack_addEmpOD($data,$db);

					 if($res>=1){
					$this->output
									->set_content_type('application/json')
									->set_output(json_encode([
									'status' => 'success',
									'message' => 'Your OD Application Has been submitted...'
									]));
					return;

					}else{
					 if($res=='NOTREP'){
					   $this->output
									->set_content_type('application/json')
									->set_output(json_encode([
									'status' => 'error',
									'message' => 'Your Reporting/Leave is not Assigned. Please contact to Admin Dept.'
									]));
					return;
					}elseif($res=='LAD'){
				   $this->output
						->set_content_type('application/json')
						->set_output(json_encode([
						'status' => 'error',
						'message' => 'Leave/OD already applied on this date.'
						]));
                      return;
				}else{

					$this->output
									->set_content_type('application/json')
									->set_output(json_encode([
									'status' => 'error',
									'message' => 'Something Went Wrong !!!.'
									]));
					return;
					}
                 } 
            }
			
	public function fetch_state()
	{
       $states = $this->Admin_model->getAllState();

    if (!empty($states)) {
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => 'success',
                'message' => 'status data fetched successfully',
                'data' => $states
            ]));
    } else {
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => 'error',
                'message' => 'No data found'
            ]));
        }
	}
	
	public function fetch_cities()
	{
		
	   $data = json_decode($this->input->raw_input_stream, true);
  
    if (empty($data['state_id'])) {
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => 'error',
                'message' => 'Required parameters are missing'
            ]));
        return;
    }
       $city_list = $this->Admin_model->getStateCity($data['state_id']);

    if (!empty($city_list)) {
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => 'success',
                'message' => 'City data fetched successfully',
                'data' => $city_list
            ]));
    } else {
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => 'error',
                'message' => 'No data found'
            ]));
        }
	}

     public function fetch_employee_applied_leaves(){
            $data =json_decode(file_get_contents('php://input'), true);

            if(empty($data)){
              $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode([
                          'status' => 'error',
                          'message' => 'Required data is missing'
                        ]));
              return;
            }
            $empid = $data['empid'];
            $db = $data['db'];
			
           /* $check=$this->leave_model->fetch_emp_for_sutrack($empid);


			  if(empty($check)){
				$this->output
				->set_content_type('application/json')
				->set_output(json_encode([
					'status' => 'error',
					'message' => 'Employee Id Not Found!!'
				]));
			return;      	  
			} */
            $res = $this->leave_model->fetch_employee_applied_leaves($empid,$db);

            if(!empty($res)){
              $this->output
                        ->set_content_type('application/json')  
                        ->set_output(json_encode([
                          'status' => 'success',
                          'data' => $res
                        ]));
              return;
            }

            $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode([
                          'status' => 'error',
                          'message' => 'No data found'

                        ]));
            return;
        }

        public function fetch_employee_applied_OD(){
            $data =json_decode(file_get_contents('php://input'), true);

            if(empty($data)){
              $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode([
                          'status' => 'error',
                          'message' => 'Required data is missing'
                        ]));
              return;
            }
			
             $empid = $data['empid'];
             $db = $data['db'];
			
			 /* $check=$this->leave_model->fetch_emp_for_sutrack($empid);


			  if(empty($check)){
				$this->output
				->set_content_type('application/json')
				->set_output(json_encode([
					'status' => 'error',
					'message' => 'Employee Id Not Found!!'
				]));
			return;      	  
			} */

            $res = $this->leave_model->fetch_employee_applied_OD($empid,$db);

            if(!empty($res)){
              $this->output
                        ->set_content_type('application/json')  
                        ->set_output(json_encode([
                          'status' => 'success',
                          'data' => $res
                        ]));
              return;
            }

            $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode([
                          'status' => 'error',
                          'message' => 'No data found'

                        ]));
            return;
        }

    
   
   
 public function send_student_attendance_pdf_by_id()
{
    $this->load->model('Attendance_model');
    $this->load->library('M_pdf');

 /*   $from_date = $this->input->post('from_date');
    $to_date = $this->input->post('to_date');*/
	$from_date = '2025-03-01'; 
    $to_date = '2025-03-31'; 
    $tdydate = date('Y-m-d');
    $student_id = $this->input->post('student_id');
	$student_id = 5254;
    if (empty($student_id)) {
        echo "Student ID not provided.";
        return;
    }

    $student = $this->Attendance_model->get_student_by_id($student_id);
		// print_r($student);exit;
    if (empty($student)) {
        echo "Student not found.";
        return;
    }

    $streamID = $student['admission_stream'];
    $semester = $student['current_semester'];
    $division = $student['division'];
    $academic_year = $student['academic_year'];
    $batch = $student['batch'];
    $enrollment_no = $student['enrollment_no'];
    $parent_email = isset($student['parent_email']) ? trim($student['parent_email']) : '';
	$email = isset($student['s_email']) ? trim($student['s_email']) : '';
    if (empty($email)) {
        echo "No parent email found for the student.";
        return;
    }

    $this->data['attendance_data'] = $this->Attendance_model->get_student_attendance_for_parent_cron(
        $streamID,
        $semester,
        $division,
        $academic_year,
        $from_date,
        $to_date,
        $student_id,
        $batch
    );
  // echo "<pre>"; print_r($this->data['attendance_data']);exit;
    $this->data['from_date'] = $from_date;
    $this->data['to_date'] = $to_date;
    $this->data['student_id'] = $student_id;
    $this->data['enrollment_no'] = $enrollment_no;

    $html = $this->load->view('Attendance/parent_letter', $this->data, true);
    $this->m_pdf->pdf = new mPDF('utf-8', 'A4', '10', '10', '10', '10', '10', '10');
    $this->m_pdf->pdf->WriteHTML($html);
    $pdfData = $this->m_pdf->pdf->Output('', "I"); 

    $file = 'Attendance_Report_' . $enrollment_no . '_' . $tdydate . '.pdf';
    $subject = 'Lecture Attendance Report';
    $body = "Dear Parent/Student,<br><br>Please find attached the attendance report.<br><br>Regards,<br>Sandip University";

    // Replace with $parent_email in production
    $this->sendattachedemail($body, 'hemant.kolte@sandipuniversity.edu.in', $subject, $file, $pdfData);

    echo "Attendance PDF sent successfully.";
}
	
}
