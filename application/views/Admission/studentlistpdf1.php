<?php
//$basepath ="http://www.sandipuniversity.com/sandipUniversity_final/";
//$basepath ="http://www.sandipuniversity.com/";
$basepath ="http://localhost/su/";
?>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Sandip University</title>
<link href="<?php echo base_url();?>assets/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url();?>assets/css/font-awesome.min.css" rel="stylesheet">
<style>
.container {
	width: 600px;font-size:12px;
}
.main-wrapper {
	background: #f4f4f4;
	padding-top: 10px;
	font-size: 10px
}
.heading-1 {
	background: #CCC;
	text-align: center
}
.heading-1 h4 {
	font-size: 15px;
	text-transform: uppercase;
	margin-top: 5px;
	margin-bottom: 5px;
	font-weight: bold;
}
p {
	text-align: inherit;
}
.head-add {
	font-size: 13px
}
.detail-bg {
	background: #eee;
}
.detail-bg table tr td {
	font-size: 12px!important;
	height: 25px;
}
.np {
	padding: 0;
}
.detail-heading {
	background: red;
	color: #fff;
	margin: 0px;
	font-size: 15px;
	padding: 5px 0 5px 15px;
	text-transform: uppercase;
	font-weight: 600;
}
.table th {
	font-size: 12px;
}
table tr td > .tablee tr td {
	font-size: 12px;
	padding: 8px;
	border-top: 1px solid #ddd;
}
.table .table {
	background-color: transparent;
}
.pb {
	padding-bottom: 10px;
}
.bb {
	border-bottom: 1px solid #ddd
}
.pt {
	padding-top: 10px;
	line-height: 23px
}
ul {
	padding-left: 15px;
	margin-top: 10px;
}
</style>
</head>

<body>
<div class="container">
  <div class="row main-wrapper">
    <div class="col-xs-9"> <img src="<?php echo base_url();?>assets/images/logo_form.png" class="ximg-responsive">
      <p><strong>A UNIVERSITY U/S 2(F) OF THE UGC ACT 1956 WITH THE RIGHT TO CONFER
        DEGREE U/S 22 (1) GOVT. OF MAHARASHTRA ACT. NO. XXXVIII OF 2015.</strong></p>
    </div>
   
    <div class="col-xs-12">
      <p class="head-add"><strong>Address :</strong> Trimbak Road, Mahirvani Nashik - 422 213, Maharashtra.<br>
        <strong>Corporate Office :</strong> Koteshwar Plaza, J N Road, Mulund (W), Mumbai - 400080 <br>
        <strong>Toll Free :</strong> 1800-212-2714 &nbsp; &nbsp;|&nbsp; &nbsp; <strong>Website :</strong> www.sandipuniversity.com </p>
    </div>
    <div class="col-lg-12 heading-1">
      <h4>Student List</h4>
    </div>
  </div>
  <div class="row detail-bg">
    <div class="col-lg-12 np">
      <h2 class="detail-heading">Stream :<?php echo $dstream; ?>    Year : <?php echo $dyear;  ?> </h2>
    </div>
    <div class="col-lg-12 np">
      <table class="table table-bordered">
        <tr>
     <th> Sr. No.</th>
                                     <th>PRN</th>
                                    <th>Name</th>
                                    <th>Course </th>
                                    <th>Stream </th>
                                    <th>DOB</th>
                                    <th>Mobile</th>
                                    <th>Email</th>
        </tr>
		
		   <?php
                            
                          
                            $j=1;                            
                            for($i=0;$i<count($emp_list);$i++)
                            {
                                
                            ?>
							 <?php if($emp_list[$i]['ro_flag']=='on') $bg="bgcolor='#e6eaf2'";
								  else $bg="";?>								
                            <tr <?=$bg?> <?=$emp_list[$i]["status"]=="N"?"style='background-color:#FBEFF2'":""?>>
                               <td><?=$j?></td>
                        
                                 <td><?=$emp_list[$i]['enrollment_no']?></td> 
                                <td>
							
							<?php
								echo $emp_list[$i]['first_name']." ".$emp_list[$i]['middle_name']." ".$emp_list[$i]['last_name'];
								?>
								</td> 
								 <td><?=$emp_list[$i]['course_name']?></td> 
								   <td><?=$emp_list[$i]['stream_name']?></td> 
                                                                                              
                            <td><?=$emp_list[$i]['dob']?></td>                               
                                                      
                                <td><?=$emp_list[$i]['mobile'];?></td>    
                                <td><?=$emp_list[$i]['email'];?></td> 
                                                    
                                                        
                             
                            </tr>
                            <?php
                            $j++;
                            }
                            ?> 
      </table>
    </div>
</div>
 
<script src="JsBarcode.all.min.js"></script> 
<script>
JsBarcode("#barcode", "W1700010", {
width:1,
  height:50,
  fontSize:12,
	});
</script> 

<!--Bootstrap core JavaScript--> 
<script src="http://www.sandipuniversity.com/js/jquery.js"></script> 
<script src="http://www.sandipuniversity.com/js/bootstrap.min.js"></script> 

<!--<script src="https://cdn.jsdelivr.net/jsbarcode/3.5.8/barcodes/JsBarcode.code128.min.js"></script>-->
</body>
</html>