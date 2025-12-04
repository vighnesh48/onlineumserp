<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>

<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.4.2/js/buttons.html5.min.js"></script>
<script src="https:////cdn.datatables.net/buttons/1.4.2/js/buttons.print.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.4.2/css/buttons.dataTables.min.css">
<script>
    <?php
$astrik = '<sup class="redasterik" style="color:red">*</sup>';
?>

$(document).ready(function() {
     $('#btn_prn').click(function(){
             var base_url = '<?=site_url()?>';
             var prn1 = $("#prn1").val();
          //    var acyear = $("#acyear").val();
                    if(prn1=='')
                    {
                        alert("Please Enter PRN Number");
                        return false;
                    }
                    
                $.ajax({
                    'url' : base_url + '/Pdc/serach_prn_student_master',
                    'type' : 'POST', //the way you want to send data to your URL
                    'data' : {'prn':prn1},
                
                    'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
                  
                   
              
                        if(data){
                            var jdata= JSON.parse(data);
                            
                            $("#showform").show();
                       
                               
                                
                                //alert(jdata.enrollment_no);
                              
                                  $("#prn").val(jdata[0].enrollment_no);
                                  $("#sfname").val(jdata[0].first_name);
                                  $("#academic_year").val(jdata[0].academic_year);
                                  $("#student_id").val(jdata[0].stud_id);
                                    /*$("#year").html(jdata.admission_year);
                                  $("#adyear").html(jdata.academic_year);
                                    $("#acyear").html(jdata.academic_year);
                                     $("#prn").val(jdata.prov_reg_no);
                                       $("#stud_id").val(jdata.adm_id);*/
                                   
                                     
                           
                            
                        }
                         
                    }
                    
                });
            });
    
    
    /*
     $('#form1').submit(function(){
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
*/
} );

</script>

