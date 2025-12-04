<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<?php
$role_id=$this->session->userdata('role_id');
//print_r($sb);
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<style>
.loader {
  border: 6px;
  border-radius: 50%;
  border-top: 6px solid pink;
  border-bottom: 6px solid pink;
  width: 90px;
  height: 90px;
  -webkit-animation: spin 2s linear infinite;
  animation: spin 2s linear infinite;
}
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Results</a></li>
        <li class="active"><a href="#">Arrears and Attendance grade updation</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Arrears and Attendance grade updation</h1>
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
                            <span class="panel-title" id="stdname">Arrears updation :
							<form method="post" action ="<?=base_url()?>Results/update_arrears_and_attendancegrade">	
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
									<!--option value="29" selected>DEC-2022</option-->
									</select>
                              </div>
							  <div class="col-sm-4" style="margin-top: -25px;">
                                <input type="radio" name='arrears' value='arrears'> Arrears &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="radio" name='arrears' value='attendancegrade'>Attendance grade &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="submit" id="" class="btn btn-primary btn-labeled" value="Update" > 
                              </div>
						  
							</span>
                    </div>
                    <div class="panel-body">
					<?php if(!empty($this->session->flashdata('message'))){ echo $this->session->flashdata('message');}else{ ?>
					<div class="<?=$loader?>"></div>
					<?php }?>
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