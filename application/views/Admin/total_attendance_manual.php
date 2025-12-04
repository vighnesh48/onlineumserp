<?php /*echo '<pre>'; print_r($all_attend);*/  ini_set('max_input_vars', 3000); ?>
<?php //print_r($all_attend);
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
}
//print_r($all_attend);
?>
<!--<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<script src="<?=site_url()?>assets/javascripts/jspdf/jspdf.js" type="text/javascript"></script>-->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
     	        <script src="http://demos.codexworld.com/includes/js/bootstrap.js"></script>
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
   border: 1px solid #aaa;
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
  
  padding: 2px 15px 2px 5px;
  
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
.inp{width:60px;}
</style>
<script>
getstaffdept_using_school('<?php echo $emp_school ?>','<?php echo $department ?>');
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
  
  
  
  function calculate_days_run(e){
	  
  //var md = '<?php echo cal_days_in_month(CAL_GREGORIAN, $msearch, $ysearch); ?>';
  var md = 7;
 // alert(md);
   var d = new Date();
   var n = d.getDate();
  var wd = $('#wday_'+e).val();
  var sd = $('#sun_'+e).val();
  var hd = $('#holi_'+e).val();
  var td = parseInt(md) - (parseInt(sd)+parseInt(hd));
 
  var od = $('#OD_'+e).text();
  var cl = $('#CL_'+e).text();
  var ml = $('#ML_'+e).text();
  var el = $('#EL_'+e).text();
  var coff = $('#COFF_'+e).text();
  var sl = $('#SL_'+e).text();
  var vl = $('#VL_'+e).text();
  var lev = $('#Lev_'+e).text();
  //var lwp = $('#LWP_'+e).val();
  var pd = $('#pday_'+e).val();
  var wfh = $('#WFH_'+e).text();
 // alert(pd+wfh+sl+ml+cl);
  var checkpoint=pd+wfh+sl+ml+cl+od;
  //alert(checkpoint);
   if(checkpoint==0){
   $('#wday_'+e).val(0);
	}else{
  $('#wday_'+e).val(td);
  }
  
  
  var lwp = $('#LWP_'+e).val();
  var ftot = parseFloat(hd)+parseFloat(sd)+parseFloat(pd)+parseFloat(od)+parseFloat(cl)+parseFloat(ml)+parseFloat(el)+parseFloat(coff)+parseFloat(sl)+parseFloat(vl)+parseFloat(lev)+parseFloat(wfh);
  //alert(ftot);
  //var ftot = parseFloat(ftot1);
  //$('#LWP_'+e).val(lwp);
 // alert(ftot);
   if(parseFloat(ftot) <= parseFloat(md)){
    lwp = parseFloat(md) - parseFloat(ftot);
   if(checkpoint==0){
	//$('#LWP_'+e).val(0);  //p day ==0 then total day should be 0
    $('#tday_'+e).val(0);
	$('#sun_'+e).val(0);
	$('#holi_'+e).val(0);
	}else{
   // $('#LWP_'+e).val(lwp);
    $('#tday_'+e).val(ftot); // Total day
	$('#sun_'+e).val(sd);
	$('#holi_'+e).val(hd);
   }
  }else{
//    alert('Total days is greater then month days.');
    if(checkpoint==0){
	//$('#LWP_'+e).val(0);
	}else{  //p day ==0 then total day should be 0
    //$('#tday_'+e).val('');
	}
   // $('#LWP_'+e).val()
  }
}
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
                        <div class="table-info">               
                                                               
                             <div id="dashboard-recent" class="panel-warning">   
                               <div class="panel">
                              <div class="panel-heading"><strong>Monthly Total Attendance </strong></div>
                                <div class="panel-body">
                 <span id="flash-messages" style="color:red;padding-left:110px;"><?php echo $this->session->flashdata('message1'); ?></span>
                                <div class="panel-padding no-padding-vr">
                            <div class="form-group">
                              
                <div class="portlet-body form">
                <form id="form" name="form" action="<?=base_url($currentModule.'/total_monthly_attendance_manual')?>" method="POST" enctype="multipart/form-data">
                <div class="form-body">
                <div class="col-md-6">
                <div class="form-group">
                <label class="col-md-4">Select School:</label>
                                             <div class="col-md-8" >
                       <select class="select2me form-control" name="emp_school" onchange="getstaffdept_using_school(this.value)" id="emp_school" >
                       <option value="" >Select School</option>
                       <?php 
					   
					   foreach($school_list as $sc) {
						   if($emp_school==$sc['college_id']){
							   $sel='selected="selected"';
						   }else{$sel='';
						   }
						   
                         echo "<option  value=".$sc['college_id']." $sel>".$sc['college_name']."</option>";
                       } ?>
                      
                         </select>
                                       </div>
                                  </div>
 <div class="form-group">
                <label class="col-md-4">Select Month:<?=$astrik?></label>
                                             <div class="col-md-8" >
                       <input id="dob-datepicker" required class="form-control form-control-inline date-picker" name="attend_date" value="<?php echo $attend_date; ?>" placeholder="Enter Month" type="text">

                                             </div>
                                  </div>
                                  </div>
                                  <div class="col-md-6">
                   <div class="form-group">
                <label class="col-md-4 ">Department:</label>
                            <div class="col-md-8">
                          <select class="form-control select2me" id="department"  onchange="getEmp_using_sch_dep(this.value)" name="department" >
                      <option value="">Select</option>
                      </select>
                                       </div>
                                  </div>
