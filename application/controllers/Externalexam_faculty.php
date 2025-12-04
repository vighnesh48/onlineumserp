<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Externalexam_faculty extends CI_Controller 
{
    var $currentModule="";
    var $title="";
    var $table_name="exam_external_faculty_master";
    var $model_name="Externalexamfaculty_model";
    var $model;
    var $view_dir='Externalexamfaculty/';
    var $data=array();
    public function __construct() 
    {
        global $menudata;
        parent:: __construct();
        //error_reporting(E_ALL);
        $this->load->helper("url");		
        $this->load->library('form_validation');
        
        if($this->uri->segment(2)!="" && $this->uri->segment(2)!="submit" && !in_array($this->uri->segment(2), $this->skipActions))
           $title=$this->uri->segment(2);                   //Second segment of uri for action,In case of edit,view,add etc.
       else
           $title=$this->master_arr['index'];
		$this->load->model('Guide_allocation_phd_model');
		$this->load->library('Awssdk');
		$this->bucket_name = 'erp-asset';

        $this->currentModule=$this->uri->segment(1);        
        $this->data['currentModule']=$this->currentModule;
        $this->data['model_name']=$this->model_name;
        
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $model = $this->load->model($this->model_name);
        
        $menu_name=$this->uri->segment(1);        
        $this->data['my_privileges']=$this->retrieve_privileges($menu_name);
		//print_r($this->data['my_privileges']);exit;
		if($this->session->userdata("role_id")==20 ||  $this->session->userdata("role_id")==10 ||  $this->session->userdata("role_id")==5 || 
		$this->session->userdata("role_id")==44 ||  $this->session->userdata("role_id")==15 ||  $this->session->userdata("role_id")==21 ||  $this->session->userdata("role_id")==6  || 
		$this->session->userdata("role_id")==23  ||  $this->session->userdata("role_id")==40){
		}else{
			redirect('home');
		}
    }
    
    public function index($type='')
    {
        global $model;
		
        $this->load->view('header',$this->data);    
        $this->data['btype']=base64_decode($this->uri->segment(3));
        $this->data['campus_details']= $this->Externalexamfaculty_model->get_faculty_details('',base64_decode($type));                                
        $this->load->view($this->view_dir.'view',$this->data);
        $this->load->view('footer');
    }
    
    public function add()
    {
        $this->load->view('header',$this->data);  
		 $this->data['btype']=base64_decode($this->uri->segment(3));
        $this->data['bank_details']=$this->Guide_allocation_phd_model->fetch_bank_det();		
        $this->load->view($this->view_dir.'add',$this->data);
        $this->load->view('footer');
    }
    
    public function view($type='')
    {
        $this->load->view('header',$this->data);        
         $this->data['btype']=base64_decode($this->uri->segment(3));
         $this->data['campus_details']=$this->Externalexamfaculty_model->get_faculty_details('',base64_decode($type));               
        $this->load->view($this->view_dir.'view',$this->data);
        $this->load->view('footer');
    }
    
    public function edit()
    {
        $this->load->view('header',$this->data);        
        $campus_id=$this->uri->segment(3);
		$this->data['btype']=base64_decode($this->uri->segment(4));
        $this->data['campus_details']=array_shift($this->Externalexamfaculty_model->get_faculty_details($campus_id)); 
        $this->data['bank_details']=$this->Guide_allocation_phd_model->fetch_bank_det();		
        $this->load->view($this->view_dir.'edit',$this->data);
        $this->load->view('footer');
    }    
    
    public function disable()
    {
		$DB1 = $this->load->database('umsdb', TRUE);
        $this->load->view('header',$this->data);       
        $campus_id=$this->uri->segment(3);   
        $update_array=array("status"=>"N","updated_by"=>  $this->session->userdata('uid'));                                
        $where=array("id"=>$campus_id);
        $DB1->where($where);
        
        if($DB1->update($this->table_name, $update_array))
        {
            redirect(base_url("Externalexam_faculty/view?error=0"));
        }
        else
        {
            redirect(base_url("Externalexam_faculty/view?error=1"));
        }  
        $this->load->view('footer');
    }
    
    public function enable()
    {
		$DB1 = $this->load->database('umsdb', TRUE);
        $this->load->view('header',$this->data);        
        $campus_id=$this->uri->segment(3);   
        $update_array=array("status"=>"Y","updated_by"=>  $this->session->userdata('uid'));                                
        $where=array("id"=>$campus_id);
        $DB1->where($where);
        
        if($DB1->update($this->table_name, $update_array))
        {
			//echo $DB1->last_query();exit;
            redirect(base_url("Externalexam_faculty/view?error=0"));
        }
        else
        {
            redirect(base_url("Externalexam_faculty/view?error=1"));
        }  
        $this->load->view('footer');
    }
    
    public function submitsss()
    {       
        $this->load->helper('security');
		$DB1 = $this->load->database('umsdb', TRUE);
        $config=array(
                        array('field'   => 'ext_fac_name',
			'label'   => 'Name',
			'rules'   => 'trim|required'
			),
                 );
        //print_r($this->input->post()); die; 
        $this->form_validation->set_rules($config);         
        $fac_id=$this->input->post('fac_id');
        
        if($fac_id=="")
        {
            if ($this->form_validation->run() == FALSE)
            {                
                $this->load->view('header',$this->data);
                $this->load->view($this->view_dir.'add',  $this->data);
                $this->load->view('footer');
            }
            else
            {
				$chk_duplicate = $this->Externalexamfaculty_model->checkDuplicate_pract_faculty($_POST);
				//echo count($chk_duplicate);exit;
				if(count($chk_duplicate) > 0){
					//echo "inside";exit;
					redirect(base_url("Externalexam_faculty/view?error=1"));
				}else{
					//echo "outside";exit;
					$ext_faculty=$this->Externalexamfaculty_model->auto_ext_faculty();
					$ext_faculty_code ='PREX_'.$ext_faculty;
					$ext_fac_name=$this->input->post("ext_fac_name");    
					$ext_fac_mobile=$this->input->post("ext_fac_mobile");    
					$ext_fac_email=$this->input->post("ext_fac_email");    
					$ext_fac_designation=$this->input->post("ext_fac_designation");    
					$ext_fac_institute=$this->input->post("ext_fac_institute");
					$ext_fac_institute_address=$this->input->post("ext_fac_institute_address");
					$distance_km = $this->input->post("distance_km");                       
					$insert_array=array("ext_faculty_code"=>$ext_faculty_code,"ext_fac_name"=>$ext_fac_name,"ext_fac_mobile"=>$ext_fac_mobile,"ext_fac_email"=>$ext_fac_email,"ext_fac_designation"=>$ext_fac_designation,"ext_fac_institute_address"=>$ext_fac_institute_address,"ext_fac_institute"=>$ext_fac_institute,"distance_km"=>$distance_km,"inserted_by"=>$this->session->userdata("uid"),"inserted_on"=>date("Y-m-d H:i:s"));                                                                
					$DB1->insert("exam_external_faculty_master", $insert_array); 
					$last_inserted_id=$DB1->insert_id();                
					if($last_inserted_id)
					{
						redirect(base_url("Externalexam_faculty/view?error=0"));
					}
					else
					{
						redirect(base_url('Externalexam_faculty/view?error=1'));
					}
				}
            }
        }
        else
        {
            if ($this->form_validation->run() == FALSE)
            {
                $this->load->view('header',$this->data);        
                $campus_id=$this->input->post("campus_id");
                $this->data['campus_details']=array_shift($this->Externalexamfaculty_model->get_faculty_details($campus_id));                            
                $this->load->view($this->view_dir.'edit',$this->data);
                $this->load->view('footer');                
            }
            else
            {        
                $campus_id=$this->input->post("fac_id");       
                $ext_fac_name=$this->input->post("ext_fac_name");    
                $ext_fac_mobile=$this->input->post("ext_fac_mobile");    
                $ext_fac_email=$this->input->post("ext_fac_email");    
                $ext_fac_designation=$this->input->post("ext_fac_designation");    
                $ext_fac_institute=$this->input->post("ext_fac_institute"); 
                $ext_fac_institute_address=$this->input->post("ext_fac_institute_address"); 
				$distance_km = $this->input->post("distance_km");				
                $update_array=array("ext_fac_name"=>$ext_fac_name,"ext_fac_mobile"=>$ext_fac_mobile,"ext_fac_email"=>$ext_fac_email,"ext_fac_designation"=>$ext_fac_designation,"ext_fac_institute_address"=>$ext_fac_institute_address,"distance_km"=>$distance_km,"ext_fac_institute"=>$ext_fac_institute,"updated_by"=>$this->session->userdata("uid"),"updated_on"=>date("Y-m-d H:i:s"));                                                                
                                
                $where=array("id"=>$campus_id);
                $DB1->where($where);                
                if($DB1->update($this->table_name, $update_array))
                {                    
                    redirect(base_url("Externalexam_faculty/view?error=0"));
                }
                else
                {  
                    redirect(base_url("Externalexam_faculty/view?error=1"));
                }
            }
        }      
    }  
    
    public function search()
    {        
        $para=$this->input->post("title");
        $campus_details=  $this->Externalexamfaculty_model->get_faculty_details_search($para);                    
        echo json_encode(array("campus_details"=>$campus_details));
    } 
	
	public function submit()
	{       
		$this->load->helper('security');
		$DB1 = $this->load->database('umsdb', TRUE);

		$config=array(
			array(
				'field'   => 'ext_fac_name',
				'label'   => 'Name',
				'rules'   => 'trim|required'
			),
		);
		$this->form_validation->set_rules($config);         
		$fac_id = $this->input->post('fac_id');

		$campus_type = $this->input->post('campus_type'); // new field

		if ($fac_id == "")
		{
			if ($this->form_validation->run() == FALSE)
			{    
				$this->load->view('header',$this->data);
				$this->data['bank_details']=$this->Guide_allocation_phd_model->fetch_bank_det();
				$this->load->view($this->view_dir.'add',  $this->data);
				$this->load->view('footer');
			}
			else
			{
				$chk_duplicate = $this->Externalexamfaculty_model->checkDuplicate_pract_faculty($_POST);

				if(count($chk_duplicate) > 0){
					redirect(base_url("Externalexam_faculty/view?error=1"));
				} else {
					$ext_faculty = $this->Externalexamfaculty_model->auto_ext_faculty();
					$ext_faculty_code ='PREX_'.$ext_faculty;

					$insert_array = array(
						"ext_faculty_code" => $ext_faculty_code,
						"ext_fac_name" => $this->input->post("ext_fac_name"),
						"ext_fac_mobile" => $this->input->post("ext_fac_mobile"),
						"ext_fac_email" => $this->input->post("ext_fac_email"),
						"ext_fac_designation" => $this->input->post("ext_fac_designation"),
						"ext_fac_institute" => $this->input->post("ext_fac_institute"),
						"ext_fac_institute_address" => $this->input->post("ext_fac_institute_address"),
						"campus_type" => $campus_type, // added
						"distance_km" => ($campus_type == 'inside_campus') ? 0 : $this->input->post("distance_km"),
						"btype" => $this->input->post("btype"),
						"bank_id" => $this->input->post("bank_name"),
						"acc_holder_name" => $this->input->post("acc_holder_name"),
						"acc_no" => $this->input->post("acc_no"),
						"ifsc_code" => $this->input->post("ifsc_code"),
						"branch" => $this->input->post("branch"),
						"inserted_by" => $this->session->userdata("uid"),
						"inserted_on" => date("Y-m-d H:i:s")
					);

					// Handle Cheque file upload
					if(!empty($_FILES['cheque_file']['name'])){
						$rand=rand(1000,9999);
						$filenm_arr = explode(".",$_FILES['cheque_file']['name']);
						$filenm = $ext_faculty_code.'-'.$rand.'-'.clean($filenm_arr[0]).".".$filenm_arr[1];
						try{
							$file_path = 'uploads/phd_renumaration_files/'.$filenm;
							$this->awssdk->uploadFile($this->bucket_name, $file_path, $_FILES['cheque_file']['tmp_name']);
							$insert_array['cheque_file'] = $filenm;
						} catch(Exception $e) {
							$insert_array['cheque_file'] = "";
						}
					}

					// Handle ID Card upload
					if(!empty($_FILES['id_card_file']['name'])){
						$rand=rand(1000,9999);
						$filenm_arr = explode(".",$_FILES['id_card_file']['name']);
						$filenm = $ext_faculty_code.'-'.$rand.'-idcard-'.clean($filenm_arr[0]).".".$filenm_arr[1];
						try{
							$file_path = 'uploads/phd_renumaration_files/'.$filenm;
							$this->awssdk->uploadFile($this->bucket_name, $file_path, $_FILES['id_card_file']['tmp_name']);
							$insert_array['id_card_file'] = $filenm;
						} catch(Exception $e) {
							$insert_array['id_card_file'] = "";
						}
					}

					$DB1->insert("exam_external_faculty_master", $insert_array); 
					$last_inserted_id = $DB1->insert_id();                
					redirect(base_url("Externalexam_faculty/view/".base64_encode($this->input->post("btype"))));
				}
			}
		}
		else
		{
			// Edit/Update
			if ($this->form_validation->run() == FALSE)
			{
				$this->load->view('header',$this->data);        
				$campus_id = $this->input->post("campus_id");
				$this->data['bank_details'] = $this->Guide_allocation_phd_model->fetch_bank_det();
				$this->data['campus_details'] = array_shift($this->Externalexamfaculty_model->get_faculty_details($campus_id));                            
				$this->load->view($this->view_dir.'edit',$this->data);
				$this->load->view('footer');                
			}
			else
			{     
				$ext_faculty_code = $this->input->post("emp_code");

				$update_array = array(
					"ext_fac_name" => $this->input->post("ext_fac_name"),
					"ext_fac_mobile" => $this->input->post("ext_fac_mobile"),
					"ext_fac_email" => $this->input->post("ext_fac_email"),
					"ext_fac_designation" => $this->input->post("ext_fac_designation"),
					"ext_fac_institute" => $this->input->post("ext_fac_institute"),
					"ext_fac_institute_address" => $this->input->post("ext_fac_institute_address"),
					"campus_type" => $campus_type, // added
					"distance_km" => ($campus_type == 'inside_campus') ? 0 : $this->input->post("distance_km"),
					"btype" => $this->input->post("btype"),
					"bank_id" => $this->input->post("bank_name"),
					"acc_holder_name" => $this->input->post("acc_holder_name"),
					"acc_no" => $this->input->post("acc_no"),
					"ifsc_code" => $this->input->post("ifsc_code"),
					"branch" => $this->input->post("branch"),
					"updated_by" => $this->session->userdata("uid"),
					"updated_on" => date("Y-m-d H:i:s")
				);

				// Cheque file
				if(!empty($_FILES['cheque_file']['name'])){
					$rand=rand(1000,9999);
					$filenm_arr = explode(".",$_FILES['cheque_file']['name']);
					$filenm = $ext_faculty_code.'-'.$rand.'-'.clean($filenm_arr[0]).".".$filenm_arr[1];
					try{
						$file_path = 'uploads/phd_renumaration_files/'.$filenm;
						$this->awssdk->uploadFile($this->bucket_name, $file_path, $_FILES['cheque_file']['tmp_name']);
						$update_array['cheque_file'] = $filenm;
					} catch(Exception $e){
						$update_array['cheque_file'] = "";
					}
				}

				// ID Card file
				if(!empty($_FILES['id_card_file']['name'])){
					$rand=rand(1000,9999);
					$filenm_arr = explode(".",$_FILES['id_card_file']['name']);
					$filenm = $ext_faculty_code.'-'.$rand.'-idcard-'.clean($filenm_arr[0]).".".$filenm_arr[1];
					try{
						$file_path = 'uploads/phd_renumaration_files/'.$filenm;
						$this->awssdk->uploadFile($this->bucket_name, $file_path, $_FILES['id_card_file']['tmp_name']);
						$update_array['id_card_file'] = $filenm;
					} catch(Exception $e){
						$update_array['id_card_file'] = "";
					}
				}

				$where = array("id" => $this->input->post("fac_id"));
				$DB1->where($where);                
				$DB1->update($this->table_name, $update_array);
				redirect(base_url("Externalexam_faculty/view/".base64_encode($this->input->post("btype"))));
			}
		}      
	}


	 public function get_external_details($exid='',$type=''){

		 $this->data['external'] = $this->Externalexamfaculty_model->get_faculty_details($exid,base64_decode($type));
         $html = $this->load->view($this->view_dir.'External_details_view',$this->data,true);
		 echo $html;		
	  }
	  
	  
	  
	  
    public function listExtFacultyEventDetails()
    {
        $event_type = $this->input->get('event_type');
        $month_year = $this->input->get('month_year');

        $this->data['success_message'] = $this->session->flashdata('success');
        $this->data['event_type_details'] = $this->Externalexamfaculty_model->get_event_ext_faculty(); // Add this method
        $this->data['event_list'] = $this->Externalexamfaculty_model->get_all_ext_faculty_event_details($event_type, $month_year);

        $this->load->view('header', $this->data);
        $this->load->view($this->view_dir . 'listExtFacultyEventDetails', $this->data);
        $this->load->view('footer');
    }

    public function add_ext_faculty_event_details($encoded_id = null)
    {
        $this->load->view('header', $this->data);

        $id = $encoded_id ? base64_decode($encoded_id) : null;

        if ($id) {
            $this->data['title_name'] = 'Edit External Faculty Payment Details';
            $this->data['sub'] = $this->Externalexamfaculty_model->get_event_detail_by_id($id);
            $this->data['updated_event_detail_id'] = $id;
        } else {
            $this->data['title_name'] = 'Add External Faculty Payment Details';
            $this->data['sub'] = [];
            $this->data['updated_event_detail_id'] = '';
        }

        $this->data['ext_faculty_details'] = $this->Externalexamfaculty_model->get_ext_faculty_details();
        $this->data['event_type_details'] = $this->Externalexamfaculty_model->get_event_ext_faculty();

        $this->load->view($this->view_dir . 'addExtFacultyEventDetails', $this->data);
        $this->load->view('footer');
    }


    public function submitExtFacultyEventTypeDetail()
    {
        $this->form_validation->set_rules('ext_faculty', 'External Faculty', 'required');
        $this->form_validation->set_rules('event_type', 'Event Type', 'required');
        $this->form_validation->set_rules('ta_amount', 'TA Amount', 'required|numeric');
        $this->form_validation->set_rules('honorarium_amount', 'Honorarium', 'required|numeric');
        $this->form_validation->set_rules('month_year', 'Month & Year', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->add_ext_faculty_event_details();
        } else {
            $uid = $this->session->userdata('uid');
            $id = $this->input->post('updated_event_detail_id');

            $data = array(
                'ext_faculty_id' => $this->input->post('ext_faculty'),
                'event_type_id' => $this->input->post('event_type'),
                'ta_amount' => $this->input->post('ta_amount'),
                'honorarium_amount' => $this->input->post('honorarium_amount'),
                'total_amount' => $this->input->post('ta_amount') + $this->input->post('honorarium_amount'),
                'description' => $this->input->post('description'),
                'month_year' => $this->input->post('month_year')

            );

            $DB1 = $this->load->database('umsdb', TRUE);
            if ($id) {
                $data['updated_by'] = $uid;
                $data['updated_at'] = date('Y-m-d H:i:s');

                $DB1->where('id', $id)->update('event_type_ext_faculty_payment_details', $data);
                $this->session->set_flashdata('success', 'Record updated successfully.');
            } else {
                $data['created_by'] = $uid;
                $data['created_at'] = date('Y-m-d H:i:s');

                $DB1->insert('event_type_ext_faculty_payment_details', $data);
                $this->session->set_flashdata('success', 'Record inserted successfully.');
            }

            redirect('Externalexam_faculty/listExtFacultyEventDetails');
        }
    }

    public function verify_status($id_encoded)
    {
        $id = base64_decode($id_encoded);
		$uid = $this->session->userdata('uid');
		
        $DB1 = $this->load->database('umsdb', TRUE);
        $record = $DB1->get_where('event_type_ext_faculty_payment_details', ['id' => $id])->row_array();

        if ($record) {
            $new_status = ($record['verification_status'] == 1) ? 0 : 1;

            $DB1->where('id', $id);
            $DB1->update('event_type_ext_faculty_payment_details', ['verification_status' => $new_status,'verified_on'=>date('Y-m-d H:i:s'),'verified_by'=>$uid]);

            $this->session->set_flashdata('success', 'Verification status updated successfully.');
        } else {
            $this->session->set_flashdata('error_message', 'Record not found.');
        }

        redirect('Externalexam_faculty/listExtFacultyEventDetails');
    }


    public function downloadFilteredPDF()
    {
        $event_type = $this->input->get('event_type');
        $month_year = $this->input->get('month_year');

        $event_list = $this->Externalexamfaculty_model->get_all_ext_faculty_event_details($event_type, $month_year);

        $event_type_name = 'All';
        if (!empty($event_type)) {
            $event_type_row = $this->Externalexamfaculty_model->get_event_type_by_id($event_type);
            $event_type_name = $event_type_row['event_type'] ?? 'Unknown';
        }
        $data['event_list'] = $event_list;
        $data['month_year'] = $month_year;
        $data['event_type_name'] = $event_type_name;

        $html = $this->load->view($this->view_dir . 'pdf_event_list', $data, true);

        $this->load->library('m_pdf');
        include("mpdf/mpdf.php");
        $mpdf = new mPDF('utf-8', 'A4-L');
        $mpdf = new mPDF('', '', 0, '0', 10, 10, 10, 0, 9, 9, 'L');

        $mpdf->WriteHTML($html);
        $mpdf->Output("Filtered_Event_List.pdf", "I");
    }

}
?>