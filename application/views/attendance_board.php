<!DOCTYPE html>
<!--

TABLE OF CONTENTS.

Use search to find needed section.

=====================================================

|  1. $BODY                 |  Body                 |
|  2. $MAIN_NAVIGATION      |  Main navigation      |
|  3. $NAVBAR_ICON_BUTTONS  |  Navbar Icon Buttons  |
|  4. $MAIN_MENU            |  Main menu            |
|  5. $CONTENT              |  Content              |

=====================================================

-->

<!--[if IE 8]>         <html class="ie8"> <![endif]-->
<!--[if IE 9]>         <html class="ie9 gt-ie8"> <![endif]-->
<!--[if gt IE 9]><!-->
<html class="gt-ie8 gt-ie9 not-ie">
<!--<![endif]-->
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title>Blank - Pages - PixelAdmin</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">

<!-- Open Sans font from Google CDN -->
<link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,600,700,300&subset=latin" rel="stylesheet" type="text/css">

<!-- Pixel Admin's stylesheets -->
<!--link href="<?=base_url()?>assets/stylesheets/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="<?=base_url()?>assets/stylesheets/pixel-admin.min.css" rel="stylesheet" type="text/css">
<link href="<?=base_url()?>assets/stylesheets/widgets.min.css" rel="stylesheet" type="text/css">
<link href="<?=base_url()?>assets/stylesheets/pages.min.css" rel="stylesheet" type="text/css">
<link href="<?=base_url()?>assets/stylesheets/rtl.min.css" rel="stylesheet" type="text/css">
<link href="<?=base_url()?>assets/stylesheets/themes.min.css" rel="stylesheet" type="text/css"-->

<!--[if lt IE 9]>
		<script src="assets/javascripts/ie.min.js"></script>
	<![endif]-->
