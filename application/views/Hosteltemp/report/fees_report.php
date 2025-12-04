<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
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
     var base_url = 'https://erp.sandipuniversity.com/';

        $('#btnView').click(function(){
                var academic_year = $("#academic_year").val();
                var institute_name = $("#institute_name").val();
                var report_type = $("#report_type").val();
                var campus = $("#campus").val();
               
                
                  if(academic_year=="" ||institute_name==""||report_type==""){
                      alert("Please select All  Options ");
                  }
                  else {
                      $("#loader1").html('<div class="loader"></div>');
                      $.ajax({
                                'url' : base_url + '/account_facility/get_hostel_fees_report',
                                'type' : 'POST', //the way you want to send data to your URL
                                'data' : {'academic_year':academic_year,'campus':campus,'report_type':report_type,'institute_name':institute_name,'act':'view'},
                                'success':function (str) {
                                 //alert(str);
                                 
                                  $("#rowdata").css('display','');
                                  $("#reportdata").html(str);
                                   $("#loader1").html("");
                                }
                          });
                      
                  }
                     
                  
        });
        
        $('#btnExcel').click(function(){
			// alert('testing');
			var academic_year = $("#academic_year").val();
			var institute_name = $("#institute_name").val();
			var report_type = $("#report_type").val();
			var campus = $("#campus").val();
			if(academic_year=="" ||institute_name==""||report_type==""){
			  alert("Please select All  Options ");
			}
			else
			{
			  // $("#loader1").html('<div class="loader"></div>');
			   $("#FrmAdm").submit();
			   
				$.ajax({
					'url' : base_url + '/account_facility/get_hostel_fees_report',
					'type' : 'POST', //the way you want to send data to your URL
					'data' : {'academic_year':academic_year,'campus':campus,'report_type':report_type,'institute_name':institute_name,'act':'excel'},
					'success':function (str) {
					// alert(str);
					 // $("#reportdata").html("<div class="loader"></div>");
					 
					}
				});
			}
        });
		
		 $('#btnPdf').click(function(){
			// alert('testing');
			var academic_year = $("#academic_year").val();
			var institute_name = $("#institute_name").val();
			var report_type = $("#report_type").val();
			var campus = $("#campus").val();
			$("#act").val('pdf');
			if(academic_year=="" ||institute_name==""||report_type==""){
			  alert("Please select All  Options ");
			}
			else
			{
			  // $("#loader1").html('<div class="loader"></div>');
			   $("#FrmAdm").submit();
			   
				$.ajax({
					'url' : base_url + '/account_facility/get_hostel_fees_report',
					'type' : 'POST', //the way you want to send data to your URL
					'data' : {'academic_year':academic_year,'campus':campus,'report_type':report_type,'institute_name':institute_name,'act':'pdf'},
					'success':function (str) {
					// alert(str);
					 // $("#reportdata").html("<div class="loader"></div>");
					 
					}
				});
			}
        });
    });

</script>

