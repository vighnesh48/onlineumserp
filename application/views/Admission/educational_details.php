<script src="<?= base_url('assets/javascripts') . '/bootstrap-datepicker.js' ?> "></script>
<link href="<?= site_url() ?>assets/css/pick.css" rel="stylesheet" type="text/css" />
<script src="<?= site_url() ?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<script type="text/javascript">
   <!--
   function copyBilling (f) {
       var s, i = 0;
       if(f.same.checked == true) {
   
       while (s = ['A', 'B', 'C', 'D', 'country', 'pc'][i++]) {f.elements['shipping_' + s].value = f.elements['bill_' + s].value};
       }
       if(f.same.checked == false) {
       // alert(false);
       while (s = ['A', 'B', 'C', 'D', 'country', 'pc'][i++]) {f.elements['shipping_' + s].value ="";};
       }
   }
   // -->
</script>
<div id="content-wrapper">
<ul class="breadcrumb breadcrumb-page">
   <div class="breadcrumb-label text-light-gray">You are here: </div>
   <li><a href="#">Masters</a></li>
   <li class="active"><a href="#">Admission Form</a></li>
</ul>
<div class="page-header">
   <div class="row">
      <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Admission Form</h1>
      <div class="col-xs-12 col-sm-8">
         <div class="row">
            <hr class="visible-xs no-grid-gutter-h">
         </div>
      </div>
   </div>
   <div class="row ">
      <div class="col-sm-12">
         <div class="panel">
            <div class="panel-body">
               <div class="xtable-info">
                  <div id="dashboard-recent" class="panel panel-warning">
                     <?php include 'stepbar.php';?>
                     <div class="tab-content">
                        <form id="upload_form" method="post" action="<?=base_url()?>Ums_admission/updateEducation" enctype="multipart/form-data">
						<!--start  of educational-details -->
                        <div id="errors" style="color:red;"></div>
                  <div id="educational-details" class="setup-content widget-comments panel-body tab-pane ">
                    <h3></h3>
				
                    <input type="hidden" name="reg_id" value="<?= $this->session->userdata('studId') ?>">
                    <input type="hidden" name="step1statusval" value="<?= $this->session->userdata('stepfirst_status') ?>">
                     
                    <div class="panel">
                      <div class="panel-heading">Academic Details
                        <?= $astrik ?>
                     </div>
                      <div class="panel-body">
                        <div class="xxpanel-padding no-padding-vr">
                          <div class="xxtable-primary">
                            <!--<div class="table-header" style="xwidth:97%!important">
                              <div class="table-caption"> Educational Background </div>
                            </div>-->
                            <div class="table-responsive">
                              <table id="eduDetTable" class="table table-bordered edu-table">
                                <thead>
                                  <tr>
                                    <th>Qualification</th>
                                    <th>Stream</th>
                                    <th>Specialization</th>
                                    <th>Board/University</th>
                                    
                                    <th width="11%">Passing Year</th>
                                    <th>Marks Obtained</th>
                                    <th>Marks Out of</th>
                                    <th>Percentage</th>
                                    <th>Docs</th>
                                    <th>Action</th>
                                  </tr>
                                </thead>
                                <tbody>
								<?php
								$j=10;
									if(!empty($qual)){
										foreach($qual as $var){
										
								?>
								<tr id="firsttr">
                                    <td> <div class="form-group">
                                        <select name="exam_id[]" id="studqual_<?=$j?>" class="squal form-control" onchange="qualifcation(this.id)">
                                        <option value="">Select</option>
                                        <option value="SSC" <?php if(!empty($var['degree_type']) && $var['degree_type']=='SSC'){ echo "selected";}?>>SSC</option>
                                        <option value="HSC" <?php if(!empty($var['degree_type']) && $var['degree_type']=='HSC'){ echo "selected";}?>>HSC</option>
                                        <option value="Graduation" <?php if(!empty($var['degree_type']) && $var['degree_type']=='Graduation'){ echo "selected";}?>>Graduation</option>
                                        <option value="Post Graduation" <?php if(!empty($var['degree_type']) && $var['degree_type']=='Post Graduation'){ echo "selected";}?>>Post Graduation's</option>
                                        <option value="Diploma" <?php if(!empty($var['degree_type']) && $var['degree_type']=='Diploma'){ echo "selected";}?>>Diploma</option>
                                      </select>
                                        </div>  
                                    </td>
                                    <td> 
                                    <select name="stream_name[]" id="stream_name_<?=$j?>" onchange="strmsubject(this.id)" style="width:85px" class="form-control">
                                        <option value="">Select</option>
										<option value="<?=$var['degree_name']?>" selected><?=$var['degree_name']?></option>
                                      </select>
                                        
                                    </td>
                                   
                                    <td><div class="form-group">
										<input type="hidden" name="qual_id[]" class="form-control" value="<?= isset($var['qual_id']) ? $var['qual_id'] : '' ?>" placeholder="Specialization"  />
                                        <input type="text" name="seat_no[]" class="form-control" value="<?= isset($var['specialization']) ? $var['specialization'] : '' ?>" placeholder="Specialization"  /></td>
                                        </div>
                                    <td><input type="text" name="institute_name[]" class="form-control" value="<?= isset($var['board_uni_name']) ? $var['board_uni_name'] : '' ?>" placeholder="Name of Board/University" /></td>
                                    <td><select name="pass_year[]" class="form-control" required>
                                        <option value="">Year</option>
<?php
    $student_id = $this->session->userdata('studId');                           
    $student_year = getStudentYear($student_id);
    for ($y = date("Y"); $y >= date("Y") - 60; $y--) {
		$year = explode("-",$var['passing_year']);
		//echo $year[1];exit;
		if($y==$year[1]){
			$sel = "selected";
		}else{
			$sel="";
		}

        echo '<option value="' . $y . '" '.$sel.'>' . $y . '</option>';
    }
?>
                                     </select>
                                      <select name="pass_month[]" class="form-control" >
                                        <option value="">Month</option>
                                        <option value="JAN" <?php if(!empty($year[0]) && $year[0]=='JAN'){ echo "selected";}?>>JAN</option>
                                        <option value="FEB" <?php if(!empty($year[0]) && $year[0]=='FEB'){ echo "selected";}?>>FEB</option>
                                        <option value="MAR" <?php if(!empty($year[0]) && $year[0]=='MAR'){ echo "selected";}?>>MAR</option>
                                        <option value="APR" <?php if(!empty($year[0]) && $year[0]=='APR'){ echo "selected";}?>>APR</option>
                                        <option value="MAY" <?php if(!empty($year[0]) && $year[0]=='MAY'){ echo "selected";}?>>MAY</option>
                                        <option value="JUN" <?php if(!empty($year[0]) && $year[0]=='JUN'){ echo "selected";}?>>JUN</option>
                                        <option value="JUL" <?php if(!empty($year[0]) && $year[0]=='JUL'){ echo "selected";}?>>JUL</option>
                                        <option value="AUG" <?php if(!empty($year[0]) && $year[0]=='AUG'){ echo "selected";}?>>AUG</option>
                                        <option value="SEP" <?php if(!empty($year[0]) && $year[0]=='SEP'){ echo "selected";}?>>SEPT</option>
                                        <option value="OCT" <?php if(!empty($year[0]) && $year[0]=='OCT'){ echo "selected";}?>>OCT</option>
                                        <option value="NOV" <?php if(!empty($year[0]) && $year[0]=='NOV'){ echo "selected";}?>>NOV</option>
                                        <option value="DEC" <?php if(!empty($year[0]) && $year[0]=='DEC'){ echo "selected";}?>>DEC</option>
                                      </select></td>
                                    <td><input type="text" name="marks_obtained[]" class="form-control numbersOnly" value="<?= isset($var['total_marks']) ? $var['total_marks'] : '' ?>" required/></td>
                                    <td><input type="text" name="marks_outof[]" class="form-control numbersOnly" value="<?= isset($var['out_of_marks']) ? $var['out_of_marks'] : '' ?>" placeholder="" required/></td>
                                    <td><input type="text" name="percentage[]" class="form-control" value="<?= isset($var['percentage']) ? $var['percentage'] : '' ?>" placeholder="" required/></td>
                                     <td><input type="file" name="sss_doc[]" id="sss_doc" style="width:80px" class="userfile" onchange="validatefile()" > <br><a href="<?= site_url() ?>Upload/get_document/<?=$var['file_path'];?>?b_name=uploads/student_document/<?php echo $student_year.'/'; ?>" target="_blank"> <?= isset($var['file_path']) ? $var['file_path'] : '' ?></a></td>
                                     
                                   <td></td>
                                  </tr>
								<?php $j++;}
									}
										?>
                                 <tr id="firsttr">
                                    <td> <div class="form-group">
                                        <select name="exam_id[]" id="studqual_1" class="squal form-control" onchange="qualifcation(this.id)" >
                                        <option value="">Select</option>
                                        <option value="SSC">SSC</option>
                                        <option value="HSC">HSC</option>
                                        <option value="Graduation">Graduation</option>
                                        <option value="Post Graduation">Post Graduation's</option>
                                        <option value="Diploma">Diploma</option>
                                      </select>
                                        </div>  
                                    </td>
                                    <td> 
                                    <select name="stream_name[]" id="stream_name_1" onchange="strmsubject(this.id)" style="width:85px" class="form-control" >
                                        <option value="">Select</option>
                                    
                                      </select>
                                        
                                    </td>
                                   
                                    <td><div class="form-group">
                                        <input type="text" name="seat_no[]" class="form-control" value="<?= isset($_REQUEST['seat_no']) ? $_REQUEST['seat_no'] : '' ?>" placeholder="Specialization"  /></td>
                                        </div>
                                    <td><input type="text" name="institute_name[]" class="form-control" value="<?= isset($_REQUEST['institute_name']) ? $_REQUEST['institute_name'] : '' ?>" placeholder="Name of Board/University" /></td>
                                    <td><select name="pass_year[]" class="form-control">
                                        <option value="">Year</option>
                                        <?php
    for ($y = date("Y"); $y >= date("Y") - 60; $y--) {
        echo '<option value="' . $y . '">' . $y . '</option>';
    }
