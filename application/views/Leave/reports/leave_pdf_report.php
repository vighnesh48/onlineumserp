<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

</head>

<style>

.attexl table th{
    border: 1px solid black;
    padding: 5px;
    background-color:grey;
    color: white;
}
.add-table tr td{border:0px}

.attexl table  td{
     border: 1px solid black;
    padding: 5px;border-collapse: collapse
}
.bottom-table{padding:50px 0 20px 0}
.bottom-table-2{padding-top:20px}
</style>

<div class="row">

<div class="col-lg-12">
<?php include('pdfheader.php'); ?>
<hr  style="border-width:1px;">
<?php
$date =  $attend_date."-01";
$lt=date('t', strtotime($attend_date)); //get end date of month
$end = $attend_date."-".$lt;
$time=strtotime($attend_date);
$d = date_parse_from_format("Y-m-d",$attend_date);
$msearch=$d["month"];//month number
$ysearch=date("Y",strtotime($attend_date));
$monthName = date('F', mktime(0, 0, 0, $msearch, 10));// month name
?>
<div align="center" style="text-align:center"><b>Monthly Leave Report Of 
                                      <?=$monthName?>
                                      <?=$ysearch?>
                                    </b></div>
</div>
<br>
<div class="col-lg-12">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
  <td align="right">
  <strong>Date :</strong> ___ /___ /_________
  </td>
  </tr>
  </table>
  
</div>
</div>



<div class="attexl" id="ReportTable1" style="">
                            <?php
				//print_r($emp_leaves_list);
 //exit;			
if(!empty($emp_leaves_list)){
	 $i=1;
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
                            
                            <div class="table-scrollable" id="reporttab">
                             <table  cellpadding="0" cellspacing="0" style="font-size:11px" width="100%" align="center" class="attexl">

<thead>
 <tr bgcolor="#9ed9ed" >
 <th>Sr.No</th>
 <th >App.Id</th>
<th>App. Date</th>
<th>Emp.Id</th>
<th>Name</th>
<th>L.Type</th>
<th>From Date</th>
<th>To Date</th>
<th>NO. Days</th>									
<th>Reason</th>
<th>Reporting1 </th> 
<th>Reporting1 Date</th>                                    
<th>Reporting1 Remark</th>
<th>Reporting2</th> 
<th>Reporting2 Date</th>                                    
<th>Reporting2 Remark</th>
<th>Reporting3</th> 
<th>Reporting3 Date</th>                                    
<th>Reporting3 Remark</th>
  </tr>
  </thead>
<tbody>
 <?php 
 $ci =&get_instance();
   $ci->load->model('admin_model');
 //print_r($emp_leaves_list);exit;
 //echo $sbtn;
  foreach($emp_leaves_list as $key=>$val){
$emp1 = $ci->admin_model->getEmployeeById($emp_leaves_list[$key]['emp1_reporting_person']); 
$emp2 = $ci->admin_model->getEmployeeById($emp_leaves_list[$key]['emp2_reporting_person']); 
$emp3 = $ci->admin_model->getEmployeeById($emp_leaves_list[$key]['emp3_reporting_person']); 
  ?>
 <tr> 
   <td ><?=$i++;?></td>
   <td ><?=$emp_leaves_list[$key]['lid']?></td>
   <td><?=date('d-m-y',strtotime($emp_leaves_list[$key]['applied_on_date']))?></td>
<td ><?=$emp_leaves_list[$key]['emp_id']?></td>
<td ><?php if($emp_leaves_list[$key]['gender']=='male'){echo 'Mr.';}else if($emp_leaves_list[$key]['gender']=='female'){ echo 'Mrs.';} ?><?=$emp_leaves_list[$key]['fname']." ".$emp_leaves_list[$key]['lname']?><br/><?php echo $emp_leaves_list[$key]['college_code']; ?><br/><?php echo $emp_leaves_list[$key]['department_name']; ?></td>
<td ><?php 

  if($emp_leaves_list[$key]['leave_type'] == 'lwp' || $emp_leaves_list[$key]['leave_type'] == 'LWP'){
                                            //echo 'LWP';
                                        echo $l = $this->leave_model->getLeaveTypeById1('9');
                                    }else if($emp_leaves_list[$key]['leave_type'] == 'official'){
                                            //echo 'LWP';
                                        echo 'OD';
                                    }else{
                                          $lt = $this->leave_model->getLeaveTypeById($emp_leaves_list[$key]['leave_type']);
                                   if($lt == 'VL'){
                                  $cnt =  $this->leave_model->get_vid_emp_allocation($emp_leaves_list[$key]['leave_type']);
                                        
        echo $lt." - ".$cnt[0]['slot_type']." ";    
        }else{
            echo $lt;
        }

                                    }
?></td><!--Total Month Days-->
<td ><?=date('d-m-y',strtotime($emp_leaves_list[$key]['applied_from_date']))?></td><!--Working days of Month excluding Sundays and Holidays-->
<td ><?=date('d-m-y',strtotime($emp_leaves_list[$key]['applied_to_date']))?></td><!--Total Present Day without OD-->
<td ><?=$emp_leaves_list[$key]['no_days']?></td><!--Sundays Count-->
<td ><?=$emp_leaves_list[$key]['reason']?></td><!--Holidays-->
<td ><?php if($emp1[0]['gender']=='male'){echo 'Mr.';}else if($emp1[0]['gender']=='female'){ echo 'Mrs.';} ?><?=$emp1[0]['fname']." ".$emp1[0]['lname']?></td>
<td ><?=date('d-m-y',strtotime($emp_leaves_list[$key]['emp1_reporting_date']))?></td>
<td ><?=$emp_leaves_list[$key]['emp1_reporting_remark']?></td>
<td ><?php if($emp2[0]['gender']=='male'){echo 'Mr.';}else if($emp2[0]['gender']=='female'){ echo 'Mrs.';} ?><?=$emp2[0]['fname']." ".$emp2[0]['lname']?></td>
<?php if(!empty($emp_leaves_list[$key]['emp2_reporting_date'])){ ?>
<td ><?=date('d-m-y',strtotime($emp_leaves_list[$key]['emp2_reporting_date']))?></td>
<?php }else{ ?>
<td></td>
<?php } ?>
<td ><?=$emp_leaves_list[$key]['emp2_reporting_remark']?></td>
<<td ><?php if($emp3[0]['gender']=='male'){echo 'Mr.';}else if($emp3[0]['gender']=='female'){ echo 'Mrs.';} ?><?=$emp3[0]['fname']." ".$emp3[0]['lname']?></td>
<?php if(!empty($emp_leaves_list[$key]['emp3_reporting_date'])){ ?>
<td ><?=date('d-m-y',strtotime($emp_leaves_list[$key]['emp3_reporting_date']))?></td>
<?php }else{ ?>
<td></td>
<?php } ?>
<td ><?=$emp_leaves_list[$key]['emp3_reporting_remark']?></td>

</tr> 
  <?php 
 }
 ?>
 
  
</tbody>  
</table>
                              </div>
                            <?php } else{?>
                            <div>
                              <label style="color:red">
                                <b>No Leaves available.....
                                </b>
                              </label>
                            </div>
                            <?php } ?>
                          </div>