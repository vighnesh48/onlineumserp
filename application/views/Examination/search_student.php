<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>

<script>    
	$(document).ready(function()
		{
			$('#form1').bootstrapValidator	
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
						search_id:	
						{
							validators: 
							{
								notEmpty: 
								{
									message: 'Please Enter Student Id,this should not be empty'
								}                     
							}
						}
					}
				})	
		});
	
	
	
	$(document).ready(function(){
			$('#sbutton').click(function(){
            
					// alert("hi");
					var base_url = '<?=base_url();?>';
					// alert(type);
					var prn = $("#prn").val();
					var exam_date=$('#exam_date').val();					var exam_session = $("#exam_session").val();
					//alert(exam_date);
					prn = prn.trim();
					if(prn=='' )
					{
						alert("Please enter the PRN");
						return false;
					}
                    
                    
           
					$.ajax({
							'url' : base_url + 'Examination/search_studentdata_for_malware',
							'type' : 'POST', //the way you want to send data to your URL
							'data' : {'prn':prn,'exam_date':exam_date,'exam_session':exam_session},
							'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
								var container = $('#stddata'); //jquery selector (get element by id)
								if(data){
                            
									container.html(data);
									return false;
								}
								return false;
							}
						});
				});
		});
            
</script>
<?php
$astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
<ul class="breadcrumb breadcrumb-page">
	<div class="breadcrumb-label text-light-gray">You are here: </div>
	<li><a href="#">Examination</a></li>
	<li class="active"><a href="#">Malpractice</a></li>
</ul>
<div class="page-header">			
	<div class="row">
		<h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Malpractice Marking</h1>
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
						<span class="panel-title"><i class="panel-title-icon fa fa-fire text-danger">Malpractice</i></span>
					</div>
					<div class="panel-body">
						<br>
						<!--<form id="form1" name="form1" enctype="multipart/form-data" action="<?=base_url($currentModule.'/search_student')?>" method="POST">-->
						<div class="row">
							<div class="form-group">
							<label class="col-sm-2">Exam Session</label>
								<div class="col-sm-2">
								<select name="exam_session" id="exam_session" class="form-control" required>
								<option value="">Select Exam Session</option>
                               
								<?php
								foreach($exam_session as $exsession){
									$exam_sess = $exsession['exam_month'] .'-'.$exsession['exam_year'];
									$exam_sess_val = $exsession['exam_month'] .'-'.$exsession['exam_year'] .'-'.$exsession['exam_id'];
									if($exam_sess_val == $_REQUEST['exam_session']){
										$sel = "selected";
									} else{
										$sel = '';
									}
									echo '<option value="' . $exam_sess_val. '"' . $sel . '>' .$exam_sess.'</option>';
								}
								?>
									
								</select>	
								</div>
								<div class="col-sm-2">
							<select name="exam_date" id="exam_date" class="form-control" required >
								<option value="">Exam Dates</option>
								<?php
								foreach($ex_dates as $exd){
									if($exd['exam_date'] == $exam_date){
										$sel = "selected";
									} else{
										$sel = '';
									}
									echo '<option value="' . $exd['exam_date'] . '"' . $sel . '>' . date('d-m-Y',strtotime($exd['exam_date'])) . '</option>';
								}
								?></select>
						</div>
								
								<div class="col-sm-3"><input type="text" class="form-control" name="prn" id="prn" placeholder="Enter PRN No."></div>
								<div class="col-sm-2"><button class="btn btn-primary form-control" id="sbutton" type="button" >Search</button> </div>
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