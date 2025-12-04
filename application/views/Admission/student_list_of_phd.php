<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<script src="<?=base_url('assets/javascripts')?>/jquery.table2excel.js"></script>

                 <script>


function load_courses(){
        var academic_year = $("#academic-year").val();
    //alert(stream_id);
    if (academic_year) {
      $.ajax({
        'url' : base_url + 'Phd_admission/load_courses_for_studentlist',
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
    }

                                     var base_url = '<?=base_url();?>';
                                      function load_streams(type){
                   // alert(type);
                var academic_year = $("#academic-year").val();    
                $.ajax({
                    'url' : base_url + 'phd_admission/load_streams_student_list',
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

                 function load_batch(type){
                
                   // alert(type);
                var academic_year = $("#academic-year").val();    
                $.ajax({
                    'url' : base_url + 'phd_admission/load_batch_student_list',
                    'type' : 'POST', //the way you want to send data to your URL
                    'data' : {'academic_year':type},
                    'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
                        var container = $('#batch'); //jquery selector (get element by id)
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

                   var base_url = "<?= base_url() ?>";
                   var acourse = $("#admission-course").val();
                   var astream = $("#admission-branch").val();
                   var ayear = $("#admission-year").val();
                   var acdyear = $("#academic-year").val();
                   var batch = $("#batch").val();
                    
                   /*   if(acourse=='')
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
                    
                $.ajax({
                    'url' : base_url + 'phd_admission/load_studentlist',
                    'type' : 'POST', //the way you want to send data to your URL
                    'data' : {'astream':astream,'ayear':ayear,'acdyear':acdyear,'batch':batch},
                    'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
                        var container = $('#stddata'); //jquery selector (get element by id)
                        if(data){
							
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
        <li class="active"><a href="#">Phd Admission</a></li>
        <li class="active"><a href="#">Student List</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Student List</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                    <div class="visible-xs clearfix form-group-margin"></div>
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-sm-12">   <div class="col-sm-2" style="float: right;" id="semest">
            <a href="<?php echo base_url();?>phd_admission/Phd_admission_form" ><input type="button" id="addphd" class="btn btn-primary btn-labeled" value="+Add" > </a>
                            </div></div>
        </div>
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                <div class="panel-heading">
                        <span class="panel-title">
                            <div class="form-group">
                             <div class="col-sm-2" id="">
                                <select name="academic-year" id="academic-year" class="form-control"  onchange="load_courses(this.value);load_batch(this.value)" required>
                                  <option value=""> Academic Year</option>
                                  <?php foreach($academic_year as $ac){ ?>
								                  <option value="<?=$ac['academic_year']?>"><?=$ac['academic_year']?>-<?php  echo  substr($ac['academic_year'],-2) + 1;  ?></option>
                                 <?php }?>
                                  </select>
                             </div>
                                <div class="col-sm-2" id="">
                                <select name="batch" id="batch" class="form-control"  required>
                                  <option value="">Select Batch</option>
                                  </select>
                             </div>
                              <div class="col-sm-2">
                                <select name="admission-course" id="admission-course" class="form-control" onchange="load_streams(this.value)" >
                                <option value="">Select Course</option>
                                </select>
                              </div>
                              <div class="col-sm-3" id="semest">
                                <select name="admission-branch" id="admission-branch" class="form-control" >
                                  <option value="">Select Stream</option>
                                  </select>
                              </div>
                               <div class="col-sm-2" id="">
                                <select name="admission-year" id="admission-year" class="form-control" >
                                  <option value="">Select Year</option>
                                  </select>
                             </div>
                              <div class="col-sm-2 pull-right" style="margin-top:10px;" id="semest">
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
									<th>Admission-cycle</th>
								    <th>Admission-Type</th>
								     <th>Academic-Year</th>
									<th>Gender </th>
                                    <th>DOB</th>
                                    <th>Mobile</th>
									<th>Category</th>	
                                    <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php
                            $j=1;                            
                            for($i=0;$i<count($emp_list);$i++)
                            {
                              if($emp_list[0]['admission_year']=='4') $adtype="PHD with Jr.Fellowship"; else $adtype= "PHD without Jr.fellowship";
                                
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
								<td><?=$emp_list[$i]['admission_cycle']?></td> 
                <td><?=$adtype?></td>                
                  <td><?=$emp_list[$i]['academic_year'];?></td> 
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
                                <td><?=$emp_list[$i]['category'];?></td>
                                <td>
                                    
				<a  href="<?php echo base_url()."phd_admission/view_studentFormDetails/".$emp_list[$i]['stud_id'].""?>" title="View" target="_blank"><i class="fa fa-eye"></i>  </a>&nbsp;&nbsp;&nbsp;&nbsp;
				<a  target="_blank" href="<?php echo base_url()."phd_admission/edit_personalDetails/".$emp_list[$i]['stud_id'].""?>" title="Edit"><i class="fa fa-edit"></i> </a>&nbsp;&nbsp;&nbsp;&nbsp;
                             </td>
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
<div id="wait" style="display:none;width:40px;height:40px;position:absolute;top:50%;left:50%;z-index:99999;"><img src='<?=site_url()?>assets/images/demo_wait_b.gif' width="64" height="64" /><br>Loading..</div>
<script>

 $(document).ajaxStart(function(){
    $("#wait").css("display", "block");
});

$(document).ajaxComplete(function(){
    $("#wait").css("display", "none");
}); 
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
  /* $("div.holder").jPages
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
        }); */
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

	 $('#admission-branch').change(function () {
        var admission_stream = $("#admission-branch").val();
		var academic_year = $("#academic-year").val();
		if (admission_stream) {
			$.ajax({
				'url' : base_url + 'phd_admission/load_years_for_studentlist',
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