<script src="<?=base_url('assets/javascripts').'/jquery-validate.bootstrap-tooltip.min.js'?> "></script>
<style>
.absent_bg{background:#ff9b9b;}

</style>
<style>    
body { margin-top:20px; }
.panel-body:not(.two-col) { padding:0px }
.glyphicon { margin-right:5px; }
.glyphicon-new-window { margin-left:10px; }
.panel-body .radio,.panel-body .checkbox {margin-top: 0px;margin-bottom: 0px;}
.panel-body .list-group {margin-bottom: 0;}
.margin-bottom-none { margin-bottom: 0; }
.panel-body .radio label,.panel-body .checkbox label { display:block; }

#radioBtn .notActive{
    color: #3276b1;
    background-color: #fff;
}

.btn-circle {
  width: 30px;
  height: 30px;
  text-align: center;
  padding: 6px 0;
  font-size: 12px;
  line-height: 1.428571429;
  border-radius: 50%;
}
.feedback-group{
   margin-bottom:0px; 
    
}
.feedback-btn a{
    margin-right:0px!important;
    transition:0.5s;border:1px solid #ddd;
    
}
.feedback-btn a:hover{
    color:#fff;
    
}
#radioBtn .notActive:hover{color:#fff!important;}
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
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Student Feedback</h1>
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
				  
				  <?php
				  if($feedback=='Y')
				  {
				      if($msg=="1")
				      {
				          
				      }
				      else{
			  echo' <br><div class="alert alert-success fade in">Your valuable Feedback is already submitted</div>';
				      }
				  }
				  else
				  {
				  ?>
				     <form id="form" name="form" action="<?=base_url($currentModule.'/submit')?>" method="POST" onsubmit="return validate()">
				         <input type="hidden" name="hstdid" value="<?=$student_id?>">
				         <input type="hidden" name="hcourse" value="<?=$stream?>">
				         <input type="hidden" name="hsem" value="<?=$semester?>">
				         <input type="hidden" name="hdiv" value="<?=$division?>">
				  		<?php 
						$i=$j=$k=1;
							if(!empty($questions)){
								foreach($questions as $que){
						?>
				  
                    <div class="panel-body">
						
                        <div class="table-info">  
						
							<table width="100%" cellpadding="0" cellspacing="0" border="1px" class="table time-table table-bordered table-responsive table-hover" align="center" >
							
							<thead>
								   <tr>
									<th align="center"><span>Q. <?=$j?></span></th>
									<th align="center" colspan="3"><span><?=$que['question_name']?></span></th>
									
									
							   </tr>
							   <tr>
									<th align="center"><span>Sr.No</span></th>
									<th align="center"><span>Subject Name</span></th>
									<th align="center"><span>Faculty Name</span></th>
							
								<th align="center"><span>Feedback </span></th>
									
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
									<tr class="ques<?=$que['ques_id']."_".$sb['faculty_code']."_".$sb['subject_code']?>">
										
										<td><?=$i?></td>
										<td><?=$sb['subject_name']?></td>
										<td><?php
											if($sb['gender']=='male'){
												$sex = 'Mr.';
											}
											
												if($sb['gender']=='female'){
												$sex = 'Mrs.';
											}
												
										?><?=$sex.' '.$sb['fname'].' '.$sb['mname'].' '.$sb['lname']?></td>
										<td>
										    
										    	<div id="radioBtn" class="btn-group feedback-btn" required>
                            					<a class="btn btn-primary btn-sm notActive"  data-toggle="<?=$que['ques_id']."_".$sb['faculty_code']."_".$sb['subject_code']?>" data-title="5">Excellent</a>
												<a class="btn btn-primary btn-sm notActive" data-toggle="<?=$que['ques_id']."_".$sb['faculty_code']."_".$sb['subject_code']?>" data-title="4">Very Good</a>
                                                <a class="btn btn-primary btn-sm notActive" data-toggle="<?=$que['ques_id']."_".$sb['faculty_code']."_".$sb['subject_code']?>" data-title="3">Good</a>
                            					<a class="btn btn-primary btn-sm notActive" data-toggle="<?=$que['ques_id']."_".$sb['faculty_code']."_".$sb['subject_code']?>" data-title="2">Average</a>
                            					<a class="btn btn-primary btn-sm notActive" data-toggle="<?=$que['ques_id']."_".$sb['faculty_code']."_".$sb['subject_code']?>" data-title="1">Poor</a>	
												<input type="text" class="qr_<?=$k ?>" name="Q<?=$que['ques_id']."_".$sb['faculty_code']."_".$sb['subject_code']?>" id="<?=$que['ques_id']."_".$sb['faculty_code']."_".$sb['subject_code']?>" required style="width:1px;border:0px;">                            					
                            				</div>
                            					
										    
										<?php 
											/*if($sb['fb'][0]['feedback_id'] ==''){
										?>
										<a href="<?=base_url()?>Feedback/submiit/<?=base64_encode($stud_details)?>"><button class="btn btn-primary">Submit</button></a>
										<?php
											}else{?>
												<button class="btn btn-success">Submited</button>
										<?php	}
										
										*/
										?>
										</td>
									
											
									</tr>
									
								<?php 
								//}
								unset($sex);
										$i++;
										$k++;
										}
									
									$j++;}else{
										echo "<tr><td colspan=3>No data found.</td></tr>";
									}
								?>
							
								</tbody>
							</table>
							
						</div>
						</div>
                    
					<?php
					
							}
							}
					?>
					
					
					
					
					
					 <!--div class="panel-body">
						
                        <div class="table-info">  
						
							<table width="100%" cellpadding="0" cellspacing="0" border="1px" class="table time-table table-bordered table-responsive table-hover" align="center" >
							
							<thead>
							
							   <tr>
									<th align="center"><span>Sr.No</span></th>
									<th align="center"><span>Subject Name</span></th>
									<th align="center"><span>Faculty Name</span></th>
							
								<th align="center"><span>Feedback </span></th>
									
							   </tr>
								</thead>
								<tbody id="studtbl">
					
					
					
					
					
					
					
						<?php
						$m=1;
									foreach($sub as $sb){
										$stud_details = $stream.'~'.$semester.'~'.$division.'~'.$student_id.'~'.$sb['subject_code'].'~'.$sb['faculty_code'];	
								?>
									<tr class="ques<?=$que['ques_id']."_".$sb['faculty_code']."_".$sb['subject_code']?>">
										
										<td><?=$m?></td>
										<td><?=$sb['subject_name']?></td>
										<td><?php
											if($sb['gender']=='male'){
												$sex = 'Mr.';
											}else{
												$sex = 'Mrs.';
											}
										?><?=$sex.' '.$sb['fname'].' '.$sb['mname'].' '.$sb['lname']?></td>
								
										<td> <textarea class="form-control" rows="3" name="comment_<?=$sb['faculty_code']."_".$sb['subject_code']?>"  id="com_<?=$m ?>"></textarea>
										</td>
											
										</td>
											
									</tr>
									
								<?php 
								//}
								unset($sex);
										$m++;
								
										}
									
								
								?>
								
					
								</tbody>
							</table>
							
						</div>
						</div-->
                    
					
					
					
					
					
					
					
					
					
				<div class="panel-footer">
				<input type="hidden" value="<?php echo $k; ?>" id="myid1">
				<input type="hidden" value="<?php echo $m; ?>" id="myid2">
                    <center><button type="submit" class="btn btn-primary btn-md" id="formbtn">
                        NEXT</button></center>
                   </div>
					
					</form>
					<?php
				  }
					?>
					
					
					
					
					
					</div>
                </div>
			</div>			
		</div>
			
    </div>
