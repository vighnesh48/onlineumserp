<?php
class Login_model extends CI_Model 
{ 
    function __construct()
    {        
        parent::__construct();     
		$this->load->library('Password');								 
       // $this->currentModule=$this->uri->segment(1);        
    } 
    function get_user($user='',$pass='',$role_id='',$uttype='')
    {
		$isValidPassword = False;
		$getCon = null;
		//echo $user;
		//echo $uttype;die(); 
        if($uttype=='student' || $uttype=='parent')
        {
				   
			
			if($uttype=='student')
			{
			$role_id=4;	
			}
			if($uttype=='parent')
			{
				$role_id=9;	
			}
						   
			
			// echo "user".$user;
			// echo "role".$role;
			$sql = ("SELECT * FROM onlineadmission_ums.user_master WHERE username=?  AND roles_id = ?");
								   
			$getUser = $this->db->query($sql, array($user, $role_id));
   
			//echo "SELECT * FROM onlineadmission_ums.user_master WHERE username='".($user)."' AND password='".($pass)."' and roles_id = '".$role_id."'";
			//exit(0);
			$userRes = $getUser->result_array();
			$isPasswordReset = $userRes[0]['is_password_reset'];
			$dbpassword = $userRes[0]['password'];
			if($isPasswordReset){
				$isValidPassword = $this->password->is_valid_password($pass, $dbpassword);
				$getCon=$getUser;
			}else{
				$sql = ("SELECT * FROM onlineadmission_ums.user_master WHERE username=? AND password=? and roles_id = ?");
				$getCon=$this->db->query($sql, array($user, $pass, $role_id));
				
				if($getCon){
					$isValidPassword = True;
				}	
			}

        }
        else
        {
            //	$role_id=9;	
            // echo "user".$user;
        	$sql = ("SELECT * FROM  user_master WHERE username=? ");
			$getUser = $this->db->query($sql, array($user));
			if($user=='sunerp'){
				//echo "SELECT * FROM onlineadmission_ums.user_master WHERE username='".($user)."' AND password='".($pass)."'";
			//exit(0);
			}
			//echo "SELECT * FROM onlineadmission_ums.user_master WHERE username='".($user)."' AND password='".($pass)."' and roles_id = '".$role_id."'";
			//exit(0);
			$userRes = $getUser->result_array();
			$isPasswordReset = (int)$userRes[0]['is_password_reset'];
			$dbpassword = $userRes[0]['password'];
			//var_dump($isPasswordReset);die();
			if($isPasswordReset){
				$isValidPassword = $this->password->is_valid_password($pass, $dbpassword);
				//var_dump($isValidPassword);die();
				if($isValidPassword){
					$sql=("SELECT * FROM user_master WHERE username=? ");
					$getCon=$this->db->query($sql, array($user));	
				}
			}else{
				$sql=("SELECT * FROM user_master WHERE username=? AND password=? ");
																			   
				$getCon=$this->db->query($sql, array($user, $pass));
				
				if($getCon){
					$isValidPassword = True;
				}
			}
			//var_dump($isValidPassword);die();
         // $sql=("SELECT * FROM user_master WHERE username=? AND password=? ");
		// 	//'".()."' ".($pass)."' $role_id
		// 	 $getCon=$this->db->query($sql, array($user, $pass));
		   
        }
    	date_default_timezone_set('Asia/Kolkata');
        if($isValidPassword){
            $conRes = $getCon->result_array();
			//echo $getCon->last_query();
            //echo "print";
            //var_dump($conRes);die();
            $dat['username']=$user;
            //  $dat['role_id']=$conRes[0]['roles_id'];
             if($conRes[0]['roles_id']!='')
             {
             $dat['role_id']=$conRes[0]['roles_id'];
             }
             else
             {
               $dat['role_id']=$role_id;   
             }
             $dat['logintime']=date('Y-m-d H:i:s');
             $dat['ip_address']=$_SERVER['REMOTE_ADDR'];
             $dat['user_agent']=$_SERVER['HTTP_USER_AGENT'];
             $dat['is_password_reset'] = $conRes[0]['is_password_reset'];
             if($conRes[0]['username']!='')
             {
               $dat['login_status']='Y';   
             }
             else
             {
               $dat['login_status']='N';   
             }             
			 
			 
			 
             $this->db->insert('user_login_history',$dat);
             return $conRes;
        }
        else{
           //print_r($this->db->error());
           
            $dat['username']=$user;
            //$dat['role_id']=$conRes[0]['roles_id'];
            $dat['logintime']=date('Y-m-d h:i:s');
            $dat['ip_address']=$_SERVER['REMOTE_ADDR'];
            $dat['user_agent']=$_SERVER['HTTP_USER_AGENT'];
            $dat['login_status']='N';
            $this->db->insert('user_login_history',$dat);
		  
        }
        
    }
    
    
    function get_user_stream()
    {
        	$DB1 = $this->load->database('umsdb', TRUE);
        	$DB1->select("admission_stream");
        	$DB1->from("student_master");
        	$DB1->where("enrollment_no",$_SESSION['name']);
        			$query=$DB1->get();
	  // echo $DB1->last_query();exit;
			return $query->row_array();
        
    }
 	 function get_student($user)
    {
        	$DB1 = $this->load->database('umsdb', TRUE);
        	$DB1->select("stud_id");
        	$DB1->from("student_master");
        	$DB1->where("enrollment_no",$user);
			//$DB1->where("enrollment_no",$_SESSION['name']);
        			$query=$DB1->get();
	  // echo $DB1->last_query();exit;
			return $query->row_array();
        
    }
    function user_login_history()
    {
        
    }
    // for getting Employee details by Empyee Id ......
    /* function get_employee_details_byId($emp_id)
    {
		
		$DB1 = $this->load->database('umsdb', TRUE);
     	$getCon = $this->db->query("select emp_id as aname, emp_id,upper(concat(fname,' ',lname))as emp_name, lname  FROM 
		employee_master where emp_id='$emp_id'   union 
		select stud_id as aname,enrollment_no as emp_id,upper(concat(first_name,' ',last_name))as emp_name,last_name as  lname 
		 FROM onlineadmission_ums.student_master where enrollment_no='$emp_id' 
		 union
     	select emp_id as aname,emp_id,upper(concat(fname,' ',lname))as emp_name, lname  FROM onlineadmission_ums.faculty_master where emp_id='$emp_id'	");
        $conRes = $getCon->result_array();
        return $conRes;
    } */
	
