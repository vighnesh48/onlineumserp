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
.feedback-btn{
    
    
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
        <li><a href="#">feedback</a></li>
        <li class="active"><a href="#"><?=$ed?> Faculty</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-comments fa-2x"></i>&nbsp;&nbsp;<?=$ed?> Student Feedback</h1>
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
                            <span class="panel-title"><i class="fa fa-file fa-2x"></i> Feedback Form Details</span>
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
                        
                      echo' <br><div class="alert alert-success fade in"><a href="#" class="close" data-dismiss="alert">&times;</a><strong>Thanks!</strong> for providing your valuable feedback</div>';  
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
                        <span class="glyphicon glyphicon-arrow-right"></span>Please Provide your valuable feedback.. <span class="glyphicon glyphicon-new-window"></span>
                    </h3>
                </div>
                <form id="form" name="form" action="<?=base_url($currentModule.'/parent')?>" method="POST">
                <div class="panel-body">
                  

              <table class="table table-bordered table-hover table-responsive" style="margin:18px; font-family:cambria;font-size:14px;">
                    <thead>
                        <tr>
                            <th width="5%">S.No</th>
                             <th width="30%">Facilities</th>
                              <th width="60%" colsapn="5">Options &nbsp;&nbsp;&nbsp;(<i>Note:Click any one of the given options</i>)</th>
                               
                        </tr>
                    </thead>
                    <tbody>
                       <tr>
                            <td>1</td> 
                            <td><i class="fa fa-users "></i> &nbsp;Faculty Advisor</td>
                             <td colspan="5">
                                <div class="col-xs-12">
                                     <div class="form-group">
                            		<div class="col-sm-11 col-md-11">
                            			<div class="input-group">
                            				<div id="radioBtn" class="btn-group feedback-btn" required>
                            					<a class="btn btn-primary btn-sm notActive"  data-toggle="faculty_advisor" data-title="5">Excellent</a>
                                                <a class="btn btn-primary btn-sm notActive" data-toggle="faculty_advisor" data-title="4">Good</a>
                            					<a class="btn btn-primary btn-sm notActive" data-toggle="faculty_advisor" data-title="3">Average</a>
                            					<a class="btn btn-primary btn-sm notActive" data-toggle="faculty_advisor" data-title="2">Poor</a>
                            					
                            					
                            				</div>
                            				
                            				<input type="hidden" name="faculty_advisor" id="faculty_advisor" required>
                            			</div>
                            		</div>
                            	</div>
    </div>
                               </td>
                        </tr>
                       <tr>
                            <td>2</td>
                            <td><i class="fa fa-check-square-o" aria-hidden="true"></i> &nbsp;Academic</td>
                             <td colspan="5">
                                <div class="col-xs-12">
                                     <div class="form-group">
                            		<div class="col-sm-12 col-md-12">
                            			<div class="input-group">
                            				<div id="radioBtn" class="btn-group feedback-btn" >
                            					<a class="btn btn-primary btn-sm notActive" data-toggle="academic" data-title="5" required>Excellent</a>
                                                <a class="btn btn-primary btn-sm notActive" data-toggle="academic" data-title="4" required>Good</a>
                            					<a class="btn btn-primary btn-sm notActive" data-toggle="academic" data-title="3" required>Average</a>
                            					<a class="btn btn-primary btn-sm notActive" data-toggle="academic" data-title="2" required>Poor</a>
                            				
                            				</div>
                            				<input type="hidden" name="academic" id="academic" required>
                            			</div>
                            		</div>
                            	</div>
    </div>
                               </td>
                        </tr>
                       <tr>
                            <td>3</td>
                            <td><i class="fa fa-bed" aria-hidden="true"></i>&nbsp;Hostel</td>
                             <td colspan="5">
                                <div class="col-xs-12">
                                     <div class="form-group">
                            		<div class="col-sm-12 col-md-12">
                            			<div class="input-group">
                            				<div id="radioBtn" class="btn-group feedback-btn">
                            					<a class="btn btn-primary btn-sm notActive"   data-toggle="hostel" data-title="5">Excellent</a>
                                                <a class="btn btn-primary btn-sm notActive" data-toggle="hostel" data-title="4">Good</a>
                            					<a class="btn btn-primary btn-sm notActive" data-toggle="hostel" data-title="3">Average</a>
                            					<a class="btn btn-primary btn-sm notActive" data-toggle="hostel" data-title="2">Poor</a>
                            					<a class="btn btn-primary btn-sm notActive" data-toggle="hostel" data-title="0">Not Applicable</a>
                            				</div>
                            				<input type="hidden" name="hostel" id="hostel">
                            			</div>
                            		</div>
                            	</div>
    </div>
                               </td>
                        </tr>
                       <tr>
                            <td>4</td>
                            <td><i class="fa fa-cutlery" aria-hidden="true"></i>&nbsp;Canteen</td>
                             <td colspan="5">
                                <div class="col-xs-12">
                                     <div class="form-group">
                            		<div class="col-sm-12 col-md-12">
                            			<div class="input-group">
                            				<div id="radioBtn" class="btn-group feedback-btn">
                            					<a class="btn btn-primary btn-sm notActive"   data-toggle="canteen" data-title="5">Excellent</a>
                                                <a class="btn btn-primary btn-sm notActive" data-toggle="canteen" data-title="4">Good</a>
                            					<a class="btn btn-primary btn-sm notActive" data-toggle="canteen" data-title="3">Average</a>
                            					<a class="btn btn-primary btn-sm notActive" data-toggle="canteen" data-title="2">Poor</a>
                            					<a class="btn btn-primary btn-sm notActive" data-toggle="canteen" data-title="0">Not Applicable</a>
                            				</div>
                            				<input type="hidden" name="canteen" id="canteen">
                            			</div>
                            		</div>
                            	</div>
    </div>
                               </td>
                        </tr>
                       <tr>
                            <td>5</td>
                            <td><i class="fa fa-bus"></i>&nbsp;Transport</td>
                             <td colspan="5">
                                <div class="col-xs-12">
                                     <div class="form-group">
                            		<div class="col-sm-12 col-md-12">
                            			<div class="input-group">
                            				<div id="radioBtn" class="btn-group feedback-btn">
                            					<a class="btn btn-primary btn-sm notActive"   data-toggle="transport" data-title="5">Excellent</a>
                                                <a class="btn btn-primary btn-sm notActive" data-toggle="transport" data-title="4">Good</a>
                            					<a class="btn btn-primary btn-sm notActive" data-toggle="transport" data-title="3">Average</a>
                            					<a class="btn btn-primary btn-sm notActive" data-toggle="transport" data-title="2">Poor</a>
                            					<a class="btn btn-primary btn-sm notActive" data-toggle="transport" data-title="0">Not Applicable</a>
                            				</div>
                            				<input type="hidden" name="transport" id="transport">
                            			</div>
                            		</div>
                            	</div>
    </div>
                               </td>
                        </tr>
                       <tr>
                            <td>6</td>
                            <td>Admin Support</td>
                             <td colspan="5">
                                <div class="col-xs-12">
                                     <div class="form-group">
                            		<div class="col-sm-12 col-md-12">
                            			<div class="input-group">
                            				<div id="radioBtn" class="btn-group feedback-btn">
                            					<a class="btn btn-primary btn-sm notActive "   data-toggle="admin_support" data-title="5">Excellent</a>
                                                <a class="btn btn-primary btn-sm notActive" data-toggle="admin_support" data-title="4">Good</a>
                            					<a class="btn btn-primary btn-sm notActive" data-toggle="admin_support" data-title="3">Average</a>
                            					<a class="btn btn-primary btn-sm notActive" data-toggle="admin_support" data-title="2">Poor</a>
                            				
                            				</div>
                            				<input type="hidden" name="admin_support" id="admin_support" required>
                            			</div>
                            		</div>
                            	</div>
    </div>
                               </td>
                        </tr>
                       <tr>
                            <td>7</td>
                            <td>Suggestion</td>
                             <td colspan="5"> <textarea class="form-control" rows="3" name="comment"  id="comment"  required></textarea>
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
    $('#'+tog).prop('value', sel);
    $('a[data-toggle="'+tog+'"]').not('[data-title="'+sel+'"]').removeClass('active').addClass('notActive');
    $('a[data-toggle="'+tog+'"][data-title="'+sel+'"]').removeClass('notActive').addClass('active');
});

$(document).ready(function() {
   $("#formbtn").click(function(){
      var tutur=$("#faculty_advisor").val();
        var academic=$("#academic").val();
          var hostel=$("#hostel").val();
            var canteen=$("#canteen").val();
              var transport=$("#transport").val();
                var admin_support=$("#admin_support").val();
                  var comment=$("#comment").val();
  if(tutur=="" ||academic==""||hostel==""||canteen==""||transport==""||transport==""||admin_support==""){
      alert("Please select any one option for all list of facilities");
  }
  else if(comment=="")
  {
     alert("Please provide your suggestion.."); 
  }
  else
  {
      return true;
  }
  
   });
    
});
</script>
