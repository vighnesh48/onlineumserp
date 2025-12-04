
<style>
    body {
        font-family: "Bookman Old Style", serif;
        font-size: 12px;
        line-height: 1.6;
        margin: 40px 60px;
    }
    .red {
        color: red;
        font-weight: bold;
    }
    .center {
        text-align: center !important;
    }
    .right {
        text-align: right !important;
    }
    .left {
        text-align: left !important;
    }    
	.justify {
        text-align: justify !important;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 1px;
        margin-bottom: 1px;
    }
    th, td {
        border: 1px solid #000;
        padding: 2px 2px;
        vertical-align: middle;
    }
    th {
        background-color: #f2f2f2;
    }
    p {
        margin: 5px;
        margin-left:10px;
    }
</style>



<!-- FROM Section -->
<strong>FROM</strong>
<p class="justify" style="text-align:justify !important; text-justify:inter-word !important; margin:0px 10px !important;">
The Controller of Examinations<br>Sandip University,Nashik</p>

<!-- TO Section -->
<strong style="margin-top:5px 10px !important;">TO</strong>
<p class="justify" style="text-align:justify !important; text-justify:inter-word !important; margin:0px 10px !important;">
<span style="display:block; text-transform:uppercase; font-weight:600; text-align:justify !important; text-justify:inter-word !important;"><?= strtoupper($examiner_name) ?></span><br>
<span style="display:block; text-align:justify !important;"><?= $designation ?></span><br>
<span style="display:block; text-align:justify !important;"><?= $college_name ?></span><br>
<span style="display:block; text-align:justify !important;">Mobile No.: <?= $mobile_no ?></span>
</p>

<strong style="margin-top:5px 10px !important;">Through:</strong>
<p class="justify" style="text-align:justify !important; text-justify:inter-word !important; margin:0px 10px !important;">
The Principal,</p>
<p><strong></strong> <?= $college_name ?></p>

<!-- Body -->
<p>Sir/Madam,</p>

<strong style="margin-top:5px 10px !important;">Sub:</strong> <span class=""> Appointment of External Examiner for End Semester Practical Examinations 
<?= $exam_month ?> <?= $exam_year ?></span> - Reg.,</p>

<p style="text-align:justify !important; text-justify:inter-word !important; margin:5px 10px !important;">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;I am, by direction, to inform you that you are appointed as the <strong>External Examiner</strong> 
to conduct the <span class=""><?= $exam_month ?> <?= $exam_year ?></span> End Semester 
Practical Examinations for the course(s) mentioned below.
</p>

<!-- Course Table -->
<table style="font-size:10px; width:100% !important; border-collapse:collapse !important;">
    <thead>
        <tr>
            <th style="width:5%;"> S.No</th>
            <th style="width:10%;">Date</th>
            <th style="width:17%;">Programme</th>
            <th style="width:30%;">Name of the Course(s)</th>
            <th style="width:8%;">Div./Batch</th>
            <th style="width:15%;">Timings</th>
            <th style="width:10%;">Total Strength</th>
        </tr>
    </thead>
	<tbody>
		<?php foreach ($courses as $c): ?>
			<tr>
				<td class="center" style="text-align:center !important; vertical-align:middle !important;">
		<?= $c['sno'] ?></td>
				<td class="center" style="text-align:center !important; vertical-align:middle !important;">
		<?= $c['exam_date'] ?></td>
				<td class="center" style="text-align:center !important; vertical-align:middle !important;">
		<?= $c['programme'] ?></td>
				<td style="text-align:justify !important; text-justify:inter-word !important; vertical-align:middle !important; padding:4px !important;">
		<?= $c['course_name'] ?></td>				
				<td class="center" style="text-align:center !important; vertical-align:middle !important;">
		<?= $c['division'].'/'.$c['batch'] ?></td>
				<td class="center" style="text-align:center !important; vertical-align:middle !important;">
		<?= $c['timing'] ?></td>
				<td class="center" style="text-align:center !important; vertical-align:middle !important;">
		<?= $c['strength'] ?></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<p style="text-align:justify !important; text-justify:inter-word !important; margin:5px 10px !important;">
You are requested to give your acceptance through mail or phone within two days from the date of receipt of this communication.<br>
If you are not conversant with the course, you are requested to decline the offer of appointment and inform the same at the earliest.
</p>

<p style="text-align:justify !important; text-justify:inter-word !important; margin:5px 10px !important;">
The Question Paper can be set jointly by the Internal and External Examiners. You are kindly requested to follow the 
rules and regulations of the Practical Examinations enclosed herewith.
</p>
<?php 
$CI =& get_instance();
$CI->load->model('Marks_model');
$user_id=$this->session->userdata('name');
$user_mobile = $this->Marks_model->fetch_user_contact($user_id);
// print_r($user_mobile);exit;
 ?>
<p><strong style="text-align:center !important;">Note: You are requested to follow the schedule and timings strictly.</strong></p><p>
For further clarifications, please contact: <b> Dean / HoD (<?= $user_mobile['mobile_no'] ?>) </b>
</p>

<p style="text-align:justify !important; text-justify:inter-word !important; margin:5px 10px !important;">
The appointment order should be kept strictly confidential. Your kind cooperation is requested in this regard.
</p>

<!-- Signature -->
<br><br>
<p class="right"><strong>Yours faithfully,</strong><br>
<strong style="text-align:center !important;">Sd/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong><br>
<strong>Controller of Examinations</strong></p>

<p><em>Encl: Instructions to Examiners</em></p>


