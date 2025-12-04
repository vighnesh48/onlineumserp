<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Conference extends CI_Controller 
{

    var $currentModule="";
    var $title="";
    var $table_name="campus_master";
    var $model_name="Conference_model";
    var $model;
    var $view_dir='Conference/';
    
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

    public function index()
    {
		if($_POST)
        {
            $this->generate_attendence_sheet();
        }
        else
        {
			$this->load->view('header',$this->data);    
			$this->data['phd_data']= $this->Conference_model->appli_details();
			$this->data['stream_cnt']= $this->Conference_model->get_count_stream_appli_details();
			$this->load->view($this->view_dir.'candidate_list',$this->data);
			$this->load->view('footer');
        }
    }
public function get_registration_byfilter(){
	$str = $_REQUEST['stream'];
	$edetails = $this->Conference_model->appli_details_bystream($str);
if(!empty($edetails)){		
$cnt = count($edetails);	$j=1;				
                            for($i=0;$i<$cnt;$i++)
                            {
	echo '<tr  class="myHead">
                                <td>'.$j.'</td>          
                                  <td>ICEMELTS18/'.$edetails[$i]['id'].'</td>
                                 <td>'.$edetails[$i]['participant_name'].'</td>
                          <td>'.$edetails[$i]['stream'].'</td> 
                            <td>'.$edetails[$i]['mode'].'</td> 
                   <td>'.$edetails[$i]['paper_title'].'</td> 
                    <td>'.$edetails[$i]['affiliation'].'</td> 
                    <td>'.mb_strimwidth($edetails[$i]['paper_abstract'], 0, 20, "...").'</td> 
                     <td>'.$edetails[$i]['email'].'</td> 
                      <td>'.$edetails[$i]['keywords'].'</td> 
                      <td>
					  <a  href="'.base_url("conference/download_conference_pdf/".$edetails[$i]['id']).'" title="Download Conference" target="_blank" '.$disable.'><i class="fa fa-file-pdf-o" aria-hidden="true"  style="font-size:20px;color:red;"></i> </a>
					  </td>
					    </tr>';
                           
                            $j++;
                            }
}else{ echo "<tr><td colspan=8>No data found</td></tr>";}

}
	public function phd_results_excel()
	{
		$this->load->view('header',$this->data);    
		$this->data['phd_data']  = $this->Phd_model->phd_results($exam='August-2018');

		$this->load->view($this->view_dir.'phd_results_excel',$this->data);
		$this->load->view('footer',$this->data);    
	}
	
	public function conference_details_pdf()
	{

		$this->data['phd_data']= $this->Conference_model->appli_details();
		//var_dump($_POST);exit();
		$this->load->library('m_pdf', $param);
		
		$html = $this->load->view($this->view_dir.'Conference_pdf', $this->data, true);
		
		$pdfFilePath = "conference_details.pdf";

		$this->m_pdf->pdf->WriteHTML($html);
		//download it.
		$this->m_pdf->pdf->Output($pdfFilePath, "D");
	}
	
	public function download_conference_pdf($id)
	{

		$this->data['phd_data']= array_shift($this->Conference_model->appli_details($id));
		//var_dump($_POST);exit();
		$this->load->library('m_pdf', $param);
		
		$html = $this->load->view($this->view_dir.'download_conference_pdf', $this->data, true);
		
		$pdfFilePath = "ICEMELTS18/".$id.".pdf";

		$this->m_pdf->pdf->WriteHTML($html);
		//download it.
		$this->m_pdf->pdf->Output($pdfFilePath, "D");
	}
	
	public function icemelt_registration_2018()
    {
		$this->load->view('header',$this->data);    
		$this->data['phd_data']= $this->Conference_model->icemelt2018_appli_details();
		//$this->data['stream_cnt']= $this->Conference_model->icemelt_get_count_stream_appli_details();
		$this->load->view($this->view_dir.'icemelt_reg_list',$this->data);
		$this->load->view('footer');
    }
	
}
?>