<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>

<script>    
	 $(document).ready(function(){

    var exam_session=$("#exam_session").val();

      if (exam_session) {
      $.ajax({
        type: 'POST',
        url: '<?= base_url() ?>Examination/load_examsess_schools_exceptall',
        data: 'exam_session=' + exam_session,
        success: function (html) {
          //alert(html);
          $('#school_code').html(html);
        }
      });
    } else {
      $('#school_code').html('<option value="">Select exam session first</option>');
    }
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

      $('#exam_session').on('change', function () { 
    var exam_session = $(this).val();
    if (exam_session) {
      $.ajax({
        type: 'POST',
        url: '<?= base_url() ?>Examination/load_examsess_schools',
        data: 'exam_session=' + exam_session,
        success: function (html) {
          //alert(html);
          $('#school_code').html(html);
        }
      });
    } else {
      $('#school_code').html('<option value="">Select exam session first</option>');
    }
  });     

  $('#sbutton').click(function(){
            
      
      var base_url = '<?=base_url();?>';
      // alert(type);
      var school_code = $("#school_code").val(); 
      var exam_session = $("#exam_session").val(); 
       exam_session = exam_session.trim();
      if(exam_session=='')
      {
        alert("Please Select Exam-Session");
          return false;
      }
      school_code = school_code.trim();
       if(school_code=='' )
      {
          alert("Please select school");
          return false;
      }

      $.ajax({
          'url' : base_url + '/Examination/get_malpractice_list_data',
          'type' : 'POST', //the way you want to send data to your URL
          'data' : {'school_code':school_code,'exam_session':exam_session},
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
	$title='MC';
}	
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Examination</a></li>
        <li class="active"><a href="#">Malpractice-Notice</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-12 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;<?=$title?> </h1>
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
                       <span class="panel-title"><i class="panel-title-icon fa fa-fire text-danger"></i>Malpractice-Notice<!--  <?=$exam[0]['exam_month']?>-<?=$exam[0]['exam_year']?> --></span>
			    		</div>
			    		<div class="panel-body">
						<br>
						<!--<form id="form1" name="form1" enctype="multipart/form-data" action="<?=base_url($currentModule.'/search_student')?>" method="POST">-->
                        <div class="row" style="<?=$dispay?>">
					
		
              <div class="form-group">
             
                <div class="col-sm-3">
                <select name="exam_session" id="exam_session" class="form-control" required>
                <option value="">Select Exam Session</option>
                               
                <?php
                foreach($exam_session as $exsession){
                  $exam_sess_val = $exsession['exam_month'] .'-'.$exsession['exam_year'] .'-'.$exsession['exam_id'];                  $exam_sess = $exsession['exam_month'] .'-'.$exsession['exam_year'];
                  if($exam_sess_val == $_REQUEST['exam_session']){
                    $sel = "selected";
                  } else{
                   $sel = "selected";
                  }
                  echo '<option value="' . $exam_sess_val. '"' . $sel . '>' .$exam_sess.'</option>';
                }
                ?>
                  
                </select> 
                </div>
                 <div class="col-sm-3">
                                <select name="school_code" id="school_code" class="form-control" required>
                                 <option value="">Select</option>
                                 
                                 </select>
                              </div>
            <div class="col-sm-2"><button class="btn btn-primary form-control" id="sbutton" type="button" >Search</button> </div>
             
              </div>
        
					  </div>
                   <div class="form-group">
                    
            
          </div>

					 <!-- </form>-->
                </div>

                
                    <div class="table-info" id="stddata" style="margin-left: 10px;">    
                 
                </div>
          
            </div>    
        </div>
    </div>
</div>
</div>
</div>