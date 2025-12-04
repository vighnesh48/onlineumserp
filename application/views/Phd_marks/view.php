<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<?php //echo  "<pre>"; print_r($unittest); die;
$role_id = $this->session->userdata('role_id');
 ?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Lecture</a></li>
        <li class="active"><a href="#">CIA Master</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;CIA</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                    <?php// if(in_array("Add", $my_privileges)) { ?>
    
                    <div class="pull-right col-xs-12 col-sm-auto"><a style="width: 100%;" class="btn btn-primary btn-labeled" href="<?=base_url($currentModule."/add")?>"><span class="btn-label icon fa fa-plus"></span>Add CIA</a></div> 
                      
                    <div class="visible-xs clearfix form-group-margin"></div>
                    <?php// } ?>
                    <?php if(in_array("Search", $my_privileges)) { ?>
                    <form class="pull-right col-xs-12 col-sm-6" action="">
                        <div class="input-group no-margin">
                            <span style="border:none;background: #fff;background: rgba(0,0,0,.05);" class="input-group-addon"><i class="fa fa-search"></i></span>
                            <select id="search_me" name="search_me" style="border:none;background: #fff;background: rgba(0,0,0,.05);" class="form-control no-padding-hr" placeholder="Search...">
                                <option value="">Select Title</option>
                                <?php
                                    for($i=0;$i<count($unittest);$i++)
                                    {
                                ?>
                                <option value="<?=$unittest[$i]['college_id']?>"><?=$unittest[$i]['college_name']?></option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>
                    </form>
                    <?php } ?>
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
                        <span class="panel-title">List</span>
                        <div class="holder21"></div>
                </div>
                <div class="panel-body">
                    <div class="table-info table-responsive">    
					<form id="form" name="form" action="<?=base_url($currentModule.'/')?>" method="POST">    
					<?php if($role_id==3){?>                                                           
                                
								
								<div class="form-group">   
								<label class="col-sm-2">Select Subject</label>								
								<div class="col-sm-3">
								
									<select id="subject" name="subject" class="form-control">
										<option value="">Select Subject</option>
										<?php 
										if($sub_Code !=''){
											$sub_Code = $sub_Code;
										}else{
											$sub_Code = $_REQUEST['subject'];
										}
										if(!empty($sb)){
											foreach($sb as $sub){
												$batch = $sub['subject_id'].'-'.$sub['stream_code'].'-'.$sub['division'].'-'.$sub['batch_no'].'-'.$sub['semester'];
												if ($batch == $sub_Code) {
													$sel = "selected='selected'";
												} else {
													$sel = 'sdfds';
												}
												$subjectdetails = explode('-', $sub['batch_code']);
												$divsion = $subjectdetails[1];
												$batchno = $subjectdetails[2];
												
												if($sub['batch_no'] !='OFF'){
													if($sub['batch_no'] ==0){
														$batch = "";
													}else{
														$batch =$sub['batch_no'];
													}
													echo '<option value="'.$sub['subject_id'].'-'.$sub['stream_code'].'-'.$sub['division'].'-'.$sub['batch_no'].'-'.$sub['semester'].'"' . $sel . '>'.$sub['subject_short_name'].'('.$sub['sub_code'].')-'.$sub['division'].''.$batch.'</option>';
												}
											}
										}
										?>									
									</select>											
								</div> 
								<div class="col-sm-2"> <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Search</button> </div>
								
                            </div>
							<?php }else{
								?>
								<div class="form-group">   
								<label class="col-sm-6">Subject Name: <?=$subjectName[0]['subject_short_name'].'('.$subjectName[0]['subject_code'].')'?></label>	
								</div>
							<?php }?>
							</form>
                    <?php //if(in_array("View", $my_privileges)) { ?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                    <th>#</th>
                                    <th>Test Name</th>
                                    <th>Date</th>
                                    <th>Min Marks </th>
                                    <th>Max Marks</th>
                                    <th>Class</th>
                                    <th>Semester</th>
                                    <th>Edit</th>
									<th>Add/Edit Marks</th>
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php
                            $j=1;  
						if(!empty($unittest)){							
                            for($i=0;$i<count($unittest);$i++)
                            {
                            ?>
                            <tr <?=$unittest[$i]["status"]=="N"?"style='background-color:#FBEFF2'":""?>>
                                <td><?=$j?></td>                                                                
                                 <td><?=$unittest[$i]['test_no']?></td>
                                <td><?=date('d-m-Y', strtotime($unittest[$i]['test_date']));?></td>
                                <td><?=$unittest[$i]['min_for_pass']?></td>
                                <td><?=$unittest[$i]['max_mark']?></td>
                                <td><?=$unittest[$i]['stream_id']?></td>
                                <td><?=$unittest[$i]['semester']?></td>
                                <td>
                                    <a href="<?=base_url($currentModule."/edit/".$unittest[$i]['unit_test_id'])?>"><i class="fa fa-edit"></i></a>
                                   
                                </td>
								<td>
                                    <?php if($unittest[$i]['td']==0) { ?>
                                    <a href="<?=base_url($currentModule."/testdetails/".base64_encode($unittest[$i]['unit_test_id'])).'/'.base64_encode($sub_Code)?>">Add</a>
									<?php }else{ ?>
									
									<a href="<?=base_url($currentModule."/editTestDetails/".base64_encode($unittest[$i]['unit_test_id']).'/'.base64_encode($sub_Code))?>">Edit</a> | 
									
									<a id="<?=$unittest[$i]['unit_test_id']?>" data-test_date="<?=date('d-m-Y', strtotime($unittest[$i]['test_date']));?>" data-test_no="<?=$unittest[$i]['test_no']?>" class="viewmarks" data-toggle="modal" style="cursor:pointer"><button type="button" class="btn btn-primary btn-xs">View</button></a>
									
									<?php } ?>
                                   
                                </td>
                            </tr>
                            <?php
                            $j++;
                            }
						}else{ echo "<tr><td colspan=8>No data found</td></tr>";}
                            ?>                            
                        </tbody>
                    </table>  
<?php if(!empty($sub_Code)){?>
								<div class="col-sm-4"></div>
								<div class="col-sm-2">
								<a href="<?=base_url($currentModule."/consolidated_testdetails/".base64_encode($_REQUEST['subject']))?>">
								<button type="button" class="btn btn-primary ">Consolidated View</button>
								</a>
								</div>
								<?php }?>					
                    <?php //} ?>
                </div>
                </div>
            </div>
				<div class="panel" id="att_details" style="display:none">
                    <div class="panel-heading">
                            <span class="panel-title">Marks details: <span id="displaydate"></span> <span id="displayslot"></span></span>
                    </div>
                    <div class="panel-body">
                        <div class="table-info">  
							<table class="table table-bordered" id="">
							<thead>
								<tr>
									<th>Sr.No.</th>
									<th>PRN.</th>
									<th>Name</th>
									<th>Marks</th>
								</tr>
							</thead>
							<tbody id="studAtt">
							</tbody>
							</table>
							
						</div>
                    </div>
                </div>
				
            </div>    
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
	$(".viewmarks").each(function () {
		
		$(document).on("click", '#' + this.id, function () {
			$('#att_details').css("display","block");
			var test_id = this.id;
			var test_date = $('#' + this.id).attr("data-test_date");
			var test_no = $('#' + this.id).attr("data-test_no");
			$('#displaydate').html("<b>CIA-</b> "+test_no+',');
			$('#displayslot').html("<b>Date-</b> "+test_date);
		    //alert(test_id);
			$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>Unittest/fetchMarkesDetails',
					data: {test_id:test_id},
					success: function (data) {
						//alert(data);
						if(data!='dupyes'){
							var absent=JSON.parse(data);
							var list_of_absent = absent.ss.length;
							
							var str="";
							for(i=0;i< list_of_absent;i++)
							{
								var is_present = absent.ss[i].is_present;
								if(is_present=='N'){
									var cls = "style='background-color: rgb(255, 123, 119);'";
									var status_p = 'A';
								}else{
									cls='';
									var status_p = 'P';
								}
								//alert("inside");
								//alert(absent.ss[i].enrollment_no);
								str+='<tr '+cls+'>';
								
								str+='<td>'+(i+1)+'</td>';   
								str+='<td>'+absent.ss[i].enrollment_no_new+'</td>';
								str+='<td>'+absent.ss[i].first_name+' '+absent.ss[i].last_name+'</td>';
								str+='<td>'+absent.ss[i].marks_obtained+'</td>';
								
								$("#studAtt").html(str);
							}
							//alert("Refresh.");
						}else{
							alert("No data found");
						}
						
					}
				});
		});
	});
});
</script>