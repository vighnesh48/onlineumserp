<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<style>
.table{width:100%;}
table{max-width:100%;}
 

</style>
<?php// print_r($all_emp_leave);?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Leaves</a></li>
        <li class="active"><a href="#">Vacation Leaves Slot List</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Vacation Leaves Slot List</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                    <?php //if(in_array("Add", $my_privileges)) { ?>
                    <div class="pull-right col-xs-12 col-sm-auto"><a style="width: 100%;" class="btn btn-primary btn-labeled" href="<?=base_url($currentModule."/vl_slot")?>"><span class="btn-label icon fa fa-plus"></span>Add</a></div>                        
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
     echo date('Y')."-".date('y',strtotime('+1 Year'));
}
                ?></b></span></h4>
                </div>
                <div class="col-md-6">
                <div class="row">
                <label class="col-sm-6 text-right">Academic Year: </label>
               <div class="col-md-6" >
               <select class="form-control" onchange="search_emp_leves(this.value)" id="year" name="year">
<option value="">Select Year</option>
<option <?php if($yer=='2016-17') { echo 'selected'; } ?> value="2016-17">2016-17</option>
                                    <option <?php if($yer=='2017-18') { echo 'selected'; } ?> value="2017-18">2017-18</option>
                                    <option <?php if($yer=='2018-19') { echo 'selected'; } ?> value="2018-19">2018-19</option>
                           <option <?php if($yer=='2019-20') { echo 'selected'; } ?> value="2019-20">2019-20</option>
                           <option <?php if($yer=='2020-21') { echo 'selected'; } ?> value="2020-21">2020-21</option>
                             <option <?php if($yer=='2021-22') { echo 'selected'; } ?> value="2021-22">2021-22</option>
							  <option <?php if($yer=='2022-23') { echo 'selected'; } ?> value="2022-23">2022-23</option>
							   <option <?php if($yer=='2023-24') { echo 'selected'; } ?> value="2023-24">2023-24</option>
              </select>
</div>

                </div>
                </div>
                </div>
                </div>
                <div class="panel-body" style="overflow-y:scroll;height:700px;">
                    <div class="table-info">    
                    <?php //if(in_array("View", $my_privileges)) { ?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                    <th>#</th>
                                    <th>Emp.ID</th>
                                    <th>Name</th>
                                    <th>School</th>
                                    <th>Department</th>                                    
									<th>Year</th>
                                    <th>Vacation Type</th>
									<th>Slot</th>
									<th>From Date</th>
									<th>To Date</th>
									<th>#Days</th>
									
                                    <th>Action</th>
									
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php
							if(!empty($vl_slot_emp)){
                            $j=1;         
                           
                            for($i=0;$i<count($vl_slot_emp);$i++)
                            {                               
                         	?>
														
                            <tr>
							<td><?=$j?></td> 
                                 
                                 <td><?=$vl_slot_emp[$i]['employee_id']?></td> 
                                <td><?php if($vl_slot_emp[$i]['gender']=='male'){echo 'Mr.';}else if($vl_slot_emp[$i]['gender']=='female'){ echo 'Mrs.';} ?><?=$vl_slot_emp[$i]['fname']." ".$vl_slot_emp[$i]['lname']?>
                                </td>
                                  <td><?=$vl_slot_emp[$i]['college_code']?></td>
                                <td><?=$vl_slot_emp[$i]['department_name']?></td>                                
                                <td><?=$vl_slot_emp[$i]['academic_year']?></td>            
                                <td><?=$vl_slot_emp[$i]['vacation_type']?></td>                                
                                <td><?=$vl_slot_emp[$i]['slot_type']?></td>                                
                                <td><?=date('d-m-Y',strtotime($vl_slot_emp[$i]['from_date']))?></td>                                
                                <td><?=date('d-m-Y',strtotime($vl_slot_emp[$i]['to_date']))?></td>  
                                  <td><?=$vl_slot_emp[$i]['no_days']?></td>                                
                                 <td><a href="<?=base_url($currentModule.'/update_vl_assign_emp/'.$vl_slot_emp[$i]['id'].'')?>" title="Edit"><i class="fa fa-edit"></i></a>
								  </td>
                            </tr>
                            <?php
                            $j++;
                            }}else{
								echo"<tr><td colspan='11'><label style='color:red'>Sorry No record.</label></td></tr>";
							}
                            ?>                            
                        </tbody>
                    </table>  
                    <div class="col-md-4"></div><div class="col-md-1"><button id="tapexport" class="btn-primary btn">PDF</button></div> <div class="col-md-2">  <button id="taexport" class="btn-primary btn">Excel</button></div>         
                   
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
var url  = "<?=base_url().strtolower($currentModule).'/export_vl_slot_list/exl/'?>"+yer;   
          //alert(url);
          window.location.href = url;
});
$('#tapexport').click(function(){
    var yer = $('#year').val();
var url  = "<?=base_url().strtolower($currentModule).'/export_vl_slot_list/pdf/'?>"+yer;   
          //alert(url);
          window.location.href = url;
});
  function search_emp_leves(yer){
       
          url= "<?php echo base_url().$currentModule; ?>/vl_slot_list/"+yer;
          window.location = url;
}
    
</script>