<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<style>
#guide { display: flex; 
       justify-content: center }

</style>
<script>    
    $(document).ready(function()
    {
        $('#form').bootstrapValidator
        ({  
            message: 'This value is not valid',
            group: 'form-group',
            feedbackIcons: 
            {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: 
            {
				   reviewer:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select in Reviewer'
                      }
                    }
                },
				   reviewer_code:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Reviewer Name should not be empty'
                      }
					}
                },
				aff_instiute:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Institute Name should not be empty'
                      },
                    regexp: 
                      {
                        regexp: /^[a-z\s]+$/i,
                        message: 'Institute Name should be alphabate characters and spaces only'
                      },
                       stringLength: 
                        {
                        max: 50,
                        min: 2,
                        message: 'Institute Name should be 2-50 characters.'
                        } 
                    }
                },
				  institute_addr:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Institute Address should not be empty'
                      },
                       stringLength: 
                        {
                        max: 100,
                        min: 2,
                        message: 'Institute Address should be 2-100 characters.'
                        } 
                    }
                },

                	dispatch_date:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select Date'
                      }
                    }
                },				
                tracking_no:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Tracking No should not be empty'
                      },
					  regexp: 
						{
						regexp: /^[a-zA-Z0-9 ]+$/,
						message: 'Tracking No can only consist of alphanumeric characters and spaces'
						},
                       stringLength: 
                        {
                        max: 12,
                        min: 4,
                        message: 'Tracking No should be 4-12 characters.'
                        } 
                    }
                },
				   receipt_date:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select Date'
                      },
                      required: 
                      {
                       message: 'Please select Date'
                      }                    
                    }
                },
            }       
        })
    });
</script>

