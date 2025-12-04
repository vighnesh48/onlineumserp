<style type="text/css">
.table-bordered, 
.table-bordered > tbody > tr > td, 
.table-bordered > tbody > tr > th, 
.table-bordered > tfoot > tr > td, 
.table-bordered > tfoot > tr > th, 
.table-bordered > thead > tr > td, 
.table-bordered > thead > tr > th {
    border-color: #8acc82;
}
</style>

<?php if($exp != 'Y'): ?>
    <style>
    .row { font-family: "Arial", "Verdana"; }
    .table { padding: 10px; font-family: "Arial", "Verdana" !important; }
    </style>
    <div class="row">
        <form id="form1" name="form1" action="<?= base_url($currentModule . '/stud_rep_download') ?>" method="post">
            <input type="hidden" name="sacd_yer" value="<?=$pdata['acd_yer']?>" />
            <input type="hidden" name="ssch_id" value="<?=$pdata['sch_id']?>" />
            <input type="hidden" name="scurs" value="<?=$pdata['curs']?>" />
            <input type="hidden" name="sstrm" value="<?=$pdata['strm']?>" />
            <input type="hidden" name="ssem" value="<?=$pdata['sem']?>" />
            <input type="hidden" name="sdivis" value="<?=$pdata['divis']?>" />
            <input type="hidden" name="sfdt" value="<?=$pdata['fdt']?>" />
            <input type="hidden" name="stdt" value="<?=$pdata['tdt']?>" />
            <input type="hidden" name="srtyp" value="<?=$pdata['rtyp']?>" />
            <div class="col-sm-1">
                <button class="btn btn-primary form-control" id="btn_exp" type="submit">PDF</button>
            </div>
        </form>
    </div>
<?php endif; ?>

<?php if($exp == 'Y'): ?>
    <div class="table-responsive">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td align="center">
                    <img src="http://erp.sandipuniversity.com/assets/images/logo_form.png" width="200" />
                    <p style="margin-top:0"><strong>Mahiravani, Trimbak Road, Nashik – 422 213</strong></p>
                </td>
            </tr>
        </table>
<?php endif; ?>

<div style="text-align:center;color:red;">
    <h4><b>Attendance Mark Report</b></h4>
</div>

<table id="dis_data" class="table table-bordered" border="1" cellspacing="0" cellpadding="3" style="border-color:#249f8a; border-collapse: collapse; font-size: 11px !important;">
    <?php if(!empty($timtab)): ?>
        <tr>
            <td colspan="10" align="center" style="align:center;">
                <h4><b><?=$timtab[0]['school_name']?></b></h4>
                <b>Current Session: <?=$this->config->item('current_year')?> 
                (<?php echo $this->config->item('current_sess') == 'WIN' ? 'WINTER' : 'SUMMER'; ?>)</b>
            </td>
        </tr>

        <?php
        $j = 1;
        $p = 0; 
        $t = 0;
        $cntj = count($timtab);
        
        for($i = 0; $i < $cntj; $i++) {
            if($t == 'r') {
                $t = $i - 1;
            } else {
                $t = $t;
            }

            $acd_yr = explode('~', $pdata['acd_yer']);
            $dt = $sdate[$timtab[$i]['wday']];
            $rowa = $this->Student_Attendance_model->get_student_attendance_data_pre(
                $acd_yr[0], substr($acd_yr[1], 0, 3), $dt,
                $timtab[$i]['stream_id'], $timtab[$i]['semester'],
                $timtab[$i]['division'], $timtab[$i]['lecture_slot'], 
                $timtab[$i]['faculty_code'],$timtab[$i]['batch_no']
            );

            $cnt = count($rowa);

            if($timtab[$t]['stream_name'] != $timtab[$i]['stream_name'] || 
               $timtab[$t]['semester'] != $timtab[$i]['semester'] || 
               $timtab[$t]['division'] != $timtab[$i]['division']) {

                if($cnt != '0'): ?>
					
                    <tr style="background-color:#6BCEEF;padding:10px;">
                        <td colspan="10" align="left" style="padding:10px;">
                            &nbsp;<b>Class: </b>&nbsp;<?=$timtab[$i]['stream_name']?>&nbsp; | &nbsp;
                            <b>SEM:</b>&nbsp;<?=$timtab[$i]['semester']?>&nbsp;|&nbsp; 
                            <b>DIVISION:</b>&nbsp;<?=$timtab[$i]['division']?>&nbsp;<?=$timtab[$i]['batch_no']?>
                        </td>
                    </tr>
                    <tr style="background-color:#D2D2D2;">
                        <th align="center"><b>Sr.no</b></th>
                        <th align="center"><b>Day</b></th>
                        <th align="center"><b>Subject Name</b></th>
                        <th align="center"><b>Type</b></th>
                        <th align="center"><b>Slot</b></th>
                        <th align="center"><b>Faculty Name</b></th>
                        <th align="center"><b>Tatal</b></th>
                        <th align="center"><b>Present</b></th>
                        <th align="center"><b>Absent</b></th>
                        <th align="center"><b>Percentage</b></th>
                    </tr>
                <?php endif;
                $k = 1; 
                $y = '1';
            }

            if($cnt != '0'): ?>
                <tr>
                    <td><?=$k?></td>
                    <td><?php 
                        if($z != $timtab[$i]['wday']) {
                            echo $dt;
                            $z = $timtab[$i]['wday'];
                        } else {
                            if($y == 1) {
                                echo $dt;
                            }
                        }
                    ?></td>
                    <td><?php
                        switch($timtab[$i]['subject_code']) {
                            case 'OFF':
                                echo "OFF Lecture";
                                break;
                            case 'Library':
                                echo "Library";
                                break;
                            case 'Tutorial':
                                echo "Tutorial";
                                break;
                            case 'Tutor':
                                echo "Tutor";
                                break;
                            case 'IS':
                                echo "Internet Slot";
                                break;
                            case 'RC':
                                echo "Remedial Class";
                                break;
                            case 'EL':
                                echo "Experiential Learning";
                                break;
                            case 'SPS':
                                echo "Swayam Prabha Session";
                                break;
                            case 'ST':
                                echo "Spoken Tutorial";
                                break;
                            case 'FAM':
                                echo "Faculty Advisor Meet";
                                break;
                            default:
                                echo $timtab[$i]['sub_code'] . " - " . $timtab[$i]['subject_name'];
                                break;
                        }
                    ?></td>
                    <td><?php 
                        echo ($timtab[$i]['subject_type'] == 'TH') ? 'Theory' : 'Practical';
                    ?></td>
                    <td><?=$timtab[$i]['from_time'] . "-" . $timtab[$i]['to_time']?></td>
                    <td><?=$timtab[$i]['fname'] . " " . $timtab[$i]['lname']?></td>
                    <td><?=$rowa[0]['tpresent']+$rowa[0]['tapsent'];?></td>
                    <td><?=$rowa[0]['tpresent']?></td>
                    <td><?=$rowa[0]['tapsent']?></td>
                    <td><?=$rowa[0]['percen_lecturs']?></td>
                </tr>
            <?php
            $k++;
            $t = 'r';
            $y = '';
            else:
                $p++;
                $t = $i - $p;
            endif;
            unset($rowa);
        }
        ?>
    <?php endif; ?>
</table>
