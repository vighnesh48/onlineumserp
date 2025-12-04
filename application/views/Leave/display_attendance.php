<?php
					$session=$this->session->userdata();
					$empid=($session['name']);
					 ?><script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<script src="<?=site_url()?>assets/javascripts/jspdf/jspdf.js" type="text/javascript"></script>

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
  onclick_checkbox_emp(<?php echo $empid;?>);
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
      <a href="#">Monthly in-out time report 
      </a>
    </li>
  </ul>
  <div class="page-header">
    <div class="row">
      <h1 class="col-xs-12 col-sm-4 text-center text-left-sm">
        <i class="fa fa-dashboard page-header-icon">
        </i>&nbsp;&nbsp;Monthly in-out time report 
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
                    <strong> Regular Staff Attendance 
                    </strong>
                  </div>
                  <div class="panel-body"> 
                    <span id="flash-messages" style="color:red;padding-left:110px;">
                      <?php echo $this->session->flashdata('message1'); ?>
                    </span>
                    <div class="panel-padding no-padding-vr">
                      <div class="form-group">
                        
                        <div class="portlet-body form">
                          <form id="form" name="form" action="<?=base_url($currentModule.'/view_attendance')?>" method="POST" enctype="multipart/form-data">
                            <div class="form-body">
                              <div class="row"> 
                                <!--<div class="form-group">
                                  <label class="col-md-4">Select School
                                  </label>
                                  <div class="col-md-8" >
                                    <select class="select2me form-control" name="emp_school" onchange="getstaffdept_using_school(this.value)" id="emp_school" >
                                      <option value="">Select School
                                      </option>
                                      <?php foreach($school_list as $sc) { echo "<option  value=".$sc['college_id'].">".$sc['college_name']."</option>"; } ?>
                                    </select>
                                  </div>
                                </div>-->
                              </div>
                              <!--<div class="row">
                                <div class="form-group">
                                  <label class="col-md-4 control-label">Select Department  
                                  </label>
                                  <div class="col-md-8">
                                    <select class="form-control select2me" id="department"  onchange="getEmp_using_sch_dep(this.value)" name="department" >
                                      <option value="">Select Department
                                      </option>
                                    </select>
                                  </div>
                                </div>
                              </div>-->
                              <div class="row">
                                <div class="form-group">
                                  <label class="col-md-4">Select Month
                                    <?=$astrik?>
                                  </label>
                                  <div class="col-md-8" >
                                    <input id="dob-datepicker" required class="form-control form-control-inline  date-picker" name="attend_date" value="" placeholder="Enter Month" type="text">
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="form-group">
                                 <!-- <label class="col-md-4">Select Employees
                                  </label>-->
                                  <div class="col-md-8">                
                                    <dl class="dropdown dropdowns">   
                                      <dt>
                                       <!-- <a href="#">
                                          <span class="hida">All Employee
                                          </span>    
                                          <div class="multiSel">
                                          </div>  
                                        </a>-->
                                      </dt>
                                      <dd>
                                      <!--  <div class="mutliSelect" id="mutliSelect">
                                          <ul id="empid">
                                           <li><input type='checkbox'   name="emp_chk_all" onclick='check_all()'> Select All </li>-->
                                            <?php 
