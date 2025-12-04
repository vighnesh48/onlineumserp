<?php $bucketname = "erp-asset"; ?>

<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>

<script>
var enroll='<?=$this->uri->segment(3)?>';
var org='<?=$this->uri->segment(5)?>';
var academic_year='<?=$this->uri->segment(6)?>';
var sf_id='<?=$student_list['sf_id']?>';
var err_status=0,error_status=0;

var curr_year = ["","First", "Second", "Third", "Fourth"];
$(document).ready(function(){
    $('#sbutton').click(function()
	{
		// alert("hi");
		var base_url = '<?=base_url();?>';
		// alert(type);
		var prn = $("#prn").val();
		var ac_year = $("#ac_year").val();
		$("#academic").val(ac_year);
		var imageData = '';
		if(prn=='' )
		{
			$('#err_msg').html("Please enter PRN Number.");
			return false;
		}
        else
		{  
			$.ajax({
				'url' : base_url + 'Hostel/gatepass_students_data',
				'type' : 'POST', //the way you want to send data to your URL
				'data' : {'enrollment_no':prn,'ac_year':ac_year},
				'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
					//var container = $('#stddata'); //jquery selector (get element by id)
					//alert(data);
					if(data != "{\"std_gatepass_details\":null}")
					{
						$('#err_msg').html('');
						$('#stddata').show();
						var array=JSON.parse(data);
						
						$('#prnno').html(array.std_gatepass_details.enrollment_no);
						$('#enroll').val(array.std_gatepass_details.enrollment_no);
						$('#student_id').val(array.std_gatepass_details.stud_id);
						$('#std_name').html(array.std_gatepass_details.first_name+' '+array.std_gatepass_details.middle_name+' '+array.std_gatepass_details.last_name);
						$('#organisation').html(array.std_gatepass_details.organisation);
						var imurl ='';
						if(array.std_gatepass_details.organisation=='SU')
						{
							//imurl ='<img src="<?=base_url('uploads/student_photo')?>/'+array.std_gatepass_details.enrollment_no+'.jpg" alt="" width="80" height="80">';
							var url = '<?= site_url() ?>Upload/getImageInfo/'+array.std_gatepass_details.enrollment_no+'.jpg?b_name=<?=$bucketname ?>';
							$.ajax({url: url, dataType: 'json', async: false,
								success: function(response){ imageData = response.imageData;
							}});
							var imurl ='<img src="'+imageData+'" alt="" width="80" height="80">';
						}
						else
						{
							imurl ='<img src="<?=base_url('assets/images')?>/nopic.jpg" alt="" width="80" height="80">';
						}
						//$('#pphoto').html(imurl);
						
						$('#orgs').val(array.std_gatepass_details.organisation);
						$('#stream').html(array.std_gatepass_details.stream_name);
						$('#allocated_id').val(array.std_gatepass_details.allocated_id);
						$('#hostel_code').val(array.std_gatepass_details.hostel_code);
						$('#institute').html(array.std_gatepass_details.school_name);
						$('#mobile1').html(array.std_gatepass_details.mobile);
						$('#mobile2').html(array.std_gatepass_details.mobile);
						$('#email').html(array.std_gatepass_details.email);
						$('#course').html(array.std_gatepass_details.course_name);
						
						$('#current_year').html(array.std_gatepass_details.current_year);
						$('#academic_year').html(array.std_gatepass_details.academic_year);
						$('#admission_year').html(array.std_gatepass_details.admission_session);
						var floor='';
						if(array.std_gatepass_details.floor_no==0)
						floor='G';
						else	
						floor=array.std_gatepass_details.floor_no;

						$('#hostel').html(array.std_gatepass_details.hostel_code);
						$('#floor_no').html(floor+' / '+array.std_gatepass_details.room_no);
							
					}
					else
					{
						$('#stddata').hide();
						$('#err_msg').html('This student has no hostel facility for the selected academic year');
						//return false;
					}
				}
			});
		}
    });
});

