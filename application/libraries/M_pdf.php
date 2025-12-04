<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
include_once APPPATH.'/third_party/mpdf/mpdf.php';
 
class M_pdf {
 
    public $param;
    public $pdf;
 
    public function __construct($param = '"c","A4","","",5,5,5,5,0,0')
    {
        $this->param =$param;
		
        $this->pdf = new mPDF($this->param);
		//$this->pdf->setAutoTopMargin = 'pad';
		//$this->pdf->SetHTMLHeader('<div class="pdf-header" ></div>'); 
		//$this->pdf->SetHTMLFooter('<div class="pdf-footer" ></div>'); 
    }
}