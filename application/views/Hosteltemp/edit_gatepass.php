<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>

<script>
var type='<?=$student_list['type']?>';
var fdate='<?=$student_list['from_date']?>';
var tdate='<?=$student_list['to_date']?>';
var reason='<?=$student_list['purpose']?>';
var err_status=0;
$(document).ready(function()
{
	$("#"+type).prop("checked", true);
	$('#doc-sub-datepicker21').val(fdate);
	$('#doc-sub-datepicker23').val(tdate);
	$('#doc-sub-datepicker20').val(fdate);
	$('#hgp_id').val('<?=$this->uri->segment(3)?>');
	
	$('#reason').val(reason);
	
	if (type == 'CITY') 
	{
		$('#dateforhome').hide();
		$('#dateforcity').show();
	}
	else
	{
		//alert("home");
		$('#dateforhome').show();
		$('#dateforcity').hide();
	}
	
	
	$('input[type=radio][name=goingto]').change(function() {
		//document.getElementById("cancelform").reset();
		/* $('#doc-sub-datepicker20').val('');
		$('#doc-sub-datepicker21').val('');
		$('#doc-sub-datepicker23').val('');
		 */
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
	$('#doc-sub-datepicker23').datepicker( {format: 'yyyy-mm-dd',autoclose: true,startDate: '2m',endDate: '+60d'});	
	
	$('#doc-sub-datepicker20')
	   .datepicker({
		   autoclose: true,
		   todayHighlight: true,
		   format: 'yyyy/mm/dd'
	   })
	   .on('changeDate', function (e) {
		   var hgp_id = $("#hgp_id").val();
			
			var type = $("input[name='goingto']:checked").val();
			//alert(type);
			//var type=$("#type").val();
			var fdate='',tdate='';
			
			fdate = $("#doc-sub-datepicker20").val();
			tdate = $("#doc-sub-datepicker20").val();
				//alert("city");
			
			//alert(student_id+'=='+enrollment_no+'=='+organisation+'=='+type+'=='+fdate+'=='+tdate);
			//alert("cdwhwehjgs");
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Hostel/edit_check_gatepass_exists',
				data: { hgp_id: hgp_id,type:type,fdate:fdate,tdate:tdate},
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
		   var hgp_id = $("#hgp_id").val();
			
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
				url: '<?= base_url() ?>Hostel/edit_check_gatepass_exists',
				data: { hgp_id: hgp_id,type:type,fdate:fdate,tdate:tdate},
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
		   var hgp_id = $("#hgp_id").val();
			
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
				url: '<?= base_url() ?>Hostel/edit_check_gatepass_exists',
				data: { hgp_id: hgp_id,type:type,fdate:fdate,tdate:tdate},
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
		   $('#cancelform').bootstrapValidator('revalidateField', 'tdate');
	   });
	
	$("#ccancel").click(function(){
		//$("#cancel_div").hide();
		window.location='<?=base_url($currentModule."/gatepass_list")?>';
    });
	
});

function validate_form(events)
{ 
	if(err_status==1)
	{		
		$('#cancellation_err').html('Today, Already gatepass request is added for this student!');
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
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Edit Gate Pass </h1>
			
			<div class="col-xs-12 col-sm-8">
                <div class="row"> 
					   <hr class="visible-xs no-grid-gutter-h">
                    
                    <!--<div class="pull-right col-xs-12 col-sm-auto"><a style="width: 100%;" class="btn btn-primary btn-labeled" href="<?=base_url($currentModule."/add")?>"><span class="btn-label icon fa fa-plus"></span>Add </a></div>        -->                
                    <div class="visible-xs clearfix form-group-margin"></div>
                    
                    
                   
                </div>
            </div>
			
			<span id="flash-messages" style="color:Green;padding-left:50px;">
						 <?php if(!empty($this->session->flashdata('message1'))){ echo $this->session->flashdata('message1'); } ?></span>
					<span id="flash-messages" style="color:red;padding-left:50px;">
						 <?php if(!empty($this->session->flashdata('message2'))){ echo $this->session->flashdata('message2'); } ?></span>

        </div>
       
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                <div class="panel-heading">
                        <span class="panel-title">Student Details</span>
                        
                </div>
				
                <div class="panel-body" style="overflow-x:scroll;height:900px;">
			
	
<?php //var_dump($student_list);?>
						
						<table class="table table-bordered">
						<tr>
						  <th width="18%">PRN :</th>
						  <td><?=$student_list['stud_prn']?></td> 
						  <th width="18%">Organisation :</th>
						  <td><?=$student_list['stud_org']?></td>
						</tr>
						<!--<tr>
						  
						  <th width="18%">Institute :</th>
						  <td><?=$student_list['school_name']?></td>
						</tr>
						<tr>
						  <th width="18%">Mobile :</th>
						  <td><?=$student_list['mobile']?></td>
						  <th width="18%">Email :</th>
						  <td><?=$student_list['email']?></td>
						</tr>
						<tr>
						  <th width="18%">Course :</th>
						  <td><?=$student_list['course_name']?></td>
						  <th width="18%">Current Year(Semester) :</th>
						  <td><?=$student_list['current_year']?>(<?=$student_list['current_semester']?>)</td>
						</tr>
						<tr>
						  <th width="18%">Academic Year:</th>
						  <td><?=$student_list['academic_year']?></td>
						  <th width="18%">Admission Year:</th>
						  <td><?=$student_list['admission_session']?></td>
						</tr>
						<tr>
						<th width="18%">Hostel</th>
						<td><?=$student_list['hostel_code']?> / <?=($student_list['floor_no']=='0')?'Ground':$student_list['floor_no']?> / <?=$student_list['room_no']?></td>
						</tr>-->
						
						</table>
						
					<!--<div class="row ">
							
						<div class="col-sm-12">
							<div class="col-sm-8"></div>
							<div class="col-sm-3">
							<a style="width: 100%;" class="btn btn-primary btn-labeled" href="<?=site_url()?>Hostel/view_std_payment/<?=$student_list['enrollment_no']?>/<?=$student_list['stud_id']?>/<?=$student_list['organisation']?>">View Payment Details </a>
							</div>
							
							
							<div class="col-sm-3">
							<a class="btn btn-primary btn-labeled" style="display:none;" id="deallocate"  title="Click here to De-allocate Room">De-allocate</a>	
							</div>	
							
						</div>
					</div>
					</br>-->
						
		
                
					</br>
					<div class="row " id="cancel_div">
						<div class="col-sm-12">
							<div class="panel">
								<div class="panel-heading">
										<span class="panel-title">Edit Gate Pass Details</span>
										<span id="cancellation_err" style="padding-left:30px;color:red;"><span>
								</div>
								
								<div class="panel-body">
								<form name="cancelform" id="cancelform" action="<?=base_url($currentModule.'/edit_gatepass_submit')?>" method="POST" onsubmit="return validate_form(event)">
								
								<input type="hidden" id="hgp_id" name="hgp_id" />
								<input type="hidden" id="org" name="org" />
								<!-- <input type="hidden" id="sf_id" name="sf_id" />-->
								
									<div class="form-group">
										<label class="col-sm-2">Going to: <?=$astrik?></label>
										<div class="col-sm-6 ">
										<input type="radio" id="CITY" name="goingto" class="form-check-input" value="city" checked/>
										<label for="city"> City</label>
										<input type="radio" id="HOME" name="goingto" value="home" class="form-check-input" />
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
									<button class="btn btn-primary form-control" id="csubmit" type="submit" >Update</button>
									</div>
									<div class="col-sm-2">
									
									<button class="btn btn-primary form-control" id="ccancel" type="reset" >Cancel</button>
									<!--<a class="btn btn-primary btn-labeled" id="csubmit" >Submit</a>	
									<a class="btn btn-primary btn-labeled" id="ccancel" >Cancel</a>	-->
									</div>
									</div>
									</form>
								</div>
							</div>
						</div>
					</div>
					
                   
            </div>
            </div>    
        </div>
    </div>
</div>
                    
