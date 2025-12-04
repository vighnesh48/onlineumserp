<?php
ini_set("display_errors", "On");

defined('BASEPATH') OR exit('No direct script access allowed');
define("MODEL_NM","course_model");
class Prospectus_fee_details extends CI_Controller 
{
    var $currentModule="";
    var $title="";
    var $table_name="prospectus_fee_details";
    var $model_name="Prospectus_fee_details_model";
    var $model;
    var $view_dir='prospectus/';
    var $data=array();
    public function __construct() 
    {
        global $menudata;
        parent:: __construct();
         
        $this->load->helper("url");	
        $this->load->model('Prospectus_fee_details_model');
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
        
        $menu_name=$this->uri->segment(1);        
        $this->data['my_privileges']=$this->retrieve_privileges($menu_name);
    }
    
    public function index($type='')
    {
        /*error_reporting(E_ALL);
         ini_set('display_errors', TRUE); */
        $this->load->view('header',$this->data); 
		
		if($type=='online'){
			$this->data['student_prospectus_fee_details']= $this->Prospectus_fee_details_model->online_admform_fees_details();
		}else{		
			$this->data['student_prospectus_fee_details']= $this->Prospectus_fee_details_model->student_prospectus_fees_details();
		}
        /*print_r($this->data['student_prospectus_fee_details']);
        die;*/
        $this->load->view($this->view_dir.'prospectus_details_list',$this->data);
        $this->load->view('footer');
    }
    public function student_prospectus_add($mobileno="")
    {   
       /*  error_reporting(E_ALL);
         ini_set('display_errors', TRUE); */
         $csid='';
	     $mobile='';
		 $mobile=$_REQUEST['mobile'];
		 $csid=$_REQUEST['csid'];

		//exit;
        $this->load->view('header',$this->data);    
        $this->data['course_details']= $this->Prospectus_fee_details_model->get_course_details();
         if($mobileno!='')
        {
            $this->data['mobilnparamer']=$mobileno;
        }
		$this->data['mobile_from']=$mobile;
		$this->data['counsellorid']=$csid;
        $this->load->view($this->view_dir.'prospectus_details',$this->data);
        $this->load->view('footer');
    }
    //*vikas singh created download pdf code with barcode
    public function student_prospectus_downloadpdf($id,$barcodee)
    {
        $data = base64_decode($id);
        $barcode_no = base64_decode($barcodee);
         $this->load->library('zend');
        //load in folder Zend
        $this->zend->load('Zend/Barcode');
        $imageResource = Zend_Barcode::factory('code128', 'image', array('text'=>$barcode_no), array())->draw();
        imagepng($imageResource, 'barcodes/'.$barcode_no.'.png');
        $rpdf=$data;
        //load mpdf library
       $this->load->library('M_pdf');
       //$mpdf=new mPDF('utf-8', 'A4-L');
       $mpdf=new mPDF('utf-8','A4', 0, '', 20, 20, 10, 10, 9, 9, 'L');
       
        if($rpdf=='2')
        {
            $this->data['regular']='2';
            $this->data['barcode_no']=$barcode_no;
            $html = $this->load->view($this->view_dir . 'prospectus_pdf', $this->data, true);
            $pdfFilePath = 'Regular_prospectus.pdf'; 
            
        }
        else
        {
             $this->data['regular']='1';
             $this->data['barcode_no']=$barcode_no;
            $html = $this->load->view($this->view_dir . 'prospectus_pdf', $this->data, true);
            $pdfFilePath = 'parttime_prospectus.pdf';


        }
            $mpdf->SetHTMLHeader('<div class="row bottom-text" style="margin-bottom:0px;Xheight:30px;"></div>');
            $mpdf->SetHTMLFooter('<br><div class="row xbottom-text" style="margin-bottom:10px;height:30px;"></div>');
            $mpdf->WriteHTML($html);
            $mpdf->Output($pdfFilePath, "D");
        
    }
    //end of the function
    public function student_prospectus_receiptpdf($id,$barcodee)
    {
            $id = base64_decode($id);

      $this->data['student_prospectus_fee_details']= $this->Prospectus_fee_details_model->student_prospectus_fees_details_by($id);
          /*  print_r($this->data['student_prospectus_fee_details']);
            die;*/
            $this->load->library('M_pdf');
            //$mpdf=new mPDF('utf-8', 'A4-L');
            $mpdf=new mPDF('utf-8','A4', 0, '', 20, 20, 10, 10, 9, 9, 'L');
            $html = $this->load->view($this->view_dir . 'receipt_pdf', $this->data, true);
            $pdfFilePath = 'parttime_prospectus.pdf';
            $mpdf->SetHTMLHeader('<div class="row bottom-text" style="margin-bottom:0px;Xheight:30px;"></div>');
         /*   $mpdf->SetHTMLFooter('<br><div class="row xbottom-text" style="margin-bottom:10px;height:30px;"></div>');*/
/*         $mpdf->SetHTMLFooter('<div class="pdf_date" style="color:black
text-align:left;" ></div>
<div class="pdf_pagination" style="color:black; text-align:right;">
</div>'
);*/
            $mpdf->WriteHTML($html);
            $mpdf->Output($pdfFilePath, "I");   
    }
    
