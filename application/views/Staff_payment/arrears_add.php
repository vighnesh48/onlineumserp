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
.mob{width:70px;}
.mobd{width:70px;}
.month-div .form-control{
   height: 25px;
}
.panel-heading{background: #fafafa !important;
border-bottom: 2px solid #ececec !important;  }
.arrs-upload{height:auto!important;}
.month-name{
    font-weight:bold;
}
</style>

<script type="text/javascript">
$(document).ready(function()
    {
        $('#tformee').bootstrapValidator
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
               
                month:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Select Month.'
                      }
                    }
                }
                
                
            }       
        });
    });

$(document).ready(function() {
        $('.mob').keypress(function (event) {
            return isNumber(event, this)
        });
    });
	function isNumber(evt, element) {
        var event;
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (
            (charCode != 45  || $(element).val().indexOf('-') != -1) &&      // “-” CHECK MINUS, AND ONLY ONE.
            (charCode != 46 || $(element).val().indexOf('.') != -1) &&      // “.” CHECK DOT, AND ONLY ONE.
            (charCode < 48 || charCode > 57) && (charCode != 8))
            return false;
        return true;
    }    


</script>
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="#">Employee Arrears Add</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Employee Arrears Add</h1>
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
              <div class="col-md-6">
                                                   
                            	<div class="panel" >
                            	<div class="panel-heading" ><form method="POST" id="tform" name="tform" enctype="multipart/form-data" action="<?=base_url($currentModule.'/emp_add_arrears')?>"><div class="form-body">
<div class="row">
							 <div class="col-md-6" >
                <b><span id='fmon'></span></b>
                </div>
                                       <div class="col-md-6">
                                       <div class="row text-right">
                                            <label class="col-md-6"> Month </label>
                                             <div class="col-md-6 ">
     <input type="text" class="form-control" required name="month" value="" id="month" /> </div>                                 
                                       </div>
                                      
                                        </div>  
                                      
							</div>
								</div></div>
                                <div class="panel-body" style="max-height:500px;overflow-y:scroll;">
								<span id="flash-messages" style="color:red;"><?php echo $this->session->flashdata('message1'); ?></span>
                                <div class="panel-padding no-padding-vr">
								
                            <div class="form-group">  
                            <div class="table-info">                                
							 <div class="portlet-body form">							    
								<div class="form-group" id="empl">
								<table class='table table-bordered'><thead><tr><th>Sr.no</th><th>Emp Id</th><th>Name</th><th>Amount</th></tr></thead><tbody>
								<?php 
					
								$i=1;$tot=0;

								foreach($emp_list as $bill){

									echo "<tr>";
									echo "<td>".$i."</td>";
									echo "<td><input type='hidden' name='empid[]' value='".$bill['emp_id']."' />".$bill['emp_id']."</td>";
									echo "<td>";
									if($bill['gender']=='male'){echo 'Mr.';}else if($bill['gender']=='female'){ echo 'Mrs.';}
											echo ucfirst($bill['lname'])." ".ucfirst($bill['fname']);
									echo "</td>";
									if(!empty($upd_emp_list)){
									if(isset($upd_emp_list[$bill['emp_id']][0])){
									$dt = $upd_emp_list[$bill['emp_id']][0];
									}else{
									  $dt ='0';
									}
									}
									$tot= $dt+$tot;
									
									echo "<td><input type='input'  class='mob amount-field' name='arr_".$bill['emp_id']."'  value='".$dt."' oninput='calculateTotal()' /></td>";
									echo "</tr>";
										$i++;
									}
									?><tr><td colspan="3" style="text-align: center;"><strong>Total</strong></td>

                                    <td><strong><span id="total_amount"><?= $tot ?></span></strong></td></tr></tbody></table>
								</div>
								</div>
								<div class="form-group">
								   <div class="col-md-3" ></div>
                                      <div class=" col-md-3">  
                                            <button type="submit" id="submit" class="btn btn-primary form-control" >Submit</button>
                                        </div>
                                        <div class="col-sm-3"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule)?>/arrears_list'">Cancel</button></div>
                                  <div class=" col-md-2">  
                                            
                                        </div>
                                    </div>			
									</form>
							               </div></div>          
									</div>
    </div>
							   </div></div>
                                
                                <div class="col-md-6">
        
        <div class="table-info">                                                              
                                                           
                              <div class="panel" >
                              <div class="panel-heading" >
