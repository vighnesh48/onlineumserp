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
                
				pcode:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please Enter Parternship Code'
                      },
                      required: 
                      {
                       message: 'Please Enter Parternship Code'
                      }
                     
                    }
                },
				factor:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select Mou Sharing factor'
                      },
                      required: 
                      {
                       message: 'Please select Mou Sharing factor'
                      }
                     
                    }
                }
				,
				pemail:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Personal Email should not be empty'
                      }
                    }
                }
				,
				oemail:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Office Email should not be empty'
                      }
                    }
                },
				address:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: ' Address should not be empty'
                      },
                      stringLength: 
                        {
                        max: 50,
                        min: 2,
                        message: ' Address should be 2-50 characters.'
                        }
                    }
                },
				 mobile:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Mobile should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[0-9/]+$/,
                        message: 'Mobile should be numeric'
                      },
                      stringLength: 
                        {
                        max: 10,
                        min:10,
                        message: 'Mobile number should be 10 digits.'
                        }
                
                    }
                },
				 office:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'office should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[0-9/]+$/,
                        message: 'office should be numeric'
                      },
                      stringLength: 
                        {
                        max: 12,
                        min:10,
                        message: 'office number should be 12 digits.'
                        }
                
                    }
                },
				pincode:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Pincode should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[0-9/]+$/,
                        message: 'Pincode should be numeric'
                      },
                      stringLength: 
                        {
                        max: 6,
                        min:6,
                        message: 'Pincode should be 6 digits.'
                        }
                
                    }
                },
				License:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'License NO. should not be empty'
                      }
                    }
                },
				driver:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Driver name should not be empty'
                      },
                      stringLength: 
                        {
                        max: 50,
                        min: 2,
                        message: 'Driver name should be 2-50 characters.'
                        }
                    }
                },
				vendor:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please Select Vendor'
                      },
                      required: 
                      {
                       message: 'Please Select Vendor'
                      }
                     
                    }
                },
				fparty:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Mou sign from university should not be empty'
                      },
                      stringLength: 
                        {
                        max: 50,
                        min: 2,
                        message: 'Mou sign from university should be 2-50 characters.'
                        }
                    }
                },
				sparty:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Mou sign from party should not be empty'
                      },
                      stringLength: 
                        {
                        max: 50,
                        min: 2,
                        message: 'Mou sign from party should be 2-50 characters.'
                        }
                    }
                },
				place:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Place should not be empty'
                      },
                      stringLength: 
                        {
                        max: 50,
                        min: 2,
                        message: 'Place should be 2-50 characters.'
                        }
                    }
                },
				campus:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please Select Campus'
                      },
                      required: 
                      {
                       message: 'Please Select Campus'
                      }
                     
                    }
                },hstate_id:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please Select State'
                      },
                      required: 
                      {
                       message: 'Please Select State'
                      }
                     
                    }
                },
				hdistrict_id:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please Select District'
                      },
                      required: 
                      {
                       message: 'Please Select District'
                      }
                     
                    }
                },
				hcity:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please Select City'
                      },
                      required: 
                      {
                       message: 'Please Select City'
                      }
                     
                    }
                },
				fdate:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please Select Mou signed date'
                      },
                      required: 
                      {
                       message: 'Please Select Mou signed date'
                      }
                     
                    }
                },
				/* sdate:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please Select Service Start date'
                      },
                      required: 
                      {
                       message: 'Please Select Service Start date'
                      }
                     
                    }
                },
				edate:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please Select Service Expiry date'
                      },
                      required: 
                      {
                       message: 'Please Select Service Expiry date'
                      }
                     
                    }
                }, */
				batch:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Batch Number should not be empty'
                      }/* ,
                      stringLength: 
                        {
                        max: 50,
                        min: 2,
                        message: 'Batch Number should be 2-50 characters.'
                        } */
                    }
                },
				bvalidity:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please Select Batch Validity'
                      },
                      required: 
                      {
                       message: 'Please Select Batch Validity'
                      }
                     
                    }
                },
				mou_doc: {
					validators: {
						file: {
							extension: 'jpg,jpeg,png,doc,docx,pdf',
							type: 'image/jpeg,image/jpg,image/png,application/pdf',
							maxSize: 2048 * 1024,
							message: 'Please select jpg,jpeg,png,doc,docx,pdf files'
						}/* ,
						notEmpty: {
								message: 'Service Agreement file is required.'
						  } */
					}
				},
				pic: {
					validators: {
						file: {
							extension: 'jpeg,png,jpg',
							type: 'image/jpeg,image/png/,image/jpg/',
							maxSize: 2048 * 1024,
							message: 'Please select jpeg,png,jpg files'
						}/* ,
						notEmpty: {
								message: 'Service Agreement file is required.'
						  } */
					}
				} 
            }       
        })
		
		
		$('.alphaonly').bind('keyup blur',function(){ 
			var node = $(this);
			node.val(node.val().replace(/[^a-zA-Z ]/g,'') ); }
		);
		
		$('.alpha').bind('keyup blur',function(){ 
			var node = $(this);
			node.val(node.val().replace(/[^A-Z]/g,'') ); }
		);
		
		$('.alphanum').bind('keyup blur',function(){ 
			var node = $(this);
			node.val(node.val().replace(/[^a-zA-Z0-9]/g,'') ); }
		);
		
		$('.numbersOnly').keyup(function () {
		
		if (this.value != this.value.replace(/[^0-9]/g, '')) {
		   this.value = this.value.replace(/[^0-9]/g, '');
		} 
		});
		
		
		$('#campus').on('change', function () {
		 campus = $(this).val();

		if (campus) 
		{
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Transport/getvendorsbycampus',
				data: {campus : campus},
				success: function (html) {
					//alert(html);
					if(html !=''){
					$('#vendor').html(html);
					}else{
					  $('#vendor').html('<option value="">No vendors found</option>');  
					}
				}
			});
		}
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
            <h1 class="col-xs-12 col-sm-5 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Add Driver</h1>
			
        </div>
        
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-heading">
                            <span class="panel-title">Enter Details</span>
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
                            
                            <form id="form" name="form" action="<?=base_url($currentModule.'/add_driver_submit')?>" method="POST" onsubmit="return validate_faci_category(event)" enctype="multipart/form-data">   

								<div class="form-group">
								
									<div class="col-sm-3">
									<label >Select Campus:<?=$astrik?></label>
									
									</div>
									
									<div class="col-sm-3">
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
                                    <span style="color:red;"><?php echo form_error('campus');?></span>
									</div>
									<div class="col-sm-3">
									<label >Select Vendor:<?=$astrik?></label>
									</div>
									<div class="col-sm-3">
									<select id="vendor" name="vendor"  class="form-control" required>
									<option value="">Select Vendor</option>
									  </select>
									<span style="color:red;"><?php echo form_error('vendor');?></span>
									</div>
									
                                </div>
								<div class="form-group">
								<div class="col-sm-3">
								<label >Enter Driver Name:<?=$astrik?></label>
									</div>
									<div class="col-sm-3">
									<input type="text" id="driver" name="driver"  onblur="check_drivername_license_exists()"  class="form-control alphaonly" placeholder="Driver Name" />                                    
                                   <span style="color:red;"><?php echo form_error('driver');?></span>
									</div>
									
									<div class="col-sm-3">
									<label>Enter Mobile:<?=$astrik?></label>
									
								   </div>
								   <div class="col-sm-3">
									
									<input type="text" id="mobile" name="mobile" placeholder="Mobile" class="form-control"  />                                  
                                   <span style="color:red;"><?php echo form_error('mobile');?></span>
								   </div>
								   
									
								</div>
								<div class="form-group">
								
                                  
								<div class="col-sm-3">
									
									<label>Enter Address:<?=$astrik?></label>
								   </div>
								   <div class="col-sm-3">
									<textarea class="form-control" id="address" name="address" ></textarea>                                    
                                   <span style="color:red;"><?php echo form_error('address');?></span>
									
									</div>
								<div class="col-sm-3">
								<label >Enter Pincode:<?=$astrik?></label>
                                 
                                </div>
								 <div class="col-sm-3">
								<input type="text" id="pincode" name="pincode" placeholder="Pincode" class="form-control"  /><span style="color:red;"><?php echo form_error('pincode');?></span>
                                  
                                </div>
							
								</div>		 
                                
								<div class="form-group">
								<div class="col-sm-3">
								<label >Select Locality: <?=$astrik?></label>
									</div>
									<div class="col-sm-3">
									 <select class="form-control" name="hstate_id" id="hstate_id" required>
                                      <option value="">Select State</option>
                                      <?php //echo "state".$state;exit();
                                        if(!empty($state)){
                                            foreach($state as $stat){
                                                ?>
                                              <option value="<?=$stat['state_id']?>"><?=$stat['state_name']?></option>  
                                            <?php 
                                                
                                            }
                                        }
                                      ?>
                                  </select>
								  <span style="color:red;"><?php echo form_error('hstate_id');?></span>
									</div>
									<div class="col-sm-3">
									<select class="form-control" name="hdistrict_id" id="hdistrict_id" required>
                                      <option value="">Select District</option>
                                  </select>
								  <span style="color:red;"><?php echo form_error('hdistrict_id');?></span>
									</div>
									<div class="col-sm-3">
									<select class="form-control" name="hcity" id="hcity" required>
                                      <option value="">Select City</option>
                                  </select>
								  <span style="color:red;"><?php echo form_error('hcity');?></span>
									</div>
								</div>			
							<div class="form-group">
                                <div class="col-sm-3">
									<label >Enter License No:<?=$astrik?></label>
									</div>
									<div class="col-sm-3">
									<input type="text" id="License" name="License"  onblur="check_drivername_license_exists()" placeholder="License No" class="form-control"  /><span style="color:red;"><?php echo form_error('License');?></span>
									</div>
									 
								
								<div class="col-sm-3">
								<label >Service Agreement Form </br>
								(if any):</label>
                                   
                                </div>
								
									<div class="col-sm-3">
									
									<input type="file"  name="mou_doc" id="mou_doc">
								<span style="color:red;"><?php echo form_error('mou_doc');?></span>
									</div>
								
								
							</div>
							
							<div class="form-group">
								
								<div class="col-sm-3">
								<label >Service Start Date:</label>
								
								</div>
																	
								<div class="col-sm-3">
								
								<input type="text" class="form-control" id="doc-sub-datepicker22" placeholder="Start Date" name="sdate" readonly="true"/>
								<!--<span style="color:red;"><?php echo form_error('sdate');?></span>-->
								</div>
								
								<div class="col-sm-3">
								<label >Service End Date:</label>
								
								</div>
								<div class="col-sm-3">
								<input type="text" class="form-control" id="doc-sub-datepicker23" placeholder="End Date" name="edate"  readonly="true"/>
								<!--<span style="color:red;"><?php echo form_error('edate');?></span>-->
								</div>
								
							</div>
							
							<div class="form-group">
								
								<div class="col-sm-3">
								<label >Batch Number:<?=$astrik?></label>
								
								</div>
																	
								<div class="col-sm-3">
								
								<input type="text" class="form-control" id="batch" placeholder="Batch Number" name="batch" />
								<span style="color:red;"><?php echo form_error('batch');?></span>
								</div>
								
								<div class="col-sm-3">
								<label >Batch Validity:<?=$astrik?></label>
								
								</div>
								<div class="col-sm-3">
								<input type="text" class="form-control" id="doc-sub-datepicker24" placeholder="Batch Validity" name="bvalidity"  readonly="true"/>
								<span style="color:red;"><?php echo form_error('bvalidity');?></span>
								</div>
								
							</div>
							
							<div class="form-group">
							<div class="col-sm-3">
								<label >Driver Photo:</label>
								
								</div>
							<div class="col-sm-3">
							<input type="file"  name="pic" id="pic">
								<span style="color:red;"><?php echo form_error('pic');?></span>
							</div>
							</div>
							<div class="form-group">
								<div class="col-sm-2">
									<button class="btn btn-primary form-control" id="btn_submit" type="submit" >Add</button>                                        
								</div>                                    
								<div class="col-sm-2"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule.'/driver_master')?>'">Cancel</button></div>
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
var status=0;var error_status=0,err_status=0;

