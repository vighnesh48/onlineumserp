<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> ">
</script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript">
</script>
<script src="<?=site_url()?>assets/javascripts/jspdf/jspdf.js" type="text/javascript">
</script>
<style>
  .attexl table {
    border: 1px solid black;
  }
  .attexl table th {
    border: 1px solid black;
    padding: 5px;
    background-color: grey;
    color: white;
  }
  .attexl table td {
    border: 1px solid black;
    padding: 5px;
  text-align:center;
  }
  .dropdown {
    xtop:50%;
    transform: translateY(0%);
  }
  a {
    color: #fff;
  }
  .dropdown dd,
  .dropdown dt {
    margin: 0px;
    padding: 0px;
    z-index:99999!important;
  }
  .dropdown{
    z-index:99999!important}
  .dropdown ul {
    margin: -1px 0 0 0;
  }
  .dropdown dd {
    position: relative;
  }
  .dropdown a,
  .dropdown a:visited {
    color: #000;
    text-decoration: none;
    outline: none;
    font-size: 12px;
  }
  .dropdown dt a {
    background-color: #fff;
    display: block;
    padding: 10px;
    overflow: hidden;
    border: 0;
    width: 288px;
    border: 1px solid #aaa;
  }
  .dropdown dt a span,
  .multiSel span {
    cursor: pointer;
    display: inline-block;
    padding: 0 3px 2px 0;
  }
  .dropdown dd ul {
    background-color: #fff;
    border: 0;
    color: #000;
    display: none;
    left: 0px;
    padding: 2px 15px 2px 5px;
    position: absolute;
    top: 2px;
    width:100%;
    list-style: none;
    height: 100px;
    overflow-y:scroll;
    border: 1px solid #aaa;
  }
  .dropdown span.value {
    display: none;
  }
  .dropdown dd ul li a {
    padding: 5px;
    display: block;
  }
  .dropdown dd ul li a:hover {
    background-color: #ddd;
  }
  .datepicker-dropdown{
    z-index: 999999;
  }
</style>
<script>
  function onclick_checkbox_emp(eid){
    //$('#mutliSelect input[type="checkbox"]').on('click', function() {
    //alert('gg');
    var title = $(this).closest('.mutliSelect').find('input[type="checkbox"]').val(),
        title = eid + ",";
    //alert(title);
    if ($('#'+eid).is(':checked')) {
      var html = '<span title="' + title + '">' + title + '</span>';
      //alert(html);
      $('.multiSel').append(html);
      $(".hida").hide();
    }
    else {
      $('span[title="' + title + '"]').remove();
      var ret = $(".hida");
      $('.dropdown dt a').append(ret);
    }
    //});
  }
  function getEmp_using_sch_dep(dept_id){
    var e = document.getElementById("emp_school");
    var school_id = e.options[e.selectedIndex].value;
    var post_data='';
    if(school_id!=null && dept_id!=null){
      post_data+="&school="+school_id+"&department="+dept_id;
    }
    jQuery.ajax({
      type: "POST",
      url: base_url+"admin/getEmpListbyDepartmentSchool_attendance",
      data: encodeURI(post_data),
      success: function(data){
        //alert(data);
        $('#empid').html(data);
      }
    }
               );
  }
  $(document).ready(function()
                    {
    $(".dropdown dt a").on('click', function() {
      $(".dropdown dd ul").slideToggle('fast');
    }
                          );
    $(".dropdown dd ul li a").on('click', function() {
      $(".dropdown dd ul").hide();
    }
                                );
    function getSelectedValue(id) {
      return $("#" + id).find("dt a span.value").html();
    }
    $(document).bind('click', function(e) {
      var $clicked = $(e.target);
      if (!$clicked.parents().hasClass("dropdown")) $(".dropdown dd ul").hide();
    }
                    );
    /*
        $('#form').bootstrapValidator
        ({  
            message: 'This value is not valid',
            group: 'form-group',
            feedbackIcons: 
            {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
       row: {
        valid: 'field-success',
        invalid: 'field-error'
    },
            fields: 
            {
                attend_date:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Select month'
                      }
                    }
                }
            }       
        })*/
  }
                   );
