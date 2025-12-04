<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<script src="<?=base_url()?>assets/javascripts/moment.js"></script>
<script src="<?=base_url('assets/javascripts').'/bootstrap-datetimepicker.min.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
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
   .help-block {
   color: red;}
</style>
<script type="text/javascript">
   $(document).ready(function(){
      $('#formww').bootstrapValidator
        ({  
            message: 'This value is not valid',
            group: 'form-control',
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
                staffid:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Staff ID should not be empty'
                      },regexp: 
                      {
                        regexp: /^[0-9/]+$/,
                        message: 'Staff ID should be numeric'
                      }
                    }
                },date:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Date should not be empty'
                      }
                    }
                }
            }       
        });
   $("#datepicker1").datepicker({       
           autoclose: true,
      format: 'dd-mm-yyyy'
       }).on('changeDate', function (e) {
         //  $('#form').bootstrapValidator('revalidateField', 'date');
  });
       
       
       $("#staffid").keypress(function(e) {
    if(e.which == 13) {
        search_emp_code();
    }
});

   });
   function search_emp_coff(){
    var sid = $('#staffid').val();
    var edate = $('#datepicker1').val();
    $.ajax({
          type: "POST",
          url: "get_emp_coff/"+sid+"/"+edate,
          
          success: function(data){
          //  alert(data);          
               $('#empcoff').html(data);
            
          } 
        });
   }
   function search_emp_code(){
   //alert('gg');
    var post_data = $('#staffid').val();
    $.ajax({
          type: "POST",
          url: "get_emp_code/"+post_data,
          
          success: function(data){
          //  alert(data);          
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
  //$('#form').bootstrapValidator('revalidateField','staffid');
   }
   
   function validateForm() {
    var na = document.forms["form"]["nota"].value;
    var sc = document.forms["form"]["special_case"].checked;
  var uf = document.forms["form"]["upload_file"].value;
  var st = document.forms["form"]["status"].value;
  var rm = document.forms["form"]["remark"].value;
  if(na=='1'){
    if(sc == false){
      alert("Select Special Case");
        return false;
    }else if(uf == ""){
      alert("Select File");
        return false;
    }
  }
     if(st == ""){
    alert("Select Status");
        return false;
  }else if (rm == "") {
        alert("Remark should not be empty");
        return false;
    } 
} 
</script>

<?php
   $astrik='<sup class="redasterik" style="color:red">*</sup>';
   ?>
<div id="content-wrapper">
   <ul class="breadcrumb breadcrumb-page">
      <div class="breadcrumb-label text-light-gray">You are here: </div>
      <li><a href="#">Leaves</a></li>
      <li class="active"><a href="#">Employee Leave Allocation</a></li>
   </ul>
   <div class="page-header">
      <div class="row">
         <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;C-Off Credit Application</h1>
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
               <div class="panel-body">
                  <div class="table-info">
                     <div id="dashboard-recent" class="panel-warning">
                        <div class="panel">
                           <div class="panel-heading"><strong>Employee C-OFF </strong></div>
                           <div class="panel-body">
                              <span id="flash-messages" style="color:red;padding-left:110px;"><?php echo $this->session->flashdata('message1'); if(isset($_GET['e'])){ if($_GET['e']=='1'){ echo 'Your file is not an acceptable format(pdf,doc,txt); ';}} ?></span>
                              <div class="panel-padding no-padding-vr">
                                 <div class="form-group">
                                    <div class="row"></div>
                                    <div class="portlet-body form">
                                       <form id="form" name="form" onsubmit="return validateForm()" action="<?=base_url($currentModule.'/add_employee_coff')?>" method="POST" enctype="multipart/form-data">
                                          <div class="form-body">
                                             <div class="col-md-7">
                                                <div class="form-group">
                                                   <label class="col-md-3">Staff Id</label>
                                                   <div class="col-md-4" >
                                                      <input type="text" class="form-control" name="staffid" required value="" id="staffid" />
                                                   </div>
                                                   <div class="col-md-4" >
                                                      <input type="button" id="semp" onclick="search_emp_code()"  class="btn btn-primary " value="Search">
                                                   </div>
                                                </div>
                                                <div class="form-group">
                                                   <label class="col-md-3">Name</label>
                                                   <div class="col-md-7" >
                                                      <input type="text" class="form-control" readonly name="ename" value="" id="nameid" />                  
                                                   </div>
                                                </div>
                                                <div class="form-group">
                                                   <label class="col-md-3">School </label>
                                                   <div class="col-md-7" >
                                                      <input type="text" class="form-control" readonly name="school" value="" id="schoolid" />
                                                   </div>
                                                </div>
                                                <div class="form-group">
                                                   <label class="col-md-3">Department</label>
                                                   <div class="col-md-7" >
                                                      <input type="text" class="form-control" readonly name="department" value="" id="departmentid" />
                                                   </div>
                                                </div>
                                                <div class="form-group">
                                                   <label class="col-md-3">Designation</label>
                                                   <div class="col-md-7" >
                                                      <input type="text" class="form-control" readonly name="designation" value="" id="designationid" />
                                                   </div>
                                                </div>
                                                <div class="form-group">
                                                   <label class="col-md-3">C-Off Date</label>
                                                   <div class="col-md-4">
                                                      <input class="form-control" id="datepicker1" name="date" required   placeholder="Date" type="text" >
                                                    </div>  
                                                    <div class="col-md-4" >
                                                      <input type="button" id="find" onclick="search_emp_coff()"  class="btn btn-primary" value="Search">
                                                   </div>
                                                </div>
                                                <div class="form-group" id="empcoff">
                                                </div>
                                             </div>
                                      
                                       </div>
                                       <div class="col-md-5 " id="emptab">
                                       </div>
                            
                                    </div>
                                               <div class="col-md-6 text-center">  
                                               
                                            <button type="submit" id="fsubmit" name="submit" class="btn btn-primary "  >Submit</button>
                                        
                              <button type="button" class="btn btn-primary " onclick="window.location='<?=base_url($currentModule)?>/employee_coff_list'" >cancel</button>
                           </div>
                                 </div>
                              </div>
                           </div>
                            </form>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

