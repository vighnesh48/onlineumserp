<link rel="stylesheet" href="<?= base_url('assets') ?>/stylesheets/jPages.css">
<script src="<?= base_url('assets/javascripts') ?>/jPages.js"></script>
<link rel="stylesheet" href="<?= base_url('assets') ?>/stylesheets/select2.css">
<script src="<?= base_url('assets/javascripts') ?>/select2.min.js"></script>

<style>
    /* Loader Container */
    #loader {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.7);
        z-index: 9999;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    /* Spinner Animation */
    .spinner {
        border: 8px solid #f3f3f3;
        /* Light gray */
        border-top: 8px solid #3498db;
        /* Blue */
        border-radius: 50%;
        width: 60px;
        height: 60px;
        animation: spin 1s linear infinite;
    }

    .custom-alert {
        position: fixed;
        top: 100px;
        left: 50%;
        transform: translateX(-50%);
        width: 350px;
        z-index: 1050;
        padding: 15px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        font-size: 15px;
        text-align: center;
    }

    /* Spinner Animation Keyframes */
    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>
<script>
    setTimeout(function() {
        $(".custom-alert").fadeOut("slow");
    }, 4000);
</script>


<?php //print_r($my_privileges); die; 
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li class="active"><a href="#">Masters</a></li>
        <li class="active"><a href="#">External Faculty Event Detil Masters</a></li>
    </ul>
    <div class="page-header">
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;External Faculty Event Details</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">
                    <hr class="visible-xs no-grid-gutter-h">
                    <?php //if(in_array("Add", $my_privileges)) { 
                    ?>
                    <div class="pull-right col-xs-12 col-sm-auto"><a style="width: 100%;" class="btn btn-primary btn-labeled" href="<?= base_url($currentModule . "/add_ext_faculty_event_details/" . base64_encode($btype)) ?>"><span class="btn-label icon fa fa-plus"></span>Add External Faculty Event Details</a></div>
                    <div class="visible-xs clearfix form-group-margin"></div>
                    <?php //} 
                    ?>

                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-sm-12">&nbsp;</div>
        </div>

        <!-- Loader Element -->
        <div id="loader" style="display: none;">
            <!-- You can replace this with any loader animation -->
            <div class="spinner"></div>
        </div>


        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-heading">
                        <span class="panel-title">List</span>
                        <div class="holder"></div>
                    </div>

                    <?php if (!empty($success_message)): ?>
                        <div class="custom-alert alert alert-success alert-dismissible fade in" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                            <?= $success_message ?>
                        </div>
                    <?php endif; ?>

                    <div class="panel-body">
                        <form method="GET" action="<?= base_url($currentModule . '/listExtFacultyEventDetails') ?>" class="form-inline" style="margin-bottom: 20px;">
                            <div class="form-group">
                                <label>Event Type:</label>
                                <select name="event_type" class="form-control select2" style="width: 150px;" id="event_type">
                                    <option value="" selected disabled>Select event Type</option>
                                    <?php foreach ($event_type_details as $event): ?>
                                        <option value="<?= $event['id'] ?>" <?= @$_GET['event_type'] == $event['id'] ? 'selected' : '' ?>>
                                            <?= $event['event_type'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group" style="margin-left: 15px;">
                                <label>Month & Year:</label>
                                <input type="text" name="month_year" class="form-control" id="month_filter" value="<?= isset($_GET['month_year']) ? $_GET['month_year'] : '' ?>" placeholder="MM-YYYY" autocomplete="off" required />
                            </div>

                            <button type="submit" class="btn btn-primary" style="margin-left: 15px;">Search</button>

                            <a href="<?= base_url($currentModule . '/downloadFilteredPDF?' . http_build_query($_GET)) ?>"
                                id="downloadPdfBtn" class="btn btn-success" style="margin-left: 15px;" target="_blank">Download PDF</a>
                        </form>
                        <div class="table-info">
                            <?php //if(in_array("View", $my_privileges)) { 
                            ?>
                            <div class="table-responsive">
                                <table class="table table-bordered" id='example'>
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Faculty Name</th>
                                            <th>Event Type</th>
                                            <th>TA Amount</th>
                                            <th>Honorarium</th>
                                            <th>Total</th>
                                            <th>Created At</th>
                                            <th>Month & Year</th>
                                            <th>Description</th>
											<th>Mobile No</th>
											<th>Account Holder Name</th>
											<th>Bank Name</th>
											<th>Branch</th>
											<th>IFSC</th>
											<th>Passbook/ Cheque Copy</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1;
                                        foreach ($event_list as $row): ?>
                                            <tr>
                                                <td><?= $i++ ?></td>
                                                <td><?= $row['ext_fac_name'] ?></td>
                                                <td><?= $row['event_type'] ?></td>
                                                <td><?= number_format($row['ta_amount'], 2) ?></td>
                                                <td><?= number_format($row['honorarium_amount'], 2) ?></td>
                                                <td><?= number_format($row['total_amount'], 2) ?></td>
                                                <td><?= date('d-m-Y H:i', strtotime($row['created_at'])) ?></td>
                                                <td><?= $row['month_year'] ?></td>
                                                <td><?=$row['description'] ?></td>
												<td><?=$row['ext_fac_mobile']?></td>
												<td><?=$row['acc_holder_name']?></td>
												<td><?=$row['bank_name']?></td>
												<td><?=$row['branch']?></td>
												<td><?=$row['ifsc_code']?></td>
												<td><?php if ($row['cheque_file']): 
											$b_name = "uploads/phd_renumaration_files/";
											$dwnld_url = base_url()."Upload/download_s3file/".$row['cheque_file'].'?b_name='.$b_name; ?>
							                <a href="<?php echo $dwnld_url ?>" download ><i class="fa fa-file-pdf-o" aria-hidden="true" style="color: red;font-size: 24px;"></i></a>
										 <?php endif; ?></td>
												
                                                <td><?= ($row['verification_status'] == 1) ? 'Verified' : 'Pending' ?></td>
                                                <td>
                                                    <?php if ($row['verification_status'] == 0): ?>
                                                        <a href="<?= base_url($currentModule . "/add_ext_faculty_event_details/" . base64_encode($row['id'])) ?>"
                                                            class="btn btn-sm btn-primary">
                                                            <i class="fa fa-edit"></i> Edit
                                                        </a>
                                                        <?php if ($this->session->userdata('role_id') == 23): ?>
                                                            <a href="<?= base_url($currentModule . "/verify_status/" . base64_encode($row['id'])) ?>"
                                                                class="btn btn-sm btn-success"
                                                                onclick="return confirm('Are you sure you want to verify the status for <?= addslashes($row['ext_fac_name']) ?>?');">
                                                                <i class="fa fa-check-circle" aria-hidden="true"></i> Verify
                                                            </a>
                                                        <?php endif; ?>
                                                    <?php else: ?>
                                                        <button class="btn btn-sm btn-default" disabled>
                                                            <i class="fa fa-check-circle" style="color: green;" aria-hidden="true"></i> Already Verified
                                                        </button>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                                <?php //} 
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.select2').select2();

        $('#month_filter').datepicker({
            format: "mm-yyyy",
            startView: "months",
            minViewMode: "months",
            autoclose: true,
            endDate: new Date()
        });
        // Disable PDF download if both not selected
        function toggleDownloadButton() {
            const eventType = $('#event_type').val();
            const monthYear = $('#month_filter').val();

            if (eventType && monthYear) {
                $('#downloadPdfBtn').removeClass('disabled').attr('href', updateDownloadLink());
            } else {
                $('#downloadPdfBtn').addClass('disabled').attr('href', '#');
            }
        }

        function updateDownloadLink() {
            const params = new URLSearchParams({
                event_type: $('#event_type').val(),
                month_year: $('#month_filter').val()
            });
            return "<?= base_url($currentModule . '/downloadFilteredPDF?') ?>" + params.toString();
        }

        $('#event_type, #month_filter').on('change', function() {
            toggleDownloadButton();
        });

        // Run on page load
        toggleDownloadButton();
        $('#example').DataTable({
            orderCellsTop: true,
            fixedHeader: true,
            dom: 'lBfrtip',
            destroy: true,
            retrieve: true,
            paging: true,

            buttons: [{
                extend: 'excel',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 15]
                }
            }],
            lengthMenu: [
                [50, 100, 150, -1],
                [50, 100, 150, "All"]
            ],
        });
    });
</script>