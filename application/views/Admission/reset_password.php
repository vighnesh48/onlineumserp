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
	
	 function send_reset_password(var1,var2)
	     {
	       //  alert(var1);
	        //  alert(var2);
	         // alert(var1);
	        $('#bonafied_div').hide();
	        
	      
	      //  return false;
	        
                $.ajax({
                    'url' : base_url + '/Ums_admission/send_reset_password',
                    'type' : 'POST', //the way you want to send data to your URL
                    'data' : {'utype':var1,'prn':var2},
                    'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
                       // var container = $('#stddata'); //jquery selector (get element by id)
                        if(data){
                            
                      alert(data);
                            //alert("Marks should be less than maximum marks");
                            //$("#"+type).val('');
                        //    container.html(data);
                            	return false;
                        }
                          return false;
                    }
                });
	         
	     }
	     
	
	
	 $(document).ready(function(){
	     
	    
               $('#sbutton').click(function(){
            
         // alert("hi");
             var base_url = '<?=base_url()?>';
                   // alert(type);
                   var prn = $("#prn").val();
                   
                    var fnum = $("#fnum").val();
                     if(prn=='')
                    {
                        alert("Please Enter PRN Number");
                        return false;
                    }
                     $("#bonafied_div").hide();
                    
           
                $.ajax({
                    'url' : base_url + '/Ums_admission/reset_student_password',
                    'type' : 'POST', //the way you want to send data to your URL
                    'data' : {'prn':prn},
                    'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
              
              
                        if(data){
                            if(data=='N')
                            {
                                  $("#bonafied_div").hide();
                                  $("#mess").show();
                                $('#mess').html("PRN Number Does not exists");
                                $('#prn').val('');
                            }
                            else
                            
                            {  
                                  $("#mess").hide();
                                  var jdata= JSON.parse(data);
                                $("#bonafied_div").show();
                                 
                                  $("#stud_name").html(jdata.first_name+'  '+jdata.middle_name+'   '+jdata.last_name);
                                  $("#stream_name").html(jdata.stream_name);
                                    $("#year").html(jdata.admission_year);
                                     $("#cyear").html(jdata.current_year);
                                     $("#prn").val(jdata.enrollment_no);
                                       $("#stud_id").val(jdata.stud_id);
                                       
                                        $("#asession").html(jdata.admission_session);
                                       $("#ayear").html(jdata.academic_year);
                                       
                                      var astatus = jdata.cancelled_admission;
                                      
                                      var smobile = jdata.mobile;
                                         var pmobile = jdata.pmobile;
                                         
                                         
                                      if(astatus=='N')
                                      {
                                          $("#err").html('');
                                          if(smobile!='')
                                          {
                                     var lin ='<button class="btn btn-primary form-control" id="btn_prn" type="button" onclick="send_reset_password(4,'+jdata.enrollment_no+');" >Reset Student Password</button>';
                                
                                     $("#stud").html(lin);
                                       $("#smobile").html(smobile);
                                     
                                          }
                                          
                                             if(pmobile!='')
                                          {
                                     
                                      var lin2 ='<button class="btn btn-primary form-control" id="btn_prn" type="button"  onclick="send_reset_password(9,'+jdata.enrollment_no+');">Reset Parent Password</button> </a>';
                                
                                     $("#par").html(lin2);
                                        $("#pmobile").html(pmobile);
                                          }
                                      }
                                      else
                                      {
                                            $("#stud").html('');
                                            $("#par").html('');
                                          var err = "Student Admission Cancelled";
                                           $("#err").html(err);
                                      }
                                    
                            }
                        
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
        <li><a href="#">Student</a></li>
        <li class="active"><a href="#">Reset Password</a></li>
    </ul>
    <div class="page-header">			
       <!-- <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Reset Student Password</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                </div>
            </div>
        </div>-->
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
                       <span class="panel-title"><i class="panel-title-icon fa fa-fire text-danger"></i>Reset Student Password</span>
			    		</div>
			    		<div class="panel-body">
						
					
<div class="tab-content">
    <?php
    if($_SESSION['role_id']==1 || $_SESSION['role_id']==2 || $_SESSION['role_id']==6)
    {
    ?>
    <div class="tab-pane active" id="fruits">
		         <div class="col-sm-2"><input type="text" class="form-control" name="prn" id="prn" placeholder="Enter Student PRN No."></div>
                      <div class="col-sm-2"><button class="btn btn-primary form-control" id="sbutton" type="button" >Search</button></div>
	
	</div>
<?php
}
?>
 
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
                
   
               
                    <div class="table-info" id="stddata">  
               <div id="mess"></div>
                    
                          <span id="bonafied_div" style="display:none;" >
                                <div class="form-group">
                                 
                                    <label class="col-sm-2">Student Name:</label>                                    
                                    <div class="col-sm-4"><b><span id='stud_name'></span></b></div>                                    
                                    <div class="col-sm-4"></div>   
                                </div>
                                <div class="form-group">
                                  
                                    <label class="col-sm-2">Stream:</label>                                    
                                    <div class="col-sm-4"><b><span id='stream_name'></span></b></div>                                    
                                    <div class="col-sm-2">Admission Year:&nbsp;&nbsp;<b><span id='year'></b></span></div>
                                    <div class="col-sm-2">Current Year:&nbsp;&nbsp;<b><span id='cyear'></b></span></div>
                                </div>
                                
                                <div class="form-group">
                                  
                                    <label class="col-sm-2">Admission Session:</label>                                    
                                    <div class="col-sm-4"><b><span id='asession'></span></b></div>                                    
                                    <div class="col-sm-2">Academic Year:&nbsp;&nbsp;<b><span id='ayear'></b></span></div>
                                    <div class="col-sm-2"></div>
                                </div>
                                
                                     <div class="form-group">
                                  
                                    <label class="col-sm-2">Student Mobile:</label>                                    
                                    <div class="col-sm-4"><b><span id='smobile'></span></b></div>                                    
                                    <div class="col-sm-3">Parent mobile:&nbsp;&nbsp;<b><span id='pmobile'></b></span></div>
                                    <div class="col-sm-2"></div>
                                </div>
                                
                                
                                 <div class="form-group" >
                            
                                   <div class="col-sm-3" id="stud"></div>
                                      <div class="col-sm-3" id="par"></div>
                                  
                                </div>
                                
                                
                                 <div class="form-group" >
                              <div class="col-sm-4" id="err" style="color:red"></div>

                                </div>
                                
                    </span>
                    
                    
                    
                    
                    
                    
                 
                </div>
         
                
                
                
                
                
                
                
                
                
            </div>    
        </div>
    </div>
</div>
</div>
</div>
