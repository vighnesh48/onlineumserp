
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
        <li class="active"><a href="#">Employee Mobiles Details</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Employee Mobiles Details</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">                               
                           
                        </div>                    
                     </div>
            </div>
      
        
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">

<div class="panel-heading" style="padding-top:5px;padding-bottom:5px;!important">
                        <span class="panel-title">
                              <div class="row">
                                <ul class="nav nav-pills bs-tabdrop-example">
                                            <li class="active"><a href="#mb" data-toggle="tab">Mobile Bill</a></li>
                                            <li><a href="#ml" data-toggle="tab">Mobile List</a></li>
                                           
                               </ul>
                            </div>
                       </span>
                    </div>
                      <div class="tab-content" style="padding:0px">
  <div class="tab-pane" id="ml">     
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
<div class="col-md-3 pull-right clearfix form-group-margin">
<?php if(in_array("Add",$my_privileges)){ ?>
 <a  class="btn btn-primary btn-labeled" href="<?=base_url($currentModule."/emp_mobile_master_add")?>"><span class="btn-label icon fa fa-plus"></span>Add </a>
<?php } ?>
</div>
                </div>
                </div>
                </div>

               </div>
                      <div class="panel-body table-info" style="height: 1020px;overflow-y: scroll;">
                    <div class="">    
                   <span id="flash-messages" style="color:red;padding-left:110px;"><?php echo $this->session->flashdata('message1'); ?></span>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                    <th>#</th>
                                    <th>Emp.ID</th>
                                    <th>Name</th>
                                    <th>Department</th>
                                    <th>School</th>                                 
                                    <th>Mobile No</th>
                                    <th>Limit</th>  
                                    <th>Deduction Req.</th>                                
                                    <th>Action</th>
                                    
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php
                            if(!empty($mobile_list)){
                            $j=1;            
                            
                            $ci =&get_instance();
   $ci->load->model('admin_model');
                            for($i=0;$i<count($mobile_list);$i++)
                            {
                              $department =  $ci->admin_model->getDepartmentById($mobile_list[$i]['department']); 
                                 $school =  $ci->admin_model->getSchoolById($mobile_list[$i]['emp_school']); 
                                  $shift =  $ci->admin_model->getshifttime($mobile_list[$i]['shift']); 
                            ?>
                                                        
                            <tr>
                            <td><?=$j?></td> 
                                 <?php if($mobile_list[$i]['gender'] == 'male'){ $m = 'Mr.'; }elseif($mobile_list[$i]['gender'] == 'female'){ $m='Mrs.'; } ?>
                                <td><?=$mobile_list[$i]['emp_id']?></td> 
                               <td><?=$m." ".$mobile_list[$i]['fname']." ".$mobile_list[$i]['lname']?></td>
                                <td><?=$department[0]['department_name']?></td>
                                <td><?=$school[0]['college_code']?></td>
                                                           
                                <td><?=$mobile_list[$i]['mobile'];?></td>                                
                                <td><?=$mobile_list[$i]['mobile_limit'];?></td>                                
                            <td><?php if($mobile_list[$i]['allow_for_Deduct']=='Y'){echo "Y"; }else{ echo "N"; } ?></td>
                                <td>
                                <?php if(in_array("Edit",$my_privileges)){ ?>
                                <a href="<?=base_url($currentModule.'/employee_mobile_master_update/'.$mobile_list[$i]['mob_id'].'')?>" title="Edit"><i class="fa fa-edit"></i></a>
                                <?php } if(in_array("Delete",$my_privileges)){ ?>
                                <a href="<?=base_url($currentModule.'/employee_mobile_master_delete/'.$mobile_list[$i]['mob_id'].'')?>" title="Delete"><i class="fa fa-trash-o"></i></a>
                                <?php } ?>
                                </td>
                            </tr>
                            <?php
                            $j++;
                            }}else{
                                echo"<tr><td colspan='19'><label style='color:red'>Sorry No record Found.</label></td></tr>";
                            }
                            ?>                            
                        </tbody>
                    </table>                    
                   
                    <?php if(in_array("Show Report",$my_privileges)){ ?>
                    <div >
                <div class="col-md-5"></div>
                                <div class="col-md-2">
                <form method="POST" action="<?=base_url($currentModule."/export_mobile_list")?>">
               
                            <button type="submit" class="btn btn-primary form-control" >Excel
                                    </button><br/>      
                                    </form>
                                    </div>      
                </div><?php } ?>
                </div>
                </div>


  </div>
    <div class="tab-pane active" id="mb">     

                <div class="panel-heading">
                      <div class="row">
                <div class="col-md-3" class="form-control">
                <h4>
                For the Month of <span id="mon"><b><?php 
                date_default_timezone_set('Asia/Kolkata');
              
			   $st = $mon;
                if($st != '-'){
                echo date('F Y',strtotime($st)); 
                }else{
                    echo date('F Y');
                }?></b></span></h4>
                </div>
                <div class="col-md-9">
                <div class="row">
                <label class="col-sm-2 text-right">Month: </label>
               <div class="col-md-4" >
