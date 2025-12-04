<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>

<?php
$role_id = $this->session->userdata('role_id');
echo $select_School.'---';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Faculty Feedback </a></li>
        
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Faculty Feedback Report</h1>
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
				<div class="row">
					<form name="searchTT" method="POST" action="<?=base_url()?>feedback/Factilywise_report">
								<div class="form-group">
							
									<div class="col-sm-2" >
										<select name="fbsession" id="fbsession" class="form-control" required>
											<option value="">Select Session</option>
											<?php
											foreach($fbsession as $fbs){
												$fbvalue = $fbs['academic_type'].'~'.$fbs['academic_year'];
												
												//$actses1 = $actses[0];
												if($fbvalue == $fbses){
													$sel = "selected";
												} else{
													$sel = '';
												}
												echo '<option value="' . $fbvalue . '"' . $sel . '>' . $fbs['academic_type'] . '-'.$fbs['academic_year'].' </option>';
											}
											?>
										</select>
									</div>
                                    
                                    <div class="col-sm-3" >
										<select name="select_School" id="select_School" class="form-control no-padding-hr">
											<option value="">Select School </option>
											<?php
											
											foreach($schools as $sch){
												$schSchool = $sch['school_code'];
												
												//$actses1 = $actses[0];
												if($schSchool == $select_School){
													$sel = "selected";
												} else{
													$sel = '';
												}
												echo '<option value="' . $schSchool . '"' . $sel . '>' . $sch['school_name'].' </option>';
											}
											?>
										</select>
                                        <span class="wait" style=" display:none;"><img src="<?php echo base_url() ?>assets/images/giphy.gif"  width="40" height="30"/></span>
									</div>
                                    
                                    
                                    
									 <div class="col-sm-3" >
										<select name="fbschool" id="fbschool" class="form-control no-padding-hr">
											<option value="">Select</option>
											<?php
											foreach($getfacdetails_all as $sch){
												$schvalue = $sch['emp_id'];
												
												//$actses1 = $actses[0];
												if($schvalue == $school){
													$sel = "selected";
												} else{
													$sel = '';
												}
												if($sch['gender']=='male'){
												$sex = 'Mr.';
											    }else{
												$sex = 'Mrs.';
											    }
						echo '<option value="' . $schvalue . '"' . $sel . ' >'.$sex.' '.$sch['fname'].' '.$sch['lname'].' </option>';
											}
											?>
										</select>
									</div>                             
									<div class="col-sm-2"><input type="submit" class="btn btn-primary" value="Search"></div>
								
								</div>
							</form>
					</div>
				</div>
				<br>
				
						
                        <div class="table-info">  
						    <div class="pull-right" style="margin-right: 15px;margin-bottom: 10px;">
								<?php
									//if(!empty($_REQUEST['division'])){
										$PDF='YES';
										$_REQUEST['division'];
							 $stud_details1 = $academic_type.'~'.$academic_year.'~'.$school.'~'.$select_School;
									?>
									<button onclick="exportTableToCSV('Export_excel.csv')">Export To Excel</button>|<a href="<?=base_url()?>Feedback/Factilywise_report_pdf/<?=base64_encode($stud_details1)?>"style="color:red" title="PDF"><button ><i class="fa fa-file-pdf-o" aria-hidden="true"> PDF</i></button></a>&nbsp;&nbsp; &nbsp;
									
									
									<?php

									//}
									?>
								</div>
								<div class="table-info">  
						    
							<table width="100%" cellpadding="0" cellspacing="0" border="1px" class="table time-table table-striped table-bordered" align="center" >
							
							<thead>
							   <tr>
									<th align="center"><b><span>Sr.No</span></b></th>
                                    <th align="center"><b><span>Faculty</span></b></th>
                                    <th align="center"><b><span>School</span></b></th>
                                    <th align="center"><b><span>Subject</span></b></th>
                                    <th align="center"><b><span>Stream</span></b></th>
									<th align="center"><b><span>Semeter</span></b></th>
									<!--<th align="center"><span>Status</span></th>-->
									<th align="center"><b><span>#Feedback</span></b></th>
									<th align="center"><b><span>Marks</span></b></th>
									<th align="center"><b><span>Outof</span></b></th>
									<th align="center"><b><span>%Per</span></b></th>
                                  <!--  <th align="center"><span>%Avg</span></th>-->
									<!--<th align="center"><span>Download</span></th>-->
									
							   </tr>
								</thead>
								<tbody id="studtbl">
								<?php
								//echo "<pre>";
								//print_r($sub);
								$i=1;
									if(!empty($sub)){
										$fc=0;
										$tempnm='';
										foreach($sub as $sb){
										$stud_details = $streamId.'~'.$semester.'~'.$division.'~'.$sb['subject_code'].'~'.$sb['faculty_code'];
											if($sb['gender']=='male'){
												$sex = 'Mr.';
											}else{
												$sex = 'Mrs.';
											}
										$mrks = $sb['mrks'][0]['Tot_marks'];
										$outoff =$sb['fb'][0]['STUD_CNT']*90;	
										if(($mrks=='')||($mrks==0)){}else{
								?>
									<tr>
										

										<td><?=$i?></td>
										
										<td><?=$sex.' '.$sb['fname'].' '.$sb['mname'].' '.$sb['lname']?></td>
                                         <td><?php echo $sb['school_name']?></td>
                                        <td><?php echo $sb['subcode'].'-'.$sb['subject_name']?></td>
									 <td><?=$sb['stream_name']?></td>
                                    <td ><?=$sb['semester']?></td>
                                    	
										<td><?php if($sb['fb'][0]['STUD_CNT'] !=''){ echo $sb['fb'][0]['STUD_CNT'];}?></td>
										<td><?=$mrks?></td>
										<td><?=$outoff?></td>
										<td><?=round($mrks/$outoff * 100);?>%</td>
                                       <!-- <td >
                                        <?php
											
											/*if($tempnm==$sb['faculty_code']){
												@$avg+=round($mrks/$outoff);
											}else{
												$tempnm=$sb['faculty_code'];												
												@$avg=round($mrks/$outoff);
												}
											echo */
										/*if($sb['faculty_code']==$fc){
											$peer=round($mrks/$outoff * 100);
										}*/
										?>
                                        
                                        </td>-->
										<!--<td>
										<?php 
											/*if($sb['fb'][0]['feedback_id'] !=''){
										?>
										<a href="<?=base_url()?>Feedback/download_report/<?=base64_encode($stud_details)?>/<?=$fbdses?>"style="color:red"><button ><i class="fa fa-file-pdf-o" aria-hidden="true"></i></button></a>
										 <!--| <a href="<?=base_url()?>Feedback/download_excel/<?=base64_encode($stud_details)?>"style="color:green"><button ><i class="fa fa-file-excel-o" aria-hidden="true"></i></button></a--> 
										<?php
											}else{?>
												
										<?php	} */
										?>
										
										</td>-->
											
									</tr>
									
								<?php 
								//}
								
										$i++;
										}
										}
									}else{
										echo "<tr><td colspan=6>No data found.</td></tr>";
									}
								?>
								
								<tr>
								    <td colspan=8></td>
								    <td>
								        <?php
									//if(!empty($_REQUEST['division'])){
									  
									?>
									<!--<a href="<?=base_url()?>Feedback/all_faculty_report_pdf/<?=$semester?>/<?=$streamId?>/<?=$division?>"style="color:red" title="Download All"><button ><i class="fa fa-file-pdf-o" aria-hidden="true"> All</i></button></a>-->
									
									<?php

									//}
									?>
								    </td>
								    
								</tr>
								</tbody>

							</table>
							
						</div>
                    </div>
                </div>
                </div>
            </div>
            </div>    
        </div>
    </div>
