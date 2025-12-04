<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>

<style>
.attexl table{
	 border: 1px solid black;
}
.attexl table th{
 border: 1px solid black;
    padding: 5px;
    background-color:grey;
    color: white;
}
.attexl table td{
	 border: 1px solid black;
    padding: 5px;
}

th, td { white-space: nowrap;  }
td>input { white-space: nowrap;width:100%;padding:2px 3px }
element {
    width: 19.2333px;
}
.table.table-bordered thead > tr > th {
    border-bottom: 0;
        border-bottom-color: currentcolor;
}
table.dataTable thead th{padding: 5px 30px;}
.cal-table tr th{padding:4px 20px!important;}
.header{
        position:sticky;
        top: 0 ;
    }
	.panel-body {
    padding: 0px!important;

</style>

<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
	
	//211949
	//echo "<pre>";
	//print_r($emp_sal);
	//exit;
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Staff Payment</a></li>
        <li class="active"><a href="#">Staff Salary Details </a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Staff Salary Details </h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                </div>
            </div>
        </div>
      
        <div class="row ">
            <div class="col-sm-12">                
                        <div class="table-info">	 
									 <div class="panel panel-warning">
              <div class="panel-heading ">
              <div class="row">
<div class="col-md-6 text-left">
              <strong>Staff Salary <?php //if(isset($fordepart) && isset($forschool)){echo $fordepart.'Department['.$forschool."]"; } else{ unset($forschool);unset($fordepart);echo "All Deartment and All School";}?> For 
								<?php echo date("F", mktime(0, 0, 0, $month_name, 10))." ".$year_name;
                               /*  $d = date_parse_from_format("Y-m-d", $inc_dt);
								//print_r($d);
								$msearch=$d["month"];
							$month_name = date("F", mktime(0, 0, 0, $msearch, 10));
                                $ysearch=$d["year"];
								 */?>
								</strong>
</div>
<div class="col-md-6 text-left">
								<label class="col-md-5">Select Month And Year</label>
								 <form id="form" name="form" action="<?=base_url($currentModule.'/staff_salary')?>" method="POST" >
							
								  <input id="dob-datepicker" required class="date-picker col-md-4" name="attend_date" value="<?=$attend_date?>" placeholder="Month & Year" type="text">
                        
                          <input type="submit" class="btn btn-primary btn-xs col-md-2 pull-right" name="submit" value="View">
                        </form>            
</div>
</div>
								</div>
								<?php if(!empty($emp_sal)){?>
                                <div class="panel-body" style="height:450px;overflow:scroll;">
								  <form id="form" name="form" action="<?=base_url($currentModule.'/add_staff_monthly_sal')?>" method="POST" >
								  <div class="form-group" >
								
								 <input type="hidden" id="dt1" name="for_month_year" value="<?=$dt1?>">
								<input type="hidden" id="dt2"  value="<?php  echo date('M Y',strtotime($dt1));?>">
								
								
								  <table  id="saltab" class="table table-bordered table-hover cal-table" width="100%"  style="font-size:12px;border:1px solid;">
								<thead style="position: sticky;top: 0" class="thead-dark">
								  <tr>
								  <th style="border: 1px solid black;" colspan="6" ></th>
								   <th style="border: 1px solid black;text-align:center;font-size:15px;background-color:#66d566!important;" colspan="9" ><b>Earnings</b></th>
								    <th style="border: 1px solid black;" colspan="1" ></th>
									 <th style="border: 1px solid black;text-align:center;font-size:15px;background-color:#909ddf!important;" colspan="3" ><b>CTC Salary</b></th>
									 
									 <th style="border: 1px solid black;text-align:center;font-size:15px;background-color:#800046!important;" colspan="10" ><b>Deductions</b></th>
									  <th style="border: 1px solid black;" colspan="4" ></th>
								  </tr>
								  <tr bgcolor="#9ed9ed"  >
	                              <th>Sr No.</th>
	                              <th>Staff Id</th>
	                              <th>Staff Name</th>
								  <th>Basic Sal</th>
								  <th>M. Days</th>
	                              <th>Days</th>
	                              <th>Basic Sal.</th>
								  <th>DP</th>
								   <th>DA</th>
	                              <th>HRA</th>
	                              <th>TA</th>
	                              <th>Increment</th>
	                              <th>Difference</th>
	                              <th>Other A.</th>
	                              <th>Special A.</th>
	                              <th>Gross Total</th>
	                              <th>Gratuity</th>
	                              <th>ER EPF</th>
								  <th>Total CTC</th>
								  <th>EPF</th>
								  <th>Gratuity</th>
								  <th>ER EPF</th>
	                              <th>PTAX</th>
	                              <th>TDS</th>
	                              <th>Bus Ded.</th>
	                              <th>Mob-Bill</th>
								  <th>CoOpSoc</th>
	                              <th>Office Adv.</th>	                              
	                              <th>Other Deduc(Adv.)</th>
								  <th>Total Deductions</th>
	                              <th>Net Salary</th>
	                            
								  </tr>
								   </thead>
								   <tbody>
								  <?php $i=0;$j=0;$epf=0;$ptax=0;	
								//echo "kk".$flag;
								$d=cal_days_in_month(CAL_GREGORIAN,$month_name,$year_name);
								 if($flag =='0'){
									  foreach($emp_sal as $key=>$val){
										  if($emp_sal[$key]['pdays']!=0)
									  	 if($emp_sal[$key]['gender']=='male'){$pr = 'Mr.';}else if($emp_sal[$key]['gender']=='female'){ $pr = 'Mrs.';}
										   echo"<tr id='".$j."'>";
									  echo"<td >".++$i."</td>";										 
                                      echo"<td >".$emp_sal[$key]['emp_id']."</td>";
									  echo"<td >".$pr." ".$emp_sal[$key]['fname']." ".$emp_sal[$key]['mname']." ".$emp_sal[$key]['lname']."</td>";
                                     echo"<td class='basc' ><span>".$emp_sal[$key]['basic_salary']."</span></td>";
									  echo"<td class='mon'><span>".$d."</span></td>";
									  echo"<td class='pdys'><span >".$emp_sal[$key]['pdays']."</span></td>";
                                      echo"<td class='basic_sal_c'><span>".$emp_sal[$key]['basic_sal']."</span></td>";
									  echo"<td class='dp'><span >".$emp_sal[$key]['dp']."</span></td>";									 
                                      echo"<td class='da'><span >".$emp_sal[$key]['da']."</span></td>";
									  echo"<td class='hra'><span >".$emp_sal[$key]['hra']."</span></td>";
									  echo"<td class='ta'><span>".$emp_sal[$key]['ta']."</span></td>";
									  echo"<td class='increment'><span>".$emp_sal[$key]['increment']."</span></td>";
									  echo"<td ><span>".$emp_sal[$key]['difference']."</span></td>";
									  echo"<td class='otha'><span >".$emp_sal[$key]['other_allowance']."</span></td>";
									  echo"<td class='spea'><span >".$emp_sal[$key]['special_allowance']."</span></td>";
									  echo"<td >".$emp_sal[$key]['gross']."</td>";
									  echo"<td class='gratuity'><span >".$emp_sal[$key]['gratuity']."</span></td>";
									  echo"<td class='epf_er'><span >".$emp_sal[$key]['epf_er']."</span></td>";
									  echo"<td class='ctc'><span >".$emp_sal[$key]['ctc']."</span></td>";
									  echo"<td class='epf'><span >".$emp_sal[$key]['epf']."</span></td>";
									  echo"<td class='gratuity'><span >".$emp_sal[$key]['gratuity']."</span></td>";
									  echo"<td class='epf_er'><span >".$emp_sal[$key]['epf_er']."</span></td>";
									  echo"<td class='ptax'><span >".$emp_sal[$key]['ptax']."</span></td>";									  
									  echo"<td ><span>".$emp_sal[$key]['TDS']."</td>";
									  
									  echo"<td >".$emp_sal[$key]['bus_fare']."</td>";
									  echo"<td >".$emp_sal[$key]['mobile_bill']."</td>";
									  echo"<td >".$emp_sal[$key]['co_op_society']."</td>";
									  echo"<td >".$emp_sal[$key]['Off_Adv']."</td>";									  
									  echo"<td >".$emp_sal[$key]['other_advance']."</td>";
									  echo"<td >".$emp_sal[$key]['total_deduct']."</td>";
									  echo"<td >".$emp_sal[$key]['final_net_sal']."</td>";
									  	 echo"</tr>";
									$j++; 
										  
									  }
								 }else{
								 	//echo "<pre>";
								 	//print_r($emp_sal);exit;
								  foreach($emp_sal as $key=>$val){
									  
									  /*********salary calculation part**********/
									   if($emp_sal[$key]['pdays']!=0){
									 $mons = date('m',strtotime($dt1.'-01'));
									 $month = cal_days_in_month(CAL_GREGORIAN,date('m',strtotime($dt1)),date('Y',strtotime($dt1)));
									  $basic_sal=0;$dp=0;$da=0;$hra=0;$total_deduct=0;$final_net_sal=0;$epf=0;$gratuity=0;$epf_er=0;$ptax=0;$tds=0;$bus_ded=0;$mobile_bill=0;$Society_Charg=0;$Off_Adv=0;$Other_Deduct=0;$ctc=0; $gross=0;$ta=0;$diff_inc=0;$other_allowance=0;$special_allowance=0;$hostel_ded=0;$lic_ded=0;$NagarikSoc=0;  
									 
									 
									  if($emp_sal[$key]['emp_id']==211949){
										// print_r($emp_sal[$key]);
										// exit;
									  }
									  $Society_Charg = $this->Staff_payment_model->get_transaction_detail_amount($emp_sal[$key]['emp_id'],'Society_Charg',$dt1);
									 // echo $dt1;
									 $arrs = $this->Staff_payment_model->get_transaction_detail_amount($emp_sal[$key]['emp_id'],'Arrears',$dt1);
									 $diff_auto = $this->Staff_payment_model->get_transaction_detail_amount($emp_sal[$key]['emp_id'],'Difference',$dt1);
									 $diff_inc = $emp_sal[$key]['difference'] + $arrs + $diff_auto ;
									 $tds = $this->Staff_payment_model->get_transaction_detail_amount($emp_sal[$key]['emp_id'],'TDS',$dt1);	
									 $bus_ded = $this->Staff_payment_model->get_transaction_detail_amount($emp_sal[$key]['emp_id'],'Bus-fare',$dt1);	
									 $mobile_bill = $this->Staff_payment_model->get_transaction_detail_amount($emp_sal[$key]['emp_id'],'Mobile_Bill',$dt1);	
									 $Off_Adv = $this->Staff_payment_model->get_transaction_detail_amount($emp_sal[$key]['emp_id'],'Off_Adv',$dt1);	
									 $Other_Deduct = $this->Staff_payment_model->get_transaction_detail_amount($emp_sal[$key]['emp_id'],'Other_Deduct',$dt1);
									 
									  $tmp1 = $emp_sal[$key]['other_allowance']/$month;
									  $other_allowance = round($tmp1 * $emp_sal[$key]['pdays']);									   
									  $special_allowance = round(($emp_sal[$key]['special_allowance']/$month) * $emp_sal[$key]['pdays']);	
									 							
									  $ta = round(($emp_sal[$key]['ta']/$month) * $emp_sal[$key]['pdays']);
									  $increment = round(($emp_sal[$key]['increment']/$month) * $emp_sal[$key]['pdays']);
									  
									  
									  
									   if($emp_sal[$key]['scaletype']=="DW"){

										$basic_sal = round(($emp_sal[$key]['basic_salary'])*($emp_sal[$key]['pdays']));
								        $dp= round(($emp_sal[$key]['dp']/100)*$basic_sal);
									    $da= round(($emp_sal[$key]['da']/100)*$basic_sal); //convert float value to upper value using ceil
									   $hra= round(($emp_sal[$key]['hra']/100)*$basic_sal);
									 
									  //Gross Total calculation
									  $gross= $basic_sal+$dp+$da+$hra+$ta+$diff_inc+$other_allowance+$special_allowance;
										  //EPF-ER Calculation
									  if($emp_sal[$key]['pf_status']==0){
									  $epf_sum = $basic_sal+$dp+$da;
									  if($epf_sum<=15000){
										 $epf_er= ceil($epf_sum*0.13);
							
									  }elseif($epf_sum>=15001){
										 $epf_er=1950; 
									  }
										}else{
											$epf_er = '0';

										}
										
										//EPF Calculation
									if($emp_sal[$key]['pf_status']=='0'){
									  $epf_sum = $basic_sal+$dp+$da;
									  if($epf_sum<=15000){
										 $epf= round($epf_sum*0.12);
							
									  }elseif($epf_sum>=15001){
										 $epf=1800; 
									  }
									}else{
										$epf = '0';
									 // echo $emp_sal[$key]['gender'];
									}
									
									 if($emp_sal[$key]['gender']=='female'){
										  if($gross<=25000){
											$ptax='0'; 
										  }else{
											 
											if($mons == '02'){
												$ptax = 300;
											}else{
												$ptax = '200';
											}
											  
										  }
									  }elseif($emp_sal[$key]['gender']='male'){
										 if($gross<=7500){
											 $ptax='0';
											 
										 }elseif($gross>=7501 && $gross<=10000){
											 $ptax='175';
											 
										 }elseif($gross>=10001){
											 if($mons == '02'){
												$ptax = 300;
											}else{
											  $ptax = '200';
											}
										 }
									  }

										if($emp_sal[$key]['gratuity_status']==1){
										$gratuity = ceil(($basic_sal+$da)/26*15/12);
										}else{
											$gratuity = 0;
										}	

									 $ctc= $gross+$gratuity+$epf_er; 
                                     $total_deduct= $epf+$gratuity+$epf_er+$ptax+$tds+$bus_ded+$mobile_bill+$Society_Charg+$Off_Adv+$Other_Deduct;
                                                              
                                     $final_net_sal= round($ctc-$total_deduct);
									

									  }else{
									  
									  $tmp = $emp_sal[$key]['basic_salary']/$month;
									  $basic_sal = round($tmp * $emp_sal[$key]['pdays']);
									  $dp= round(($emp_sal[$key]['dp']/100)*$basic_sal);
									  $da= round(($emp_sal[$key]['da']/100)*$basic_sal); //convert float value to upper value using ceil
									  $hra= round(($emp_sal[$key]['hra']/100)*$basic_sal);
									  
									  //Gross Total calculation
									  $gross= $basic_sal+$dp+$da+$hra+$ta+$diff_inc+$other_allowance+$special_allowance;
									  
									if($emp_sal[$key]['pf_status']==0){
									  $epf_sum = $basic_sal+$dp+$da;
									  if($epf_sum<=15000){
										 $epf_er= ceil($epf_sum*0.13);
							
									  }elseif($epf_sum>=15001){
										 $epf_er=1950; 
									  }
									}else{
										$epf_er = '0';
									 // echo $emp_sal[$key]['gender'];
									}
									
									if($emp_sal[$key]['gratuity_status']==1){
										$gratuity = ceil(($basic_sal+$da)/26*15/12);
									}else{
										$gratuity = 0;
									}
									
									$ctc= $gross+$gratuity+$epf_er; 
									
									//Total Deduction calculations
									//EPF Calculation
									if($emp_sal[$key]['pf_status']=='0'){
									  $epf_sum = $basic_sal+$dp+$da;
									  if($epf_sum<=15000){
										 $epf= round($epf_sum*0.12);
							
									  }elseif($epf_sum>=15001){
										 $epf=1800; 
									  }
									}else{
										$epf = '0';
									 // echo $emp_sal[$key]['gender'];
									}
									
									//echo $ptax;
									   if($emp_sal[$key]['gender']=='female'){
										  if($gross<=25000){
											$ptax='0'; 
										  }else{
											 
											if($mons == '02'){
												$ptax = 300;
											}else{
												$ptax = '200';
											}
											  
										  }
									  }elseif($emp_sal[$key]['gender']='male'){
										 if($gross<=7500){
											 $ptax='0';
											 
										 }elseif($gross>=7501 && $gross<=10000){
											 $ptax='175';
											 
										 }elseif($gross>=10001){
											 if($mons == '02'){
												$ptax = 300;
											}else{
											  $ptax = '200';
											}
										 }
									  }	

									
									 
									$total_deduct= $epf+$gratuity+$epf_er+$ptax+$tds+$bus_ded+$mobile_bill+$Society_Charg+$Off_Adv+$Other_Deduct;
                                     //Final Net Salary

                                     //$final_net_sal= round($gross-$total_deduct);							 
                                     $final_net_sal= round($ctc-$total_deduct);		

									  }									 
									 /*****end of salary calculation part******/											  
									  if($emp_sal[$key]['gender']=='male'){$pr = 'Mr.';}else if($emp_sal[$key]['gender']=='female'){ $pr = 'Mrs.';}
									  echo"<tr id='".$j."'>";
									  echo"<td >".++$i."</td>";										 
                                      echo"<td ><input  type='hidden' name='ins[".$j."][emp_id]' value='".$emp_sal[$key]['emp_id']."'>".$emp_sal[$key]['emp_id']."</td>";
									  echo"<td ><input  type='hidden' name='ins[".$j."][ename]' value='".$pr." ".$emp_sal[$key]['fname']." ".$emp_sal[$key]['mname']." ".$emp_sal[$key]['lname']."'>".$pr." ".$emp_sal[$key]['fname']." ".$emp_sal[$key]['mname']." ".$emp_sal[$key]['lname']."</td>";
                                      echo"<td class='basc' >".$emp_sal[$key]['basic_salary']."</td>";
									  echo"<td class='mon'><span>".$month."</span><input type='hidden' name='ins[".$j."][month_days]' value='".$month."' /></td>";
									  echo"<td class='pdys'><span >".$emp_sal[$key]['pdays']."</span><input type='hidden' name='ins[".$j."][pdays]'  value='".$emp_sal[$key]['pdays']."' /></td>";
                                      echo"<td class='basic_sal_c'><span >".$basic_sal."</span><input type='hidden' name='ins[".$j."][basic_sal]'  value='".$basic_sal."' placeholder=''></td>";
									  echo"<td class='dp'><span >".$dp."</span><input   type='hidden' name='ins[".$j."][DP]' value='".$dp."' placeholder=''></td>";									 
                                      echo"<td class='da'><span >".$da."</span><input  type='hidden' name='ins[".$j."][DA]'  value='".$da."' placeholder=''></td>";
									  echo"<td class='hra'><span >".$hra."</span><input  type='hidden' name='ins[".$j."][HRA]' value='".$hra."' placeholder=''></td>";
									  echo"<td class='ta'><span>".$ta."</span><input  type='hidden' name='ins[".$j."][TA]' value='".$ta."' ></td>";
									  echo"<td class='increment'><span>".$increment."</span><input  type='hidden' name='ins[".$j."][increment]' value='".$increment."' ></td>";
									  echo"<td ><input id='ins".$j."' onblur='calculate_gross_amt(".$j.");' type='text' name='ins[".$j."][Incom_Diff]' value='".round($diff_inc)."' ></td>";
									  echo"<td class='otha'><span >".$other_allowance."</span><input   type='hidden' name='ins[".$j."][otherinc]' value='".$other_allowance."' ></td>";
									  echo"<td class='spea'><span >".$special_allowance."</span><input  type='hidden' name='ins[".$j."][special_allowance]' value='".$special_allowance."' ></td>";
									  echo"<td ><input  type='text' id='gross".$j."' name='ins[".$j."][gross]' value='".number_format($gross,2,'.','')."' ></td>";
									  echo"<td class='gratuity'><span>".$gratuity."</span><input  type='hidden' name='ins[".$j."][gratuity]' value='".$gratuity."' ></td>";
									  echo"<td class='epf_er'><span>".$epf_er."</span><input  type='hidden' name='ins[".$j."][epf_er]' value='".$epf_er."' ></td>";
									  echo"<td ><input  type='text' id='ctc".$j."' name='ins[".$j."][ctc]' value='".number_format($ctc,2,'.','')."' ></td>";
									  echo"<td ><input  type='text' id='epf".$j."' name='ins[".$j."][epf]' onblur='calculate_gross_amt(".$j.");' value='".$epf."' ></td>";
									  echo"<td class='gratuity2'><span>".$gratuity."</span><input  type='hidden' name='ins[".$j."][gratuity]' value='".$gratuity."' ></td>";
									  echo"<td class='epf_er2'><span>".$epf_er."</span><input  type='hidden' name='ins[".$j."][epf_er]' value='".$epf_er."' ></td>";
									  echo"<td><input  type='text' id='ptax".$j."' name='ins[".$j."][ptax]' onblur='calculate_gross_amt(".$j.");' value='".$ptax."' ></td>";									  
									  echo"<td ><input  type='text' placeholder='0' id='tds".$j."' onblur='calculate_gross_amt(".$j.");' name='ins[".$j."][TDS]'  value='".$tds."' ></td>";
									  echo"<td ><input  type='text' placeholder='0' id='busd".$j."' onblur='calculate_gross_amt(".$j.");' name='ins[".$j."][bus_ded]' value='".$bus_ded."' ></td>";
									  echo"<td ><input  type='text' placeholder='0' id='mobb".$j."' onblur='calculate_gross_amt(".$j.");' name='ins[".$j."][mobile_bill]' value='".$mobile_bill."' ></td>";
									  echo"<td ><input  type='text' placeholder='0' id='socc".$j."' onblur='calculate_gross_amt(".$j.");' name='ins[".$j."][Society_Charg]' value='".$Society_Charg."' ></td>";
									  echo"<td ><input  type='text' placeholder='0' id='offa".$j."' onblur='calculate_gross_amt(".$j.");' name='ins[".$j."][Off_Adv]' value='".$Off_Adv."' ></td>";									  
									  echo"<td ><input  type='text' placeholder='0' id='othd".$j."' onblur='calculate_gross_amt(".$j.");' name='ins[".$j."][Other_Deduct]' value='".$Other_Deduct."' ></td>";
									  echo"<td ><input  type='text' placeholder='0' id='totd".$j."' onblur='calculate_gross_amt(".$j.");' name='ins[".$j."][total_deduct]' value='".number_format($total_deduct,2,'.','')."' ></td>";
									  echo"<td ><input  type='text' placeholder='0' id='nets".$j."' onblur='calculate_gross_amt(".$j.");' name='ins[".$j."][final_net_sal]' value='".number_format($final_net_sal,2,'.','')."' ></td>";
									  //echo"<td><input type='hidden' name='ins[".$emp_sal[$key]['emp_id']."][for_month_year]' value='".$ysearch."-".$msearch."-"."01"."' placeholder=''></td>";
									 // echo"<td><input type='hidden' name='ins[".$j."][inserted_by]' value='".$this->session->userdata('uid')."' placeholder=''></td>";
									  //echo"<td><input type='hidden' name='ins[".$j."][inserted_date]' value='".date('Y-m-d h:i:s')."' placeholder=''></td>";
									 echo"</tr>";
									$j++; 
								    }
								  } ?>
								  </tbody>
								  </table>
								  </div>
								  <br>
								   <?php //if(in_array("Add",$my_privileges)){ ?>
								   <div class="form-group">
								   <div class="col-md-6" ></div>
                                      <div class=" col-md-2">  
                                           <!-- <input type="submit" class="btn btn-primary form-control" name="save" value="Save Staff Income Detail">-->
											<button class="btn btn-primary form-control" id="btn_submit1" type="submit" >Save</button>
                                        </div>
                                       <div class=" col-md-2">  
                                            <!--input type="submit" class="btn btn-primary form-control" name="cancel" value="cancel"-->
											<!--button onclick="ExportToExcel('xlsx')">Export table to excel</button-->
                                        </div> 
                                    </div>
								 <?php }//} ?>
								  </form>
								  </div>
								</div>
								</div>
									 <?php }elseif(empty($emp_sal)){
										 if(!empty($month_name)){
										 	if(!empty($this->session->flashdata('message1'))){
										echo"<span class='text-center col-md-12'><label style='color:red'>".$this->session->flashdata('message1')." for  ".date("F", mktime(0, 0, 0, $month_name, 10))."  ".$year_name."</label></span>"; 
}else if(!empty($this->session->flashdata('message2'))){
										echo"<span class='text-center col-md-12'><label style='color:red'>".$this->session->flashdata('message2')."</label></span>"; 
									}
									 }
									 }?>
															    
                          </div>                              
                        </div>
                    </div>
                </div>
            </div>    
        </div>
   

<script type="text/javascript">

function calculate_gross_amt(e){
	//alert(e);	
	var basic_sal_c = $('#'+e).closest("tr").find(".basic_sal_c").text();
	//alert(basic_sal_c);
	$('#'+e).closest("tr").find(".basic_sal_c").val(basic_sal_c);
	var dp = $('#'+e).closest("tr").find(".dp").text();
	var da = $('#'+e).closest("tr").find(".da").text();
	var hra = $('#'+e).closest("tr").find(".hra").text();
	var ta = $('#'+e).closest("tr").find(".ta").text();
	var diff = $('#ins'+e).val();
	var otha = $('#'+e).closest("tr").find(".otha").text();
	var spea = $('#'+e).closest("tr").find(".spea").text();
	
	var gratuity = $('#'+e).closest("tr").find(".gratuity").text();
	var epf_er = $('#'+e).closest("tr").find(".epf_er").text();
	
	var gratuity_val = Math.round(parseFloat(gratuity));
	var epf_er_val = Math.round(parseFloat(epf_er));
	$('#gross_salary').val('');
	//alert(gratuity);
	//alert(epf_er);
//alert(parseInt(basic_sal_c));

	var grosst = (parseFloat(basic_sal_c)+Math.round(parseFloat(da))+Math.round(parseFloat(hra))+Math.round(parseFloat(dp))+Math.round(parseFloat(ta))+Math.round(parseFloat(diff))+Math.round(parseFloat(otha))+Math.round(parseFloat(spea)));
	
$('#gross'+e).val(parseFloat(grosst).toFixed(2));
var ctc1 =parseFloat(grosst)+gratuity_val+epf_er_val;
var ctc =ctc1.toFixed(2);
//alert(ctc);
$('#ctc'+e).val(ctc);

var epf = $('#epf'+e).val();
	var ptax = $('#ptax'+e).val();
	var tds = $('#tds'+e).val();
	var busd = $('#busd'+e).val();
	var mobb = $('#mobb'+e).val();
	var socc = $('#socc'+e).val();
	var offa = $('#offa'+e).val();
	var othd = $('#othd'+e).val();
	
	
	var totd = ((gratuity_val!=''?parseFloat(gratuity_val):0)+(epf_er_val!=''?parseFloat(epf_er_val):0)+(epf!=''?parseFloat(epf):0)+(ptax!=''?parseFloat(ptax):0)+(tds!=''?parseFloat(tds):0)+(busd!=''?parseFloat(busd):0)+(mobb!=''?parseFloat(mobb):0)+(offa!=''?parseFloat(offa):0)+(othd!=''?parseFloat(othd):0)+(socc!=''?parseFloat(socc):0));
	//alert(totd);
	$('#totd'+e).val(parseFloat(totd).toFixed(2));
	
//var final_net_sal= (parseFloat(grosst)-parseFloat(totd));
var final_net_sal= (parseFloat(ctc)-parseFloat(totd));
$('#nets'+e).val('');
$('#nets'+e).val(parseFloat(final_net_sal).toFixed(2));	
	
}
$(document).ready(function(){
	 
	$('#dob-datepicker').datepicker( {format: "yyyy-m",startView: "months",minViewMode: "months",autoclose:true});
	var content = '<tr>'+$('#eduDetTable tbody tr').html()+'</tr>';
	$("#eduDetTable").on("click","input[name='addMore']", function(e){	
	//$("input[name='addMore']").on('click',function(){		
		//var content = $(this).parent().parent('tr').clone('true');
		$(this).parent().parent('tr').after(content);		
	});
	$("#eduDetTable").on("click","input[name='remove']", function(e){	
	//$("input[name='remove']").on('click',function(){
		var rowCount = $('#eduDetTable tbody tr').length;
		if(rowCount>1){
			$(this).parent().parent('tr').remove();
		}
	});	
	
	 $("#btnExport").click(function(e) {
		    window.open('data:application/vnd.ms-excel,' + $('#dvData').html());
    e.preventDefault();
});   
});
</script>
<script type="text/javascript">
function ExportToExcel(type, fn, dl) {
       var elt = document.getElementById('saltab');
       var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
       return dl ?
         XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }):
         XLSX.writeFile(wb, fn || ('MySheetName.' + (type || 'xlsx')));
    }
$(document).ready(function () {
    var table = $('#saltab').DataTable({
        orderCellsTop: true,
        fixedHeader: true,
                dom: 'lBfrtip',
            "bPaginate": false,
                "bInfo": false,
        buttons: [
            'excel'
        ]
    });
});
	
</script>

