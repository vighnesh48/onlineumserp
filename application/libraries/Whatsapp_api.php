<?php

class Whatsapp_api
{
    private $CI;
 
    function __construct()
    {
        $this->CI = get_instance();
    }
 
		function send_whats_app_message($mobile, $file_name)
	  {
		
	
			$url = 'https://app.relationsai.com/api/users';

			// Prepare the data payload
			$data = array(
			 'phone' => '+91' . $mobile,  // Replace with actual phone number
			'first_name' => 'Vighnesh',     // Replace with actual first name
			'last_name' => 'Sukum',       // Optional: Replace with actual last name
			'actions' => array(
			array(
			'action' => 'set_field_value',
			'field_name' => 'attendance_pdf',
			'value' => $file_name
			),
			array(
			'action' => 'set_field_value',
			'field_name' => 'attendance_duration',
			'value' => '15 JAN 2025 to 30 April 2025 '
			),
			array(
			'action' => 'send_flow',
			'flow_id' => '1745906112101'
			)
			)
			);

			// Set the headers, including the API key
			$headers = array(
			'Content-Type: application/json',
			'X-ACCESS-TOKEN: 1343415.5bwbad8nvVIcCtPbw4aAbx63KWg8i2OKtKl61c4RhKXI5WV'
			);

			// Initialize cURL session
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

			// Execute the request
			$response = curl_exec($ch);
			$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

			// Error handling
			if (curl_errno($ch)) {
			echo 'Curl error: ' . curl_error($ch);
			} else {
			echo 'HTTP Status Code: ' . $http_code . "\n";
			echo 'Response: ' . $response;
			}

			// Close cURL session
			curl_close($ch);
    }
	
 
    }


?>