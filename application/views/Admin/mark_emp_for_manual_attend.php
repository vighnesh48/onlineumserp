<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">

<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>

<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">

<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>

<?php// print_r($emp_list);?>
<style>
 .table-info {height:700px;overflow-y:scroll;}
.table{width:100%;}
    
</style>
<div id="content-wrapper">

    <ul class="breadcrumb breadcrumb-page">

        <div class="breadcrumb-label text-light-gray">You are here: </div>        

        <li class="active"><a href="#">Attendance</a></li>

        <li class="active"><a href="#">Manual Attendance</a></li>

    </ul>

    <div class="page-header">			

        <div class="row">

            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Staff Manual Attendance</h1>

            <div class="col-xs-12 col-sm-8">

                <div class="row">                    

                    <hr class="visible-xs no-grid-gutter-h">              

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

                        <span class="panel-title">Employee List</span>                       

                </div>

				<form method="post" name="form2" action="">

                <div class="panel-body">

				<span id="flash-messages" style="color:red;padding-left:110px;"><?php echo $this->session->flashdata('message1'); ?></span><br>

                    <div class="table-info">    

                    <?php //if(in_array("View", $my_privileges)) { ?>

                    <table class="table table-bordered">

                        <thead>

                            <tr>

                                    <th>#</th>

									<th>Mark</th>

                                    <th>EmployeeID</th>                                   

                                    <th>Name</th>

                                    <th>Dept/Designation</th>

                                    

                            </tr>

                        </thead>

                        <tbody id="itemContainer">

                            <?php

                            $j=1;                            

                            for($i=0;$i<count($emp_list);$i++)

                            {

                                

                            ?>

							 <?php if($emp_list[$i]['ro_flag']=='on') $bg="bgcolor='#e6eaf2'";

								  else $bg="";?>								

                            <tr <?=$bg?> <?=$emp_list[$i]["status"]=="N"?"style='background-color:#FBEFF2'":""?>>

                                <td><?=$j?></td> 

                                <td><?php if($emp_list[$i]['manual_attendance_flag']=='Y'){

									$vv='checked';

								}elseif($emp_list[$i]['manual_attendance_flag']=='N'){

									$vv='';

									

								}?><input value="<?=$emp_list[$i]['emp_id']?>" name="ch[]" <?=$vv?> type="checkbox"></td> 

                                <td><?=$emp_list[$i]['emp_id']?></td> 

                              

                                <td><?=ucfirst($emp_list[$i]['lname'])." ".ucfirst($emp_list[$i]['fname']);?></td>                                                                

                                <td><p>Department : <strong><?php  $res=$this->Admin_model->getDepartmentById($emp_list[$i]['department']);

										 // print_r($res);

										  echo $res[0]['department_name'];

										  ?></strong>&nbsp;&nbsp;&nbsp;&nbsp;Designation : <strong><?php  $res=$this->Admin_model->getDesignationById($emp_list[$i]['designation']);

										 // print_r($res);

										  echo $res[0]['designation_name'];

										  ?></strong></p>

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

				<div class="form-group">

                                    <div class="col-sm-3"></div>

                                    <div class="col-sm-2">
<?php //print_r($my_privileges);
                    if(in_array("Add", $my_privileges)) { ?>
                                        <input type="submit" name="mark" class="btn btn-primary form-control" value="Add Marked Staff" id="btn_submit">                                      
<?php } ?>
                                    </div> 

</div>

				</form>

            </div>

            </div>    

        </div>

    </div>

</div>

<script>

 /* $("div.holder").jPages

  ({

    containerID : "itemContainer"

  });*/

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