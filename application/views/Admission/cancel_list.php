<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<script src="<?=base_url('assets/javascripts')?>/jquery.table2excel.js"></script>

<script>    
    $(document).ready(function()
    {
	$('#form1').bootstrapValidator	
({ 
message: 'This value is not valid',
            group: 'form-group',
            feedbackIcons: 
                 {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
                  },
			 row: {
        valid: 'field-success',
        invalid: 'field-error'
                  },
            fields: 
                  {
					search_id:	
                         {
                             validators: 
                               {
                                    notEmpty: 
                                       {
                                        message: 'Please Enter Student Id,this should not be empty'
                                         }                     
                                }
						  }
				  }
})	
	});
	
	
	
	 $(document).ready(function(){
               $('#sbutton').click(function(){
            
         // alert("hi");
             var base_url = '<?=base_url()?>';
                   // alert(type);
                   var prn = $("#prn").val();
                    var mobile = $("#mobile").val();
                    var fname = $("#fname").val();
                     var mname = $("#mname").val();
                      var lname = $("#lname").val();
                    var fnum = $("#fnum").val();
                     if(prn=='')
                    {
                        alert("Please Enter PRN Number");
                        return false;
                    }
                    
                    
           
                $.ajax({
                    'url' : base_url + 'Ums_admission/search_cancaldata',
                    'type' : 'POST', //the way you want to send data to your URL
                    'data' : {'prn':prn,'mobile':mobile,'fname':fname,'mname':mname,'lname':lname,'fnum':fnum},
                    'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
                        var container = $('#stddata'); //jquery selector (get element by id)
                        if(data){
                            
                        //  alert(data);
                            //alert("Marks should be less than maximum marks");
                            //$("#"+type).val('');
                            container.html(data);
                            	return false;
                        }
                          return false;
                    }
                });
            });
            
            
            
            
                  $('#cbutton').click(function(){
            
         // alert("hi");
             var base_url = '<?=base_url()?>';
                   // alert(type);
                   var prn = $("#academic-year").val();
                  
                     if(prn=='')
                    {
                        alert("Please Select Academic Year");
                        return false;
                    }
                    
                    
           
                $.ajax({
                    'url' : base_url + 'Ums_admission/load_cancel_admission',
                    'type' : 'POST', //the way you want to send data to your URL
                    'data' : {'prn':prn},
                    'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
                        var container = $('#stddata'); //jquery selector (get element by id)
                        if(data){
                            
                        //  alert(data);
                            //alert("Marks should be less than maximum marks");
                            //$("#"+type).val('');
                            container.html(data);
                            	return false;
                        }
                          return false;
                    }
                });
            });
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            });
			
			$(document).ready(function() {
    $("#click-me-div").click(function() {
        alert('yes, the click actually happened');
        $('.nav-tabs a[href="#samosas"]').tab('show');
    });
});

            
</script>


<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="#">Admission Form</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Admission Cancel List</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                </div>
            </div>
        </div>
		<style>
		.theme-default .nav-tabs>li.active>a, .theme-default .nav-tabs>li.active>a:focus, .theme-default .nav-tabs>li.active>a:hover {
    background: #774545 !important;
    border-bottom: 2px solid #1a7ab9;
}
		</style>
        <div class="row ">
            <div class="col-sm-12">&nbsp;</div>
        </div>
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                     

                    <div id="dashboard-recent" class="panel panel-warning">        
                     <div class="panel-heading">
                       <span class="panel-title"><i class="panel-title-icon fa fa-fire text-danger"></i>Cancel Admission</span>
			    		</div>
			    		<div class="panel-body">
						
						 <ul class="nav nav-tabs">
    <li class="active"><a href="#fruits" data-toggle="tab" style="">Search Cancelled data</a></li>
    <li><a href="#veggies" data-toggle="tab">Cancel Admission</a></li>

</ul>
<div class="tab-content">
    <div class="tab-pane active" id="fruits">
	
	   <div class="col-sm-2" id="">
                                <select name="academic-year" id="academic-year" class="form-control" required>
                                  <option value=""> Academic Year</option>
								   <?php

														foreach ($exam_session as $exsession) {
															$exam_sess = $exsession['academic_year'];
															$exam_sess_val =  $exsession['session'];
															if ($exam_sess_val == $_REQUEST['academic_year']) {
																$sel = "selected";
															} else {
																$sel = '';
															}
															echo '<option value="' . $exam_sess_val. '"' . $sel . '>' .$exam_sess.'</option>';
														}
                                                     ?>

                                  </select>
                             </div>
                              <div class="col-sm-2"><button class="btn btn-primary form-control" id="cbutton" type="button" >Search</button></div>
	
	</div>
    <div class="tab-pane" id="veggies">
	
	         <div class="col-sm-2"><input type="text" class="form-control" name="prn" id="prn" placeholder="Enter Student PRN No."></div>
                      <div class="col-sm-2"><button class="btn btn-primary form-control" id="sbutton" type="button" >Search</button></div>
	
	</div>
 
</div>
						
						
						<!--<form id="form1" name="form1" enctype="multipart/form-data" action="<?=base_url($currentModule.'/search_student')?>" method="POST">-->
                    
					
                          
             
					
				
					  
					  
					 
					  <div class="row">
					   <div class="form-group">
					   <div class="col-sm-3"></div>
					   <div class="col-sm-6">
					   <?php 
					   echo "<span style='color:red;padding-left:110px;'>".@$this->session->flashdata('message1')."</span>";
					   ?>
					   </div>
					 </div>                      
                      </div>
					 <!-- </form>-->
                </div>
                
   
               
                    <div class="table-info table-responsive" id="stddata">  
               
                    
                    
                    
                    
                    
                    
                    
                    
                    
                 
                </div>
         
                
                
                
                
                
                
                
                
                
            </div>    
        </div>
    </div>
</div>
</div>
</div>
