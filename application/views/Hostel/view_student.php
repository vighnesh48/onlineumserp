<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>

<script>

$(document).ready(function()
{
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
	
	var academic='<?=$this->uri->segment(3)?>';
	var campus='<?=$this->uri->segment(4)?>';
	//alert(campus);
	if(academic!="" && campus!="")
	{
		$('#academic option').each(function()
		 {              
			 if($(this).val()== academic)
			{
			$(this).attr('selected','selected');
			}
		});
		$('#campus option').each(function()
		{              
			 if($(this).val()== campus)
			{
			$(this).attr('selected','selected');
			}
		});
		$("#btn_submit").trigger("click");
	}
	   
});


var html_content="",type="",url="",datastring="";
function validation()
{
	var html_content="",type="",url="",datastring="";
	var academic=$('#academic').val();
	var campus=$('#campus').val();
	//alert(faci_id);
	if(academic=="")
	{	
		$('#show_facilities').hide();
		$('#err_msg').html('Please select academic!!');
	}
	else if(campus=="")
	{	
		$('#show_facilities').hide();
		$('#err_msg').html('Please select campus!!');
	}
	else
	{
		$('#err_msg').html('');
		type='POST',url='<?= base_url() ?>Hostel/get_all_sf_students',datastring={academic:academic,campus:campus};
		html_content=ajaxcall(type,url,datastring);
		//alert(html_content);
		if(html_content!="")
		{
			$('#err_msg').html('');
			$('#itemContainer').html(html_content);
			$('#show_list').show();
		}
		else
		{
			$('#itemContainer').html('');
			$('#show_list').hide();
			$('#err_msg').html('No Data');
			//$('#show_facilities').show();
		}
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
        <li class="active"><a href="<?=base_url($currentModule)?>">Hostel </a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;  Student List</h1>
			
			<div class="col-xs-12 col-sm-8">
                <div class="row"> 
					                      
                    <div class="pull-right col-xs-12 col-sm-auto"><a style="width: 100%;" class="btn btn-primary btn-labeled" href="<?=base_url($currentModule."/add_student")?>"><span class="btn-label icon fa fa-plus"></span>Add </a></div>                                       
                </div>
            </div>
			

        </div>

        <div class="row ">
            <div class="col-sm-12">
						
                <div class="panel">
                <div class="panel-heading">
                    <div class="row">
						<div class="col-sm-3">
						  <select class="form-control" name="academic" id="academic" required>
						<option value="">Select Academic Year</option>
						   <?php //echo "state".$state;exit();
						if(!empty($academic_details)){
							foreach($academic_details as $academic){
								$arr=explode("-",$academic['academic_year']);
								$ac_year=$arr[0];
								if($academic['status']=='Y')
								{
								?>
							  <option selected value="<?=$ac_year?>"><?=$academic['academic_year']?></option>  
							<?php 
								}else{
								?>
								<option value="<?=$ac_year?>"><?=$academic['academic_year']?></option> 
								<?php
								}
								
							}
						}
					  ?>
						  </select>
						</div>
						<div class="col-sm-3">
									<select id="campus" name="campus" class="form-control" required>
										<option value="">Select Campus</option>
										
                                      <?php //echo "state".$state;exit();
                                        if(!empty($campus)){
                                            foreach($campus as $campusname){
                                                ?>
                                              <option value="<?=$campusname['campus_name']?>"><?=$campusname['campus_name']?></option>  
                                            <?php 
                                                
                                            }
                                        }
                                      ?>
									</select> 
									<!--<span style="color:red;"><?php echo form_error('campus');?></span>	-->									
								</div>
						
						<div class="col-sm-2">
							<button class="btn btn-primary form-control" onclick="validation()" id="btn_submit" >Submit</button>                                     
						</div>
						<div class="col-sm-3">
							<input type="text" class="form-control" name="sss" id="sss" placeholder="Search">                                     
						</div>
						
					</div>
                </div>
				
				<h4 id="flash-messages" style="color:Green;padding-left:250px;">
				 <?php if(!empty($this->session->flashdata('message1'))){ echo $this->session->flashdata('message1'); } ?></h4>
			<h4 id="flash-messages" style="color:red;padding-left:250px;">
				 <?php if(!empty($this->session->flashdata('message2'))){ echo $this->session->flashdata('message2'); } ?></h4>
			<h4 id="err_msg" style="color:red;padding-left:250px;"></h4>
                <div id="show_list" class="panel-body" style="display:none;overflow-x:scroll;">
                    <div class="table-info">    
                    
                    <table class="table table-bordered" id="example">
                        <thead>
                            <tr>
                                    <th>#</th>
                                    <th>Old PRN</th>
                                    <th>PRN</th>
									<th>Name</th>
									<th>Gender</th>
                                    
									<th>Institute</th>
                                    <th>Stream</th>
								    <th>Current Year</th>
                                    <th>Mobile</th>
                                    <!--<th>Academic</th>-->
                                    <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                                                      
                        </tbody>
                    </table>                    
                   
                </div>
                </div>
            </div>
            </div>    
        </div>
    </div>
</div>