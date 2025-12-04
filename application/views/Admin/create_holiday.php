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
                order_ref_no:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Order Referance No should not be empty'
                      }
                    }
                },
                order_date:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Order name should not be empty'
                      }
                    }
                },
				occasion:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Occasion should not be empty'
                      }
                    }
                },
				frm_date:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Form date should not be empty'
                      }
                    }
                },
                to_date:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'To Date should not be empty'
                      }
                    }
                },
				approved_by:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Select Approved By'
                      }
                    }
                }
            }       
        })
		
});
    
</script>
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="#">Add Holiday</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Add New Holiday</h1>
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
                           
                         <div id="dashboard-recent" class="panel-warning">   
                               <div class="panel">
                            	<div class="panel-heading"><strong>New Holiday Addition</strong></div>
                                <div class="panel-body">
                                <div class="panel-padding no-padding-vr">
                            <div class="modal-body">
                											<div class="portlet-body form">

                                                            						<!-- BEGIN FORM-->
                                 <form id="form" name="form" action="<?=base_url($currentModule.'/add_holiday')?>" method="POST" enctype="multipart/form-data">
							<div class="form-body">
								<div class="form-group">
								<label class="col-md-3">Order Referance No:</label>
                                             <div class="col-md-3" >
                                  <input id="orderrefno" class="form-control form-control-inline input-medium" name="order_ref_no" value="" placeholder="Enter Referance No" type="text">

                                             </div>
                                  </div>
								  <div class="form-group">
								<label class="col-md-3">Order Date:</label>
                                             <div class="col-md-3" >
                                  <input id="dob-datepicker1" class="form-control form-control-inline input-medium date-picker" name="order_date" value="" placeholder="Enter Order Date" type="text">

                                             </div>
                                  </div>
								  <div class="form-group">
							 <label class="col-md-3">Occasion</label>
                                            <div class="col-md-3">
                                                    <input class="form-control form-control-inline" name="occasion" placeholder="Occasion" type="text">
                                            </div>
                                  </div>
                                <div class="form-group">
								<label class="col-md-3">Occasion Date:</label>
                                             <div class="col-md-2" >
                                  <input id="dob-datepicker" class="form-control form-control-inline  date-picker" name="frm_date" value="" placeholder="Enter from Date" type="text">
</div> <div class="col-md-2" style="margin-left:5px;">
								  <input id="dob-datepicker2" class="form-control form-control-inline  date-picker" name="to_date" value="" placeholder="Enter To Date" type="text">

                                             </div>
                                  </div>
				              
                                    <div class="form-group">
							 <label class="col-md-3">Approved By</label>
                                            <div class="col-md-3">
                                                    <select name="approved_by">
													<option value="">Select</option>
													<option value="management">Management</option>
													<option value="university">University</option>
													</select>
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
                                 <!-- END FORM-->
                             </div>
                                    </div>
        		   </div>
					 </div>
                                </div>
                            </div> 
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
	var current_year=new Date().getFullYear(); //get current year
	//alert(current_year);
	$('#dob-datepicker').datepicker( {format: 'yyyy-mm-dd',autoclose: true,startDate: new Date(current_year, 0, 1)});
	$('#dob-datepicker1').datepicker( {format: 'yyyy-mm-dd',autoclose: true,startDate: new Date(current_year, 0, 1)});
	$('#dob-datepicker2').datepicker( {format: 'yyyy-mm-dd',autoclose: true,startDate: new Date(current_year, 0, 1)});
	
	//$('#dob-datepicker').datepicker( {format: 'yyyy-mm-dd',autoclose: true,startDate:'+current_year+'});
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