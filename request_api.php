<?php
$prn= $_REQUEST['SId'];
$acy=$_REQUEST['AYNAme'];
$ch = curl_init(); 
$query="?UserName=SUN321&ApiKey=SU-API-Enrolled-Stud&SId=".$prn."&AYNAme=".$acy;
curl_setopt($ch, CURLOPT_URL,'https://sandiperp.com/RequestApi.aspx'.$query); 
//curl_setopt($ch,CURLOPT_URL,  "http://beed.mezbanservice.com/pcurl.php");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
//curl_setopt($ch, CURLOPT_POSTFIELDS, "UserName=SUN321&ApiKey=SU-API-Enrolled-Stud&SId=532018001&AYNAme=2018-2019");
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Length: 0'));
$buffer = curl_exec($ch);
echo $buffer;
curl_close($ch);
?>