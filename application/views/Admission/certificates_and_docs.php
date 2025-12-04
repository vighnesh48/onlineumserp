
<script src="<?= base_url('assets/javascripts') . '/bootstrap-datepicker.js' ?> "></script>
<link href="<?= site_url() ?>assets/css/pick.css" rel="stylesheet" type="text/css" />
<script src="<?= site_url() ?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<script type="text/javascript">
   <!--
   function copyBilling (f) {
       var s, i = 0;
       if(f.same.checked == true) {
   
       while (s = ['A', 'B', 'C', 'D', 'country', 'pc'][i++]) {f.elements['shipping_' + s].value = f.elements['bill_' + s].value};
       }
       if(f.same.checked == false) {
       // alert(false);
       while (s = ['A', 'B', 'C', 'D', 'country', 'pc'][i++]) {f.elements['shipping_' + s].value ="";};
       }
   }
   // -->
</script>
<div id="content-wrapper">
<ul class="breadcrumb breadcrumb-page">
   <div class="breadcrumb-label text-light-gray">You are here: </div>
   <li><a href="#">Masters</a></li>
   <li class="active"><a href="#">Admission Form</a></li>
</ul>
<div class="page-header">
   <div class="row">
      <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Admission Form</h1>
      <div class="col-xs-12 col-sm-8">
         <div class="row">
            <hr class="visible-xs no-grid-gutter-h">
         </div>
      </div>
   </div>
   <div class="row ">
      <div class="col-sm-12">
         <div class="panel">
            <div class="panel-body">
               <div class="xtable-info">
                  <div id="dashboard-recent" class="panel panel-warning">
                     <?php include 'stepbar.php';?>
                     <div class="tab-content">
                        <form method="post" action="<?=base_url()?>Ums_admission/update_docDetails" enctype="multipart/form-data">
                        <!--start  of documents-certificates -->
                          <div id="documents-certificates" class="setup-content widget-threads panel-body tab-pane">
                     
                              <input type="hidden" name="reg_id" value="<?= $this->session->userdata('student_id') ?>">
                              <input type="hidden" name="step1statusval" value="<?= $this->session->userdata('stepfirst_status') ?>">
                              <input type="hidden" name="step2statusval" value="<?= $this->session->userdata('stepsecond_status') ?>">
                              <div class="panel">
                                <div class="panel-heading">List Of Documents To Be Submitted
                                  <?= $astrik ?>
                               </div>
                                <div class="panel-body">
                                  <div class="table-responsive">
                                    <table class="doc-tbl table-bordered">
                                      <tr>
                                          
                                             <th>Select</th>
                                <th>Sr No.</th>
                                
                                <th>Particulars</th>
                              <!-- <th>Mark 'NA'if not applicable</th>-->
                                <th>Original or Xerox</th>
                               <!-- <th>If Pending for submission(Specify Date of Submission)</th>-->
                                <th>Upload Scan Copy</th>
                                 <th>View</th>
                                       <!-- <th>Sr No.</th>
                                        <th>Particulars</th>
                                        <th>Mark 'NA'if not applicable</th>
                                        <th>Mark'O' if Submitted in original and 'X' if xerox submitted</th>
                                        <th>If Pending for submission(Specify Date of Submission)</th>
                                        <th>Upload Scan Copy</th>
                                        <th>Remark</th>-->
                                      </tr>
                                      <?php
                                    //  var_dump($doc_list);
                                      
                                      
        foreach ($document as $key => $val) {
        ?><?php print_r($document);?>
                                     <input type="hidden" name="updoc_id[]" value="<?= $document[$key]['document_id'] ?>">
                                      <?php
        }
        ?>
                                     <?php
        foreach ($doc_list as $doc) {
        ?>
                                     <tr>
                                             <td><input type="checkbox" name="dapplicable[<?= $doc['document_id'] ?>]" value="Y"></td>

                                        <td><?= $doc['document_id'] ?>
                                         <input type="hidden" name="doc_id[<?= $doc['document_id'] ?>]" value="<?= $doc['document_id'] ?>"></td>
                                        <td><label>
                                            <?= $doc['document_name'] ?>
                                         </label></td>
                                  <!-- <td><select name="dapplicable[<?= $doc['document_id'] ?>]">
                                            <option value="">Select</option>
                                            <option value="A" <?php if($doc['doc_applicable']=="A"){echo "selected";}?>>Yes</option>
                                            <option value="NA" <?php if($doc['doc_applicable']=="NA"){echo "selected";}?>>NA</option>
                                          </select></td>-->
                                        <td><select name="ox[<?= $doc['document_id'] ?>]">
                                            <option value="">Select</option>
                                            <option value="O" <?php if($doc['ox']=="O"){echo "selected";}?>>O</option>
                                            <option value="X" <?php if($doc['ox']=="X"){echo "selected";}?>>X</option>
                                          </select></td>
                                       <!-- <td><div class="form-group">
                                            <div class="input-group date" id="doc-sub-datepicker<?= $doc['document_id'] ?>">
                                              <input type="text" id="docsubdate[]" name="docsubdate[<?= $doc['document_id'] ?>]" class="form-control" value="<?= $doc['created_on'] ?>" placeholder="Date" />
                                              <span class="input-group-addon"><i class="fa fa-calendar"></i></span> </div>
                                          </div></td>-->
                                        <td><input type="file" name="scandoc[<?= $doc['document_id'] ?>]"> <?php if($doc['doc_path']!=''){echo $doc['doc_path'];}  ?></td>
    <td>
                                            <?php
                                                $student_id = $this->session->userdata('studId');
                                                $bucketname = 'uploads/student_document/';
                                                $s3_path = 'uploads/student_document/'.$doc['doc_path'];
                                                $year = getStudentYear($student_id);
                                                $bucketname = 'uploads/student_document/'. $year .'/';
                                                $s3_path = 'uploads/student_document/'. $year. '/' .$doc['doc_path'];
                                                $s3_file =   $this->awssdk->isFileExist('erp-asset', $s3_path);

                                                if( trim($doc['doc_path']) !='' && $s3_file) {
                                            ?>
                                                    <a href="<?= site_url() ?>Upload/get_document/<?php echo $doc['doc_path'].'?b_name='.$bucketname;  ?>" target="_blank">View</a>
                                            <?php
                                                }
                                            ?>
                                        </td>
                                     <!--   <td><input type="text" name="remark[<?= $doc['document_id'] ?>]?>" value="<?= $doc['remark'] ?>"/></td>-->
                                      </tr>
                                      <?php
        }
        ?>
                                   </table>
                                  </div>
                                </div>
                              </div>
                             <!-- <div class="panel">
                                <div class="panel-heading">Certificates Details </div>
                                <div class="panel-body">
                                  <table class="table table-bordered">
                                    <tr>
                                      <th>Certificate Name</th>
                                      <th>Certificate No.</th>
                                      <th>Issue Date</th>
                                      <th>Validity</th>
                                    </tr>
                                    <tr>
                                      <td><input type="hidden" name="cert_id[]" value="<?= isset($get_icert_details[0]['cid']) ? $get_icert_details[0]['cid'] : '' ?>">
                                        <label>Income</label>
                                        <input type="hidden" name="cnm[]" value="Income" readonly></td>
                                      <td><input type="text" name="cno[]" value="<?= isset($get_icert_details[0]['certificate_no']) ? $get_icert_details[0]['certificate_no'] : '' ?>"/></td>
                                      <td><div class="form-group">
                                          <div class="input-group date" id="doc-sub-datepicker17">
                                            <input type="text" id="issuedt1" name="issuedt[]" class="form-control" value="<?= isset($get_icert_details[0]['issue_date']) ? $get_icert_details[0]['issue_date'] : '' ?>" placeholder="Document issue Date" />
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span> </div>
                                        </div></td>
                                      <td><div class="form-group"><div class="input-group date"><input type="text" class="form-control"name="cval[]" id="cvaldt1" value="<?= isset($get_icert_details[0]['validity_date']) ? $get_icert_details[0]['validity_date'] : '' ?>"><span class="input-group-addon"><i class="fa fa-calendar"></i></span></div></div></td>
                                    </tr>
                                    <tr>
                                      <td><input type="hidden" name="cert_id[]" class="form-control" value="<?= isset($certificate[1]['cid']) ? $certificate[1]['cid'] : '' ?>">
                                        <label>Cast-category</label>
                                        <input type="hidden"name="cnm[]" value="Cast-category" readonly></td>
                                      <td><input type="text" name="cno[]" value="<?= isset($get_ccert_details[0]['certificate_no']) ? $get_ccert_details[0]['certificate_no'] : '' ?>"/></td>
                                      <td><div class="form-group">
                                          <div class="input-group date" id="doc-sub-datepicker18">
                                            <input type="text" id="issuedt2" name="issuedt[]" class="form-control" value="<?= isset($get_ccert_details[0]['issue_date']) ? $get_ccert_details[0]['issue_date'] : '' ?>" placeholder="Document issue Date" />
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span> </div>
                                        </div></td>
                                      <td><div class="form-group"><div class="input-group date"><input type="text" class="form-control" name="cval[]" id="cvaldt2" value="<?= isset($get_ccert_details[0]['validity_date']) ? $get_ccert_details[0]['validity_date'] : '' ?>"><span class="input-group-addon"><i class="fa fa-calendar"></i></span></div></div></td>
                                    </tr>
                                    <tr>
                                      <td><input type="hidden" name="cert_id[]" value="<?= isset($certificate[2]['cid']) ? $certificate[2]['cid'] : '' ?>">
                                        <label>Residence-State Subject</label>
                                        <input type="hidden" name="cnm[]" value="Residence-State Subject" readonly></td>
                                      <td><input type="text" name="cno[]" value="<?= isset($get_rcert_details[0]['certificate_no']) ? $get_rcert_details[0]['certificate_no'] : '' ?>"/></td>
                                      <td><div class="form-group">
                                          <div class="input-group date" id="doc-sub-datepicker19">
                                            <input type="text" id="issuedt3" name="issuedt[]" class="form-control" value="<?= isset($get_rcert_details[0]['issue_date']) ? $get_rcert_details[0]['issue_date'] : '' ?>" placeholder="Document issue Date" />
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span> </div>
                                        </div></td>
                                      <td><div class="form-group"><div class="input-group date"><input type="text" name="cval[]" id="cvaldt3" class="form-control" value="<?= isset($get_rcert_details[0]['validity_date']) ? $get_rcert_details[0]['validity_date'] : '' ?>"><span class="input-group-addon"><i class="fa fa-calendar"></i></span></div></div></td>
                                    </tr>
                                  </table>
                                </div>
                              </div>-->
                              <div class="form-group">
                                <div class="col-sm-4"></div>
                               <div class="col-sm-2">
                                  <button class="btn btn-primary nextBtn form-control" type="submit" >Update</button>
                                </div>
        
                             </div>
                         
                          </div>
                        <!--end of documents-certificates --> 
                        </form>
                     </div>
                  </div>
                  
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<script type="text/javascript">
  function qualifcation(id){
      standrd = $("#"+id).val();

      res = id.split("_");
      var n= res[1];
      var streamId = '#stream_name_'+n;
      var sub = $(streamId).val();
       if(standrd=='SSC'){
    	  $(streamId).html("<option value='NA'>NA</option>");
    	  $(streamId+" option[value='NA']").attr("selected", "selected");
    	  $("tr.10th").show();
    	//$('.10th').show();
      }else if(standrd=='HSC'){
    	  $(streamId).html("<option value=''>-select-</option><option value='Arts'>Arts</option><option value='Commerce'>Commerce</option><option value='Science'>Science</option>");
    	  $("tr.12th").show();
    	  
      }else if(standrd=='Graduation'){
    	  //alert('Inside');
    	 $.post("<?= base_url() ?>Ums_admission/fetch_qualification_streams/", {getspecial: 1}, function (data) {
    		 //alert(data);
    		$(streamId).html(data);
    		
    	});
      }else if(standrd=='Diploma'){
    	  $(streamId).html("<option value='NA'>NA</option>");
    	  $(streamId+" option[value='NA']").attr("selected", "selected");
    	  $("tr.diploama").show();
      } 
  } 
  
   function strmsubject(id){
      streamId = $("#"+id).val();
      if(streamId=='Arts' || streamId=='Commerce'){
         $("tr.eng").show(); 
         $("tr.sci").hide(); 
         $("td.12eng").attr("rowspan","1");
      }else if(streamId=='Science'){
          $("td.12eng").attr("rowspan","5");
         $("tr.eng").show(); 
         $("tr.sci").show(); 
      }else{
          
      }

  } 
  
