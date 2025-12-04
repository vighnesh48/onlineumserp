<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>

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
                lname:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Last name should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[a-zA-Z-/]+$/,
                        message: 'Last name should be alphabate characters'
                      },
                      stringLength: 
                        {
                        max: 50,
                        min: 2,
                        message: 'Last name should be 2-50 characters'
                        }
                    }
                }
              
            }       
        })
		
});
    });
</script>
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="#">View od Status</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;View od Status</h1>
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
					   <span id="flash-messages" style="color:red;padding-left:110px;"><?php echo $this->session->flashdata('message1'); ?></span>
                        <div class="table-info">
                         
                         <div id="dashboard-recent" class="panel-warning">   
                               <div class="panel">
                            	<div class="panel-heading"><strong>OD Status</strong></div>
                                <div class="panel-body">
                                <div class="table-responsive">
							<?php // print_r($od);?>
							 <table style="width: 1040px;" aria-describedby="applications_info" role="grid" 
							  class="table table-striped table-bordered table-hover no-footer" id="applications">
							  <!-- class='dataTable' for sorting arrows icon for col-->
                                     <thead>
                                    <tr role="row">
									<th aria-label="ID: activate to sort column ascending" style="width: 80px;" colspan="1" rowspan="1" aria-controls="applications" tabindex="0" class="center sorting">Sr No.</th>
									<th aria-label="ID: activate to sort column ascending" style="width: 80px;" colspan="1" rowspan="1" aria-controls="applications" tabindex="0" class="center sorting">OD ID</th>
									<th aria-label="Name: activate to sort column ascending" aria-sort="ascending" style="width: 103px;" colspan="1" rowspan="1" aria-controls="applications" tabindex="0" class="center sorting_asc">Name</th>
									<th aria-label="Date: activate to sort column ascending" style="width: 99px;" colspan="1" rowspan="1" aria-controls="applications" tabindex="0" class="center sorting">From Date/Departure Time</th>
									<th aria-label="Date: activate to sort column ascending" style="width: 99px;" colspan="1" rowspan="1" aria-controls="applications" tabindex="0" class="center sorting">To Date/Arrival Time</th>
									<th aria-label="Date: activate to sort column ascending" style="width: 99px;" colspan="1" rowspan="1" aria-controls="applications" tabindex="0" class="center sorting">Days/Hrs</th>
									<th aria-label="od Type: activate to sort column ascending" style="width: 122px;" colspan="1" rowspan="1" aria-controls="applications" tabindex="0" class="center sorting">OD Type</th>
									<th aria-label="od Type: activate to sort column ascending" style="width: 122px;" colspan="1" rowspan="1" aria-controls="applications" tabindex="0" class="center sorting">OD Duration</th>
									<th aria-label="Reason: activate to sort column ascending" style="width: 122px;" colspan="1" rowspan="1" aria-controls="applications" tabindex="0" class="center sorting">Reason</th>
									
				                 <th aria-label="Applied on: activate to sort column ascending" style="width: 116px;" colspan="1" rowspan="1" aria-controls="applications" tabindex="0" class="center sorting">Applied on</th>
									<th aria-label="Status: activate to sort column ascending" style="width: 85px;" colspan="1" rowspan="1" aria-controls="applications" tabindex="0" class="center sorting">Status</th>
									<th aria-label="Status: activate to sort column ascending" style="width: 85px;" colspan="1" rowspan="1" aria-controls="applications" tabindex="0" class="center sorting">Download Gate Pass</th>
									
									<!--<th aria-label="Action" style="width: 162px;" colspan="1" rowspan="1" class="center sorting_disabled">Action</th>-->
									</tr>
                                    </thead>
                                    <tbody>
                                   <?php if(empty($od)){?>
									<tr id="row441" class="odd" role="row">
										<td class="center" colspan=30><?php echo "No OD Applications Available"; ?></td>
										</tr>
									<?php }else{
										$i=0;
										foreach($od as $key=>$val){
											$i++;
										?>
									   <tr id="row<?php echo $i;?>" class="odd" role="row">
										<td class="center"><?php echo $i;?></td>
										<td class="center"><?php echo $od[$key]['oid'];?></td>
										<td class="center sorting_1"><?php echo $od[$key]['ename'];?></td>
										<td class="center">
						<?php
						if($od[$key]['od_duration']=='hrs'){
						echo $od[$key]['departure_time'];	
						}elseif($od[$key]['od_duration']=='full-day'){
							echo $od[$key]['applied_from_date'];
						}
							?>
											</td>
										<td class="center">
										<?php 
										if($od[$key]['od_duration']=='hrs'){
						echo $od[$key]['arrival_time'];	
						}elseif($od[$key]['od_duration']=='full-day'){
							echo $od[$key]['applied_to_date'];
						}
										?>
										</td>
										<td class="center">
										<?php
										if(isset($od[$key]['no_days']) && $od[$key]['no_days']!='0'){
											echo $od[$key]['no_days']." Days";
											}else if(isset($od[$key]['no_hrs']) && $od[$key]['no_hrs']!=''){
											echo $od[$key]['no_hrs']." Hrs.";
											}
										?>
										
										</td>
						                <td class="center"><?php echo $od[$key]['od_type'];?></td>
						                <td class="center"><?php echo $od[$key]['od_duration'];?></td>
										<td class="center"><?php echo $od[$key]['reason_od'];?></td>
										<td class="center"><?php echo $od[$key]['od_applied_on_date'];?></td>
										<td class="center">
										<?php if($od[$key]['status']=='Approved'){
											$var='label label-success';
											}elseif($od[$key]['status']=='Rejected'){ $var='label label-danger';
											}elseif($od[$key]['status']=='Pending'){ $var='label label-warning';
											}else{ $var=""; }?><span class="<?=$var;?>"><?php echo $od[$key]['status'];?></span></td>
										<td class="center">
										<?php if($od[$key]['status']=='Approved'){?>
<!--<a data-toggle="modal" data-book-id="<?=$od[$key]['oid']?>" data-target="#myModal"> View</a>-->
											<a href="<?=base_url().'employee/create_getpass?od_id='.$od[$key]['oid'].'&emp_id='.$od[$key]['emp_id']?>">GetPass</a>
											<?php }?>
                                         </td>										
										<!--<td class="center">
							<p><a style="width: 106px;" href="del_od_app?id=<?=$od[$key]['oid'];?>" class="btn btn-danger">
                        <i class="fa fa-trash"></i> Delete</a></p></td>-->
						</tr>	
										
										<?php }}?>
                          
						</tbody>

							</table>
					  </div>
					            </div>
							 <div class="form-group">
                                    <div class="col-sm-4"></div>
                                    <div class="col-sm-2">
                                        <a class="btn btn-primary form-control" id="btn_submit" type="submit" href="<?php echo base_url().'home'?>">Go Back </a>                                        
                                    </div> 
                             </div>									
                                </div>
								<!--Gate Pass-->
								<?php if(!empty($getpass_data)){ //print_r($getpass_data);?>
								
								 <div class="panel">
                            	<div class="panel-heading"><strong>Gate Pass For OD(<?php if($getpass_data[0]['od_duration']=='hrs'){
									echo"Hours";
								}elseif($getpass_data[0]['od_duration']=='full-day'){ echo"Full Days";}?>)</strong></div>
                                <div class="panel-body">
                               
							<?php 
							$str="";
							 $str="<table border='1'>";
						     $str.="<tr>
							 <th><img  src='".base_url().'assets/images/logo.jpg'."' ></th><th></th>
							 </tr>";
							$str.="<tr><td >
								<label>Mahiravani, Trimbak Road, Nashik – 422 213 </label><br>
	                            <label>Website : http://www.sandipuniversity.com <br> 
	                              Email:info@sandipuniversity.com</label><br>
                                <label>Ph: (02594) 222 541, 42, 43, 44, 45 Fax: (02594) 222 555</label>
								</td><td></td></tr>";
								
								$str.="<tr><td style='width:50%'>No:</td><td style='width:50%'>Date: ". date('d-m-Y')."</td></tr>								
								
								<tr><td style='text-align:center;padding:10px 0'><h1 style='color:red'><b>Gate Pass For OD ".strtoupper($getpass_data[0]['od_duration'])."</b></h1></td><td></td></tr><br>
								<tr><td style='padding:10px 0'><label>The Undermentioned staff member(s) of the university is/are authorized to proceed to visit as follows:</label></td><td></td></tr>
								<tr><td style='padding:10px 0'>Location :&nbsp;<b>".$getpass_data[0]['location_od']."</b></td><td style='padding:10px 0'>Purpose :&nbsp;<b>".$getpass_data[0]['reason_od']."</b></td></tr>
								<tr><td style='padding:10px 0'>From Date :&nbsp;<b>".$getpass_data[0]['applied_from_date']."</b></td><td style='padding:10px 0'>To Date :&nbsp;<b>".$getpass_data[0]['applied_to_date']."</b></td></tr>";
								if($getpass_data[0]['od_duration']=='hrs'){
						$str.="<tr><td style='padding:10px 0'>Departure Time :&nbsp;<b>".$getpass_data[0]['departure_time']."</b></td><td style='padding:10px 0'>Arrival Time :&nbsp;<b>".$getpass_data[0]['arrival_time']."</b></td></tr>";
								}							
																
								$str.="<tr><td style='padding:10px 0'>Staff ID:&nbsp;<b>".$getpass_data[0]['emp_id']."</b></td><td style='padding:10px 0'>Name :&nbsp;<b>".$getpass_data[0]['fname'].' '.$getpass_data[0]['mname'].' '.$getpass_data[0]['lname']."</b></td></tr>
								<tr><td style='padding:10px 0'>Designation:&nbsp;<b>".$getpass_data[0]['designation_name']."</b></td><td style='padding:10px 0'>Department :&nbsp;<b>".$getpass_data[0]['department_name']."</b></td></tr>
								<tr><td style='xxwidth:30%;padding:10px 0'>Signature of Employee</td> <td> Signature of HOD/Dean  </td></tr>
								<tr><td style='xxwidth:30%;padding:10px 0'>Signature of Registerar</td> <td> </td></tr>
								</table>";
							if($getpass_data[0]['od_duration']=='hrs'){ //for OD on  Movement oreder
							$str.="<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
							<table border='1'>";
						     $str.="<tr>
							 <th><img  src='".base_url().'assets/images/logo.jpg'."' ></th><th></th>
							 </tr>";
							$str.="<tr><td >
								<label>Mahiravani, Trimbak Road, Nashik – 422 213 </label><br>
	                            <label>Website : http://www.sandipuniversity.com <br> 
	                              Email:info@sandipuniversity.com</label><br>
                                <label>Ph: (02594) 222 541, 42, 43, 44, 45 Fax: (02594) 222 555</label>
								</td><td></td></tr>";
                            $str.="<tr><td style='width:50%'>SUN/Movement Order/No:</td><td style='width:50%'>Date: ". date('d-m-Y')."</td></tr>";															
							$str.="<tr><td style='text-align:center;padding:10px 0'><h1 style='color:red'><b>MOVEMENT ORDER </b></h1></td><td></td></tr><br>";
							$str.="<tr><td style='padding:10px 0'><label>The Undermentioned staff member(s) of the university is/are authorized to proceed to visit as follows:</label></td><td></td></tr>";
							$str.="<tr><td style='padding:10px 0'>Location :&nbsp;<b>".$getpass_data[0]['location_od']."</b></td><td style='padding:10px 0'>Purpose :&nbsp;<b>".$getpass_data[0]['reason_od']."</b></td></tr>
								<tr><td style='padding:10px 0'>From Date :&nbsp;<b>".$getpass_data[0]['applied_from_date']."</b></td><td style='padding:10px 0'>To Date :&nbsp;<b>".$getpass_data[0]['applied_to_date']."</b></td></tr>";
						  
					$str.="<tr><td style='padding:10px 0'>Departure Time :&nbsp;<b>".$getpass_data[0]['departure_time']."</b></td><td style='padding:10px 0'>Arrival Time :&nbsp;<b>".$getpass_data[0]['arrival_time']."</b></td></tr>";
							
                            $str.="<tr><td style='padding:10px 0'>Staff ID:&nbsp;<b>".$getpass_data[0]['emp_id']."</b></td><td style='padding:10px 0'>Name :&nbsp;<b>".$getpass_data[0]['fname'].' '.$getpass_data[0]['mname'].' '.$getpass_data[0]['lname']."</b></td></tr>
								<tr><td style='padding:10px 0'>Designation:&nbsp;<b>".$getpass_data[0]['designation_name']."</b></td><td style='padding:10px 0'>Department :&nbsp;<b>".$getpass_data[0]['department_name']."</b></td></tr>
								<tr><td style='xxwidth:30%;padding:10px 0'>Signature of Employee</td> <td> Signature of HOD/Dean  </td></tr>
								<tr><td style='xxwidth:30%;padding:10px 0'>Signature of Registerar</td> <td> </td></tr>
								</table>";							
							}elseif($getpass_data[0]['od_duration']=='full-day'){ // for Office Order
							$str.="<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
							<table border='1'>";
						     $str.="<tr>
							 <th><img  src='".base_url().'assets/images/logo.jpg'."' ></th><th></th>
							 </tr>";
							$str.="<tr><td >
								<label>Mahiravani, Trimbak Road, Nashik – 422 213 </label><br>
	                            <label>Website : http://www.sandipuniversity.com <br> 
	                              Email:info@sandipuniversity.com</label><br>
                                <label>Ph: (02594) 222 541, 42, 43, 44, 45 Fax: (02594) 222 555</label>
								</td><td></td></tr>";
                            $str.="<tr><td style='width:50%'>SUN/Movement Order/No:</td><td style='width:50%'>Date: ". date('d-m-Y')."</td></tr>";															
							$str.="<tr><td style='text-align:center;padding:10px 0'><h1 style='color:red'><b>OFFICE ORDER </b></h1></td><td></td></tr><br>";
							$str.="<tr><td style='padding:10px 0'><label>The Undermentioned staff member(s) of the university is/are authorized to proceed to visit as follows:</label></td><td></td></tr>";
							$str.="<tr><td style='padding:10px 0'>Location :&nbsp;<b>".$getpass_data[0]['location_od']."</b></td><td style='padding:10px 0'>Purpose :&nbsp;<b>".$getpass_data[0]['reason_od']."</b></td></tr>
								<tr><td style='padding:10px 0'>From Date :&nbsp;<b>".$getpass_data[0]['applied_from_date']."</b></td><td style='padding:10px 0'>To Date :&nbsp;<b>".$getpass_data[0]['applied_to_date']."</b></td></tr>";
						   
                            $str.="<tr><td style='padding:10px 0'>Staff ID:&nbsp;<b>".$getpass_data[0]['emp_id']."</b></td><td style='padding:10px 0'>Name :&nbsp;<b>".$getpass_data[0]['fname'].' '.$getpass_data[0]['mname'].' '.$getpass_data[0]['lname']."</b></td></tr>
								<tr><td style='padding:10px 0'>Designation:&nbsp;<b>".$getpass_data[0]['designation_name']."</b></td><td style='padding:10px 0'>Department :&nbsp;<b>".$getpass_data[0]['department_name']."</b></td></tr>
								<tr><td style='xxwidth:30%;padding:10px 0'>Signature of Employee</td> <td> Signature of HOD/Dean  </td></tr>
								<tr><td style='xxwidth:30%;padding:10px 0'>Signature of Registerar</td> <td> </td></tr>
								</table>";		
							}
																
								echo $str; 
								
								?>
						
					           
					            </div>
							 <div class="form-group">
                                    <div class="col-sm-4"></div>
                                    <div class="col-sm-2">
                                        <a class="btn btn-primary form-control" id="btn_submit" type="submit" href="<?php echo base_url().'employee/downloadgetpass?str='.$str?>">Download Getpass</a>                                        
                                    </div> 
                             </div>									
                                </div>	
<?php }?>								
<!-- End Of Gate Pass-->								
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
	$('#dob-datepicker').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
	$('#dob-datepicker1').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
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
});
</script>