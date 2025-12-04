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
    padding: 5px;border-collapse: collapse
}
.add-table{border:0px!important}
.add-table tr td{border:0px}
.add-table tr td > h3{margin-top:0;margin-bottom:0;font-weight:bold;line-height:0.5}
a {
  color: #fff;
}

.dropdown dd,
.dropdown dt {
  margin: 0px;
  padding: 0px;
}

.dropdown ul {
  margin: -1px 0 0 0;
}

.dropdown dd {
  position: relative; 
}

.dropdown a,
.dropdown a:visited {
  color: #000;
  text-decoration: none;
  outline: none;
  font-size: 12px;
}

.dropdown dt a {
  background-color: #fff;
  display: block;
  padding: 10px;
  overflow: hidden;
  border: 0;
  width: 240px; border: 1px solid #aaa;
}

.dropdown dt a span,
.multiSel span {
  cursor: pointer;
  display: inline-block;
  padding: 0 3px 2px 0;
}

.dropdown dd ul {
  background-color: #fff;
  border: 0;
  color: #000;
  display: none;
  left: 0px;
  padding: 2px 15px 2px 5px;
  position: absolute;
  top: 2px;
  width:100%;
  list-style: none;
  height: 100px;
  overflow-y:scroll; border: 1px solid #aaa;
}

.dropdown span.value {
  display: none;
}

.dropdown dd ul li a {
  padding: 5px;
  display: block;
}
.dropdown dd ul li a:hover {
  background-color: #ddd;
}
</style>
<script>
function onclick_checkbox_emp(eid){
//$('#mutliSelect input[type="checkbox"]').on('click', function() {
//alert('gg');
  var title = $(this).closest('.mutliSelect').find('input[type="checkbox"]').val(),
    title = eid + ",";
//alert(title);
  if ($('#'+eid).is(':checked')) {
    var html = '<span title="' + title + '">' + title + '</span>';
  //alert(html);
    $('.multiSel').append(html);
    $(".hida").hide();
  } else {
    $('span[title="' + title + '"]').remove();
    var ret = $(".hida");
    $('.dropdown dt a').append(ret);

  }
//});
}
function getEmp_using_sch_dep(dept_id){
var e = document.getElementById("emp_school");
var school_id = e.options[e.selectedIndex].value;
var post_data='';
if(school_id!=null && dept_id!=null){
               
        post_data+="&school="+school_id+"&department="+dept_id;
        
      }
        
jQuery.ajax({
        type: "POST",
        url: base_url+"admin/getEmpListbyDepartmentSchool_attendance",
        data: encodeURI(post_data),
        success: function(data){
          //alert(data);
        $('#empid').html(data);
        
            } 
      });

}
 $(document).ready(function()
    { 
  $(".dropdown dt a").on('click', function() {
  $(".dropdown dd ul").slideToggle('fast');
});

$(".dropdown dd ul li a").on('click', function() {
  $(".dropdown dd ul").hide();
});

function getSelectedValue(id) {
  return $("#" + id).find("dt a span.value").html();
}

$(document).bind('click', function(e) {
  var $clicked = $(e.target);
  if (!$clicked.parents().hasClass("dropdown")) $(".dropdown dd ul").hide();
});
  });
