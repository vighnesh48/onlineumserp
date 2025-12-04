<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
	$tp = $this->uri->segment(3);
	if($tp!=''){
		$ed ="Add Topic";
	}else{
		$ed ="Add Topic";
	}
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Lecture</a></li>
        <li class="active"><a href="#"><?=$ed?></a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-book page-header-icon"></i>&nbsp;&nbsp;<?=$ed?></h1>
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
                            <span class="panel-title"><b>Subject Name:</b><?=$sub[0]['subject_name'].' ('.$sub[0]['subject_code'].')'?>, <b>Stream Name:</b><?=$sub[0]['stream_short_name']?>, <b>Semester:</b><?=$sub[0]['semester']?>, <b>Batch:</b><?=$sub[0]['batch']?></span>
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
							
                           <form id="form" name="form" method="POST">                                                               
                            <div class="form-group">
                              
							<label class="col-sm-2">Topic Number <?= $astrik ?></label>
                              <div class="col-sm-2" >
                                <select name="topic_no" id="topic_no" class="form-control" required>
                                  <option value="">Select</option>
                                 <?php for($i=1;$i<25;$i++) {?>
									<option value="<?=$i?>" ><?=$i?></option>
								<?php } ?>
                               </select>
                              </div>
							  <label class="col-sm-2">Topic Name <?= $astrik ?></label>
                              <div class="col-sm-6" >
                                <input type="text" name="topic_name" id="topic_name" class="form-control">
								<input type="hidden" name="subject_id" id="subject_id" value="<?=$subject_id?>">
                              </div>	
                            </div>
		
							
                                <!--- practical end-->
                                <div class="form-group">
                                    <div class="col-sm-2"></div>
                                    <div class="col-sm-2">
                                        <?php
										if($subdet[0]['sub_id'] !=''){
										?> 
											<button class="btn btn-primary form-control" id="submitfrm" name="submit" type="submit" >Update</button>
										<?php }else{ ?>
										<button class="btn btn-primary form-control" id="submitfrm" name="submit" type="submit" >Submit</button>
										<?php }?>                                        
                                    </div>                                    
                                    <div class="col-sm-2"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule)?>/topic'">Cancel</button></div>
                                    <div class="col-sm-4"></div>
                                </div>
                            </form>
                            <?php //} ?>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
