
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
		//alert('hh');
			  <?php // print_r($_SESSION);
$rolid = $this->session->userdata("role_id");
if($rolid=='6'){
                    ?>
		var camp =$('#campus').val();
		<?php }else{ ?>
var camp = '';
			<?php } ?>
		var htyp=$('#gtype').val();
		var hostlit = $('#hoslist').val();
		var selectby = $("#selectby").val();
		var report=$('#report').val();
		var daywise = $("#doc-sub-datepicker20").val();
						var datewise1 = $("#doc-sub-datepicker21").val();
						var datewise2 = $("#doc-sub-datepicker23").val();
						
            if(report==""){
			alert("Please Select Report");
			return false;
			}else if(selectby==""){
			alert("Please Select Report");
			return false;
			}else{
			
				
						
							$("#loader1").html('<div class="loader"></div>');
							type='POST',url='<?= base_url() ?>Guesthouse/get_guesthouse_report_list';
							datastring={'report':report,'campus':camp,'htyp':htyp,'hostlit':hostlit,'selectby':selectby,'daywise':daywise,'fdate':datewise1,'tdate':datewise2};
							html_content=ajaxcall(type,url,datastring);
							$("#rowdata").css('display','');
							$("#reportdata").html(html_content);
							$("#loader1").html("");
							
						
                     
			}     
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
            <h1 class="col-xs-12 "><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp; Guest House Report</h1>
			
        </div>
</div>
        <div class="row ">
            <div class="col-sm-12">
               <div class="panel">
             	<div class="panel-heading">
                    <div class="row">
                           
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
						<div class="col-sm-2" style="padding-left:0px;">
							<select id="gtype" name="gtype" class="form-control" >
									  <option value="">Select Guest House Type</option>
									  <option value="H">Hostel</option>
									  <option value="T">Trustee Office</option>
							</select>
						</div>
                        <div class="col-sm-1" style="padding-left:0px;width:10.50%;">
							<select id="hoslist" name="hoslist" class="form-control" >
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
						 <div class="col-sm-1" style="padding-left:0px;width:10.50%;">
							<select id="report" name="report" class="form-control" >
									  <option value="">Select Report</option>
                                      <option value="1">List</option>
									  <option value="2">Count</option>
									
							</select>
						</div>
						<div id="single">
						<div class="col-sm-2">
							<select class="form-control" name="selectby" id="selectby">
								<option value="">Select Frequency</option>
								<option value="Datewise">Day wise</option>
								<option value="Between">Dates wise</option>
							</select>	
							
						
							</div>
						</div>
						
						
						
						<div id="datewise" style="display:none;">
						<!--<label class="col-sm-1">Date: <?=$astrik?></label>-->
							<div class="col-sm-2">
							<input type="text" class="form-control" id="doc-sub-datepicker20" name="date" required readonly="true"/>
							</div>
						</div>
						
						<div id="between" style="display:none;">
							
							<div class="col-sm-2" style="padding-left:0px;width:10.50%;">
							  <input type="text" class="form-control" id="doc-sub-datepicker21" name="fdate" required readonly="true"/>
							</div>
							
						
							<div class="col-sm-2" style="padding-left:0px;width:10.50%;">
							  <input type="text" class="form-control" id="doc-sub-datepicker23" name="tdate" required readonly="true"/>
							</div>
						</div>
							
						
							<div class="col-sm-1">
							<button class="btn btn-primary form-control" id="btnView" type="submit" >Submit</button>
							</div>
                    </div>
					
                </div>	

                </div>
            </div>
			
            </div>    
        
		
		<center><div id="loader1"></div></center>
                <div class="row" id="reportdata">
					
				</div> 
    </div>

</div>
<script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.colVis.min.js"></script>
