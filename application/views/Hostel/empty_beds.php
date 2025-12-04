<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
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
                   var campus = $("#campus").val();
                    var host_id = $("#host_id").val();
                 var academic = $("#academic").val();
                    if(campus=='')
                    {
                        $('#err_msg').html("Please Select Campus");
						$('#maincontent').hide();
						$('#bedsdetailcontent').hide();
                        return false;
                    }
                   
                    
                    
           
                $.ajax({
                    'url' : base_url + 'Hostel/emptybeds_count_data',
                    'type' : 'POST', //the way you want to send data to your URL
                    'data' : {'campus':campus,'host_id':host_id,'academic':academic},
                    'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
                        var container = $('#itemContainer'); //jquery selector (get element by id)
						var content='';
                        if(data){
							//alert(data);
							 if(data === "{\"emptybeds_details\":[]}")
							{
								
								$('#maincontent').hide();
								$('#bedsdetailcontent').hide();
								$('#err_msg').html('All beds are filled.'); 
							}
							else
							{
								$('#err_msg').html('');
								var array=JSON.parse(data);
								len=array.emptybeds_details.length;
								var j=1;
								for(i=0;i<len;i++)
								{
									content+='<tr><td>'+j+'</td><td>'+array.emptybeds_details[i].campus_name+'</td><td>'+academic+'</td><td>'+array.emptybeds_details[i].hostel_code+'</td><td>'+array.emptybeds_details[i].tot_count+'</td><td><a title="View Hostel\'s Empty beds Detail" class="btn btn-primary btn-xs" onclick="emptybedsdetails(this.id,'+academic+')" id="'+array.emptybeds_details[i].host_id+'">View</a></td></tr>';
									j++;
								}
							}
                            //alert("Marks should be less than maximum marks");
                            //$("#"+type).val('');
                            container.html(content);
							$('#maincontent').show();
							$('#bedsdetailcontent').hide();
                            	return false;
                        }
                          return false;
                    }
                });
				

            });
			

     });

function excel_report(id,academic_y)
{
	//alert('testing');
	 $.ajax({
		'url' : base_url + 'Hostel/excel_emptybeddetail',
		'type' : 'POST', //the way you want to send data to your URL
		'data' : {'host_id':id,'academic':academic_y},
		'success' : function(data){ alert(data);}
	 });
} 
	 
 function emptybedsdetails(id,academic_y)
 {
	 $.ajax({
		'url' : base_url + 'Hostel/emptybeddetail',
		'type' : 'POST', //the way you want to send data to your URL
		'data' : {'host_id':id,'academic':academic_y},
		'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
			var container = $('#emptybeddetail'); //jquery selector (get element by id)
			var content='';
			if(data){
				//alert(data);
				 if(data === "{\"emptybeddetail\":[]}")
				{
					$('#err_msg').html('All beds are filled.'); 
					$('#bedsdetailcontent').hide();
				}
				else
				{
					$('#err_msg').html('');
					var array=JSON.parse(data);
					len=array.emptybeddetail.length;
					var j=1;
					var floor_no='';
					var total=0;
					for(i=0;i<len;i++)
					{
						if(array.emptybeddetail[i].floor_no==0)
							floor_no='G';
						else
							floor_no=array.emptybeddetail[i].floor_no;
						content+='<tr><td>'+j+'</td><td>'+array.emptybeddetail[i].hostel_code+'</td><td>'+floor_no+'</td><td>'+array.emptybeddetail[i].room_no+'</td><td>'+array.emptybeddetail[i].beds_available+'</td></tr>';
						
						total+=parseInt(array.emptybeddetail[i].beds_available);
						j++;
					}
					content+='<tr style="font:bold"><th colspan="4">Total</th><th>'+total+'</th></tr>';
					container.html(content);
					$('#bedsdetailcontent').show();
					$('#hid').val(id);
					$('#acyear').val(academic_y);
					//$('#exportlink').attr("onclick", 'excel_report('+id+','+academic_y+')');
					return false;

				}
				//alert("Marks should be less than maximum marks");
				//$("#"+type).val('');
			}
			  return false;
		}
	});
 }
