<?php 

 //exit;
$this->load->helper('convertexcel');
echo array_to_csv($emp_sal,$filename,$trep,$title,$dt);

//echo convertToExcel('public/coderiddles.jpg') 
?>