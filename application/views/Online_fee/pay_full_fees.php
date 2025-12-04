<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<script src="<?=base_url('assets/javascripts')?>/jquery.table2excel.js"></script>
<script src="<?=base_url('assets/javascripts')?>/bootstrap-datepicker.js "></script>
<script>
   var base_url = '<?php echo site_url();?>';
   $(document).ready(function(){
       $('.numbersOnly').keyup(function () {
   if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
   this.value = this.value.replace(/[^0-9\.]/g, '');
   } 
   });
   
   
   $("#udf2").change(function(){
	   var container = $('#feepend'); 
	   $("#productinfo").val('');
	    container.html('');
	   $("#amount").val(0);
	   
   });
   
   
   $("#productinfo").change(function(){
  
   var ftype = $("#productinfo").val();
   var year = $("#udf2").val();
   var stud_id = $("#stud_id").val();
   $.ajax({
   'url' : base_url + 'Online_fee/fetch_feedet_full',
   'type' : 'POST', //the way you want to send data to your URL
   'data' : {'ftype' : ftype,'year' : year,'stud_id':stud_id},
   'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
   var container = $('#feepend'); //jquery selector (get element by id)
   if(data){
   //   alert(data);
   //alert("Marks should be less than maximum marks");
   //$("#"+type).val('');
   container.html(data);
   }
   
    $(".nextBtn ").prop('disabled', false);
   if(ftype=='Examination'){
	   $("#amount").val(data);
	     $('#amount').attr('readonly', false); 
   }else if(ftype=='Revaluation'){
	   $("#amount").val(data);
	   $('#amount').attr('readonly', false); 
   }else if(ftype=='Admission'){
	   var amt= data.split('~~');
	   var tbl_tot_fees='<table border="1" ><tr style="background:#3175af"><th><label class="">Total fees </label></th><th><label class="">Paid fees </label></th><th><label class="">Pending fees </label></th></tr><tr style="color:#000000"><td><b><label class="">'+Math.round(amt[0])+'</label></td><td><label class="">'+Math.round(amt[1])+'</label></td><td><label class="">'+Math.round(amt[2])+'</label></b></td></tr></table>';
	   
	   container.html(tbl_tot_fees);
	   
	   if(amt[2]<0){
	   $("#amount").val(0);
	   }else{
		  $("#amount").val(Math.round(amt[2])); 
	   }
	   
	   $('#amount').attr('readonly', true); 
	   
	 // $("#amount").val(data);
	   //$('#amount').attr('readonly', false); 
   }else if(ftype=='Photocopy'){
	   $("#amount").val(data);
	   $('#amount').attr('readonly', false); 
   }else if(ftype=='Re-Registration-full'){
	   var amt= data.split('~~');
	  /* var tbl_tot_fees='<table border="1" ><tr style="background:#3175af"><th><label class="">Total fees </label></th></tr><tr style="color:#000000"><td><b><label class="">'+Math.round(amt[0])+'</label></td></tr></table>';*/
	   
	   /*if(!isNaN(amt[0])){
	   if (amt[1] < 0) {
	container.html('');	   
$("#amount").val('');
 var msg='<table border="1" ><tr style="background:#3175af"><th>Fee already with us..Not need to pay Online</label></td></tr></table>';
container.html(msg);	
$(".nextBtn ").prop('disabled', true);  
} else {
  $("#amount").val(Math.round(amt[1]));
  $(".nextBtn ").prop('disabled', false);
  container.html(tbl_tot_fees);
}
	   }else*/{
		   
		/* var text=  '<table border="1" ><tr style=""><th><label class=""><b style="color:#000000">&nbsp;First pay Admission 2019-20 Pending Fee.<br> Then You are eligible For Re-Registration.<br>Pending Amount Rs.'+Math.round(amt[2])+'</b>&nbsp;<br>If You Want Full Payment <a href="">Click here</a></label></td></tr></table>';
		   container.html(text);*/
		   $("#amount").val(amt[1]);
		   $('#amount').attr('readonly', true); 
	   }
	   
	  // $("#amount").val(Math.round(amt[1]));
	   
	// $('#amount').attr('readonly', true); 
   } 
   
   }
   });
   });                  

   });
   
   
</script>

 <style>
.loader {
    position: fixed;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    z-index: 9999;
    background: url('<?php echo base_url();?>assets/images/loading.gif') 50% 50% no-repeat rgb(249,249,249);
    opacity: .8;
	
}
</style>
<div id="content-wrapper">
<ul class="breadcrumb breadcrumb-page">
   <div class="breadcrumb-label text-light-gray">You are here: </div>
   <li class="active"><a href="#">Fee Payment</a></li>
   <li class="active"><a href="#">Online Fee</a></li>
</ul>

