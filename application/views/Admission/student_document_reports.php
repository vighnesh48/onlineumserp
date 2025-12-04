<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<script src="<?=base_url('assets/javascripts')?>/jquery.table2excel.js"></script>
<style>
.loader {
  border: 6px;
  border-radius: 50%;
  border-top: 6px solid pink;
  border-bottom: 6px solid pink;
  width: 90px;
  height: 90px;
  -webkit-animation: spin 2s linear infinite;
  animation: spin 2s linear infinite;
}

@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

</style>

                 <script>


                  function load_courses(){
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
    }
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

               function load_batch(type){
                
                   // alert(type);
                var academic_year = $("#academic-year").val();    
                $.ajax({
                    'url' : base_url + '/Ums_admission/load_batch_student_list',
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
             
         // alert("hi");
             var base_url = 'https://erp.sandipuniversity.com/';
                   // alert(type);
                   var acourse = $("#admission-course").val();
                    var astream = $("#admission-branch").val();
                    var ayear = $("#admission-year").val();
                    var acdyear = $("#academic-year").val();
                    
                    //var batch = $("#batch").val();

                    if(acdyear=='')
                    {
                        alert("Please Select academic year");
                        return false;
                    }
                    
                    if(acourse=='')
                    {
                        alert("Please Select Course");
                        return false;
                    }
                    
                    
                   /* if(astream=='')
                    {
                          alert("Please Select Stream");
                        return false;
                        
                    }*/
                    
                    /*if(ayear=='')
                    {
                          alert("Please Select Year");
                        return false;
                        
                    }*/
                     $("#loader1").html('<div class="loader"></div>');
                $.ajax({
                    'url' : base_url + '/Ums_admission/load_studentlist_with_document',
                    'type' : 'POST', //the way you want to send data to your URL
                    'data' : {'astream':astream,'ayear':ayear,'acdyear':acdyear,acourse:acourse},
                    'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
                
                    
                        var container = $('#stddata'); //jquery selector (get element by id)
                        if(data){
                            
                        // alert(data);
                            //alert("Marks should be less than maximum marks");
                            //$("#"+type).val('');
                            container.html(data);
                             $("#loader1").html("");
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
        <li class="active"><a href="#">Student Document reports</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Student Document reports</h1>
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
                                <select name="academic-year" id="academic-year" onchange="load_courses(this.value)"class="form-control" required>
                                  <option value=""> Academic Year</option>
								  <option value="2021">2021-22 </option>
								  <option value="2020">2020-21 </option>
                                   <option value="2019">2019-20 </option>
                                   
                                  </select>
                             </div>
                           <!--    <div class="col-sm-2" id="">
                                <select name="batch" id="batch" class="form-control"  required>
                                  <option value="">Select Batch</option>
                                 
                                   
                                  </select>
                             </div> -->
                              <div class="col-sm-2">
                                <select name="admission-course" id="admission-course" class="form-control" onchange="load_streams(this.value)" required>
                                <option value="">Select Course</option>
                                </select>
                              </div>
                             
                            <!--  <label class="col-sm-2">Stream<sup class="redasterik" style="color:red">*</sup></label>-->
                              <div class="col-sm-3" id="semest">
                                <select name="admission-branch" id="admission-branch" class="form-control" required>
                                  <option value="">Select Stream</option>
                                  </select>
                              </div>
                               <div class="col-sm-2" id="">
                                <select name="admission-year" id="admission-year"  class="form-control" required>
                                  <option value="">Select Year</option>
                                   <option value="1">1 </option>
                                   <option value="2">2 </option>
                                   <option value="3">3 </option>
                                   <option value="4">4 </option>
                                  </select>
                             </div>

                            
                             
                        
                             
                              <div class="col-sm-2 pull-right" style="margin-top:10px;" id="semest">
                                 <input type="button" id="sbutton" class="btn btn-primary btn-labeled" value="Search" > 
                            </div>
                           
                             <!--<div class="col-sm-3" id="semest">
                               <a href="<?=base_url()?>Ums_admission/generateallpdfs">  <input type="button" id="" class="btn btn-primary btn-labeled" value="Generate All" > </a>
                            </div>-->
                            </div>
                              <center><div id="loader1"></div> </center>
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
	
	res = id.split("~");
	var detain =res[0];
	var stud_id =res[1];
	if(confirm("Are you sure to Generate GPA?")){
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




<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.3.1/css/buttons.dataTables.min.css">

<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>


<script>
$(document).ready(function() {

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

   $('#example').DataTable( {
        dom: 'Bfrtip',
        targets: 'no-sort',
bSort: false,
     bPaginate: false,
        buttons: [
            
            {
                extend: 'excelHtml5',
                title: 'Student documents list'
            },
            
        ]
    } );
} );
</script>


