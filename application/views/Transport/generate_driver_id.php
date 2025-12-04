<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>

<script>    
    $(document).ready(function()
    {
		$('#form1').bootstrapValidator	          
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
					search_id:	
                         {
                             validators: 
                               {
                                    notEmpty: 
                                       {
                                        message: 'Please Enter Student Id,this should not be empty'
                                         }                     
                                }
						  }
				  }
		})	
	});
	
	
$(document).ready(function(){

	$("#ckbCheckAll").click(function () {
        $(".checkBoxClass").prop('checked', $(this).prop('checked'));
    });
    
    $(".checkBoxClass").change(function(){
        if (!$(this).prop("checked")){
            $("#ckbCheckAll").prop("checked",false);
        }
    });

/* 	$('#org').on('change', function () {
		var	campus = $(this).val();
		//check_student_exists();
		//alert(college);
		if (campus) {
			$.ajax({
						type: 'POST',
						url: '<?= base_url() ?>Transport_facility/get_institutes_by_campus',
						data: 'campus=' + campus,
						success: function (html) {
							//alert(html);
							$('#college_name').html(html);
						}
			});
		} else {
			$('#college_name').html('<option value="">Select Organisation </option>');
		}
	}); */
	
$('#sbutton').click(function(){

	var base_url = '<?=base_url();?>';
	var campus = $("#campus").val();
	var vendor = $("#vendor").val();
	$("#arg_vendor").val(vendor);
	$("#arg_campus").val(campus);

	$.ajax({
		'url' : base_url + '/Transport/get_drivers_details',
		'type' : 'POST', //the way you want to send data to your URL
		'data' : {'vendor':vendor,'campus':campus},
		'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
			var container = $('#stddata'); 

			if(data!='<span style="color:red;">Records Not Found Please change search criteria and try again</span>'){
				$('#err_id').html('');
				$('#table2excel').show();
				container.html(data);
				$('#report').attr('href','<?=base_url()?>Transport/download_driver_id_pdf/'+campus+'/'+vendor);
				$('#excel').show();
			}
			 else
			 {
				 $('#err_id').html(data);
				 $('#table2excel').hide();
				 $('#report').attr('href','');
				 $('#excel').hide();
			 }
		}
	});


});
});


function validate(){

	var chk_stud_checked_length = $('input[class=checkBoxClass]:checked').length;
	if(chk_stud_checked_length == 0){
		alert(chk_stud_checked_length);
	}
	else
	{
		 var temp = [];
            $.each($("input[class=checkBoxClass]:checked"), function(){            
                temp.push($(this).val());
            });
		//alert('arr=='+temp.join(","));
		$("#arg_prn").val(temp.join(","));
	}
	
}
</script>
<style type="css/text">
.table-info thead th, .table-info thead tr{background: #774545;border-color:#FFFFFF !important}
</style>
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="<?=base_url($currentModule)?>">Transport Drivers</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-5 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Generate Driver Id Card</h1>
         
        </div>

        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">

				<div class="panel-heading">
						 <div class="row">
					  <div class="col-sm-3 ">
					  <select id="campus" name="campus" class="form-control" >
									  <option value="">All campus</option>
									  <option value="NASHIK">Nashik</option>
									  <option value="SIJOUL">Sijoul</option>
							</select>
					  
					</div>
					  <div class="col-sm-3">
					    <select class="form-control" name="vendor" id="vendor">
						<option value="">All vendor</option>
				<?php 
						if(!empty($vendor_details)){
							foreach($vendor_details as $vendor){
							?>	
								<option value="<?=$vendor['vendor_id']?>"><?=$vendor['vendor_name']?></option> 
								<?php
							}
						}
					  ?>
					</select>
					      
					  </div>
                      
                      
                      <div class="col-sm-2"><button class="btn btn-primary form-control" id="sbutton" type="button" >Search</button></div>
					 
					 <!-- </form>-->
					</div>
				</div>
			    <div class="panel-body">
					 <div class="row">
					   
					   <div class="col-sm-12" id="err_id">
					   
					   </div>
				                    
                      </div>	
					<form name="form" id="form" method="post" action="<?=base_url()?>Transport/download_driver_id_pdf">	
					
					<input type="hidden" name="arg_campus" id="arg_campus">
					<input type="hidden" name="arg_vendor" id="arg_vendor">
				
                    <table class="table table-bordered  table-info" id="table2excel" style="display:none;">
						<thead>
							<tr style="">
							<th class="noExl">
							<input type="checkbox" name="ckbCheckAll" id="ckbCheckAll"></th>
								 <th>Sr No</th>
								  <th>Campus</th>
								  <th>Vendor</th>
									 <th>Name</th>
									<!-- <th class="noExl">Photo</th>-->
									<th width="250">Mobile</th>
									<th># license</th>
									
									<!--<th class="noExl">Action</th>-->
							</tr>
						</thead>
						<tbody id="stddata">
						</tbody>
					</table>
					
					
					<div id="excel" style="display:none;">
					<button type="submit" class="btn btn-primary pull-right" style="margin-right: 30px">PDF Download</button>
					</div>
					
					</form>
				</div>    
       
    </div>
</div>
</div>
</div>