</script>
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Attendance</a></li>
        <li class="active"><a href="#">Montly Attendance</a></li>
    </ul>
    <div class="page-header">     
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Montly Attendance</h1>
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
                              <div class="panel-heading"><strong>Monthly Total Attendance </strong></div>
                                <div class="panel-body">
                <span id="flash-messages" style="color:red;padding-left:110px;"><?php echo $this->session->flashdata('message1'); ?></span>
                                <div class="panel-padding no-padding-vr">
                            <div class="form-group">
                              <div class="row"></div>
                <div class="portlet-body form">
                <form id="form" name="form" action="<?=base_url($currentModule.'/total_monthly_attendance')?>" method="POST" enctype="multipart/form-data">
                <div class="form-body">
                <div class="form-group">
                <label class="col-md-3">Select School</label>
                                             <div class="col-md-3" >
                       <select class="select2me form-control" name="emp_school" onchange="getstaffdept_using_school(this.value)" id="emp_school" >
                       <option value="">Select School</option>
                       <?php foreach($school_list as $sc) {
                         echo "<option  value=".$sc['college_id'].">".$sc['college_name']."</option>";
                       } ?>
                      
                         </select>
                                       </div>
                                  </div>
                   <div class="form-group">
                <label class="col-md-3 control-label">Department:<?=$astrik?></label>
                            <div class="col-md-3">
                          <select class="form-control select2me" id="department"  onchange="getEmp_using_sch_dep(this.value)" name="department" >
                      <option value="">Select</option>
                      </select>
                                       </div>
                                  </div>
                                <div class="form-group">
                <label class="col-md-3">Select Month</label>
                                             <div class="col-md-3" >
                                  <input id="dob-datepicker" required class="form-control form-control-inline input-medium date-picker" name="attend_date" value="" placeholder="Enter Month" type="text">

                                             </div>
                                  </div>
                                         <div class="form-group">
                                <label class="col-md-3">Select Employee</label>
                                <div class="col-md-8">                
                <dl class="dropdown">  
    <dt>
    <a href="#">
      <span class="hida">Select</span>    
      <div class="multiSel"></div>  
    </a>
    </dt>  
    <dd>
        <div class="mutliSelect" id="mutliSelect">
            <ul id="empid">
      <?php 
      //print_r($emp_list);
      foreach($emp_list as $key=>$val){ 
               echo '<li>
          <input type="checkbox" name="empsid[]" id="'.$emp_list[$key]['emp_id'].'" onclick="onclick_checkbox_emp('.$emp_list[$key]['emp_id'].');" value="'.$emp_list[$key]['emp_id'].'" /> '.$emp_list[$key]['emp_id'].' - '.$emp_list[$key]['fname'].' '.$emp_list[$key]['lname'].' </li>';
          
                    
       } ?> 
            </ul>
        </div>
    </dd>  
</dl>                         
                </div>
                              </div>    
                              <br/>                                               

                                   <div class="form-group">
                   <div class="col-md-3" ></div>
                                      <div class=" col-md-2">  
                                            <button type="submit" name="submit" class="btn btn-primary form-control" >Submit</button>
                                        </div>
                                       
                                    </div>
                            </div>
                                    </form>
                  </div>
                  <?php 
                   /*  echo"<pre>";
                                  print_r($all_emp);
                                  echo"</pre>";
                  echo"<pre>";
                                  print_r($attendance);
                                  echo"</pre>";  
                                 // die();  */
                  ?>
              
                <div class="pagination" style="float:right;"> <?php  echo $paginglinks['navigation']; ?></div>
