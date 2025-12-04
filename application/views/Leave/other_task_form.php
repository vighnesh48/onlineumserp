<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<script src="<?=base_url()?>assets/javascripts/moment.js"></script>
<script src="<?=base_url('assets/javascripts').'/bootstrap-datetimepicker.min.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<!--<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/3.2/select2.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/3.2/select2.min.js"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.0/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.0/css/bootstrap-datepicker.css" rel="stylesheet" type="text/css" />


<script>    
    $(document).ready(function()
    {
		
		$("#division").select2();
		//$("#emp_id").select2();
		
       $('#form-forleave').bootstrapValidator
        ({  
            message: 'This value is not valid',
            group: 'form-group',
            feedbackIcons: 
            {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
			
       row: {
        valid: 'field-success',
        invalid: 'field-error'
    },
	 fields: 
            {
                academic_year:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Academic year should not be empty'
                      }
                    }
                },
				 stream_id:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Stream should not be empty'
                      }
                    }
                },
				reason:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Reason should not be empty'
                      }
                    }
                },
				semester:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Semester should not be empty'
                      }
                    }
                },
				division:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Division should not be empty'
                      }
                    }
                },
				 leave_applied_from_date:
					{
						  validators: 
								{
								  notEmpty: 
								  {
								   message: 'From Date should not be empty'
								  }
								}
				  },
				 leave_applied_to_date:
					{
						  validators: 
								{
								  notEmpty: 
								  {
								   message: 'To Date should not be empty'
								  }
								}
				  },
			},
			EM: {
                    validators: {
                        callback: {
                            message: 'Please select faculty!',
                            callback: function (value, validator, $field) {

                                var emp_id = $('#emp_id').val();
                                var isEMIDMatch = false;
                                if($("#other_task").val() !=1 && emp_id =="" ){
									return false;
								}
								else{
									return true;
								}
                                

                                
                            }
                        }
                    }
		}
		});
            /*fields: 
            {
                academic_year:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Academic year should not be empty'
                      }
                    }
                },
				 stream_id:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Stream should not be empty'
                      }
                    }
                },
				reason:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Reason should not be empty'
                      }
                    }
                },
				semester:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Semester should not be empty'
                      }
                    }
                },
				division:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Division should not be empty'
                      }
                    }
                },
				leave_duration:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Duration should not be empty'
                      }
                    }
                },
				
				
        leave_applied_from_date:
        {
              validators: 
                    {
                      notEmpty: 
                      {
                       message: 'From Date should not be empty'
                      }
                    }
      },
	 leave_applied_to_date:
        {
              validators: 
                    {
                      notEmpty: 
                      {
                       message: 'To Date should not be empty'
                      }
                    }
      },
      course_id: {
            validators: {
        notEmpty: 
                      {
                       message: 'Course should not be empty.'
                      }
               
            }
        }
            }       
        });*/
    
	
	 
		
		
 $("#dob-datepicker").datepicker({
todayBtn:  1,
autoclose: true,
format: 'dd-mm-yyyy', startDate: new Date() 
}).on('changeDate', function (selected) {
minDate = new Date(selected.date.valueOf());
$("#dob-datepicker1").val('');
$('#dob-datepicker1').datepicker('setStartDate', minDate);
});

$("#dob-datepicker1").datepicker(
{
todayBtn:  1,
autoclose: true,
format: 'dd-mm-yyyy'
});	
}); 


   





   </script>
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>

<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Leave</a></li>
        <li class="active"><a href="#">Allocate Other task to faculty</a></li>
    </ul>
    <div class="page-header">     
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Allocation For Other task to faculty</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-sm-12">&nbsp;</div>
        </div>
		  <?php 
