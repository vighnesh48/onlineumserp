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
                    'url' : base_url + '/Ums_admission/load_cancel_admission',
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
    <li ><a href="#fruits" data-toggle="tab" style="">Search Cancelled data</a></li>
    <li class="active"><a href="<?php echo base_url();?>ums_admission/search_cancaldatafor_restar"  >Cancel Request</a></li>


</ul>
<div class="tab-content">
    <div class="tab-pane active" id="fruits">
	
	   <div class="col-sm-2" id="">
                                <select name="academic-year" id="academic-year" class="form-control" required>
                                  <option value=""> Academic Year</option>
                                   <option value="2016">2016-17</option>
                                   <option value="2017">2017-18 </option>
                                   <option value="2018">2018-19 </option>
								   <option value="2019">2019-20 </option>
                                  </select>
                             </div>
                              <div class="col-sm-2"><button class="btn btn-primary form-control" id="cbutton" type="button" >Search</button></div>
	
	</div>
    <div class="tab-pane" id="veggies">
	
	        <!--  <div class="col-sm-2"><input type="text" class="form-control" name="prn" id="prn" placeholder="Enter Student PRN No."></div>
                      <div class="col-sm-2"><button class="btn btn-primary form-control" id="sbutton" type="button" >Search</button></div> -->
	
	</div>
 
</div>
						
						
						<!--<form id="form1" name="form1" enctype="multipart/form-data" action="<?=base_url($currentModule.'/search_student')?>" method="POST">-->
              <br/> 
             <br/>
                    <div class="panel" id="makepmnt" style="display:none">
                            <div class="panel-heading">
                <span class="panel-title">Cancel Admission</span>
              </div>
                                <div class="panel-body">
                
                                 <div class="form-group">
                  
                 <!--  <label class="col-sm-3">Cancellation Fee</label>
                                    <div class="col-sm-3">
                                      <input type="text" name="cfee" id="cfee" class="form-control"  value="" placeholder="Cancellation Fee" required>
                                    </div>-->
                  
                                    <label class="col-sm-3">Cancellation Date</label>
                                    <div class="col-sm-3">
                                      <input type="text" class="form-control" id="doc-sub-datepicker20" name="cdate"  required value="" placeholder="Cancellation  Date" required readonly="true"/>
                                    </div>
                                   
                                  </div>
                                  <div class="form-group">
                                    <label class="col-sm-3">Remark</label>
                                    <div class="col-sm-3">
                                    <textarea class="form-control" name="cremark" id="cremark" ></textarea>
