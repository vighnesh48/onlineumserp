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
        <li><a href="#">masters</a></li>
        <li class="active"><a href="#">Canteen </a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Canteen Import</h1>
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
                            	<div class="panel-heading"><strong>Canteen Student Import</strong></div>
                                <div class="panel-body">
								<span id="flash-messages" style="color:red;padding-left:110px;"><?php echo $this->session->flashdata('message1'); ?></span>
                                <div class="panel-padding no-padding-vr">
                            <div class="form-group">
                              <div class="row"></div>
							  <div class="portlet-body form">
							  <form id="form11" name="form11" action="<?=base_url($currentModule.'/import_students')?>" enctype="multipart/form-data" method="POST" >
								<div class="form-body">
								
                                <div class="form-group">
								<label class="col-md-2">Upload Excel File:</label>
                                             <div class="col-md-2" >
                                             <input type="file" name="excel_file" id="excel_file" class="form-control" />

                                             </div>											
                                  </div>
                                 
								  
								 				    
                                             <div class="form-group">
                                                     <div class="col-md-2"></div>	                                                                               
                                                         <div class=" col-md-2">  
                                                             <input type="submit" class="btn btn-primary form-control" name="submit" value="Upload">
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


