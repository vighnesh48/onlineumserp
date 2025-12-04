<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<style>
label {
  font-size: 13px;
}
#lb{
	font-size: 10px;
}
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
                house_rent_amount:
                {
                    validators: 
                    {
                      regexp: 
                      {
                        regexp: "^[1-9][0-9]*$",
                        message: 'Amount should be Numeric characters'
                      },
                      stringLength: 
                        {
                        max: 8,
                        min: 2,
                        message: 'Amount should be 2-8 characters'
                        }
                    }

                },
				house_rent_file:
                {
                    validators: 
                    {
						 notEmpty: 
                      {
                       message: 'File is Manditory'
                      },
	                file: {
                        extension: 'pdf,zip',
                        type: 'application/pdf,application/zip',
                        maxSize: 2048 * 1024,
                        message: 'Pdf and Zip files allowed And Size Must be less than 2MB'
                        }
                    }

                },
				  house_loan_interest_amount:
                {
                    validators: 
                    {
                      regexp: 
                      {
                        regexp: "^[1-9][0-9]*$",
                        message: 'Amount should be Numeric characters'
                      },
                      stringLength: 
                        {
                        max: 8,
                        min: 2,
                        message: 'Amount should be 2-8 characters'
                        }
                    }

                },
				house_loan_interest_file:
                {
                    validators: 
                    {
						 notEmpty: 
                      {
                       message: 'File is Manditory'
                      },
	                file: {
                        extension: 'zip,pdf',
                        type: 'application/pdf,application/zip',
                        maxSize: 2048 * 1024,
                        message: 'Pdf and Zip files allowed And Size Must be less than 2MB'
                        }
                    }

                },
				 vpf_amount:
                {
                    validators: 
                    {
                      regexp: 
                      {
                        regexp: "^[1-9][0-9]*$",
                        message: 'Amount should be Numeric characters'
                      },
                      stringLength: 
                        {
                        max: 8,
                        min: 2,
                        message: 'Amount should be 2-8 characters'
                        }
                    }

                },
				vpf_file:
                {
                    validators: 
                    {
						 notEmpty: 
                      {
                       message: 'File is Manditory'
                      },
	                file: {
                        extension: 'zip,pdf',
                        type: 'application/pdf,application/zip',
                        maxSize: 2048 * 1024,
                        message: 'Pdf and Zip files allowed And Size Must be less than 2MB'
                        }
                    }

                },
				 provident_fund_amount:
                {
                    validators: 
                    {
                      regexp: 
                      {
                        regexp: "^[1-9][0-9]*$",
                        message: 'Amount should be Numeric characters'
                      },
                      stringLength: 
                        {
                        max: 8,
                        min: 2,
                        message: 'Amount should be 2-8 characters'
                        }
                    }

                },
				provident_fund_file:
                {
                    validators: 
                    {
						 notEmpty: 
                      {
                       message: 'File is Manditory'
                      },
	                file: {
                        extension: 'zip,pdf',
                        type: 'application/pdf,application/zip',
                        maxSize: 2048 * 1024,
                        message: 'Pdf and Zip files allowed And Size Must be less than 2MB'
                        }
                    }

                },
				 scss_amount:
                {
                    validators: 
                    {
                      regexp: 
                      {
                        regexp: "^[1-9][0-9]*$",
                        message: 'Amount should be Numeric characters'
                      },
                      stringLength: 
                        {
                        max: 8,
                        min: 2,
                        message: 'Amount should be 2-8 characters'
                        }
                    }

                },
				scss_file:
                {
                    validators: 
                    {
						 notEmpty: 
                      {
                       message: 'File is Manditory'
                      },
	                file: {
                        extension: 'zip,pdf',
                        type: 'application/pdf,application/zip',
                        maxSize: 2048 * 1024,
                        message: 'Pdf and Zip files allowed And Size Must be less than 2MB'
                        }
                    }

                },
				 nsc_amount:
                {
                    validators: 
                    {
                      regexp: 
                      {
                        regexp: "^[1-9][0-9]*$",
                        message: 'Amount should be Numeric characters'
                      },
                      stringLength: 
                        {
                        max: 8,
                        min: 2,
                        message: 'Amount should be 2-8 characters'
                        }
                    }

                },
				nsc_file:
                {
                    validators: 
                    {
						 notEmpty: 
                      {
                       message: 'File is Manditory'
                      },
	                file: {
                        extension: 'zip,pdf',
                        type: 'application/pdf,application/zip',
                        maxSize: 2048 * 1024,
                        message: 'Pdf and Zip files allowed And Size Must be less than 2MB'
                        }
                    }

                },
				 txfd_amount:
                {
                    validators: 
                    {
                      regexp: 
                      {
                        regexp: "^[1-9][0-9]*$",
                        message: 'Amount should be Numeric characters'
                      },
                      stringLength: 
                        {
                        max: 8,
                        min: 2,
                        message: 'Amount should be 2-8 characters'
                        }
                    }

                },
				txfd_file:
                {
                    validators: 
                    {
						 notEmpty: 
                      {
                       message: 'File is Manditory'
                      },
	                file: {
                        extension: 'zip,pdf',
                        type: 'application/pdf,application/zip',
                        maxSize: 2048 * 1024,
                        message: 'Pdf and Zip files allowed And Size Must be less than 2MB'
                        }
                    }

                },
				  tax_bond_amount:
                {
                    validators: 
                    {
                      regexp: 
                      {
                        regexp: "^[1-9][0-9]*$",
                        message: 'Amount should be Numeric characters'
                      },
                      stringLength: 
                        {
                        max: 8,
                        min: 2,
                        message: 'Amount should be 2-8 characters'
                        }
                    }

                },
				tax_bond_file:
                {
                    validators: 
                    {
						 notEmpty: 
                      {
                       message: 'File is Manditory'
                      },
	                file: {
                        extension: 'zip,pdf',
                        type: 'application/pdf,application/zip',
                        maxSize: 2048 * 1024,
                        message: 'Pdf and Zip files allowed And Size Must be less than 2MB'
                        }
                    }

                },
				 elss_amount:
                {
                    validators: 
                    {
                      regexp: 
                      {
                        regexp: "^[1-9][0-9]*$",
                        message: 'Amount should be Numeric characters'
                      },
                      stringLength: 
                        {
                        max: 8,
                        min: 2,
                        message: 'Amount should be 2-8 characters'
                        }
                    }

                },
				elss_file:
                {
                    validators: 
                    {
						 notEmpty: 
                      {
                       message: 'File is Manditory'
                      },
	                file: {
                        extension: 'zip,pdf',
                        type: 'application/pdf,application/zip',
                        maxSize: 2048 * 1024,
                        message: 'Pdf and Zip files allowed And Size Must be less than 2MB'
                        }
                    }

                },
				 life_ins_prem_amount:
                {
                    validators: 
                    {
                      regexp: 
                      {
                        regexp: "^[1-9][0-9]*$",
                        message: 'Amount should be Numeric characters'
                      },
                      stringLength: 
                        {
                        max: 8,
                        min: 2,
                        message: 'Amount should be 2-8 characters'
                        }
                    }

                },
				life_ins_prem_file:
                {
                    validators: 
                    {
						 notEmpty: 
                      {
                       message: 'File is Manditory'
                      },
	                file: {
                        extension: 'zip,pdf',
                        type: 'application/pdf,application/zip',
                        maxSize: 2048 * 1024,
                        message: 'Pdf and Zip files allowed And Size Must be less than 2MB'
                        }
                    }

                },
				  nps_80c_amount:
                {
                    validators: 
                    {
                      regexp: 
                      {
                        regexp: "^[1-9][0-9]*$",
                        message: 'Amount should be Numeric characters'
                      },
                      stringLength: 
                        {
                        max: 8,
                        min: 2,
                        message: 'Amount should be 2-8 characters'
                        }
                    }

                },
				 nps_80c_file:
                {
                    validators: 
                    {
						 notEmpty: 
                      {
                       message: 'File is Manditory'
                      },
	                file: {
                        extension: 'zip,pdf',
                        type: 'application/pdf,application/zip',
                        maxSize: 2048 * 1024,
                        message: 'Pdf and Zip files allowed And Size Must be less than 2MB'
                        }
                    }

                },
				 pension_plan_amount:
                {
                    validators: 
                    {
                      regexp: 
                      {
                        regexp: "^[1-9][0-9]*$",
                        message: 'Amount should be Numeric characters'
                      },
                      stringLength: 
                        {
                        max: 8,
                        min: 2,
                        message: 'Amount should be 2-8 characters'
                        }
                    }

                },
				pension_plan_file:
                {
                    validators: 
                    {
						 notEmpty: 
                      {
                       message: 'File is Manditory'
                      },
	                file: {
                        extension: 'zip,pdf',
                        type: 'application/pdf,application/zip',
                        maxSize: 2048 * 1024,
                        message: 'Pdf and Zip files allowed And Size Must be less than 2MB'
                        }
                    }

                },
				 emp_pension_amount:
                {
                    validators: 
                    {
                      regexp: 
                      {
                        regexp: "^[1-9][0-9]*$",
                        message: 'Amount should be Numeric characters'
                      },
                      stringLength: 
                        {
                        max: 8,
                        min: 2,
                        message: 'Amount should be 2-8 characters'
                        }
                    }

                },
				emp_pension_file:
                {
                    validators: 
                    {
						 notEmpty: 
                      {
                       message: 'File is Manditory'
                      },
	                file: {
                        extension: 'zip,pdf',
                        type: 'application/pdf,application/zip',
                        maxSize: 2048 * 1024,
                        message: 'Pdf and Zip files allowed And Size Must be less than 2MB'
                        }
                    }

                },
				 houseloan_prin_repay_amount:
                {
                    validators: 
                    {
                      regexp: 
                      {
                        regexp: "^[1-9][0-9]*$",
                        message: 'Amount should be Numeric characters'
                      },
                      stringLength: 
                        {
                        max: 8,
                        min: 2,
                        message: 'Amount should be 2-8 characters'
                        }
                    }

                },
				houseloan_prin_repay_file:
                {
                    validators: 
                    {
						 notEmpty: 
                      {
                       message: 'File is Manditory'
                      },
	                file: {
                        extension: 'zip,pdf',
                        type: 'application/pdf,application/zip',
                        maxSize: 2048 * 1024,
                        message: 'Pdf and Zip files allowed And Size Must be less than 2MB'
                        }
                    }

                },
				 suk_sam_acc_amount:
                {
                    validators: 
                    {
                      regexp: 
                      {
                        regexp: "^[1-9][0-9]*$",
                        message: 'Amount should be Numeric characters'
                      },
                      stringLength: 
                        {
                        max: 8,
                        min: 2,
                        message: 'Amount should be 2-8 characters'
                        }
                    }

                },
				suk_sam_acc_file:
                {
                    validators: 
                    {
						 notEmpty: 
                      {
                       message: 'File is Manditory'
                      },
	                file: {
                        extension: 'zip,pdf',
                        type: 'application/pdf,application/zip',
                        maxSize: 2048 * 1024,
                        message: 'Pdf and Zip files allowed And Size Must be less than 2MB'
                        }
                    }

                },
				 stamp_duty_amount:
                {
                    validators: 
                    {
                      regexp: 
                      {
                        regexp: "^[1-9][0-9]*$",
                        message: 'Amount should be Numeric characters'
                      },
                      stringLength: 
                        {
                        max: 8,
                        min: 2,
                        message: 'Amount should be 2-8 characters'
                        }
                    }

                },
				stamp_duty_file:
                {
                    validators: 
                    {
						 notEmpty: 
                      {
                       message: 'File is Manditory'
                      },
	                file: {
                        extension: 'zip,pdf',
                        type: 'application/pdf,application/zip',
                        maxSize: 2048 * 1024,
                        message: 'Pdf and Zip files allowed And Size Must be less than 2MB'
                        }
                    }

                },
				 tuition_fee_amount:
                {
                    validators: 
                    {
                      regexp: 
                      {
                        regexp: "^[1-9][0-9]*$",
                        message: 'Amount should be Numeric characters'
                      },
                      stringLength: 
                        {
                        max: 8,
                        min: 2,
                        message: 'Amount should be 2-8 characters'
                        }
                    }

                },
				tuition_fee_file:
                {
                    validators: 
                    {
						 notEmpty: 
                      {
                       message: 'File is Manditory'
                      },
	                file: {
                        extension: 'zip,pdf',
                        type: 'application/pdf,application/zip',
                        maxSize: 2048 * 1024,
                        message: 'Pdf and Zip files allowed And Size Must be less than 2MB'
                        }
                    }

                },
				 other_amount:
                {
                    validators: 
                    {
                      regexp: 
                      {
                        regexp: "^[1-9][0-9]*$",
                        message: 'Amount should be Numeric characters'
                      },
                      stringLength: 
                        {
                        max: 8,
                        min: 2,
                        message: 'Amount should be 2-8 characters'
                        }
                    }

                },
				other_file:
                {
                    validators: 
                    {
						 notEmpty: 
                      {
                       message: 'File is Manditory'
                      },
	                file: {
                        extension: 'zip,pdf',
                        type: 'application/pdf,application/zip',
                        maxSize: 2048 * 1024,
                        message: 'Pdf and Zip files allowed And Size Must be less than 2MB'
                        }
                    }

                },
				  nps_amount:
                {
                    validators: 
                    {
                      regexp: 
                      {
                        regexp: "^[1-9][0-9]*$",
                        message: 'Amount should be Numeric characters'
                      },
                      stringLength: 
                        {
                        max: 8,
                        min: 2,
                        message: 'Amount should be 2-8 characters'
                        }
                    }

                },
				 nps_file:
                {
                    validators: 
                    {
						 notEmpty: 
                      {
                       message: 'File is Manditory'
                      },
	                file: {
                        extension: 'zip,pdf',
                        type: 'application/pdf,application/zip',
                        maxSize: 2048 * 1024,
                        message: 'Pdf and Zip files allowed And Size Must be less than 2MB'
                        }
                    }

                },
				 medical_premium_amount:
                {
                    validators: 
                    {
                      regexp: 
                      {
                        regexp: "^[1-9][0-9]*$",
                        message: 'Amount should be Numeric characters'
                      },
                      stringLength: 
                        {
                        max: 8,
                        min: 2,
                        message: 'Amount should be 2-8 characters'
                        }
                    }

                },
				medical_premium_file:
                {
                    validators: 
                    {
						 notEmpty: 
                      {
                       message: 'File is Manditory'
                      },
	                file: {
                        extension: 'zip,pdf',
                        type: 'application/pdf,application/zip',
                        maxSize: 2048 * 1024,
                        message: 'Pdf and Zip files allowed And Size Must be less than 2MB'
                        }
                    }

                },
				  expenditure_amount:
                {
                    validators: 
                    {
                      regexp: 
                      {
                        regexp: "^[1-9][0-9]*$",
                        message: 'Amount should be Numeric characters'
                      },
                      stringLength: 
                        {
                        max: 8,
                        min: 2,
                        message: 'Amount should be 2-8 characters'
                        }
                    }

                },
				 expenditure_file:
                {
                    validators: 
                    {
						 notEmpty: 
                      {
                       message: 'File is Manditory'
                      },
	                file: {
                        extension: 'zip,pdf',
                        type: 'application/pdf,application/zip',
                        maxSize: 2048 * 1024,
                        message: 'Pdf and Zip files allowed And Size Must be less than 2MB'
                        }
                    }

                },
				 medical_exp_amount:
                {
                    validators: 
                    {
                      regexp: 
                      {
                        regexp: "^[1-9][0-9]*$",
                        message: 'Amount should be Numeric characters'
                      },
                      stringLength: 
                        {
                        max: 8,
                        min: 2,
                        message: 'Amount should be 2-8 characters'
                        }
                    }

                },
				medical_exp_file:
                {
                    validators: 
                    {
						 notEmpty: 
                      {
                       message: 'File is Manditory'
                      },
	                file: {
                        extension: 'zip,pdf',
                        type: 'application/pdf,application/zip',
                        maxSize: 2048 * 1024,
                        message: 'Pdf and Zip files allowed And Size Must be less than 2MB'
                        }
                    }

                },
				  edu_loan_amount:
                {
                    validators: 
                    {
                      regexp: 
                      {
                        regexp: "^[1-9][0-9]*$",
                        message: 'Amount should be Numeric characters'
                      },
                      stringLength: 
                        {
                        max: 8,
                        min: 2,
                        message: 'Amount should be 2-8 characters'
                        }
                    }

                },
				 edu_loan_file:
                {
                    validators: 
                    {
						 notEmpty: 
                      {
                       message: 'File is Manditory'
                      },
	                file: {
                        extension: 'zip,pdf',
                        type: 'application/pdf,application/zip',
                        maxSize: 2048 * 1024,
                        message: 'Pdf and Zip files allowed And Size Must be less than 2MB'
                        }
                    }

                },
				 certain_funds_amount:
                {
                    validators: 
                    {
                      regexp: 
                      {
                        regexp: "^[1-9][0-9]*$",
                        message: 'Amount should be Numeric characters'
                      },
                      stringLength: 
                        {
                        max: 8,
                        min: 2,
                        message: 'Amount should be 2-8 characters'
                        }
                    }

                },
				certain_funds_file:
                {
                    validators: 
                    {
						 notEmpty: 
                      {
                       message: 'File is Manditory'
                      },
	                file: {
                        extension: 'zip,pdf',
                        type: 'application/pdf,application/zip',
                        maxSize: 2048 * 1024,
                        message: 'Pdf and Zip files allowed And Size Must be less than 2MB'
                        }
                    }

                },
		          disability_ben_amount:
                {
                    validators: 
                    {					
                      regexp: 
                      {
                        regexp: "^[1-9][0-9]*$",
                        message: 'Amount should be Numeric characters'
                      },
                      stringLength: 
                        {
                        max: 8,
                        min: 2,
                        message: 'Amount should be 2-8 characters'
                        }
                    }

                },
				disability_ben_file:
                {
                    validators: 
                    {
						 notEmpty: 
                      {
                       message: 'File is Manditory'
                      },
	                file: {
                        extension: 'zip,pdf',
                        type: 'application/pdf,application/zip',
                        maxSize: 2048 * 1024,
                        message: 'Pdf and Zip files allowed And Size Must be less than 2MB'
                        }
                    }

                },
				  vehical_loan_amount:
                {
                    validators: 
                    {
                      regexp: 
                      {
                        regexp: "^[1-9][0-9]*$",
                        message: 'Amount should be Numeric characters'
                      },
                      stringLength: 
                        {
                        max: 8,
                        min: 2,
                        message: 'Amount should be 2-8 characters'
                        }
                    }

                },
				 vehical_loan_file:
                {
                    validators: 
                    {
						 notEmpty: 
                      {
                       message: 'File is Manditory'
                      },
	                file: {
                        extension: 'zip,pdf',
                        type: 'application/pdf,application/zip',
                        maxSize: 2048 * 1024,
                        message: 'Pdf and Zip files allowed And Size Must be less than 2MB'
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
        <li class="active"><a href="#">Tax Calculator</a></li>
    </ul>
    <div class="page-header">           
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Add Investment Details</h1>
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
                            <span class="panel-title">INVESTMENT DESCRIPTION </span>
                    </div>
                    <div class="panel-body">
                        <div class="table-info">                            
                            <?php //if(in_array("Add", $my_privileges)) { ?>
                            <form id="form" name="form" action="<?=base_url($currentModule.'/tax_calculator_submit')?>" method="POST" enctype="multipart/form-data" onsubmit="return submitForm();">
							
                                 <div class="form-group">
                                    <label class="col-sm-3">Financial Year </label>
									<div class="col-sm-2"><input type="text" id="financial_year" name="financial_year" class="form-control" value="<?=FINANCIAL_YEAR?>" readonly>
									</div>
                                </div>
								
								<div class="form-group">
								<label class="col-sm-3">Gross Salary</label>
								<div class="col-sm-2"><input type="text" id="gross_sal"  class="form-control" value="<?=$tot_gross?>" readonly>
								</div>
								</div>
                                <div class="form-group">
                                    <label class="col-sm-3">House Rent </br><span id="lb"> (Relief provided against submission Rent agreement. If rent agreement is not available Please attach Rent Self Declaration & Declaration from Landlord)</span></label>
									<div class="col-sm-2"><input type="text" id="house_rent_amount" name="house_rent_amount" class="form-control" oninput="file_valid('house_rent_amount')"  placeholder="Enter Amount" >
									</div>	
                                    <div class="col-sm-3" id="house_rent_file_div"><input type="file" id="house_rent_file" name="house_rent_file" class="form-control" placeholder="Select File">
									</div>                                    		
                                </div>
                                 <div class="form-group">
                                    <label class="col-sm-3">Interest on Housing Loan</br><span id="lb">(Maximum Limit for Self Occupied Property Rs. 200,000/- (before 1-4-1999) & Rs. 1,50,000/-(from 1-4-1999) (Submit Certificate received from Financial Institution/ Banks immediately). OWNERSHIP : JOINT OR SOLE)</span></label>
									<div class="col-sm-2"><input type="text" id="house_loan_interest_amount" name="house_loan_interest_amount" oninput="file_valid('house_loan_interest_amount')" class="form-control"  placeholder="Enter Amount" >
									</div>
                                    <div class="col-sm-3" id="house_loan_interest_file_div"><input type="file" id="house_loan_interest_file" name="house_loan_interest_file" class="form-control" placeholder="Select File">
									</div>                                  			
                                </div>
								 <div class="form-group">
                                    <label class="col-sm-3">A) VPF Contribution</label>                                  
                                    <div class="col-sm-2"><input type="text" id="vpf_amount" name="vpf_amount" class="form-control"  placeholder="Enter Amount" oninput="file_valid('vpf_amount')" ></div>	
									<div class="col-sm-3" id="vpf_file_div"><input type="file" id="vpf_file" name="vpf_file" class="form-control" placeholder="Select File">
									</div> 
											
                                </div>
								 <div class="form-group">
                                    <label class="col-sm-3">B) Public Provident Fund (PPF)</label>
                                    <div class="col-sm-2"><input type="text" id="provident_fund_amount" name="provident_fund_amount" class="form-control" oninput="file_valid('provident_fund_amount')" placeholder="Enter Amount" >
									</div>	
                                     <div class="col-sm-3" id="provident_fund_file_div"><input type="file" id="provident_fund_file" name="provident_fund_file" class="form-control" placeholder="Select File">
									</div> 									
                                </div>
								 <div class="form-group">
                                    <label class="col-sm-3">C) Senior Citizen’s Saving Scheme (SCSS)</label>
                                    <div class="col-sm-2"><input type="text" id="scss_amount" name="scss_amount" class="form-control" oninput="file_valid('scss_amount')" placeholder="Enter Amount" >
									</div>	
                                    <div class="col-sm-3" id="scss_file_div"><input type="file" id="scss_file" name="scss_file" class="form-control" placeholder="Select File">
                                </div>
								</div>
								 <div class="form-group">
                                    <label class="col-sm-3">D) N.S.C (Investment + accrued Interest before Maturity Year)</label>
                                    <div class="col-sm-2"><input type="text" id="nsc_amount" name="nsc_amount" oninput="file_valid('nsc_amount')" class="form-control"  placeholder="Enter Amount" >
									</div>
                                     <div class="col-sm-3" id="nsc_file_div"><input type="file" id="nsc_file" name="nsc_file" class="form-control" placeholder="Select File">
									</div>									
                                </div>
								 <div class="form-group">
                                    <label class="col-sm-3">E) Tax Saving Fixed Deposit (5 Years and above)</label>  
                                    <div class="col-sm-2"><input type="text" id="txfd_amount" name="txfd_amount" class="form-control" oninput="file_valid('txfd_amount')" placeholder="Enter Amount" >
									</div>	
                                      <div class="col-sm-3" id="txfd_file_div"><input type="file" id="txfd_file" name="txfd_file" class="form-control" placeholder="Select File">
									</div>									
                                </div>
								 <div class="form-group">
                                    <label class="col-sm-3">F) Tax Savings Bonds</label>
                                    <div class="col-sm-2"><input type="text" id="tax_bond_amount" name="tax_bond_amount" class="form-control" oninput="file_valid('tax_bond_amount')" placeholder="Enter Amount" >
									</div>	
                                    <div class="col-sm-3" id="tax_bond_file_div"><input type="file" id="tax_bond_file" name="tax_bond_file" class="form-control" placeholder="Select File">
									</div>									
                                </div>
								 <div class="form-group">
                                    <label class="col-sm-3">G) E.L.S.S (Tax Saving Mutual Fund)</label> 
                                    <div class="col-sm-2"><input type="text" id="elss_amount" name="elss_amount" class="form-control" oninput="file_valid('elss_amount')" placeholder="Enter Amount" >
									</div>	
                                    <div class="col-sm-3" id="elss_file_div"><input type="file" id="elss_file" name="elss_file" class="form-control" placeholder="Select File">
									</div>									
                                </div>
								 <div class="form-group">
                                    <label class="col-sm-3">H) Life Insurance Premiums</label> 
                                    <div class="col-sm-2"><input type="text" id="life_ins_prem_amount" name="life_ins_prem_amount" class="form-control" oninput="file_valid('life_ins_prem_amount')"  placeholder="Enter Amount" >
									</div>	
                                    <div class="col-sm-3" id="life_ins_prem_file_div"><input type="file" id="life_ins_prem_file" name="life_ins_prem_file" class="form-control" placeholder="Select File">
									</div>									
                                </div>
								 <div class="form-group">
                                    <label class="col-sm-3">I) New Pension Scheme (NPS)</br> (u/s 80CCC)</label> 
                                    <div class="col-sm-2"><input type="text" id="nps_80c_amount" name="nps_80c_amount" class="form-control" oninput="file_valid('nps_80c_amount')" placeholder="Enter Amount" >
									</div>	
                                    <div class="col-sm-3" id="nps_80c_file_div"><input type="file" id="nps_80c_file" name="nps_80c_file" class="form-control" placeholder="Select File">
									</div>									
                                </div>
								 <div class="form-group">
                                    <label class="col-sm-3">J) Pension Plan from Insurance Companies/Mutual Funds (u/s 80CCC)</label>
                                    <div class="col-sm-2"><input type="text" id="pension_plan_amount" name="pension_plan_amount" class="form-control" oninput="file_valid('pension_plan_amount')" placeholder="Enter Amount" >
									</div>	
                                    <div class="col-sm-3" id="pension_plan_file_div"><input type="file" id="pension_plan_file" name="pension_plan_file" class="form-control" placeholder="Select File">
									</div> 									
                                </div> <div class="form-group">
                                    <label class="col-sm-3">K) 80 CCD Central Govt. Employees Pension Plan (u/s 80CCD)</label> 
                                    <div class="col-sm-2"><input type="text" id="emp_pension_amount" name="emp_pension_amount" class="form-control" oninput="file_valid('emp_pension_amount')" placeholder="Enter Amount" >
									</div>	
                                    <div class="col-sm-3" id="emp_pension_file_div"><input type="file" id="emp_pension_file" name="emp_pension_file" class="form-control" placeholder="Select File">
									</div>									
                                </div> <div class="form-group">
                                    <label class="col-sm-3">L) Housing. Loan (Principal Repayment)</label>
                                    <div class="col-sm-2"><input type="text" id="houseloan_prin_repay_amount" name="houseloan_prin_repay_amount" oninput="file_valid('houseloan_prin_repay_amount')" class="form-control"  placeholder="Enter Amount" >
									</div>	
                                    <div class="col-sm-3" id="houseloan_prin_repay_file_div"><input type="file" id="houseloan_prin_repay_file" name="houseloan_prin_repay_file" class="form-control" placeholder="Select File">
									</div> 									
                                </div>
								 <div class="form-group">
                                    <label class="col-sm-3">M) Sukanya Samriddhi Account</label> 
                                    <div class="col-sm-2"><input type="text" id="suk_sam_acc_amount" name="suk_sam_acc_amount" class="form-control" oninput="file_valid('suk_sam_acc_amount')" placeholder="Enter Amount" >
									</div>
                                    <div class="col-sm-3" id="suk_sam_acc_file_div"><input type="file" id="suk_sam_acc_file" name="suk_sam_acc_file" class="form-control" placeholder="Select File">
									</div>									
                                </div>
								 <div class="form-group">
                                    <label class="col-sm-3">N) Stamp Duty & Registration Charges</label> 
                                    <div class="col-sm-2"><input type="text" id="stamp_duty_amount" name="stamp_duty_amount" class="form-control" oninput="file_valid('stamp_duty_amount')" placeholder="Enter Amount" >
									</div>	
                                    <div class="col-sm-3" id="stamp_duty_file_div"><input type="file" id="stamp_duty_file" name="stamp_duty_file" class="form-control" placeholder="Select File">
									</div>									
                                </div>
								 <div class="form-group">
                                    <label class="col-sm-3">O) Tuition fees for 2 children</label> 
                                    <div class="col-sm-2"><input type="text" id="tuition_fee_amount" name="tuition_fee_amount" class="form-control" oninput="file_valid('tuition_fee_amount')" placeholder="Enter Amount" >
									</div>	
                                    <div class="col-sm-3" id="tuition_fee_file_div"><input type="file" id="tuition_fee_file" name="tuition_fee_file" class="form-control" placeholder="Select File">
									</div>									
                                </div>
								 <div class="form-group">
                                    <label class="col-sm-3">P) OTHER (PLEASE SPECIFY)</label> 
                                    <div class="col-sm-2"><input type="text" id="other_amount" name="other_amount" class="form-control" oninput="file_valid('other_amount')"   placeholder="Enter Amount" >
									</div>
                                    <div class="col-sm-3" id="other_file_div"><input type="file" id="other_file" name="other_file" class="form-control" placeholder="Select File">
									</div>									
                                </div>
								 <div class="form-group">
                                    <label class="col-sm-3">New Pension Scheme (NPS)</label> 
                                    <div class="col-sm-2"><input type="text" id="nps_amount" name="nps_amount" oninput="file_valid('nps_amount')" class="form-control"  placeholder="Enter Amount" >
									</div>	
                                    <div class="col-sm-3" id="nps_file_div"><input type="file" id="nps_file" name="nps_file" class="form-control" placeholder="Select File">
									</div>									
                                </div>
								 <div class="form-group">
                                    <label class="col-sm-3">MEDICAL PREMIUM (80D)</br><span id="lb">(For Self, Spouse, Dependent Childred & Parents) Max Rs. 25,000/ - & Rs. 50,000/- in case of premium on the health of Dependents above 65 years old otherwise of Rs. 25,000/-  </span></label>
                                    <div class="col-sm-2"><input type="text" id="medical_premium_amount" name="medical_premium_amount" oninput="file_valid('medical_premium_amount')" class="form-control"  placeholder="Enter Amount" >
									</div>	
                                    <div class="col-sm-3" id="medical_premium_file_div"><input type="file" id="medical_premium_file" name="medical_premium_file" class="form-control" placeholder="Select File">
									</div> 									
                                </div>
								 <div class="form-group">
                                    <label class="col-sm-3">EXPENDITURE ON HANDICAPPED DEPENDENTS</br><span id="lb">(Deposit made for maintenance of handicapped Dependents (LIC, UTI etc.) Adhoc amount of Rs. 75,000/- & disability exceeding 80% the deduction will be Rs. 125,000/- (attach Govt. hospital medical certificate))</span></label>
                                    <div class="col-sm-2"><input type="text" id="expenditure_amount" name="expenditure_amount" class="form-control" oninput="file_valid('expenditure_amount')" placeholder="Enter Amount" >
									</div>	
                                    <div class="col-sm-3" id="expenditure_file_div"><input type="file" id="expenditure_file" name="expenditure_file" class="form-control" placeholder="Select File">
									</div> 									
                                </div>
							   <div class="form-group">
                                    <label class="col-sm-3">MEDICAL EXPENSES</br><span id="lb">(proposed to be incurred ON SPECIFIED DISEASES (Bill to be submitted by 31-12-2023) {AIDS, Cancer, Thalassaemia, Hemophilia, Chronic Renal Failure, Chronic Nero-logical Diseases) Max Rs. 40,000/- & Rs. 1,00,000/- in case aged above 65 years. (attach Govt. hospitals Medical Certificate)</span></label> 
                                    <div class="col-sm-2"><input type="text" id="medical_exp_amount" name="medical_exp_amount" class="form-control" oninput="file_valid('medical_exp_amount')" placeholder="Enter Amount" >
									</div>	
                                    <div class="col-sm-3" id="medical_exp_file_div"><input type="file" id="medical_exp_file" name="medical_exp_file" class="form-control" placeholder="Select File">
									</div>									
                                </div>
								 <div class="form-group">
                                    <label class="col-sm-3">INTEREST ON EDUCATION LOAN </br>(for self education)</label>
                                    <div class="col-sm-2"><input type="text" id="edu_loan_amount" name="edu_loan_amount" class="form-control"  oninput="file_valid('edu_loan_amount')"  placeholder="Enter Amount" >
									</div>	
                                    <div class="col-sm-3" id="edu_loan_file_div"><input type="file" id="edu_loan_file" name="edu_loan_file" class="form-control" placeholder="Select File">
									</div> 									
                                </div>
								 <div class="form-group">
                                    <label class="col-sm-3">DONATION TO CERTAIN FUNDS</br> (as prescribed by GOI )</br><span id="lb">- please specify separately</span></label> 
                                    <div class="col-sm-2"><input type="text" id="certain_funds_amount" name="certain_funds_amount" class="form-control" oninput="file_valid('certain_funds_amount')" placeholder="Enter Amount" >
									</div>	
                                    <div class="col-sm-3" id="certain_funds_file_div"><input type="file" id="certain_funds_file" name="certain_funds_file" class="form-control" placeholder="Select File">
									</div>									
                                </div>
								 <div class="form-group">
                                    <label class="col-sm-3">PERMANENT DISABILITY BENEFIT(SELF)</br><span id="lb">(Adhoc deduction of Rs. 75,000/- & Rs. 125,000/- in case of disability exceeding 80% (attach Govt. Hospital Medical Certificate)</span></label> 
                                    <div class="col-sm-2"><input type="text" id="disability_ben_amount" name="disability_ben_amount" oninput="file_valid('disability_ben_amount')" class="form-control"  placeholder="Enter Amount" >
									</div>	
                                    <div class="col-sm-3" id="disability_ben_file_div"><input type="file" id="disability_ben_file" name="disability_ben_file" class="form-control" placeholder="Select File">
									</div>									
                                </div>
								 <div class="form-group">
                                    <label class="col-sm-3">Interest on First Electric Vehicle and Loan taken in 2019 - 2023?</label>
                                    <div class="col-sm-2"><input type="text" id="vehical_loan_amount" name="vehical_loan_amount" class="form-control" oninput="file_valid('vehical_loan_amount')" placeholder="Enter Amount" >
									</div>	
                                    <div class="col-sm-3" id="vehical_loan_file_div"><input type="file" id="vehical_loan_file" name="vehical_loan_file" class="form-control" placeholder="Select File">
									</div> 									
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-2">
                                        <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Submit</button>
                                    </div>                                    
                                    <div class="col-sm-2"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule)?>/tax_calculator_view'">Cancel</button></div>
                                    <div class="col-sm-4"></div>
                                </div>
                              </form>
                            <?php //} ?>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </div>
</div>
<script>
$(document).ready(function(){
	var chrt="vehical_loan_amount";
      var m=chrt.slice(0, -6)
	   $("input[type='file']").hide();   
});
function file_valid(id)
{
	var amount=$("#"+id+"").val();
    if(amount !='' && amount > 10)
	{
		var id=id.slice(0,-6);
	     id=id+'file';
		$("#"+id+"").show();
		 id=id+'_div';
	   $("#"+id+"").show();
	}
	else
	{	
		var id=id.slice(0,-6);
	     id=id+'file';
	   $("#"+id+"").hide();
	   $("#"+id+"").val('');
	   id=id+'_div';
	   $("#"+id+"").hide();
	}
}
function submitForm(){
    var vehical_loan_amount=$("#vehical_loan_amount").val();
    var disability_ben_amount=$("#disability_ben_amount").val();
	var certain_funds_amount=$("#certain_funds_amount").val();
	var edu_loan_amount=$("#edu_loan_amount").val();
	var medical_exp_amount=$("#medical_exp_amount").val();
	var expenditure_amount=$("#expenditure_amount").val();
	var medical_premium_amount=$("#medical_premium_amount").val();
	var nps_amount=$("#nps_amount").val();
	var other_amount=$("#other_amount").val();
	var tuition_fee_amount=$("#tuition_fee_amount").val();
	var stamp_duty_amount=$("#stamp_duty_amount").val();
	var suk_sam_acc_amount=$("#suk_sam_acc_amount").val();
	var houseloan_prin_repay_amount=$("#houseloan_prin_repay_amount").val();
	var emp_pension_amount=$("#emp_pension_amount").val();
	var pension_plan_amount=$("#pension_plan_amount").val();
	var nps_80c_amount=$("#nps_80c_amount").val();
	var life_ins_prem_amount=$("#life_ins_prem_amount").val();
	var elss_amount=$("#elss_amount").val();
	var tax_bond_amount=$("#tax_bond_amount").val();
	var txfd_amount=$("#txfd_amount").val();
	var nsc_amount=$("#nsc_amount").val();
	var scss_amount=$("#scss_amount").val();
	var provident_fund_amount=$("#provident_fund_amount").val();
	var vpf_amount=$("#vpf_amount").val();
	var house_loan_interest_amount=$("#house_loan_interest_amount").val();
	var house_rent_amount=$("#house_rent_amount").val();
	 if(vehical_loan_amount=='' && disability_ben_amount=='' &&  certain_funds_amount=='' && edu_loan_amount=='' && medical_exp_amount=='' && expenditure_amount=='' && medical_premium_amount=='' && nps_amount=='' && other_amount=='' && tuition_fee_amount=='' && stamp_duty_amount=='' && suk_sam_acc_amount==''  && houseloan_prin_repay_amount=='' && emp_pension_amount=='' && pension_plan_amount=='' && nps_80c_amount=='' && life_ins_prem_amount=='' && elss_amount=='' && tax_bond_amount=='' && txfd_amount=='' && nsc_amount=='' && scss_amount=='' && provident_fund_amount=='' && vpf_amount=='' && house_loan_interest_amount=='' &&
	 house_rent_amount=='')
	 { 	   
		 alert("Atleast One Field required.");
		 $('#btn_submit').attr('disabled',false);
		 return false;
		 
	 }
	 else
	 {
		return true;
	 }
	 
  };
</script>