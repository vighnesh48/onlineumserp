<?php
ini_set("display_errors", "On");
error_reporting(1);
defined('BASEPATH') OR exit('No direct script access allowed');
define("MODEL_NM","course_model");
class Fees_collection extends CI_Controller 
{
    var $currentModule="";
    var $title="";
    var $table_name="course_master";
    var $model_name="Fees_model";
    var $model;
    var $view_dir='Fees_Collection/';
    var $data=array();
    public function __construct() 
    {
        global $menudata;
        parent:: __construct();
        
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
         $this->load->model('Fees_school_model');
        $menu_name=$this->uri->segment(1);        
        $this->data['my_privileges']=$this->retrieve_privileges($menu_name);
		if($this->session->userdata("role_id")==5 || $this->session->userdata("role_id")==6 || $this->session->userdata("role_id")==40){
		}else{
			redirect('home');
		}
    }
    
    public function index()
    {
        $this->load->view('header',$this->data);    
       $this->data['sdetails']=$this->Fees_model->get_form_details();
		$this->data['college_details']= $this->Fees_model->get_college_details();	   
        $this->load->view($this->view_dir.'view',$this->data);
        $this->load->view('footer');
    }
    
    public function add()
    {
        $this->load->view('header',$this->data);    
		$this->data['college_details']= $this->Fees_model->get_college_details();
        $this->load->view($this->view_dir.'add',$this->data);
        $this->load->view('footer');
    }
     public function submit()
    {       
        $id = $this->Fees_model->add_uniform_details($_POST);
		if($id==1){
			redirect(base_url("Fees_collection/view?error=0"));
		}else{
			redirect(base_url("Fees_collection/view?error=1"));
		}
		
    }  
	public function get_course_name($cid)
    {       
        $crs = $this->Fees_model->get_course_name_bycollegeid($cid);
		echo "<option value=''>Course Name</option>";
		foreach($crs as $val){			
			echo "<option value='".$val['course_name']."'>".$val['course_name']."</option>";
		}
	}
		
	public function get_branch_name($colid,$crs)
    {       
        $crs = $this->Fees_model->get_branch_name($colid,$crs);
		echo "<option value=''>Branch Name</option>";
		foreach($crs as $val){
			echo "<option value='".$val['sf_program_id']."'>".$val['branch_name']."</option>";
		}
	}
    public function view()
    {
        $this->load->view('header',$this->data);        
          $this->data['sdetails']=$this->Fees_model->get_form_details();
$this->data['college_details']= $this->Fees_model->get_college_details();	               
        $this->load->view($this->view_dir.'view',$this->data);
        $this->load->view('footer');
    }
    public function search()
    {        
        $colg=$_REQUEST['colg'];
		$cr=$_REQUEST['crn'];
		$br=$_REQUEST['brn'];
		$year=$_REQUEST['year'];
		$srchdate=$_REQUEST['srchdate'];
        $sdetails=  $this->Fees_model->get_form_details($colg,$cr,$br,$year,$srchdate);  
        	$total=0;
		$stud_count=0;
         if(count($sdetails)>0){
            $j = 1;
        for($i=0;$i<count($sdetails);$i++)
                            {
                                
                        echo '<tr><td>'.$j.'</td>'; 
                          echo '<td>'.$sdetails[$i]['college_code'].'</td>';
                            
                                 $col = $this->session->userdata('name');
		$ex = explode("_",$col);
		
		if($ex[0]=='sf'){ 
		    $cn = $this->Fees_model->get_su_course_name($sdetails[$i]['program_id']);
		  if($sdetails[$i]['college_code'] == 'SU'){
                       echo '<td>'.$cn[0]['course_name'].'</td>';
                       echo '<td>'.$cn[0]['branch_name'].'</td>';
		    
	 }else{ 
	    echo '<td>'.$sdetails[$i]['course_name1'].'</td>';
        echo '<td>'.$sdetails[$i]['branch_short_name'].'</td>';
	}	    
		}else{
                            
                      echo '<td>'.$sdetails[$i]['course_name1'].'</td>';
                      echo '<td>'.$sdetails[$i]['branch_short_name'].'</td>';
                                 }
								echo '<td>'.$sdetails[$i]['course_year1'].'</td>';
								echo '<td>'.$sdetails[$i]['reg_no'].'</td>';
								echo '<td>'.$sdetails[$i]['name'].'</td>';
								echo '<td>'.$sdetails[$i]['receipt_no'].'</td>';
								echo '<td>'.$sdetails[$i]['paid_date'].'</td>';
								echo '<td>'.$sdetails[$i]['amount'].'</td>';
                                echo '<td>'.$sdetails[$i]['bankname'].'</td>';
                           echo '</tr>';
                            $total+=$sdetails[$i]['amount'];
                          
                            $j++;
                            }
                             if($colg == 'd'){
							 echo "<tr><td colspan='9'></td><td><b>". $total."</b></td></tr>";
								}
								else
								{
								     	 echo "<tr><td colspan='9'></td><td><b>". $total."</b></td></tr>";
								}
        }else{
             echo '<tr><td colspan="10">No Records Found.</td></tr>'; 
        }                            
        
       // echo json_encode(array("fees_details"=>$fees_details));
    } 


