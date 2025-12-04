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
            fields: 
            {
				.only_number:
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
				campus:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select campus'
                      },
                      required: 
                      {
                       message: 'Please select campus'
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
		<li class="active"><a href="<?=base_url($currentModule)?>">Transport </a></li>
        <!--<li class="active"><a href="#">Cousre</a></li>-->
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-5 text-center text-left-sm">
			<i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Add Boarding Fee Details </h1>
			
        </div>
        
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-heading">
                            <span class="panel-title">Details</span>
							<span style="color:red;padding-left:40px;" id="err_msg"></span>
							<span style="color:red;padding-left:40px;" id="err_msg1"></span>
							
			<span id="flash-messages" style="color:Green;padding-left:50px;">
				 <?php if(!empty($this->session->flashdata('message1'))){ echo $this->session->flashdata('message1'); } ?>
			</span>
			<span id="flash-messages" style="color:red;padding-left:50px;">
			 <?php if(!empty($this->session->flashdata('message2'))){ echo $this->session->flashdata('message2'); } ?>
			</span>
                    </div>
                    <div class="panel-body">
                        <div class="table-info">                            
                            
                             
							<div class="form-group">
                                    <label class="col-sm-2">Campus <?=$astrik?></label>                                    
                                    <div class="col-sm-4">
                                        <select id="campus" name="campus" class="form-control" required>
											  <option value="">Select Campus</option>
											  <?php //echo "state".$state;exit();
                                        if(!empty($campus)){
                                            foreach($campus as $campusname){
                                                ?>
                                              <option value="<?=$campusname['campus_name']?>"><?=$campusname['campus_name']?></option>  
                                            <?php 
                                                
                                            }
                                        }
                                      ?>
                                    </select>
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('campus');?></span></div>
                                </div>                                                          
                                <div class="form-group">
                                    <label class="col-sm-2">Academic Year<?=$astrik?></label>                                    
                                    <div class="col-sm-4">
                                        <select id="academic" name="academic" class="form-control" >
                                            <option value="">Select Academic Year</option>
                                            <?php 
										 $yyyy=date('Y');
										 $yy=date('y')+1;
										   for($i=1;$i<=4;$i++)
										   {
											   /* if($yyyy==2017)
												   echo '<option selected value="'.$yyyy.'-'.$yy.'">'.$yyyy.'-'.$yy.'</option>';
											   else */
												   echo '<option value="'.$yyyy.'-'.$yy.'">'.$yyyy.'-'.$yy.'</option>';
											   
											   $yyyy--;$yy--;
										   }
										   ?>
                                      
                                        </select>
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('academic');?></span></div>
                                </div>
                                																
                                <div class="form-group">
                                    <div class="col-sm-2"></div>
                                    <div class="col-sm-2">
                                        <button class="btn btn-primary form-control" id="btn_submit" >Show List</button>                                        
                                    </div>                                    
                                    <div class="col-sm-2"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule)?>'">Cancel</button></div>
                                    <div class="col-sm-4"></div>
                                </div>
                            
                            
                        </div>
						<div class="row ">
							<div id="r_div" class="col-sm-12" style="display:none;">
								<div class="table-info">    
									<form id="form" name="form" action="<?=base_url($currentModule.'/fees_details_submit')?>" method="POST" >
									<input type="hidden" name="academicyear" id="academicyear" />
									<div id="list">
									
									</div>
									
									<div class="form-group">
										<div class="col-sm-2"></div>
										<div class="col-sm-2">
											<button class="btn btn-primary form-control" id="save" type="submit" >Save</button>                                        
										</div>                                    
										<div class="col-sm-2"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule.'/add_boarding_fees')?>'">Cancel</button></div>
										<div class="col-sm-4"></div>
									</div>
									
									</form>
								</div>
							</div>
							<div id="already_added" class="col-sm-12" style="display:none;">
							<h4 style="color:red" >Already fee details have entered for the selected campus and academic year. </h4>
							</div>
						</div>
                    </div>
                </div>
            </div>    
        </div>
    </div>
</div>


<script>
var status=0,error_status=0;
var type='',url='',datastring='',html_content='';
$(document).ready(function(){
	$('#btn_submit').on('click', function () {
		var campus=$('#campus').val();
		var academic=$('#academic').val();
		
		if (campus == "" || academic == "")
		{
			$('#err_msg').html("Please Select both academic and campus fields!!!");
			return false;
		}
		else
		{
			$("#academicyear").val(academic);
			$('#err_msg').html('');//getboardingsbycampus
			type='POST',url='<?= base_url() ?>Transport/get_boarding_list',datastring={academic:academic,campus:campus};
			html_content=ajaxcall(type,url,datastring);
			//alert(html_content);
			if(html_content!="")
			{	
				$('#list').html(html_content);
				$('#r_div').show();
				$('#already_added').hide();
			}
			else
			{
				$('#r_div').hide();
				$('#already_added').show();
			}
		}
	});
});

function ajaxcall(type,url,datastring)
{  
	var res;
	$.ajax({
		type:type,
		url:url,
		data:datastring,
		cache:false,
		async:false,
		success: function(result)
	 {
	  res=result;	 
	 }
	});
	return res; 
}

function only_number(id)
{
	var r_no=$('#'+id).val();
	r_no = r_no.replace(/[^0-9]/g, '');
	$('#'+id).val(r_no);
	$(':input[type="submit"]').prop('disabled', false);return true;
}

function check_route_exists()
{
	var rname=$('#rname').val();
	var rcode=$('#rcode').val();
	$('#err_msg').html('');
		$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Transport/check_route_exists',
				data: {rname:rname},
				success: function (html) {
					//alert(html);
					if(html>0)
					{$('#err_msg1').html("This route name is already there.");status=1;}
				else
					{$('#err_msg1').html("");status=0;}
				}
		});
}

function validate_faci_category(events)
{
	if(status==1)
	{ return false;}
}


</script>
