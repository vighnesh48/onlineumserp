<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<script src="<?=base_url()?>assets/javascripts/moment.js"></script>

<?php// print_r($all_emp_leave);?>
<style type="text/css">
    
.table{width:100%;}
</style>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Leaves</a></li>
        <li class="active"><a href="#">Employee C-OFF List</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Employee C-OFF list</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
         	<?php $id=$this->session->userdata('role_id'); 
									if($id =='1' || $id=='11'){ ?>
                    <div class="pull-right col-xs-12 col-sm-auto"><a style="width: 100%;" class="btn btn-primary btn-labeled" href="<?=base_url($currentModule."/employee_coff_add")?>"><span class="btn-label icon fa fa-plus"></span>Credit C-Off </a></div>                        
                    <div class="visible-xs clearfix form-group-margin"></div>
                    <?php } ?>
                    <?php //if(in_array("Search", $my_privileges)) { ?>
                
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
               <div class="panel-heading "> 
                <div class="row">
                <div class="col-md-6" class="form-control">
                <h4>
                For the Month of <span id="mon"><b><?php 
                date_default_timezone_set('Asia/Kolkata');
                //echo $mon;
                $ex = explode('-',$mon);
                $st = $ex[1].'-'.$ex[0];
                if($st != '-'){
                echo date('F Y',strtotime($st)); 
                }else{
                    echo date('F Y');
                }?></b></span></h4>
                </div>
                <div class="col-md-6">
                <div class="row">
                <label class="col-sm-3 text-right">Month: </label>
               <div class="col-md-6" >
<input type="text" id="month" name="month" class="form-control monthPicker" value="<?php echo $mon; ?>"/> 
</div>
<div class="col-md-3"><input type="button" id="find" onclick="search_emp_leves()"  class="btn btn-primary" value="Search">
</div>
                </div>
                </div>
                </div></div>
                <div class="panel-body" style="overflow-x:scroll;height:700px;">
                    <div class="table-info">    
                   
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                    <th>#</th>
                                    <th>Emp.ID</th>
                                    <th>Name</th>
									<?php $id=$this->session->userdata('role_id'); 
									if($id =='1' || $id=='11'){
									    	echo "<th>School</th>";		
										echo "<th>Department</th>";
									}
									?>
									<th>Date</th>
                                    <th>Status</th>
									<th>Credited by</th>
									<th>Credited On</th>
                                    <th>Added By</th>
									<?php 	if($id =='1'){ ?>
                                    <th>Action</th>
									<?php } ?>
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php
							date_default_timezone_set("Asia/Kolkata");
							
							$ci =&get_instance();
   $ci->load->model('admin_model');
   //print_r($coffleave);
							if(!empty($coffleave)){
                            $j=1;                            
                            for($i=0;$i<count($coffleave);$i++)
                            {
                                
							?>
														
                            <tr>
							<td><?=$j?></td> 
                                 
                              <td><?=$coffleave[$i]['emp_id'];?></td> 
                                <td><?php if($coffleave[$i]['gender']=='male'){echo 'Mr.';}else if($coffleave[$i]['gender']=='female'){ echo 'Mrs.';} echo $coffleave[$i]['fname']." ".$coffleave[$i]['lname']; ?></td>
                                 <?php if($id =='1' || $id=='11'){
								  $department =  $ci->admin_model->getDepartmentById($coffleave[$i]['department']); 
								 $school =  $ci->admin_model->getSchoolById($coffleave[$i]['emp_school']); 
								 	echo "<td>".$school[0]['college_code']."</td>";	
								   echo "<td>".$department[0]['department_name']."</td>";
									
							   }?>
							   <td><?=date('d-m-Y',strtotime($coffleave[$i]['date']));?></td>            
                                <td><?=$coffleave[$i]['status'];?></td>                                
                                <td><?=$coffleave[$i]['credited_by'];?></td>                                
                               	<td><?=date('d-m-Y',strtotime($coffleave[$i]['inserted_datetime1']));?></td>  							
                                    <td><?php 
$un = $this->leave_model->get_username($coffleave[$i]['inserted_by']);
                                    echo $un[0]['username'];?></td>    
                                     <?php 	if($id =='1' || $id=='11'){ ?>                                          
                                <td><a href="<?=base_url($currentModule.'/employee_coff_update/'.$coffleave[$i]['id'].'')?>" title="Edit"><i class="fa fa-edit"></i></a>
								 <?php 	} ?>
                                </td>
                            </tr>
                            <?php
                            $j++;
                            }}else{
								echo"<tr><td colspan='19'><label style='color:red'>Sorry No record of Employee's C-OFF leaves.</label></td></tr>";
							}
                            ?>                            
                        </tbody>
                    </table> 
                    <div class="col-md-6"></div> <div class="col-md-2">  <button id="taexport" class="btn-primary btn">Export</button></div>         
                     
                    <?php //} ?>
                </div>
                </div>
            </div>
            </div>    
        </div>
    </div>
</div>
<script>
$('#taexport').click(function(){
    var mon = $('#month').val();
var url  = "<?=base_url().strtolower($currentModule).'/export_emp_leave_coff/'?>"+mon;   
          //alert(url);
          window.location.href = url;
});
  function search_emp_leves(){
    var month = $('#month').val();    
          url= "<?php echo base_url().$currentModule; ?>/employee_coff_list/"+month;
          window.location = url;
}
$(function () {
    $('.monthPicker').datepicker({
       autoclose: true,
    minViewMode: 1,
    format: 'mm-yyyy',
        onClose: function (dateText, inst) {
            var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
            $(this).datepicker('setDate', new Date(year, month, 1));
        }
    });
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