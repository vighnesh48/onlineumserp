<style>
input[type=file]::file-selector-button {
  border: 2px solid #6c5ce7;
  padding: .2em .4em;
  border-radius: .2em;
  background-color: #a29bfe;
  transition: 1s;
}

.form-control {
    height: auto;
}
input[type=file]::file-selector-button:hover {
  background-color: #81ecec;
  border: 2px solid #00cec9;
}</style>

<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Masters</a></li>
        <li class="active"><a href="#">Upload Student Data</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon font-16 text-purple"></i>&nbsp;&nbsp;Upload Student Data</h1>
            
        </div>
        <div class="row ">
            <div class="col-sm-12">&nbsp;</div>
        </div>

		<div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                <div class="panel-heading panel-info">
                      <h1> Student Details</h1>
                       <!--  <div class="holder"></div> -->
                </div>
                <div class="panel-body">








<form class="form-horizontal" action="<?= base_url($currentModule . '/upload_excel_student_data') ?>" method="post" name="upload_excel" enctype="multipart/form-data">
   <fieldset>
      <!-- Form Name -->
     
      <!-- File Button --
      <div class="form-group">
         <label class="col-md-4 control-label" for="filebutton">Select School:</label>
         <div class="col-md-4">
            <select id="courses" class="form-control" name="courses" >
               <option value=''>Select School *</option>
               <?php
                  for($i=0;$i<count($school_list);$i++){
                  $selCond = '';
                  echo "<option ".$selCond."value='".$school_list[$i]['school_id']."'>".$school_list[$i]['school_name']."</option>"; 
                  }?>
            </select>
         </div>
      </div>
     <div class="form-group">
         <label class="col-md-4 control-label" for="filebutton">Select Course:</label>
		 <div class="col-md-4">
            <select name="" id="specialisation1" name="specialisation1" class="form-control" >
               <option value="">Select Course *</option>
            </select>
          </div>
      </div>
  -->
      <div class="form-group">
         <label class="col-md-4  control-label" for="filebutton">Select File:</label>
         <div class="col-md-4">
            <input type="file" class="form-control" name="file" id="file" class="input-large">
         </div>
      </div>
      <!-- Button -->
      <div class="form-group">
         <div class="col-md-12 text-center">
            <button type="submit" id="submit" name="Import" class="btn btn-primary button-loading" data-loading-text="Loading...">Submit</button>
			<!--<p style="margin-top:20px"><span style="color:red;">*</span><b> Kindly Provide Secondary Student Data in Mention Format. Click Here to Download Excel Format  <a href="https://sandipuniversity.com/ic_erp/student-data.xlsx" target="_blank"><i class="fa fa-file-excel-o" style="font-size:30px;color:green"></i></a> </b></p>
			
			<p style="margin-top:0px"><span style="color:red;">*</span><b>State and City Mapping of India. Click Here to Download Excel Format  <a href="https://sandipuniversity.com/ic_erp/states_and_cities_of_india-2022-23.xlsx" target="_blank"><i class="fa fa-file-excel-o" style="font-size:30px;color:green"></i></a> </b></p>
			
		<p style="margin-top:20px"><span style="color:red;">*</span><b> Kindly Provide Primary Digital Student Data in Mention Format. Click Here to Download Excel Format  <a href="https://sandipuniversity.com/ic_erp/student-data_digital.xlsx" target="_blank"><i class="fa fa-file-excel-o" style="font-size:30px;color:green"></i></a> </b></p>
    -->
         </div>
     
		 
      </div>
	
   </fieldset>
</form>



</div>
</div>
</div>
</div>

</div>
<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>				
<script>
   $(document).ready(function() {
   
    $("#courses").on("change", function() {
    
     var courses = $(this).val();
     var thisid = $(this).attr('id');
     //var ue = '<?=$basepath?>api/api.php';
     //alert(ue);
     //alert("test");
     var data = {
      courses: courses,
      action: 'getCourses'
     };
     $.ajax({
      type: "POST",
      url:  "<?php echo base_url('students/get_courses'); ?>",
      data: data,
      dataType: "html",
      crossDomain: true,
      cache: false,
      crossDomain: true,
      success: function(data) {
       $("#specialisation1").html(data);
       return false;
      },
      error: function(data) {
       alert("Page Or Folder Not Created..!!");
      }
     });
    });
   }); 
   
    
</script>