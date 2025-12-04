

<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" type="text/css" />
<link href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css" type="text/css"/>
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
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp; Ph.D. Registration List 2025</h1>
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
                             <div class="col-sm-10">
                                  <form method="post">
                                      <div class="col-sm-3">
            <!--<select id="yearsession"  name="yearsession" class="form-control" >
              <option value="">Select Session</option> 
              <option value="JULY-2021" selected="selected">JULY-2021</option> 
			  <option value="JULY-2020">JULY-2020</option> 
              <option value="JULY-2019">JULY-2019</option> 
               <option value="FEB-2019">FEB-2019</option>  
                         
                     </select>-->                                                            
        </div>

			<div class="col-sm-2 from-group"><h4>Registration Status</h4></div>
				<div class="col-sm-2">
				    <select id="pstatus" name="pstatus" class="form-control" >
				      <option value="">All</option> 
		 <option value="success">Completed</option> 
			 <option value="fail">Not Completed</option> 						
				             </select>                                                            
				</div>

		<div class="col-sm-2 from-group"><h4> Department</h4></div>
				<div class="col-sm-2">
				    <select id="dept" name="dept" class="form-control" >
				      <option value="">All</option> 
			<?php
			foreach($dept as $dept)
			{
			echo "<option value='".$dept['dept_name']."'>".$dept['dept_name']."</option>";    
			}
			?>
								
				             </select>                                                            
				</div>
			<div class="col-sm-4"><input type="button" value="Search" class="btn btn-primary" id="btnsearch">
			<input type="Submit" value="Attendance Sheet" class="btn btn-primary" id="">
			<!--input type="button" value="Hall Ticket" class="btn btn-primary" onclick="send_hallticket()"-->								
			</div>	
		<!--	<div class="col-sm-1"><input type="Submit" value="Attendance Sheet" class="btn btn-primary" id=""></div>-->
			<!--	<div class="col-sm-1"><input type="Submit" value="Excel" class="btn btn-primary" id=""></div>-->	

