<link href="<?=base_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=base_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=base_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<style>   
/*new style*/
.panel{
    box-shadow: 1px 2px 13px #ccc!important;
}
.panel:hover{
    box-shadow:1px 2px 7px #f2f2f2!important;;
}

.form-control {
    box-shadow: 1px 2px 3px #ccc!important;
}
.breadcrumb li, .breadcrumb li a {
   
    height: 11px!important;
}
@media only screen and (max-width: 992px) {
	.form-control{width:80%;}
}


 /*new style*/
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
.e-suggestion-btn{
    
    
}
.e-suggestion-btn a{
    margin-right:0px!important;
    transition:0.5s;border:1px solid #ddd;
    
}
.e-suggestion-btn a:hover{
    color:#fff;
    
}
#radioBtn .notActive:hover{color:#fff!important;}
</style>

<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">e-suggestion</a></li>
        <li class="active"><a href="#"><?=$ed?></a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-comments fa-2x text-danger"></i>&nbsp;&nbsp;<?=$ed?> Grievance Redressal</h1>
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
                            <span class="panel-title"><i class="fa fa-file fa-2x text-warning"></i> Grievance Redressal Form Details</span>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            
        <div class="col-md-12" >
              <?php
              //print_r($category);
              if($this->session->flashdata('exist')){
                 
                   echo' <br><br><div class="alert alert-notice alert-dismissable"><strong>!!</strong> You have alreday  submitted the Grievance Redressal.<br> </div>';  
                  
              }
                 else if($this->session->flashdata('msg')) {
                    $msg= $this->session->flashdata('msg');
                    if($msg=="1"){
                        
                      echo' <br><div class="alert alert-success fade in"><a href="#" class="close" data-dismiss="alert">&times;</a><strong>Thanks!</strong> for providing your valuable Grievance Redressal</div>';  
                    }
                    else
                   {
                       echo'<br><br> <div class="alert alert-danger fade in"><a href="#" class="close" data-dismiss="alert">&times;</a><strong>Grievance Redressal!</strong> is not submitted</div>';
                   }
        
                  }
                  //else
                  //{
                 ?>
            <div class="panel panel-primary" style="border-color:#428bca;margin:30px 30px;box-shadow:none!important;">
                <div class="panel-heading " >
                    <h3 class="panel-title" style="color:white;">
                        <span class="glyphicon glyphicon-arrow-right"></span>Please Provide your valuable Grievance Redressal.. <span class="glyphicon glyphicon-new-window"></span>
                    </h3>
                </div>
                <form id="form" name="form" action="<?=base_url($currentModule.'/grievance')?>" method="POST">
                <div class="panel-body" >
                  

              <table class="table table-bordered table-hover table-responsive" style="margin:18px; font-family:cambria;font-size:14px;">
                    <thead>
                        <tr>
                            
                             <th width="30%">Select Category</th>
                              <th width="60%" colsapn="5">
							  <select class="form-control" name="category" id="category" >
								<option value="">-Select-</option>
								<?php foreach($category as $cat){ 
								if (!in_array($cat['c_id'], $added_category)) {
								?>
								<option value="<?=$cat['c_id']?>"><?=$cat['c_name']?></option>
								<?php }}?>
							  </select>
							  </th>
                               
                        </tr>
                    </thead>
                    <tbody>
                       <tr>
                            
                            <td>Grievance</td>
                             <td colspan="5"> <textarea class="form-control" rows="3" name="comment"  id="comment"  required></textarea>
                               </td>
                        </tr>
                    </tbody>
                    </table>
                 
                </div>
                <div class="panel-footer">
                    <center><button type="submit" class="btn btn-primary btn-md" id="formbtn">
                        Submit Grievance </button></center>
                   </div>
            </div>
           
        </div>
         <div class="col-md-1"></div>
         </form>
    </div>             
                     <?php
                  //}
            ?></div>
                </div>
            </div>    
        </div>

		       
    
    
    </div>
	<div class="panel">
                    <div class="panel-heading">
                            <h3 class="panel-title">Grievance Redressal List</h3>
                    </div>
                    <div class="panel-body">
                        <div style="margin:30px 0px;">  
							<table class="table table-bordered" align="center" width="70%">
							<thead>
								<tr class="bg-primary">
								<th>Sr.No</th>
								<th>Date</th>
									<th>Category</th>
									<th>Grievance</th>
									
								</tr>
							</thead>
							<tbody>
							<?php $i=1;
							foreach($esuggestions as $ec){ ?>							
								<tr>
									<th width="5%"><?=$i?></th>
									<td width="15%"><?=date('d-m-Y', strtotime($ec['suggestion_date']))?></td>
									<td width="15%"><?=$ec['c_name']?></td>
									<td><?=$ec['comment']?></td>
									
								</tr>
								<?php $i++;}?>
								</tbody>
							</table>
			
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
     alert("Please provide your Grievance Redressal.."); 
  }
  else
  {
      return true;
  }
  
   });
    
});
</script>
