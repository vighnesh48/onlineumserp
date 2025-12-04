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
                     if(prn=='')
                    {
                        alert("Please Enter PRN Number");
                        return false;
                    }
                    
                    
           
                $.ajax({
                    'url' : base_url + '/Ums_admission/search_cancaldata',
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
            });
            
</script>
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="#">Hostel Students</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Hostel Students List</h1>
           <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                                        <div class="pull-right col-xs-12 col-sm-auto"><a style="width: 100%;" class="btn btn-primary btn-labeled" href="<?=base_url($currentModule.'/search_hostel_students')?>"><span class="btn-label icon fa fa-plus"></span>Add New</a></div>                        
                    <div class="visible-xs clearfix form-group-margin"></div>
                    
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
                       <span class="panel-title"><i class="panel-title-icon fa fa-fire text-danger">Students List</i></span>
			    		</div>
			    		<div class="panel-body">
						
						<!--<form id="form1" name="form1" enctype="multipart/form-data" action="<?=base_url($currentModule.'/search_student')?>" method="POST">-->
                       <div class="row">
					 
					<!--  <div class="col-sm-1"></div>
                      <div class="col-sm-3"><input type="text" class="form-control" name="prn" id="prn" placeholder="Enter Student PRN No."></div><label class="col-sm-1"></label>
                      <div class="col-sm-2"><button class="btn btn-primary form-control" id="sbutton" type="button" >Search</button></div>
					   <div class="col-sm-6"></div>
				-->
					  
					  
					 
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
                    <?php if(count($student_list)>0)
                    {
                        
                    ?>
                    <style>
                    .table-info thead th, .table-info thead tr{background: #774545;border-color:#FFFFFF !important}
                    </style>
                    <table class="table table-bordered" id="table2excel">
                        <thead>
                            <tr style="">
                                 <th>Sr No</th>
                                    <th>Student ID</th>
                                    <!-- <th class="noExl">Photo</th>-->
                                    <th>Name</th>
                                    <th>Stream </th>
                                    <th>Year</th>
                                    <th>Total Fee</th>
                                    <th>Fee Paid</th>
                                    <th class="noExl">Action</th>
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php
                          //  var_dump($emp_list);
                          
                            $j=1;                            
                            foreach($student_list as $emp_list)
                            {
                                
                            ?>
							 <?php if($emp_list['ro_flag']=='on') $bg="bgcolor='#e6eaf2'";
								  else $bg="";?>								
                            <tr <?=$bg?> <?=$emp_list["status"]=="N"?"style='background-color:#FBEFF2'":""?>>
                               
                        <td><?=$j?></td>
                                 <td><?=$emp_list['enrollment_no']?></td> 
                                 
                            
						<td>	
							<?php
								echo $emp_list['first_name']." ".$emp_list['middle_name']." ".$emp_list['last_name'];
								?>
								</td> 
							
								   <td><?=$emp_list['stream_name']?></td> 
                                                                                              
                            <td><?=$emp_list['admission_year']?></td>                               
                                                      
                                <td><?=$emp_list['mobile'];?></td> 
                                <td ><?=$emp_list['fee_paid'][0];?></td> 
                                          
                                <td class="noExl" style="padding:0px;" align="center">
                                    <p> 
			<a  href="<?php echo base_url()."ums_admission/view_studentFormDetails/".$emp_list['stud_id'].""?>" title="View" target="_blank"><i class="fa fa-eye"></i>&nbsp;  </a>
	       
	      
                             </td>
                            </tr>
                            <?php
                            $j++;
                            }
                            ?>                            
                        </tbody>
                    </table>
                    <?php
                    }
                    ?>
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                 
                </div>
         
                
                
                
                
                
                
                
                
                
            </div>    
        </div>
    </div>
</div>
</div>
</div>