//print_r($emp_list)
$sl='';
/*foreach($emp_list as $key=>$val){ 
if($emp_list[$key]['emp_id']==$empid){$sl="checked='checked'";}else{$sl='';}
echo '<li>
<input type="checkbox" name="empsid[]"  id="'.$emp_list[$key]['emp_id'].'" onclick="onclick_checkbox_emp('.$emp_list[$key]['emp_id'].');" value="'.$emp_list[$key]['emp_id'].'" /> '.$emp_list[$key]['emp_id'].' - '.$emp_list[$key]['fname'].' '.$emp_list[$key]['lname'].' </li>';
}*/ ?> 
<input type="hidden" name="empsid[]" checked="checked"  id="<?php echo $empid;?>" onclick="onclick_checkbox_emp(<?php echo $empid;?>);" value="<?php echo $empid;?>" readonly="readonly" />

                                         <!-- </ul>
                                        </div>-->
                                      </dd>
                                    </dl>           
                                  </div>
                                </div>
                              </div>
                             
                              <div class="row">
                                <div class="form-group">
                                  <div class="col-md-3" >
                                  </div>
                                  <div class=" col-md-3">
                                    <button type="submit" class="btn btn-primary form-control" >Submit
                                    </button>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </form>
                        </div>
                       </div>
             
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="col-sm-6" style="display:none;">
<div class="table-info">
              <div id="dashboard-recent" class="panel-warning">
                <div class="panel">
                  <div class="panel-heading">
                    <strong> Visiting Staff Attendance 
                    </strong>
                  </div>
                  <div class="panel-body"> 
                    <span id="flash-messages" style="color:red;padding-left:110px;">
                      <?php echo $this->session->flashdata('message1'); ?>
                    </span>
                    <div class="panel-padding no-padding-vr">
                      <div class="form-group">
                        
                        <div class="portlet-body form">
                          <form id="form1" name="form1" action="<?=base_url($currentModule.'/view_visiting_attendance')?>" method="POST" enctype="multipart/form-data">
                            <div class="form-body">
                             <!-- <div class="row"> 
                                <div class="form-group">
                                  <label class="col-md-6">Select School
                                  </label>
                                  <div class="col-md-6" >
                                    <select class="select2me form-control" name="emp_schoolv" onchange="getstaffdept_using_schoolv(this.value)" id="emp_schoolv" >
                                      <option value="">Select School
                                      </option>
                                      <?php //foreach($school_list as $sc) { echo "<option  value=".$sc['college_id'].">".$sc['college_name']."</option>"; } ?>
                                    </select>
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="form-group">
                                  <label class="col-md-6 control-label">Select Department  
                                  </label>
                                  <div class="col-md-6">
                                    <select class="form-control select2me" id="departmentv"  onchange="getEmp_using_sch_depv(this.value)" name="department" >
                                      <option value="">Select Department
                                      </option>
                                    </select>
                                  </div>
                                </div>
                              </div>-->
                              <div class="row">
                                <div class="form-group">
                                  <label class="col-md-4">Select Month
                                    <?=$astrik?>
                                  </label>
                                  <div class="col-md-8" >
                                    <input id="dob-datepickerv" required class="form-control form-control-inline  date-picker" name="attend_datev" value="" placeholder="Enter Month" type="text">
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="form-group">
                                  <label class="col-md-4">Select Employees
                                  </label>
                                  <div class="col-md-8">                
                                    <dl class="dropdownv dropdown">   
                                      <dt>
                                        <a href="#">
                                          <span class="hidav">All Employee
                                          </span>    
                                          <div class="multiSelv">
                                          </div>  
                                        </a>
                                      </dt>
                                      <dd>
                                        <div class="mutliSelectv" id="mutliSelectv">
                                          <ul id="empidv">
                                           <li><input type='checkbox'  name="emp_chk_allv" onclick='check_allv()'> Select All </li>
                                            <?php 
//print_r($emp_list);
foreach($vemp_list as $key=>$val){ 
echo '<li>
<input type="checkbox" name="empsidv[]" id="'.$vemp_list[$key]['emp_id'].'" onclick="onclick_checkbox_empv('.$vemp_list[$key]['emp_id'].');" value="'.$vemp_list[$key]['emp_id'].'" /> '.$vemp_list[$key]['emp_id'].' - '.$vemp_list[$key]['fname'].' '.$vemp_list[$key]['lname'].' </li>';
} ?> 
                                          </ul>
                                        </div>
                                      </dd>
                                    </dl>           
                                  </div>
                                </div>
                              </div>
                             
                              <div class="row">
                                <div class="form-group">
                                  <div class="col-md-3" >
                                  </div>
                                  <div class=" col-md-3">
                                    <button type="submit" class="btn btn-primary form-control" >Submit
                                    </button>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </form>
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
