<?php
include 'header.php';
?>
<style>
.act1{
    background:#a9a9a9!important;
}
</style>
<body>
<div id="wrapper" class="xtoggled">
  <div class="container-fluid"> 
    <!-- Sidebar -->
<?php include 'sidebar_menu.php';?>
    <!-- /#sidebar-wrapper --> 
    
    <!-- Page Content -->
    <div id="page-content-wrapper">
      <div class="container-fluid">
        <?php include 'topheader.php';?>
        <div class="row form-container">
          <div class="col-lg-12"> 
            <!-- tabs -->
            <div class="tabbable">
              <ul class="nav nav-tabs">
                <?php
                   $lognType = $this->session->userdata('login_type');
                    if($lognType=='admin' || $lognType=='suadmin'){
                  ?>
                <li  id='tab1'><a href="<?=base_url()?>admin/admission_confirm" class="act1">Admission List </a></li>
                <li id='tab2'><a href="<?=base_url()?>admin/in_house_studlist" class=""> Walik-In Student List</a></li>
                <li  id='tab1'><a href="<?=base_url()?>admin" >Online Student List </a></li>
                 <?php 
                    }else{
                ?>
                <li id='tab2'><a href="<?=base_url()?>admin/in_house_studlist" class=""> Walik-In Student List</a></li>
                <li id='tab2'><a href="<?=base_url()?>admin/admission_confirm" class="act1"> Admission List</a></li>
                <?php }?>
              </ul>
              <div class="tab-content form-tab">
			  
			  
                    <form class="form-horizontal detail-form" id="personalinfo" method="POST" action="<?=base_url()?>admin/admission_confirm">
					<div class="row">
					<div class="col-lg-6">
                    <div class="form-group">
                      <label class="control-label col-sm-3" for="email">Form No*</label>
                      <div class="col-sm-9 input-group"> 
                         <input type="text" class="form-control required" id="form_no" name="form_no" placeholder="Enter Form No" value="<?php if(!empty($per[0]['receipt_no'])){ echo $per[0]['receipt_no'];}?>">
                      </div>
                    </div>

                    </div>
					
					
					<div class="col-lg-6">
					<div class="form-group">

					  <button type="submit" class="btn btn-danger pull-left adm-btn" style="margin-left:50px;">Search</button>
                    </div>

					</div>
					</div>
                  </form>
				
               <div class="table-info">    

                    <table class="table table-bordered table-bg">
                        <thead>
                            <tr>
                                    <th>Sr.No</th>
                                    <th>Date</th>
                                    <th>Form No</th>
                                    <th>Name</th>
                                    <th>Mobile</th>
                                    <th>Parent Mobile</th>
                                    <th>City</th>
									<th>Year</th>
                                    <th>Course Applied</th>
                                    <th>Entry By</th>
									<th>Admission Status </th>
									<th>View </th>
									<th>Edit </th>
									
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
						<?php 
						$srNo=1;
						if(!empty($stud)){
							foreach($stud as $val){
							    $adm_date = date('d/m/Y',strtotime($val['entry_on']));
						?>
                            <tr style="display: table-row; opacity: 1;">
								<td><?=$srNo?></td>   
								<td><?=$adm_date?></td>
                                <td><?=$val['form_no']?></td>                                                                
                                <td><?=$val['student_name']?></td>
                                   
                                <td><?=$val['mobile']?></td>
                                <td><?=$val['parent_mobile']?></td>
                                <td><?=$val['district_name']?></td>
								<td><?=$val['stream_year']?></td>
								<td><?=$val['stream_name']?></td>
                               <td>
								    
								<?php
								if($val['login_type']!='' && $val['login_type']=='ic'){
									echo 'IC- '.$val['ic_city'];
								}elseif($val['username']==''){
								    echo 'Student';
								}
								else{ 
									echo $val['username'];
								}
								?>
								</td>
								<td><?php
							
								if($val['seat_conform']=='Prov Confirm' || $val['seat_conform']=='Confirm'){
									?>
									<button class="btn btn-success btn-xs"><?=$val['seat_conform']?></button>
									<?php 
								}elseif($val['seat_conform']=='Rejected'){ ?>
								    <button class="btn btn-danger btn-xs" ><?=$val['seat_conform']?></button>
								<?php }else{?>
								    <button class="btn btn-primary btn-xs" >In-Process</button>
									
								<?php }?>
								</td> 
								<td><a href="<?=base_url()?>home/view_form/<?=$val['stud_id']?>" target="_blank">View</a></td>
								<td><a href="<?=base_url()?>home/index/<?=$val['stud_id']?>" target="_blank"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>
                            </tr>
							<?php 
							$srNo++;
							}
						}else{
							echo "<tr>";
							echo "<td colspan='10'>";
							
							echo "No data found.";
							echo "</td>";
							echo "</tr>";
						}
							?>
                            
                                                        
                        </tbody>
                    </table>                    
                </div>
              </div>
            </div>
            <!-- /tabs --> 
          </div>
        </div>
      </div>
    </div>
    <!-- /#page-content-wrapper --> 
  </div>