<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Hostel</a></li>
        <li class="active">Reports<a href="#"></a></li>
    </ul>
  <form action="<?=base_url($currentModule.'/get_hostel_fees_report');?>" method="POST" id="FrmAdm">
     
    <div class="page-header">
      <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-heading">
                            <span class="panel-title form-group"><i class="fa fa-list-alt page-header-icon h3"></i>&nbsp;&nbsp;Hostel Fees Report</span>
                    </div>
                    <div class="panel-body">
                             <div class="row">
                                   <div class="form-group">
                                        <div class="col-sm-2">
                                            	<select id="academic_year" name="academic_year" class="form-control"  required>
        											<option value="">Select Academic Year</option>
														<option value="2019">2019-20</option>
        												<option value="2018">2018-19</option>
        												<option value="2017">2017-18</option>
        													<option value="2016">2016-17</option>
									           	</select>
                						    </div>
                					
                						    <div class="col-sm-2">
                                            	<select id="campus" name="campus" class="form-control" required>
        											<option value="">Select Campus</option>
        											
        											   <?php
					          
   		$exp = explode("_",$_SESSION['name']);

	
            if($exp[1]=="nashik")
        {
 
					          ?>
					    	<option value="NASHIK">NASHIK</option>
					  <?php
 }
  elseif($exp[1]=="sijoul")
  {
					  ?>
					<option value="SIJOUL">SIJOUL</option>
					  <?php
  }
  else
  {
					  ?>
		<option value="ALL">ALL</option>
        												<option value="NASHIK">NASHIK</option>
        												
        												<option value="SIJOUL">SIJOUL</option>
					  <?php
  }
					  ?>
        											
									           	</select>
                						    </div>
                                        <div class="col-sm-2">
                                    	        <select id="institute_name" name="institute_name" class="form-control"  required>
        											 <option value="" > Select Institute Type</option>
        											 <?php
        											 	
            if($exp[1]=="nashik")
        {
 
					          ?>
							  <option value="All">All</option>
					    	<option value="SU">Sandip University Nashik</option>
								<option value="SU-PROV">SU-PROV</option>
								<option value="SITRC">SF-SITRC</option>
								<option value="SIEM">SF-SIEM</option>
								<option value="SIPS">SF-SIPS</option>
								<option value="SP">SF-SP</option>
								<option value="SIP">SF-SIP</option>
								<option value="MBA">SF-MBA</option>
								<option value="SGS">GLOBAL SCHOOL</option>
					  <?php
 }
  elseif($exp[1]=="sijoul")
  {
					  ?>
					 <!-- <option value="All">All Hostel</option>-->
					 <option value="All">All</option>
					<option value="SRP">SRP</option>
					<option value="SSJPITI">SSJPITI</option>
					<option value="SU-SIJOUL">SU-SIJOUL</option>
					<option value="SNJCOE">SNJCOE</option>
					  <?php
  }
  else
  {
					  ?>
					     <option value="All">All Hostel</option>   
						<option value="SU">Sandip University Nashik</option>
						<option value="SU-PROV">SU-PROV</option>
						<option value="SITRC">SF-SITRC</option>
						<option value="SIEM">SF-SIEM</option>
						<option value="SIPS">SF-SIPS</option>
						<option value="SP">SF-SP</option>
						<option value="SIP">SF-SIP</option>
						<option value="MBA">SF-MBA</option>
						<option value="JrCollege">GLOBAL SCHOOL</option>
							<option value="SRP">SRP</option><option value="SSJPITI">SSJPITI</option><option value="SU-SIJOUL">SU-SIJOUL</option>
							<option value="SNJCOE">SNJCOE</option>
					  <?php
  }
  ?>
        											 
									           	</select>
								            </div>
                						<div class="col-sm-2">
                                    	        <select id="report_type" name="report_type" class="form-control"  required>
        											<option value=""> Select Report Type</option>
        												<option value="1">Fees Details</option>
        											 	<option value="2">Student Wise Fees</option>
        												<option value="3">Institute Statistics</option>
        												<option value="4">Fees Outstanding</option>
        												<option value="5">Hostel Summary</option>
        												<option value="6">Refund Details</option>	    
									           	</select>
								            </div>
								            <input type="hidden" name="act" id="act">
								        <div class="col-sm-1">
										<a class="btn btn-primary btn-labeled" id="btnView" >view</a>
										
										</div>
								      
						  
						  <div class="btn-group col-sm-1">
							<a class="btn btn-primary btn-labeled" id="btnExcel" >Excel</a>&nbsp;&nbsp;&nbsp;
						  </div>
							<div class="btn-group col-sm-2">
							<a class="btn btn-primary btn-labeled" id="btnPdf" >PDF</a>	
						  </div>	       
								        
								          </form>
								        
								        
								    </div>
							    </div>
		         
                    </div>  
                             
                   </div><center>
                  <div id="loader12"> </div></center>
           </div>
       </div>
 <center><div id="loader1"></div> </center>
    </div>
    <div class="row" id="reportdata">

    </div
           

<div class="bs-example">
 <div id="myModal" class="modal fade modal-fullscreen">
        <div class="modal-dialog">
            <div class="modal-content">
            </div>
        </div>
    </div>
</div>

  
<script>
  $(document).ready(function (){
      
      $("#campus").on('change', function (e){
          var dat =''
         if($("#campus").val() =="SIJOUL")
         {
			 //<option value="All">All Hostel</option>
             dat ='<option value="All">All</option><option value="SRP">SRP</option><option value="SSJPITI">SSJPITI</option><option value="SU-SIJOUL">SU-SIJOUL</option><option value="SNJCOE">SNJCOE</option>';
         }
          if($("#campus").val() =="NASHIK")
         {//<option value="All">All Hostel</option>
    dat =' <option value="All">All</option><option value="SU">Sandip University Nashik</option><option value="SU-PROV">SU-PROV</option><option value="SITRC">SF-SITRC</option><option value="SIEM">SF-SIEM</option><option value="SIPS">SF-SIPS</option><option value="SP">SF-SP</option><option value="SIP">SF-SIP</option><option value="MBA">SF-MBA</option><option value="SGS">GLOBAL SCHOOL</option>';
         }
         
                 if($("#campus").val() =="ALL")
         {
    dat ='<option value="All">All Hostel</option><option value="SU">Sandip University Nashik</option><option value="SU-PROV">SU-PROV</option><option value="SITRC">SF-SITRC</option><option value="SIEM">SF-SIEM</option><option value="SIPS">SF-SIPS</option><option value="SP">SF-SP</option><option value="MBA">SF-MBA</option><option value="SIP">SF-SIP</option><option value="SGS">GLOBAL SCHOOL</option><option value="SRP">SRP</option><option value="SSJPITI">SSJPITI</option><option value="SU-SIJOUL">SU-SIJOUL</option><option value="SNJCOE">SNJCOE</option>';
         }
         
         
         $("#institute_name").html(dat);
          
      });
$(document).on('hidden.bs.modal', function (e) {
    $(e.target).removeData('bs.modal');
});

   // $('#myModal').fullscreen();
   
  });
</script>

    
  
 
    
    


