
<?php //echo  "<pre>"; print_r($unittest); die;
$role_id = $this->session->userdata('role_id');
//var_dump($_SESSION);
 ?>
 <script src="<?=base_url('assets/javascripts')?>/jquery.table2excel.js"></script>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#"></a></li>
        <li class="active"><a href="#"></a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Todays Admissions 2018</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
          
                    <div class="visible-xs clearfix form-group-margin"></div>
                   
                    
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-sm-12">&nbsp;</div>
        </div>
        
        
        <div class="row ">
            <div class="col-sm-12">
  <strong> <span id="flash-messages" style="color:Green;padding-left:50px;">
						 <?php if(!empty($this->session->flashdata('message1'))){ echo $this->session->flashdata('message1'); } ?></span></strong>
        
        </div>
        </div>
   
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                    <?php

						$fees_total1 = []; 							
						if(!empty($stud_data)){							
                            for($i=0;$i<count($stud_data);$i++)
                            {
                               $fees_total1[] = $stud_data[$i]['amount']; 
							}
						}?>
                <div class="panel-heading">
                     <div class="row ">
                             <div class="col-sm-3">Total Count : <b><?php if(!empty($stud_data)){ echo  count($stud_data);}else{ echo "0";}?></b></div>   
							<div class="col-sm-6">Total Fees : <b><?php if(!empty($fees_total1)){ echo  array_sum($fees_total1);}else{ echo "0";}?></b></div> 							 
                            <div class="col-sm-3">  
                             <input id="system-search" name="q" placeholder="Search for" required class="form-control pull-right">
                            </div> 
                     </div> 
                </div>
