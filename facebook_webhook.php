<?php
//error_reporting(E_ALL);
$challenge=$_REQUEST['hub_challenge'];
$verfy_token=$_REQUEST['hub_verify_token'];
if($verfy_token=='abc123'){
	echo $challenge;
}
$raw_post_data = file_get_contents('php://input');
$data = json_decode($raw_post_data);
//print_r($data);
$username = "main_erp_app_cyEht4JgqRXr26DlD3V";
$password = "MIaD0Y&Ez@W^Y4@1GhY";
$dbname = "sandipun_univerdb";
$servername="su-prod-mysql-erp.cgmr578w39wg.ap-south-1.rds.amazonaws.com";

$conn=mysqli_connect($servername,$username,$password,$dbname);
$con1=mysqli_connect($servername,$username,$password,"sandipun_admin");
if($con){
	echo "connected...";
	
}
else{
	echo "Problem in connection.";
}
$sql = "INSERT INTO adm_leads (full_name,email,mobile,message,ipaddr,lead_source)
VALUES ('John1111',  'john@example.com','8850633088','','','')";

if ($conn->query($sql) === TRUE) {
  echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

/*$appsecret = '291cbd9d2532bf823e51b12a4b79deb7';
$raw_post_data = file_get_contents('php://input');
$header_signature = $headers['X-Hub-Signature'];

// Signature matching
$expected_signature = hash_hmac('sha1', $raw_post_data, $appsecret);

$signature = '';
if(
    strlen($header_signature) == 45 &&
    substr($header_signature, 0, 5) == 'sha1='
  ) {
  $signature = substr($header_signature, 5);
}
if (hash_equals($signature, $expected_signature)) {
  echo('SIGNATURE_VERIFIED');
}else{
	print_r($raw_post_data);
}*/
?>
