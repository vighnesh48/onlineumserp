   <?php
   $CI =& get_instance();
	$CI->load->model('Ums_admission_model');
   $role_id =$_SESSION['role_id'];
   //echo $urlseg = $this->uri->segment(3);
if(count($emp_list)>0)
{
   ?>
                            </tr>
    <form method="post" action="<?=base_url()?>Ums_admission/generateID/">
 
 <table class="table table-bordered" id="table2excel">
                        <thead>
                            <tr>
                                   <th class="noExl"><input type="checkbox"  id="ckbCheckAll"></th>
                                    <th>S.No.</th>
                                    <th>PRN</th>
                                     <th>Old PRN</th>
                                     <th>Form No.</th>
                                     <th class="noExl">Photo1</th>
                                    <th>Name</th>
                                    <th>Stream </th>
                                      <th>Admission-cycle</th>
                                    <th>DOB</th>
                                    <th>Mobile</th>
                                    <th>Blood Group</th>
                                    <?php
                                    if( $_SESSION['role_id']=='5')
                                    {
                                    ?>
                                    <th class="noExl">Payment</th>
                                    <?php
                                    }
                                    ?>
                                     <?php
                                    if( $_SESSION['role_id']=='7')
                                    {
                                    ?>
                                    <th class="noExl">Payment Details</th>
                                    <?php
                                    }
                                    ?>
                                    
                                    <!--th class="noExl">View Subject</th-->
                                    <th class="noExl">Action</th>
									<?php if($role_id==15 ){ //|| $role_id==10 ?>
									<!--th>Detention</th-->
									<?php } ?>
									<?php if($role_id==15 || $role_id==2 ){?>
									<!--th>Change Stream</th-->
									<?php } ?>
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php
                            
                          
                            $j=1;                            
                            for($i=0;$i<count($emp_list);$i++)
                            {
                                
                            ?>
							 <?php if($emp_list[$i]['ro_flag']=='on') $bg="bgcolor='#e6eaf2'";
								  else $bg="";?>								
                            <tr <?=$bg?> <?=$emp_list[$i]["cancelled_admission"]=="Y"?"style='background-color:#f5b9a1'":""?>>
                                <th class="noExl"><input type="checkbox" value="<?=$emp_list[$i]['stud_id']?>" name="lstd[]" class="checkBoxClass"></td>
                               <td><?=$j?></td>
                        
                                 <td>'<?=$emp_list[$i]['enrollment_no'];?></td> 
                                  <td><?=$emp_list[$i]['enrollment_no_new']?></td> 
                                  <td><?=($emp_list[$i]['formn']!="")? $emp_list[$i]['formn']:$emp_list[$i]['form_number']?></td>
                                   <td  class="noExl">
                                       <?php
                                     //  $tep = base_url().'uploads/2017-18/'.$emp_list[$i]['form_number'].'/' . $emp_list[$i]['form_number'].'_PHOTO.bmp';
                                     //  echo $tep;
                                      /* if (file_exists('uploads/2017-18/'.$emp_list[$i]['form_number'].'/' . $emp_list[$i]['form_number'].'_PHOTO.bmp')) {
                                         //  echo "yES";
                                           $ext = 'bmp';
                                       }
                                       else
                                       {
                                             $ext = 'jpg';
                                       }*/
                                       ?>
                                       
                                     <!--  <img src="https://erp.sandipuniversity.com/uploads/2017-18/<?=$emp_list[$i]['form_number']?>/<?=$emp_list[$i]['form_number']?>_PHOTO.<?=$ext?>" alt="" width="60"/></td> 
                              -->

                                  <?php
                                    $bucket_key = 'uploads/student_photo/'.$emp_list[$i]['enrollment_no'].'.jpg';
                                    $imageData = $this->awssdk->getImageData($bucket_key);
                                  ?>
                                <img src="<?= $imageData ?>" alt="" width="80" height="80"/>
                                    
                                <td>
							
							<?php
								echo $emp_list[$i]['first_name']." ".$emp_list[$i]['middle_name']." ".$emp_list[$i]['last_name'];
								?>
								</td> 
							
								   <td><?=$emp_list[$i]['stream_name']?></td> 
                    <td><?=$emp_list[$i]['admission_cycle']?></td> 
                                                                                              
                            <td><?=$emp_list[$i]['dob']?></td>                               
                                                      
                                <td><?=$emp_list[$i]['mobile'];?></td>    
                                <td><?=$emp_list[$i]['blood_group'];?></td> 
                                           <?php
                                    if( $_SESSION['role_id']=='5')
                                    {
                                    ?>          
                                <td class="noExl"><a  href="<?php echo base_url()."ums_admission/viewPayments/".$emp_list[$i]['stud_id'].""?>" title="View" target="_blank"><i class="fa fa-credit-card" aria-hidden="true"></i> </a>&nbsp;&nbsp;&nbsp;&nbsp;</td>                         
                               <?php
                                    }
                               
                                if( $_SESSION['role_id']=='7')
                                    {
                                    ?>          
                                <td class="noExl"><a  href="<?php echo base_url()."ums_admission/viewPayment_det/".$emp_list[$i]['stud_id'].""?>" title="View" target="_blank"><i class="fa fa-credit-card" aria-hidden="true"></i> </a>&nbsp;&nbsp;&nbsp;&nbsp;</td>                         
                               <?php
                                    }     
                                    
                               ?>
                               
                                <!--td class="noExl"><a  href="<?php echo base_url()."/Subject_allocation/view_studSubject/".$emp_list[$i]['stud_id'].""?>" title="View" target="_blank"><i class="fa fa-book" aria-hidden="true"></i> </a>&nbsp;&nbsp;&nbsp;&nbsp;</td-->                         
                                <td class="noExl" style="padding:0px;" align="center">
                                    <p> 
			<a  href="<?php echo base_url()."phd_admission/view_studentFormDetails/".$emp_list[$i]['stud_id'].""?>" title="View" target="_blank"><i class="fa fa-eye"></i>&nbsp;  </a>
	       
	        <?php
                                    if($_SESSION['role_id']=='1' || $_SESSION['role_id']=='2')
                                    {
                                        if($_SESSION['name']=='student_dept')
                                        {
                                    ?>      
	        <a  target="_blank" href="<?php echo base_url()."phd_admission/edit_personalDetails/".$emp_list[$i]['stud_id'].""?>" title="Edit"><i class="fa fa-edit"></i> &nbsp; </a>
       
                                
                       
                       
                          <?php
                                    }
                                    }
                          ?>
                             </td>
							 <?php if($role_id==15){ //|| $role_id==10 ?>
							 <!--td>
							 
							 <?php
							 $std_reason =$this->Ums_admission_model->fetch_stud_detain_reason($emp_list[$i]['stud_id']);
								$std_details= $emp_list[$i]['admission_stream'].'~'.$emp_list[$i]['current_semester'].'~'.$emp_list[$i]['academic_year'];
									if($emp_list[$i]['is_detained']=='Y'){
                                           $btncls = "btn-danger"; 
                                        }elseif($emp_list[$i]['is_detained']=='N'){
                                            $btncls="btn-success";
                                        }else{
                                            $btncls = "btn-info";
                                        }
							 ?>
							 <?php if($emp_list[$i]['is_detained']=='Y'){ ?><span class="btn <?=$btncls?> btn-xs">Detained</span></a> <?php }else{?>
							 <a class="marksat" id="state<?=$emp_list[$i]['stud_id']; ?>" data-stud_id="<?=$emp_list[$i]['stud_id']; ?>"  data-dexses="<?=$std_reason[0]['exam_session']; ?>" data-dstatus="<?=$emp_list[$i]['is_detained']; ?>" data-stud_details="<?=$std_details;?>" data-stud_dreason="<?=$std_reason[0]['reason'];?>" data-toggle="modal" data-target="#walkinModal" style="cursor:pointer"><span class="btn <?=$btncls?> btn-xs"><?=$emp_list[$i]['is_detained']?></span></a>
							 
							 </td-->
							 <?php }
							 }?>
							 <?php if($role_id==15 || $role_id==2){?>
							 
							 <!--td>
							 <?php if($emp_list[$i]['is_detained']=='Y'){ ?><span class="btn <?=$btncls?> btn-xs">Detained</span></a> <?php }else{?>
							 <a  href="<?php echo base_url()."phd_admission/change_stream/".$emp_list[$i]['stud_id'].""?>" title="Change Stream" target="_blank"><span class="btn btn-primary">Click</span> </a></td-->
							 <?php }
							 }?>
                            </tr>
                            <?php
                            $j++;
                            }
                            ?>                            
                        </tbody>
                    </table>  
                   
                       <input type="hidden" name="dcourse" value="<?=$dcourse;?>">
                     <input type="hidden" name="dyear" value="<?=$dyear;?>">
                     <?php
              
                      if($hide =='hide')
                     {
                     }
                     else
                     {
                     ?>
                     <input type="submit" value="Generate ID Card" class="btn btn-primary btn-labeled">
                     <?php
                     }
                     ?>
               
                     
                     
                     </form>
                      <?php
                     if($hide =='hide')
                     {
                     }
                     else
                     {
                     ?>
                    <form method="post" action="<?=base_url()?>Ums_admission/generatepdf/" style="float: left;margin-top: -29px;margin-left: 150px;">
                    <input type="hidden" name="dcourse" value="<?=$dcourse;?>">
                     <input type="hidden" name="dyear" value="<?=$dyear;?>">
                     <input type="submit" value="Generate PDF" class="btn btn-primary btn-labeled">
                     
                      <input type="button" id="expdata" value="Export as Excel" class="btn btn-primary btn-labeled">
                     </form>
                     
                     <?php
                     }

                     ?>
                     <?php
}
else
{echo "No Results Found";}
                     ?>
                     
