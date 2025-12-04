<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="<?php echo base_url('assets/javascripts') . '/bootstrap-datepicker.js' ?> "></script>
<script>    
$(document).ready(function()
{
	//$('#exam_date').datepicker( {format: 'dd/mm/yyyy',autoclose: true});
});

function getExamDate(id){
	$('#'+id).datepicker( {format: 'dd/mm/yyyy',autoclose: true});
	$('#'+id).focus();
	return true;
}
</script>

<?php 
if(isset($role_id) && $role_id==1 ){
?>
<style>
	.table{width: 150%;}
	table{max-width: 150%;}
</style>									
<?php }else{ ?>
	<style>
	table.dataTable{width: 210%;}</style>
<?php }?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Examination</a></li>
        <li class="active"><a href="#">Marks</a></li>
    </ul>
    <div class="page-header">
                     <div class="row">
				<h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-list page-header-icon"></i>&nbsp;&nbsp;Practical Subject List</h1>
				<div class="col-xs-12 col-sm-8">
					<div class="row">                    
						<hr class="visible-xs no-grid-gutter-h">
						<div class="pull-right col-xs-12 col-sm-auto">
						</div>                        
						<div class="visible-xs clearfix form-group-margin"></div>
					</div>
				</div>
			</div>
                </div>

            <div class="table-info panel-body" >  
			<?php //echo $reval;exit;
			$role_id=$this->session->userdata('role_id');
			$emp_id=$this->session->userdata('name');
			//if(isset($role_id) && $role_id==1 ){?>
            <form id="" method="post" action ="#">

            <input type="hidden" name="stream_id" value="<?=$stream?>">
			<input type="hidden" name="adm_semester" value="<?=$semester?>">
				<?php// }?>
			
                <div class="col-lg-12">
                    <div class="table-info" id="stddata" style="<?=$tbstyle?>">    
			
 <table class="table table-bordered" id="table2excel">
                        <thead>
                            <tr>
                                   <!--th><input type="checkbox" name="chk_stud_all" id="chk_stud_all"></th-->
                                    <th>S.No.</th>
									<th>Batch</th>
                                    <th>Subject Code</th>
                                    <th>Subject Name</th>
									<th>Stream</th>
									<th>Semester</th>
									<th>Division</th>
									<th>Batch No</th>
                                     <th>Action</th>
									 <th>Entry On</th>
                                     <th>Verify On</th>
                                     <th>Approved On</th>
                                    <th>Status</th>
									<th>Stud. List</th>
									<th>Download</th>
                                    
                            </tr>
                        </thead>
                        <tbody id="studtbl">
                            <?php
							$roleid = $this->session->userdata("role_id");
							$today = date('d/m/Y');
                            //echo "<pre>";
							//print_r($sub_list);
                          if(!empty($sub_list)){
                            $j=1;                            
                            for($i=0;$i<count($sub_list);$i++)
                            {
                               //echo $sub_list[$i]['isPresent']; 
                            ?>
							<input type="hidden" name="subject_id[]" id="subject_id<?=$j?>" class='studCheckBox' value="<?=$sub_list[$i]['sub_id']?>">
							<input type="hidden" name="subject_code[]" id="subject_code<?=$j?>" class='studCheckBox' value="<?=$sub_list[$i]['subject_code']?>">
							 <?php if($sub_list[$i]['ro_flag']=='on') $bg="bgcolor='#e6eaf2'";
								  else $bg="";?>								
                            <tr <?=$bg?> <?=$sub_list[$i]["cancelled_admission"]=="Y"?"style='background-color:#f5b9a1'":""?>>
							<!--th><input type="checkbox" name="chk_stud[]" id="chk_stud" class='studCheckBox' value="<?=$sub_list[$i]['stud_id']?>"></th-->
                              <td><?=$j?></td>
								<td><?=strtoupper($sub_list[$i]['batch'])?></td> 
                                 <td><?=strtoupper($sub_list[$i]['subject_code'])?></td> 
                                    <td>
							
							<?php
								echo strtoupper($sub_list[$i]['subject_name']);
								?>
								</td> 
								<td><?=$sub_list[$i]['stream_short_name']?></td>
								<td><?=$sub_list[$i]['semester']?></td>
								<?php if($roleid !='15'){?>
								<td><?=$sub_list[$i]['division']?></td>
								<td><?=$sub_list[$i]['batch_no']?></td>
								<?php }else{ ?>
								<td><?=$division?></td>
								<td><?=$batch_no?></td>
								<?php }?>
								<td>
								
                                    <?php

                                    $school_code='0'; 
                                    $admissioncourse='0';
                                    //$exam=$sub_list[$i]['exam_month'].'-'.$sub_list[$i]['exam_year'].'-'.$sub_list[$i]['exam_id'];
						
									if($roleid !='15'){
										$subDetails = $sub_list[$i]['sub_id'].'~'.$school_code.'~'.$admissioncourse.'~'.$sub_list[$i]['stream_id'].'~'.$sub_list[$i]['semester'].'~'.$exam.'~'.$marks_type='PR'.'~'.$sub_list[$i]['division'].'~'.$sub_list[$i]['batch_no'].'~'.$reval.'~'.$sub_list[$i]['is_backlog'].'~'.$sub_list[$i]['exam_date'];
									}else{ 
										$is_backlog='Y';$exam_date='2018-01-08';
										$subDetails = $sub_list[$i]['sub_id'].'~'.$school_code.'~'.$admissioncourse.'~'.$sub_list[$i]['stream_id'].'~'.$sub_list[$i]['semester'].'~'.$exam.'~'.$marks_type='PR'.'~'.$division.'~'.$batch_no.'~'.$reval.'~'.$is_backlog.'~'.$exam_date;
									}
									
									
								if($today==$sub_list[$i]['exam_date'] || $emp_id=='su_coe' || $emp_id=='110351' || $emp_id=='110243'){
									// || $emp_id=='110111' || $emp_id=='110322' || $emp_id=='110087' || $emp_id=='210121' || $emp_id=='110265' || $emp_id=='110239' || $emp_id=='210088' || $emp_id=='F1006'
									if($sub_list[$i]['mrk'][0]['me_id'] =='') {	 
									?>
                                    <a href="<?=base_url($currentModule."/pract_marksdetails/".base64_encode($subDetails))?>" target="_blank">Add</a>
									<?php }else{ //echo $sub_list[$i]['mrk'][0]['me_id'];
									//if($sub_list[$i]['mrk'][0]['entry_by']== $this->session->userdata('name')){
										//echo $subDetails;
										?>
									<a href="<?=base_url($currentModule."/editMarksDetails/".base64_encode($subDetails).'/'.base64_encode($sub_list[$i]['mrk'][0]['me_id']))?>" target="_blank">Edit <?//=$sub_list[$i]['sub_id']; ?></a>
									
									<?php //}else{ echo "done";}
									} 
							}else{
								echo "exam on: ".$sub_list[$i]['exam_date'];
							}
                               ?>
								</td> 
								<td>
								<?php
									if($sub_list[$i]['mrk'][0]['entry_on'] !=''){
										echo date('d/m/Y H:i:s', strtotime($sub_list[$i]['mrk'][0]['entry_on']));
									}else{
										echo "";
									}
								?>
								</td> 
								<td>
									<?php
									if($sub_list[$i]['mrk'][0]['verified_on'] !=''){
										echo date('d/m/Y H:i:s', strtotime($sub_list[$i]['mrk'][0]['verified_on']));
									}else{
										echo "";
									}
								?>
								</td> 
								<td>
									<?php
									if($sub_list[$i]['mrk'][0]['approved_on'] !=''){
										echo date('d/m/Y H:i:s', strtotime($sub_list[$i]['mrk'][0]['approved_on']));
									}else{
										echo "";
									}
								?>
								</td> 
                                <td>
								<?php
									if($sub_list[$i]['mrk'][0]['entry_status'] !=''){
										echo $sub_list[$i]['mrk'][0]['entry_status'];
									}else{
										echo "Not Entered";
									}
								?>
								</td> 
									<td>
                                    <a href="<?=base_url($currentModule."/downloadStudlistpdf/".base64_encode($subDetails).'/'.base64_encode($sub_list[$i]['mrk'][0]['me_id']))?>"><i class="fa fa-file-pdf-o" aria-hidden="true"  style="font-size:20px;color:red;"></i></a>
									
								</td>								
								<td>
									<?php
									if($sub_list[$i]['mrk'][0]['me_id'] !='') {	 
									?>
                                    <a href="<?=base_url($currentModule."/downldPractmarkspdf/".base64_encode($subDetails).'/'.base64_encode($sub_list[$i]['mrk'][0]['me_id']))?>"><i class="fa fa-file-pdf-o" aria-hidden="true"  style="font-size:20px;color:red;"></i></a>
									<?php } ?>
								</td>								
                          
                            </tr>
                            <?php
                            $j++;
                            }
						  }else{
							  echo "<tr><td colspan=9> No data found.</td></tr>";
						  }
                            ?>                            
                        </tbody>
                    </table>  
					
					
			</form>		

                </div>
                </div>
                </div>
            </div>
            </div>    
        </div>
    </div>
</div>

<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/pdfmake.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.3.1/css/buttons.dataTables.min.css">


<script>
function validate_student(strm){

	var chk_stud_checked_length = $('input[class=studCheckBox]:checked').length;
	if(chk_stud_checked_length == 0){
		 alert('please check atleast one Student from student list');
		 return false;
	}else{
		return true;
	}
}

$(document).ready(function () {
	$('#chk_stud_all').change(function () {
        $('.studCheckBox').prop('checked', $(this).prop('checked'));
    });
});	

$(document).ready(function() {
$("#expdata").click(function(){

  $("#table2excel").table2excel({

    exclude: ".noExl",

    name: "Worksheet Name",
   filename: "Student List" //do not include extension

  });

});
   // $('#example').DataTable( {
    //    dom: 'Bfrtip',
    //    buttons: [
     //       'csv', 'excel'
       // ]
    //} );
} );
</script>