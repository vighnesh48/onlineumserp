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
		} else {
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
<?php
/*  echo"<pre>";
print_r($fee);
echo"</pre>";
die();  */
//$stud_id=$_REQUEST['s'];
//echo $stud_id;
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
    <div class="row ">
      <div class="col-sm-12">
        <div class="panel">
          <div class="panel-body">
           
                             
          <form id="form1" name="form1" action="<?= base_url($currentModule . '/ums_admission_submit') ?>" method="POST" enctype="multipart/form-data">
            <div class="xtable-info"> 
              <!--<label>Note:<span>Fields marked with asterisk(<?= $astrik ?>) are mandatory to be filled.</span></label>-->
              <div id="dashboard-recent" class="panel panel-warning">
                <div class="panel-heading"> <span class="panel-title"><i class="panel-title-icon fa fa-fire text-danger"></i>Details</span>
                  <ul class="nav nav-tabs nav-tabs-xs setup-panel">
                    <li class="active"><a data-toggle="tab" href="#personal-details">1.Personal Information</a></li>
                    <li><a data-toggle="tab" href="#educational-details">2.Educational Details</a></li>
                    <li><a data-toggle="tab" href="#documents-certificates">3.Documents & Certificates</a></li>
                    <li><a data-toggle="tab" href="#references">4.References</a></li>
                    <li id="paymnt"><a data-toggle="tab" href="#payment-photo">5.Payment Details & Photo</a></li>
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
                          
                          <!--  <input type="hidden" value="" id="campus_id" name="campus_id" />-->
                          
                          <div class="panel-padding no-padding-vr">
                              
                              
                                  <div class="form-group">
                              <label class="col-sm-3">Admission Type <?= $astrik ?></label>
                              <div class="col-sm-3">
                               
                                      <select name="admission_type" name="admission_type" class="form-control" required>
                                  <option value="">Select Type</option>
                                   <option value="1">New Admission</option>
                                    <option value="2">Lateral Entry</option>
                                 
                               </select>
                               
                               
                                </div>
                              </div>
                              
                              
                              
                              
                              
                              
                              
                            <div class="form-group">
                              <label class="col-sm-3">Admission To (Course) <?= $astrik ?></label>
                              <div class="col-sm-3" >
                                <select name="admission-course" class="form-control" onchange="load_streams(this.value)" required>
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
                                      function load_streams(type){
                   // alert(type);
                    
                $.ajax({
                    'url' : base_url + '/Ums_admission/load_streams',
                    'type' : 'POST', //the way you want to send data to your URL
                    'data' : {'course' : type},
                    'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
                        var container = $('#semest'); //jquery selector (get element by id)
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
                              <label class="col-sm-3">Branch(Stream) <?= $astrik ?></label>
                              <div class="col-sm-3" id="semest" >
                                <select name="admission-branch" class="form-control" required>
                                  <option value="">Select</option>
                                  <?php
foreach ($branches as $branch) {
    if ($branch['branch_code'] == $personal[0]['admission-branch']) {
        $sel = "selected";
    } else {
        $sel = '';
    }
    echo '<option value="' . $branch['branch_code'] . '" ' . $sel . '>' . $branch['branch_code'] . '</option>';
}
?>
                               </select>
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="col-sm-3">Student Name <?= $astrik ?></label>
                              <div class="col-sm-3">
                                <input data-bv-field="slname" id="slname" name="slname" class="form-control" value="<?= isset($personal[0]['lname']) ? $personal[0]['lname'] : ''; ?>" placeholder="Last Name" type="text" required>
                                </div>
                              <div class="col-sm-3">
                                <input data-bv-field="sfname" id="sfname" name="sfname" class="form-control" value="<?= isset($personal[0]['fname']) ? $personal[0]['fname'] : ''; ?>" placeholder="First Name" type="text" required>
                               </div>
                              <div class="col-sm-3">
                                <input data-bv-field="smname" id="smname" name="smname" class="form-control" value="<?= isset($personal[0]['mname']) ? $personal[0]['mname'] : ''; ?>" placeholder="Middle Name" type="text" required>
                                </div>
                            </div>
                            <div class="form-group">
                              <label class="col-sm-3">Father's/Husband Name <?= $astrik ?></label>
                              <div class="col-sm-3">
                                <input data-bv-field="slname" id="slname1" name="slname1" class="form-control" value="" placeholder="Last Name" type="text" required>
                                </div>
                              <div class="col-sm-3">
                                <input data-bv-field="sfname" id="sfname1" name="sfname1" class="form-control" value="" placeholder="First Name" type="text" required>
                                </div>
                              <div class="col-sm-3">
                                <input data-bv-field="smname" id="smname1" name="smname1" class="form-control" value="" placeholder="Middle Name" type="text" required>
                                </div>
                            </div>
                            <div class="form-group">
                              <label class="col-sm-3">Mother Name <?= $astrik ?></label>
                              <div class="col-sm-3">
                                <input data-bv-field="sfname" id="sfname2" name="sfname2" class="form-control" value="" placeholder="First Name" type="text" required>
                                <i data-bv-icon-for="sfname" class="form-control-feedback" style="display: none; top: 0px;"></i><small data-bv-result="NOT_VALIDATED" data-bv-for="sfname" data-bv-validator="notEmpty" class="help-block" style="display: none;">First name should not be empty</small><small data-bv-result="NOT_VALIDATED" data-bv-for="sfname" data-bv-validator="regexp" class="help-block" style="display: none;">First name should be alphabate characters</small><small data-bv-result="NOT_VALIDATED" data-bv-for="sfname" data-bv-validator="stringLength" class="help-block" style="display: none;">First name should be 2-50 characters.</small> </div>
                                
                              <label class="col-sm-3">Aadhar Card No </label>
                              <div class="col-sm-3">
                                <input type="text" id="saadhar" maxlength="12" value="<?= isset($personal[0]['aadhar_no']) ? $personal[0]['aadhar_no'] : ''; ?>" name="saadhar" class="numbersOnly form-control" >
                              
                            </div>
                            </div>
                            <div class="form-group">
                              <label class="col-sm-3">Date of Birth <?= $astrik ?></label>
                              <div class="col-sm-3 date" id="dob-datepicker">
                                  <div class="input-group">
                                <input type="text" id="dob" name="dob" class="form-control"  value="<?= isset($personal[0]['dob']) ? $personal[0]['dob'] : ''; ?>" placeholder="Date of Birth" required />
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span> </div></div>
                                
                                
                                  <label class="col-sm-3">Place Of Birth <?= $astrik ?></label>
                              <div class="col-sm-3 ">
        <input type="text" id="pob" name="pob" class="form-control"  value="<?= isset($personal[0]['dob']) ? $personal[0]['dob'] : ''; ?>" placeholder="Place of Birth" required />
                                </div>
                                
                                
                            </div>
                            <div class="form-group">
                              <label class="col-sm-3">Gender <?= $astrik ?></label>
                             <div class="col-sm-2">
                                <label>
                                  <input type="radio" value="M" id="gender" name="gender" required>
                                  &nbsp;&nbsp;Male</label>
                              </div>
                              <div class="col-sm-2">
                                <label>
                                  <input type="radio" value="F" id="gender" name="gender" required>
                                  &nbsp;&nbsp;Female</label>
                              </div>
                              <div class="col-sm-2">
                                <label>
                                  <input type="radio" value="T" id="gender" name="gender" required>
                                  &nbsp;&nbsp;TG</label>
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="col-sm-3">Mobile <?= $astrik ?></label>
                              <div class="col-sm-3">
                                <input type="text" id="mobile" name="mobile" class="form-control numbersOnly" value="" placeholder="contact no" maxlength="10" onblur="return chek_mob_exist(this.value)" required />
                              </div>
                              <label class="col-sm-3">Email</label>
                              <div class="col-sm-3">
                                <input type="email" id="email_id" name="email_id" class="form-control" value="" placeholder="Email" />
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="col-sm-3">Nationality </label>
                              <div class="col-sm-3">
                                <input type="text" id="nationality" name="nationality" class="form-control" value="Indian" placeholder="" />
                              </div>
                              <label class="col-sm-3">Category <?= $astrik ?></label>
                              <div class="col-sm-3">
                                <select id="category" name="category" class="form-control" required>
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
                              <label class="col-sm-3">Religion <?= $astrik ?></label>
                              <div class="col-sm-3">
                                <select id="religion" name="religion" class="form-control" required>
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
                                  <?php
$val  = "";
$val1 = "";
if ($personal[0]['res_state'] == "MS") {
    $val = "selected";
} elseif ($personal[0]['res_state'] == "OMS") {
    $val1 = "selected";
}
?>
                                 <option <?php
echo $val;
?> value="MS">MS</option>
                                  <option <?php
echo $val1;
?> value="OMS">OMS</option>
                                </select>
                              </div>
                            </div>
                            
                            <div class="form-group">
                              <label class="col-sm-3">Hostel(Fill Enclosure I)</label>
                              <div class="col-sm-3">
                                <select id="hostel" name="hostel" class="form-control">
                                  <option value="">Select</option>
                                  <?php
$val  = "";
$val1 = "";
if ($personal[0]['hostelfacility'] == "Y") {
    $val = "selected";
} elseif ($personal[0]['hostelfacility'] == "N") {
    $val1 = "selected";
}
?>
                                 <option <?php
echo $val;
?> value="Y">Yes</option>
                                  <option <?php
echo $val1;
?>value="N">No</option>
                                </select>
                              </div>
                              <div class="col-sm-2">
                                <label>
                                  <input type="radio" checked value="R" id="hosteltype" name="hosteltype">
                                  &nbsp;&nbsp;Regular</label>
                              </div>
                              <div class="col-sm-3">
                                <label>
                                  <input type="radio" value="D" id="hosteltype" name="hosteltype">
                                  &nbsp;&nbsp;Day Boarding</label>
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="col-sm-3">Transport(Fill Enclosure II)</label>
                              <div class="col-sm-3">
                                <select id="transport" name="transport" class="form-control">
                                  <option value="">Select</option>
                                  <?php
$val  = "";
$val1 = "";
if ($personal[0]['transportfacility'] == "Y") {
    $val = "selected";
} elseif ($personal[0]['transportfacility'] == "N") {
    $val1 = "selected";
}
?>
                                 <option <?php
echo $val;
?>  value="Y">Yes</option>
                                  <option <?php
echo $val1;
?> value="N">No</option>
                                </select>
                              </div>
                              <label class="col-sm-3">Bording Point</label>
                              <div class="col-sm-3">
                                <input type="text" name="bording_point" value="<?= isset($personal[0]['bording_point']) ? $personal[0]['bording_point'] : ''; ?>" placeholder="Bording Point" class="form-control">
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
                              <th>Local Address</th>
                              <th>Permanent Address</th>
                            </tr>
                              <tr>
                            
                            <!--Local Address-->
                            <td width="47%">
                            <div class="form-group">
                                <label  class="col-sm-3">Address: <?=$astrik?></label>
                                <div class="col-sm-6">
                                  <textarea id="laddress" class="form-control" NAME="laddress" style="margin: 0px; width: 200px; height: 50px;" required></textarea>
                                </div>
                              </div>

                              <div class="form-group">
                                <label  class="col-sm-3">State: <?=$astrik?></label>
                                <div class="col-sm-6">
                                  <select class="form-control" name="lstate_id" id="lstate_id" required>
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
                                  <select class="form-control" name="ldistrict_id" id="ldistrict_id" required>
                                      <option value="">select District</option>
                                  </select>
                                </div>
                              </div>
                              <div class="form-group">
                                <label  class="col-sm-3">City: <?=$astrik?></label>
                                <div class="col-sm-6">
                                   <select class="form-control" name="lcity" id="lcity" required>
                                      <option value="">select City</option>
                                  </select>
                                </div>
                              </div>
                              <div class="form-group">
                                <label  class="col-sm-3">Pin Code: <?=$astrik?></label>
                                <div class="col-sm-6">
                                  <INPUT TYPE="TEXT" class="form-control numbersOnly" id="lpincode" maxlength="6" NAME="lpincode" value="" required>
                                </div>
                              </div>
                              </td>
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
                                  <INPUT TYPE="TEXT" class="form-control numbersOnly" id="ppincode" maxlength="6" NAME="ppincode" value="" required>
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
                           <!--<tr><td><label style="text-align:left"><input name="same" <?php
echo $val;
?> onclick="copyBilling (this.form) " type="checkbox">Permanent Address is Same as Local Address</label></td></tr>-->
                          </table>
                          <label style="text-align:left">
                            <input name="same" <?php
echo $val;
?> onclick="copyBilling (this.form) " type="checkbox">
                            Permanent Address is Same as Local Address</label>
                        </div>
                      </div>
                      <div class="panel">
                        <div class="panel-heading">Parent's/Guardian's Details
                          <?= $astrik ?>
                       </div>
                        <div class="panel-body">
                          <div class="form-group">
                            <label class="col-sm-3">Parent/Guardian's Name</label>
                            <div class="col-sm-3">
                              <input type="text" id="parent_lname" name="lname" class="form-control" value="<?= isset($personal[0]['glname']) ? $personal[0]['glname'] : '' ?>" placeholder="Last Name" />
                            </div>
                            <div class="col-sm-3">
                              <input type="text" id="parent_fname" name="fname" class="form-control" value="<?= isset($personal[0]['gfname']) ? $personal[0]['gfname'] : '' ?>" placeholder="First Name" />
                            </div>
                            <div class="col-sm-3">
                              <input type="text" id="parent_mname" name="mname" class="form-control" value="<?= isset($personal[0]['gmname']) ? $personal[0]['gmname'] : '' ?>" placeholder="Middle Name" />
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-3">Relationship </label>
                            <div class="col-sm-3">
                              <select name="relationship" class="form-control">
                                <option value="">Select</option>
                                <?php
$val1 = $val2 = $val3 = $val4 = "";
if ($personal[0]['grelationship'] == "Father") {
    $val1 = "selected";
} elseif ($personal[0]['grelationship'] == "Mother") {
    $val2 = "selected";
} elseif ($personal[0]['grelationship'] == "Uncle") {
    $val3 = "selected";
} elseif ($personal[0]['grelationship'] == "Other") {
    $va4 = "selected";
}
?>
                               <option <?php
echo $val1;
?> value="Father">Father</option>
                                <option <?php
echo $val2;
?> value="Mother">Mother</option>
                                <option <?php
echo $val3;
?> value="Uncle">Uncle</option>
                                <option <?php
echo $val4;
?> value="Other">Other</option>
                              </select>
                            </div>
                            <label class="col-sm-3">Occupation </label>
                            <div class="col-sm-3">
                              <select name="occupation" class="form-control">
                                <option value="">Select</option>
                                <?php
$val1 = $val2 = $val3 = $val4 = "";
if ($personal[0]['goccupation'] == "Service") {
    $val1 = "selected";
} elseif ($personal[0]['goccupation'] == "Business") {
    $val2 = "selected";
} elseif ($personal[0]['goccupation'] == "Farmer") {
    $val3 = "selected";
} elseif ($personal[0]['goccupation'] == "Other") {
    $va4 = "selected";
}
?>
                               <option <?php
echo $val1;
?> value="Service">Service</option>
                                <option <?php
echo $val2;
?> value="Business">Business</option>
                                <option <?php
echo $val3;
?> value="Farmer">Farmer</option>
<option <?php
echo $val3;
?> value="Retired">Retired</option>
                                <option <?php
echo $val4;
?> value="Other">Other</option>
                              </select>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-3">Annual Income </label>
                            <div class="col-sm-3">
                              <input type="text" id="annual_income" name="annual_income" class="form-control" value="<?= isset($personal[0]['gannual_income']) ? $personal[0]['gannual_income'] : '' ?>" placeholder="Annual Income in Rs." />
                            </div>
                            <label class="col-sm-3">E-Mail </label>
                            <div class="col-sm-3">
                              <input type="text" id="parent_email" name="parent_email" class="form-control" value="<?= isset($personal[0]['gparent_email']) ? $personal[0]['gparent_email'] : '' ?>" placeholder="Email" />
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-3">Mobile</label>
                            <div class="col-sm-3">
                              <input type="text" id="parent_mobile" name="parent_mobile" class="form-control numbersOnly" maxlength="10" value="<?= isset($personal[0]['gparent_mobile']) ? $personal[0]['gparent_mobile'] : '' ?>" maxlength="10"/>
                            </div>
                            <label class="col-sm-3">Phone No</label>
                            <div class="col-sm-3">
                              <input type="text" id="parent_phone" name="parent_phone" class="form-control numbersOnly" maxlength="10" value="<?= isset($personal[0]['gparent_phone']) ? $personal[0]['gparent_phone'] : '' ?>" />
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-3">Address</label>
                            <div class="col-sm-3">
                              <textarea id="gparent_address" name="gparent_address" class="form-control" rows="3" cols="50" style="resize: vertical;" ><?= isset($personal[0]['gparent_address']) ? $personal[0]['gparent_address'] : '' ?>
</textarea>
                            </div>
                               
                          </div>
                          <div class="form-group">
                                <label  class="col-sm-3">State: <?=$astrik?></label>
                                <div class="col-sm-3">
                                  <select class="form-control" name="gstate_id" id="gstate_id" required>
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
                              
                                <label  class="col-sm-3">District: <?=$astrik?></label>
                                <div class="col-sm-3">
                                  <select class="form-control" name="gdistrict_id" id="gdistrict_id" required>
                                      <option value="">select District</option>
                                  </select>
                                </div>
                              </div>
                              <div class="form-group">
                                <label  class="col-sm-3">City: <?=$astrik?></label>
                                <div class="col-sm-3">
                                   <select class="form-control" name="gcity" id="gcity" required>
                                      <option value="">select City</option>
                                  </select>
                                </div>
                                <label  class="col-sm-3">Pin Code: <?=$astrik?></label>
                                <div class="col-sm-3">
                                  <INPUT TYPE="TEXT" class="form-control numbersOnly" id="gpincode" maxlength="6" NAME="gpincode" value="" required>
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
                  <!--end of personal-details --> 
                  <!-- / .widget-comments --> 
                  <!--start  of educational-details -->
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
                                        <input type="text" name="seat_no[]" class="form-control" value="<?= isset($_REQUEST['seat_no']) ? $_REQUEST['seat_no'] : '' ?>" placeholder="Specialization" /></td>
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
                                    <td><input type="text" name="marks_obtained[]" class="form-control numbersOnly" maxlength="4" value="<?= isset($_REQUEST['marks_obtained']) ? $_REQUEST['marks_obtained'] : '' ?>" required/></td>
                                    <td><input type="text" name="marks_outof[]" class="form-control numbersOnly" maxlength="4" value="<?= isset($_REQUEST['marks_outof']) ? $_REQUEST['marks_outof'] : '' ?>" placeholder="" required/></td>
                                    <td><input type="text" name="percentage[]" class="form-control" maxlength="5" value="<?= isset($_REQUEST['percentage']) ? $_REQUEST['percentage'] : '' ?>" placeholder="" required/></td>
                                     <td><input type="file" name="sss_doc[]" id="sss_doc" style="width:80px" required></td>
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
                      <div class="panel-heading">Marks Detail</div>
                      <div class="panel-body">
                        <table class="table table-bordered">
                          <tr>
                            <th>Exam</th>
                            <th>Subject</th>
                            <th>Marks Obtained</th>
                            <th>Total Marks</th>
                            <th width="18%">Passing Year</th>
                           
                          </tr>
                         
                        
                          <tr class="10th">
                            <td><label>10th(Matriculation)Or Equivalent</label></td>
                            <td><label>English</label></td>
                            <td><input type="text" id="tssc_eng" class="numbersOnly form-control w150" name="tssc_eng" maxlength="3" value="<?= isset($qualiexam[0]['stotal_eng']) ? $qualiexam[0]['stotal_eng'] : '' ?>" >
                              <i data-bv-icon-for="tssc_eng" class="form-control-feedback" style="display: none; top: 0px;"></i><small data-bv-result="NOT_VALIDATED" data-bv-for="tssc_eng" data-bv-validator="notEmpty" class="help-block" style="display: none;">Mark should not be empty </small></td>
                            <td><input type="text" id="ossc_eng" name="ossc_eng" class="numbersOnly form-control w150" maxlength="3" value="<?= isset($qualiexam[0]['sobt_eng']) ? $qualiexam[0]['sobt_eng'] : '' ?>" ></td>
                            <td>
                              <div class="input-group date" id="doc-sub-datepicker_ssc">
                                <input type="text" id="sscpass_date" name="sscpass_date" class="form-control " value="<?= isset($qualiexam[0]['ssc_passing_dt']) ? $qualiexam[0]['ssc_passing_dt'] : '' ?>" placeholder="yyyy-mm-dd">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span> </div></td>
                               
                          </tr>
                         
                         
                         
                          <tr class="12th eng">
                            <td rowspan="5" class='12eng'>12th(Intermediate)or Equivalent</td>
                            <td><label>English</label></td>
                            <td><input type="text" id="thsc_eng" class="numbersOnly form-control w150" maxlength="3" value="<?= isset($qualiexam[0]['htotal_eng']) ? $qualiexam[0]['htotal_eng'] : '' ?>" name="thsc_eng">
                                </td>
                            <td><input type="text" id="ohsc_eng" class="numbersOnly form-control w150" maxlength="3" name="ohsc_eng" value="<?= isset($qualiexam[0]['hobt_eng']) ? $qualiexam[0]['hobt_eng'] : '' ?>">
                                </td>
                            <td>
                              <div class="input-group date" id="doc-sub-datepicker_hsc">
                                <input data-bv-field="slname" type="text" id="hscpass_date" class="form-control" name="hscpass_date" maxlength="3" value="<?= isset($qualiexam[0]['hscpass_date']) ? $qualiexam[0]['hscpass_date'] : '' ?>" placeholder="yyyy-mm-dd">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span> </div>
                            </td>
                                
                          </tr>
                          <tr class="12th sci">
                            <td><label>Physics</label></td>
                            <td><input type="text" id="thsc_phy" class="numbersOnly form-control w150" maxlength="3" value="<?= isset($qualiexam[0]['htotal_phy']) ? $qualiexam[0]['htotal_phy'] : '' ?>" name="thsc_phy"></td>
                            <td><input type="text" id="ohsc_phy" class="numbersOnly form-control w150" maxlength="3" value="<?= isset($qualiexam[0]['hobt_phy']) ? $qualiexam[0]['hobt_phy'] : '' ?>" name="ohsc_phy"></td>
                          </tr>
                          <tr class="12th sci">
                            <td><label>chemistry</label></td>
                            <td><input type="text" id="thsc_chem" class="numbersOnly form-control w150" maxlength="3" value="<?= isset($qualiexam[0]['htotal_chem']) ? $qualiexam[0]['htotal_chem'] : '' ?>" name="thsc_chem"></td>
                            <td><input type="text" id="ohsc_chem" class="numbersOnly form-control w150" maxlength="3" name="ohsc_chem" value="<?= isset($qualiexam[0]['hobt_chem']) ? $qualiexam[0]['hobt_chem'] : '' ?>"></td>
                          </tr>
                          <tr class="12th sci">
                            <td><label>Math</label></td>
                            <td><input type="text" id="thsc_maths" class="numbersOnly form-control w150" maxlength="3" value="<?= isset($qualiexam[0]['htotal_bio']) ? $qualiexam[0]['htotal_bio'] : '' ?>" name="thsc_maths"></td>
                            <td><input type="text" id="ohsc_maths" class="numbersOnly form-control w150" maxlength="3" name="ohsc_maths" value="<?= isset($qualiexam[0]['hobt_bio']) ? $qualiexam[0]['hobt_bio'] : '' ?>" ></td>
                          </tr>
                          <tr class="12th sci">
                            <td><label>Biology</label></td>
                            <td><input type="text" id="thsc_bio" class="numbersOnly form-control w150" maxlength="3" value="<?= isset($qualiexam[0]['htotal_bio']) ? $qualiexam[0]['htotal_bio'] : '' ?>" name="thsc_bio"></td>
                            <td><input type="text" id="ohsc_bio" class="numbersOnly form-control w150" maxlength="3" name="ohsc_bio" value="<?= isset($qualiexam[0]['hobt_bio']) ? $qualiexam[0]['hobt_bio'] : '' ?>" ></td>
                          </tr>

                          <tr class='diploama'>
                            <td><label>Diploma</label></td>
                            <td><label>Sem 1</label></td>
                            <td><input  type="text" id="tdsem1_eng" class="numbersOnly form-control w150" maxlength="3" name="tdsem1_eng" value="" >
                              </td>
                            <td><input  type="text" id="odsem1_eng" class="numbersOnly form-control w150" maxlength="3" name="odsem1_eng" value="" ></td>
                            <td>
                              <div class="input-group date" id="doc-sub-datepicker_ssc">
                                <input  type="text" id="dsem1pass_date" class="form-control" name="dsem1pass_date" value="" placeholder="yyyy-mm-dd">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span> </div>
                            </td>
                           
                            </tr>
                            
                            <tr class='diploama'>
                            <td></td>
                            <td><label>Sem 2</label></td>
                            <td><input  type="text" id="tdsem2_eng" class="numbersOnly form-control w150" maxlength="3" name="tdsem2_eng" value="" >
                              </td>
                            <td><input  type="text" id="odsem2_eng" class="numbersOnly form-control w150" maxlength="3" name="odsem2_eng" value="" ></td>
                            <td>
                              <div class="input-group date" id="doc-sub-datepicker_ssc">
                                <input  type="text" id="dsem2pass_date" class="form-control" name="dsem2pass_date" maxlength="3" value="" placeholder="yyyy-mm-dd">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span> </div>
                            </td>
                            
                            </tr>
                            
                            <tr class='diploama'>
                            <td></td>
                            <td><label>Sem 3</label></td>
                            <td><input  type="text" id="tdsem3_eng" class="numbersOnly form-control w150" maxlength="3" name="tdsem3_eng" value="" >
                              </td>
                            <td><input  type="text" id="odsem3_eng" class="numbersOnly form-control w150" maxlength="3" name="odsem3_eng" value="" ></td>
                            <td>
                              <div class="input-group date" id="doc-sub-datepicker_ssc">
                                <input  type="text" id="dsem3pass_date" class="form-control" name="dsem3pass_date" value="" placeholder="yyyy-mm-dd">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span> </div>
                            </td>
                            
                            </tr>
                            <tr class='diploama'>
                            <td></td>
                            <td><label>Sem 4</label></td>
                            <td><input  type="text" id="tdsem4_eng" class="numbersOnly form-control w150" maxlength="3" name="tdsem4_eng" value="" >
                              </td>
                            <td><input  type="text" id="odsem4_eng" class="numbersOnly form-control w150" maxlength="3" name="odsem4_eng" value="" ></td>
                            <td>
                              <div class="input-group date" id="doc-sub-datepicker_ssc">
                                <input  type="text" id="dsem4pass_date" class="form-control" name="dsem4pass_date" value="" placeholder="yyyy-mm-dd">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span> </div>
                            </td>
                            
                            </tr>
                            <tr class='diploama'>
                            <td></td>
                            <td><label>Sem 5</label></td>
                            <td><input  type="text" id="tdsem5_eng" class="numbersOnly form-control w150" maxlength="3" name="tdsem5_eng" value="" >
                              </td>
                            <td><input  type="text" id="odsem5_eng" class="numbersOnly form-control w150" maxlength="3" name="odsem5_eng" value="" ></td>
                            <td>
                              <div class="input-group date" id="doc-sub-datepicker_ssc">
                                <input  type="text" id="dsem5pass_date" class="form-control" name="dsem5pass_date" value="" placeholder="yyyy-mm-dd">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span> </div>
                            </td>
                            
                            </tr>
                            <tr class='diploama'>
                            <td></td>
                            <td><label>Sem 6</label></td>
                            <td><input  type="text" id="tdsem6_eng" class="numbersOnly form-control w150" maxlength="3" name="tdsem6_eng" value="" >
                              </td>
                            <td><input  type="text" id="odsem6_eng" class="numbersOnly form-control w150" maxlength="3" name="odsem6_eng" value="" ></td>
                            <td>
                              <div class="input-group date" id="doc-sub-datepicker_ssc">
                                <input  type="text" id="dsem6pass_date" class="form-control" name="dsem6pass_date" value="" placeholder="yyyy-mm-dd">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span> </div>
                            </td>
                           
                          </tr>
                 
                        </table>
                      </div>
                    </div>
                    
                    <div class="panel">
                      <div class="panel-heading">Entrance Exam</div>
                      <div class="panel-body">
                          
                         <div class="row">
							<div class="col-sm-6">
								 <input type="checkbox" name="chk_sujee" id="chk_sujee" value="SUJEE"> SU-JEE-17<br>
								 <div class="form-group" id="enrol_div" style="display:none">
									 <label class="col-sm-4">Enrolment Number: </label>
									 <div class="col-sm-5">
									 <input type="text" class="form-control numbersOnly" name="reg_no" id="reg_no" value="" placeholder="Enrolment Number">
									 </div>
									 <div class="col-sm-2">
									 <input type="button" class="" name="btn_sujee" id="btn_sujee" value="Submit">
									 </div>
								 </div>
							 </div>
							 
						</div>
                         <div id="suJeexamtable"></div>
                        <table class="table table-bordered edu-table" id="examDettable">
                            <thead>
                          <tr>
                            <th>Exam Name</th>
                            <th>Oth Exam Name</th>
                            <th width="12%">Month</th>
                            <th width="12%">Year</th>
                            <th>Enrolment No</th>
                            <th>Marks Obt</th>
                            <th>Total Marks</th>
                            <th>Percentage</th>
                            
                          </tr>
                          </thead>
                          <tbody>
                          <tr>
                          <td><select name="exam-name[]" class="form-control" style="width: 95px;"><option value="">Select</option>
                                <option value="MH-CET">MH-CET</option>
                                </select></td>
                          <td><input type="text" name="other_exam-name[]" class="form-control" placeholder="Exam Name" /></td>
                          <td>
                              <select name="pass_month[]" class="form-control" style="width: 85px;">
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
                          <td><select name="pass_year[]" class="form-control" style="width: 85px;">
                                        <option value="">Year</option>
                                        <?php
for ($y = date("Y"); $y >= date("Y") - 60; $y--) {
    echo '<option value="' . $y . '">' . $y . '</option>';
}
?>
                                     </select>
                          </td>
                          
                          <td><input type="text" name="enrolment[]" class="form-control" placeholder="Enrolment Number" style="width: 100px;"/></td>
                          <td><input type="text" name="marks[]" id="mhcet_obt_marks" maxlength="3" class="form-control numbersOnly" placeholder="Marks Obtained" style="width: 70px;" /></td>
                          <td><input type="text" name="totalmarks[]" maxlength="3" class="form-control numbersOnly" placeholder="Total Marks" style="width: 70px;"/></td>
                          <td><input type="number" name="ent_percentage[]" step="0.01" min="0" max="100" class="form-control" placeholder="Percentage" style="width: 80px;"/></td>

                          </tr>
						  <tr>
                          <td><select name="exam-name[]" class="form-control" style="width: 95px;"><option value="">Select</option>
                               
                                <option value="Other">Other</option></select></td>
                          <td><input type="text" name="other_exam-name[]" class="form-control" placeholder="Exam Name" /></td>
                          <td>
                              <select name="pass_month[]" class="form-control" style="width: 85px;">
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
                          <td><select name="pass_year[]" class="form-control" style="width: 85px;">
                                        <option value="">Year</option>
                                        <?php
for ($y = date("Y"); $y >= date("Y") - 60; $y--) {
    echo '<option value="' . $y . '">' . $y . '</option>';
}
?>
                                     </select>
                          </td>
                          
                          <td><input type="text" name="enrolment[]" class="form-control" placeholder="Enrolment Number" style="width: 100px;"/></td>
                          <td><input type="text" name="marks[]" id="othr_obt_marks" maxlength="3" class="form-control numbersOnly" placeholder="Marks Obtained" style="width: 70px;" /></td>
                          <td><input type="text" name="totalmarks[]" class="form-control numbersOnly" maxlength="3" placeholder="Total Marks" style="width: 70px;"/></td>
                          <td><input type="text" name="ent_percentage[]" class="form-control" placeholder="Percentage" style="width: 80px;"/></td>

                          </tr>
                          </tbody>
                        </table>
                        <div class="row">	
							 <div class="col-sm-6">
								<input type="checkbox" name="chk_scholr" id="chk_scholr" value="scholr"> Is Scholarship?<br>
								<div class="form-group" id="schlr_div" style="display:none">
									 <label class="col-sm-4">Scholarship Types: </label>
									 <div class="col-sm-6">
									 <input type="radio" name="schlr_type" id="schlr_type" value="I"> 1<sup>st</sup> &nbsp;
									 <input type="radio" name="schlr_type" id="schlr_type" value="II"> 2<sup>nd</sup> &nbsp;
									 <input type="radio" name="schlr_type" id="schlr_type" value="III"> 3<sup>rd</sup> &nbsp;
									 </div>
									 <!--div class="col-sm-2">
									 <input type="button" class="" name="btn_sujee" id="btn_sujee" value="Submit">
									 </div-->
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
                  <!--end  of educational --> 
                  <!--start  of documents-certificates -->
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
                                <th>Sr No.</th>
                                <th>Particulars</th>
                                <th>Mark 'NA'if not applicable</th>
                                <th>Mark'O' if Submitted in original and 'X' if xerox submitted</th>
                                <th>If Pending for submission(Specify Date of Submission)</th>
                                <th>Upload Scan Copy</th>
                                <th>Remark</th>
                              </tr>
                              <?php
foreach ($document as $key => $val) {
?>
                             <input type="hidden" name="updoc_id[]" value="<?= $document[$key]['doc_id'] ?>">
                              <?php
}
?>
                             <?php
foreach ($doc_list as $doc) {
?>
                             <tr>
                                <td><?= $doc['document_id'] ?>
                                 <input type="hidden" name="doc_id[]" value="<?= $doc['document_id'] ?>"></td>
                                <td><label>
                                    <?= $doc['document_name'] ?>
                                 </label></td>
                                <td><div class="form-group">
                                    <select name="dapplicable[<?= $doc['document_id'] ?>]">
                                    <option value="">Select</option>
                                    <option value="A">Yes</option>
                                    <option value="NA">NA</option>
                                  </select></td>
                                <td><select name="ox[<?= $doc['document_id'] ?>]" >
                                    <option value="">Select</option>
                                    <option value="O">O</option>
                                    <option value="X">X</option>
                                  </select></td>
                                <td><div class="form-group">
                                    <div class="input-group date" id="doc-sub-datepicker<?= $doc['document_id'] ?>">
                                      <input type="text" id="docsubdate[]" name="docsubdate[<?= $doc['document_id'] ?>]" class="form-control" value="<?= isset($_REQUEST['docsubdate']) ? $_REQUEST['docsubdate'] : '' ?>" placeholder="Date" />
                                      <span class="input-group-addon"><i class="fa fa-calendar"></i></span> </div>
                                  </div></td>
                                <td><input type="file" name="scandoc[<?= $doc['document_id'] ?>]"></td>
                                <td><input type="text" name="remark[<?= $doc['document_id'] ?>]?>"/></td>
                              </tr>
                              <?php
}
?>
                           </table>
                          </div>
                        </div>
                      </div>
                      <div class="panel">
                        <div class="panel-heading">Certificates Details </div>
                        <div class="panel-body">
                          <table class="table table-bordered">
                            <tr>
                              <th>Certificate Name</th>
                              <th>Certificate No.</th>
                              <th>Issue Date</th>
                              <th>Validity</th>
                            </tr>
                            <tr>
                              <td><input type="hidden" name="cert_id[]" value="<?= isset($certificate[0]['cid']) ? $certificate[0]['cid'] : '' ?>">
                                <label>Income</label>
                                <input type="hidden" name="cnm[]" value="Income" readonly></td>
                              <td><div class="form-group"><input type="text" name="cno[]" class="form-control" value="<?= isset($certificate[0]['certificate_no']) ? $certificate[0]['certificate_no'] : '' ?>" required="true" /></div></td>
                              <td><div class="form-group">
                                  <div class="input-group date" id="doc-sub-datepicker17">
                                    <input type="text" id="issuedt1" name="issuedt[]" class="form-control" value="<?= isset($certificate[0]['cissue_dt']) ? $certificate[0]['cissue_dt'] : '' ?>" placeholder="Document issue Date" />
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span> </div>
                                </div></td>
                              <td><div class="form-group"><div class="input-group date"><input type="text" class="form-control"name="cval[]" id="cvaldt1" value="<?= isset($certificate[0]['cvalidity']) ? $certificate[0]['cvalidity'] : '' ?>"><span class="input-group-addon"><i class="fa fa-calendar"></i></span></div></div></td>
                            </tr>
                            <tr>
                              <td><input type="hidden" name="cert_id[]" class="form-control" value="<?= isset($certificate[1]['cid']) ? $certificate[1]['cid'] : '' ?>">
                                <label>Cast-category</label>
                                <input type="hidden"name="cnm[]" value="Cast-category" readonly></td>
                              <td><input type="text" name="cno[]" class="form-control" value="<?= isset($certificate[1]['certificate_no']) ? $certificate[1]['certificate_no'] : '' ?>"/></td>
                              <td><div class="form-group">
                                  <div class="input-group date" id="doc-sub-datepicker18">
                                    <input type="text" id="issuedt2" name="issuedt[]" class="form-control" value="<?= isset($certificate[1]['cissue_dt']) ? $certificate[1]['cissue_dt'] : '' ?>" placeholder="Document issue Date" />
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span> </div>
                                </div></td>
                              <td><div class="form-group"><div class="input-group date"><input type="text" class="form-control" name="cval[]" id="cvaldt2" value="<?= isset($certificate[1]['cvalidity']) ? $certificate[1]['cvalidity'] : '' ?>"><span class="input-group-addon"><i class="fa fa-calendar"></i></span></div></div></td>
                            </tr>
                            <tr>
                              <td><input type="hidden" name="cert_id[]" value="<?= isset($certificate[2]['cid']) ? $certificate[2]['cid'] : '' ?>">
                                <label>Residence-State Subject</label>
                                <input type="hidden" name="cnm[]" value="Residence-State Subject" readonly></td>
                              <td><input type="text" name="cno[]" class="form-control" value="<?= isset($certificate[2]['certificate_no']) ? $certificate[2]['certificate_no'] : '' ?>"/></td>
                              <td><div class="form-group">
                                  <div class="input-group date" id="doc-sub-datepicker19">
                                    <input type="text" id="issuedt3" name="issuedt[]" class="form-control" value="<?= isset($certificate[2]['cissue_dt']) ? $certificate[2]['cissue_dt'] : '' ?>" placeholder="Document issue Date" />
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span> </div>
                                </div></td>
                              <td><div class="form-group"><div class="input-group date"><input type="text" name="cval[]" id="cvaldt3" class="form-control" value="<?= isset($certificate[2]['cvalidity']) ? $certificate[2]['cvalidity'] : '' ?>"><span class="input-group-addon"><i class="fa fa-calendar"></i></span></div></div></td>
                            </tr>
                          </table>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-sm-4"></div>
                       <div class="col-sm-2">
                          <button class="btn btn-primary nextBtn form-control" type="button" > Next</button>
                        </div>

                     </div>
                 
                  </div>
                  <!--end of documents-certificates --> 
                  <!--start  of references -->
                  <div id="references" class="setup-content widget-threads panel-body tab-pane fade">

                      <div class="panel">
                        <div class="panel-heading">References details</div>
                        <div class="panel-body">
                          <label class="col-sm-6">References(Other than Blood Relatives)</label>
                          <table class="table table-bordered">
                            <tr>
                              <td width="14px">Sr No.</td>
                              <td>Reference Name</td>
                              <td>Contact Number</td>
                            </tr>
                            <tr>
                              <td>1</td>
                              <td width="45%"><div class="form-group"><input type="text" name="fref1" value="" class="form-control w300" required/></div></td>
                              <td><div class="form-group"><input type="text" name="frefcont1" class="numbersOnly form-control w155" maxlength="10" value="<?= isset($references[0]['for_stud_refer_cont1']) ? $references[0]['for_stud_refer_cont1'] : '' ?>" class="form-control" required></div></td>
                            </tr>
                            <tr>
                              <td>2</td>
                              <td><input type="text" class="form-control w300" name="fref2" value="<?= isset($references[0]['for_stud_refer_name2']) ? $references[0]['for_stud_refer_name2'] : '' ?>"/></td>
                              <td><input type="text" class="form-control numbersOnly w155" name="frefcont2" maxlength="10" value="<?= isset($references[0]['for_stud_refer_cont2']) ? $references[0]['for_stud_refer_cont2'] : '' ?>" ></td>
                            </tr>
                          </table>
                          <table class="table table-bordered" id="ref_sandip">
                            <tr >
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
                      </div>
                      <div class="panel">
                        <div class="panel-heading">How Did You Come To Know About Sandip University</div>
                        <div class="panel-body">
                          <div class="form-group">
                            <label class="col-sm-3">Select The Publicity Media:</label>
                            <div class="col-sm-8">
                              <select name="publicitysandip[]" multiple="multiple" >
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
                              </select>
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
                              <input data-bv-field="refcandidatecont" id="refcandidatecont" name="refcandidatecont" class="form-control" maxlength="10" value="<?= isset($references[0]['ref_bystud_cont']) ? $references[0]['ref_bystud_cont'] : '' ?>" placeholder="Candidate contact" type="text">
                            </div>
                          </div>
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
                  <!--end of references --> 
                  <!--start  of photos -->
                  
                  <div id="payment-photo" class="setup-content widget-threads panel-body tab-pane fade">
                   <input type="hidden" name="reg_id" value="<?= $this->session->userdata('student_id') ?>">
                      <input type="hidden" name="step1statusval" value="<?= $this->session->userdata('stepfirst_status') ?>">
                      <input type="hidden" name="step2statusval" value="<?= $this->session->userdata('stepsecond_status') ?>">
                      <input type="hidden" name="step3statusval" value="<?= $this->session->userdata('stepthird_status') ?>">
                      <input type="hidden" name="step4statusval" value="<?= $this->session->userdata('stepfourth_status') ?>">
                      <div class="panel">
                        <div class="panel-heading">Payment Details
                          <?= $astrik ?>
                       </div>
                        <div class="panel-body">
                          <table class="table table-bordered">
                            <tr>
                              <th>particulars</th>
                              <th>Academic Fee</th>
							  <th>Exepmted Fee</th>
                              <th>Applicable Fee</th>
                              <th>Amount Paid</th>
                              <th>Balance(if any)</th>
                              
                            </tr>
                            <!-- <tr>
                              <td>Admission Form/prospectus Fee(Not to pay if already paid)</td>
                              <td><input type="text" id="txt1" name="formfeeappli" onkeyup="sub();" value="<?= isset($fee[0]['formfeeappli']) ? $fee[0]['formfeeappli'] : '' ?>"></td>
                              <td><input type="text" id="txt2" name="formfeepaid" onkeyup="sub();" value="<?= isset($fee[0]['formfeepaid']) ? $fee[0]['formfeepaid'] : '' ?>"></td>
                              <td><input type="text" id="txt3" name="formfeebal" onkeyup="sub();" value="<?= isset($fee[0]['formfeebal']) ? $fee[0]['formfeebal'] : '' ?>"></td>
                              
                            </tr>
                           <tr>
                              <td>Tution Fee</td>
                              <td><input type="text" id="txt11" name="tutionfeeappli" value="<?= isset($fee[0]['tutionfeeappli']) ? $fee[0]['tutionfeeappli'] : '' ?>" onkeyup="sub1();" ></td>
                              <td><input type="text" id="txt12" name="tutionfeepaid" value="<?= isset($fee[0]['tutionfeepaid']) ? $fee[0]['tutionfeepaid'] : '' ?>" onkeyup="sub1();"></td>
                              <td><input id="txt13" type="text" name="tutionfeebal" value="<?= isset($fee[0]['tutionfeebal']) ? $fee[0]['tutionfeebal'] : '' ?>" onkeyup="sub1();"></td>
                            </tr>
                            <tr>
                              <td>Other</td>
                              <td><input type="text" id="txt21" name="otherfeeappli" value="<?= isset($fee[0]['otherfeeappli']) ? $fee[0]['otherfeeappli'] : '' ?>" onkeyup="sub2();"></td>
                              <td><input id="txt22" type="text" name="otherfeepaid" value="<?= isset($fee[0]['otherfeepaid']) ? $fee[0]['otherfeepaid'] : '' ?>"  onkeyup="sub2();"></td>
                              <td><input type="text" id="txt23" name="otherfeebal" value="<?= isset($fee[0]['otherfeebal']) ? $fee[0]['otherfeebal'] : '' ?>" onkeyup="sub2();"></td>
                            </tr>-->
                            <tr>
                              <td>Total fee</td>
                              <td><input type="text" id="txt_acd" name="acd_totalfee" value="<?= isset($fee[0]['totalfeeappli']) ? $fee[0]['totalfeeappli'] : '' ?>" onkeyup="sub3();" style="width:100px" readonly></td>
							  <td><input type="text" id="txt_exempt" name="exepmted_fee" value="<?= isset($fee[0]['totalfeeappli']) ? $fee[0]['totalfeeappli'] : '' ?>" onkeyup="sub3();" style="width:100px" readonly></td>
                              <td><input type="text" id="txt31" name="totalfeeappli" value="<?= isset($fee[0]['totalfeeappli']) ? $fee[0]['totalfeeappli'] : '' ?>" onkeyup="sub3();" style="width:100px" readonly></td>
                              <td><input type="text" id="txt32" name="totalfeepaid" value="<?= isset($fee[0]['totalfeepaid']) ? $fee[0]['totalfeepaid'] : '' ?>" onblur="cal_balance_left();" style="width:100px" required></td>
                              <td><input type="text" id="txt33" name="totalfeebal" value="<?= isset($fee[0]['totalfeebal']) ? $fee[0]['totalfeebal'] : '' ?>" onkeyup="sub3();" style="width:100px" readonly></td>
                            </tr>
                          </table>
                          <div class="panel">
                            <div class="panel-heading">Paid Details <?= $astrik ?>
                                <div class="panel-body">
                                  <div class="form-group">
                                    <label class="col-sm-3">Payment of Rs</label>
                                    <div class="col-sm-3">
                                      <input data-bv-field="paidfee" id="paidfee" name="paidfee" class="form-control" value="<?= isset($fee[0]['totalfeepaid']) ? $fee[0]['totalfeepaid'] : '' ?>" placeholder="Paid Fee" type="text" required readonly>
                                    </div>
                                    <label class="col-sm-3">Payment Type</label>
                                    <div class="col-sm-3">
                                    <select name="payment_type" id="payment_type" class="form-control" required>
                                        <option value="">Select Payment Type</option>
									<option value="CHQ">Cheque</option>
									<option value="DD">DD</option>
									<option value="CHLN">Chalan</option>
									
									</select>
									
									
                                    </div>
                                  </div>
                                  <div class="form-group">
								  
								   <label class="col-sm-3"> Cheque/DD No./Chalan No.</label>
                                    <div class="col-sm-3">
                                      <input type="text" name="dd_no" class="form-control" required value="<?= isset($fee[0]['dd_no']) ? $fee[0]['dd_no'] : '' ?>" placeholder="DD No." required>
                                    </div>
									
                                    <label class="col-sm-3">Dated</label>
                                    <div class="col-sm-3">
                                      <input type="text" class="form-control" id="doc-sub-datepicker20" name="dd_date" required value="<?= isset($fee[0]['dd_drawn_date']) ? $fee[0]['dd_drawn_date'] : '' ?>" placeholder="DD Date" required/>
                                    </div>
                                    
                                    <div class="col-sm-6">
                                      
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label class="col-sm-3">Bank name</label>
                                    <div class="col-sm-3">
                                     <!-- <input type="text" id="dd_bank" name="dd_bank" class="form-control" value="<?= isset($fee[0]['dd_drawn_bank_branch']) ? $fee[0]['dd_drawn_bank_branch'] : '' ?>" placeholder="Bank & Branch">-->
									  
									  
									                                  <select name="dd_bank" id="dd_bank" class="form-control" required>
                                  <option value="">Select</option>
                                  <?php
foreach ($bank_details as $branch) {
  
    echo '<option value="' . $branch['bank_id'] . '" ' . $sel . '>' . $branch['bank_name'] . '</option>';
}
?>
                               </select>
									  
									  
									  

                                    </div>
                                    <label class="col-sm-3"> Branch Name.</label>
                                    <div class="col-sm-3">
                                      <input type="text" id="dd_bank_branch" name="dd_bank_branch" class="form-control" value="" placeholder="Branch Name" required>
                                    </div>
                                  </div>
                                  
                                  <div class="form-group">
								  
								   <label class="col-sm-3">Upload document</label>
                                    <div class="col-sm-3"><input type="file" name="payfile">
                                        </div>
                                  </div>
                                  
                                </div>
                            </div>
                         </div>
                       
                       <div class="panel">
                            <div class="panel-heading">Student Personal Account Details
                                <div class="panel-body">   
                                  <div class="form-group">
                                    <label class="col-sm-3">Bank Name</label>
                                    <div class="col-sm-3">
									
									                                  <select name="bank_name" id="bank_name" class="form-control">
                                  <option value="">Select</option>
                                  <?php
foreach ($bank_details as $branch) {
  
    echo '<option value="' . $branch['bank_id'] . '" ' . $sel . '>' . $branch['bank_name'] . '</option>';
}
?>
                               </select>
									
									
									
                                      <!--<input type="text" id="bank_name" name="bank_name" class="form-control" value="<?= isset($fee[0]['bank_name']) ? $fee[0]['bank_name'] : '' ?>" placeholder="BOI Account No." />-->
                                    </div>
                                    <label class="col-sm-3"> Bank Account No.</label>
                                    <div class="col-sm-3">
                                      <input type="text" id="account_no" name="account_no" class="form-control" value="<?= isset($fee[0]['account_no']) ? $fee[0]['account_no'] : '' ?>" placeholder="Other Bank Account No." />
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label class="col-sm-3">IFSC code</label>
                                    <div class="col-sm-3">
                                      <input type="text" id="ifsc" name="ifsc" class="form-control" value="<?= isset($fee[0]['ifsc']) ? $fee[0]['ifsc'] : '' ?>" placeholder="IFSC code" />
                                    </div>
                                    
                                     <label class="col-sm-3">Bank Branch</label>
                                    <div class="col-sm-3">
                                      <input type="text" id="bank_branch" name="bank_branch" class="form-control" value="<?= isset($fee[0]['ifsc']) ? $fee[0]['ifsc'] : '' ?>" placeholder="Bank Branch" />
                                    </div>
                                  </div>
                                   </div>
                                </div>
                            </div>
                        </div>
                      </div>
                      <div class="panel">
                        <div class="panel-heading">Photo Uplod
                          <?= $astrik ?>
                       </div>
                        <div class="panel-body">
                          <div class="form-group">
                            <label class="col-sm-3">Upload Photo:</label>
                            <?php
if (!empty($fee[0]['profile_img'])) {
    $profile = base_url() . "uploads/student_profilephotos/" . $fee[0]['profile_img'];
} else {
    $profile = "";
}
?>
                           <input type="hidden" name="profile_img" value="<?= isset($fee[0]['profile_img']) ? $fee[0]['profile_img'] : '' ?>">
                            <img id="blah" alt="Student Profile image" src="<?php
echo $profile;
?>"width="100" height="100" border="1px solid black" />
                            <input type="file" name="profile_img" value="<?= isset($fee[0]['profile_img']) ? $fee[0]['profile_img'] : '' ?>" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-sm-4"></div>
                        <div class="col-sm-2">
                         <button class="btn btn-success btn-lg pull-right" type="submit">Submit</button>
                        </div>
                        
                     </div>
                   
                  </div>
                  <!--end of photos --> 
                  
				  
				
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

<script type="text/javascript">
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
    	  $(streamId).html("<option value=''>-select-</option><option value='Arts'>Arts</option><option value='Commerce'>Commerce</option><option value='Science'>Science</option>");
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
    var total_balance=parseInt(fee_appli)-parseInt(fee_paid);
    //alert(fee_appli);alert(fee_paid);
    if (!isNaN(total_balance)) {
        document.getElementById('txt33').value = total_balance;
        document.getElementById('paidfee').value = fee_paid;
    }
  }
  //check duplicate mobile no
    function chek_mob_exist(mob_no) {
		if (mob_no) {
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
		} else {
			
		}
  }
  
function validatePercentage(x) {
    alert(x);
    alert(hi);
    var str="x.2";
    alert(str);
    var parts = str.split(".");
    alert(parts[1]);
    /*if (typeof parts[1] == "string" && (parts[1].length == 0 || parts[1].length > 2)){
         alert("Not");
        return false;
    }
    var n = parseFloat(x);
    alert(n)
    if (isNaN(n)){
        alert("Not number");
        return false;
    }
    if (n < 0 || n > 100){
         alert("Not valid");
        return false;
    }*/
    return true;
}
////////////////////////////////////////////////////////////////////////////

$(document).ready(function(){
    
    // payment calculations
    $('#paymnt').on('click', function () {
		var strm_id = $("#admission-stream").val();
		//alert(strm_id);
		if (strm_id) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Ums_admission/fetch_academic_fees_for_stream',
				data: 'strm_id=' + strm_id,
				success: function (resp) {
					//alert(resp)
					var obj = jQuery.parseJSON(resp);	
					var tot_fees =parseInt(obj[0].total_fees); 
					var total_fees =parseInt(obj[0].tution_fees); 
					var su_jee_per = parseFloat($("#super").val());
					var mhcet_mrks = parseInt($("#mhcet_obt_marks").val());
					var othr_mrks = parseInt($("#othr_obt_marks").val());
					//alert(su_jee_per);
					//alert(mhcet_mrks);
					//alert(total_fees);
					
					if(mhcet_mrks >0){						
					}else{
						mhcet_mrks =0;
					}
					if(othr_mrks >0){						
					}else{
						othr_mrks =0;
					}
					if(su_jee_per > 0){
						//alert("SU");
						if (su_jee_per >= 90 && su_jee_per <= 100) 
						{
							var exepmted_fees = total_fees;
						}else if(su_jee_per >= 86 && su_jee_per <= 89)
						{
							var exepmted_fees = total_fees * 0.5;
						}else if(su_jee_per >= 75 && su_jee_per <= 85)
						{
							var exepmted_fees = total_fees * 0.25;
						}else{
							var exepmted_fees = parseInt(0);
						}
					}else if(mhcet_mrks > othr_mrks){
						//alert("MH");
						if (mhcet_mrks >= 130 && mhcet_mrks <= 150) 
						{
							var exepmted_fees = total_fees;
						}else if(mhcet_mrks >= 115 && mhcet_mrks <= 129)
						{
							var exepmted_fees = total_fees * 0.5;
						}else if(mhcet_mrks >= 105 && mhcet_mrks <= 114)
						{
							var exepmted_fees = total_fees * 0.25;
						}else{
							var exepmted_fees = parseInt(0);
						}
					}else if(othr_mrks > mhcet_mrks){
						//alert("OTh");
						if (othr_mrks >= 130 && othr_mrks <= 150) 
						{
							var exepmted_fees = total_fees;
						}else if(othr_mrks >= 115 && othr_mrks <= 129)
						{
							var exepmted_fees = total_fees * 0.5;
						}else if(othr_mrks >= 105 && othr_mrks <= 114)
						{
							var exepmted_fees = total_fees * 0.25;
						}else{
							var exepmted_fees = parseInt(0);
						}
					}else{
						//alert("else");
						var exepmted_fees = parseInt(0);
					}

					//alert(total_fees);
					//alert(exepmted_fees);
					
					var final_fee = tot_fees - exepmted_fees;
					//alert(final_fee);
					$("#txt_acd").val(tot_fees);
					$("#txt_exempt").val(exepmted_fees);
					$("#txt31").val(final_fee);
					//$('#suJeexamtable').html(html);
				}
			});
		} else {
			//alert("Please enter registration no");

		}
	});
    /////////////
    $("tr.person_sandp").hide();
    $("tr.alumini_sandip").hide();
    $("tr.relativ_sandip").hide();
    
    $('#reletedsandip').change(function(){
        var reletedsandip = $("#reletedsandip").val();
        if(reletedsandip=='Y')
        $("tr.person_sandp").show();
        else
        $("tr.person_sandp").hide();

    });
    
    $('#aluminisandip').change(function(){
        var aluminisandip = $("#aluminisandip").val();
        if(aluminisandip=='Y')
        $("tr.alumini_sandip").show();
        else
        $("tr.alumini_sandip").hide();

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
		if($(this).is(":checked"))
		$('#schlr_div').fadeIn('slow');
		else
		$('#schlr_div').fadeOut('slow');
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
    $('#dob-datepicker').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
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
            //alert(qid);
			var fieldshtml = "<tr><td> <div class='form-group'><select name='exam_id[]' id='studqual_"+x+"' class='squal form-control' onchange='qualifcation("+'"'+qid+'"'+")' required><option value=''>Select</option><option value='SSC'>SSC</option><option value='HSC'>HSC</option><option value='Graduation'>Graduation</option><option value='Post Graduation'>Post Graduations</option><option value='Diploma'>Diploma</option></select></div>   </td><td><select name='stream_name[]' id='stream_name_"+x+"' onchange='strmsubject("+'"'+strm+'"'+")' style='width:85px' class='form-control' required><option value=''>Select</option> </select></td><td><div class='form-group'><input type='text' name='seat_no[]' class='form-control' value='' placeholder='Specialization' /></td></div><td><input type='text' name='institute_name[]' class='form-control' value='' placeholder='Name of Board/University' required /></td><td><select name='pass_year[]' class='form-control' required><option value=''>Year</option><?php  for ($y = date('Y'); $y >= date('Y') - 60; $y--) {  ?> <option value='<?=$y?>'><?=$y?></option><? }?></select><select name='pass_month[]' class='form-control' required><option value=''>Month</option><option value='JAN'>JAN</option><option value='FEB'>FEB</option><option value='MAR'>MAR</option><option value='APR'>APR</option><option value='MAY'>MAY</option><option value='JUN'>JUN</option><option value='JUL'>JUL</option><option value='AUG'>AUG</option><option value='SEP'>SEPT</option><option value='OCT'>OCT</option><option value='NOV'>NOV</option><option value='DEC'>DEC</option></select></td><td><input type='text' name='marks_obtained[]' class='numbersOnly form-control' maxlength='4' value='' required/></td><td><input type='text' name='marks_outof[]' class='numbersOnly form-control' maxlength='4' value='' placeholder='' required/></td><td><input type='text' name='percentage[]' class='form-control' maxlength='5' value='' placeholder='' required/></td><td><input type='file' name='sss_doc[]' id='sss_doc' style='width:80px' required></td><td><input type='button' class='remove_field btn btn-xs btn-danger btn-flat' id='remove' value='Remove' name='remove' /></td></tr>";
		
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