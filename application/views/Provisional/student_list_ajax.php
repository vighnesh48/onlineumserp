<link href="<?php //echo base_url('assets/bootstrap/css/bootstrap.min.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/datatables/css/dataTables.bootstrap.min.css')?>" rel="stylesheet">
<?php //echo  "<pre>"; print_r($unittest); die;
$role_id = $this->session->userdata('role_id'); //var_dump($_SESSION);
?>

<div id="content-wrapper">
/* <input type='hidden' id='date' value='<?php if (isset($date) && $date !=''){
			 echo $date; 
		 } ?>'>*/
		 <input type='hidden' id='type_param' value='<?php if (isset($type_param) && $type_param !=''){
			 echo $type_param; 
		 } ?>'>
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#"></a></li>
        <li class="active"><a href="#"></a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Provisional Admissions</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
          
                    <div class="visible-xs clearfix form-group-margin"></div>
                   <div class="col-sm-6">
                           <div class="col-sm-3">Select&nbsp;Year</div>
                           <div class="col-sm-6"><select name="year" id="year" class="form-control" onchange="order_status_change(this)">
                            <option value="">Select Yeatr</option>
							<!--option value="2020" >2020-21</option>
                            <option value="2021">2021-22</option>
                            <option value="2022" >2022-23</option>
							<option value="2023" >2023-24</option-->
							<option value="2025" selected="selected">2025-26</option>
							</select></div>
                            </div>
                    
                </div>
                
            </div>
        </div>
        <div class="row ">
            <div class="col-sm-12">&nbsp;</div>
        </div>
        
        
        <div class="row ">
            <div class="col-sm-6">
  <strong> <span id="flash-messages" style="color:Green;padding-left:50px;">
						 <?php if(!empty($this->session->flashdata('message1'))){ echo $this->session->flashdata('message1'); } ?></span></strong>
        
        </div>
        </div>
   
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                    
                <div class="panel-heading">
                <div class="row ">
                             <div class="col-sm-3">Total Provisional Admissions(<?php echo ADMISSION_SESSION; ?>):<b> <?php
                             
						if(!empty($stud_data)){							
                            echo count($stud_data);
						}  
                            ?></b></div><div class="col-sm-6">Total&nbsp;Confirm&nbsp;Admissions + International&nbsp;Admissions(<?php echo ADMISSION_SESSION; ?>):<b> <?php
                             
						if(!empty($stud_data_confirm)){							
                            echo count($stud_data_confirm);
						} else{echo 0;} 
                            ?></b></div>
                            
                            </div>
                            <div class="row ">&nbsp;&nbsp;</div>
                            
                            <div class="row ">
                            <div>
                           <div class="col-sm-2">Document&nbsp;status</div>
                           <div class="col-sm-2"><select name="order_status" id="order_status" class="form-control" onchange="order_status_change(this)">
                            <option value="">Select Status</option><option value="ALL" selected="selected">ALL</option><option value="Pending">Pending</option><option value="Confirm">Min Confirm</option><option value="Verified">Verified</option></select></div>
                            </div><div>
                           <div class="col-sm-2">Admission&nbsp;status</div>
                           <div class="col-sm-2"><select name="Admission_status" id="Admission_status" class="form-control" onchange="Admission_status_change(this)">
                            <option value="">Select Status</option><option value="ALL" selected="selected">ALL</option><option value="Pending">Pending</option><option value="Confirm">Confirm</option></select></div>
                            </div><div class="col-sm-2"> &nbsp;</div> 
                            <div class="col-sm-2"><b><a href="<?php echo base_url();?>Provisional_admission/confirm_admissions" target="_blank"><button name="">Confirm List</button></a></b></div>                        
                                
                       	  
                             
                     </div>
                     <div class="row ">
                             
   <!-- <form method="post">

				<div class="col-sm-3">
					<input type="text" name="doa" id="doa" class="form-control" placeholder="Date Of Admission"  value=""/>                                                                            
				</div>
				
			<div class="col-sm-3">
				    <select id="reftype" name="reftype" class="form-control" >
				      <option value="">Select Reference Type</option> 
				 <?php 
							foreach($refer_det as $refer_det){ 
							
								?>
								<option value="<?php echo $refer_det['admission_refer_by']; ?>" ><?php echo $refer_det['admission_refer_by']; ?></option>
								<?php } ?>      
				             </select>                                                            
				</div>
				
	
			<div class="col-sm-1"><input type="button" value="Search" class="btn btn-primary" id="btnsearch"></div>	&nbsp;&nbsp;&nbsp;
			
				<div class="col-sm-1" style="margin-left: 10px;"><input type="Submit" value="Excel" class="btn btn-primary" id=""></div>		