$(document).ready(function()
{
	$('#enroll').val(enroll);
	$('#org').val(org);
	$('#sf_id').val(sf_id);
	
        $('#cancelform').bootstrapValidator
        ({  
            message: 'This value is not valid',
            group: 'form-group',
            feedbackIcons: 
            {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: 
            {
				
				reason:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'reason should not be empty'
                      }
                    }
                }
			}
			
		}); 
	
	$('#doc-sub-datepicker20').datepicker( {format: 'yyyy-mm-dd',autoclose: true,startDate: '1m',endDate: '+20d'});			
	$('#doc-sub-datepicker21').datepicker( {format: 'yyyy-mm-dd',autoclose: true,startDate: '1m',endDate: '+10d'});	
	$('#doc-sub-datepicker23').datepicker( {format: 'yyyy-mm-dd',autoclose: true,endDate: '+60d'});	
	
	$('#doc-sub-datepicker20')
	   .datepicker({
		   autoclose: true,
		   todayHighlight: true,
		   format: 'yyyy/mm/dd'
	   })
	   .on('changeDate', function (e) {
		   var student_id = $("#student_id").val();
			var enrollment_no = $("#enroll").val();
			var organisation = $("#orgs").val();
			var type = $("input[name='goingto']:checked").val();
			//alert(type);
			//var type=$("#type").val();
			var fdate='',tdate='';
			fdate = $("#doc-sub-datepicker20").val();
			tdate = $("#doc-sub-datepicker20").val();

			//alert(student_id+'=='+enrollment_no+'=='+organisation+'=='+type+'=='+fdate+'=='+tdate);
			//alert("cdwhwehjgs");
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Hostel/check_gatepass_exists',
				data: { student_id: student_id,enrollment_no:enrollment_no,organisation:organisation,type:type,fdate:fdate,tdate:tdate},
				success: function (html) {
					//alert(html);
					if(html>0)
						err_status=1;
					else
					{
						err_status=0;
						$('#cancellation_err').html('');
					}
				}
			});
		   // Revalidate the date field
		   $('#cancelform').bootstrapValidator('revalidateField', 'date');
	   }); 
	
	$('#doc-sub-datepicker21')
	   .datepicker({
		   autoclose: true,
		   todayHighlight: true,
		   format: 'yyyy/mm/dd'
	   })
	   .on('changeDate', function (e) {
		   var startDate = new Date(e.date.valueOf());
		//$('#doc-sub-datepicker23').datepicker('setStartDate', startDate);
		$('#doc-sub-datepicker23').datepicker( {format: 'yyyy-mm-dd',autoclose: true,setStartDate:startDate,endDate: '+60d'});
		   var student_id = $("#student_id").val();
			var enrollment_no = $("#enroll").val();
			var organisation = $("#orgs").val();
			var type = $("input[name='goingto']:checked").val();
			//alert(type);
			//var type=$("#type").val();
			var fdate='',tdate='';
			if (type == 'city') 
			{
				fdate = $("#doc-sub-datepicker20").val();
				tdate = $("#doc-sub-datepicker20").val();
				//alert("city");
			}
			else
			{
				fdate = $("#doc-sub-datepicker21").val();
				tdate = $("#doc-sub-datepicker23").val();
				//alert("home");
			}
			
			
			//alert(student_id+'=='+enrollment_no+'=='+organisation+'=='+type+'=='+fdate+'=='+tdate);
			//alert("cdwhwehjgs");
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Hostel/check_gatepass_exists',
				data: { student_id: student_id,enrollment_no:enrollment_no,organisation:organisation,type:type,fdate:fdate,tdate:tdate},
				success: function (html) {
					//alert(html);
					if(html>0)
						err_status=1;
					else
					{
						err_status=0;
						$('#cancellation_err').html('');
					}
				}
			});
		   // Revalidate the date field
		   $('#cancelform').bootstrapValidator('revalidateField', 'fdate');
		   
	   });
			   
	$('#doc-sub-datepicker23')
	   .datepicker({
		   autoclose: true,
		   todayHighlight: true,
		   format: 'yyyy/mm/dd'
	   })
	   .on('changeDate', function (e) {
		    var student_id = $("#student_id").val();
			var enrollment_no = $("#enroll").val();
			var organisation = $("#orgs").val();
			var type = $("input[name='goingto']:checked").val();
			//alert(type);
			//var type=$("#type").val();
			var fdate='',tdate='';
			if (type == 'city') 
			{
				fdate = $("#doc-sub-datepicker20").val();
				tdate = $("#doc-sub-datepicker20").val();
				//alert("city");
			}
			else
			{
				fdate = $("#doc-sub-datepicker21").val();
				tdate = $("#doc-sub-datepicker23").val();
				//alert("home");
			}
			//alert(student_id+'=='+enrollment_no+'=='+organisation+'=='+type+'=='+fdate+'=='+tdate);
			//alert("cdwhwehjgs");
			
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Hostel/check_gatepass_exists',
				data: { student_id: student_id,enrollment_no:enrollment_no,organisation:organisation,type:type,fdate:fdate,tdate:tdate},
				success: function (html) {
					//alert(html);
					if(html>0)
						err_status=1;
					else
					{
						err_status=0;
						$('#cancellation_err').html('');
					}
				}
			});
			
			if ((Date.parse(tdate) < Date.parse(fdate))) 
			{
				error_status=1;
			}
			else
				error_status=0;
		   // Revalidate the date field
		   $('#cancelform').bootstrapValidator('revalidateField', 'tdate');
	   });
	
	$("#ccancel").click(function(){
		//$("#cancel_div").hide();
		document.getElementById("cancelform").reset();
    });
	
    $('input[type=radio][name=goingto]').change(function() {
		//document.getElementById("cancelform").reset();
		$('#doc-sub-datepicker20').val('');
		$('#doc-sub-datepicker21').val('');
		$('#doc-sub-datepicker23').val('');
		
        if (this.value == 'city') {
            $('#dateforhome').hide();
			$('#dateforcity').show();
        }
        else if (this.value == 'home') {
            //alert("home");
			$('#dateforhome').show();
			$('#dateforcity').hide();
        }
    });

	  //called when key is pressed in textbox
  $("#prn").keypress(function (e) {
     //if the letter is not digit then display error and don't type anything
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        //display error message
        $("#err_msg").html("Enter Only Digits").show();
               return false;
    }
   });
	
});


