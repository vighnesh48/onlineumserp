<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<?php

$bar = array_column($sale_by_academic_new_admission, 'fees_paid_type');

if (in_array('OL', $bar)) {
    echo "|1| The 'omg' value found in the assoc array ||";
}
else{
	echo "ff";
}

//$dd= array_key_exists('fees_paid_type', $sale_by_academic_new_admission);
//print_r($dd);
//echo "<pre>";
//print_r($sale_by_academic_reregistration);
//echo "<pre>";
//print_r($sale_by_academic_phd);
//echo "<pre>";
//print_r($sale_by_academic_illp);

?>


<style>
#table {
  font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#table td, #table th {
  border: 1px solid #ddd;
      padding: 5px 12px;
}

#table tr:nth-child(even){background-color: #f2f2f2;}

#table tr:hover {background-color: #ddd;}

#table th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    background-color: #a5a5a5;
    color: black;
}
</style>
<div class="page-header">
        <div class="row">
             <div class="col-sm-12">
                <div class="fancy-collapse-panel">
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                        <div class="panel panel-default">
                           
                             <div class="table-responsive">

<table id="table" width="100%" border="1">
   <tbody>
      <tr>
         <th>
            <p><strong>Sr.No.</strong></p>
         </th>
         <th colspan="2">
            <p><strong>Particulars</strong></p>
         </th>
         <th width="64">
            <p><strong>By POS</strong></p>
         </th>
         <th width="73">
            <p><strong>By Cheque</strong></p>
         </th>
         <th width="73">
            <p><strong>By DD</strong></p>
         </th>
         <th width="91">
            <p><strong>By online (Gateway/NEFT/RTGS)</strong></p>
         </th>
         <th width="64">
            <p><strong>Others</strong></p>
         </th>
         <th width="64">
            <p><strong>Total</strong></p>
         </th>
      </tr>
      <tr>
         <td rowspan="4">
            1</p>
         </td>
         <td rowspan="4">
            Academic</p>
         </td>
         <td>
            New Adm.</p>
         </td>
         <td>
            <p>&nbsp;</p>
         </td>
         <td>
            <p>&nbsp;</p>
         </td>
         <td>
            <p>&nbsp;</p>
         </td>
         <td>
            <p>&nbsp;</p>
         </td>
         <td>
            <p><strong></strong></p>
         </td>
		 <td>
            <p><strong>0</strong></p>
         </td>
      </tr>
      <tr>
         <td>
            Re-Reg.</p>
         </td>
         <td>
            <p>&nbsp;</p>
         </td>
         <td>
            <p>&nbsp;</p>
         </td>
         <td>
            <p>&nbsp;</p>
         </td>
         <td>
            <p>&nbsp;</p>
         </td>
         <td>
            <p><strong></strong></p>
         </td>
		 <td>
            <p><strong>0</strong></p>
         </td>
      </tr>
      <tr>
         <td>
            Ph.D.</p>
         </td>
         <td>
            <p>&nbsp;</p>
         </td>
         <td>
            <p>&nbsp;</p>
         </td>
         <td>
            <p>&nbsp;</p>
         </td>
         <td>
            <p>&nbsp;</p>
         </td>
         <td>
            <p><strong></strong></p>
         </td>
		 <td>
            <p><strong>0</strong></p>
         </td>
      </tr>
      <tr>
         <td>
            IILP</p>
         </td>
         <td>
            <p>&nbsp;</p>
         </td>
         <td>
            <p>&nbsp;</p>
         </td>
         <td>
            <p>&nbsp;</p>
         </td>
         <td>
            <p>&nbsp;</p>
         </td>
         <td>
            <p><strong></strong></p>
         </td>
		 <td>
            <p><strong>0</strong></p>
         </td>
      </tr>
      <tr>
         <td rowspan="4">
            2</p>
         </td>
         <td rowspan="4">
            Exam&nbsp;</p>
         </td>
         <td>
            New Adm.</p>
         </td>
         <td>
            <p>&nbsp;</p>
         </td>
         <td>
            <p>&nbsp;</p>
         </td>
         <td>
            <p>&nbsp;</p>
         </td>
         <td>
            <p>&nbsp;</p>
         </td>
         <td>
            <p><strong></strong></p>
         </td>
		 <td>
            <p><strong>0</strong></p>
         </td>
      </tr>
      <tr>
         <td>
            Re-Reg.</p>
         </td>
         <td>
            <p>&nbsp;</p>
         </td>
         <td>
            <p>&nbsp;</p>
         </td>
         <td>
            <p>&nbsp;</p>
         </td>
         <td>
            <p>&nbsp;</p>
         </td>
         <td>
            <p><strong></strong></p>
         </td>
		 <td>
            <p><strong>0</strong></p>
         </td>
      </tr>
      <tr>
         <td>
            Ph.D.</p>
         </td>
         <td>
            <p>&nbsp;</p>
         </td>
         <td>
            <p>&nbsp;</p>
         </td>
         <td>
            <p>&nbsp;</p>
         </td>
         <td>
            <p>&nbsp;</p>
         </td>
         <td>
            <p><strong></strong></p>
         </td>
		 <td>
            <p><strong>0</strong></p>
         </td>
      </tr>
      <tr>
         <td>
            IILP</p>
         </td>
         <td>
            <p>&nbsp;</p>
         </td>
         <td>
            <p>&nbsp;</p>
         </td>
         <td>
            <p>&nbsp;</p>
         </td>
         <td>
            <p>&nbsp;</p>
         </td>
         <td>
            <p><strong></strong></p>
         </td>
		 <td>
            <p><strong>0</strong></p>
         </td>
      </tr>
      <tr>
         <td>
            3</p>
         </td>
         <td>
            Other / External</p>
         </td>
         <td>
            <p>&nbsp;</p>
         </td>
         <td>
            <p>&nbsp;</p>
         </td>
         <td>
            <p>&nbsp;</p>
         </td>
         <td>
            <p>&nbsp;</p>
         </td>
         <td>
            <p>&nbsp;</p>
         </td>
         <td>
            <p><strong></strong></p>
         </td>
		 <td>
            <p><strong>0</strong></p>
         </td>
      </tr>
      <tr>
         <td colspan="3">
            <p><strong>TOTAL</strong></p>
         </td>
         <td>
            <p><strong>0</strong></p>
         </td>
         <td>
            <p><strong>0</strong></p>
         </td>
         <td>
            <p><strong>0</strong></p>
         </td>
         <td>
            <p><strong>0</strong></p>
         </td>
         <td>
            <p><strong></strong></p>
         </td>
		 <td>
            <p><strong>0</strong></p>
         </td>
		 
      </tr>
   </tbody>
</table>
</div>
                           
                        </div>
             </div>   
                       
                    </div>