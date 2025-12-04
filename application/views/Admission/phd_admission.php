<script src="<?= base_url('assets/javascripts') . '/bootstrap-datepicker.js' ?> "></script>
<link href="<?= site_url() ?>assets/css/pick.css" rel="stylesheet" type="text/css" />  
<style>
.has-error .form-control {
    border-color: #a94442;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
    box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
}

.has-error .form-control {
    border-color: #ebccd1;
    -webkit-box-shadow: none;
    box-shadow: none;
}

.has-error .form-control {
    border-color: #d38e99;
    -webkit-box-shadow: none;
    box-shadow: none;
}

.has-error .form-control {
    border-color: #a94442;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
    box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
}
.table{width:100%}

table {max-width: 100%;}
.edu-table .form-control{font-size:12px!important}
.edu-table thead tr th{font-size:13px!important}
.ecadem-table{width:110%;max-width: 110%;}
</style>
<script src="<?= site_url() ?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>

<script type="text/javascript">
<!--
function copyBilling (f) {
    //alert('hi');
    var s, i = 0;
    if(f.same.checked == true) {
    // fetch district
        var stateID = $("#lstate_id").val();
        var district_id = $("#ldistrict_id").val();
        var lcity = $("#lcity").val();
		
		if (stateID) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Ums_admission/getStatewiseDistrict',
				data: 'state_id=' + stateID,
				success: function (html) {
					//alert(html);
					$('#pdistrict_id').html(html);
					$("#pdistrict_id option[value='" + district_id + "']").attr("selected", "selected");
				}
			});
		 }else {
			$('#pdistrict_id').html('<option value="">Select state first</option>');
		}
	// fetch district
		if (district_id) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Ums_admission/getStateDwiseCity',
				data: { state_id: stateID, district_id : district_id},
				success: function (html) {
					//alert(html);
					if(html !=''){
					$('#pcity').html(html);
					$("#pcity option[value='" + lcity + "']").attr("selected", "selected");
					}else{
					  $('#pcity').html('<option value="">No city found</option>');  
					}
				}
			});
		} else {
			$('#pcity').html('<option value="">Select district first</option>');
	}

    while (s = ['address', 'state_id', 'district_id', 'city', 'pincode'][i++]) {f.elements['p' + s].value = f.elements['l' + s].value};
    }
    if(f.same.checked == false) {
    // alert(false);
    $('#pdistrict_id').html('<option value="">Select state first</option>');
    $('#pcity').html('<option value="">Select district first</option>');
    while (s = ['address', 'state_id', 'district_id', 'city', 'pincode'][i++]) {f.elements['p' + s].value ="";};
    }
    
}
// -->
</script>
<script>
$(function(){
 
    $('#txt1').keyup(function()
    {
        var yourInput = $(this).val();
        //re = /[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi;
        re = /[`~!@#$%^&*()_|+\-=?;:'",<>\{\}\[\]\\\/]/gi;
        var isSplChar = re.test(yourInput);
        if(isSplChar)
        {
            var no_spl_char = yourInput.replace(/[`~!@#$%^&*()_|+\-=?;:'",<>\{\}\[\]\\\/]/gi, '');
            $(this).val(no_spl_char);
        }
    });
    $('#txt2').keyup(function()
    {
        var yourInput = $(this).val();
        re = /[`~!@#$%^&*()_|+\-=?;:'",<>\{\}\[\]\\\/]/gi;
        var isSplChar = re.test(yourInput);
        if(isSplChar)
        {
            var no_spl_char = yourInput.replace(/[`~!@#$%^&*()_|+\-=?;:'",<>\{\}\[\]\\\/]/gi, '');
            $(this).val(no_spl_char);
        }
    });
    $('#txt3').keyup(function()
    {
        var yourInput = $(this).val();
        re = /[`~!@#$%^&*()_|+\-=?;:'",<>\{\}\[\]\\\/]/gi;
        var isSplChar = re.test(yourInput);
        if(isSplChar)
        {
            var no_spl_char = yourInput.replace(/[`~!@#$%^&*()_|+\-=?;:'",<>\{\}\[\]\\\/]/gi, '');
            $(this).val(no_spl_char);
        }
    });
    $('#txt11').keyup(function()
    {
        var yourInput = $(this).val();
        re = /[`~!@#$%^&*()_|+\-=?;:'",<>\{\}\[\]\\\/]/gi;
        var isSplChar = re.test(yourInput);
        if(isSplChar)
        {
            var no_spl_char = yourInput.replace(/[`~!@#$%^&*()_|+\-=?;:'",<>\{\}\[\]\\\/]/gi, '');
            $(this).val(no_spl_char);
        }
    });
    $('#txt12').keyup(function()
    {
        var yourInput = $(this).val();
        re = /[`~!@#$%^&*()_|+\-=?;:'",<>\{\}\[\]\\\/]/gi;
        var isSplChar = re.test(yourInput);
        if(isSplChar)
        {
            var no_spl_char = yourInput.replace(/[`~!@#$%^&*()_|+\-=?;:'",<>\{\}\[\]\\\/]/gi, '');
            $(this).val(no_spl_char);
        }
    });
    $('#txt13').keyup(function()
    {
        var yourInput = $(this).val();
        re = /[`~!@#$%^&*()_|+\-=?;:'",<>\{\}\[\]\\\/]/gi;
        var isSplChar = re.test(yourInput);
        if(isSplChar)
        {
            var no_spl_char = yourInput.replace(/[`~!@#$%^&*()_|+\-=?;:'",<>\{\}\[\]\\\/]/gi, '');
            $(this).val(no_spl_char);
        }
    });
    $('#txt21').keyup(function()
    {
        var yourInput = $(this).val();
        re = /[`~!@#$%^&*()_|+\-=?;:'",<>\{\}\[\]\\\/]/gi;
        var isSplChar = re.test(yourInput);
        if(isSplChar)
        {
            var no_spl_char = yourInput.replace(/[`~!@#$%^&*()_|+\-=?;:'",<>\{\}\[\]\\\/]/gi, '');
            $(this).val(no_spl_char);
        }
    });
    $('#txt22').keyup(function()
    {
        var yourInput = $(this).val();
        re = /[`~!@#$%^&*()_|+\-=?;:'",<>\{\}\[\]\\\/]/gi;
        var isSplChar = re.test(yourInput);
        if(isSplChar)
        {
            var no_spl_char = yourInput.replace(/[`~!@#$%^&*()_|+\-=?;:'",<>\{\}\[\]\\\/]/gi, '');
            $(this).val(no_spl_char);
        }
    });
    $('#txt23').keyup(function()
    {
        var yourInput = $(this).val();
        re = /[`~!@#$%^&*()_|+\-=?;:'",<>\{\}\[\]\\\/]/gi;
        var isSplChar = re.test(yourInput);
        if(isSplChar)
        {
            var no_spl_char = yourInput.replace(/[`~!@#$%^&*()_|+\-=?;:'",<>\{\}\[\]\\\/]/gi, '');
            $(this).val(no_spl_char);
        }
    });
    $('#txt31').keyup(function()
    {
        var yourInput = $(this).val();
        re = /[`~!@#$%^&*()_|+\-=?;:'",<>\{\}\[\]\\\/]/gi;
        var isSplChar = re.test(yourInput);
        if(isSplChar)
        {
            var no_spl_char = yourInput.replace(/[`~!@#$%^&*()_|+\-=?;:'",<>\{\}\[\]\\\/]/gi, '');
            $(this).val(no_spl_char);
        }
    });
    $('#txt32').keyup(function()
    {
        var yourInput = $(this).val();
        re = /[`~!@#$%^&*()_|+\-=?;:'",<>\{\}\[\]\\\/]/gi;
        var isSplChar = re.test(yourInput);
        if(isSplChar)
        {
            var no_spl_char = yourInput.replace(/[`~!@#$%^&*()_|+\-=?;:'",<>\{\}\[\]\\\/]/gi, '');
            $(this).val(no_spl_char);
        }
    });
    $('#txt33').keyup(function()
    {
        var yourInput = $(this).val();
        re = /[`~!@#$%^&*()_|+\-=?;:'",<>\{\}\[\]\\\/]/gi;
        var isSplChar = re.test(yourInput);
        if(isSplChar)
        {
            var no_spl_char = yourInput.replace(/[`~!@#$%^&*()_|+\-=?;:'",<>\{\}\[\]\\\/]/gi, '');
            $(this).val(no_spl_char);
        }
    });
});
function sub() {
            var txtFirstNumberValue = document.getElementById('txt1').value;
            var txtSecondNumberValue = document.getElementById('txt2').value;
            var result = parseInt(txtFirstNumberValue) - parseInt(txtSecondNumberValue);
            if (!isNaN(result)) {
                document.getElementById('txt3').value = result;
            }
        }
        function sub1() {
            var txtFirstNumberValue = document.getElementById('txt11').value;
            var txtSecondNumberValue = document.getElementById('txt12').value;
            var result1 = parseInt(txtFirstNumberValue) - parseInt(txtSecondNumberValue);
            if (!isNaN(result1)) {
                document.getElementById('txt13').value = result1;
            }
        }
        function sub2() {
            var txtFirstNumberValue = document.getElementById('txt21').value;
            var txtSecondNumberValue = document.getElementById('txt22').value;
            var result2 = parseInt(txtFirstNumberValue) - parseInt(txtSecondNumberValue);
            if (!isNaN(result2)) {
                document.getElementById('txt23').value = result2;
            }
         }
        function sub3() {
            //////////
            var fee_appli =document.getElementById('txt31').value;
            var fee_paid=document.getElementById('txt32').value;
            var total_balance=parseInt(fee_appli)-parseInt(fee_paid);
            //alert(fee_appli);alert(fee_paid);
            if (!isNaN(total_balance)) {
                document.getElementById('txt33').value = total_balance;
            }
            ///////////////////
            var txtFirstNumberValue2=document.getElementById('txt2').value;
            var txtFirstNumberValue12=document.getElementById('txt12').value;
            var txtFirstNumberValue22=document.getElementById('txt22').value;
            var totalpaid=parseInt(txtFirstNumberValue2)+parseInt(txtFirstNumberValue12)+parseInt(txtFirstNumberValue22);
            if (!isNaN(totalpaid)) {
                document.getElementById('txt32').value = totalpaid;
                 document.getElementById('paidfee').value = totalpaid;
            }
            ////////
            var txtFirstNumberValue3=document.getElementById('txt3').value
            var txtFirstNumberValue13=document.getElementById('txt13').value;
            var txtFirstNumberValue23=document.getElementById('txt23').value
            var totalbal=parseInt(txtFirstNumberValue3)+parseInt(txtFirstNumberValue13)+parseInt(txtFirstNumberValue23);
            if (!isNaN(totalbal)) {
                document.getElementById('txt33').value = totalbal;
            }
            ////////
            var txtFirstNumberValue = document.getElementById('txt31').value;
            var txtSecondNumberValue = document.getElementById('txt32').value;
            var result4 = parseInt(txtFirstNumberValue) - parseInt(txtSecondNumberValue);
            if (!isNaN(result4)) {
                document.getElementById('txt33').value = result4;
            }
         }
	 
