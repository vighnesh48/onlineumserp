<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<script src="<?=base_url('assets/javascripts')?>/jquery.table2excel.js"></script>
<script src="<?=base_url('assets/javascripts')?>/bootstrap-datepicker.js "></script>
<?php 
$i=0;
foreach($reddystudents as $ra){
					$redyy[$i] =$ra['student_id'];
					$redyy_stud[] =$ra['student_id'];
					$i++;
				}
				//print_r($redyy);
$redyy = json_encode($redyy);
//echo '<pre>';print_r($redyy_stud);
if(in_array($stdata['stud_id'], $redyy_stud)){
	$hostel_pending =5000;
}else{
$hostel_pending =$hostel_pending['pending_fees'];
}
//echo $_SESSION['amount']; exit;
?>
<script>
$( document ).ready(function() {
    checkExamfees();
});
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
	   //var reddy_stud_arr=<?php echo $redyy; ?>;
	   var reddy_stud_arr='';
	  //console.log(reddy_stud_arr);
	   $('#lateFee').hide(); 
	   $(".Paymenttype").hide();
	   $(".exam_session").hide();
   var Payment_type= $("#Payment_type").val();
   var ftype = $("#productinfo").val();
   var year = $("#udf2").val();
   var stud_id = $("#stud_id").val();
   var course_id = $("#course_id").val();
    var admission_session = $("#admission_session").val();
    var admission_cycle = $("#admission_cycle").val();
	var examsession=$("#examsession").val();
   $.ajax({
   'url' : base_url + 'Online_fee/fetch_feedet',
   'type' : 'POST', //the way you want to send data to your URL
   'data' : {'ftype' : ftype,'year' : year,'stud_id':stud_id,'Payment_type':Payment_type,'admission_session':admission_session,'examsession':examsession},
   'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
   var container = $('#feepend'); //jquery selector (get element by id)
   if(data){
   //   alert(data);
   //alert("Marks should be less than maximum marks");
   //$("#"+type).val('');
   container.html(data);
   }
   //alert(year);
    $(".nextBtn ").prop('disabled', false);
   if(ftype=='Examination'){
	   $(".exam_session").show();
	   //$("#exam_session").html('<select name="examsession" id="examsession" class="form-control" onchange="onPayment_type()"><option //value="">Select exam session</option><option value="23">SEPT-2021</option><option value="20">JUNE-2021</option><option //value="21">JULY-2021</option><option value="19">APRIL-2021</option></select>');
	    // $("#amount").val(data);
	    // $('#amount').attr('readonly', true); 
   }else if(ftype=='Revaluation'){
	   $("#amount").val(data);
	   $('#amount').attr('readonly', true); 
   }else if(ftype=='Duplicate_hallticket'){
	   $(".exam_session").show();
	   $("#amount").val(data);
	   $('#amount').attr('readonly', true); 
   }else if(ftype=='Admission'){
	   
	   if(year=="2025"){
		   $(".Paymenttype").show();
	  /* <option value="3">35% Payment</option><option value="3">35% Payment</option><option value="3">70% Payment</option><option value="3">70% Payment</option>*/
	  if(admission_session==2025){
		  
		  if(course_id==5){
			  //alert(5);
			 $("#PaymentType").html('<select name="Payment_type" id="Payment_type" class="form-control" onchange="onPayment_type()"><option value="">Select Payment Type</option><option value="1">50% Payment</option><option value="3">70% Payment</option><option value="2">Full Payment</option></select>');  
		  }else if(admission_cycle != ''){
			  //alert(4);
			  
			   $("#PaymentType").html('<select name="Payment_type" id="Payment_type" class="form-control" onchange="onPayment_type()"><option value="">Select Payment Type</option><option value="4">50% Payment</option><option value="2">Full Payment</option></select>');
			  
		  } 
		  else{
			  // alert(3);
		  
		  if(jQuery.inArray(stud_id, reddy_stud_arr) != -1) {
			  //alert(stud_id);
				$("#PaymentType").html('<select name="Payment_type" id="Payment_type" class="form-control" onchange="onPayment_type()"><option value="">Select Payment Type</option><option value="33">Package</option></select>');
			} else {
			$("#PaymentType").html('<select name="Payment_type" id="Payment_type" class="form-control" onchange="onPayment_type()"><option value="">Select Payment Type</option><!--option value="1">50% Payment</option--><!--option value="4">50% Payment</option --><option value="1">50% Payment</option><option value="3">70% Payment</option><option value="2">Full Payment</option></select>');
		   } 
		  }
	  }else{
		  //alert(admission_cycle);
		  if(admission_cycle != ''){
			 // alert(4);
			  
			   $("#PaymentType").html('<select name="Payment_type" id="Payment_type" class="form-control" onchange="onPayment_type()"><option value="">Select Payment Type</option><option value="1">50% Payment</option><option value="2">Full Payment</option></select>');
			  
		  } else{
		   $("#PaymentType").html('<select name="Payment_type" id="Payment_type" class="form-control" onchange="onPayment_type()"><option value="">Select Payment Type</option><option value="1">50% Payment</option><option value="3">70% Payment</option><option value="2">Full Payment</option></select>');
		  }
	  }
	   
		
		 
		  $('#amount').attr('readonly', true);
	   }else{
	    $(".Paymenttype").show();
	   if(admission_cycle != ''){
			  //alert(4);
			  
			   $("#PaymentType").html('<select name="Payment_type" id="Payment_type" class="form-control" onchange="onPayment_type()"><option value="">Select Payment Type</option><option value="4">50% Payment</option><option value="2">Full Payment</option></select>');
			  
		  } 
		
	   var amt= data.split('~~');
	   var tbl_tot_fees='<table border="1" ><tr style="background:#3175af"><th><label class="">Total fees </label></th><th><label class="">Paid fees </label></th><th><label class="">Pending fees </label></th></tr><tr style="color:#000000"><td><b><label class="">'+Math.round(amt[0])+'</label></td><td><label class="">'+Math.round(amt[1])+'</label></td><td><label class="">'+Math.round(amt[2])+'</label></b></td></tr></table>';
	   
	   container.html(tbl_tot_fees);
	   
	   if(amt[2]<0){
	   $("#amount").val(0);

	   }else{
		  $("#amount").val(Math.round(amt[2])); 
	   }
	   
	   $('#amount').attr('readonly', false); 
	   }
	 // $("#amount").val(data);
	   //$('#amount').attr('readonly', false); 
	   
	   
   }else if(ftype=='Photocopy'){
	   $("#amount").val(data);
	   $('#amount').attr('readonly', false); 
	   
   }else if(ftype=='Re-Registration'){
	   /*<option value="4">70% Payment</option><option value="3">70% Payment</option>*/
	     $(".Paymenttype").show();
	     $("#PaymentType").html('<select name="Payment_type" id="Payment_type" class="form-control" onchange="onPayment_type()"><option value="">Select Payment Type</option><option value="3">35% Payment</option><option value="2">Full Payment</option></select>');
	   
	   
	  /* var amt= data.split('~~');
	   
	   if(!isNaN(amt[0])){
		   container.html('');
		     $(".Paymenttype").show();
	   }else
	   {
		    container.html(data);
	   }*/
	  // $(".Paymenttype").show();
	   /*$(".Paymenttype").show();
	   var amt= data.split('~~');
	   var tbl_tot_fees='<table border="1" ><tr style="background:#3175af"><th><label class="">Total fees </label></th></tr><tr style="color:#000000"><td><b><label class="">'+Math.round(amt[0])+'</label></td></tr></table>';
	   
	   if(!isNaN(amt[0])){
	   if (amt[1] < 0) {
	container.html('');	   
$("#amount").val('');
var url="https://erp.sandipuniversity.com/online_fee/pay_full_fees";
 var msg='<table border="1" ><tr style="background:#3175af"><th>Fees already with us.<br>If You want Pay full payment <a href='+url+'><u style="color:#fff">Click here</u></a></label></td></tr></table>';
container.html(msg);	
$(".nextBtn ").prop('disabled', true);  
} else {
  $("#amount").val(Math.round(amt[1]));
  $(".nextBtn ").prop('disabled', false);
  container.html(tbl_tot_fees);
}
	   }else{
		   
		 var text=  '<table border="1" ><tr style=""><th><label class=""><b style="color:#000000">&nbsp;First pay Admission 2019-20 Pending Fee.<br> Then You are eligible For Re-Registration.<br>Pending Amount Rs.'+Math.round(amt[2])+'</b>&nbsp;</label></td></tr></table>';
		   container.html(text);
		   $("#amount").val('');
	   }
	   
	  // $("#amount").val(Math.round(amt[1]));
	   
	 $('#amount').attr('readonly', true); */
   } 
   
   }
   
   });
   });         
   
   
   });
   $(function() {
        $(this).bind("contextmenu", function(e) {
            e.preventDefault();
        });
    }); 
 // $("#Payment_type").change(function(){
	 function onPayment_type(){
	 // alert();
	   //$(".Paymenttype").hide();
	     
   var Payment_type= $("#Payment_type").val();
   var ftype = $("#productinfo").val();
   var year = $("#udf2").val();
   var stud_id = $("#stud_id").val();
   var course_id = $("#course_id").val();
    var admission_session = $("#admission_session").val();
    var examsession=$("#examsession").val();

   $.ajax({
   'url' : base_url + 'Online_fee/fetch_feedet',
   'type' : 'POST', //the way you want to send data to your URL
   'data' : {'ftype' : ftype,'year' : year,'stud_id':stud_id,'Payment_type':Payment_type,'admission_session':admission_session,'examsession':examsession,'course_id':course_id},
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
	   if((data==0)){
		   var msgd='<table border="1" ><tr style="background:#3175af"><th>Exam fees already paid.<br></label></td></tr></table>';
		   container.html(msgd);
		   $("#amount").val('');
		   $('#amount').attr('readonly', true); 
	   }else{
		   container.html('');
	  $("#amount").val(data);
	  $('#amount').attr('readonly', true); 
	   }
	  
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
		   if(year=="2025"){$("#amount").val(Math.round(amt[3])); }else{
		  $("#amount").val(Math.round(amt[2])); 
		   }
	   }
	   
	   $('#amount').attr('readonly', true); 
	   
	 // $("#amount").val(data);
	   //$('#amount').attr('readonly', false); 
   }else if(ftype=='Photocopy'){
	   $("#amount").val(data);
	   $('#amount').attr('readonly', false); 
   }else if(ftype=='Re-Registration'){
	   $(".Paymenttype").show();
	   
	   var amt= data.split('~~');
	   //console.log(amt);
	   $("#udf6").val(amt[4]);
	    var udf6= amt[4];
	   var tbl_tot_fees='<table border="1" ><tr style="background:#3175af"><th><label class="">Total fees </label></th></tr><tr style="color:#000000"><td><b><label class="">'+Math.round(amt[0])+'</label></td></tr></table>';
	  // if(stud_id==4123){alert(amt[0]);}
	   if(!isNaN(amt[0])){
	   if (amt[1] < 0) {
	container.html('');	   
$("#amount").val('');
var url="https://erp.sandipuniversity.com/online_fee/pay_full_fees";
 var msg='<table border="1" ><tr style="background:#3175af"><th>Fees already with us.<br></label></td></tr></table>';
 //If You want Pay full payment <a href='+url+'><u style="color:#fff">Click here</u></a>
container.html(msg);	

$(".nextBtn ").prop('disabled', true);  
} else {
	var amountt=Math.round(amt[1])+Math.round(udf6)+Math.round(amt[2]); 
  $("#amount").val(Math.round(amountt));
  $("#opeing_balnace").val(Math.round(amt[2]));
  $(".nextBtn ").prop('disabled', false);
  container.html(tbl_tot_fees);
}
	   }else{
		   
		 var textt=  '<table border="1" ><tr style=""><th><label class=""><b style="color:#000000">&nbsp;First pay Admission 2020-21 Pending Fee.<br> Then You are eligible For Re-Registration.<br>Pending Amount Rs.'+Math.round(amt[2])+'</b>&nbsp;</label></td></tr></table>';
		   container.html(textt);
		   $("#amount").val('');
	   }
	   
	  // $("#amount").val(Math.round(amt[1]));
	   
	 $('#amount').attr('readonly', true); 
   } 
   
   }
   });
   $('#lateFee').show(); 
   //});    
   
           

 //  });
   
   }
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
.panel{
    box-shadow: 1px 2px 13px #ccc!important;
}
.panel:hover{
    box-shadow:1px 2px 7px #f2f2f2!important;
}
 /* remove border radius for the tab */
         #exTab1{ padding: 10px;}
         #exTab1 .nav-pills > li > a {
         border-radius: 0;
         margin-top:10px;
         }
         
         #exTab1 .tab-content {
         padding: 5px 15px;
         border: #e9e5e5 solid 1px;
         margin-top: -10px;
		
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
      <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon text-danger"></i>&nbsp;&nbsp;Make Payment</h1>
      <div class="col-xs-12 col-sm-8">
         <div class="row">
            <hr class="visible-xs no-grid-gutter-h">
            <?php 			
			$MERCHANT_KEY = "soe5Fh";
					
				$reddy_stud_arr =$reddystudents;
				
				
				//echo '<pre>';print_r($redyy);exit;
			//if(in_array("Add", $my_privileges)) { ?>
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
               <span class="panel-title"> Online Payment</span>
               
            </div>
            <div id="exTab1">
            <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#home">Admission / Examination</a></li>
    <!--li><a data-toggle="tab" href="#menu1"> Transportation</a></li>
    <?php //if($stdata['stud_id']=="3407"){ ?>
    <li><a data-toggle="tab" href="#menu2"> Hostel Gyms</a></li>
     <?php //if($stdata['stud_id']=="7972")
	 { ?>
    <li><a data-toggle="tab" href="#menu3">Hostel</a></li>
	<li><a data-toggle="tab" href="#menu4">Caution Payment</a></li>
    <?php  } ?>
  <!--  <li><a data-toggle="tab" href="#menu2">Menu 2</a></li>
    <li><a data-toggle="tab" href="#menu3">Menu 3</a></li>-->
  </ul>
            
            
            <?php
            $vmob =$stdata['mobile'];
            $vem = $stdata['email'];
            ?>
            <div class="tab-content  clearfix">
             
            <div id="home" class="tab-pane fade in active">
            <input type="hidden" name="course_id" id="course_id" value="<?php echo $stdata['course_id']; ?>" required="required"> 
            <form  name="payuForm"  id="payuForm" method="post" action="https://secure.payu.in/_payment" onSubmit="return submitPayuForm();">
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
                     <input type="hidden" name="udf3" id="udf3" value="">     
                     <input type="hidden" name="udf4" id="udf4" value="">
                     <input type="hidden" name="udf5" id="udf5" value=""> 
                      

                     <input type="hidden" name="stud_id" id="stud_id" value="<?php echo $stdata['stud_id']; ?>" required="required"> 
                     <input type="hidden" name="mobile" id="mobile" value="<?php echo $stdata['mobile']; ?>" required="required">
                     <input type="hidden" name="admission_cycle" id="admission_cycle" value="<?php echo $stdata['admission_cycle']; ?>">
                     <input type="hidden" name="admission_session" id="admission_session" value="<?php echo $stdata['admission_session']; ?>" required="required">
                     <input type="hidden" name="surl" value="https://erp.sandipuniversity.com/online_fee/success"/>
                     <input type="hidden" name="furl" value="https://erp.sandipuniversity.com/online_fee/failure"/>
                     
                     <!--<input type="hidden" name="furl" value="https://erp.sandipuniversity.com/test1">-->
                </div>
                
                          <div class="row">
                          <div class="col-sm-6">
                          
                          <div class="row"></div>
                            
                                <div class="row">
                                <div class="form-group">
                                     <label class="col-sm-6">Academic Year: </label>
                                 <div class="col-sm-6" id="">
