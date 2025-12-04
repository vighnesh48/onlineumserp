<style type="text/css">
  .dataTables_length , .dataTables_filter{
    display:inline-block !important;
    float:right !important;
  }
</style>
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
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Payment List</h1> 
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h"> 
                    <div class="visible-xs clearfix form-group-margin"></div>
                </div>
            </div>
        </div>           
        <div class="row ">
                  <div class="panel-heading">
                    <span class="panel-title">   
                    <div class="form-group">
<div>
                           <div class="col-sm-1">Type</div>
                           <div class="col-sm-2"><select name="Type_status" id="Type_status" class="form-control" onchange="Type_status_change(this)">
                           <option value="">Select Status</option><option value="ALL" selected="selected">ALL</option>
                           <?php foreach($product_info as $lists){ if(!empty($lists)){?>
                            <option value="<?php echo $lists->productinfo; ?>"><?php echo $lists->productinfo; ?></option>
                            <?php }} ?><option value="Both">Re-Registration-Late fee</option></select></div>
                            </div>
                            
                            <div>
                           <div class="col-sm-1">Verify&nbsp;status</div>
                           <div class="col-sm-2"><select name="Verify_status" id="Verify_status" class="form-control" onchange="Verify_status_change(this)">
                            <option value="">Select Status</option><option value="ALL">ALL</option>
                            <option value="Pending" selected="selected">Pending</option>
                            <option value="Approved">Approved</option></select></div>
                            </div>
                      <div class="col-sm-1">Year</div>
                        <div class="col-sm-2" id="">
                          <select name="pyear" id="pyear" class="form-control" onchange="pyear_change(this)">
                            <option value="">Select Status</option>
                            <option value="2019">2019</option>
                            <option value="2020" >2020</option>
                            <option value="2021">2021</option>
                            <option value="ALL" selected="selected">ALL</option>
                          </select>
                        </div>

                        <!--<div class="col-sm-3" id="" >
                          <input type="text" name="pdate" id="pdate" class="form-control" Placeholder="Payment Date">
                        </div>-->

                        <!--<div class="col-sm-2" id="semest">
                             <input type="button" id="sbutton" class="btn btn-primary btn-labeled" value="Search" > 
                        </div>-->
                    </div>
                    </span>
                  </div>

                  <div class="table-info panel-body table-responsive" style="overflow:auto;">          
                  <table id="table" class="table table-striped table-bordered js-basic-example dataTable" cellspacing="0" width="100%">
                              <thead>
                                  <tr>
                                      <th>Sr.No.</th>
                                      <th>Receipt&nbsp;No.</th>
                                      <th>Bank&nbsp;Ref&nbsp;No</th>
                                      <th>PRN</th>
                                      <th>Name</th>
                                       <th>Campus</th>
                                      <th>Mobile</th>
                                      <th>Amount</th>
                                      <th>academic</th>
                                      <th>Mode</th>
                                      <th>Status</th>
                                      <th>Date</th>
                                      <th>Type</th>
                                    <!--  <th>Registration</th>-->
                                      <th>Verify</th>
                                      <th>Action</th>
                                  </tr>
                              </thead>
                              <tbody>
                              </tbody>

                              <tfoot>
                                  <tr>
                                      <th>Sr.No.</th>
                                      <th>Receipt&nbsp;No.</th>
                                      <th>Bank&nbsp;Ref&nbsp;No</th>
                                       <th>PRN</th>
                                      <th>Name</th>
                                      <th>Mobile</th>
                                      <th>Amount</th>
                                      <th>academic</th>
                                      <th>Mode</th>
                                      <th>Status</th>
                                      <th>Date</th>
                                      <th>Type</th>
                                  <!--    <th>Registration</th>-->
                                      <th>Verify</th>
                                      <th>Action</th>
                                  </tr>
                              </tfoot>
                          </table>
                  </div>    <!--<div class="loader" style="display:none"></div>-->
        </div>
    </div>
</div>
<script type="text/javascript">

var oTable;

