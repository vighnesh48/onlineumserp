<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<style>
.disabled {
  pointer-events: none;
  cursor: default;
  opacity: 0.6;
}

.table{width: 100%;}
	table{max-width: 100%;}
	
.blinking{
    animation:blinkingText 7.2s infinite;
}
@keyframes blinkingText{
    0%{     color: red;    }
    49%{    color: transparent; }
    50%{    color: red; }
    99%{    color:red;  }
    100%{   color: red;    }
}
</style>
<?php $role_id = $this->session->userdata('role_id'); ?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Masters</a></li>
        <li class="active"><a href="#">Subject Master</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-book page-header-icon"></i>&nbsp;&nbsp;Subject List</h1><!--span class="blinking pull-left">Last date for adding/updating Course master is 13<sup>rd</sup> JAN 2020 </span-->
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                    <?php //if(in_array("Add", $my_privileges)) { ?>
                    <div class="pull-right col-xs-12 col-sm-auto"><a style="width: 100%;" class="btn btn-primary btn-labeled" href="<?=base_url($currentModule."/add")?>"><span class="btn-label icon fa fa-plus"></span>Add Subject</a></div>                        
                    <div class="visible-xs clearfix form-group-margin"></div>
                    <?php //} ?>

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
                        	
                        <span class="panel-title">
                        
                        <form name="searchTT" id="forms" method="POST" action="<?=base_url()?>subject/index">
						<div class="form-group">
							<div class="col-sm-2" >
                                <select name="batch" id="batch" class="form-control" required>
                                  <option value="">Select Batch</option>
                                  <?php
                                    foreach ($batches as $bth) {
                                        if ($bth['batch'] == $batch) {
                                            $sel = "selected";
                                        } else {
                                            $sel = '';
                                        }
                                        echo '<option value="' . $bth['batch'] . '"' . $sel . '>' . $bth['batch'] . '</option>';
                                    }
                                    ?>
                               </select>
                              </div>
                              <div class="col-sm-2" >
                                <select name="regulation" id="regulation" class="form-control" required>
                                  <option value="">Select Regulation</option>
                                  <?php
                                    foreach ($regulatn as $reg) {
                                        if ($reg['regulation'] == $regulation) {
                                            $sel = "selected";
                                        } else {
                                            $sel = '';
                                        }
                                        echo '<option value="' . $reg['regulation'] . '"' . $sel . '>' . $reg['regulation'] . '</option>';
                                    }
                                    ?>
                               </select>
                              </div>
							  
                              <div class="col-sm-2" >
                                <select name="course_id" id="course_id" class="form-control" required>
                                  <option value="">Select Course</option>
                                  <?php
									foreach ($course_details as $course) {
										if ($course['course_id'] == $courseId) {
											$sel = "selected";
										} else {
											$sel = '';
										}
										echo '<option value="' . $course['course_id'] . '"' . $sel . '>' . $course['course_short_name'] . '</option>';
									}
									?>
                               </select>
                              </div> 
                              <div class="col-sm-2">
                                <select name="stream_id" id="stream_id" class="form-control" required>
                                  <option value="">Select Stream</option>
                               </select>
                              </div>
								<div class="col-sm-2">
									<select id="semester" name="semester" class="form-control">
											<option value="">Semester</option>
											<?php 
											$semesterNo = $semesterNo;
											/*for($i=1;$i<9;$i++) {
												if ($i == $semesterNo) {
													$sel3 = "selected";
												} else {
													$sel3 = '';
												}
											?>
											<option value="<?=$i?>" <?=$sel3?>><?=$i?></option>
											<?php } */?>
									</select>
								</div> 
								
								<div class="col-sm-2"><input type="submit" class="btn btn-primary form-control" value="Search"></div>
								
                            </div>
                              </form> </span>
                        <div class="holder"></div>
                </div>
                <div class="panel-body" style="overflow-y: auto;">
				     <div class="row ">
						<div class="col-sm-9" style="color:green;float:left;font-weight: 900;">
							<?php
							if ($this->session->flashdata('message') != ''): 
								echo $this->session->flashdata('message'); 
							endif;
							?>
						</div>
					</div>
				<div class="row">
					</div>
                    <div class="table-info">
                        <?php if(!empty($_POST) || !empty($this->session->userdata('Ssemester'))){?>
                        <b>Stream Name:</b><?=$subj_details[0]['stream_short_name']?>, <b>Semester:</b><?=$semesterNo?>, <b>Batch:</b><?=$batch?></span>   
                        <?php }?>
                    <?php if(in_array("View", $my_privileges)) { ?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                    <th>#</th>
									<!--th>Batch</th>
                                    <th>Reg</th-->
                                    <th>Code</th>
                                    <th>Subject Name</th>
                                    <th>Evaluation Board</th>
                                    <th>Sem</th>
                                    <th>Type</th>
									
                                    <th>Component</th>
                                    						
                                    <th>Credits</th>
									<th>Order</th>
                                   
                                   <?php if($this->session->userdata('role_id')==6 || $this->session->userdata('role_id')==15 || $this->session->userdata('role_id')==10 || $this->session->userdata('role_id')==20 || $this->session->userdata('role_id')==44 || $this->session->userdata('role_id')==68){?>
                                    <th>Syllabus</th>
									<th>COs</th>
									<th>Question</th>
                                    <?php }?>
									 <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php
                            $j=1;  
							if(!empty($subj_details)){
                            for($i=0;$i<count($subj_details);$i++)
                            {
								if($subj_details[$i]['subject_category']=='NCR'){
									$subject_category = '*';
								}elseif($subj_details[$i]['subject_category']=='MNR'){
									$subject_category = '**';
								}elseif($subj_details[$i]['subject_category']=='ADL'){
									$subject_category = '***';
								}elseif($subj_details[$i]['subject_category']=='URE'){
									$subject_category = '****';
								}else{
									$subject_category='';
								}
                            ?>
                            <tr <?=$subj_details[$i]["status"]=="N"?"style='background-color:#FBEFF2'":""?>>
                                <td><?=$j?></td> 
								<!--td><?=$subj_details[$i]['batch']?></td>
                                <td><?=$subj_details[$i]['regulation']?></td-->
                                <td><?=$subj_details[$i]['subject_code']?></td>
								<td style="width:250px;"><?=$subj_details[$i]['subject_name']?> <?=$subject_category;?></td>								
                                <td><?=$subj_details[$i]['evaluation_board']?></td>
                                <td><?=$subj_details[$i]['semester']?></td>
                                <td><?=$subj_details[$i]['type_name']?></td>
								
                                <td><?php 
                                if($subj_details[$i]['subject_component']=='PR'){ echo 'Practical';}else{ echo 'Theory';}
                                ?></td>
                                
                                <td><?=$subj_details[$i]['credits']?></td>
								<td><?=$subj_details[$i]['subject_order']?></td>
                                
                                <?php if($this->session->userdata('role_id')==6 || $this->session->userdata('role_id')==15 || $this->session->userdata('role_id')==10 || $this->session->userdata('role_id')==20 || $this->session->userdata('role_id')==44 || $this->session->userdata('role_id')==68){?>
                                    <!--th><button type="button" class="btn btn-info" onclick="add_subjects(<?=$subj_details[$i]['sub_id']?>);">Add</button></th-->
									<th><a href="<?=base_url("SyllabusController/index/".$subj_details[$i]['sub_id']."/1")?>" target="_blank"><button type="button" class="btn btn-info" ><i class="fa fa-plus-circle"></i>Add Syllabus</button></a> </th>
									<th><a href="<?=base_url("Course_outcomes/index/".$subj_details[$i]['sub_id']."/1")?>" target="_blank"><button type="button" class="btn btn-info" ><i class="fa fa-plus-circle"></i>COs </button></a> </th>
									<th><a href="<?=base_url("assignment_question_bank/index/".encrypt_id($subj_details[$i]['sub_id'])."/1")?>" target="_blank"><button type="button" class="btn btn-info" ><i class="fa fa-plus-circle"></i>Question Bank </button></a> </th>
                                    <?php }?>
									<td>
                                    <?php 
                                    if($subj_details[$i]['is_final']=='N') { 
                                        $dis_cls = "";
                                    }else{
                                        $dis_cls = "disabled";
                                    }
									$cred_date= explode('-', $subj_details[$i]['created_on']);
									if($cred_date[0]=='2019' || ($this->session->userdata('role_id')==15) || ($this->session->userdata('role_id')==30) || ($this->session->userdata('role_id')==20)  || ($this->session->userdata('role_id')==6) || $this->session->userdata('role_id')==10 || $this->session->userdata('role_id')==23 || $this->session->userdata('role_id')==44){
                                    ?>
                                    <a href="<?=base_url($currentModule."/edit/".$subj_details[$i]['sub_id'])?>" class="<?=$dis_cls?>"><i class="fa fa-edit <?=$dis_cls?>" ></i></a> | 
                                    <a href="<?=base_url($currentModule."/removeSubject/".$subj_details[$i]['sub_id'])?>" class="tt <?=$dis_cls?>">
									<i class="fa fa-trash-o <?=$dis_cls?>"></i></a> 

                                    <?php if(in_array("Delete", $my_privileges)) { ?>
                                    <!--a href='<?=base_url($currentModule).$subj_details[$i]["status"]=="Y"?"disable/".$subj_details[$i]["sub_id"]:"enable/".$subj_details[$i]["sub_id"]?>'><i class='fa <?=$subj_details[$i]["status"]=="Y"?"fa-ban":"fa-check"?>' title='<?=$subj_details[$i]["status"]=="Y"?"Disable":"Enable"?>'></i></a-->
                                    <?php } ?>
									 <?php } ?>
                                </td>
                            </tr>
                            <?php 
                            $j++;
                            }
							}else{
								echo "<tr><td colspan=11>No data found.</td></tr>";
							}
                            ?>                            
                        </tbody>
                    </table>
					<?php } if(!empty($_POST)){ ?>
					<table class="table table-bordered" style="width:100%!important;">
                        <tr>
                            <td width="15%"><b>Total Subjects :</b> <input type="text" name="total_subject" id="total_subject" class="form-control numbersOnly" maxlength="2" value="<?php if(!empty($stream_mapping[0]['total_subject'])){ echo $stream_mapping[0]['total_subject'];}?>"></td>
                            <td width="15%"><b>Compulsary : </b><input type="text" name="compulsary" id="compulsary" class="form-control numbersOnly" maxlength="2" value="<?php if(!empty($stream_mapping[0]['compulsary'])){ echo $stream_mapping[0]['compulsary'];}?>"></td>
                            <td width="15%"><b>Elective :</b> <input type="text" name="elective" id="elective" class="form-control numbersOnly" maxlength="2" value="<?php if(!empty($stream_mapping[0]['elective'])){ echo $stream_mapping[0]['elective'];}?>"></td>
                            <td width="15%"><b>Group Subject :</b> <input type="text" name="group_subject" id="group_subject" class="form-control numbersOnly" maxlength="2" value="<?php if(!empty($stream_mapping[0]['group_subject'])){ echo $stream_mapping[0]['group_subject'];}?>"></td>
                            <td width="20%"><input type="button" name="saveInfo" id="saveInfo" value="Save" class="btn btn-primary pull-left" style="margin-top: 15px;"> </td>
                            
                            <td width="20%">
                                <?php if($subj_details[0]['is_final']=='N'){ ?>
                                <button class="btn btn-primary pull-right" id="locksubjects" style="margin-top: 15px;">Lock All Subjects</button>
                            <?php }else{
                                if($role_id==6 || $role_id==15 ){ //|| $role_id==30 || $role_id==10 || $role_id==20  || $role_id==44 ?>
                                <button class="btn btn-primary pull-right" id="unlocksubjects" style="margin-top: 15px;">UnLock All Subjects</button>
                            <?php } 
                            }?>
                            </td>
                        </tr>

                    </table> 
					<?php }?>
					
                    <?php if(!empty($courseId)){?>
                    <a href="<?=base_url()?>subject/downloadPdf/<?=$courseId?>/<?=$streamId?>/<?=$semesterNo?>/<?=$regulation?>/<?=$batch?>"><button class="btn btn-primary" >PDF</button>	
                    <a href="<?=base_url()?>subject/subject_report_excel/<?=$courseId?>/<?=$streamId?>/<?=$semesterNo?>/<?=$regulation?>/<?=$batch?>"><button class="btn btn-primary" >Excel</button>
					
                    <?php } ?>
                </div>
                </div>
            </div>
            </div>    
        </div>
    </div>
