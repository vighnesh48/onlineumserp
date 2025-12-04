
<?php //echo  "<pre>"; print_r($unittest); die;
$role_id = $this->session->userdata('role_id');
 ?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#"></a></li>
        <li class="active"><a href="#"></a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Payments</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                    <?php if($role_id ==4 || $role_id==8) { ?>
                                        <div class="pull-right col-xs-12 col-sm-auto"><a style="width: 100%;" class="btn btn-primary btn-labeled" href="<?=base_url("event/add")?>"><span class="btn-label icon fa fa-plus"></span>Add Event</a></div>  
                    <div class="pull-right col-xs-12 col-sm-auto"><a style="width: 100%;" class="btn btn-primary btn-labeled" href="<?=base_url($currentModule."/add")?>"><span class="btn-label icon fa fa-plus"></span>Add Institute</a></div> 
                      
                    <div class="visible-xs clearfix form-group-margin"></div>
                    <?php } ?>
                    
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
                     <div class="row ">
                             <div class="col-sm-9">
                                  <form method="post">

	

		<div class="col-sm-4 from-group"><h4>Select Payment Status:</h4></div>
				<div class="col-sm-3">
				    <select id="pstatus" name="pstatus" class="form-control" >
				      <option value="">All</option> 
			
								<option value="P" >Pending</option>
						<option value="V" >Verified</option>
				             </select>                                                            
				</div>
			<div class="col-sm-2"><input type="Submit" value="Search" class="btn btn-primary" id="btnsearch"></div>	
				

</form>
                             </div>   <div class="col-sm-2">     </div>
                            <div class="col-sm-3">  
                             <input id="system-search" name="q" placeholder="Search for" required class="form-control pull-right">
                            </div> 
                     </div> 
                </div>
      
                <div class="panel-body" style="overflow:scroll;height:800px;">
                    <div class="table-info">    
                    <?php //if(in_array("View", $my_privileges)) { ?>
                    <table  id="search-table" class="table table-bordered table-list-search">
                        <thead>
                            <tr>
                                    <th>#</th>
                                      <th>Reg No</th>
                                    <th>Student Name</th>
                                  
                                     <th>Year</th>
                                    <th>Mobile</th>
                                     <th>Payment For</th>
                                        <th>Amount</th>
                                       <th>Payment Type</th>
                                     <th>Bank Name</th> 
                                   <!--   <th>Bank Branch</th>  -->
                                        <th>Payment</th>  
                                    <th>Payment 
                                    Verification Status</th> 
                                  
                                    <!--<th>State</th>
                                    <th>City</th>
                                    <th>Location</th>-->
                                    
                                    <th>Receipt</th>
                            </tr>
                            
                        </thead>
                        <tbody id="itemContainer">
                            <?php
                            $j=1;  
						if(!empty($payment_data)){							
                            for($i=0;$i<count($payment_data);$i++)
                            {
                               
                            ?>
                            <tr  class="myHead">
                                <td><?=$j?></td>          
                                    <td><?php if($payment_data[$i]['type_id']==2 && $payment_data[$i]['provisional_admission']=='Y'){ echo $payment_data[$i]['prov_reg_no'];}?></td> 
                                 <td><?=$payment_data[$i]['student_name']?></td>
                                      
                             <td><?=$payment_data[$i]['admission_year']?></td> 
                             
                                <td><?=$payment_data[$i]['mobile1']?></td>
                             <td><?php 
							 if($payment_data[$i]['type_id']==1){
								 echo "Admission Form";
							 }else if($payment_data[$i]['type_id']==2){
								 echo "Admission";
							}else{
								
							}
								 ?></td>
                                <td><?=$payment_data[$i]['amount']?></td>
                                <td><?=$payment_data[$i]['fees_paid_type']?></td>
                               	<td><?php if($payment_data[$i]['fees_paid_type']=="CHLN"){} else{ echo $payment_data[$i]['bank_name'];}; ?></td>
                                 <!--  <td><?=$payment_data[$i]['bank_city']?></td>-->
                                   
                                   <td class="noExl"><a href="<?=base_url($currentModule."/viewPayments/".$payment_data[$i]['student_id'])?>" title="View" target="_blank">
                                       <i class="fa fa-credit-card" aria-hidden="true"></i> </a>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                <td>
                         <?php if($payment_data[$i]['payment_status']=="P"){$stat ="Pending";}
                         elseif($payment_data[$i]['payment_status']=="V"){$stat ="Verified";}
                         elseif($payment_data[$i]['payment_status']=="R"){$stat ="Rejected";}
                           elseif($payment_data[$i]['payment_status']=="C"){$stat ="Cancelled";} 
                           echo $stat;
                         ?>
                                </td>
                                 <td>
                              <?php if($payment_data[$i]['payment_status']=="V"){?>
                     		<a href="<?=base_url($currentModule."/generate_payment_receipt/".$payment_data[$i]['fees_id'])?>" title="View" target="_blank">
                               <i class="fa fa-file-pdf-o" style="font-size:20px;color:red"></i> </a>         
                           
                    
                            <!--   <a class="marksat" id="editpayment" data-reg_no="<?=$payment_data[$i]['prov_reg_no']?>"  data-stud_name="<?= $payment_data[$i]['student_name']; ?>" val="<?=$i?>" 
    						data-fees_id="<?=$payment_data[$i]['fees_id']; ?>" data-exam_fee="<?= $inst['exam_fees']; ?>" data-exam="<?= $ext; ?>" data-exam_id="<?= $inst['exam_id']; ?>" data-applicable_fee="<?= $inst['exam_session']; ?>" data-toggle="modal" data-target="#walkinModal" style="cursor:pointer"><button class="btn btn-primary btn-xs">Update Payment Status</button></a>
    				-->
    				
    				
    				
                                </td>
                                <?php
                              }
                                ?>
                            </tr>
                            <?php
                            $j++;
                            }
						}else{ echo "<tr><td colspan=8>No data found</td></tr>";}
                            ?>                            
                        </tbody>
                    </table>                    
                    <?php //} ?>
                </div>
                </div>
            </div>
            </div>    
        </div>
    </div>
