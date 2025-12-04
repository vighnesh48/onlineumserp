<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> ">
</script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript">
</script>
<script src="<?=site_url()?>assets/javascripts/jspdf/jspdf.js" type="text/javascript">
</script>
<style>
  .attexl table {
    border: 1px solid black;
  }
  .attexl table th {
    border: 1px solid black;
    padding: 5px;
    background-color: grey;
    color: white;
  }
  .attexl table td {
    border: 1px solid black;
    padding: 5px;
  text-align:center;
  }
  .dropdown {
    xtop:50%;
    transform: translateY(0%);
  }
  a {
    color: #fff;
  }
  .dropdown dd,
  .dropdown dt {
    margin: 0px;
    padding: 0px;
    z-index:99999!important;
  }
  .dropdown{
    z-index:99999!important}
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
    width: 288px;
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
    left: 0px;
    padding: 2px 15px 2px 5px;
    position: absolute;
    top: 2px;
    width:100%;
    list-style: none;
    height: 100px;
    overflow-y:scroll;
    border: 1px solid #aaa;
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
  .datepicker-dropdown{
    z-index: 999999;
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
    }
    else {
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
    }
               );
  }
  $(document).ready(function()
                    {
    $(".dropdown dt a").on('click', function() {
      $(".dropdown dd ul").slideToggle('fast');
    }
                          );
    $(".dropdown dd ul li a").on('click', function() {
      $(".dropdown dd ul").hide();
    }
                                );
    function getSelectedValue(id) {
      return $("#" + id).find("dt a span.value").html();
    }
    $(document).bind('click', function(e) {
      var $clicked = $(e.target);
      if (!$clicked.parents().hasClass("dropdown")) $(".dropdown dd ul").hide();
    }
                    );
    /*
        $('#form').bootstrapValidator
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
                attend_date:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Select month'
                      }
                    }
                }
            }       
        })*/
  }
                   );
</script>
<?php
$astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
  <ul class="breadcrumb breadcrumb-page">
    <div class="breadcrumb-label text-light-gray">You are here: 
    </div>
    <li>
      <a href="#">Attendance
      </a>
    </li>
    <li class="active">
      <a href="#">Monthly in-out time report 
      </a>
    </li>
  </ul>
  <div class="page-header">
    <div class="row">
      <h1 class="col-xs-12 col-sm-4 text-center text-left-sm">
        <i class="fa fa-dashboard page-header-icon">
        </i>&nbsp;&nbsp;Monthly in-out time report 
      </h1>
      <div class="col-xs-12 col-sm-8">
        <div class="row">
          <hr class="visible-xs no-grid-gutter-h">
        </div>
      </div>
    </div>
    
    <div class="row ">
      <div class="col-sm-12">
        
            <div class="table-info">
              <div id="dashboard-recent" class="panel-warning">
                <div class="panel">
                  <div class="panel-heading">
                    <strong>Attendance 
                    </strong>
                  </div>
                  <div class="panel-body"> 
                    <span id="flash-messages" style="color:red;padding-left:110px;">
                      <?php echo $this->session->flashdata('message1'); ?>
                    </span>
                    <div class="panel-padding no-padding-vr">
                      <div class="form-group">
                        
                        <div class="portlet-body form">
                          <form id="form" name="form" action="<?=base_url($currentModule.'/view_attendance')?>" method="POST" enctype="multipart/form-data">
                            <div class="form-body">
                              <div class="row"> 
                                <div class="form-group">
                                  <label class="col-md-3">Select School
                                  </label>
                                  <div class="col-md-4" >
                                    <select class="select2me form-control" name="emp_school" onchange="getstaffdept_using_school(this.value)" id="emp_school" >
                                      <option value="">Select School
                                      </option>
                                      <?php foreach($school_list as $sc) { echo "<option  value=".$sc['college_id'].">".$sc['college_name']."</option>"; } ?>
                                    </select>
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="form-group">
                                  <label class="col-md-3 control-label">Select Department  
                                  </label>
                                  <div class="col-md-4">
                                    <select class="form-control select2me" id="department"  onchange="getEmp_using_sch_dep(this.value)" name="department" >
                                      <option value="">Select Department
                                      </option>
                                    </select>
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="form-group">
                                  <label class="col-md-3">Select Month
                                    <?=$astrik?>
                                  </label>
                                  <div class="col-md-4" >
                                    <input id="dob-datepicker" required class="form-control form-control-inline  date-picker" name="attend_date" value="" placeholder="Enter Month" type="text">
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="form-group">
                                  <label class="col-md-3">Select Employees
                                  </label>
                                  <div class="col-md-4">                
                                    <dl class="dropdown">   
                                      <dt>
                                        <a href="#">
                                          <span class="hida">Select Employee
                                          </span>    
                                          <div class="multiSel">
                                          </div>  
                                        </a>
                                      </dt>
                                      <dd>
                                        <div class="mutliSelect" id="mutliSelect">
                                          <ul id="empid">
                                           <li><input type='checkbox'  name="emp_chk_all" onclick='check_all()'> Select All </li>
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
                              </div>
                              <br>
                              <div class="row">
                                <div class="form-group">
                                  <div class="col-md-3" >
                                  </div>
                                  <div class=" col-md-2">
                                    <button type="submit" class="btn btn-primary form-control" >Submit
                                    </button>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </form>
                        </div>
                        <div class="pagination" style="float:right;">
                          <?php  echo $paginglinks['navigation']; ?>
                        </div>
                        <div class="pagination" style="float:left;"> 
                          <?php echo (!empty($pagermessage) ? $pagermessage : ''); ?>
                        </div>
                        <form action="<?=base_url($currentModule.'/view_attendance')?>" method="post">
                          <input type="hidden" name="attend_date_pdf" value="<?php echo $attend_date; ?>" />
                           <input type="hidden" name="emp_school_pdf" value="<?php echo $this->session->userdata("emp_school"); ?>" />
                          <input type="hidden" name="department_pdf" value="<?php echo $this->session->userdata("department"); ?>" />
                         <input type="hidden" name="empsid_pdf" value="<?php echo $this->session->userdata("empsid"); ?>" />
                        
                          <div class="attexl" id="ReportTable1" style="">
                            <?php