</div>
</div>
</div>



        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                <div class="panel-body" style="overflow:scroll;height:800px;">
                    
                   
                    <div class="table-info">    
                    <?php //if(in_array("View", $my_privileges)) { ?>
                    <table  id="search-table" class="table table-bordered table-list-search">
                        <thead>
                            <tr>
                                    <th>#</th>
                                     <th>PRN</th>
                                    <th>Student Name</th>
                                    <th>Mobile</th>
                                    <th>Stream </th>
                                    <th> Semester</th>
                                   <th> Fees</th>
                                   
                            </tr>
                            
                        </thead>
                        <tbody id="itemContainer">
                            <?php
                            $j=1;
						$fees_total = []; 							
						if(!empty($stud_data)){							
                            for($i=0;$i<count($stud_data);$i++)
                            {
                               $fees_total[] = $stud_data[$i]['amount']; 
                            ?>
                            <tr  class="myHead">
                                <td><?=$j?></td>    
                                <td><?=$stud_data[$i]['enrollment_no']?></td> 
                                <td><?=$stud_data[$i]['first_name'].' '.$stud_data[$i]['middle_name'].' '.$stud_data[$i]['last_name']?></td>
                                <td><?=$stud_data[$i]['mobile']?></td>
                                <td><?=$stud_data[$i]['stream_name']?></td>     
								<td><?=$stud_data[$i]['current_semester']?></td>
								<td><?=$stud_data[$i]['amount']?></td>
                            </tr>
                            <?php
                            $j++;
                            }?>
							<!--tr><td colspan=6 align="left"><b>Total Fees</b></td><td ><b><?=array_sum($fees_total);?></b></td></tr-->
						<?php }else{ echo "<tr><td colspan=8>No data found</td></tr>";}
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
                   <span id="fform_id">Cancel Admission</span>
                </h4>
            </div>
            


  <div class="modal-body">
                <div class="row">
                            <div class="col-sm-12">
                                <div class="panel panel-default panel-hovered panel-stacked" style="margin-top: 10px;">
                                    <div class="panel-body">
                                        <form name="editfrm" method="POST" action="<?=base_url()?>provisional_admission/cancel_admission" enctype="multipart/form-data" onsubmit="return confirm('Do you really want to cancel the admission?');">
                                 
                                        <div class="form-group">
                                          
                           
                                                Student Name : <label name="stud_name" id="stud_name"></label><br>
                                                Reg. No : <label name="reg_no" id="reg_no"></label> <br>
                                                 Course : <label name="course_name" id="course_name"></label> 
                                                
                                                <input type="hidden" name="fstud_id" class="form-control" id="fstud_id" style="width:50%"/>
                                                 <input type="hidden" name="freg_no" class="form-control" id="freg_no" style="width:50%"/>
                                                 
    									    

                                           
                                        </div>  
                                

								   <div class="form-group">
                                            <label class="col-sm-4" for="exampleInputEmail1">Cancellation Fees</label>
                                             <div class="col-sm-5">
                                            <input type="text" name="canc_fees" class="form-control numbersOnly" id="canc_fees" style="" required/>
                                             
                                                 </select>
                                            
                                            </div>
                                        </div>
								   <div class="form-group">
                                            <label class="col-sm-4" for="exampleInputEmail1">Cancellation Date</label>
                                             <div class="col-sm-5">
                                            <input type="text" name="canc_date" class="form-control" id="canc_date" style="" required/>
                                             
                                                 </select>
                                            
                                            </div>
                                        </div>			
										
								   <div class="form-group">
                                            <label class="col-sm-4" for="exampleInputEmail1">Cancellation Remark</label>
                                             <div class="col-sm-5">
                                            <textarea type="text" name="canc_remark" class="form-control" id="canc_remark" style="" required/></textarea>
                                                 </select>
                                            
                                            </div>
                                        </div>
   
                                          <button type="submit" class="btn btn-primary" id="updatePayment1" >Cancel Admission</button>
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
		    
	                     
$("#expdata").click(function(){

  $("#search-table").table2excel({

    exclude: ".noExl",

    name: "Worksheet Name",
  filename: "Student List" //do not include extension

  });

});	    
		    
		     $(document).on("click", '#editpayment', function () {

         //   var fees_id = $(this).attr("data-fees_id");
	
var stud_id = $(this).attr("data-reg_id");
var stud_name = $(this).attr("data-stud_name");
var stud_reg_no = $(this).attr("data-prov_regno");
var stud_prog = $(this).attr("data-prog_name");


			$("#stud_name").html(stud_name);
$("#reg_no").html(stud_reg_no);
$("#freg_no").val(stud_reg_no);
$("#course_name").html(stud_prog);
$("#fstud_id").val(stud_id);

      
    									    

    });		    
		    	    
		$("#btnsearch").on('click',function(){
	//	var ic = $("#ic").val();
		var doa = $("#doa").val();
	var reftype = $("#reftype").val();
		var refby = $("#refby").val();
		var url  = '<?=base_url()?>/Provisional_admission/search_admissions';	
		var data = {'reftype':reftype,'refby':refby,'doa':doa};		
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

		$("#reftype").on('change',function(){
		var reftype = $(this).val();
	//	alert(reftype);
	//	var doa = $("#doa").val();
		var url  = '<?=base_url()?>/Provisional_admission/get_references';	
		var data = {'reftype':reftype};		
		$.ajax({
			type: "POST",
			url: url,
			data: data,
			dataType: "html",
			cache: false,
			crossDomain: true,
			success: function(data){
				$('#refby').html(data);
			//	$('#block').html('');
			//	return false;
			},
			error: function(data){
				alert("Page Or Folder Not Created..!!");
			}
		});
	});	
		    
		  $('.numbersOnly').keyup(function () {
			if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
				this.value = this.value.replace(/[^0-9\.]/g, '');
			}
		});  
		    
		    
		    
		    
		    
		    
		    
		    $('#doa').datepicker({format: 'dd/mm/yyyy',autoclose: true});
		      $('#canc_date').datepicker({format: 'dd/mm/yyyy',autoclose: true});
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
