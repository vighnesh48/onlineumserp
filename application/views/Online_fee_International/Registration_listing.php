<style type="text/css">
  .dataTables_length , .dataTables_filter{
    display:inline-block !important;
    float:right !important;
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
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Payment List</h1> <!--<a href="<?=base_url()?>Online_fee/ic_adm_payment"><button class="btn-primary btn pull-right">IC Admission Online Payment</button></a>-->
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
                    <!--<div class="form-group">

                      <div class="col-sm-2"></div>
                        <div class="col-sm-4" id="">
                          <select name="pstatus" id="pstatus" class="form-control" required>
                            <option value="">Select Status</option>
                            <option value="Y">Approved</option>
                            <option value="N">Pending</option>
                          </select>
                        </div>

                        <div class="col-sm-3" id="" >
                          <input type="text" name="pdate" id="pdate" class="form-control" Placeholder="Payment Date">
                        </div>

                        <div class="col-sm-2" id="semest">
                             <input type="button" id="sbutton" class="btn btn-primary btn-labeled" value="Search" > 
                        </div>
                    </div>-->
                    </span>
                  </div>

                  <div class="table-info panel-body table-responsive" style="overflow:auto;">          
                  <table id="table" class="table table-striped table-bordered js-basic-example dataTable" cellspacing="0" width="100%">
                              <thead>
                                  <tr>
                                      <th>Sr.No.</th>
                                      <th>Receipt No.</th>
                                      <th>Bank Ref No</th>
                                      <th>PRN</th>
                                      <th>Name</th>
                                      <th>Mobile</th>
                                      <th>Amount</th>
                                      <th>Mode</th>
                                      <th>Trans Status</th>
                                      <th>Payment Date</th>
                                     <th>Payment Type</th>
                                     <th>Registration</th>
                                  </tr>
                              </thead>
                              <tbody>
                              </tbody>

                              <tfoot>
                                  <tr>
                                      <th>Sr.No.</th>
                                      <th>Receipt No.</th>
                                      <th>Bank Ref No</th>
                                       <th>PRN</th>
                                      <th>Name</th>
                                      <th>Mobile</th>
                                      <th>Amount</th>
                                      <th>Mode</th>
                                      <th>Trans Status</th>
                                      <th>Payment Date</th>
                                      <th>Payment Type</th>
                                      <th>Re-registration</th>
                                  </tr>
                              </tfoot>
                          </table>
                  </div>    
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
        "serverSide": true,
        "responsive": true,
		"sScrollX": "100%",
        "sScrollXInner": "100%",
        "bScrollCollapse": true,
        "order": [[0, 'DESC']],        
        "iDisplayLength": 50,
        "lengthMenu": [[100, 250, 500, -1], [100, 250, 500, "All"]],
        "ajax": {
                "url": "<?php echo site_url('Online_fee/getOnlineFeeDetail_Registration')?>",
                "type": "POST",
                "data":{}
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

    $('#sbutton').click(function(){
      oTable.destroy();
      var pdate = $("#pdate").val();
      var pstatus = $("#pstatus").val();

          oTable =  $('#table').DataTable( {
          dom: 'Bflrtip',
          buttons: [
              'excelHtml5'
          ],
          "processing": true,
          "serverSide": true,
          "responsive": true,
		  "sScrollX": "100%",
        "sScrollXInner": "100%",
        "bScrollCollapse": true,
          "order": [[0, 'DESC']],        
          "iDisplayLength": 50,
          "lengthMenu": [[100, 250, 500, -1], [100, 250, 500, "All"]],
          "ajax": {
                  "url": "<?php echo site_url('Online_fee/getOnlineFeeDetail_Registration')?>",
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
    });

 });
</script>