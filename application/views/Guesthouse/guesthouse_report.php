<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
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
<script>
$(document).ready(function(){
	var today = new Date();
	var dd = today.getDate();
	var mm = today.getMonth()+1; //January is 0!
	var mmm= today.getMonth();
	var yyyy = today.getFullYear();
	if(dd<10){
	dd='0'+dd;
	} 
	if(mm<10){
	mm='0'+mm;
	} 
	var today = dd+'/'+mm+'/'+yyyy;
	
	//$('#header_date').html(dd+" "+monthNames[mmm]+", "+yyyy%100);
		
	$('#doc-sub-datepicker20')
	   .datepicker({
		   
		   autoclose: true,
		   todayHighlight: true,
		   format: 'dd/mm/yyyy',
		   setDate: new Date()
		   
	   });
	 $('#doc-sub-datepicker21').datepicker( {
  todayHighlight: true,
  format: 'dd/mm/yyyy',
  autoclose: true,
  setDate: new Date()
  });
	$('#doc-sub-datepicker23').datepicker( {
  todayHighlight: true,
  format: 'dd/mm/yyyy',
  autoclose: true,
  setDate: new Date()
  });

  $('#vmobile').keyup(function() {
		var node = $(this);
			node.val(node.val().replace(/[^0-9]/g,'') ); 
	});
  
  $('#vname').keyup(function() {
		$(this).val($(this).val().toUpperCase());
	});
  
  $('#report').change(function() {
	   if (this.value == 4) {
		   $('#single').hide();
		   $('#vhistory').show();
		   $('#gtype').hide();
		   $('#between').hide();
			$('#datewise').hide();
	   }
	   else if (this.value == 5) {
		   $('#single').show();
		   $('#selectby').hide();
		   $('#vhistory').hide();
		   $('#gtype').show();
		   $('#between').hide();
			$('#datewise').hide();
	   }
	   else{
		    $('#vhistory').hide();
		   $('#gtype').hide();
		   $('#single').show();
		    $('#selectby').show();
			$("#selectby").trigger("change");
	   }
		   
  });
  
	$('#selectby').change(function() {
	
        if (this.value == 'Datewise') {
			$('#doc-sub-datepicker20').val(today);
            $('#between').hide();
			$('#datewise').show();
        }
        else if (this.value == 'Between') {
			$('#doc-sub-datepicker21').val(today);
			$('#doc-sub-datepicker23').val(today);
            //alert("home");
			$('#between').show();
			$('#datewise').hide();
        }
		else
		{
			$('#between').hide();
			$('#datewise').hide();
		}
		//common_call();
	});
	
	$('#btnView').click(function(){
                var report = $("#report").val();
                var selectby = $("#selectby").val();
                         
				if(report==""){
				  alert("Please select All Options");
				}
				else if((report==1 || report==2) && selectby=="" ){
				  alert("Please select All Options");
				}
				else if(report==4 &&(($("#vname").val())=="" && ($("#vmobile").val())=="" )){
				  alert("Please select All Options");
				}
				else if(report==5 &&($("#gtype").val())==""){
				  alert("Please select All Options");
				}
				else
				{
					if(report==1 || report==2)
					{
						var daywise = $("#doc-sub-datepicker20").val();
						var datewise1 = $("#doc-sub-datepicker21").val();
						var datewise2 = $("#doc-sub-datepicker23").val();
						var camp = $('#campus').val();
						var htype=$('#htype').val();
						if (selectby == 'Between' && (datewise1=="" || datewise2=="") )
						{alert("Please select All  Options "); return false;}
						else if (selectby == 'Datewise' && (daywise==""))
						{alert("Please select All  Options ");return false;}
						else 
						{
							$("#loader1").html('<div class="loader"></div>');
							type='POST',url='<?= base_url() ?>Guesthouse/get_guesthouse_report';
							datastring={'report':report,'campus':camp,'selectby':selectby,'daywise':daywise,'fdate':datewise1,'tdate':datewise2,'act':'view'};
							html_content=ajaxcall(type,url,datastring);
							$("#rowdata").css('display','');
							$("#reportdata").html(html_content);
							$("#loader1").html("");
							
						}
					}
					else if(report==4)
					{
						var vname = $("#vname").val();
						var vmobile = $("#vmobile").val();
						$("#loader1").html('<div class="loader"></div>');
						type='POST',url='<?= base_url() ?>Guesthouse/get_guesthouse_report';
						datastring={'report':report,'vname':vname,'vmobile':vmobile,'act':'view'};
						html_content=ajaxcall(type,url,datastring);
						$("#rowdata").css('display','');
						$("#reportdata").html(html_content);
						$("#loader1").html("");
					}
					else if(report=5)
					{
						var gtype = $("#gtype").val();
						$("#loader1").html('<div class="loader"></div>');
						type='POST',url='<?= base_url() ?>Guesthouse/get_guesthouse_report';
						datastring={'report':report,'gtype':gtype,'act':'view'};
						html_content=ajaxcall(type,url,datastring);
						$("#rowdata").css('display','');
						$("#reportdata").html(html_content);
						$("#loader1").html("");
					}
				}
                     
                  
        });
	
});

