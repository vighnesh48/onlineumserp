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
                branch_name:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Branch name should not be empty'
                      },
                      stringLength: 
                        {
                        max: 100,
                        min: 5,
                        message: 'Branch name should be 5-20 characters'
                        }
                    }

                },
                account_name:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Account name should not be empty'
                      },
                      stringLength: 
                        {
                        max: 100,
                        min: 5,
                        message: 'Account name should be 5-20 characters'
                        }
                    }

                },
                bank_code:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Bank code should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[a-zA-Z0-9-/]+$/,
                        message: 'Bank Code should be alpha numeric characters'
                      },
                      stringLength: 
                        {
                        max: 20,
                        min: 2,
                        message: 'Bank code should be 2-20 characters'
                        }
                    }

                },
                bank_name:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Bank name should not be empty'
                      }
                    }
                },
                bank_account_no:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Account no should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[0-9/]+$/,
                        message: 'Account no should be numeric value'
                      },
                      stringLength: 
                        {
                        max: 20,
                        min: 2,
                        message: 'Account no should be 2-20 characters'
                        }
                    }

                },
                bank_ifsc:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'IFSC should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[a-zA-Z0-9/]+$/,
                        message: 'IFSC should be alpha numeric value'
                      },
                      stringLength: 
                        {
                        max: 20,
                        min: 2,
                        message: 'IFSC should be 2-20 characters'
                        }
                    }

                },
                bank_micr:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Mirc Code should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[0-9/]+$/,
                        message: 'Mirc Code should be numeric value'
                      },
                      stringLength: 
                        {
                        max: 20,
                        min: 2,
                        message: 'Mirc Code should be 2-20 characters'
                        }
                    }

                },
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
                            <?php if(in_array("Edit", $my_privileges)) { ?>
                            <form id="form" name="form" action="<?=base_url($currentModule.'/submit')?>" method="POST">                                                               
                                <input type="hidden" value="<?=isset($bank_details['bank_id'])?$bank_details['bank_id']:""?>" id="bank_id" name="bank_id" />
                                <div class="form-group">
                                    <label class="col-sm-3">Bank Branch <?=$astrik?></label>                                    
                                    <div class="col-sm-6"><input type="text" id="branch_name" name="branch_name" class="form-control" value="<?=isset($bank_details['branch_name'])?$bank_details['branch_name']:''?>" /></div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('branch_name');?></span></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3">Account No. <?=$astrik?></label>                                    
                                    <div class="col-sm-6"><input type="text" id="bank_account_no" name="bank_account_no" class="form-control" value="<?=isset($bank_details['bank_account_no'])?$bank_details['bank_account_no']:''?>" /></div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('bank_account_no');?></span></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3">Account Name <?=$astrik?></label>                                    
                                    <div class="col-sm-6"><input type="text" id="account_name" name="account_name" class="form-control" value="<?=isset($bank_details['account_name'])?$bank_details['account_name']:''?>" /></div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('account_name');?></span></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3">Bank Code <?=$astrik?></label>                                    
                                    <div class="col-sm-6"><input type="text" id="bank_code" name="bank_code" class="form-control" value="<?=isset($bank_details['bank_code'])?$bank_details['bank_code']:''?>" /></div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('bank_code');?></span></div>
                                </div>                                
                                <div class="form-group">
                                    <label class="col-sm-3">Bank Name <?=$astrik?></label>                                    
                                    <div class="col-sm-6"><input type="text" id="bank_code" name="bank_name" class="form-control" value="<?=isset($bank_details['bank_name'])?$bank_details['bank_name']:''?>" /></div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('bank_name');?></span></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3">Bank Editress <?=$astrik?></label>                                    
                                    <div class="col-sm-6"><textarea id="bank_address" name="bank_address" class="form-control"><?=isset($bank_details['bank_address'])?$bank_details['bank_address']:''?></textarea></div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('bank_address');?></span></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3">Micr Code. <?=$astrik?></label>                                    
                                    <div class="col-sm-6"><input type="text" id="bank_micr" name="bank_micr" class="form-control" value="<?=isset($bank_details['bank_micr'])?$bank_details['bank_micr']:''?>" /></div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('bank_micr');?></span></div>
                                </div> 
                                <div class="form-group">
                                    <label class="col-sm-3">IFSC. <?=$astrik?></label>                                    
                                    <div class="col-sm-6"><input type="text" id="bank_ifsc" name="bank_ifsc" class="form-control" value="<?=isset($bank_details['bank_ifsc'])?$bank_details['bank_ifsc']:''?>" /></div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('bank_ifsc');?></span></div>
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