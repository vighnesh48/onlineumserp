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
          //    var acyear = $("#acyear").val();
                    if(prn1=='')
                    {
                        alert("Please Enter PRN Number");
                        return false;
                    }
                    
                $.ajax({
                    'url' : base_url + 'Ums_admission/verifyprn_bonafide',
                    'type' : 'POST', //the way you want to send data to your URL
                    'data' : {'prn':prn1},
                
                    'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
                  
                   
              
                        if(data){
                            if(data=='N')
                            {
                            //  alert(data); 
                               // container.html("PRN Number Does not exists");
                                 $('#errordiv').html("PRN Number Does not exists");
                                
                             //   $('#prn').val('');
                            }
                            else
                            
                            { 
                                 $('#errordiv').html('');
                                 var jdata= JSON.parse(data);
                                
                                $("#bonafied_div").show();
                                 //console.log(jdata);
                                  $("#stud_name").html(jdata.first_name+'  '+jdata.middle_name+'   '+jdata.last_name);
                                  $("#stream_name").html(jdata.stream_name);
                                    $("#year").html(jdata.current_year);
                                    $("#adyear").html(jdata.admission_session);
                                    $("#acyear").html(jdata.academic_year);
                                     $("#prn").val(jdata.enrollment_no);
                                       $("#stud_id").val(jdata.stud_id);
									   $("#semester").html(jdata.current_semester);
									   //alert(jdata.current_semester);
                                       var sid = jdata.stud_id;
									   var sem = parseInt(jdata.current_semester)+1;
                                       var d = new Date();
                                       var n =jdata.current_year;// d.getFullYear();
                                     
                                       if(n*2==jdata.current_semester)
                                       {
                                            var lin ='<div style="color:red">Student semester is already promoted</div>';
                                       }
                                       else if(jdata.is_detained=='Y')
                                       {  
                                            if(jdata.academic_year==n)
                                            {
                                                var lin ='<div style="color:red">Student is Detained. kindly contact to COE department.</div>';

                                            }
                                            else
                                            {
                                                 var stat='Y';
                                                var lin ='<a href="'+base_url+'ums_admission/promote_semester/'+sid+'/'+sem+'"> <button class="btn btn-primary form-control" id="btn_prn" type="button" >Promote Student </button> </a>';
                                            }
                                        }
                                       else
                                       {
                                        var lin ='<a href="'+base_url+'ums_admission/promote_semester/'+sid+'/'+sem+'"> <button class="btn btn-primary form-control" id="btn_prn" type="button" >Promote Student </button> </a>';
                                       }
                                     $("#rereg").html(lin);
                                     
                            }
                        
                                return false;
                        }
                          return false;
                    }
                    
                });
            });
    
    
    
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

} );

</script>

<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="#">Student Semester Promotion</a></li>
    </ul>
    <div class="page-header">           
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Semester Promotion</h1>
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
                    <div class="panel-heading">
                            <span class="panel-title">Semester Promotion</span>
                    </div>
                    <div class="panel-body">
                        <div class="table-info">                            
                            
                                    <?php   echo "<span style='color:red;padding-left:110px;'>".@$this->session->flashdata('message1')."</span>"; ?> 
                                     <?php   echo "<span style='color:green;padding-left:110px;'>".@$this->session->flashdata('message2')."</span>"; ?> 
                               
                                <div class="form-group" id="errordiv" style="color:red">
                                    
                                    </div>
                                <div class="form-group">
                                   
                                    <label class="col-sm-2">Student PRN: <?=$astrik?></label>                                    
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
                            <span id="bonafied_div" style="display:none;" >
                                <div class="form-group">
                                    <div class="col-sm-2"></div>
                                    <label class="col-sm-2">Student Name:</label>                                    
                                    <div class="col-sm-4"><b><span id='stud_name'></span></b></div> 
									<div class="col-sm-2">Current Semester&nbsp;&nbsp;<b><span id='semester'></b></span></div>   									
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-2"></div>
                                    <label class="col-sm-2">Stream:</label>                                    
                                    <div class="col-sm-4"><b><span id='stream_name'></span></b></div>                                    
                                    <div class="col-sm-1">Year:&nbsp;&nbsp;<b><span id='year'></b></span></div>
                                    <div class="col-sm-2"></div>
                                </div>
                                
                                   <div class="form-group">
                                    <div class="col-sm-2"></div>
                                    <label class="col-sm-2">Admission Year:</label>                                    
                                    <div class="col-sm-4"><b><span id='adyear'></span></b></div>                                    
                                    <div class="col-sm-3">Academic Year:&nbsp;&nbsp;<b><span id='acyear'></b></span></div>
                                   
                                </div>
                                
                                
                                 <div class="form-group" >
                                  <div class="col-sm-4"></div>
                                   <div class="col-sm-2" id="rereg"></div>
                                  <div class="col-sm-5"></div>
                                </div>
                                
                                
                                    <hr>
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
</script>

