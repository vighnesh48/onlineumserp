<!DOCTYPE html>
<html>
<head>
<title>Question Papper</title>
 <style> 
body{
	font-family: sans-serif;
  font-size:12px;
   line-height: 15px;
} 
 h1, h2, h3, h4 ,h5,h6{font-family: sans-serif;}

ol li{
    margin-left: -22px;
	 font-size:12px;
    line-height: 15px;
  font-family: sans-serif;

}
ol>li:before {
  display:inline-block;
  width:1.5em;
  padding-right:0.5em;
  font-weight:bold;
  text-align:right;
  content:counter(item) ".";
}


 
  .wt1{border:#000 Solid 2px;}
 
 
 .wt{width:50%;float:left;}
 .clear{clear:both;}
          p{
  font-family: sans-serif;
font-size:12px;
line-height: 15px;
}
 table {
  font-family: sans-serif;
  border-collapse: collapse;
  width: 100%;
}
.bor{
  border: 1px solid #000;
  text-align: left;
  padding: 4px;
}
 
.text-center{
  text-align: center;
}

 .boxxx {
  height: 200px;
  width: 200px;
  /*background-color: hotpink;*/
  /*color: #fff;*/
  padding: 10px;
  /*border: solid 3px black;*/
}
.pt30{
  padding-top: 30px;
}
.pt20{
  padding-top: 20px;
}
.pt15{
  padding-top: 15px;
}
.pt10{
  padding-top: 10px;
}
.pt5{
  padding-top: 5px;
}

        </style>  
</head>
<body>

<!--Header-->
<!--Header-->
<?php
//echo '<pre>';

$qp_data = $this->data['qp_details'][0];

//print_r($qp_data['fname']);
//print_r($qp_data);
//exit;

   ?>
<table>
<tbody>
<tr>
  
<td colspan="3"  class="bor" align="center">
<img src="<?=base_url()?>assets/su_logo.jpg">
</td>

<td class="bor" style="text-align:center">
<h1 >COE</h1>
</td>
</tr>
<tr>
<td colspan="4"  class="bor" style="text-align:center">
<h3 >OFFICE OF THE CONTROLLER OF EXAMINATIONS</h3>
</td>
</tr>
<tr>
<td colspan="2"  class="bor">
<strong>Mobile No: 8956512577</strong>
</td>
<td colspan="2"  class="bor">
<strong>Email ID: qp.coe@sandipuniversity.edu.in</strong>
</td>
</tr>

<tr>
<td colspan="2"  class="pt10">
<p>Ref : SUN/COE/QP/<?= $qp_data['exam_year']?>/<?= $qp_data['exam_month'].'/'.$qp_data['order_id']?></p>
</td>
<td colspan="2" class="pt10" style="text-align:right;">
<p style="text-align:right;">Date:<?=date('d.m.Y');?></p>
</td>
</tr>

<tr>
<td colspan="2" class="pt20">
<p><strong>FROM</strong><br/>
The Controller Of Examinations<br />  
Sandip University<br />
Nashik</p>
</td>
<td colspan="2" class="pt20">
<p><strong>To</strong><br/>
<?php echo $qp_data['fname'].' '.$qp_data['mname'].' '.$qp_data['lname'] ;?><br/>
<?php echo $qp_data['designation_name'];?><br/>
<?php echo $qp_data['department_name'];?><br/>
<?php echo $qp_data['college_name'];?></p>
</td>
</tr>
<tr>
  
  <td colspan="4" class="pt20">
    <p><strong>Dear Sir/Madam,</strong><br/>
<strong>Sub</strong> : University Examinations - Setting of Question Paper(s)- Reg.<br/><br />
You have been appointed as a Question Paper Setter for the University Examinations in the Cources(s) noted below.</p>

  </td>
</tr>
<tr><td class="pt20">
<Strong>Duration</Strong> : <?= $qp_data['duration']?> HOURS<br/>
</td><td colspan="3" class="pt20">
<Strong>Last Date for Submission </Strong>: <?= $qp_data['last_date_of_submit']?></Strong> <Strong>Max. Marks :</Strong> 100/75/80
</td></tr>

<?php 
//echo '<pre>';
//echo count($qp_details);
//echo $qp_details[0]['course_name'];
//print_r($qp_details);exit;




//echo $qp_details[$i]['course_name'];exit;
?>
</tbody>
</table>

    <table border="0" width="100%">
		<tr>
			<th class="bor">Sr.No</th>
			<th class="bor">Course</th>
			<th class="bor">Course Code and Title</th>
			<th class="bor">Semester</th>
			<th class="bor">No.of Question Paper</th>
		</tr>
		<?php $k=1;for ($i = 0;$i < count($qp_details);$i++) { ?>
		<tr>
			<td class="bor"><?=$k?></td>
			<td class="bor"><?=$qp_details[$i]['course_name']?></td>
			<td class="bor"><?php echo $qp_details[$i]['subject_code'];?>-<?php echo $qp_details[$i]['subject_name'];?></td>
			<td align="center" class="bor"><?=$qp_details[$i]['semester']?></td>
			<td align="center" class="bor"><?=$qp_details[$i]['no_of_sets']?></td>
		</tr>
<?php  $k++;
    }
    ?>
      </table>


      

       
    


<!-- <p><strong>* Setter are requested to give their acceptance for setting Question Paper(s) through Phone or email
within two days from the date of receipt of this communication.</strong></p> -->
<p><strong>* Setters are requested to download the appropriate question paper template from the portal.</strong></p>
<!-- <p>Please send the following in the enclosed cover(duly attested by Examiners on the flaps) by Registered Post / Courier
to the Undersigned by name on (or) before the last date mentioned without fail</p> -->

<p>Please upload  the following in the Portal</p> 
<ol>
<li>Softcopy of Question Papers typed in the format.</li>

<!-- <li>Filled-in Claim Form.</li> -->

</ol> 

<p style="text-align:justify">Your kind cooperation in sending the question paper on time is highly solicited. We will be very much thankful for your
fullest co-operation.</p>
<p style="text-align:justify">You are requested to decline the Examinership, if your Son / Daughter / Relative is appearing in the Subject(s) for
which you have been appointed as question paper setter. In such case, kindly inform us through Phone within two
days from the receipt of this communication and provided to enable us to make alternative arrangements</p>
<table>
  <tr>
    <td width="80%"></td>
    <td  style="float:right; text-align: center;">
      <div>
  <p>Yours Faithfully</p>
 <p>Controller Of Examinations</p>
 <img src="https://www.sandipuniversity.edu.in/images/sandip-university-logo.png">

</div></td>

  </tr>

</table>


<div class="clear"></div>
<p><strong>Encl :</strong></p>
<div style=""  >
<ol>
<li>General Instructions to the Question Paper setters and Claim Form.</li>
<!-- <li>Check List & Claim Form</li> -->

</ol>
</div>


<div style='page-break-after:always'></div>
<div class="clear"></div>
<div style="border: 2px dotted black; padding:10px; text-align: justify;"> 

<h3 align="center"><u><b>GENERAL INSTRUCTIONS</b></u></h3> 

<ol>
<li>Question Paper setters are requested to keep their appointments strictly <strong>CONFIDENTIAL.</strong></li>
<li>Kindly refer question paper pattern available in the portal. <strong>[ Scheme not required ]</strong></li>
<li>Each Question paper is to be set for <strong>3 HOURS</strong> duration and for a total of <strong>100/75/80 Marks.</strong></li>
<li><strong>The Questions must be fairly distributed over the whole syllabus of study and not concentrated on
one area or a few topics only.</strong></li>
<li>The question paper must be set in accordance with <strong>Bloom’s taxonomy</strong>.<br/>
<strong>No payment will be entertained</strong> if the question paper does not follow higher levels of Bloom’s<br/>
taxonomy or the question paper rejected by the Question Paper Scrutiny Panel.</li>
<li> Detailed instructions as per the material (Handbooks, Codes, Special Tables, Charts, etc….) if any, to be
used by the candidate in the examination hall for answering the questions should be mentioned on the
top of the question paper.</li>
<li>Abbreviations of all kinds, except those in special Cources are to be avoided.</li>
<li> If any figure / picture/ diagrams are to be mentioned in the question paper it should be either clearly<br/>
drawn using appropriate tools or it can be scanned with good resolution.</li>
<li>Declaration: I declare that digitally discarded the question paper</li> 
<!-- <li><strong>Remuneration for setting one Question paper for 100 Marks is Rs.1000/-.</strong></li>
<li> In the claim form, <strong>name (as per bank records), address for sending CHEQUE / DD,</strong> contact number<br/>
and e-mail Id of the setter must be clearly mentioned.</li> -->
</ol>
<p><strong>Note:</strong>The Question Paper must be uploaded in the  portal only not by via email.</p>

<!-- <div> <h3 align="center"><u><b>QUESTION PAPER PATTERN FOR B.E / B.TECH / M.E & MCA</b></u></h3> </div>
<ul><li>Question Paper must be prepared in two sections <strong>(PART – A & PART – B)</strong>
</li></ul>
<div style="padding-left:30px">
<p style="line-height:27px"> <strong>PART – A </strong> (10 x 2 = 20 Marks)<br/>
- Short Question Type [ No Choice]<br/>
- No. of Questions : 10<br/>
- Marks: 10 x 2 Marks = 20 Marks <strong> (2 questions must be taken from each unit) </strong></p><br/>

<p style="line-height:27px"> <strong>PART – B </strong> (5 x 16 = 80 Marks)<br/>
- - Descriptive / Essay Type questions [ Q.No 11.a) or b) to 15.a) or b) ]
<br/>
- No. of Questions : 5<br/>
- Marks: 5 x 16 Marks = 80 Marks (“either or” pattern ) </p><br/></div>-->

