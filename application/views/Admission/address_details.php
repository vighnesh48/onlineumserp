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
               <div class="xtable-info">
                  <div id="dashboard-recent" class="panel panel-warning">
                     <?php include 'stepbar.php';?>
                     <div class="tab-content">
                        <form method="post" action="<?=base_url()?>Ums_admission/update_addressDetails/" enctype="multipart/form-data">
                        <div id="personal-details" class="setup-content widget-comments panel-body tab-pane fade active in">
                           <!-- Panel padding, without vertical padding -->
                            <input type="hidden" name="student_id" value="<?php echo $studentid;  ?>">
                              <div class="panel-body">
                                 <!--  <input type="hidden" value="" id="campus_id" name="campus_id" />-->
                                
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
                                       <?php //print_r($local_address); ?>
                                          <div class="form-group">
                                             <label  class="col-sm-3">Address: <?=$astrik?></label>
                                             <div class="col-sm-6">
                <textarea id="laddress" class="form-control" NAME="laddress" style="margin: 0px; width: 200px; height: 50px;" ><?= isset($local_address) ? $local_address : ''; ?></textarea>
                                             </div>
                                          </div>
                                          <div id='ladd'>
<div class="form-group">
                                             <label  class="col-sm-3">Country: <?=$astrik?></label>
                                             <div class="col-sm-6">
                                                <select class="form-control" name="lCountry_id" id="lCountry_id" required>
                                                   <option value="">select Country</option>
                                                   <?php
                                                      if(!empty($country)){
                                                          foreach($country as $countr){
                                                              ?>
                              <option value="<?php echo $countr['id']?>" <?php if($countr['id'] == $localcountry){echo "selected";} ?> ><?php echo $countr['name']?></option>
                                                   <?php 
                                                      }
                                                      }
                                                      ?>
                                                </select>
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
                              <option value="<?php echo $stat['state_id']?>" <?php if($stat['state_id'] == $localstate){echo "selected";} ?> ><?php echo $stat['state_name']?></option>
                                                   <?php 
                                                      }
                                                      }
                                                      ?>
                                                </select>
                                             </div>
                                          </div>
                                          <div class="form-group">
                                             
                                             <label  class="col-sm-3">District: <?=$astrik?></label>
                                             <div class="col-sm-6"> <?php
                                              //var_dump($localdistrict);
                                              ?>
                                                <select class="form-control" name="ldistrict_id" id="ldistrict_id" required>
                                                       <?php
                                                     // if(!empty($district)){
                                                        //  foreach($district as $stat){
                                                              ?>
                                               <option value="<? //$stat['district_id']?>" <?php //if($stat['district_id'] == $localdistrict){echo "selected";} ?> ><? //$stat['district_name']?></option>
                                                   <?php 
                                                    //  }
                                                  //    }
                                                      ?>
                                                </select>
                                             </div>
                                          </div>
                                          <div class="form-group">
                                             <label  class="col-sm-3">City: <?=$astrik?></label>
                                             <div class="col-sm-6">
                                                <select class="form-control" name="lcity" id="lcity">
                                                     <?php
                                                    //  if(!empty($city)){
                                                      //    foreach($city as $stat){
                                                              ?>
                                                   <option value="<? //$stat['taluka_id']?>" <?php //if($stat['taluka_id'] == $localcity){echo "selected";} ?> ><? //$stat['taluka_name']?></option>
                                                   <?php 
                                                     // }
                                                    //  }
                                                      ?>
                                                </select>
                                             </div>
                                          </div>
                                          <div class="form-group">
                                             <label  class="col-sm-3">Pin Code: <?=$astrik?></label>
                                             <div class="col-sm-6">
                  <INPUT type="text" class="form-control numbersOnly" id="lpincode" NAME="lpincode" value="<?= isset($localpincode) ? $localpincode : ''; ?>" >
                                             </div>
                                          </div>
                                          </div>
                                       </td>
                                       <!--Permanent Address-->
                                       <td width="50%">
                                          <div class="form-group">
                                             <label  class="col-sm-3">Address: <?=$astrik?></label>
                                             <div class="col-sm-6">
               <textarea id="paddress" class="form-control" NAME="paddress" style="margin: 0px; width: 200px; height: 50px;" ><?= isset($perm_address) ? $perm_address : ''; ?></textarea>
                                             </div>
                                          </div>
                                          <div id='adiv'>




                                  <div class="form-group">
                                             <label  class="col-sm-3">Country: <?=$astrik?></label>
                                             <div class="col-sm-6">
                                                <select class="form-control" name="pCountry_id" id="pCountry_id" required>
                                                   <option value="">select Country</option>
                                                   <?php
                                                      if(!empty($country)){
                                                          foreach($country as $countr){
                                                              ?>
                              <option value="<?php echo $countr['id']?>" <?php if($countr['id'] == $permcountry){echo "selected";} ?> ><?php echo $countr['name']?></option>
                                                   <?php 
                                                      }
                                                      }
                                                      ?>
                                                </select>
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
                       <option value="<? echo $stat['state_id']?>"  <?php if($stat['state_id'] == $permstate){echo "selected";} ?>><? echo $stat['state_name']?></option>
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
                                                        <?php
                                                    //  if(!empty($district)){
                                                       //   foreach($district as $stat){
                                                              ?>
                           <option value="<? //$stat['district_id']?>" <?php //if($stat['district_id'] == $permdistrict){echo "selected";} ?> ><? //$stat['district_name']?></option>
                                                   <?php 
                                                   //   }
                                                   //   }
                                                      ?>
                                                </select>
                                             </div>
                                          </div>
                                          <div class="form-group">
                                             <label  class="col-sm-3">City: <?=$astrik?></label>
                                             <div class="col-sm-6">
                                                <select class="form-control" name="pcity" id="pcity">
                                                   <?php
                                                     // if(!empty($city)){
                                                      //    foreach($city as $stat){
                                                              ?>
                                                   <option value="<? //$stat['taluka_id']?>" <?php //if($stat['taluka_id'] == $permcity){echo "selected";} ?> ><? //$stat['taluka_name']?></option>
                                                   <?php 
                                                    //  }
                                                   //   }
                                                      ?>
                                                </select>
                                             </div>
                                          </div>
                                          <div class="form-group">
                                             <label  class="col-sm-3">Pin Code: <?=$astrik?></label>
                                             <div class="col-sm-6">
           <INPUT type="text" class="form-control numbersOnly" id="ppincode" NAME="ppincode" value="<?= isset($permpincode) ? $permpincode : ''; ?>" >
                                             </div>
                                          </div>
                                          </div>
                                       </td>
                                    </tr>
                                    <?php
                                       if ($emp_list[0]['same'] == "on") {
                                           $val = "checked";
                                       } else {
                                           $val = "";
                                       }
                                       ?>
                                    <!--<tr><td><label style="text-align:left"><input name="same" <?php
                                       echo $val;
                                       ?> onclick="copyBilling (this.form) " type="checkbox">Permanent Address is Same as Local Address</label></td></tr>-->
                                 </table>
                                <!-- <label style="text-align:left">
                                 <input name="same" <?php
                                    echo $val;
                                    ?> onclick="copyBilling (this.form) " type="checkbox">
                                 Permanent Address is Same as Local Address</label>-->
								 <div class="form-group">
								 <INPUT type="checkbox"  id="sameaslocal" NAME="sameaslocal" >
                                             
                                             <b>Same as local address</b>
                                            </div>
								 
								 
                              </div>
                           </div>
                           <div class="panel">
                              <div class="panel-heading">Parent's/Guardian's Details
                                 <?= $astrik ?>
                              </div>
                              <div class="panel-body">
                               
                                 <div class="form-group">
                                    <label class="col-sm-3">Relationship </label>
                                    <div class="col-sm-3">
                                       <select name="relationship" class="form-control">
                                          <option value="">Select</option>
                                          <?php
                                             $val1 = $val2 = $val3 = $val4 = "";
                                             if ($parent_details[0]['relation'] == "Father") {
                                                 $val1 = "selected";
                                             } elseif ($parent_details[0]['relation'] == "Mother") {
                                                 $val2 = "selected";
                                             } elseif ($parent_details[0]['relation'] == "Uncle") {
                                                 $val3 = "selected";
                                             } elseif ($parent_details[0]['relation'] == "Other") {
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
                                             if ($parent_details[0]['occupation'] == "Service") {
                                                 $val1 = "selected";
                                             } elseif ($parent_details[0]['occupation'] == "Business") {
                                                 $val2 = "selected";
                                             } elseif ($parent_details[0]['occupation'] == "Farmer") {
                                                 $val3 = "selected";
                                             } elseif ($parent_details[0]['occupation'] == "Other") {
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
                                             echo $val4;
                                             ?> value="Other">Other</option>
                                       </select>
                                    </div>
                                 </div>
                                 <div class="form-group">
                                    <label class="col-sm-3">Annual Income </label>
                                    <div class="col-sm-3">
                                       <input type="text" id="annual_income" name="annual_income" class="form-control" value="<?= isset($parent_details[0]['income']) ? $parent_details[0]['income'] : ''; ?>" placeholder="Annual Income in Rs." />
                                    </div>
                                    <label class="col-sm-3">Mobile</label>
                                    <div class="col-sm-3">
                                       <input type="text" id="parent_mobile" name="parent_mobile" class="form-control" value="<?= isset($parent_details[0]['parent_mobile2']) ? $parent_details[0]['parent_mobile2'] : ''; ?>" maxlength="10"/>
                                    </div>
                                 </div>
                               
                           </div>
                           <div class="form-group">
                              <div class="col-sm-4"></div>
                              <div class="col-sm-2">
                                	<?php  $role_id =$this->session->userdata('role_id');

                                  if($role_id==2 || $role_id==59) {
							?>
							  
                                 <button class="btn btn-primary form-control" type="submit">Update</button>
								 
								  <?php  } ?>	 
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
</div>
 
<script type="text/javascript">
   function checkp(){
  var state_IDp = '<?php echo $permstate;?>';//$("#lstate_id").val();
  var ldistrict_idp = '<?php echo $permdistrict;?>';//$("#lstate_id").val();
  var lcityp = '<?php echo $permcity;?>';//$("#lstate_id").val();
		alert(state_ID);
		if (state_IDp) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Ums_admission/getStatewiseDistrict',
				data: 'state_id=' + state_IDp+'&ldistrict_id='+ldistrict_idp,
				success: function (html) {
					//alert(html);
					$('#pdistrict_id').html(html);
				}
			});
		} else {
			$('#pdistrict_id').html('<option value="">Select state first</option>');
		}
			///////////////////////////////////////////
			if (ldistrict_idp) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Ums_admission/getStateDwiseCity',
				data: { state_id: state_IDp, district_id : ldistrict_idp,lcity:lcityp},
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
  }
  
  
  