function validate_form(events)
{ 
	if(error_status==1)
	{
		$('#cancellation_err').html('To date should be greater than From date.');
		return false;
	}
	if(err_status==1)
	{		
		$('#cancellation_err').html('Today, Already gatepass request is added for this student');
		return false;
	}
}
</script>

<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Masters</a></li>
        <li class="active"><a href="#">Hostel </a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-5 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;GatePass Application Form</h1>
			
			<div class="col-xs-12 col-sm-7">
                <span id="flash-messages" style="color:Green;padding-left:50px;">
						 <?php if(!empty($this->session->flashdata('message1'))){ echo $this->session->flashdata('message1'); } ?></span>
					<span id="flash-messages" style="color:red;padding-left:50px;">
						 <?php if(!empty($this->session->flashdata('message2'))){ echo $this->session->flashdata('message2'); } ?></span>
            </div>
			
			

        </div>
       
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                <div class="panel-heading">
				<div class="row">
                     <!--<label class="col-sm-2">	Enter Student PRN/Id:</label>	-->  
					   <div class="col-sm-3">
					   <input type="text" class="form-control" name="prn" id="prn" placeholder="Enter PRN No.">
					   
					   <?php //echo "state".$state;exit();
						if(!empty($academic_details)){
							foreach($academic_details as $academic){
								$arr=explode("-",$academic['academic_year']);
								$ac_year=$arr[0];
								if($academic['status']=='Y')
								{
								?>
								<input type="hidden" class="form-control" name="ac_year" id="ac_year" value="<?=$ac_year?>">
							<?php 
								}
								
							}
						}
					  ?>
					   
					   </div>
                      <div class="col-sm-2">
					  <button class="btn btn-primary form-control" id="sbutton" type="button" >Search</button>
					  </div>
                    </div>
                </div>
				
                <div class="panel-body" style="overflow-x:scroll;height:600px;">
				<span id="err_msg" style="color:red;"></span>
				<!--<span id="stddata"></span>-->
				<div id="stddata" style="display:none;">
				<input type="hidden" name="hidacyear" id="hidacyear" value="<?=$student_list['academic_year']?>">
				<input type="hidden" name="hidfacid" id="hidfacid" value="1">
				<input type="hidden" name="cyear" id="cyear" value="<?=$student_list['current_year']?>">
				<input type="hidden" name="stud_id" id="stud_id" value="<?=$student_list['stud_id']?>">
				<input type="hidden" name="fmid" id="fmid" value="">

				<div class="panel panel-primary">
										<div class="panel-heading" style="height: 40px;">
												
									<span class="pull-left" ><b>PRN : </b><span id="prnno" name="prnno"></span></span>
									<span class="panel-title pull-right" style="color:white;"><b>Name : </b><span id="std_name" name="std_name"></span>
												</span>
									<!-- -->
										</div>
							
							 
										<div class="panel-body">
											<div class="table-info">  
												<div class="row">
												    	<div class="col-sm-10">
															<table class="table table-bordered">
															
															<tr>
															<th scope="col">Course :</th>
															  <td><span id="course"></span></td>
															<th scope="col">Stream :</th>
															  <td><span id="stream"></span></td>
															</tr>
															
															 <tr>
															  <th scope="col">Institute :</th>
															  <td><span id="organisation"></span> - 
															  <span id="institute"></span></td>
															  <th scope="col">Current Year :</th>
															  <td><span id="current_year"></span></td>
															</tr>   
															
															<tr id="div1">
															  <th scope="col">Hostel :</th>
															  <td><span id="hostel"></span> / <span id="floor_no"></span></td>
															  <th scope="col">Mobile:</th>
															  <td><span id="mobile1"></span></td>
															  </tr>
															
															<!--
															<tr>
															  
															  <th scope="col">Mobile 2:</th>
															  <td><span id="mobile2"></span></td>
															</tr>-->
															
															  
															
															</table>
											
											
													</div>
														<div class="col-sm-2"><span id="pphoto">
													
														 </span>
														 </div>  

													
												</div>
											
										
											</div>

				
					
					<form name="cancelform" id="cancelform" action="<?=base_url($currentModule.'/gatepass_submit')?>" method="POST" onsubmit="return validate_form(event)">
					<input type="hidden" id="academic" name="academic" value="<?=$student_list['academic_year']?>"/>
								<input type="hidden" id="student_id" name="student_id" value="<?=$student_list['stud_id']?>"/>
								<input type="hidden" id="enroll" name="enroll" />
								<input type="hidden" id="orgs" name="orgs" />
								<input type="hidden" id="allocated_id" name="allocated_id" />
								<input type="hidden" id="hostel_code" name="hostel_code" />
								
									<div class="form-group">
										<label class="col-sm-2">Going to: <?=$astrik?></label>
										<div class="col-sm-6 ">
										<input type="radio" id="city" name="goingto" class="form-check-input" value="city" checked/>
										<label for="city"> City</label>
										<input type="radio" id="home" name="goingto" value="home" class="form-check-input" />
										<label for="home"> Home</label>
										</div>                                    
										<div class="col-sm-3"><span style="color:red;"><?php echo form_error('city');?></span></div>
									</div>
									
									<div class="form-group" id="dateforcity">
									<label class="col-sm-2">Date <?=$astrik?></label>
										<div class="col-sm-3">
										  <input type="text" class="form-control" id="doc-sub-datepicker20" name="date" required readonly="true"/>
										</div>
									</div>
									
									<div class="form-group" id="dateforhome" style="display:none;">
									<label class="col-sm-2">From Date <?=$astrik?></label>
										<div class="col-sm-3">
										  <input type="text" class="form-control" id="doc-sub-datepicker21" name="fdate" required readonly="true"/>
										</div>
										
									<label class="col-sm-2">To Date <?=$astrik?></label>
										<div class="col-sm-3">
										  <input type="text" class="form-control" id="doc-sub-datepicker23" name="tdate" required readonly="true"/>
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-sm-2">Reason <?=$astrik?></label>
										<div class="col-sm-6"><input type="text" id="reason" name="reason" class="form-control" /></div>                                    
										<div class="col-sm-3"><span style="color:red;"><?php echo form_error('reason');?></span></div>
									</div>
									
									<div class="form-group">
									<div class="col-sm-2"></div>
									<div class="col-sm-2">
									<button class="btn btn-primary form-control" id="csubmit" type="submit" >Submit</button>
									</div>
									<div class="col-sm-2">
									
									<button class="btn btn-primary form-control" id="ccancel" type="reset" >Cancel</button>
									<!--<a class="btn btn-primary btn-labeled" id="csubmit" >Submit</a>	
									<a class="btn btn-primary btn-labeled" id="ccancel" >Cancel</a>	-->
									</div>
									<span class="col-sm-6" id="cancellation_err" style="color:red;"></span>
									
									</div>
									</form>
					
					<!--<div class="row " id="cancel_div">
						<div class="col-sm-12">
							<div class="panel">
								<div class="panel-heading">
										<span class="panel-title">Enter Gate Pass Details</span>
										<span id="cancellation_err" style="padding-left:30px;color:red;"><span>
								</div>
								
								<div class="panel-body">
								
								</div>
							</div>
						</div>
					</div>-->
					
                   
            </div>
			</div>
            </div>    
        </div>
    </div>
</div>
                    
