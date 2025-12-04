<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>

<script>    
    $(document).ready(function(){
     var base_url = 'https://erp.sandipuniversity.com/';


		
    });

</script>

<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Account</a></li>
        <li class="active">Reports<a href="#"></a></li>
    </ul>
  
    <div class="page-header">
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-heading">
                            <span class="panel-title form-group"><i class="fa fa-list-alt page-header-icon h3"></i>&nbsp;&nbsp;Exam Fees Report</span>
                    </div>
                    <div class="panel-body">
                        <form id="exam_fees-form"  name="exam_fees-form" action="<?=base_url('/account/get_exam_fees_reports')?>" method="POST">
                        <div class="table-info">
                             <div class="row">
                                   <div class="form-group">
                                       <div class="col-sm-2"></div>
                                    	<label class="col-sm-2 control-label"> Exam Session</label>
                                            <div class="col-sm-3">
                                            	<select id="exam_session" name="exam_session" class="form-control"  required>
        											<option value="">Select Exam Session</option>
        											<option value="5">DEC-2017</option>	
														<?php/* foreach($ex_sess as $ses){ ?>
															<option value="<?=$ses['exam_id']?>"><?=$ses['exam_month'].'-'.$ses['exam_year']?></option>
															
														<?php } */?>
									           	</select>
                						    </div>

								    </div>
							    </div>
							      <div class="row">
                                   <div class="form-group">
                						    <div class="col-sm-2"></div>
                						    <label class="col-sm-2 control-label">Report Type </label>
                						    <div class="col-sm-3">
                                    	        <select id="report_type" name="report_type" class="form-control"  required>
        											<option value=""> Select Report Type</option>
        												<option value="1">Fees Details</option>
        											 	<option value="2">Fees Statistics</option>
        													<option value="3">Student Wise Fees</option>
        													    
									           	</select>
								            </div>
								    </div>
							    </div>
					     	<div class="row"><br></div>
                        	<div class="row">
                        	     <div class="col-sm-4"></div>
                              
                                   <div class="col-sm-2"><button  class="btn btn-primary form-control" id="btnView" >Export Excel</button></div>
                                 <div class="col-sm-2">
                                     
                                    
                                 </div>
                            </div>  
                             
                        </div>
                    </div>    
                </div>
            </div>
            </form>
        </div>
    </div>
    <div class="row" id="reportdata"></div>
           
            
</div>

