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
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Edit Canteen Slot and Price </h1>
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
                        <span class="panel-title">Update <?= $canteen_name['cName'] ?> Canteen Slot & Price</span>
						
						<span id="message" style="color:red;padding-left:200px;"></span>
                        <div class="holder"></div>
					</div>
                    <div class="panel-body">
                        <div class="table-info">                            
                            
                          <form id="form" name="form" action="<?=base_url($currentModule.'/update_canteen_slot_price')?>" method="POST" onsubmit="return form_check_exists(event)">                                                               
                                <input type="hidden" value="<?=$canteen_encoded_id ?>" id="canteen_id" name="canteen_id" />
								
								<?php if(isset($breakfast_slot_details)){?>  
                            <div class="form-group">

                                <h3>Breakfast Slot Update</h3> <br>
                                    
                                <div class="col-sm-4">
                                    <label>Select From Time <?=$astrik?></label>
                                    <select id="breakfast_from_time" name="breakfast_from_time" class="form-control">
                                        <option value="">From Time</option>
                                        <?php
                                            // Generate time options dynamically
                                            for ($hour = 0; $hour < 24; $hour++) {
                                                for ($minute = 0; $minute < 60; $minute += 30) { // Interval of 30 minutes
                                                    $time = sprintf('%02d:%02d', $hour, $minute);
                                                    $selected = ($breakfast_slot_details['from_time'] == $time) ? 'selected' : '';
                                                    
                                                    echo "<option value='$time' $selected>$time</option>";
                                                    
                                                    
                                                }
                                            }
                                        ?>
                                    </select>
                                    <span style="color:red;"><?php echo form_error('from_time');?></span>
                                </div>
                                    
                                <div class="col-sm-4">
                                    <label>Select To Time <?=$astrik?></label>
                                    <select id="breakfast_to_time" name="breakfast_to_time" class="form-control">
                                        <option value="">To Time</option>
                                        <?php
                                            // Generate time options dynamically
                                            for ($hour = 0; $hour < 24; $hour++) {
                                                for ($minute = 0; $minute < 60; $minute += 30) { // Interval of 30 minutes
                                                    $time = sprintf('%02d:%02d', $hour, $minute);
                                                    $selected = ($breakfast_slot_details['to_time'] == $time) ? 'selected' : '';
                                                    
                                                    echo "<option value='$time' $selected>$time</option>";
                                                    
                                                }
                                            }
                                        ?>
                                    </select>
                                    <span style="color:red;"><?php echo form_error('to_time');?></span>
                                </div>

                                <div class="col-sm-4">
                                    <label>Enter Price <?=$astrik?></label>
                                    <input type="number" class="form-control" name="breakfast_price" id="breakfast_price" value="<?=$breakfast_slot_details['price']?>" placeholder="Enter Price" min="0" step="1" required>  
                                    <span style="color:red;"><?php echo form_error('breakfast_price');?></span>										
                                </div>
									 
                            </div>
                                <?php } ?>
                                <br>
                                <?php if(isset($lunch_slot_details)){?>                
                            <div class="form-group">

                                <h3>Lunch Slot Update</h3> <br>

                                <div class="col-sm-4">
                                    <label>Select From Time <?=$astrik?></label>
                                    <select id="lunch_from_time" name="lunch_from_time" class="form-control">
                                        <option value="">From Time</option>
                                        <?php
                                            // Generate time options dynamically
                                            for ($hour = 0; $hour < 24; $hour++) {
                                                for ($minute = 0; $minute < 60; $minute += 30) { // Interval of 30 minutes
                                                    $time = sprintf('%02d:%02d', $hour, $minute);
                                                    $selected = ($lunch_slot_details['from_time'] == $time) ? 'selected' : '';
                                                    
                                                    echo "<option value='$time' $selected>$time</option>";
                                                    
                                                }
                                            }
                                        ?>
                                    </select>
                                    <span style="color:red;"><?php echo form_error('from_time');?></span>
                                </div>
                                        
                                <div class="col-sm-4">
                                    <label>Select To Time <?=$astrik?></label>
                                    <select id="lunch_to_time" name="lunch_to_time" class="form-control">
                                        <option value="">To Time</option>
                                        <?php
                                            // Generate time options dynamically
                                            for ($hour = 0; $hour < 24; $hour++) {
                                                for ($minute = 0; $minute < 60; $minute += 30) { // Interval of 30 minutes
                                                    $time = sprintf('%02d:%02d', $hour, $minute);
                                                    $selected = ($lunch_slot_details['to_time'] == $time) ? 'selected' : '';

                                                    echo "<option value='$time' $selected>$time</option>";
                                                }
                                            }
                                        ?>
                                    </select>
                                    <span style="color:red;"><?php echo form_error('from_time');?></span>
                                </div>
                                        
                                <div class="col-sm-4">
                                    <label>Enter Price <?=$astrik?></label>
                                    <input type="number" class="form-control" name="lunch_price" id="lunch_price" value="<?=$lunch_slot_details['price']?>" placeholder="Enter Price" min="0" step="1" required>  
                                    <span style="color:red;"><?php echo form_error('lunch_price');?></span>										
                                </div>   

                            </div>
                                <?php } ?>
                                <br>
                                <?php if(isset($dinner_slot_details)){?> 
                                <div class="form-group">


                                    <h3>Dinner Slot Update</h3> <br>

                                    <div class="col-sm-4">
                                        <label>Select From Time <?=$astrik?></label>
                                        <select id="dinner_from_time" name="dinner_from_time" class="form-control">
                                            <option value="">From Time</option>
                                            <?php
                                                // Generate time options dynamically
                                                for ($hour = 0; $hour < 24; $hour++) {
                                                    for ($minute = 0; $minute < 60; $minute += 30) { // Interval of 30 minutes
                                                        $time = sprintf('%02d:%02d', $hour, $minute);
                                                        $selected = ($dinner_slot_details['from_time'] == $time) ? 'selected' : '';
                                                        echo "<option value='$time' $selected>$time</option>";
                                                    }
                                                }
                                            ?>
                                        </select>
                                        <span style="color:red;"><?php echo form_error('from_time');?></span>
                                    </div>
                                            
                                    <div class="col-sm-4">
                                        <label>Select To Time <?=$astrik?></label>
                                        <select id="dinner_to_time" name="dinner_to_time" class="form-control">
                                            <option value="">To Time</option>
                                            <?php
                                                // Generate time options dynamically
                                                for ($hour = 0; $hour < 24; $hour++) {
                                                    for ($minute = 0; $minute < 60; $minute += 30) { // Interval of 30 minutes
                                                        $time = sprintf('%02d:%02d', $hour, $minute);
                                                        $selected = ($dinner_slot_details['to_time'] == $time) ? 'selected' : '';
                                                        echo "<option value='$time' $selected>$time</option>";
                                                    }
                                                }
                                            ?>
                                        </select>
                                        <span style="color:red;"><?php echo form_error('from_time');?></span>
                                    </div>
                                            
                                    <div class="col-sm-4">
                                        <label>Enter Price <?=$astrik?></label>
                                        <input type="number" class="form-control" name="dinner_price" id="dinner_price" value="<?=$dinner_slot_details['price']?>" placeholder="Enter Price" min="0" step="0.01" required>  
                                        <span style="color:red;"><?php echo form_error('dinner_price');?></span>										
                                    </div>
                                            
                                            
                                </div>
                                <?php } ?>
								
							  
							 <div class="form-group">
                                    
                                    <div class="col-sm-2">
                                        <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Update</button>                                        
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