<!-- Modal -->
<div class="modal fade" id="walkinModal" tabindex="-1" role="dialog" 
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                
                <h4 class="modal-title" id="myModalLabel">
                   <span id="fform_id">Detention Form</span>
                </h4>
            </div>
            
            <!-- Modal Body -->
            <div class="modal-body">
                <div class="row">
                            <div class="col-sm-12">
                                <div class="panel panel-default panel-hovered panel-stacked" style="margin-top: 10px;">
                                    <div class="panel-body">
                                        <!--form role="form" method="post" action="<?=base_url()?>admin/updateWalkinStatus"-->
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Detention Status</label><br>
                                              <input type="radio" name="dstatus" id="radio_1" value="no" required/> &nbsp;No &nbsp;
                                              <input type="radio" name="dstatus" id="radio_2" value="yes" required/> &nbsp;Yes &nbsp;
                                              
                                              <input type="hidden" name="stud_id" class="form-control" id="fstud_id" />
											  <input type="hidden" name="fstud_details" class="form-control" id="fstud_details"/>
                                          </div> 
											<div class="form-group">
                                            <label for="exampleInputEmail1">Exam Session</label><br>
											<select name="exam_session" class="form-control" id="exam_session" style="width:35%" required>
                                               <option value="">-Select-</option>
											   <?php foreach($ex_ses as $ex){
												   $exam_ses = $ex['exam_month'].'-'.$ex['exam_year'];
												   $exam_ses_val = $ex['exam_month'].'~'.$ex['exam_year'].'~'.$ex['exam_id'];
												   ?>
											   <option value="<?=$exam_ses_val?>"><?=$exam_ses?></option>
											   <?php }?>
											  <select>
                                          </div>  										  
											<div class="form-group">
                                            <label for="exampleInputEmail1">Reason</label><br>
											<select name="detain_reason" class="form-control" id="detain_reason" style="width:35%" required>
                                               <option value="">-Select-</option>
											   <option value="Lack of Attendance">Lack of Attendance</option>
											   <option value="Indiscipline">Indiscipline</option>
											  <select>
                                          </div>  										  
                                          <button type="button" class="btn btn-primary" onclick="return mark_detention()">Submit</button>
                                          <button type="button" class="btn btn-default"
                                                data-dismiss="modal">
                                                    Close
                                        </button>
                                        <!--/form-->
                                    </div>
                                </div>
                            </div>
                        </div>
                
            </div>
            
            <!-- Modal Footer 
            <div class="modal-footer">
                <button type="button" class="btn btn-default"
                        data-dismiss="modal">
                            Close
                </button>
                <button type="button" class="btn btn-primary">
                    Save changes
                </button>
            </div>-->
        </div>
    </div>
