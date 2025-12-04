
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
        <li class="active"><a href="<?=base_url($currentModule)?>">Hostel </a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Allocate Canteen</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                </div>
            </div>
			
			<span id="flash-messages" style="color:Green;padding-left:50px;">
						 <?php if(!empty($this->session->flashdata('message1'))){ echo $this->session->flashdata('message1'); } ?></span>
					<span id="flash-messages" style="color:red;padding-left:50px;">
						 <?php if(!empty($this->session->flashdata('message2'))){ echo $this->session->flashdata('message2'); } ?></span>
        </div>
        <div class="row ">
            <div class="col-sm-12">&nbsp;</div>
        </div>
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-heading">
                        <span class="panel-title">Student Details</span>
                    </div>
                    <div class="panel-body">
                        <div class="table-info">   
						<table class="table table-bordered">
    					<tr>
    					  <th width="17%">PRN No:</th><td width="35%"><?=$student_details['enrollment_no']?></td>
    					  <th width="17%">Institute:</th><td width="35%"><?=$student_details['school_name']?></td>
						</tr>
						<tr>
						  <th scope="col">Student Name:</th><td><?=$student_details['last_name']?> <?=$student_details['first_name']?> <?=$student_details['middle_name']?></td>
						  <th width="15%">Academic Year:</th><td><?= isset($stud_details['academic_year']) ? $stud_details['academic_year'] : '' ?></td>
						</tr>
						<tr>
    					  <th scope="col">Course Name:</th>
					<td id="prgm_id"><?php  if($student_details['course']==NULL)//echo $student_details['course_short_name'].' '.
					echo $student_details['stream_short_name'].$student_details['stream'];else echo $student_details['course'].' '.$student_details['stream']?></td>
    					  <th width="15%">Year:</th><td><?=$student_details['current_year']?></td>
    					</tr>
						<!-- -----------------------------  Addded a dropdown for canteen  ---------------------------- -->
						<tr>
							<form action="<?=base_url($currentModule.'/student_canteen_facility_allocation_edit')?>" method="post" class="form-inline">
								<th>Canteen: (Breakfast, Lunch, Dinner)</th>
								<td><input type="hidden" name="enrollment_no" id="enrollment_no" value="<?=$student_details['enrollment_no']?>" class="form-control">
								<input type="hidden" name="academic_year" id="academic_year" value="<?=$stud_details['academic_year']?>" class="form-control">
								<input type="hidden" name="student_id" id="student_id" value="<?=$this->uri->segment(4)?>" class="form-control">
								<input type="hidden" name="org" id="org" value="<?=$this->uri->segment(5)?>" class="form-control">
								<input type="hidden" name="sffm_id" id="sffm_id" value="3" class="form-control">

								<?php //if(!isset($canteen_id['allocated_id'])){ ?>
								<select name="canteen_name_breakfast" id="canteen_name_breakfast" class="" style="width:49%; height: 30px; focus: blue; padding: 1px; margin-bottom: 3px;">
										<option value="">-- Select Breakfast Canteen --</option>
										<?php foreach ($canteen_details as $key => $value) { ?>
											<option value="<?=$value['id']?>" <?php if($value['id']==$canteen_id_breakfast['allocated_id']) echo "selected" ?>><?=$value['cName']?></option>
											<?php } ?>
									</select>

									<select name="breakfast_location" id="breakfast_location" style="width: 49%; height: 30px; margin-bottom: 3px;">
										<option value="">-- Select Breakfast Location --</option>
									</select>
									<input type="hidden" name="breakfast_location_value" id="breakfast_location_value" value="<?= isset($canteen_id_breakfast['device_location']) ? $canteen_id_breakfast['device_location'] : '' ?>">
									<input type="hidden" name="breakfast_device_id" id="breakfast_device_id" value="<?= isset($canteen_id_breakfast['device_id']) ? $canteen_id_breakfast['device_id'] : '' ?>">
									
									<select name="canteen_name_lunch" id="canteen_name_lunch" class="" style="width: 49%; height: 30px; focus: blue; padding: 1px; margin-bottom: 3px;">
										<option value="">-- Select Lunch Canteen --</option>
										<?php foreach ($canteen_details as $key => $value) { ?>
											<option value="<?=$value['id']?>" <?php if($value['id']==$canteen_id_lunch['allocated_id']) echo "selected" ?>><?=$value['cName']?></option>
											<?php } ?>
									</select>

									<select name="lunch_location" id="lunch_location" style="width: 49%; height: 30px; margin-bottom: 3px;">
										<option value="">-- Select lunch Location --</option>
									</select>
									<input type="hidden" name="lunch_location_value" id="lunch_location_value" value="<?= isset($canteen_id_lunch['device_location']) ? $canteen_id_lunch['device_location'] : '' ?>">
									<input type="hidden" name="lunch_device_id" id="lunch_device_id" value="<?= isset($canteen_id_lunch['device_id']) ? $canteen_id_lunch['device_id'] : '' ?>">
									
									<select name="canteen_name_dinner" id="canteen_name_dinner" class="" style="width: 49%; height: 30px; focus: blue; padding: 1px; margin-bottom: 3px;">
										<option value="">-- Select Dinner Canteen --</option>
										<?php foreach ($canteen_details as $key => $value) { ?>
											<option value="<?=$value['id']?>" <?php if($value['id']==$canteen_id_dinner['allocated_id']) echo "selected" ?>><?=$value['cName']?></option>
											<?php } ?>
									</select>

									<select name="dinner_location" id="dinner_location" style="width: 49%; height: 30px; margin-bottom: 3px;">
										<option value="">-- Select Dinner Location --</option>
									</select>
									<input type="hidden" name="dinner_location_value" id="dinner_location_value" value="<?= isset($canteen_id_dinner['device_location']) ? $canteen_id_dinner['device_location'] : '' ?>">
									<input type="hidden" name="dinner_device_id" id="dinner_device_id" value="<?= isset($canteen_id_dinner['device_id']) ? $canteen_id_dinner['device_id'] : '' ?>">
									<br>
									<button class="btn btn-primary" id="btn_submit" type="submit">Update</button>
								<?php // } 
								// else { 
								// 	 foreach ($canteen_details as $key => $value) { 
								// 		 if($value['id']==$canteen_id['allocated_id']) {
								// 			 echo $value['cName']; 
								// 			 } 

								// 	 }
								// 	 }
									  ?>
								
								</td>
							</form>
						</tr>
						<!-- -----------------------------  End of dropdown for canteen  ---------------------------- -->
						</table>
                      </div>
            

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>var base_url = "<?= base_url(); ?>";</script>

