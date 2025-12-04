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

$(document).ready(function() {
     $('#btn_prn').click(function(){
             var base_url = 'https://erp.sandipuniversity.com/';
             var prn1 = $("#prn1").val();
                    if(prn=='')
                    {
                        alert("Please Enter PRN Number");
                        return false;
                    }
                    
                $.ajax({
                    'url' : base_url + 'Ums_admission/verifyprn_bonafide',
                    'type' : 'POST', //the way you want to send data to your URL
                    'data' : {'prn':prn1},
                
                    'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
                   
                    var jdata= JSON.parse(data);
              
                        if(data){
                            if(data=='N')
                            {
                                container.html("PRN Number Does not exists");
                                $('#prn').val('');
                            }
                            else
                            
                            {  $("#bonafied_div").show();
                                 
                                  $("#stud_name").html(jdata.first_name+'  '+jdata.middle_name+'   '+jdata.last_name);
                                  $("#stream_name").html(jdata.stream_name);
                                    $("#year").html(jdata.year);
                                     $("#prn").val(jdata.enrollment_no);
                                       $("#stud_id").val(jdata.stud_id);
                                    
                                    
                            }
                        
                            	return false;
                        }
                          return false;
                    }
                    
                });
            });
    
    
    
     $('#form1').submit(function(){
                   var prn = $("#prn").val();
   
                         var reg = $("#reg").val();
                  
                         
                    var idate = $("#idate").val();
                  
                  
                     
                     if(prn=='')
                    {
                        alert("Please Enter PRN ");
                        return false;
                    }
                    
           
                    
                    
                         if(reg=='')
                    {
                        alert("Please Enter Transfer Certificate Number ");
                        return false;
                    }
                    
                    
                              if(idate=='')
                    {
                        alert("Please Select Transfer Certificate Date ");
                        return false;
                    }
            
        
           
          
            });

} );

</script>

<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="#">Migration Certificate</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;>Migration Certificate</h1>
            <div class="col-xs-12 col-sm-8">         <div class="pull-right col-xs-12 col-sm-auto"><a style="width: 100%;" class="btn btn-primary btn-labeled" href="<?=base_url($currentModule.'/migration_certificate/')?>"><span class="btn-label icon fa fa-back"></span> Back to Migration Certificate list</a></div> 
                   
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
                            <span class="panel-title">>Migration Certificate Form</span>
                    </div>
                    <div class="panel-body">
                        <div class="table-info">                            
                            
                                    <?php   echo "<span style='color:red;padding-left:110px;'>".@$this->session->flashdata('message1')."</span>"; ?> 
                                     <?php   echo "<span style='color:green;padding-left:110px;'>".@$this->session->flashdata('message2')."</span>"; ?> 
                               
                                <div class="form-group">
                                    <div class="col-sm-2"></div>
                                    <label class="col-sm-2">Student PRN: <?=$astrik?></label>                                    
                                    <div class="col-sm-2"><input type="text" id="prn1" name="prn1" class="form-control" value="" /></div>                                    
                                    <div class="col-sm-2"><button class="btn btn-primary form-control" id="btn_prn" type="submit" >Submit </button> </div>
                                </div>
                                <hr>
                            <span id="bonafied_div" style="display:none;" >
                                <div class="form-group">
                                    <div class="col-sm-2"></div>
                                    <label class="col-sm-2">Student Name:</label>                                    
                                    <div class="col-sm-4"><b><span id='stud_name'></span></b></div>                                    
                                    <div class="col-sm-4"></div>   
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-2"></div>
                                    <label class="col-sm-2">Stream:</label>                                    
                                    <div class="col-sm-4"><b><span id='stream_name'></span></b></div>                                    
                                    <div class="col-sm-1">Year:&nbsp;&nbsp;<b><span id='year'></span></b></div>
                                    <div class="col-sm-2"></div>
                                </div>
                                    <hr>
                        <form id="form1" name="form1" action="<?=base_url($currentModule.'/generate_migration_cert')?>" method="POST">  
                       <input type="hidden" id="prn" name="prn" class="form-control" />
                         <input type="hidden" id="stud_id" name="stud_id" class="form-control" />
                         <!--
                               <div class="form-group">
                                   <div class="col-sm-2"></div>
                                   <label class="col-sm-2">Case Number</label>   
                                    <div class="col-sm-3"><input type="text" class="form-control" name="cnum" id="cnum" placeholder="Case Number"></div>
                               
                                </div>-->
                                
                                
                                <div class="form-group">
                                    <div class="col-sm-2"></div>
                                    <label class="col-sm-2">T.C. No.</label>                                    
                                    <div class="col-sm-3"><input type="text" class="form-control" name="reg" id="reg" placeholder="TC Number" required></div>                                    
                                   
                                </div>
                                
                                         <div class="form-group">
                                    <div class="col-sm-2"></div>
                                    <label class="col-sm-2"> Date:</label>                                    
                                    <div class="col-sm-3"> <input type="text" class="form-control" name="idate" id="idate" placeholder=""
                                    required></div>  
                                
                                </div>
                                
                               <!-- <div class="form-group">
                                    <div class="col-sm-2"></div>
                                    <label class="col-sm-2">Note</label>                                    
                                    <div class="col-sm-3"> <textarea class="form-control" name="note" id="note" placeholder="Note"></textarea></div>                                    
                             
                                </div>-->
                       
                                <div class="form-group">
                                    <div class="col-sm-4"></div>
                                    <div class="col-sm-3"><button class="btn btn-primary form-control" id="" type="submit" >Generate Migration Certificate</button></div>                                 
                                    <div class="col-sm-2"><button class="btn btn-primary form-control" id="cancel" type="submit" >Cancel</button></div>                                    
                                    <div class="col-sm-3"></div>   
                                </div>
                                
                                
                                
                            </form>
                          </span> 
                        </div>
                    </div>
                </div>
            </div>  
             
        </div>
    </div>
</div>


<script>
  $('#idate').datepicker( {format: 'dd-mm-yyyy',autoclose: true});
    $('#ldate').datepicker( {format: 'dd-mm-yyyy',autoclose: true});
</script>

