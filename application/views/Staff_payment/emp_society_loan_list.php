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
        <li class="active"><a href="#">Co-Society Loan List</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Co-Society Loan List</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                    <?php //if(in_array("Add", $my_privileges)) { ?>
                     <div class="col-sm-2 pull-right clearfix form-group-margin"><a  class="btn btn-primary btn-labeled" href="<?=base_url($currentModule."/emp_society_loan_add")?>"><span class="btn-label icon fa fa-plus"></span>Add </a></div>
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
                <h4>Employee List
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
                    <?php //if(in_array("View", $my_privileges)) { ?>
                    <table class="table table-bordered" style="width:100%;">
                        <thead>
                            <tr>
                                    <th>#</th>
                                    <th>Emp.ID</th>
                                    <th>Name</th><th>School</th>                                   
<th>Department</th>
<th>Loan Amt</th>  
<th>Period</th>        
<th>Dect. Amt</th>                  
			<th>Action</th>													
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php //print_r($society_loan_list);
							 date_default_timezone_set('Asia/Kolkata'); 
							if(!empty($society_loan_list)){
                            $j=1;    
$ci =&get_instance();
   $ci->load->model('admin_model');							
                            for($i=0;$i<count($society_loan_list);$i++)
                            {          
$department =  $ci->admin_model->getDepartmentById($society_loan_list[$i]['department']); 
							$school =  $ci->admin_model->getSchoolById($society_loan_list[$i]['emp_school']); 
						
                            ?>							 							
                            <tr>
                                <td><?=$j?></td>                                  
                                <td id="empid_<?=$society_loan_list[$i]['emp_id']?>"><?php if($society_loan_list[$i]['type']=='A'){
									echo "--";
								}else{
									echo $society_loan_list[$i]['emp_id'];
								}?></td> 
                                <td  id="empn_<?=$society_loan_list[$i]['emp_id']?>"><?
								if($society_loan_list[$i]['type']=='A'){
									echo "For All";
								}else{
									if($society_loan_list[$i]['gender']=='male'){echo 'Mr.';}else if($society_loan_list[$i]['gender']=='female'){ echo 'Mrs.';}
								echo ucfirst($society_loan_list[$i]['lname'])." ".ucfirst($society_loan_list[$i]['fname']); }?></td>                                                               
                                       <td><?php echo $school[0]['college_code'];  ?> </td>                       
                                  <td ><?php echo $department[0]['department_name'];?> </td>
								 
							<td><?php echo $society_loan_list[$i]['loan_amount']; ?></td> 
                            <td><?php echo date('M y',strtotime($society_loan_list[$i]['from_month']))." to ".date('M y',strtotime($society_loan_list[$i]['to_month'])); ?></td>
<td><?php echo $society_loan_list[$i]['monthly_deduction']; ?></td>							
							<td>
							<a href="<?=base_url($currentModule.'/emp_society_loan_update/'.$society_loan_list[$i]['soc_id'].'')?>" title="Edit"><i class="fa fa-edit"></i></a>
								<a href="" onclick="delete_emp_society(<?=$society_loan_list[$i]['soc_id']?>)" ><i class="fa fa-trash-o"></i></a>
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
				<div class="col-md-3">
				<form method="POST" action="<?=base_url($currentModule."/export_excel_society_loan")?>">
				
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
  
   function delete_emp_society(eid){
	   var txt;
var r = confirm("Delete the Society deduction of this Employee?");
if (r == true) {
     url= "<?php echo base_url().$currentModule; ?>/emp_society_loan_delete/"+eid;
          window.location = url;
}

   }

</script>