<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<script src="<?=site_url()?>assets/javascripts/jspdf/jspdf.js" type="text/javascript"></script>

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
    padding: 5px;
}
</style>
<script>
 /* $(document).ready(function()
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
        })
		
}); */
  
</script>


<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Staff Payment</a></li>
        <li class="active"><a href="#">Staff Income Details </a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Staff Income Details </h1>
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
                            	<div class="panel-heading"><strong>Staff Income Details </strong></div>
                                <div class="panel-body">
								<span id="flash-messages" style="color:red;padding-left:110px;"><?php echo $this->session->flashdata('message1'); ?></span>
                                <div class="panel-padding no-padding-vr">
                            <div class="form-group">
                              <div class="row"></div>
							  <div class="portlet-body form">
							  <form id="form" name="form" action="<?=base_url($currentModule.'/income_details')?>" method="POST" >
								<div class="form-body">
								<!--<div class="form-group">
								<label class="col-md-3">Select School</label>
                                             <div class="col-md-3" >
											 <select class="select2me form-control" name="emp_school" onchange="getstaffdept_using_school(this.value)" id="emp_school" >
											 <option value="">Select School</option>
											 <?php foreach($school_list as $sc) {
												 echo "<option  value=".$sc['college_id'].">".$sc['college_name']."</option>";
											 } ?>
											
										     </select>
                                       </div>
                                  </div>
								   <div class="form-group">
								<label class="col-md-3 control-label">Department:<?=$astrik?></label>
        										<div class="col-md-3">
        									<select class="form-control select2me" id="department"  name="department" >
											<option value="">Select</option>
											</select>
                                       </div>
                                  </div>-->
                                <div class="form-group">
								<label class="col-md-3">Select Month And Year</label>
                                             <div class="col-md-3" >
                          <input id="dob-datepicker" required class="form-control form-control-inline  date-picker" name="attend_date" value="" placeholder="Month & Year" type="text">

                                             </div>
											 <div class=" col-md-2">  
                                            <input type="submit" class="btn btn-primary form-control" name="submit" value="View">
                                        </div>
                                       
                                  </div>
				                                                                               

                                   
                            </div>
                                    </form>
									</div>
									 </div>
							   </div>
                                </div>
                            </div>
									 <?php if(!empty($emp_income)){?>
									 <div class="panel">
              <div class="panel-heading text-center"><strong>Staff Income Details of <?php if(isset($fordepart) && isset($forschool)){echo $fordepart.'Department['.$forschool."]"; } else{ unset($forschool);unset($fordepart);echo "All Deartment and All School";}?> For 
								<?php echo $month_name." ".$year_name;
                               /*  $d = date_parse_from_format("Y-m-d", $inc_dt);
								//print_r($d);
								$msearch=$d["month"];
							$month_name = date("F", mktime(0, 0, 0, $msearch, 10));
                                $ysearch=$d["year"];
								 */?>
								</strong></div>
                                <div class="panel-body">
								  <div class="form-group" style="height:700px;overflow-y:scroll;">
								  <form id="form" name="form" action="<?=base_url($currentModule.'/add_income_details')?>" method="POST" >
								 <input type="hidden" name="for_month_year" value="<?=$dt1?>">
								  <table cellpadding="0" cellspacing="0" style="font-size:12px;border:1px solid;">
								  <tr bgcolor="#9ed9ed" style="border: 1px solid black;">
	                              <td style="border: 1px solid black;">Sr No.</td>
	                              <td style="border: 1px solid black;" >Staff Id</td>
	                              <td style="border: 1px solid black;">Staff Name</td>
	                              <td style="border: 1px solid black;">DA(%)</td>
	                              <td style="border: 1px solid black;">HRA(%)</td>
	                              <td style="border: 1px solid black;">TA</td>
	                              <td style="border: 1px solid black;">Income Difference(Rs.)</td>
	                              <td style="border: 1px solid black;">Otherincome(Rs.)</td>
	                              <td style="border: 1px solid black;">DP</td>
								  </tr>
								  <?php $i=0;$j=0;	//echo $flag;
								  if($flag == '1'){
								  foreach($emp_income as $key=>$val){
									  									 									 
									  echo"<tr style='border: 1px solid black;'>";
									  echo"<td style='border: 1px solid black;'>".++$i."</td>";										 
                                      echo"<td style='border: 1px solid black;'><input type='hidden' readonly name='ins[".$j."][emp_id]' value='".$emp_income[$key]['emp_id']."' >".$emp_income[$key]['emp_id']."</td>";
									  echo"<td style='border: 1px solid black;'>";
									    if($emp_income[$key]['gender']=='male'){echo 'Mr.';}else if($emp_income[$key]['gender']=='female'){ echo 'Mrs.';}
									  echo $emp_income[$key]['fname']." ".$emp_income[$key]['lname']."</td>";
									  echo"<td style='border: 1px solid black;'><input type='text' name='ins[".$j."][DA]'  value='".$emp_income[$key]['DA']."' style='width:100px;' placeholder=''></td>";
									  echo"<td style='border: 1px solid black;'><input type='text' name='ins[".$j."][HRA]' value='".$emp_income[$key]['HRA']."' style='width:100px;' placeholder=''></td>";
									  echo"<td style='border: 1px solid black;'><input type='text' name='ins[".$j."][TA]' value='".$emp_income[$key]['TA']."' style='width:100px;' placeholder=''></td>";
									  echo"<td style='border: 1px solid black;'><input type='text' name='ins[".$j."][Incom_Diff]' value='".$emp_income[$key]['Incom_Diff']."' style='width:100px;' placeholder=''></td>";
									  echo"<td style='border: 1px solid black;'><input type='text' name='ins[".$j."][otherinc]' value='".$emp_income[$key]['otherinc']."' style='width:100px;' placeholder=''></td>";
									  echo"<td style='border: 1px solid black;'><input type='text' name='ins[".$j."][DP]' value='".$emp_income[$key]['DP']."' style='width:100px;' placeholder=''></td>";
										 echo"</tr>";
									$j++; 
								  } 
								  }else{
									  foreach($emp_income as $key=>$val){
									  									 									 
									  echo"<tr style='border: 1px solid black;'>";
									  echo"<td style='border: 1px solid black;'>".++$i."</td>";										 
                                      echo"<td style='border: 1px solid black;'>".$emp_income[$key]['emp_id']."</td>";
									  echo"<td style='border: 1px solid black;'>";
									  if($emp_income[$key]['gender']=='male'){echo 'Mr.';}else if($emp_income[$key]['gender']=='female'){ echo 'Mrs.';}
									  echo $emp_income[$key]['fname']." ".$emp_income[$key]['lname']."</td>";
									  echo"<td style='border: 1px solid black;'>".$emp_income[$key]['DA']."</td>";
									  echo"<td style='border: 1px solid black;'>".$emp_income[$key]['HRA']."</td>";
									  echo"<td style='border: 1px solid black;'>".$emp_income[$key]['TA']."</td>";
									  echo"<td style='border: 1px solid black;'>".$emp_income[$key]['Incom_Diff']."</td>";
									  echo"<td style='border: 1px solid black;'>".$emp_income[$key]['otherinc']."</td>";
									  echo"<td style='border: 1px solid black;'>".$emp_income[$key]['DP']."</td>";
										 echo"</tr>";
									$j++;  
								  }
								  }
								  ?>
								  </table>
								  <br>
								   <div class="form-group">
								   <div class="col-md-3" ></div>
                                      <div class=" col-md-3">  
                                           <!-- <input type="submit" class="btn btn-primary form-control" name="save" value="Save Staff Income Detail">-->
											<button class="btn btn-primary form-control" id="btn_submit1" type="submit" >Save Staff Income Detail </button>
                                        </div>
                                       <!--<div class=" col-md-2">  
                                            <input type="submit" class="btn btn-primary form-control" name="cancel" value="cancel">
                                        </div> -->
                                    </div>
								  </form>
								  </div>
								</div>
								</div>
									 <?php }elseif(empty($emp_income)){
										 if(!empty($year_name)){
										echo"<span><label style='color:red'>No Staff Income Details available for year ".$year_name."</label></span>"; 
									 } }?>
									<?php 
								 /* echo"<pre>";
	                                print_r($all_emp);
	                                echo"</pre>"; 
									echo"*********************************";
									//die();
									echo"<pre>";
	                                print_r($attendance);
	                                echo"</pre>";  
	                              // die();  
								    */
									?>
							
							


							
							
							    
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
	$('#dob-datepicker').datepicker( {format: "yyyy-m",startView: "months",minViewMode: "months",autoclose:true});
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
	
	 $("#btnExport").click(function(e) {
		    window.open('data:application/vnd.ms-excel,' + $('#dvData').html());
    e.preventDefault();
});   
});
</script>


