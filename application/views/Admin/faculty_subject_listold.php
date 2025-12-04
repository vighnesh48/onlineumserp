<script>
$(document).ready(function() {
	
	$('#swapModal').on('shown.bs.modal', function () {
    $(this).find('input:visible:first').focus();
});


  $(".toggle-accordion").on("click", function() {
    var accordionId = $(this).attr("accordion-id"),
      numPanelOpen = $(accordionId + ' .collapse.in').length;
    
    $(this).toggleClass("active");

    if (numPanelOpen == 0) {
      openAllPanels(accordionId);
    } else {
      closeAllPanels(accordionId);
    }
  })

  openAllPanels = function(aId) {
    console.log("setAllPanelOpen");
    $(aId + ' .panel-collapse:not(".in")').collapse('show');
  }
  closeAllPanels = function(aId) {
    console.log("setAllPanelclose");
    $(aId + ' .panel-collapse.in').collapse('hide');
  }	
});

</script>
<style>
.table{width:100%;} 
table{max-width: 100%;}

tr.collapse.in {
  display:table-row;
}

/* GENERAL STYLES */
body {
    
    font-family: Verdana;
}

/* FANCY COLLAPSE PANEL STYLES */
.fancy-collapse-panel .panel-default > .panel-heading {
padding: 0;

}
.fancy-collapse-panel .panel-heading a {
padding: 12px 35px 12px 15px;
display: inline-block;
width: 100%;
background-color:#136fab;
color: #ffffff;
font-size: 16px;
font-weight: 200;
position: relative;
text-decoration: none;

}
.fancy-collapse-panel .panel-heading a:after {
font-family: "FontAwesome";
content: "\f147";
position: absolute;
right: 20px;
font-size: 20px;
font-weight: 400;
top: 50%;
line-height: 1;
margin-top: -10px;

}

.fancy-collapse-panel .panel-heading a.collapsed:after {
content: "\f196";
}
</style>
<style>
/* Center modal perfectly */
.modal-dialog {
    margin: 1.75rem auto;
    max-width: 600px;
}

/* Modal content styling */
.modal-content {
    border-radius: 10px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    border: none;
}

.modal-header {
    background-color: #136fab;
    color: #fff;
    padding: 15px 20px;
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
}

.modal-title {
    font-weight: 600;
    font-size: 18px;
}

.modal-header .close {
    color: #fff;
    opacity: 1;
    font-size: 24px;
}

.modal-body {
    padding: 20px;
    background-color: #f9f9f9;
}

.modal-footer {
    padding: 15px 20px;
    background-color: #f1f1f1;
    border-bottom-left-radius: 10px;
    border-bottom-right-radius: 10px;
}

/* Form styles inside modal */
#swapForm .form-group label {
    font-weight: 500;
    color: #333;
}

#swapForm .form-control {
    border-radius: 5px;
    padding: 8px 12px;
    font-size: 14px;
    border: 1px solid #ccc;
    transition: border-color 0.3s ease;
	height: auto;
}

#swapForm .form-control:focus {
    border-color: #136fab;
    box-shadow: none;
}

/* Buttons */
.modal-footer .btn {
    min-width: 100px;
}

.modal-footer .btn-primary {
    background-color: #136fab;
    border-color: #136fab;
}

