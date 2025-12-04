<?php ini_set('max_input_vars', 3000); ?>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="http://demos.codexworld.com/includes/js/bootstrap.js"></script>
<style>
.attexl table{
   border: 1px solid black;
}
.attexl table th{
 border: 1px solid black;
    padding: 5px;
    background-color:grey;
    color: white;
}
.attexl table td{
   border: 1px solid black;
    padding: 5px;border-collapse: collapse
}
.add-table{border:0px!important}
.add-table tr td{border:0px}
.add-table tr td > h3{margin-top:0;margin-bottom:0;font-weight:bold;line-height:0.5}
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
  padding: 2px 15px 2px 5px; 
  top: 2px;
  width:100%;
  list-style: none;
  height: 550px;
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
.inp{width:250px;}
</style>
<script>
getstaffdept_using_school('<?php echo $emp_school ?>','<?php echo $department ?>');
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
}

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
  
</script>
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Attendance</a></li>
        <li class="active"><a href="#"> <?php if(isset($type) && $type=='resign'){ ?>Employee Resignation  <?php } else { ?>Employee Status <?php } ?> </a></li>
    </ul>
    <div class="page-header">     
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;<?php if(isset($type) && $type=='resign'){ ?>Employee Update Resignation  <?php } else { ?>Employee Status Change  <?php } ?></h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-sm-12">&nbsp;</div>
        </div>
<?php if (isset($_SESSION['status'])): ?>
    <script type="text/javascript">
        var status = '<?php echo $_SESSION['status']; ?>';
        alert(status);
        <?php unset($_SESSION['status']); ?>
    </script>
<?php endif; ?>
        <div class="row ">
            <div class="col-sm-12">                
                        <div class="table-info">               
                                                               
                             <div id="dashboard-recent" class="panel-warning">   
                               <div class="panel">
							   <?php if(isset($type) && $type=='resign'){ ?>
                              <div class="panel-heading"><strong>Employee Multiple Resignation </strong></div>
							   <?php } else { ?>
							    <div class="panel-heading"><strong>Employee Status Change (Active / Inactive)</strong></div>
							   <?php } ?>
                                <div class="panel-body">
                                    <span id="flash-messages" style="color:red;padding-left:110px;"><?php echo $this->session->flashdata('message1'); ?></span>
                                <div class="panel-padding no-padding-vr">
                            <div class="form-group">                            
								<div class="portlet-body form">
								<?php if(isset($type) && $type=='resign'){ ?>
								<form id="form" name="form" action="<?=base_url($currentModule.'/emp_multi_resign_update')?>" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">								
								<?php } else { ?>
								  <form id="form" name="form" action="<?=base_url($currentModule.'/emp_multi_status_change')?>" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">	
								<?php } ?>
								<div class="form-body">
                                  <div class="col-md-6">  
									<div class="form-group">
										<label class="col-md-3">Employee:<?=$astrik?></label>
										<div class="col-md-6">
											<dl class="dropdown">
												<dt>
													<a href="#">
														<span class="hida">Select</span>
														<div class="multiSel"></div>
													</a>
												</dt>
												<dd>
													<div class="mutliSelect" id="mutliSelect">
														<input type="text" id="empSearch" onkeyup="filterEmployees()" placeholder="Search for employees..." class="form-control" style="margin-bottom: 10px;">
														<ul id="empid">
															<li>
																<input type='checkbox' name="emp_chk_all" onclick='check_all()'> Select All
															</li>
															<?php 
															foreach($all_attend as $empl){ 
																$emph[] = $empl['emp_id'];
															}
															$kk = 0;
															foreach($emp_list as $key => $val){ 
																$sel = in_array($emp_list[$key]['emp_id'], $emph) ? 'checked="checked"' : '';
																echo '<li>
																	<input type="checkbox" name="empsid[]" id="'.$emp_list[$key]['emp_id'].'" onclick="onclick_checkbox_emp('.$emp_list[$key]['emp_id'].');" value="'.$emp_list[$key]['emp_id'].'" '.$sel.' /> '.$emp_list[$key]['emp_id'].' - '.$emp_list[$key]['fname'].' '.$emp_list[$key]['lname'].'
																</li>';
																$kk++;
															} 
															?>
														</ul>
													</div>
												</dd>
											</dl>
										</div>
									</div>							  
                                  </div>  
                                    <div class="col-md-6"<?php if(isset($type) && $type=='resign'){ echo 'style="display:none"';}?>>
									  <div class="form-group">
									<label class="col-md-3"> Status <?=$astrik?></label>
										<div class="col-md-6">                
	                                     <select id="status" name="status" class="form-control" > 
										 <option value="">Select Status</option>
										 <option value="Y">Active</option>
										 <option value="N">Inactive</option>
										 <option value="E">Enabled</option>
										 <option value="D">Disabled</option>
										 </select>                    
                                          </div>
                                      </div>    
                                  </div>
								  <div class="col-md-6" <?php if(empty($type)){ echo 'style="display:none"';}?>>
									<div class="form-group">
									  <label class="col-md-3"> Resignation date <?=$astrik?></label>
										<div class="col-md-6">                
	                                      <input type="text" id="res_date" name="res_date" class="form-control">                  
                                          </div>
                                      </div>   
									  <div class="form-group">
									  <label class="col-md-3"> Resignation Reason <?=$astrik?></label>
										<div class="col-md-6">                
	                                      <textarea id="res_reason" name="res_reason" class="form-control"></textarea>                  
                                          </div>
                                      </div> 
                                  </div>
                                        								  
                                   <div class="form-group">
                                 <div class="col-md-5" ></div>
								  <div class=" col-md-2">  
										<button type="submit" name="submit" class="btn btn-primary form-control" >Submit</button>
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
</div>    
<script type="text/javascript">
function check_all(){
    if($('input:checkbox[name="emp_chk_all"]').prop("checked")) {
  $('input:checkbox[name="empsid[]"]').prop('checked', true);
  
  $('.emp_amty').prop('disabled',false);
   } else {
     $('input:checkbox[name="empsid[]"]').prop('checked', false);
   $('.emp_amty').prop('disabled',true);
            }    
}
$(document).ready(function(){
var type='';
	    <?php if(isset($type) && $type != '') { ?>
        type = "<?= $type ?>";
    <?php } ?>
	   $("#res_date").datepicker({       
           autoclose: true,
      format: 'yyyy-mm-dd'
       }).on('changeDate', function (e) {  
  });  
   if (type != 'resign') {
        $('#status').attr('required', 'required');
        $('#res_date').removeAttr('required');
        $('#res_reason').removeAttr('required');
    } else {
        $('#status').removeAttr('required');
        $('#res_date').attr('required', 'required');
        $('#res_reason').attr('required', 'required');
    }
  
});

