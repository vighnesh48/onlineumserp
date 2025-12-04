
    <link href="<?php //echo base_url('assets/bootstrap/css/bootstrap.min.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/datatables/css/dataTables.bootstrap.min.css')?>" rel="stylesheet">
  
  <div id="content-wrapper">
  <div class="row">
  
                         <div class="col-sm-5">   <h2 style="font-size:20pt">Enquiry List <span class="yer"><?=ADMISSION_SESSION; ?></span></h2></div>
                       </div>   <div class="row">
                       <div class="col-sm-2">
					   
					  <?php $getallAcademicYear= getallAcademicYear(); 
					  //print_r($getallAcademicYear);
					  
					  ?>
					   
					   <select name="year" id="year" class="form-control" onchange="order_status_change(this)">
                            <option value="">Select Year</option>
                           <?php foreach($getallAcademicYear as $row) {?>
                            <option value="<?=$row['session']; ?>" 
							<?php 
							 if($row['session']==ADMISSION_SESSION){
								 echo "selected";
							 }
							
							?>
							
							><?=$row['academic_year']; ?></option>
						   <?php } ?>

						<!--   <option value="2021" >2021-22</option>
                            <option value="2022" >2022-23</option>
							<option value="2023">2023-24</option>
							<option value="2024" selected >2024-25</option>-->
                            </select></div>  </div>
                            <br />
        
        <div style="color:#C66;"><?php if($this->session->flashdata('Msg')){ ?><?php echo $this->session->flashdata('Msg'); ?><?php } ?></div>
         <input type='hidden' id='date' value='<?php if (isset($date) && $date !=''){
			 echo $date; 
		 } ?>'>
		 <input type='hidden' id='type_param' value='<?php if (isset($type_param) && $type_param !=''){
			 echo $type_param; 
		 } ?>'>
         
         
        <h3 id="title_id"></h3>
        <span id="flash-messages" style="color:Green;padding-left:50px;">
						 <?php if(!empty($this->session->flashdata('message1'))){ echo $this->session->flashdata('message1'); } ?></span>
        <br>
        <div class="panel panel-default" style="display:none;">
            <div class="panel-heading">
                <h3 class="panel-title" >Custom Filter : </h3>
            </div>
            <div class="panel-body">
                <form id="form-filter" class="form-horizontal">
                    <div class="form-group">
                        <label for="country" class="col-sm-2 control-label">Country</label>
                        <div class="col-sm-4">
                            <?php echo $form_country; ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="FirstName" class="col-sm-2 control-label">First Name</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="FirstName">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="LastName" class="col-sm-2 control-label">Last Name</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="LastName">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="LastName" class="col-sm-2 control-label">Address</label>
                        <div class="col-sm-4">
                            <textarea class="form-control" id="address"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="LastName" class="col-sm-2 control-label"></label>
                        <div class="col-sm-4">
                            <button type="button" id="btn-filter" class="btn btn-primary">Filter</button>
                            <button type="button" id="btn-reset" class="btn btn-default">Reset</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
        <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Enquiry&nbsp;No</th>
                    <th>Form&nbsp;No</th>
                      <th>provisional&nbsp;no</th>
                    <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                    <th>mobile</th>
                  <!--  <th>Altarnet&nbsp;mobile</th>-->
                   <!-- <th>Email</th>-->
                   <th>School&nbsp;&nbsp;Name</th>
                   <th>Course&nbsp;&nbsp;Name</th>
                   <th>Stream&nbsp;&nbsp;Name</th>
                   <th>Year</th>
                    <!--<th>Form&nbsp;Taken</th>-->
                     
                    <!--<th>Scholarship&nbsp;allowed</th>-->
                    <th>Actual&nbsp;Fee</th>
                    <th>Scholarship</th>
                    <th>Scholarship&nbsp;Amount</th>
                    <th>Applicable&nbsp;Fee</th>
                    
                    <th>Action</th>
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

<!--<script src="<?php // echo base_url('assets/jquery/jquery-2.2.3.min.js')?>"></script>
<script src="<?php //echo base_url('assets/bootstrap/js/bootstrap.min.js')?>"></script>-->
<script src="<?php echo base_url('assets/datatables/js/jquery.dataTables.min.js')?>"></script>
<script src="<?php echo base_url('assets/datatables/js/dataTables.bootstrap.min.js')?>"></script>


<script type="text/javascript">

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
					var year=$('#year').val();
    //datatables
    table = $('#table').DataTable({ 
//resetPaging: false,
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
		"sScrollX": "100%",
        "sScrollXInner": "110%",
        "bScrollCollapse": true,
        "order": [], //Initial no order.
        "pageLength": 30,
	    "lengthMenu": [['',50,100,500,1000,1500,2000,2500,3000, -1], ['',50,100,500,1000,1500,2000,2500,3000, "All"] ],
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('Enquiry/ajax_list')?>",
            "type": "POST",
            "data": function ( data ) {
				
				
				data.date = $('#date').val();
				 data.type_param = year;//$('#type_param').val();
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

});

function order_status_change(m){
		/*if(confirm("Are you sure you want to do this?"))*/{
		var values = $(m).val();
	   // var	urk="https://sandipuniversity.com/newadmission_sijoul/Test/Transfer/"+values;
		//var a = document.getElementById('Transfer');
$(".yer").html(values);
		//a.href=urk
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
            "url": "<?php echo site_url('Enquiry/ajax_list')?>",
            "type": "POST",
            "data": function ( data ) {
				
				
				data.year = values;//$('#year').val();
				data.date = $('#date').val();
				data.type_param =values;// $('#type_param').val();
				//data.Document_status = values;
				//data.admission_status=$('#Admission_status').val();
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
