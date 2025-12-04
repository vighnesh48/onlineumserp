<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<style type="text/css">
   .panel-warning .panel-heading .panel-title {
   color: #000 !important;
   font-weight:400 !important;
   }
   .testtiltle{
    font-size: 14px !important;
	font-weight:600 !important;
	margin-top: 5px !important;
    margin-bottom: 0px !important;
}
   input[type=checkbox], input[type=radio] {
   margin: 2px 0 0;
   line-height: normal;
   }
   fieldset.scheduler-border {
   border: 1px solid #1d89cf !important;
   padding: 0 1.4em 1.4em 1.4em !important;
   margin: 0 0 1.5em 0 !important;
   -webkit-box-shadow: 0px 0px 0px 0px #000;
   box-shadow: 0px 0px 0px 0px #0000;
   }
   border-top-color: #dadada;
   -webkit-box-shadow: none;
   box-shadow: 1px 1px 1px #ccc;
   legend.scheduler-border {
   font-size: 1.2em !important;
   font-weight: bold !important;
   text-align: left !important;
   width:auto;
   padding:0 10px;
   border-bottom:none;
   }
   .theme-default .bordered, .theme-default .panel, .theme-default .table, .theme-default hr {
   border-color: #ffffff;
   }
   .tab-content {
   padding: 0px 0;
   }
   .panel-heading {
   background: #fffce1;
   border: 2px solid #f6deac;
   padding-bottom: 2px;
   padding-left: 20px;
   padding-right: 20px;
   padding-top: 11px;
   position: relative;
   }
   .h3, h3 {
   color: #666;
   font-size: 18px;
   font-weight: 300;
   line-height: 30px;
   }
   legend {
   color: #1d89cf!important;
   }
   legend.scheduler-border {
   font-size: 15px !important;
   font-weight: 600 !important;
   text-align: left !important;
   width:auto;
   padding:0 10px;
   border-bottom:none;
   }
   fieldset.scheduler-border:hover {
   border: solid 1px #f6deac!important
   }
   .form-control {
   height: 26px;
   padding: 0px 12px;
   margin-left: 10px;
   width:95%;
   }
</style>
<?php
$role_id =$this->session->userdata('role_id');
 ?>
<script>    
function History(){
//var history=history.back();

//window.location=history.back();
window.location="https://erp.sandipuniversity.com/Enquiry/Enquiry_list";
}
   var fno='20R01'; 
      $(document).ready(function()
      {
          $('#formd').bootstrapValidator
          ({  
              message: 'This value is not valid',
              group: 'form-group',
              feedbackIcons: 
              {
                  valid: 'glyphicon glyphicon-ok',
                  invalid: 'glyphicon glyphicon-remove',
                  validating: 'glyphicon glyphicon-refresh'
              },
              /*fields: 
              {                
                  first_name:
                  {
                      validators: 
                      {
                        notEmpty: 
                        {
                         message: 'student name should not be empty'
                        },
                        regexp: 
                        {
                          regexp: /^[a-z\s]+$/i,
                          message: 'First name can consist of alphabetical characters and spaces only'
                        } 
                      }
   
                  }
			  }*/
		  });
				/*  middle_name:
                  {
                      validators: 
                      {
                        notEmpty: 
                        {
                         message: 'student name should not be empty'
                        } ,
                        regexp: 
                        {
                          regexp: /^[a-z\s]+$/i,
                          message: 'First name can consist of alphabetical characters and spaces only'
                        } 
                      }
   
                  },
				  last_name:
                  {
                      validators: 
                      {
                        notEmpty: 
                        {
                         message: 'student name should not be empty'
                        } ,
                        regexp: 
                        {
                          regexp: /^[a-z\s]+$/i,
                          message: 'First name can consist of alphabetical characters and spaces only'
                        } 
                      }
   
                  },
                  mobile:
                 {
                     validators: 
                     {
                       notEmpty: 
                       {
                        message: ' Mobile number should not be empty'
                       },
                       regexp: 
                       {
                         regexp: /^[0-9/]+$/,
                         message: 'Mobile number should be numeric'
                       },
                       stringLength: 
                         {
                         max: 12,
                         min: 10,
                         message: 'Mobile number should be 10-12 characters.'
                         }
                     }
                 },
                   state_id:
                  {
                      validators: 
                      {
                        notEmpty: 
                        {
                         message: 'select state'
                        } ,
                        regexp: 
                        {
                          regexp: /^[a-z\s]+$/i,
                          message: 'First name can consist of alphabetical characters and spaces only'
                        } 
                      }
   
                  },
				   district_id:
                  {
                      validators: 
                      {
                        notEmpty: 
                        {
                         message: 'select district'
                        } ,
                        regexp: 
                        {
                          regexp: /^[a-z\s]+$/i,
                          message: 'First name can consist of alphabetical characters and spaces only'
                        } 
                      }
   
                  },
				   city_id:
                  {
                      validators: 
                      {
                        notEmpty: 
                        {
                         message: 'select city'
                        } ,
                        regexp: 
                        {
                          regexp: /^[a-z\s]+$/i,
                          message: 'First name can consist of alphabetical characters and spaces only'
                        } 
                      }
   
                  },
                  pincode:
                  {
                      validators: 
                      {
                        notEmpty: 
                        {
                         message: 'Enter pincode'
                        },
                        regexp: 
                        {
                          regexp: '^[+-]?([0-9]*[.])?[0-9]+$',
                          message: 'Paid search should be Decimal'
                        }
                        stringLength: 
                          {
                          max:6,
                          min: 6,
                          message: 'pincode should be 6 characters.'
                          }
                      }
                  },
                  admission_type:
                  {
                      validators: 
                      {
                        notEmpty: 
                        {
                         message: 'Select Admission Type'
                        } ,
                        regexp: 
                        {
                          regexp: /^[a-z\s]+$/i,
                          message: 'First name can consist of alphabetical characters and spaces only'
                        } 
                      }
   
                  },
                   last_qualification:
                  {
                      validators: 
                      {
                        notEmpty: 
                        {
                         message: 'Select last Qualification'
                        } ,
                        regexp: 
                        {
                          regexp: /^[a-z\s]+$/i,
                          message: 'First name can consist of alphabetical characters and spaces only'
                        } 
                      }
   
                  },
                  qualification_percentage:
                  {
                      validators: 
                      {
                        notEmpty: 
                        {
                         message: 'Enter percentage'
                        } ,
                        regexp: 
                        {
                          regexp: /^[a-z\s]+$/i,
                          message: 'First name can consist of alphabetical characters and spaces only'
                        } 
                      }
   
                  },school_id:
                  {
                      validators: 
                      {
                        notEmpty: 
                        {
                         message: 'Select school'
                        } ,
                        regexp: 
                        {
                          regexp: /^[a-z\s]+$/i,
                          message: 'First name can consist of alphabetical characters and spaces only'
                        } 
                      }
   
                  },
				  course_id:
                  {
                      validators: 
                      {
                        notEmpty: 
                        {
                         message: 'Select course'
                        } ,
                        regexp: 
                        {
                          regexp: /^[a-z\s]+$/i,
                          message: 'First name can consist of alphabetical characters and spaces only'
                        } 
                      }
   
                  },
				  stream_id:
                  {
                      validators: 
                      {
                        notEmpty: 
                        {
                         message: 'Select stream'
                        } ,
                        regexp: 
                        {
                          regexp: /^[a-z\s]+$/i,
                          message: 'First name can consist of alphabetical characters and spaces only'
                        } 
                      }
   
                  }
                  
                  
               
                  email:
                 {
                     validators: 
                     {
                      notEmpty: 
                       {
                        message: ' Email should not be empty'
                       },
                       regexp: 
                       {
                         regexp: '^[^@\\s]+@([^@\\s]+\\.)+[^@\\s]+$',
                         message: 'This is not a valid email'
                       }
                       
                     }
                 }
                 
   
              }       
          });*/
     
          /*$('#coursen').on('blur', function(e) {
             $('#form').bootstrapValidator('revalidateField', 'coursen');
           });*/
   	
          /*$("#form").on("submit", function(e) {
            alert('j');
            var mob_no = $("#mobile").val();
             alert(mob_no);
            if (mob_no) {
        $.ajax({
          type: 'POST',
          url: '<?= base_url()?>prospectus_fee_details/chek_dupmobno_exist',
          data: 'mobile_no=' + mob_no,
          success: function (resp) {
            var resp1 = resp.split("~");
            var dup = resp1[0];
          
            var mob = JSON.parse(resp1[1]);
   
            if(dup=="Duplicate"){
              //alert("You have already registered with us using this mobile no.");
              $("#errormsg").html("<span style='color:red;''>You have already registered with us using this mobile no.</span>");
              $("#mobile").val("");
              $('#mobile').focus();
             $("#btn_submit").prop('disabled', true);
              //alert(html);
              //$("#usrdetails").html(html);
              return false;
            }else{
              $("#btn_submit").prop('disabled', false);
              $("#errormsg").html("");
              return true
            }
            
          }
        });
      } else {
        return true;
        
      }
          });*/
      });
</script>
<?php
   $astrik='<sup class="redasterik" style="color:red">*</sup>';
   ?>
