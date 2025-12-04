<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
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
.row{margin:0px;}

</style>
<script>
function search_emp_code(){
	//alert('gg');
	var post_data = $('#emp_id').val();
	$.ajax({
				type: "POST",
				url: "<?php echo base_url();?>leave/get_emp_code/"+post_data,
				success: function(data){
				//	alert(data);          
            $('#emptab').html(data);         
				}	
			});	
}



</script>
<script>
$(document).ready(function()
    {
$('#tform1').bootstrapValidator
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
                  type_of:
                {
                    validators: 
                    {
                     notEmpty: 
                      {
                       message: 'Select type.'
                      }
                    }
                },
				deduct_of:	{
validators: 
                    {
                     notEmpty: 
                      {
                       message: 'Select Deduction Of.'
                      }
                    }
				},
	frequency:	{
validators: 
                    {
                     notEmpty: 
                      {
                       message: 'Select Frequency.'
                      }
                    }
				},
				vfmonth:	{
validators: 
                    {
                     notEmpty: 
                      {
                       message: 'Select valid From Month.'
                      }
                    }
				},
				vfyear:	{
validators: 
                    {
                     notEmpty: 
                      {
                       message: 'Select valid From Year.'
                      }
                    }
				}
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
        <li><a href="#">Staff Payment</a></li>
        <li class="active"><a href="#">Employee Monthly Deduction Add</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Employee Monthly deduction Add</h1>
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
							   <div class="panel-heading"><strong> Employee Monthly deduction Add </strong></div>
                            	 <div class="panel-body">
								<span id="flash-messages" style="color:red;padding-left:110px;"><?php if($_GET['e']==1){ echo 'Already inserted.'; } ?></span>
                                <div class="panel-padding no-padding-vr">
                            <div class="form-group">
                              <div class="row"></div>
							  <div class="portlet-body form">
							  <form id="tform" name="tform" action="<?=base_url($currentModule.'/emp_monthly_deduction_add_submit')?>" method="POST">
							  <div class="form-group">
							         <div class="col-md-4"> 
								<div class="form-group">
								<label class="col-md-4 control-label">Type:</label>
        										<div class="col-md-8">
												<select class="form-control"  id="typ" name="type_of" required>
												<option value=''>Select</option>
												<option value="CR">Credits</option>
												<option value="DC">Debits</option>
												</select><div id="type"></div>
										</div>
										</div>
												
										</div>
										
										<div class="col-md-4"> 
									 <div class="form-group">
								<label class="col-md-6 control-label">Deduction Of:</label>
        										<div class="col-md-6">
												<select class="form-control" id="deduct_dr" name="deduct_of" required>
												
    									</select><div id="deduct_dre"></div>
										
										</div></div>
									
									 </div>
									 <div class="col-md-4"> 
									 <div class="form-group">
								<label class="col-md-5">Frequency:</label>
        										<div class="col-md-7">
											<select class="form-control"  onchange="display_validto(this.value,'fr2');"  id="frequency" name="frequency" required>
											<option value="">Select</option>
												<option value="1">One Time</option>
												<option value="2">Monthly</option>
											
    									</select><div id="frequencye"></div></div>
										</div>
															 
									 </div>
									 </div>
									 </div>
									 <div class="form-group">
									 <div class="col-md-6" style="padding:0;">
									 <div class="form-group row">
								<label class="col-md-3" style="padding:0;">Valid From:</label>
        										
												<div class="col-md-4">
												<select class="form-control"   id="vfmonth" name="vfmonth" required>
											<option value="">Select</option>
											<?php 
											$MonthArray = array("1" => "Jan", "2" => "Feb", "3" => "Mar", "4" => "Apr",
                    "5" => "May", "6" => "Jun", "7" => "Jul", "8" => "Aug","9" => "Sep", "10" => "Oct", "11" => "Nov", "12" => "Dec");
												foreach($MonthArray as $key=>$mon){ ?>											
												<option value="<?php echo $key; ?>"><?php echo $mon; ?></option>
											<?php } ?>												
    									</select>
												</div>
												<div class="col-md-4">
												<select class="form-control" name="vfyear"  id="vfyear" required>
											<option value="">Select</option>
											<option value="<?php echo $this->config->item('cyear'); ?>"><?php echo $this->config->item('cyear'); ?></option>
										<option value="<?php echo date('Y'); ?>"><?php echo date('Y'); ?></option>
											<option value="<?php echo date('Y',strtotime('+1 year')); ?>"><?php echo date('Y',strtotime('+1 year')); ?></option>
																						
    									</select>
												</div>
												</div>
										
										</div>
										<div class="col-md-6" style="padding:0;">
										 <div class="form-group row" id="valto1">
								<label class="col-md-3" style="padding:0;">Valid To:</label>
        										<div class="col-md-4">
											<select class="form-control" id="vtmonth" name="vtmonth">
											<option value="">Select</option>
											<?php 
												
									
												foreach($MonthArray as $key=>$mon){ ?>											
												<option value="<?php echo $key; ?>"><?php echo $mon; ?></option>
											<?php } ?>												
    									</select><div id="vtmonthe"></div></div>
										<div class="col-md-4">	
<select class="form-control" class="col-sm-2" id="vtyear" name="vtyear">
											<option value="">Select</option>
												<option value="<?php echo $this->config->item('cyear'); ?>"><?php echo $this->config->item('cyear'); ?></option>
											<option value="<?php echo date('Y'); ?>"><?php echo date('Y'); ?></option>
											<option value="<?php echo date('Y',strtotime('+1 year')); ?>"><?php echo date('Y',strtotime('+1 year')); ?></option>
																						
    									</select><div id="vtyeare"></div>		</div>
										</div>	
										</div>
										
										</div>
									 <div class="form-group">
								<label class="col-md-3">Employees</label>
        							 <div class='col-md-12 emp-list' id='etable'>
									 <input type='text' id='myInput' onkeyup='myFunction()' placeholder='Search ..' title='Type in a name'>
									 <table id='myTable' class='table' >
       <tr> <th> <input type='checkbox'  name="emp_chk_all" onclick='check_all(<?php echo $val['emp_id']; ?>)'></th><th>Emp Code</th><th>Emp Name</th><th>College</th><th>Department</th><th>Amount</th></tr>
       <?php foreach($emp as $val){
		    if($val['gender']=='male'){$pr = 'Mr.';}else if($val['gender']=='female'){ $pr = 'Mrs.';}
				?>
            <tr >
            <td><input type='checkbox' name="emp_chk[]" id="<?php echo $val['emp_id']; ?>" onclick="active_row(<?php echo $val['emp_id']; ?>)" value="<?php echo $val['emp_id'];?>"></td>
            <td><?php echo $val['emp_id'];?></td>
            <td><?php echo $pr." ".$val['fname']." ".$val['lname']; ?></td>
			<td><?php echo $val['college_code']; ?></td>
			<td><?php echo $val['department_name']; ?></td>
            <td><input type='text' disabled class="emp_amty" id="emp_amt_<?php echo $val['emp_id']; ?>" name="emp_amt_<?php echo $val['emp_id']; ?>" value=""></td>
          
		   </tr>
       <?php }?>
       </table></div>			
										</div>	
									 
									 
									 
									 <div class="form-group">								 
								   <div class="col-md-3" ></div>
								    <div class=" col-md-3">  
                                            <input type="submit" id="fsub" name="up_basic_submit" class="btn btn-primary form-control" value="Add">
                                        </div>
									
                                      <div class=" col-md-3">  
                                            <input type="button" name="basic_submit" onclick="window.location='<?=base_url($currentModule)?>/emp_monthly_deduction_list'" class="btn btn-primary form-control" value="Cancel">
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
function myFunction() {
  // Declare variables
  var input, filter, table, tr, td, i;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}
function check_all(){
	  if($('input:checkbox[name="emp_chk_all"]').prop("checked")) {
	$('input:checkbox[name="emp_chk[]"]').prop('checked', true);
	
	$('.emp_amty').prop('disabled',false);
	 } else {
     $('input:checkbox[name="emp_chk[]"]').prop('checked', false);
	 $('.emp_amty').prop('disabled',true);
            }    
}
function active_row(ch){
	//alert(ch);
	 if ($('#'+ch).is(':checked')){
		// alert('ff');
		//preventDefault();
		$('#emp_amt_'+ch).prop('disabled',false);
		$("#emp_amt_"+ch).attr('required',true);
$("#emp_amt_"+ch).prop('required',true);
$('#fsub').removeAttr('disabled');
	}else{
		//alert(ch);
		$('#emp_amt_'+ch).val('');
		$('#emp_amt_'+ch).prop('disabled',true);
		
	}
}
function display_validto(e,f){
	if(e==1){
		if(f=='fr1'){
			$('#valto').hide();
		}else{
		$('#valto1').hide();
		}
	}else{
		if(f=='fr1'){
			$('#valto').show();
		}else{
		$('#valto1').show();
		}
	}
}
$(document).ready(function(){
	$( "#vtmonth" ).change(function( event ) {
				$('#fsub').removeAttr('disabled');				
			});
			$( "#vtyear" ).change(function( event ) {
				$('#fsub').removeAttr('disabled');				
			});
			$( ".emp_amty" ).keypress(function( event ) {
				$('#fsub').removeAttr('disabled');
				//if(event.which != 8 && isNaN(String.fromCharCode(event.which))){
            //event.preventDefault();
        //}
			});
	$('#tform').on('submit', function() {
		//var typ = $('#typ').val();
		//var ddr = $('#deduct_dr').val();
		var frq = $('#frequency').val();
		//var vfmonth = $('#vfmonth').val();
		//var vfyear = $('#vfyear').val();
		   if(frq == 2){
			var vtmonth = $('#vtmonth').val();
			var vtyear = $('#vtyear').val();
			if(vtmonth == ''){
				alert('Select Valid To Month.');				
			return false;
			}else if(vtyear == ''){
				alert('Select Valid To Year.');				
			return false;
			}else{
			
			var vfmonth = $('#vfmonth').val();
			var vfyear = $('#vfyear').val();
			
			if(parseInt(vtyear) < parseInt(vfyear)){
				alert('Valid To must be geater then from date.');				
			return false;
			}else if(vtyear == vfyear){
				//alert('jj');
				//alert(vfmonth);
			//alert(vtmonth);
				if(parseInt(vtmonth) < parseInt(vfmonth)){					
					//alert('hh');
					alert('Valid To must be geater then from date.');				
			return false;
				}

			}
		}
			

		}
		
		    var favorite = [];
var f=0;
            $.each($("input[name='emp_chk[]']:checked"), function(){            
                favorite.push($(this).val());
            });
           
            var fLen = favorite.length;
			//alert(fLen);
			if(fLen == 0){
				alert('Select Employees.');
			return false;
			
			}else{
				 for (i = 0; i < fLen; i++) {
                var kk = $('#emp_amt_'+favorite[i]).val();
              //  alert(kk);
                if(kk == ''){
                    f = favorite[i];   
                }
				
				//alert($.isNumeric(kk));
				
}
//alert(f);
if(f!=0){
    alert('Insert valid Amount of Employee '+f);
  return false;  
}else{	
	return true;
}			}
     });
	   
	$("#typ").change(function () {
		//alert('dd');
           var dtyp = $(this).val();
		   if(dtyp == 'DC'){
			   var opt = "<option value=''>Select</option><option value='Bus-fare'>Bus-fare</option><option value='Mobile_Bill'>Mobile</option><option value='TDS'>TDS</option><option value='Off_Adv'>Office Advance</option><option value='Other_Deduct'>Other_Deduct</option>";
    			$('#deduct_dr option').remove();
				$('#deduct_dr').append(opt);
			   	   }else{
			    var opt = "<option value=''>Select</option><option value='Difference'>Difference</option><option value='Arrears'>Arrears</option>";												
    		$('#deduct_dr option').remove();
			$('#deduct_dr').append(opt);
			   	 
		   }
		   });
		   
		   
});
</script>


