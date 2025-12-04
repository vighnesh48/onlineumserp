<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<script src="<?=base_url('assets/javascripts')?>/jquery.table2excel.js"></script>
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

@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

</style>
<script src="https://cdn.jsdelivr.net/npm/xlsx/dist/xlsx.full.min.js"></script>
<script>    
    $(document).ready(function(){
     var base_url = 'https://erp.sandipuniversity.com/';
     var btn='<div class="col-sm-1"><input type="button" class="btn btn-primary form-control" id="btnView" value="view"></div><div class="col-sm-1 hidden"><input type="submit"  class="btn btn-primary form-control " id="btnExcel" value="Excel"></div><div class="col-sm-1"><button class="btn btn-primary form-control" type="button" onclick="export_to_excel()" >Excel</button></div>';
     var schoolstr='<div class="col-sm-4"><select id="school_id" name="school_id" class="form-control"  required><option value="">Select School </option></select> </div><div class="col-sm-3"></div>';
     var coursestr='<div class="col-sm-3"><select id="course_id" name="course_id" class="form-control"  required><option value="">Select Course </option></select> </div>';
     var streamstr='<div class="col-sm-3"><select id="stream_id" name="stream_id" class="form-control"  required><option value="">Select Stream </option></select> </div>';
     var yearstr='<div class="col-sm-2"><select id="year" name="year" class="form-control"  required><option value="">Select Year </option></select> </div>';
  
  $("#disbutton").html(btn);
  $("#report_type").change(function(){
        var report_type = $("#report_type").val();
      
        if(report_type=="10"||report_type=="11"){
            var academic_year = $("#academic_year").val();
            var school_id = $("#school_id").val();
            var course_id = $("#course_id").val();
            var stream_id = $("#stream_id").val();
             var year = $("#year").val();
            get_school(academic_year);
            
            $("#disbutton").html(schoolstr);
            $("#specificrow").html('<br>'+coursestr+' '+streamstr+' '+yearstr+' '+btn);
        }
        else{
           $("#disbutton").html(btn); 
            $("#specificrow").html('');
        }
      
  });
  $("#academic_year").change(function(){
      var academic_year = $("#academic_year").val(); 
        get_school(academic_year);
  });
  function check_appoval_validation(school_id,course_id,stream_id,year){
        if(school_id=="0"||course_id=="0"||stream_id=="0"||year=="0"){
            alert("Please select all the options properly..");
            return false;
        }
        else{
            return true;
        }
  }
        function get_school(academic_year){
                          $.ajax({
                                 'url' : base_url + 'admission/get_ajax_admission_course',
                                'type' : 'POST', //the way you want to send data to your URL
                                'data' : {'academic_year':academic_year,'type':'school'},
                                'success':function (str) {
                                 //alert(str);
                                  $("#school_id").html('<option value="0">Select School</option>'+str);
                                }
                          });
                }
                
        function get_courses(academic_year,school_id){
             $.ajax({
                                'url' : base_url + 'admission/get_ajax_admission_course',
                                'type' : 'POST', //the way you want to send data to your URL
                                'data' : {'academic_year':academic_year,'type':'course','school_id':school_id},
                                'success':function (str) {
                                // alert(str);
                                  $("#course_id").html('<option value="0">Select Course</option>'+str);
                                }
                          });
            
            
        }  
                 
        function get_stream(academic_year,school_id,course_id){
             $.ajax({
                                'url' : base_url + 'admission/get_ajax_admission_course',
                                'type' : 'POST', //the way you want to send data to your URL
                                'data' : {'academic_year':academic_year,'type':'stream','school_id':school_id,'course_id':course_id},
                                'success':function (str) {
                                 //alert(str);
                                  $("#stream_id").html('<option value="0">Select Stream</option>'+str);
                                }
                          });
        }  
         function get_year(academic_year,school_id,course_id,stream_id){
             $.ajax({
                                'url' : base_url + 'admission/get_ajax_admission_course',
                                'type' : 'POST', //the way you want to send data to your URL
                                'data' : {'academic_year':academic_year,'type':'year','school_id':school_id,'course_id':course_id,'stream_id':stream_id},
                                'success':function (str) {
                                 //alert(str);
                                  $("#year").html('<option value="0">Select Year</option>'+str);
                                }
                          });
        } 
        
        
          $('#disbutton').on('change','#school_id', function(){
               var academic_year = $("#academic_year").val();
                var school_id = $("#school_id").val();
                if(school_id==""){
                    alert("Please select options properly..");
                }
                get_courses(academic_year,school_id);    
                    
           }) ; 
           
           $('#specificrow').on('change','#course_id', function(){
               var academic_year = $("#academic_year").val();
                var school_id = $("#school_id").val();
                var course_id = $("#course_id").val();
                 if(school_id==""||course_id==""){
                    alert("Please select options properly..");
                }
                get_stream(academic_year,school_id,course_id);    
                    
           }) ; 
            $('#specificrow').on('change','#stream_id', function(){
               var academic_year = $("#academic_year").val();
                var school_id = $("#school_id").val();
                var course_id = $("#course_id").val();
                var stream_id = $("#stream_id").val();
                if(school_id=="0"||course_id=="0"||stream_id=="0"){
                    alert("Please select options properly..");
                }
                get_year(academic_year,school_id,course_id,stream_id);    
                    
           }) ; 
 
        $('#disbutton,#specificrow').on('click','#btnView', function(){
                var academic_year = $("#academic_year").val();
                var report_type = $("#report_type").val();
                var school_id = $("#school_id").val();
                var course_id = $("#course_id").val();
                var stream_id = $("#stream_id").val();
                 var year = $("#year").val();
               // alert('test');
                if(report_type=="10"||report_type=="11"){
                    if(check_appoval_validation(school_id,course_id,stream_id,year)==false){
                        return false;
                    }
                     
                }
              
                  if(academic_year=="0" ||report_type=="0"){
                      alert("Please select All  Options ");
                  }
                  else {
                      $("#loader1").html('<div class="loader"></div>');
                      $.ajax({
                                'url' : base_url + 'admission/get_admission_statistics',
                                'type' : 'POST', //the way you want to send data to your URL
                                'data' : {'academic_year':academic_year,'report_type':report_type,'act':'view','school_id':school_id,'course_id':course_id,'stream_id':stream_id,'year':year},
                                'success':function (str) {
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
                var school_id = $("#school_id").val();
                var course_id = $("#course_id").val();
                var stream_id = $("#stream_id").val();
                 var year = $("#year").val();
                if(report_type=="10"||report_type=="11"){
                    if(check_appoval_validation(school_id,course_id,stream_id,year)==false){
                        return false;
                    }
                     
                }
     
                  if(academic_year=="" ||admission_type==""||report_type==""){
                      alert("Please select All  Options ");
                  }
             
                  else
                  {
                      // $("#loader1").html('<div class="loader"></div>');
                       $("#FrmAdm").submit();
                       
                        $.ajax({
                                 'url' : base_url + 'admission/get_admission_statistics',
                                'type' : 'POST', //the way you want to send data to your URL
                                'data' : {'academic_year':academic_year,'report_type':report_type,'admission_type':admission_type,'act':'excel'},
                                'success':function (str) {
                                 //alert(str);
                                 // $("#reportdata").html("<div class="loader"></div>");
                                 
                                }
                          });
                  }
        });
      
		
    });
	 function export_to_excel() {
    // Get the table element
    var table = document.getElementById("example");
    
    // Convert the table to a worksheet
    var workbook = XLSX.utils.table_to_book(table, { sheet: "Student Data" });

    // Export the workbook to a .xlsx file
    XLSX.writeFile(workbook, "Student_Data.xlsx");
}



</script>

<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Account</a></li>
        <li class="active">Reports<a href="#"></a></li>
    </ul>
  <form action="<?=base_url($currentModule.'get_admission_statistics');?>" method="POST" id="FrmAdm">
     
    <div class="page-header">
      <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-heading">
                            <span class="panel-title form-group"><i class="fa fa-list-alt page-header-icon h3"></i>&nbsp;&nbsp;Admission  Report</span>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                             <div class="row">
                                        <div class="col-sm-3">
                                            	<select id="academic_year" name="academic_year" class="form-control"  required>
        											<option value="">Select Academic Year</option>
													 <?php

														foreach ($exam_session as $exsession) {
															$exam_sess = $exsession['academic_year'];
															$exam_sess_val =  $exsession['session'];
															if ($exam_sess_val == $_REQUEST['academic_year']) {
																$sel = "selected";
															} else {
																$sel = '';
															}
															echo '<option value="' . $exam_sess_val. '"' . $sel . '>' .$exam_sess.'</option>';
														}
                                                     ?>
									           	</select>
                						    </div>
                						<div class="col-sm-3">
                                    	        <select id="report_type" name="report_type" class="form-control"  required>
        											<option value=""> Select Report Type</option>
        												<option value="1">Admission Summary</option>
        												<option value="2">Admission Statistics</option>
        											 	<option value="3">Category Wise Statistics</option>
        												<option value="4">City Wise List</option>
        												<option value="5">ScholorShip List</option>
        												<option value="6">Cancelled List</option>
        												<option value="7">Direct Second Year Admission list</option>
        												<option value="8">Student List</option>
        												<option value="14">Student Data</option>
        												<option value="9">Parent List</option>
        												<option value="10">Approval List</option>
        												<!--option value="11">Approval Summary</option-->
        												<option value="12">Hostel Student List</option>
        												<option value="13">Transport Student List</option>
        												<option value="15">Admission Status Report</option>
        											<!--	<option value="16">Non Reported Student List</option>
        												<option value="17">Non Reregistered Student List</option>	    -->
									           	</select>
								        </div>
								            <input type="hidden" name="act" value="excel">
								            <div id="disbutton">
										
											</div>
						     </div>	
						   	<div class="row" id="specificrow">
							    
							 </div>
                        </div>  
                   </div>
           </div>
       </div>
       </div>
        </form>
 <center><div id="loader1"></div> </center>
    </div>
    <div class="row" id="reportdata">

    </div
           

><div class="bs-example">
 
</div>

  

    
  
 
    
    


