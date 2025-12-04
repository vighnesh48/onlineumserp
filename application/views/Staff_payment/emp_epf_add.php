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
.tabsal td>input{
	width:100%;
}
</style>

<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Staff Payment</a></li>
        <li class="active"><a href="#">Staff EPF Details </a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Staff EPF Details </h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                </div>
            </div>
        </div>
       
        <div class="row ">
            <div class="col-sm-12">               
                        <div class="table-info">
                               <span id="flash-messages" style="color:red;padding-left:110px;"><?php echo $this->session->flashdata('message1'); ?></span>                       
                                                               
                             <div id="dashboard-recent" class="panel-warning">			 
									 <div class="panel panel-warning">
              <div class="panel-heading">              <div class="row">
<div class="col-md-6 text-left">
</div>
<div class="col-md-6 text-left">
								       
</div>
</div>									</div><?php if(!empty($emp_list)){?>
                                <div class="panel-body" style="height:800px;overflow-y:scroll;">
								  <div class="form-group" >
								  <form id="form1" name="form1" action="<?=base_url($currentModule.'/add_emp_epf')?>" method="POST" >
								
								  <table cellpadding="0" cellspacing="0" style="font-size:12px;border:1px solid;width:100%;" class="table tabsal">
								  <tr bgcolor="#9ed9ed" style="border: 1px solid black;">
								  <td style="border: 1px solid black;"><input type='checkbox'  name="emp_chk_all" onclick='check_all()'></td>
	                              <td style="border: 1px solid black;">Sr No.</td>
	                              <td style="border: 1px solid black;">Staff Id</td>
	                              <td style="border: 1px solid black;">Staff Name</td>
								  <td style="border: 1px solid black;">School</td>
								  <td style="border: 1px solid black;">Department</td>
	                              
								  <td style="border: 1px solid black;">Status</td>
	                              </tr>
								  <?php $i=0;$j=1;	
	//$ci =&get_instance();
   //$ci->load->model('admin_model');								  
//print_r($tds_list);		
					  
								  foreach($emp_list as $key=>$val){				
								  	//$department =  $ci->admin_model->getDepartmentById($emp_list[$key]['department']); 
								 ///$school =  $ci->admin_model->getSchoolById($emp_list[$key]['emp_school']); 		
									
									if($emp_list[$key]['epf_apply']=='Y'){
										$ch = 'checked';
									}else{
										$ch ='';
									}
									
									 echo"<tr style='border: 1px solid black;'>";
									  echo"<td style='border: 1px solid black;'>";
									  
									  echo "<input  type='checkbox' name='mon_sal[]'  class='msal'  value='".$emp_list[$key]['emp_id']."' >";
									 
									  echo "</td>";		
echo "<td 	style='border: 1px solid black;'>".$j."</td>";								  
                                      echo"<td id='".$emp_list[$key]['emp_id']."' style='border: 1px solid black;'>".$emp_list[$key]['emp_id']."</td>";
									  echo"<td style='border: 1px solid black;'>"; if($emp_list[$key]['gender']=='male'){echo 'Mr.';}else if($emp_list[$key]['gender']=='female'){ echo 'Mrs.';} echo $emp_list[$key]['fname']." ".$emp_list[$key]['mname']." ".$emp_list[$key]['lname']."</td>";
									  echo"<td style='border: 1px solid black;'>".$emp_list[$key]['college_code']."</td>";
									   echo"<td style='border: 1px solid black;'>".$emp_list[$key]['department_name']."</td>";
									    
									 echo"<td  style='border: 1px solid black;'>";
									  echo $emp_list[$key]['epf_apply'];
									  echo "</td>";  
									  
									 echo"</tr>";
									$j++; 
								  } 
?>
								  </table>
								  </div>
								  <br>
							<!-- Modal -->

								  
									
									<div class="form-group">
									<div class="col-md-4" ></div>
									<div class="col-md-2" >
                                    <button class="btn btn-primary " id="btn_submit1" name="ssend" onclick="get_action();" value="ssend" type="button" >Save</button>
											</div>
											</div>
								  </form>								  
								</div>
								</div>
									 <?php }elseif(empty($tds_list)){
										 if(!empty($month_name)){
										echo"<span><label style='color:red'>No records available for  ".$month_name.$year_name."</label></span>"; 
									 } }?>
									</div>                       
                </div>
            </div>    
        </div>
    </div>
