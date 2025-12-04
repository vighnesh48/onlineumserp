<?php header("Access-Control-Allow-Origin: *");
defined('BASEPATH') OR exit('No direct script access allowed');
class Login extends CI_Controller 
{
    function __construct()
    {        
        parent::__construct();                     
        $this->load->model('login_model');
		$this->load->model('Certificate_model');
    }
    public function index_new()
    {
		$this->load->view('maintenance_mode');
	}
    public function index()
    {
		//$this->output->enable_profiler(TRUE);
		 $this->load->helper("url");		
	     $data['utype'] = $this->uri->segment(3);
		
		
		
        $data['msg'] = '';	
        if($this->security->xss_clean($this->input->post('role_id')==4)){
             $data['login_user'] = 'Student';
        }
       else if($this->security->xss_clean($this->input->post('role_id')==9)){
             $data['login_user'] = 'Parent';
        }
        else
        {
             $data['login_user'] = 'Staff';
        }

        if($this->input->post('submit'))
        {
			//echo $var;
			//exit(0);
			 //print_r($this->input->post());die;
             $recaptchaResponse = $this->input->post('g-recaptcha-response');						
			if (!$recaptchaResponse) {
				//$this->session->set_flashdata('message_event_error', 'Please verify that you are not a robot.');
				$data['msg'] = 'Please verify that you are not a robot.';
				//echo 13;exit;
			}else{		
			$secretKey = SECRET_KEY; 
			$verifyUrl = "https://www.google.com/recaptcha/api/siteverify";

			$response = file_get_contents($verifyUrl . "?secret={$secretKey}&response={$recaptchaResponse}");
			$responseData = json_decode($response);	
			//
			//if ($responseData->success) 
			if(1==1)
			{
				//echo 1;exit;
				if($this->input->post('signin_username'))
			  // print_r($this->input->post());die;
				 $user = $this->security->xss_clean($this->input->post('signin_username'));
				$pass = $this->security->xss_clean($this->input->post('signin_password'));
				$role_id = $this->security->xss_clean($this->input->post('role_id'));
				$uttype = $this->security->xss_clean($this->input->post('uttype'));
				$adminRec = array_shift($this->login_model->get_user($user,$pass,$role_id,$uttype));
				$get_student =$this->login_model->get_student($user);
				if($user=='sunerp'){
				//echo 1111;print_r($adminRec);
				//exit;
				}
				$checkro=$this->login_model->getRoUser($adminRec['username']);
			//print_r($checkro);exit;
				 if(!empty($checkro))
				 {
					 $adminRec['ro']=$checkro; //for setting RO in session variable
				 }	 
				/*  echo $adminRec['ro'];
				 die(); */
				if(sizeof($adminRec)>0)
				{
					
					if($adminRec['status']=='Y')
					{	//if($adminRec['roles_id']!=21 && $adminRec['roles_id']!=63  && $adminRec['roles_id']!=20  && $adminRec['roles_id']!=44) 
						if (
							$adminRec['roles_id'] != 21 && $adminRec['roles_id']!=6 && $adminRec['roles_id']!=4 &&
							strpos($this->input->post('signin_username'), '25SUN') === false &&
							$adminRec['username'] != '662659'
						){ 
						
							$this->session->set_userdata('username',$adminRec['username']);
							$this->session->set_userdata('roles_id',$adminRec['roles_id']);
							//redirect('login/otp_login_submit/'.base64_encode($adminRec['username']).'/'.base64_encode($adminRec['roles_id']));
						    redirect('login/otp_login/'.base64_encode($adminRec['username']).'/'.base64_encode($adminRec['roles_id']));exit;
							
							//redirect('login/otp_login_submit'); exit;
							
						}
						//if($adminRec['roles_id'] =='15' || $adminRec['roles_id']=='6'){
						$emp_data= array_shift($this->login_model->get_employee_details_byId($user));
						//print_r($emp_data);exit;
						$array = array(
										'uid' => $adminRec['um_id'],
										'name'=> $adminRec['username'],
										'role_id'=>$adminRec['roles_id'],
										'emp_name'=>$emp_data['emp_name'],
										'sname'=> $get_student['stud_id'],
										'aname'=>$emp_data['aname'],
										'uttype'=>$uttype,
										 'ro'=>$adminRec['ro'],
										 'is_password_reset' => $adminRec['is_password_reset'],
										'logged_in' => TRUE);
							$check_details=$this->login_model->get_universal_id($adminRec['username'],1);	
							
							$array['uni_type']=base64_encode(1);
							$array['universalid']=base64_encode($check_details->um_id);			
										
										
						$this->session->set_userdata($array);
						
						//$this->login_model->get_user($user,$pass,$role_id,$uttype);
						if($adminRec['username']=='110376'){
							redirect('Leave/leave_applicant_list');
						}elseif($adminRec['username']=='662659'){
							redirect('finance/dashboard');  
						}else{
							redirect('home');
						}
						exit;
						//}else{
						//	redirect('login/logoff');
						//}
					}
					else
					{
						$data['msg'] = 'Your account is blocked.';
							  $this->session->set_flashdata('msg','Your account is blocked.');
						$data['roleid'] = $role_id;
						if($uttype!='')
						{
							   redirect('login/index/'.$uttype);
						}
						else
						{
							 redirect('login');
						}
					}                                    
				}
				else
				{
					
					$data['msg'] = 'In-valid Username or Password';
						  $this->session->set_flashdata('msg','In-valid Username or Password');
					$data['roleid'] = $role_id;
					if($uttype!='')
						{
							   redirect('login/index/'.$uttype);
						}
						else
						{
							 redirect('login');
						}
				//  redirect($_SERVER['REQUEST_URI'], 'refresh'); 
				}
				}
				else
				{
					echo 2;exit;
				$data['msg'] = 'Captcha verification failed';
				}
			}
		}
        //echo "fdfdfd"; die;
       // redirect($_SERVER['REQUEST_URI'], 'refresh'); 
        $this->load->view('login',$data);
    }


	public function app_login()
    {
		exit;
		 $this->load->helper("url");		
	     $data['utype'] = $this->uri->segment(3);
		
		
		
        $data['msg'] = '';	
        if($this->security->xss_clean($this->input->post('role_id')==4)){
             $data['login_user'] = 'Student';
        }
       else if($this->security->xss_clean($this->input->post('role_id')==9)){
             $data['login_user'] = 'Parent';
        }
        else
        {
             $data['login_user'] = 'Staff';
        }

        if($this->input->post('submit'))
        {
			//echo $var;
			//exit(0);
            
            if($this->input->post('signin_username'))
            // print_r($this->input->post());die;
            $user = $this->security->xss_clean($this->input->post('signin_username'));
            $pass = $this->security->xss_clean($this->input->post('signin_password'));
            $role_id = $this->security->xss_clean($this->input->post('role_id'));
			 $uttype = $this->security->xss_clean($this->input->post('uttype'));
            $adminRec = array_shift($this->login_model->get_user($user,$pass,$role_id,$uttype));
			$get_student =$this->login_model->get_student($user);
              
/* print_r($adminRec);	
echo $adminRec['username'];
die();	 */	$checkro=$this->login_model->getRoUser($adminRec['username']);
             if(!empty($checkro))
			 {
				 $adminRec['ro']=$checkro; //for setting RO in session variable
			 }	 
			/*  echo $adminRec['ro'];
			 die(); */
            if(sizeof($adminRec)>0)
            {
                if($adminRec['status']=='Y')
                {
					//if($adminRec['roles_id'] =='15' || $adminRec['roles_id']=='6'){
                    $emp_data= array_shift($this->login_model->get_employee_details_byId($user));
                    $array = array(
                                    'uid' => $adminRec['um_id'],
                                    'name'=> $adminRec['username'],
                                    'role_id'=>$adminRec['roles_id'],
                                    'emp_name'=>$emp_data['emp_name'],
									'aname'=>$emp_data['aname'],
									'uttype'=>$uttype,
				                     'ro'=>$adminRec['ro'],
                                    'logged_in' => TRUE,
									'is_password_reset' => $adminRec['is_password_reset']
									);
                    $this->session->set_userdata($array);
                    
                    //$this->login_model->get_user($user,$pass,$role_id,$uttype);
                    if($adminRec['username']=='110376'){
						redirect('Leave/leave_applicant_list');
                    }else{
                    redirect('home');
}
                    exit;
					//}else{
					//	redirect('login/logoff');
					//}
                }
                else
                {
                    $data['msg'] = 'Your account is blocked.';
						  $this->session->set_flashdata('msg','Your account is blocked.');
                    $data['roleid'] = $role_id;
					if($uttype!='')
					{
						   redirect('login/index/'.$uttype);
					}
					else
					{
						 redirect('login');
					}
                }                                    
            }
            else
            {
                
                $data['msg'] = 'In-valid Username or Password';
					  $this->session->set_flashdata('msg','In-valid Username or Password');
                $data['roleid'] = $role_id;
				if($uttype!='')
					{
						   redirect('login/index/'.$uttype);
					}
					else
					{
						 redirect('login');
					}
            //  redirect($_SERVER['REQUEST_URI'], 'refresh'); 
            }
        }
        //echo "fdfdfd"; die;
       // redirect($_SERVER['REQUEST_URI'], 'refresh'); 
        $this->load->view('login',$data);
    }
  
    
    public function logoff()
    {
        $array_items = array('uid','name','uttype','emp_name','ro','logged_in','role_id','ScourseId','Sstream_id','Ssemester','TScourse_id','TSstream_id','TSsemester','TSdivision','SAcourseId','SAstream_id','SAsemester','roles_id');
		if($_SESSION['uttype']!='')
		{
			$vart = $_SESSION['uttype'];
		}
        $this->session->unset_userdata($array_items);
		if($vart!='')
		{
			   redirect('login/index/'.$vart);
		}
		else{
        redirect('login');
		}
    }
	
	
	