<div class="row">
               <div class="form-group" style="margin-bottom:0px;">                
                                      
                                            <label class="col-md-4 "> File Upload</label>                                    
                                      
                                         
                                      </div>
              </div>
                </div>
                                <div class="panel-body" >
                <span id="flash-messages" style="color:red;"><?php echo $this->session->flashdata('message1'); ?></span>
                                <div class="panel-padding no-padding">
                                                        
                                
                 <form class="form-horizontal" action="<?=base_url($currentModule.'/upload_csv_file_arrears')?>" method="post" name="upload_excel" enctype="multipart/form-data">
                <div class="form-group" >
        <label class="col-md-10"><input type="file" onchange="return fileValidation()" class="form-control arrs-upload" required accept=".csv" name="fupl"  id="fupl" /></label>
        <label class="col-md-2 "><input type="submit" class="btn btn-primary"  value="Upload" /></label>
        </div>
        <div class="form-group">
        <label> <span id="flash-messages" style="color:red;"><?php echo $this->session->flashdata('umessage'); ?></span></label>
        <label class="col-md-12">Note:
        <label class="col-md-12"> 1) Please upload CSV file only
        
</label>
<label class="col-md-12 "> 2) Download CSV file format <a href="<?=base_url($currentModule.'/download_csv_format_arrears/1')?>" ><i class="fa fa-download"></i></a></div>
</div>  
        </form>
        
      
        </div></div></div></div>
                       </div>

                </div>
            </div>    
        </div>
    </div>
</div>
<script type="text/javascript">
function fileValidation(){
    var fileInput = document.getElementById('fupl');
    var filePath = fileInput.value;
    var allowedExtensions = /(\.csv)$/i;
    if(!allowedExtensions.exec(filePath)){
        alert('Please upload file having extensions .csv only.');
        fileInput.value = '';
        return false;
    }
}
	  var monthNames = ["", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

$('#month').datepicker({
    autoclose: true,
    startView: "months",
    minViewMode: "months",
    format: 'yyyy-m'
}).on('changeDate', function (e) {
    var my = $(this).val().split("-");
    var monthIndex = parseInt(my[1], 10); // Convert to integer

    $('#fmon').text('For month ' + monthNames[monthIndex] + ' ' + my[0]);

    $.ajax({
        type: "POST",
        url: "<?=base_url().strtolower($currentModule).'/check_monthly_arrears/'?>" + $(this).val(),
        dataType: "html",
        cache: false,
        crossDomain: true,
        success: function (data) {
            data = $.trim(data); // Remove extra spaces

            if (data === "false") {
                $('#flash-messages').html('Selected ' + monthNames[monthIndex] + ' ' + my[0] + ' Arrears are not allowed, The Salary is already calculated.');
                $('#submit').hide();
                $('#empl').hide();
            } else {
                $('#flash-messages').html('Selected month is allowed.');
                $('#submit').show();
                $('#empl').show();
            }
        },
        error: function () {
            $('#flash-messages').html("Error occurred while checking arrears.");
        }
    });
});

</script>
<script>
function calculateTotal() {
    let total = 0;
    document.querySelectorAll('.amount-field').forEach(function(input) {
        let val = parseFloat(input.value);
        if (!isNaN(val)) {
            total += val;
        }
    });
    document.getElementById('total_amount').innerText = total.toFixed(2);
}
</script>