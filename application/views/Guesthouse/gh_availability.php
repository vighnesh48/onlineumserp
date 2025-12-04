<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<style>
.widget-messages-alt .messages-list {
    overflow: inherit;
    position: relative;
}
#acnt{font-weight: bold;font-size: 15px;}
.table1 {display:block;border-collapse:separate;border-spacing:10px; height:8px;border-top:#ccc dashed 1px;
margin-top:5px;}
.innerdiv{
color: #fff;
    height: 36px;
    width: 36px;
    line-height: 36px;
    background-color: #9fa4a5;
    border-radius: 50%;
    display: inline-block;
    margin-left: 7px;
    box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.14), 0 3px 1px -2px rgba(0, 0, 0, 0.2), 0 1px 5px 0 rgba(0, 0, 0, 0.12);
}
.padding-tb-5{padding:5px 10px}
.card-stats .card-header+.card-footer {
    border-top: 1px solid #eee;
    margin-top: 20px;
}

.row1 {display:table-row;}
.border-rgt{border-right: 1px dashed #ccc;}
.main-box{width:27%;height:178px;    box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.14), 0 3px 1px -2px rgba(0, 0, 0, 0.2), 0 1px 5px 0 rgba(0, 0, 0, 0.12);box-sizing: border-box;background: #fff;margin:25px;border-radius:5px;padding:0px; }


@media screen and (max-width:768px){
.main-box {
    width: 100%;
    height: 216px;
    margin: 5px;
}
}




</style>
<script>
$(document).ready(function(){
	
	var input_data='<option value="">Select No. Of Person</option>';

	for (i=1;i<=10;i++)
	{
		input_data+='<option value="'+i+'"> '+i+'</option>';
	}
	$('#nperson').html(input_data);
	
	$('#campus').change(function() {
		//common_call();
	});
	
	$('#gtype').change(function() {
		//common_call();
		  <?php // print_r($_SESSION);
$rolid = $this->session->userdata("role_id");
if($rolid=='6'){
                    ?>
		var camp =$('#campus').val();
		<?php } ?>
		var htyp=$('#gtype').val();


		$.ajax({
													type: 'POST',
													 url: '<?= base_url() ?>Guesthouse/getghouse_list_creteria_dropdown',
													<?php if($rolid=='6'){
                    ?>
        data: { host_typ: htyp, camp:camp},
        <?php }else{?>
  data: { host_typ: htyp},
        	<?php } ?>
													success: function (html) {
														//alert(html);
														//if(html !=''){
														$('#hoslist').html(html);
														//}else{
														//  $('#hcity').html('<option value="">First Select District</option>');  
														//}
														
													}
												});
	});
	
	$('#btn_submit').click(function() {
		common_call();
	}); 
	
	$('#doc-sub-datepicker21').on('changeDate', function (e) {
		//common_call();
	}); 
			
	$('#doc-sub-datepicker22').on('changeDate', function (e) {
		//common_call();
	}); 
	
	$('#doc-sub-datepicker21').datepicker( {
  todayHighlight: true,
  format: 'yyyy-mm-dd',
  autoclose: true,
  startDate: new Date()
  });
	$('#doc-sub-datepicker22').datepicker( {
  todayHighlight: true,
  format: 'yyyy-mm-dd',
  autoclose: true,
  startDate: new Date()
  });
	
});

function common_call()
{
	var campus=$('#campus').val();
	var gtype=$('#gtype').val();
	var g_id=$('#hoslist').val();
	var nperson=$('#nperson').val();
	var fdate=$('#doc-sub-datepicker21').val();
	var tdate=$('#doc-sub-datepicker22').val();
	$("#display_avalability").html('');

	type='POST',url='<?= base_url() ?>Guesthouse/get_ghouse_list_by_creteria';
	datastring={campus:campus,gtype:gtype,nperson:nperson,cin:fdate,cout:tdate,g_id:g_id};
	html_content=ajaxcall(type,url,datastring);
	//alert('html_content='+html_content);
	$("#display_avalability").html(html_content);
	//display_content(html_content);		
}

function display_content(html_content)
{
	var content='';
	var content1='';
	if(html_content === "{\"ghouse_list\":[]}")
	{
		$('#itemContainer1').html('');
		$('#bookbtn').hide();
		$('#tableinfo').hide();
		$('#err_msg1').html('Records Not Found Please change search criteria and try again');
	}
	else
	{
		$('#err_msg1').html('');
		$('#pdf').show();
		$('#excel').show();
		var array=JSON.parse(html_content);
		len=array.ghouse_list.length;
		//alert(len+"==="+html_content);
		var j=1;
		for(i=0;i<len;i++)
		{
			content+='<div class="col-md-3 main-box" ><div style="text-align:center;"><h3>'+array.ghouse_list[i].guesthouse_name+'</h3></div><div style="margin:10px;padding:10px;"><div class="col-md-6" style="text-align:center;"><b>'+array.ghouse_list[i].campus+'</b></div><div class="col-md-6" style="text-align:center;"><b>'+array.ghouse_list[i].guesthouse_type+'</b></div></div><div style="padding:5px">';
				if(array.ghouse_list[i].current_status=='AVAILABLE')
				content+='<span style="color:Green" ><b>AVAILABLE</b></span> : <span style="color:black;"><b>'+array.ghouse_list[i].bed_available+'</b></span>';
			else if(array.ghouse_list[i].current_status=='FULL')
				content+= '<span style="color:red" >FULL</span>';
			else 
				content+= '<span style="color:#1d89cf" >RESERVED</span>';
			
			content+='</div><div class="table1" ><div class="row1" >';
			var t= array.ghouse_list[i].bed_capacity;
			for(k=1;k<=t;k++){ 
				content+='<div class="innerdiv" >'+k+'</div>';
			}
			
			content+='</div></div></div>';
			
			
			
			j++;
		}
		$('#itemContainer1').html(content);
		$('#bookbtn').show();
		$('#tableinfo').show();
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
<style>.hostel-logo{width:100px;height:100px;border-radius:50%;background:#e66554;text-align:center;color:#fff;margin-left:10px;}
.hostel-logo > h3{padding-top:37px;}</style>
<div id="content-wrapper">
<div class="row banner-bg"> </div>
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Masters</a></li>
        <li class="active"><a href="<?=base_url($currentModule)?>">Guest House</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-5 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp; Guest House Availability</h1>
			
        </div>
        	<div class="pull-right col-xs-4 col-sm-auto" id="bookbtn"><a style="width: 100%;" class="btn btn-primary btn-labeled" href="<?=base_url($currentModule."/book_guesthouse")?>">Book Guest House </a></div>

        <div class="row ">
            <div class="col-sm-12">
               <div class="panel">
             	<div class="panel-heading">
                    <div class="row">
                    <?php // print_r($_SESSION);
$rolid = $this->session->userdata("role_id");
if($rolid=='6'){
                    ?>
                           <div class="col-sm-2" style="padding-left:0px;">
						<select id="campus" name="campus" class="form-control" >
								  <option value="">Select Campus</option>
								  <option value="NASHIK">Nashik</option>
								  <option value="SIJOUL">Sijoul</option>
						</select>
						</div>
						<?php } ?>
						<div class="col-sm-2" style="padding-left:0px;">
							<select id="gtype" name="gtype" class="form-control" >
									  <option value="">Select Guest House Type</option>
									  <?php if($rolid=='17'){ ?>
									  <option value="H">Hostel</option>
									  <?php }elseif($rolid=='28'){ ?>
									  <option value="T">Trustee Office</option>
									  <?php }elseif($rolid=='2'){ ?>
<option value="H">Hostel</option><option value="T">Trustee Office</option>
									  <?php } ?>
							</select>
						</div>

						<div class="col-sm-2" style="padding-left:0px;">
							<select id="hoslist" name="hostlist" class="form-control" >
									  <option value="">Select Hostel/Trustee</option>
									 
							</select>
						</div>
						
							<!--label class="col-sm-1" style="padding-left:0px;">CheckIn:</label>-->
							<div class="col-sm-1" style="padding-left:0px;width:11%;">
							  <input type="text" class="form-control" placeholder="CheckIn Date" id="doc-sub-datepicker21" name="fdate"  readonly="true"/>
							</div>
							<!--label class="col-sm-1" style="padding-left:0px;">CheckOut:</label>-->
						
							<div class="col-sm-2" style="padding-left:0px;width:11%;">
							  <input type="text" class="form-control" placeholder="CheckOut Date" id="doc-sub-datepicker22" name="tdate"  readonly="true"/>
							</div>
							<div class="col-sm-2" style="padding-left:0px;">
						<select id="nperson" name="nperson" class="form-control" >
								  
								 
						</select>
						</div>
					
							<div class="col-sm-1" style="padding-left:0px;">
							<button style="padding-left:6px;" class="btn btn-primary form-control" id="btn_submit" type="submit" >Check </button>
							</div>
                    </div>
					
                </div>	
				<div class="panel-body" >
                <h4 id="flash-messages" style="color:Green;padding-left:250px;">
				<?php if(!empty($this->session->flashdata('message1'))){ echo $this->session->flashdata('message1'); } ?></h4>
				<h4 id="flash-messages" style="color:red;padding-left:250px;">
				<?php if(!empty($this->session->flashdata('message2'))){ echo $this->session->flashdata('message2'); } ?></h4>
				<div class="panel widget-messages-alt">
       <!-- <div class="panel-heading"> <span class="panel-title"><i class="panel-title-icon fa fa-bars"></i>All Guest House
         List</span> </div>
         / .panel-heading -->
        <div class="panel-body padding-sm" id="display_avalability">
			<div class="messages-list">	
			<div class="row text-center" id="itemContainer1" align="center" >
			
				
                      <?php
					  $fdate1=date('Y-m-d');
					  $tdate1=date('Y-m-d');
				if(!empty($get_beds_available_gh))
				{
					$j=1;                      
					for($i=0;$i<count($get_beds_available_gh);$i++)
					{
						$bd = $this->Guesthouse_model->get_gesthouse_booking_list_bydate_avalability($get_beds_available_gh[$i]['gh_id'],$fdate1,$tdate1);
						
						?>
						<div class="col-md-3 main-box" >
			<div  class=" card card-stats"style="text-align:center ">
<?php
$rolid = $this->session->userdata("role_id");
if($rolid=='6'){
echo $get_beds_available_gh[$i]['campus'];
echo "<br/>";
}
$rmno = explode('_',$get_beds_available_gh[$i]['location']);
?><div class="card-header card-header-warning">
			<h3 style="font-size: 19px;
    color: #ffffff;
    font-weight: 400;
    margin-top: 0px;
    padding: 10px;
    background-color: #1d89cf;
    border-top-left-radius: 7px;
    border-top-right-radius: 7px;"><?=$get_beds_available_gh[$i]['guesthouse_name']?></h3></div></div>
			
            <?php //if($get_beds_available_gh[$i]['location']=='T'){ ?>
           <!--  <div style="padding:5px"><b>Floor:<?=$get_beds_available_gh[$i]['floor']?></b></div> -->
            <?php //}else{ ?>
            <div style="">
			<div class="col-md-6 padding-tb-5" style="text-align:left;"><b>Room No:<?=$get_beds_available_gh[$i]['room_no']?></b></div>
			<div class="col-md-6 padding-tb-5" style="text-align:right;"><b>Floor:<?=$get_beds_available_gh[$i]['floor']?></b></div></div>
			<?php// } ?>
			
            <div  style="padding:5px"><span  class="padding-tb-5" style="text-align:left;"><b>Available : </b></span><span style="color:black;" id="acnt_<?=$get_beds_available_gh[$i]['gh_id']?>"><b></b></span></div>
			<div class="table1" >
		<div class="row1" >
			<?php   $f = $get_beds_available_gh[$i]['bed_capacity'];
			//echo $get_beds_available_gh[$i]['doubel_bed'];
			$ck= explode(',',$get_beds_available_gh[$i]['doubel_bed']);
				//print_r($c[$get_beds_available_gh[$i]['gh_id']]);				
				for($k=1;$k<=$f;$k++){ 
				if(in_array($k, $ck)){
										$db = 'style=""';
									}else{
										$db='';
									}
									//echo $db;
		if(count($bd)>0){
		
			if(in_array($k,$bd)){
				$r= array_search($k,$bd);
				$r1= explode("_", $r);
				if(substr($r1[0],0,-1)=='CHECK-IN'){
					$bc = 'style="background-color:green;border:green"';
				}elseif(substr($r1[0],0,-1)=='CANCELLED'){
					$bc = 'style="background-color:red;border:red"';
				}else{
					$bc = 'style="background-color:orange; border:orange"';
				}
		//	}
			?>
<div data-target="#myModal" data-toggle="modal" data-id="<?=$r1[1]?>"  class="btn-block1 innerdiv"  <?=$bc?> <?=$db?>  ><?=$k?></div>
				<?php
						
				}else{
$a[$get_beds_available_gh[$i]['gh_id']][]=1;

					?>
			<div class="innerdiv" <?=$db?> ><?=$k?></div>
				<?php  } // } //}
		}else{ 
$a[$get_beds_available_gh[$i]['gh_id']][]=1;
			?>
		<div class="innerdiv" <?=$db?>  ><?=$k?></div>
		<?php }

			}
			?></div>
			</div>
			</div>
						<script>$('#acnt_<?=$get_beds_available_gh[$i]['gh_id']?>').text(<?php if(!empty($a[$get_beds_available_gh[$i]['gh_id']])) { echo array_sum($a[$get_beds_available_gh[$i]['gh_id']]); }else{ echo '0'; } ?>);</script>
					
						
						<?php 	//exit;
						$j++;
					}
					//print_r($act."_".$get_beds_available_gh[$i]['gh_id']);
					?> 
						<!--</table>-->	
					</div>
				</div>
				</br>
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

<div id="myModal" class="modal" role="dialog"  >
						  <div class="modal-dialog" id="dispcon">

							<!-- Modal content-->
						

						  </div>
						</div>
						<script>
$('.btn-block1').on('click',function(){
            var id=$(this).data('id');
            //alert(id);
    $('.modal-body').html('loading');
       $.ajax({
        type: 'POST',
        url: '<?= base_url() ?>Guesthouse/get_booking_details',
        data:{id: id},
        success: function(data) {
          $('#dispcon').html(data);
        },
        error:function(err){
          alert("error"+JSON.stringify(err));
        }
    })
 });
</script>