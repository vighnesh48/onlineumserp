<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<script>    
var duration="<?=$stream_details['course_duration']?>";
var pattern="<?=$stream_details['course_pattern']?>";
var qua="<?=$stream_details['min_que']?>";
var partnership="<?=$stream_details['is_partnership']?>";  
var partner="<?=$stream_details['partnership_id']?>";
var id='<?=$stream_details['stream_id']?>';
var school_id_code='<?=$school_id_code?>';
var isactive='<?=$stream_details['is_active']?>';
var activeforyear='<?=$stream_details['active_for_year']?>';
var islateral='<?=$stream_details['is_lateral']?>';


    $(document).ready(function()
    {
        
        $('#isactive option').each(function()
		 {              
			if($(this).val()== isactive)
			{
				$(this).attr('selected','selected');
			}
		});
                $('#activeforyear option').each(function()
		 {              
			if($(this).val()== activeforyear)
			{
				$(this).attr('selected','selected');
			}
		});
                $('#islateral option').each(function()
		 {              
			if($(this).val()== islateral)
			{
				$(this).attr('selected','selected');
			}
		});
		$('#school option').each(function()
		 {              
			if($(this).val()== school_id_code)
			{
				$(this).attr('selected','selected');
			}
		});
		$('#duration option').each(function()
		 {              
			if($(this).val()== duration)
			{
				$(this).attr('selected','selected');
			}
		});
		$('#pattern option').each(function()
		{              
			if($(this).val()== pattern)
			{
				$(this).attr('selected','selected');
			}
		});
		
		$('#qua option').each(function()
		 {              
			if($(this).val()== qua)
			{
				$(this).attr('selected','selected');
			}
		});
		
		$('#partnership option').each(function()
		 {              
			if($(this).val()== partnership)
			{
				$(this).attr('selected','selected');
			}
		});
		
		if(partnership=='Y')
			$('#p_yes').show();
		else
			$('#p_yes').hide();
		
		$('#partner option').each(function()
		 {              
			if($(this).val()== partner)
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
                
				ccode:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please Enter Stream Code'
                      },
                      required: 
                      {
                       message: 'Please Enter Stream Code'
                      }
                     
                    }
                },
				sno:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please Enter Stream No.'
                      },
                      required: 
                      {
                       message: 'Please Enter Stream No.'
                      }
                     
                    }
                },
				duration:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select course duration'
                      },
                      required: 
                      {
                       message: 'Please select course duration'
                      }
                     
                    }
                },
              is_active:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select Is Active'
                      },
                      required: 
                      {
                       message: 'Please select Is Active'
                      }
                     
                    }
                },
                 active_for_year:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select Active For Year'
                      },
                      required: 
                      {
                       message: 'Please select Active For Year'
                      }
                     
                    }
                },
                is_lateral:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select Is Lateral'
                      },
                      required: 
                      {
                       message: 'Please select Is Lateral'
                      }
                     
                    }
                },
				pattern:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select pattern '
                      },
                      required: 
                      {
                       message: 'Please select pattern '
                      }
                     
                    }
                },
				qua:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select min. qualification '
                      },
                      required: 
                      {
                       message: 'Please select min. qualification '
                      }
                     
                    }
                },
				cname:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Stream name should not be empty'
                      },
                      stringLength: 
                        {
                        max: 100,
                        min: 2,
                        message: 'Stream name should be 2-50 characters.'
                        }
                    }
                },
				ssname:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Stream short name should not be empty'
                      },
                      stringLength: 
                        {
                        max: 100,
                        min: 2,
                        message: 'Stream short name should be 2-50 characters.'
                        }
                    }
                },/*specialization: {validators:{notEmpty:{message: 'Specialization should not be empty'},
				stringLength:{max: 100,min: 2,message: 'Specialization should be 2-50 characters.'}}},*/
				syear:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select Start Year'
                      },
                      required: 
                      {
                       message: 'Please select Start Year'
                      }
                     
                    }
                },
				category:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select course category'
                      },
                      required: 
                      {
                       message: 'Please select course category'
                      }
                     
                    }
                },
				course:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select course '
                      },
                      required: 
                      {
                       message: 'Please select course '
                      }
                     
                    }
                },
				partnership:
				{
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select partnership '
                      },
                      required: 
                      {
                       message: 'Please select partnership '
                      }
                     
                    }
                }
            }       
        })
		
		
		$('.alphaonly').bind('keyup blur',function(){ 
			var node = $(this);
			node.val(node.val().replace(/[^a-zA-Z. ]/g,'') ); }
		);
		
		$('.alpha').bind('keyup blur',function(){ 
			var node = $(this);
			node.val(node.val().replace(/[^A-Z]/g,'') ); }
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
        <!--<li class="active"><a href="#">stream</a></li>-->
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-5 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Update Stream </h1>
			<span style="color:red;padding-left:0px;" id="err_msg"></span>
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
                            <span class="panel-title">Update Details</span>
                    </div>
                    <div class="panel-body">
                        <div class="table-info">                            
                            
                            <form id="form" name="form" action="<?=base_url($currentModule.'/edit_stream_submit')?>" method="POST" onsubmit="return validate_faci_category(event)">   
								<input type="hidden" name="id" id="id" value="<?=$stream_details['stream_id']?>"/>
								
								<input type="hidden" id="sno" name="sno" value="<?=$stream_details['stream_no']?>" placeholder="Stream Number" class="form-control numbersOnly" />
								<input type="hidden" id="pcode" name="pcode" value="<?=$stream_details['programme_code']?>" class="form-control" placeholder="Program Code" readonly /> 
								
								<div class="form-group">
                                     
									 
									<label class="col-sm-3">School Name:<?=$astrik?></label>
									<div class="col-sm-3">
									<select id="school" name="school" onchange="generate_prg_code(),check_strm_exists()" class="form-control" required>
											  <option value="">select school</option>
											  <?php 
													if(!empty($school_details)){
														foreach($school_details as $coursename){
														
															if($school_stream_details['school_id']==$coursename['school_id'])
															{
															?>
														  <option selected value="<?=$coursename['school_id'].'||'.$coursename['school_code']?>"><?=$coursename['school_name']?></option>  
														<?php 
														}
														else{
															
															?>
															 <option  value="<?=$coursename['school_id'].'||'.$coursename['school_code']?>"><?=$coursename['school_name']?></option>
															
															<?php
															}
														}
													}
												  ?>
                                        </select>                                    
                                    <span style="color:red;"><?php echo form_error('school');?></span>
									</div>
									
									
									<label class="col-sm-3">Course:<?=$astrik?></label>
									<div class="col-sm-3">
									<select id="course" name="course" onchange="check_strm_exists()" class="form-control" required>
											  <option value="">select Course</option>
											  <?php 
													if(!empty($course_details)){
														foreach($course_details as $coursename){
															if($stream_details['course_id']==$coursename['course_id'])
															{
															?>
														  <option selected value="<?=$coursename['course_id']?>"><?=$coursename['course_name']?></option>  
														<?php 
														}
														else{
															
															?>
															<option value="<?=$coursename['course_id']?>"><?=$coursename['course_short_name']?></option> 
															
															<?php
															}
														}
													}
												  ?>
                                        </select>                                    
                                    <span style="color:red;"><?php echo form_error('course');?></span>
									</div>
									</div>
									<div class="form-group">
									<label class="col-sm-3">Course Category:<?=$astrik?></label>
									<div class="col-sm-3">
									<select id="category" name="category" onchange="check_strm_exists()" class="form-control" required>
											  <option value="">Select Course Category</option>
											   <?php 
													if(!empty($course_category_details)){
														foreach($course_category_details as $coursename){
															/* ?>
														  <option value="<?=$coursename['cr_cat_id']?>"><?=$coursename['course_category']?></option>  
														<?php  */
															if($stream_details['course_cat']==$coursename['cr_cat_id'])
															{
															?>
														  <option selected value="<?=$coursename['cr_cat_id']?>"><?=$coursename['course_category']?></option>  
														<?php 
														}
														else{
															
															?>
															<option value="<?=$coursename['cr_cat_id']?>"><?=$coursename['course_category']?></option> 
															
															<?php
															}
														}
													}
												  ?>
                                        </select>                                    
                                    <span style="color:red;"><?php echo form_error('category');?></span>
									</div>
									
									<label class="col-sm-3">Stream Name:<?=$astrik?></label>
									<div class="col-sm-3">
									<input type="text" id="cname" name="cname" onchange="check_strm_exists()" placeholder="Stream Name " value="<?=$stream_details['stream_name']?>" class="form-control alphaonly"  /><span style="color:red;"><?php echo form_error('cname');?></span>
									</div>
                                    
                                </div>

								<div class="form-group">
								
									
									
									<label class="col-sm-3">Stream Short Name:<?=$astrik?></label>
									<div class="col-sm-3">
									<input type="text" id="ssname" name="ssname" onchange="check_strm_exists()" class="form-control alphaonly"  value="<?=$stream_details['stream_short_name']?>" placeholder="Stream Short Name" />                                    
                                   <span style="color:red;"><?php echo form_error('ssname');?></span>
								   </div>
								   
									
									<label class="col-sm-3">Stream Code:<?=$astrik?></label>
									<div class="col-sm-3">
									<input type="text" id="ccode" onchange="check_strm_exists()" name="ccode" class="form-control alpha" placeholder="Stream Code"  value="<?=$stream_details['stream_code']?>"  />                                    
                                    <span style="color:red;"><?php echo form_error('ccode');?></span>
									</div>
								</div>
								<div class="form-group">																	
										<label class="col-sm-3">Gradesheet Name:</label>	
										<div class="col-sm-3">										
										<input type="text" id="gradesheet_name" name="gradesheet_name" class="form-control" placeholder="Gradesheet Name" value="<?=$stream_details['gradesheet_name']?>"  />
										<span style="color:red;"><?php echo form_error('gradesheet_name');?></span>
										</div>
										<label class="col-sm-3">Specialization:</label>	
										<div class="col-sm-3">
										<input type="text" id="specialization" name="specialization" class="form-control" placeholder="Specialization"  value="<?=$stream_details['specialization']?>"/>
										<span style="color:red;"><?php echo form_error('specialization');?></span>
									</div>		
                                </div>
								<div class="form-group">
																	
									<label class="col-sm-3">Degree Name:</label>
									<div class="col-sm-3">										
									<input type="text" id="Degree_name" name="Degree_name" class="form-control" placeholder="Degree name" value="<?=$stream_details['degree_specialization']?>"  />
									<span style="color:red;"><?php // echo form_error('Degree_name');?></span>
									</div>								
																	
									<label class="col-sm-3">Marathi Name:</label>	
									<div class="col-sm-3">	
									<input type="text" id="stream_name_marathi" name="stream_name_marathi" class="form-control" placeholder="Program Marathi Name" value="<?=$stream_details['stream_name_marathi']?>"  />
									
									<span style="color:red;"><?php //echo form_error('specialization');?></span>
									</div>
									
									
                                </div>
								<div class="form-group">
                                    
										
									<label class="col-sm-3">Start Year:<?=$astrik?></label>
									<div class="col-sm-3">
									<select id="syear" name="syear" onchange="check_strm_exists()" class="form-control" >
                                            <option value="">Select Start Year</option>
                                            <?php 
										 $yyyy=date('Y');
										 $yy=date('y')+1;
										   for($i=1;$i<=4;$i++)
										   {
											   if($yyyy==$stream_details['start_year'])
												   echo '<option selected value="'.$yyyy.'">'.$yyyy.'-'.$yy.'</option>';
											   else 
												   echo '<option value="'.$yyyy.'">'.$yyyy.'-'.$yy.'</option>';
											   
											   $yyyy--;$yy--;
										   }
										   ?>
                                      
                                        </select>                                     
                                   <span style="color:red;"><?php echo form_error('syear');?></span>
								   </div>
								   
								   
									<label class="col-sm-3">Course Pattern:<?=$astrik?></label>
									<div class="col-sm-3">
									<select id="pattern" name="pattern" onchange="c_pattern()" class="form-control" required>
											  <option value="">Select Course Pattern</option>
											  <option value="SEMESTER">Semester</option>
											  <option value="YEAR">Year</option>
                                        </select>                                    
                                    <span style="color:red;"><?php echo form_error('pattern');?></span>
									</div>
								</div>
								<div class="form-group">
								
									<label class="col-sm-3">Course Duration:<?=$astrik?></label>
									<div class="col-sm-3">
									<select id="duration" name="duration" class="form-control select" required>
											  <option value="">Select Course Duration</option>
											  
                                        </select>                                   
                                   <span style="color:red;"><?php echo form_error('duration');?></span>
								   </div>
									
									<label class="col-sm-3">Is Partnership:<?=$astrik?></label>
									<div class="col-sm-3">
									<select id="partnership" name="partnership" onchange="is_partnership()"  class="form-control" required>
											  <option value="">Select Is Parternship</option>
											  <option value="Y">Yes</option>
											  <option value="N">No</option>
                                    </select>                                    
                                    <span style="color:red;"><?php echo form_error('partnership');?></span>
									</div>											
								</div>
                                                                
                                                                <div class="form-group">
								
									<label class="col-sm-3">Active For Year:<?=$astrik?></label>
									<div class="col-sm-3">
                                                                            <?php $yyyy=date('Y');
										 $yy=date('Y')-1; ?>
									   <select id="activeforyear" name="active_for_year" class="form-control " required>
                                                                           <option value="0">Select Active Year</option>
                                                                           <option value="<?=$yyyy?>"><?=$yyyy?></option>
                                                                           <option value="<?=$yy?>"><?=$yy?></option>	  
                                                                           </select>         
                                   <span style="color:red;"><?php echo form_error('activeforyear');?></span>
								   </div>
									
									<label class="col-sm-3">Is Active:<?=$astrik?></label>
									<div class="col-sm-3">
									<select id="isactive" name="is_active"   class="form-control" required>
											  <option value="">Select Is Active</option>
											  <option value="Y">Yes</option>
											  <option value="N">No</option>
                                    </select>                                    
                                    <span style="color:red;"><?php echo form_error('isactive');?></span>
									</div>											
								</div>
                                                                <div class="form-group">
								
									<label class="col-sm-3">Is Lateral:<?=$astrik?></label>
									<div class="col-sm-3">
									<select id="islateral" name="is_lateral" class="form-control " required>
											  <option value="">Select Is Lateral</option>
                                                                                         <option value="Y">Yes</option>
											  <option value="N">No</option>
											  
                                        </select>                                   
                                   <span style="color:red;"><?php echo form_error('islateral');?></span>
								   </div>
								   
									<label class="col-sm-3">Course Type:<?=$astrik?></label>
									<div class="col-sm-3">
									<select id="course_type" name="course_type" class="form-control " required="required">
											  <option value="">Select Course Type</option>
                                              <option value="UG" <?php if($stream_details['course_type']=='UG'){ echo 'selected';}?>>UG</option>
											  <option value="PG" <?php if($stream_details['course_type']=='PG'){ echo 'selected';}?>>PG</option>
											  <option value="PHD" <?php if($stream_details['course_type']=='PHD'){ echo 'selected';}?>>PHD</option>
											  <option value="DIPLOMA" <?php if($stream_details['course_type']=='DIPLOMA'){ echo 'selected';}?>>DIPLOMA</option>
											  <option value="CERTIFICATE" <?php if($stream_details['course_type']=='CERTIFICATE'){ echo 'selected';}?>>CERTIFICATE</option>											  
                                        </select>                                   
                                   <span style="color:red;"><?php echo form_error('errcourse_type');?></span>
								   </div>
									
									</div>											
								
														
								<!--<div class="form-group">
								
                                    
								   <div class="col-sm-4">
									<label >Min. Qualification:<?=$astrik?></label>
									<select id="qua" name="qua" class="form-control" required>
											  <option value="">Select Min. Qualification</option>
											  
											  <option value="1">1</option>
											  <option value="2">2</option>
											  <option value="3">3</option>
											  <option value="4">4</option>
											  
                                        </select>
									<span style="color:red;"><?php echo form_error('qua');?></span>
									</div>
									
                                </div>-->
								<div class="form-group">
   
                                    <div class="col-sm-12"  id="p_yes" style="display:none;">
									<label class="col-sm-3">Partnership:<?=$astrik?></label>
									<div class="col-sm-3">
									<select id="partner" name="partner" class="form-control" required>
											  <option value="">select partnership</option>
											  <?php 
													if(!empty($partnership_details)){
														foreach($partnership_details as $coursename){
															/* ?>
														  <option value="<?=$coursename['partnership_code']?>" ><?=$coursename['partnership_code']?></option>  
														<?php  */
															if($stream_details['partnership_id']==$coursename['partner_id'])
															{
															?>
														  <option selected value="<?=$coursename['partner_id']?>"><?=$coursename['partnership_code']?></option>  
														<?php 
														}
														else{
															
															?>
															<option value="<?=$coursename['partner_id']?>"><?=$coursename['partnership_code']?></option> 
															
															<?php
															}
														}
													}
											  ?>
                                    </select> 
									<span style="color:red;"><?php echo form_error('partner');?></span>
									</div>
									</div>
                                </div>          
																
                                <div class="form-group">
                                    <!--<div class="col-sm-3"></div>-->
									<?php if($this->session->userdata('role_id')==15 || $this->session->userdata('role_id')==2){?>
                                    <div class="col-sm-2">
                                        <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Update</button>                                        
                                    </div>    
									<?php }?>									
                                    <div class="col-sm-2"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule.'/stream_master')?>'">Cancel</button></div>
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
function check_strm_exists()
{
	var syear=$('#syear').val();
	var course=$('#course').val();
	var ccode=$('#ccode').val();
	var category=$('#category').val();
	var cname=$('#cname').val();
	var ssname=$('#ssname').val();
	
    if(course=="")
	{
		$('#err_msg').html('Please Select course');
	}
	else if(category=="")
	{
		$('#err_msg').html('Please Select Stream Type');
	}
	else if(cname=="")
	{
		$('#err_msg').html('Please Enter Stream Name');
	}
	else if(ssname=="")
	{
		$('#err_msg').html('Please Enter Stream Short Name');
	}
	else if(ccode=="")
	{
		$('#err_msg').html('Please Enter Stream Code');
	}
	else if(syear=="")
	{
		$('#err_msg').html('Please select start year');
	}
	else
	{
		$('#err_msg').html('');
		$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Master/check_stream_exists',
				data: {syear:syear,ccode:ccode,category:category,cname:cname,ssname:ssname,course:course,id:id},
				success: function (html) {
					//alert(html);
					if(html>0)
					{$('#err_msg').html("This Stream Details are already there.");status=1;}
				else
					{$('#err_msg').html("");status=0;}
				}
			});
	}
}