$ci =&get_instance();
     $ci->load->model('leave_model');
	 ?>
        <div class="row ">
            <div class="col-sm-12">
      
                <div class="panel">
                    
                    <div class="panel-body">
          
             <span id="flash-messages" style="color:red;padding-left:110px;"><?php if(!empty($this->session->flashdata('message1'))){ echo "<script>alert('".$this->session->flashdata('message1')."')</script>"; } ?></span><br>
                        <div class="table-info">
                           
                         <div id="dashboard-recent" class="panel-warning"> 

             
                               <div class="panel" id="forleave">
                              <div class="panel-heading"><strong> Allocation For Other task to faculty</strong>
                                <?php $date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));?>
                         <span class="pull-right"><b>Current Date: <?=$date->format('d-m-Y H:i:s a')?>     </b>        
                         </span></div>
                              
                            
                                <div class="panel-body">
                
           <form id="form-forleave" name="form-forleave" action="<?=base_url($currentModule.'/add_task')?>" method="POST" enctype="multipart/form-data">
               
                <input class="form-control"  type="hidden" name="today_date" id="today_date" value="<?=$date->format('d-m-Y H:i:s a')?>">
                  <input type="hidden" name="ltyp" id="ltyp" value="" />    
                                <div class="form-group">
                         <label class="col-md-3 control-label"> Academic Year</label>
                        <div class="col-sm-3" >

                                <select name="academic_year" id="academic_year" class="form-control" required>
                                  <option value="">Select Academic Year</option>
                                  <?php
									foreach ($academic_year as $yr) {
										if ($yr['academic_year'].'~'.$yr['academic_session'] == $academicyear) {
											$sel = "selected";
										} else {
											$sel = '';
										}
										echo '<option value="' . $yr['academic_year'].'~'.$yr['academic_session']. '"' . $sel . '>' . $yr['academic_year'] .' ('.$yr['academic_session'].')</option>';
									}
									?>
                               </select>

                              </div>
						   <label class="col-md-3 control-label">Course</label>
						   <div class="col-sm-3" >
							<select name="course_id" id="course_id" class="form-control" required>
							  <option value="">Select Course</option>
						   </select>
						  </div> 
                       
						 
                      
                          </div>
					<div class="form-group">
					 <label class="col-md-3 control-label">Stream</label>
					<div class="col-sm-3" id="semest" >
					<select name="stream_id" id="stream_id" class="form-control" required>
					<option value="">Select Stream</option>
					</select>
					</div>
					<label class="col-md-3 control-label">Semester</label>
					<div class="col-sm-3">
					<select id="semester" name="semester" class="form-control" required>
					<option value="">Semester</option>
					</select>
					</div> 					
					</div>							  
						<div class="form-group">
						<label class="col-md-3 control-label">Division</label>
						<div class="col-sm-3">
						
									<select multiple id="division" name="division[]" class="form-control" required>
											<option value="">Division</option>
									</select>
								</div>
						<label class="col-md-3 control-label">Select Leave Duration</label>
												<div class="col-md-3" >
												 
												<select id="leave_duration" name="leave_duration"  class="form-control" required>
												<option value=""> Select Duration</option>
												<option value="full-day">Full-Day</option>
												<option value="half-day">Half-Day</option>
												</select>
												</div>
						 </div> 
						  
						<div class="form-group">
						<label class="col-md-3 control-label"> From Date</label>
						<div class="col-md-3">                            
						<input class="form-control" id="dob-datepicker" name="leave_applied_from_date" value=""  placeholder="From Date" type="text" >
						</div>
						<label class="col-md-3 control-label"> To Date</label>
						<div class="col-md-3">                          
						<input class="form-control"  id="dob-datepicker1" name="leave_applied_to_date"  value="" placeholder=" To Date" type="text" >
						
						</div>    
						</div>
                                     <div class="form-group hidden">
                   <label class="col-md-3 control-label">No Of Days.</label>
                   <div class="col-md-3">
                  <input class="form-control"  required type="text" readonly  name="no_days" id="no_days" value="">
                  </div>
                   
                  </div>
				 
				  
				  
				   <div class="form-group">
						 <label class="col-md-3 control-label"> Select Other Task</label>
                        <div class="col-sm-3" >

                                <select name="other_task" id="other_task" class="form-control" required>
                                  <option value="">Select  Task</option>
                                  <?php
									foreach ($other_task as $row) { ?>
										<option value="<?=$row->id ?>"><?= $row->task_name; ?></option>
									<?php }
									?>
                               </select>

                              </div>
					<div id="faculty_show" class="hidden">		  
					<label class="col-md-3 control-label">Faculty</label>
					<div class="col-sm-3">
					<select id="emp_id" name="emp_id"  class="form-control" required>
					<option value="">Faculty</option>
					</select>
                    </div>
					</div>
					</div>
                    <div class="form-group">
						<label class="col-md-3 control-label">Reason</label>
						<div class="col-md-9">
						<textarea  class="form-control"  style="resize:none;overflow-y:scroll;height:50px" required name="reason" placeholder="Reason " ></textarea>
                       </div>
                    </div>
                 <div class="form-group">
                    <label class="col-md-3"><u>Details of Alternative Arrangement</u></label>
               <!-- <label class="col-md-9" style="color:red;">Note:Select Department Only if you want alternate arrangement from other Department</label>   -->     
                   </div> 
                            
               
             
							  <div class="form-group">
                 
                 <div  id="levdiv" style="display:none;overflow-y:scroll;">
  <table id="emp-table" style="width:100%;" class="table table-bordered table-striped">
       
  </table>

  <script>
//$('emp-table').tableCheckbox({ /* options */ });
</script> 
</div>
                 
                                         
              </div>  
                              

                                    <div class="form-group">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-2">
                                        <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Submit  </button>                                      
                                    </div> 
                                    </div>                        
                      </div>
                 </form>              
                                </div>
                <!--Form For the Od-->                
                
                            </div>
                          </div>             
                                             
                               
                           
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </div>
</div>
<script type="text/javascript">