	 function get_employee_details_byId($emp_id)
{
    // If emp_id is empty, return empty result
    if (empty($emp_id)) {
        return [];
    }

    // Use query bindings to avoid SQL injection
    $sql = "
        SELECT emp_id as aname, emp_id, UPPER(CONCAT(fname, ' ', lname)) AS emp_name, lname, 1 as nationality 
        FROM employee_master 
        WHERE emp_id = ?

        UNION 

        SELECT stud_id as aname, enrollment_no AS emp_id, UPPER(first_name) AS emp_name, last_name AS lname, nationality  
        FROM onlineadmission_ums.student_master 
        WHERE enrollment_no = ?

        UNION 

        SELECT emp_id as aname, emp_id, UPPER(CONCAT(fname, ' ', lname)) AS emp_name, lname, 1 as nationality   
        FROM onlineadmission_ums.faculty_master 
        WHERE emp_id = ?
    ";

    $query = $this->db->query($sql, [$emp_id, $emp_id, $emp_id]);
    return $query->result_array();
}
	// for checking Reporting officer type user
    function getRoUser($emp_id){
		$sql="select ro_flag from employee_master where emp_id='$emp_id'";
		$query=$this->db->query($sql);
		$res=$query->result_array($query);
		/* print_r($res);
		die(); */
		return $res[0]['ro_flag'];
		
	}	
function change_user_password($post){
		$isValidPassword = False;
		$old_password = $post['old_password'];
		$um_id = $this->session->userdata("uid");
		$isStudent = 0;
		$email = '';
		$firstname = '';
		$email_sql = '';
		
		if($this->session->userdata("role_id")=='4'||$this->session->userdata("role_id")=='9')
		{
		   $sql="SELECT * from onlineadmission_ums.user_master WHERE um_id = ? and roles_id =?"; 

		   $email_sql = "SELECT * from onlineadmission_ums.user_master um inner join onlineadmission_ums.student_master sm on sm.enrollment_no = um.username where um.username = ? and um.roles_id = ?";
		   $isStudent =1;
		}
		else
		{
		    $sql="SELECT * from user_master WHERE um_id = ?";
		    $email_sql = "SELECT * FROM onlineadmission_ums.vw_faculty vf  WHERE vf.emp_id =  ?";
		}
		if($isStudent){
			$getUser = $this->db->query($sql, array($um_id, $this->session->userdata("role_id")));	
		
		}else{
			$getUser = $this->db->query($sql, array($um_id));
		}
		
		$userRes = $getUser->result_array();
		$isPasswordReset = $userRes[0]['is_password_reset'];
		$username = $userRes[0]['username'];
		if(!$isStudent){
			$getEmail = $this->db->query($email_sql, array($username));
	  		//echo $this->db->last_query();
	  	
			$emailRes = $getEmail->result_array();
			$email = (isset($emailRes) && count($emailRes[0]) > 0) ? $emailRes[0]['email_id'] : False;
			$firstname = $emailRes[0]['fname'];
		}else{
			$getEmail = $this->db->query($email_sql, array($username, $this->session->userdata("role_id")));
			//echo $this->db->last_query();
			$emailRes = $getEmail->result_array();
			$email = (isset($emailRes) && count($emailRes[0]) > 0) ? $emailRes[0]['email'] : False;
			$firstname = $emailRes[0]['first_name'];
		}

		$dbpassword = $userRes[0]['password'];
		if($isPasswordReset){ 
			$isValidPassword = $this->password->is_valid_password($old_password, $dbpassword);
		} else {
			if($this->session->userdata("role_id")=='4'||$this->session->userdata("role_id")=='9')
			{
			   $sql="SELECT * from onlineadmission_ums.user_master WHERE password=? and username = ?"; 
			}
			else
			{
			    $sql="SELECT * from user_master WHERE password=? and username = ?";
			}
			$query=$this->db->query($sql, array($old_password, $username));
			// echo "<br/>";
			// echo $this->db->last_query();
			$res=$query->result_array($query);

			if(count($res) > 0){
				$isValidPassword = True;
			}
		}
		
		if($isValidPassword) {
		    date_default_timezone_set('Asia/Kolkata');
			$dt = new DateTime();
	  		$update_time = $dt->format('Y-m-d H:i:s');
	  		$user_id = $this->session->userdata("uid");
	  		$password = $post['new_password'];
	  		$encrypt_password = $this->password->encrypt_password($password, $user_id);
	  		if($this->session->userdata("role_id")=='4'||$this->session->userdata("role_id")=='9')
			{
				$sql="UPDATE onlineadmission_ums.user_master SET `password` =?, `updated_by` = ?, `updated_datetime`=?, `is_password_reset` = 1 WHERE username=? and roles_id = ?";
			}
			else
			{
			   	$sql="UPDATE user_master SET `password` =?, `updated_by` = ?, `updated_datetime`=? ,`is_password_reset`= 1 WHERE username=? and roles_id = ?";
			}
			$ins = $this->db->query($sql,array($encrypt_password, $user_id, $update_time, $username, $this->session->userdata("role_id")));
			if($email){
				//$this->Login_model->password_change_mail($password, $firstname, $email);	
			}
		}else{
			$ins = "2";
		}
		return $ins;
	}
	function get_universal_id($user='',$type='')
    {
   
       
		
	 $sql= ("SELECT * FROM `universal_usermaster`  WHERE username=? AND type=?"
        );
		
		 $getCon=$this->db->query($sql, array($user, $type));
		
		
		
		
       if($getCon){  
	   $conRes = $getCon->row();
	   return $conRes;
	   }
	   else
	   {
		  return array(); 
       
	   }
	 
	   
	}
	
	
	function get_user_auto($um_id='')
    {
	

	$sql=("SELECT * FROM user_master WHERE um_id=?");
	$getCon=$this->db->query($sql,array($um_id));


		   
    date_default_timezone_set('Asia/Kolkata');
        if($getCon){
             $conRes = $getCon->result_array();
             $dat['username']=$user;
           //  $dat['role_id']=$conRes[0]['roles_id'];
             if($conRes[0]['roles_id']!='')
             {
             $dat['role_id']=$conRes[0]['roles_id'];
             }
             else
             {
               $dat['role_id']=$role_id;   
             }
             $dat['logintime']=date('Y-m-d H:i:s');
             $dat['ip_address']=$_SERVER['REMOTE_ADDR'];
             $dat['user_agent']=$_SERVER['HTTP_USER_AGENT'];
             if($conRes[0]['username']!='')
             {
               $dat['login_status']='Y';   
             }
             else
             {
               $dat['login_status']='N';   
             }
             
             
             
             $this->db->insert('user_login_history',$dat);
             return $conRes;
        }
        else{
           //print_r($this->db->error());
           
             $dat['username']=$user;
             //$dat['role_id']=$conRes[0]['roles_id'];
             $dat['logintime']=date('Y-m-d h:i:s');
             $dat['ip_address']=$_SERVER['REMOTE_ADDR'];
             $dat['user_agent']=$_SERVER['HTTP_USER_AGENT'];
                   $dat['login_status']='N';
                $this->db->insert('user_login_history',$dat);
          
        }
        
    }
	
