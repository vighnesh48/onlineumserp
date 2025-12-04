<?php
if(isset($_GET['wo']) || isset($_GET['po'])){
	
	 $prn = $_GET['po'];
	 $exam_month = $_GET['exam_month'];
	 $exam_year = $_GET['exam_year'];
	// $stream_id = $_GET['stream_id'];
	// $exam_id = $_GET['exam_id'];
	 if($prn !='160106071002' && $prn !='160106061002'){
 $file ='http://sandipuniversity.com/erp/uploads/degree/'.$exam_month.'/'.$exam_year.'/qrcode_'.$prn.'.png';

//'qrcode_'.$prn.'.png'
	// $file = 'chpdf/output1.pdf';
	 $filename ="https://sandipuniversity.com/erp/uploads/degree/".$exam_month."/".$exam_year."/".$prn."_degree_certificate.pdf";
 
	  header('Content-type: application/pdf');
	  header('Content-Disposition: inline; filename="' . $filename . '"');
	  header('Content-Transfer-Encoding: binary');
	  header('Accept-Ranges: bytes');
	  @readfile($filename);
	 }else{
		 //header('http://sandipuniversity.com/erp/certificate/160106071002');
		 header("Location: http://sandipuniversity.com/erp/login/view/160106061002");
	 }
}
else
echo "Invalid link";	
?> 