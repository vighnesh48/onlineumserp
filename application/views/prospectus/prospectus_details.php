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
                sname:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'student name should not be empty'
                      }/* ,
                      regexp: 
                      {
                        regexp: /^[a-z\s]+$/i,
                        message: 'First name can consist of alphabetical characters and spaces only'
                      } */
                    }

                },
                 formno:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Form no should not be empty'
                      },/* ,
                      regexp: 
                      {
                        regexp: /^[a-z\s]+$/i,
                        message: 'First name can consist of alphabetical characters and spaces only'
                      } */
                      stringLength: 
                       {
                       max: 12,
                       min:6,
                       message: 'Enter the correct  prospectus form no.'
                       }
                    }

                },
                 course_type:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'select course type'
                      }/* ,
                      regexp: 
                      {
                        regexp: /^[a-z\s]+$/i,
                        message: 'First name can consist of alphabetical characters and spaces only'
                      } */
                    }

                },
                coursen:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'select course'
                      },
                      /*regexp: 
                      {
                        regexp: '^[+-]?([0-9]*[.])?[0-9]+$',
                        message: 'Paid search should be Decimal'
                      }*/
                      /*stringLength: 
                        {
                        max:6,
                        min: 6,
                        message: 'pincode should be 6 characters.'
                        }*/
                    }
                },
                paymentmode:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Select Payment type'
                      }/* ,
                      regexp: 
                      {
                        regexp: /^[a-z\s]+$/i,
                        message: 'First name can consist of alphabetical characters and spaces only'
                      } */
                    }

                },
                 picture:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'upload dd scan file'
                      }/* ,
                      regexp: 
                      {
                        regexp: /^[a-z\s]+$/i,
                        message: 'First name can consist of alphabetical characters and spaces only'
                      } */
                    }

                },
                check:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Required Check Number'
                      }/* ,
                      regexp: 
                      {
                        regexp: /^[a-z\s]+$/i,
                        message: 'First name can consist of alphabetical characters and spaces only'
                      } */
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
        });
   
        $('#coursen').on('blur', function(e) {
           $('#form').bootstrapValidator('revalidateField', 'coursen');
         });
		
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
        <li class="active"><a href="#">Add Prospectus Fee Details</a></li>
    </ul>
    <div class="page-header">           
            <div class="row">
                <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Add Prospectus Fee Details</h1>
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
                <div class="col-sm-2 from-group"><h4>Search By Mobile:</h4></div>
                          
                <div class="col-sm-3"><input type="text" name="mobile_search" id="mobile_search" class="form-control numbersOnly" maxlength="10"  title="Enter your mobile number" value="<?php  if($mobile_from){echo $mobile_from;}?>" required></div>
                <div class="col-sm-1"><input type="button" value="Search" class="btn btn-primary" id="btnsearch"></div>
              </div>
              <div id="returnMessage"></div>
                <div> <?php if(isset($validation_errors)) { ?>
                                               <span style='color:red;'><?php echo $validation_errors;  ?></span> <?php }?></div>
            
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
                                <div class="panel-heading">
                                        <span class="panel-title">Prospectus Fee</span>
                                </div>
                               

                                <div class="panel-body">
                                     <form id="form"   name="form"  action="<?=base_url($currentModule.'/submit')?>" method="POST"  enctype="multipart/form-data">

                                    <div class="panel-padding no-padding-vr">

                                     
                                          <div class="form-group">
                                              <label class="col-sm-2">Student name <?=$astrik?></label>
           <div class="col-sm-4"><input type="text" id="sname" name="sname" class="form-control" placeholder="" /></div> 
                                                     <label class="col-sm-2"> Course type <?=$astrik?></label>
                                    <div class="col-sm-4">
                                        <select name="course_type" class="form-control" id="course_type" required="true" >
                                          
                                           <option value="">--Select--</option>
                                           <option value="R" selected>Regular</option>
                                            <option value="P">Part time</option>
                                        </select>
                                    </div>                                    
                                                
                                          </div>
                                           <div class="form-group">
                                            <label class="col-sm-2">Course<?=$astrik?></label>                                     
                                             <div class="col-sm-4">
                                        <select name="coursen" class="form-control" id="coursen" required="true" >
                                          <option value="">Select course type first </option>
                                            
                                        </select>
                                    </div>
                                              <label class="col-sm-2">Email <?=$astrik?> </label>                                    
                                               <div class="col-sm-4"><input type="email"   id="email" name="email" class="form-control"  placeholder="" /></div>                                    
                                                
                                          </div> 
                                          <div class="form-group">
                                            <label class="col-sm-2">Amount <?=$astrik?></label>                                     
                                              <div class="col-sm-4"><input type="text" id="amount"  name="amount"  readonly class="form-control"  value="1000" placeholder="" /></div>
                                               <label class="col-sm-2">Mobile<?=$astrik?></label>
                                               <div class="col-sm-4"><input type="text" id="mobile"  name="mobile" class="form-control" /><?php  if(isset($validation_errors)) { ?>
                                               <span style='color:red;'>You have already registered with us using this mobile no.</span> <?php } else
                                               {?> <span id="errormsg"></span> <?php } ?><input type="hidden" id="hidden_mobile"  name="hidden_mobile" class="form-control" />
                                  <input type="hidden" id="hidden_id"  name="hidden_id" class="form-control" />
    <input type="hidden" id="counsellorid"  name="counsellorid" value="<?php if(isset($counsellorid)){ echo $counsellorid;}?>" class="form-control" /></div>                                       
                                           </div>
                                               <div class="form-group">
                                                                             
                                        <label class="col-sm-2">Form no: <?=$astrik?> </label>         
                                                                  
                                               <div class="col-sm-4"> <div  id="dshow" style="display:none;">
                                         
                                        </div> <input type="text"  id="formno" name="formno" class="form-control"  placeholder=" Form No" onblur="return chek_duplicate_formno_exist(this.value)" /><!--onblur="return chek_duplicate_formno_exist(this.value)"--><?php  if(isset($validation_errors1)) { ?>
                                               <span style='color:red;'>You have already registered with us using this form no.</span> <?php } else
                                               {?> <span id="errormsgform"></span> <?php } ?></div> 
                                          
                                    </div> 
                                       <div class="form-group">


                                        <label class="col-sm-2">Payment Mode: <?=$astrik?> </label> 
                                          <div class="col-sm-4">
                                        <select name="paymentmode" class="form-control" id="paymentmode" required="true" onchange="getdd_details(value)" >
                                          <option value="">Select Payment type</option>
                                           <option value="Cash">Cash</option>
                                           <option value="OL">Online</option>
                                            <option value="CHQ">Check</option>
                                            <option value="DD">DD</option>
                                        </select>
                                    </div> 
                                  </div>
                                     <div class="form-group">
                                     <div class="col-sm-3">
                                     </div>
                                   <div class="form-group">
       <input class="form-control" type="hidden" name="picture" id="picture" style="display: none;" />
       <!--  <input type="file" name="ddno" id="ddno"  class="form-control" style="display: none;" /> -->
      <div class="col-sm-3">               
      <input type="text" name="check" class="form-control"  placeholder=" Enter Check Number" id="check" style="display: none;" />      <input type="text" name="DDno" class="form-control"  placeholder=" Enter DD Number" id="DDNo" style="display: none;" />
      </div>
      <div class="col-sm-3">
      <input type="text" name="BankName" class="form-control"  placeholder=" Enter Bank Name" id="BankName" style="display: none;" /></div>
                                </div>   
                                  </div>
                                           
                                             <br>
											 <!-- Transfer to Admission center -->	 
                                           <?php  if($mobile_from!=""){?>
								 <div class="form-group">	<div class="col-sm-4">
										<label>Forward to Admission Center&nbsp;</label> 
					<input type="radio" name="TransToAdmin"  class="TransToAdmin" value="Y" checked="checked"> Yes
					<input type="radio" name="TransToAdmin"  class="TransToAdmin" value="N" /> No
									</div></div>
									<div class="NoTranstoAdmin" style="display:none;">
										<label class="col-sm-3">Admission Date</label> 
                         <div class="col-md-2"><input type="text" name="revisit_date" id="revisit_date" class="form-control" value="" placeholder="Date of Admission" /></div>
										 <textarea name="NoTranstoAdmin" id="NoTranstoAdmin" placeholder="Reason" required='required'></textarea>
									</div>
                                    <?php } ?>
									<!-- END of Transfer to Admission center -->
									<br>
                                           <div class="form-group">
                                               <div class="col-sm-4"></div>
                                               <div class="col-sm-2">
                                                   <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Submit</button>                                        
                                               </div>                                    
                                               <div class="col-sm-2"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule)?>'">Cancel</button></div>
                                               <div class="col-sm-4"></div>
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
<script>

 


    $(function(){
   var mobile='<?php echo $mobilnparamer; ?>';
   if(mobile!='')
   {
     // alert('1');
       $.ajax({
              type:'POST',
              url: '<?= base_url() ?>prospectus_fee_details/serach_details',
              data: 'mobile_no='+mobile,
              success: function (resp) {
                if(resp=='no')
                {
                  $("#show_form").show();
                  $("#mobile").val(mobile);
                }
                else
                {
                  var mob = JSON.parse(resp);
                  //alert(mob[0]['course_walkin']);
                  $("#show_form").show();
                  $("#sname").val(mob[0]['student_name']);
                  $("#email").val(mob[0]['email']);
                  $("#mobile").val(mob[0]['mobile1']);

                   var reg='Regular';
                  var coursetype='R';
                  $("#course_type").val(coursetype);
                  // var coursetype = coursetype;
                  var select_course=mob[0]['course_walkin'];
                  //alert(select_course);
                  if(coursetype!==''){
                  $.ajax({
                        type:'POST',
                        url:'<?= base_url()?>prospectus_fee_details/fetch_course_details',
                        data:{coursetype:coursetype,select_course:select_course},
                        success:function(html){
                            $('#coursen').html(html);
                               if(coursetype=='R')
                           {
                             $("#amount").val('1000');
                             $("#dshow").show();
                             var fno='19R01';
                             $("#formno").val(fno);
                           }
                           else{
                              $("#dshow").show();
                              var fno='19P02';
                              $("#formno").val(fno);
                           
                               $("#amount").val('1000'); 
                           }
                            //$("#coursen option[value='"+select_course+"']").attr("selected", "selected");

                             
                        }
                    });
                  }     
                }
              }                      
            });

   }
   else
   {
    return false;

   }
});
  $('.numbersOnly').keyup(function () {
      if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
        this.value = this.value.replace(/[^0-9\.]/g, '');
      }
    }); 

  $("#btnsearch").click(function(){

      
          var mobile= $("#mobile_search").val();
          //alert(mobile);
          var filter = /^[0-9-+]+$/;
          if(mobile.length <= 11){
            if (filter.test(mobile)) {  //alert('2');
              $.ajax({
                  type:'POST',
                  url: '<?= base_url() ?>prospectus_fee_details/serach_details',
                  data: 'mobile_no='+mobile,
                  success: function (resp) {
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
                    $('#paymentmode').html('<option value=""> Select Payment Type </option><option value="Cash">Cash</option><option value="OL">Online</option><option value="CHQ">Check</option><option value="DD">DD</option>');
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
                        $.ajax({
                                type:'POST',
                                url:'<?= base_url()?>prospectus_fee_details/fetch_course_details',
                                data:{coursetype:coursetype,select_course:select_course},
                                success:function(html){
                                  $('#coursen').html(html);
                                }
                            });
                        }
                       //alert(coursetype);
                   
                         else{ 
                              $('#coursen').html('<option value="" required >Select course type first</option>'); 
                           }
                           if(coursetype=='R')
                           {
                             $("#amount").val('1000');
                             $("#dshow").show();
                             var fno='19R01';
                             $("#formno").val(fno);
                           }
                           else{
                              $("#dshow").show();
                              var fno='19P02';
                              $("#formno").val(fno);
                           
                               $("#amount").val('1000'); 
                            }
                    }
                    else
                    {

                      var mob = JSON.parse(resp);
                     var form_no =mob[0]['adm_form_no'];

                      if(mob[0]['admission_form_taken']=='Y' || mob[0]['provisional_admission']=='Y')
                      {

                          $('#returnMessage').html('<span class="messageError" style="color:red;"> You have already taken form with form no:' + form_no + '</span>');
                          $("#show_form").show();
                          $("#sname").val(mob[0]['student_name']);
                          $("#sname").prop('readOnly', true);
                          $("#email").val(mob[0]['email']);
                          $("#email").prop('readOnly', false);
                          $("#mobile").val(mob[0]['mobile1']);
                          $("#mobile").prop('readOnly', true);
                          var reg='Regular';
                          var part='Part Time';
                          if(mob[0]['admission_mode']=='R')
                          {
                           $("#course_type").append("<option selected >"+reg+"</option>");
                            var coursetype="R";
                          }
                          else
                          {
                           $("#course_type").append("<option selected >"+part+"</option>");
						                var coursetype="P";
                          }
						  
						   
                          $("#course_type").prop('disabled', true);
                           var coursetype = $("#course_type").val();
                        var reg='Regular';
              var coursetype='R';
               $("#course_type").val(coursetype);
              // var coursetype = coursetype;
               var select_course=mob[0]['course_walkin'];
               //alert(select_course);
             if(coursetype!==''){
             $.ajax({
                      type:'POST',
                      url:'<?= base_url()?>prospectus_fee_details/fetch_course_details',
                      data:{coursetype:coursetype,select_course:select_course},
                      success:function(html){
                          $('#coursen').html(html);
                      }
                  });
        }
                          // $("#coursen").append("<option selected >"+mob[0]['course_walkin']+"</option>");
                          $("#coursen").prop('disabled', true);
                          $("#amount").val(mob[0]['amount']);
                          $("#formno").val(form_no);
                           $("#formno").prop('disabled', true);
                           if(mob[0]['fees_paid_type']=='OL')
                          {
                           $("#paymentmode").append("<option selected >OnLine</option>");
                            
                          }
                          else
                          {
                           $("#paymentmode").append("<option selected >"+mob[0]['fees_paid_type']+"</option>");
                          }
                           $("#paymentmode").val(mob[0]['fees_paid_type']);
                           $("#paymentmode").prop('disabled', true);
                           $("#btn_submit").prop('disabled', true);  
                      }
                      else
                      {
                          var mob = JSON.parse(resp);
                          $("#sname").val(mob[0]['student_name']);
            						  var reg='Regular';
            						  var coursetype='R';
            						   $("#course_type").val(coursetype);
            						  // var coursetype = coursetype;
          						    var select_course=mob[0]['course_walkin'];
                             if(coursetype!==''){
                             $.ajax({
                                      type:'POST',
                                      url:'<?= base_url()?>prospectus_fee_details/fetch_course_details',
                                      data:{coursetype:coursetype,select_course:select_course},
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
                            $("#dshow").show();
                            var fno='19R01';
                            $("#formno").val(fno);
                          }
                          else{
                             $("#dshow").show();
                             var fno='19P02';
                             $("#formno").val(fno);
                          
                              $("#amount").val('1000'); 
                          }
						  
                          $("#show_form").show();
                          $("#sname").val(mob[0]['student_name']);
                          $("#sname").prop('readOnly', true);
                         // $("#sname").attr("disabled", "disabled"); 
                          $("#email").val(mob[0]['email']);
                          $("#email").prop('readOnly', false);
                          $("#mobile").val(mob[0]['mobile1']);
                          $("#mobile").prop('readOnly', true);
                          $("#hidden_mobile").val(mob[0]['mobile1']);
                          $("#hidden_id").val(mob[0]['id']);

                      }
                    
                        
                    }
                    

                  
                  }                      
                });
              return true;
            }
            else {
              alert('Please enter correct mobile no');
              $("#mobile_search").focus();
              return false;
            }
          }

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
                      url:'<?= base_url()?>prospectus_fee_details/fetch_course_details',
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
          $("#dshow").show();
          var fno='19R01';
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
      
    }
  }
      //check duplicate form no
    function chek_duplicate_formno_exist(formno) {
    if (formno) {
      var course=$("#course_type").val();

      if(course=='R')
      {
        var newforno=formno;
      }
      else
      {//for parttime even semster
        var newforno=formno;
      }
        $.ajax({
        type: 'POST',
        url: '<?= base_url()?>prospectus_fee_details/chek_formno_exist_withapprove',
        data: 'newforno=' + newforno,
        success: function (resp) {
        

          if(resp=="duplicate"){

            //alert("You have already registered with us using this mobile no.");
            $("#errormsgform").html("<span style='color:red;''>Form no does not exist in Database</span>");
            $("#formno").val("");
            $('#formno').focus();
           $("#btn_submit").prop('disabled', true);
            //alert(html);
            //$("#usrdetails").html(html);
            return false;
          }else{

                      $.ajax({
                          type: 'POST',
                          url: '<?= base_url()?>prospectus_fee_details/chek_formno_exist',
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
                             $("#btn_submit").prop('disabled', true);
                              //alert(html);
                              //$("#usrdetails").html(html);
                              return false;
                            }else{
                              
                              $("#errormsgform").html("");
                              $("#btn_submit").prop('disabled', false);
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
  function getdd_details(value)
  {
    if(value=='DD')
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
    }
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
	  
	  $("#revisit_date").datetimepicker({format: 'yyyy-mm-dd',pickTime: false,minView: 2,autoclose: true});
		 $("#revisit_date").on('change', function () {
        var date = Date.parse($(this).val());
        if (date < Date.now()) {
            alert('Selected date must be greater than today date');
            $(this).val('');
        }
    });
  });
</script>
<?php  if($mobile_from!=""){?>
<script>
function onload_search(){
          var mobile= '<?php echo $mobile_from ?>';
          //alert(mobile);
          var filter = /^[0-9-+]+$/;
          if(mobile.length <= 11){
            if (filter.test(mobile)) { //alert('3');
              $.ajax({
                  type:'POST',
                  url: '<?= base_url() ?>prospectus_fee_details/serach_details',
                  data: 'mobile_no='+mobile,
                  success: function (resp) {
                  document.forms["form"].reset();
                   $('#returnMessage').html('');
                    $("#sname").prop('readOnly', false);
                    $("#email").prop('readOnly', false);
                    $("#mobile").prop('readOnly', false);
                  $('#course_type').html('<option value="">--Select--</option><option value="R">Regular</option><option value="P">Part time</option>');
                    $("#course_type").prop('disabled', false);
                    $('#coursen').html('<option value=""> Select Course </option>');
                    $("#coursen").prop('disabled', false);
                    $("#email").prop('disabled', false);
                    $("#amount").val();
                    $("#formno").val();
                    $("#formno").prop('disabled', false);
                    $('#paymentmode').html('<option value=""> Select Payment Type </option><option value="Cash">Cash</option><option value="OL">Online</option><option value="CHQ">Check</option><option value="DD">DD</option>');
                    $("#paymentmode").prop('disabled', false);
                    if(resp=='no')
                    {
                      $("#show_form").show();
                      $("#mobile").val(mobile);


                    }
                    else
                    {
                      var mob = JSON.parse(resp);
                     var form_no =mob[0]['adm_form_no'];

                      if(mob[0]['admission_form_taken']=='Y' || mob[0]['provisional_admission']=='Y')
                      {

                          $('#returnMessage').html('<span class="messageError" style="color:red;"> You have already taken form with form no:' + form_no + '</span>');
                          $("#show_form").show();
                          $("#sname").val(mob[0]['student_name']);
                          $("#sname").prop('readOnly', true);
                          $("#email").val(mob[0]['email']);
                          $("#email").prop('readOnly', false);
                          $("#mobile").val(mob[0]['mobile1']);
                          $("#mobile").prop('readOnly', true);
                          var reg='Regular';
                          var part='Part Time';
                         /* if(mob[0]['admission_mode']=='R')
                          {
                           $("#course_type").append("<option selected >"+reg+"</option>");
                           var coursetype="R";
                          }
                          else
                          {
                           $("#course_type").append("<option selected >"+part+"</option>");
						   var coursetype="P";
                          }*/
						  
						 if(mob[0]['admission_mode']=='R')
                          {
                           $("#course_type").append("<option selected >"+reg+"</option>");
                            var coursetype="R";
                          }
                          else
                          {
                           $("#course_type").append("<option selected >"+part+"</option>");
						    var coursetype="P";
                          }
						  
						   
						  
						  
						  
						  
                          
                          $("#course_type").prop('disabled', true);
                           $("#coursen").append("<option selected >"+mob[0]['sprogramm_name']+"</option>");
                          $("#coursen").prop('disabled', true);
                          $("#amount").val(mob[0]['amount']);
                          $("#formno").val(form_no);
                           $("#formno").prop('disabled', true);
                           if(mob[0]['fees_paid_type']=='OL')
                          {
                           $("#paymentmode").append("<option selected >OnLine</option>");
                            
                          }
                          else
                          {
                           $("#paymentmode").append("<option selected >"+mob[0]['fees_paid_type']+"</option>");
                          }
                           $("#paymentmode").val(mob[0]['fees_paid_type']);
                           $("#paymentmode").prop('disabled', true);
                           $("#btn_submit").prop('disabled', true);
                           
                         

                      }
                      else
                      {
						  
						  var coursetype='R';
						   var reg='Regular';
						   $("#course_type").val(coursetype);
						  // var coursetype = coursetype;
						   var select_course=mob[0]['course_walkin'];
             if(coursetype!==''){
             $.ajax({
                      type:'POST',
                      url:'<?= base_url()?>prospectus_fee_details/fetch_course_details',
                      data:{coursetype:coursetype,select_course:select_course},
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
          $("#dshow").show();
          var fno='19R01';
          $("#formno").val(fno);
        }
        else{
           $("#dshow").show();
           var fno='19P02';
           $("#formno").val(fno);
        
            $("#amount").val('1000'); 
        }
						  
						  
						  
						  
						  
                          $("#show_form").show();
                          $("#sname").val(mob[0]['student_name']);
                          $("#sname").prop('readOnly', true);
                         // $("#sname").attr("disabled", "disabled"); 
                          $("#email").val(mob[0]['email']);
                          $("#email").prop('readOnly', false);
                          $("#mobile").val(mob[0]['mobile1']);
                          $("#mobile").prop('readOnly', true);
                          $("#hidden_mobile").val(mob[0]['mobile1']);
                          $("#hidden_id").val(mob[0]['id']);
						  

                      }
                    
                        
                    }
                    

                  
                  }                      
                });
             // return true;
            }
            else {
              alert('Please enter correct mobile no');
              $("#mobile_search").focus();
           //   return false;
            }
          }
}
onload_search();
</script>
<?php } ?>