	// login otp code start here////////////////
	
	public function check_user_details($user,$roles_id='')
	   {		
			$sql1 = "SELECT um_id,username,roles_id,otp FROM user_master WHERE username=? AND roles_id = ?";
			$sql2 = "SELECT um_id,username,roles_id,otp FROM onlineadmission_ums.user_master WHERE username=?  AND roles_id = ?";
			
			$query1= $this->db->query($sql1, array($user,$roles_id));
			$query2 = $this->db->query($sql2, array($user,$roles_id));

			$query = $this->db->query($sql1 . ' UNION ' . $sql2, array($user,$roles_id, $user,$roles_id));
			return $query->result_array();
	   }
	
		public function check_emp_other_details($user)
	   {
			/* $this->db->select('mobileNumber');
			$this->db->from('employe_other_details');
			$this->db->where('emp_id',$user);    
			$query=$this->db->get();   
			return $query->row_array();   */

			$query1 = $this->db->select('o.mobileNumber,o.oemail,em.fname,em.lname')
                       ->from('employe_other_details as o')
					   ->join('employee_master as em', 'em.emp_id = o.emp_id', 'left')
                       ->where('o.emp_id', $user)
                       ->get_compiled_select();

			// Second query to select mobile number from faculty_master
			$query2 = $this->db->select('mobile_no as mobileNumber,email_id as oemail, fname,lname')
							   ->from('onlineadmission_ums.faculty_master')
							   ->where('emp_id', $user)
							   ->get_compiled_select();

			// Combine both queries using UNION
			$final_query = $query1 . ' UNION ' . $query2;

			// Execute the final query
			$query = $this->db->query($final_query);
			
			// Return the result as an array
			return $query->row_array();
	   }
   
