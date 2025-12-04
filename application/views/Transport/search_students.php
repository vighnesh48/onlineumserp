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
             var base_url = '<?=base_url();?>';
                   // alert(type);
                   var prn = $("#prn").val();
                    var org = $("#org").val();
                 var acyear = $("#acyear").val();
				 //var campus = $("#campus").val();
                    if(org=='')
                    {
                        alert("Please Select Organisation");
                        return false;
                    }
					/* if(campus=='')
                    {
                        alert("Please Select Campus");
                        return false;
                    } */
                     if(prn=='')
                    {
                        alert("Please Enter PRN Number");
                        return false;
                    }
					if(acyear=='')
                    {
                        alert("Please Select Academic Year");
                        return false;
                    }
                    
                    
           
                $.ajax({
                    'url' : base_url + 'Transport/load_transport_students',
                    'type' : 'POST', //the way you want to send data to your URL
                    'data' : {'prn':prn,'org':org,'acyear':acyear},//,'campus':campus
                    'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
                        var container = $('#stddata'); //jquery selector (get element by id)
                        if(data){
                            
                         //alert(data);
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
        <li class="active"><a href="<?=base_url($currentModule)?>">Transport Facility</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Add Transport Student</h1>
           
        </div>
        
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                     

            
				<div class="panel-heading">
						 <div class="row">
					 
					  <div class="col-sm-3">
					<select class="form-control" name="acyear" id="acyear">
						<option value="">Select Academic Year</option>
						<?php 
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
					</select>
					</div>
					  <div class="col-sm-3">
					      <select class="form-control" name="org" id="org">
					          <?php
					          
								$exp = explode("_",$_SESSION['name']);

									 if($exp[1]=="sijoul")
								{
									  $where.=" AND campus_name='SIJOUL'";
								}
								
									if($exp[1]=="nashik")
								{
 
					          ?>
					      <option value="SU">Sandip University</option>
					  <option value="SF">Sandip Foundation</option>
					  <?php
						 }
						  elseif($exp[1]=="sijoul")
						  {
					  ?>
					  <option value="SU-SIJOUL">Sandip University Sijoul</option>
					  <option value="SF-SIJOUL">Sandip Foundation Sijoul</option>
					  <?php
						  }
						  else
						  {
					  ?>
					 
		      <option value="SU">Sandip University</option>
					  <option value="SF">Sandip Foundation</option>
				  <option value="SF-SIJOUL">Sandip Foundation Sijoul</option>
					  <?php
						}
					  ?>
					  </select>
					  </div>
                   
					  
					   <div class="col-sm-3"><input type="text" class="form-control" name="prn" id="prn" placeholder="Enter Student PRN No."></div>
                      <div class="col-sm-2">
					  <button class="btn btn-primary form-control" id="sbutton" type="button" >Search</button>
					  </div>
					 
			
					  
					  
					 
					 <!-- </form>-->
					</div>
				</div>
			    <div class="panel-body">
						
					  <div class="row">
					   
					   <div class="col-sm-12">
					   <?php 
					   echo "<span style='color:red;padding-left:110px;'>".@$this->session->flashdata('message1')."</span>";
					   ?>
					   </div>
					                     
                      </div>
						<!--<form id="form1" name="form1" enctype="multipart/form-data" action="<?=base_url($currentModule.'/search_student')?>" method="POST">-->
                    <div class="table-info" id="stddata">  
                 
                     <?php
                    // var_dump($data);
                     
                     //echo count($data);
                     ?>
                 
					</div>
         
				</div>    
       
    </div>
</div>
</div>
</div>