<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script>    
    $(document).ready(function()
    {  
		// Num check logic
		$('.numbersOnly').keyup(function () {
			if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
			   this.value = this.value.replace(/[^0-9\.]/g, '');
			} 
		});
		//
		var course_id = $("#course_id").val();
		//alert(course_id);
		if (course_id) {
			$.ajax({
				'url' : base_url + 'Subject/load_streams_sub',
				'type' : 'POST', //the way you want to send data to your URL
				'data' : {'course' : course_id},
				'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
					var container = $('#semest'); //jquery selector (get element by id)
					if(data){
						var stream_id = '<?= $subdet[0]['stream_id'] ?>';
						container.html(data);
						$("#semest option[value='" + stream_id + "']").attr("selected", "selected");
					}
				}
			});
		}
		
    });

</script>
<style>
.blinking{
    animation:blinkingText 10.2s infinite;
}
@keyframes blinkingText{
    0%{     color: red;    }
    49%{    color: transparent; }
    50%{    color: red; }
    99%{    color:red;  }
    100%{   color: red;    }
}
</style>
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
	$tp = $this->uri->segment(3);
	if($tp!=''){
		$ed ="Edit";
	}else{
		$ed ="Add";
	}
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="#"><?=$ed?> Course Work</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-book page-header-icon"></i>&nbsp;&nbsp;<?=$ed?> Course Work</h1> <span class="blinking pull-left">Last date for adding/updating Course master is 3<sup>rd</sup> July 2019 </span>
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
                    <div class="panel-heading">
                            <span class="panel-title">Course Details</span>
                    </div>
                    <div class="panel-body">
                        <div class="table-info">
                            <?php 
                            $dup_msg = $this->session->flashdata('dup_msg');
                            if(!empty($dup_msg)){
                                ?>
                            <div class="form-group">
                              <label class="col-sm-12" style="color:red"> <?= $dup_msg ?></label>     
                            </div>
                            <?php
                            }
                            ?>
							
                            <form id="form" name="form" method="POST" action="<?=base_url($currentModule.'/insert_subject')?>" enctype="multipart/form-data">                                                               
                            <input type="hidden" value="<?=isset($subdet[0]['sub_id']) ? $subdet[0]['sub_id'] : ''?>" id="sub_id" name="sub_id" />

                            <div class="form-group">
                              <label class="col-sm-3">Regulation <?= $astrik ?></label>
                              <div class="col-sm-3" >
                                <select name="regulation" id="regulation" class="form-control" required>
                                  <option value="">Select</option>
                                  <?php

                                    /*foreach ($regulatn as $reg) {
                                        if ($reg['regulation'] == $subdet[0]['regulation']) {
                                            $sel = "selected";
                                        } else {
                                            $sel = '';
                                        }
                                        echo '<option value="' . $reg['regulation'] . '"' . $sel . '>' . $reg['regulation'] . '</option>';
                                    }*/
                                    ?>
									<option value="2023" selected>2023</option>
                               </select>
                              </div>
							<label class="col-sm-3">Batch <?= $astrik ?></label>
                              <div class="col-sm-3" >
                                <select name="batch" id="batch" class="form-control" required>
                                  <option value="">Select</option>
                                  <?php
								  //$batches = array('2016','2017','2018','2019','2020','2021','2022','2023','2024','2025');
                                    foreach ($adm_batches as $bt) {
										//$bt=trim($bt[batch]);
                                        if ($bt== $subdet[0]['admission_cycle']) {
                                            $sel = "selected";
                                        } else {
                                            $sel = '';
                                        }
                                        echo '<option value="' . $bt['admission_cycle'] . '"' . $sel . '>' . $bt['admission_cycle'] . '</option>';
                                    }
                                    ?>
                               </select>
                              </div>

                            </div>
							<div class="form-group">
                              <label class="col-sm-3">Course <?= $astrik ?></label>
                              <div class="col-sm-3" >
                                <select name="course_id" id="course_id" class="form-control" onchange="load_streams(this.value)" required>
                                  <option value="">Select</option>
                                  <?php
									foreach ($course_details as $course) {
										if ($course['course_id'] == $subdet[0]['course_id']) {
											$sel = "selected";
										} else {
											$sel = '';
										}
										echo '<option value="' . $course['course_id'] . '"' . $sel . '>' . $course['course_short_name'] . '</option>';
									}
									?>
                               </select>
                              </div>
                              <script>
                                     var base_url = '<?php
										echo site_url();
										?>';
                                      function load_streams(type){
											   // alert(type);
												
											$.ajax({
												'url' : base_url + 'Subject/load_streams_sub',
												'type' : 'POST', //the way you want to send data to your URL
												'data' : {'course' : type},
												'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
													var container = $('#semest'); //jquery selector (get element by id)
													if(data){
													 //   alert(data);
														//alert("Marks should be less than maximum marks");
														//$("#"+type).val('');
														container.html(data);
													}
												}
											});
										}
										
                                    </script>
                              <label class="col-sm-3">Stream <?= $astrik ?></label>
                              <div class="col-sm-3" id="semest" >
                                <select name="stream_id" class="form-control" id="stream_id" required>
                                  <option value="">Select</option>
                                  <?php
									foreach ($branches as $branch) {
										if ($branch['branch_code'] == $subdet[0]['strem_id']) {
											$sel = "selected";
										} else {
											$sel = '';
										}
										echo '<option value="' . $branch['branch_code'] . '" ' . $sel . '>' . $branch['branch_code'] . '</option>';
									}
									?>
                               </select>
                              </div>
                            </div>
							<div class="form-group">
                                    <label class="col-sm-3">Semester<?=$astrik?></label>
                                    <div class="col-sm-3">
									<select id="semester" name="semester" class="form-control" required>
                                            <option value="">Select Semester</option>
											<?php 
											/*for($i=1;$i<=9;$i++) {
												if ($i == $subdet[0]['semester']) {
												$sel3 = "selected";
												} else {
													$sel3 = '';
												}
												if(empty($subdet[0]['sub_id'])){
												if($i%2==0)
												{
													$even=$i;
													if($cur_session[0]['academic_session']=='SUMMER'){
													?>
													<option value="<?=$even?>" <?=$sel3?>><?=$even?></option>
													<?php }}else{
													$odd=$i;
													if($cur_session[0]['academic_session']=='WINTER'){
													?> 
												<option value="<?=$odd?>" <?=$sel3?>><?=$odd?></option>
													<?php }}
											
											}else{ 
											?>
											<option value="<?=$i?>" <?=$sel3?>><?=$i?></option>
											<?php }} */?>
											
											<option value="1" <?=$sel3?>>1</option>
											</select>
									</div>      
									<label class="col-sm-3">Subject Component<?=$astrik?></label>
								    <div class="col-sm-3">
									  <select id="subject_component" name="subject_component" class="form-control" required>
                                            <option value="">Select Component</option>
                                            <?php for($i=0;$i<count($subcmpt);$i++) {
												if ($subcmpt[$i]['sub_component'] == $subdet[0]['subject_component']) {
												$sel4 = "selected";
												} else {
													$sel4 = '';
												}
											?>
                                            <option value="<?=$subcmpt[$i]['sub_component']?>" <?=$sel4?>><?=$subcmpt[$i]['component_name']?></option>
                                            <?php } ?>
                                        </select>
								    </div>
                                    
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3">Subject Code <?=$astrik?></label>                                    
									<div class="col-sm-3">
                                        <input type="text" id="subject_code" name="subject_code" class="form-control" value="<?=isset($subdet[0]['subject_code']) ? $subdet[0]['subject_code'] : ''?>" placeholder="Subject Code" required/>                                  
                                    </div> 
									<label class="col-sm-3">Subject Name <?=$astrik?></label>                                    
									<div class="col-sm-3">
                                        <input type="text" id="subject_name" name="subject_name" class="form-control" value="<?=isset($subdet[0]['subject_name']) ? $subdet[0]['subject_name'] : ''?>" placeholder="Subject Name" required/>                                  
                                    </div> 
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3">Subject Short Name </label>
                                    <div class="col-sm-3"><input type="text" id="subject_short_name" name="subject_short_name" class="form-control" value="<?=isset($subdet[0]['subject_short_name']) ? $subdet[0]['subject_short_name'] : ''?>" /></div>                                    
                                    <label class="col-sm-3">Subject Type<?=$astrik?></label>
								    <div class="col-sm-3">
									  <select id="subject_type" name="subject_type" class="form-control" required>
                                            <option value="">Select Type </option>
                                            <?php for($i=0;$i<count($subtype);$i++) {
												if ($subtype[$i]['sub_type'] == $subdet[0]['subject_type']) {
												$sel2 = "selected";
												} else {
													$sel2 = '';
												}	
											?>
                                            <option value="<?=$subtype[$i]['sub_type']?>" <?=$sel2?>><?=$subtype[$i]['type_name']?></option>
                                            <?php } ?>
                                        </select>
								    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-3">Subject Group</label>
                                    <div class="col-sm-3"><input type="text" id="subject_group" name="subject_group" class="form-control" value="<?=isset($subdet[0]['subject_group']) ? $subdet[0]['subject_group'] : ''?>" /></div>                                    
                                    <label class="col-sm-3">Credit<?=$astrik?> </label>
								    <div class="col-sm-3">
									    <input type="text" id="credits" name="credits" class="form-control numbersOnly" value="<?=isset($subdet[0]['credits']) ? $subdet[0]['credits'] : ''?>" maxlength="2" placeholder="Subject Credit" required/>                                  
								    </div>
                                </div>
								<div class="form-group">
                                    <label class="col-sm-3">Subject Category</label>
                                    <div class="col-sm-3">
										<select name="subject_category" id="subject_category" class="form-control">
											<option value="">--Select--</option>
											<option value="NCR" <?php if($subdet[0]['subject_category']=='NCR'){ echo "selected";} ?>>Non Credits</option>											
											<option value="MNR" <?php if($subdet[0]['subject_category']=='MNR'){ echo "selected";} ?>>Minors</option>
											<option value="ADL" <?php if($subdet[0]['subject_category']=='ADL'){ echo "selected";} ?>>Additional Learning</option>
											<option value="URE" <?php if($subdet[0]['subject_category']=='URE'){ echo "selected";} ?>>University Research Experince</option>											
									    </select>
									</div>                                    
                                    <label class="col-sm-3">Subject Order<?=$astrik?> </label>
								    <div class="col-sm-3">
										<select name="subject_order" id="subject_order" class="form-control">
											<option value="">--Select--</option>
											<?php 
											for($i=1; $i<=20; $i++){
												
												if ($i == $subdet[0]['subject_order']) {
												$sel32 = "selected";
												} else {
													$sel32 = '';
												}	
											?>
											<option value="<?=$i?>" <?=$sel32?>><?=$i?></option>
											<?php }?>
									    </select>                                  
								    </div>
                                </div>


                                    <div class="form-group">
                                    <label class="col-sm-3">Evaluation Board<?=$astrik?></label>
                                    <div class="col-sm-3">
                                        <select name="evaluation_board" id="evaluation_board" class="form-control">
                                            <option value="">--Select--</option>
                                            <option value="Mathematics" <?php if($subdet[0]['evaluation_board']=='Mathematics'){ echo "selected";} ?>>Mathematics</option>                                          
                                            <option value="Physics" <?php if($subdet[0]['evaluation_board']=='Physics'){ echo "selected";} ?>>Physics</option>
                                            <option value="Chemistry" <?php if($subdet[0]['evaluation_board']=='Chemistry'){ echo "selected";} ?>>Chemistry</option>
                                            <option value="Life sciences" <?php if($subdet[0]['evaluation_board']=='Life sciences'){ echo "selected";} ?>>Life sciences Experince</option> 
                                             <option value="English" <?php if($subdet[0]['evaluation_board']=='English'){ echo "selected";} ?>>English</option> 
                                              <option value="Civil" <?php if($subdet[0]['evaluation_board']=='Civil'){ echo "selected";} ?>>Civil</option> 
                                               <option value="Electrical" <?php if($subdet[0]['evaluation_board']=='Electrical'){ echo "selected";} ?>>Electrical</option> 
                                                <option value="Mechanical" <?php if($subdet[0]['evaluation_board']=='Mechanical'){ echo "selected";} ?>>Mechanical</option>
												<option value="Management" <?php if($subdet[0]['evaluation_board']=='Management'){ echo "selected";} ?>>Management</option> 												
                                                 <option value="Law" <?php if($subdet[0]['evaluation_board']=='Law'){ echo "selected";} ?>>Law</option> 
                                                  <option value="Pharmacy" <?php if($subdet[0]['evaluation_board']=='Pharmacy'){ echo "selected";} ?>>Pharmacy</option> 
                                                   <option value="Fashion Design" <?php if($subdet[0]['subject_category']=='Fashion Design'){ echo "selected";} ?>>Fashion Design</option> 
                                                    <option value="CSE" <?php if($subdet[0]['evaluation_board']=='CSE'){ echo "selected";} ?>>CSE</option> 
                                                     <option value="Aerospace" <?php if($subdet[0]['subject_category']=='Aerospace'){ echo "selected";} ?>> Aerospace</option> 
                                                      <option value="Fire & Safety" <?php if($subdet[0]['evaluation_board']=='Fire & Safety'){ echo "selected";} ?>>Fire & Safety</option><option value="Forensic science" <?php if($subdet[0]['evaluation_board']=='Forensic science'){ echo "selected";} ?>>Forensic science</option>                                           
                                        </select>
                                    </div>                                    
                                    <label class="col-sm-3">Category<?=$astrik?></label>
                                    <div class="col-sm-3">
                                        <select name="category_subject" id="category_subject" class="form-control">
                                            <option value="">--Select--</option>
                                           
                                           <option value="University Core(UC)" <?php if($subdet[0]['category_subject']=='University Core(UC)'){ echo "selected";} ?>>University Core(UC)</option>
                                            <option value="Programme Core(PC)" <?php if($subdet[0]['category_subject']=='Programme Core(PC)'){ echo "selected";} ?>>Programme Core(PC)</option>
                                             <option value="Programme Elective(PE)" <?php if($subdet[0]['category_subject']=='Programme Elective(PE)'){ echo "selected";} ?>> Programme Elective(PE)</option>
                                              <option value="Open Elective(OE)" <?php if($subdet[0]['category_subject']=='Open Elective(OE)'){ echo "selected";} ?>> Open Elective(OE)</option>
                                          
                                        </select>                                  
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3">Theory Max<?=$astrik?></label>
                                    <div class="col-sm-3"><input type="text" id="theory_max" name="theory_max" class="form-control numbersOnly" maxlength="3" value="<?=isset($subdet[0]['theory_max']) ? $subdet[0]['theory_max'] : ''?>" required/></div>                                    
                                    <label class="col-sm-3">Theory Min for Pass<?=$astrik?></label>
								    <div class="col-sm-3"><input type="text" id="theory_min_for_pass" name="theory_min_for_pass" class="form-control numbersOnly" maxlength="3" value="<?=isset($subdet[0]['theory_min_for_pass']) ? $subdet[0]['theory_min_for_pass'] : ''?>" required /></div>
                                </div>                                
                                <div class="form-group">
                                    <label class="col-sm-3">Internal Max<?=$astrik?></label>
                                    <div class="col-sm-3"><input type="text" id="internal_max" name="internal_max" class="form-control numbersOnly" maxlength="3" value="<?=isset($subdet[0]['internal_max']) ? $subdet[0]['internal_max'] : ''?>" required/></div>                                    
                                    <label class="col-sm-3">Internal Min for Pass<?=$astrik?></label>
								    <div class="col-sm-3"><input type="text" id="internal_min_for_pass" name="internal_min_for_pass" class="form-control numbersOnly" maxlength="3" value="<?=isset($subdet[0]['internal_min_for_pass']) ? $subdet[0]['internal_min_for_pass'] : ''?>" required/></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3">Sub Max<?=$astrik?></label>
                                    <div class="col-sm-3"><input type="text" id="sub_max" name="sub_max" class="form-control numbersOnly" maxlength="3" value="<?=isset($subdet[0]['sub_max']) ? $subdet[0]['sub_max'] : ''?>" required/></div>
                                    
                                    <label class="col-sm-3">Sub Min<?=$astrik?></label>
								    <div class="col-sm-3"><input type="text" id="sub_min" name="sub_min" class="form-control numbersOnly" maxlength="3" value="<?=isset($subdet[0]['sub_min']) ? $subdet[0]['sub_min'] : ''?>" required/></div>                                    
                                </div>
								
								<div class="form-group">
								<?php 
								if(isset($subdet[0]['syllabus_uploaded']) && $subdet[0]['syllabus_uploaded']=="Y"){
									$var ="Change Syllabus";
									$required ="";
								}else{
									$var ="Upload Syllabus";
									if($this->session->userdata("role_id")==15 || $this->session->userdata("role_id")==6){
										$required =""; 
									}else{
										$required ="required";
									}
								}?>
								<?php 
								//if(isset($subdet[0]['sub_id']) && $subdet[0]['sub_id']!=''){
									?>
                                    <label class="col-sm-3"><?=$var?><?=$astrik?></label>
                                    <div class="col-sm-6">
										<input type="file" name="syllabus" id="syllabus" onchange="validate_fileupload_pdf(this.id);" <?=$required?>>
										<label id="lblpdf_0" style="display:none;font-weight:normal;color:red;" >Please upload files with pdf extensions and Maximum file size of 2 MB</label>
									</div>
									<?php 
								//}
								if(isset($subdet[0]['syllabus_uploaded']) && $subdet[0]['syllabus_uploaded']=="Y"){
									?>
									<div class="col-sm-3">
									<a download href="<?=base_url()?>uploads/syllabus/<?=$subdet[0]['syllabus_path']?>">
										<i class="fa fa-file-pdf-o" aria-hidden="true" style="font-size:20px;color:red;"> Download Syllabus PDF</i></a>
									</div>
								<?php }?>
                                </div>
                                <!--- practical-->
                                <div class="form-group" id="em" style="display:none;">
                                    <label class="col-sm-3">Practical Max<?=$astrik?></label>
                                    <div class="col-sm-3"><input type="text" id="practical_max" name="practical_max" class="form-control numbersOnly" maxlength="3" value="<?=isset($subdet[0]['practical_max']) ? $subdet[0]['practical_max'] : ''?>" required/></div>
                                    
                                    <label class="col-sm-3">Practical Min for Pass<?=$astrik?></label>
                                    <div class="col-sm-3"><input type="text" id="practical_min_for_pass" name="practical_min_for_pass" class="form-control numbersOnly" maxlength="3" value="<?=isset($subdet[0]['practical_min_for_pass']) ? $subdet[0]['practical_min_for_pass'] : ''?>" required/></div>                                    
                                </div>
                                <!--- practical end-->
                                <div class="form-group">
                                    <div class="col-sm-4"></div>
                                    <div class="col-sm-2">
                                        <?php
										if($subdet[0]['sub_id'] !=''){
										?> 
											<button class="btn btn-primary form-control" id="submitfrm" name="submit" type="submit" >Update</button>
										<?php }else{ ?>
										<button class="btn btn-primary form-control" id="submitfrm" name="submit" type="submit" >Submit</button>
										<?php }?>                                        
                                    </div>                                    
                                    <div class="col-sm-2"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule)?>'">Cancel</button></div>
                                    <div class="col-sm-4"></div>
                                </div>
                            </form>
                            <?php //} ?>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
        <script type="text/javascript">
        $('#subject_component').on('change', function () {
            
            var subject_component = $(this).val();
            if (subject_component=='EM' || subject_component=='PR') {
                $('#practical_max').prop('required',true);;
                $('#practical_min_for_pass').prop('required',true);
                $('#em').show();
            } else {
                $('#em').hide();
                $('#practical_max').prop('required',false);;
                $('#practical_min_for_pass').prop('required',false);
            }
        });
            // for edit
             var subject_component = '<?=$subdet[0]['subject_component']?>';
            if (subject_component=='EM' || subject_component=='PR') {
                $('#practical_max').prop('required',true);;
                $('#practical_min_for_pass').prop('required',true);
                $('#em').show();
            } else {
                $('#em').hide();
                $('#practical_max').prop('required',false);;
                $('#practical_min_for_pass').prop('required',false);
            }
        </script>