	 public function Go_iilp()
    {
        $array_items = array('uid','name','emp_name','uttype','ro','logged_in','role_id','ScourseId','Sstream_id','Ssemester','TScourse_id','TSstream_id','TSsemester','TSdivision','SAcourseId','SAstream_id','SAsemester');
		if($_SESSION['uttype']!='')
		{
			$vart = $_SESSION['uttype'];
		}
        $this->session->unset_userdata($array_items);
		//$this->session->unset_userdata();
		if($vart!='')
		{
			 //  redirect('login/index/'.$vart);
		}else{
       // redirect('login');
		}
		 echo '<script>window.location.href = "https://erpiilp.sandipuniversity.com/";</script>';
		 
		
    }
	public function Go_bvoc()
    {
        $array_items = array('uid','name','emp_name','uttype','ro','logged_in','role_id','ScourseId','Sstream_id','Ssemester','TScourse_id','TSstream_id','TSsemester','TSdivision','SAcourseId','SAstream_id','SAsemester');
		if($_SESSION['uttype']!='')
		{
			$vart = $_SESSION['uttype'];
		}
        $this->session->unset_userdata($array_items);
		//$this->session->unset_userdata();
		if($vart!='')
		{
			 //  redirect('login/index/'.$vart);
		}else{
       // redirect('login');
		}
		 echo '<script>window.location.href = "https://erpbvoc.sandipuniversity.com/";</script>';
		 
		
    }
	
	
	public function login_json()
    {
		exit;
		//print_r($_POST);
		//echo json_encode("Done");
		//exit();
		 $this->load->helper("url");		
	     $data['utype'] = $this->uri->segment(3);
		
		
		
        $data['msg'] = '';	
        if($this->security->xss_clean($this->input->post('role_id')==4)){
             $data['login_user'] = 'Student';
        }
       else if($this->security->xss_clean($this->input->post('role_id')==9)){
             $data['login_user'] = 'Parent';
        }
        else
        {
             $data['login_user'] = 'Staff';
        }

        if($this->input->post('submit'))
        {
			//echo $var;
			//exit(0);
            
            if($this->input->post('signin_username'))
            // print_r($this->input->post());die;
            $user = $this->security->xss_clean($this->input->post('signin_username'));
            $pass = $this->security->xss_clean($this->input->post('signin_password'));
            $role_id = $this->security->xss_clean($this->input->post('role_id'));
			 $uttype = $this->security->xss_clean($this->input->post('uttype'));
            $adminRec = array_shift($this->login_model->get_user($user,$pass,$role_id,$uttype));
              
/* print_r($adminRec);	
echo $adminRec['username'];
die();	 */	$checkro=$this->login_model->getRoUser($adminRec['username']);
             if(!empty($checkro))
			 {
				 $adminRec['ro']=$checkro; //for setting RO in session variable
			 }	 
			/*  echo $adminRec['ro'];
			 die(); */
            if(sizeof($adminRec)>0)
            {
                if($adminRec['status']=='Y')
                {
					//if($adminRec['roles_id'] =='15' || $adminRec['roles_id']=='6'){
                    $emp_data= array_shift($this->login_model->get_employee_details_byId($user));
                    $array = array(
                                    'uid' => $adminRec['um_id'],
                                    'name'=> $adminRec['username'],
                                    'role_id'=>$adminRec['roles_id'],
                                    'emp_name'=>$emp_data['emp_name'],
									'aname'=>$emp_data['aname'],
									'uttype'=>$uttype,
				                     'ro'=>$adminRec['ro'],
                                    'logged_in' => TRUE);
                    $this->session->set_userdata($array);
                    
                    //$this->login_model->get_user($user,$pass,$role_id,$uttype);
                    if($adminRec['username']=='110376'){
                    //redirect('Leave/leave_applicant_list');
                    }else{
                   // redirect('home');
				   //$msg=array("Message"=>"Success");
				   $Message = "Success";
				   $response[] = array("Message" => $Message,'uid'=>$adminRec['um_id'],'name'=>$adminRec['username'],'role_id'=>$adminRec['roles_id'],'aname'=>$emp_data['aname']);

				   echo json_encode($response);
}
                    exit;
					//}else{
					//	redirect('login/logoff');
					//}
                }
                else
                {
                    $data['msg'] = 'Your account is blocked.';
						  $this->session->set_flashdata('msg','Your account is blocked.');
                    $data['roleid'] = $role_id;
					if($uttype!='')
					{
						//   redirect('login/index/'.$uttype);
						echo json_encode("Fail");
					}
					else
					{
					//	 redirect('login');
					echo json_encode("Fail");
					}
                }                                    
            }
            else
            {
                
                $data['msg'] = 'In-valid Username or Password';
					  $this->session->set_flashdata('msg','In-valid Username or Password');
                $data['roleid'] = $role_id;
				if($uttype!='')
					{
					//	   redirect('login/index/'.$uttype);
					echo json_encode("Fail");
					}
					else
					{
						// redirect('login');
						echo json_encode("Fail");
					}
					echo json_encode("Fail");
            //  redirect($_SERVER['REQUEST_URI'], 'refresh'); 
            }
        }
        //echo "fdfdfd"; die;
       // redirect($_SERVER['REQUEST_URI'], 'refresh'); 
     //   $this->load->view('login',$data);
    }
	
	
	
	public function view($prn)
    {
		$this->load->model('Certificate_model');
		$this->data['emp']= $this->Certificate_model->get_proviCerticateStudents($prn);			
		$this->load->view('Certificate/degree_certificate_html',$this->data);

    }
	public function view_degree_certificate($prn)
    {
		//echo $prn='170101171034';//exit;
		$this->load->model('Certificate_model');
		 $student_id =$this->Certificate_model->student_id(base64_decode($prn));
		$this->data['emp']= $this->Certificate_model->get_degreeCerticateStudents(base64_decode($prn));
		//echo "<pre>";
		//print_r($this->data['emp']);
		//exit;
	     $stud_last_exsess= $this->Certificate_model->stud_last_exam_session($student_id);
		
		$this->data['stud_last_ex_ses'] =$stud_last_exsess[0]['exam_month'].'-'.$stud_last_exsess[0]['exam_year'];
		if(!empty($this->data['emp'])){	
		$this->load->view('Certificate/degree_certificate_html_new',$this->data);
		}else{
			echo "Degree certificate not dispatched";
		}

    }	
	public function phd_view_degree_certificate($prn)
    {
		$this->load->model('Certificate_model');
		$this->load->model('Phd_results_model');
		 $student_id =$this->Certificate_model->student_id(base64_decode($prn));
		$gc_id = $this->Certificate_model->phd_get_degreeCerticateStudents(base64_decode($prn));
		$gc_id = $gc_id[0]['gc_id'];
		$this->data['stud_data'][]=$this->Phd_results_model->fetch_phd_degree_cert_assgn_det($gc_id);
		//echo "<pre>";
		//print_r($this->data['stud_data']);
		//exit;
		if(!empty($gc_id)){	
		$this->load->view('Certificate/phd_degree_certificate_html_new',$this->data);
		}else{
			echo "Degree certificate not dispatched";
		}

    }	
	
