<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<script src="<?=site_url()?>assets/javascripts/jspdf/jspdf.js" type="text/javascript"></script>

<style>
.attexl table{
	 border: 1px solid black;
}
.attexl table th{
 border: 1px solid black;
    padding: 5px;
    background-color:grey;
    color: white;
}
.attexl table td{
	 border: 1px solid black;
    padding: 5px;
}
</style>
<script>    
   
       
       
 function getEmp_using_dept1(dept_id,sid,did){
var e = document.getElementById(sid);
var school_id = e.options[e.selectedIndex].value;
var post_data='';
if(school_id!=null && dept_id!=null){
               
				post_data+="&school="+school_id+"&department="+dept_id;
				
			}
        
jQuery.ajax({
				type: "POST",
				url: base_url+"Employee/getEmpListDepartmentSchool1",
				data: encodeURI(post_data),
				success: function(data){
					//alert(data);
				$('#'+did).html(data);
         		}	
			});

}
 
function getdept_using_school1(school_id,did){
//alert(school_id);
 var post_data=schoolid='';
	var schoolid=school_id;
           if(school_id!=null){

				post_data+="&school_id="+schoolid;
				
			}
 jQuery.ajax({
				type: "POST",
				url: base_url+"admin/getdepartmentByschool",
				data: encodeURI(post_data),
				success: function(data){
					//alert(data);
				        
            //$('#reporting_dept').append(data);
            $('#'+did).html(data);
           //$("#dept-emp").html(emp_list);
				}	
			});

	
}

</script>
<script type="text/javascript">

function search_emp_code(t){
	//alert('gh');
	if(t=='r'){
		var post_data = $('#rstaffid').val();
	}else{
	var post_data = $('#staffid').val();
	}
	if(t=='r'){
				url1 = "<?php echo base_url();?>Employee/display_emp_details/"+post_data;
				}else{
				url1 = "<?php echo base_url();?>Employee/get_report_emp/"+post_data;	
				}
				//alert(url1);
	if(post_data == null || post_data == ''){
		alert('Insert staff id value.');
	}else{
	$.ajax({
				type: "POST",
				url: url1,
				success: function(data){
				//	alert(data);          
            //$('#emptab').html(data);
			var empd = data.split('-');
			if(empd[0]=='1'){
				$('#flash-messages').text('Employee is not reporting person.');
			}else{
				$('#flash-messages').text('');
			if(t=='r'){
				$('#rby1').html(data);	
              			$('#rby1').show();	
				$('#rby').hide();
       
			}else{
				  $('#nameid').val(empd[0]);
		 $('#departmentid').val(empd[1]);
		 $('#schoolid').val(empd[2]);
		 $('#designationid').val(empd[3]);
			}
				}	
				}
			});
	}
}
function insert_emp_id(empid,empn,sch,dep,des){
	$('#rby1').hide();
	$('#rby').show();
	$('#rstaffid').val(empid);
	$('#rnameid').val(empn);
		 $('#rdepartmentid').val(dep);
		 $('#rschoolid').val(sch);
		 $('#rdesignationid').val(des);
}
</script>
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Employee</a></li>
        <li class="active"><a href="#">Change Reporting</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Change Reporting</h1>
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
                
                        <div class="table-info">                                  
                                                               
                             <div id="dashboard-recent" class="panel-warning">   
                               <div class="panel">
                            	<div class="panel-heading"><strong>Change Reporting</strong></div>
                                <div class="panel-body">
								<span id="flash-messages" style="color:red;padding-left:110px;"><?php echo $this->session->flashdata('message1'); ?></span>
                                <div class="panel-padding no-padding-vr">
                            <div class="form-group">
                              <div class="row"></div>
							  <div class="portlet-body form">
							  <form id="form" name="form" onsubmit="return confirm('Are you sure you want to change '+$('#staffid').val()+' to '+$('#rstaffid').val()+' ?');" action="<?=base_url($currentModule.'/change_reporting_submit')?>"  method="POST"  enctype="multipart/form-data">
							    <input type="hidden" name="er_id" value=""/>
							    <?php 
							   echo $err;
							    ?>
								<div class="form-body">
							<div class="form-group">
							<label class="col-md-3"><input type="radio" name="route" value="1" /> Route 1</label>
                                <label class="col-md-3"><input type="radio" name="route" value="2" /> Route 2</label>
							</div>
								        <div class="form-group">
										<div class="row">
										<div class="col-md-6">
										    <div class="form-group">
                                <label class="col-md-6"><b>Replace For:</b></label>
								</div>
										     <div class="form-group">
                                <label class="col-md-6">Staff Id</label>
                                <div class="col-md-4">
                                  <input type="text" class="form-control" required name="staffid" value="" id="staffid" />
                                </div>
                                <div class="col-md-2 text-right">
                                <a href="#" class="btn btn-primary" id="semp" onClick="search_emp_code('e')"><span class="glyphicon glyphicon-search"></span></a>
                                <!--<input type="button" id="semp" onClick="search_emp_code()"  class="" value="Search"/>-->
                                </div>
                              </div>
										    
										    
										    
									
																	<div class="form-group">
								<label class="col-md-6">Name</label>
                                             <div class="col-md-6" >
	 <input type="text" class="form-control" readonly name="ename" value="" id="nameid" />								   
                                       </div>			 
                                  </div>    
								  
