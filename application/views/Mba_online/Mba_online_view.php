<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<link href="<?php //echo base_url('assets/bootstrap/css/bootstrap.min.css')?>" rel="stylesheet">
    <!--<link href="<?php echo base_url('assets/datatables/css/dataTables.bootstrap.min.css')?>" rel="stylesheet">-->
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
<style>
#overlay{	
	position: fixed;
	top: 0;
	z-index: 100;
	width: 100%;
	height:100%;
	display: none;
	background: rgba(0,0,0,0.6);
}
.cv-spinner {
	height: 100%;
	display: flex;
	justify-content: center;
	align-items: center;  
}
.spinner {
	width: 40px;
	height: 40px;
	border: 4px #ddd solid;
	border-top: 4px #2e93e6 solid;
	border-radius: 50%;
	animation: sp-anime 0.8s infinite linear;
}
@keyframes sp-anime {
	100% { 
		transform: rotate(360deg); 
	}
}
.is-hide{
	display:none;
}
</style>
<?php
$role_id =$this->session->userdata('role_id');
 ?>
<script>  
var table;  
function History(){
//var history=history.back();

//window.location=history.back();
window.location="https://sandipuniversity.com/erp_sijoul/Enquiry/Enquiry_list";
}

function Close(){
	$('#Bonafide')[0].reset();
	$("#msg_show").html("");
	$('#show_form').hide(1000);
	$('#Bonafide')[0].reset();
}


  
      
</script>
<?php
   $astrik='<sup class="redasterik" style="color:red">*</sup>';
   ?>
   <div id="overlay">
	<div class="cv-spinner">
		<span class="spinner"></span>
	</div>
</div>
<div id="content-wrapper">
   <ul class="breadcrumb breadcrumb-page">
      <div class="breadcrumb-label text-light-gray">You are here: </div>
      <li><a href="#">Masters</a></li>
      <li class="active"><a href="#">SUJEE MBA </a></li>
   </ul> <input type='hidden' id='cyear' value='<?php echo $cyear; ?>'>
         <input type='hidden' id='date' value='<?php if (isset($date) && $date !=''){
			 echo $date; 
		 } ?>'>
		 <input type='hidden' id='type_param' value='<?php if (isset($type_param) && $type_param !=''){
			 echo $type_param; 
		 } ?>'>
   <div class="page-header">
      <div class="row">
         <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;SUJEE MBA/LAW/FASHION</h1>
         <div id="" align="right"><!--<a href="#" class="add_new"  id="add_new"><h4>Add New</h4></a>--></div>
         <div class="col-xs-12 col-sm-8">
            <div class="row">
               <hr class="visible-xs no-grid-gutter-h">
            </div>
         </div>
      </div>
      <div class="row ">
	  
	    <div class="col-sm-12">
                <div class="panel">
                <div class="panel-heading panel-info">
         <div class="form-group">
		 
		 <?php  $uid=$this->session->userdata('uid');
		 
		?>
			 
			 
			 
		 <label class="col-sm-2">Select academic year<sup class="redasterik" style="color:red">*</sup>:</label>
						<div class="col-sm-3">
                        <select class="form-control" name="academic_year" id="academic_year" required>
						<option value="">Select academic</option>						
						<option  value="2023-24" >2023-24</option>

						
						<option  value="2024-25">2024-25</option>
						<option  value="2025-26">2025-26</option>
						<option  value="2026-27" selected>2026-27</option>
						
											
						</select>      
                        </div>
                        <label class="col-sm-2">Select Exams<sup class="redasterik" style="color:red">*</sup>:</label>
						<div class="col-sm-3">
                        <select class="form-control" name="exam" id="exam" required>
						<option value="">Select Exams</option>						
						<option  value="12" selected>MBA</option>

						
						<option  value="3">LAW</option>
						<option  value="5">FASHION</option>  
											
						</select>      
                        </div>
						<div class="col-sm-1">
						<input class="btn btn-primary btn-labeled" onclick="submit_form()"  name="search" type="button" value="Search">
						</div>
      </div> </div>
      </div> </div>
      </div>
      <div class="row" id="show_form" style="display:none;">
         <div class="col-sm-12">
            <div id="dashboard-recent" class="panel panel-warning">
               <div class="tab-content">
                  <span style="color:red; padding-left:110px;"><?php echo $this->session->flashdata('message1'); ?></span>
                  
                  </div>
               </div>
            </div>
         </div>
         <br />
