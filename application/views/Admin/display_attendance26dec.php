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
        <li class="active"><a href="#">Attendance </a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;View Attendance </h1>
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
                            	<div class="panel-heading"><strong>Attendance </strong></div>
                                <div class="panel-body">
								<span id="flash-messages" style="color:red;padding-left:110px;"><?php echo $this->session->flashdata('message1'); ?></span>
                                <div class="panel-padding no-padding-vr">
                            <div class="form-group">
                              <div class="row"></div>
							  <div class="portlet-body form">
							  <form id="form" name="form" action="<?=base_url($currentModule.'/view_attendance')?>" method="POST" enctype="multipart/form-data">
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
                                  <input id="dob-datepicker" class="form-control form-control-inline input-medium date-picker" name="attend_date" value="" placeholder="Enter Month" type="text">

                                             </div>
                                  </div>
				                                                                               

                                   <div class="form-group">
								   <div class="col-md-3" ></div>
                                      <div class=" col-md-2">  
                                            <button type="submit" class="btn btn-primary form-control" >Submit</button>
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
<form action="exporttoexcel" method="post" 
onsubmit='$("#datatodisplay").val( $("<div>").append( $("#ReportTable").eq(0).clone() ).html() )'>
<div class="attexl" id="ReportTable" style="">
<?php
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
<div class="col-lg-12"><label><b>Sandip University</b></label></div><br>
<div class="col-lg-12"><label><b>School: </b><?php $sc=$this->Admin_model->getSchoolById($this->session->userdata("emp_school"));echo $sc[0]['college_name'];?></label></div>
<div class="col-lg-12"><label><b>Department: </b> <?php $de=$this->Admin_model->getDepartmentById($this->session->userdata("department"));echo $de[0]['department_name'];?></label></div>
<div class="col-lg-12"><label ><b><u>Monthly Attendance Report Of<?=$monthName?><?=$ysearch?>  </u></b></label></div><br>
</div>
<br><br>
 <div class="table-scrollable">
