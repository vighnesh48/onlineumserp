<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>

<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="#">Edit Bank</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Edit Bank</h1>
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
                            <span class="panel-title">Bank Details</span>
                    </div>
                    <div class="panel-body">
                        <div class="table-info">                            
                            <?php //if(in_array("Add", $my_privileges)) { ?>
                            <form id="form" name="form" action="<?=base_url($currentModule.'/Update_item')?>" method="POST">                                                               
                               <?php foreach($getAllitem as $list){ ?>
                                <input type="hidden" value="<?=$list['item_id']?>" id="item_id" name="item_id" />
                              <div class="form-group">
                                    <label class="col-sm-3">Item Type <?=$astrik?></label>                                    
                                    <div class="col-sm-3"><select name="Item_type" id="Item_type" class="form-control" required>
                                    <option value="">Select</option>
                                    <option value="Internal" <?php if($list['Item_type']=="Internal"){?>  selected="selected"<?php } ?>>Internal</option>
                                    <option value="External" <?php if($list['Item_type']=="External"){?>  selected="selected"<?php } ?>>External</option>
                                    </select></div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php //echo form_error('branch_name');?></span></div>
                                </div>
                                
                                
                                
                                
                                <div class="form-group">
                                    <label class="col-sm-3">Item Name. <?=$astrik?></label>                                    
                                    <div class="col-sm-3"><input type="text" id="Item_Name" name="Item_Name" class="form-control" value="<?=$list['Item_Name']?>" required/></div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php //echo form_error('bank_account_no');?></span></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3">Item Amount <?=$astrik?></label>                                    
                                    <div class="col-sm-3"><input type="text" id="Item_Amount" name="Item_Amount" class="form-control" value="<?=$list['Item_Amount']?>" required/></div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php //echo form_error('account_name');?></span></div>
                                </div>
                                                                
                                
                                <div class="form-group">
                                    <label class="col-sm-3">Active<?=$astrik?></label>                                    
                                    <div class="col-sm-3"><select name="Status" id="Status" class="form-control" required>
                                    <option value="">Select</option>
                                    <option value="Y" <?php if($list['status']=="Y"){?>  selected="selected"<?php } ?>>Yes</option>
                                    <option value="N" <?php if($list['status']=="N"){?>  selected="selected"<?php } ?>>No</option>
                                    </select></div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php //echo form_error('account_name');?></span></div>
                                </div>
                                 
                                 
                                <div class="form-group">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-2">
                                        <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Submit</button>                                        
                                    </div>                                    
                                    <div class="col-sm-2"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule)?>'">Cancel</button></div>
                                    <div class="col-sm-4"></div>
                                </div>
                                <?php } ?>
                            </form>
                            
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </div>
</div>