</form>    -->                           
                                
                       	<!--<div class="col-sm-2" style="margin-left: 10px;"> 	<input type="button" id="expdata" value="Export as Excel" class="btn btn-primary btn-labeled">
                       	
                      
                             </div>-->  
                            <!--<div class="col-sm-3">  
                             <input id="system-search" name="q" placeholder="Search for" required class="form-control pull-right">
                            </div>--> 
                     </div> 
                </div>
</div>
</div>
</div> 



        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                <div class="panel-body">
                    
                   
                    <div class="table-info">    
                  
                  <table id="table" class="table table-striped table-bordered display nowrap" cellspacing="0" width="100%">
            <thead> 
                <tr>
                    <th>No</th>
                    <th>Prn&nbsp;No</th>
                    <th>Unifrom&nbsp;Status</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th>Aadhar No</th>
                  <th>School&nbsp;name</th>
                    <th>Stream&nbsp;name</th>
                    <th>year&nbsp;</th>
                    <th>Nationality</th>
					 <th>State</th>
					 <th>District</th>
                   <th>City</th>
                    <th>Min Doc Status</th>
                    <th>Final Doc Status</th>
                    <th>Admission Status</th>
                    
                    <!--<th>Date of Admission</th>-->
                   <!-- <th>Action</th>-->
                </tr>
            </thead>
            <tbody>
            </tbody>

           
        </table>
                  
                </div>
                </div>
            </div>
            </div>    
        </div>
    </div>
</div>
<!--<script src="<?php // echo base_url('assets/jquery/jquery-2.2.3.min.js')?>"></script>
<script src="<?php //echo base_url('assets/bootstrap/js/bootstrap.min.js')?>"></script>-->
<script src="<?php echo base_url('assets/datatables/js/jquery.dataTables.min.js')?>"></script>
<script src="<?php echo base_url('assets/datatables/js/dataTables.bootstrap.min.js')?>"></script>

