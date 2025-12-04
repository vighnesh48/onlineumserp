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
    <div class="col-xs-3 pull-right"> <strong>Form No :</strong> 0123456987  </div>
    <div class="col-xs-12">
      <p class="head-add"><strong>Address :</strong> Trimbak Road, Mahirvani Nashik - 422 213, Maharashtra.<br>
        <strong>Corporate Office :</strong> Koteshwar Plaza, J N Road, Mulund (W), Mumbai - 400080 <br>
        <strong>Toll Free :</strong> 1800-212-2714 &nbsp; &nbsp;|&nbsp; &nbsp; <strong>Website :</strong> www.sandipuniversity.com </p>
    </div>
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
          <td><input name="Male" type="checkbox" value="" checked>
            &nbsp;&nbsp;First Year &nbsp;&nbsp;&nbsp;
            <input name="Male" type="checkbox" value="" >
            &nbsp;&nbsp;Lateral Year</td>
          <td><strong>Enrollment No :</strong> 1234567890</td>
          <td rowspan="2" width="90px"><img src="<?php echo base_url();?>assets/images/user-img.jpg" width="88" height="88"></td>
        </tr>
        <tr>
          <td><strong>Already Enrolled Student :</strong>&nbsp;&nbsp;&nbsp;
            <input name="Male" type="checkbox" value="" >
            &nbsp;yes &nbsp;&nbsp;&nbsp;
            <input name="Male" type="checkbox" value="" >
            &nbsp;No</td>
          <td><strong>Issue Date :</strong> 12/04/2007</td>
        </tr>
      </table>
    </div>
    <div class="col-lg-12 np">
      <h2 class="detail-heading">COURSES & BRANCH THE CANDIDATE IS APPLYING FOR <small style="color:#fff">(In Order to Preference)</small></h2>
    </div>
    <table class="table table-bordered">
      <tr>
        <th scope="col">Sr.</th>
        <th scope="col">Course Name</th>
        <th scope="col">Name of Program</th>
        <th scope="col">Specilization / Branch</th>
      </tr>
      <tr>
	  
        <td>1.</td>
        <td><?=$emp[0]['course_name']?></td>
        <td><?=$emp[0]['stream_name']?></td>
        <td>-</td>
      </tr>

    </table>
  </div>
  <div class="row detail-bg">
    <div class="col-lg-12 np">
      <h2 class="detail-heading">Personal Information</h2>
    </div>
    <div class="col-lg-12">
      <table class="table">
        <tr>
          <td  align="right"><strong>Student Name :</strong></td>
          <td colspan="3"><strong>Surname :</strong> <?=$emp[0]['last_name']?> &nbsp;&nbsp;&nbsp;<strong>First Name :</strong> <?=$emp[0]['first_name']?> &nbsp;&nbsp;&nbsp; <strong>Middle Name :</strong> <?=$emp[0]['middle_name']?></td>
        </tr>
        <tr>
          <td  align="right">&nbsp;</td>
          <td colspan="3">(Exact as appears in the certificate of qualifying examination)</td>
        </tr>
        <tr>
          <td  align="right" width="22%"><strong>Gender :</strong></td>
          <td><?php if(isset($emp[0]['gender']) && $emp[0]['gender']=='M'){
			  echo "Male";
		  }else{
			  echo "Female";
		  }?>
             </td>
          <td width="20%" align="right"><strong>Date of Birth :</strong></td>
          <td width="30%"><?php
            //echo $per[0]['dob'];
            if($emp[0]['dob'] !='0000-00-00' && $emp[0]['dob'] !=''){
			echo $newDate = date("d-m-Y", strtotime($emp[0]['dob']));
            }
			?></td>
            </td>
        </tr>
		<?php 
			if(!empty($laddr)){
		?>
        <tr>
          <td align="right"><strong>Address of Correspondence :</strong></td>
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
          <td align="right"><strong>Address of Permanent :</strong></td>
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
          <td align="right"><strong>Nantionality :</strong></td>
          <td>
            Indian</td>
          <td align="right"><strong>Domicile Status :</strong></td>
          <td><?php if(isset($emp[0]['domicile_status']) && $emp[0]['domicile_status']!='') { echo $emp[0]['domicile_status'];}?></td>
        </tr>
        <tr>
          <td align="right"><strong>Category :</strong></td>
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
			if(!empty($var['file_path'])){
			echo 'Y';
			}else{
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
      <h2 class="detail-heading">for office use only</h2>
    </div>
    <div class="col-lg-12 np">
      <table class="table table-bordered">
              <tr>
          <td colspan="4" align="right"><br><strong>Recommendation of Admissions Committee :</strong> -----------------------</td>
        </tr>

        <tr>
          <td width="25%"><strong>Form Entry Section</strong></td>
          <td>&nbsp;</td>
          <td width="25%"><strong>ERP Entry Section</strong></td>
          <td>&nbsp;</td>
        </tr>
                <tr>
          <td width="25%"><strong>Document Section</strong></td>
          <td>&nbsp;</td>
          <td width="25%"><strong>File Section</strong></td>
          <td>&nbsp;</td>
        </tr>

        <tr>
          <td width="25%"><strong>Scholarship Section</strong></td>
          <td>&nbsp;</td>
          <td width="25%"><strong>Student's Section</strong></td>
          <td>&nbsp;</td>
        </tr>

        <tr>
          <td width="25%"><strong>Accounts Section</strong></td>
          <td>&nbsp;</td>
          <td width="25%"><strong>Signature (Convener Admissions Committee)</strong></td>
          <td>&nbsp;</td>
        </tr>

      </table>
      
    </div>
  </div>
  
  
  <div class="row detail-bg">
    <div class="col-lg-12 np">
      <h2 class="detail-heading">general information</h2>
    </div>
    <div class="col-lg-12 np">
      <table class="table table-bordered">
        <tr>
          <td width="25%"><strong>Place of Birth</strong></td>
          <td colspan="5">&nbsp;</td>
        </tr>
         <tr>
          <td><strong>Father Occupation</strong></td>
          <td>&nbsp;</td>
          <td width="20%"><strong>Income</strong></td>
          <td>&nbsp;</td>
          <td width="20%"><strong>Qualification</strong></td>
          <td>&nbsp;</td>

        </tr>
          <tr>
          <td><strong>Mother Occupation</strong></td>
          <td>&nbsp;</td>
          <td><strong>Income</strong></td>
          <td>&nbsp;</td>
          <td><strong>Qualification</strong></td>
          <td>&nbsp;</td>

        </tr>
        <tr>
          <td width="25%"><strong>ID Proff</strong></td>
          <td colspan="5">Adhar Card</td>
        </tr>
        <tr>
          <td width="25%"><strong>Bank Details</strong></td>
          <td colspan="5">
          <table width="100%">
              <tr>
                <td class="pb"><strong>Account No :</strong> 5897452 </td>
                  <td><strong>IFSC Code :</strong> AIFR 58</td>
              </tr>
              <tr>
                <td class="pb"> <strong>Bank Name :</strong> HDFC Bank </td>
                <td class="pb"><strong>Bank Address :</strong> Ghatkopar, Mumbai </td>
              </tr>
              <tr> </tr>
            </table>
            </td>
        </tr>
      </table>
      
      <!--table class="table table-bordered">
         <tr>
         <th>Certificate Details</th>
         <th>Certificate No</th>
         <th>Issue Date</th>
         <th>Validity</th>
         </tr>
         <tr>
         <td>Income</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         </tr>
         <tr>
         <td>Caste/Category</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         </tr>

         <tr>
         <td>Residence/State Subject</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         </tr>

      </table>
      
      <table class="table table-bordered">
      <tr>
      <td colspan="5"><strong>Education Details</strong></td>
      </tr>
         <tr>
         <th>Exam/Degree</th>
         <th>Subject</th>
         <th>Total Marks</th>
         <th>Marks Obtained</th>
         <th>Date of Passing</th>
         </tr>
         <tr>
         <td rowspan="4">12th (Intermedeate or its equivalent)</td>
         <td>Physics</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td rowspan="4">&nbsp;</td>
         </tr>
         <tr>
         <td>Chemistry</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         </tr>

         <tr>
         <td>Maths / Bio</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         </tr>
         <tr>
         <td>English</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         </tr>
        <tr>
        <td>10th (Matriculation or its equivalent)</td>
         <td>English</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         </tr>

      </table-->
      
      <table class="table table-bordered">
      <tr>
      <td colspan="5"><strong>Payment Details</strong></td>
      </tr>
         <tr>
         <th>Particulars</th>
         <th>Application Fees</th>
         <th>Amount Paid</th>
         <th>Balance (if any)</th>
         <th>Payment Particulars</th>
         </tr>
         <tr>
         <td>Asmission Form / Prospectus Fee (not to pay if already paid)</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td rowspan="4">Payment of Rs._______________made througn cash Receipt/Demand Draft No________Dated________drawn on_______________(Name of the Bank and Branch)</td>
         </tr>
         <tr>
         <td>Tution Fee</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         </tr>

         <tr>
         <td>Other</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         </tr>
         <tr>
         <td>Total</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
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
      <th>Mark 'NA' if not applicable</th>
      <th>Mark 'O' if submitted in original and 'X' if Xerox is submitted</th>
      <th>If pending for submission (Specify date of submission)</th>
      <th>(For office use only)</th>
      </tr>
	  <?php
	  $x=1;
		if(!empty($docs)){
			foreach($docs as $doc){
	  ?>
         <tr>
          <td><?=$x?>.</td>
          <td><?=$doc['document_name']?></td>
          <td><?=$doc['doc_applicable']?></td>
          <td><?=$doc['ox']?></td>
          <td><?=$doc['created_on']?></td>
          <td>&nbsp;</td>
        </tr>
			<?php $x++;
			}
		}
			?>
         
      </table>
      
      
    </div>
  </div>
  
  <div class="row detail-bg" style="font-size:11px;">
    <div class="col-lg-12"> <strong>I, the undersigned, hereby declare that:</strong>
      <ul>
        <li>All information submitted and stated by me during the course of admission and related thereto, to the best of my knowledge and belief is complete, true and 	factually correct and all the supporting and annexures to this form submitted to Sandip University are authentic. I undertake that I would be subject to all sorts of disciplinary action that University may deem fit to take against me including, but not restricted to cancellation of my admission or expulsion or rustication and other actions applicable as per relevant laws, in case the documents and information submitted and stated herewith found false, incorrect or misrepresented by me.</li>
        <li>The University has all the rights to accept my admission or reject it; mere submission of form along with fee does not mean that admission has been confirmed. The 	admission would be understood as confirmed when the University will issue the admit card or do such act that pertains to confirmation of admission.</li>
        <li>I have read and understood all the contents of the Prospectus and manual circulated along with it regarding various rules & regulations.</li>
        <li>In case I withdraw from the program for any personal reason or due to expulsion or rustication from the University on disciplinary grounds, I shall not be entitled for any refund of fees or other amount paid.</li>
      </ul><br>
    </div>
    <div class="col-xs-4  pb pt"><strong>Date :</strong> 25/5/2017</div>
    <div class="col-xs-4  pb pt"><strong>Signature of Candidate</strong></div>
    <div class="col-xs-4  pb pt"><strong>Signature of Parents/Gurdian</strong></div>
  </div>
  
  <div class="row detail-bg">
    <div class="col-lg-12 np">
      <h2 class="detail-heading">undertaking by the applicant</h2><br>
    </div>
    <div class="col-lg-12">
      <p>I, the undersigned, ___________________________________S/o / D/o _________________________________________________aged about _______________ years 

</p>
<p>R/o_____________________________________, applying for admission to Sandip University, Nashik ( Maharashtra) (Hereinafter referred to as “University”) take oath and state as under :-</p>
<ol>
<li>I hereby solemnly affirm and declare that all documents, including transfer Certification, Marks sheets and Testimonials provided by me are genuine and original and on the basis of which I am taking admission . If anything, otherwise is proved, I will be fully responsible for the consequences which may lead to cancellation of my admission forfeiting all the fees paid by me and refund of scholarship, if any, granted to me.</li>
<li>As a prospective student of Sandip University, I confirm that I understand and accept my obligations as a student of this University and certify that if I am accepted and  enrolled, I will abide by the provisions of the Act, Statutes, Regulations, Ordinances & Rules of the University, as framed, amended and enforced from time to time in any form and manner, whatever it may be (hereinafter jointly referred to as “Rules & Regulations”).</li>
<li>I undertake that it would be obligatory on my part to participate in various academic, co-curricular and extra curricular practices including but not limited to research, training, industrial visits, seminar, study tours, placements and other activities in or outside the Campus, organized/arranged by the University on payment of the fee and charges prescribed for the purpose or otherwise as deemed fit by the University from time to time.</li>
<li>I undertake that during my stay at University, I will involve myself only to academic studies and other co-curricular and extra curricular activities and would not involve myself in any activity that is illegal, anti-social, anti-national and may cause any kind of harm to any co-student, teacher, staff or to any person.</li>
<li>I undertake that the University may revise existing charges and may impose additional charges and/or fee. Moreover, the University may take decisions to alter/change various facilities provided or to be provided by the University.</li>
<li>I shall be liable to compensate for the damages caused by me to the property of the University either alone or jointly with others and the University is free to take disciplinary action against me in this respect as per the rules & regulation of the University.</li>
<li>All tangible and intangible materials developed by me (individually or jointly with others) during my study at the University including but not limited to books, software, new technologies, formulae, notes, slides, papers, CD's, formulations, drawings, paintings, photographs, sculptures, designs, models, audio, videos, films etc. will invariably be the property of the University and all rights including copyrights, patents, trademarks, intellectual property rights, publishing, selling, transferring, parting with, assigning to, broadcasting, telecasting, printing etc. shall lie with the University without any compensation to me. The University shall without my specific consent be entitled to use 	my personal and other details available in any form for such legal purposes during my study at the University and even thereafter as deemed appropriate.</li>
<li>I undertake that I would not be absolved from the implication and applicability of any act, deed, discipline etc just because that any document or information required to be submitted in any form to University or to be read and understood by me or by my parents/guardian at the time of my admission and even thereafter has not been so read, understood, signed or submitted or has been completely or partially omitted to be so read, understood, signed or submitted either deliberately or unintentionally, and hence will be binding on me for all the practical purposes.</li>
<li>I undertake that I would not be absolved from the implication and applicability of any act, deed, discipline etc just because that any document or information required to be submitted in any form to University or to be read and understood by me or by my parents/guardian at the time of my admission and even thereafter has not been so read, understood, signed or submitted or has been completely or partially omitted to be so read, understood, signed or submitted either deliberately or unintentionally, and hence will be binding on me for all the practical purposes.</li>
<li>I declare that I am medically fit and have no communicable and serious diseases like that of fits, any sort of attacks or otherwise and I shall be liable to pay for any expenditure incurred by the University on my treatment for any illness or disease or personal injury or otherwise, due to any reason during my stay at the University.</li>
<li>I agree that I would adhere to all kinds of rules & regulations framed by the University including but not limited to admission cancellation, expulsion or rustication or withdrawal of any facility by the University. In case I have been found guilty of, any sort of disobedience or misconduct of any of the Rules and Regulations, I will not only be liable to face the disciplinary and penal action as per the University code of conduct but would also face the legal action as per the law of the land and in that case I shall not have any right to claim for refund of fees and other amounts paid to the University.</li>
<li>I agree that I shall study at the University for the complete duration of the program opted for and if due to any reason, I leave /withdraw at any time before the completion of program, I shall not be entitled for any kind of refund, however would be liable to pay the University all the outstanding dues in respect of fee & charges for the concerned academic year.</li>
<li>The University reserves the right to frame, amend, revoke, repeal and enforce the Rules & Regulations, as and when deemed fit; and it shall be my duty to keep myself well  versed and updated with the amended Rules & Regulations as applicable from time to time; the University shall not be bound or responsible to intimate me separately in any manner, in this regard. </li>
<li>The University reserves the right to frame, amend, revoke, repeal and enforce the Rules & Regulations, as and when deemed fit; and it shall be my duty to keep myself well  versed and updated with the amended Rules & Regulations as applicable from time to time; the University shall not be bound or responsible to intimate me separately in any manner, in this regard. </li>
<li>I agree that the Hon’ble Court applicable for Nashik jurisdiction would be the only court to handle all disputes arising out of or in respect of all academic and other matters of all kinds pertaining to the University in any respect.</li>
<li>I agree that I shall study at Sandip University for the complete duration. I shall maintain minimum 75% attendance in any/all courses failing which the University may take  any action that shall be final.</li>
<li>The University officials have all the rights to stop my entry to the campus, classes, lab etc., if I have been found not in uniform and without carrying ID card.</li>
<li>I shall not practice and/or involve in any kind of activities that may be termed as “RAGGING” as per Hon’ble Supreme Court directive as per the order no.D15/04/xi-A dated 	26th Feb. 2009. I understand that performing or involving in any such kind of activities may not only lead me to a fine of Rs 1,00,000/-or rigorous imprisonment of 6 months or both but would also get a mention of the same on my marks-sheet/degree.</li>
<li>I shall personally take care of cash and personal belongings of all kinds including mobile phones, PC, Laptops, jewelry or other valuables in the University. In case of any loss  or damage caused for any reason, the University administration will not be responsible for the same.</li>
</ol>
      
    </div>
   <div class="col-xs-6 pb pt"><strong>Signature of Candidate ______________</strong></div>
   <div class="col-xs-12">
   <h4>VERIFICATION</h4>
   <p>I, ___________________________________, do hereby verify that the above undertaking under para (1) to para (18) is given by me to Sandip University with full understanding and if any variation is found, I myself shall be responsible for the consequences thereof.
</p>
   </div>
   <div class="col-xs-6 pb pt"><strong>Signature of Applicant ______________</strong></div>
   <div class="col-xs-12">
   <h4>INDEMNIFICATION <br><small>(By Parent/Legal Guardian)</small></h4>
   <p>I, the undersigned, ___________________________________ _S/D/o ____________________________________________in the capacity of _____________________ (Father/Mother/Legal Guardian, specify relation) of the above named applicant do hereby indemnify Sandip University (hereinafter referred to as the “University”) and their representatives against:

</p>
<ol>
<li>All the liabilities whether civil, criminal or otherwise as per the law of the land currently in force, that may arise on account of the misconduct and illegal actions of my ward, throughout the duration of his/her stay at the University campus or elsewhere during the course of pursuing the academic program at the University; and I undertake to be personally responsible for all the consequences whatsoever and further undertake to bear all kind of liabilities whatever it may be and to compensate the University that it has suffered related for that matter.</li>
<li>All rights and claims by my ward, myself, my dependants, next of kin or other legal representatives for compensation on account of any mis-happening in terms of death, suicide, disability, infections, diseases, loss or damage of any kind caused to my above said Ward in person or otherwise in any manner due to any reason throughout his/ her stay at the University campus or elsewhere while pursuing the academic program at the University, and for any loss or damage of cash or valuables or his or her personal 	belongings of all kinds including mobile phones, PC, laptop, jewelry, other valuables etc.</li>
<li>All the consequences and liabilities arising, on account of misrepresentation of fact by me or my wards or due to false/incorrect details submitted by me or my ward to the University; I further undertake to be personally responsible for all consequences and liabilities whatsoever arise in this regard and compensate the University for any losses it had suffered on this count.</li>
<li>I will send my ward to the University Campus either through public transport or transport provided by the University, if the candidate is residing outside the University Campus, we would be fully responsible for all the consequences and/or loss any sort that may arise due to the usage of public transport and his/her own vehicle by my ward and we would keep the University fully indemnified against any claims that would happen due to such action.</li>
<li>My ward shall not practice and/or involve in any kind of activities that may be termed as ‘RAGGING’ as per Hon’ble Supreme Court directives as per order no. D15/04/xi-A  dates 26th Feb. 2009. I understand that performing or involving in any such kind of activities may not only lead my ward to a fine of Rs. 1,00,000/-or rigorous imprisonment of 6 months or both but would also get a mention of the same on his marks-sheet/degree.</li>

</ol>
   </div>
       <div class="col-xs-6  pb pt"><strong>Date :</strong> 25/5/2017</div>
    <div class="col-xs-6  pb pt"><strong>Signature of the Parent/Legal Guardian</strong></div>
    <div class="col-xs-6  pb pt"><strong>Place </strong></div>

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