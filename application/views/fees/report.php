<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Management</a></li>
        <li class="active"><a href="#">Summary List</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-8 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;  Admission Session wise Fees Summary : </h1>
            <div class="col-xs-12 col-sm-4">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-sm-12"></div>
        </div>
        
		  <div class="row ">
			 
            <div class="col-sm-12">
				<div class="panel">
                    <div class="panel-heading">
					
					
					<div class="row ">
            <div class="col-sm-12"><form name="form" method="POST" action="<?=base_url('Feesummary/report')?>">
							<span class="col-sm-2">
								<select name="admission_session" class="form-control" required>
									<option value="">--select--</option>
									<option value="2021" <?php if($admission_session==2021){ echo "selected";}?>>2021</option>
									<option value="2022" <?php if($admission_session==2022){ echo "selected";}?>>2022</option>
									<option value="2023" <?php if($admission_session==2023){ echo "selected";}?>>2023</option>
									<option value="2024" <?php if($admission_session==2024){ echo "selected";}?>>2024</option>
									<option value="2025" <?php if($admission_session==2025){ echo "selected";}?>>2025</option>
								</select>
								</span>
								<span class="col-sm-2">
								<select name="admission_type" class="form-control" required>
									<option value="">--select--</option>
									<option value="" <?php if($admission_type==''){ echo "selected";}?>>All Admission</option>
									<option value="1" <?php if($admission_type==1){ echo "selected";}?>>First Year Admission</option>
									<option value="2" <?php if($admission_type==2){ echo "selected";}?>>Lateral Admission</option>
									
								</select>
								</span>
								<span class="col-sm-2">
								<input type="submit" class="btn btn-primary form-control col-sm-2" value="submit">
								</span>
								</form>
								<a href="<?= current_url().'?'.http_build_query(array_merge($_GET, ['export'=>'excel','admission_session'=>$admission_session,'admission_type'=>$admission_type])) ?>" class="btn btn-success btn-sm">Download Excel</a>
								</div>
        </div>
					
                           
							 
							
                    </div>
                    <div class="panel-body">
						<div class="col-sm-12">
                        <div class="table-info">  
							<div style="overflow-x: auto; white-space: nowrap; position: relative;"> 
																	
							
    <table class="table table-bordered table-striped table-sm" >
        <thead>
        <tr>
		<th>Sr.No</th>
            <th>PRN</th>
            <th>Student Name</th>
            <th>Mobile</th>
            <th>Gender</th>
            <th>School</th>
            <th>Course</th>
            <th>Stream</th>
            <th>Uniform</th>
            <th>1st Year AY</th>
            <th>1st OpBal</th>
            <th>1st Actual</th>
            <th>1st Scholarship</th>
            <th>1st Applicable</th>
            <th>1st Paid</th>
            <th>1st Refund</th>
            <th>1st NetPaid</th>
            <th>1st Balance</th>
            <th>1st Hostel</th>
            <th>2nd Year AY</th>
            <th>2nd OpBal</th>
            <th>2nd Actual</th>
            <th>2nd Scholarship</th>
            <th>2nd Applicable</th>
            <th>2nd Paid</th>
            <th>2nd Refund</th>
            <th>2nd NetPaid</th>
            <th>2nd Balance</th>
            <th>2nd Hostel</th>
			<th>3rd Year AY</th>
            <th>3rd OpBal</th>
            <th>3rd Actual</th>
            <th>3rd Scholarship</th>
            <th>3rd Applicable</th>
            <th>3rd Paid</th>
            <th>3rd Refund</th>
            <th>3rd NetPaid</th>
            <th>3rd Balance</th>
            <th>3rd Hostel</th>
			<th>4th Year AY</th>
            <th>4th OpBal</th>
            <th>4th Actual</th>
            <th>4th Scholarship</th>
            <th>4th Applicable</th>
            <th>4th Paid</th>
            <th>4th Refund</th>
            <th>4th NetPaid</th>
            <th>4th Balance</th>
            <th>4th Hostel</th>
			<th>5th Year AY</th>
            <th>5th OpBal</th>
            <th>5th Actual</th>
            <th>5th Scholarship</th>
            <th>5th Applicable</th>
            <th>5th Paid</th>
            <th>5th Refund</th>
            <th>5th NetPaid</th>
            <th>5th Balance</th>
            <th>5th Hostel</th>
            <!-- add 3rd–5th years -->
        </tr>
        </thead>
        <tbody>
        <?php $i=1;foreach ($rows as $r): ?>
            <tr>
                <td><?= $i ?></td>
                <td><?= $r['enrollment_no'] ?></td>
                <td><?= $r['first_name'] ?></td>
                <td><?= $r['mobile'] ?></td>
                <td><?= $r['gender'] ?></td>
                <td><?= $r['school_short_name'] ?></td>
                <td><?= $r['course_short_name'] ?></td>
                <td><?= $r['stream_name'] ?></td>
                <td><?= $r['uniform_status'] ?></td>
                <td><?= $r['y1_ay'] ?></td>
                <td><?= $r['y1_opbal'] ?></td>
                <td><?= $r['y1_actual'] ?></td>
                <td><?= $r['y1_scholarship'] ?></td>
                <td><?= $r['y1_applicable'] ?></td>
                <td><?= $r['y1_paid'] ?></td>
                <td><?= $r['y1_refund'] ?></td>
                <td><?= $r['y1_netpaid'] ?></td>
                <td><?= $r['y1_balance'] ?></td>
                <td><?= $r['y1_hostel'] ?></td>
                <td><?= $r['y2_ay'] ?></td>
                <td><?= $r['y2_opbal'] ?></td>
                <td><?= $r['y2_actual'] ?></td>
                <td><?= $r['y2_scholarship'] ?></td>
                <td><?= $r['y2_applicable'] ?></td>
                <td><?= $r['y2_paid'] ?></td>
                <td><?= $r['y2_refund'] ?></td>
                <td><?= $r['y2_netpaid'] ?></td>
                <td><?= $r['y2_balance'] ?></td>
                <td><?= $r['y2_hostel'] ?></td>
				<td><?= $r['y3_ay'] ?></td>
                <td><?= $r['y3_opbal'] ?></td>
                <td><?= $r['y3_actual'] ?></td>
                <td><?= $r['y3_scholarship'] ?></td>
                <td><?= $r['y3_applicable'] ?></td>
                <td><?= $r['y3_paid'] ?></td>
                <td><?= $r['y3_refund'] ?></td>
                <td><?= $r['y3_netpaid'] ?></td>
                <td><?= $r['y3_balance'] ?></td>
                <td><?= $r['y3_hostel'] ?></td>
				<td><?= $r['y4_ay'] ?></td>
                <td><?= $r['y4_opbal'] ?></td>
                <td><?= $r['y4_actual'] ?></td>
                <td><?= $r['y4_scholarship'] ?></td>
                <td><?= $r['y4_applicable'] ?></td>
                <td><?= $r['y4_paid'] ?></td>
                <td><?= $r['y4_refund'] ?></td>
                <td><?= $r['y4_netpaid'] ?></td>
                <td><?= $r['y4_balance'] ?></td>
                <td><?= $r['y4_hostel'] ?></td>
				<td><?= $r['y5_ay'] ?></td>
                <td><?= $r['y5_opbal'] ?></td>
                <td><?= $r['y5_actual'] ?></td>
                <td><?= $r['y5_scholarship'] ?></td>
                <td><?= $r['y5_applicable'] ?></td>
                <td><?= $r['y5_paid'] ?></td>
                <td><?= $r['y5_refund'] ?></td>
                <td><?= $r['y5_netpaid'] ?></td>
                <td><?= $r['y5_balance'] ?></td>
                <td><?= $r['y5_hostel'] ?></td>
            </tr>
        <?php $i++;endforeach; ?>
        </tbody>
    </table>

	</div>
	</div>
						</div>
                    </div>
                </div>
			</div>
			<!--/form-->		
		</div>
			
    </div>
</div>

<style>
.table thead th {
  position: sticky;
  top: 0;
  z-index: 10;
}
.table th,
.table td {
  white-space: nowrap;
}
</style>