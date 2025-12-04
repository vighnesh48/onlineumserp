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
				'url' : base_url + '/Subject/load_streams_sub',
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
        <li class="active"><a href="#"><?=$ed?> Subject Component</a></li>
    </ul>
    <div class="page-header">			
       <!--  <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-book page-header-icon"></i>&nbsp;&nbsp;<?=$ed?> Subject</h1> <span class="blinking pull-left">Last date for adding/updating Course master is 3<sup>rd</sup> July 2019 </span>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                </div>
            </div>
        </div> -->
        <div class="row ">
            <div class="col-sm-12">&nbsp;</div>
        </div>
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-heading">
                            <span class="panel-title">Subject Component Details</span>
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
							
                            <form id="form" name="form" method="POST" action="<?=base_url($currentModule.'/insert_subject_component')?>" enctype="multipart/form-data">                                                               
                          <!--   <input type="hidden" value="<?=isset($subdet[0]['sub_id']) ? $subdet[0]['sub_id'] : ''?>" id="sub_id" name="sub_id" /> -->

                            <div class="form-group">
                              <label class="col-sm-3">Regulation <?= $astrik ?></label>
                              <div class="col-sm-3" >
                                <select name="regulation" id="regulation" class="form-control" required>
                                  <option value="">Select</option>
                                  <?php

                                    foreach ($regulatn as $reg) {
                                        if ($reg['regulation'] == $subdet[0]['regulation']) {
                                            $sel = "selected";
                                        } else {
                                            $sel = '';
                                        }
                                        echo '<option value="' . $reg['regulation'] . '"' . $sel . '>' . $reg['regulation'] . '</option>';
                                    }
                                    ?>
                               </select>
                              </div>
							<label class="col-sm-3">Batch <?= $astrik ?></label>
                              <div class="col-sm-3" >
                                <select name="batch" id="batch" class="form-control" required>
                                  <option value="">Select</option>
                                  <?php
								  $batches = array('2016','2017','2018','2019','2020','2021','2022','2023','2024','2025');
                                    foreach ($batches as $bt) {
                                        if ($bt== $subdet[0]['batch']) {
                                            $sel = "selected";
                                        } else {
                                            $sel = '';
                                        }
                                        echo '<option value="' . $bt . '"' . $sel . '>' . $bt . '</option>';
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
												'url' : base_url + '/Subject/load_streams_sub',
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
										if ($branch['branch_code'] == $subdet[0]['stream_id']) {
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
									<select id="semester_id" name="semester_id" class="form-control" required>
                                            <option value="">Select Semester</option>
											<?php for($i=1;$i<9;$i++) {
												if ($i == $subdet[0]['semester_id']) {
												$sel3 = "selected";
												} else {
													$sel3 = '';
												}
											?>
                                            <option value="<?=$i?>" <?=$sel3?>><?=$i?></option>
                                            <?php } ?>
											</select>
									</div>  
                                       <label class="col-sm-3">total Subject<?=$astrik?></label>
                                    <div class="col-sm-3">
                                      <input type="text" id="total_subject" name="total_subject" class="form-control" value="<?=isset($subdet[0]['total_subject']) ? $subdet[0]['total_subject'] : ''?>" placeholder="Subject" required/>
                                    </div>    
							
                                    
                                </div>
                                <div class="form-group">
                                            <label class="col-sm-3">Subject Theory<?=$astrik?></label>
                                    <div class="col-sm-3">
                                      <!-- <select id="subject_component" name="subject_component" class="form-control" required>
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
                                        </select> -->
                                         <input type="text" id="theory" name="theory" class="form-control" value="<?=isset($subdet[0]['theory']) ? $subdet[0]['theory'] : ''?>" placeholder="Theory" required/>
                                    </div>
                                       
                                    <!-- <label class="col-sm-3">Subject Component<?=$astrik?></label> -->
                                      <label class="col-sm-3">Practical<?=$astrik?></label>
                                    <div class="col-sm-3">
                                      <input type="text" id="practical" name="practical" class="form-control" value="<?=isset($subdet[0]['practical']) ? $subdet[0]['practical'] : ''?>" placeholder="Practical" required/>
                                    </div>  
                                 
                                    
                                </div>
                                    <div class="form-group">
                                             <label class="col-sm-3">Embadded Lab<?=$astrik?></label>
                                    <div class="col-sm-3">
                                      <!-- <select id="subject_component" name="subject_component" class="form-control" required>
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
                                        </select> -->
                                         
                                           <input type="hidden" id="academic_year" name="academic_year" class="form-control" value="<?= date("Y")?>" placeholder="Embadded Lab" required/>
                                         <input type="text" id="embadded" name="embadded" class="form-control" value="<?=isset($subdet[0]['embadded']) ? $subdet[0]['embadded'] : ''?>" placeholder="Embadded Lab" required/>

                                    </div>
                                       
                             
                                 
                                    
                                </div>
                         
                          
                         
                                <!--- practical end-->
                                <div class="form-group">
                                    <div class="col-sm-4"></div>
                                    <div class="col-sm-2">
                                        <?php
										if($subdet[0]['sub_comid'] !=''){
										?> 
											<button class="btn btn-primary form-control" id="submitfrm" name="submit" type="submit" >Update</button>
										<?php }else{ ?>
										<button class="btn btn-primary form-control" id="submitfrm" name="submit" type="submit" >Submit</button>
										<?php }?>                                        
                                    </div>                                    
                                    <div class="col-sm-2"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule)?>/Subject_component_details'">Cancel</button></div>
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
            if (subject_component=='EM') {
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
            if (subject_component=='EM') {
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