       public function send_otp_via_api($otp,$mob)
     { 
	      // $mess = urlencode("One time Password for Registration in Sandip University is:$otp");
		// $smsGatewayUrl="http://login.businesslead.co.in/api/mt/SendSMS?user=SANDIPFOUNDATION&password=ABC@789&senderid=SANDIP&channel=TRANS&DCS=0&flashsms=0&number=$mob&text=$mess&route=22&peid=1701159161247599930";
		 //$smsGatewayUrl="http://login.businesslead.co.in/api/mt/SendSMS?user=SANDIPFOUNDATION&password=ABC@789&senderid=SANDIP&channel=TRANS&DCS=0&flashsms=0&number=$mob&text=$mess&route=51&peid=1701159161247599930";
		 
		  $mess = urlencode("One time Password for Login in SUN-ERP is:$otp From Sandip University.");
		  $smsGatewayUrl="http://login.businesslead.co.in/api/mt/SendSMS?user=SANDIPFOUNDATION&password=ABC@789&senderid=SANDIP&channel=Trans&DCS=0&flashsms=0&number=$mob&text=$mess&route=06&Peid=1701159161247599930&DLTTemplateId=1107175005512145969";
		
			$smsgatewaydata = $smsGatewayUrl;
			$url = $smsgatewaydata;

			$ch = curl_init();                       // initialize CURL
			curl_setopt($ch, CURLOPT_POST, false);    // Set CURL Post Data
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$output = trim(curl_exec($ch));
			curl_close($ch); 

			$response = json_decode($output, true);
	        return 1;
      }