<table cellpadding="0" cellspacing="0" style="font-size:11px;border:1px solid;" >
 <tr style="border: 1px solid black;">
	<td style="border: 1px solid black;">Sr No.</td>
    <?php while(strtotime($date) <= strtotime($end)) {
        $day_num = date('d', strtotime($date));
		$day_name = date('D', strtotime($date));
		$totaldays['total'][]=$day_num;
		$totaldays['weekd'][]=$day_name ;
		
        $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));?>
      <td style="border: 1px solid black;"><?=$day_num?> <br/> <?=$day_name?></td>
   <?php }
    ?>
	<td style="border: 1px solid black;">Total</td>
    </tr>
	
	<?php
    /*  echo "total days=". count($totaldays['total'])	;
	print_r($totaldays['total']);
	       print_r($totaldays['weekd']); 
		    */
	?>
	<?php 
	$sr=0;
	foreach($all_emp as $e ){
		                            /* echo"<pre>";
	                                print_r($attendance[$e['emp_id']]);
	                                echo"</pre>"; */
     $sr++;   
	?>
		<tr style="border: 1px solid black;">
		<td style="border: 1px solid black;"><?=$sr;?></td>
		<td colspan="<?=$lt?>" style="border: 1px solid black;"><?php echo"<b>Staff ID:</b> ".$e['emp_id']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp"."<b>Staff Name:</b> ".$e['fname']." ".$e['mname']." ".$e['lname']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp"."<b>Designation:</b> ".$e['designation_name']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp"."<b>Department:</b> ".$e['department_name']?></td>
		<td style="border: 1px solid black;" rowspan="4">22.0+1.0(CL)+1.0(CO)+0.0(ML)0.0(EL)<br>
+0.0(MTL)+0.0(SL)+0.0(L)+<br>
0.0(O)+4.0(S)+3.0(H)+0.0(VL) = 31.0<br>
(Total)</td>
		</tr>
		<tr style="border: 1px solid black;"><td style="border: 1px solid black;">In:</td>
		
		<?php foreach($attendance[$e['emp_id']] as $att){ 
		$d=date('d',strtotime($att['Intime']));
		$d = intval($d);
		 $dayIn[$e['emp_id']][$d]=$d; //array for only punched In day 
		 $tempdayin[$e['emp_id']][$d]=$dayIn[$e['emp_id']][$d];
		 $timedayin[$e['emp_id']][$d]=$att['Intime'];
		?>
		<?php } ?>
		
		<?php for($i=1;$i<=count($totaldays['total']);$i++){
			//first check holiday and sunday ***********************
				$dname=$attend_date."-".$totaldays['total'][$i-1];
				$check_holiday=$this->Admin_model->checkHoliday($dname);//check for holiday
				//echo $check_holiday;die()
				if($check_holiday=='true'){
					$day_name="Holiday";
				}else{
					$day_name = date('D', strtotime($dname));
					$checkforLeave=$this->Admin_model->checkDateForLeaveOfEmployee($dname,$e['emp_id']);//check for leave
					if(!empty($checkforLeave)){
						$lflag=1;
						$day_name=$checkforLeave;
					}else{
						$lflag=0;
					}
				}
			$temp1=array_search($i,$tempdayin[$e['emp_id']]);
			if(($day_name=='Sun')){?>
			<td style="border: 1px solid black;"><?php echo "<b style='color:red;'>".$day_name."</b>";?></td>	
			<?php }elseif(($day_name=='Holiday')){ ?>
			<td style="border: 1px solid black;"><?php echo "<b style='color:red;'>".$day_name."</b>";?></td>		
			<?php 
			}elseif(($day_name!='Sun')&&($day_name!='Holiday')&&($lflag==1)){ ?>
			<td style="border: 1px solid black;" ><?php echo "<b style='color:green;'>".$day_name."</b>";?></td>		
			<?php 
			}elseif(($day_name!='Sun')&&($day_name!='Holiday')&&($lflag!=1)){
				//echo $day_name;
	                 $temp=array_search($i,$tempdayin[$e['emp_id']]);
					// echo $temp;
			if($i==$temp) { ?> <td style="border: 1px solid black;"><?php  if($timedayin[$e['emp_id']][$temp]=='0000-00-00 00:00:00') echo "NA"; else{ echo  date('H:i:s',strtotime($timedayin[$e['emp_id']][$temp]));}?></td><?php }else{?>
			<td style="border: 1px solid black;"><?php echo "NA";?></td>
			
		<?php } } } ?>
			
		
		</tr>
		 
		<tr style="border: 1px solid black;"><td style="border: 1px solid black;">Out:</td>
		
		<?php foreach($attendance[$e['emp_id']] as $att){
			$d=date('d',strtotime($att['Outtime']));
			$d = intval( $d);
		    $dayOut[$e['emp_id']][$d]=$d; //array for only punched In day 
			$tempdayout[$e['emp_id']][$d]=$dayOut[$e['emp_id']][$d];
		    $timedayout[$e['emp_id']][$d]=$att['Outtime'];
			?>
			<?php }?>
		<?php for($i=1;$i<=count($totaldays['total']);$i++){
				//first check holiday and sunday **************************
				$dname=$attend_date."-".$totaldays['total'][$i-1];
			$check_holiday=$this->Admin_model->checkHoliday($dname);
				//echo $check_holiday;die()
				if($check_holiday=='true'){
					$day_name="Holiday";
				}else{
					$day_name = date('D', strtotime($dname));
					$checkforLeave=$this->Admin_model->checkDateForLeaveOfEmployee($dname,$e['emp_id']);
					if(!empty($checkforLeave)){
						$lflag=1;
						$day_name=$checkforLeave;
					}else{
						$lflag=0;
					}
				}
			$temp1=array_search($i,$tempdayin[$e['emp_id']]);
			if(($day_name=='Sun')){?>
			<td style="border: 1px solid black;"><?php echo "<b style='color:red;'>".$day_name."</b>";?></td>	
			<?php }elseif(($day_name=='Holiday')){ ?>
			<td style="border: 1px solid black;"><?php echo "<b style='color:red;'>".$day_name."</b>";?></td>		
			<?php 
			}elseif(($day_name!='Sun')&&($day_name!='Holiday')&&($lflag==1)){ ?>
			<td style="border: 1px solid black;" ><?php echo "-";//echo "<b style='color:green;'>".$day_name."</b>";?></td>		
			<?php 
			}elseif(($day_name!='Sun')&&($day_name!='Holiday')&&($lflag!=1)){
	                 $temp=array_search($i,$tempdayout[$e['emp_id']]);
					// echo $temp;
			if($i==$temp) { ?> <td style="border: 1px solid black;"><?php if($timedayout[$e['emp_id']][$temp]=='0000-00-00 00:00:00') echo "NA"; else{ echo  date('H:i:s',strtotime($timedayout[$e['emp_id']][$temp]));}?></td><?php }else{ ?>
			<td style="border: 1px solid black;"><?php echo "NA";?></td>
			
			<?php } } }?>
			
		</tr>
		<tr style="border: 1px solid black;"><td style="border: 1px solid black;">Dur:</td>
		<?php foreach($attendance[$e['emp_id']] as $att){
			$d=date('d',strtotime($att['Outtime']));
			$d = intval( $d);
			if($att['Intime']!='0000-00-00 00:00:00')$time1=date('H:i:s',strtotime($att['Intime']));else $time1='00:00:00';
			if($att['Outtime']!='0000-00-00 00:00:00')$time2=date('H:i:s',strtotime($att['Outtime'])); else $time2='00:00:00';
          $diff=$this->Admin_model->get_time_difference($time1, $time2);
          $dur[$d]=	$diff;	  
		} // print_r( $timedayout);?>
		<?php for($i=1;$i<=count($totaldays['total']);$i++){
				//echo $i;
	                 $temp1=array_search($i,$tempdayin[$e['emp_id']]);
	                 $temp2=array_search($i,$tempdayout[$e['emp_id']]);
					// echo $temp;
						//first check holiday and sunday **************************
			$dname=$attend_date."-".$totaldays['total'][$i-1];
			$check_holiday=$this->Admin_model->checkHoliday($dname);
				//echo $check_holiday;die()
				if($check_holiday=='true'){
					$day_name="Holiday";
				}else{
					$day_name = date('D', strtotime($dname));
					$checkforLeave=$this->Admin_model->checkDateForLeaveOfEmployee($dname,$e['emp_id']);
					if(!empty($checkforLeave)){
						$lflag=1;
						$day_name=$checkforLeave;
					}else{
						$lflag=0;
					}
				}
			$temp11=array_search($i,$tempdayin[$e['emp_id']]);
			if(($day_name=='Sun')){?>
			<td style="border: 1px solid black;"><?php echo "<b style='color:red;'>".$day_name."</b>";?></td>	
			<?php }elseif(($day_name=='Holiday')){ ?>
			<td style="border: 1px solid black;"><?php echo "<b style='color:red;'>".$day_name."</b>";?></td>		
			<?php 
			}elseif(($day_name!='Sun')&&($day_name!='Holiday')&&($lflag==1)){ ?>
			<td style="border: 1px solid black;" ><?php echo "-";//echo "<b style='color:green;'>".$day_name."</b>";?></td>		
			<?php 
			}elseif(($day_name!='Sun')&&($day_name!='Holiday')&&($lflag!=1)){
				if($temp1==$temp2 && $i==$temp1 && $i==$temp2) { ?> <td style="border: 1px solid black;"><?php echo $dur[$temp1] ;?></td><?php }else{?>
			<td style="border: 1px solid black;"><?php echo "00:00:00";?></td>
			
		<?php } }}?>
		
		</tr>
	<?php }//echo"<pre>";print_r($timedayin);echo"</pre>";echo"<pre>";print_r($timedayout);echo"</pre>";	?>
	
	
</table>
</div>
<?php } else{?>
<div><label style="color:red"><b>No Attendance available.....</b></label></div>
<?php } ?>
</div>
<?php
if(!empty($attendance)){?>
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

<div id="dvData" style="display:none">
							  <table>
							      <tr>
        <th>UserId </th>
         <th>In Time</th>
        <th>Out Time</th>
		<th>Punch Date</th>
    </tr>                           
                                    
                                   <?php if(empty($attendance)){?>
									<tr id="row441" class="odd" role="row">
										<td class=" center"><?php echo "No Attendance  Available for Mentioned Date"; ?></td>
										</tr>
									<?php }else{
										$i=0;
										foreach($attendance as $key=>$val){
											$i++;
										?>
							<tr>		
										<td><?php echo $attendance[$key]['UserId'];?></td>
										<td><?php echo $attendance[$key]['punch_intime'];?></td>
										<td><?php echo $attendance[$key]['punch_outtime'];?></td>
										<td><?php echo $attendance[$key]['punch_date'];?></td>
										
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


