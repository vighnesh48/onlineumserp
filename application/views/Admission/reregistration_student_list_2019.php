<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<script src="<?=base_url('assets/javascripts')?>/jquery.table2excel.js"></script>
 
                 <script>
                                     var base_url = '<?=base_url();?>';
                                      function load_streams(type){
                   // alert(type);
                var academic_year = $("#academic-year").val();    
                $.ajax({
                    'url' : base_url + '/Ums_admission/load_streams_student_list',
                    'type' : 'POST', //the way you want to send data to your URL
                    'data' : {'course' : type,'academic_year':academic_year},
                    'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
                        var container = $('#admission-branch'); //jquery selector (get element by id)
                        if(data){
                            //alert(data);
                            //alert("Marks should be less than maximum marks");
                            //$("#"+type).val('');
                            container.html(data);
                        }
                    }
                });
            }
           $(document).ready(function(){
               $('#sbutton').click(function(){
            
         //alert("hi");
             var base_url = '<?=base_url();?>';
                    //alert(base_url);
                   var reported = $("#reported_status").val();
                    var fees_paid = $("#fees_paid").val();
                    var ayear = $("#academic_year").val();
                    var admission_school = $("#admission_school").val();
                    //var acdyear = $("#academic-year").val();
                    //alert(admission_school);
                     if(reported=='')
                    {
                        alert("Please Select Reporting");
                        return false;
                    }
                    
                    
                    if(fees_paid=='')
                    {
                          alert("Please Select Fees status");
                        return false;
                        
                    }
                    
                    if(ayear=='')
                    {
                          alert("Please Select Year");
                        return false;
                        
                    }
                    //alert(ayear);
                $.ajax({
                    'url' : base_url + 'Ums_admission/load_re_registration_studentlist',
                    'type' : 'POST', //the way you want to send data to your URL
                    'data' : {'fees_paid':fees_paid,'ayear':ayear,'reported':reported,'admission_school':admission_school},
                    'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
                        var container = $('#stddata'); //jquery selector (get element by id)
                        if(data){
                            
                         //alert(data);
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
        <li class="active"><a href="#">Admission</a></li>
        <li class="active"><a href="#">Re-registration Student List</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Re-registration Student List</h1>
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
                             
							 <div class="col-sm-2" id="">
                                <select name="academic_year" id="academic_year" class="form-control" required>
                                  <option value=""> Academic Year</option>
								  <option value="<?=C_RE_REG_YEAR?>" selected ><?=RE_REG_YEAR?></option>
                                   
                                  </select>
                             </div>
							 <div class="col-sm-2" id="">
                                <select name="admission_school" class="form-control" id="admission_school" onchange="load_courses(this.value)" required>
                              
                                  <?php
								  echo '<option value="All" > All School </option>';
									foreach ($school_list as $schools) {
										
										echo '<option value="' . $schools['school_id'] . '"' . $sel . '>' . $schools['school_short_name'] . '</option>';
										
									}
									?>
                               </select>
                             </div>
							 
							  <div class="form-group">
                              <!--<label class="col-sm-3">Course <?= $astrik ?></label>-->
                           <!--   <div class="col-sm-3" >
                                <select name="admission-course" id="admission-course" class="form-control" onchange="load_streams(this.value)" required>
                                  <option value="">Select</option>
                                  <?php
foreach ($course_details as $course) {
    if ($course['course_id'] == $personal[0]['admission-course']) {
        $sel = "selected";
    } else {
        $sel = '';
    }
    echo '<option value="' . $course['course_id'] . '"' . $sel . '>' . $course['course_short_name'] . '</option>';
}
?>
                               </select>
                              </div>
                              <script>
                                     var base_url = '<?php echo site_url();?>';
                                     
                                        function load_courses(type){
                   // alert(type);
                   var acyear = $("#academic-year").val();    
                   // var year ='<?=$stud_det['admission_year'];?>';
                $.ajax({
                    'url' : base_url + 'Ums_admission/load_courses',
                    'type' : 'POST', //the way you want to send data to your URL
                    'data' : {'school' : type,'acyear':acyear},
                    'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
                        var container = $('#admission-course'); //jquery selector (get element by id)
                        if(data){
                         //   alert(data);
                            //alert("Marks should be less than maximum marks");
                            //$("#"+type).val('');
                            container.html(data);
                        }
                    }
                });
            }
                                      function load_streams(type){
                   // alert(type);
                   var acyear = $("#academic-year").text();    
                    
                $.ajax({
                    'url' : base_url + 'Ums_admission/get_course_streams_yearwise',
                    'type' : 'POST', //the way you want to send data to your URL
                    'data' : {'course' : type,'acyear':acyear},
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
            
                                    </script>
                              <!--<label class="col-sm-3">Stream <?= $astrik ?></label>-->
                           <!--   <div class="col-sm-3" id="semest" >
                                <select name="admission-branch" class="form-control" required>
                                  <option value="">Select</option>
                                  <?php
foreach ($branches as $branch) {
    if ($branch['branch_code'] == $personal[0]['admission-branch']) {
        $sel = "selected";
    } else {
        $sel = '';
    }
    echo '<option value="' . $branch['branch_code'] . '" ' . $sel . '>' . $branch['branch_code'] . '</option>';
}
?>
                               </select>
                              </div>
                            </div>-->
							
                              <div class="col-sm-2">
                                <select name="reported_status" id="reported_status" class="form-control" required>
                                <option value="All">All</option>
                                <option value="Y">Reported</option>
                                <option value="N">Not-Reported</option>
                                </select>
                              </div>
                             
                            <!--  <label class="col-sm-2">Stream<sup class="redasterik" style="color:red">*</sup></label>-->
                              <!--div class="col-sm-3" display="none">
                                <select name="fees_paid" id="fees_paid" class="form-control" >
                                  <option value="All" >SELECT</option>
                                  <option value="Y" selected>fees_paid</option>
                                 <option value="N">fees Not paid</option>
                                  </select>
                              </div-->
                               <!--<div class="col-sm-2" id="">
                                <select name="admission-year" id="admission-year" class="form-control" required>
                                  <option value="">Select Year</option>
                                   <!--option value="1">1 </option>
                                   <option value="2">2 </option>
                                   <option value="3">3 </option>
                                   <option value="4">4 </option-->
                                 <!-- </select>
                             </div>-->
                             
                             
                             
                             
                             
                              <div class="col-sm-2" >
                                 <input type="button" id="sbutton" class="btn btn-primary btn-labeled" value="Search" > 
                            </div>
                             <!--<div class="col-sm-3" id="semest">
                               <a href="<?=base_url()?>Ums_admission/generateallpdfs">  <input type="button" id="" class="btn btn-primary btn-labeled" value="Generate All" > </a>
                            </div>-->
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
			
                <div class="col-lg-12">
                    <div class="table-info" id="stddata" >    
				<?php 	
					if(isset($role_id) && $role_id==2 ){
				
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
									<?php //if(isset($role_id) && $role_id==10){?>
									<th>Detention</th>
									<?php //} ?>
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
							 <?php ?>
							 <td><?php if($emp_list[$i]['is_detained']=='N'){?> <button class="btn btn-success" id="no~<?=$emp_list[$i]['stud_id']?>" onclick="return mark_detention(this.id)">N</button><?php }else{?><button class="btn btn-danger">Detained</button><?php }?></td>
                            </tr>
                            <?php
                            $j++;
                            }
                            ?>                            
                        </tbody>
                    </table>               
                    <?php } ?>
                </div>
                </div>
                </div>
            </div>
            </div>    
        </div>
    </div>
</div>
<script>
function mark_detention(id){
	//alert(id);
	res = id.split("~");
	var detain =res[0];
	var stud_id =res[1];
	if(confirm("Are you sure to Detain this student")){
	$.ajax({
		type: 'POST',
		url: '<?= base_url() ?>Ums_admission/detain_student',
		data: {detain:detain,stud_id:stud_id},
		success: function (data) {
			if(data=='Y'){
			alert("Updated Successfully..");
			 location.reload();	
			}
		}
	});
	}else {

            return false;
        }
	return true;
}  
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
 $('#academic-year').change(function () {
        var academic_year = $("#academic-year").val();
		//alert(stream_id);
		if (academic_year) {
			$.ajax({
				'url' : base_url + '/Ums_admission/load_courses_for_studentlist',
				'type' : 'POST', //the way you want to send data to your URL
				'data' : {'academic_year' : academic_year},
				'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
					var container = $('#admission-course'); //jquery selector (get element by id)
					if(data){	
						container.html(data);
					}
				}
			});
		}
    });
	 $('#admission-branch').change(function () {
        var admission_stream = $("#admission-branch").val();
		var academic_year = $("#academic-year").val();
		if (admission_stream) {
			$.ajax({
				'url' : base_url + '/Ums_admission/load_years_for_studentlist',
				'type' : 'POST', //the way you want to send data to your URL
				'data' : {'academic_year' : academic_year,admission_stream:admission_stream},
				'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
					var container = $('#admission-year'); //jquery selector (get element by id)
					if(data){	
						container.html(data);
					}
				}
			});
		}
    });
} );
</script>