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
                },
                mname:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Middle name should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[a-zA-Z-/]+$/,
                        message: 'Middle name should be alphabate characters'
                      },
                      stringLength: 
                        {
                        max: 50,
                        min: 2,
                        message: 'Middle name should be 2-50 characters.'
                        }
                    }
                },
				fname:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'First name should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[a-zA-Z-/]+$/,
                        message: 'First name should be alphabate characters'
                      },
                      stringLength: 
                        {
                        max: 50,
                        min: 2,
                        message: 'First name should be 2-50 characters.'
                        }
                    }
                },
				flname:
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
                },
                fmname:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Middle name should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[a-zA-Z-/]+$/,
                        message: 'Middle name should be alphabate characters'
                      },
                      stringLength: 
                        {
                        max: 50,
                        min: 2,
                        message: 'Middle name should be 2-50 characters.'
                        }
                    }
                },
				ffname:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'First name should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[a-zA-Z-/]+$/,
                        message: 'First name should be alphabate characters'
                      },
                      stringLength: 
                        {
                        max: 50,
                        min: 2,
                        message: 'First name should be 2-50 characters.'
                        }
                    }
                },
				mlname:
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
                },
                mmname:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Middle name should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[a-zA-Z-/]+$/,
                        message: 'Middle name should be alphabate characters'
                      },
                      stringLength: 
                        {
                        max: 50,
                        min: 2,
                        message: 'Middle name should be 2-50 characters.'
                        }
                    }
                },
				mfname:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'First name should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[a-zA-Z-/]+$/,
                        message: 'First name should be alphabate characters'
                      },
                      stringLength: 
                        {
                        max: 50,
                        min: 2,
                        message: 'First name should be 2-50 characters.'
                        }
                    }
                },
				dob: {
					validators: {
						date: {
							format: 'YYYY-MM-DD',
							message: 'The value is not a valid birth date'
						}
					}
				}
                /*campus_state:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Campus state should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[a-zA-Z-/]+$/,
                        message: 'Campus state should be alphabate characters'
                      },
                      stringLength: 
                        {
                        max: 10,
                        min: 2,
                        message: 'Campus state should be 10-50 characters'
                        }
                    }

                },
                campus_city:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Campus city should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[a-zA-Z-/]+$/,
                        message: 'Campus city should be alphabate characters'
                      },
                      stringLength: 
                        {
                        max: 10,
                        min: 2,
                        message: 'Campus city should be 10-50 characters'
                        }
                    }

                },
                campus_address:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Campus address should not be empty'
                      },
                      stringLength: 
                        {
                        max: 100,
                        min: 5,
                        message: 'Campus address should be 5-100 characters'
                        }
                    }

                },
                campus_pincode:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Campus pincode should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[0-9/]+$/,
                        message: 'Campus pincode should be numeric characters'
                      },
                      stringLength: 
                        {
                        max: 6,
                        min: 6,
                        message: 'Campus pincode should be 6 digit numeric value.'
                        }
                    }

                },*/
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
        <li class="active"><a href="#">Department List</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Department List</h1>
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
						<a class="btn btn-primary form-control"id="btnNext" href="">Add Department <i class="fa fa-plus"></i></a>	
                                    </div> 
                                </div>
                                
                             <div id="dashboard-recent" class="panel-warning">   
                               <div class="panel">
                            	<div class="panel-heading"><strong>Department List</strong></div>
                                <div class="panel-body">
                                <div class="panel-padding no-padding-vr">
                            <div class="form-group">
                                   <table aria-describedby="sample_employees_info" role="grid" class="table table-striped table-bordered table-hover dataTable no-footer" id="sample_employees">
							<thead>
							<tr role="row"><th aria-label="
									 EmployeeID
								: activate to sort column ascending" style="width: 82px;" colspan="1" rowspan="1" aria-controls="sample_employees" tabindex="0" class="text-center sorting">
									 EmployeeID
								</th><th aria-label="
                                     Image
                                " style="width: 96px;" colspan="1" rowspan="1" class="text-center sorting_asc">
                                     Image
                                </th><th aria-label="
									 Name
								: activate to sort column ascending" colspan="1" rowspan="1" aria-controls="sample_employees" tabindex="0" class="sorting" style="text-align: center; width: 82px;">
									 Name
								</th><th aria-label="
                                	 Dept/Designation
                                : activate to sort column ascending" style="width: 206px;" colspan="1" rowspan="1" aria-controls="sample_employees" tabindex="0" class="text-center sorting">
                                	 Dept/Designation
                                </th><th aria-label="
                                	 At Work
                                : activate to sort column ascending" style="width: 107px;" colspan="1" rowspan="1" aria-controls="sample_employees" tabindex="0" class="text-center sorting">
                                	 At Work
                                </th><th aria-label="
									 Phone
								: activate to sort column ascending" style="width: 121px;" colspan="1" rowspan="1" aria-controls="sample_employees" tabindex="0" class="text-center sorting">
									 Phone
								</th><th aria-label="
									 Status
								: activate to sort column ascending" style="width: 44px;" colspan="1" rowspan="1" aria-controls="sample_employees" tabindex="0" class="text-center sorting">
									 Status
								</th><th aria-label="
									 Action
								" style="width: 110px;" colspan="1" rowspan="1" class="text-center sorting_disabled">
									 Action
								</th></tr>
							</thead>
							<tbody>
							<tr><td colspan="7">No Data Available.......</td></tr>
					</tbody>
							</table>
                                  </div>
							                          
                                
                                  
                                  </div>
                                </div>
                            </div> 
                          </div>             
                                
                              
                               <!-- <div class="form-group">
                                    <div class="col-sm-4"></div>
                                    <div class="col-sm-2">
                                        <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Submit</button>                                        
                                    </div>                                    
                                    <div class="col-sm-2"><button class="btn btn-primary form-control" id="btn_cancel" type="button">Cancel</button></div>
                                    <div class="col-sm-4"></div>
                                </div>-->
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