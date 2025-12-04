<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<?php// print_r($all_emp_leave);?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Masters</a></li>
        <li class="active"><a href="#">Staff Leaves List</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Center List</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                    <?php //if(in_array("Add", $my_privileges)) { ?>
                    <div class="pull-right col-xs-12 col-sm-auto"><a style="width: 100%;" class="btn btn-primary btn-labeled" href="<?=base_url($currentModule."/staff_leave_allocation")?>"><span class="btn-label icon fa fa-plus"></span>Add Employee Leaves</a></div>                        
                    <div class="visible-xs clearfix form-group-margin"></div>
                    <?php// } ?>
                    <?php //if(in_array("Search", $my_privileges)) { ?>
                   <form class="pull-right col-xs-12 col-sm-6" action="">
                        <div class="input-group no-margin">
                            <span style="border:none;background: #fff;background: rgba(0,0,0,.05);" class="input-group-addon"><i class="fa fa-search"></i></span>
                            <select id="search_me" name="search_me" style="border:none;background: #fff;background: rgba(0,0,0,.05);" class="form-control no-padding-hr" placeholder="Search...">
                                <option value="">Select Title</option>
                                <?php
                                    for($i=0;$i<count($all_emp_leave);$i++)
                                    {
                                ?>
                                <option value="<?=$all_emp_leave[$i]['emp_id']?>"><?=$all_emp_leave[$i]['fname'].' '.$all_emp_leave[$i]['lname']?></option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>
                    </form>
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
                        <span class="panel-title">Employee Leaves List</span>
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
                                    <th>Employee Name</th>
                                    <th>School/Dept/Designation</th>
                                    <th>At Work from</th>
                                    <th>vslot1</th>
                                    <th>vslot2</th>
                                    <th>vslot3</th>
                                    <th>vslot4</th>
                                    <th>CL</th>
                                    <th>C-Off</th>
                                    <th>EL</th>
                                    <th>ML</th>
                                    <th>VL</th>
                                    <th>SL</th>
                                    <th>Leave</th>
                                    <th>LWP</th>
                                    <th>STL</th>
				    <th>Action</th>
									
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php
							if(!empty($all_emp_leave)){
                            $j=1;                            
                            for($i=0;$i<count($all_emp_leave);$i++)
                            {
                                
                            ?>
							 <?php if($all_emp_leave[$i]['ro_flag']=='on') $bg="bgcolor='#e6eaf2'";
								  else $bg="";?>								
                            <tr <?=$bg?> <?=$all_emp_leave[$i]["status"]=="N"?"style='background-color:#FBEFF2'":""?>>
                                <td><?=$j?></td> 
                                 
                                <td><?=$all_emp_leave[$i]['emp_id']?></td> 
                                
                                <td><?=ucfirst($all_emp_leave[$i]['lname'])." ".ucfirst($all_emp_leave[$i]['fname']);?></td>                                                                
                                <td><p>School: <strong><?=$all_emp_leave[$i]['college_name']?></strong></p>
                                    <p>Department: <strong><?=$all_emp_leave[$i]['department_name']?></strong></p>
                                    <p>Designation: <strong><?=$all_emp_leave[$i]['designation_name']?></strong></p>
								</td>                                
                                <td> <?php 
					   $date1 = $all_emp_leave[$i]['dt_join'];
                                            $date2 = date("Y-m-d");
                                            $diff = abs(strtotime($date2) - strtotime($date1));
                                            $years = floor($diff / (365*60*60*24));
                                            $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                                            $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
                                            printf("%d years, %d months, %d days\n", $years, $months, $days);
									  ?></td>                                
                                <td><?=$all_emp_leave[$i]['vslot1'];?></td>                                
                                <td><?=$all_emp_leave[$i]['vslot2'];?></td>                                
                                <td><?=$all_emp_leave[$i]['vslot3'];?></td>                                
                                <td><?=$all_emp_leave[$i]['vslot4'];?></td>                                
                                <td><?=$all_emp_leave[$i]['cnt_cl'];?></td>                                
                                <td><?=$all_emp_leave[$i]['cnt_coff'];?></td>                                
                                <td><?=$all_emp_leave[$i]['cnt_el'];?></td>                                
                                <td><?=$all_emp_leave[$i]['cnt_ml'];?></td>                                
                                <td><?=$all_emp_leave[$i]['cnt_vl'];?></td>                                
                                <td><?=$all_emp_leave[$i]['cnt_sl'];?></td>                                
                                <td><?=$all_emp_leave[$i]['cnt_leave'];?></td>                                
                                <td><?=$all_emp_leave[$i]['cnt_lwp'];?></td>                                
                                <td><?=$all_emp_leave[$i]['cnt_stl'];?></td>                                                
                                <td><a href="<?=base_url($currentModule.'/staff_leave_allocation?lv_id='.$all_emp_leave[$i]['el_id'].'')?>" title="Edit"><i class="fa fa-edit"></i></a></td>
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
                    for(i=0;i<array.emp_details.length;i++)
                    {
                        str+='<tr style="display: table-row; opacity: 1;">';
                        str+='<td>'+(i+1)+'</td>';                                                                                                
                        str+='<td>'+array.emp_details[i].emp_id+'</td>';
									
                        str+='<td><img src=" <?=base_url();?>uploads/employee_profilephotos/'+array.emp_details[i].profile_pic+' " alt="ProfileImage" height="80px"></td>';
                        str+='<td>'+array.emp_details[i].fname+' '+array.emp_details[i].lname+'</td>';
                        str+='<td>Department:'+array.emp_details[i].department_name+'<br>Designation:'+array.emp_details[i].designation_name+'</td>';
                       //joining date duration calculation
					   var user_date = Date.parse(array.emp_details[i].joiningDate);
                       var today_date = new Date();
                       var diff_date =  user_date - today_date;
                       var num_years = diff_date/31536000000;
                       var num_months = (diff_date % 31536000000)/2628000000;
                       var num_days = ((diff_date % 31536000000) % 2628000000)/86400000;
				    
						str+='<td>'+Math.abs(Math.ceil(num_years))+"years,"+Math.abs(Math.ceil(num_months))+"months,"+Math.abs(Math.ceil(num_days))+"days"+'</td>';                            
					    str+='<td>'+array.emp_details[i].mobileNumber+'</td>';
                         if(array.emp_details[i].emp_status=='Y')                        
                        str+='<td><span class="btn btn-success"> active </span></td>';
                       else
						   str+='<td><span class="btn btn-danger"> Inactive </span></td>';
                        str+='<td>';
                        str+='<a href="<?=base_url(strtolower($currentModule))?>/view_emp?id='+array.emp_details[i].emp_id+"&status="+array.emp_details[i].emp_status+'"><i class="fa fa-eye"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;';
                        str+='<a href="<?=base_url(strtolower($currentModule))?>/create_employee?id='+array.emp_details[i].emp_id+"&status="+array.emp_details[i].emp_status+'"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;';
                        str+='<a href="<?=base_url(strtolower($currentModule))?>/deact_emp?id='+array.emp_details[i].emp_id+"&status="+array.emp_details[i].emp_status+'"><i title="Disable" class="fa fa-ban"></i></a>';
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