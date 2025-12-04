<link href="<?php //echo base_url('assets/bootstrap/css/bootstrap.min.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/datatables/css/dataTables.bootstrap.min.css')?>" rel="stylesheet">
<?php //echo  "<pre>"; print_r($unittest); die;
$role_id = $this->session->userdata('role_id'); //var_dump($_SESSION);
?>

<div id="content-wrapper">
 <input type='hidden' id='date' value='<?php if (isset($date) && $date !=''){
			 echo $date; 
		 } ?>'>
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
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;cancelled Admissions 2020-21</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
          
                    <div class="visible-xs clearfix form-group-margin"></div>
                   
                    
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-sm-12">&nbsp;</div>
        </div>
        
        
        <div class="row ">
            <div class="col-sm-12">
  <strong> <span id="flash-messages" style="color:Green;padding-left:50px;">
						 <?php if(!empty($this->session->flashdata('message1'))){ echo $this->session->flashdata('message1'); } ?></span></strong>
        
        </div>
        </div>
   
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                    
                <div class="panel-heading">
                
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
                    
                   
                    <div class="table-info table-responsive">    
                  
                  <table id="table" class="table table-striped table-bordered display nowrap" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Prn&nbsp;No</th>
                    <th width="10">Name</th>
                    <!--<th>Email</th>-->
                    <th>Mobile</th>
                <!--<th>School&nbsp;name</th>-->
                    <th width="10">Stream&nbsp;name</th>
                     <th width="10">Remark</th>
                   <th>Action</th>
                   
                   
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
            "url": "<?php echo site_url('ums_admission/cancelled_list_admissions_ajax')?>",
            "type": "POST",
            "data": function ( data ) {
				
				
				//  data.date = $('#date').val();
				// data.type_param = $('#type_param').val();
				// data.Document_status = 'ALL';
				// data.admission_status=$('#Admission_status').val();
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

function admissiom_chnage(m){
		if(confirm("Are you sure you want to do this?")){
		var values = $(m).val();
	//	alert(values);
		//var docuemnt_confirm = $('#docuemnt_confirm').val();
		var id = $(m).attr("lang");
	   if((values=="N")){
		  // alert("Document Not Verify");
		   return false;}else{
		var url  = '<?=base_url()?>ums_admission/admissiom_chnage';	
		var data = {'values':values,'id':id};		
		$.ajax({
			type: "POST",
			url: url,
			data: data,
			dataType: "html",
			cache: false,
			crossDomain: true,
			success: function(data){
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
            "url": "<?php echo site_url('ums_admission/cancelled_list_admissions_ajax')?>",
            "type": "POST",
            "data": function ( data ) {
				
				
			//	data.date = $('#date').val();
			//	data.type_param = $('#type_param').val();
			//	data.Document_status = values;
			//	data.admission_status=$('#Admission_status').val();
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
            "url": "<?php echo site_url('ums_admission/cancelled_list_admissions_ajax')?>",
            "type": "POST",
            "data": function ( data ) {
				
				
			//	data.date = $('#date').val();
			//	data.type_param = $('#type_param').val();
			//	data.Document_status = $('#order_status').val();
			//	data.admission_status = values;
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

     


