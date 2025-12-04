<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>


<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<?php
$student_id=$personal[0]['student_id'];
echo $student_id;
//print_r($personal[0]) ;
//die();
?>

<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="#">Admission Form</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Temporary Admission Form</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-sm-12">&nbsp;</div>
        </div>
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                     <div class="panel-body">

                         <div id="dashboard-recent" class="panel panel-warning">        
                     <div class="panel-heading">
                       <span class="panel-title"><i class="panel-title-icon fa fa-fire text-danger"></i>Details</span>
			    		</div>
                      <div class="row">
					   <div class="form-group">
					   <?php 
					   echo "<span style='color:red;padding-left:110px;'>".@$this->session->flashdata('message1')."</span>";
					   ?>
					 </div>                      
                      </div>
					  <div class="row">
					  <div class="table-responsive">
					  <table class="table table-bordered">
					  <tbody>
					  <!--Step 1-->
					  <tr class="info"><td colspan="4"><label>1.Personal Information</label></td></tr>
					  <tr class="danger"><td colspan="4"><label>Personal Details</label></td></tr>
					  <tr  class="success"><td><label>Student Registration Id</label></td><td><?php echo $personal[0]['student_id']; ?></td>
					  <td><label>Admission Branch & Course</label></td><td><?php echo $personal[0]['admission-course'].' - '.$personal[0]['admission-branch']; ?></td>
					  <tr  class="success"><td><label>Full Name</label></td><td><?php echo ucfirst($personal[0]['fname']).' '.ucfirst($personal[0]['mname']).' '.ucfirst($personal[0]['lname']); ?></td>
					  <td><label>Father Name</label></td><td><?php echo ucfirst($personal[0]['pfname']).' '.ucfirst($personal[0]['pmname']).' '.ucfirst($personal[0]['plname']); ?></td>
					  </tr>
					  <tr  class="success"><td><label>Mother Name</label></td><td><?php echo ucfirst($personal[0]['mothernm']); ?></td>
					  <td><label>Birth Date</label></td><td><?php echo  $personal[0]['dob']; ?></td>
					  </tr>
					  <tr  class="success"><td><label>Gender</label></td><td><?php if($personal[0]['gender']=='M') echo" Male"; elseif($personal[0]['gender']=='F') echo" Female"; else echo "Transegender";?></td>
					  <td><label>Student Mobile No.</label></td><td><?php echo  $personal[0]['mobile']; ?></td>
					  </tr>
					  <tr  class="success"><td><label>Email</label></td><td><?php echo  $personal[0]['email_id'];?></td>
					  <td><label>Nationality</label></td><td><?php echo  $personal[0]['nationality']; ?></td>
					  </tr>
					  <tr  class="success"><td><label>Category</label></td><td><?php echo  $personal[0]['caste'];?></td>
					  <td><label>Religion</label></td><td><?php echo  $personal[0]['religion']; ?></td>
					  </tr>
					  <tr  class="success"><td><label>State Residence</label></td><td><?php echo $personal[0]['res_state'];?></td>
					  <td><label>Aadhar Card No</label></td><td><?php echo  $personal[0]['aadhar_no']; ?></td>
					  </tr>
					  <tr  class="success"><td><label>Hostel(Fill Enclosure I)</label></td><td><?php echo $personal[0]['hostelfacility'];?></td>
					  <td><label>Transport(Fill Enclosure II)</label></td><td><?php echo  $personal[0]['transportfacility']; ?></td>
					  </tr>
					   <tr class="danger"><td colspan="4"><label>Address</label></td></tr>
					  <tr class="success"><td colspan="2"><label>Local Address</label></td><td colspan="2"><label>Permanent Address</label></td>
					  </tr>
					  <tr  class="success"><td><label>HouseNo</label></td><td><?php echo $personal[0]['lhouseno'];?></td>
					  <td><label>HouseNo</label></td><td><?php echo  $personal[0]['phouseno']; ?></td>
					  </tr>
					  <tr  class="success"><td><label>Street</label></td><td><?php echo $personal[0]['lstreet'];?></td>
					  <td><label>Street</label></td><td><?php echo  $personal[0]['pstreet']; ?></td>
					  </tr>
					  <tr  class="success"><td><label>City</label></td><td><?php echo $personal[0]['lcity'];?></td>
					  <td><label>City</label></td><td><?php echo  $personal[0]['pcity']; ?></td>
					  </tr>
					  <tr  class="success"><td><label>State</label></td><td><?php echo $personal[0]['lstate'];?></td>
					  <td><label>State</label></td><td><?php echo  $personal[0]['pstate']; ?></td>
					  </tr>
					   <tr  class="success"><td><label>Country</label></td><td><?php echo $personal[0]['lcountry'];?></td>
					  <td><label>Country</label></td><td><?php echo  $personal[0]['pcountry']; ?></td>
					  </tr>
					   <tr  class="success"><td><label>Postcode</label></td><td><?php echo $personal[0]['lpostal'];?></td>
					  <td><label>Postcode</label></td><td><?php echo  $personal[0]['ppostal']; ?></td>
					  </tr>
					  <tr class="danger"><td colspan="4"><label>Guardian's Details</label></td></tr>
					  <tr  class="success"><td><label>Guardian Name</label></td><td><?php echo ucfirst($personal[0]['gfname']).ucfirst($personal[0]['gmname']).ucfirst($personal[0]['glname']);?></td>
					  <td><label>Relationship</label></td><td><?php echo  $personal[0]['grelationship']; ?></td>
					  </tr>
					   <tr  class="success"><td><label>Occupation</label></td><td><?php echo $personal[0]['goccupation'];?></td>
					  <td><label>Annual Income</label></td><td><?php echo  $personal[0]['gannual_income'].'Rs.'; ?></td>
					  </tr>
					   <tr  class="success"><td><label>E-Mail</label></td><td><?php echo $personal[0]['gparent_email'];?></td>
					  <td><label>Mobile No.</label></td><td><?php echo  $personal[0]['gparent_mobile']; ?></td>
					  </tr>
					  <tr  class="success"><td><label>LandLine</label></td><td><?php echo $personal[0]['gparent_phone'];?></td>
					  <td><label>Address</label></td><td><?php echo  $personal[0]['gparent_address']; ?></td>
					  </tr>
					  <!--Step 2-->
					   <tr class="info"><td colspan="4"><label>2.Educational Details</label></td></tr>
					   <tr class="danger"><td colspan="4"><label>Qualifying exam Details</label></td></tr>
					  <tr  class="success"><td><label>Exam Name</label></td><td><?php echo $qualiexam[0]['qexam_name'];?></td>
					  <td><label>Passing Year </label></td><td><?php  echo $qualiexam[0]['qexam_pyear']; ?></td>
					  </tr> 
					  <tr  class="success"><td><label>College Name</label></td><td><?php echo $qualiexam[0]['qexam_colleg'];?></td>
					  <td><label>Admission Basis </label></td><td><?php  echo $qualiexam[0]['adm_basis']; ?></td>
					  </tr>
					  <tr  class="success"><td><label>Exam RollNo</label></td><td><?php echo $qualiexam[0]['qexam_roll'];?></td>
					  <td><label>Exam Rank</label></td><td><?php  echo $qualiexam[0]['qexam_rank']; ?></td>
					  </tr>
					<tr class="danger"><td colspan="4"><label>Academic Details</label></td></tr>
					<tr class="success"><td colspan="4"><table class="table table-bordered" >
