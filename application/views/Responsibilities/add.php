<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<?php //print_r($my_privileges); die; ?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Masters</a></li>
        <li class="active"><a href="#">Upload Staff Document</a></li>
    </ul>
    <div class="page-header">
      <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Upload Staff document</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                </div>
            </div>
        </div>
		<div class="row ">
            <div class="col-sm-12">&nbsp;</div>
        </div>
	    <div class="row ">
		 <div class="col-sm-12">
		 <div class="panel">
		      <div class="panel-heading">
                            <span class="panel-title">Staff Details</span>
                    </div>
					 <div class="panel-body">
                        <div class="table-info"> 
						 <form id="form" name="form" action="<?=base_url($currentModule.'/submit')?>" method="POST" enctype="multipart/form-data">
						  <input type="hidden" value="" id="upload_id" name="upload_id" />
                        <div class="form-group">
						 <label class="col-sm-3">Staff Name <?=$astrik?></label> 
                          
							<div class="col-sm-6">
                            <select required id="search_me" name="search_me" style="border:none;background: #fff;background: rgba(0,0,0,.05);" class="form-control no-padding-hr" placeholder="Search...">
                                <option value="">Select Title</option>
                                <?php
                                    for($i=0;$i<count($fc_details);$i++)
                                   {
                                ?>
                                <option value="<?=$fc_details[$i]['emp_reg_id']?>"><?=$fc_details[$i]['fname']." ".$fc_details[$i]['lname']."(".$fc_details[$i]['emp_id'].")"?></option>
                                <?php
                                    }
                                ?>
                            </select>
							</div> 
                          <div class="col-sm-3"><span style="color:red;"><?php echo form_error('branch_code');?></span></div>
                                </div> 
                          <div class="form-group">
                                    <label class="col-sm-3">Upload document <?=$astrik?></label>                                    
                                     
									<input required type="file"  name="doc" id="doc">
									<span style="color:red;"><?php //echo form_error('mou_doc');?></span>                             
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('doc');?></span></div>
                                </div>  
						   <div class="form-group">
                                    <div class="col-sm-4"></div>
                                    <div class="col-sm-2">
                                        <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Submit</button>                                        
                                    </div>                                    
                                    <div class="col-sm-2"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule)?>'">Cancel</button></div>
                                    <div class="col-sm-4"></div>
                                </div>		
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
  $("div.holder").jPages
  ({
    containerID : "itemContainer"
  });
  $("#search_me").select2({
      placeholder: "Enter title",
      allowClear: true
    });
        </script>

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
                branch_code:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Branch code should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[a-zA-Z-/]+$/,
                        message: 'Branch Code should be alphabate characters'
                      },
                      stringLength: 
                        {
                        max: 10,
                        min: 2,
                        message: 'Branch code should be 10-20 characters'
                        }
                    }

                },
                branch_name:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Branch name should not be empty'
                      }
                    }

                },
                branch_type:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Please select course type.'
                      }
                    }

                },
                duration:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Please select course type.'
                      },
                      regexp: 
                      {
                        regexp: /^[0-9/]+$/,
                        message: 'Please select valid option for course duration'
                      },
                    }

                }
            }       
        })
    });
	</script>