</div>
<script>
	$('#radioBtn a').on('click', function(){
	  //  alert("hello");
			var sel = $(this).data('title');
			var tog = $(this).data('toggle');
			//alert(sel);
			//alert(tog);
			$('#'+tog).prop('value', sel);
			
			$('a[data-toggle="'+tog+'"]').not('[data-title="'+sel+'"]').removeClass('active').addClass('notActive');
			$('a[data-toggle="'+tog+'"][data-title="'+sel+'"]').removeClass('notActive').addClass('active');
			for(i=1; i<=18;i++){
				if(($("#"+i).val())=='')
				{
					//$(".ques"+i).css("background-color", "#f56c6c");
				}else{
					$(".ques"+i).css("background-color", "#76ca76");
				}
			}
		});

				function validate(){
					
				var myid =$("#myid1").val();
						var myid2 =$("#myid2").val();
	for(i=1;i<myid;i++){
		var a= $(".qr_"+i).val();
		//alert(a);
				if(($(".qr_"+i).val())=='')
				{
			alert(".qr_"+i);
				alert("Please select any one option for all list of Feedback");
				$(".qr_"+i).focus();
					return false;
				}
				
				
			}
					
					
						for(i=1;i< myid2;i++){
						 
				if(($("#com_"+i).val())=='')
				{
				 
				alert("Please Fill All Suggestion");
					return false;
				}
				
				
			}
					
				
					
					return true;
					
					
					
					
				/*	var Q1=$("#1").val();
					var Q2=$("#2").val();
					var Q3=$("#3").val();
					var Q4=$("#4").val();
					var Q5=$("#5").val();
					var Q6=$("#6").val();
					var Q7=$("#7").val();
					var Q8=$("#8").val();
					var Q9=$("#9").val();
					var Q10=$("#10").val();
					var Q11=$("#11").val();
					var Q12=$("#12").val();
					var Q13=$("#13").val();
					var comment=$("#comment").val();

					if(Q1=="" ||Q2==""||Q3==""||Q4==""||Q5==""||Q6==""||Q7==""||Q8==""||Q8==""||Q9==""||Q10==""||Q11==""||Q12==""||Q13=="" || comment==''){
						alert("Please select any one option for all list of facilities and Suggestion");
					return false;
					}
					else
					{
						return true;
					}
					return true;*/
  
				}		
</script>
