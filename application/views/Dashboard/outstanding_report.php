     <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
	<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">


<style>
.isoStickerWidget {
    width: 100%;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-align: stretch;
    align-items: stretch;
    overflow: hidden;
    border-radius: 5px;
}

.isoStickerWidget .isoIconWrapper {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-align: center;
    align-items: center;
    -ms-flex-pack: center;
    justify-content: center;
    width: 80px;
    -ms-flex-negative: 0;
    flex-shrink: 0;
    background-color: rgba(0, 0, 0, 0.1);
}
.isoStickerWidget .isoContentWrapper {
    width: 100%;
    padding: 20px 5px 20px 13px;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-direction: column;
    flex-direction: column;
}
.isoStickerWidget .isoContentWrapper .isoStatNumber {
    font-size: 18px;
    font-weight: 500;
    line-height: 1.1;
    margin: 0 0 5px;
}
.isoStickerWidget .isoContentWrapper .isoLabel {
    font-size: 15px;
    font-weight: 400;
    margin: 0;
    line-height: 1.2;
}
.isoStickerWidget .isoIconWrapper i {
    font-size: 30px;
    color: rgb(255, 255, 255)
}
.ant-col-md-6 {
    display: block;
    width: 20%; float:left;
}
.isoWidgetsWrapper {
    margin: 0 10px;color:#fff;
}
.isoSaleWidget {
    width: 100%;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-direction: column;
    flex-direction: column;
    padding: 30px;
    background-color: #ffffff;
    overflow: hidden;
    border: 1px solid #ebebeb;
}
.isoSaleWidget .isoSaleLabel {
    font-size: 14px;
    font-weight: 700;
    line-height: 1.2;
    text-transform: uppercase;
    color: #323332;
    margin: 0 0 20px;
}
.isoSaleWidget .isoSalePrice {
    font-size: 28px;
    font-weight: 300;
    line-height: 1.2;
    margin: 0 0 20px;
color: rgb(247, 93, 129);
}
.isoSaleWidget .isoSaleDetails {
    font-size: 13px;
    font-weight: 400;
    line-height: 1.5;
    color: #979797;
    margin: 0;
}
/**/
a:hover,a:focus{
    outline: none;
    text-decoration: none;
}
.tab .nav-tabs{
    border: 1px solid #1fc1dd;
}
.tab .nav-tabs li{
    margin: 0;
}
.tab .nav-tabs li a{
    font-size: 14px;
    color: #999898;
    background: #fff;
    margin: 0;
    padding: 10px 25px;
    border-radius: 0;
    border: none;
    border-right: 1px solid #ddd;
    text-transform: uppercase;
    position: relative;
}
.tab .nav-tabs li a:hover{
    border-top: none;
    border-bottom: none;
    border-right-color: #ddd;
}
.tab .nav-tabs li.active a,
.tab .nav-tabs li.active a:hover{
    color: #fff;
    border: none;
    background: #1fc1dd;
    border-right: 1px solid #ddd;
}
.tab .nav-tabs li.active a:before{
    content: "";
    width: 68%;
    height: 4px;
    background: #fff;
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    margin: 0 auto;
}
.tab .nav-tabs li.active a:after{
    content: "";
    border-top: 10px solid #1fc1dd;
    border-left: 10px solid transparent;
    border-right: 10px solid transparent;
    position: absolute;
    bottom: -10px;
    left: 43%;
}
.tab .tab-content{
    font-size: 13px;
    color: #999898;
    line-height: 25px;
    background: #fff;
    padding: 20px;
    border: 1px solid #1fc1dd;
    border-top: none;
}
.tab .tab-content h3{
    font-size: 24px;
    color: #999898;
    margin-top: 0;
}
.icomon{
    background-color:#7ed320;
    border-radius: 100%;
    padding: 10px;
	 color:#fff;
    margin-top: 6px;
    font-size: 15px;
}
.icomon:hover{
    background-color: #fff;
    color:#000;
} 
 .isoContentWrapper1 {display:inline-block!important;}
 