</div>
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Commerce</h4>
      </div>
      <div class="modal-body">
        <p>Some text in the modal.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<script>
$(document).ready(function(){
	$("#select_School").on('change',function(){
var fbsession = $("#fbsession").val();
var select_School = $("#select_School").val();
		//alert(course_id);
		$('.wait').css('display','block');
		if (fbsession) {
			$.ajax({
				'url' : base_url + 'Feedback/load_streams_Faculty_list',
				'type' : 'POST', //the way you want to send data to your URL
				'data' : {'School':select_School,'fbsession' : fbsession},
				'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
					var container = $('#stream_id'); //jquery selector (get element by id)
					if(data){
						var stream_id = 'fbschool';
						$("#fbschool").html(data);
								$('.wait').css('display','none');

						//$("#stream_id option[value='" + stream_id + "']").attr("selected", "selected");
					}
				}
			});
		}

		/*var courseid ='<?=$this->uri->segment(6)?>';
			//alert(course_id);
			if (courseid) {
				$.ajax({
						'url' : base_url + '/Batch_allocation/load_streams',
						'type' : 'POST', //the way you want to send data to your URL
						'data' : {'course_id' : courseid},
						'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
							var container = $('#stream_id'); //jquery selector (get element by id)
							if(data){
								var stream_id = '<?=$this->uri->segment(3)?>';
								container.html(data);
								$("#stream_id option[value='" + stream_id + "']").attr("selected", "selected");
							}
						}
					});
			}*/
			
	});
});		




  $("div.holder").jPages
  ({
    containerID : "itemContainer"
  });
  $("#search_me").select2({
      placeholder: "Enter Time table name",
      allowClear: true
    });
        $("#search_me").on('change',function()
        {
            var search_val = $(this).val();            
            var url  = "<?=base_url().strtolower($currentModule).'/search/'?>";	
            var data = {title: search_val};		
            var type="";
            var type_name="";
            $.ajax
            ({
                type: "POST",
                url: url,
                data: data,
                dataType: "html",
                cache: false,
                crossDomain: true,
                success: function(data)
                {                       
                    var array=JSON.parse(data);
                    var str="";
                    for(i=0;i<array.slot.length;i++)
                    {
                        str+='<tr style="display: table-row; opacity: 1;">';
                        str+='<td>'+(i+1)+'</td>';                                                                                                
                        str+='<td>'+array.slot[i].campus_name+'</td>';
                        str+='<td>'+array.slot[i].college_code+'</td>';
                        str+='<td>'+array.slot[i].college_name+'</td>';
                        str+='<td>'+array.slot[i].college_state+'</td>';
                        str+='<td>'+array.slot[i].college_city+'</td>';                        
                        str+='<td>'+array.slot[i].college_pincode+'</td>';
                        str+='<td>'+array.slot[i].college_address+'</td>';
                        str+='<td>';
                        str+='<a href="<?=base_url(strtolower($currentModule))?>/edit/'+array.slot[i].college_id+'"><i class="fa fa-edit"></i></a>';
                        str+='<a href="<?=base_url(strtolower($currentModule))?>/disable/'+array.slot[i].college_id+'"><i title="Disable" class="fa fa-ban"></i></a>';
                        str+='</td>';
                        str+='</tr>';
                        $("#itemContainer").html(str);
                    }
                },
                error: function(data)
                {
                    alert("Page Or Folder Not Created..!!");
                }
            });
        });
