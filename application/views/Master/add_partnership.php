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
                       message: 'Please Select Mou Sharing Factor'
                      },
                      required: 
                      {
                       message: 'Please Select Mou Sharing Factor'
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
                        max: 12,
                        min:10,
                        message: 'Mobile number should be 12 digits.'
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
				country:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Country should not be empty'
                      },
                      stringLength: 
                        {
                        max: 20,
                        min: 2,
                        message: 'Country should be 2-20 characters.'
                        }
                    }
                },
				pname:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Parternship name should not be empty'
                      },
                      stringLength: 
                        {
                        max: 50,
                        min: 2,
                        message: 'Parternship name should be 2-50 characters.'
                        }
                    }
                },
				pname_short:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Parternship Short name should not be empty'
                      },
                      stringLength: 
                        {
                        max: 10,
                        min: 2,
                        message: 'Parternship name short should be 2-10 characters.'
                        }
                    }
                },
				cperson:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Contact Person should not be empty'
                      },
                      stringLength: 
                        {
                        max: 50,
                        min: 2,
                        message: 'Contact Person should be 2-50 characters.'
                        }
                    }
                },
				fparty:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Mou sign from university person name should not be empty'
                      },
                      stringLength: 
                        {
                        max: 50,
                        min: 2,
                        message: 'Mou sign from university person name should be 2-50 characters.'
                        }
                    }
                },
				sparty:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                      message: 'Mou sign from university parternship should not be empty'
                      },
                      stringLength: 
                        {
                        max: 50,
                        min: 2,
                       message: 'Mou sign from university parternship should be 2-50 characters.'
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
				hstate_id:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please Select State'
                      },
                      required: 
                      {
                       message: 'Please select state'
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
				sdate:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please Select Mou Start date'
                      },
                      required: 
                      {
                       message: 'Please Select Mou Start date'
                      }
                     
                    }
                },
				edate:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please Select Mou Expiry date'
                      },
                      required: 
                      {
                       message: 'Please Select Mou Expiry date'
                      }
                     
                    }
                },
				r1:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select ratio'
                      },
                      required: 
                      {
                       message: 'Please select ratio'
                      }
                     
                    }
                },
				r2:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select ratio'
                      },
                      required: 
                      {
                       message: 'Please select ratio'
                      }
                     
                    }
                },
			/*	mou_doc: {
					validators: {
						file: {
							extension: 'jpeg,png,doc,docx,pdf,zip,rtf',
							type: 'image/jpeg,image/png/,application/pdf,application/msword,application/rtf,application/zip',
							maxSize: 1024 * 4048,
							message: 'The selected file is not valid'
						},
						notEmpty: {
								message: 'mou file is required.'
						  }
					}
				}*/
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
		
    });

