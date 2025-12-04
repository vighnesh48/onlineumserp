
<?php
$content=$_REQUEST['str'];?>
<? 
ob_end_clean();
ob_start();  // for server always comment this line
include ('HtmlToPdf/html2pdf.class.php');
$html2pdf = new HTML2PDF('L', 'A3', 'en');
$html2pdf->pdf->SetDisplayMode('fullpage');
$html2pdf->writeHTML($content);
$html2pdf->Output('Getpass.pdf','D');
?>