	public function view_degree_certificate1($prn)
    {
		//echo $prn='170101171034';//exit;
		$this->load->model('Certificate_model');
		 $student_id =$this->Certificate_model->student_id(base64_decode($prn));
		$this->data['emp']= $this->Certificate_model->get_degreeCerticateStudents(base64_decode($prn));
	
	     $stud_last_exsess= $this->Certificate_model->stud_last_exam_session($student_id);
		
		$this->data['stud_last_ex_ses'] =$stud_last_exsess[0]['exam_month'].'-'.$stud_last_exsess[0]['exam_year'];
		if(!empty($this->data['emp'])){	
		$this->load->view('Certificate/degree_certificate_html_new1',$this->data);
		}else{
			echo "Degree certificate not dispatched";
		}

    }	
	
	
	function orderBy($data, $field)
  {
    $code = "return strnatcmp(\$a['$field'], \$b['$field']);";
    usort($data, create_function('$a,$b', $code));
    return $data;
  }
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function view_consolated(){
		 $list=$this->uri->segment(3);
		//exit();
		  // $stud_prnn='180107021005';//$prn;
		  // $list=$this->Certificate_model->student_id($stud_prnn);
		   $enrollment_no=$this->Certificate_model->enrollment_no($list);
		 //exit() ; 
	    $stud_last_exsess= $this->Certificate_model->stud_last_exam_session($list);
		$stud_last_exsess[0]['exam_month'].'-'.$stud_last_exsess[0]['exam_year'];
	    $stud_prnn= $stud_prnn; //chk_stud //stud_prnn
		//print_r($stud_last_exsess);
		//exit;
		$stud_idd= $stud_last_exsess[0]['student_id'];
		$list=$stud_last_exsess[0]['student_id'];
		$stream_id= $stud_last_exsess[0]['stream_id'];
		$exam_id= $stud_last_exsess[0]['exam_id'];
		$school= $stud_last_exsess[0]['school_id'];
		$semester= $stud_last_exsess[0]['semester'];
	//	print_r($student_id);
		$exam_month=$stud_last_exsess[0]['exam_month'];
	    $exam_year=$stud_last_exsess[0]['exam_year'];
	   
	   
	    $stud_prnn= $list; //chk_stud //stud_prnn
		//print_r($stud_prnn);
		//exit;
		$stud_idd= $list;
		//$stream_id= $stream_id;
		//$exam_id= $exam_id;
		//$school= $school;
		//$semester= $semester;	
		$this->data['semester']=$semester;
	    $dattime=date('Y-m-d');
		
		$current_date=$dattime;

		  // echo "inside";
	    	//$enrollment_no=$this->Certificate_model->enrollment_no($student_id);
			
          $stud_list= $this->Certificate_model->Manual_certificate($enrollment_no,$stream_id,$school,$exam_id,$semester,$stud_idd);
		  $stud_last_exsess= $this->Certificate_model->stud_last_exam_session($list);
		  $this->data['stud_last_ex_ses'] =$stud_last_exsess[0]['exam_month'].'-'.$stud_last_exsess[0]['exam_year']; 
		// echo '<pre>';
		// print_r($stud_list);
		// exit();
		  $stud_list = $this->orderBy($stud_list, 'subject_order');
		  $this->data['stud_list']=$stud_list;

		  $this->data['exam_month']=$exam_month;
          $this->data['exam_year']=$exam_year;
          $this->data['exam_id']=$exam_id;
		  if($exam_id >=13){
					$signature='Sign COE 01.png';
				}else{
					$signature='Sign COE 01_parimala.png';
				}
		  //echo '<pre>'; print_r($stud_list);
		  //$html='';
		  //$this->load->view('header',$this->data);
			$this->load->view('Certificate/view_consolidated_gradesheet_certificate_html_view.php',$this->data);
		   
			$footer = '<table width="800" border="0" cellspacing="0" cellpadding="0" align="center" style="margin-bottom:68px">

				  <tr>
					<td align="left" height="50" class="signature" style="margin-left:50px;"></td>
					<td align="center" height="50" class="signature"></td>
					<td align="right" height="50" class="signature"><img src="'.base_url().'assets/images/'.$signature.'" height="50" width="200"></td>
				  </tr>
				 <tr>
					<td align="left" height="50" class="signature" style="margin-left:155px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td align="left" height="50" class="signature" valign="top" style="margin-top:2px;"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'; 
					
					$footer .=$current_date.'</strong></td>
					<td align="right" height="50" valign="top" class="signature" style="text-align:top;"></td>
				  </tr>
				</table>
				<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
				<tr>
				<td align="center" colspan="3" class="signature"><small style="color:#CDCACA;">'.$current_date.'</small></td>
				</tr>
				</table>';

					 	
	}
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		function view_markscard($prn){
			//echo 'insede';exit;
		 
		  $list =base64_decode($prn);
		//error_reporting(E_ALL); ini_set('display_errors', 1); 
		 //echo "<pre>";
		// echo $chk_stud= $chk_checked; $semester=$sem;$admission_stream=$stream;$exam_session=$exam_session;
	     //print_r($_POST);exit;
		 //$this->Results_model->fetch_student_grade_details($_POST);
		 $this->load->model('Results_model');
		 $this->load->model('Marks_model');
		 $student=array();
		 $s3_selete = [];
		 $stud_last_exsess= $this->Certificate_model->stud_last_exam_details($list);
		 
		 if($_POST['stream_id'] !='71'){

			 $student = $_POST['chk_stud'];
			 $exam_session = explode('~', $_POST['exam_session']);
			 $certf_dat = str_replace('/', '-', $_POST['mrk_cer_date']);
			 
			 if(!empty($_POST['mrk_cer_date'])){
			 $certf_date = date('d M, Y', strtotime($certf_dat));
			 }else{
				$certf_date =''; 
			 }
			 
			 
			 $stream_id = $stud_last_exsess[0]['stream_id'];
			 $semester = $stud_last_exsess[0]['seemster'];
			 $exam_id =$stud_last_exsess[0]['exam_id'];
			 $exam_ses =$exam_session[0].''.$exam_session[1];
			 $exam_ses =$stud_last_exsess[0]['month'].''.$$stud_last_exsess[0]['exam_month'];
			 $today_date = date('d-m-Y');
			 $stud =$stud_last_exsess[0]['stud_id'];
			$res_bklogsems =array();
			$resgrade=array();
			
			//print_r($student);
			//exit();
				 $exam_unique_id  = $this->Results_model->fetch_student_exam_unique_id($stud, $stream_id,$semester,$exam_id);
				 $this->data['stud_data'][] = $this->Results_model->fetch_student_grade_details($stud, $stream_id,$semester,$exam_id);
				 $this->data['res_uniq_sem'] = $this->Results_model->fetch_student_unique_result_semester($stud,$exam_id);

				$this->data['resultsgrade_f'] = $resultsgrade;
				
				//$this->data['resultsgrade'] = $resgrade;
				//$this->data['res_bklogsems'] = array_unique($res_bklogsems);
				
				//print_r($res_bklogsems);exit;
			/*	  echo "<pre>";
				 print_r($this->data['stud_data']);
				  echo "</pre>";
			*/

				
				 $this->data['exam_master_id'][] = $exam_unique_id[0]['exam_master_id'];
			 
				$strmname = $this->data['stud_data'][0][0]['stream_short_name'];
				
				$html = $this->load->view('Results/marsk_card_pdf_html_qrcode',$this->data,true);
				echo $html;
				exit();
			 unset($f_grade);
			 unset($resgrade);
			 unset($res_bklogsems);
			
			 
		}else{  //if($_POST['stream_id'] !='71'){
			
		 }
		 
		
		// ob_end_flush();
	}
	
	
	function view_markscard_phd($prn){
			//echo 'insede';exit;
		 
		  $list =base64_decode($prn);
		//error_reporting(E_ALL); ini_set('display_errors', 1); 
		 //echo "<pre>";
		// echo $chk_stud= $chk_checked; $semester=$sem;$admission_stream=$stream;$exam_session=$exam_session;
	     //print_r($_POST);exit;
		 //$this->Results_model->fetch_student_grade_details($_POST);
		 $this->load->model('Results_model');
		 $this->load->model('Phd_results_model');
		 $this->load->model('Marks_model');
		 $student=array();
		 $s3_selete = [];
		 $stud_last_exsess= $this->Certificate_model->stud_last_exam_details_phd($list);
		 
		 if($_POST['stream_id'] !='71'){

			 $student = $_POST['chk_stud'];
			 $exam_session = explode('~', $_POST['exam_session']);
			 $certf_dat = str_replace('/', '-', $_POST['mrk_cer_date']);
			 
			 if(!empty($_POST['mrk_cer_date'])){
			 $certf_date = date('d M, Y', strtotime($certf_dat));
			 }else{
				$certf_date =''; 
			 }
			 
			 
			 $stream_id = $stud_last_exsess[0]['stream_id'];
			 $semester = $stud_last_exsess[0]['seemster'];
			 $exam_id =$stud_last_exsess[0]['exam_id'];
			 $exam_ses =$exam_session[0].''.$exam_session[1];
			 $exam_ses =$stud_last_exsess[0]['month'].''.$$stud_last_exsess[0]['exam_month'];
			 $today_date = date('d-m-Y');
			 $stud =$stud_last_exsess[0]['stud_id'];
			$res_bklogsems =array();
			$resgrade=array();
			
			//print_r($student);
			//exit();
				 $exam_unique_id  = $this->Phd_results_model->fetch_student_exam_unique_id($stud, $stream_id,$semester,$exam_id);
				 $this->data['stud_data'][] = $this->Phd_results_model->fetch_student_grade_details($stud, $stream_id,$semester,$exam_id);
				 $this->data['res_uniq_sem'] = $this->Phd_results_model->fetch_student_unique_result_semester($stud,$exam_id);

				$this->data['resultsgrade_f'] = $resultsgrade;
				
				//$this->data['resultsgrade'] = $resgrade;
				//$this->data['res_bklogsems'] = array_unique($res_bklogsems);
				
				//print_r($res_bklogsems);exit;
			/*	  echo "<pre>";
				 print_r($this->data['stud_data']);
				  echo "</pre>";
			*/

				
				 $this->data['exam_master_id'][] = $exam_unique_id[0]['exam_master_id'];
			 
				$strmname = $this->data['stud_data'][0][0]['stream_short_name'];
				
				$html = $this->load->view('Results/marsk_card_pdf_html_qrcode_phd',$this->data,true);
				echo $html;
				exit();
			 unset($f_grade);
			 unset($resgrade);
			 unset($res_bklogsems);
			
			 
		}else{  //if($_POST['stream_id'] !='71'){
			
		 }
		 
		
		// ob_end_flush();
	}
	
	//////// code by vrs
	
	function decrypt($string_to_encrypt)
{
$password="password";

return $decrypted_string=openssl_decrypt($string_to_encrypt,"AES-128-ECB",$password);

}
	