<?php // print_r($stdata);
  //admission_cycle
 ?>
                                        <select name="udf2" id="udf2" class="form-control" required readonly>
                                           <option value="">Select Year</option>
                                       
									 <?php if(empty($stdata['admission_cycle'])) {  ?>
									   
                                         <option value="2025" <?php if($stdata['academic_year']=='2025'){ echo "selected";}
									   ?>>2025-26</option>
									   <!--option value="2023" <?php if($stdata['academic_year']=='2023'){ echo "selected";}
									   ?>>2023-24</option-->
									 <?php }else{ ?>
										 <option value="2025" <?php if($stdata['academic_year']=='2025'){ echo "selected";}
									   ?>>2025-26</option>
										 <option value="2024" <?php if($stdata['academic_year']=='2024'){ echo "selected";}
									   ?>>2024-25</option>
									      <option value="2023" <?php if($stdata['academic_year']=='2023'){ echo "selected";}
									   ?>>2023-24</option>
										 <option value="2022" <?php if($stdata['academic_year']=='2022'){ echo "selected";}
									   ?>>2022-23</option> 
									   <option value="2021" <?php if($stdata['academic_year']=='2021'){ echo "selected";}
									   ?>>2021-22</option> 
									<?php }
									 
									 
									 ?>
									   
									   
                                        <?php if(empty($adm)){?>
                                         <!--option value="2020" <?php if($stdata['academic_year']=='2020'){ echo "selected";}
									   ?>>2020-21</option-->
                                         <?php } ?>
                                         <?php // if(empty($adm)){?>
										 <!--option value="2019" <?php if($stdata['academic_year']=='2019'){ echo "selected";}
									   ?>>2019-20</option-->
                                         <?php //} ?>
                                        <!--option value="2018">2018-19</option-->
                                        </select>
                                </div>
                                </div>
                                </div>
                                
                            <div class="row">
                            <div class="form-group">
                                 <label class="col-sm-6">Fees Type: </label>
                             <div class="col-sm-6" id="">
                                    <select name="productinfo" id="productinfo" class="form-control" required>
                                       <option value="">Select Fee Type</option>
                                       <?php if(empty($adm) && empty($stdata['admission_cycle'])){ 
										   if(!empty($_POST['productinfo'])){
											   $productinfo=$_POST['productinfo'];
										   }else{
											   $productinfo=$productinfo1;
										   }
										   ?>
                                    <option value="Re-Registration" <?php if($_POST['productinfo']=='Re-register'){echo "selected";} ?>>Re-Registration</option>
									<!--option value="Admission" <?php if($_POST['productinfo']=='Admission'){echo "selected";} ?>>Admission</option>
                                       <option value="Examination" <?php if($_POST['productinfo']=='Examination'){echo "selected";} ?>>Examination</option-->
                                       <?php }else{ ?>
                                       <option value="Admission" <?php if($_POST['productinfo']=='Admission'){echo "selected";} ?>>Admission</option>
									   
                                     
									   <option value="Examination" <?php if($_POST['productinfo']=='Examination'){echo "selected";} ?>>Examination</option>
                                       
                                        <option value="Duplicate_hallticket" <?php if($_POST['productinfo']=='Duplicate_hallticket'){echo "selected";} ?>>Duplicate Hall-Ticket</option>
                                        <?php if($stdata['enrollment_no']=='210105181025' || $stdata['enrollment_no']=='210101051028' || $stdata['enrollment_no']=='210101051108' || $stdata['enrollment_no']=='200105121009'  ){?>
                                       
                                         <option value="Examination" <?php if($_POST['productinfo']=='Examination'){echo "selected";} ?>>Examination</option>
                                       
									   <!--option value="Revaluation" <?php if($_POST['productinfo']=='Revaluation'){echo "selected";} ?>>Revaluation</option-->
									   <!--option value="Photocopy" <?php if($_POST['productinfo']=='Photocopy'){echo "selected";} ?>>Photocopy</option-->
									  
									   <?php }
									   }?>
                                    </select>
                              </div>
                              </div>
                              </div>
                               
                               <div class="row Paymenttype" style="display:none;">
                               <div class="form-group">
                                     <label class="col-sm-6">Payment Type: </label>
                                <div class="col-sm-6" id="PaymentType">

                                        <select name="Payment_type" id="Payment_type" class="form-control">
                                         <option value="">Select Payment Type</option>
                                         <option value="3">35% Payment</option>
                                         <option value="1">Half Payment</option>
										 <option value="2">Full Payment</option>
                                         <option value="4">70% Payment</option>
                                        <!--option value="2018">2018-19</option-->
                                        </select>
                                 </div>
                                </div>
                                </div>
                                
								<div class="row exam_session" style="display:none;">
                                <div class="form-group">
                                     <label class="col-sm-6">Exam Session: </label>
                                <div class="col-sm-6" id="exam_session">

                                        <select name="examsession" id="examsession" class="form-control" onChange="onPayment_type()">
										<option value="">Select Exam Session</option>
										<?php  //print_r($ex_list);
											foreach($ex_list as $listnew){
												?>
				 <option value="<?php echo $listnew['exam_id'];?>"> <?php echo $listnew['exam_month'].'-'.$listnew['exam_year']; ?></option>
											<?php 
											}
										?>
                                        </select>
                                </div>
                                </div>
                                </div>
                             
                             
                             <div class="row">
                             <div class="form-group">
                             <div class="col-sm-6" id=""></div>
                             <div class="col-sm-6" id="feepend" style="color:white;  text-align: center;"></div>
                             </div>
                             </div>
                               
                              <div class="row" style="display:none;" id="lateFee">
                              <div class="form-group">
                                 <label class="col-sm-6">Late Fee (Rs.) </label>
                                <div class="col-sm-6" id="">
                                    <input data-bv-field="slname" id="udf6" name="udf6" class="form-control" value="0" placeholder="Late Fee" type="text" readonly> 
                                 </div>+
                              </div>
                               </div>
                              
                              
                              <div class="row">
                              <div class="form-group">
                                 <label class="col-sm-6">Pay Amount (Rs.) </label>
                               <div class="col-sm-6" id="">
                                <input data-bv-field="slname" id="amount" name="amount" class="form-control"  required value="<?php echo (empty($_POST['amount'])) ? '' : $_POST['amount'] ?>" placeholder="Amount" type="text" readonly> <!--+ Late Fee <input id="udf6" name="udf6" class="form-control" value="0" placeholder="Late Fee" type="text" readonly>-->
                                 <input type="hidden" name="opeing_balnace" id="opeing_balnace" value="" />
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
                          
                          <div class="row">
                          <div class="form-group">
                          <div class="col-sm-12"><span style="color:#900"><h4>Please keep 30 minutes time between two Transactions</h4></span></div>
                          </div>
                          </div>
                          
                          </div>
                          
                          <div class="col-sm-1"></div>
                          <div class="col-sm-5"><h4><b>Instructions:</b></h4>
                          <ol style="font-family:verdana;line-height:24px;">
                            <li>For <b>Admission</b> select Academic Year <b>2025-26</b> and fees type <b>Admission</b> then click on Pay now button.</li>
                            <li>Select Fees type and Enter the Payment amount.</li>
                            <li>After Clicking on the <b>Pay Now</b> button ,it will redirect to Payment Gateway page.</li>
                            <li>After payment successful completion you will receive SMS notification and Email with Payment Receipt.</li>
                            <li>Kindly submit the same payment recepit to the Account section for verification with in a Week.</li>
                            <li>This is authorised payment gateway provided by Sandip university.</li>
                            <li>If <b>Pay Now</b> button is not visible then kindly update your mobile or email from student sections.</li>
                            
                          </ol></div>
                         <div class="col-lg-12"></div>
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
            <!--tab-pane-->
             <div id="menu1" class="tab-pane fade">
             
             <form  name="payuForm_ht"  id="payuForm_ht" method="post" action="https://secure.payu.in/_payment" onSubmit="return submitPayutransport();">
               <div class="table-info panel-body">
                 <div class="form-group">
                     <input type="hidden" name="key" value="w75rWU" /><?php //echo $MERCHANT_KEY ?>
                     <input type="hidden" name="hash" id="hash_ht" value=""/>
                     <input type="hidden" name="txnid" id="txnid_ht" value="" />
                    <!-- <input type="hidden" name="action" value="https://secure.payu.in/_payment" />-->
                     <?php // $vat = date('ymd')."".rand(1000,9999); ?>
                     <input name="firstname" id="firstname_ht" type="hidden"  placeholder="Enter your Name*"  value="<?php echo trim($Transportation_payment[0]['first_name']); ?>"  required />
                     <input name="email" id="email_ht" type="hidden"  placeholder="Email*"  value="<?php echo $Transportation_payment[0]['email']; ?>"  required />
                     <input type="hidden" name="udf1" id="udf1_ht" value="">
                     <input type="hidden" name="udf2" id="udf2_ht" value="">
                     <input type="hidden" name="udf3" id="udf3_ht" value="<?php echo $Transportation_payment[0]['mobile']; ?>">     
                     <input type="hidden" name="udf4" id="udf4_ht" value="">
                     <input type="hidden" name="udf5" id="udf5_ht" value=""> 
                     
                     <input type="hidden" name="fc_id" id="fc_id_ht" value="">
                     <input type="hidden" name="adhar_card_no" id="adhar_card_no_ht" value="<?php echo $Transportation_payment[0]['adhar_card_no']; ?>">
                     <input type="hidden" name="org_frm" id="org_frm_ht" value="SU">
                    <!-- <input type="hidden" name="productinfo" id="productinfo_ht" value="online_transporation_new"> -->
                     <input type="hidden" name="stud_id" id="stud_id_ht" value="<?php echo $Transportation_payment[0]['stud_id']; ?>" required="required"> 
                     <input type="hidden" name="prn_no" id="prn_no_ht" value="<?php echo $Transportation_payment[0]['enrollment_no']; ?>" required="required"> 
                     <input type="hidden" name="prn_no_new" id="prn_no_new" value="<?php echo $Transportation_payment[0]['enrollment_no_new']; ?>" required="required">
                     <input type="hidden" name="mobile" id="mobile_ht" value="<?php echo $Transportation_payment[0]['mobile']; ?>" required="required">
                     <input type="hidden" name="admission_session" id="admission_session_ht" value="<?php echo $Transportation_payment[0]['admission_session']; ?>" required="required">
                     <input type="hidden" name="ac_year" id="ac_year_ht" value="2025" required="required">
                     <input type="hidden" name="hidac_year" id="hidac_year_ht" value="<?php echo $Transportation_payment[0]['academic_year']; ?>" required="required">
                     <input type="hidden" name="surl" value="https://erp.sandipuniversity.com/Online_transport_fee/payu_success"/>
                     <input type="hidden" name="furl" value="https://erp.sandipuniversity.com/Online_transport_fee/payu_failure"/>
                     <?php //print_r($Transportation_payment); ?>
                     <div class="row">
                      <div class="form-group">
                                 <label class="col-sm-3">Type</label>
                    <div class="col-sm-3" id="">
                                    <select name="productinfo" id="productinfo_ht" class="form-control" required>
                                       <option value="">Select Fee Type</option>
                                       
                                    <!--  <option value="online_hostel_new">Hostel</option> -->
                                       
                                     
                                       <option value="online_transporation_new">Transporation</option>
                                     
									  
									   
                                    </select>
                              </div>
                    </div>
                    </div>
                              
                              <div class="row Deposite" style="display:none;">
                              <div class="form-group">
                                 <label class="col-sm-3">Deposite</label>
                               <div class="col-sm-3" id="">
                                <input data-bv-field="slname" id="Deposite_ht" name="Deposite" class="form-control"  required value="0" placeholder="Deposite" type="text" readonly> <!--+ Late Fee <input id="udf6" name="udf6" class="form-control" value="0" placeholder="Late Fee" type="text" readonly>-->
                                 
                                 
                               </div>
                               </div>
                               </div>
                               
                               <div class="row Opeing" style="display:none;">
                              <div class="form-group">
                                 <label class="col-sm-3">Opeing Balnace</label>
                               <div class="col-sm-3" id="">
                                <input data-bv-field="slname" id="opeing_balnace_ht" name="opeing_balnace" class="form-control"  value="0" placeholder="opeing balnace" type="text" readonly> <!--+ Late Fee <input id="udf6" name="udf6" class="form-control" value="0" placeholder="Late Fee" type="text" readonly>-->
                                 
                                 
                               </div>
                               </div>
                               </div>
                               
                               <div class="rout" style="display:none;">
                               
                               <div class="row">
                              <div class="form-group">
                                 <label class="col-sm-3">Route&nbsp;Name:</label>
                               <div class="col-sm-3" id="">
                               <span class="rout_FROM"></span>
                                 
                                 
                               </div>
                               </div>
                               </div>
                               <div class="row">
                              <div class="form-group">
                                 <label class="col-sm-3">Boarding&nbsp;Point:&nbsp;:</label>
                               <div class="col-sm-3" id="">
                               <span class="rout_To"></span>
                                 
                                 
                               </div>
                               </div>
                               </div>
                               
                               
                               
                               
                               
                              
                               </div>
                               
                    
                              <div class="row">
                              <div class="form-group">
                                 <label class="col-sm-3">Pay Amount (Rs.) </label>
                               <div class="col-sm-3" id="">
                                <input data-bv-field="slname" id="amount_ht" name="amount" class="form-control"  required value="" placeholder="Amount" type="text" readonly> <!--+ Late Fee <input id="udf6" name="udf6" class="form-control" value="0" placeholder="Late Fee" type="text" readonly>-->
                                
                                 
                               </div>
                               </div>
                               </div>
                               
                                <div class="row">
                              <div class="form-group">
                              <div class="col-sm-3"></div>
                              </div>
                              </div>
                              
                               <div class="row">
                              <div class="form-group">
                              <div class="col-sm-3"></div>
                              <div class="col-sm-3">
                                     <?php
                                     if($Transportation_payment[0]['email']=='' || $Transportation_payment[0]['mobile']=='' || $_SESSION['name']=="170101051057")
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
                             <!--<div class="loader" style="display:none;"></div> -->
                             </div>
                               
                               
                               
                               
                               
                </div></div>
                </form>
             
             
             <div class="loader" style="display:none;"></div> 
              </div>
              
             
              <div id="menu2" class="tab-pane fade">
              <form  name="payuForm_hh"  id="payuForm_hh" method="post" action="https://secure.payu.in/_payment" onSubmit="return submitPayugym();">
               <div class="table-info panel-body">
                 <div class="form-group">
                     <input type="hidden" name="key" value="BGdiP5" /><?php //echo $MERCHANT_KEY ?>
                     <input type="hidden" name="hash" id="hash_hh" value=""/>
                     <input type="hidden" name="txnid" id="txnid_hh" value="" />
                    <!-- <input type="hidden" name="action" value="https://secure.payu.in/_payment" />-->
                     <?php // $vat = date('ymd')."".rand(1000,9999); ?>
                     <input name="firstname" id="firstname_hh" type="hidden"  placeholder="Enter your Name*"  value="<?php echo trim($Transportation_payment[0]['first_name']); ?>"  required />
                     <input name="email" id="email_hh" type="hidden"  placeholder="Email*"  value="<?php echo $stdata['email']; ?>"  required />
                     <input type="hidden" name="mobile" id="mobile_hh" value="<?php echo $stdata['mobile']; ?>" required="required">
                     <input type="hidden" name="udf1" id="udf1_hh" value="">
                     <input type="hidden" name="udf2" id="udf2_hh" value="">
                     <input type="hidden" name="udf3" id="udf3_hh" value="<?php echo $stdata['enrollment_no']; ?>">     
                     <input type="hidden" name="udf4" id="udf4_hh" value="<?php echo $stdata['mobile']; ?>">
                     <input type="hidden" name="udf5" id="udf5_hh" value="<?php echo $stdata['stud_id']; ?>"> 
                     <input type="hidden" name="stud_id" id="stud_id_hh" value="<?php echo $stdata['stud_id']; ?>" required="required">
                     <input type="hidden" name="surl" value="https://erp.sandipuniversity.com/Online_fee/success_gym"/>
                     <input type="hidden" name="furl" value="https://erp.sandipuniversity.com/Online_fee/failure_gym"/>
                     <input type="hidden" name="productinfo" id="productinfo_hh" value="Hostel_Gym_new" />
                     
                    
                     <?php //print_r($Transportation_payment); ?>
                      <div class="row">
                      <label class="col-sm-3">&nbsp;</label>
                      <label class="col-sm-4">per month subscription Fees-: 600 RS</label>
                      </div><div class="row">&nbsp;</div>
                     <div class="row">
                      <div class="form-group">
                                 <label class="col-sm-3">Type</label>
                    <div class="col-sm-3" id="">
                                    <select name="udf6" id="udf6_hh" class="form-control" required>
                                       <option value="">Select Fee Type</option>
                                       
                                    <!--  <option value="Hostel_admission_new">Hostel</option>-->
                                       
                                     
                                       <option value="1">1 Month</option>
                                       <option value="2">2 Month</option>
                                       <option value="3">3 Month</option>
                                       <option value="4">4 Month</option>
                                       <option value="5">5 Month</option>
                                       <option value="6">6 Month</option>
                                       <option value="7">7 Month</option>
                                       <option value="8">8 Month</option>
                                       <option value="9">9 Month</option>
                                       <option value="10">10 Month</option>
                                       <option value="11">11 Month</option>
                                       <option value="12">12 Month</option>

                                    </select>
                              </div>
                    </div>
                    </div>
                              
                              
                               
                               
                               
                               
                               
                    
                              <div class="row">
                              <div class="form-group">
                                 <label class="col-sm-3">Pay Amount (Rs.) </label>
                               <div class="col-sm-3" id="">
                                <input id="amount_hh" name="amount" class="form-control"  required value="600" placeholder="Amount" type="text" readonly> <!--+ Late Fee <input id="udf6" name="udf6" class="form-control" value="0" placeholder="Late Fee" type="text" readonly>-->
                                
                                 
                               </div>
                               </div>
                               </div>
                               
                                <div class="row">

                              <div class="form-group">
                              <div class="col-sm-3"></div>
                              </div>
                              </div>
                              
                               <div class="row">
                              <div class="form-group">
                              <div class="col-sm-3"></div>
                              <div class="col-sm-3"><?php //echo $stdata['enrollment_no']; ?>
                                     <?php
                                     if($stdata['email']=='' || $stdata['mobile']=='')//|| $_SESSION['name']=="170101051057"
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
                               
                               
                               
                               
                               
                </div></div>
                </form>
              </div>
              <div id="menu3" class="tab-pane fade">
              <form  name="payuForm_hp"  id="payuForm_hp" method="post" action="https://secure.payu.in/_payment" onSubmit="return submitPayuhostelpending();">
               <div class="table-info panel-body">
                 <div class="form-group">
                     <input type="hidden" name="key" value="BGdiP5" /><?php //echo $MERCHANT_KEY ?>
                     <input type="hidden" name="hash" id="hash_hp" value=""/>
                     <input type="hidden" name="txnid" id="txnid_hp" value="" />
                    <!-- <input type="hidden" name="action" value="https://secure.payu.in/_payment" />-->
                     <?php // $vat = date('ymd')."".rand(1000,9999); ?>
                     <input name="firstname" id="firstname_hp" type="hidden"  placeholder="Enter your Name*"  value="<?php echo trim($stdata['first_name']); ?>"  required />
                     <input name="email" id="email_hp" type="hidden"  placeholder="Email*"  value="<?php echo $stdata['email']; ?>"  required />
                     <input type="hidden" name="mobile" id="mobile_hp" value="<?php echo $stdata['mobile']; ?>" required="required">
                     <input type="hidden" name="udf1" id="udf1_hp" value="">
                     <input type="hidden" name="udf2" id="udf2_hp" value="">
                     <input type="hidden" name="udf3" id="udf3_hp" value="<?php echo $stdata['enrollment_no']; ?>">     
                     <input type="hidden" name="udf4" id="udf4_hp" value="<?php echo $stdata['mobile']; ?>">
                     <input type="hidden" name="udf5" id="udf5_hp" value="<?php echo $stdata['stud_id']; ?>"> 
                     <input type="hidden" name="stud_id" id="stud_id_hp" value="<?php echo $stdata['stud_id']; ?>" required="required">
                     <input type="hidden" name="surl" value="https://erp.sandipuniversity.com/Online_fee/success_hostel_pending"/>
                     <input type="hidden" name="furl" value="https://erp.sandipuniversity.com/Online_fee/failure_hostel_pending"/>
                     <input type="hidden" name="productinfo" id="productinfo_hh" value="Hostel_Pending_fees" />
                     
                    
                     <?php //print_r($Transportation_payment); ?>
                      <div class="row">
                      <label class="col-sm-3">&nbsp;</label>
                      <label class="col-sm-4"></label>
                      </div><div class="row">&nbsp;</div>
                     <div class="row">
                      <div class="form-group">
                                 <label class="col-sm-3">Type</label>
                    <div class="col-sm-3" id="">
                                    <select name="udf6" id="udf6_hp" class="form-control" required>
                                       <option value="">Select Fee</option>
                                       
                                    <!--  <option value="Hostel_admission_new">Hostel</option>-->
                                       
                                     
                                       <option value="1" selected="selected">Hostel Pending</option>
                                       

                                    </select>
                              </div>
                    </div>
                    </div>

                    
                              <div class="row">
                              <div class="form-group">
                                 <label class="col-sm-3">Pay Amount (Rs.) </label>
                               <div class="col-sm-3" id="">
                                <input id="amount_hp" name="amount" class="form-control"  required value="<?php echo $hostel_pending; ?>" placeholder="Amount" type="text" readonly> <!--+ Late Fee <input id="udf6" name="udf6" class="form-control" value="0" placeholder="Late Fee" type="text" readonly>-->
                                
                                 
                               </div>
                               </div>
                               </div>
                               
                                <div class="row">

                              <div class="form-group">
                              <div class="col-sm-3"></div>
                              </div>
                              </div>
                              
                               <div class="row">
                              <div class="form-group">
                              <div class="col-sm-3"></div>
                              <div class="col-sm-3"><?php //echo $stdata['enrollment_no']; ?>
                                     <?php
                                     if($stdata['email']=='' || $stdata['mobile']=='')//|| $_SESSION['name']=="170101051057"
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
                               
                               
                               
                               
                               
                </div></div>
                </form>
              
              </div>
            
			<div id="menu4" class="tab-pane fade">
              <form  name="payuForm_cm"  id="payuForm_cm" method="post" action="https://secure.payu.in/_payment" onSubmit="return submitPayucausion();">
               <div class="table-info panel-body">
                 <div class="form-group">
                     <input type="hidden" name="key" value="soe5Fh" /><?php //echo $MERCHANT_KEY ?>
                     <input type="hidden" name="hash" id="hash_cm" value=""/>
                     <input type="hidden" name="txnid" id="txnid_cm" value="" />
                    <!-- <input type="hidden" name="action" value="https://secure.payu.in/_payment" />-->
                     <?php // $vat = date('ymd')."".rand(1000,9999); ?>
                     <input name="firstname" id="firstname_cm" type="hidden"  placeholder="Enter your Name*"  value="<?php echo trim($stdata['first_name']); ?>"  required />
                     <input name="email" id="email_cm" type="hidden"  placeholder="Email*"  value="<?php echo $stdata['email']; ?>"  required />
                     <input type="hidden" name="mobile" id="mobile_cm" value="<?php echo $stdata['mobile']; ?>" required="required">
                     <input type="hidden" name="udf1" id="udf1_cm" value="">
                     <input type="hidden" name="udf2" id="udf2_cm" value="">
                     <input type="hidden" name="udf3" id="udf3_cm" value="<?php echo $stdata['enrollment_no']; ?>">     
                     <input type="hidden" name="udf4" id="udf4_cm" value="<?php echo $stdata['mobile']; ?>">
                     <input type="hidden" name="udf5" id="udf5_cm" value="<?php echo $stdata['stud_id']; ?>"> 
                     <input type="hidden" name="stud_id" id="stud_id_cm" value="<?php echo $stdata['stud_id']; ?>" required="required">
                     <input type="hidden" name="surl" value="https://erp.sandipuniversity.com/online_fee/success"/>
                     <input type="hidden" name="furl" value="https://erp.sandipuniversity.com/online_fee/failure"/>
                     <input type="hidden" name="productinfo" id="productinfo_cm" value="causion_money" />
                     
                    
                     <?php //print_r($Transportation_payment); ?>
                      <div class="row">
                      <label class="col-sm-3">&nbsp;</label>
                      <label class="col-sm-4"></label>
                      </div><div class="row">&nbsp;</div>
                     <div class="row">
                      <div class="form-group">
                                 <label class="col-sm-3">Type</label>
                    <div class="col-sm-3" id="">
                                    <select name="udf6" id="udf6_cm" class="form-control" required>
                                       <option value="">Select Fee</option>
                                       
                                    <!--  <option value="Hostel_admission_new">Hostel</option>-->
                                       
                                     
                                       <option value="1" selected="selected">Caution Pending</option>
                                       

                                    </select>
                              </div>
                    </div>
                    </div>
                              
                              
                               
                               
                               
                               
                               <?php if($causion_pending==''){
								   $causion_pending=500;
							   }?>
                    
                              <div class="row">
                              <div class="form-group">
                                 <label class="col-sm-3">Pay Amount (Rs.) </label>
                               <div class="col-sm-3" id="">
                                <input id="amount_cm" name="amount" class="form-control"  required value="<?php echo $causion_pending; ?>" placeholder="Amount" type="text" readonly> <!--+ Late Fee <input id="udf6" name="udf6" class="form-control" value="0" placeholder="Late Fee" type="text" readonly>-->
                                
                                 
                               </div>
                               </div>
                               </div>
                               
                                <div class="row">

                              <div class="form-group">
                              <div class="col-sm-3"></div>
                              </div>
                              </div>
                              
                               <div class="row">
                              <div class="form-group">
                              <div class="col-sm-3"></div>
                              <div class="col-sm-3"><?php //echo $stdata['enrollment_no']; ?>
                                     <?php
                                     if($stdata['email']=='' || $stdata['mobile']=='')//|| $_SESSION['name']=="170101051057"
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
                               
                               
                               
                               
                               
                </div></div>
                </form>
              
              </div>
            </div><!--tab-content-->
         </div><!--<exTab1>-->
         
         
      </div>
      </div>
       <script type="text/javascript">
