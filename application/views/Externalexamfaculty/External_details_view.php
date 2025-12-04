<style>
/* Table Styling */
.table-external {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0 6px;
}

.table-external th {
    background-color: #0078d7db;
    color: white;
    font-weight: 600;
    text-align: left;
    padding: 10px 15px;
    border-radius: 6px 0 0 6px;
	width:40%;
}

.table-external td {
    background-color: #f4f6f9;
    padding: 10px 15px;
    border-radius: 0 6px 6px 0;
}

.table-external tr + tr td {
    margin-top: 6px;
}

.table-external a.download-link {
    text-decoration: none;
}

.table-external a.download-link i {
    color: red;
    font-size: 22px;
}
</style>		
				<div class="panel-body ">
					<div class="table-info">   

		<table class="table table-external">
			<tr>
				<th>External Code - Name :</th>
				<td><?=$external[0]['ext_faculty_code']?> - <?=$external[0]['ext_fac_name']?></td>
			</tr>
			<tr>
				<th>Mobile No :</th>
				<td><?=$external[0]['ext_fac_mobile']?></td>
			</tr>
			<tr>
				<th>Email:</th>
				<td><?=$external[0]['ext_fac_email']?></td>
			</tr>
			<tr>
				<th>Designation:</th>
				<td><?=$external[0]['ext_fac_designation']?></td>
			</tr>
			<tr>
				<th>Campus Type:</th>
				<td><?=$external[0]['campus_type']?></td>
			</tr>
			<tr>
				<th>Institute Name:</th>
				<td><?=$external[0]['ext_fac_institute']?></td>
			</tr>	
			
			<tr>
				<th>Institute Address:</th>
				<td><?=$external[0]['ext_fac_institute_address']?></td>
			</tr>
			
			<tr>
				<th>Distance (km):</th>
				<td><?=$external[0]['distance_km']?></td>
			</tr>
			<tr>
				<th>Bank Name:</th>
				<td><?=$external[0]['bank_name']?></td>
			</tr>
			<tr>
				<th>Account Holder Name:</th>
				<td><?=$external[0]['acc_holder_name']?></td>
			</tr>
			<tr>
				<th>Account No:</th>
				<td><?=$external[0]['acc_no']?></td>
			</tr>
			<tr>
				<th>IFSC Code :</th>
				<td><?=$external[0]['ifsc_code']?></td>
			</tr>
			<tr>
				<th>Branch:</th>
				<td><?=$external[0]['branch']?></td>
			</tr>
			<tr>
				<th>Cheque File:</th>
				<td>
					<?php if ($external[0]['cheque_file'] != ''): 
						$b_name = "uploads/phd_renumaration_files/";
						$dwnld_url = base_url()."Upload/download_s3file/".$external[0]['cheque_file'].'?b_name='.$b_name;
					?>
						<a href="<?=$dwnld_url?>" class="download-link" download>
							<i class="fa fa-file-pdf-o" aria-hidden="true"></i>
						</a>
					<?php endif; ?>
				</td>
			</tr>
			<tr>
				<th>ID Card File:</th>
				<td>
					<?php if ($external[0]['id_card_file'] != ''): 
						$b_name = "uploads/phd_renumaration_files/";
						$dwnld_url = base_url()."Upload/download_s3file/".$external[0]['id_card_file'].'?b_name='.$b_name;
					?>
						<a href="<?=$dwnld_url?>" class="download-link" download>
							<i class="fa fa-file-pdf-o" aria-hidden="true"></i>
						</a>
					<?php endif; ?>
				</td>
			</tr>
		</table>
		
				  </div>
				  </div> 
                               
									
							           
								

 