<div class="form-group">
                                <label class="col-md-4"> Employee:</label>
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
             <li><input type='checkbox'   name="emp_chk_all" onclick='check_all()'>Select All </li>
      <?php 
     // print_r($all_attend);
	  foreach($all_attend as $empl){ 
	  $emph[]=$empl['UserId'];
	  }
	 // print_r($emph);
	  $kk=0;
      foreach($emp_list as $key=>$val){ 
	  if (in_array($emp_list[$key]['emp_id'], $emph))
  {
 $sel='checked="checked"';
 //echo '1';
  }
else
  {
	 // echo '1';
 $sel='';
  }
	/* if($all_attend[$kk]['UserId']==$emp_list[$key]['emp_id']){
		 $sel='checked="checked"';
	  }else{$sel='';}*/
               echo '<li>
          <input type="checkbox"  name="empsid[]" id="'.$emp_list[$key]['emp_id'].'" onclick="onclick_checkbox_emp('.$emp_list[$key]['emp_id'].');" value="'.$emp_list[$key]['emp_id'].'" '.$sel.' /> '.$emp_list[$key]['emp_id'].' - '.$emp_list[$key]['fname'].' '.$emp_list[$key]['lname'].' </li>';
              $$kk++;        
       } ?> 
            </ul>
        </div>
    </dd>  
</dl>                         
                </div>
                              </div>    
                                  </div>                      
                               
                                   <div class="form-group">
                   <div class="col-md-5" ></div>
                                      <div class=" col-md-2">  
                                            <button type="submit" name="submit" class="btn btn-primary form-control" >Submit</button>
                                        </div>                                       
                                    </div>
                            </div>
                                    </form>
                  </div>
                 
                <div class="pagination" style="float:right;"> <?php  echo $paginglinks['navigation']; ?></div>
<div class="pagination" style="float:left;"> <?php echo (!empty($pagermessage) ? $pagermessage : ''); ?></div>
<form onsubmit="return confirm('Are you sure to submit this month salary?');" action="<?=base_url($currentModule.'/add_update_monthly_attendance_manual')?>" method="post" >

     <input type="hidden" id="dept" name="empschool" value="<?php echo $emp_school ;?>" />
   <input type="hidden" id="rdate" name="rdate" value="<?php echo $attend_date;?>" />
   <input type="hidden" id="dept" name="dept" value="<?php echo $department ;?>" />
   
