<style>
/*ERP PROFILE PAGE STYLE*/
/*New Style*/
.nav>li:last-child {
    margin-top:10px!important;
}
.panel{
    box-shadow: 1px 2px 13px #ccc!important;
}
.panel:hover{
    box-shadow:1px 2px 7px #f2f2f2!important;
}
.theme-default .nav-tabs>li.active>a, .theme-default .nav-tabs>li.active>a:focus, .theme-default .nav-tabs>li.active>a:hover {
    background: #1d89cf!important;
    border-bottom: 2px solid #1d89cf!important;
    color: #fff!important;
    text-transform: capitalize!important;
}
.form-horizontal .form-group {
    margin-left: -11px;
    margin-right: -11px;
    border-bottom: #FFFDE7 solid 1px;
    margin: 10px;
}










.img-circle {

    box-shadow: 7px 12px 19px #a59d9d!important;
}
.tabs-left > .nav-tabs > li > a {
    margin-right: 0px;
    -webkit-border-radius: 0px 0 0 0px;
    -moz-border-radius: 0px 0 0 0px;
    border-radius: 0px 0 0 0px;
    text-transform: capitalize!important;
    font-size: 13px;
    padding: 8px 5px!important;
}
.form-horizontal .control-label {
    font-weight: bold!important;
}
.student-detail-container {
    background: #f8f8f8!important;
    padding: 10px!important;
	overflow: hidden!important;
	margin-bottom:20px!important;
}
.tab-content>.active {
    display: block;
	padding: 7px!important;
    border: #FF9800 solid 1px!important;
}
.tab-pane h3 {

    font-size: 16px!important;
	font-family:'Roboto';
}
@media (max-width: 992px){
.tab-pane h3 {
    margin-top: 5%!important;
}
.text-right {
    text-align: center!important;
}
}
/*New Style*/
.profile-img{width: 200px;
            height: 200px;
            border: 7px solid #b7b7b7; background-color: #eee5de;
            position: relative;
			box-shadow:#1px 1px #ccc;
            border-inline-start: 7px #ffc844 solid;
            border-radius:50%;margin:0 auto;}
 .border-bottom{border-bottom:1px solid #000;padding-bottom:10px}           
    
.no-padding{padding:0px}
.tooltip{padding:20px!important;height:50px}




.tabs-left > .nav-tabs > li,
.tabs-right > .nav-tabs > li {
  float: none;
}

.tabs-left > .nav-tabs > li > a,
.tabs-right > .nav-tabs > li > a {
  min-width: 74px;
  margin-right: 0;
  margin-bottom: 3px;
  color:#000;font-weight:400;
}

.tabs-left > .nav-tabs {
  float: left;
  margin-right:0px;
  border-right:0px solid #000;
}

.tabs-left > .nav-tabs > li > a {
  margin-right: 0px;
  -webkit-border-radius: 0px 0 0 0px;
  -moz-border-radius: 0px 0 0 0px;
  border-radius: 0px 0 0 0px;text-transform: uppercase;
  font-size:13px;padding:10px 5px;
}

.tabs-left > .nav-tabs > li > a:hover,
.tabs-left > .nav-tabs > li > a:focus {
  border-color: #eeeeee #dddddd #eeeeee #eeeeee;
}

.tabs-left > .nav-tabs .active > a,
.tabs-left > .nav-tabs .active > a:hover,
.tabs-left > .nav-tabs .active > a:focus {
	border: 1px solid transparent;
    border-bottom: 4px solid #ffc844;
    background:#ddd;color:#000;
}
.tabs-left > .nav-tabs{border-bottom:0px;width: 100%;}
.student-detail-container{background: #f8f8f8;padding:0 5px;}
.line-space{line-height: 2em}
.tab-pane  h3{
margin-top: 0;
margin-bottom:20px;
background: #ffc844;
padding: 5px;
text-transform: uppercase;
}
.container {
	width: 100%;font-size:12px;
}
.main-wrapper {
	*background: #f4f4f4;
	padding-top: 10px;
	font-size: 14px
}
.table{width:100%}
@media (max-width: 767px) 
   {
    .tab-pane h3 
	{
    margin-top: 106%;
    }
}
@media (max-width: 992px) 
   {
    .tab-pane h3 
	{
    margin-top: 106%;
    }
}
</style>
<div id="content-wrapper">
  <div class="page-header">
    <div class="row ">
      <div class="col-sm-12">
        <div class="panel">
          <div class="panel-body">
<div class="row">
  <div class="container">
    <div class="col-md-3">
    <div class="profile-img">
        <?php
                                     //  $tep = base_url().'uploads/2017-18/'.$emp_list[$i]['form_number'].'/' . $emp_list[$i]['form_number'].'_PHOTO.bmp';
                                     //  echo $tep;
                                      /*  if (file_exists('uploads/2017-18/'.$emp[0]['form_number'].'/' . $emp[0]['form_number'].'_PHOTO.bmp')) {
                                         //  echo "yES";
                                           $ext = 'bmp';
                                       }
                                       else
                                       {
                                             $ext = 'jpg';
                                       }
                                           $bucket_key = '/uploads/student_photo/'.$emp[0]['enrollment_no'].$ext;
    $imageData = $this->awssdk->getImageData($bucket_key); */
	

								    $file_name = $emp[0]['enrollment_no'];
									$photo = $file_name.'.jpg';
									$bucket_key = 'uploads/student_photo/' .$photo;
									$bucket_name = 'erp-asset';
									$this->load->library('awssdk');
									$profile = $this->awssdk->getImageData($bucket_key);
									
									?>
                                   
    <img src="<?=$profile?>"  width="100%" height="100%" class="img-circle">
   </div>
    </div>
   <div class="col-md-9">
   <h3 class="border-bottom"><b>Name : <?=$emp[0]['last_name']?> <?=$emp[0]['first_name']?> <?=$emp[0]['middle_name']?></b></h3>
   <div class="row">
    <div class="col-md-8 line-space">
	<?php
        $ac_year=(int)substr($emp[0]['academic_year'],2,2)+1;
         $adm_year=(int)substr($emp[0]['admission_session'],2,2)+1;
        
		if($emp[0]['lateral_entry']=='N'){
			$first_y = "First Year".'&nbsp;&nbsp; ('.$emp[0]['admission_session'].'-'.$adm_year.' )';
		}else{
			$first_y = "Direct Second  Year".'&nbsp;&nbsp;('.$emp[0]['admission_session'].'-'. $adm_year.' )';
		}
		
		
  switch($emp[0]['current_year']){
     case '1': $year="First Year";
     break;
      case '2':$year="Second Year";
     break;
      case '3':$year="Third Year";
     break;
      case '4':$year="Fourth Year";
     break;
   
  }
    //print_r($emp[0]);
	?>
   
     
       <table class="table table-bordered table-condensed table-hover">
       		 <tr>
               <td width="30%">Admission Year</td>
               <td><b><?php echo $emp[0]['academic_year']; ?></b></td>
         </tr>
       	 <tr>
               <td width="30%">Admission Type</td>
               <td><b><?php if($emp[0]['admission_year']=='4') echo "PHD with Jr.Fellowship"; else echo "PHD without Jr.fellowship";?></b></td>
         </tr>

           <tr>
               <td width="30%">Admission Cycle</td>
               <td><b><?=$emp[0]['admission_cycle'];?></b></td>
         </tr>
         <tr>
               <td>PRN No</td>
               <td><b><?=$emp[0]['enrollment_no']?></b></td>
             </tr>
             <tr>
               <td>Course Name</td>
               <td><b><i><?=$emp[0]['stream_name']?> (<?=$emp[0]['stream_code']?>)</i></b></td>
             </tr>
                <tr>
               <td>Current Year</td>
               <td><b><?=$year.'   ('.$emp[0]['academic_year'].'-'.$ac_year.')'?></b></td>
             </tr>
              
        </table>
        <?php
       // print_r($get_feedetails);
        ?>
    </div>
    <div class="col-md-4 text-right">
    <a href="#" data-toggle="tooltip" title="<?=$emp[0]['mobile']?>"><img src="<?=base_url()?>assets/images/phone-icon.png" alt="Phone" > </a>&nbsp;&nbsp;
    <a href="#" data-toggle="tooltip" title="<?=$emp[0]['email']?>"><img src="<?=base_url()?>assets/images/email-icon.png" alt="Email" > </a>    
    </div>   
   </div>
  
   </div>
   <div class="clearfix"></div>
    
    <div class="col-lg-12" style="margin-top:20px">
    
    
         <!-- tabs left -->
      <div class="tabbable">
      <div class="col-md-3 tabs-left  student-detail-container">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#one" data-toggle="tab">Personal Information</a></li>
          <li><a href="#two" data-toggle="tab">Academic History</a></li>
          <li><a href="#seven" data-toggle="tab">Payment Details</a></li>
          <li><a href="#six" data-toggle="tab">Parent's/Guardian's Details*</a></li>
      <!--    <li><a href="#three" data-toggle="tab">FACILITY OPTED</a></li>-->
          <li><a href="#four" data-toggle="tab">Extra Curricular Activities  </a></li>
     <!--     <li><a href="#eight" data-toggle="tab">Submit documents List</a></li></li>-->
          <li><a href="#five" data-toggle="tab">How did you know?</a></li>
 
        </ul>
        </div>
        <div class="col-md-9">
        <div class="tab-content no-padding">
            <div class="tab-pane active" id="one">
            <h3>Personal Information</h3>
            <!--form class="form-horizontal">
   <div class="form-group">
    <label class="control-label col-sm-4" for="email">Gender :</label>
    <div class="col-sm-8">
      <p class="form-control-static"><?php if(isset($emp[0]['gender']) && $emp[0]['gender']=='M'){
						  echo "Male";
					  }else{
						  echo "Female";
					  }?> </p>
    </div>
    </div>

    <div class="form-group">
    <label class="control-label col-sm-4" for="email">Adhar Card No :</label>
    <div class="col-sm-8">
      <p class="form-control-static"><?=$emp[0]['adhar_card_no'];?> </p>
    </div>
   </div>

       <div class="form-group">
    <label class="control-label col-sm-4" for="email">Date of Birth : </label>
    <div class="col-sm-8">
      <p class="form-control-static"><?php
		//echo $per[0]['dob'];
		if($emp[0]['dob'] !='0000-00-00' && $emp[0]['dob'] !=''){
		echo $newDate = date("d-m-Y", strtotime($emp[0]['dob']));
		}
		?>	 </p>
    </div>
   </div>

      <div class="form-group">
    <label class="control-label col-sm-4" for="email">Place of Birth :</label>
    <div class="col-sm-8">
      <p class="form-control-static"><?=$emp[0]['birth_place'];?> </p>
    </div>
   </div>
  <!--div class="form-group">
    <label class="control-label col-sm-4" for="email">Local Address :</label>
    <div class="col-sm-8">
      <p class="form-control-static"><?=$laddr[0]['address']?><br><strong>City :</strong> <?=$laddr[0]['taluka_name']?> &nbsp; &nbsp;<strong>Dist :</strong> <?=$laddr[0]['district_name']?><strong> &nbsp; &nbsp;State :</strong> <?=$laddr[0]['state_name']?> &nbsp; &nbsp; <strong>Pincode :</strong> <?=$laddr[0]['pincode']?><br>
 </p>
    </div>
  </div-->
  <!--th>
  <div class="form-group">
    <label class="control-label col-sm-4" for="email">Permanent Address:</label>
    <div class="col-sm-8">
      <p class="form-control-static"><?=$paddr[0]['address']?><br><strong>City :</strong> <?=$paddr[0]['taluka_name']?> &nbsp; &nbsp;<strong>Dist :</strong> <?=$paddr[0]['district_name']?><strong> &nbsp; &nbsp;State :</strong> <?=$paddr[0]['state_name']?> &nbsp; &nbsp; <strong>Pincode :</strong> <?=$paddr[0]['pincode']?><br>
 </p>
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-4" for="email">Nantionality :</label>
    <div class="col-sm-8"  for="email">
      <p class="form-control-static"><?=$emp[0]['nationality']?></p>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-4" for="email">Domicile Status :</label>
    <div class="col-sm-8">
      <p class="form-control-static"><?php if(isset($emp[0]['domicile_status']) && $emp[0]['domicile_status']!='') { echo $emp[0]['domicile_status'];}?></p>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-4" for="email">Category :</label>
    <div class="col-sm-8">
      <p class="form-control-static"><?=$emp[0]['category'];?></p>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-4" for="email">Blood Group :</label>
    <div class="col-sm-8">
      <p class="form-control-static"><?=$emp[0]['blood_group'];?></p>
    </div>
  </div>


</form-->     
      <table class="table table-bordered table-condensed table-hover">
       		 <tr>
               <td width="30%"><strong>Gender</strong></td>
               <td><b><?php if(isset($emp[0]['gender']) && $emp[0]['gender']=='M'){
						  echo "Male";
					  }else{
						  echo "Female";
					  }?> </b></td>
         </tr>
       	 <tr>
               <td width="30%"><strong>Adhar Card No :</strong></td>
               <td><b><?=$emp[0]['adhar_card_no'];?></b></td>
         </tr>

           <tr>
               <td width="30%"><strong>Date of Birth : </strong></td>
               <td><b><?php
		//echo $per[0]['dob'];
		if($emp[0]['dob'] !='0000-00-00' && $emp[0]['dob'] !=''){
		echo $newDate = date("d-m-Y", strtotime($emp[0]['dob']));
		}
		?></b></td>
         </tr>
         <tr>
               <td><strong>Place of Birth :</strong></td>
               <td><b><?=$emp[0]['birth_place'];?> </b></td>
             </tr>
             <tr>
               <td><strong>Permanent Address:</strong></td>
               <td><b><?=$paddr[0]['address']?><br><strong>City :</strong> <?=$paddr[0]['taluka_name']?> &nbsp; &nbsp;<strong>Dist :</strong> <?=$paddr[0]['district_name']?><strong> &nbsp; &nbsp;State :</strong> <?=$paddr[0]['state_name']?> &nbsp; &nbsp; <strong>Pincode :</strong> <?=$paddr[0]['pincode']?><br></b></td>
             </tr>
                <tr>
               <td><strong>Nantionality :</strong></td>
               <td><b><?=$emp[0]['nationality']?></b></td>
             </tr>
			 <tr>
               <td><strong>Domicile Status :</strong></td>
               <td><b><?php if(isset($emp[0]['domicile_status']) && $emp[0]['domicile_status']!='') { echo $emp[0]['domicile_status'];}?></b></td>
             </tr>
			 <tr>
               <td><strong>Category :</strong></td>
               <td><b><?=$emp[0]['category'];?></b></td>
             </tr>
			 <tr>
               <td><strong>Blood Group :</strong></td>
               <td><b><?=$emp[0]['blood_group'];?></b></td>
             </tr> 
			 <tr>
               <td><strong>Father Name :</strong></td>
               <td><b><?=$emp[0]['father_lname'];?> &nbsp;<?=$emp[0]['father_fname'];?>  &nbsp;<?=$emp[0]['father_mname'];?></b></td>
             </tr> 
			 <tr>
               <td><strong>Mother Name :</strong></td>
               <td><b><?=$emp[0]['mother_name'];?></b></td>
             </tr>
              
        </table>
             </div>
            <div class="tab-pane" id="two">
            <h3>Academic History</h3>
             <table class="table table-bordered">
					<tbody><tr>
					  <th scope="col">Qualification</th>
					  <th scope="col">Specilization</th>
					  <th scope="col">Board Name</th>
					  <th scope="col">Year of Passing</th>
					  <th scope="col">Percentage</th>
					  <th scope="col">Document</th>
					</tr>
					<?php 
					
			      $student_id = $this->session->userdata('studId');                   
                  $student_year = getStudentYear($student_id);
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
						<a href="<?= site_url() ?>Upload/get_document/<?=$var['file_path'];?>?b_name=uploads/student_document/<?php echo $student_year.'/';?>" target="_blank"> view</a>
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
										
				  </tbody>
				  </table>       
				  </div>
            <div class="tab-pane" id="three">
            <h3>FACILITY OPTED</h3>
            <table class="table table-bordered">
					<tbody>
					<tr>
					  <td width="50%"><strong>Hostel </strong></td>
					  <?php 
						if(isset($admdetails[0]['hostel']) && $admdetails[0]['hostel']=='Yes'){
							echo "<td></td>";
							echo "<td>";
							  if(isset($admdetails[0]['hostel_type']) && $admdetails[0]['hostel_type']=='reg'){
								  echo "";
							  }else{
								  echo "";
							  }
							  echo "</td>";
						  }else{
							echo "<td colspan=2></td>";  
						  }
					  ?>					  
					</tr>
					<tr>
					  <td><strong>Transport</strong></td>
						<?php 
						if(isset($admdetails[0]['transport']) && $admdetails[0]['transport']=='Yes'){
							echo "<td></td>";
							echo "<td>";
							  if(isset($admdetails[0]['transport_boarding_point']) && $admdetails[0]['hostel_type']!=''){
								  //echo $admdetails[0]['transport_boarding_point'];
							  }else{
								  echo "-";
							  }
							  echo "</td>";
						  }else{
							echo "<td colspan=2></td>";  
						  }
					  ?>
					</tr>
				  </tbody>
				  </table>            
				  </div>
            <div class="tab-pane" id="four">
            <h3>Extra Curricular Activities</h3>
             <table class="table table-bordered">
					<tbody>
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
					</tbody>
					</table>  
					<table class="table table-bordered">
					<tbody>
					<?php 
						if(!empty($uniemp)){
					?>	
					<tr>
					  <td colspan="2">Are you related to any person employed with Sandip University (if Yes) :</td>
					</tr>
					<tr>
					  <td width="33%" align="right"><strong>Name of Employed Person</strong></td>
					  <td><?=$uniemp[0]['person_name']?></td>
					</tr>
					<tr>
					  <td align="right"><strong>Designation</strong></td>
					  <td><?=$uniemp[0]['contact_no']?></td>
					</tr>
					<tr>
					  <td align="right"><strong>Relation</strong></td>
					  <td>dgdsg</td>
					</tr>
					<?php } if(!empty($unialu)){?>
					<tr>
					  <td colspan="2">Are you related to Alumni of Sandip University (if Yes) :</td>
					</tr>
					<tr>
					  <td width="33%" align="right"><strong>Name of Alumni</strong></td>
					  <td><?=$unialu[0]['person_name']?></td>
					</tr>
					<tr>
					  <td align="right"><strong>Year of Passing</strong></td>
					  <td><?=$unialu[0]['contact_no']?></td>
					</tr>
					<tr>
					  <td align="right"><strong>Relation</strong></td>
					  <td><?=$unialu[0]['relation']?></td>
					</tr>
					<?php } if(!empty($unistud)){?>
					<tr>
					  <td colspan="2" scope="col">Are you relatives studying in Sandip University (if Yes) :</td>
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
					 </tbody>
					 </table>          
            
             </div>
				<div class="tab-pane" id="five">
				<h3>How did you know?</h3>
            <table class="table table-bordered">
					<tbody><tr>
					  <td><strong>Newspaper Advertisement</strong></td>
					  <td><?=$emp[0]['about_uni_know']?></td>
					</tr>
				  </tbody>
				  </table>
				  <table class="table table-bordered">
					<tbody><tr>
					  <td colspan="3">References:</td>
					</tr>
					<tr>
					  <td width="50%"><strong>Name of Candidate</strong></td>
					  <td colspan="2"><?=$fromref[0]['person_name']?></td>
					</tr>
				
					<tr>
					  <td><strong>Contact Nos.</strong></td>
					  <td colspan="2">
						<table width="100%">
						  <tbody>
						  <tr>
							<td class="pb"><strong>Mobile :</strong> <?=$fromref[0]['contact_no']?>&nbsp; &nbsp;
							  <strong>E-mail id :</strong> <?=$fromref[0]['email']?></td>
						  </tr>
						  <tr> 
						  </tr>
						</tbody>
						</table>
					  </td>
					</tr>
					<tr>
					  <td><strong>Your relation with the candidate</strong></td>
					  <td colspan="2"><?=$fromref[0]['relation']?></td>
					</tr>
					<tr>
					  <td><strong>Area of interest of referred candidate</strong></td>
					  <td colspan="2"><?=$fromref[0]['area_of_interest']?></td>
					</tr>
				  </tbody></table>
					</div>
					<div class="tab-pane" id="six">
      <h3>Parent's/Guardian's Details *</h3>
            <table class="table table-bordered table-hover">
					<tbody>
					   <tr>
    					  <td><strong>Father Name</strong></td>
    					  <td colspan="5"><?=$emp[0]['father_lname'];?> &nbsp;<?=$emp[0]['father_fname'];?>  &nbsp;<?=$emp[0]['father_mname'];?></td>
					   </tr>
					<tr>
					  <td><strong>Mother Name</strong></td>
					  <td><?=$emp[0]['mother_name'];?></td>
					</tr>
					<tr>
					  <td><strong>Gurdian Mobile</strong></td>
					  <td><?=$parent_details[0]['parent_mobile2'];?></td>
					  </tr>
					 <tr>
					  <td><strong>Father Occupation</strong></td>
					  <td><?=$parent_details[0]['occupation'];?></td>
					  
					</tr>
					<tr>
					  <td><strong>Income</strong></td>
					  <td><?=$parent_details[0]['income'];?></td>
					  				  
					</tr>
					<tr>
					  <td><strong>Gurdian Relation</strong></td>
					  <td><?=$parent_details[0]['relation'];?></td>
					</tr>
						<tr>
					  <td><strong>SMS Subscribe</strong></td>
					  <td><?= $parent_details[0]['subscribe_for_sms']=="Y" ? 'Yes' : 'No';?></td>
					</tr>
						<tr>
					  <td><strong>Email Subscribe</strong></td>
					  <td><?= $parent_details[0]['subscribe_for_email']=="Y" ? 'Yes' : 'No';?></td>
					</tr>
				  </tbody></table>
					</div>
					
			<div class="tab-pane" id="seven">
			<h3>Payment Details</h3>
            <table class="table table-bordered table-hover">
				<tbody>
					<?php 
				
					  $exm = (int)$admission_details[0]['actual_fee'] - (int)$admission_details[0]['applicable_fee'];
			  $bal = (int)$admission_details[0]['applicable_fee'] - (int)$totfeepaid[0]['tot_fee_paid'];
					  $srNo1=1;
					  
						
    			 $popbal = ($admission_detail[1]['applicable_fee'] + $admission_det[1]['canc_amount'] + $admission_detail[1]['opening_balance']) + $admission_detail[1]['tot_refunds'] -  $admission_detail[1]['totfeepaid'] ;
    					  
    				?>
					<tr style="background-color:#F5F5F5;">
					      <td><strong>Academic Year</strong></td>
					       <td><strong> Year</strong></td>
					        <th scope="col">Academic Fee</th>
    					  <th scope="col">Exepmted Fee</th>
    					  <th scope="col">Applicable Fee</th>
    					  <th scope="col">Opening balance</th>
    					  <th scope="col">Amount Paid</th>
    				
    					   <td><strong>Refund</strong></td>
    					  
    					  
    					  <th scope="col">Remaining Balance</th>
    					 
    					    <th scope="col">Chq Cancellation Charges</th>
    					      <th scope="col">Total Outstanding</th>
    					<!--  <td><strong>Academic Fees</strong></td>
    					  <td><strong>Exepmted Fees</strong></td>
    					  <td><strong>Applicable Fees</strong></td>
    					  
    					  <td><strong>Amount Paid</strong></td>
    					    <?php
    					  if($tot_refunds['rsum']!='')
    					  {
    					    ?>
    					   <td><strong>Refund</strong></td>
    					   <?
    					  }
    					  ?>
    					  <td><strong>Balance Fees</strong></td>
    					-->
					 </tr>
					 
					 
					 <?php 

						$exm = (int)$admission_details[0]['actual_fee'] - (int)$admission_details[0]['applicable_fee'];
						$bal = (int)$admission_details[0]['applicable_fee'] - (int)$get_feedetails[0]['amount'];
					  
    					$srNo1=1;
    					
    				$actual =	isset($admission_details[0]['applicable_fee']) ? $admission_details[0]['applicable_fee'] : '';
    					$paid =isset($totfeepaid[0]['tot_fee_paid']) ? $totfeepaid[0]['tot_fee_paid'] : '';
    					$i=1;
    				  $cn = count($admission_detail);
    				  
    				 // var_dump($admission_detail);
    					if($cn >1)
    					{
    					
    			 $popbal = ($admission_detail[1]['applicable_fee'] + $admission_det[1]['canc_amount'] + $admission_detail[1]['opening_balance']) + $admission_detail[1]['tot_refunds'] -  $admission_detail[1]['totfeepaid'] ;
    					}
    					else
    					{
    					    $popbal = 0;
    					}
    				//	$popbal = $admission_detail[];
    					$i=1;
    					foreach($admission_detail as $admission_det)
    					{
    					    
    				//	 echo $i;
						$exm = (int)$admission_det['actual_fee'] - (int)$admission_det['applicable_fee'];
						$bal = (int)$admission_det['applicable_fee'] - (int)$admission_det['totfeepaid'];
					  
    					$srNo1=1;
    					
    				$actual =	isset($admission_det['applicable_fee']) ? $admission_det['applicable_fee'] : '';
    					$paid =isset($admission_det['totfeepaid']) ? $admission_det['totfeepaid'] : '';   
    					?>
    					<tr>
							<td><?= $admission_det['academic_year']; ?></td>
								<td><?= $admission_det['year']; ?></td>
    						<td><?= isset($admission_det['actual_fee']) ? $admission_det['actual_fee'] : '' ?></td>
    						<td><?=  $exm; ?></td>
    						<td><?= isset($admission_det['applicable_fee']) ? $admission_det['applicable_fee'] : '' ?></td>
    						<td><?= isset($admission_det['opening_balance']) ? $admission_det['opening_balance'] : '' ?></td>
    						<td><?= isset($admission_det['totfeepaid']) ? $admission_det['totfeepaid'] : '' ?></td>
    						
    						<?php
    				  if($admission_det['tot_refunds']!='')
    					  {
    					    $actual = $actual + $admission_det['tot_refunds'] ;
    					  }
    					    ?>
    					   <td><?=$admission_det['tot_refunds'] ?></td>
    					   <?
    				
    					  if($admission_det['opening_balance']!='')
    					  
    					  {
    					    $actual = $actual +   $admission_det['opening_balance'];
    					  }
    					  ?> 
    					  
    						<td><?= $pend = $actual - $paid; //isset($minbalance[0]['min_balance']) ? $minbalance[0]['min_balance'] : $admission_details[0]['applicable_fee'] ?></td>
    					
    							<td><?php echo $can_amt = $admission_det['tot_canc']; //$canc_charges[0]['canc_amount'] ?></td>
    							<td><?php echo $can_amt + $pend; //$canc_charges[0]['canc_amount'] ?></td>
    						
    					</tr>
    					
    					<?php
    					$i++;
    					}
    					?>
					 <!--<tr >
					     <td ><?= isset($admission_details[0]['academic_year']) ? $admission_details[0]['academic_year'] : '' ?></td>
    					  <td ><?= isset($admission_details[0]['actual_fee']) ? $admission_details[0]['actual_fee'] : '' ?></td>
    					  <td><?=  $exm; ?></td>
    					  <td><?= isset($admission_details[0]['applicable_fee']) ? $admission_details[0]['applicable_fee'] : '' ?></td>
    					  <td><?= $admission_details[0]['tot_fee_paid']; ?></td>
    					    <?php
    					  if($tot_refunds['rsum']!='')
    					  {
    					    $bal = $bal + $tot_refunds['rsum'];
    					    ?>
    					   <td><?=$admission_details[0]['tot_refunds']?></td>
    					   <?
    					  }
    					  ?> 
    					  <td><?= $admission_details[0]['applicable_fee']-$admission_details[0]['tot_fee_paid']; ?></td>
					</tr>-->
				</tbody>
		    </table>
				  <h3>Installment Details:</h3>
				  <table class="table table-bordered table-hover">
    					<tbody><tr style="background-color:#F5F5F5;">
    					  <th width="5%">S.No</th>
    					   <th width="5%">Academic Year</th>
						  <th width="7%">Paid By</th>
    					  <th width="15%">CHQ/DD/PG <br>Ref No.</th>
						  <th width="28%">Bank Name</th>
    					  <th width="15%">Branch Name</th>
						  <th width="10%">Dated</th>
						  <th width="10%">Amount Paid</th>
						   <th width="15%">Status</th>
						<!--  <th width="10%">Scan Copy</th>-->
    					</tr>
    					 <?php 
    				//	 var_dump($get_feedetails);
    					 
    					 $j=1;
    					 if(count($get_feedetails[0])>0){
    					     for($i=0;$i<count($get_feedetails);$i++)
    					     {
						        ?>
						 <tr>
						   
							<td><?=$j?></td>
								<td><?=$get_feedetails[$i]['academic_year']?></td>
    						<td><?=$get_feedetails[$i]['fees_paid_type']?></td>
							<td><?= isset($get_feedetails[$i]['receipt_no']) ? $get_feedetails[$i]['receipt_no'] : '' ?></td>
							<td><?= $get_feedetails[$i]['bank_name']; ?></td>
							<td><?= isset($get_feedetails[$i]['bank_city']) ? $get_feedetails[$i]['bank_city'] : '' ?></td>
							
						
							
    						<td><?php if($get_feedetails[$i]['fees_date']!=''){echo date('d-m-Y', strtotime($get_feedetails[$i]['fees_date']));}?></td>
    						
    						
    						<td><?= isset($get_feedetails[$i]['amount']) ? $get_feedetails[$i]['amount'] : '' ?></td>
							<td><?php if($get_feedetails[$i]['chq_cancelled']=='Y'){echo "Cancelled";}?></td>
    					</tr>
    				<?php
    					 $j++;    }
    					 
    					 
    					  for($i=0;$i<count($get_refunds);$i++)
    					     {
						        ?>
						 <tr>
						   
							<td><?=$j?></td>
								<td><?=$get_refunds[$i]['academic_year']?></td>
    						<td><?=$get_refunds[$i]['refund_paid_type']?></td>
							<td><?= isset($get_refunds[$i]['receipt_no']) ? $get_refunds[$i]['receipt_no'] : '' ?></td>
							<td><?= $get_refunds[$i]['bank_name']; ?></td>
							<td><?= isset($get_refunds[$i]['bank_city']) ? $get_refunds[$i]['bank_city'] : '' ?></td>
							
						
							
    						<td><?php if($get_refunds[$i]['refund_date']!=''){echo date('d-m-Y', strtotime($get_refunds[$i]['refund_date']));}?></td>
    						
    						
    						<td><?= isset($get_refunds[$i]['amount']) ? $get_refunds[$i]['amount'] : '' ?></td>
							<td>Refund</td>
    					</tr>
    				<?php
    					 $j++;    }
    					 
    					 
    					 
    					 
    					 
    					 
    					 
    					 
    					 
    					 
    					 
    					 
    					 }
    					else
    					{
    					echo '<td colspan="8">Records are not available</td>';
    					}
    				?>
    				  </tbody></table>

				 
					</div>
					
					
				<div class="tab-pane" id="eight">
<h3>Submit documents List</h3>
            <table class="table table-bordered">
				  <tbody><tr>
				  <th>Sr.No.</th>
				  <th>Particulars</th>
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
					
					  <td><?=$doc['created_on']?></td>
					  <td><?php
					  if(!empty($doc)){
					      ?>
					    
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
				  </tbody>
				  </table>
					</div>
             
           </div>
      </div></div>
      <!-- /tabs -->
  
           
    </div>
   
    
    
    </div>
    
  </div>

</div>
			</div>
		</div>
	</div>
	</div>
</div>	


<?php include 'footer.php';?>

<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});
</script>


