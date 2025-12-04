<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<style>
	.table{width: 100%;}
	table{max-width: 100%;}
</style>
<script>
function create_login(stid,type1)
{
     $.ajax({
                    'url' : base_url + '/Ums_admission/create_stu_par_login',
                    'type' : 'POST', //the way you want to send data to your URL
                    'data' : {'um_id':stid,'type1':type1},
                    'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
                       if(type1=="S"){var container = $('#csid');}else{var container = $('#cpid');} //jquery selector (get element by id)
                        if(data){
                            
                       // alert(data);
                            alert("Account Created");
                            //$("#"+type).val('');
                            container.html(data);
                            	return false;
                        }
                          return false;
                    }
                });
}
function change_status(var1,status1,type1,stid)
{
//alert(var1);
var text='';
if(status1=="Y")
{
  text = "Are you sure you want to deactivate account";  
}
else
{
    text = "Are you sure you want to activate account";  
}
//var txt;
    if (confirm(text) == true) {
       // txt = "You pressed OK!";
        
    } 
    else
    {
        return false;
    }


 $.ajax({
                    'url' : base_url + '/Ums_admission/activate_student_login',
                    'type' : 'POST', //the way you want to send data to your URL
                    'data' : {'um_id':var1,'type1':type1,'stid':stid},
                    'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
                       if(type1=="S"){var container = $('#stest');}else{var container = $('#ptest');} //jquery selector (get element by id)
                        if(data){
                            
                       // alert(data);
                            //alert("Marks should be less than maximum marks");
                            //$("#"+type).val('');
                            container.html(data);
                            	return false;
                        }
                          return false;
                    }
                });












//$('#stest').html('hi');
}

</script>
<script>
 $(document).ready(function(){
               $('#sbutton').click(function(){
            
         // alert("hi");
             var base_url = 'https://erp.sandipuniversity.com/';
                   // alert(type);
                   var acourse = $("#course_id").val();
                    var astream = $("#stream_id").val();
                    var ayear = $("#year").val();
                    
                     if(acourse=='')
                    {
                        alert("Please Select Course");
                        return false;
                    }
                    
                    
                    if(astream=='')
                    {
                          alert("Please Select Stream");
                        return false;
                        
                    }
                    
                    if(ayear=='')
                    {
                          alert("Please Select Year");
                        return false;
                        
                    }
                    
                $.ajax({
                    'url' : base_url + '/Ums_admission/load_login_list',
                    'type' : 'POST', //the way you want to send data to your URL
                    'data' : {'astream':astream,'ayear':ayear},
                    'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
                        var container = $('#itemContainer'); //jquery selector (get element by id)
                        if(data){
                            
                       // alert(data);
                            //alert("Marks should be less than maximum marks");
                            //$("#"+type).val('');
                            container.html(data);
                            	return false;
                        }
                          return false;
                    }
                });
            });
            });

</script>
<?php //print_r($my_privileges); die; ?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Masters</a></li>
        <li class="active"><a href="#">Admission</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Login List</h1>
            <div class="col-xs-12 col-sm-8">
                
            </div>
        </div>
        <div class="row ">
            <div class="col-sm-12">&nbsp;</div>
        </div>
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                <div class="panel-heading">
                      	<div class="row">
					<form name="searchTT" id="forms" method="POST" action="<?=base_url()?>ums_admission/login_list">
						<div class="form-group">
							
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
                              <div class="col-sm-4" id="semest" >
                                <select name="stream_id" id="stream_id" class="form-control" required>
                                  <option value="">Select Stream</option>
                               </select>
                              </div>
								<div class="col-sm-2">
									<select id="year" name="year" class="form-control">
											<option value="">Select Year</option>
											<?php 
											$semesterNo =$_REQUEST['semester'];
											for($i=1;$i<5;$i++) {
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
								
								<!--	<div class="col-sm-2"><select name="created" id="created"  class="form-control">
											<option value="">Select </option>
									    <option value="C">Created</option>
									    <option value="N">Not Created</option>
									    
									</select></div>
								
								<div class="col-sm-2"><select name="active" id="active"  class="form-control">
											<option value="">Select </option>
									    <option value="A">Activated</option>
									    <option value="I">Non Activated</option>
									    
									</select></div>-->
									
								
								<div class="col-sm-2"><input type="button" id="sbutton" class="btn btn-primary" value="Search"></div>
								
                            </div>
                              </form> 
					</div>  
                </div>
                <div class="panel-body">
			
                    <div class="table-info" >    
                    <?php //if(in_array("View", $my_privileges)) { ?>
                
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                    <th rowspan="2" width="5%">#</th>
                                    <th rowspan="2" width="5%"><input type='checkbox' name='selectall'></th>
                                    <th rowspan="2" width="10%">PRN</th>
                                    <th rowspan="2" width="30%">Student Name</th>
                                    <th rowspan="2" width="5%">Year</th>
                                    <th colspan="3" width="15%">Student Login</th>
                                    <th colspan="3" width="15%">Parent Login </th>
                                    <!--<th rowspan="2">Action</th>-->
                            </tr>
                             <tr>
                                    <th>Created</th>
                                    <th>Active</th>
                                    <th>Action</th>
                                    <th>Created</th>
                                    <th>Active</th>
                                     <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php
                            $j=1;  
							if(!empty($subj_details)){
                            for($i=0;$i<count($subj_details);$i++)
                            {
                                
                            ?>
                            <tr <?=$subj_details[$i]["status"]=="N"?"style='background-color:#FBEFF2'":""?>>
                                <td><?=$j?></td> 
                                <td><?=$subj_details[$i]['stream_name']?></td>
                                <td><?=$subj_details[$i]['subject_code']?></td>
								<td><?=$subj_details[$i]['subject_name']?></td>								
                                <td><?=$subj_details[$i]['subject_short_name']?></td>
                                <td><?=$subj_details[$i]['semester']?></td>
                                <td><?=$subj_details[$i]['type_name']?></td>
                                <td><?php 
                                if($subj_details[$i]['subject_component']=='PR'){ echo 'Practical';}else{ echo 'Theory';}
                                ?></td>
                                <td><?=$subj_details[$i]['subject_group']?></td>
                                <td><?=$subj_details[$i]['credits']?></td>
                                <td>
                                    <?php //if(in_array("Edit", $my_privileges)) { ?>
                                    <a href="<?=base_url($currentModule."/edit/".$subj_details[$i]['sub_id'])?>"><i class="fa fa-edit"></i></a>                                                                        
                                    <?php// } ?>
                                    <?php //if(in_array("Delete", $my_privileges)) { ?>
                                    <!--a href='<?=base_url($currentModule).$subj_details[$i]["status"]=="Y"?"disable/".$subj_details[$i]["sub_id"]:"enable/".$subj_details[$i]["sub_id"]?>'><i class='fa <?=$subj_details[$i]["status"]=="Y"?"fa-ban":"fa-check"?>' title='<?=$subj_details[$i]["status"]=="Y"?"Disable":"Enable"?>'></i></a-->
                                    <?php //} ?>
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


</script>