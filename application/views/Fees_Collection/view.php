<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<script src="<?=base_url('assets/javascripts')?>/jquery.table2excel.js"></script>

<!--script type="text/javascript" src="www.sandipuniversity.com/assets/js/export/tableExport.js"></script>
<script type="text/javascript" src="www.sandipuniversity.com/assets/js/export/jquery.base64.js"></script-->
<script>
	$(document).ready(function(){

	$("#college_name").change(function(){
		var post_data = $(this).val();		
	$.ajax({
				type: "POST",
				url: "<?=base_url().strtolower($currentModule)?>/get_course_name/"+post_data,
				
				success: function(data){
					//alert(data);          
            $('#course_name').html(data);
         
				}	
			});
	});
	
	$("#course_name").change(function(){
		var post_data = $('#college_name').val()+'/'+$(this).val();		
	$.ajax({
				type: "POST",
				url: "<?=base_url().strtolower($currentModule)?>/get_branch_name/"+post_data,
				
				success: function(data){
					//alert(data);          
            $('#branch_name').html(data);
         
				}	
			});
	});
});
</script>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Masters</a></li>
        <li class="active"><a href="#">Fees Collection Master</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Fees Collection</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                    <?php //if(in_array("Add", $my_privileges)) { ?>
                       
               
                    <div class="pull-right col-xs-12 col-sm-auto"><a style="width: 100%;" class="btn btn-primary btn-labeled" href="<?=base_url($currentModule."/add")?>"><span class="btn-label icon fa fa-plus"></span>Add Fees</a></div>                        
                    <div class="visible-xs clearfix form-group-margin"></div>
                    <?php // } ?>
                    <?php //if(in_array("Search", $my_privileges)) { ?>
                  
                    <?php //} ?>
                </div>
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
                        <div class="col-sm-2">                            
                            <select id="college_name" name="college_name" class="form-control">
                                           <option value="">Select College</option>
										   <?php foreach($college_details as $val){
											    echo '<option value="'.$val['college_name'].'">'.$val['college_name'].'</option>';
										   }
										   ?>
                                        </select>
							
							</div>
							<div class="col-sm-2">                            
                            <select id="course_name" name="course_name" class="form-control">
                                           <option value="">Select Course</option>										   
                                        </select>
							
							</div>
							<div class="col-sm-2">                            
                            <select id="branch_name" name="branch_name" class="form-control">
                                           <option value="">Select Branch </option>										  
                                        </select>							
							</div>
							<div class="col-sm-2">                            
                            <select id="year" name="year" class="form-control">
                                           <option value="">Select Year </option>
                                            <option value="1">First Year </option>	
                                             <option value="2">Second Year </option>
                                              <option value="3">Third Year </option>
                                               <option value="4">Fourth Year </option>
                                        </select>							
							</div>
							<div class="col-sm-2">                            
								<input type="text" name="srch_date" id="srch_date" class="form-control" placeholder="Search by Date">							
							</div>
							 <div class="col-sm-2">
							
                                        <button class="btn btn-primary form-control" id="searchbtn" type="button" > <i class="fa fa-search"></i>&nbsp;Search</button>                                        
                            </div>   
                    
						</div>
                </div><div class="clearfix"></div>
                <div class="panel-body">
                    <div class="table-info table-responsive">    
                    <?php //if(in_array("View", $my_privileges)) { ?>
                    <table class="table table-bordered table-hover" id="feestable">
                        <thead>
                            
                            <tr>
                                    <th width="5%">S.No</th>
                                    <th width="5%">College</th>
                                    <th width="5%">Course</th>
                                    <th width="10%">Branch</th>
                                    <th width="5%">Year</th>
									<th width="10%">Reg No.</th>
									<th width="20%">Name</th>
									<th width="5%">Receipt</th>
									<th width="5%">Date</th>
									<th width="5%">Paid Amt</th>
									<th width="15%">Bank</th>
                                    
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php
							$ci =&get_instance();
   $ci->load->model('fees_model');
                            $j=1;                            
                            for($i=0;$i<count($sdetails);$i++)
                            {
                                
                            ?>
                            <tr>
                                <td><?=$j?></td> 
                                    <td><?=$sdetails[$i]['college_code']?></td>
                               <?php 
                                 $col = $this->session->userdata('name');
		$ex = explode("_",$col);
		
		if($ex[0]=='sf'){ 
		    $cn = $ci->fees_model->get_su_course_name($sdetails[$i]['program_id']);
			//print_r($cn);
		  if($sdetails[$i]['college_code'] == 'SU'){?>
                       <td><?=$cn[0]['course_name']?></td>
                                <td><?=$cn[0]['branch_name']?></td>
		    
	<?php }else{ ?>
	    <td><?=$sdetails[$i]['course_name1']?></td>
                                <td><?=$sdetails[$i]['branch_short_name']?></td>
                                <?php
	}	    
		}else{
                               ?>
                            
                       <td><?=$sdetails[$i]['course_name1']?></td>
                                <td><?=$sdetails[$i]['branch_short_name']?></td>
                                <?php } ?>
								<td><?php echo $sdetails[$i]['course_year1']; ?></td>
								<td><?=$sdetails[$i]['reg_no']?></td>
								<td><?=$sdetails[$i]['name']?></td>
								<td><?=$sdetails[$i]['receipt_no']?></td>
								<td><?=$sdetails[$i]['paid_date']?></td>
								<td><?=$sdetails[$i]['amount']?></td>
                                <td><?=$sdetails[$i]['bankname']?></td>
                            </tr>
                            <?php
                            $j++;
                            }
                            ?>                            
                        </tbody>
                    </table> 
                     <div class="col-md-10">
                         <div class="holder pull"> </div>
                     </div>
                    <div class="col-md-2">
                        	<button id="exp" class="btn btn-primary pull-left" >Export to Excel</button>	
                     </div>
                                 
                        
				
                    <?php //} ?>
                </div>
                </div>
            </div>
            </div>    
        </div>
    </div>
</div>
<script>
			$("#exp").click(function(){
				$("#feestable").table2excel({
					exclude: ".noExl",
					name: "Excel Document Name",
					filename: "Fees_Details",
					type: ".xls",
					exclude_img: true,
					exclude_links: true,
					exclude_inputs: true
				});
			});
		</script>
<script>
$(document).ready(function(){
	$("#srch_date").datepicker({       
        autoclose: true,
		format: 'yyyy-mm-dd',
		todayHighlight: true		
    });
});	
	
  $("div.holder").jPages
  ({
    containerID : "itemContainer"
  });
  $("#search_me").select2({
      placeholder: "Enter title",
      allowClear: true
    });
        $("#searchbtn").on('click',function()
        {
            var coll_val = $('#college_name').val();  
			var crs_val = $('#course_name').val();
			var brn_val = $('#branch_name').val();
			var year_val = $('#year').val();
			var srch_date = $('#srch_date').val();
			
			
            var url  = "<?=base_url().strtolower($currentModule).'/search/'?>";	
            var data = {colg: coll_val,crn:crs_val,brn:brn_val,year:year_val,srchdate:srch_date};		
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
                   
                        $("#itemContainer").html(data);
                    
                },
                error: function(data)
                {
                    alert("Page Or Folder Not Created..!!");
                }
            });
        });
</script>