<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">PDC</a></li>
        <li class="active"><a href="#">PDC Registration</a></li>
    </ul>
    <div class="page-header">           
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;PDC Registration</h1>
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
                  <!--  <div class="panel-heading">
                            <span class="panel-title">New Registration</span>
                    </div>-->
                    <div class="panel-body">
                        <div class="table-info">                            
                             <div class="form-group">
                                   
                                    <label class="col-sm-3"> Provisional Registration Number <?=$astrik?></label>                                    
                                    <div class="col-sm-2"><input type="text" id="prn1" name="prn1" class="form-control" value="" /></div>                                    
                                   
                                  <!--  <label class="col-sm-2">Academic Year</label>
                                    <div class="col-sm-2">
                                    <select name="acyear" id="acyear" class="form-control" required="">
                                
                                     <option value="2017" selected="">2017-18</option>
                                     <option value="2016">2016-17</option>
                                   </select>
                                    </div>-->
                                     <div class="col-sm-2"><button class="btn btn-primary form-control" id="btn_prn" type="button" >Submit </button> </div>
                                </div>
                                <hr>
                            <div style="display:none;" id="showform">
                            <form id="form" name="form" action="<?=base_url($currentModule.'/submit_pdc')?>" method="POST" enctype="multipart/form-data">                                                               
                                <input type="hidden" value="" id="student_id" name="student_id" />
                                                             
                                  <div class="form-group">
                              <label class="col-sm-3">Student Name <?= $astrik ?></label>
                              <div class="col-sm-3">
                               
                                  <input data-bv-field="sfname" id="sfname" name="sfname" class="form-control" value="<?= isset($personal[0]['fname']) ? $personal[0]['fname'] : ''; ?>" placeholder="Student Name" type="text" required="required">
                               
                               
                                </div>  
                                
                            <label class="col-sm-3">PRN Number </label>
                              <div class="col-sm-3">
                               
                               <input type="text" id="prn" name="prn" class="form-control" readonly="readonly" placeholder="Student prn Number" required="required" />
                    
                                </div>   
                                
                              </div>

                                  <div class="form-group">
                              <label class="col-sm-3">Cheque No <?= $astrik ?></label>
                              <div class="col-sm-3">
                               
                                  <input data-bv-field="chk_no" id="chk_no" name="chk_no" class="form-control" value="" placeholder="Cheque No" type="text" required="required">
                               
                               
                                </div>   
                                
                            <label class="col-sm-3">Upload Cheque Receipt </label>
                              <div class="col-sm-3">
                               
                               <input type="file" name="upload"  />
                    
                                </div>   
                                
                              </div>
                                  <div class="form-group">
                              <label class="col-sm-3">Amount <?= $astrik ?></label>
                              <div class="col-sm-3">
                               
                                  <input data-bv-field="amount" id="amount" name="amount" class="form-control" value="" placeholder="Enter Amount" type="text" required="required">
                               
                               
                                </div>  
                                
                            <label class="col-sm-3">Cheque Date <?= $astrik ?> </label>
                              <div class="col-sm-3">
                               
                              <input type="text" required="required" class="form-control" id="idate" name="idate" placeholder="Select date">
                    
                                </div>   
                                
                              </div>
                                  <div class="form-group">
                              <label class="col-sm-3">Bank Name <?= $astrik ?></label>
                              <div class="col-sm-3">
                               
                                  <select id="bank_name" name="bank_name" class="form-control" required="required">
                                            <option value="">Select Bank</option>
                                            <?php  if(isset($bank_details))
                                            {
                                                foreach($bank_details as $bankd)
                                                {
                                                    ?>
                                                    <option value="<?php echo $bankd['bank_id']; ?>"><?php echo $bankd['bank_name'];?></option>
                                                    <?php 
                                                }
                                            }
                                                ?>

                                            
                                           
                                        </select>
                               
                               
                                </div>  
                                
                            <label class="col-sm-3">City Name </label>
                              <div class="col-sm-3">
                               
                               <input type="text" id="city_name" name="city_name" class="form-control"  placeholder="Enter city name" />
                    
                                </div>   
                                
                              </div>
                                  <div class="form-group">
                              <label class="col-sm-3">Academic Year <?= $astrik ?></label>
                              <div class="col-sm-3">
                               
                                  <input data-bv-field="academic_year" id="academic_year" name="academic_year" class="form-control" value="" placeholder="" type="text" required="required">
                               
                               
                                </div>  
                                
                            <label class="col-sm-3">Remark</label>
                              <div class="col-sm-3">
                               
                            <textarea class="form-control" id="remark" name='remark' rows="3"></textarea>
                    
                                </div>   
                                
                              </div>

                             <!--    <div class="form-group">
                                    <label class="col-sm-3">Campus Type <?=$astrik?></label>                                    
                                    <div class="col-sm-6">
                                        <select id="course_type" name="course_type" class="form-control">
                                            <option value="">Select Type</option>
                                            <option value="E">Engineering</option>
                                            <option value="M">Management</option>
                                            <option value="P">Polytechnic</option>
                                            <option value="PH">Pharmacy</option>
                                        </select>
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('course_type');?></span></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3">Campus Duration [in Yrs] <?=$astrik?></label>                                    
                                    <div class="col-sm-6">
                                        <select id="duration" name="duration" class="form-control">
                                            <option value="">Select Type</option>
                                            <?php for($i=1;$i<=10;$i++) {?>
                                            <option value="<?=$i?>"><?=$i." Yrs "?></option>
                                            <?php } ?>
                                        </select>
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('course_type');?></span></div>
                                </div> -->
                                <div class="form-group">
                                    <div class="col-sm-4"></div>
                                    <div class="col-sm-2">
                                        <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Submit</button>                                        
                                    </div>                                    
                                    <div class="col-sm-2"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule)?>'">Cancel</button></div>
                                    <div class="col-sm-4"></div>
                                </div>
                            </form>
                           </div>
                        </div>
                    </div>
                </div>
            </div>       
        </div>
    </div>
</div>


<script>
    var date = new Date();
  var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
  var end = new Date(date.getFullYear(), date.getMonth(), date.getDate());
  $('#idate').datepicker( {format: "yyyy-mm-dd",
todayHighlight: true,
startDate: today,

autoclose: true});




</script>
