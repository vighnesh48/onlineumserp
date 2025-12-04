<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.0.272/jspdf.debug.js"></script>


<style>
.total {
    font-weight: bold;
}



#table_data {
  font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width:90%;
}

#table_data td, #table_data th {
  border: 1px solid #ddd;
      padding: 5px 12px !important;
}

#table_data tr:nth-child(even){background-color: #f2f2f2;}

#table_data tr:hover {background-color: #ddd;}

#table_data th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: center;
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
                            <div class="panel-heading" role="tab" id="headingOne">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne1" aria-expanded="true" aria-controls="collapseOne1">Report Details:
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseOne1" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                <div class="panel-body table-reponsive" style="width:100%;overflow:scroll;height:700px;padding:0px;">
                                
							
                                      
                                  
		

<div id="content-wrapper">
 <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Daily Fees Collection Report</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                </div>
            </div>
        </div>
		
		
		<div class="row " id="print">
            <div class="col-sm-12">
                <div class="panel">
                    
                    <div class="panel-body">
					
					 <form id="form" name="form" action="<?=base_url($currentModule.'/day_wise_fees_reports')?>" method="POST"> 
					   <div class="col-sm-12" >
					    <div class="col-sm-2" >
                             <select  class="form-control" name="by_type" id="by_type"  required>
							 <option value="1" 
							 <?php

                                if($bytype==1){
									echo "selected";
								} ?>>By current Date</option>
							  <option value="2"
							    <?php

                                if($bytype==2){
									echo "selected";
								} ?>
							  
							  >By Deposited Date</option>
                              </div>
					  <div class="col-sm-2" >
                               <input type="text" class="form-control" name="date" id="dt-datepicker1" value="<?php

                                if(isset($date)){
									echo $date;
								} else{

								echo  date( 'Y-m-d', strtotime( 'monday this week' ) );} ?>" placeholder="From Date" required>
                              </div>
							  
							  
							  <div class="col-sm-2"> <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Search</button> </div>
							  
							  
							  <button type="button" id="excel_dwld" class="btn btn-primary" onclick="tableToExcel('table_data', 'ss')" =>Export to Excel</button>
							  <button type="button" class="btn btn-primary" id="pdf_dwld" onclick="makePDF()" =>Download PDF</button>
							
					</div>
					 </form>  
					
					
					 
					<div class="clearfix"></div>
					
					
					<div class="col-md-12" id="table_data1">
					<div id="report_date" class="hidden">
					<div style="font-size:20px;text-align:center !important">
					<span  >
					
					Daily Collection Summary Report</span>
					</div>
					<div style="text-align:left !important">
					<span style="text-align:right !important">
					</br>
					  Date :
                     <?php   if(isset($date)){
									echo $date;
								} else{ echo   date( 'Y-m-d', strtotime( 'monday this week' ) );}
					?>
					</span>
					</div>
					</div>
					<div class="table-responsive">
					<table id="table_data" width="95%" border="1">
					
					
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
         <th width="64">
            <p><strong>By online (NEFT/<br>RTGS)</strong></p>
         </th>
		 <th width="64">
            <p><strong>By online (Gateway)</strong></p>
         </th>
		  <th width="64">
            <p><strong>By Challan</strong></p>
         </th>
		  <th width="64">
            <p><strong>BY ITF</strong></p>
         </th>
         <th width="64">
            <p><strong>BY RECPT</strong></p>
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
            <p>
			 <a href="<?php  echo base_url("Challan/challan_details/POS/2/1/".$date."/".$bytype)?>" target="_blank"><?php $sale_by_academic_new_admission;
			   
              $bar = array_column($sale_by_academic_new_admission,'fmount', 'fees_paid_type');
			    if (array_key_exists("POS",$bar))
					{
					echo $bar['POS'];
					}
               
				else{
					echo 0;
				}


			?>
			</a>&nbsp;</p>
         </td>
         <td>
            <p><a href="<?php  echo base_url("Challan/challan_details/CHQ/2/1/".$date."/".$bytype)?>" target="_blank"><?php $sale_by_academic_new_admission;
			     // print_r($sale_by_academic_new_admission);
              $bar = array_column($sale_by_academic_new_admission,'fmount', 'fees_paid_type');
			    if (array_key_exists("CHQ",$bar))
					{
					echo $bar['CHQ'];
					}
               
				else{
					echo 0;
				}?></a>&nbsp;</p>
         </td>
         <td>
            <p><a href="<?php  echo base_url("Challan/challan_details/DD/2/1/".$date."/".$bytype)?>" target="_blank"><?php $sale_by_academic_new_admission;
			     // print_r($sale_by_academic_new_admission);
              $bar = array_column($sale_by_academic_new_admission,'fmount', 'fees_paid_type');
			    if (array_key_exists("DD",$bar))
					{
					echo $bar['DD'];
					}
               
				else{
					echo 0;
				}?></a>&nbsp;</p>
         </td>
         <td>
            <p><a href="<?php  echo base_url("Challan/challan_details/PG/2/1/".$date."/".$bytype)?>" target="_blank"><?php $sale_by_academic_new_admission;
			     // print_r($sale_by_academic_new_admission);
              $bar = array_column($sale_by_academic_new_admission,'fmount', 'fees_paid_type');
			    if (array_key_exists("PG",$bar))
					{
					echo $bar['PG'];
					}
               
				else{
					echo 0;
				}?></a>&nbsp;</p>
         </td>
         <td>
            <p><a href="<?php  echo base_url("Challan/challan_details/OL/2/1/".$date."/".$bytype)?>" target="_blank"><?php $sale_by_academic_new_admission;
			     // print_r($sale_by_academic_new_admission);
              $bar = array_column($sale_by_academic_new_admission,'fmount', 'fees_paid_type');
			    if (array_key_exists("OL",$bar))
					{
					echo $bar['OL']+$bar['GATEWAY-ONLINE'];
					}
               
				else{
					echo 0;
				}?></a></p>
         </td>
		  <td>
            <p><a href="<?php  echo base_url("Challan/challan_details/CHLN/2/1/".$date."/".$bytype)?>" target="_blank"><?php $sale_by_academic_new_admission;
			     // print_r($sale_by_academic_new_admission);
              $bar = array_column($sale_by_academic_new_admission,'fmount', 'fees_paid_type');
			    if (array_key_exists("CHLN",$bar))
					{
					echo $bar['CHLN'];
					}
               
				else{
					echo 0;
				}?></a></p>
         </td>
		  <td>
            <p><a href="<?php  echo base_url("Challan/challan_details/ITF/2/1/".$date."/".$bytype)?>" target="_blank"><?php $sale_by_academic_new_admission;
			     // print_r($sale_by_academic_new_admission);
              $bar = array_column($sale_by_academic_new_admission,'fmount', 'fees_paid_type');
			    if (array_key_exists("ITF",$bar))
					{
					echo $bar['ITF'];
					}
               
				else{
					echo 0;
				}?></a></p>
         </td>
		  <td>
            <p><a href="<?php  echo base_url("Challan/challan_details/RECPT/2/1/".$date."/".$bytype)?>" target="_blank"><?php $sale_by_academic_new_admission;
			     // print_r($sale_by_academic_new_admission);
              $bar = array_column($sale_by_academic_new_admission,'fmount', 'fees_paid_type');
			    if (array_key_exists("RECPT",$bar))
					{
					echo $bar['RECPT'];
					}
               
				else{
					echo 0;
				}?></a></p>
         </td>
		  <td>
              <p><a href="<?php  echo base_url("Challan/challan_details/OTHER/2/1/".$date."/".$bytype)?>" target="_blank"><?php 
			$sale_by_academic_new_admission;
			     // print_r($sale_by_academic_new_admission);
              $bar = array_column($sale_by_academic_new_admission,'fmount', 'fees_paid_type');
			    if (array_key_exists("",$bar))
					{
					echo $bar[''];
					}
               
				else{
					echo 0;
				}?></a></p>
         </td>
		 <td>
            <p><strong><a href="<?php  echo base_url("Challan/challan_details/0/2/1/".$date."/".$bytype)?>" target="_blank"><?=$total_sale_by_academic_new_admission ?></a></strong></p>
         </td>
      </tr>
      <tr>
         <td>
            Re-Reg.</p>
         </td>
         <td>
            <p><a href="<?php  echo base_url("Challan/challan_details/POS/2/2/".$date."/".$bytype)?>" target="_blank"><?php 	
			     // print_r($sale_by_academic_new_admission);
              $bar = array_column($sale_by_academic_reregistration,'fmount', 'fees_paid_type');
			//  print_r();
			    if (array_key_exists("POS",$bar))
					{
					echo $bar['POS'];
					}
               
				else{
					echo 0;
				}


			?></a>&nbsp;</p>
         </td>
         <td>
            <p><a href="<?php  echo base_url("Challan/challan_details/CHQ/2/2/".$date."/".$bytype)?>" target="_blank"><?php $sale_by_academic_reregistration;
			     // print_r($sale_by_academic_new_admission);
              $bar = array_column($sale_by_academic_reregistration,'fmount', 'fees_paid_type');
			    if (array_key_exists("CHQ",$bar))
					{
					echo $bar['CHQ'];
					}
               
				else{
					echo 0;
				}


			?></a>&nbsp;</p>
         </td>
         <td>
            <p><a href="<?php  echo base_url("Challan/challan_details/DD/2/2/".$date."/".$bytype)?>" target="_blank"><?php $sale_by_academic_reregistration;
			     // print_r($sale_by_academic_new_admission);
              $bar = array_column($sale_by_academic_reregistration,'fmount', 'fees_paid_type');
			    if (array_key_exists("DD",$bar))
					{
					echo $bar['DD'];
					}
               
				else{
					echo 0;
				}


			?></a>&nbsp;</p>
         </td>
         <td>
            <p><a href="<?php  echo base_url("Challan/challan_details/PG/2/2/".$date."/".$bytype)?>" target="_blank"><?php $sale_by_academic_reregistration;
			     // print_r($sale_by_academic_new_admission);
              $bar = array_column($sale_by_academic_reregistration,'fmount', 'fees_paid_type');
			    if (array_key_exists("PG",$bar))
					{
					echo $bar['PG'];
					}
               
				else{
					echo 0;
				}


			?></a>&nbsp;</p>
         </td>
         <td>
            <p><a href="<?php  echo base_url("Challan/challan_details/OL/2/2/".$date."/".$bytype)?>" target="_blank"><?php $sale_by_academic_reregistration;
			     // print_r($sale_by_academic_new_admission);
              $bar = array_column($sale_by_academic_reregistration,'fmount', 'fees_paid_type');
			    if (array_key_exists("OL",$bar))
					{
					echo $bar['OL']+$bar['GATEWAY-ONLINE'];
					}
               
				else{
					echo 0;
				}


			?></a></p>
         </td>
		  <td>
            <p><a href="<?php  echo base_url("Challan/challan_details/CHLN/2/2/".$date."/".$bytype)?>" target="_blank"><?php $sale_by_academic_reregistration;
			     // print_r($sale_by_academic_new_admission);
              $bar = array_column($sale_by_academic_reregistration,'fmount', 'fees_paid_type');
			    if (array_key_exists("CHLN",$bar))
					{
					echo $bar['CHLN'];
					}
               
				else{
					echo 0;
				}


			?></a></p>
         </td>
		  <td>
            <p><a href="<?php  echo base_url("Challan/challan_details/ITF/2/2/".$date."/".$bytype)?>" target="_blank"><?php $sale_by_academic_reregistration;
			     // print_r($sale_by_academic_new_admission);
              $bar = array_column($sale_by_academic_reregistration,'fmount', 'fees_paid_type');
			    if (array_key_exists("ITF",$bar))
					{
					echo $bar['ITF'];
					}
               
				else{
					echo 0;
				}


			?></a></p>
         </td>
		 <td>
            <p><a href="<?php  echo base_url("Challan/challan_details/RECPT/2/2/".$date."/".$bytype)?>" target="_blank"><?php $sale_by_academic_reregistration;
			     // print_r($sale_by_academic_new_admission);
              $bar = array_column($sale_by_academic_reregistration,'fmount', 'fees_paid_type');
			    if (array_key_exists("RECPT",$bar))
					{
					echo $bar['RECPT'];
					}
               
				else{
					echo 0;
				}


			?></a></p>
         </td>
		  <td>
           <p><a href="<?php  echo base_url("Challan/challan_details/OTHER/2/2/".$date."/".$bytype)?>" target="_blank"><?php $sale_by_academic_reregistration;
			     // print_r($sale_by_academic_new_admission);
              $bar = array_column($sale_by_academic_reregistration,'fmount', 'fees_paid_type');
			    if (array_key_exists("",$bar))
					{
					echo $bar[''];
					}
               
				else{
					echo 0;
				}


			?></a></p>
         </td>
		 <td>
            <p><strong><a href="<?php  echo base_url("Challan/challan_details/0/2/2/".$date."/".$bytype)?>" target="_blank"><?=$total_sale_by_academic_reregistration ?></strong></a></p>
         </td>
      </tr>
      <tr>
         <td>
            Ph.D.</p>
         </td>
         <td>
            <p><a href="<?php  echo base_url("Challan/challan_details/POS/2/3/".$date."/".$bytype)?>" target="_blank"><?php $sale_by_academic_phd;
			     // print_r($sale_by_academic_new_admission);
              $bar = array_column($sale_by_academic_phd,'fmount', 'fees_paid_type');
			    if (array_key_exists("POS",$bar))
					{
					echo $bar['POS'];
					}
               
				else{
					echo 0;
				}


			?></a>&nbsp;</p>
         </td>
         <td>
            <p><a href="<?php  echo base_url("Challan/challan_details/CHQ/2/3/".$date."/".$bytype)?>" target="_blank"><?php $sale_by_academic_phd;
			     // print_r($sale_by_academic_new_admission);
              $bar = array_column($sale_by_academic_phd,'fmount', 'fees_paid_type');
			    if (array_key_exists("CHQ",$bar))
					{
					echo $bar['CHQ'];
					}
               
				else{
					echo 0;
				}


			?></a>&nbsp;</p>
         </td>
         <td>
            <p><a href="<?php  echo base_url("Challan/challan_details/DD/2/3/".$date."/".$bytype)?>" target="_blank"><?php $sale_by_academic_phd;
			     // print_r($sale_by_academic_new_admission);
              $bar = array_column($sale_by_academic_phd,'fmount', 'fees_paid_type');
			    if (array_key_exists("DD",$bar))
					{
					echo $bar['DD'];
					}
               
				else{
					echo 0;
				}


			?></a>&nbsp;</p>
         </td>
		 <td>
            <p><a href="<?php  echo base_url("Challan/challan_details/PG/2/3/".$date."/".$bytype)?>" target="_blank"><?php $sale_by_academic_phd;
			     // print_r($sale_by_academic_new_admission);
              $bar = array_column($sale_by_academic_phd,'fmount', 'fees_paid_type');
			    if (array_key_exists("PG",$bar))
					{
					echo $bar['PG'];
					}
               
				else{
					echo 0;
				}


			?></a>&nbsp;</p>
         </td>
         <td>
            <p><a href="<?php  echo base_url("Challan/challan_details/OL/2/3/".$date."/".$bytype)?>" target="_blank"><?php $sale_by_academic_phd;
			     // print_r($sale_by_academic_new_admission);
              $bar = array_column($sale_by_academic_phd,'fmount', 'fees_paid_type');
			    if (array_key_exists("OL",$bar))
					{
					echo $bar['OL']+$bar['GATEWAY-ONLINE'];
					}
               
				else{
					echo 0;
				}


			?></a>&nbsp;</p>
         </td>
		 <td>
            <p><a href="<?php  echo base_url("Challan/challan_details/CHLN/2/3/".$date."/".$bytype)?>" target="_blank"><?php $sale_by_academic_phd;
			     // print_r($sale_by_academic_new_admission);
              $bar = array_column($sale_by_academic_phd,'fmount', 'fees_paid_type');
			    if (array_key_exists("CHLN",$bar))
					{
					echo $bar['CHLN'];
					}
               
				else{
					echo 0;
				}


			?></a>&nbsp;</p>
         </td>
		  <td>
            <p><a href="<?php  echo base_url("Challan/challan_details/ITF/2/3/".$date."/".$bytype)?>" target="_blank"><?php 
			     // print_r($sale_by_academic_new_admission);
              $bar = array_column($sale_by_academic_phd,'fmount', 'fees_paid_type');
			    if (array_key_exists("ITF",$bar))
					{
					echo $bar['ITF'];
					}
               
				else{
					echo 0;
				}


			?></a></p>
         </td>
         <td>
            <p><a href="<?php  echo base_url("Challan/challan_details/RECPT/2/3/".$date."/".$bytype)?>" target="_blank"><?php 
			     // print_r($sale_by_academic_new_admission);
              $bar = array_column($sale_by_academic_phd,'fmount', 'fees_paid_type');
			    if (array_key_exists("RECPT",$bar))
					{
					echo $bar['RECPT'];
					}
               
				else{
					echo 0;
				}


			?></a></p>
         </td>
		 <td>
             <p><a href="<?php  echo base_url("Challan/challan_details/OTHER/2/3/".$date."/".$bytype)?>" target="_blank"><?php 
			     // print_r($sale_by_academic_new_admission);
              $bar = array_column($sale_by_academic_phd,'fmount', 'fees_paid_type');
			    if (array_key_exists("",$bar))
					{
					echo $bar[''];
					}
               
				else{
					echo 0;
				}


			?></a></p>
         </td>
	
		 <td>
            <p><strong><a href="<?php  echo base_url("Challan/challan_details/0/2/3/".$date."/".$bytype)?>" target="_blank"><?=$total_sale_by_academic_phd ?></a></strong></p>
         </td>
      </tr>
      <tr>
         <td>
            IILP</p>
         </td>
         <td>
            <p><?php $sale_by_academic_phd;
			     // print_r($sale_by_academic_new_admission);
              $bar = array_column($sale_by_academic_illp,'fmount', 'fees_paid_type');
			    if (array_key_exists("POS",$bar))
					{
					echo $bar['POS'];
					}
               
				else{
					echo 0;
				}


			?>&nbsp;</p>
         </td>
         <td>
            <p><?php $sale_by_academic_illp;
			     // print_r($sale_by_academic_new_admission);
              $bar = array_column($sale_by_academic_illp,'fmount', 'fees_paid_type');
			    if (array_key_exists("CHQ",$bar))
					{
					echo $bar['CHQ'];
					}
               
				else{
					echo 0;
				}


			?>&nbsp;</p>
         </td>
         <td>
            <p><?php $sale_by_academic_illp;
			     // print_r($sale_by_academic_new_admission);
              $bar = array_column($sale_by_academic_illp,'fmount', 'fees_paid_type');
			    if (array_key_exists("DD",$bar))
					{
					echo $bar['DD'];
					}
               
				else{
					echo 0;
				}


			?>&nbsp;</p>
         </td>
		  <td>
            <p><?php $sale_by_academic_illp;
			     // print_r($sale_by_academic_new_admission);
              $bar = array_column($sale_by_academic_illp,'fmount', 'fees_paid_type');
			    if (array_key_exists("PG",$bar))
					{
					echo $bar['PG'];
					}
               
				else{
					echo 0;
				}


			?>&nbsp;</p>
         </td>
         <td>
            <p><?php $sale_by_academic_illp;
			     // print_r($sale_by_academic_new_admission);
              $bar = array_column($sale_by_academic_illp,'fmount', 'fees_paid_type');
			    if (array_key_exists("OL",$bar))
					{
					echo $bar['OL'];
					}
               
				else{
					echo 0;
				}


			?>&nbsp;</p>
         </td>
         <td>
            <p><?php $sale_by_academic_illp;
			     // print_r($sale_by_academic_new_admission);
              $bar = array_column($sale_by_academic_illp,'fmount', 'fees_paid_type');
			    if (array_key_exists("CHLN",$bar))
					{
					echo $bar['CHLN'];
					}
               
				else{
					echo 0;
				}


			?></p>
         </td>
		  <td>
            <p><?php $sale_by_academic_illp;
			     // print_r($sale_by_academic_new_admission);
              $bar = array_column($sale_by_academic_illp,'fmount', 'fees_paid_type');
			    if (array_key_exists("ITF",$bar))
					{
					echo $bar['ITF'];
					}
               
				else{
					echo 0;
				}


			?></p>
         </td>
		  <td>
            <p><?php $sale_by_academic_illp;
			     // print_r($sale_by_academic_new_admission);
              $bar = array_column($sale_by_academic_illp,'fmount', 'fees_paid_type');
			    if (array_key_exists("RECPT",$bar))
					{
					echo $bar['RECPT'];
					}
               
				else{
					echo 0;
				}


			?></p>
         </td>
		  <td>
            <p><?php $sale_by_academic_illp;
			     // print_r($sale_by_academic_new_admission);
              $bar = array_column($sale_by_academic_illp,'fmount', 'fees_paid_type');
			    if (array_key_exists("",$bar))
					{
					echo $bar[''];
					}
               
				else{
					echo 0;
				}


			?></p>
         </td>
		 <td>
            <p><strong><?=$total_sale_by_academic_illp ?></strong></p>
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
            <p><a href="<?php  echo base_url("Challan/challan_details/POS/5/1/".$date."/".$bytype)?>" target="_blank"><?php 	
			     // print_r($sale_by_academic_new_admission);
              $bar = array_column($sale_by_exam_new_admission,'fmount', 'fees_paid_type');
			    if (array_key_exists("POS",$bar))
					{
					echo $bar['POS'];
					}
               
				else{
					echo 0;
				}


			?></a></p>
         </td>
         <td>
            <p><a href="<?php  echo base_url("Challan/challan_details/CHQ/5/1/".$date."/".$bytype)?>" target="_blank"><?php 	
			     // print_r($sale_by_academic_new_admission);
              $bar = array_column($sale_by_exam_new_admission,'fmount', 'fees_paid_type');
			    if (array_key_exists("CHQ",$bar))
					{
					echo $bar['CHQ'];
					}
               
				else{
					echo 0;
				}


			?></a>&nbsp;</p>
         </td>
         <td>
            <p><a href="<?php  echo base_url("Challan/challan_details/DD/5/1/".$date."/".$bytype)?>" target="_blank"><?php 	
			     // print_r($sale_by_academic_new_admission);
              $bar = array_column($sale_by_exam_new_admission,'fmount', 'fees_paid_type');
			    if (array_key_exists("DD",$bar))
					{
					echo $bar['DD'];
					}
               
				else{
					echo 0;
				}


			?></a>&nbsp;</p>
         </td>
		 <td>
            <p><a href="<?php  echo base_url("Challan/challan_details/PG/5/1/".$date."/".$bytype)?>" target="_blank"><?php 	
			     // print_r($sale_by_academic_new_admission);
              $bar = array_column($sale_by_exam_new_admission,'fmount', 'fees_paid_type');
			    if (array_key_exists("PG",$bar))
					{
					echo $bar['PG'];
					}
               
				else{
					echo 0;
				}


			?></a>&nbsp;</p>
         </td>
         <td>
            <p><a href="<?php  echo base_url("Challan/challan_details/OL/5/1/".$date."/".$bytype)?>" target="_blank"><?php 	
			     // print_r($sale_by_academic_new_admission);
              $bar = array_column($sale_by_exam_new_admission,'fmount', 'fees_paid_type');
			    if (array_key_exists("OL",$bar))
					{
					echo $bar['OL'];
					}
               
				else{
					echo 0;
				}


			?></a>&nbsp;</p>
         </td>
         <td>
            <p><a href="<?php  echo base_url("Challan/challan_details/CHLN/5/1/".$date."/".$bytype)?>" target="_blank"><?php 	
			     // print_r($sale_by_academic_new_admission);
              $bar = array_column($sale_by_exam_new_admission,'fmount', 'fees_paid_type');
			    if (array_key_exists("CHLN",$bar))
					{
					echo $bar['CHLN'];
					}
               
				else{
					echo 0;
				}


			?></a></p>
         </td>
		 <td>
            <p><a href="<?php  echo base_url("Challan/challan_details/ITF/5/1/".$date."/".$bytype)?>" target="_blank"><?php 	
			     // print_r($sale_by_academic_new_admission);
              $bar = array_column($sale_by_exam_new_admission,'fmount', 'fees_paid_type');
			    if (array_key_exists("ITF",$bar))
					{
					echo $bar['ITF'];
					}
               
				else{
					echo 0;
				}


			?></a></p>
         </td>
		 <td>
            <p><a href="<?php  echo base_url("Challan/challan_details/RECPT/5/1/".$date."/".$bytype)?>" target="_blank"><?php 	
			     // print_r($sale_by_academic_new_admission);
              $bar = array_column($sale_by_exam_new_admission,'fmount', 'fees_paid_type');
			    if (array_key_exists("RECPT",$bar))
					{
					echo $bar['RECPT'];
					}
               
				else{
					echo 0;
				}


			?></a></p>
         </td>
		 <td>
            <p><a href="<?php  echo base_url("Challan/challan_details/OTHER/5/1/".$date."/".$bytype)?>" target="_blank"><?php 	
			     // print_r($sale_by_academic_new_admission);
              $bar = array_column($sale_by_exam_new_admission,'fmount', 'fees_paid_type');
			    if (array_key_exists("",$bar))
					{
					echo $bar[''];
					}
               
				else{
					echo 0;
				}


			?></a></p>
         </td>
		 <td>
            <p><strong><a href="<?php  echo base_url("Challan/challan_details/0/5/1/".$date."/".$bytype)?>" target="_blank"><?=$total_sale_by_exam_new_admission ?></a></strong></p>
         </td>
      </tr>
      <tr>
         <td>
            Re-Reg.</p>
         </td>
         <td>
            <p><a href="<?php  echo base_url("Challan/challan_details/POS/5/2/".$date."/".$bytype)?>" target="_blank"><?php 	
			     // print_r($sale_by_academic_new_admission);
              $bar = array_column($sale_by_exam_reregistration,'fmount', 'fees_paid_type');
			    if (array_key_exists("POS",$bar))
					{
					echo $bar['POS'];
					}
               
				else{
					echo 0;
				}


			?></a>&nbsp;</p>
         </td>
         <td>
            <p><a href="<?php  echo base_url("Challan/challan_details/CHQ/5/2/".$date."/".$bytype)?>" target="_blank"><?php 	
			     // print_r($sale_by_academic_new_admission);
              $bar = array_column($sale_by_exam_reregistration,'fmount', 'fees_paid_type');
			    if (array_key_exists("CHQ",$bar))
					{
					echo $bar['CHQ'];
					}
               
				else{
					echo 0;
				}


			?></a>&nbsp;</p>
         </td>
         <td>
             <p><a href="<?php  echo base_url("Challan/challan_details/DD/5/2/".$date."/".$bytype)?>" target="_blank"><?php 	
			     // print_r($sale_by_academic_new_admission);
              $bar = array_column($sale_by_exam_reregistration,'fmount', 'fees_paid_type');
			    if (array_key_exists("DD",$bar))
					{
					echo $bar['DD'];
					}
               
				else{
					echo 0;
				}


				?></a>&nbsp;</p>
         </td>
		 <td>
             <p><a href="<?php  echo base_url("Challan/challan_details/PG/5/2/".$date."/".$bytype)?>" target="_blank"><?php 
			     // print_r($sale_by_academic_new_admission);
              $bar = array_column($sale_by_exam_reregistration,'fmount', 'fees_paid_type');
			    if (array_key_exists("PG",$bar))
					{
					echo $bar['PG'];
					}
               
				else{
					echo 0;
				}


			?></a>&nbsp;</p>
         </td>
         <td>
            <p><a href="<?php  echo base_url("Challan/challan_details/OL/5/2/".$date."/".$bytype)?>" target="_blank"><?php 
			     // print_r($sale_by_academic_new_admission);
              $bar = array_column($sale_by_exam_reregistration,'fmount', 'fees_paid_type');
			    if (array_key_exists("OL",$bar))
					{
					echo $bar['OL'];
					}
               
				else{
					echo 0;
				}


			?></a>&nbsp;</p>
         </td>
         <td>
              <p><a href="<?php  echo base_url("Challan/challan_details/CHLN/5/2/".$date."/".$bytype)?>" target="_blank"><?php 
			     // print_r($sale_by_academic_new_admission);
              $bar = array_column($sale_by_exam_reregistration,'fmount', 'fees_paid_type');
			    if (array_key_exists("CHLN",$bar))
					{
					echo $bar['CHLN'];
					}
               
				else{
					echo 0;
				}


			?></a>&nbsp;</p>
         </td>
		    <td>
              <p><a href="<?php  echo base_url("Challan/challan_details/ITF/5/2/".$date."/".$bytype)?>" target="_blank"><?php 
			     // print_r($sale_by_academic_new_admission);
              $bar = array_column($sale_by_exam_reregistration,'fmount', 'fees_paid_type');
			    if (array_key_exists("ITF",$bar))
					{
					echo $bar['ITF'];
					}
               
				else{
					echo 0;
				}


			?></a>&nbsp;</p>
         </td>
		    <td>
           <p><a href="<?php  echo base_url("Challan/challan_details/RECPT/5/2/".$date."/".$bytype)?>" target="_blank"><?php 
			     // print_r($sale_by_academic_new_admission);
              $bar = array_column($sale_by_exam_reregistration,'fmount', 'fees_paid_type');
			    if (array_key_exists("RECPT",$bar))
					{
					echo $bar['RECPT'];
					}
               
				else{
					echo 0;
				}


			?></a>&nbsp;</p>
         </td>
		    <td>
            <p><a href="<?php  echo base_url("Challan/challan_details/OTHER/5/2/".$date."/".$bytype)?>" target="_blank"><?php 	
			     // print_r($sale_by_academic_new_admission);
              $bar = array_column($sale_by_exam_reregistration,'fmount', 'fees_paid_type');
			    if (array_key_exists("",$bar))
					{
					echo $bar[''];
					}
               
				else{
					echo 0;
				}


			?></a>&nbsp;</p>
         </td>
		 <td>
            <p><strong><a href="<?php  echo base_url("Challan/challan_details/0/5/2/".$date."/".$bytype)?>" target="_blank"><?=$total_sale_by_exam_reregistration ?></a></strong></p>
         </td>
      </tr>
      <tr>
         <td>
            Ph.D.</p>
         </td>
         <td>
           <p><a href="<?php  echo base_url("Challan/challan_details/POS/5/3/".$date."/".$bytype)?>" target="_blank"><?php 
			     // print_r($sale_by_academic_new_admission);
              $bar = array_column($sale_by_exam_phd,'fmount', 'fees_paid_type');
			    if (array_key_exists("POS",$bar))
					{
					echo $bar['POS'];
					}
               
				else{
					echo 0;
				}


			?></a>&nbsp;</p>
         </td>
         <td>
           <p><a href="<?php  echo base_url("Challan/challan_details/CHQ/5/3/".$date."/".$bytype)?>" target="_blank"><?php 
			     // print_r($sale_by_academic_new_admission);
              $bar = array_column($sale_by_exam_phd,'fmount', 'fees_paid_type');
			    if (array_key_exists("CHQ",$bar))
					{
					echo $bar['CHQ'];
					}
               
				else{
					echo 0;
				}


			?></a>&nbsp;</p>
         </td>
         <td>
             <p><a href="<?php  echo base_url("Challan/challan_details/DD/5/3/".$date."/".$bytype)?>" target="_blank"><?php	
			     // print_r($sale_by_academic_new_admission);
              $bar = array_column($sale_by_exam_phd,'fmount', 'fees_paid_type');
			    if (array_key_exists("DD",$bar))
					{
					echo $bar['DD'];
					}
               
				else{
					echo 0;
				}


			?></a>&nbsp;</p>
         </td>  <td>
               <p><a href="<?php  echo base_url("Challan/challan_details/PG/5/3/".$date."/".$bytype)?>" target="_blank"><?php	
			     // print_r($sale_by_academic_new_admission);
              $bar = array_column($sale_by_exam_phd,'fmount', 'fees_paid_type');
			    if (array_key_exists("PG",$bar))
					{
					echo $bar['PG'];
					}
               
				else{
					echo 0;
				}


			?></a>&nbsp;</p>
         </td>
         <td>
            <p><a href="<?php  echo base_url("Challan/challan_details/OL/5/3/".$date."/".$bytype)?>" target="_blank"><?php	
			     // print_r($sale_by_academic_new_admission);
              $bar = array_column($sale_by_exam_phd,'fmount', 'fees_paid_type');
			    if (array_key_exists("OL",$bar))
					{
					echo $bar['OL'];
					}
               
				else{
					echo 0;
				}


			?></a>&nbsp;</p>
         </td>
         <td>
            <p><a href="<?php  echo base_url("Challan/challan_details/CHLN/5/3/".$date."/".$bytype)?>" target="_blank"><?php	
			     // print_r($sale_by_academic_new_admission);
              $bar = array_column($sale_by_exam_phd,'fmount', 'fees_paid_type');
			    if (array_key_exists("CHLN",$bar))
					{
					echo $bar['CHLN'];
					}
               
				else{
					echo 0;
				}


			?></a>&nbsp;</p>
         </td>
		 <td>
            <p><a href="<?php  echo base_url("Challan/challan_details/ITF/5/3/".$date."/".$bytype)?>" target="_blank"><?php
			     // print_r($sale_by_academic_new_admission);
              $bar = array_column($sale_by_exam_phd,'fmount', 'fees_paid_type');
			    if (array_key_exists("ITF",$bar))
					{
					echo $bar['ITF'];
					}
               
				else{
					echo 0;
				}


			?></a>&nbsp;</p>
         </td>
		 <td>
          <p><a href="<?php  echo base_url("Challan/challan_details/RECPT/5/3/".$date."/".$bytype)?>" target="_blank"><?php
			     // print_r($sale_by_academic_new_admission);
              $bar = array_column($sale_by_exam_phd,'fmount', 'fees_paid_type');
			    if (array_key_exists("RECPT",$bar))
					{
					echo $bar['RECPT'];
					}
               
				else{
					echo 0;
				}


			?></a>&nbsp;</p>
         </td>
		 <td>
           <p><a href="<?php  echo base_url("Challan/challan_details/OTHER/5/3/".$date."/".$bytype)?>" target="_blank"><?php
			     // print_r($sale_by_academic_new_admission);
              $bar = array_column($sale_by_exam_phd,'fmount', 'fees_paid_type');
			    if (array_key_exists("",$bar))
					{
					echo $bar[''];
					}
               
				else{
					echo 0;
				}


			?></a>&nbsp;</p>
         </td>
		 <td>
            <p><strong><a href="<?php  echo base_url("Challan/challan_details/0/5/3/".$date."/".$bytype)?>" target="_blank"><?=$total_sale_by_exam_phd ?></a></strong></p>
         </td>
      </tr>
      <tr>
         <td>
            IILP</p>
         </td>
         <td>
            <p><?php 	
			     // print_r($sale_by_academic_new_admission);
              $bar = array_column($sale_by_exam_illp,'fmount', 'fees_paid_type');
			    if (array_key_exists("POS",$bar))
					{
					echo $bar['POS'];
					}
               
				else{
					echo 0;
				}


			?></p>
         </td>
         <td>
            <p><?php 	
			     // print_r($sale_by_academic_new_admission);
              $bar = array_column($sale_by_exam_illp,'fmount', 'fees_paid_type');
			    if (array_key_exists("CHQ",$bar))
					{
					echo $bar['CHQ'];
					}
               
				else{
					echo 0;
				}


			?></p>
         </td>
         <td>
            <p><?php 	
			     // print_r($sale_by_academic_new_admission);
              $bar = array_column($sale_by_exam_illp,'fmount', 'fees_paid_type');
			    if (array_key_exists("DD",$bar))
					{
					echo $bar['DD'];
					}
               
				else{
					echo 0;
				}


			?></p>
         </td>
		   <td>
            <p><?php 	
			     // print_r($sale_by_academic_new_admission);
              $bar = array_column($sale_by_exam_illp,'fmount', 'fees_paid_type');
			    if (array_key_exists("PG",$bar))
					{
					echo $bar['PG'];
					}
               
				else{
					echo 0;
				}


			?></p>
         </td>
         <td>
            <p><?php 	
			     // print_r($sale_by_academic_new_admission);
              $bar = array_column($sale_by_exam_illp,'fmount', 'fees_paid_type');
			    if (array_key_exists("OL",$bar))
					{
					echo $bar['OL'];
					}
               
				else{
					echo 0;
				}


			?></p>
         </td>
         <td>
            <p><?php 	
			     // print_r($sale_by_academic_new_admission);
              $bar = array_column($sale_by_exam_illp,'fmount', 'fees_paid_type');
			    if (array_key_exists("CHLN",$bar))
					{
					echo $bar['CHLN'];
					}
               
				else{
					echo 0;
				}


			?></p>
         </td>
		 <td>
            <p><?php 	
			     // print_r($sale_by_academic_new_admission);
              $bar = array_column($sale_by_exam_illp,'fmount', 'fees_paid_type');
			    if (array_key_exists("ITF",$bar))
					{
					echo $bar['ITF'];
					}
               
				else{
					echo 0;
				}


			?></p>
         </td>
		 <td>
            <p><?php 	
			     // print_r($sale_by_academic_new_admission);
              $bar = array_column($sale_by_exam_illp,'fmount', 'fees_paid_type');
			    if (array_key_exists("RECPT",$bar))
					{
					echo $bar['RECPT'];
					}
               
				else{
					echo 0;
				}


			?></p>
         </td>
		 <td>
            <p><?php 	
			     // print_r($sale_by_academic_new_admission);
              $bar = array_column($sale_by_exam_illp,'fmount', 'fees_paid_type');
			    if (array_key_exists("",$bar))
					{
					echo $bar[''];
					}
               
				else{
					echo 0;
				}


			?></p>
         </td>
		 <td>
            <p><strong><?=$total_sale_by_exam_illp ?></strong></p>
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
            <p><?php 	
			  
              $bar = array_column($sale_by_internal_external,'famount','type');
			 
			    if (array_key_exists("POS",$bar))
					{
					echo $bar['POS'];
					}
               
				else{
					echo 0;
				}


			?></p>
         </td>
         <td>
            <p><?php 	
			     
              $bar = array_column($sale_by_internal_external,'famount', 'type');
			  
			    if (array_key_exists("CHQ",$bar))
					{
					echo $bar['CHQ'];
					}
               
				else{
					echo 0;
				}


			?>&nbsp;</p>
         </td>
         <td>
            <p><?php 	
			     // print_r($sale_by_academic_new_admission);
              $bar = array_column($sale_by_internal_external,'famount', 'type');
			    if (array_key_exists("DD",$bar))
					{
					echo $bar['DD'];
					}
               
				else{
					echo 0;
				}


			?>&nbsp;</p>
         </td>
		  <td>
            <p><?php 	
			     // print_r($sale_by_academic_new_admission);
              $bar = array_column($sale_by_internal_external,'famount', 'type');
			    if (array_key_exists("PG",$bar))
					{
					echo $bar['PG'];
					}
               
				else{
					echo 0;
				}


			?>&nbsp;</p>
         </td>
         <td>
            <p><?php 	
			     // print_r($sale_by_academic_new_admission);
              $bar = array_column($sale_by_internal_external,'famount', 'type');
			    if (array_key_exists("OL",$bar))
					{
					echo $bar['OL'];
					}
               
				else{
					echo 0;
				}


			?>&nbsp;</p>
         </td>
         <td>
            <p><?php 	
			     // print_r($sale_by_academic_new_admission);
              $bar = array_column($sale_by_internal_external,'famount', 'fees_paid_type');
			    if (array_key_exists("CHLN",$bar))
					{
					echo $bar['CHLN'];
					}
               
				else{
					echo 0;
				}


			?></p>
         </td>
		 <td>
            <p><?php 	
			     // print_r($sale_by_academic_new_admission);
              $bar = array_column($sale_by_internal_external,'famount', 'fees_paid_type');
			    if (array_key_exists("ITF",$bar))
					{
					echo $bar['ITF'];
					}
               
				else{
					echo 0;
				}


			?></p>
         </td>
		 <td>
            <p><?php 	
			     // print_r($sale_by_academic_new_admission);
              $bar = array_column($sale_by_internal_external,'famount', 'fees_paid_type');
			    if (array_key_exists("RECPT",$bar))
					{
					echo $bar['RECPT'];
					}
               
				else{
					echo 0;
				}


			?></p>
         </td>
		 <td>
            <p><?php 	
			     // print_r($sale_by_academic_new_admission);
              $bar = array_column($sale_by_internal_external,'famount', 'fees_paid_type');
			    if (array_key_exists("",$bar))
					{
					echo $bar[''];
					}
               
				else{
					echo 0;
				}


			?></p>
         </td>
		 <td>
            <p><strong><?=$total_sale_by_internal_external ?></strong></p>
         </td>
      </tr>
      <tr>
         <td colspan="3">
            <p><strong>TOTAL</strong></p>
         </td>
         <td>
            <p><strong><?=$sale_by_pos ?></strong></p>
         </td>
         <td>
            <p><strong><?=$sale_by_cheque ?></strong></p>
         </td>
         <td>
            <p><strong><?=$sale_by_dd ?></strong></p>
         </td>
         <td>
            <p><strong><?=$sale_by_pg ?></strong></p>
         </td>
         <td>
           <p><strong><?=$sale_by_ol ?></strong></p>
         </td>
		 <td>
            <p><strong><?=$sale_by_chln ?></strong></p>
         </td>
		 <td>
            <p><strong><?=$sale_by_itf ?></strong></p>
         </td>
		 <td>
            <p><strong><?=$sale_by_recpt ?></strong></p>
         </td>
		 <td>
            <p><strong><?=$sale_by_others ?></strong></p>
         </td>
		 <td>
            <p><strong><?php echo ($total_sale_by_academic_new_admission+$total_sale_by_academic_reregistration+$total_sale_by_academic_phd+$total_sale_by_academic_illp+$total_sale_by_exam_new_admission+$total_sale_by_exam_phd+$total_sale_by_exam_reregistration+$total_sale_by_exam_illp+$total_sale_by_internal_external); ?></strong></p>
         </td>
		 
      </tr>
   </tbody>