$(document).ready(function(){
	
	
 
    // State by country
	$('#lCountry_id').on('change', function () {
		var Country_id = $(this).val();
		if(Country_id!=101){
		
		$('#ldistrict_id').removeAttr('required');
$('#lcity').removeAttr('required');
$('#lpincode').removeAttr('required');
		}else{
$('#ldistrict_id').prop('required',true);
$('#lcity').prop('required',true);
$('lpincode').prop('required',true);

		}
		
		if (lCountry_id) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Ums_admission/getCountrywiseState',
				data: 'Country_id='+Country_id,
				success: function (html) {
					//alert(html);
					$('#lstate_id').html(html);
					


				}
			});
		} else {
			$('#lstate_id').html('<option value="">Select Country first</option>');
		}
	});
	
	
	
	$('#pCountry_id').on('change', function () {
		var Country_id = $(this).val();
		if(Country_id!=101){
			$('#pdistrict_id').removeAttr('required');
$('#pcity').removeAttr('required');
$('#ppincode').removeAttr('required');
		}else{
			$('#pdistrict_id').prop('required',true);
$('#pcity').prop('required',true);
$('#ppincode').prop('required',true);
		}
		if (lCountry_id) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Ums_admission/getCountrywiseState',
				data: 'Country_id='+Country_id,
				success: function (html) {
					//alert(html);
					$('#pstate_id').html(html);
					
				}
			});
		} else {
			$('#pstate_id').html('<option value="">Select Country first</option>');
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
	///////////////////////////////////////////
	
	
    });  