<div id="msg_show" style="color:#0C3"></div>
<br />
         <div class="table-info panel-body table-responsive" style="overflow:auto;"> 
         
         <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Date</th>
                    <th>Name</th>
                    <th>mobile</th>
                    <th>Email</th>
					<th>Exam</th>
					<th>Reg No</th>
					<th>Password</th>
					<th>Status</th>
					<th>Lead ownwer(ICname)</th>
					<th>Registration ownwer(ICname)</th>
					<th>Exam Status</th>
					<th>Phase</th>
					<th>Payment Status</th>
					<th>Qualification</th>
					<th>Category</th>
					<th>Percentage</th>
					<th>Education Status</th>
					<th>Resume</th>
                    <!--th>Amount</th>
                    <th>status</th> 
                  <th>Action</th--> 
                    
                </tr>
            </thead>
            <tbody>
            </tbody>

            <!--<tfoot>
                <tr>
                    <th>No</th>
                    <th>Enquiry&nbsp;No</th>
                      <th>provisional&nbsp;no</th>
                    <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                    <th>mobile</th>
                    <th>Alternate&nbsp;mobile</th>
                    <!--<th>Email</th>
                    <th>Interset&nbsp;Stream</th>
                    <th>Form&nbsp;Taken</th>
                   
                    <th>Scholarship&nbsp;allowed</th>
                    <th>Scholarship&nbsp;status</th>
                    
                </tr>
            </tfoot>-->
        </table>
      </div>
   </div>
</div>
<br />
<!--<div id="msg_del" style="color:#0C3"></div>-->
<br />
<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Update Status </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="modal_daa"><div>
     <div class="form-group">
     <label class="col-sm-1">&nbsp;Update Status&nbsp;</label><input type="radio" name="Updates" id="Updates" value="Status" checked="checked" /><label class="col-sm-1">&nbsp;Update Acknowledgement No&nbsp;</label><input type="radio" name="Updates" id="Updates" value="Acknowledgement" />
     </div>
     <div class="form-group">
      <label class="col-sm-1">&nbsp;Status&nbsp;</label>
                                 <div class="col-sm-4">
                                    <select name="status_m" id="status_m" class="form-control"  required="required">
                                       <option value="" >Select Type</option>
                                       <option value="Y">Confirmed</option>
                                       <option value="N">Pending</option>
                                    </select>
                                 </div>
                                 <label class="col-sm-1" >&nbsp;Date&nbsp;</label>
                                 <div class="col-sm-4"><input type="text" id="Date_f" name="Date_f" class="form-control" placeholder="Date" /></div>
                                 </div><div class="form-group">
                                  <label class="col-sm-2">&nbsp;Remark&nbsp;</label>
                                 <div class="col-sm-5"><textarea name="Remark" id="Remark"></textarea></div>
                                 
                              </div>
                              </div>
                              
                              
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="save_status">Save changes</button>
      </div>
    </div>
  </div>
</div>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.18/pdfmake.min.js"></script>

<script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.bootstrap.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.html5.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.print.js"></script>

<script>

function OpenDialouge(m){
	//alert(m);
	$.ajax({
                   type: 'POST',
                   url: '<?= base_url() ?>Bonafide/fetch_Bonafide',
                   data: {'bcd_id' : m},
                   success: function (resp) {
					   
					 //  modal_daa
					   $("#modal_daa").html(resp);
					   
   					/*var obj = jQuery.parseJSON(resp);  
   					$("#actual_fee").val(parseInt(obj[0].total_fees));
   					$("#without_scholarship").val(parseInt(25/100 * obj[0].tution_fees));
   					$("#tution_fees").val(parseInt(obj[0].tution_fees));*/
   					
                      
                   }
               });
	
}
function OpenDialougeedit(m){
	//alert(m);
	$('#show_form').show(1000);
	$.ajax({
                   type: 'POST',
                   url: '<?= base_url() ?>Bonafide/OpenDialougeedit',
                   data: {'bcd_id' : m},
                   success: function (resp) {
					   
					 //  modal_daa
					   $("#show_form").html(resp);
					   
   					/*var obj = jQuery.parseJSON(resp);  
   					$("#actual_fee").val(parseInt(obj[0].total_fees));
   					$("#without_scholarship").val(parseInt(25/100 * obj[0].tution_fees));
   					$("#tution_fees").val(parseInt(obj[0].tution_fees));*/
   					
                      
                   }
               });
	
}

