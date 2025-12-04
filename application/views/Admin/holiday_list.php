<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<script>    
     $(document).ready(function()
    {
        $('#formh').bootstrapValidator
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
                order_ref_no:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Order Referance No should not be empty'
                      }
                    }
                },
                order_date:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Order name should not be empty'
                      }
                    }
                },
				occasion:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Occasion should not be empty'
                      }
                    }
                },
				frm_date:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Form date should not be empty'
                      }
                    }
                },
                to_date:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'To Date should not be empty'
                      }
                    }
                },
				approved_by:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Select Approved By'
                      }
                    }
                }
            }       
        })
		
});
</script>
<style type="text/css">
table{max-width:100%}
</style>
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
  <ul class="breadcrumb breadcrumb-page">
    <div class="breadcrumb-label text-light-gray">You are here: </div>
    <li><a href="#">Masters</a></li>
    <li class="active"><a href="#">Holiday List</a></li>
  </ul>
  <div class="page-header">
    <div class="row">
      <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Holiday List</h1>
      <div class="col-xs-12 col-sm-8">
        <div class="row">
         <div class="form-group">
         <?php //print_r($my_privileges);
                    if(in_array("Add", $my_privileges)) { ?>
                <div class="text-right">
                  <button id="addholiday" class="btn btn-primary btn-labeled"> <i class="fa fa-plus"></i> Add Holiday</button>
                </div>
                <?php } ?>
              </div>
          <hr class="visible-xs no-grid-gutter-h">
        </div>
      </div>
    </div>
    
    <div class="row ">
      <div class="col-sm-12">
       
            <div class="table-info"> 
              <!-- <form id="form" name="form" action="<?//=base_url($currentModule.'/submit')?>" method="POST">  -->
              <input type="hidden" value="" id="campus_id" name="campus_id" />
              
              <!--<div class="form-group">
                                    
                                    <label class="col-sm-2">Admission Date <?=$astrik?></label>
                                    <div class="col-sm-4">
                                    <div id="bs-datepicker-component" class="input-group date">
                                        <input type="text" id="po_date" class="form-control"><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
                                    </div>
                                </div>--> 
              <!--<div class="form-group">               
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('campus_state');?></span></div>
                                </div>-->
              
             
              
              <div id="dashboard-recent" class="panel-warning">
              <div class="panel" id="addform" style="display:none;">
    <div class="panel-heading"><strong>Add Holiday</strong></div>
    <div class="panel-body">
    <div class="col-lg-6">
                <form id="formh" name="form" action="<?=base_url($currentModule.'/add_holiday')?>" method="POST" enctype="multipart/form-data">
                  <div class="form-body">
                      <div class="form-group">
                      <label class="col-md-4">Academic Year</label>
                      <div class="col-md-8">
                        <select name="academic_year" class="form-control">
                                    <option <?php if($this->config->item('current_year')=='2016-17') { echo 'selected'; } ?> value="2016-17">2016-17</option>
                                    <option <?php if($this->config->item('current_year')=='2017-18') { echo 'selected'; } ?> value="2017-18">2017-18</option>
                                    <option <?php if($this->config->item('current_year')=='2018-19') { echo 'selected'; } ?> value="2018-19">2018-19</option>
                                    <option <?php if($this->config->item('current_year')=='2019-20') { echo 'selected'; } ?> value="2019-20">2019-20</option>
			                        <option <?php if($this->config->item('current_year')=='2020-21') { echo 'selected'; } ?> value="2020-21">2020-21</option>
                                    <option <?php if($this->config->item('current_year')=='2021-22') { echo 'selected'; } ?> value="2021-22">2021-22</option>
                                    <option <?php if($this->config->item('current_year')=='2022-23') { echo 'selected'; } ?> value="2022-23">2022-23</option>
									 <option <?php if($this->config->item('current_year')=='2023-24') { echo 'selected'; } ?> value="2023-24">2023-24</option>
                                      <option <?php if($this->config->item('current_year')=='2024-25') { echo 'selected'; } ?> value="2024-25">2024-2025</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-4">Order Referance No:</label>
                      <div class="col-md-8" >
                        <input id="orderrefno" class="form-control form-control-inline xinput-medium" name="order_ref_no" value="" placeholder="Enter Referance No" type="text">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-4">Order Date:</label>
                      <div class="col-md-8" >
                        <input id="dob-datepicker1" class="form-control form-control-inline xinput-medium date-picker" name="order_date" value="" placeholder="Enter Order Date" type="text">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-4">Occasion</label>
                      <div class="col-md-8">
                        <input class="form-control form-control-inline" name="occasion" placeholder="Occasion" type="text">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-4">Occasion Date:</label>
                      <div class="col-md-4" >
                        <input id="dob-datepicker" class="form-control form-control-inline  date-picker" name="frm_date" value="" placeholder="Enter from Date" type="text">
                      </div>
                      <div class="col-md-4">
                        <input id="dob-datepicker2" class="form-control form-control-inline  date-picker" name="to_date" value="" placeholder="Enter To Date" type="text">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-4">Approved By</label>
                      <div class="col-md-8">
                        <select name="approved_by" class="form-control">
                          <option value="">Select</option>
                          <option value="management">Management</option>
                          <option value="university">University</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-4">Relax Day</label>
                      <div class="col-md-8">
                        <input type="checkbox" name="rday" value="Y"> Yes &nbsp;
						<input type="checkbox" name="rday" value="N"> No
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-4">Applicable For</label>
                      <div class="col-md-8">
                          <select  class="form-control" required name="applicable_for" id="applicable">
                             <option value="">Select</option>
                          <option  value="Teaching+Technical">Teaching+Technical</option>   
                          <option  value="Non-Technical">Non-Technical</option>
                           <option  value="Teaching+Technical+Non-Teaching">Teaching+Technical+Non-Teaching</option>
                          <!--<option  value="Teaching">Teaching</option>
                          <option  value="Technical">Technical</option>-->
                         
                          <!--<option  value="Non-Teaching+IC-Staff">Non-Teaching+IC-Staff</option>-->
                          <option  value="IC-Staff-HO">IC-Staff-Ho</option>
                          <option  value="All">ALL</option>
                          </select>     
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-md-4" ></div>
                      <div class=" col-md-4">
                        <button type="submit" class="btn btn-primary form-control" >Submit</button>
                      </div>
                      <div class=" col-md-4">
                        <button type="button" id="close_frm" class="btn btn-primary form-control" >Close</button>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
              <div class="col-lg-6"> <div id="empt"></div></div>
    </div>
  </div>
              
              </div>
              
              
              
              <div id="dashboard-recent" class="panel-warning">
                <div class="panel">
                  <div class="panel-heading">
                   <div class="row ">