</div> 
<div style='page-break-after:always'></div>
<div> <h3 align="center"><b>CLAIM FORM FOR QUESTION PAPER SETTING</b></h3> </div>


<div  class="wt"><p><strong>Ref : SUN/COE/QP/<?= $qp_data['exam_year']?>/<?= $qp_data['exam_month'].'/'.$qp_data['order_id']?></strong><br/>
</p></div>
<div class="wt"><p style="text-align:right"><strong>Date:6.1.2023</strong><br/></p></div>

<div class="clear"></div>

<table >
  <tr>
  
    <th class="bor">Course, Semester, Subject
Code & Title
</th>
 <th class="bor">Course, Semester, Subject
Code & Title
</th>
    <th class="bor">No. of Question
Paper(s)
</th>
	    <th class="bor"> Remuneration Per
Question Paper</th>
    <th class="bor">Total Amount (In Rs.)</th>
  </tr>
  <?php 
  $total = 0;
  for ($i = 0;$i < count($qp_details);$i++) {
    $total +=$qp_details[$i]['price_per_set']*$qp_details[$i]['no_of_sets'];


    ?>
  <tr>
    
    <td class="bor"><?php echo $qp_details[$i]['course_name'].'/'.$qp_details[$i]['subject_code'].'-'.$qp_details[$i]['subject_name'];?></td>
    <td align="center" class="bor"><?php echo $qp_details[$i]['no_of_sets'];?></td>
	<td align="right" class="bor"><?php echo $qp_details[$i]['price_per_set'];?></td>
    <td align="right" class="bor"><?php echo $qp_details[$i]['price_per_set']*$qp_details[$i]['no_of_sets']; ?></td>
  </tr>

  <?}?>
  
  <tr>
    <td colspan="2" style="text-align:center" class="bor"><p ><strong>Total Amount(in Rs.)</strong></p></td>
    <td class="bor"></td>
    <td align="right" class="bor"><?php echo $total ?></td>
  </tr>
  
