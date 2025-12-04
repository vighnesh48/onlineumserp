<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<script src="<?=base_url()?>assets/javascripts/moment.js"></script>
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
.emp-mo-m .form-group {
    margin-bottom: 7px;
}
.emp-mo-m label{font-weight:normal;font-size:12px;}

</style>
<script>    
 $(document).ready(function() {
        $('#amt').keypress(function (event) {
            return isNumber(event, this)
        });
    });
	function isNumber(evt, element) {

        var charCode = (evt.which) ? evt.which : event.keyCode

        if (
            (charCode != 45 || $(element).val().indexOf('-') != -1) &&      // “-” CHECK MINUS, AND ONLY ONE.
            (charCode != 46 || $(element).val().indexOf('.') != -1) &&      // “.” CHECK DOT, AND ONLY ONE.
            (charCode < 48 || charCode > 57))
            return false;

        return true;
    }    
    $(document).ready(function()
    {
       
       $("#submit").click(function(){
           // var sid = $('#staffid').val();
              var favorite = [];
var f = 0;

            $.each($("input[name='staffid[]']:checked"), function(){            

                favorite.push($(this).val());

            });
           
            fLen = favorite.length;
           // alert(favorite);
            
if(fLen==0){
     alert('Select Atleast one employee.');
  return false;
}
  
       });		
});
 function getEmp_using_dept1(dept_id,sid,did){
var e = document.getElementById(sid);
var school_id = e.options[e.selectedIndex].value;
var post_data='';
if(school_id!=null && dept_id!=null){
               
				post_data+="&school="+school_id+"&department="+dept_id;
				
			}
        
jQuery.ajax({
				type: "POST",
				url: base_url+"Employee/getEmpListDepartmentSchool1",
				data: encodeURI(post_data),
				success: function(data){
					//alert(data);
				$('#'+did).html(data);
         		}	
			});

}
 
function getdept_using_school1(school_id,did){
//alert(school_id);
 var post_data=schoolid='';
	var schoolid=school_id;
           if(school_id!=null){

				post_data+="&school_id="+schoolid;
				
			}
 jQuery.ajax({
				type: "POST",
				url: base_url+"admin/getdepartmentByschool",
				data: encodeURI(post_data),
				success: function(data){
					//alert(data);
				        
            //$('#reporting_dept').append(data);
            $('#'+did).html(data);
           //$("#dept-emp").html(emp_list);
				}	
			});

	
}
</script>
<script type="text/javascript">
function check_sel_rep(chk){
    var f ;
    if($("#"+chk).is(':checked')) {
     if(chk > 1){
         for(var i=1;i<chk;i++){
        if($("#"+i).is(':checked')){
   f = 0; // checked
}else{
    f = 1;
   $("#"+chk).prop('checked', false); 
    }
         }
        if(f==1){
            alert('select previous reporting');
        }
    }
    }else{
         for(var i=chk;i<=4;i++){
        $("#"+i).prop('checked', false); 
         }
    }  
    }


</script>
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Staff payment</a></li>
        <li class="active"><a href="#">Co-Society Deduction Add</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Co-Society Deduction Add</h1>
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
               
                        <div class="table-info">                                                              
                             <div id="dashboard-recent" class="panel-warning">   
                               <div class="panel">
                            	<div class="panel-heading"><strong>Co-Society Deduction Add</strong></div>
                                <div class="panel-body">
								<span id="flash-messages" style="color:red;padding-left:110px;"><?php echo $this->session->flashdata('message1'); ?></span>
                                <div class="panel-padding no-padding-vr">
                            <div class="form-group">
                              <div class="row"></div>
							  <div class="portlet-body form">
							  <form id="form" name="form" action="<?=base_url($currentModule.'/emp_society_add_submit')?>"  method="POST"  enctype="multipart/form-data">
							   
								<div class="form-body">
							
								        <div class="form-group">
										<div class="row">

<div class="form-group">
  <div class='emp-list' id='etable'><input type='text' id='myInput' onkeyup='myFunction()' placeholder='Search ..' title='Type in a name'><table id='myTable' class='table' style=''>
        <th></th><th>Emp Code</th><th>Emp Name</th><th>School</th><th>Department</th>
        <?php
 foreach($emp_list as $val){
                $nme = '"'.$val['fname'].' '.$val['lname'].'"';
            $sch = $val['college_name'];
            $dep = $val['department_name'];
           
            echo "<tr >";
            echo "<td><input type='checkbox' value='".$val['emp_id']."' name='staffid[]'></td>";
            echo "<td>".$val['emp_id']."</td>";
            echo "<td>".$val['fname']." ".$val['lname']."</td>";
echo "<td>".$sch."</td>";
echo "<td>".$dep."</td>";
            echo "</tr>";
        }
        ?>
        </table></div>
</div>

<div class="form-group">
										<div class="col-md-6 emp-mo-m">					   	
 							   
                  <div class="form-group">
                <label class="col-md-4"><b>Active From</b></label>
                                             <div class="col-md-6" >
   <input type="text" class="form-control"  name="active_form" required value="" id="active_form" />
                                       </div>
                                  </div>  
                                    
</div>
							
									
<div class="col-md-6">
<div class="form-group" id="emptab">
<div class="form-group">
                <label class="col-md-4"><b>Amount</b> </label>
                                             <div class="col-md-6" >
   <input type="text" class="form-control" required maxlength="5"   name="amt" value="" id="amt" />
                                       </div>
                                  </div>    
</div>
							  
</div>		</div>							  
										</div>
												</div>
<div class="form-group">
								   <div class="col-md-3" ></div>
                                      <div class=" col-md-2">  
                                            <button type="submit" id="submit" class="btn btn-primary form-control" >Submit</button>
                                        </div>
                                        <div class="col-sm-2"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule)?>/emp_society_list'">Cancel</button></div>
                                  
                                    </div>					
                                    </form>									
									</div>   </div>
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

$(function(){
	 $('#active_form').datepicker({
       autoclose: true,
    minViewMode: 1,
    format: 'yyyy-mm'        
    });	
});
</script>


