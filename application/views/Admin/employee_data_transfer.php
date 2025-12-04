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
        <li class="active"><a href="#">Employee Data Transfer</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Employee Data Transfer</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                    <?php  
                    if(in_array("Add", $my_privileges)) { ?>
                         <div class="col-sm-2 pull-right clearfix form-group-margin"><a  class="btn btn-primary btn-labeled" href="<?=base_url($currentModule."/employee_data_transfer_add")?>"><span class="btn-label icon fa fa-plus"></span>Add </a>
						 &nbsp;&nbsp;&nbsp;&nbsp;<a  class="btn btn-primary btn-labeled" href="<?=base_url($currentModule."/employee_multi_data_transfer_add")?>"><span class="btn-label icon fa fa-plus"></span>Multi-Add</a>
						 
						 </div>             
                    <div class="visible-xs clearfix form-group-margin"></div>
                    <?php } ?>
                    <?php //if(in_array("Search", $my_privileges)) { ?>
                
                    <?php //} ?>
                </div>
            </div>
        </div>
        	<?php
       if(isset($_SESSION['errors'])){ ?>
			 <script>
            var errors = <?php echo json_encode($_SESSION['errors']); ?>;
            alert(errors.replace(/<br\s*\/?>/gi, '\n')); // Replace <br> with newline
        </script>
        <?php unset($_SESSION['errors']);
       } 
        ?>
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
              <div class="panel-heading">
                      <div class="row">
					  <h4>Employee List</h4>
					  </div>
					  </div>
                <div class="panel-body">
                    <div class="table-info">    
                    <?php //if(in_array("View", $my_privileges)) { 
                    ?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                    <th>#</th>
                                    <th>Emp ID</th>
                                    <th>Name</th>
									<th>Old EMP ID</th>	
                                    <th>Department</th>
                                    <th>School</th>																
                                    <th>Joining Date</th>									
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php
							if(!empty($emplist)){
                            $j=1;            
                            
							
                            foreach($emplist as $val)
                            {
                             		?>
														
                            <tr>
							<td><?=$j?></td> 
                                 
                                <td><?=$val['emp_id']?></td>
 <td><?=$val['fname']." ".$val['lname']?></td>
 <td><?=$val['old_emp_id']?></td>        								
                                <td><?=$val['department_name']?></td>
                                <td><?=$val['college_name']?></td>                                  
                               
                                <td><?=date('d-m-Y',strtotime($val['joiningDate']))?></td>
                            </tr>
                            <?php
                            $j++;
                            }}else{
								echo"<tr><td colspan='7'><label style='color:red'>Sorry No records.</label></td></tr>";
							}
                            ?>                            
                        </tbody>
                    </table>                    
                    <?php// }
                    ?>
                </div>
                </div>
            </div>
            </div>    
        </div>
    </div>
</div>
