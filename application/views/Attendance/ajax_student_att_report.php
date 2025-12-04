<style type="text/css">
.table-bordered, 
.table-bordered > tbody > tr > td, 
.table-bordered > tbody > tr > th, 
.table-bordered > tfoot > tr > td, 
.table-bordered > tfoot > tr > th, 
.table-bordered > thead > tr > td, 
.table-bordered > thead > tr > th {
    border-color: #1d89cf !important;
    padding: 7px !important;
}

.table-bordered > thead > tr > th {
    color: #fff !important;
}
</style>

<?php if ($exp != 'Y') : ?>
    <div class="row">
        <form id="form1" name="form1" action="<?= base_url($currentModule . '/stud_rep_download') ?>" method="post">
            <input type="hidden" name="sacd_yer" value="<?= $pdata['acd_yer'] ?>" />
            <input type="hidden" name="ssch_id" value="<?= $pdata['sch_id'] ?>" />
            <input type="hidden" name="scurs" value="<?= $pdata['curs'] ?>" />
            <input type="hidden" name="sstrm" value="<?= $pdata['strm'] ?>" />
            <input type="hidden" name="ssem" value="<?= $pdata['sem'] ?>" />
            <input type="hidden" name="sdivis" value="<?= $pdata['divis'] ?>" />
            <input type="hidden" name="sfdt" value="<?= $pdata['fdt'] ?>" />
            <input type="hidden" name="stdt" value="<?= $pdata['tdt'] ?>" />
            <div class="col-sm-1">
                <button class="btn btn-primary form-control" id="btn_exp" type="submit">PDF</button>
            </div>
        </form>
    </div>
<?php endif; ?>

<?php if ($exp == 'Y') : ?>
    <div class='table-responsive'>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td align="center">
                    <img src="http://erp.sandipuniversity.com/assets/images/logo_form.png" width="200" />
                    <p style="margin-top:0"><strong>Mahiravani, Trimbak Road, Nashik – 422 213,</strong></p>
                </td>
            </tr>
        </table>
    </div>
<?php endif; ?>

<style>
.abc {
    color: grey !important;
}
</style>

<div style="text-align:center;color:red;">
    <h4><b>Attendance Not Mark Report</b></h4>
</div>

