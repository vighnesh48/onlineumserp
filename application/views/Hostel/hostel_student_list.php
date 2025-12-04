<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<style>
.loader {
  border: 6px;
  border-radius: 50%;
  border-top: 6px solid pink;
  border-bottom: 6px solid pink;
  width: 90px;
  height: 90px;
  -webkit-animation: spin 2s linear infinite;
  animation: spin 2s linear infinite;
}
</style>
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
             var base_url = '<?=base_url();?>';
                    
                   var prn = $("#prn").val();
                    var org = $("#org").val();
                 var acyear = $("#acyear").val();
				 //alert(org);
				$("#arg_org").val(org);
				$("#arg_acyear").val(acyear);
				
				$("#arg_org1").val(org);
				$("#arg_acyear1").val(acyear);
				 
                    if(org=='')
                    {
                        alert("Please Select Organisation");
                        return false;
                    }
                   
                    
                    
				$("#loader1").html('<div class="loader"></div>');
                $.ajax({
                    'url' : base_url + 'Hostel/search_students_data',
                    'type' : 'POST', //the way you want to send data to your URL
                    'data' : {'prn':prn,'org':org,'acyear':acyear},
                    'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
					if(prn=='912020116'){
					//alert(data);
					}
                        var container = $('#stddata'); //jquery selector (get element by id)
                       if(data!='<span style=\"color:red;\">Records Not Found Please change search criteria and try again</span>'){
							container.html(data);
							$('#excel').show();
						}
						 else
						 {
							 container.html(data);
							 $('#excel').hide();
						 }
						 $("#loader1").html("");
                    }
                });
				
				/* $.ajax({
                    'url' : base_url + 'Hostel/search_students_data',
                    'type' : 'POST', //the way you want to send data to your URL
                    'data' : {'prn':prn,'org':org,'acyear':acyear,'cancel':'cancel'},
                    'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
                        var container = $('#cancelled_list'); //jquery selector (get element by id)
                         if(data!='<span style=\"color:red;\">Records Not Found Please change search criteria and try again</span>'){
							container.html(data);
							$('#excel1').show();
						}
						 else
						 {
							 container.html(data);
							 $('#excel1').hide();
						 }
                    }
                }); */
				
				$('.nav-tabs a[href="#allocated"]').tab('show');
            });
        });
                    
</script>
<?php
//print_r($_SESSION['name']);exit;
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="<?=base_url($currentModule)?>">Hostel</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Hostel Students List</h1>
			<?php if($this->session->userdata('role_id') !=33){?>
           <div class="pull-right col-xs-12 col-sm-auto"><a style="width: 100%;" class="btn btn-primary btn-labeled" href="<?=base_url($currentModule.'/search_hostel_students')?>"><span class="btn-label icon fa fa-plus"></span>Add New</a></div>
			<?php }?>
			
        </div>
<div id="dashboard-recent" class="panel panel-warning"> 
                   
                     <div class="panel-heading">
                       <span class="panel-title"><i class="panel-title-icon fa fa-fire text-danger">Students List</i></span>
					   			<span id="flash-messages" style="color:Green;padding-left:210px;">
						 <?php if(!empty($this->session->flashdata('message1'))){ echo $this->session->flashdata('message1'); } ?></span>
					<span id="flash-messages" style="color:red;padding-left:50px;">
						 <?php if(!empty($this->session->flashdata('message2'))){ echo $this->session->flashdata('message2'); } ?></span>
			    		</div>
			    		<div class="panel-body">
						
						<!--<form id="form1" name="form1" enctype="multipart/form-data" action="<?=base_url($currentModule.'/search_student')?>" method="POST">-->
                      <div class="row">
					 
					    <div class="col-sm-3"><select class="form-control" name="acyear" id="acyear">
						<option value="">Select Academic Year</option>
                                           <?php //echo "state".$state;exit();
										if(!empty($academic_details)){
											foreach($academic_details as $academic){
												$arr=explode("-",$academic['academic_year']);
												$ac_year=$arr[0];
												if($academic['status']=='Y')
												{
												?>
											  <option selected value="<?=$ac_year?>"><?=$academic['academic_year']?></option>  
											<?php 
												}else{
												?>
												<option value="<?=$ac_year?>"><?=$academic['academic_year']?></option> 
												<?php
												}
												
											}
										}
									  ?>
					</select></div>
					  <div class="col-sm-3">
					      <select class="form-control" name="org" id="org">
					          <?php
					          
   		$exp = explode("_",$_SESSION['name']);