</div>
<script>    
    $(document).ready(function()
    {
		$('#saveInfo').on('click', function () {
            //alert('alert');
            var regulation = $("#regulation").val();
            var stream_id = $("#stream_id").val();
            var semester = $("#semester").val();
            var total_subject = $("#total_subject").val();
            var group_subject=$("#group_subject").val();
            var elective=$("#elective").val();
            var compulsary=$("#compulsary").val();

            if (total_subject!='') {
                $.ajax({
                    type: 'POST',
                    url: '<?= base_url() ?>subject/update_stream_mapping',
                    data: {batch:regulation,total_subject:total_subject,group_subject:group_subject,elective:elective,stream_id:stream_id,semester:semester,compulsary:compulsary},
                    success: function (html) {
                        if(html=='SUCCESS'){
                            alert("Successfully Updated");
                        }else{
                            alert("Problem while adding");
                        }
                    }
                });
            }else{
                alert('Please Enter all The input fields.');
            }
        });
        //
        $('#locksubjects').on('click', function () {
            //alert('alert');
            if(confirm("Are you sure to Lock the Subjects?")){
                var regulation = $("#regulation").val();
                var stream_id = $("#stream_id").val();
                var semester = $("#semester").val();
    
                if (stream_id!='') {
                    $.ajax({
                        type: 'POST',
                        url: '<?= base_url() ?>subject/update_lock_subjects',
                        data: {batch:regulation,stream_id:stream_id,semester:semester},
                        success: function (html) {
                            if(html=='SUCCESS'){
                                alert("Successfully Locked");
                                location.reload();
                            }else{
                                alert("Problem while Locking");
                            }
                        }
                    });
                }else{
                    //alert('Please Enter all The input fields.');
                }
            }else{
		        return false;
	        } 
        });
         $('#unlocksubjects').on('click', function () {
            //alert('alert');
            if(confirm("Are you sure to UnLock the Subjects?")){
                var regulation = $("#regulation").val();
                var stream_id = $("#stream_id").val();
                var semester = $("#semester").val();
    
                if (stream_id!='') {
                    $.ajax({
                        type: 'POST',
                        url: '<?= base_url() ?>subject/update_unlock_subjects',
                        data: {batch:regulation,stream_id:stream_id,semester:semester},
                        success: function (html) {
                            if(html=='SUCCESS'){
                                alert("Successfully UnLocked");
                                location.reload();
                            }else{
                                alert("Problem while UnLocking");
                            }
                        }
                    });
                }else{
                    //alert('Please Enter all The input fields.');
                }
            }else{
		        return false;
	        } 
        });
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
				'url' : base_url + 'Batch_allocation/load_streams',
				'type' : 'POST', //the way you want to send data to your URL
				'data' : {'course_id' : course_id},
				'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
					var container = $('#stream_id'); //jquery selector (get element by id)
					if(data){
						var stream_id = '<?=$streamId ?>';
						container.html(data);
						$("#stream_id option[value='" + stream_id + "']").attr("selected", "selected");
					}
				}
			});
		}
		// fetch stream form course
	var stream_id = $("#semester").val();
	if(stream_id !=''){
		$("#sem_id").val(stream_id);
	}
		// fetch subject of sem_acquire
		$("#stream_id").change(function(){
			//alert("hi");
		  $('#semester option').attr('selected', false);
		});
		
		$("#semester").change(function(){
			var streamId = $("#stream_id").val();
			var course_id = $("#course_id").val();
			var semesterId = $("#semester").val();
			
			$.ajax({
				'url' : base_url + 'Batch_allocation/load_subject',
				'type' : 'POST', //the way you want to send data to your URL
				'data' : {'course' : course_id,'streamId':streamId,'semesterId':semesterId},
				'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
					var container = $('#subject'); //jquery selector (get element by id)
					if(data){
						//alert(data);
						container.html(data);
						//$("#semest option[value='" + stream_id + "']").attr("selected", "selected");
					}
				}
			});
		});
		$('#course_id').on('change', function () {
			
			var course_id = $(this).val();
			var batch = $("#batch").val();
			var regulation = $("#regulation").val();
			if (course_id) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>subject/load_streams',
					data: {course_id:course_id,batch:batch,regulation:regulation},
					success: function (html) {
						//alert(html);
						$('#stream_id').html(html);
					}
				});
			} else {
				$('#stream_id').html('<option value="">Select course first</option>');
			}
		});
		// alert for removing subject
		$('.tt').click(function(){
			var checkstr =  confirm('Are you sure you want to delete this?');
			if(checkstr == true){
			  // do your code
			}else{
			return false;
			}
			});
			
	 $('#stream_id').change(function () {
        var stream_id = $("#stream_id").val();
		var batch = $("#batch").val();
		var regulation = $("#regulation").val();
		if (stream_id) {
			$.ajax({
				'url' : base_url + 'Subject/load_semester',
				'type' : 'POST', //the way you want to send data to your URL
				'data' : {'batch' : batch,stream_id:stream_id,regulation:regulation},
				'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
					var container = $('#semester'); //jquery selector (get element by id)
					if(data){	
						container.html(data);
					}
				}
			});
		}
    });			
	// edit Semester
	var stream_id = '<?=$streamId ?>';
		var batch = '<?=$batch?>';
		var regulation = '<?=$regulation?>';
		if (stream_id) {
			$.ajax({
				'url' : base_url + 'Subject/load_semester',
				'type' : 'POST', //the way you want to send data to your URL
				'data' : {'batch' : batch,stream_id:stream_id,regulation:regulation},
				'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
					var container = $('#semester'); //jquery selector (get element by id)
					if(data){	
					var sem = '<?=$semesterNo?>';
						container.html(data);
						$("#semester option[value='" + sem + "']").attr("selected", "selected");
					}
				}
			});
		}
    });

