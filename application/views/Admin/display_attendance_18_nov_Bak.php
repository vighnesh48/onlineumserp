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
        <li class="active"><a href="#">Attendance </a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;View Attendance </h1>
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
                                                    
                                                               
                             <div id="dashboard-recent" class="panel-warning">   
                               <div class="panel">
                            	<div class="panel-heading"><strong>Attendance </strong></div>
                                <div class="panel-body">
								<span id="flash-messages" style="color:red;padding-left:110px;"><?php echo $this->session->flashdata('message1'); ?></span>
                                <div class="panel-padding no-padding-vr">
                            <div class="form-group">
                              <div class="row"></div>
							  <div class="portlet-body form">
							  <form id="form" name="form" action="<?=base_url($currentModule.'/view_attendance')?>" method="POST" enctype="multipart/form-data">
								<div class="form-body">
                                <div class="form-group">
								<label class="col-md-3">Select Date</label>
                                             <div class="col-md-3" >
                                  <input id="dob-datepicker" class="form-control form-control-inline input-medium date-picker" name="attend_date" value="" placeholder="Enter Date" type="text">

                                             </div>
                                  </div>
				                                                                               

                                   <div class="form-group">
								   <div class="col-md-3" ></div>
                                      <div class=" col-md-2">  
                                            <button type="submit" class="btn btn-primary form-control" >Submit</button>
                                        </div>
                                       
                                    </div>
                            </div>
                                    </form>
									</div>
									<?php// print_r($attendance);
									//die();
									?>
							
							  <div class="pagination" style="float:right;"> <?php  echo $paginglinks['navigation']; ?></div>
<div class="pagination" style="float:left;"> <?php echo (!empty($pagermessage) ? $pagermessage : ''); ?></div>
							  <table style="width: 1044px;" aria-describedby="applications_info" role="grid" 
							  class="table table-striped table-bordered table-hover no-footer" id="applications">
							  <!-- class='dataTable' for sorting arrows icon for col-->
                                     <thead>
                                    <tr role="row">
									<th aria-label="ID: activate to sort column ascending" style="width: 30px;" colspan="1" rowspan="1" aria-controls="applications" tabindex="0" class="center sorting">USER ID</th>
									<!--<th aria-label="Name: activate to sort column ascending" aria-sort="ascending" style="width: 103px;" colspan="1" rowspan="1" aria-controls="applications" tabindex="0" class="center sorting_asc">Name</th>-->
									<th aria-label="Date: activate to sort column ascending" style="width: 99px;" colspan="1" rowspan="1" aria-controls="applications" tabindex="0" class="center sorting">In Time</th>
									<th aria-label="Leave Type: activate to sort column ascending" style="width: 122px;" colspan="1" rowspan="1" aria-controls="applications" tabindex="0" class="center sorting">Out Time</th>
									<th aria-label="Reason: activate to sort column ascending" style="width: 122px;" colspan="1" rowspan="1" aria-controls="applications" tabindex="0" class="center sorting">Punch Date</th>
									
				                <!-- <th aria-label="Applied on: activate to sort column ascending" style="width: 116px;" colspan="1" rowspan="1" aria-controls="applications" tabindex="0" class="center sorting">Applied on</th>
									<th aria-label="Status: activate to sort column ascending" style="width: 85px;" colspan="1" rowspan="1" aria-controls="applications" tabindex="0" class="center sorting">Status</th>
									<th aria-label="Action" style="width: 162px;" colspan="1" rowspan="1" class="center sorting_disabled">Action</th>-->
									</tr>
                                    </thead>
                                    <tbody>
                                   <?php if(empty($attendance)){?>
									<tr id="row441" class="odd" role="row">
										<td class=" center"><?php echo "No Attendance  Available for Mentioned Date"; ?></td>
										</tr>
									<?php }else{
										$i=0;
										foreach($attendance as $key=>$val){
											$i++;
										?>
									
										<td class="center"><?php echo $attendance[$key]['UserId'];?></td>
										<td class="center sorting_1"><?php echo $attendance[$key]['punch_intime'];?></td>
										<td class="center"><?php echo $attendance[$key]['punch_outtime'];?></td>
										<td class="center"><?php echo $attendance[$key]['punch_date'];?></td>
										
						</tr>	
										
										<?php }}?>
                          
						</tbody>

							</table>
							
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
	$('#dob-datepicker').datepicker( {format: 'yyyy-mm-dd',autoclose:true});
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