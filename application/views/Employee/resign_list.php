<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>

<?php //print_r($my_privileges); die; ?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Employee</a></li>
        <li class="active"><a href="#">Resign List</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Employee Resign List</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                  <?php //print_r($my_privileges);
                    if(in_array("Add", $my_privileges)) { ?>
                    <div class="pull-right col-xs-12 col-sm-auto"><a style="width: 100%;" class="btn btn-primary btn-labeled" href="<?=base_url($currentModule."/add_resign")?>"><span class="btn-label icon fa fa-plus"></span>Add Resign</a></div>                        
                    <?php } ?>
					
					<div class="pull-right col-xs-12 col-sm-auto"><a style="width: 100%;" class="btn btn-primary btn-labeled" href="<?=base_url("Admin/employee_multi_resign")?>"><span class="btn-label icon fa fa-plus"></span>Multi Resign</a></div>

							<?php if (isset($_SESSION['status'])){  ?>        
							<script type="text/javascript">
							var status = '<?php echo $_SESSION['status']; ?>';
							alert(status);
							<?php unset($_SESSION['status']); ?>
							</script>
							<?php } ?>

                    <div class="visible-xs clearfix form-group-margin"></div>
                   
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
                        <span class="panel-title">#</span>
                        <div class="holder"></div>
                </div>
                <div class="panel-body" style="height:700px;overflow-y:scroll;">
			
                    <div class="table-info" >    

                    <table class="table table-bordered table-stripped">
                        <thead>
                            <tr>
                                    <th>#</th>
                                    <th width="7%">Emp ID</th>
                                    <th width="25%">Emp Name</th>
                                    <th width="7%">School</th>
                                    <th width="15%">Dept.</th>
                                    <th width="12%">Design.</th>
                                    <th width="10%">Resign On</th>
                                    <th width="30%">Reason</th>
                                    
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                              <?php
                              $i=1;
                              if(isset($resign_data)){
                                  foreach($resign_data as $row){
                                echo '<tr>
                                <td>'.$i.'</td>
                                 <td>'.$row['emp_id'].'</td>
                                  <td>'.strtoupper($row['fname'].' '.$row['mname'].' '.$row['lname']).'</td>
                                   <td>'.$row['college_code'].'</td>
                                   <td>'.$row['department_name'].'</td>
                                    <td>'.$row['designation_name'].'</td>
                                     <td>'.$row['resign_date1'].'</td>
                                    <td>'.$row['reason'].'</td></tr> ';
                                $i++;
                                
                            }
                                 
                              }
                              else{
                                  echo '<tr><td colspan="8">No Records</td></tr>';  
                                  
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
<script>    
    $(document).ready(function(){
		
		
		
		
	});
	
	
</script>