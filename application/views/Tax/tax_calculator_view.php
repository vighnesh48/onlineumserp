<?php $role_id=$this->session->userdata("role_id");
 $um_id=$this->session->userdata("uid");?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://cdn.datatables.net/buttons/2.0.0/js/dataTables.buttons.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.html5.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.print.min.js" type="text/javascript"></script>
<?php //print_r($my_privileges); die; ?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Tax Calculator</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-trophy page-header-icon"></i>&nbsp;&nbsp; Investment Details</h1>
			<span id="err_msg1" style="color:red;"></span>
			<div class="col-xs-12 col-sm-8">
                <div class="row"> 
					 <hr class="visible-xs no-grid-gutter-h">
					 <?php if(empty($tax_details) || ($role_id!=40 && $role_id!=6)){ ?>
					  <div class="pull-right col-xs-12 col-sm-auto"><a style="width: 100%;" class="btn btn-primary btn-labeled" href="<?=base_url($currentModule."/tax_calculator")?>"><span class="btn-label icon fa fa-plus"></span>Add Investment Details</a></div>                        
                    <div class="visible-xs clearfix form-group-margin"></div>
					<?php } ?>
                </div>
            </div>
        </div></br>
  				 <?php 
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
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel-body">						
                    <div class="table-info" >    <!--id="example" class="display"-->
                       <table class="table table-bordered display" style="width:100%;" id="example">
                        <thead>
                            <tr>
							   <th>#</th>
							   <th>Staff ID</th>
								<th>Employee Name</th>
								<th>Designation</th>
								<th>AadharCard No.</th>
								<th>PanCard No.</th>
								<th>Submitted Date</th>								
								<th>Status</th>								
								<th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                           <?php
                            $j=1; 
							
                            for($i=0;$i<count($tax_details);$i++)
                            {
                            ?>
                            <tr>
                               <td><?=$j?></td> 
							   <td><?=$tax_details[$i]['emp_id']?></td>
                                <td><?=$tax_details[$i]['fname'].' '.$tax_details[$i]['mname'].' '.$tax_details[$i]['lname']?></td>
                                <td><?=$tax_details[$i]['designation_name']?></td>
                                <td><?=$tax_details[$i]['adhar_no']?></td>
                                <td><?=$tax_details[$i]['pan_no']?></td>
                                <td><?=$tax_details[$i]['entry_on']?></td>
								 <?php if($tax_details[$i]['status']=='N'){ ?>
                              <td style="color: red;">Pending</td> 
                              <?php }else if($tax_details[$i]['status']=='Y') { ?> 
								<td style="color: Green;">Approved</td> 
								 <?php }else { ?>	
                                 <td style="color: red;">Rejected</td> 
								 <?php } ?>					
                                <td>
								<?php if($tax_details[$i]['status']=="N" || ($role_id==40 && $role_id!=6)  ){ ?>
								<a href="<?=base_url()?>Tax/tax_invest_det_edit/<?=base64_encode($tax_details[$i]['tax_id'])?>/<?=base64_encode($tax_details[$i]['emp_id'])?>" target="_blank"><i class="fa fa-edit"></i></a>    
								<?php }?>
								<!--a href="<?=base_url()?>Tax/generate_income_tax_excel/<?php echo $tax_details[$i]['tax_id'];?>" target="_blank">
							    <i class="fa fa-file-excel-o" aria-hidden="true" style="color:red;cursor:pointer"></i>
									</a-->
                                    	 <?php if($role_id==40 || $um_id=='2'){?>
									<?php if($tax_details[$i]['status']=="N"){ ?>
									|       <button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="status_change_ap(<?=$tax_details[$i]['tax_id']?>)">Approve?</button>

									 |       <button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="status_change_rej(<?=$tax_details[$i]['tax_id'];?>)">Reject?</button>
							         <?php }else if($tax_details[$i]['status']=="Y"){ ?>
									 |       <button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="status_change_rej(<?=$tax_details[$i]['tax_id'];?>)">Reject?</button>
									<?php } else if($tax_details[$i]['status']=="R"){ ?>
									|       <button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="allow_to_edit(<?=$tax_details[$i]['tax_id'];?>)">Allow To Update</button>
									<?php }} ?>
									|     
									  <a href="<?=base_url()?>Tax/tax_calculation_yearly/<?php echo $tax_details[$i]['tax_id'];?>/Excel" target="_blank">
							          <i class="fa fa-file-excel-o" aria-hidden="true" style="color:red;cursor:pointer"></i>
									</a>
									  <button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="tax_calculation(<?=$tax_details[$i]['tax_id'];?>)">Tax Calculator(Monthly)</button>
									<button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="tax_calculation_yearly(<?=$tax_details[$i]['tax_id'];?>)">Tax Calculator(Yearly)</button>
									</a>
								 </td>
							   </tr>
								<?php
								$j++;
                            }
                            ?>          
                        </tbody>
                      </table>                    
                    </div>
                  </div>
               </div>
             </div>
           <div id="tax_det">
         </div>			
      </div>
  </div>
	<div id="view_tax_cal" class="modal fade" role="dialog">
  <div class="modal-dialog" >
    <!-- Modal content-->
    <div class="modal-content" >
       <div class="modal-header">
        <button type="button" class="btn btn-default pull-right" data-dismiss="modal">&times;</button>
        <p class="modal-title" ><strong>Tax Calculations :- </strong> 
        </p>
      </div>
      <div class="modal-body" >
      <div class="row table-responsive" id="taxcal">    
       </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
    </div>
    </div>