<input type="text" id="month" name="month" class="form-control monthPicker" value="<?php echo $mon; ?>"/> 
</div>
<div class="col-md-4"><input type="button" id="find" onclick="search_emp_bill()"  class="btn btn-primary" value="Search"></div>

<div class="col-sm-2 pull-right">
<?php if(in_array("Add",$my_privileges)){ ?><a  class="btn btn-primary btn-labeled" href="<?=base_url($currentModule."/employee_mobile_bill_add")?>"><span class="btn-label icon fa fa-plus"></span>Add </a><?php } ?></div>

                </div>
                </div>
                </div>  
                        
                </div>
                <div class="panel-body" style="height: 1020px;overflow-y: scroll;">
                    <div class="table-info" >    
                     <form name="upform" id="upform"  method="POST" action="<?=base_url($currentModule."/update_mob_bill_list")?>">
                    <input type="hidden" name="smon" value="<?php echo $mon; ?>" />
                    <table class="table table-bordered" style="width:100%;">
                        <thead>
                            <tr><?php if($upflag=='1'){ ?>  
                            <th></th> <?php } ?>
                                    <th>#</th>
                                    <th>Emp.ID</th>
                                    <th>Name</th><th>School</th>                                   
<th>Department</th>
<th>Mobile No</th>	
<th>Limit</th>									
                                    <th>Bill Amt</th>
                                    <th>Dedt.Amt</th>
																
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php //print_r($mobile_bill);
							 date_default_timezone_set('Asia/Kolkata'); 
                            // print_r($mobile_bill);
							if(!empty($mobile_bill)){
                            $j=1;    
$ci =&get_instance();
   $ci->load->model('admin_model');							
                            for($i=0;$i<count($mobile_bill);$i++)
                            {          
$department =  $ci->admin_model->getDepartmentById($mobile_bill[$i]['department']); 
								 $school =  $ci->admin_model->getSchoolById($mobile_bill[$i]['emp_school']); 
						
                            ?>							 							
                            <tr id="trl_<?php echo $mobile_bill[$i]['mob_bill_id']; ?>">
                             <?php if($upflag=='1'){ ?>  
                             <td><input type="checkbox" name="empmob[]"  id="empmob_<?=$mobile_bill[$i]['mob_bill_id']?>" onclick="display_update(<?=$mobile_bill[$i]['mob_bill_id']?>)" value="<?=$mobile_bill[$i]['mob_bill_id']?>" /> </td>   
                          <?php } ?>
                                <td><?=$j?></td>                                  
                                <td id="empid_<?=$mobile_bill[$i]['emp_id']?>"><?php if($mobile_bill[$i]['type']=='A'){
									echo "--";
								}else{
									echo $mobile_bill[$i]['emp_id'];
								}?></td> 
                                <td  id="empn_<?=$mobile_bill[$i]['emp_id']?>"><?
								if($mobile_bill[$i]['type']=='A'){
									echo "For All";
								}else{
									if($mobile_bill[$i]['gender']=='male'){echo 'Mr.';}else if($mobile_bill[$i]['gender']=='female'){ echo 'Mrs.';}
								echo ucfirst($mobile_bill[$i]['lname'])." ".ucfirst($mobile_bill[$i]['fname']); }?></td>                                                                
                                       <td><?php echo $school[0]['college_code'];  ?> </td>                          
                                  <td ><?php echo $department[0]['department_name'];?> </td>
								 
							<td><?php echo $mobile_bill[$i]['mobile']; ?></td>      
<td class='mobl'><?php echo $mobile_bill[$i]['mobile_limit']; ?></td>        							
                               <?php if($upflag=='1'){ ?>  
                                <td><input type="text" class='mob' style="width:100px;" onblur="calculate_amt(<?=$mobile_bill[$i]['mob_bill_id']?>);" disabled name="billamt_<?=$mobile_bill[$i]['mob_bill_id']?>" id="billamt_<?=$mobile_bill[$i]['mob_bill_id']?>" value="<?=$mobile_bill[$i]['bill_amount'];?>" /></td>                                
                                <td ><input type="text" style="width:100px;" disabled name="detamt_<?=$mobile_bill[$i]['mob_bill_id']?>" id="detamt_<?=$mobile_bill[$i]['mob_bill_id']?>" value="<?php echo $mobile_bill[$i]['deduction_amount']; ?>" /></td> 								
                                 <?php }else{ ?>
 
 <td><?=$mobile_bill[$i]['bill_amount'];?> </td>
 <td><?php echo $mobile_bill[$i]['deduction_amount']; ?> </td>
 

                                 <?php } ?>                                               
                              
                            </tr>
                            <?php
                            $j++;
                            }}else{
						echo"<tr><td colspan='19'><label style='color:red'>Sorry No record </label></td></tr>";
							}
                            ?>                            
                        </tbody>
                    </table>                    
                     <?php if($upflag=='1'){ ?>  
                      <div>
                <div class="col-md-5"></div>
                <div class="col-md-2">
<button type="submit" class="btn btn-primary form-control" >Update
                                    </button></div></div>
                                    <?php } ?>
                    </form>
                </div>
                <?php if(in_array("Show Report",$my_privileges)){ ?>
				<div >
                <div class="col-md-5"></div>
                				<div class="col-md-2">
				<form method="POST" action="<?=base_url($currentModule."/export_excel_mobile_bill")?>">
				<input type='hidden' name="rmon" value="<?php echo $mon; ?>" />
							<button type="submit" class="btn btn-primary form-control" >Excel
                                    </button><br/>		
									</form>
									</div>		
				</div><?php } ?> </div>
                </div>
            </div>
            </div>    
        </div>
    </div>
