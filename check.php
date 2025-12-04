<?php
if(isset($_GET['wo']) || isset($_GET['po'])){
	
	$prn = $_GET['po'];
	 if($prn !='160106071002' && $prn !='160106061002'){
	  //$file ='http://sandipuniversity.com/erp/uploads/exam/DEC2023/HallTicket/'.$prn.'_exam_hallticket.pdf';
	  $prn=base64_encode($prn);
	  echo $file ='https://erp.sandipuniversity.com/examination/hall_ticket_qr/'.$prn;
	 // redirect($file);
	  header('location: '.$file);
	// $file = 'chpdf/output1.pdf';
	/* $filename = $prn.'_exam_hallticket.pdf';
 
	  header('Content-type: application/pdf');
	  header('Content-Disposition: inline; filename="' . $filename . '"');
	  header('Content-Transfer-Encoding: binary');
	  header('Accept-Ranges: bytes');
	  @readfile($file);*/
	 }else{
		 //header('http://sandipuniversity.com/erp/certificate/160106071002');
		 header("Location: http://sandipuniversity.com/erp/login/view/160106061002");
	 }
}
else
echo "Invalid link";	
?> 