</script>
<?php
$astrik = '<sup class="redasterik" style="color:red">*</sup>';
?>

<div id="content-wrapper">
  <ul class="breadcrumb breadcrumb-page">
    <div class="breadcrumb-label text-light-gray">You are here: </div>
    <li><a href="#">Masters</a></li>
    <li class="active"><a href="#">Admission Form</a></li>
  </ul>
  
  
  <div class="page-header">
    <div class="row">
      <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Admission Form</h1>
      <div class="col-xs-12 col-sm-8">
        <div class="row">
          <hr class="visible-xs no-grid-gutter-h">
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <div class="panel">
          <div class="panel-body">
           
                             
          <form id="form1" name="form1" action="<?= base_url($currentModule . '/ums_phdadmission_submit') ?>" method="POST" enctype="multipart/form-data" autocomplete="off">
            <div class="xtable-info"> 
              <!--<label>Note:<span>Fields marked with asterisk(<?= $astrik ?>) are mandatory to be filled.</span></label>-->
              <div id="dashboard-recent" class="panel panel-warning">
                <div class="panel-heading"> <span class="panel-title"><i class="panel-title-icon fa fa-fire text-danger"></i>Details</span>
                  <ul class="nav nav-tabs nav-tabs-xs setup-panel">
                    <li class="active"><a data-toggle="tab" href="#personal-details">1.Personal Information</a></li>
                    <li><a data-toggle="tab" href="#educational-details">2.Educational Details</a></li>
                    <li><a data-toggle="tab" href="#documents-certificates">3.Documents & Certificates</a></li>
                    <li><a data-toggle="tab" href="#references">4.References</a></li>
                    <li id="paymnt"><a data-toggle="tab" href="#payment-photo">5.Student Details & Photo</a></li>
                  </ul>
                </div>                 
                <div class="tab-content">
                  <label><span style="padding-left:10px;">Note:Fields marked with asterisk(
                    <?= $astrik ?>
                   ) are mandatory to be filled.</span></label>
                  <div class="form-group11">
                    <?php
echo "<span id='flash-messages' style='color:red;padding-left:110px;'>" . @$this->session->flashdata('message') . "</span>";
?>
                   <span id="flash-messages" style="color:red;padding-left:110px;"><?php