      public function get_otp_user($user,$roles_id='')
    {
		   $sql1 = "SELECT um_id,username,roles_id,status,is_password_reset FROM user_master WHERE username=? AND roles_id = ?";
		   $sql2 = "SELECT um_id,username,roles_id,status,is_password_reset FROM onlineadmission_ums.user_master WHERE username=?  AND roles_id = ?";

		   $query1= $this->db->query($sql1, array($user,$roles_id));
		   $query2 = $this->db->query($sql2, array($user,$roles_id));

		   $getCon = $this->db->query($sql1 . ' UNION ' . $sql2, array($user,$roles_id, $user,$roles_id));
	   
      date_default_timezone_set('Asia/Kolkata');
        if($getCon){
             $conRes = $getCon->result_array();
             $dat['username']=$user;
             $dat['role_id']=$conRes[0]['roles_id'];
             $dat['logintime']=date('Y-m-d H:i:s');
             $dat['ip_address']=$_SERVER['REMOTE_ADDR'];
             $dat['user_agent']=$_SERVER['HTTP_USER_AGENT'];
             if($conRes[0]['username']!='')
             {
               $dat['login_status']='Y';   
             }
             else
             {
               $dat['login_status']='N';   
             }
			 
             $this->db->insert('user_login_history',$dat);
             return $conRes;
          }
        else{        
             $dat['username']=$user;
             $dat['logintime']=date('Y-m-d h:i:s');
             $dat['ip_address']=$_SERVER['REMOTE_ADDR'];
             $dat['user_agent']=$_SERVER['HTTP_USER_AGENT'];
             $dat['login_status']='N';
             $this->db->insert('user_login_history',$dat);
        }
     }
   
		public function check_stud_prnt_details($user)
		{
			$DB1 = $this->load->database('umsdb', TRUE);   
			$sql = "SELECT sm.enrollment_no,sm.mobile as mobileNumber,p.parent_mobile2 as parent_mobno,sm.email as oemail,p.parent_email as pemail FROM student_master sm left join parent_details p on p.student_id=sm.stud_id WHERE sm.enrollment_no=? ";
			$query= $DB1->query($sql, array($user));
			return $query->row_array();
		}  

		public function check_oth_user_details($user,$roles_id='')
	   { 
		   $sql1 = "SELECT mobile_no as mobileNumber,email as oemail FROM user_master WHERE username=? AND roles_id = ? AND mobile_no!='' ";
		   $sql2 = "SELECT mobile_no as mobileNumber,email as oemail FROM onlineadmission_ums.user_master WHERE username=?  AND roles_id = ? AND mobile_no!='' ";

		   $query1= $this->db->query($sql1, array($user,$roles_id));
		   $query2 = $this->db->query($sql2, array($user,$roles_id));

		   $getCon = $this->db->query($sql1 . ' UNION ' . $sql2, array($user,$roles_id,$user,$roles_id));
		   return $getCon->row_array();
      }
	  
	  function get_total_ods($emp_id,$current_date){
		  $sql="SELECT COALESCE(count(emp_id),0) as tcount from leave_applicant_list l 
		  WHERE leave_type IN ('OD') 
AND l.fstatus NOT IN ('Cancel', 'Rejected') and emp_id IN ($emp_id)
AND l.applied_from_date <= '$current_date'  
AND LEAST(l.applied_to_date, '$current_date') >= '2025-01-15'  



";

		 return $result=$this->db->query($sql)->row()->tcount;
		  
	  }
    
	function get_total_ods_current_month($emp_id,$current_date){
		
		$start_date=date('Y-m-01',strtotime($current_date)); 
		  $sql="SELECT COALESCE(COUNT(emp_id), 0) AS tcount 
        FROM leave_applicant_list l 
        WHERE leave_type IN ('OD') 
        AND l.fstatus NOT IN ('Cancel', 'Rejected') 
        AND emp_id IN ($emp_id)
        AND l.applied_from_date >= '$start_date'  -- First day of the month
        AND l.applied_from_date <= '$current_date'    -- Up to today
        AND LEAST(l.applied_to_date, '$current_date') >= '$start_date'  



";

		 return $result=$this->db->query($sql)->row()->tcount;
		  
	  }
	
