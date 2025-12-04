<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<script>    

$(document).ready(function()
{
	$('#campus').on('change', function () {
		 campus = $(this).val();

		if (campus) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Transport/getvendorsbycampus',
				data: {campus : campus},
				success: function (html) {
					//alert(html);
					$('#emptab').hide();
					if(html !=''){
					$('#vendor').html(html);
					}else{
					  $('#vendor').html('<option value="">No vendors found</option>');  
					}
				}
			});
			} else {
				$('#vendor').html('<option value="">Select Campus first</option>');
			$('#emptab').hide();
		}
	});
	 // Num check logic
  	$('.numbersOnly').keyup(function () {
		
    if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
       this.value = this.value.replace(/[^0-9\.]/g, '');
    } 
  	});
	
	$('#vendor').on('change', function () {
		var vendor = $('#vendor').val();
		if(vendor) 
		{
			type='POST',url='<?= base_url() ?>Transport/get_buses_list_notin_vendor',datastring={vendor:vendor};
			html_content=ajaxcall(type,url,datastring);
			//alert(html_content);
			if(html_content!="")
			{
				$('#err_msg').html('');
				$('#streamlist').html(html_content);
				$('#show_list').show();
				$('#emptab').show();
			}
			else
			{
				$('#streamlist').html('');
				$('#show_list').hide();
				$('#emptab').hide();
				$('#err_msg1').hide();
				$('#err_msg').html('No Buses available for vendor '+$("#vendor option:selected").text());
				
				//$('#show_facilities').show();
			}
		}
		else 
		{
			$('#err_msg').html('Please select vendor');
			$('#streamlist').html('');
			$('#emptab').hide();
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

var numberOfChecked =0;
function form_validate(event)
{
	numberOfChecked = $('input:checkbox[class=chk]:checked').length;

	if(numberOfChecked==0)
	{
		$('#err_msg').html('Please select Bus number.');
		return false;
	}
}

function count_ischecked()
{
	numberOfChecked = $('input:checkbox[class=chk]:checked').length;
	if(numberOfChecked==0)
		$('#err_msg1').html('you have not selected any bus in buses list.');
	else
		$('#err_msg1').html('you have selected '+numberOfChecked+' buses.');
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
            <h1 class="col-xs-5 text-ctext-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Vendor Bus Mapping</h1>
			
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
                          <form id="form" name="form" action="<?=base_url($currentModule.'/add_vendor_bus_submit')?>" method="POST" onsubmit="return form_validate(event)">
                             
                            <div class="col-md-6">
							<div class="well well-sm"><b>Campus and Vendor Details:</b></div>
							
								<div class="form-group">
                                <label class="col-md-3 text-right">Campus:</label>
                                <div class="col-md-7">
                                  <select id="campus" name="campus"  class="form-control" required>
											  <option value="">Select campus</option>
											  <option value="NASHIK">Nashik</option>
											  <option value="SIJOUL">Sijoul</option>
                                    </select>
                                </div>
                                
                              </div>
							  
                              <div class="form-group">
                                <label class="col-md-3 text-right">Vendor : </label>
                                <div class="col-md-7">
                                  <select id="vendor" name="vendor" class="form-control" required>
											  <option value="">select Vendor</option>
									</select>
                                </div>
                                
                              </div>
							                               
                              <div class="form-group">
                                <div class="col-md-1"></div>
                                <div class=" col-md-4">
                                  <button type="submit" class="btn btn-primary form-control" >Allocate</button>
                                </div>
                                   <div class="col-sm-4"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule)?>/vendor_buses_list'">Cancel</button></div>
                 
                              </div>
                            </div>
                          
                        
                        <div class="col-md-6" id="emptab" style="display:none"> 
						<div class="well well-sm"><b>Buses List:</b></div>
							<div class="col-md-12"  style="overflow-x:scroll;height:300px;">
								
								 <table id='myTable' class="table table-bordered" >
									<thead>
									<tr>
												<th>#</th>
												<th>Buses Number</th>
												<!--<th>Year</th>-->
										</tr>
									</thead>
									<tbody id="streamlist">
																  
									</tbody>
								</table>  
								
							</div>
							
						</div>
						</form>
						
                      </div>
					  
					  
                    </div>
					<div class="col-md-3"></div>
					<span id="err_msg1" style="color:red;padding-left:10px;"></span>
                </div>
            </div>
        </div>    
    </div>
    
</div>

