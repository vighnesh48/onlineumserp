<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<style>
.total {
    font-weight: bold;
}

}
</style>
<script>
$(document).ready(function() {

  $(".toggle-accordion").on("click", function() {
    var accordionId = $(this).attr("accordion-id"),
      numPanelOpen = $(accordionId + ' .collapse.in').length;
    
    $(this).toggleClass("active");

    if (numPanelOpen == 0) {
      openAllPanels(accordionId);
    } else {
      closeAllPanels(accordionId);
    }
  })

  openAllPanels = function(aId) {
    console.log("setAllPanelOpen");
    $(aId + ' .panel-collapse:not(".in")').collapse('show');
  }
  closeAllPanels = function(aId) {
    console.log("setAllPanelclose");
    $(aId + ' .panel-collapse.in').collapse('hide');
  }
     
});
</script>
<style>
.table{width:100%;} 
table{max-width: 100%;}
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
                                   <?php
                                   switch($report_type){
                                       case "1":
                                   ?>
                                    	<table id="example" class="table table-bordered table-hover" width="100%">
							<thead>
							    <?php
							    if(!empty($adm_data)){
							      ?>
								<tr>
								    <th>S.No</th>
								    <th>Type</th> 
									<th >In-House </th>
									<th >Partnership  </th>
									<th >Cancel In-House </th>
									<th >Cancel Partnership </th>
									<th >Overall </th>
									<th >Active </th>
								</tr>
								</thead>
								<tbody>
									<tr>
										<td>1</td>
										<td>First Year</td>
										<td><?=$adm_data[0]['new_adm']?></td>
										<td><?=$adm_data[0]['part_new_adm']?></td>
										<td><?=$adm_data[0]['cancel_new_adm']?></td>
										<td><?=$adm_data[0]['cancel_part_new_adm']?></td>
										<td><?=$x=$adm_data[0]['new_adm']+$adm_data[0]['part_new_adm']+$adm_data[0]['cancel_new_adm']+$adm_data[0]['cancel_part_new_adm']?></td>
										<td class="total"><?=$y=$adm_data[0]['new_adm']+$adm_data[0]['part_new_adm']?></td>
									</tr>
									<tr>
										<td>2</td>
										<td>Direct Admission</td>
										<td><?=$adm_data[0]['di_adm']?></td>
										<td><?=$adm_data[0]['part_di_adm']?></td>
										<td><?=$adm_data[0]['cancel_di_adm']?></td>
										<td><?=$adm_data[0]['cancel_part_di_adm']?></td>
										<td><?=$x1=$adm_data[0]['di_adm']+$adm_data[0]['part_di_adm']+$adm_data[0]['cancel_di_adm']+$adm_data[0]['cancel_part_di_adm']?></td>
										<td class="total"><?=$y1=$adm_data[0]['di_adm']+$adm_data[0]['part_di_adm']?></td>
									</tr>
									
									<tr>
										<td>2</td>
										<td>Direct Third Year</td>
										<td><?=$adm_data[0]['new_adm_third']?></td>
										<td>0</td>
										<td>0</td>
										<td>0</td>
										<td><?=$adm_data[0]['new_adm_third']?></td>
										<td class="total"><?=$z1=$adm_data[0]['new_adm_third']?></td>
									</tr>
									
									
									<tr class="total">
										<td>3</td>
										<td>New Admission</td>
										<td><?=$adm_data[0]['di_adm']+$adm_data[0]['new_adm']+$adm_data[0]['new_adm_third']?></td>
										<td><?=$adm_data[0]['part_di_adm']+$adm_data[0]['part_new_adm']?></td>
										<td><?=$adm_data[0]['cancel_di_adm']+$adm_data[0]['cancel_new_adm']?></td>
										<td><?=$adm_data[0]['cancel_part_di_adm']+$adm_data[0]['cancel_part_di_adm']?></td>
										<td><?=$x+$x1?></td>
										<td class="total"><?=$y+$y1+$z1?></td>
									</tr>
									<tr class="total">
										<td>4</td>
										<td>Re-Registration </td>
										<td><?=$adm_data[0]['re_adm']?></td>
										<td><?=$adm_data[0]['part_re_adm']?></td>
										<td><?=$adm_data[0]['cancel_re_adm']?></td>
										<td><?=$adm_data[0]['cancel_part_re_adm']?></td>
										<td><?=$x2=$adm_data[0]['re_adm']+$adm_data[0]['part_re_adm']+$adm_data[0]['cancel_re_adm']+$adm_data[0]['cancel_part_re_adm']?></td>
										<td class="total"><?=$y2=$adm_data[0]['re_adm']+$adm_data[0]['part_re_adm']?></td>
									</tr>
									<tr class="total">
										<td>5</td>
										<td>Total</td>
										<td><?=$adm_data[0]['new_adm']+$adm_data[0]['di_adm']+$adm_data[0]['re_adm']?></td>
										<td><?=$adm_data[0]['part_new_adm']+$adm_data[0]['part_di_adm']+$adm_data[0]['part_re_adm']?></td>
										<td><?=$adm_data[0]['cancel_new_adm']+$adm_data[0]['cancel_di_adm']+$adm_data[0]['cancel_re_adm']?></td>
										<td><?=$adm_data[0]['cancel_part_new_adm']+$adm_data[0]['cancel_part_di_adm']+$adm_data[0]['cancel_part_re_adm']?></td>
										<td><?=$x+$x1+$x2+$z1?></td>
										<td class="total"><?=$y+$y1+$y2+$z1?></td>
									</tr>
									</tbody>
									</thead>
									</table>
							<?php
									}else{
									echo"Records are not found....";    

									}
                                   break;
                                   case"2":
                                       ?>
                                       <table id="example" class="table table-bordered table-hover" width="100%">
							<thead>
							    <?php
							    if(!empty($adm_data)){
							        ?>
								<tr>
								    <th>S.No</th>
									<th >School</th>
									<th >Course</th>
									<th >Stream </th>
									<th >Year</th>
									<th >Male</th>
									<th >Female</th>
									<th >Total</th>
									<th>Cancelled</th>
									<th>Active</th>
									</tr>

								</thead>
								<tbody>
								<?php				
								$i=1;
									$m=0;$f=0;$c=0;
										foreach($adm_data as $stud){

								?>
									<tr>
										<td><?=$i?></td>
										<td><?=$stud['school_short_name']?></td>
										<td><?=$stud['course_short_name']?></td>
										<td><?=$stud['stream_name']?></td>
										<td><?=$stud['year']?></td>
										<td><?=$stud['M']?></td>
										<td><?=$stud['F']?></td>
										<td class="total"><?=($stud['M']+$stud['F'])?></td>
										<td><?=$stud['cancel_adm']?></td>
										<td class="total"><?=($stud['M']+$stud['F'])-($stud['cancel_adm'])?></td>
										
									</tr>
								<?php
								     $m=$m+$stud['M'];
								     $f=$f+$stud['F'];
								     $c=$c+$stud['cancel_adm'];
										$i++;
										}

										echo'<tr class="total"><td colspan="5" class="text-right">Total</td><td>'.$m.'</td><td>'.$f.'</td><td>'.($m+$f).'</td><td>'.$c.'</td><td>'.(($m+$f)-$c).'</td></tr>';
				
									}else{
									    
										echo 'No records are found.';
									}
								?>
								
								</tbody>
							</table>
                                       <?php
                                       break;
                                       case"3":
                                       ?>
                                       <table id="example" class="table table-bordered table-hover" width="100%">
							<thead>
							    <?php
							    if(!empty($adm_data)){
							        ?>
								<tr>
								    <th rowsapn="2">S.No</th>
									<th rowsapn="2">School</th>
									<th rowsapn="2">Course</th>
									<th rowsapn="2">Stream </th>
									<th rowsapn="2">Year</th>
									<th colspan="3">Total</th>
									<th colspan="3">GM</th>
									<th colspan="3">OBC</th>
									<th colspan="3">SC</th>
									<th colspan="3">ST</th>
									<th colspan="3">NT-B</th>
									<th colspan="3">NT-C</th>
									<th colspan="3">NT-D</th>
									<th colspan="3">VJDT-A</th>
									<th colspan="3">SBC</th>
									<th colspan="3">SBCM</th>
									<th colspan="3">Hindu</th>
									<th colspan="3">Sikh</th>
									<th colspan="3">Jain</th>
									<th colspan="3">Chri</th>
									<th colspan="3">Mus</th>
									<th colspan="3">Budh</th>
									<th colspan="3">Handicap</th>
									<th colspan="3">Domicile</th>
									<th colspan="3">International</th>
									<th>Cancelled</th>
									</tr>
								    <tr>
								<td></td><td></td><td></td><td></td><td></td><td>M</td><td>F</td><td>T</td><td>M</td><td>F</td><td>T</td><td>M</td><td>F</td><td>T</td><td>M</td><td>F</td><td>T</td><td>M</td><td>F</td><td>T</td><td>M</td><td>F</td><td>T</td><td>M</td><td>F</td><td>T</td><td>M</td><td>F</td><td>T</td><td>M</td><td>F</td><td>T</td><td>M</td><td>F</td><td>T</td><td>M</td><td>F</td><td>T</td><td>M</td><td>F</td><td>T</td><td>MS</td><td>OMS</td><td>T</td><td>M</td><td>F</td><td>T</td><td></td>
								</tr>
								</thead>
								<tbody>
								<?php				
								$i=1;
									
										foreach($adm_data as $stud){
										
										
								?>
									<tr>
										<td><?=$i?></td>
										<td><?=$stud['school_short_name']?></td>
										<td><?=$stud['course_short_name']?></td>
										<td><?=$stud['stream_short_name']?></td>
										<td><?=$stud['year']?></td>
										<td><?=$stud['M']?></td>
										<td><?=$stud['F']?></td>
										<td class="total"><?=($stud['M']+$stud['F'])?></td>
										<td><?=$stud['GM-M']?></td>
										<td><?=$stud['GM-F']?></td>
										<td class="total"><?=($stud['GM-M'])+($stud['GM-F'])?></td>
										<td><?=$stud['OBC-M']?></td>
										<td><?=$stud['OBC-F']?></td>
										<td class="total"><?=($stud['OBC-M']+$stud['OBC-F'])?></td>
										<td><?=$stud['SC-M']?></td>
										<td><?=$stud['SC-F']?></td>
										<td class="total"><?=($stud['SC-M']+$stud['SC-F'])?></td>
										<td><?=$stud['ST-M']?></td>
										<td><?=$stud['ST-F']?></td>
										<td class="total"><?=($stud['ST-M']+$stud['ST-F'])?></td>
										
										<td><?=$stud['NT1-M']?></td>
										<td><?=$stud['NT1-F']?></td>
										<td class="total"><?=($stud['NT1-M']+$stud['NT1-F'])?></td>
										<td><?=$stud['NT2-M']?></td>
										<td><?=$stud['NT2-F']?></td>
										<td class="total"><?=($stud['NT2-M']+$stud['NT2-F'])?></td>
										<td><?=$stud['NT3-M']?></td>
										<td><?=$stud['NT3-F']?></td>
										<td class="total"><?=($stud['NT3-M']+$stud['NT3-F'])?></td>
										<td><?=$stud['VJDT-M']?></td>
										<td><?=$stud['VJDT-F']?></td>
										<td class="total"><?=($stud['VJDT-M']+$stud['VJDT-F'])?></td>
										<td><?=$stud['SBC-M']?></td>
										<td><?=$stud['SBC-F']?></td>
										<td class="total"><?=($stud['SBC-M']+$stud['SBC-F'])?></td>
										<td><?=$stud['SBCM-M']?></td>
										<td><?=$stud['SBCM-F']?></td>
										<td class="total"><?=($stud['SBCM-M']+$stud['SBCM-F'])?></td>
										
										
										<td><?=$stud['Hind-M']?></td>
										<td><?=$stud['Hind-F']?></td>
										<td class="total"><?=($stud['Hind-M']+$stud['Hind-F'])?></td>
										<td><?=$stud['Jai-M']?></td>
										<td><?=$stud['Jai-F']?></td>
										<td class="total"><?=($stud['Jai-M']+$stud['Jai-F'])?></td>
										<td><?=$stud['Sik-M']?></td>
										<td><?=$stud['Sik-F']?></td>
										<td class="total"><?=($stud['Sik-M']+$stud['Sik-F'])?></td>
										<td><?=$stud['Chri-M']?></td>
										<td><?=$stud['Chri-F']?></td>
										<td class="total"><?=($stud['Chri-M']+$stud['Chri-F'])?></td>
										<td><?=$stud['Bud-M']?></td>
										<td><?=$stud['Bud-F']?></td>
										<td class="total"><?=($stud['Bud-M']+$stud['Bud-F'])?></td>
										<td><?=$stud['Mus-M']?></td>
										<td><?=$stud['Mus-F']?></td>
										<td class="total"><?=($stud['Mus-M']+$stud['Mus-F'])?></td>
										<td><?=$stud['PHY-M']?></td>
										<td><?=$stud['PHY-F']?></td>
										<td class="total"><?=($stud['PHY-M']+$stud['PHY-F'])?></td>
										<td><?=$stud['MS']?></td>
										<td><?=$stud['OMS']?></td>
										<td class="total"><?=($stud['MS']+$stud['OMS'])?></td>
										<td ><?=$stud['INT-M']?></td>
										<td><?=$stud['INT-F']?></td>
										<td class="total"> <?=($stud['INT-M']+$stud['INT-F'])?></td>
										<td><?=$stud['cancel_adm']?></td>
										
									</tr>
								<?php
								
										$i++;
										}
										
										?>
										<?php?>
									
								
										
								<?php
									}else{
									    
										echo '
<div class="bs-example">
    <div class="alert alert-dager fade in">

        <a href="#" class="close" data-dismiss="alert">&times;</a>

        <strong>Warning!</strong> There is no data for selected Academic Year.
</div>
    </div>

';
									}
								?>
								
								</tbody>
							</table>
                                       <?php
                                       break;
                                       case"4":
                                       ?>
                                       <table id="example" class="table table-bordered table-hover" width="100%">
							<thead>
							    <?php
							    if(!empty($adm_data)){
							        ?>
								<tr>
								    <th>S.No</th>
									<th>City</th>
									<th>State</th>
									<th>Total</th>
									<th>B.Tech</th>
									<th>M.Tech</th>
									<th>LLB</th>
									<th>LLM</th>
									<th>D.PHARMA</th>
									<th>BBA </th>
									<th>MBA </th>
									<th>BSC</th>
									<th>MSC</th>
									<th>BCA</th>
									<th>MCA</th>
									<th>BSC-CS</th>
									<th>MSC-CS</th>
									<th>BCOM</th>
									<th>MCOM</th>
									<th>BA</th>
									<th>MA</th>
									<th>CERT</th>
									
									</tr>
								</thead>
								<tbody>
								<?php				
								$i=1;
									
										foreach($adm_data as $stud){
								?>
									<tr>
										<td><?=$i?></td>
										<td><?=$stud['district_name']?></td>
										<td><?=$stud['state_name']?></td>
										<td class="total"><?=$stud['city_total']?></td>
										<td><?=$stud['BTECH']?></td>
										<td><?=$stud['MTECH']?></td>
										<td><?=$stud['LLB']?></td>
										<td><?=$stud['LLM']?></td>
										<td><?=$stud['DPHRM']?></td>
										<td><?=$stud['BBA']?></td>
										<td><?=$stud['MBA']?></td>
										<td><?=$stud['BSC']?></td>
										<td><?=$stud['MSC']?></td>
										<td><?=$stud['BCA']?></td>
										<td><?=$stud['MCA']?></td>
										<td><?=$stud['BCS']?></td>
										<td><?=$stud['MCS']?></td>
										<td><?=$stud['BCOM']?></td>
										<td><?=$stud['MCOM']?></td>
										<td><?=$stud['BA']?></td>
										<td><?=$stud['MA']?></td>
										<td><?=$stud['CERT']?></td>
									
										
									</tr>
								<?php
								
										$i++;
										}
										
									
									}else{
									    
										echo '';
									}
								?>
								
								</tbody>
							</table>
                                       <?php
                                       break;
                                        case"5":
                                       ?>
                                       <table id="example" class="table table-bordered table-hover" width="100%">
							<thead>
							    <?php
							    if(!empty($adm_data)){
							        ?>
								<tr>
								    <th>S.No</th>
									<th>PRN</th>
									<th>Name</th>
									<th>Stream</th>
									<th>Year</th>
									<th>Actual Fees</th>
									<th>Scholorship</th>
									<th>Applicable</th>
								
									</tr>
								</thead>
								<tbody>
								<?php				
								$i=1;
									
										foreach($adm_data as $stud){
								?>
									<tr>
										<td><?=$i?></td>
										<td><?=$stud['enrollment_no']?></td>
										<td><?=$stud['first_name'].' ' .$stud['middle_name'].' '.$stud['last_name']?></td>
										<td><?=$stud['stream_short_name']?></td>
										<td><?=$stud['year']?></td>
										<td><?=$stud['actual_fee']?></td>
										<td><?=$stud['actual_fee']-$stud['applicable_fee']?></td>
										<td><?=$stud['applicable_fee']?></td>
										
									</tr>
								<?php
								
										$i++;
										}
										
									
									}else{
									    
										echo '';
									}
								?>
								
								</tbody>
							</table>
                                       <?php
                                       break;
                                        case"6":
                                       ?>
                                       <table id="example" class="table table-bordered table-hover" width="100%">
							<thead>
							    <?php
							    if(!empty($adm_data)){
							        ?>
								<tr>
								    <th>S.No</th>
									<th>PRN</th>
									<th>Name</th>
									<th>Stream</th>
									<th>Year</th>
										<th>Mobile</th>
									<th>Cancelled date</th>
									<th>Cancelled Fees</th>
									</tr>
								</thead>
								<tbody>
								<?php				
								$i=1;
									
										foreach($adm_data as $stud){
								?>
									<tr>
										<td><?=$i?></td>
										<td><?=$stud['enrollment_no_new']?></td>
										<td><?=$stud['first_name'].' ' .$stud['middle_name'].' '.$stud['last_name']?></td>
										<td><?=$stud['stream_short_name']?></td>
										<td><?=$stud['year']?></td>
											<td><?=$stud['mobile']?></td>
										<td><?=$stud['cancel_date']?></td>
										<td><?=$stud['canc_fee']?></td>
									</tr>
								<?php
								
										$i++;
										}
										
									
									}else{
									    
										echo '';
									}
								?>
								
								</tbody>
							</table>
                                       <?php
                                       break;
                                        case"7":
                                       ?>
                                      <table id="example" class="table table-bordered table-hover" width="100%">
							<thead>
							    <?php
							    if(!empty($adm_data)){
							        ?>
								<tr>
								    <th>S.No</th>
									<th>PRN</th>
									<th>Name</th>
									<th>Stream</th>
									<th>School</th>
									<th>Stream</th>
									<th>Year</th>
									<th>Mobile No</th>
									</tr>
								</thead>
								<tbody>
								<?php				
								$i=1;
									
										foreach($adm_data as $stud){
								?>
									<tr>
										<td><?=$i?></td>
										<td><?=$stud['enrollment_no']?></td>
										<td><?=$stud['first_name'].' ' .$stud['middle_name'].' '.$stud['last_name']?></td>
										<td><?=$stud['stream_short_name']?></td>
										<td><?=$stud['school_short_name']?></td>
										<td><?=$stud['stream_short_name']?></td>
											<td><?=$stud['year']?></td>
											<td><?=$stud['mobile']?></td>
									</tr>
								<?php
								
										$i++;
										}
										
									
									}else{
									    
										echo '';
									}
								?>
								
								</tbody>
							</table>
                                       <?php
                                       break;
                                        case"8":
                                       ?>
                                      <table id="example" class="table table-bordered table-hover" width="100%">
							<thead>
							    <?php
							    if(!empty($adm_data)){
									$str = mb_substr($stud[0]['enrollment_no'], 0, 2);
							        ?>
								<tr>
								    <th>S.No</th>
									<th>PRN</th>
									<th>Form no.</th>									
									<th>Admission Date</th>
									<th>Name</th>
									<th>Stream</th>
									<th>Year</th>
									<th>School</th>
									<th>Stream</th>
									<th>Student Mobile</th>
									<th>Parent Mobile</th>
									</tr>
								</thead>
								<tbody>
								<?php				
								$i=1;
									
										foreach($adm_data as $stud){
								?>
									<tr>
										<td><?=$i ?></td>
										<td><?=$stud['enrollment_no']?></td>
										<td><?=$stud['form_number']?></td>
										<?php if($str=='18'){ ?>
										<td><?=$stud['admission_date']?></td>
										<?php }else{
											echo "<td>-</td>";
										} ?>
										<td><?=$stud['first_name'].' ' .$stud['middle_name'].' '.$stud['last_name']?></td>
										<td><?=$stud['stream_short_name']?></td>
										<td><?=$stud['year']?></td>
										<td><?=$stud['school_short_name']?></td>
										<td><?=$stud['stream_short_name']?></td>
										<td><?=$stud['mobile']?></td>
										<td><?=$stud['parent_mobile2']?></td>
									</tr>
								<?php
								
										$i++;
										}
										
									
									}else{
									    
										echo '';
									}
								?>
								
								</tbody>
							</table>
                                       <?php
                                       break;
                                       case"9":
                                       ?>
                                      <table id="example" class="table table-bordered table-hover" width="100%">
							<thead>
							    <?php
							    if(!empty($adm_data)){
							        ?>
								<tr>
								    <th>S.No</th>
									<th>PRN</th>
									<th>Parent of </th>
									<th>Stream</th>
									<th>Year</th>
									<th>School</th>
									<th>Stream</th>
									<th>Parent Mobile</th>
									<th>Relation</th>
									<th>Occupation</th>
									</tr>
								</thead>
								<tbody>
								<?php				
								$i=1;
									
										foreach($adm_data as $stud){
								?>
									<tr>
										<td><?=$i?></td>
										<td><?=$stud['enrollment_no']?></td>
										<td><?=$stud['first_name'].' ' .$stud['middle_name'].' '.$stud['last_name']?></td>
										<td><?=$stud['stream_short_name']?></td>
										<td><?=$stud['year']?></td>
										<td><?=$stud['school_short_name']?></td>
										<td><?=$stud['stream_short_name']?></td>
										<td><?=$stud['parent_mobile2']?></td>
										<td><?=$stud['relation']?></td>
										<td><?=$stud['occupation']?></td>
									</tr>
								<?php
								
										$i++;
										}
										
									
									}else{
									    
										echo '';
									}
								?>
								
								</tbody>
							</table>
                                       <?php
                                       break;
                                        case"10":
                                       ?>
                                      <table id="example" class="table table-bordered table-hover" width="150%">
							<thead>
							    <?php
							    if(!empty($adm_data)){
							        ?>
							        <tr><td colspan="9"><h4>Approval List:&nbsp;&nbsp;&nbsp;<?=$adm_data[0]['stream_name']?>&nbsp;&nbsp;&nbsp;Year:<?=$adm_data[0]['year']?></h4></tr>
								<tr>
								    <th>S.No</th>
								    	<th>GRN with Photo</th>
								    	<th>Name<br> Mother Name<br> Parent Name</th>
									<!--<th>PRN<br>Student Id<br>Form No</th>-->
										<th>Permanent Add<br>Phone No<br>Email<br>Aadhar No. </th>
										 <th>Cast</th>
										 	 <th>DOB</th>
										 	 <th>Place of Birth</th>
										 	  <th>Name of the College last Attended</th>
										 	  <th>Date of Admission to University</th>
								<!--	<th>Student Name<br>Address<br>Email </th>-->
									<th>Gender<br>D.O.B<br>Religion<br>Category</th>
									<th>Mobile No<br>Adhar No<br>Blood Group</th>
									<th>Domicile<br>Nationality<br>Handicap</th>
									<th>Qualification</th>
								
									<th>Remark</th>
								</tr>
								</thead>
								<tbody>
								<?php				
								$i=1;
									
										foreach($adm_data as $stud){
										    if($stud['taluka_name']==$stud['district_name'] ){
										        $ads=$stud['taluka_name'];
										    }
										    else{
										        $ads=$stud['taluka_name'].'  '.$stud['district_name'] ;
										    }
										    $image=base_url('uploads/student_photo').'/'.$stud['enrollment_no'].".jpg";
										    $remark="";
										    if($stud['cancelled_admission']=="Y"){$remark="Admission Cancelled";}
								?>
									<tr>
										<td><?=$i?></td>
											<td><?=$stud['general_reg_no']?><img src="<?=$image?>" alt="" width="80" height="80"></td>
												<td><b><?=$stud['first_name'].' ' .$stud['middle_name'].' '.$stud['last_name']?></b><br><?=$stud['mother_name']?>
												<br><?=$stud['father_fname'].' ' .$stud['father_mname'].' '.$stud['father_lname']?></td>
									<!--	<td><b><?=$stud['enrollment_no'].'<br>'.$stud['enrollment_no_new']?></b><br><?=$stud['form_no']?></td>-->
									<td><?=strtoupper($stud['adds']).'  '. strtoupper($ads).'  '.strtoupper($stud['state_name']).'-'.$stud['pincode'].'<br>'.$stud['mobile'].'<br><i>'.$stud['email'].'</i><br>'.$stud['adhar_card_no']?></td>
									
									<!--	<td><b><?=$stud['first_name'].' ' .$stud['middle_name'].' '.$stud['last_name']?></b><br><?=strtoupper($stud['adds']).'  '. strtoupper($ads).'  '.strtoupper($stud['state_name']).'-'.$stud['pincode'].'<br><i>'.$stud['email']?></i></td>-->
										<td><?=$stud['sub_caste']?></td>
											<td><?=$stud['dob']?></td>
												<td><?=$stud['birth_place']?></td>
													<td><?=$stud['last_institute']?></td>
													<td><?=$stud['admission_date']?></td>
										<td><?=$stud['gender'].'<br>'.$stud['dob'].'<br>'.$stud['religion'].'<br>'.$stud['category']?></td>
								    	<td><?=$stud['mobile'].'<br>'.$stud['adhar_card_no'].'<br>'.$stud['blood_group']?></td>
										<td><?=$stud['domicile_status'].'<br>'.$stud['nationality'].'<br>'.$stud['physically_handicap']?></td>
										
										<td><?php
									
										if($stud['degree_type1']=="SSC"){
										    echo'SSC,'.sprintf('%0.2f',$stud['percentage1']).','.$stud['passing_year1'];
										}
										if($stud['degree_type2']=="HSC"){
										    echo '<br>HSC,'.sprintf('%0.2f',$stud['percentage2']).','.$stud['passing_year2'];
										}
										if($stud['degree_type3']=="Diploma"){
										    echo '<br>Diploma,'.sprintf('%0.2f',$stud['percentage3']).','.$stud['passing_year3'];
										}
										if($stud['degree_type4']=="Graduation"){
										    echo '<br>UG,'.sprintf('%0.2f',$stud['percentage4']).','.$stud['passing_year4'];
										}
										if($stud['degree_type5']=="Post Graduation"){
										    echo '<br>PG,'.sprintf('%0.2f',$stud['percentage5']).','.$stud['passing_year5'];
										}
										
										?>
										</td>
									
										<td><?=$remark?></td>
									</tr>
								<?php
								
										$i++;
										}
										
									
									}else{
									    
										echo '';
									}
								?>
								
								</tbody>
							</table>
                                       <?php
                                       break;
                                       case"14":
                                       ?>
                                      <table id="example" class="table table-bordered table-hover" width="150%">
							<thead>
							    <?php
							    if(!empty($adm_data)){
							        ?>
							       
								<tr>
								    <th>S.No</th>
									<th>PRN</th>
									<th>OLD PRN</th>
									<th>Form No</th>
									<th>Student Name</th>
									<th>Father Name</th>
									<th>Mother Name</th>
									<th>School </th>
									<th>Stream </th>
									<th>Year </th>
									<th>Address</th>
								    <th>City</th>
									<th>District</th>
									<th>State</th>
									<th>Pincode</th>
									<th>Mobile No</th>
									<th>Email </th>
									<th>Gender</th>
									<th>D.O.B</th>
									<th>Religion</th>
									<th>Category</th>
									<th>Adhar No</th>
									<th>Boold Group</th>
									<th>Domicile</th>
									<th>Nationality</th>
									<th>Handicap</th>
									<th>Admission Cancelled</th>
									<th>CET Det</th>
									<th>Last Exam Name</th>
									<th>Last Exam Marks</th>
									<th>Admission Year</th>	
                                    <th>Country</th>
									<th>Transfer Case</th>
									<th>Package</th>
								</tr>
								</thead>
								<tbody>
								<?php				
								$i=1;
									
										foreach($adm_data as $stud){
								?>
									<tr>
										<td><?=$i?></td>
										<td><?=$stud['enrollment_no']?></td>
										<td><?=$stud['enrollment_no_new']?></td>
										<td><?=$stud['form_number']?></td>
										<td><?=$stud['first_name'].' ' .$stud['middle_name'].' '.$stud['last_name']?></td>
										<td><?=$stud['father_fname'].' ' .$stud['father_mname'].' '.$stud['father_lname']?></td>
										<td><?=$stud['mother_name']?></td>
										<td><?=$stud['school_short_name']?></td>
										<td><?=$stud['stream_short_name']?></td>
										<td><?=$stud['year']?></td>
										<td><?=$stud['adds']?></td>
										<td><?=$stud['taluka_name']?></td>
										<td><?=$stud['district_name']?></td>
										<td><?=$stud['state_name']?></td>
										<td><?=$stud['pincode']?></td>
										<td><?=$stud['mobile']?></td>
										<td><?=$stud['email']?></td>
										<td><?=$stud['gender']?></td>
										<td><?=$stud['dob']?></td>
										<td><?=$stud['religion']?></td>
										<td><?=$stud['category']?></td>
										<td><?=$stud['adhar_card_no']?></td>
																		<td><?=$stud['blood_group']?></td>
																			<td><?=$stud['domicile_status']?></td>
																				<td><?=$stud['nationality']?></td>
																					<td><?=$stud['physically_handicap']?></td>
																					<td><?=$stud['cancelled_admission']?></td>
																	<td><?=$stud['CET']?></td>
																	
																		<td><?=$stud['last_exam']['degree_type']." ".$stud['last_exam']['degree_name']." ".$stud['last_exam']['passing_year'];?></td>
										<td><?=$stud['last_exam']['total_marks']."/".$stud['last_exam']['out_of_marks']?></td>
											<td><?=$stud['admission_session']?></td>
                                            <td><?=$stud['country_name']?></td>
											<td><?php if($stud['transefercase'] == 'Y'){
                                            	echo 'Yes';
                                            }else{
                                            	echo 'No';
                                            }  ?></td>
											<td><?php if($stud['belongs_to'] == 'Package'){
                                            	echo 'Yes';
                                            }else{
                                            	echo 'No';
                                            }  ?></td>
									</tr>
								<?php
								
										$i++;
										}
										
									
									}else{
									    
										echo '';
									}
								?>
								
								</tbody>
							</table>
                                       <?php
                                       
                                       break;
                                        case"15":
                                       ?>
                                      <table id="example" class="table table-bordered table-hover" width="150%">
							<thead>
							    <?php
							    if(!empty($adm_data)){
							        ?>
							       
								<tr>
								    <th>S.No</th>
									<th>PRN</th>
									<th>Student Name</th>
									<th>School </th>
									<th>Course </th>
									<th>Stream </th>
									<th>Year </th>
									<th>Mobile </th>
									<th>Email Id </th>
									<th>Admission Year</th>
								    <th>Admission Status</th>
									
								</tr>
								</thead>
								<tbody>
								<?php				
								$i=1;
									
										foreach($adm_data as $stud){
								?>
									<tr>
										<td><?=$i?></td>
										<td><?=$stud['reg_no']?></td>
										<td><?=$stud['student_name']?></td>
										<td><?=$stud['school_short_name']?></td>
										<td><?=$stud['stream_short_name']?></td>
										<td><?=$stud['course_short_name']?></td>
										<td><?=$stud['current_year']?></td>
										<td><?=$stud['mobile']?></td>
										<td><?=$stud['email']?></td>
                                        <td><?=$stud['admission_session']?></td>
										<td><?=$stud['Remark']?></td>
																		
									
									</tr>
								<?php
								
										$i++;
										}
										
									
									}else{
									    
										echo '';
									}
								?>
								
								</tbody>
							</table><?php
                                       break;
                                        case"17":
                                       ?>
                                      <table id="example" class="table table-bordered table-hover" width="100%">
							<thead>
							    <?php
							    if(!empty($adm_data)){
							        ?>
								<tr>
								    <th>S.No</th>
									<th>PRN</th>
									<th>Form no.</th>
									<th>Name</th>
									<th>Stream</th>
									<th>Year</th>
									<th>School</th>
									<th>Stream</th>
									<th>Student Mobile</th>
									<th>Parent Mobile</th>
                                    <th>Country</th>
									</tr>
								</thead>
								<tbody>
								<?php				
								$i=1;
									
										foreach($adm_data as $stud){
								?>
									<tr>
										<td><?=$i?></td>
										<td><?=$stud['enrollment_no']?></td>
										<td><?=$stud['form_number']?></td>
										<td><?=$stud['first_name'].' ' .$stud['middle_name'].' '.$stud['last_name']?></td>
										<td><?=$stud['stream_short_name']?></td>
										<td><?=$stud['year']?></td>
										<td><?=$stud['school_short_name']?></td>
										<td><?=$stud['stream_short_name']?></td>
										<td><?=$stud['mobile']?></td>
										<td><?=$stud['parent_mobile2']?></td>
                                        <td><?=$stud['country_name']?></td>
									</tr>
								<?php
								
										$i++;
										}
										
									
									}else{
									    
										echo '';
									}
								?>
								
								</tbody>
							</table>
                                       <?php
                                       
                                       
                                       
                                       break;
                                       
                                        case"16":
                                       ?>
                                      <table id="example" class="table table-bordered table-hover" width="150%">
							<thead>
							    <?php
							    if(!empty($adm_data)){
							        ?>
							       
								<tr>
								    <th>S.No</th>
									<th>PRN</th>
									<th>Student Name</th>
									<th>School </th>
									<th>Course </th>
									<th>Stream </th>
									<th>Year </th>
										<th>Mobile </th>
									<th>Email Id </th>
									<th>Admission Year</th>
								    <th>Admission Status</th>
									
								</tr>
								</thead>
								<tbody>
								<?php				
								$i=1;
									
										foreach($adm_data as $stud){
								?>
									<tr>
										<td><?=$i?></td>
										<td><?=$stud['reg_no']?></td>
										<td><?=$stud['student_name']?></td>
										<td><?=$stud['school_short_name']?></td>
										<td><?=$stud['stream_short_name']?></td>
										<td><?=$stud['course_short_name']?></td>
										<td><?=$stud['current_year']?></td>
											<td><?=$stud['mobile']?></td>
												<td><?=$stud['email']?></td>
                                        <td><?=$stud['admission_session']?></td>
										<td><?=$stud['Remark']?></td>
																		
									
									</tr>
								<?php
								
										$i++;
										}
										
									
									}else{
									    
										echo '';
									}
								?>
								
								</tbody>
							</table>
                                       <?php
                                       
                                       
                                       
                                       break;
                                       
                                       
                                       }
                                   ?>
								   
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


</style>