function check_drivername_license_exists()
{
	var campus=$('#campus').val();
	var driver=$('#driver').val();
	var license=$('#License').val();
	$.ajax({
			type: 'POST',
			url: '<?= base_url() ?>Transport/check_drivername_exists',
			data: {driver:driver},
			success: function (html) {
				  //alert(html);
				if(html>0)
				{$('#err_msg').html("");
			$('#err_msg1').html("This Driver Name is already there.");status=1;}
			else
				{$('#err_msg1').html("");status=0;}
			}
	});
	$.ajax({
		type: 'POST',
		url: '<?= base_url() ?>Transport/check_driver_license_exists',
		data: {license:license},
		success: function (html) {
			  //alert(html);
			if(html>0)
			{$('#err_msg1').html("");
		$('#err_msg').html("This Driver License No. is already there.");error_status=1;}
		else
			{$('#err_msg').html("");error_status=0;}
		}
	});	
}

function validate_faci_category(events)
{
	if(status==1)
	{ return false; }

	if(error_status==1)
	{ return false; }

if(err_status==1)
	{ return false; }
}


$(document).ready(function(){

	$('#batch').on('change', function () {
		var batch=$(this).val();
		$.ajax({
			type: 'POST',
			url: '<?= base_url() ?>Transport/check_driver_batchno_exists',
			data: {batch:batch},
			success: function (html) {
				  //alert(html);
				if(html>0)
				{$('#err_msg1').html("");$('#err_msg').html("This Driver Batch No. is already there.");err_status=1;}
			else
				{$('#err_msg').html("");err_status=0;}
			}
		});	
	});
	
	$('#doc-sub-datepicker21').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
	$('#doc-sub-datepicker22').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
	$('#doc-sub-datepicker23').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
   $('#doc-sub-datepicker24').datepicker( {format: 'yyyy-mm-dd',autoclose: true}).on('changeDate', function (e) {
		$('#form').bootstrapValidator('revalidateField', 'bvalidity');
		});
   
   
	$('#doc-sub-datepicker22')
   .datepicker({
	   autoclose: true,
	   todayHighlight: true,
	   format: 'yyyy/mm/dd'
   })
   .on('changeDate', function (e) {
	   
	   fdate = $("#doc-sub-datepicker22").val();
		tdate = $("#doc-sub-datepicker23").val();
			
		if ((Date.parse(tdate) < Date.parse(fdate))) 
		{
			error_status=1;$('#err_msg').html("Expiry date should be greater than Start date.");
		}
		else
		{error_status=0;$('#err_msg').html("");}
	   // Revalidate the date field
	   $('#form').bootstrapValidator('revalidateField', 'sdate');
   });
   
   $('#doc-sub-datepicker23')
   .datepicker({
	   autoclose: true,
	   todayHighlight: true,
	   format: 'yyyy/mm/dd'
   })
   .on('changeDate', function (e) {
	   
	   fdate = $("#doc-sub-datepicker22").val();
			tdate = $("#doc-sub-datepicker23").val();
			
			if ((Date.parse(tdate) < Date.parse(fdate))) 
		{
			error_status=1;$('#err_msg').html("Expiry date should be greater than Start date.");
		}
		else
			{error_status=0;$('#err_msg').html("");}
	   // Revalidate the date field
	   $('#form').bootstrapValidator('revalidateField', 'edate');
   });
   
   
    // City by State
	$('#hstate_id').on('change', function () {
		 stateID = $(this).val();
			var state_ID = $("#hstate_id").val();
			$("#state").val($("#hstate_id option:selected").text());
		//alert("called==="+stateID);
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
			$('#hdistrict_id').html('<option value="">Select State First</option>');
		}
	});
	
    // City by State
	$('#hdistrict_id').on('change', function () {
		var district_id = $(this).val();
		var state_ID = $("#hstate_id").val();
		$("#district").val($("#hdistrict_id option:selected").text());
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
					  $('#hcity').html('<option value="">No City Found</option>');  
					}
				}
			});
		} else {
			$('#hcity').html('<option value="">Select District First</option>');
		}
	});

		 $("#hcity").change(function(){
      $("#city").val($("#hcity option:selected").text());
    });
	
	});	

</script>