echo $this->session->flashdata('msg1');
?></span> <span style="color:red; padding-left:110px;"><?php
echo $this->session->flashdata('msg2');
?></span> <span style="color:red; padding-left:110px;"><?php
echo $this->session->flashdata('msg3');
?></span> <span style="color:red; padding-left:110px;"><?php
echo $this->session->flashdata('msg4');
?></span> <span style="color:red; padding-left:110px;"><?php
echo $this->session->flashdata('msg5');
?></span> </div>
                  
                  <!-- Comments widget -->                 
                  <!-- Without padding --> 
                  <!--start  of personal-details -->
  
                  <div id="personal-details" class="setup-content widget-comments panel-body tab-pane fade active in">
                   <!-- Panel padding, without vertical padding -->
                      <div class="panel">
                        <div class="panel-heading">Personal Details
                          <?= $astrik ?>
                       </div>
                        <div class="panel-body"> 

                          <div class="panel-padding no-padding-vr">
                              
                              
							      <div class="form-group">
                              <label class="col-sm-3">Academic Year <?= $astrik ?></label>
                              <div class="col-sm-3">
                               
                                      <select id="acyear" name="acyear" class="form-control"  required onchange="getad(value)">
                                <?php $number = range(2023,date("Y")); 
                                    foreach ($number as $key => $value) {
                                        if($value=='2023')
                                        {
                                            $selected='selected';
                                        }
                                        else
                                        {
                                            $selected='';
                                        }
                                        echo "<option value='$value' ".$selected." >$value</option>";
                                        # code...
                                    }

                                    ?>
                               </select>
                                </div>
							  </div>
                                  <div class="form-group">
                              <label class="col-sm-3">Admission Type <?= $astrik ?></label>
                              <div class="col-sm-3">
                                      <select id="admission_type" name="admission_type" class="form-control" required>
                                        <option value="">Select Type</option>
                                    <option value="6">Part Time</option>
                                    <option value="7">Full Time</option>
                                    <option value="8">Full Time with Fellowship</option>
                               </select>
                                </div>
                               <label class="col-sm-3">Admission Form Number </label>
                              <div class="col-sm-3">
                                <input id="sfnumber" name="sfnumber" pattern="[0-9]+" class="form-control" value="" placeholder="Admission Form Number" type="text" >
                                </div>
                              </div>
                              <div class="form-group">
                               <label class="col-sm-3">Admission Batch <?= $astrik ?></label>
                              <div class="col-sm-3">                             
                              <select id="admission_cycle" name="admission_cycle" class="form-control" >
                                <option value="">Select Type</option>
                               </select>
                                </div>
                              <label class="col-sm-3">School <?= $astrik ?></label>
                              <div class="col-sm-3" >
                                <select name="admission-school" id="admission_school" class="form-control" onchange="load_courses(this.value)" required>
                              <option value="">Select School</option>
                                  <?php
									foreach ($school_list as $schools) {
										if ($schools['school_id'] == $stream_det[0]['school_id']) {
											$sel = "selected";
										} else {
											$sel = '';
										}
										echo '<option value="' . $schools['school_id'] . '"' . $sel . '>' . $schools['school_name'] . '</option>';
									}
									?>
                               </select>
                              </div>
                              </div>
                            <div class="form-group">
                              <label class="col-sm-3">Course <?= $astrik ?></label>
                              <div class="col-sm-3" >
                                <select name="admission-course" id="admission-course" class="form-control" onchange="load_streams(this.value)" required>
                                  <option value="">Select</option>
                                  <?php
								foreach ($course_details as $course) {
									if ($course['course_id'] == $personal[0]['admission-course']) {
										$sel = "selected";
									} else {
										$sel = '';
									}
									echo '<option value="' . $course['course_id'] . '"' . $sel . '>' . $course['course_short_name'] . '</option>';
								}
								?>
                               </select>
                              </div>
                              <script>
                                     var base_url = '<?php echo site_url();?>';
                                     
                                        function load_courses(type){
                                            
                   // alert(type);
				  // $("#admission_school").val('');
	$("#admission-course").val('');
	$("#admission-branch").val('');
		
	$("#txt_acd").val('');
	$("#academic_fees_id").val('');
	$("#txt32").val('');
                   var acyear = '2021-22';
                    var year ='<?=$stud_det['admission_year'];?>';
                    $.ajax({
                    'url' : base_url + 'phd_admission/load_courses',
                    'type' : 'POST', //the way you want to send data to your URL
                    'data' : {'school' : type,'acyear':acyear,'year':year},
                    'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
                        var container = $('#admission-course'); //jquery selector (get element by id)
                        if(data){
                         //   alert(data);
                            //alert("Marks should be less than maximum marks");
                            //$("#"+type).val('');
                            container.html(data);
                        }
                    }
                });
            }
                                      function load_streams(type){
                   // alert(type);
                   var acyear = '2021-22';
                   var admission_school=$("#admission_school").val();
				   
				 //  $("#admission-course").val('');
	$("#admission-branch").val('');
		
	$("#txt_acd").val('');
	$("#academic_fees_id").val('');
	$("#txt32").val('');
                    
                $.ajax({
                    'url' : base_url + 'phd_admission/get_course_streams_yearwise',
                    'type' : 'POST', //the way you want to send data to your URL
                    'data' : {'course' : type,'acyear':acyear,'admission_school':admission_school},
                    'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
                        var container = $('#admission-branch'); //jquery selector (get element by id)
                        if(data){
                           
                         //   alert(data);
                            //alert("Marks should be less than maximum marks");
                            //$("#"+type).val('');
                            container.html(data);
                        }
                    }
                });
            }
            
                                    </script>
                              <label class="col-sm-3">Stream <?= $astrik ?></label>
                              <div class="col-sm-3"  >
                                <select name="admission-branch" id="admission-branch" class="form-control" required>
                                  <option value="">Select</option>
                                 <!--  <?php
								foreach ($branches as $branch) {
									if ($branch['branch_code'] == $personal[0]['admission-branch']) {
										$sel = "selected";
									} else {
										$sel = '';
									}
									echo '<option value="' . $branch['branch_code'] . '" ' . $sel . '>' . $branch['branch_code'] . '</option>';
								}
								?> -->
                               </select>
                              </div>
                            </div>
                           <div class="form-group">&nbsp;</div> 
                        <div class="form-group">
                        <label class="col-sm-3">Semester Fee <?= $astrik ?></label>
                        <div class="col-sm-3">
                        <input type="text" id="txt_acd" class="form-control" name="acd_totalfee" value="" readonly="readonly" required>
                        <input type="hidden" id="academic_fees_id" name="academic_fees_id" value="" readonly="" required>
					    <input type="hidden" id="txt32" name="open_bal" value="" style="width:100px" readonly="">
                                </div>
                        </div>     
                           <div class="form-group">&nbsp;</div> 
                            
                            <div class="form-group">
                              <label class="col-sm-3">Student Name <?= $astrik ?></label>
                              <div class="col-sm-3">
                                <input data-bv-field="sfname" required pattern="[a-zA-Z ]*" id="sfname" name="sfname" class="form-control" value="<?= isset($personal[0]['fname']) ? $personal[0]['fname'] : ''; ?>" placeholder="Student Name" type="text"
								onkeydown="onlyAlphabets(event)" onpaste="onlyAlphabets(event)"  onkeyup="this.value=this.value.replace(/[^A-z ]/g,'');" >
                                </div>
                                 <label class="col-sm-3">Father's/Husband Name <?= $astrik ?></label>
                              <div class="col-sm-3">
                                <input data-bv-field="sfname1" required id="sfname1" name="sfname1" class="form-control" value="<?= isset($personal[0]['sfname1']) ? $personal[0]['sfname1'] : ''; ?>" placeholder="Father Name" type="text" onkeydown="onlyAlphabets(event)" onpaste="onlyAlphabets(event)"
								onkeyup="this.value=this.value.replace(/[^A-z ]/g,'');" >
                               </div>
                            </div>
                            <div class="form-group">
                              <label class="col-sm-3">Mother Name <?= $astrik ?></label>
                              <div class="col-sm-3">
                                <input data-bv-field="sfname" id="sfname2" name="sfname2" class="form-control" required value="" placeholder="Mother Name" type="text" onkeydown="onlyAlphabets(event)" onpaste="onlyAlphabets(event)" onkeyup="this.value=this.value.replace(/[^A-z ]/g,'');" >
                                <i data-bv-icon-for="sfname" class="form-control-feedback" style="display: none; top: 0px;"></i><small data-bv-result="NOT_VALIDATED" data-bv-for="sfname" data-bv-validator="notEmpty" class="help-block" style="display: none;">First name should not be empty</small><small data-bv-result="NOT_VALIDATED" data-bv-for="sfname" data-bv-validator="regexp" class="help-block" style="display: none;">First name should be alphabate characters</small><small data-bv-result="NOT_VALIDATED" data-bv-for="sfname" data-bv-validator="stringLength" class="help-block" style="display: none;">First name should be 2-50 characters.</small> </div>
                                
                              <label class="col-sm-3">Aadhar Card No </label>
                              <div class="col-sm-3">
                                <input type="text" id="saadhar" minlength="12" maxlength="12" value="<?= isset($personal[0]['aadhar_no']) ? $personal[0]['aadhar_no'] : ''; ?>" name="saadhar" class="numbersOnly form-control" onblur="return chek_aadhar_valid(this.value)">
                            </div>
                            </div>
                            <div class="form-group">
                              <label class="col-sm-3">Date of Birth <?= $astrik ?></label>
                              <div class="col-sm-3 date" id="dob-datepicker">
                                  <div class="input-group">
                                <input type="text" id="dob" name="dob" class="form-control"  value="<?= isset($personal[0]['dob']) ? $personal[0]['dob'] : ''; ?>" placeholder="Date of Birth" required  />
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span> </div></div>
                                  <label class="col-sm-3">Place Of Birth <?= $astrik ?></label>
                               <div class="col-sm-3 ">
                             <input type="text" id="pob" name="pob" required class="form-control"  value="<?= isset($personal[0]['dob']) ? $personal[0]['dob'] : ''; ?>" placeholder="Place of Birth" onkeydown="onlyAlphabets(event)" onpaste="onlyAlphabets(event)" onkeyup="this.value=this.value.replace(/[^A-z ]/g,'');" />
                                </div>
                            </div>
                            <div class="form-group">
                              <label class="col-sm-3">Gender <?= $astrik ?></label>
                              <div class="col-md-3">
												  <select  class="form-control" name="gender" id="gender" required >
												  <option value="">Select Gender</option>
                                                   <option value="M">Male</option>
                                                    <option value="F">Female</option>
                                                     <option value="T">Transgender</option>
                                                  </select>
                                                  </div>
                              <label class="col-md-3 control-label">Blood Group:
							 </label>
        										<div class="col-md-3">
												  <select  class="form-control" name="blood_gr" id="blood_gr">
												  <option value="">Select</option>
												  <?php
													 $str=$str1=$str2=$str3=$str4=$str5=$str6=$str7=$str8=$str9=$str10=$str11=$str12="";
													if($emp[0]['blood_gr']=='A+'){
															 $str="selected";
															 }elseif($emp[0]['blood_gr']=='A-'){
															$str1="selected";	 
															 }elseif($emp[0]['blood_gr']=='A'){
															$str2="selected";	 
															 }elseif($emp[0]['blood_gr']=='B+'){
															$str3="selected";	 
															 }elseif($emp[0]['blood_gr']=='B-'){
															$str4="selected";	 
															 }elseif($emp[0]['blood_gr']=='B'){
															$str5="selected";	 
															 }elseif($emp[0]['blood_gr']=='AB+'){
															$str6="selected";	 
															 }elseif($emp[0]['blood_gr']=='AB-'){
															$str7="selected";	 
															 }elseif($emp[0]['blood_gr']=='AB'){
															$str8="selected";	 
															 }elseif($emp[0]['blood_gr']=='O+'){
															$str9="selected";	 
															 }elseif($emp[0]['blood_gr']=='O-'){
															$str10="selected";	 
															 }elseif($emp[0]['blood_gr']=='O'){
															$str11="selected";	 
															 }elseif($emp[0]['blood_gr']=='Unknown'){
															$str12="selected";	 
															 }?>
														<option <?=$str?> value="A+">A Positive</option>
														<option <?=$str1?> value="A-">A Negative</option>
														<option <?=$str2?> value="A">A Unknown</option>
														<option <?=$str3?> value="B+">B Positive</option>
														<option <?=$str4?> value="B-">B Negative</option>
														<option <?=$str5?> value="B">B Unknown</option>
														<option <?=$str6?> value="AB+">AB Positive</option>
														<option <?=$str7?> value="AB-">AB Negative</option>
														<option <?=$str8?> value="AB">AB Unknown</option>
														<option <?=$str9?> value="O+">O Positive</option>
														<option <?=$str10?> value="O-">O Negative</option>
														<option <?=$str11?> value="O">O Unknown</option>
														<option <?=$str12?> value="Unknown">Unknown</option>
													</select> 
                                                 </div>
                            </div>
                            <div class="form-group">
                              <label class="col-sm-3">Mobile <?= $astrik ?></label>
                              <div class="col-sm-3">
                                <input type="text" id="mobile" name="mobile" class="form-control numbersOnly" value="" placeholder="contact no" maxlength="10" onblur="return chek_mob_exist(this.value)" required />
                              </div>
                              <label class="col-sm-3">Email<?= $astrik ?></label>
                              <div class="col-sm-3">
                                <input type="email" id="email_id" required name="email_id" class="form-control" value="" placeholder="Email" onblur="return chek_email_exist(this.value)" />
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="col-sm-3">Nationality </label>
                              <div class="col-sm-3">
                                <input type="text" id="nationality" name="nationality" class="form-control" value="Indian" placeholder="" />
                              </div>
                              <label class="col-sm-3">Category <?= $astrik ?></label>
                              <div class="col-sm-3">
                                <select id="category" name="category" required class="form-control"  >
                                  <option value="">Select</option>
                                  <?php
									foreach ($category as $category) {
										if ($category['caste_code'] == $personal[0]['caste']) {
											$sel = "selected";
										} else {
											$sel = '';
										}
										echo '<option value="' . $category['caste_code'] . '" ' . $sel . '>' . $category['caste_name'] . '</option>';
									}
                                 ?>
                               </select>
                              </div>
                            </div>
                             <div class="form-group">  
                          <label class="col-sm-3">Sub Caste </label>
                       <div class="col-sm-3 ">
                         <input type="text" id="subcaste" name="subcaste" class="form-control"  value="" placeholder="Sub Caste" />
                                </div>
                              <label class="col-sm-3">Date of Admission <?= $astrik ?></label>
                              <div class="col-sm-3 date" id="doadd-datepicker">
                                  <div class="input-group">
                                <input type="text" id="doadd" name="doadd" class="form-control"  value="" placeholder="Date of Admission" required />
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span> </div></div>
                            </div>
                            
                            <div class="form-group">
                              <label class="col-sm-3">Religion <?= $astrik ?></label>
                              <div class="col-sm-3">
                                <select id="religion" name="religion" required class="form-control" >
                                  <option value="">Select</option>
                                  <?php
									foreach ($religion as $religion) {
										if ($religion['rel_code'] == $personal[0]['religion']) {
											$sel = "selected";
										} else {
											$sel = '';
										}
										echo '<option value="' . $religion['rel_code'] . '" ' . $sel . '>' . $religion['rel_name'] . '</option>';
									}
									?>
                               </select>
                              </div>
                              <label class="col-sm-3">OMS/MS</label>
                              <div class="col-sm-3">
                                <select id="res_state" name="res_state" class="form-control" >
                                  <option value="">Select</option>
                                   <option value="">Select</option>

                                 <option value="MS">MS</option>
                                  <option  value="OMS">OMS</option>
                                      <option  value="NRI">NRI</option>
                                          <option  value="PIO">PIO</option>
                                          <option value="FOR">FOR</option>
                                </select>
                              </div>
                            </div>
                             <div class="form-group">
                              <label class="col-sm-3">Last Institute Attended</label>
                              <div class="col-sm-3">
                                <input type="text" id="linst" name="linst" value="" placeholder="Last Institute Attended" class="form-control">
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="col-sm-2">Defence Personal</label>
                              <div class="col-sm-2">
                         <input type="checkbox" value="Y" id="defperson" name="defperson">
                              </div>
                              <label class="col-sm-2">Jammu Kashmir Migrates</label>
                              <div class="col-sm-2">
                              <input type="checkbox" value="Y" id="jk" name="jk">
                              </div>
                               <label class="col-sm-2">Weather PWD</label>
                              <div class="col-sm-2">
                               <input type="checkbox" value="Y" id="pwd" name="pwd">
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="panel">
                        <div class="panel-heading">Contact Address
                          <?= $astrik ?>
                       </div>
                        <div class="panel-body" style="font-size:12px!important">
                          <table class="table table-new">
                            <tr>
                              <!--th>Local Address</th-->
                              <th>Permanent Address</th>
                            </tr>
                              <tr>
                            <!--Permanent Address-->
                              <td width="50%">
                               <div class="form-group">
                                <label  class="col-sm-3">Address: <?=$astrik?></label>
                                <div class="col-sm-6">
                                  <textarea id="paddress" class="form-control" NAME="paddress" style="margin: 0px; width: 200px; height: 50px;" required></textarea>
                                </div>
                              </div>
                              <div class="form-group">
                                <label  class="col-sm-3">State: <?=$astrik?></label>
                                <div class="col-sm-6">
                                  <select class="form-control" name="pstate_id" id="pstate_id" required>
                                      <option value="">select State</option>
                                      <?php
                                        if(!empty($states)){
                                            foreach($states as $stat){
                                                ?>
                                              <option value="<?=$stat['state_id']?>"><?=$stat['state_name']?></option>  
                                            <?php 
                                                
                                            }
                                        }
                                      ?>
                                  </select>
                                </div>
                              </div>
                              <div class="form-group">
                                <label  class="col-sm-3">District: <?=$astrik?></label>
                                <div class="col-sm-6">
                                  <select class="form-control" name="pdistrict_id" id="pdistrict_id" required>
                                      <option value="">select District</option>
                                  </select>
                                </div>
                              </div>
                              <div class="form-group">
                                <label  class="col-sm-3">City: <?=$astrik?></label>
                                <div class="col-sm-6">
                                   <select class="form-control" name="pcity" id="pcity" required>
                                      <option value="">select City</option>
                                  </select>
                                </div>
                              </div>
                              <div class="form-group">
                                <label  class="col-sm-3">Pin Code: <?=$astrik?></label>
                                <div class="col-sm-6">
                                  <INPUT TYPE="TEXT" class="form-control numbersOnly" id="ppincode" pattern="[1-9][0-9]{5}"  name="ppincode" value="" required>
                                </div>
                              </div>
                              </td>
                              </tr>
                            
                            <?php