	 public function autologin($um_id='')
    {
		redirect('login');exit;
		
		 $this->load->helper("url");		
         $data['login_user'] = 'Staff';
        

        if(!empty($um_id))
        {
           session_unset();
			$um_id= base64_decode($um_id);
            $um_id=$this->decrypt($um_id);
            $adminRec = array_shift($this->login_model->get_user_auto($um_id));
            $checkro=$this->login_model->getRoUser($adminRec['username']);
//print_r($adminRec);exit;
             if(!empty($checkro))
			 {
				 $adminRec['ro']=$checkro; //for setting RO in session variable
			 }	 

            if(sizeof($adminRec)>0)
            {
                if($adminRec['status']=='Y')
                {
					//if($adminRec['roles_id'] =='15' || $adminRec['roles_id']=='6'){
                    $emp_data= array_shift($this->login_model->get_employee_details_byId($adminRec['username']));
                    $array = array(
                                    'uid' => $adminRec['um_id'],
                                    'name'=> $adminRec['username'],
                                    'role_id'=>$adminRec['roles_id'],
                                    'roles_id'=>$adminRec['roles_id'],
                                    'emp_name'=>$emp_data['emp_name'],
									'aname'=>$emp_data['aname'],
									'uttype'=>$uttype,
				                     'ro'=>$adminRec['ro'],
                                    'logged_in' => TRUE);
						$check_details=$this->login_model->get_universal_id($adminRec['username'],1);	
						
						$array['uni_type']=base64_encode(1);
						$array['universalid']=base64_encode($check_details->um_id);			
									
									
                    $this->session->set_userdata($array);
                    
                    //$this->login_model->get_user($user,$pass,$role_id,$uttype);
                    if($adminRec['username']=='110376'){
					redirect('Leave/leave_applicant_list');
                    }else{
                    redirect('home');
}
                    exit;
					//}else{
					//	redirect('login/logoff');
					//}
                }
                else
                {
                    $data['msg'] = 'Your account is blocked.';
						  $this->session->set_flashdata('msg','Your account is blocked.');
                    $data['roleid'] = $role_id;
					if($uttype!='')
					{
						   redirect('login/index/'.$uttype);
					}
					else
					{
						 redirect('login');
					}
                }                                    
            }
            else
            {
                
                $data['msg'] = 'In-valid Username or Password';
					  $this->session->set_flashdata('msg','In-valid Username or Password');
                $data['roleid'] = $role_id;
				if($uttype!='')
					{
						   redirect('login/index/'.$uttype);
					}
					else
					{
						 redirect('login');
					}
            //  redirect($_SERVER['REQUEST_URI'], 'refresh'); 
            }
        }
        //echo "fdfdfd"; die;
       // redirect($_SERVER['REQUEST_URI'], 'refresh'); 
        $this->load->view('login',$data);
    }
	// code end by vrs
	///////////otp code start here///////////
	public function otp_login()
		{
			$this->data['user']=base64_decode($this->uri->segment(3));
			$this->data['roles_id']=base64_decode($this->uri->segment(4));
			$this->load->view('otp_login',$this->data);				
		}
	public function otp_login_submit()
	 {

		    $user = $this->security->xss_clean($this->input->post('signin_username'));
		    $roles_id = $this->security->xss_clean($this->input->post('roles_id')); 
		    $login_method = $this->security->xss_clean($this->input->post('login_method'));
		  // $user =$this->session->userdata('username');
		  // $roles_id = $this->session->userdata('roles_id');

		   $user_val = array_shift($this->login_model->check_user_details($user,$roles_id));	
     	   
		    if(!empty($user_val))
			{
				 

				if (in_array($user_val['roles_id'], [20,21,44,3,40,12,13,2,68,63,59])) {
					$user_data = $this->login_model->check_emp_other_details($user_val['username']);
				} 
				else if (in_array($user_val['roles_id'], [4, 9])) {
					$user_data = $this->login_model->check_stud_prnt_details($user_val['username']);
				} 
				else {
					$user_data = $this->login_model->check_oth_user_details($user_val['username'], $user_val['roles_id']);
				}

           
			     if ($login_method == 'mobile') {

				$contact = !empty($user_data['mobileNumber']) ?
							$user_data['mobileNumber'] :
							$user_data['parent_mobno'];

				if (empty($contact)) {
					$data['msg'] = "No mobile number registered!";
					return $this->load->view('login', $data);
				}

			} else if ($login_method == 'email') {

				$contact = !empty($user_data['oemail']) ?
							$user_data['oemail'] :
							$user_data['pemail'];

				if (empty($contact)) {
					$data['msg'] = "No email ID registered!";
					return $this->load->view('login', $data);
				}
			}

             $otp=rand (100000 , 999999);

              $otp_data=array(
			  
			     'otp'=>$otp,			  
			  );			  
    				 
			 $this->db->where('um_id',$user_val['um_id']);
			  if (in_array($user_val['roles_id'], [4, 9])) {
					$this->db->where('roles_id', $user_val['roles_id']);
					$this->db->update("sandipun_ums.user_master", $otp_data);
				} else {
					$this->db->update("user_master", $otp_data);
				}
			
			  if ($login_method == 'mobile') {
        // API call sending SMS OTP
            $response = $this->login_model->send_otp_via_api($otp, $contact);

				} else {
					$name = trim($user_data['fname'] . ' ' . $user_data['lname']);
                     $name = ($name == '') ? $user_data['username'] : $name;
                     $otpText = '<h4>'.$otp.'</h4>'; // Optional if you want a header tag
					$subject = "OTP for Login Verification";

						// OTP email body with visual OTP box
					$body = '
					<html>
					<head>
					  <title>Login OTP</title>
					</head>
					<body style="font-family: Arial, sans-serif; line-height: 1.4; color: #000; margin:0; padding:0;">
					  <p>Dear ' . (!empty($name) ? htmlspecialchars($name) : 'User') . ',</p>

					  <p>Your Login OTP is:</p>

					  <p style="font-size: 20px; font-weight: bold; letter-spacing: 2px; margin:5px 0;">' . $otp . '</p>

					  <p>The OTP is confidential and for security reasons, DO NOT share it with anyone.</p>
					</body>
					</html>';


				$subject = "OTP for Verification - ERP";
				$response = $this->send_leave_mail($contact, $subject, $body);
				}
				
			$_SESSION['otp'] = $otp;
			$_SESSION['otp_sent_at'] = time();
			$_SESSION['otp_expiry_time'] = 300;
			$_SESSION['user_ip'] = $_SERVER['REMOTE_ADDR'];	
			
			if ($login_method == 'mobile') {
				$this->session->set_flashdata('msg', 'OTP sent to your registered mobile number');
			} else {
				$this->session->set_flashdata('msg', 'OTP sent to your registered email');
			}

			
               redirect('login/otp_login_verify/');
				   
			}
			else
			{
				$data['msg'] = 'In-valid Username';
			}
			
			$this->load->view('login',$data);
	     }
	  /*  public function otp_login_submit_old()
	 {
		   // $user = $this->security->xss_clean($this->input->post('signin_username'));
		   //$roles_id = $this->security->xss_clean($this->input->post('roles_id')); 
		   $user =$this->session->userdata('username');
		   $roles_id = $this->session->userdata('roles_id');
		   
		   $user_val = array_shift($this->login_model->check_user_details($user,$roles_id));	
     	   
		    if(!empty($user_val))
			{
				 
				if($user_val['roles_id']==20 || $user_val['roles_id']==21 || $user_val['roles_id']==44 || $user_val['roles_id']==3 || $user_val['roles_id']==63 || $user_val['roles_id']==40  || $user_val['roles_id']==12 || $user_val['roles_id']==13 || $user_val['roles_id']==2 || $user_val['roles_id']==68 || $user_val['roles_id']==59) 
				{
					$user_data=$this->login_model->check_emp_other_details($user_val['username']);
				}
                else if($user_val['roles_id']==4 || $user_val['roles_id']==9 )
				{
					$user_data=$this->login_model->check_stud_prnt_details($user_val['username']);
					
				}else
				{
					$user_data=$this->login_model->check_oth_user_details($user_val['username'],$user_val['roles_id']);
				}					

 			   if(!empty($user_data['mobileNumber']))
			   {
				   $mob=$user_data['mobileNumber'];
			   }
			  else
			  {
			     $mob=$user_data['parent_mobno'];
			  }	  
			  if($mob!=''){
             $otp=rand (100000 , 999999);

              $otp_data=array(
			  
			     'otp'=>$otp,			  
			  );			  
			 $otp_data['otp_date']=date('Y-m-d');
			 
			 $this->db->where('um_id',$user_val['um_id']);
			 if($user_val['roles_id']==4 || $user_val['roles_id']==9 ){
			 $this->db->where('roles_id',$user_val['roles_id']); 
			 $this->db->update("sandipun_ums.user_master", $otp_data);
			 }else
			 {
			   $this->db->update("user_master", $otp_data); 
			 }	
			$response=$this->login_model->send_otp_via_api($otp,$mob);


			 if($response== 1){
				 
				$_SESSION['otp'] = $otp;
				$_SESSION['otp_sent_at'] = time(); // Timestamp when OTP was sent
				$_SESSION['otp_expiry_time'] = 300; // OTP expiration in seconds (5 minutes)
				$_SESSION['user_ip'] = $_SERVER['REMOTE_ADDR']; 
				 
				 
				echo 'OTP has sent to your registered mobile number';
               $this->session->set_flashdata('msg','OTP has sent to your registered mobile number');
				
			 }else{
			 echo 'OTP has sent to your registered mobile number';
              $this->session->set_flashdata('msg','OTP has sent to your registered mobile number1');

			 } 
			
               redirect('login/otp_login_verify/');
			}
			   else
			   {
				  $data['msg'] = 'Mobile Number Not Registered. Kindly Register it';
			   }				   
			}
			else
			{
				$data['msg'] = 'In-valid Username';
			}
			
			$this->load->view('login',$data);
	     } */
		 