<form id="form" name="form" action="<?=base_url($currentModule.'/holiday_list')?>" method="POST">
<div class="col-md-6"><b style="color:Purple;">For Academic Year <?=$year?>                          
                          </b></div>
                          <div class="col-md-2"></div>
                          <div class="col-sm-2" id="month" style="">
                               <select name="search_dt1" class="form-control">
                                   <option value="">Select</option>
                                   <option <?php if($year=='2015-16') { echo 'selected'; } ?> value="2015-16">2015-2016</option>
                                   <option <?php if($year=='2016-17') { echo 'selected'; } ?> value="2016-17">2016-2017</option>
                          <option <?php if($year=='2017-18') { echo 'selected'; } ?> value="2017-18">2017-2018</option>
                          <option <?php if($year=='2018-19') { echo 'selected'; } ?> value="2018-19">2018-2019</option>
                            <option <?php if($year=='2019-20') { echo 'selected'; } ?> value="2019-20">2019-2020</option>
            <option <?php if($year=='2020-21') { echo 'selected'; } ?> value="2020-21">2020-2021</option>
            <option <?php if($year=='2021-22') { echo 'selected'; } ?> value="2021-22">2021-2022</option>
            <option <?php if($year=='2022-23') { echo 'selected'; } ?> value="2022-23">2022-2023</option>
			 <option <?php if($year=='2023-24') { echo 'selected'; } ?> value="2023-24">2023-2024</option>
			  <option <?php if($year=='2024-25') { echo 'selected'; } ?> value="2024-25">2024-2025</option>
                        </select>
                            <!--<input type="test" class="form-control" placeholder="Select Year " value="" name="search_dt1" id="search_dt1">-->
                          </div>
                          <div class="col-md-2">
                            <button class="btn btn-primary form-control" id="btn_submit1" type="submit">Search </button>
                          </div>
                        </form>