<div class="modal fade" id="walkinModal" tabindex="-1" role="dialog" 
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                
                <h4 class="modal-title" id="myModalLabel">
                   <span id="fform_id">Cancel Admission</span>
                </h4>
            </div>
            


  <div class="modal-body">
                <div class="row">
                            <div class="col-sm-12">
                                <div class="panel panel-default panel-hovered panel-stacked" style="margin-top: 10px;">
                                    <div class="panel-body">
                                        <form name="editfrm" method="POST" action="<?=base_url()?>provisional_admission/cancel_admission" enctype="multipart/form-data" onsubmit="return confirm('Do you really want to cancel the admission?');">
                                 
                                        <div class="form-group">
                                          
                           
                                                Student Name : <label name="stud_name" id="stud_name"></label><br>
                                                Reg. No : <label name="reg_no" id="reg_no"></label> <br>
                                                 Course : <label name="course_name" id="course_name"></label> 
                                                
                                                <input type="hidden" name="fstud_id" class="form-control" id="fstud_id" style="width:50%"/>
                                                 <input type="hidden" name="freg_no" class="form-control" id="freg_no" style="width:50%"/>
                                                 
    									    

                                           
                                        </div>  
                                

								   <div class="form-group">
                                            <label class="col-sm-4" for="exampleInputEmail1">Cancellation Fees</label>
                                             <div class="col-sm-5">
                                            <input type="text" name="canc_fees" class="form-control numbersOnly" id="canc_fees" style="" required/>
                                             
                                                 </select>
                                            
                                            </div>
                                        </div>
								   <div class="form-group">
                                            <label class="col-sm-4" for="exampleInputEmail1">Cancellation Date</label>
                                             <div class="col-sm-5">
                                            <input type="text" name="canc_date" class="form-control" id="canc_date" style="" required/>
                                             
                                                 </select>
                                            
                                            </div>
                                        </div>			
										
								   <div class="form-group">
                                            <label class="col-sm-4" for="exampleInputEmail1">Cancellation Remark</label>
                                             <div class="col-sm-5">
                                            <textarea type="text" name="canc_remark" class="form-control" id="canc_remark" style="" required/></textarea>
                                                 </select>
                                            
                                            </div>
                                        </div>
   
                                          <button type="submit" class="btn btn-primary" id="updatePayment1" >Cancel Admission</button>
                                          <button type="button" class="btn btn-default"
                                                data-dismiss="modal">
                                                    Close
                                        </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                
            </div>
            
             </div>
    </div>
</div>     <script type="text/javascript">







var table;

$(document).ready(function() {
	
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
        "pageLength": 100,
		"lengthMenu": [[100,200,300,500,1000,1500,2000,2500,5000, -1], [100,200,300,500,1000,1500,2000,2500,5000, "All"] ],
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('Provisional_admission/list_admissions_ajax')?>",
            "type": "POST",
            "data": function ( data ) {
				
				
				data.year = $('#year').val();
				 data.type_param = $('#type_param').val();
				 data.Document_status = 'ALL';
				 data.admission_status=$('#Admission_status').val();
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
        buttons: [
            
            'excelHtml5',
            
            'pdfHtml5'
        ]

    });

    $('#btn-filter').click(function(){ //button filter event click
        table.ajax.reload();  //just reload table
    });
    $('#btn-reset').click(function(){ //button reset event click
        $('#form-filter')[0].reset();
        table.ajax.reload();  //just reload table
    });
/////////////////////////////////////////////////////////////////////////////////////////////////////////	
	
	
	
	
////////////////////////////////////
});

function admissiom_chnage_old(m){
	//alert('inside11');
	var id = $(m).attr("lang");
	var url1  = '<?=base_url()?>Provisional_admission/check_uniform_payments';
	var data1 = {'org_frm':'SU','id':id};	
	$.ajax({
			type: "POST",
			url: url1,
			data: data1,
			dataType: "html",
			cache: false,
			crossDomain: true,
			success: function(dataa){
				//alert(dataa);
				if(dataa==0){
					alert("You can not confirm this admission as Uniform payment is pending.");
					return false;
				}
		
			},
			error: function(data){
				alert("Page Or Folder Not Created..!!");
			}
		});
	
		if(confirm("Are you sure you want to do this?")){
		var values = $(m).val();
		//alert(values);
		var docuemnt_confirm = $('#docuemnt_confirm').val();
		
	   if((docuemnt_confirm=="")||(docuemnt_confirm=="N")){
		   alert("Document Not Verify");
		   return false;}else{
		var url  = '<?=base_url()?>Provisional_admission/Update_admission';	
		var data = {'values':values,'docuemnt_confirm':docuemnt_confirm,'id':id};		
		$.ajax({
			type: "POST",
			url: url,
			data: data,
			dataType: "html",
			cache: false,
			crossDomain: true,
			success: function(data){
				
				//alert(data);
			table.ajax.reload(); 
			//	$('#block').html('');
			//	return false;
			},
			error: function(data){
				alert("Page Or Folder Not Created..!!");
			}
		});
	   }
		}else{
			table.ajax.reload();
			return false;
		}
	}

