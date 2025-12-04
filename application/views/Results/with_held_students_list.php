<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<?php
$role_id=$this->session->userdata('role_id');
//print_r($sb);
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Results</a></li>
        <li class="active"><a href="#">With held</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;With held</h1>
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
                            <span class="panel-title" id="stdname">With-held Students List :
							<form method="post" action ="<?=base_url()?>Results/with_held">	
<div class="col-sm-2" style="margin-top: -25px;margin-left:170px;">
                                <select name="exam_ses" id="exam_ses" class="form-control" required>
                                 <option value="">Exam Session</option>
                               
                                  <?php

									foreach ($exam_session as $exsession) {
										$exam_sess = $exsession['exam_id'];
									    if ($exam_sess == $_POST['exam_ses']) {
									        $sel = "selected";
									    } else {
									        $sel = '';
									    }
									    echo '<option value="' . $exam_sess. '"' . $sel . '>' .$exsession['exam_month'] .'-'.$exsession['exam_year'].'</option>';
									}
									?>
									<!--option value="DEC-2018-9" selected>DEC-2018</option-->
									</select>
                              </div>
 <div class="col-sm-2" id="semest" style="margin-top: -25px;">
                                 <input type="submit" id="" class="btn btn-primary btn-labeled" value="Search" > 
                            </div>							  
							</span>
                    </div>
                    <div class="panel-body">
                        <div class="table-info">  
						
						<div class="col-sm-12" style="height: 300px;overflow-y: scroll;">
						<input type="hidden" name="exam_id" id="exam_id" value="<?=$exam_id?>">
							<table class="table table-bordered">
							<thead>
								<tr><th></th>
									<th>Sr.No</th>
									<th>PRN</th>
									<th>Student Name</th>
									<th>Stream</th>
									<th>Status</th>
									
								</tr>
								</thead>
								<tbody id="studtbl">
								<?php
								//print_r($stud_app_id);
								$i=1;
									if(!empty($whresults)){
										foreach($whresults as $wh){
								?>
									<tr id="chk<?=$wh['enrollment_no']?>">
									<td><input type="checkbox" name="chk_stud[]" id="chk_stud" class='studCheckBox' value="<?=$wh['enrollment_no']?>" onclick="changeBackground('<?=$wh['enrollment_no']?>')"></td>
										
										<td><?=$i?></td>
										<td><?=$wh['enrollment_no']?></td>
										<td><?=$wh['stud_name']?></td>
										<td><?=$wh['stream_name']?></td>
										<td><?=$wh['with_held']?></td>
										
										
									</tr>
								<?php 
								//}
										$i++;
										}
									}else{
										echo "<tr><td colspan=7>No data found.</td></tr>";
									}
								?>
								</tbody>
							</table>
							</div>
							<div class="col-sm-4"> <button class="btn btn-primary form-control" id="btn_relesewth" type="button" style="width:150px;">Release</button> </div>
						</div>
                    </div>
                </div>
			</div>
			<!--/form-->		
		</div>
			
    </div>
</div>
<script>

$(document).ready(function () {

	//Relese with-held students
	$('#btn_relesewth').on('click', function () {
		//alert("hi");
		var chk_stud_checked_length = $('input[class=studCheckBox]:checked').length;
		//alert(chk_stud_checked_length);
		if(chk_stud_checked_length == 0){
			 alert('please check atleast one Student from student list');
			 return false;
		}else{
			var chk_stud = $("#chk_stud").val();
			var exam_id = $("#exam_id").val();
			var chk_checked = [];
            $.each($("input[name='chk_stud[]']:checked"), function(){            
                chk_checked.push($(this).val());
            });
			//alert(exam_id);
			if (chk_stud) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>Results/updateWithheld',
					data: {chk_stud:chk_checked,exam_id:exam_id},
					success: function (data) {
						alert('Successfully released result.');
						location.reload();
					}
				});
			} else {
				$('#allocatestudent').html('<option value="">No data found</option>');
			}
		}
		});
	});		
function changeBackground(id){
	var trvalue = 'chk'+id;
	if($(".chk_stud"+id).prop("checked") == true){
		$("#"+trvalue).css({"background-color":"#FF7B77"});
	}
	else if($(".chk_stud"+id).prop("checked") == false){
		$("#"+trvalue).css({"background-color":"#FFF"});
	}
}
</script>	