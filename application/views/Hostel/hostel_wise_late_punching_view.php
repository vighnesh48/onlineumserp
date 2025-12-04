
<style>.form-control {
    margin-bottom: 4px!important;
}	
</style>

<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Masters</a></li>
        <li class="active"><a href="#">Digital</a></li>
    </ul>
        <div class="row ">
            <div class="col-sm-12">			
                <div class="panel">
                    <div class="panel-heading panel-info">
                   <div class="form-group">	
           	  <div class="col-sm-3">
				 <select class="form-control" name="report_id" id="report_id" onChange="load_hostels(this.value)" >
				   <option value='1'>All Students inOut punching Report</option>  
				   <option value='2'>Main Gate inOut punching Report</option>  
				   <option value='3'>Late Punch-Boys Report</option>  
				   <option value='4'>Late Punch-Girls Report</option>  
						 </select>
					          </div>
             <div class="hidden" id='host_by'>   							  
			   <div class="col-sm-3">
				 <select class="form-control" name="hostel_id_by" id="hostel_id_by">
				   <option value='0'>All</option>  
				   <?php foreach($hostel_list_by as $row){ ?>
				      <option value='<?=$row['host_id']?>'><?=$row['hostel_name'].'-'.$row['hostel_code']?></option>
				             <?php } ?>
						    </select>
					           </div></div>
       <div class="hidden" id='host_gl'>				  
			   <div class="col-sm-3">
				 <select class="form-control" name="hostel_id_gl" id="hostel_id_gl">
				   <option value='0'>All</option>  
				   <?php foreach($hostel_list_gl as $row){ ?>
				      <option value='<?=$row['host_id']?>'><?=$row['hostel_name'].'-'.$row['hostel_code']?></option>
				             <?php } ?>
						    </select>
					           </div></div>
								  <div class="col-sm-3"><input type="date" id="log_date" name="log_date" class="form-control"  	 value="<?=date("Y-m-d");?>"/></div>
								  <div class="col-sm-1"><button class="btn btn-primary" id="btnserachdigi">View</button></div>
					            </div>		  
                          </div>
                        </div>                          
                    </div>					 
               </div>
				 <div class="panel-body">
                   <div class="table-info" >
                     <table class="table table-bordered" id="example">
                 <!--   <button id='pdf_main' class="dt-button buttons-excel buttons-html5" onclick="functionTopdf()">PDF</button>-->
                      <!--a id='pdf_main' class="dt-button buttons-excel buttons-html5" href="<?php echo base_url()?>hostel/hostel_wise_students_inout_punching_report/" >PDF</a--> 
						<thead id="bd_tb" width="100%">
						 <tr bgcolor="#9ed9ed" >
							 <td  class='text-center'><strong>SRNo.</strong></td>
							 <td  class='text-center'><strong>Enrollment no</strong></td>
							 <td  class='text-center'><strong>punching Prn</strong></td>
							 <td  class='text-center' ><strong>Name Of Student</strong></td>
							  <td  class='text-center'><strong>Direction</strong></td>
							 <td  class='text-center'><strong>Punching Time</strong></td>
							 <td class='text-center'><strong>Hostel</strong></td>
							 </tr>
                          </thead>
                        <tbody id="itemContainer">						
                           </tbody>
                        </table>
					 </form>
                  </div>
               </div>				
            </div>    
       </div>
<script>
 $(document).ajaxStart(function(){
    $("#wait").css("display", "block");
});

$(document).ajaxComplete(function(){
    $("#wait").css("display", "none");
}); 
	/*  function functionTopdf()
	 {
		var log_date= $('#log_date').val();
		 $.ajax({
                       type:'POST',
                       url: '<?= base_url() ?>Admin/hostel_wise_students_inout_punching_report',
                       data: 'log_date='+log_date,
                       success: function (data) {
						 
					   }
		 });  
	 } */
        $(document).ready(function(){	
        $("#btnserachdigi").trigger("click");
        var log_date= $('#log_date').val();	
		$('#sd').html(log_date);
		                  });

	$("#btnserachdigi").click(function(){
	   $('#itemContainer').empty();	
	     $('#example').dataTable().fnDestroy(); 
		var hostel_id_by= $('#hostel_id_by').val();
		var hostel_id_gl= $('#hostel_id_gl').val();
		var log_date= $('#log_date').val();
		var report_id= $('#report_id').val();

                $.ajax({
                       type:'POST',
                       url: '<?= base_url() ?>hostel/hostel_wise_late_punching_details_fetch',
                       data: 'hostel_id_by='+hostel_id_by+'&hostel_id_gl='+hostel_id_gl+'&log_date='+log_date+'&report_id='+report_id,
					   dataType: "json",
                       success: function (data) {
						   $('#itemContainer').empty();	                 
                    if(data['stud_data'].length>0){						
						var j=1;
					
		             $.each(data['stud_data'], function(i, item){
						   var tbl="";
						   tbl+="<tr class='text-center'>";
						   tbl+="<td>"+j+"</td>";
						   tbl+="<td>"+item.enrollment_no+"</td>";	   
						   tbl+="<td>"+item.punching_prn+"</td>";	   
						   tbl+="<td>"+item.student_name	+"</td>";	   
						   tbl+="<td>"+item.direction+"</td>";	   
						   tbl+="<td>"+item.LogDate+"</td>";	   
						   tbl+="<td>"+item.hostel_name+"</td>";	   
						   tbl+="</tr>";	  
						   $('#itemContainer').append(tbl);
						   j++;
							}); 
                              $('#example').DataTable({
								orderCellsTop: true,
								fixedHeader: true,
								dom: 'lBfrtip',
								destroy: true,
								retrieve:true,
								paging:false,
								info: false,
								buttons: [
									 'excel','pdf',
								],					  
							  });                        							
						  }
						  else
						  {     
					           var tbl="";
							   tbl+="<tr>";
							   tbl+="<td colspan='6'>No Record Found!!!</td>";
							   tbl+="</tr>"; 
							   $('#itemContainer').append(tbl);   
						  }							  
                      }   		                       
                   }); 
               }); 

          function load_hostels(id)
	 {
		 if(id=='1')
		 {
			$("#pdf_main").removeClass('hidden'); 
			$("#host_by").addClass('hidden');
			$("#host_gl").addClass('hidden');
		 } 
		 else if(id=='3')
		 {
			 $("#host_by").removeClass('hidden');
			 $("#host_gl").addClass('hidden');
			 $("#pdf_main").addClass('hidden');
		 }
		 else if(id=='4')
		 {
			$("#host_gl").removeClass('hidden');
			 $("#host_by").addClass('hidden'); 
			 $("#pdf_main").addClass('hidden');
		 }
		 else
		 {
			 $("#host_by").addClass('hidden');
			 $("#host_gl").addClass('hidden');
			 $("#pdf_main").addClass('hidden');
		 }
	 } 
	 

</script>

<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.flash.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.min.js"></script>
<div id="wait" style="display:none;width:40px;height:40px;position:absolute;top:50%;left:50%;z-index:99999;"><img src='<?=site_url()?>assets/images/demo_wait_b.gif' width="64" height="64" /><br>Loading..</div>








