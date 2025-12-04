<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<?php// print_r($emp_list);?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Masters</a></li>
        <li class="active"><a href="#">Center List</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Center List</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                    <?php //if(in_array("Add", $my_privileges)) { ?>
                    <div class="pull-right col-xs-12 col-sm-auto"><a style="width: 100%;" class="btn btn-primary btn-labeled" href="<?=base_url($currentModule."/create_employee")?>"><span class="btn-label icon fa fa-plus"></span>Add New Employee</a></div>                        
                    <div class="visible-xs clearfix form-group-margin"></div>
                    <?php// } ?>
                    <?php //if(in_array("Search", $my_privileges)) { ?>
                   <!-- <form class="pull-right col-xs-12 col-sm-6" action="">
                        <div class="input-group no-margin">
                            <span style="border:none;background: #fff;background: rgba(0,0,0,.05);" class="input-group-addon"><i class="fa fa-search"></i></span>
                            <select id="search_me" name="search_me" style="border:none;background: #fff;background: rgba(0,0,0,.05);" class="form-control no-padding-hr" placeholder="Search...">
                                <option value="">Select Title</option>
                                <?php
                                    for($i=0;$i<count($emp_list);$i++)
                                    {
                                ?>
                                <option value="<?=$emp_list[$i]['ic_code']?>"><?=$emp_list[$i]['ic_name']?></option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>
                    </form>-->
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
                        <span class="panel-title">Employee List</span>
                        <div class="holder"></div>
                </div>
                <div class="panel-body">
                    <div class="table-info">    
                    <?php //if(in_array("View", $my_privileges)) { ?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                    <th>#</th>
                                    <th>EmployeeID</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Dept/Designation</th>
                                    <th>At Work</th>
                                    <th>Phone</th>
                                    <th>Status</th>
                                    <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php
                            $j=1;                            
                            for($i=0;$i<count($emp_list);$i++)
                            {
                                
                            ?>
                            <tr <?=$emp_list[$i]["status"]=="N"?"style='background-color:#FBEFF2'":""?>>
                                <td><?=$j?></td>  
                                <td><?=$emp_list[$i]['emp_id']?></td> 
                                <td><?php if(!empty($emp_list[$i]['profile_pic'])){
			$profile=base_url()."uploads/employee_profilephotos/".$emp_list[$i]['profile_pic'];
		}else{
	$profile=base_url()."uploads/noprofile.png";}?>
								<img src="<?=$profile;?>" alt="ProfileImage" height="80px"></td> 
                                <td><?=ucfirst($emp_list[$i]['lname'])." ".ucfirst($emp_list[$i]['fname']);?></td>                                                                
                                <td><p>Department: <strong><?php  $res=$this->Admin_model->getDepartmentById($emp_list[$i]['department']);
										 // print_r($res);
										  echo $res[0]['department_name'];
										  ?></strong></p>
                                          <p>Designation: <strong><?php  $res=$this->Admin_model->getDesignationById($emp_list[$i]['designation']);
										 // print_r($res);
										  echo $res[0]['designation_name'];
										  ?></strong></p>
								</td>                                
                                <td> <?php 
											$date1 = $emp_list[$i]['joiningDate'];
                                            $date2 = date("Y-m-d");
                                            $diff = abs(strtotime($date2) - strtotime($date1));
                                            $years = floor($diff / (365*60*60*24));
                                            $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                                            $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
                                            printf("%d years, %d months, %d days\n", $years, $months, $days);
									  ?></td>                                
                                <td><?=$emp_list[$i]['mobileNumber'];?></td>                                
                                <td><?php if($emp_list[$i]['emp_status']=='Y'){?> 
                                      <span class="btn btn-success"> active </span>
									<?php }else{?>
									<span class="btn btn-danger"> Inactive </span>
									<?php }?></td>                                
                                                        
                                <td>
                                    <p> 
			<a  href="<?php echo base_url()."Admin/view_emp?id=".$emp_list[$i]['emp_id']."&status=".$emp_list[$i]['emp_status'].""?>" title="View"><i class="fa fa-eye"></i>  </a>&nbsp;&nbsp;&nbsp;&nbsp;
	<a  href="<?php echo base_url()."Admin/create_employee?id=".$emp_list[$i]['emp_id']."&status=".$emp_list[$i]['emp_status']."&flag=".'1'.""?>" title="Edit"><i class="fa fa-edit"></i> </a>&nbsp;&nbsp;&nbsp;&nbsp;
     <a style="width: 105px;" href="<?php echo base_url()."Admin/deact_emp?id=".$emp_list[$i]['emp_id']."&status=".$emp_list[$i]['emp_status'].""?>"><i class="fa fa-trash-o" title="Change Status"></i></a></p>
                                </td>
                            </tr>
                            <?php
                            $j++;
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
</div>
<script>
  $("div.holder").jPages
  ({
    containerID : "itemContainer"
  });
    $("#search_me").select2({
      placeholder: "Enter Event name",
      allowClear: true
    });    
        $("#search_me").on('change',function()
        {
            var search_val = $(this).val();            
            var url  = "<?=base_url().strtolower($currentModule).'/search/'?>";	
            var data = {title: search_val};		
            var type="";
            var type_name="";
            $.ajax
            ({
                type: "POST",
                url: url,
                data: data,
                dataType: "html",
                cache: false,
                crossDomain: true,
                success: function(data)
                {                       
                    var array=JSON.parse(data);
                    var str="";
                    var str2="";
                    for(i=0;i<array.city_details.length;i++)
                    {
                        str+='<tr style="display: table-row; opacity: 1;">';
                        str+='<td>'+(i+1)+'</td>';                                                                                                                        
                        str+='<td>'+array.city_details[i].state_name+'</td>';                        
                        str+='<td>'+array.city_details[i].city_name+'</td>';                        
                        str+='<td>';
                        str+='<a href="<?=base_url(strtolower($currentModule))?>/edit/'+array.city_details[i].event_id+'"><i class="fa fa-edit"></i></a>';
                        str+=' <a href="<?=base_url(strtolower($currentModule))?>/disable/'+array.city_details[i].event_id+'"><i title="Disable" class="fa fa-ban"></i></a>';
                        str+='</td>';
                        str+='</tr>';
                        $("#itemContainer").html(str);
                    }
                },
                error: function(data)
                {
                    alert("Page Or Folder Not Created..!!");
                }
            });
        });
</script>