</div>
                  </div>
                  <div class="panel-body" style="overflow-y:scroll;height:700px;"> <span id="flash-messages" style="color:red;padding-left:110px;"><?php echo $this->session->flashdata('message1'); ?></span>
                    <div class="panel-padding no-padding-vr">                     
                          <?php
					$temp=$year; //assign year for search
				 $month_arr = array('January','February','March','April','May','June','July','August','September','October','November','December'); 
						?>
                             
                                    <div class="table-scrollable">
                                      <table class="table table-hover">
                                        <thead>
                                          <tr>
                                            <th> # </th>
                                            <th> Date </th>
                                            <th> Day </th>
                                            <th> Occasion </th>
                                            <th>Order Ref No</th>
                                            <th>Order Date</th>
                                             <th>Approved by</th><th>Applicable For</th>
                                             <th>Created On</th>
                                            <th> Action </th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                          <?php 
															$i=1;
															//echo error_reporting(E_ALL);
															date_default_timezone_set('Asia/Kolkata') ;
															$j=1;
															foreach($month_arr as $valm){
					
                                                            $month=$valm;	
															
															$hol=$this->load->Admin_model->getHolidayListMonthWise($month,$temp);
															//print_r($hol);
															//if(!empty($hol)){
																
															foreach($hol as $val){
																//print_r($val);
																if($val['to_date'] != '0000-00-00' ){
																$datetime1 = new DateTime($val['hdate']);

																$datetime2 = new DateTime($val['to_date']);

																$difference = $datetime1->diff($datetime2);
																$dcnt =  $difference->d;
																}else{
																	$dcnt = 0;
																}
																$dstr ='';
																if(!empty($val['order_ref_no'])){
																$dayl=$this->load->Admin_model->getDayofHolidays1($val['hid']);
																
																$cnt =count($dayl);
																$ed = end($dayl);
																$i=0;
																if($dcnt > 1){
																$dstr .= $dayl[0]['hday']." to ".$ed['hday'];
																}else{
																    $dstr .= $dayl[0]['hday'];
																}
															//	foreach($dayl as $dval){ $dstr .= $dval['hday']; 
																//if($i < $cnt){ $dstr .= ', ';}
															//	$i = $i+1;
															//	}
																}else{
																	$dstr =$val['hday'];
																}
																 	//print_r($dayl);
																	
																	?>
                                          <tr id="row<?php echo $i;?>" <?php if($val['is_relax_day']=='Y'){ echo "Style='background-color:#D3D3D3;'"; } ?> >
                                            <td><?php echo $j;?></td>
                                            <?php if($dcnt > 1) { ?>
                                            <td><?php echo  date("d", strtotime($val['hdate']))." to ".date("d M Y", strtotime($val['to_date'])) ;?></td>
                                            <?php }else{?>
                                            <td><?php echo  date("d M Y", strtotime($val['hdate']));?></td>
                                            <?php } ?>
                                            <td><?php echo $dstr;?></td>
                                            <td><?php echo $val['occasion'];?></td>
                                            <td><?php if(empty($val['order_ref_no'])){
																		echo '--';
																	}else{echo $val['order_ref_no'];}?></td>
                                            <td><?php 
																	if($val['order_date'] == '0000-00-00'){
																		echo '--';
																	}else{
																	echo date('d-m-Y',strtotime($val['order_date'])); }?></td>
																	<td><?php echo $val['approved_by']; ?></td>
                                    <td><?php echo $val['applicable_for']; ?></td>
																	<td><?php echo date('d-m-Y',strtotime($val['inserted_datetime'])); ?></td>
                                            <td>
                                            <?php //print_r($my_privileges);
                    if(in_array("Delete", $my_privileges)) { ?>
                                              <a href="del_holiday?id=<?php echo $val['hid'];?>" title="Delete" class=""> <i class="fa fa-trash-o"></i> </a>
                                             <?php } ?>
                                             </td>
                                              
                                          </tr>
                                          <?php $j= $j+1; } //} }else{ ?>
                                          <?php
                                          $j= $j;
                                          } //}?>
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
                
              
              <!--<div class="form-group">
                                    <div class="col-sm-4"></div>
                                    <div class="col-sm-2">
                                        <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Submit</button>                                        
                                    </div>                                    
                                    <div class="col-sm-2"><button class="btn btn-primary form-control" id="btn_cancel" type="button">Cancel</button></div>
                                    <div class="col-sm-4"></div>
                                </div>-->
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  
<script type="text/javascript">
$(document).ready(function(){
	var current_year=new Date().getFullYear(); //get current year
	//alert(current_year);
	$('#dob-datepicker').datepicker( {format: 'yyyy-mm-dd',autoclose: true,startDate: new Date(current_year-1, 0, 1)});
	$('#dob-datepicker1').datepicker( {format: 'yyyy-mm-dd',autoclose: true,startDate: new Date(current_year-1, 0, 1)});
	$('#dob-datepicker2').datepicker( {format: 'yyyy-mm-dd',autoclose: true,startDate: new Date(current_year-1, 0, 1)});
	
	$("#addholiday").click(function(){
        $("#addform").toggle();
    });
	$("#close_frm").click(function(){
        $("#addform").hide();
		$("#formh").trigger('reset');
    });
	$('#search_dt1').datepicker( {format: 'yyyy',viewMode: 'years',minViewMode: 'years',startDate: '2016',autoclose: true});
	$('#dob-datepicker').datepicker( {format: 'yyyy-mm-dd'});
	var content = '<tr>'+$('#eduDetTable tbody tr').html()+'</tr>';
	$("#eduDetTable").on("click","input[name='addMore']", function(e){	
	//$("input[name='addMore']").on('click',function(){		
		//var content = $(this).parent().parent('tr').clone('true');
		$(this).parent().parent('tr').after(content);		
	});
	$("#eduDetTable").on("click","input[name='remove']", function(e){	
	//$("input[name='remove']").on('click',function(){
		var rowCount = $('#eduDetTable tbody tr').length;
		if(rowCount>1){
			$(this).parent().parent('tr').remove();
		}
	});	
  $('#applicable').change(function () {
   
   
    /*if($(this).val() == 'Teaching+Technical'){
      var tp = 'tt';
    }else{*/
      var type = encodeURIComponent($(this).val());
  //  }
     var url  = "<?=base_url().strtolower($currentModule).'/get_emp_list_bystafftyp/'?>";  
     $.ajax
            ({
                type: "POST",
                url: url,
                 data: "type="+type,
                dataType: "html",
                cache: false,
                crossDomain: true,
                success: function(data)
                {          
                        $("#empt").html(data);                  
                },
                error: function(data)
                {
                    alert("Page Or Folder Not Created..!!");
                }
            });
  });
});
</script>