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
							  <form id="form" name="form" action="<?=base_url($currentModule.'/fetch_attendance')?>" method="POST">
								<div class="form-body">
                                <div class="form-group">
								<label class="col-md-3">Select Organization</label>
                                             <div class="col-md-3" >
											 <select name="org_name" class="form-control" required>
											 <option value="">Select Organization</option>
											 <?php foreach($org_list as $org) {
												 echo "<option  value=".$org['organisation_id'].">".$org['org_name']."</option>";
											 } ?>
											
										     </select>
                                       </div>
                                  </div>
								   <div class="form-group">
								<label class="col-md-3">Select Department</label>
                                             <div class="col-md-3" >
											 <select name="dept_name" class="form-control" required>
											 <option value="">Select Department</option>
											 <?php foreach($dept_list as $dept) {
												 echo "<option  value=".$dept['department_id'].">".$dept['department_name']."</option>";
											 } ?>
											
										     </select>
                                       </div>
                                  </div>
								  <div class="form-group">
								<label class="col-md-3">Enter Employee ID</label>
                                   <div class="col-md-3" >
                                  <input class="form-control" name="emp_id" value="" placeholder="Enter Employee ID" type="text" required>

                                  </div>
                                  </div>
								  <div class="form-group">
								<label class="col-md-3">Select Month</label>
                                   <div class="col-md-3" >
                      <input id="dob-datepicker" class="form-control  date-picker" name="attend_date" value="" placeholder="Enter Month " type="text" required>

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
					if($i==array_search($i,$day1)) {
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
	echo "<td javascript:void(0) onclick='javascript:test(".$log[$i].")'><a name='materialValue' title='".$day[$i]."' id='todolink".$log[$i]."'  data-toggle='modal' class='open-AddBookDialog' data-target='#edit-modal' data-todo='{\"emp_id\":".$empId[$i].",\"name\":\"".$fname[$i].' '.$lname[$i]."\",\"da\":\"".$adate[$i]."\",\"intime\":\"".$InTime[$i]."\",\"outtime\":\"".$OutTime[$i]."\",\"status\":\"".$day[$i]."\",\"logId\":".$log[$i]."}'>".$str."</a></td>";
	}									 
		 }
							
								 ?>							
                        </tr>   
<tr><td colspan="<?=$totaldays+1?>"></td></tr>						
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
function test(id){
	//alert(id);
	var total = id;
    var selector = '' + total;
	selector = '#todolink' + selector;
	var todoId = $(selector).data('todo').emp_id;// employee id
	//alert(todoId);
    var todoname = $(selector).data('todo').name; //name
    var tododt = $(selector).data('todo').da;  //date of attendance
    var todoin = $(selector).data('todo').intime; // intime
    var todout = $(selector).data('todo').outtime; //outtime
	var todologId = $(selector).data('todo').logId; //LogId
	//alert(todologId);
  //  var todostatus = $('#todolink').data('todo').status;
    $(".modal-body #input1").val( todoId );
    $(".modal-body #input2").val( todoname );
    $(".modal-body #input3").val( tododt );
    $(".modal-body #input4").val( todoin );
    $(".modal-body #input5").val( todout );
   // $(".modal-body #input6").val( todostatus );
   $('#edit-modal').fadeIn('show');
    //$('#edit-modal').modal('show');
	//return false;
}
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
		
 $(document).on('click', 'button[data-dismiss]', function (e) {
            location.reload(true);
        });
	
	$("#submit").click(function(){
var emp_id = $("#input1").val();
var name = $("#input2").val();
var adate = $("#input3").val();
var intime = $("#input4").val();
var outttime = $("#input5").val();
var status = $("#input6").val();

// Returns successful data submission message when the entered information is stored in database.
var dataString = 'emp_id='+ emp_id + '&name='+ name + '&adate='+ adate + '&intime='+ intime + '&outttime='+ outttime + '&status='+ status;
if(emp_id==''||name==''||adate==''||intime==''||outttime=='' ||status=='')
{
alert("Please Fill All Fields");
}
else
{
// AJAX Code To Submit Form.
$.ajax({
type: "POST",
url: "http://localhost/sandip_lms/admin/update_attendance",
data: dataString,
cache: false,
success: function(result){
//alert(result);
$('#edit-modal').modal('hide');
 location.reload(true);
}
});
}
return false;
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
