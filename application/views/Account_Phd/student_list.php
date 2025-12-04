<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<script src="<?=base_url('assets/javascripts')?>/jquery.table2excel.js"></script>

                 <script>
                                     var base_url = '<?=base_url();?>';
                                      function load_streams(type){
                   // alert(type);
                    
                $.ajax({
                    'url' : base_url + '/Examination/course_streams',
                    'type' : 'POST', //the way you want to send data to your URL
                    'data' : {'course' : type},
                    'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
                        var container = $('#semest'); //jquery selector (get element by id)
                        if(data){
                         //   alert(data);
                            //alert("Marks should be less than maximum marks");
                            //$("#"+type).val('');
                            container.html(data);
                        }
                    }
                });
            }
            
            
               function load_semsester(type){
                   // alert(type);
                    
                $.ajax({
                    'url' : base_url + '/Examination/stream_semester',
                    'type' : 'POST', //the way you want to send data to your URL
                    'data' : {'course' : type},
                    'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
                        var container = $('#semester'); //jquery selector (get element by id)
                        if(data){
                       //   alert(data);
                            //alert("Marks should be less than maximum marks");
                            //$("#"+type).val('');
                            container.html(data);
                        }
                    }
                });
            }
            
            
            
            
            
            
            
            
           $(document).ready(function(){
               $('#sbutton').click(function(){
            
         // alert("hi");
             var base_url = '<?=base_url();?>';
                   // alert(type);
                   var admissioncourse = $("#admission-course").val();
                    var admissionstream = $("#admission-stream").val();
                    var semester = $("#semester").val();
                    var acyear = $("#acyear").val();
                    
                     if(admissioncourse=='')
                    {
                        alert("Please Select Course");
                        return false;
                    }
                    
                    
                    if(admissionstream=='')
                    {
                          alert("Please Select Stream");
                        return false;
                        
                    }
                    
                    if(semester=='')
                    {
                          alert("Please Select Semester");
                        return false;
                        
                    }
                    
                     if(acyear=='')
                    {
                          alert("Please Select Academic Year");
                        return false;
                        
                    }
                $.ajax({
                    'url' : base_url + '/Account/load_studentlist',
                    'type' : 'POST', //the way you want to send data to your URL
                    'data' : {'admission-course':admissioncourse,'admission-stream':admissionstream,'admission-year':semester,'acyear':acyear,'academic_year':'2017'},
                    'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
                        var container = $('#stddata'); //jquery selector (get element by id)
                        if(data){
                            
                        //  alert(data);
                            //alert("Marks should be less than maximum marks");
                            //$("#"+type).val('');
                            container.html(data);
                            	return false;
                        }
                          return false;
                    }
                });
            });
            });
