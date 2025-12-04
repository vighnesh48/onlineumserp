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
        <li class="active"><a href="#">Staff Payment</a></li>
        <li class="active"><a href="#">Mobile List</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Mobile list</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                    <?php //if(in_array("Add", $my_privileges)) { ?>
                               <div class="col-sm-2 pull-right clearfix form-group-margin"><a  class="btn btn-primary btn-labeled" href="<?=base_url($currentModule."/emp_mobile_master_add")?>"><span class="btn-label icon fa fa-plus"></span>Add </a></div>
                    <div class="visible-xs clearfix form-group-margin"></div>
                    <?php// } ?>
                    <?php //if(in_array("Search", $my_privileges)) { ?>
                
                    <?php //} ?>
                </div>
            </div>
        </div>
        
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
              <div class="panel-heading"> 

 <div class="row">
                <div class="col-md-6" class="form-control">
                <h4>
               </h4>
                </div>
                <div class="col-md-6">
                <div class="row">
                
               <div class="col-md-6" >
</div>
<div class="col-md-3">
</div>
                </div>
                </div>
                </div>

               </div>
                <div class="panel-body table-info">
                    <div class="">    
                   <span id="flash-messages" style="color:red;padding-left:110px;"><?php echo $this->session->flashdata('message1'); ?></span>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                    <th>#</th>
                                    <th>Emp.ID</th>
                                    <th>Name</th>
                                    <th>Department</th>
                                    <th>School</th>									
									<th>Mobile No</th>
									<th>Limit</th>									
                                    <th>Action</th>
									
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php
							if(!empty($mobile_list)){
                            $j=1;            
                            
							$ci =&get_instance();
   $ci->load->model('admin_model');
                            for($i=0;$i<count($mobile_list);$i++)
                            {
                              $department =  $ci->admin_model->getDepartmentById($mobile_list[$i]['department']); 
								 $school =  $ci->admin_model->getSchoolById($mobile_list[$i]['emp_school']); 
								  $shift =  $ci->admin_model->getshifttime($mobile_list[$i]['shift']); 
							?>
														
                            <tr>
							<td><?=$j?></td> 
                                 <?php if($mobile_list[$i]['gender'] == 'male'){ $m = 'Mr.'; }elseif($mobile_list[$i]['gender'] == 'female'){ $m='Mrs.'; } ?>
                                <td><?=$mobile_list[$i]['emp_id']?></td> 
                               <td><?=$m." ".$mobile_list[$i]['fname']." ".$mobile_list[$i]['lname']?></td>
                                <td><?=$department[0]['department_name']?></td>
                                <td><?=$school[0]['college_code']?></td>
                                                           
                                <td><?=$mobile_list[$i]['mobile'];?></td>                                
                                <td><?=$mobile_list[$i]['mobile_limit'];?></td>                                
							
                                <td><a href="<?=base_url($currentModule.'/employee_mobile_master_update/'.$mobile_list[$i]['mob_id'].'')?>" title="Edit"><i class="fa fa-edit"></i></a>
								<a href="<?=base_url($currentModule.'/employee_mobile_master_delete/'.$mobile_list[$i]['mob_id'].'')?>" title="Delete"><i class="fa fa-trash-o"></i></a>
								</td>
                            </tr>
                            <?php
                            $j++;
                            }}else{
								echo"<tr><td colspan='19'><label style='color:red'>Sorry No record Found.</label></td></tr>";
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
