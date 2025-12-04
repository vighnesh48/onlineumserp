<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<style>.hostel-logo{width:100px;height:100px;border-radius:50%;background:#e66554;text-align:center;color:#fff;margin-left:10px;}
.hostel-logo > h3{padding-top:37px;}
h4{color:dodgerblue}
h3{font-weight: 800;color: #999999;}
.details{box-shadow:0px 0px 2px 0px #8b8686;margin:2em;padding:0.5em;}
.sidebar{background:dodgerblue;height:100%;position:fixed;z-index:1000}
.main{padding-left:11em;}
.fa{font-size:0.8em}
.dash-icon{color:white;}
.hoverbg{background-color:transparent}
.hoverbg:hover{background-color:#157ee5;cursor:pointer}.
.text-center{text-align:left}
.stik-side{position:fixed}
.border-rgt{border-right: 1px dashed #ccc;min-height: 100px;}

@media (max-width:768px){
.sidebar{height:15%;width:100%}
.main{padding-left:2em;padding-top:5em}
.mg-tp{margin-top:1em}
}

</style>
<script>

$(document).ready(function(){
	$('#header').html('All');
	$('#gtype').change(function() {
		common_call();
	});
	
	$('#nperson').change(function() {
		//common_call();
	}); 
	
	$('#doc-sub-datepicker21').on('changeDate', function (e) {
		//common_call();
	}); 
			
	$('#doc-sub-datepicker22').on('changeDate', function (e) {
		//common_call();
	}); 
	
	$('#doc-sub-datepicker21').datepicker( {
  todayHighlight: true,
  format: 'dd/mm/yyyy',
  autoclose: true,
  setDate: new Date()
  });
	$('#doc-sub-datepicker22').datepicker( {
  todayHighlight: true,
  format: 'dd/mm/yyyy',
  autoclose: true,
  setDate: new Date()
  });
	
}); 
var bed_available=0;
var gtype=0;
function common_call()
{
	var ghouse=$('#gtype').val();
	if(ghouse=='')
	{
		alert('Please Select Guesthouse');
		return false;
	}
	else
	{
		$('#header').html($("#gtype option:selected").text());
		var arr=ghouse.split("_");
		gtype=arr[0];
		bed_available=arr[1];
	/* 	var nperson=$('#nperson').val();
		var fdate=$('#doc-sub-datepicker21').val();
		var tdate=$('#doc-sub-datepicker22').val(); */

		type='POST',url='<?= base_url() ?>Guesthouse/dashboard_details_by_id';
		datastring={gtype:gtype};//,nperson:nperson,cin:fdate,cout:tdate
		html_content=ajaxcall(type,url,datastring);
		//display_content(html_content);
		$('#Container').html(html_content);
	}	
}



function ajaxcall(type,url,datastring)
{  
	var res;
	$.ajax({
		type:type,
		url:url,
		data:datastring,
		cache:false,
		async:false,
		success: function(result)
	 {
	  res=result;	 
	 }
	});
	return res; 
}
</script>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Masters</a></li>
        <li class="active"><a href="<?=base_url($currentModule)?>">Guest House</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-5 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp; Dash Board</h1>
			
        </div>

        <div class="row ">
            <div class="col-sm-12">
               <div class="panel">
             	<div class="panel-heading">
                    <div class="row">
                        <div class="col-sm-5">
						<span class="panel-title"><h4>Guest House: <b><span id="header"></span></b></h4></span>
						</div>
						<div class="col-sm-2 pull-right" style="padding-left:0px;">
							<select id="gtype" name="gtype" class="form-control" >
									  <option value="">Select Guest House</option>
									  <?php 
									if(!empty($guesthouse_details)){
										foreach($guesthouse_details as $gh){
											?>
										  <option value="<?=$gh['gh_id'].'_'.$gh['bed_available']?>"><?=$gh['guesthouse_name']?></option>  
										<?php 
											
										}
									}
							  ?>
							</select>
						</div>
						<!-- <div class="col-sm-2" style="padding-left:0px;">
							  <input type="text" class="form-control" placeholder="CheckIn Date" id="doc-sub-datepicker21" name="fdate"  readonly="true"/>
							</div>
							<div class="col-sm-2" style="padding-left:0px;">
							  <input type="text" class="form-control" placeholder="CheckOut Date" id="doc-sub-datepicker22" name="tdate"  readonly="true"/>
							</div>
							-->
                    </div>
					
                </div>	
				<div class="panel-body" >
                <h4 id="flash-messages" style="color:Green;padding-left:250px;">
				<?php if(!empty($this->session->flashdata('message1'))){ echo $this->session->flashdata('message1'); } ?></h4>
				<h4 id="flash-messages" style="color:red;padding-left:250px;">
				<?php if(!empty($this->session->flashdata('message2'))){ echo $this->session->flashdata('message2'); } ?></h4>
                 <?php
				if(!empty($dashboard_details))
				{
					
					?>   <div class="row" id="Container">    

<?php foreach ($dashboard_details as $key => $value) { ?>
	
					<div class="row details" >
<div class="col-md-2" style="padding:10px;text-align:center;">
<div class="hostel-logo"><br/><b><?=$value['campus']?></b><br/><b><?=$value['guesthouse_name']?></b></div>
<h4>Room No. <?=$value['room_no'];?></h4>
</div>
<div class="col-md-7 col-sm-4">
<div class="row">
<div class="col-md-9 col-xs-9 "><h4><?=$value['visitor_name']?></h4></div><div class="col-md-3 col-xs-3 ">&nbsp;&nbsp;
<?php if($value['current_status']=='CHECK-IN'){
					$bc = 'style="color:orange;"';
				}elseif($value['current_status']=='CANCELLED'){
                     $bc = 'style="color:red;"';
				}elseif($value['current_status']=='CHECK-OUT'){
					$bc = 'style="color:blue;"';
				}else{
					$bc = 'style="color:green;"';
				} ?>
<span <?=$bc?> ><b><?=$value['current_status']?></b></span></div>
</div>
<h6><?=$value['address']?>,&nbsp;&nbsp;<?=$value['state_name']?>,&nbsp;&nbsp;<?=$value['taluka_name']?></h6>
<h6><b><?=$value['id_proof']?>:</b> <?=$value['id_ref_no']?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Pin Code : </b><?=$value['pincode']?></h6>
<h5>Charge: <?php if($value['charges']!=''){ ?> Rs. <?=$value['charges']?>/- <?php }else{ ?> -- <?php } ?></h4>
<h5><b>Booking Date : <?php if($value['proposed_in_date']!=''){  echo date('d M Y h:i',strtotime($value['proposed_in_date'])); } ?>&nbsp; TO &nbsp;<?php if($value['proposed_out_date']!=''){  echo date('d M Y h:i',strtotime($value['proposed_out_date'])); } ?>  &nbsp;&nbsp;&nbsp;&nbsp; Days: <?=$value['no_of_days']?> &nbsp;&nbsp;&nbsp;&nbsp; Bed No.: <?=$value['bed_no']?></b></h4>

</div>
<div class="col-md-3 mg-tp">
<div class="col-md-6 col-xs-6 border-rgt">
<h6>CHECK-IN</h6>
<h3><?php if($value['checkin_on']!='') { echo date('d',strtotime($value['checkin_on'])); } ?></h3>
<h5><b><?php if($value['checkin_on']!='') { echo date('F',strtotime($value['checkin_on'])); } ?></b></h5>
<h6><?php if($value['checkin_on']!='') { echo date('l',strtotime($value['checkin_on'])); } ?></h6>
</div>

<div class="col-md-6 col-xs-6">
<h6>CHECK-OUT</h6>
<h3><?php if($value['checkin_out']!='') { echo date('d',strtotime($value['checkin_out'])); } ?></h3>
<h5><b><?php if($value['checkin_out']!='') { echo date('F',strtotime($value['checkin_out'])); } ?></b></h5>
<h6><?php if($value['checkin_out']!='') { echo date('l',strtotime($value['checkin_out'])); } ?></h6>
</div>
</div>
</div>

<?php } ?>


                   
                              <?php
							  
                           ?>   
                       </div>                   
                  
                </div>
				<?php
				}else{
					?>
					<h4 style="color:red;padding-left:200px;">Guest House Have Not Found</h4>
					<?php
				}
				  ?>
				  <h4 style="color:red;padding-left:200px;" id="err_msg1"></h4>
				   </div>
                </div>
            </div>
			
            </div>    
        </div>
    </div>
</div>