function filterEmployees() {
    var input, filter, ul, li, a, i, txtValue;
    input = document.getElementById('empSearch');
    filter = input.value.toUpperCase();
    ul = document.getElementById("empid");
    li = ul.getElementsByTagName('li');

    for (i = 0; i < li.length; i++) {
        a = li[i].getElementsByTagName("label")[0];
        txtValue = li[i].textContent || li[i].innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            li[i].style.display = "";
        } else {
            li[i].style.display = "none";
        }
    }
}

function validateForm() {
    var type = '';
    <?php if(isset($type) && $type != '') { ?>
        type = "<?= $type ?>";
    <?php } ?>

    const selectedEmployees = document.querySelectorAll('input[name="empsid[]"]:checked').length;
    const selectedStatus = document.getElementById('status').value;
    const selectedDate = document.getElementById('res_date').value;
    const selectedReason = document.getElementById('res_reason').value;

    if (selectedEmployees === 0) {
        alert("Please select at least one employee.");
        return false;
    }

    if (type != 'resign') {
        $('#status').attr('required', 'required');
        $('#res_date').removeAttr('required');
        $('#res_reason').removeAttr('required');

        if (selectedStatus === "") {
            alert("Please select a status.");
            return false;
        }
    } else {
        $('#status').removeAttr('required');
        $('#res_date').attr('required', 'required');
        $('#res_reason').attr('required', 'required');

        if (selectedDate === "") {
            alert("Please select a Date.");
            return false;
        }

        if (selectedReason === "") {
            alert("Please Enter a Reason.");
            return false;
        }
    }

    return confirm("Are you sure you want to proceed?");
}

</script>