if ($personal[0]['same'] == "on") {
    $val = "checked";
} else {
    $val = "";
}
?>
                          </table>
                        </div>
                      </div>              
                  <div class="form-group">
                        <div class="col-sm-4"></div>


                       <div class="col-sm-2">
                          <button class="btn btn-primary nextBtn form-control" id=""  >Next</button>
                        </div>

                     </div>
                     
                    </div> 
                  
                  <div id="educational-details" class="setup-content widget-comments panel-body tab-pane fade ">
                    <h3></h3>
				
                    <input type="hidden" name="reg_id" value="<?= $this->session->userdata('student_id') ?>">
                    <input type="hidden" name="step1statusval" value="<?= $this->session->userdata('stepfirst_status') ?>">
                     
                    <div class="panel">
                      <div class="panel-heading">Academic Details
                        <?= $astrik ?>
                     </div>
                      <div class="panel-body">
                        <div class="xxpanel-padding no-padding-vr">
                          <div class="xxtable-primary">
                            <!--<div class="table-header" style="xwidth:97%!important">
                              <div class="table-caption"> Educational Background </div>
                            </div>-->
                            <div class="table-responsive" style="overflow-x:scroll">
                              <table id="eduDetTable" class="table ecadem-table table-bordered edu-table">
                                <thead>
                                  <tr>
                                    <th>Qualification</th>
                                    <th>Stream</th>
                                    <th>Specialization</th>
                                    <th>Board/University</th>
                                    <th width="11%">Passing Year</th>
                                    <th>Marks Obt.</th>
                                    <th>Marks Out of</th>
                                    <th>Percentage</th>
                                    <th>CGPA / SGPA</th>
                                    <th>Grade</th>  
                                    <th>Docs</th>
                                    <th>Action</th>
                                  </tr>
                                </thead>
                                <tbody>
                                 <tr id="firsttr">
                                    <td> <div class="form-group">
                                        <select name="exam_id[]" id="studqual_1" class="squal form-control" onchange="qualifcation(this.id)" required>
                                        <option value="">Select</option>
                                        <option value="SSC">SSC</option>
                                        <option value="HSC">HSC</option>
                                        <option value="Graduation">Graduation</option>
                                        <option value="Post Graduation">Post Graduation's</option>
                                        <option value="Diploma">Diploma</option>
                                      </select>
                                        </div>  
                                    </td>
                                    <td> 
                                    <select name="stream_name[]" id="stream_name_1" onchange="strmsubject(this.id)" style="width:85px" class="form-control" required>
                                        <option value="">Select</option>
                                      </select>                                       
                                    </td>                                  
                                    <td><div class="form-group">
                                        <input type="text" name="seat_no[]" class="form-control" required value="<?= isset($_REQUEST['seat_no']) ? $_REQUEST['seat_no'] : '' ?>" placeholder="Specialization"  /></td>
                                        </div>
                                    <td><input type="text" name="institute_name[]" class="form-control" value="<?= isset($_REQUEST['institute_name']) ? $_REQUEST['institute_name'] : '' ?>" placeholder="Name of Board/University" required /></td>
                                    <td><select name="pass_year[]" class="form-control" required>
                                        <option value="">Year</option>
                                        <?php
    for ($y = date("Y"); $y >= date("Y") - 60; $y--) {
        echo '<option value="' . $y . '">' . $y . '</option>';
    }
?>
                                     </select>
                                      <select name="pass_month[]" class="form-control" required>
                                        <option value="">Month</option>
                                        <option value="JAN">JAN</option>
                                        <option value="FEB">FEB</option>
                                        <option value="MAR">MAR</option>
                                        <option value="APR">APR</option>
                                        <option value="MAY">MAY</option>
                                        <option value="JUN">JUN</option>
                                        <option value="JUL">JUL</option>
                                        <option value="AUG">AUG</option>
                                        <option value="SEP">SEPT</option>
                                        <option value="OCT">OCT</option>
                                        <option value="NOV">NOV</option>
                                        <option value="DEC">DEC</option>
                                      </select></td>
                                    <td><input type="text" name="marks_obtained[]" id="qua-markobt_1" required class="form-control numbersOnly" maxlength="4" value="<?= isset($_REQUEST['marks_obtained']) ? $_REQUEST['marks_obtained'] : '' ?>" /></td>
                                    <td><input type="text" name="marks_outof[]" id="qua-markout_1" class="form-control numbersOnly" onblur="return cal_percentage(this.id)" maxlength="4" value="<?= isset($_REQUEST['marks_outof']) ? $_REQUEST['marks_outof'] : '' ?>" required placeholder="" /></td>
                                    <td><input type="text" name="percentage[]" id="qua-percent_1" class="form-control" maxlength="5" value="<?= isset($_REQUEST['percentage']) ? $_REQUEST['percentage'] : '' ?>" placeholder="" required readonly="true"/></td>
                                        <td><input type="text" name="cgpa[]" class="form-control" value="" placeholder="" required /></td>
                                       <td><input type="text" name="grade[]" class="form-control" value="" placeholder="" required /></td>
                                     <td><input type="file" required name="sss_doc[]" id="sss_doc" style="width:80px"></td>
                                    <td><input type="button" class="btn btn-xs btn-primary btn-flat" id="addmore" value="Add More" name="addMore" />
                                      <input type="button" class="btn btn-xs btn-danger btn-flat" id="remove" value="Remove" name="remove" /></td>
                                  </tr>
                               </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>                   
                     <div class="panel">
                      <div class="panel-heading">Entrance Exam</div>
                      <div class="panel-body">
                         <div id="suJeexamtable"></div>
                        <table class="table table-bordered edu-table" id="examDettable">
                            <thead>
                          <tr>
                            <th>Exam Name</th>                          
                            <th width="12%">Month</th>
                            <th width="12%">Year</th>
                            <th>Enrollment No</th>
                            <th>Marks/Grade</th>
                           <th></th>
                          </tr>
                          </thead>
                          <tbody>
                          <tr>
                          <td><select name="exam-name[]" class="form-control" style="width: 95px;"><option value="">Select</option>
                                <?php
                                foreach($exam_list as $exam_list)
                                {
                                 echo '<option value="'.$exam_list['exam_name'].'">'.$exam_list['exam_name'].'</option>';   
                                }
                                ?>
                                
                                </select></td>
                        
                          <td>
                              <select name="pass_monthe[]" class="form-control" style="width: 85px;">
                                <option value="">Month</option>
                                <option value="JAN">JAN</option>
                                <option value="FEB">FEB</option>
                                <option value="MAR">MAR</option>
                                <option value="APR">APR</option>
                                <option value="MAY">MAY</option>
                                <option value="JUN">JUN</option>
                                <option value="JUL">JUL</option>
                                <option value="AUG">AUG</option>
                                <option value="SEP">SEPT</option>
                                <option value="OCT">OCT</option>
                                <option value="NOV">NOV</option>
                                <option value="DEC">DEC</option>
                            </select>
                          </td>
                          <td><select name="pass_yeare[]" class="form-control" style="width: 85px;">
                                        <option value="">Year</option>
                                        <?php