</div>
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">Close</button>
        <h4 class="modal-title" id="mhead"></h4>
      </div>
	  <form id="form" name="form" action="<?=base_url($currentModule.'/add_staff_salary_release')?>" method="POST" >
      <div class="modal-body" id="dmod">
       
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-default" name="ssend" value="ssend" data-dismiss="modal">Submit</button>
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
	  </form>
    </div>
  </div>
</div>
<script type="text/javascript">
function check_all(){
	  if($('input:checkbox[name="emp_chk_all"]').prop("checked")) {
	$('input:checkbox[name="mon_sal[]"]').prop('checked', true);	
	 } else {
     $('input:checkbox[name="mon_sal[]"]').prop('checked', false);	
            }    
}

function display_tdiv(t){
	//alert(t);
	if(t=='deposit'){
		$('#tdiv').show();
	}else{
		$('#tdiv').hide();
	}
}
function get_action(){
	
	 var favorite = [];
            $.each($("input[name='mon_sal[]']:checked"), function(){  
                favorite.push($(this).val());
            });
			var fLen = favorite.length;
         var sact = $('#sact').val();
         var smon = $('#smonth').val();
		 //var styp = $('#stype').val();
		   var st = $("input[name='styp']:checked").val();
		   //alert(st);alert(sact);
		   if(st=='c' || sact =='hold' || sact == 'release'){
		  // var t;
		  var t = '<input type="hidden" name="smonth" value="'+smon+'"/><input type="hidden" name="sact" value="'+sact+'"><input type="hidden" name="styp" value="'+st+'"><table cellpadding="0" cellspacing="0" style="font-size:12px;border:1px solid;" class="table"><tr><th style="border: 1px solid black;">Sr.No</th><th style="border: 1px solid black;">Emp ID</th><th style="border: 1px solid black;">';
		  if(sact=='deposit'){
			   t += 'Cheque Ref. No';
			  $('#mhead').text('Salary Details');
		  }else{
			  t += 'Remark';
			  $('#mhead').text('Hold Details');
		  }
		   t += '</th></tr>';
		  var k = 1;
            for (var i = 0; i < fLen; i++) {
			//alert(favorite.length);
			var emp = $('#'+favorite[i]).text();
			t += "<input type='hidden' name='empid_"+favorite[i]+"' value='"+emp+"' />";
var nets = $('#nets_'+favorite[i]).text();
			t += "<input type='hidden' name='enets_"+favorite[i]+"' value='"+nets+"' />";
			var stas = $('#sta_'+favorite[i]).text();
			if(sact =='release'){
			if(stas == 'Hold'){
			t += '<tr><input type="hidden" name="uid[]" value="'+favorite[i]+'"><td style="border: 1px solid black;">'+k+'</td><td style="border: 1px solid black;">'+emp+'</td><td style="border: 1px solid black;"><input type="text" name="emp_'+favorite[i]+'" style="width:50%;" value=""/></td></tr>';
			}
			}else{
				t += '<tr><input type="hidden" name="uid[]" value="'+favorite[i]+'"><td style="border: 1px solid black;">'+k+'</td><td style="border: 1px solid black;">'+emp+'</td><td style="border: 1px solid black;"><input type="text" name="emp_'+favorite[i]+'" style="width:50%;" value=""/></td></tr>';
			}
			k = k + 1;			
			}
			t += '</table>';
			$('#dmod').html(t);
			 $('#myModal').modal({show:true});
		   }else{
			   $('#form1').submit();
		   }
           
}
$(document).ready(function(){
	$('#dob-datepicker').datepicker( {format: "yyyy-m",startView: "months",minViewMode: "months",autoclose:true});
});
</script>