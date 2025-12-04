    <div style="text-align:right;margin-right: 34px;">
        <input type="button" id="expdata" value="Export as Excel" class="btn btn-primary btn-labeled">
        </div>
     <?php if(count($emp_list)>0)
                    {
                        
                    ?>
                    <style>
                    .table-info thead th, .table-info thead tr{background: #774545;border-color:#FFFFFF !important}
                    </style>
                    <table class="table table-bordered" id="table2excel">
                        <thead>
                            <tr style="">
                                 <th>Sr No</th>
                                    <th>PRN</th>
                                   
                                    <th>Name</th>
                                     <th>School </th>
                                    <th>Stream </th>
                                    <th>Year</th>
                                     <th>Academic Year</th>
                                  
                                     <th>Cancellation Fee</th>
                                    <th>Cancellation Date</th>
                                      <th>Remark</th>
                                    <th class="noExl">Action</th>
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php
                          //  var_dump($emp_list);
                          
                            $j=1;                            
                            for($i=0;$i<count($emp_list);$i++)
                            {
                                
                            ?>
							 <?php if($emp_list[$i]['ro_flag']=='on') $bg="bgcolor='#e6eaf2'";
								  else $bg="";?>								
                            <tr <?=$bg?> <?=$emp_list[$i]["status"]=="N"?"style='background-color:#FBEFF2'":""?>>
                               
                        <td><?=$j?></td>
                                 <td><?=$emp_list[$i]['enrollment_no']?></td> 
                                 
                           
                                <td>
							
							<?php
								echo $emp_list[$i]['first_name']." ".$emp_list[$i]['middle_name']." ".$emp_list[$i]['last_name'];
								?>
								</td> 
							 <td><?=$emp_list[$i]['school_short_name']?></td> 
								   <td><?=$emp_list[$i]['stream_short_name']?></td> 
                                                                                              
                            <td><?=$emp_list[$i]['admission_year']?></td>                               
                                       <td><?=$emp_list[$i]['academic_year']?></td>                    
                             
                                  <td><?=$emp_list[$i]['canc_fee'];?></td> 
                                <td style="color: red;"><?=  date('d-m-Y',strtotime($emp_list[$i]['canc_date']));?></td> 
                                   <td><?=$emp_list[$i]['canc_remark'];?></td> 
                                          
                                <td class="noExl" style="padding:0px;" align="center">
                                    <p> 
			<a  href="<?php echo base_url()."ums_admission/view_studentFormDetails/".$emp_list[$i]['stud_id'].""?>" title="View" target="_blank"><i class="fa fa-eye"></i>&nbsp;  </a>
	       <a href="javascript:void(0)"  title='De-cancel'  onclick="student_decancel(<?=$emp_list[$i]['stud_id']?>)"><i class="fa fa-edit"></i></a></p>	   
	      
                             </td>
                            </tr>
                            <?php
                            $j++;
                            }
                            ?>                            
                        </tbody>
                    </table>
                    <?php
                    }
                    ?>
<div id="updatestudent" class="modal fade" role="dialog">
  <div class="modal-dialog" >
    <!-- Modal content-->
    <div class="modal-content" >
       <div class="modal-header">
        <button type="button" class="btn btn-default pull-right" data-dismiss="modal">&times;</button>
        <p class="modal-title" ><strong>Student Info :- </strong> 
        </p>
      </div>
      <div class="modal-body" >
      <div class="row table-responsive">    
          <div class="form-group">                 
            <label  class="col-form-label">PRN:-</label>
            <input name="prn_no" class="form-control" id="prn_no" readonly>	
         </div>
     <div class="form-group">                 
            <label  class="col-form-label">Student Name:-</label>
            <input name="name" class="form-control" id="name" readonly>	
         </div>		 
          <div class="form-group">                 
            <label  class="col-form-label">Remark</label>
            <textarea name="remark" class="form-control" id="remark" ></textarea>		
         </div>
		 
		  <input type="hidden" class="form-control" id="stud_id">
       </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" id='submit' class="btn btn-default" >Submit</button>
      </div>
    </div>
    </div>
    </div>
	 <script>
$("#expdata").click(function(){

  $("#table2excel").table2excel({

    exclude: ".noExl",

    name: "Worksheet Name",
  filename: "Student List" //do not include extension

  });

});

function student_decancel(stud_id){

             
              var url  = "<?=base_url().strtolower($currentModule).'/get_student_details/'?>"+stud_id; 
                  $.ajax
            ({
                type: "POST",
                url: url,
               // data: data,
                dataType: "json",
                cache: false,
                crossDomain: true,	
                success: function(data)
                {  		
                       // console.log(data);
					   var middle_name ='';
                       var last_name ='';
						if(data['0']['middle_name']!= null)
						{
						   middle_name=data['0']['middle_name'];
						}
						if(data['0']['last_name']!= null)
						{
						   last_name=data['0']['last_name'];
						}                      					
                        $("#stud_id").val(data['0']['stud_id']);
						$("#prn_no").val(data['0']['enrollment_no']);	
                        $("#name").val(data['0']['first_name']+' '+middle_name+' '+last_name);									
                        $("#updatestudent").modal('show');
                },
                error: function(data)
                {
                    alert("Page Or Folder Not Created..!!");
                }
              });
           }
		 
		 	$(document).ready(function() {
				
           $("#submit").click(function(){
			   
			  if (confirm('Are you sure, You want to De-cancel it?')) {
               update_student();
            } 			   
		   });
		});
		   
		   
		   
		function update_student()
		{
			var url  = "<?=base_url().strtolower($currentModule).'/student_decancel/'?>"; 
                        var stud_id=$("#stud_id").val();
                        var remark=$("#remark").val();
						if(remark==''){
                                alert("please enter remark");
								return false;
                        }
						$.ajax
            ({
                type: "POST",
                url: url,
                data:{stud_id:stud_id,remark:remark},
                cache: false,
                crossDomain: true,
                success: function(data)
                {  
				 // console.log(data);
						if(data==1){
							    
								alert("Student De-Cancellation Succesfully Done");
								location.reload();
						}
						else{
						 alert("Something went wrong,please try again ");        
						}
						
                  
                },
                error: function(data)
                {
                    alert("Page Or Folder Not Created..!!");
                }
            });
			
		}
                     </script>
                    