for ($y = date("Y"); $y >= date("Y") - 60; $y--) {
    echo '<option value="' . $y . '">' . $y . '</option>';
}
?>
                                     </select>
                          </td>
                          
                          <td><input type="text" name="enrolment[]" class="form-control" placeholder="Enrolment Number" style="width: 100px;"/></td>
                          <td><input type="text" name="marks[]" id="mhcet_obt_marks" maxlength="3" class="form-control" placeholder="Marks Obtained" style="width: 70px;" /></td>
                  <td><input type="button" class="btn btn-xs btn-primary btn-flat" id="addmore" value="Add More" name="addMore" />
                                      <input type="button" class="btn btn-xs btn-danger btn-flat" id="remove" value="Remove" name="removeE" /></td>
                          </tr>
                          </tbody>
                        </table>

                        <div class="row">	
							<div class="col-sm-3">
							</div>
							 <div class="col-sm-9">
								
								<div class="form-group" id="schlr_div" style="display:none">
									 <label class="col-sm-2">Scholarship Types: </label>
									 <div class="col-sm-7">
									 <input type="radio" class="schBtn" name="schlr_type" id="schlr_type1" value="I"> I (100% Off)&nbsp;
									 <input type="radio" class="schBtn" name="schlr_type" id="schlr_type2" value="II"> II (50% Off) &nbsp;
									 <input type="radio" class="schBtn" name="schlr_type" id="schlr_type3" value="III"> III (25% Off)&nbsp;
									  <input type="radio" class="schBtn" name="schlr_type" id="schlr_type4" value="IV"> Other&nbsp;
									</div>
									
								<div class="col-sm-3" name="spertd" id="spertd" style="display:none"><select name="spert" id="spert" ><option value=""> Select Percentage</option>
								<?php
								for($i=1;$i<=100;$i++)
								{
								?>
								<option value="<?=$i?>"><?=$i?></option>
								<?php
								}
								?>
								
								</select></div>
									* On Tution Fee 
								 </div>
							</div>
						</div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-sm-4"></div>
                     <div class="col-sm-2">
                    <button class="btn btn-primary nextBtn form-control" id="" >Next</button>
                    </div>
                   </div>
                  </div>
                  <div id="documents-certificates" class="setup-content widget-threads panel-body tab-pane fade">
                        
                      <input type="hidden" name="reg_id" value="<?= $this->session->userdata('student_id') ?>">
                      <input type="hidden" name="step1statusval" value="<?= $this->session->userdata('stepfirst_status') ?>">
                      <input type="hidden" name="step2statusval" value="<?= $this->session->userdata('stepsecond_status') ?>">
                      <div class="panel">
                        <div class="panel-heading">List Of Documents To Be Submitted
                          <?= $astrik ?>
                       </div>
                        <div class="panel-body">
                          <div class="table-responsive">
                            <table class="doc-tbl table-bordered">
                              <tr>
                                <th>Select</th>
                                <th>Sr No.</th>                              
                                <th>Particulars</th>
                                <th>Original or Xerox</th>
                                <th>Upload Scan Copy</th>
                              </tr>
                              <?php
								foreach ($document as $key => $val) {
								?>
								<input type="hidden" name="updoc_id[]" value="<?= $document[$key]['doc_id'] ?>">
			                <?php
								}
								?>
                             <?php
							 $j=1;
							foreach ($doc_list as $doc) {
							?>
                             <tr>
                                <td><input type="checkbox"></td>
                                <td><?=$j++; //$doc['document_id'] ?>
                                 <input type="hidden" name="doc_id[]" value="<?= $doc['document_id'] ?>"></td>
                                <td><label>
                                    <?= $doc['document_name'] ?>
                                 </label></td>
                                <td><select name="ox[<?= $doc['document_id'] ?>]" >
                                    <option value="">Select</option>
                                    <option value="O">O</option>
                                    <option value="X">X</option>
                                  </select></td>
                                <td><input type="file" name="scandoc[<?= $doc['document_id'] ?>]"></td>
                              </tr>
                              <?php
}
?>
                           </table>
                          </div>
                        </div>
                      </div>
                    <div class="form-group">
                        <div class="col-sm-4"></div>
                       <div class="col-sm-2">
                          <button class="btn btn-primary nextBtn form-control" type="button" > Next</button>
                        </div>
                     </div>
                  </div>
                  <div id="references" class="setup-content widget-threads panel-body tab-pane fade">
                      <div class="panel">
                        <div class="panel-heading">References details</div>
                        <div class="panel-body">
                          <label class="col-sm-6">Reference (if any) of Relative(Blood
relation) working in SF/SU</label>
                          <table class="table table-bordered">
                            <tr>
                              <td width="14px">Sr No.</td>
                              <td>Reference Name</td>
                              <td>Contact Number</td>
                            </tr>
                            <tr>
                              <td>1</td>
                              <td width="45%"><div class="form-group"><input type="text" name="fref1" value="" class="form-control w300" /></div></td>
                              <td><div class="form-group"><input type="text" name="frefcont1" class="numbersOnly form-control w155" maxlength="10" value="<?= isset($references[0]['for_stud_refer_cont1']) ? $references[0]['for_stud_refer_cont1'] : '' ?>" class="form-control" ></div></td>
                            </tr>
                            <tr>
                              <td>2</td>
                              <td><input type="text" class="form-control w300" name="fref2" value="<?= isset($references[0]['for_stud_refer_name2']) ? $references[0]['for_stud_refer_name2'] : '' ?>"/></td>
                              <td><input type="text" class="form-control numbersOnly w155" name="frefcont2" maxlength="10" value="<?= isset($references[0]['for_stud_refer_cont2']) ? $references[0]['for_stud_refer_cont2'] : '' ?>" ></td>
                            </tr>
                          </table>
                          <table class="table table-bordered" id="ref_sandip">
                            <tr>
                              <td colspan="3"><label >Are you related to any person employed with Sandip University: </label>
                                <select name="reletedsandip" id="reletedsandip">
                                  <?php
										$val = $val1 = "";
										if ($references[0]['ex_emp_rel'] == 'Y') {
											$val = "selected";
										} else {
											$val1 = "selected";
										}
										?>
                                 <option value="">Select</option>
                                  <option <?php echo $val;?> value="Y">Yes</option>
                                  <option <?php echo $val1;?> value="N">No</option>
                                </select></td>
                            </tr>
                            <tr class="person_sandp">
                              <td><label>Name:</label>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="text" name="relatedname" value="<?= isset($references[0]['ex_emp_rname']) ? $references[0]['ex_emp_rname'] : '' ?>"/></td>
                              <td><label>Designation:</label>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="text" name="relateddesig" value="<?= isset($references[0]['ex_emp_rdesig']) ? $references[0]['ex_emp_rdesig'] : '' ?>"/></td>
                              <td><label>Relation:</label>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="text" name="relatedrelation" value="<?= isset($references[0]['ex_emp_relat']) ? $references[0]['ex_emp_relat'] : '' ?>" /></td>
                            </tr>
                              <tr>
                              <td colspan="3"><label >Are you related to Alumini of  Sandip University: </label>
                                <select name="aluminisandip" id="aluminisandip">
                                  <?php
									$val = $val1 = "";
									if ($references[0]['alumini_rel'] == 'Y') {
										$val = "selected";
									} else {
										$val1 = "selected";
									}
									?>
                                 <option value="">Select</option>
                                  <option <?php echo $val;?> value="Y">Yes</option>
                                  <option <?php echo $val1;?> value="N">No</option>
                                </select></td>
                            </tr>
                            <tr class="alumini_sandip">
                              <td><label>Name:</label>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="text" name="alumininame" value="<?= isset($references[0]['alumini_rel_name']) ? $references[0]['alumini_rel_name'] : '' ?>"/></td>
                              <td><label>passing Year:</label>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="text" name="aluminiyear" value="<?= isset($references[0]['alumini_rel_passyear']) ? $references[0]['alumini_rel_passyear'] : '' ?>"/></td>
                              <td><label>Relation:</label>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="text" name="aluminirelation" value="<?= isset($references[0]['alumini_relat']) ? $references[0]['alumini_relat'] : '' ?>" /></td>
                            </tr>

                            <tr>
                              <td colspan="3"><label >Are you  from sister concern institute of SF </label>
                                <select name="concern" id="concern">
                                  <?php
									$val = $val1 = "";
									if ($references[0]['alumini_rel'] == 'Y') {
										$val = "selected";
									} else {
										$val1 = "selected";
									}
									?>
                                 <option value="">Select</option>
                                  <option <?php echo $val;?> value="Y">Yes</option>
                                  <option <?php echo $val1;?> value="N">No</option>
                                </select></td>
                            </tr>
                           <tr class="concernid">
                              <td><label>Select Institute:</label>
                              <select name="cin" id="cin">
                                <option value="">Select Institute</option>
                                  <option value="SP">SP</option>
                                  <option  value="SIP">SIP</option>
                                  <option  value="SIPS">SIPS</option>
                                  <option  value="SITRC">SITRC</option>
                                  <option  value="SIEM">SIEM</option>
                                 
                                </select>
                            </tr>
                            <tr >
                              <td colspan="3"><label >Are your relatives studying in Sandip University: </label>
                                <select name="relativesandip" id="relativesandip">
                                  <?php
											$val = $val1 = "";
											if ($references[0]['rel_stud_san'] == 'Y') {
												$val = "selected";
											} else {
												$val1 = "selected";
											}
											?>
                                 <option value="">Select</option>
                                  <option <?php echo $val;?> value="Y">Yes</option>
                                  <option <?php echo $val1;?> value="N">No</option>
                                </select></td>
                            </tr>
                            <tr class="relativ_sandip">
                              <td><label>Name:</label>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="text" name="relativename" value="<?= isset($references[0]['rel_stud_san_name']) ? $references[0]['rel_stud_san_name'] : '' ?>"/></td>
                              <td><label>CourseName:</label>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="text" name="relativecoursenm" value="<?= isset($references[0]['rel_stud_san_course']) ? $references[0]['rel_stud_san_course'] : '' ?>"/></td>
                              <td><label>Relation:</label>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="text" name="relativerelation" value="<?= isset($references[0]['rel_stud_san_relat']) ? $references[0]['rel_stud_san_relat'] : '' ?>"/></td>
                            </tr>
                          </table>
                        </div>
                     
                      <div class="panel">
                        <div class="panel-heading">How Did You Come To Know About Sandip University</div>
                        <div class="panel-body">
                          <div class="form-group">
                            <label class="col-sm-3">Select The Publicity Media:</label>
                            <div class="col-sm-8">
                             
                                
                                
                                <?php
foreach ($pmedia as $course) {
    ?>
   <input type="checkbox" value="<?=$course['pm_id']?>" name="publicitysandip[]">  <?=$course['pm_name']?>
  
  <?php
}
?>

                            <!--  <select name="publicitysandip[]" multiple="multiple" >
                                <option value=""><strong>Select</strong></option>
                                <?php
$val = $val1 = $val2 = $val3 = $val4 = $val5 = $val6 = $val7 = $val8 = $val9 = "";
$arr = explode(',', $references[0]['publicity_media']);
// print_r($references[0]['publicity_media']);
foreach ($arr as $key => $val) {
    if ($arr[$key] == 'newspaper-advt') {
        $val = "selected";
    } elseif ($arr[$key] == 'newspaper-insert') {
        $val1 = "selected";
    } elseif ($arr[$key] == 'tv') {
        $val2 = "selected";
    } elseif ($arr[$key] == 'radio') {
        $val3 = "selected";
    } elseif ($arr[$key] == 'hording') {
        $val4 = "selected";
    } elseif ($arr[$key] == 'cstudent') {
        $val5 = "selected";
    } elseif ($arr[$key] == 'alumini') {
        $val6 = "selected";
    } elseif ($arr[$key] == 'staff') {
        $val7 = "selected";
    } elseif ($arr[$key] == 'website') {
        $val8 = "selected";
    } elseif ($arr[$key] == 'otherweb') {
        $val9 = "selected";
    } else {
        $val = $val1 = $val2 = $val3 = $val4 = $val5 = $val6 = $val7 = $val8 = $val9 = "";
    }
}
?>
                               <option <?php
