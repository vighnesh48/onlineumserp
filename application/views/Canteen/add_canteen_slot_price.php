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
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Add Canteen Slot and Price </h1>
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
                        <span class="panel-title">Add Canteen Slot & Price</span>
						
						<span id="message" style="color:red;padding-left:200px;"></span>
                        <div class="holder"></div>
					</div>
                    <div class="panel-body">
                        <div class="table-info">                            
                            
                            <form id="form" name="form" action="<?=base_url($currentModule.'/save_canteen_slot_price')?>" method="POST" onsubmit="return form_check_exists(event)">                                                               
                                <!-- <input type="hidden" value="" id="canteen_slot_id" name="canteen_slot_id" /> -->
								
								<div class="form-group">
                                    
									<div class="col-sm-4">
									<label>Select Canteen <?=$astrik?></label>
                                    <?php //if(!isset($canteen_id['allocated_id'])){ ?>
									<select name="canteen_name" id="canteen_name" class="form-control" required >
										<option value="">-- Select Canteen --</option>
										<?php foreach ($canteen_details as $key => $value) { ?>
											<option value="<?=$value['id']?>" ><?=$value['cName']?></option>
											<?php } ?>
									</select>
                                    <?php //} ?>
								   
										<span style="color:red;"><?php echo form_error('hostel_type');?></span>										
                                    </div>
                                    
                                    <div class="col-sm-4">
									<label>Select Meal <?=$astrik?></label>
                                        <select id="canteen_mtype" name="canteen_mtype" class="form-control" required >
                                            <option value="">Select Meal Type</option>
                                          
                                            <option value="B">Breakfast</option>
                                             <option value="L">Lunch</option>
                                             <option value="D">Dinner</option>
                                        </select>   
										<span style="color:red;"><?php //echo form_error('hostel_type');?></span>										
                                    </div>
                                
									 
                                </div>
                                <div class="form-group">
                                    
                                <div class="col-sm-4">
                                    <label>Select From Time <?=$astrik?></label>
                                    <select id="canteen_from_time" name="canteen_from_time" class="form-control" required >
                                        <option value="">From Time</option>
                                        <?php
                                            // Generate time options dynamically
                                            for ($hour = 0; $hour < 24; $hour++) {
                                                for ($minute = 0; $minute < 60; $minute += 30) { // Interval of 30 minutes
                                                    $time = sprintf('%02d:%02d', $hour, $minute);
                                                    echo "<option value='$time'>$time</option>";
                                                }
                                            }
                                        ?>
                                    </select>
                                    <span style="color:red;"><?php echo form_error('from_time');?></span>
                                </div>
                                    
                                <div class="col-sm-4">
                                    <label>Select To Time <?=$astrik?></label>
                                    <select id="canteen_to_time" name="canteen_to_time" class="form-control" required >
                                        <option value="">To Time</option>
                                        <?php
                                            // Generate time options dynamically
                                            for ($hour = 0; $hour < 24; $hour++) {
                                                for ($minute = 0; $minute < 60; $minute += 30) { // Interval of 30 minutes
                                                    $time = sprintf('%02d:%02d', $hour, $minute);
                                                    echo "<option value='$time'>$time</option>";
                                                }
                                            }
                                        ?>
                                    </select>
                                    <span style="color:red;"><?php echo form_error('from_time');?></span>
                                </div>

                                <div class="col-sm-4">
                                    <label>Enter Price <?=$astrik?></label>
                                    <input type="number" class="form-control" name="canteen_price" id="canteen_price" placeholder="Enter Price" min="0" step="0.01" required>  
                                    <span style="color:red;"><?php echo form_error('canteen_price');?></span>										
                                </div>
                                
									 
                                </div>
								
							  
							 <div class="form-group">
                                    
                                    <div class="col-sm-2">
                                        <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Submit</button>                                        
                                    </div>                                    
                                    <div class="col-sm-2"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule)?>/canteen_slot_price'">Cancel</button></div> 
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

<script>
    function form_check_exists(event) {
        // Get the selected values for from time and to time
        var fromTime = document.getElementById('canteen_from_time').value;
        var toTime = document.getElementById('canteen_to_time').value;

        // Check if both times are selected
        if (fromTime === "" || toTime === "") {
            alert("Please select both 'From Time' and 'To Time'.");
            return false;
        }

        // Convert times to Date objects for comparison
        var fromTimeObj = new Date("1970-01-01 " + fromTime);
        var toTimeObj = new Date("1970-01-01 " + toTime);

        // Check if 'From Time' is less than 'To Time'
        if (fromTimeObj >= toTimeObj) {
            alert("'From Time' must be earlier than 'To Time'.");
            return false;
        }

        // If the validation passes, submit the form
        return true;
    }
</script>



