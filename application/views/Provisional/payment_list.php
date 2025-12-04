
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
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Provisional Fees List</h1>
            <div class="col-xs-12 col-sm-8">
              
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
                             <div class="col-sm-7">
                                  <form method="post">

	

		<div class="col-sm-3 from-group"><h4>Payment Status:</h4></div>
				<div class="col-sm-3">
				    <select id="pstatus" name="pstatus" class="form-control" >
				      <!--<option value="">All</option> -->
			
								<option value="P" selected="selected" >Pending</option>
						<option value="V" >Verified</option>
				             </select>                                                            
				</div>
			<div class="col-sm-2"><input type="button" value="Search" class="btn btn-primary" id="btnsearch"></div>	
		   <div class="col-sm-2"><input type="Submit" value="Excel" class="btn btn-primary" id=""></div>	

</form>

   
            
            
            
            

                             </div> 
                              <div class="col-sm-3">  
<!--<input id="system-search" name="q" placeholder="Search for" required class="form-control pull-right">-->  
<!-- For multuple field search-->
			<select id="searchby" name="searchby" class="form-control" >
				      <!--<option value="">All</option> -->
				<option value="prov_reg_no" >Reg No</option>	
				<option value="adm_form_no" >Form No</option>
				<option value="student_name" >Name</option>
			</select>  
<!-- EOL For multuple field search-->
<input id="new_search" name="new_search" placeholder="Search" required class="form-control pull-right">
 </div>   <div class="col-sm-2">
 <button type="button" class="btn btn-success" onclick="search_new();" >Search</button>
<!--<a href="javascript:void(0);" name="" id="" onclick="search_new();">Search</a>                       
--></div>
                             <!--<input id="system-search" name="q" placeholder="Search for" required class="form-control pull-right">-->  

                   <!--            <div class="col-sm-1">     </div>
                            <div class="col-sm-3">  
<input id="new_search" name="new_search" placeholder="Name" required class="form-control pull-right">
 </div>   <div class="col-sm-2">
 <button type="button" class="btn btn-success" onclick="search_new();" >Search</button>
</div>-->
                     </div> 
                      <div class="row "><div class="col-sm-7">&nbsp;</div></div>
                   <div class="row "><div class="col-sm-7"> </div>
                <div class="col-sm-3">   <form action="studentwise_list" method="post">
                <button type="submit" class="btn btn-success" >Student List</button> 
            </form> </div>
                   
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
                                      <th>Form No</th>
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
                                    <th>Admission Status</th>
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
                             <td><?=$payment_data[$i]['prov_reg_no']?></td> 
                             <td><?=$payment_data[$i]['adm_form_no']?></td> 
                             <td><?=$payment_data[$i]['student_name']?></td>
                             <td><?=$payment_data[$i]['admission_year']?></td> 
                             <td><?=$payment_data[$i]['mobile1']?></td>
                             
                             <td><?php if($payment_data[$i]['type_id']==2){echo "Admission";}elseif($payment_data[$i]['type_id']==1){echo "Form";}else{ echo "Hostel";}?></td>
                             <td><?=$payment_data[$i]['amount']?></td>
                             <td><?=$payment_data[$i]['fees_paid_type']?></td>
                             
                           	 <td><?php if($payment_data[$i]['fees_paid_type']=="CHLN"){} else{ echo $payment_data[$i]['bank_name'];}; ?></td>
                              <!--<td><?=$payment_data[$i]['bank_city']?></td>-->
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
                               <i class="fa fa-file-pdf-o" style="font-size:20px;color:red"></i></a>         
                           
                    
                  <!--   <a class="marksat" id="editpayment" data-reg_no="<?=$payment_data[$i]['prov_reg_no']?>"  data-stud_name="<?= $payment_data[$i]['student_name']; ?>" val="<?=$i?>" 
    						data-fees_id="<?=$payment_data[$i]['fees_id']; ?>" data-exam_fee="<?= $inst['exam_fees']; ?>" data-exam="<?= $ext; ?>" data-exam_id="<?= $inst['exam_id']; ?>" data-applicable_fee="<?= $inst['exam_session']; ?>" data-toggle="modal" data-target="#walkinModal" style="cursor:pointer"><button class="btn btn-primary btn-xs">Update Payment Status</button></a>
    				-->
    				
    				
    				
                                </td>
                               
                                      <td>
                              <?php /*if($payment_data[$i]['is_cancelled']=="Y"){
                                  echo "<span style='color:red'>CANCELLED</span>";
                              }else{
								  echo '-';
							  }*/
                             /* if($payment_data[$i]['is_confirmed']=="Y"){
                                  echo "<span style='color:red'>Done</span>";
                              }else{
								  echo 'Pending';
							  }*/
							  if($payment_data[$i]['is_cancelled']=="Y"){
 echo "<span style='color:red'>Cancelled</span>";
  }else{
   if($payment_data[$i]['is_confirmed']=="Y"){
  echo "<span style='color:green'>ERP Entry Done</span>";
  
   }else{
  
   if($payment_data[$i]['is_verified']=="Y"){
   echo "<span style='color:#07c4fd'>Verified</span>";
   }else{
	echo "Pending";}
   }
  }
							  
							  
                              ?>
                              
                              
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
     




<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">






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
		    
		    
		    
		    
		$("#btnsearch").on('click',function(){
		var pstatus = $("#pstatus").val();
		
		var url  = '<?=base_url()?>/Provisional_admission/search_received_payment_details';	
		var data = {'pstatus':pstatus};		
		$.ajax({
			type: "POST",
			url: url,
			data: data,
			dataType: "html",
			cache: false,
			crossDomain: true,
			success: function(data){
				$('#itemContainer').html(data);
			//	$('#block').html('');
			//	return false;
			},
			error: function(data){
				alert("Page Or Folder Not Created..!!");
			}
		});
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
			inputText.trim();
            if(inputText != '')
            {
                $('.search-query-sf').remove();
                tableBody.prepend('<tr class="search-query-sf"><td colspan="9"><strong>Searching for: "'
                    + $(that).val().trim()
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

function search_new(){
	var new_search = $("#new_search").val();
	var searchby = $("#searchby").val();
	var status = $("#pstatus").val();
	
		var url  = '<?=base_url()?>Provisional_admission/new_search';	
		var data = {'new_search':new_search,'status':status,'searchby':searchby};		
		$.ajax({
			type: "POST",
			url: url,
			data: data,
			dataType: "html",
			cache: false,
			crossDomain: true,
			success: function(data){
				$('#itemContainer').html(data);
			//	$('#block').html('');
			//	return false;
			},
			error: function(data){
				alert("Page Or Folder Not Created..!!");
			}
		});
}
		</script>