</div>                     
                     
 <script>
function mark_detention(){
	//alert(id);
	//res = id.split("~");
	//var detain =res[0];
	var detain = $("input[name='dstatus']:checked").val();
	var dreason = $("#detain_reason").val();
	var exam_session = $("#exam_session").val();
	var fstud_details = $("#fstud_details").val();
	var stud_id =$("#fstud_id").val();
	if(detain=='yes'){
		var str_alert = 'Detain';
	}else{
		var str_alert = 'Release';
	}
	if(exam_session==''){
		alert('please select Exam Session');
		$("#exam_session").focus();
		return false;
	}
	if(dreason==''){
		alert('please select reason');
		$("#detain_reason").focus();
		return false;
	}
	if(confirm("Are you sure to "+str_alert+" this Student?")){
		//alert(detain);
	$.ajax({
		type: 'POST',
		url: '<?= base_url() ?>Ums_admission/detain_student',
		data: {detain:detain,stud_id:stud_id,dreason:dreason,stud_details:fstud_details,exam_session:exam_session},
		success: function (data) {
			//alert(data);
			if(data=='Y'){
			alert("Updated Successfully..");
			$('.modal-backdrop').remove();
			//$('#walkinModal').modal('hide');
			$("#sbutton").trigger("click");
			}
		}
	});
	}else {

            return false;
        }
	return true;
}                                                             
                     
