<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.min.js"></script>

<script>
$(document).ready(function() {
  $('#stopic_no').multiselect({
    buttonWidth : '160px',
    //includeSelectAllOption : true,
	enableFiltering: true
  });
    });
  </script>
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
	$tp = $this->uri->segment(3);
	if($tp!=''){
		$ed ="Add Planning";
	}else{
		$ed ="Add Planning";
	}
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Lecture</a></li>
        <li class="active"><a href="#"><?=$ed?></a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-book page-header-icon"></i>&nbsp;&nbsp;<?=$ed?></h1>
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
                            <span class="panel-title"><b>Subject Name:</b><?=$sub[0]['subject_name'].' ('.$sub[0]['subject_code'].')'?>, <b>Stream Name:</b><?=$sub[0]['stream_short_name']?>, <b>Semester:</b><?=$sub[0]['semester']?>, <b>Batch:</b><?=$sub[0]['batch']?></span>
							<span class="pull-right"><a href="<?=base_url()?>lessonplan/plandetails/<?=base64_encode($subdetails)?>"><button class="btn btn-info" style="margin-top: -5px;">Back</button></a></span>
                    </div>
                    <div class="panel-body">
                        <div class="table-info">
                            <?php 
                          
                            $dup_msg = $this->session->flashdata('dup_msg');
                            if(!empty($dup_msg)){
                                ?>
                            <div class="form-group">
                              <label class="col-sm-12" style="color:red"> <?= $dup_msg ?></label>     
                            </div>
                            <?php
                            }
                            ?>
							
						<form id="form" name="form" action="<?=base_url()?>lessonplan/update" method="POST">
                           <input type="hidden" name="subject_id" id="subject_id" value="<?=$sub[0]['sub_id']?>">
						   
						   <?php
						   foreach($wdays as $wdy){
							   $dayw =$wdy['wday'];
								for($i=1; $i<=26; $i++){
									$lect_dates[] = date("Y-m-d", strtotime('+'.$i.' '.$dayw.'')); 
								}
							}
							function date_sort($a, $b) {
								return strtotime($a) - strtotime($b);
							}
							usort($lect_dates, "date_sort");
							?>

						     <input type="hidden" name="sub_details" id="sub_details" value="<?=$subdetails?>">
                            <div class="form-group">   
								<label class="col-sm-2">Academic year <?= $astrik ?></label>
	                            <div class="col-sm-2" >
	                                <select name="academic_year" id="academic_year" class="form-control" required>
	                                  <option value="">Select</option>
	                                 <?php /*print_r($academic_year);
	                                 die;*/ foreach ($academic_year as $yr) {
										if ($yr['academic_year'].'~'.$yr['academic_session'] == $lessonplan[0]['academic_year']) {
											$sel = "selected";
										} else {
											$sel = '';
										}
										echo '<option value="' . $yr['academic_year'].'~'.$yr['academic_session']. '" selected>' . $yr['academic_year'] .'-'.$yr['academic_session'].'</option>';
									}
									?>
	                                </select>
	                            </div>
								
								<label class="col-sm-2">Lecture Date<?= $astrik ?></label>
	                            <div class="col-sm-2" >
	                                <select name="planned_date" id="planned_date" class="form-control" required>
									<option value="">select</option>
	                                    <?php foreach($lect_dates as $ldates) {?>
										<option value="<?=$ldates?>" <?=$sel1?>><?=$ldates?></option>
									 <?php } ?>
	                                </select>
	                            </div>
								<label class="col-sm-2">Lecture <?= $astrik ?></label>
	                            <div class="col-sm-2" >
	                                <select name="lecture_no" id="lecture_no" class="form-control" required>
									<option value="">select</option>
	                                    <?php for($i=1;$i<51;$i++) {
	                                    if(!empty($syllbus[0]['topic_no'])){
	                                       $topicno = $syllbus[0]['topic_no'];
	                                   }else{
	                                       $topicno = $topic_no;
	                                   }   
	                                    if($i==$topicno){
	                                        $sel1="selected";
	                                    }else{ $sel1='';}
	                                 ?>
										<option value="<?=$i?>" <?=$sel1?>><?=$i?></option>
									 <?php } ?>
	                                </select>
	                            </div>
                            </div>
							<div class="form-group"> 
							
							<label class="col-sm-2">Topic Name <?= $astrik ?></label>
	                            <div class="col-sm-2">
	                                <select name="topic_no" id="topic_no" class="form-control" required>
	                                  <option value="" >Select</option>
	                                  <?php foreach ($topics as $topc) {
										$topic_val = $topc['unit_no'].'.'.$topc['topic_no'];
										echo '<option value="'.$topic_val. '"' . $sel . '>' . $topic_val.'
										'.$topc['topic_name'].'</option>';
									}
									?>
	                                </select>
	                            </div>
	                            <label class="col-sm-2">Subtopic Name <?= $astrik ?></label>
	                           <div class="col-sm-6" id="lsubtopic">
	                               
	                            </div>
	                           
	                           
                            </div>
							<div class="form-group">
							<label class="col-sm-2">Type details <?= $astrik ?></label>
	                           <div class="col-sm-2">
	                                <input type="text" name="topic_contents" id="topic_contents" class="form-control" required> 
	                            </div>
								<label class="col-sm-2">Pedagogical Tool <?= $astrik ?></label>
	                            <div class="col-sm-2" >
	                                <select name="pedagogical" id="pedagogical" class="form-control" required>
	                                  <option value="">Select</option>
										<option value="R">R</option>
	                                </select>
	                            </div>

							 	
							</div>
							</div>
							<div class="row">
							<label class="col-sm-12" style="text-align:center;"><b>Weightage in Examination </b></label>
							</div><br>
							<div class="row">
							<div class="form-group">
								<label class="col-sm-1">SUN</label>
	                            <div class="col-sm-2" >
	                                <select name="sun" id="sun" class="form-control" required>
	                                  <option value="">Select</option>
										<option value="R">R</option>
	                                </select>
	                                 
	                            </div>
								<label class="col-sm-1">Gate</label>
									<div class="col-sm-2" >
	                                <select name="gate" id="gate" class="form-control" required>
	                                  <option value="">Select</option>
										<option value="R">R</option>
	                                </select>
	                                 
	                            </div>
								<label class="col-sm-1">U/Mpsc</label>
								<div class="col-sm-2" >
	                                <select name="umpsc" id="umpsc" class="form-control" required>
	                                  <option value="">Select</option>
										<option value="R">R</option>
	                                </select>
	                                 
	                            </div>
								<label class="col-sm-1">Other</label>
								<div class="col-sm-2" >
	                                <select name="ex_wgt_other" id="ex_wgt_other" class="form-control" required>
	                                  <option value="">Select</option>
										<option value="R">R</option>
	                                </select>
	                                 
	                            </div>
							</div>
							<div class="form-group">
								<label class="col-sm-1">RM</label>
	                            <div class="col-sm-2" >
	                                <select name="rm" id="rm" class="form-control" required>
	                                  <option value="">Select</option>
										<option value="M">M</option>
	                                </select>
	                                 
	                            </div>
								<label class="col-sm-1">US</label>
									<div class="col-sm-2" >
	                                <select name="us" id="us" class="form-control" required>
	                                  <option value="">Select</option>
										<option value="S">S</option>
	                                </select>
	                                 
	                            </div>
								<label class="col-sm-1">AY</label>
								<div class="col-sm-2" >
	                                <select name="ay" id="ay" class="form-control" required>
	                                  <option value="">Select</option>
										<option value="M">M</option>
	                                </select>
	                                 
	                            </div>
								<label class="col-sm-1">AN</label>
								<div class="col-sm-2" >
	                                <select name="an" id="an" class="form-control" required>
	                                  <option value="">Select</option>
										<option value="M">M</option>
	                                </select>
	                                 
	                            </div>
							</div>
							<div class="form-group">
								<label class="col-sm-1">Remark</label>
	                            <div class="col-sm-5" >
	                                <textarea name="remark" id="remark" class="form-control"></textarea>
	                                 
	                            </div>
								</div>
                                <!--- practical end-->
                                <div class="form-group">
                                    <div class="col-sm-2"></div>
                                    <div class="col-sm-2">   
										<button class="btn btn-primary form-control" id="submitfrm" name="submit" type="submit" >Update</button>
										                                      
                                    </div>                                    
                                    <div class="col-sm-2"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url()?>subject'">Cancel</button></div>
                                    <div class="col-sm-4"></div>
                                </div>
                            </form>
                            <?php //} ?>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
<!----------------------------------------------------->
    </div>
</div>
<script>	
$(document).ready(function() {
		$('#topic_no').on('change', function () {
			var topic_no = $(this).val();
			var subject_id = '<?=$sub[0]['sub_id']?>';
			if (topic_no) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>lessonplan/load_subtopics',
					data: {topic_no:topic_no,subject_id:subject_id},
					success: function (response) {
						//alert(response);
						$("#lsubtopic").html(response);
					
					}
					 
				});
			} else {
				$('#stopic_no').html('<option value="">Select Topic first</option>');
			}
		});
		//$('#stopic_no').multiselect('rebuild');
});
</script>