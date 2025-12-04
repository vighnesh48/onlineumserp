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
?>
<div class="panel-heading"> <span class="panel-title"><i class="panel-title-icon fa fa-fire text-danger"></i>Details</span>
  <ul class="nav nav-tabs nav-tabs-xs setup-panel">
	<li class="<?=$act_per?>"><a href="<?=base_url()?>phd_admission/edit_personalDetails/<?=$studId?>">1.Personal Information</a></li>
	<li class="<?=$act_ed?>"><a href="<?=base_url()?>phd_admission/edit_eduDetails">2.Educational Details</a></li>
	<li class="<?=$act_dc?>"><a href="<?=base_url()?>phd_admission/edit_docsndcertDetails">3.Documents & Certificates</a></li>
	<li class="<?=$act_ref?>"><a href="<?=base_url()?>phd_admission/edit_refDetails">4.References</a></li>
	<li class="<?=$act_pay?>"><a href="<?=base_url()?>phd_admission/edit_paymentDetails">5.Payment Details & Photo</a></li>
  </ul>
</div>  