<!----------------------------------------------------->
		   <div class="row " style="display:none1;">
            <div class="col-sm-12">
                <div class="panel">
                <div class="panel-heading">
                        <span class="panel-title">Topic List</span>
                        <div class="holder"></div>
                </div>
                <div class="panel-body" style="overflow:scroll;height:400px;">
                    <div class="table-info12" >    
                    <?php //if(in_array("View", $my_privileges)) { ?>
                    <table class="table table-bordered" >
                        <thead style="background: #3da1bf !important;border-top-color: #3da1bf !important;color: #fff;border-color: #e2e2e2;">
                            <tr>
                                    <th>#</th>  
                                    <th>Subject Name</th>
                                    <th>Topic No.</th>
                                    <th>Topic Name</th>
                                    <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="subjectList">
							<?php 
							$CI =& get_instance();
							$CI->load->model('Subject_model');
							
							$j=1;
							if(!empty($topic_details)){
								foreach($topic_details as $tpc){?>
									<tr>
                                    <td><?=$j?></td>  
									<td><?=$tpc['subject_name']?> (<?=$tpc['subject_code']?>)</td>  
									 <td><?=$tpc['topic_no']?></td>  
									 <td><?=$tpc['topic_name']?></td>  
									 <td>
										 <button type="button" id="<?=$tpc['topic_no']?>" class="btn btn-info" onclick="toggle_details(this.id);">add</button>
										<button type="button" class="btn btn-info" onclick="toggle_view(<?=$tpc['topic_no']?>);">view</button>
									</td>   
                            </tr>
							<!--add-->
							<tr>
								<td colspan=5 id="details_<?=$tpc['topic_no']?>" style="display:none">
									<form id="form_subtopic" name="form_subtopic" method="POST">                                                               
                            <div class="form-group">
                              
							<label class="col-sm-2">Sub Topic Number <?= $astrik ?></label>
                              <div class="col-sm-2" >
                                <select name="sub_topic_no" id="sub_topic_no" class="form-control" required>
                                  <option value="">Select</option>
                                 <?php for($i=1;$i<25;$i++) {?>
									<option value="<?=$i?>" ><?=$i?></option>
								<?php } ?>
                               </select>
                              </div>
							  <label class="col-sm-2">Sub Topic Name <?= $astrik ?></label>
                              <div class="col-sm-6" >
                                <input type="text" name="sub_topic_name" id="sub_topic_name" class="form-control">
								<input type="hidden" name="subject_id" id="subject_id" value="<?=$tpc['subject_id']?>">
								<input type="hidden" name="topic_id" id="topic_id" value="<?=$tpc['topic_no']?>">
                              </div>	
                            </div>
		
							
                                <!--- practical end-->
                                <div class="form-group">
                                    <div class="col-sm-2"></div>
                                    <div class="col-sm-2">
										<button class="btn btn-primary form-control" id="submitfrm11" name="submit" type="submit" >Submit</button>										                                       
                                    </div>                                    

                                </div>
                            </form>
								</td>
							</tr>
							<!--view-->
							<tr>
								<td colspan=5 id="view_<?=$tpc['topic_no']?>" style="display:none">
								<table class="table table-bordered" >
														
										<thead>
											<tr  style="background:#e9a23b !important">
												<th width="30%">Topic No.</th>											
												<th width="30%">Sub Topic No.</th>
												<th>Sub Topic Name</th>									
											</tr>
											</thead>
											<tbody id="subjectSubTopicList_<?=$tpc['topic_no']?>">
												<?php
												$subtopc =$CI->Subject_model->get_subtopic_details($tpc['subject_id'], $tpc['topic_no']);
												$k=1;
												if(!empty($subtopc)){
													foreach($subtopc as $stpc){?>
													<tr > 
														<td><?=$stpc['topic_id']?></td>
														<td><?=$stpc['sub_topic_no']?></td>  
														<td><?=$stpc['sub_topic_name']?></td>  
												</tr>
												<?php 
												$k++;
													}
												}
												?>	
											</tbody>
											</table>
								</td>
							</tr>
								<?php }
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
	function toggle_details(id){
		$("#details_"+id).toggle( "slow", function() {
			});

	}
	function toggle_view(id){
		$("#view_"+id).toggle( "slow", function() {
			});

	}	
      $(function () {

        $('#form').on('submit', function (e) {
          e.preventDefault();
		  var subject_id = $('#subject_id').val(); 
		  alert(subject_id);
		  if(subject_id !=''){
          $.ajax({
            type: 'post',
            url: '<?=base_url($currentModule.'/insert_subject_topic')?>',
            data: $('#form').serialize(),
            success: function (data) {
				alert(data);
				$("#btn_submit").removeAttr('disabled');
						if(data!='dupyes'){
							var topc=JSON.parse(data);
							//alert(topc.ss);
							var list_of_topc = topc.ss.length;	
alert(list_of_topc);							
							var str="";
							for(i=0;i< list_of_topc;i++)
							{
								alert("inside");
								alert(topc.ss[i].subtopic_name);
								str+='<tr>';
								
								str+='<td>'+(i+1)+'</td>';					
								str+='<td>'+topc.ss[i].subject_name+'('+topc.ss[i].subject_code+')</td>';
								str+='<td>'+topc.ss[i].topic_no+'</td>';
								str+='<td>'+topc.ss[i].topic_name+'</td>';
								str+='<a href="<?=base_url(strtolower($currentModule))?>/edit/'+topc.ss[i].sub_id+'"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;';
								str+='</td>';
								$("#subjectList").html(str);
							}
							if(topc.actn=='insert'){
							alert("Topic inserted successfully.");
							}else{
								alert("Topic Updated successfully.");
							}
						}else{
							alert("This Subject Topic No is already exist, Please add another");
						}
            }
          });
			}else{
				$('#course_id').focus();
				return false;
			}
        });
//////////////////////////////////////
        $('#form_subtopic').on('submit', function (e) {
          e.preventDefault();
		  var subject_id = $('#subject_id').val(); 
		  var topic_id = $('#topic_id').val(); 
		  //alert(subject_id);
		  if(subject_id !=''){
          $.ajax({
            type: 'post',
            url: '<?=base_url($currentModule.'/insert_subject_subtopic')?>',
            data: $('#form_subtopic').serialize(),
            success: function (data) {
				//alert(data);
				$("#submitfrm11").removeAttr('disabled');
						if(data!='dupyes'){
							var subtopc=JSON.parse(data);
							//alert(subtopc.actn);
							var list_of_subtopc = subtopc.ss.length;								
							var str="";
							for(i=0;i< list_of_subtopc;i++)
							{
								//alert("inside");
								str+='<tr>';
								str+='<td>'+subtopc.ss[i].topic_id+'</td>';								
								str+='<td>'+subtopc.ss[i].sub_topic_no+'</td>';
								str+='<td>'+subtopc.ss[i].sub_topic_name+'</td>';
								$("#subjectSubTopicList_"+topic_id).html(str);
							}
							if(subtopc.actn=='insert'){
							alert("Sub Topic inserted successfully.");
							}else{
								alert("Sub Topic Updated successfully.");
							}
						}else{
							alert("This Sub Topic is already exist, Please add another");
						}
            }
          });
			}else{
				//$('#course_id').focus();
				return false;
			}
        });
      });

</script>