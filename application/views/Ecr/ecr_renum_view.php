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

        /* Modal animations */
        /* Base modal dialog hidden state */
        .animated-modal .modal-dialog {
            transform: scale(0.7) rotateX(-30deg);
            opacity: 1;
            transition: transform 0.6s cubic-bezier(0.25, 1, 0.5, 1), opacity 0.6s ease;
            transform-origin: center center;
        }

        /* Modal dialog visible state */
        .animated-modal.show .modal-dialog {
            transform: scale(1) rotateX(0deg);
            opacity: 1;
        }

        /* Add a subtle glow to modal content */
        .modal-content {
            border-radius: 10px;
            background: linear-gradient(135deg, #ffffff, #f8f9fa);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3), 0 0 20px rgba(0, 123, 255, 0.2);
            overflow: hidden;
            animation: modal-glow 1.5s infinite alternate ease-in-out;
        }

        /* Modal glowing effect */
        @keyframes modal-glow {
            from {
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3), 0 0 20px rgba(0, 123, 255, 0.2);
            }

            to {
                box-shadow: 0 15px 40px rgba(0, 0, 0, 0.4), 0 0 30px rgba(0, 123, 255, 0.5);
            }
        }

        /* Header design */
        .modal-header {
            background: linear-gradient(44deg, #59b9f3, rgb(207 148 247), #edd6ff, #e0d3f9, #7aceff);
            background-size: 400% 400%;
            border-bottom: none;
            padding: 10px;
            padding-left: 25px;
            animation: gradientBackground 25s ease infinite;
        }


        /* Button hover glow effect */
        #openModalButton:hover {
            box-shadow: 0 8px 20px rgba(0, 123, 255, 0.7);
            transform: translateY(-2px) scale(1.05);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        /* Fade-in and smooth scaling for modal body */
        .modal-body {
            padding: 30px;
            background: #f8f9fa;
            border-radius: 10px;
            animation: fadeInBody 0.7s ease;
        }

        /* Keyframes for body fade-in */
        @keyframes fadeInBody {
            from {
                opacity: 0;
                transform: scale(0.009);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .pulse-animation {
            animation: pulse 0.5s;
        }



.glowing-border-button {
    border: 2px solid transparent;
    border-radius: 4px;
    transition: transform 0.3s, box-shadow 0.3s;
    /* animation: pulse 1s infinite; */
    transform: translateY(0) scale(1.0); /* Reset scale and translation to normal */
}

.glowing-border-button:hover {
    box-shadow: 0 8px 8px lightskyblue;
    transform: translateY(-2px) scale(1.05);
}


.glowing-border-button {
    box-shadow: 0 8px 8px lightskyblue;
    border-color: #007bff;
}

.glowing-border-button:hover {
    box-shadow: 0 8px 8px lightskyblue;
    border-color: blueviolet; /* More noticeable blue color on hover */
}

@keyframes pulse {
    0%, 100% {
        transform: scale(1.0);
        box-shadow: 0 8px 8px rgba(0, 123, 255, 0.7);
    }
    50% {
        transform: scale(1.05);
        box-shadow: 0 8px 16px rgba(0, 123, 255, 1);
    }
}
</style>

<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Exam Management</a></li>
        <li class="active"><a href="#">ECR Remuneration</a></li>
    </ul>

    <div class="page-header">
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm">
                <i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;ECR Remuneration List
            </h1>
            <div class="col-xs-12 col-sm-8">
                <div class="pull-right col-xs-12 col-sm-auto">
                <button class="btn glowing-border-button btn-labeled" data-toggle="modal" data-target="#createRenumModal">
    <span class="btn-label icon fa fa-plus"></span>Add Remuneration
</button>
                </div>
            </div>
        </div>
    </div>
    <?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger">
        <?= $this->session->flashdata('error'); ?>
    </div>
<?php endif; ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="panel">
                <div class="panel-heading">
                    <span class="panel-title">Manage ECR Remuneration</span>
                </div>

                <div class="panel-body">

                    <!-- Table to display renum data -->
                    <table class="table table-bordered mt-3" id="datatable">
                        <thead class="bgdynamic">
                            <tr>
                                <th>ID</th>
                                <th>Academic Year</th>
                                <th>Exam Session</th>
                                <th>ECR Role</th>
                                <th>Remuneration</th>
                                <th>Additional Session Count</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($renum_data)): ?>
                                <?php $i = 1;
                                foreach ($renum_data as $row): ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= $row['academic_year'] ?></td>
                                        <td><?= $row['exam_name'] ?></td>
                                        <td><?= $row['role_name'] ?></td>
                                        <td><?= $row['renum'] ?></td>
                                        <td><?= $row['additional_ssn_count'] ?></td>
                                        <td>
                                            <button class="btn edit-btn btn-sm glowing-border-button" data-id="<?= $row['id'] ?>"
                                                data-ecr-role-id="<?= $row['ecr_role_id'] ?>"
                                                data-exam-id="<?= $row['exam_id'] ?>"
                                                data-academic-year="<?= $row['academic_year'] ?>"
                                                data-renum="<?= $row['renum'] ?>"
                                                data-additional-ssn-count="<?= $row['additional_ssn_count'] ?>">
                                                Edit
                                            </button>
                                        </td>

                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5">No records found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for creating renum -->
    <div id="createRenumModal" class="modal fade animated-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-m" role="document">
        <div class="modal-content shadow">
                <form action="<?= base_url('EcrRenumerationController/createRenum') ?>" method="POST">
                    <div class="modal-header bgdynamic">
                        <h5 class="modal-title">Add Renumeration</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="ecr_role_id">ECR Role</label>
                            <select name="ecr_role_id" id="ecr_role_id" class="form-control" >
                                <option value="">Select ECR Role</option>
                                <?php foreach ($ecr_roles as $role): ?>
                                    <option value="<?= $role['ecr_role_id'] ?>"><?= $role['role_name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="exam_id">Exam Session</label>
                            <select name="exam_id" id="exam_id" class="form-control" >
                                <option value="">Select Exam Session</option>
                                <?php foreach ($exam_sessions as $session): ?>
                                    <option value="<?= $session['exam_id'] ?>" selected ><?= $session['exam_name'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="academic_year">Academic Year</label>
                            <input type="text" name="academic_year" id="academic_year" class="form-control"
                                value="<?= ACADEMIC_YEAR ?>" readonly required>
                        </div>

                        <div class="form-group">
                            <label for="renum">Remuneration</label>
                            <input type="number" name="renum" id="renum" class="form-control" step="0.01" required>
                        </div>
                        <div class="form-group">
                            <label for="add_ssn_count">Additional Session Count If Applicable</label>
                            <input type="number" name="add_ssn_count" id="add_ssn_count" class="form-control" step="1">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Submit</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
                </div>
    </div>
</div>

<script>
$(document).ready(function () {
    // DataTable initialization
     $('#datatable').DataTable({
    dom: 'Bfrtip',
    pageLength: 15, // Show 15 rows per page by default
    lengthMenu: [ [15, 25, 50, 100], [15, 25, 50, 100] ], // Options for page length
    buttons: [
        'pageLength' // This adds the page length dropdown button
    ]
});

    // Event listener for "Edit" button clicks
    $('.edit-btn').on('click', function () {
        // Retrieve data attributes from the button
        const id = $(this).data('id');
        const ecrRoleId = $(this).data('ecr-role-id');
        const examId = $(this).data('exam-id');
        const academicYear = $(this).data('academic-year');
        const renum = $(this).data('renum');
        const additionalSsnCount = $(this).data('additional-ssn-count');

        // Set values in the modal's form fields
        $('#ecr_role_id').val(ecrRoleId);
        $('#exam_id').val(examId);
        $('#academic_year').val(academicYear);
        $('#renum').val(renum);
        $('#add_ssn_count').val(additionalSsnCount);

        // Set form action to update the existing record
        $('#createRenumModal form').attr('action', '<?= base_url() . 'EcrRenumerationController/updateRenum/' ?>' + id);
        $('#createRenumModal .modal-title').text('Edit Renumeration');

        // Show the modal with animation
        openModalWithAnimation();
    });

    // Open modal with animation
    function openModalWithAnimation() {
        const modal = $('#createRenumModal');
        modal.modal('show');

        // Reset animation state
        const dialog = modal.find('.modal-dialog');
        dialog.css({
            transform: 'scale(0.7) rotateX(-30deg)',
            opacity: 0,
        });

        // Trigger animation with a slight delay
        setTimeout(() => {
            dialog.css({
                transform: 'scale(1) rotateX(0deg)',
                opacity: 1,
            });
        }, 100);
    }

    // Reset the modal when it's closed
    $('#createRenumModal').on('hidden.bs.modal', function () {
        $(this).find('form').trigger("reset");
        $(this).find('form').attr('action', '<?= base_url('EcrRenumerationController/createRenum') ?>');
        $(this).find('.modal-title').text('Add Renumeration');
    });
});
</script>


<script> /*
    $(document).ready(function () {
        // When an "Edit" button is clicked, populate the modal with the selected values
        $('.edit-btn').on('click', function () {
            // Get each attribute value from the clicked button
            const id = $(this).data('id');
            const ecrRoleId = $(this).data('ecr-role-id');
            const examId = $(this).data('exam-id');
            const academicYear = $(this).data('academic-year');
            const renum = $(this).data('renum');
            const additionalSsnCount = $(this).data('additional-ssn-count');

            // Set the values in the modal form fields
            $('#ecr_role_id').val(ecrRoleId);
            $('#exam_id').val(examId);
            $('#academic_year').val(academicYear);
            $('#renum').val(renum);
            $('#add_ssn_count').val(additionalSsnCount);

            // Update the form action to the update route with the item ID
            $('#createRenumModal form').attr('action', '<?= base_url() . 'EcrRenumerationController/updateRenum/' ?>' + id);

            // Update the modal title
            $('#createRenumModal .modal-title').text('Edit Renumeration');

            // Show the modal
            $('#createRenumModal').modal('show');
        });

        // Reset the modal when closed
        $('#createRenumModal').on('hidden.bs.modal', function () {
            $('#createRenumModal form').trigger("reset");
            $('#createRenumModal form').attr('action', '<?= base_url('EcrRenumerationController/createRenum') ?>');
            $('#createRenumModal .modal-title').text('Add Renumeration');
        });
    });
        //datatable
        $(document).ready(function() {
        $('#datatable').DataTable({
            dom: 'Bfrtip',
            buttons: []
        });
    });*/
</script>