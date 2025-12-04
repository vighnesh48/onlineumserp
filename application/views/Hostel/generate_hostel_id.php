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

	$('#org').on('change', function () {
		var	campus = $(this).val();
		//check_student_exists();
		//alert(college);
		if (campus) {
			$.ajax({
						type: 'POST',
						url: '<?= base_url() ?>Hostel/get_institutes_by_campus',
						data: 'campus=' + campus,
						success: function (html) {
							//alert(html);
							$('#college_name').html(html);
						}
			});
		} else {
			$('#college_name').html('<option value="">Select Organisation </option>');
		}
	});
	
$('#sbutton').click(function(){
	
 // alert("hi");
	var base_url = '<?=base_url();?>';
	// alert(type);
	var prn = $("#prn").val();
	var org = $("#org").val();
	var acyear = $("#acyear").val();
	var college_name= $("#college_name").val();
	
	$("#arg_org").val(org);
	$("#arg_acyear").val(acyear);
	$("#arg_institute").val(college_name);
	if(org=='')
	{
		alert("Please Select Organisation");
		return false;
	}

	$.ajax({
		'url' : base_url + '/Hostel/get_hstudents_data',
		'type' : 'POST', //the way you want to send data to your URL
		'data' : {'prn':prn,'org':org,'acyear':acyear,'institute':college_name},
		'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
			var container = $('#stddata'); //jquery selector (get element by id)
			if(data!='<span style=\"color:red;\">Records Not Found Please change search criteria and try again</span>'){
				$('#table2excel').show();
				container.html(data);
				$('#report').attr('href','<?=base_url()?>Hostel/download_idcard_pdf/'+acyear+'/'+org+'/'+college_name+'/'+prn);
				$('#excel').show();
			}
			 else
			 {
				 container.html(data);
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
		alert('arr=='+temp.join(","));
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
        <li class="active"><a href="<?=base_url($currentModule)?>">Hostel Students</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-5 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Generate Hostel Id Card</h1>
         
        </div>

        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">

				<div class="panel-heading">
						 <div class="row">
					  <div class="col-sm-3 "><select class="form-control" name="acyear" id="acyear">
						<option value="">Academic Year</option>
                                           <?php //echo "state".$state;exit();
										if(!empty($academic_details)){
											foreach($academic_details as $academic){
												$arr=explode("-",$academic['academic_year']);
												$ac_year=$arr[0];
												if($academic['status']=='Y')
												{
												?>
											  <option selected value="<?=$ac_year?>"><?=$academic['academic_year']?></option>  
											<?php 
												}else{
												?>
												<option value="<?=$ac_year?>"><?=$academic['academic_year']?></option> 
												<?php
												}
												
											}
										}
									  ?>
					</select></div>
					  <div class="col-sm-3">
					           <select class="form-control" name="org" id="org">
							   <option value="">Organisation</option>
					          <?php
					          
   		$exp = explode("_",$_SESSION['name']);

		     if($exp[1]=="sijoul")
        {
              $where.=" AND campus_name='SIJOUL'";
        }
        
            if($exp[1]=="nashik")
        {
 
					          ?>
					      <option value="SU">Sandip University</option>
					  <option value="SF">Sandip Foundation</option>
					  <?php
 }
  elseif($exp[1]=="sijoul")
  {
					  ?>
					  <option value="SF-SIJOUL">Sandip Foundation Sijoul</option>
					  <?php
  }
  else
  {
					  ?>
		      <option value="SU">Sandip University</option>
					  <option value="SF">Sandip Foundation</option>
				  <option value="SF-SIJOUL">Sandip Foundation Sijoul</option>
					  <?php
  }
					  ?>
					  </select>
					      
					      
					    <!--  <select class="form-control" name="org" id="org"><option value="SU">Sandip University</option>
					  <option value="SF">Sandip Foundation</option></select>-->
					  
					  
					  </div>
                      <div class="col-sm-3">
					  <select class="form-control" name="college_name" id="college_name" required>
						  <option value="">institute</option>
						  
					  </select>
					  </div>
                      <!--<div class="col-sm-2">
					  <input type="text" class="form-control" name="prn" id="prn" placeholder="Enter Student PRN No."></div>-->
					   
                      <div class="col-sm-2"><button class="btn btn-primary form-control" id="sbutton" type="button" >Search</button></div>
					 
					 <!-- </form>-->
					</div>
				</div>
			    <div class="panel-body">
					 <div class="row">
					   
					   <div class="col-sm-3"></div>
					   <div class="col-sm-6">
					   <?php 
					   echo "<span style='color:red;padding-left:110px;'>".@$this->session->flashdata('message1')."</span>";
					   ?>
					   </div>
				                    
                      </div>	
					<form name="form" id="form" method="post" action="<?=base_url()?>Hostel/download_idcard_pdf">	
					
					<input type="hidden" name="arg_prn" id="arg_prn">
					<input type="hidden" name="arg_institute" id="arg_institute">
					<input type="hidden" name="arg_org" id="arg_org">
					<input type="hidden" name="arg_acyear" id="arg_acyear">
					
                    <table class="table table-bordered  table-info" id="table2excel" style="display:none;">
						<thead>
							<tr style="">
							<th class="noExl"><input type="checkbox" name="ckbCheckAll" id="ckbCheckAll"></th>
								 <th>Sr No</th>
								  <th>Organisation</th>
								  <th>Institute</th>
									 <th>Student PRN</th>
									<!-- <th class="noExl">Photo</th>-->
									<th width="250">Name</th>
									<th>Stream </th>
									
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