function OpenDialougedeleted(m){
	//alert(m);
	var x = confirm("Are you sure you want to delete?");
  if (x){
	$.ajax({
                   type: 'POST',
                   url: '<?= base_url() ?>Bonafide/OpenDialougedeleted',
                   data: {'bcd_id' : m},
                   success: function (resp) {
					   
					 //  modal_daa
					   $("#msg_show").html("Deleted Successfully");
					    table.ajax.reload();
   					/*var obj = jQuery.parseJSON(resp);  
   					$("#actual_fee").val(parseInt(obj[0].total_fees));
   					$("#without_scholarship").val(parseInt(25/100 * obj[0].tution_fees));
   					$("#tution_fees").val(parseInt(obj[0].tution_fees));*/
   					
                      
                   }
               });
  }else{
      return false;

  }
	
}


function submit_form(){
	var exam=$("#exam").val();
	var academic_year=$("#academic_year").val();
	table.ajax.reload();  
}

$(document).ready(function() {
	 $('#add_new').click(function(){ //button filter event click
       // table.ajax.reload();  //just reload table
	   $('#show_form').show();
	   var m='';
	   $.ajax({
                   type: 'POST',
                   url: '<?= base_url() ?>Bonafide/OpenDialougeedit',
                   data: {'bcd_id' : m},
                   success: function (resp) {
					   
					 //  modal_daa
					   $("#show_form").html(resp);
					   
   					/*var obj = jQuery.parseJSON(resp);  
   					$("#actual_fee").val(parseInt(obj[0].total_fees));
   					$("#without_scholarship").val(parseInt(25/100 * obj[0].tution_fees));
   					$("#tution_fees").val(parseInt(obj[0].tution_fees));*/
   					
                      
                   }
               });
	 //  $('#show_form').fadeOut( "slow" );
	   
    });
	
	
	
	if($('#date').val() !='' && $('#date').val() !=0 ){
					$("#title_id").html("Today's ");
				}
				
				if($('#type_param').val() !=''){
					if($('#type_param').val()==1){
					//$("#title_id").append("Form Collected Report");
					}
					else if($('#type_param').val()==2){
				//	$("#title_id").append("Provisional Admission Report");	
					}
					
				}
				else{
					//$("#title_id").append("Enquiry Report");	
					}
	 //datatables
    table = $('#table').DataTable({ 
//resetPaging: false,
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
		"sScrollX": "100%",
        "sScrollXInner": "110%",
        "bScrollCollapse": true,
        "order": [], //Initial no order.
        "pageLength": 20,
	    "lengthMenu": [['',50,100,500,1000,1500,2000,2500,3000, -1], ['',50,100,500,1000,1500,2000,2500,3000, "All"] ],
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('Mba_online/ajax_list')?>",
            "type": "POST",
            "data": function ( data ) {
				
				//alert($('#academic_year').val());
				 data.date = $('#date').val();
				 data.type_param = $('#type_param').val();
				 data.cyear = $('#academic_year').val();
				 data.exam = $('#exam').val();
                /*data.country = $('#country').val();
                data.FirstName = $('#FirstName').val();
                data.LastName = $('#LastName').val();
                data.address = $('#address').val();*/
            }
        },
		

        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [ 0 ], //first column / numbering column
            "orderable": false, //set not orderable
        },
        ],
		language: {
        search: "_INPUT_",
        searchPlaceholder: "Search..."
    },
	  dom: 'lBfrtip',
    // "bPaginate": false,
     bSort: false,
        buttons: ['excelHtml5']

    });

    $('#btn-filter').click(function(){ //button filter event click
        table.ajax.reload();  //just reload table
    });
    $('#btn-reset').click(function(){ //button reset event click
        $('#form-filter')[0].reset();
        table.ajax.reload();  //just reload table
    });
	
	 $("#save_status").on('click', function () {
		   var bcd_id=$('#bcd_id').val();
		    var status_m=$('#status_m').val();
			 var Date_f=$('#Date_f').val();
			 var Remark=$('#Remark').val();
			 var acknowledgement_no=$('#acknowledgement_no').val();
		  // window.location='<?= base_url() ?>Bonafide/Enquiry_list/'+value+'/';
		   
		   $.ajax({
                   type: 'POST',
                   url: '<?= base_url() ?>Bonafide/save_status',
                   data: {'bcd_id' : bcd_id,'status_m':status_m,'Date_f':Date_f,'Remark':Remark,'acknowledgement_no':acknowledgement_no},
                   success: function (resp) {
					$("#msg_save").html("Updated Done");   
					 table.ajax.reload();
   					//var obj = jQuery.parseJSON(resp);  
   					//$("#actual_fee").val(parseInt(obj[0].total_fees));
   					//$("#without_scholarship").val(parseInt(25/100 * obj[0].tution_fees));
   					//$("#tution_fees").val(parseInt(obj[0].tution_fees));
   					
                      
                   }
               });
		   
		   
		   
		   
		   });
	
	
	
	
});
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
   
   
   /*function submitForm(){
	   
	   
   }*/
   
   
      $(function(){
		  
		  
     var enquiryparamer='<?php echo $enquiryparamer; ?>';
	 var mobilnparamer='<?php echo $mobilnparamer; ?>';
	
	 if((enquiryparamer!='')||(mobilnparamer!='')){
	 $("#btnsearch").trigger('click');
	 }
	 
	 var frm = $('#Bonafide');

    frm.submit(function (e) {

        e.preventDefault();
		$("#msg_show").html("");
       $("#overlay").show();
        $.ajax({
            type: frm.attr('method'),
            url: frm.attr('action'),
            data: frm.serialize(),
            success: function (data) {
				if(data!=''){
                console.log('Submission was successful.');
				$("#msg_show").html("Added Successfully");
                console.log(data);
				$("#overlay").hide();
				table.ajax.reload();
				$('#show_form').hide(1000);
				$('#Bonafide')[0].reset();
				}else{
					console.log('Submission was Fail.');
					$("#msg_show").html("Submission was Fail");
					$("#overlay").hide();
					table.ajax.reload();
					$('#show_form').hide(1000);
					$('#Bonafide')[0].reset();
				}
            },
            error: function (data) {
                console.log('An error occurred.');
                console.log(data);
				$("#msg_show").html("Submission was Fail");
				$("#overlay").hide();
            },
        });
    });
	
	
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
   
   
   $("#Bonafide_date").datepicker({
     todayBtn:  1,       
        autoclose: true,
    format: 'yyyy-mm-dd'/*,
     startDate: new Date() */
    })/*.on('changeDate', function (selected) {
        var minDate = new Date(selected.date.valueOf());
  //  $('#dob-datepicker3').datepicker('setStartDate');
	$('#dob-datepicker3').datepicker('setStartDate', minDate);
  var depid = $('#reporting_dept_od').val();
      getEmp_using_deptforod(depid);
  getTotalDays1();
    });*/
   
    $("#Date_f").datepicker({
     todayBtn:  1,       
        autoclose: true,
    format: 'yyyy-mm-dd'/*,
     startDate: new Date() */
    })
   
   
    
   
   
   
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
	   
	   $('.btn_submit').click(function(){
   alert();
   var formData = new FormData($('#Bonafide')[0]);
   
  /* $.ajax({
'url' : 'https://www.sandipuniversity.com/erp_sijoul/Bonafide/insert_data',
'type' : 'POST',
'processData': false,
'contentType': false ,  //the way you want to send data to your URL
'data' : formData,
'dataType': "json",
'success' : function(data){ 


}
   });*/
   
   
   
   
	});
	   
	   
	   
	   
   	  
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