</script>
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="<?=base_url($currentModule)?>">Hostel</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Empty Beds List</h1>
           <span id="err_msg" style="color:red;padding-left:10px;"></span>
			<span id="flash-messages" style="color:Green;padding-left:10px;">
						 <?php if(!empty($this->session->flashdata('message1'))){ echo $this->session->flashdata('message1'); } ?></span>
					<span id="flash-messages" style="color:red;padding-left:50px;">
						 <?php if(!empty($this->session->flashdata('message2'))){ echo $this->session->flashdata('message2'); } ?></span>
			
        </div>

        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                     

                   
                     <div class="panel-heading">
                        <div class="row">
					 
							  <div class="col-sm-3">
									
									<select id="campus" name="campus" class="form-control" >
										<option value="">Select Campus</option>
										
									  <?php //echo "state".$state;exit();
										if(!empty($campus)){
											foreach($campus as $campusname){
												?>
											  <option value="<?=$campusname['campus_name']?>"><?=$campusname['campus_name']?></option>  
											<?php 
												
											}
										}
									  ?>
									</select> 
																		

							  
							  </div>
						   						  
							   <div class="col-sm-3">
							   
								<select class="form-control" name="host_id" id="host_id" required>
									  <option value="">select Hostel</option>
									  <?php //echo "state".$state;exit();
										if(!empty($hostel_details)){
											foreach($hostel_details as $hostels){
												?>
											  <option value="<?=$hostels['host_id']?>||<?=$hostels['hostel_code']?>||<?=$hostels['no_of_floors']?>"><?=$hostels['hostel_name']?></option>  
											<?php 
												
											}
										}
									  ?>
								  </select>
							  </div>
							  
							  
								<div class="col-sm-3">
								
									<select class="form-control" name="academic" id="academic" required>
									  <option value="">Select Academic Year</option>
                                           <?php //echo "state".$state;exit();
										if(!empty($academic_details)){
											foreach($academic_details as $academic){
												$arr=explode("-",$academic['academic_year']);
												$ac_year=$arr[0];
												if($academic['status']=='Y')
												{
												?>
											  <option selected value="<?=$ac_year?>"><?=$academic['academic_year']?></option>  
											<?php 
												}else{
												?>
												<option value="<?=$ac_year?>"><?=$academic['academic_year']?></option> 
												<?php
												}
												
											}
										}
									  ?>
								  </select>
								</div>
								
							  <div class="col-sm-2">
								<button class="btn btn-primary form-control" id="sbutton" type="button" >Search</button>
							  </div>

					 
                </div>
			    		</div>
			    		<div class="panel-body">
								<div class="row " id="maincontent" style="display:none;">
									<div class="table-info col-sm-6" >    
									<span style="font-weight:bold;font-size:15px;">Hostel wise empty beds</span>
									<table class="table table-bordered">
										<thead>
										<tr>
													<th>#</th>
													<th>Campus</th>
													<th>Academic Year</th>
													<th>Hostel</th>
													<th>#Beds</th>
													<th>Action</th>
											</tr>
										</thead>
										<tbody id="itemContainer">
																	  
										</tbody>
									</table>                    
								   
									</div>
									<div class="table-info  col-sm-5 pull-right" id="bedsdetailcontent" style="display:none; overflow-x:scroll;height:400px;">    
									<span style="font-weight:bold;">Floor wise empty beds list of a hostel:</span>
									<table class="table table-bordered">
										<thead>
										<tr>
													<th>#</th>
													<th>Hostel</th>
													<th>#Floor</th>
													<th>#Room</th>
													<th>#Bed Available</th>
													
											</tr>
										</thead>
										<tbody id="emptybeddetail">
																	  
										</tbody>
									</table>
<form name="form" id="form" action="<?=base_url($currentModule.'/excel_emptybeddetail');?>" method="POST"><input type="hidden" id="hid" name="hid"><input type="hidden" id="acyear" name="acyear">
									<button class="btn btn-default btn-labeled pull-right" id="exportlink" >Excel</button>
									</form>
									</div>
								</div>
								
								<div class="row" >
									
								</div>
						</div>    
				
				</div>
			</div>
		</div>
</div>
<script>
	$(document).ready(function()
		{
			//alert("hello");
			var enroll='<?=$this->uri->segment(3)?>';
			var ac_year='<?=$this->uri->segment(4)?>';
	
			var org='<?=$this->uri->segment(5)?>';
			//alert(enroll);alert(ac_year);alert(org);
			if(enroll!="" && org!="")
			{
				$('#org option').each(function()
					{              
						if($(this).val()== org)
						{
							$(this).attr('selected','selected');
						}
					});
				$('#acyear option').each(function()
					{              
						if($(this).val()== ac_year)
						{
							$(this).attr('selected','selected');
						}
					});
				$("#prn").val(enroll);
				$("#sbutton").trigger("click");
			}

			$('#campus').on('change', function () {
		var	campus = $(this).val();
		//check_student_exists();
		//alert(college);
		if (campus) {
			$.ajax({
						type: 'POST',
						url: '<?= base_url() ?>Hostel/get_hostel_by_campus',
						data: 'campus=' + campus,
						success: function (html) {
							//alert(html);
							$('#host_id').html(html);
						}
			});
		} else {
			$('#host_id').html('<option value="">Select Hostel </option>');
		}
	});
	
	   
		});
</script>