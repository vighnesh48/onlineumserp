<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Transport extends CI_Controller 
{
    var $currentModule="";
    var $title="";
    var $table_name="";
    var $model_name="Transport_model";
    var $model;
    var $view_dir='Transport/';
    var $data=array();
    public function __construct() 
    {
        parent:: __construct();
		//error_reporting(E_ALL);
		//ini_set('display_errors', 1);
        // load form and url helpers
        $this->load->helper(array('form', 'url'));
         
        // load form_validation library
        $this->load->library('form_validation');
		$this->currentModule=$this->uri->segment(1);        
        $this->data['currentModule']=$this->currentModule;
        $this->data['model_name']=$this->model_name;
		$this->load->model($this->model_name);
		$this->load->model('Ums_admission_model');
	}
	
	public function index()
    {
        $this->boarding_fees_list();
    }
	
	public function vendors_list()
    {
        $this->load->view('header',$this->data);
		$this->data['vendor_details']=$this->Transport_model->get_vendor_details();
        $this->load->view($this->view_dir.'view_vendor',$this->data);
        $this->load->view('footer');
    }
	
	function generate_driver_id()
    {
        $this->load->view('header',$this->data);
		$this->data['vendor_details']=$this->Transport_model->get_vendor_details();
        $this->load->view($this->view_dir.'generate_driver_id',$this->data);
        $this->load->view('footer');
    }

	public function add_vendor()
	{
		$this->load->view('header',$this->data);  
$this->data['campus']= $this->Transport_model->getcampusname();		
		$this->data['state']= $this->Transport_model->getAllState();
		$this->load->view($this->view_dir.'add_vendor',$this->data);
        $this->load->view('footer');
	}
	
	public function checking_vendor_exists($vname,$campus)
	{
		return $this->Transport_model->checking_vendor_exists($vname,$campus);
	}
	
	public function add_vendor_submit()
    {
		$this->load->helper('security');
		$config=array(
						array('field'   => 'vname',
						'label'   => 'Vendor Name',
						'rules'   => 'trim|required|xss_clean|callback_checking_vendor_exists[' . $_POST['vname'] . ','.$_POST['campus'].']'
						)
					);
		 
		$this->form_validation->set_rules($config);
		
		if ($this->form_validation->run() == false)
		{                
			$this->session->set_flashdata('message2','The Vendor Name already exist, please try another.');
			redirect(base_url($this->view_dir));
		}
		else
		{
			//echo 'filename=='.$_FILES['mou_doc']['name'];exit();
			if(!empty($_FILES['mou_doc']['name'])){
				$filenm=$_POST['vname'].'-'.$_FILES['mou_doc']['name'];
				$config['upload_path'] = 'uploads/Transport/vendor';
				$config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
				$config['overwrite']= TRUE;
				$config['max_size']= "2048000";
				//$config['file_name'] = $_FILES['profile_img']['name'];
				$config['file_name'] = $filenm;

				//Load upload library and initialize configuration
				$this->load->library('upload',$config);
				$this->upload->initialize($config);

				if($this->upload->do_upload('mou_doc')){
					$uploadData = $this->upload->data();
					$payfile = $uploadData['file_name'];
				}else{
					$payfile = '';
				}
			}
			else{
				$payfile = '';
			}
			
			$insert_array=array("campus"=>$_POST['campus'],"vendor_name"=>$_POST['vname'],"contact_person"=>$_POST['cperson'],"mobile"=>$_POST['mobile'],"office_no"=>$_POST['office'],"email"=>$_POST['pemail'],"address"=>$_POST['address'],"service_started_year"=>$_POST['sdate'],"service_end_year"=>$_POST['edate'],"state_id"=>$_POST['hstate_id'],"district_id"=>$_POST['hdistrict_id'],"taluka_id"=>$_POST['hcity'],"state"=>$_POST['state'],"district"=>$_POST['district'],"taluka"=>$_POST['taluka'],"pincode"=>$_POST['pincode'],"agreement_documents"=>$payfile,"gst_no"=>$_POST['gst'],"created_by"=>$this->session->userdata("uid"),"created_on"=>date("Y-m-d H:i:s"),"is_active"=>"Y");
			//var_dump($insert_array);exit();
			$last_inserted_id= $this->Transport_model->add_vendor_submit($insert_array);
			if($last_inserted_id)
				$this->session->set_flashdata('message1','Vendor Details Added Successfully.');
			else
				$this->session->set_flashdata('message2','Vendor Details Not Added Successfully.');
			redirect(base_url($this->view_dir.'vendors_list'));
		}
    }
	
	public function get_vendor_details()
	{
		$id=$_POST['pid'];//echo "id===".$id;
		$p_dts=array_shift($this->Transport_model->get_vendor_details($id));
		echo json_encode(array("vendor_details"=>$p_dts));
	}
	
	public function get_bus_boarding_details()
	{
		$p_dts=$this->Transport_model->get_bus_boarding_details($_POST);
		echo json_encode(array("bus_boarding_details"=>$p_dts));
	}
	
	public function download_driver_id_pdf()
	{
		$this->data['ids'] = $this->Transport_model->t_driver_data($_POST);
		//var_dump($this->data['ids']);exit();
		$this->load->library('m_pdf', $param);
		
		$html = $this->load->view($this->view_dir.'driver_icard', $this->data, true);
		$pdfFilePath = "drivers_id_card.pdf";

		$this->m_pdf->pdf->WriteHTML($html);
		//download it.
		$this->m_pdf->pdf->Output($pdfFilePath, "D"); 
	}
	
	public function get_drivers_details()
	{
		$driver_list=$this->Transport_model->get_drivers_details($_POST);
	    if(count($driver_list)>0)
		{
			$j=1;
			
		   foreach($driver_list as $emp_list){
			echo '<tr>
				<td class="noExl"><input type="checkbox" name="chk_stud[]" id="chk_stud" class="checkBoxClass" value="'.$emp_list['driver_id'].'"></td>
				<td>'.$j.'</td><td>'.$emp_list['campus'].'</td> 
				<td>'.$emp_list['vendor_name'].'</td> 
				<td>'.$emp_list['driver_name'].'</td>
				<td>'.$emp_list['mobile'].'</td> 
				<td>'.$emp_list['driving_license_no'].'</td>
				<!--<td>
				<a class="btn btn-info btn-xs" href="'.base_url()."Transport/download_idcard_pdf/".$emp_list['campus']."/".$emp_list['vendor_id']."/".$emp_list['driver_id']."".'" title="View" target="_blank"><i class="fa fa-file-pdf-o" aria-hidden="true" style="font-size:20px; color:red;"> </i></a>
				</td>-->
				</tr>';
		
				$j++;
			}
			
		}
		else
				echo "<span style=\"color:red;\">Records Not Found Please change search criteria and try again</span>";
	}
	
	public function get_vendor_buses()
	{
		//$id=$_POST['pid'];//echo "id===".$id;
		$p_dts=$this->Transport_model->get_vendor_bus_details($_POST);
		echo json_encode(array("vendor_buses"=>$p_dts));
	}
	
	public function edit_vendor()
	{
		$id=$this->uri->segment(3);
        $this->load->view('header',$this->data);
$this->data['campus']= $this->Transport_model->getcampusname();		
		$this->data['state']= $this->Transport_model->getAllState();
        $this->data['vendor_details']= array_shift($this->Transport_model->get_vendor_details($id));
		$this->load->view($this->view_dir.'edit_vendor',$this->data);
        $this->load->view('footer');
	}
	
	public function edit_vendor_submit()
    {
		$id=$this->uri->segment(3);
		$update_array=array();
		//echo 'filename=='.$_FILES['mou_doc']['name'];exit();
		if(!empty($_FILES['mou_doc']['name'])){
			$filenm=$_POST['vname'].'-'.$_FILES['mou_doc']['name'];
			$config['upload_path'] = 'uploads/Transport/vendor';
			$config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
			$config['overwrite']= TRUE;
			$config['max_size']= "2048000";
			//$config['file_name'] = $_FILES['profile_img']['name'];
			$config['file_name'] = $filenm;

			//Load upload library and initialize configuration
			$this->load->library('upload',$config);
			$this->upload->initialize($config);

			if($this->upload->do_upload('mou_doc'))
			{
				$uploadData = $this->upload->data();
				$payfile = $uploadData['file_name'];
				$update_array=array("campus"=>$_POST['campus'],"vendor_name"=>$_POST['vname'],"contact_person"=>$_POST['cperson'],"mobile"=>$_POST['mobile'],"office_no"=>$_POST['office'],"email"=>$_POST['pemail'],"address"=>$_POST['address'],"service_started_year"=>$_POST['sdate'],"service_end_year"=>$_POST['edate'],"state_id"=>$_POST['hstate_id'],"district_id"=>$_POST['hdistrict_id'],"taluka_id"=>$_POST['hcity'],"state"=>$_POST['state'],"district"=>$_POST['district'],"taluka"=>$_POST['taluka'],"pincode"=>$_POST['pincode'],"agreement_documents"=>$payfile,"gst_no"=>$_POST['gst'],"modified_by"=>$this->session->userdata("uid"),"modified_on"=>date("Y-m-d H:i:s"),"is_active"=>$_POST['status']); 
			}
		}
		else
		{
			$update_array=array("campus"=>$_POST['campus'],"vendor_name"=>$_POST['vname'],"contact_person"=>$_POST['cperson'],"mobile"=>$_POST['mobile'],"office_no"=>$_POST['office'],"email"=>$_POST['pemail'],"address"=>$_POST['address'],"service_started_year"=>$_POST['sdate'],"service_end_year"=>$_POST['edate'],"state_id"=>$_POST['hstate_id'],"district_id"=>$_POST['hdistrict_id'],"taluka_id"=>$_POST['hcity'],"state"=>$_POST['state'],"district"=>$_POST['district'],"taluka"=>$_POST['taluka'],"pincode"=>$_POST['pincode'],"gst_no"=>$_POST['gst'],"modified_by"=>$this->session->userdata("uid"),"modified_on"=>date("Y-m-d H:i:s"),"is_active"=>$_POST['status']); 
		}
		
		
		//var_dump($update_array);exit();
        $last_inserted_id= $this->Transport_model->edit_vendor_submit($id,$update_array);
		if($last_inserted_id)
			$this->session->set_flashdata('message1','Vendor Details Updated Successfully.');
		else
			$this->session->set_flashdata('message2','Vendor Details Not Updated Successfully.');
        redirect(base_url($this->view_dir.'edit_vendor/'.$id));
    }
	
	public function buses_list()
    {
        $this->load->view('header',$this->data);
		$this->data['bus_details']=$this->Transport_model->get_bus_details();
        $this->load->view($this->view_dir.'buses_list',$this->data);
        $this->load->view('footer');
    }
	
	public function get_bus_details_by_campus()
	{
		$bus_details=$this->Transport_model->get_bus_details();
		
		$j=1;                      
		for($i=0;$i<count($bus_details);$i++)
		{
			if($bus_details[$i]['inhouse']=='Y')
				$inhouse='Yes';
			else
				$inhouse='No';
			
			echo '<tr>
				<td>'.$j.'</td>
				<td>'.$bus_details[$i]['campus'].'</td>  
				<td>'.$bus_details[$i]['vendor_name'].'</td> 
				<td>'.$bus_details[$i]['bus_no'].'</td>
				<td>'.$bus_details[$i]['bus_company'].'</td>
				<td>'.$bus_details[$i]['bus_model_no'].'</td>
				<td>'.$bus_details[$i]['manufacture_year'].'</td>
				<td>'.$bus_details[$i]['capacity'].'</td>
				<td>'.$inhouse.'</td>
				<td>
				   <a title="Edit Bus Details" class="btn btn-primary btn-xs" href="'.base_url($currentModule."/edit_bus/".$bus_details[$i]['bus_id']).'">Edit</a>
				</td>
			</tr>';
			
			$j++;
		}

	}
	
	public function bus_list_excel()
    {
		$this->data['bus_details']=$this->Transport_model->get_bus_details();
        $this->load->view($this->view_dir.'bus_list_excel',$this->data);
    }
	
	public function add_bus()
	{
		$this->load->view('header',$this->data); 
		$this->data['vendor_details']=$this->Transport_model->get_vendor_details();		
		$this->load->view($this->view_dir.'add_bus',$this->data);
        $this->load->view('footer');
	}
	
	public function add_bus_submit()
	{
		$insert_array=array("vendor_id"=>$_POST['vendor'],"bus_no"=>$_POST['bno'],"capacity"=>$_POST['capacity'],"bus_company"=>$_POST['company'],"bus_model_no"=>$_POST['model'],"manufacture_year"=>$_POST['myear'],"inhouse"=>$_POST['inhouse'],"created_by"=>$this->session->userdata("uid"),"created_on"=>date("Y-m-d H:i:s"),"is_active"=>"Y"); 
		//var_dump($insert_array);exit();
        $last_inserted_id= $this->Transport_model->add_bus_submit($insert_array);
		if($last_inserted_id)
			$this->session->set_flashdata('message1','Bus Details Added Successfully.');
		else
			$this->session->set_flashdata('message2','Bus Details Not Added Successfully.');
        redirect(base_url($this->view_dir.'buses_list'));
	}
	
	public function edit_bus()
	{
		$id=$this->uri->segment(3);
        $this->load->view('header',$this->data);
		$this->data['vendor_details']=$this->Transport_model->get_vendor_details();			
        $this->data['bus_details']= array_shift($this->Transport_model->get_bus_details($id));
		$this->load->view($this->view_dir.'edit_bus',$this->data);
        $this->load->view('footer');
	}
	
	public function edit_bus_submit()
	{
		$id=$this->uri->segment(3);
		$update_array=array("vendor_id"=>$_POST['vendor'],"bus_no"=>$_POST['bno'],"capacity"=>$_POST['capacity'],"bus_company"=>$_POST['company'],"bus_model_no"=>$_POST['model'],"manufacture_year"=>$_POST['myear'],"inhouse"=>$_POST['inhouse'],"created_by"=>$this->session->userdata("uid"),"created_on"=>date("Y-m-d H:i:s"),"is_active"=>$_POST['status']); 
		//var_dump($insert_array);exit();
        $last_inserted_id= $this->Transport_model->edit_bus_submit($id,$update_array);
		if($last_inserted_id)
			$this->session->set_flashdata('message1','Bus Details updated Successfully.');
		else
			$this->session->set_flashdata('message2','Bus Details Not updated Successfully.');
        redirect(base_url($this->view_dir.'edit_bus/'.$id));
	}
	
	public function xdrivers_list()
    {
        $this->load->view('header',$this->data);
		$this->data['driver_details']=$this->Transport_model->get_driver_details();
        $this->load->view($this->view_dir.'drivers_list',$this->data);
        $this->load->view('footer');
    }
	
	public function route_master()
    {
        $this->load->view('header',$this->data);
		$this->data['route_details']=$this->Transport_model->get_routemaster_details();
        $this->load->view($this->view_dir.'route_master',$this->data);
        $this->load->view('footer');
    } 
	
	public function driver_master()
    {
        $this->load->view('header',$this->data);
		$this->data['driver_details']=$this->Transport_model->get_drivermaster_details();
        $this->load->view($this->view_dir.'driver_master',$this->data);
        $this->load->view('footer');
    }
	
	public function edit_driver()
	{
		$id=$this->uri->segment(3);
        $this->load->view('header',$this->data); 
$this->data['campus']= $this->Transport_model->getcampusname();		
		$this->data['state']= $this->Transport_model->getAllState();
		$this->data['vendor_details']=$this->Transport_model->get_vendor_details();
        $this->data['driver_details']= array_shift($this->Transport_model->get_drivermaster_details($id));
		$this->load->view($this->view_dir.'edit_driver',$this->data);
        $this->load->view('footer');
	}
	
	public function edit_route()
    {
		$this->data['rid']=$this->uri->segment(3);
        $this->load->view('header',$this->data);
		$this->data['boarding_details']=$this->Transport_model->get_boarding_details();
		//$p_dts=$this->Transport_model->get_bus_boarding_details($_POST);
		$this->data['route_details']=$this->Transport_model->get_bus_boarding_details($this->data);
        $this->load->view($this->view_dir.'edit_route',$this->data);
        $this->load->view('footer');
    }
	
	public function get_driver_details()
	{
		$id=$_POST['pid'];//echo "id===".$id;
		$p_dts=array_shift($this->Transport_model->get_drivermaster_details($id));
		echo json_encode(array("driver_details"=>$p_dts));
	}
	
	public function add_driver()
    {
        $this->load->view('header',$this->data);
		$this->data['state']= $this->Transport_model->getAllState();
		$this->data['campus']= $this->Transport_model->getcampusname();
		$this->data['vendor_details']=$this->Transport_model->get_vendor_details();
        $this->load->view($this->view_dir.'add_driver',$this->data);
        $this->load->view('footer');
    }
	
	public function bus_vender_mapping()
    {
        $this->load->view('header',$this->data);
		$this->load->view($this->view_dir.'add_bus_vender_mapping',$this->data);
        $this->load->view('footer');
    }
	
	public function add_driver_submit()
    {
		//echo 'filename=='.$_FILES['mou_doc']['name'];exit();
		if(!empty($_FILES['mou_doc']['name'])){
			$filenm=$_POST['License'].'-'.$_FILES['mou_doc']['name'];
			$config['upload_path'] = 'uploads/Transport/Driver';
			$config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
			$config['overwrite']= TRUE;
			$config['max_size']= "2048000";
			//$config['file_name'] = $_FILES['profile_img']['name'];
			$config['file_name'] = $filenm;

			//Load upload library and initialize configuration
			$this->load->library('upload',$config);
			$this->upload->initialize($config);

			if($this->upload->do_upload('mou_doc')){
				$uploadData = $this->upload->data();
				$payfile = $uploadData['file_name'];
			}else{
				$payfile = '';
			}
		}
		else{
			$payfile = '';
		}
		
		if(!empty($_FILES['pic']['name'])){
			$filenm=$_POST['License'].'-'.$_FILES['pic']['name'];
			$config['upload_path'] = 'uploads/Transport/Driver';
			$config['allowed_types'] = 'jpg|jpeg|png';
			$config['overwrite']= TRUE;
			$config['max_size']= "2048000";
			//$config['file_name'] = $_FILES['profile_img']['name'];
			$config['file_name'] = $filenm;

			//Load upload library and initialize configuration
			$this->load->library('upload',$config);
			$this->upload->initialize($config);

			if($this->upload->do_upload('pic')){
				$uploadData = $this->upload->data();
				$pic = $uploadData['file_name'];
			}else{
				$pic = '';
			}
		}
		else{
			$pic = '';
		}
		
		$insert_array=array("campus"=>$_POST['campus'],"driver_name"=>$_POST['driver'],"vendor_id"=>$_POST['vendor'],"mobile"=>$_POST['mobile'],"driver_photo"=>$_POST['photo'],"address"=>$_POST['address'],"service_started_date"=>$_POST['sdate'],"service_end_date"=>$_POST['edate'],"state_id"=>$_POST['hstate_id'],"district_id"=>$_POST['hdistrict_id'],"taluka_id"=>$_POST['hcity'],"pincode"=>$_POST['pincode'],"agreement_documents"=>$payfile,"batch_no"=>$_POST['batch'],"batch_validity"=>$_POST['bvalidity'],"driver_photo"=>$pic,"driving_license_no"=>$_POST['License'],"created_by"=>$this->session->userdata("uid"),"created_on"=>date("Y-m-d H:i:s"),"is_active"=>"Y"); 
		//var_dump($insert_array);exit();
        $last_inserted_id= $this->Transport_model->add_driver_submit($insert_array);
		if($last_inserted_id)
			$this->session->set_flashdata('message1','Driver Details Added Successfully.');
		else
			$this->session->set_flashdata('message2','Driver Details Not Added Successfully.');
        redirect(base_url($this->view_dir.'driver_master'));
    }
	
	public function edit_driver_submit()
    {
		$id=$this->uri->segment(3);
		$update_array=array();
		$payfile='';
		$pic='';
		//echo 'filename=='.$_FILES['mou_doc']['name'];exit();
		if(!empty($_FILES['mou_doc']['name'])){
			$filenm=$_POST['License'].'-'.$_FILES['mou_doc']['name'];
			$config['upload_path'] = 'uploads/Transport/Driver';
			$config['allowed_types'] = 'jpg|jpeg|png|pdf';
			$config['overwrite']= TRUE;
			$config['max_size']= "2048000";
			//$config['file_name'] = $_FILES['profile_img']['name'];
			$config['file_name'] = $filenm;

			//Load upload library and initialize configuration
			$this->load->library('upload',$config);
			$this->upload->initialize($config);

			if($this->upload->do_upload('mou_doc'))
			{
				$uploadData = $this->upload->data();
				$payfile = $uploadData['file_name'];
				$mou_array=array("agreement_documents"=>$payfile); 
			}
		}
		else
			$mou_array=array();
		
		
		if(!empty($_FILES['pic']['name'])){
			$filenm=$_POST['License'].'-'.$_FILES['pic']['name'];
			$config['upload_path'] = 'uploads/Transport/Driver';
			$config['allowed_types'] = 'jpg|jpeg|png|pdf';
			$config['overwrite']= TRUE;
			$config['max_size']= "2048000";
			//$config['file_name'] = $_FILES['profile_img']['name'];
			$config['file_name'] = $filenm;

			//Load upload library and initialize configuration
			$this->load->library('upload',$config);
			$this->upload->initialize($config);

			if($this->upload->do_upload('pic'))
			{
				$uploadData = $this->upload->data();
				$pic = $uploadData['file_name'];
				$pic_array=array("driver_photo"=>$pic); 
			}
		}
		else
			$pic_array=array();
		
		$update_array=array("campus"=>$_POST['campus'],"driver_name"=>$_POST['driver'],"vendor_id"=>$_POST['vendor'],"mobile"=>$_POST['mobile'],"address"=>$_POST['address'],"service_started_date"=>$_POST['sdate'],"service_end_date"=>$_POST['edate'],"state_id"=>$_POST['hstate_id'],"district_id"=>$_POST['hdistrict_id'],"taluka_id"=>$_POST['hcity'],"pincode"=>$_POST['pincode'],"batch_no"=>$_POST['batch'],"batch_validity"=>$_POST['bvalidity'],"driving_license_no"=>$_POST['License'],"modified_by"=>$this->session->userdata("uid"),"modified_on"=>date("Y-m-d H:i:s"),"is_active"=>$_POST['status']); 
		
		$temp=array();
		$temp=array_merge($mou_array,$pic_array);
		//print_r(array_merge($update_array,$temp));exit();
		//var_dump($update_array);exit();
        $last_inserted_id= $this->Transport_model->edit_driver_submit($id,array_merge($update_array,$temp));
		if($last_inserted_id)
			$this->session->set_flashdata('message1','Driver Details Updated Successfully.');
		else
			$this->session->set_flashdata('message2','Driver Details Not Updated Successfully.');
        redirect(base_url($this->view_dir.'edit_driver/'.$id));
    }
	
	public function get_buses_list_notin_vendor()
	{
		$get_all_vendorbuses_list=$this->Transport_model->get_all_vendorbuses_list();
		
		foreach($get_all_vendorbuses_list as $val){
			$buslist[]=$val['bus_id'];
		}
//var_dump($buslist);exit();
		$get_buses_list_notin_vendor=$this->Transport_model->get_buses_list_notin_vendor($buslist);
		/* echo "<table id='myTable' class='table' >";
        echo "<th></th><th>Stream Name</th><th>Year</th>"; */
        foreach($get_buses_list_notin_vendor as $val){
            echo "<tr >";
            echo "<td><input name=\"bus_list[]\" onclick=\"count_ischecked()\" value='".$val['bus_id']."||".$val['bus_no']."' class = \"chk\" type='checkbox' ></td>";
            echo "<td>".$val['bus_no']."</td>";
            //echo "<td>".$_POST['year']."</td>";
            echo "</tr>";
        }
	}
	
	public function vendor_buses_list()
	{
		$this->load->view('header',$this->data);
		$this->data['vendor_details']=$this->Transport_model->get_vendor_details();
		$this->load->view($this->view_dir.'vendor_buses_list',$this->data);
        $this->load->view('footer');
	}
	
	public function get_vendor_bus_details()
	{
		$vendor_bus_details=$this->Transport_model->get_vendor_bus_details($_POST);
		$i=1;
		$ban='fa-ban';
		$check='fa-check';
		$gender='';
		
		foreach($vendor_bus_details as $val){
           	 echo '<tr>
					 <td>'.$i.'</td>
					 <td>'.$val["campus"].'</td>
					 <td>'.$val["vendor_name"].'</td>
					 <td>'.$val["bus_no"].'</td>
					 <td>'.$val["capacity"].'</td>
					
					<!--<td>
					
					<a href="'.base_url($currentModule.$this->view_dir.'edit_vendor_bus/'.$val['vendor_id']).'" title="edit the details"><i class="fa fa-edit"></i></a>
					
				   </td>-->
				   </tr>';
				  
			$i++;
        }
	}
	
	public function add_vendor_bus_submit()
	{
		if(count($_POST['bus_list'])>0)
		{
			$j=0;
			$insert_array = array();
			for($i = 1; $i <= count($_POST['bus_list']); $i++)
			{
				$bus_details=explode('||',$_POST['bus_list'][$j]);
				$insert_array[$j]=array("bus_id"=>$bus_details[0],"bus_no"=>$bus_details[1],"vendor_id"=>$_POST['vendor'],"created_by"=>$this->session->userdata("uid"),"created_on"=>date("Y-m-d H:i:s"),"is_active"=>'Y');
				$j++;
			}
			//var_dump($insert_array);exit();
			$last_inserted_id=$this->Transport_model->add_vendor_bus_submit($insert_array);
		}
		else
			$this->session->set_flashdata('message2','No bus available to enter vendor bus details');
		
		if($last_inserted_id)
			$this->session->set_flashdata('message1','vendor bus Detail has inserted Successfully.');
		else
			$this->session->set_flashdata('message2','vendor bus Detail has not inserted Successfully.');
		redirect('Transport/vendor_buses_list');
	}
	
	public function check_route_exists()
	{
		echo $dts=$this->Transport_model->check_route_exists($_POST);
	}
	
	public function check_boardingpoint_exists()
	{
		echo $dts=$this->Transport_model->check_boardingpoint_exists($_POST);
	}
	
	public function check_vendor_exists()
	{
		echo $dts=$this->Transport_model->check_vendor_exists($_POST);
	}
	
	public function check_vendor_gst_exists()
	{
		echo $dts=$this->Transport_model->check_vendor_gst_exists($_POST);
	}
	
	public function check_bus_exists()
	{
		echo $dts=$this->Transport_model->check_bus_exists($_POST);
	}
	
	public function check_drivername_exists()
	{
		echo $dts=$this->Transport_model->check_drivername_exists($_POST);
	}
	
	public function check_driver_license_exists()
	{
		echo $dts=$this->Transport_model->check_driver_license_exists($_POST);
	}
	
	public function check_driver_batchno_exists()
	{
		echo $dts=$this->Transport_model->check_driver_batchno_exists($_POST);
	}
	
	public function get_buses_list_notin_driver_bus_map()
	{
		$get_all_driverbusesmap_list=$this->Transport_model->get_allbuses_driverbusesmap_list();
		
		foreach($get_all_driverbusesmap_list as $val){
			$buslist[]=$val['bus_id'];
		}
		
		$buses=$this->Transport_model->get_buses_list_notin_driver_bus_map($buslist,$_POST['vendor']);
		
        if(!empty($buses)){
			echo"<option value=''>Select Bus No.</option>";
			foreach($buses as $key=>$val){
				echo"<option value='".$buses[$key]['bus_id']."'>".$buses[$key]['bus_no']."</option>";
			}		
		}
	}
	
	public function get_drivers_list_notin_driver_bus_map()
	{
		$get_all_driverbusesmap_list=$this->Transport_model->get_alldriver_driverbusesmap_list();
		
		foreach($get_all_driverbusesmap_list as $val){
			$driverlist[]=$val['driver_id'];
		}
		
		$drivers=$this->Transport_model->get_drivers_list_notin_driver_bus_map($driverlist,$_POST);
		
        if(!empty($drivers)){
			echo"<option value=''>Select Driver Id</option>";
			foreach($drivers as $key=>$val){
				echo"<option value='".$drivers[$key]['driver_id']."'>".$drivers[$key]['driver_name']."</option>";
			}		
		}
	}
	
	public function driver_bus_mapping()
	{
		$this->load->view('header',$this->data);
		$this->load->view($this->view_dir.'driver_bus_mapping');
        $this->load->view('footer');
	}
	
	public function getvendorsbycampus()
	{
		$vendors=$this->Transport_model->getvendorsbycampus($_POST['campus']);
		//print_r($dist);exit;
		if(!empty($vendors)){
			echo"<option value=''>Select vendor</option>";
			foreach($vendors as $key=>$val){
				echo"<option value='".$vendors[$key]['vendor_id']."'>".$vendors[$key]['vendor_name']."</option>";
			}		
		}
	}
	
	public function getdriversbyvendor()
	{
		$drivers=$this->Transport_model->getdriversbyvendor($_POST['vendor']);
		//print_r($dist);exit;
		if(!empty($drivers)){
			echo"<option value=''>Select driver id</option>";
			foreach($drivers as $key=>$val){
				echo"<option value='".$drivers[$key]['driver_id']."'>".$drivers[$key]['driver_name']."</option>";
			}		
		}
	}
	
	public function getbusbyvendor()
	{
		$buses=$this->Transport_model->getbusbyvendor($_POST['vendor']);
		//print_r($dist);exit;
		if(!empty($buses)){
			echo"<option value=''>Select Bus No.</option>";
			foreach($buses as $key=>$val){
				echo"<option value='".$buses[$key]['bus_id']."'>".$buses[$key]['bus_no']."</option>";
			}		
		}
	}
	
	public function driver_bus_mapping_submit()
	{
		$insert_array=array("route_id"=>$_POST['route'],"bus_id"=>$_POST['bno'],"driver_id"=>$_POST['did'],"created_by"=>$this->session->userdata("uid"),"created_on"=>date("Y-m-d H:i:s"),"is_active"=>"Y"); 
		//var_dump($insert_array);exit();
        $last_inserted_id= $this->Transport_model->driver_bus_mapping_submit($insert_array);
		if($last_inserted_id)
			$this->session->set_flashdata('message1','Driver Bus mapping Details Added Successfully.');
		else
			$this->session->set_flashdata('message2','Driver Bus mapping Details Not Added Successfully.');
        redirect(base_url($this->view_dir.'drivers_list'));
	}
	
	/* public function add_route()
	{
		$this->load->view('header',$this->data);
		$this->load->view($this->view_dir.'add_route');
        $this->load->view('footer');
	} */
	
	public function add_route_submit()
	{
		$insert_array=array("campus"=>$_POST['campus'],"route_name"=>$_POST['rname'],"route_code"=>$_POST['rcode'],"created_by"=>$this->session->userdata("uid"),"created_on"=>date("Y-m-d H:i:s")); 
		//var_dump($insert_array);exit();
        $last_inserted_id= $this->Transport_model->add_route_submit($insert_array);
		if($last_inserted_id)
			$this->session->set_flashdata('message1','Route Details Added Successfully.');
		else
			$this->session->set_flashdata('message2','Route Details Not Added Successfully.');
        redirect(base_url($this->view_dir.'route_master'));
	}
	
	/* public function delete_boardingpoint()
	{
		
	} */
	
	public function edit_route_submit()
	{
		$id=$this->uri->segment(3);
		//print_r($_POST);
		if(count($_POST['capacity'])>0)
		{
			$j=0;
			$insert_array = array();
			$update_array = array();
			$cart = array();

			for($i = 1; $i <= count($_POST['keyvalue']); $i++)
			{
				if($_POST['keyvalue'][$j]=="" && $_POST['capacity'][$j]!="")
				{
					$_POST['keyvalue'][$j]=0;
				array_push($cart,$_POST['keyvalue'][$j]);
				}else
					array_push($cart,$_POST['keyvalue'][$j]);
				
				$j++;
			}
			
			
			$jj=0;
			for($i = 1; $i <= count($_POST['capacity']); $i++)
			{
				//echo $j.'='.$cart[$j].'='.$_POST['boarding'][$j].'='.$_POST['capacity'][$j].'</br>';
				if($cart[$jj]=="0" && $_POST['capacity'][$jj]>0)
$insert_array[$jj]=array("sequence_no"=>$_POST['capacity'][$jj],
"board_id"=>$_POST['boarding'][$jj],
"route_id"=>$_POST['route_id'],"is_active"=>'Y',"created_by"=>$this->session->userdata("uid"),
"created_on"=>date("Y-m-d H:i:s"));
			else if($cart[$jj]>0 && $_POST['capacity'][$jj]>0)
	$update_array[$jj]=array("details_id"=>$_POST['keyvalue'][$jj],
	"sequence_no"=>$_POST['capacity'][$jj],
	"modified_by"=>$this->session->userdata("uid"),
	"modified_on"=>date("Y-m-d H:i:s"));
			else if($cart[$jj]>0 && $_POST['capacity'][$jj]=="0")
				$delete_array[$jj]=array("details_id"=>$_POST['keyvalue'][$jj],"is_active"=>'N',
				"modified_by"=>$this->session->userdata("uid"),"modified_on"=>date("Y-m-d H:i:s"));
			
				$jj++;
			}
			//print_r($insert_array);echo '</br>';
			//print_r($update_array);echo '</br>';
			//print_r($delete_array);echo '</br>';
			//exit();
			$last_inserted_id=$this->Transport_model->add_route_boarding_mapping_submit($insert_array);
			if($last_inserted_id){
			$last_updated_id=$this->Transport_model->edit_route_submit($update_array);
			}
			if($last_updated_id){
			$last_deleted_id=$this->Transport_model->edit_route_submit($delete_array);
			}
		}
		else
			$this->session->set_flashdata('message2','No Boarding point available to Update Route Details');
		
		if($last_updated_id)
			$this->session->set_flashdata('message1','Route & Boarding Detail Have Updated Successfully.');
		else
			$this->session->set_flashdata('message2','Route & Boarding Detail Have Not Updated Successfully.');	
	
        redirect(base_url($this->view_dir.'edit_route/'.$id));
	}
	
	public function add_boarding_details()
	{
		$this->load->view('header',$this->data);
		$this->data['campus']= $this->Transport_model->getcampusname();
		$this->load->view($this->view_dir.'add_boarding_details',$this->data);
        $this->load->view('footer');
	}
	
	public function boarding_list()
	{
		$this->load->view('header',$this->data);
		$this->data['boarding_details']=$this->Transport_model->get_boardingmaster_details();
		$this->load->view($this->view_dir.'boarding_list',$this->data);
        $this->load->view('footer');
	}
	
	public function edit_boarding_details()
	{
		$id=$this->uri->segment(3);
		$this->load->view('header',$this->data);
		$this->data['campus']= $this->Transport_model->getcampusname();
		$this->data['boarding_details']=array_shift($this->Transport_model->get_boardingmaster_details($id));
		$this->load->view($this->view_dir.'edit_boarding_details',$this->data);
        $this->load->view('footer');
	}
	
	public function add_boarding_submit()
	{
		$insert_array=array("boarding_point"=>$_POST['bpoint'],"distance_from_campus"=>$_POST['distance'],"campus"=>$_POST['campus'],"is_active"=>'Y',"created_by"=>$this->session->userdata("uid"),"created_on"=>date("Y-m-d H:i:s")); 
		
		//"pickup_timing"=>$_POST['ptime'],"drop_timing"=>$_POST['dtime'],
		
		//var_dump($insert_array);exit();
        $last_inserted_id= $this->Transport_model->add_boarding_submit($insert_array);
		if($last_inserted_id)
			$this->session->set_flashdata('message1','Boarding Details Added Successfully.');
		else
			$this->session->set_flashdata('message2','Boarding Details Not Added Successfully.');
        redirect(base_url($this->view_dir.'boarding_list'));
	}
	
	public function edit_boarding_submit()
	{
		$id=$this->uri->segment(3);
		$update_array=array("boarding_point"=>$_POST['bpoint'],"distance_from_campus"=>$_POST['distance'],"campus"=>$_POST['campus'],"modified_by"=>$this->session->userdata("uid"),"modified_on"=>date("Y-m-d H:i:s")); 
		
		//"pickup_timing"=>$_POST['ptime'],"drop_timing"=>$_POST['dtime'],
		
		//var_dump($insert_array);exit();
        $last_inserted_id= $this->Transport_model->edit_boarding_submit($id,$update_array);
		if($last_inserted_id)
			$this->session->set_flashdata('message1','Boarding Details Updated Successfully.');
		else
			$this->session->set_flashdata('message2','Boarding Details Not Updated Successfully.');
        redirect(base_url($this->view_dir.'edit_boarding_details/'.$id));
	}
	
	public function add_route()
	{
		$this->load->view('header',$this->data);
		$this->data['campus']= $this->Transport_model->getcampusname();
		$this->data['boarding_details']=$this->Transport_model->get_boarding_details();
		$this->load->view($this->view_dir.'add_route_boarding_mapping',$this->data);
        $this->load->view('footer');
	}
	
	public function bus_allocation_list()
	{
		$this->load->view('header',$this->data);
		$this->data['allocatedbus_details']=$this->Transport_model->get_allbuses_in_allocationlist();
		$this->load->view($this->view_dir.'bus_allocation_list',$this->data);
        $this->load->view('footer');
	}
	
	public function bus_allocation_submit()
	{
		$arr=$_POST['bus'];
		$arr=explode('||',$_POST['bus']);
		$ptime='';
		$pickuptiming=$this->input->post("pickuptiming");
		for($i = 0; $i <= count($pickuptiming); $i++)
		{
			$ptime.=$pickuptiming[$i].',';
		}
		//$ptime=substr($ptime, 0, -1);
		$ptime=rtrim($ptime,", ");
		//echo 'p=='.$ptime;
		
		$dtime='';
		$droptiming=$this->input->post("droptiming");
		for($i = 0; $i <= count($droptiming); $i++)
		{
			$dtime.=$droptiming[$i].',';
		}
		//echo '=='.$dtime;
		//$dtime=substr($dtime, 0, -1);
		$dtime=rtrim($dtime,", ");
		//echo 'd=='.$dtime;
		
		$insert_array=array("route_id"=>$_POST['route'],"bus_no"=>$arr[2],"bus_id"=>$arr[0],"driver_id"=>$_POST['did'],"academic_year"=>$_POST['academic'],"pickup_time"=>$ptime,"departure_time"=>$dtime,"created_by"=>$this->session->userdata("uid"),"created_on"=>date("Y-m-d H:i:s"),"is_active"=>"Y"); 
		//var_dump($insert_array);exit();
        $last_inserted_id= $this->Transport_model->bus_allocation_submit($insert_array);
		if($last_inserted_id)
			$this->session->set_flashdata('message1','Bus Allocation IS Done Successfully.');
		else
			$this->session->set_flashdata('message2','Bus Allocation IS Not Done  Successfully.');
        redirect(base_url($this->view_dir.'bus_allocation'));
	}
	
	public function edit_bus_allocation_submit()
	{
		$arr=$_POST['bus'];
		$arr=explode('||',$_POST['bus']);
		$ptime='';
		$pickuptiming=$this->input->post("pickuptiming");
		for($i = 0; $i <= count($pickuptiming); $i++)
		{
			$ptime.=$pickuptiming[$i].',';
		}
		//$ptime=substr($ptime, 0, -1);
		$ptime=rtrim($ptime,", ");
		//echo 'p=='.$ptime;
		
		$dtime='';
		$droptiming=$this->input->post("droptiming");
		for($i = 0; $i <= count($droptiming); $i++)
		{
			$dtime.=$droptiming[$i].',';
		}
		//echo '=='.$dtime;
		//$dtime=substr($dtime, 0, -1);
		$dtime=rtrim($dtime,", ");
		//echo 'd=='.$dtime;
		
		$update_array=array("route_id"=>$_POST['route'],"bus_no"=>$arr[2],"bus_id"=>$arr[0],"driver_id"=>$_POST['did'],"academic_year"=>$_POST['academic'],"pickup_time"=>$ptime,"departure_time"=>$dtime,"modified_by"=>$this->session->userdata("uid"),"modified_on"=>date("Y-m-d H:i:s"),"is_active"=>"Y"); 
		//var_dump($insert_array);exit();
        $last_inserted_id= $this->Transport_model->edit_bus_allocation_submit($update_array,$this->uri->segment(3));
		if($last_inserted_id)
			$this->session->set_flashdata('message1','Bus Allocation Updated Successfully.');
		else
			$this->session->set_flashdata('message2','Bus Allocation IS Not Updated  Successfully.');
        redirect(base_url($this->view_dir.'edit_bus_allocation/'.$this->uri->segment(3)));
	}
	
	public function edit_bus_allocation()
	{
		$id=$this->uri->segment(3);
		$this->load->view('header',$this->data);
		$this->data['academic_details']= $this->Transport_model->get_academic_details();
		$this->data['route_details']=$this->Transport_model->get_route_details();
		$this->data['allocatedbus_details']=array_shift($this->Transport_model->get_allbuses_in_allocationlist($id));
		
		$get_allocationbus_list=$this->Transport_model->get_allbuses_in_allocationlist();
		
		foreach($get_allocationbus_list as $val){
			if($this->data['allocatedbus_details']['bus_id']!=$val['bus_id'])
			{
				$buslist[]=$val['bus_id'];
				$driverlist[]=$val['driver_id'];
			}
		}
				
		$this->data['bus_details']=$this->Transport_model->get_bus_list_notin_allocation($buslist,$_POST);
		
		$this->data['driver_details']=$this->Transport_model->get_driver_list_notin_allocation($driverlist,$_POST);
	
		$this->load->view($this->view_dir.'edit_bus_allocation',$this->data);
        $this->load->view('footer');
	}
	
	public function bus_allocation()
	{
		$this->load->view('header',$this->data);
		$this->data['academic_details']= $this->Transport_model->get_academic_details();
		$this->data['route_details']=$this->Transport_model->get_route_details();
		
		$get_allocationbus_list=$this->Transport_model->get_allbuses_in_allocationlist();
		
		foreach($get_allocationbus_list as $val){
			$buslist[]=$val['bus_id'];
			$driverlist[]=$val['driver_id'];
		}
				
		$this->data['bus_details']=$this->Transport_model->get_bus_list_notin_allocation($buslist,$_POST);
		
		$this->data['driver_details']=$this->Transport_model->get_driver_list_notin_allocation($driverlist,$_POST);
		
		$this->data['allocatedbus_details']=$get_allocationbus_list;
		$this->data['campus']= $this->Transport_model->getcampusname();	
		$this->load->view($this->view_dir.'bus_allocation',$this->data);
        $this->load->view('footer');
	}
	
	public function getroutesbycampus()
	{   //echo "campus==".$_POST['campus'];exit();
		$get_allroute_routeboardingmap_list=$this->Transport_model->get_allroute_routeboardingmap_list($_POST['campus']);
		
		foreach($get_allroute_routeboardingmap_list as $val){
			$routelist[]=$val['route_id'];
		}
		
		$route_details=$this->Transport_model->get_routes_list_notin_route_boarding_map($routelist,$_POST);
		//$route_details=$this->Transport_model->get_route_details($_POST['campus']);
		if(!empty($route_details)){
			echo"<option value=''>Select Route</option>";
			foreach($route_details as $key=>$val){
				echo"<option value='".$route_details[$key]['route_id']."'>".$route_details[$key]['route_name']."</option>";
			}		
		}
	}
	
	public function getboardingsbycampus()
	{
		$boarding_details=$this->Transport_model->get_boarding_details($_POST['campus']);
		if(!empty($boarding_details)){
			$j=1;
			foreach($boarding_details as $val)
			{
				echo "<tr >";
				echo "<td><input name=\"boarding_list[]\" id='check_".$j."' onclick=\"count_ischecked(this.id)\" value='".$val['board_id']."' class = \"chk\" type='checkbox' ></td>";
				echo "<td>".$val['boarding_point']."</td>";
				echo "<td> <input type=\"text\" id=\"capacity".$j."\" name=\"capacity[]\" class=\"givenclass form-control \" onkeyup=\"only_number(this.id)\" style=\"width:80px;\" disabled required/> </td>";
				//echo "<td>".$_POST['year']."</td>";
				echo "</tr>";
				$j++;
			}
		}
	}
	
	public function add_route_boarding_mapping_submit()
	{
		$insert_array=array("campus"=>$_POST['campus'],"route_name"=>$_POST['rname'],"route_code"=>$_POST['rcode'],"created_by"=>$this->session->userdata("uid"),"created_on"=>date("Y-m-d H:i:s")); 
		//var_dump($insert_array);exit();
        $inserted_id= $this->Transport_model->add_route_submit($insert_array);
		
		if(count($_POST['capacity'])>0)
		{
			$j=0;
			$insert_array = array();
			for($i = 1; $i <= count($_POST['capacity']); $i++)
			{
				$insert_array[$j]=array("is_active"=>'Y',"sequence_no"=>$_POST['capacity'][$j],"board_id"=>$_POST['boarding_list'][$j],"route_id"=>$inserted_id,"created_by"=>$this->session->userdata("uid"),"created_on"=>date("Y-m-d H:i:s"));
				$j++;
			}
			//var_dump($insert_array);exit();
			$last_inserted_id=$this->Transport_model->add_route_boarding_mapping_submit($insert_array);
		}
		else
			$this->session->set_flashdata('message2','No Boarding point available to enter route boarding mapping details');
		
		if($last_inserted_id)
			$this->session->set_flashdata('message1','Route boarding mapping Detail has inserted Successfully.');
		else
			$this->session->set_flashdata('message2','Route boarding mapping Detail has not inserted Successfully.');
		redirect('Transport/route_master');
	}
	
	public function qqqroutes_list()
	{
		$this->load->view('header',$this->data);
		$this->load->view($this->view_dir.'route_details');
        $this->load->view('footer');
	}
	
	public function get_route_boarding_details()
	{
		$route_boarding_details=$this->Transport_model->get_route_boarding_details($_POST);
		$i=1;
		$ban='fa-ban';
		$check='fa-check';
		$gender='';
		
		foreach($route_boarding_details as $val){
			$campus='fullview_boarding('.$val['route_id'].',\''.$val['campus'].'\')';
			//echo $campus;exit();
			
			($val["bus_no"]==null)?$busno='<span style="color:red;">Not Allocated</span>':$busno=$val["bus_no"];
			($val["driver_name"]==null)?$dname='<span style="color:red;">Not Allocated</span>':$dname=$val["driver_name"];
			($val["vendor_name"]==null)?$vname='<span style="color:red;">Not Allocated</span>':$vname=$val["vendor_name"];			
			
           	 echo '<tr>
					 <td>'.$i.'</td>
					 <td>'.$val["campus"].'</td>
					 <td>'.$val["route_name"].'</td>
					 <td>'.$val["route_code"].'</td>
					 <td>'.$busno.'</td>
					 <td>'.$dname.'</td>
					<td>'.$vname.'</td>
					<td>
					<a title="View boarding Details" class="btn btn-primary btn-xs" onclick="'.$campus.'" >View</a>
					<!--	&nbsp;	&nbsp;	<a title="Delete Driver-Bus Details" class="btn btn-primary btn-xs" href="'.base_url($currentModule."/disable_route_boarding_mapping/".$driver_details[$i]['driver_id']).'">Delete</a>-->
				   </td>
				   </tr>';
				  
			$i++;
        }
	}
	
	public function disable_driver_bus_mapping()
	{
		$id=$this->uri->segment(3);
		$update_array=array("modified_by"=>$this->session->userdata("uid"),"modified_on"=>date("Y-m-d H:i:s"),"is_active"=>'N'); 
		$flag=$this->Transport_model->disable_driver_bus_mapping($id,$update_array);
		if($flag)
			$this->session->set_flashdata('message1','Driver Bus Mapping Detail Has disabled Successfully.');
		else
			$this->session->set_flashdata('message2','Driver Bus Mapping Detail Has Not disabled Successfully.');
		redirect('Transport/drivers_list');
	}
	
	public function boarding_fees_list()
    {
        $this->load->view('header',$this->data);
		$this->data['campus']= $this->Transport_model->getcampusname();
		$this->data['academic_details']= $this->Transport_model->get_academic_details();
        $this->load->view($this->view_dir.'boarding_fee_list',$this->data);
        $this->load->view('footer');
    }
	
	public function add_boarding_fees()
	{
		if($this->session->userdata("role_id")==5 || $this->session->userdata("role_id")==6 || $this->session->userdata("role_id")==46){
		}else{
			redirect('home');
		}
		$this->load->view('header',$this->data); 
		$this->data['campus']= $this->Transport_model->getcampusname();		
		$this->load->view($this->view_dir.'add_boarding_fee_details',$this->data);
        $this->load->view('footer');
	}
	
	public function get_boarding_list()
	{
		//var_dump($_POST);exit();
		$boarding_list=$this->Transport_model->get_boarding_details_infeemaster($_POST);
		foreach($boarding_list as $val){
			$boardinglist[]=$val['board_id'];
		}
		//print_r($boardinglist);exit();
		$boarding_fee_details=$this->Transport_model->get_boarding_list_notin_boarding($boardinglist,$_POST);
		if(!empty($boarding_fee_details)){
			$j=1;
			echo "<table class=\"table table-bordered\">
					<thead>
						<tr>
						<th>#</th>
						<th>Boarding Point</th>
						<th>Transport Fees</th>
						</tr>
					</thead>
					<tbody>";
			foreach($boarding_fee_details as $val)
			{
				echo "<tr >";
				echo "<td>".$j."</td>";
				echo "<td>".$val['boarding_point']."<input type=\"hidden\" name=\"b_id[]\" value=\"".$val['board_id']."\"/></td>";
				echo "<td> <input type=\"text\" id=\"fees".$j."\" name=\"fees[]\" class=\"only_number form-control \" onkeyup=\"only_number(this.id)\" style=\"width:80px;\" required/> </td>";
				//echo "<td>".$_POST['year']."</td>";
				echo "</tr>";
				$j++;
			}
			echo "</tbody></table>";
		}
		else
		{
			echo "";
		}
	}
	
	public function fees_details_submit()
	{
		$j=0;
		$insert_array = array();
		for($i = 1; $i <= count($_POST['fees']); $i++)
		{
			$insert_array[$j]=array("academic_year"=>$_POST['academicyear'],"category_id"=>$_POST['b_id'][$j],"fees"=>$_POST['fees'][$j],"facility_type_id"=>2,"status"=>'Y',"created_by"=>$this->session->userdata("uid"),"created_on"=>date("Y-m-d H:i:s"));
			//echo $insert_array[$j]['academic_year'].'=='.$insert_array[$j]['category_id'].'=='.$insert_array[$j]['fees'].'=='.$insert_array[$j]['facility_type_id'].'=='.$insert_array[$j]['status'].'=='.$insert_array[$j]['created_by']."<br/>";
			$j++;
			
		}
		//var_dump($insert_array);exit();
		$last_inserted_id=$this->Transport_model->add_boarding_fees_details_submit($insert_array);
		
		if($last_inserted_id)
			$this->session->set_flashdata('message1','Boarding Fee Details have inserted Successfully.');
		else
			$this->session->set_flashdata('message2','Boarding Fee Details have not inserted Successfully.');
		redirect('Transport/boarding_fees_list');
	}
	
	public function updateall_fees_details_submit()
	{
		$j=0;
		$update_array = array();
		for($i = 1; $i <= count($_POST['fees']); $i++)
		{
			$update_array[$j]=array("sffm_id"=>$_POST['b_id'][$j],"fees"=>$_POST['fees'][$j],"status"=>'Y',"modified_by"=>$this->session->userdata("uid"),"modified_on"=>date("Y-m-d H:i:s"));
			//echo $update_array[$j]['fees'].'=='.$update_array[$j]['sffm_id'].'=='.$update_array[$j]['fees'].'=='.$update_array[$j]['modified_by']."<br/>";
			$j++;
		}
		//var_dump($update_array);exit();
		$last_inserted_id=$this->Transport_model->updateall_fees_details_submit($update_array);
		
		if($last_inserted_id)
			$this->session->set_flashdata('message1','Boarding Fee Details have updated Successfully.');
		else
			$this->session->set_flashdata('message2','Boarding Fee Details have not updated Successfully.');
		redirect('Transport/edit_all_boardingfee_details/'.$this->uri->segment(3).'/'.$this->uri->segment(4));
	}
	
	public function get_boarding_feedetails()
	{
		$boardingfee_details=$this->Transport_model->get_boarding_details_infeemaster($_POST);
		$i=1;
		$ban='fa-ban';
		$check='fa-check';
		$gender='';
		
		foreach($boardingfee_details as $val){
			
           	 echo '<tr>
					 <td>'.$i.'</td>
					 <td>'.$val["boarding_point"].'</td>
					 <td>'.$val["fees"].'</td>
					 
					<td>
					<a href="'.base_url($currentModule.$this->view_dir.'edit_boarding_fee/'.$val['sffm_id'].'/'.$val['campus'].'/'.$val['academic_year']).'" title="edit the fee details"><i class="fa fa-edit"></i></a>
				   </td>
				   </tr>';
				  
			$i++;
        }
	}
	
	public function trip_list()
	{
		$this->load->view('header',$this->data);
		$this->data['bus_details']=$this->Transport_model->get_bus_details();
		//$this->data['route_details']=$this->Transport_model->get_routemaster_details();
		$this->data['trip_details']=$this->Transport_model->get_bus_trip_details();
        $this->load->view($this->view_dir.'trip_list',$this->data);
        $this->load->view('footer');
	}
	
	public function trip_list_new()
	{
		$this->load->view('header',$this->data);
		$this->data['bus_details']=$this->Transport_model->get_bus_details();
		//$this->data['route_details']=$this->Transport_model->get_routemaster_details();
		$this->data['trip_details']=$this->Transport_model->get_bus_trip_details_new();
        $this->load->view($this->view_dir.'trip_list_new',$this->data);
        $this->load->view('footer');
	}
	
	public function get_bus_trip_list_by_creteria()
	{
		$trip_list=$this->Transport_model->get_bus_trip_details($_POST);
		echo json_encode(array("trip_list"=>$trip_list));
	}
	
	public function get_bus_trip_list_by_creteria_new()
	{
		$trip_list=$this->Transport_model->get_bus_trip_details_new($_POST);
		echo json_encode(array("trip_list"=>$trip_list));
	}
	
	public function bus_checkincheckout()
	{
		$exist_status = $this->Transport_model->checking_bus_exists($_POST);
		if($exist_status[0]['count_rows']==1)
		{
			$details = $this->Transport_model->checking_bus_details($_POST);
			if(!empty($details)){
				if($details[0]['status']=="IN")
				$exist_status[0]['status']="OUT";
			else
				$exist_status[0]['status']="IN";
			}
			else
			{
				if($_POST['ttype_out']='tour')
					$exist_status[0]['status']='OUT';
				else
					$exist_status[0]['status']='IN';
			}
			$exist_status[0]['trip_date']=date("Y-m-d");
			$exist_status[0]['trip_time']=date("H:i:s",time());
			echo json_encode(array("bus_trip_details"=>$exist_status));
		}
		else
			echo json_encode(array("bus_trip_details"=>'Invalid Bus Number'));
		//echo 'Invalid Bus Number';
	}
	
	public function trip_entry()
	{
		$this->load->view('header',$this->data);
		$this->data['bus_details']=$this->Transport_model->get_bus_details();
        $this->load->view($this->view_dir.'trip_entry',$this->data);
        $this->load->view('footer');
	}
	
	public function trip_entry_new()
	{
		$this->load->view('header',$this->data);
		$this->data['bus_details']=$this->Transport_model->get_bus_details();
        $this->load->view($this->view_dir.'trip_entry_new',$this->data);
        $this->load->view('footer');
	}
	
	public function add_trip_entry()
	{
		$indate=array();
		$outdate=array();
		
		if($_POST['status']=="IN")
		{
			$indate=array("in_entry_by"=>$this->session->userdata("uid"),"in_entry_on"=>date("Y-m-d H:i:s"),"in_time"=>date("Y-m-d H:i:s"));
		}
		else
		{
			if($_POST['ttype_out']=="tour")
			{
				$outdate=array("visit_location"=>$_POST['visit'],"distance_from_campus"=>$_POST['distance'],"out_entry_by"=>$this->session->userdata("uid"),"out_entry_on"=>date("Y-m-d H:i:s"),"out_time"=>date("Y-m-d H:i:s"));
			}
			else
				$outdate=array("out_entry_by"=>$this->session->userdata("uid"),"out_entry_on"=>date("Y-m-d H:i:s"),"out_time"=>date("Y-m-d H:i:s"));
		}
			
		//echo var_dump($_POST);exit();
		
		$temp=array();
		$temp=array_merge($indate,$outdate);
		
		$fdate=date("Y-m-d", strtotime($_POST['tdate_out'])); 
		$insert_array=array("route_id"=>$_POST['rid_out'],"status"=>$_POST['status'],"bus_no"=>$_POST['busno_out'],"trip_date"=>$fdate,"trip_time"=>$_POST['ttime_out'],"trip_type"=>$_POST['ttype_out'],"entry_ip"=>$_SERVER['REMOTE_ADDR']);
		//var_dump($insert_array);exit();
        $last_inserted_id= $this->Transport_model->add_trip_entry(array_merge($insert_array,$temp));
		if($last_inserted_id)
			$this->session->set_flashdata('message1','Bus Trip Details Added Successfully.');
		else
			$this->session->set_flashdata('message2','Bus Trip Details Not Added Successfully.');
        redirect(base_url($this->view_dir.'trip_list'));
	} 
	
	public function add_trip_entry_new()
	{
		$indate=array();
		$outdate=array();
		
		if($_POST['checkp']=="IN")
		{
			$indate=array("in_entry_by"=>$this->session->userdata("uid"),"in_entry_on"=>date("Y-m-d H:i:s"),"in_time"=>date("Y-m-d H:i:s"));
		}
		else
		{
			if($_POST['shift']=="tour")
			{
				$outdate=array("visit_location"=>$_POST['visit'],"distance_from_campus"=>$_POST['distance'],"out_entry_by"=>$this->session->userdata("uid"),"out_entry_on"=>date("Y-m-d H:i:s"),"out_time"=>date("Y-m-d H:i:s"));
			}
			else
				$outdate=array("out_entry_by"=>$this->session->userdata("uid"),"out_entry_on"=>date("Y-m-d H:i:s"),"out_time"=>date("Y-m-d H:i:s"));
		}
			
		//echo var_dump($_POST);exit();
		
		$temp=array();
		$temp=array_merge($indate,$outdate);
		
		$fdate=date("Y-m-d", strtotime($_POST['tdate'])); 
		$insert_array=array("noofstudent"=>$_POST['nos'],"route_id"=>$_POST['rid_out'],"status"=>$_POST['checkp'],"bus_no"=>$_POST['bus'],"trip_date"=>$fdate,"trip_time"=>$_POST['time'],"trip_type"=>$_POST['shift'],"entry_ip"=>$_SERVER['REMOTE_ADDR']);
		//var_dump(array_merge($insert_array,$temp));exit();
        $last_inserted_id= $this->Transport_model->add_trip_entry(array_merge($insert_array,$temp));
		if($last_inserted_id)
			$this->session->set_flashdata('message1','Bus Trip Details Added Successfully.');
		else
			$this->session->set_flashdata('message2','Bus Trip Details Not Added Successfully.');
        redirect(base_url($this->view_dir.'trip_list_new'));
	}
	
	public function fee_details_excelReports()
	{
		$this->data['boardingfee_details']=$this->Transport_model->get_boarding_details_infeemaster($_POST);
		$this->load->view($this->view_dir.'boarding_fees_excel',$this->data);
	}
	
	public function trip_details_excelReports()
	{
		$this->data['route']=$_POST['routeexcel'];
		$this->data['bus']=$_POST['busexcel'];
		$this->data['odate']=$_POST['odateeexcel'];
		$this->data['fdate']=$_POST['fdateexcel'];
		$this->data['tdate']=$_POST['tdateexcel'];
		//echo var_dump($_POST);exit();
		$this->data['trip_details']=$this->Transport_model->get_bus_trip_details($this->data);
		$this->load->view($this->view_dir.'trip_excel',$this->data);
	}
	
	public function trip_details_pdfReports()
	{
		$this->data['route']=$_POST['routepdf'];
		$this->data['bus']=$_POST['buspdf'];
		$this->data['odate']=$_POST['odatepdf'];
		$this->data['fdate']=$_POST['fdatepdf'];
		$this->data['tdate']=$_POST['tdatepdf'];
		$this->data['trip_details'] = $this->Transport_model->get_bus_trip_details($this->data);
		//var_dump($_POST);exit();
		$this->load->library('m_pdf', $param);
		
		$html = $this->load->view($this->view_dir.'trip_pdf', $this->data, true);
		
		
		if($_POST['routeexcel']=='summary')
			$pdfFilePath = "Bus_Trip_".$_POST['routeexcel']."_details.pdf";
		else
			$pdfFilePath = "Bus_Trip_details.pdf";

		$this->m_pdf->pdf->WriteHTML($html);
		//download it.
		$this->m_pdf->pdf->Output($pdfFilePath, "D");
	}
	
	public function trip_details_pdfReports_new()
	{
		$this->data['route']=$_POST['routepdf'];
		$this->data['bus']=$_POST['buspdf'];
		$this->data['odate']=$_POST['odatepdf'];
		$this->data['fdate']=$_POST['fdatepdf'];
		$this->data['tdate']=$_POST['tdatepdf'];
		$this->data['trip_details'] = $this->Transport_model->get_bus_trip_details_new($this->data);
		//var_dump($_POST);exit();
		$this->load->library('m_pdf', $param);
		
		$html = $this->load->view($this->view_dir.'trip_pdf', $this->data, true);
		
		
		if($_POST['routeexcel']=='summary')
			$pdfFilePath = "Bus_Trip_".$_POST['routeexcel']."_details.pdf";
		else
			$pdfFilePath = "Bus_Trip_details.pdf";

		$this->m_pdf->pdf->WriteHTML($html);
		//download it.
		$this->m_pdf->pdf->Output($pdfFilePath, "D");
	}
	
	public function fee_details_pdfReports()
	{
		$this->data['boardingfee_details'] = $this->Transport_model->get_boarding_details_infeemaster($_POST);
		//var_dump($_POST);exit();
		$this->load->library('m_pdf', $param);
		
		$html = $this->load->view($this->view_dir.'boarding_fees_pdf', $this->data, true);
		$pdfFilePath = $_POST['academic']."_boarding_fees.pdf";

		$this->m_pdf->pdf->WriteHTML($html);
		//download it.
		$this->m_pdf->pdf->Output($pdfFilePath, "D");
	}
	
	public function edit_boarding_fee()
    {
		$id=$this->uri->segment(3);
        $this->load->view('header',$this->data);
		$this->data['boarding_fee_details']=array_shift($this->Transport_model->get_boardingfee_details_byid($id));
		$this->data['campus']=$this->uri->segment(4);
		$this->data['academic']=$this->uri->segment(5);
        $this->load->view($this->view_dir.'edit_boarding_fee',$this->data);
        $this->load->view('footer');
    }
	
	public function edit_boarding_fee_submit()
	{
		$id=$this->uri->segment(3);
		$update_array=array("fees"=>$_POST['fee'],"modified_by"=>$this->session->userdata("uid"),"modified_on"=>date("Y-m-d H:i:s")); 
		//var_dump($insert_array);exit();
        $last_inserted_id= $this->Transport_model->edit_boarding_fee_submit($id,$update_array);
		if($last_inserted_id)
			$this->session->set_flashdata('message1','Boarding Fee Details Updated Successfully.');
		else
			$this->session->set_flashdata('message2','Boarding Fee Details Not Updated Successfully.');
        redirect(base_url($this->view_dir.'edit_boarding_fee/'.$id.'/'.$this->uri->segment(4).'/'.$this->uri->segment(5)));
	}
	
	public function edit_all_boardingfee_details()
	{
		$this->load->view('header',$this->data);
		
        //var_dump($this->data['all_boarding_fee_details']);exit();
		$this->data['campus']=$this->uri->segment(3);
		$this->data['academic']=$this->uri->segment(4);
		$this->data['all_boarding_fee_details']=$this->Transport_model->get_boarding_details_infeemaster($this->data);
		$this->load->view($this->view_dir.'edit_all_boarding_fee_details',$this->data);
        $this->load->view('footer');
	}
	
	function search_transport_students()
    {
        $this->load->view('header',$this->data);    
      //$this->data['student_list']= $this->hostel_model->get_hstudent_list();  
        $this->data['academic_details']= $this->Transport_model->get_academic_details();	  
        $this->load->view($this->view_dir.'search_students',$this->data);
        $this->load->view('footer');
    }
	
	function load_transport_students()
    {
		//$this->load->view('header',$this->data);    
		//error_reporting(E_ALL);
		$this->data['student_list'] = $this->Transport_model->load_transport_students(); 
		//below two lines need to be uncomment for exist transport candidate.
		$this->data['installment'] = $this->Transport_model->student_paid_fees(); 
		$this->data['bank_details']= $this->Transport_model->getbanks();
		$this->data['boarding_details']=$this->Transport_model->get_boardingmaster_details();
		
		$this->data['boarding_details']=$this->Transport_model->get_boardingmaster_details();
		$this->data['route_details']=$this->Transport_model->get_route_details();
		
		$this->data['stud_details']['enrollment_no']= str_replace("_","/",$_POST['prn']);
		$this->data['stud_details']['org']=$_POST['org'];
		$this->data['stud_details']['academic_year']=$_POST['acyear'];
		$stud_faci_details= $this->Transport_model->get_std_fc_details_byid($this->data['stud_details']);
		$this->data['stud_faci_details']= $stud_faci_details;
		//echo $stud_faci_details[0]['student_id'];
		//exit;
		$this->data['Local_Address']= $this->Ums_admission_model->fetch_address_details($stud_faci_details[0]['student_id'],'STUDENT','CORS');
        $this->data['PERMNT_Address']= $this->Ums_admission_model->fetch_address_details($stud_faci_details[0]['student_id'],'STUDENT','PERMNT');
		//echo($std_details['stud_id']);exit;
		/*if(!empty($laddr)){
			$Local=$laddr;
		}else{
			$Local=array('Local'=>0);
		}
		
		if(!empty($paddr)){
			$PERMNT=$laddr;
		}else{
			$PERMNT=array('PERMNT'=>0);
		}*/
		
		
		
		$stdata = $this->load->view($this->view_dir.'student_data',$this->data);
		//$this->load->view('footer');
    }
	
	function facility_fee_details()
	{
		//var_dump($_POST);exit();
		$bpoint = $this->Transport_model->facility_fee_details($_POST['fcid'],$_POST['acyear'],$_POST['bpoint']);
		echo  json_encode($bpoint);
	}
	
	function Rpoint(){
		$Rpoint=$_REQUEST['Rpoint'];
		$data= $this->Transport_model->Rpoint($Rpoint);
		echo '<select class="form-control" name="bpoint" id="bpoint" required>
		<option value="">Boarding Point</option>';
		foreach($data as $list){
			 ?>
        <option value="<?=$list['board_id']?>"><?=$list['boarding_point']?></option>  
       <?php  } ?>
       </select>
                                  	<?php
	}
	
	function register_for_facility()
	{
	  //  echo "arvi";
	  //  exit();
	    $ac_year=$_POST['hidac_year'];
		$enrollment_no=$_POST['prn_no'];
		$org=$_POST['org_frm'];
		
		if(!empty($_FILES['exemfile']['name'])){
			$filenm=$_POST['prn_no'].'-'.$_POST['hidac_year'].'-'.$_FILES['exemfile']['name'];
			$config['upload_path'] = 'uploads/Transport/facility';
			$config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
			$config['overwrite']= TRUE;
			$config['max_size']= "2048000";
			//$config['file_name'] = $_FILES['profile_img']['name'];
			$config['file_name'] = $filenm;

			//Load upload library and initialize configuration
			$this->load->library('upload',$config);
			$this->upload->initialize($config);

			if($this->upload->do_upload('exemfile')){
				$uploadData = $this->upload->data();
				$exemfile = $uploadData['file_name'];
			}else{
				$exemfile = '';
			}
		}
		else{
			$exemfile = '';
		}
				
		$insert_array=array("student_id"=>$_POST['stud_id'],"enrollment_no"=>$_POST['prn_no'],
		"organisation"=>$_POST['org_frm'],"year"=>$_POST['c_year'],"academic_year"=>$_POST['hidac_year'],"admission_type"=>$_POST['admission_type'],
		"sffm_id"=>$_POST['hidfac_id'],"actual_fees"=>$_POST['actualfee'],"excemption_fees"=>$_POST['exem'],
		"excem_doc_path"=>$exemfile,"created_ip"=>$_SERVER['REMOTE_ADDR'],
		"created_by"=>$this->session->userdata("uid"),"created_on"=>date("Y-m-d H:i:s"),"status"=>"Y"); 
		//var_dump($insert_array);exit();
        $last_inserted_id= $this->Transport_model->register_for_facility($insert_array);
		
	    $boarding_insert_array=array("student_id"=>$_POST['stud_id'],"enrollment_no"=>$_POST['prn_no'],
		"sf_id"=>$last_inserted_id,"academic_year"=>$_POST['hidac_year'],"route_id"=>$_POST['Rpoint'],"allocated_id"=>$_POST['bpoint'],
		"sffm_id"=>$_POST['hidfac_id'],"created_ip"=>$_SERVER['REMOTE_ADDR'],
		"created_by"=>$this->session->userdata("uid"),"created_on"=>date("Y-m-d H:i:s"),"is_active"=>"Y");
		
		$last_inserted_id= $this->Transport_model->allocate_boardingpoint($boarding_insert_array);
		$this->session->set_flashdata('message1','Student registered for Transport Successfully.');
		
		if($this->session->userdata("role_id")==5){
		//redirect(base_url('hostel/download_challan_pdf/'.$last_inserted_id));
		//usleep(6000000);
		$this->session->set_flashdata('hostel_direct',$enrollment_no);
		redirect(base_url('Transport_Challan/add_fees_challan/'.$enrollment_no.'/'.$ac_year.'/'.$org));

		}else{
		redirect(base_url($this->view_dir.'student_list/'.$enrollment_no.'/'.$ac_year.'/'.$org));
		}
		
	}
	
	public function student_list($enrollment_no='', $ac_year='', $org='')
    {
        $this->load->view('header',$this->data);    
      //$this->data['student_list']=$this->Transport_model->get_hstudent_list(); 
		$this->data['academic_details']= $this->Transport_model->get_academic_details();	   
        $this->load->view($this->view_dir.'transport_student_list',$this->data);
        $this->load->view('footer');
    }
	
	function search_students_data()
	{
		$this->data['student_list'] = $this->Transport_model->search_students_data();     	
	   $stdata = $this->load->view($this->view_dir.'transport_allocated_list',$this->data);	
	}
	
	public function export_allocated()
	{
		$this->data['stud_details']['prn']= $_POST['arg_prn'];
		$this->data['stud_details']['institute']= $_POST['arg_institute'];
		$this->data['stud_details']['org']= $_POST['arg_org'];
		$this->data['stud_details']['acyear']= $_POST['arg_acyear'];
		$this->data['student_details'] = $this->Transport_model->allocated_list_export($this->data['stud_details']);
		//$this->data['student_details'] = $this->Transport_model->h_students_data($_POST);
		
		if(isset($_POST['btnPDF']))
		{
			$this->load->library('m_pdf', $param);
			$html = $this->load->view($this->view_dir.'transport_cancelled_pdf', $this->data, true);
			$pdfFilePath ="transport_allocated_student_list.pdf";

			$this->m_pdf->pdf->WriteHTML($html);
			//download it.
			$this->m_pdf->pdf->Output($pdfFilePath, "D");
		}
		else
		$this->load->view($this->view_dir.'student_list_excelreport',$this->data);
	}
	
	public function export_cancelled()
	{
		$this->data['stud_details']['prn']= $_POST['arg_prn1'];
		$this->data['stud_details']['institute']= $_POST['arg_institute1'];
		$this->data['stud_details']['org']= $_POST['arg_org1'];
		$this->data['stud_details']['acyear']= $_POST['arg_acyear1'];
		$this->data['stud_details']['cancel']= $_POST['cancel'];
		
		$this->data['student_details'] = $this->Transport_model->cancelled_list_export($this->data['stud_details']);
		//$this->data['student_details'] = $this->Transport_model->cancelled_list_export($_POST);
		if(isset($_POST['can_btn']))
		{
			$this->load->library('m_pdf', $param);
			$html = $this->load->view($this->view_dir.'transport_cancelled_pdf', $this->data, true);
			$pdfFilePath ="transport_cancelled_student_list.pdf";

			$this->m_pdf->pdf->WriteHTML($html);
			//download it.
			$this->m_pdf->pdf->Output($pdfFilePath, "D");
		}
		else
		$this->load->view($this->view_dir.'student_list_excelreport',$this->data);
	}
	
	public function student_facility_details()
	{
		$this->load->view('header',$this->data);    
		$this->data['boarding_details']=$this->Transport_model->get_boardingmaster_details();	
		$this->data['stud_details']['enrollment_no']= str_replace("_","/",$this->uri->segment(3));
		$this->data['stud_details']['org']=$this->uri->segment(5);
		$this->data['stud_details']['academic_year']=$this->uri->segment(6);
		
		$this->data['student_list']= array_shift($this->Transport_model->get_transportfee_details($this->data['stud_details']));
		$this->data['bank_details']= $this->Transport_model->getbanks();
		$this->data['installment']= $this->Transport_model->fetch_transportfee_details($this->data['stud_details']);
		
		$this->data['stud_faci_details']= $this->Transport_model->get_std_fc_details_byid($this->data['stud_details']);	
		
		$this->data['total_fees']= $this->Transport_model->total_fee_paid($this->data['stud_details']);
		$stdata = $this->load->view($this->view_dir.'student_transport_data',$this->data);
		
        $this->load->view('footer');
    }
	
	public function cancel_faci_submit()
	{
	   // exit(0);
		$last_inserted_id=$this->Transport_model->cancel_faci_submit($_POST);
		if($last_inserted_id)
		{
			$this->session->set_flashdata('message1','Transport facility cancelled Successfully.');
			redirect(base_url($this->view_dir.'student_list'));
		}
		else
		{
			$this->session->set_flashdata('message2','Transport facility not cancelled Successfully.');
			redirect(base_url($this->view_dir.'student_list'));
		}
	}
	
	public function boardingform_submit()
	{
	   // exit(0);
		$last_inserted_id=$this->Transport_model->boardingform_submit($_POST);
	
		if($last_inserted_id)
		{
			$this->session->set_flashdata('message1','Boarding facility changed Successfully.');
			redirect(base_url($this->view_dir.'student_facility_details/'.$_POST['benroll'].'/'.$_POST['bsf_id'].'/'.$_POST['borg'].'/'.$_POST['bacademic_year']));
		}
		else
		{
			$this->session->set_flashdata('message2','Boarding facility not changed Successfully.');
			redirect(base_url($this->view_dir.'student_facility_details/'.$_POST['benroll'].'/'.$_POST['bsf_id'].'/'.$_POST['borg'].'/'.$_POST['bacademic_year']));
		}
	}
	
	public function get_institutes_by_campus()
	{
	    echo $this->Transport_model->get_institutes_by_campus($_POST['campus']);
	}
	
	public function download_idcard_pdf()
	{
		$this->data['ids'] = $this->Transport_model->t_students_data($_POST);
		//var_dump($this->data['ids']);exit();
		$this->load->library('m_pdf', $param);
		
		$html = $this->load->view($this->view_dir.'student_icard', $this->data, true);
		$pdfFilePath = $_POST['arg_acyear']."_".$_POST['arg_org']."_hostel_id_card.pdf";

		$this->m_pdf->pdf->WriteHTML($html);
		//download it.
		$this->m_pdf->pdf->Output($pdfFilePath, "D"); 
	}
	
	function generate_id_card()
    {
        $this->load->view('header',$this->data);
		$this->data['academic_details']= $this->Transport_model->get_academic_details();	  
        $this->load->view($this->view_dir.'generate_transport_id',$this->data);
        $this->load->view('footer');
    }
	
	public function get_tstudents_data()
	{
		$student_list= $this->Transport_model->search_students_data();     	
	   //$stdata = $this->load->view($this->view_dir.'h_applied_list',$this->data);
	    if(count($student_list)>0)
		{
			$j=1;
			
		   foreach($student_list as $emp_list){
			echo '<tr>
				<td class="noExl"><input type="checkbox" name="chk_stud[]" id="chk_stud" class="checkBoxClass" value="'.$emp_list['sf_id'].'"></td>
				<td>'.$j.'</td><td>'.$emp_list['organisation'].'</td> 
				<td>'.$emp_list['school_name'].'</td> 
				<td>'.$emp_list['enrollment_no'].'</td> 
				<td>'.$emp_list['first_name']." ".$emp_list['middle_name']." ".$emp_list['last_name'].'</td>
				<td>'.$emp_list['stream_name'].'</td>
				<!--<td>
				<a class="btn btn-info btn-xs" href="'.base_url()."Transport/download_idcard_pdf/".$emp_list['academic_year']."/".$emp_list['organisation']."/".$emp_list['school_name']."/".str_replace("/","_",$emp_list['sf_id'])."".'" title="View" target="_blank"><i class="fa fa-file-pdf-o" aria-hidden="true" style="font-size:20px; color:red;"> </i></a>
				</td>-->
				</tr>';
		
				$j++;
			}
			
		}
		else
				echo "<span style=\"color:red;\">Records Not Found Please change search criteria and try again</span>";
	}
	
	public function view_std_payment()
	{
		$sf_std_id=$this->uri->segment(3);
		$this->data['stud_details']['enrollment_no']= str_replace("_","/",$this->uri->segment(3));//$this->uri->segment(3);
		$this->data['stud_details']['student_id']=$this->uri->segment(4);
		$this->data['stud_details']['org']=$this->uri->segment(5);
		$this->data['stud_details']['academic_year']=$this->uri->segment(6);
		$this->load->view('header',$this->data); 
		//echo "<pre>";
		//print_r($this->data['stud_details']);exit;
       $this->data['academic_details']= $this->Transport_model->get_academic_details();
		$this->data['student_details']= array_shift($this->Transport_model->get_transportfee_details($this->data['stud_details']));
		$this->data['bank_details']= $this->Transport_model->getbanks();
		$this->data['installment']= $this->Transport_model->fetch_transportfee_details($this->data['stud_details']);
		
		$this->data['total_fees']= $this->Transport_model->total_fee_paid($this->data['stud_details']);
		
		$this->data['stud_faci_details']= $this->Transport_model->get_std_fc_details_byid($this->data['stud_details']);	
		//exit();
		$this->data['canc']= $this->Transport_model->get_student_canc($this->data['stud_details']['enrollment_no']);
		$this->load->view($this->view_dir.'view_std_payment',$this->data);
        $this->load->view('footer');
	}
		// insert Payment installment
	public function pay_Installment()
    {
		//print_r($_FILES);exit;
        $stud_id= $_POST['stud_id'];
		$enroll= $_POST['enrollment_no'];
		$org= $_POST['org'];
		$academic= $_POST['acyear'];
		
		$no_of_installment =1+$_POST['no_of_installment'];
		if(!empty($_FILES['payfile']['name'])){
			$filenm=$stud_id.'-'.$no_of_installment.'-'.$_FILES['payfile']['name'];
			$config['upload_path'] = 'uploads/transport/student_challans/';
			$config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
			$config['overwrite']= TRUE;
			$config['max_size']= "2048000";
			//$config['file_name'] = $_FILES['profile_img']['name'];
			$config['file_name'] = $filenm;

			//Load upload library and initialize configuration
			$this->load->library('upload',$config);
			$this->upload->initialize($config);

			if($this->upload->do_upload('payfile')){
				$uploadData = $this->upload->data();
				$payfile = $uploadData['file_name'];
			}else{
				$payfile = '';
			}
		}
		else{
			$payfile = '';
		}
		
		//echo "calling";exit();
        $last_inserted_id= $this->Transport_model->pay_Installment($_POST,$payfile );
		if($last_inserted_id)
		{
			$this->session->set_flashdata('message1','Fee Details Added Successfully.');
			redirect(base_url($this->view_dir."view_std_payment/".$enroll."/".$stud_id."/".$org."/".$academic));
		}
		else
		{
			$this->session->set_flashdata('message2','Fee Details Not Added Successfully.');
			redirect(base_url($this->view_dir."view_std_payment/".$enroll."/".$stud_id."/".$org."/".$academic));
		}
        //redirect('Hostel/view_std_payment/'.$stud_id);
    }
	
	public function updatePayment()
	{
		$stud_id= $_POST['student_id'];
		$enroll= $_POST['enrollment_no'];
		$org= $_POST['org'];
		
    	$sf_id =$_POST['fstud_id'];
    	$data['actual_fees'] =$_POST['fdeposite'];   
    	$data['excemption_fees'] =$_POST['exem'];  
    	$data['concession_fees'] =$_POST['concession'];   
    	if(!empty($_FILES['exemfile']['name'])){
    	    $newfilename= date('dmYHis').str_replace(" ", "", basename($_FILES["exemfile"]["name"]));
    	$data['excem_doc_path'] = $newfilename;
    	}
		if(!empty($_FILES['concefile']['name'])){
    	    $newfilename1= date('dmYHis').str_replace(" ", "", basename($_FILES["concefile"]["name"]));
    	$data['conce_doc_path'] = $newfilename1;
    	}
    	$data['modified_by']=$_SESSION['uid'];
		$data['modified_on']=date("Y-m-d H:i:s");
		$data['modified_ip']=$_SERVER['REMOTE_ADDR'];
		
		$this->data['indet']= $this->Transport_model->updatePayment($sf_id, $data);
		if(!empty($_FILES['exemfile']['name'])) {
            if(is_uploaded_file($_FILES['exemfile']['tmp_name'])) {
                $sourcePath = $_FILES['exemfile']['tmp_name'];
                $targetPath = "uploads/Transport/exepmted_fees/".$newfilename;
                if(move_uploaded_file($sourcePath,$targetPath)) {
                
                }
            }
        }
		if(!empty($_FILES['concefile']['name'])) {
            if(is_uploaded_file($_FILES['concefile']['tmp_name'])) {
                $sourcePath1 = $_FILES['concefile']['tmp_name'];
                $targetPath1 = "uploads/Transport/concession_fees/".$newfilename1;
                if(move_uploaded_file($sourcePath1,$targetPath1)) {
                
                }
            }
        }
       $this->session->set_flashdata('message1','Transport Fee Details Updated Successfully!!.');
		redirect(base_url("Transport/view_std_payment/".$enroll."/".$stud_id."/".$org."/".$_POST['academic_y']));
	}
	
	public function edit_fdetails()
	{
		$this->data['stud_details']['enrollment_no']=$_POST['enroll'];
		$this->data['stud_details']['student_id']=$_POST['stdid'];
		$this->data['stud_details']['org']=$_POST['org'];
		$feeid =$_POST['feeid'];
		$this->data['academic_details']= $this->Transport_model->get_academic_details();
		$this->data['bank_details']= $this->Transport_model->getbanks();
		$this->data['indet']= $this->Transport_model->fetch_transportfee_details_byfid($feeid);
		$this->load->view($this->view_dir.'edit_fee',$this->data);
	}
	
	public function update_inst($stud_id)
	{
		$stud_id= $_POST['student_id'];
		$enroll= $_POST['enrollment_no'];
		$org= $_POST['org'];
		date_default_timezone_set('Asia/Kolkata');
        $stud_id= $_POST['sid'];
		if(!empty($_FILES['epayfile']['name'])){
			$filenm=$stud_id.'-'.time().'-'.$_FILES['epayfile']['name'];
			$config['upload_path'] = 'uploads/Transport/student_challans/';
			$config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
			$config['overwrite']= TRUE;
			$config['max_size']= "2048000";
			$config['file_name'] = $filenm;

			//Load upload library and initialize configuration
			$this->load->library('upload',$config);
			$this->upload->initialize($config);

			if($this->upload->do_upload('epayfile')){
				$uploadData = $this->upload->data();
				$payfile = $uploadData['file_name'];
			}else{
				$payfile = '';
			}
		}
		else{
			$payfile = '';
		}
        $this->Transport_model->update_fee_det($_POST,$payfile );
        //redirect('ums_admission/viewPayments/'.$stud_id);
		$this->session->set_flashdata('message1','Transport Fee Details Updated Successfully.');
		redirect(base_url($this->view_dir."view_std_payment/".$enroll."/".$stud_id."/".$org."/".$_POST['acyear']));
	}
	
	public function delete_fees()
	{
	    $this->Transport_model->delete_fees($_POST);  
	}
	// insert Refund_payment installment
	public function Refund_payment()
    {
		//print_r($_FILES);exit;
        $stud_id= $_POST['rstud_id'];
		$enroll= $_POST['renrollment_no'];
		$org= $_POST['rorg'];
		$acyear= $_POST['racyear'];
		$no_of_installment =1;
		if(!empty($_FILES['rpayfile']['name'])){
			$filenm=$stud_id.'-'.$no_of_installment.'-'.$_FILES['rpayfile']['name'];
			$config['upload_path'] = 'uploads/student_challans/';
			$config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
			$config['overwrite']= TRUE;
			$config['max_size']= "2048000";
			//$config['file_name'] = $_FILES['profile_img']['name'];
			$config['file_name'] = $filenm;

			//Load upload library and initialize configuration
			$this->load->library('upload',$config);
			$this->upload->initialize($config);

			if($this->upload->do_upload('rpayfile')){
				$uploadData = $this->upload->data();
				$payfile = $uploadData['file_name'];
			}else{
				$payfile = '';
			}
		}
		else{
			$payfile = '';
		}
		
		//echo "calling";exit();
        $last_inserted_id= $this->Transport_model->Refund_payment($_POST,$payfile );
		if($last_inserted_id)
		{
			$this->session->set_flashdata('message1','Refund Fee Details Added Successfully.');
			redirect(base_url($this->view_dir."view_std_payment/".str_replace("/","_",$enroll)."/".$stud_id."/".$org."/".$acyear));
		}
		else
		{
			$this->session->set_flashdata('message2','Refund Fee Details Not Added Successfully.');
			redirect(base_url($this->view_dir."view_std_payment/".str_replace("/","_",$enroll)."/".$stud_id."/".$org."/".$acyear));
		}
        //redirect('Hostel/view_std_payment/'.$stud_id);
    }	
}
?>