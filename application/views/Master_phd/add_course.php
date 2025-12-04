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
                
				cname:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please Enter Course Name'
                      },
                      required: 
                      {
                       message: 'Please Enter Course Name'
                      }
                     
                    }
                },
               csname:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please Enter Course Short Name'
                      },
                      required: 
                      {
                       message: 'Please Enter Course Short Name'
                      }
                     
                    }
                }
            }       
        })
		
		
		$('.alphaonly').bind('keyup blur',function(){ 
			var node = $(this);
			node.val(node.val().replace(/[^a-zA-Z. ]/g,'') ); }
		);
		
    });

</script>
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <!--<li class="active"><a href="#">Cousre</a></li>-->
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-5 text-center text-left-sm">
			<i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Add Course </h1>
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
                            <span class="panel-title">Enter Details</span>
							
                    </div>
                    <div class="panel-body">
                        <div class="table-info">                            
                            
                            <form id="form" name="form" action="<?=base_url($currentModule.'/add_course_submit')?>" method="POST" onsubmit="return validate_faci_category(event)">                                                               
                                <div class="form-group">
                                    <label class="col-sm-3">Course Name <?=$astrik?></label>                                    
                                    <div class="col-sm-4">
                                        <input type="text" id="cname" name="cname" onchange="check_crs_exists()" class="form-control alphaonly" />
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('cname');?></span></div>
                                </div>
                                
								<div class="form-group">
                                    <label class="col-sm-3"> Course Short Name <?=$astrik?></label>                                    
                                    <div class="col-sm-4">
                                        <input type="text" id="csname" name="csname" onchange="check_crs_exists()" class="form-control alphaonly" />
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('csname');?></span></div>
                                </div>
								
								
                                <div class="form-group">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-2">
                                        <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Add</button>                                        
                                    </div>                                    
                                    <div class="col-sm-2"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule.'/course_master')?>'">Cancel</button></div>
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
function check_crs_exists()
{
	//alert("gvjhj");
	var cname=$('#cname').val();
	var csname=$('#csname').val();
	if(cname=="")
	{
		$('#err_msg').html('Please Enter Course Name');
	}
	else if(csname=="")
	{
		$('#err_msg').html('Please Enter Course Short Name');
	}
	else
	{
		$('#err_msg').html('');
		$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Master/check_course_exists',
				data: {cname:cname,csname:csname},
				success: function (html) {
					//alert(html);
					if(html>0)
					{$('#err_msg').html("This Course Details are already there.");status=1;}
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
