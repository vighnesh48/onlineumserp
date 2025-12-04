<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script>
$(document).ready(function(){
				
	$('#school_code').on('change', function () {	
		var school_code = $(this).val();
		//alert(school_code);
		if (school_code) {
			//alert('inside');
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Certificate/load_examschools',
				data: {school_code:school_code},
				success: function (html) {
					//alert(html);
					$('#admission-course').html(html);
				}
			});
		} else {
			$('#admission-course').html('<option value="">Select course first</option>');
		}
	});  
// edit
var school_code = '<?=$school_code?>';
		if (school_code) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Certificate/load_examschools',
				data: {school_code:school_code},
				success: function (html) {
					//alert(html);
					var course_id = '<?=$admissioncourse?>';
					$('#admission-course').html(html);
					$("#admission-course option[value='" + course_id + "']").attr("selected", "selected");
				}
			});
		} else {
			
			$('#admission-course').html('<option value="">Select course first</option>');
		}	
		//load streams
		$('#admission-course').on('change', function () {	
		var admission_course = $("#admission-course").val();
		//alert(admission_course);
		if (admission_course) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Certificate/load_streams',
				data: {course_id:admission_course},
				success: function (html) {
					//alert(html);
					$('#stream_id').html(html);
					$("#stream_id option[value='" + admission_course + "']").attr("selected", "selected");
				}
			});
		} else {
			$('#stream_id').html('<option value="">Select course first</option>');
		}
	}); 

var admission_course = '<?=$admissioncourse?>';
		if (admission_course!='') {
			//alert('inside');
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Certificate/load_streams',
				data: {course_id:admission_course},
				success: function (html) {
					//alert(html);
					var stream_id = '<?=$stream?>';
					//alert(stream_id);
					$('#stream_id').html(html);
					$("#stream_id option[value='" + stream_id + "']").attr("selected", "selected");
				}
			});
		} else {
			
			$('#stream_id').html('<option value="">Select course first</option>');
		}	
});
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
        <li class="active"><a href="#">Certificate</a></li>
        <li class="active"><a href="#">Provisional Certificate</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Provisional Certificate List</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row"> 
                	<a href="<?=base_url()?>Certificate/provisional_form/" target="_blank">
                		<button class="btn btn-primary pull-right" style="margin-right: 15px;">Add</button>
                	</a>                   
                    <hr class="visible-xs no-grid-gutter-h">                                         
                    <div class="visible-xs clearfix form-group-margin"></div>               
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
                        <span class="panel-title">
                            <form method="post">
                            <div class="form-group">
                             <!-- <label class="col-sm-2">Course<sup class="redasterik" style="color:red">*</sup></label>-->
							 <div class="col-sm-2">
                                <select name="academic_year" id="academic_year" class="form-control" required>
                                 <option value="">Academic Year</option>
                               
                                  <?php

foreach ($academic_year as $acadyear) {
	//if($acadyear['academic_year']!="2016-17"){
	$academicyear = $acadyear['academic_year'];
    if ($academicyear == $acd_year) {
        $sel = "selected";
    } else {
        $sel = '';
    }
    echo '<option value="' . $academicyear. '"' . $sel . '>' .$academicyear.'</option>';
} //}
?></select>
                              </div>
							<div class="col-sm-2">

                                <select name="school_code" id="school_code" class="form-control" required>
                                 <option value="" <?php if($_REQUEST['school_code']==$school_code){ echo "selected";}?>>Select School</option>
                                  <option value="0" <?php if(isset($_REQUEST['school_code']) && $_REQUEST['school_code']==$school_code){ echo "selected";}?>>All School</option>
                                  <?php
