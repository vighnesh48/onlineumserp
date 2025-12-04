<style>
.has-error .form-control {
    border-color: #a94442;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
    box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
}

.has-error .form-control {
    border-color: #ebccd1;
    -webkit-box-shadow: none;
    box-shadow: none;
}

.has-error .form-control {
    border-color: #d38e99;
    -webkit-box-shadow: none;
    box-shadow: none;
}

.has-error .form-control {
    border-color: #a94442;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
    box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
}
.table{width:100%}
table {max-width: 100%;}
.edu-table .form-control{font-size:12px!important}
.edu-table thead tr th{font-size:13px!important}
</style>
<?php
$var_url = $this->uri->segment(2);

if($var_url=='edit_personalDetails'){
    $act_per = 'active';
}else{
    $act_per = '';
}
if($var_url=='edit_addressDetails'){
    $act_add = 'active';
}else{
    $act_add = '';
}
if($var_url=='edit_eduDetails'){
    $act_ed = 'active';
}else{
    $act_ed = '';
}

if($var_url=='edit_docsndcertDetails'){
    $act_dc = 'active';
}else{
    $act_dc = '';
}

if($var_url=='edit_refDetails'){
    $act_ref = 'active';
}else{
    $act_ref = '';
}

if($var_url=='edit_paymentDetails'){
    $act_pay = 'active';
}else{
    $act_pay = '';
}
 $studId = $this->session->userdata('studId');
 $CI =& get_instance();
 $db1=$CI->load->database('umsdb', TRUE);
 $sql = "select sm.academic_year,sm.admission_session from student_master as sm
 left join student_confirm_status as sc ON sc.student_id = sm.stud_id
  where stud_id='" . $studId . "' ";
        $query = $db1->query($sql);
        $stream_details = $query->result_array();
 /*$CI->select("sm.academic_year,sm.admission_session");
		$CI->from('student_master as sm');
		//$DB1->join('vw_stream_details as stm','sm.admission_stream = stm.stream_id','left');
		$CI->join('student_confirm_status as sc','sc.student_id = sm.stud_id','left');
		$CI->where('stud_id', $stud_id);
		$CI->order_by("sm.stud_id", "desc");
		$query=$CI->get();
		$result=$query->result_array();*/
 
//print_r($stream_details);
//exit();
?>
<div class="panel-heading"> <span class="panel-title"><i class="panel-title-icon fa fa-fire text-danger"></i>Details</span>
  <ul class="nav nav-tabs nav-tabs-xs setup-panel">
	<li class="<?=$act_per?>"><a href="<?=base_url()?>Ums_admission/edit_personalDetails/<?=$studId?>">1.Personal Information</a></li>
    <li class="<?=$act_add?>"><a href="<?=base_url()?>Ums_admission/edit_AddressDetails/<?=$studId?>">1.Address Details</a></li>
	<li class="<?=$act_ed?>"><a href="<?=base_url()?>Ums_admission/edit_eduDetails">2.Educational Details</a></li>
    <?php if(($stream_details[0]['academic_year']==ADMISSION_SESSION)&&($stream_details[0]['admission_session']==ADMISSION_SESSION)){?>
	<li class="<?=$act_dc?>"><a href="<?=base_url()?>Ums_admission/edit_docsndcertDetails_provisional">3.Documents & Certificates</a></li>
    <?php }else{?>
    <li class="<?=$act_dc?>"><a href="<?=base_url()?>Ums_admission/edit_docsndcertDetails">3.Documents & Certificates</a></li>
    <?php } ?>
	<li class="<?=$act_ref?>"><a href="<?=base_url()?>Ums_admission/edit_refDetails">4.References</a></li>
	<li class="<?=$act_pay?>"><a href="<?=base_url()?>Ums_admission/edit_paymentDetails">5.Payment Details & Photo</a></li>
  </ul>
</div>  