<div class="attexl" id="ReportTable" >
<?php //print_r($all_attend);
if(!empty($all_attend)){
//echo $attend_date;
/*$date =  $attend_date."-01";
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
$working_days=$totaldays-($total_sun+$total_holiday);*/

//print_r($all_attend);
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0"  class="add-table">
  <tr>
    <td align="center"><b>Monthly Employee Present Days Report Of <?=$attend_date?> <input type='hidden' name='monthdate' value='<?=$attend_date?>' /></b></td>
  </tr>
</table>
<br/>
<table  cellpadding="0" cellspacing="0" style="font-size:11px" width="100%" align="center" class="attexl" id="tblData">
<thead>

 <tr bgcolor="#9ed9ed" >
 <td><strong>SRNo.</strong></td>
 <td ><strong>Staff ID</strong></td>
 <td width="18%"><strong>Name Of Employee</strong></td>
 <td ><strong>Month Days</strong></td>
 <td ><strong>Present Days</strong></td> 
 <!--<td style="border: 1px solid black;">Lcome/EG o</td>-->
 
  </tr></thead><tbody>
 <?php 
 echo $sbtn;
 if($sbtn=='1'){ 
 echo 'in';
 foreach($all_attend as $key=>$val){ ?>
 <tr> 
   <td ><?=$i++;?></td>
<td ><?=$all_attend[$key]['UserId']?></td>
<td ><?=$all_attend[$key]['empname']?></td>
<td ><?=$all_attend[$key]['month_days']?></td>
<td ><?=($all_attend[$key]['total_present']);?></td><!--Total Present Day without OD-->

</tr> 
  <?php 
 }
 
   
  
 }else{
  if($sbtn=='2'){
   echo "<input type='hidden' name='sbtnv' value='2' />";
 }
 $s=1;
 foreach($all_attend as $key=>$val){
	
?> 
<tr  >
<td ><?=$i++;?></td>
<td ><?=$all_attend[$key]['UserId']?><input type='hidden' name='UserId[]' value='<?=$all_attend[$key]['UserId']?>' /></td>
<td ><?=$all_attend[$key]['empname']?></td>
<td ><?=$all_attend[$key]['month_days']?></td>
<td>
<input type="text"  name="pday[]" id="pday_<?=$all_attend[$key]['total_present']?>" class="inp" 
value="<?=$all_attend[$key]['total_present'];?>" /></td>
</tr> 
<script type="text/javascript">
//calculate_days_run('<?=$all_attend[$key]['UserId']?>');
</script>
	 <?php  $s++; } } ?>  
</tbody>  
</table>
</div>
<?php } else{?>
<div><label style="color:red"><b>No Attendance available.....</b></label></div>
<?php } ?>
<br/><br/>
<div class="form-group"><div class="col-md-4"></div>
<?php
if($sbtn=='0'){?> 
    <input type="hidden" id="datatodisplay" name="datatodisplay"/>
	
                                      <div class="col-md-1" style="margin-right:15px;">  
     <input type="submit" class="btn btn-primary" name="stable" value="Save"/>
</div> 
<?php }elseif($sbtn=='2'){ ?>
<input type="hidden" id="datatodisplay" name="datatodisplay"/>
<div class="col-md-1" style="margin-right:15px;">  
<input type="submit" class="btn btn-primary" name="stable" value="Update"/>
</div> 
<?php } ?>
</form>

<?php
//if(!empty($all_attend)){
 // if($msearch != date('m')){
 //if($sbtn !='0'){ ?>
 <form action="<?=base_url($currentModule.'/total_monthly_attendance')?>" method="post"  >
   <input type="hidden" id="dept" name="emp_school" value="<?php echo $emp_school ;?>" />
   <input type="hidden" id="rdate" name="attend_date" value="<?php echo $attend_date;?>" />
   <input type="hidden" id="dept" name="department" value="<?php echo $department ;?>" />
    <input type="hidden"  name="exp_t" value="1" />
      <?php 
     /// print_r($empsid_new);
	  foreach($all_attend as $empl){ 
	  $emph[]=$empl['UserId'];
	  }
	 // print_r($emph);
	  $kk=0;
      foreach($emp_list as $key=>$val){ 
	  if (in_array($emp_list[$key]['emp_id'], $empsid_new))
  {
 $sel='checked="checked"';
echo '<input type="hidden"  name="empsid[]" id="'.$emp_list[$key]['emp_id'].'" onclick="onclick_checkbox_emp('.$emp_list[$key]['emp_id'].');" value="'.$emp_list[$key]['emp_id'].'"/>';
  }
else
  {
	 // echo '1';
 $sel='';
  }
	
               
              $$kk++;        
       } ?> 
    <div class="col-md-2">
   <input type="submit" name="submit" class="btn btn-primary" id="tsave1" value="Download To PDF"/>
   
   </div><div class="col-md-1"></div>
   <div class="col-md-2">
   <!--<button  onclick="exportTableToExcel('tblData', 'members-data');">Excel File</button>--><br />
<a id="downloadLink" onclick="exportF(this)" style="color:#000">Export to excel</a>

    </div>
   </form>
   <?php// } }}?>
    <?php