?>
                                     </select>
                                      <select name="pass_month[]" class="form-control">
                                        <option value="">Month</option>
                                        <option value="JAN">JAN</option>
                                        <option value="FEB">FEB</option>
                                        <option value="MAR">MAR</option>
                                        <option value="APR">APR</option>
                                        <option value="MAY">MAY</option>
                                        <option value="JUN">JUN</option>
                                        <option value="JUL">JUL</option>
                                        <option value="AUG">AUG</option>
                                        <option value="SEP">SEPT</option>
                                        <option value="OCT">OCT</option>
                                        <option value="NOV">NOV</option>
                                        <option value="DEC">DEC</option>
                                      </select></td>
                                    <td><input type="text" name="marks_obtained[]" class="form-control numbersOnly" value="<?= isset($_REQUEST['marks_obtained']) ? $_REQUEST['marks_obtained'] : '' ?>" /></td>
                                    <td><input type="text" name="marks_outof[]" class="form-control numbersOnly" value="<?= isset($_REQUEST['marks_outof']) ? $_REQUEST['marks_outof'] : '' ?>" placeholder=""/></td>
                                    <td><input type="text" name="percentage[]" class="form-control" value="<?= isset($_REQUEST['percentage']) ? $_REQUEST['percentage'] : '' ?>" placeholder="" /></td>
                                     <td><input type="file" name="sss_doc[]" id="sss_doc" style="width:80px"></td>
                                    <td><input type="button" class="btn btn-xs btn-primary btn-flat" id="addmore" value="Add More" name="addMore" />
                                      <input type="button" class="btn btn-xs btn-danger btn-flat" id="remove" value="Remove" name="remove" /></td>
                                  </tr>

                               </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!--<div class="panel">
                      <div class="panel-heading">Marks Detail</div>
                      <div class="panel-body">
                        <table class="table table-bordered">
                          <tr>
                            <th>Exam</th>
                            <th>Subject</th>
                            <th>Marks Obtained</th>
                            <th>Total Marks</th>
                            <th>Passing Year</th>
                           
                          </tr>
                         <?php 
						 if(!empty($subjects)){
							foreach($subjects as $sub){
							$dgree[] = $sub['degree_type'];
							 if($sub['degree_type']=='SSC'){
						?>
							<tr>
                            <td><label><?=$sub['degree_type']?></label></td>
                            <td><label><?=$sub['sub_sem_name']?></label></td>
                            <td><input type="text" id="tssc_eng" class="numbersOnly" name="tssc_eng" value="<?= isset($sub['marks_obt']) ? $sub['marks_obt'] : '' ?>" >
								<input type="hidden" id="sub_id" class="numbersOnly" name="sub_id" value="<?= isset($sub['id']) ? $sub['id'] : '' ?>" >
								<input type="hidden" id="sub_qual_id[]" class="numbersOnly" name="sub_qual_id" value="<?= isset($sub['qual_id']) ? $sub['qual_id'] : '' ?>" >
                              </td>
                            <td><input type="text" id="ossc_eng" name="ossc_eng" class="numbersOnly" value="<?= isset($sub['marks_outof']) ? $sub['marks_outof'] : '' ?>" ></td>
                            <td>
                              <div class="input-group date" id="doc-sub-datepicker_ssc">
                                <input type="text" id="sscpass_date" name="sscpass_date" value="<?= isset($sub['passing_year']) ? $sub['passing_year'] : '' ?>" placeholder="yyyy-mm-dd">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span> </div></td>
                               
                           </tr>
                        <?php
							 } if(($sub['degree_type']=='HSC') && ($sub['degree_name'] =='Arts' || $sub['degree_name'] =='Commerce')){
								 //echo "hello";
								 ?>
							<tr class="121th eng1">
                            <td rowspan="1" class='12eng'>12th(Intermediate)or Equivalent</td>
                            <td><label>English</label></td>
                            <td>
							<input type="hidden" id="sub_id" class="numbersOnly" name="hsub_id" value="<?= isset($sub['id']) ? $sub['id'] : '' ?>" >
							<input type="hidden" id="sub_qual_id" class="numbersOnly" name="hsub_qual_id" value="<?= isset($sub['qual_id']) ? $sub['qual_id'] : '' ?>" >
							<input type="text" id="thsc_eng" class="numbersOnly" value="<?= isset($sub['marks_obt']) ? $sub['marks_obt'] : '' ?>" name="thsc_eng">
                                </td>
                            <td><input type="text" id="ohsc_eng" class="numbersOnly" name="ohsc_eng" value="<?= isset($sub['marks_outof']) ? $sub['marks_outof'] : '' ?>">
                                </td>
                            <td>
                                <div class="input-group date" id="doc-sub-datepicker_hsc">
                                <input data-bv-field="slname" type="text" id="hscpass_date" name="hscpass_date" value="<?= isset($sub['passing_year']) ? $sub['passing_year'] : '' ?>" placeholder="yyyy-mm-dd">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span> </div>
                            </td>
                                
                          </tr>
						<?php
						}else if($sub['degree_type']=='HSC' && $sub['degree_name'] =='Science'){
						if($sub['sub_sem_name'] =='English'){
						?>						
						<tr class="121th eng1">
                            <td rowspan="1" class='12eng'>12th(Intermediate)or Equivalent</td>
                            <td><label>English</label>
							<input type="hidden" id="hesub_name" class="numbersOnly" name="hsc_eng" value="<?=$sub['sub_sem_name']?>"></td>
                            <td>
							<input type="hidden" id="sub_id" class="numbersOnly" name="hesub_id" value="<?= isset($sub['id']) ? $sub['id'] : '' ?>" >
							<input type="hidden" id="sub_qual_id" class="numbersOnly" name="hesub_qual_id" value="<?= isset($sub['qual_id']) ? $sub['qual_id'] : '' ?>" >
							<input type="text" id="thsc_eng" class="numbersOnly" value="<?= isset($sub['marks_obt']) ? $sub['marks_obt'] : '' ?>" name="thsc_eng">
                                </td>
                            <td><input type="text" id="ohsc_eng" class="numbersOnly" name="ohsc_eng" value="<?= isset($sub['marks_outof']) ? $sub['marks_outof'] : '' ?>">
                                </td>
                            <td>
                                <div class="input-group date" id="doc-sub-datepicker_hsc">
                                <input data-bv-field="slname" type="text" id="hscpass_date" name="hscpass_date" value="<?= isset($sub['passing_year']) ? $sub['passing_year'] : '' ?>" placeholder="yyyy-mm-dd">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span> </div>
                            </td>
                                
                          </tr>
						
						<?php
						}
							if($sub['sub_sem_name'] =='Physics'){
							?>
						   <tr class="121th sci1">
						   <td><label><?=$sub['degree_type']?></label></td>
                            <td><label><?=$sub['sub_sem_name']?></label>
							<input type="hidden" id="sub_name" class="numbersOnly" name="hsc_phy" value="<?=$sub['sub_sem_name']?>">
							</td>
                            
                            <td><input type="hidden" id="sub_id" class="numbersOnly" name="hpsub_id" value="<?= isset($sub['id']) ? $sub['id'] : '' ?>" >
							<input type="hidden" id="sub_qual_id" class="numbersOnly" name="hpsub_qual_id" value="<?= isset($sub['qual_id']) ? $sub['qual_id'] : '' ?>" >
							<input type="text" id="thsc_phy" class="numbersOnly" value="<?= isset($sub['marks_obt']) ? $sub['marks_obt'] : '' ?>" name="thsc_phy"></td>
                            <td><input type="text" id="ohsc_phy" class="numbersOnly"  value="<?= isset($sub['marks_outof']) ? $sub['marks_outof'] : '' ?>" name="ohsc_phy"></td>
							<td>

                            </td>
                          </tr>
						  <?php } if($sub['sub_sem_name'] =='Chemistry'){?>
                          <tr class="121th sci1">
                            <td><label><?=$sub['degree_type']?></label></td>
                            <td><label><?=$sub['sub_sem_name']?></label>
							<input type="hidden" id="hesub_name" class="numbersOnly" name="hsc_chem" value="<?=$sub['sub_sem_name']?>">
							</td>
                            <td><input type="hidden" id="sub_id" class="numbersOnly" name="hcsub_id" value="<?= isset($sub['id']) ? $sub['id'] : '' ?>" >
							<input type="hidden" id="sub_qual_id" class="numbersOnly" name="hcsub_qual_id" value="<?= isset($sub['qual_id']) ? $sub['qual_id'] : '' ?>" >
							<input type="text" id="thsc_chem" class="numbersOnly" value="<?= isset($sub['marks_obt']) ? $sub['marks_obt'] : '' ?>" name="thsc_chem"></td>
                            <td><input type="text" id="ohsc_chem" class="numbersOnly" name="ohsc_chem" value="<?= isset($sub['marks_outof']) ? $sub['marks_outof'] : '' ?>"></td>
                          </tr>
						  <?php } if($sub['sub_sem_name'] =='Maths'){?>
						  <tr class="121th sci1">
                            <td><label><?=$sub['degree_type']?></label></td>
                            <td><label><?=$sub['sub_sem_name']?></label>
							<input type="hidden" id="hesub_name" class="numbersOnly" name="hsc_maths" value="<?=$sub['sub_sem_name']?>"></td>
                            <td><input type="hidden" id="sub_id" class="numbersOnly" name="hmsub_id" value="<?= isset($sub['id']) ? $sub['id'] : '' ?>" >
							<input type="hidden" id="sub_qual_id" class="numbersOnly" name="hmsub_qual_id" value="<?= isset($sub['qual_id']) ? $sub['qual_id'] : '' ?>" >
							<input type="text" id="thsc_maths" value="<?= isset($sub['marks_obt']) ? $sub['marks_obt'] : '' ?>" name="thsc_maths"></td>
                            <td><input type="text" id="ohsc_maths" name="ohsc_maths" value="<?= isset($sub['marks_outof']) ? $sub['marks_outof'] : '' ?>" ></td>
                          </tr>
						  
						  <?php } if($sub['sub_sem_name'] =='Biology'){?>
                          <tr class="121th sci1">
                            <td><label><?=$sub['degree_type']?></label></td>
                            <td><label><?=$sub['sub_sem_name']?></label>
							<input type="hidden" id="hesub_name" class="numbersOnly" name="hsc_bio" value="<?=$sub['sub_sem_name']?>"></td>
                            <td><input type="hidden" id="sub_id" class="numbersOnly" name="hbsub_id" value="<?= isset($sub['id']) ? $sub['id'] : '' ?>" >
							<input type="hidden" id="sub_qual_id" class="numbersOnly" name="hbsub_qual_id" value="<?= isset($sub['qual_id']) ? $sub['qual_id'] : '' ?>" >
							<input type="text" id="thsc_bio" class="numbersOnly" value="<?= isset($sub['marks_obt']) ? $sub['marks_obt'] : '' ?>" name="thsc_bio"></td>
                            <td><input type="text" id="ohsc_bio" class="numbersOnly" name="ohsc_bio" value="<?= isset($sub['marks_outof']) ? $sub['marks_outof'] : '' ?>" ></td>
                          </tr>
						
						<?php 
						  }
						}	
							if($sub['degree_type']=='Diploma'){
							if($sub['sub_sem_name'] =='Sem 1'){
						?>
							<tr class='diploama11'>
                            <td><label>Diploma</label></td>
                            <td><label>Sem 1</label>
							<input type="hidden" id="hesub_name" class="numbersOnly" name="sem1" value="<?=$sub['sub_sem_name']?>">
							</td>
                            <td>
							<input type="hidden" id="sub_id" class="numbersOnly" name="sem1_id" value="<?= isset($sub['id']) ? $sub['id'] : '' ?>" >
							<input type="hidden" id="sub_qual_id" class="numbersOnly" name="sem1sub_qual_id" value="<?= isset($sub['qual_id']) ? $sub['qual_id'] : '' ?>" >
							<input  type="text" id="tdsem1_eng" class="numbersOnly" name="tdsem1_eng" value="<?= isset($sub['marks_obt']) ? $sub['marks_obt'] : '' ?>" >
                              </td>
                            <td><input  type="text" id="odsem1_eng" class="numbersOnly" name="odsem1_eng" value="<?= isset($sub['marks_outof']) ? $sub['marks_outof'] : '' ?>" ></td>
                            <td>
                              <div class="input-group date" id="doc-sub-datepicker_ssc">
                                <input  type="text" id="dsem1pass_date" name="dsem1pass_date" value="<?= isset($sub['passing_year']) ? $sub['passing_year'] : '' ?>" placeholder="yyyy-mm-dd">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span> </div>
                            </td>
                           
                            </tr>
							<?php } if($sub['sub_sem_name'] =='Sem 2'){?>
                            
                            <tr class='diploama11'>
                            <td></td>
                            <td><label>Sem 2</label>
							<input type="hidden" id="" class="numbersOnly" name="sem2" value="<?=$sub['sub_sem_name']?>">
							</td>
                            <td>
							<input type="hidden" id="sub_id" class="numbersOnly" name="sem2_id" value="<?= isset($sub['id']) ? $sub['id'] : '' ?>" >
							<input type="hidden" id="sub_qual_id" class="numbersOnly" name="sem2sub_qual_id" value="<?= isset($sub['qual_id']) ? $sub['qual_id'] : '' ?>" >
							<input  type="text" id="tdsem2_eng" class="numbersOnly" name="tdsem2_eng" value="<?= isset($sub['marks_obt']) ? $sub['marks_obt'] : '' ?>" >
                              </td>
                            <td><input  type="text" id="odsem2_eng" class="numbersOnly" name="odsem2_eng" value="<?= isset($sub['marks_outof']) ? $sub['marks_outof'] : '' ?>" ></td>
                            <td>
							<div class="input-group date" id="doc-sub-datepicker_ssc">
                                <input  type="text" id="dsem2pass_date" name="dsem2pass_date" value="<?= isset($sub['passing_year']) ? $sub['passing_year'] : '' ?>" placeholder="yyyy-mm-dd">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span> </div>							
                            </td>
                            
                            </tr>
                            <?php } if($sub['sub_sem_name'] =='Sem 3'){?>
                            <tr class='diploama11'>
                            <td></td>
                            <td><label>Sem 3</label>
							<input type="hidden" id="" class="numbersOnly" name="sem3" value="<?=$sub['sub_sem_name']?>">
							</td>
                            <td>
							<input type="hidden" id="sub_id" class="numbersOnly" name="sem3_id" value="<?= isset($sub['id']) ? $sub['id'] : '' ?>" >
							<input type="hidden" id="sub_qual_id" class="numbersOnly" name="sem3sub_qual_id" value="<?= isset($sub['qual_id']) ? $sub['qual_id'] : '' ?>" >
							<input  type="text" id="tdsem3_eng" class="numbersOnly" name="tdsem3_eng" value="<?= isset($sub['marks_obt']) ? $sub['marks_obt'] : '' ?>" >
                              </td>
                            <td><input  type="text" id="odsem3_eng" class="numbersOnly" name="odsem3_eng" value="<?= isset($sub['marks_outof']) ? $sub['marks_outof'] : '' ?>" ></td>
                            <td>
                              <div class="input-group date" id="doc-sub-datepicker_ssc">
                                <input  type="text" id="dsem3pass_date" name="dsem3pass_date" value="<?= isset($sub['passing_year']) ? $sub['passing_year'] : '' ?>" placeholder="yyyy-mm-dd">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span> </div>
                            </td>
                            
                            </tr>
							<?php } if($sub['sub_sem_name'] =='Sem 4'){?>
                            <tr class='diploama11'>
                            <td></td>
                            <td><label>Sem 4</label>
							<input type="hidden" id="" class="numbersOnly" name="sem4" value="<?=$sub['sub_sem_name']?>">
							</td>
                            <td>
							<input type="hidden" id="sub_id" class="numbersOnly" name="sem4_id" value="<?= isset($sub['id']) ? $sub['id'] : '' ?>" >
							<input type="hidden" id="sub_qual_id" class="numbersOnly" name="sem4sub_qual_id" value="<?= isset($sub['qual_id']) ? $sub['qual_id'] : '' ?>" >
							<input  type="text" id="tdsem4_eng" class="numbersOnly" name="tdsem4_eng" value="<?= isset($sub['marks_obt']) ? $sub['marks_obt'] : '' ?>" >
                              </td>
                            <td><input  type="text" id="odsem4_eng" class="numbersOnly" name="odsem4_eng" value="<?= isset($sub['marks_outof']) ? $sub['marks_outof'] : '' ?>" ></td>
                            <td>
                              <div class="input-group date" id="doc-sub-datepicker_ssc">
                                <input  type="text" id="dsem4pass_date" name="dsem4pass_date" value="<?= isset($sub['passing_year']) ? $sub['passing_year'] : '' ?>" placeholder="yyyy-mm-dd">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span> </div>
                            </td>
                            
                            </tr>
							<?php } if($sub['sub_sem_name'] =='Sem 5'){?>
                            <tr class='diploama11'>
                            <td></td>
                            <td><label>Sem 5</label>
							<input type="hidden" id="" class="numbersOnly" name="sem5" value="<?=$sub['sub_sem_name']?>">
							</td>
                            <td>
							<input type="hidden" id="sub_id" class="numbersOnly" name="sem5_id" value="<?= isset($sub['id']) ? $sub['id'] : '' ?>" >
							<input type="hidden" id="sub_qual_id" class="numbersOnly" name="sem5sub_qual_id" value="<?= isset($sub['qual_id']) ? $sub['qual_id'] : '' ?>" >
							<input  type="text" id="tdsem5_eng" class="numbersOnly" name="tdsem5_eng" value="<?= isset($sub['marks_obt']) ? $sub['marks_obt'] : '' ?>" >
                              </td>
                            <td><input  type="text" id="odsem5_eng" class="numbersOnly" name="odsem5_eng" value="<?= isset($sub['marks_outof']) ? $sub['marks_outof'] : '' ?>" ></td>
                            <td>
                              <div class="input-group date" id="doc-sub-datepicker_ssc">
                                <input  type="text" id="dsem5pass_date" name="dsem5pass_date" value="<?= isset($sub['passing_year']) ? $sub['passing_year'] : '' ?>" placeholder="yyyy-mm-dd">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span> </div>
                            </td>
                            
                            </tr>
							<?php } if($sub['sub_sem_name'] =='Sem 6'){?>
                            <tr class='diploama11'>
                            <td></td>
                            <td><label>Sem 6</label>
							<input type="hidden" id="" class="numbersOnly" name="sem6" value="<?=$sub['sub_sem_name']?>">
							</td>
                            <td>
							<input type="hidden" id="sub_id" class="numbersOnly" name="sem6_id" value="<?= isset($sub['id']) ? $sub['id'] : '' ?>" >
							<input type="hidden" id="sub_qual_id" class="numbersOnly" name="sem6sub_qual_id" value="<?= isset($sub['qual_id']) ? $sub['qual_id'] : '' ?>" >
							<input  type="text" id="tdsem6_eng" class="numbersOnly" name="tdsem6_eng" value="<?= isset($sub['marks_obt']) ? $sub['marks_obt'] : '' ?>" >
                              </td>
                            <td><input  type="text" id="odsem6_eng" class="numbersOnly" name="odsem6_eng" value="<?= isset($sub['marks_outof']) ? $sub['marks_outof'] : '' ?>" ></td>
                            <td>
                              <div class="input-group date" id="doc-sub-datepicker_ssc">
                                <input  type="text" id="dsem6pass_date" name="dsem6pass_date" value="<?= isset($sub['passing_year']) ? $sub['passing_year'] : '' ?>" placeholder="yyyy-mm-dd">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span> </div>
                            </td>
                           
                          </tr>
						<?php	
							}
						}
							} 
						 }
						 ?>
						<?php 
							
						if (!in_array("SSC", $dgree))
						{
						?>
                         <tr class="10th">
                            <td><label>10th(Matriculation)Or Equivalent</label></td>
                            <td><label>English</label></td>
                            <td><input type="text" id="tssc_eng" class="numbersOnly" name="tssc_eng" value="<?= isset($qualiexam[0]['stotal_eng']) ? $qualiexam[0]['stotal_eng'] : '' ?>" >
                              </td>
                            <td><input type="text" id="ossc_eng" name="ossc_eng" class="numbersOnly" value="<?= isset($qualiexam[0]['sobt_eng']) ? $qualiexam[0]['sobt_eng'] : '' ?>" ></td>
                            <td>
                              <div class="input-group date" id="doc-sub-datepicker_ssc">
                                <input type="text" id="sscpass_date" name="sscpass_date" value="<?= isset($qualiexam[0]['ssc_passing_dt']) ? $qualiexam[0]['ssc_passing_dt'] : '' ?>" placeholder="yyyy-mm-dd">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span> </div></td> 
                           </tr>	 
						<?php }
						if (!in_array("HSC", $dgree))
						{
						?>
                         
                          <tr class="12th eng">
                            <td rowspan="5" class='12eng'>12th(Intermediate)or Equivalent</td>
                            <td><label>English</label></td>
                            <td><input type="text" id="thsc_eng" class="numbersOnly" value="<?= isset($qualiexam[0]['htotal_eng']) ? $qualiexam[0]['htotal_eng'] : '' ?>" name="thsc_eng">
                                </td>
                            <td><input type="text" id="ohsc_eng" class="numbersOnly" name="ohsc_eng" value="<?= isset($qualiexam[0]['hobt_eng']) ? $qualiexam[0]['hobt_eng'] : '' ?>">
                                </td>
                            <td>
                              <div class="input-group date" id="doc-sub-datepicker_hsc">
                                <input data-bv-field="slname" type="text" id="hscpass_date" name="hscpass_date" value="<?= isset($qualiexam[0]['hscpass_date']) ? $qualiexam[0]['hscpass_date'] : '' ?>" placeholder="yyyy-mm-dd">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span> </div>
                            </td>
                                
                          </tr>
                          <tr class="12th sci">
                            <td><label>Physics</label></td>
                            <td><input type="text" id="thsc_phy" class="numbersOnly" value="<?= isset($qualiexam[0]['htotal_phy']) ? $qualiexam[0]['htotal_phy'] : '' ?>" name="thsc_phy"></td>
                            <td><input type="text" id="ohsc_phy" class="numbersOnly"  value="<?= isset($qualiexam[0]['hobt_phy']) ? $qualiexam[0]['hobt_phy'] : '' ?>" name="ohsc_phy"></td>
                          </tr>
                          <tr class="12th sci">
                            <td><label>chemistry</label></td>
                            <td><input type="text" id="thsc_chem" class="numbersOnly" value="<?= isset($qualiexam[0]['htotal_chem']) ? $qualiexam[0]['htotal_chem'] : '' ?>" name="thsc_chem"></td>
                            <td><input type="text" id="ohsc_chem" class="numbersOnly" name="ohsc_chem" value="<?= isset($qualiexam[0]['hobt_chem']) ? $qualiexam[0]['hobt_chem'] : '' ?>"></td>
                          </tr>
                          <tr class="12th sci">
                            <td><label>Math</label></td>
                            <td><input type="text" id="thsc_bio" class="numbersOnly" value="<?= isset($qualiexam[0]['htotal_bio']) ? $qualiexam[0]['htotal_bio'] : '' ?>" name="thsc_bio"></td>
                            <td><input type="text" id="ohsc_bio" class="numbersOnly" name="ohsc_bio" value="<?= isset($qualiexam[0]['hobt_bio']) ? $qualiexam[0]['hobt_bio'] : '' ?>" ></td>
                          </tr>
                          <tr class="12th sci">
                            <td><label>Biology</label></td>
                            <td><input type="text" id="thsc_bio" class="numbersOnly"  value="<?= isset($qualiexam[0]['htotal_bio']) ? $qualiexam[0]['htotal_bio'] : '' ?>" name="thsc_bio"></td>
                            <td><input type="text" id="ohsc_bio" class="numbersOnly" name="ohsc_bio" value="<?= isset($qualiexam[0]['hobt_bio']) ? $qualiexam[0]['hobt_bio'] : '' ?>" ></td>
                          </tr>
						<?php }
						if (!in_array("Diploma", $dgree))
						{
						?>

                          <tr class='diploama'>
                            <td><label>Diploma</label></td>
                            <td><label>Sem 1</label></td>
                            <td><input  type="text" id="tdsem1_eng" class="numbersOnly" name="tdsem1_eng" value="" >
                              </td>
                            <td><input  type="text" id="odsem1_eng" class="numbersOnly" name="odsem1_eng" value="" ></td>
                            <td>
                              <div class="input-group date" id="doc-sub-datepicker_ssc">
                                <input  type="text" id="dsem1pass_date" name="dsem1pass_date" value="" placeholder="yyyy-mm-dd">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span> </div>
                            </td>
                           
                            </tr>
                            
                            <tr class='diploama'>
                            <td></td>
                            <td><label>Sem 2</label></td>
                            <td><input  type="text" id="tdsem2_eng" class="numbersOnly" name="tdsem2_eng" value="" >
                              </td>
                            <td><input  type="text" id="odsem2_eng" class="numbersOnly" name="odsem2_eng" value="" ></td>
                            <td>
                              <div class="input-group date" id="doc-sub-datepicker_ssc">
                                <input  type="text" id="dsem2pass_date" name="dsem2pass_date" value="" placeholder="yyyy-mm-dd">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span> </div>
                            </td>
                            
                            </tr>
                            
                            <tr class='diploama'>
                            <td></td>
                            <td><label>Sem 3</label></td>
                            <td><input  type="text" id="tdsem3_eng" class="numbersOnly" name="tdsem3_eng" value="" >
                              </td>
                            <td><input  type="text" id="odsem3_eng" class="numbersOnly" name="odsem3_eng" value="" ></td>
                            <td>
                              <div class="input-group date" id="doc-sub-datepicker_ssc">
                                <input  type="text" id="dsem3pass_date" name="dsem3pass_date" value="" placeholder="yyyy-mm-dd">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span> </div>
                            </td>
                            
                            </tr>
                            <tr class='diploama'>
                            <td></td>
                            <td><label>Sem 4</label></td>
                            <td><input  type="text" id="tdsem4_eng" class="numbersOnly" name="tdsem4_eng" value="" >
                              </td>
                            <td><input  type="text" id="odsem4_eng" class="numbersOnly" name="odsem4_eng" value="" ></td>
                            <td>
                              <div class="input-group date" id="doc-sub-datepicker_ssc">
                                <input  type="text" id="dsem4pass_date" name="dsem4pass_date" value="" placeholder="yyyy-mm-dd">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span> </div>
                            </td>
                            
                            </tr>
                            <tr class='diploama'>
                            <td></td>
                            <td><label>Sem 5</label></td>
                            <td><input  type="text" id="tdsem5_eng" class="numbersOnly" name="tdsem5_eng" value="" >
                              </td>
                            <td><input  type="text" id="odsem5_eng" class="numbersOnly" name="odsem5_eng" value="" ></td>
                            <td>
                              <div class="input-group date" id="doc-sub-datepicker_ssc">
                                <input  type="text" id="dsem5pass_date" name="dsem5pass_date" value="" placeholder="yyyy-mm-dd">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span> </div>
                            </td>
                            
                            </tr>
                            <tr class='diploama'>
                            <td></td>
                            <td><label>Sem 6</label></td>
                            <td><input  type="text" id="tdsem6_eng" class="numbersOnly" name="tdsem6_eng" value="" >
                              </td>
                            <td><input  type="text" id="odsem6_eng" class="numbersOnly" name="odsem6_eng" value="" ></td>
                            <td>
                              <div class="input-group date" id="doc-sub-datepicker_ssc">
                                <input  type="text" id="dsem6pass_date" name="dsem6pass_date" value="" placeholder="yyyy-mm-dd">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span> </div>
                            </td>
                           
                          </tr>
						  <?php 
						}
						  ?>
                 
                        </table>
                      </div>
                    </div>-->
                    
                    <div class="panel" style="display:none;">
                      <div class="panel-heading">Entrance Exam</div>
                      <div class="panel-body">
                          
                         <div class="row">
						 	<?php
								if(!empty($ent_exams)){
									foreach($ent_exams as $ent){	
									$exam_name1[] = $ent['entrance_exam_type'];
									
									
									}
								}
								//echo "<pre>";
									//print_r($exam_name1);
									if (!in_array("SU-JEE", $exam_name1))
									{
							?>
							<div class="col-sm-6">
								 <input type="checkbox" name="chk_sujee" id="chk_sujee" value="SUJEE"> SU-JEE-17<br>
								 <div class="form-group" id="enrol_div" style="display:none">
									 <label class="col-sm-4">Enrolment Number: </label>
									 <div class="col-sm-5">
									 <input type="text" class="form-control numbersOnly" name="reg_no" id="reg_no" value="" placeholder="Enrolment Number">
									 </div>
									 <div class="col-sm-2">
									 <input type="button" class="" name="btn_sujee" id="btn_sujee" value="Submit">
									 </div>
								 </div>
							 </div>
									<?php }

								?>
							 
						</div>
                         <div id="suJeexamtable"></div>
                        <table class="table table-bordered edu-table" id="examDettable">
                            <thead>
                          <tr>
                            <th>Exam Type</th>
                            <th>Exam Name</th>
                            <th width="12%">Month</th>
                            <th width="12%">Year</th>
                            <th>Enrolment No</th>
                            <th>Marks Obt</th>
                            <th>Total Marks</th>
                            <th>Percentage</th>
                            
                          </tr>
                          </thead>
                          <tbody>
						  <?php
								if(!empty($ent_exams)){
									foreach($ent_exams as $ent){	
									$exam_name[] = $ent['entrance_exam_type'];
									
							?>
							<tr>
                          <td><select name="exam-type[]" class="form-control" style="width: 95px;"><option value="">Select</option>
                                <option value="<?=$ent['entrance_exam_type']?>" selected><?=$ent['entrance_exam_type']?></option>
                                </select></td>
                          <td>
						  <input type="hidden" name="ent_exam_id[]" class="form-control" placeholder="Exam Name" value="<?=$ent['ent_exam_id']?>"/>
						  <input type="text" name="exam-name[]" class="form-control" placeholder="Exam Name" value="<?=$ent['entrance_exam_name']?>"/></td>
                          <td>
						   <?php
							$yearent = explode("-",$ent['passing_year']);
							$yearent[0]= strtoupper(substr($yearent[0], 0, 3));
							?>
                                     
                              <select name="ent_pass_month[]" class="form-control" style="width: 75px;">
                                <option value="JAN" <?php if(!empty($yearent[0]) && $yearent[0]=='JAN'){ echo "selected";}?>>JAN</option>
                                        <option value="FEB" <?php if(!empty($yearent[0]) && $yearent[0]=='FEB'){ echo "selected";}?>>FEB</option>
                                        <option value="MAR" <?php if(!empty($yearent[0]) && $yearent[0]=='MAR'){ echo "selected";}?>>MAR</option>
                                        <option value="APR" <?php if(!empty($yearent[0]) && $yearent[0]=='APR'){ echo "selected";}?>>APR</option>
                                        <option value="MAY" <?php if(!empty($yearent[0]) && $yearent[0]=='MAY'){ echo "selected";}?>>MAY</option>
                                        <option value="JUN" <?php if(!empty($yearent[0]) && $yearent[0]=='JUN'){ echo "selected";}?>>JUN</option>
                                        <option value="JUL" <?php if(!empty($yearent[0]) && $yearent[0]=='JUL'){ echo "selected";}?>>JUL</option>
                                        <option value="AUG" <?php if(!empty($yearent[0]) && $yearent[0]=='AUG'){ echo "selected";}?>>AUG</option>
                                        <option value="SEP" <?php if(!empty($yearent[0]) && $yearent[0]=='SEP'){ echo "selected";}?>>SEPT</option>
                                        <option value="OCT" <?php if(!empty($yearent[0]) && $yearent[0]=='OCT'){ echo "selected";}?>>OCT</option>
                                        <option value="NOV" <?php if(!empty($yearent[0]) && $yearent[0]=='NOV'){ echo "selected";}?>>NOV</option>
                                        <option value="DEC" <?php if(!empty($yearent[0]) && $yearent[0]=='DEC'){ echo "selected";}?>>DEC</option>
                            </select>
                          </td>
                          <td><select name="ent_pass_year[]" class="form-control" style="width: 75px;">
                                        <option value="">Year</option>
                                        <?php
for ($y = date("Y"); $y >= date("Y") - 60; $y--) {
			if($y==$yearent[1]){
			$selent = "selected";
		}else{
			$selent="";
		}
    echo '<option value="' . $y . '" '.$selent.'>' . $y . '</option>';
}
?>
                                     </select>
                          </td>
                          
                          <td><input type="text" name="enrolment[]" class="form-control" placeholder="Enrolment Number" value="<?= isset($ent['register_no']) ? $ent['register_no'] : '' ?>" style="width: 100px;"/></td>
                          <td><input type="text" name="ent_marks[]" id="mhcet_obt_marks" class="form-control numbersOnly" value="<?= isset($ent['marks_obt']) ? $ent['marks_obt'] : '' ?>" placeholder="Marks Obtained" style="width: 70px;" /></td>
                          <td><input type="text" name="ent_totalmarks[]" class="form-control numbersOnly" value="<?= isset($ent['marks_outof']) ? $ent['marks_outof'] : '' ?>" placeholder="Total Marks" style="width: 70px;"/></td>
                          <td><input type="text" name="ent_percentage[]" class="form-control" value="<?= isset($ent['percentage']) ? $ent['percentage'] : '' ?>" placeholder="Percentage" style="width: 80px;"/></td>

                          </tr>
							<?php
									}
								}
								if (!in_array("MH-CET", $exam_name))
								{	
														
							?>
                          <tr>
                          <td><select name="exam-type[]" class="form-control" style="width: 95px;"><option value="">Select</option>
                                <option value="MH-CET">MH-CET</option>
                                </select></td>
                          <td><input type="text" name="exam-name[]" class="form-control" placeholder="Exam Name" /></td>
                          <td>
                              <select name="ent_pass_month[]" class="form-control" style="width: 75px;">
                                <option value="">Month</option>
                                <option value="JAN">JAN</option>
                                <option value="FEB">FEB</option>
                                <option value="MAR">MAR</option>
                                <option value="APR">APR</option>
                                <option value="MAY">MAY</option>
                                <option value="JUN">JUN</option>
                                <option value="JUL">JUL</option>
                                <option value="AUG">AUG</option>
                                <option value="SEP">SEPT</option>
                                <option value="OCT">OCT</option>
                                <option value="NOV">NOV</option>
                                <option value="DEC">DEC</option>
                            </select>
                          </td>
                          <td><select name="pass_year[]" class="form-control" style="width: 75px;">
                                        <option value="">Year</option>
                                        <?php
for ($y = date("Y"); $y >= date("Y") - 60; $y--) {
    echo '<option value="' . $y . '">' . $y . '</option>';
}
?>
                                     </select>
                          </td>
                          
                          <td><input type="text" name="enrolment[]" class="form-control" placeholder="Enrolment Number" style="width: 100px;"/></td>
                          <td><input type="text" name="ent_marks[]" id="mhcet_obt_marks" class="form-control numbersOnly" placeholder="Marks Obtained" style="width: 70px;" /></td>
                          <td><input type="text" name="ent_totalmarks[]" class="form-control numbersOnly" placeholder="Total Marks" style="width: 70px;"/></td>
                          <td><input type="number" name="ent_percentage[]" class="form-control" placeholder="Percentage" style="width: 80px;"/></td>

                          </tr>
						  <?php 
								}if (!in_array("Other", $exam_name))
								{	
						  ?>
						  <tr>
                          <td><select name="exam-type[]" class="form-control" style="width: 95px;"><option value="">Select</option>
                               
                                <option value="Other">Other</option></select></td>
                          <td><input type="text" name="exam-name[]" class="form-control" placeholder="Exam Name" /></td>
                          <td>
                              <select name="ent_pass_month[]" class="form-control" style="width: 75px;">
                                <option value="">Month</option>
                                <option value="JAN">JAN</option>
                                <option value="FEB">FEB</option>
                                <option value="MAR">MAR</option>
                                <option value="APR">APR</option>
                                <option value="MAY">MAY</option>
                                <option value="JUN">JUN</option>
                                <option value="JUL">JUL</option>
                                <option value="AUG">AUG</option>
                                <option value="SEP">SEPT</option>
                                <option value="OCT">OCT</option>
                                <option value="NOV">NOV</option>
                                <option value="DEC">DEC</option>
                            </select>
                          </td>
                          <td><select name="ent_pass_year[]" class="form-control" style="width: 75px;">
                                        <option value="">Year</option>
                                        <?php
for ($y = date("Y"); $y >= date("Y") - 60; $y--) {
    echo '<option value="' . $y . '">' . $y . '</option>';
}
?>
                                     </select>
                          </td>
                          
                          <td><input type="text" name="enrolment[]" class="form-control" placeholder="Enrolment Number" style="width: 100px;"/></td>
                          <td><input type="text" name="ent_marks[]" id="othr_obt_marks" class="form-control numbersOnly" placeholder="Marks Obtained" style="width: 70px;" /></td>
                          <td><input type="text" name="ent_totalmarks[]" class="form-control numbersOnly" placeholder="Total Marks" style="width: 70px;"/></td>
                          <td><input type="number" name="ent_percentage[]" class="form-control" placeholder="Percentage" style="width: 80px;"/></td>

                          </tr>
								<?php }?>
                          </tbody>
                        </table>
                        <div class="row">	
							 <div class="col-sm-6">
								<input type="checkbox" name="chk_scholr" id="chk_scholr" value="scholr"> Is Scholarship?<br>
								<div class="form-group" id="schlr_div" style="display:none">
									 <label class="col-sm-4">Scholarship Types: </label>
									 <div class="col-sm-6">
									 <input type="radio" name="schlr_type" id="schlr_type" value="I"> 1<sup>st</sup> &nbsp;
									 <input type="radio" name="schlr_type" id="schlr_type" value="II"> 2<sup>nd</sup> &nbsp;
									 <input type="radio" name="schlr_type" id="schlr_type" value="III"> 3<sup>rd</sup> &nbsp;
									 </div>
									 <!--div class="col-sm-2">
									 <input type="button" class="" name="btn_sujee" id="btn_sujee" value="Submit">
									 </div-->
								 </div>
							</div>
						</div>
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <div class="col-sm-4"></div>

                     <div class="col-sm-2">
                   
					
					
								  	<?php  $role_id =$this->session->userdata('role_id');

                                  if($role_id==2 || $role_id==59) {
							?>
							  
                                 <button class="btn btn-primary nextBtn form-control" type="submit" >Update</button>
								 
								  <?php  } ?>	 
					
                    </div>
                      

                   </div>
                
                  </div>
                  <!--end  of educational --> 
                        </form>
                     </div>
                  </div>
                  
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<script type="text/javascript">
  function qualifcation(id){
      standrd = $("#"+id).val();

      res = id.split("_");
      var n= res[1];
      var streamId = '#stream_name_'+n;
      var sub = $(streamId).val();
       if(standrd=='SSC'){
    	  $(streamId).html("<option value='NA'>NA</option>");
    	  $(streamId+" option[value='NA']").attr("selected", "selected");
    	  $("tr.10th").show();
    	//$('.10th').show();
      }else if(standrd=='HSC'){
    	  $(streamId).html("<option value=''>-select-</option><option value='Arts'>Arts</option><option value='Commerce'>Commerce</option><option value='Science'>Science</option><option value='Vocational'>Vocational</option>");
    	  $("tr.12th").show();
    	  
      }else if(standrd=='Graduation'){
    	  //alert('Inside');
    	 $.post("<?= base_url() ?>Ums_admission/fetch_qualification_streams/", {getspecial: 1}, function (data) {
    		 //alert(data);
    		$(streamId).html(data);
    		
    	});
      }else if(standrd=='Diploma'){
    	  $(streamId).html("<option value='NA'>NA</option>");
    	  $(streamId+" option[value='NA']").attr("selected", "selected");
    	  $("tr.diploama").show();
      } 
  } 
  
   function strmsubject(id){
      streamId = $("#"+id).val();
      if(streamId=='Arts' || streamId=='Commerce'){
         $("tr.eng").show(); 
         $("tr.sci").hide(); 
         $("td.12eng").attr("rowspan","1");
      }else if(streamId=='Science'){
          $("td.12eng").attr("rowspan","5");
         $("tr.eng").show(); 
         $("tr.sci").show(); 
      }else{
          
      }

  } 
  
