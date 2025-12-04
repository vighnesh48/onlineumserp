<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>

<script>    
    $(document).ready(function(){
     var base_url = 'https://erp.sandipuniversity.com/';
     
      $("#emp_data_show").hide();
       $("#msg-alert").hide();

    	$("#resign_date").datepicker({       
        autoclose: true,
		format: 'dd-mm-yyyy',
		todayHighlight: true		
    });
    
     $('#button_reset').click(function(){
         
          window.location.href = base_url + 'employee/resign_list';
     });
     
     $('#save_resign').click(function(){
         var resign_date=$("#resign_date").val();
         var resign_reason=$("#resign_reason").val();
         var emp_id=$("#emp_id").val();
         var dateAr = resign_date.split('-');
         var r_date = dateAr[2] + '-' + dateAr[1] + '-' + dateAr[0];
        if(resign_date=="" && resign_reason==""){
            alert("Please enter the resign details.");
        }
        else
        {
            $.ajax({
                    'url' : base_url + 'employee/save_employee_resign',
                    'type' : 'POST', //the way you want to send data to your URL
                    'data' :{'emp_id':emp_id,'resign_date':r_date,'resign_reason':resign_reason}   ,
                    'success':function (str1){
                                 window.location.href = base_url + 'employee/resign_list';
                            }
            });
        }
     });
    
        
    
        $('#button').click(function(){
                 var emp_code = $("#emp_code").val();
                var emp_table= "";
                  if(emp_code==""){
                      alert("Please enter the valid Employee id.");
                  }
                  else
                  {
                     
                      
                      $.ajax({
                            'url' : base_url + 'employee/get_resign_employee',
                            'type' : 'POST', //the way you want to send data to your URL
                            'data' : {'emp_code':emp_code},
                            'success':function (str){
                             // alert(str);
                             if(str==0){
                                  alert("No any recodrs exist for such Employee ID.");
                                   $("#emp_info").html("");
                                     $("#emp_data_show").hide();
                                }
                              else
                             {
                                 var emp_arr = JSON.parse(str);
                                var dateAr = emp_arr.joiningDate.split('-');
                                var join_date = dateAr[1] + '-' + dateAr[2] + '-' + dateAr[0];
                                emp_table= "<table style='margin-left:10%;margin-top:5%;width:60%;' border='1'><tr><td style='background:#D2D2D2; width:30%;' >Empoyee ID</td><td>"+emp_arr.emp_id+"</td></tr><tr><td style='background:#D2D2D2;'>Empoyee Name</td><td >"+emp_arr.fname+" "+emp_arr.mname+" "+emp_arr.lname+"</td></tr><tr><td style='background:#D2D2D2;'>Local Address</td><td colspan='2'>"+emp_arr.lflatno+""+emp_arr.larea_name+"<br>Tal:"+emp_arr.ltaluka+",Dist:"+emp_arr.ldist+"<br> State:"+emp_arr.lstate+" ,"+emp_arr.lcountry+",Pincode:"+emp_arr.lpincode+"</td></tr><tr><td style='background:#D2D2D2;'>Permanent Address</td><td colspan='2'>"+emp_arr.pflatno+""+emp_arr.parea_name+"<br>Tal:"+emp_arr.ptaluka+",Dist:"+emp_arr.pdist+"<br> State:"+emp_arr.pstate+", "+emp_arr.pcountry+",Pincode:"+emp_arr.p_pincode+"</td></tr><tr><td style='background:#D2D2D2;'>Mail(Personal)</td><td colspan='2'>"+emp_arr.pemail+"</td></tr><tr><td style='background:#D2D2D2;'>Mobile No</td><td >"+emp_arr.mobileNumber+"</td></tr><tr><td style='background:#D2D2D2;'>Alternate  No</td><td >"+emp_arr.alternateno+"</td></tr><tr><td style='background:#D2D2D2;'>Date of Joining</td><td >"+join_date+"</td></tr></table>";
                                $("#emp_data_show").show();
                                $("#emp_info").html(emp_table);
                               $("#emp_id").val(emp_arr.emp_id);
                              }
                               // alert(emp_table);
                                
                                
                                
                            }
                      });
                            
           
                  }
            
            
        });
      

		
    });

</script>
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="#"></a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Employee Resign Form</h1>
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
                            <span class="panel-title">Employee Details</span>
                    </div>
                    <div class="panel-body">
                        <div class="table-info">

                               <div class="row">
                                   <div class="form-group">
                                    <div class="col-sm-1"></div>
                                       <label class="col-sm-2">Employee ID:</label>
                                        <div class="col-sm-2"><input type="text" class="form-control" name="emp_code" id="emp_code"/></div>
                                         <div class="col-sm-2"><button class="btn btn-primary form-control" id="button" type="button" >View</button></div>
                                     
                                       
                                </div>
                                <hr>
                                
                            <span id ="emp_data_show" >
                                 <span id="emp_info"></span>   
                                <input type='hidden' name='emp_id' id='emp_id' >
                                        <table style='margin-left:10%;margin-bottom:5%;width:60%;' border='1'><tr><td style='background:#D2D2D2; width:30%;'>Resignation Date</td><td ><div class='col-sm-3'> <input type='text' id='resign_date' name='resign_date' class='form-control'  style='width:150px' /></div>  </td></tr><tr><td style='background:#D2D2D2;'>Resignation Reason</td><td ><div class='col-sm-8'><textarea class='form-control col-xs-8' id='resign_reason'></textarea></div></td></tr></table>
                                        <div class='row'><div class='col-sm-3'></div><div class='col-sm-2'><button class='btn btn-primary form-control' id='save_resign' type='button' >Save</button></div><div class='col-sm-2'><button class='btn btn-primary form-control' id='button_reset' type='reset'>Cancel</button></div></div>
   
                            </span>
                    
                </div>
            </div>    
        </div>
    </div>
</div>