$(function() {  //  console.log( "ready!" );
	///////////////////////////////////////////
  var country_idl = '<?php echo $localcountry;?>';
  var state_IDl = '<?php echo $localstate;?>';//$("#lstate_id").val();
  var ldistrict_idl = '<?php echo $localdistrict;?>';//$("#lstate_id").val();
  var lcityl = '<?php echo $localcity;?>';//$("#lstate_id").val();
		//alert(state_ID);
		if (country_idl) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Ums_admission/getStatewiseDistrict',
				data: 'state_id=' + state_IDl+'&ldistrict_id='+ldistrict_idl,
				success: function (html) {
					//alert(html);
					$('#ldistrict_id').html(html);
				}
			});
		} else {
			$('#ldistrict_id').html('<option value="">Select state first</option>');
		}
		
		
		if (state_IDl) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Ums_admission/getStatewiseDistrict',
				data: 'state_id=' + state_IDl+'&ldistrict_id='+ldistrict_idl,
				success: function (html) {
					//alert(html);
					$('#ldistrict_id').html(html);
				}
			});
		} else {
			$('#ldistrict_id').html('<option value="">Select state first</option>');
		}
			///////////////////////////////////////////
			if (ldistrict_idl) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Ums_admission/getStateDwiseCity',
				data: { state_id: state_IDl, district_id : ldistrict_idl,lcity:lcityl},
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
			
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	/*	 setTimeout(
  function() 
  {
    checkp()
  }, 5000);*/
