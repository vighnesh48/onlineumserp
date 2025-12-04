<?php


class Student_info_update_model extends CI_Model 
{ 

	function get_student_id_by_prn($enrollment_no){
	  $DB1 = $this->load->database('umsdb', TRUE);
			$DB1->select("stud_id,mobile");
			$DB1->from('student_master');
			$DB1->where("enrollment_no", $enrollment_no);
			$DB1->or_where("enrollment_no_new", $enrollment_no);
			$query=$DB1->get();
			$result=$query->row_array();
			return $result;
	}

	public function verify_student_mobile($post)
  	{
  		//print_r($post);die;
	 	$new_mobileno = $post['new_mobileno'];
	 	$stud_id = $post['student_code'];
	 	$email = $post['email'];
	 	$oldmobile = $post['oldmobile'];

		if($new_mobileno!='')
		{
			//echo "12";die;
		    $mobile= $new_mobileno; 
		    $DB1 = $this->load->database('umsdb', TRUE);
			$sql1 ="select * from student_master where  mobile ='$oldmobile'";
			$query1=$DB1->query($sql1);
			$result1=$query1->row_array();
			//print_r($result1);die;
		    if($result1['mobile'] == $oldmobile)
		   	{
		   		if($oldmobile  == $new_mobileno)
		   		{
		   			 echo 'Same Mobile No already registered.';
					 exit();
		   		}
		  		else
		  		{
		   			///	echo "2"; die;
					if($mobile=='' || strlen($mobile) < 10 || strlen($mobile) > 11 )
					{
					    echo 'Mobile Number not registered. Please contact student section';
					    exit();
					}
			
					$otp = rand(10000,99999);

					//$sdata['mobile'] = $mobile ; 
					//$sdata['email'] = $email ; 

					$sdata['otp'] = $otp ; 
					$sdata['otp_date'] = date('Y-m-d') ; 
					$DB1 = $this->load->database('umsdb', TRUE);
					$DB1->where('stud_id',$stud_id);
					$DB1->update('student_master',$sdata);

					
					$mess = urlencode("One time Password for Registration in Sandip University is:$otp");
					$smsGatewayUrl="http://login.businesslead.co.in/api/mt/SendSMS?user=SANDIPFOUNDATION&password=ABC@789&senderid=SANDIP&channel=TRANS&DCS=0&flashsms=0&number=$mobile&text=$mess&route=22&peid=1701159161247599930";

					$ch = curl_init();                       // initialize CURL
					curl_setopt($ch, CURLOPT_POST, false);    // Set CURL Post Data
					curl_setopt($ch, CURLOPT_URL, $smsGatewayUrl);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					$output = trim(curl_exec($ch));
					curl_close($ch); 
					//print_r($output);die;
					$response = json_decode($output, true);
					
					//print_r($response);die;
					/*if($response['status']== 1){
					 	return 'Y';
						//echo 'OTP has sent to your registered mobile number';
						exit();
					}

					else
					{
					 	echo 'Systeam Dely sms delivery';
						//print_r($output);
						exit();
					}*/
					return 'Y';
				}
			} 
		} 
	}
	public function verify_student_mobile_otp($post)
  	{
  		//echo "1"; die;
	 	$new_mobileno = $post['new_mobileno'];
	 	$stud_id = $post['student_code'];
	 	$otp = $post['otp'];
	 	$email = $post['email'];
		if($stud_id!='')
		{
		    $mobile= $new_mobileno; 
			$DB1 = $this->load->database('umsdb', TRUE);
			$sql ="select * from student_master where  stud_id ='$stud_id'
			 AND otp ='$otp' ";
			$query=$DB1->query($sql);
			// echo $DB1->last_query();exit;
			$result=$query->result_array();
			if(isset($result))
			{
				$sdata['mobile'] = $mobile ; 
				$sdata['email'] = $email ; 
				$DB1 = $this->load->database('umsdb', TRUE);
				$DB1->where('stud_id',$stud_id);
				$DB1->update('student_master',$sdata);
				//echo $DB1->last_query(); exit;
				echo "Y";
			}
			else
			{
				echo 'OTP Not Match Please try again';
			}
		}
	} 

}

?>