	/* public function otp_login_verify()	 
	{
		 if($_POST)
		{
		   $otp=$this->input->post('otp');	
		   $mobile_no=$this->input->post('mobile_no');			   
		   $user=$this->input->post('username');		   
		   $roles_id=$this->input->post('roles_id');		   
		   $send_otp= array_shift($this->login_model->check_user_details($user,$roles_id));
          if($otp==$send_otp['otp'])
		  {
			$adminRec = array_shift($this->login_model->get_otp_user($user,$roles_id)); 
			$checkro=$this->login_model->getRoUser($adminRec['username']);
             if(!empty($checkro))
			 {
				 $adminRec['ro']=$checkro; //for setting RO in session variable
			 }
			 if(sizeof($adminRec)>0)
            {			  
			      if($adminRec['status']=='Y')
                {

                    $emp_data= array_shift($this->login_model->get_employee_details_byId($user));
                    $array = array(
                                    'uid' => $adminRec['um_id'],
                                    'name'=> $adminRec['username'],
                                    'role_id'=>$adminRec['roles_id'],
                                    'emp_name'=>$emp_data['emp_name'],
									'aname'=>$emp_data['aname'],
									'uttype'=>$uttype,
				                     'ro'=>$adminRec['ro'],
                                    'logged_in' => TRUE);
						$check_details=$this->login_model->get_universal_id($adminRec['username'],1);	
						
					$array['uni_type']=base64_encode(1);
					$array['universalid']=base64_encode($check_details->um_id);	
                    $this->session->set_userdata($array);
                    redirect('home');
                    exit;
                }
                else
                {
            $this->session->set_flashdata('msg1','Your account is blocked.');
		    redirect('login/otp_login_verify/'.base64_encode($user).'/'.base64_encode($mobile_no));						  
                } 
			}else{
			$this->session->set_flashdata('msg1','In-valid Username or Password');
		    redirect('login/otp_login_verify/'.base64_encode($user).'/'.base64_encode($mobile_no));
			 }
		  }  
		  else
		  {  
		    $this->session->set_flashdata('msg1','Please Enter Correct OTP');
		    redirect('login/otp_login_verify/'.base64_encode($user).'/'.base64_encode($mobile_no));
		  }		  
		}
		else
		{			
		    $this->data['username']=base64_decode($this->uri->segment(3));
		    $this->data['mobile']=base64_decode($this->uri->segment(4));
		    $this->data['roles_id']=base64_decode($this->uri->segment(5));
			$this->load->view('otp_login_verify',$this->data);
		}
	} */
	
	public function otp_login_verify()	 
	{
		 if($_POST)
		{
			$tokenName = $this->security->get_csrf_token_name();
			$tokenValue = $this->security->get_csrf_hash();

			// Fetch token submitted with form
			$userToken = $this->input->post($tokenName);

			/* if ($userToken !== $tokenValue) {
				show_error('Invalid CSRF token', 403);
			} */
			
		   $otp=$this->input->post('otp');	
		   $mobile_no=$this->input->post('mobile_no');			   
		   $user=$this->input->post('username');		   
		   $roles_id=$this->input->post('roles_id');		   
		   $send_otp= array_shift($this->login_model->check_user_details($user,$roles_id));
		    $cut=time() - $_SESSION['otp_expiry_time'];
		  
		   
          if($otp==$send_otp['otp'] && $otp==$_SESSION['otp'] && $_SESSION['otp_sent_at']>=$cut)
		  {
			 
			  unset($_SESSION['otp']);
			  unset($_SESSION['otp_sent_at']);
			  
			  unset($_SESSION['otp_expiry_time']);
			  unset($_SESSION['user_ip']);
			  $this->session->set_userdata('username',$user);
              $this->session->set_userdata('roles_id', $roles_id);

			$adminRec = array_shift($this->login_model->get_otp_user($user,$roles_id)); 
			$checkro=$this->login_model->getRoUser($adminRec['username']);
			$get_student =$this->login_model->get_student($user);
             if(!empty($checkro))
			 {
				 $adminRec['ro']=$checkro; //for setting RO in session variable
			 }
			 if(sizeof($adminRec)>0)
            {			  
			      if($adminRec['status']=='Y')
                {
                    $emp_data= array_shift($this->login_model->get_employee_details_byId($user));
                    $array = array(
                                    'uid' => $adminRec['um_id'],
                                    'name'=> $adminRec['username'],
                                    'role_id'=>$adminRec['roles_id'],
                                    'emp_name'=>$emp_data['emp_name'],
									'sname'=> $get_student['stud_id'],
									'aname'=>$emp_data['aname'],
									'uttype'=>$uttype,
				                     'ro'=>$adminRec['ro'],
                                    'logged_in' => TRUE,
									'is_password_reset' => $adminRec['is_password_reset']
									);
					$check_details=$this->login_model->get_universal_id($adminRec['username'],1);	
						
					$array['uni_type']=base64_encode(1);
					$array['universalid']=base64_encode($check_details->um_id);	
                    $this->session->set_userdata($array);
					if($adminRec['roles_id']=='6' || $adminRec['username']=='662659'){
							redirect('finance/dashboard');  
						}else{
							redirect('home');
							 exit;
						}
                   
                }
                else
                {
            $this->session->set_flashdata('msg1','Your account is blocked.');						  
		    redirect('login/otp_login_verify');						  
                } 
			}else{
			$this->session->set_flashdata('msg1','In-valid Username or Password');
		    redirect('login/otp_login_verify');
			 }
		  }  
		  else
		  {  
		    $this->session->set_flashdata('msg1','Please Enter Correct OTP');
		    redirect('login/otp_login_verify');
		  }		  
		}
		else
		{			

		    $this->data['username']=$this->session->userdata('username');
		    $this->data['mobile']=$this->session->userdata('mobile');
		    $this->data['roles_id']=$this->session->userdata('roles_id');
			$this->load->view('otp_login_verify',$this->data);
		}
	}
	
		public function send_attendance()	
			  {		
			  
			  
			  $icdb = $this->load->database('icdb', TRUE);
			  $d=date('Y-m-d H:i:s');
			  $icdb->insert('crons',array('cron'=>'ERP  AUTO SEND ATTENDANCE','date'=>$d));
			  
			  
					$this->load->model('Admin_model');			
					$emplist= $this->Admin_model->getEmployees1('Y');	

				
					$date=date('Y-m');
					$emplist1=array();
					if(!empty($emplist)){ 
						$m=1;
						foreach($emplist as $val){
						$email=	$val['oemail'];
						$emplist1[]['emp_id'] = $val['emp_id'];
						$sent_date=$val['mail_sent_on'];
						$array=array(211292,211278,211279,211280,211281,211283,211284,211285,211286,211288,211289,211290,211291,211292,211295,211297,110003);
						
							if($sent_date !=date('Y-m-d')   & (!in_array($val['emp_id'], $array))){
								
								
								$attendance[$val['emp_id']]=$this->Admin_model->getAttendanceForAllSchool($val['emp_id'],$date);
								$dt=array('empsid'=>array($val['emp_id']));
								$all_emp=$this->Admin_model->getAttendance_All1($dt);  
								$this->data['all_emp']= $all_emp;
								$this->data['attendance']=$attendance;
								$this->data['attend_date']=$date;		    		  		   
								$html =  $this->load->view('Admin/inout_pdf_export',$this->data,true);
								$this->load->library('m_pdf');
								$pdfFilePath1 =$val['emp_id'].$date."_attendance.pdf";
								$mpdf=new mPDF();
								$this->m_pdf->pdf = new mPDF('L', 'A3', '', '', 5, 5, 5, 5, 5, 5);
								$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
								$this->m_pdf->pdf->WriteHTML($html);
								$pdf_data=$this->m_pdf->pdf->Output('', "S");
								$body = "Hi Sir,
Please find your attendance. 

Thanks,
Sandip University";
								//$email='vighnesh.sukum@sandipuniversity.edu.in';
								$subject='weekly attendance';
								$this->send_mail($email,$subject,$body,$pdf_data,$pdfFilePath1);
								$this->db->where('emp_id', $val['emp_id']);
								$this->db->update('employee_master', array('mail_sent_on'=>date('Y-m-d')));
								//echo $this->db->last_query();
								//exit;
								$m++;
								
							}
						}
					}					
			   }
			
			
			