$(document).ready(function() {

        oTable =  $('#table').DataTable( {
        dom: 'Bflrtip',
        buttons: [
            'excelHtml5'
        ],
        "processing": true,
		 'language': {
            'loadingRecords': '&nbsp;',
            'processing': '<div class="loader"></div>'
        }      ,
        "serverSide": true,
        "responsive": true,
		"sScrollX": "100%",
        "sScrollXInner": "100%",
        "bScrollCollapse": true,
        "order": [[0, 'DESC']],        
        "iDisplayLength": 100,
        "lengthMenu": [[100, 250, 500,1000, -1], [100, 250, 500,1000, "All"]],
		
        "ajax": {
                "url": "<?php echo site_url('Online_transport_fee/getOnlineFeeDetail')?>",
                "type": "POST",
                 "data": function ( data ) {
				
	
				//data.date = $('#date').val();
				//data.type_param = $('#type_param').val();
				data.Type_status = 'ALL';
				data.Verify_status = 'Pending';
				data.pyear = 'ALL';
                /*data.country = $('#country').val();
                data.FirstName = $('#FirstName').val();
                data.LastName = $('#LastName').val();
                data.address = $('#address').val();*/
            }
        },
            
        "aoColumnDefs": [ { 
            "targets": [ 0 ], //first column / numbering column
            "orderable": false, //set not orderable
        } ],
        "rowCallback": function (nRow, aData, iDisplayIndex) {
          /*var oSettings = this.fnSettings ();
          $("td:first", nRow).html(oSettings._iDisplayStart+iDisplayIndex +1);
          return nRow;*/
        },
    } );

    oTable.on('draw.dt', function () {
      $('[data-toggle="tooltip"]').tooltip();  
    });

    $('#btn-filter').click(function(){ //button filter event click
        oTable.ajax.reload();  //just reload table
    });
    $('#btn-reset').click(function(){ //button reset event click
        $('#form-filter')[0].reset();
        oTable.ajax.reload();  //just reload table
    });

    $('#pdate').datepicker( {format: 'yyyy-mm-dd',autoclose: true});

    /*$('#sbutton').click(function(){
      oTable.destroy();
      var pdate = $("#pdate").val();
      var pstatus = $("#pstatus").val();

          oTable =  $('#table').DataTable( {
          dom: 'Bflrtip',
          buttons: [
              'excelHtml5'
          ],
          "processing": true,
		   'language': {
            'loadingRecords': '&nbsp;',
            'processing': '<div class="loader"></div>'
        }      ,
          "serverSide": true,
          "responsive": true,
		  "sScrollX": "100%",
        "sScrollXInner": "100%",
        "bScrollCollapse": true,
          "order": [[0, 'DESC']],        
          "iDisplayLength": 100,
          "lengthMenu": [[200, 250, 500,1000, -1], [200, 250, 500,1000, "All"]],
          "ajax": {
                  "url": "<?php echo site_url('Online_transport_fee/getOnlineFeeDetail')?>",
                  "type": "POST",
                  'data' : {'pdate':pdate,'pstatus':pstatus},
              },
          "aoColumnDefs": [ { 
              "targets": [ 0 ], //first column / numbering column
              "orderable": false, //set not orderable
          } ],
          "rowCallback": function (nRow, aData, iDisplayIndex) {
          },
      } );
    });*/

 });
 function Type_status_change(m){
 	var values = $(m).val();
  oTable =  $('#table').DataTable( {
        dom: 'Bflrtip',
        buttons: [
            'excelHtml5'
        ],
		"destroy": true,
        "processing": true,
		 'language': {
            'loadingRecords': '&nbsp;',
            'processing': '<div class="loader"></div>'
        }      ,
        "serverSide": true,
        "responsive": true,
		"sScrollX": "100%",
        "sScrollXInner": "100%",
        "bScrollCollapse": true,
        "order": [[0, 'DESC']],        
        "iDisplayLength": 100,
        "lengthMenu": [[100, 250, 500,1000, -1], [100, 250, 500,1000, "All"]],
		
        "ajax": {
                "url": "<?php echo site_url('Online_transport_fee/getOnlineFeeDetail')?>",
                "type": "POST",
                 "data": function ( data ) {
				
				
				data.Type_status = values;
				data.Verify_status = $('#Verify_status').val();
				data.pyear = $('#pyear').val();
                /*data.country = $('#country').val();
                data.FirstName = $('#FirstName').val();
                data.LastName = $('#LastName').val();
                data.address = $('#address').val();*/
            }
        
            },
        "aoColumnDefs": [ { 
            "targets": [ 0 ], //first column / numbering column
            "orderable": false, //set not orderable
        } ],
        "rowCallback": function (nRow, aData, iDisplayIndex) {
          /*var oSettings = this.fnSettings ();
          $("td:first", nRow).html(oSettings._iDisplayStart+iDisplayIndex +1);
          return nRow;*/
        },
    } );
	
	
	
 }
	
	function Verify_status_change(m){
	var values = $(m).val();
	 oTable =  $('#table').DataTable( {
        dom: 'Bflrtip',
        buttons: [
            'excelHtml5'
        ],
		"destroy": true,
        "processing": true,
		 'language': {
            'loadingRecords': '&nbsp;',
            'processing': '<div class="loader"></div>'
        }      ,
        "serverSide": true,
        "responsive": true,
		"sScrollX": "100%",
        "sScrollXInner": "100%",
        "bScrollCollapse": true,
        "order": [[0, 'DESC']],        
        "iDisplayLength": 100,
        "lengthMenu": [[100, 250, 500,1000, -1], [100, 250, 500,1000, "All"]],
		
        "ajax": {
                "url": "<?php echo site_url('Online_transport_fee/getOnlineFeeDetail')?>",
                "type": "POST",
                 "data": function ( data ) {
				
				
				data.Type_status = $('#Type_status').val();
				data.Verify_status = values;
				data.pyear = $('#pyear').val();
                /*data.country = $('#country').val();
                data.FirstName = $('#FirstName').val();
                data.LastName = $('#LastName').val();
                data.address = $('#address').val();*/
            }
        
            },
        "aoColumnDefs": [ { 
            "targets": [ 0 ], //first column / numbering column
            "orderable": false, //set not orderable
        } ],
        "rowCallback": function (nRow, aData, iDisplayIndex) {
          /*var oSettings = this.fnSettings ();
          $("td:first", nRow).html(oSettings._iDisplayStart+iDisplayIndex +1);
          return nRow;*/
        },
    } );
	}
	
	
	
	function pyear_change(m){
	var values = $(m).val();
	 oTable =  $('#table').DataTable( {
        dom: 'Bflrtip',
        buttons: [
            'excelHtml5'
        ],
		"destroy": true,
        "processing": true,
		 'language': {
            'loadingRecords': '&nbsp;',
            'processing': '<div class="loader"></div>'
        }      ,
        "serverSide": true,
        "responsive": true,
		"sScrollX": "100%",
        "sScrollXInner": "100%",
        "bScrollCollapse": true,
        "order": [[0, 'DESC']],        
        "iDisplayLength": 100,
        "lengthMenu": [[100, 250, 500,1000, -1], [100, 250, 500,1000, "All"]],
		
        "ajax": {
                "url": "<?php echo site_url('Online_transport_fee/getOnlineFeeDetail')?>",
                "type": "POST",
                 "data": function ( data ) {
				
				
				data.Type_status = $('#Type_status').val();
				data.Verify_status =$('#Verify_status').val();
				data.pyear = values;;
                /*data.country = $('#country').val();
                data.FirstName = $('#FirstName').val();
                data.LastName = $('#LastName').val();
                data.address = $('#address').val();*/
            }
        
            },
        "aoColumnDefs": [ { 
            "targets": [ 0 ], //first column / numbering column
            "orderable": false, //set not orderable
        } ],
        "rowCallback": function (nRow, aData, iDisplayIndex) {
          /*var oSettings = this.fnSettings ();
          $("td:first", nRow).html(oSettings._iDisplayStart+iDisplayIndex +1);
          return nRow;*/
        },
    } );
	}
	
	
	
	
	
	function change_productinfo(m){
		var value=m.value;
		var lang=m.lang;
		var retVal = confirm("Do you want to continue ?");
               if( retVal == true ) {
				   
				   $.ajax({
   'url' : base_url + 'Online_transport_fee/change_productinfo',
   'type' : 'POST', //the way you want to send data to your URL
   'data' : {'value' : value,'lang' : lang},
   'success' : function(data){
	   
	   oTable.ajax.reload(); 
   }
				   });
				   
				   
				  // alert(value);
				   
                 // document.write ("User wants to continue!");
                 // return true;
               } else {
                 // document.write ("User does not want to continue!");
                  return false;
               }
		
		
		
		
		
	}
</script>