</script>
<script>
  $("div.holder").jPages
  ({
    containerID : "itemContainer1"
  });
  $("#search_me").select2({
      placeholder: "Enter subject name",
      allowClear: true
    });
        $("#search_me").on('change',function()
        {
            var search_val = $(this).val();            
            var url  = "<?=base_url().strtolower($currentModule).'/search/'?>";	
            var data = {title: search_val};		
            var type="";
            var type_name="";
            $.ajax
            ({
                type: "POST",
                url: url,
                data: data,
                dataType: "html",
                cache: false,
                crossDomain: true,
                success: function(data)
                {                       
                    var array=JSON.parse(data);
                    var str="";
                    for(i=0;i<array.subj_details.length;i++)
                    {
                        str+='<tr style="display: table-row; opacity: 1;">';
                        str+='<td>'+(i+1)+'</td>';                                                                                                
                        str+='<td>'+array.subj_details[i].campus_name+'</td>';
                        str+='<td>'+array.subj_details[i].college_code+'</td>';
                        str+='<td>'+array.subj_details[i].college_name+'</td>';
                        str+='<td>'+array.subj_details[i].college_state+'</td>';
                        str+='<td>'+array.subj_details[i].college_city+'</td>';                        
                        str+='<td>'+array.subj_details[i].college_pincode+'</td>';
                        str+='<td>'+array.subj_details[i].college_address+'</td>';
                        str+='<td>';
                        str+='<a href="<?=base_url(strtolower($currentModule))?>/edit/'+array.subj_details[i].college_id+'"><i class="fa fa-edit"></i></a>';
                        str+='<a href="<?=base_url(strtolower($currentModule))?>/disable/'+array.subj_details[i].college_id+'"><i title="Disable" class="fa fa-ban"></i></a>';
                        str+='</td>';
                        str+='</tr>';
                        $("#itemContainer").html(str);
                    }
                },
                error: function(data)
                {
                    alert("Page Or Folder Not Created..!!");
                }
            });
        });
        function add_subjects(id){
		var url = '<?=base_url()?>';
		window.location.href=url+"Syllabus/add_syllabus/"+id;
	}
</script>