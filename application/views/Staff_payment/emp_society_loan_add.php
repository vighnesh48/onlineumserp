<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<script src="<?=base_url()?>assets/javascripts/moment.js"></script>
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
.emp-mo-m .form-group {
    margin-bottom: 7px;
}
.emp-mo-m label{font-weight:normal;font-size:12px;}

</style>
<script>    
 $(document).ready(function() {
        $('#amt_limt').keypress(function (event) {
            return isNumber(event, this)
        });
    });
	function isNumber(evt, element) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (
            (charCode != 45 || $(element).val().indexOf('-') != -1) &&      // “-” CHECK MINUS, AND ONLY ONE.
            (charCode != 46 || $(element).val().indexOf('.') != -1) &&      // “.” CHECK DOT, AND ONLY ONE.
            (charCode < 48 || charCode > 57))
            return false;
        return true;
    }    
    $(document).ready(function()
    {       
       $("#submit").click(function(){
            var sid = $('#staffid').val();
              var favorite = [];
var f = 0;
            $.each($("input[name='ch[]']:checked"), function(){ 
                            favorite.push($(this).val());
            });           
            fLen = favorite.length;
           // alert(favorite);
            for (i = 0; i < fLen; i++) {
                var kk = $('#reporting_person'+favorite[i]).val();
              //  alert(kk);
                if(kk == ''){
                    f = favorite[i];   
                }
}
if(f!=0){
     alert('select reporting '+f);
  return false;
}
 if(sid == null || sid == ''){
	alert('select Staff Id');
  return false; 
 }      
       });		
});
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
function check_sel_rep(chk){
    var f ;
    if($("#"+chk).is(':checked')) {
     if(chk > 1){
         for(var i=1;i<chk;i++){
        if($("#"+i).is(':checked')){
   f = 0; // checked
}else{
    f = 1;
   $("#"+chk).prop('checked', false); 
    }
         }
        if(f==1){
            alert('select previous reporting');
        }
    }
    }else{
         for(var i=chk;i<=4;i++){
        $("#"+i).prop('checked', false); 
         }
    }  
    }
function search_emp_code(){
	//alert('gg');
	var post_data = $('#staffid').val();
  if(post_data == null || post_data == ''){
    alert('Insert staff id value.');
  }else{
	$.ajax({
				type: "POST",
				url: "<?php echo base_url();?>leave/get_emp_code/"+post_data,				
				success: function(data){
				//	alert(data);          
            $('#emptab').html(data);         
				}	
			});	
}
}
function insert_emp_id(emp,nme,sch,dep,des){
	//alert(emp);
  $('#empd').show();
	$('#staffid').val(emp);
	$('#nameid').text(nme);
	$('#schoolid').text(sch);
	$('#departmentid').text(dep);
	$('#designationid').text(des);
	$("#etable").remove();
}
</script>
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Staff payment</a></li>
        <li class="active"><a href="#">Co-Society Loan Form</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Co-Society Loan Form</h1>
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
                            	<div class="panel-heading"><strong>Co-Society Loan Add</strong></div>
                                <div class="panel-body">
								<span id="flash-messages" style="color:red;padding-left:110px;"><?php echo $this->session->flashdata('message1'); ?></span>
                                <div class="panel-padding no-padding-vr">
                            <div class="form-group">
                              <div class="row"></div>
							  <div class="portlet-body form">
							  <form id="form" name="form" action="<?=base_url($currentModule.'/emp_society_loan_add_submit')?>"  method="POST"  enctype="multipart/form-data">
							   
								<div class="form-body">							
								        <div class="form-group">
										<div class="row">
										<div class="col-md-6 emp-mo-m">										    
										     <div class="form-group">
                                <label class="col-md-4"><b>Staff Id</b></label>
                                <div class="col-md-6">
                                  <input type="text" class="form-control" name="staffid" value="" id="staffid" />
                                </div>
                                <div class="col-md-2 text-right">
                                <a href="#" class="btn btn-primary" id="semp" onClick="search_emp_code()"><span class="glyphicon glyphicon-search"></span></a>
                                <!--<input type="button" id="semp" onClick="search_emp_code()"  class="" value="Search"/>-->
                                </div>
                              </div>
                              <div id="empd" style="display:none;">									
																	<div class="form-group">
								<label class="col-md-4"><b>Name</b></label>
                                             <div class="col-md-8" >
	 <label id="nameid"></label>								   
                                       </div>			 
                                  </div>    
								 
<div class="form-group">
								<label class="col-md-4"><b>School</b> </label>
                                             <div class="col-md-8" >
	 <label id="schoolid"></label>
                                       </div>
                                  </div>                      				  
								  <div class="form-group">
                <label class="col-md-4"><b>Department</b></label>
                                             <div class="col-md-8" >
   <label id="departmentid"></label>
                                       </div>
                                  </div>  
                  <div class="form-group">
                <label class="col-md-4"><b>Designation</b></label>
                                             <div class="col-md-8" >
   <label id="designationid"></label>
                                       </div>
                                  </div>
					 <div class="form-group">
								<label class="col-md-4"><b>Loan Amount</b></label>
                                             <div class="col-md-6" >
	 <input type="text" class="form-control" required maxlength="5"   name="loan_amt" value="" id="amt" />
                                       </div>
                                  </div>  		  	
 							  <div class="form-group">
								<label class="col-md-4"><b>Start Period</b></label>
                                             <div class="col-md-6" >
	 <input type="text" class="form-control"  name="active_form" required value="" id="active_form" />
                                       </div>
                                  </div> 
                      
                  <div class="form-group">
                <label class="col-md-4"><b>End Period</b></label>
                                             <div class="col-md-6" >
   <input type="text" class="form-control"  name="active_to" required value="" id="active_to" />
                                       </div>
                                  </div><div class="form-group">
                <label class="col-md-4"><b>Monthly Deduction</b> </label>
                                             <div class="col-md-6" >
   <input type="text" class="form-control" required maxlength="5"   name="mon_dec" value="" id="mon_dec" />
                                       </div>
                                  </div>  <br/>                
</div> </div> 
<div class="col-md-6" id="emptab">
												</div></div>
<div class="form-group">
								   <div class="col-md-3" ></div>
                                      <div class=" col-md-2">  
                                            <button type="submit" id="submit" class="btn btn-primary form-control" >Submit</button>
                                        </div>
                                        <div class="col-sm-2"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule)?>/emp_society_list'">Cancel</button></div>
                                  
                                    </div>	

                                    </form>									
									</div>   </div>
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
     $(function () {
                    $("#form").submit(function () {
                        var fromdate = new Date($("#active_form").val()); //Year, Month, Date
                        var todate = new Date($("#active_to").val()); //Year, Month, Date
                        if (todate > fromdate) {
                            return true;
                        } else {
                            return false;
                        }
                    });
                });
$(function(){
	 $('#active_form').datepicker({
       autoclose: true,
    minViewMode: 1,
    format: 'yyyy-mm'        
    });	
	 $('#active_to').datepicker({
       autoclose: true,
    minViewMode: 1,
    format: 'yyyy-mm'        
    });	
});
$("#active_to").change(function () {
    var startDate = document.getElementById("active_form").value;
    var endDate = document.getElementById("active_to").value;
    if ((Date.parse(startDate) >= Date.parse(endDate))) {
        alert("To date should be greater than Start date");
        document.getElementById("active_to").value = "";
    }
});
</script>