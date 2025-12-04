
<link rel="stylesheet" href="<?= base_url('assets') ?>/stylesheets/select2.css">
<script src="<?= base_url('assets/javascripts') ?>/select2.min.js"></script>
<?php // print_r($fac_list);?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Question Paper</a></li>
        <li class="active"><a href="#">Question Paper List</a></li>
    </ul>
    <div class="page-header">			
         <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Question Paper List</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                 <?php  if(in_array("Add", $my_privileges)) { ?>
                    <div class="pull-right col-xs-12 col-sm-auto"><a style="width: 100%;" class="btn btn-primary btn-labeled" href="<?=base_url($currentModule."/add_new_qp")?>"><span class="btn-label icon fa fa-plus"></span>Add QP</a></div>                        
                    <div class="visible-xs clearfix form-group-margin"></div>
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
                  
                    <div class="panel-body">
                        <div class="table-info">    
                            <table id="example" class="table table-bordered">
                                <thead>
                                    <tr>
                                    	<!-- <th class="noExl"><input type="checkbox" name="chk_sub_all" id="chk_sub_all"></th> -->
                                        <th data-orderable="false">S.No.</th>
                                        <th data-orderable="false">Subject Code</th>
                                        <!--th data-orderable="false">Image</th-->
                                        <th data-orderable="false">Subject Name</th>
                                        <th data-orderable="false">No. of Sets</th>
                                        <th data-orderable="false">Flies</th>
                                        <th data-orderable="false">Last Date Of Submission</th>  
                                        <th data-orderable="false">Duration</th>  
                                        <th data-orderable="false">Subject Type</th>
                                        <th data-orderable="false">Semester</th>
                                        <th data-orderable="false">Comment</th>
                                        <th data-orderable="false">Status</th>
                                        <th data-orderable="false">Action</th>
                                        <!-- th data-orderable="false">Email Id</th>
                                        <th data-orderable="false">Phone</th>
                                        <th data-orderable="false">Staff Type</th> -->
                                        <!--th data-orderable="false">Action</th-->
                                    </tr>
                                </thead>
                                <tbody id="itemContainer">

                                	<input type="hidden" name="semester" id="semester" value="<?=$semesterNo?>">
                                	<input type="hidden" name="facultyy" id="facultyy" value="<?=$facultyy?>">
                                	<input type="hidden" name="academicyear" id="academicyear" value="<?=$academicyear?>">
                                	<input type="hidden" name="streamId" id="streamId" value="<?=$streamId?>">
                                	<input type="hidden" name="courseId" id="courseId" value="<?=$courseId?>">
                        	       
                                    <?php
                                    //echo '<pre>';
                                    //print_r($sub_list);exit;
                                    $j = 1;
                                    if(!empty($sub_list)){
                                    for ($i = 0; $i < count($sub_list); $i++) {
                                    	  //echo '<pre>';
                                    	//print_r(count($sub_list[$i]['doc_details']));exit;
										
                                        ?>
                                        							
                                        <tr>
                                        	<input type="hidden" name="qp_id_<?= $i; ?>" id="qp_id_<?= $i; ?>" value="<?php  echo $sub_list[$i]['id'];?>">
                                            <td><?= $j ?></td> 

                                            <td><?php  echo $sub_list[$i]['subject_code'];?></td> 
                                            <td><?php  echo $sub_list[$i]['subject_name'];?></td> 
                                            <td><?php  echo $sub_list[$i]['no_of_sets'];?></td>

                                            <td>
                                            	<?php 

                                            	  $ii = 1;
                                            	  $fcheck = 0;
                                            	 if(count($sub_list[$i]['doc_details']) >0){

                                                   foreach($sub_list[$i]['doc_details'] as $docs){
                                                   //echo '<pre>';
                                                   //	print_r($docs);exit;
												 if(trim($docs['doc_path'])!=''){

												 	$fcheck++;

												?>
												 <a href="<?= site_url() ?>uploads/student_document/<?php echo $docs['doc_path'];  ?>" target="_blank">Set <?= $ii?></a><br />
																						<?php
														}
																						
                                                       $ii ++; 
                                                   }


                                            	 }

                                            	?>
                                            </td> 
                                             
                                            <td><?php  echo $sub_list[$i]['last_date_of_submit'];?></td> 
                                            <td><?php  echo $sub_list[$i]['duration'];?></td>
                                            <td><?php  echo $sub_list[$i]['subject_component'];?></td> 
                                            <td><?php  echo $sub_list[$i]['semester'];?></td> 
                                            <td>
                                            <?php  if(in_array("Add", $my_privileges)) { ?>	 
                                            	<textarea onchange="update_qp_comment('<?php  echo $i;?>')" name="comment_<?= $i; ?>" id="comment_<?= $i; ?>"> <?php  echo $sub_list[$i]['comment'];?></textarea>
                                             <?php } else {?>

												<textarea  name="comment_<?= $i; ?>" id="comment_<?= $i; ?>" disabled> <?php  echo $sub_list[$i]['comment'];?></textarea>
                                            <?php  } ?>
                                            </td>
                                            <td><?php 
                                            if($sub_list[$i]['coe_satatus'] == 1){
                                                 echo 'Approved';
                                            }else{
                                                    echo 'Not Approved';
                                            } 
                                        ?></td> 
                                            <td>
                                           <?php  if(in_array("Edit", $my_privileges)) { 
                                           	  if($sub_list[$i]['coe_satatus'] == 0){ ?>
                                            <a  href="<?php echo base_url()."Question_paper/upload_docs/".$sub_list[$i]['id'].""?>" title="Upload Sets" target="_blank"><i class="fa fa-cloud-upload"></i>  </a>
                                            <?php }else{ ?>

                                            	<a style="pointer-events: none;cursor: default;"  href="#" title="Upload Sets" target="_blank"><i class="fa fa-cloud-upload"></i>  </a>


                                            <?php } }?>
                                            <?php  if(in_array("Add", $my_privileges)) { ?>	
                                           <?php if($sub_list[$i]['coe_satatus'] == 0){ ?>
                                             <button name="approve_<?= $i; ?>" id="approve_<?= $i; ?>" class="form-control"  onclick = "approve_qp('<?php  echo $i;?>');" value="1">Approved</button>
                                         <?php }else { ?>
                                         	<button name="approve_<?= $i; ?>" id="approve_<?= $i; ?>" class="form-control" disabled>Approved</button>
                                        <?php } ?>
                                             </td>
                                             <?php } ?>		
                                          
                                        </tr>
                                        <?php
                                        $j++;
                                    }
                                }
                                    else{
                                        echo "<tr><td colspan=9>";echo "No data found.";echo "</td></tr>";
                                    }
                                    ?>                            
                                </tbody>
                            </table>

                           

				               
                            <?php //}   ?>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </div>
</div>

<script>
$(document).ready(function () {
	var base_url = '<?php  echo base_url(); ?>';
	$('#chk_sub_all').change(function () {
        $('.subCheckBox').prop('checked', $(this).prop('checked'));
    });
	
	///////////////////////////////
	// fetch stream form course
	var stream_id = $("#semester").val();
	var faculty = $("#facultyy").val();
	if(stream_id !=''){
		$("#sem_id").val(stream_id);
	}
		// fetch subject of sem_acquire
		$("#stream_id").change(function(){
			//alert("hi");
		  $('#semester option').attr('selected', false);
		});
		
  });
function validate_subject(strm){

	var chk_stud_checked_length = $('input[class=subCheckBox]:checked').length;
	if(chk_stud_checked_length == 0){
		 alert('please check atleast one Subject from subject list');
		 return false;
	}else{
		return true;
	}
}
function  approve_qp(i){
	//alert(i);
	var status = $("#approve_"+ i).val();
	var qp_id = $("#qp_id_"+ i).val();
	//alert(status);

	                  $.ajax({
                                'url' : base_url + 'Question_paper/update_qp_status',
                                'type' : 'POST', //the way you want to send data to your URL
                                'data' : {'status':status,'qp_id':qp_id},
                                'success':function (str) {
                                 if(str==1){
                                 	window.location.reload();
                                 } 
                                }
                          });
}
function  update_qp_comment(i){
	//alert(i);
	var comment = $("#comment_"+ i).val();
	var qp_id = $("#qp_id_"+ i).val();
	alert(comment);

	                  $.ajax({
                                'url' : base_url + 'Question_paper/update_qp_comment',
                                'type' : 'POST', //the way you want to send data to your URL
                                'data' : {'comment':comment,'qp_id':qp_id},
                                'success':function (str) {
                                 if(str==1){
                                 	window.location.reload();
                                 } 
                                }
                          });
}	
</script>