  public function fees_reports(){
      $this->load->view('header',$this->data);        
          $this->data['sdetails']=$this->Fees_model->get_search_report_details('');
              $this->data['college_details']= $this->Fees_model->get_college_details();	   
        $this->load->view($this->view_dir.'fees_reports',$this->data);
        $this->load->view('footer');
  }
    
   public function search_report(){
        $colg=$_REQUEST['colg'];
		$dt=$_REQUEST['dt'];
		$colnam = $_REQUEST['colnam'];
		$total=0;
		$stud_count=0;
		
        $sdetails=  $this->Fees_model->get_search_report_details($colg,$dt,$colnam);  
        //echo json_encode(array("fees_details"=>$sdetails));
           $j=1;                            
                            for($i=0;$i<count($sdetails);$i++)
                            {
                                
                            echo '<tr><td>'.$j.'</td>'; 
                             if($sdetails[$i]['college_code'] == 'SU'){ 
                                $coursename = $this->Fees_model->get_su_course_name($sdetails[$i]['program_id']);
                            
                                echo '<td>'.$sdetails[$i]['college_code'].'</td>';
                       echo '<td>'.$coursename[0]['course_name'].'</td>';
                             echo '<td>'.$coursename[0]['branch_name'].'</td>';
                            }else{ 
                                echo '<td>'.$sdetails[$i]['college_code'].'</td>';
                       echo '<td>'.$sdetails[$i]['course_name1'].'</td>';
                              echo '<td>'.$sdetails[$i]['branch_short_name'].'</td>';
                                 } 
								echo '<td>'.$sdetails[$i]['course_year1'].'</td>';
							
								echo '<td>'.$sdetails[$i]['scnt'].'</td>';
								echo '<td>'.$sdetails[$i]['am'].'</td>';
								if($colg == 'd'){
								echo '<td>'.$sdetails[$i]['paid_date'].'</td>';
								}
								
                          echo '</tr>';
                          $total+=$sdetails[$i]['am'];
                            $stud_count+=$sdetails[$i]['scnt'];
                            $j++;
                            }
                            
                            if($colg == 'd'){
							 echo "<tr><td colspan='5'></td><td>". $stud_count."</td><td>". $total."</td></tr>";
								}
								else
								{
								     echo "<tr><td colspan='5'></td><td>".$stud_count."</td><td>". $total."</td></tr>";
								}
                           
   }

