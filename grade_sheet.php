<?php
if(isset($_GET['wo']) || isset($_GET['po'])){
	
	 $prn = $_GET['po'];
	 if($prn !='160106071002' && $prn !='160106061002'){
		 header("Location: https://erp.sandipuniversity.com/login/view_consolated/".$prn);
	/*//  $file ='http://sandipuniversity.com/erp/uploads/grade_sheet/2019_May/'.$prn.'_Gradesheet.pdf';
	  $file ='http://sandipuniversity.com/erp/uploads/gradesheet/2019_May_new/180107021005_Gradesheet.pdf';
	  
	// $file = 'chpdf/output1.pdf';
	 $filename = $prn.'_Gradesheet.pdf';
 
	  header('Content-type: application/pdf');
	  header('Content-Disposition: inline; filename="' . $filename . '"');
	  header('Content-Transfer-Encoding: binary');
	  header('Accept-Ranges: bytes');
	  @readfile($file);*/
	 }else{
		 //header('http://sandipuniversity.com/erp/certificate/160106071002');
		 header("Location: https://erp.sandipuniversity.com/login/view/160106061002");
	 }
}
else
echo "Invalid link";	
?> 