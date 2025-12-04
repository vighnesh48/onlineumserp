<!DOCTYPE html>
<html>
<head>
    <title>OD Report</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .container { width: 100%; max-width: 1400px; margin: auto; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { 
            border: 1px solid black; 
            padding: 12px; 
            text-align: center; 
            font-size: 14px;
        }
        .table th { 
            background-color: #007bff; 
            color: white; 
            font-size: 16px;
        }
        .header-table { width: 100%; border: none; margin-bottom: 10px; }
        .header-table td { padding: 5px; }
        .logo { width: 100px; height: auto; }
        .title { font-size: 27px; font-weight: bold; color: red; text-align: center; }
        .subtitle { font-size: 16px; text-align: center; }
        .report-title { font-size: 18px; font-weight: bold; padding: 10px 0px; text-align: center; }
        .date { text-align: right; font-size: 14px; padding: 10px; font-weight: bold; }
        hr { border: 1px solid #000; margin: 10px 0; }
    </style>
</head>
<body>
   
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .container { width: 100%; max-width: 1400px; margin: auto; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { 
            border: 1px solid black; 
            padding: 12px; 
            text-align: center; 
            font-size: 14px;
        }
        .table th { 
            background-color: #007bff; 
            color: white; 
            font-size: 16px;
        }
        .header-table { width: 100%; border: none; margin-bottom: 10px; }
        .header-table td { padding: 5px; }
        .logo { width: 100px; height: auto; }
        .title { font-size: 27px; font-weight: bold; color: red; text-align: center; }
        .subtitle { font-size: 16px; text-align: center; }
        .report-title { font-size: 18px; font-weight: bold; padding: 10px 0px; text-align: center; }
        .date { text-align: right; font-size: 14px; padding: 10px; font-weight: bold; }
        hr { border: 1px solid #000; margin: 10px 0; }
    </style>



<div class="container">
    <table class="header-table">
        <tr>
            <td style="width: 10%; text-align: left;">
                <!--<img src="<?php echo base_url();?>assets/images/su-logo.png" class="logo">-->
            </td>
            <td style="width: 90%;">
                <div class="title">Sandip Foundation</div>
                <div class="subtitle"><?=$address;?></div>
                
            </td>
        </tr>
    </table>
    <div class="report-title" style="display:none" >Daily Leave Report</div>
    <div class="date"  style="display:none">Date: <?php echo date('d-m-Y'); ?></div>
    <hr>

    <div class="table-responsive"  style="display:none">
        <table class="table">
            <thead>
                <tr>
                    <th>Sr.No</th>
					<th>School</th>
                    <th>Staff ID</th>
                    <th>Staff Name</th>                    
                    <th>Department</th>
                    <th>Designation</th>
                    <th>From Date</th>
                    <th>To Date</th>
                    <th>No of Days/Hrs</th>
                    <th>Cumm Month Leave</th>
                    <th>Cumm Leave(Sum-2025)</th>
                    <th>Reason</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $count = 1;
				 $this->load->model('login_model');
                foreach ($leave as $row) { 
                    ?>
                        <tr>
                            <td><?= $count++; ?></td>
							<td><?= $row['school']; ?></td>
                            <td><?= $row['emp_id']; ?></td>
                            <td><?= $row['empname']; ?></td>
                            
                            <td><?= $row['department_name']; ?></td>
                            <td><?= $row['designation_name']; ?></td>
                            <td><?= $row['applied_from_date']; ?></td>
                            <td><?= $row['applied_to_date']; ?></td>
                            <td>
							
							<?php
							if($row['leave_duration']=='full-day'){
								if($row['no_days'] >1){
									echo 1;
								}
								else{
									echo 1;
								}
								//$row['no_days'] > 1 ? 1
							}
							else{
								echo $row['no_days'];
							}
							
						
						?>
							
							
							</td>
							<?php $tc=$this->login_model->get_total_leaves($row['emp_id'],$current_date);
							$tcm=$this->login_model->get_total_leaves_current_month($row['emp_id'],$current_date);
							?>
							
							
                           <td><?= $tcm; ?></td>
                            <td><?= $tc; ?></td>
							
                            <td><?= $row['reason']; ?></td>
                        </tr>
                <?php  } ?>
            </tbody>
        </table>
    </div>
</div>