</script>
<?php 
if(isset($role_id) && $role_id==1 ){
?>
<style>
	.table{width: 150%;}
	table{max-width: 150%;}
</style>									
<?php }else{ ?>
	<style>
	table.dataTable{width: 210%;}</style>
<?php }?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Examination</a></li>
        <li class="active"><a href="#">Student List</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Student List</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                    <?php //if(in_array("Add", $my_privileges)) { ?>
                       
                    <div class="visible-xs clearfix form-group-margin"></div>
                    <?php// } ?>
                    <?php //if(in_array("Search", $my_privileges)) { ?>
                   <!--<form class="pull-right col-xs-12 col-sm-6" action="">
                        <div class="input-group no-margin">
                            <span style="border:none;background: #fff;background: rgba(0,0,0,.05);" class="input-group-addon"><i class="fa fa-search"></i></span>
                            <select id="search_me" name="search_me" style="border:none;background: #fff;background: rgba(0,0,0,.05);" class="form-control no-padding-hr" placeholder="Search...">
                                <option value="">Select Title</option>
                                <?php
                                    for($i=0;$i<count($emp_list);$i++)
                                    {
                                ?>
                                <option value="<?=$emp_list[$i]['emp_id']?>"><?=$emp_list[$i]['fname'].' '.$emp_list[$i]['lname']?></option>
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
                        <span class="panel-title">
                            <div class="form-group">
                             <!-- <label class="col-sm-2">Course<sup class="redasterik" style="color:red">*</sup></label>-->
                              <div class="col-sm-3">
                                <select name="admission-course" id="admission-course" class="form-control" onchange="load_streams(this.value)" required>
                                 <option value="">Select Course</option>
                                    <option value="0">All Courses</option>
                                  <?php
foreach ($course_details as $course) {
    if ($course['course_id'] == $personal[0]['admission-course']) {
        $sel = "selected";
    } else {
        $sel = '';
    }
    echo '<option value="' . $course['course_id'] . '"' . $sel . '>' . $course['course_short_name'] . '</option>';
}
?></select>
                              </div>
                             
                            <!--  <label class="col-sm-2">Stream<sup class="redasterik" style="color:red">*</sup></label>-->
                              <div class="col-sm-3" id="semest">
                                <select name="admission-branch" class="form-control" required>
                                  <option value="">Select Stream</option>
                                  </select>
                              </div>
                      
                             
                              <div class="col-sm-2" id="">
                                <select name="semester" id="semester" class="form-control">
                                  <option value="">Select Semester</option>
                                  <option value="0">All </option>
                                   <option value="1">1 </option>
                                   <option value="2">2 </option>
                                   <option value="3">3 </option>
                                   <option value="4">4 </option>
                                  </select>
                             </div>
                             
                              <div class="col-sm-2" id="">
                                <select name="acyear" id="acyear" class="form-control" required>
                                
                            
                                   <option value="2016">2016-17 </option>
                                   <option value="2017" selected>2017-18</option>
                                
                                  </select>
                             </div>
                             
                             
                             
                             
                             
                              <div class="col-sm-2" id="semest">
                                 <input type="button" id="sbutton" class="btn btn-primary btn-labeled" value="Search" > 
                            </div>
                            </div>
                        </span>
                        <div class="holder1"></div>
                </div>

            <div class="table-info panel-body" style="overflow:scroll;height:800px;">  
			<?php 
			$role_id=$this->session->userdata('role_id');
			if(isset($role_id) && $role_id==1 ){?>
            <form id="filterdata" method="post" action ="">

            </form>
				<?php }?>
				<?php 
					if(isset($role_id) && $role_id==2 ){
						$tbstyle="overflow:scroll;height:800px;";
					}else{ 
						$tbstyle="";
					}			
				?>
                <div class="col-lg-12">
                    <div class="table-info" id="stddata" >    
				<?php 	
				/*	if(isset($role_id) && $role_id==2 ){
				
				?>
			
                   <table class="table table-bordered" id="example">
                        <thead>
                            <tr>
                                   
                                    <th>S.No.</th>
                                    <th>PRN</th>
                                    <th>Form No.</th>
                                    <th>Name</th>
                                    <th>Stream </th>
									<th>Year</th>
									<th>Gender </th>
                                    <th>DOB</th>
                                    <th>Mobile</th>
									<th>Parent Mobile</th>
                                    <th>Email</th>
									<th>Category</th>	
                                    <th>Action</th>
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
                        
                                 <td><?=$emp_list[$i]['enrollment_no']?></td> 
								 <td><?=$emp_list[$i]['form_number']?></td> 
                                <td>
							
							<?php
								echo $emp_list[$i]['first_name']." ".$emp_list[$i]['middle_name']." ".$emp_list[$i]['last_name'];
								?>
								</td> 
								 
								<td><?=$emp_list[$i]['stream_name']?></td> 
								<td><?=$emp_list[$i]['admission_year']?></td> 
								<td>
								<?php
									if(!empty($emp_list[$i]['gender']) && $emp_list[$i]['gender']=='M'){
										echo "Male";
									}else{
										echo "Female";
									}
								?>
								</td>								
								<td><?=$emp_list[$i]['dob']?></td>                                                    
                                <td><?=$emp_list[$i]['mobile'];?></td>
								<td><?=$emp_list[$i]['parent_mobile2'];?></td>								
                                <td><?=$emp_list[$i]['email'];?></td> 
                                <td><?=$emp_list[$i]['category'];?></td>                    
                                                        
                                <td>
                                    
										<a  href="<?php echo base_url()."ums_admission/view_studentFormDetails/".$emp_list[$i]['stud_id'].""?>" title="View" target="_blank"><i class="fa fa-eye"></i>  </a>&nbsp;&nbsp;&nbsp;&nbsp;
										<a  href="<?php echo base_url()."ums_admission/edit_personalDetails/".$emp_list[$i]['stud_id'].""?>" title="Edit"><i class="fa fa-edit"></i> </a>&nbsp;&nbsp;&nbsp;&nbsp;
                             </td>
                            </tr>
                            <?php
                            $j++;
                            }
                            ?>                            
                        </tbody>
                    </table>               
                    <?php }*/ ?>
                </div>
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
                        str+='<a href="<?=base_url(strtolower($currentModule))?>/deact_emp?id='+array.emp_details[i].emp_id+"&status="+array.emp_details[i].emp_status+'"> <i title="Disable" class="fa fa-ban"></i></a>';
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
<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/pdfmake.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.3.1/css/buttons.dataTables.min.css">


<script>
$(document).ready(function() {
    $('#example').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'csv', 'excel'
        ]
    } );
} );
</script>