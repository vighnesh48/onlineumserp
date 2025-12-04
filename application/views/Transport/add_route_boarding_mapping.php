<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<script>    
 $(document).ready(function()
    {
        $('#form').bootstrapValidator
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
                campus:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select campus'
                      },
                      required: 
                      {
                       message: 'Please select campus'
                      }
                     
                    }
                },
				rname:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please Enter Route Name'
                      },
                      required: 
                      {
                       message: 'Please Enter Route Name'
                      }
                     
                    }
                },
               rcode:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please Enter Route Code'
                      },
                      required: 
                      {
                       message: 'Please Enter Route Code'
                      }
                     
                    }
                }
            }       
        })
		

	 // Num check logic
  	$('.numbersOnly').keyup(function () {
		alert('tyfty');
    if (this.value != this.value.replace(/[^0-9]/g, '')) {
       this.value = this.value.replace(/[^0-9]/g, '');
    } 
  	});
	
	$('#campus').on('change', function () {
		var campus = $(this).val();
//alert(campus);
		if (campus) {
	
			
			type='POST',url='<?= base_url() ?>Transport/getboardingsbycampus',datastring={campus:campus};
			html=ajaxcall(type,url,datastring);
			//alert(html);
			if(html !='')
			{
				$('#err_msg5').html('');
			$('#boardinglist').html(html);
			$('#myTable').show();
			}else{
			  $('#err_msg5').html('No Boarding Point found for '+campus+' campus'); 
			  $('#myTable').hide();
			}
		} 
		else 
		{
			$('#err_msg5').html('');
			//$('#route').html('<option value="">Select Campus first</option>');
			$('#boardinglist').html('');
			$('#myTable').hide();
		}
	});
});
	
function ajaxcall(type,url,datastring)
{  
	var res;
	$.ajax({
		type:type,
		url:url,
		data:datastring,
		cache:false,
		async:false,
		success: function(result)
	 {
	  res=result;	 
	 }
	});
	return res; 
}

var numberOfChecked =0,status=0,err_status=0,error_status=0,exist_status=0;
function form_validate(event)
{
	numberOfChecked = $('input:checkbox[class=chk]:checked').length;

	if(numberOfChecked==0)
	{
		$('#err_msg1').html('Please select atleast one Boarding Point.');
		err_status=1;
	}
	else
		{$('#err_msg1').html("");err_status=0;}
	
	if(checkDuplicates())
	{
	 $('#err_msg5').html('Has duplication route order');
	 error_status=1;
	}
	else
		{$('#err_msg5').html("");error_status=0;}
	
	 //capacity
	//$('input[type="text"]:enabled').filter(function(){return $(this).val()=="";}).length;

	var leng=$('input[name="capacity[]"]').length;
//alert(leng);
	var j=0;
	for (i=0;i<leng;i++)
	{
		capacity=$('input[id="capacity'+i+'"]:enabled').val();
		
		//capacity=$('#capacity'+i).val();
		//console.log('#capacity'+i+'===='+capacity);
		if(capacity=='')
		{
			status=1;$('#err_msg4').html('Please fill all checked route order fields.');j++;
		}
		else
			{$('#err_msg4').html("");status=0;}
		
	}
	//alert(j+'||'+err_status+'||'+error_status);
	if(j>0 || err_status==1||error_status==1)
	{
		return false;
	}
//else{return true;}
	if(exist_status==1)
	{ return false;}
}

function checkDuplicates() 
{
	// get all input elements
	var $elems = $('.givenclass');

	// we store the inputs value inside this array
	var values = [];
	values.length=0;
	//alert(values.length);
	// return this
	var isDuplicated = false;
	// loop through elements
	$elems.each(function () {
	//If value is empty then move to the next iteration.
	if(!this.value) return true;
	//If the stored array has this value, break from the each method
	if(values.indexOf(this.value) !== -1) {
		$(this).css("border-color", "red");
	   isDuplicated = true;
	   //return false;
	 }
	 else
		$(this).css("border-color", "");
	// store the value
	values.push(this.value);
	});   

	return isDuplicated;     
}

function count_ischecked(id)
{
	var val=id.split("_");
	
	if ($('input:checkbox[id='+id+']').is(':checked')) 
	{
		$('#capacity'+val[1]).prop('disabled', false);
	}
	else
	{
		$('#capacity'+val[1]).val('');
		$('#capacity'+val[1]).prop('disabled', true);
	}
	
	numberOfChecked = $('input:checkbox[class=chk]:checked').length;
	if(numberOfChecked==0)
		$('#err_msg1').html('You have not selected any Boarding Point in the list.');
	else
	{
		$('#err_msg1').html('You have selected '+numberOfChecked+' Boarding Points.');
		$(':input[type="submit"]').prop('disabled', false);
	}
}

function only_number(id)
{
	var r_no=$('#'+id).val();
	r_no = r_no.replace(/[^0-9]/g, '');
	$('#'+id).val(r_no);
	$(':input[type="submit"]').prop('disabled', false);return true;
}

