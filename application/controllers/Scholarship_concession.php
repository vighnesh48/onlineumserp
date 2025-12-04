<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('display_errors', 1);
class Scholarship_concession extends CI_Controller 
{

    var $currentModule="";
    var $title="";
    var $table_name="";
    var $model_name="Scholarship_concession_model";
    var $model;
    var $view_dir='Scholarship_concession/';
    
    public function __construct() 
    {
        global $menudata; 
        parent:: __construct();
     //   echo $_SERVER['REMOTE_ADDR'];
 // var_dump($_SESSION);
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
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
        $this->load->model("Admission_model");
        $this->load->library('Message_api');
        $menu_name=$this->uri->segment(1);        
        $this->data['my_privileges']=$this->retrieve_privileges($menu_name);
    }
	
    public function index()
    {
        global $model;
        $this->load->view('header',$this->data);    
        //$this->data['campus_details']= $this->campus_model->get_campus_details();                        
        $this->load->view($this->view_dir.'upload_excel',$this->data);
        $this->load->view('footer');
    }
	function RemoveSpecialChar($str) { 
      
    // Using str_replace() function  
    // to replace the word  
    $res = str_replace( array( '\'', '"', 
    ',' , ';', '<', '>' ), ' ', $str); 
      
    // Returning the result  
    return $res; 
    } 
	