//print_r($attendance);
if(!empty($attendance)){
//echo $attend_date;
$date =  $attend_date."-01";
$lt=date('t', strtotime($attend_date)); //get end date of month
$end = $attend_date."-".$lt;
$time=strtotime($attend_date);
$d = date_parse_from_format("Y-m-d",$attend_date);
$msearch=$d["month"];//month number
$ysearch=date("Y",strtotime($attend_date));
$monthName = date('F', mktime(0, 0, 0, $msearch, 10));// month name
?>
                            <div >
                              <?php if(!empty($this->session->userdata("emp_school"))){?>
                              <div class="col-lg-12">
                                <label>
                                  <b>Sandip University</b>
                                </label>
                              </div>
                              <br>
                              <div class="col-lg-12">
                                <label>
                                  <b>School: 
                                  </b>
                                  <?php $sc=$this->Admin_model->getSchoolById($this->session->userdata("emp_school"));echo $sc[0]['college_name'];?>
                                </label>
                              </div>
                              <div class="col-lg-12">
                                <label>
                                  <b>Department: 
                                  </b>
                                  <?php $de=$this->Admin_model->getDepartmentById($this->session->userdata("department"));echo $de[0]['department_name'];?>
                                </label>
                              </div>
                              <?php } else{?>
                              <div class="col-lg-12">
                                <label>
                                  <b>Sandip University
                                  </b>
                                </label>
                              </div>
                              <br>
                              <div class="col-lg-12">
                                <label>
                                  <b>All Employee Attendance
                                  </b>
                                </label>
                              </div>
                              <br>
                              <?php }?>
                              <br>
                            </div>
                            <br>
                            <br>
                            <div class="table-scrollable" id="reporttab">
                              <table cellpadding="0"  cellspacing="0" border="0"  width="100%">
                                <tr>
                                  <td align="center" style="padding-bottom:15px">
                                    <b>Monthly Attendance Report Of 
                                      <?=$monthName?>
                                      <?=$ysearch?>
                                    </b>
                                  </td>
                                </tr>
                              </table>
                              <!--<div class="col-lg-12"><label ><b><u>Monthly Attendance Report Of <?=$monthName?> <?=$ysearch?>  </u></b></label></div>-->
                              <table cellpadding="0" cellspacing="0"   style="font-size:11px;border:1px solid;" >
                                <thead>
                                  <tr style="border: 1px solid black;">
                                    <td style="border: 1px solid black;">Sr No.
                                    </td>
                                    <td style="border: 1px solid black;">Date 
                                      <br/>
                                      Day
                                    </td>
                                    <?php while(strtotime($date) <= strtotime($end)) {
$day_num = date('d', strtotime($date));
$day_name = date('D', strtotime($date));
$totaldays['total'][]=$day_num;
$totaldays['weekd'][]=$day_name ;
$date = date("Y-m-d", strtotime("+1 day", strtotime($date)));?>
                                    <td style="border: 1px solid black;">
                                      <?=$day_num?>
                                      <br/>
                                      <?=$day_name?>
                                    </td>
                                    <?php }
?>
                                    <td  colspan="5" style="border: 1px solid black;">Total
                                    </td>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php
/*  echo "total days=". count($totaldays['total'])  ;
print_r($totaldays['total']);
print_r($totaldays['weekd']); 
*/
?>
                                  <?php 
//print_r($all_emp);
$sr=0;
$total_count = array();
$grand_total=array();
foreach($all_emp as $e ){
// echo 
$det = $this->Admin_model->getEmployeeById1($e['emp_id']);
//  echo $e['emp_id'];
$name = $det[0]['fname']." ".$det[0]['mname']." ".$det[0]['lname'];
/*   echo"<pre>";
print_r($attendance[$e['emp_id']]);
echo"</pre>"; */
$sr++;   
?>
                                  <tr style="border: 1px solid black;">
                                    <td rowspan="5" style="border: 1px solid black;">
                                      <?=$sr;?>
                                    </td>
                                    <td colspan="<?=$lt+1?>" style="border: 1px solid black;">
                                      <?php echo"<b>Staff ID:</b> ".$e['emp_id']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp"."<b>Staff Name:</b> ".$name."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp"."<b>Designation:</b> ".$det[0]['designation_name']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp"."<b>Department:</b> ".$det[0]['department_name']?>
                                    </td>
                                    <td style="border:1px solid black;">P
                                    </td>
                                    <td style="border:1px solid black;">S
                                    </td>
                                    <td style="border:1px solid black;">H
                                    </td>
                                    <td style="border:1px solid black;">LWP
                                    </td>
                                    <td style="border:1px solid black;">OD
                                    </td>
                                  </tr>
                                  <tr style="border: 1px solid black;">
                                    <td style="border: 1px solid black;">
                                      <strong>In:
                                      </strong>
                                    </td>
                                    <?php 
//echo "<pre>";
//print_r($attendance[$e['emp_id']]);
//echo $attendance[$e['emp_id']][0]['status'];
foreach($attendance[$e['emp_id']] as $att){ 
$d=date('d',strtotime($att['Intime']));
$d = intval($d);
$dayIn[$e['emp_id']][$d]=$d; //array for only punched In day 
$tempdayin[$e['emp_id']][$d]=$dayIn[$e['emp_id']][$d];
$timedayin[$e['emp_id']][$d]=$att['Intime'];
$status[$e['emp_id']][$d]=$att['status'];
$leave[$e['emp_id']][$d]=$att['leave_type'];
$durl[$e['emp_id']][$d]=$att['leave_duration'];
$reml[$e['emp_id']][$d]=$att['remark'];
if($att['Outtime'] != '0000-00-00 00:00:00'){
$d=date('d',strtotime($att['Outtime']));
$d = intval( $d);
//echo "<br/>";
$dayOut[$e['emp_id']][$d]=$d; //array for only punched In day 
$tempdayout[$e['emp_id']][$d]=$dayOut[$e['emp_id']][$d];
//echo "<br/>";
$timedayout[$e['emp_id']][$d]=$att['Outtime'];
} 

if(date('H:i:s',strtotime($att['Outtime'])) != '00:00:00' || date('H:i:s',strtotime($att['Intime'])) != '00:00:00'){
$d=date('d',strtotime($att['Outtime']));
$d = intval($d);
//  echo $att['Intime'];
if(date('h:i:s',strtotime($att['Intime']))!='00:00:00')$time1=date('h:i:s',strtotime($att['Intime']));else $time1='00:00';
if(date('h:i:s',strtotime($att['Outtime']))!='00:00:00')$time2=date('h:i:s',strtotime($att['Outtime'])); else $time2='00:00';
$diff=$this->Admin_model->get_time_difference($time1,$time2);
$dur[$d]= $diff;   
$timedayout[$e['emp_id']][$d]=$att['Outtime']; 
$timedayin[$e['emp_id']][$d]=$att['Intime']; 
}


 } 
$CI =& get_instance();
$CI->load->model('Leave_model');
?>
                                    <?php for($i=1;$i<=count($totaldays['total']);$i++){
//first check holiday and sunday ***********************
$dname=$attend_date."-".$totaldays['total'][$i-1];
$check_holiday=$this->Admin_model->checkHoliday($dname);//check for holiday
//echo $check_holiday;die();
if($check_holiday=='true'){
$day_name="Holiday";
}else{
$day_name = date('D', strtotime($dname));
}
// echo $day_name;
//echo $timedayin[$e['emp_id']][$temp];
if($status[$e['emp_id']][$i] =='present' && ($day_name!="Holiday" && $day_name!="Sun") ){
if(date('H:i',strtotime($timedayin[$e['emp_id']][$i])) !='00:00'){
//  if($durl[$e['emp_id']][$i] != '1' ){
//  echo date('H:i',strtotime($timedayin[$e['emp_id']][$temp]));
$total_count[$e['emp_id']]['present'][]='1';
// }
}
}elseif($status[$e['emp_id']][$i]=='leave' || $status[$e['emp_id']][$i]=='outduty'){
$ltypes=$leave[$e['emp_id']][$i];
echo $ltypes = strtoupper($ltypes);
$dur1 = $durl[$e['emp_id']][$i]; 
$rem = $reml[$e['emp_id']][$i];
if($dur1 == '0.5' && $rem != 'hrs' ){
  if(substr($ltypes, -1) === '*'){
$total_count[$e['emp_id']]['LWP'][]='0.5';
$total_count[$e['emp_id']][substr($ltypes,0,-1)][]=$dur1;
  }else{
$total_count[$e['emp_id']]['present'][]='0.5';
$total_count[$e['emp_id']][$ltypes][]=$dur1;
}
}else{  
if($rem == 'hrs'){
$total_count[$e['emp_id']][$ltypes][]=1;
}else{
$total_count[$e['emp_id']][$ltypes][]=$dur1;
}
}
}  
$temp1=array_search($i,$tempdayin[$e['emp_id']]);
//echo $status[$e['emp_id']][$i];
if($status[$e['emp_id']][$i]=='holiday' || $status[$e['emp_id']][$i]=='sunday'){
  $col = 'color:red;';
  
}else{
  $col ='';
}
$cd = date('d');
$cm = date('m');
$ad = date_parse_from_format("m",$attend_date);
//echo $i;
if($cm==$ad){
if($i<=$cd){
  if($status[$e['emp_id']][$i]=='sunday'){
$total_count[$e['emp_id']]['sun'][] = '1';
  }
  if($status[$e['emp_id']][$i]=='holiday'){
  $total_count[$e['emp_id']]['holiday'][]='1';
  }
}
}else{
  if($status[$e['emp_id']][$i]=='sunday'){
$total_count[$e['emp_id']]['sun'][] = '1';
  }
  if($status[$e['emp_id']][$i]=='holiday'){
  $total_count[$e['emp_id']]['holiday'][]='1';
  }
}
?>
                                 
                                    <td style="border: 1px solid black;<?php echo $col;?>">
                                      <?php  if($timedayin[$e['emp_id']][$i]!=''){ if(date('H:i',strtotime($timedayin[$e['emp_id']][$i]))=='00:00'){ echo "00:00"; }else{ echo  date('H:i',strtotime($timedayin[$e['emp_id']][$i]));} }else{ echo '00:00'; } ?>
                                    </td>
                                   
                                    <?php   } ?>
                                    <td style="border:1px solid black;">
                                      <?php echo $p = array_sum($total_count[$e['emp_id']]['present']); ?>
                                    </td>
                                    <td style="border:1px solid black;">
                                      <?php echo $s = array_sum($total_count[$e['emp_id']]['sun']); ?>
                                    </td>
                                    <td style="border:1px solid black;">
                                      <?php echo $h = array_sum($total_count[$e['emp_id']]['holiday']); ?>
                                    </td>
                                    <td style="border:1px solid black;">
                                      <?php echo $lwp = array_sum($total_count[$e['emp_id']]['LWP']); ?>
                                    </td>
                                    <td style="border:1px solid black;">
                                      <?php 
                                    //var_dump($total_count[$e['emp_id']]['OD']);
                                      echo $od = array_sum($total_count[$e['emp_id']]['OD']); ?>
                                    </td>
                                  </tr>
                                  <tr style="border: 1px solid black;">
                                    <td style="border: 1px solid black;">
                                      <strong>Out:
                                      </strong>
                                    </td>
                                    <?php
//print_r($attendance[$e['emp_id']]);

for($i=1;$i<=count($totaldays['total']);$i++){
  if($status[$e['emp_id']][$i]=='holiday' || $status[$e['emp_id']][$i]=='sunday'){
  $col = 'color:red;';
}else{
  $col ='';
}
?>
                                    
                                    
                                    
                                    <td style="border: 1px solid black;<?php echo $col;?>">
                                      <?php  if($timedayout[$e['emp_id']][$i]!=''){ if(date('H:i',strtotime($timedayout[$e['emp_id']][$i])) =='00:00') echo "00:00"; else{ echo  date('H:i',strtotime($timedayout[$e['emp_id']][$i]));}}else{echo '00:00';}?>
                                    </td>
                                   
                                    <?php  } ?>
                                    <td style="border:1px solid black;">CO
                                    </td>
                                    <td style="border:1px solid black;">CL
                                    </td>          
                                    <td style="border:1px solid black;">SL
                                    </td>
                                    <td style="border:1px solid black;">EL
                                    </td>
                                    <td style="border:1px solid black;">ML
                                    </td>
                                  </tr>
                                  <tr style="border: 1px solid black;">
                                    <td style="border: 1px solid black;">
                                      <strong>Dur: </strong>
                                    </td>
                                    
                                    <?php for($i=1;$i<=count($totaldays['total']);$i++){ 
                  if($status[$e['emp_id']][$i]=='holiday' || $status[$e['emp_id']][$i]=='sunday'){
  $col = 'color:red;';
}else{
  $col ='';
}?>
                                  
                                    
                                    <td style="border: 1px solid black;<?php echo $col;?>">
                                      <?php 
if(date('H:i',strtotime($timedayin[$e['emp_id']][$i]))!='00:00' && date('H:i',strtotime($timedayout[$e['emp_id']][$i]))!='00:00'){
if($dur[$i]!=''){
echo $dur[$i] ; }else{echo "00:00";} }else{echo "00:00";}?>
                                    </td>
                  <?php } ?>         
                                    <td style="border:1px solid black;">
                                      <?php echo $co = array_sum($total_count[$e['emp_id']]['C-OFF']); ?>
                                    </td>
                                    <td style="border:1px solid black;">
                                      <?php echo $cl = array_sum($total_count[$e['emp_id']]['CL']); ?>
                                    </td>          
                                    <td style="border:1px solid black;">
                                      <?php echo $sl = array_sum($total_count[$e['emp_id']]['SL']); ?>
                                    </td>
                                    <td style="border:1px solid black;">
                                      <?php echo $el = array_sum($total_count[$e['emp_id']]['EL']); ?>
                                    </td>
                                    <td style="border:1px solid black;">
                                      <?php echo $ml = array_sum($total_count[$e['emp_id']]['ML']); ?>
                                    </td>
                                    <?php                
$grand_total[$e['emp_id']]= $p+$s+$h+$od+$co+$cl+$sl+$el+$ml; ?>               
                                  </tr>
                                  <tr style="border: 1px solid black;">
                                    <td style="border: 1px solid black;">
                                      <strong>sta.:
                                      </strong>
                                    </td>
                                    
                                    <?php for($i=1;$i<=count($totaldays['total']);$i++){
if($status[$e['emp_id']][$i]=='holiday' || $status[$e['emp_id']][$i]=='sunday'){
  $col = 'color:red;';
}else{
  $col ='';
}
?>
                                    <td style="border: 1px solid black;<?php echo $col;?>">
                                      <?php 
if($status[$e['emp_id']][$i]=='present'){
//echo $timedayin[$e['emp_id']][$temp1];
if(date('H:i:s',strtotime($timedayout[$e['emp_id']][$i]))=='00:00:00' || date('H:i:s',strtotime($timedayin[$e['emp_id']][$i]))=='00:00:00')
{
echo "";
}else{
echo 'P';
}
$total_count[$e['emp_id']]['present'][]='1';
}elseif($status[$e['emp_id']][$i]=='leave' || $status[$e['emp_id']][$i]=='outduty'){
$ltypes=$leave[$e['emp_id']][$i];
$dur1 = $durl[$e['emp_id']][$i];
 
if($ltypes=='LWP'){
 
if($durl[$e['emp_id']][$i]==0.5 && $reml[$e['emp_id']][$i]=='half-day'){
echo '<span style="color:red;">'.$ltypes.'(H)</span>'; 
}else{
echo '<span style="color:red;">'.$ltypes.'</span>'; 
}
}else{
  if($durl[$e['emp_id']][$i]==0.5 && $reml[$e['emp_id']][$i]=='half-day'){
    $ds = '(H)';
  }else{
    $ds ='';
  }
echo '<span style="color:green;">'.$ltypes.''.$ds.'</span>'; 
}

$total_count[$e['emp_id']][$ltypes][]=$dur1;
}elseif($status[$e['emp_id']][$i]=='sunday'){
  echo '<span style="color:red;">Sun</span>'; 
}elseif($status[$e['emp_id']][$i]=='holiday'){
  echo '<span style="color:red;">Hol</span>'; 
}
// echo $status[$e['emp_id']][$i] ; ?>
                                    </td>
                                    <?php //}else{?>
                                    <?php }?>
                                    <td colspan='5'>Total:  
                                      <?php echo $grand_total[$e['emp_id']]; ?>
                                    </td>
                                  </tr>
                                  <?php }//echo"<pre>";print_r($timedayin);echo"</pre>";echo"<pre>";print_r($timedayout);echo"</pre>";  ?>
                                </tbody>
                              </table>
                            </div>
                            <?php } else{?>
                            <div>
                              <label style="color:red">
                                
                              </label>
                            </div>
                            <?php } ?>
                          </div>
                          <?php