$(document).ready(function()
{
	var division='<?=$this->uri->segment(5)?>'; 
	var semester='<?=$this->uri->segment(4)?>';
	var course ='<?=$this->uri->segment(6)?>';
	var stream ='<?=$this->uri->segment(3)?>';
	if(division!="" && semester!="")
	{
		$('#division option').each(function()
		 {              
			 if($(this).val()== division)
			{
			$(this).attr('selected','selected');
			}
		});
		$('#semester option').each(function()
		 {              
			 if($(this).val()== semester)
			{
			$(this).attr('selected','selected');
			}
		});
		$('#course_id option').each(function()
		 {              
			 if($(this).val()== course)
			{
			$(this).attr('selected','selected');
			}
		});
		$("#btn_submit").trigger("click");
	}
	$("#fbschool").select2({
      placeholder: "Select Faculty",
      allowClear: true
    });
	   
});        


</script><script type="text/javascript">

function downloadCSV(csv, filename) {
    var csvFile;
    var downloadLink;

    // CSV file
    csvFile = new Blob([csv], {type: "text/csv"});

    // Download link
    downloadLink = document.createElement("a");

    // File name
    downloadLink.download = filename;

    // Create a link to the file
    downloadLink.href = window.URL.createObjectURL(csvFile);

    // Hide download link
    downloadLink.style.display = "none";

    // Add the link to DOM
    document.body.appendChild(downloadLink);

    // Click download link
    downloadLink.click();
}


function exportTableToCSV(filename) {
    var csv = [];
    var rows = document.querySelectorAll("table tr");
    
        for (var i = 0; i < rows.length; i++) {
        var row = [], cols = rows[i].querySelectorAll("td, th");
        
        for (var j = 0; j < cols.length; j++) 
            row.push(cols[j].innerText);
        
        csv.push(row.join(","));        
    }
	//var filef='';var files='';var filefb='';
//filef=$("#fbsession option:selected").html();
files=$("#select_School option:selected").html();
//filefb=$("#fbschool option:selected").html();
    // Download CSV file
    downloadCSV(csv.join("\r\n"), filename);
}

</script>