</div>
</div>

<script>
function display_update(em){
    //alert(em);
    if($("#empmob_"+em).is(':checked')) {
 $('#billamt_'+em).prop('disabled',false);
 $('#detamt_'+em).prop('disabled',false);
$('#trl_'+em).css('background-color','#D2D2D2');

    }else{
    $('#billamt_'+em).prop('disabled',true);
        $('#trl_'+em).css('background-color','#FFFFFF');
$('#detamt_'+em).prop('disabled',true);
    }
}
  function search_emp_bill(){
    var month = $('#month').val();    
          url= "<?php echo base_url().$currentModule; ?>/emp_mobile_bill_list/"+month;
          window.location = url;
}
function calculate_amt(mob){
    //alert(mob);
 var ml = $('#trl_'+mob).closest("tr").find(".mobl").text();
 //alert(ml);
 var amt = $('#trl_'+mob).closest("tr").find(".mob").val();
 if(amt == ''){
     amt = 0;
 }
 var dec = parseInt(amt) - parseInt(ml);
 if(parseInt(dec) < 0 ){
     $('#detamt_'+mob).val('0');
 }else{
     $('#detamt_'+mob).val(dec);
 }
}
$(function () {
    $("#upform").submit(function () {
            
              var favorite = [];
var f = 0;
            $.each($("input[name='empmob[]']:checked"), function(){ 
                            favorite.push($(this).val());
            });           
            fLen = favorite.length;
            if(fLen == '0'){
                alert('Select atleast one employee.');
                return false;
            }
            
     });
    $('.monthPicker').datepicker({
       autoclose: true,
    minViewMode: 1,
    format: 'yyyy-mm'        
    });
});
   

</script>