.modal-footer .btn-primary:hover {
    background-color: #0d5f96;
    border-color: #0d5f96;
}
</style>
<?php $astrik='<sup class="redasterik" style="color:red">*</sup>'; ?>
    <div class="page-header">
        <div class="row">
             <div class="col-sm-12">
                <div class="fancy-collapse-panel">
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                        <div class="panel panel-default">
                             <div class="table-responsive">
                                <div class="panel-heading" role="tab" id="headingOne">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne1" aria-expanded="true" aria-controls="collapseOne1">Total Subject List:
                                        </a>
                                    </h4>
                                </div>
                                    <div id="collapseOne1" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                        <div class="panel-body table-reponsive" style="width:100%;overflow:scroll;height:700px;padding:0px;">

										<table class="table table-bordered">
												<thead>
													<tr>
														<th>Sr.No</th>
														<th>Stream Name</th>
														<th>Semester</th>
														<th>Subject Code - Subject Name</th>
														<th>Pay Type</th>
														<th>TH Amount</th>
														<th>PR Amount</th>
														<th>No.of.Lectures</th>
														<th>Total Amount</th>
														<th>Actions</th>
													</tr>
												</thead>
												<tbody>
													<?php $x=1; if(!empty($lectures_det)) { 
														foreach ($lectures_det as $lecture) { ?>  
														<tr>
															<td><?php echo $x; ?></td>
															<td><?= $lecture['stream_short_name']; ?></td>
															<td><?= $lecture['semester']; ?></td>
															<td><?= $lecture['sub_code'].' - '.$lecture['subject_name']; ?></td>
															<td><?= $lecture['pay_type']; ?></td>
															<td><?= $lecture['th_amount']; ?></td>
															<td><?= $lecture['pr_amount']; ?></td>
															<td><?= $lecture['no_of_lectures']; ?></td>
															<td><?= $lecture['amount_payable']; ?></td>
															<td>
																<a href="javascript:void(0);" class="btn btn-primary open-modal" 
																   data-faculty_code="<?= $lecture['faculty_code'] ?>" 
																   data-sub_id="<?= $lecture['subject_id'] ?>">Add Sub Details</a>
															</td>
														</tr>
													<?php $x++; } } ?>
												</tbody>
											</table>
        	                            </div>
                                   </div>				
                            </div>
                        </div>
                    </div>
                </div>
             </div>   
            </div>
        </div>
  
   <div class="modal fade" id="swapModal" tabindex="-1" role="dialog" aria-labelledby="swapModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="swapModalLabel">Add Faculty Approval Subjects Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="swapForm">
                <div class="modal-body">
                    <input type="hidden" name="faculty_id" id="faculty_id">
                    <input type="hidden" name="sub_id" id="sub_id">
                    <div class="form-group">
                        <label>Select Pay Type<?=$astrik?></label>
                        <select name="pay_type" id="pay_type" class="form-control" required>
                            <option value="">--Select--</option>
                            <option value="hourly">Per Hour</option>
                            <option value="consolidated">Consolidated</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Rate of TH<?=$astrik?></label>
                        <input type="number" class="form-control" name="th_amount" id="th_amount" required min="10" max="10000">
                    </div>
					<div class="form-group">
                        <label>Rate of PR<?=$astrik?></label>
                        <input type="number" class="form-control" name="pr_amount" id="pr_amount" required min="10" max="10000">
                    </div>
					<div class="form-group">
                        <label>Total Approval Hrs/Lectures<?=$astrik?></label>
                        <input type="number" class="form-control" name="no_of_lectures" id="no_of_lectures" required min="1" max="250">
                    </div>
                    <div class="form-group">
                        <label>Total Payable<?=$astrik?></label>
                        <input type="number" class="form-control" name="amount_payable" id="amount_payable" required min="10" max="100000">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">ADD</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    // Open modal and set values
    $(".open-modal").click(function(){
        $("#faculty_id").val($(this).data("faculty_code"));
        $("#sub_id").val($(this).data("sub_id"));
        $("#swapModal").modal("show");
    });

    // Handle form submission
    $("#swapForm").submit(function(e){
        e.preventDefault(); // Prevent normal form submission
        $.ajax({
            url: "<?= base_url('Faculty/add_faculty_sub_approval_det') ?>", 
            type: "POST",
            data: $(this).serialize(),
            dataType: "json",
            success: function(response){
                if (response.status === "success") {
                    alert(response.message);
                    $("#swapModal").modal("hide");
					 $("#btnView").trigger("click");
                } else {
                    alert(response.message);
                }
            },
            error: function(){
                alert("Error: Could not insert data.");
            }
        });
    });
});

</script>