			function send_mail($email='',$subject='',$body='',$pdfData='',$filename='')
				{
					$path=$_SERVER["DOCUMENT_ROOT"].'/application/third_party/';
					require_once($path.'PHPMailer/class.phpmailer.php');
					date_default_timezone_set('Asia/Kolkata');
					require_once(APPPATH."third_party/PHPMailer/PHPMailerAutoload.php");
					$mail = new PHPMailer;
					//Tell PHPMailer to use SMTP
					$mail->isSMTP();			
					$mail->Host = 'smtp.gmail.com';		
					$mail->Port = 465;			
					$mail->SMTPAuth = true;
					$mail->isHTML(true);
					$mail->SMTPSecure = 'ssl';			
					$mail->Username = 'noreply9@sandipuniversity.edu.in'; 			
					$mail->Password = 'nxwg gjay gzxi eenl';			
					$mail->setFrom('noreply7@sandipuniversity.edu.in', 'SUN');
					$mail->AddAddress($email);
					$mail->AddBCC('vighnesh.sukum@sandipuniversity.edu.in');
					$mail->AddBCC('erp.support@sandipuniversity.edu.in');
					$mail->AddBCC('aryan.jha@sandipuniversity.edu.in');
					$mail->Subject = $subject;
					$mail->Body = $body;
					$mail->addStringAttachment($pdfData, $filename, 'base64', 'application/pdf');
					if (!$mail->send()) {
					echo 'Mailer Error: ' . $mail->ErrorInfo;
					} else {
					echo 'Message sent!';
					}
				}


function send_daily_leave_report(){
	
	$date=date('Y-m-d');
	$monthEnd = date('Y-m-t');
	$monthStart = date('Y-m-01');
	$sql="SELECT 
    e.emp_id,
    CONCAT(fname,' ',
    mname,' ',
    lname) as empname,
    emp_school,
    c.college_name,
    c.college_code AS school,
    d.designation_name,
    designation,
    dt.department_name,
    l.reason,
    -- Count for Today (applied_from_date or applied_to_date overlaps with today)
    SUM(CASE 
            WHEN 
                (CASE WHEN l.applied_from_date = '1970-01-01' THEN l.applied_to_date ELSE l.applied_from_date END) <= '$date' 
            AND 
                (CASE WHEN l.applied_to_date = '1970-01-01' THEN l.applied_from_date ELSE l.applied_to_date END) >= '$date' 
            THEN 
                DATEDIFF(LEAST((CASE WHEN l.applied_to_date = '1970-01-01' THEN l.applied_from_date ELSE l.applied_to_date END), '$date'), 
                         GREATEST((CASE WHEN l.applied_from_date = '1970-01-01' THEN l.applied_to_date ELSE l.applied_from_date END), '$date')) + 1
            ELSE 0 
        END) AS today_count,
    
    -- Cumulative Count (applied_from_date >= 2025-01-15)
     SUM(CASE 
    WHEN (CASE WHEN l.applied_from_date = '1970-01-01' THEN l.applied_to_date ELSE l.applied_from_date END) >= '2025-01-15' 
    THEN 
        DATEDIFF(
            LEAST(
                CASE 
                    WHEN (CASE WHEN l.applied_to_date = '1970-01-01' THEN l.applied_from_date ELSE l.applied_to_date END) > '$date' 
                    THEN '$date' 
                    ELSE (CASE WHEN l.applied_to_date = '1970-01-01' THEN l.applied_from_date ELSE l.applied_to_date END)
                END, 
                '$date'
            ), 
            (CASE WHEN l.applied_from_date = '1970-01-01' THEN l.applied_to_date ELSE l.applied_from_date END)
        ) + 1
    ELSE 0 
END)
 AS cumulative_count,
    
    -- Current Month Count (applied_from_date within current month)
      SUM(CASE 
    WHEN YEAR((CASE WHEN l.applied_from_date = '1970-01-01' THEN l.applied_to_date ELSE l.applied_from_date END)) = YEAR('$date') 
    AND MONTH((CASE WHEN l.applied_from_date = '1970-01-01' THEN l.applied_to_date ELSE l.applied_from_date END)) = MONTH('$date') 
    THEN 
        DATEDIFF(LEAST(
            CASE 
                WHEN (CASE WHEN l.applied_to_date = '1970-01-01' THEN l.applied_from_date ELSE l.applied_to_date END) > '$date' 
                THEN '$date' 
                ELSE (CASE WHEN l.applied_to_date = '1970-01-01' THEN l.applied_from_date ELSE l.applied_to_date END)
            END, 
            '$monthEnd'
        ), 
        GREATEST((CASE WHEN l.applied_from_date = '1970-01-01' THEN l.applied_to_date ELSE l.applied_from_date END), '$monthStart')) + 1
    ELSE 0 
END) AS current_month_count

FROM leave_applicant_list l
JOIN employee_master AS e ON l.emp_id = e.emp_id
LEFT JOIN designation_master AS d ON e.designation = d.designation_id
LEFT JOIN department_master AS dt ON e.department = dt.department_id
LEFT JOIN college_master AS c ON e.emp_school = c.college_id

WHERE leave_type IN (
    SELECT id FROM employee_leave_allocation WHERE academic_year = '2024-25'
) 
AND l.fstatus NOT IN ('Cancel', 'Rejected')
AND l.applied_from_date >= '2025-01-15'
AND c.college_name != 'General' and l.applied_from_date<='$date'

GROUP BY e.emp_id, fname, mname, lname, emp_school, c.college_name, c.college_code, 
         d.designation_name, designation, department

ORDER BY c.college_code;
";
$result=$this->db->query($sql)->result_array();
$this->data['leaves']=$result;
 $html = $this->load->view('dailyleavereport',$this->data,true);
// exit;
$date1=date('d-m-y');
$this->load->library('m_pdf');
		$mpdf=new mPDF();
		$this->m_pdf->pdf = new mPDF('L', 'A4-L', '', '', 5, 5, 5, 5, 5, 5);
		 $html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
		
		$this->m_pdf->pdf->WriteHTML($html);
		$pdfFilePath1 =$date1."-SUN_leave_report.pdf";
		$pdf_data=$this->m_pdf->pdf->Output('', "S");
		$body = "Hi Sir,<br>Please find Leave report.<br><br> Thanks,Sandip University";
		//$email='vighnesh.sukum@sandipuniversity.edu.in';
		$subject='SUN-Leave report-'.$date1;
		$this->send_mail($email,$subject,$body,$pdf_data,$pdfFilePath1);
}

     //////////////code by pranav
	 
	 
	  function send_daily_OD_report_sf($con=''){
	
	/*$date=date('Y-m-d');
	
	
	$monthEnd = date('Y-m-t');
	$monthStart = date('Y-m-01');
	*/
	$date=date('Y-m-d');
	$monthEnd = date('Y-m-t');
	$monthStart = date('Y-m-01');
	$c=" and e.campus_id=1";
	if($con==1){
		$c=" and e.campus_id=2";
		
	}
	
	 $sql=" select * from ((SELECT 
    e.emp_id,
    CONCAT(fname,' ',
    mname,' ',
    lname) as employee_name,
    emp_school,
    c.college_name,
    c.college_code AS school,
    d.designation_name,
    designation,
    dt.department_name AS department,
    l.reason,
	l.applied_from_date,
	l.applied_to_date,
	l.no_days,l.leave_duration,l.no_hrs,l.od_document   
		
FROM hrms.leave_applicant_list l
JOIN hrms.employee_master AS e ON l.emp_id = e.emp_id
LEFT JOIN hrms.designation_master AS d ON e.designation = d.designation_id
LEFT JOIN hrms.department_master AS dt ON e.department = dt.department_id
LEFT JOIN hrms.college_master AS c ON e.emp_school = c.college_id

WHERE leave_type IN ('OD') 
AND l.fstatus NOT IN ('Cancel', 'Rejected')
 and  e.campus_id=3 and e.staff_sub_type=31 and e.emp_school in (29,36,39,40,41,42,43,44,47)
AND c.college_name != 'General'  
GROUP BY e.emp_id, fname, mname, lname, emp_school, c.college_name, c.college_code, 
         d.designation_name, designation, department

ORDER BY l.applied_from_date desc)
) f order by applied_from_date


";
//and '$date' between l.applied_from_date and l.applied_to_date $c
$c='SUN';
$this->data['address']='Mahiravani, Trimbak Road, Nashik - 422 213';
if($con==1){
	$c='SUM';
	$this->data['address']='Neelam Vidya Vihar, Village Sijoul, P.O. Mailam, Madhubani, Bihar, India';
	$this->db=$this->load->database('sum_erp', TRUE);
}

$result=$this->db->query($sql)->result_array();

//

$this->data['OD']=$result;
$this->data['current_date']=$date;

     $html = $this->load->view('dailyODreport',$this->data,true);
	

$sql="SELECT 
    e.emp_id,
    CONCAT(fname,' ',
    mname,' ',
    lname) as empname,
    emp_school,
    c.college_name,
    c.college_code AS school,
    d.designation_name,
    designation,
    dt.department_name,
    l.reason,l.applied_from_date,
	l.applied_to_date,
	l.no_days,l.leave_duration,l.no_hrs 
    
    
   
    
   

FROM leave_applicant_list l
JOIN employee_master AS e ON l.emp_id = e.emp_id
LEFT JOIN designation_master AS d ON e.designation = d.designation_id
LEFT JOIN department_master AS dt ON e.department = dt.department_id
LEFT JOIN college_master AS c ON e.emp_school = c.college_id

WHERE leave_type IN (
    SELECT id FROM employee_leave_allocation WHERE academic_year = '2024-25'
) 
and '$date' between l.applied_from_date and l.applied_to_date
AND c.college_name != 'General'
AND l.fstatus NOT IN ('Cancel', 'Rejected')
AND l.applied_from_date >= '2025-01-15'
AND c.college_name != 'General' and l.applied_from_date<='$date'

GROUP BY e.emp_id, fname, mname, lname, emp_school, c.college_name, c.college_code, 
         d.designation_name, designation, department

ORDER BY c.college_code;
";

$result_leave=$this->db->query($sql)->result_array();

//

$this->data['leave']=$result_leave;
$this->data['current_date']=$date;

   
$html2 = $this->load->view('dailyleavereportnew',$this->data,true);


