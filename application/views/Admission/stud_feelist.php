<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<script src="<?=base_url('assets/javascripts')?>/jquery.table2excel.js"></script>

                 <script>
                                     var base_url = '<?= base_url(); ?>';
                                      function load_streams(type){
                   // alert(type);
                      var academic_year = $("#academic-year").val();    
					  var stream = '<?php echo $admission_branch;?>';
                $.ajax({
                   // 'url' : base_url + 'Ums_admission/load_streams',
                    'url' : base_url + 'Ums_admission/load_streams_student_list',
                    'type' : 'POST', //the way you want to send data to your URL
                    //'data' : {'course' : type},
                    'data' : {'course' : type,'academic_year':academic_year,'stream':stream},
                    'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
                        var container = $('#admission-branch'); //jquery selector (get element by id)
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
             var base_url = '<?= base_url(); ?>';
                   // alert(type);
				   var acdyear = $("#academic-year").val();
                   var acourse = $("#admission-course").val();
                   var astream = $("#admission-branch").val();
                   var ayear = $("#admission-year").val();
                   var prn = $("#prn").val();
                     
					 
					 
                     /* if(acourse=='')
                    {
                        alert("Please Select Course");
                        return false;
                    }
                    
                    
                    if(astream=='')
                    {
                          alert("Please Select Stream");
                        return false;
                        
                    }
                    
                    if(ayear=='')
                    {
                          alert("Please Select Year");
                        return false;
                        
                    } */
                    
                        
                    if(acdyear=='')
                    {
                          alert("Please Select Academic Year");
                        return false;
                        
                    }
                    
                $.ajax({
                    'url' : base_url + 'Ums_admission/search_studentfeedata',
                    'type' : 'POST', //the way you want to send data to your URL
                    'data' : {'acdyear':acdyear,'acourse':acourse,'astream':astream,'ayear':ayear,'prn':prn},
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
        <li class="active"><a href="#">Admission</a></li>
        <li class="active"><a href="#">Student Fees</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Student Fees</h1>
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
        <?php
        if($this->session->flashdata('errormessage')) {
$message = $this->session->flashdata('errormessage');
?>
<div class="<?php echo $message['class'] ?>">
Fees updated successfully for selected students
</div>
<?php
}
?>
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                <div class="panel-heading">
                        <span class="panel-title">
                            <div class="form-group">
                             <!-- <label class="col-sm-2">Course<sup class="redasterik" style="color:red">*</sup></label>-->
                             <div class="col-sm-2" id="">
                                <select name="academic-year" id="academic-year" class="form-control" required>
                                  <option value=""> Academic Year</option>
								  <option value="2025" <?php if($academic_year=='2025'){?> selected="selected"<?php } ?>>2025-26 </option>
								  <option value="2024" <?php if($academic_year=='2024'){?> selected="selected"<?php } ?>>2024-25 </option>
								  <option value="2023" <?php if($academic_year=='2023'){?> selected="selected"<?php } ?>>2023-24 </option>
								  <option value="2022" <?php if($academic_year=='2022'){?> selected="selected"<?php } ?>>2022-23 </option>
                                  <!--option value="2021" <?php if($academic_year=='2021'){?> selected="selected"<?php } ?>>2021-22 </option>
								  <option value="2020" <?php if($academic_year=='2020'){?> selected="selected"<?php } ?>>2020-21 </option>
								 <option value="2019" <?php if($academic_year=='2019'){?> selected="selected"<?php } ?>>2019-20 </option>
								   <option value="2018" <?php if($academic_year=='2018'){?> selected="selected"<?php } ?>>2018-19 </option>
								  <!--option value="2017" <?php if($academic_year=='2017'){?> selected="selected"<?php } ?>>2017-18 </option>
                                  <option value="2016" <?php if($academic_year=='2016'){?> selected="selected"<?php } ?>>2016-17</option>-->
                                  </select>
                             </div>
                             
                              <div class="col-sm-2">
                                <select name="admission-course" id="admission-course" class="form-control" onchange="load_streams(this.value)" required>
                                  <option value="">Select Course</option>
                                  <?php
                                        foreach ($course_details as $course) {
                                            if ($course['course_id'] == $admission_course) {
                                                $sel = "selected";
                                            } else {
                                                $sel = '';
                                            }
                                            echo '<option value="' . $course['course_id'] . '"' . $sel . '>' . $course['course_short_name'] . '</option>';
                                        }
                                        ?></select>
                              </div>
                             
                            <!--  <label class="col-sm-2">Stream<sup class="redasterik" style="color:red">*</sup></label>-->
                              <div class="col-sm-2" id="semest">
                                <select name="admission-branch" class="form-control"  id="admission-branch"  required>
                                  <option value="">Select Stream</option>
                                  </select>
                              </div>
                               <div class="col-sm-1" id="">
                                <select name="admission-year" id="admission-year" class="form-control" required>
                                  <option value="">Select Year</option>
                                   <option value="1" <?php if($admission_year=='1'){?> selected="selected"<?php } ?>>1 </option>
                                   <option value="2" <?php if($admission_year=='2'){?> selected="selected"<?php } ?>>2 </option>
                                   <option value="3" <?php if($admission_year=='3'){?> selected="selected"<?php } ?>>3 </option>
                                   <option value="4" <?php if($admission_year=='4'){?> selected="selected"<?php } ?>>4 </option>
                                   <option value="5" <?php if($admission_year=='5'){?> selected="selected"<?php } ?>>5 </option>
                                  </select>
                             </div>
                             <div class="col-sm-1" style="text-align: right;">OR </div><div class="col-sm-1" style="text-align: right;">PRN </div>
                              <div class="col-sm-1">
                                <input type='text' name="prn" class="form-control"  id="prn" >
                                 
                              </div>
                             
                             
                              <div class="col-sm-2" id="semest">
                                 <input type="button" id="sbutton" class="btn btn-primary btn-labeled" value="Search" > 
                            </div>
							
                            </div>
							<a href="<?=base_url()?>Ums_admission/import_concession_fee_excel"><button type="submit" class="btn btn-success w-100">
                                <i class="fa fa-download"></i> Import Excel
                            </button></a>
                        </span>
                        <div class="holder1"></div>
                </div>

            <div class="table-info panel-body"  style="overflow:scroll;height:700px;">    
			<?php 
			$role_id=$this->session->userdata('role_id');
			if(isset($role_id) && $role_id==1 ){?>
            <form id="filterdata" method="post" action ="">

            </form>
				<?php }?>
			
                <div class="col-lg-12">
                    <div class="table-info" id="stddata">    
				<?php 	
			//	var_dump($emp_list);
					if(count($emp_list)>0){
				
				?>
			
                   <form method="post" action="<?=base_url()?>Ums_admission/applyexem/<?=$dcourse?>/<?=$dyear?>">
 
 <table class="table table-bordered" id="table2excel">
                        <thead>
                            <tr>
                                   <th><input type="checkbox"  id="ckbCheckAll"></th>
                                    <th >S.No.</th>
                                    <th>PRN</th>
                                    <th>Name</th>
                                    <th>Mobile</th>
                                    <th>Actual Fees</th>
                                    <th>Excempted Fees</th>
                                    <th>Applicable Fees</th>

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
                                <th><input type="checkbox" value="<?=$emp_list[$i]['stud_id']?>" name="lstd[]" class="checkBoxClass"></td>
                               <td><?=$j?></td>
                        
                                 <td ><?=$emp_list[$i]['enrollment_no']?></td> 
                                 

							<td>
							<?php
								echo $emp_list[$i]['first_name']." ".$emp_list[$i]['middle_name']." ".$emp_list[$i]['last_name'];
								?>
								</td> 
							                      
                                                      
                                <td><?=$emp_list[$i]['mobile'];?></td>    

                                      <td>  <input type="text" value="<?=$emp_list[$i]['actual_fee'];?>" name="<?=$emp_list[$i]['stud_id']?>_actual" id="txtnum">      </td>
                                       <td>  <input type="text" value="<?php echo (int)$emp_list[$i]['actual_fee'] - (int)$emp_list[$i]['applicable_fee'] ;?>" name="<?=$emp_list[$i]['stud_id']?>_exem" id="txtnum">      </td>

                                      <td>  <input type="text" value="<?=$emp_list[$i]['applicable_fee'];?>" name="<?=$emp_list[$i]['stud_id']?>_appli" readonly>      </td>
                                     
                            </tr>
                            <?php
                            $j++;
                            }
                            ?>                            
                        </tbody>
                    </table>  
                    
                       <input type="hidden" name="dcourse" value="<?=$dcourse;?>">
                     <input type="hidden" name="dyear" value="<?=$dyear;?>">
                     
                     <!-- <input type="submit" value="Apply Fees" class="btn btn-primary btn-labeled">-->
                     <center>
                                     <?php
                                    // if($this->session->userdata('name')=="admission"){
                                    	if(isset($emp_list)){
                                         echo '<input type="submit" value="Update Fee" class="btn btn-primary btn-labeled" id="feesrow">     </center>';
                                    	}
                                    // }
                                     ?>
                                   
                 <input type="hidden" name="dcourse" value="<?=$dcourse;?>">
                     <input type="hidden" name="dyear" value="<?=$dyear;?>">

                     </form>
                    <form method="post" action="<?=base_url()?>Ums_admission/generatepdf/">

                     </form> <?php } ?>
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
 <?php if(!empty($admission_course)){ ?>
             <script>
			load_streams(<?php echo $admission_course;?>);
			</script>
            <?php } ?>
		<?php if((!empty($academic_year))&&(!empty($admission_course))&&(!empty($admission_branch))&&(!empty($admission_year))){ ?>	
            <script>  //$(document).ready(function(){ 
			function call_after(){
			$('#sbutton').trigger('click');
			}
            
            //setInterval( "call_after()", 5000 );
setTimeout(function(){ call_after(); }, 3000);

            
            </script>
            <?php } ?>