</table>
<div>
  <p>(Received a sum of Rupees <?php echo ($total)?> only.)</p>
</div>
<table >

  <tr >
    <td>
    <table>
    <tr>
    <td><strong>Name (in Block Letters)</strong></td>
    <td> : <?php echo $qp_data['fname'].''.$qp_data['mname'].''.$qp_data['lname'] ;?></td>
  </tr>
   <tr>
    <td ><strong>Designation/Dept</strong></td>
    <td  >:<?php echo $qp_data['designation_name'];?><br/>
          <?php echo $qp_data['department_name'];?><br/><?php echo $qp_data['college_name'];?></td>
  
   <tr>
    <td  ><strong>Mobile No.</strong></td>
    <td >: <?php echo $qp_data['mobile_no'];?></td>
  </tr>
   <tr>
    <td  ><strong>E-Mail ID</strong></td>
    <td >: <?php echo $qp_data['email_id'];?></td>
  </tr>
     <tr>
    <td  ><strong>Experience </strong></td>
    <td >: UG : 15,  PG : 9</td>
  </tr>
</table>
</td>

<td style="float: right;width: 100px;text-align: center; bottom: 0px;">
  <p>Signature.</p>


</td>
</tr>
<tr>
<td colspan="2"></td>
  </tr>
</table>

