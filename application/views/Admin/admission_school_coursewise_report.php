
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
				 <select class="form-control" name="academic_year" id="academic_year">
				  <option value="">Select Academic Year</option>
                        <option value="2016"> 2016-17</option>
                        <option value="2017"> 2017-18</option>
						<option value="2018"> 2018-19</option>
						<option value="2019"> 2019-20</option>
						<option value="2020"> 2020-21</option>
						<option value="2021"> 2021-22</option>
						<option value="2022" <?php if($year=='2022-23'){echo 'Selected';} ?>> 2022-23</option>
						<option value="2023" <?php if($year=='2023-24'){echo 'Selected';} ?>> 2023-24</option>
					        </select>
					    </div>
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
							 <th class='text-center' style="width:10%">#</th>
						       <th class='text-center' style="width:10%">Academic Year</th>	
							   <th class='text-center' style="width:10%">School Short Name</th>	
							   <th class='text-center' style="width:10%">Course Short Name</th>
							   <th class='text-center' style="width:30%">Stream Name </th>
							   <th class='text-center' style="width:10%">New Admissions</th>
							   <th class='text-center' style="width:10%">Re-registration Admissions</th>
							   <th class='text-center' style="width:10%">Total Admissions</th>
                                </tr>
                            </thead>
                         <tbody id="itemContainer">		
							</tbody>
                        </table>
                        <table class="table table-bordered">
						 <thead>
                 <tr class='text-center'>
<th style="align:center" >Total New Admissions = <span id="tnadm" class="table table-bordered"></span></th>
							     <th style="align:center" >Total Re-registration Admissions = <span id="tradm" class="table table-bordered"></span></th>
							     <th style="align:center" >Overall Admissions = <span id="toadm" class="table table-bordered"></span></th>
							   </tr>
                           </thead>
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
		var academic_year= $('#academic_year').val();

                $.ajax({
                       type:'POST',
                       url: '<?= base_url() ?>Admin/admission_school_coursewise_details_fetch',
                       data: 'course_id='+course_id+'&academic_year='+academic_year,
					   dataType: "json",
                       success: function (data) {
						   $('#itemContainer').empty();	                 
                     if(data['stud_data'].length>0){						
						var j=1;var tnew_adm=0;var trr_adm=0;var tt_adm=0;
					       $("#tnadm").html('');
					       $("#tradm").html('');
					       $("#toadm").html('');
		             $.each(data['stud_data'], function(i, item){

						  totstud=parseInt(item.new_adm) + parseInt(item.rr_adm);

						   tnew_adm=parseInt(tnew_adm)+parseInt(item.new_adm);
						   trr_adm=parseInt(trr_adm)+parseInt(item.rr_adm);
						   tt_adm=parseInt(tt_adm)+parseInt(totstud);
						   var academic_year=item.academic_year;
						   var course_id=item.course_id;

						   tbl="";
						   tbl+="<tr class='text-center'>";
						   tbl+="<td>"+j+"</td>";
						   tbl+="<td>"+item.academic_year+"</td>";
						   tbl+="<td>"+item.school_short_name+"</td>";
						   tbl+="<td>"+item.course_short_name+"</td>";
						   tbl+="<td>"+item.stream_name+"</td>";

                           tbl+='<td><a target="_blank"  href="<?=base_url()?>Admin/display_student_details/'+item.academic_year+'/'+item.course_id+'/'+item.stream_id+'/N">'+item.new_adm+'</a></td>';
				
                            tbl+='<td><a target="_blank"  href="<?=base_url()?>Admin/display_student_details/'+item.academic_year+'/'+item.course_id+'/'+item.stream_id+'/R">'+item.rr_adm+'</a></td>';
						
                            tbl+='<td><a target="_blank"  href="<?=base_url()?>Admin/display_student_details/'+item.academic_year+'/'+item.course_id+'/'+item.stream_id+'">'+Math.abs(totstud)+'</a></td>';
						   tbl+="</tr>";	  
						   $('#itemContainer').append(tbl);
						   j++;
							});
						
							$("#tnadm").html('<a target="_blank"  href="<?=base_url()?>Admin/display_student_details/'+academic_year+'/'+course_id+'/'+0+'/N">'+tnew_adm+'</a>');
				
							$("#tradm").html('<a target="_blank"  href="<?=base_url()?>Admin/display_student_details/'+academic_year+'/'+course_id+'/'+0+'/R">'+trr_adm+'</a>');
	
							$("#toadm").html('<a target="_blank"  href="<?=base_url()?>Admin/display_student_details/'+academic_year+'/'+course_id+'/'+0+'">'+tt_adm+'</a>');
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
							   tbl+="<td colspan='8'>No Record Found!!!</td>";
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








