<?php
$bucketname = 'uploads/employee_documents/';
?>
<link rel="stylesheet" href="<?= base_url('assets') ?>/stylesheets/jPages.css">
<script src="<?= base_url('assets/javascripts') ?>/jPages.js"></script>
<link rel="stylesheet" href="<?= base_url('assets') ?>/stylesheets/select2.css">
<script src="<?= base_url('assets/javascripts') ?>/select2.min.js"></script>
<script src="<?= base_url('assets/javascripts') . '/bootstrap-datepicker.js' ?> "></script>
<script src="<?= base_url() ?>assets/javascripts/moment.js"></script>
<?php $uid = $this->session->userdata("name"); ?>
<style>
    .leavetab {
        max-width: 110% !important;
        width: 110% !important;
    }

    .timeline-centered {
        position: relative;
        margin-bottom: 30px;
    }

    .timeline-centered:before,
    .timeline-centered:after {
        content: " ";
        display: table;
    }

    .timeline-centered:after {
        clear: both;
    }

    .timeline-centered:before,
    .timeline-centered:after {
        content: " ";
        display: table;
    }

    .timeline-centered:after {
        clear: both;
    }

    .timeline-centered:before {
        content: '';
        position: absolute;
        display: block;
        width: 4px;
        background: #f5f5f6;
        /*left: 50%;*/
        top: 20px;
        bottom: 20px;
        margin-left: 30px;
    }

    .timeline-centered .timeline-entry {
        position: relative;
        /*width: 50%;
        float: right;*/
        margin-top: 5px;
        margin-left: 30px;
        margin-bottom: 30px;
        clear: both;
    }

    .timeline-centered .timeline-entry:before,
    .timeline-centered .timeline-entry:after {
        content: " ";
        display: table;
    }

    .timeline-centered .timeline-entry:after {
        clear: both;
    }

    .timeline-centered .timeline-entry:before,
    .timeline-centered .timeline-entry:after {
        content: " ";
        display: table;
    }

    .timeline-centered .timeline-entry:after {
        clear: both;
    }

    .timeline-centered .timeline-entry.begin {
        margin-bottom: 0;
    }

    .timeline-centered .timeline-entry.left-aligned {
        float: left;
    }

    .timeline-centered .timeline-entry.left-aligned .timeline-entry-inner {
        margin-left: 0;
        margin-right: -18px;
    }

    .timeline-centered .timeline-entry.left-aligned .timeline-entry-inner .timeline-time {
        left: auto;
        right: -100px;
        text-align: left;
    }

    .timeline-centered .timeline-entry.left-aligned .timeline-entry-inner .timeline-icon {
        float: right;
    }

    .timeline-centered .timeline-entry.left-aligned .timeline-entry-inner .timeline-label {
        margin-left: 0;
        margin-right: 70px;
    }

    .timeline-centered .timeline-entry.left-aligned .timeline-entry-inner .timeline-label:after {
        left: auto;
        right: 0;
        margin-left: 0;
        margin-right: -9px;
        -moz-transform: rotate(180deg);
        -o-transform: rotate(180deg);
        -webkit-transform: rotate(180deg);
        -ms-transform: rotate(180deg);
        transform: rotate(180deg);
    }

    .timeline-centered .timeline-entry .timeline-entry-inner {
        position: relative;
        margin-left: -20px;
    }

    .timeline-centered .timeline-entry .timeline-entry-inner:before,
    .timeline-centered .timeline-entry .timeline-entry-inner:after {
        content: " ";
        display: table;
    }

    .timeline-centered .timeline-entry .timeline-entry-inner:after {
        clear: both;
    }

    .timeline-centered .timeline-entry .timeline-entry-inner:before,
    .timeline-centered .timeline-entry .timeline-entry-inner:after {
        content: " ";
        display: table;
    }

    .timeline-centered .timeline-entry .timeline-entry-inner:after {
        clear: both;
    }

    .timeline-centered .timeline-entry .timeline-entry-inner .timeline-time {
        position: absolute;
        left: -100px;
        text-align: right;
        padding: 10px;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }

    .timeline-centered .timeline-entry .timeline-entry-inner .timeline-time>span {
        display: block;
    }

    .timeline-centered .timeline-entry .timeline-entry-inner .timeline-time>span:first-child {
        font-size: 15px;
        font-weight: bold;
    }

    .timeline-centered .timeline-entry .timeline-entry-inner .timeline-time>span:last-child {
        font-size: 12px;
    }

    .timeline-centered .timeline-entry .timeline-entry-inner .timeline-icon {
        background: #fff;
        color: #737881;
        display: block;
        width: 40px;
        height: 40px;
        -webkit-background-clip: padding-box;
        -moz-background-clip: padding;
        background-clip: padding-box;
        -webkit-border-radius: 20px;
        -moz-border-radius: 20px;
        border-radius: 20px;
        text-align: center;
        -moz-box-shadow: 0 0 0 5px #f5f5f6;
        -webkit-box-shadow: 0 0 0 5px #f5f5f6;
        box-shadow: 0 0 0 5px #f5f5f6;
        line-height: 40px;
        font-size: 15px;
        float: left;
    }

    .timeline-centered .timeline-entry .timeline-entry-inner .timeline-icon.bg-primary {
        background-color: #303641;
        color: #fff;
    }

    .timeline-centered .timeline-entry .timeline-entry-inner .timeline-icon.bg-secondary {
        background-color: #ee4749;
        color: #fff;
    }

    .timeline-centered .timeline-entry .timeline-entry-inner .timeline-icon.bg-success {
        background-color: #00a651;
        color: #fff;
    }

    .timeline-centered .timeline-entry .timeline-entry-inner .timeline-icon.bg-info {
        background-color: #21a9e1;
        color: #fff;
    }

    .timeline-centered .timeline-entry .timeline-entry-inner .timeline-icon.bg-warning {
        background-color: #fad839;
        color: #fff;
    }

    .timeline-centered .timeline-entry .timeline-entry-inner .timeline-icon.bg-danger {
        background-color: #cc2424;
        color: #fff;
    }

    .timeline-centered .timeline-entry .timeline-entry-inner .timeline-label {
        position: relative;
        background: #f5f5f6;
        padding: 1em;
        margin-left: 60px;
        -webkit-background-clip: padding-box;
        -moz-background-clip: padding;
        background-clip: padding-box;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        border-radius: 3px;
    }

    .timeline-centered .timeline-entry .timeline-entry-inner .timeline-label:after {
        content: '';
        display: block;
        position: absolute;
        width: 0;
        height: 0;
        border-style: solid;
        border-width: 9px 9px 9px 0;
        border-color: transparent #f5f5f6 transparent transparent;
        left: 0;
        top: 10px;
        margin-left: -9px;
    }

    .timeline-centered .timeline-entry .timeline-entry-inner .timeline-label h2,
    .timeline-centered .timeline-entry .timeline-entry-inner .timeline-label p {
        color: #737881;
        font-family: "Noto Sans", sans-serif;
        font-size: 12px;
        margin: 0;
        line-height: 1.428571429;
    }

    .timeline-centered .timeline-entry .timeline-entry-inner .timeline-label p+p {
        margin-top: 15px;
    }

    .timeline-centered .timeline-entry .timeline-entry-inner .timeline-label h2 {
        font-size: 16px;
        margin-bottom: 10px;
    }

    .timeline-centered .timeline-entry .timeline-entry-inner .timeline-label h2 a {
        color: #303641;
    }

    .timeline-centered .timeline-entry .timeline-entry-inner .timeline-label h2 span {
        -webkit-opacity: .6;
        -moz-opacity: .6;
        opacity: .6;
        -ms-filter: alpha(opacity=60);
        filter: alpha(opacity=60);
    }

    .view-btn {
        padding: 0px;
    }

    .view-btn i {
        padding: 3px 0;
        list-style: none;
        width: 35px;
        text-align: center;
        color: #fff;
        background: #4bb1d0;
        xpadding: 5px 10px;
        margin: 2px;
    }

    .view-btn i a {
        color: #fff;
        font-weight: bold;
    }
