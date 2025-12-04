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
      <li class="active"><a href="#">Collaboration Education</a></li>
   </ul> <input type='hidden' id='cyear' value='<?php echo $cyear; ?>'>
         <input type='hidden' id='date' value='<?php if (isset($date) && $date !=''){
			 echo $date; 
		 } ?>'>
		 <input type='hidden' id='type_param' value='<?php if (isset($type_param) && $type_param !=''){
			 echo $type_param; 
		 } ?>'>
   <div class="page-header">
      <div class="row">
         <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Collaboration Education</h1>
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
						<option  value="2025-26">2025-26</option>
						<option  value="2026-27" selected>2026-27</option>
						
											
						</select>      
                        </div>
                        <label class="col-sm-2">Select Events<sup class="redasterik" style="color:red">*</sup>:</label>
						<div class="col-sm-3">
                        <select class="form-control" name="form_type" id="form_type" required>
						<option value="">Select Events</option>
						<option  value="1">Educator Forum</option> 
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
                    <th>Academic Year</th>
                    <th>Full Name</th>
                    <th>Mobile No.</th>
                    <th>Email</th>
                    <th>Designation</th>
					<th>State</th>
					<th>City</th>
					<th>Institution Type</th>
					<th>Participation Category</th>
					<th>Institute Name</th>
					<th>Institution Address</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
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
function submit_form(){
	var form_type=$("#form_type").val();
	var academic_year=$("#academic_year").val();
	table.ajax.reload();  
}

$(document).ready(function() {
	
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
	    "lengthMenu": [[20,50,100,500,1000,1500,2000,2500,3000, -1], [20,50,100,500,1000,1500,2000,2500,3000, "All"] ],
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('Collaboration_edu/ajax_list')?>",
            "type": "POST",
            "data": function ( data ) {
				
				 data.cyear = $('#academic_year').val();
				 data.form_type = $('#form_type').val();
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
	
});
	

	
</script>