$fhmtl=$html2."<br><br><br><br>".$html;








		$date1=date('d-m-y');
		$this->load->library('m_pdf');
		$mpdf=new mPDF();
		$this->m_pdf->pdf = new mPDF('L', 'A4-L', '', '', 10, 10, 10, 10, 10, 10);
		 $html = mb_convert_encoding($fhmtl, 'UTF-8', 'UTF-8');
		
		$this->m_pdf->pdf->WriteHTML($html);
		$pdfFilePath1 =$c."_OD_LEAVE_REPORT_".$date1.".pdf";
		$pdf_data=$this->m_pdf->pdf->Output('', "D");
		
		$body = "Hi Sir,<br>Please find OD AND LEAVE report.<br><br> Thanks,Sandip University";
		//$email='vighnesh.sukum@sandipuniversity.edu.in';
		$subject=$c.'_OD_LEAVE_REPORT-'.$date1;
		$this->send_mail($email,$subject,$body,$pdf_data,$pdfFilePath1);
}

	 
	 
	 function send_daily_OD_report($con=''){
	
	/*$date=date('Y-m-d');
	
	
	$monthEnd = date('Y-m-t');
	$monthStart = date('Y-m-01');
	*/
	$date=date('Y-m-d');
	$monthEnd = date('Y-m-t');
	$monthStart = date('Y-m-01');
	$c=" and e.campus_id=1";
	if($con==1){
		$c=" and e.campus_id=2";
		
	}
	
	 $sql=" select * from ((SELECT 
    e.emp_id,
    CONCAT(fname,' ',
    mname,' ',
    lname) as employee_name,
    emp_school,
    c.college_name,
    c.college_code AS school,
    d.designation_name,
    designation,
    dt.department_name AS department,
    l.reason,
	l.applied_from_date,
	l.applied_to_date,
	l.no_days,l.leave_duration,l.no_hrs,l.od_document   
		
FROM hrms.leave_applicant_list l
JOIN hrms.employee_master AS e ON l.emp_id = e.emp_id
LEFT JOIN hrms.designation_master AS d ON e.designation = d.designation_id
LEFT JOIN hrms.department_master AS dt ON e.department = dt.department_id
LEFT JOIN hrms.college_master AS c ON e.emp_school = c.college_id

WHERE leave_type IN ('OD') 
AND l.fstatus NOT IN ('Cancel', 'Rejected')
 and  e.campus_id=1 and e.staff_sub_type=31
AND c.college_name != 'General' and e.emp_id in ('110048','110052','110073','110074','110077','110140','110145','110194','110353','110382','110384','110391','110395','110396','110400','110404','110407','110408','110409','110416','110418','110425','110427','110430','110431','110432','110436','110442','110443','110444','110449','110463','110464','110467','110477','110478','110486','110493','110494','110495','110496','110498','110503','110504','110506','110507','110508','110509','110512','110513','110518','110522','110526','110528','110534','110537','110545','110548','110550','110551','110555','110559','110562','110568','110569','110570','110571','110573','110575','110577','110578','110580','110583','110588','110592','110593','110594','110595','110596','110600','110601','110603','110604','110605','110606','110607','110609','110610','110611','110612','110613','110614','110615','110617','110618','110620','110623','110624','110627','210527','211253','211569','211570','211571','211573','211574','211575','211577','211578','211579','211582','211589','211592','211594','211596','211604','211607','211608','211610','211613','211615','211621','211623','211631','211636','211639','211640','211642','211643','211645','211647','211648','211653','211654','211656','211661','211662','211668','211672','211674','211677','211679','211681','211683','211687','211694','211702','211703','211710','211711','211716','211721','211724','211730','211734','211736','211739','211742','211745','211747','211751','211754','211756','211760','211764','211766','211775','211776','211777','211779','211783','211789','211791','211795','211802','211808','211810','211871','211877','211886','211890','211891','211894','211903','211942','211943','211946','211951','211964','211965','211991','212012','212023','212024','212025','212036','212079','212114','212155','212176','212177','212178','212179','212183','212374','212376','212378','212383','212390','212391','212394','212395','212396','212397','212412','212416','212417','212421','212422','212425','212426','212428','212440','212442','212443','212444','212445','212449','212450','212451','212454','212455','212456','212461','212489','212508','212509','212515','212526','212538','662479','662623','662639','662649','662656','662657','662658','662660','662663','662666','662692','662698','662699','662703','662706','662709','662713','662716','662717','662718','662719','662720','662721','662722','662723','662724','662725','662726','662727','662728','662729','662730') 
GROUP BY e.emp_id, fname, mname, lname, emp_school, c.college_name, c.college_code, 
         d.designation_name, designation, department

ORDER BY l.applied_from_date desc)

UNION

(SELECT 
    e.emp_id,
    CONCAT(fname,' ',
    mname,' ',
    lname) as employee_name,
    emp_school,
    c.college_name,
    c.college_code AS school,
    d.designation_name,
    designation,
    dt.department_name AS department,
    l.reason,
	l.applied_from_date,
	l.applied_to_date,
	l.no_days,l.leave_duration,l.no_hrs,l.od_document   
		
FROM leave_applicant_list l
JOIN employee_master AS e ON l.emp_id = e.emp_id
LEFT JOIN designation_master AS d ON e.designation = d.designation_id
LEFT JOIN department_master AS dt ON e.department = dt.department_id
LEFT JOIN college_master AS c ON e.emp_school = c.college_id

WHERE leave_type IN ('OD') 
AND l.fstatus NOT IN ('Cancel', 'Rejected')

AND c.college_name != 'General' and e.emp_id in ('110048','110052','110073','110074','110077','110140','110145','110194','110353','110382','110384','110391','110395','110396','110400','110404','110407','110408','110409','110416','110418','110425','110427','110430','110431','110432','110436','110442','110443','110444','110449','110463','110464','110467','110477','110478','110486','110493','110494','110495','110496','110498','110503','110504','110506','110507','110508','110509','110512','110513','110518','110522','110526','110528','110534','110537','110545','110548','110550','110551','110555','110559','110562','110568','110569','110570','110571','110573','110575','110577','110578','110580','110583','110588','110592','110593','110594','110595','110596','110600','110601','110603','110604','110605','110606','110607','110609','110610','110611','110612','110613','110614','110615','110617','110618','110620','110623','110624','110627','210527','211253','211569','211570','211571','211573','211574','211575','211577','211578','211579','211582','211589','211592','211594','211596','211604','211607','211608','211610','211613','211615','211621','211623','211631','211636','211639','211640','211642','211643','211645','211647','211648','211653','211654','211656','211661','211662','211668','211672','211674','211677','211679','211681','211683','211687','211694','211702','211703','211710','211711','211716','211721','211724','211730','211734','211736','211739','211742','211745','211747','211751','211754','211756','211760','211764','211766','211775','211776','211777','211779','211783','211789','211791','211795','211802','211808','211810','211871','211877','211886','211890','211891','211894','211903','211942','211943','211946','211951','211964','211965','211991','212012','212023','212024','212025','212036','212079','212114','212155','212176','212177','212178','212179','212183','212374','212376','212378','212383','212390','212391','212394','212395','212396','212397','212412','212416','212417','212421','212422','212425','212426','212428','212440','212442','212443','212444','212445','212449','212450','212451','212454','212455','212456','212461','212489','212508','212509','212515','212526','212538','662479','662623','662639','662649','662656','662657','662658','662660','662663','662666','662692','662698','662699','662703','662706','662709','662713','662716','662717','662718','662719','662720','662721','662722','662723','662724','662725','662726','662727','662728','662729','662730') and l.applied_from_date>='2025-01-01'
GROUP BY e.emp_id, fname, mname, lname, emp_school, c.college_name, c.college_code, 
         d.designation_name, designation, department

ORDER BY l.applied_from_date desc) ) f order by applied_from_date


";
//and '$date' between l.applied_from_date and l.applied_to_date $c
$c='SUN';
$this->data['address']='Mahiravani, Trimbak Road, Nashik - 422 213';
if($con==1){
	$c='SUM';
	$this->data['address']='Neelam Vidya Vihar, Village Sijoul, P.O. Mailam, Madhubani, Bihar, India';
	$this->db=$this->load->database('sum_erp', TRUE);
}

$result=$this->db->query($sql)->result_array();

//

$this->data['OD']=$result;
$this->data['current_date']=$date;

     $html = $this->load->view('dailyODreport',$this->data,true);
	

$sql="SELECT 
    e.emp_id,
    CONCAT(fname,' ',
    mname,' ',
    lname) as empname,
    emp_school,
    c.college_name,
    c.college_code AS school,
    d.designation_name,
    designation,
    dt.department_name,
    l.reason,l.applied_from_date,
	l.applied_to_date,
	l.no_days,l.leave_duration,l.no_hrs 
    
    
   
    
   

FROM leave_applicant_list l
JOIN employee_master AS e ON l.emp_id = e.emp_id
LEFT JOIN designation_master AS d ON e.designation = d.designation_id
LEFT JOIN department_master AS dt ON e.department = dt.department_id
LEFT JOIN college_master AS c ON e.emp_school = c.college_id

WHERE leave_type IN (
    SELECT id FROM employee_leave_allocation WHERE academic_year = '2024-25'
) 
and '$date' between l.applied_from_date and l.applied_to_date
AND c.college_name != 'General'
AND l.fstatus NOT IN ('Cancel', 'Rejected')
AND l.applied_from_date >= '2025-01-15'
AND c.college_name != 'General' and l.applied_from_date<='$date'

GROUP BY e.emp_id, fname, mname, lname, emp_school, c.college_name, c.college_code, 
         d.designation_name, designation, department

ORDER BY c.college_code;
";

$result_leave=$this->db->query($sql)->result_array();

//

$this->data['leave']=$result_leave;
$this->data['current_date']=$date;

   
$html2 = $this->load->view('dailyleavereportnew',$this->data,true);


$fhmtl=$html2."<br><br><br><br>".$html;








		$date1=date('d-m-y');
		$this->load->library('m_pdf');
		$mpdf=new mPDF();
		$this->m_pdf->pdf = new mPDF('L', 'A4-L', '', '', 10, 10, 10, 10, 10, 10);
		 $html = mb_convert_encoding($fhmtl, 'UTF-8', 'UTF-8');
		
		$this->m_pdf->pdf->WriteHTML($html);
		$pdfFilePath1 =$c."_OD_LEAVE_REPORT_".$date1.".pdf";
		$pdf_data=$this->m_pdf->pdf->Output('', "D");
		
		$body = "Hi Sir,<br>Please find OD AND LEAVE report.<br><br> Thanks,Sandip University";
		//$email='vighnesh.sukum@sandipuniversity.edu.in';
		$subject=$c.'_OD_LEAVE_REPORT-'.$date1;
		$this->send_mail($email,$subject,$body,$pdf_data,$pdfFilePath1);
}