function validate_faci_category(events)
{
  
	if(status==1)
	{ return false; }
        
}

function is_partnership()
{
	if(($('#partnership').val())!='' && ($('#partnership').val())=='Y')
		$('#p_yes').show();
	else
		$('#p_yes').hide();
}

function c_pattern()
{
	if(($('#pattern').val())!='' && ($('#pattern').val())=='Year')
	{
		var $select = $(".select").html('<option value="">Select Course Duration</option>');
		for (i=1;i<=5;i++){
			$select.append($('<option></option>').val(i).html(i))
		}	
	}
	else{
		var $select = $(".select").html('<option value="">Select Course Duration</option>');
		for (i=1;i<=10;i++){
			$select.append($('<option></option>').val(i).html(i))
		}	
	}
}

$(function(){
    var $select = $(".select").html('<option value="">Select Course Duration</option>');
    for (i=1;i<=10;i++){
		if(duration==i)
			$select.append($('<option selected></option>').val(i).html(i))
		else
			$select.append($('<option></option>').val(i).html(i));
    }
});


function generate_prg_code()
{
	var school=($('#school').val()).split('||');
	var school_last_2_code=school[1].slice(-2);
	type='POST',url='<?= base_url() ?>Master/get_stream_no',datastring={sid:school[1]};
	html_content=ajaxcall(type,url,datastring);
	//alert(html_content);
	$('#sno').val(html_content);
	//var streamno=$('#sno').val();
	$('#pcode').val(school_last_2_code+(html_content));
}

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
</script>