echo $val;
?> value="newspaper-advt">Newspaper Advt</option>
                                <option <?php
echo $val1;
?> value="newspaper-insert">Newspaper Insertions</option>
                                <option <?php
echo $val2;
?> value="tv">TV Advt.</option>
                                <option <?php
echo $val3;
?> value="radio">Radio Advt.</option>
                                <option <?php
echo $val4;
?> value="hording">Hording</option>
                                <option <?php
echo $val5;
?> value="cstudent">Current Student</option>
                                <option <?php
echo $val6;
?> value="alumini">University Alumani</option>
                                <option <?php
echo $val7;
?> value="staff">University Staff</option>
                                <option <?php
echo $val8;
?> value="website">University Website</option>
                                <option <?php
echo $val9;
?> value="otherweb">Other Website</option>
                              </select>-->
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-12">Give the Reference of the candidate who may be interested to pursue academic program in sandip university:</label>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-3">Name of Candidate</label>
                            <div class="col-sm-3">
                              <input data-bv-field="refcandidatenm" id="refcandidatenm" name="refcandidatenm" class="form-control" value="<?= isset($references[0]['ref_bystud_name']) ? $references[0]['ref_bystud_name'] : '' ?>" placeholder="Candidate Name" type="text">
                            </div>
                            <label class="col-sm-3">Contact No.</label>
                            <div class="col-sm-3">
                              <input data-bv-field="refcandidatecont" id="refcandidatecont" name="refcandidatecont" class="form-control" minlength="10" maxlength="10" value="<?= isset($references[0]['ref_bystud_cont']) ? $references[0]['ref_bystud_cont'] : '' ?>" placeholder="Candidate contact" type="text">
                            </div>
                          </div>
                          <div class="form-group">
                          <div class="form-group">
                            <label class="col-sm-3">Email Id</label>
                            <div class="col-sm-3">
                              <input id="refcandidateemail" name="refcandidateemail" class="form-control" value="<?= isset($references[0]['ref_bystud_email']) ? $references[0]['ref_bystud_email'] : '' ?>" placeholder="Candidate Email" type="email">
                            </div>
                            <label class="col-sm-3">Relation with Candidate</label>
                            <div class="col-sm-3">
                              <input data-bv-field="refcandidaterelt" id="refcandidaterelt" name="refcandidaterelt" class="form-control" value="<?= isset($references[0]['ref_bystud_relat']) ? $references[0]['ref_bystud_relat'] : '' ?>" placeholder="With Candidate relation" type="text">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-3">Area of Interest</label>
                            <div class="col-sm-3">
                              <input data-bv-field="refcandidateinterest" id="refcandidateinterest" name="refcandidateinterest" class="form-control" value="<?= isset($references[0]['ref_bystud_area']) ? $references[0]['ref_bystud_area'] : '' ?>" placeholder="Candidate Interest Area" type="text">
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-sm-4"></div>
                       <div class="col-sm-2">
                         <button class="btn btn-primary nextBtn form-control" type="button" > Next</button>
                        </div>

                     </div>
                    
                  </div>
				  </div>
                  <!--end of references --> 
                  <!--start  of photos -->
                  </div>
                  <div id="payment-photo" class="setup-content widget-threads panel-body tab-pane fade">
                   <input type="hidden" name="reg_id" value="<?= $this->session->userdata('student_id') ?>">
                      <input type="hidden" name="step1statusval" value="<?= $this->session->userdata('stepfirst_status') ?>">
                      <input type="hidden" name="step2statusval" value="<?= $this->session->userdata('stepsecond_status') ?>">
                      <input type="hidden" name="step3statusval" value="<?= $this->session->userdata('stepthird_status') ?>">
                      <input type="hidden" name="step4statusval" value="<?= $this->session->userdata('stepfourth_status') ?>">
   
                        <div class="panel-body">
                       <div class="panel">
                            <div class="panel-heading">Student Personal Details</div>
                                <div class="panel-body">   
                                  <div class="form-group">
                                    <label class="col-sm-3">Student Photo (only .jpg allowed)</label>
                                    <div class="col-sm-3">
									<input type="file" id="profile_img" name="profile_img" class="form-control" value="" required >
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label class="col-sm-3">Current Employment</label>
                                    <div class="col-sm-3">
                                   <input type="radio" id="government" name="employment" value="government">
									 <label for="govt">Government Service</label><br>
									  <input type="radio" id="private" name="employment" value="private">
									 <label for="private">Private Service</label><br>
                                    </div>
									 <input type="radio" id="self" name="employment" value="self">
									 <label for="self">Self Employed</label><br>
									  <input type="radio" id="business" name="employment" value="business">
									 <label for="business">Business </label>
                                  </div>
								      <div class="form-group">
                                    <label class="col-sm-3">Remark</label>
                                    <div class="col-sm-3">
									<textarea id="remark" name="remark"></textarea>
                                    </div>
                                  </div>
								   <div class="form-group">
                                    <label class="col-sm-3">Employer NOC (only .pdf allowed)</label>
                                    <div class="col-sm-3">
									<input type="file" id="emp_noc" name="emp_noc" class="form-control" value="" >
                                    </div>
                                     </div>
                                   </div>
                                </div>
                            </div>
                        <div class="panel-body">
                          <div class="form-group">
                            <label class="col-sm-3">Confirm Submission</label>
                           <input type="checkbox" class="confirm" name="confirm" value="1" required="required"> select checkbox and click submit to confirm
                          </div>
                        </div>
						  <div class="form-group">
							<div class="col-sm-4"></div>
							<div class="col-sm-2">
							 <button class="btn btn-success btn-lg pull-right" type="submit">Submit</button>
							</div>
						 </div>
					  </div>
					</div>
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

<script type="text/javascript">
// Qualification percentage calculation
var d=$("#acyear").val();
getad(d);

    function getad(value)
    {
//<option>JAN-"+res+"</option>
        var res = value.substring(2);
        var ress=parseInt(res)+1;
        $("#admission_cycle").html("<option >Select Batch</option><option selected value='JAN-"+ress+"'>JAN-"+ress+"</option><option value='JULY-"+res+"'>JULY-"+res+"</option>");
    }
  function cal_percentage(id){
      var quamarkout = $("#"+id).val();
      var qres = id.split("_");
      var m = qres[1];
      var quamarkobt = '#qua-markobt_'+m;
	  var quaper = '#qua-percent_'+m;
	  var mrkobtned = $(quamarkobt).val();
      var quamarkoutof = parseInt(quamarkout);
	  var quamarkobted = parseInt(mrkobtned);
	  if(quamarkobted > quamarkoutof){
		  //alert("hii");
		  alert("Marks obtained should be smaller than Out of marks");
		  $(quamarkobt).focus();
		  $(quaper).val("");
		  return false;
	  }
      var tot_per = parseFloat(quamarkobted/quamarkoutof *100).toFixed(2);
	  $(quaper).val(tot_per);
	 return true;
  }
  // other MH-CET percentage calculation
  function ent_cal_percentage1(id){
      var entmarkout = $("#"+id).val();
	  var entmrkobtned = $("#mhcet_obt_marks").val();
      var entmarkoutof = parseInt(entmarkout);
	  var entmarkobted = parseInt(entmrkobtned);
	  if(entmarkobted > entmarkoutof){
		  //alert("hii");
		  alert("Marks obtained should be smaller than Out of marks");
		  $("#mhcet_obt_marks").focus();
		  $("#mhcet_per").val("");
		  return false;
	  }
      var ent_tot_per = parseFloat(entmarkobted/entmarkoutof *100).toFixed(2);
	  //alert(ent_tot_per);
	  $("#mhcet_per").val(ent_tot_per);
	 return true;
  }
  // other cet percentage calculation
  function ent_cal_percentage2(id){
      var entmarkout1 = $("#"+id).val();
	  var entmrkobtned1 = $("#othr_obt_marks").val();
      var entmarkoutof1 = parseInt(entmarkout1);
	  var entmarkobted1 = parseInt(entmrkobtned1);
	  if(entmarkobted1 > entmarkoutof1){
		  //alert("hii");
		  alert("Marks obtained should be smaller than Out of marks");
		  $("#othr_obt_marks").focus();
		  $("#othr_per").val("");
		  return false;
	  }
      var ent_tot_per1 = parseFloat(entmarkobted1/entmarkoutof1 *100).toFixed(2);
	  //alert(ent_tot_per1);
	  $("#othr_per").val(ent_tot_per1);
	 return true;
  }  
  
  function qualifcation(id){
      standrd = $("#"+id).val();

      res = id.split("_");
      var n= res[1];
      var streamId = '#stream_name_'+n;
      var sub = $(streamId).val();
       if(standrd=='SSC'){
    	  $(streamId).html("<option value='NA'>NA</option>");
    	  $(streamId+" option[value='NA']").attr("selected", "selected");
    	  $("tr.10th").show();
    	//$('.10th').show();
      }else if(standrd=='HSC'){
    	  $(streamId).html("<option value=''>-select-</option><option value='Arts'>Arts</option><option value='Commerce'>Commerce</option><option value='Science'>Science</option><option value='Vocational'>Vocational</option>");
    	  $("tr.12th").show();
    	  
      }else if(standrd=='Graduation'){
    	  //alert('Inside');
    	 $.post("<?= base_url() ?>Ums_admission/fetch_qualification_streams/", {getspecial: 1}, function (data) {
    		 //alert(data);
    		$(streamId).html(data);
    		
    	});
      }else if(standrd=='Diploma'){
    	  $(streamId).html("<option value='NA'>NA</option>");
    	  $(streamId+" option[value='NA']").attr("selected", "selected");
    	  $("tr.diploama").show();
      }
      else if(standrd=='Post Graduation'){
    	  $(streamId).html("<option value='NA'>NA</option>");
    	  $(streamId+" option[value='NA']").attr("selected", "selected");
    	 
      } 
  } 
  
   function strmsubject(id){
      streamId = $("#"+id).val();
      if(streamId=='Arts' || streamId=='Commerce'){
         $("tr.eng").show(); 
         $("tr.sci").hide(); 
         $("td.12eng").attr("rowspan","1");
      }else if(streamId=='Science'){
          $("td.12eng").attr("rowspan","5");
         $("tr.eng").show(); 
         $("tr.sci").show(); 
      }else{
          
      }

  } 
  
  // calculate balance left 
  function cal_balance_left() {
    //////////
    var fee_appli =document.getElementById('txt31').value;
    var fee_paid=document.getElementById('txt32').value;
	if(parseInt(fee_paid) > parseInt(fee_appli)){
		alert("Amount paid should be smaller than applecable fee");
		$("#txt32").val("");
		$("#txt33").val("");
		$("#paidfee").val("");
		return false;
	}
    var total_balance= parseInt(fee_appli)-parseInt(fee_paid);
    //alert(fee_appli);alert(fee_paid);
    if (!isNaN(total_balance)) {
        document.getElementById('txt33').value = total_balance;
        document.getElementById('paidfee').value = fee_paid;
    }
	return true;
  }
  //check duplicate mobile no
    function chek_mob_exist(mob_no) {
	
		   if (mob_no) {
			      var regx = /^[6-9]\d{9}$/ ;
            if(regx.test(mob_no) && mob_no.length==10)
			{

			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Ums_admission/chek_mob_exist',
				data: 'mobile_no=' + mob_no,
				success: function (resp) {
					//alert(resp);
					if(resp=="Duplicate"){
						alert("You have already registered with us using this mobile no.");
						$("#mobile").val("");
						$('#mobile').focus();
						return false;
					}else{
						return true
					}
					
				}
			});
			}else
			{
				alert("Mobile No should be in proper format");
			$("#mobile").val('');
			return false; // Stop the form submitting

			}
                			
			} else {}
		

  }
    function chek_aadhar_valid(aadhar) {
		   //var regx = /^[0-9]\d{12}$/ ;
		    var regx = /^\d{12}$/;
            if(regx.test(aadhar))
			{
				
			}else
			{
				alert("Aadhar No should be in proper format");
			     $("#saadhar").val('');
			}
	}
     function chek_email_exist(email) {
		 var emailf=/^\S+@\S+\.\S+$/;

	if (isNaN(email) && emailf.test(email)==true ) 
			{
				
			}
			else
			{
				alert("Email should be in proper format");
                 $("#email_id").val('');
			}
	}
