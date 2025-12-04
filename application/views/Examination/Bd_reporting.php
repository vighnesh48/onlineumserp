<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Bd_reporting extends CI_Controller 
{
    var $currentModule="";
    var $title="";
    var $table_name="bd_reporting";
    var $model_name="Bd_reporting_model";
    var $model;
    var $view_dir='bd_reporting/';
    
    public function __construct() 
    {
        global $menudata;
        parent:: __construct();
        
        $this->load->helper("url");		
        $this->load->library('form_validation');
		 //$this->load->library('upload');
        
        if($this->uri->segment(2)!="" && $this->uri->segment(2)!="submit" && !in_array($this->uri->segment(2), $this->skipActions))
           $title=$this->uri->segment(2);                   //Second segment of uri for action,In case of edit,view,add_ic etc.
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
        $this->load->view('header',$this->data);
		//print_r($_SESSION);
		//exit;
		if($this->session->userdata("role_id")=='1'){
			$this->data['icreport'] = $this->Bd_reporting_model->ic_reporting_to_admin(date('d-m-Y'));
		}else{
		$this->data['icreport'] = $this->Bd_reporting_model->get_ic_reporting(date('M-Y'));
		}
        $this->load->view($this->view_dir.'view',$this->data);
        $this->load->view('footer');
    }
	public function add()
    {
        $this->load->view('header',$this->data);                                            
        $this->load->view($this->view_dir.'add',$this->data);
        $this->load->view('footer');
    }
	public function submit()
    {
        $this->load->view('header',$this->data);   
		$icdate = date('Y-m-d', strtotime($_POST['icdate']));
        $icr = $this->Bd_reporting_model->get_ic_reporting_bydate($icdate);	
	   if($icr == '0'){
		    $this->data['ins_status']= $this->Bd_reporting_model->insert_ic_reporting($_POST);	
				$this->smsbdreport($_POST['icdate']); // send sms to ic users
			   redirect('Bd_reporting');
	   }else{		   
	   $this->session->set_flashdata('message1','Already Inserted BD Reporting on this date '.$_POST['icdate']);
	                redirect('Bd_reporting/add');
	   }     
    }
	
  public function get_ic_report_bysearch(){
	  $smonth=$_REQUEST['smonth'];
	  
	  if($this->session->userdata("role_id")=='1'){
			$ic_rec = $this->Bd_reporting_model->ic_reporting_to_admin($smonth);
		}else{
	  $ic_rec = $this->Bd_reporting_model->get_ic_reporting($smonth);
		}
	  $j=1;
		$consentschool = array();
		$consentcollage = array();
		$consentclasses = array();
		$consenttotal=array();
		$seminarsschool=array();
		$seminarscollage=array();
		$seminarsclasses=array();
		$seminarstotal=array();
		$studentschool=array();
		$studentcollage=array();
		$studentclasses=array();
		$studenttotal=array();
		$formic=array();
		$formcompus=array();
	  foreach($ic_rec as $val){
		   $consentschool[] = $val['consent_school_count'];
		   $consentcollage[] = $val['consent_collage_count'];
			$consentclasses[] = $val['consent_classes_count'];
			$consenttotal[]=$val['consent_total'];
			$seminarsschool[]=$val['seminars_school_count'];
			$seminarscollage[]=$val['seminars_collage_count'];
			$seminarsclasses[]=$val['seminars_classes_count'];
			$seminarstotal[]=$val['seminars_total'];
			$studentschool[]=$val['student_school_count'];
			$studentcollage[]=$val['student_collage_count'];
			$studentclasses[]=$val['student_classes_count'];
			$studenttotal[]=$val['student_total'];	

			  echo "<tr>";
			  echo "<td>".$j."</td>";  
			  if($this->session->userdata("role_id")=='1'){
				  
				  echo "<td>".$val['ic_name']."</td>";
				  echo "<td>".$val['fname'].' '.$val['lname'].'</td>'; 
			  }elseif($this->session->userdata("role_id")=='7'){
					echo "<td>".$val['fname'].' '.$val['lname'].'</td>';
					echo "<td>".date('d-M',strtotime($val['date']))."</td>";
			  }else{
			  echo "<td>".date('d-M',strtotime($val['date']))."</td>";
			  }		  
			  echo "<td>".$val['consent_school_count'].'</td>'; 
			  echo "<td>".$val['consent_collage_count'].'</td>'; 
			  echo "<td>".$val['consent_classes_count'].'</td>'; 
			 echo '<td>'.$val['consent_total'].'</td>'; 
			 echo '<td>'.$val['seminars_school_count'].'</td>'; 
			  echo '<td>'.$val['seminars_collage_count'].'</td>'; 
			 echo '<td>'.$val['seminars_classes_count'].'</td>'; 
			 echo '<td>'.$val['seminars_total'].'</td>';
			 echo '<td>'.$val['student_school_count'].'</td>'; 
			 echo '<td>'.$val['student_collage_count'].'</td>'; 
			 echo '<td>'.$val['student_classes_count'].'</td>'; 
			 echo '<td>'.$val['student_total'].'</td>'; 
			 echo '<td>'.$val['work_report'].'</td>'; 
			  echo '</tr>';
			  $j = $j+1;
	  }
	echo " <tr>
<td></td>  
                                <td><b>Total</b></td> ";
								if($this->session->userdata("role_id")=='1'){
									echo "<td></td>"; 
								}elseif($this->session->userdata("role_id")=='7'){
									echo "<td></td>";
								}else{
									
								}
                                echo "<td><b>".array_sum($consentschool)."</b></td> 
								<td><b>".array_sum($consentcollage)."</b></td> 
                                <td><b>".array_sum($consentclasses)."</b></td> 
<td><b>".array_sum($consenttotal)."</b></td> 
<td><b>".array_sum($seminarsschool)."</b></td> 
<td><b>".array_sum($seminarscollage)."</b></td>
<td><b>".array_sum($seminarsclasses)."</b></td> 
<td><b>".array_sum($seminarstotal)."</b></td> 
<td><b>".array_sum($studentschool)."</b></td> 
<td><b>".array_sum($studentcollage)."</b></td> 
<td><b>".array_sum($studentclasses)."</b></td> 
<td><b>".array_sum($studenttotal)."</b></td>
<td></td> 
</tr>";						
  }
  
  public function export_excel($smonth){
	  $this->load->library('excel');
if($smonth==''){
	if($this->session->userdata("role_id")=='1'){
   $smonth = date('d-m-Y');
		}else{
		$smonth = date('M-Y');
		}
}else{
$smonth = $smonth;
}		
$this->excel->setActiveSheetIndex(0);
$this->excel->getActiveSheet()->setTitle('test worksheet');
$this->excel->getActiveSheet()->setCellValue('A1', 'DATE: '.$smonth);
$this->excel->getActiveSheet()->mergeCells('A1:B1');
$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
$this->excel->getActiveSheet()->setCellValue('C1', 'No of Consent Received');
$this->excel->getActiveSheet()->mergeCells('C1:F1');
$this->excel->getActiveSheet()->setCellValue('G1', 'No of Seminars Conducted ');
$this->excel->getActiveSheet()->mergeCells('G1:J1');
$this->excel->getActiveSheet()->setCellValue('K1', 'No of Students Present');
$this->excel->getActiveSheet()->mergeCells('K1:N1');
$this->excel->getActiveSheet()->setCellValue('O1', 'Work Details ');
$this->excel->getActiveSheet()->mergeCells('O1:P1');
//set aligment to center for that merged cell (A1 to D1)
$this->excel->getActiveSheet()->getStyle('C1:O1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->excel->getActiveSheet()->getStyle('C1:O1')->getFont()->setSize(15);
//$this->excel->getActiveSheet()->getStyle('C1:O1')->getFont()->setBold(true);


if($this->session->userdata("role_id")=='1'){
	$this->excel->getActiveSheet()->setCellValue('A2', '#');
	$this->excel->getActiveSheet()->setCellValue('B2', 'IC Name');
	$this->excel->getActiveSheet()->setCellValue('A2', 'BD Name');
}elseif($this->session->userdata("role_id")=='7'){
	$this->excel->getActiveSheet()->setCellValue('A2', 'BD Name');
	$this->excel->getActiveSheet()->setCellValue('B2', 'DATE');
}else{
	$this->excel->getActiveSheet()->setCellValue('B2', 'DATE');
}
$this->excel->getActiveSheet()->setCellValue('C2', 'School');
$this->excel->getActiveSheet()->setCellValue('D2', 'College');
$this->excel->getActiveSheet()->setCellValue('E2', 'Classes');
$this->excel->getActiveSheet()->setCellValue('F2', 'Total');
$this->excel->getActiveSheet()->setCellValue('G2', 'School');
$this->excel->getActiveSheet()->setCellValue('H2', 'College');
$this->excel->getActiveSheet()->setCellValue('I2', 'Classes');
$this->excel->getActiveSheet()->setCellValue('J2', 'Total');
$this->excel->getActiveSheet()->setCellValue('K2', 'School');
$this->excel->getActiveSheet()->setCellValue('L2', 'College');
$this->excel->getActiveSheet()->setCellValue('M2', 'Classes');
$this->excel->getActiveSheet()->setCellValue('N2', 'Total');
$this->excel->getActiveSheet()->setCellValue('O2', 'Work Details');

$this->excel->getActiveSheet()->getStyle('A2:O2')->getFont()->setBold(true);

if($this->session->userdata("role_id")=='1'){
			$ic_rec = $this->Bd_reporting_model->ic_reporting_to_admin($smonth);
		}else{
	  $ic_rec = $this->Bd_reporting_model->get_ic_reporting($smonth);
		}
		$row=3;
		$j=1;
		$consentschool = array();
	  $consentcollage = array();
$consentclasses = array();
$consenttotal=array();
$seminarsschool=array();
$seminarscollage=array();
$seminarsclasses=array();
$seminarstotal=array();
$studentschool=array();
$studentcollage=array();
$studentclasses=array();
$studenttotal=array();
$formic=array();
$formcompus=array();
		foreach($ic_rec as $val){
			$consentschool[] = $val['consent_school_count'];
		   $consentcollage[] = $val['consent_collage_count'];
$consentclasses[] = $val['consent_classes_count'];
$consenttotal[]=$val['consent_total'];
$seminarsschool[]=$val['seminars_school_count'];
$seminarscollage[]=$val['seminars_collage_count'];
$seminarsclasses[]=$val['seminars_classes_count'];
$seminarstotal[]=$val['seminars_total'];
$studentschool[]=$val['student_school_count'];
$studentcollage[]=$val['student_collage_count'];
$studentclasses[]=$val['student_classes_count'];
$studenttotal[]=$val['student_total'];	
$fromic[]=$val['work_report'];

			 $bd_name = $val['fname'].' '.$val['lname'];
		  if($this->session->userdata("role_id")=='1'){
			   $this->excel->getActiveSheet()->setCellValue('A'.$row, $val['ic_name']);	
			$this->excel->getActiveSheet()->setCellValue('B'.$row,  $bd_name);	
		  }elseif($this->session->userdata("role_id")=='7'){
			  $this->excel->getActiveSheet()->setCellValue('A'.$row, $bd_name);
			  $this->excel->getActiveSheet()->setCellValue('B'.$row, date('d-M',strtotime($val['date'])));
		  }else{
			  $this->excel->getActiveSheet()->setCellValue('A'.$row, $j);
			  $this->excel->getActiveSheet()->setCellValue('B'.$row, date('d-M',strtotime($val['date'])));
            }		  
          $this->excel->getActiveSheet()->setCellValue('C'.$row, $val['consent_school_count']);
		  $this->excel->getActiveSheet()->setCellValue('D'.$row, $val['consent_collage_count']);
		  $this->excel->getActiveSheet()->setCellValue('E'.$row, $val['consent_classes_count']);
		  $this->excel->getActiveSheet()->setCellValue('F'.$row, $val['consent_total']);
		  $this->excel->getActiveSheet()->getStyle('F'.$row)->getFont()->setBold(true);
		  $this->excel->getActiveSheet()->setCellValue('G'.$row, $val['seminars_school_count']);
		  $this->excel->getActiveSheet()->setCellValue('H'.$row, $val['seminars_collage_count']);
		  $this->excel->getActiveSheet()->setCellValue('I'.$row, $val['seminars_classes_count']);
		  $this->excel->getActiveSheet()->setCellValue('J'.$row, $val['seminars_total']);
		  $this->excel->getActiveSheet()->getStyle('J'.$row)->getFont()->setBold(true);
		  $this->excel->getActiveSheet()->setCellValue('K'.$row, $val['student_school_count']);
		  $this->excel->getActiveSheet()->setCellValue('L'.$row, $val['student_collage_count']);
		  $this->excel->getActiveSheet()->setCellValue('M'.$row, $val['student_classes_count']);
		  $this->excel->getActiveSheet()->setCellValue('N'.$row, $val['student_total']);
		  $this->excel->getActiveSheet()->getStyle('N'.$row)->getFont()->setBold(true);
		  $this->excel->getActiveSheet()->setCellValue('O'.$row, $val['work_report']);
		   
		  $row = $row+1;
		  $j=$j+1;
			
		}
		
		$this->excel->getActiveSheet()->setCellValue('A'.$row, 'Total');
		$this->excel->getActiveSheet()->getStyle('A'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $this->excel->getActiveSheet()->mergeCells('A'.$row.':B'.$row);
		$this->excel->getActiveSheet()->setCellValue('C'.$row, array_sum($consentschool));
		$this->excel->getActiveSheet()->setCellValue('D'.$row, array_sum($consentcollage));
		$this->excel->getActiveSheet()->setCellValue('E'.$row, array_sum($consentclasses));
		$this->excel->getActiveSheet()->setCellValue('F'.$row, array_sum($consenttotal));
		$this->excel->getActiveSheet()->setCellValue('G'.$row, array_sum($seminarsschool));
		$this->excel->getActiveSheet()->setCellValue('H'.$row, array_sum($seminarscollage));
		$this->excel->getActiveSheet()->setCellValue('I'.$row, array_sum($seminarsclasses));
		$this->excel->getActiveSheet()->setCellValue('J'.$row, array_sum($seminarstotal));
		$this->excel->getActiveSheet()->setCellValue('K'.$row, array_sum($studentschool));
		$this->excel->getActiveSheet()->setCellValue('L'.$row, array_sum($studentcollage));
		$this->excel->getActiveSheet()->setCellValue('M'.$row, array_sum($studentclasses));
		$this->excel->getActiveSheet()->setCellValue('N'.$row, array_sum($studenttotal));
		$this->excel->getActiveSheet()->setCellValue('O'.$row, array_sum($fromic));
                  

		$this->excel->getActiveSheet()->getStyle('A'.$row.':P'.$row)->getFont()->setBold(true);
		
$filename='ic_report_'.$smonth.'.xls'; //save our workbook as this file name
header('Content-Type: application/vnd.ms-excel'); //mime type
header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
header('Cache-Control: max-age=0'); //no cache
$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
//force user to download the Excel file without writing it to server's HD
$objWriter->save('php://output');





  }
    function smsbdreport($rdate)
    {
		$this->load->model('Bd_reporting_model');
		if($rdate !=''){
			$smonth  = $rdate;
		}
        else{
			$smonth  = date('d-m-Y');
		}
		//echo $smonth;exit;
        $ic_rec  = $this->Bd_reporting_model->get_ic_reporting_admin($smonth);

        $tot_rec = $this->Bd_reporting_model->get_total_ic_reporting_count($smonth);
		
		$mobile_nos = $this->Bd_reporting_model->fetch_bd_user_mobiles($ic_rec[0]['icCode']);
		//print_r($tot_rec);
		$m = "";
		foreach($mobile_nos as $mo){
			$m .= $mo['mobile_official'].',';
		}
		$mobile = rtrim($m,',');
        // send sms functionality
        $this->load->library('Mylibrary');
        $test    = NEW CI_Mylibrary();
        $mob     = '9821739610,9870841482,9545453097';
        $content = "IC Name: " . strtoupper($ic_rec[0]['ic_code']) . " 
BD: " .$ic_rec[0]['fname'] .' '.$ic_rec[0]['lname']."  		
Date: " .$smonth. " 

Consent Received
School: " . $ic_rec[0][consent_school_count] . " (" . $tot_rec[0][consent_school_count] . ") 	
College: " . $ic_rec[0][consent_collage_count] . " (" . $tot_rec[0][consent_collage_count] . ") 
Classes: " . $ic_rec[0][consent_classes_count] . " (" . $tot_rec[0][consent_classes_count] . ") 
Total: " . $ic_rec[0][consent_total] . " (" . $tot_rec[0][consent_total] . ") 

Seminar Conducted
School: " . $ic_rec[0][seminars_school_count] . " (" . $tot_rec[0][seminars_school_count] . ") 	
College: " . $ic_rec[0][seminars_collage_count] . " (" . $tot_rec[0][seminars_collage_count] . ") 
Classes: " . $ic_rec[0][seminars_classes_count] . " (" . $tot_rec[0][seminars_classes_count] . ") 
Total: " . $ic_rec[0][seminars_total] . " (" . $tot_rec[0][seminars_total] . ") 

Student Present
School: " . $ic_rec[0][student_school_count] . " (" . $tot_rec[0][student_school_count] . ") 	
College: " . $ic_rec[0][student_collage_count] . " (" . $tot_rec[0][student_collage_count] . ") 
Classes: " . $ic_rec[0][student_classes_count] . " (" . $tot_rec[0][student_classes_count] . ") 
Total: " . $ic_rec[0][student_total] . " (" . $tot_rec[0][student_total] . ") 


From,
Sandip University";
//echo "<pre>";
		//echo $content;        exit;
        $test->sendSms($mob, $content);
        
        ////////////////SEND SMS END///////////////////
    }    
}
?>