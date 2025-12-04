<script src="<?php base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?php site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?php site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?php site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<style>
a {
  color: #fff;
}
.dropdown dd,
.dropdown dt {
  margin: 0px;
  padding: 0px;
}
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
  width: 195px; border: 1px solid #aaa;
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
  padding: 2px 15px 2px 5px;  
  top: 2px;
  width:100%;
  list-style: none;
  height: 100px;
  overflow-y:scroll; border: 1px solid #aaa;
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
</style>
 <script type="text/javascript">
$(document).ready(function(){
	$('#dob-datepicker').datepicker( {format: "yyyy-m",startView: "months",minViewMode: "months",autoclose:true});	    
});
$(document).ready(function()
    { 
  $(".dropdown dt a").on('click', function() {
  $(".dropdown dd ul").slideToggle('fast');
});

$(".dropdown dd ul li a").on('click', function() {
  $(".dropdown dd ul").hide();
});

function getSelectedValue(id) {
  return $("#" + id).find("dt a span.value").html();
}
$(document).bind('click', function(e) {
  var $clicked = $(e.target);
  if (!$clicked.parents().hasClass("dropdown")) $(".dropdown dd ul").hide();
});
  });
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
  } else {
    $('span[title="' + title + '"]').remove();
    var ret = $(".hida");
    $('.dropdown dt a').append(ret);
  }
//});
}
</script>
<?php   $astrik='<sup class="redasterik" style="color:red">*</sup>'; ?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="#">Monthly Leave Report</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Monthly Leave Report</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                </div>
            </div>
        </div>      
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-heading"><strong>Monthly Leave Report</strong></div>
                    <div class="panel-body">
					   <span id="flash-messages" style="color:red;padding-left:110px;"><?php  echo $this->session->flashdata('message1'); ?></span>
                        <div class="table-info">
                            <form id="form" name="form" action="<?php echo base_url($currentModule);?>/generate_leave_report" method="POST" enctype="multipart/form-data">
							<div class="form-group">
                <label class="col-md-3">Select School</label>
                                             <div class="col-md-3" >
                       <select class="select2me form-control" name="emp_school" onchange="getstaffdept_using_school(this.value)" id="emp_school" >
                       <option value="">Select School</option>
                       <?php 
					   foreach($school_list as $sc) {
                         echo "<option  value=".$sc['college_id'].">".$sc['college_name']."</option>";
                       } ?>                      
                         </select>
                                       </div>
                                  </div>
								  <div class="form-group">
                <label class="col-md-3 control-label">Department:</label>
                            <div class="col-md-3">
                          <select class="form-control select2me" id="department"  onchange="getEmp_using_sch_dep(this.value)" name="department" >
                      <option value="">Select</option>
                      </select>                                       </div>
                                  </div>
                       <div class="form-group">
								<label class="col-md-3">Select Month <?=$astrik?></label>
                                             <div class="col-md-3" >
                          <input id="dob-datepicker" required class="form-control form-control-inline  date-picker" name="attend_date" value="" placeholder="Enter Month" type="text">
                                             </div>
											 </div>
											 <div class="form-group">
                <label class="col-md-3 control-label">Leave Type:</label>
                            <div class="col-md-3">
                          <select class="form-control select2me" id="leavetyp" name="leavetyp" >
                      <option value="">Select</option>
					  <option value="Leave">Leave</option>
					  <option value="OD">OD</option>
                      </select>                                       </div>
                                  </div>							  
											 <div class="form-group">					 
                                <label class="col-md-3">Select Employee</label>
                                <div class="col-md-3">                
                <dl class="dropdown">  
    <dt>
    <a href="#">
      <span class="hida">Select</span>    
      <div class="multiSel"></div>  
    </a>
    </dt>  
    <dd>
        <div class="mutliSelect" id="mutliSelect">
            <ul id="empid">
			 <li><input type='checkbox'  name="emp_chk_all" onclick='onclick_checkbox_emp()'>Select All </li>
      <?php 
      //print_r($emp_list);
      foreach($emp_list as $key=>$val){ 
               echo '<li>
          <input type="checkbox" name="empsid[]" id="'.$emp_list[$key]['emp_id'].'" onclick="onclick_checkbox_emp('.$emp_list[$key]['emp_id'].');" value="'.$emp_list[$key]['emp_id'].'" /> '.$emp_list[$key]['emp_id'].' - '.$emp_list[$key]['fname'].' '.$emp_list[$key]['lname'].' </li>';                   
       } ?> 
            </ul>
        </div>
    </dd>  
</dl>                         
                </div>
                              </div>  

											  <div class="form-group">
											  <div class="col-md-3"></div>
											  <div class="col-md-2" >
                            <button type="submit" class="btn btn-primary form-control" >Submit</button>
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