<div class="form-group">
								<label class="col-md-6">School </label>
                                             <div class="col-md-6" >
	 <input type="text" class="form-control" readonly name="school" value="" id="schoolid" />
                                       </div>
                                  </div>                                      
<div class="form-group">
								<label class="col-md-6">Department</label>
                                             <div class="col-md-6" >
	 <input type="text" class="form-control" readonly name="department" value="" id="departmentid" />
                                       </div>
                                  </div>  
								  <div class="form-group">
								<label class="col-md-6">Designation</label>
                                             <div class="col-md-6" >
	 <input type="text" class="form-control" readonly name="designation" value="" id="designationid" />
                                       </div>
                                  </div>  		
																	
									  </div>
										<div class="col-md-6" >
										 <div class="form-group">
                                <label class="col-md-6"><b>Replace By:</b></label>
								</div>
										<div class="form-group">
                                <label class="col-md-6">Staff Id</label>
                                <div class="col-md-4">
                                  <input type="text" class="form-control" required name="rstaffid" value="" id="rstaffid" />
                                </div>
                                <div class="col-md-2 text-right">
                                <a href="#" class="btn btn-primary" id="semp" onClick="search_emp_code('r')"><span class="glyphicon glyphicon-search"></span></a>
                                <!--<input type="button" id="semp" onClick="search_emp_code()"  class="" value="Search"/>-->
                                </div>
                              </div>
										    
										  <div id="rby1" ></div>  
										    <div id="rby" style="display:none;">
									
																	<div class="form-group">
								<label class="col-md-6">Name</label>
                                             <div class="col-md-6" >
	 <input type="text" class="form-control" readonly name="rename" value="" id="rnameid" />								   
                                       </div>			 
                                  </div>    
								
<div class="form-group">
								<label class="col-md-6">School </label>
                                             <div class="col-md-6" >
	 <input type="text" class="form-control" readonly name="rschool" value="" id="rschoolid" />
                                       </div>
                                  </div>                                      
<div class="form-group">
								<label class="col-md-6">Department</label>
                                             <div class="col-md-6" >
	 <input type="text" class="form-control" readonly name="rdepartment" value="" id="rdepartmentid" />
                                       </div>
                                  </div>  
								  <div class="form-group">
								<label class="col-md-6">Designation</label>
                                             <div class="col-md-6" >
	 <input type="text" class="form-control" readonly name="rdesignation" value="" id="rdesignationid" />
                                       </div>
                                  </div>  		
									</div>										
									  </div>	
										</div>
																 
                                  </div> 							
<div class="form-group">
								   <div class="col-md-3" ></div>
                                      <div class=" col-md-2">  
                                            <button type="submit" id="submit" class="btn btn-primary form-control" >Submit</button>
                                        </div>
                                        <div class="col-sm-2"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule)?>/employee_reporting'">Cancel</button></div>
                                  
                                    </div>								  
                            </div>							
                                    </form>									
									</div>    </div>
							   </div>
                                </div>
                            </div> 
                          </div>                          
                           
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    
<script type="text/javascript">
function myFunction() {
  // Declare variables
  var input, filter, table, tr, td, i;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}

</script>


