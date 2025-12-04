
<style>
.model{overflow: hidden !important;}
.clickable{
    cursor: pointer;   
    	margin-top: 12px;
	   font-size: 15px;
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
$('#btnView').click(function(){

                var acad_year = $("#acad_year").val();
                var faculty_code = $("#faculty_code").val();
                var acad_session = $("#acad_session").val();

                      $("#loader1").html('<div class="loader"></div>');
                      $.ajax({
                                'url' : base_url + 'Faculty/get_faculty_lecture_attendance',
                                'type' : 'POST', //the way you want to send data to your URL
                                'data' : {'acad_year':acad_year,'faculty_code':faculty_code,'acad_session':acad_session},
                                'success':function (str) {
                                 //alert(str);
                                 
                                  $("#rowdata").css('display','');
                                  $("#reportdata").html(str);
                                   $("#loader1").html("");
                                }
                          });       
                 });
        });
		

</script>
<?php 
if(isset($role_id) && $role_id==1 ){
?>
<style>
	.table{width: 150%;}
	table{max-width: 150%;}
</style>									
<?php }else{ ?>
	<style>
	table.dataTable{width: 210%;}</style>
<?php }?>
<?php $astrik='<sup class="redasterik" style="color:red">*</sup>'; ?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Subject Details</a></li>
        <li class="active"><a href="#">Faculty Allocated Subject Details</a></li>
    </ul>
	
<div class="col-sm-12" >
      <div class="page-header">	
		<div class="panel">
                <div class="panel-heading">
               <span class="panel-title"> Faculty Allocated Subject Details:</span>
				</div>						

        <div class="row panel-body">
         
                            <div class="form-group">
							  
							  <div class="col-sm-2">
								<select name="acad_session" id="acad_session" class="form-control" required >
								<option value="">Select Session<?=$astrik?></option>
								<!--option value="WINTER">WINTER<?=$astrik?></option-->
							<?php foreach ($acad_session as $sess) {  ?>
							       <option value="<?=$sess['academic_session']?>" ><?=$sess['academic_session']?></option>
							<?php } ?>
								</select>
                              </div> 
							  
							  <div class="col-sm-2">
								<select name="acad_year" id="acad_year" class="form-control" required >
								<option value="">Select Academic Year<?=$astrik?></option>
							<?php foreach ($acad_year as $acad) {  ?>
							       <option value="<?=$acad['academic_year']?>" ><?=$acad['academic_year']?></option>
							<?php } ?>
								</select>
                              </div>
							  
							  <div class="col-sm-2">
								<select name="faculty_code" id="faculty_code" class="form-control" required >
								<option value="">Select Faculty<?=$astrik?></option>
							<?php foreach ($faculty_code as $fac) {  ?>
							       <option value="<?=$fac['emp_id']?>" ><?=$fac['fullname']?></option>
							   <?php } ?>
								</select>
                              </div>
                              
                               <div class="col-sm-2" id="semest">
							  <input type="button" class="btn btn-primary form-control" id="btnView" value="view">
						   </div>
                         </div>
                     <!--/form-->
				</div>        
            </div> 
<div id="loader12"> </div></center>			
    <div class="row" id="reportdata"> </div>
        </div>
    </div>
</div>
