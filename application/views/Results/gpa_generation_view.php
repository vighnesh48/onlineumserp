<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="<?php echo base_url('assets/javascripts') . '/bootstrap-datepicker.js' ?> "></script>

<?php 
if(isset($role_id) && $role_id==1 ){
?>
<style>
	.table{width: 150%;}
	table{max-width: 150%;}
</style>									
<?php }else{ ?>
	<style>
	table.dataTable{width: 210%;}</style>
<?php }?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Results</a></li>
        <li class="active"><a href="#">GPA Generation</a></li>
    </ul>
    <div class="page-header">
    	<div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;GPA Generation</h1>
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
                <div class="panel-heading">
                        <span class="panel-title">
                            
                            <div class="form-group">
                             <!-- <label class="col-sm-2">Course<sup class="redasterik" style="color:red">*</sup></label>-->
							 <div class="col-sm-2">
                                <a href="<?=base_url()?>Results/generate_sgpa"><button value="SGPA">SGPA</button></a>
                              </div>
							<div class="col-sm-2">
                                <a href="<?=base_url()?>Results/generate_cgpa"><button value="CGPA">CGPA</button></a>
                              </div>
                              <div class="col-sm-2">
                               <a href="<?=base_url()?>Results/generate_gpa"><button value="GPA">GPA</button></a>
                              </div>
                             
                            <!--  <label class="col-sm-2">Stream<sup class="redasterik" style="color:red">*</sup></label>-->
                              <div class="col-sm-2" id="semest">
                                <a href="<?=base_url()?>Results/calculate_percentage_dpharma"><button value="Dpharma">Dpharma GPA</button></a>
                              </div>

                              <div class="col-sm-2" id="semest">
                              
                            </div>

                            </div>
                             <div class="form-group">
                             <!-- <label class="col-sm-2">Course<sup class="redasterik" style="color:red">*</sup></label>-->
							 <div class="col-sm-2">
                                <a href="<?=base_url()?>Results/generate_sgpa_pharma"><button value="SGPA">Pharma SGPA</button></a>
                              </div>
							<div class="col-sm-2">
                                <a href="<?=base_url()?>Results/generate_cgpa_pharma"><button value="CGPA">Pharma CGPA</button></a>
                              </div>
                              <div class="col-sm-2">
                               <a href="<?=base_url()?>Results/generate_gpa_pharma"><button value="GPA">Pharma GPA</button></a>
                              </div>
                             
                            <!--  <label class="col-sm-2">Stream<sup class="redasterik" style="color:red">*</sup></label>-->
                              <div class="col-sm-2" id="semest">
                                <!--a href="<?=base_url()?>Results/calculate_percentage_dpharma"><button value="Dpharma">Dpharma GPA</button></a-->
                              </div>

                              <div class="col-sm-2" id="semest">
                              
                            </div>

                            </div>
                        </span>
                        <div class="holder1"></div>
                </div>
            </div>
            </div>    
        </div>
    </div>
</div>