<table id="dis_data" width="100%" class="table table-bordered" border="1" style="border-color:#249f8a;border-collapse: collapse; font-size: 11px !important;">
    <?php if (!empty($timtab)) : ?>
        <tr>
            <td colspan="7" align="center">
                <h4><b><?= $timtab[0]['school_name'] ?></b></h4>
                <b>Current Session: <?= $this->config->item('current_year') ?>
                    (<?= $this->config->item('current_sess') == 'WIN' ? 'WINTER' : 'SUMMER' ?>)
                </b>
            </td>
        </tr>

        <?php
        $j = 1;
        $p = 0;
        $t = 0;
        $cntj = count($timtab);

        for ($i = 0; $i < $cntj; $i++) {
            if ($t == 'r') {
                $t = $i - 1;
            }

            $t = $t;
			 $dt = $sdate[$timtab[$i]['wday']];
                $rowa = $this->Student_Attendance_model->get_student_attendance_data(
                    $dt,
                    $timtab[$i]['stream_id'],
                    $timtab[$i]['semester'],
                    $timtab[$i]['division'],
                    $timtab[$i]['lecture_slot'],
                    $timtab[$i]['faculty_code'],
					$timtab[$i]['batch_no']
                );
				$cnt = count($rowa);
            if ($i == '0') : ?>
                
                <?php
                $k = 1;
                $y = '1';
            else :
                if ($timtab[$t]['stream_name'] != $timtab[$i]['stream_name'] ||
                    $timtab[$t]['semester'] != $timtab[$i]['semester'] ||
                    $timtab[$t]['division'] != $timtab[$i]['division']) :
                    if ($cnt == '0') : ?>
                        <tr style="background-color:#1d89cf!important;padding:10px!important;color:#fff!important;">
                            <td colspan="7" align="left" style="padding:10px;color:white;">
                                <b style="font-weight:900">&nbsp;Class:&nbsp;<?= $timtab[$i]['stream_name'] ?>&nbsp; | &nbsp;SEM:&nbsp;<?= $timtab[$i]['semester'] ?>&nbsp;|&nbsp; DIVISION:&nbsp;<?= $timtab[$i]['division'] ?></b>
                            </td>
                        </tr>
                        <tr style="background-color:#D2D2D2;padding:10px;">
                            <th align="center"><b>Sr.no</b></th>
                            <th align="center"><b>Day</b></th>
                            <th align="center"><b>Subject Name</b></th>
                            <th align="center"><b>Type</b></th>
                            <th align="center"><b>Batch</b></th>
                            <th align="center"><b>Slot</b></th>
                            <th align="center"><b>Faculty Name</b></th>
                        </tr>
                        <?php
                        $k = 1;
                        $y = '1';
                    endif;
                endif;

               

                

                if ($cnt == '0') : ?>
                    <tr>
                        <td style="padding:7px;font-size:12px"><?= $k ?></td>
                        <td style="padding:7px;font-size:12px">
                            <?php
                            if ($z != $timtab[$i]['wday']) {
                                echo $dt;
                                $z = $timtab[$i]['wday'];
                            } else {
                                if ($y == 1) {
                                    echo $dt;
                                }
                            }
                            ?>
                        </td>
                        <td style="padding:7px;font-size:12px">
                            <?php
                            $subject_code = $timtab[$i]['subject_code'];
                            $subject_name = $timtab[$i]['subject_name'];
                            $sub_code = $timtab[$i]['sub_code'];
                            
                            $subject_map = [
                                'OFF' => 'OFF Lecture',
                                'Library' => 'Library',
                                'Tutorial' => 'Tutorial',
                                'Tutor' => 'Tutor',
                                'IS' => 'Internet Slot',
                                'RC' => 'Remedial Class',
                                'EL' => 'Experiential Learning',
                                'SPS' => 'Swayam Prabha Session',
                                'ST' => 'Spoken Tutorial',
                                'FAM' => 'Faculty Advisor Meet'
                            ];

                            echo $subject_map[$subject_code] ?? "$sub_code - $subject_name";
                            ?>
                        </td>
                        <td style="padding:7px;font-size:12px">
                            <?= $timtab[$i]['subject_type'] == 'TH' ? 'Theory' : 'Practical' ?> 
                        </td>
						<td style="padding:7px;font-size:12px"><?php if($timtab[$i]['batch_no']!=0){ echo $timtab[$i]['batch_no'];}else{ echo '-';}?></td>
                        <td style="padding:7px;font-size:12px"><?= $timtab[$i]['from_time'] . "-" . $timtab[$i]['to_time'] ?></td>
                        <td style="padding:7px;font-size:12px">
                            <?= $timtab[$i]['fname'] . " " . $timtab[$i]['lname'] ?>
                            <br>
                            <?php
                            $lv = $this->Student_Attendance_model->check_leave($timtab[$i]['faculty_code'], $dt);
                            $hd = $this->Student_Attendance_model->check_holidays($dt, $timtab[$i]['staff_type']);
                            $fr = '';

                            if ($hd == 'true' || $hd == 'RD') {
                                $fr = "Holiday";
                            } elseif ($lv != 'N') {
                                $fr = $lv;
                            }
                            ?>
                            <span style="color:red;"><?= $fr ?></span>
                        </td>
                    </tr>
                    <?php
                    $k++;
                    $t = 'r';
                    $y = '';
                    unset($cnt);
                else:
                    unset($cnt);
                    if ($timtab[$t]['stream_name'] != $timtab[$i]['stream_name'] ||
                        $timtab[$t]['semester'] != $timtab[$i]['semester'] ||
                        $timtab[$t]['division'] != $timtab[$i]['division']) {
                        $p++;
						$t = $i - $p;
                    }
                    $t++;
                endif;
            endif;
        }
        ?>
    <?php endif; ?>
</table>
