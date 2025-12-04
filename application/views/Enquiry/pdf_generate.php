<?php
/* include autoloader */
include 'dompdf/autoload.inc.php';
//echo "jay";
//exit;
$basepath = base_url();

//$form_no= $Enquiry_data[];//$this->session->userdata('formNo');
/* reference the Dompdf namespace */
use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->set('isRemoteEnabled', TRUE);
$dompdf = new Dompdf($options);
/*$contxt = stream_context_create([ 
    'ssl' => [ 
        'verify_peer' => FALSE, 
        'verify_peer_name' => FALSE,
        'allow_self_signed'=> TRUE
    ] 
]);
$dompdf->setHttpContext($contxt);*/
/* instantiate and use the dompdf class */
$dompdf = new Dompdf();



ob_start();                      // start capturing output
include('print_admission_form_view.php');   // execute the file
$content = ob_get_contents();    // get the contents from the buffer
ob_end_clean();  
//$body1 = file_get_contents('print_admission_form_view.php');
//echo $content;exit;
$html = $content;

$dompdf->loadHtml(utf8_encode($html));

/* Render the HTML as PDF */
$dompdf->render();

/* Output the generated PDF to Browser */
$dompdf->stream();
//$domPdf->output(['isRemoteEnabled' => true]);
?>