<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="<?=base_url($currentModule)?>">Phd Guide Allocation</a></li>
    </ul>
	
		<?php //echo'<pre>';print_r($renum_files);exit;
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
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Add Thesis Evaluation Dispatch Records </h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row"> 
						<br/>				
					<span id="flash-messages" style="color:Green;padding-left:50px;">
						 <?php if(!empty($this->session->flashdata('message1'))){ echo $this->session->flashdata('message1'); } ?></span>
					<span id="flash-message" style="color:red;padding-left:50px;">
						 <?php if(!empty($this->session->flashdata('message2'))){ echo $this->session->flashdata('message2'); } ?></span>
                    <hr class="visible-xs no-grid-gutter-h">
                </div>
            </div>
        </div>
		    <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-heading">
                        <span class="panel-title" id="guide"> &nbsp;&nbsp;&nbsp;&nbsp;<b>Guide ID-Name : <?php if($sem_det['guide_id']!=''){ echo $sem_det['guide_id'].' - '.$sem_det['guide_name']; } else { echo '<span style="color:red;"> Guide Not Assigned.</span>';}?> </b></span>
                    </div>
                </div>
            </div>    
        </div>
           <div class="row">
        <div class="col-sm-12">
            <div class="panel">
                <div class="panel-heading">
                    <span class="panel-title" id="guide"><b>Details of Student: </b><b>PRN - <?=$sem_det['enrollment_no']?> || Name - <?=$sem_det['student_name']?> || Active Semester - Sem <?=$sem_det['current_semester']?> </b></span>
                </div>
              </div>
         </div>
    </div>       
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-heading">
                        <span class="panel-title">Add Dispatch Records</span>						
						<span id="message" style="color:red;padding-left:200px;"></span>
                        <div class="holder"></div>
					</div>
                    <div class="panel-body">
                        <div class="table-info">                                                       
                            <form id="form" name="form" action="<?=base_url($currentModule.'/submit_thesis_dispatch_records')?>" method="POST"> 

                             <input type="hidden" name="student_id" value="<?=$sem_det['student_id']?>" >
							 <input type="hidden" name="enrollment_no" value="<?=$sem_det['enrollment_no']?>" >						
								<div class="form-group">                                    
									<div class="col-sm-4">
									<label>Select Reviewer type: <?=$astrik?></label>
                                        <select id="reviewer" name="reviewer" class="form-control" onchange="check_reviewer(this.value)" >
                                            <option value="">Select Reviewer type</option>  									
                                            <option value="Reviewer1" >Reviewer 1</option>
                                            <option value="Reviewer2" >Reviewer 2</option>
                                            <option value="Reviewer3" >Reviewer 3</option>
                                        </select>   
										<span style="color:red;"><?php echo form_error('reviewer');?></span>							
                                    </div>
										<div class="col-sm-4">
									<label>Select Reviewer: <?=$astrik?></label>
                                        <select id="reviewer_code" name="reviewer_code" class="form-control" >
                                            <option value="">Select Reviewer</option>
											<?php
                                                 foreach($reviewer_det  as $rev){?>
                                            <option value="<?=$rev['ext_faculty_code']?>" ><?=$rev['ext_fac_name']?></option>
												 <?php } ?>
                                        </select>   
										<span style="color:red;"><?php echo form_error('reviewer_code');?></span>							
                                    </div>									
                                    <div class="col-sm-4">
									<label>Affiliation Institute Name: <?=$astrik?></label>
									<input type="text" id="aff_instiute" name="aff_instiute" class="form-control" placeholder="Enter Affiliation Institute Name"  />
									<span style="color:red;" id="err_hcode"><?php echo form_error('aff_instiute');?></span>
									</div>
                                </div>								
                                <div class="form-group">                                   
                                    <div class="col-sm-4">
									<label>Institute Address: <?=$astrik?></B></label>
									<textarea id="institute_addr" name="institute_addr" class="form-control" placeholder="Enter Address" ></textarea><span style="color:red;"><?php echo form_error('institute_addr');?></span>
								</div>
								<div class="col-sm-4">
                                  <label>Date of Dispatch: <?=$astrik?></label>
                                   <input type="text" id="dispatch_date" name="dispatch_date" class="form-control" placeholder="Enter Date"  /><span style="color:red;"><?php echo form_error('dispatch_date');?></span>
								</div>
                                </div>	
                                  <div class="form-group">
									<div class="col-sm-4">
								<label >Dispatch Tracking No.: <?=$astrik?></label>
								<input type="text" id="tracking_no" name="tracking_no" class="form-control" placeholder="Enter Dispatch Tracking No." /><span style="color:red;"><?php echo form_error('tracking_no');?></span>
								</div>
								<div class="col-sm-4">
								<label >Date of Receipt: <?=$astrik?></label>
								<input type="text" id="receipt_date" name="receipt_date" class="form-control" placeholder="Enter Date" /><span style="color:red;"><?php echo form_error('receipt_date');?></span>
								</div>  
                             </div>								
							<div class="form-group" ></div>
							 <div class="form-group" id="guide">
                                    <div class="col-sm-2">
                                       <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Submit</button>
                                    </div>                                    
                                    <div class="col-sm-2"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule)?>/guide_allocation_view'">Cancel</button></div>
                                </div>								
							   </div>	
                            </form>
                        </div>
                    </div>
                </div>
            </div>
                 <div class="row "> 
            <div class="col-sm-12">
				<div class="panel">
                    <div class="panel-heading">
                        <span class="panel-title" id="stdname">Dispatch Records List</span>
                    </div>
                    <div class="panel-body" style="overflow:scroll;height:700px;">
                        <div class="table-info" id='stud_view'>  
						  <?php //if(in_array("View", $my_privileges)) { ?>
							<table id="example" class="table table-bordered" width="100%">
							<thead>
								<tr>
									<th style="text-align: center">Srno</th>
									<th style="text-align: center">Reviewer</th>
									<th style="text-align: center">Reviewer Name</th>
							    	<th style="text-align: center">Email ID</th>
							    	<th style="text-align: center">Mobile No</th>
							    	<th style="text-align: center">Amount</th>
							    	<th style="text-align: center">Tracking No.</th>
							    	<th style="text-align: center">Date of Dispatch</th>
							    	<th style="text-align: center">Date of Receipt</th>
							    	<th style="text-align: center">Institute Name</th>
							    	<th style="text-align: center">Institute Address</th>
							    	<th style="text-align: center">Action</th>
								</tr>
								</thead>
								<tbody>
								<?php			
								$i=1;
									if(!empty($dispatch_det)){
										foreach($dispatch_det as $stud){
								?>
									<tr align="center">
										<td><?=$i?></td>
										<td><?=$stud['reviewer']?></td>
										<td><?=$stud['ext_fac_name']?></td>
										<td><?=$stud['ext_fac_email']?></td>
										<td><?=$stud['ext_fac_mobile']?></td>										
										<td><?=$stud['amount']?></td>										
										<td><?=$stud['tracking_no']?></td>
										<td><?=$stud['dispatch_date']?></td>
										<td><?=$stud['receipt_date']?></td>
										<td><?=$stud['aff_instiute']?></td>
										<td><?=$stud['institute_addr']?></td>
										<td><a href="<?=base_url();?>Guide_allocation_phd/edit_thesis_ev_dispatch_records/<?=base64_encode($stud['id']);?>" title="" ><i class="fa fa-edit"></i>&nbsp;</a></td>
									</tr>
								<?php
										$i++;
									  }
									}else{
										echo "<tr><td colspan='11'>No data found.</td></tr>";
									}
								?>
								</tbody>
							</table>
						  <?php //} ?>
						</div>
                    </div>
                </div>
			 </div>		
		   </div>			
        </div>
    </div>
</div>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>

<script type="text/javascript">
$(document).ready(function () {
$('#dispatch_date').datepicker( {format: 'dd-mm-yyyy',autoclose: true, endDate: '0d'});
$('#receipt_date').datepicker( {format: 'dd-mm-yyyy',autoclose: true, endDate: '0d'});
});
function check_reviewer(rev)
{
	 var stud_id='<?=$sem_det['student_id']?>';
    if(rev!=''){
	$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>Guide_allocation_phd/fetch_reviewer_det',
					data: {rev:rev,stud_id:stud_id},
				   'success' : function(data){ //probably this request will return 
                      if(data > 0){
						  
						  alert('Data Already submitted aginst '+rev);
						 //$('#btn_submit').prop('disabled', true);
						 $('#btn_submit').hide();
					  }else
					  {
						 //$('#btn_submit').prop('disabled', false);
						 $('#btn_submit').show();
					  }
				}
			});
		}
}


 $(document).ready(function() {
	    $('#example').DataTable({
        scrollX: true,
        bPaginate: false,
        dom: 'Bfrtip',
         buttons: [
			 {
				  extend: 'excel',
               exportOptions: {
                columns: [0,1,2,3,4,5,6,7,8,9] 
               }
			 }
		]
    });

   }); 
</script>     