function validatePercentage(x) {
   
    var str="x.2";
   
    var parts = str.split(".");
    //alert(parts[1]);

    return true;
}
////////////////////////////////////////////////////////////////////////////

$(document).ready(function(){
      $('#nationality').blur(function(e){
 var n = $(this).val();

 var res = n.toUpperCase();

if(res=='INDIAN' || res=='INDIA'){
    $('#adiv').show();
    $('#ladd').show();
    $('#lstate_id').attr("required", true);
     $('#ldistrict_id').attr("required", true);
      $('#lcity').attr("required", true);
       $('#lpincode').attr("required", true);
       $('#pstate_id').attr("required", true);
     $('#pdistrict_id').attr("required", true);
      $('#pcity').attr("required", true);
       $('#ppincode').attr("required", true);
    
}else{
    $('#lstate_id').removeAttr( "required" );
     $('#ldistrict_id').removeAttr( "required" );
      $('#lcity').removeAttr( "required" );
       $('#lpincode').removeAttr( "required" );
       $('#pstate_id').removeAttr( "required" );
     $('#pdistrict_id').removeAttr( "required" );
      $('#pcity').removeAttr( "required" );
       $('#ppincode').removeAttr( "required" );
$('#adiv').hide();
$('#ladd').hide();
}
    });
     $('.schBtn').on('click', function () {
    	var scval = $("input[type='radio'].schBtn:checked").val();	
    
			if(scval=="I"||scval=="II"||scval=="III"){
			    $('#spertd').fadeOut('slow');;
			    //	alert(scval);
			}
			else
			{
			     $('#spertd').fadeIn('slow');; 
			     	//alert(scval);
			}
     });

    $("tr.person_sandp").hide();
    $("tr.alumini_sandip").hide();
    $("tr.relativ_sandip").hide();
     $("tr.concernid").hide();
    $('#reletedsandip').change(function(){
        var reletedsandip = $("#reletedsandip").val();
        if(reletedsandip=='Y')
        $("tr.person_sandp").show();
        else
        $("tr.person_sandp").hide();

    });
    
	$('#admission_cycle').change(function(){
		
	$("#admission_school").val('');
	$("#admission-course").val('');
	$("#admission-branch").val('');
		
	$("#txt_acd").val('');
	$("#academic_fees_id").val('');
	$("#txt32").val('');
	 });
	
    $('#aluminisandip').change(function(){
        var aluminisandip = $("#aluminisandip").val();
        if(aluminisandip=='Y')
        $("tr.alumini_sandip").show();
        else
        $("tr.alumini_sandip").hide();

    });  
    
    
    
        $('#concern').change(function(){
        var concern = $("#concern").val();
        if(concern=='Y')
        $("tr.concernid").show();
        else
        $("tr.concernid").hide();

    });   
    
    
    $('#admission-branch').change(function(){ //on('chnage', function () {
        
		var strm_id = $("#admission-branch").val();
		var admission_cycle = $("#admission_cycle").val();
		var acyear = $("#acyear").val();
		//$("#admission-branch").val('');
		
	$("#txt_acd").val('');
	$("#academic_fees_id").val('');
	$("#txt32").val('');
		
		if($("input[type='radio'].schBtn").is(':checked')) {
			var schlr_manual = $("input[type='radio'].schBtn:checked").val();	
	
		}else{
			var schlr_manual ='';
		}
	//	alert(acyear);
		if (strm_id) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>phd_admission/fetch_academic_fees_for_stream_year',
				data: {'strm_id' : strm_id,'acyear':acyear,'admission_cycle':admission_cycle},//'strm_id=' + strm_id + 'acyear=' + acyear,
				success: function (resp) {
					//alert(resp)
					var obj = jQuery.parseJSON(resp);	
					var total_fees =parseInt(obj[0].tution_fees);
					var tot_fees =parseInt(obj[0].total_fees); 
					var total_fees =parseInt(obj[0].tution_fees); 
					var total_fees =parseInt(obj[0].total_fees); 
				
				    $("#txt_acd").val(total_fees);
					$("#academic_fees_id").val(parseInt(obj[0].academic_fees_id));
					//$("#txt_acd").val(tot_fees);
					//$("#txt_exempt").val(Math.round(exepmted_fees));
					$("#txt32").val(0);
				}
			});
		} else {
			//alert("Please enter registration no");

		}
	});	 
    
    
    
    
    
    
    $('#relativesandip').change(function(){
        var relativesandip = $("#relativesandip").val();
        if(relativesandip=='Y')
        $("tr.relativ_sandip").show();
        else
        $("tr.relativ_sandip").hide();

    });    
    //
    $("tr.10th").hide();
    $("tr.12th").hide();
    $("tr.diploama").hide();
    ///////
    $('#btn_sujee').on('click', function () {
		var reg_no = $("#reg_no").val();
		//alert(reg_no);
		if (reg_no) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Ums_admission/fetch_sujee_details',
				data: 'reg_no=' + reg_no,
				success: function (html) {
				//	alert(html);
					$('#suJeexamtable').html(html);
				}
			});
		} else {
			alert("Please enter registration no");
			$("#reg_no").focus();
		}
	});
    //SU-JEE Exam show and hide
    $('#chk_sujee').change(function(){
    if($(this).is(":checked"))
    $('#enrol_div').fadeIn('slow');
    else
    $('#enrol_div').fadeOut('slow');

    });
    // added by bala
	$('#chk_scholr').change(function(){
		if($(this).is(":checked")){
		$('#schlr_div').fadeIn('slow');
		}else{
			//alert('clear');
			$('#schlr_div').fadeOut('slow');
			$('.schBtn').prop('checked', false);
		}
    });
    // Num check logic
  	$('.numbersOnly').keyup(function () {
    if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
       this.value = this.value.replace(/[^0-9\.]/g, '');
    } 
  	});
  	
    // City by State
	$('#lstate_id').on('change', function () {
		var stateID = $(this).val();
		if (stateID) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Ums_admission/getStatewiseDistrict',
				data: 'state_id=' + stateID,
				success: function (html) {
					//alert(html);
					$('#ldistrict_id').html(html);
				}
			});
		} else {
			$('#ldistrict_id').html('<option value="">Select state first</option>');
		}
	});
	
    // City by State
	$('#ldistrict_id').on('change', function () {
		var district_id = $(this).val();
		var state_ID = $("#lstate_id").val();
	//	alert(state_ID);alert(district_id);
		if (district_id) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Ums_admission/getStateDwiseCity',
				data: { state_id: state_ID, district_id : district_id},
				success: function (html) {
					//alert(html);
					if(html !=''){
					$('#lcity').html(html);
					}else{
					  $('#lcity').html('<option value="">No city found</option>');  
					}
				}
			});
		} else {
			$('#lcity').html('<option value="">Select district first</option>');
		}
	});	
  /////////// for perment address
      // City by State
	$('#pstate_id').on('change', function () {
		var stateID = $(this).val();
		
		if (stateID) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Ums_admission/getStatewiseDistrict',
				data: 'state_id=' + stateID,
				success: function (html) {
					//alert(html);
					$('#pdistrict_id').html(html);
				}
			});
		} else {
			$('#pdistrict_id').html('<option value="">Select state first</option>');
		}
	});
	
    // City by State
	$('#pdistrict_id').on('change', function () {
		var district_id = $(this).val();
		var state_ID = $("#pstate_id").val();
	//	alert(state_ID);alert(district_id);
		if (district_id) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Ums_admission/getStateDwiseCity',
				data: { state_id: state_ID, district_id : district_id},
				success: function (html) {
					//alert(html);
					if(html !=''){
					$('#pcity').html(html);
					}else{
					  $('#pcity').html('<option value="">No city found</option>');  
					}
				}
			});
		} else {
			$('#pcity').html('<option value="">Select district first</option>');
		}
	});	

	 /////////// for Parent's/Guardian's Details *
      // City by State
	$('#gstate_id').on('change', function () {
		var stateID = $(this).val();
		
		if (stateID) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Ums_admission/getStatewiseDistrict',
				data: 'state_id=' + stateID,
				success: function (html) {
					//alert(html);
					$('#gdistrict_id').html(html);
				}
			});
		} else {
			$('#gdistrict_id').html('<option value="">Select state first</option>');
		}
	});
	
    // City by State
	$('#gdistrict_id').on('change', function () {
		var district_id = $(this).val();
		var state_ID = $("#gstate_id").val();
	//	alert(state_ID);alert(district_id);
		if (district_id) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Ums_admission/getStateDwiseCity',
				data: { state_id: state_ID, district_id : district_id},
				success: function (html) {
					//alert(html);
					if(html !=''){
					$('#gcity').html(html);
					}else{
					  $('#gcity').html('<option value="">No city found</option>');  
					}
				}
			});
		} else {
			$('#gcity').html('<option value="">Select district first</option>');
		}
	});	
	//////////////////////////////////////////////
    //$('#dob-datepicker').datepicker( {format: 'dd-mm-yyyy',autoclose: true});
    // Calculate the end date 18 years ago from the current date
    var endDate = new Date();
    endDate.setFullYear(endDate.getFullYear() - 18);

    $('#dob-datepicker').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        endDate: endDate,
        startDate: '-100y' // Just setting a very old date as a reference
    });
      $('#doadd-datepicker').datepicker( {format: 'dd-mm-yyyy',autoclose: true});
    $('#doc-sub-datepicker1').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#doc-sub-datepicker2').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#doc-sub-datepicker3').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#doc-sub-datepicker4').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#doc-sub-datepicker5').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#doc-sub-datepicker6').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#doc-sub-datepicker7').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#doc-sub-datepicker8').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#doc-sub-datepicker9').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#doc-sub-datepicker10').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#doc-sub-datepicker11').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#doc-sub-datepicker12').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#doc-sub-datepicker13').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#doc-sub-datepicker14').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#doc-sub-datepicker15').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#doc-sub-datepicker16').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#doc-sub-datepicker17').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#doc-sub-datepicker18').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#doc-sub-datepicker19').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#doc-sub-datepicker20').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#doc-sub-datepicker_ssc').datepicker( {format: 'yyyy-mm',startView: "year",minViewMode: "months",autoclose: true});
    $('#doc-sub-datepicker_hsc').datepicker( {format: 'yyyy-mm',startView: "year",minViewMode: "months",autoclose: true});

    $('#cvaldt1').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#cvaldt2').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#cvaldt3').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    
      $('#dsem1pass_date').datepicker( {format: 'yyyy-mm',startView: "year",minViewMode: "months",autoclose: true});
      $('#dsem2pass_date').datepicker( {format: 'yyyy-mm',startView: "year",minViewMode: "months",autoclose: true});
      $('#dsem3pass_date').datepicker( {format: 'yyyy-mm',startView: "year",minViewMode: "months",autoclose: true});
      $('#dsem4pass_date').datepicker( {format: 'yyyy-mm',startView: "year",minViewMode: "months",autoclose: true});
      $('#dsem5pass_date').datepicker( {format: 'yyyy-mm',startView: "year",minViewMode: "months",autoclose: true});
      $('#dsem6pass_date').datepicker( {format: 'yyyy-mm',startView: "year",minViewMode: "months",autoclose: true});
  
       var content = '<tr>'+$('#eduDetTable tbody tr').html()+'</tr>';
    // hide the remove button in education table
    var rowCount = $('#eduDetTable >tbody >tr').length;
    if(rowCount<2){$('#remove').hide();}
    else{$('#remove').show();}
    ///

    $("#eduDetTable").on("click","input[name='remove']", function(e){    
    //$("input[name='remove']").on('click',function(){
        var rowCount = $('#eduDetTable tbody tr').length;

        if(rowCount>1){
            $(this).parent().parent('tr').remove();
        }
    }); 
    
    var contentE = '<tr>'+$('#examDettable tbody tr').html()+'</tr>';
    // hide the removeE button in education table
    var rowCountE = $('#examDettable >tbody >tr').length;
	if(rowCountE<2){$('#removeE').hide();}
	else{$('#removeE').show();}

    $("#examDettable").on("click","input[name='addMore']", function(e){    
    //$("input[name='addMore']").on('click',function(){        
        //var contentE = $(this).parent().parent('tr').clone('true');
        $(this).parent().parent('tr').after(contentE);    
        
    });
    $("#examDettable").on("click","input[name='removeE']", function(e){    
    //$("input[name='removeE']").on('click',function(){
        var rowCountE = $('#examDettable tbody tr').length;

        if(rowCountE>1){
            $(this).parent().parent('tr').remove();
        }
    });  
    
    });  
    
    /////////// add more for edu table
    var max_fields      = 5; //maximum input boxes allowed

    var x = 1; //initlal text box count
    $("#addmore").click(function(e){ //on add input button click
 
       e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            var qid= "studqual_"+x;
            var strm = "stream_name_"+x;
			var mrkobt = "qua-markobt_"+x;
			var mrkout = "qua-markout_"+x;
            //alert(qid);
			var fieldshtml = "<tr><td> <div class='form-group'><select name='exam_id[]' id='studqual_"+x+"' class='squal form-control exam_id' onchange='qualifcation("+'"'+qid+'"'+")' required><option value=''>Select</option><option value='SSC'>SSC</option><option value='HSC'>HSC</option><option value='Graduation'>Graduation</option><option value='Post Graduation'>Post Graduations</option><option value='Diploma'>Diploma</option></select></div>   </td><td><select name='stream_name[]' id='stream_name_"+x+"' onchange='strmsubject("+'"'+strm+'"'+")' style='width:85px' class='form-control stream_name' required><option value=''>Select</option> </select></td><td><div class='form-group'><input type='text' name='seat_no[]' required class='form-control' value='' placeholder='Specialization' /></td></div><td><input type='text' name='institute_name[]' class='form-control institute_name' value='' placeholder='Name of Board/University' required /></td><td><select name='pass_year[]' class='form-control pass_year' required><option value=''>Year</option><?php  for ($y = date('Y'); $y >= date('Y') - 60; $y--) {  ?> <option value='<?=$y?>'><?=$y?></option><? }?></select><select name='pass_month[]' class='form-control pass_month' required><option value=''>Month</option><option value='JAN'>JAN</option><option value='FEB'>FEB</option><option value='MAR'>MAR</option><option value='APR'>APR</option><option value='MAY'>MAY</option><option value='JUN'>JUN</option><option value='JUL'>JUL</option><option value='AUG'>AUG</option><option value='SEP'>SEPT</option><option value='OCT'>OCT</option><option value='NOV'>NOV</option><option value='DEC'>DEC</option></select></td><td><input type='text' name='marks_obtained[]' id='qua-markobt_"+x+"' class='numbersOnly form-control marks_obtained'  maxlength='4' value='' required/></td><td><input type='text' name='marks_outof[]' id='qua-markout_"+x+"' onblur='return cal_percentage("+'"'+mrkout+'"'+")' class='numbersOnly form-control marks_outof' maxlength='4' value='' placeholder='' required/></td><td><input type='text' name='percentage[]' id='qua-percent_"+x+"' class='form-control percentage' maxlength='5' value='' placeholder='' required readonly='true'/></td><td><input type='file' required  name='sss_doc[]' id='sss_doc' style='width:80px'></td><td><input type='button' class='remove_field btn btn-xs btn-danger btn-flat' id='remove' value='Remove' name='remove' /></td></tr>";
		
            $("#eduDetTable >tbody").append(fieldshtml); //add input box
        }
    });
    $("#eduDetTable >tbody").on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('tr').remove(); x--;
    });

