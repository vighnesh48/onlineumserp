<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<script>    
    $(document).ready(function()
    {
        
    });
</script>
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="#">Leave Applications </a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Leave Applications </h1>
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
                        <div class="table-info">
                            <form id="form" name="form" action="<?=base_url($currentModule.'/submit')?>" method="POST">                                                               
                                <input type="hidden" value="" id="campus_id" name="campus_id" />
                                
                                <!--<div class="form-group">
                                    
                                    <label class="col-sm-2">Admission Date <?=$astrik?></label>
                                    <div class="col-sm-4">
                                    <div id="bs-datepicker-component" class="input-group date">
                                        <input type="text" id="po_date" class="form-control"><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
                                    </div>
                                </div>-->
                                <!--<div class="form-group">               
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('campus_state');?></span></div>
                                </div>-->
                                
                                <div class="form-group">
                                    <div class="col-sm-2">
						<!--<a class="btn btn-primary form-control"id="btnNext" href="">Add Employee <i class="fa fa-plus"></i></a>-->	
                                    </div> 
                                </div>
                                
                             <div id="dashboard-recent" class="panel-warning">   
                               <div class="panel">
                            	<div class="panel-heading"><strong>Leave Applications </strong></div>
                                <div class="panel-body">
								<span id="flash-messages" style="color:red;padding-left:110px;"><?php echo $this->session->flashdata('message1'); ?></span>
                                <div class="panel-padding no-padding-vr">
                            <div class="form-group">
                              <div class="row"></div>
							  <div class="table-scrollable">
							  <table style="width: 1044px;" aria-describedby="applications_info" role="grid" 
							  class="table table-striped table-bordered table-hover no-footer" id="applications">
							  <!-- class='dataTable' for sorting arrows icon for col-->
                                     <thead>
                                    <tr role="row">
									<th aria-label="ID: activate to sort column ascending" style="width: 30px;" colspan="1" rowspan="1" aria-controls="applications" tabindex="0" class="center sorting">ID</th>
									<th aria-label="Name: activate to sort column ascending" aria-sort="ascending" style="width: 103px;" colspan="1" rowspan="1" aria-controls="applications" tabindex="0" class="center sorting_asc">Name</th>
									<th aria-label="Date: activate to sort column ascending" style="width: 99px;" colspan="1" rowspan="1" aria-controls="applications" tabindex="0" class="center sorting">Date</th>
									<th aria-label="Leave Type: activate to sort column ascending" style="width: 122px;" colspan="1" rowspan="1" aria-controls="applications" tabindex="0" class="center sorting">Leave Type</th>
									<th aria-label="Reason: activate to sort column ascending" style="width: 122px;" colspan="1" rowspan="1" aria-controls="applications" tabindex="0" class="center sorting">Reason</th>
									
				                 <th aria-label="Applied on: activate to sort column ascending" style="width: 116px;" colspan="1" rowspan="1" aria-controls="applications" tabindex="0" class="center sorting">Applied on</th>
									<th aria-label="Status: activate to sort column ascending" style="width: 85px;" colspan="1" rowspan="1" aria-controls="applications" tabindex="0" class="center sorting">Status</th>
									<th aria-label="Action" style="width: 162px;" colspan="1" rowspan="1" class="center sorting_disabled">Action</th>
									</tr>
                                    </thead>
                                    <tbody>
                                   <?php if(empty($applicant)){?>
									<tr id="row441" class="odd" role="row">
										<td class=" center"><?php echo "No Leave Applications Available"; ?></td>
										</tr>
									<?php }else{
										$i=0;
										foreach($applicant as $key=>$val){
											$i++;
										?>
									<tr id="row<?php echo $i;?>" class="odd" role="row">
										<td class="center"><?php echo $applicant[$key]['lid'];?></td>
										<td class="center sorting_1"><?php echo $applicant[$key]['ename'];?></td>
										<td class="center"><?php echo $applicant[$key]['applied_from_date'];?></td>
										<td class="center"><?php echo $this->Admin_model->getLeaveTypeById($applicant[$key]['leave_type']);?></td>
										<td class="center"><?php echo $applicant[$key]['reason'];?></td>
										<td class="center"><?php echo $applicant[$key]['applied_on_date'];?></td>
										<td class="center">
										<?php if($applicant[$key]['status']=='Approved'){
											$var='label label-success';
											}elseif($applicant[$key]['status']=='Rejected'){ $var='label label-danger';
											}elseif($applicant[$key]['status']=='Pending'){ $var='label label-warning';
											}else{ $var=""; }?><span class="<?=$var;?>"><?php echo $applicant[$key]['status'];?></span></td>
										<td class="center">
										<p>
										<a class="btn btn-success" data-toggle="modal" href="view_leave_application?id=<?php echo $applicant[$key]['lid'];?>" ><i class="fa fa-edit"></i> View/Edit</a></p>
                          <p><a style="width: 106px;" href="del_leave_app?id=<?=$applicant[$key]['lid'];?>" class="btn btn-danger">
                        <i class="fa fa-trash"></i> Delete</a></p></td>
						</tr>	
										
										<?php }}?>
                          
						</tbody>

							</table></div>
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
	$('#dob-datepicker').datepicker( {format: 'yyyy-mm-dd'});
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