<tr class="success"><th>Exam Name</th><th>School/College</th><th>Passing Year</th><th>Seat No.</th>
<th>Board/University</th><th>Marks Obtained</th><th>Marks Out of</th><th>%</th></tr>	
					<?php foreach($education as $key=>$val){?>
					
<tr class="success"></td><td><?php  echo $education[$key]['exam_id'];?></td>
					  <td><?php echo $education[$key]['college_name'];?></td>
					  <td><?php echo $education[$key]['pass_year'];?></td>
					  <td><?php echo $education[$key]['seat_no'];?></td>
					  <td><?php echo $education[$key]['institute_name'];?></td>
					  <td><?php echo $education[$key]['marks_obtained'];?></td>
					  <td><?php echo $education[$key]['marks_outof'];?></td>
					  <td><?php echo $education[$key]['percentage'];?></td>
					</tr>
					<?php } ?>
					</table ></tr>
				<tr class="danger"><td colspan="4"><label>Mark Details</label></td></tr>
                   <tr  class="success"><td><label>ssc_passing_date</label></td><td><?php echo $qualiexam[0]['ssc_passing_dt'];?></td>
					  <td><label>Marks Obtained English</label></td><td><?php echo $qualiexam[0]['sobt_eng'].' <strong>out of</strong> '.$qualiexam[0]['stotal_eng'];?></td>
					</tr>
					<tr  class="success"><td><label>Hsc_passing_date</label></td><td><?php echo $qualiexam[0]['hscpass_date'];?></td>
					  <td><label>Marks Obtained Physics</label></td><td><?php echo $qualiexam[0]['hobt_phy'].' <strong>out of</strong> '.$qualiexam[0]['htotal_phy'];?></td>
					</tr>
					<tr  class="success"><td><label>Marks Obtained Chemistry</label></td><td><?php echo $qualiexam[0]['hobt_chem'].' <strong>out of</strong> '.$qualiexam[0]['htotal_chem'];?></td>
					<td><label>Marks Obtained Biology</label></td><td><?php echo $qualiexam[0]['hobt_bio'].' <strong>out of</strong> '.$qualiexam[0]['htotal_bio'];?></td>
					</tr>
					<tr  class="success"><td><label>Marks Obtained English</label></td><td colspan="3"><?php echo $qualiexam[0]['hobt_eng'].' <strong>out of</strong> '.$qualiexam[0]['htotal_eng'];?></td>
					</tr>
					<!--Step 3-->
					 <tr class="info"><td colspan="4"><label>3.Documents & Certificates List</label></td></tr>
					   <tr class="danger"><td colspan="4"><label>List Of Documents To Be Submitted</label></td></tr>
              <tr class="success"><td colspan="4"><table class="table table-bordered" >
