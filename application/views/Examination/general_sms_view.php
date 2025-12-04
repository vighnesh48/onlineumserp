<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>

<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-maxlength/1.7.0/bootstrap-maxlength.min.js"></script>
</head>

<?php
$astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
<ul class="breadcrumb breadcrumb-page">
	<div class="breadcrumb-label text-light-gray">You are here: </div>
	<li><a href="#">Examination</a></li>
	<li class="active"><a href="#">SMS</a></li>
</ul>
<div class="page-header">			
	<div class="row">
		<h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;SEND MESSAGE</h1>
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
				<div id="dashboard-recent" class="panel panel-warning">        
					<div class="panel-heading">
						<span class="panel-title"><i class="panel-title-icon fa fa-fire text-danger">SEND SMS</i></span>
					</div>
					<div class="panel-body">
						<br>
						<!--<form id="form1" name="form1" enctype="multipart/form-data" action="<?=base_url($currentModule.'/general_sms')?>" method="POST">-->
						<div class="row">
							<div class="form-group">
								<label class="col-sm-2" style="text-align:right">Mobile No.</label>
								<div class="col-sm-5">
									<input type="text" class="form-control" name="mobiles" id="mobiles" required>	
								</div>
								<div class="col-sm-5">
									* Please enter comma separated mobile no.	
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-2" style="text-align:right">Message.</label>
								<div class="col-sm-5">
									<textarea class="form-control" name="message" id="message" style="resize:none" maxlength="120" required></textarea>
									
								</div>
								<div class="col-sm-5">* Please enter 120 character message.</div>
							</div>
								
							<div class="form-group">
								<label class="col-sm-2"></label>
								<div class="col-sm-2">
									<button class="btn btn-primary form-control" id="sbutton" type="button" >SEND</button>	
								</div>
							</div>
								
							<!-- </form>-->
						</div>
                
						<div class="table-info" id="stddata">    
                 
						</div>
          
					</div>    
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
        $('textarea').maxlength({
              alwaysShow: true,
              threshold: 10,
              warningClass: "label label-success",
              limitReachedClass: "label label-danger",
              separator: ' out of ',
              preText: 'You write ',
              postText: ' chars.',
              validate: true,
              placement: 'bottom-right'
        });
$(document).ready(function () {		
	$('#sbutton').on('click', function () {
		var mobiles = $("#mobiles").val();
		var message = $("#message").val();
		//alert(standard);
		if (mobiles !='' && message !='') {
			if(confirm("Are you sure you want to send sms?")){
			$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>Examination/general_sms',
					data: {mobiles:mobiles,message:message},
					success: function (html) {
						
						if(html=='success'){
							alert('Message sent Successfully.');
							$("#mobiles").val('');
							$("#message").val('');
						}
					}
				});
			}
		} else {
			alert('Please enter required fields');
		}
	}); 	
}); 
    </script>
