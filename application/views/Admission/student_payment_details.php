<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<style>
.panel-heading {
    color: #8a6d3b;
    background-color: #fcf8e3;
    border-color: #faebcc;
}
</style>

<script>
function feevalidate()
{
    //alert("jugal");
 //   return false;
    
        var base_url = 'https://erp.sandipuniversity.com/';
                   // alert(type);
                   var clreceipt = $("#clreceipt").val();
                 
                $.ajax({
                    'url' : base_url + '/Ums_admission/validate_receipt',
                    'type' : 'POST', //the way you want to send data to your URL
                    'data' : {'clreceipt':clreceipt},
                    'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
                    //    var container = $('#stddata'); //jquery selector (get element by id)
                        if(data){
                          alert(data);
                          if(data.trim()!='')  
                          {
                             alert("Receipt Number Should be Unique"); 
                              e.preventDefault();
                             return false;
                          }
                          else
                          {
                              $('#makePayment').submit();
                          }
                          
                        //  alert(data);
                            //alert("Marks should be less than maximum marks");
                            //$("#"+type).val('');
                           // container.html(data);
                            
                        }
                       
                    }
                });
                
                 e.preventDefault();
        return false;
    
  //  alert("out");
    
  // return false;
    
    
    
    
    
    
    
    
    
}

