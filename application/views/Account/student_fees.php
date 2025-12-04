<link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
<style>
	.table{width: 120%;}
	table{max-width: 120%;}
</style>
<?php 
$faculty_arr = array();
foreach ($faculty_list as $value) {
	$faculty_arr[] = $value['emp_id'].", ".$value['fac_name'].", ".$value['department_name'].", ".$value['designation_name'];
}
foreach ($class_faculty_list as $clsval) {
	$class_faculty_arr[] = $clsval['faculty_code'].", ".$clsval['fac_name'];
}
 ?>
<script type="text/javascript">
 $(document).ready(function(){
    //Assign php generated json to JavaScript variable
    var tempArray = <?php echo json_encode($faculty_arr); ?>;
    var dataSrc = tempArray;
    $(".faculty_search").autocomplete({
        source:dataSrc
    });
	//
 	var tempArray1 = <?php echo json_encode($class_faculty_arr); ?>;
    var dataSrc1 = tempArray1;
    $(".faculty_search1").autocomplete({
        source:dataSrc1
    });
    //

    $(".faculty_search2").autocomplete({
        source:dataSrc1
    });
    //

    $(".faculty_search3").autocomplete({
        source:dataSrc1
    });
    //

    $(".faculty_search0").autocomplete({
        source:dataSrc1
    });

});

</script>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Account</a></li>
        <li class="active"><a href="#">Student Report </a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Student Fees Details</h1>
            <div class="col-xs-12 col-sm-8">

            </div>
        </div>
        <div class="row ">
            <div class="col-sm-12">&nbsp;</div>
        </div>
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                <div class="panel-heading">
                    <div class="row ">
						<div class="col-sm-3">
							
						</div>	
						<div class="col-sm-9" style="color:green;float:left;font-weight: 900;">
							<?php $emp_id = $this->session->userdata("name");
							if($emp_id=='suerp')
							{
								$requiredd="";
								
							}
							else
							{
								$requiredd='required="required"';


							}
							
							// /die;
							if ($this->session->flashdata('Tmessage') != ''): 
								echo $this->session->flashdata('Tmessage'); 
							endif;
							?>
						</div>
					</div>
					<div class="row">
				
					</div>
                </div>
                <div class="panel-body">
				
                    <div class="table-info" >    
                    <?php //if(in_array("View", $my_privileges)) { ?>
                    <table class="table table-bordered" style="width:100%!important" id="example">
                        <thead>
                            <tr>
                                    <th width="5%">#</th>
                                   <!--  <th>Academic Year</th> -->
                                    <th width="12%">Student name</th>
                                    <th>Enrollment no</th>
                                    <th width="12%">School name</th>
                                    <th width="5%">Stream</th>
                                    <th>Year</th>
                                    <th width="5%">Academic Year</th>
                                    <th width="5%">Amount</th>
									<th width="5%">chq number</th>
                                    <!--th>Room No</th-->
									<th>Chq Date</th>	
									<th>Receipt No</th>	
									<th>Receipt Date</th>	
									
                                    
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php
                            $j=1;
                            $fac_app =0;
                            //echo "<pre>";print_r($tt_details);
							if(!empty($studentfee_details)){
								$dd=0;
                            for($i=0;$i<count($studentfee_details);$i++)
                            {
                             
                            ?>
                        

<tr>
                             
                                <td><?=$j?></td>  
                                  <td><?=$studentfee_details[$i]['first_name']."&nbsp;".$studentfee_details[$i]['last_name']?></td> 
                                    <td><?=$studentfee_details[$i]['enrollment_no']?></td> 
                                    <td><?=$studentfee_details[$i]['school_short_name']?></td>  
                                <td><?=$studentfee_details[$i]['stream_name']?></td>
                               
                                <td><?=$studentfee_details[$i]['current_year']?></td>
                                <td><?=$studentfee_details[$i]['academic_year']?></td>
                                <td><?=$studentfee_details[$i]['amount']?></td>
                                <td><?=$studentfee_details[$i]['receipt_no']?></td>
                                <td><?=$studentfee_details[$i]['fees_date']?></td>
                                <td><?=$studentfee_details[$i]['college_receiptno']?></td>
                                <td><?=$studentfee_details[$i]['created_on']?></td>
                                
                            </tr>
                               

								
                            
                            <?php
                     
                            $j++;
                            }
							}else{
								echo "<tr>";echo "<td colspan=13>";echo "No data found.";echo "</td>";echo "</tr>";
							}
                            ?>                            
                        </tbody>
                    </table>

                </div>
                </div>
            </div>
            </div>    
        </div>
    </div>