foreach ($schools as $sch) {
    if ($sch['school_code'] == $school_code) {
        $sel = "selected";
    } else {
        $sel = '';
    }
    echo '<option value="' . $sch['school_code'] . '"' . $sel . '>' . $sch['school_short_name'] . '</option>';
}
?></select>
                              </div>
                              <div class="col-sm-2">
                                <select name="admission-course" id="admission-course" class="form-control" required>
                                 <option value="">Select Course</option>
                                  <option value="0">All Courses</option>
                                  </select>
                              </div>
                             
                            <!--  <label class="col-sm-2">Stream<sup class="redasterik" style="color:red">*</sup></label>-->
                              <div class="col-sm-2" id="semest">
                                <select name="admission-branch" id="stream_id" class="form-control" required>
                                  <option value="">Select Stream</option>
                                  <option value="0">All Stream</option>
                                  </select>
                              </div>

                              <div class="col-sm-2">
                                 <input type="submit" id="" class="btn btn-primary btn-labeled" value="Search" > 
                            </div>
                             <!--<div class="col-sm-3" id="semest">
                               <a href="<?=base_url()?>Ums_admission/generateallpdfs">  <input type="button" id="" class="btn btn-primary btn-labeled" value="Generate All" > </a>
                            </div>-->
                            </div>
                            </form>
                        </span>
                        <div class="holder1"></div>
                </div>

            <div class="table-info panel-body">  
			<?php 
			$role_id=$this->session->userdata('role_id');
			if(isset($role_id) && $role_id==1 ){?>
            <form id="filterdata" method="post" action ="">

            </form>
				<?php }?>
			
                <div class="col-lg-12">
                    <div class="table-info" id="stddata" style="<?=$tbstyle?>">    
				<?php 	
					if($_POST){
				
				?>
			
 <table class="table table-bordered" id="table2excel">
                        <thead>
                            <tr>
                                    <th>S.No.</th>									
                                    <th>PRN</th>
                                    <th>Name</th>
									<th>Stream</th>
                                     <th>PPC No</th>
                                     <th>Placed In</th>
									 <th>Degree Completed</th>
									 <!--th>Attend (%)</th-->
                                     <!--th>Form Status</th-->
                                    <th>Action </th>
                                    
                            </tr>
                        </thead>
                        <tbody id="studtbl">
                            <?php
                            //echo "<pre>";
							//print_r($emp_list);  
							if(!empty($emp_list)){        
                            $j=1;                            
                            for($i=0;$i<count($emp_list);$i++)
                            {
                            	$degree_completed =explode('-', $emp_list[$i]['degree_completed']);
                            ?>
														
                            <tr>
								<td><?=$j?></td>
                         		<td><?=$emp_list[$i]['student_prn']?></td> 
                            	<td><?=$emp_list[$i]['last_name']?> <?=$emp_list[$i]['first_name']?> <?=$emp_list[$i]['middle_name']?></td>
								<td><?=$emp_list[$i]['gradesheet_name']?></td> 
								<td><?=$emp_list[$i]['ppc_no']?></td> 
								<td><?=$emp_list[$i]['placed_in'];?></td> 	
								<td><?=$degree_completed[0].'-'.$degree_completed[1];?></td> 								
								<td style="width: 75px;">
									<a href="<?=base_url()?>Certificate/provisional_form/<?=$emp_list[$i]['enrollment_no']?>" target="_blank">
										<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
									</a> &nbsp;&nbsp;| &nbsp;&nbsp;
									<a href="<?=base_url()?>Certificate/download_provisional_certificate/<?=$emp_list[$i]['enrollment_no']?>" target="_blank">
										<i class="fa fa-file-pdf-o" aria-hidden="true" style="color:red;cursor:pointer"></i>
									</a>
								</td> 
                                                                                              
                          
                            </tr>
                            <?php
                            $j++;
                            }
                        }else{
                        	echo '<tr><td colspan=8> No Data Found.</td></tr>';
                        }
                            ?>                            
                        </tbody>
                    </table>                     
                    <?php } ?>
                </div>
                </div>
                </div>
            </div>
            </div>    
        </div>
    </div>
</div>