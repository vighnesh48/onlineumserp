<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
	$tp = $this->uri->segment(3);
	if($tp!=''){
		$ed ="Add Syllabus";
	}else{
		$ed ="Add Syllabus";
	}
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Syllabus</a></li>
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
							<?php 
                              if(!empty($syllbus)){?>
                                  <form id="form_update" name="form_update" method="POST">
                               <?php }else{ ?>
							        <form id="form" name="form" method="POST">
							<?php }?>      
                             
                           
                           <input type="hidden" name="subject_id" id="subject_id" value="<?=$sub[0]['sub_id']?>">
                           <?php 
                           if(!empty($syllbus)){?>
                               <input type="hidden" name="syllabus_id" id="syllabus_id" value="<?=$syllbus[0]['syllabus_id']?>">
                           <?php } ?>
                            <div class="form-group">   
								<label class="col-sm-2">Unit Number <?= $astrik ?></label>
	                            <div class="col-sm-2" >
	                                <select name="unit_no" id="unit_no" class="form-control" required>
	                                  <option value="">Select</option>
	                                 <?php for($i=1;$i<30;$i++) {
	                                   if(!empty($syllbus[0]['unit_no'])){
	                                       $unitno = $syllbus[0]['unit_no'];
	                                   }else{
	                                       $unitno = $unit_no;
	                                   }  
	                                  if($i==$unitno){
	                                        $sel="selected";
	                                    }else{ $sel='';}
	                                 ?>
										<option value="<?=$i?>" <?=$sel?>><?=$i?></option>
									 <?php } ?>
	                                </select>
	                            </div>
								
	                            <label class="col-sm-2">Topic type <?= $astrik ?></label>
	                            <div class="col-sm-2" >
	                                <select name="topic_type" id="topic_type" class="form-control" required>
	                                    <?php 
	                                    
	                                   if(!empty($syllbus[0]['subtopic_no']) || $syllbus[0]['subtopic_no'] !=''){
	                                       if($syllbus[0]['subtopic_no']=='0'){
	                                          
	                                           $topictype='Main';
	                                       }else{
	                                           $topictype='Subtopic';
	                                       }
	                                   }else{
	                                       $topictype=$topic_type;
	                                   }  
	                           
	                                   ?>
	                                  <option value="" selected="selected">Select</option>
									  <option value="Main" <?php //if($topictype=='Main'){ echo 'selected';}?>>Main</option>
									  <option value="Subtopic" <?php //if($topictype=='Subtopic'){ echo 'selected';}?>>Subtopic</option>
									 
	                                </select>
	                            </div>
                            </div>
							<div class="form-group"> 
							<label class="col-sm-2">Topic Number <?= $astrik ?></label>
	                            <!--div class="col-sm-2" id='maintopic'  style="display:none">
	                                <select name="topic_no" id="mtopic_no" class="form-control" required>
	                                  <option value="">Select</option>
										<option value="0">0</option>
	                                </select>
	                            </div-->
	                            <div class="col-sm-2" id='subtopic'>
	                                <select name="topic_no" id="stopic_no" class="form-control" required>
	                                  <option value="">Select</option>
	                                 <?php for($i=1;$i<50;$i++) {
	                                    if(!empty($syllbus[0]['topic_no'])){
	                                       $topicno = $syllbus[0]['topic_no'];
	                                   }else{
	                                       $topicno = $topic_no;
	                                   }   
	                                    if($i==$topicno){
	                                        $sel1="selected";
	                                    }else{ $sel1='';}
	                                 ?>
										<option value="<?=$i?>" <?=$sel1?>><?=$i?></option>
									 <?php } ?>
	                                </select>
	                            </div>
	                            <label class="col-sm-2">Topic Name <?= $astrik ?></label>
	                            <div class="col-sm-6" id="mtop_name">
	                                <input type="text" name="topic_name" id="topic_name1" class="form-control" value="<?php if(!empty($syllbus[0]['topic_name'])){ echo $syllbus[0]['topic_name'];}?>" required>                
	                            </div>  
	                           
	                            <div class="col-sm-6" id="mtopname" style="display:none;">
	                                        <?=$topic_name?>
	                            </div>
                            </div>
							<div class="form-group">
								<label class="col-sm-2">Subtopic Number <?= $astrik ?></label>
	                            <div class="col-sm-2" >
	                                <select name="subtopic_no" id="subtopic_no" class="form-control" required>
	                                  <option value="">Select</option>
	                                 <?php for($i=0;$i<50;$i++) {
	                                    if(!empty($syllbus[0]['subtopic_no'])){
	                                       $subtopicno = $syllbus[0]['subtopic_no'];
	                                   }
	                                    if($i==$subtopicno){
	                                        $sel3="selected";
	                                    }else{ $sel3='';}
	                                 ?>
										<option value="<?=$i?>" <?=$sel3?>><?=$i?></option>
									 <?php } ?>
	                                </select>
	                            </div>

							 	<label class="col-sm-2">Sub Topic Details <?= $astrik ?></label>
	                            <div class="col-sm-6" >
	                                <textarea name="topic_contents" id="topic_contents" class="form-control" required><?php if(!empty($syllbus[0]['topic_contents'])){
	                                       echo $syllbus[0]['topic_contents'];
	                                   }?></textarea>                   
	                            </div>
							</div>
							<div class="form-group">
								<label class="col-sm-2">Required Hrs <!-- <?= $astrik ?> --></label>
	                            <div class="col-sm-2" >
	                                <input type="text" name="unit_hours_required" id="unit_hours_required" class="form-control" value="<?php if(!empty($syllbus[0]['unit_hours_required'])){ echo $syllbus[0]['unit_hours_required'];}?>">
	                                 
	                            </div>

							 	<label class="col-sm-2">Weightage <!-- <?= $astrik ?> --></label>
	                            <div class="col-sm-2" >
	                                <input type="text"  name="weightage" id="weightage" class="form-control" value="<?php if(!empty($syllbus[0]['weightage'])){ echo $syllbus[0]['weightage'];}?>">
	                                 
	                            </div>
							</div>
							
                                <!--- practical end-->
                                <div class="form-group">
                                    <div class="col-sm-2"></div>
                                    <div class="col-sm-2">
                                       <?php 
                                           if(!empty($syllbus)){?>
                                               <button class="btn btn-primary form-control" id="updatefrm" name="submit" type="submit" >Update</button>
                                           <?php }else{ ?>
										<button class="btn btn-primary form-control" id="submitfrm" name="submit" type="submit" >Submit</button>
										<?php }?>                                        
                                    </div>                                    
                                    <div class="col-sm-2"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url()?>subject'">Cancel</button></div>
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
                        <span class="panel-title">Syllabus List</span>
                        <div class="pull-right" style="margin-top: -6px;"><a href="<?=base_url()?>syllabus/downloadpdf/<?=$tp?>"><button class="btn btn-info">Download pdf</button></a></div>
                </div>
                <div class="panel-body" style="overflow:scroll;height:400px;">
                    <div class="table-info12" >    
                    <?php //if(in_array("View", $my_privileges)) { ?>
                    <table class="table table-bordered" >
                        <thead style="background: #3da1bf !important;border-top-color: #3da1bf !important;color: #fff;border-color: #e2e2e2;">
                            <tr>
                                    <!--th>#</th-->  
                                    <th>Unit No.</th>
                                    <th>Topic Name</th>
                                    <!--th>Action</th-->
                            </tr>
                        </thead>
                        <tbody id="subjectList">
							<?php 
							$CI =& get_instance();
							$CI->load->model('Syllabus_model');
							
							$j=1;
							if(!empty($topic_details)){
								foreach($topic_details as $tpc){
								$stopc =$CI->Syllabus_model->get_uniquesubtopics($tpc['subject_id'], $tpc['unit_no']);

								?>
									<tr>
                                    <!--td><?=$j?></td-->  
									<td><?=$tpc['unit_no']?></td>  
									 <td>
									     <?php
									     if(!empty($stopc)){
													foreach($stopc as $sutpc){?>
														
													<?=$sutpc['topic_name']?>  <a href="<?=base_url()?>Syllabus/add_syllabus/<?=$tpc['subject_id']?>/<?=$sutpc['syllabus_id']?>"><i class="fa fa-edit"></i></a>
												
												
									     <ul>
									 <?php
									 $subtopc =$CI->Syllabus_model->get_subtopic_details($tpc['subject_id'], $tpc['unit_no'], $sutpc['topic_no']);
												$k=1;
												if(!empty($subtopc)){
													foreach($subtopc as $stpc){?>
														
														<li><?=$stpc['topic_contents']?> <a href="<?=base_url()?>Syllabus/add_syllabus/<?=$tpc['subject_id']?>/<?=$stpc['syllabus_id']?>"><i class="fa fa-edit"></i></a></li>  
												
												<?php 
												$k++;
													}
												}
												?>
									 </ul>
									 <?php 
									 
													}
									     }
									 ?>
									 </td>  
									 <!--td>
										
										<button type="button" class="btn btn-info" onclick="toggle_view(<?=$tpc['unit_no']?>);">view</button>
									</td-->   
                            </tr>
							<!--add-->
							
							<!--view-->
							<!--tr>
								<td colspan=5 id="view_<?=$tpc['unit_no']?>" style="display:none">
								<table class="table table-bordered" >
														
										<thead>
											<tr  style="background:#e9a23b !important">
												<th width="10%">Topic No.</th>	
												<th width="15%">Sub Topic No.</th>
												<th>Topic Content.</th>
											</tr>
											</thead>
											<tbody id="subjectSubTopicList_<?=$tpc['unit_no']?>">
												<?php
												/*$subtopc =$CI->Syllabus_model->get_subtopic_details($tpc['subject_id'], $tpc['unit_no']);
												$k=1;
												if(!empty($subtopc)){
													foreach($subtopc as $stpc){?>
													<tr > 
														<td><?=$stpc['topic_no']?></td> 
														<td><?=$stpc['subtopic_no']?></td>
														<td><?=$stpc['topic_contents']?></td>  
												</tr>
												<?php 
												$k++;
													}
												}*/
												?>	
											</tbody>
											</table>
								</td>
							</tr-->
								<?php
								$j++;
								    
								}
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
        //

//$( document ).ready(function() {
/*	$(window).load(function() {

 var subtop = '<?=$topic_type?>';
 //alert(subtop);
        if(subtop=='Subtopic'){
             $("#mtop_name").hide();
             $("#mtopname").show();
             // $("#maintopic").hide();
              //$("#mtopic_no").prop('disabled','disabled');
              $("#topic_name1").prop('disabled','disabled');
              $("#topic_name2").prop('disabled',false);
              $("#topic_contents").prop('disabled',false);
              $("#topic_contents").show();  
        }
        
        var subtopic_no = '<?=$syllbus[0]['subtopic_no']?>';
        if(subtopic_no==0){
            var topic_type='Main';
        }else{
             var topic_type='Subtopic';
        }
			//alert(topic_type);
            if(topic_type=='Main'){
                //alert(topic_type);
                //$("#maintopic").show();
                $("#topic_contents").hide();
               // $("#mtopic_no").prop('disabled', false);
                $("#topic_contents").prop('disabled', 'disabled');
                $("#topic_name1").prop('disabled',false);
                $("#topic_name2").prop('disabled','disabled');
                $("#mtopname").hide();
                $("#mtop_name").show();
                $("#subtopic_no option[value='0']").attr("selected", "selected");
                
            }else{
              $("#mtop_name").hide(); 
              $("#mtopname").show();
             // $("#maintopic").hide();
              //$("#mtopic_no").prop('disabled','disabled');
              $("#topic_name1").prop('disabled','disabled');
              $("#topic_name2").prop('disabled',false);
              $("#topic_contents").prop('disabled',false);
              $("#topic_contents").show();  
            }

});*/


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
		  var topic_no = $('#unit_no').val();
		   var topic_type = $('#topic_type').val(); 
		    var subtopic_no = $('#subtopic_no').val(); 
		   
		   if(topic_type=='Subtopic' && subtopic_no=='0' ) 
		   {
		   	alert("Please Enter subtopic number");
		   	return false;

		   }

		    if(topic_type=='Main' && subtopic_no>0 ) 
		   {
		   	alert("Please do not select subtopic number");
		   	return false;

		   }
		  
		  //alert(topic_no);
		  if(topic_no !=''){
          $.ajax({
            type: 'post',
            url: '<?=base_url($currentModule.'/insert_syllabus')?>',
            data: $('#form').serialize(),
            success: function (data) {
				//alert(data);
				$("#btn_submit").removeAttr('disabled');
						if(data=='topic') {
							alert("This Subject  Topic No is already exist, Please add another");
							
							
							
						}
						else if(data=='subtopic')
						{
							alert("This Subject Sub Topic No is already exist, Please add another");

						}

						else{
							alert("Topic inserted successfully.");
							location.reload();
							
						}
            }
          });
			}else{
				$('#course_id').focus();
				return false;
			}
        });
        //
        $('#form_update').on('submit', function (e) {
          e.preventDefault();
		  var topic_no = $('#unit_no').val(); 
		  //alert('top'+topic_no);
		  if(topic_no !=''){
          $.ajax({
            type: 'post',
            url: '<?=base_url($currentModule.'/update_syllabus')?>',
            data: $('#form_update').serialize(),
            success: function (data) {
				//alert(data);
				//console.log(data);
				$("#btn_submit").removeAttr('disabled');

					if(data=='topic') {
							alert("This Subject  Topic No is already exist, Please add another");
						}
						else if(data=='subtopic')
						{
							alert("This Subject Sub Topic No is already exist, Please add another");

						}
						else{
							alert("Topic updated successfully.");
							location.reload();
						}
            }
          });
			}else{
				$('#course_id').focus();
				return false;
			}
        });
//////////////////////////////////////

        $("#topic_type").change(function(){
			var topic_type = $("#topic_type").val();
			//alert(topic_type);
            if(topic_type=='Main'){
                //alert(topic_type);
                //$("#maintopic").show();
                $("#topic_contents").hide();
               // $("#mtopic_no").prop('disabled', false);
                $("#topic_contents").prop('disabled', 'disabled');
                $("#topic_name1").prop('disabled',false);
                $("#topic_name2").prop('disabled','disabled');
                $("#mtopname").hide();
                $("#mtop_name").show();
                $("#subtopic_no option[value='0']").attr("selected", "selected");
                
            }else{
              $("#mtop_name").hide(); 
              $("#mtopname").show();
             // $("#maintopic").hide();
              //$("#mtopic_no").prop('disabled','disabled');
              $("#topic_name1").prop('disabled','disabled');
              $("#topic_name2").prop('disabled',false);
              $("#topic_contents").prop('disabled',false);
              $("#topic_contents").show();  
            }
		});
       
      });




</script>