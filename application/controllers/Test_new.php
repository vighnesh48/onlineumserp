<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Test_new extends CI_Controller 
{
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
        
        $menu_name=$this->uri->segment(1);        
        $this->data['my_privileges']=$this->retrieve_privileges($menu_name);
    }	
	
	function check_date(){
	echo date('Ymdhis');
	}
	public function Test_sms(){
	//ini_set('error_reporting', E_ALL);
echo '1';


//http://162.241.114.66/api/send_sms?api_key=APIKEY&text=TEXT&mobiles=9926765557&unicode=0&sender_id=SENDERID&template_id=TEMPLATEID

//API Key :  3126098cf46a2ca0

  //$user_mobile = $udf3;//$udf4//9545453488,9545453087,8850633088;
	 $sms_message=urlencode("Dear Student
Your payment of Rs {32323323}. is duly received and tranction no -  {32323323}. Your Receipt Number is   {32323323}. Your Provisional PRN No is   {32323323}. please check your Email
Thanks
Sandip University");
 //$sms=$sms_message;
 
   $message="Dear Student
Your payment of Rs {32323323}. is duly received and tranction no -  {212112}. Your Receipt Number is   {1212112}. Your Provisional PRN No is   {212121}. please check your Email
Thanks
Sandip University";
 //$sms=$sms_message;
 
/* $ch = curl_init();
   
    $query="?api_key=3126098cf46a2ca0&text=$sms_message&mobiles=9960006338&unicode=0&sender_id=SENDERID&template_id=1107161951409075253";
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_URL,'http://162.241.114.66/api/send_sms' . $query); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    $res = trim(curl_exec($ch));
    curl_close($ch);
	print_r($res);*/
	$cURLConnection = curl_init();

curl_setopt($cURLConnection, CURLOPT_URL, 'http://162.241.114.66/api/send_sms?api_key=3126098cf46a2ca0&text=$sms_message&mobiles=9960006338&unicode=0&sender_id=SANDIP&template_id=1107161951409075253');
curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);

$phoneList = curl_exec($cURLConnection);
print_r($phoneList);
curl_close($cURLConnection);

$jsonArrayResponse - json_decode($phoneList);
	print_r($phoneList);
	//http://162.241.114.66/api/send_sms?api_key=3126098cf46a2ca0&text=Test&mobiles=9960006338&unicode=0&sender_id=SENDERID&template_id=1107161951409075253
}


