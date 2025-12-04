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
table.dataTable{margin-top: 0px !important;}
th, td { white-space: nowrap; }
td>input { white-space: nowrap;width:100%;padding:5px; }
</style>



<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Staff Payment</a></li>
        <li class="active"><a href="#">Visiting Faculty Salary Reports </a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Visiting Faculty Salary Reports </h1>
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
                            	<div class="panel-heading"><strong>Visiting Faculty Salary Reports</strong></div>
                                <div class="panel-body">
								<span id="flash-messages" style="color:red;padding-left:110px;"><?php echo $this->session->flashdata('message1'); ?></span>
                                <div class="panel-padding no-padding-vr">
                            <div class="form-group">
                              <div class="row"></div>
							  <div class="portlet-body form">
							  <form id="form11" name="form11" action="<?=base_url($currentModule.'/visiting_export_excel')?>" method="POST" >
								<div class="form-body">
								
                                <div class="form-group">
								<label class="col-md-3">Select Month And Year:</label>
                                             <div class="col-md-3" >
                          <input id="dob-datepicker" required class="form-control form-control-inline" name="attend_date" value="" placeholder="Month & Year" type="text">

                                             </div>											
                                  </div>

								  <div class="form-group">
								<label class="col-md-3">Report:</label>
                                             <div class="col-md-3" >
                           <select name="treport" required class="form-control" onchange="display_typ(this.value);">
						   <option value="">select</option>
						   <!--option value="salary_reg">SALARY REGISTER</option-->
						   <option value="salary_note">NOTE SHEET</option>
						   <option value="salary_bank">BANK TRANSFER LETTER </option>
						   <option value="salary_neft">NEFT BANK LETTER </option>
						   <option value="salary_tds">TDS REPORT</option>

				</select>

                                             </div>											
                                  </div>
								  
								   <div class="form-group">
								<label class="col-md-3">Type:</label>
                                             <div class="col-md-6" >
											 <label  class="radio-inline">
      <input type="radio" name="rtype" id="lpdf" required value="pdf" />PDF
    </label>
    <!--label class="radio-inline" id="exceld">
      <input type="radio"  value="exl" required name="rtype" />Excel
    </label-->
                         </div>											
                                  </div>								    
			<div class="form-group">
			<div class="col-md-3"></div>	                                                                               
 <div class=" col-md-2">  
                                            <input type="submit" class="btn btn-primary form-control" name="submit" value="Download">
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
        </div>
<script type="text/javascript">
function display_typ(typ){
/* 	if(typ=='salary_slip'){		
$('#exceld').hide();
	}else{		
$('#exceld').show();
	} */
}
$(document).ready(function(){
	 
	$('#dob-datepicker').datepicker( {format: "yyyy-mm",startView: "months",minViewMode: "months",autoclose:true}).on('changeDate', function (selected) {
	//	$('#form1').bootstrapValidator('revalidateField', 'attend_date');		
	});
	
});
</script>


