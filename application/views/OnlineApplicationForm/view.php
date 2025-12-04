<script src="<?= site_url() ?>assets/javascripts/jquery.min.js"></script>
<script src="<?= site_url() ?>assets/javascripts/bootstrap.min.js"></script>
<!-- DataTables CSS -->

<!-- DataTables Buttons CSS -->

<!-- jQuery (required for DataTables) -->
<!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> -->

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>

<!-- DataTables Buttons JS (for Excel export) -->
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>

<!-- JS for exporting to Excel -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>


<style>
    .bgdynamic {
        background: linear-gradient(44deg, #59b9f3, rgb(207 148 247), #edd6ff, #e0d3f9, #7aceff);
        background-size: 400% 400%;
        animation: gradientBackground 25s ease infinite;
    }

    @keyframes gradientBackground {
        0% {
            background-position: 0% 50%;
        }

        50% {
            background-position: 100% 50%;
        }

        100% {
            background-position: 0% 50%;
        }
    }
</style>

<script>

    $(document).ready(function () {
        // Flag to track if search was successful
        let searchPerformed = false;

        // Submit form when date or role is selected
        $('#filter_application_type').on('change', function () {
            $('#filterForm').submit();
        });

    });

</script>
<script>
    function sendConfirmationMailAjax(enrollment_no, toEmail, tableName, txtid ,certificate_id) {
        
        $.ajax({
            url: '<?= base_url("OnlineApplicationForms/sendConfirmationMail") ?>',  // Adjusted URL to match your setup
            type: 'POST',
            data: {
                enrollment_no: enrollment_no,
                to_email: toEmail,
                table_name: tableName,
                txtid: txtid,
                certificateId:certificate_id
            },
            success: function(response) {
                alert(response.message || 'Confirmation Mail sent successfully');
                location.reload();
            },
            error: function(xhr, status, error) {
                console.error("Error sending Confirmation Mail:", error);
                alert('Failed to send Confirmation Mail. Please try again.');
            }
        });
    }


    function sendCollectionMailAjax(enrollment_no, toEmail, tableName, txtid,certificate_id) {
      
        $.ajax({
            url: '<?= base_url("OnlineApplicationForms/sendCollectionMail") ?>',  // Adjusted URL to match your setup
            type: 'POST',
            data: {
                enrollment_no: enrollment_no,
                to_email: toEmail,
                tableName: tableName,
                txtid: txtid,
                certificateId:certificate_id


            },
            success: function(response) {
                alert(response.message || 'Collection Mail sent successfully');
                location.reload();
            },
            error: function(xhr, status, error) {
                console.error("Error sending Collection Mail:", error);
                alert('Failed to send Collection Mail. Please try again.');
            }
        });
    }
</script>

<script>
$(document).ready(function () {
    var table = $('.table').DataTable({
        dom: 'Bfrtip',  // Define the layout (B for buttons, f for filter, t for table, i for info, p for pagination)
        buttons: [
            {
                extend: 'excelHtml5',  // Enable the Excel export button
                exportOptions: {
                    columns: ':not(:nth-child(11))'  // Exclude the 11th column (Product Info) from the export
                }
            }
        ],
        lengthChange: true,  // Allow the user to change how many entries they see per page
        pageLength: 20,  // Set the default rows per page
        language: {
            lengthMenu: "Show _MENU_ entries per page"  // Customize the length dropdown text
        },
        lengthMenu: [
            [10, 25, 50, -1],  // Number of entries options
            [10, 25, 50, "All"]  // Labels for the number of entries options
        ]
    });

    // Change the search input placeholder text
    $('input[type="search"]').attr('placeholder', 'Search');

    // Add Bootstrap styling to the length dropdown
    $(".dataTables_length select").addClass("form-control");  // Make the dropdown look nice with Bootstrap
});

    </script>




<!-- Duty Allocation List -->
<div id="content-wrapper">
        <ul class="breadcrumb breadcrumb-page">
            <div class="breadcrumb-label text-light-gray">You are here: </div>
            <li class="active"><a href="#">Online Application</a></li>
            <li class="active"><a href="#">Online Application Forms </a></li>
        </ul>
        
    <!-- Filter Form -->
    <!-- Radio Buttons for View Selection -->
    
   

    <!-- Table Panel -->
    <div class="row">
        <div class="col-sm-12">
            <div class="panel">
                <div class="panel-heading">
                    <span class="panel-title">Online Application List</span>
                </div>
                <div class="panel-body">
                    <div class="row " >
                        
                        <div class="col-sm-12">
                                <div class="row">
                                <form id="filterForm" action="<?= base_url('OnlineApplicationForms/index') ?>" method="GET">
                                    <div class="col-sm-2">

                                    <select id="filter_application_type" name="filter_application_type" class="form-control">
                                        <option value="">Select Application Type</option>
                                        <?php foreach ($application_forms as $application_form): ?>
                                            <option value="<?= $application_form->productinfo ?>" 
                                                <?= isset($_GET['filter_application_type']) && $_GET['filter_application_type'] == $application_form->productinfo ? 'selected' : '' ?>>
                                                <?= ucwords(str_replace('_', ' ', $application_form->formatted_productinfo)) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    </div>
                                            
                                </div>
                              </form>
                        </div>
                    </div> <br>
                
                        <!-- Duty Allocation Table -->
                        <table class="table table-bordered">
                            <thead class="bgdynamic">
                                <tr>
                                    <th>#</th>
                                    <th>Application No</th>
                                    <th>Name</th>
                                    <th>Enrollment No</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Transaction Id</th>
                                    <th>School</th>
                                    <th>Stream</th>
                                    <th>Academic Year</th>
                                    <th style="display :none">Product Info</th>
                                    <th>Amount</th>
                                    <th>Payment Mode</th>
                                    <th>Application Name</th>
                                    <th  class="action-column">Action</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($applications)): ?>
                                    <?php $i=1;
                                     foreach ($applications as $application): ?>
                                        <tr>
                                            
                                            <td><?= $i++; ?></td>
                                            <td><?= $application->application_no ?></td>
                                            <td><?= $application->name ?>
                                            </td>
                                            <td><?= $application->enrollment_no ?>
                                            </td>
                                            <td><?= $application->email ?></td>
                                            <td><?= $application->phone ?></td>
                                            <td><?= $application->txtid ?></td>
                                            <td><?= $application->school_name ?></td>
                                            <td><?= $application->stream_name ?></td>
                                            <td><?= $application->academic_year ?></td>
                                            <td style="display :none"><?= $application->productinfo ?></td>
                                            <td><?= $application->amount ?></td>
                                            <td><?= $application->payment_mode ?></td>
                                            <td><?= $application->table_name ?></td>
                                            <td class="action-column">
                                                <?php if($application->certificate_status == 0){ ?>
                                                    <button type="button" class="btn btn-primary"
                                                        onclick="if(confirm('Are you sure you want to send the Confirmation Mail?')) { this.disabled = true; sendConfirmationMailAjax('<?= $application->enrollment_no ?>', '<?= $application->email ?>', '<?= $application->table_name ?>', '<?= $application->txtid ?>', '<?= $application->certificate_id ?>'); }">
                                                        Confirmation Mail
                                                    </button>
                                                <?php } else if($application->certificate_submit_status == 0){ ?>
                                                    <button type="button" class="btn btn-success"
                                                        onclick="if(confirm('Are you sure you want to send the Collection Mail?')) { this.disabled = true; sendCollectionMailAjax('<?= $application->enrollment_no ?>', '<?= $application->email ?>', '<?= $application->table_name ?>', '<?= $application->txtid ?>', '<?= $application->certificate_id ?>'); }">
                                                        Collection Mail
                                                    </button>
                                                <?php } else { ?>
                                                    <span style="color:green;">Mail Sent Successfully</span>
                                                <?php } ?>
                                            </td>


                                            
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="8">No Applications found</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                </div>
            </div>
        </div>
    </div>
</div>