function send_sum_leave_report(){
	$this->send_daily_OD_report(1);
}


function send_sun_leave_report(){
	$this->send_daily_OD_report();
}





function mailtopendngapprovals(){
			
			$currentMonth = date('m');  // Current month (01 to 12)
			$currentYear = date('Y');

			$query=' SELECT l.lid,
			l.emp1_reporting_person, 
			e.fname, 
			e.lname, 
			eod.oemail, 
			l.reason,fm.fname as ename,fm.email_id,
			CASE WHEN eod.oemail !="" THEN eod.oemail
			WHEN fm.email_id !="" THEN fm.email_id
			ELSE "" END AS mailtosent,
			CONCAT(le.fname," ", 
			le.lname) as leave_taken_by,
			le.emp_id as leave_byemp_id
			
			FROM 
			leave_applicant_list AS l
			LEFT JOIN 
			employee_master AS e ON l.emp1_reporting_person = e.emp_id
			LEFT JOIN 
			employe_other_details AS eod ON l.emp1_reporting_person = eod.emp_id
			LEFT JOIN 
			sandipun_ums.faculty_master AS fm ON l.emp1_reporting_person = CONCAT("v_", fm.emp_id)
			
			left join employee_master as le on l.emp_id=le.emp_id
			
			
			WHERE 
			l.fstatus = "Pending"  AND (l.leave_apply_type = "leave" OR l.leave_apply_type = "OD")
			AND MONTH(l.applied_from_date)="'.$currentMonth.'" AND YEAR(l.applied_from_date)="'.$currentYear.'" GROUP BY mailtosent
			';
          
			$data=$this->db->query($query)->result();
              
			 
			  
			  
			$sub='Request to kindly take actions against Pending Leave/OD Approvals';
			
			if(!empty($data)){
			foreach($data as $row){
            $body='<div>Dear Sir,<p>Request to kindly take actions against Pending Leave/OD Approvals.</p>
			<p>Emp id:'.$row->leave_byemp_id.'</p>
			<p>Employee Name:'.$row->leave_taken_by.'</p>
			
			<p>Regards,</p>
			<p>Sandip University</p>
			 </div>';
			//$row->mailtosent='vighnesh.sukum@sandipuniversity.edu.in';
			$this->send_leave_mail($row->mailtosent,$sub,$body);
			
			
			}
			}
			
			
		}
  
  
  
public function send_leave_mail($addres,$sub,$body){

$this->load->library('Message_api');
$obj = New Message_api();

$newaddress=$addres;
$from='noreply7@sandipuniversity.edu.in';
$bcc='';
if(!empty($addres)){
$cursession = $obj->sendattachedemail($body,$sub,$file,$newaddress,$cc,$bcc,$from);
}
    return '1';
}

  public function forgot_password() {
    $data = array('msg' => '');
    if ($this->input->post('prn')) {
        $prn = $this->security->xss_clean($this->input->post('prn'));
        $user_val = array_shift($this->login_model->get_student_for_forgot_password($prn));
        if (!empty($user_val)) {
            // Get mobile number for OTP
            $mob = $user_val  ?? '';
            if ($mob != '') {
                $otp = rand(100000, 999999);
                $otp_data = array('otp' => $otp);
                $this->db->where('stud_id', $user_val['stud_id']);
                $this->db->update('sandipun_ums.student_master', $otp_data);
                $this->login_model->send_otp_via_api($otp, $mob);
                $_SESSION['otp'] = $otp;
                $_SESSION['otp_sent_at'] = time();
                $_SESSION['otp_expiry_time'] = 300;
                $_SESSION['prn'] = $prn;
                $this->session->set_flashdata('msg', 'OTP has been sent to your registered mobile number.');
                redirect('login/forgot_password_otp');
                return;
            } else {
                $data['msg'] = 'Mobile Number Not Registered. Kindly Register it.';
            }
        } else {
            $data['msg'] = 'Invalid PRN Number.';
        }
    }
    $this->load->view('forgot_password', $data);
}

public function forgot_password_otp() {
    $msg = '';
    if ($this->input->post('otp')) {
        $entered_otp = $this->input->post('otp');
        $session_otp = isset($_SESSION['otp']) ? $_SESSION['otp'] : null;
        $otp_sent_at = isset($_SESSION['otp_sent_at']) ? $_SESSION['otp_sent_at'] : 0;
        $otp_expiry = isset($_SESSION['otp_expiry_time']) ? $_SESSION['otp_expiry_time'] : 300;
        $cut = time() - $otp_expiry;
        if ($entered_otp == $session_otp && $otp_sent_at >= $cut) {
            unset($_SESSION['otp']);
            unset($_SESSION['otp_sent_at']);
            unset($_SESSION['otp_expiry_time']);
            $this->session->set_flashdata('msg', 'OTP verified. Please set your new password.');
            redirect('login/forgot_password_reset');
            return;
        } else {
            $msg = 'Invalid or expired OTP. Please try again.';
        }
    }
    $this->session->set_flashdata('msg', $msg);
    $this->load->view('forgot_password_otp');
}

public function forgot_password_reset_aman() {
    $msg = '';
    if ($this->input->post('password') && $this->input->post('confirm_password')) {
        $password = $this->input->post('password');
        $confirm_password = $this->input->post('confirm_password');
        $valid = $this->valid_password($password);
        if ($valid !== true) {
            $msg = $valid;
        } else if ($password !== $confirm_password) {
            $msg = 'Passwords do not match.';
        } else if (!isset($_SESSION['prn'])) {
            $msg = 'Session expired. Please try again.';
            redirect('login/forgot_password');
            return;
        } else {
            $prn = $_SESSION['prn'];
            $user = $this->db->where('username', $prn)->get('sandipun_ums.user_master')->row_array();
            $um_id = $user ? $user['um_id'] : $prn;
            $this->load->library('Password');
            $hashed_password = $this->password->encrypt_password($password, $um_id);
            $this->db->where('username', $prn);
            $this->db->update('sandipun_ums.user_master', array('password' => $hashed_password, 'is_password_reset' => 1));
            unset($_SESSION['prn']);
            $this->session->set_flashdata('msg', 'Password changed successfully. Please login.');
            redirect('login');
            return;
        }
    }
    $this->session->set_flashdata('msg', $msg);
    $this->load->view('forgot_password_reset');
}
public function valid_password($password = '')
{
    $password = trim($password);
    $regex_lowercase = '/[a-z]/';
    $regex_uppercase = '/[A-Z]/';
    $regex_number = '/[0-9]/';
    $regex_special = '/[!@#$%^&*()\-_=+{};:,<.>ยง~]/';
    if (empty($password)) {
        return 'Password is required.';
    }
    if (preg_match_all($regex_lowercase, $password) < 1) {
        return 'Password must have at least one lowercase letter.';
    }
    if (preg_match_all($regex_uppercase, $password) < 1) {
        return 'Password must have at least one uppercase letter.';
    }
    if (preg_match_all($regex_number, $password) < 1) {
        return 'Password must have at least one number.';
    }
    if (preg_match_all($regex_special, $password) < 1) {
        return 'Password must have at least one special character.';
    }
    if (strlen($password) < 8) {
        return 'Password must be at least 8 characters.';
    }
    if (strlen($password) > 32) {
        return 'Password cannot exceed 32 characters.';
    }
    return true;
}	 
///////////////////////////	 
public function forgot_password_reset() {
    $msg = '';
    if ($this->input->post('password') && $this->input->post('confirm_password')) {
        $password = $this->input->post('password');
        $confirm_password = $this->input->post('confirm_password');

        // Password validation
        $valid = true;
        if (strlen($password) < 8) {
            $msg = 'Password must be at least 8 characters long.';
            $valid = false;
        } else if (!preg_match('/[A-Za-z]/', $password)) {
            $msg = 'Password must contain at least one letter.';
            $valid = false;
        } else if (!preg_match('/[0-9]/', $password)) {
            $msg = 'Password must contain at least one number.';
            $valid = false;
        } else if (!preg_match('/[^A-Za-z0-9]/', $password)) {
            $msg = 'Password must contain at least one special character.';
            $valid = false;
        } else if ($password !== $confirm_password) {
            $msg = 'Passwords do not match.';
            $valid = false;
        } else if (!isset($_SESSION['prn'])) {
            $msg = 'Session expired. Please try again.';
            redirect('login/forgot_password');
            return;
        }

        if ($valid) {
            $prn = $_SESSION['prn'];

            // Fetch user data by PRN (username)
            $query = $this->db->get_where('sandipun_ums.user_master', ['username' => $prn]);
            $user = $query->row_array();

            if ($user) {
                // Encrypt password using Password class logic
                $this->load->library('password'); // Ensure this is loaded correctly
                $encrypted_password = $this->password->encrypt_password($password, $prn);
                
                // Prepare update data
                $update_data = [
                    'password' => $encrypted_password,
                    'is_password_reset' => 1,
                    'updated_by' => $user['um_id'], // Or 0 if unknown
                    'updated_datetime' => date('Y-m-d H:i:s')
                ];

                $this->db->where('username', $prn);
                $this->db->update('sandipun_ums.user_master', $update_data);

                unset($_SESSION['prn']);
                $this->session->set_flashdata('msg', 'Password changed successfully. Please login.');
                redirect('login');
                return;
            } else {
                $msg = 'User not found. Please try again.';
            }
        }
    }

    $this->session->set_flashdata('msg', $msg);
    $this->load->view('forgot_password_reset');
}

	
}