</table></div>

</div>



</div>
					
					
			    </div>
			</div>
		</div>
	</div>
</div>	

                                    
                                </div>
                                </div>
                            </div>
                           
                        </div>
             </div>   
                       
                    </div>
                </div>
           
        </div>
            
    </div>
<style>
tr.collapse.in {
  display:table-row;
}

/* GENERAL STYLES */
body {
    
    font-family: Verdana;
}

/* FANCY COLLAPSE PANEL STYLES */
.fancy-collapse-panel .panel-default > .panel-heading {
padding: 0;

}
.fancy-collapse-panel .panel-heading a {
padding: 12px 35px 12px 15px;
display: inline-block;
width: 100%;
background-color:#136fab;
color: #ffffff;
font-size: 16px;
font-weight: 200;
position: relative;
text-decoration: none;

}
.fancy-collapse-panel .panel-heading a:after {
font-family: "FontAwesome";
content: "\f147";
position: absolute;
right: 20px;
font-size: 20px;
font-weight: 400;
top: 50%;
line-height: 1;
margin-top: -10px;

}

.fancy-collapse-panel .panel-heading a.collapsed:after {
content: "\f196";
}
.hidden_color{
	background-color:white !important;
}


</style>
<script>
$('#dt-datepicker1').datepicker( {format: 'yyyy-mm-dd',endDate: '+0d',autoclose: true});