<div id="content-wrapper">
   <ul class="breadcrumb breadcrumb-page">
      <div class="breadcrumb-label text-light-gray">You are here: </div>
      <li><a href="#">Masters</a></li>
      <li class="active"><a href="#">Enquiry</a></li>
   </ul>
   <div class="page-header">
      <div class="row">
         <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Add Enquiry</h1>
         <div id="" align="right"><a href="<?php echo base_url();?>Enquiry/Enquiry_list"><h4>Enquiry List</h4></a></div>
         <div class="col-xs-12 col-sm-8">
            <div class="row">
               <hr class="visible-xs no-grid-gutter-h">
            </div>
         </div>
      </div>
      <div class="row ">
         <div class="form-group">
            <div class="col-sm-12">
               <div class="panel-heading">
                  <!--form method="post" action=""-->
                  <div class="row">
                     <div class="col-sm-2 from-group">
                        <h4 class="testtiltle" >Search By Mobile:</h4>
                     </div>
                     <div class="col-sm-2"><input type="text" name="mobile_search" id="mobile_search" class="form-control numbersOnly" maxlength="10"  title="Enter your mobile number" value="<?php  if($mobilnparamer){echo $mobilnparamer;}?>"></div>
                     <div class="col-sm-2">
                        <h4 class="testtiltle" >Search&nbsp;By&nbsp;Enquiry&nbsp;No: </h4>
                     </div>
                     <div class="col-sm-2"><input type="text" name="Enquiry_search" id="Enquiry_search" class="form-control"  title="Enter your Enquiry No" value="<?php  if($enquiryparamer){echo $enquiryparamer;}?>"></div>
                     <div class="col-sm-1"><input type="button" value="Search" class="btn btn-primary" id="btnsearch"></div>
                  </div>
                  <div id="returnMessage"></div>
                  <div> <?php if(isset($validation_errors)) { ?>
                     <span style='color:red;'><?php echo $validation_errors;  ?></span> <?php }?>
                  </div>
                  <!--/form-->
               </div>
            </div>
         </div>
      </div>
      <div class="row" id="show_form" style="display:none;">
         <div class="col-sm-12">
            <div id="dashboard-recent" class="panel panel-warning">
               <div class="tab-content">
                  <span style="color:red; padding-left:110px;"><?php echo $this->session->flashdata('message1'); ?></span>
                  <div id="personal-details" class="widget-comments panel-body tab-pane fade active in">
                     <div class="panel">
                        <form id="form"   name="form"  action="<?=base_url('Enquiry/Enquiry_insert')?>" method="POST"  enctype="multipart/form-data">
                           <input type="hidden" id="enquiry_id" name="enquiry_id" class="form-control" value="" />
                           <fieldset class="scheduler-border">
                              <legend class="scheduler-border">New Admission</legend>
                              <div class="form-group enquiry_no">
                                 <label class="col-sm-1">Enquiry&nbsp;No</label>
                                 <div class="col-sm-3"><input type="text" id="enquiry_no" name="enquiry_no" class="form-control enquiry_no" value="" readonly="readonly" required="required"/></div>
                              </div>
                              <div class="form-group">
                                 <label class="col-sm-1">First&nbsp;Name&nbsp;<?=$astrik?></label>
                                 <div class="col-sm-3"><input type="text" id="first_name" name="first_name" class="form-control" placeholder="First&nbsp;Name" required="required" pattern="^[A-Za-z][A-Za-z0-9!@#$%^&amp;* ]*$" title="Full Name should only letters. e.g. john"/></div>
                                 <label class="col-sm-1">Middle&nbsp;Name&nbsp;<?=$astrik?></label>
                                 <div class="col-sm-3">
                                    <input type="text" id="middle_name" name="middle_name" class="form-control" placeholder="Middle&nbsp;Name" required="required" pattern="^[A-Za-z][A-Za-z0-9!@#$%^&amp;* ]*$" title="Full Name should only letters. e.g. john"/>
                                 </div>
                                 <label class="col-sm-1">Last&nbsp;Name&nbsp;<?=$astrik?></label>
                                 <div class="col-sm-3">
                                    <input type="text" id="last_name" name="last_name" class="form-control" placeholder="Last&nbsp;Name" required="required" pattern="^[A-Za-z][A-Za-z0-9!@#$%^&amp;* ]*$" title="Full Name should only letters. e.g. john"/>
                                 </div>
                              </div>
                              <div class="form-group">
                                 <label class="col-sm-1">Email&nbsp;</label>
                                 <div class="col-sm-3"><input type="email" id="email_id" name="email_id" class="form-control" placeholder="Email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" /></div>
                                 <label class="col-sm-1">Mobile&nbsp;<?=$astrik?></label>
                                 <div class="col-sm-3">
                                    <input type="text" id="mobile" name="mobile" class="form-control" placeholder="mobile" required="required" maxlength="10"/>
                                 </div>
                                 <label class="col-sm-1">Alternate&nbsp;No&nbsp;<?=$astrik?></label>
                                 <div class="col-sm-3">
                                    <input type="text" id="altarnet_mobile" name="altarnet_mobile" class="form-control" placeholder="Alternate&nbsp;No" required="required"/>
                                 </div>
                              </div>
                              <div class="form-group">
                                 <label class="col-sm-1">State&nbsp;<?=$astrik?></label>
                                 <div class="col-sm-3">
                                    <select  id="state_id" name="state_id" class="form-control" required="required">
                                       <option value="">select</option>
                                       <?php
                                          if(!empty($states)){
                                              foreach($states as $stat){
                                                  ?>
                                       <option value="<?=$stat['state_id']?>"
                                          <?php
                                             if(isset($stud->state_id) && !empty($stud->state_id ) && $stud->state_id==$stat['state_id']){
                                              echo "selected";
                                             }
                                             ?>
                                          ><?=$stat['state_name']?></option>
                                       <?php 
                                          }
                                          }
                                          ?>
                                    </select>
                                 </div>
                                 <label class="col-sm-1">District&nbsp;<?=$astrik?></label>
                                 <div class="col-sm-3">
                                    <select  id="district_id" name="district_id" class="form-control" required="required"></select>
                                 </div>
                                 <label class="col-sm-1">City&nbsp;<?=$astrik?></label>
                                 <div class="col-sm-3">
                                    <select id="city_id" name="city_id" class="form-control" required="required"></select>
                                 </div>
                              </div>
                              <div class="form-group">
                                 <label class="col-sm-1">Pincode<?=$astrik?></label>
                                 <div class="col-sm-3"><input type="text" id="pincode" name="pincode" class="form-control" placeholder="Pincode" required="required" /></div>
                                 <label class="col-sm-1">&nbsp;Type<?=$astrik?></label>
                                 <div class="col-sm-3">
                                    <select name="admission_type" id="admission_type" class="form-control" onchange="get_fees_value()" required="required">
                                       <option value="">Select Type</option>
                                       <option value="1">First Year</option>
                                       <option value="2">Lateral Entry</option>
                                    </select>
                                 </div>
                                 <label class="col-sm-1">Gender<?=$astrik?></label>
                                 <div class="col-sm-3">
                                    <div class="">
                                       <label class="radio-container m-r-45">Male
                                       <input type="radio" name="gender" id="gender" value="M" required="required">
                                       </label>
                                       <label class="radio-container">Female
                                       <input type="radio" name="gender" id="gender" value="F">
                                       </label>
                                    </div>
                                 </div>
                              </div>
                              <div class="form-group">
                                 <label class="col-sm-1">Aadhar&nbsp;Card</label>
                                 <div class="col-sm-3"><input type="text" id="aadhar_card" name="aadhar_card" class="form-control" placeholder="" minlength="12" required="required"/></div>
                                 <label class="col-sm-1">Category<?=$astrik?></label>
                                 <div class="col-sm-5">
                                    <label class="radio-inline "><input type="radio" name="category" id="category" value="Open" required="required">GEN </label>
                                    <label class="radio-inline"><input type="radio" name="category" id="category" value="ST">ST </label>
                                    <label class="radio-inline"><input type="radio" name="category" id="category" value="SC">SC</label>
                                    <label class="radio-inline"><input type="radio" name="category" id="category" value="NT">NT</label>
                                    <label class="radio-inline"><input type="radio" name="category" id="category" value="OBC">OBC</label>
                                    <label class="radio-inline"><input type="radio" name="category" id="category" value="SBC">SBC</label>
                                 </div>
                              </div>
                     </div> 
                     </fieldset>
                     <fieldset class="scheduler-border">
                     <legend class="scheduler-border">Program Details:</legend>
                     <div class="form-group">
                     <label class="col-sm-1">Last&nbsp;Exam<?=$astrik?></label>
                     <div class="col-sm-3">
                     <select id="last_qualification" name="last_qualification" class="form-control"  onChange="get_school(this.value);" required="required">
                     <option value="">Select Highest Qualification</option>
                     <option value="SSC" <?php
                        if(isset($stud->last_qualification) && !empty($stud->last_qualification ) && $stud->last_qualification=="SSC"){
                         echo "selected";
                        }
                        ?> > SSC	</option>
                     <option value="HSC" <?php
                        if(isset($stud->last_qualification) && !empty($stud->last_qualification ) && $stud->last_qualification=="HSC"){
                         echo "selected";
                        }
                        ?>> HSC </option>
                     <option value="UG" <?php
                        if(isset($stud->last_qualification) && !empty($stud->last_qualification ) && $stud->last_qualification=="UG"){
                         echo "selected";
                        }
                        ?>> UG Degree </option>
                     <option value="PG" <?php
                        if(isset($stud->last_qualification) && !empty($stud->last_qualification ) && $stud->last_qualification=="PG"){
                         echo "selected";
                        }
                        ?>> PG Degree </option>
                     <option value="afterDP" <?php
                        if(isset($stud->last_qualification) && !empty($stud->last_qualification ) && $stud->last_qualification=="afterDP"){
                         echo "selected";
                        }
                        ?>> Diploma (Direct Second Year)</option>
                     </select>
                     </div>
                     <label class="col-sm-1">Percents%<?=$astrik?></label>
                     <div class="col-sm-3">
                     <input type="text" id="qualification_percentage" name="qualification_percentage" class="form-control" placeholder="" required="required"/>
                     </div>
                     <label class="col-sm-1"></label>
                     <div class="col-sm-3">
                     </div>
                     </div>
                     <!--<div class="form-group">
                        <label class="col-sm-1">PCM<?=$astrik?></label>
                        <div class="col-sm-3"></div> 
                        <label class="col-sm-1">PCB%<?=$astrik?></label>
                        <div class="col-sm-3">
                         <input type="text" id="Percents" name="qualification_percentage" class="form-control" placeholder="" />
                        </div>                                    
                        <label class="col-sm-1"></label>
                        <div class="col-sm-3">
                        
                        </div>          
                            </div>-->
                     <div class="form-group">
                     <label class="col-sm-1">School<?=$astrik?></label>
                     <div class="col-sm-3"><select id="school_id" name="school_id" class="form-control" onChange="load_courses(this.value)" required="required"></select></div>
                     <label class="col-sm-1">Course<?=$astrik?></label>
                     <div class="col-sm-3"> <select id="course_id" name="course_id" class="form-control" onChange="load_streams(this.value)" required="required"></select>
                     </div>
                     <label class="col-sm-1">Stream<?=$astrik?></label>
                     <div class="col-sm-3">
                     <select id="stream_id" name="stream_id" class="form-control"  onChange="get_fees_value()" required="required"></select>
                     </div>
                     </div>
                     <div class="form-group">
                     <label class="col-sm-1">Total Fees</label>
                     <div class="col-sm-3"><input type="text" id="actual_fee" name="actual_fee" readonly class="form-control col-sm-3" value="<?php
                        if(isset($stud->actual_fee) && !empty($stud->actual_fee ) ) { echo $stud->actual_fee; } ?>" ></div>
                    <!-- <label class="col-sm-1">Tution&nbsp;Fees</label>
                     <div class="col-sm-3">
                     <input type="text" id="tution_fees" name="tution_fees" readonly class="form-control col-sm-3"  value="<?php
                       // if(isset($stud->tution_fees) && !empty($stud->tution_fees ) ) { echo $stud->tution_fees; } ?>" >
                     </div>-->
                     </div>
                     </fieldset>	
                     <fieldset class="scheduler-border">
                     <legend class="scheduler-border"> Admission Form: YES&nbsp;<input type="radio" id="FormTaken"  name="form_taken" value="Y" onchange="Form_check(this);">&nbsp;NO
                     <input type="radio" id="FormTaken"  name="form_taken"  value="N" onchange="Form_check(this);"></span>
                     </legend>
                     
                     <div id="FTaken" style="display:none;">
                     <div class="form-group"></div>
                     <!--                                           original_price - (original_price * discount / 100)
                        -->                                           
                     <div class="form-group">
                     <label class="col-sm-2">Amount <?=$astrik?></label>                                     
                     <div class="col-sm-3"><input type="text" id="amount"  name="form_amount"  readonly class="form-control"  value="1000" placeholder="" /></div>
                     <!--<label class="col-sm-2">Mobile<?=$astrik?></label>
                     <div class="col-sm-3"><input type="text" id="form_mobile"  name="form_mobile" class="form-control" />-->
                     <?php  /*if(isset($validation_errors)) { ?>
                     <span style='color:red;'>You have already registered with us using this mobile no.</span> <?php } else
                        {?> <span id="errormsg"></span> <?php } */?>
                     
                     </div>
                    
                     <div class="form-group">
                     <label class="col-sm-2">Form no: <?=$astrik?> </label>         
                     <div class="col-sm-3">
                     <div  id="dshow" style="display:none;">
                     </div>
                     <input type="text"  id="form_no" name="form_no" class="form-control"  placeholder="Form No" onblur="return chek_duplicate_formno_exist(this.value)" />
                     <!--onblur="return chek_duplicate_formno_exist(this.value)"--><?php  if(isset($validation_errors1)) { ?>
                     <span style='color:red;'>You have already registered with us using this form no.</span> <?php } else
                        {?> <span id="errormsgform"></span> <?php } ?>
                     </div>
                     <label class="col-sm-2">Payment Mode: <?=$astrik?> </label> 
                     <div class="col-sm-3">
                     <select name="payment_mode" class="form-control" id="payment_mode" onchange="getdd_details(this)" >
                     <option value="">Select Payment type</option>
                     <option value="CASH">Cash</option>
                     <option value="OL">ONLINE</option>
                     <option value="POS">POS</option>
                     <option value="CC">CC</option>
                     <option value="DC">DC</option>
                     <option value="NB">NB</option>
                     </select>
                     </div>
                     </div>
                     
                     <div class="form-group">
                     <input type="hidden" id="acyear" name="acyear" class="form-control col-sm-8" value="2020">
                     <div class="col-sm-6"></div>
                     <label class="col-sm-1 Transaction_lable"></label>
                     <div class="col-sm-3 Transaction_box" style="display: none;">
                     <input type="text" name="TransactionNo" id="TransactionNo" class="form-control"  placeholder=""/>
                     </div>
                     </div>
                      </div>
                     <!--<div class="form-group">
                        <label class="col-sm-2"></label>          
                        <label class="col-sm-2"><button class="btn btn-primary form-control" id="btn_submit" type="button" >Amount Receive</button></label>
                                  
                        
                             </div>-->
                     <!--<div class="form-group">
                        <input class="form-control" type="hidden" name="picture" id="picture" style="display: none;" />
                        <input type="file" name="ddno" id="ddno"  class="form-control" style="display: none;" />
                        <div class="col-sm-3">               
                        <input type="text" name="check" class="form-control"  placeholder=" Enter Check Number" id="check" style="display: none;" />
                        <input type="text" name="DDno" class="form-control"  placeholder=" Enter DD Number" id="DDNo" style="display: none;" />
                        </div>
                        <div class="col-sm-3">
                        <input type="text" name="BankName" class="form-control"  placeholder=" Enter Bank Name" id="BankName" style="display: none;" /></div>
                                                 </div>-->   
                     <!-- Transfer to Admission center -->	 
                     <?php /* if($mobile_from!=""){?>
                     <div class="form-group">
                     <div class="col-sm-4">
                     <label>Forward to Admission Center&nbsp;</label> 
                     <input type="radio" name="TransToAdmin"  class="TransToAdmin" value="Y" checked="checked"> Yes
                     <input type="radio" name="TransToAdmin"  class="TransToAdmin" value="N" /> No
                     </div>
                     </div>
                     <div class="NoTranstoAdmin" style="display:none;">
                     <label class="col-sm-3">Admission Date</label> 
                     <div class="col-md-2"><input type="text" name="revisit_date" id="revisit_date" class="form-control" value="" placeholder="Date of Admission" /></div>
                     <textarea name="NoTranstoAdmin" id="NoTranstoAdmin" placeholder="Reason" required='required'></textarea>
                     </div>
                     <?php } */?>
                     <!-- END of Transfer to Admission center -->
                     </div>
                     </fieldset>
                     <fieldset class="scheduler-border">
                     <legend class="scheduler-border">Hostel Allowed: YES&nbsp;<input type="radio" id="hostel_allowed"  name="hostel_allowed" value="Y">&nbsp;NO
                  <input type="radio" id="hostel_allowed"  name="hostel_allowed" value="N"></legend>
                     </fieldset>
                     <?php /*if(($role_id==24)||($role_id==23))*/{?>
                     
                     <fieldset class="scheduler-border" style="">
                     <legend class="scheduler-border">Scholarship:
                     YES&nbsp;<input type="radio" class="Scholarship_Allowed" value="YES" id="Scholarship_Allowed" name="scholarship_allowed" />
                     &nbsp;NO&nbsp;<input type="radio" class="Scholarship_Allowed" value="NO" id="Scholarship_Allowed" name="scholarship_allowed" />
                     :</legend>
                     <div class="form-group">&nbsp;</div>
                     <div class="form-group" style="display:none;">
                     <label class="col-sm-2">Scholarship&nbsp;Type&nbsp;<?=$astrik?></label>
                     <div class="col-sm-5">
                     <?php foreach($Scholarship_type as $type)
                        { ?>
                     <?php echo str_replace('_',' ',$type['type']);?>&nbsp;<input type="checkbox" class="Scholarship_type" value="<?php echo $type['type'];?>" id="<?php echo $type['type'];?>" name="Scholarship_type[]" />
                     <?php } ?>
                     </div>
                     <div class="col-sm-3">
                     </div>
                     </div>
                     <div class="Scholarship_allow" style="display:none;">
                     <div class="Other_ship">
                     <h3>Other Scholarship</h3>
                     <div class="form-group">
                     <?php foreach($Scholarship_typee as $Other) { 
                        if(($Other['type']=="Other_Scholarship")&&($Other['state_wise']=="ALL")&&($Other['year']==0))
                        {
                        ?>
                     <div class="">
                     <input type="radio" name="Other_Scholarship_selected" value="<?php echo $Other['s_id'];?>" 
                        id="apply_Other" class="Other_Scholarship"  lang="<?php echo $Other['consession_allowed'];?>" />&nbsp;<?php echo $Other['schlorship_name'];?>&nbsp;(<?php echo $Other['Criteria'];?>)&nbsp;(<?php echo $Other['consession_allowed'];?>)%
                     </div>
                     <?php }} ?>
                     <!--  <input type="radio" name="Other_Scholarship_selected" value="<?php echo $Other['s_id'];?>" 
                        id="apply_Other" class="Other_Scholarship"  lang="0" />
                                    -->    <input type="hidden" name="Other_samount" id="Other_samount" value="0" />                 
                     </div>
                     </div>
                     <div class="Sports_ship">
                     <h3>Sports Scholarship</h3>
                     <div class="form-group">
                     <?php foreach($Scholarship_typee as $Sports) { 
                        if(($Sports['type']=="Sports_Scholarship")&&($Sports['state_wise']=="ALL")&&($Sports['year']==1)){
                        ?>
                     <div class="">
                     <input type="radio" name="Other_Scholarship_selected" value="<?php echo $Sports['s_id'];?>" id="apply_Sports" 
                        lang="<?php echo $Sports['consession_allowed'];?>" class="Sports_Scholarship" />&nbsp;<?php echo $Sports['schlorship_name'];?>&nbsp&nbsp;(<?php echo $Sports['consession_allowed'];?>)%
                     </div>
                     <?php }} ?> 
                     <input type="hidden" name="Sports_samount" id="Sports_samount" value="0" />                          
                     </div>
                     </div>
                     <div class="Merit_ship" style="">
                     <div class="form-group">
                     <h3>Merit Scholarship</h3>
                     <!--<div class="col-sm-2 Other_Scholarship"></div> -->
                     <div class="col-sm-6 Merit_Scholarship">
                     MH&nbsp;<input type="radio" value="MH" class="Scholarship_state" name="Scholarship_state" onchange="Scholarship_change(this)" />&nbsp;OMH&nbsp;<input type="radio" value="OMH" class="Scholarship_state" name="Scholarship_state" onchange="Scholarship_change(this)"/>
                     </div>
                     <!--<div class="col-sm-2 Sports_Scholarship"></div>      -->  
                     </div>
                     <div class="MH" style="display:none;">
                     <div class="form-group">
                     <?php foreach($Scholarship_typee as $typee) { 
                        if(($typee['type']=="Merit_Scholarship")&&($typee['state_wise']=="MH")&&($typee['year']==1))
                        {
                        ?>
                     <div class=""><input type="radio" name="Other_Scholarship_selected" value="<?php echo $typee['s_id'];?>" 
                        id="apply_Merit" class="Merit_Scholarship"  lang="<?php echo $typee['consession_allowed'];?>" />&nbsp;<?php echo $typee['schlorship_name'];?>&nbsp;(<?php echo $typee['Criteria'];?>)&nbsp;(<?php echo $typee['consession_allowed'];?>)%</div>
                     <?php }} ?>                           
                     </div>
                     </div>
                     <div class="OMH" style="display:none;">
                     <div class="form-group">
                     <?php foreach($Scholarship_typee as $typee) { 
                        if(($typee['type']=="Merit_Scholarship")&&($typee['state_wise']=="OMH")&&($typee['year']==1))
                        {
                        ?>
                     <div class=""><input type="radio" name="Other_Scholarship_selected" value="<?php echo $typee['s_id'];?>" 
                        id="apply_Merit" class="Merit_Scholarship" lang="<?php echo $typee['consession_allowed'];?>"/>&nbsp;<?php echo $typee['schlorship_name'];?>&nbsp;(<?php echo $typee['Criteria'];?>)&nbsp;(<?php echo $typee['consession_allowed'];?>)%</div>
                     <?php }} ?>  
                     <input type="hidden" name="Merit_samount" id="Merit_samount" value="0" />                         
                     </div>
                     </div>
                     </div>
                     
                     <!--<div class="form-group">
                     <label class="col-sm-1">Tution&nbsp;Fees</label>
                     <div class="col-sm-3">
                     <input type="text" id="tution_fees" name="tution_fees" readonly class="form-control col-sm-3"  value="<?php
                      //  if(isset($stud->tution_fees) && !empty($stud->tution_fees ) ) { echo $stud->tution_fees; } ?>" >
                     </div>
                     </div>-->
                     <div class="form-group">
                      <label class="col-sm-2">Tution Fees</label>
                     <div class="col-sm-3"><input type="text" id="tution_fees"  name="tution_fees" class="form-control" readonly="readonly" value="<?php
                      //  if(isset($stud->tution_fees) && !empty($stud->tution_fees ) ) { echo $stud->tution_fees; } ?>" /></div>
                     <label class="col-sm-2">Scholarship Amount</label>
                     <div class="col-sm-3"><input type="text" id="Scholarship_Amount"  name="scholarship_amount" class="form-control" readonly="readonly" /></div>
                     </div>
                     <div class="form-group">&nbsp;</div>
                     <div class="form-group">
                     <label class="col-sm-2">&nbsp;Without&nbsp;Scholarship 25% Pay</label>
                     <div class="col-sm-3">
                     <input type="text" id="without_scholarship" name="without_scholarship" class="form-control" readonly value="<?php
                       // if(isset($stud->actual_fee) && !empty($stud->actual_fee ) ) { echo round(25/100*$stud->actual_fee); } ?>">
                     </div>
                     <label class="col-sm-2">&nbsp;With&nbsp;Scholarship 25% Pay</label>
                     <div class="col-sm-3"><input type="text" id="with_scholarship"  name="with_scholarship" class="form-control col-sm-2"  readonly="readonly"/></div>
                     </div>
                     
                     <div class="form-group final_Pay" style="display:none">
                     <label class="col-sm-2"></label>
                     <div class="col-sm-3">
                     
                     </div>
                     <label class="col-sm-2">&nbsp;Final Pay</label>
                     <div class="col-sm-3"><input type="text" id="final_Pay"  name="final_Pay" class="form-control col-sm-2" value=""  readonly="readonly"/></div>
                     </div>
                     
                     <div class="form-group">&nbsp;</div>
                     <div class="form-group">&nbsp;</div>
                      <?php if(($role_id==24)){?>
                     <div class="form-group">
                     <label class="col-sm-2">Scholarship Status</label>
                     <div class="col-sm-3"><select name="scholarship_status" id="scholarship_status" class="form-control" >
                     <option value="">Select Status</option>
                     <option value="Approve">Approve</option>
                     <option value="Reject">Reject</option>
                     <option value="Pending">Pending</option>
                     </select></div>
                     </div>
                     <?php } ?>
                     </div>
                     </fieldset>
                     <?php } ?>
                     
                     <fieldset class="">
                   <!--  <legend class="scheduler-border">Hostel Allowed: YES&nbsp;<input type="radio" id="hostel_allowed"  name="hostel_allowed" value="Y">&nbsp;NO
                  <input type="radio" id="hostel_allowed"  name="hostel_allowed" value="N"></legend>-->
                     <div class="form-group">
                     <div class="row text-center">
