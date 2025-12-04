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
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Feedback Course List</h1>
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
                            <div class="row ">
                                <div class="col-sm-6">Course:<?=$stream_name?></div>
                                <div class="col-sm-3">Semester:<?=$semester?></div>
                                <div class="col-sm-3">Division:<?=$division?>  <?=$batch?>
                                </div>
                                 
							</span>
                    </div>
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
						
                        <div class="table-info">  
						
							<table width="100%" cellpadding="0" cellspacing="0" border="1px" class="table time-table table-bordered table-responsive table-hover" align="center" >
							
							<thead>
							   <tr>
									<th align="center"><span>Sr.No</span></th>
									<th align="center"><span>Subject Name</span></th>
									<th align="center"><span>Faculty Name</span></th>
									<th align="center"><span>Feedback</span></th>
									<th align="center"><span>Date</span></th>
									
							   </tr>
								</thead>
								<tbody id="studtbl">
								<?php
								//echo "<pre>";
								//print_r($sub);
								$i=1;
									if(!empty($sub)){
										
										foreach($sub as $sb){
										$stud_details = $stream.'~'.$semester.'~'.$division.'~'.$student_id.'~'.$sb['subject_code'].'~'.$sb['faculty_code'];	
								?>
									<tr>
										
										<td><?=$i?></td>
										<td><?=$sb['subject_name']?></td>
										<td><?php
											if($sb['gender']=='male'){
												$sex = 'Mr.';
											}else{
												$sex = 'Mrs.';
											}
										?><?=$sex.' '.$sb['fname'].' '.$sb['mname'].' '.$sb['lname']?></td>
										<td>
										<?php 
											if($sb['fb'][0]['feedback_id'] ==''){
										?>
										<a href="<?=base_url()?>Feedback/submiit/<?=base64_encode($stud_details)?>"><button class="btn btn-primary">Submit</button></a>
										<?php
											}else{?>
												<button class="btn btn-success">Submited</button>
										<?php	}
										?>
										</td>
										<td><?php if($sb['fb'][0]['feedback_date'] !='' && $sb['fb'][0]['feedback_date'] !='0000-00-00'){ echo date('d/m/Y',strtotime($sb['fb'][0]['feedback_date']));}?>
										</td>
											
										</td>
											
									</tr>
									
								<?php 
								//}
								unset($sex);
										$i++;
										}
									}else{
										echo "<tr><td colspan=3>No data found.</td></tr>";
									}
								?>
								
								
								</tbody>
							</table>
							
						</div>
                    </div>
                </div>
			</div>			
		</div>
			
    </div>
</div>
