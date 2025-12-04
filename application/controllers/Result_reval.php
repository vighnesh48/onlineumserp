<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Result_reval extends CI_Controller{

	var $currentModule = "";   
	var $title = "";   
	var $table_name = "";    
	var $model_name = "Result_reval_model";   
	var $model;  
	var $view_dir = 'result_reval/';
 
	public function __construct(){        
 		global $menudata;      
		parent::__construct();       
		$this->load->helper("url");     
		$this->load->library('form_validation');        
		 if($this->uri->segment(2) != "" && $this->uri->segment(2) != "submit" && !in_array($this->uri->segment(2), $this->skipActions))
		$title = $this->uri->segment(2); //Second segment of uri for action,In case of edit,view,add etc.       
		else
		$title = $this->master_arr['index'];
		$this->currentModule = $this->uri->segment(1);    
		$this->data['currentModule'] = $this->currentModule;       
		$this->data['model_name'] = $this->model_name;             
		$this->load->library('form_validation');       
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $this->load->model('Results_model');
		$model = $this->load->model($this->model_name);
		$menu_name = $this->uri->segment(1);
        //15
 		 $this->session->userdata("role_id");
		if(($this->session->userdata("role_id")==15)||($this->session->userdata("role_id")==14)){}else{
			redirect('home');
			} 
		$this->data['my_privileges'] = $this->retrieve_privileges($menu_name); 
         
	}
	
	    public function exam_result_update($result_data='')
	  {
		 //$exam_id=$_POST['exam_id'];
		 $result_data=$_POST['res_data'];
		 if(!empty($result_data)){
		  $subdetails = explode('~', $result_data);
		  $school_code  =$subdetails[0];
		  $stream =$subdetails[1];
		  $semester =$subdetails[2];
		  $exam_month =$subdetails[3];
		  $exam_year =$subdetails[4];
		  $exam_id =$subdetails[5];
		
		  $result=$this->Result_reval_model->exam_result_update($stream,$semester,$exam_id);
		 }
		  if($result)
		  {
			   //$this->session->set_flashdata('msg',"Data Updated successfully.");
			 //  redirect('Result_reval/entry_reval_status');
			   echo "success";
		  }
		  else
		  {
			   //$this->session->set_flashdata('msg1',"Something Wrong!!!");
			   //redirect('Result_reval/entry_reval_status');
			   echo "Not success";
		  }	
		  
		
	  }
	  
	public function generate_reval()
    {
      $this->load->model('Exam_timetable_model');
      if($_POST)
      {
        $this->load->view('header',$this->data);        
		$this->data['school_code'] =$_POST['school_code'];
		$this->data['admissioncourse'] =$_POST['admission-course'];
		$this->data['stream'] =$_POST['admission-branch'];
		$this->data['exam'] =$_POST['exam_session'];
		$this->data['exam_session']= $this->Result_reval_model->fetch_result_exam_session();
		$this->data['course_details']= $this->Exam_timetable_model->getCollegeCourse();
		$this->data['schools']= $this->Exam_timetable_model->getSchools();
		$exam= explode('-', $_POST['exam_session']);

		$exam_month =$exam[0];
		$exam_year =$exam[1];
		$exam_id =$exam[2];
		$this->data['exam_month'] =$exam_month;
		$this->data['exam_year'] =$exam_year;
		$this->data['exam_id'] =$exam_id;
		$this->data['stream_list']= $this->Result_reval_model->get_reval_result_stream_data($_POST['admission-branch'],$exam_id);
		$this->load->view($this->view_dir.'generate_reval_result_view',$this->data);		
        $this->load->view('footer');    
      }
      else
      {   
		
        $this->load->view('header',$this->data); 
		$this->data['school_code'] ='';
		$this->data['admissioncourse'] = '';
		$this->data['stream'] = '';
		$this->data['semester'] = '';	
		$this->data['exam_session']= $this->Result_reval_model->fetch_result_exam_session();
		$this->data['course_details']= $this->Exam_timetable_model->getCollegeCourse();
		$this->data['schools']= $this->Exam_timetable_model->getSchools();
        $this->load->view($this->view_dir.'generate_reval_result_view',$this->data);
        $this->load->view('footer');     
      }       
    }
	
	public function entry_reval_status()
	{
	    $this->load->model('Exam_timetable_model');
		$this->load->model('Results_model');
	    if($_POST)
	    {
	        $this->load->view('header',$this->data);
	        $this->data['school_code'] =$_POST['school_code'];
	        $this->data['admissioncourse'] =$_POST['admission-course'];
	        $this->data['stream'] =$_POST['admission-branch'];
	        $this->data['semester'] =$_POST['semester'];
	        $this->data['exam'] =$_POST['exam_session'];
	        $this->data['marks_type'] =$_POST['marks_type'];
	        $this->data['exam_session']= $this->Results_model->fetch_result_exam_session();
	        $this->data['course_details']= $this->Exam_timetable_model->getCollegeCourse();
	        $this->data['schools']= $this->Exam_timetable_model->getSchools();
	        $exam= explode('-', $_POST['exam_session']);
	        $exam_month =$exam[0];
	        $exam_year =$exam[1];
	        $exam_id =$exam[2];
	        $this->data['exam_month']= $exam_month;
			$this->data['exam_year']= $exam_year;
			$this->data['exam_id']= $exam_id;
			$this->load->model('Results_model');
			$this->data['chk1'] = $this->Results_model->check_for_duplicate_result($_POST['admission-branch'], $_POST['semester'], $exam_month, $exam_year, $exam_id);
	        $this->data['sub_list']= $this->Result_reval_model->list_exam_subjects_for_status_applied($_POST, $exam_id);

	        $this->load->view($this->view_dir.'reval_marks_entry_status',$this->data);	        
	        $this->load->view('footer');
	    }
	    else
	    {
	        $this->load->view('header',$this->data);
	        $this->data['school_code'] ='';
	        $this->data['admissioncourse'] = '';
	        $this->data['stream'] = '';
	        $this->data['semester'] = '';	        
	        $this->data['exam_session']=$this->Results_model->fetch_result_exam_session();
	        $this->data['course_details']= $this->Exam_timetable_model->getCollegeCourse();
	        $this->data['schools']= $this->Exam_timetable_model->getSchools();
	        $this->load->view($this->view_dir.'reval_marks_entry_status',$this->data);
	        $this->load->view('footer');	        
	    }	    
	} 
		
	  public function grade_generation_reval()
    {        
         $result_data = $_POST['res_data']; 
        $res_detail_id = $_POST['res_detail_id'];
		$emp_id = $this->session->userdata("name");
		$DB1 = $this->load->database('umsdb', TRUE);
		$subdetails = explode('~', $result_data);

		$school_code  =$subdetails[0];
		$stream =$subdetails[1];
		$exam_month =$subdetails[2];
		$exam_year =$subdetails[3];
		$exam_id =$subdetails[4];
		$semester =$subdetails[5];
		$res_data['school_id'] = $school_code;
		$res_data['stream_id'] = $stream;
		$res_data['semester'] = $semester;
		$res_data['exam_id'] = $exam_id;
		$res_data['exam_month'] = $exam_month;
		$res_data['exam_year'] = $exam_year;
		$res_data['entry_by'] = $this->session->userdata("uid");
		$res_data['entry_on'] = date('Y-m-d H:i:s');
		$res_data['entry_ip'] = $this->input->ip_address();

        $result_info = $this->Result_reval_model->fetch_result_data_for_grade($result_data);

		$grade_rule = $this->Results_model->fetch_gread_rule($stream);
		$grd_rule = $grade_rule[0]['grade_rule'];

		$student_subjets=array();
		$grace =array('1'); //grace marks array
		$moderate_marks = array('1','2','3'); //moderate marks array
		foreach ($result_info as $res) {

			$stud_id = $res['student_id'];
			$sub = $this->Result_reval_model->fetch_reslt_subjects($result_data,$stud_id);
			
			foreach ($sub as $key => $val) {

				$subject = $val['subject_id'];
				$subdet = $this->Result_reval_model->fetch_subject_details($subject); // fetching subject details from subject master
                 	
				$cia_max_mrks = $subdet[0]['internal_max'];
				$internal_min_for_pass = $subdet[0]['internal_min_for_pass'];
				$theory_max = $subdet[0]['theory_max'];
				$th_min_mrks = $subdet[0]['theory_min_for_pass'];
				$sub_max = $subdet[0]['sub_max'];
				$sub_min = $subdet[0]['sub_min'];
				
				$practical_max = $subdet[0]['practical_max'];
				$practical_min_for_pass = $subdet[0]['practical_min_for_pass'];
				
				if($subdet[0]['subject_component']=='EM'){
					$ciamax = $this->Results_model->fetch_max_marks_cia($stream,$exam_id,$semester,$subject);
					$thmax = $this->Results_model->fetch_max_marks_theory($stream,$exam_id,$semester,$subject);
					$prmax = $this->Results_model->fetch_max_marks_practcal($stream,$exam_id,$semester,$subject);
					
					$thobtmrk = $this->Results_model->fetch_thobtained_marks($result_data,$stud_id,$subject);
					$probtmrk = $this->Results_model->fetch_probtained_marks($result_data,$stud_id,$subject);
					$ciaobtmrk = $this->Results_model->fetch_ciaobtained_marks($result_data,$stud_id,$subject);
					
					$theory_obt_marks= $thobtmrk[0]['marks'];
					$pract_obt_marks= $val['reval_marks'];
					$cia_obt_marks= $ciaobtmrk[0]['cia_marks'];
					
					$data['exam_marks']= $pract_obt_marks;
					$data['cia_marks']= $cia_obt_marks;
					$data['practical_marks']= $theory_obt_marks;
					//echo 'subjectid-'.$subject.', ';
					if($cia_max_mrks >0 && $theory_max >0 && $practical_max >0){
							//for theory
							$exam_grade_marks =(100 * ($theory_obt_marks / $prmax[0]['max_marks'])) /2;
							$exam_min_marks=100 * ($practical_min_for_pass/ $practical_max);
							$exam_grade_marks1 =(100 * ($theory_obt_marks / $prmax[0]['max_marks']));
							//for CIA
							$cia_garde_marks = 50 * ($cia_obt_marks / $ciamax[0]['max_marks']);	
							$cia_min_marks = 50 * ($internal_min_for_pass/ $cia_max_mrks);
							//for practical
							$pr_garde_marks = 50 * ($pract_obt_marks / $thmax[0]['max_marks']);	
							$pr_min_marks = 50 * ($th_min_mrks/ $theory_max);									
					}

					$cia_th_grade_marks = ($cia_garde_marks+$pr_garde_marks)/2;//exit;
					$data['cia_garde_marks']= $cia_th_grade_marks;
					$data['exam_grade_marks']= $exam_grade_marks;
						
					$data['final_garde_marks']= round($exam_grade_marks + $cia_th_grade_marks);  // addition of theory + cia marks 

					$sub_max_marks[] = $subdet[0]['sub_max'];          // exam result master
					$sub_final_marks[] = $theory_obt_marks+$cia_obt_marks+$pract_obt_marks;
					$final_garde_marks = $data['final_garde_marks'];
					
					if(($cia_garde_marks < $cia_min_marks) && $cia_obt_marks !=NULL){  
                      //echo 'inside1';
					$finalgrade = 'U';
					$data['final_grade'] = 'U';
					//$data['result_grade'] = 'U';
					$data['reval_grade'] = 'U';
					$th_garce_required = '0';
					$sub_garce_required = '0';
					$data['garce_marks'] = '';

				}elseif(($pr_garde_marks < $pr_min_marks) && $pract_obt_marks !=NULL){
                echo 'inside2';
					$finalgrade = 'U';
					$data['final_grade'] = 'U';
					//$data['result_grade'] = 'U';
					$data['reval_grade'] = 'U';
					$th_garce_required = '0';
					$sub_garce_required = '0';
					$data['garce_marks'] = '';

				}elseif(($exam_grade_marks1 < $exam_min_marks) && $theory_obt_marks !=NULL){
          //echo 'inside3';
					$finalgrade = 'U';
					$data['final_grade'] = 'U';
				//	$data['result_grade'] = 'U';
					$data['reval_grade'] = 'U';
					$th_garce_required = '0';
					$sub_garce_required = '0';
					$data['garce_marks'] = '';

				}elseif($final_garde_marks < $sub_min){
				 // echo 'inside4';  
						$sub_mrk_diff = $sub_min - $final_garde_marks;        // calculating difference 
						
						if(in_array($sub_mrk_diff, $grace)){
							$final_garde_marks = $final_garde_marks;             // if difference is between grace array then applying grace of 1 marks
							$data['garce_marks'] = 1;
							$sub_garce_required = '1';
							$grade = $this->Result_reval_model->fetch_grade($final_garde_marks+1,$grd_rule);
							//$data['result_grade'] = $grade[0]['grade_letter'];
							$data['reval_grade'] = $grade[0]['grade_letter'];
							$data['final_grade'] = $grade[0]['grade_letter'];
							$finalgrade = $grade[0]['grade_letter'];
						}else{
						    
						    if(in_array($sub_mrk_diff, $moderate_marks)){         // condition for moderate marks
        					    $data['moderate_marks'] = $sub_mrk_diff;
        				    }
						    
							$finalgrade = 'U';
							$data['final_grade'] = 'U';
                          // $data['result_grade'] = 'U';
                            $data['reval_grade'] = 'U';
							$th_garce_required = '0';
							$sub_garce_required = '0';
							$data['garce_marks'] = '';
							
						}
				
				}else{
				    if($stream==71){
				    	if($final_garde_marks >=40){
				    		$grade[0]['grade_letter'] ='P';	
				    	}else{
				    		$grade[0]['grade_letter'] ='U';	
				    	}
				    	
				    }else if($stream=='116' || $stream=='119' || $stream=='170'){
						$grade = $this->Result_reval_model->fetch_grade_pharma($final_garde_marks,$grd_rule);
					}else{
						$grade = $this->Result_reval_model->fetch_grade($final_garde_marks,$grd_rule);
					}

					$data['reval_grade'] = $grade[0]['grade_letter'];
					$data['final_grade'] = $grade[0]['grade_letter'];
					$finalgrade = $grade[0]['grade_letter'];
					$data['garce_marks'] = '';
					$th_garce_required = '0';
				}
				
			}else{
	                
					if($subdet[0]['subject_component']=='TH'){
					$theory_max = $subdet[0]['theory_max'];
					$th_min_mrks=$th_min_mrks;
				}else{
					$theory_max = $subdet[0]['practical_max'];
					$th_min_mrks =$subdet[0]['practical_min_for_pass'];
				}
				//echo $subject;exit;
				$thprmax = $this->Result_reval_model->fetch_max_marks_thpr($stream,$exam_id,$semester,$subject); // fetching subject max_marks from marks_entry
				$ciamax = $this->Result_reval_model->fetch_max_marks_cia($stream,$exam_id,$semester,$subject);
				// fetching obtained marks 
				//$theory_obt_marks= $val['exam_marks'];
				$theory_obt_marks= $val['reval_marks'];
				$cia_obt_marks= $val['cia_marks'];

				
				if($stream==71){      // for D-Pharma results 80-20 pattern
					$exam_grade_marks =80 * ($theory_obt_marks / $theory_max);
					$exam_min_marks=80 * ($th_min_mrks / $theory_max);
					$cia_garde_marks = 20 * ($cia_obt_marks / $cia_max_mrks);	
					$cia_min_marks = 20 * ($internal_min_for_pass/ $cia_max_mrks);	
					$exam_grade_marks1 =(80 * ($theory_obt_marks / $theory_max));
				    	
				 }elseif($stream=='116' || $stream=='119' || $stream=='170'){
					 if($cia_max_mrks >0 && $theory_max >0){
						$exam_grade_marks =$theory_obt_marks;
						$exam_min_marks=$th_min_mrks;
						$cia_garde_marks = $cia_obt_marks;	
						$cia_min_marks = $internal_min_for_pass;	
						$exam_grade_marks1 =$theory_obt_marks;
							
					}elseif($cia_max_mrks ==0 && $theory_max >0){					
						$exam_grade_marks = $theory_obt_marks;
						$exam_min_marks=$th_min_mrks;
						$exam_grade_marks1 =$theory_obt_marks;
						$cia_garde_marks=NULL;					
					}elseif($cia_max_mrks >0 && $theory_max ==0){
						$cia_garde_marks = $cia_obt_marks;	
						$cia_min_marks = $internal_min_for_pass;			
						$exam_grade_marks=NULL;	
					}else{		
					}
				 }else{

					if($cia_max_mrks >0 && $theory_max >0){

						$exam_grade_marks =(100 * ($theory_obt_marks / $theory_max)) /2;
						$exam_min_marks=100 * ($th_min_mrks / $theory_max);
						$cia_garde_marks = 50 * ($cia_obt_marks / $cia_max_mrks);	
						$cia_min_marks = 50 * ($internal_min_for_pass/ $cia_max_mrks);	
						$exam_grade_marks1 =(100 * ($theory_obt_marks / $theory_max));
							
					}elseif($cia_max_mrks ==0 && $theory_max >0){					
						$exam_grade_marks = (100 * ($theory_obt_marks / $theory_max));
						$exam_min_marks=100 * ($th_min_mrks / $theory_max);
						$exam_grade_marks1 =(100 * ($theory_obt_marks / $theory_max));
						$cia_garde_marks=NULL;					
					}elseif($cia_max_mrks >0 && $theory_max ==0){
						$cia_garde_marks = (50 * ($cia_obt_marks / $cia_max_mrks)) *2;	
						$cia_min_marks = 50 * ($internal_min_for_pass/ $cia_max_mrks);			
						$exam_grade_marks=NULL;	
					}else{		
					}
				}
				/////////////////////////////////
				$data['cia_garde_marks']= $cia_garde_marks;
				$data['reval_grade_mark']= $exam_grade_marks;
				if($stream=='116' || $stream=='119' || $stream=='170'){
					$data['final_garde_marks'] = round(100 * ($exam_grade_marks + $cia_garde_marks)/$subdet[0]['sub_max']);
					
					$sub_min = (100 * ($subdet[0]['sub_min'])/$subdet[0]['sub_max']);
				}else{
					$data['final_garde_marks']= round($exam_grade_marks + $cia_garde_marks);  // addition of theory + cia marks 
				}
				$sub_max_marks[] = $subdet[0]['sub_max'];          // exam result master
				$sub_final_marks[] = $val['final_garde_marks'];				
				$final_garde_marks = $data['final_garde_marks'];
				
				if($subject=='3263'){
				 "Student id:".$stud_id." Subject id:".$subject."-Th Obt:".$theory_obt_marks."-TH Max". $thprmax[0]['max_marks']."- TH_grade marks:".$exam_grade_marks." th min:".$exam_min_marks."-CIA obt:".$cia_obt_marks." CIA MAX:".$ciamax[0]['max_marks']."  CIA grade ".$cia_garde_marks ." cia min:".$cia_min_marks."--Total:".$final_garde_marks."<br>";//exit;
				}

				if(($cia_garde_marks < $cia_min_marks) && $cia_obt_marks !=NULL){ 
				
					if($stream=='116' || $stream=='119' || $stream=='170'){
						$finalgrade = 'F';
						$data['final_grade'] = 'F';
						//$data['result_grade'] = 'F';
						$data['reval_grade'] = 'F';
						$th_garce_required = '0';
						$sub_garce_required = '0';
						$data['garce_marks'] = '';

					}else{
						$finalgrade = 'U';
						$data['final_grade'] = 'U';
						//$data['result_grade'] = 'U';
						$data['reval_grade'] = 'U';
						$th_garce_required = '0';
						$sub_garce_required = '0';
						$data['garce_marks'] = '';
					}

				}elseif(($exam_grade_marks1 < $exam_min_marks) && $theory_obt_marks !=NULL){

					if($stream=='116' || $stream=='119' || $stream=='170'){
						$finalgrade = 'F';
						$data['final_grade'] = 'F';
						//$data['result_grade'] = 'F';
						$data['reval_grade'] = 'F';
						$th_garce_required = '0';
						$sub_garce_required = '0';
						$data['garce_marks'] = '';

					}else{
						$finalgrade = 'U';
						$data['final_grade'] = 'U';
						//$data['result_grade'] = 'U';
						$data['reval_grade'] = 'U';
						
						$th_garce_required = '0';
						$sub_garce_required = '0';
						$data['garce_marks'] = '';
					}
				
				}elseif($final_garde_marks < $sub_min){

						$sub_mrk_diff = $sub_min - $final_garde_marks;        // calculating difference 
						if(in_array($sub_mrk_diff, $grace)){

							$final_garde_marks = $final_garde_marks;      // if difference is between grace array then applying grace of 1 marks
							$data['garce_marks'] = 1;
							$sub_garce_required = '1';
							if($stream=='116' || $stream=='119'  || $stream=='170'){
								//echo "fn-".$final_garde_marks+1;
								$grade = $this->Result_reval_model->fetch_grade_pharma($final_garde_marks+1,$grd_rule);
							}else{
								$grade = $this->Result_reval_model->fetch_grade($final_garde_marks+1,$grd_rule);
							}
							//$data['result_grade'] = $grade[0]['grade_letter'];
							$data['reval_grade'] = $grade[0]['grade_letter'];
							$data['final_grade'] = $grade[0]['grade_letter'];
							$finalgrade = $grade[0]['grade_letter'];
						}else{
						    
						    if(in_array($sub_mrk_diff, $moderate_marks)){         // condition for moderate marks
        					    $data['moderate_marks'] = $sub_mrk_diff;
        				    }
						    if($stream=='116' || $stream=='119' || $stream=='170'){
								$finalgrade = 'F';
								$data['final_grade'] = 'F';
								//$data['result_grade'] = 'F';
								$data['reval_grade'] = 'F';
								$th_garce_required = '0';
								$sub_garce_required = '0';
								$data['garce_marks'] = '';
							}else{
								$finalgrade = 'U';
								$data['final_grade'] = 'U';
								//$data['result_grade'] = 'U';
								$data['reval_grade'] = 'U';
								$th_garce_required = '0';
								$sub_garce_required = '0';
								$data['garce_marks'] = '';
							}
							
						}

				}else{ 

				    if($stream==71){
				    	if($final_garde_marks >=40){
				    		$grade[0]['grade_letter'] ='P';	
				    	}else{
				    		$grade[0]['grade_letter'] ='U';	
				    	}
				    	
				    }else if($stream=='116' || $stream=='119' || $stream=='170'){

						$grade = $this->Result_reval_model->fetch_grade_pharma($final_garde_marks,$grd_rule);
					}else{
						$grade = $this->Result_reval_model->fetch_grade($final_garde_marks,$grd_rule);
					}

					$data['reval_grade'] = $grade[0]['grade_letter'];
					$data['final_grade'] = $grade[0]['grade_letter'];
					$finalgrade = $grade[0]['grade_letter'];
					$data['garce_marks'] = '';
					$th_garce_required = '0';

				}
			  }

				array_push($student_subjets, array(
					'student_id' => $stud_id,
					'subject_id' => $subject,
					'internal_max' => $cia_max_mrks,
					'internal_min_for_pass' => $internal_min_for_pass,
					'theory_max' => $theory_max,
					'th_min_mrks' => $th_min_mrks,
					'sub_max' => $sub_max,
					'sub_min' => $sub_min,
					'theory_obt_marks' => $theory_obt_marks,
					'cia_obt_marks' => $cia_obt_marks,
					'theory_obt_marks' => $theory_obt_marks,
					'cia_garde_marks' => $cia_garde_marks,
					'reval_grade_marks' => $exam_grade_marks,
					'final_garde_marks' => $final_garde_marks,
					'final_grade' => $finalgrade,
					'th_garce_required' => $th_garce_required,
					'sub_garce_required' => $sub_garce_required,
				));

				$this->Result_reval_model->update_reslt_grade($subject,$semester,$stream,$exam_id,$stud_id, $data);
				unset($data);

			}

			foreach ($student_subjets as $key => $value) {

				if($value['th_garce_required']=='1'){
				$gracemrk['garce_marks'] =1;
				$this->Result_reval_model->update_resltsubject_grace($value['subject_id'],$semester,$stream,$exam_id,$value['student_id'], $gracemrk);
				break;
				}
			}
			$res_data['student_id'] = $stud_id;
			$res_data['enrollment_no'] = $res['enrollment_no'];
			unset($sub_final_marks);
			unset($sub_max_marks);
		}
		
        echo "success";
    }  
 
    
	
		function load_streams_for_reval_result(){

		if($_POST["course_id"] !=''){
			//Get all streams
			$stream = $this->Result_reval_model->get_streams_for_reval_result($_POST["course_id"],$_POST["school_code"]);
            
			//Count total number of rows
			$rowCount = count($stream);

				echo '<option value="">Select Stream</option>';
				echo '<option value="0">All Stream</option>';
				foreach($stream as $value){

					echo '<option value="' . $value['stream_id'] . '" >' . $value['stream_name'] . '</option>';
				}
		 }
	}

	 public function pdf_reval_resultReport($result_data,$batch){

		ini_set('memory_limit', '2048M');
		$emp_id = $this->session->userdata("name");
		$DB1 = $this->load->database('umsdb', TRUE);
		$subdetails = explode('~', $result_data);
		$school_code  =$subdetails[0];
		$stream =$subdetails[1];
		$semester =$subdetails[5];
		$exam_month =$subdetails[2];
		$exam_year =$subdetails[3];
		$exam_id =$subdetails[4];
		$this->data['exam_id'] = $exam_id;
		$this->data['dpharma'] = $subdetails[7];
		if(!empty($subdetails[8])){
			$this->data['gdview'] = $subdetails[8];
		}
		
		$res_data['school_id'] = $school_code;
		$res_data['stream_id'] = $stream;
		$res_data['semester'] = $semester;
		$res_data['exam_month'] = $exam_month;
		$res_data['exam_year'] = $exam_year;
		$res_data['entry_by'] = $this->session->userdata("uid");
		$res_data['entry_on'] = date('Y-m-d H:i:s');
		$res_data['entry_ip'] = $this->input->ip_address();
		$this->data['semester'] =$semester;
		$this->data['stream_id'] =$stream;
		$this->data['result_info'] = $this->Result_reval_model->fetch_student_reval_result_data($result_data,$batch);

			
		$arr_students = array_values(array_column($this->data['result_info'], 'student_id'));

		if(!empty($arr_students)){

		$grade_rule = $this->Result_reval_model->fetch_gread_rule($stream);
		$grd_rule = $grade_rule[0]['grade_rule'];
		$this->load->model('Exam_timetable_model');
		$exam_sess= $this->Exam_timetable_model->fetch_stud_curr_exam();
		$this->load->model('Examination_model');
		$StreamShortName =$this->Examination_model->getStreamShortName($stream);
		$this->data['sem_subjects'] = $this->Result_reval_model->fetch_subjects_exam_semester($result_data,$arr_students);

        $this->load->library('m_pdf', $param);
	    $this->m_pdf->pdf=new mPDF('utf-8', 'A4-L', '15', '15', '15', '15', '50', '20');
	    $stream_name = $StreamShortName[0]['stream_short_name'];

		if($stream==71){
			$semest = "Year";
			$iname='Result_Gradesheet';
		}else{
			$semest = "Semester";
			$iname='Result';
		}
	    $header ='<table align="center" width="100%"> 
			<tbody>  
				<tr>
					<td valign="top" height="40">
						<table cellpadding="0" cellspacing="0" border="0" align="center" width="100%" style="margin-top:15px;">
							<tr>
							<td width="80" align="center" style="text-align:center;padding-top:5px;"><img src="https://erp.sandipuniversity.com/assets/images/logo-7.jpg" alt="" width="50" border="0"></td>
							<td style="font-weight:normal;text-align:center;">
								<h1 style="font-size:30px;">Sandip University</h1>
								<p>Mahiravani, Trimbak Road, Nashik – 422 213</p>

							</td>
							<td width="120" align="right" valign="middle" style="text-align:center;padding-top:10px;"></td>
						</tr>
							<tr>
								<td></td>
								<td align="center" style="text-align:center;margin:0;padding:0"><h3 style="font-size:12px;">OFFICE OF THE CONTROLLER OF EXAMINATIONS<br>END SEMESTER EXAMINATION RESULTS - <u>'.$exam_month.' '.$exam_year.' (Revaluation)</u></h3></td>
								<td></td>
							</tr>
            				<tr>
								<td colspan="3">&nbsp;</td>
								
							</tr>
						</table>
					</td>
				</tr>           
			            </tbody>           
				</table>
						<table class="content-table" width="100%" cellpadding="0" cellspacing="2" border="1" align="center" style="font-size:12px;height:150px;overflow: hidden;padding-bottom: 10px">
							<tr>
								<td width="100" height="30"><strong>Batch :</strong> '.$batch.', <strong>Stream : </strong>
								'.$stream_name.'</td>
								<td width="100" height="30"><strong>'.$semest.' :</strong> '.$semester.'</td>					
							</tr>
						</table>';

		$dattime = date('d-m-Y H:i:s');
		$footer ='<table width="100%" border="0" style="text-align:center" cellspacing="0" cellpadding="2"  style="margin-bottom:20px;"><tr>
		<td width="25%" ><b>Office Seal</b></td>
		<td width="75%" align="center"><b><span style="text-align:center!important">COE Signature</span></b></td>
		<td width="25%" style="float:right!important"><span style="text-align:right!important">Printed on: '.$dattime.'</span></td>
		</tr>
		</table>';
				
	    $content = $this->load->view($this->view_dir.'reval_result_marksheet_pdf', $this->data, true);
	    $header1 = mb_convert_encoding($header, 'UTF-8', 'UTF-8');
	    $this->m_pdf->pdf->SetHTMLHeader($header1);
		$content = mb_convert_encoding($content, 'UTF-8', 'UTF-8');
		$this->m_pdf->pdf->AddPage();
		$this->m_pdf->pdf->WriteHTML($content);	
        $this->m_pdf->pdf->SetHTMLFooter($footer);
        $fname= $batch.'_'.$stream_name.'_'.$semester.'_'.$exam_month.'_'.$exam_year;
	    $pdfFilePath = $iname.'_'.$fname.".pdf";

	    //download it.
	    $this->m_pdf->pdf->Output($pdfFilePath, "D");
		}else{
			echo "No data found.";
			
		}
    }
		
	public function reval_gradesheet_pdfreport($result_data, $batch){

		$emp_id = $this->session->userdata("name");
		$DB1 = $this->load->database('umsdb', TRUE);
		ini_set('memory_limit', '2048M');
		$subdetails = explode('~', $result_data);

		$school_code  =$subdetails[0];
		$stream =$subdetails[1];
		$semester =$subdetails[5];
		$exam_month =$subdetails[2];
		$exam_year =$subdetails[3];
		$exam_id =$subdetails[4];
		$this->data['exam_id'] = $exam_id;
		
		$res_data['school_id'] = $school_code;
		$res_data['stream_id'] = $stream;
		$res_data['semester'] = $semester;
		$res_data['exam_month'] = $exam_month;
		$res_data['exam_year'] = $exam_year;
		$res_data['entry_by'] = $this->session->userdata("uid");
		$res_data['entry_on'] = date('Y-m-d H:i:s');
		$res_data['entry_ip'] = $this->input->ip_address();
		$this->data['semester'] =$semester;
		$this->data['stream_id'] =$stream;
		$this->data['result_info'] = $this->Result_reval_model->fetch_student_reval_result_data($result_data, $batch);
		$arr_students = array_values(array_column($this->data['result_info'], 'student_id'));

		$grade_rule = $this->Results_model->fetch_gread_rule($stream);
		$grd_rule = $grade_rule[0]['grade_rule'];
		$this->load->model('Exam_timetable_model');
		$this->data['exam_sess']= $this->Exam_timetable_model->fetch_stud_curr_exam();
		$this->load->model('Examination_model');
		$this->data['StreamShortName'] =$this->Examination_model->getStreamShortName($stream);
		$this->data['sem_subjects'] = $this->Result_reval_model->fetch_subjects_exam_semester($result_data,$arr_students);
	
		if($stream=='116' || $stream=='119' || $stream=='170'){
			$this->data['grade_details']= $this->Results_model->list_grade_pharma_details($grd_rule);
		}else{
			$this->data['grade_details']= $this->Results_model->list_grade_details($grd_rule);
		}
		if($stream==71){
			$semest = "Year";
		}else{
			$semest = "Semester";
		}
		$i=0;
		foreach ($this->data['result_info'] as $res){

			$stud_id = $res['student_id'];
			$this->data['result_info'][$i]['sub'] = $this->Result_reval_model->fetch_reslt_subjects($result_data,$stud_id);
			$i++;
		}

        $this->load->library('m_pdf', $param); 
	    $this->m_pdf->pdf=new mPDF('utf-8', 'A4-L', '15', '15', '15', '15', '50', '35');
	    $stream_name = $this->data['StreamShortName'][0]['stream_short_name'];
	   	    
	    $header ='<table align="center" width="100%"> 
			<tbody>  
				<tr>
					<td valign="top" height="40">
						<table cellpadding="0" cellspacing="0" border="0" align="center" width="100%" style="margin-top:15px;">
							<tr>
							<td width="80" align="center" style="text-align:center;padding-top:5px;"><img src="https://erp.sandipuniversity.com/assets/images/logo-7.jpg" alt="" width="50" border="0"></td>
							<td style="font-weight:normal;text-align:center;">
								<h1 style="font-size:30px;">Sandip University</h1>
								<p>Mahiravani, Trimbak Road, Nashik – 422 213</p>

							</td>
							<td width="120" align="right" valign="middle" style="text-align:center;padding-top:10px;"></td>
						</tr>
							<tr>
								<td></td>
								<td align="center" style="text-align:center;margin:0;padding:0"><h3 style="font-size:12px;">OFFICE OF THE CONTROLLER OF EXAMINATIONS<br>END SEMESTER EXAMINATION RESULTS - <u>'.$exam_month.' '.$exam_year.' (Revaluation)</u></h3></td>
								<td></td>
							</tr>
            				<tr>
								<td colspan="3">&nbsp;</td>
								
							</tr>
						</table>
					</td>
				</tr>           
			            </tbody>           
				</table>
						<table class="content-table" width="100%" cellpadding="2" cellspacing="0" border="1" align="center" style="font-size:12px;height:150px;overflow: hidden;margin-bottom: 10px">
							<tr>
								<td width="100" height="30"><strong>Stream : </strong>
								'.$stream_name.'</td>
								<td width="100" height="30"><strong>'.$semest.' :</strong> '.$semester.'</td>	
								<td width="100" height="30"><strong>Regulation:</strong> 2017</td>	
							</tr>						

						</table>';
	    
	    $content = $this->load->view($this->view_dir.'reval_result_gradesheet_pdf', $this->data, true);
	    $dattime = date('d-m-Y H:i:s');
		$footer='<table width="100%"  style="text-align:center" cellspacing="0" cellpadding="2"  style="margin-bottom:20px;"><tr>
		<td width="24%"><b>Office Seal</b></td>
		<td width="54%" align="center"><b>COE Signature</b></td>
		<td width="20%">Printed on: '.$dattime.'</td>
		<td width="2%"> <b>{PAGENO}</b></td>
		</tr> 
		</table>';

	    $header1 = mb_convert_encoding($header, 'UTF-8', 'UTF-8');
	    $this->m_pdf->pdf->SetHTMLHeader($header1);
		$content = mb_convert_encoding($content, 'UTF-8', 'UTF-8');
		$this->m_pdf->pdf->AddPage();
		
		$this->m_pdf->pdf->WriteHTML($content);	
        $this->m_pdf->pdf->SetHTMLFooter($footer);
		//$this->m_pdf->pdf->setFooter('{PAGENO}');
		
        $fname= $stream_name.'_'.$semester.'_'.$exam_month.'_'.$exam_year;
	    $pdfFilePath = 'Result_Gradesheet_'.$fname.".pdf";

	    //download it.
	    $this->m_pdf->pdf->Output($pdfFilePath, "D");
    }
		public function download_mrkdentrystatus_pdf($testId='', $me_id='', $cia_me_id='')
    {
         $this->load->model('Marks_model');
		$me_id = base64_decode($me_id);
		$cia_me_id = base64_decode($cia_me_id);
		$testId = base64_decode($testId);
		$this->data['me_id']=$me_id;
		$this->data['sub_details'] = $testId;
		$subdetails =explode('~',$testId);
		$sub_id  =$subdetails[0];//exit;
		$stream =$subdetails[3];
		$semester = $subdetails[4];

		$exam= explode('-', $subdetails[5]);
		$exam_month =$exam[0];
		$exam_year =$exam[1];
		$exam_id = $exam[2];
		
        $this->data['exam_month'] = $exam_month;
		$this->data['exam_year'] = $exam_year;
		
		$this->data['ut'] = $this->Marks_model->getsubdetails($sub_id);
		$this->data['StreamSrtName'] = $this->Marks_model->getStreamShortName($subdetails[3]);
		$this->data['me']=$this->Marks_model->fetch_me_details($me_id);	
		$this->data['mrks']=$this->Result_reval_model->get_thmarks_revalmrks_details($sub_id, $stream, $semester,$exam_id);		
		$this->load->library('m_pdf');
		$html = $this->load->view($this->view_dir.'pdf_reval_marksentry',$this->data, true);
		$pdfFilePath1 =$this->data['ut'][0]['subject_short_name']."_marksentry.pdf";
		$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
		
		$mpdf=new mPDF();
          $mpdf->SetFont('Arial', 'B', 14);
		$this->m_pdf->pdf->WriteHTML($html);
		//download it.
		$this->m_pdf->pdf->Output($pdfFilePath1, "D");
        
    }
	 
	function load_schools_for_reval_results(){

		if($_POST["school_code"] !=''){
			
			//Get all city data
			$stream = $this->Result_reval_model->get_courses_reval_results($_POST["school_code"]);
            
			//Count total number of rows
			echo $rowCount = count($stream);

				echo '<option value="">Select Course</option>';
				echo '<option value="0">All Course</option>';
				foreach($stream as $value){
					echo '<option value="' . $value['course_id'] . '">' . $value['course_short_name'] . '</option>';
				}
		 }
	}

	function load_examsemesters(){

		if(isset($_POST["stream_id"]) && !empty($_POST["stream_id"])){
			
			$stream = $this->Result_reval_model->get_examsemester($_POST["stream_id"], $_POST["exam_session"]);
            
			//Count total number of rows
			$rowCount = count($stream);

			//Display cities list
			if($rowCount > 0){
				echo '<option value="">Select Semester</option>';
				echo '<option value="0">All Semester</option>';
				foreach($stream as $value){
					echo '<option value="' . $value['semester'] . '">' . $value['semester'] . '</option>';
				}
			} else{
				echo '<option value="">Semester not available</option>';
			}
		}
	}
}