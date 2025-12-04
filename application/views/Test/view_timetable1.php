<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>

<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">View Time table</a></li>
        
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Time table</h1>
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
                        <span class="panel-title">Time Table View</span>
                        
                </div>
                <div class="panel-body">
					<div class="row">
					<form name="searchTT" method="POST" action="<?=base_url()?>timetable/viewTtable">
						<div class="form-group">
							
                              <div class="col-sm-3" >
                                <select name="course_id" id="course_id" class="form-control" onchange="load_streams(this.value)" required>
                                  <option value="">Select Course</option>
                                  <?php
									foreach ($course_details as $course) {
										if ($course['course_id'] == $_REQUEST['course_id']) {
											$sel = "selected";
										} else {
											$sel = '';
										}
										echo '<option value="' . $course['course_id'] . '"' . $sel . '>' . $course['course_name'] . '</option>';
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
												'url' : base_url + '/Subject/load_streams',
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
                              
                              <div class="col-sm-3" id="semest" >
                                <select name="stream_id" class="form-control" required>
                                  <option value="">Select Stream </option>
                                  <?php
									foreach ($branches as $branch) {
										if ($branch['branch_code'] == $_REQUEST['stream_id']) {
											$sel = "selected";
										} else {
											$sel = '';
										}
										echo '<option value="' . $branch['branch_code'] . '" ' . $sel . '>' . $branch['branch_code'] . '</option>';
									}
									?>
                               </select>
                              </div>	
								<div class="col-sm-2">
									<select id="semester" name="semester" class="form-control">
											<option value="">Semester</option>
											<?php 
											$semesterNo = $_REQUEST['semester'];
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
									<select id="division" name="division" class="form-control">
											<option value="">Division</option>
											<?php 
											$div = array('A','B','C');
											
											for($i=0;$i<count($div);$i++) {
												if ($i == $_REQUEST['division']) {
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
                    <div class="table-info">    
                    <?php //if(in_array("View", $my_privileges)) { ?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                    <th>Time/Day</th>
                                    <th>Monday</th>
                                    <th>Tuesday</th>
                                    <th>Wednesday</th>
                                    <th>Thursday</th>
                                    <th>Friday</th>
									<th>Saturday</th>  
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php
                            $j=1;   
							//echo "<pre>";
							//print_r($slot);
							//print_r($slot[0]['ttsub']);exit;
                            for($i=0;$i<count($slot);$i++)
                            {
                                
                            ?>
								<tr <?=$slot[$i]["status"]=="N"?"style='background-color:#FBEFF2'":""?>>
                                <td><?=$slot[$i]['from_time']?> - <?=$slot[$i]['to_time']?> <?=$slot[$i]['slot_am_pm']?></td>
								<?php 
									foreach($slot[$i]['ttsub'] as $sub){
										//echo $sub[0]['subject_name'];
								?>	
								<td><?=$sub[0]['subject_name']?></td>	
									<?php }?>								
                            </tr>
                            <?php
                            $j++;
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
  $("div.holder").jPages
  ({
    containerID : "itemContainer"
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
                    for(i=0;i<array.slot.length;i++)
                    {
                        str+='<tr style="display: table-row; opacity: 1;">';
                        str+='<td>'+(i+1)+'</td>';                                                                                                
                        str+='<td>'+array.slot[i].campus_name+'</td>';
                        str+='<td>'+array.slot[i].college_code+'</td>';
                        str+='<td>'+array.slot[i].college_name+'</td>';
                        str+='<td>'+array.slot[i].college_state+'</td>';
                        str+='<td>'+array.slot[i].college_city+'</td>';                        
                        str+='<td>'+array.slot[i].college_pincode+'</td>';
                        str+='<td>'+array.slot[i].college_address+'</td>';
                        str+='<td>';
                        str+='<a href="<?=base_url(strtolower($currentModule))?>/edit/'+array.slot[i].college_id+'"><i class="fa fa-edit"></i></a>';
                        str+='<a href="<?=base_url(strtolower($currentModule))?>/disable/'+array.slot[i].college_id+'"><i title="Disable" class="fa fa-ban"></i></a>';
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
</script>