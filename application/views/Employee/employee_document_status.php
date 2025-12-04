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
    width: 100%;
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
    width:300px;
    list-style: none;
    height: 300px;
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
  #main-wrapper{overflow: visible!important;}
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
  function onclick_checkbox_empv(eid){
    //$('#mutliSelect input[type="checkbox"]').on('click', function() {
    //alert('gg');
    var title = $(this).closest('.mutliSelectv').find('input[type="checkbox"]').val(),
        title = eid + ",";
   // alert(title);
    if ($('#'+eid).is(':checked')) {
      var html = '<span title="' + title + '">' + title + '</span>';
      //alert(html);
      $('.multiSelv').append(html);
      $(".hidav").hide();
    }
    else {
      $('span[title="' + title + '"]').remove();
      var ret = $(".hidav");
      $('.dropdownv dt a').append(ret);
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
  function getEmp_using_sch_depv(dept_id){
    var e = document.getElementById("emp_schoolv");
    var school_id = e.options[e.selectedIndex].value;
    var post_data='';
    if(school_id!=null && dept_id!=null){
      post_data+="&school="+school_id+"&department="+dept_id;
    }
    jQuery.ajax({
      type: "POST",
      url: base_url+"admin/getVisitingEmpListbyDepartmentSchool_attendance",
      data: encodeURI(post_data),
      success: function(data){
       // alert(data);
        $('#empidv').html(data);
      }
    }
               );
  }
  $(document).ready(function()
                    {
    $(".dropdowns dt a").on('click', function() {
      $(".dropdowns dd ul").slideToggle('fast');
    }
                          );
    $(".dropdowns dd ul li a").on('click', function() {
      $(".dropdowns dd ul").hide();
    }
                                );
    function getSelectedValue(id) {
      return $("#" + id).find("dt a span.value").html();
    }
    $(document).bind('click', function(e) {
      var $clicked = $(e.target);
      if (!$clicked.parents().hasClass("dropdowns")) $(".dropdowns dd ul").hide();
    }
                    );
          
           $(".dropdownv dt a").on('click', function() {
      $(".dropdownv dd ul").slideToggle('fast');
    }
                          );
    $(".dropdownv dd ul li a").on('click', function() {
      $(".dropdownv dd ul").hide();
    }
                                );
    function getSelectedValuev(id) {
      return $("#" + id).find("dt a span.value").html();
    }
    $(document).bind('click', function(e) {
      var $clicked = $(e.target);
      if (!$clicked.parents().hasClass("dropdownv")) $(".dropdownv dd ul").hide();
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
      <a href="#">Attendance
      </a>
    </li>
    <li class="active">
      <a href="#">Document List
      </a>
    </li>
  </ul>
  <div class="page-header">
    <div class="row">
      <h1 class="col-xs-12 col-sm-4 text-center text-left-sm">
        <i class="fa fa-dashboard page-header-icon">
        </i>&nbsp;&nbsp;Document List
      </h1>
      <div class="col-xs-12 col-sm-8">
        <div class="row">
          <hr class="visible-xs no-grid-gutter-h">
        </div>
      </div>
    </div>
    
    <div class="row ">
      <div class="col-sm-12">
        <div class="col-sm-6">
            <div class="table-info">
              <div id="dashboard-recent" class="panel-warning">
                <div class="panel">
                  <div class="panel-heading">
                    <strong> Submitted Documents 
                    </strong>
                  </div>
                  <div class="panel-body"> 
                    
                    <div class="panel-padding no-padding-vr">
                      <div class="form-group">
                        
                        <div class="portlet-body form">
                            <div class="form-body">
                              <div class="row"> 
                                <table class="table table-bordered ">
<thead><th>SR.NO</th><th>Name</th><th>Original or Xerox</th></thead>
<tbody>
<?php //print_r($empdocs); 
$i=1;
foreach($empdocs as $val) { ?>
<tr>
<td><?php echo $i; ?></td><td><?php echo $val['document_name']; ?></td><td><?php if($val['doc_ox']=='O'){ echo 'Original'; }elseif($val['doc_ox']=='X'){ echo 'Xerox'; } ?></td>
</tr>
<?php $i++; } ?>
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
<div class="col-sm-6">
<div class="table-info">
              <div id="dashboard-recent" class="panel-warning">
                <div class="panel">
                  <div class="panel-heading">
                    <strong> Peanding Documents
                    </strong>
                  </div>
                  <div class="panel-body"> 
                  
                    <div class="panel-padding no-padding-vr">
                      <div class="form-group">
                        
                        <div class="portlet-body form">
                               <div class="form-body">
                            
                              <div class="row">
                                 <table class="table table-bordered ">
<thead><th>SR.NO</th><th>Name</th></thead>
<tbody>
<?php //print_r($empdocs); 
$i=1;
foreach($empdocp as $val) { ?>
<tr>
<td><?php echo $i; ?></td><td><?php echo $val['document_name']; ?></td>
</tr>
<?php $i++; } ?>
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
<script type="text/javascript">
function getstaffdept_using_schoolv(school_id){
//alert(school_id);
 var post_data=schoolid='';
  var schoolid=school_id;
           if(school_id!=null){

        post_data+="&school_id="+schoolid;
        
      }
 jQuery.ajax({
        type: "POST",
        url: base_url+"admin/getdepartmentByschool",
        data: encodeURI(post_data),
        success: function(data){
        //  alert(data);
                
            //$('#reporting_dept').append(data);
      //alert('fff');
            $('#departmentv').html(data);
      //$('#mutliSelect').prop('selected',false);
      $(".multiSel").find('span').remove();
      //$("#dept-emp").html(emp_list);
        } 
      });

  
}
function check_all(){
    if($('input:checkbox[name="emp_chk_all"]').prop("checked")) {
  $('input:checkbox[name="empsid[]"]').prop('checked', true);
  
  $('.emp_amty').prop('disabled',false);
   } else {
     $('input:checkbox[name="empsid[]"]').prop('checked', false);
   $('.emp_amty').prop('disabled',true);
            }    
}
function check_allv(){
    if($('input:checkbox[name="emp_chk_allv"]').prop("checked")) {
  $('input:checkbox[name="empsidv[]"]').prop('checked', true);
  
  $('.emp_amty').prop('disabled',false);
   } else {
     $('input:checkbox[name="empsidv[]"]').prop('checked', false);
   $('.emp_amty').prop('disabled',true);
            }    
}
  $(document).ready(function(){
    $('#dob-datepicker').datepicker( {
      format: "yyyy-m",startView: "months",minViewMode: "months",autoclose:true}
                                   );
                   $('#dob-datepickerv').datepicker( {
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
