<link rel="stylesheet" href="<?= base_url('assets') ?>/stylesheets/jPages.css">
<script src="<?= base_url('assets/javascripts') ?>/jPages.js"></script>
<link rel="stylesheet" href="<?= base_url('assets') ?>/stylesheets/select2.css">
<script src="<?= base_url('assets/javascripts') ?>/select2.min.js"></script>
<?php //print_r($my_privileges); die; 
?>

<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li class="active"><a href="#">Masters</a></li>
        <li class="active">Job Fair</li>
    </ul>
    <div class="page-header">
       
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-heading">
                        <span class="panel-title">Job Fair Details</span>
                    </div>

                    <div class="panel-body">
                    <div class="panel-body">
                        <div class="table-info">
                            <form method="GET" action="<?= base_url('Job_Fair/index'); ?>">
                                <div class="row">
                                    <div class="col-md-1">
                                        <select name="limit" class="form-control" onchange="this.form.submit()">
                                            <option value="10" <?= $limit == 10 ? 'selected' : '' ?>>10 rows</option>
                                            <option value="25" <?= $limit == 25 ? 'selected' : '' ?>>25 rows</option>
                                            <option value="50" <?= $limit == 50 ? 'selected' : '' ?>>50 rows</option>
                                            <option value="100" <?= $limit == 100 ? 'selected' : '' ?>>100 rows</option>
                                            <option value="500" <?= $limit == 500 ? 'selected' : '' ?>>500 rows</option>
                                            <option value="all" <?= $limit == 'all' ? 'selected' : '' ?>>All</option>
                                            </select>
                                    </div>
                                    <div class="col-md-9">

                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" name="search" class="form-control" onchange="this.form.submit()" placeholder="Search..." value="<?= isset($search) ? $search : '' ?>">
                                    </div>

                                    <!-- <div class="col-md-1">
                                        <button type="submit" class="btn btn-primary">Search</button>
                                    </div> -->
                                </div>
                            </form>
                            <br>
                            <button class="btn btn-success mb-3" onclick="exportTableToExcel('eventTable', 'Job_Fair_List')">
                                Export to Excel
                            </button>

                            <table class="table table-bordered" id="eventTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Applicant Name</th>
                                        <th>Father Name</th>
                                        <th>Email</th>
                                        <th>Mobile No.</th>
                                        <th>Qualification</th>
                                        <th>Technical Qualification</th>
                                        <th>College Name</th>
                                        <th>Age</th>
                                        <th>State</th>
                                        <th>City</th>
										<th>Created Date</th>
                                    </tr>
                                </thead>
                                <tbody id="itemContainer">
                                    <?php if (!empty($job_applications)) : ?>
                                        <?php
                                            $offset = $this->uri->segment(3) ? (int)$this->uri->segment(3) : 0;
                                            $actual_limit = is_numeric($limit) ? (int)$limit : 0;
                                            $i = ($limit === 'all') ? 1 : 1 + $offset;
                                            ?>                     
                                             <?php foreach ($job_applications as $job_application) : ?>
                                            <tr>
                                                <td><?= $i ?></td>
                                                <td><?= htmlspecialchars($job_application['name']) ?></td>
                                                <td><?= htmlspecialchars($job_application['father_name']) ?></td>
                                                <td><?= htmlspecialchars($job_application['email_id']) ?></td>
                                                <td><?= htmlspecialchars($job_application['mobile_no']) ?></td>
                                                <td><?= htmlspecialchars($job_application['qualification']) ?></td>
                                                <td><?= htmlspecialchars($job_application['tqualification']) ?></td>
                                                <td><?= htmlspecialchars($job_application['college_name']) ?></td>
                                                <td><?= htmlspecialchars($job_application['age']) ?></td>
                                                <td><?= htmlspecialchars($job_application['state_name']) ?></td>
                                                <td><?= htmlspecialchars($job_application['city_name']) ?></td>
												<td><?= ($job_application['created_at']) ?></td>
                                               
                                            </tr>
                                            <?php $i++; ?>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <tr>
                                            <td colspan="12" class="text-center">No Job Fair Applications Found.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                            <div class="pagination-container text-center">
                                <?= $pagination_links ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

<script>
    function exportTableToExcel(tableID, filename = 'Job Fair 3.0 Application List') {
        const table = document.getElementById(tableID);
        const ws = XLSX.utils.table_to_sheet(table, {
            origin: 'A2'
        });

        XLSX.utils.sheet_add_aoa(ws, [
            ["Job Fair 3.0 Application List"]
        ], {
            origin: "A1"
        });
        ws['!merges'] = [{
            s: {
                r: 0,
                c: 0
            },
            e: {
                r: 0,
                c: table.rows[0].cells.length - 1
            }
        }];
        ws['A1'].s = {
            font: {
                bold: true,
                sz: 14
            },
            alignment: {
                horizontal: "center"
            }
        };
        const wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, "Sheet 1");

        XLSX.writeFile(wb, `${filename}.xlsx`);
    }
</script>