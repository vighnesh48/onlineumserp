<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<style type="text/css">
    .table-info {height:700px;overflow-y:scroll;}
.table{width:100%;}
</style>
<?php// print_r($all_emp_leave);?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Employee</a></li>
        <li class="active"><a href="#">Employee Reporting List</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Employee Reporting list</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                    
                    <div class="pull-right col-xs-12 text-right">
                    <a style="margin-right: 10px;" class="btn btn-primary btn-labeled" href="<?=base_url($currentModule."/change_reporting")?>"><span class="btn-label icon fa fa-plus"></span>Change Reporting</a>
                   <?php // print_r($my_privileges);
                   if(in_array("Add", $my_privileges)) { ?>
                    <a  class="btn btn-primary btn-labeled" href="<?=base_url($currentModule."/add_employee_reporting")?>"><span class="btn-label icon fa fa-plus"></span>Add Reporting</a></div>                        
                               <?php } ?>           
                    <div class="visible-xs clearfix form-group-margin"></div>
                    
                    <?php //if(in_array("Search", $my_privileges)) { ?>
                
                    <?php //} ?>
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-sm-12">&nbsp;</div>
        </div>
        <div class="row ">
			<!-- tabs -->
        <div class="tabbable">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#one" data-toggle="tab">Route 1<br/>(OD/Leave/CL/Vacation)</a></li>
            <li><a href="#two" data-toggle="tab">Route 2<br/>(EL,ML)</a></li>
          
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="one">
			
			 <div class="col-sm-12">
                <div class="panel">
                
			<div class="panel-body">
                    <div class="table-info">    
                    <?php //if(in_array("View", $my_privileges)) { ?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                    <th>#</th>
                                    <th>Emp.ID</th>
                                    <th>School</th>
                                    <th>Department</th>
									<th>Route</th>
									<th>Reporting1</th>
<th>Reporting2</th>
<th>Reporting3</th>
<th>Reporting4</th>
                                    <th>Action</th>
									
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php
							if(!empty($emp_rep_details)){
                            $j=1;    
                            $ci =&get_instance();
   $ci->load->model('admin_model');
   
                            for($i=0;$i<count($emp_rep_details);$i++)
                            {
                                $rep_person1 =$this->Employee_model->get_emp_details($emp_rep_details[$i]['report_person1']);	
                                $rep_person2 =$this->Employee_model->get_emp_details($emp_rep_details[$i]['report_person2']);	
							    $rep_person3 =$this->Employee_model->get_emp_details($emp_rep_details[$i]['report_person3']);	
							    $rep_person4 =$this->Employee_model->get_emp_details($emp_rep_details[$i]['report_person4']);	
							
							$emp = $this->Employee_model->get_emp_details($emp_rep_details[$i]['emp_code']);	
							 $department =  $ci->admin_model->getDepartmentById($emp[0]['department']); 
								 $school =  $ci->admin_model->getSchoolById($emp[0]['emp_school']); 
								 	
								?>														
                            <tr>
							<td><?=$j?></td>                                  
                                <td><?=$emp_rep_details[$i]['emp_code']." - ".$emp_rep_details[$i]['fname']." ".$emp_rep_details[$i]['lname']?></td> 
                                <td><?=$school[0]['college_name']?></td>
                                 <td><?=$department[0]['department_name']?></td>
                                <td><?=$emp_rep_details[$i]['route'];?></td>            
                                <td><?=$rep_person1[0]['fname'];?> <?=$rep_person1[0]['lname'];?></td>
                                <td><?=$rep_person2[0]['fname'];?> <?=$rep_person2[0]['lname'];?></td>
								<td><?=$rep_person3[0]['fname'];?> <?=$rep_person3[0]['lname'];?></td>
								<td><?=$rep_person4[0]['fname'];?> <?=$rep_person4[0]['lname'];?></td>
                                								
                                <td>
 <?php if(in_array("Edit", $my_privileges)) { ?>
                                <a href="<?=base_url($currentModule.'/update_employee_reporting/'.$emp_rep_details[$i]['er_id'].'')?>" title="Edit"><i class="fa fa-edit"></i></a>
								  <?php } ?>
                                  <a href="#" class="btn btn-primary btn-xs emp_view" id="<?=$emp_rep_details[$i]['emp_code']."_1"?>" data-toggle="modal"  data-target="#myModal"><span class="glyphicon glyphicon-search"></span></a>
							   </td>
                            </tr>
                            <?php
                            $j++;
                            }}else{
								echo"<tr><td colspan='19'><label style='color:red'>Sorry No record of Employee's Assigned for leaves.</label></td></tr>";
							}
                            ?>                            
                        </tbody>
                    </table>                    
                    <?php //} ?>
                </div>
                </div>
			  </div>
                </div>	
						
			
			
			</div>
            <div class="tab-pane" id="two">
			
			 <div class="col-sm-12">
                <div class="panel">
                
			<div class="panel-body">
                    <div class="table-info">    
                    <?php //if(in_array("View", $my_privileges)) { ?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                    <th>#</th>
                                    <th>Emp.ID</th>
                                    <th>School</th>
                                    <th>Department</th>
									<th>Route</th>
									<th>Reporting1</th>