function admissiom_chnage(m,course_id) {
    var id = $(m).attr("lang");
    var url1 = '<?=base_url()?>Provisional_admission/check_uniform_payments';
    var data1 = {'org_frm': 'SU', 'id': id};

    $.ajax({
        type: "POST",
        url: url1,
        data: data1,
        dataType: "html",
        cache: false,
        crossDomain: true,
        success: function (dataa) {
			// If course is 3 or 19, treat dataa as "allowed"
			//alert(dataa);
			if (course_id == 3 || course_id == 19 || course_id == 10 || course_id == 18 || course_id == 39 || course_id == 35 || course_id == 12 || course_id == 22) {
				//alert(1111);
				dataa = 1; 
			}

			if (parseInt(dataa) === 0) {
				alert("You can not confirm this admission as Uniform payment is pending.");
				return false; // stop execution here
			}

            // ✅ Only comes here if payment is successful
            if (confirm("Are you sure you want to do this?")) {
                var values = $(m).val();
                var docuemnt_confirm = $('#docuemnt_confirm').val();

                if ((docuemnt_confirm == "") || (docuemnt_confirm == "N")) {
                    alert("Document Not Verify");
                    return false;
                } else {
                    var url = '<?=base_url()?>Provisional_admission/Update_admission';
                    var data = {'values': values, 'docuemnt_confirm': docuemnt_confirm, 'id': id};

                    $.ajax({
                        type: "POST",
                        url: url,
                        data: data,
                        dataType: "html",
                        cache: false,
                        crossDomain: true,
                        success: function (data) {
                            table.ajax.reload();
                        },
                        error: function () {
                            alert("Page Or Folder Not Created..!!");
                        }
                    });
                }
            } else {
                table.ajax.reload();
                return false;
            }
        },
        error: function () {
            alert("Page Or Folder Not Created..!!");
        }
    });
}

function order_status_change(m){
		/*if(confirm("Are you sure you want to do this?"))*/{
		var values = $(m).val();
		 //datatables
    table = $('#table').DataTable({ 
//resetPaging: false,
 "destroy": true,
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
		"sScrollX": "100%",
        "sScrollXInner": "110%",
        "bScrollCollapse": true,
        "order": [], //Initial no order.
        "pageLength": 100,
		"lengthMenu": [[100,200,300,500,1000,1500,2000,2500,5000, -1], [100,200,300,500,1000,1500,2000,2500,5000, "All"] ],
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('Provisional_admission/list_admissions_ajax')?>",
            "type": "POST",
            "data": function ( data ) {
				
				
				data.year = $('#year').val();
				data.type_param = $('#type_param').val();
				data.Document_status = values;
				data.admission_status=$('#Admission_status').val();
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
        buttons: [
            
            'excelHtml5',
            
            'pdfHtml5'
        ]

    });
	}
	
}
function Admission_status_change(m){
		/*if(confirm("Are you sure you want to do this?"))*/{
		var values = $(m).val();
		 //datatables
    table = $('#table').DataTable({ 
//resetPaging: false,
 "destroy": true,
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
		"sScrollX": "100%",
        "sScrollXInner": "110%",
        "bScrollCollapse": true,
        "order": [], //Initial no order.
        "pageLength": 100,
		"lengthMenu": [[100,200,300,500,1000,1500,2000,2500,5000, -1], [100,200,300,500,1000,1500,2000,2500,5000, "All"] ],
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('Provisional_admission/list_admissions_ajax')?>",
            "type": "POST",
            "data": function ( data ) {
				
				
				data.year = $('#year').val();
				data.type_param = $('#type_param').val();
				data.Document_status = $('#order_status').val();
				data.admission_status = values;
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
        buttons: [
            
            'excelHtml5',
            
            'pdfHtml5'
        ]

    });
	}
	
}
</script>

     