    public function day_wise_fees_reports(){

      $this->load->view('header',$this->data);
      if(isset($_POST) && $_POST['date'] !=''){
		 $this->data['date']=$_POST['date'];
	  }
	  else{
		  $_POST['date']=date('Y-m-d');
		 
	  }
	  if(isset($_POST) && $_POST['by_type'] !=''){
		 $this->data['bytype']=$_POST['by_type'];  
		
	  }
	  else{
	     $this->data['bytype']=2;  
		 $_POST['by_type']=2;
	  }
	  $this->data['date']=$_POST['date'];  
	 
	  
	   /* total sdales based on types */
      $this->data['sale_by_pos']=$this->Fees_model->get_day_wise_fees_collection_details_sale_by_pos();
	  $this->data['sale_by_cheque']=$this->Fees_model->get_day_wise_fees_collection_details_sale_by_cheque();
	  $this->data['sale_by_dd']=$this->Fees_model->get_day_wise_fees_collection_details_sale_by_dd();
	  $this->data['sale_by_ol']=$this->Fees_model->get_day_wise_fees_collection_details_sale_by_ol();
	  $this->data['sale_by_pg']=$this->Fees_model->get_day_wise_fees_collection_details_sale_by_pg();
	  $this->data['sale_by_itf']=$this->Fees_model->get_day_wise_fees_collection_details_sale_by_itf();
	  $this->data['sale_by_recpt']=$this->Fees_model->get_day_wise_fees_collection_details_sale_by_recpt();
	  $this->data['sale_by_chln']=$this->Fees_model->get_day_wise_fees_collection_details_sale_by_chln();
	  $this->data['sale_by_others']=$this->Fees_model->get_day_wise_fees_collection_details_sale_by_others();
	  
	  
	  /* sales based on categories */
	  $this->data['sale_by_academic_new_admission']=$this->Fees_model->get_day_wise_fees_collection_details_sale_by_academic_new_admission();
	  $this->data['sale_by_academic_reregistration']=$this->Fees_model->get_day_wise_fees_collection_details_sale_by_academic_reregistration();
	  
	  //print_r( $this->data['sale_by_academic_reregistration']);
	  //exit;
	  $this->data['sale_by_academic_phd']=$this->Fees_model->get_day_wise_fees_collection_details_sale_by_academic_phd();
	  $this->data['sale_by_academic_illp']=$this->Fees_model->get_day_wise_fees_collection_details_sale_by_academic_illp();
	  $this->data['sale_by_exam_new_admission']=$this->Fees_model->get_day_wise_fees_collection_details_sale_by_exam_new_admission();
	  $this->data['sale_by_exam_phd']=$this->Fees_model->get_day_wise_fees_collection_details_sale_by_exam_phd();
	  $this->data['sale_by_exam_reregistration']=$this->Fees_model->get_day_wise_fees_collection_details_sale_by_exam_reregistration();
	  $this->data['sale_by_exam_illp']=$this->Fees_model->get_day_wise_fees_collection_details_sale_by_exam_illp();
	  $this->data['sale_by_internal_external']=$this->Fees_model->get_day_wise_fees_collection_details_sale_by_internal_external();
	  
	  /* total sdales based on academics and exams */
	  $this->data['total_sale_by_academic_new_admission']=$this->Fees_model->get_day_wise_fees_collection_details_sale_by_academic_new_admission_total();
	  $this->data['total_sale_by_academic_reregistration']=$this->Fees_model->get_day_wise_fees_collection_details_sale_by_academic_reregistration_total();
	   $this->data['total_sale_by_academic_phd']=$this->Fees_model->get_day_wise_fees_collection_details_sale_by_academic_phd_total();
	  
	  $this->data['total_sale_by_academic_illp']=$this->Fees_model->get_day_wise_fees_collection_details_sale_by_academic_illp_total();
	  $this->data['total_sale_by_exam_new_admission']=$this->Fees_model->get_day_wise_fees_collection_details_sale_by_exam_new_admission_total();
	  $this->data['total_sale_by_exam_phd']=$this->Fees_model->get_day_wise_fees_collection_details_sale_by_exam_phd_total();
	  $this->data['total_sale_by_exam_reregistration']=$this->Fees_model->get_day_wise_fees_collection_details_sale_by_exam_reregistration_total();
	  $this->data['total_sale_by_exam_illp']=$this->Fees_model->get_day_wise_fees_collection_details_sale_by_exam_illp_total();
	  $this->data['total_sale_by_internal_external']=$this->Fees_model->get_day_wise_fees_collection_details_sale_by_internal_external_total();
	  
	 
	  //
      $this->load->view($this->view_dir.'report/day_wise_collection_report',$this->data);
      $this->load->view('footer');
  }
 //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
 
 
 
 //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  public function day_wise_fees_reports_school(){

