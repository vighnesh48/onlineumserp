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
            fields: 
            {
                institute_type:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Unit-Test code should not be empty'
                      }
                    }
                },
                institute_name:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Unit-Test name should not be empty'
                      },
                      stringLength: 
                        {
                        max: 50,
                        min: 2,
                        message: 'Unit-Test name should be 2-50 characters.'
                        }
                    }
                },
                state:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'state should not be empty'
                      },
                    }
                },
				city:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'City should not be empty'
                      },
                    }
                },
				pincode:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'pincode  should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[0-9/]+$/,
                        message: 'pincode should be numeric'
                      },
                      stringLength: 
                        {
                        max:6,
                        min: 6,
                        message: 'pincode should be 6 characters.'
                        }
                    }
                },
            }       
        })
    });
</script>
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="#">Add Unit-Test</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Add Unit-Test</h1>
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
                            <span class="panel-title">Unit-Test Details</span>
                    </div>
                    <div class="panel-body">
                        <div class="table-info">                            
                            <?php //if(in_array("Add", $my_privileges)) { ?>
                            <form id="form" name="form" action="<?=base_url($currentModule.'/submit')?>" method="POST">                                                               
                                <input type="hidden" value="<?=$ut[0]['unit_test_id']?>" id="unit_test_id" name="unit_test_id" />
								<div class="form-group">
									<label class="col-sm-3">Class <?=$astrik?></label>    
									<div class="col-sm-3" >
									<select name="room_no" id="room_no" class="form-control" required>
									  <option value="">Select Class</option>
									  <?php
										foreach ($classRoom as $class) {
											if ($class['stream_id'] == $ut[0]['stream_id']) {
												$sel = "selected";
											} else {
												$sel = '';
											}
											echo '<option value="' . $class['stream_id'] . '"' . $sel . '>' . $class['stream_name'] . '</option>';
										}
										?>
								   </select>
								  </div>
								  <label class="col-sm-3">Semester <?=$astrik?></label>
								  <div class="col-sm-3" >
									<select name="semester" id="semester" class="form-control" required>
									  <option value="">Select Semester</option>
								   </select>
								  </div> 
							  </div>
                              
							  <div class="form-group">
									<label class="col-sm-3">Division <?=$astrik?></label>
								  <div class="col-sm-3" >
									<select name="division" id="division" class="form-control" required>
									  <option value="">Select Division</option>
								   </select>
								  </div>
								  <label class="col-sm-3">Subject <?=$astrik?></label>
								  <div class="col-sm-3">
									<select id="subject" name="subject" class="form-control" required>
										<option value="">Select Subject</option>	
									</select>											
								</div> 
							  </div>                             
								
								
                                <div class="form-group">
                                    <label class="col-sm-3">Unit-Test<?=$astrik?></label>                                    
                                    <div class="col-sm-3">
                                        <select id="test_name" name="test_name" class="form-control" required="true" >
                                            <option value="">--Select--</option>
											<option value="1A" <?php if($ut[0]['test_no']=='1A'){ echo "selected";}?>>1A</option>
											<option value="2A" <?php if($ut[0]['test_no']=='2A'){ echo "selected";}?>>2A</option>
											<option value="2B" <?php if($ut[0]['test_no']=='2B'){ echo "selected";}?>>2B</option>
											<option value="3A" <?php if($ut[0]['test_no']=='3A'){ echo "selected";}?>>3A</option>
                                        </select>                                        
                                    </div>    
									<label class="col-sm-3">Date<?=$astrik?></label>
                                    <div class="col-sm-3">
									<!--for update-->
									<input type="text" id="test_date" name="test_date" class="form-control" value="<?=date('d/m/Y', strtotime($ut[0]['test_date']))?>" required>	
									
                                    </div>                                  
                                </div>
								<div class="form-group">
								 <label class="col-sm-3">Min Marks<?=$astrik?></label>
                                    
									 <div class="col-sm-3"><input type="text" id="min_for_pass" name="min_for_pass" class="form-control numbersOnly" value="<?=$ut[0]['min_for_pass']?>" maxlength=3 /></div>
								   	<label class="col-sm-3">Max Marks<?=$astrik?></label>
                                    <div class="col-sm-3">
									<input type="text" id="max_marks" name="max_marks" class="form-control numbersOnly" maxlength=3 value="<?=$ut[0]['max_mark']?>" onClick="return checkMarks()">
									
                                   </div>
                                   	
                                </div>	
								                                
                                <div class="form-group">
                                    <div class="col-sm-4"></div>
                                    <div class="col-sm-2">
                                        <button class="btn btn-primary form-control" id="btn_submit" type="submit" onClick="return checkMarks()">Submit</button>                                        
                                    </div>                                    
                                    <div class="col-sm-2"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule)?>'">Cancel</button></div>
                                    <div class="col-sm-4"></div>
                                </div>
                            </form>
                            <?php //} ?>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </div>