</script>
<!-- steps logic-->
<script type="text/javascript">
  $(document).ready(function () {
  var navListItems = $('ul.setup-panel li a'),
		  allWells = $('.setup-content'),
		  allNextBtn = $('.nextBtn');

  //allWells.hide();

  navListItems.click(function (e) {
	  e.preventDefault();
	  var $target = $($(this).attr('href')),
			  $item = $(this);

	  if (!$item.hasClass('disabled')) {
		  navListItems.removeClass('btn-primary').addClass('btn-default');
		  $item.addClass('btn-primary');
		  allWells.hide();
		  $target.show();
		  $target.find('select:eq(0)').focus();
	  }
  });

  allNextBtn.click(function(){
	  var curStep = $(this).closest(".setup-content"),
		  curStepBtn = curStep.attr("id"),
		  nextStepWizard = $('ul.setup-panel li a[href="#' + curStepBtn + '"]').parent().next().children("a"),
		  curInputs = curStep.find("input[type='text'],input[type='email'],input[type='radio'],input[type='url'],input[type='file'],textarea[textarea]"),
		  isValid = true;

	  $(".form-group").removeClass("has-error");
	  for(var i=0; i<curInputs.length; i++){
		  if (!curInputs[i].validity.valid){
			  isValid = false;
			  $(curInputs[i]).closest(".form-group").addClass("has-error");
		  }
	  }

	  if (isValid)
		  nextStepWizard.removeAttr('disabled').trigger('click');
  });

  $('ul.setup-panel li a.btn-primary').trigger('click');
});


</script>
<script>
$(document).ready(function(){
    $('#emp_noc').on('change', function(){
        var fileName = $(this).val();
        var ext = fileName.split('.').pop().toLowerCase();
        if($.inArray(ext, ['pdf']) == -1) {
            alert('Please select a PDF file.');
            $(this).val('');
        }
    });
	
	   $('#profile_img').on('change', function(){
        var fileName = $(this).val();
        var ext = fileName.split('.').pop().toLowerCase();
        if($.inArray(ext, ['jpg']) == -1) {
            alert('Please select a jpg file.');
            $(this).val('');
        }
    });
	
	
    });	
	 
function onlyAlphabets(event) {
  //allows only alphabets in a textbox
  if (event.type == "paste") {
    var clipboardData = event.clipboardData || window.clipboardData;
    var pastedData = clipboardData.getData('Text');
	var format = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/;
    if (isNaN(pastedData) ) {
		if(format.test(pastedData)){
			event.preventDefault();
		}
		else{
			return;
		}
    }
	
	else {
      event.preventDefault();
    }
  }
  var charCode = event.which;
  if (!(charCode >= 65 && charCode <= 120) && (charCode != 32 && charCode != 0) && charCode != 8 &&  charCode != 9 && (charCode >= 48 && charCode <= 57) || (charCode >= 96 && charCode <= 111)) {
    event.preventDefault();
  }
}

 
</script>
<style>
.w150{
    width:100px;
}
.w155{
    width:150px;
}
.w300{
    width:300px;
}
</style>
<!-- steps logic end-->