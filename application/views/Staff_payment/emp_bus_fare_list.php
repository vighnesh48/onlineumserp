<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<?php// print_r($all_emp_basicsal);?>
<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<script src="<?=base_url()?>assets/javascripts/moment.js"></script>

<style>
.view-btn{padding:0px;}
.view-btn i{padding: 3px 0;list-style:none;width:35px;text-align: center;color:#fff;background:#4bb1d0;xpadding: 5px 10px;margin:2px;}
.view-btn i a{color:#fff;font-weight:bold;}
</style>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Staff Payment</a></li>
        <li class="active"><a href="#">Bus Facility Entry </a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Bus Facility Entry</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                    <?php //if(in_array("Add", $my_privileges)) { ?>
                     <div class="col-sm-2 pull-right clearfix form-group-margin"><a  class="btn btn-primary btn-labeled" href="<?=base_url($currentModule."/emp_bus_fare_add")?>"><span class="btn-label icon fa fa-plus"></span>Add </a></div>
                    <?php// } ?>                       
                        </div>                    
                     </div>
            </div>   
        
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
         <div class="panel-heading"> 

 <div class="row">
                <div class="col-md-6" class="form-control">
                <h4>
               </h4>
                </div>
                <div class="col-md-6">
                <div class="row">
                
               <div class="col-md-6" >
</div>
<div class="col-md-3">
</div>
                </div>
                </div>
                </div>

               </div>
                <div class="panel-body" style="height: 1020px;overflow-y: scroll;">
                    <div class="table-info" >    
                                                    <span id="flash-messages" style="color:red;padding-left:110px;"><?php echo $this->session->flashdata('message1'); ?></span>

                    <table class="table table-bordered" style="width:100%;">
                        <thead>
                            <tr>
                                    <th>#</th>
                                    <th>Emp.ID</th>
                                    <th>Name</th><th>School</th>                                   
<th>Department</th>
<th>Bus Fare</th>                            
			<th>Action</th>													
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php //print_r($busfare_list);
							 date_default_timezone_set('Asia/Kolkata'); 
							if(!empty($busfare_list)){
                            $j=1;    
$ci =&get_instance();
   $ci->load->model('admin_model');							
                            for($i=0;$i<count($busfare_list);$i++)
                            {          
$department =  $ci->admin_model->getDepartmentById($busfare_list[$i]['department']); 
								 $school =  $ci->admin_model->getSchoolById($busfare_list[$i]['emp_school']); 
						
                            ?>							 							
                            <tr>
                                <td><?=$j?></td>                                  
                                <td id="empid_<?=$busfare_list[$i]['emp_id']?>"><?php if($busfare_list[$i]['type']=='A'){
									echo "--";
								}else{
									echo $busfare_list[$i]['emp_id'];
								}?></td> 
                                <td  id="empn_<?=$busfare_list[$i]['emp_id']?>"><?
								if($busfare_list[$i]['type']=='A'){
									echo "For All";
								}else{
									if($busfare_list[$i]['gender']=='male'){echo 'Mr.';}else if($busfare_list[$i]['gender']=='female'){ echo 'Mrs.';}
								echo ucfirst($busfare_list[$i]['lname'])." ".ucfirst($busfare_list[$i]['fname']); }?></td>                                                                
                                       <td><?php echo $school[0]['college_code'];  ?> </td>                          
                                  <td ><?php echo $department[0]['department_name'];?> </td>
								 
							<td><?php echo $busfare_list[$i]['bus_fare']; ?></td>    
							<td>
							<a href="<?=base_url($currentModule.'/emp_bus_fare_update/'.$busfare_list[$i]['bus_id'].'')?>" title="Edit"><i class="fa fa-edit"></i></a>
								<a href="<?=base_url($currentModule.'/emp_busfare_delete/'.$busfare_list[$i]['bus_id'].'')?>" ><i class="fa fa-trash-o"></i></a>
							</td>                                                                   
                              
                            </tr>
                            <?php
                            $j++;
                            }}else{
						echo"<tr><td colspan='5'><label style='color:red'>Sorry No records found. </label></td></tr>";
							}
                            ?>                            
                        </tbody>
                    </table>                    
                    <?php //} ?>
                </div>
				<div>
                <div class="col-md-5"></div>
				<div class="col-md-2">
				<form method="POST" action="<?=base_url($currentModule."/export_excel_busfare")?>">
				<input type='hidden' name="rmon" value="<?php echo $mon; ?>" />
							<button type="submit" class="btn btn-primary form-control" >Excel
                                    </button>		
									</form>
									</div>		
				</div>
                </div>
            </div>
            </div>    
        </div>
    </div>
</div>


<script>
  function search_emp_bill(){
    var month = $('#month').val();    
          url= "<?php echo base_url().$currentModule; ?>/emp_busfare_list_list/"+month;
          window.location = url;
}
$(function () {
    $('.monthPicker').datepicker({
       autoclose: true,
    minViewMode: 1,
    format: 'yyyy-mm'        
    });
});
   

</script>