
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
				 <select class="form-control" name="course_id" id="course_id">
				   <option value='0'>All</option>  
				      <option value='14'>Regular</option>
				         <option value='16'>NACC</option>
				           <option value='15'>Ph.D</option>
					           </div>
					              </select>
					            </div>						  
				             <div class="col-sm-1"><button class="btn btn-primary" id="btnserachdigi">View</button></div>			  
                          </div>
                        </div>                          
                    </div>					 
               </div>
				 <div class="panel-body">
                   <div class="table-info" >
                     <table class="table table-bordered" id="example">
                        <thead id="bd_tb" width="100%">
                            <tr>
							   <th class='text-center'>#</th>
								 <th class='text-center'>Academic Year</th>	
								   <th class='text-center'>New Admissions</th>
								     <th class='text-center'>Re-registration Admissions</th>
									 <th class='text-center'>Final Year Students</th>
									 <th class='text-center'>Passout Students</th>
								      <th class='text-center'>Cancle Admissions</th>
								    <th class='text-center'>Total Admissions</th>
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
        $(document).ready(function(){	
        $("#btnserachdigi").trigger("click");								  
		                  });

	$("#btnserachdigi").click(function(){
	   $('#itemContainer').empty();	
	     $('#example').dataTable().fnDestroy(); 
		var course_id= $('#course_id').val();

                $.ajax({
                       type:'POST',
                       url: '<?= base_url() ?>Admin/admission_report_details_fetch',
                       data: 'course_id='+course_id,
					   dataType: "json",
                       success: function (data) {
						   $('#itemContainer').empty();	                 
                    if(data['stud_data'].length>0){						
						var j=1;
					
		             $.each(data['stud_data'], function(i, item){

						  totstud=parseInt(item.new_adm) + parseInt(item.rr_adm);
						   var tbl="";
						   tbl+="<tr class='text-center'>";
						   tbl+="<td>"+j+"</td>";
						   tbl+="<td>"+item.academic_year+"</td>";
						   tbl+='<td><a target="_blank"  href="<?=base_url()?>Admin/display_student_details/'+item.academic_year+'/'+item.course_id+'/'+0+'/N">'+item.new_adm+'</a></td>';
						   tbl+='<td><a target="_blank"  href="<?=base_url()?>Admin/display_student_details/'+item.academic_year+'/'+item.course_id+'/'+0+'/R">'+item.rr_adm+'</a></td>';
						   tbl+='<td><a target="_blank"  href="<?=base_url()?>Admin/display_student_details/'+item.academic_year+'/'+item.course_id+'/'+0+'/P">'+item.final_year_student+'</a></td>';
						   tbl+='<td><a target="_blank"  href="<?=base_url()?>Admin/display_student_details/'+item.academic_year+'/'+item.course_id+'/'+0+'/DC">'+item.passout_student+'</a></td>';
						   tbl+='<td><a target="_blank"  href="<?=base_url()?>Admin/display_student_details/'+item.academic_year+'/'+item.course_id+'/'+0+'/C">'+item.cancel_adm+'</a></td>';
                           tbl+='<td><a target="_blank"  href="<?=base_url()?>Admin/display_student_details/'+item.academic_year+'/'+item.course_id+'">'+Math.abs(totstud)+'</a></td>';						   
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
									 'excel',
								],					  
							  });                        							
						  }
						  else
						  {     
					           var tbl="";
							   tbl+="<tr>";
							   tbl+="<td colspan='5'>No Record Found!!!</td>";
							   tbl+="</tr>"; 
							   $('#itemContainer').append(tbl);   
						  }							  
                      }   		                       
                   }); 
               }); 	
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








