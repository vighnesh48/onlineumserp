

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
                sizecode:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Product code should not be empty'
                      },
                      /*stringLength: 
                        {
                        max: 10,
                        min: 2,
                        message: 'Color code should be 10-20 characters'
                        }*/
                    }

                },
                size:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Product name should not be empty'
                      }
                    }

                },
                product_id:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Product name  not be Selected'
                      }
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
        <li class="active"><a href="#">Add Product Size Size</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Add Product Size </h1>
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
                            <span class="panel-title">Product size Details</span>
                    </div>
                    <div class="panel-body">
                        <div class="table-info">                            
                            <?php if(in_array("Add", $my_privileges)) { ?>
                            <form id="form" name="form" action="<?=base_url($currentModule.'/submit')?>" method="POST">                                                               
                                <input type="hidden" value="" id="productsize_id" name="productsize_id" />
                                  <div class="form-group">
                                    <label class="col-sm-3">Product Name <?=$astrik?></label>                
                                    <div class="col-sm-6">
                                        <select class="form-control" name="product_id" id="product_id">
                                         <option value=""> -- Select -- </option>
                                         <?php  
										
										 foreach($products as $product) { ?>
                                                 <option value="<?php echo $product['id']?>"><?php echo $product['product_name']?> </option>
                                           <?php }  ?>
                                        </select>
                                    </div>                                    
                                    <div class="col-sm-3">
                                        <span style="color:red;"><?php echo form_error('size');?></span>
                                    </div>
                                </div> 
								<div class="form-group">
                                    <label class="col-sm-3">Size Name <?=$astrik?></label>                                    
                                    <div class="col-sm-6"><input type="text" id="size" name="size" class="form-control" value="<?=isset($_REQUEST['size'])?$_REQUEST['size']:''?>" /></div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('size');?></span></div>
                                </div> 
								<div class="form-group">
                                    <label class="col-sm-3">Size Code <?=$astrik?></label>                                    
                                    <div class="col-sm-6"><input type="text" id="sizecode" name="sizecode" class="form-control" value="<?=isset($_REQUEST['sizecode'])?$_REQUEST['sizecode']:''?>" /></div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('sizecode');?></span></div>
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