<script>
var base_url = "<?= base_url(); ?>";

// Fetch and populate device locations
function fetchCanteenLocation(canteenSelectId, locationSelectId, preselectedLocation = '') {
    let canteenId = $('#' + canteenSelectId).val();

    if (canteenId === '') {
        $('#' + locationSelectId).html('<option value="">-- Select Location --</option>');
        $('#' + locationSelectId.replace('location', 'device_id')).val('');
        $('#' + locationSelectId.replace('location', 'location_value')).val('');
        return;
    }

    // Step 1: Get canteen name by ID
    $.ajax({
        url: base_url + 'Hostel/getCanteenName/' + canteenId,
        type: 'GET',
        dataType: 'json',
        success: function(res) {
            if (res.success) {
                let canteenName = res.canteen_name;

                // Step 2: Fetch locations from API
                $.ajax({
                    url: base_url + 'Hostel/getCanteenLocations/' + encodeURIComponent(canteenName),
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        let $loc = $('#' + locationSelectId);
                        $loc.empty().append('<option value="">-- Select Location --</option>');

                        if (response.status === true && Array.isArray(response.data)) {
                            $.each(response.data, function(i, item) {
                                let selected = (item.device_location === preselectedLocation) ? 'selected' : '';
                                $loc.append(`<option value="${item.device_location}" data-device="${item.device_id}" ${selected}>${item.device_location}</option>`);
                            });

                            // ✅ If preselected exists, update hidden fields
                            if (preselectedLocation !== '') {
                                let preselectedOption = $loc.find('option:selected');
                                $('#' + locationSelectId.replace('location', 'device_id')).val(preselectedOption.data('device') || '');
                                $('#' + locationSelectId.replace('location', 'location_value')).val(preselectedOption.val() || '');
                            }
                        } else {
                            $loc.append('<option value="">No locations found</option>');
                        }
                    },
                    error: function() {
                        $('#' + locationSelectId).html('<option value="">Failed to load locations</option>');
                    }
                });
            }
        },
        error: function() {
            console.error('Failed to get canteen name');
        }
    });
}

// On change — update hidden fields when user selects location
$('#breakfast_location').change(function() {
    var selectedOption = $(this).find(':selected');
    $('#breakfast_device_id').val(selectedOption.data('device') || '');
    $('#breakfast_location_value').val(selectedOption.val() || '');
});
$('#lunch_location').change(function() {
    var selectedOption = $(this).find(':selected');
    $('#lunch_device_id').val(selectedOption.data('device') || '');
    $('#lunch_location_value').val(selectedOption.val() || '');
});
$('#dinner_location').change(function() {
    var selectedOption = $(this).find(':selected');
    $('#dinner_device_id').val(selectedOption.data('device') || '');
    $('#dinner_location_value').val(selectedOption.val() || '');
});

// Bind dropdown change event for new selections
$('#canteen_name_breakfast').change(function() {
    fetchCanteenLocation('canteen_name_breakfast', 'breakfast_location');
});
$('#canteen_name_lunch').change(function() {
    fetchCanteenLocation('canteen_name_lunch', 'lunch_location');
});
$('#canteen_name_dinner').change(function() {
    fetchCanteenLocation('canteen_name_dinner', 'dinner_location');
});

// ✅ On page load — fetch existing values
$(document).ready(function() {
    // Load existing locations for edit
    let existingBreakfast = $('#breakfast_location_value').val();
    let existingLunch = $('#lunch_location_value').val();
    let existingDinner = $('#dinner_location_value').val();

    if ($('#canteen_name_breakfast').val()) {
        fetchCanteenLocation('canteen_name_breakfast', 'breakfast_location', existingBreakfast);
    }
    if ($('#canteen_name_lunch').val()) {
        fetchCanteenLocation('canteen_name_lunch', 'lunch_location', existingLunch);
    }
    if ($('#canteen_name_dinner').val()) {
        fetchCanteenLocation('canteen_name_dinner', 'dinner_location', existingDinner);
    }
});
</script>
