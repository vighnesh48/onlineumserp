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
                academic_year:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Academic Year should not be empty'
                      }
                    }

                },
                amount:
                {
                      validators: 
                    {
						notEmpty: 
                      {
                       message: 'Amount should not be empty'
                      },
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
				  from_month:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Month should not be empty'
                      }
                    }

                },
            }       
        })
    });
</script>
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>'; 
     if(isset($_SESSION['status']))
    {
        ?>
			<script>
			//alert("Your Details already Submitted.");
			var status="<?php echo $_SESSION['status'] ?>";
			 alert(status);
			</script>
        <?php 
        unset($_SESSION['status']);
       }
   ?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="#"><?php if(empty($incre_det)){ ?>Add Increment <?php }else{?>Edit Increment <?php }?></a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;<?php if(empty($incre_det)){ ?>Add Increment <?php }else{?>Edit Increment <?php }?></h1>
		    <div class="col-xs-12 col-sm-8">
                <div class="row"> 
					 <hr class="visible-xs no-grid-gutter-h">
					  <div class="pull-right col-xs-12 col-sm-auto"><a style="width: 100%;" class="btn btn-primary btn-labeled" href="<?php echo base_url('staff_payment/staff_basic_salary_increment_detview'); ?>"><span class="btn-label icon fa fa-plus"></span>View Increment</a></div>
                    <div class="visible-xs clearfix form-group-margin"></div>
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
                            <span class="panel-title">Increment Details</span>
                    </div>
                    <div class="panel-body">
                        <div class="table-info">                            
                            <?php //if(in_array("Add", $my_privileges)) { ?>
				<?php if(empty($incre_det)){ ?>
                    <form id="form" name="form" action="<?=base_url($currentModule.'/save_increment')?>" method="POST">
				<?php }else{ ?>	
				<form id="form" name="form" action="<?=base_url($currentModule.'/update_increment')?>" method="POST">
				<input type="hidden" id="eid" name="eid" value="<?=$incre_det[0]['id']?>" />
				<input type="hidden" id="emp_id" name="emp_id" value="<?=$incre_det[0]['emp_id']?>" />
				<?php } ?>				
                            <div class="form-group">
                                    <label class="col-sm-3">Employee<?=$astrik?></label>
                                    <div class="col-sm-4"><select name="emp_id" class="form-control" id='emp_id' <?php if(!empty($incre_det)){echo 'disabled'; }?>>
									 <option value="">Select Employee</option>
                                     <?php
									  foreach($emp_list as $row){?>
									<option value="<?php echo $row['emp_id']?>"<?php if($row['emp_id']==$incre_det[0]['emp_id']){ echo 'selected'; }elseif($row['emp_id']==$emp_id){ echo 'selected'; }else{} ?>
									><?php echo $row['emp_id'].' - '.$row['fname'].' '.$row['lname'];?></option>
                                     <?php } ?> 
									  </select></div>
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('emp_id');?></span></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3">Academic Year<?=$astrik?></label>                                    
                                    <div class="col-sm-4"><select name="academic_year" class="form-control" id='academic_year'>
									 <option value="">Select Year</option>
									 <option selected="" value="2024-25"<?php if($incre_det[0]['academic_year']=="2024-25"){ echo 'selected'; } ?>>2024-25</option>
									  <option value="2023-24"<?php if($incre_det[0]['academic_year']=="2023-24"){ echo 'selected'; } ?>>2023-24</option></select></div>
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('acad_year');?></span></div>
                                </div>  
                              <div class="form-group">
                                    <label class="col-sm-3">Increment Amount<?=$astrik?></label>                                    
                                    <div class="col-sm-4"><input type="text" id="amount" name="amount" class="form-control" value="<?=$incre_det[0]['amount']?>" /></div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('acad_year');?></span></div>
                                </div>
                              <div class="form-group">
                                    <label class="col-sm-3">Valid From Month<?=$astrik?></label>                                    
                                    <div class="col-sm-4"><input id="dob-datepicker" required="" class="form-control form-control-inline  date-picker" name="from_month" placeholder="Enter Month" type="text" value="<?=$incre_det[0]['from_month']?>"></div>
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('acad_year');?></span></div>
                                </div>								
                                <div class="form-group">
                                    <div class="col-sm-4"></div>
                                    <div class="col-sm-1">
                                        <button class="btn btn-primary form-control" id="btn_submit" type="submit" ><?php if(empty($incre_det)){?>Submit<?php }else{?>Update<?php }?></button>
                                    </div>                                    
                                    <div class="col-sm-1"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule)?>/staff_basic_salarydetails/<?=$emp_id;?>'">Cancel</button></div>
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
/*     $('#dob-datepicker').datepicker( {
      format: "yyyy-m",startView: "months",minViewMode: "months",autoclose:true}
                                  ); */
	$('#dob-datepicker').datepicker( {format: 'dd-mm-yyyy',autoclose:true,endDate: new Date()});
  });
</script>