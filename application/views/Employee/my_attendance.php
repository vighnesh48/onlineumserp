<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
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
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Search Attendance </h1>
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
                            	<div class="panel-heading"><strong>Search </strong></div>
                                <div class="panel-body">
								<span id="flash-messages" style="color:Red;padding-left:110px;"><?php echo $this->session->flashdata('message1'); ?></span>
								<span id="flash-messages" style="color:Green;padding-left:110px;"><?php echo $this->session->flashdata('message'); ?></span>
                                <div class="panel-padding no-padding-vr">
                            <div class="form-group">
                              <div class="row"></div>
							  <div class="portlet-body form">
							  <form id="form" name="form" action="<?=base_url($currentModule.'/check_my_attendance')?>" method="POST">
								<div class="form-body">
                                <div class="form-group">
								<label class="col-md-2">Select Month</label>
                                   <div class="col-md-4" >
                      <input id="dob-datepicker" class="form-control  date-picker" name="attend_date" value="" placeholder="Enter Month " type="text" required>

                                  </div>
                                  <div class=" col-md-3">  
                                            <button type="submit" class="btn btn-primary form-control" >Submit</button>
                                        </div>
                                        <div class="col-md-3" ></div>
                                  </div>
				                 
                                    </form>
									</div>
									<?php if(!empty($res)){?>
										<div class="form-group">
                              <div class="row"></div>
							  <div class="table-scrollable">
							  <table style="width: 1044px;" aria-describedby="applications_info" role="grid" 
							  class="table table-striped table-bordered table-hover no-footer" id="applications">
							  <!-- class='dataTable' for sorting arrows icon for col-->
                                     <thead>
                                    <tr role="row">
									<th aria-label="ID: activate to sort column ascending" style="width: 30px;" colspan="1" rowspan="1" aria-controls="applications" tabindex="0" class="center sorting" colspan=""><?php echo date("F",strtotime($res[0]['Intime']))." ".date("Y",strtotime($res[0]['Intime']))." Attendance";?></th>
									</tr>
                                    </thead>
     <tbody>
<tr>
<td>Days</td>	 
									<?php 
									$cnt=count($res);	

                                 foreach($res as $val){
									
									 $date1 = strtotime($val['Intime']);
									 $date2 = strtotime($val['Outtime']);
                                     $dat = date("F d Y", $date1);
									  if($val['Intime']=='0000-00-00 00:00:00'){
										$intime="00:00:00"; 
									 } else{
										$intime = date('H:m:s A',$date1); 
									 }
                                     if($val['Outtime']=='0000-00-00 00:00:00'){
										$outtime="00:00:00"; 
									 } else{
										$outtime = date('H:m:s A',$date2); 
									 }
									 $d = date_parse_from_format("Y-m-d", $val['Intime']);
									 $msearch=$d["month"];
                                     $ysearch=date("Y",$date1);
									 //echo $msearch." ".$ysearch;
									 $totaldays=cal_days_in_month(CAL_GREGORIAN, $msearch, $ysearch);
									 
									// echo "number of days=".$totaldays;
								 }
								 for($i=1;$i<=$totaldays;$i++){
									 echo "<td>".$i."</td>";
								 }
								 ?>
							</tr> 
						<?php 
						foreach($res as $key=>$val){
				   $d=date('d',strtotime($res[$key]['Intime']));//get day from date
				    $d = intval( $d); //for removing leading zero from day i.e.01,02 etc to make it 1,2 etc
				   $day[$d]=$res[$key]['status']; //array for only punched day presenty status
				   $day1[$d]=$d; //array for only punched day 
				   $log[$d]=$res[$key]['DeviceLogId'];//array for punch Id from table
				   $empId[$d]=$res[$key]['emp_id'];// array for employee Id
				   $fname[$d]=$res[$key]['fname'];//array for fname
				   $lname[$d]=$res[$key]['lname'];//array for lname
				   $adate[$d]=date("F d Y",strtotime($res[$key]['Intime']));//array of date of attendance;
				     if($res[$key]['Intime']=='0000-00-00 00:00:00'){
										$intime="00:00:00"; 
										$InTime[$d]=$intime;
									 } else{
										$intime = date('H:m:s A',$date1); 
										$InTime[$d]=$intime;
									}
                    if($res[$key]['Outtime']=='0000-00-00 00:00:00'){
										$outtime="00:00:00"; 
										$OutTime[$d]=$outtime;
									 } else{
										$outtime = date('H:m:s A',$date2); 
										$OutTime[$d]=$outtime;
									 }
				   
			           }
					  
				?>	
<tr><td><label>Status</label></td>
                <?php for($i=1;$i<=$totaldays;$i++){
	                  $str="";
					   $temp=array_search($i,$day1);
					  // echo $temp;
					if($i==$temp) {
						    	 if($day[$i]=='present'){
									$str='P';
								}elseif($day[$i]=='outduty'){
									$str='OD';
								}elseif($day[$i]=='overtime'){
									$str='OT';
								}elseif($day[$i]=='leave'){
									$str='L';
								}elseif($day[$i]=='abscent'){
									$str='A';
								}elseif($day[$i]=='latemark'){
									$str='LT';
								}else{
									$str="";
								}
					}else{
						
						$str="-";//it indicates not punched....
					}             
				    
	                           
	                               
if($str=='-'){
	echo "<td><a title='Not Punched' href='#'>".$str."</a></td>";
}else{
	echo "<td><a>".$str."</a></td>";
	}									 
		 }
							
								 ?>							
                        </tr>   
<!--<tr><td colspan="<?=$totaldays+1?>"></td></tr>-->						
<tr>
<td colspan="<?php echo $totaldays-24;?>"><label>Total Days Present:</label></td><td colspan="<?php echo $totaldays-24+3;?>">
<?php echo $present[0]['total'];?></td><td colspan="<?php echo $totaldays-24;?>"><label>Total Days OD:</label></td><td colspan="<?php echo $totaldays-24+4;?>"><?php echo $outer[0]['total'];?></td>
</tr>
<tr>
<td colspan="<?php echo $totaldays-24;?>"><label>Total Days Absecent:</label></td><td colspan="<?php echo $totaldays-24+3;?>"><?php echo $abscent[0]['total'];?></td><td colspan="<?php echo $totaldays-24;?>"><label>Total Days OT:</label></td><td colspan="<?php echo $totaldays-24+4;?>"><?php echo $over[0]['total'];?></td>
</tr>	
<tr>
<td colspan="<?php echo $totaldays-24;?>"><label>Total Late Marks:</label></td><td colspan="<?php echo $totaldays-24+3;?>"><?php echo $late[0]['total'];?></td><td colspan="<?php echo $totaldays-24;?>"><label>Total Leaves:</label></td><td colspan="<?php echo $totaldays-24+4;?>"><?php echo $leave[0]['total'];?></td>
</tr>					
						</tbody>

							</table></div>
							    </div>

								
								 <?php } ?>
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
<script>

