<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
body {
    font-family: "Bookman Old Style", serif;
    font-size: 12px;
    margin: 25px;
}

/* Headings */
.header-title {
    text-align: center;
    margin-bottom: 4px;
}
.sub-title {
    text-align: center;
    margin: 2px 0;
}
.section-info {
    margin-top: 15px;
    line-height: 1.6;
}

/* Table styling (unchanged) */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 12px;
}

th {
    border: 1px solid #000;
    padding: 6px;
    text-align: center;
    font-weight: bold;
    background: #f1f1f1;
    font-size: 12px;
}

td {
    border: 1px solid #000;
    padding: 5px;
    text-align: center;
    font-size: 12px;
}

tbody tr:nth-child(even) {
    background: #fafafa;
}

td.left {
    text-align: left;
}

/* Total row styling */
.total-row td {
    font-weight: bold;
    background: #e3e3e3;
}

/* Footer */
.footer-sign {
    text-align: right;
    margin-top: 40px;
    font-weight: bold;
    font-size: 13px;
}
</style>
</head>
<body>

<!-- HEADER SECTION (clean + centered) -->
<div class="header-title">
    <h3>OFFICE OF THE CONTROLLER OF EXAMINATIONS</h3>
</div>
<div class="sub-title">
    <h4>ESE PRACTICAL EXAM CLAIM FORM – (<?= $exam_month.' '.$exam_year ?>)</h4>
    <h4>BATCH-WISE STATEMENT FOR PRACTICAL EXAMINATION</h4>
</div>

<table style="width:100%; border-collapse: collapse; border:none;">
    <tr>
        <td><strong>Programme:</strong> <?= $claim['stream_name'] ?></td>
        <td><strong>Semester:</strong> <?= $claim['semester'] ?></td>
    </tr>
    <tr>
        <td><strong>Division:</strong> <?= $claim['division'] ?></td>
        <td><strong>Batch:</strong> <?= $claim['batch_no'] ?></td>
    </tr>
    <tr>
        <td colspan="2"><strong>Subject:</strong> <?= $claim['subject_code'].' - '.$claim['subject_name'] ?></td>
    </tr>
</table>

<table>
<thead>
<tr>
    <th>Sr. No.</th>
    <th width="20%">Name & Designation</th>
    <th width="15%">Institution <span>(Abbreviated)</span></th>
    <th width="10%" >Role</th>
    <th>No. of Students <span>Reg.</span></th>
    <th>No. of Students <span>Examined</span></th>
    <th width="5%">Distance <span> In KM </span></th>
    <th width="8%">Remuneration<span>(A)</span></th>
    <th width="5%">TA
		<span>
			Rs.8/-
			Per
			K.M (B)
		</span>
	</th>
    <th width="5%">DA
		<span>
			Rs.150/-
			Per
			Day (C)
		</span>
	</th>
    <th width="5%">Total Amount
		<span>
			(A+B+C)
		</span>		
	</th>
    <th width="8%">Signature</th>
</tr>
</thead>
<tbody>
<?php 
			$CI =& get_instance();
            $CI->load->model('Marks_model');
            $strength = $this->Marks_model->fetch_marks_entry_details(
                $claim['subject_id'],
                $claim['stream_id'],
                $claim['semester'],
                $claim['division'],
                $claim['batch_no'],
                $exam_id
            );
            $rates = $this->Marks_model->fetch_renum_rates(
                $claim['stream_id'],
                $claim['subject_category']
            );
			
			// Access array keys instead of object properties
			$total_students  = $strength['total_strength'] ?? 0;
			$absent_count    = $strength['absent_count'] ?? 0;
			$present_count   = $strength['present_count'] ?? 0;
			
			$rate_factor = $rates['factor'] ?? 0;;
			$rate_ta = 8;
			$rate_da = 150;
			$rate_ta_la = 70; // lab assistant
			
			// Returns TA/DA availability for each exam_pract_fact_id
			$ta_da = $this->Marks_model->get_ta_da_status(
            $claim['ext_faculty_code'], 
            $exam_id
			);

			// Current exam_pract_fact_id
			$fact_id = $claim['exam_pract_fact_id'];

			$allow_TA = $ta_da[$fact_id]['allow_ta'];
			$allow_DA = $ta_da[$fact_id]['allow_da'];
			
			$grand_rem = ($present_count * $rate_factor) + ($present_count * $rate_factor) + $rate_ta_la;
			$grand_ta  = $allow_TA ? ($claim['distance'] * $rate_ta) : 0;
			$grand_da  = $allow_DA ? $rate_da : 0;
			$grand_total = (($present_count * $rate_factor)+ ($allow_TA ? ($claim['distance'] * $rate_ta) : 0) + ($allow_DA ? $rate_da : 0))
							+ 
							($present_count * $rate_factor) + $rate_ta_la;
