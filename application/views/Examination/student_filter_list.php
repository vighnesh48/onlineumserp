<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<script src="<?=base_url('assets/javascripts')?>/jquery.table2excel.js"></script>

          
<?php 
if(isset($role_id) && $role_id==1 ){
?>
<style>
	.table{width: 150%;}
	table{max-width: 150%;}
	
             td {width:25% }
</style>									
<?php }else{ ?>
	<style>
	table.dataTable{width: 210%;}</style>
<?php }?>

<style>

</style>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Examination</a></li>
        <li class="active"><a href="#">Total
										<?php
										  if($is_of==0){
											  echo "All";
										  }
										  else  if($is_of==1){
											  echo "Applied";
										  }
										    else  if($is_of==2){
											  echo " Not Applied";
										  }
										
										
										?>
										Student  List:</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;<?php
										  if($is_of==0){
											  echo "All";
										  }
										  else  if($is_of==1){
											  echo "Applied";
										  }
										    else  if($is_of==2){
											  echo " Not Applied";
										  }
										
										
										?> Student List</h1>
           
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
                            
                        </span>
                        <div class="holder1"></div>
                </div>

            <div class="table-info panel-body"  style="overflow:scroll;height:800px;">  
			
			
                <div class="col-lg-12">
                    <div class="table-info" id="stddata" >    
				
			
                      <table class="table table-bordered" id="table2excel">
                        <thead>
                            <tr>
                                   
                                    <th>Sr.No</th>
									<th>School name</th>
									<th>Stream Name</th>
									<th>Semester</th>
									<th>PRN</th>
									<th>Name</th>
									<th>Mobile</th>
									<th>Actual Fees</th>
									<th>Scholorship</th>
									<th>Applicable Fees</th>
									<th>Opening Balance</th>
									<th>Charges</th>
									<th>Other Fees</th>
		                            <th>Refund</th>
									<th>Paid Fees</th>
									<th>Pending Fees</th>
                                    
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php $x=1; if(! empty($summary_list)){ 
							$ref=0;$other=0;$pending=0;
		           for($i=0;$i<count($summary_list);$i++){	?>	 
				<tr>

					<td><?php echo $x; 
					$exam_data=explode('-', $exam_session);
					$other=$summary_list[$i]['opening_balance']+$summary_list[$i]['cancel_charges'];
			        $pending=($summary_list[$i]['applicable_total']+$other+$summary_list[$i]['refund'])-$summary_list[$i]['fees_total'];
					?></td>
					<td> <?=$summary_list[$i]['school_short_name']; ?> </td>
					<td><?=$summary_list[$i]['stream_short_name']; ?></td>
					<td><?=$summary_list[$i]['current_semester']; ?></td>
					<td><?=$summary_list[$i]['enrollment_no']; ?></td>
					<td><?=$summary_list[$i]['first_name']." ".$summary_list[$i]['last_name']; ?></td>
					<td><?=$summary_list[$i]['mobile']; ?></td>
					<td><?=$summary_list[$i]['actual_fees']; ?></td>
					<td><?=(int)$summary_list[$i]['actual_fees']-(int)$summary_list[$i]['applicable_total']; ?></td>
					<td><?=$summary_list[$i]['applicable_total']; ?></td>
					<td><?=$summary_list[$i]['opening_balance']?></td>
					<td><?=$summary_list[$i]['cancel_charges']?></td>
					<td><?=$other?></td>
					 <td><?=$summary_list[$i]['refund']?></td>
					<td><?=$summary_list[$i]['fees_total']; ?></td>
					<td><?=	$pending?></td>
				
				</tr>
	
	
		
			<?php $x++;
					} } ?>           
                        </tbody>
                    </table>  
                     <input type="button" id="expdata" value="Export as Excel" class="btn btn-primary btn-labeled">
                    
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
$("#expdata").click(function(){

  $("#table2excel").table2excel({

    exclude: ".noExl",

    name: "Worksheet Name",
   filename:  "<?php if($is_of==0){ echo 'All  Student List'; } else  if($is_of==1){ echo 'Applied  Student List'; }else  if($is_of==2){ echo 'Not Applied  Student List';}	?>" //do not include extension

  });

});
   
} );
</script>