</form>
                             </div>   <!-- <div class="col-sm-2">     </div>
                            <div class="col-sm-3">  
                             <input id="system-search" name="q" placeholder="Search for" required class="form-control pull-right">
                            </div>  -->
                     </div> 
                </div>
      
                <div class="panel-body" style="overflow:scroll;height:800px;">
                    <div class="table-info" id="gettotaldata">    
                    <?php //if(in_array("View", $my_privileges)) { ?>
					<div id="wait" style="display:none;width:40px;height:40px;position:absolute;top:50%;left:50%;z-index:99999;"><img src='<?=site_url()?>assets/images/demo_wait_b.gif' width="64" height="64" /><br>Loading..</div>						 
                    <table  id="search-table" class="table table-bordered table-list-search">
                        <thead>
                            <tr>
                                 <th>All<input type="checkbox" name="checkall" id="checkAll" value="1" /></th>
                                    <th>Applicant Name</th>
									<th>Registration No.</th>
                                  <th>Department</th>
                                  <th>City</th>
                                   <th>Category</th>
                                     <th>Gender</th>
                                    <th>Mobile</th>
                                     <th>Email</th>
                                      <th>Amount</th>
                                      <th>Online&nbsp;Pay</th>  
                                   <th>Verification&nbsp;Status</th>  
								   <th>Created on</th>
									<th>Entrance</br>Marks</th>			   
										<th>Interview</br>Marks</th>
										<th>Final</br>Marks</th> 
	                                   <th>Mail Status</th> 			 
										<th>Actions</th>								   
                                    <th>Documets</th>     
                            </tr>
                            
                        </thead>
                        <tbody id="itemContainer">
                            <?php
                            $j=1;  
						if(!empty($phd_data)){							
                            for($i=0;$i<count($phd_data);$i++)
                            {
                               
                            ?>
                            <tr  class="myHead">
                                <td><?=$j?>
								<?php if($phd_data[$i]['verification']=="V" && $phd_data[$i]['is_mailsend']!='Y'){ ?>
                                <input type="checkbox" name="stud[]" class="phd_id" value="<?=$phd_data[$i]['phd_id']?>" />
								<?php } ?>
								</td>

                                 <td><?=$phd_data[$i]['student_name']?></td>
								 <td>2501<?=$phd_data[$i]['phd_id']?></td>
                          <td><?=$phd_data[$i]['department']?></td> 
                            <td><?=$phd_data[$i]['city_c']?></td> 
                   <td><?=$phd_data[$i]['category']?></td> 
                    <td><?=$phd_data[$i]['gender']?></td> 
                    <td><?=$phd_data[$i]['mobile_no']?></td> 
                     <td><?=$phd_data[$i]['email_id']?></td> 
                      <td><?=$phd_data[$i]['amount']?></td> 
                      <td><?php
						   if($phd_data[$i]['fees_paid']=="Y")
                                            {
												echo "Paid";
											}else{echo "Pending";  } ?></td> 
                        <td>
                          <?php
						  
                          if($phd_data[$i]['verification']=="P")
                          {
                          echo "Pending";  
                           ?>
                          
                         
    		<?php
    		
                          }
                          else if($phd_data[$i]['verification']=="V")
                          {
                         echo "Verified";     
                          }
                          else
                          {
                           echo "Cancelled";         
                          }
                         
                          ?>
                            
                        </td> 
						<td><?=$phd_data[$i]['entry_on']?></td>
<td><input type="text" id="entrance_marks_<?=$phd_data[$i]['phd_id']?>" name="entrance_marks_<?=$phd_data[$i]['phd_id']?>" class="form-control numbersOnly" value="<?=$phd_data[$i]['entrance_marks']?>" onchange="check_marks(<?=$phd_data[$i]['phd_id']?>, <?=$phd_data[$i]['academic_year']?>,<?=$phd_data[$i]['phd_reg_no']?>,this.value)"> 
</td> 			   
<td><input type="text" name="interview_marks_<?=$phd_data[$i]['phd_id']?>" id="interview_marks_<?=$phd_data[$i]['phd_id']?>" class="form-control numbersOnly" value="<?=$phd_data[$i]['interview_marks']?>" onchange="add_marks(<?=$phd_data[$i]['phd_id']?>, <?=$phd_data[$i]['academic_year']?>,<?=$phd_data[$i]['phd_reg_no']?>,this.value)"></td> 
	<td><input type="text" class="form-control numbersOnly" id="final_marks_<?=$phd_data[$i]['phd_id']?>" value="<?=$phd_data[$i]['final_marks']?>" readonly> </td>
 <?php if($phd_data[$i]['is_mailsend']=='Y'){ ?>
	 <td style="color:green">Send</td>
	 <?php } else { ?>
	  <td style="color:red">Unsend</td>	
	 <?php } ?>
	<td>
	<a href="javascript:void(0)"  id=""  onclick="add_marks_show(<?=$phd_data[$i]['phd_id']?>, <?=$phd_data[$i]['academic_year']?>,<?=$phd_data[$i]['phd_reg_no']?>)" title="Check/Add/Update Marks"><i class="fa fa-edit"></i></a>  || 
	<?php if($phd_data[$i]['final_marks']!=''){?>
	<a href="<?=base_url($currentModule."/sunpet_student_results_pdf/".$phd_data[$i]['phd_id']."/".$phd_data[$i]['academic_year']) ?>"><i class="fa fa-file-pdf-o" aria-hidden="true" style="font-size:14px;color:red;"></i></a>
	<?php } ?>
	</td>							
                                            <td><a href="<?=base_url($currentModule."/documents/".$phd_data[$i]['phd_id'])?>" target="_blank">View</a> 
                                            <?php
                                            if($phd_data[$i]['fees_paid']=="Y")
                                            {
                                             ?>
                                             <br />
                                              <a href="<?=base_url($currentModule."/generate_hall_ticket_sum/".$phd_data[$i]['phd_id'])?>">Hall Ticket</a>
                                              <!-- <a href="<?=base_url($currentModule."/generate_admit_card/".$phd_data[$i]['phd_id'])?>">Generate Admit Card</a> --> 
                                             <?php
                                            }
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
</div> <!-- <a class="marksat" id="editpayment" data-dept="<?=$phd_data[$i]['department']?>"  data-stud_name="<?= $phd_data[$i]['student_name']; ?>" val="<?=$i?>" 
    						data-fees_id="<?=$phd_data[$i]['payment_id']; ?>" data-toggle="modal" data-target="#walkinModal" style="cursor:pointer"><button class="btn btn-primary btn-xs">Update Payment Status</button></a>-->



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
                                        <form name="editfrm" method="POST" action="<?=base_url()?>phd/update_payment_status" enctype="multipart/form-data" onsubmit="">
                                   
                                        <div class="form-group">
                                          
                                             <div class="col-sm-6"> 
                                                 <label name="" id="">Name : </label>   <span name="exam_sess" id="student_name"></span>
                                                

                                            </div>
                                             <div class="col-sm-6"> 
                                                <label name="" id="">Department : </label> <span name="exam_sess" id="department"></span>
                                                
                                                
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
                                             <option value="P" selected>Pending</option>  
                                      
                                             
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
$("#checkAll").change(function () {
    $(".phd_id").prop('checked', $(this).prop("checked"));
});

              			  
               function add_marks(phd_id,acad_year,reg_no,intv_marks){
				   
                        var url  = "<?=base_url().strtolower($currentModule).'/add_sunpet_marks/'?>"; 
						var phd_id=phd_id;
                        //var entrance_marks=$("#entrance_marks_"+phd_id).val();
                        var entrance_marks=parseFloat($("#entrance_marks_"+phd_id).val()) || 0;
                        var interview_marks=parseFloat(intv_marks);
						var academic_year=acad_year;
						var phd_reg_no=reg_no;
						if (entrance_marks > 100) {
						alert("Entrance Marks cannot be more than 100.");
						$("#entrance_marks_"+phd_id).val('');
						//$("#interview_marks_"+phd_id).val('');
						return;
						}
						if(interview_marks > 100){
						alert("Interview Marks cannot be more than 100.");
						$("#interview_marks_"+phd_id).val('');
						return;
						}
						var finalMarks = entrance_marks + interview_marks;
						$("#final_marks_"+phd_id).val(finalMarks);
						
						var final_marks=$("#final_marks_"+phd_id).val();
						
                        if(entrance_marks==''){
                                alert("please enter Entrance Marks");
                        }
                        else if(interview_marks==''){
                                alert("please enter Interview Marks");
                        }
						else if(final_marks ==''){
							 alert("please enter Final Marks");
						}
						else 
						{ 
                         $.ajax
            ({
                type: "POST",
                url: url,
                data:{entrance_marks:entrance_marks,interview_marks:interview_marks,final_marks:final_marks,phd_id:phd_id,academic_year:academic_year,phd_reg_no:phd_reg_no},
                cache: false,
                crossDomain: true,
                success: function(data)
                {  


                },
                error: function(data)
                {
                    alert("Page Or Folder Not Created..!!");
                }
            });
           }				
		}

		$(document).ready(function() {
		    
		 $(document).on("click", '#editpayment', function () {
   // var ye = $(this).value();
     //var va = $(this).attr('val');
    //alert(va);
      

            var fees_id = $(this).attr("data-fees_id");
	 var student_name = $(this).attr("data-stud_name");
	 var department = $(this).attr("data-dept");
	
	//	alert(examname);
  
				$("#student_name").html(student_name);
                 $("#department").html(department);
		$("#fees_id").val(fees_id);


    });		    
		    
		    
		    
		    
		$("#btnsearch").on('click',function(){
		var dept = $("#dept").val();
		var pstatus = $("#pstatus").val();
        var yearsession=$("#yearsession").val();
		var url  = '<?=base_url()?>phd/search_reg';	
		var data = {'dept':dept,'pstatus':pstatus,'yearsession':yearsession};		
		$.ajax({
			type: "POST",
			url: url,
			data: data,
			dataType: "html",
			cache: false,
			crossDomain: true,
			success: function(data){
				$('#gettotaldata').html(data);
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
                      <script>
$(document).ready(function() {
    $('#search-table').DataTable( {
        dom: 'Bfrtip',
        targets: 'no-sort',
bSort: false,
     bPaginate: false,
        buttons: [
            
            {
                extend: 'excelHtml5',
                title: 'PHD List'
            }
            /*{
                extend: 'pdfHtml5',
                title: 'PHD List'
            }*/
        ]
    } );

       
} );

		
$(".numbersOnly").keydown(function (event) {
    var num = event.keyCode;
    if ((num > 95 && num < 106) || (num > 36 && num < 41) || num == 9 || num == 110 || num == 190) {
        return;
    }
    if (event.shiftKey || event.ctrlKey || event.altKey) {
        event.preventDefault();
    } else if (num != 46 && num != 8) {
        if (isNaN(parseInt(String.fromCharCode(event.which)))) {
            event.preventDefault();
        }
    }
});
function check_marks(phd_id,acad_year,reg_no,marks)
{
	var entrance_marks=parseFloat(marks);
	var interview_marks=parseFloat($("#interview_marks_"+phd_id).val()) || 0;

	            if(entrance_marks==''){
                                alert("please enter Entrance Marks");
                        }
					else if (entrance_marks > 100) {
						alert("Entrance Marks cannot be more than 100.");
						$("#entrance_marks_"+phd_id).val('');
						return;
						}
						else
						{
						   if(interview_marks!=''){
	                       add_marks(phd_id,acad_year,reg_no,interview_marks)
							}
						}
}
function send_hallticket()
{
    var studdata = [];
 $('input[class=phd_id]:checked').each(function() {
   studdata.push($(this).val());
 });
  $("#wait").css("display", "block");
   var url= "<?=base_url().strtolower($currentModule).'/generate_hall_ticket/'?>"; 
		   $.ajax
            ({
                type: "POST",
                url: url,
                data:{studdata:studdata,},
                dataType: "json",
                cache: false,
                crossDomain: true,
                success: function(data)
			    {  console.log();
					$("#wait").css("display", "none");
					alert("Mail Send successfully To Selected Students !!!");
					//location.reload(); 
				},	
				error: function(data)
                {
                    $("#wait").css("display", "none");
					alert("Mail Send successfully To Selected Students !!!");
					location.reload(); 
                }
				
             });   
}
</script>

 <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>