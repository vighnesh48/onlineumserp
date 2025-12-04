<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<?php// print_r($all_emp_leave);
?>
<style type="text/css">
    .table-info {height:700px;overflow-y:scroll;}
.table{width:100%;}
</style>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Employees</a></li>
        <li class="active"><a href="#">Shift Timing List</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Shift Timing list</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                    <?php //print_r($my_privileges);
                    if(in_array("Add", $my_privileges)) { ?>
                               <div class="col-sm-2 pull-right clearfix form-group-margin"><a  class="btn btn-primary btn-labeled" href="<?=base_url($currentModule."/emp_shift_time_update")?>"><span class="btn-label icon fa fa-plus"></span>Add </a></div>
                    <div class="visible-xs clearfix form-group-margin"></div>
                    <?php } ?>
                    <?php //if(in_array("Search", $my_privileges)) { ?>
                
                    <?php //} ?>
                </div>
            </div>
        </div>
      
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
               <div class="panel-heading" style="padding-top:5px;padding-bottom:5px;!important">
                        <span class="panel-title">
                              <div class="row">
                                <ul class="nav nav-pills bs-tabdrop-example">
                                            <li class="active"><a href="#act" data-toggle="tab">Current Timing</a></li>
                                            <li><a href="#inact" data-toggle="tab">Planned Timing</a></li>
                                            
                               </ul>
                            </div>
                       </span>
                    </div>
                <div class="panel-body table-info">
                   <div class="tab-content ">
                               
                            <div class="tab-pane active" id="act">   
                              <table class="table table-bordered">
                        <thead>
                            <tr>
                                    <th>#</th>
                                    <th>Emp.ID</th>
<th>Name</th>
                                    <th>Department</th>
                                    <th>School</th>		
                                         <th>Shiftd</th>    							
									<th>Intime</th>
									<th>Outtime</th>
								
                                    <th>Action</th>
									
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php
							if(!empty($emplisty)){
                            $j=1;            
                            
							//$ci =&get_instance();
  // $ci->load->model('admin_model');
                            foreach($emplisty as $emp)
                            {
                              //$department =  $ci->admin_model->getDepartmentById($emplisty[$i]['department']); 
								// $school =  $ci->admin_model->getSchoolById($emplisty[$i]['emp_school']); 
								//  $shift =  $ci->admin_model->getshifttime($emplisty[$i]['shift']); 
							?>
														
                            <tr>
							<td><?=$j?></td> 
                                 <?php if($emp['gender'] == 'male'){ $m = 'Mr.'; }elseif($emp['gender'] == 'female'){ $m='Mrs.'; } ?>
                                <td><?=$emp['emp_id']?></td> 
                                <td><?=$m." ".$emp['fname']." ".$emp['lname']?></td>
                                <td><?=$emp['department_name']?></td>
                                <td><?=$emp['college_name']?></td>
                                  <td><?=$emp['shift_id'];?></td>                              
                                <td><?=date('H:i',strtotime($emp['in_time']));?></td>                                
                                <td><?=date('H:i',strtotime($emp['out_time']));?></td>                                
							
                                <td>
 <?php if(in_array("Edit", $my_privileges)) { ?>
                                <a href="<?=base_url($currentModule.'/employee_shifttime_update/'.$emp['emp_shift_id'].'')?>" title="Edit"><i class="fa fa-edit"></i></a>
								<?php } ?>
                                 <a href="#" class=" emp_view" id="<?=$emp['emp_id']?>" data-toggle="modal"  data-target="#myModal"><i class="fa fa-eye"></i></a>
                                </td>
                            </tr>
                            <?php
                            $j++;
                            }}else{
								echo"<tr><td colspan='19'><label style='color:red'>Sorry No records.</label></td></tr>";
							}
                            ?>                            
                        </tbody>
                    </table>                    
                   </div>
                              <div class="tab-pane" id="inact">    
  <table class="table table-bordered">
                        <thead>
                            <tr>
                                    <th>#</th>
                                    <th>Emp.ID</th>
<th>Name</th>
                                    <th>Department</th>
                                    <th>School</th>                                 
                                    <th>Intime</th>
                                    <th>Outtime</th>
<th>Active From</th>                                    
                                    <th>Action</th>
                                    
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php
                            if(!empty($emplistn)){
                            $j=1;            
                            $cnt = count($emplistn);
                           // $ci =&get_instance();
   //$ci->load->model('admin_model');
                            for($i=0;$i<$cnt;$i++)
                            {
                                    // $shift =  $ci->admin_model->getshifttime($emplistn[$i]['shift']); 
                            ?>
                                                        
                            <tr>
                            <td><?=$j?></td> 
                                 <?php if($emplistn[$i]['gender'] == 'male'){ $m = 'Mr.'; }elseif($emplistn[$i]['gender'] == 'female'){ $m='Mrs.'; } ?>
                                <td><?=$emplistn[$i]['emp_id']?></td> 
                                <td><?=$m." ".$emplistn[$i]['fname']." ".$emplistn[$i]['lname']?></td>
                                <td><?=$emplistn[$i]['department_name']?></td>
                                <td><?=$emplistn[$i]['college_code']?></td>
                                                           
                                <td><?=date('H:i',strtotime($emplistn[$i]['in_time']));?></td>                                
                                <td><?=date('H:i',strtotime($emplistn[$i]['out_time']));?></td>                                
                            <td><?=date('d-m-Y',strtotime($emplistn[$i]['active_from']));?></td>
                                <td>
 <?php if(in_array("Delete", $my_privileges)) { ?>
                                <a href="<?=base_url($currentModule.'/emp_shift_time_del/'.$emplistn[$i]['emp_shift_id'].'')?>" title="Edit"><i class="fa fa-trash-o"></i></a>
                                 <?php } ?>
                                 </td>
                            </tr>
                            <?php
                            $j++;
                            }}else{
                                echo"<tr><td colspan='19'><label style='color:red'>Sorry No records.</label></td></tr>";
                            }
                            ?>                            
                        </tbody>
                    </table>                    
</div>
                              </div>
                </div>
                </div>
            </div>
            </div>    
        </div>
    
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width:60%;">

    <!-- Modal content-->
    <div class="modal-content" >
       <div class="modal-header">
        <button type="button" class="btn btn-default pull-right" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" >Emp Id: <strong><span id="empid"></span></strong> 
        </h4>
      </div>
      <div class="modal-body" >
      <div class="row table-responsive">
        <table class="table table-bordered"  >
                        <thead>
                            <tr>
                             <th>#</th>
                                    <th>Intime</th>
                                    
                                    <th>Out time</th>
                                    <th>Active From</th> 
<th>Shift </th> <th>Duration</th>                               
                                    <th>Status</th>
                                    
                            </tr>
                        </thead>
                        <tbody id="emp_cnt">
                        
                        </tbody>
                        </table>
                        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
    </div>
    </div>
<script>
   $(".emp_view").on('click',function()
        {
            var eid = $(this).attr('id'); 
            //alert(eid);
             var url  = "<?=base_url().strtolower($currentModule).'/get_emp_shift_history/'?>"+eid; 
        
            $.ajax
            ({
                type: "POST",
                url: url,
               // data: data,
                dataType: "html",
                cache: false,
                crossDomain: true,
                success: function(data)
                {  
                $("#empid").text(eid);
                 
                        $("#emp_cnt").html(data);
                  
                },
                error: function(data)
                {
                    alert("Page Or Folder Not Created..!!");
                }
            });
        });
</script>