</script>
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="#">Payment Details</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Make Payment</h1>
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
                        <span class="panel-title">Payment Details</span>
                    </div>
                    <div class="panel-body">
                        <div class="table-info">   
						<table class="table table-bordered">
    					<tr>
    					  <th width="25%">PRN No :</th><td><?=$emp[0]['enrollment_no']?></td>
						</tr>
						<tr>
						  <th scope="col">Student Name :</th><td><?=$emp[0]['last_name']?> <?=$emp[0]['first_name']?> <?=$emp[0]['middle_name']?></td>
						</tr>
						<tr>
    					  <th scope="col">Course Name :</th><td><?=$emp[0]['stream_name']?></td>
    					</tr>
						</table>
    				    <table class="table table-bordered">
    					<tr>
    					   <th scope="col">Academic Year</th>
    					   <th scope="col">Year</th>
    					  <th scope="col">Academic Fee</th>
    					  <th scope="col">Exepmted Fee</th>
    					  <th scope="col">Applicable Fee</th>
    					  <th scope="col">Opening balance</th>
    					  <th scope="col">Amount Paid</th>
    				
    					   <td><strong>Refund</strong></td>
    					  
    					  
    					  <th scope="col">Remaining Balance</th>
    					 
    					    <th scope="col">Chq Cancellation Charges</th>
    					      <th scope="col">Total Outstanding</th>
    					     
    					    <th scope="col">Action</th>
    					</tr>
    					<?php 

						$exm = (int)$admission_details[0]['actual_fee'] - (int)$admission_details[0]['applicable_fee'];
						$bal = (int)$admission_details[0]['applicable_fee'] - (int)$get_feedetails[0]['amount'];
					  
    					$srNo1=1;
    					
    				$actual =	isset($admission_details[0]['applicable_fee']) ? $admission_details[0]['applicable_fee'] : '';
    					$paid =isset($totfeepaid[0]['tot_fee_paid']) ? $totfeepaid[0]['tot_fee_paid'] : '';
    					$i=1;
    				  $cn = count($admission_detail);
    				  
    				 // var_dump($admission_detail);
    					if($cn >1)
    					{
    					
    			 $popbal = ($admission_detail[1]['applicable_fee'] + $admission_det[1]['canc_amount'] + $admission_detail[1]['opening_balance']) + $admission_detail[1]['tot_refunds'] -  $admission_detail[1]['totfeepaid'] ;
    					}
    					else
    					{
    					    $popbal = 0;
    					}
    				//	$popbal = $admission_detail[];
    					$i=1;
    					foreach($admission_detail as $admission_det)
    					{
    					    
    				//	 echo $i;
						$exm = (int)$admission_det['actual_fee'] - (int)$admission_det['applicable_fee'];
						$bal = (int)$admission_det['applicable_fee'] - (int)$admission_det['totfeepaid'];
					  
    					$srNo1=1;
    					
    				$actual =	isset($admission_det['applicable_fee']) ? $admission_det['applicable_fee'] : '';
    					$paid =isset($admission_det['totfeepaid']) ? $admission_det['totfeepaid'] : '';   
    					?>
    					<tr>
							<td><?= $admission_det['academic_year']; ?></td>
								<td><?= $admission_det['year']; ?></td>
    						<td><?= isset($admission_det['actual_fee']) ? $admission_det['actual_fee'] : '' ?></td>
    						<td><?=  $exm; ?></td>
    						<td><?= isset($admission_det['applicable_fee']) ? $admission_det['applicable_fee'] : '' ?></td>
    						<td><?= isset($admission_det['opening_balance']) ? $admission_det['opening_balance'] : '' ?></td>
    						<td><?= isset($admission_det['totfeepaid']) ? $admission_det['totfeepaid'] : '' ?></td>
    						
    						<?php
    				  if($admission_det['tot_refunds']!='')
    					  {
    					    $actual = $actual + $admission_det['tot_refunds'] ;
    					  }
    					    ?>
    					   <td><?=$admission_det['tot_refunds'] ?></td>
    					   <?
    				
    					  if($admission_det['opening_balance']!='')
    					  
    					  {
    					    $actual = $actual +   $admission_det['opening_balance'];
    					  }
    					  ?> 
    					  
    						<td><?= $pend = $actual - $paid; //isset($minbalance[0]['min_balance']) ? $minbalance[0]['min_balance'] : $admission_details[0]['applicable_fee'] ?></td>
    					
    							<td><?php echo $can_amt = $admission_det['tot_canc']; //$canc_charges[0]['canc_amount'] ?></td>
    							<td><?php echo $can_amt + $pend; //$canc_charges[0]['canc_amount'] ?></td>
    							<td>
    							 
    					
    						</td>
    					</tr>
    					
    					<?php
    					$i++;
    					}
    					?>
    					<!--<tr>
							<td><?= $admission_details[0]['academic_year']; ?></td>
								<td><?= $admission_details[0]['year']; ?></td>
    						<td><?= isset($admission_details[0]['actual_fee']) ? $admission_details[0]['actual_fee'] : '' ?></td>
    						<td><?=  $exm; ?></td>
    						<td><?= isset($admission_details[0]['applicable_fee']) ? $admission_details[0]['applicable_fee'] : '' ?></td>
    						<td><?= isset($admission_details[0]['opening_balance']) ? $admission_details[0]['opening_balance'] : '' ?></td>
    						<td><?= isset($totfeepaid[0]['tot_fee_paid']) ? $totfeepaid[0]['tot_fee_paid'] : '' ?></td>
    						
    						<?php
    					  if($tot_refunds['rsum']!='')
    					  {
    					    $actual = $actual + $tot_refunds['rsum'] ;
    					    ?>
    					   <td><?=$tot_refunds['rsum']?></td>
    					   <?
    					  }
    					  if($admission_details[0]['opening_balance']!='')
    					  
    					  {
    					    $actual = $actual +   $admission_details[0]['opening_balance'];
    					  }
    					  ?> 
    					  
    						<td><?= $pend = $actual - $paid; //isset($minbalance[0]['min_balance']) ? $minbalance[0]['min_balance'] : $admission_details[0]['applicable_fee'] ?></td>
    						 <?php
    					  if($canc_charges['canc_amount']>0)
    					  {
    					  ?>
    							<td><?php echo $can_amt = $canc_charges['canc_amount']; //$canc_charges[0]['canc_amount'] ?></td>
    							<td><?php echo $can_amt + $pend; //$canc_charges[0]['canc_amount'] ?></td>
    							<?php
    					  }
    							?>
    							<td>
    						    <a class="marksat" id="editpayment" data-academic_year="<?= $admission_details[0]['academic_year']; ?>" data-stud_id="<?= $admission_details[0]['student_id']; ?>" data-actual_fee="<?= $admission_details[0]['actual_fee']; ?>" data-excemption_fees="<?= $exm; ?>" data-applicable_fee="<?= $admission_details[0]['applicable_fee']; ?>" data-opening_balance="<?= $admission_details[0]['opening_balance']; ?>"data-toggle="modal" data-target="#walkinModal" style="cursor:pointer"><button class="btn btn-primary btn-xs">Edit</button></a>
    						</td>
    					</tr>-->
    						
    				  </table>	
					  </div>
					  </div>
				
           
										  <!------------------------------------------------------------------------------------------------------------------------------>
					 
				
				
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                         </div>
						 <!------------------------------------------------------------------------------------------------------------------------------------------------->

                </div>
            </div>    
        </div>
    </div>

