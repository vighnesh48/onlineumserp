<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<script>    
    $(document).ready(function()
    {
        $('#form').bootstrapValidator
        ({  
            message: 'This value is not valid',
            group: 'form-group',
            feedbackIcons: 
            {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
			 row: {
        valid: 'field-success',
        invalid: 'field-error'
    },
            fields: 
            {
                lname:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Last name should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[a-zA-Z-/]+$/,
                        message: 'Last name should be alphabate characters'
                      },
                      stringLength: 
                        {
                        max: 50,
                        min: 2,
                        message: 'Last name should be 2-50 characters'
                        }
                    }
                }
              
            }       
        })
		
});
    });
</script>
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="#">View Leave Status</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;View Leave Status</h1>
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
                    
                    <div class="panel-body">
					   <span id="flash-messages" style="color:red;padding-left:110px;"><?php echo $this->session->flashdata('message1'); ?></span>
                        <div class="table-info">
                            <form id="form" name="form" action="<?=base_url($currentModule.'/add_emp')?>" method="POST" enctype="multipart/form-data">
                         <div id="dashboard-recent" class="panel-warning">   
                               <div class="panel">
                            	<div class="panel-heading"><strong>Leave Status</strong></div>
                                <div class="panel-body">
                                <div class="table-responsive">
							<?php // print_r($leave);?>
							 <table style="width: 1040px;" aria-describedby="applications_info" role="grid" 
							  class="table table-striped table-bordered table-hover no-footer" id="applications">
							  <!-- class='dataTable' for sorting arrows icon for col-->
                                     <thead>
                                    <tr role="row">
									<th aria-label="ID: activate to sort column ascending" style="width: 80px;" colspan="1" rowspan="1" aria-controls="applications" tabindex="0" class="center sorting">Leave ID</th>
									<th aria-label="Name: activate to sort column ascending" aria-sort="ascending" style="width: 103px;" colspan="1" rowspan="1" aria-controls="applications" tabindex="0" class="center sorting_asc">Name</th>
									<th aria-label="Date: activate to sort column ascending" style="width: 99px;" colspan="1" rowspan="1" aria-controls="applications" tabindex="0" class="center sorting">From Date</th>
									<th aria-label="Date: activate to sort column ascending" style="width: 99px;" colspan="1" rowspan="1" aria-controls="applications" tabindex="0" class="center sorting">To Date</th>
									<th aria-label="Date: activate to sort column ascending" style="width: 99px;" colspan="1" rowspan="1" aria-controls="applications" tabindex="0" class="center sorting">Days</th>
									<th aria-label="Leave Type: activate to sort column ascending" style="width: 122px;" colspan="1" rowspan="1" aria-controls="applications" tabindex="0" class="center sorting">Leave Type</th>
									<th aria-label="Reason: activate to sort column ascending" style="width: 122px;" colspan="1" rowspan="1" aria-controls="applications" tabindex="0" class="center sorting">Reason</th>
									
				                 <th aria-label="Applied on: activate to sort column ascending" style="width: 116px;" colspan="1" rowspan="1" aria-controls="applications" tabindex="0" class="center sorting">Applied on</th>
									<th aria-label="Status: activate to sort column ascending" style="width: 85px;" colspan="1" rowspan="1" aria-controls="applications" tabindex="0" class="center sorting">Status</th>
									<!--<th aria-label="Action" style="width: 162px;" colspan="1" rowspan="1" class="center sorting_disabled">Action</th>-->
									</tr>
                                    </thead>
                                    <tbody>
                                   <?php if(empty($leave)){?>
									<tr id="row441" class="odd" role="row">
										<td class="center" colspan=30><?php echo "No Leave Applications Available"; ?></td>
										</tr>
									<?php }else{
										$i=0;
										foreach($leave as $key=>$val){
											$i++;
										?>
									<tr id="row<?php echo $i;?>" class="odd" role="row">
										<td class="center"><?php echo $leave[$key]['lid'];?></td>
										<td class="center sorting_1"><?php echo $leave[$key]['ename'];?></td>
										<td class="center"><?php echo $leave[$key]['applied_from_date'];?></td>
										<td class="center"><?php echo $leave[$key]['applied_to_date'];?></td>
										<td class="center"><?php echo $leave[$key]['no_days'];?></td>
						<td class="center"><?php echo $this->Admin_model->getLeaveTypeById($leave[$key]['leave_type']);?></td>
										<td class="center"><?php echo $leave[$key]['reason'];?></td>
										<td class="center"><?php echo $leave[$key]['applied_on_date'];?></td>
										<td class="center">
										<?php if($leave[$key]['status']=='Approved'){
											$var='label label-success';
											}elseif($leave[$key]['status']=='Rejected'){ $var='label label-danger';
											}elseif($leave[$key]['status']=='Pending'){ $var='label label-warning';
											}else{ $var=""; }?><span class="<?=$var;?>"><?php echo $leave[$key]['status'];?></span></td>
										<!--<td class="center">
							<p><a style="width: 106px;" href="del_leave_app?id=<?=$leave[$key]['lid'];?>" class="btn btn-danger">
                        <i class="fa fa-trash"></i> Delete</a></p></td>-->
						</tr>	
										
										<?php }}?>
                          
						</tbody>

							</table>
					  </div>
					            </div>
							 <div class="form-group">
                                    <div class="col-sm-4"></div>
                                    <div class="col-sm-2">
                                        <a class="btn btn-primary form-control" id="btn_submit" type="submit" href="<?php echo base_url().'home'?>">Go Back </a>                                        
                                    </div> 
                             </div>									
                                </div>
                            </div> 
                          </div>             
                                             
                               
                            </form>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('#dob-datepicker').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
	$('#dob-datepicker1').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
	var content = '<tr>'+$('#eduDetTable tbody tr').html()+'</tr>';
	$("#eduDetTable").on("click","input[name='addMore']", function(e){	
	//$("input[name='addMore']").on('click',function(){		
		//var content = $(this).parent().parent('tr').clone('true');
		$(this).parent().parent('tr').after(content);		
	});
	$("#eduDetTable").on("click","input[name='remove']", function(e){	
	//$("input[name='remove']").on('click',function(){
		var rowCount = $('#eduDetTable tbody tr').length;
		if(rowCount>1){
			$(this).parent().parent('tr').remove();
		}
	});	
});
</script>