$(document).ready(function(){

    $("tr.10th").hide();
    $("tr.12th").hide();
    $("tr.diploama").hide();
    ///////
    $('#btn_sujee').on('click', function () {
		var reg_no = $("#reg_no").val();
		//alert(reg_no);
		if (reg_no) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Ums_admission/fetch_sujee_details',
				data: 'reg_no=' + reg_no,
				success: function (html) {
				//	alert(html);
					$('#suJeexamtable').html(html);
				}
			});
		} else {
			alert("Please enter registration no");
			$("#reg_no").focus();
		}
	});
    //SU-JEE Exam show and hide
    $('#chk_sujee').change(function(){
    if($(this).is(":checked"))
    $('#enrol_div').fadeIn('slow');
    else
    $('#enrol_div').fadeOut('slow');

    });
    // Num check logic
  	$('.numbersOnly').keyup(function () {
    if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
       this.value = this.value.replace(/[^0-9\.]/g, '');
    } 
  	});
  	
    // City by State
	$('#lstate_id').on('change', function () {
		var stateID = $(this).val();
		
		if (stateID) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Ums_admission/getStatewiseDistrict',
				data: 'state_id=' + stateID,
				success: function (html) {
					//alert(html);
					$('#ldistrict_id').html(html);
				}
			});
		} else {
			$('#ldistrict_id').html('<option value="">Select state first</option>');
		}
	});
	
    // City by State
	$('#ldistrict_id').on('change', function () {
		var district_id = $(this).val();
		var state_ID = $("#lstate_id").val();
	//	alert(state_ID);alert(district_id);
		if (district_id) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Ums_admission/getStateDwiseCity',
				data: { state_id: state_ID, district_id : district_id},
				success: function (html) {
					//alert(html);
					if(html !=''){
					$('#lcity').html(html);
					}else{
					  $('#lcity').html('<option value="">No city found</option>');  
					}
				}
			});
		} else {
			$('#lcity').html('<option value="">Select district first</option>');
		}
	});	
  /////////// for perment address
      // City by State
	$('#pstate_id').on('change', function () {
		var stateID = $(this).val();
		
		if (stateID) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Ums_admission/getStatewiseDistrict',
				data: 'state_id=' + stateID,
				success: function (html) {
					//alert(html);
					$('#pdistrict_id').html(html);
				}
			});
		} else {
			$('#pdistrict_id').html('<option value="">Select state first</option>');
		}
	});
	
    // City by State
	$('#pdistrict_id').on('change', function () {
		var district_id = $(this).val();
		var state_ID = $("#pstate_id").val();
	//	alert(state_ID);alert(district_id);
		if (district_id) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Ums_admission/getStateDwiseCity',
				data: { state_id: state_ID, district_id : district_id},
				success: function (html) {
					//alert(html);
					if(html !=''){
					$('#pcity').html(html);
					}else{
					  $('#pcity').html('<option value="">No city found</option>');  
					}
				}
			});
		} else {
			$('#pcity').html('<option value="">Select district first</option>');
		}
	});	

	 /////////// for Parent's/Guardian's Details *
      // City by State
	$('#gstate_id').on('change', function () {
		var stateID = $(this).val();
		
		if (stateID) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Ums_admission/getStatewiseDistrict',
				data: 'state_id=' + stateID,
				success: function (html) {
					//alert(html);
					$('#gdistrict_id').html(html);
				}
			});
		} else {
			$('#gdistrict_id').html('<option value="">Select state first</option>');
		}
	});
	
    // City by State
	$('#gdistrict_id').on('change', function () {
		var district_id = $(this).val();
		var state_ID = $("#gstate_id").val();
	//	alert(state_ID);alert(district_id);
		if (district_id) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Ums_admission/getStateDwiseCity',
				data: { state_id: state_ID, district_id : district_id},
				success: function (html) {
					//alert(html);
					if(html !=''){
					$('#gcity').html(html);
					}else{
					  $('#gcity').html('<option value="">No city found</option>');  
					}
				}
			});
		} else {
			$('#gcity').html('<option value="">Select district first</option>');
		}
	});	
	//////////////////////////////////////////////
    $('#dob-datepicker').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#doc-sub-datepicker1').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#doc-sub-datepicker2').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#doc-sub-datepicker3').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#doc-sub-datepicker4').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#doc-sub-datepicker5').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#doc-sub-datepicker6').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#doc-sub-datepicker7').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#doc-sub-datepicker8').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#doc-sub-datepicker9').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#doc-sub-datepicker10').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#doc-sub-datepicker11').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#doc-sub-datepicker12').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#doc-sub-datepicker13').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#doc-sub-datepicker14').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#doc-sub-datepicker15').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#doc-sub-datepicker16').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#doc-sub-datepicker17').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#doc-sub-datepicker18').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#doc-sub-datepicker19').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#doc-sub-datepicker20').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#doc-sub-datepicker_ssc').datepicker( {format: 'yyyy-mm',autoclose: true});
    $('#doc-sub-datepicker_hsc').datepicker( {format: 'yyyy-mm',autoclose: true});

    $('#cvaldt1').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#cvaldt2').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#cvaldt3').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    
      $('#dsem1pass_date').datepicker( {format: 'yyyy-mm',autoclose: true});
      $('#dsem2pass_date').datepicker( {format: 'yyyy-mm',autoclose: true});
      $('#dsem3pass_date').datepicker( {format: 'yyyy-mm',autoclose: true});
      $('#dsem4pass_date').datepicker( {format: 'yyyy-mm',autoclose: true});
      $('#dsem5pass_date').datepicker( {format: 'yyyy-mm',autoclose: true});
      $('#dsem6pass_date').datepicker( {format: 'yyyy-mm',autoclose: true});
  
       var content = '<tr>'+$('#eduDetTable tbody tr').html()+'</tr>';
    // hide the remove button in education table
    var rowCount = $('#eduDetTable >tbody >tr').length;
    if(rowCount<2){$('#remove').hide();}
    else{$('#remove').show();}
    ///

    $("#eduDetTable").on("click","input[name='remove']", function(e){    
    //$("input[name='remove']").on('click',function(){
        var rowCount = $('#eduDetTable tbody tr').length;

        if(rowCount>1){
            $(this).parent().parent('tr').remove();
        }
    }); 
    
    var contentE = '<tr>'+$('#examDettable tbody tr').html()+'</tr>';
    // hide the removeE button in education table
    var rowCountE = $('#examDettable >tbody >tr').length;
	if(rowCountE<2){$('#removeE').hide();}
	else{$('#removeE').show();}

    $("#examDettable").on("click","input[name='addMore']", function(e){    
    //$("input[name='addMore']").on('click',function(){        
        //var contentE = $(this).parent().parent('tr').clone('true');
        $(this).parent().parent('tr').after(contentE);    
        
    });
    $("#examDettable").on("click","input[name='removeE']", function(e){    
    //$("input[name='removeE']").on('click',function(){
        var rowCountE = $('#examDettable tbody tr').length;

        if(rowCountE>1){
            $(this).parent().parent('tr').remove();
        }
    });  
    
    });  
    
    /////////// add more for edu table
    var max_fields      = 5; //maximum input boxes allowed

    var x = 1; //initlal text box count
    $("#addmore").click(function(e){ //on add input button click
 
       e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            var qid= "studqual_"+x;
            var strm = "stream_name_"+x;
            //alert(qid);
			var fieldshtml = "<tr><td> <div class='form-group'><select name='exam_id[]' id='studqual_"+x+"' class='squal form-control' onchange='qualifcation("+'"'+qid+'"'+")' required><option value=''>Select</option><option value='SSC'>SSC</option><option value='HSC'>HSC</option><option value='Graduation'>Graduation</option><option value='Post Graduation'>Post Graduations</option><option value='Diploma'>Diploma</option></select></div>   </td><td><select name='stream_name[]' id='stream_name_"+x+"' onchange='strmsubject("+'"'+strm+'"'+")' style='width:85px' class='form-control' required><option value=''>Select</option> </select></td><td><div class='form-group'><input type='text' name='seat_no[]' class='form-control' value='' placeholder='Board/University' required /></td></div><td><input type='text' name='institute_name[]' class='form-control' value='' placeholder='Name of Board/University' required /></td><td><select name='pass_year[]' class='form-control' required><option value=''>Year</option><?php  for ($y = date('Y'); $y >= date('Y') - 60; $y--) {  ?> <option value='<?=$y?>'><?=$y?></option><? }?></select><select name='pass_month[]' class='form-control' required><option value=''>Month</option><option value='JAN'>JAN</option><option value='FEB'>FEB</option><option value='MAR'>MAR</option><option value='APR'>APR</option><option value='MAY'>MAY</option><option value='JUN'>JUN</option><option value='JUL'>JUL</option><option value='AUG'>AUG</option><option value='SEP'>SEPT</option><option value='OCT'>OCT</option><option value='NOV'>NOV</option><option value='DEC'>DEC</option></select></td><td><input type='text' name='marks_obtained[]' class='form-control' value='' required/></td><td><input type='text' name='marks_outof[]' class='form-control' value='' placeholder='' required/></td><td><input type='text' name='percentage[]' class='form-control' value='' placeholder='' required/></td><td><input type='file' name='sss_doc[]' id='sss_doc' style='width:80px'></td><td><input type='button' class='remove_field btn btn-xs btn-danger btn-flat' id='remove' value='Remove' name='remove' /></td></tr>";
		
            $("#eduDetTable >tbody").append(fieldshtml); //add input box
        }
    });
    $("#eduDetTable >tbody").on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('tr').remove(); x--;
    });

</script>
<!-- steps logic-->