$(document).ready(function () {
    $("#ckbCheckAll").click(function () {
        $(".checkBoxClass").prop('checked', $(this).prop('checked'));
    });
    
    $(".checkBoxClass").change(function(){
        if (!$(this).prop("checked")){
            $("#ckbCheckAll").prop("checked",false);
        }
    });
	
$(".marksat").each(function () {
    $(document).on("click", '#' + this.id, function () {
        var stud_id = $('#' + this.id).attr("data-stud_id");
		var dstatus = $('#' + this.id).attr("data-dstatus");
		var dexsession = $('#' + this.id).attr("data-dexses");
		var stud_details = $('#' + this.id).attr("data-stud_details");
		var stud_dreason = $('#' + this.id).attr("data-stud_dreason");
		//alert(dexsession);
		
        document.getElementById("fstud_id").value = stud_id;
		document.getElementById("fstud_details").value = stud_details;
		//document.getElementById("detain_reason").value = stud_dreason;
		$("#detain_reason option[value='" + stud_dreason + "']").attr("selected", "selected");
		$("#exam_session option[value='" + dexsession + "']").attr("selected", "selected");
        //$('#fform_id').html(form_id);
		if(dstatus=='N'){
			$("#radio_1").prop("checked", 'checked');
		}else{
			$("#radio_2").prop("checked", 'checked');
		}
    });
});	
});
                     
                     
                     
                     
                     
                     
                     
                     
                     
                     
                     
                     
$("#expdata").click(function(){

  $("#table2excel").table2excel({

    exclude: ".noExl",

    name: "Worksheet Name",
  filename: "Student List" //do not include extension

  });

});

                     </script>
                     
                     
	    