<script>
function tax_calculation_yearly(tax_id)
  {

	  if(tax_id !=''){
	 	$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Tax/tax_calculation_yearly',
				data: 'tax_id=' + tax_id,
				success: function (html) {
					$('#taxcal').html(html);
                    $("#view_tax_cal").modal('show');
				}
			});
	  }
	  else
	  {
		  alert("Something Wrong");
	  }
  }
  $(document).ready(function() {
	  $('#tax_det').html('');
   $('#example').DataTable({
			orderCellsTop: true,
			fixedHeader: true,
			dom: 'lBfrtip',
			destroy: true,
			retrieve:true,
			paging:true,
			
			 buttons: [
			 {
				  extend: 'excel',
               exportOptions: {
                columns: [0,1,2,3,4,5,6,7] 
               }
			 }
			], 
			lengthMenu: [[50, 100, 150, -1], [50, 100, 150, "All"]],			
		  });		   
});
  function tax_calculation(tax_id)
  {

	  if(tax_id !=''){
	 	$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Tax/tax_calculation_det',
				data: 'tax_id=' + tax_id,
				success: function (html) {
					$('#taxcal').html(html);
                    $("#view_tax_cal").modal('show');
				}
			});
	  }
	  else
	  {
		  alert("Something Wrong");
	  }
  }
    function status_change_ap(tax_id)
  {
      var status='Y';
	  if(tax_id !=''){
		var checkstr =  confirm('Are you sure you want to Approved this?');
        if(checkstr == true){
	 	$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Tax/tax_investment_status_chng',
				data: 'tax_id=' + tax_id+'&status='+status,
				success: function (sucess) {
					
                       location.reload();
				}
			});
		}
	  }
	  else
	  {
		  alert("Something Wrong");
	  }
  }
      function status_change_rej(tax_id)
  {
      var status='R';
	  if(tax_id !=''){
		var checkstr =  confirm('Are you sure you want to Reject this?');
        if(checkstr == true){
	 	$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Tax/tax_investment_status_chng',
				data: 'tax_id=' + tax_id+'&status='+status,
				success: function (sucess) {
					
                       location.reload();
				}
			});
		}
	  }
	  else
	  {
		  alert("Something Wrong");
	  }
  }
  function allow_to_edit(tax_id)
  {
       var status='N';
	  if(tax_id !=''){
		var checkstr =  confirm('Are you sure you want to Allow to Edit this?');
        if(checkstr == true){
	 	$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Tax/tax_investment_status_chng',
				data: 'tax_id=' + tax_id+'&status='+status,
				success: function (sucess) {
					
                       location.reload();
				}
			});
		}
	  }
	  else
	  {
		  alert("Something Wrong");
	  }
  }
</script>