var tableToExcel = (function() {
  var uri = 'data:application/vnd.ms-excel;base64,'
    , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--><meta http-equiv="content-type" content="text/plain; charset=UTF-8"/></head><body><table>{table}</table></body></html>'
    , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
    , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
  return function(table, name) {
    if (!table.nodeType) table = document.getElementById(table)
    var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
    window.location.href = uri + base64(format(template, ctx))
  }
})()
</script>

<script type="text/javascript">
       function makePDF() {
    //$("#excel_dwld").addClass('hidden');
	 //$("#pdf_dwld").addClass('hidden');
	 //$("#btn_submit").addClass('hidden');
	 $("#report_date").removeClass('hidden');
	 
	 // $("#dt-datepicker1").addClass('hidden_color');
	
	
	 
    var quotes = document.getElementById('table_data1');

    html2canvas(quotes, {
        onrendered: function(canvas) {

        //! MAKE YOUR PDF
        var pdf = new jsPDF('p', 'pt', 'letter');

        for (var i = 0; i <= quotes.clientHeight/980; i++) {
            //! This is all just html2canvas stuff
            var srcImg  = canvas;
            var sX      = 0;
            var sY      = 980*i; // start 980 pixels down for every new page
            var sWidth  = 1500;
            var sHeight = 980;
            var dX      = 0;
            var dY      = 0;
            var dWidth  = 1500;
            var dHeight = 980;

            window.onePageCanvas = document.createElement("canvas");
            onePageCanvas.setAttribute('width', 2000);
            onePageCanvas.setAttribute('height', 980);
            var ctx = onePageCanvas.getContext('2d');
            // details on this usage of this function: 
            // https://developer.mozilla.org/en-US/docs/Web/API/Canvas_API/Tutorial/Using_images#Slicing
            ctx.drawImage(srcImg,sX,sY,sWidth,sHeight,dX,dY,dWidth,dHeight);

            // document.body.appendChild(canvas);
            var canvasDataURL = onePageCanvas.toDataURL("image/png", 1.0);

            var width         = onePageCanvas.width;
            var height        = onePageCanvas.clientHeight;

            //! If we're on anything other than the first page,
            // add another page
            if (i > 0) {
                pdf.addPage(900, 791); //8.5" x 11" in pts (in*72)
            }
            //! now we declare that we're working on that page
            pdf.setPage(i+1);
            //! now we add content to that page!
            pdf.addImage(canvasDataURL, 'PNG', 20, 40, (width*.62), (height*.62));

        }
        //! after the for loop is finished running, we save the pdf.
        pdf.save('daily_collection_report.pdf');
		 //$("#excel_dwld").removeClass('hidden');
	     //$("#pdf_dwld").removeClass('hidden');
		 // $("#dt-datepicker1").css("border", "1px solid #e5e5e5"); 
		   //$("#btn_submit").removeClass('hidden');
		    $("#report_date").addClass('hidden');
    }
  });
}
    </script>