	public function Excel_upload(){
		
		//exit();
		
		$check_2020='';
		$DB1 = $this->load->database('umsdb', TRUE);
		if(!empty($_FILES['Excel_upload']['name'])){
		  echo '1';
		$datestring = date("Y-m-d:h:i:s");
        $time = time();
       // $trackdate=mdate($datestring, $time);
				
		$config['image_library'] = 'gd2';
        $config['upload_path']          = 'uploads/Scholarship_concession/';
        $config['allowed_types']        = 'xls|xlsx';
		$new_name = $datestring.'conf-'.$_FILES["Excel_upload"]['name'];
        $config['file_name'] = $new_name;
        $this->load->library('upload', $config);
		//	exit();	
		   if ( ! $this->upload->do_upload('Excel_upload')){
			   
			  // echo '2';
            $error = array('error' => $this->upload->display_errors());
			$status = "error";
            $msg = print_r($error);
               }else{//do_upload
			   //echo '3';
		    $date=time();
            $data = array('upload_data' => $this->upload->data());
			$image_data = $this->upload->data();  //	print_r($image_data);
			$filename=$image_data['full_path'];
			$status = "success";
            $msg = "File successfully uploaded";
			$file = $filename;    //load the excel library
            $this->load->library('excel'); //read file from path
            $objPHPExcel = PHPExcel_IOFactory::load($file);
            //get only the Cell Collection
            $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
            //extract to a PHP readable array format
            foreach ($cell_collection as $cell) {
            $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
            $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
            $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue(); // print_r($column);
           //header will/should be in row 1 only. of course this can be modified to suit your need.
            if ($row == 1) {
            $header[$row][$column] = $data_value;
            }else{
             $arr_data[$row][$column] = $data_value;
            }
			  }
$data['header'] = $header;
$header = $header;
$data['values'] = $arr_data;
$values = $arr_data;
//$data['Status'] = 'CONFIRM';
//$Status='CONFIRM';
$data['row']=$row; 
$row=$row;
$error="";
$msg=array();	

	  
print_r($header[1]);	echo '<br>';

	  
if (in_array('PRN', $header[1])) {
$PRN = array_search('PRN',  $header[1]);
    //echo $key;
}else{
	$error=1;
	$msg[]="PRN Field Not Match To Excel Sheet";
} 

if (in_array('Name', $header[1])) {
$Name = array_search('Name',  $header[1]);
    //echo $key;
}else{
	$error=1;
	$msg[]="Name Field Not Match To Excel Sheet";
} 

if (in_array('Actual_Fees', $header[1])) {
$Actual_Fees = array_search('Actual_Fees',  $header[1]);
    //echo $key;
}else{
	$error=1;
	$msg[]="Actual Fees Field Not Match To Excel Sheet";
} 
if (in_array('Scholarship_Type', $header[1])) {
$Scholarship_Type = array_search('Scholarship_Type',  $header[1]);
    //echo $key;
}else{
	$error=1;
	$msg[]="Scholarship Type Field Not Match To Excel Sheet";
} 			  
			  
	if (in_array('Duration', $header[1])) {
$Duration = array_search('Duration',  $header[1]);
    //echo $key;
}else{
	$error=1;
	$msg[]="Duration Field Not Match To Excel Sheet";
} 			  
	if (in_array('Excempted_Fees', $header[1])) {
$Excempted_Fees = array_search('Excempted_Fees',  $header[1]);
    //echo $key;
}else{
	$error=1;
	$msg[]="Excempted Fees Field Not Match To Excel Sheet";
} 				  
			  
	
	if (in_array('Applicable_Fees', $header[1])) {
$Applicable_Fees = array_search('Applicable_Fees',  $header[1]);
    //echo $key;
}else{
	$error=1;
	$msg[]="Applicable Fees Field Not Match To Excel Sheet";
} 		
	
	if (in_array('Remark', $header[1])) {
$Remark = array_search('Remark',  $header[1]);
    //echo $key;
}else{
	$error=1;
	$msg[]="Remark Field Not Match To Excel Sheet";
} 	

///////////////////////////////////////////////////////////////////////



   if($error=="1"){
	 $path =  FCPATH;
	//if($logo_imgpath_old){
				unlink($file);
				//}
	$data['Error']=array('error'=>$error,'msg'=>$msg);
	$Error=array('error'=>$error,'msg'=>$msg);
	print_r($Error);echo '<br>';
	//$this->load->view('Scholarship_concession',$data);
	
    }else{
    $affect_id=array();
	
	$k=1;
	 for($i=2;$row>=$i;$i++){ //for($i=2;$row>=$i;$i++)
		 
		 if(!empty($values[$i][$PRN])){
			 
			 
			echo $k.'--'.$values[$i][$PRN].'--'.$values[$i][$Name].'--'.$values[$i][$Actual_Fees].'--'.$values[$i][$Scholarship_Type].'--'.$values[$i][$Duration].'--'.$values[$i][$Excempted_Fees].'--'.$values[$i][$Applicable_Fees].'--'.$values[$i][$Remark]; echo '<br>';
			 
			 $new_prn= trim($values[$i][$PRN]);
			 $new_Name= trim($values[$i][$Name]);
			 $new_Actual_Fees= trim($values[$i][$Actual_Fees]);
			 $new_Scholarship_Type= trim($values[$i][$Scholarship_Type]);
			 $new_Duration=trim($values[$i][$Duration]);
			 $new_Excempted_Fees=trim($values[$i][$Excempted_Fees]);
			 $new_Applicable_Fees=trim($values[$i][$Applicable_Fees]);
			 $new_concession_Remark=trim($values[$i][$Remark]);
			  
			  
			  if($new_Duration=="All"){
				  $Duration_final=0;
			  }else{
				  $Duration_final=$new_Duration;
			  }
			  
			  
			  
			 $DB1 = $this->load->database('umsdb', TRUE);
		
           
		$DB1->select("stud_id,
`enrollment_no_new`,
`enrollment_no`,
`email`,
`mobile`,
`academic_year`,
`admission_session`,
`admission_school`,
`admission_stream`,
`admission_year`,
`lateral_entry`,
`current_year`,
`current_semester`,
`admission_cycle`,
`admission_confirm`,
`cancelled_admission`");
		$DB1->from("student_master");
			//$DB1->like('username', "19", 'after');
		//$DB1->where("um_id >",36227);
		$DB1->where("enrollment_no",($new_prn));
		//$DB1->where("status",'Y');
		//$DB1->order_by("um_id", "asc");
		$query=$DB1->get(); 
		//echo $DB1->last_query();echo '<br>';
		//exit(0);
		//die;*
		
		
		$result = $query->result_array(); 
			  unset($query);
			// print_r($result);echo '<br>';
			echo $stud_id=$result[0]['stud_id'];echo '<br>';
			
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
			
			
			
			 $DB1->select("student_id,actual_fee,applicable_fee");
			 $DB1->from("admission_details");
			 $DB1->where("enrollment_no",($new_prn));
			 $DB1->where("academic_year",'2020');
			 $query_2020=$DB1->get();
			 $result_2020 = $query_2020->result_array(); 
			  unset($query_2020);
			  
		    $stud_idd=$result_2020[0]['student_id'];
			$actual_fee_2020=$result_2020[0]['actual_fee'];
			
			 if(($stud_idd)&&($Duration_final==0)){
				 
				echo 'Yes';
				$check_2020='Y';
				$applicable_fee_2020=$result_2020[0]['actual_fee']-$new_Excempted_Fees;
				
				 $admission_update_2020="update  admission_details SET applicable_fee='$applicable_fee_2020',fees_consession_allowed='Y',concession_type='$new_Scholarship_Type',duration='$Duration_final',concession_remark='$new_concession_Remark' WHERE 
			 
			academic_year='2020' AND enrollment_no='$new_prn' AND student_id='$stud_id'";
			
			/*$dataadmission_update=$DB1->query($admission_update_2020);
			
			
			if($dataadmission_update){
					 echo 'admission_update_2020';echo '<br>';
				 }else{
					 echo 'admission_update_2020 Fail';echo '<br>';
					 $error = $DB1->error();echo '<br>';
					 print_r($error);
				 }
				 
             unset($dataadmission_update);*/
			
			
			 $DB1->select("student_id");
			 $DB1->from("fees_consession_details");
			 $DB1->where("enrollement_no",($new_prn));
			 $DB1->where("academic_year",'2020');
			 $query_fees_consession=$DB1->get();
			 $result_fees_consession = $query_fees_consession->result_array(); 
			  
		    $stud_idc=$result_fees_consession[0]['student_id'];
			unset($query_fees_consession);
			if($stud_idc){
				
				
				$fees_consession_update_2020="update  fees_consession_details SET concession_type='$new_Scholarship_Type'
				,exepmted_fees='$new_Excempted_Fees',duration='$Duration_final',concession_remark='$new_concession_Remark',remark='by kiran' WHERE 
			 
			 academic_year='2020' AND enrollement_no='$new_prn' AND student_id='$stud_id'";
			
			 /*$dataconsession_update=$DB1->query($fees_consession_update_2020);
			 if($dataconsession_update){
					 echo 'fees_consession_update_2020';echo '<br>';
				 }else{
					 echo 'fees_consession_update_2020 Fail';echo '<br>';
					 $error = $DB1->error();echo '<br>';
					 print_r($error);
				 }
			 
			 
			 
              unset($fees_consession_update_2020);*/
			}else{
				
				$fees_paid_required=$result_2020[0]['actual_fee']-$new_Excempted_Fees;
				$fees_consession_insert_2020="insert into fees_consession_details values(NULL,'$new_Scholarship_Type','$stud_id','$new_prn','2020','$actual_fee_2020','$new_Excempted_Fees','$fees_paid_required','$Duration_final','$new_concession_Remark','Admin',
				'','','','','by kiran')";
				
				/*$dataconsession_insert= $DB1->query($fees_consession_insert_2020);
				 
				  if($dataconsession_insert){
					 echo 'fees_consession_insert_2020';echo '<br>';
				    }else{
					 echo 'fees_consession_insert_2020 Fail';echo '<br>';
					 $error = $DB1->error();echo '<br>';
					 print_r($error);
				   }
				 
                  unset($fees_consession_insert_2020);*/
			}
				
				
			}else{
				echo 'NO';
				$check_2020='N';
			}
			
			
			echo '<br>';
			
			
			 $DB1->select("student_id");
			 $DB1->from("fees_consession_details");
			 $DB1->where("enrollement_no",($new_prn));
			 $DB1->where("academic_year",'2019');
			 $query_fees_consession_2019=$DB1->get();
			 $result_fees_consession_2019 = $query_fees_consession_2019->result_array(); 
			  
		    $stud_idc_2019=$result_fees_consession_2019[0]['student_id'];
			unset($query_fees_consession_2019);
			if($stud_idc_2019!=''){
				
				
				$fees_consession_update_2020="update  fees_consession_details SET concession_type='$new_Scholarship_Type'
				,exepmted_fees='$new_Excempted_Fees',duration='$Duration_final',concession_remark='$new_concession_Remark',remark='by kiran' WHERE 
			 
			 academic_year='2019' AND enrollement_no='$new_prn' AND student_id='$stud_id'";
			
			/* $dataconsession_update=$DB1->query($fees_consession_update_2020);
			 if($dataconsession_update){
					 echo 'fees_consession_update_2020';echo '<br>';
				 }else{
					 echo 'fees_consession_update_2020 Fail';echo '<br>';
					 $error = $DB1->error();echo '<br>';
					 print_r($error);
				 }
			 
			 
			 
              unset($fees_consession_update_2020);*/
			}else{
				
			 $DB1->select("student_id,actual_fee,applicable_fee");
			 $DB1->from("admission_details");
			 $DB1->where("enrollment_no",($new_prn));
			 $DB1->where("academic_year",'2019');
			 $query_2019=$DB1->get();
			 $result_2019 = $query_2019->result_array(); 
			  
			  
		    //$stud_idd=$result_2019[0]['student_id'];
			$actual_fee_2019=$result_2019[0]['actual_fee'];
				unset($result_2019);
				
				
				
				
				
				$fees_paid_required=$actual_fee_2019-$new_Excempted_Fees;
				$fees_consession_insert_2020="insert into fees_consession_details values(NULL,'$new_Scholarship_Type','$stud_id','$new_prn','2019','$actual_fee_2019','$new_Excempted_Fees','$fees_paid_required','$Duration_final','$new_concession_Remark','Admin',
				'','','','','by kiran')";
			//echo	'fees_consession_insert_2019';
			/*	$dataconsession_insert_2019= $DB1->query($fees_consession_insert_2020);
				 
				  if($dataconsession_insert_2019){
					 echo 'fees_consession_insert_2019';echo '<br>';
				    }else{
					 echo 'fees_consession_insert_2019 Fail';echo '<br>';
					 $error = $DB1->error();echo '<br>';
					 print_r($error);
				   }
				 
                  unset($dataconsession_insert_2019);*/
			}
			
			
			
			
			
			
			
			
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////		 
			 $DB1->select("student_id,actual_fee,applicable_fee,concession_type,duration,concession_remark");
			 $DB1->from("admission_details");
			 $DB1->where("enrollment_no",($new_prn));
			 $DB1->where("academic_year",'2019');
			 $query_old=$DB1->get();
			 $result_old = $query_old->result_array(); 
			 
		    // $stud_idd=$result_old[0]['actual_fee'];
			 
			 
			 $old_actual_fee=trim($result_old[0]['actual_fee']) ;
			 $old_applicable_fee=trim($result_old[0]['applicable_fee']);
			 $old_concession_type=trim($result_old[0]['concession_type']);
			 $old_concession_remark=$this->RemoveSpecialChar(trim($result_old[0]['concession_remark']));
			 
			 unset($query_old);
			 
			 $admission_update="update  admission_details SET actual_fee='$new_Actual_Fees',applicable_fee='$new_Applicable_Fees',fees_consession_allowed='Y',concession_type='$new_Scholarship_Type',duration='$Duration_final',concession_remark='$new_concession_Remark' WHERE 
			 
			academic_year='2019' AND enrollment_no='$new_prn' AND student_id='$stud_id'";
			
			/*  $dadmission_update=$DB1->query($admission_update);
			  
			  if($dadmission_update){
					 echo 'admission_update';echo '<br>';
				    }else{
					 echo 'admission_update Fail';echo '<br>';
					 $error = $DB1->error();echo '<br>';
					 print_r($error);
				   }
			  
			  
			  
              unset($admission_update);*/
			 
			 
			 $fees_consession_update="update  fees_consession_details SET concession_type='$new_Scholarship_Type',actual_fees='$new_Actual_Fees',exepmted_fees='$new_Excempted_Fees',duration='$Duration_final',concession_remark='$new_concession_Remark',remark='by kiran' WHERE 
			 
			 academic_year='2019' AND enrollement_no='$new_prn' AND student_id='$stud_id'";
			 $date=date('Y-m-d');
			/* $datafees= $DB1->query($fees_consession_update);
			  
			  if($datafees){
					 echo 'fees_consession_update';echo '<br>';
				    }else{
					 echo 'fees_consession_update Fail';echo '<br>';
					 $error = $DB1->error();echo '<br>';
					 print_r($error);
				   }
              unset($fees_consession_update);*/
			//////////////////////////////////////////////////////////////////////////////////////////////////////
			$excel_updated="insert into scholship_excel_updated values('','$new_prn','$stud_id','2019','$old_actual_fee','$new_Actual_Fees','$old_applicable_fee','$new_Applicable_Fees','$old_concession_type','$new_Scholarship_Type','$new_Duration','".$old_concession_remark."','$new_concession_Remark','$date','$check_2020')";
			
				/* $data= $DB1->query($excel_updated);
				 
				 if($data){
					 echo 'excel_updated Insert';echo '<br>';
				 }else{
					 echo 'excel_updated Fail';echo '<br>';
					 $error = $DB1->error();echo '<br>';
					 print_r($error);
				 }
           unset($excel_updated);*/
			 
			$k++; 
			 
		 }
	 }
	
	
	
	
	
	}

			  
			   }//do_upload
			   
			   
		}//!empty($_FILES['Excel_upload']['name']
	}
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////	
}