?>

<tr>
    <td>1</td>
    <td><?= $claim['ext_fac_name'].'<br>'.$claim['ext_fac_designation'] ?></td>
    <td><?= $claim['ext_fac_institute'] ?></td>
    <td>External Examiner</td>
    <td><?= $total_students ?></td>
    <td><?= $present_count ?></td>
    <td><?= $claim['distance'] ?></td>
    <td><p><?= $present_count * $rate_factor ?></p>
		<span style="color:#9b9b9b8a; font-size:10px;">
			(<?= $present_count ?> X <?= $rate_factor ?>)
		</span>
	</td>
	<td><?= $allow_TA ? ($claim['distance'] * $rate_ta) : 0 ?></td>
	<td><?= $allow_DA ? $rate_da : 0 ?></td>
	<td>
		<?= ($present_count * $rate_factor)
			+ ($allow_TA ? ($claim['distance'] * $rate_ta) : 0)
			+ ($allow_DA ? $rate_da : 0) 
		?>
	</td>

    <td>
		<span style="color:#9b9b9b8a;">
			Affix One
			Rupee Stamp if
			Amount
			Exceeds
			Rs.5000/-
		</span>	
	</td>
</tr>

<tr>
    <td>2</td>
    <td><?= $claim['fname'].' '.$claim['mname'].' '.$claim['lname'].'<br>'.$claim['designation_name'] ?></td>
    <td>Sandip University</td>
    <td>Internal Examiner</td>
    <td><?= $total_students ?></td>
    <td><?= $present_count ?></td>
    <td>--</td>
    <td><p><?= $present_count * $rate_factor ?></p>
		<span style="color:#9b9b9b8a; font-size:10px;">
			(<?= $present_count ?> X <?= $rate_factor ?>)
		</span>
	</td>
    <td>--</td>
    <td>--</td>
    <td><?= $present_count * $rate_factor ?></td>
    <td>
		<span style="color:#9b9b9b8a;">
			Affix One
			Rupee Stamp if
			Amount
			Exceeds
			Rs.5000/-
		</span>	
	</td>
</tr>

<tr>
    <td>3</td>
    <td><?= $claim['lab_fname'].' '.$claim['lab_mname'].' '.$claim['lab_lname'].'<br>'.$claim['lab_designation_name'] ?></td>
    <td>Sandip University</td>
    <td>Lab Assistant</td>
    <td><?= $total_students ?></td>
    <td><?= $present_count ?></td>
    <td>--</td>
    <td><?= $rate_ta_la ?></td>
    <td>--</td>
    <td>--</td>
    <td><?= $rate_ta_la ?></td>
    <td> 
		<span style="color:#9b9b9b8a;">
			Affix One
			Rupee Stamp if
			Amount
			Exceeds
			Rs.5000/-
		</span>
	</td>
</tr>

<!-- TOTAL ROW -->
<tr class="total-row">
    <td colspan="7" style="text-align:right;">TOTAL(IN RS.)</td>
    <td><?= $grand_rem ?>/-</td>
    <td><?= $grand_ta ?>/-</td>
    <td><?= $grand_da ?>/-</td>
    <td><?= $grand_total ?>/-</td>
    <td></td>
</tr>
</tbody>
</table>
<br>
<br>
<!-- FOOTER SIGN -->
<div class="footer-sign">
    Controller of Examinations
</div>
</body>
</html>
