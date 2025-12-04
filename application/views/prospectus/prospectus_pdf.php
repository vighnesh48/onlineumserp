<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
<style>.image {
        position: relative;
        margin-bottom: 20px;
        width: 100%;
        height: 300px;
        color: white;
        background: url('<?php echo base_url('assets/images/admission_pdf/1.jpg');?>') no-repeat;
        background-size: 250px 250px;
    }</style>

</head>

<body> 
	<?php if($regular=='2') {?>
<div class="page-container">

	
<div>

	<div style="text-align:right; padding-top:10px; padding-right: 20px;  width:100%;  height: 100%; background: url('<?php echo base_url('assets/images/admission_pdf/1.jpg');?>') no-repeat;background-size: 100%;"><img  src="<?php echo base_url('barcodes/'.$barcode_no.'.png');?>"></div>
</div>
<div><img src="<?php echo base_url('assets/images/admission_pdf/2.jpg');?>"></div>
<div><img src="<?php echo base_url('assets/images/admission_pdf/3.jpg');?>"></div>
<div><img src="<?php echo base_url('assets/images/admission_pdf/4.jpg');?>"></div>
<div><img src="<?php echo base_url('assets/images/admission_pdf/5.jpg');?>"></div>
<div><img src="<?php echo base_url('assets/images/admission_pdf/6.jpg');?>"></div>
</div>
<?php } else { ?>

<div class="page-container">
<div>

	<div style="text-align:right; padding-top:50px; padding-right: 20px;  width:100%;  height: 100%; background: url('<?php echo base_url('assets/images/admission_pdf/partime/1.jpg');?>') no-repeat;background-size: 100%;"><img  src="<?php echo base_url('barcodes/'.$barcode_no.'.png');?>"></div>

  
  
</div>
<div><img src="<?php echo base_url('assets/images/admission_pdf/partime/2.jpg');?>"></div>
<div><img src="<?php echo base_url('assets/images/admission_pdf/partime/3.jpg');?>"></div>
<div><img src="<?php echo base_url('assets/images/admission_pdf/partime/4.jpg');?>"></div>
</div>
<?php } ?>

</body>
</html>