<!--                     <button class="btn btn-primary" id="btn_submit" type="submit" >Submit</button>   
-->                     <button class="btn btn-primary" id="btn_cancel" type="button" onclick="History();">Back</button>
                   <!--  <button class="btn btn-primary" id="btn_pdf" type="button" style="display:none;">PDF</button> -->
                     </div>
                     </div>
                     </fieldset>
                     </form>
                  
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<script>

	function get_fees_value(){
   	  
   	   
   	   
           var strm_id = $("#stream_id").val();
           var acyear = $("#acyear").val();
   		 var admission_type = $("#admission_type").val();
   		
   
           if (strm_id && acyear  && admission_type ) {
   			$("#jpfees").val('');
   			//$("#without_scholarship").val('');
               $.ajax({
                   type: 'POST',
                   url: '<?= base_url() ?>Enquiry/fetch_academic_fees_for_stream_year',
                   data: {'strm_id' : strm_id,'acyear':acyear,'admission_type':admission_type},
                   success: function (resp) {
   					var obj = jQuery.parseJSON(resp);  
   					$("#actual_fee").val(parseInt(obj[0].total_fees));
   					$("#without_scholarship").val(parseInt(25/100 * obj[0].tution_fees));
   					$("#tution_fees").val(parseInt(obj[0].tution_fees));
   					
                      
                   }
               });
           } else {
   			/*if(is_admission_type_on_change==0){
   				if(strm_id==''){
   					alert("Please Select Stream");
   				}
   				else if(acyear==""){
   					alert("Please Select Admission year");
   				}
   				else if(admission_type==""){
   					alert("Please Select Admission type");
   				}
   			}*/
               //alert("Please enter registration no");
   
           }
       }		


   function state_call(stateID,stt=0){
    var datavalue={'state_id':stateID,'stt':stt}
      $.ajax({
                  type: 'POST',
                  url:'<?= base_url() ?>Enquiry/getStatewiseDistrict',              
                  data: datavalue,
                  success: function (html) {
                      //alert(html);
                      $('#district_id').html(html);
                  }
              });
     
    }
   
   function distic_call(stateID,district_id,stt=0){
    $.ajax({
                  type: 'POST',
                  url: '<?= base_url() ?>Enquiry/getStateDwiseCity',     
                  data: 'state_id=' + stateID+"&district_id="+district_id+"&stt="+stt,
                  success: function (html) {
                      //alert(html);
                      $('#city_id').html(html);
                  }
              });
   }
   
      $(function(){
     var enquiryparamer='<?php echo $enquiryparamer; ?>';
	 var mobilnparamer='<?php echo $mobilnparamer; ?>';
	 if((enquiryparamer!='')||(mobilnparamer!='')){
	 $("#btnsearch").trigger('click');
	 }
    /* if(mobilnparamer!='')
     {
       var values={mobile_no:mobile,Enquiry_search:mobilnparamer}
                $.ajax({
                    type:'POST',
                    url: '<?php echo base_url()?>Enquiry/Serach_details', 
                    data: values,
                    success: function (resp) {
   				//  alert(resp);
                      document.forms["form"].reset();
                      $('#returnMessage').html('');
                      $("#sname").prop('readOnly', false);
                      $("#email").prop('readOnly', false);
                      $("#mobile").prop('readOnly', false);
                      $('#course_type').html('<option value="">--Select--</option><option value="R" selected>Regular</option><option value="P">Part time</option>');
                      $("#course_type").prop('disabled', false);
                      $('#coursen').html('<option value=""> Select Course </option>');
                      $("#coursen").prop('disabled', false);
                      $("#email").prop('readOnly', false);
                      $("#amount").val();
                      $("#formno").val();
                      $("#formno").prop('disabled', false);
                      $('#paymentmode').html('<option value=""> Select Payment Type </option><option value="CASH">Cash</option><option value="OL">Online</option><option value="POS">POS</option>');
                      $("#paymentmode").prop('disabled', false);
                      if(resp=='no')
                      {
                        //alert('test');
   
                        $("#show_form").show();
                        $("#mobile").val(mobile);
                        var coursetype = $("#course_type").val();
                        var reg='Regular';
                        var coursetype='R';
                        $("#course_type").val(coursetype);
                        // var coursetype = coursetype;
                        
                         //alert(coursetype);
                     
                           else{ 
                                $('#coursen').html('<option value="" required >Select course type first</option>'); 
                             }
                             if(coursetype=='R')
                             {
                               $("#amount").val('1000');
                               $("#dshow").show();var fno='20R01'; 
                               $("#formno").val(fno);
                             }
                             else{
                                $("#dshow").show();
                                var fno='19P02';
                                $("#formno").val(fno);
                             
                                 $("#amount").val('1000'); 
                              }
                      }else{  alert(mobilnparamer);
                          $("#show_form").show();
                        var mob = JSON.parse(resp);
                        var form_no =mob[0]['adm_form_no'];
   				  $(".enquiry_no").show();
                        var enquiry_no =mob[0]['enquiry_no'];
   				  $(".enquiry_no").val(enquiry_no);
   				  
   				  if(mob[0]['enquiry_no']!="")
   				  {
   					  $("#form").attr('action', "<?php echo base_url(); ?>Enquiry/Updated");
   					  $("#btn_submit").html('Update');
   				  }
   				  $("#enquiry_id").val(mob[0]['enquiry_id'])
   				  $("#first_name").val(mob[0]['first_name']);
   				  $("#middle_name").val(mob[0]['middle_name']);
   				  $("#last_name").val(mob[0]['last_name']);
   				  $("#email_id").val(mob[0]['email_id']);
   				  $("#mobile").val(mob[0]['mobile']);
   				  $("#altarnet_mobile").val(mob[0]['altarnet_mobile']);
   				  
   				  $("#state_id").val(mob[0]['state_id']);
   				 // state_call(mob[0]['state_id'],mob[0]['district_id']);
   				  setTimeout(function() { state_call(mob[0]['state_id'],mob[0]['district_id']); }, 500);
   				  $("#district_id").val(mob[0]['district_id']);
   				  $("#city_id").val(mob[0]['city_id']);
   				 // distic_call(mob[0]['state_id'],mob[0]['district_id'],mob[0]['city_id']);
   				  setTimeout(function() { distic_call(mob[0]['state_id'],mob[0]['district_id'],mob[0]['city_id']); }, 1000);
   				  
   				  $("#pincode").val(mob[0]['pincode']);
   				  $("#admission_type").val(mob[0]['admission_type']);
   				  
   				 // $("#gender").val(mob[0]['gender']);
   				  $("input[name=gender][value=" + mob[0]['gender'] + "]").prop('checked', true);
   
   				  $("#aadhar_card").val(mob[0]['aadhar_card']);
   				 // $("#category").val(mob[0]['category']);
   				   $("input[name=category][value=" + mob[0]['category'] + "]").prop('checked', true);
   				   ///////////////////////////////////////////////////////////////////////////////////////////////////////
   				   $("#last_qualification").val(mob[0]['last_qualification']);
   				   get_school(mob[0]['last_qualification'],mob[0]['school_id']);
   				   $("#qualification_percentage").val(mob[0]['qualification_percentage']);
   				   $("#school_id").val(mob[0]['school_id']);
   				  
   				   $("#course_id").val(mob[0]['course_id']);
   				   // load_courses(mob[0]['school_id'],mob[0]['course_id']);
   					setTimeout(function() { load_courses(mob[0]['school_id'],mob[0]['course_id']); }, 500);
   				   $("#stream_id").val(mob[0]['stream_id']);
   				   setTimeout(function() { load_streams(mob[0]['course_id'],mob[0]['stream_id']); }, 1000);
   				   
   				   
   				   $("#actual_fee").val(mob[0]['actual_fee']);
   				   $("#tution_fees").val(mob[0]['tution_fees']);
   				   
   				   //$("#form_taken").val(mob[0]['form_taken']);
   				   $("input[name=form_taken][value=" + mob[0]['form_taken'] + "]").prop('checked', true);
   				   if(mob[0]['form_taken']=="Y"){
   					   $("#FTaken").show();
   				   }else{
   					   $("#FTaken").hide();
   				   }
   				   $("#form_amount").val(mob[0]['form_amount']);
   				   $("#form_mobile").val(mob[0]['form_mobile']);
   				   $("#form_no").val(mob[0]['form_no']);
   				   $("#payment_mode").val(mob[0]['payment_mode']);
   				   $("#TransactionNo").val(mob[0]['recepit_no']);
                       
                          
                      }
                      
   
                    
                    }                      
                  });
   
     }
     else
     {
      return false;
   
     }*/
     
	 
	 
   });
    $('.numbersOnly').keyup(function () {
        if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
          this.value = this.value.replace(/[^0-9\.]/g, '');
        }
      }); 
   
   
   
   $('.Scholarship_Allowed').click(function(){
   var value=$(this).val();
   
   if(value=="YES")	{
   $('.Scholarship_allow').show();
   
   }else{
   $('#Scholarship_Amount').val('');
   //$('#without_scholarship').val('');
   $('#with_scholarship').val('');
   $('.Other_Scholarship').prop('checked', false); // Unchecks it
   $('.Sports_Scholarship').prop('checked', false); // Unchecks it
   $('.Merit_Scholarship').prop('checked', false); // Unchecks it
   $('.Scholarship_allow').hide();
   }
   
   
   })
   
   $('.Scholarship_type').click(function(){
   
   var value=$(this).val();
   
   if($('#Merit_Scholarship ').is(':checked')){
   
   if(value=="Merit_Scholarship")	{
   $('.Merit_ship').show();
   $('.State_lable').html('State Wise');
   $('.Merit_Scholarship').show(); //html('MH&nbsp;<input type="radio" value="MH" class="Scholarship_state" name="Scholarship_state" onclick="Scholarship_state(this)" />&nbsp;OMH&nbsp;<input type="radio" value="OMH" class="Scholarship_state" name="Scholarship_state" onclick="Scholarship_state(this)"/>');
   }
   
   }else{
   $('.State_lable').html('');
   $('.Merit_Scholarship').hide();
   $('.Merit_ship').hide();
   }
   
   
   
   if($('#Other_Scholarship ').is(':checked')){
   /*if(value=="Other_Scholarship")	{
   }*/
   $('.Other_ship').show();
   }else{
   $('.Other_ship').hide();}
   if($('#Sports_Scholarship ').is(':checked')){
   /*if(value=="Sports_Scholarship")	{
   }*/	
   $('.Sports_ship').show();
   }else{
   $('.Sports_ship').hide();
   }
   
   });
   //var arr = [];
   
   ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
   
    $('.Other_Scholarship').change(function(){
   
   var id=$(this).attr('id');
   ///$('.Sports_Scholarship').attr
  // $('.Other_Scholarship').prop('checked', false); // Unchecks it
  // $('.Sports_Scholarship').prop('checked', false); // Unchecks it
   //$('.Merit_Scholarship').prop('checked', false); // Unchecks it
   //var Other_samount=$("#Other_samount").val();
   $("#Other_samount").val(0);
   var Sports_samount=$("#Sports_samount").val();
   var Merit_samount=$("#Merit_samount").val();
   if ($("[id=" + id+ "]:checked").length == 1) {
   var lang=$(this).attr('lang');
   var actual_fee=$("#actual_fee").val();
   var tution_fees=$("#tution_fees").val();
   if(lang==0){
   	var discount=0;
   	}else{
   var discount=parseInt((tution_fees * lang / 100));
   }
   //var discount=parseInt((tution_fees * lang / 100));
   //var Currentamount=parseInt(actual_fee - discount);
   
   var Currentamount=parseInt(actual_fee -  discount);
    alert("Discount Amount: "+discount+" Total paid "+Currentamount);
    var total_Scholarship=parseInt(Sports_samount) +parseInt(Merit_samount)+parseInt(discount);
   
    $("#Other_samount").val(discount);
    $("#Scholarship_Amount").val(Math.round(total_Scholarship));
     
    var paid=parseInt(tution_fees)-parseInt(total_Scholarship);
    var total_paid=(25/100)*(parseInt(paid));
    var fees=(25/100)*parseInt(tution_fees);
	
	if(total_paid==0){
	$('.final_Pay').show();
	var finala=actual_fee - tution_fees;
	$("#final_Pay").val(Math.round(finala));
	}else{$('.final_Pay').hide();}
	//$("#without_scholarship").val(Math.round(fees));
    $("#with_scholarship").val(Math.round(total_paid));
    //$('.Sports_Scholarship').trigger('change');
	//$('.Merit_Scholarship').trigger('change');
   }
   });
      ////////////////////////////////////////////////////////////////////////////////////////////////////////////////

   $('.Sports_Scholarship').change(function(){
   
   var id=$(this).attr('id');
   // $('.Other_Scholarship').prop('checked', false); // Unchecks it
   //$('.Sports_Scholarship').prop('checked', false); // Unchecks it
   //$('.Merit_Scholarship').prop('checked', false); // Unchecks it
   var Other_samount=$("#Other_samount").val();
   //var Sports_samount=$("#Other_samount").val();
   $("#Sports_samount").val(0);
   var Merit_samount=$("#Merit_samount").val();
   if ($("[id=" + id+ "]:checked").length == 1) {
   var lang=$(this).attr('lang');	
   var actual_fee=$("#actual_fee").val();
   var tution_fees=$("#tution_fees").val();
   if(lang==0){
   	var discount=0;
   	}else{
   var discount=parseInt((tution_fees * lang / 100));
   }
   //var Currentamount=parseInt(actual_fee - discount);
   
   var Currentamount=parseInt(actual_fee -  discount);
    alert("Discount Amount: "+discount+" Total paid "+Currentamount);
    var total_Scholarship=parseInt(Other_samount) + parseInt(Merit_samount) +parseInt(discount);
   // alert(Other_samount+"_"+Merit_samount+"_"+discount);
    $("#Sports_samount").val(discount);
    $("#Scholarship_Amount").val(Math.round(total_Scholarship));
    
     var paid=parseInt(tution_fees)-parseInt(total_Scholarship);
    var total_paid=(25/100)*(parseInt(paid));
    var fees=(25/100)*parseInt(tution_fees);
	
	if(total_paid==0){
	$('.final_Pay').show();
	var finala=actual_fee - tution_fees;
	$("#final_Pay").val(Math.round(finala));
	}else{$('.final_Pay').hide();}
	
	//$("#without_scholarship").val(Math.round(fees));
    $("#with_scholarship").val(Math.round(total_paid));
   }
 //  $('.Other_Scholarship').trigger('change');
	//$('.Merit_Scholarship').trigger('change');
   });
   
      ////////////////////////////////////////////////////////////////////////////////////////////////////////////////

   $('.Merit_Scholarship').change(function(){
   
   var id=$(this).attr('id');
   var qualification_percentage=$("#qualification_percentage").val();
  //   $('.Other_Scholarship').prop('checked', false); // Unchecks it
  // $('.Sports_Scholarship').prop('checked', false); // Unchecks it
  // $('.Merit_Scholarship').prop('checked', false); // Unchecks it
   var Other_samount=$("#Other_samount").val();
   var Sports_samount=$("#Other_samount").val();
   $("#Merit_samount").val(0);
   if ($("[id=" + id+ "]:checked").length == 1) {
   	var lang=$(this).attr('lang');
   	var actual_fee=$("#actual_fee").val();
   var tution_fees=$("#tution_fees").val();
   if(lang==0){
   	var discount=0;
   	}else{
   var discount=parseInt((tution_fees * lang / 100));
   }
   //var discount=parseInt((tution_fees * lang / 100));
   //var Currentamount=parseInt(actual_fee - discount);
   
   var Currentamount=parseInt(actual_fee -  discount);
    alert("Discount Amount: "+discount+" Total paid "+Currentamount);
    
    var total_Scholarship=parseInt(Other_samount) + parseInt(Sports_samount) +parseInt(discount);
    $("#Merit_samount").val(discount);
    $("#Scholarship_Amount").val(Math.round(total_Scholarship));
    
    
    var paid=parseInt(tution_fees)-parseInt(total_Scholarship);
    var total_paid=(25/100)*parseInt(paid);
	var fees=(25/100)*parseInt(tution_fees);
	
	if(total_paid==0){
	$('.final_Pay').show();
	var finala=actual_fee - tution_fees;
	$("#final_Pay").val(Math.round(finala));
	}else{$('.final_Pay').hide();}
	//$("#without_scholarship").val(Math.round(fees));
    $("#with_scholarship").val(Math.round(total_paid));
   }
  // $('.Other_Scholarship').trigger('change');
	//$('.Sports_Scholarship').trigger('change');
   });
   
   
   //});
      ////////////////////////////////////////////////////////////////////////////////////////////////////////////////

   
    $("#btnsearch").click(function(){
   
             $(".enquiry_no").hide();
            var mobile= $("#mobile_search").val();
   	        var Enquiry_search= $("#Enquiry_search").val();
            //alert(mobile);
            var filter = /^[0-9-+]+$/;
            if((mobile.length >= 10)&&(filter.test(mobile))||(Enquiry_search!='')){
				
            //if((filter.test(mobile))||(Enquiry_search!=''))
			//{  //alert('2');
   		
   		
   		  var values={mobile_no:mobile,Enquiry_search:Enquiry_search}
                $.ajax({
                    type:'POST',
                    url: '<?php echo base_url()?>Enquiry/Serach_details', 
                    data: values,
                    success: function (resp) {
   				//  alert(resp);
                      document.forms["form"].reset();
                      $('#returnMessage').html('');
                      $("#sname").prop('readOnly', false);
                      $("#email").prop('readOnly', false);
                      $("#mobile").prop('readOnly', false);
                      $('#course_type').html('<option value="">--Select--</option><option value="R" selected>Regular</option><option value="P">Part time</option>');
                      $("#course_type").prop('disabled', false);
                      $('#coursen').html('<option value=""> Select Course </option>');
                      $("#coursen").prop('disabled', false);
                      $("#email").prop('readOnly', false);
                      $("#amount").val();
                      $("#formno").val();
                      $("#formno").prop('disabled', false);
                      $('#paymentmode').html('<option value=""> Select Payment Type </option><option value="CASH">Cash</option><option value="OL">Online</option><option value="POS">POS</option>');
                      $("#paymentmode").prop('disabled', false);
                      if(resp=='no')
                      {
                        //alert('test');
   
                        $("#show_form").show();
                        $("#mobile").val(mobile);
                        var coursetype = $("#course_type").val();
                        var reg='Regular';
                        var coursetype='R';
                        $("#course_type").val(coursetype);
                        // var coursetype = coursetype;
                         if(coursetype!==''){
                          /*$.ajax({
                                  type:'POST',
                                  url:'<?= base_url()?>prospectus_fee_details/fetch_course_details',
                                  data:{coursetype:coursetype,select_course:select_course},
                                  success:function(html){
                                    $('#coursen').html(html);
                                  }
                              });*/
                          }
                         //alert(coursetype);
                     
                           else{ 
                                $('#coursen').html('<option value="" required >Select course type first</option>'); 
                             }
                             if(coursetype=='R')
                             {
                               $("#amount").val('1000');
                               $("#dshow").show();var fno='20R01'; 
                               $("#formno").val(fno);
                             }
                             else{
                                $("#dshow").show();
                                var fno='19P02';
                                $("#formno").val(fno);
                             
                                 $("#amount").val('1000'); 
                              }
                      }else{
                      $("#show_form").show();
                        var mob = JSON.parse(resp);
                        var form_no =mob[0]['adm_form_no'];
   				  $(".enquiry_no").show();
                        var enquiry_no =mob[0]['enquiry_no'];
   				  $(".enquiry_no").val(enquiry_no);
   				  
   				  if(mob[0]['enquiry_no']!="")
   				  {
   					  $("#form").attr('action', "<?php echo base_url(); ?>Enquiry/Updated");
   					 // $("#btn_submit").html('Update');
					  $("#btn_pdf").show();
   				  }
   				  $("#enquiry_id").val(mob[0]['enquiry_id'])
   				  $("#first_name").val(mob[0]['first_name']);
   				  $("#middle_name").val(mob[0]['middle_name']);
   				  $("#last_name").val(mob[0]['last_name']);
   				  $("#email_id").val(mob[0]['email_id']);
   				  $("#mobile").val(mob[0]['mobile']);
   				  $("#altarnet_mobile").val(mob[0]['altarnet_mobile']);
   				  
   				  $("#state_id").val(mob[0]['state_id']);
				  
				   if(mob[0]['state_id']==27){
			  // $('.Scholarship_state').prop("checked", true);
			   var value="MH";
			   $("input[name=Scholarship_state][value=" + value + "]").prop('checked', true);
			   $('.MH').show();
               $('.OMH').hide();
			   }else{
				  var value="OMH";
			   $("input[name=Scholarship_state][value=" + value + "]").prop('checked', true);
			   $('.MH').hide();
               $('.OMH').show(); 
			   }
				  
				  
				  
   				 // state_call(mob[0]['state_id'],mob[0]['district_id']);
   				  setTimeout(function() { state_call(mob[0]['state_id'],mob[0]['district_id']); }, 500);
   				  $("#district_id").val(mob[0]['district_id']);
   				  $("#city_id").val(mob[0]['city_id']);
   				 // distic_call(mob[0]['state_id'],mob[0]['district_id'],mob[0]['city_id']);
   				  setTimeout(function() { distic_call(mob[0]['state_id'],mob[0]['district_id'],mob[0]['city_id']); }, 1000);
   				  
   				  $("#pincode").val(mob[0]['pincode']);
   				  $("#admission_type").val(mob[0]['admission_type']);
   				  
   				 // $("#gender").val(mob[0]['gender']);
   				  $("input[name=gender][value=" + mob[0]['gender'] + "]").prop('checked', true);
   
   				  $("#aadhar_card").val(mob[0]['aadhar_card']);
   				 // $("#category").val(mob[0]['category']);
   				   $("input[name=category][value=" + mob[0]['category'] + "]").prop('checked', true);
   				   ///////////////////////////////////////////////////////////////////////////////////////////////////////
   				   $("#last_qualification").val(mob[0]['last_qualification']);
   				   get_school(mob[0]['last_qualification'],mob[0]['school_id']);
   				   $("#qualification_percentage").val(mob[0]['qualification_percentage']);
   				   $("#school_id").val(mob[0]['school_id']);
   				  
   				   $("#course_id").val(mob[0]['course_id']);
   				   // load_courses(mob[0]['school_id'],mob[0]['course_id']);
   					setTimeout(function() { load_courses(mob[0]['school_id'],mob[0]['course_id']); }, 500);
   				   $("#stream_id").val(mob[0]['stream_id']);
   				   setTimeout(function() { load_streams(mob[0]['course_id'],mob[0]['stream_id']); }, 1000);
   				   
   				   
   				   $("#actual_fee").val(mob[0]['actual_fee']);
   				   $("#tution_fees").val(mob[0]['tution_fees']);
				   $("#without_scholarship").val(mob[0]['without_scholarship']);
   				  // get_fees_value();
				   setTimeout(function() { get_fees_value(); }, 1000);
   				   //$("#form_taken").val(mob[0]['form_taken']);
   				   $("input[name=form_taken][value=" + mob[0]['form_taken'] + "]").prop('checked', true);
   				   if(mob[0]['form_taken']=="Y"){
   					   $("#FTaken").show();
   				   }else{
   					   $("#FTaken").hide();
   				   }
				   $("input[name=hostel_allowed][value=" + mob[0]['hostel_allowed'] + "]").prop('checked', true);
				 
				   
   				   $("#form_amount").val(mob[0]['form_amount']);
   				   $("#form_mobile").val(mob[0]['form_mobile']);
   				   $("#form_no").val(mob[0]['form_no']);
   				   $("#payment_mode").val(mob[0]['payment_mode']);
				    if(mob[0]['payment_mode']!='CHLN'){
						   $('.Transaction_box').show();
   					   $("#TransactionNo").val(mob[0]['recepit_no']);
					   $(".Transaction_lable").html('Recepit');
					   }else{
						    $(".Transaction_lable").html('');
						   $('.Transaction_box').hide();
					   }
   				   //$("#TransactionNo").val(mob[0]['recepit_no']);
                       
                  //  alert(mob[0]['scholarship_allowed']);
                       $("input[name=scholarship_allowed][value=" + mob[0]['scholarship_allowed'] + "]").prop('checked', true);
						   
				   if(mob[0]['scholarship_allowed']=="YES"){
   					$(".Scholarship_allow").show();
					$("input[name=Other_Scholarship_selected][value=" + mob[0]['other_scholarship'] + "]").prop('checked', true);
					$("input[name=Sports_Scholarship_selecet][value=" + mob[0]['sports_scholarship'] + "]").prop('checked', true);
					
					$("input[name=Scholarship_state][value=" + mob[0]['merit_state'] + "]").prop('checked', true);
					
					if(mob[0]['scholarship_allowed']=="MH"){
						$('.MH').show();
                    	$('.OMH').hide();
						$("input[name=Merit_Scholarship_selected][value=" + mob[0]['merit_scholarship'] + "]").prop('checked', true);
					}else{
						$('.MH').hide();
                     	$('.OMH').show();
					$("input[name=Merit_Scholarship_selected][value=" + mob[0]['merit_scholarship'] + "]").prop('checked', true);
					}
					//alert(mob[0]['without_scholarship']);
					//final_Pay
					//$("#without_scholarship").val(mob[0]['without_scholarship']);
					if(mob[0]['final_Pay']==0){$(".final_Pay").hide();}else{$(".final_Pay").show();}
					$("#final_Pay").val(mob[0]['final_Pay']);
					$("#Scholarship_Amount").val(mob[0]['scholarship_amount']);
					
					$("#with_scholarship").val(mob[0]['with_scholarship']);
					$("#scholarship_status").val(mob[0]['scholarship_status']);
   					}else{
					$("#Scholarship_Amount").val(' ');
					//$("#without_scholarship").val(' ');
					$("#with_scholarship").val(' ');
   					$(".Scholarship_allow").hide();
   					   }       
                      }
                      
   
                    
                    }                      
                  });
                return true;
              }else {
                alert('Please enter correct mobile no');
                $("#mobile_search").focus();
                return false;
              }
			  
			  
            //}
   
          });
   
   
   
    ///below code
   $(document).ready(function(){
   
   $('#pdob').datepicker({
    format: 'yyyy-mm-dd',
    autoclose: true
   
    
   }).on('change',function(e){
    var selecteddate=$(this).val();
        var dt = new Date(selecteddate);
           dt.setDate( dt.getDate() -1 );
           var newdate=convert(dt);
           $("#reportdate").val(newdate);
      });
   
   
   //below function is used to Convert date from 'Thu Jun 09 2011 00:00:00 GMT+0530 (India Standard Time)' to 'YYYY-MM-DD' in javascript
   function convert(str) {
      var date = new Date(str),
          mnth = ("0" + (date.getMonth()+1)).slice(-2),
          day  = ("0" + date.getDate()).slice(-2);
      return [ date.getFullYear(), mnth, day ].join("-");
   }
   
   $('#visit_date').datepicker( {format: 'dd/mm/yyyy',autoclose: true});
   $('#cvisit_date').datepicker( {format: 'dd/mm/yyyy',autoclose: true});
   //$('#idTourDateDetails').timepicker({timeFormat: 'h:mm:ss p'});
   $('#idTourDateDetails').timepicker({
      defaultTime: '',
      minuteStep: 1,
      disableFocus: false,
      template: 'dropdown',
      showMeridian:false
   });
   
   });
   
   
