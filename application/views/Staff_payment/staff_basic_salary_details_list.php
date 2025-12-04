<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<?php// print_r($all_emp_basicsal);?>
<style>
.view-btn{padding:0px;}
.view-btn i{padding: 3px 0;list-style:none;width:35px;text-align: center;color:#fff;background:#4bb1d0;xpadding: 5px 10px;margin:2px;}
.view-btn i a{color:#fff;font-weight:bold;}
</style>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Staff Payment</a></li>
        <li class="active"><a href="#">Salary Structure Details</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Salary Structure Details </h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                    <?php //if(in_array("Add", $my_privileges)) { ?>
                     <div class="visible-xs clearfix form-group-margin"></div>
                    <?php// } ?>
                    
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
                   <h4><b>Employee List</b></h4>    
                        
                </div>
                <div class="panel-body" style="height: 1000px;overflow-y: scroll;">
                    <div class="table-info" style="width:100% !important;"> 
                    <?php if(in_array("Show Report",$my_privileges)){ ?>
                    <div class="col-md-2 ">
                            <a href="<?=base_url($currentModule.'/staff_master_export')?>" ><button type="button" class="btn btn-primary form-control" >Excel
                                    </button></a>       
                                    </div>   
                                    <br/>               
                    <?php } ?>   
                    <br/>
					
						 <?php 
     if(isset($_SESSION['status']))
    {
        ?>
			<script>
			var status="<?php echo $_SESSION['status'] ?>";
			 alert(status);
			</script>
        <?php 
        unset($_SESSION['status']);
       }
   ?>								
                    <?php //if(in_array("View", $my_privileges)) { ?>
                    <table class="table table-bordered" style="width:100% !important;">
                        <thead>
                            <tr>
                                    <th>#</th>
                                    <th>Emp.ID</th>
                                    <th>Emp. Name</th>
                                    <th style="display:none;">School/Dept/Designation</th>   
<th>Staff Type</th>
<th>Joining Date</th>
<th>Scale Type</th>									
                                   
                                    <th>Gross Salary</th>
                                    
                                    <th>Action</th>
									
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php //print_r($all_emp_basicsal);
							if(!empty($all_emp_basicsal)){
                            $j=1;                            
                            for($i=0;$i<count($all_emp_basicsal);$i++)
                            {
                                
                            ?>
							 <?php if($all_emp_basicsal[$i]['ro_flag']=='on') $bg="bgcolor='#e6eaf2'";
								  else $bg="";?>								
                            <tr <?=$bg?> <?=$all_emp_basicsal[$i]["status"]=="N"?"style='background-color:#FBEFF2'":""?>>
                                <td><?=$j?></td> 
                                 
                                <td><?=$all_emp_basicsal[$i]['em_emp_id']?></td> 
                                
                                <td id="empn_<?=$all_emp_basicsal[$i]['em_emp_id']?>"><?php if($all_emp_basicsal[$i]['gender']=='male'){echo 'Mr.';}else if($all_emp_basicsal[$i]['gender']=='female'){ echo 'Mrs.';} ?><?=ucfirst($all_emp_basicsal[$i]['fname'])." ".ucfirst($all_emp_basicsal[$i]['lname']);?></td>                                                                
                                <td style="display:none;" ><p>School: <span id="emps_<?=$all_emp_basicsal[$i]['em_emp_id']?>"><strong><?=$all_emp_basicsal[$i]['college_name']?></strong></span></p>
                                    <p >Department: <span id="empd_<?=$all_emp_basicsal[$i]['em_emp_id']?>"><strong><?=$all_emp_basicsal[$i]['department_name']?></strong></span></p>
                                    <p >Designation: <span id="empde_<?=$all_emp_basicsal[$i]['em_emp_id']?>"><strong><?=$all_emp_basicsal[$i]['designation_name']?></strong></span></p>
								    <p >Pay Band: <span id="emppayb_<?=$all_emp_basicsal[$i]['em_emp_id']?>"><strong><?php echo $all_emp_basicsal[$i]['pay_band_min']; if(!empty($all_emp_basicsal[$i]['pay_band_min'])&&!empty($all_emp_basicsal[$i]['pay_band_max'])&&!empty($all_emp_basicsal[$i]['pay_band_gt']))echo $all_emp_basicsal[$i]['pay_band_min']."-".$all_emp_basicsal[$i]['pay_band_max']."+AGP ".$all_emp_basicsal[$i]['pay_band_gt'];else echo "NA"; ?></span></p>
								</td>                                
                                      <td><?php if($all_emp_basicsal[$i]['staff_type']==1){echo 'Technical';}elseif($all_emp_basicsal[$i]['staff_type']==2){echo 'Non-Technical';}elseif($all_emp_basicsal[$i]['staff_type']==3){echo 'Teaching';}?></td> 
							     
										  <td id="empj_<?=$all_emp_basicsal[$i]['em_emp_id']?>"><?=date('d-m-Y',strtotime($all_emp_basicsal[$i]['joiningDate']));?></td>										  
                                 <td><?=$all_emp_basicsal[$i]['scaletype1'];?></td>

									 <td><?=$all_emp_basicsal[$i]['gross_salary'];?></td>                                
                                                
                                                                                
                                <td class="view-btn">
                                <?php if(in_array("Edit",$my_privileges)){  //sal_structure_id?>
								<a href="<?=base_url($currentModule.'/staff_basic_salarydetails/'.$all_emp_basicsal[$i]['em_emp_id'].'')?>" title="Edit"><i class="fa fa-edit"></i></a>
								<?php } ?>
                                <a href="#" class=" emp_view" id="<?=$all_emp_basicsal[$i]['em_emp_id']?>" data-toggle="modal"  data-target="#myModal"><i class="fa fa-eye"></i></a>
								<?php if(in_array("Edit",$my_privileges)){ ?>
								<a href="javascript:void(0)" class="emp_view "  onClick="if(confirm('Are you sure you want to perform  this action')){del_product(<?=$all_emp_basicsal[$i]['sal_structure_id']?>);}else{ }" >
								<?php
								  if($all_emp_basicsal[$i]['active_status']=='Y'){
									  echo "Inactive ??";
								  }
								  else{
									  echo "Activate ??";
								  }
								?>
								</a>
							 	<?php } ?>							</td>
                            </tr>
                            <?php
                            $j++;
                            }}else{
								echo"<tr><td colspan='19'><label style='color:red'>Sorry No record of Employee's Assigned for Basic Salary Details.</label></td></tr>";
							}
                            ?>                            
                        </tbody>
                    </table>  

                </div>
                </div>
            </div>
            </div>    
        </div>
    </div>
</div>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width:80%;">

    <!-- Modal content-->
    <div class="modal-content" >
       <div class="modal-header">
        <button type="button" class="btn btn-default pull-right" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" >Emp Id: <strong><span id="empid"></span></strong> <span style="margin-left:50px;">Name:</span> <strong><span id="empname"></span></strong>  <span style="margin-left:50px;">Joining Date: </span><strong><span id='joi'></span></strong></h4>
		<h4 class="modal-title" >Pay Band: <strong><span id='payb'></span></strong></h4>
        <h4 class="modal-title" >School : <strong><span id='sch'></span></strong> 
		<span style="margin-left:50px;"> Department : </span><strong><span id='dep'></span></strong> 
		<span style="margin-left:50px;"> Designation : </span><strong><span id='des'></span></strong>
		</h4>
      </div>
      <div class="modal-body" >
	  <div class="row table-responsive">
        <table class="table table-bordered"  >
                        <thead>
                            <tr>
							 <th>#</th>
                                    <th>Basic Salary</th>
                                    
									<th>Pay Band Min</th>
                                    <th>Pay Band Max</th>                                                                  
                                    <th>Pay Band Gt</th>
                                    <th>DA</th>                                                                  
                                    <th>HRA</th>
                                    <th>TA</th>  
									
                                    <th>Income Difference</th>
                                                                                                
                                    <th>Other Income</th>
									<th>Special Allowance</th>                                                             
                                    
									<th>Gross Salary</th>
                                    <th>Date</th>
									<th>Active</td>
                            </tr>
                        </thead>
						<tbody id="emp_cnt">
						
						</tbody>
						</table>
						</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
	</div>
    </div>
<script>
  $("div.holder").jPages
  ({
    containerID : "itemContainer"
  });
   
   function del_product(id){
	     var url  = "<?=base_url().strtolower($currentModule).'/update_status/'?>"+id;	
	   $.ajax
            ({
                type: "POST",
                url: url,
                data: "id="+id,
                dataType: "html",
                cache: false,
                crossDomain: true,
                success: function(data)
                {  
				if(data==1){
					alert("Successfully done");
					location.reload();
				}
				else{
					alert("Something went wrong");
				}
                  
                },
                error: function(data)
                {
                    alert("Page Or Folder Not Created..!!");
                }
            });
   }
   
   
		$(".emp_view").on('click',function()
        {
            var eid = $(this).attr('id');   
            var enam = $('#empn_'+eid).text();
			var edep = $('#empd_'+eid).text();
			var esch = $('#emps_'+eid).text();
			var edepe = $('#empde_'+eid).text();
			var ejoi = $('#empj_'+eid).text();
			var epayb = $('#emppayb_'+eid).text();
            var url  = "<?=base_url().strtolower($currentModule).'/get_emp_history/'?>"+eid;	
         //   var data = {title: search_val};		
         //   var type="";
         //   var type_name="";
            $.ajax
            ({
                type: "POST",
                url: url,
               // data: data,
                dataType: "html",
                cache: false,
                crossDomain: true,
                success: function(data)
                {  
				$("#empid").text(eid);
                   $("#empname").text(enam);
				   $("#sch").text(esch);
				   $("#dep").text(edep);
				   $("#des").text(edepe);
				   $("#joi").text(ejoi);
				     $("#payb").text(epayb);
                        $("#emp_cnt").html(data);
                  
                },
                error: function(data)
                {
                    alert("Page Or Folder Not Created..!!");
                }
            });
        });
</script>