<!----------------------------------------------------->
		        <!--div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                <div class="panel-heading">
                        <span class="panel-title">Subject List</span>
                        <div class="holder"></div>
                </div>
                <div class="panel-body" style="overflow:scroll;height:400px;">
                    <div class="table-info" >    
                    <?php //if(in_array("View", $my_privileges)) { ?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                    <th>#</th>  
                                    <th>Subject Code</th>
                                    <th>Subject Name</th>
                                    <th>Short Name</th>
                                    <th>Semester</th>
                                    <th>Type</th>
                                    <th>Component</th>
                                    <th>Group</th>
                                    <th>Credits</th>
                                    <th>Edit</th>
                            </tr>
                        </thead>
                        <tbody id="subjectList">                         
                        </tbody>
                    </table>                    
                    <?php //} ?>
                </div>
                </div>
            </div>
            </div>    
        </div-->
    </div>
</div>
<script>
      $(function () {

        $('#form11').on('submit', function (e) {
          e.preventDefault();
		  var course_id = $('#course_id').val(); 
		  if(course_id !=''){
          $.ajax({
            type: 'post',
            url: '<?=base_url($currentModule.'/insert_subject')?>',
            data: $('#form').serialize(),
            success: function (data) {
				$("#btn_submit").removeAttr('disabled');
						if(data!='dupyes'){
							var absent=JSON.parse(data);
							//alert(absent.ss);
							var list_of_sub = absent.ss.length;							
							var str="";
							for(i=0;i< list_of_sub;i++)
							{
								//alert("inside");
								//alert(absent.ss[i].enrollment_no);
								if(absent.ss[i].subject_component=='PR'){
									var subcomp = "Practical";
								}else{
									var subcomp = "Theory";
								}
								str+='<tr>';
								
								str+='<td>'+(i+1)+'</td>';
															
								str+='<td>'+absent.ss[i].subject_code+'</td>';
								str+='<td>'+absent.ss[i].subject_name+'</td>';
								str+='<td>'+absent.ss[i].subject_short_name+'</td>';
								str+='<td>'+absent.ss[i].semester+'</td>';
								str+='<td>'+absent.ss[i].type_name+'</td>';
								str+='<td>'+subcomp+'</td>';
								str+='<td>'+absent.ss[i].subject_group+'</td>';
								str+='<td>'+absent.ss[i].credits+'</td>';
								str+='<td>';
								str+='<a href="<?=base_url(strtolower($currentModule))?>/edit/'+absent.ss[i].sub_id+'"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;';
								str+='</td>';
								$("#subjectList").html(str);
							}
							if(absent.actn=='insert'){
							alert("Subject inserted successfully.");
							}else{
								alert("Subject Updated successfully.");
							}
						}else{
							alert("This Subject is already exist, Please add another");
						}
            }
          });
			}else{
				$('#course_id').focus();
				return false;
			}
        });

      });
    // validation of pdf upload
    function validate_fileupload_pdf(id)
    {
        var size = document.getElementById(id).files[0].size;
        var sFileName = document.getElementById(id).value;
        var ext = sFileName.split('.')[sFileName.split('.').length - 1].toLowerCase();

        if (!(ext === "pdf") || size > 9097152)
        {
            document.getElementById("lblpdf_0").style.display = 'block';
            //        alert("Please upload files with jpeg, jpg, gif, png extensions and Maximum file size should be 1 mb");
            document.getElementById(id).value = null;
			$("#submitfrm").prop('disabled', true);
            return false;
        } else
        {
			$("#submitfrm").prop('disabled', false);
            document.getElementById("lblpdf_0").style.display = 'none';
        }

    }
</script>