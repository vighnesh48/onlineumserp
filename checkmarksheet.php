<?php
if(isset($_GET['type']) || isset($_GET['po'])){
	
	 $prn = $_GET['type'];
	 if($prn !='160106071002' && $prn !='160106061002'){
	  $file ='http://sandipuniversity.com/erp/uploads/exam/DEC2018/HallTicket/'.$prn.'_exam_hallticket.pdf';
	// $file = 'chpdf/output1.pdf';
	 $filename = $prn.'_exam_hallticket.pdf';
 
	  header('Content-type: application/pdf');
	  header('Content-Disposition: inline; filename="' . $filename . '"');
	  header('Content-Transfer-Encoding: binary');
	  header('Accept-Ranges: bytes');
	  @readfile($file);
	 }else{
		 //header('http://sandipuniversity.com/erp/certificate/160106071002');
		 header("Location: http://sandipuniversity.com/erp/login/view_marksheet/160106061002");
	 }
}
else
echo "Invalid link";	
?> 