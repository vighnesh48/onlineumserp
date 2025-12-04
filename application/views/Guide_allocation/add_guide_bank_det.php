<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<style>
#guide { display: flex; 
       justify-content: center }

</style>
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
				bank_name:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Bank Name should not be empty'
                      }
					}  
                },
				acc_holder_name:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Account Holder Name should not be empty'
                      },
                    regexp: 
                      {
                        regexp: /^[a-z\s]+$/i,
                        message: 'Account Holder Name should be alphabate characters and spaces only'
                      },
                       stringLength: 
                        {
                        max: 50,
                        min: 2,
                        message: 'Account Holder Name should be 2-50 characters.'
                        } 
                    }
                },
				  acc_no:
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
				  branch:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Branch name should not be empty'
                      },
					   regexp: 
						{
						regexp: /^[a-zA-Z0-9 ]+$/,
						message: 'Branch name can only consist of alphanumeric characters and spaces'
						},
                      stringLength: 
                        {
                        max: 20,
                        min: 2,
                        message: 'Branch name should be 2-20 characters'
                        }
                    }

                },
                ifsc_code:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'IFSC should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[A-Z0-9/]+$/,
                        message: 'IFSC should be alpha numeric value'
                      },
                      stringLength: 
                        {
                        max: 11,
                        min: 11,
                        message: 'IFSC should be Exactly 11 characters'
                        }
                    }

                },
				  cheque_file: {
                    validators: {
                        notEmpty: {
                            message: 'Please select a file'
                        },
                        file: {
                            extension: 'jpeg,jpg,png,gif,pdf',
                            type: 'image/jpeg,image/png,image/gif,application/pdf',
                            maxSize: 2097152, // 2 MB in bytes
                            message: 'Please select a valid file (jpeg, jpg, png, gif, pdf) and the file size must be less than 2 MB'
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
        <li class="active"><a href="<?=base_url($currentModule)?>">Phd Guide Allocation</a></li>
    </ul>
	
		<?php //echo'<pre>';print_r($renum_files);exit;
     if(isset($_SESSION['status']))
     {
        ?>
			<script>
			var status="<?php echo $_SESSION['status'] ?>";
			 alert(status);
			</script>
        <?php 
        unset($_SESSION['status']);
       }
   ?>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Add Guide Bank Details </h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row"> 
						<br/>				
					<span id="flash-messages" style="color:Green;padding-left:50px;">
						 <?php if(!empty($this->session->flashdata('message1'))){ echo $this->session->flashdata('message1'); } ?></span>
					<span id="flash-message" style="color:red;padding-left:50px;">
						 <?php if(!empty($this->session->flashdata('message2'))){ echo $this->session->flashdata('message2'); } ?></span>
                    <hr class="visible-xs no-grid-gutter-h">
                </div>
            </div>
        </div>
		    <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-heading">
                        <span class="panel-title" id="guide"> &nbsp;&nbsp;&nbsp;&nbsp;<b>Guide ID-Name : <?php if($guide_det['guide_id']!=''){ echo $guide_det['guide_id'].' - '.$guide_det['guide_name']; } else { echo '';}?> </b></span>
                    </div>
                </div>
            </div>    
        </div>      
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-heading">
                        <span class="panel-title">Add Guide Bank Details</span>						
						<span id="message" style="color:red;padding-left:200px;"></span>
                        <div class="holder"></div>
					</div>
                    <div class="panel-body">
                        <div class="table-info">                                                       
                            <form id="form" name="form" action="<?=base_url($currentModule.'/insert_guide_bank_details')?>" method="POST" enctype="multipart/form-data"> 
							 <input type="hidden" name="guide_id" value="<?=$guide_det['guide_id']?>" />	
							<div class="form-group">  
                               <div class="col-sm-4">
							   <label >Select Bank: <?=$astrik?></label>
                                   <select  name="bank_name" id="bank_name" class="form-control" >
                                 <option value="">Select Bank</option>
                                 <?php
                                    foreach($bank_details as $result){?>
                                 <option value="<?php echo $result['bank_id']?>"><?php echo $result['bank_name'];?></option>
                                 <?php } ?>   
                              </select>
							   <span style="color:red;"><?php echo form_error('bank_name');?></span>
                                </div>							
                                <div class="col-sm-4">
                                     <label>Account Holder Name: <?=$astrik?></label>
									<input type="text" id="acc_holder_name" name="acc_holder_name" class="form-control" placeholder="Enter Name" />
                                   <span style="color:red;"><?php echo form_error('acc_holder_name');?></span>								
                                </div>
								 <div class="col-sm-4">
                                   <label>Account No: <?=$astrik?></label>
									<input type="text" id="acc_no" name="acc_no" class="form-control" placeholder="Enter Account No." />
                                   <span style="color:red;"><?php echo form_error('acc_no');?></span>
                                </div>								
							</div>
								<!--div class="form-group">  							
                                <div class="col-sm-4">
                                     <label>IFSC Code: <?=$astrik?></label>
									<input type="text" id="ifsc_code" name="ifsc_code" class="form-control" placeholder="Enter IFSC Code" />
                                   <span style="color:red;"><?php echo form_error('ifsc_code');?></span>								
                                </div>
								 <div class="col-sm-4">
                                   <label>Branch : <?=$astrik?></label>
									<input type="text" id="branch" name="branch" class="form-control" placeholder="Enter Branch" />
                                   <span style="color:red;"><?php echo form_error('branch');?></span>
                                </div>								
							</div-->
							<div class="form-group">  							
                                <div class="col-sm-4">
                                     <label>IFSC Code: <?=$astrik?></label>
									<input type="text" id="ifsc_code" name="ifsc_code" class="form-control" placeholder="Enter IFSC Code" />
                                   <span style="color:red;"><?php echo form_error('ifsc_code');?></span>								
                                </div>
								 <div class="col-sm-4">
                                   <label>Branch : <?=$astrik?></label>
									<input type="text" id="branch" name="branch" class="form-control" placeholder="Enter Branch" />
                                   <span style="color:red;"><?php echo form_error('branch');?></span>
                                </div>	
                                    <div class="col-sm-4">
                                   <label>Passbook/Cheque Copy<?=$astrik?></label>
									<input type="file" id="cheque_file" name="cheque_file" class="form-control" />
                                   <span style="color:red;"><?php echo form_error('cheque_file');?></span>
                                </div>									
							</div>
							<div class="form-group" ></div>
							 <div class="form-group" id="guide">
                                    <div class="col-sm-2">
                                       <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Submit</button>
                                    </div>                                    
                                    <div class="col-sm-2"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule)?>/guide_recommendation'">Cancel</button></div>
                                </div>								
							   </div>	
                            </form>
                        </div>
                    </div>
                </div>
            </div>			
        </div>
    </div>    
