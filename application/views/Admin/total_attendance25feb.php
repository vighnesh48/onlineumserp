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
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
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
        									<select class="form-control select2me" id="department"  name="department" >
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
<form action="exporttoexcel" method="post" onsubmit='$("#datatodisplay").val( $("<div>").append( $("#ReportTable").eq(0).clone() ).html() )' >
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
		function total_sundays($monthName,$ysearch)
{
$sundays=0;
$total_days=cal_days_in_month(CAL_GREGORIAN, $monthName, $ysearch);
for($i=1;$i<=$total_days;$i++)
if(date('N',strtotime($ysearch.'-'.$monthName.'-'.$i))==7)
$sundays++;
return $sundays;
}
$total_sun=total_sundays($msearch,$ysearch);
$total_holiday=$this->Admin_model->getTotalHoliday($msearch,$ysearch);
//echo $total_holiday;
$working_days=$totaldays-($total_sun+$total_holiday);
?>
<div style="padding-left:20px;padding-top:10px">

<div class="col-lg-12"><img src="<?=site_url()?>assets/images/lg.png" alt="Sandip University" width="45" height="45"><label style="padding-left:20px"><b>Sandip University</b></label></div><br>
<div><label style="padding-left:60px">Trimbak Road, A/p - Mahiravani, Nashik – 422 213 </label> </div>
<div><label style="padding-left:60px">Website : http://www.sandipuniversity.com | Email : info@sandipuniversity.com </label> </div>
<div><label style="padding-left:60px">Ph: (02594) 222 541 Fax: (02594) 222 555 </label> </div>
<hr  style="border-width:1px;width:50%">
<div class="col-lg-12"><label><b>School: </b><?php $sc=$this->Admin_model->getSchoolById($emp_school);echo $sc[0]['college_name'];?></label>&nbsp;&nbsp;&nbsp;
<label><b>Department: </b> <?php $de=$this->Admin_model->getDepartmentById($department);echo $de[0]['department_name'];?></label>
</div>
<br><br>
<div class="col-lg-12"><label ><b><u>Monthly Employee Present Days Report Of <?=$monthName?>  <?=$ysearch?>  </u></b></label></div><br>
</div>
<br><br>
<div style="padding-left:10px">
<table  cellpadding="0" cellspacing="0" style="font-size:11px;border:1px solid;" >
<tbody>
<!--<tr style="border: 1px solid black;"><td colspan="9"style="border: 1px solid black;"></td>
 <td colspan="10" style="border: 1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Leave</td>
 <td style="border: 1px solid black;"></td>
 </tr>-->
 <tr bgcolor="#9ed9ed" style="border: 1px solid black;">
 <td style="border: 1px solid black;">SRNo.</td>
 <td style="border: 1px solid black;">Staff ID</td>
 <td style="border: 1px solid black;">Name Of Employee</td>
 <td style="border: 1px solid black;">Month Days</td>
 <td style="border: 1px solid black;">Working Days</td>
 <td style="border: 1px solid black;">Present Days</td>
 <td style="border: 1px solid black;">Sunday</td>
 <td style="border: 1px solid black;">Holiday</td>
 <td style="border: 1px solid black;">OD</td>
 <td style="border: 1px solid black;">CL</td>
 <td style="border: 1px solid black;">ML</td>
 <td style="border: 1px solid black;">EL</td>
 <td style="border: 1px solid black;">C-off</td>
 <td style="border: 1px solid black;">SL</td>
 <td style="border: 1px solid black;">VL</td>
 <td style="border: 1px solid black;">Leave</td>
 <td style="border: 1px solid black;">Other</td>
 <td style="border: 1px solid black;">LWP</td>
 <td style="border: 1px solid black;">Lcome/EG o</td>
 <td style="border: 1px solid black;">Total</td>
  </tr>

 <?php foreach($all_attend as $key=>$val){
$present=($all_attend[$key]['total_present']- $all_attend[$key]['total_outduty']);
$total_final_workday=($present+$all_attend[$key]['total_outduty']+
                      $all_attend[$key]['total_CL']+$all_attend[$key]['total_ML']+$all_attend[$key]['total_EL']
					  +$all_attend[$key]['total_Coff']+$all_attend[$key]['total_SL']+$all_attend[$key]['total_VL']
					  +$all_attend[$key]['total_leave']+$all_attend[$key]['total_Other']+$all_attend[$key]['total_Lcm']);
if($working_days!=$total_final_workday){?>

<tr bgcolor="#edc2b8" style="border:1px solid black;"><!--Heighlight the employee who are full present-->
<?php }else{?>
<tr  style="border:1px solid black;">
<?php } ?>

<td style="border:1px solid black;"><?=$i++;?></td>
<td style="border:1px solid black;"><?=$all_attend[$key]['UserId']?></td>
<td style="border:1px solid black;"><?=$all_attend[$key]['fname']." ".$all_attend[$key]['lname']?></td>
<td style="border:1px solid black;"><?=$totaldays?></td><!--Total Month Days-->
<td style="border:1px solid black;"><?=$working_days?></td><!--Working days of Month excluding Sundays and Holidays-->
<td style="border:1px solid black;"><?=$present;?></td><!--Total Present Day without OD-->
<td style="border:1px solid black;"><?=isset($total_sun)?$total_sun:0;?></td><!--Sundays Count-->
<td style="border:1px solid black;"><?=isset($total_holiday)?$total_holiday:0?></td><!--Holidays-->
<td style="border:1px solid black;"><?=isset($all_attend[$key]['total_outduty'])?$all_attend[$key]['total_outduty']:0?></td><!--OD-->
<td style="border:1px solid black;"><?=isset($all_attend[$key]['total_CL'])?$all_attend[$key]['total_CL']:0?></td><!--CL-->
<td style="border:1px solid black;"><?=isset($all_attend[$key]['total_ML'])?$all_attend[$key]['total_ML']:0?></td><!--ML-->
<td style="border:1px solid black;"><?=isset($all_attend[$key]['total_EL'])?$all_attend[$key]['total_EL']:0?></td><!--EL-->
<td style="border:1px solid black;"><?=isset($all_attend[$key]['total_Coff'])?$all_attend[$key]['total_Coff']:0?></td><!--C-off-->
<td style="border:1px solid black;"><?=isset($all_attend[$key]['total_SL'])?$all_attend[$key]['total_SL']:0?></td><!--SL-->
<td style="border:1px solid black;"><?=isset($all_attend[$key]['total_VL'])?$all_attend[$key]['total_VL']:0?></td><!--VL-->
<td style="border:1px solid black;"><?=isset($all_attend[$key]['total_leave'])?$all_attend[$key]['total_leave']:0?></td><!--Leave-->
<td style="border:1px solid black;"><?=isset($all_attend[$key]['total_Other'])?$all_attend[$key]['total_Other']:0?></td><!--Other-->
<td style="border:1px solid black;"><?=isset($all_attend[$key]['total_LWP'])?$all_attend[$key]['total_LWP']:0?></td><!--LWP-->
<td style="border:1px solid black;"><?=isset($all_attend[$key]['total_Lcm'])?$all_attend[$key]['total_Lcm']:0?></td><!--Lcome/EG o-->
<?php
//calculation  of total worked days at the end of month

                      
?>
<td style="border:1px solid black;"><?=$total_final_workday?></td>
</tr>	
 <?php } ?>
	
</tbody>	
</table>
</div>
<?php } else{?>
<div><label style="color:red"><b>No Attendance available.....</b></label></div>
<?php } ?>
<br><br><br>
</div>
<?php
if(!empty($all_attend)){?>
 <table width="600px" cellpadding="2" cellspacing="2" border="0">
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center"><input type="hidden" id="datatodisplay" name="datatodisplay">
        <input type="submit" class="btn-primary" value="Download To PDF">
      </td>
    </tr>
  </table>
<?php } ?>
</form>
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


