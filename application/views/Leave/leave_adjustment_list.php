<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<?php// print_r($all_emp_basicsal);?>
<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<script src="<?=base_url()?>assets/javascripts/moment.js"></script>

<style>
.view-btn{padding:0px;}
.view-btn i{padding: 3px 0;list-style:none;width:35px;text-align: center;color:#fff;background:#4bb1d0;xpadding: 5px 10px;margin:2px;}
.view-btn i a{color:#fff;font-weight:bold;}
</style>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Staff Payment</a></li>
        <li class="active"><a href="#">Leave Adjustment List</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Leave Adjustment List</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                    <?php //if(in_array("Add", $my_privileges)) { ?>
                     <div class="col-sm-2 pull-right clearfix form-group-margin"><a  class="btn btn-primary btn-labeled" href="<?=base_url($currentModule."/leave_adjustment_add")?>"><span class="btn-label icon fa fa-plus"></span>Add </a></div>
                    <?php// } ?>                  
                           
                        </div>                    
                     </div>
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
              
			   $st = $mon;
                if(!empty($st)){
                echo date('F Y',strtotime("01-".$st)); 
                }else{
                    echo date('F Y');
                }?></b></span></h4>
                </div>
                <div class="col-md-6">
                <div class="row">
                <label class="col-sm-5 text-right">Month: </label>
               <div class="col-md-4" >
<input type="text" id="month" name="month" class="form-control monthPicker" value="<?php echo $mon; ?>"/> 
</div>
<div class="col-md-3"><input type="button" id="find" onclick="search_emp_adj()"  class="btn btn-primary" value="Search">
</div>
                </div>
                </div>
                </div>  
                        
                </div>
                <div class="panel-body" style="height: 1020px;overflow-y: scroll;">
                    <div class="table-info" >    
                    <?php //if(in_array("View", $my_privileges)) { ?>
                    <table class="table table-bordered" style="width:100%;">
                        <thead>
                            <tr>
                                    <th>#</th>
                                    <th>Emp.ID</th>
                                    <th>Name</th><th>School</th>                                   
<th>Department</th>
<th>Date</th>
<th>Adjustment For</th>	
                                    <th>Remark</th>
																
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php //print_r($tds_list);
							 date_default_timezone_set('Asia/Kolkata'); 
							if(!empty($leave_list)){
                            $j=1;    
					
                           foreach($leave_list as $val)
                            {          
					
                            ?>							 							
                            <tr>
                                <td><?=$j?></td>                                  
                                <td ><?php 	echo $val['emp_id'];?></td> 
                                <td ><?php							
									if($val['gender']=='male'){echo 'Mr.';}else if($val['gender']=='female'){ echo 'Mrs.';}
								echo $val['fname']." ".$val['lname']; ?></td>                                                                
                                       <td><?php echo $val['college_code'];  ?> </td>                          
                                  <td ><?php echo $val['department_name'];?> </td>
								 <td><?php echo date('d-m-Y',strtotime($val['adjust_date'])); ?></td>
							<td><?php echo $val['adjust_type']; ?></td>      
<td><?php echo $val['remark']; ?></td>           
                              
                            </tr>
                            <?php
                            $j++;
                            }}else{
						echo"<tr><td colspan='19'><label style='color:red'>Sorry No record </label></td></tr>";
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
  function search_emp_adj(){
    var month = $('#month').val();    
          url= "<?php echo base_url().$currentModule; ?>/leave_adjustment_list/"+month;
          window.location = url;
}
$(function () {
    $('.monthPicker').datepicker({
       autoclose: true,
    minViewMode: 1,
    format: 'mm-yyyy'        
    });
});
   

</script>