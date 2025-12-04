<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<style>
	.table{width: 120%;}
	table{max-width: 120%;}
</style>
<?php //print_r($my_privileges); die; ?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Masters</a></li>
        <li class="active"><a href="#">Time table Master</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Time table <span class="panel-title">for (2017-18)</span></h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                    <?php// if(in_array("Add", $my_privileges)) { ?>
                    <div class="pull-right col-xs-12 col-sm-auto"><a style="width: 100%;" class="btn btn-primary btn-labeled" href="<?=base_url($currentModule."/")?>"><span class="btn-label icon fa fa-plus"></span>Add Time table</a></div>                        
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
                    <div class="row ">
						<div class="col-sm-3">
							
						</div>	
						<div class="col-sm-9" style="color:green;float:left;font-weight: 900;">
							<?php
							if ($this->session->flashdata('Tmessage') != ''): 
								echo $this->session->flashdata('Tmessage'); 
							endif;
							?>
						</div>
					</div>
					<div class="row">
					<form name="searchTT" id="forms" method="POST" action="<?=base_url()?>timetable/ttlist">
						<div class="form-group">
							
                              <div class="col-sm-3" >
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
                              <div class="col-sm-3" id="semest" >
                                <select name="stream_id" id="stream_id" class="form-control" required>
                                  <option value="">Select Stream</option>
                               </select>
                              </div>
								<div class="col-sm-2">
									<select id="semester" name="semester" class="form-control" required>
											<option value="">Semester</option>
											<?php 
											$semesterNo = $semesterNo;
											for($i=1;$i<9;$i++) {
												if ($i == $semesterNo) {
													$sel3 = "selected";
												} else {
													$sel3 = '';
												}
											?>
											<option value="<?=$i?>" <?=$sel3?>><?=$i?></option>
											<?php } ?>
									</select>
								</div> 
								<div class="col-sm-2">
									<select id="division" name="division" class="form-control" required>
											<option value="">Division</option>
											<?php 
											$div = array('A','B','C','D','E','F');
											
											for($i=0;$i<count($div);$i++) {
												if ($div[$i] == $division) {
													$sel4 = "selected";
												} else {
													$sel4 = '';
												}
											?>
											<option value="<?=$div[$i]?>" <?=$sel4?>><?=$div[$i]?></option>
											<?php } ?>
									</select>
								</div>
								<div class="col-sm-2"><input type="submit" class="btn btn-primary" value="Search"></div>
								
                            </div>
                              </form> 
					</div>
                </div>
                <div class="panel-body">
				
                    <div class="table-info" style="overflow:scroll;height:500px;">    
                    <?php //if(in_array("View", $my_privileges)) { ?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                    <th>#</th>
                                    <!--th>Academic Year</th>
                                    <th>Stream Name</th>
                                    <th>Semester</th-->
                                    <th>Subject Name</th>
                                    <th>Type</th>
                                    <th>Division</th>
									<th>Batch No</th>
                                    <!--th>Room No</th-->
									<th>Faculty</th>
									<th>Day</th>
									<th>Slot</th>
                                    <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php
                            $j=1;
							if(!empty($tt_details)){
                            for($i=0;$i<count($tt_details);$i++)
                            {
                                
                            ?>
                            <tr <?=$tt_details[$i]["status"]=="N"?"style='background-color:#FBEFF2'":""?>>
                                <td><?=$j?></td>     
								<!--td><?=$tt_details[$i]['academic_year']?></td>								
                                <td><?=$tt_details[$i]['stream_name']?></td>
                                <td><?=$tt_details[$i]['semester']?></td-->
                                <td>
								<?php
								if($tt_details[$i]['subject_code']== 'OFF'){
									echo "OFF Lecture";
								}else if($tt_details[$i]['subject_code']=='Library'){
									echo "Library";
								}else if($tt_details[$i]['subject_code']== 'Tutorial'){
									echo "Tutorial";
								}else if($tt_details[$i]['subject_code']== 'Tutor'){
									echo "Tutor";
								}else{
									echo $tt_details[$i]['sub_code'].' - '.$tt_details[$i]['subject_name'];
								}
								?>
								</td>
                                <td><?=$tt_details[$i]['subject_type']?></td>
                                <td><?=$tt_details[$i]['division']?></td>
                                <td><?=$tt_details[$i]['batch_no']?></td>
                                <!--td><?=$tt_details[$i]['room_no']?></td-->
								<td><?=strtoupper($tt_details[$i]['fname'][0].'. '.$tt_details[$i]['mname'][0].'. '.$tt_details[$i]['lname']);?></td>
								<td><?=$tt_details[$i]['wday']?></td>
								<td><?=$tt_details[$i]['from_time']?> - <?=$tt_details[$i]['to_time']?> <?=$tt_details[$i]['slot_am_pm']?></td>
                                <td>
                                    <?php //if(in_array("Edit", $my_privileges)) { ?>
                                    <a href="<?=base_url($currentModule."/edit/".$tt_details[$i]['time_table_id'])?>">
									<i class="fa fa-edit"></i></a> |
									<a href="<?=base_url($currentModule."/removeTimetableEntry/".$tt_details[$i]['time_table_id'])?>" class="tt">
									<i class="fa fa-trash-o"></i></a> 
																		
                                    <?php// } ?>
                                    <?php //if(in_array("Delete", $my_privileges)) { ?>
                                    <!--a href='<?=base_url($currentModule).$tt_details[$i]["status"]=="Y"?"disable/".$tt_details[$i]["time_table_id"]:"enable/".$tt_details[$i]["sub_id"]?>'><i class='fa <?=$tt_details[$i]["status"]=="Y"?"fa-ban":"fa-check"?>' title='<?=$tt_details[$i]["status"]=="Y"?"Disable":"Enable"?>'></i></a-->
                                    <?php //} ?>
                                </td>
                            </tr>
                            <?php
                            $j++;
                            }
							}else{
								echo "<tr>";echo "<td colspan=13>";echo "No data found.";echo "</td>";echo "</tr>";
							}
                            ?>                            
                        </tbody>
                    </table>                    
                    <?php //} ?>
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
				'url' : base_url + '/Batch_allocation/load_streams',
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
			if (course_id) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>batch_allocation/load_streams',
					data: 'course_id=' + course_id,
					success: function (html) {
						//alert(html);
						$('#stream_id').html(html);
					}
				});
			} else {
				$('#stream_id').html('<option value="">Select course first</option>');
			}
		});
		
    });

