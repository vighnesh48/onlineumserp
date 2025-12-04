<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<script src="<?=base_url('assets/javascripts').'/bootstrap-datetimepicker.min.js'?> "></script>
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
        <li class="active"><a href="#">Apply Leave</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Leave Application</h1>
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
					   <span id="flash-messages" style="color:red;padding-left:110px;"><?php echo $this->session->flashdata('message1'); ?></span><br>
                        <div class="table-info">
                            <form id="form" name="form" action="<?=base_url($currentModule.'/add_leave')?>" method="POST" >
                         <div id="dashboard-recent" class="panel-warning">   
                               <div class="panel">
                            	<div class="panel-heading"><strong>Leave Application Form</strong></div>
                                <div class="panel-body">
								<input type="hidden" name="emp_id" value="<?php echo $this->session->userdata('name');?>">
                                <div class="form-group">
        										<label class="col-md-3 control-label">Leave Type</label>
        										<div class="col-md-3">
												<select id="leave_type" name="leave_type" class="form-control" required>
												<option value="">Select Leave Type</option>
												<?php foreach($leave as $l){
													echo "<option value=".$l['leave_id'].">".$l['ltype']."</option>";
												}
												?>
												</select>
												</div>
        									</div>
									<div class="form-group">
        										<label class="col-md-3 control-label">Reason For Leave</label>
        										<div class="col-md-3">
												<textarea  class="form-control"  style="resize:none;" required name="reason" placeholder="Reason For Leave" ></textarea>
												</div>
        									</div>
                                        
                                        <div class="form-group">
        										<label class="col-md-3 control-label">Leave From Date</label>
												<div class="col-md-3">
        										<div class="input-group date" id="dob-datepicker">
        										<input class="form-control" name="applied_from_date" placeholder="Leave From Date" type="text" required>
        												<span class="input-group-btn">
        												<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
        												</span>
        											</div>
													</div>
        									</div>	
											<div class="form-group">
        										<label class="col-md-3 control-label">Leave To Date</label>
												<div class="col-md-3">
        										<div class="input-group date" id="dob-datepicker1">
        							<input class="form-control" name="applied_to_date" placeholder="Leave To Date" type="text" required>
        												<span class="input-group-btn">
        												<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
        												</span>
        											</div>
													</div>
        									</div>	
                                    <div class="form-group">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-2">
                                        <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Submit  </button>                                      
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
</div>
<script type="text/javascript">
$(document).ready(function(){
	$("#leave_type").select2({
        placeholder: "Select Leave Type",
        allowClear: true
    });
	/* $('#dob-datepicker').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
	$('#dob-datepicker1').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
	 */
	     $("#dob-datepicker").datepicker({
        todayBtn:  1,
        autoclose: true,
		format: 'yyyy-mm-dd'
    }).on('changeDate', function (selected) {
        var minDate = new Date(selected.date.valueOf());
		$('#dob-datepicker1').datepicker('setStartDate', minDate);
    });
    
    $("#dob-datepicker1").datepicker({
        autoclose: true,
		format: 'yyyy-mm-dd'
    }).on('changeDate', function (selected) {
            var minDate = new Date(selected.date.valueOf());
            $('#dob-datepicker').datepicker('setEndDate', minDate);
	});
	
	
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