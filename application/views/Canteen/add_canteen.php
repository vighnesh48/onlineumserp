<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<style>
.panel-heading {
    color: #8a6d3b;
    background-color: #fcf8e3;
    border-color: #faebcc;
}
</style>


<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
   //echo "<pre>";
   //echo $total_fees['fee_paid'];
 // print_r($student_details);
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="<?=base_url($currentModule)?>">Canteen </a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Add Canteen </h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row"> 
						<br/>				
					<span id="flash-messages" style="color:Green;padding-left:50px;">
						 <?php if(!empty($this->session->flashdata('message_canteen_1'))){ echo $this->session->flashdata('message_canteen_1'); } ?></span>
					<span id="flash-message" style="color:red;padding-left:50px;">
						 <?php if(!empty($this->session->flashdata('message_canteen_2'))){ echo $this->session->flashdata('message_canteen_2'); } ?></span>
                    <hr class="visible-xs no-grid-gutter-h">
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-heading">
                        <span class="panel-title">Add Canteen </span>
						
						<span id="message" style="color:red;padding-left:200px;"></span>
                        <div class="holder"></div>
					</div>
                    <div class="panel-body">
                        <div class="table-info">                            
                            
                            <form id="form" name="form" action="<?=base_url($currentModule.'/save_canteen')?>" method="POST" onsubmit="return form_check_exists(event)">                                                               
                                <!-- <input type="hidden" value="" id="canteen_slot_id" name="canteen_slot_id" /> -->
								
								<div class="form-group">
                                    
									<div class="col-sm-4">
									    <label>Canteen Name <?=$astrik?></label>
                                        <input type="text" class="form-control" name="cName" id="cName" placeholder="Enter Canteen Name" required>
										<span style="color:red;"><?php echo form_error('cName');?></span>										
                                    </div>
                                    
                                    <div class="col-sm-4">
									    <label>Canteen Contact No. <?=$astrik?></label>
                                        <input type="text" class="form-control" name="cPhone" id="cPhone" placeholder="Enter Canteen Contact No." required>
										<span style="color:red;"><?php echo form_error('cPhone');?></span>										
                                    </div>

                                    <div class="col-sm-4">
								    	<label>Canteen Code. <?=$astrik?></label>
                                        <input type="text" class="form-control" name="cId" id="cId" placeholder="Enter Canteen Code" required>
								    	<span style="color:red;"><?php echo form_error('cId');?></span>										
                                    </div>
                                									 
                                </div>
                                <div class="form-group">

                                    <div class="col-sm-4">
								        <label>Canteen Address <?=$astrik?></label>
                                         <textarea name="cAddress" id="cAddress" class="form-control" placeholder="Enter Canteen Address" required></textarea>
								        <span style="color:red;"><?php echo form_error('cAddress');?></span>										
                                    </div>

                                    <div class="col-sm-4">
                                        <label>Enter Machine ID </label>
                                        <input type="text" class="form-control" name="machine_id" id="machine_id" placeholder="Enter machine ID"  >  
                                        <span style="color:red;"><?php echo form_error('machine_id');?></span>										
                                    </div>

                                </div>
								
							  
							 <div class="form-group">
                                    
                                    <div class="col-sm-2">
                                        <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Submit</button>                                        
                                    </div>                                    
                                    <div class="col-sm-2"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule)?>'">Cancel</button></div> 
									<div class="col-sm-4"></div>
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