</script>
<script>
   //find total function is used to calculate sum of all input box
   function findTotal(){
   
      var osearch= parseInt($('#osearch').val()) || 0;
      var psearch=parseInt($('#psearch').val()) || 0;
      var direct=parseInt($('#direct').val()) || 0;
      var refferal=parseInt($('#refferal').val()) || 0;
      var social=parseInt($('#social').val()) || 0;
      var sum=osearch+psearch+direct+refferal+social;
       document.getElementById('tvisitor').value =parseInt(sum);
   }
   
   $('#course_type').on('change', function () {
     var coursetype = $(this).val();
      if(coursetype!==''){
                $.ajax({
                         type:'POST',
                         url:'<?= base_url()?>Enquiry/fetch_course_details',
                         data:'coursetype='+coursetype,
                         success:function(html){
                             $('#coursen').html(html);
                         }
                     });
           }
         else{ 
              $('#coursen').html('<option value="" required >Select course type first</option>'); 
           }
           if(coursetype=='R')
           {
             $("#amount").val('1000');
             $("#dshow").show();var fno='20R01'; 
             $("#formno").val(fno);
           }
           else{
              $("#dshow").show();
              var fno='19P02';
              $("#formno").val(fno);
           
               $("#amount").val('1000'); 
           }
   });
   
   
     //check duplicate mobile no
       function chek_mob_exist(mob_no) {
       if (mob_no) {
         $.ajax({
           type: 'POST',
           url: '<?= base_url()?>Enquiry/chek_dupmobno_exist',
           data: 'mobile_no=' + mob_no,
           success: function (resp) {
             var resp1 = resp.split("~");
             var dup = resp1[0];
           
             var mob = JSON.parse(resp1[1]);
   
             if(dup=="Duplicate"){
               //alert("You have already registered with us using this mobile no.");
               $("#errormsg").html("<span style='color:red;''>You have already registered with us using this mobile no.</span>");
               $("#mobile").val("");
               $('#mobile').focus();
              //$("#btn_submit").prop('disabled', true);
               //alert(html);
               //$("#usrdetails").html(html);
               return false;
             }else{
             //  $("#btn_submit").prop('disabled', false);
               $("#errormsg").html("");
               return true
             }
             
           }
         });
       } else {
         
       }
     }
         //check duplicate form no
       function chek_duplicate_formno_exist(formno) {
       if (formno) {
         /*var course=$("#course_type").val();
   
         if(course=='R')
         {
           var newforno=formno;
         }
         else
         {//for parttime even semster
           var newforno=formno;
         }*/
   	   var newforno=formno;
           $.ajax({
           type: 'POST',
   		async : false,
           url: '<?= base_url()?>Enquiry/chek_formno_exist_withapprove',
           data: 'newforno=' + newforno,
           success: function (resp) {
           
   
             if(resp=="duplicate"){
   
               //alert("You have already registered with us using this mobile no.");
               $("#errormsgform").html("<span style='color:red;''>Form no does not exist in Database</span>");
               $("#formno").val("");
               $('#formno').focus();
             //  $("#btn_submit").prop('disabled', true);
               //alert(html);
               //$("#usrdetails").html(html);
               return false;
             }else{
   
                         $.ajax({
                             type: 'POST',
                             url: '<?= base_url()?>Enquiry/chek_formno_exist',
                             data: 'newforno=' + newforno,
                             success: function (resp) {
                               var resp1 = resp.split("~");
                               var dup = resp1[0];
                             
                               var mob = JSON.parse(resp1[1]);
   
                               if(dup=="Duplicate"){
                                 //alert("You have already registered with us using this mobile no.");
                                 $("#errormsgform").html("<span style='color:red;''>You have already registered with us using this form no.</span>");
                                 $("#formno").val("");
                                 $('#formno').focus();
                                //$("#btn_submit").prop('disabled', true);
                                 //alert(html);
                                 //$("#usrdetails").html(html);
                                 return false;
                               }else{
                                 
                                 $("#errormsgform").html("");
                               //  $("#btn_submit").prop('disabled', false);
                                 return true
                               }
                               
                             }
                           })
                   }
             
           }
         });
       
       } else {
         
       }
     }
     function getdd_details(m)
     {
   	  
   	  var value=m.value;
   	 // alert(value);
   	  if(value=='OL'){
   	  $(".Transaction_lable").html("Recepit No");
         $(".Transaction_box").show();
   	  }else if(value=='POS'){
   	  $(".Transaction_lable").html("POS No");
         $(".Transaction_box").show();
       }else{
   		$(".Transaction_lable").html("");
         $(".Transaction_box").hide();
   	}
   	  
       /*if(value=='DD')
       {
         $("#picture").show();
          $("#DDNo").show();
   	   $("#BankName").show();
   	   $("#check").hide();
       }
       else if(value=='CHQ')
       {
         $("#check").show();
         $("#picture").hide();
   	   $("#BankName").show();
   	  $("#DDNo").hide();
       }
       else
       {
         $("#picture").hide();
   	  $("#BankName").hide();
         $("#check").hide();
   	$("#DDNo").hide();
       }*/
     }
    
   $(document).ready(function() {
   	  
   	  $('.TransToAdmin').change(function(){
           var value = $( 'input[name=TransToAdmin]:checked' ).val();
   		if(value=='N'){
           $('.NoTranstoAdmin').show();
   		}else{
   		$('.NoTranstoAdmin').hide();
   		}
   	  })
   	  
   	/*  $("#revisit_date").datetimepicker({format: 'yyyy-mm-dd',pickTime: false,minView: 2,autoclose: true});
   		 $("#revisit_date").on('change', function () {
           var date = Date.parse($(this).val());
           if (date < Date.now()) {
               alert('Selected date must be greater than today date');
               $(this).val('');
           }
       });*/
   	
   	$('#state_id').on('change', function () {
           var stateID = $(this).val();
           $('#city_id').html('<option value="">Select city </option>');
		   
		       if(stateID==27){
			  // $('.Scholarship_state').prop("checked", true);
			   var value="MH";
			   $("input[name=Scholarship_state][value=" + value + "]").prop('checked', true);
			   $('.MH').show();
               $('.OMH').hide();
			   }else{
				  var value="OMH";
			   $("input[name=Scholarship_state][value=" + value + "]").prop('checked', true);
			   $('.MH').hide();
               $('.OMH').show(); 
			   }
           if (stateID) {
               $.ajax({
                   type: 'POST',
                   url:'<?= base_url() ?>Enquiry/getStatewiseDistrict',              
                   data: 'state_id=' + stateID,
                   success: function (html) {
                       //alert(html);
                       $('#district_id').html(html);
                   }
               });
           } else {
               $('#district_id').html('<option value="">Select state first</option>');
           }
     });
     
     
     
     $('#district_id').on('change', function () {
           var stateID = $("#state_id").val();
           var district_id = $(this).val();
           if (district_id) {
               $.ajax({
                   type: 'POST',
                   url: '<?= base_url() ?>Enquiry/getStateDwiseCity',     
                   data: 'state_id=' + stateID+"&district_id="+district_id,
                   success: function (html) {
                       //alert(html);
                       $('#city_id').html(html);
                   }
               });
           } else {
               $('#city_id').html('<option value="">Select district first</option>');
           }
     });
     
     $("#btn_pdf").click(function(){
		 
		var enquiry_id= $("#enquiry_id").val();
		//alert(enquiry_id);
		window.location.href='<?php echo base_url();?>Enquiry/download_admission_form/'+enquiry_id;
		 })
     //////////////////
     });
     
     function get_school(val,schoola=0){
   	   if(val){
   		  // alert(schoola);
   		  $.ajax({
                   type: 'POST',
                   url: '<?= base_url() ?>Enquiry/fetch_school',
                   data: {'val' : val,'schoola':schoola},
                   success: function (resp) {
   					
   					$("#school_id").html(resp);
   					$("#stream_id").html('<option value="">Select Stream</option>');
   					$("#course_id").html('<option value="">Select Course Stream</option>');
   					
   					$("#jpfees").val('');
   					//$("#without_scholarship").val('');
   					
                      
                   }
               });  
   	   }
      }
      
      function load_courses(type,schoola=0){
   var highest_qualification=$("#last_qualification").val();
   if(highest_qualification){
   $.ajax({
   'url' : '<?= base_url() ?>Enquiry/load_courses',
   'type' : 'POST',
   'data' : {'school' : type,'highest_qualification':highest_qualification,'schoola':schoola},
   'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
   var container = $('#course_id'); //jquery selector (get element by id)
   if(data){
   	$("#stream_id").html('<option value="">Select Stream</option>');
   	$("#jpfees").val('');
  // 	$("#without_scholarship").val('');
   	
   container.html(data);
   }
   }
   });
     }
     else{
   	  alert("Please Select highest qualification");
     }
   }
   
      function load_streams(type,schoola=0){
                      // alert(type);
                  var acyear = $("#acyear").val();
				  var school_id = $("#school_id").val();
                   $.ajax({
                       'url' :  '<?= base_url() ?>Enquiry/get_course_streams_yearwise',
                       'type' : 'POST', //the way you want to send data to your URL
                       'data' : {'course' : type,'acyear':acyear,'school_id':school_id},
                       'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
                          // var container = $('#admission-stream'); //jquery selector (get element by id)"
                           if(data){                     
                               $('#stream_id').html(data);
                           }
                       }
                   });
               }
   			
   
    
   			
   		 function Scholarship_change(m){
   var value=m.value;
   //alert(value);
   $('.Merit_ship').show();
   if(value=='MH'){
   	$('.MH').show();
   	$('.OMH').hide();
   }
   if(value=='OMH'){
   	$('.MH').hide();
   	$('.OMH').show();
   }	
   	
   }	
   
   function Form_check(m){
   	var value=m.value;
   	if(value=="Y"){
   		$('#FTaken').show();
   	}else{
   		$('#FTaken').hide();
		//$("#btn_submit").prop('disabled', false);
   	}
   }