var fullDate = new Date()
console.log(fullDate);
//Thu Otc 15 2014 17:25:38 GMT+1000 {}
  
//convert month to 2 digits
var twoDigitMonth = ((fullDate.getMonth().length+1) === 1)? (fullDate.getMonth()+1) :(fullDate.getMonth()+1);
  
var currentDate = twoDigitMonth+ "/" +fullDate.getDate() + "/" + fullDate.getFullYear();
console.log(currentDate);
var days = daysdifference('7/31/2020', currentDate);
  
console.log(days);
var late_fee=Math.round(days * 0);
  $("#udf6").val(late_fee);
function daysdifference(firstDate, secondDate){
    var startDay = new Date(firstDate);
    var endDay = new Date(secondDate);
   
    var millisBetween = startDay.getTime() - endDay.getTime();
    var days = millisBetween / (1000 * 3600 * 24);
   
    return Math.round(Math.abs(days));
}
</script> 
  <script type="text/javascript">
   function  donep(){ //$(".loader").hide();
   var payuForm = document.forms.payuForm;
   payuForm.submit();
 //$('#payuForm').trigger('submit');

   }
   function submitPayuForm() {
	   var amount = $("#amount").val();
	 //alert(amount);
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
	
	//return false;
	//console.log(fdata);
	$('.loader').show();
	 $.ajax({
   'url' : base_url + 'Online_fee/Online_fee_entery',
   'type' : 'POST', //the way you want to send data to your URL
   'data' : $('#payuForm').serialize(),
   'dataType': "json",
   'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
   //var container = $('#feepend'); //jquery selector (get element by id)
   //alert(amount);
   if(data!==''){
 // alert(data.amount);
 
    $('#txnid').val(data.txnid);
	$('#hash').val(data.hash);
	$('#amount').val(data.amount);
	
	$('#udf1').val(data.udf1);
	$('#udf3').val(data.udf3);
	$('#udf4').val(data.udf4);
	$('#udf5').val(data.udf5);
	//return false;
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
  function checkExamfees(){
	   $('#lateFee').hide(); 
	   $(".Paymenttype").hide();
   var Payment_type= $("#Payment_type").val();
   var ftype = $("#productinfo").val();
   var year = $("#udf2").val();
   var stud_id = $("#stud_id").val();
    var admission_session = $("#admission_session").val();
	var examsession=$("#examsession").val();
   $.ajax({
   'url' : base_url + 'Online_fee/fetch_feedet',
   'type' : 'POST', //the way you want to send data to your URL
   'data' : {'ftype' : ftype,'year' : year,'stud_id':stud_id,'Payment_type':Payment_type,'admission_session':admission_session,'examsession':examsession},
   'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
   var container = $('#feepend'); //jquery selector (get element by id)
   if(data){
     // alert(data);
   //alert("Marks should be less than maximum marks");
   //$("#"+type).val('');
   container.html(data);
   }
   
    $(".nextBtn ").prop('disabled', false);
   if(ftype=='Examination'){
	   $("#amount").val(data);
	     $('#amount').attr('readonly', true); 
   }else if(ftype=='Revaluation'){
	   $("#amount").val(data);
	   $('#amount').attr('readonly', true); 
   }else if(ftype=='Photocopy'){
	   $("#amount").val(data);
	   $('#amount').attr('readonly', false); 
	   
   }
   
   }
   
   });
  }
 ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
 
 $("#productinfo_ht").change(function(){
	// alert('Inside');
	 var values=$(this).val();
	 var academicc=$("#hidac_year_ht").val();
	  var stud_id = $("#stud_id_ht").val();
	   var prn_no = $("#prn_no_ht").val();
	  //alert(stud_id);
	 if(values!=''){
	 $.ajax({'url' : base_url + 'Online_transport_fee/productinfo_ht',
   'type' : 'POST', //the way you want to send data to your URL
   'data' : {'values' : values, 'academicc' : academicc,'stud_id':stud_id,'prn_no':prn_no},
   'success' : function(data){	//alert(data);
	 // if(data)
	  {
		  var array=JSON.parse(data);
		//if(data.std_details.admission_cycle==null){
		//	alert(array.check_last);
		if(array.check_last!=null){
		$(".Deposite").show();
		$("#Deposite_ht").val(array.check_current.deposit_fees);
		}else{
		$(".Deposite").hide();
		$("#Deposite_ht").val(0);
		//$(".Opeing").show();
		//$("#opeing_balnace_ht").val(array.check_current.opening_balance);
		}
			//alert(array.check_current.stud_id);
			
	   $("#fc_id_ht").val(array.check_current.sffm_id);
	   $("#amount_ht").val(array.check_current.actual_fees);
	   $("#opeing_balnace_ht").val(0);//array.check_current.opening_balance
	   if(array.check_current.sffm_id==2){
	   $(".rout").show();//array.check_current.opening_balance
	   $(".rout_FROM").html(array.check_current.route_name);//array.check_current.opening_balance
	   $(".rout_To").html(array.check_current.boarding_point);//array.check_current.opening_balance
	   }else{
		   $(".rout").hide();//array.check_current.opening_balance
	   $(".rout_FROM").html('');//array.check_current.opening_balance
	   $(".rout_To").html('');//array.check_current.opening_balance
	   }
	   
	   $('#amount_ht').attr('readonly', true); 
	   }
	   
   }
	})
	 }else{
		 alert("Please Select Type");
		  $("#fc_id_ht").val(0);
	      $("#amount_ht").val(0);
		  $("#opeing_balnace_ht").val(0);
		  $("#Deposite_ht").val(0);
		 return false;
	 }
	 
});
 
 
 
 
 
 
 
 
 
  function  donept(){ //$(".loader").hide();
  var payuForm_ht = document.forms.payuForm_ht;
   payuForm_ht.submit();
 //$('#payuForm').trigger('submit');

   }
  function submitPayutransport() {
	   var amount = $("#amount_ht").val();
	 //alert(amount);
     /*if(hash == '') {
       return false;
     }*/
	 if((amount==0)||(amount=='')){
		  alert("please Enter Amount");
		 return false;
		 
	 }
	
	// $(".loader").show();
	var stud_id_ht=$("#stud_id_ht").val();
	 var txtid=$("#txtid_ht").val();
	 var email=$("#email_ht").val();
	 var firstname=$("#firstname_ht").val();
	 var productinfo=$("#productinfo_ht").val();
	 var amount=$("#amount_ht").val();
	 var udf3=$("#udf3_ht").val();
	 var udf4=$("#udf4_ht").val();
	var fdata=$('#payuForm_ht').serialize();
	//alert(data);
	$('.loader').show();
	 $.ajax({
   'url' : base_url + 'Online_transport_fee/savestudent_data',
   'type' : 'POST', //the way you want to send data to your URL
   'data' : $('#payuForm_ht').serialize(),
   'dataType': "json",
   'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
   //var container = $('#feepend'); //jquery selector (get element by id)
   if(data!==''){
 // alert(data.amount);
 
    $('#txnid_ht').val(data.txnid);
	$('#hash_ht').val(data.hash);
	
	
	$('#udf1_ht').val(data.student_id);
	$('#udf2_ht').val(data.transaction_db_id);
	//$('#udf3_ht').val(data.udf3);
	$('#udf4_ht').val(data.vat);
	$('#udf5_ht').val(data.adhar_card_no);
	
	$('#amount_ht').attr('readonly', false); 
	$('#amount_ht').val(data.amount);
	$('#amount_ht').attr('readonly', true); 
	if(stud_id_ht==0){}else
	{
    setTimeout(function(){ donept() }, 2000);
	}
//alert();
   //var payuForm = document.forms.payuForm;
   //payuForm.submit();
   }
   }
   });
	 
	 
	  return false;
	 
    
   }
 /////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
 
 $("#udf6_hh").change(function(){
	 
	   var values=$(this).val();
	   //alert(values * 600);
	  // 600* values
	   $('#amount_hh').val(values * 600);
	  // $('#amount_hh').attr('readonly', true); 
  });
  
  
  function  dongym(){ //$(".loader").hide();
  var payuForm_hh = document.forms.payuForm_hh;
   payuForm_hh.submit();
 //$('#payuForm').trigger('submit');

   }
  function submitPayugym() {
	   var amount = $("#amount_hh").val();
	 //alert(amount);
     /*if(hash == '') {
       return false;
     }*/
	 if((amount==0)||(amount=='')){
		  alert("please Enter Amount");
		 return false;
		 
	 }
	
	 $(".loader").show();
	/* var txtid=$("#txtid").val();
	 var email=$("#email").val();
	 var firstname=$("#firstname").val();
	 var productinfo=$("#productinfo").val();
	 var amount=$("#amount").val();
	 var udf3=$("#udf3").val();
	 var udf4=$("#udf4").val();*/
	var fdata=$('#payuForm_hh').serialize();
	//alert(data);
	$('.loader').show();
	 $.ajax({
   'url' : base_url + 'Online_fee/Online_fee_entery_gym',
   'type' : 'POST', //the way you want to send data to your URL
   'data' : $('#payuForm_hh').serialize(),
   'dataType': "json",
   'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
   //var container = $('#feepend'); //jquery selector (get element by id)
   if(data!==''){
 // alert(data.amount);
 
    $('#txnid_hh').val(data.txnid);
	$('#hash_hh').val(data.hash);
	$('#amount_hh').val(data.amount);
	
	$('#udf1_hh').val(data.udf1);
	$('#udf3_hh').val(data.udf3);
	$('#udf4_hh').val(data.udf4);
	$('#udf5_hh').val(data.udf5);
	if(productinfo=='Hostel_Gym_new'){
	 $('#amount_hh').attr('readonly', true); 
	}else{
	$('#amount_hh').attr('readonly', false); 
	}
	
	 setTimeout(function(){ dongym() }, 2000);
//alert();
   //var payuForm = document.forms.payuForm;
   //payuForm.submit();
   }
   }
   });
	 
	 
	  return false;
	 
    
   }
   
   /////////////////////////////////////////////////////////////////
   
   function  donhp(){ //$(".loader").hide();
  var payuForm_hp = document.forms.payuForm_hp;
   payuForm_hp.submit();
 //$('#payuForm').trigger('submit');

   }
  function submitPayuhostelpending() {
	   var amount = $("#amount_hp").val();
	 //alert(amount);
     /*if(hash == '') {
       return false;
     }*/
	 if((amount==0)||(amount=='')){
		  alert("please Enter Amount");
		 return false;
		 
	 }
	
	 $(".loader").show();
	/* var txtid=$("#txtid").val();
	 var email=$("#email").val();
	 var firstname=$("#firstname").val();
	 var productinfo=$("#productinfo").val();
	 var amount=$("#amount").val();
	 var udf3=$("#udf3").val();
	 var udf4=$("#udf4").val();*/
	var fdata=$('#payuForm_hp').serialize();
	//alert(data);
	$('.loader').show();
	 $.ajax({
   'url' : base_url + 'Online_fee/Online_fee_entery_hostel_pending',
   'type' : 'POST', //the way you want to send data to your URL
   'data' : $('#payuForm_hp').serialize(),
   'dataType': "json",
   'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
   //var container = $('#feepend'); //jquery selector (get element by id)
   if(data!==''){
 // alert(data.amount);
 
    $('#txnid_hp').val(data.txnid);
	$('#hash_hp').val(data.hash);
	$('#amount_hp').val(data.amount);
	
	$('#udf1_hp').val(data.udf1);
	$('#udf3_hp').val(data.udf3);
	$('#udf4_hp').val(data.udf4);
	$('#udf5_hp').val(data.udf5);
	if(productinfo=='Hostel_Pending_fees'){
	 $('#amount_hp').attr('readonly', true); 
	}else{
	$('#amount_hp').attr('readonly', false); 
	}
	
	 setTimeout(function(){ donhp() }, 2000);

//alert();
   //var payuForm = document.forms.payuForm;
   //payuForm.submit();
   
   }
   }
   });
	 
	 
	  return false;
	 
    
   }
   function  doncm(){ //$(".loader").hide();
  var payuForm_hp = document.forms.payuForm_cm;
   payuForm_hp.submit();
 //$('#payuForm').trigger('submit');

   }  
   function submitPayucausion() {
	   var amount = $("#amount_cm").val();
	 //alert(amount);
     /*if(hash == '') {
       return false;
     }*/
	 if((amount==0)||(amount=='')){
		  alert("please Enter Amount");
		 return false;
		 
	 }
	
	 $(".loader").show();
	/* var txtid=$("#txtid").val();
	 var email=$("#email").val();
	 var firstname=$("#firstname").val();
	 var productinfo=$("#productinfo").val();
	 var amount=$("#amount").val();
	 var udf3=$("#udf3").val();
	 var udf4=$("#udf4").val();*/
	var fdata=$('#payuForm_cm').serialize();
	//alert(data);
	$('.loader').show();
	 $.ajax({
   'url' : base_url + 'Online_fee/submitPayucausion',
   'type' : 'POST', //the way you want to send data to your URL
   'data' : $('#payuForm_cm').serialize(),
   'dataType': "json",
   'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
   //var container = $('#feepend'); //jquery selector (get element by id)
   if(data!==''){
 // alert(data.amount);
 
    $('#txnid_cm').val(data.txnid);
	$('#hash_cm').val(data.hash);
	$('#amount_cm').val(data.amount);
	
	$('#udf1_cm').val(data.udf1);
	$('#udf3_cm').val(data.udf3);
	$('#udf4_cm').val(data.udf4);
	$('#udf5_cm').val(data.udf5);
	if(productinfo=='causion_money'){
	 $('#amount_mc').attr('readonly', true); 
	}else{
	$('#amount_mc').attr('readonly', false); 
	}
	
	 setTimeout(function(){ doncm() }, 2000);

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
   var admission_session = $("#admission_session").val();
   $.ajax({
   'url' : base_url + 'Online_fee/fetch_feedet',
   'type' : 'POST', //the way you want to send data to your URL
   'data' : {'ftype' : ftype,'year' : year,'admission_session':admission_session},
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