     function fetch_course_details() {
		 
		 $select_course=$_REQUEST['select_course'];
        if (isset($_POST["coursetype"]) && !empty($_POST["coursetype"])) {
            //Get all city data
            $course = $this->Prospectus_fee_details_model->get_course_details($_POST["coursetype"]);

            //Count total number of rows
            $rowCount = count($course);
          
            //Display course list
            if ($rowCount > 0) {
                echo '<option value="">Select Course</option>';
                foreach ($course as $value) {
					if($select_course==$value['course_id']){ $sel='selected="selected"';}else{$sel='';}
                    echo '<option value="' . $value['course_id'] . '"'.$sel.'>' . $value['course'] . '</option>';
                }
            } else {
                echo '<option value="">Course not available</option>';
            }
        }
        echo '<script>
        $("#coursen").select2
        ({
              placeholder: "Select ",
              allowClear: true
        });</script>';
    }
    //insert prospectus record in database table
    public function submit()
    {
		
		
       //$mob =$this->Prospectus_fee_details_model->chek_mob_exist( $_POST['mobile']);
       
        $formno=$_POST['formno'];
        
        
         $formno_exist_withapprovenoo =$this->Prospectus_fee_details_model->chek_formno_exist_withapprove($formno);
// print_r($formnoo) ;
//echo '<br>';
   // print_r($_POST);
	//exit;
        if(empty($formno_exist_withapprovenoo))
        {
           
             $this->load->view('header',$this->data);
            $this->data['validation_errors']='Form no does not exist in Database';
            $this->load->view($this->view_dir.'prospectus_details',$this->data);
            $this->load->view('footer');
        }
        else
        {
            //check if form no already given to other user
             $chek_formno_alreadygiventostudent =$this->Prospectus_fee_details_model->chek_formno_exist($formno);
            // print_r($formnoo) ;
             if(!empty($chek_formno_alreadygiventostudent))
             {
               
                $this->load->view('header',$this->data);
                $this->data['validation_errors']="You have already registered with us using this form no";
                $this->load->view($this->view_dir.'prospectus_details',$this->data);
                $this->load->view('footer');

             }
             else
             {
                if(!empty($_POST))
                { 

                   if(!empty($_FILES['picture']['name'])){
                        $config['upload_path'] = 'uploads/prospectus/';
                        $config['allowed_types'] = 'jpg|jpeg|png|gif';
                        $config['file_name'] = $_FILES['picture']['name'];
                        
                        //Load upload library and initialize configuration
                        $this->load->library('upload',$config);
                        $this->upload->initialize($config);
                        
                        if($this->upload->do_upload('picture')){
                            $uploadData = $this->upload->data();
                            $picture = $uploadData['file_name'];

                        }else{
                            $picture = '';
                        }
                    }else{

                        $picture = '';
                    }
                   
                        $last_inserted_id=$this->Prospectus_fee_details_model->insert_prospectusform($_POST,$picture); 
                                         //exit;
                        if($last_inserted_id==2)
                        {
                           if(isset($_POST['TransToAdmin'])){
						   if($_POST['TransToAdmin']=='Y'){
							   redirect('GetPass/CounsellorDesk');
						   }else{
							   redirect('GetPass/CounsellorDesk');
						   }
						   }else{
                            redirect(base_url('Prospectus_fee_details'));
						   }
                        }
                        else
                        {
                            redirect(base_url('Prospectus_fee_details'));
                        }
                }
                else
                {
                    
                    redirect(base_url('Prospectus_fee_details'));
                    
                }

             }


              

        }
      
    }
    public function export_excel_forprospectus()
    {
            $this->load->library('excel');
        $student_prospectus_fees_details=$this->Prospectus_fee_details_model->student_prospectus_fees_details();
        $this->load->library('excel');
        $styleArray = array(
        'borders' => array(
          'allborders' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN
            ))
        );
        $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->getStyle('A1:I1')->getFont()->setBold(true);
         $this->excel->getActiveSheet()->getStyle('A1:I1')->applyFromArray($styleArray);
        $this->excel->getActiveSheet()->setTitle('Student Prospectus Details list');
        $this->excel->getActiveSheet()->setCellValue('A1', 'Sr.no');
        $this->excel->getActiveSheet()->setCellValue('B1', 'IC Name');
        $this->excel->getActiveSheet()->setCellValue('C1', 'Ic Code');
        $this->excel->getActiveSheet()->setCellValue('D1', 'Student Name');
        $this->excel->getActiveSheet()->setCellValue('E1', 'Form no');
        $this->excel->getActiveSheet()->setCellValue('F1', 'Course');
        $this->excel->getActiveSheet()->setCellValue('G1', 'Mobile No');
        $this->excel->getActiveSheet()->setCellValue('H1', 'Email');
        $this->excel->getActiveSheet()->setCellValue('I1', 'Amount');
        