<tr class="success"><th>Document No</th><th>Document Name</th><th>Applicable</th><th>O/X</th><th>Remark</th><th>Submission Date(if pending)</th></tr>				 
					  <?php
					foreach($document as $key=>$val){?>
					
					<tr class="success"></td><td><?php echo $document[$key]['doc_id'];?></td><?php
					$nm=$this->Admission_model->getdocumentNameById($document[$key]['doc_id']);
					 ?>
					<td><?php echo $nm[0]['document_name'];?></td>
					  <td><?php echo $document[$key]['doc_applicable'];?></td>
					  <td><?php echo $document[$key]['ox'];?></td>
					  <td><?php echo $document[$key]['remark'];?></td>
					  <td colspan="3"><?php if($document[$key]['remark']=="pending")echo $document[$key]['sub_dt'];?></td>
					</tr>
					<?php } ?>
					</table></td>
					</tr>
					<tr class="danger"><td colspan="4"><label>Certificate Details</label></td></tr>
					<tr class="success"><td colspan="4"><table class="table table-bordered" >
<tr class="success"><th>Certificate Name</th><th>Certificate No</th><th>Issue Date</th><th>Validity</th></tr>				 
					  <?php
					foreach($certificate as $key=>$val){?>
					
					<tr class="success"></td><td><?php echo $certificate[$key]['certificate_name'];?></td>
					  <td><?php echo $certificate[$key]['certificate_no'];?></td>
					  <td><?php echo $certificate[$key]['cissue_dt'];?></td>
					  <td><?php echo $certificate[$key]['cvalidity'];?></td>
					</tr>
					<?php } ?>
					</table >
					</tr>
					<!--Step 4-->
					<tr class="info"><td colspan="4"><label>4.Refernces </label></td></tr>
					<tr class="danger"><td colspan="4"><label>Refernces details</label></td></tr>
					<tr class="success"><td colspan="4"><label>References(Other than Blood Relatives)</label></td></tr>
					<tr  class="success"><td><label>Reference Name1</label></td><td><?php echo $references[0]['for_stud_refer_name1'];?></td>
					  <td><label>Reference Contact1</label></td><td><?php echo $references[0]['for_stud_refer_cont1'];?></td>
					</tr>
					<tr  class="success"><td><label>Reference Name2</label></td><td><?php echo $references[0]['for_stud_refer_name2'];?></td>
					  <td><label>Reference Contact2</label></td><td><?php echo $references[0]['for_stud_refer_cont2'];?></td>
					</tr>
					<tr class="success"><td colspan="4"><label>Are you related to any person employed with Sandip University(Y/N):</label><?php if($references[0]['ex_emp_rel']=='Y')echo 'Yes';else echo 'No';?></td></tr>
                     <?php if($references[0]['ex_emp_rel']=='Y'){ ?>
					 <tr  class="success"><td><label>Name</label></td><td><?php echo $references[0]['ex_emp_rname'];?></td>
					  <td><label>Designation</label></td><td><?php echo $references[0]['ex_emp_rdesig'];?>
					</tr>
					 <tr  class="success"><td><label>Relationship</label></td><td colspan="3"><?php echo $references[0]['ex_emp_relat'];?></td></tr>
					 <?php } ?>	
                    <tr class="success"><td colspan="4"><label>Are you related to Alumini of Sandip University(Y/N):</label><?php if($references[0]['alumini_rel']=='Y')echo 'Yes';else echo 'No';?></td></tr>
                     <?php if($references[0]['alumini_rel']=='Y'){ ?>
					 <tr  class="success"><td><label>Name</label></td><td><?php echo $references[0]['alumini_rel_name'];?></td>
					  <td><label>Passing Year</label></td><td><?php echo $references[0]['alumini_rel_passyear'];?>
					</tr>
					 <tr  class="success"><td><label>Relationship</label></td><td colspan="3"><?php echo $references[0]['alumini_relat'];?></td></tr>
					 <?php } ?>	
                    <tr class="success"><td colspan="4"><label>Are your relatives studying in Sandip University(Y/N):</label><?php if($references[0]['rel_stud_san']=='Y')echo 'Yes';else echo 'No';?></td></tr>
                     <?php if($references[0]['rel_stud_san']=='Y'){ ?>
					 <tr  class="success"><td><label>Name</label></td><td><?php echo $references[0]['rel_stud_san_name'];?></td>
					  <td><label>Course</label></td><td><?php echo $references[0]['rel_stud_san_course'];?>
					</tr>
					 <tr  class="success"><td><label>Relationship</label></td><td colspan="3"><?php echo $references[0]['rel_stud_san_relat'];?></td></tr>
					 <?php } ?>	
					 <?php if($references[0]['ref_bystud_name']!=""||$references[0]['ref_bystud_cont']!=""||$references[0]['ref_bystud_email']!=""||$references[0]['ref_bystud_relat']!=""||$references[0]['ref_bystud_area']!=""){?>
                     <tr class="danger"><td colspan="4"><label>The Reference of the candidate who may be interested to pursue academic program in sandip university:</label></td></tr>	
                      <tr  class="success"><td><label>Name</label></td><td><?php echo $references[0]['ref_bystud_name'];?></td>
					  <td><label>Contact</label></td><td><?php echo $references[0]['ref_bystud_cont'];?>
					  </tr>
					  <tr  class="success"><td><label>Email Id</label></td><td><?php echo $references[0]['ref_bystud_email'];?></td>
					  <td><label>Relation with Candidate</label></td><td><?php echo $references[0]['ref_bystud_relat'];?>
					  </tr>
					  <tr class="success"><td><label>Area Of Interest</label></td><td colspan="3"><?php echo $references[0]['ref_bystud_area'];?></td></tr>
					 <?php } ?>
                     <!--Step 5-->
					<tr class="info"><td colspan="4"><label>5.Payment Details & Photo</label></td></tr>
					<tr class="danger"><td colspan="4"><label>Payment Details</label></td></tr>
