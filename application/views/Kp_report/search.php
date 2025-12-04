<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>

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
             var base_url = 'https://erp.sandipuniversity.com/';
                   // alert(type);
                   var prn = $("#prn").val();
                    var mobile = $("#mobile").val();
                    var fname = $("#fname").val();
                     var mname = $("#mname").val();
                      var lname = $("#lname").val();
                    var fnum = $("#fnum").val();
                     if(prn=='' && mobile==''  && fnum==''  && fname==''  && mname=='' && lname=='')
                    {
                        alert("Please Select Atleast one search criteria");
                        return false;
                    }
                    
                    
           
                $.ajax({
                    'url' : base_url + '/Account/search_studentdata',
                    'type' : 'POST', //the way you want to send data to your URL
                    'data' : {'prn':prn,'mobile':mobile,'fname':fname,'mname':mname,'lname':lname,'fnum':fnum,'hide':'hide'},
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
            
</script>
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="#">Account</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Examination Fees</h1>
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
                    <div id="dashboard-recent" class="panel panel-warning">        
                     <div class="panel-heading">
                       <span class="panel-title"><i class="panel-title-icon fa fa-fire text-danger"></i>Search Student</span>
			    		</div>
			    		<div class="panel-body">
						<br>
						<!--<form id="form1" name="form1" enctype="multipart/form-data" action="<?=base_url($currentModule.'/search_student')?>" method="POST">-->
                        <div class="row">
					   <div class="form-group">
	 
                      <div class="col-sm-3"><input type="text" class="form-control" name="prn" id="prn" placeholder="Student PRN No."></div><label class="col-sm-1">OR</label>
                      <div class="col-sm-3"><input type="text" class="form-control" name="fnum" id="fnum" placeholder="Student Form No."></div> <label class="col-sm-1">OR</label>   
                      <div class="col-sm-3"><input type="text" class="form-control" name="mobile" id="mobile" placeholder="Student Mobile No."></div><label class="col-sm-1"></label>
                      
					  </div>
					  </div>
					  <div class="row">
					  
					  <div class="form-group">
                     <div class="col-sm-3"><input type="text" class="form-control" name="fname" id="fname"  placeholder="Student First Name"></div><label class="col-sm-1">OR</label>
                     <div class="col-sm-3"> <input type="text" class="form-control" name="mname" id="mname" placeholder="Student Middle Name"></div><label class="col-sm-1">OR</label>
                      <div class="col-sm-3"><input type="text" class="form-control" name="lname" id="lname" placeholder="Student last Name"></div><label class="col-sm-1">&nbsp;</label>
                      
					  </div>
					  
					  </div>
					   <div class="row">
					   <div class="form-group">
					  <div class="col-sm-3">&nbsp;</div><label class="col-sm-1">&nbsp;</label>
					  <div class="col-sm-2"><button class="btn btn-primary form-control" id="sbutton" type="button" >Search</button> </div>
					  </div>
					  </div>
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
                 
                </div>
          
            </div>    
        </div>
    </div>
</div>
</div>
</div>