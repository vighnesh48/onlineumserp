<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>

<script>    
    $(document).ready(function()
    {
	$('#form1').bootstrapValidator	
({ 
message: 'This value is not valid',
            group: 'form-group',
            feedbackIcons: 
                 {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
                  },
			 row: {
        valid: 'field-success',
        invalid: 'field-error'
                  },
            fields: 
                  {
					search_id:	
                         {
                             validators: 
                               {
                                    notEmpty: 
                                       {
                                        message: 'Please Enter Student Id,this should not be empty'
                                         }                     
                                }
						  }
				  }
})	
	});
	
	
	
	
	
	 $(document).ready(function(){
               $('#hostid').click(function(){
       
             var base_url = '<?=site_url()?>';
                   // alert(type);
                   var acyear = $("#hidacyear").val();
                    var fcid = $("#hidfacid").val();
    
                $.ajax({
                    'url' : base_url + 'Hostel/facility_fee_details',
                    'type' : 'POST', //the way you want to send data to your URL
                    'data' : {'acyear':acyear,'fcid':fcid},
                    'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
                      //  var container = $('#showhost'); //jquery selector (get element by id)
                        if(data){
							   var jdata= JSON.parse(data);
                            $('#showhost').show();
						//	alert(jdata.deposit);
							             $("#fdeposit").html(jdata.deposit);
                                     $("#ffees").html(jdata.fees);
									  $("#fmid").val(jdata.sffm_id);
                        //  alert(data);
                            //alert("Marks should be less than maximum marks");
                            //$("#"+type).val('');
                          //   $('showhost').html(data);
                            	return false;
                        }
                          return false;
                    }
                });
            });
			
			
			
			
			
		              $('#reg').click(function(){
       
             var base_url = '<?=site_url()?>';
                   // alert(type);
				    var prn = $("#prn").val();
                   var acyear = $("#hidacyear").val();
                    var fcid = $("#hidfacid").val();
					   var org = $("#org").val();
                        var cyear = $("#cyear").val();
						 var exem = $("#exem").val();
						 var stud_id = $("#stud_id").val(); 
						  var fmid = $("#fmid").val(); 
                $.ajax({
                    'url' : base_url + 'Hostel/register_for_facility',
                    'type' : 'POST', //the way you want to send data to your URL
                    'data' : {'prn':prn,'acyear':acyear,'fcid':fcid,'org':org,'cyear':cyear,'exem':exem,'stud_id':stud_id,'fmid':fmid},
                    'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
                      //  var container = $('#showhost'); //jquery selector (get element by id)
					  //alert(data);
                        if(data){
							alert("Student Registered for facility successfully");
							var lin ='<a href="<?=site_url()?>Hostel/hostel_allocation_view/'+prn+'/'+stud_id+'/'+org+'/'+data+'"><input type="button" value="Allocate hostel"></a>';
							 $('#showhost').html(lin);
                        //  alert(data);
                            //alert("Marks should be less than maximum marks");
                            //$("#"+type).val('');
                          //   $('showhost').html(data);
                            	return false;
                        }
                          return false;
                    }
                });
            });	
			
			
			
			
			
			
			
			
			
			
			
			
			
            });
	
	
      
