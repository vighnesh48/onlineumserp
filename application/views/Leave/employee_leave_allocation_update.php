<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
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
}
</style>
<script>
    $(document).ready(function()
    {
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
                 <?php 	 $ltyp = $this->load->leave_model->get_employee_leave_type($emp_leave_allocation[0]['employee_id']); 
                 foreach($ltyp as $val){ 
if($val['leave_type']!='VL'){
                  ?>
                 no_leave_allocate_<?php echo $val['leave_type']; ?>:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'No leave allocate should not be empty'
                      }
                    }
                },
            remark_<?php echo $val['leave_type']; ?>:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Remark should not be empty'
                      }
                    }
                },
			<?php } } ?>	
            }       
        })
    });
</script>
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
  <ul class="breadcrumb breadcrumb-page">
    <div class="breadcrumb-label text-light-gray">You are here: </div>
    <li><a href="#">Leaves</a></li>
    <li class="active"><a href="#">Employee Leave Allocation</a></li>
  </ul>
  <div class="page-header">
    <div class="row">
      <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Employee Leave Allocation</h1>
      <div class="col-xs-12 col-sm-8">
        <div class="row">
          <hr class="visible-xs no-grid-gutter-h">
        </div>
      </div>
    </div>
    <div class="row ">
      <div class="col-sm-12">&nbsp;</div>
    </div>
    <div class="row ">
      <div class="col-sm-12">
        <div class="panel">
          <div class="panel-body">
            <div class="table-info">
              <div id="dashboard-recent" class="panel-warning">
                <div class="panel">
                  <div class="panel-heading"><strong>Employee Leave Allocation</strong></div>
                  <div class="panel-body"> <span id="flash-messages" style="color:red;padding-left:110px;"><?php echo $this->session->flashdata('message1'); ?></span>
                    <div class="panel-padding no-padding-vr">
                      <div class="form-group">
                        <div class="row"></div>
                        <div class="portlet-body form">
                          <form id="form" name="form" action="<?=base_url($currentModule.'/update_employee_leave_allocation_submit')?>" method="POST" enctype="multipart/form-data">
                            <div class="form-body">
                              <div class="form-group">
                                <label class="col-md-2">Academic Year</label>
                                <div class="col-md-4" >
                                  <select class="select2me form-control" name="year">
                                    <option value="">Select</option>
                                    <option <?php if($emp_leave_allocation[0]['academic_year']=="2016-17"){echo 'Selected' ; } ?> value="2016-17">2016-17</option>
                                    <option <?php if($emp_leave_allocation[0]['academic_year']=="2017-18"){echo 'Selected' ; } ?> value="2017-18">2017-18</option>
                                    <option <?php if($emp_leave_allocation[0]['academic_year']=="2018-19"){echo 'Selected' ; } ?> value="2018-19">2018-19</option>
                                  <option <?php if($emp_leave_allocation[0]['academic_year']=="2019-20"){echo 'Selected' ; } ?> value="2019-20">2019-20</option>
								    <option <?php if($emp_leave_allocation[0]['academic_year']=="2020-21"){echo 'Selected' ; } ?> value="2020-21">2020-21</option>
									  <option <?php if($emp_leave_allocation[0]['academic_year']=="2021-22"){echo 'Selected' ; } ?> value="2021-22">2021-22</option>
									    <option <?php if($emp_leave_allocation[0]['academic_year']=="2022-23"){echo 'Selected' ; } ?> value="2022-23">2022-23</option>
										  <option <?php if($emp_leave_allocation[0]['academic_year']=="2023-24"){echo 'Selected' ; } ?> value="2023-24">2023-24</option> 
										  <option <?php if($emp_leave_allocation[0]['academic_year']=="2024-25"){echo 'Selected' ; } ?> value="2024-25">2024-25</option>
                                
                                  </select>
                                </div>
                                <label class="col-md-1">Staff Id</label>
                                <div class="col-md-4" >
                                  <input type="text" class="form-control" readonly name="staffid" value="<?=isset($emp_leave_allocation[0]['employee_id'])?$emp_leave_allocation[0]['employee_id']:''?>" id="staffid" />
                                </div>
                              </div>
                              
                              <div class="form-group">
                                <div class="" >
                                  <?php $ltyp = $this->load->leave_model->get_employee_leave_type($emp_leave_allocation[0]['employee_id'],$emp_leave_allocation[0]['academic_year']); 
	?>
                                  <table class="table table-bordered">
                                    <tr  class="warning">
                                      <th scope="col">Leave Type</th>
                                      <th scope="col">No. of Leave Assign</th>
                                     
                                      <th scope="col">Remark</th>
                                    </tr>
                                    <?php 
//print_r($ltyp);
                                    foreach($ltyp as $val){ 
if($val['leave_type']=='VL'){
                 // echo $val['vl_id'];
            $cnt = $this->leave_model->get_vacation_leave_list('',$val['vl_id']);
          }
                                      ?>                                    
                                      <tr>
                                      <?php if($val['leave_type']=='VL'){ ?>
                                        <td><?php echo $val['leave_type']." - ".$cnt[0]['slot_type']; ?></td>
                                        <?php }else{ ?>
 <td><?php echo $val['leave_type']; ?></td>
                                        <?php } ?>
                                        <td><input type="text" <?php if($val['leave_type']=='VL'){ echo 'readonly'; } ?> class="form-control" name="no_leave_allocate_<?php echo $val['leave_type']; ?>" value="<?=isset($val['leaves_allocated'])?$val['leaves_allocated']:''?>"/></td>
                                     
                                        <td><textarea name="remark_<?php echo $val['leave_type']; ?>" <?php if($val['leave_type']=='VL'){ echo 'readonly'; } ?> class="form-control" rows="2" style="height:32px"><?=isset($val['remark'])?$val['remark']:''?>
</textarea></td>
                                      </tr>
                                   
                                    <?php }
	?>
                                  </table>
                                </div>
                              </div>
                              <div class="form-group">
                                <div class="col-md-3" ></div>
                                <div class=" col-md-2">
                                  <button type="submit" class="btn btn-primary form-control" >Submit</button>
                                </div>
                                                                    <div class="col-sm-2"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule)?>/employee_leave_allocation'">Cancel</button></div>
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
    </div>
  </div>
</div>
<script type="text/javascript">
$(document).ready(function() {
	
	$("#semp").click(function() {
		alert('gg');
	var post_data = $('#staffid').val();
	jQuery.ajax({
				type: "POST",
				url: base_url+"leave/get_emp_code/"+post_data,
				
				success: function(data){
				//	alert(data);          
            $('#emptab').html(data);
         
				}	
			});
	});

    $("#etable td").click(function() {
        alert("You clicked my <td>! My TR is:");
        //get <td> element values here!!??
    });
});
</script> 
