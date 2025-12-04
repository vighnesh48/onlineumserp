<?php

    // $total_student = $student_count*30;
    $breakfast_price = $canteen_slot_price_breakfast['price'];
    $lunch_price = $canteen_slot_price_lunch['price'];
    $dinner_price = $canteen_slot_price_dinner['price'];



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Canteen Details Report - <?= $month ?> <?= $year ?> </title>
    <style>
        *{
            margin-top: 5px;
            padding: 0;
        }
        body {
            font-family: Arial, sans-serif;
            padding: 10px;
        }

       
        /* table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        } */
         .header-td{
            border: none;
         }
        .main_table, td, th {
         border: 1px solid #000;
         border-collapse: collapse;
         padding:7px;
         padding-top: 7px;
         font-size:11px;
         line-height:5px;
         font-family: sans-serif;
         margin-bottom: 10px;
         }
         .main_table{
            padding: 0;
         }
        
    </style>
</head>
<body>
    
    

    
    <div style=" width:700px;margin:1px auto;overflow:auto;height:auto">
        <div id = "header">
            
        <table cellpadding="0" cellspacing="0" border="0" align="center" width="100%" style="margin-bottom:5px;">

        <tr>
	        <td class="header-td" width="80" align="right" style="text-align:right;padding-top:5px;"><img src="<?=base_url()?>assets\sandipFoundation_logo.jpg" alt="" width="100" border="0"></td>
	        <td class="header-td" style="font-weight:normal;text-align:center;">
	        <h2 style=" color: red; font-size: 23px">SANDIP FOUNDATION</h2>
	        <!-- <p>Mahiravani, Trimbak Road, Nashik – 422 213</p> -->
            <br>
            <h3 style="font-size: 20px"><?= $canteen_name ?></h3>
            <br>
            <h3 style=" color: grey; font-size: 20px"> <?= $month ?> -  <?= $year ?></h3>

	        </td>
	        <td class="header-td" width="120" align="right" valign="top" style="text-align:center;padding-top:15px;">
	        </td>

	   <tr>
        </table>
            
        </div>
        
        <table width="100%" style="text-align: center;" class="main_table">
            <thead>
                <tr>
                    <th rowspan="2"><strong>Sr.No</strong></th>
                    <th rowspan="2">Date</th>
                    <th rowspan="1" colspan="3">BreakFast</th>
                    <th rowspan="1" colspan="3">Lunch</th>
                    <th rowspan="1" colspan="3">Dinner</th>
                    <strong></strong>
                </tr>
                <tr>
                    <th rowspan="1">Total</th>
                    <th rowspan="1">Present</th>
                    <th rowspan="1">AB</th>
    
                    <th rowspan="1">Total</th>
                    <th rowspan="1">Present</th>
                    <th rowspan="1">AB</th>
    
                    <th rowspan="1">Total</th>
                    <th rowspan="1">Present</th>
                    <th rowspan="1">AB</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($punching_details as $i => $data) { ?>
            
                <tr>
                    <td><?= $i+1 ?></td>
                    <td><?= $data['punch_date'] ?></td>
                    <td><?= $student_count['breakfast_count'] ?></td>
                    <td><?= $data['breakfast_present'] ?></td>
                    <td><?= $student_count['breakfast_count'] - $data['breakfast_present'] ?></td>
                    <td><?= $student_count['lunch_count'] ?></td>
                    <td><?= $data['lunch_present'] ?></td>
                    <td><?= $student_count['lunch_count'] - $data['lunch_present'] ?></td>
                    <td><?= $student_count['dinner_count'] ?></td>
                    <td><?= $data['dinner_present'] ?></td>
                    <td><?= $student_count['dinner_count'] - $data['dinner_present'] ?></td>

                 <?php $total_present_breakfast = $total_present_breakfast + $data['breakfast_present'] ?>
                 <?php $total_present_lunch = $total_present_lunch + $data['lunch_present'] ?>
                 <?php $total_present_dinner = $total_present_dinner + $data['dinner_present'] ?>

                 <?php $total_student_breakfast = $total_student_breakfast + $student_count['breakfast_count'] ?>
                 <?php $total_student_lunch = $total_student_lunch + $student_count['lunch_count'] ?>
                 <?php $total_student_dinner = $total_student_dinner + $student_count['dinner_count'] ?>

                 <?php $total_absent_breakfast += $student_count['breakfast_count'] - $data['breakfast_present']; ?>
                 <?php $total_absent_lunch += $student_count['lunch_count'] - $data['lunch_present']; ?>
                 <?php $total_absent_dinner += $student_count['dinner_count'] - $data['dinner_present']; ?>
   
                </tr>
                <?php } ?>
                <tr>
                    <td colspan="2"><strong>Total</strong></td>

                    <td colspan="1"><strong><?= $total_student_breakfast ?></strong></td>
                    <td colspan="1"><strong><?= $total_present_breakfast ?></strong></td>
                    <td colspan="1"><strong><?= $total_absent_breakfast ?></strong></td>

                    <td colspan="1"><strong><?= $total_student_lunch ?></strong></td>
                    <td colspan="1"><strong><?= $total_present_lunch ?></strong></td>
                    <td colspan="1"><strong><?= $total_absent_lunch ?></strong></td>

                    <td colspan="1"><strong><?= $total_student_dinner ?></strong></td>
                    <td colspan="1"><strong><?= $total_present_dinner ?></strong></td>
                    <td colspan="1"><strong><?= $total_absent_dinner ?></strong></td>
                </tr>
               
                <!-- Add more rows as needed -->
            </tbody>
        </table>
    
        <table class="main_table" width="100%" style="text-align: center;">
            <thead>
                <tr>
                    
                    <th rowspan="1" colspan="3">BreakFast</th>
                    <th rowspan="1" colspan="3">Lunch</th>
                    <th rowspan="1" colspan="3">Dinner</th>
                    <th rowspan="2">Total Amount</th>
                </tr>
                <tr>
                    <th rowspan="1">Rate</th>
                    <th rowspan="1">Present</th>
                    <th rowspan="1">Total</th>
    
                    <th rowspan="1">Rate</th>
                    <th rowspan="1">Present</th>
                    <th rowspan="1">Total</th>
    
                    <th rowspan="1">Rate</th>
                    <th rowspan="1">Present</th>
                    <th rowspan="1">Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?= $breakfast_price ?></td>
                    <td><?= $total_present_breakfast ?></td>
                    <td><?= $total_present_breakfast * $breakfast_price ?></td>
                    <td><?= $lunch_price ?></td>
                    <td><?= $total_present_lunch ?></td>
                    <td><?= $total_present_lunch * $lunch_price ?></td>
                    <td><?= $dinner_price ?></td>
                    <td><?= $total_present_dinner ?></td>
                    <td><?= $total_present_dinner * $dinner_price ?></td>
                    <td><?= $total_present_breakfast * $breakfast_price + $total_present_lunch * $lunch_price + $total_present_dinner * $dinner_price ?></td>
    
    
                </tr>
               
               
                <!-- Add more rows as needed -->
            </tbody>
        </table>
    </div>
   
    

    
</body>
</html>

