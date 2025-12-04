<style>
.table-info {height:900px;overflow-y:scroll;}
.table{width:100%;}
.view-btn{padding:0px;}
.view-btn li{padding: 3px 0;list-style:none;width:55px;text-align: center;color:#fff;background:#4bb1d0;xpadding: 5px 10px;margin:2px;}
.view-btn li a{color:#fff;font-weight:bold;}
</style>
<link rel="stylesheet" href="<?= base_url('assets') ?>/stylesheets/select2.css">
<script src="<?= base_url('assets/javascripts') ?>/select2.min.js"></script>
<?php // print_r($fac_list);?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Employee</a></li>
        <li class="active"><a href="#">Visiting Faculty List</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Visiting Faculty List</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
<?php //print_r($my_privileges);
                    if(in_array("Add", $my_privileges)) { ?>
                    <div class="pull-right col-xs-12 col-sm-auto"><a style="width: 100%;" class="btn btn-primary btn-labeled" href="<?= base_url($currentModule . "/add") ?>"><span class="btn-label icon fa fa-plus"></span>Add New Faculty</a></div>                        
                    <div class="visible-xs clearfix form-group-margin"></div>
<?php } ?>
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-sm-12">&nbsp;</div>
        </div>
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-heading" style="padding-top:5px;padding-bottom:5px;!important">
                        <span class="panel-title">
                              <div class="row">
                              <div class="col-md-10">
                                <ul id="emptab" class="nav nav-pills bs-tabdrop-example">
                                            <li class="active"><a href="#act" data-toggle="tab">Active</a></li>
                                            <li><a href="#inact" data-toggle="tab">Inactive</a></li>
                                            <li><a href="#reg" data-toggle="tab">Resign</a></li>
                               </ul></div>
							   <div class="col-md-2">
							      <!--<select  class="form-control" onchange="filter_tables(this.value);" name="staff_type" id="staff_type">
							      					   <option value="">Select All</option>
													<option  value="Teaching">Teaching</option>		
													<option  value="Non-Teaching">Non-Teaching</option>
													</select>-->
							   </div>
                            </div>
                       </span>
                    </div>
                    <div class="panel-body">
                     <div class="tab-content">
                    <div class="tab-pane active" id="act"> 
                    
                        <div class="table-info">    
                            <?php //if(in_array("View", $my_privileges)) { ?>
                            <table id="example" class="table table-bordered display">
                                <thead>
                                    <tr>
                                        <th data-orderable="false">#</th>
                                        <th data-orderable="false">FacultyID</th>
                                        <!--th data-orderable="false">Image</th-->
                                        <th data-orderable="false">Name</th>
                                        <th data-orderable="false">Dept</th>
                                        <th data-orderable="false">Email Id</th>
                                        <th data-orderable="false">Phone</th>   
										<th data-orderable="false">Status</th>   
                                        <th data-orderable="false">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="itemContainer">
                                    <?php
                                    $j = 1;
                                    if(!empty($fac_list)){
                                    for ($i = 0; $i < count($fac_list); $i++) {
										if($fac_list[$i]['emp_status']=='Y'){
										$f_type= substr($fac_list[$i]['emp_id'],0,1);
                                        ?>
                                        <?php
                                        if ($fac_list[$i]['ro_flag'] == 'on')
                                            $bg = "bgcolor='#e6eaf2'";
                                        else
                                            $bg = "";
                                        ?>								
                                        <tr <?= $bg ?> <?= $fac_list[$i]["status"] == "N" ? "style='background-color:#FBEFF2'" : "" ?>>
                                            <td><?= $j ?></td> 

                                            <td><?= $fac_list[$i]['emp_id'] ?></td> 
                                            <!--td>
                                                <?php
                                                if (!empty($fac_list[$i]['profile_photo'])) {
                                                    $profile = base_url() . "uploads/employee_profilephotos/" . $fac_list[$i]['profile_photo'];
                                                } else {
                                                    $profile = base_url() . "uploads/noprofile.png";
                                                }
                                                ?>
                                                <img src=" <?= $profile; ?> " alt="ProfileImage" height="80px"></td--> 
                                            <td><?= ucfirst($fac_list[$i]['lname']) . " " . ucfirst($fac_list[$i]['fname']); ?></td>                                                                
                                            <td style="width: 250px;">Department: <strong><?php
                                                        $res = $this->Admin_model->getDepartmentById($fac_list[$i]['department']);
                                                        // print_r($res);
                                                        echo $res[0]['department_name'];
                                                        ?></strong><br>
                                                Designation: <strong><?php
                                                        $res = $this->Admin_model->getDesignationById($fac_list[$i]['designation']);
                                                        // print_r($res);
                                                        echo $res[0]['designation_name'];
                                                        ?></strong>
                                            </td>                                
                                            <td> <?php
                                                /*$date1 = $fac_list[$i]['date_of_birth'];
                                                $date2 = date("Y-m-d");
                                                $diff = abs(strtotime($date2) - strtotime($date1));
                                                $years = floor($diff / (365 * 60 * 60 * 24));
                                                $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
                                                $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
                                                printf("%d years, %d months, %d days\n", $years, $months, $days);*/
                                                echo $fac_list[$i]['email_id'];
                                                ?></td>                                
                                            <td><?= $fac_list[$i]['mobile_no']; ?></td>                                
                           
                                            <td><?php if($fac_list[$i]['emp_status']=='Y'){
												  $empstatus = "Active";
												  $btnclass = "btn-success";
												}else{
												  $empstatus = "Inactive"; 
												  $btnclass = "btn-danger";
												 }?>
												<!--a  href="<?php echo base_url()."Faculty/deact_emp?id=".$fac_list[$i]['emp_id']."&status=".$fac_list[$i]['emp_status'].""?>"--><span class="btn <?=$btnclass?>"><?=$empstatus?> </span></a>
											</td>                                
                                                        
											<td>
												<ul class="view-btn">
													<li><a  href="<?php echo base_url()."Faculty/view_visiting_emp?id=".$fac_list[$i]['emp_id']."&status=".$fac_list[$i]['emp_status'].""?>"  title="View"><i class="fa fa-eye"></i> </a></li>
													 <?php $uid=$this->session->userdata('role_id');  if($uid == 1 || $uid == 11){ ?>
													<?php //print_r($my_privileges);
                    if(in_array("Edit", $my_privileges)) {  ?>
													<li > <a  target='_blank' href="<?php echo base_url()."Faculty/add?id=".$fac_list[$i]['emp_id']."&status=".$fac_list[$i]['emp_status']."&flag=".'1'.""?>"  title="Edit"><i class="fa fa-edit"></i> </a></li>
												<?php } if(in_array("Edit", $my_privileges)) {
												?>
                                                <li> <a  href="<?php echo base_url()."Faculty/deact_emp?p=".$this->uri->segment(3)."&id=".$fac_list[$i]['emp_id']."&status=".$fac_list[$i]['emp_status'].""?>"><i class="fa fa-trash-o" title="Change Status"></i></a></li>
												<?php } if(in_array("Edit", $my_privileges)) {
												?>
                                                 <li> <a  href="<?php echo base_url()."Faculty/deact_emp?p=".$this->uri->segment(3)."&id=".$fac_list[$i]['emp_id']."&status=R"?>"><i class="fa fa-fire" title="Resign"></i></a></li>
												<?php }?>
												</ul>
													 <?php }?>
											</td>
                                        </tr>
                                        <?php
                                        $j++;
                                    } }
                                    }else{
                                        echo "<tr><td colspan=9>";echo "No data found.";echo "</td></tr>";
                                    }
                                    ?>                            
                                </tbody>
                            </table>                    
                            <?php //}   ?>
                        </div>
                        </div>
                        
                        <div class="tab-pane" id="inact"> 
                    
                        <div class="table-info">    
                            <?php //if(in_array("View", $my_privileges)) { ?>
                            <table id="example" class="table table-bordered display">
                                <thead>
                                    <tr>
                                        <th data-orderable="false">#</th>
                                        <th data-orderable="false">FacultyID</th>
                                        <!--th data-orderable="false">Image</th-->
                                        <th data-orderable="false">Name</th>
                                        <th data-orderable="false">Dept</th>
                                        <th data-orderable="false">Email Id</th>
                                        <th data-orderable="false">Phone</th>   
										<th data-orderable="false">Status</th>   
                                        <th data-orderable="false">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="itemContainer">
                                    <?php
                                    $j = 1;
                                    if(!empty($fac_list)){
                                    for ($i = 0; $i < count($fac_list); $i++) {
										if($fac_list[$i]['emp_status']=='N'){
										$f_type= substr($fac_list[$i]['emp_id'],0,1);
                                        ?>
                                        <?php
                                        if ($fac_list[$i]['ro_flag'] == 'on')
                                            $bg = "bgcolor='#e6eaf2'";
                                        else
                                            $bg = "";
                                        ?>								
                                        <tr <?= $bg ?> <?= $fac_list[$i]["status"] == "N" ? "style='background-color:#FBEFF2'" : "" ?>>
                                            <td><?= $j ?></td> 

                                            <td><?= $fac_list[$i]['emp_id'] ?></td> 
                                            <!--td>
                                                <?php
                                                if (!empty($fac_list[$i]['profile_photo'])) {
                                                    $profile = base_url() . "uploads/employee_profilephotos/" . $fac_list[$i]['profile_photo'];
                                                } else {
                                                    $profile = base_url() . "uploads/noprofile.png";
                                                }
                                                ?>
                                                <img src=" <?= $profile; ?> " alt="ProfileImage" height="80px"></td--> 
                                            <td><?= ucfirst($fac_list[$i]['lname']) . " " . ucfirst($fac_list[$i]['fname']); ?></td>                                                                
                                            <td style="width: 250px;">Department: <strong><?php
                                                        $res = $this->Admin_model->getDepartmentById($fac_list[$i]['department']);
                                                        // print_r($res);
                                                        echo $res[0]['department_name'];
                                                        ?></strong><br>
                                                Designation: <strong><?php
                                                        $res = $this->Admin_model->getDesignationById($fac_list[$i]['designation']);
                                                        // print_r($res);
                                                        echo $res[0]['designation_name'];
                                                        ?></strong>
                                            </td>                                
                                            <td> <?php
                                                /*$date1 = $fac_list[$i]['date_of_birth'];
                                                $date2 = date("Y-m-d");
                                                $diff = abs(strtotime($date2) - strtotime($date1));
                                                $years = floor($diff / (365 * 60 * 60 * 24));
                                                $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
                                                $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
                                                printf("%d years, %d months, %d days\n", $years, $months, $days);*/
                                                echo $fac_list[$i]['email_id'];
                                                ?></td>                                
                                            <td><?= $fac_list[$i]['mobile_no']; ?></td>                                
                           
                                            <td><?php if($fac_list[$i]['emp_status']=='Y'){
												  $empstatus = "Active";
												  $btnclass = "btn-success";
												}else{
												  $empstatus = "Inactive"; 
												  $btnclass = "btn-danger";
												 }?>
												<!--a  href="<?php echo base_url()."Faculty/deact_emp?id=".$fac_list[$i]['emp_id']."&status=".$fac_list[$i]['emp_status'].""?>"--><span class="btn <?=$btnclass?>"><?=$empstatus?> </span></a>
											</td>                                
                                                        
											<td>
												<ul class="view-btn">
													<li><a  href="<?php echo base_url()."Faculty/view_visiting_emp?id=".$fac_list[$i]['emp_id']."&status=".$fac_list[$i]['emp_status'].""?>"  title="View"><i class="fa fa-eye"></i> </a></li>
													 <?php $uid=$this->session->userdata('role_id');  if($uid == 1 || $uid == 11){ ?>
													<?php //print_r($my_privileges);
                    if(in_array("Edit", $my_privileges)) { ?>
													<li > <a  href="<?php echo base_url()."Faculty/add?id=".$fac_list[$i]['emp_id']."&status=".$fac_list[$i]['emp_status']."&flag=".'1'.""?>"  title="Edit"><i class="fa fa-edit"></i> </a></li>
												<?php } ?>
												<?php if(in_array("Edit", $my_privileges)) {
												?>
                                                <li> <a  href="<?php echo base_url()."Faculty/deact_emp?p=".$this->uri->segment(3)."&id=".$fac_list[$i]['emp_id']."&status=".$fac_list[$i]['emp_status'].""?>"><i class="fa fa-trash-o" title="Change Status"></i></a></li>
												<?php } if(in_array("Edit", $my_privileges)) {
												?>
                                                 <li> <a  href="<?php echo base_url()."Faculty/deact_emp?p=".$this->uri->segment(3)."&id=".$fac_list[$i]['emp_id']."&status=R"?>"><i class="fa fa-fire" title="Resign"></i></a></li>
												 <?php } 
													 }
												?>
												</ul>
											</td>
                                        </tr>
                                        <?php
                                        $j++;
                                    } }
                                    }else{
                                        echo "<tr><td colspan=9>";echo "No data found.";echo "</td></tr>";
                                    }
                                    ?>                            
                                </tbody>
                            </table>                    
                            <?php //}   ?>
                        </div>
                        </div>
                        
                        <div class="tab-pane" id="reg"> 
                    
                        <div class="table-info">    
                            <?php //if(in_array("View", $my_privileges)) { ?>
                            <table id="example" class="table table-bordered display">
                                <thead>
                                    <tr>
                                        <th data-orderable="false">#</th>
                                        <th data-orderable="false">FacultyID</th>
                                        <!--th data-orderable="false">Image</th-->
                                        <th data-orderable="false">Name</th>
                                        <th data-orderable="false">Dept</th>
                                        <th data-orderable="false">Email Id</th>
                                        <th data-orderable="false">Phone</th>   
										<th data-orderable="false">Status</th>   
                                        <th data-orderable="false">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="itemContainer">
                                    <?php
                                    $j = 1;
                                    if(!empty($fac_list)){
                                    for ($i = 0; $i < count($fac_list); $i++) {
										if($fac_list[$i]['emp_resign']=='Y'){
										$f_type= substr($fac_list[$i]['emp_id'],0,1);
                                        ?>
                                        <?php
                                        if ($fac_list[$i]['ro_flag'] == 'on')
                                            $bg = "bgcolor='#e6eaf2'";
                                        else
                                            $bg = "";
                                        ?>								
                                        <tr <?= $bg ?> <?= $fac_list[$i]["status"] == "N" ? "style='background-color:#FBEFF2'" : "" ?>>
                                            <td><?= $j ?></td> 

                                            <td><?= $fac_list[$i]['emp_id'] ?></td> 
                                            <!--td>
                                                <?php
                                                if (!empty($fac_list[$i]['profile_photo'])) {
                                                    $profile = base_url() . "uploads/employee_profilephotos/" . $fac_list[$i]['profile_photo'];
                                                } else {
                                                    $profile = base_url() . "uploads/noprofile.png";
                                                }
                                                ?>
                                                <img src=" <?= $profile; ?> " alt="ProfileImage" height="80px"></td--> 
                                            <td><?= ucfirst($fac_list[$i]['lname']) . " " . ucfirst($fac_list[$i]['fname']); ?></td>                                                                
                                            <td style="width: 250px;">Department: <strong><?php
                                                        $res = $this->Admin_model->getDepartmentById($fac_list[$i]['department']);
                                                        // print_r($res);
                                                        echo $res[0]['department_name'];
                                                        ?></strong><br>
                                                Designation: <strong><?php
                                                        $res = $this->Admin_model->getDesignationById($fac_list[$i]['designation']);
                                                        // print_r($res);
                                                        echo $res[0]['designation_name'];
                                                        ?></strong>
                                            </td>                                

                                            <td> <?php
                                                /*$date1 = $fac_list[$i]['date_of_birth'];
                                                $date2 = date("Y-m-d");
                                                $diff = abs(strtotime($date2) - strtotime($date1));
                                                $years = floor($diff / (365 * 60 * 60 * 24));
                                                $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
                                                $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
                                                printf("%d years, %d months, %d days\n", $years, $months, $days);*/
                                                echo $fac_list[$i]['email_id'];
                                                ?></td>                                
                                            <td><?= $fac_list[$i]['mobile_no']; ?></td>                                
                           
                                            <td><?php if($fac_list[$i]['emp_status']=='Y'){
												  $empstatus = "Active";
												  $btnclass = "btn-success";
												}else{
												  $empstatus = "Inactive"; 
												  $btnclass = "btn-danger";
												 }?>
												<!--a  href="<?php echo base_url()."Faculty/deact_emp?id=".$fac_list[$i]['emp_id']."&status=".$fac_list[$i]['emp_status'].""?>"--><span class="btn <?=$btnclass?>"><?=$empstatus?> </span></a>
											</td>                                
                                                        
											<td>
												<ul class="view-btn">
													<li><a  href="<?php echo base_url()."Faculty/view_visiting_emp?id=".$fac_list[$i]['emp_id']."&status=".$fac_list[$i]['emp_status'].""?>"  title="View"><i class="fa fa-eye"></i> </a></li>
													 <?php $uid=$this->session->userdata('role_id');  if($uid == 1 || $uid == 11){ ?>
													<?php //print_r($my_privileges);
                    if(in_array("Edit", $my_privileges)) { ?>
													<li > <a  href="<?php echo base_url()."Faculty/add?id=".$fac_list[$i]['emp_id']."&status=".$fac_list[$i]['emp_status']."&flag=".'1'.""?>"  title="Edit"><i class="fa fa-edit"></i> </a></li>
												<?php } ?>
												<?php  if(in_array("Edit", $my_privileges)) {
												?>
                                                <li> <a  href="<?php echo base_url()."Faculty/deact_emp?p=".$this->uri->segment(3)."&id=".$fac_list[$i]['emp_id']."&status=".$fac_list[$i]['emp_status'].""?>"><i class="fa fa-trash-o" title="Change Status"></i></a></li>
												<?php } 
													 }
												?>
												</ul>
											</td>
                                        </tr>
                                        <?php
                                        $j++;
                                    }}
                                    }else{
                                        echo "<tr><td colspan=9>";echo "No data found.";echo "</td></tr>";
                                    }
                                    ?>                            
                                </tbody>
                            </table>                    
                            <?php //}   ?>
                        </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </div>
</div>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.4.2/js/buttons.html5.min.js"></script>
<script src="https:////cdn.datatables.net/buttons/1.4.2/js/buttons.print.min.js"></script>


<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.4.2/css/buttons.dataTables.min.css">

<script>
$(document).ready(function() {
    $('#example').DataTable( {
        dom: 'Bfrtip',
		"bPaginate": false,
        buttons: [

        ]
    } );
} );
</script>