</script>
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
   
    <div class="page-header">			
    
     
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                     

                    <div id="dashboard-recent" class="panel panel-warning">        
                   
			    		<div class="panel-body">
						
						<!--<form id="form1" name="form1" enctype="multipart/form-data" action="<?=base_url($currentModule.'/search_student')?>" method="POST">-->
                       <div class="row">
					 
					<!--  <div class="col-sm-1"></div>
                      <div class="col-sm-3"><input type="text" class="form-control" name="prn" id="prn" placeholder="Enter Student PRN No."></div><label class="col-sm-1"></label>
                      <div class="col-sm-2"><button class="btn btn-primary form-control" id="sbutton" type="button" >Search</button></div>
					   <div class="col-sm-6"></div>
				-->
					  
					  
					 
					  <div class="row">
					   <div class="form-group">
					   <div class="col-sm-3"></div>
					   <div class="col-sm-6">
					   <?php 
					   echo "<span style='color:red;padding-left:110px;'>".@$this->session->flashdata('message1')."</span>";
					   ?>
					   </div>
					 </div>                      
                      </div>
					 <!-- </form>-->
                </div>
                
   
               
                    <div class="table-info" id="stddata">  
              
                    <style>
                    .table-info thead th, .table-info thead tr{background: #ffffff;color:#000000 !important}
                    </style>
					<input type="hidden" name="hidacyear" id="hidacyear" value="<?=$student_list['academic_year']?>">
					<input type="hidden" name="hidfacid" id="hidfacid" value="1">
					<input type="hidden" name="cyear" id="cyear" value="<?=$student_list['current_year']?>">
						<input type="hidden" name="stud_id" id="stud_id" value="<?=$student_list['stud_id']?>">
							<input type="hidden" name="fmid" id="fmid" value="">
							
							
                    <table class="table table-bordered" id="table2excel">
                        <thead>
                            <tr style="">
                                 <td><strong>Student Name(Enrollment No)</strong></td>
                                    <td>	<?php
								echo $student_list['first_name']." ".$student_list['middle_name']." ".$emp_list['student_list'];
								?>(<?=$student_list['enrollment_no']?>)</td>  
									<td><strong>Organisation</strong></td>
                                    <td><?=$student_list['organisation']?></td>
                            </tr>
							 <tr style="">
							   <td><strong>Academic Year</strong></td>
                                    <td><?=$student_list['academic_year']?></td>
                                 <td><strong>Admission Session</strong></td>
                                    <td><?=$student_list['admission_session']?></td>
                            </tr>
							
								 <tr style="">
							   <td><strong>Admission Year(Semester)</strong></td>
                                    <td><?=$student_list['admission_year']?>(<?=$student_list['admission_semester']?>)</td>
                                 <td><strong>Current Year(Semester)</strong></td>
                                    <td><?=$student_list['current_year']?>(<?=$student_list['current_semester']?>)</td>
                            </tr>
							
							
							 <tr style="">
                                 <td><strong>Institute</strong></td>
                                    <td><?=$student_list['school_name']?></td>
									   <td><strong>Course(Stream)</strong></td>
                                    <td><?=$student_list['course_name']?>(<?=$student_list['stream_name']?>)</td>
									
                            </tr>
							
								 <tr style="">
                                 <td><strong>Email</strong></td>
                                    <td><?=$student_list['email']?></td>
									   <td><strong>Mobile</strong></td>
                                    <td><?=$student_list['mobile']?></td>
									
                            </tr>
							
								 <tr style="">
                                 <td><strong>Opted Hostel Facility</strong></td>
                                    <td><?php if($student_list['stat']=="Y"){echo "Yes";
									?>
									<a href="<?=site_url()?>Hostel/view_std_payment/<?=$student_list['enrollment_no']?>/<?=$student_list['stud_id']?>"><input type="button" value="View Payment Details"></a>
									<?php
									} 
									else
									{
										?>
										<input type="button" value="Apply For Hostel" id="hostid" name="hostid">
										<?php
									}
									
									?>
	
									</td>
								<td colspan="2" >	 
<div id="showhost" name="showhost" style="display:none">
<strong>Facility Deposit </strong><span id="fdeposit"></span><br>
<strong>Facility Fees  </strong><span id="ffees"></span><br>
<strong>Enter Exempted fees </strong><input type="text" name="exem" id="exem"><br>
<input type="button" value="Register" id="reg" name="reg">
</div>
								</td>
                                  
									
                            </tr>
						
                        </thead>
                    
                    </table>
                   
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                 
                </div>
         
                
                
                
                
                
                
                
                
                
            </div>    
        </div>
    </div>
</div>
</div>
</div>