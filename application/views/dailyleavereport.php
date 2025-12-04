<!DOCTYPE html>
<html>
<head>
    <title>Leave Report</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { border: 1px solid black; padding: 10px; text-align: center; }
        .table th { background-color: #007bff; color: white; }
    </style>
</head>
<body>
        <table style="width: 100%; border: none; font-size: 12px;">
            <tr>
                <td style="width: 20%; text-align: center; border: none; ">
                    <img src="<?php echo base_url();?>assets/images/su-logo.png" style="width: 80px; height: auto;">
                </td>
                <td style="width: 60%; text-align: center; border: none; ">
                    <div style="font-size: 20px; font-weight: bold; color:red;">Sandip University</div>
                    <div>Mahiravani, Trimbak Road, Nashik - 422 213</div>
                    <div style="font-size: 14px; font-weight: bold;">Cumulative Leave Report</div>
                    
                </td>
                <td style="width: 20%; text-align: center; border: none; ">
                    
                </td>
                
            </tr>
        </table><div align="right">
		
               <div style="padding:10px 0px"><b>Date:<?php echo date('d-m-Y');?></b><br/>
			   </div>
			   </div>
        <hr>

    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Employee ID</th>
                <th>Employee Name</th>
                <th>School</th>
                <th>Department</th>
				<th>Designation</th>
                <th>Leave Today</th>
                <th>Curr Month Leave </th>
                <th>Cumm Leaves</th>
				<th>Reason</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $count = 1;
            foreach ($leaves as $row) { 
			if($row['today_count']==1) {
			?>
                <tr>
                    <td><?= $count++; ?></td>
                    <td><?= $row['emp_id']; ?></td>
                    <td><?= $row['empname']; ?></td>
                    <td><?= $row['school']; ?></td>
                    <td><?= $row['department_name']; ?></td>
					<td><?= $row['designation_name']; ?></td>
                    <td><?= $row['today_count']; ?></td>
                    <td><?= $row['current_month_count']; ?></td>
                    <td><?= $row['cumulative_count']; ?></td>
					<td><?= $row['reason']; ?></td>
                </tr>
            <?php } } ?>
        </tbody>
    </table>
</body>
</html>
