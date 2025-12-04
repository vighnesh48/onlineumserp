<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Remuneration Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        .header-table td {
            border: none;
            padding: 5px;
        }
        .no-border {
            border: none;
        }
        .signature-table td {
            height: 50px;
            border: none;
        }
        .section-title {
            font-weight: bold;
            text-align: center;
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
      
    <!-- Header Information -->
	<div class="col-lg-12">
<table width="100%" class='no-border'>
  <tr class='no-border'>
    <td valign="top" align="center" class='no-border'>
	<img src="<?php echo base_url(); ?>assets/images/logo-admin.png" alt="Sandip University" class="img-responsive">
    </td>
  </tr>
</table>
</div>
<br>
	
    <table class="header-table">
        <tr>
            <td><strong>Student Name:</strong> <?=$sem_det['student_name']?></td>
            <td colspan='2'><strong>PRN:</strong> <?=$sem_det['enrollment_no']?></td>
             <td colspan='3'><strong>Conduction Date:</strong> <?= $post['rac_date'] ?></td>
        </tr>
        <tr>
            <td colspan="3"><strong>Department/School:</strong> <?=$sem_det['stream_name']?>/<?=$sem_det['school_name']?> </td>
			<td colspan='2'><?php 
				echo ($post['type'] == 'topic_approval') ? '<strong>RAC Topic Approval</strong>' :
					 (($post['type'] == 'pre_thesis') ? '<strong>Pre Thesis</strong>' :
					 (($post['type'] == 'final_defence') ? '<strong>PhD Final Defence</strong>' :
					 (($post['type'] == 'course_work') ? '<strong>Course Work (Research Progress Seminar)</strong>' :
					 '<strong>' . ucfirst(str_replace('_', ' ', $post['type'])) . ' (Research Progress Seminar)</strong>')));
                 ?></td>

        </tr>
    </table>

    <!-- Main Content -->
    <table>
        <thead>
            <tr>
                <th>Details of Members</th>
                <th>Staff ID</th>
                <th>Name of Member</th>
                <th>Renumeration</th>
                <th>Travelling Allowance</th>
                <th>Name of Bank / STAFF ID</th>
                <th>IFSC Code (Branch)</th>
                <th>Account No</th>
                <th>Total Amount</th>
                <th>Signature</th>
            </tr>
        </thead>
        <tbody>
            <!-- Section Title for Internal Staff -->
            <tr>
                <td colspan="10" class="section-title">SUN Internal Staff</td>
            </tr>
			<?php if(!empty($gdata) && $gdata !=''){ ?>
            <tr>
                <td><?=$gdata['designation']?></td>
                <td><?=$gdata['guide_id']?></td>
                <td><?=$gdata['guide_name']?></td>
                <td><?=$gdata['renumeration']?></td>
                <td>NA</td>
                <td><?= !empty($gdata['bank_name']) ? $gdata['bank_name'] : $gdata['guide_id'] ?></td>
                <td><?=$gdata['ifsc_code']?></td>
                <td><?=$gdata['acc_no']?></td>
                <td><?=$gdata['amount']?></td>
                <td></td>
            </tr>
			<?php } ?>
			<?php if(!empty($intdata) && $intdata !=''){ ?>
            <tr>	
                <td><?=$intdata['designation']?></td>
                <td><?=$intdata['guide_id']?></td>
                <td><?=$intdata['guide_name']?></td>
                <td><?=$intdata['renumeration']?></td>
                <td>NA</td>
                <td><?= !empty($intdata['bank_name']) ? $intdata['bank_name'] : $intdata['guide_id'] ?></td>
                <td><?=$intdata['ifsc_code']?></td>
                <td><?=$intdata['acc_no']?></td>
                <td><?=$intdata['amount']?></td>
                <td></td>
            </tr>
			<?php } ?>

            
            <!-- Section Title for External Examiner -->
            <tr>
                <td colspan="10" class="section-title">SUN External Examiner</td>
            </tr>
			<?php if(!empty($ex_det) && $ex_det !=''){ 
			      foreach($ex_det as $row){      ?>
				<tr>
					<td><?=$row['ext_fac_designation']?></td>
					<td><?=$row['ext_faculty_code']?></td>
					<td><?=$row['ext_fac_name']?></td>
					<td><?=$row['renumeration']?></td>
					<td><?=$row['travelling_allowance']?></td>
					<td><?=$row['bank_name']?></td>
					<td><?=$row['ifsc_code']?></td>
					<td><?=$row['acc_no']?></td>
					<td><?=$row['amount']?></td>
					<td></td>
				</tr>
			<?php } }?>
        </tbody>
    </table>
  <br>
    <p>Enclose: Financial Approval (for above Remuneration)</p>
<br>
    <!-- Signatures -->
    <table class="signature-table">
        <tr>
            <td><strong>Signature</strong></td>
            <td><strong>Supervisor</strong></td>
            <td><strong>Dean</strong></td>
            <td><strong>Associate Dean (Ph.D.)</strong></td>
            <td><strong>Registrar</strong></td>
        </tr>
        <tr>
            <td colspan="3"></td>
        </tr>
        <tr>
            <td colspan="5" style="text-align:right;"><strong>Date: </strong><?=date('d-m-Y');?></td>
        </tr>

    </table>

</body>
</html>

	