<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<!--<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>-->
<script>    
    $(document).ready(function()
    {
        
		
		/*$('.alphaonly').bind('keyup blur',function(){ 
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
		});*/
		
    });

</script>
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
       <!-- <li class="active"><a href="#">stream</a></li>-->
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-5 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Add Stream </h1>
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
                            <span class="panel-title">Enter Details</span>
							<span style="color:red;padding-left:40px;" id="err_msg"></span>
                    </div>
                    <div class="panel-body">
                        <div class="table-info">                            
                            
                            <form id="form" name="form" action="<?=base_url($currentModule.'/add_stream_submit')?>" method="POST">   
								<input type="hidden" id="sno" name="sno" value="<?php echo $last_stream_no;?>" placeholder="Stream Number" class="form-control numbersOnly" />
								<input type="hidden" id="pcode" name="pcode" class="form-control" placeholder="Program Code" readonly /> 
								<div class="form-group">
                                    
									<label class="col-sm-3">School Name:<?=$astrik?></label>
									<div class="col-sm-3">
									<select id="school" name="school" onchange="generate_prg_code()" class="form-control" required="required" >
											  <option value="">select school</option>
											  <?php 
													if(!empty($school_details)){
														foreach($school_details as $coursename){
															?>
														  <option value="<?=$coursename['school_id'].'||'.$coursename['school_code']?>"><?=$coursename['school_name']?></option>  
														<?php 
															
														}
													}
											  ?>
                                    </select>                                    
                                    <span style="color:red;"><?php echo form_error('school');?></span>
									</div>
									
									
									<label class="col-sm-3">Course:<?=$astrik?></label>
									<div class="col-sm-3">
									<select id="course" name="course"  class="form-control" required="required" >
											  <option value="">select Course</option>
											  <?php 
													if(!empty($course_details)){
														foreach($course_details as $coursename){
															?>
														  <option value="<?=$coursename['course_id']?>"><?=$coursename['course_name']?></option>  
														<?php 
															
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
									<select id="category" name="category" class="form-control" required="required" >
											  <option value="">Select Course Category</option>
											   <?php 
													if(!empty($course_category_details)){
														foreach($course_category_details as $coursename){
															?>
														  <option value="<?=$coursename['cr_cat_id']?>"><?=$coursename['course_category']?></option>  
														<?php 
															
														}
													}
												  ?>
                                        </select>                                    
                                    <span style="color:red;"><?php echo form_error('category');?></span>
									</div>
									
									<label class="col-sm-3"> Stream Name:<?=$astrik?></label>
									<div class="col-sm-3">
			<input type="text" id="cname" name="cname"  placeholder="Stream Name " class="form-control alphaonly" required="required"/><span style="color:red;"><?php echo form_error('cname');?></span>
									</div>
									
                                </div>

								<div class="form-group">
									
									<label class="col-sm-3"> Stream Short Name:<?=$astrik?></label>
									<div class="col-sm-3">
									<input type="text" id="ssname" name="ssname"  class="form-control alphaonly" placeholder="Stream Short Name"  required="required"/>                                    
                                   <span style="color:red;"><?php echo form_error('ssname');?></span>
								   </div>
								   
									
									<label class="col-sm-3"> Stream Code:<?=$astrik?></label>
									<div class="col-sm-3">
									<input type="text" id="ccode"  name="ccode" class="form-control alpha" placeholder="Stream Code" required="required" />                                    
                                    <span style="color:red;"><?php echo form_error('ccode');?></span>
									
									</div>		
								</div>	
								<div class="form-group">
																	
									<label class="col-sm-3">Gradesheet Name:</label>
									<div class="col-sm-3">										
									<input type="text" id="gradesheet_name" name="gradesheet_name" class="form-control" placeholder="Gradesheet Name" required="required" />
									<span style="color:red;"><?php echo form_error('gradesheet_name');?></span>
									</div>								
																	
									<label class="col-sm-3">Specialization:</label>	
									<div class="col-sm-3">										
									<input type="text" id="specialization" name="specialization" class="form-control" placeholder="Specialization" required="required" />
									<span style="color:red;"><?php echo form_error('specialization');?></span>
									</div>
									
									
                                </div>
                                
                                <div class="form-group">
																	
									<label class="col-sm-3">Degree Name:</label>
									<div class="col-sm-3">										
									<input type="text" id="Degree_name" name="Degree_name" class="form-control" placeholder="Degree name" required="required" />
									<span style="color:red;"><?php //echo form_error('Degree_name');?></span>
									</div>								
																	
									<label class="col-sm-3"></label>	
									<div class="col-sm-3">										
									
									<span style="color:red;"><?php //echo form_error('specialization');?></span>
									</div>
									
									
                                </div>
								
								<div class="form-group">
									<label class="col-sm-3">Start Year:<?=$astrik?></label>
									<div class="col-sm-3">
									<select id="syear" name="syear" onchange="check_strm_exists()" class="form-control" required="required">
                                        <option value="">Select Start Year</option>
                                        <?php 
										$yyyy=date('Y');
										$yy=date('y')+1;
										   for($i=1;$i<=4;$i++)
										   {
											   /* if($yyyy==2017)
												   echo '<option selected value="'.$yyyy.'-'.$yy.'">'.$yyyy.'-'.$yy.'</option>';
											   else */
												   echo '<option value="'.$yyyy.'">'.$yyyy.'-'.$yy.'</option>';
											   
											   $yyyy--;$yy--;
										   }
										?>
                                      <option value="2024">2024-25</option>
                                        </select>                                     
                                   <span style="color:red;"><?php echo form_error('syear');?></span>
								   </div>
								   
								    
									<label class="col-sm-3">Course Pattern:<?=$astrik?></label>
									<div class="col-sm-3">
									<select id="pattern" name="pattern" onchange="c_pattern()" class="form-control" required="required">
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
									<select id="duration" name="duration" class="form-control select" >
											  <option value="">Select Course Duration</option>
											  
                                        </select>                                   
                                   <span style="color:red;"><?php echo form_error('duration');?></span>
								   </div>
									
									<label class="col-sm-3">Is Partnership:<?=$astrik?></label>
									<div class="col-sm-3">
									<select id="partnership" name="partnership" onchange="is_partnership()"  class="form-control" required="required">
											  <option value="">Select Is Parternship</option>
											  <option value="Y">Yes</option>
											  <option value="N">No</option>
                                    </select>                                    
                                    <span style="color:red;"><?php echo form_error('partnership');?></span>
									</div>
								 </div>
														
								
								<div class="form-group" >
                                    
                                    <div class="col-sm-12" id="p_yes" style="display:none;">
									<label class="col-sm-3">Partnership:<?=$astrik?></label>
									<div class="col-sm-3">
									<select id="partner" name="partner" class="form-control" >
											  <option value="">select partnership</option>
											  <?php 
													if(!empty($partnership_details)){
														foreach($partnership_details as $coursename){
															?>
														  <option value="<?=$coursename['partner_id']?>" ><?=$coursename['partnership_code']?></option>  
														<?php 
															
														}
													}
											  ?>
                                    </select> 
									<span style="color:red;"><?php echo form_error('partner');?></span>
									</div>
									</div>
									
                                </div>          
						<div class="form-group">
								
									<label class="col-sm-3">Active For Year:<?=$astrik?></label>
									<div class="col-sm-3">
                                                                            <?php $yyyy=date('Y');
										 $yy=date('Y')-1;
$yyy=date('Y')+1;										 ?>
									   <select id="active_for_year" name="active_for_year" class="form-control " >
                                                                           <option value="0">Select Active Year</option>
																		   <option value="<?=$yyy?>"><?=$yyy?></option>	  
                                                                           <option selected value="<?=$yyyy?>"><?=$yyyy?></option>
                                                                           <option value="<?=$yy?>"><?=$yy?></option>	  
                                                                           
                                                                           </select>         
                                   <span style="color:red;"><?php echo form_error('activeforyear');?></span>
								   </div>
									
									<label class="col-sm-3">Is Active:<?=$astrik?></label>
									<div class="col-sm-3">
									<select id="is_active" name="is_active"   class="form-control" required="required">
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
									<select id="is_lateral" name="is_lateral" class="form-control " required="required">
											  <option value="">Select Is Lateral</option>
                                                                                         <option value="Y">Yes</option>
											  <option value="N">No</option>
											  
                                        </select>                                   
                                   
								   </div>
									<label class="col-sm-3">Course Type:<?=$astrik?></label>
									<div class="col-sm-3">
									<select id="course_type" name="course_type" class="form-control " required="required">
											  <option value="">Select Course Type</option>
                                              <option value="UG">UG</option>
											  <option value="PG">PG</option>
											  <option value="PHD">PHD</option>
											  <option value="DIPLOMA">DIPLOMA</option>
											  <option value="CERTIFICATE">CERTIFICATE</option>											  
                                        </select>                                   
                                   <span style="color:red;"><?php echo form_error('errcourse_type');?></span>
								   </div>
									
									</div>											
								</div>										
                                <div class="form-group">
                                    <!--<div class="col-sm-3"></div>-->
									<?php if($this->session->userdata('role_id')==15 || $this->session->userdata('role_id')==2){?>
                                    <div class="col-sm-2">
                                        <!--<button class="btn btn-primary form-control" id="btn_submit" type="submit" >Add</button> --> 
                                      <input type="submit" name="btn_submit" id="btn_submit" class="btn btn-primary form-control" value="Add" />                                    
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
var html_content="",type="",url="",datastring="";
var status=0;
function check_strm_exists()
{
	var syear=$('#syear').val();
	var course=$('#course').val();
	var ccode=$('#ccode').val();
	var category=$('#category').val();
	var cname=$('#cname').val();
	var ssname=$('#ssname').val();
    var isactive=$('#is_active').val();
    var islateral=$('#is_lateral').val();
    var activeforyear=$('#active_for_year').val();
	var course_type=$('#course_type').val();
	
        
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
	else if(course_type=="")
	{
		$('#err_msg').html('Please select course type');
	}
	else
	{
		$('#err_msg').html('');
		$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Master/check_stream_exists',
				data: {syear:syear,ccode:ccode,category:category,cname:cname,ssname:ssname,course:course},
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

function validate_faci_category()
{
	/*alert(status);
	if(status==1)
	{ return false; }else{ return true;}*/
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
        $select.append($('<option></option>').val(i).html(i))
    }
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
</script>