/*function display_duration(dr){
  var lty1 = $('#leave_type option:selected').text();
  //alert(lty1);
  $('#ltyp').val(lty1);
  var lty1s = lty1.split(' ');
  if(lty1=='ML' || lty1=='EL' || lty1s[0]=='VL' || lty1=='C-OFF'){
  $('#leave_duration').find('option[value="half-day"]').hide();
  if(lty1=='ML'){
  $('#certify').show();
  }
  }else{
  $('#leave_duration').find('option[value="half-day"]').show();
    $('#certify').hide();
  }
  if(lty1s[0] =='VL'){
    var lid= $('#leave_type').val();
    $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>leave/get_vl_details/"+lid,
        success: function(data){
        //  alert(data);          
            var exp = data.split('/');
         $('#dob-datepicker').val(exp[0]);
     $('#dob-datepicker1').val(exp[1]);
     $('#no_days').val(exp[2]);
     $('#leave_duration option[value="full-day"]').attr("selected", "selected");
      $('#leave_duration').find('option[value="half-day"]').hide();
     //$('#vid').val(exp[3]);
     
     //$('#today_date').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
     //alert('hh');
 $("#dob-datepicker").prop('readonly', true);
         $("#dob-datepicker1").prop('readonly', true);
        $("#dob-datepicker").unbind('allowInputToggle',false);
         $("#dob-datepicker1").unbind('allowInputToggle',false);
         $('#vl_leave').val('vl');
        } 
      });
  }else{
    $('#dob-datepicker').val('');
     $('#dob-datepicker1').val('');
     $('#no_days').val('');
     $("#dob-datepicker").prop('disabled', false);
     $("#dob-datepicker1").prop('disabled', false);
 $('#vl_leave').val('');
  }
}
function get_unchecked_box(eid,lt){
             
        if(lt=='OD'){
            var fd = $("#dob-datepicker2").val();
            var lt = $("#od_duration").val();
            if (lt == 'hrs') {
                var td = $("#dob-datepicker2").val();                
            } else {
                var td = $("#dob-datepicker3").val();               
            }
         }else{
       var fd = $("#dob-datepicker").val();
            var lt = $("#leave_duration").val();
            if (lt == 'half-day') {
                var td = $("#dob-datepicker").val();
            } else {
                var td = $("#dob-datepicker1").val();
            }
         }
     
  if((fd !='' || fd != null) || (td !='' || td != null)){
          date1 = fd.split('-');
                    date2 = td.split('-');
           var start = new Date(date1[2]+"-"+date1[1]+"-"+date1[0]),
           end = new Date(date2[2]+"-"+date2[1]+"-"+date2[0]),
        year = start.getFullYear(),
    month = start.getMonth(),
    day = start.getDate(),
    dates = [start];
          
      while(dates[dates.length-1] < end) {          
  dates.push(new Date(year, month, ++day));  
}
//alert(dates); 
  if(dates.length > 1){
        var dcnt = parseInt(dates.length)-1;
      }else{
        var dcnt = parseInt(dates.length);
      }
    //alert(fd);
   // alert(td);
    if(fd==td){
      $("#fromdt"+eid).find('option').remove().end();
      $("#todt"+eid).find('option').remove().end();
    }else{
      $("#fromdt"+eid).find('option').remove().end().append($('<option>', {value:'', text:'Select'}));
      $("#todt"+eid).find('option').remove().end().append($('<option>', {value:'', text:'Select'}));
      }
      for (j = 0; j < dcnt; j++) {  
      var d1 = new Date(dates[j]);      
      var mm1 = d1.getMonth();
        var mm = parseInt(mm1) + 1;
      if(mm < '10'){
        var mm = "0"+mm;
      }else{
        var mm = mm;
      }
      var dd1 = d1.getDate();
      var dd = parseInt(dd1);
      if(dd < '10'){
        dd = "0"+dd;
      }else{
        dd = dd;
      }
    
      var str = dd+"-"+mm+"-"+d1.getFullYear();


   $("#fromdt"+eid).append($('<option>', {value:str, text:str})); 
  
$("#todt"+eid).append($('<option>', {value:str, text:str}));
$('#todt'+eid+' option[value=""]').prop('selected', true);

  } 
  } 
  
}
function get_checked_box(eid,fd,td){
   if(fd==td){
     $("#fromdtdt"+eid).append($('<option>', {value:str, text:str}));
   //  $("#todt"+eid).append($('<option>', {value:fd, text:fd}));
   }else{
              var favorite = [];        
       $.each($("input[name='ch[]']:checked"), function(){       
       favorite.push($(this).val());
       });
     // alert(favorite);
  for (i = 0; i <= favorite.length; i++) {     
          var frdat = $("#fromdt"+favorite[i]+" :selected").val();
          var todat = $("#todt"+favorite[i]+" :selected").val();
       // alert(frdat);
          if((frdat !='' || frdat != null) || (todat !='' || todat != null)){
          date1 = frdat.split('-');
                    date2 = todat.split('-');
        
            var start = new Date(date1[2]+"-"+date1[1]+"-"+date1[0]),
           end = new Date(date2[2]+"-"+date2[1]+"-"+date2[0]),
        year = start.getFullYear(),
    month = start.getMonth(),
    day = start.getDate(),
    dates = [start];          
          //alert(end);          
        while(dates[dates.length-1] < end) {          
  dates.push(new Date(year, month, ++day));  
}
      if(dates.length > 1){
        var dcnt = parseInt(dates.length)-1;
      }else{
        var dcnt = parseInt(dates.length);
      }
      for (j = 0; j < dcnt; j++) {  
      var d1 = new Date(dates[j]);
      //alert(i);
      //alert(d1.getFullYear());
      var mm1 = d1.getMonth();
        var mm = parseInt(mm1) + 1;
      if(mm < '10'){
        var mm = "0"+mm;
      }else{
        var mm = mm;
      }
      var dd1 = d1.getDate();
      var dd = parseInt(dd1);
      if(dd < '10'){
        dd = "0"+dd;
      }else{
        dd = dd;
      }
    
      var str = dd+"-"+mm+"-"+d1.getFullYear();
      //alert(str);      
      $("#todt"+eid+" option[value='"+str+"']").remove();
        $("#fromdt"+eid+" option[value='"+str+"']").remove();      
      }      
    }
        
}
   }         
}
function onCheck(eid){
  //alert(dd);
  $('#btn_submit').attr('disabled',false);
  var nd = $('#no_days').val();
  var total=$('input[name="ch[]"]:checked').length;
  var arr = $('input[name="no_of_alter_days[]"]');
 // alert(arr);
    var tot=0;
    for(var i=0;i<arr.length;i++){
        if(parseInt(arr[i].value))
            tot += parseInt(arr[i].value);
    }
    //alert(tot);
  var nd1;
  if(nd == '0.5'){
   nd1 = '1';
  }else{
     nd1 = nd;
  }
  //alert(total);
  //alert(nd1);
  if(tot < nd1){
  if(total <= nd1 ){
  
  var fd= $("#dob-datepicker").val();
  var lt = $("#leave_duration").val();
  if(lt=='half-day'){
    var td= $("#dob-datepicker").val();
  }else{
var td= $("#dob-datepicker1").val();
  }
  $('#fromdt'+eid).prop("disabled", false);
  //$('#fromdt'+eid).val(fd);
  $('#todt'+eid).prop("disabled", false);
  //$('#todt'+eid).val(td);
  $('#no_of_alter_days'+eid).prop("disabled", false);
  $('#no_of_alter_days'+eid).val(nd);
  get_checked_box(eid,fd,td);
  
  
  }else{
    $('#'+eid).attr('checked', false); 
  }
}else{
    $('#'+eid).attr('checked', false); 
  }
}
function onUnCheck(eid){
  get_unchecked_box(eid,'LE');
  
 $('#no_of_alter_days' + eid).val('');  
    //$('#fromdt'+eid).find('option:selected').val(''); 
  $('#fromdt' + eid).prop("disabled", true);
    $('#todt' + eid).prop("disabled", true);
    $('#no_of_alter_days' + eid).prop("disabled", true);
  
}

function onCheckod(eid){
	 $('#btn_submit1').attr('disabled',false);
  //alert(dd);
  var total1=$('input[name="ch[]"]:checked').length;
  //alert(total);
  var nd = $('#no_hrs_forod').val();
  var lt = $("#od_duration").val();
  var arr = $('input[name="no_of_alter_od_days[]"]');
  //alert(arr);
    var tot=0;
    for(var i=0;i<arr.length;i++){
        if(parseInt(arr[i].value))
            tot += parseInt(arr[i].value);
    }
  var nd2;
  if(lt == 'hrs'){
   nd2 = '1';
  }else{
    var nd = $('#no_days_forod').val();
     nd2 = nd;
  }
  //alert(tot);
  //alert(nd2);
  if(tot < nd2){
  if(total1 <= nd2){
  var fd= $("#dob-datepicker2").val();
  var lt = $("#od_duration").val();
  if(lt=='hrs'){
    var td= $("#dob-datepicker2").val();
    var nd = $('#no_hrs_forod').val();
  }else{
var td= $("#dob-datepicker3").val();
var nd = $('#no_days_forod').val();
  }
  $('#fromdt'+eid).prop("disabled", false);
  //$('#fromdt'+eid).val(fd);
  $('#todt'+eid).prop("disabled", false);
  //$('#todt'+eid).val(td);
  $('#no_of_alter_od_days'+eid).prop("disabled", false);
 // alert(nd);
$('#no_of_alter_od_days'+eid).val(nd);
if(fd == td){
    
  }else{  
get_checked_box(eid,fd,td);
  }
}else{
    
    $('#'+eid).attr('checked', false); 
  }
  
  }else{
    
    $('#'+eid).attr('checked', false); 
  }
//$('#fromdt'+eid).val('<option>'fd);
}
function onUnCheckod(eid){
  
  get_unchecked_box(eid,'OD');
  //$('#fromdt'+eid).val('');
  //$('#todt'+eid).val('');
  $('#no_of_alter_od_days'+eid).val('');
  $('#fromdt'+eid).prop("disabled", true);  
  $('#todt'+eid).prop("disabled", true);
  $('#no_of_alter_od_days'+eid).prop("disabled", true);
  
}*/
$(document).ready(function(){
    var i=1;
  /*$( "#form-forleave" ).submit(function( event ) {
 
  // $('#form-forleave').bootstrapValidator('revalidateField', 'medical_cert');
   
    
   var altern3 = [];        
       $.each($("input[name='ch[]']:checked"), function(){       
       altern3.push($(this).val());
       });
   //  alert(altern.length);
     if(altern3.length ==0){
       //if(i=='1'){
       alert('Select Alternative Arrangement.');
   // }
    //i=i+1;
       //$('#form-forleave').bootstrapValidator('revalidateField', 'ch[]');
    return false;
    }else{
      // alert('ff1');
      
     // alert(altern3.length);
       for (i = 0; i <= altern3.length; i++) { 
//alert("kk"+favorite[i]);  
          var frdat = $("#fromdt"+altern3[i]+" option:selected").val();
          var todat = $("#todt"+altern3[i]+" option:selected").val();
      // alert(frdat);
          if((frdat =='' || frdat == null) || (todat =='' || todat == null)){
      alert('Select Alternative Dates.');
    $("#fromdt"+altern3[i]).attr("required", "true");
    $("#todt"+altern3[i]).attr("required", "true");
     return false;
      }else{
         var arr1 = $('input[name="no_of_alter_days[]"]');
  //alert(arr);
    var tot1=0;
    for(var i=0;i<arr1.length;i++){
        if(parseFloat(arr1[i].value))
         tot1 += parseFloat(arr1[i].value);
   //  alert(parseInt(arr1[i].value));
      //   tot1 += parseInt(arr1[i].value);
    }
   //alert(tot1);
      var tonody = $('#no_days').val();
     
    //alert(tonody);
        if(tot1 != tonody){
          alert('Total No of Days and Alternative No. of days must be Same.');
         $('#btn_submit').attr('disabled',true);
         return false;
        }else{          
        $('#btn_submit').attr('disabled',false);
        return true;
        }
      }   
      }   
       //return true;
     }  
});*/
/*$( "#form-forod" ).submit(function( event ) {
  
  var altern = [];        
       $.each($("input[name='ch[]']:checked"), function(){       
       altern.push($(this).val());
       });
     //alert(altern.length);
     if(altern.length == 0){
       //if(i=='1'){
       alert('Select Alternative Arrangement.');
    //}
    //i=i+1;
       //$('#form-forleave').bootstrapValidator('revalidateField', 'ch[]');
    return false;
    }else{
    //   alert(altern.length);
      for (i = 0; i <= altern.length; i++) { 
//alert("kk"+favorite[i]);  
          var frdat = $("#fromdt"+altern[i]+" option:selected").val();
          var todat = $("#todt"+altern[i]+" option:selected").val();
      // alert(frdat);
          if((frdat =='' || frdat == null) || (todat =='' || todat == null)){
      alert('Select Alternative Dates.');
    $("#fromdt"+altern[i]).attr("required", "true");
    $("#todt"+altern[i]).attr("required", "true");
     return false;
      }else{
         var arr1 = $('input[name="no_of_alter_od_days[]"]');
  //alert(arr);
    var tot1=0;
    for(var i=0;i<arr1.length;i++){
        if(parseInt(arr1[i].value))
            tot1 += parseInt(arr1[i].value);
    }
     // alert(tot1);
      var tonody = $('#no_days_forod').val();
      //alert(tonody);
        if(tot1 != tonody){
          alert('Total No of Days and Alternative No. of days must be Same.');
         $('#btn_submit1').attr('disabled',true);
         return false;
        }else{          
        $('#btn_submit1').attr('disabled',false);
        return true;
        }
      }
    }
  }
});
  $("input[name='formtype']").click(function () {
  
            if ($("#formtype_leave").is(":checked")) {
        $("#forleave").show();
        $("#leaveBal").show();
                $("#forod").hide();
            } else if($("#formtype_od").is(":checked")){
               $("#forod").show();
                $("#forleave").hide();
        $("#leaveBal").hide();
            }
        });*/
    
      
  
  /*$("#state").select2({
        placeholder: "Select State",
        allowClear: true
    });
  $("#city").select2({
        placeholder: "Select City",
        allowClear: true
    });
  $("#leave_type").select2({
        placeholder: "Select Leave Type",
        allowClear: true
    });
  $("#reporting_school").select2({
        placeholder: "Select School",
        allowClear: true
    });
  $("#reporting_dept").select2({
        placeholder: "Select Department",
        allowClear: true
    });*/
   //$('#today_date').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
  /*$('#dob-datepicker1').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
   */
   /* 7/2/2018 -- disabled current month from datepicker */
   //for leave form datepicker
   //1-8-2018 -- added ristruction to apply privious month leave
   //3-09-2019 -- deactivated past date
    var minDate='';
   var d = new Date();
   var m = d.getMonth();
   m = parseInt(m)+1;
   var y = d.getFullYear();
   $("#dob-datepicker").datepicker({
    todayBtn:  1,
    autoclose: true,
	format: 'dd-mm-yyyy', startDate: new Date() 
}).on('changeDate', function (selected) {

    minDate = new Date(selected.date.valueOf());
	
$("#dob-datepicker1").datepicker(
{
todayBtn:  1,
autoclose: true,
format: 'dd-mm-yyyy',
startDate: minDate
});	
});



//$('#dob-datepicker1').datepicker('setStartDate', "01-01-1900");
   
  /*$("#dob-datepicker").datepicker({
        // endDate: '-'+day+'d',                       
        autoclose: true,
    format: 'dd-mm-yyyy',
    startDate: new Date() 
    }).on('changeDate', function (selected) {
		$('#form-forleave').bootstrapValidator('revalidateField', 'leave_applied_from_date');
						
        //var minDate = new Date(selected.date.valueOf());
		//alert(minDate);
		//$("#datepicker").datepicker("setDate", new Date);
		//$('#dob-datepicker1').datepicker('setStartDate',minDate);
		//$('').datepicker('setStartDate', minDate);
       //$('#dob-datepicker1').datepicker('setStartDate', minDate);
    //var depid = $('#reporting_dept').val();
      
    //getTotalDays();
    //$('#form-forleave').bootstrapValidator('revalidateField', 'leave_applied_from_date');
   // $('#form-forleave').bootstrapValidator('revalidateField', 'no_days');
    });*/
  /*$("#dob-datepicker1").datepicker({ 
    //endDate: '-'+day+'d', 
      todayBtn:  1,       
        autoclose: true,
        format: 'dd-mm-yyyy',
        startDate: new Date()     
    }).on('changeDate', function (selected) {
		$('#form-forleave').bootstrapValidator('revalidateField', 'leave_applied_to_date');
           // var minDate = new Date(selected.date.valueOf());
           // $('#dob-datepicker').datepicker('setEndDate', minDate);
           // getTotalDays();
           // var depid = $('#reporting_dept').val();
      
  });*/
  
 
 /* $("#dob-datepicker2").datepicker({
     todayBtn:  1,       
        autoclose: true,
    format: 'dd-mm-yyyy',
     startDate: new Date() 
    }).on('changeDate', function (selected) {
        var minDate = new Date(selected.date.valueOf());
    $('#dob-datepicker3').datepicker('setStartDate', minDate);
  var depid = $('#reporting_dept_od').val();
      getEmp_using_deptforod(depid);
  getTotalDays1();
    });
  $("#dob-datepicker3").datepicker({      
        autoclose: true,
    format: 'dd-mm-yyyy',
    startDate: new Date()  
    }).on('changeDate', function (selected) {
            var minDate = new Date(selected.date.valueOf());
            $('#dob-datepicker2').datepicker('setEndDate', minDate);
   //   $('#form-forod').bootstrapValidator('revalidateField', 'od_applied_to_date');
            
             var depid = $('#reporting_dept_od').val();
      getEmp_using_deptforod(depid);
       getTotalDays1();
  });
  //for od hrs time picker
 /* $('#timepicker1').datetimepicker({ format:'HH:mm',stepping:5}).on("dp.change", function (e) {
           getTotalhrs();
        });
  $('#timepicker2').datetimepicker({ format:'HH:mm',stepping:5}).on("dp.change", function (e) {
           getTotalhrs();
        });*/
 
  
  
  
  // $('#datetimepicker1').datetimepicker();

  /*var content = '<tr>'+$('#eduDetTable tbody tr').html()+'</tr>';
  $("#eduDetTable").on("click","input[name='addMore']", function(e){  
  //$("input[name='addMore']").on('click',function(){   
    //var content = $(this).parent().parent('tr').clone('true');
    $(this).parent().parent('tr').after(content);   
  });
  $("#eduDetTable").on("click","input[name='remove']", function(e){ 
  //$("input[name='remove']").on('click',function(){
    var rowCount = $('#eduDetTable tbody tr').length;
    if(rowCount>1){
      $(this).parent().parent('tr').remove();
    }
  }); */
  
  
});
/* function changevisible(val){
  if(val=='half-day'){
  $("#dob-datepicker1").hide(); 
  $("#dob-for-half-day").show();    
  }else if(val=='full-day'){
  $("#dob-datepicker1").show(); 
  $("#dob-for-half-day").hide();    
  }
} */


