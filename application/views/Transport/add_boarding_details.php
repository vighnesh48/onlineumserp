<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<script>    
    $(document).ready(function()
    {
		$('#ptime').timepicker({ 'Default': 'now' });
			
		$('#dtime').timepicker({ 'Default': 'now' });
		
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
                
				bpoint:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please Enter Boarding Point'
                      },
                      required: 
                      {
                       message: 'Please Enter Boarding Point'
                      }
                     
                    }
                },
               distance:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please Enter Distance from campus'
                      },
                      required: 
                      {
                       message: 'Please Enter Distance from campus'
                      }
                     
                    }
                }/* ,ptime:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please Enter Pickup Timing'
                      },
                      required: 
                      {
                       message: 'Please Enter Pickup Timing'
                      }
                     
                    }
                },
               dtime:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please Enter Drop Timing'
                      },
                      required: 
                      {
                       message: 'Please Enter Drop Timing'
                      }
                     
                    }
                } */,
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
		
		
		$('.alphaonly').bind('keyup blur',function(){ 
			var node = $(this);
			node.val(node.val().replace(/[^a-zA-Z ]/g,'') ); }
		);
		$('.alphanum').bind('keyup blur',function(){ 
			var node = $(this);
			node.val(node.val().replace(/[^A-Z0-9 ]/g,'') ); }
		);
		
		$('.time').bind('keyup blur',function(){ 
			var node = $(this);
			node.val(node.val().replace(/[^AMP0-9. ]/g,'') ); }
		);
		
		$('.numbersOnly').keyup(function () {
		
		if (this.value != this.value.replace(/[^0-9.]/g, '')) {
		   this.value = this.value.replace(/[^0-9.]/g, '');
		} 
		});
		
		$('#distance').on('change', function (){
			var node = $(this);
			if(((node.val().match(/[/.]/g) || []).length) > 1)
				$("#err_msg").html('Invalid decimal number(more than two dots).');
			else
				$("#err_msg").html('');
		});
		$('#ptime').on('change', function (){
			
			//start time
			var start_time = $("#ptime").val();

			//end time
			var end_time = $("#dtime").val();

			//convert both time into timestamp
			var stt = new Date("April 13, 2018 " + start_time);
			stt = stt.getTime();

			var endt = new Date("April 13, 2018 " + end_time);
			endt = endt.getTime();
			if(stt >= endt) 
				$("#err_msg").html('Drop timing should be greater');
			else
				$("#err_msg").html('');
		});
		
		$('#dtime').on('change', function (){
			
			//start time
			var start_time = $("#ptime").val();

			//end time
			var end_time = $("#dtime").val();

			//convert both time into timestamp
			var stt = new Date("April 13, 2018 " + start_time);
			stt = stt.getTime();

			var endt = new Date("April 13, 2018 " + end_time);
			endt = endt.getTime();
			if(stt >= endt) 
				$("#err_msg").html('Drop timing should be greater');
			else
				$("#err_msg").html('');
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
        <li class="active"><a href="<?=base_url($currentModule)?>">Transport</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-5 text-center text-left-sm">
			<i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Add Boarding Details </h1>
			
        </div>
        
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-heading">
                            <span class="panel-title">Enter Details</span>
							<span style="color:red;padding-left:40px;" id="err_msg"></span>
							
			<span id="flash-messages" style="color:Green;padding-left:50px;">
				 <?php if(!empty($this->session->flashdata('message1'))){ echo $this->session->flashdata('message1'); } ?>
			</span>
			<span id="flash-messages" style="color:red;padding-left:50px;">
			 <?php if(!empty($this->session->flashdata('message2'))){ echo $this->session->flashdata('message2'); } ?>
			</span>
                    </div>
                    <div class="panel-body">
                        <div class="table-info">                            
                            
                            <form id="form" name="form" action="<?=base_url($currentModule.'/add_boarding_submit')?>" method="POST" onsubmit="return validate_faci_category(event)">     

								
								<div class="form-group">
                                    <label class="col-sm-3">Campus <?=$astrik?></label>                                    
                                    <div class="col-sm-3">
                                        <select id="campus" name="campus"  onchange="check_boardingpoint_exists()" class="form-control" required>
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
                                    <div class="col-sm-4"><span style="color:red;"><?php echo form_error('campus');?></span></div>
                                </div>							
                                <div class="form-group">
                                    <label class="col-sm-3">Boarding Point <?=$astrik?></label>                                    
                                    <div class="col-sm-3">
                                        <input type="text" id="bpoint" name="bpoint" onblur="check_boardingpoint_exists()" class="form-control alphaonly" />
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('bpoint');?></span></div>
                                </div>
                                
								<div class="form-group">
                                    <label class="col-sm-3">Distance From Campus (Km)<?=$astrik?></label>                                    
                                    <div class="col-sm-3">
                                        <input type="text" id="distance" name="distance" class="form-control numbersOnly" />
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('distance');?></span></div>
                                </div>
								<!--
								<div class="form-group">
                                    <label class="col-sm-3">Pickup timing<?=$astrik?></label>                                    
                                    <div class="col-sm-4">
                                        <input id="ptime" name="ptime"  type="text" class="form-control" autocomplete="off">
										
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('ptime');?></span></div>
                                </div>

								<div class="form-group">
                                    <label class="col-sm-3">Drop timing<?=$astrik?></label>                                    
                                    <div class="col-sm-4">
                                       <input id="dtime" name="dtime" type="text" class="form-control" autocomplete="off">
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('dtime');?></span></div>
                                </div>	-->							
																
                                <div class="form-group">
                                    <div class="col-sm-1"></div>
                                    <div class="col-sm-2">
                                        <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Add</button>                                        
                                    </div>                                    
                                    <div class="col-sm-2"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule.'/boarding_list')?>'">Cancel</button></div>
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
var status=0,error_status=0;
function check_boardingpoint_exists()
{
	var bpoint=$('#bpoint').val();
	var campus=$('#campus').val();
	
		$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Transport/check_boardingpoint_exists',
				data: {campus:campus,bpoint:bpoint},
				success: function (html) {
					//alert(html);
					if(html>0)
					{$('#err_msg').html("This boarding point is already there in "+campus+" campus");status=1;}
				else
					{$('#err_msg').html("");status=0;}
				}
		});

}

function validate_faci_category(events)
{
	if(status==1)
	{ return false;}
}
</script>