</div>
<!-- /#wrapper --> 
<!-- Modal -->
<div class="modal fade" id="walkinModal" tabindex="-1" role="dialog" 
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                
                <h4 class="modal-title" id="myModalLabel">
                   <span id="fform_id"></span>
                </h4>
            </div>
            
            <!-- Modal Body -->
            <div class="modal-body">
                <div class="row">
                            <div class="col-sm-12">
                                <div class="panel panel-default panel-hovered panel-stacked" style="margin-top: 10px;">
                                    <div class="panel-body">
                                        <form role="form" method="post" action="<?=base_url()?>admin/updateWalkinStatus">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Update Walk-In Status</label><br>
                                              <input type="radio" name="walk_in_status" class="seat_confirm" value="Interested" required/> &nbsp;Interested &nbsp;
                                              <input type="radio" name="walk_in_status" class="seat_confirm" value="Not-Interested" required/> &nbsp;Not-Interested &nbsp;
                                              
                                              <input type="hidden" name="stud_id" class="form-control" id="fstud_id" style="width:50%"/>
                                          </div>    
                                          <button type="submit" class="btn btn-primary">Submit</button>
                                          <button type="button" class="btn btn-default"
                                                data-dismiss="modal">
                                                    Close
                                        </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                
            </div>
            
            <!-- Modal Footer 
            <div class="modal-footer">
                <button type="button" class="btn btn-default"
                        data-dismiss="modal">
                            Close
                </button>
                <button type="button" class="btn btn-primary">
                    Save changes
                </button>
            </div>-->
        </div>
    </div>
</div>
<!--Bootstrap core JavaScript--> 
<?php include('footer.php');?>

<script>
$(document).ready(function() {
	$("#tab2").addClass("active");
	$("#tab1").removeClass("active");
	$("#tab2").removeClass("active");
});
</script>

<script>
 $(document).ready(function() {
	 
    $('#basicform').bootstrapValidator({
        // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            sname: {
                validators: {
                        stringLength: {
                        min: 2,
                    },
                        notEmpty: {
                        message: 'Please supply your Full name'
                    }
                }
            },
            email: {
                validators: {
                    notEmpty: {
                        message: 'Please supply your email address'
                    },
                    emailAddress: {
                        message: 'Please supply a valid email address'
                    }
                }
            },
            smobile: {
                validators: {
                     notEmpty:
                                                                {
                                                                    message: 'Mobile number should not be empty'
                                                                },
                                                        regexp:
                                                                {
                                                                    regexp: /^[0-9/]+$/,
                                                                    message: 'Mobile number should be numeric'
                                                                },
                                                        stringLength:
                                                                {
                                                                    max: 12,
                                                                    min: 10,
                                                                    message: 'Mobile number should be 10-12 characters.'
                                                                }

                }
            }      
           
  
            }
        });
        
});

$(".marksat").each(function () {

    $(document).on("click", '#' + this.id, function () {
        var stud_id = $('#' + this.id).attr("data-stud_id");
        var form_id = $('#' + this.id).attr("data-form_no");
       // alert(form_id);
        document.getElementById("fstud_id").value = stud_id;
        $('#fform_id').html(form_id);
       // document.getElementById("fform_id").html();

    });
});

</script>
</body>
</html>