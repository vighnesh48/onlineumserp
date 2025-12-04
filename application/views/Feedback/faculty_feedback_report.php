<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>

<style>
.absent_bg{background:#ff9b9b;}

</style>
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="#">Feedback</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;View Faculty Report</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-sm-12">&nbsp;</div>
        </div>

		  <div class="row ">
            <div class="col-sm-12">
				<div class="panel">
                    <div class="panel-heading">
                            <span class="panel-title" id="stdname"> 
							<?php
							if($sb['gender']=='male'){
												$sex = 'Mr.';
											}else{
												$sex = 'Mrs.';
											}
							echo "<b>Stream : ".$StreamSrtName[0]['stream_short_name'].",&nbsp; Semester : ".$semester.",&nbsp; Division : ".$division.''.$batch.",&nbsp; Subject : ".$sub[0]['subject_name'].",&nbsp; Faculty: ".$sex.' '.$fac[0]['fname']." ".$fac[0]['lname']."  </b>"; 
							?>
							</span>
                    </div>
					<?php
					if($this->session->flashdata('msg')) {
                    $msg= $this->session->flashdata('msg');
                    if($msg=="1"){
                        
                      echo' <br><div class="alert alert-success fade in"><a href="#" class="close" data-dismiss="alert">&times;</a><strong>Thanks!</strong> for providing your valuable feedback</div>';  
                    }
                    else
                   {
                       echo'<div class="alert alert-danger fade in"><a href="#" class="close" data-dismiss="alert">&times;</a><strong>Feedback!</strong> is not submitted</div>';
                   }
        
                  }
				  ?>
                    <div class="panel-body">
						
                        <div class="table-info table-responsive">  
						
							<table width="100%" cellpadding="0" cellspacing="0" border="1px" class="table time-table table-striped table-bordered" align="center" >
							
							<thead>
							   <tr>
									<th align="center"><span>Q.No</span></th>
									<th align="center"><span>Question</span></th>
									<th align="center"><span>Marks</span></th>
									<th align="center"><span>Out of </span></th>
									<th align="center"><span>Percentage(%)</span></th>
									
							   </tr>
								</thead>
								<tbody id="studtbl">
								<?php 
									$i=1;
									$j=0;
									$sum_marks=0;
									$sum_totmarks = 0;									
										if(!empty($questions)){
											foreach($questions as $que){
											$queNo ='Q'.$i;	
											$sum_marks+=$marks[$j][$queNo];
											$sum_totmarks+=$marks[$j]['quecnt'] *5;
									?>
									<tr>
										
										<td>&nbsp;<?=$i?></td> 
										<td><i class=""></i> &nbsp;<?=$que['question_name']?></td>
										<td>&nbsp;<?=$marks[$j][$queNo]?></td>
										<td>&nbsp;<?=$marks[$j]['quecnt'] *5;?></td>
										<td>&nbsp;<?php
										$mrkobt = $marks[$j][$queNo];
										$mrkoutof = $marks[$j]['quecnt'] *5;
										echo $per = round($mrkobt / $mrkoutof *100);
										?>%</td>
											
										
											
									</tr>
									
								<?php 
								unset($queNo);
								//$j++;
										$i++;
										}
									}else{
										echo "<tr><td colspan=5>No data found.</td></tr>";
									}
								?>
								<tr>
									<td></td>
									<td>&nbsp;<b>No of feedback:</b><b> <?=$marks[0]['quecnt']?></b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="float:right;margin-right:5px;"><b>Total</b></span></td>
									<td>&nbsp;<b><?=$sum_marks?></b></td>
									<td>&nbsp;<b><?=$sum_totmarks?></b></td>
									<td>&nbsp;<b><?=round($sum_marks/$sum_totmarks * 100);?>%</b></td>
								</tr>
								
								</tbody>
							</table>
							
						</div>
                    </div>
                </div>
			</div>			
		</div>
			
    </div>
</div>
