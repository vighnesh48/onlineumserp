<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Menu_privileges_reln extends CI_Controller 
{
    var $currentModule="";
    var $title="";
    var $table_name="menu_privileges_reln";
    var $model_name="menu_privileges_reln_model";
    var $model;
    var $view_dir='Menu_privileges_reln/';
    
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
		if($this->session->userdata("role_id")==6){
		}else{
			redirect('home');
		}
    }
    
    public function index() 
    {
        $this->load->view('header',$this->data);                            
        $this->data['mapping_details']= $this->menu_privileges_reln_model->get_mapping_details();                                        
        $this->load->view($this->view_dir.'view',$this->data);
        $this->load->view('footer');
    }
    
    public function add()
    {
        $this->load->view('header',$this->data);        
        $this->data['privileges_details']= $this->menu_privileges_reln_model->get_privileges_details();                                
        $this->data['menu_details']= $this->menu_privileges_reln_model->get_menu_details();                                        
        $this->load->view($this->view_dir.'add',$this->data);
        $this->load->view('footer');
    }
    
    public function view()
    {
       $this->load->view('header',$this->data);                    
        $this->data['mapping_details']= $this->menu_privileges_reln_model->get_mapping_details();                                        
        $this->load->view($this->view_dir.'view',$this->data);
        $this->load->view('footer');
    }
    
    public function edit()
    {
        $this->load->view('header',$this->data);                
        $mapping_id=$this->uri->segment(3);
        $this->data['mapping_details']=$this->menu_privileges_reln_model->get_mapping_details2($mapping_id);                                    
        $this->load->view($this->view_dir.'edit',$this->data);
        $this->load->view('footer');
    }    
    
    public function disable()
    {
        $this->load->view('header',$this->data);                
        $menu_id=$this->uri->segment(3);   
        $update_array=array("status"=>"N","updated_by"=>  $this->session->userdata('uid'));                                
        $where=array("menu_id"=>$menu_id);
        $this->db->where($where);
        
        if($this->db->update($this->table_name, $update_array))
        {
            redirect(base_url($this->view_dir."view?error=0"));
        }
        else
        {
            redirect(base_url($this->view_dir."view?error=1"));
        }  
        $this->load->view('footer');
    }
    
    public function enable()
    {        
        $this->load->view('header',$this->data);                
        $menu_id=$this->uri->segment(3);   
        $update_array=array("status"=>"Y","updated_by"=>  $this->session->userdata('uid'));                                
        $where=array("menu_id"=>$menu_id);
        $this->db->where($where);
        
        if($this->db->update($this->table_name, $update_array))
        {
            redirect(base_url($this->view_dir."view?error=0"));
        }
        else
        {
            redirect(base_url($this->view_dir."view?error=1"));
        }  
        $this->load->view('footer');
    }
    
    public function submit()
    {               
        $post_array=$this->input->post();
        
        if((isset($post_array['action']))&&($post_array['action']=="add"))
        {
            $post_array=$post_array['prev'];
            $insert_array=array();        
            $i=0;
            foreach($post_array as $key=>$array)
            {
                for($j=0;$j<count($array);$j++)
                {
                    $insert_array[$i]["menu_id"]=$key;
                    $insert_array[$i]["privileges_id"]=$array[$j];
                    $insert_array[$i]["inserted_by"]=  $this->session->userdata('uid');            
                    $insert_array[$i]["inserted_datetime"]=date("Y-m-d H:i:s");    
                    $i++;                
                }
                $this->db->where('menu_id', $key);
                $this->db->delete("menu_privileges_reln");
            }        

            $cnt= $this->db->insert_batch("menu_privileges_reln", $insert_array);
            if($cnt)
            {
                redirect(base_url(strtolower($this->view_dir)."view?error=0"));
            }
            else
            {
                redirect(base_url(strtolower($this->view_dir)."view?error=1"));
            }
        }
        elseif((isset($post_array['action']))&&($post_array['action']=="edit"))
        {
            $post_array=$post_array['prev'];
            $insert_array=array();        
            $i=0;
            $privileges_details= $this->menu_privileges_reln_model->get_privileges_details(); 
            
            $privileges_details2 =array();
            for($i=0;$i<count($privileges_details);$i++)
            {
                $privileges_details2[]=$privileges_details[$i]['privileges_id'];
            }
            $found=array();
            foreach($post_array as $key1=>$array)
            {
                foreach($array as $key2=>$val)
                {
                    $found[$key1][]=$val;
                    //echo "$key1.===> $key2==>$val"."<br>";
                    $update_array[$i]["menu_id"]=$key1;
                    $update_array[$i]["privileges_id"]=$val;
                    $update_array[$i]["inserted_by"]=  $this->session->userdata('uid');            
                    $update_array[$i]["inserted_datetime"]=date("Y-m-d H:i:s");
                    $update_array[$i]["status"]="Y";                    
                    $i++; 
                }
            }        
            
            $menu_id=$key1;
            $update_cnt=count($update_array);
            $str="";
            
            for($i=0;$i<count($found[$menu_id]);$i++)
            {                
                $str.=$found[$menu_id][$i].",";
            }
            $str=  rtrim($str,",");
            $new_array=$this->menu_privileges_reln_model->get_not_found_rows($str,$menu_id);
            //echo "<pre>"; 
            for($j=0;$j<count($new_array);$j++)
            {
                $update_array[$update_cnt]['menu_id']=$new_array[$j]['menu_id'];
                $update_array[$update_cnt]['privileges_id']=$new_array[$j]['privileges_id'];
                $update_array[$update_cnt]['status']='N';                
                $update_array[$update_cnt]["inserted_by"]=  $this->session->userdata('uid');            
                $update_array[$update_cnt]["inserted_datetime"]=date("Y-m-d H:i:s");
            }
            
            //echo "<pre>";print_r($update_array); die;
            $this->db->where('menu_id', $menu_id);
            $this->db->delete("menu_privileges_reln");
            
            $cnt= $this->db->insert_batch("menu_privileges_reln", $update_array);
            if($cnt)
            {
                redirect(base_url(strtolower($this->view_dir)."view?error=0"));
            }
            else
            {
                redirect(base_url(strtolower($this->view_dir)."view?error=1"));
            }
            
           // print_r($update_array);
//            
//            for($i=0;$i<count($update_array);$i++)
//            {
//                
//                $this->db->where('mpr_id',)
//            }
        }        
    }  
    
    public function search()
    {           
        $para=$this->input->post("title");        
        $mapping_details=  $this->menu_privileges_reln_model->get_mapping_details($para);                    
        echo json_encode(array("mapping_details"=>$mapping_details));
    } 
}
?>