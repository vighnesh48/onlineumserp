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
        <li><a href="#">Attendance</a></li>
        <li class="active"><a href="#">Datewise Attendance</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Datewise Attendance</h1>
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
                            	<div class="panel-heading"><strong>Datewise Attendance </strong></div>
                                <div class="panel-body">
								<span id="flash-messages" style="color:red;padding-left:110px;"><?php echo $this->session->flashdata('message1'); ?></span>
                                <div class="panel-padding no-padding-vr">
                           
							  <div class="portlet-body form">
    							  <form id="form" name="form" action="<?=base_url($currentModule.'/daywise_attendance')?>" method="POST" enctype="multipart/form-data">
    								<div class="form-body">
    								    <div class="row">
            								<div class="col-sm-4">
            								    <div class="form-group">
                								    <select class="select2me form-control" name="emp_school" onchange="getstaffdept_using_school(this.value)" id="emp_school" >
                											 <option value="">Select School</option>
                											 <?php foreach($school_list as $sc) {
                												 echo "<option  value=".$sc['college_id'].">".$sc['college_name']."</option>";
                											 } ?>
                											
                								    </select>
                								    </div>
            					            </div>
    							         	<div class="col-sm-4">
    							         	    <div class="form-group">
            								    	<select class="form-control select2me" id="department"  name="department" >
            											<option value="">Select</option>
            										</select>
    										    </div>
    								        </div>
    								        <div class="col-sm-2">
    								            <div class="form-group">
    								    	        <input id="dob-datepicker" required class="form-control form-control-inline input-small date-picker" name="attend_date" value="" placeholder="Select Date" type="text"/>
                                                 </div>  
                                                 
                                            </div>  
                                            <div class="col-sm-2">
                                               <div class="form-group">
                                                     <button type="submit" name="submit" class="btn btn-primary form-control" >Submit</button>
                                                </div>     
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


</div>

</form>
    
							   </div>
                                </div>
                            </div> 
                          </div>                          
                           
                        </div>
                    </div>
                </div>
                <div class="panel-warning"> 
                <div class="panel">
                    <div class="panel-heading"><b>Datewise Employee Report Of <?=date("d M Y",strtotime($attend_date))?> </b></div>
                    <div class="panel-body">
                        <div style="padding-left:20px;padding-top:10px">



<div class="col-lg-4">
    <?php if(!empty($emp_school)){?><label><b>SCHOOL : </b> <?php $sc=$this->Admin_model->getSchoolById($emp_school);echo $sc[0]['college_name'];?></label>
    </div>
  <div class="col-lg-4">  
<label><b>DEPARTMENT : </b>  <?php $de=$this->Admin_model->getDepartmentById($department);echo $de[0]['department_name'];?></label>
</div>
<?php }elseif(empty($emp_school)){ ?>
<div class="col-lg-12"><label><b>ALL EMPLOYEE REPORT</b></label></div>
<?php } ?>

</div>
<br><br>
<div style="padding-left:10px">
<table  cellpadding="0" cellspacing="0" class="table">
<tbody>
<!--<tr style="border: 1px solid black;"><td colspan="9"style="border: 1px solid black;"></td>
 <td colspan="10" style="border: 1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Leave</td>
 <td style="border: 1px solid black;"></td>
 </tr>-->
 <tr bgcolor="#9ed9ed" style="border: 1px solid black;">
 <td style="border: 1px solid black;">S.No.</td>
 <td style="border: 1px solid black;">Staff ID</td>
 <td style="border: 1px solid black;">Name Of Employee</td>

 <td style="border: 1px solid black;">In Time</td>
 <td style="border: 1px solid black;">Out Time</td>
 <td style="border: 1px solid black;">Duration</td>
  </tr>

 <?php 
 $j='1';
 foreach($all_attend as $val){
     $ex = explode(',',$val);
      $diff=$this->Admin_model->get_time_difference(date('H:i:s',strtotime($ex[2])), date('H:i:s',strtotime($ex[3])));
    
      if( date('H:i',strtotime($ex[3]))=="00:00"){
           $diff="00:00";
      }else
      {
       $diff;
      }
/* $present= $all_attend[$key]['total_present']; //($all_attend[$key]['total_present']- $all_attend[$key]['total_outduty']);
$total_final_workday=($present+$all_attend[$key]['total_outduty']+
                      $all_attend[$key]['total_CL']+$all_attend[$key]['total_ML']+$all_attend[$key]['total_EL']
					  +$all_attend[$key]['total_Coff']+$all_attend[$key]['total_SL']+$all_attend[$key]['total_VL']
					  +$all_attend[$key]['total_leave']+$all_attend[$key]['total_STL']+$all_attend[$key]['total_LWP']); */
if($all_attend[$key]['working_days']!=$all_attend[$key]['Total']){?> 

<tr bgcolor="#edc2b8" style="border:1px solid black;"></tr><!--Heighlight the employee who are full present-->
<?php }else{?>
<tr  style="border:1px solid black;">
<?php } ?>

<td style="border:1px solid black;"><?=$i++;?></td>
<td style="border:1px solid black;"><?=$ex[0]?></td>
<td style="border:1px solid black;"><?=$ex[1]?></td>

<td style="border:1px solid black;"><?=isset($ex[2])?date('H:i',strtotime($ex[2])):0?></td><!--LWP-->
<td style="border:1px solid black;"><?=isset($ex[3])?date('H:i',strtotime($ex[3])):0?></td><!--Study Leave-->
<td style="border:1px solid black;"><?=$diff?></td>
</tr>	
 <?php } ?>
	
</tbody>	
</table>
</div>
<?php } else{?>
<div><label style="color:red"><b>No Attendance available.....</b></label></div>
<?php } ?>
                        
                    </div>
                </div>
                </div>
            </div>    
        </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('#dob-datepicker').datepicker( {format: "d-m-yyyy",startView: "months",minViewMode: "date",autoclose:true});
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


