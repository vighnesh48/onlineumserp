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
</style>
<script>    
 $(document).ready(function() {
        $('#amt').keypress(function (event) {
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
	$.ajax({
				type: "POST",
				url: "<?php echo base_url();?>leave/get_emp_code/"+post_data,
				
				success: function(data){
				//	alert(data);          
            $('#emptab').html(data);
         
				}	
			});
	
}
function insert_emp_id(emp,nme,sch,dep,des){
	//alert(emp);
	$('#staffid').val(emp);
	$('#nameid').val(nme);
	$('#schoolid').val(sch);
	$('#departmentid').val(dep);
	$('#designationid').val(des);
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
        <li class="active"><a href="#">Co-Society Deduction Update</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Co-Society Deduction Update</h1>
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
            <?php $ci =&get_instance();
   $ci->load->model('admin_model'); 
    $department =  $ci->admin_model->getDepartmentById($society_details[0]['department']); 
    $school =  $ci->admin_model->getSchoolById($society_details[0]['emp_school']);
    $desg = $ci->admin_model->getDesignationById($society_details[0]['designation']);               
   ?>
                        <div class="table-info">                                                              
                             <div id="dashboard-recent" class="panel-warning">   
                               <div class="panel">
                            	<div class="panel-heading"><strong>Co-Society Deduction Update</strong></div>
                                <div class="panel-body">
								<span id="flash-messages" style="color:red;padding-left:110px;"><?php echo $this->session->flashdata('message1'); ?></span>
                                <div class="panel-padding no-padding-vr">
                            <div class="form-group">
                              <div class="row"></div>
							  <div class="portlet-body form">
							  <form id="form" name="form" action="<?=base_url($currentModule.'/emp_society_update_submit')?>"  method="POST"  enctype="multipart/form-data">
							   <input type="hidden" name="soc_id" value="<?php echo $society_details[0]['soc_id'];?>"/>
							   
								<div class="form-body">
							
								        <div class="form-group">
										<div class="row">
										<div class="col-md-6">
										    
										     <div class="form-group">
                                <label class="col-md-4">Staff Id</label>
                                <div class="col-md-3">
                                  <input type="text" class="form-control" name="staffid" value="<?php echo $society_details[0]['emp_id']; ?>" id="staffid" />
                                </div>
                                
                              </div>									
																	<div class="form-group">
								<label class="col-md-4">Name</label>
                                             <div class="col-md-8" >
	 <input type="text" class="form-control" readonly name="ename" value="<?php if($society_details[0]['gender'] == 'male'){ $m = 'Mr.'; }elseif($society_details[0]['gender'] == 'female'){ $m='Mrs.'; }echo $m." ".$society_details[0]['fname']." ".$society_details[0]['lname']?>" id="nameid" />								   
                                       </div>			 
                                  </div>    
								 
<div class="form-group">
								<label class="col-md-4">School </label>
                                             <div class="col-md-8" >
	 <input type="text" class="form-control" readonly name="school" value="<?php echo $school[0]['college_code']; ?>" id="schoolid" />
                                       </div>
                                  </div>                      				  
								  <div class="form-group">
								<label class="col-md-4">Amount </label>
                                             <div class="col-md-3" >
	 <input type="text" class="form-control col-md-6" required maxlength="5"   name="amt" value="<?php echo $society_details[0]['soc_amount']; ?>" id="amt" />
                                       </div>
                                  </div>  
						
							  
								</div>
										
<div class="col-md-6">
<div class="form-group">
<label class="col-md-6">&nbsp;</label>
                                             <div class="col-md-6" >
	 &nbsp;
                                       </div>
</div>

<div class="form-group">
								<label class="col-md-4">Department</label>
                                             <div class="col-md-8" >
	 <input type="text" class="form-control" readonly name="department" value="<?php echo $department[0]['department_name']; ?>" id="departmentid" />
                                       </div>
                                  </div>  
								  <div class="form-group">
								<label class="col-md-4">Designation</label>
                                             <div class="col-md-8" >
	 <input type="text" class="form-control" readonly name="designation" value="<?php echo $desg[0]['designation_name']; ?>" id="designationid" />
                                       </div>
                                  </div> 
								   <div class="form-group">
								<label class="col-md-4">Active From</label>
                                             <div class="col-md-3" >
	 <input type="text" class="form-control" readonly name="active_form" required value="<?php echo date('Y-m',strtotime($society_details[0]['active_from'])); ?>" id="active_form" />
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
$(function(){
	 $('#active_form').datepicker({
       autoclose: true,
    minViewMode: 1,
    format: 'yyyy-mm'        
    });	
});
</script>


