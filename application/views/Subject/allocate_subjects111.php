<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<script>    
    $(document).ready(function()
    {
        $('#form').bootstrapValidator
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
                subject_name:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Please enter subject name'
                      }
                    }

                },
                subject_code:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Subject code should not be empty'
                      },
                      stringLength: 
                        {
                        max: 20,
                        min: 2,
                        message: 'Subject code should be 2-20 characters.'
                        }
                    }
                },
                subject_type:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Subject type should not be empty'
                      }
                    }
                },
                stream_id:
                {
                    validators: 
                    {                      
                      notEmpty: 
                      {
                       message: 'stream should not be empty'
                      }
                    }

                },
				semester:
                {
                    validators: 
                    {                      
                      notEmpty: 
                      {
                       message: 'semester should not be empty'
                      }
                    }

                },
				subject_group:
                {
                    validators: 
                    {                      
                      notEmpty: 
                      {
                       message: 'subject group should not be empty'
                      }
                    }

                },
				subject_component:
                {
                    validators: 
                    {                      
                      notEmpty: 
                      {
                       message: 'subject component should not be empty'
                      }
                    }

                },
				theory_max:
                {
                    validators: 
                    {                      
                      notEmpty: 
                      {
                       message: 'theory max should not be empty'
                      }
                    }

                },
				theory_min_for_pass:
                {
                    validators: 
                    {                      
                      notEmpty: 
                      {
                       message: 'theory min should not be empty'
                      }
                    }

                },
				internal_max:
                {
                    validators: 
                    {                      
                      notEmpty: 
                      {
                       message: 'internal max should not be empty'
                      }
                    }

                },
				internal_min_for_pass:
                {
                    validators: 
                    {                      
                      notEmpty: 
                      {
                       message: 'internal min should not be empty'
                      }
                    }

                },
				sub_max:
                {
                    validators: 
                    {                      
                      notEmpty: 
                      {
                       message: 'sub max should not be empty'
                      }
                    }

                },
				sub_min:
                {
                    validators: 
                    {                      
                      notEmpty: 
                      {
                       message: 'sub min should not be empty'
                      }
                    }

                },
            }       
        })
		
		// Num check logic
		$('.numbersOnly').keyup(function () {
			if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
			   this.value = this.value.replace(/[^0-9\.]/g, '');
			} 
		});
		//
		var course_id = $("#course_id").val();
		//alert(course_id);
		if (course_id) {
			$.ajax({
				'url' : base_url + '/Subject/load_streams',
				'type' : 'POST', //the way you want to send data to your URL
				'data' : {'course' : course_id},
				'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
					var container = $('#semest'); //jquery selector (get element by id)
					if(data){
						var stream_id = '<?= $subdet[0]['stream_id'] ?>';
						container.html(data);
						$("#semest option[value='" + stream_id + "']").attr("selected", "selected");
					}
				}
			});
		}
		
    });

