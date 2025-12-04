<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="<?php echo base_url('assets/javascripts') . '/bootstrap-datepicker.js' ?> "></script>
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
<?php
$reval = $this->session->userdata('reval');
if($reval==0){
    $report_name="PHOTOCOPY";
    $reportName="Photocopy";
}else{
    $report_name="REVALUATION";
    $reportName="Revaluation";
}    
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#"><?=$reportName?></a></li>
        <li class="active"><a href="#"></a></li>
    </ul>
    <div class="page-header">
    	<div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-list page-header-icon"></i>&nbsp;&nbsp;Photocopy / Revaluation List</h1>
            <div class="col-xs-12 col-sm-8">
            </div>
        </div>


        <div class="row ">
            <div class="col-sm-12">&nbsp;</div>
        </div>
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                <div class="panel-heading">                        
                        <div class="holder1"></div>
                </div>

            <div class="table-info panel-body" >  
            	<div id="rgm" style="color:green;margin-left: 15px;"><div id="resp" style="display:none;"><img src='<?=base_url()?>assets/images/demo_wait_b.gif' /></div></div>
			<?php 
			$role_id=$this->session->userdata('role_id');
			?>
           

            <input type="hidden" name="stream_id" value="<?=$stream?>">
			<input type="hidden" name="adm_semester" value="<?=$semester?>">
				<?php// }?>
			
                <div class="col-lg-12">
                    <div class="table-info" id="stddata" style="<?=$tbstyle?>">    
			
 <table class="table table-bordered" id="table2excel">
                        <thead>
                            <tr>
                                   <!--th><input type="checkbox" name="chk_stud_all" id="chk_stud_all"></th-->
                                    <th>S.No.</th>
									<th>PRN.</th>	
                                    <th>Student Name</th>
                                     <th>Semester</th>
									 <th>Stream Name</th> 
									 <?if($reval==0){ ?>
									 <th>Photocopy Fees</th>
            						<?php }else{ ?>
 									<th>Revaluation Fees</th> 	
            						<?php }  ?>
									   
									 
									 <th>No. Subjects</th>
									  <th>Status</th>
                                     <th>Action</th>            
                            </tr>
                        </thead>
                        <tbody id="studtbl">
                        <?php 
                    	$result_data = $school_code.'~'.$stream.'~'.$exam_month.'~'.$exam_year.'~'.$exam_id;
                    	?>
                        	  <input type="hidden" id="res_data" name="res_data" value="<?=$result_data?>">

                            <?php
                           // echo "<pre>";
							//print_r($stream_list);
                          
                            $j=1;  
                            if(!empty($rev_list)){                          
                            foreach ($rev_list as $key => $value) {
                               if($reval==0){
					                $fees =$value['photocopy_fees']; 
					            }else{
					                $fees =$value['reval_fees']; 
					            }  
                            ?>				
                            <tr>
                              <td><?=$j?></td>
                              <td><?=$value['enrollment_no']?></td>
								<td><?=$value['stud_name']?></td> 
								<td><?=$value['semester']?></td> 
								<td><?=$value['stream_short_name']?></td>
								<td><?=$fees?></td>
								<td><?=$value['sub_cnt']?></td>
								<td><?php if(empty($value['amount'])){ ?> <span style="color:red">Not Paid</span>
								<?php }else{?>
								<span style="color:green"><b>Paid</b></span>	
								<?php 
								}?></td>
                                <td><?php if(empty($value['amount'])){ ?><a href="<?=base_url()?>Reval/Payments/<?=$value['stud_id']?>/<?=$exam_id?>" target="_blank"><button class="btn btn-primary" id="v_sd">Pay</button></a>
								<?php }else{?>
								<a href="<?=base_url()?>Reval/Payments/<?=$value['stud_id']?>/<?=$exam_id?>" target="_blank"><button class="btn btn-primary" id="v_sd">View</button>	
								<?php 
								}?>
								</td>
                            </tr>
                            <?php
                            $j++;
                            }
                        }else{
                        	echo "<tr><td colspan='6'>No data found.</td></tr>";
                        }
                            ?>                            
                        
                        </tbody>
                    </table> 
                    <button class="btn-primary" id="ex_list">Excel</button> 	
                    
                </div>
                </div>
                </div>
            </div>
            </div>    
        </div>
    </div>
</div>
<script>

$(document).ready(function () {
    $('#ex_list').on('click', function () {	
    	var stream_id = '<?=$stream?>'
    	var exam_id= '<?=$exam_id?>';
    	window.location.href = '<?= base_url() ?>Reval/excel_applied_list/'+stream_id+'/'+exam_id;
	}); 
});
	
</script>