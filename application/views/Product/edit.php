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
                colorcode:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Color code should not be empty'
                      },
                      stringLength: 
                        {
                        max: 10,
                        min: 2,
                        message: 'Color code should be 2-20 characters'
                        }
                    }

                },
                colorname:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Color name should not be empty'
                      }
                    }

                }
            }       
        })
    });
</script>
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
    //echo "<pre>";print_r($designation_details); echo "</pre>";
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="#">Edit Product</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Edit Product</h1>
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
                            <span class="panel-title">Color Details</span>
                    </div>
                    <div class="panel-body">
                        <div class="table-info">                            
                            <?php if(in_array("Edit", $my_privileges)) { ?>
                            <form id="form" name="form" action="<?=base_url($currentModule.'/submit')?>" method="POST"  enctype="multipart/form-data">                                                               
                                <input type="hidden" value="<?=isset($product_details['id'])?$product_details['id']:""?>" id="product_id" name="product_id" />
                                                               
                                <div class="form-group">
                                    <label class="col-sm-3">Product Name <?=$astrik?></label>                                    
                                    <div class="col-sm-6"><input type="text" id="product_name" name="product_name" class="form-control" value="<?=isset($product_details['product_name'])?$product_details['product_name']:''?>" /></div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('product_name');?></span></div>
                                </div> 
								<div class="form-group">
                                    <label class="col-sm-3">Price<?=$astrik?></label>                                    
                                    <div class="col-sm-6"><input type="text" id="product_price" name="product_price" class="form-control" value="<?=isset($product_details['product_price'])?$product_details['product_price']:''?>" /></div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('product_price');?></span></div>
                                </div> 
								<input type="hidden" id="temp_image" name="temp_image" class="form-control" value="<?=isset($product_details['Image'])?$product_details['Image']:''?>" />
								<div class="form-group">
										<label class="col-md-3">Upload Photo:<?=$astrik?></label>
										<?php
										if(!empty($product_details['Image'])){
										
											$profile=base_url()."uploads/uniform/product/".$product_details['Image'];
										}else{
									$profile=base_url()."uploads/noimage.png";}?>
									<div class="col-md-9">
									<div class="row">
									<div class="col-sm-2">
										<img id="blah" alt="Student Profile image" src="<?php echo $profile;?>"width="100" height="100" border="1px solid black" />
										</div><br><br><br><br>
										
									 <div class="col-sm-3">
										<input type="file" id="profile_img" name="profile_img"  onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])" >
										</div>
									</div>
									</div>	
								</div>
								
                                <div class="form-group">
                                    <div class="col-sm-4"></div>
                                    <div class="col-sm-2">
                                        <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Submit</button>                                        
                                    </div>                                    
                                    <div class="col-sm-2"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule)?>'">Cancel</button></div>
                                    <div class="col-sm-4"></div>
                                </div>
                            </form>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </div>
</div>