function check_route_exists()
{
	
	var campus = $('#campus').val();
	var rname=$('#rname').val();
	var rcode=$('#rcode').val();
	$('#err_msg').html('');
	$.ajax({
			type: 'POST',
			url: '<?= base_url() ?>Transport/check_route_exists',
			data: {rname:rname,campus:campus,rcode:rcode},
			success: function (html) {
				console.log(html);
				if(html>0)
				{$('#err_msg1').html("Entered route name is already there.");
			exist_status=1;}
			else
				{$('#err_msg1').html("");exist_status=0;}
			}
	});
}
</script>
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>

<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="<?=base_url($currentModule)?>">Transport</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-5 text-ctext-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Add Route - Boarding Points</h1>
			
        </div>

        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                   
				   <div class="panel-heading">
                        <span class="panel-title">Enter Details</span><span id="err_msg" style="color:red;padding-left:50px;"></span>
						
			<span id="flash-messages" style="color:Green;padding-left:50px;">
				 <?php if(!empty($this->session->flashdata('message1'))){ echo $this->session->flashdata('message1'); } ?>
			</span>
			<span id="flash-messages" style="color:red;padding-left:50px;">
			 <?php if(!empty($this->session->flashdata('message2'))){ echo $this->session->flashdata('message2'); } ?>
			</span>
					</div>
					
                    <div class="panel-body">
							<div class="portlet-body form">
                          <form id="form" name="form" action="<?=base_url($currentModule.'/add_route_boarding_mapping_submit')?>" method="POST" onsubmit="return form_validate(event)">
                             
                            <div class="row">
											
							  <div class="form-group">
                                <label class="col-md-2">Campus:</label>
                                <div class="col-md-2">
                                  <select id="campus" name="campus" onchange="check_route_exists()" class="form-control" required>
											  <option value="">Select campus</option>
											   <?php //echo "state".$state;exit();
                                        if(!empty($campus)){
                                            foreach($campus as $campusname){
                                                ?>
                                              <option value="<?=$campusname['campus_name']?>"><?=$campusname['campus_name']?></option>  
                                            <?php 
                                                
                                            }
                                        }
                                      ?>
                                    </select>
                                </div>
                               
                              </div>
								
								 <div class="form-group">
                                    <label class="col-sm-2">Route Name <?=$astrik?></label>                                    
                                    <div class="col-sm-2">
                                        <input type="text" id="rname" name="rname" onchange="check_route_exists()" class="form-control alphaonly" />
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('rname');?></span></div>
                                </div>
                                
								<div class="form-group">
                                    <label class="col-sm-2"> Route Code <?=$astrik?></label>                                    
                                    <div class="col-sm-2">
                                        <input type="text" id="rcode" name="rcode" onchange="check_route_exists()" class="form-control alphanum" />
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('rcode');?></span></div>
                                </div>
							  							  
                              <div class="form-group">
                                <div class="col-md-6" >
								
								 <table id='myTable' class="table table-bordered" style="height:400px;">
									<thead>
									<tr>
												<th>#</th>
												<th>Boarding Point</th>
												<th>Route Order</th>
										</tr>
									</thead>
									<tbody id="boardinglist">
										 <?php 
											if(!empty($boarding_details)){
												$j=1;
												foreach($boarding_details as $val){
													echo "<tr >";
													echo "<td><input name=\"boarding_list[]\" id='check_".$j."' onclick=\"count_ischecked(this.id)\" value='".$val['board_id']."' class = \"chk\" type='checkbox' ></td>";
													echo "<td>".$val['boarding_point']."</td>";
													echo "<td> <input type=\"text\" id=\"capacity".$j."\" name=\"capacity[]\" class=\"givenclass form-control \" onkeyup=\"only_number(this.id)\" style=\"width:80px;\" disabled required/> </td>";
													//echo "<td>".$_POST['year']."</td>";
													echo "</tr>";
													$j++;
												}
											}
									  ?>						  
									</tbody>
								</table>  
								<div class="row">
								<h4 id="err_msg1" style="color:red;padding-left:50px;"></h4>
								<h4 id="err_msg2" style="color:red;padding-left:50px;"></h4>
								<h4 id="err_msg3" style="color:red;padding-left:50px;"></h4>
								<h4 id="err_msg4" style="color:red;padding-left:50px;"></h4>
								<h4 id="err_msg5" style="color:red;padding-left:50px;"></h4>
								</div>
							</div>
                              </div>
							                               
                              <div class="form-group">
                                <div class="col-md-1"></div>
                                <div class=" col-md-2">
                                  <button type="submit" class="btn btn-primary form-control" >Allocate</button>
                                </div>
                                   <div class="col-sm-2"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule)?>/route_master'">Cancel</button></div>
                 
                              </div>
                            </div>
                          
                        
                        
						</form>
						
                      </div>
					  
					  
                    </div>
					<div class="col-md-3"></div>
					
                </div>
            </div>
        </div>    
    </div>
    
</div>