</div>
<script>
function checkMarks(){
    var minmarks = parseInt($("#min_for_pass").val());
    var maxmarks = parseInt($("#max_marks").val());
    if(minmarks > maxmarks){
        alert("The Min marks should be smallar than Max marks");
        $("#min_for_pass").val("");
         $("#min_for_pass").focus();
        return false;
    }
    return true;
}
$('#test_date').datepicker( {format: 'dd/mm/yyyy',autoclose: true});
		$('#room_no').on('change', function () {
			
			var room_no = $(this).val();
			if (room_no) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>attendance/load_sem',
					data: 'room_no=' + room_no,
					success: function (html) {
						//alert(html);
						$('#semester').html(html);
					}
				});
			} else {
				$('#semester').html('<option value="">Select course first</option>');
			}
		});
		
		$("#semester").change(function(){
			var room_no = $("#room_no").val();
			var semesterId = $("#semester").val();
			
			$.ajax({
				'url' : base_url + 'Attendance/load_division',
				'type' : 'POST', //the way you want to send data to your URL
				'data' : {'room_no' : room_no,'semesterId':semesterId},
				'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
					var container = $('#division'); //jquery selector (get element by id)
					if(data){
						//alert(data);
						container.html(data);
						//$("#semest option[value='" + stream_id + "']").attr("selected", "selected");
					}
				}
			});
		});
				
		$("#division").change(function(){
			var room_no = $("#room_no").val();
			var semesterId = $("#semester").val();
			var divs = $("#division").val();
			$.ajax({
				'url' : base_url + 'Attendance/load_subject',
				'type' : 'POST', //the way you want to send data to your URL
				'data' : {'room_no' : room_no,'semesterId':semesterId,'division':divs},
				'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
					var container = $('#subject'); //jquery selector (get element by id)
					if(data){
						//alert(data);
						container.html(data);
						//$("#semest option[value='" + stream_id + "']").attr("selected", "selected");
					}
				}
			});
		});
        
//edit subject
		var classid = $("#room_no").val();
		var semesterid = '<?=$ut[0]['semester'] ?>';
		var division = '<?=$ut[0]['division']?>';
		var strmid = '<?=$ut[0]['stream_id']?>';
		//alert(course_id);
		if (classid) {
			$.ajax({
				'url' : base_url + '/Attendance/load_subject',
				'type' : 'POST', //the way you want to send data to your URL
				'data' : {'room_no' : classid,'semesterId':semesterid,'division':division},
				'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
					var container = $('#subject'); //jquery selector (get element by id)
					if(data){
						//alert(data);
						var subject = '<?=$ut[0]['subject_id'].'-'.$ut[0]['batch_code']?>';
						//alert(subject);
						container.html(data);
						$("#subject option[value='" + subject + "']").attr("selected", "selected");
					}
				}
			});
		}
		if (strmid !='' && semesterid !='') {
			$.ajax({
				'url' : base_url + '/Attendance/load_division',
				'type' : 'POST', //the way you want to send data to your URL
				'data' : {'room_no' : strmid,'semesterId':semesterid},
				'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
					var container = $('#division'); //jquery selector (get element by id)
					if(data){
						//alert(data);
						var division1 = '<?=$ut[0]['division']?>';
						//alert(subject);
						container.html(data);
						$("#division option[value='" + division1 + "']").attr("selected", "selected");
					}
				}
			});
		}
		var course_id = $("#room_no").val();
		//alert(course_id);
		if (course_id) {
			$.ajax({
				'url' : base_url + '/Attendance/load_sem',
				'type' : 'POST', //the way you want to send data to your URL
				'data' : {'room_no' : course_id},
				'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
					var container = $('#semester'); //jquery selector (get element by id)
					if(data){
						var stream_id = '<?=$ut[0]['semester']?>';
						container.html(data);
						$("#semester option[value='" + stream_id + "']").attr("selected", "selected");
					}
				}
			});
		}
    </script>
    <script type="text/javascript">
$(document).ready(function(){
 
    $('#college_state').on('change',function(){
        var stateID = $(this).val();
        if(stateID){
            $.ajax({
                type:'POST',
                url:'<?= base_url()?>school/fetch_city_bystate',
                data:'state_id='+stateID,
                success:function(html){
                    $('#college_city').html(html);
                }
            }); 
        }else{
            $('#college_city').html('<option value="">Select state first</option>'); 
        }
    });
    $("#college_state").select2({
        placeholder: "Select State",
        allowClear: true
    }); 
	$("#college_city").select2({
        placeholder: "Select City",
        allowClear: true
    }); 
    $('.numbersOnly').keyup(function () {
		if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
		   this.value = this.value.replace(/[^0-9\.]/g, '');
		}
	});
});
});
</script>