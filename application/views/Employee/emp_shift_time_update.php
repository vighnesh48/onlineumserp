<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<script src="<?=base_url()?>assets/javascripts/moment.js"></script>
<script src="<?=base_url('assets/javascripts').'/bootstrap-datetimepicker.min.js'?> "></script>
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
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Employee</a></li>
        <li class="active"><a href="#">Shift Time Add</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Shift Time Add</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                </div>
            </div>
        </div>
        
        <div class="row ">
            <div class="col-sm-12">
                
                        <div class="table-info">                                    
                                                  <form id="tform"  name="tform" onsubmit="return check_duration();" action="<?=base_url($currentModule.'/emp_shift_time_update_submit')?>" method="POST">
							              
                             <div id="dashboard-recent" class="panel-warning">   
                               <div class="panel">
							   <div class="panel-heading">
							   <div class="row">
							   <label class="col-md-1">School</label>

							<div class='col-md-3'>  <select class="select2me form-control" name="emp_school" onchange="getstaffdept_using_school(this.value)" id="emp_school" >
													  <option value="">Select</option>
													  <?php 
foreach($school_list as $val){
	echo "<option value='".$val['college_id']."'>".$val['college_name']."</option>";
}
													  ?>
								</select>
								</div>
								<label class="col-md-1">Department</label>

							<div class='col-md-3'>   <select class="select2me form-control" name="department" id="department" >
													 <option value="">Select</option>
													
								</select>
								</div>
                <div class='col-md-3'><input type="button" class="btn-primary btn" name="disemp" id="disemp" value="View" /></div>
								
</div>
							   </div>
                            	 <div class="panel-body">
								<span id="flash-messages" style="color:red;padding-left:110px;"><?php if($_GET['e']==1){ echo 'Already inserted.'; } ?></span>
                                <div class="panel-padding no-padding">
                            <div class="form-group">
                              <div class="row"></div>
							  <div class="portlet-body form">
							   
 
									 <div class="form-group">
								<label class="col-md-3 text-center"><strong>Search by Employees Id:</strong></label>
                <div class="col-md-3 no-padding">
                <input type='text' id='myInput' onkeyup='myFunction()' placeholder='Search ..' title='Type in a name'>
                </div>

        							 <div class='col-md-12 emp-list no-padding' id='etable'>
									 <table id='myTable' class='table' >
       <tr> <th> <input type='checkbox'  name="emp_chk_all" onclick='check_all(<?php echo $val['emp_id']; ?>)'></th><th>Emp Code</th><th>Emp Name</th><th>School</th><th>Department</th></tr>
    <tbody id="empl">
      </tbody>
       </table></div>	</div>		
											
                    <div class="form-group"><hr>
                    <label class="col-md-1 text-right">Shift:</label>
                                             <div class="col-md-2 no-padding" >
                      <select class="form-control"  name="shift_dur" onchange="display_dur(this.value);"><option value="">Select</option> 
                      <?php foreach($shift_time as $sft){ 
echo "<option value='".$sft['shift_id']."'>".$sft['shift_name']." (".date('h:i',strtotime($sft['shift_start_time']))."-".date('h:i',strtotime($sft['shift_end_time'])).")</option>";
                      } ?></select>                     
                    </div>
                    <label class="col-md-1 text-right">Duration:</label>
                                             <div class="col-md-1 no-padding" >
                        <input type='text' required class="form-control"  id="shift_dur" name="shift_dur" value="">                   
                    </div>
										<label class="col-md-1 text-right">Intime:</label>
                                             <div class="col-md-1 no-padding" >
												<input type='text' required class="form-control"  id="emp_intime" name="emp_intime" value="">										
										</div>
										<label class="col-md-1 text-right">OutTime:</label>
                                             <div class="col-md-1 no-padding" >
												<input type='text' required class="form-control"  id="emp_outtime" name="emp_outtime" value="">										
										</div>
										<label class="col-md-2 text-right">Applicable From:</label>
                                             <div class="col-md-1 no-padding" >
												<input type='text' required class="form-control"  id="activef" name="activef" value="">										
										</div> <div class="col-md-6" ></div></div>
									 <div class="form-group"><br>								 
								   <div class="col-md-4" ></div>
								    <div class=" col-md-2">  
                                            <input type="submit" id="fsub" name="up_basic_submit" class="btn btn-primary form-control" value="Add">
                                        </div>
									
                                      <div class=" col-md-2">  
                                            <input type="button" name="basic_submit" onclick="window.location='<?=base_url($currentModule)?>/emp_shift_time_list'" class="btn btn-primary form-control" value="Cancel">
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
function display_dur(e){
  //alert(e);
  var post_data='&sftid='+e;
  jQuery.ajax({
        type: "POST",
        url: base_url+"Employee/getshiftduration/",
        data: encodeURI(post_data),
        success: function(data){
          //alert(data);
          var res = data.split("-");
        $('#shift_dur').val(res[0]);
        $('#emp_intime').val(res[1]);
        $('#emp_outtime').val(res[2]);
            } 
      });
}

function check_duration(){
  var dur = $('#shift_dur').val();
  var intim = $('#emp_intime').val();
  var ottim = $('#emp_outtime').val();
  //alert(intim);
  //alert(ottim);
  var d = '<?php echo date('Y-m-d'); ?>';
  //alert(d);
  var hourStart = new Date(d+" "+intim+":00").getHours();
        var hourEnd = new Date(d+" "+ottim+":00").getHours();
//alert(hourStart);
  //alert(hourEnd);
        var minuteStart = new Date(d+" "+intim+":00").getMinutes();
        var minuteEnd = new Date(d+" "+ottim+":00").getMinutes();

        var hourDiff = hourEnd - hourStart;
        var minuteDiff = minuteEnd - minuteStart;
    
        if (minuteDiff < 0) {
            hourDiff = hourDiff - 1;
      minuteDiff=60-(-(minuteDiff));
        }
   var rn=hourDiff+'.'+minuteDiff;
    //alert(rn);
  if(parseInt(rn) == parseInt(dur)){
    
    return true;
  }else{
    var r = confirm("Shift Duration and in out time duration is not same. Do you want to proceed? ");
if (r == true) {
    return true;
} else {
    return false
} 
  }
  
}

$(document).ready(function(){
	$('#disemp').on('click',function(){
		var school = $('#emp_school').val();
		var dep = $('#department').val();

		var post_data='&school='+school+'&department='+dep;
  jQuery.ajax({
        type: "POST",
        url: base_url+"Employee/get_emp_sch_dep_shift_time/",
        data: encodeURI(post_data),
        success: function(data){
          //alert(data);
        $('#empl').html(data);
            } 
      });

	});
	$("#activef").datepicker({
        todayBtn:  1,
        autoclose: true,
		format: 'yyyy-mm-dd'
    });
	
$('#emp_intime').datetimepicker({ format:'HH:mm'});
$('#emp_outtime').datetimepicker({ format:'HH:mm'});	


$('#tform').on('submit', function() {
	
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
				
				return true;
			}
	
	
	
});
	   
});
</script>