</script>
<?php
$astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
  <ul class="breadcrumb breadcrumb-page">
    <div class="breadcrumb-label text-light-gray">You are here: 
    </div>
    <li>
      <a href="#">Leave
      </a>
    </li>
    <li class="active">
      <a href="#">Monthly Leave report 
      </a>
    </li>
  </ul>
  <div class="page-header">
    <div class="row">
      <h1 class="col-xs-12 col-sm-4 text-center text-left-sm">
        <i class="fa fa-dashboard page-header-icon">
        </i>&nbsp;&nbsp;Monthly Leave report 
      </h1>
      <div class="col-xs-12 col-sm-8">
        <div class="row">
          <hr class="visible-xs no-grid-gutter-h">
        </div>
      </div>
    </div>
    <div class="row ">
      <div class="col-sm-12">&nbsp;
      </div>
    </div>
    <div class="row ">
      <div class="col-sm-12">
        <div class="panel">
          <div class="panel-body">
            <div class="table-info">
              <div id="dashboard-recent" class="panel-warning">
                <div class="panel">
                  <div class="panel-heading">
                    <strong>Leave
                    </strong>
                  </div>
                  <div class="panel-body"> 
                    <span id="flash-messages" style="color:red;padding-left:110px;">
                      <?php echo $this->session->flashdata('message1'); ?>
                    </span>
                    <div class="panel-padding no-padding-vr">
                      <div class="form-group">
                        <div class="row">
                        </div>
                        <div class="portlet-body form">
                          <form id="form" name="form" action="<?=base_url($currentModule.'/leave_report_pdf')?>" method="POST" enctype="multipart/form-data">
                            <div class="form-body">
                              <div class="row"> 
                                <div class="form-group">
                                  <label class="col-md-3">Select School
                                  </label>
                                  <div class="col-md-4" >
                                    <select class="select2me form-control" name="emp_school" onchange="getstaffdept_using_school(this.value)" id="emp_school" >
                                      <option value="">Select School
                                      </option>
                                      <?php foreach($school_list as $sc) { echo "<option  value=".$sc['college_id'].">".$sc['college_name']."</option>"; } ?>
                                    </select>
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="form-group">
                                  <label class="col-md-3 control-label">Select Department  
                                  </label>
                                  <div class="col-md-4">
                                    <select class="form-control select2me" id="department"  onchange="getEmp_using_sch_dep(this.value)" name="department" >
                                      <option value="">Select Department
                                      </option>
                                    </select>
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="form-group">
                                  <label class="col-md-3">Select Month
                                    <?=$astrik?>
                                  </label>
                                  <div class="col-md-4" >
                                    <input id="dob-datepicker" required class="form-control form-control-inline  date-picker" name="attend_date" value="" placeholder="Enter Month" type="text">
                                  </div>
                                </div>
                              </div>
                               <div class="row"> 
                                <div class="form-group">
                                  <label class="col-md-3">Select Leave Type
                                  </label>
                                  <div class="col-md-4" >
                                    <select class="select2me form-control" name="leave_typ"  >
                                      <option value="">Select Leave Type
                                      </option>
									  <option value="">All</option>
                                     <option value='OD'> OD </option>
									 <option value="Leave" >Leaves</option>
                                    </select>
                                  </div>
                                </div>
                              </div>
                              <br>
                              <div class="row">
                                <div class="form-group">
                                  <div class="col-md-3" >
                                  </div>
                                  <div class=" col-md-2">
                                    <button type="submit" class="btn btn-primary form-control" >Submit
                                    </button>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </form>
                        </div>
                        <div class="pagination" style="float:right;">
                          <?php  echo $paginglinks['navigation']; ?>
                        </div>
                        <div class="pagination" style="float:left;"> 
                          <?php echo (!empty($pagermessage) ? $pagermessage : ''); ?>
                        </div>
                       
                         
                        
                          <div class="attexl" id="ReportTable1" style="">
                          <?php print_r($emp_leaves_list); ?>
						   <table class="table table-bordered leavetab">
                        <thead>
                          <tr>
                                    
                                    
                                    
                            </tr>
                        </thead>
                        <tbody id="itemContainer1">
						
						</tbody>
						</table>
                           
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
           
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<script type="text/javascript">
  $(document).ready(function(){
    $('#dob-datepicker').datepicker( {
      format: "yyyy-m",startView: "months",minViewMode: "months",autoclose:true}
                                   );
    var content = '<tr>'+$('#eduDetTable tbody tr').html()+'</tr>';
    $("#eduDetTable").on("click","input[name='addMore']", function(e){
      //$("input[name='addMore']").on('click',function(){   
      //var content = $(this).parent().parent('tr').clone('true');
      $(this).parent().parent('tr').after(content);
    }
                        );
    $("#eduDetTable").on("click","input[name='remove']", function(e){
      //$("input[name='remove']").on('click',function(){
      var rowCount = $('#eduDetTable tbody tr').length;
      if(rowCount>1){
        $(this).parent().parent('tr').remove();
      }
    }
                        );
    $("#btnExport").click(function(e) {
      window.open('data:application/vnd.ms-excel,' + $('#dvData').html());
      e.preventDefault();
    }
                         );
  }
                   );
</script> 
