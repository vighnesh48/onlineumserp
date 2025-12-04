<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>

<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
	//print_r($hostel_details);
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="#">Add Item</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Add Item</h1>
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
                            <span class="panel-title">Item Details</span>
                    </div>
                    <div class="panel-body">
                        <div class="table-info">                            
                            <?php //if(in_array("Add", $my_privileges)) { ?>
                            <form id="form" name="form" action="<?=base_url($currentModule.'/submit')?>" method="POST">                                                               
                                <input type="hidden" value="" id="bank_id" name="bank_id" />
                              <div class="form-group">
                                    <label class="col-sm-3">Item Type <?=$astrik?></label>                                    
                                    <div class="col-sm-3"><select name="Item_type" id="Item_type" class="form-control" required>
                                    <option value="">Select</option>
                                    <option value="Internal">Internal</option>
                                    <option value="External">External</option>
                                    </select></div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php //echo form_error('branch_name');?></span></div>
                                </div>
                                
                                
                                
                                
                                <div class="form-group">
                                    <label class="col-sm-3">Item Name. <?=$astrik?></label>                                    
                                    <div class="col-sm-3"><input type="text" id="Item_Name" name="Item_Name" class="form-control" value="" required/></div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php //echo form_error('bank_account_no');?></span></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3">Item Amount <?=$astrik?></label>                                    
                                    <div class="col-sm-3"><input type="text" id="Item_Amount" name="Item_Amount" class="form-control" value="" required/></div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php //echo form_error('account_name');?></span></div>
                                </div>
                                                                
                                
                                <div class="form-group">
                                    <label class="col-sm-3">Active<?=$astrik?></label>                                    
                                    <div class="col-sm-3"><select name="Status" id="Status" class="form-control" required>
                                    <option value="">Select</option>
                                    <option value="Y">Yes</option>
                                    <option value="N">No</option>
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
                            </form>
                            <?php //} ?>
                        </div>
                    </div>
                    
                    
                    <div class="panel-body">
                    <div class="table-info">    
                    <?php  //if(in_array("View", $my_privileges)) { ?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                    <th>#</th>
                                    <th>Item Type</th>
                                    <th>Item Name</th>                                    
                                    <th>Item Amount</th>                                    
                                                                 
                                    <th>Status</th>                                                                                                         
                                    <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php
                            $j=1;                            
                            foreach($getAllitem as $list)
                            {
                                
                            ?>
                            <tr <?=$list["status"]=="N"?"style='background-color:#FBEFF2'":""?>>
                                <td><?=$j?></td>                                                                
                                <td><?=$list['Item_type']?></td>
                                <td><?=$list['Item_Name']?></td>
                                <td><?=$list['Item_Amount']?></td>                                
                                <td><?=$list['status']?></td> 
                                <td>
                                    <?php //if(in_array("Edit", $my_privileges)) { ?>
                                    <a href="<?=base_url($currentModule."/edit/".$list['item_id'])?>"><i class="fa fa-edit"></i></a>                                                                        
                                    <?php //} ?>
                                    <?php // if(in_array("Delete", $my_privileges)) { ?>
                                   <!-- <a href='<?=base_url($currentModule)."/"?><?=$list["status"]=="Y"?"disable/".$list["item_id"]:"enable/".$list["item_id"]?>'><i class='fa <?=$list["status"]=="Y"?"fa-ban":"fa-check"?>' title='<?=$list["status"]=="Y"?"Disable":"Enable"?>'></i></a>-->
                                    <?php //} ?>
                                </td>
                            </tr>
                            <?php
                            $j++;
                            }
                            ?>                            
                        </tbody>
                    </table>                    
                    <?php //} ?>
                </div>
                </div>
                    
                    
                    
                </div>
            </div>    
        </div>
    </div>
</div>
<script type="text/javascript">
$("#Hostel").on('change',function(){
	//alert();
	var id=$(this).val();
	$.ajax({
		'url': '<?php echo base_url()?>Caution_money/Get_floor',
		'type':'POST',
		'data':'id='+id,
		'success' : function(data){ 
	    $("#HFloor").html(data);
		}
		});
	
	
	
})
</script>