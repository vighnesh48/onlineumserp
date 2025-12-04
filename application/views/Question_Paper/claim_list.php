<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="<?php echo base_url('assets/javascripts') . '/bootstrap-datepicker.js' ?> "></script>
<script>    

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
        <li class="active"><a href="#">Question Paper Remuneration</a></li>
        <li class="active"><a href="#"></a></li>
    </ul>
    <div class="page-header">
    	<div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-list page-header-icon"></i>&nbsp;&nbsp;Question Paper Remuneration </h1>
            
        </div>


        <div class="row ">
            <div class="col-sm-12">&nbsp;</div>
        </div>
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                

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
									<th>Name of Paper Setter</th>	
                                    <th>Staff ID</th>
                                     <th>Bank Name</th>
									 <th>Bank A/C No</th>  
									 <th>IFSC Code</th>
									 <th>Branch</th>
                                     <th>UG/QP Rs.500</th>            
                                     <th>UG. Total</th>            
                                     <th>PG/QP Rs.700</th>            
                                     <th>PG. Total</th>            
                                     <th>Dip.+ UG+ PG =Total In Rs.</th>            
                            </tr>
                        </thead>
                        <tbody id="studtbl">
                            <?php
                             $CI =& get_instance();
						     $CI->load->model('Question_paper_model');
                            //echo "<pre>";
							//print_r($claim_datas);
                          
                            $j=1;  
                            if(!empty($claim_datas) ){                          
                            foreach ($claim_datas as $key => $value) {

                              $datas = $this->Question_paper_model->get_qp_faculy_data($value['faculty_id']);
                              //echo '<pre>';print_r($datas);exit;
                              $ug_count = 0;
                              $ug_count_total = 0;
                              $pg_count = 0;
                              $pg_count_total = 0;
                              $final_total = 0;

                              foreach($datas as $data){
                                 //echo '<pre>';print_r($data);exit;

                                 if($data['course_type'] == 'UG'){
                                 	$ug_count = $data['count'];
                                 	$ug_count_total = $data['total'];
                                 	$final_total += $data['total'];


                                 }elseif($data['course_type'] == 'PG'){

                                 	$pg_count =  $data['count'];
                                 	$pg_count_total = $data['total'];
                                 	$final_total += $data['total'];


                                 }else{
                                    $final_total +=$data['total'];

                                 }


                              }






                            ?>				
                            <tr>
                              <td><?=$j?></td>
                              <td><?=$value['fname'].' '.$value['mname'].' '.$value['lname']?></td>
							  <td><?=$value['faculty_id']?></td> 
							  <td><?=$value['bank_name']?></td> 
							  <td><?=$value['bank_acc_no']?></td>
							  <td><?=$value['bank_ifsc']?></td>
							  <td><?=$value['branch_name']?></td>
							  <td><?=$ug_count?></td>
							  <td><?=$ug_count_total?></td>
							  <td><?=$pg_count?></td>
							  <td><?=$pg_count_total?></td>
							  <td><?=$final_total?></td>



								
                            </tr>
                            <?php
                            unset($ug_count);
                            unset($ug_count_total);
                            unset($pg_count);
                            unset($pg_count_total);
                            unset($final_total);
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


function validate_student(strm){

	var chk_stud_checked_length = $('input[class=studCheckBox]:checked').length;
	if(chk_stud_checked_length == 0){
		 alert('please check atleast one Student from student list');
		 return false;
	}else{
		return true;
	}
}

$(document).ready(function () {
	$('#chk_stud_all').change(function () {
        $('.studCheckBox').prop('checked', $(this).prop('checked'));
    });
     $('#ex_list').on('click', function () {	
    	//var stream_id = '<?=$stream?>'
    	//var exam_id= '<?=$exam_id?>';
    	window.location.href = '<?= base_url() ?>Question_paper/excel_qp_report/';
	}); 
});
	
</script>