<div> <h3 align="center"><b>CLAIM PAYMENT DETAILS
</b></h3> </div>
<div style="padding-left:30px" ><p><strong>Bank Name </strong>: <?= $qp_data['bank_name'];?>
</p>
<p><strong>Branch Name</strong>: <?= $qp_data['branch_name'];?></p>
<p><strong>IFSC Code </strong>:  <?= $qp_data['bank_ifsc'];?></p>
<p><strong>Account No.</strong>: <?= $qp_data['bank_acc_no'];?></p>
</div>



<!-- <div> <h3 align="center">CHECK LIST
</h3> </div>
<table>

  <tr>
    <td class="bor">1</td>
    <td class="bor">All units of the prescribed syllabus covered. Same question is not repeated.Duplicacy among the set is verified.</td>
    <td class="bor">Yes</td>
	 <td  class="bor">No</td>
  </tr>
  
  <tr>
    <td class="bor">2</td>
    <td class="bor">Cource Code and Name of the course is clearly mentioned.</td>
    <td class="bor">Yes</td>
	 <td  class="bor">No</td>
  </tr>
  <tr>
    <td class="bor">3</td>
    <td class="bor">Are the figure, diagram and the usage of chart, tables are mentioned properly.</td>
    <td class="bor">Yes</td>
	 <td  class="bor">No</td>
  </tr>
  <tr>
    <td class="bor">4</td>
    <td class="bor">Check List and Claim are enclosed.</td>
    <td class="bor">Yes</td>
	  <td class="bor">No</td>
  </tr>
  
    <tr>
    <td class="bor">5</td>
    <td class="bor">Written Name with initial and Subject Code on the CD. Blooms taxonomy followed.</td>
    <td class="bor">Yes</td>
	 <td  class="bor">No</td>
  </tr>
  <tr>
    <td class="bor">6</td>
    <td class="bor">Blueprint mentioned properly.</td>
    <td class="bor">Yes</td>
	  <td class="bor">No</td>
  </tr> 
</table>  -->

<p style="text-align:right"><strong>Name & Signature of the Examiner</strong></p>
<p style="font-size:22px"><strong>Note:</strong></p>
<p style="margin-left:30px"><span>&#10004;</span> <strong>60%</strong> of the question could test the candidate on <strong>Remembering </strong>and <strong>Understanding.</strong><br/>
<span>&#10004;</span>Remaining <strong>40% </strong>on Knowledge testing like Applying, <strong>Analyzing</strong> and <strong>Evaluating.</strong></p>

</body>
</html>