$(document).ready(function(){
    // payment calculations
    $('#paymnt').on('click', function () {
		var strm_id = $("#admission-stream").val();
		//alert(strm_id);
		if (strm_id) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Ums_admission/fetch_academic_fees_for_stream',
				data: 'strm_id=' + strm_id,
				success: function (resp) {
					//alert(resp)
					var obj = jQuery.parseJSON(resp);	
					var total_fees =parseInt(obj[0].total_fees); 
					var su_jee_per = parseFloat($("#super").val());
					var mhcet_mrks = parseInt($("#mhcet_obt_marks").val());
					var othr_mrks = parseInt($("#othr_obt_marks").val());
					//alert(su_jee_per);
					//alert(mhcet_mrks);
					//alert(total_fees);
					
					if(mhcet_mrks >0){						
					}else{
						mhcet_mrks =0;
					}
					if(othr_mrks >0){						
					}else{
						othr_mrks =0;
					}
					if(su_jee_per > 0){
						//alert("SU");
						if (su_jee_per >= 90 && su_jee_per <= 100) 
						{
							var exepmted_fees = total_fees;
						}else if(su_jee_per >= 86 && su_jee_per <= 89)
						{
							var exepmted_fees = total_fees * 0.5;
						}else if(su_jee_per >= 75 && su_jee_per <= 85)
						{
							var exepmted_fees = total_fees * 0.25;
						}else{
							//var exepmted_fees = parseInt(0);
						}
					}else if(mhcet_mrks > othr_mrks){
						//alert("MH");
						if (mhcet_mrks >= 130 && mhcet_mrks <= 150) 
						{
							var exepmted_fees = total_fees;
						}else if(mhcet_mrks >= 115 && mhcet_mrks <= 129)
						{
							var exepmted_fees = total_fees * 0.5;
						}else if(mhcet_mrks >= 105 && mhcet_mrks <= 114)
						{
							var exepmted_fees = total_fees * 0.25;
						}else{
							//var exepmted_fees = parseInt(0);
						}
					}else if(othr_mrks > mhcet_mrks){
						//alert("OTh");
						if (othr_mrks >= 130 && othr_mrks <= 150) 
						{
							var exepmted_fees = total_fees;
						}else if(othr_mrks >= 115 && othr_mrks <= 129)
						{
							var exepmted_fees = total_fees * 0.5;
						}else if(othr_mrks >= 105 && othr_mrks <= 114)
						{
							var exepmted_fees = total_fees * 0.25;
						}else{
							//var exepmted_fees = parseInt(0);
						}
					}else{
						//alert("else");
						var exepmted_fees = parseInt(0);
					}

					//alert(total_fees);
					//alert(exepmted_fees);
					
					var final_fee = total_fees - exepmted_fees;
					//alert(final_fee);
					$("#txt_acd").val(total_fees);
					$("#txt_exempt").val(exepmted_fees);
					$("#txt31").val(final_fee);
					//$('#suJeexamtable').html(html);
				}
			});
		} else {
			//alert("Please enter registration no");

		}
	});
    /////////////
    $("tr.person_sandp").hide();
    $("tr.alumini_sandip").hide();
    $("tr.relativ_sandip").hide();
    
    $('#reletedsandip').change(function(){
        var reletedsandip = $("#reletedsandip").val();
        if(reletedsandip=='Y')
        $("tr.person_sandp").show();
        else
        $("tr.person_sandp").hide();

    });
    
    $('#aluminisandip').change(function(){
        var aluminisandip = $("#aluminisandip").val();
        if(aluminisandip=='Y')
        $("tr.alumini_sandip").show();
        else
        $("tr.alumini_sandip").hide();

    });   
    $('#relativesandip').change(function(){
        var relativesandip = $("#relativesandip").val();
        if(relativesandip=='Y')
        $("tr.relativ_sandip").show();
        else
        $("tr.relativ_sandip").hide();

    });    
    //
    $("tr.10th").hide();
    $("tr.12th").hide();
    $("tr.diploama").hide();
    ///////
    $('#btn_sujee').on('click', function () {
		var reg_no = $("#reg_no").val();
		//alert(reg_no);
		if (reg_no) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Ums_admission/fetch_sujee_details',
				data: 'reg_no=' + reg_no,
				success: function (html) {
				//	alert(html);
					$('#suJeexamtable').html(html);
				}
			});
		} else {
			alert("Please enter registration no");
			$("#reg_no").focus();
		}
	});
    //SU-JEE Exam show and hide
    $('#chk_sujee').change(function(){
    if($(this).is(":checked"))
    $('#enrol_div').fadeIn('slow');
    else
    $('#enrol_div').fadeOut('slow');

    });
    // added by bala
	$('#chk_scholr').change(function(){
		if($(this).is(":checked"))
		$('#schlr_div').fadeIn('slow');
		else
		$('#schlr_div').fadeOut('slow');
    });
    // Num check logic
  	$('.numbersOnly').keyup(function () {
    if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
       this.value = this.value.replace(/[^0-9\.]/g, '');
    } 
  	});
  	
    // City by State
	$('#lstate_id').on('change', function () {
		var stateID = $(this).val();
		
		if (stateID) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Ums_admission/getStatewiseDistrict',
				data: 'state_id=' + stateID,
				success: function (html) {
					//alert(html);
					$('#ldistrict_id').html(html);
				}
			});
		} else {
			$('#ldistrict_id').html('<option value="">Select state first</option>');
		}
	});
	
    // City by State
	$('#ldistrict_id').on('change', function () {
		var district_id = $(this).val();
		var state_ID = $("#lstate_id").val();
	//	alert(state_ID);alert(district_id);
		if (district_id) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Ums_admission/getStateDwiseCity',
				data: { state_id: state_ID, district_id : district_id},
				success: function (html) {
					//alert(html);
					if(html !=''){
					$('#lcity').html(html);
					}else{
					  $('#lcity').html('<option value="">No city found</option>');  
					}
				}
			});
		} else {
			$('#lcity').html('<option value="">Select district first</option>');
		}
	});	
  /////////// for perment address
      // City by State
	$('#pstate_id').on('change', function () {
		var stateID = $(this).val();
		
		if (stateID) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Ums_admission/getStatewiseDistrict',
				data: 'state_id=' + stateID,
				success: function (html) {
					//alert(html);
					$('#pdistrict_id').html(html);
				}
			});
		} else {
			$('#pdistrict_id').html('<option value="">Select state first</option>');
		}
	});
	
    // City by State
	$('#pdistrict_id').on('change', function () {
		var district_id = $(this).val();
		var state_ID = $("#pstate_id").val();
	//	alert(state_ID);alert(district_id);
		if (district_id) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Ums_admission/getStateDwiseCity',
				data: { state_id: state_ID, district_id : district_id},
				success: function (html) {
					//alert(html);
					if(html !=''){
					$('#pcity').html(html);
					}else{
					  $('#pcity').html('<option value="">No city found</option>');  
					}
				}
			});
		} else {
			$('#pcity').html('<option value="">Select district first</option>');
		}
	});	

	 /////////// for Parent's/Guardian's Details *
      // City by State
	$('#gstate_id').on('change', function () {
		var stateID = $(this).val();
		
		if (stateID) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Ums_admission/getStatewiseDistrict',
				data: 'state_id=' + stateID,
				success: function (html) {
					//alert(html);
					$('#gdistrict_id').html(html);
				}
			});
		} else {
			$('#gdistrict_id').html('<option value="">Select state first</option>');
		}
	});
	
    // City by State
	$('#gdistrict_id').on('change', function () {
		var district_id = $(this).val();
		var state_ID = $("#gstate_id").val();
	//	alert(state_ID);alert(district_id);
		if (district_id) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Ums_admission/getStateDwiseCity',
				data: { state_id: state_ID, district_id : district_id},
				success: function (html) {
					//alert(html);
					if(html !=''){
					$('#gcity').html(html);
					}else{
					  $('#gcity').html('<option value="">No city found</option>');  
					}
				}
			});
		} else {
			$('#gcity').html('<option value="">Select district first</option>');
		}
	});	
	//////////////////////////////////////////////
    $('#dob-datepicker').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#doc-sub-datepicker1').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#doc-sub-datepicker2').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#doc-sub-datepicker3').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#doc-sub-datepicker4').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#doc-sub-datepicker5').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#doc-sub-datepicker6').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#doc-sub-datepicker7').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#doc-sub-datepicker8').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#doc-sub-datepicker9').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#doc-sub-datepicker10').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#doc-sub-datepicker11').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#doc-sub-datepicker12').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#doc-sub-datepicker13').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#doc-sub-datepicker14').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#doc-sub-datepicker15').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#doc-sub-datepicker16').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#doc-sub-datepicker17').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#doc-sub-datepicker18').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#doc-sub-datepicker19').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#doc-sub-datepicker20').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#doc-sub-datepicker_ssc').datepicker( {format: 'yyyy-mm',autoclose: true});
    $('#doc-sub-datepicker_hsc').datepicker( {format: 'yyyy-mm',autoclose: true});
	$('#sscpass_date').datepicker( {format: 'yyyy-mm',autoclose: true});

    $('#cvaldt1').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#cvaldt2').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#cvaldt3').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    
      $('#dsem1pass_date').datepicker( {format: 'yyyy-mm',autoclose: true});
      $('#dsem2pass_date').datepicker( {format: 'yyyy-mm',autoclose: true});
      $('#dsem3pass_date').datepicker( {format: 'yyyy-mm',autoclose: true});
      $('#dsem4pass_date').datepicker( {format: 'yyyy-mm',autoclose: true});
      $('#dsem5pass_date').datepicker( {format: 'yyyy-mm',autoclose: true});
      $('#dsem6pass_date').datepicker( {format: 'yyyy-mm',autoclose: true});
  
       var content = '<tr>'+$('#eduDetTable tbody tr').html()+'</tr>';
    // hide the remove button in education table
    var rowCount = $('#eduDetTable >tbody >tr').length;
    if(rowCount<2){$('#remove').hide();}
    else{$('#remove').show();}
    ///

    $("#eduDetTable").on("click","input[name='remove']", function(e){    
    //$("input[name='remove']").on('click',function(){
        var rowCount = $('#eduDetTable tbody tr').length;

        if(rowCount>1){
            $(this).parent().parent('tr').remove();
        }
    }); 
    
    var contentE = '<tr>'+$('#examDettable tbody tr').html()+'</tr>';
    // hide the removeE button in education table
    var rowCountE = $('#examDettable >tbody >tr').length;
	if(rowCountE<2){$('#removeE').hide();}
	else{$('#removeE').show();}

    $("#examDettable").on("click","input[name='addMore']", function(e){    
    //$("input[name='addMore']").on('click',function(){        
        //var contentE = $(this).parent().parent('tr').clone('true');
        $(this).parent().parent('tr').after(contentE);    
        
    });
    $("#examDettable").on("click","input[name='removeE']", function(e){    
    //$("input[name='removeE']").on('click',function(){
        var rowCountE = $('#examDettable tbody tr').length;

        if(rowCountE>1){
            $(this).parent().parent('tr').remove();
        }
    });  
    
    });  
    
    /////////// add more for edu table
    var max_fields      = 5; //maximum input boxes allowed

    var x = 1; //initlal text box count
    $("#addmore").click(function(e){ //on add input button click
 
       e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            var qid= "studqual_"+x;
            var strm = "stream_name_"+x;
            //alert(qid);
			var fieldshtml = "<tr><td> <div class='form-group'><select name='exam_id[]' id='studqual_"+x+"' class='squal form-control' onchange='qualifcation("+'"'+qid+'"'+")' required><option value=''>Select</option><option value='SSC'>SSC</option><option value='HSC'>HSC</option><option value='Graduation'>Graduation</option><option value='Post Graduation'>Post Graduations</option><option value='Diploma'>Diploma</option></select></div>   </td><td><select name='stream_name[]' id='stream_name_"+x+"' onchange='strmsubject("+'"'+strm+'"'+")' style='width:85px' class='form-control' ><option value=''>Select</option> </select></td><td><div class='form-group'><input type='text' name='seat_no[]' class='form-control' value='' placeholder='Board/University' required /></td></div><td><input type='text' name='institute_name[]' class='form-control' value='' placeholder='Name of Board/University' required /></td><td><select name='pass_year[]' class='form-control'><option value=''>Year</option><?php  for ($y = date('Y'); $y >= date('Y') - 60; $y--) {  ?> <option value='<?=$y?>'><?=$y?></option><? }?></select><select name='pass_month[]' class='form-control' required><option value=''>Month</option><option value='JAN'>JAN</option><option value='FEB'>FEB</option><option value='MAR'>MAR</option><option value='APR'>APR</option><option value='MAY'>MAY</option><option value='JUN'>JUN</option><option value='JUL'>JUL</option><option value='AUG'>AUG</option><option value='SEP'>SEPT</option><option value='OCT'>OCT</option><option value='NOV'>NOV</option><option value='DEC'>DEC</option></select></td><td><input type='text' name='marks_obtained[]' class='form-control numbersOnly' value='' required/></td><td><input type='text' name='marks_outof[]' class='form-control numbersOnly' value='' placeholder='' required/></td><td><input type='text' name='percentage[]' class='form-control' value='' placeholder='' required/></td><td><input type='file' name='sss_doc[]' id='sss_doc' style='width:80px'></td><td><input type='button' class='remove_field btn btn-xs btn-danger btn-flat' id='remove' value='Remove' name='remove' /></td></tr>";
		
            $("#eduDetTable >tbody").append(fieldshtml); //add input box
        }
    });
    $("#eduDetTable >tbody").on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('tr').remove(); x--;
    });


