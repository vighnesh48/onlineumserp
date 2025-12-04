<style>
.attexl table{
	 border: 1px solid black;
}
.attexl table th{
 border: 1px solid black;
    padding: 5px;
    background-color:grey;
    color: white;
}
.attexl table td{
	 border: 1px solid black;
    padding: 5px;
}
</style>
<?php
ini_set('max_execution_time', 150000); 
ini_set('memory_limit','5048M');
//ini_set('display_errors', 1);
ob_start();
$content=$_REQUEST['datatodisplay'];

?>
<?php
include ('HtmlToPdf/html2pdf.class.php');
$html2pdf = new HTML2PDF('L', 'A4', 'en');
$html2pdf->pdf->SetDisplayMode('fullpage');
$html2pdf->writeHTML($content);
ob_end_clean(); 
$html2pdf->Output('attendancereport.pdf', 'D');
//ob_end_clean(); 
?>

