<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<script> 
var start_month="<?=$academic_details['start_month']?>";
var last_month="<?=$academic_details['last_month']?>";
var session="<?=$academic_details['academic_session']?>";  
var active="<?=$academic_details['currently_active']?>";
var id="<?=$academic_details['id']?>";

    $(document).ready(function()
    {
		$('#session option').each(function()
		 {              
			if($(this).val()== session)
			{
				$(this).attr('selected','selected');
			}
		});
		
		$('#smonth option').each(function()
		 {              
			if($(this).val()== start_month)
			{
				$(this).attr('selected','selected');
			}
		});
		
		$('#lmonth option').each(function()
		 {              
			if($(this).val()== last_month)
			{
				$(this).attr('selected','selected');
			}
		});
		
		$('#active option').each(function()
		 {              
			if($(this).val()== active)
			{
				$(this).attr('selected','selected');
			}
		});
		
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
            fields: 
            {
                
				session:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select Academic session'
                      },
                      required: 
                      {
                       message: 'Please select Academic session'
                      }
                     
                    }
                },
				academic:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select academic year'
                      },
                      required: 
                      {
                       message: 'Please select academic year'
                      }
                     
                    }
                },
               smonth:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select Start Month'
                      },
                      required: 
                      {
                       message: 'Please select Start Month'
                      }
                     
                    }
                },
				lmonth:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select Last Month'
                      },
                      required: 
                      {
                       message: 'Please select Last Month'
                      }
                     
                    }
                },
				active:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select Currently Active'
                      },
                      required: 
                      {
                       message: 'Please select Currently Active'
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
        <!--<li class="active"><a href="#">Academic Session</a></li>-->
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-5 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Update Academic Session </h1>
			<span style="color:red;padding-left:0px;" id="err_msg"></span>
			<span id="flash-messages" style="color:Green;padding-left:50px;">
						 <?php if(!empty($this->session->flashdata('message1'))){ echo $this->session->flashdata('message1'); } ?></span>
		<span id="flash-messages" style="color:red;padding-left:50px;">
			 <?php if(!empty($this->session->flashdata('message2'))){ echo $this->session->flashdata('message2'); } ?></span>
           
        </div>
        
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-heading">
                            <span class="panel-title">Update Details</span>
							
                    </div>
                    <div class="panel-body">
                        <div class="table-info">                            
                            
                            <form id="form" name="form" action="<?=base_url($currentModule.'/edit_academic_session_submit')?>" method="POST" onsubmit="return validate_faci_category(event)">    
							<input type="hidden" name="aca_id" id="aca_id" value="<?=$academic_details['id']?>"/>                                                      
                                <div class="form-group">
                                    <label class="col-sm-3">Academic Year <?=$astrik?></label>                                    
                                    <div class="col-sm-4">
                                        <select id="academic" name="academic" onchange="check_session_exists()" class="form-control" >
                                            <option value="">Select Academic Year</option>
                                            <?php 
										 $yyyy=date('Y');
										 $yy=date('y')+1;
										   for($i=1;$i<=4;$i++)
										   {
											   if($yyyy.'-'.$yy==$academic_details['academic_year'])
												   echo '<option selected value="'.$yyyy.'-'.$yy.'">'.$yyyy.'-'.$yy.'</option>';
											   else 
												   echo '<option value="'.$yyyy.'-'.$yy.'">'.$yyyy.'-'.$yy.'</option>';
											   
											   $yyyy--;$yy--;
										   }
										   ?>
                                      
                                        </select>                                        
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('academic');?></span></div>
                                </div>
                                
								<div class="form-group">
                                    <label class="col-sm-3">Session <?=$astrik?></label>                                    
                                    <div class="col-sm-4">
                                        <select class="form-control" onchange="check_session_exists()" name="session" id="session" required>
											  <option value="">select Session</option>
											  <option value="SUMMER">SUMMER</option>
											  <option value="WINTER">WINTER</option>
										  </select>                                       
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('session');?></span></div>
                                </div>
								
								<div class="form-group">
                                    <label class="col-sm-3">Start Month <?=$astrik?></label>                                    
                                    <div class="col-sm-4">
                                        <select id="smonth" name="smonth" onchange="check_session_exists()" class="form-control" required>
											  <option value="">select Start Month</option>
											  <option value="JAN">JAN</option>
											  <option value="JUL">JUL</option>
                                        </select>                                        
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('smonth');?></span></div>
                                </div>
								
								<div class="form-group">
                                    <label class="col-sm-3">Last Month <?=$astrik?></label>                                    
                                    <div class="col-sm-4">
                                        <select id="lmonth" name="lmonth" onchange="check_session_exists()" class="form-control" required>
											  <option value="">select Last Month</option>
											  <option value="JUN">JUN</option>
											  <option value="DEC">DEC</option>
                                        </select>                                        
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('lmonth');?></span></div>
                                </div>
								<div class="form-group">
                                    <label class="col-sm-3">Currently Active <?=$astrik?></label>                                    
                                    <div class="col-sm-4">
                                        <select id="active" name="active" class="form-control" required>
											  <option value="">select Currently Active</option>
											  <option value="Y">yes</option>
											  <option value="N">No</option>
                                        </select>                                        
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('active');?></span></div>
                                </div>
								
                                <div class="form-group">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-2">
                                        <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Update</button>                                        
                                    </div>                                    
                                    <div class="col-sm-2"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule.'/academic_session')?>'">Cancel</button></div>
                                    <div class="col-sm-4"></div>
                                </div>
                            </form>
                            
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </div>
</div>


<script>
var status=0;
function check_session_exists()
{
	var academic=$('#academic').val();
	var session=$('#session').val();
	var smonth=$('#smonth').val();
	var lmonth=$('#lmonth').val();
	if(academic=="")
	{
		$('#err_msg').html('Please select Academic year.');
	}
	else if(session=="")
	{
		$('#err_msg').html('Please select Session.');
	}
	else if(smonth=="")
	{
		$('#err_msg').html('Please select start month.');
	}
	else if(lmonth=="")
	{
		$('#err_msg').html('Please select last month.');
	}
	else
	{
		$('#err_msg').html('');
		$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Master/check_academic_session_exists',
				data: {academic:academic,session:session,smonth:smonth,lmonth:lmonth,id:id},
				success: function (html) {
					//alert(html);
					if(html>0)
					{$('#err_msg').html("This Academic session Details are already there!!");status=1;}
				else
					{$('#err_msg').html("");status=0;}
				}
			});
	}
}

function validate_faci_category(events)
{
	if(status==1)
	{ return false;}
}


</script>