	function get_total_leaves($emp_id,$current_date){
		  $sql="SELECT COALESCE(count(emp_id),0) as tcount from leave_applicant_list l 
		  WHERE leave_type IN (SELECT id FROM employee_leave_allocation WHERE academic_year = '2024-25') 
AND l.fstatus NOT IN ('Cancel', 'Rejected') and emp_id IN ($emp_id)
AND l.applied_from_date <= '$current_date'  
AND LEAST(l.applied_to_date, '$current_date') >= '2025-01-15'  



";

		 return $result=$this->db->query($sql)->row()->tcount;
		  
	  }
    
	function get_total_leaves_current_month($emp_id,$current_date){
		
		$start_date=date('Y-m-01',strtotime($current_date)); 
		  $sql="SELECT COALESCE(COUNT(emp_id), 0) AS tcount 
        FROM leave_applicant_list l 
        WHERE leave_type IN (SELECT id FROM employee_leave_allocation WHERE academic_year = '2024-25') 
        AND l.fstatus NOT IN ('Cancel', 'Rejected') 
        AND emp_id IN ($emp_id)
        AND l.applied_from_date >= '$start_date'  -- First day of the month
        AND l.applied_from_date <= '$current_date'    -- Up to today
        AND LEAST(l.applied_to_date, '$current_date') >= '$start_date'  



";

		 return $result=$this->db->query($sql)->row()->tcount;
		  
	  }
	
	function password_change_mail($passwordText, $firstname, $email){
		
		$passwordText = '<h4>'.$passwordText.'</h5>';
		$subject = 'Password Change Successfully';
		$body = '<div style="font-family: Helvetica,Arial,sans-serif;min-width:1000px;overflow:auto;line-height:2">
			<div style="margin:0px auto;width:70%;padding:20px 0">
			    <div style="border-bottom:1px solid #eee">
			      <a href="" style="font-size:1.4em;color: #00466a;text-decoration:none;font-weight:600">Sandip University</a>
			    </div>
			    <p style="font-size:1.1em">Hi, '.$firstname.'</p>
			    <p>Thank you for changing to strong password policy. Use the following password to complete your login procedures.</p>
			    <h2 style="background: #00466a;margin: 0 auto;width: max-content;padding: 0 10px;color: #fff;border-radius: 4px;">'.$passwordText.'</h2>
			    <p style="font-size:0.9em;">Regards,<br />Sandip University</p>
			    <hr style="border:none;border-top:1px solid #eee" />
			    <div style="float:right;padding:8px 0;color:#aaa;font-size:0.8em;line-height:1;font-weight:300">
			      <p>info@sandipuniversity.edu.in</p>
			      <p>Trimbak Road Nashik, Maharashtra, India.</p>
			      <p>Nashik</p>
			    </div>
			  </div>
			</div>
		';
		$subject="Password Change Successfully";
        date_default_timezone_set('Asia/Kolkata');
        $mail = new PHPMailer;
        $mail->isSMTP();
	    $mail->Host = 'smtp.gmail.com';
        $mail->Port = 465;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'ssl';
		$mail->Username = 'noreply11@sandipuniversity.edu.in';
		$mail->Password = 'gqej udth gjpj nxvs';
        $mail->setFrom('noreply11@sandipuniversity.edu.in', 'SUN');
	    $mail->AddAddress($email);
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->AltBody = 'This is a plain-text message body';
        if (!$mail->send()) {
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo 'Message sent!';
        }
	}
	function get_student_for_forgot_password($user)
    {
        	$DB1 = $this->load->database('umsdb', TRUE);
        	$DB1->select("mobile");
        	$DB1->from("student_master");
        	$DB1->where("enrollment_no",$user);
			//$DB1->where("enrollment_no",$_SESSION['name']);
        			$query=$DB1->get();
	  // echo $DB1->last_query();exit;
			return $query->row_array();
        
    }
}