        $row=2;
        $j=1;
        foreach($student_prospectus_fees_details as $val){
            if($val['status']=='Y')
                $status='Active';
            else
                $status='In Active';
            $this->excel->getActiveSheet()->setCellValue('A'.$row, $j); 
            $this->excel->getActiveSheet()->setCellValue('B'.$row, $val['fname'].' '.$val['lname']);
            $this->excel->getActiveSheet()->setCellValue('C'.$row,$val['ic_code'] );
            $this->excel->getActiveSheet()->setCellValue('D'.$row, $val['student_name']);
            $this->excel->getActiveSheet()->setCellValue('E'.$row,$val['adm_form_no']);
            $this->excel->getActiveSheet()->setCellValue('F'.$row, $val['sprogramm_name']);
            $this->excel->getActiveSheet()->setCellValue('G'.$row, $val['mobile1']);
            $this->excel->getActiveSheet()->setCellValue('H'.$row, $val['email']);
            $this->excel->getActiveSheet()->setCellValue('I'.$row, $val['amount']);
             
          $row = $row+1;
          $j=$j+1;          
        }
            $k = $j+1;
             for($p=0; $p<$k; $p++){
                

            $this->excel->getActiveSheet()->getStyle("A".$p.":I".$p)->applyFromArray($styleArray);
            
           }
        $filename='|Student_Prospectus_fees_details.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
    }

        // check mobile exist
        public function chek_dupmobno_exist(){

            $mobile_no=$_REQUEST['mobile_no'];
           
            //echo $state;
            $mob =$this->Prospectus_fee_details_model->chek_mob_exist($mobile_no);
            $cnt_mob = count($mob);
            if($cnt_mob > 0){
                echo "Duplicate~".json_encode($mob);
            }else{
                echo "regular~1";
            }
        }
      // check duplicate form no exist
        public function chek_formno_exist(){

            $formno=$_REQUEST['newforno'];
           
            //echo $state;
            $mob =$this->Prospectus_fee_details_model->chek_formno_exist($formno);
            $cnt_mob = count($mob);
            if($cnt_mob > 0){
                echo "Duplicate~".json_encode($mob);
            }else{
                echo "regular~1";
            }
        }
               // check duplicate form no approve status exist
        public function chek_formno_exist_withapprove(){

            $formno=$_REQUEST['newforno'];
           
            //echo $state;
            $mob =$this->Prospectus_fee_details_model->chek_formno_exist_withapprove($formno);
            $cnt_mob = count($mob);
            if($cnt_mob > 0){
                echo "regular~1".json_encode($mob);
            }else{
                echo "duplicate";
            }
        }
         // check duplicate mobile no exist
        public function serach_details(){
         
        $mobile_no = trim($_REQUEST['mobile_no']);
        //echo $state;
        $mob = $this->Prospectus_fee_details_model->chek_mob_exist($mobile_no);
      
        //$this->data['ic']  = $this->Sujee_model->get_ic_name();
        //print_r($mob);exit;
        $cnt_mob   = count($mob);
        //echo $mob[0]['sujee_apperaed'];
        if($cnt_mob > 0){
            
                echo json_encode($mob);
            } else{
                echo "no";
               
            }
    
    }

    
    
    
}
?>