@media only screen and (max-width: 480px){
    .tab .nav-tabs li{
        width: 100%;
        text-align: center;
    }
    .tab .nav-tabs li.active a,
    .tab .nav-tabs li.active a:after,
    .tab .nav-tabs li.active a:hover{
        border: none;
    }
}



@media only screen and (max-width: 768px){
.ant-col-md-6 {
    display: inline-block;
    width: 50%;
    float: left;
    margin: 10px 0px;
    /* height: 93px; */
}
.isoStickerWidget .isoContentWrapper {
    padding: 10px;
}
}

.t1{
	background-color:#EBDEF0;
}
.t2{
	background-color:#82E0AA;
}
.t3{
	background-color:#D6EAF8;
}
.t4{
	background-color:#F9E79F;
}
.t5{
	background-color:#D6DBDF;
}
</style>
			
	<style>
	.tooltip {
  font-size: 15px;
}
.tooltip .tooltip-inner {
  background-color: #000;
  color: #fff;
    font-size: 15px;
}
	.table{width: 100%;}
	table{max-width: 100%;}
	</style>

<?php
//echo $refunds.">>".$opening_balance.">>".$other_fees.">>";
?>
<script>
$('#dt-datepicker1').datepicker( {format: 'yyyy-mm-dd',endDate: '+0d',autoclose: true});
</script>
           
    </head>
 
 <div id="content-wrapper">
     <div class="row">
     <div class="col-md-12">
          <div class="col-md-12">
        <div class="panel">
        					<div class="panel-heading">
        						<span class="panel-title">Admission fees summary report</span>
        					</div>
        					<div class="panel-body">
							<form id="form" name="form" action="<?=base_url($currentModule.'/outstanding_report')?>" method="POST"> 
					   <div class="col-sm-12" >
					    <div class="col-sm-2" >
                             <select  class="form-control" name="by_type" id="by_type"  required>
							 <option value="1" 
							 <?php
									echo "selected";
								 ?>
							  
							  >By Deposited Date</option>
							  </select>
                              </div>
							<div class="col-sm-2" >
								<select class="form-control" name="academic_year" >
									<option value="2023" <?php if($academic_year=='2023'){ echo 'selected';}?>>2023</option>
									<option value="2024"  <?php if($academic_year=='2024'){ echo 'selected';}?>>2024</option>
									<option value="2025"  <?php if($academic_year=='2025'){ echo 'selected';}?>>2025</option>
								</select>
								<!--input type="text" class="form-control" name="academic_year"  value="2022"-->
                               
                              </div>
							  <div class="col-sm-2" >
							  <input type="text" class="form-control" name="cdate" id="dt-datepicker1" value="<?php

                                if(isset($cdate)){
									echo $cdate;
								} else{

								echo  date( 'Y-m-d');} ?>" placeholder="From Date" required>
								</div>
							  
							  <div class="col-sm-2"> <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Search</button> </div>
							  
							  
							  <!--button type="button" id="excel_dwld" class="btn btn-primary" onclick="tableToExcel('table_data', 'ss')" =>Export to Excel</button>
							  <button type="button" class="btn btn-primary" id="pdf_dwld" onclick="makePDF()" =>Download PDF</button-->
							
					</div>
					 </form>  
					
					
					 
					<div class="clearfix"></div>
        					<div class="col-md-12">
							<?php
        					    
								$i=1;
								//print_r($fees);
									//if(!empty($fees)){
										//foreach($fees as $stud){
											//echo 'reg-'.$getFeeReceived_reg;echo '<br>';
											//echo 'new-'.$getFeeReceived_new;echo '<br>';
										$opening_receivable =$opening_balance_new+$opening_balance_reg;
										
										$total_fees_receivable=$getTotalfee_reg+$getTotalfee_new+ $other_fees_reg+$other_fees_new;
										
										$total_refund=$refunds_reg + $refunds_new;
										
										$scholarship_given =$getExemfee_new+$getExemfee_reg;
										
										$total_fees_paid =$getFeeReceived_reg+$getFeeReceived_new -($total_refund); echo '<br>';
										
										$pending_fees_receivable =$total_fees_receivable+$opening_balance_reg-$total_fees_paid;
										
										$opening_receivable =$opening_balance_new+$opening_balance_reg;
										
										$pending_opening_fees_receivable =$opening_receivable-$fees['opening_amount_paid'];
								?>
							<div class="table-responsive" style="overflow-x:auto;">
        					<table id='example' class="table table-bordered table-hover display" >
							 <thead>
        					    <tr class="themecolor">
        					        <th >#</th>
        					        <th class="t4">New Admissions</th>
									<th class="t4">Re-Registration</th>
        					        <th class="t4">Total Admissions</th>
									<th class="t3">Today's Collections</th>
									<th class="t3">Cumu-monthly Collections</th>
									<th class="t3">Total-Cumu Collections</th>
									<th class="t2">Total Receivable</th>
									<th class="t2">Scholarship Given</th>
									<th class="t2">Pending Receivable</th>
									
									<th class="t5">Today's Opening Collections</th>
									<th class="t5">Total-Cumu Opening Collections</th>
									<th class="t5">Total Opening Receivable</th>									
									<th class="t5">Pending Opening Receivable</th>
        					        
									<th class="t1">Receivable from Student-Pending</th>
									<th class="t1">Receivable from Scholarship-Pending</th>									
									<th class="t1">Total Receivable -Pending</th>
        					   </tr>
							    </thead>
        					   <tbody>
        					    
									<tr>
										<td><?=$i?></td>
										<td class="t4"><a href="<?=base_url()?>account/admission_fees_report/<?=$academic_year?>/N/2/All/both" target="_blank"><?=$getTotalAdmNew['newadd']?></a></td>
										<td class="t4"><a href="<?=base_url()?>account/admission_fees_report/<?=$academic_year?>/N/2/All/both" target="_blank"><?=$getTotalAdm_reg['rr_adm']?></a></td>
										<td class="t4"><a href="<?=base_url()?>account/admission_fees_report/<?=$academic_year?>/N/2/All/both" target="_blank"><?=$getTotalAdmNew['newadd']+$getTotalAdm_reg['rr_adm']?></a></td>
										<td class="t3"><?=money_format('%!.0n',$fees['todays_collection'])?></td>
										<td class="t3"><?=money_format('%!.0n',$fees['dec_collection'])?></td>
										<td class="t3"><?=money_format('%!.0n',$total_fees_paid)?></td>
										<td class="t2"><?php echo "".money_format('%!.0n',round($total_fees_receivable));?></td>
										<td class="t2"><?=money_format('%!.0n',$scholarship_given)?></td>
										<td class="t2"><?=money_format('%!.0n',$pending_fees_receivable)?></td>
										
										<td class="t5">0</td>
										<td class="t5"><?=money_format('%!.0n',$fees['opening_amount_paid'])?></td>
										<td class="t5"><?=money_format('%!.0n',$opening_receivable)?></td>
										<td class="t5"><?=money_format('%!.0n',$pending_opening_fees_receivable)?></td>
										
										<td class="t1"><?=money_format('%!.0n',$pending_fees_receivable)?></td>
										<td class="t1"><?=money_format('%!.0n',0)?></td>
										<td class="t1"><?=money_format('%!.0n',$pending_fees_receivable)?></td>
									</tr>
								<?php
										//$i++;
										//}
									//}
										?>
        					       
        					       
        					   </tbody>
        					    </table>
								</div>
        					
     
        					</div>	
        					
        					</div>
        </div>
        </div>
        
     </div>
     </div> <!-- / .row --> 			
     </div>
     </div> <!-- / .row --> 
     
     
  
	</div> <!-- / #content-wrapper -->
	<div id="main-menu-bg"></div>
</div> <!-- / #main-wrapper -->

<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css">
<script>
$('#dt-datepicker1').datepicker( {format: 'yyyy-mm-dd',endDate: '+0d',autoclose: true});
	$(document).ready(function() {
    $('#example').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel'
        ]
    } );
} );
</script>
		
				