//date check for leave duration function
/*
function checkLeaveDuration(){
  var lty = $('#leave_type option:selected').text();

  
  if($('#leave_duration').val()=='half-day'){
    
  var d1=$("#dob-datepicker").val();  
  $("#dob-datepicker1").hide();
  $("#dob-datepicker1").val('');
  $("#dob-for-half-day").show();  
  $("#dob-for-half-day").val(d1); 
  $("#dob-for-half-day").attr('readonly', 'true');
  $("#no_days").val(0.5);
  }else if($('#leave_duration').val()=='full-day'){
    $("#no_days").val('');    
  $("#dob-datepicker1").show(); 
  $("#dob-for-half-day").hide();
    $("#dob-for-half-day").val(''); 
  }
  var to_date = $("#dob-datepicker1").val();
  //alert(to_date);
  if(to_date !=""){
   // alert("inside");
  getTotalDays();
  //$('#form-forleave').bootstrapValidator('revalidateField', 'no_days');
  }
}*/
//date check for od duration function
/*
function checkOD_Duration(){
  if($('#od_duration').val()=='half-day'){
  var d1=$("#dob-datepicker2").val(); 
  $("#dob-datepicker3").hide();
    $("#dob-datepicker3").val('');  
  $("#od-for-half-day").show(); 
  $("#od-for-half-day").val(d1);  
  $("#od-for-half-day").attr('readonly', 'true');
  $("#no_days_forod").attr('required', 'true');
  $("#no_days_forod").val(0.5);
//  
  //clear timepicker values
   $('#timepicker1').val(' ');
   $('#timepicker2').val(' ');
  }else if($('#od_duration').val()=='full-day'){
    $("#no_days_forod").val('');
  $("#dob-datepicker3").show(); 
  $("#dob-datepicker3").attr('required', 'true'); 
  $("#od-for-half-day").hide();
$("#no_days_forod").attr('required', 'true'); 
  //clear timepicker values
   $('#timepicker1').val(' ');
   $('#timepicker2').val(' ');
  }
}

*/
//for leave form
/*
function getTotalDays(){
  //alert('ff');
  if($('#leave_duration').val()==''){
    alert('Please select Duration for Leave');
  }
  var lty = $('#leave_type option:selected').text();
  var spid = $('#'+lty).text();
  //alert(lty);
 
  
  if($('#leave_duration').val()=='half-day'){
    $("#no_days").val(0.5);
    $("#no_days").attr('readonly',true);  
  }else if($('#leave_duration').val()=='full-day'){
  var date1=$("#dob-datepicker").val();
  var date2=$("#dob-datepicker1").val();
  var firstValue = date1.split('-');
  var secondValue = date2.split('-');
  var firstDate=new Date();
   firstDate.setFullYear(firstValue[2],(firstValue[1] - 1 ),firstValue[0]);

 var secondDate=new Date();
 secondDate.setFullYear(secondValue[2],(secondValue[1] - 1 ),secondValue[0]);     
  if (firstDate > secondDate)
  {
    alert("From date should not be greater than To date");
  //document.getElementById('dob-datepicker').value =" "; 
  //document.getElementById('dob-datepicker1').value=" ";    
  $("#dob-datepicker1").val(''); 
  document.getElementById('no_days').value=" "; 
    date1=date2=""; 
  }
    var start = new Date(firstValue[2]+"-"+firstValue[1]+"-"+firstValue[0]),
           end = new Date(secondValue[2]+"-"+secondValue[1]+"-"+secondValue[0]),
        year = start.getFullYear(),
    month = start.getMonth(),
    day = start.getDate(),
    dates = [start];
          //alert(start); 
          //alert(end);
        while(dates[dates.length-1] < end) {
          
  dates.push(new Date(year, month, ++day));
  
}
      if(dates.length > 1){
        var timeDifferenceInDays = parseInt(dates.length)-1;
      }else{  
      var timeDifferenceInDays = dates.length;
      }

//alert(timeDifferenceInDays);

removed ml limit -- date:- 23-5-2018
else if(lty == 'ML' && timeDifferenceInDays < 3 ){
    alert('Minimum 3 leaves are allow for ML.');
     $("#dob-datepicker1").val('');
    document.getElementById('no_days').value=" ";
}



  }
   

 //$('#form-forleave').bootstrapValidator('revalidateField', 'no_days');
}*/
//for od form
/* 
function checkdh_div(val){
  if(val=='hrs'){
    $('#od-for-hrs').show();
    $('#no_hr').show();
    $("#no_hrs_forod").attr('required',true);
    $('#od-for-day').hide();
  $('#od-for-day1').hide();
    $('#no_d').hide();
    
    
  }else if(val=='full-day'){
    $('#od-for-day').show();
    $("#dob-datepicker2").attr('required',true);
    $('#no_d').show();
    $('#od-for-hrs').hide();
  $('#od-for-day1').show();
    $('#no_hr').hide();
    $("#no_hrs_forod").removeAttr('required',true);
  }else if(val=='half-day'){
    $('#od-for-day').show();
    $("#dob-datepicker2").attr('required',true);
    $('#no_d').show();
    $('#od-for-hrs').hide();
    $('#no_hr').hide();
    $("#no_hrs_forod").removeAttr('required',true);
  }
  
}


function calculateTime() {  
                       
        var valuestart1 = $('#timepicker1').val();// "8:45am";
        var valuestop1 = $('#timepicker2').val();//"8:46pm";    
  //  alert(valuestart1);
 // alert(valuestop1);
  if(valuestart1 != '' && valuestop1 !=''){
         var valuestart = moment(valuestart1, "HH:mm");
    var valuestop = moment(valuestop1, "HH:mm");   
    
        var hourStart = new Date(valuestart).getHours();
        var hourEnd = new Date(valuestop).getHours();

        var minuteStart = new Date(valuestart).getMinutes();
        var minuteEnd = new Date(valuestop).getMinutes();

        var hourDiff = hourEnd - hourStart;
        var minuteDiff = minuteEnd - minuteStart;
    
        if (minuteDiff < 0) {
            hourDiff = hourDiff - 1;
      minuteDiff=60-(-(minuteDiff));
        }
    // alert(hourDiff);
    //alert(minuteDiff); 

    if(hourDiff >= 0){
   var rn=hourDiff+'.'+minuteDiff;
 }else{
  alert('Arrival Time must be greater then Departure Time');
   var rn='';
 }
}else{
  var rn ='';
}
        return  rn;    
    }
    function getTotalhrs(){   
  //alert('gg');
    var tdiff=calculateTime();
    //alert(tdiff);
    $('#no_hrs_forod').val(tdiff);
    //$('#form-forod').bootstrapValidator('revalidateField', 'od_departure_time');
    //$('#form-forod').bootstrapValidator('revalidateField', 'od_arrival_time');
    //$('#form-forod').bootstrapValidator('revalidateField', 'no_hrs_forod');
  }


function getTotalDays1(){
  
  var date1=$("#dob-datepicker2").val();
  var date2=$("#dob-datepicker3").val();
  var firstValue = date1.split('-');
var secondValue = date2.split('-');

 var firstDate=new Date();
 firstDate.setFullYear(firstValue[2],(firstValue[1] - 1 ),firstValue[0]);

 var secondDate=new Date();
 secondDate.setFullYear(secondValue[2],(secondValue[1] - 1 ),secondValue[0]);     
  if (firstDate > secondDate)
  {
 
    alert("From date should not be greater than To date");
   // $("#dob-datepicker2").val('');
    $("#dob-datepicker3").val('');
  //document.getElementById('dob-datepicker2').value =" "; 
  //document.getElementById('dob-datepicker3').value=" ";     
  document.getElementById('no_days_forod').value=" "; 
    date1=date2=""; 
  }
    var start = new Date(firstValue[2]+"-"+firstValue[1]+"-"+firstValue[0]),
           end = new Date(secondValue[2]+"-"+secondValue[1]+"-"+secondValue[0]),
        year = start.getFullYear(),
    month = start.getMonth(),
    day = start.getDate(),
    dates = [start];
          //alert(start); 
          //alert(end);
        while(dates[dates.length-1] < end) {
          
  dates.push(new Date(year, month, ++day));
  
}
      if(dates.length > 1){
        var timeDifferenceInDays = parseInt(dates.length)-1;
      }else{  
      var timeDifferenceInDays = dates.length;
      }
  
//alert(timeDifferenceInDays);
if(timeDifferenceInDays>0){
$("#no_days_forod").val(timeDifferenceInDays);  
$("#no_days_forod").attr('readonly',true);

}
 //$('#form-forod').bootstrapValidator('revalidateField', 'applied_from_date');
 //$('#form-forod').bootstrapValidator('revalidateField', 'no_days_forod');
  //$('#form-forod').bootstrapValidator('revalidateField', 'od_departure_time');
}

function getalterdiff(id){
  //alert(id);
  id1='#fromdt'+id;
  id2='#todt'+id;
  
  var date1=$('#fromdt' +id).val();
  var date2=$('#todt' +id).val();
 var firstValue = date1.split('-');
var secondValue = date2.split('-');

 var firstDate=new Date();
 firstDate.setFullYear(firstValue[2],(firstValue[1] - 1 ),firstValue[0]);

 var secondDate=new Date();
 secondDate.setFullYear(secondValue[2],(secondValue[1] - 1 ),secondValue[0]);     
  if (firstDate > secondDate)
  {
    alert("From date should not be greater than To date");
 // $('#fromdt' +id).val('');
 $('#todt' +id).val('');  
  document.getElementById('no_of_alter_days' +id).value=" "; 
    date1=date2=""; 
  }
   var start = new Date(firstValue[2]+"-"+firstValue[1]+"-"+firstValue[0]),
           end = new Date(secondValue[2]+"-"+secondValue[1]+"-"+secondValue[0]),
        year = start.getFullYear(),
    month = start.getMonth(),
    day = start.getDate(),
    dates = [start];
          //alert(start); 
          //alert(end);
        while(dates[dates.length-1] < end) {
          
  dates.push(new Date(year, month, ++day));
  
}
      if(dates.length > 1){
        var timeDifferenceInDays = parseInt(dates.length)-1;
      }else{  
      var timeDifferenceInDays = dates.length;
      }
      
//alert(timeDifferenceInDays);
if(timeDifferenceInDays>0){
  
$("#no_of_alter_days"+id).val(timeDifferenceInDays);  //no_of_alter_days110024
}
}
function getalterdiff1(id){
  //alert(id);
  id1='#fromdt'+id;
  id2='#todt'+id;
  
  var date1=$('#fromdt' +id).val();
  var date2=$('#todt' +id).val();
var firstValue = date1.split('-');
var secondValue = date2.split('-');

 var firstDate=new Date();
 firstDate.setFullYear(firstValue[2],(firstValue[1] - 1 ),firstValue[0]);

 var secondDate=new Date();
 secondDate.setFullYear(secondValue[2],(secondValue[1] - 1 ),secondValue[0]);     
  if (firstDate > secondDate)
  {
    alert("From date should not be greater than To date");
  $('#todt' +id).val('');  
  document.getElementById('no_of_alter_days' +id).value=" "; 
    date1=date2=""; 
  }
   var start = new Date(firstValue[2]+"-"+firstValue[1]+"-"+firstValue[0]),
        end = new Date(secondValue[2]+"-"+secondValue[1]+"-"+secondValue[0]),
        year = start.getFullYear(),
    month = start.getMonth(),
    day = start.getDate(),
    dates = [start];
          //alert(start); 
          //alert(end);
        while(dates[dates.length-1] < end) {
          
  dates.push(new Date(year, month, ++day));
  
}
      if(dates.length > 1){
        var timeDifferenceInDays = parseInt(dates.length)-1;
      }else{  
      var timeDifferenceInDays = dates.length;
      }

if(timeDifferenceInDays>0){
$("#no_of_alter_od_days"+id).val(timeDifferenceInDays); //no_of_alter_days110024
}
}
 
      
function get_datet(eid,dty){
var dty = dty;
   
    if(dty=='od'){
        //alert(dty);
        getalterdiff1(eid);
    var arr1 = $('input[name="no_of_alter_od_days[]"]');
  //alert(arr);
    var tot1=0;
    for(var i=0;i<arr1.length;i++){
        if(parseInt(arr1[i].value))
            tot1 += parseInt(arr1[i].value);
    }
     // alert(tot1);
      var tonody = $('#no_days_forod').val();
    //  alert(tonody);
        if(tot1 != tonody){
          alert('Total No of Days and Alternative No. of days must be Same.');
         $('#btn_submit1').attr('disabled',true);
         return false;
        }else{          
        $('#btn_submit1').attr('disabled',false);
        return true;
        }
    }else{
    getalterdiff(eid);
    var arr1 = $('input[name="no_of_alter_days[]"]');
  //alert(arr);
    var tot1=0;
    for(var i=0;i<arr1.length;i++){
        if(parseInt(arr1[i].value))
            tot1 += parseInt(arr1[i].value);
    }
     // alert(tot1);
      var tonody = $('#no_days').val();
     // alert(tonody);
        if(tot1 != tonody){
          alert('Total No of Days and Alternative No. of days must be Same.');
         $('#btn_submit').attr('disabled',true);
         return false;
        }else{          
        $('#btn_submit').attr('disabled',false);
        return true;
        }

}        
        //   getalterdiff(eid);
      }
	  
	  
	  
	  */
	  
	  
	  
	  
	  
	  
	  $('#academic_year').on('change', function () {
			var academic_year = $(this).val();
			if (academic_year) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>timetable/load_ttcources',
					data: {academic_year:academic_year},
					success: function (html) {
						//alert(html);
						$('#course_id').html(html);
					}
				});
			} else {
				$('#course_id').html('<option value="">Select academic year first</option>');
			}
		});
		
		
			$('#course_id').on('change', function () {
			var academic_year =$("#academic_year").val();
			var course_id = $(this).val();
			if (course_id) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>Timetable/load_tt_streams',
					data: {course_id:course_id,academic_year:academic_year},
					success: function (html) {
						//alert(html);
						$('#stream_id').html(html);
					}
				});
			} else {
				$('#stream_id').html('<option value="">Select course first</option>');
			}
		});
		
		$('#stream_id').on('change', function () {
			var stream_id = $(this).val();
			var academic_year =$("#academic_year").val();
			if (stream_id) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>timetable/load_ttsemesters',
					data: {stream_id:stream_id,academic_year:academic_year},
					success: function (html) {
						//alert(html);
						$('#semester').html(html);
					}
				});
			} else {
				$('#semester').html('<option value="">Select Stream first</option>');
			}
		});
		
		$('#semester').on('change', function () {
			var semester = $(this).val();
			var stream_id =$("#stream_id").val();
			var academic_year =$("#academic_year").val();
			if (semester) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>timetable/load_ttdivision',
					data: {stream_id:stream_id,academic_year:academic_year,stream_id:stream_id, semester:semester},
					success: function (html) {
					
						$("#division").select2("val", "");
						$('#division').html(html);
						
					}
				});
			} else {
				$("#division").select2("val", "");
				$('#division').html('<option value="">Select Stream first</option>');
			}
		});
		
		$('#other_task').on('change', function () {
			var other_task = $(this).val();
			if((other_task !=1 && other_task !=3) && other_task !="" ){
			
			var semester = $("#semester").val();
			var stream_id =$("#stream_id").val();
			var academic_year =$("#academic_year").val();
			var division=$("#division").val();
			if (semester &&  stream_id && academic_year  && division) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>timetable/load_faculty_data',
					data: {stream_id:stream_id,academic_year:academic_year,other_task:other_task, semester:semester,division:division},
					success: function (html) {		
					$("#faculty_show").removeClass('hidden');
					$("#emp_id").html(html);
					
					get_employee_list_of_specific_stream_semester(stream_id,academic_year,semester);
					
					
					}
				});
			} else {
				alert("Please select above fields");
				
			}
			}
			else{
				
				$("#faculty_show").addClass('hidden');
				 $('#levdiv').css('display','none');
				
			}
			
		});
		
		function get_employee_list_of_specific_stream_semester(stream_id,academic_year,semester)
			   {
				var  from_date=$("#dob-datepicker").val();
				var  to_date=$("#dob-datepicker1").val();
				var division=$("#division").val();
				if(from_date &&  to_date && division){
					$.ajax({
							type: 'POST',
							url: '<?= base_url() ?>Admin/get_employee_list_of_specific_stream_semester',
							data: {stream_id:stream_id,academic_year:academic_year,semester:semester,from_date:from_date,to_date:to_date,division:division},
							success: function (html) {		
							  $("#emp-table").html(html);
							  $('#levdiv').css('display','block');
							  //$(".ms").select2();
					         
							}
						});
				}
				else{
				  alert("Please select above fields"); 
			   }
			   }
			   
				
</script>