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
                school_id:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'School Name not be Selected'
                      }
                    }

                },
                color_id:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Color Name not be Selected'
                      }
                    }
                },
				size_id:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Product Size Name not be Selected'
                      }
                    }

                },
                product_id:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Product Name not be Selected'
                      }
                    }
                },
				 quantity: {
                    validators: {
                        notEmpty: {
                            message: 'Product Quantity not be Empty'
                        },
                        numeric: {
                            message: 'The value is not a valid number'
                        },
                        greaterThan: {
                            value: 0, 
                            inclusive: false,
                            message: 'The quantity must be greater than 0'
                        }
                    }
                },

				
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
        <li class="active"><a href="#">Edit Inventory</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Edit Inventory</h1>
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
                            <span class="panel-title">Inventory</span>
                    </div>
                    <div class="panel-body">
                        <div class="table-info">                            
                            <?php if(in_array("Edit", $my_privileges)) { ?>
                            <form id="form" name="form" action="<?=base_url($currentModule.'/submit')?>" method="POST">                                                               
                                <input type="hidden" value="<?=isset($inventory_details['id'])?$inventory_details['id']:""?>" id="inventory_id" name="inventory_id" />
                                
								<div class="form-group">
                                    <label class="col-sm-3">School Name <?=$astrik?></label>                
                                    <div class="col-sm-6">
                                        <select class="form-control" name="school_id" id="school_id">
                                       <option value=""> -- Select -- </option>
                                         <?php foreach($school as $schools) {
                                                if($inventory_details['school_id'] == $schools['id']) {?>
                                                     <option value="<?php echo $schools['id']?>" selected><?php echo $schools['school_name']?> </option>
                                               
                                               <?php   } else { ?>
                                                     <option value="<?php echo $schools['id']?>"><?php echo $schools['school_name']?> </option>
                                                   <?php  } } ?>
                                        </select>
                                    </div>                                    
                                    <div class="col-sm-3">
                                        <span style="color:red;"><?php echo form_error('school_id');?></span>
                                    </div>
                                </div> 
								
                                
								<div class="form-group">
                                    <label class="col-sm-3">Product Name <?=$astrik?></label>                
                                    <div class="col-sm-6">
                                        <select class="form-control" name="product_id" id="product_id">
                                        <option value=""> -- Select -- </option>
                                         <?php foreach($product as $products) {
                                                if($inventory_details['product_id'] == $products['id']) {?>
                                                     <option value="<?php echo $products['id']?>" selected><?php echo $products['product_name']?> </option>
                                               
                                               <?php   } else { ?>
                                                     <option value="<?php echo $products['id']?>"><?php echo $products['product_name']?> </option>
                                                   <?php  } } ?>
                                        </select>
                                    </div>                                    
                                    <div class="col-sm-3">
                                        <span style="color:red;"><?php echo form_error('product_id');?></span>
                                    </div>
                                </div>
								
								<div class="form-group">
                                    <label class="col-sm-3">Product Size<?=$astrik?></label>                
                                    <div class="col-sm-6">
                                        <select class="form-control" name="size_id" id="size_id">
                                        <option value=""> -- Select -- </option>
                                         <?php foreach($size as $sizes) {
                                                if($inventory_details['product_size_id'] == $sizes['id']) {?>
                                                     <option value="<?php echo $sizes['id']?>" selected><?php echo $sizes['size']?> </option>
                                               
                                               <?php   } else { ?>
                                                     <option value="<?php echo $sizes['id']?>"><?php echo $sizes['size']?> </option>
                                                   <?php  } } ?>
                                        </select>
                                    </div>                                    
                                    <div class="col-sm-3">
                                        <span style="color:red;"><?php echo form_error('size_id');?></span>
                                    </div>
                                </div>
								<div class="form-group">
                                    <label class="col-sm-3">Color Name <?=$astrik?></label>                
                                    <div class="col-sm-6">
                                        <select class="form-control" name="color_id" id="color_id">
                                        <option value=""> -- Select -- </option>
                                         <?php foreach($color as $colors) {
                                                if($inventory_details['color_id'] == $colors['id']) {?>
                                                     <option value="<?php echo $colors['id']?>" selected><?php echo $colors['colorname']?> </option>
                                               
                                               <?php   } else { ?>
                                                     <option value="<?php echo $colors['id']?>"><?php echo $colors['colorname']?> </option>
                                                   <?php  } } ?>
                                        </select>
                                    </div>                                    
                                    <div class="col-sm-3">
                                        <span style="color:red;"><?php echo form_error('color_id');?></span>
                                    </div>
                                </div> 
								<div class="form-group">
                                    <label class="col-sm-3">Quantity <?=$astrik?></label>                                    
                                    <div class="col-sm-6"><input type="text" id="quantity" name="quantity" class="form-control" value="<?=isset($inventory_details['quantity'])?$inventory_details['quantity']:''?>" /></div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('quantity');?></span></div>
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