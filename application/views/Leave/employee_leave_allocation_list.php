<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<style>
.table{width:100%;}
table{max-width:100%;}
 .table-bordered > thead > tr > th{border:0px;text-align:center;font-size:13px;
 font-weight:600;
 }
.tooltip {
    position: relative;
   display: inline-block;    
    opacity:1 !important;
}

.tooltip .tooltiptext {
    visibility: hidden;
    
    overflow:hidden!important;
    color: #000;
    text-align: center;
    border-radius: 6px;
    padding: 5px 0;
    
    /* Position the tooltip */
     position: absolute;
    z-index: 1;
    top: -5px;
    left: 110%;
    width:450px;
}
.tooltip .tooltiptext .table tbody{
    overflow:hidden!important;
    font-size:12px;
    height:auto !important;
}
.tooltip .tooltiptext .table tbody td{
    background-color:#f0f0f0;
}

.tooltip .tooltiptext .table tbody td:nth-child(1){
    width:10% !important;
}
.tooltip .tooltiptext .table tbody td:nth-child(2){
    width:20% !important;
}
.tooltip .tooltiptext .table tbody td:nth-child(3){
    width:15% !important;
}
.tooltip .tooltiptext .table tbody td:nth-child(4){
    width:15% !important;
}
.tooltip:hover .tooltiptext {
    visibility: visible;
}
.lev-tab tr th{ border:1px solid #FFF !important;vertical-align:middle !important; }
</style>
<?php// print_r($all_emp_leave);?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Leaves</a></li>
        <li class="active"><a href="#">Employee Leaves List</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Employee leave list</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                    <?php //if(in_array("Add", $my_privileges)) { ?>
                     <div class="pull-right col-xs-12 col-sm-auto">
                     <?php $id=$this->session->userdata('role_id'); 
if($id == 1){ ?>
<a  class="btn btn-primary btn-labeled" href="<?=base_url($currentModule."/carry_forward_employee_leave")?>"><span class="btn-label icon fa fa-plus"></span>Carry Forward </a>&nbsp;&nbsp;
                     <a  class="btn btn-primary btn-labeled" href="<?=base_url($currentModule."/add_employee_leaves")?>"><span class="btn-label icon fa fa-plus"></span>Assign Leaves</a>&nbsp;&nbsp;
                     <a  class="btn btn-primary btn-labeled" href="<?=base_url($currentModule."/add_employee_leave_allocation")?>"><span class="btn-label icon fa fa-plus"></span>Add Leaves</a>
<?php } ?>
                     </div>  
                      <div class="visible-xs clearfix form-group-margin"></div>
                    <?php// } ?>
                    <?php //if(in_array("Search", $my_privileges)) { ?>
                
                    <?php //} ?>
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-sm-12">&nbsp;</div>
        </div>
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                <div class="panel-heading">
                     <div class="row">
                <div class="col-md-6" class="form-control">
                <h4>
                For the Academic Year of <span id="mon"><b><?php    
if(!empty($yer)){               
                    echo $yer;
}else{
     echo $this->config->item('current_year');
}
                ?></b></span></h4>
                </div>
                <div class="col-md-6">
                <div class="row">
                <label class="col-sm-6 text-right">Academic Year: </label>
               <div class="col-md-6" >
               <select class="form-control" onchange="search_emp_leves(this.value)" id="year" name="year">
<option value="">Select Year</option>
                          <option <?php if($yer=='2017-18') { echo 'selected'; } ?> value="2017-18">2017-18</option>
                                    <option <?php if($yer=='2018-19') { echo 'selected'; } ?> value="2018-19">2018-19</option>
    <option <?php if($yer=='2019-20') { echo 'selected'; } ?> value="2019-20">2019-20</option>
	<option <?php if($yer=='2020-21') { echo 'selected'; } ?> value="2020-21">2020-21</option>
  <option <?php if($yer=='2021-22') { echo 'selected'; } ?> value="2021-22">2021-22</option>
  <option <?php if($yer=='2022-23') { echo 'selected'; } ?> value="2022-23">2022-23</option> 
    <option <?php if($yer=='2023-24') { echo 'selected'; } ?> value="2023-24">2023-24</option> 
	<option <?php if($yer=='2024-25') { echo 'selected'; } ?> value="2024-25">2024-25</option> 
              </select>
</div>

                </div>
                </div>
                </div>
                </div>
                <div class="panel-body" style="overflow-x:scroll;height:700px;">
                    <div class="table-info">    
                    <?php //if(in_array("View", $my_privileges)) { ?>
                    <table class="table table-bordered lev-tab">
                        <thead>
                            <tr>  <th rowspan='2' >#</th>
                                    <th rowspan='2' >Emp.ID</th>
                                    <th rowspan='2' >Name</th>
                                    <th rowspan='2' >School</th>
                                    <th rowspan='2' >Department</th>
                                    <th rowspan='2' >Details</th>									
                                    <th  colspan='2'>CL</th>									
									<th  colspan='2'>EL</th>
									<th colspan='2'>ML</th>
									<th colspan='2'>VL</th>
									<th colspan='2'>SL</th>
									<th colspan='2'>C-Off</th>
                                    <th colspan='2'>Leave</th>
                                    <?php if($id == 1){ ?>
                                    <th rowspan='2' >Action</th>
                                    <?php } ?>									
                            </tr>
                            <tr>                                 
                                    <th>A</th><th>U</th>
									<th>A</th><th>U</th>
									<th>A</th><th>U</th>
									<th>A</th><th>U</th>
									<th>A</th><th>U</th>
									<th>A</th><th>U</th>
                                    <th>A</th><th>U</th>                                    
							</tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php  $vl_cnt =array();
							if(!empty($emp_leave_allocation)){
                            $j=1;         
                            $ci =&get_instance();
   $ci->load->model('admin_model');
                            for($i=0;$i<count($emp_leave_allocation);$i++)
                            {
                                //$vl."_".$emp_leave_allocation[$i]['employee_id'] = array();
                                $cl = $this->load->leave_model->get_emp_leaves($emp_leave_allocation[$i]['employee_id'],'CL',$yer);
                            $el = $this->load->leave_model->get_emp_leaves($emp_leave_allocation[$i]['employee_id'],'EL',$yer);
                           $ml = $this->load->leave_model->get_emp_leaves($emp_leave_allocation[$i]['employee_id'],'ML',$yer);
                           $vl = $this->load->leave_model->get_emp_leaves($emp_leave_allocation[$i]['employee_id'],'VL',$yer);
                           $sl = $this->load->leave_model->get_emp_leaves($emp_leave_allocation[$i]['employee_id'],'SL',$yer);
                           $leave = $this->load->leave_model->get_emp_leaves($emp_leave_allocation[$i]['employee_id'],'Leave',$yer);
                           //$coff = $this->load->leave_model->get_count_coff_leaves($emp_leave_allocation[$i]['employee_id']);
                           $coff = $this->load->leave_model->get_emp_leaves($emp_leave_allocation[$i]['employee_id'],'C-OFF',$yer);
                          	$emp = $ci->admin_model->getEmployeeById($emp_leave_allocation[$i]['employee_id']);	
							 $department =  $ci->admin_model->getDepartmentById($emp[0]['department']); 
								 $school =  $ci->admin_model->getSchoolById($emp[0]['emp_school']); 
                                //$emp_leave_allocation[$i]['employee_id'] = array();
$style="";	
	if($emp_leave_allocation[$i]["status"]=="N"){
		$style="style='background:#edb34c'";
	}
							?>
														
                            <tr <?php echo $style; ?>>
							<td><?=$j?></td> 
                                 
                                 <td><?=$emp_leave_allocation[$i]['employee_id']?></td> 
                                <td><?php if($emp[0]['gender']=='male'){echo 'Mr.';}else if($emp[0]['gender']=='female'){ echo 'Mrs.';} ?><?=$emp[0]['fname']." ".$emp[0]['lname']?>
                                </td>
                                  <td><?=$school[0]['college_code']?></td>
                                <td><?=$department[0]['department_name']?></td>
                                <td style="text-align: center;"><a class="tooltip"><i class="fa fa-info-circle fa-2x">
                               <span class="tooltiptext"><?php 
                                $lis = $this->load->leave_model->get_employee_leave_type($emp_leave_allocation[$i]['employee_id'],$emp_leave_allocation[$i]['academic_year']);  
 echo '  <table class="table table-bordered" >
    <thead>
      <tr>
        <th >Leave</th>
        <th >Total Allocated</th>
        <th >Used leaves</th>
        <th >Balance</th>
      </tr> </thead>';
    
     if(!empty($lis)){
    foreach($lis as $val){
	
		
     echo '<tr '.$style.'><td >';
if($val['leave_type']=='VL'){
                 // echo $val['vl_id'];
                    $vl_cnt[$emp_leave_allocation[$i]['employee_id']][] = $val['leaves_allocated'];
$vl_us_cnt[$emp_leave_allocation[$i]['employee_id']][] = $val['leave_used'];
            $cnt = $ci->leave_model->get_vacation_leave_list('',$val['vl_id']);
          //$emp_leave_allocation[$i]['employee_id'][] = $val['leaves_allocated'];
            echo $val['leave_type']." (".$cnt[0]['vacation_type'].") - ".$cnt[0]['slot_type']  ;
    }else{     
    echo $val['leave_type'];
}
     echo '</td>
        <td >'.$val['leaves_allocated'].'</td>
        <td >';
        if($val['leave_type']=='C-OFF'){
			$cff[$emp_leave_allocation[$i]['employee_id']][]= $val['leave_used'];
		}
        if(!empty($val['leave_used'])){ echo $val['leave_used']; }else{ echo '0'; }
        echo '</td>
        <td >';
        echo $val['leaves_allocated']-$val['leave_used'];
        echo '</td></tr>';
     } 
    }else{
         echo '<tr>
        <td>--</td>
        <td>0</td>
        <td>0</td>
        <td>0</td></tr>';
    }
        echo "</table>";
                             
                               ?></span></a></td>                                         
                                <td><?=$cl[0]['leaves_allocated'];?></td> 
                                <td><?=$cl[0]['leave_used'];?></td>                                 
                                <td><?=$el[0]['leaves_allocated'];?></td> 
                                <td><?=$el[0]['leave_used'];?></td>                               
                                <td><?=$ml[0]['leaves_allocated'];?></td> 
                                <td><?=$ml[0]['leave_used'];?></td>                                
                                <td><?php echo array_sum($vl_cnt[$emp_leave_allocation[$i]['employee_id']]);?></td>  
                                 <td><?php echo array_sum($vl_us_cnt[$emp_leave_allocation[$i]['employee_id']]);?></td>
                                 <td><?=$sl[0]['leaves_allocated'];?></td> 
                                 <td><?=$sl[0]['leave_used'];?></td>                                
                                <td><?=$coff[0]['leaves_allocated'];?></td>  	
                                <td><?php echo array_sum($cff[$emp_leave_allocation[$i]['employee_id']]);?></td> 								
                                   <td><?=$leave[0]['leaves_allocated'];?></td>     
                                   <td><?=$leave[0]['leave_used'];?></td>                                                
                              <?php if($id == 1){ ?>
                                <td><a href="<?=base_url($currentModule.'/update_employee_leave_allocation/'.$emp_leave_allocation[$i]['employee_id'].'/'.$yer.'')?>" title="Edit"><i class="fa fa-edit"></i></a>
								 <a href='<?=base_url($currentModule)."/"?><?=$emp_leave_allocation[$i]["status"]=="Y"?"emp_leave_disable/".$emp_leave_allocation[$i]["employee_id"]."/".$yer:"emp_leave_enable/".$emp_leave_allocation[$i]["employee_id"]?>'><i class='fa <?=$emp_leave_allocation[$i]["status"]=="Y"?"fa-ban":"fa-check"?>' title='<?=$emp_leave_allocation[$i]["status"]=="Y"?"emp_leave_Disable":"emp_leave_Enable"?>'></i></a>
                                </td>
                                <?php } ?>
                            </tr>
                            <?php
                            $j++;
                            }}else{
								echo"<tr><td colspan='19'><label style='color:red'>Sorry No record of Employee's Assigned for leaves.</label></td></tr>";
							}
                            ?>                            
                        </tbody>
                    </table>   
                   <div class="col-md-4"></div> <div class="col-md-1"><button id="taexportp" class="btn-primary btn">PDF</button></div><div class="col-md-2">  <button id="taexport" class="btn-primary btn">Excel</button></div>         
                  
                    <?php //} ?>
                </div>
                </div>
            </div>
            </div>    
        </div>
    </div>
</div>
<script>
$('#taexport').click(function(){
  var yer = $('#year').val();
var url  = "<?=base_url().strtolower($currentModule).'/export_emp_leave_allocate/Exl/'?>"+yer;   
          //alert(url);
          window.location.href = url;
}); 
$('#taexportp').click(function(){
  var yer = $('#year').val();
var url  = "<?=base_url().strtolower($currentModule).'/export_emp_leave_allocate/pdf/'?>"+yer;   
          //alert(url);
          window.location.href = url;
}); 
  function search_emp_leves(yer){
       
          url= "<?php echo base_url().$currentModule; ?>/employee_leave_allocation/"+yer;
          window.location = url;
}
   
</script>