function main_test(){
	error_reporting(E_ALL);
echo "1112";
}
	
	
	
	function New_testing(){
		$sms_message=urlencode("Dear Student
Your payment of Rs {32323323}. is duly received and tranction no -  {32323323}. Your Receipt Number is   {32323323}. Your Provisional PRN No is   {32323323}. please check your Email
Thanks
Sandip University");
		
$smsGatewayUrl = "http://162.241.114.66/api/send_sms?api_key=3126098cf46a2ca0&text=$sms_message&mobiles=9960006338&unicode=0&sender_id=SANDIP&template_id=1107161951389454954";
$smsgatewaydata = $smsGatewayUrl;
$url = $smsgatewaydata;

$ch = curl_init();                       // initialize CURL
curl_setopt($ch, CURLOPT_POST, false);    // Set CURL Post Data
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$output = trim(curl_exec($ch));
print_r($output);
curl_close($ch);
$response = json_decode($output, true);

if($response['status']== 1){
echo 'OTP has sent to your registered mobile number';
}else{
echo 'OTP has sent to your registered mobile number';
}

	}
	
	function Insert_excel(){
		 $this->load->view('Test/insert'); //markscard_view
	}
	
	function New_excel(){
echo '1';
	}
	
	
	function read_excel(){
		//$this->load->view('import_data');
		if(isset($_POST["submit"]))
		{
			$file = $_FILES['file']['tmp_name'];
			$handle = fopen($file, "r");
			$c = 0;//
			while(($filesop = fgetcsv($handle, 1000, ",")) !== false)
			{
				$fname = $filesop[0];
				$lname = $filesop[1];
				if($c<>0){					// SKIP THE FIRST ROW 
					//$this->Crud_model->saverecords($fname,$lname);
					echo	$fname = $filesop[0];
			echo	$lname = $filesop[1];
				}
				$c = $c + 1;
			}
			echo "sucessfully import data !";
				
		}
		
	}
	
	function new_read(){
	//	exit();
		$DBs = $this->load->database('umsdb', TRUE);
		if ($this->input->post('submit')) 
		{            
			$path = './uploads/excel/';
			require_once APPPATH . "/third_party/PHPExcel.php";
			$config['upload_path'] = $path;
			$config['allowed_types'] = 'xlsx|xls';
			$config['remove_spaces'] = TRUE;
			$this->load->library('upload', $config);
			$this->upload->initialize($config);            
			if (!$this->upload->do_upload('uploadFile')) {
				$error = array('error' => $this->upload->display_errors());
			} else {
				$data = array('upload_data' => $this->upload->data());
			}
			if(empty($error)){
			  if (!empty($data['upload_data']['file_name'])) {
				$import_xls_file = $data['upload_data']['file_name'];
			} else {
				$import_xls_file = 0;
			}
			$inputFileName = $path . $import_xls_file;
			//exit();
			try {
				$inputFileType = PHPExcel_IOFactory::identify($inputFileName);
				$objReader = PHPExcel_IOFactory::createReader($inputFileType);
				$objPHPExcel = $objReader->load($inputFileName);
				$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
				$flag = true;
				$i=0;
				foreach ($allDataInSheet as $value) {
				  if($flag){
					$flag =false;
					continue;
				  }
				 // exit();
				  $current_d=date('Y-m-d h:i:s');
				  echo $value['A'].'--'.$value['B'].'--prn'.$value['C'].'--reg_no'.$value['D']; echo '<br>';
				  //echo $value['B']; echo '<br>';
				//  echo $value['C']; echo '<br>';
				 // $inserdata[$i]['first_name'] = $value['A'];
				 // $inserdata[$i]['last_name'] = $value['B'];
				  //$inserdata[$i]['address'] = $value['C'];
				 // $inserdata[$i]['email'] = $value['D'];
				 // $inserdata[$i]['mobile'] = $value['E'];
				 
				//echo $sql_insert="INSERT INTO punching_log values('','".$value['A']."','".$value['B']."','".$value['C']."','".$value['D']."','".$current_d."','')";
				echo $sqld ="UPDATE `sandipun_ums`.`student_master` SET marathi_name='".$value['D']."' WHERE `enrollment_no` = '".$value['B']."'"; 
				//AND admission_session='2021'
				echo '<br>';
              // $queryd = $DBs->query($sqld);
				  $i++;
				}               
				/*$result = $this->import_model->importdata($inserdata);   
				if($result){
				  echo "Imported successfully";
				}else{
				  echo "ERROR !";
				}      */       

			} catch (Exception $e) {
			   die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME)
						. '": ' .$e->getMessage());
			}
		}else{
			  echo $error['error'];
		}         
		
		//$this->load->view('Test/insert');
	}
	}
	
	
	function excel_read(){

$csvFile = fopen("https://erp.sandipuniversity.com/uploads/excel/Visit_Admin.xlsx");
  //skip first line
  fgetcsv($csvFile);
  //read data from csv file line by line
  while(($line = fgetcsv($csvFile)) !== FALSE){  
  echo $line[0];      
     //You can have your active record's query to insert it into Db
    // $db->query("INSERT INTO tableName (Column1) VALUES ('".$line[0]."')");
  }                
  //close opened csv file
  fclose($csvFile);
	}
	function url_exists($url) {

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    return ($code == 200); // verifica se recebe "status OK"
}
	
	function Check_photos(){
		exit();
		$DBs = $this->load->database('umsdb', TRUE);
		/*echo $check=$this->url_exists("https://erp.sandipuniversity.com/uploads/student_photo/200101091002.jpg");
		if($this->url_exists("https://erp.sandipuniversity.com/uploads/student_photo/200101091001.jpg")) {
		    echo "IN"; echo '<br>';
	   }else{
		   echo "OUT";echo '<br>';
	   }
	   exit();*/
		$sqld ="select * from student_master where admission_session='2021' AND  
		academic_year='2021' AND cancelled_admission='N' AND admission_confirm='Y'"; 
   $queryd = $DBs->query($sqld);
   $results= $queryd->result_array();
   foreach($results as $val){
	   if($this->url_exists("https://erp.sandipuniversity.com/uploads/student_photo/".$val['enrollment_no'].".jpg")) {
		   // echo "IN".$val['enrollment_no']; echo '<br>';
	   }else{
		   echo $val['enrollment_no'];echo '<br>';
	   }
   }
		
	}
	
	function Copy_photos(){
		//chmod('/var/www/html/erp/uploads/upload_test/',0777);
		//exec ("find /var/www/html/erp/uploads/upload_test/ -type f -exec chmod 0777 {} +");
		exit();
		/* $Path='/var/www/html/erp/uploads/student_photo/170103011001.jpg'; //complete image directory path
    $destPath = '/var/www/html/erp/uploads/upload_2021/'; ///var/www/html/erp/uploads/upload_2021
    // makes new folder, if not exists.
    if(!file_exists($destPath) || file_exists($destPath)) 
    {
        rmdir($destPath);
        mkdir($destPath, 0777);
    }

    $imageName='abc.jpg';
    $Path=$Path.$imageName;
    $dest=$destPath.$imageName;
    copy($Path, $dest);*/
	//exit();
		/* $imagePath = "/var/www/html/erp/uploads/student_photo/170103011001.jpg";
$newPath = "/var/www/html/erp/uploads/upload_t/";
//rmdir($newPath);
 if(file_exists($destPath)) { //!file_exists($destPath) || 
        mkdir($newPath, 0777);
		echo 'bb';
 }else{
	 mkdir($newPath, 0777);
 echo 'aa';
 }
$ext = '.jpg';
$newName  = $newPath."170103011001".$ext;
chmod($newName,0777);
$copied = copy($imagePath , $newName);

if ((!$copied)) 
{
    echo "Error : Not Copied";
}
else
{ 
    echo "Copied Successful";
}
		exit();*/
		
		/*$imagePath = "/var/www/projectName/Images/somepic.jpg";
$newPath = "/test/Uploads/";
$ext = '.jpg';
$newName  = $newPath."a".$ext;

$copied = copy($imagePath , $newName);*/
		$DBs = $this->load->database('umsdb', TRUE);
		/*echo $check=$this->url_exists("https://erp.sandipuniversity.com/uploads/student_photo/200101091002.jpg");
		if($this->url_exists("https://erp.sandipuniversity.com/uploads/student_photo/200101091001.jpg")) {
		    echo "IN"; echo '<br>';
	   }else{
		   echo "OUT";echo '<br>';
	   }
	   exit();*/
		$sqld ="select * from student_master where admission_session='2020' AND  
		 cancelled_admission='N' AND admission_confirm='Y'"; //AND stud_id='6454'
   $queryd = $DBs->query($sqld);
   $results= $queryd->result_array();
  // print_r($results); //exit();
  $newPath = "/var/www/html/erp/uploads/upload_test/";
   foreach($results as $val){
	// echo ($val['enrollment_no_new']);
	   if(($this->url_exists("https://erp.sandipuniversity.com/uploads/student_photo/".$val['enrollment_no_new'].".jpg"))) {//||($this->url_exists("https://erp.sandipuniversity.com/uploads/student_photo/".$val['enrollment_no_new'].".jpg")) //($this->url_exists("https://erp.sandipuniversity.com/uploads/student_photo/".$val['enrollment_no'].".jpg"))||
		   
		    
$imagePath = "/var/www/html/erp/uploads/student_photo/".$val['enrollment_no'].".jpg";
$newPath = "/var/www/html/erp/uploads/upload_test/";
//rmdir($newPath);
 //if(file_exists($destPath)) { //!file_exists($destPath) || 
        //mkdir($newPath, 0777);
		//echo 'bb';
// }else{
//	 mkdir($newPath, 0777);
 //echo 'aa';
 //}
$ext = '.jpg';
$newName  = $newPath.$val['enrollment_no'].$ext;

$copied = copy($imagePath , $newName);
chmod($newName,0777);
if ((!$copied)) 
{
    echo "Error : Not Copied";
}
else
{ 
    echo "Copied Successful";
}
		   
		   
		   
/*$imagePath = "https://erp.sandipuniversity.com/uploads/student_photo/".$val['enrollment_no'].".jpg";
$newPath = "https://erp.sandipuniversity.com/uploads/upload_test/";
mkdir($newPath,0755);
$ext = '.jpg';
echo $newName  = $newPath;echo '<br>';
//$copied = copy($imagePath , $newName);
if( !copy($imagePath, $newName) ) { 
echo "File can't be copied! \n";
}else{
	echo "File has been copied! \n";
}*/


		    echo "IN".$val['enrollment_no'].'==='.$val['enrollment_no_new']; echo '<br>';
	   }else{
		   echo $val['enrollment_no'];echo '<br>';
	   }
   }
		
	}
	function create(){
		$this->load->library('m_pdf');
		$html1=$this->load->view('errors/print','',true);
	
exit();
        $pdfFilePath = "MARCH_2022.pdf";
		
		//$mpdf->WriteHTML($stylesheet,1);
		$this->m_pdf->pdf->WriteHTML($stylesheet,1);
		//	 $html1 = $this->load->view('Test', $this->data, true);
		//if($trep=='salary_reg'){
//$this->m_pdf->pdf=new mPDF('L','A4-L','','',5,5,5,5,5,5);
//}else{
$this->m_pdf->pdf=new mPDF('','', 0, 0, 5, 5, 5, 0, 5, 5, 'L');//('','A4','','',5,5,5,5,5,5);	
//}
        $this->m_pdf->pdf->WriteHTML($html1);
        //download it.
        $this->m_pdf->pdf->Output($pdfFilePath, "D");	
	}
	
	function create_from(){
		$DBs = $this->load->database('umsdb', TRUE);
		for($i=1;$i<1000;$i++){
			$from="22R0".(101001+$i);
			 $from; echo '<br>';
		echo  $sqld ="insert Into sandipun_ic_erp22.material_distribution_details
   
		 VALUES (NULL, '47', '$from', '1', 'Rohan ', '', '', 'SU Prospec', '9168615820', 'admission ', 'Nashik', 'Hand over', '2022-03-10', '',
		  NULL, '1', '2022-03-10 17:20:30')"; 
//$queryd = $DBs->query($sqld);
		}
	}
	
	
	function test_database(){
		 print_r($this->db);
	}
	
	public function Test_print(){
		 $this->load->library('m_pdf');
	//$output=$this->Test_model->Test_print();
	$output=$this->load->view('errors/print','',true);
	$mpdf = new mPDF('utf-8', 'A4-L');
$mpdf= new mPDF('','', 0, 0, 5, 5, 5, 0, 5, 5, 'L');
$stylesheet2 = file_get_contents(base_url().'assets/css/bootstrap.min.css');
$mpdf->list_indent_first_level = 0;  // 1 or 0 - whether to indent the first level of a list
$mpdf->WriteHTML($output);
$mpdf->Output($tempDir.'Payslip.pdf', "D");
	}
	
	
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
}
?>