//if(!empty($all_attend)){
//  if($sbtn != '1'){
 // if($msearch != date('m')){
  ?>
 <form onsubmit="return confirm('Are you sure you want to final save this month salary?');" action="<?=base_url($currentModule.'/final_submit_Attendance_manual')?>" method="post"  >

  <input type="hidden" id="rdate" name="attend_date" value="<?php echo $attend_date;?>" />
  <div class=" col-md-2"> 
   <input type="submit" name="submit" class="btn btn-primary" id="tsave1" value="Final Submit"/>
   </div>
   </form>
   <?php // }}}?>
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
function calculate_days_lwp1(e){
  var md = '<?php echo cal_days_in_month(CAL_GREGORIAN, $msearch, $ysearch); ?>';
var olwp = $('#tday_'+e).val();
//alert(olwp);
 var pd = $('#pday_'+e).val();
 var su = $('#sun_'+e).val();
var hd = $('#holi_'+e).val();

var td = parseFloat(pd)+parseFloat(su)+parseFloat(hd);

 var mlwp = $('#LWP_'+e).val();
 //alert(mlwp);
var pd1 = parseFloat(olwp) - parseFloat(mlwp);
//alert(pd1);
if(td >= md){
  $('#LWP_'+e).val('0');

}else{
    $('#tday_'+e).val(pd1);
}
 calculate_days(e);

}
function calculate_days(e){
	
  var md = '<?php echo cal_days_in_month(CAL_GREGORIAN, $msearch, $ysearch); ?>';
 // alert(md);
   var d = new Date();
   var n = d.getDate();
  var wd = $('#wday_'+e).val();
  var sd = $('#sun_'+e).val();
  var hd = $('#holi_'+e).val();
  var td = parseInt(md) - (parseInt(sd)+parseInt(hd));
 
  var od = $('#OD_'+e).text();
  var cl = $('#CL_'+e).text();
  var ml = $('#ML_'+e).text();
  var el = $('#EL_'+e).text();
  var coff = $('#COFF_'+e).text();
  var sl = $('#SL_'+e).text();
  var vl = $('#VL_'+e).text();
  var lev = $('#Lev_'+e).text();
  //var lwp = $('#LWP_'+e).val();
  var pd = $('#pday_'+e).val();
  var wfh = $('#WFH_'+e).text();
  //alert(pd);
  var checkpoint=pd+wfh+sl+ml+cl+od;
   if(checkpoint==0){
   $('#wday_'+e).val(0);
	}else{
  $('#wday_'+e).val(td);
  }
  
  
  var lwp = $('#LWP_'+e).val();
  var ftot = parseFloat(hd)+parseFloat(sd)+parseFloat(pd)+parseFloat(od)+parseFloat(cl)+parseFloat(ml)+parseFloat(el)+parseFloat(coff)+parseFloat(sl)+parseFloat(vl)+parseFloat(lev)+parseFloat(wfh);
  //alert(ftot);
  //var ftot = parseFloat(ftot1);
  //$('#LWP_'+e).val(lwp);
 // alert(ftot);
   if(parseFloat(ftot) <= parseFloat(md)){
    lwp = parseFloat(md) - parseFloat(ftot);
   if(checkpoint==0){
	//$('#LWP_'+e).val(0);  //p day ==0 then total day should be 0
    $('#tday_'+e).val(0);
	$('#sun_'+e).val(0);
	$('#holi_'+e).val(0);
	}else{
   // $('#LWP_'+e).val(lwp);
    $('#tday_'+e).val(ftot); // Total day
	$('#sun_'+e).val(sd);
	$('#holi_'+e).val(hd);
   }
  }else{
  //  alert('Total days is greater then month days.');
    if(checkpoint==0){
	//$('#LWP_'+e).val(0);
	}else{  //p day ==0 then total day should be 0
    //$('#tday_'+e).val('');
	}
   // $('#LWP_'+e).val()
  }
}


function check_all(){
    if($('input:checkbox[name="emp_chk_all"]').prop("checked")) {
  $('input:checkbox[name="empsid[]"]').prop('checked', true);
  
  $('.emp_amty').prop('disabled',false);
   } else {
     $('input:checkbox[name="empsid[]"]').prop('checked', false);
   $('.emp_amty').prop('disabled',true);
            }    
}
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
   /*$("#btnExport").click(function(e) {
        window.open('data:application/vnd.ms-excel,' + $('#dvData').html());
    e.preventDefault();
});  */ 

    
/* $('#example').DataTable( {
        dom: 'Bfrtip',
		 "pageLength": 500,
        buttons: [
            'excel'
        ]
    } );*/


});


function exportTableToExcel(tableID, filename = ''){
    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableID);
    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
    
    // Specify file name
    filename = filename?filename+'.xls':'excel_data.xls';
    
    // Create download link element
    downloadLink = document.createElement("a");
    
    document.body.appendChild(downloadLink);
    
    if(navigator.msSaveOrOpenBlob){
        var blob = new Blob(['\ufeff', tableHTML], {
            type: dataType
        });
        navigator.msSaveOrOpenBlob( blob, filename);
    }else{
        // Create a link to the file
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
    
        // Setting the file name
        downloadLink.download = filename;
        
        //triggering the function
        downloadLink.click();
    }
}
function exportF(elem) {
  var table = document.getElementById("tblData");
  var html = table.outerHTML;
  var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
  elem.setAttribute("href", url);
  elem.setAttribute("download", "export.xls"); // Choose the file name
  return false;
}

</script>