</script>
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="#">Add Subject</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Add Subject</h1>
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
                            <span class="panel-title">Subject Details</span>
                    </div>
                    <div class="panel-body">
                        <div class="table-info">                            
                            <?php //if(in_array("Add", $my_privileges)) { ?>
                            <form id="form" name="form" action="<?=base_url($currentModule.'/insert_subject')?>" method="POST">                                                               
                                <input type="hidden" value="<?=isset($subdet[0]['sub_id']) ? $subdet[0]['sub_id'] : ''?>" id="sub_id" name="sub_id" />
								<div class="form-group">
                              <label class="col-sm-3">Admission To (Course) <?= $astrik ?></label>
                              <div class="col-sm-3" >
                                <select name="course_id" id="course_id" class="form-control" onchange="load_streams(this.value)" required>
                                  <option value="">Select</option>
                                  <?php
									foreach ($course_details as $course) {
										if ($course['course_id'] == $subdet[0]['course_id']) {
											$sel = "selected";
										} else {
											$sel = '';
										}
										echo '<option value="' . $course['course_id'] . '"' . $sel . '>' . $course['course_name'] . '</option>';
									}
									?>
                               </select>
                              </div>
                              <script>
                                     var base_url = '<?php
										echo site_url();
										?>';
                                      function load_streams(type){
											   // alert(type);
												
											$.ajax({
												'url' : base_url + '/Subject/load_streams',
												'type' : 'POST', //the way you want to send data to your URL
												'data' : {'course' : type},
												'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
													var container = $('#semest'); //jquery selector (get element by id)
													if(data){
													 //   alert(data);
														//alert("Marks should be less than maximum marks");
														//$("#"+type).val('');
														container.html(data);
													}
												}
											});
										}
										
                                    </script>
                              <label class="col-sm-3">Branch(Stream) <?= $astrik ?></label>
                              <div class="col-sm-3" id="semest" >
                                <select name="stream_id" class="form-control" required>
                                  <option value="">Select</option>
                                  <?php
									foreach ($branches as $branch) {
										if ($branch['branch_code'] == $subdet[0]['strem_id']) {
											$sel = "selected";
										} else {
											$sel = '';
										}
										echo '<option value="' . $branch['branch_code'] . '" ' . $sel . '>' . $branch['branch_code'] . '</option>';
									}
									?>
                               </select>
                              </div>
                            </div>
                                <div class="form-group">
									<label class="col-sm-3">Subject Name <?=$astrik?></label>                                    
									<div class="col-sm-3">
                                        <input type="text" id="subject_name" name="subject_name" class="form-control" value="<?=isset($subdet[0]['subject_name']) ? $subdet[0]['subject_name'] : ''?>" placeholder="Subject Name" />                                  
                                    </div> 
                                    <label class="col-sm-3">Subject Code <?=$astrik?></label>                                    
									<div class="col-sm-3">
                                        <input type="text" id="subject_code" name="subject_code" class="form-control" value="<?=isset($subdet[0]['subject_code']) ? $subdet[0]['subject_code'] : ''?>" placeholder="Subject Code" />                                  
                                    </div>                                  
                                    
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3">Subject Short Name <?=$astrik?></label>
                                    <div class="col-sm-3"><input type="text" id="subject_short_name" name="subject_short_name" class="form-control" value="<?=isset($subdet[0]['subject_short_name']) ? $subdet[0]['subject_short_name'] : ''?>" /></div>                                    
                                    <label class="col-sm-3">Subject Type<?=$astrik?></label>
								    <div class="col-sm-3">
									  <select id="subject_type" name="subject_type" class="form-control" >
                                            <option value="">Select Type </option>
                                            <?php for($i=0;$i<count($subtype);$i++) {
												if ($subtype[$i]['sub_type'] == $subdet[0]['subject_type']) {
												$sel2 = "selected";
												} else {
													$sel2 = '';
												}	
											?>
                                            <option value="<?=$subtype[$i]['sub_type']?>" <?=$sel2?>><?=$subtype[$i]['sub_type']?></option>
                                            <?php } ?>
                                        </select>
								    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3">Semester<?=$astrik?></label>
                                    <div class="col-sm-3">
									<select id="semester" name="semester" class="form-control" >
                                            <option value="">Select Semester</option>
											<?php for($i=1;$i<9;$i++) {
												if ($i == $subdet[0]['semester']) {
												$sel3 = "selected";
												} else {
													$sel3 = '';
												}
											?>
                                            <option value="<?=$i?>" <?=$sel3?>><?=$i?></option>
                                            <?php } ?>
											</select>
									</div>                                    
                                    <label class="col-sm-3"> </label>
								    <div class="col-sm-3">
									 
								    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3">Subject Group<?=$astrik?></label>
                                    <div class="col-sm-3"><input type="text" id="subject_group" name="subject_group" class="form-control" value="<?=isset($subdet[0]['subject_group']) ? $subdet[0]['subject_group'] : ''?>" /></div>                                    
                                    <label class="col-sm-3">Subject Component</label>
								    <div class="col-sm-3">
									  <select id="subject_component" name="subject_component" class="form-control" >
                                            <option value="">Select Component</option>
                                            <?php for($i=0;$i<count($subcmpt);$i++) {
												if ($subcmpt[$i]['sub_component'] == $subdet[0]['subject_component']) {
												$sel4 = "selected";
												} else {
													$sel4 = '';
												}
											?>
                                            <option value="<?=$subcmpt[$i]['sub_component']?>" <?=$sel4?>><?=$subcmpt[$i]['sub_component']?></option>
                                            <?php } ?>
                                        </select>
								    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3">Theory Max<?=$astrik?></label>
                                    <div class="col-sm-3"><input type="text" id="theory_max" name="theory_max" class="form-control numbersOnly" maxlength="3" value="<?=isset($subdet[0]['theory_max']) ? $subdet[0]['theory_max'] : ''?>" /></div>                                    
                                    <label class="col-sm-3">Theory Min for Pass</label>
								    <div class="col-sm-3"><input type="text" id="theory_min_for_pass" name="theory_min_for_pass" class="form-control numbersOnly" maxlength="3" value="<?=isset($subdet[0]['theory_min_for_pass']) ? $subdet[0]['theory_min_for_pass'] : ''?>" /></div>
                                </div>                                
                                <div class="form-group">
                                    <label class="col-sm-3">Internal Max<?=$astrik?></label>
                                    <div class="col-sm-3"><input type="text" id="internal_max" name="internal_max" class="form-control numbersOnly" maxlength="3" value="<?=isset($subdet[0]['internal_max']) ? $subdet[0]['internal_max'] : ''?>" /></div>                                    
                                    <label class="col-sm-3">Internal Min for Pass</label>
								    <div class="col-sm-3"><input type="text" id="internal_min_for_pass" name="internal_min_for_pass" class="form-control numbersOnly" maxlength="3" value="<?=isset($subdet[0]['internal_min_for_pass']) ? $subdet[0]['internal_min_for_pass'] : ''?>" /></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3">Sub Min<?=$astrik?></label>
                                    <div class="col-sm-3"><input type="text" id="sub_min" name="sub_min" class="form-control numbersOnly" maxlength="3" value="<?=isset($subdet[0]['sub_min']) ? $subdet[0]['sub_min'] : ''?>" /></div>                                    
                                    <label class="col-sm-3">Sub Max</label>
								    <div class="col-sm-3"><input type="text" id="sub_max" name="sub_max" class="form-control numbersOnly" maxlength="3" value="<?=isset($subdet[0]['sub_max']) ? $subdet[0]['sub_max'] : ''?>" /></div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-4"></div>
                                    <div class="col-sm-2">
                                        <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Submit</button>                                        
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