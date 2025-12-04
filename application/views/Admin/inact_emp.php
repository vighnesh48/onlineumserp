<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>

<style>
    .pagination {
        float: right;
        line-height: 0;
        margin: 0 0 17px;
        white-space: normal;
    }

    .dataTables_info {
        line-height: 40px;
    }

    .table {
        width: 100%;
    }

    .view-btn {
        padding: 0px;
    }

    .view-btn li {
        padding: 3px 0;
        list-style: none;
        width: 55px;
        text-align: center;
        color: #fff;
        background: #4bb1d0;
        padding: 5px 10px;
        margin: 2px;
    }

    .view-btn li a {
        color: #fff;
        font-weight: bold;
    }

    .pagination-container {
    padding-right: 20px;
}

.pagination-container h4 {
    margin: 0;
}

.pagination-container a {
    display: inline-block;
    padding: 2px 5px;
    margin-right: 3px;
    margin-left: 3px;
    border: 1px solid #ccc;
    border-radius: 3px;
    text-decoration: none;
    color: #333;
    background-color: #f5f5f5;
}
.pagination-container a:hover {
    background-color: #e5e5e5;
}

.pagination-container .active {
    background-color: #337ab7;
    color: #fff;
    border-color: #337ab7;
}

</style>

<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li class="active"><a href="#">Employee</a></li>
        <li class="active"><a href="#">Inactive Employee List</a></li>
    </ul>

    <div class="page-header">
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Inactive Employee List</h1>
        </div>
        <div class="row ">
            <div class="col-sm-12">&nbsp;</div>
        </div>
        <div class="row ">
            <div class="panel">
                <div class="panel-heading" style="padding-top:5px;padding-bottom:5px;!important">
                    <span class="panel-title">
                        <div class="row">
                            <div class="col-md-10">
                                <ul id="emptab" class="nav nav-pills bs-tabdrop-example">
                                <li ><a href="<?=base_url('admin/employee_list')?>" >Active</a></li>
                                <li class="active"><a href="<?php base_url('admin/employee_listInact')?>" >Inactive</a></li>
                                <!-- <li class="active"><a href="#inact" >Inactive</a></li> -->

                                <li><a href="<?=base_url('admin/employee_listReg')?>" >Resign</a></li>
                                </ul>
                            </div>
                            <div class="col-md-2">
                                <!-- <select class="form-control" onchange="filter_tables(this.value);" name="staff_type" id="staff_type">
                                    <option value="">Select All</option>
                                    <option value="Teaching">Teaching</option>
                                    <option value="Non-Teaching">Non-Teaching</option>
                                </select> -->
                            </div>
                        </div>
                    </span>
                </div>
                <div class="panel-body" style="height:900px;overflow-y:scroll;">

                    <div class="tab-content">

                            <div class="tab-pane active" id="inact">
                            <form name="search_form" id="search_form" class="form" action="<?= base_url('admin/employee_listInact') ?>" method="get">
                                <div class="row p-20">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="department">Department</label>
                                            <select name="department" id="department" class="form-control">
                                                <option value="" selected >Select Department</option>
                                                <?php foreach ($departments as $dept) : ?>
                                                    <option value="<?= $dept['department_id'] ?>" <?= ($this->input->get('department') == $dept['department_id']) ? 'selected' : '' ?>>
                                                        <?= $dept['department_name'] ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>

                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="designation">Designation</label>
                                            <select name="designation" id="designation" class="form-control">
                                                <option value="" selected >Select Designation</option>
                                                <?php foreach ($designations as $desig) : ?>
                                                    <option value="<?= $desig['designation_id'] ?>" <?= ($this->input->get('designation') == $desig['designation_id']) ? 'selected' : '' ?>>
                                                        <?= $desig['designation_name'] ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                            <label for="or-label" class="text-center">OR</label>

                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label for="staff_type">Staff Type</label>
                                            <select name="staff_type" id="staff_type" class="form-control">
                                                <option value="" selected>Select Staff Type</option>
                                                <?php foreach ($staff_types as $stf) : ?>
                                                    <option value="<?= $stf['emp_cat_id'] ?>" <?= ($this->input->get('staff_type') == $stf['emp_cat_id']) ? 'selected' : '' ?>>
                                                        <?= $stf['emp_cat_name'] ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                            <label for="or-label" class="text-center">OR</label>
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label for="search">Search Employee</label>
                                            <input type="text" name="search" id="search" class="form-control" style="width: 150px;" placeholder="Search Employee" value="<?php // $this->input->get('search') ?>">
                                            <label for="or-label" class="text-center">OR</label>
                                        </div> 
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label for="form_name" class="mr-2"></label><br>
                                            <button type="submit" class="login-25 text-white btn-sm mr-5 text-center">Search</button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                                <form id="per-page-form" action="<?= base_url('admin/employee_listInact'); ?>" method="post" style="padding-bottom: 50px;">
                                <div class="pagination-container">
                                    <div class="col-sm-3">
                                        <div class="form-group d-flex align-items-center">
                                            <label for="per-page" style="margin-right: 10px;">Per page:</label>
                                            <select id="per-page" name="per_page" class="form-control" style="width: 90px;" onchange="changePerPage(this)">
                                                <option value="" disabled selected>Select</option>
                                                <option value="10" <?= ($this->config->item('per_page') == 10) ? 'selected' : '' ?>>10</option>
                                                <option value="25" <?= ($this->config->item('per_page') == 25) ? 'selected' : '' ?>>25</option>
                                                <option value="50" <?= ($this->config->item('per_page') == 50) ? 'selected' : '' ?>>50</option>
                                                <option value="-1" <?= ($this->config->item('per_page') == -1) ? 'selected' : '' ?>>All</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <br>

                            <div class="col-sm-12">
                                <div class="table-info">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Emp.Id</th>
                                                <th>Photo</th>
                                                <th>Name</th>
                                                <th>Dept/Designation</th>
                                                <th>Hiring type</th>
                                                <th>At Work</th>
                                                <th>Phone</th>
                                             
                                                <?php // if($uid == 1){ ?>
                                                <th>Status</th>
                                                
                                                <?php // }?>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="itemContainerin">
                                            <?php
                                            $j=1;
                                            $incnt = count($emp_list_inact);
                                            for($i=0;$i<$incnt;$i++)
                                            {
                                            ?>
                                            <?php if($emp_list_inact[$i]['ro_flag']=='on') $bg="bgcolor='#e6eaf2'";
                                                else $bg="";?>
                                            <tr id="<?php echo $emp_list_inact[$i]['staff_type']; ?>" <?=$bg?> <?=$emp_list_inact[$i]["status"]=="N"?"style='background-color:#FBEFF2'":""?>>
                                                <td><?=$j?></td>

                                                <td><?=$emp_list_inact[$i]['emp_id']?></td>
                                                <td>
                                                <?php if(!empty($emp_list_inact[$i]['profile_pic'])){
                            $bucket_key = 'uploads/employee_profilephotos/'.$emp_list_inact[$i]['profile_pic'];
                            $profile = $this->awssdk->getImageData($bucket_key);                      
                            //$profile=base_url()."uploads/employee_profilephotos/".$emp_list_inact[$i]['profile_pic'];
                        }else{
                    $profile=base_url()."uploads/noprofile.png";}?>
                                                <img src=" <?=$profile;?> " alt="ProfileImage" height="80px"></td> 
                                                   
                                                    <td><?=ucfirst($emp_list_inact[$i]['fname'])." ".ucfirst($emp_list_inact[$i]['mname'])." ".ucfirst($emp_list_inact[$i]['lname']);
                                                 echo "<br/>";echo "<br/>"; echo "<b>DOB:</b>".date('d-m-Y',strtotime($emp_list_inact[$i]['date_of_birth'])); ?></td>                                                                
                                                   <td><p>Dept.: <strong><?=$emp_list_inact[$i]['department_name']?></strong></p>
                                                          <p>Desig.: <strong><?=$emp_list_inact[$i]['designation_name']?></strong></p>
                                                </td>
                                                <td><?=$emp_list_inact[$i]['hiring_type']?>
                                                </td>
                                                <td> <?php 
                                                  echo '<b>'.date('d-m-Y',strtotime($emp_list_inact[$i]['joiningDate'])).'</b>';
                                                echo "<br/>";
                                                            $date1 = $emp_list_inact[$i]['joiningDate'];
                                                            $date2 = date("Y-m-d");
                                                            $diff = abs(strtotime($date2) - strtotime($date1));
                                                            $years = floor($diff / (365*60*60*24));
                                                            $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                                                            $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
                                                            printf("%d-Years<br> %d-Months<br> %d-Days\n", $years, $months, $days);
                                                            
                                                            
                                                      ?></td>
                                                <td><?=$emp_list_inact[$i]['mobileNumber'];?></td>
                                                <?php // if($uid == 1){ ?>
                                                <td><?php if($emp_list_inact[$i]['emp_status']=='Y'){?>
                                                    <span class="btn btn-success"> active </span>
                                                    <?php }else{?>
                                                    <span class="btn btn-danger"> Inactive </span>
                                                    <?php }?></td>
                                                <?php // }?>
                                                <td>
                                                    <ul class="view-btn">
                                                        <li><a  href="<?php echo base_url()."Admin/view_emp?id=".$emp_list_inact[$i]['emp_id']."&status=".$emp_list_inact[$i]['emp_status'].""?>"  title="View"><i class="fa fa-eye"></i> </a></li>
                                                        <?php $uid=$this->session->userdata('role_id');  if($uid == 1 || $uid == 11){ ?>
                                                        <li > <a  href="<?php echo base_url()."Admin/create_employee?p=".$this->uri->segment(3)."&id=".$emp_list_inact[$i]['emp_id']."&status=".$emp_list_inact[$i]['emp_status']."&flag=".'1'.""?>"  title="Edit"><i class="fa fa-edit"></i> </a></li>
                                                        <li> <a  href="<?php echo base_url()."Admin/deact_emp?p=".$this->uri->segment(3)."&id=".$emp_list_inact[$i]['emp_id']."&status=".$emp_list_inact[$i]['emp_status'].""?>"><i class="fa fa-trash-o" title="Change Status"></i></a></li>
                                                        <?php } ?>
                                                    </ul>
                                                </td>
                                            </tr>
                                            <?php
                                            $j++;
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                    <div class="pagination-container">
                                    <div class="pull-right">
                                        <h4><?php echo $links; ?></h4>
                                    </div>
                                    </div>

                                    <div class="text-center">

                                        <a href="<?php echo base_url('admin/export_employees_inact_to_excel') ?>?<?= http_build_query($_GET) ?>" class="btn btn-primary">Export to Excel</a>
                                   </div>

                                    <!-- <button onclick="exportToExcel()">Export to Excel</button> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<script>
    function changePerPage(select) {
        var perPage = select.value;
        document.getElementById("per-page-form").submit();
    }
</script>


<script >
    
function filter_tables(s){	
    console.log("Dropdown value changed to: " + s);
	
	 var target = $("ul#emptab li.active a").attr('href');
    
    var tableBody = $(target + ' .table-bordered tbody').attr('id');

//alert("hii");

//var tableBody1 = $(target+" .table-bordered tbody");
        var k=1;
        var tableRowsClass = $(target+" .table-bordered tbody tr");		
		 tableRowsClass.each( function(i, val) { 
           
            var rowText = $(this).attr('id');
		       
			if(s=='Non-Teaching'){  
			if(rowText == '1' || rowText == '2')
            {			
              $(this).find("td").eq(0).html(k);		
				   tableRowsClass.eq(i).show();		
             k = k+1;				   
            }
            else
            {   tableRowsClass.eq(i).hide();                		
               
            }
			}else if(s=='Teaching'){
				if(rowText == '3')
            {				
				   $(this).find("td").eq(0).html(k);		
				   tableRowsClass.eq(i).show();		
            k = k+1;	
//k = k+1;				 
            }
            else
            {                  tableRowsClass.eq(i).hide();                	             		
               
            }
				
			}else{
				 $(this).find("td").eq(0).html(k);
				 tableRowsClass.eq(i).show();	
              k = k+1;				 
			}
			 });
		
        //all tr elements are hidden 
      //  if(tableRowsClass.children(':visible').length == 0)
       // {
         //   tableBody1.append('<tr class="search-sf"><td class="text-muted" colspan="8">No records  found.</td></tr>');
        //}
		
}
</script>