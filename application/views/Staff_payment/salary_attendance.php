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
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Staff Payment</a></li>
        <li class="active"><a href="#">Salary Attendance</a></li>
    </ul>
    <div class="page-header">     
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Salary Attendance</h1>
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
                              <div class="panel-heading"><strong>Salary Attendance </strong></div>
                                <div class="panel-body">
               
                                <div class="panel-padding no-padding-vr">
                            <div class="form-group">
                              
                <div class="portlet-body form">
                <form id="form" name="form" action="<?=base_url($currentModule.'/salary_attendance')?>" method="POST" enctype="multipart/form-data">
                <div class="form-body">
                <div class="col-md-6">
               
 <div class="form-group">
                <label class="col-md-4">Select Month:<?=$astrik?></label>
                                             <div class="col-md-8" >
                                  <input id="dob-datepicker" required class="form-control form-control-inline date-picker" name="attend_date" value="" placeholder="Enter Month" type="text">

                                             </div>
                                  </div>
                                  </div>
                                  <div class="col-md-6">
                   
    
                                  </div>                      
                               
                                   <div class="form-group">
                   <div class="col-md-5" ></div>
                                      <div class=" col-md-2">  
                                            <button type="submit" name="submit" class="btn btn-primary form-control" value="submit" >View</button>
                                        </div>                                       
                                    </div>
                            </div>
                                    </form>
                  </div>
                 
              <div class="attexl" id="ReportTable" >
<?php //print_r($emp_att);
if(!empty($emp_att)){
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0"  class="add-table">
  <tr>
    <td align="center"><b>Monthly Employee Present Days Report Of <?=$monthName?>  <?=$ysearch?> </b></td>
  </tr>
</table>
<br/>
<table  cellpadding="0" cellspacing="0" style="font-size:11px" width="80%" align="center" class="attexl">
<tbody>

 <tr bgcolor="#9ed9ed" >
 <td><strong>SRNo.</strong></td>
 <td><strong>Staff ID</strong></td>
 <td><strong>Name Of Employee</strong></td>
 <td><strong>Month Days</strong></td>
 <td><strong>Salary Days</strong></td>
  </tr>
 <?php 
 $i=1;
 foreach($emp_att as $key=>$val){ ?>
 <tr> 
   <td ><?=$i;?></td>
<td ><?=$emp_att[$key]['UserId']?></td>
<td ><?=$emp_att[$key]['ename']?></td>
<td ><?=$emp_att[$key]['month_days']?></td><!--Total Month Days-->
<td ><?=($emp_att[$key]['Total'])?></td>
</tr> 
  <?php 
  $i++;
 }
 ?>
</tbody>  
</table>
</div>
<?php } else{?>
<div><label style="color:red"><b>Attendance not submitted.....</b></label></div>
<?php } ?>

                                </div>
                            </div> 
                          </div>                          
                           
                        </div>
                    </div>
                </div>
           
<script type="text/javascript">
$(document).ready(function(){	
  $('#dob-datepicker').datepicker( {format: "yyyy-m",startView: "months",minViewMode: "months",autoclose:true});
 });
</script>