<input type="hidden" name="stid" id="stid" value="<?=$emp_list['stud_id']?>">
<input type="hidden" name="stenrl" id="stenrl" value="<?=$emp_list['enrollment_no']?>">
<input type="hidden" name="stayear" id="stayear" value="<?=$emp_list['admission_session']?>">
                                    </div>
                                   
                                  </div>
                                  

                  <div class="form-group">
                    <div class="col-sm-3"></div>
                                    <div class="col-sm-6"><button type="submit" name="Make_Payment" id="canc" value="Cancel Admission" class="btn btn-primary">Cancel Admission</button>
                                    </div>
                                  </div>
                                  
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
<?php  if(!empty($emp_list)) 
                            { ?>

                           <table class="table table-bordered table-striped" id="example">
                          
                        <thead style="width:100%">
                            <tr>
                                    <th>#</th>
                                     <th>PRN</th>
                                     <th class="noExl">Photo</th>
                                    <th>Name</th>
                                    <th>Stream </th>
                                    <th>Total Fee Paid </th>
                                    <th>Applicable Fee </th>
                                    <th>Actual Fee  </th>
                                    <th>Year</th>
                                    <th>Mobile</th>
                        
                                    <th class="noExl">Action</th>
                                   
                                    
                            </tr>
                        </thead>
                           <tbody id="itemContainer">
                            <?php
                          //  var_dump($emp_list);
                          
                            $j=1; 
                            /*print_r($emp_list[1]);
                            die;*/

                              for($i=0;$i<count($emp_list[0]);$i++)
                                {
                               
                            ?>
                      
                            <tr>
                               
                        
                                 <td><?php echo $j;?></td> 
                                  <td><?php echo $emp_list[0][$i]['enrollment_no']?></td> 
                         
                                   <td  class="noExl">
                                       <?php
                                     //  $tep = base_url().'uploads/2017-18/'.$emp_list[$i]['form_number'].'/' . $emp_list[$i]['form_number'].'_PHOTO.bmp';
                                     //  echo $tep;
                                       if (file_exists('uploads/2017-18/'.$emp_list[0][$i]['form_number'].'/' . $emp_list[0][$i]['form_number'].'_PHOTO.bmp')) {
                                         //  echo "yES";
                                           $ext = 'bmp';
                                       }
                                       else
                                       {
                                             $ext = 'jpg';
                                       }
                                       ?>
                                       
                                       <img src="https://erp.sandipuniversity.com/uploads/2017-18/<?=$emp_list['form_number']?>/<?=$emp_list[0][$i]['form_number']?>_PHOTO.<?=$ext?>" alt="" width="60"/></td> 
                                <td>
              
              <?php
                echo $emp_list[0][$i]['first_name']." ".$emp_list[0][$i]['middle_name']." ".$emp_list[0][$i]['last_name'];
                ?>
                </td> 
              
                   <td><?=$emp_list[0][$i]['stream_name']?> <input type="hidden" value="<?=$emp_list[0][$i]['enrollment_no']?>" name="sprn"></td>
                    <td><?=$emp_list[1][$emp_list[0][$i]['stud_id']]['total_fee'][0]['tot_fee_paid']?></td>
                                  <td><?=$emp_list[0][$i]['actual_fee']?></td> 
                                   <td><?=$emp_list[0][$i]['applicable_fee']?></td> 
                            <td><?=$emp_list[0][$i]['admission_year']?></td>                               
                                                      
                                <td><?=$emp_list[0][$i]['mobile'];?></td>    
                                          
                                <td class="noExl" style="padding:0px;" align="center">
                                    <p> 
      <a  href="<?php echo base_url()."ums_admission/view_studentFormDetails/".$emp_list[0][$i]['stud_id'].""?>" title="View" target="_blank"><i class="fa fa-eye"></i>&nbsp;  </a>|
         
          <?php
                                 //   if(($_SESSION['role_id']=='1' || $_SESSION['role_id']=='2'  || $_SESSION['role_id']=='6'   || $_SESSION['role_id']=='5' ) && $emp_list['cancelled_admission']=='N' )
                                  //  {
                                    ?>  
                                        
        <span id="hidet">
        <!--   <a  href="javascript:void(0)" title="Cancel Admission" id="pmnt" onclick="get_details('<?php echo $emp_list[0][$i]['stud_id']; ?>','<?php echo $emp_list[0][$i]['enrollment_no']; ?>','<?php echo $emp_list[0][$i]['admission_session'] ?>')" > <i class="fa fa-trash-o"></i></a> -->
           <a href="<?php echo base_url()."ums_admission/cancel_stud_adm_request/".$emp_list[0][$i]['stud_id']."/".$emp_list[0][$i]['enrollment_no']."/".$emp_list[0][$i]['academic_year']?>" title="Cancel Admission" id="pmnts" ><i class="fa fa-trash-o"></i> </a>
          
          </span>
                                
                       
                    
                             
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
else
{
   echo "Record Not Found";       
}
            ?>                  
                        </tbody>
                    </table>
               
                    
                    
                    
                    
                    
                    
                    
                    
                    
                 
                </div>

                 
         
                
                
                
                
                
                
                
                
                
            </div>    
        </div>
    </div>
</div>
</div>
</div>
<script>
$('#doc-sub-datepicker20').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
        $('#doc-sub-datepicker21').datepicker( {format: 'yyyy-mm-dd',autoclose: true});   
  function get_details(stud,enroll,session)
  {
    

    $("#makepmnt").show();
    $("#stid").val(stud);
    $("#stenrl").val(enroll);
    $("#stayear").val(session);

  }
       
</script>



<script>

$('#canc').click(function(){

//alert(var1);
var  dat= $("#doc-sub-datepicker20").val();
var remark = $("#cremark").val();
var cfee = $("#cfee").val();
var stid = $("#stid").val();
var stenrl = $("#stenrl").val();
var stayear = $("#stayear").val();
var sprn = $("#sprn").val();

                    /* if(cfee=='')
                    {
                        alert("Please Enter Cancellation Fee");
                        return false;
                    }*/
                    
                    
                     if(dat=='')
                    {
                        alert("Please Select Cancellation Date");
                        return false;
                    }
                    
                     if(remark=='')
                    {
                        alert("Please Enter Cancellation Remark");
                        return false;
                    }
                    
var text='';

  text = "Are you sure you want to cancel Admission";  

//var txt;
    if (confirm(text) == true) {
       // txt = "You pressed OK!";
        
    } 
    else
    {
        return false;
    }


 $.ajax({
                    'url' : base_url + '/Ums_admission/cancel_stud_adm',
                    'type' : 'POST', //the way you want to send data to your URL
                    'data' : {'stid':stid,'remark':remark,'cfee':cfee,'dat':dat,'stenrl':stenrl,'stayear':stayear,'sprn':sprn},
                    'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
                       //if(type1=="S"){var container = $('#stest');}else{var container = $('#ptest');} //jquery selector (get element by id)
                        if(data){
                            
                       
                            alert("Admission Cancelled Successfully");
                            $("#makepmnt").hide();
                            $("#hidet").hide();
                            //$("#"+type).val('');
                          //  container.html(data);
                          //location.reload();
                              return false;
                        }
                          return false;
                    }
                });
});







</script>