</script>
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <!--<li class="active"><a href="#">Parternship Institue</a></li>-->
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-5 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Add Parternship Institue</h1>
			
			<span id="flash-messages" style="color:Green;padding-left:50px;">
				 <?php if(!empty($this->session->flashdata('message1'))){ echo $this->session->flashdata('message1'); } ?>
			</span>
			<span id="flash-messages" style="color:red;padding-left:50px;">
			 <?php if(!empty($this->session->flashdata('message2'))){ echo $this->session->flashdata('message2'); } ?>
			</span>
        </div>
        
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-heading">
                            <span class="panel-title">Enter Details</span>
							
                    </div>
                    <div class="panel-body">
                        <div class="table-info">                            
                            
                            <form id="form" name="form" action="<?=base_url($currentModule.'/add_partnership_submit')?>" method="POST" onsubmit="return validate_faci_category(event)" enctype="multipart/form-data">   

								<div class="form-group">
								
									<div class="col-sm-2">
									<label >Parternship Code:<?=$astrik?></label>
									<input type="text" id="pcode" onchange="check_partnership_exists()" name="pcode" class="form-control alphanum" placeholder="Parternship Code"  />                                    
                                    <span style="color:red;"><?php echo form_error('pcode');?></span>
									</div>
									
									<div class="col-sm-4">
									<label >Parternship Name:<?=$astrik?></label>
									<input type="text" id="pname" name="pname" onchange="check_partnership_exists()" class="form-control alphaonly" placeholder="Parternship Name" />                                    
                                   <span style="color:red;"><?php echo form_error('pname');?></span>
								   </div>
								   <div class="col-sm-3">
									<label >Parternship Short Name:<?=$astrik?></label>
									<input type="text" id="pname_short" name="pname_short" onchange="check_partnership_exists()" class="form-control alphanum" placeholder="Short Name "  />                                    
                                    <span style="color:red;"><?php echo form_error('pname_short');?></span>
									</div>
									<div class="col-sm-3">
									<label >Contact Person:<?=$astrik?></label>
									<input type="text" id="cperson" name="cperson" placeholder="Contact Person" class="form-control alphaonly"  /><span style="color:red;"><?php echo form_error('cperson');?></span>
									</div>
                                    
                                </div>
								
								<div class="form-group">
                                    
									<div class="col-sm-4">
									<label >Personal Email:<?=$astrik?></label>
									<input type="email" id="pemail" name="pemail" placeholder="Personal Email" class="form-control"  /><span style="color:red;"><?php echo form_error('pemail');?></span>
									</div>
									
									<div class="col-sm-4">
									<label >Office Email:<?=$astrik?></label>
									<input type="email" id="oemail" name="oemail" placeholder="Office Email" class="form-control"  /><span style="color:red;"><?php echo form_error('oemail');?></span>
									</div>
									
									 <div class="col-sm-4">
									<label>Mobile:<?=$astrik?></label>
									<input type="text" id="mobile" name="mobile" placeholder="Mobile" class="form-control"  />                                  
                                   <span style="color:red;"><?php echo form_error('mobile');?></span>
								   </div>
									
								</div>
								<div class="form-group">
                                   
									 <div class="col-sm-4">
									<label>Address:<?=$astrik?></label>
									<textarea class="form-control" id="address" name="address" ></textarea>                                    
                                   <span style="color:red;"><?php echo form_error('address');?></span>
								   </div>
									 
									<div class="col-sm-4">
									<label >Pincode:<?=$astrik?></label>
									<input type="text" id="pincode" name="pincode" placeholder="Pincode" class="form-control"  /><span style="color:red;"><?php echo form_error('pincode');?></span>
									</div>
									
									<div class="col-sm-4">
									<label >Country:<?=$astrik?></label>
									<input type="text" id="country" name="country" placeholder="Country" class="form-control"  /><span style="color:red;"><?php echo form_error('country');?></span>
									</div>
									
								</div>
											
							<div class="form-group">
                                
                                <div class="col-sm-4">
								<label >Select State: <?=$astrik?></label>
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
								 <div class="col-sm-4">
								 <label >Select District: <?=$astrik?></label>
                                  <select class="form-control" name="hdistrict_id" id="hdistrict_id" required>
                                      <option value="">Select District</option>
                                  </select>
								  <span style="color:red;"><?php echo form_error('hdistrict_id');?></span>
                                </div>
								<div class="col-sm-4">
								<label >Select City: <?=$astrik?></label>
                                   <select class="form-control" name="hcity" id="hcity" required>
                                      <option value="">Select City</option>
                                  </select>
								  <span style="color:red;"><?php echo form_error('hcity');?></span>
                                </div>
								
							</div>
							<div class="form-group">
								
									<div class="col-sm-4">
									<label >Mou Sign From University Person:<?=$astrik?></label>
									<input type="text" id="fparty" name="fparty" class="form-control " placeholder="University Person Name"  />                                    
                                    <span style="color:red;"><?php echo form_error('fparty');?></span>
									</div>
									
									<div class="col-sm-4">
									<label >Mou Sign From University Partnership:<?=$astrik?></label>
									<input type="text" id="sparty" name="sparty" class="form-control " placeholder="Partnership Name" />                                    
                                   <span style="color:red;"><?php echo form_error('sparty');?></span>
								   </div>
								   
								   <div class="col-sm-4">
									<label >Mou Placed:<?=$astrik?></label>
									<input type="text" id="place" name="place" class="form-control " placeholder="Mou Placed" />                                    
                                   <span style="color:red;"><?php echo form_error('place');?></span>
								   </div>
								   
									
                                    
                                </div>
								<div class="form-group">
                                    <div class="col-sm-4">
									<label >Mou Signed Date:<?=$astrik?></label>
									<input type="text" class="form-control" id="doc-sub-datepicker21" placeholder="Signed Date" name="fdate" required readonly="true"/>
									<span style="color:red;"><?php echo form_error('fdate');?></span>
									</div>
									
									<div class="col-sm-4">
									<label >Mou Start Date:<?=$astrik?></label>
									<input type="text" class="form-control" id="doc-sub-datepicker22" placeholder="Start Date" name="sdate" required readonly="true"/>
									<span style="color:red;"><?php echo form_error('sdate');?></span>
									</div>
									
									<div class="col-sm-4">
									<label >Mou Expiry Date:<?=$astrik?></label>
									<input type="text" class="form-control" id="doc-sub-datepicker23" placeholder="Expiry Date" name="edate" required readonly="true"/>
									<span style="color:red;"><?php echo form_error('edate');?></span>
									</div>
									
                                </div>
								<div class="form-group" >
                                    
                                    <div class="col-sm-4" >
									<label >Mou Sharing Ratio:<?=$astrik?></label>
									<div class="row">
										<div class="col-sm-12">
											<div class="col-sm-5">
											<select id="r1" name="r1" onclick="check_ration()" class="form-control select" required>
											</select>
											</div>
											<div class="col-sm-2"><b>:</b></div>
											<div class="col-sm-5">
											<select id="r2" name="r2" onclick="check_ration()" class="form-control select" required>
											</select> 
											</div>
										</div>
									</div>
									<span style="color:red;"><?php echo form_error('r1');?></span>
									<span style="color:red;"><?php echo form_error('r2');?></span>
									</div>
									
									<div class="col-sm-4">
									<label >Mou Sharing Factor:<?=$astrik?></label>
									<select id="factor" name="factor"  class="form-control" required>
											  <option value="">Select Sharing Factor</option>
											  <option value="tution">On Tution Fee</option>
											  <option value="academic">On Full Fee</option>
                                    </select>                                    
                                    <span style="color:red;"><?php echo form_error('factor');?></span>
									</div>
									<div class="col-sm-4">
									<label >Mou File:<?php //$astrik?></label>
									<input type="file"  name="mou_doc" id="mou_doc">
									<span style="color:red;"><?php //echo form_error('mou_doc');?></span>
									</div>
                                </div>          
																
                                <div class="form-group">
                                    <!--<div class="col-sm-3"></div>-->
                                    <div class="col-sm-2">
                                        <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Add</button>                                        
                                    </div>                                    
                                    <div class="col-sm-2"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule.'/partnership')?>'">Cancel</button></div>
                                    <div class="col-sm-8">																		<span style="color:red;padding-left:0px;" id="err_msg"></span></div>
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
var status=0;var error_status=0;