</script>
<?php  if($mobilnparamer){?>
<script>
   function onload_search(){
             var mobilnparamer= '<?php echo $mobilnparamer ?>';
           //  alert(mobilnparamer);
             var values={mobile_no:mobile,Enquiry_search:mobilnparamer}
                 $.ajax({
                     type:'POST',
                     url: '<?php echo base_url()?>Enquiry/Serach_details', 
                     data: values,
                     success: function (resp) {
   					//  alert(resp);
                       document.forms["form"].reset();
                       $('#returnMessage').html('');
                       $("#sname").prop('readOnly', false);
                       $("#email").prop('readOnly', false);
                       $("#mobile").prop('readOnly', false);
                       $('#course_type').html('<option value="">--Select--</option><option value="R" selected>Regular</option><option value="P">Part time</option>');
                       $("#course_type").prop('disabled', false);
                       $('#coursen').html('<option value=""> Select Course </option>');
                       $("#coursen").prop('disabled', false);
                       $("#email").prop('readOnly', false);
                       $("#amount").val();
                       $("#formno").val();
                       $("#formno").prop('disabled', false);
                       $('#paymentmode').html('<option value=""> Select Payment Type </option><option value="CASH">Cash</option><option value="OL">Online</option><option value="POS">POS</option>');
                       $("#paymentmode").prop('disabled', false);
                       if(resp=='no')
                       {
                         //alert('test');
   
                         $("#show_form").show();
                         $("#mobile").val(mobile);
                         var coursetype = $("#course_type").val();
                         var reg='Regular';
                         var coursetype='R';
                         $("#course_type").val(coursetype);
                         // var coursetype = coursetype;
                          if(coursetype!==''){
                           /*$.ajax({
                                   type:'POST',
                                   url:'<?= base_url()?>prospectus_fee_details/fetch_course_details',
                                   data:{coursetype:coursetype,select_course:select_course},
                                   success:function(html){
                                     $('#coursen').html(html);
                                   }
                               });*/
                           }
                          //alert(coursetype);
                      
                            else{ 
                                 $('#coursen').html('<option value="" required >Select course type first</option>'); 
                              }
                              if(coursetype=='R')
                              {
                                $("#amount").val('1000');
                                $("#dshow").show();var fno='20R01'; 
                                $("#formno").val(fno);
                              }
                              else{
                                 $("#dshow").show();
                                 var fno='19P02';
                                 $("#formno").val(fno);
                              
                                  $("#amount").val('1000'); 
                               }
                       }else{  alert(mobilnparamer);
                           $("#show_form").show();
                         var mob = JSON.parse(resp);
                         var form_no =mob[0]['adm_form_no'];
   					  $(".enquiry_no").show();
                         var enquiry_no =mob[0]['enquiry_no'];
   					  $(".enquiry_no").val(enquiry_no);
   					  
   					  if(mob[0]['enquiry_no']!="")
   					  {
   						  $("#form").attr('action', "<?php echo base_url(); ?>Enquiry/Updated");
   						//  $("#btn_submit").html('Update');
						  $("#btn_pdf").show();
   					  }
   					  $("#enquiry_id").val(mob[0]['enquiry_id'])
   					  $("#first_name").val(mob[0]['first_name']);
   					  $("#middle_name").val(mob[0]['middle_name']);
   					  $("#last_name").val(mob[0]['last_name']);
   					  $("#email_id").val(mob[0]['email_id']);
   					  $("#mobile").val(mob[0]['mobile']);
   					  $("#altarnet_mobile").val(mob[0]['altarnet_mobile']);
   					  
   					  $("#state_id").val(mob[0]['state_id']);
   					 // state_call(mob[0]['state_id'],mob[0]['district_id']);
					 
					 if(mob[0]['state_id']==27){
			  // $('.Scholarship_state').prop("checked", true);
			   var value="MH";
			   $("input[name=Scholarship_state][value=" + value + "]").prop('checked', true);
			   $('.MH').show();
               $('.OMH').hide();
			   }else{
				  var value="OMH";
			   $("input[name=Scholarship_state][value=" + value + "]").prop('checked', true);
			   $('.MH').hide();
               $('.OMH').show(); 
			   }
					 
					 
					 
   					  setTimeout(function() { state_call(mob[0]['state_id'],mob[0]['district_id']); }, 500);
   					  $("#district_id").val(mob[0]['district_id']);
   					  $("#city_id").val(mob[0]['city_id']);
   					 // distic_call(mob[0]['state_id'],mob[0]['district_id'],mob[0]['city_id']);
   					  setTimeout(function() { distic_call(mob[0]['state_id'],mob[0]['district_id'],mob[0]['city_id']); }, 1000);
   					  
   					  $("#pincode").val(mob[0]['pincode']);
   					  $("#admission_type").val(mob[0]['admission_type']);
   					  
   					 // $("#gender").val(mob[0]['gender']);
   					  $("input[name=gender][value=" + mob[0]['gender'] + "]").prop('checked', true);
   
   					  $("#aadhar_card").val(mob[0]['aadhar_card']);
   					 // $("#category").val(mob[0]['category']);
   					   $("input[name=category][value=" + mob[0]['category'] + "]").prop('checked', true);
   					   ///////////////////////////////////////////////////////////////////////////////////////////////////////
   					   $("#last_qualification").val(mob[0]['last_qualification']);
   					   get_school(mob[0]['last_qualification'],mob[0]['school_id']);
   					   $("#qualification_percentage").val(mob[0]['qualification_percentage']);
   					   $("#school_id").val(mob[0]['school_id']);
   					  
   					   $("#course_id").val(mob[0]['course_id']);
   					   // load_courses(mob[0]['school_id'],mob[0]['course_id']);
   						setTimeout(function() { load_courses(mob[0]['school_id'],mob[0]['course_id']); }, 500);
   					   $("#stream_id").val(mob[0]['stream_id']);
   					   setTimeout(function() { load_streams(mob[0]['course_id'],mob[0]['stream_id']); }, 1000);
   					   
   					   
   					   $("#actual_fee").val(mob[0]['actual_fee']);
   					   $("#tution_fees").val(mob[0]['tution_fees']);
					   $("#without_scholarship").val(mob[0]['without_scholarship']);
					   setTimeout(function() { get_fees_value(); }, 1000);
   					   // get_fees_value();
   					   //$("#form_taken").val(mob[0]['form_taken']);
   					   $("input[name=form_taken][value=" + mob[0]['form_taken'] + "]").prop('checked', true);
   					  
					   if(mob[0]['form_taken']=="Y"){
   						   $("#FTaken").show();
   					   }else{
   						   $("#FTaken").hide();
   					   }
					   
					   
					   
					    $("input[name=hostel_allowed][value=" + mob[0]['hostel_allowed'] + "]").prop('checked', true);
					   
					   
		
					   
   					   $("#form_amount").val(mob[0]['form_amount']);
   					   $("#form_mobile").val(mob[0]['form_mobile']);
   					   $("#form_no").val(mob[0]['form_no']);
   					   $("#payment_mode").val(mob[0]['payment_mode']);
					   if(mob[0]['payment_mode']!='CHLN'){
					   $('.Transaction_box').show();
   					   $("#TransactionNo").val(mob[0]['recepit_no']);
					   $(".Transaction_lable").html('Recepit');
					   }else{
						    $(".Transaction_lable").html('');
						   $('.Transaction_box').hide();
					   }
					   
                       // alert(mob[0]['scholarship_allowed']);
                       $("input[name=scholarship_allowed][value=" + mob[0]['scholarship_allowed'] + "]").prop('checked', true);
						   
						if(mob[0]['scholarship_allowed']=="Y"){
   						   $(".Scholarship_allow").show();
						   $("#scholarship_status").val(mob[0]['scholarship_status']);
   					   }else{
   						   $(".Scholarship_allow").hide();
   					   }
					   
					   if(mob[0]['final_Pay']==0){$(".final_Pay").hide();}else{$(".final_Pay").show();}
					$("#final_Pay").val(mob[0]['final_Pay']);
					   if(mob[0]['scholarship_allowed']=="MH"){
						$('.MH').show();
                    	$('.OMH').hide();
						$("input[name=Merit_Scholarship_selected][value=" + mob[0]['merit_scholarship'] + "]").prop('checked', true);
					}else{
						$('.MH').hide();
                     	$('.OMH').show();
					$("input[name=Merit_Scholarship_selected][value=" + mob[0]['merit_scholarship'] + "]").prop('checked', true);
					}
					   
					//	$("#scholarship_status").val(mob[0]['scholarship_status']);  
						   
                       }
                       
   
                     
                     }                      
                   });
   }
   //onload_search();
   
   
   
</script>
<?php } ?>