</script>
<script type="text/javascript">
    var upload_error = 0;
    function validatefile() {
    
    var userfile_arr = new Array();
    var fieldname_arr = new Array();
    var formData = new FormData();
    $('.userfile').each(function(i, obj) {
        const file = this.files[0];
        // Create a FormData object to send the file via Ajax
        if(file){
          console.log("file found at index"+i);
          var fieldName = $(this).parent().parent().find('td>div>select[name*="exam_id"]').val();
          fieldName = $.trim(fieldName);   
          console.log(fieldName);             
          // userfile_arr.push(file);
          formData.append("userfile[]", file);
          formData.append("fieldname[]", fieldName);
        }
    });

    // Send the file to the server for validation
    $.ajax({
        url: "<?= base_url('upload/validateAllFile') ?>",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
            // Handle the validation result
            // You can show messages or perform actions based on the response
            console.log(response);
            $("#errors").html('');
            $.each(response, function(index) {
                if(response[index].status == 'error'){
                  upload_error = 1;
                    $("#errors").append("<br/>"+response[index].message);
                }else{
                  upload_error = 0;
                }

            });
        },
        error: function (xhr, status, error) {
            console.error(error);
        }
    });
}
$(document).ready(function () {
    $("#upload_form").submit(function(e){
        if(upload_error){
          e.preventDefault();
          alert("Please resolved upload file error");
        }
    })
    // Optional: If you want to trigger the Ajax request on button click
    // $("#uploadButton").click(function () {
    //     $("#userfile").trigger("change");
    // });
});
</script>