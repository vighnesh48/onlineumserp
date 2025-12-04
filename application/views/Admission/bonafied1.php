<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>

<script>    

	
	
	
	 $(document).ready(function(){
               $('#form1').submit(function(){
            
         // alert("hi");
          
                   // alert(type);
                   var prn = $("#prn").val();
                    var idate = $("#idate").val();
                    var reg = $("#reg").val();
                     var purpose = $("#purpose").val();
                     
                     if(prn=='')
                    {
                        alert("Please Enter PRN ");
                        return false;
                    }
                    
                         if(reg=='')
                    {
                        alert("Please Enter Reference Number ");
                        return false;
                    }
                       if(idate=='')
                    {
                        alert("Please select date ");
                        return false;
                    }
                  
                       if(purpose=='')
                    {
                        alert("Please Enter Purpose ");
                        return false;
                    }
                    
           
          
            });
            });
            
            
            
            	 $(document).ready(function(){
               $('#ver').click(function(){
            
         // alert("hi");
             var base_url = 'https://erp.sandipuniversity.com/';
                   // alert(type);
                   var prn = $("#prn").val();
              
              
                     if(prn=='')
                    {
                        alert("Please Enter PRN Number");
                        return false;
                    }
                    
                    
           
                $.ajax({
                    'url' : base_url + '/Ums_admission/verifyprn_bonafide',
                    'type' : 'POST', //the way you want to send data to your URL
                    'data' : {'prn':prn},
                    'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
                        var container = $('#vdata'); //jquery selector (get element by id)
                        if(data){
                            if(data=='N')
                            {
                               // alert("PRN Number Does not exists");
                                container.html("PRN Number Does not exists");
                                $('#prn').val('');
                            }
                            else
                            {
                                
                                 $('#hide1').show();
                                  container.html(data);
                            }
                        //  alert(data);
                            //alert("Marks should be less than maximum marks");
                            //$("#"+type).val('');
                          
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
        <li class="active"><a href="#">Bonafied Certificate</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp; Student Boafied </h1>
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
                         <div class="col-sm-4">
                       <span class="panel-title"><i class="panel-title-icon fa fa-fire text-danger"></i>Generate Bonafied</span>
                       </div>
                       
			    	</div>
			    		<div class="panel-body">
			    		    	 <?php   echo "<span style='color:red;padding-left:110px;'>".@$this->session->flashdata('message1')."</span>"; ?>
						<br>
						
					<form id="form1" name="form1" method="post" enctype="multipart/form-data" action="<?=base_url($currentModule.'/bonafied_pdf')?>" >
                        <div class="row">
					   <div class="form-group">

                    <label class="col-sm-2">Student PRN </label><div class="col-sm-2"><input type="text" class="form-control" name="prn" id="prn" placeholder="Student PRN No."></div>
                    <div class="col-sm-2"><button class="btn btn-primary form-control" id="ver" type="button" >Verify</button> </div>
                   
                      
					  </div>
					  </div>
					  	  <div class="row" id="vdata">
					  	      </div>
					  <div class="row">
					      <hr>
					      </div>
					      <div id="hide1" style="display:none;">
					      
					  <div class="row">
					   <div class="form-group">
					   <label class="col-sm-2">Reference No.</label>   
                      <div class="col-sm-4"><input type="text" class="form-control" name="reg" id="reg" placeholder="Reference No."></div><label class="col-sm-2">Purpose</label>
                    <div class="col-sm-4"> <textarea class="form-control" name="purpose" id="purpose" placeholder="Purpose"></textarea></div>
					  
					  
					   </div>
				
					  </div>
					   <div class="row">
					   <div class="form-group">
					          <label class="col-sm-2">Date</label>
                      <div class="col-sm-4"><input type="text" class="form-control" name="idate" id="idate" placeholder=""></div>
					 
					  <div class="col-sm-2"><button class="btn btn-primary form-control" id="" type="submit" >Generate Bonafide</button> </div>
					  </div>
					  </div>
					  
					  </div>
					  <div class="row">
					   <div class="form-group">
					   <div class="col-sm-3"></div>
					   <div class="col-sm-6">
				
					   </div>
					 </div>                      
                      </div>
					</form>
                </div>
                
                    <div class="table-info" id="stddata">    
                 
                 
                  <?php if(count($student_list)>0)
                    {
                        
                    ?>
                   
                    <table class="table table-bordered " id="table2excel">
                        <thead>
                            <tr style="">
                                 <th>S.No</th>
                                    <th>PRN</th>
                                    <!-- <th class="noExl">Photo</th>-->
                                    <th>Reference Number</th>
                                    <th>Issue Date </th>
                                    <th>Purpose</th>  <th>Action</th>
                                    
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php
                        //  var_dump($student_list);
                          
                            $j=1;                            
                            foreach($student_list as $emp_list)
                            {
                                
                            ?>
							 <?php if($emp_list['ro_flag']=='on') $bg="bgcolor='#e6eaf2'";
								  else $bg="";?>								
                            <tr <?=$bg?> <?=$emp_list["status"]=="N"?"style='background-color:#FBEFF2'":""?>>
                               
                        <td><?=$j?></td>
                                 <td><?=$emp_list['enrollment_no']?></td> 
                                 
                            
						
							
								   <td><?=$emp_list['cert_reg']?></td> 
                                                                                              
                            <td><?=$emp_list['cert_date']?></td>                               
                                                      
                                <td><?=$emp_list['purpose'];?></td> 
                                
                      <td><a href="<?=base_url($currentModule.'/regenerate_bonafide/'.$emp_list['bc_id'].'/'.$emp_list['enrollment_no'])?>" target="_blank">view </a> </td> 
                            
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



<script>
  $('#idate').datepicker( {format: 'dd-mm-yyyy',autoclose: true});
</script>