function check_ration()
{
	var r1=$('#r1').val();
	var r2=$('#r2').val();
	if(r1>r2)
	{
		{$('#err_msg').html("ration 1.");error_status=1;}
	}
	else
		{$('#err_msg').html("");error_status=0;}
}

function check_partnership_exists()
{
	var pcode=$('#pcode').val();
	var pname=$('#pname').val();
	var pname_short=$('#pname_short').val();
	/* if(pcode=="")
	{
		$('#err_msg').html('Please Enter Parternship Code');
	}
	else if(pname=="")
	{
		$('#err_msg').html('Please Enter Parternship Name');
	}
	else
	{ */
		$('#err_msg').html('');
		$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Master/check_partnership_exists',
				data: {pcode:pcode,pname:pname,pname_short:pname_short},
				success: function (html) {
					  //alert(html);
					if(html>0)
					{$('#err_msg').html("This Parternship Code/Name are already there.");status=1;}
				else
					{$('#err_msg').html("");status=0;}
				}
			});
	//}
}

function validate_faci_category(events)
{
	if(status==1)
	{ return false; }

	if(error_status==1)
	{ return false; }
}

$(function(){
    var $select = $(".select").html('');
    for (i=1;i<=100;i++){
        $select.append($('<option></option>').val(i).html(i))
    }
});

$(document).ready(function(){

	$('#doc-sub-datepicker21').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
	$('#doc-sub-datepicker22').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
	$('#doc-sub-datepicker23').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
   
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
			error_status=0;
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
			error_status=0;
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
			$('#hdistrict_id').html('<option value="">Select state first</option>');
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
					  $('#hcity').html('<option value="">No city found</option>');  
					}
				}
			});
		} else {
			$('#hcity').html('<option value="">Select district first</option>');
		}
	});

		 $("#hcity").change(function(){
      $("#city").val($("#hcity option:selected").text());
    });
	
	});	

</script>