      $this->load->view('header',$this->data);
      if(isset($_POST) && $_POST['date'] !=''){
		 $this->data['date']=$_POST['date'];
	  }
	  else{
		  $_POST['date']=date('Y-m-d');
		 
	  }
	  if(isset($_POST) && $_POST['by_type'] !=''){
		 $this->data['bytype']=$_POST['by_type'];  
		
	  }
	  else{
	     $this->data['bytype']=2;  
		 $_POST['by_type']=2;
	  }
	  $this->data['date']=$_POST['date'];  
	 
	  
	   /* total sdales based on types */
      $this->data['sale_by_pos']=$this->Fees_school_model->get_day_wise_fees_collection_details_sale_by_pos();
	  $this->data['sale_by_cheque']=$this->Fees_school_model->get_day_wise_fees_collection_details_sale_by_cheque();
	  $this->data['sale_by_dd']=$this->Fees_school_model->get_day_wise_fees_collection_details_sale_by_dd();
	  $this->data['sale_by_ol']=$this->Fees_school_model->get_day_wise_fees_collection_details_sale_by_ol();
	  $this->data['sale_by_pg']=$this->Fees_school_model->get_day_wise_fees_collection_details_sale_by_pg();
	  $this->data['sale_by_itf']=$this->Fees_school_model->get_day_wise_fees_collection_details_sale_by_itf();
	  $this->data['sale_by_recpt']=$this->Fees_school_model->get_day_wise_fees_collection_details_sale_by_recpt();
	  $this->data['sale_by_chln']=$this->Fees_school_model->get_day_wise_fees_collection_details_sale_by_chln();
	  $this->data['sale_by_others']=$this->Fees_school_model->get_day_wise_fees_collection_details_sale_by_others();
	  
	  
	  /* sales based on categories */
	  $this->data['sale_by_academic_new_admission']=$this->Fees_school_model->get_day_wise_fees_collection_details_sale_by_academic_new_admission();
	  $this->data['sale_by_academic_reregistration']=$this->Fees_school_model->get_day_wise_fees_collection_details_sale_by_academic_reregistration();
	  
	  //print_r( $this->data['sale_by_academic_reregistration']);
	  //exit;
	  $this->data['sale_by_academic_phd']=$this->Fees_school_model->get_day_wise_fees_collection_details_sale_by_academic_phd();
	  $this->data['sale_by_academic_illp']=$this->Fees_school_model->get_day_wise_fees_collection_details_sale_by_academic_illp();
	  $this->data['sale_by_exam_new_admission']=$this->Fees_school_model->get_day_wise_fees_collection_details_sale_by_exam_new_admission();
	  $this->data['sale_by_exam_phd']=$this->Fees_school_model->get_day_wise_fees_collection_details_sale_by_exam_phd();
	  $this->data['sale_by_exam_reregistration']=$this->Fees_school_model->get_day_wise_fees_collection_details_sale_by_exam_reregistration();
	  $this->data['sale_by_exam_illp']=$this->Fees_school_model->get_day_wise_fees_collection_details_sale_by_exam_illp();
	  $this->data['sale_by_internal_external']=$this->Fees_school_model->get_day_wise_fees_collection_details_sale_by_internal_external();
	  
	  /* total sdales based on academics and exams */
	  $this->data['total_sale_by_academic_new_admission']=$this->Fees_school_model->get_day_wise_fees_collection_details_sale_by_academic_new_admission_total();
	  $this->data['total_sale_by_academic_reregistration']=$this->Fees_school_model->get_day_wise_fees_collection_details_sale_by_academic_reregistration_total();
	   $this->data['total_sale_by_academic_phd']=$this->Fees_school_model->get_day_wise_fees_collection_details_sale_by_academic_phd_total();
	  
	  $this->data['total_sale_by_academic_illp']=$this->Fees_school_model->get_day_wise_fees_collection_details_sale_by_academic_illp_total();
	  $this->data['total_sale_by_exam_new_admission']=$this->Fees_school_model->get_day_wise_fees_collection_details_sale_by_exam_new_admission_total();
	  $this->data['total_sale_by_exam_phd']=$this->Fees_school_model->get_day_wise_fees_collection_details_sale_by_exam_phd_total();
	  $this->data['total_sale_by_exam_reregistration']=$this->Fees_school_model->get_day_wise_fees_collection_details_sale_by_exam_reregistration_total();
	  $this->data['total_sale_by_exam_illp']=$this->Fees_school_model->get_day_wise_fees_collection_details_sale_by_exam_illp_total();
	  $this->data['total_sale_by_internal_external']=$this->Fees_school_model->get_day_wise_fees_collection_details_sale_by_internal_external_total();
	  
	 
	  //
      $this->load->view($this->view_dir.'report/day_wise_collection_report',$this->data);
      $this->load->view('footer');
  }   
    
}
?>