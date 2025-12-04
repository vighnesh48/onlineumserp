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
           <?php
              if($acfees[0]['total_fees']=='')
              {
                 ?>
                   <div class="form-group"><span style="color:red"><strong>***Academic Fees for selected academic year and stream not Updated. Hence student can not be Confirmed Please contact finance section</strong></span>
                           </div>
                            
                 <?php
              }
              else
              {
                  
            ?>          
          <form id="form1" name="form1" action="<?= base_url($currentModule . '/prov_admission_submit') ?>" method="POST" enctype="multipart/form-data">
            <div class="xtable-info"> 
              <!--<label>Note:<span>Fields marked with asterisk(<?= $astrik ?>) are mandatory to be filled.</span></label>-->
              <input type="hidden" id="adm_id" name="adm_id" value="<?=$stud_det['prov_reg_no']?>">
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
				  
				    
                     <?php
                     //var_dump($stream_det);
                     ?>
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
                              <label class="col-sm-3">Academic Year <?= $astrik ?></label>
                              <div class="col-sm-3">
                               
                                      <select id="acyear" name="acyear" class="form-control" required>
                                <!--  <option value="">Select Academic Year</option>-->
                                  <!-- <option value="2016">2016-17</option>-->
                                     <?php $number = range(2018,date("Y")); 
                                    foreach ($number as $key => $value) {
                                        $yea=substr($value,2);
                                        $yea=$yea+1;
                                        $showyear=$value."-".$yea;
                                        if($value==date("Y"))
                                        {
                                            $selected='selected';
                                        }
                                        else
                                        {
                                            $selected='';
                                        }
                                        echo "<option value='$value' ".$selected." >$showyear</option>";
                                        # code...
                                    }

                                    ?>
                           
                               </select>
                               
                               
                                </div>
                                
                                
                                     <label class="col-sm-3">Student GRN Number</label>
                              <div class="col-sm-3">
                         <input type="text" id="sgrn" name="sgrn" class="form-control" value="" placeholder="Student GRN Number" />
                              </div>
							  </div>
							  
							  
                                  <div class="form-group">
                              <label class="col-sm-3">Admission Type <?= $astrik ?></label>
                              <div class="col-sm-3">
                               
                                      <select name="admission_type" name="admission_type" class="form-control" required>
                                  <option value="">Select Type</option>
                                   <option value="1" <?php if($stud_det['admission_year']=='1'){echo "selected";} ?>>First Year</option>
                                    <option value="2" <?php if($stud_det['admission_year']=='2'){echo "selected";} ?>>Lateral Entry</option>
                                 
                               </select>
                               
                               
                                </div>
                                
                                
                                
                                
                                       <label class="col-sm-3">Admission Form Number <?= $astrik ?></label>
                              <div class="col-sm-3">
                               
                                <input id="sfnumber" name="sfnumber" class="form-control" value="<?=$stud_det['adm_form_no']?>" placeholder="Admission Form Number " type="text" >
                               
                               
                               
                                </div>
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                              </div>
                              
                              
                              
                              
                               <div class="form-group">
                              <label class="col-sm-3">School <?= $astrik ?></label>
                              <div class="col-sm-3" >
                                <select name="admission-school" class="form-control" onchange="load_courses(this.value)" required>
                              
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
                                <select name="admission-course" id="admission-course"  class="form-control" onchange="load_streams(this.value)" required>
                                  <option value="">Select</option>
                                  <?php
foreach ($course_list as $course) {
    if ($course['course_id'] == $stream_det[0]['course_id']) {
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
                   var acyear = '2017-18';
                    var year ='<?=$stud_det['admission_year'];?>';
                $.ajax({
                    'url' : base_url + 'Ums_admission/load_courses',
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
                   var acyear = '2017-18';
                    var year ='<?=$stud_det['admission_year'];?>';
                $.ajax({
                    'url' : base_url + 'Ums_admission/load_streams',
                    'type' : 'POST', //the way you want to send data to your URL
                    'data' : {'course' : type,'acyear':acyear,'year':year},
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
                              <label class="col-sm-3">Stream <?= $astrik ?></label>
                              <div class="col-sm-3" id="semest" >
                                <select name="admission-branch" class="form-control" required>
                                  <option value="">Select</option>
                                  <?php
foreach ($stream_list as $branch) {
    if ($branch['stream_id'] == $stream_det[0]['stream_id']) {
        $sel = "selected";
    } else {
        $sel = '';
    }
    echo '<option value="' . $branch['stream_id'] . '" ' . $sel . '>' . $branch['stream_short_name'] . '</option>';
}
?>
                               </select>
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="col-sm-3">Student Name <?= $astrik ?></label>
                              <?php
                              $stname = explode(" ",$stud_det['student_name']);
                              ?>
                             <!-- <div class="col-sm-3">
                               Last Name <input data-bv-field="slname" id="slname" name="slname" class="form-control" value="<?=$stname[2] ?>" placeholder="Last Name" type="text">
                                </div>
                              <div class="col-sm-3">
                                Student Name<input data-bv-field="sfname" id="sfname" name="sfname" class="form-control" value="<?= $stname[0] ?>" placeholder="First Name" type="text">
                               </div>
                              <div class="col-sm-3">
                               Middle Name <input data-bv-field="smname" id="smname" name="smname" class="form-control" value="<?= $stname[1] ?>" placeholder="Middle Name" type="text">
                                </div>-->
                               
                              <div class="col-sm-5">
                                <input data-bv-field="slname" id="sfname" name="sfname" class="form-control" value="<?=$stud_det['student_name']?>" placeholder="Student Name as per last qualifying Exam" type="text">
                                </div>
                            </div>
                            <div class="form-group">
                              <label class="col-sm-3">Father's/Husband Name <?= $astrik ?></label>
                              
                              <div class="col-sm-5">
                                <input data-bv-field="sfname" id="sfname1" name="sfname1" class="form-control" value="" placeholder="Father's/Husband Name " type="text">
                                </div>
                            <!--  <div class="col-sm-3">
                                <input data-bv-field="slname" id="slname1" name="slname1" class="form-control" value="" placeholder="Last Name" type="text">
                                </div>
                              <div class="col-sm-3">
                                <input data-bv-field="sfname" id="sfname1" name="sfname1" class="form-control" value="" placeholder="First Name" type="text">
                                </div>
                              <div class="col-sm-3">
                                <input data-bv-field="smname" id="smname1" name="smname1" class="form-control" value="" placeholder="Middle Name" type="text">
                                </div>-->
                            </div>
                            <div class="form-group">
                              <label class="col-sm-3">Mother Name <?= $astrik ?></label>
                              <div class="col-sm-3">
                                <input data-bv-field="sfname" id="sfname2" name="sfname2" class="form-control" value="" placeholder="First Name" type="text">
                                <i data-bv-icon-for="sfname" class="form-control-feedback" style="display: none; top: 0px;"></i><small data-bv-result="NOT_VALIDATED" data-bv-for="sfname" data-bv-validator="notEmpty" class="help-block" style="display: none;">First name should not be empty</small><small data-bv-result="NOT_VALIDATED" data-bv-for="sfname" data-bv-validator="regexp" class="help-block" style="display: none;">First name should be alphabate characters</small><small data-bv-result="NOT_VALIDATED" data-bv-for="sfname" data-bv-validator="stringLength" class="help-block" style="display: none;">First name should be 2-50 characters.</small> </div>
                                
                              <label class="col-sm-3">Aadhar Card No </label>
                              <div class="col-sm-3">
                                <input type="text" id="saadhar" maxlength="12" value="<?= isset($stud_det['adhar_no']) ? $personal['adhar_no'] : ''; ?>" name="saadhar" class="numbersOnly form-control" >
                              
                            </div>
                            </div>
                            <div class="form-group">
                              <label class="col-sm-3">Date of Birth <?= $astrik ?></label>
                              <div class="col-sm-3 date" id="dob-datepicker">
                                  <div class="input-group">
                                <input type="text" id="dob" name="dob" class="form-control"  value="<?php if($stud_det['dob']=='NULL' || $stud_det['dob']==''|| $stud_det['dob']=='1970-01-01'){ } else { echo date('d-m-Y',strtotime($stud_det['dob']));} ?>" placeholder="Date of Birth"  />
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span> </div></div>
                                
                                
                                  <label class="col-sm-3">Place Of Birth <?= $astrik ?></label>
                              <div class="col-sm-3 ">
        <input type="text" id="pob" name="pob" class="form-control"  value="" placeholder="Place of Birth" />
                                </div>
                                
                                
                            </div>
                            <div class="form-group">
                              <label class="col-sm-3">Gender <?= $astrik ?></label>
                             <div class="col-sm-4">
                                <label>
                                  <input type="radio" value="M" id="gender" name="gender" <?php if($stud_det['gender']=='M'){echo "checked";} ?>  required>
                                  Male</label>
                                      <label>
                                  <input type="radio" value="F" id="gender" name="gender" <?php if($stud_det['gender']=='F'){echo "checked";} ?> required>
                                 Female</label>
                           
                                <label>
                                  <input type="radio" value="T" id="gender" name="gender" <?php if($stud_det['gender']=='T'){echo "checked";} ?> required>
                                 Transgender</label>
                              </div>
                              
                              <label class="col-md-2 control-label">Blood Group:<?=$astrik?></label>
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
                                <input type="text" id="mobile" name="mobile" class="form-control numbersOnly" value="<?=$stud_det['mobile1']?>" placeholder="contact no" maxlength="10" onblur="return chek_mob_exist(this.value)"  />
                              </div>
                              <label class="col-sm-3">Email</label>
                              <div class="col-sm-3">
                                <input type="email" id="email_id" name="email_id" class="form-control" value="<?=$stud_det['email']?>" placeholder="Email" />
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="col-sm-3">Nationality </label>
                              <div class="col-sm-3">
                                <input type="text" id="nationality" name="nationality" class="form-control" value="Indian" placeholder="" />
                              </div>
                              <label class="col-sm-3">Category <?= $astrik ?></label>
                              <div class="col-sm-3">
                                <select id="category" name="category" class="form-control" >
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
                                <input type="text" id="doadd" name="doadd" class="form-control"  value="<?= isset($stud_det['doa']) ? date('d-m-Y',strtotime($stud_det['doa'])) : ''; ?>" placeholder="Date of Admission"  />
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span> </div></div>
                                
                           
                                
                                
                            </div>
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            <div class="form-group">
                              <label class="col-sm-3">Religion <?= $astrik ?></label>
                              <div class="col-sm-3">
                                <select id="religion" name="religion" class="form-control" >
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

                                 <option value="MS">MS</option>
                                  <option  value="OMS">OMS</option>
                                      <option  value="NRI">NRI</option>
                                          <option  value="PIO">PIO</option>
                                       
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
                              <th>Local Address</th>
                              <th>Permanent Address</th>
                            </tr>
                              <tr>
                            
                            <!--Local Address-->
                            <td width="47%">
                            <div class="form-group">
                                <label  class="col-sm-3">Address: <?=$astrik?></label>
                                <div class="col-sm-6">
                                  <textarea id="laddress" class="form-control" NAME="laddress" style="margin: 0px; width: 200px; height: 50px;" ><?=$stud_det['address'] ?></textarea>
                                </div>
                              </div>

                              <div class="form-group">
                                <label  class="col-sm-3">State: <?=$astrik?></label>
                                <div class="col-sm-6">
                                  <select class="form-control" name="lstate_id" id="lstate_id" >
                                      <option value="">select State</option>
                                      <?php
                                        if(!empty($states)){
                                            foreach($states as $stat){
                                                ?>
                                              <option value="<?=$stat['state_id']?>" <?php if($stud_det['state_id']==$stat['state_id']){echo "selected";} ?>><?=$stat['state_name']?></option>  
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
                                  <select class="form-control" name="ldistrict_id" id="ldistrict_id" >
                                      <option value="">select District</option>
                                      <?php
                                        if(!empty($district)){
                                            foreach($district as $district){
                                                ?>
                                              <option value="<?=$district['district_id']?>"><?=$district['district_name']?></option>  
                                            <?php 
                                                
                                            }
                                        }
                                      ?>
                                  </select>
                                </div>
                              </div>
                              <div class="form-group">
                                <label  class="col-sm-3">City: <?=$astrik?></label>
                                <div class="col-sm-6">
                                   <select class="form-control" name="lcity" id="lcity" >
                                      <option value="">select City</option>
                                  </select>
                                </div>
                              </div>
                              <div class="form-group">
                                <label  class="col-sm-3">Pin Code: <?=$astrik?></label>
                                <div class="col-sm-6">
                                  <INPUT TYPE="TEXT" class="form-control numbersOnly" id="lpincode" maxlength="6" NAME="lpincode" value="<?= $stud_det['pincode']?>" >
                                </div>
                              </div>
                              </td>
                            <!--Permanent Address-->
                            
                              <td width="50%">
                             
                            
                               <div class="form-group">
                                <label  class="col-sm-3">Address: <?=$astrik?></label>
                                <div class="col-sm-6">
                                  <textarea id="paddress" class="form-control" NAME="paddress" style="margin: 0px; width: 200px; height: 50px;" ></textarea>
                                </div>
                              </div>

                              <div class="form-group">
                                <label  class="col-sm-3">State: <?=$astrik?></label>
                                <div class="col-sm-6">
                                  <select class="form-control" name="pstate_id" id="pstate_id" >
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
                                  <select class="form-control" name="pdistrict_id" id="pdistrict_id" >
                                      <option value="">select District</option>
                                  </select>
                                </div>
                              </div>
                              <div class="form-group">
                                <label  class="col-sm-3">City: <?=$astrik?></label>
                                <div class="col-sm-6">
                                   <select class="form-control" name="pcity" id="pcity" >
                                      <option value="">select City</option>
                                  </select>
                                </div>
                              </div>
                              <div class="form-group">
                                <label  class="col-sm-3">Pin Code: <?=$astrik?></label>
                                <div class="col-sm-6">
                                  <INPUT TYPE="TEXT" class="form-control numbersOnly" id="ppincode" maxlength="6" NAME="ppincode" value="" >
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
                          <!--<div class="form-group">
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
                          </div>-->
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
                            <label class="col-sm-3">Mobile</label>
                            <div class="col-sm-3">
                              <input type="text" id="parent_mobile" name="parent_mobile" class="form-control numbersOnly" maxlength="10" value="<?= isset($personal[0]['gparent_mobile']) ? $personal[0]['gparent_mobile'] : '' ?>" maxlength="10"/>
                            </div>
                          </div>
                         <!-- <div class="form-group">
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
                              </div>-->
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-sm-4"></div>


                       <div class="col-sm-2">
                          <button class="btn btn-primary nextBtn form-control" id=""  >Next</button>
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
                                      <th>CGPA / SGPA</th>
                                     <th>Grade</th>  
                                    <th>Docs</th>
                                    <th>Action</th>
                                  </tr>
                                </thead>
                                <tbody>




			<?php
								$j=10;
							//	var_dump();
									if(!empty($edu_det)){
										foreach($edu_det as $var){
										
								?>
								<tr id="firsttr">
                                    <td> <div class="form-group">
                                        <select name="exam_id[]" id="studqual_<?=$j?>" class="squal form-control" onchange="qualifcation(this.id)">
                                        <option value="">Select</option>
                                        <option value="SSC" <?php if(!empty($var['qualification']) && $var['qualification']=='SSC'){ echo "selected";}?>>SSC</option>
                                        <option value="HSC" <?php if(!empty($var['qualification']) && $var['qualification']=='HSC'){ echo "selected";}?>>HSC</option>
                                        <option value="Graduation" <?php if(!empty($var['qualification']) && $var['qualification']=='Graduation'){ echo "selected";}?>>Graduation</option>
                                        <option value="Post Graduation" <?php if(!empty($var['qualification']) && $var['qualification']=='Post Graduation'){ echo "selected";}?>>Post Graduation's</option>
                                        <option value="Diploma" <?php if(!empty($var['qualification']) && $var['qualification']=='Diploma'){ echo "selected";}?>>Diploma</option>
                                      </select>
                                        </div>  
                                    </td>
                                    <td> 
                                    <select name="stream_name[]" id="stream_name_<?=$j?>" onchange="strmsubject(this.id)" style="width:85px" class="form-control">
                                        <option value="">Select</option>
										<option value="<?=$var['specialization']?>" selected><?=$var['specialization']?></option>
                                      </select>
                                        
                                    </td>
                                   
                                    <td><div class="form-group">
										<input type="hidden" name="qual_id[]" class="form-control" value="<?= isset($var['qual_id']) ? $var['qual_id'] : '' ?>" placeholder="Specialization"  />
                                        <input type="text" name="seat_no[]" class="form-control" value="<?= isset($var['specialization']) ? $var['specialization'] : '' ?>" placeholder="Specialization"  /></td>
                                        </div>
                                    <td><input type="text" name="institute_name[]" class="form-control" value="<?= isset($var['board_uni_name']) ? $var['board_uni_name'] : '' ?>" placeholder="Name of Board/University" /></td>
                                    <td><select name="pass_year[]" class="form-control" >
                                        <option value="">Year</option>
                                        <?php
    for ($y = date("Y"); $y >= date("Y") - 60; $y--) {
		$year =$var['pass_year'];
		//echo $year[1];exit;
		if($y==$year){
			$sel = "selected";
		}else{
			$sel="";
		}

        echo '<option value="' . $y . '" '.$sel.'>' . $y . '</option>';
    }
?>
                                     </select>
                                      <select name="pass_month[]" class="form-control" >
                                        <option value="">Month</option>
                                        <option value="JAN" <?php if(!empty($year[0]) && $year[0]=='JAN'){ echo "selected";}?>>JAN</option>
                                        <option value="FEB" <?php if(!empty($year[0]) && $year[0]=='FEB'){ echo "selected";}?>>FEB</option>
                                        <option value="MAR" <?php if(!empty($year[0]) && $year[0]=='MAR'){ echo "selected";}?>>MAR</option>
                                        <option value="APR" <?php if(!empty($year[0]) && $year[0]=='APR'){ echo "selected";}?>>APR</option>
                                        <option value="MAY" <?php if(!empty($year[0]) && $year[0]=='MAY'){ echo "selected";}?>>MAY</option>
                                        <option value="JUN" <?php if(!empty($year[0]) && $year[0]=='JUN'){ echo "selected";}?>>JUN</option>
                                        <option value="JUL" <?php if(!empty($year[0]) && $year[0]=='JUL'){ echo "selected";}?>>JUL</option>
                                        <option value="AUG" <?php if(!empty($year[0]) && $year[0]=='AUG'){ echo "selected";}?>>AUG</option>
                                        <option value="SEP" <?php if(!empty($year[0]) && $year[0]=='SEP'){ echo "selected";}?>>SEPT</option>
                                        <option value="OCT" <?php if(!empty($year[0]) && $year[0]=='OCT'){ echo "selected";}?>>OCT</option>
                                        <option value="NOV" <?php if(!empty($year[0]) && $year[0]=='NOV'){ echo "selected";}?>>NOV</option>
                                        <option value="DEC" <?php if(!empty($year[0]) && $year[0]=='DEC'){ echo "selected";}?>>DEC</option>
                                      </select></td>
                                    <td><input type="text" name="marks_obtained[]" class="form-control numbersOnly" id="qua-markobt_0" value="<?= isset($var['total_marks']) ? $var['total_marks'] : '' ?>" /></td>
                                    <td><input type="text" name="marks_outof[]" class="form-control numbersOnly" id="qua-markout_0"  onblur="return cal_percentage('qua-markout_0')" value="<?= isset($var['out_of_marks']) ? $var['out_of_marks'] : '' ?>" placeholder="" /></td>
                                    <td><input type="text" name="percentage[]" class="form-control" id="qua-percent_0" value="<?= isset($var['percentage']) ? $var['percentage'] : '' ?>" placeholder="" /></td>
                                      <td><input type="text" name="cgpa[]" class="form-control" value="" placeholder="" /></td>
                                       <td><input type="text" name="grade[]" class="form-control" value="" placeholder="" /></td>
                                     <td><input type="file" name="sss_doc[]" id="sss_doc" style="width:80px" > <br> <?= isset($var['file_path']) ? $var['file_path'] : '' ?></td>
                                   <td></td>
                                  </tr>
								<?php $j++;}
									}
										?>
                                 <tr id="firsttr">
                                    <td> <div class="form-group">
                                        <select name="exam_id[]" id="studqual_1" class="squal form-control" onchange="qualifcation(this.id)" >
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
                                    <select name="stream_name[]" id="stream_name_1" onchange="strmsubject(this.id)" style="width:85px" class="form-control" >
                                        <option value="">Select</option>
                                    
                                      </select>
                                        
                                    </td>
                                   
                                    <td><div class="form-group">
                                        <input type="text" name="seat_no[]" class="form-control" value="<?= isset($_REQUEST['seat_no']) ? $_REQUEST['seat_no'] : '' ?>" placeholder="Specialization"  /></td>
                                        </div>
                                    <td><input type="text" name="institute_name[]" class="form-control" value="<?= isset($_REQUEST['institute_name']) ? $_REQUEST['institute_name'] : '' ?>" placeholder="Name of Board/University" /></td>
                                    <td><select name="pass_year[]" class="form-control">
                                        <option value="">Year</option>
                                        <?php
    for ($y = date("Y"); $y >= date("Y") - 60; $y--) {
        echo '<option value="' . $y . '">' . $y . '</option>';
    }
?>
                                     </select>
                                      <select name="pass_month[]" class="form-control">
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
                                    <td><input type="text" name="marks_obtained[]" class="form-control numbersOnly" id="qua-markobt_1" value="<?= isset($_REQUEST['marks_obtained']) ? $_REQUEST['marks_obtained'] : '' ?>" /></td>
                                    <td><input type="text" name="marks_outof[]" class="form-control numbersOnly"  id="qua-markout_1"  onblur="return cal_percentage('qua-markout_1')" value="<?= isset($_REQUEST['marks_outof']) ? $_REQUEST['marks_outof'] : '' ?>" placeholder=""/></td>
                                    <td><input type="text" name="percentage[]" class="form-control"  id="qua-percent_1" value="<?= isset($_REQUEST['percentage']) ? $_REQUEST['percentage'] : '' ?>" placeholder="" /></td>
                                                                          <td><input type="text" name="cgpa[]" class="form-control" value="" placeholder="" /></td>
                                       <td><input type="text" name="grade[]" class="form-control" value="" placeholder="" /></td>
                                    
                                     <td><input type="file" name="sss_doc[]" id="sss_doc" style="width:80px"></td>
                                    <td><input type="button" class="btn btn-xs btn-primary btn-flat" id="addmore" value="Add More" name="addMore" />
                                      <input type="button" class="btn btn-xs btn-danger btn-flat" id="remove" value="Remove" name="remove" /></td>
                                  </tr>



















                                <!-- <tr id="firsttr">
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
                                    <td><input type="text" name="marks_obtained[]" id="qua-markobt_1" class="form-control numbersOnly" maxlength="4" value="<?= isset($_REQUEST['marks_obtained']) ? $_REQUEST['marks_obtained'] : '' ?>" required/></td>
                                    <td><input type="text" name="marks_outof[]" id="qua-markout_1" class="form-control numbersOnly" onblur="return cal_percentage(this.id)" maxlength="4" value="<?= isset($_REQUEST['marks_outof']) ? $_REQUEST['marks_outof'] : '' ?>" placeholder="" required/></td>
                                    <td><input type="text" name="percentage[]" id="qua-percent_1" class="form-control" maxlength="5" value="<?= isset($_REQUEST['percentage']) ? $_REQUEST['percentage'] : '' ?>" placeholder="" required readonly="true"/></td>
                                     <td><input type="file" name="sss_doc[]" id="sss_doc" style="width:80px"></td>
                                    <td><input type="button" class="btn btn-xs btn-primary btn-flat" id="addmore" value="Add More" name="addMore" />
                                      <input type="button" class="btn btn-xs btn-danger btn-flat" id="remove" value="Remove" name="remove" /></td>
                                  </tr>-->

                               </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!--<div class="panel">
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
                    </div>-->
                    
                    <div class="panel">
                      <div class="panel-heading">Entrance Exam</div>
                      <div class="panel-body">
                          
                      <!-- <div class="row">
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
							 
						</div>-->
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
							<!--	<input type="checkbox" name="chk_scholr" id="chk_scholr" value="scholr"> Is Scholarship?-->
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
                                   <th>Select</th>
                                <th>Sr No.</th>
                                
                                <th>Particulars</th>
                                <!--<th>Mark 'NA'if not applicable</th>-->
                                <th>Original or Xerox</th>
                               <!-- <th>If Pending for submission(Specify Date of Submission)</th>-->
                                <th>Upload Scan Copy</th>
                               <!-- <th>Remark</th>-->
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
                                   <td><input type="checkbox"></td>
                                <td><?= $doc['document_id'] ?>
                                 <input type="hidden" name="doc_id[]" value="<?= $doc['document_id'] ?>"></td>
                                <td><label>
                                    <?= $doc['document_name'] ?>
                                 </label></td>
                               <!-- <td><div class="form-group">
                                    <select name="dapplicable[<?= $doc['document_id'] ?>]">
                                    <option value="">Select</option>
                                    <option value="A">Yes</option>
                                    <option value="NA">NA</option>
                                  </select></td>-->
                                <td><select name="ox[<?= $doc['document_id'] ?>]" >
                                    <option value="">Select</option>
                                    <option value="O">O</option>
                                    <option value="X">X</option>
                                  </select></td>
                               <!-- <td><div class="form-group">
                                    <div class="input-group date" id="doc-sub-datepicker<?= $doc['document_id'] ?>">
                                      <input type="text" id="docsubdate[]" name="docsubdate[<?= $doc['document_id'] ?>]" class="form-control" value="<?= isset($_REQUEST['docsubdate']) ? $_REQUEST['docsubdate'] : '' ?>" placeholder="Date" />
                                      <span class="input-group-addon"><i class="fa fa-calendar"></i></span> </div>
                                  </div></td>-->
                                <td><input type="file" name="scandoc[<?= $doc['document_id'] ?>]"></td>
                         <!--       <td><input type="text" name="remark[<?= $doc['document_id'] ?>]?>"/></td>-->
                              </tr>
                              <?php
}
?>
                           </table>
                          </div>
                        </div>
                      </div>
                    <!--  <div class="panel">
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
                              <td><div class="form-group"><input type="text" name="cno[]" class="form-control" value="<?= isset($certificate[0]['certificate_no']) ? $certificate[0]['certificate_no'] : '' ?>"  /></div></td>
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
                    -->  <div class="form-group">
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
                              <td>Total fee
                              <?php
                             // var_dump($acfees);
                              ?>
                              </td>
                              <td><input type="text" id="txt_acd" name="acd_totalfee" value="<?= isset($acfees[0]['total_fees']) ? $acfees[0]['total_fees'] : '' ?>" onkeyup="sub3();" style="width:100px" readonly></td>
							  <td><input type="text" id="txt_exempt" name="exepmted_fee" value="<?= isset($fee_det['exemption_fees']) ? $fee_det['exemption_fees'] : '' ?>" onkeyup="sub3();" style="width:100px" readonly></td>
                              <td><input type="text" id="txt31" name="totalfeeappli" value="<?= $acfees[0]['total_fees'] - $fee_det['exemption_fees']  ?>" onkeyup="sub3();" style="width:100px" readonly></td>
                              <td><input type="text" id="txt32" name="totalfeepaid" value="<?= isset($fee_det['amtpaid']) ? $fee_det['amtpaid'] : '' ?>" onblur="return cal_balance_left();" style="width:100px" readonly ></td>
                           <td><input type="text" id="txt33" name="totalfeebal" value="<?= $acfees[0]['total_fees'] - $fee_det['exemption_fees'] - $fee_det['amtpaid'] ?>"  readonly></td>
                         
                           
                             <!-- <td><input type="text" id="txt33" name="totalfeebal" value="<?= isset($fee[0]['totalfeebal']) ? $fee[0]['totalfeebal'] : '' ?>" onkeyup="sub3();" style="width:100px" readonly></td>
                          -->  </tr>
                          </table>
                          <!--div class="panel">
                            <div class="panel-heading">Paid Details <?= $astrik ?>
                                <div class="panel-body">
                                  <div class="form-group">
                                    <label class="col-sm-3">Payment of Rs</label>
                                    <div class="col-sm-3">
                                      <input data-bv-field="paidfee" id="paidfee" name="paidfee" class="form-control" value="<?= isset($fee[0]['totalfeepaid']) ? $fee[0]['totalfeepaid'] : '' ?>" placeholder="Paid Fee" type="text" required readonly>
                                    </div>
                                    <label class="col-sm-3">Payment Type</label>
                                    <div class="col-sm-3">
                                    <select name="payment_type" id="payment_type" class="form-control">
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
                                      <input type="text" name="dd_no" class="form-control"  value="<?= isset($fee[0]['dd_no']) ? $fee[0]['dd_no'] : '' ?>" placeholder="Cheque/DD No./Chalan No.">
                                    </div>
									
                                    <label class="col-sm-3">Dated</label>
                                    <div class="col-sm-3">
                                      <input type="text" class="form-control" id="doc-sub-datepicker20" name="dd_date"  value="<?= isset($fee[0]['dd_drawn_date']) ? $fee[0]['dd_drawn_date'] : '' ?>" placeholder="Date"/>
                                    </div>
                                    
                                    <div class="col-sm-6">
                                      
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label class="col-sm-3">Bank name</label>
                                    <div class="col-sm-3">
                                    
									  
									  
									                                  <select name="dd_bank" id="dd_bank" class="form-control">
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
                                      <input type="text" id="dd_bank_branch" name="dd_bank_branch" class="form-control" value="" placeholder="Branch Name">
                                    </div>
                                  </div>
                                  
                                  <div class="form-group">
								  
								   <label class="col-sm-3">Upload document</label>
                                    <div class="col-sm-3"><input type="file" name="payfile">
                                        </div>
                                  </div>
                                  
                                </div>
                            </div>
                         </div>-->
                       
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
                      
                 
                        <div class="panel-body">
                          <div class="form-group">
                            <label class="col-sm-3">Confirm Submission</label>
                           
                           <input type="checkbox" name="confirm" value="" required> select checkbox and click submit to confirm
                   </div>
                        </div>
                    
                      
                      
                      
                      <!--<div class="panel">
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
                      </div-->
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
            <?php
            }
          
            
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
// Qualification percentage calculation
  function cal_percentage(id){
    //  alert();
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
    // payment calculations
   /* $('#paymnt').on('click', function () {
		var strm_id = $("#admission-stream").val();
		var acyear = $("#acyear").val();
		if($("input[type='radio'].schBtn").is(':checked')) {
			var schlr_manual = $("input[type='radio'].schBtn:checked").val();	
	
		}else{
			var schlr_manual ='';
		}
	//	alert(acyear);
		if (strm_id) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Ums_admission/fetch_academic_fees_for_stream_year',
				data: {'strm_id' : strm_id,'acyear':acyear},//'strm_id=' + strm_id + 'acyear=' + acyear,
				success: function (resp) {
					//alert(resp)
					var obj = jQuery.parseJSON(resp);	
					var tot_fees =parseInt(obj[0].total_fees); 
					var total_fees =parseInt(obj[0].tution_fees); 
					var schol_allowed =obj[0].scholorship_allowed;
					var su_jee_per = parseFloat($("#super").val());
					var mhcet_mrks = parseInt($("#mhcet_obt_marks").val());
					var othr_mrks = parseInt($("#othr_obt_marks").val());
					//alert(schol_allowed);
					//alert(schlr_manual);
					//alert(total_fees);
					
					if(mhcet_mrks >0){						
					}else{
						mhcet_mrks =0;
					}
					if(othr_mrks >0){						
					}else{
						othr_mrks =0;
					}
					if(schol_allowed =='Y'){
						if(schlr_manual ==''){
							//alert("hiii");
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
								var exepmted_fees = parseInt(0);
							}
						}else{
							if (schlr_manual == "I") 
							{
								var exepmted_fees = total_fees;
							}else if(schlr_manual == "II")
							{
								var exepmted_fees = total_fees * 0.5;
							}else if(schlr_manual == "III")
							{
								var exepmted_fees = total_fees * 0.25;
							}else if(schlr_manual == "IV")
							{
							    var fdet = $('#spert').val();
								var exepmted_fees = total_fees * 0.01*fdet;
							}else{
								var exepmted_fees = parseInt(0);
							}
						}
					}else{
						var exepmted_fees = parseInt(0);
					}

					//alert(total_fees);
					//alert(exepmted_fees);
					
					var final_fee = tot_fees - Math.round(exepmted_fees);
					//alert(final_fee);
					$("#txt_acd").val(tot_fees);
					$("#txt_exempt").val(Math.round(exepmted_fees));
					$("#txt31").val(final_fee);
					//$('#suJeexamtable').html(html);
				}
			});
		} else {
			//alert("Please enter registration no");

		}
	});*/
    /////////////
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
    $('#dob-datepicker').datepicker( {format: 'dd-mm-yyyy',autoclose: true});
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
			var fieldshtml = "<tr><td> <div class='form-group'><select name='exam_id[]' id='studqual_"+x+"' class='squal form-control' onchange='qualifcation("+'"'+qid+'"'+")' required><option value=''>Select</option><option value='SSC'>SSC</option><option value='HSC'>HSC</option><option value='Graduation'>Graduation</option><option value='Post Graduation'>Post Graduations</option><option value='Diploma'>Diploma</option></select></div>   </td><td><select name='stream_name[]' id='stream_name_"+x+"' onchange='strmsubject("+'"'+strm+'"'+")' style='width:85px' class='form-control' required><option value=''>Select</option> </select></td><td><div class='form-group'><input type='text' name='seat_no[]' class='form-control' value='' placeholder='Specialization' /></td></div><td><input type='text' name='institute_name[]' class='form-control' value='' placeholder='Name of Board/University' required /></td><td><select name='pass_year[]' class='form-control' required><option value=''>Year</option><?php  for ($y = date('Y'); $y >= date('Y') - 60; $y--) {  ?> <option value='<?=$y?>'><?=$y?></option><? }?></select><select name='pass_month[]' class='form-control' required><option value=''>Month</option><option value='JAN'>JAN</option><option value='FEB'>FEB</option><option value='MAR'>MAR</option><option value='APR'>APR</option><option value='MAY'>MAY</option><option value='JUN'>JUN</option><option value='JUL'>JUL</option><option value='AUG'>AUG</option><option value='SEP'>SEPT</option><option value='OCT'>OCT</option><option value='NOV'>NOV</option><option value='DEC'>DEC</option></select></td><td><input type='text' name='marks_obtained[]' id='qua-markobt_"+x+"' class='numbersOnly form-control' maxlength='4' value='' /></td><td><input type='text' name='marks_outof[]' id='qua-markout_"+x+"' onblur='return cal_percentage("+'"'+mrkout+'"'+")' class='numbersOnly form-control' maxlength='4' value='' placeholder=''/></td><td><input type='text' name='percentage[]' id='qua-percent_"+x+"' class='form-control' maxlength='5' value='' placeholder=''  readonly='true'/><td><input type='text' name='cgpa[]' id='qua-cgpa_"+x+"' class='form-control' maxlength='5' value='' placeholder=''/></td><td><input type='text' name='grade[]' id='qua-grade_"+x+"' class='form-control' maxlength='5' value='' placeholder=''  /><td><input type='file' name='sss_doc[]' id='sss_doc' style='width:80px'></td><td><input type='button' class='remove_field btn btn-xs btn-danger btn-flat' id='remove' value='Remove' name='remove' /></td></tr>";
		
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