<div class="pagination" style="float:left;"> <?php echo (!empty($pagermessage) ? $pagermessage : ''); ?></div>
<form action="table_exporttopdf" method="post" onsubmit='$("#datatodisplay").val( $("<div>").append( $("#ReportTable").eq(0).clone() ).html() )' >
<div class="attexl" id="ReportTable" >
<?php
if(!empty($all_attend)){
//echo $attend_date;
$date =  $attend_date."-01";
$lt=date('t', strtotime($attend_date)); //get end date of month
$end = $attend_date."-".$lt;
$time=strtotime($attend_date);
    $d = date_parse_from_format("Y-m-d",$attend_date);
        $msearch=$d["month"];//month number
        $ysearch=date("Y",strtotime($attend_date));
    $monthName = date('F', mktime(0, 0, 0, $msearch, 10));// month name
    $totaldays=cal_days_in_month(CAL_GREGORIAN, $msearch, $ysearch);
    $i=1;
    //calculate number of sundays in given month
    function total_sundays1($monthName,$ysearch)
{
$sundays=0;
$total_days=cal_days_in_month(CAL_GREGORIAN, $monthName, $ysearch);
for($i=1;$i<=$total_days;$i++)
if(date('N',strtotime($ysearch.'-'.$monthName.'-'.$i))==7)
$sundays++;
return $sundays;
}
$total_sun=total_sundays1($msearch,$ysearch);
$total_holiday=$this->Admin_model->getTotalHoliday($msearch,$ysearch);
//echo $total_holiday;
$working_days=$totaldays-($total_sun+$total_holiday);
?>


<table width="100%" border="0" cellspacing="0" cellpadding="0"  class="add-table">
  <tr>
    <td align="center"><b>Monthly Employee Present Days Report Of <?=$monthName?>  <?=$ysearch?> </b></td>
  </tr>
</table>
<br/>



<table  cellpadding="0" cellspacing="0" style="font-size:11px" width="100%" align="center" class="attexl">
<tbody>
<!--<tr style="border: 1px solid black;"><td colspan="9"style="border: 1px solid black;"></td>
 <td colspan="10" style="border: 1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Leave</td>
 <td style="border: 1px solid black;"></td>
 </tr>-->
 <tr bgcolor="#9ed9ed" >
 <td><strong>SRNo.</strong></td>
 <td ><strong>Staff ID</strong></td>
 <td width="18%"><strong>Name Of Employee</strong></td>
 <td ><strong>Month Days</strong></td>
 <td ><strong>Working Days</strong></td>
 <td ><strong>Present Days</strong></td>
 <td ><strong>Sunday</strong></td>
 <td ><strong>Holiday</strong></td>
 <td ><strong>OD</strong></td>
 <td ><strong>CL</strong></td>
 <td ><strong>ML</strong></td>
 <td ><strong>EL</strong></td>
 <td ><strong>C-off</strong></td>
 <td ><strong>SL</strong></td>
 <td ><strong>VL</strong></td>
 <td><strong>Leave</strong></td>
 <!--<td style="border: 1px solid black;">Other</td>-->
 <td ><strong>LWP</strong></td>
 
 <!--<td style="border: 1px solid black;">Lcome/EG o</td>-->
 <td ><strong>Total</strong></td>
  </tr>

 <?php 
 //print_r($all_attend);
 //exit;
 //echo $sbtn;
 if($sbtn=='1'){ foreach($all_attend as $key=>$val){ ?>
 <tr> 
   <td ><?=$i++;?></td>
<td ><?=$all_attend[$key]['UserId']?></td>
<td ><?=$all_attend[$key]['ename']?></td>
<td ><?=$all_attend[$key]['month_days']?></td><!--Total Month Days-->
<td ><?=$all_attend[$key]['working_days']?></td><!--Working days of Month excluding Sundays and Holidays-->
<td ><?=($all_attend[$key]['total_present']);?></td><!--Total Present Day without OD-->
<td ><?=isset($all_attend[$key]['sunday'])?$all_attend[$key]['sunday']:0;?></td><!--Sundays Count-->
<td ><?=isset($all_attend[$key]['holiday'])?$all_attend[$key]['holiday']:0?></td><!--Holidays-->
<td ><?=isset($all_attend[$key]['total_outduty'])?$all_attend[$key]['total_outduty']:0?></td><!--OD-->
<td ><?=isset($all_attend[$key]['CL'])?$all_attend[$key]['CL']:0?></td><!--CL-->
<td ><?=isset($all_attend[$key]['ML'])?$all_attend[$key]['ML']:0?></td><!--ML-->
<td ><?=isset($all_attend[$key]['EL'])?$all_attend[$key]['EL']:0?></td><!--EL-->
<td ><?=isset($all_attend[$key]['C-Off'])?$all_attend[$key]['C-Off']:0?></td><!--C-off-->
<td ><?=isset($all_attend[$key]['SL'])?$all_attend[$key]['SL']:0?></td><!--SL-->
<td ><?=isset($all_attend[$key]['VL'])?$all_attend[$key]['VL']:0?></td><!--VL-->
<td ><?=isset($all_attend[$key]['Leave'])?$all_attend[$key]['Leave']:0?></td><!--Leave-->

<td ><?=isset($all_attend[$key]['LWP'])?$all_attend[$key]['LWP']:0?></td><!--LWP-->


<td ><?=($all_attend[$key]['Total'])?></td>
</tr> 
  <?php 
 }
 }else{
 foreach($all_attend as $key=>$val){
/* $present= $all_attend[$key]['total_present']; //($all_attend[$key]['total_present']- $all_attend[$key]['total_outduty']);
$total_final_workday=($present+$all_attend[$key]['total_outduty']+
                      $all_attend[$key]['total_CL']+$all_attend[$key]['total_ML']+$all_attend[$key]['total_EL']
            +$all_attend[$key]['total_Coff']+$all_attend[$key]['total_SL']+$all_attend[$key]['total_VL']
            +$all_attend[$key]['total_leave']+$all_attend[$key]['total_STL']+$all_attend[$key]['total_LWP']); */
//if($all_attend[$key]['working_days']!=$all_attend[$key]['Total']){?> 

<!--<tr bgcolor="#edc2b8" style="border:1px solid black;">--><!--Heighlight the employee who are full present-->
<?php // }else{?>
<tr  >
<?php //} ?>

<td ><?=$i++;?></td>
<td ><?=$all_attend[$key]['UserId']?></td>
<td ><?=$all_attend[$key]['ename']?></td>
<td ><?=$all_attend[$key]['month_days']?></td><!--Total Month Days-->
<td ><?=$all_attend[$key]['working_days']?></td><!--Working days of Month excluding Sundays and Holidays-->
<td ><?=($all_attend[$key]['total_present_half']+$all_attend[$key]['total_present']);?></td><!--Total Present Day without OD-->
<td ><?=isset($all_attend[$key]['sunday'])?$all_attend[$key]['sunday']:0;?></td><!--Sundays Count-->
<td ><?=isset($all_attend[$key]['holiday'])?$all_attend[$key]['holiday']:0?></td><!--Holidays-->
<td ><?=isset($all_attend[$key]['total_outduty'])?$all_attend[$key]['total_outduty']:0?></td><!--OD-->
<td ><?=isset($all_attend[$key]['total_CL'])?$all_attend[$key]['total_CL']:0?></td><!--CL-->
<td ><?=isset($all_attend[$key]['total_ML'])?$all_attend[$key]['total_ML']:0?></td><!--ML-->
<td ><?=isset($all_attend[$key]['total_EL'])?$all_attend[$key]['total_EL']:0?></td><!--EL-->
<td ><?=isset($all_attend[$key]['total_Coff'])?$all_attend[$key]['total_Coff']:0?></td><!--C-off-->
<td ><?=isset($all_attend[$key]['total_SL'])?$all_attend[$key]['total_SL']:0?></td><!--SL-->
<td ><?=isset($all_attend[$key]['total_VL'])?$all_attend[$key]['total_VL']:0?></td><!--VL-->
<td ><?=isset($all_attend[$key]['total_leave'])?$all_attend[$key]['total_leave']:0?></td><!--Leave-->

<td ><?=isset($all_attend[$key]['total_LWP'])?$all_attend[$key]['total_LWP']:0?></td><!--LWP-->


<td ><?=($all_attend[$key]['total_present_half']+$all_attend[$key]['total_present']+$all_attend[$key]['sunday']+$all_attend[$key]['holiday']+$all_attend[$key]['total_outduty']+$all_attend[$key]['total_CL']+$all_attend[$key]['total_ML']+$all_attend[$key]['total_EL']+$all_attend[$key]['total_Coff']+$all_attend[$key]['total_SL']+$all_attend[$key]['total_VL']+$all_attend[$key]['total_leave'])?></td>

</tr> 
 <?php } } ?>
  
</tbody>  
</table>
</div>
<?php } else{?>
<div><label style="color:red"><b>No Attendance available.....</b></label></div>
<?php } ?>
<br/><br/><br/>