<div class="page-header">
   <div class="row">
      <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Make Payment</h1>
      <div class="col-xs-12 col-sm-8">
         <div class="row">
            <hr class="visible-xs no-grid-gutter-h">
            <?php $MERCHANT_KEY = "soe5Fh"; //if(in_array("Add", $my_privileges)) { ?>
            <div class="visible-xs clearfix form-group-margin"></div>
            <?php// } ?>
            <?php //if(in_array("Search", $my_privileges)) { ?>
            <!--<form class="pull-right col-xs-12 col-sm-6" action="">
               <div class="input-group no-margin">
                   <span style="border:none;background: #fff;background: rgba(0,0,0,.05);" class="input-group-addon"><i class="fa fa-search"></i></span>
                   <select id="search_me" name="search_me" style="border:none;background: #fff;background: rgba(0,0,0,.05);" class="form-control no-padding-hr" placeholder="Search...">
                       <option value="">Select Title</option>
                       <?php
                //  for($i=0;$i<count($emp_list);$i++)
                  {
                  ?>
                       <option value="<?//$emp_list[$i]['emp_id']?>"><?//$emp_list[$i]['fname'].' '.$emp_list[$i]['lname']?></option>
                       <?php
                  }
                  ?>
                   </select>
               </div>
               </form>-->
            <?php //} ?>
         </div>
      </div>
   </div>
   <div class="row ">
      <div class="col-sm-12">&nbsp;</div>
   </div>
   <div class="row ">
      <div class="col-sm-12">
         <div class="panel">
            <div class="panel-heading">
               <span class="panel-title"><h4> Online Payment</h4></span>
               <div class="holder"></div>
            </div>
            <?php
            $vmob =$stdata['mobile'];
            $vem = $stdata['email'];
            ?>
            <form  name="payuForm"  id="payuForm" method="post" action="https://secure.payu.in/_payment" onsubmit="return submitPayuForm();">
               <div class="table-info panel-body">
                 <div class="form-group">
                     <input type="hidden" name="key" value="<?php echo $MERCHANT_KEY ?>" />
                     <input type="hidden" name="hash" id="hash" value=""/>
                     <input type="hidden" name="txnid" id="txnid" value="" />
                    <!-- <input type="hidden" name="action" value="https://secure.payu.in/_payment" />-->
                     <?php // $vat = date('ymd')."".rand(1000,9999); ?>
                     <input name="firstname" id="firstname" type="hidden"  placeholder="Enter your Name*"  value="<?php echo (empty($_POST['firstname'])) ?  $stdata['first_name'].' '.$stdata['last_name'] : $_POST['firstname']; ?>"  required />
                     <input name="email" id="email" type="hidden"  placeholder="Email*"  value="<?php echo $stdata['email']; ?>"  required />
                     <input type="hidden" name="udf1" id="udf1" value="">
                     <input type="hidden" name="udf3" id="udf3" value="<?php echo $stdata['enrollment_no']; ?>">     
                     <input type="hidden" name="udf4" id="udf4" value="">
                     <input type="hidden" name="udf5" id="udf5" value=""> 
                     
                     <input type="hidden" name="stud_id" id="stud_id" value="<?php echo $stdata['stud_id']; ?>" required> 
                     <input type="hidden" name="mobile" id="mobile" value="<?php echo $stdata['mobile']; ?>" required>
                     
                     <input type="hidden" name="surl" value="https://www.sandipuniversity.com/erp/Online_fee/success"/>
                     <input type="hidden" name="furl" value="https://www.sandipuniversity.com/erp/Online_fee/failure"/>
                     
                     
                </div>
                     <div class="row">
                          <div class="col-sm-6">
                            <div class="row">
                                <div class="form-group">
                                     <label class="col-sm-6">Academic Year </label>
                                     <div class="col-sm-6" id="">

                                        <select name="udf2" id="udf2" class="form-control" required>
                                           <option value="">Select Year</option>
                                       
                                         <option value="2020" selected="selected">2020-21</option>
										 
                                     
                                        </select>
                                     </div>
                                </div>
                                </div>
                            <div class="row">
                                <div class="form-group">
                                 <label class="col-sm-6">Fees Type </label>
                                 <div class="col-sm-6" id="">
                                    <select name="productinfo" id="productinfo" class="form-control" required>
                                       <option value="">Select Fee Type</option>
                                       <option value="Re-Registration-full" <?php if($_POST['productinfo']=='Re-register'){echo "selected";} ?>>Re-Registration</option>
                                    </select>
                                 </div>
                              </div>
                               </div>
                             <div class="row">
                              <div class="form-group">
                                 <div class="col-sm-6" id="">
                                 </div>
                                 <div class="col-sm-6"  id="feepend" style="color:white;  text-align: center;">
                                    
                                 </div>
                              </div>
                               </div>
                              <div class="row">
                              <div class="form-group">
                                 <label class="col-sm-6">Pay Amount (Rs.) </label>
                                 <div class="col-sm-6" id="">
                                    <input data-bv-field="slname" id="amount" name="amount" class="form-control"  required value="<?php echo (empty($_POST['amount'])) ? '' : $_POST['amount'] ?>" placeholder="Amount" type="text">
                                 </div>
                              </div>
                               </div>
                              <div class="row">
                              <div class="form-group">
                                 <div class="col-sm-6"></div>
                                 <div class="col-sm-4">
                                     <?php
                                     if($vmob=='' || $vem=='' || $_SESSION['name']=="170101051057")
                                     {echo '<b style="color:red">Please update mobile and email address</b>';
                                     }
                                     else
                                     {
                                     ?>
                                    <button class="btn btn-primary nextBtn form-control"  type="submit" >Pay Now</button>
                                    <?php
                                    }
                                    ?>
                                 </div>
                              </div>
                            <div class="loader" style="display:none;"></div> 
                          </div>  
                          </div>
                          <div class="col-sm-1"></div>
                          <div class="col-sm-5"><h4><b>Instructions:</b></h4>
                          <ol style="font-family:verdana;">
                            <li>For <b>Re-registration</b> select Academic Year <b>2020-21</b> and fees type <b>Re-registration</b> then click on Pay now button.</li>
                            <li>Select Fees type and Enter the Payment amount.</li>
                            <li>After Clicking on the <b>Pay Now</b> button ,it will redirect to Payment Gateway page.</li>
                            <li>After payment successful completion you will receive SMS notification and Email with Payment Receipt.</li>
                            <li>Kindly submit the same payment recepit to the Account section for verification with in a Week.</li>
                            <li>This is authorised payment gateway provided by Sandip university.</li>
                            <li>If <b>Pay Now</b> button is not visible then kindly update your mobile or email from student sections.</li>
                            
                          </ol>
                          
                    </div>
                   
                  <div class="col-lg-12">
                  </div>
               </div>
               <?php
                  // var_dump($stdata);
                   if(count($_POST)>0)
                   {
                       //echo "jugal";
                       ?>
               <script>
               //   $( "#payuForm" ).submit();
                  
                  
               </script>
               <?php
                  }
                  ?>
            </form>
         </div>
      </div>
      <script type="text/javascript">
   function  donep(){$(".loader").hide();
  var payuForm = document.forms.payuForm;
   payuForm.submit();
 //$('#payuForm').trigger('submit');

   }
   function submitPayuForm() {
	   var amount = $("#amount").val();
	 
     /*if(hash == '') {
       return false;
     }*/
	 if((amount==0)||(amount=='')){
		  alert("please Enter Amount");
		 return false;
		 
	 }
	
	 //$(".loader").show();
	 var txtid=$("#txtid").val();
	 var email=$("#email").val();
	 var firstname=$("#firstname").val();
	 var productinfo=$("#productinfo").val();
	 var amount=$("#amount").val();
	 var udf3=$("#udf3").val();
	 var udf4=$("#udf4").val();
	var fdata=$('#payuForm').serialize();
	//alert(data);
	$('.loader').show();
	 $.ajax({
   'url' : base_url + 'Online_fee/Online_fee_entery_full',
   'type' : 'POST', //the way you want to send data to your URL
   'data' : $('#payuForm').serialize(),
   'dataType': "json",
   'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
   //var container = $('#feepend'); //jquery selector (get element by id)
   if(data!==''){
 // alert(data.txnid);
 
    $('#txnid').val(data.txnid);
	$('#hash').val(data.hash);
	$('#amount').val(data.amount);
	
	$('#udf1').val(data.udf1);
	$('#udf3').val(data.udf3);
	$('#udf4').val(data.udf4);
	$('#udf5').val(data.udf5);
	if(productinfo=='Re-Registration'){
	 $('#amount').attr('readonly', true); 
	}else{
	$('#amount').attr('readonly', false); 
	}
	setTimeout(function(){ donep() }, 2000);
//alert();
   //var payuForm = document.forms.payuForm;
   //payuForm.submit();
   }
   }
   });
	 
	 
	  return false;
	 
    
   }
  
</script>
<?php if($_POST['productinfo']=='Admission'){?>
 <script type="text/javascript">
   var ftype = $("#productinfo").val();
   var year = $("#udf2").val();
   $.ajax({
   'url' : base_url + 'Online_fee/fetch_feedet_full',
   'type' : 'POST', //the way you want to send data to your URL
   'data' : {'ftype' : ftype,'year' : year},
   'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
   var container = $('#feepend'); //jquery selector (get element by id)
   if(data){
   //   alert(data);
   //alert("Marks should be less than maximum marks");
   //$("#"+type).val('');
   container.html(data);
   }
   }
   });
  
   </script>
   <?php } ?>       
   </div>
</div>