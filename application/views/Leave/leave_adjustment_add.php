<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> ">
</script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript">
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
      <a href="#">Leave Adjustment Add
      </a>
    </li>
  </ul>
  <div class="page-header">
    <div class="row">
      <h1 class="col-xs-12 col-sm-4 text-center text-left-sm">
        <i class="fa fa-dashboard page-header-icon">
        </i>&nbsp;&nbsp;Leave Adjustment Add
      </h1>
      <div class="col-xs-12 col-sm-8">
        <div class="row">
          <hr class="visible-xs no-grid-gutter-h">
        </div>
      </div>
    </div>
    
    <div class="row ">
      <div class="col-sm-12">
       
              <div id="dashboard-recent" class="panel-warning">
                <div class="panel">
                  <div class="panel-heading">
                    <strong>Leave Adjustment Add </strong>
                  </div>
                  <div class="panel-body">                     
                    <div class="panel-padding no-padding-vr">                       
                        <div class="portlet-body form">
                         <form id="forms" name="forms" action="<?=base_url($currentModule.'/leave_adjustment_submit')?>" method="POST" enctype="multipart/form-data">
						 
                            <div class="form-body">
                              <div class="row"> 
                             
                                  <label class="col-md-2">Select School</label>
                                  <div class="col-md-2" >
                                    <select class="select2me form-control" name="emp_school" onchange="getstaffdept_using_school(this.value)" id="emp_school" >
                                      <option value="">Select School
                                      </option>
                                      <?php foreach($school_list as $sc) { echo "<option  value=".$sc['college_id'].">".$sc['college_name']."</option>"; } ?>
                                    </select>
                                  </div>
                                
                                  <label class="col-md-2 control-label">Select Department  
                                  </label>
                                  <div class="col-md-2">
                                    <select class="form-control select2me" id="department"   name="department" >
                                      <option value="">Select Department
                                      </option>
                                    </select>
                                  </div>
                                <label class="col-md-1 control-label">Date
                                  </label>
                                  <div class="col-md-2">
                                    <input type="text" id="sdate" name="sdate" class="form-control" value="" />
                                  </div>
                                  <div class=" col-md-1">
                                    <button type="button" id="serbtn" class="btn btn-primary form-control" >View
                                    </button>
                                  </div>
                                
                              </div>
                            </div>
                            
						  <div class="row table-info" style="height:500px;overflow-y: scroll;">
						   <table cellpadding="0" cellspacing="0"   class="table table-bordered" >
                                <thead>
                                  <tr >
                                    <td ><input type='checkbox'  name="emp_chk_all" onclick='check_all()'></td>
									<td >Sr No.</td>
									<td >Emp Id</td>
									<td >Name</td>
									<td >Designation</td>
									<td >Time</td>
									</tr>
						  </thead>
						  <tbody id="empd">
						  
						  </tbody>
						  </table>
						  </div>
						  
						  <div class="form-group">
                                  <label class="col-md-2">Select Adjustment For</label>
                                  <div class="col-md-2" >
						  <select class="form-control" required onchange="display_div(this.value)" name="adjfor">
						  <option value="">Select </option>						  
						  <option value="BL">Bus Late</option> 
						   <option value="SP">Special Case</option> 
						  </select>
						  </div>
              <div id="typc" style="display:none;">
<label class="col-md-1">Punching</label>
<div class="col-md-2"><select class="form-control" name="punch_typ"><option value="">Select</option><option value="IN">In-Time</option><option value="OUT">Out-Time</option></select></div>
              </div>
						  <label class="col-md-2">Remark</label>
						  <div class="col-md-3" >
						  <textarea name="remark" class="form-control"></textarea>
						  </div>
						  </div>
						     <div class="form-group">
							  <label class="col-md-2">Status</label>
                                  <div class="col-md-3" >
						  <select class="form-control" required name="status">
						  <option value="">Select </option>						  
						  <option value="Pending">Pending</option> 
						   <option value="Approved">Approved</option>   <option value="Rejected">Rejected</option> 
						  </select>
						  </div>
							
						   <label class="col-md-3">Do you want to upload a file?</label>
						   <div class="col-md-1"><input type="checkbox" onclick="display_file()" name="chkf" value="1" /></div>
						  <div class="col-md-3" id="disf" style="display:none"><input type="file" name="upfile" class="form-control" /></div>
						  </div>
              <div class="form-group">
 <label class="col-md-2">Approved By</label>
                                  <div class="col-md-3" >
<select class="form-control" required name="app_by">
              <option value="">Select </option>             
              <option value="T">Transport Dept.,SF</option> 
               <option value="R">Registrar, SUN</option> 
               <option value="V">Vice Chancellor, SUN</option> 
              </select>
                                  </div>
              </div>
						   <div class="form-group">
						   <div class=" col-md-3"></div>
                               <div class=" col-md-2">
                                    <button type="submit" class="btn btn-primary form-control" >Submit
                                    </button>
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
<script type="text/javascript">
function display_div(e){
  //alert(e);
  if(e=='SP'){
    $('#typc').show();

  }else{
    $('#typc').hide();
  }
}
 $("#sdate").datepicker({       
           autoclose: true,
      format: 'dd-mm-yyyy'
       });
 function display_file(){
	 if($('input:checkbox[name="chkf"]').prop("checked")) {
	$('#disf').show();	
	 } else {
    $('#disf').hide();	
            }   
 }
function check_all(){
	//alert('ll');
	  if($('input:checkbox[name="emp_chk_all"]').prop("checked")) {
	$('input:checkbox[name="empsid[]"]').prop('checked', true);	
	 } else {
     $('input:checkbox[name="empsid[]"]').prop('checked', false);	
            }    
}
  $(document).ready(function(){
   $("#serbtn").click(function(e) {
	  //alert('ll');
	  var e = document.getElementById("emp_school");
var school_id = e.options[e.selectedIndex].value;
 var d = document.getElementById("department");
var dept_id = d.options[d.selectedIndex].value;
var sdate = $('#sdate').val();
var post_data='';
if(school_id!=null && dept_id!=null){
               
        post_data+="&school="+school_id+"&department="+dept_id+"&sdate="+sdate;
        
      }
      $.ajax({
        type: "POST",
        url: base_url+"Leave/getEmpListbyDepartmentSchool",
        data: encodeURI(post_data),
        success: function(data){
         // alert(data);
        $('#empd').html(data);
        
            } 
      });
    });
       $('#forms').on('submit', function() {
		   //alert('gg');
var favorite = [];
$.each($("input[name='empsid[]']:checked"), function(){            
                favorite.push($(this).val());
            });
			var fLen = favorite.length;
			 if(fLen == 0){
                alert('Select Employees.');
            return false;
            
            }

	   });	   
  });
</script> 
