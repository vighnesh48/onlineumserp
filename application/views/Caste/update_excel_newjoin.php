<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<style>
input[type=file]::file-selector-button {
  border: 2px solid #6c5ce7;
  padding: .2em .4em;
  border-radius: .2em;
  background-color: #a29bfe;
  transition: 1s;
}

.form-control {
    height: auto;
}
input[type=file]::file-selector-button:hover {
  background-color: #81ecec;
  border: 2px solid #00cec9;
}</style>
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Masters</a></li>
        <li class="active"><a href="#">Upload pay Data</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon font-16 text-purple"></i>&nbsp;&nbsp;Upload pay Data</h1>
            
        </div>
        <div class="row ">
            <div class="col-sm-12">&nbsp;</div>
        </div>

		<div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                <div class="panel-heading panel-info">
                      <h1> Upload pay Excel</h1>
                       <!--  <div class="holder"></div> -->
                </div>
                <div class="panel-body">
<form class="form-horizontal" action="<?= base_url($currentModule . '/upload_excel_newjoin_data') ?>" method="post"  enctype="multipart/form-data" id="form" name="form">
   <fieldset>
      <div class="form-group">
         <label class="col-md-4  control-label" for="filebutton">Select File:</label>
         <div class="col-md-4">
            <input type="file" class="form-control" name="ex_file" id="ex_file"  class="input-large" >
         </div>
      </div>
      <div class="form-group">
         <div class="col-md-12 text-center">
            <button type="submit" id="submit" name="submit" class="btn btn-primary " >Submit</button>
			<p style="margin-top:20px"><span style="color:red;">*</span><b> Kindly Provide Secondary Student Data in Mention Format. Click Here to Download Excel Format  <a href="<?=base_url($currentModule."/pay_excel_format")?>" ><i class="fa fa-file-excel-o" style="font-size:30px;color:green"></i></a></b></p>
         </div>		 
      </div>	  
   </fieldset>
</form>
</div>
</div>
</div>
</div>
</div>
		