<tr class="success"><td colspan="4"><table class="table table-bordered" >
<tr class="success"><th>Particulars</th><th>Applicable Fee</th><th>Ammount Paid</th><th>Balance(if any)</th><th>Payment particulars</th></tr>				 
<tr class="success"><td>Admission Form/prospectus Fee(Not to pay if already paid)</td><td><?php echo $fee[0]['formfeeappli'];?></td>
					  <td><?php echo $fee[0]['formfeepaid'];?></td>
					  <td><?php echo $fee[0]['formfeebal'];?></td>
					  <td rowspan="4">Payment of Rs.<strong><?php echo $fee[0]['totalfeepaid'];?></strong> made<br><br>through CashRecipt/DD No.
					  <strong><?php echo $fee[0]['dd_no'];?></strong><br><br>Dated <strong><?php echo $fee[0]['dd_drawn_date'];?></strong>
					  <br><br>drawn On <strong><?php echo $fee[0]['dd_drawn_bank_branch'];?></strong>
					 </td>
					</tr>
<tr class="success"><td>Tution Fee</td><td><?php echo $fee[0]['tutionfeeappli'];?></td>
					  <td><?php echo $fee[0]['tutionfeepaid'];?></td>
					  <td><?php echo $fee[0]['tutionfeebal'];?></td>
					 
					</tr>
