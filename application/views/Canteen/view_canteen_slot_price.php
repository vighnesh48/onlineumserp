<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<?php //print_r($my_privileges); die; ?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Masters</a></li>
         <li class="active"><a href="<?=base_url($currentModule)?>">Canteen </a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Canteen Slot & Price List</h1>
			
			<div class="col-xs-12 col-sm-8">
                <div class="row"> 
					   <hr class="visible-xs no-grid-gutter-h">
                    
                    <div class="pull-right col-xs-12 col-sm-auto"><a style="width: 100%;" class="btn btn-primary btn-labeled" href="<?=base_url($currentModule."/add_canteen_slot_price")?>"><span class="btn-label icon fa fa-plus"></span>Add </a></div>                        
                    <div class="visible-xs clearfix form-group-margin"></div>
                    
                    
                   
                </div>
            </div>
			
			<span id="flash-messages" style="color:Green;padding-left:50px;">
						 <?php if(!empty($this->session->flashdata('message1'))){ echo $this->session->flashdata('message1'); } ?></span>
					<span id="flash-messages" style="color:red;padding-left:50px;">
						 <?php if(!empty($this->session->flashdata('message2'))){ echo $this->session->flashdata('message2'); } ?></span>

        </div>
       
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                <div class="panel-heading">
                        <span class="panel-title">Slot & Price Details</span>
                        
                </div>
				
                <div class="panel-body" style="overflow-x:scroll;height:500px;">
                    <div class="table-info" >    
                       <table class="table table-bordered">
                        <thead>
                            <tr>
                                    <th>#</th>
                                    <th>Canteen Name</th>
                                    <th>Breakfast Slot</th>
                                    <th>Breakfast Price</th>
                                    <th>Lunch Slot</th>
                                    <th>Lunch Price</th>
                                    <th>Dinner Slot</th>
									                  <th>Dinner Price</th>
                                    <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php
                            $j=1;    
                          //  var_dump($_SESSION);
                            foreach ($canteen_slot_price_details as $slot)
                            {
                                
                            ?>
                            <tr>
                                <td><?=$j?></td>
                                <td><?= $slot['cName'] ?></td>
                                <td><?= $slot['breakfast_slot'] ?></td>
                                <td><?= $slot['breakfast_price'] ?></td>
                                <td><?= $slot['lunch_slot'] ?></td>
                                <td><?= $slot['lunch_price'] ?></td>
                                <td><?= $slot['dinner_slot'] ?></td>
                                <td><?= $slot['dinner_price'] ?></td>
                                <td>
								                   <a style="width: 40%; color:blue; font-size: 18px; margin-left: 8px;"   href="<?=base_url($currentModule."/edit_canteen_slot_price/".base64_encode($slot['canteen_id']))?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>

                                   <!-- <a type="button" style="width: 40%; color:red; font-size: 20px; margin-left: 4px; background-color: transparent; border: none;" 
                                     data-id="<?= $slot['canteen_id'] ?>" 
                                     class="open-delete-modal" 
                                     data-toggle="modal" 
                                     data-target="#myModal">
                                      <i class="fa fa-trash"></i>
                                  </a> -->
								   
								              </td>
                            </tr>
                            <?php
                            $j++;
                            }
                            ?>                            
                        </tbody>
                    </table>   
                
                    <!-- Modal -->
                    <div id="myModal" class="modal fade"  role="dialog">
                      <div class="modal-dialog" >

                        <!-- Modal content-->
                        <div class="modal-content" >
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Select Slot to delete</h4>
                          </div>
                          <div class="modal-body">
                            <form action="<?=base_url($currentModule.'/delete_canteen_slot_price')?>" method="post">
                              <!-- Hidden field to hold the canteen_slot_price_id -->
                              <input type="hidden" name="canteen_id" id="canteen_id" >
                              <div class="form-group">
                                <label for="slot_type">Slot Type</label>
                                <select class="form-control" name="meal_type" required >
                                  <option value="">--Select Slot Type--</option>
                                  <option value="0">All</option>
                                  <option value="1">Breakfast</option>
                                  <option value="2">Lunch</option>
                                  <option value="3">Dinner</option>
                                </select>
                              </div>
                              <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          </div>
                        </div>

                      </div>
                    </div>
                
                </div>
                </div>
            </div>
            </div>    
        </div>
    </div>
</div>

<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->

<script>
 $(document).ready(function() {
    // Click handler for the delete buttons
    $('.open-delete-modal').click(function() {
        var canteenSlotPriceId = $(this).data('id'); // Get the data-id from the clicked button

        // Debug: Check if the ID is captured correctly
        console.log("Captured ID:", canteenSlotPriceId);

        // Set the value in the hidden input field in the modal
        $('#canteen_id').val(canteenSlotPriceId);
    });
});
</script>