//print_r($exp);
		   /*  if($exp[1]=="sijoul")
        {
              $where.=" AND campus_name='SIJOUL'";
        }*/
        
        if($exp[1]=="nashik")
        {
			
 
					          ?>
<option value="SU">Sandip University Nashik</option>
<option value="SF">Sandip Foundation Nashik</option>
					  <?php
 }
  elseif($exp[1]=="sijoul")
  {
	 // echo 'inside';exit;
					  ?>
					  <option value="SF-SIJOUL">Sandip Foundation Sijoul</option>
					  <option value="SU-SIJOUL">Sandip University Sijoul</option>
					  <?php
  }
  else
  { 
					  ?>
<option value="">Select</option>
<option value="SU">Sandip University Nashik</option>
<option value="SF">Sandip Foundation Nashik</option>
<option value="SU-SIJOUL">Sandip University Sijoul</option>
<option value="SF-SIJOUL">Sandip Foundation Sijoul</option>
					  <?php
  }
					  ?>
					  </select>
					  </div>
                   
					  
					   <div class="col-sm-3"><input type="text" class="form-control" name="prn" id="prn" placeholder="Enter Student PRN No."></div>
                      <div class="col-sm-2"><button class="btn btn-primary form-control" id="sbutton" type="button" >Search</button></div>
					 
			
					  
					  
					 
					  <div class="row">
					   <div class="form-group">
					   <div class="col-sm-3"></div>
					   <!--<div class="col-sm-6">
					   <?php 
					   echo "<span style='color:red;padding-left:110px;'>".@$this->session->flashdata('message1')."</span>";
					   ?>
					   </div>-->
					 </div>                      
                      </div>
					 <!-- </form>-->
                </div>
               
			   <ul class="nav nav-tabs">
						
						<li><a data-toggle="tab" href="#allocated">Allocated List <span id="allocated_tot"></span></a></li>
						<!--li class="active"><a data-toggle="tab" href="#cancelled">Cancelled List  <span id="cancelled_tot"></span> </a></li-->
						<!--<li><a data-toggle="tab" href="#city">City</a></li>
						<li><a data-toggle="tab" href="#home">Home</a></li>-->
					  </ul>
						
					  <div class="tab-content">
						<div id="allocated" class="tab-pane fade">
						  <h4 id="no_out"></h4>
						 <center><div id="loader1"></div> </center> 	
						<form name="form" id="form" method="post" action="<?=base_url()?>Hostel/export_allocated">	
					
					<input type="hidden" name="arg_prn" id="arg_prn">
					<input type="hidden" name="arg_institute" id="arg_institute">
					<input type="hidden" name="arg_org" id="arg_org">
					<input type="hidden" name="arg_acyear" id="arg_acyear">
					
                   <div class="table-info" id="stddata">
					</div>
					
					</form>	
						
						</div>
						<div id="cancelled" class="tab-pane fade">
						  <h4 id="no_in"></h4>
						  
				<form name="form1" id="form1" method="post" action="<?=base_url()?>Hostel/export_cancelled">	
					
					<input type="hidden" name="arg_prn1" id="arg_prn1">
					<input type="hidden" name="arg_institute1" id="arg_institute1">
					<input type="hidden" name="arg_org1" id="arg_org1">
					<input type="hidden" name="arg_acyear1" id="arg_acyear1">
					
                   <div class="table-info" id="cancelled_list">
					</div>
					
					</form>	
						</div>
						
					  </div>
					
			   
			   
                    
                
            </div>    
      
    </div>

</div>
</div>
<script>
	$(document).ready(function()
		{
			//alert("hello");
			var enroll='<?=str_replace("_","/",$this->uri->segment(3))?>';
			var ac_year='<?=$this->uri->segment(4)?>';
	
			var org='<?=$this->uri->segment(5)?>';
			//alert(enroll);alert(ac_year);alert(org);
			if(enroll!="" && org!="")
			{
				$('#org option').each(function()
					{              
						if($(this).val()== org)
						{
							$(this).attr('selected','selected');
						}
					});
				$('#acyear option').each(function()
					{              
						if($(this).val()== ac_year)
						{
							$(this).attr('selected','selected');
						}
					});
				$("#prn").val(enroll);
				$("#sbutton").trigger("click");
			}
	
	   
		});
</script>