<th>Reporting2</th>
<th>Reporting3</th>
<th>Reporting4</th>
                                    <th>Action</th>
									
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php
							if(!empty($emp_rep_details1)){
                            $j=1;                            
                            for($i=0;$i<count($emp_rep_details1);$i++)
                            {
                                $rep_person1 =$this->Employee_model->get_emp_details($emp_rep_details1[$i]['report_person1']);	
                                $rep_person2 =$this->Employee_model->get_emp_details($emp_rep_details1[$i]['report_person2']);	
							    $rep_person3 =$this->Employee_model->get_emp_details($emp_rep_details1[$i]['report_person3']);	
							    $rep_person4 =$this->Employee_model->get_emp_details($emp_rep_details1[$i]['report_person4']);	
							    
							    	$emp = $this->Employee_model->get_emp_details($emp_rep_details1[$i]['emp_code']);	
							 $department =  $ci->admin_model->getDepartmentById($emp[0]['department']); 
								 $school =  $ci->admin_model->getSchoolById($emp[0]['emp_school']); 
								 	
														
								?>														
                            <tr>
							<td><?=$j?></td>                                  
                                <td><?=$emp_rep_details1[$i]['emp_code']." - ".$emp[0]['fname']." ".$emp[0]['lname']?></td> 
                                 <td><?=$school[0]['college_name']?></td>
                                 <td><?=$department[0]['department_name']?></td>
                                <td><?=$emp_rep_details1[$i]['route'];?></td>            
                                <td><?=$rep_person1[0]['fname'];?> <?=$rep_person1[0]['lname'];?></td>
                                <td><?=$rep_person2[0]['fname'];?> <?=$rep_person2[0]['lname'];?></td>
								<td><?=$rep_person3[0]['fname'];?> <?=$rep_person3[0]['lname'];?></td>
								<td><?=$rep_person4[0]['fname'];?> <?=$rep_person4[0]['lname'];?></td>
                                								
                                <td>
 <?php if(in_array("Edit", $my_privileges)) { ?>
                                <a href="<?=base_url($currentModule.'/update_employee_reporting/'.$emp_rep_details1[$i]['er_id'].'')?>" title="Edit"><i class="fa fa-edit"></i></a>
								  <?php } ?>
                                  <a href="#" class="btn btn-primary btn-xs emp_view" id="<?=$emp_rep_details1[$i]['emp_code']."_2"?>" data-toggle="modal"  data-target="#myModal"><span class="glyphicon glyphicon-search"></span></a>
							   </td>
                            </tr>
                            <?php
                            $j++;
                            }}else{
								echo"<tr><td colspan='19'><label style='color:red'>Sorry No record of Employee's Assigned for leaves.</label></td></tr>";
							}
                            ?>                            
                        </tbody>
                    </table>                    
                    <?php //} ?>
                </div>
                </div>
			  </div>
                </div>	
			
			</div>
            
        </div>
        <!-- /tabs -->
           
	 
              
        </div>
    </div>
</div>
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width:800px;">

    <!-- Modal content-->
    <div class="modal-content" >
       <div class="modal-header">
        <button type="button" class="btn btn-default pull-right" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="empname"></h4>
      </div>
      <div class="modal-body" >
	  <div class="row table-responsive">
        <table class="table table-bordered"  >
                        <thead>
                            <tr>
							 <th>Sr.No</th>
                                    <th>Emp.ID</th>
									<th>Reporting Person1</th>
									<th>Reporting Person2</th>
									<th>Reporting Person3</th>
									<th>Reporting Person4</th>
									<th>from </th>
                                    
									
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

    $("#search_me").select2({
      placeholder: "Enter Event name",
      allowClear: true
    });    
        $(".emp_view").on('click',function()
        {
            var eid = $(this).attr('id');   

            var url  = "<?=base_url().strtolower($currentModule).'/get_emp_history/'?>"+eid;	
         //   var data = {title: search_val};		
         //   var type="";
         //   var type_name="";
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
                    var sp = eid.split('_');
                   $("#empname").text(sp[0]);
                 // $("#empname").text(eid);
                        $("#emp_cnt").html(data);
                  
                },
                error: function(data)
                {
                    alert("Page Or Folder Not Created..!!");
                }
            });
        });
</script>