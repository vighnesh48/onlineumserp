<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
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
.mob{width:70px;}
.mobd{width:70px;}
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
$(document).ready(function() {
        $('.mob').keypress(function (event) {
            return isNumber(event, this)
        });
    });
    function isNumber(evt, element) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (
            (charCode != 45  || $(element).val().indexOf('-') != -1) &&      // “-” CHECK MINUS, AND ONLY ONE.
            (charCode != 46 || $(element).val().indexOf('.') != -1) &&      // “.” CHECK DOT, AND ONLY ONE.
            (charCode < 48 || charCode > 57) && (charCode != 8))
            return false;
        return true;
    }    
function show_upload_div(){
    
    
}
function calculate_amt(mob){
    //alert(mob);
 var ml = $('#moblim_'+mob).closest("tr").find(".mobl").text();
 var amt = $('#moblim_'+mob).closest("tr").find(".mob").val();
 //alert(amt);
 if(amt == ''){
     amt = 0;
 }
 var dec = parseInt(amt) - parseInt(ml);
 if(parseInt(dec) < 0 ){
     $('#det_'+mob).val('0');
 }else{
     $('#det_'+mob).val(dec);
	
 }
 //return false;
}
$(document).ready(function() {
    $('#mform2').bootstrapValidator({
        framework: 'bootstrap',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
             row: {
        valid: 'field-success',
        invalid: 'field-error'
    },
        fields: {
            month: {
                validators: {
                   
                     notEmpty: 
                      {
                       message: 'Select type.'
                      }
                    
                }
            }
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
        <li class="active"><a href="#">Employee Mobile Bill Add</a></li>
    </ul>
    <div class="page-header">           
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Employee Mobile Bill Add</h1>
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
            <div class="col-sm-6">
                <div class="panel">
                 <form method="POST" id="mform" enctype="multipart/form-data" action="<?=base_url($currentModule.'/add_mobile_bill_list')?>">
                     
                <div class="panel-heading">
                      <div class="row">
                      <div class="col-md-6" >For a month of <b><span id="mdiv"></span></b></div>
                
                <div class="col-md-2" class="form-control ">
                <h4>Month </h4> 
                </div>
                <div class="col-md-3">
                <input type="text" class="form-control "  required name="month" value="" id="fmonth" /> 
                </div>
                
                </div>  
                        
                </div>                       
                    <div class="panel-body" style="min-height:500px;overflow-y: scroll;">
                        <div class="table-info">                         
                                                               
                             <div id="dashboard-recent" class="panel-warning">            
                                
                                <span id="flash-messages" style="color:red;padding-left:110px;"><?php echo $this->session->flashdata('message1'); ?></span>
                                <div class="panel-padding no-padding-vr">
                                      <div class="form-group">                              
                              <div class="portlet-body form">                               
                                
                                <div class="form-group" id="empl">
                                <table class='table table-bordered'><thead><tr><th>Sr.no</th><th>Emp Id</th><th>Mobile No</th><th>Limit</th><th>Bill</th><th>Deduction</th>
								<th>Monthly Charges</th><th>Local</th><th>STD</th><th>ISD</th><th>GPRS</th><th>Download</th><th>SMS</th><th>Conference Call Charges</th><th>Roming</th><th>Discount</th><th>Previous balance</th><th>Grand Total</th><th>SGST</th><th>CGST</th><th>Current Charges</th>
								</tr></thead><tbody>
                                <?php 
                                $i=1;
                        //        $ci =&get_instance();
  // $ci->load->model('admin_model');
                                foreach($mobile_list as $bill){
                                    // $department =  $ci->admin_model->getDepartmentById($bill['department']); 
                                 //$school =  $ci->admin_model->getSchoolById($bill['emp_school']); 
                                 
echo "<tr id='moblim_".$bill['mobile']."' >";
echo "<td>".$i."</td>";
echo "<td><input type='hidden' name='empid_".$bill['mobile']."' value='".$bill['emp_id']."' />".$bill['emp_id']."</td>";
//echo "<td>".$school[0]['college_code']."</td>";
//echo "<td>".$department[0]['department_name']."</td>";
echo "<td><input type='hidden'  name='mobileno[]' value='".$bill['mobile']."' />".$bill['mobile']."</td>";
echo "<td class='mobl'>".$bill['mobile_limit']."</td>";
if(!empty($upd_mob_list)){
   //echo '<pre>';print_r($upd_mob_list);exit;
if(isset($upd_mob_list[$bill['mobile']][0])){
$mb = $upd_mob_list[$bill['mobile']][16];//exit;
}else{
    $mb ='0';
}

}
echo "<td><input type='input' class='mob' name='amt_".$bill['mobile']."' onblur='calculate_amt(".$bill['mobile'].");' value='".$mb."' /></td>";
echo "<td><input type='input' readonly class='mobd' name='det_".$bill['mobile']."' id='det_".$bill['mobile']."' value='".$bill['det']."' /></td>";
echo "<td><input type='input' readonly class='mobd' name='monthlycharges_".$bill['mobile']."' id='monthlycharges_".$bill['mobile']."' value='".$upd_mob_list[$bill['mobile']][2]."' /></td>";
echo "<td><input type='input' readonly class='mobd' name='local_".$bill['mobile']."' id='local_".$bill['mobile']."' value='".$upd_mob_list[$bill['mobile']][3]."' /></td>";
echo "<td><input type='input' readonly class='mobd' name='std_".$bill['mobile']."' id='std_".$bill['mobile']."' value='".$upd_mob_list[$bill['mobile']][4]."' /></td>";
echo "<td><input type='input' readonly class='mobd' name='isd_".$bill['mobile']."' id='isd_".$bill['mobile']."' value='".$upd_mob_list[$bill['mobile']][5]."' /></td>";
echo "<td><input type='input' readonly class='mobd' name='gprs_".$bill['mobile']."' id='gprs_".$bill['mobile']."' value='".$upd_mob_list[$bill['mobile']][6]."' /></td>";
echo "<td><input type='input' readonly class='mobd' name='downloads_".$bill['mobile']."' id='downloads_".$bill['mobile']."' value='".$upd_mob_list[$bill['mobile']][7]."' /></td>";
echo "<td><input type='input' readonly class='mobd' name='messagingcharges_".$bill['mobile']."' id='messagingcharges_".$bill['mobile']."' value='".$upd_mob_list[$bill['mobile']][8]."' /></td>";
echo "<td><input type='input' readonly class='mobd' name='conferenceecallcharges_".$bill['mobile']."' id='conferenceecallcharges_".$bill['mobile']."' value='".$upd_mob_list[$bill['mobile']][9]."' /></td>";
echo "<td><input type='input' readonly class='mobd' name='roamingcharges_".$bill['mobile']."' id='roamingcharges_".$bill['mobile']."' value='".$upd_mob_list[$bill['mobile']][10]."' /></td>";
echo "<td><input type='input' readonly class='mobd' name='discount_".$bill['mobile']."' id='discount_".$bill['mobile']."' value='".$upd_mob_list[$bill['mobile']][11]."' /></td>";

echo "<td><input type='input' readonly class='mobd' name='previousbalance_".$bill['mobile']."' id='previousbalance_".$bill['mobile']."' value='".$upd_mob_list[$bill['mobile']][12]."' /></td>";

echo "<td><input type='input' readonly class='mobd' name='grandtotal_".$bill['mobile']."' id='grandtotal_".$bill['mobile']."' value='".$upd_mob_list[$bill['mobile']][13]."' /></td>";
echo "<td><input type='input' readonly class='mobd' name='sgst_".$bill['mobile']."' id='sgst_".$bill['mobile']."' value='".$upd_mob_list[$bill['mobile']][14]."' /></td>";
echo "<td><input type='input' readonly class='mobd' name='cgst_".$bill['mobile']."' id='cgst_".$bill['mobile']."' value='".$upd_mob_list[$bill['mobile']][15]."' /></td>";
echo "<td><input type='input' readonly class='mobd' name='currentcharges_".$bill['mobile']."' id='currentcharges_".$bill['mobile']."' value='".$upd_mob_list[$bill['mobile']][16]."' /></td>";

//echo "<td><input type='hidden' readonly class='mobd' name='totalamountdue_".$bill['mobile']."' id='totalamountdue_".$bill['mobile']."' value='".$upd_mob_list[$bill['mobile']][14]."' /></td>";
echo "</tr>";
    $i++;
    if(!empty($upd_mob_list)){
    echo "<script>calculate_amt(".$bill['mobile'].");</script>";
    }
}
?></tbody></table>                              
                                </div>
                                <!-- <div class="form-group">OR</div>
                                <div class="form-group">
                                 <label class="col-md-2">File</label>
                                 <input type="hidden" class="form-control"  name="month1" value="" id="month1" />
                                <div class="col-md-4">
                                <input type="file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" class="form-control" name="file_up" value="" id="fileup" />
                                </div>
                                 <div class=" col-md-2">  
                                       <button type="submit" name="fupload"  id="submit" class="btn btn-primary form-control" value="fupload" >Upload</button>
                                        </div>                              
                                </div> -->
                                <div class="form-group">
                                   <div class="col-md-3" ></div>
                                      <div class=" col-md-3">  
                                            <button type="submit" id="submit" class="btn btn-primary form-control" >Submit</button>
                                        </div>
                                        <div class="col-sm-3"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule)?>/emp_mobile_bill_list'">Cancel</button></div>
                                 
                                    </div>  
<!-- <div class="form-group">
<p><b>Note: 1.</b> Upload Excel Xls or xlsx File. <br/> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b> 2.</b> File format must be same. <a href="<?php echo base_url();?>test.xlsx" target="_blank">Sample File</a>  </p>

</div>    -->                               
                                                                                       
                                    </div>
    </div>
                               </div>
                                </div>
                            </div> 
                          </div>  </form>                       
                </div>
                </div>
<div class="col-sm-6">

<div class="panel">               
                
                <div class="panel-heading">
                      <div class="row">
                <div class="col-md-3" class="form-control ">
                <h4>File Upload</h4> 
                </div>
                
                </div>  
                        
                </div>                    
                    <div class="panel-body">
                    
                                                     <form class="form-horizontal" action="<?=base_url($currentModule.'/upload_csv_file_mob_bill')?>" method="post" name="upload_excel" enctype="multipart/form-data">
                                <div class="form-group" >
                <label class="col-md-10"><input type="file" class="form-control tds-upload" accept=".csv" name="fupl" /></label>
                <label class="col-md-2 "><input type="submit" class="btn btn-primary"  value="Upload" /></label>
                </div>
                <div class="form-group">
                 <label> <span id="flash-messages" style="color:red;"><?php echo $this->session->flashdata('umessage'); ?></span></label>
        <label class="col-md-12">Note:
        <label class="col-md-12"> 1) Please upload CSV file only
        
</label>
<label class="col-md-12 "> 2) Download CSV file format <a href="<?=base_url($currentModule.'/download_csv_format_mobile')?>" ><i class="fa fa-download"></i></a></div>


                </form>
                    </div>

</div>



            </div>    
        </div>
    </div>
</div>
<script type="text/javascript">
var monthNames = ["","Jan", "Feb", "Mar", "Apr", "May", "Jun",
  "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
];
    $('#fmonth').datepicker({format: "yyyy-m",startView: "months",minViewMode: "months",autoclose:true}).on('changeDate', function (selected) {  
    $('#month1').val($(this).val());
     var my = $(this).val().split("-");  
                $('#mdiv').text(monthNames[my[1]]+' '+my[0]);
    $.ajax
            ({
                type: "POST",
                url: "<?=base_url().strtolower($currentModule).'/check_monthly_mobbill/'?>"+$(this).val(),
               // data: data,
                dataType: "html",
                cache: false,
                crossDomain: true,
                success: function(data)
                {  
                 if(data=='false'){
                  $('#flash-messages').html('Final Salary is submited.');
                 $('#submit').hide();
                 $('#empl').hide();
                }else{
                   $('#flash-messages').html(data);
                   $('#submit').show();
                   $('#empl').show();
                }
                }
            });
         });    
</script>


