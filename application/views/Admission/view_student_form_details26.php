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
	width: 100%;font-size:12px;
}
.main-wrapper {
	*background: #f4f4f4;
	padding-top: 10px;
	font-size: 14px
}
.heading-1 {
	*background: #CCC;
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
	*background: #eee;
}
.detail-bg table tr td {
	font-size: 14px!important;
	height: 25px;
}
.np {
	padding: 0;
}
.detail-heading {
	background: #f9f1c7;
	border-color: #f6deac;
    color: #af8640;
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
	*background-color: transparent;
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
<div id="content-wrapper">
  <div class="page-header">
    <div class="row ">
      <div class="col-sm-12">
        <div class="panel">
          <div class="panel-body">
			<div class="container">
			  <div class="row main-wrapper">

				<div class="col-lg-12 heading-1">
				  <h4>Admission Form 2017-18</h4>
				</div>
			  </div>
			  <div class="row detail-bg">
				<div class="col-lg-12 np">
				  <h2 class="detail-heading">ENTRY LEVEL </h2>
				</div>
				<div class="col-lg-12 np">
				  <table class="table table-bordered">
					<tr>
					<?php
						if($emp[0]['lateral_entry']=='N'){
							$first_y = "checked";
						}else{
							$first_y = "";
						}
						if($emp[0]['lateral_entry']=='Y'){
							$sec_y = "checked";
						}else{
							$sec_y = "";
						}
						
						?>
					  <td>
					      <?php
						if($emp[0]['lateral_entry']=='N'){
    						echo "First Year";
						}else{
							echo "Lateral Year";
						}
						
						
						?>
						</td>
					  <td><strong>PRN No :</strong> <?=$emp[0]['enrollment_no']?></td>
					  <td rowspan="2" width="90px"><img src="<?php echo base_url();?>assets/images/user-img.jpg" width="88" height="88"></td>
					</tr>
					<tr>
					  <td><strong>Course Name :</strong>&nbsp;&nbsp;&nbsp; <?=$emp[0]['course_name']?> <?=$emp[0]['stream_name']?>
						</td>
					  <td><strong>Issue Date :</strong> 12/04/2007</td>
					</tr>
				  </table>
				</div>

			  </div>
			  <div class="row detail-bg">
				<div class="col-lg-12 np">
				  <h2 class="detail-heading">Personal Information</h2>
				</div>
				<div class="col-lg-12">
				  <table class="table">
					<tr>
					  <td  align="left"><strong>Student Name :</strong></td>
					  <td colspan="3"><strong>Surname :</strong> <?=$emp[0]['last_name']?> &nbsp;&nbsp;&nbsp;<strong>First Name :</strong> <?=$emp[0]['first_name']?> &nbsp;&nbsp;&nbsp; <strong>Middle Name :</strong> <?=$emp[0]['middle_name']?></td>
					</tr>
					<tr>
					  <td  align="left">&nbsp;</td>
					  <td colspan="3">(Exact as appears in the certificate of qualifying examination)</td>
					</tr>
					<tr>
					  <td  align="left" width="22%"><strong>Gender :</strong></td>
					  <td colspan=3><?php if(isset($emp[0]['gender']) && $emp[0]['gender']=='M'){
						  echo "Male";
					  }else{
						  echo "Female";
					  }?>
						 <strong style="margin-left:40px;">Date of Birth :</strong> 
					  <?php
						//echo $per[0]['dob'];
						if($emp[0]['dob'] !='0000-00-00' && $emp[0]['dob'] !=''){
						echo $newDate = date("d-m-Y", strtotime($emp[0]['dob']));
						}
						?>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp<strong>Place of Birth :</strong> <?=$emp[0]['birth_place'];?>
						</td>
					</tr>
					<?php 
						if(!empty($laddr)){
					?>
					<tr>
					  <td align="left"><strong>Address of Correspondence :</strong></td>
					  <td valign="top"  colspan="3"><table width="100%">
						  <tr>
							<td class="pb"><?=$laddr[0]['address']?></td>
						  </tr>
						  <tr>
							<td class="pb">City :</strong> <?=$laddr[0]['taluka_name']?> &nbsp; &nbsp;<strong>Dist :</strong> <?=$laddr[0]['district_name']?><strong> &nbsp; &nbsp;State :</strong> <?=$laddr[0]['state_name']?> &nbsp; &nbsp; <strong>Pincode :</strong> <?=$laddr[0]['pincode']?></td>
						  </tr>
						  <tr>
							<td class="pb"><strong>Mobile (self) :</strong> <?=$emp[0]['mobile']?>  &nbsp; &nbsp;</td>
						  </tr>
						</table></td>
					</tr>
					<?php
						}
						if(!empty($paddr)){
					?>
					<tr>
					  <td align="left"><strong>Address of Permanent :</strong></td>
					  <td valign="top"  colspan="3"><table width="100%">
						  <tr>
							<td class="pb"><?=$paddr[0]['address']?></td>
						  </tr>
						  <tr>
							<td class="pb"><strong>City :</strong> <?=$paddr[0]['taluka_name']?> &nbsp; &nbsp;<strong>Dist :</strong> <?=$paddr[0]['district_name']?><strong> &nbsp; &nbsp;State :</strong> <?=$paddr[0]['state_name']?> &nbsp; &nbsp; <strong>Pincode :</strong> <?=$paddr[0]['pincode']?> </td>
						  </tr>
						  
						</table></td>
					</tr>
					<?php
						}
						
					?>
					<tr>
					  <td align="left"><strong>Nantionality :</strong></td>
					  <td>
						Indian</td>
					  <td align="right"><strong>Domicile Status :</strong></td>
					  <td><?php if(isset($emp[0]['domicile_status']) && $emp[0]['domicile_status']!='') { echo $emp[0]['domicile_status'];}?></td>
					</tr>
					<tr>
					  <td align="left"><strong>Category :</strong></td>
					  <td><?php if(isset($emp[0]['caste']) && $emp[0]['caste']!='') { echo $emp[0]['caste'];}?></td>
					  <td align="right" width="30%"><strong>Any Other(Specify) :</strong></td>
					  <td>- </td>
					</tr>
				  </table>
				</div>
			  </div>
			  <!--div class="row detail-bg">
				<div class="col-lg-12 np">
				  <h2 class="detail-heading">Admission & Qualifying Examination Particulars</h2>
				</div>
				<div class="col-lg-12 np">
				  <table  class="table table-bordered">
					<tr>
					  <td width="60%"><table class="tablee">
						  <tr>
							<td width="55%" align="right"><strong>Name of Qualifying Exam :</strong></td>
							<td>Dummy</td>
						  </tr>
						  <tr>
							<td align="right"><strong>Disipline (Applicable):</strong></td>
							<td>Dummy</td>
						  </tr>
						  <tr>
							<td align="right"><strong>Duration & Year of Passing :</strong></td>
							<td>Dummy</td>
						  </tr>
						  <tr>
							<td align="right"><strong>Institute Name :</strong></td>
							<td>Dummy</td>
						  </tr>
						  <tr>
							<td align="right"><strong>Admission Basis :</strong></td>
							<td><input name="Male" type="checkbox" value="" checked>
							  Entrance Exam</td>
						  </tr>
						  <tr>
							<td align="right"><strong>Entrance Exam (if applicable) :</strong></td>
							<td><input name="Male" type="checkbox" value="" checked>
							  SU JEE</td>
						  </tr>
						  <tr>
							<td align="right"><strong>Roll No. & Date of Exam :</strong></td>
							<td>Dummy</td>
						  </tr>
						  <tr>
							<td align="right"><strong>Entrance Exam percentage :</strong></td>
							<td>Dummy</td>
						  </tr>
						</table></td>
					  <td valign="top"><table class="tablee">
						  <tr>
							<td colspan="3">CGPA/Mark Obtained in Qualifying Examination</td>
						  </tr>
						  <tr>
							<td align="center"><strong>Year/Semester</strong></td>
							<td align="center"><strong>Max Marks</strong></td>
							<td align="center"><strong>Marks Obtained</strong></td>
						  </tr>
						  <tr>
							<td align="center">I</td>
							<td align="center">80</td>
							<td align="center">80</td>
						  </tr>
						  <tr>
							<td align="center">II</td>
							<td align="center">80</td>
							<td align="center">80</td>
						  </tr>
						  <tr>
							<td align="center">III</td>
							<td align="center">80</td>
							<td align="center">80</td>
						  </tr>
						  <tr>
							<td align="center">IV</td>
							<td align="center">80</td>
							<td align="center">80</td>
						  </tr>
						  <tr>
							<td align="center">V</td>
							<td align="center">80</td>
							<td align="center">80</td>
						  </tr>
						  <tr>
							<td align="center">VI</td>
							<td align="center">80</td>
							<td align="center">80</td>
						  </tr>
						  <tr>
							<td colspan="3">CGPA--------on a------- Point Scale OR Aggregate-------% (of all the year/Semester)</td>
						  </tr>
						</table></td>
					</tr>
				  </table>
				</div>
			  </div-->
			  <div class="row detail-bg">
				<div class="col-lg-12 np">
				  <h2 class="detail-heading">Academic History Other Than Qualifying Examination</h2>
				</div>
				<div class="col-lg-12 np">
				  <table class="table table-bordered">
					<tr>
					  <th scope="col">Qualification</th>
					  <th scope="col">Specilization</th>
					  <th scope="col">Board Name</th>
					  <th scope="col">Year of Passing</th>
					  <th scope="col">Percentage</th>
					  <th scope="col">Document</th>
					</tr>
					 <?php 
						$srNo1=1;
						foreach($qual as $var){
					?>
					<tr>
						<td><?=$var['degree_type']?></td>
						<td><?=$var['specialization']?></td>
						<td><?=$var['board_uni_name']?></td>
						<td><?=$var['passing_year']?></td>
						<td><?=$var['percentage']?>%</td>
						<td>
						<?php
						if(!empty($var['file_path'])){?>
						<a href="<?=base_url()?>uploads/student_document/<?=$var['file_path']?>" target="_blank">view</a>
						<?php }else{
							echo 'N';
						}
						?>
						</td>
					</tr>
					<?php 
					$srNo++;
					}
					?>
					
				  </table>
				</div>
			  </div>
			  <div class="row detail-bg">
				<div class="col-lg-12 np">
				  <h2 class="detail-heading">FACILITY OPTED BY THE CANDIDATE </h2>
				</div>
				<div class="col-lg-12 np">
				  <table class="table table-bordered">
					<tr>
					  <td>Hostel (Fill enclouser I)</td>
					  <?php 
						if(isset($admdetails[0]['hostel']) && $admdetails[0]['hostel']=='Yes'){
							echo "<td>Yes</td>";
							echo "<td>";
							  if(isset($admdetails[0]['hostel_type']) && $admdetails[0]['hostel_type']=='reg'){
								  echo "Regular";
							  }else{
								  echo "Day Boarding";
							  }
							  echo "</td>";
						  }else{
							echo "<td colspan=2>No</td>";  
						  }
					  ?>
					  
					</tr>
					<tr>
					  <td>Transport (Fill enclouser I)</td>
						<?php 
						if(isset($admdetails[0]['transport']) && $admdetails[0]['transport']=='Yes'){
							echo "<td>Yes</td>";
							echo "<td>";
							  if(isset($admdetails[0]['transport_boarding_point']) && $admdetails[0]['hostel_type']!=''){
								  echo $admdetails[0]['transport_boarding_point'];
							  }else{
								  echo "-";
							  }
							  echo "</td>";
						  }else{
							echo "<td colspan=2>No</td>";  
						  }
					  ?>
					</tr>
				  </table>
				</div>
			  </div>
			  <div class="row detail-bg">
				<div class="col-lg-12 np">
				  <h2 class="detail-heading">Extra Curricular Activities <br>
					<small style="color:#fff">Furnish in brief the particular of achivementin sports/cultural/and other co-curricular activities)</small> </h2>
				</div>
				<div class="col-lg-12 np">
				  <table class="table table-bordered">
					<tr>
					  <th scope="col">Particular of Activity</th>
					  <th scope="col">Year</th>
					  <th scope="col">Marks Obtained</th>
					  <th scope="col">Total Marks</th>
					  <th scope="col">Percentage</th>
					</tr>
					<?php 
						$srNo1=1;
						foreach($entrance as $entr){
					?>
					<tr>
						<td><?=$entr['entrance_exam_name']?></td>
						<td><?=$entr['passing_year']?></td>
						<td><?=$entr['marks_obt']?></td>
						<td><?=$entr['marks_outof']?></td>
						<td><?=$entr['percentage']?>%</td>
						
					</tr>
						<?php }?>
				  </table>
				  <!--table class="table table-bordered">
					<tr>
					  <th colspan="3" scope="col">Details of Disciplinary Action (if any)</th>
					</tr>
					<tr>
					  <td width="60%">Has any disciplinary action ever been taken against you? <br>
						(if yes,Please furnish the following details)</td>
					  <td  colspan="2"><input name="Male" type="checkbox" value="" checked>
						Yes &nbsp;&nbsp;&nbsp;
						<input name="Male" type="checkbox" value="" >
						No</td>
					</tr>
					<tr>
					  <td><strong>Perticulars of Disciplinary Action</strong></td>
					  <td><strong>Year</strong></td>
					  <td><strong>Name of the Institution</strong></td>
					</tr>
					<tr>
					  <td>&nbsp;</td>
					  <td>&nbsp;</td>
					  <td>&nbsp;</td>
					</tr>
				  </table-->
				  
				  <table class="table table-bordered">
					<tr>
					  <th colspan="3" scope="col">References (Other than Blood Relatives)</th>
					</tr>
					<tr>
					  <td><strong>S.NO.</strong></td>
					  <td><strong>Reference Name</strong></td>
					  <td><strong>Contact Number</strong></td>
					</tr>
					<?php 
						$srNo11=1;
						if(!empty($ref)){
						foreach($ref as $rf){
					?>
					<tr>
					  <td><?=$srNo11?></td>
					  <td><?=$rf['person_name']?></td>
					  <td><?=$rf['contact_no']?></td>
					</tr>
						<?php $srNo11++; } }?>
				  </table>
				  <table class="table table-bordered">
						<?php 
						
						if(!empty($uniemp)){
						?>
					<tr>
					  <th colspan="2" scope="col">Are you related to any person employed with Sandip University (if Yes) :</th>
					</tr>
					<tr>
					  <td width="33%" align="right">Name of Employed Person</td>
					  <td><?=$uniemp[0]['person_name']?></td>
					</tr>
					<tr>
					  <td align="right">Designation</td>
					  <td><?=$uniemp[0]['contact_no']?></td>
					</tr>
					<tr>
					  <td align="right">Relation</td>
					  <td><?=$uniemp[0]['relation']?></td>
					</tr>
						<?php } if(!empty($unialu)){?>
					<tr>
					  <th colspan="2" scope="col">Are you related to Alumni of Sandip University (if Yes) :</th>
					</tr>
					<tr>
					  <td width="33%" align="right">Name of Alumni</td>
					  <td><?=$unialu[0]['person_name']?></td>
					</tr>
					<tr>
					  <td align="right">Year of Passing</td>
					  <td><?=$unialu[0]['contact_no']?></td>
					</tr>
					<tr>
					  <td align="right">Relation</td>
					  <td><?=$unialu[0]['relation']?></td>
					</tr>
					<?php } if(!empty($unistud)){?>
					<tr>
					  <th colspan="2" scope="col">Are you relatives studying in Sandip University (if Yes) :</th>
					</tr>
					<tr>
					  <td width="33%" align="right">Name of Student</td>
					  <td><?=$unistud[0]['person_name']?></td>
					</tr>
					<tr>
					  <td align="right">Course Name</td>
					  <td><?=$unistud[0]['contact_no']?></td>
					</tr>
					<tr>
					  <td align="right">Relation</td>
					  <td><?=$unistud[0]['relation']?></td>
					</tr>
					<?php }?>
				  </table>
				</div>
			  </div>
			  <div class="row detail-bg">
				<div class="col-lg-12 np">
				  <h2 class="detail-heading">How did you know about sandip university ?</h2>
				</div>
				<div class="col-lg-12 np">
				  <table class="table table-bordered">
					<tr>
					  <td><strong><?=$emp[0]['about_uni_know']?></strong></td>
					</tr>
				  </table>
				  <table class="table table-bordered">
					<tr>
					  <td colspan="3"><strong>Give reference of the candidate who maybe interested to purse academic programe in Sandip University</strong></td>
					</tr>
					<tr>
					  <td width="33%">Name of Candidate</td>
					  <td colspan="2"><?=$fromref[0]['person_name']?></td>
					</tr>
					<!--tr>
					  <td>Age / Date of Birth</td>
					  <td>23 Year</td>
					  <td><strong>Gender :</strong> Male</td>
					</tr>
					<tr>
					  <td>Address for Correspondence</td>
					  <td colspan="2"><table width="100%">
						  <tr>
							<td class="pb">5th Floor, Koteshwar Plaza, J N Road, Mulund West </td>
						  </tr>
						  <tr>
							<td class="pb"><strong>City :</strong> Mumbai &nbsp; &nbsp;<strong>State :</strong> Maharashtra &nbsp; &nbsp; <strong>Pincode :</strong> 400068</td>
						  </tr>
						  <tr> </tr>
						</table></td>
					</tr-->
					<tr>
					  <td>Contact Nos.</td>
					  <td colspan="2">
					  <table width="100%">
						  <tr>
							<td class="pb"><strong>Mobile :</strong> <?=$fromref[0]['contact_no']?>&nbsp; &nbsp;<br>
							  <br>
							  <strong>E-mail id :</strong> <?=$fromref[0]['email']?></td>
						  </tr>
						  <tr> </tr>
						</table></td>
					</tr>
					<tr>
					  <td>Your relatinon with the candidate</td>
					  <td colspan="2">&<?=$fromref[0]['relation']?></td>
					</tr>
					<tr>
					  <td>Area of interest of referred candidate</td>
					  <td colspan="2"><?=$fromref[0]['area_of_interest']?></td>
					</tr>
				  </table>
				</div>
			  </div>
			  
			  
			  
			  <div class="row detail-bg">
				<div class="col-lg-12 np">
				  <h2 class="detail-heading">Parent's/Guardian's Details *</h2>
				</div>
				<div class="col-lg-12 np">
				  <table class="table table-bordered">
					
					<tr>
					  <td><strong>Father Name</strong></td>
					  <td colspan=5><?=$parent_details[0]['gfirst_name'];?> <?=$parent_details[0]['gmiddle_name'];?> <?=$parent_details[0]['glast_name'];?></td>
					</tr>
					<tr>
					  <td><strong>Mobile 1</strong></td>
					  <td colspan=2><?=$parent_details[0]['parent_mobile1'];?> </td>
					  <td><strong>Mobile 2</strong></td>
					  <td colspan=2><?=$parent_details[0]['parent_mobile2'];?></td>
					</tr>
					 <tr>
					  <td><strong>Father Occupation</strong></td>
					  <td><?=$parent_details[0]['occupation'];?></td>
					  <td width="20%"><strong>Income</strong></td>
					  <td><?=$parent_details[0]['income'];?></td>
					  <td width="20%"><strong>Qualification</strong></td>
					  <td><?=$parent_details[0]['qualification'];?></td>
					</tr>
					<tr>
					  <td align="left"><strong>Address of Permanent :</strong></td>
					  <td valign="top"  colspan="5"><table width="100%">
						  <tr>
							<td class="pb"><?=$gaddr[0]['address']?></td>
						  </tr>
						  <tr>
							<td class="pb"><strong>City :</strong> <?=$gaddr[0]['taluka_name']?> &nbsp; &nbsp;<strong>Dist :</strong> <?=$gaddr[0]['district_name']?><strong> &nbsp; &nbsp;State :</strong> <?=$gaddr[0]['state_name']?> &nbsp; &nbsp; <strong>Pincode :</strong> <?=$gaddr[0]['pincode']?> </td>
						  </tr>
						  
						</table>
						</td>
					</tr>
				  </table>
				  
				  
				  <table class="table table-bordered">
    				  <tr>
    				  <td colspan="5"><strong>Payment Details</strong></td>
    				  </tr>
    					 <tr>
    					  <td width="25%"><strong>Payment Details</strong></td>
    					  <td colspan="5">
    					      
    				    <table class="table table-bordered">
    					<tr>
    					  <th scope="col">Academic Fee :</th>
    					  <th scope="col">Exepmted Fee :</th>
    					  <th scope="col">Applicable Fee :</th>
    					  <th scope="col">Amount Paid :</th>
    					  <th scope="col">Balance :</th>
    					</tr>
    					<?php 

					  $exm = (int)$admission_details[0]['actual_fee'] - (int)$admission_details[0]['applicable_fee'];
					  $bal = (int)$admission_details[0]['applicable_fee'] - (int)$get_feedetails[0]['amount'];
					  
    						$srNo1=1;
    					
    					?>
    					<tr>
    						<td><?= isset($admission_details[0]['actual_fee']) ? $admission_details[0]['actual_fee'] : '' ?></td>
    						<td><?=  $exm; ?></td>
    						<td><?= isset($admission_details[0]['applicable_fee']) ? $admission_details[0]['applicable_fee'] : '' ?></td>
    						<td><?= isset($get_feedetails[0]['amount']) ? $get_feedetails[0]['amount'] : '' ?></td>
    						<td><?= $bal ?></td>
    						
    					</tr>
    						
    				  </table>
    				  
    				  <table class="table table-bordered">
    					<tr>
    					  <th scope="col">Payment Type :</th>
    					  <th scope="col">Cheque/DD No. :</th>
    					  <th scope="col">Dated :</th>
    					  <th scope="col">Bank name :</th>
    					  <th scope="col">Branch name :</th>
    					</tr>

    					<tr>
    						<td><?=$get_feedetails[0]['fees_paid_type']?></td>
    						<td><?= isset($get_feedetails[0]['receipt_no']) ? $get_feedetails[0]['receipt_no'] : '' ?></td>
    						<td><?= isset($get_feedetails[0]['fees_date']) ? $get_feedetails[0]['fees_date'] : '' ?></td>
    						<td><?= $bank_details[0]['bank_name']; ?></td>
    						<td><?= isset($get_feedetails[0]['bank_city']) ? $get_feedetails[0]['bank_city'] : '' ?></td>
    						
    					</tr>
    						
    				  </table>
    				  
						</td>
					</tr>

				  </table>
				  
				</div>
			  </div>
			  
			  <div class="row detail-bg">
				<div class="col-lg-12 np">
				  <h2 class="detail-heading">checklist in respect of document to be submitted</h2>
				</div>
				<div class="col-lg-12 np">
				  <table class="table table-bordered">
				  <tr>
				  <th>Sr.No.</th>
				  <th>Particulars</th>
				  <!--th>Mark 'NA' if not applicable</th>
				  <th>Mark 'O' if submitted in original and 'X' if Xerox is submitted</th-->
				  <th>If pending for submission (Specify date of submission)</th>
				  <th>Document</th>
				  </tr>
				  <?php
				  $x=1;
					if(!empty($docs)){
						foreach($docs as $doc){
				  ?>
					 <tr>
					  <td><?=$x?>.</td>
					  <td><?=$doc['document_name']?></td>
					  <!--td><?=$doc['doc_applicable']?></td>
					  <td><?=$doc['ox']?></td-->
					  <td><?=$doc['created_on']?></td>
					  <td><?php
					  if(!empty($doc)){
					      ?>
					      <a href="<?=base_url()?>uploads/student_document/<?=$doc['doc_path']?>" target="_blank">view</a>
					      <?php
					  }else{
					      echo "N";
					  }
					      ?>
					      </td>
					</tr>
						<?php $x++;
						}
					}
						?>
					 
				  </table>
				  
				  
				</div>
			  </div>

				</div>
				</div>
			</div>
		</div>
	</div>
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