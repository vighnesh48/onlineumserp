<style>
.table {

    width: 100%;

max-width: 100%;

}

.table-warning thead{border-color: #de9328 !important;

color: #fff!important;}

.table-warning thead tr {

    background: #e9a23b !important;

}

</style>

<?php

//echo $academic_year;

    $astrik='<sup class="redasterik" style="color:red">*</sup>';

?>

<div id="content-wrapper">

    <ul class="breadcrumb breadcrumb-page">

        <div class="breadcrumb-label text-light-gray">You are here: </div>

        <li><a href="#">Lessonplan</a></li>

        <li class="active"><a href="#">Lessonplan </a></li>

    </ul>

    <div class="page-header">			

        <div class="row">

            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Lessonplan Details</h1>

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
							<span class="pull-right"><a href="<?=base_url()?>lessonplan"><button class="btn btn-info" style="margin-top: -5px;">Back</button></a></span>
							<div><a href="<?=base_url()?>lessonplan/downloadpdf/<?=base64_encode($subdetails.'~'.$academicyear)?>"><button class="btn btn-info">Download pdf</button></a></div>
                    </div>

                    <div class="panel-body">
						<div class="col-sm-12">
                        <div class="table-info12">  
							<table class="table table-bordered">
							<thead style="background: #3da1bf !important;border-top-color: #3da1bf !important;color: #fff;border-color: #e2e2e2;">
								<tr>	
									<!--th>#</th-->
                                    <th>lecture No</th>
                                    <th>Unit No</th>
                                    <th>Topic No</th>
                                    <th>Topic to be Covered</th>
									<th>Planned date</th>
									<!-- <th>Actual Date</th> -->
									<th>Action</th>
								</tr>

								</thead>

								<tbody id="studtbl">

								<?php

								

								$CI =& get_instance();

								$CI->load->model('Subject_model');
								//echo "<pre>";

								//print_r($subj_details);
								$i=1;
								$str_cvrdtp='';	
									if(!empty($lessonplan)){

										foreach ($lessonplan as $lplan) {	
										$covrdtpc = explode('~~~',$lplan['subtopic_no']);
										
												$k=1;
												foreach($covrdtpc as $cvrdtp){
													$str_cvrdtp .= '<b>'.$k.'</b>) '.$cvrdtp.'<br>'; 
													$k++;
													$lplanid=$lplan['lecture_plan_id'];
												}
												?>

													<tr>
														<!--td><?=$i?></td-->
														<td><?=$lplan['lecture_no']?></td>
														<td><?=$lplan['unit_no']?></td>
														<td><?=$lplan['topic_no']?></td>
														<td><?=$str_cvrdtp?></td>
														<td><?=$lplan['planned_date']?></td>
														<!-- <td><?php if($lplan['actual_date']=='0000-00-00'){ echo '-';}else{ echo $lplan['actual_date'];}?></td> -->
														
														<td>
														<a href="<?=base_url()?>lessonplan/delete/<?=base64_encode($subdetails)?>/<?=base64_encode($lplanid)?>"><button type="button" class="btn btn-info">Delete</button>
														</td>

													</tr>
													
										<?php  unset($str_cvrdtp);
												$i++;
										}
									}else{
										echo "<tr><td colspan='8'>No data found.</td></tr>";
									}
										?>
										</tbody>
										</table>	

						</div>

                    </div>

                </div>

			</div>

			<!--/form-->		

		</div>

			

    </div>

</div>

<script>

	function toggle_details(id){

		$("#details_"+id).toggle( "slow", function() {

			});



	}

		function toggle_view(subid, top_no){

			//alert(top_no);

		if (top_no) {

			$.ajax({

				'url' : base_url + '/Subject/get_subtopic_details',

				'type' : 'POST', //the way you want to send data to your URL

				'data' : {'subject_id' : subid,'topic_id':top_no},

				'success' : function(data){ //probably this request will return anything, it'll be put in var "data"

					var container = $('#view_subtopics'); //jquery selector (get element by id)

					if(data){

						container.html(data);						

					}

				}

			});

		}

			



	}

	function add_subjects(id){

		var url = '<?=base_url()?>';

		window.location.href=url+"Syllabus/add_syllabus/"+id;

	}	



$(document).ready(function () {

		var course_id = $("#course_id").val();

		//alert(course_id);

		if (course_id) {

			$.ajax({

				'url' : base_url + '/Batch_allocation/load_streams',

				'type' : 'POST', //the way you want to send data to your URL

				'data' : {'course_id' : course_id},

				'success' : function(data){ //probably this request will return anything, it'll be put in var "data"

					var container = $('#stream_id'); //jquery selector (get element by id)

					if(data){

						var stream_id = '<?=$streamId ?>';

						container.html(data);

						$("#stream_id option[value='" + stream_id + "']").attr("selected", "selected");

					}

				}

			});

		}

		// fetch stream form course

	var stream_id = $("#semester").val();

	if(stream_id !=''){

		$("#sem_id").val(stream_id);

	}

		// fetch subject of sem_acquire

		$("#stream_id").change(function(){

			//alert("hi");

		  $('#semester option').attr('selected', false);

		});

		

		$("#semester").change(function(){

			var streamId = $("#stream_id").val();

			var course_id = $("#course_id").val();

			var semesterId = $("#semester").val();

			

			$.ajax({

				'url' : base_url + 'Batch_allocation/load_subject',

				'type' : 'POST', //the way you want to send data to your URL

				'data' : {'course' : course_id,'streamId':streamId,'semesterId':semesterId},

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

		$('#course_id').on('change', function () {

			

			var course_id = $(this).val();

			if (course_id) {

				$.ajax({

					type: 'POST',

					url: '<?= base_url() ?>batch_allocation/load_streams',

					data: 'course_id=' + course_id,

					success: function (html) {

						//alert(html);

						$('#stream_id').html(html);

					}

				});

			} else {

				$('#stream_id').html('<option value="">Select course first</option>');

			}

		});

});

</script>