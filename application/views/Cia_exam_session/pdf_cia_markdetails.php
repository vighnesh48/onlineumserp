<br>
<table border="1" align="center" width="100%" cellpadding="3" cellspacing="0" style="font-size:12px;">
	<thead>
		<tr style="border:1px solid #000;">
			<th style="border-top:1px solid #000" align="left">Sr.No</th>
			<th style="border:1px solid #000" align="left">PRN</th>
			<th style="border:1px solid #000" align="left">STUDENT NAME</th>
			<th style="border:1px solid #000" align="left"><?php echo $me[0]['cia_exam_type']; ?> MARKS
				(<?php if ($me[0]['max_marks'] != '') {
					echo $me[0]['max_marks'];
				} ?>)</th>
			<th style="border:1px solid #000" align="left">Student Signature</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$count = 0;
		$count_AB = 0;
		$exam_type = $me[0]['cia_exam_type'];

	//	print_r($exam_type);exit;

		$k = 1;

		if (!empty($mrks)) {

			foreach ($mrks as $stud) {

				?>
				<tr style="border:1px solid #000;">
					<td style="border:1px solid #000;" width="5%"><?= $k ?></td>
					<td style="border:1px solid #000;" width="20%"><?= $stud['enrollment_no'] ?></td>
					<td style="border:1px solid #000;"><?= $stud['first_name'] . ' ' . $stud['middle_name'] . ' ' . $stud['last_name'] ?>
					</td>
					<td style="border:1px solid #000;"><?= $stud["$exam_type"] ?></td>
					<td style="border:1px solid #000;"></td>
				</tr>
				<?php
				if ($stud['marks'] == 'AB') {
					$count_AB++;
				}
				$k++;
				$count++;
			}
		}
		?>
	</tbody>
</table>