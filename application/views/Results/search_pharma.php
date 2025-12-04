<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>

<script>    
	 $(document).ready(function(){
      var roleid= '<?=$this->session->userdata('role_id')?>';
      var username= '<?=$this->session->userdata('name')?>';
     // alert(prn_s);
     var stud =0;
      if(roleid =='4'){
          $("#prn").val(username);
          $("#prn").prop('readonly',true);
         var stud =1;
      }else{
          $("#prn").val('');  
          $("#prn").prop('readonly',false); 
      }     

  $('#sbutton').click(function(){
            
   // alert("hi");
      var base_url = '<?=base_url();?>';
      // alert(type);
      var prn = $("#prn").val(); 
      prn = prn.trim();
       if(prn=='' )
      {
          alert("Please enter the PRN");
          return false;
      }

      $.ajax({
          'url' : base_url + 'Results/calculate_gpa_single_pharma',
          'type' : 'POST', //the way you want to send data to your URL
          'data' : {'prn':prn},
          'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
              //var container = $('#stddata'); //jquery selector (get element by id)
              if(data){
                  
              //  alert(data);
                  alert("GPA Genrated Successfully");
                  //$("#"+type).val('');
                  //container.html(data);
				  window.location.reload();
                  	return false;
              }
                return false;
          }
      });
  });
  if(stud==1){
        $("#sbutton").trigger("click");
    }
});
            
</script>
<?php

    $astrik='<sup class="redasterik" style="color:red">*</sup>';
    if($this->session->userdata('role_id')==4){
    $dispay="display:none;";
   
    }else{
       $dispay="display:blank;";
    }  
if($exam[0]['exam_type'] =='Regular'){
	$title ='Exam';
}else{
	$title='Special Supplementary Examinations';
}	
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Examination</a></li>
        <li class="active"><a href="#">Form</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-12 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>GPA Genration of Student</h1>
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
                       <span class="panel-title"><i class="panel-title-icon fa fa-fire text-danger"></i></span>
			    		</div>
			    		<div class="panel-body">
						<br>
						<!--<form id="form1" name="form1" enctype="multipart/form-data" action="<?=base_url($currentModule.'/search_student')?>" method="POST">-->
                        <div class="row" style="<?=$dispay?>">
					   <div class="form-group">
					   <div class="col-sm-1 "></div>
					   <label class="col-sm-2">Student PRN</label>
                      <div class="col-sm-3"><input type="text" class="form-control" name="prn" id="prn" placeholder="Enter PRN No."></div>
					  <div class="col-sm-2"><button class="btn btn-primary form-control" id="sbutton" type="button" >Genrate GPA</button> </div>
					  </div>
					 <!-- </form>-->
                </div>
                
                    
          
            </div>    
        </div>
    </div>
</div>
</div>
</div>