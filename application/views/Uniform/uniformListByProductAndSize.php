<link rel="stylesheet" href="<?= base_url('assets') ?>/stylesheets/jPages.css">
<script src="<?= base_url('assets/javascripts') ?>/jPages.js"></script>
<link rel="stylesheet" href="<?= base_url('assets') ?>/stylesheets/select2.css">
<script src="<?= base_url('assets/javascripts') ?>/select2.min.js"></script>
<script src="<?= base_url('assets/javascripts') ?>/jquery.table2excel.js"></script>

<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li class="active"><a href="#">Uniform</a></li>
        <li class="active"><a href="#">List</a></li>
    </ul>
    <div class="page-header">
        <div class="row">
            <div class="col-xs-12 col-sm-8">
                <h3 class="page-title">Uniform List</h3>
            </div>
        </div>
    </div>


    <div class="row">
        <!-- Download Excel -->
        <div class="col-md-12 text-right">
            <form method="post" action="<?= site_url('Uniform/download_uniform_excel') ?>">
                <input type="hidden" name="academic_year" value="<?= isset($academic_year) ? $academic_year : '' ?>">
                <input type="hidden" name="school" value="<?= isset($school) ? $school : '' ?>">
                <button type="submit" class="btn btn-primary">Download Excel</button>
            </form>
        </div>

        <!-- Filter Form -->
        <form id="filterdata" method="post" action="<?= site_url('Uniform/uniformListByProductAndSize') ?>">
            <div class="col-md-2">
                <input type="text" name="enrollment_no"
                    value="<?= isset($enrollment_no) ? $enrollment_no : '' ?>"
                    placeholder="Enter Enrollment No" class="form-control">
            </div>
            <div class="col-md-2">
                <select name="academic_year" class="form-control">
                    <option value="" disabled <?= empty($academic_year) ? 'selected' : '' ?>>Select Academic Year</option>
                    <?php for ($year = 2021; $year <= date('Y'); $year++): ?>
                        <option value="<?= $year ?>"
                            <?= isset($academic_year) && $academic_year == $year ? 'selected' : '' ?>>
                            <?= $year ?>
                        </option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="col-md-2">
                <select name="school" class="form-control">
                    <option value="" disabled selected>Select School</option>
                    <?php foreach ($schools as $school): ?>
                        <option value="<?= $school['school_name'] ?>" <?= set_value('school') == $school['school_name'] ? 'selected' : '' ?>>
                            <?= $school['school_name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
    </div>
    <div class="form-group d-flex align-items-left">

        <label for="per-page" style="margin-right: 10px;">Per page:</label>
        <select id="per-page" name="per_page" class="form-control" style="width: 90px;" onchange="this.form.submit()">
            <option value="" disabled selected>Select</option>
            <option value="100" <?= isset($per_page) && $per_page == 100 ? 'selected' : '' ?>>100</option>
            <option value="250" <?= isset($per_page) && $per_page == 250 ? 'selected' : '' ?>>250</option>
            <option value="500" <?= isset($per_page) && $per_page == 500 ? 'selected' : '' ?>>500</option>
            <option value="700" <?= isset($per_page) && $per_page == 700 ? 'selected' : '' ?>>700</option>
            <option value="1500" <?= isset($per_page) && $per_page == 1500 ? 'selected' : '' ?>>1500</option>
            <option value="10000" <?= isset($per_page) && $per_page == 10000 ? 'selected' : '' ?>>All</option>
        </select>
    </div>
    </form>
    <div class="row">
        <div class="col-sm-12">
            <div class="table-info table-responsive" id="stddata" style="max-height: 800px; overflow-y: auto; border: 1px solid #ddd;">
               <table class="table table-bordered" id="uniformTable">
                    <thead style="position: sticky; top: 0; background-color: #f8f9fa; z-index: 1;">
                        <tr>
                            <th>#</th>
                            <th>Enrollment No</th>
                            <th>Student Name</th>
                            <th>Transaction No</th>
                            <th>Phone</th>
                            <th>Product Info</th>
                            <th>Amount</th>
                            <th>Bank Ref No</th>
                            <th>School Name</th>
                            <th>AY</th>
                            <th>Shirt Size</th>
                            <th>Shirt Count</th>
                            <th>Trouser Size</th>
                            <th>Trouser Count</th>
                            <th>Blazer Size</th>
                            <th>Blazer Count</th>
                            <th>Tie Count</th>
                            <th>Kurta Size</th>
                            <th>Kurta Count</th>
                            <th>Denin Size</th>
                            <th>Denin Count</th>
                        
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($uniform_data)) : ?>
                            <?php $j = 1;
                            foreach ($uniform_data as $row) : ?>
                                <tr>
                                    <td><?= $j++; ?></td>
                                    <td><?= $row['enrollment_no'] ?></td>
                                    <td><?= $row['firstname'] ?></td>
                                    <td><?= $row['transaction_no'] ?>-<?= $row['all_transaction_ids'] ?></td>
                                    <td><?= $row['phone'] ?></td>
                                    <td><?= $row['productinfo'] ?></td>
                                    <td><?= $row['amount'] ?></td>
                                    <td><?= $row['bank_ref_num'] ?></td>
                                    <td><?= $row['school_name'] ?></td>
                                    <td><?= $row['academic_year'] ?></td>
                                    <td><?= $row['Shirt_Size'] ?></td>
                                    <td><?= $row['Shirt_Count'] ?></td>
                                    <td><?= $row['Trouser_Size'] ?></td>
                                    <td><?= $row['Trouser_Count'] ?></td>
                                    <td><?= $row['Blazer_Size'] ?></td>
                                    <td><?= $row['Blazer_Count'] ?></td>
                                    <td><?= $row['Tie_Count'] ?></td>
                                    <td><?= $row['Kurta_Size'] ?></td>
                                    <td><?= $row['Kurta_Count'] ?></td>
                                    <td><?= $row['Denim_Size'] ?></td>
                                    <td><?= $row['Denim_Count'] ?></td> 
                                 
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="17">No data found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>


            </div>
        </div>
    </div>
</div>