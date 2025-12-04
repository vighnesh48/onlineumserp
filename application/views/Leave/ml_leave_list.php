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
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;ML Leave list</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                    
                    <div class="pull-right col-xs-12 col-sm-auto"></div>                        
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
  <span id="flash-messages" style="color:red;padding-left:110px;"><?php echo $this->session->flashdata('message1'); ?></span>					
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
									<th>Dur</th>									
									<th>Added On</th>
									<th>Status</th>
									<th>Action</th>
									
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php
							if(!empty($ml_leave)){
                            $j=1;         
                            $ci =&get_instance();
   $ci->load->model('admin_model');
                            for($i=0;$i<count($ml_leave);$i++)
                            {
                                //$cl = $this->load->leave_model->get_emp_leaves($emp_leave_allocation[$i]['employee_id'],'CL','2018-19');
                           
                          	?>
														
                            <tr>
							<td><?=$j?></td> 
                                 
                                <td><?=$ml_leave[$i]['emp_id']?></td> 
                                 <td><?php if($ml_leave[$i]['gender']=='male'){echo 'Mr.';}else if($ml_leave[$i]['gender']=='female'){ echo 'Mrs.';} echo $ml_leave[$i]['fname']." ".$ml_leave[$i]['lname'];?></td>
                                 <td><?=$ml_leave[$i]['college_code'];?></td> 
                                 <td><?=$ml_leave[$i]['department_name'];?></td>                                 
                                  <td><?=date('d-m-Y',strtotime($ml_leave[$i]['applied_from_date']))?></td> 
                               
								 <td><?=$ml_leave[$i]['leave_duration']?></td>
 
 <td><?=date('d-m-Y',strtotime($ml_leave[$i]['inserted_datetime']))?></td>
  <td><?=$ml_leave[$i]['status']?></td>
 <td><a href="<?=base_url($currentModule.'/update_ml_leave_application/'.$ml_leave[$i]['leave_id'])?>" title="Edit"><i class="fa fa-edit"></i></a></td>
                            </tr>
                            <?php
                            $j++;
                            }}else{
								echo"<tr><td colspan='19'><label style='color:red'>Sorry No ML leaves for this month .</label></td></tr>";
							}
                            ?>                            
                        </tbody>
                    </table>  
				<!-- <div class="col-md-6"></div> <div class="col-md-2">  <button id="taexport" class="btn-primary btn">Export</button></div>         -->
   	
                    <?php //} ?>
                </div>
                </div>
            </div>
            </div>    
        </div>
    </div>
</div>
<script>
//$('#taexport').click(function(){
//	var mon = $('#month').val();
//var url  = "<?=base_url().strtolower($currentModule).'/export_ml_leave/'?>"+mon;   
          //alert(url);
 //         window.location.href = url;
//});
function search_emp_leves(){
    var month = $('#month').val();    
          url= "<?php echo base_url().$currentModule; ?>/ml_leave_list/"+month;
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