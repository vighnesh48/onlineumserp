
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
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp; Ph.D. Results</h1>
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
                     <div class="row ">
                             <div class="col-sm-6">
                                 </div>
                              <!--    <form method="post">

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
			</div>	
	

</form>-->
 <div class="col-sm-3">
<a href="<?=base_url($currentModule)?>/results"><input type="button" value="Result PDF" class="btn btn-primary" id=""></a>
<a href="<?=base_url($currentModule)?>/phd_results_excel"><input type="button" value="Result Excel" class="btn btn-primary" id=""></a>
                             </div>  
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
                                    
                                     <th>Registration No.</th>
                                    <th>Applicant Name</th>
                                  <th>Branch</th>
                                  <th>Degree Type</th>
                                   <th>Marks Scored</th>
                                   
                                    <th>Action</th>     
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
                                <td><?=$j?></td>          
                                     <td><?=$phd_data[$i]['reg_no']?></td>
                                 <td><?=$phd_data[$i]['student_name']?></td>
                          <td><?=$phd_data[$i]['stream']?></td> 
                             <td><?=$phd_data[$i]['exam_type']?></td> 
                               <td><?=$phd_data[$i]['marks_obtained']?></td> 
                               
                      
                     
                                            <td><a href="<?=base_url($currentModule."/student_results_pdf/".$phd_data[$i]['reg_no'])?>"><i class="fa fa-file-pdf-o" aria-hidden="true" style="font-size:14px;color:red;"></i></a> 
                                           
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
		var url  = '<?=base_url()?>/phd/search_reg';	
		var data = {'dept':dept,'pstatus':pstatus};		
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