</script>

<script type="text/javascript">
$(document).ready(function(){
	//datepicker
	$('#dob-datepicker').datepicker( {format: "yyyy-m",startView: "months",minViewMode: "months",autoclose:true});
	//for time picker
	$('#dob-datepicker1').timepicker({ 'timeFormat': 'h:i A',autoclose:true});
	$('#dob-datepicker2').timepicker({ 'timeFormat': 'H:i:s',autoclose:true});
	
	var content = '<tr>'+$('#eduDetTable tbody tr').html()+'</tr>';
	$("#eduDetTable").on("click","input[name='addMore']", function(e){	
	$(this).parent().parent('tr').after(content);		
	});
	$("#eduDetTable").on("click","input[name='remove']", function(e){	
		var rowCount = $('#eduDetTable tbody tr').length;
		if(rowCount>1){
			$(this).parent().parent('tr').remove();
		}
	});
		
 	
});
</script>




<!-- Modal -->
<div id="edit-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
 <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Update Attendance</h4>
      </div>
      <div class="modal-body">
         <form class="form-horizontal" action="<?=base_url($currentModule.'/update_attendance')?>"  method="POST" role="form">
		 <?php /* echo"<pre>";
		 print_r($res);
		 echo "</pre>"; */ ?>
                  <div class="form-group">
                    <label  class="col-sm-2 control-label"
                              for="input1">Employee ID</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="input1" value="" placeholder="emp_id"/>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label"
                          for="input2" >Employee Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" value="" id="input2" placeholder="Employee Name"/>
                    </div>
                  </div>
				  <div class="form-group">
                    <label class="col-sm-2 control-label"
                          for="input3" >Date Of Attendance</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" value="" id="input3" placeholder="Date Of Attendance"/>
                    </div>
                  </div>
				  <div class="form-group">
                    <label class="col-sm-2 control-label"
                          for="input4" >Punch InTime</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" value="" id="input4" placeholder="HH:MM:SS"/>
                    </div>
                  </div>
				  <div class="form-group">
                    <label class="col-sm-2 control-label"
                          for="input5" >Punch OutTime</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" value="" id="input5" placeholder="HH:MM:SS"/>
                    </div>
                  </div>
				  <div class="form-group">
                    <label class="col-sm-2 control-label"
                          for="input6" >Status</label>
                    <div class="col-sm-10">
                         <select id="input6" name="status" class="form-control">
						 <option value="">Select </option>
								   <option  value="present">present</option>
								  <option  value="outduty">outduty</option>
								  <option  value="overtime">overtime</option>
								  <option  value="leave">leave</option>
								  <option  value="abscent">abscent</option>
								  <option  value="latemark">latemark</option>
								  </select>
                    </div>
                  </div>
                 
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" id="submit" class="btn btn-primary">Update</button>
					  
                    </div>
                  </div>
                </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
