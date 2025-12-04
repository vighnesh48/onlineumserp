<?php $role_id = $_SESSION['role_id']; ?>
<style type="text/css">
  .dataTables_length , .dataTables_filter {
    display:inline-block !important;
    float:right !important;
  }
  .customBtns {
    display:inline-block !important;
    float:left !important;
    margin-right: 10px !important;
  }
</style>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Admission</a></li>
        <li class="active"><a href="#">Dashboard</a></li>
        <li class="active"><a href="#">Student List</a></li>
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
        <div class="panel-heading">
        <span class="panel-title">
        <div class="form-group">
        <div class="col-sm-2" id="">
        <select name="academic-year" id="academic-year" class="form-control" required>
        <option value=""> Academic Year</option>
        <?php 
          $academicYear = getStartSuccessiveAcademicYear();
          foreach($academicYear as $year) {
              $yearVal = explode('-', $year);
              echo '<option value="'.$yearVal[0].'">'.$year.'</option>';
            } 
        ?>
        </select>
        </div>
        <div class="col-sm-2">
        <select name="admission-course" id="admission-course" class="form-control" onchange="load_streams(this.value)" >
        <option value="">Select Course</option>
        </select>
        </div>
        <div class="col-sm-3" id="semest">
        <select name="admission-branch" id="admission-branch" class="form-control" >
        <option value="">Select Stream</option>
        </select>
        </div>
        <div class="col-sm-2" id="">
        <select name="admission-year" id="admission-year" class="form-control" >
        <option value="">Select Year</option>
        </select>
        </div>
        <div class="col-sm-2" id="semest">
        <input type="button" id="sbutton" class="btn btn-primary btn-labeled" value="Search" > 
        </div>
        </div>
        </span>
        <div class="holder1"></div>
        </div>
                  <div class="table-info panel-body table-responsive" style="overflow:auto;">
                  <form method="post" action="https://erp.sandipuniversity.com/Ums_admission/generatepdf/">
                  <input type="hidden" class="dcourse" name="dcourse" value="">
                  <input type="hidden" class="dyear" name="dyear" value="">
                  <input type="hidden" class="academic_year_pdf" name="academic_year_pdf" value="">
                  <input type="submit" value="Generate PDF" class="btn btn-primary btn-labeled customBtns">
                  </form>
                  <form method="post" action="https://erp.sandipuniversity.com/Ums_admission/generateID/" target="_blank">
                  <input type="hidden" class="dcourse" name="dcourse" value="">
                  <input type="hidden" class="dyear" name="dyear" value="">
                  <input type="submit" value="Generate ID Card" id="generateIdCard" class="btn btn-primary btn-labeled customBtns">   
                  <table id="table" class="table table-striped table-bordered js-basic-example dataTable" cellspacing="0" width="100%">
                              <thead>
                                  <tr>
                                      <th><input type="checkbox" id="ckbCheckAll"></th>
                                      <th>S.No.</th>
                                      <th>PRN</th>
                                      <th>Old PRN</th>
									  <th>Punching PRN</th>
                                      <th>Form No.</th>
                                      <th>Student Photo</th>
                                      <th>Name</th>
                                      <th>Marathi Name</th>
                                      <th>Stream</th>
                                      <th>Admission Year</th>
									  <th>Current Year</th>
                                      <th>Gender</th>
                                      <th>DOB</th>
									  <th>Admission Date</th>
                                      <th>Mobile</th>
									  <!--<th>Username</th>
									  <th>Password</th>-->
                                      <th>Parent Mobile</th>
                                      <th>Email</th>
                                      <th>Category</th>
                                      <!--th>Reported</th-->
                                      <?php if($role_id == 5) { ?>
                                      <th class="noExl">Payment</th>
                                      <?php } ?>
                                      <?php if($role_id == 7) { ?>
                                      <th class="noExl">Payment Details</th>
                                      <?php } ?>
                                      <?php if($role_id == 15 || $role_id == 10 || $role_id == 6) { ?>
                                      <th class="noExl">View Subject</th>
                                      <?php } ?>
                                      
                                      <th>Action</th>
                                      <?php if($role_id == 15) { ?>
                                      <th>Detention</th>
                                      <?php } ?>
                                      <?php if($role_id == 41 || $role_id == 2 ) { ?>
									   <th>View</th>
                                      <!--th>Change Stream</th-->
                                      <?php } ?>
                                  </tr>
                              </thead>
                              <tbody>
                              </tbody>

                              <tfoot>
                                  <tr>
                                      <th><input type="checkbox" id="ckbCheckAll"></th>
                                      <th>S.No.</th>
                                      <th>PRN</th>
                                      <th>Old PRN</th>
                                      <th>Form No.</th>
                                      <th>Student Photo</th>
                                      <th>Name</th>
									  <th>Marathi Name</th>
                                      <th>Stream</th>
                                      <th>Admission Year</th>
									  <th>Current Year</th>
                                      <th>Gender</th>
                                      <th>DOB</th>
									  <th>Admission Date</th>
                                      <th>Mobile</th>
									<!--  <th>Username</th>
									  <th>Password</th>-->
                                      <th>Parent Mobile</th>
                                      <th>Email</th>
                                      <th>Category</th>
                                      <!--th>Reported</th-->
                                      <?php if($role_id == 5) { ?>
                                      <th class="noExl">Payment</th>
                                      <?php } ?>
                                      <?php if($role_id == 7) { ?>
                                      <th class="noExl">Payment Details</th>
                                      <?php } ?>
                                      <?php if($role_id == 41 || $role_id == 15 || $role_id == 10 || $role_id == 6) { ?>
                                      <th class="noExl">View Subject</th>
                                      <?php } ?>
                                      
                                      <th>Action</th>
                                      <?php if($role_id == 15) { ?>
                                      <th>Detention</th>
                                      <?php } ?>
                                      <?php if($role_id == 41 || $role_id == 2 ) { ?>
									  <th>View</th>
                                      <!--th>Change Stream</th-->
                                      <?php } ?>
                                  </tr>
                              </tfoot>
                          </table>
                          </form>
                  </div>    
        </div>

        <!-- Modal -->
        <div class="modal fade" id="walkinModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">

                        <h4 class="modal-title" id="myModalLabel">
                           <span id="fform_id">Detention Form</span>
                        </h4>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="panel panel-default panel-hovered panel-stacked" style="margin-top: 10px;">
                                    <div class="panel-body">
                                        <!--form role="form" method="post" action="<?=base_url()?>admin/updateWalkinStatus"-->
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Detention Status</label>
                                            <br>
                                            <input type="radio" name="dstatus" id="radio_1" value="no" required/> &nbsp;No &nbsp;
                                            <input type="radio" name="dstatus" id="radio_2" value="yes" required/> &nbsp;Yes &nbsp;

                                            <input type="hidden" name="stud_id" class="form-control" id="fstud_id" />
                                            <input type="hidden" name="fstud_details" class="form-control" id="fstud_details" />
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Exam Session</label>
                                            <br>
                                            <select name="exam_session" class="form-control" id="exam_session" style="width:35%" required>
                                                <!--option value="">-Select-</option-->
                                                <?php foreach($ex_ses as $ex) {
                                                  $exam_ses = $ex['exam_month'].'-'.$ex['exam_year'];
                                                  $exam_ses_val = $ex['exam_month'].'~'.$ex['exam_year'].'~'.$ex['exam_id'];
                                                ?>
                                                  <option value="<?=$exam_ses_val?>" selected="selected">
                                                  <?=$exam_ses?>
                                                  </option>
                                                  <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Reason</label>
                                            <br>
                                            <select name="detain_reason" class="form-control" id="detain_reason" style="width:35%" required>
                                                <option value="">-Select-</option>
                                                <option value="Lack of Attendance">Lack of Attendance</option>
                                                <option value="Indiscipline">Indiscipline</option>
                                                </select>
                                        </div>
                                        <button type="button" class="btn btn-primary" onclick="return mark_detention()">Submit</button>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">
                                            Close
                                        </button>
                                        <!--/form-->
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- Modal Footer 
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal">
                                    Close
                        </button>
                        <button type="button" class="btn btn-primary">
                            Save changes
                        </button>
                    </div>-->
                </div>
            </div>
        </div>

    </div>
</div>
<script type="text/javascript">

var oTable;

$(document).ready(function() {
    var oTable =  $('#table').DataTable( {
        dom: 'Bflrtip',
        buttons: [
            { extend: 'excelHtml5', className: 'btn-primary' }
        ],
      
        "responsive": true,
        
      
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

    $(".customBtns, .buttons-excel").css("visibility", "hidden");

    $('#sbutton').click(function(){
		alert("please wait");
    $(".customBtns, .buttons-excel").css("visibility", "visible");
    var base_url = '<?php echo base_url();?>';
    var acourse = $("#admission-course").val();
    var astream = $("#admission-branch").val();
    var ayear = $("#admission-year").val();
    var acdyear = $("#academic-year").val();
	if(acdyear == '') {
        alert("Please Select Academic Year");
        return false;   
    }
    /*if(acourse == '') {
        alert("Please Select Course");
        return false;
    }

    if(astream == '') {
        alert("Please Select Stream");
        return false;
    }*/

    

    $('.dcourse').val(astream);
    $('.dyear').val(ayear);
    $('.academic_year_pdf').val(acdyear);

    oTable.destroy();
	
    oTable =  $('#table').DataTable( {
        dom: 'Bflrtip',
        buttons: [
            { extend: 'excelHtml5', className: 'btn-primary' }
        ],
        "processing": true,
        "serverSide": true,
        "responsive": true,
        "order": [[0, 'DESC']],        
        "iDisplayLength": 10,
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        "ajax": {
                "url": "<?php echo site_url('Ums_admission/loadStudentsList')?>",
                "type": "POST",
                "data":{'astream':astream,'ayear':ayear,'acdyear':acdyear}
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

    $('#academic-year').change(function () {
      var academic_year = $("#academic-year").val();
      if (academic_year) {
        $.ajax({
          'url' : base_url + 'Ums_admission/load_courses_for_studentlist',
          'type' : 'POST',
          'data' : {'academic_year' : academic_year},
          'success' : function(data) {
            var container = $('#admission-course');
            if(data){ 
              container.html(data);
            }
          }
        });
      }
    });

    $('#admission-branch').change(function () {
      var admission_stream = $("#admission-branch").val();
      var academic_year = $("#academic-year").val();
      if (admission_stream) {
        $.ajax({
          'url' : base_url + 'Ums_admission/load_years_for_studentlist',
          'type' : 'POST',
          'data' : {'academic_year' : academic_year,admission_stream:admission_stream},
          'success' : function(data){
            var container = $('#admission-year');
            if(data){ 
              container.html(data);
            }
          }
        });
      }
    });

    $("#ckbCheckAll").click(function () {
        $(".checkBoxClass").prop('checked', $(this).prop('checked'));
    });

    $(".checkBoxClass").change(function(){
        if (!$(this).prop("checked")){
            $("#ckbCheckAll").prop("checked",false);
        }
    });
});

function load_streams(type){
    var academic_year = $("#academic-year").val();    
    $.ajax({
    'url' : base_url + 'Ums_admission/load_streams_student_list',
    'type' : 'POST',
    'data' : {'course' : type,'academic_year':academic_year},
    'success' : function(data){
      var container = $('#admission-branch');
      if(data) {
      container.html(data);
      }
    }
    });
}

function mark_detention() {
  var detain = $("input[name='dstatus']:checked").val();
  var dreason = $("#detain_reason").val();
  var exam_session = $("#exam_session").val();
  var fstud_details = $("#fstud_details").val();
  var stud_id = $("#fstud_id").val();
  if(detain == 'yes') {
    var str_alert = 'Detain';
  } else {
    var str_alert = 'Release';
  }
  if(exam_session == '') {
    alert('please select Exam Session');
    $("#exam_session").focus();
    return false;
  }
  if(dreason == '') {
    alert('please select reason');
    $("#detain_reason").focus();
    return false;
  }
  if(confirm("Are you sure to "+str_alert+" this Student?")) {
    $.ajax({
      type: 'POST',
      url: '<?= base_url() ?>Ums_admission/detain_student',
      data: {detain:detain,stud_id:stud_id,dreason:dreason,stud_details:fstud_details,exam_session:exam_session},
      success: function (data) {
        if (data == 'Y') {
          alert("Updated Successfully..");
          $('.modal-backdrop').remove();
          $("#sbutton").trigger("click");
        }
      }
    });
  } else {
    return false;
  }
  return true;
}
</script>