</div>





<div class="modal fade" id="walkinModal" tabindex="-1" role="dialog" 
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                
                <h4 class="modal-title" id="myModalLabel">
                   <span id="fform_id">Update Payment Status</span>
                </h4>
            </div>
            


  <div class="modal-body">
                <div class="row">
                            <div class="col-sm-12">
                                <div class="panel panel-default panel-hovered panel-stacked" style="margin-top: 10px;">
                                    <div class="panel-body">
                                        <form name="editfrm" method="POST" action="<?=base_url()?>provisional_admission/update_payment_status" enctype="multipart/form-data" onsubmit="">
                                        <div class="form-group">
                                            <label class="col-sm-3" for="exampleInputEmail1"> </label>
                                             <div class="col-sm-6"> 
                                             <label name="facdamicfee" id="facdamicfee"></label>
                                                
                                            </div>
                                        </div> 
                                        <div class="form-group">
                                          
                                             <div class="col-sm-6"> 
                                                <label name="exam_sess" id="exam_sess"></label>
                                                <input type="hidden" name="fstud_id" class="form-control" id="fstud_id" style="width:50%"/>
                                                
    									        <input type="hidden" name="fees_id" id="fees_id"  value="">
    									  

                                            </div>
                                        </div>  
                                

								   <div class="form-group">
                                            <label class="col-sm-6" for="exampleInputEmail1">Select Payment Status </label>
                                             <div class="col-sm-6">
                                             <select name="upstatus" id="upstatus" class="form-control" required>
                                           <option value="">Select Payment Status</option>        
                                             <option value="V">Payment Verified </option> 
                                             <option value="C">Payment Cancelled </option> 
                                             <option value="R">Payment Rejected</option>  
                                      
                                             
                                                 </select>
                                            
                                            </div>
                                        </div>
										
							
   
                                          <button type="submit" class="btn btn-primary" id="updatePayment1" >Submit</button>
                                          <button type="button" class="btn btn-default"
                                                data-dismiss="modal">
                                                    Close
                                        </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                
            </div>
            
             </div>
    </div>
</div>     
     











<script type="text/javascript">
		$(document).ready(function() {
		    
		 $(document).on("click", '#editpayment', function () {
   // var ye = $(this).value();
     //var va = $(this).attr('val');
    //alert(va);
      
            var fees_id = $(this).attr("data-fees_id");
	
		
	//	alert(examname);
  
   
        if(fees_id !=''){
			$("#fees_id").val(parseInt(fees_id));
		}


    });		    
		    
		    
		    
		    
		    
		    
		    
		    
    var activeSystemClass = $('.list-group-item.active');

    //something is entered in search form
    $('#system-search').keyup( function() {
       var that = this;
        // affect all table rows on in systems table
        var tableBody = $('.table-list-search tbody');
        var tableRowsClass = $('.table-list-search tbody tr');
        $('.search-sf').remove();
        tableRowsClass.each( function(i, val) {
        
            //Lower text for case insensitive
            var rowText = $(val).text().toLowerCase();
            var inputText = $(that).val().toLowerCase();
            if(inputText != '')
            {
                $('.search-query-sf').remove();
                tableBody.prepend('<tr class="search-query-sf"><td colspan="9"><strong>Searching for: "'
                    + $(that).val()
                    + '"</strong></td></tr>');
            }
            else
            {
                $('.search-query-sf').remove();
            }

            if( rowText.indexOf( inputText ) == -1 )
            {
                //hide rows
                tableRowsClass.eq(i).hide();
                
            }
            else
            {
                $('.search-sf').remove();
                tableRowsClass.eq(i).show();
            }
        });
        //all tr elements are hidden
        if(tableRowsClass.children(':visible').length == 0)
        {
            tableBody.append('<tr class="search-sf"><td class="text-muted" colspan="8">No records  found.</td></tr>');
        }
    });
});
		</script>
