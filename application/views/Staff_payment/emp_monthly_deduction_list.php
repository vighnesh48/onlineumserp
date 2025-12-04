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
        <li class="active"><a href="#">Transaction List</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Transaction List</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                    <?php //if(in_array("Add", $my_privileges)) { ?>
                     <div class="col-sm-2 pull-right clearfix form-group-margin"><a  class="btn btn-primary btn-labeled" href="<?=base_url($currentModule."/emp_monthly_deduction_add")?>"><span class="btn-label icon fa fa-plus"></span>Add </a></div>
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
                <label class="col-sm-5 text-right">Month: </label>
               <div class="col-md-4" >
<input type="text" id="month" name="month" class="form-control monthPicker" value="<?php echo $mon; ?>"/> 
</div>
<div class="col-md-3"><input type="button" id="find" onclick="search_emp_leves()"  class="btn btn-primary" value="Search">
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
                                    <th>Emp.Name</th><th>Type</th>                                   
<th>Deduction OF</th>
<th>Frequency</th>									
                                    <th>Amount</th>
                                    <th>Validity</th>
								
                                    <th>Action</th>									
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php //print_r($deduction_list);
							 date_default_timezone_set('Asia/Kolkata'); 
							if(!empty($deduction_list)){
                            $j=1;                            
                            for($i=0;$i<count($deduction_list);$i++)
                            {                                
                            ?>							 							
                            <tr>
                                <td><?=$j?></td>                                  
                                <td id="empid_<?=$deduction_list[$i]['emp_id']?>"><?php if($deduction_list[$i]['type']=='A'){
									echo "--";
								}else{
									echo $deduction_list[$i]['emp_id'];
								}?></td> 
                                <td  id="empn_<?=$deduction_list[$i]['emp_id']?>"><?
								if($deduction_list[$i]['type']=='A'){
									echo "For All";
								}else{
									if($deduction_list[$i]['gender']=='male'){echo 'Mr.';}else if($deduction_list[$i]['gender']=='female'){ echo 'Mrs.';}
								echo ucfirst($deduction_list[$i]['lname'])." ".ucfirst($deduction_list[$i]['fname']); }?></td>                                                                
                                       <td><?php if($deduction_list[$i]['trans_type']=='CR'){
									  echo "Credits";
								  }elseif($deduction_list[$i]['trans_type']=='DC'){
									  echo 'Debits';
								  }
									  
								  ?> </td>                          
                                  <td class="dedc" id="trans_of_<?=$deduction_list[$i]['emp_id']?>_<?php echo date('M-Y',strtotime($deduction_list[$i]['valid_from']));?>"><?php echo $deduction_list[$i]['trans_of'];?> </td>
								 
							<td><?php if($deduction_list[$i]['frequency']=='1'){
								echo "One Time";
							}elseif($deduction_list[$i]['frequency']=='2'){
								echo "Monthly";
							}
							?></td>                                
                                <td><?=$deduction_list[$i]['amount'];?></td>                                
                                <td ><?php 
								
								if(date('M-Y',strtotime($deduction_list[$i]['valid_from'])) == date('M-Y',strtotime($deduction_list[$i]['valid_to']))){
									echo date('M-Y',strtotime($deduction_list[$i]['valid_from']));
								}else{
									echo date('M-Y',strtotime($deduction_list[$i]['valid_from']))." to ".date('M-Y',strtotime($deduction_list[$i]['valid_to']));
								}?></td> 								
                                                                                
                                <td class="view-btn"><a href="<?=base_url($currentModule.'/emp_monthly_deduction_update/'.$deduction_list[$i]['trans_id'].'')?>" title="Edit"><i class="fa fa-edit"></i></a>
								<a href="#" class="emp_view" id="<?=$deduction_list[$i]['emp_id']?>" data-toggle="modal"  data-target="#myModal"><i class="fa fa-eye"></i></a>
							 								</td>
                            </tr>
                            <?php
                            $j++;
                            }}else{
								echo"<tr><td colspan='19'><label style='color:red'>Sorry No record of Employee's Assigned for Basic Salary Details.</label></td></tr>";
							}
                            ?>                            
                        </tbody>
                    </table>                    
                    <?php //} ?>
                </div>
                </div>
            </div>
            </div>    
        </div>
    </div>
</div>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width:80%;">

    <!-- Modal content-->
    <div class="modal-content" >
       <div class="modal-header">
        <button type="button" class="btn btn-default pull-right" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" >Employee Id: <strong><span id="empid"></span></strong> <span style="margin-left:50px;">Name:</span> <strong><span id="empname"></span></strong>  </h4>
		
      </div>
      <div class="modal-body" >
	  <div class="row table-responsive">
        <table class="table table-bordered"  >
                        <thead>
                            <tr>
							 <th>#</th>
                                    <th>Deduction Of</th>                                    
									<th>Type</th>
                                    <th>Frequency</th>                                                                  
                                    <th>Amount</th>
                                    <th>Validity</th>                                                                
                                    								
                                    <th>Status</th>  
									
                            </tr>
                        </thead>
						<tbody id="emp_cnt">
						
						</tbody>
						</table>
						</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
	</div>
    </div>
<script>
  function search_emp_leves(){
    var month = $('#month').val();    
          url= "<?php echo base_url().$currentModule; ?>/emp_monthly_deduction_list/"+month;
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
   
		$(".emp_view").on('click',function()
        {
            var eid = $(this).attr('id');
		 var trans_of = $(this).closest("tr").find(".dedc").text();
		// alert(id);
            var enam = $('#empn_'+eid).text();
			var edep = $('#empd_'+eid).text();
			var esch = $('#emps_'+eid).text();
			var edepe = $('#empde_'+eid).text();
			var ejoi = $('#empj_'+eid).text();
            var url  = "<?=base_url().strtolower($currentModule).'/get_emp_deduction_history/'?>"+eid+"/"+trans_of;	
         //   var data = {title: search_val};		
         //   var type="";
         //   var type_name="";
            $.ajax
            ({
                type: "POST",
                url: url,
               // data: data,
                dataType: "html",
                cache: false,
                crossDomain: true,
                success: function(data)
                {  
				$("#empid").text(eid);
                   $("#empname").text(enam);
				   $("#sch").text(esch);
				   $("#dep").text(edep);
				   $("#des").text(edepe);
				   $("#joi").text(ejoi);
                        $("#emp_cnt").html(data);
                  
                },
                error: function(data)
                {
                    alert("Page Or Folder Not Created..!!");
                }
            });
        });
</script>