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
        <li class="active"><a href="#">TDS Deduction List</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;TDS Deduction List</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                    <?php if(in_array("Add", $my_privileges)) { ?>
                     <div class="col-sm-2 pull-right clearfix form-group-margin"><a  class="btn btn-primary btn-labeled" href="<?=base_url($currentModule."/emp_tds_bill_add")?>"><span class="btn-label icon fa fa-plus"></span>Add </a></div>
                    <?php } ?>                  
                           
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
                For the Month of <span id="mon"><b><?php 
                date_default_timezone_set('Asia/Kolkata');              
			   $st = $mon;
                if($st != '-'){
                echo date('F Y',strtotime($st)); 
                }else{
                    echo date('F Y');
                }?></b></span></h4>
                </div>
                <div class="col-md-6">
                <div class="row">
                <label class="col-sm-5 text-right">Month: </label>
               <div class="col-md-4" >
<input type="text" id="month" name="month" class="form-control monthPicker" value="<?php echo $mon; ?>"/> 
</div>
<div class="col-md-3"><input type="button" id="find" onclick="search_emp_bill()"  class="btn btn-primary" value="Search">
</div>
                </div>
                </div>
                </div>  
                        
                </div>
                <div class="panel-body" style="height: 1020px;overflow-y: scroll;">
                    <div class="table-info" >    
                    <form name="upform" id="upform"  method="POST" action="<?=base_url($currentModule."/update_tds_list")?>">
                    <table class="table table-bordered" style="width:100%;">
                        <thead>
                            <tr> <?php if($upflag=='1'){ ?><th><input type="checkbox" name="chk_stud_all" id="chk_stud_all"></th><?php } ?>
							

                                    <th>#</th>
                                    <th>Emp.ID</th>
                                    <th>Name</th><th>School</th>                                   
<th>Department</th>
<th>Amt</th>	
                                    <th>Action</th>
																
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php //print_r($tds_list);
							 date_default_timezone_set('Asia/Kolkata'); 
							if(!empty($tds_list)){
                            $j=1;    
			$cnt = count($tds_list);
                            for($i=0;$i<$cnt;$i++)
                            {          
                       ?>	
                       <input type="hidden" name="tdsid_<?php echo $tds_list[$i]['emp_id']; ?>"  value="<?php echo $tds_list[$i]['tds_id']; ?>" />
                                <input type="hidden" name="cmon" value="<?php echo $mon;?>" />                                          
                        						 							
                            <tr id="trl_<?=$tds_list[$i]['emp_id']?>">
                            <?php if($upflag=='1'){ ?>
                            <td><input type="checkbox" class="studCheckBox" name="empids[]" id="empids_<?=$tds_list[$i]['emp_id']?>" onclick="display_update(<?=$tds_list[$i]['emp_id']?>)" value="<?=$tds_list[$i]['emp_id']?>" /> </td>   
                               <?php } ?>
                                <td><?=$j?></td>                                  
                                <td id="empid_<?=$tds_list[$i]['emp_id']?>"><?php if($tds_list[$i]['type']=='A'){
									echo "--";
								}else{
									echo $tds_list[$i]['emp_id'];
								}?></td> 
                                <td  id="empn_<?=$tds_list[$i]['emp_id']?>"><?
								if($tds_list[$i]['type']=='A'){
									echo "For All";
								}else{
									if($tds_list[$i]['gender']=='male'){echo 'Mr.';}else if($tds_list[$i]['gender']=='female'){ echo 'Mrs.';}
								echo ucfirst($tds_list[$i]['lname'])." ".ucfirst($tds_list[$i]['fname']); }?></td>                                                                
                                       <td><?php echo $tds_list[$i]['college_code'];  ?> </td>                          
                                  <td ><?php echo $tds_list[$i]['department_name'];?> </td>
								  <?php if($upflag=='1'){ ?>
							<td><input type="text" name="amt_<?php echo $tds_list[$i]['emp_id']; ?>" disabled id="amt_<?php echo $tds_list[$i]['emp_id']; ?>"  value="<?php echo $tds_list[$i]['tds_amount']; ?>" /></td>        
<?php }else{ ?>
<td><?php echo $tds_list[$i]['tds_amount']; ?></td>
<?php } ?>
<td>
<?php if(in_array("Edit", $my_privileges)) { if($upflag=='1'){?>
<a href="<?=base_url($currentModule.'/emp_tds_bill_update/'.$tds_list[$i]['tds_id'].'')?>" title="Edit"><i class="fa fa-edit"></i></a>
<?php }} ?>
								</td>           
                              
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
                                    </button></div></div> <?php } ?>
                    </form>                      
                    <?php //} ?>
                </div>
                <?php if(in_array("Show Report", $my_privileges)) { ?>
				<div>
                <div class="col-md-5"></div>
				<div class="col-md-2">
				<form method="POST" action="<?=base_url($currentModule."/export_excel_tds_list")?>">
				<input type='hidden' name="rmon" value="<?php echo $mon; ?>" />
							<button type="submit" class="btn btn-primary form-control" >Excel
                                    </button>		
									</form>
									</div>		
				</div><?php } ?>
                </div>
            </div>
            </div>    
        </div>
    </div>
</div>


<script>
$('#chk_stud_all').change(function () {
        $('.studCheckBox').prop('checked', $(this).prop('checked'));
    });
function display_update(em){
    //alert(em);
    if($("#empids_"+em).is(':checked')) {
 $('#amt_'+em).prop('disabled',false);
$('#trl_'+em).css('background-color','#D2D2D2');

    }else{
    $('#amt_'+em).prop('disabled',true);
        $('#trl_'+em).css('background-color','#FFFFFF');

    }
}
  function search_emp_bill(){
    var month = $('#month').val();    
          url= "<?php echo base_url().$currentModule; ?>/emp_tds_bill_list/"+month;
          window.location = url;
}
$(function () {
	 $("#upform").submit(function () {
            
              var favorite = [];
var f = 0;
            $.each($("input[name='empids[]']:checked"), function(){ 
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