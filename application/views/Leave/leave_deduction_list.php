<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<script src="<?=base_url()?>assets/javascripts/moment.js"></script>
<style>
.table{width:100%;}
table{max-width:100%;}
 .table-bordered > thead > tr > th{border:0px;font-size:13px;text-align:left;
 font-weight:600;
 }
</style>
<?php// print_r($all_emp_leave);?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Leaves</a></li>
        <li class="active"><a href="#">Leaves Deduction List</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Leave Deduction list</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                    <?php //if(in_array("Add", $my_privileges)) { ?>
                    <div class="pull-right col-xs-12 col-sm-auto"><a style="width: 100%;" class="btn btn-primary btn-labeled" href="<?=base_url($currentModule."/leave_deduction_add")?>"><span class="btn-label icon fa fa-plus"></span>Leaves Deduction</a></div>
                    <div class="pull-right col-xs-12 col-sm-auto">
                    <?php $uid=$this->session->userdata('role_id'); 
                    if($uid == 1 || $uid == 11){ ?>
                                        <a style="width: 100%;" class="btn btn-primary btn-labeled" href="<?=base_url($currentModule."/leave_deductions")?>"><span class="btn-label icon fa fa-plus"></span>Other Leave Deduction</a>
                    <?php } ?>
                    </div>                         
                    <div class="visible-xs clearfix form-group-margin"></div>
                    <?php// } ?>
                    <?php //if(in_array("Search", $my_privileges)) { ?>
                
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
                      <div class="row">
                <div class="col-md-6" class="form-control">
                <h4>
                For the Month of <span id="mon"><b><?php 
                date_default_timezone_set('Asia/Kolkata');
                //echo $mon;
                $ex = explode('-',$mon);
                $st = $ex[1].'-'.$ex[0];
                if($st != '-'){
                echo date('F Y',strtotime($st)); 
                }else{
                    echo date('F Y');
                }?></b></span></h4>
                </div>
                <div class="col-md-6">
                <div class="row">
                <label class="col-sm-3 text-right">Month: </label>
               <div class="col-md-6" >
<input type="text" id="month" name="month" class="form-control monthPicker" value="<?php echo $mon; ?>"/> 
</div>
<div class="col-md-3"><input type="button" id="find" onclick="search_emp_leves()"  class="btn btn-primary" value="Search">
</div>
                </div>
                </div>
                </div>
                </div>
                <div class="panel-body" style="overflow-x:scroll;height:700px;">
                    <div class="table-info">    
                    <?php //if(in_array("View", $my_privileges)) { ?>
                    <table class="table table-bordered" >
                        <thead>
                            <tr>
                                    <th>#</th>
                                    <th>Emp.ID</th>
                                    <th>Name</th>
                                    <th>School</th>
                                    <th>Department</th>
                                    <th>Date</th>
									<th>Leave Type</th>
									<th>Dur</th>
									<th>Approved By</th>
                                    <th>Remark</th>
									<th>Added On</th>
									
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php // print_r($leave_deduction);
							if(!empty($leave_deduction)){
                            $j=1;         
                            $ci =&get_instance();
   $ci->load->model('admin_model');
                            for($i=0;$i<count($leave_deduction);$i++)
                            {
                                $cl = $this->load->leave_model->get_emp_leaves($emp_leave_allocation[$i]['employee_id'],'CL');
                           
                          	?>
														
                            <tr>
							<td><?=$j?></td> 
                                 
                                <td><?=$leave_deduction[$i]['emp_id']?></td> 
                                 <td><?php if($leave_deduction[$i]['gender']=='male'){echo 'Mr.';}else if($leave_deduction[$i]['gender']=='female'){ echo 'Mrs.';} echo $leave_deduction[$i]['fname']." ".$leave_deduction[$i]['lname'];?></td>
                                 <td><?=$leave_deduction[$i]['college_code'];?></td> 
                                 <td><?=$leave_deduction[$i]['department_name'];?></td> 
                                
                                  <td><?=date('d-m-Y',strtotime($leave_deduction[$i]['applied_from_date']))?></td> 
                                <td><?php if($leave_deduction[$i]['leave_type']=='LWP'){echo 'LWP'; }else{ 
$ls = $this->leave_model->getLeaveTypeById($leave_deduction[$i]['leave_type']);
if($ls) {
     echo $ls;
 } else {
    echo $leave_deduction[$i]['leave_type'];
 }
                                    } ?></td> 
								 <td><?=$leave_deduction[$i]['leave_duration']?></td>
 <td><?=$leave_deduction[$i]['emp1_reporting_person']?></td> 
  <td><?=$leave_deduction[$i]['emp1_reporting_remark']?></td> 	
 <td><?=date('d-m-Y',strtotime($leave_deduction[$i]['inserted_datetime']))?></td>
                            </tr>
                            <?php
                            $j++;
                            }}else{
								echo"<tr><td colspan='19'><label style='color:red'>Sorry No record of Employee's Assigned for leaves.</label></td></tr>";
							}
                            ?>                            
                        </tbody>
                    </table>     
                    <div class="col-md-6"></div> <div class="col-md-2">  <button id="taexport" class="btn-primary btn">Export</button></div>         
                   
                    <?php //} ?>
                </div>
                </div>
            </div>
            </div>    
        </div>
    </div>
</div>
<script>
$('#taexport').click(function(){
    var mon = $('#month').val();
var url  = "<?=base_url().strtolower($currentModule).'/export_leave_deduction/'?>"+mon;   
          //alert(url);
          window.location.href = url;
});
function search_emp_leves(){
    var month = $('#month').val();    
          url= "<?php echo base_url().$currentModule; ?>/employee_leave_deduction/"+month;
          window.location = url;
}
$(function () {
    $('.monthPicker').datepicker({
       autoclose: true,
    minViewMode: 1,
    format: 'mm-yyyy',
        onClose: function (dateText, inst) {
            var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
            $(this).datepicker('setDate', new Date(year, month, 1));
        }
    });
});
</script>