</style>
<? php // print_r($all_emp_leave);
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li class="active"><a href="#">Leaves</a></li>
        <li class="active"><a href="#">Leave Application List</a></li>
    </ul>
    <div class="page-header">
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Leave Application List</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">
                    <hr class="visible-xs no-grid-gutter-h">
                    <?php //if(in_array("Add", $my_privileges)) { 
                    ?>

                    <div class="visible-xs clearfix form-group-margin"></div>
                    <? php // } 
                    ?>
                    <?php //if(in_array("Search", $my_privileges)) { 
                    ?>

                    <?php //} 
                    ?>
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-sm-12">&nbsp;</div>
        </div>
        <div class="row ">
            <!-- tabs -->
            <div class="tabbable">
                <ul id="emptab" class="nav nav-tabs">
                    <?php
                    $a = $_GET['lt'];
                    if ($a == 'official') {
                        $b = 'active';
                    } elseif ($a == 'WFH') {
                        $c = 'active';
                    } else {
                        $a = 'active';
                    }
                    ?>
                    <li class="<?php echo $a; ?>"><a href="#leave" data-toggle="tab">Leave </a></li>
                    <li class="<?php echo $b; ?>"><a href="#od" data-toggle="tab">OD</a></li>
                    <li class="<?php echo $c; ?>"><a href="#wfh" data-toggle="tab">WFH</a></li>

                </ul>
                <div class="tab-content">
                    <div class="tab-pane <?php echo $a; ?> " id="leave">
                        <div class="col-sm-12">
                            <div class="panel">
                                <div class="panel-heading">

                                    <div class="row">
                                        <div class="col-md-6" class="form-control">
                                            <h4>
                                                For the Month of <span id="mon"><b><?php
                                                                                    date_default_timezone_set('Asia/Kolkata');
                                                                                    //echo $mon;
                                                                                    $ex = explode('-', $mon);
                                                                                    $st = $ex[1] . '-' . $ex[0];
                                                                                    if ($st != '-') {
                                                                                        echo date('F Y', strtotime($st));
                                                                                    } else {
                                                                                        echo date('F Y');
                                                                                    } ?></b></span></h4>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <label class="col-sm-3 text-right">Month: </label>
                                                <div class="col-md-3">
                                                    <input type="text" id="monthleave" name="month" class="form-control monthPicker" value="<?php echo $mon; ?>" />
                                                </div>
                                                <div class="col-md-3"><input type="button" id="find" onclick="search_emp_leves('leave')" class="btn btn-primary" value="Search">
                                                </div>
                                                <?php if ($_GET['sf'] != '') {
                                                    if ($_GET['sf'] == 'Pending') {
                                                        $p = 'selected';
                                                    } elseif ($_GET['sf'] == 'Approved') {
                                                        $a = 'selected';
                                                    } elseif ($_GET['sf'] == 'Forward') {
                                                        $f = 'selected';
                                                    } elseif ($_GET['sf'] == 'Rejected') {
                                                        $r = 'selected';
                                                    }
                                                }  ?>
                                                <div class="col-md-3"><select id="sfilter" onchange="filter_table(this.value)" class="form-control" name="sfilter">
                                                        <option value="">Status</option>
                                                        <option value="Approved" <?php echo $a; ?>>Approved</option>
                                                        <option value="Pending" <?php echo $p; ?>>Pending</option>
                                                        <option value="Forward" <?php echo $f; ?>>Forward</option>
                                                        <option value="Rejected" <?php echo $r; ?>>Rejected</option>
                                                    </select></div>


                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-1"></div>
                                    <div class="col-md-1"><b>Leave&nbsp;&nbsp;Application</b></div>
                                    <div class="col-md-1"></div>
                                    <div class="col-md-2">
                                        <select id="status_leave" name="status_leave" class="form-control">
                                            <option value="">Select</option>
                                            <option value="Rejected">Rejected</option>
                                            <option value="Approved">Approved</option>
                                        </select>
                                    </div>
                                    <input type='hidden' name='ltype' id='ltype' value='leave'>
                                    <div class="col-md-1"><button id="tapApply_leave" name="tapApply_leave" class="btn-primary btn tapApply_leave">Apply</button></div>
                                    <br />
                                </div>
                                <div class="panel-body" style="overflow-x:scroll;height:700px;">
                                    <div class="table-info">
                                        <?php //if(in_array("View", $my_privileges)) { 
                                        ?>
                                        <table class="table table-bordered leavetab">
                                            <thead>
                                                <tr>
                                                    <th width="3%">S.No</th>
                                                    <!-- <th width="3%">SLeave.No</th> -->
                                                    <th width="3%"><input type="checkbox" name="chk_stud_leave" id="chk_stud_leave"></th>
                                                    <th width="3%">App.Id</th>
                                                    <th width="5%">Emp.Id</th>
                                                    <th width="15%">Name</th>
                                                    <th width="5%">School</th>
                                                    <th width="8%">Department</th>
                                                    <th width="8%">Date</th>
                                                    <th width="5%">L.Type</th>
                                                    <th width="8%">Reason</th>
                                                    <th width="2%">Days</th>
                                                    <th width="8%">Applied on</th>
                                                    <th width="8%">Status</th>
                                                    <th width="3%">Details</th>
                                                    <?php if ($this->session->userdata("role_id") == 6 || $this->session->userdata("role_id") == 11) {
                                                    } else { ?>

                                                        <th width="10%">Action</th>
                                                    <?php } ?>

                                                </tr>
                                            </thead>
                                            <tbody id="itemContainer1">
                                                <?php
                                                //print_r($applicant_leave);

                                                if (empty($applicant_leave)) { ?>
                                                    <tr id="row441" class="odd" role="row">
                                                        <td colspan="13" class="center"><?php echo "No Leave Applications Available"; ?></td>
                                                    </tr>
                                                    <?php } else {
                                                    $i = 0;
                                                    //print_r($applicant);
                                                    foreach ($applicant_leave as $key => $val) {
                                                        if ($val['leave_type'] == 'WFH') {
                                                        } else {
                                                            $i++;
                                                    ?>
                                                            <tr id="row<?php echo $i; ?>" class="odd" role="row">
                                                                <td class="center"><?php echo $i; ?></td>
                                                                
                                                                
                                                                
                                                                <td class="center">
<?php
    $consider_hours = 0;
    foreach ($checked_hours as $row) {
        if (strtolower($row['leave_type']) === 'leave') {
            $consider_hours = (int)$row['consider_hours'];
            break;
        }
    }

    $inserted_time_str = $val['inserted_datetime'] ?? '';
    $inserted_time = strtotime($inserted_time_str);
    $current_time = time();
    $deadline = $inserted_time + ($consider_hours * 3600);

    $fstatus = $applicant_leave[$key]['fstatus'];

    if (
        $current_time <= $deadline &&
        ($fstatus === "Pending" || $fstatus === "Forward")
    ) {
?>
    <input type="checkbox"
        name="check_leave[]"
        id="check_leave"
        alt="<?php echo $applicant_leave[$key]['lid']; ?>"
        lang="<?php echo $fstatus; ?>"
        value="<?php echo $applicant_leave[$key]['lid']; ?>"
        class="studCheckBox_leave studpf_<?php echo $applicant_leave[$key]['lid']; ?>" />
<?php
    } else {
        echo '<i class="text-muted" title="Edit disabled after ' . $consider_hours . ' hours"></i>';
    }
?>
</td>


                                                                <!-- <td class="center">
                                                                    <?php //
                                                              //      if (($applicant_leave[$key]['fstatus'] == "Pending") || ($applicant_leave[$key]['fstatus'] == "Forward")) { ?>
                                                                        <input type="checkbox" name="check_leave[]" id="check_leave" alt="<?php // echo $applicant_leave[$key]['lid']; ?>" lang="<?php // echo $applicant_leave[$key]['fstatus']; ?>" value="<?php // echo $applicant_leave[$key]['lid']; ?>" class='studCheckBox_leave studpf_<?php // echo $applicant_leave[$key]['lid']; ?>' <?php // if ($applicant_leave[$key]['fstatus'] == 'Pending' || $applicant_leave[$key]['fstatus'] == 'Forward') {
                                                                                                                                                                                                                                                                                                                                                                                     //   echo '';
                                                                                                                                                                                                                                                                                                                                                                               //     } else {
                                                                                                                                                                                                                                                                                                                                                                                   //     echo 'disabled';
                                                                                                                                                                                                                                                                                                                                                                                 //  } ?> />
                                                                    <?php // } ?>
                                                                </td> -->
                                                                <td class="center"><?php echo $applicant_leave[$key]['lid']; ?></td>
                                                                <td class="center"><?php echo $applicant_leave[$key]['emp_id']; ?></td>
                                                                <td class="center sorting_1"><?php if ($applicant_leave[$key]['gender'] == 'male') {
                                                                                                    echo 'Mr.';
                                                                                                } else if ($applicant_leave[$key]['gender'] == 'female') {
                                                                                                    echo 'Mrs.';
                                                                                                } ?><?php echo $applicant_leave[$key]['fname'] . " " . $applicant_leave[$key]['lname']; ?></td>
                                                                <td class="center"><?= $applicant_leave[$key]['college_code'] ?></td>
                                                                <td class="center"><?= $applicant_leave[$key]['department_name'] ?></td>
                                                                <td class="center"><?php
                                                                                    if ($applicant_leave[$key]['applied_from_date'] == $applicant_leave[$key]['applied_to_date']) {
                                                                                        echo date('d/m/Y', strtotime($applicant_leave[$key]['applied_from_date']));
                                                                                    } else {
                                                                                        echo date('d/m/Y', strtotime($applicant_leave[$key]['applied_from_date'])) . " to " . date('d/m/Y', strtotime($applicant_leave[$key]['applied_to_date']));
                                                                                    }

                                                                                    //  echo date('d-m-Y',strtotime($applicant_leave[$key]['applied_from_date']))." - ".date('d-m-Y',strtotime($applicant_leave[$key]['applied_to_date']));


                                                                                    ?></td>
                                                                <td class="center">
                                                                    <?php //echo $val['leave_type'];
                                                                    if ($val['leave_type'] == 'lwp' || $val['leave_type'] == 'LWP') {
                                                                        //echo 'LWP';
                                                                        echo $lt = $this->leave_model->getLeaveTypeById1('9');
                                                                    } elseif ($val['leave_type'] == 'WFH') {
                                                                        echo $lt = $this->leave_model->getLeaveTypeById1('13');
                                                                    } else {

                                                                        $lt = $this->leave_model->getLeaveTypeById($val['leave_type']);
                                                                        // echo $this->db->last_query();
                                                                        if ($lt == 'VL') {
                                                                            $cnt =  $this->leave_model->get_vid_emp_allocation($val['leave_type']);

                                                                            echo $lt . " - " . $cnt[0]['slot_type'] . " ";
                                                                        } else {
                                                                            echo $lt;
                                                                        }
                                                                    }

                                                                    // print_r($l);

                                                                    ?></td>

                                                                <td class="center"><?php echo $applicant_leave[$key]['reason']; ?> </td>
                                                                <?php
                                                                if ($val['leave_apply_type'] == 'OD' && $applicant_leave[$key]['leave_duration'] == 'hrs') { ?>
                                                                    <td class="center"><?php echo $applicant_leave[$key]['no_hrs']; ?> hrs</td>
                                                                <?php } else { ?>
                                                                    <td class="center"><?php echo $applicant_leave[$key]['no_days']; ?></td>
                                                                <?php   } ?>
                                                                <td class="center"><?php echo date('d/m/Y', strtotime($applicant_leave[$key]['applied_on_date'])); ?></td>
                                                                <td class="center">
                                                                    <?php if ($applicant_leave[$key]['fstatus'] == 'Approved') {
                                                                        $var = 'label label-success';
                                                                    } elseif ($applicant_leave[$key]['fstatus'] == 'Rejected' || $applicant_leave[$key]['fstatus'] == 'Cancel') {
                                                                        $var = 'label label-danger';
                                                                    } elseif ($applicant_leave[$key]['fstatus'] == 'Pending') {
                                                                        $var = 'label label-warning';
                                                                    } elseif ($applicant_leave[$key]['fstatus'] == 'Forward') {
                                                                        $var = 'label label-primary';
                                                                    } ?><span id="<?php echo $applicant_leave[$key]['fstatus']; ?>" class="<?= $var; ?>">
                                                                        <?php echo $applicant_leave[$key]['fstatus'];
                                                                        ?></span></td>
                                                                <td class="view-btn">
                                                                    <?php
                                                                    echo "<a href='' id='" . $applicant_leave[$key]['lid'] . "' class='edetails' data-toggle='modal' data-target='#myModal' ><i class='fa fa-eye btn' aria-hidden='true' ></i></a>";

                                                                    if ($this->session->userdata("role_id") == 1) {
                                                                    ?>

                                                                        <a href="javascript:void(0)" id="" onclick="edit_timing(<?= $applicant_leave[$key]['lid'] ?>)"><i class="fa fa-edit"></i></a>
                                                                    <?php } ?>
                                                                </td>
                                                                <?php if ($this->session->userdata("role_id") == 6  || $this->session->userdata("role_id") == 11) {
                                                                } else { ?>

                                                                    <td class="view-btn">
                                                                        <?php if ($this->session->userdata("role_id") != 1) { ?>

                                                                            <p>
                                                                                <?php
                                                                                $uid = $this->session->userdata("name");
                                                                                $applicant_leave[$key]['emp1_reporting_person'];
                                                                                $uemp = '';
                                                                                if ($applicant_leave[$key]['emp1_reporting_person'] == $uid) {
                                                                                    $uemp = "emp1_reporting_status";
                                                                                } elseif ($applicant_leave[$key]['emp2_reporting_person'] == $uid) {
                                                                                    $uemp = "emp2_reporting_status";
                                                                                } elseif ($applicant_leave[$key]['emp3_reporting_person'] == $uid) {
                                                                                    $uemp = "emp3_reporting_status";
                                                                                } elseif ($applicant_leave[$key]['emp4_reporting_status'] == $uid) {
                                                                                    $uemp = "emp4_reporting_status";
                                                                                }
                                                                                if ($lt == 'ML') {
                                                                                    $ckml = $this->leave_model->check_ml_status($applicant_leave[$key]['lid']);
                                                                                } else {
                                                                                    $ckml = '';
                                                                                }
                                                                                //echo "kk".$uemp ;
                                                                                //echo $ckml;
                                                                                //echo $applicant_leave[$key]['applied_on_date'];

                                                                                if (($applicant_leave[$key]['fstatus'] != 'Approved') && (empty($applicant_leave[$key][$uemp]))) {
                                                                                    if ($lt == 'ML' && $ckml == 'false') {
                                                                                    } else {

                                                                                        //$applicant_leave[$key]['is_final']=='N'

                                                                                        if ($applicant_leave[$key]['is_final'] == 'N') {
                                                                                        } else {
                                                                                ?>
                                                                                    <?php
                                                                                    $consider_hours = 0;
                                                                                    foreach ($checked_hours as $row) {
                                                                                        if (strtolower($row['leave_type']) === 'leave') {
                                                                                            $consider_hours = (int)$row['consider_hours'];
                                                                                            break;
                                                                                        }
                                                                                    }

                                                                                    $inserted_time_str = $val['inserted_datetime'] ?? ''; // echo $inserted_time_str;
                                                                                    $inserted_time = strtotime($inserted_time_str);
                                                                                    $current_time = time();

                                                                                    $deadline = $inserted_time + ($consider_hours * 3600);

                                                                                    if ($current_time <= $deadline) {
                                                                                        echo '<a alt="Edit" href="' . base_url() . $currentModule . '/view_leave_application/' . $applicant_leave[$key]['lid'] . '"><i class="fa fa-edit btn"></i></a>';
                                                                                    } else {
                                                                                        echo '<i class="fa fa-lock text-muted" title="Edit disabled after ' . $consider_hours . ' hours"></i>';
                                                                                    }
                                                                                    ?>


                                                                                            <!-- <a alt="Edit" href="<?php // echo base_url() . $currentModule; ?>/view_leave_application/<?php echo $applicant_leave[$key]['lid']; ?>"><i class="fa fa-user btn"></i></a> -->
                                                                                <?php }
                                                                                    }
                                                                                }  ?>
                                                                            </p>

                                                                            <?php    }
                                                                        if ($applicant_leave[$key]['fstatus'] != 'Cancel' && $applicant_leave[$key]['fstatus'] != 'Rejected') {
                                                                            if ($this->session->userdata("role_id") == 1) { ?>
                                                                                <p> <a alt="Delete" href="<?php echo base_url() . $currentModule; ?>/view_leave_application/<?php echo $applicant_leave[$key]['lid']; ?>"><i class="fa fa-trash-o btn "></i> </a>
                                                                                </p>
                                                                        <?php }
                                                                        } ?>
                                                                    </td><?php } ?>
                                                            </tr>

                                                <?php }
                                                    }
                                                } ?>
                                            </tbody>
                                        </table>
                                        <?php if ($this->session->userdata("role_id") == 1 || $this->session->userdata("role_id") == 6 || $this->session->userdata("role_id") == 11) {
                                        } else { ?>

                                            <div class="col-md-3"><select id="selsts" class="form-control">
                                                    <option value="">Select</option>
                                                    <option value="approved">Action Taken</option>
                                                    <option value="pending">Action Pending</option>
                                                </select></div>
                                            <div class="col-md-1"><button id="tapexport" class="btn-primary btn">PDF</button></div>
                                            <div class="col-md-2"> <button id="taexport" class="btn-primary btn">Excel</button></div>

                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="tab-pane <?php echo $b; ?> " id="od">
                        <div class="col-sm-12">
                            <div class="panel">
                                <div class="panel-heading ">
                                    <div class="row">
                                        <div class="col-md-6" class="form-control">
                                            <h4>
                                                For the Month of <span id="mon"><b><?php
                                                                                    date_default_timezone_set('Asia/Kolkata');
                                                                                    //echo $mon;
                                                                                    $ex = explode('-', $mon);
                                                                                    $st = $ex[1] . '-' . $ex[0];
                                                                                    if ($st != '-') {
                                                                                        echo date('F Y', strtotime($st));
                                                                                    } else {
                                                                                        echo date('F Y');
                                                                                    } ?></b></span></h4>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <label class="col-sm-3 text-right">Month: </label>
                                                <div class="col-md-3">
                                                    <input type="text" id="monthofficial" name="month" class="form-control monthPicker" value="<?php echo $mon; ?>" />
                                                </div>
                                                <div class="col-md-3"><input type="button" id="find" onclick="search_emp_leves('official')" class="btn btn-primary" value="Search">
                                                </div>
                                                <div class="col-md-3"><select id="sfilter" onchange="filter_table(this.value)" class="form-control sfilter" name="sfilter">
                                                        <option value="">Status</option>
                                                        <option value="Approved">Approved</option>
                                                        <option value="Pending">Pending</option>
                                                        <option value="Forward">Forward</option>
                                                        <option value="Rejected">Rejected</option>
                                                    </select></div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-1"></div>
                                    <div class="col-md-1"><b>OD&nbsp;&nbsp;Application</b></div>
                                    <div class="col-md-1"></div>
                                    <div class="col-md-2">
                                        <select id="status_od" name="status_od" class="form-control">
                                            <option value="">Select</option>
                                            <option value="Rejected">Rejected</option>
                                            <option value="Approved">Approved</option>
                                        </select>
                                    </div>
                                    <?php  /*if($this->session->userdata("name")==110052)*/ { ?>
                                        <div class="col-md-1"><button id="tapApply_od" name="tapApply_od" class="btn-primary btn tapApply_od">Apply</button></div>
                                    <?php } ?>
                                    <br />
                                </div>
                                <div class="panel-body" style="overflow:scroll;height:700px;">
                                    <div class="table-info">
                                        <?php //if(in_array("View", $my_privileges)) { 
                                        ?>
                                        <table class="table table-bordered odtab">
                                            <thead>
                                                <tr>
                                                    <th width="3%">S.No</th>
                                                    <th width="3%"><input type="checkbox" name="chk_stud_od" id="chk_stud_od"></th>
                                                    <th width="3%">App.Id</th>
                                                    <th width="5%">Emp.Id</th>
                                                    <th width="15%">Name</th>
                                                    <th width="5%">School</th>
                                                    <th width="15%">Department</th>
                                                    <th width="8%">Date</th>
                                                    <th width="5%">L.Type</th>
                                                    <th width="30%">Reason</th>
                                                    <th width="5%">Days/Hrs</th>
                                                    <th width="10%">Applied on</th>
                                                    <th width="8%">Status</th>
                                                    <th width="3%">Details</th>
                                                    <?php if ($this->session->userdata("role_id") == 6 || $this->session->userdata("role_id") == 11) {
                                                    } else { ?>
                                                        <th width="10%">Action</th>
                                                    <?php } ?>

                                                </tr>
                                            </thead>
                                            <tbody id="itemContainer2">
                                                <?php if (empty($applicant_od)) { ?>
                                                    <tr id="row441" class="odd" role="row">
                                                        <td colspan="13" class=" center"><?php echo "No Leave Applications Available"; ?></td>
                                                    </tr>
                                                    <?php } else {
                                                    $i = 0;
                                                    //print_r($applicant);
                                                    foreach ($applicant_od as $key => $val) {

                                                        $i++;

                                                        $getallreporting = $this->leave_model->getallreporting($applicant_od[$key]['lid']);
                                                    ?>
                                                        <tr id="row<?php echo $i; ?>" class="odd" role="row">
                                                            <td class="center"><?php echo $i; ?></td>


                                                            <td class="center">
                                                            <?php
                                                                $consider_hours = 0;
                                                                foreach ($checked_hours as $row) {
                                                                    if (strtolower($row['leave_type']) === 'od') {
                                                                        $consider_hours = (int)$row['consider_hours'];
                                                                        break;
                                                                    }
                                                                }

                                                                $inserted_time_str = $val['inserted_datetime'] ?? '';
                                                                $inserted_time = strtotime($inserted_time_str);
                                                                $current_time = time();
                                                                $deadline = $inserted_time + ($consider_hours * 3600);

                                                                $fstatus = $applicant_od[$key]['fstatus'];

                                                                if (
                                                                    $current_time <= $deadline &&
                                                                    ($fstatus === "Pending" || $fstatus === "Forward")
                                                                ) {
                                                            ?>
                                                                <input type="checkbox"
                                                                    name="check_od[]"
                                                                    id="check_od"
                                                                    alt="<?php echo $applicant_od[$key]['lid']; ?>"
                                                                    lang="<?php echo $fstatus; ?>"
                                                                    value="<?php echo $applicant_od[$key]['lid']; ?>"
                                                                    class="studCheckBox_od studpf_<?php echo $applicant_od[$key]['lid']; ?>" />
                                                            <?php
                                                                } else {
                                                                    echo '<i class="text-muted" title="Edit disabled after ' . $consider_hours . ' hours"></i>';
                                                                }
                                                            ?>
                                                            </td>



                                                            <!-- <td class="center">

                                                                <?php //if(in_array($uid,$getallreporting))
                                                                { //if(($applicant_leave[$key]['fstatus']=="Pending")||($applicant_leave[$key]['fstatus']=="Forward")){
                                                                ?>
                                                                    <input type="checkbox" name="check_od[]" id="check_od" alt="<?php echo $applicant_od[$key]['lid']; ?>" lang="<?php echo $applicant_od[$key]['fstatus']; ?>" value="<?php echo $applicant_od[$key]['lid']; ?>" class='studCheckBox_od studpf_<?php echo $applicant_od[$key]['lid']; ?>' />
                                                                <?php } ?>
                                                            </td> -->
                                                            <td class="center"><?php echo $applicant_od[$key]['lid']; ?> <?php  //echo $dc=($applicant_od[$key]['od_document']);
                                                                                                                            ?></td>
                                                            <td class="center"><?php echo $applicant_od[$key]['emp_id']; ?></td>

                                                            <td class="center sorting_1"><?php if ($applicant_od[$key]['gender'] == 'male') {
                                                                                                echo 'Mr.';
                                                                                            } else if ($applicant_od[$key]['gender'] == 'female') {
                                                                                                echo 'Mrs.';
                                                                                            } ?><?php echo $applicant_od[$key]['fname'] . " " . $applicant_od[$key]['lname']; ?></td>
                                                            <td><?= $applicant_od[$key]['college_code'] ?></td>
                                                            <td><?= $applicant_od[$key]['department_name'] ?></td>
                                                            <td class="center"><?php
                                                                                if ($applicant_od[$key]['applied_from_date'] == $applicant_od[$key]['applied_to_date']) {
                                                                                    echo date('d/m/Y', strtotime($applicant_od[$key]['applied_from_date']));
                                                                                } else {
                                                                                    echo date('d/m/Y', strtotime($applicant_od[$key]['applied_from_date'])) . " to " . date('d/m/Y', strtotime($applicant_od[$key]['applied_to_date']));
                                                                                }

                                                                                //echo date('d-m-Y',strtotime($applicant_od[$key]['applied_from_date']))." - ".date('d-m-Y',strtotime($applicant_od[$key]['applied_to_date']));
                                                                                ?>
                                                            </td>

                                                            <td class="center"><?php echo 'OD'; ?>

                                                                <?php

                                                                //echo $this->awssdk->getsignedurl("Upload/get_document/".$applicant_od[$key]['od_document']);
                                                                ?>

                                                                <?php if (empty($applicant_od[$key]['od_document'])) {
                                                                } else { ?><a href="<?= site_url() ?>Upload/get_document/<?php echo $applicant_od[$key]['od_document'] . '?b_name=' . $bucketname;  ?>" target="_blank">Click Here-------</a><?php } ?></td>

                                                            <!--<a href="<?= site_url() ?>Upload/get_document/<?php echo $applicant_od[$key]['od_document'] . '?b_name=' . $bucketname;  ?>" target="_blank">View</a>-->

                                                            <td class="center"><?php echo $applicant_od[$key]['reason']; ?><br /></td>
                                                            <?php if ($val['leave_apply_type'] == 'OD' && $applicant_od[$key]['leave_duration'] == 'hrs') { ?>
                                                                <td class="center"><?php echo $applicant_od[$key]['no_hrs']; ?> Hrs</td>
                                                            <?php } else { ?>
                                                                <td class="center"><?php echo $applicant_od[$key]['no_days']; ?></td>
                                                            <?php   } ?>
                                                            <td class="center"><?php echo date('d/m/Y', strtotime($applicant_od[$key]['applied_on_date'])); ?></td>
                                                            <td class="center">
                                                                <?php if ($applicant_od[$key]['fstatus'] == 'Approved') {
                                                                    $var = 'label label-success';
                                                                } elseif ($applicant_od[$key]['fstatus'] == 'Rejected' || $applicant_od[$key]['fstatus'] == 'Cancel') {
                                                                    $var = 'label label-danger';
                                                                } elseif ($applicant_od[$key]['fstatus'] == 'Pending') {
                                                                    $var = 'label label-warning';
                                                                } elseif ($applicant_od[$key]['fstatus'] == 'Forward') {
                                                                    $var = 'label label-primary';
                                                                }


                                                                ?><span id="<?php echo $applicant_od[$key]['fstatus']; ?>" class="<?= $var; ?>">
                                                                    <?php echo $applicant_od[$key]['fstatus'];
                                                                    ?></span></td>
                                                            <td class="center view-btn">
                                                                <?php
                                                                echo "<a href='' id='" . $applicant_od[$key]['lid'] . "' class='edetails' data-toggle='modal' data-target='#myModal' ><i class='fa fa-eye' aria-hidden='true' ></i></a>";

                                                                if ($this->session->userdata("role_id") == 1) {
                                                                ?>
                                                                    <a href="javascript:void(0)" id="" onclick="edit_timing(<?= $applicant_od[$key]['lid'] ?>)"><i class="fa fa-edit"></i></a>
                                                                <?php } ?>
                                                            </td>
                                                            <?php if ($this->session->userdata("role_id") == 6 ||  $this->session->userdata("role_id") == 11) {
                                                            } else { ?>
                                                                <td class="center view-btn">
                                                                    <?php if ($this->session->userdata("role_id") != 1) { ?>

                                                                        <p>
                                                                            <?php
                                                                            $uid = $this->session->userdata("name");
                                                                            $uemp = '';
                                                                            if ($applicant_od[$key]['emp1_reporting_person'] == $uid) {
                                                                                $uemp = "emp1_reporting_status";
                                                                            } elseif ($applicant_od[$key]['emp2_reporting_person'] == $uid) {
                                                                                $uemp = "emp2_reporting_status";
                                                                            } elseif ($applicant_od[$key]['emp3_reporting_person'] == $uid) {
                                                                                $uemp = "emp3_reporting_status";
                                                                            } elseif ($applicant_od[$key]['emp4_reporting_status'] == $uid) {
                                                                                $uemp = "emp4_reporting_status";
                                                                            }
                                                                            //  echo "kk".$applicant_od[$key][$uemp];
                                                                            // echo "kk".$uemp ;

                                                                            //print_r($getallreporting);

                                                                            if (($applicant_od[$key]['fstatus'] != 'Approved') && (empty($applicant_od[$key][$uemp]))) {
                                                                                //  if(in_array($uid,$getallreporting))
                                                                                {
                                                                                    if ($applicant_leave[$key]['is_final'] == 'N') {
                                                                                    } else {
                                                                            ?>

<?php
                                                                                    $consider_hours = 0;
                                                                                    foreach ($checked_hours as $row) {
                                                                                        if (strtolower($row['leave_type']) === 'od') {
                                                                                            $consider_hours = (int)$row['consider_hours'];
                                                                                            break;
                                                                                        }
                                                                                    }
                                                                                

                                                                                    $inserted_time_str = $val['inserted_datetime'] ?? '';
                                                                                    $inserted_time = strtotime($inserted_time_str);
                                                                                    $current_time = time();

                                                                                    $deadline = $inserted_time + ($consider_hours * 3600);

                                                                                    if ($current_time <= $deadline) {
                                                                                        echo '<a alt="Edit" href="' . base_url() . $currentModule . '/view_leave_application/' . $applicant_od[$key]['lid'] . '"><i class="fa fa-edit btn"></i></a>';
                                                                                    } else {
                                                                                        echo '<i class="fa fa-lock text-muted" title="Edit disabled after ' . $consider_hours . ' hours"></i>';
                                                                                    }
                                                                                    ?>

                                                                                        <!-- <a alt="edit" href="<?php // echo base_url() . $currentModule; ?>/view_leave_application/<?php echo $applicant_od[$key]['lid']; ?>"><i class="fa fa-user"></i></a> -->
                                                                            <?php }
                                                                                }
                                                                            } ?>
                                                                        </p>
                                                                        <?php    }
                                                                    if ($applicant_od[$key]['fstatus'] != 'Cancel' && $applicant_od[$key]['fstatus'] != 'Rejected') {
                                                                        if ($this->session->userdata("role_id") == 1) { ?>
                                                                            <p> <a alt="Delete" href="<?php echo base_url() . $currentModule; ?>/view_leave_application/<?php echo $applicant_od[$key]['lid']; ?>"><i class="fa fa-trash-o"></i> </a>
                                                                            </p>
                                                                    <?php }
                                                                    } ?>
                                                                </td>
                                                            <?php } ?>

                                                        </tr>

                                                <?php }
                                                } ?>
                                            </tbody>
                                        </table>
                                        <?php if ($this->session->userdata("role_id") == 1 || $this->session->userdata("role_id") == 6 || $this->session->userdata("role_id") == 11 || $this->session->userdata("role_id") == 7) {
                                        } else { ?>
                                            <div class="col-md-3"><select id="selstsod" class="form-control">
                                                    <option value="">Select</option>
                                                    <option value="approved">Action Taken</option>
                                                    <option value="pending">Action Pending</option>
                                                </select></div>
                                            <div class="col-md-1"><button id="tapexportod" class="btn-primary btn">PDF</button></div>
                                            <div class="col-md-2"> <button id="taexportod" class="btn-primary btn">Excel</button></div>

                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="tab-pane <?php echo $c; ?> " id="wfh">
                        <div class="col-sm-12">
                            <div class="panel">
                                <div class="panel-heading">

                                    <div class="row">
                                        <div class="col-md-6" class="form-control">
                                            <h4>
                                                For the Month of <span id="mon"><b><?php
                                                                                    date_default_timezone_set('Asia/Kolkata');
                                                                                    //echo $mon;
                                                                                    $ex = explode('-', $mon);
                                                                                    $st = $ex[1] . '-' . $ex[0];
                                                                                    if ($st != '-') {
                                                                                        echo date('F Y', strtotime($st));
                                                                                    } else {
                                                                                        echo date('F Y');
                                                                                    } ?></b></span></h4>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <label class="col-sm-3 text-right">Month: </label>
                                                <div class="col-md-3">
                                                    <input type="text" id="monthWFH" name="month" class="form-control monthPicker" value="<?php echo $mon; ?>" />
                                                </div>
                                                <div class="col-md-3"><input type="button" id="find" onclick="search_emp_leves('WFH')" class="btn btn-primary" value="Search">
                                                </div>
                                                <?php if ($_GET['sf'] != '') {
                                                    if ($_GET['sf'] == 'Pending') {
                                                        $p = 'selected';
                                                    } elseif ($_GET['sf'] == 'Approved') {
                                                        $a = 'selected';
                                                    } elseif ($_GET['sf'] == 'Forward') {
                                                        $f = 'selected';
                                                    } elseif ($_GET['sf'] == 'Rejected') {
                                                        $r = 'selected';
                                                    }
                                                }  ?>
                                                <div class="col-md-3"><select id="sfilter" onchange="filter_table(this.value)" class="form-control sfilter" name="sfilter">
                                                        <option value="">Status</option>
                                                        <option value="Approved" <?php echo $a; ?>>Approved</option>
                                                        <option value="Pending" <?php echo $p; ?>>Pending</option>
                                                        <option value="Forward" <?php echo $f; ?>>Forward</option>
                                                        <option value="Rejected" <?php echo $r; ?>>Rejected</option>
                                                    </select></div>


                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-1"></div>
                                    <div class="col-md-1">Status&nbsp;Of&nbsp;Application</div>
                                    <div class="col-md-2">
                                        <select id="status" name="status" class="form-control">
                                            <option value="">Select</option>
                                            <option value="Rejected">Rejected</option>
                                            <option value="Approved">Approved</option>
                                        </select>
                                    </div>
                                    <?php  /*if($this->session->userdata("name")==110052)*/ { ?>
                                        <div class="col-md-1"><button id="tapApply" name="tapApply" class="btn-primary btn tapApply">Apply</button></div>
                                    <?php } ?>
                                    <br />
                                </div>
                                <div class="panel-body" style="overflow-x:scroll;height:700px;">
                                    <div class="table-info">
                                        <?php //if(in_array("View", $my_privileges)) { 
                                        ?>
                                        <table class="table table-bordered wfhtab">
                                            <thead>
                                                <tr>
                                                    <th width="3%">SWFH.No</th>
                                                    <th width="3%"><input type="checkbox" name="chk_stud_all" id="chk_stud_all"></th>
                                                    <th width="3%">App.Id</th>
                                                    <th width="5%">Emp.Id</th>
                                                    <th width="15%">Name</th>
                                                    <th width="5%">School</th>
                                                    <th width="10%">Department</th>
                                                    <th width="8%">Date</th>
                                                    <th width="5%">L.Type</th>
                                                    <th width="30%">Reason</th>
                                                    <th width="2%">Days</th>
                                                    <th width="8%">Applied on</th>
                                                    <th width="8%">Status</th>
                                                    <th width="3%">Details</th>
                                                    <?php if ($this->session->userdata("role_id") == 6 || $this->session->userdata("role_id") == 11) {
                                                    } else { ?>

                                                        <th width="10%">Action</th>
                                                    <?php } ?>

                                                </tr>
                                            </thead>
                                            <tbody id="itemContainer3">
                                                <?php
                                                //print_r($applicant_leave);

                                                if (empty($applicant_leave)) { ?>
                                                    <tr id="row441" class="odd" role="row">
                                                        <td colspan="13" class="center"><?php echo "No Leave Applications Available"; ?></td>
                                                    </tr>
                                                    <?php } else {
                                                    $i = 0;
                                                    //print_r($applicant);
                                                    foreach ($applicant_leave as $key => $val) {
                                                        if ($val['leave_type'] == 'WFH') {
                                                            $i++;
                                                    ?>
                                                            <tr id="row<?php echo $i; ?>" class="odd" role="row">
                                                                <td class="center"><?php echo $i; ?></td>


                                                                <td class="center">


                                                            <?php
                                                                $consider_hours = 0;
                                                                foreach ($checked_hours as $row) {
                                                                    if (strtolower($row['leave_type']) === 'wfh') {
                                                                        $consider_hours = (int)$row['consider_hours'];
                                                                        break;
                                                                    }
                                                                }

                                                                $inserted_time_str = $val['inserted_datetime'] ?? '';
                                                                $inserted_time = strtotime($inserted_time_str);
                                                                $current_time = time();
                                                                $deadline = $inserted_time + ($consider_hours * 3600);

                                                                $fstatus = $applicant_leave[$key]['fstatus'];

                                                                if (
                                                                    $current_time <= $deadline &&
                                                                    ($fstatus === "Pending" || $fstatus === "Forward")
                                                                ) {
                                                            ?>
                                                                <input type="checkbox"
                                                                    name="check_wfh[]"
                                                                    id="check_wfh"
                                                                    alt="<?php echo $applicant_leave[$key]['lid']; ?>"
                                                                    lang="<?php echo $fstatus; ?>"
                                                                    value="<?php echo $applicant_leave[$key]['lid']; ?>"
                                                                    class="studCheckBox studpf_<?php echo $applicant_leave[$key]['lid']; ?>" />
                                                            <?php
                                                                } else {
                                                                    echo '<i class="text-muted" title="Edit disabled after ' . $consider_hours . ' hours"></i>';
                                                                }
                                                            ?>
                                                            </td>





                                                                <!-- <td class="center">
                                                                    <?php // if (($applicant_leave[$key]['fstatus'] == "Pending") || ($applicant_leave[$key]['fstatus'] == "Forward")) { ?>
                                                                        <input type="checkbox" name="check_wfh[]" id="check_wfh" alt="<?php // echo $applicant_leave[$key]['lid']; ?>" lang="<?php // echo $applicant_leave[$key]['fstatus']; ?>" value="<?php // echo $applicant_leave[$key]['lid']; ?>" class='studCheckBox studpf_<?php // echo $applicant_leave[$key]['lid']; ?>' />
                                                                    <?php // } ?>
                                                                </td> -->
                                                                <td class="center"><?php echo $applicant_leave[$key]['lid']; ?></td>
                                                                <td class="center"><?php echo $applicant_leave[$key]['emp_id']; ?></td>
                                                                <td class="center sorting_1"><?php if ($applicant_leave[$key]['gender'] == 'male') {
                                                                                                    echo 'Mr.';
                                                                                                } else if ($applicant_leave[$key]['gender'] == 'female') {
                                                                                                    echo 'Mrs.';
                                                                                                } ?><?php echo $applicant_leave[$key]['fname'] . " " . $applicant_leave[$key]['lname']; ?></td>
                                                                <td class="center"><?= $applicant_leave[$key]['college_code'] ?></td>
                                                                <td class="center"><?= $applicant_leave[$key]['department_name'] ?></td>
                                                                <td class="center"><?php
                                                                                    if ($applicant_leave[$key]['applied_from_date'] == $applicant_leave[$key]['applied_to_date']) {
                                                                                        echo date('d/m/Y', strtotime($applicant_leave[$key]['applied_from_date']));
                                                                                    } else {
                                                                                        echo date('d/m/Y', strtotime($applicant_leave[$key]['applied_from_date'])) . " to " . date('d/m/Y', strtotime($applicant_leave[$key]['applied_to_date']));
                                                                                    }

                                                                                    //  echo date('d-m-Y',strtotime($applicant_leave[$key]['applied_from_date']))." - ".date('d-m-Y',strtotime($applicant_leave[$key]['applied_to_date']));


                                                                                    ?></td>
                                                                <td class="center">
                                                                    <?php //echo $val['leave_type'];
                                                                    if ($val['leave_type'] == 'lwp' || $val['leave_type'] == 'LWP') {
                                                                        //echo 'LWP';
                                                                        echo $lt = $this->leave_model->getLeaveTypeById1('9');
                                                                    } elseif ($val['leave_type'] == 'WFH') {
                                                                        echo $lt = $this->leave_model->getLeaveTypeById1('13');
                                                                    } else {
                                                                        $lt = $this->leave_model->getLeaveTypeById($val['leave_type']);
                                                                        if ($lt == 'VL') {
                                                                            $cnt =  $this->leave_model->get_vid_emp_allocation($val['leave_type']);

                                                                            echo $lt . " - " . $cnt[0]['slot_type'] . " ";
                                                                        } else {
                                                                            echo $lt;
                                                                        }
                                                                    }

                                                                    ?></td>

                                                                <td class="center"><?php echo $applicant_leave[$key]['reason']; ?></td>
                                                                <?php
                                                                if ($val['leave_apply_type'] == 'OD' && $applicant_leave[$key]['leave_duration'] == 'hrs') { ?>
                                                                    <td class="center"><?php echo $applicant_leave[$key]['no_hrs']; ?> hrs</td>
                                                                <?php } else { ?>
                                                                    <td class="center"><?php echo $applicant_leave[$key]['no_days']; ?></td>
                                                                <?php   } ?>
                                                                <td class="center"><?php echo date('d/m/Y', strtotime($applicant_leave[$key]['applied_on_date'])); ?></td>
                                                                <td class="center">
                                                                    <?php if ($applicant_leave[$key]['fstatus'] == 'Approved') {
                                                                        $var = 'label label-success';
                                                                    } elseif ($applicant_leave[$key]['fstatus'] == 'Rejected' || $applicant_leave[$key]['fstatus'] == 'Cancel') {
                                                                        $var = 'label label-danger';
                                                                    } elseif ($applicant_leave[$key]['fstatus'] == 'Pending') {
                                                                        $var = 'label label-warning';
                                                                    } elseif ($applicant_leave[$key]['fstatus'] == 'Forward') {
                                                                        $var = 'label label-primary';
                                                                    } ?><span id="<?php echo $applicant_leave[$key]['fstatus']; ?>" class="<?= $var; ?>">
                                                                        <?php echo $applicant_leave[$key]['fstatus'];
                                                                        ?></span></td>
                                                                <td class="view-btn">
                                                                    <?php
                                                                    echo "<a href='' id='" . $applicant_leave[$key]['lid'] . "' class='edetails' data-toggle='modal' data-target='#myModal' ><i class='fa fa-eye btn' aria-hidden='true' ></i></a>";
                                                                    if ($this->session->userdata("role_id") == 1) {

                                                                    ?>
                                                                        <a href="javascript:void(0)" id="" onclick="edit_timing(<?= $applicant_leave[$key]['lid'] ?>)"><i class="fa fa-edit"></i></a>
                                                                    <?php } ?>
                                                                </td>
                                                                <?php if ($this->session->userdata("role_id") == 6  || $this->session->userdata("role_id") == 11) {
                                                                } else { ?>

                                                                    <td class="view-btn">
                                                                        <?php if ($this->session->userdata("role_id") != 1) { ?>

                                                                            <p>
                                                                                <?php
                                                                                $uid = $this->session->userdata("name");
                                                                                $uemp = '';
                                                                                if ($applicant_leave[$key]['emp1_reporting_person'] == $uid) {
                                                                                    $uemp = "emp1_reporting_status";
                                                                                } elseif ($applicant_leave[$key]['emp2_reporting_person'] == $uid) {
                                                                                    $uemp = "emp2_reporting_status";
                                                                                } elseif ($applicant_leave[$key]['emp3_reporting_person'] == $uid) {
                                                                                    $uemp = "emp3_reporting_status";
                                                                                } elseif ($applicant_leave[$key]['emp4_reporting_status'] == $uid) {
                                                                                    $uemp = "emp4_reporting_status";
                                                                                }
                                                                                if ($lt == 'ML') {
                                                                                    $ckml = $this->leave_model->check_ml_status($applicant_leave[$key]['lid']);
                                                                                } else {
                                                                                    $ckml = '';
                                                                                }
                                                                                //echo "kk".$uemp ;
                                                                                //echo $ckml;
                                                                                //echo $applicant_leave[$key]['applied_on_date'];

                                                                                if (($applicant_leave[$key]['fstatus'] != 'Approved' || $applicant_leave[$key]['fstatus'] != 'Cancel') && empty($applicant_leave[$key][$uemp])) {
                                                                                    if ($lt == 'ML' && $ckml == 'false') {
                                                                                    } else {
                                                                                ?>


<?php
                                                                                    $consider_hours = 0;
                                                                                    foreach ($checked_hours as $row) {
                                                                                        if (strtolower($row['leave_type']) === 'wfh') {
                                                                                            $consider_hours = (int)$row['consider_hours'];
                                                                                            break;
                                                                                        }
                                                                                    }
                                                                                
                                                                                    $inserted_time_str = $val['inserted_datetime'] ?? '';
                                                                                    $inserted_time = strtotime($inserted_time_str);
                                                                                    $current_time = time();

                                                                                    $deadline = $inserted_time + ($consider_hours * 3600);

                                                                                    if ($current_time <= $deadline) {
                                                                                        echo '<a alt="Edit" href="' . base_url() . $currentModule . '/view_leave_application/' . $applicant_leave[$key]['lid'] . '"><i class="fa fa-edit btn"></i></a>';
                                                                                    } else {
                                                                                        echo '<i class="fa fa-lock text-muted" title="Edit disabled after ' . $consider_hours . ' hours"></i>';
                                                                                    }
                                                                                    ?>

                                                                                        <!-- <a alt="Edit" href="<?php echo base_url() . $currentModule; ?>/view_leave_application/<?php echo $applicant_leave[$key]['lid']; ?>"><i class="fa fa-user btn"></i></a> -->
                                                                                <?php }
                                                                                }  ?>
                                                                            </p>

                                                                            <?php    }
                                                                        if ($applicant_leave[$key]['fstatus'] != 'Cancel' && $applicant_leave[$key]['fstatus'] != 'Rejected') {
                                                                            if ($this->session->userdata("role_id") == 1) { ?>
                                                                                <p> <a alt="Delete" href="<?php echo base_url() . $currentModule; ?>/view_leave_application/<?php echo $applicant_leave[$key]['lid']; ?>"><i class="fa fa-trash-o btn "></i> </a>
                                                                                </p>
                                                                        <?php }
                                                                        } ?>
                                                                    </td><?php } ?>
                                                            </tr>

                                                <?php }
                                                    }
                                                } ?>
                                            </tbody>
                                        </table>



                                        <div class="row">&nbsp;</div>

                                        <?php if ($this->session->userdata("role_id") == 1 || $this->session->userdata("role_id") == 6 || $this->session->userdata("role_id") == 11) {
                                        } else { ?>
                                            <div class="row">
                                                <div class="col-md-5"></div>
                                                <div class="col-md-3">
                                                    <select id="selsts" class="form-control">
                                                        <option value="">Select</option>
                                                        <option value="approved">Action Taken</option>
                                                        <option value="pending">Action Pending</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-1"><button id="tapexport" class="btn-primary btn">PDF</button></div>
                                                <div class="col-md-2"> <button id="taexport" class="btn-primary btn">Excel</button></div>
                                            </div>

                                        <?php } ?>

                                    </div>

                                </div>

                            </div>
                        </div>


                    </div>
                </div>




            </div>
        </div>
        <!-- /tabs -->


    </div>
</div>
</div>
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content" id="edata">

        </div>

    </div>
</div>
<div id="updatetiming" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn btn-default pull-right" data-dismiss="modal">&times;</button>
                <p class="modal-title">APP_ID: <strong>
                        <h5 id="appidd"></h5>
                    </strong>
                </p>
            </div>
            <div class="modal-body">
                <div class="row table-responsive">

                    <div class="form-group">
                        <div>
                            <label for="fdate" class="col-form-label">From Date:</label>
                            <input type="date" class="form-control" id="fdate">
                        </div>
                    </div>
                    <div class="form-group">
                        <div>
                            <label for="tdate" class="col-form-label">To Date:</label>
                            <input type="date" class="form-control" id="tdate">
                            <input type="hidden" class="form-control" id="app_id">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-2">
                            <label for="tdays" class="col-form-label">Total Days:</label>
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control" id="tdays">
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-default" onclick="update_time()">Submit</button>
            </div>
        </div>
    </div>
</div>

<script>
    <?php if ($_GET['sf'] != '') { ?>
        filter_table('<?php echo $_GET['sf']; ?>');
    <?php } ?>

    function filter_table(s) {
        var target = $("ul#emptab li.active a").attr('href');
        var tableBody = $(target + " .table-bordered tbody").attr('id');
        var k = 1;
        var tableRowsClass = $(target + " .table-bordered tbody tr");
   
        tableRowsClass.each(function(i, val) {
            //alert(i+'--'+val);
            if (tableBody == "itemContainer3" || tableBody == "itemContainer1" || tableBody == "itemContainer2") {


                var rowText = $(this).find("td").eq(12).find("span").attr('id');

            } else {
                var rowText = $(this).find("td").eq(11).find("span").attr('id');
            }

            if (s != '') {
                if (s == rowText) {

                    $(this).find("td").eq(0).html(k);
                    var sf = $(this).find("td").eq(13).find("a").attr('href');
                    //alert(sf); 
                    $(this).find("td").eq(13).find("a").attr('href', sf + '/' + s);
                    tableRowsClass.eq(i).show();
                    k = k + 1;
                } else {
                    tableRowsClass.eq(i).hide();

                }
            } else {
                tableRowsClass.eq(i).show();
            }

        });

    }

    function search_emp_leves(lt) {
        var month = $('#month' + lt).val();
        url = "<?php echo base_url() . $currentModule; ?>/leave_applicant_list/" + month + "/?lt=" + lt;
        window.location = url;
    }
    $(function() {
        $('.monthPicker').datepicker({
            autoclose: true,
            minViewMode: 1,
            format: 'mm-yyyy',
            onClose: function(dateText, inst) {
                var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                $(this).datepicker('setDate', new Date(year, month, 1));
            }
        });
    });
    $(document).ready(function() {
        var ids = [];

        $('#chk_stud_leave').change(function() {

            var sfilter = $(".sfilter").val();
            if (sfilter != '') {
                // if($('input[id="chk_stud_all"]:checked')){
                if ($('input[id="chk_stud_leave"]').is(':checked')) {
                    $('input[id="check_leave"]').each(function() {

                        if (sfilter == this.lang) {
                            ids.push(this.lang + '' + this.alt);
                            // $('.studCheckBox').prop('checked', $(this).prop('checked'));
                            $('.studpf_' + this.alt).prop('checked', 'checked');
                        }
                    });
                    console.log(ids);
                } else {
                    //  alert();
                    // $('.studpf_'+this.alt).prop('checked', $(this).prop('checked'));
                    $('.studCheckBox_leave').prop('checked', false).removeAttr('checked');
                    //$('.studCheckBox').prop('checked',false);
                }
            } else {
                $('.studCheckBox_leave').prop('checked', $(this).prop('checked'));
            }
        });


        $('.tapApply_leave').click(function() {

            var status = $("#status_leave").val();
            var ltype = $("#ltype").val();
            var urln = "<?= base_url() . strtolower($currentModule) . '/Leave/leave_applicant_list' ?>";
            var chk_checked = [];
            $.each($("input[name='check_leave[]']:checked"), function() {
                chk_checked.push($(this).val());
            });
            var arr_length = chk_checked.length;
            if (arr_length == 0) {
                alert("Please select at least One Employee");
                return false;
            }

            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>leave/update_leave_application_group_od',
                data: {
                    chk_checkedf: chk_checked,
                    status: status,
                    ltype: ltype
                },
                success: function(html) {
                    alert("Successfully Applied");
                    // Simulate a mouse click:
                    window.location.href = $urln;
                    //$('#stream_id').html(html);
                }
            });
        });

        $('#chk_stud_all').change(function() {

            var sfilter = $(".sfilter").val();
            if (sfilter != '') {
                // if($('input[id="chk_stud_all"]:checked')){
                if ($('input[id="chk_stud_all"]').is(':checked')) {
                    $('input[id="check_wfh"]').each(function() {

                        if (sfilter == this.lang) {
                            ids.push(this.lang + '' + this.alt);
                            // $('.studCheckBox').prop('checked', $(this).prop('checked'));
                            $('.studpf_' + this.alt).prop('checked', 'checked');
                        }
                    });
                    console.log(ids);
                } else {
                    //  alert();
                    // $('.studpf_'+this.alt).prop('checked', $(this).prop('checked'));
                    $('.studCheckBox').prop('checked', false).removeAttr('checked');
                    //$('.studCheckBox').prop('checked',false);
                }
            } else {
                $('.studCheckBox').prop('checked', $(this).prop('checked'));
            }

        });


        $('.tapApply').click(function() {
            //	alert();
            var status = $("#status").val();
            var chk_checked = [];
            $.each($("input[name='check_wfh[]']:checked"), function() {
                chk_checked.push($(this).val());
            });
            var arr_length = chk_checked.length;
            if (arr_length == 0) {
                alert("Please select at least One Employee");
                return false;
            }

            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>leave/update_leave_application_group',
                data: {
                    chk_checkedf: chk_checked,
                    status: status
                },
                success: function(html) {
                    alert("Successfully Applied");
                    // Simulate a mouse click:
                    window.location.href = "https://erp.sandipuniversity.com/Leave/leave_applicant_list?lt=WFH&sf=";
                    //$('#stream_id').html(html);
                }
            });

        });



        $('#chk_stud_od').change(function() {

            var sfilter = $(".sfilter").val();
            if (sfilter != '') {
                if ($('input[id="chk_stud_od"]').is(':checked')) {
                    $('input[id="check_od"]').each(function() {

                        if (sfilter == this.lang) {
                            ids.push(this.lang + '' + this.alt);
                            // $('.studCheckBox').prop('checked', $(this).prop('checked'));
                            $('.studpf_' + this.alt).prop('checked', 'checked');
                        }
                    });
                    console.log(ids);
                } else {


                    $('.studCheckBox_od').prop('checked', false).removeAttr('checked');
                }
            } else {
                $('.studCheckBox_od').prop('checked', $(this).prop('checked'));
            }



        });




        $('.tapApply_od').click(function() {
            //	alert();
            var status = $("#status_od").val();
            var chk_checked = [];
            $.each($("input[name='check_od[]']:checked"), function() {
                chk_checked.push($(this).val());
            });
            var arr_length = chk_checked.length;
            if (arr_length == 0) {
                alert("Please select at least One Employee");
                return false;
            }

            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>leave/update_leave_application_group_od',
                data: {
                    chk_checkedf: chk_checked,
                    status: status
                },
                success: function(html) {
                    alert("Successfully Applied");
                    // Simulate a mouse click:
                    window.location.href = "https://erp.sandipuniversity.com/Leave/leave_applicant_list?lt=official&sf=";
                    //$('#stream_id').html(html);
                }
            });

        });


        $('#taexport').click(function() {
            var mon = $('#monthleave').val();
            var selsts = $('#selsts').val();
            if (mon == '') {
                var d = new Date();
                var m = d.getMonth();
                m = m + 1;
                mon = m + "-" + d.getFullYear();
                //alert(mon);
            }
            var url = "<?= base_url() . strtolower($currentModule) . '/export_emp_application_lev/exl/' ?>" + mon + "/" + selsts;
            //alert(url);
            window.location.href = url;
        });
        $('#tapexport').click(function() {
            var mon = $('#monthleave').val();
            var selsts = $('#selsts').val();
            //alert(mon);

            if (mon == '') {
                var d = new Date();
                var m = d.getMonth();
                m = m + 1;
                mon = m + "-" + d.getFullYear();
                //alert(mon);
            }
            var url = "<?= base_url() . strtolower($currentModule) . '/export_emp_application_lev/pdf/' ?>" + mon + "/" + selsts;
            //alert(url);
            window.location.href = url;
        });
        $('#taexportod').click(function() {
            var mon = $('#monthofficial').val();
            var selsts = $('#selstsod').val();
            if (mon == '') {
                var d = new Date();
                var m = d.getMonth();
                m = m + 1;
                mon = m + "-" + d.getFullYear();
                //alert(mon);
            }
            var url = "<?= base_url() . strtolower($currentModule) . '/export_emp_application_lev/exl-od/' ?>" + mon + "/" + selsts;
            //alert(url);
            window.location.href = url;
        });
        $('#tapexportod').click(function() {
            var mon = $('#monthofficial').val();
            var selsts = $('#selstsod').val();
            //alert(mon);

            if (mon == '') {
                var d = new Date();
                var m = d.getMonth();
                m = m + 1;
                mon = m + "-" + d.getFullYear();
                //alert(mon);
            }
            var url = "<?= base_url() . strtolower($currentModule) . '/export_emp_application_lev/pdf-od/' ?>" + mon + "/" + selsts;
            //alert(url);
            window.location.href = url;
        });
        $(".edetails").on('click', function() {
            //alert();
            var post_data = $(this).attr('id');
            //alert(post_data);
            jQuery.ajax({
                type: "POST",
                url: base_url + "leave/view_application_forward_details/" + post_data,
                success: function(data) {
                    //  alert(data);          
                    $('#edata').html(data);

                }
            });
        });



        $(".emp_view").on('click', function() {
            var eid = $(this).attr('id');

            var url = "<?= base_url() . strtolower($currentModule) . '/get_emp_history/' ?>" + eid;
            //   var data = {title: search_val};       
            //   var type="";
            //   var type_name="";
            $.ajax({
                type: "POST",
                url: url,
                // data: data,
                dataType: "html",
                cache: false,
                crossDomain: true,
                success: function(data) {
                    $("#empname").text(eid);
                    $("#emp_cnt").html(data);

                },
                error: function(data) {
                    alert("Page Or Folder Not Created..!!");
                }
            });
        });
    });

    function edit_timing(APP_ID) {


        var url = "<?= base_url() . strtolower($currentModule) . '/get_time_details/' ?>" + APP_ID;
        $.ajax({
            type: "POST",
            url: url,
            // data: data,
            dataType: "json",
            cache: false,
            crossDomain: true,
            success: function(data) {
                //console.log(data);
                // console.log(data['0']['applied_from_date']);

                $("#appidd").html(data['0']['lid']);
                // $("#appidd").val(data['0']['lid']);
                $("#app_id").val(data['0']['lid']);
                $("#fdate").val(data['0']['applied_from_date']);
                $("#tdate").val(data['0']['applied_to_date']);
                $("#updatetiming").modal('show');
                $("#tdays").val(data['0']['no_days']);
            },
            error: function(data) {
                alert("Page Or Folder Not Created..!!");
            }
        });
    }

    function update_time() {
        var url = "<?= base_url() . strtolower($currentModule) . '/update_time/' ?>";
        var app_id = $("#app_id").val();
        var fdate = $("#fdate").val();
        var tdate = $("#tdate").val();
        var tdays = $("#tdays").val();

        var rgx = /^[0-9]*\.?[0-9]*$/;

        if (fdate == '') {
            alert("please enter In time");
        } else if (tdate == '') {
            alert("please enter Out time");
        } else if (fdate > tdate) {
            alert("To_date must be greater than From_date");
        } else if (tdays.match(rgx)) {
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    fdate: fdate,
                    tdate: tdate,
                    tdays: tdays,
                    app_id: app_id,
                },
                cache: false,
                crossDomain: true,
                success: function(data) {
                    if (data == 1) {
                        alert("shift time updated successfully");
                        location.reload();
                    } else {
                        alert("Something went wrong,please try again ");
                    }


                },
                error: function(data) {
                    alert("Page Or Folder Not Created..!!");
                }
            });
        } else {
            alert("Total days must be Numeric");
        }
    }
</script>

