<style type="text/css">
  .dataTables_length , .dataTables_filter{
    display:inline-block !important;
    float:right !important;
  }
</style>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Admission</a></li>
        <li class="active"><a href="#">Dashboard</a></li>
        <li class="active"><a href="#">College Student List</a></li>
    </ul>
    <div class="page-header">
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;College Student List</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h"> 
                    <div class="visible-xs clearfix form-group-margin"></div>
                </div>
            </div>
        </div>           
        <div class="row ">
                  <div class="table-info panel-body table-responsive" style="overflow:auto;">          <table id="table" class="table table-striped table-bordered js-basic-example dataTable" cellspacing="0" width="100%">
                              <thead>
                                  <tr>
                                      <th><input type="checkbox" id="ckbCheckAll" class="checkBoxClass"></th>
                                      <th>S.No.</th>
                                      <th>PRN</th>
                                      <th>Old PRN</th>
                                      <th>Form No.</th>
                                      <th>Photo1</th>
                                      <th>Name</th>
                                      <th>Stream</th>
                                      <th>DOB</th>
                                      <th>Mobile</th>
                                      <th>Reported</th>
                                      <th>View Subject</th>
                                      <th>Action</th>
                                  </tr>
                              </thead>
                              <tbody>
                              </tbody>

                              <tfoot>
                                  <tr>
                                      <th></th>
                                      <th>S.No.</th>
                                      <th>PRN</th>
                                      <th>Old PRN</th>
                                      <th>Form No.</th>
                                      <th>Photo1</th>
                                      <th>Name</th>
                                      <th>Stream</th>
                                      <th>DOB</th>
                                      <th>Mobile</th>
                                      <th>Reported</th>
                                      <th>View Subject</th>
                                      <th>Action</th>
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

    var url_string = window.location.href; //current url
    var url = new URL(url_string);
    var school_id = url.searchParams.get("school_id");
    var academicYear = url.searchParams.get("academicYear");

    var oTable =  $('#table').DataTable( {
        dom: 'Bflrtip',
        buttons: [
            'excelHtml5'
        ],
        "processing": true,
        "serverSide": true,
        "responsive": true,
        "order": [[0, 'DESC']],        
        "iDisplayLength": 10,
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        "ajax": {
                "url": "<?php echo site_url('Currentyearadmission/CurrentYearAdmissionList')?>",
                "type": "POST",
                "data":{school_id:school_id,academicYear:academicYear}
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

});

</script>