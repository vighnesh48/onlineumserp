<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/bootstrap-modal-fullscreen/1.0.3/bootstrap-modal-fullscreen.min.js"></script>
<style>
.model{overflow: hidden !important;}
.clickable{
    cursor: pointer;   
    	margin-top: 12px;
	   font-size: 15px;
}

.loader {
  border: 6px solid #f3f3f3;
  border-radius: 50%;
  border-top: 6px solid #3498db;
  width: 50px;
  height: 50px;
  -webkit-animation: spin 2s linear infinite; /* Safari */
  animation: spin 2s linear infinite;
}
    .modal-dialog {
      width: 100%;
      padding: 0;
      margin:0;
    }
    
    .modal-body{
    max-height:calc(100vh - 100px);
    overflow-y: auto;
    }
.modal-open {
    overflow: hidden;
}

/* Safari */
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>
<script>    
    $(document).ready(function(){
     var base_url = 'https://erp.sandipuniversity.com/';

        $('#btnView').click(function(){
                var academic_year = $("#academic_year").val();
                var admission_type = $("#admission_type").val();
                var report_type = $("#report_type").val();
               
                
                  if(academic_year=="" ||admission_type==""||report_type==""){
                      alert("Please select All  Options ");
                  }
                  else {
                      $("#loader1").html('<div class="loader"></div>');
                      $.ajax({
                                'url' : base_url + '/account/get_admission_fees_report',
                                'type' : 'POST', //the way you want to send data to your URL
                                'data' : {'academic_year':academic_year,'report_type':report_type,'admission_type':admission_type,'act':'view'},
                                'success':function (str) {
                                 //alert(str);
                                 // $("#reportdata").html("<div class="loader"></div>");
                                  $("#rowdata").css('display','');
                                  $("#reportdata").html(str);
                                   $("#loader1").html("");
                                }
                          });
                      
                  }
                     
                  
        });
        
         $('#btnExcel').click(function(){
                var academic_year = $("#academic_year").val();
                var admission_type = $("#admission_type").val();
                var report_type = $("#report_type").val();
     
                  if(academic_year=="" ||admission_type==""||report_type==""){
                      alert("Please select All  Options ");
                  }
                  else
                  {
                       $("#loader1").html('<div class="loader"></div>');
                       $("#FrmAdm").submit();
                       
                        $.ajax({
                                'url' : base_url + '/account/get_admission_fees_report',
                                'type' : 'POST', //the way you want to send data to your URL
                                'data' : {'academic_year':academic_year,'report_type':report_type,'admission_type':admission_type,'act':'excel'},
                                'success':function (str) {
                                 //alert(str);
                                 // $("#reportdata").html("<div class="loader"></div>");
                                  $("#rowdata").css('display','');
                                  $("#reportdata").html("<center><h4>Excel Downloaded Successfully....!!</h4></center>").delay(700);
                                   $("#loader1").html("");
                                }
                          });
           
                  }
            
            
        });
      
		
    });

</script>

<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Student</a></li>
        <li class="active">Result<a href="#"></a></li>
    </ul>
    <div class="page-header">
      <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-heading">
                            <span class="panel-title form-group"><i class="fa fa-list-alt page-header-icon h3"></i>&nbsp;&nbsp;Result List</span>
                    </div>
                    <div class="panel-body panel-success">
                             <div class="row">
                                 <table class="table table-responsive table-bordered panel-primary">
                                     <tr class="h4" >
                                         <td>S.No</td>
                                        <td>Exam Name</td>
                                        
                                        <td>Action </td>
                                    </tr>
									<?php $i=1;
									foreach($ex_list as $ext){
										if($ext['exam_type']=='Makeup'){
											$extype='Supplimentry';
										}else{
											$extype='END SEMESTER';
										}
																			?>
                                    <tr>
                                        <td><?=$i?></td>
                                         <td><?=$extype?> EXAMINATION <b><?=$ext['exam_month'].'-'.$ext['exam_year'];?></b></td>
                                          
                                           <td><a href="http://www.sandipuniversity.edu.in/result/display_for_erp.php?exam=<?=base64_encode($ext['exam_id'])?>&prn=<?=base64_encode($stud[0]['enrollment_no'])?>&dob=<?=base64_encode($stud[0]['dob'])?>&studlogin=Y&year=<?=base64_encode($stud[0]['academic_year'])?>"  target="_blank" class="btn btn-primary">show</a></td>
                                    </tr>
									<?php $i++; }?>
									<?php if($stud[0]['admission_stream']=='71' && $stud[0]['current_year']=='2'){?>
									<tr>
                                        <td>2</td>
                                         <td>University Semester End Examination</td>
                                          <td>MAY-2019</td>
                                           <td><a href="http://www.sandipuniversity.edu.in/result/display.php?exam=6&prn=<?=$stud[0]['enrollment_no']?>&dob=<?=$stud[0]['dob']?>"  target="_blank" class="btn btn-primary">show</a></td>
                                    </tr>
									<?php }?>
                                 </table>
								        
								   
							  </div>
		         
                    </div>  
                             
                   </div>
                  
           </div>
           
        
      </div>
    </div>
     </div>   
   
</div> 



    
  
 
    
    


