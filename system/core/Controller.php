<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2015, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (http://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2015, British Columbia Institute of Technology (http://bcit.ca/)
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	http://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Application Controller Class
 *
 * This class object is the super class that every library in
 * CodeIgniter will be assigned to.
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		EllisLab Dev Team
 * @link		http://codeigniter.com/user_guide/general/controllers.html
 */
class CI_Controller {

	/**
	 * Reference to the CI singleton
	 *
	 * @var	object
	 */
	private static $instance;
    public $model_obj;
    public $data=array();
	/**
	 * Class constructor
	 *
	 * @return	void
	 */
	public function __construct()
	{
			  
		self::$instance =& $this;                
        include_once(APPPATH."includes/Global.php");
        global $menudata,$sessionArray;
		// Assign all the class objects that were instantiated by the
		// bootstrap file (CodeIgniter.php) to local class variables
		// so that CI can run as one big super object.
		foreach (is_loaded() as $var => $class)
		{
			$this->$var =& load_class($class);
		}		
		$this->load =& load_class('Loader', 'core');
		$this->load->initialize();
		log_message('info', 'Controller Class Initialized');                
              
                /*Added By Shreenivas starts here */
				$menu_name = $this->uri->segment(1);
				$method_name = $this->uri->segment(2);
				$is_qr_view = ($menu_name == 'Letter' && $method_name == 'generate_package_pdf' && $this->input->get('mode') == 'view');
                
				
					if ($is_qr_view) {
					return; // Skip all session and menu checks for QR view
					}
                 
                 if($this->uri->segment(2)!=''){
                     $menu_link=$this->uri->segment(1).'/'.$this->uri->segment(2);//By Arvind
					 $menum=$this->uri->segment(1).'/';
                 }
                 else{
                     $menu_link=$this->uri->segment(1);
					 $menum=$menu_link;
                 }
				 //echo $this->uri->segment(2);
				 $this->check_user_access_login($this->uri->segment(1));
               // echo $menu_name."@@"; die; 
                if($menu_name!="login" && $menu_name!="" && $menu_name!="Erp_cron" && $menu_name !="Erp_cron_attendance" && $menu_name !="Userprofile" && $menu_name !="Notifications" && $menu_name !="Upload" && $menu_name !="Practical" && $menu_name !="Api1" && $menu_name !="SyllabusController" && $menu_name !="Course_outcomes" && $menu_name !="lecture_plan" && $menu_name !="course_outcomes" && $menu_name !="assignment_question_bank" && $menu_name !="Assignment_question_bank" && $menu_name !="finance" && $menu_name !="Feesummary")
					//&& $menu_name !="student_attendance"
					
                {                     
                    
                    $this->data['menu_privileges']=$this->retrieve_privileges($menu_name);
                    $this->data['my_menu_details']=$this->get_menu_details();  
                     
                   //added by arvind
                   $url=$_SERVER['REQUEST_URI']; 
                   if($url)
                   {
                       $this->save_user_history($url);
                   }
                }
                /*Added By Shreenivas starts here */
                
	}

	// --------------------------------------------------------------------

	/**
	 * Get the CI singleton
	 *
	 * @static
	 * @return	object
	 */
	public static function &get_instance()
	{
		return self::$instance;
	}
	
        public function retrieve_privileges($menu_name)
        {
            
            $this->load->database();                   
            $sql="  SELECT pm.privileges_name
                    FROM role_menu_reln rmr
                    INNER JOIN menu_master mm on rmr.menu_id=mm.menu_id
                    INNER JOIN privileges_master pm on pm.privileges_id=rmr.privileges_id
                    WHERE rmr.status='Y'  AND mm.status='Y' AND rmr.menu_id=(select menu_id from menu_master where path='".$menu_name."' LIMIT 1)
                    AND pm.status='Y' AND rmr.roles_id='".$this->session->userdata("role_id")."'";
           //echo $sql; die;
            $query = $this->db->query($sql);
            $array=$query->result_array();
            $array2=array();
            for($i=0;$i<count($array);$i++)
            {
                $array2[]=$array[$i]['privileges_name'];
            }
            return $array2;
            
         }

        function  get_menu_details()
        {
     $controller = $this->uri->segment(1);
    $method = $this->uri->segment(2);
    $is_qr_view = ($controller == 'Letter' && $method == 'generate_package_pdf' && $this->input->get('mode') == 'view');
  if ($is_qr_view) {
        return []; // No session or role validation
    }
if($this->uri->segment(1)=="erp_cron_attendance" || $this->uri->segment(1)=="Forgot_password" || $this->uri->segment(1)=="Mail_attendance" || $this->uri->segment(1)=="mail_attendance")
{
	
}
else
{
            
            
           
            
            if(($_REQUEST['hash']!='')&&($_REQUEST['productinfo']!='online_transporation_new'))
            {
            $this->session->userdata['role_id'] =4;
            $this->session->userdata['name'] =$_REQUEST['udf3'];//$this->session->userdata['name'];//$_SESSION['name'];//$_REQUEST['udf3'];
            }
			 if(($_REQUEST['productinfo']=='online_transporation_new')){
            $this->session->userdata['role_id'] =4;
            $this->session->userdata['name'] = $this->session->userdata['name'];//$this->session->userdata['name'];//$_SESSION['name'];//$_REQUEST['udf3'];
            }
			
           if($_REQUEST['encResp']!='')
            {
				//print_r($this->session->all_userdata());
				 $this->session->userdata['name'];
				//echo $_SESSION['name'];;
				//print_r($_REQUEST);
				//exit();
           // $this->session->userdata['role_id'] =4;
           // $this->session->userdata['name'] =$this->session->userdata['name'];
            }
            if((!isset($this->session->userdata['role_id'])))//&&($this->uri->segment(2)!="payment_handler_success")
   {

	 echo "Your Session Has expired Please <a href='https://onlineerp.sandipuniversity.com/'>login again</a>";
    exit(0);

  }
            $where=" WHERE status='Y' AND parent='0' ";  
            $sql="SELECT rmr.menu_id,mm.menu_id,mm.menu_name,mm.path,mm.icon,mm.parent,mm.seq,mm.status
                                FROM role_menu_reln rmr
                                INNER JOIN roles_master rm on rmr.roles_id=rm.roles_id
                                INNER JOIN menu_master mm on mm.menu_id=rmr.menu_id
                                WHERE rmr.status='Y' AND rm.status='Y' AND mm.status='Y' AND mm.parent='0' AND rm.roles_id=".$this->session->userdata['role_id']."
                                GROUP BY mm.menu_name
                                ORDER BY mm.parent,mm.seq";        

            $query = $this->db->query($sql);
            $return_array=array();                        
            $return_array["level_0"]= $query->result_array();        
            for($i=0;$i<count($return_array["level_0"]);$i++)
            {

                $sql2="SELECT rmr.menu_id,mm.menu_id,mm.menu_name,mm.path,mm.icon,mm.parent,mm.seq,mm.status
                                FROM role_menu_reln rmr
                                INNER JOIN roles_master rm on rmr.roles_id=rm.roles_id
                                INNER JOIN menu_master mm on mm.menu_id=rmr.menu_id
                      WHERE rmr.status='Y' AND rm.status='Y' AND mm.status='Y' AND mm.parent='".$return_array["level_0"][$i]['menu_id']."' AND rm.roles_id=".$this->session->userdata['role_id']."
                                GROUP BY mm.menu_name
                                ORDER BY mm.parent,mm.seq";

                $query2 = $this->db->query($sql2);

                if(count($query2->result_array())>0)
                {
                    $return_array["level_1"][$return_array["level_0"][$i]['menu_id']]= $query2->result_array();     
                }

            }                
            return $return_array;
            
            
        }
        }
        
         function check_user_access($menu){
          // echo $menu;
             $sql="  SELECT pm.privileges_name
                    FROM role_menu_reln rmr
                    INNER JOIN menu_master mm on rmr.menu_id=mm.menu_id
                    INNER JOIN privileges_master pm on pm.privileges_id=rmr.privileges_id
                    WHERE rmr.status='Y'  AND mm.status='Y' AND rmr.menu_id=(select menu_id from menu_master where path='".$menu."' LIMIT 1)
                    AND pm.status='Y' AND rmr.roles_id='".$this->session->userdata("role_id")."'";
            $query =$this->db->query($sql);
            $arr=$query->result_array();
            if(count($arr)==0){
              redirect('login');
            }
            else{
                return '1';
            }
           
        }
		
		 function check_user_access_login($menu_link){
          
		  // $menu=$menu_link.'/';
		  /*if(empty($this->session->userdata("role_id"))){
			   echo 'NO'.$this->session->userdata("role_id");
		  }elseif(!empty($this->session->userdata("role_id"))&&($menu_link!="home")){
			     'YES'.$this->session->userdata("role_id");
			     'YES'.$this->session->userdata("name");
				 'YES'.$this->session->userdata("uid");
				 $countt=0;*/
				 if(($this->session->userdata('role_id')=="4")&&($menu_link=="Challan")){
			 /* $sql="  SELECT pm.privileges_name
                    FROM role_menu_reln rmr
                    INNER JOIN menu_master mm on rmr.menu_id=mm.menu_id
                    INNER JOIN privileges_master pm on pm.privileges_id=rmr.privileges_id
                    WHERE rmr.status='Y'  AND mm.status='Y' AND rmr.menu_id=(select menu_id from menu_master where path LIKE '%$menu_link%' LIMIT 1)
                    AND pm.status='Y' AND rmr.roles_id='".$this->session->userdata("role_id")."'";
            $query =$this->db->query($sql);
             $arr=$query->result_array();
			  $countt=count($arr);
            if($countt==0){
				//$this->session->sess_destroy();
				//$this->session->set_flashdata('msg', 'Do not To this Again');
            echo 'e-e';

              redirect('login/index/student');
            }else{
             //  return '1';
            }*/
			$this->session->sess_destroy();
			$this->session->set_flashdata('msgg', 'Do not To this Again');
			redirect('login/index/student');
		 }
		  if(($this->session->userdata('role_id')=="4")&&($this->uri->segment(2)=="Challan")){
			  
			  $this->session->sess_destroy();
			$this->session->set_flashdata('msgg', 'Do not To this Again');
			redirect('login/index/student');
		  }
		// if($this->session->userdata('role_id')==2){echo 'stud';}
		
	
		  if(($this->session->userdata('role_id')=="4")&&($this->uri->segment(2)=="bonafied_list"||$this->uri->segment(2)=="add_bonafied"||$this->uri->segment(2)=="regenerate_bonafide")){
	     	$this->session->sess_destroy();
			$this->session->set_flashdata('msgg', 'Do not To this Again');
			redirect('login/index/student');
		 }
		 
		 if(($this->session->userdata('role_id')=="4")&&($this->uri->segment(2)=="migration_certificate"||$this->uri->segment(2)=="add_migration_cert")){
	     	$this->session->sess_destroy();
			$this->session->set_flashdata('msgg', 'Do not To this Again');
			redirect('login/index/student');
		 }
		 
		 if(($this->session->userdata('role_id')=="4")&&($this->uri->segment(2)=="transfer_certificate"||$this->uri->segment(2)=="add_transfer_cert"||$this->uri->segment(2)=="regenerate_transfer_cert")){
			  
			  $this->session->sess_destroy();
			$this->session->set_flashdata('msgg', 'Do not To this Again');
			redirect('login/index/student');
		  }
		 
		 //////////////////////////////////////////////////////////////////////////////////////////////////////
		  if(($this->session->userdata('role_id')=="9")&&($menu_link=="Challan")){
			 /* $sql="  SELECT pm.privileges_name
                    FROM role_menu_reln rmr
                    INNER JOIN menu_master mm on rmr.menu_id=mm.menu_id
                    INNER JOIN privileges_master pm on pm.privileges_id=rmr.privileges_id
                    WHERE rmr.status='Y'  AND mm.status='Y' AND rmr.menu_id=(select menu_id from menu_master where path LIKE '%$menu_link%' LIMIT 1)
                    AND pm.status='Y' AND rmr.roles_id='".$this->session->userdata("role_id")."'";
            $query =$this->db->query($sql);
             $arr=$query->result_array();
			  $countt=count($arr);
            if($countt==0){
				//$this->session->sess_destroy();
				//$this->session->set_flashdata('msg', 'Do not To this Again');
            echo 'e-e';

              redirect('login/index/student');
            }else{
             //  return '1';
            }*/
			$this->session->sess_destroy();
			$this->session->set_flashdata('msgg', 'Do not To this Again');
			redirect('login/index/student');
		 }
		  if(($this->session->userdata('role_id')=="9")&&($this->uri->segment(2)=="Challan")){
			  
			  $this->session->sess_destroy();
			$this->session->set_flashdata('msgg', 'Do not To this Again');
			redirect('login/index/student');
		  }
		 // }
		  /* if(($menu_link=="login")){
             
			
		   }*/
           
        }
		
		
        function save_user_history($url){
             $dat['username']=$this->session->userdata("name");;
             $dat['role_id']=$this->session->userdata("role_id");
             $dat['logintime']=date('Y-m-d H:i:s');
             $dat['ip_address']=$_SERVER['REMOTE_ADDR'];
             $dat['user_agent']=$_SERVER['HTTP_USER_AGENT'];
             $dat['url']=$url;
           // '$_SERVER['REQUEST_URI'];
             $this->db->insert('user_view_history',$dat);
    
}


}