var state_IDp = '<?php echo $permstate;?>';//$("#lstate_id").val();
  var ldistrict_idp = '<?php echo $permdistrict;?>';//$("#lstate_id").val();
  var lcityp = '<?php echo $permcity;?>';//$("#lstate_id").val();
	//	alert(state_ID);
		if (state_IDp) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Ums_admission/getStatewiseDistrict_p',
				data: 'state_id=' + state_IDp+'&ldistrict_id='+ldistrict_idp,
				success: function (html) {
					//alert(html);
					$('#pdistrict_id').html(html);
				}
			});
		} else {
			$('#pdistrict_id').html('<option value="">Select state first</option>');
		}
			///////////////////////////////////////////
			if (ldistrict_idp) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Ums_admission/getStateDwiseCity_p',
				data: { state_id: state_IDp, district_id : ldistrict_idp,lcity:lcityp},
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
 
  
  
  
 
</script>
<?php if($localcountry!=101){?>
<script type="text/javascript">
$('#ldistrict_id').removeAttr('required');
$('#lcity').removeAttr('required');
$('#lpincode').removeAttr('required');

$('#pdistrict_id').removeAttr('required');
$('#pcity').removeAttr('required');
$('#ppincode').removeAttr('required');
</script>
<?php } ?>

<script type="text/javascript">
$('#sameaslocal').change(function() {
        if(this.checked) {
			$("#pCountry_id").val($("#lCountry_id").val());
            $("#pstate_id").val($("#lstate_id").val());
			$("#pstate_id").trigger("change");
			setTimeout(function(){
              $("#pdistrict_id").val($("#ldistrict_id").val());
              
}, 200); 

setTimeout(function(){
	$("#pdistrict_id").trigger("change");
             
}, 400); 
setTimeout(function(){
	 $("#pcity").val($("#lcity").val());
             
}, 600); 

 $("#paddress").val($("#laddress").val());
 $("#ppincode").val($("#lpincode").val());

			
			//$("#pdistrict_id").trigger("change");
			//
			
			
        }
		else{
		$("#paddress").val('');
		$("#ppincode").val('');
		$("#pdistrict_id").val('');
		$("#pcity").val('');
		$("#pCountry_id").val('');
		$("#pstate_id").val('');
		}
        
    });
</script>

