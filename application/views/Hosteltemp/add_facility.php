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
                category:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select Hostel'
                      },
                      required: 
                      {
                       message: 'Please select Hostel'
                      }
                     
                    }
                },
				faci_id:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select Facility'
                      },
                      required: 
                      {
                       message: 'Please select Facility'
                      }
                     
                    }
                },
				academic:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select academic'
                      },
                      required: 
                      {
                       message: 'Please select academic'
                      }
                     
                    }
                },
                deposit:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'deposit should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[0-9/]+$/,
                        message: 'deposit should be numeric'
                      },
                     /*  stringLength: 
                        {
                        max: 12,
                        min: 10,
                        message: 'Mobile number should be 10-12 characters.'
                        } */
                    }
                },
				 fees:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Fees should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[0-9/]+$/,
                        message: 'Fees should be numeric'
                      },
                     /*  stringLength: 
                        {
                        max: 12,
                        min: 10,
                        message: 'Mobile number should be 10-12 characters.'
                        } */
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
        <li class="active"><a href="#">Hostel</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Add Fee Details</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row"> 
						<br/>				
					<span id="flash-messages" style="color:Green;padding-left:50px;">
						 <?php if(!empty($this->session->flashdata('message1'))){ echo $this->session->flashdata('message1'); } ?></span>
					<span id="flash-messages" style="color:red;padding-left:50px;">
						 <?php if(!empty($this->session->flashdata('message2'))){ echo $this->session->flashdata('message2'); } ?></span>
                    <hr class="visible-xs no-grid-gutter-h">
                </div>
            </div>
        </div>
        
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-heading">
                            <span class="panel-title">Enter Details</span>
							<span style="color:red;padding-left:40px;" id="err_msg"></span>
                    </div>
                    <div class="panel-body">
                        <div class="table-info">                            
                            
                            <form id="form" name="form" action="<?=base_url($currentModule.'/add_faci_submit')?>" method="POST" onsubmit="return validate_faci_category(event)">                                                               
                                <div class="form-group">
                                    <label class="col-sm-3">Select Academic Year <?=$astrik?></label>                                    
                                    <div class="col-sm-4">
                                        <select id="academic" name="academic" class="form-control" >
                                         <option value="">Select Academic Year</option>
                                           <?php //echo "state".$state;exit();
										if(!empty($academic_details)){
											foreach($academic_details as $academic){
												$arr=explode("-",$academic['academic_year']);
												$ac_year=$arr[0];
												if($academic['status']=='Y')
												{
												?>
											  <option selected value="<?=$ac_year?>"><?=$academic['academic_year']?></option>  
											<?php 
												}else{
												?>
												<option value="<?=$ac_year?>"><?=$academic['academic_year']?></option> 
												<?php
												}
												
											}
										}
									  ?>
                                        </select>                                        
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('academic');?></span></div>
                                </div>
                                
								<div class="form-group">
                                    <label class="col-sm-3">Select Type <?=$astrik?></label>                                    
                                    <div class="col-sm-4">
                                        <select class="form-control" name="faci_id" id="faci_id" required>
											  <option value="">select Type</option>
											  <?php //echo "state".$state;exit();
												if(!empty($facilities_types)){
													foreach($facilities_types as $types){
														?>
													  <option value="<?=$types['faci_id']?>"><?=$types['facility_name']?></option>  
													<?php 
														
													}
												}
											  ?>
										  </select>                                       
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('faci_id');?></span></div>
                                </div>
								
								<div class="form-group">
                                    <label class="col-sm-3">Select Campus <?=$astrik?></label>                                    
                                    <div class="col-sm-4">
                                        <select id="category" name="category" onchange="check_facility_exists()" class="form-control" required>
											  <option value="">select Campus</option>
											 <?php //echo "state".$state;exit();
                                        if(!empty($campus)){
                                            foreach($campus as $campusname){
                                                ?>
                                              <option value="<?=$campusname['cat_id']."||".$campusname['campus_name']?>"><?=$campusname['campus_name']?></option>  
                                            <?php 
                                                
                                            }
                                        }
                                      ?>
                                        </select>                                        
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('category');?></span></div>
                                </div>
								
								<div class="form-group">
                                    <label class="col-sm-3">Deposit <?=$astrik?></label>
                                    <div class="col-sm-4"><input type="text" id="deposit" name="deposit" class="form-control" /></div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('deposit');?></span></div>
                                </div>
								
								<div class="form-group">
                                    <label class="col-sm-3">Fees <?=$astrik?></label>
                                    <div class="col-sm-4"><input type="text" id="fees" name="fees" class="form-control" /></div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('fees');?></span></div>
                                </div>
								
                                <div class="form-group">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-2">
                                        <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Add</button>                                        
                                    </div>                                    
                                    <div class="col-sm-2"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule.'/view_facilities')?>'">Cancel</button></div>
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
function check_facility_exists()
{
	var academic=$('#academic').val();
	var faci_id=$('#faci_id').val();
	var category=$('#category').val();
	if(academic=="")
	{
		$('#err_msg').html('Please select Academic year!!');
	}
	else if(faci_id=="")
	{
		$('#err_msg').html('Please select Facility type!!');
	}
	else if(category=="")
	{
		$('#err_msg').html('Please select Hostel!!');
	}
	else
	{
		$('#err_msg').html('');
		$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Hostel/check_facilityfee_exists',
				data: {academic:academic,faci_id:faci_id,category:category},
				success: function (html) {
					//alert(html);
					if(html==1)
					{$('#err_msg').html("Fee Details are already added for the given hostel and academic!!");status=1;}
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

$(document).ready(function(){
	    // Num check logic
  	$('.numbersOnly').keyup(function () {
    if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
       this.value = this.value.replace(/[^0-9\.]/g, '');
    } 
  	});
  	
    // City by State
	$('#hstate_id').on('change', function () {
		 stateID = $(this).val();
			var state_ID = $("#hstate_id").val();
		alert("called==="+stateID);
		if (stateID) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Ums_admission/getStatewiseDistrict',
				data: 'state_id=' + stateID,
				success: function (html) {
					//alert(html);
					$('#hdistrict_id').html(html);
				}
			});
		} else {
			$('#hdistrict_id').html('<option value="">Select state first</option>');
		}
	});
	
    // City by State
	$('#hdistrict_id').on('change', function () {
		var district_id = $(this).val();
		var state_ID = $("#hstate_id").val();
	//	alert(state_ID);alert(district_id);
		if (district_id) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Ums_admission/getStateDwiseCity',
				data: { state_id: state_ID, district_id : district_id},
				success: function (html) {
					//alert(html);
					if(html !=''){
					$('#hcity').html(html);
					}else{
					  $('#hcity').html('<option value="">No city found</option>');  
					}
				}
			});
		} else {
			$('#hcity').html('<option value="">Select district first</option>');
		}
	});	
	
	});	

</script>