</div>
<script>    
    $(document).ready(function()
    {



    	$('#school_code').on('change', function () {	
		var school_code = $(this).val();
		if(school_code=='0')
		{
			$('#course_id').html('<option value="">Select course first</option>');
			$('#stream_id').html('<option value="">Select course first</option>');
			$('#semester').html('<option value="">Select Stream first</option>');
			$('#division').html('<option value="">Select semester first</option>');
		}
		var academic_year = $("#academic_year").val();
		if (school_code) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>academic_reports/load_courses_for_studentlist',
				data: {academic_year:academic_year,school_code:school_code},
				success: function (html) {
					//alert(html);
					$('#course_id').html(html);
				}
			});
		} else {
			$('#course_id').html('<option value="">Select course first</option>');
		}
	});  


    	var school_code = '<?=$school_code?>';
		var academic_year = '<?=$academicyear?>';
		
		if (school_code) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>academic_reports/load_courses_for_studentlist',
				data: {academic_year:academic_year,school_code:school_code},
				success: function (html) {
				
					//alert(html);
					var course_id = '<?=$courseId?>';
					$('#course_id').html(html);
					$("#course_id option[value='" + course_id + "']").attr("selected", "selected");
				}
			}); 
		} else {
			
			$('#course_id').html('<option value="">Select course first</option>');
		}
		// Num check logic
		$('.numbersOnly').keyup(function () {
			if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
			   this.value = this.value.replace(/[^0-9\.]/g, '');
			} 
		});
		//
		var course_id ='<?=$courseId?>';
		//alert(course_id);
		if (course_id) {
			var academic_year = $("#academic_year").val();
			$.ajax({
				'url' : base_url + '/Batch_allocation/load_streams_faculty_allocation',
				'type' : 'POST', //the way you want to send data to your URL
				'data' : {'course_id' : course_id,academic_year:academic_year,school_code:school_code},
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

		$('#course_id').on('change', function () {
			
			var course_id = $(this).val();
			var academic_year = $("#academic_year").val();
			var school_code = $("#school_code").val();
			if (course_id) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>batch_allocation/load_streams_faculty_allocation',
				data: {course_id:course_id,academic_year:academic_year,school_code:school_code},
					success: function (html) {
						//alert(html);
						$('#stream_id').html(html);
					}
				});
			} else {
				$('#stream_id').html('<option value="">Select course first</option>');
			}
		});
		//update class teacher
		$('#saveClassInfo').on('click', function () {
			//alert('alert');
			var class_teacher = $("#class_teacher").val();
			var tutor_1 = $("#tutor_1").val();
			var tutor_2 = $("#tutor_2").val();
			var tutor_3 = $("#tutor_3").val();
			var stream_id='<?=$streamId?>';
			var semester='<?=$semesterNo?>';
			var academic_year='<?=$academicyear?>';
			var division='<?=$division?>';
			if (class_teacher!='' && tutor_3!='' && tutor_2 !='' && tutor_1 !='') {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>timetable/update_class_details',
					data: {class_teacher:class_teacher,tutor_1:tutor_1,tutor_2:tutor_2,tutor_3:tutor_3,stream_id:stream_id,semester:semester,academic_year:academic_year,division:division},
					success: function (html) {
						if(html=='SUCCESS'){
							alert("Successfully Updated");
						}else{
							alert("Problem while adding");
						}
					}
				});
			}else{
				alert('Please Enter all The input fields.');
			}
		});
		
    });

