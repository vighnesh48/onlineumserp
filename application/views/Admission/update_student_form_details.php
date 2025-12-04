<style>
/*ERP PROFILE PAGE STYLE*/
/*New Style*/
.nav>li:last-child {
    margin-top:10px!important;
}
.panel{
    box-shadow: 1px 2px 13px #ccc!important;
}
.panel:hover{
    box-shadow:1px 2px 7px #f2f2f2!important;
}
.theme-default .nav-tabs>li.active>a, .theme-default .nav-tabs>li.active>a:focus, .theme-default .nav-tabs>li.active>a:hover {
    background: #1d89cf!important;
    border-bottom: 2px solid #1d89cf!important;
    color: #fff!important;
    text-transform: capitalize!important;
}
.form-horizontal .form-group {
    margin-left: -11px;
    margin-right: -11px;
    border-bottom: #FFFDE7 solid 1px;
    margin: 10px;
}










.img-circle {

    box-shadow: 7px 12px 19px #a59d9d!important;
}
.tabs-left > .nav-tabs > li > a {
    margin-right: 0px;
    -webkit-border-radius: 0px 0 0 0px;
    -moz-border-radius: 0px 0 0 0px;
    border-radius: 0px 0 0 0px;
    text-transform: capitalize!important;
    font-size: 13px;
    padding: 8px 5px!important;
}
.form-horizontal .control-label {
    font-weight: bold!important;
}
.student-detail-container {
    background: #f8f8f8!important;
    padding: 10px!important;
	overflow: hidden!important;
	margin-bottom:20px!important;
}
.tab-content>.active {
    display: block;
	padding: 7px!important;
    border: #FF9800 solid 1px!important;
}
.tab-pane h3 {

    font-size: 16px!important;
	font-family:'Roboto';
}
@media (max-width: 992px){
.tab-pane h3 {
    margin-top: 5%!important;
}
.text-right {
    text-align: center!important;
}
}
/*New Style*/
.profile-img{width: 200px;
            height: 200px;
            border: 7px solid #b7b7b7; background-color: #eee5de;
            position: relative;
			box-shadow:#1px 1px #ccc;
            border-inline-start: 7px #ffc844 solid;
            border-radius:50%;margin:0 auto;}
 .border-bottom{border-bottom:1px solid #000;padding-bottom:10px}           
    
.no-padding{padding:0px}
.tooltip{padding:20px!important;height:50px}




.tabs-left > .nav-tabs > li,
.tabs-right > .nav-tabs > li {
  float: none;
}

.tabs-left > .nav-tabs > li > a,
.tabs-right > .nav-tabs > li > a {
  min-width: 74px;
  margin-right: 0;
  margin-bottom: 3px;
  color:#000;font-weight:400;
}

.tabs-left > .nav-tabs {
  float: left;
  margin-right:0px;
  border-right:0px solid #000;
}

.tabs-left > .nav-tabs > li > a {
  margin-right: 0px;
  -webkit-border-radius: 0px 0 0 0px;
  -moz-border-radius: 0px 0 0 0px;
  border-radius: 0px 0 0 0px;text-transform: uppercase;
  font-size:13px;padding:10px 5px;
}

.tabs-left > .nav-tabs > li > a:hover,
.tabs-left > .nav-tabs > li > a:focus {
  border-color: #eeeeee #dddddd #eeeeee #eeeeee;
}

.tabs-left > .nav-tabs .active > a,
.tabs-left > .nav-tabs .active > a:hover,
.tabs-left > .nav-tabs .active > a:focus {
	border: 1px solid transparent;
    border-bottom: 4px solid #ffc844;
    background:#ddd;color:#000;
}
.tabs-left > .nav-tabs{border-bottom:0px;width: 100%;}
.student-detail-container{background: #f8f8f8;padding:0 5px;}
.line-space{line-height: 2em}
.tab-pane  h3{
margin-top: 0;
margin-bottom:20px;
background: #ffc844;
padding: 5px;
text-transform: uppercase;
}
.container {
	width: 100%;font-size:12px;
}
.main-wrapper {
	*background: #f4f4f4;
	padding-top: 10px;
	font-size: 14px
}
.table{width:100%}
@media (max-width: 767px) 
   {
    .tab-pane h3 
	{
    margin-top: 106%;
    }
}
@media (max-width: 992px) 
   {
    .tab-pane h3 
	{
    margin-top: 106%;
    }
}
</style>
<div id="content-wrapper">
  <div class="page-header">
    <div class="row ">
      <div class="col-sm-12">
        <div class="panel">
          <div class="panel-body">
<div class="row">
  <div class="container">
    <div class="col-md-3">
    <div class="profile-img">
        <?php
		 $role_id = $this->session->userdata('role_id');
                                     //  $tep = base_url().'uploads/2017-18/'.$emp_list[$i]['form_number'].'/' . $emp_list[$i]['form_number'].'_PHOTO.bmp';
                                     //  echo $tep;
                                       if (file_exists('uploads/2017-18/'.$emp[0]['form_number'].'/' . $emp[0]['form_number'].'_PHOTO.bmp')) {
                                         //  echo "yES";
                                           $ext = 'bmp';
                                       }
                                       else
                                       {
                                             $ext = 'jpg';
                                       }
                                       ?>
    <img src="<?=base_url()?>uploads/student_photo/<?=$emp[0]['enrollment_no']?>.jpg"  width="100%" height="100%" class="img-circle">
   </div>
    </div>
   <div class="col-md-9">
   <h3 class=""><b>Name: <?=$emp[0]['last_name']?> <?=$emp[0]['first_name']?> <?=$emp[0]['middle_name']?></b></h3>
   <hr/>
   <div class="row">
    <div class="col-md-8 ">
	<?php
        $ac_year=(int)substr($emp[0]['academic_year'],2,2)+1;
         $adm_year=(int)substr($emp[0]['admission_session'],2,2)+1;
        /*
		if($emp[0]['lateral_entry']=='N'){
			$first_y = "First Year".'&nbsp;&nbsp; ('.$emp[0]['admission_session'].'-'.$adm_year.' )';
		}else{
			$first_y = "Direct Second  Year".'&nbsp;&nbsp;('.$emp[0]['admission_session'].'-'. $adm_year.' )';
		}
		*/
		//Updated for the direct third year student by kishor 07-09-2019
		if($emp[0]['lateral_entry']=='N'){
			$first_y = "First Year".'&nbsp;&nbsp; ('.$emp[0]['admission_session'].'-'.$adm_year.' )';
		}elseif($emp[0]['admission_year']=='2' && $emp[0]['lateral_entry']=='Y'){
			$first_y = "Direct Second Year".'&nbsp;&nbsp;('.$emp[0]['admission_session'].'-'. $adm_year.' )';
		}elseif($emp[0]['admission_year']=='3' && $emp[0]['lateral_entry']=='Y'){
			$first_y = "Direct Third Year".'&nbsp;&nbsp;('.$emp[0]['admission_session'].'-'. $adm_year.' )';
		}
			
		
  switch($emp[0]['current_year']){
     case '1': $year="First Year";
     break;
      case '2':$year="Second Year";
     break;
      case '3':$year="Third Year";
     break;
      case '4':$year="Fourth Year";
     break;
   
  }
    //print_r($emp[0]);
	?>
	
	<?php 
	   echo "<span style='color:green;'>".@$this->session->flashdata('msg5')."</span>";
	  ?>
					   
     <div class="table-responsive">
       <table class="table table-bordered  table-hover">
           <tr>
               <td class="bg-primary text-white" width="30%">Admission Type</td>
               <td><b><?=$first_y?></b></td>
         </tr>
         <tr>
               <td class="bg-primary text-white">PRN No</td>
               <td><b><?=$emp[0]['enrollment_no']?></b></td>
             </tr>
             <tr>
               <td class="bg-primary text-white">Student Id</td>
               <td><b><?=$stud_id?></b></td>
             </tr>
             <tr>
               <td class="bg-primary text-white">Course Name</td>
               <td><b><i><?=$emp[0]['stream_name']?> (<?=$emp[0]['stream_code']?>)</i></b></td>
             </tr>
                <tr>
               <td class="bg-primary text-white">Current Year</td>
               <td><b><?=$year.'   ('.$emp[0]['academic_year'].'-'.$ac_year.')'?></b></td>
             </tr>
              <tr>
               <td>Current Semester</td>
               <td><b><?=$emp[0]['current_semester']?></b></td>
             </tr>
			 <tr>
               <td>Admission Cycle</td>
               <td><b><?php if(!empty($emp[0]['admission_cycle'])){ echo $emp[0]['admission_cycle'];}else{ echo $emp[0]['admission_session'];}?></b></td>
             </tr>
			 <?php if($role_id==2 || $role_id==6){?>
			 <tr>
               <td>Username:</td>
			   <td><b><?php if(!empty($emp[0]['username'])){ echo $emp[0]['username'];}else{ echo 'Not Generated';}?></b></td>
			   
             </tr>
			 <tr>
			   <td>Password:</td>
               <td><b><?php if(!empty($emp[0]['password'])){ echo $emp[0]['password'];}?></b></td>
             </tr>
			 <?php }?>
        </table>
		</div>
		
        <?php
       // print_r($get_feedetails); 
        ?>
		<?php if($role_id==20 || $role_id==44){ ?>
		<form id="form1" name="form1" action="<?=base_url($currentModule.'/update_marathiname')?>" method="POST">
		<input type="hidden" name="student_code" value="<?=$emp[0]['stud_id']?>">
		<input type="hidden" name="enrollment_no" value="<?=$emp[0]['enrollment_no']?>" >
			<div class="form-group">				
				<label class="col-sm-4" >Guardian First Name :</label>  
				<div class="col-sm-6">
					<input type="text" class="form-control " name="guard_fname" id="guard_fname" placeholder="First Name" value="<?=$emp[0]['gfirst_name']?>"  onkeydown="onlyAlphabets(event)" onpaste="onlyAlphabets(event)">
					</div>
					</div>
					<div class="form-group">	
					<label class="col-sm-4" >Guardian Middle Name :</label> 
					<div class="col-sm-6">
					<input type="text" class="form-control" name="guard_mname" id="guard_mname" placeholder="Middle Name" value="<?=$emp[0]['gmiddle_name']?>" onkeydown="onlyAlphabets(event)" onpaste="onlyAlphabets(event)" >
					</div>
					</div>
					<div class="form-group">	
					<label class="col-sm-4" >Guardian Last Name :</label> 
					<div class="col-sm-6">
					<input type="text" class="form-control" name="guard_lname" id="guard_lname" placeholder="Last Name" value="<?=$emp[0]['glast_name']?>" onkeydown="onlyAlphabets(event)" onpaste="onlyAlphabets(event)" >
				</div>
				</div>
				<div class="form-group">	
				<label class="col-sm-4" >Guardian Mobile No. :</label>
				<div class="col-sm-6">
					<input type="text" class="form-control numbersOnly" name="guardian_mobno" id="guardian_mobno" placeholder="Enter Mobile No." value="<?=$emp[0]['parent_mobile2']?>" minlength='10' maxlength='10' 
					pattern="[7-9]{1}[0-9]{9}" >
				</div> 
				</div> 
				<div class="col-sm-2">
					<button type="submit" name="guardian_det_submit" value="guardian_det_submit" class="btn btn-primary">Update</button>
				</div>					
			</div>
		</form>

		<?php }else { ?>
				<form id="form1" name="form1" action="<?=base_url($currentModule.'/update_marathiname')?>" method="POST">
			<input type="hidden" name="student_code" value="<?=$emp[0]['stud_id']?>">
			<div class="form-group">
				
				<label class="col-sm-4" >Student In Marathi Name :</label>  
				
				<div class="col-sm-6">
					<input type="text" class="form-control" name="marathi_name" id="marathi_name" placeholder="student_marathi_name." value="<?=$emp[0]['marathi_name']?>" >
				</div> 
				
									
			</div>
			<div class="form-group">
				
				<label class="col-sm-4" >Student Regulation :</label>  
				
				<div class="col-sm-6">					
					<select name="stud_regulation" id="stud_regulation" class="form-control" required="">
					<option value="">Select Regulation</option>
					<option value="2017" <?php if($emp[0]['stud_regulation']==2017){?>selected="selected" <?php }?>>2017</option>
					<option value="2023" <?php if($emp[0]['stud_regulation']==2023){?>selected="selected" <?php }?>>2023</option>
					</select>
				</div> 
				<div class="col-sm-2">
					<button type="submit" name="student_marathi_submit" value="student_marathi_submit" class="btn btn-primary">Update </button>
				</div>
									
			</div>
		</form>
		
		<?php } ?>
	</div>
  
   </div>
  
   </div>
   <div class="clearfix"></div>
    
   

</div>
			</div>
		</div>
	</div>
	</div>
</div>	


<?php include 'footer.php';?>

<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
	
 $(".numbersOnly").keydown(function (event) {
    var num = event.keyCode;
    if ((num > 95 && num < 106) || (num > 36 && num < 41) || num == 9) {
        return;
    }
    if (event.shiftKey || event.ctrlKey || event.altKey) {
        event.preventDefault();
    } else if (num != 46 && num != 8) {
        if (isNaN(parseInt(String.fromCharCode(event.which)))) {
            event.preventDefault();
        }
    }
 });	
});
function onlyAlphabets(event) {
  //allows only alphabets in a textbox
  if (event.type == "paste") {
    var clipboardData = event.clipboardData || window.clipboardData;
    var pastedData = clipboardData.getData('Text');
	var format = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/;
    if (isNaN(pastedData) ) {
		if(format.test(pastedData)){
			event.preventDefault();
		}
		else{
			return;
		}
    }
	

	else {
      event.preventDefault();
    }
  }
  var charCode = event.which;
  if (!(charCode >= 65 && charCode <= 120) && (charCode != 32 && charCode != 0) && charCode != 8 &&  charCode != 9 && (charCode >= 48 && charCode <= 57) || (charCode >= 96 && charCode <= 105)) {
    event.preventDefault();
  }
}
function Reported(){
	//alert();
	  var current_year='<?php echo date('Y');?>';
	  var academic_year ='<?php echo $emp[0]['academic_year'];?>';
	  var admission_session ='<?php echo $emp[0]['admission_session'];?>';
	  var admissionacademic_year ='<?php echo $admission_detail[0]['academic_year'];?>';
	  var totfeepaid='<?php echo$admission_detail[0]['totfeepaid'];?>';
	 // alert(totfeepaid);
	if((academic_year==current_year)&&(admission_session!==current_year)&&(admissionacademic_year==current_year)&&(totfeepaid.length== 0)){
	
	alert("Current Year Student Does Not Paid Payment");
	return false;
	 }else{
	if (confirm("Are you sure ?")) {
    //alert("Here you go!");
	return true;
}else{
	return false;
}
 } 
}
</script>


