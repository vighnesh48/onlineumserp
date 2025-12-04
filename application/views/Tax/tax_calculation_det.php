				
                    <div class="panel-body ">
                        <div class="table-info">   
						<table class="table table-bordered">
						<tr>
						  <th scope="col">Staff ID / Employee Name / Joining Date:</th><td><?=$tax_cred_det['emp_id']?> / <?=$tax_cred_det['fname'].' '.$tax_cred_det['mname'].' '.$tax_cred_det['lname']?> / <?=$tax_cred_det['joiningDate']?></td>
						</tr>
							<tr>
    					  <th scope="col">Taxable Income :</th><td><?php echo preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $taxable_income);
                           ?></td>
    					</tr>
						<tr>
    					  <th scope="col">Tax :</th><td><?php echo preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $final_tax) ?> </td>
    					</tr>
    					<tr>
    					  <th width="25%">Gross Salary :</th><td><?php echo preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $gross_salary) ?></td>
						</tr>
						<tr>
    					  <th width="25%">Standared deduction 40k:</th><td><?php echo preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", 50000)?></td>
						</tr>
						<tr>
						  <th scope="col">HRA :</th><td><?php echo preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $tot_hra) ?></td>
						</tr>
                        <tr>
    					  <th scope="col">PT:</th><td><?php echo preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $ptax) ?></td>
    					</tr>
                       <tr>
    					  <th scope="col">Medical Premium 80 D :</th><td><?php echo preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $tax_details[0]['medical_premium_amount']) ?></td>
    					</tr>	

                        <tr>
    					  <th scope="col">Home Interest :</th><td><?php echo preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $tax_details[0]['house_loan_interest_amount']) ?></td>
    					</tr>
                        <tr>
    					  <th scope="col">EPF :</th><td><?php echo preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $epf)  ?></td>
    					</tr>
                          <tr>
    					  <th scope="col">NSC :</th><td><?php echo preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $tax_details[0]['nsc_amount']) ?></td>
    					</tr>
                         <tr>
    					 <th scope="col">Pension Scheme /MF :</th><td><?php echo preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $tax_details[0]['pension_plan_amount'])  ?></td>
    					</tr>
						<tr>
    					  <th scope="col">PPF :</th><td><?php echo preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $tax_details[0]['provident_fund_amount']) ?></td>
    					</tr>
						<tr>
    					  <th scope="col">Children Education :</th><td><?php echo preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $tax_details[0]['tuition_fee_amount'])  ?></td>
    					</tr>
						<tr>
    					  <th scope="col">Home Loan :</th><td><?php echo preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $tax_details[0]['houseloan_prin_repay_amount']) ?></td>
    					</tr>
						<tr>
    					  <th scope="col">ELSS :</th><td><?php echo preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $tax_details[0]['elss_amount']) ?></td>
    					</tr>
						<tr>
    					  <th scope="col">Stamp Duty :</th><td><?php echo preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $tax_details[0]['stamp_duty_amount'] ) ?></td>
    					</tr>
						<tr>
    					  <th scope="col">Insurance :</th><td><?php echo preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $tax_details[0]['life_ins_prem_amount']) ?></td>
    					</tr>
						<tr>						
    					  <th scope="col">Bonds & Others :</th><td><?php echo preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $tot_bonds )?></td>
    					</tr>						
						<tr>
    					  <th scope="col">NPS(80c) :</th><td><?php echo preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $tax_details[0]['nps_80c_amount']) ?></td>
    					</tr>
						<tr>
    					  <th scope="col">VPF:</th><td><?php echo preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $tax_details[0]['vpf_amount']) ?></td>
    					</tr>
						<tr>
    					  <th scope="col">SCSS :</th><td><?php echo preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $tax_details[0]['scss_amount']) ?></td>
    					</tr>
						<tr>
    					  <th scope="col">Fixed Deposit :</th><td><?php echo preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $tax_details[0]['txfd_amount'])  ?></td>
    					</tr>
						<tr>
    					  <th scope="col">Sukanya Samriddhi Account :</th><td><?php echo preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $tax_details[0]['suk_sam_acc_amount']) ?></td>
    					</tr>
						<tr>
    					  <th scope="col">Total 80c :</th><td><?php echo preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $tax_details[0]['total_80c']) ?></td>
    					</tr>
						<tr>
    					  <th scope="col">Expenditure On Handicapped Dependents :</th><td><?php echo preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $tax_details[0]['expenditure_amount']) ?></td>
    					</tr>
						<tr>
    					  <th scope="col">Medical  Expenses :</th><td><?php echo preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $tax_details[0]['medical_exp_amount']) ?></td>
    					</tr>
						<tr>
    					  <th scope="col">Interest On Education Loan (for self education) :</th><td><?php echo preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $tax_details[0]['edu_loan_amount']) ?></td>
    					</tr>
						<tr>
    					  <th scope="col">NPS :</th><td><?php echo preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $tax_details[0]['nps_amount']) ?></td>
    					</tr>
						<tr>
    					  <th scope="col">Donation To Certain Funds :</th><td><?php echo preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $tax_details[0]['certain_funds_amount']) ?></td>
    					</tr>
						<tr>
    					  <th scope="col">Permanent Disability Benefit :</th><td><?php echo preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $tax_details[0]['disability_ben_amount']) ?></td>
    					</tr>
						<tr>
    					  <th scope="col">Interest on First Electric Vehicle and Loan :</th><td><?php echo preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $tax_details[0]['vehical_loan_amount']) ?></td>
    					</tr>					
						</table>    				
					  </div>
					  </div> 


 

