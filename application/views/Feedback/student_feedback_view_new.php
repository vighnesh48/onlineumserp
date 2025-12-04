<link href="<?=base_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=base_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=base_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
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

<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Feedback</a></li>
        <li class="active"><a href="#"><?=$ed?> Faculty</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-comments fa-2x"></i>&nbsp;&nbsp;<?=$ed?> Student Feedback Form</h1>
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
                            <span class="panel-title">
                                <div class="row">
                                    <div class="col-md-8">Subject: <?=$sub[0]['subject_name']?></div>
                                     <div class="col-md-4">Faculty: <?php if($fac[0]['gender']=='male'){echo "Mr.";}else{ echo "Mrs.";}?> <?=$fac[0]['fname']." ".$fac[0]['lname']?></div>
                              </div>
                            </span>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                             <div class="col-md-1"></div>
        <div class="col-md-10">
              <?php
              
              if($this->session->flashdata('exist')){
                 
                   echo' <br><br><div class="alert alert-notice alert-dismissable"><strong>!!</strong> You have alreday  submitted the feedback.<br> </div>';  
                  
              }
                 else if($this->session->flashdata('msg')) {
                    $msg= $this->session->flashdata('msg');
                    if($msg=="1"){
                        
                      echo' <div class="alert alert-success fade in"><a href="#" class="close" data-dismiss="alert">&times;</a><strong>Thanks!</strong> for providing your valuable feedback</div>';  
                    }
                    else
                   {
                       echo'<br><br> <div class="alert alert-danger fade in"><a href="#" class="close" data-dismiss="alert">&times;</a><strong>Feedback!</strong> is not submitted</div>';
                   }
        
                  }
                  else
                  {
                 ?>
            <div class="panel panel-primary" style="border-color:#428bca;">
                <div class="panel-heading ">
                    <h3 class="panel-title" style="color:white;">
                        <span class="glyphicon glyphicon-arrow-right"></span>Please Provide your valuable feedback.. </span>
                    </h3>
                </div>
                <form id="form" name="form" action="<?=base_url($currentModule.'/submiit')?>" method="POST" onsubmit="return validate()">
				<input type="hidden" name="subject_det" value="<?=$stud_det?>">
                <div class="panel-body">
                  

              <table class="table table-bordered table-hover1 table-responsive" style="margin:18px; font-family:cambria;font-size:14px;">
                    <thead>
                        <tr>
                            <th width="5%">Q.No</th>
                             <th width="47%">Questions</th>
                              <th colsapn="5">Options &nbsp;&nbsp;&nbsp;(<i>Note:Click any one of the given options</i>)</th>
                               
                        </tr>
                    </thead>
                    <tbody>
						<?php 
						$i=1;
							if(!empty($questions)){
								foreach($questions as $que){
						?>
                       <tr class="ques<?=$que['ques_id']?>">
                            <td><?=$i?></td> 
                            <td><i class=""></i> &nbsp;<?=$que['question_name']?></td>
                             <td colspan="5">
                                <div class="col-xs-12">
                                     <div class="form-group feedback-group">
                            		<div class="col-sm-11 col-md-11">
                            			<div class="input-group">
                            				<div id="radioBtn" class="btn-group feedback-btn" required>
                            					<a class="btn btn-primary btn-sm notActive"  data-toggle="<?=$que['ques_id']?>" data-title="5">Excellent</a>
												<a class="btn btn-primary btn-sm notActive" data-toggle="<?=$que['ques_id']?>" data-title="4">Very Good</a>
                                                <a class="btn btn-primary btn-sm notActive" data-toggle="<?=$que['ques_id']?>" data-title="3">Good</a>
                            					<a class="btn btn-primary btn-sm notActive" data-toggle="<?=$que['ques_id']?>" data-title="2">Average</a>
                            					<a class="btn btn-primary btn-sm notActive" data-toggle="<?=$que['ques_id']?>" data-title="1">Poor</a>	                            					
                            				</div>
                            				
                            				<input type="hidden" name="Q<?=$que['ques_id']?>" id="<?=$que['ques_id']?>" required>
                            			</div>
                            		</div>
                            	</div>
    </div>
                               </td>
                        </tr>
								<?php $i++;
								}
								
							}?>
                       
                       <tr>
                            <td>#</td>
                            <td>Suggestion</td>
                             <td colspan="5"> <textarea class="form-control" rows="3" name="comment"  id="comment"></textarea>
                               </td>
                        </tr>
                    </tbody>
                    </table>
                 
                </div>
                <div class="panel-footer">
                    <center><button type="submit" class="btn btn-primary btn-md" id="formbtn">
                        Submit Feedback</button></center>
                   </div>
            </div>
           
        </div>
         <div class="col-md-1"></div>
         </form>
    </div>
                        
                        
                    
                     <?php
                  }
            ?></div>
                </div>
            </div>    
        </div>

		       
    
    
    </div>
</div>
<script>
	$('#radioBtn a').on('click', function(){
			var sel = $(this).data('title');
			var tog = $(this).data('toggle');
			//alert(sel);
			//alert(tog);
			$('#'+tog).prop('value', sel);
			$('a[data-toggle="'+tog+'"]').not('[data-title="'+sel+'"]').removeClass('active').addClass('notActive');
			$('a[data-toggle="'+tog+'"][data-title="'+sel+'"]').removeClass('notActive').addClass('active');
			for(i=1; i<=13;i++){
				if(($("#"+i).val())=='')
				{
					//$(".ques"+i).css("background-color", "#f56c6c");
				}else{
					$(".ques"+i).css("background-color", "#76ca76");
				}
			}
		});

				function validate(){
					
					var Q1=$("#1").val();
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
					return true;
  
				}
    

</script>