</script>
<script>
		$('#stream_id').on('change', function () {
			var stream_id = $(this).val();
			var academic_year =$("#academic_year").val();
			if (stream_id) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>timetable/load_ttsemesters',
					data: {stream_id:stream_id,academic_year:academic_year},
					success: function (html) {
						//alert(html);
						$('#semester').html(html);
					}
				});
			} else {
				$('#semester').html('<option value="">Select Stream first</option>');
			}
		});
		//

			var stream_id ='<?=$streamId?>';
			var academic_year ='<?=$academicyear?>';
			if (stream_id) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>timetable/load_ttsemesters',
					data: {stream_id:stream_id,academic_year:academic_year},
					success: function (html) {
						var semester = '<?=$semesterNo?>';
						$('#semester').html(html);
						$("#semester option[value='" + semester + "']").attr("selected", "selected");
					}
				});
			} else {
				$('#semester').html('<option value="">Select Stream first</option>');
			}


		$('#semester').on('change', function () {
			var semester = $(this).val();
			var stream_id =$("#stream_id").val();
			var academic_year =$("#academic_year").val();
			if (semester) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>timetable/load_ttdivision',
					data: {stream_id:stream_id,academic_year:academic_year,stream_id:stream_id, semester:semester},
					success: function (html) {
						
						$('#division').html(html);
						
					}
				});
			} else {
				$('#division').html('<option value="">Select Stream first</option>');
			}
		});

			var semester = '<?=$semesterNo?>';
			if (semester) {
				var academic_year ='<?=$academicyear?>';
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>timetable/load_ttdivision',
					data: {stream_id:stream_id,academic_year:academic_year,stream_id:stream_id, semester:semester},
					success: function (html) {
						var division ='<?=$division?>';
						$('#division').html(html);
						$("#division option[value='" + division + "']").attr("selected", "selected");
					}
				});
			} else {
				$('#division').html('<option value="">Select Stream first</option>');
			}

		// search faculty 
	$('#search_faculty').keyup( function() {
    //alert('gg');
       var that = this;
        // affect all table rows on in systems table
        var tableBody = $('.table-bordered tbody');
        var tableRowsClass = $('.table-bordered tbody tr');
		
		var k = [];
        $('.search-sf').remove();
        tableRowsClass.each( function(i, val) {        
            //Lower text for case insensitive
            var rowText = $(val).text().toLowerCase();
            var inputText = $(that).val().toLowerCase();
            if( rowText.indexOf( inputText ) == -1 )
            {
                //hide rows
				if(tableRowsClass.eq(i).find(":checkbox").attr('data-messid') == '0'){
				 tableRowsClass.eq(i).find(":checkbox").attr('name','assledun[]');
				}
				//alert(id);
                tableRowsClass.eq(i).hide();                
            }
            else
            {
                $('.search-sf').remove();
				if(tableRowsClass.eq(i).find(":checkbox").attr('data-messid') == '0'){
				tableRowsClass.eq(i).find(":checkbox").attr('name','assled[]');
				}
                tableRowsClass.eq(i).show();
                k.push(1);
            }
        });
        $('#fcnt').text(k.length);
        //all tr elements are hidden
        if(tableRowsClass.children(':visible').length == 0)
        {
            tableBody.append('<tr class="search-sf"><td class="text-muted" colspan="8">No records  found.</td></tr>');
        }
    });
</script>
<script>
	$('#example').DataTable( {
        dom: 'Bfrtip',
		"pageLength": 50,

        buttons: [
            {
                extend: 'excel',
                messageTop: 'Lecture Faculty Allocation',
                exportOptions: {
                     columns: [ 0, 1, 2,3,4,5,6,7,8]
                }
            }
        ]
    } );
	</script>