<tr class="success"><td>Other Fee</td><td><?php echo $fee[0]['otherfeeappli'];?></td>
					  <td><?php echo $fee[0]['otherfeepaid'];?></td>
					  <td><?php echo $fee[0]['otherfeebal'];?></td>
					 
					</tr>
<tr class="success"><td>Total</td><td><?php echo $fee[0]['totalfeeappli'];?></td>
					  <td><?php echo $fee[0]['totalfeepaid'];?></td>
					  <td><?php echo $fee[0]['totalfeebal'];?></td>
					 
					</tr>
			
					</table></td>
					</tr>
<?php if($fee[0]['bank_name']!=""){?>					
			<tr  class="success"><td><label>Bank Name</label></td><td><?php echo $fee[0]['bank_name'];?></td>
			<td><label>Account No.</label></td><td><?php echo $fee[0]['account_no'];?></td>
		   </tr>
		   <tr  class="success"><td><label>Bank IFSC Code</label></td><td colspan="3"><?php echo $fee[0]['ifsc'];?></td></tr>
<?php } ?>						
<tr class="danger"><td colspan="4"><label>Student Photo</label></td></tr>
<tr class="success"><td colspan="4"><img src="<?php echo base_url().'uploads/student_profilephotos/'.$fee[0]['profile_img'];?>" width="100" height="100" border="1px solid black"></td></tr>			
			</tbody>
                      </table>	
                      </div>
  <div class="form-group">
                                    <div class="col-sm-4"></div>
                                    <div class="col-sm-2">
                                        <button class="btn btn-primary form-control" id="btn_submit" type="submit" onClick="document.location.href='<?php echo base_url().'admission/form?s='.$student_id;?>'" >Update</button>                                        
                                    </div> 
                                    <div class="col-sm-2">
                                        <button class="btn btn-primary form-control" id="btn_submit" type="submit" onClick="document.location.href='<?php echo base_url().'admission/cancel_all_sessions'?>'" >Confirm</button>                                        
                                    </div> 									

				           </div>					  
					  </div>
				
					                   
                               
                   </div>
                </div>
            </div>    
        </div>
    </div>
</div>
</div>