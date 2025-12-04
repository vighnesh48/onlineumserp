<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<script>
$(function() {
// setTimeout() function will be fired after page is loaded
// it will wait for 5 sec. and then will fire
		setTimeout(function() {
			$(".hide-it").hide();
		}, 3000);
});
function cancellation(id)
{
	if (confirm("Are you sure,Do you want to cancel this Guesthouse?")) 
	{
		$.ajax({
			'url' : base_url + 'Guesthouse/cancellation',
			'type' : 'POST', //the way you want to send data to your URL
			'data' : {'visitor_id':id},
			'success' : function(data){ 
				alert(data);
				//$('#err_msg1').html(data);
				window.location.replace(base_url+'Guesthouse/student_list');
			}
		});
	} 
	else 
	{
		//txt = "You pressed Cancel!";
	}
	
}

$(document).ready(function(){
	
	$('#sss').keyup( function() {
    //alert('gg');
       var that = this;
        // affect all table rows on in systems table
        var tableBody = $('.table-bordered tbody');
        var tableRowsClass = $('.table-bordered tbody tr');
        $('.search-sf').remove();
        tableRowsClass.each( function(i, val) {        
            //Lower text for case insensitive
            var rowText = $(val).text().toLowerCase();
            var inputText = $(that).val().toLowerCase();
            if( rowText.indexOf( inputText ) == -1 )
            {
                //hide rows
                tableRowsClass.eq(i).hide();                
            }
            else
            {
                $('.search-sf').remove();
                tableRowsClass.eq(i).show();
            }
        });
        //all tr elements are hidden
        if(tableRowsClass.children(':visible').length == 0)
        {
            tableBody.append('<tr class="search-sf"><td class="text-muted" colspan="8">No records  found.</td></tr>');
        }
    });
	
	var input_data='<option value="">Select No. Of Person</option>';

	for (i=1;i<=10;i++)
	{
		input_data+='<option value="'+i+'"> '+i+'</option>';
	}
	$('#nperson').html(input_data);
	
	$('#status').change(function() {
		common_call();
	});
	
	$('#gtype').change(function() {
		common_call();
	});
	
	$('#nperson').change(function() {
		common_call();
	}); 
	
	$('#doc-sub-datepicker21').on('changeDate', function (e) {
		common_call();
	}); 
			
	$('#doc-sub-datepicker22').on('changeDate', function (e) {
		common_call();
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

function common_call()
{
	var status=$('#status').val();
	var gtype=$('#gtype').val();
	var nperson=$('#nperson').val();
	var fdate=$('#doc-sub-datepicker21').val();
	var tdate=$('#doc-sub-datepicker22').val();

	type='POST',url='<?= base_url() ?>Guesthouse/student_list_by_creteria';
	datastring={status:status,gtype:gtype,nperson:nperson,cin:fdate,cout:tdate};
	html_content=ajaxcall(type,url,datastring);
	display_content(html_content);		
}

function display_content(html_content)
{
	var content='';
	var content1='';
	if(html_content === "{\"student_list\":[]}")
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
		len=array.student_list.length;
		//alert(len+"==="+html);
		var j=1,gen='';
		for(i=0;i<len;i++)
		{
			if(array.student_list[i].gender=='M')
				gen='Male';
			else
				gen='Female';
			
			content+='<tr><td>'+j+'</td><td>'+array.student_list[i].visitor_name+'</td><td>'+gen+'</td><td>'+array.student_list[i].mobile+'</td><td><b>'+array.student_list[i].guesthouse_name+'</b>, '+array.student_list[i].guesthouse_type+' type<b></td><td>'+array.student_list[i].charges+'</td><td>'+array.student_list[i].no_of_person+'</td><td>';
			
			if(array.student_list[i].current_status=='BOOKING-DONE')
				content+='<span style="color:Green" >BOOKING-DONE</span>';
			else if(array.student_list[i].current_status=='CANCELLED')
				content+= '<span style="color:red" >CANCELLED</span>';
			else 
				content+= '<span style="color:#1d89cf" >'+array.student_list[i].current_status+'</span>';
			
			content+='</td><td>';
			
			if(array.student_list[i].current_status=='BOOKING-DONE')
			{
				content+='<a title="Edit Booking Details" class="btn btn-primary btn-xs" href="'+base_url+'edit_booking_details/'+array.student_list[i].visitor_id+'">Edit</a><a title="Cancel Booking Details" class="btn btn-primary btn-xs" onclick="cancellation('+array.student_list[i].visitor_id+')" >Cancellation</a>';
			}
			content+='</td></tr>';
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
        <li class="active"><a href="<?=base_url($currentModule)?>">Competitive Exam</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-5 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp; Student List</h1>
			<div class="pull-right col-xs-4 col-sm-auto"><a style="width: 100%;" class="btn btn-primary btn-labeled" href="<?=base_url($currentModule."/registration_form")?>"><span class="btn-label icon fa fa-plus"></span>Add </a></div>
        </div>

        <div class="row ">
            <div class="col-sm-12">
               <div class="panel">
             	<div class="panel-heading">
                    <div class="row">
                          
								
								<div class="col-sm-3 pull-right">
									<input type="text" class="form-control" name="sss" id="sss" placeholder="Search">                                     
								</div>
						<label class="col-sm-1 pull-right">Search:</label>
						<!--<div class="col-sm-2" style="padding-left:0px;">
							<select id="gtype" name="gtype" class="form-control" >
									  <option value="">Select Guest House</option>
									  <?php 
									/* if(!empty($guesthouse_details)){
										foreach($guesthouse_details as $gh){
											?>
										  <option value="<?=$gh['gh_id']?>"><?=$gh['guesthouse_name']?></option>  
										<?php 
											
										}
									} */
							  ?>
							</select>
						</div>
						
							<div class="col-sm-2" style="padding-left:0px;">
							  <input type="text" class="form-control" placeholder="CheckIn Date" id="doc-sub-datepicker21" name="fdate"  readonly="true"/>
							</div>
							
						
							<div class="col-sm-2" style="padding-left:0px;">
							  <input type="text" class="form-control" placeholder="CheckOut Date" id="doc-sub-datepicker22" name="tdate"  readonly="true"/>
							</div>
							<div class="col-sm-2" style="padding-left:0px;">
						<select id="nperson" name="nperson" class="form-control" >
								  
								 
						</select>
						</div>
						
						-->	
                    </div>
					
                </div>
				<div class="panel-body" >
                <h4 class='hide-it' id="flash-messages" style="color:Green;padding-left:250px;">
				<?php if(!empty($this->session->flashdata('message1'))){ echo $this->session->flashdata('message1'); } ?></h4>
				<h4 class='hide-it' id="flash-messages" style="color:red;padding-left:250px;">
				<?php if(!empty($this->session->flashdata('message2'))){ echo $this->session->flashdata('message2'); } ?></h4>
                 <?php
				if(!empty($student_list))
				{ 
					?>   <div class="table-info table-responsive" id="tableinfo" >    
                    
                    <table class="table table-bordered" style="width:100%;max-width:100%;">
                        <thead>
						<tr>
                                    <th>#</th>
									<th>Reg No</th>
									<th>Name</th>
									<th>Gender</th>
                                    <th>Mobile</th>
									<!--<th>Parent Mobile</th>-->
									<th>Entrance Type</th>
									<th>Applicable fees</th>
									<!--<th>ComeToKnow About SU</th>-->
									<?php
									if($_SESSION['role_id']==2)
									{
										?>
									<th>Action</th>
									<?php
									}
									
									?>
									<?php
									if($_SESSION['role_id']==5)
									{
										?>
									<th>Make Payment</th>
									<?php
									}
									
									?>
									<!--<th>mobile</th>
									<th>mobile</th>-->
                                    
                            </tr>
                        </thead>
                        <tbody id="itemContainer1">
                              <?php
							  
                            $j=1;                      
                            for($i=0;$i<count($student_list);$i++)
                            {
								?>
								<tr>
									<td><?=$j?></td>
									<td><?=$student_list[$i]['reg_no']?></td>
									<td><?=$student_list[$i]['student_name']?></td>	
									<td><?=$student_list[$i]['gender']=='M'?'Male':'Female'?></td>
									<td><?=$student_list[$i]['student_mobileno']?></td>			
									<!--<td><?=$student_list[$i]['parent_mobileno']?></td>-->
									<td><?=$student_list[$i]['entrance_type']?></td>
									<td><?=$student_list[$i]['applicable_fees']?></td>
									<!--<td><?=$student_list[$i]['come_toknow']?>
									</td>-->
									<?php
									if($_SESSION['role_id']==2)
									{
										?>
									<td>
									<a title="Edit Student Details" class="btn btn-primary btn-xs" href="<?=base_url($currentModule."/edit_student/".$student_list[$i]['stud_id'])?>">Edit</a>
									</td>
									<?php
									}
									if($_SESSION['role_id']==5)
									{
										?>
									<td>
									<a title="View Student Fee Details" class="btn btn-primary btn-xs" href="<?=base_url($currentModule."/view_std_payment/".$student_list[$i]['stud_id'])?>" target="_blank">Fee Details</a>
									</td>
									<?php
									}
									
									?>
								</tr>
								<?php
								$j++;
                            }
                            ?>                           
                        </tbody>
                    </table>                    
                  
                </div>
				<?php
				}else{
					?>
					<h4 style="color:red;padding-left:200px;">Students Have Not Registered Yet</h4>
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