<?php
if(!empty($all_attend)){?>

    <input type="hidden" id="datatodisplay" name="datatodisplay"/>
    <div class="text-center">
     <input type="submit" class="btn btn-primary" value="Download To PDF"/>
    </div>
 
<?php } ?>
</form>
<div class="text-center">
<?php
if(!empty($all_attend)){
 if($sbtn =='0'){ ?>
<form onsubmit="return confirm('Are you sure you want to save this month salary?');" action="<?=base_url($currentModule.'/add_update_monthly_attendance')?>" method="post" >

     <input type="hidden" id="dept" name="empschool" value="<?php echo $emp_school ;?>" />
   <input type="hidden" id="rdate" name="rdate" value="<?php echo $attend_date;?>" />
   <input type="hidden" id="dept" name="dept" value="<?php echo $department ;?>" />
   <input type="submit" name="stable" class="btn btn-primary" id="tsave1" value="Save"/>
   </form>
   <?php } }?>
</div>
    
                 </div>
                                </div>
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
$(document).ready(function(){
  $('#dob-datepicker').datepicker( {format: "yyyy-m",startView: "months",minViewMode: "months",autoclose:true});
  var content = '<tr>'+$('#eduDetTable tbody tr').html()+'</tr>';
  $("#eduDetTable").on("click","input[name='addMore']", function(e){  
  //$("input[name='addMore']").on('click',function(){   
    //var content = $(this).parent().parent('tr').clone('true');
    $(this).parent().parent('tr').after(content);   
  });
  $("#eduDetTable").on("click","input[name='remove']", function(e){ 
  //$("input[name='remove']").on('click',function(){
    var rowCount = $('#eduDetTable tbody tr').length;
    if(rowCount>1){
      $(this).parent().parent('tr').remove();
    }
  }); 
  
   $("#btnExport").click(function(e) {
        window.open('data:application/vnd.ms-excel,' + $('#dvData').html());
    e.preventDefault();
});   
});
</script>


