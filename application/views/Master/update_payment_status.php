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
            <h1 class="col-xs-12 col-sm-5 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Update Payment Status</h1>
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
                            <span class="panel-title">Payment Details</span>
							<span style="color:red;padding-left:40px;" id="err_msg"></span>
                    </div>
                    <div class="panel-body">
                        <div class="table-info">                            
                            
                            <form id="form" name="form" action="<?=base_url($currentModule.'/update_payment_status_data')?>" method="POST">   
								
									<div class="form-group">
									
									<label class="col-sm-3">Payment Type:<?=$astrik?></label>
									<div class="col-sm-3">
									<select id="payment_type" name="payment_type" class="form-control" required="required" >
											  <option value="">Select Payment Type</option>
											  <option value="H">Hostel Payment</option>
											  <option value="R">Regular Payment</option>
											  <option value="H">Uniform Payment</option>
                                        </select>                                    
                                  
									</div>
									
									
                                </div>

								<div class="form-group">
									
									<label class="col-sm-3"> Transaction ID :<?=$astrik?></label>
									<div class="col-sm-3">
									<input type="text" id="txtid" name="txtid"  class="form-control alphaonly"  required="required"/>                                    
								   </div>
								   
										
								</div>	
								<div class="form-group">
																	
									<label class="col-sm-3">Bank Refference No.:<?=$astrik?> </label>
									<div class="col-sm-3">										
									<input type="text" id="ref_no" name="ref_no" class="form-control"  required="required" />
									</div>								
																	
                                </div>
								
								<div class="form-group">
																	
									<label class="col-sm-3">Recepit No.</label>
									<div class="col-sm-3">										
									<input type="text" id="recepit_no" name="recepit_no" class="form-control" placeholder="Gradesheet Name"  />
									</div>								
																	
                                </div>
						                         											
								</div>										
                                <div class="form-group">
                                    <!--<div class="col-sm-3"></div>-->
                                    <div class="col-sm-2">
                                        <!--<button class="btn btn-primary form-control" id="btn_submit" type="submit" >Add</button> --> 
                                      <input type="submit" name="btn_submit" id="btn_submit" class="btn btn-primary form-control" value="Add" />                                    
                                    </div>                                    
                             
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