<style>
.table-header .table-caption{font-weight:normal;font-size: 14px;}
.roll-no{font-weight: bold;padding-top:7px;text-shadow:0px 1px #0009;color:#fffefe}
.student-rn .fa-user{font-size:33px;}
.fa-stack{margin:12px 1PX 0px 1px;display: inline-table;float:left;cursor:pointer;}
.student-rn{padding:0px 0px 10px 0px !important;}
.icon-bg-green{color:#46ac46e6;}
.icon-bg-red{color:#e14430b3;}
.icon-bg-gray{color:#b3b3b3;}
.sub-code{background-color:#fafafa!important;margin-bottom:0px;}
.sub-code tr td{xcolor:#fff;padding: 2px 5px !important;cursor:pointer;}
.table-light p{margin:0 0 3px;}
.l-take{padding: 10px 10px 0;cursor:pointer;}
.table-light .label.label-info{background: #1693b8;}
.table{width:100%}
table{max-width: 100%;}
.popover {
	border: 3px solid rgba(0, 0, 0, 0.38)!important;
}
.popover.right {
	margin-left:0px;
	z-index: 99999;
}
.popover-content {
	padding: 0;
}
.list-group-item {
padding:5px 2px;	font-size: 12px;
	line-height: 12px;
}
.list-group{margin-bottom:0}
.popover.right .arrow:after {
    border-right-color: rgba(0,0,0,.5)!important;}
    .cross-icon{margin-top: -5px;
    margin-right: -2px;font-size: 11px;
    color: #bdbdbd;}
</style>
</head>

<!-- 1. $BODY ======================================================================================
	
	Body

	Classes:
	* 'theme-{THEME NAME}'
	* 'right-to-left'      - Sets text direction to right-to-left
	* 'main-menu-right'    - Places the main menu on the right side
	* 'no-main-menu'       - Hides the main menu
	* 'main-navbar-fixed'  - Fixes the main navigation
	* 'main-menu-fixed'    - Fixes the main menu
	* 'main-menu-animated' - Animate main menu
-->
<body class="theme-default main-menu-animated">
<script>var init = [];</script> 
<!-- Demo script --> <script src="assets/demo/demo.js"></script> <!-- / Demo script -->

<div id="main-wrapper"> 
   
  <!-- 2. $MAIN_NAVIGATION ===========================================================================

	Main navigation
-->
    <!-- Main menu toggle -->
    <button type="button" id="main-menu-toggle"><i class="navbar-icon fa fa-bars icon"></i><span class="hide-menu-text">HIDE MENU</span></button>

    <!-- / .navbar-inner --> 
  </div>
  
  <!-- / #main-navbar --> 
  <!-- /2. $END_MAIN_NAVIGATION --> 
  
  <!-- 4. $MAIN_MENU =================================================================================

		Main menu
		
		Notes:
		* to make the menu item active, add a class 'active' to the <li>
		  example: <li class="active">...</li>
		* multilevel submenu example:
			<li class="mm-dropdown">
			  <a href="#"><span class="mm-text">Submenu item text 1</span></a>
			  <ul>
				<li>...</li>
				<li class="mm-dropdown">
				  <a href="#"><span class="mm-text">Submenu item text 2</span></a>
				  <ul>
					<li>...</li>
					...
				  </ul>
				</li>
				...
			  </ul>
			</li>
-->
 

  <div id="content-wrapper"> 
      <div class="page-header">			
        <div class="row" style="margin-top: -30px;">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;<b>Attendance Board</b></h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                </div>
            </div>
        </div>
		<div class="clearfix">&nbsp;
           
        </div>
    <!-- 5. $CONTENT ===================================================================================

		Content--> 
    
    <!-- Content here -->
   
    <div class="row">
      <div class="panel widget-notifications">
        <div class="panel-heading">
          <div class="row">
			<form name="searchTT" class="form-horizontal" method="POST" action="<?=base_url()?>Attendance/dashboard">
              <div class="form-group">
			  
                <div class="col-sm-2">
                  <select name="academic_year" id="academic_year" class="form-control" required>
					  <option value="">Select Academic Year</option>
					  <?php
						foreach ($academic_year as $yr) {
							if ($yr['academic_year'].'~'.$yr['academic_session'] == $academicyear) {
								$sel = "selected";
							} else {
								$sel = '';
							}
							echo '<option value="' . $yr['academic_year'].'~'.$yr['academic_session'].'"' . $sel . '>' . $yr['academic_year'].'('.$yr['academic_session'] . ')</option>';
						}
						?>
				   </select>
                </div>
                <div class="col-sm-2">
                  <select name="course_id" id="course_id" class="form-control" required>
					  <option value="">Select Course</option>
				   </select>
                </div>
                <div class="col-sm-2">
                  <select name="stream_id" class="form-control" id="stream_id" required>
					  <option value="">Select Stream </option>	  
				   </select>
                </div>
                <div class="col-sm-2">
                  <select id="semester" name="semester" class="form-control">
						<option value="">Semester</option>
				  </select>
                </div>
				<div class="col-sm-1">
					<select id="division" name="division" class="form-control">
							<option value="">Division</option>
					</select>
				</div>
				<div class="col-sm-2"><input type="text" class="form-control" name="att_date" placeholder="Date" id="dt-datepicker1" value="<?php if($_REQUEST['att_date']){ echo $_REQUEST['att_date'];}else{ echo date('Y-m-d');}?>" required></div>
                <div class="col-sm-1">   
				  <input type="submit" class="btn btn-danger" value="Search">
                </div>
              </div>
            </form>
          </div>
        </div>
        <?php
            $timestamp = strtotime($todaysdate);
            $attDate = date('l, j F Y', $timestamp);
			
        ?>
        <!-- / .panel-heading -->
        <div class="panel-body padding-sm">
          <div class="row">
            <div class="col-lg-12"></div>
            <div class="col-lg-12">
			<?php if(!empty($details)){?>
              <div class="table-light table-responsive">
                <div class="table-header">
                  <div class="table-caption"> <strong>Class:</strong> <?=$details[0]['stream_name']?> &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<strong>Division:</strong> <?=$division?>
              &nbsp;&nbsp;&nbsp;<span style="float:right;"><strong>Day:</strong> <?=$attDate?> </span> </div>
                </div>
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th width="110">Lecture Slot</th>
                      <th>Students Attendance details</th>
                      <th width="150">Summary</th>
                    </tr>
                  </thead>
                  <tbody>
				  <?php 
				  $CI =& get_instance();
				  $CI->load->model('Attendance_model');
				 
				   $systime = date('Y-m-d H:i');
				   $sys_time =explode(' ',$systime);
				   $time1 = date(strtotime($sys_time[1]));
				   
					if(!empty($details)){
						foreach($details as $att){
							if($att['subject_type']=='TH'){
								$stype="Theroy";
							}else{
								$stype="Practical";
							}
							$time2 = $attDate.' '.$att['from_time'];
							//$time2=date(strtotime($time2));
							$time1 = strtotime($systime);
						    $time2 = strtotime($time2);
							//echo 't1:'.$time1;echo "<br>"; echo 't2:'.$time2;exit;
							if ($time1 < $time2) {
								$mesg ="<span style='color:#ef9006;'>Lecture yet to be taken</span>";
							}else{
								$mesg ="";
							}			
				  ?>
                    <tr>
                      <td><?=$att['from_time']?> to <?=$att['to_time']?><br>
                      <strong><?=$stype?> </strong><br>
                      <?php if($att['subject_type']=='PR'){ ?>
                      <strong>Batch - <?=$att['batch_no']?></strong><br>
                      <?php }?>
                      </td>
                      <td class="student-rn">
					  <?php
					  $tot_present=0;
					  $tot_absent=0;
					  $attpr =$this->Attendance_model->fetch_todaysattendance($att['subject_code'],$att['lecture_slot'],$academicyear,$todaysdate,$streamId,$semesterNo,$division,$att['batch_no'],$att['faculty_code']);
					  $l_assigned = $att['faculty_code'];
					  $l_taken = $attpr[0]['faculty_code'];
					  //if($l_assigned != $l_taken){
							$fac =$this->Attendance_model->fetch_faculty_punching($l_assigned, $todaysdate);
							if(!empty($fac)){
								$reason = "In Campus";
							}else{
								$reason = "On Leave";
							}
					  //}
					  ?>
                      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered sub-code">
						  <tr>
							<td width="65%"><strong><?=$att['sub_code']?></strong> - <?=$att['subject_name']?></td>
							<td align="right"><strong>Assigned: </strong><span data-trigger="hover" data-toggle="popover" data-container="body"  data-html="true" href="#" id="<?=$att['faculty_code']?>"><?php if(($l_assigned != $l_taken) && !empty($l_taken)){ ?><strike style="color:red;cursor:pointer;" title=""><?php }?><?php if(!empty($att['faculty_code'])){ echo strtoupper($att['fname'].'. '.$att['mname'][0].'. '.$att['lname']);}else{ echo "-";}?></strike></span>
							 
							
							</td>
							<div id="popover-content-<?=$att['faculty_code']?>" class="hide popover-list">
							  <ul class="list-group">
								<li class="list-group-item">
								  <div class="row">
									<!--div class="col-sm-3"><img src="<?=base_url()?>uploads/employee_profilephotos/<?=$att['photo_path']?>" width="40" height="40" class="img-circle"></div-->
									<div class="col-sm-9"><strong><?php if(!empty($att['faculty_code'])){ echo strtoupper($att['fname'].'. '.$att['mname'][0].'. '.$att['lname']); }else{ echo "-";} ?></strong> <br>
									  <small>
									  Faculty ID: <?=$att['faculty_code']?><br>
									  Mobile: <?=$att['mobile_no']?><br>
									  Reason: <?=$reason?></small>
									  
									  </div>
								  </div>
								</li>
							  </ul>
							</div> 
						  </tr>
					  </table>
					  <?php
					  //echo '<pre>';
					  //print_r($attpr);
					  $tot_students =count($attpr);
					  if(!empty($attpr)){
					  foreach($attpr as $apa){
						  if($apa['is_present']=='Y'){
								$clss="icon-bg-green";
								$tot_present += 1;
						  }elseif($apa['is_present']=='N'){
							  $clss="icon-bg-red";
							  $tot_absent += 1;
						  }else{
							  $clss="icon-bg-gray";
						  }
						  
					  //}  
					  ?>
                      <span class="fa-stack fa-1x" data-trigger="hover" data-toggle="popover" data-container="body" data-placement="right" type="button" data-html="true" href="#" id="<?=$att['subject_code'].'_'.$apa['enrollment_no']?>"><i class="fa fa-user fa-stack-2x <?=$clss?>"></i><span  class="fa fa-stack-1x roll-no">
					  <?=$apa['roll_no']?></span></span>
					  <div id="popover-content-<?=$att['subject_code'].'_'.$apa['enrollment_no']?>" class="hide popover-list">
                      <ul class="list-group">
                        <li class="list-group-item">
                          <div class="row">
<?php
    $bucket_key = 'uploads/student_photo/'.$apa['enrollment_no'].'.jpg';
    $imageData = $this->awssdk->getImageData($bucket_key);
?>
                            <div class="col-sm-3"><img src="<?= $imageData ?>" width="40" height="40" class="img-circle"></div>
                            <div class="col-sm-9"><strong><?php if(!empty($apa['enrollment_no'])){ echo strtoupper($apa['first_name'].'. '.$apa['middle_name'].'. '.$att['last_name']); }else{ echo "-";} ?></strong> <br>
                              <small>PRN:<?=$apa['enrollment_no']?><br>
                              Mob:<?=$apa['mobile']?></small>
                              
                              </div>
                          </div>
                        </li>
                      </ul>
                    </div>  
					
						<?php }
						}elseif($mesg !=''){
							echo $mesg;
						}else{
							echo "<span style='color:#e66454;'>Attendance Not Marked.</span>";
						}
						$attpersentage = round(($tot_present/$tot_students)*100);
						?>
                      <?php if(!empty($attpr[0]['faculty_code'])){ ?>
					  <span class="pull-right l-take">  
					  <strong>Taken:</strong> <span data-trigger="hover" data-toggle="popover" data-container="body"  data-html="true" href="#" id="lt<?=$attpr[0]['faculty_code']?>"><?php if(!empty($attpr[0]['faculty_code'])){ echo strtoupper($attpr[0]['fname'].'. '.$attpr[0]['mname'][0].'. '.$attpr[0]['lname']); }else{ echo "-";} ?></span></span>
					  
					  <div id="popover-content-lt<?=$attpr[0]['faculty_code']?>" class="hide popover-list">
							  <ul class="list-group">
								<li class="list-group-item">
								  <div class="row">
									<div class="col-sm-3"><img src="<?=base_url()?>uploads/employee_profilephotos/<?=$attpr[0]['photo_path']?>" width="40" height="40" class="img-circle"></div>
									<div class="col-sm-9"><strong><?php if(!empty($attpr[0]['faculty_code'])){ echo strtoupper($attpr[0]['fname'].'. '.$attpr[0]['mname'][0].'. '.$attpr[0]['lname']); }else{ echo "-";} ?></strong> <br>
									  <small>
									  Faculty ID: <?=$attpr[0]['faculty_code']?><br>
									  Mobile: <?=$attpr[0]['mobile_no']?><br>
									  </small>
									  
									  </div>
								  </div>
								</li>
							  </ul>
							</div> 
                      <div class="clearfix"></div>
                      <?php }?>

                      </td>
                      <td><p><span class="label label-success"><?=$tot_present?></span> Present</p>
                      <p><span class="label label-danger"><?=$tot_absent?></span> Absent</p>
                     <p ><span class="label label-warning"><?=$tot_students?></span> Total</p>
                     <p ><span class="label label-info"><?=$attpersentage;?></span> Percentage</p>
                      </td>
                    </tr>
                    
					<?php }
					}
					?>

				  </tbody>
                </table>
                <div class="table-footer"> Footer </div>
              </div>
			  <?php }else{ echo "No Data Found.";}?>
            </div>
            <div class="col-lg-4"></div>
          </div>
        </div>
        <!-- / .panel-body --> 
      </div>
    </div>
  </div>
  <!-- / #content-wrapper -->
  <div id="main-menu-bg"></div>
   </div>
</div>
<!-- / #main-wrapper --> 

<!-- Get jQuery from Google CDN --> 
<!--[if !IE]> -->
	<script type="text/javascript"> window.jQuery || document.write('<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js">'+"<"+"/script>"); </script>
<!-- <![endif]--> 
<!--[if lte IE 9]>
	<script type="text/javascript"> window.jQuery || document.write('<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js">'+"<"+"/script>"); </script>
<![endif]--> 



<!-- Pixel Admin's javascripts --> 

<!-- Pixel Admin's javascripts --> 

<script type="text/javascript">
	//init.push(function () {
		// Javascript code here
	//});
	//window.PixelAdmin.start(init);

</script>
<!--div id="popover-content-login" class="hide popover-list">
  <ul class="list-group">
    <li class="list-group-item">
      <div class="row">
        <div class="col-sm-3"><img src="assets/demo/avatars/2.jpg" width="40" height="40" class="img-circle"></div>
        <div class="col-sm-9"><strong>Ankur Saxena</strong> <br>
          <small>B.Tech.Mechanical FY<br>
          SIEM</small></div>
      </div>
    </li>
    <li class="list-group-item">
      <div class="row">
        <div class="col-sm-3"><img src="assets/demo/avatars/3.jpg" width="40" height="40" class="img-circle"></div>
        <div class="col-sm-9"><strong>Ankur Saxena</strong> <br>
          <small>B.Tech.Mechanical FY<br>
          SIEM</small></div>
      </div>
    </li>
    <li class="list-group-item">
      <div class="row">
        <div class="col-sm-3"><img src="assets/demo/avatars/4.jpg" width="40" height="40" class="img-circle"></div>
        <div class="col-sm-9"><strong>Ankur Saxena</strong> <br>
          <small>B.Tech.Mechanical FY<br>
          SITRC</small></div>
      </div>
    </li>
    <li class="list-group-item">
      <div class="row">
        <div class="col-sm-3"><img src="assets/demo/avatars/5.jpg" width="40" height="40" class="img-circle"></div>
        <div class="col-sm-9"><strong>Ankur Saxena</strong> <br>
          <small>B.Tech.Mechanical FY<br>
          SP</small></div>
      </div>
    </li>
    <li class="list-group-item">
      <div class="row">
        <div class="col-sm-3"><img src="assets/demo/avatars/6.jpg" width="40" height="40" class="img-circle"></div>
        <div class="col-sm-9"><strong>Ankur Saxena</strong> <br>
          <small>B.Tech.Mechanical FY<br>
          SIEM</small></div>
      </div>
    </li>
    <li class="list-group-item">
      <div class="row">
        <div class="col-sm-3"><img src="assets/demo/avatars/3.jpg" width="40" height="40" class="img-circle"></div>
        <div class="col-sm-9"><strong>Ankur Saxena</strong> <br>
          <small>B.Tech.Mechanical FY<br>
          SIP</small></div>
      </div>
    </li>
    <li class="list-group-item">
      <div class="row">
        <div class="col-sm-3"><img src="assets/demo/avatars/4.jpg" width="40" height="40" class="img-circle"></div>
        <div class="col-sm-9"><strong>Ankur Saxena</strong> <br>
          <small>B.Tech.Mechanical FY<br>
          SITRC</small></div>
      </div>
    </li>
    <li class="list-group-item">
      <div class="row">
        <div class="col-sm-3"><img src="assets/demo/avatars/5.jpg" width="40" height="40" class="img-circle"></div>
        <div class="col-sm-9"><strong>Ankur Saxena</strong> <br>
          <small>B.Tech.Mechanical FY<br>
          SIEM</small></div>
      </div>
    </li>
    <li class="list-group-item">
      <div class="row">
        <div class="col-sm-3"><img src="assets/demo/avatars/6.jpg" width="40" height="40" class="img-circle"></div>
        <div class="col-sm-9"><strong>Ankur Saxena</strong> <br>
          <small>B.Tech.Mechanical FY<br>
          SIM</small></div>
      </div>
    </li>
  </ul>
</div-->
</div>
</body>
</html>
<script>
$(document).ready(function()
{
	$('#dt-datepicker1').datepicker( {format: 'yyyy-mm-dd',endDate: '+0d',autoclose: true});
	$('#academic_year').on('change', function () {
			var academic_year = $(this).val();
			if (academic_year) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>timetable/load_ttcources',
					data: {academic_year:academic_year},
					success: function (html) {
						//alert(html);
						$('#course_id').html(html);
					}
				});
			} else {
				$('#course_id').html('<option value="">Select academic year first</option>');
			}
		});
		$('#course_id').on('change', function () {
			var academic_year =$("#academic_year").val();
			var course_id = $(this).val();
			if (course_id) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>Timetable/load_tt_streams',
					data: {course_id:course_id,academic_year:academic_year},
					success: function (html) {
						//alert(html);
						$('#stream_id').html(html);
					}
				});
			} else {
				$('#stream_id').html('<option value="">Select course first</option>');
			}
		});
		$('#stream_id').on('change', function () {
			var stream_id = $(this).val();
			var academic_year =$("#academic_year").val();
			if (stream_id) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>timetable/load_ttsemesters',
					data: {stream_id:stream_id,academic_year:academic_year},
					success: function (html){
						//alert(html);
						$('#semester').html(html);
					}
				});
			} else {
				$('#semester').html('<option value="">Select Stream first</option>');
			}
		});
		//
	var course_id = '<?=$courseId?>';
	var academic_year ='<?=$academicyear?>';
	if (academic_year) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>timetable/load_ttcources',
					data: {academic_year:academic_year},
					success: function (html) {
						//alert(html);
						$('#course_id').html(html);
						$("#course_id option[value='" + course_id + "']").attr("selected", "selected");
					}
				});
			}
			
			if (course_id) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>Timetable/load_tt_streams',
					data: {course_id:course_id,academic_year:academic_year},
					'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
					var container = $('#stream_id'); //jquery selector (get element by id)
					if(data){
						var stream_id = '<?=$streamId?>';
						container.html(data);
						$("#stream_id option[value='" + stream_id + "']").attr("selected", "selected");
					}
				}
			});
		}
			var stream_id ='<?=$streamId?>';
			
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
			
});		

</script>