</script>
<script>
  $("div.holder").jPages
  ({
    containerID : "itemContainer1"
  });
  $("#search_me").select2({
      placeholder: "Enter Time table name",
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
                    for(i=0;i<array.tt_details.length;i++)
                    {
                        str+='<tr style="display: table-row; opacity: 1;">';
                        str+='<td>'+(i+1)+'</td>';                                                                                                
                        str+='<td>'+array.tt_details[i].campus_name+'</td>';
                        str+='<td>'+array.tt_details[i].college_code+'</td>';
                        str+='<td>'+array.tt_details[i].college_name+'</td>';
                        str+='<td>'+array.tt_details[i].college_state+'</td>';
                        str+='<td>'+array.tt_details[i].college_city+'</td>';                        
                        str+='<td>'+array.tt_details[i].college_pincode+'</td>';
                        str+='<td>'+array.tt_details[i].college_address+'</td>';
                        str+='<td>';
                        str+='<a href="<?=base_url(strtolower($currentModule))?>/edit/'+array.tt_details[i].college_id+'"><i class="fa fa-edit"></i></a>';
                        str+='<a href="<?=base_url(strtolower($currentModule))?>/disable/'+array.tt_details[i].college_id+'"><i title="Disable" class="fa fa-ban"></i></a>';
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
				$('.tt').click(function(){
			var checkstr =  confirm('Are you sure you want to delete this?');
			if(checkstr == true){
			  // do your code
			}else{
			return false;
			}
			});
</script>