<!-- model end-->
</div>
<script>
     
 var base_url = '<?php echo site_url(); ?>';

   // $('#editp').on('click', function () {
        function valid(feeid)
        {
      //  var feeid = $(this).attr('name');
   var controller = 'Ums_admission';
           
            $('#pmnt').prop('disabled', true);
            
	          $.ajax({
                    'url' : base_url + '/' + controller + '/edit_fdetails',
                    'type' : 'POST', //the way you want to send data to your URL
                    'data' : {'feeid' : feeid},
                    'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
                        var container = $('#edit_fee'); //jquery selector (get element by id)
                        if(data){
							//alert(data);
							//alert("Marks should be less than maximum marks");
							//$("#"+type).val('');
                            container.html(data);
                        }
                    }
                });
		
//	});
}






	  $('#cbutton').on('click', function () {
        //$('#pmnt').prop('disabled', false);
        	$("#makepmnt").hide();
   });

    $('#pmnt').on('click', function () {
        
		$("#makepmnt").show();
	});
    // Num check logic
  	$('.numbersOnly').keyup(function () {
    if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
       this.value = this.value.replace(/[^0-9\.]/g, '');
    } 
  	});
	    $('#doc-sub-datepicker20').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
	      $('#doc-sub-datepicker21').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
	       $('#doc-sub-datepicker41').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
	        $('#doc-sub-datepicker42').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
/////////////////
$(document).on("click", '#editpayment', function () {
   // var ye = $(this).value();
     //var va = $(this).attr('val');
    //alert(va);
        var stud_id = $('#editpayment').attr("data-stud_id");
        var applicable_fee = $('#editpayment').attr("data-applicable_fee");
      //  var academic_year = $('#editpayment').attr("data-academic_year");
        var academic_year = $(this).attr("data-academic_year");
        var openingbal = $(this).attr("data-openingbal");
        
        var actual_fee = $('#editpayment').attr("data-actual_fee");
       // var opening_balance = $('#editpayment').attr("data-opening_balance");
       
       var opening_balance = $(this).attr("data-opening_balance");
       
       
        var excemption_fees = $('#editpayment').attr("data-excemption_fees");
		//alert(opening_balance);
        if(stud_id !=''){
			document.getElementById("fstud_id").value = parseInt(stud_id);
		}
        if(applicable_fee !=''){
			$("#fgym_fees").html(parseInt(applicable_fee));
		}
        if(actual_fee !=''){
			$("#facdamicfee").html(parseInt(actual_fee));
		}
		if(opening_balance !=''){
			$("#fopening_balance").val(parseInt(openingbal));
			
		}
		if(excemption_fees !=''){
			$("#exem").html(parseInt(excemption_fees));
			
		}
		if(academic_year !=''){
			$("#acad_year").val(parseInt(academic_year));
			
		}

    });	        
	</script>