function common_call()
{
	var campus=$('#campus').val();
	var gtype=$('#gtype').val();
	var nperson=$('#nperson').val();
	var fdate=$('#doc-sub-datepicker21').val();
	var tdate=$('#doc-sub-datepicker22').val();

	type='POST',url='<?= base_url() ?>Guesthouse/get_ghouse_list_by_creteria';
	datastring={campus:campus,gtype:gtype,nperson:nperson,cin:fdate,cout:tdate};
	html_content=ajaxcall(type,url,datastring);
	display_content(html_content);		
}

function display_content(html_content)
{
	var content='';
	var content1='';
	if(html_content === "{\"ghouse_list\":[]}")
	{
		$('#tableinfo').hide();
		$('#pdf').hide();
		$('#excel').hide();
		$('#err_msg1').html('Records Not Found Please change search criteria and try again');
	}
	else
	{
		$('#err_msg1').html('');
		$('#pdf').show();
		$('#excel').show();
		var array=JSON.parse(html_content);
		len=array.ghouse_list.length;
		//alert(len+"==="+html);
		var j=1;
		for(i=0;i<len;i++)
		{
			content+='<tr><td>'+j+'</td><td>Logo</td><td>'+array.ghouse_list[i].guesthouse_name+'('+array.ghouse_list[i].campus+'), '+array.ghouse_list[i].guesthouse_type+' type, '+array.ghouse_list[i].location+'</td><td>Available ('+array.ghouse_list[i].bed_available+')</td>';
			j++;
		}
		$('#itemContainer1').html(content);
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
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Masters</a></li>
        <li class="active"><a href="<?=base_url($currentModule)?>">Guest House</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-5 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp; Guest House Report</h1>
			
        </div>

        <div class="row ">
            <div class="col-sm-12">
               <div class="panel">
             	<div class="panel-heading">
                    <div class="row">
                           <div class="col-sm-2">
						<select id="report" name="report" class="form-control" >
								  <option value="">Select Report By</option>
								  <option value="1">Booked GuestHouse</option>
								  <option value="2">Check Visitors</option>
								 <!-- <option value="3">Check Visitor Room</option>-->
								  <option value="4">Visitors History</option>
								  <option value="5">GuestHouse History</option>
								  
						</select>
						</div>
                         <?php // print_r($_SESSION);
$rolid = $this->session->userdata("role_id");
if($rolid=='6'){
                    ?>
                           <div class="col-sm-2" >
						<select id="campus" name="campus" class="form-control" >
								  <option value="">Select Campus</option>
								  <option value="NASHIK">Nashik</option>
								  <option value="SIJOUL">Sijoul</option>
						</select>
						</div>
                       
                        
						<?php } ?>
                         <div class="col-sm-2" >
							<select id="htype" name="htype" class="form-control" >
									  <option value="">Select Guest House Type</option>
									  <option value="H">Hostel</option>
									  <option value="T">Trustee Office</option>
							</select>
						</div>
						<div id="single">
						<div class="col-sm-2">
							<select class="form-control" name="selectby" id="selectby">
								<option value="">Select Frequency</option>
								<option value="Datewise">Day wise</option>
								<option value="Between">Dates wise</option>
							</select>
							
							
							<select id="gtype" name="gtype" class="form-control" style="display:none;">
									  <option value="">Select Guest House</option>
									  <option value="All">All</option>
									  <?php 
									if(!empty($guesthouse_details)){
										foreach($guesthouse_details as $gh){
											?>
										  <option value="<?=$gh['gh_id']?>"><?=$gh['guesthouse_name']?></option>  
										<?php 
											
										}
									}
							  ?>
							</select>
							</div>
						</div>
						
						<div id="vhistory" style="display:none;">
							<div class="col-sm-2">
							<input type="text" class="form-control" placeholder="Visitor Name" id="vname" name="vname" required />
							</div>
							<label class="col-sm-1" align="center">OR</label>
							<div class="col-sm-2">
							<input type="text" class="form-control" placeholder="Visitor Mobile" id="vmobile" name="vmobile" required />
							</div>
							</div>
						
						<div id="datewise" style="display:none;">
						<!--<label class="col-sm-1">Date: <?=$astrik?></label>-->
							<div class="col-sm-2">
							<input type="text" class="form-control" id="doc-sub-datepicker20" name="date" required readonly="true"/>
							</div>
						</div>
						
						<div id="between" style="display:none;">
							<label class="col-sm-1">From:</label>
							<div class="col-sm-2" style="padding-left:0px;">
							  <input type="text" class="form-control" id="doc-sub-datepicker21" name="fdate" required readonly="true"/>
							</div>
							<label class="col-sm-1">To:</label>
						
							<div class="col-sm-2" style="padding-left:0px;">
							  <input type="text" class="form-control" id="doc-sub-datepicker23" name="tdate" required readonly="true"/>
							</div>
						</div>
							
						
							<div class="col-sm-2">
							<button class="btn btn-primary form-control" id="btnView" type="submit" >Submit</button>
							</div>
                    </div>
					
                </div>	

                </div>
            </div>
			
            </div>    
        </div>
		<h4 id="flash-messages" style="color:Green;padding-left:250px;">
		<?php if(!empty($this->session->flashdata('message1'))){ echo $this->session->flashdata('message1'); } ?></h4>
		<h4 id="flash-messages" style="color:red;padding-left:250px;">
		<?php if(!empty($this->session->flashdata('message2'))){ echo $this->session->flashdata('message2'); } ?></h4>
		<center><div id="loader1"></div></center>
                <div class="row" id="reportdata">
					
				</div> 
    </div>
</div>

