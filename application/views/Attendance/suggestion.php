
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
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Suggestions</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
             
                                    
                    
            <div class="pull-right col-xs-12 col-sm-auto">    <a class="btn btn-primary btn-labeled" id="editpayment" data-reg_no="<?=$payment_data[$i]['prov_reg_no']?>"  data-stud_name="<?= $payment_data[$i]['student_name']; ?>" val="<?=$i?>" 
    						data-fees_id="<?=$payment_data[$i]['fees_id']; ?>" data-exam_fee="<?= $inst['exam_fees']; ?>" data-exam="<?= $ext; ?>" data-exam_id="<?= $inst['exam_id']; ?>" data-applicable_fee="<?= $inst['exam_session']; ?>" data-toggle="modal" data-target="#walkinModal" style="cursor:pointer"><button class="btn btn-primary btn-xs">Add New Suggestion</button></a>
    				   </div>
                 
                    
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
                             <div class="col-sm-6">
                                 <span class="panel-title text-primary">Suggestion List</span>  
                             </div>   <div class="col-sm-2">     </div>
                            <div class="col-sm-4">  
                             <input id="system-search" name="q" placeholder="Search for" required class="form-control pull-right">
                            </div> 
                     </div> 
                </div>
                <?php
        //       var_dump($_SESSION);
                ?>

                <div class="panel-body" style="overflow:scroll;height:800px;">
                    <div class="table-info">    
                    <?php //if(in_array("View", $my_privileges)) { ?>
                    <table  id="search-table" class="table table-bordered table-list-search">
                        <thead>
                            <tr>
                                    <th>#</th>
                                    <th>Suggestion Category</th>
                                    <th>Suggestion</th>
                                    <th>Added On</th>
                                    <th>Status</th> 
                                  
                                    <!--<th>State</th>
                                    <th>City</th>
                                    <th>Location</th>-->
                                    
                                    
                            </tr>
                            
                        </thead>
                        <tbody id="itemContainer">
                            <?php
                            $j=1;  
						if(!empty($suggestions)){							
                            foreach ($suggestions as $suggestions)
                            {
                               
                            ?>
                            <tr  class="myHead">
                                <td><?=$j?></td>                                                                
                                 <td><?php 
                      if($suggestions['category']=="A"){$stat ="Academics";}
                         elseif($suggestions['category']=="H"){$stat ="Hostel";}
                           elseif($suggestions['category']=="T"){$stat ="Transport";} 
                            elseif($suggestions['category']=="C"){$stat ="Canteen";} 
                             elseif($suggestions['category']=="S"){$stat ="Student Section";}    
                           elseif($suggestions['category']=="O"){$stat ="Other";}        
                           echo $stat;
                           ?></td>
                                          <td><?=$suggestions['suggestion']?></td> 
                        
                                <td><?= date('d-m-Y', strtotime($suggestions['added_on']));?></td>
                             
                                <td>
                         <?php 
                         if($suggestions['status']=="P"){$stats ="Pending";}
                         elseif($suggestions['status']=="F"){$stats ="Forwarded";}
                           elseif($suggestions['status']=="A"){$stats ="Action Taken";} 
                           
                           echo $stats;
                         ?>
                                </td>
                                
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
                   <span id="fform_id">Add New Suggestion</span>
                </h4>
            </div>
            


  <div class="modal-body">
                <div class="row">
                            <div class="col-sm-12">
                                <div class="panel panel-default panel-hovered panel-stacked" style="margin-top: 10px;">
                                    <div class="panel-body">
                                        <form name="editfrm" method="POST" action="<?=base_url()?>Attendance/suggestions" enctype="multipart/form-data" onsubmit="">
                                  

								   <div class="form-group">
                                            <label class="col-sm-3" for="exampleInputEmail1"> Suggestion Category </label>
                                             <div class="col-sm-6">
                                             <select name="upstatus" id="upstatus" class="form-control" required>
                                           <option value="">Select Suggestion Category </option>        
                                             <option value="A">Academics</option> 
                                             <option value="H">Hostel</option> 
                                             <option value="T">Transport</option>  
                                       <option value="C">Canteen</option> 
                                             <option value="S">Student Section</option> 
                                             <option value="O">Other</option>  
                       
                                                 </select>
                                            
                                            </div>
                                        </div>
						
									   <div class="form-group">
                                            <label class="col-sm-3" for="exampleInputEmail1"> Suggestion </label>
                                             <div class="col-sm-6">
                                             <textarea id="sugg" name="sugg" class="form-control" style="margin: 0px -67px 0px 0px;
    width: 303px;
    height: 162px;" required></textarea>
                                            
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