if(!empty($attendance)){?>
                          <table width="600px" cellpadding="2" cellspacing="2" border="0">
                            <tr>
                              <td>&nbsp;
                              </td>
                            </tr>
                            <tr>
                              <td align="center">
                                <input type="hidden" id="datatodisplay" name="datatodisplay">
                                <input type="submit" name="downpdf" class="btn-primary" value="Download To PDF">
                              </td>
                            </tr>
                          </table>
                          <?php } ?>
                        </form>
                        <div id="dvData" style="display:none">
                          <table>
                            <tr>
                              <th>UserId 
                              </th>
                              <th>In Time
                              </th>
                              <th>Out Time
                              </th>
                              <th>Punch Date
                              </th>
                            </tr>
                            <?php if(empty($attendance)){?>
                            <tr id="row441" class="odd" role="row">
                              <td class=" center">
                                <?php echo "No Attendance  Available for Mentioned Date"; ?>
                              </td>
                            </tr>
                            <?php }else{
$i=0;
foreach($attendance as $key=>$val){
$i++;
?>
                            <tr>
                              <td>
                                <?php echo $attendance[$key]['UserId'];?>
                              </td>
                              <td>
                                <?php echo $attendance[$key]['punch_intime'];?>
                              </td>
                              <td>
                                <?php echo $attendance[$key]['punch_outtime'];?>
                              </td>
                              <td>
                                <?php echo $attendance[$key]['punch_date'];?>
                              </td>
                            </tr>
                            <?php }}?>
                          </table>
                        </div>
                      </div>
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

<script type="text/javascript">
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
    $('#dob-datepicker').datepicker( {
      format: "yyyy-m",startView: "months",minViewMode: "months",autoclose:true}
                                   );
    var content = '<tr>'+$('#eduDetTable tbody tr').html()+'</tr>';
    $("#eduDetTable").on("click","input[name='addMore']", function(e){
      //$("input[name='addMore']").on('click',function(){   
      //var content = $(this).parent().parent('tr').clone('true');
      $(this).parent().parent('tr').after(content);
    }
                        );
    $("#eduDetTable").on("click","input[name='remove']", function(e){
      //$("input[name='remove']").on('click',function(){
      var rowCount = $('#eduDetTable tbody tr').length;
      if(rowCount>1){
        $(this).parent().parent('tr').remove();
      }
    }
                        );
    $("#btnExport").click(function(e) {
      window.open('data:application/vnd.ms-excel,' + $('#dvData').html());
      e.preventDefault();
    }
                         );
  }
                   );
</script> 
