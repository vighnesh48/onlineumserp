<!DOCTYPE html>
<html>
<head>
    <title>Edit Investment</title>
    <!-- Bootstrap 3 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container-fluid" style="margin-top:70px;">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h4 class="panel-title">✏️ Edit Investment Details</h4>
        </div>
        <div class="panel-body" style="background-color:rgb(217,237,247);">

            <!-- Flash Messages -->
            <?php if($this->session->flashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <?= $this->session->flashdata('error') ?>
                </div>
            <?php endif; ?>

            <?= form_open('investment/edit/'.$encoded_id, ['class' => 'form-horizontal']) ?>

            <div class="form-group">
                
                <div class="col-md-4">
                    <label for="investment_type">Investment Type</label>
                    <select id="investment_type" name="investment_type" class="form-control">
                        <option value="">-- Select Investment Type --</option>
                        <option value="Fixed Deposit" <?= set_select('investment_type','Fixed Deposit',$investment->investment_type=='Fixed Deposit') ?>>Fixed Deposit</option>
                        <option value="Mutual Fund" <?= set_select('investment_type','Mutual Fund',$investment->investment_type=='Mutual Fund') ?>>Mutual Fund</option>
                        <!--option value="Bond" <?= set_select('investment_type','Bond',$investment->investment_type=='Bond') ?>>Bond</option-->
                        <option value="Equity" <?= set_select('investment_type','Equity',$investment->investment_type=='Equity') ?>>Equity</option>
                        <option value="Insurance" <?= set_select('investment_type','Insurance',$investment->investment_type=='Insurance') ?>>Insurance Policy</option>
                        <option value="Mediclaim" <?= set_select('investment_type','Mediclaim',$investment->investment_type=='Mediclaim') ?>>Mediclaim</option>
                        <!--option value="Others" <?= set_select('investment_type','Others',$investment->investment_type=='Others') ?>>Others</option-->
                    </select>
                    <small class="text-danger"><?= form_error('investment_type') ?></small>
                </div>
				<div class="col-md-4">
                    <label for="status">Status</label>
                    <select id="status" name="status" class="form-control">
                        <option value="">-- Select Status --</option>
                        <option value="Active" <?= set_select('status','Active',$investment->status=='Active') ?>>Active</option>
                        <option value="Closed" <?= set_select('status','Closed',$investment->status=='Closed') ?>>Closed</option>
                        <option value="Matured" <?= set_select('status','Matured',$investment->status=='Matured') ?>>Matured</option>
                    </select>
                    <small class="text-danger"><?= form_error('status') ?></small>
                </div>
				</div>


            <!-- Dynamic Extra Fields -->
            <div class="form-group">
                <div class="col-md-12" id="extra-fields"></div>
            </div>

            <div class="form-group">
                <div class="col-md-12 text-right">
                    <a href="<?= site_url('investment') ?>" class="btn btn-default">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Investment</button>
                </div>
            </div>

            <?= form_close() ?>
        
    </div>
</div>
<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script>
    // Pass old POST values (or DB $investment values when editing)
    let oldValues = <?= json_encode($investment ?: $this->input->post()) ?>;
    // Pass validation errors from PHP
    let errors = <?= json_encode($this->form_validation->error_array() ?: []) ?>;
$(function () {
  $('[data-toggle="popover"]').popover({ trigger: 'focus hover' });
});

    $(document).ready(function() {

        function loadExtraFields(type) {
            let html = '';

            // ------------------ EQUITY ------------------
            if (type === 'Equity') {
                html = `
                <div class="form-group">
                    <div class="col-md-4">
					  <label for="poc_name">Company Name</label>
                        <input type="text" name="company_name" class="form-control"
                               placeholder="Company Name" value="${oldValues.company_name || ''}">
                        <small class="text-danger">${errors.company_name || ''}</small>
                    </div>
                    <div class="col-md-3">
					  <label for="poc_name">Purchase Date</label>
                        <input type="date" name="purchase_date" class="form-control"
                               placeholder="Purchase Date" value="${oldValues.purchase_date || ''}">
                        <small class="text-danger">${errors.purchase_date || ''}</small>
                    </div>
                    <div class="col-md-4">
					  <label for="poc_name">Stock Code</label>
                        <input type="text" name="stock_code" class="form-control"
                               placeholder="Stock Code" value="${oldValues.stock_code || ''}">
                        <small class="text-danger">${errors.stock_code || ''}</small>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-3">
					<label for="poc_name">No. of Shares</label>
                        <input type="number" name="no_of_shares" class="form-control" placeholder="No. of Shares" value="${oldValues.no_of_shares || ''}">
                        <small class="text-danger">${errors.no_of_shares || ''}</small>
                    </div>
                    <div class="col-md-3">
					<label for="poc_name">Market Value/Share</label>
                        <input type="text" name="market_value" class="form-control" placeholder="Market Value/Share" value="${oldValues.market_value || ''}">
                        <small class="text-danger">${errors.market_value || ''}</small>
                    </div>
                    <div class="col-md-3">
					<label for="poc_name">Total Value</label>
                        <input type="number" name="total_value" class="form-control" placeholder="Total Value" value="${oldValues.total_value || ''}">
                        <small class="text-danger">${errors.total_value || ''}</small>
                    </div>
                    <div class="col-md-3">
					<label for="poc_name">Broker Name</label>
                        <input type="text" name="broker_name" class="form-control" placeholder="Broker Name" value="${oldValues.broker_name || ''}">
                        <small class="text-danger">${errors.broker_name || ''}</small>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-6">
					<label for="poc_name">Broker Address</label>
                        <input type="text" name="broker_address" class="form-control" placeholder="Broker Address" value="${oldValues.broker_address || ''}">
                        <small class="text-danger">${errors.broker_address || ''}</small>
                    </div>
                    <div class="col-md-6">
					<label for="poc_name">Broker Contact No</label>
                        <input type="text" name="broker_contact" class="form-control" placeholder="Broker Contact No" value="${oldValues.broker_contact || ''}">
                        <small class="text-danger">${errors.broker_contact || ''}</small>
                    </div>
                </div>`;
            } 

            // ------------------ MUTUAL FUND ------------------
            else if (type === 'Mutual Fund') {
                html = `
                <div class="form-group">
                    <div class="col-md-4">
					<label for="poc_name">MF Company Name</label>
                        <input type="text" name="mf_company" class="form-control" placeholder="MF Company Name" value="${oldValues.mf_company || ''}">
                        <small class="text-danger">${errors.mf_company || ''}</small>
                    </div>
                    <div class="col-md-3">
					<label for="poc_name">Purchase Date</label>
                        <input type="date" name="mf_purchase_date" class="form-control"
                               placeholder="Purchase Date" value="${oldValues.mf_purchase_date || ''}">
                        <small class="text-danger">${errors.mf_purchase_date || ''}</small>
                    </div>
                    <div class="col-md-4">
					<label for="poc_name">MF Code</label>
                        <input type="text" name="mf_code" class="form-control" placeholder="MF Code" value="${oldValues.mf_code || ''}">
                        <small class="text-danger">${errors.mf_code || ''}</small>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-3">
					<label for="poc_name">No. of Units</label>
                        <input type="number" name="no_of_units" class="form-control" placeholder="No. of Units" value="${oldValues.no_of_units || ''}">
                        <small class="text-danger">${errors.no_of_units || ''}</small>
                    </div>
                    <div class="col-md-3">
					<label for="poc_name">Price/Unit</label>
                        <input type="text" name="price_per_unit" class="form-control" placeholder="Price/Unit" value="${oldValues.price_per_unit || ''}">
                        <small class="text-danger">${errors.price_per_unit || ''}</small>
                    </div>
                    <div class="col-md-3">
					<label for="poc_name">Total Value</label>
                        <input type="number" name="mf_total_value" class="form-control" placeholder="Total Value" value="${oldValues.mf_total_value || ''}">
                        <small class="text-danger">${errors.mf_total_value || ''}</small>
                    </div>
                    <div class="col-md-3">
					<label for="poc_name">Broker Name</label>
                        <input type="text" name="mf_broker" class="form-control" placeholder="Broker Name" value="${oldValues.mf_broker || ''}">
                        <small class="text-danger">${errors.mf_broker || ''}</small>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-6">
					<label for="poc_name">Broker Address</label>
                        <input type="text" name="mf_broker_address" class="form-control" placeholder="Broker Address" value="${oldValues.mf_broker_address || ''}">
                        <small class="text-danger">${errors.mf_broker_address || ''}</small>
                    </div>
                    <div class="col-md-6">
					<label for="poc_name">Broker Contact No</label>
                        <input type="text" name="mf_broker_contact" class="form-control" placeholder="Broker Contact No" value="${oldValues.mf_broker_contact || ''}">
                        <small class="text-danger">${errors.mf_broker_contact || ''}</small>
                    </div>
                </div>`;
            } 

            // ------------------ MEDICLAIM ------------------
            else if (type === 'Mediclaim') {
                html = `
                <div class="form-group">
                    <div class="col-md-4">
					<label for="poc_name">Insured Since</label>
                        <input type="date" name="insured_since" class="form-control"
                               placeholder="Insured Since" value="${oldValues.insured_since || ''}">
                        <small class="text-danger">${errors.insured_since || ''}</small>
                    </div>
                    <div class="col-md-3">
					<label for="poc_name">Date Of Renewal</label>
                        <input type="date" name="renewal_date" class="form-control"
                               placeholder="Date Of Renewal" value="${oldValues.renewal_date || ''}">
                        <small class="text-danger">${errors.renewal_date || ''}</small>
                    </div>
                    <div class="col-md-4">
					<label for="poc_name">Policy No</label>
                        <input type="text" name="policy_no" class="form-control" placeholder="Policy No" value="${oldValues.policy_no || ''}">
                        <small class="text-danger">${errors.policy_no || ''}</small>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-3">
					<label for="poc_name">Policy Holder Name</label>
                        <input type="text" name="policy_holder" class="form-control" placeholder="Policy Holder Name" value="${oldValues.policy_holder || ''}">
                        <small class="text-danger">${errors.policy_holder || ''}</small>
                    </div>
                    <div class="col-md-3">
					<label for="poc_name">Premium Amount</label>
                        <input type="number" name="premium_amt" class="form-control" placeholder="Premium Amount" value="${oldValues.premium_amt || ''}">
                        <small class="text-danger">${errors.premium_amt || ''}</small>
                    </div>
                    <div class="col-md-3">
					<label for="poc_name">Sum Assured</label>
                        <input type="number" name="sum_assured" class="form-control" placeholder="Sum Assured" value="${oldValues.sum_assured || ''}">
                        <small class="text-danger">${errors.sum_assured || ''}</small>
                    </div>
                    <div class="col-md-3">
					<label for="poc_name">Plan</label>
                        <input type="text" name="plan_name" class="form-control" placeholder="Plan" value="${oldValues.plan_name || ''}">
                        <small class="text-danger">${errors.plan_name || ''}</small>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-3">
					<label for="poc_name">Policy Name</label>
                        <input type="text" name="policy_name" class="form-control" placeholder="Policy Name" value="${oldValues.policy_name || ''}">
                        <small class="text-danger">${errors.policy_name || ''}</small>
                    </div>
                </div>`;
            }

            // ------------------ INSURANCE ------------------
            else if (type === 'Insurance') {
                html = `
                <div class="form-group">
                    <div class="col-md-3">
					<label for="poc_name">Date of Policy</label>
                        <input type="date" name="policy_date" class="form-control"
                               placeholder="Date of Policy" value="${oldValues.policy_date || ''}">
                        <small class="text-danger">${errors.policy_date || ''}</small>
                    </div>
                    <div class="col-md-3">
					<label for="poc_name">Maturity Year</label>
                        <input type="text" name="maturity_year" class="form-control" placeholder="Maturity Year" value="${oldValues.maturity_year || ''}">
                        <small class="text-danger">${errors.maturity_year || ''}</small>
                    </div>
                    <div class="col-md-3">
					<label for="poc_name">Maturity Date</label>
                        <input type="date" name="insurance_maturity_date" class="form-control"
                               placeholder="Maturity Date" value="${oldValues.insurance_maturity_date || ''}">
                        <small class="text-danger">${errors.insurance_maturity_date || ''}</small>
                    </div>
                    <div class="col-md-3">
					<label for="poc_name">Policy Holder Name</label>
                        <input type="text" name="insurance_policy_holder" class="form-control" placeholder="Policy Holder Name" value="${oldValues.insurance_policy_holder || ''}">
                        <small class="text-danger">${errors.insurance_policy_holder || ''}</small>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-3">
					<label for="poc_name">Nominee</label>
                        <input type="text" name="nominee" class="form-control" placeholder="Nominee" value="${oldValues.nominee || ''}">
                        <small class="text-danger">${errors.nominee || ''}</small>
                    </div>
                    <div class="col-md-3">
					<label for="poc_name">Policy Name</label>
                        <input type="text" name="insurance_policy_number" class="form-control" placeholder="Policy Number" value="${oldValues.insurance_policy_number || ''}">
                        <small class="text-danger">${errors.insurance_policy_number || ''}</small>
                    </div>
                    <div class="col-md-3">
					<label for="poc_name">Premium Amount</label>
                        <input type="number" name="insurance_premium_amt" class="form-control" placeholder="Premium Amount" value="${oldValues.insurance_premium_amt || ''}">
                        <small class="text-danger">${errors.insurance_premium_amt || ''}</small>
                    </div>
                    <div class="col-md-3">
					<label for="poc_name">Sum Assured</label>
                        <input type="number" name="insurance_sum_assured" class="form-control" placeholder="Sum Assured" value="${oldValues.insurance_sum_assured || ''}">
                        <small class="text-danger">${errors.insurance_sum_assured || ''}</small>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-6">
					<label for="poc_name">Plan Name</label>
                        <input type="text" name="insurance_plan" class="form-control" placeholder="Plan Name" value="${oldValues.insurance_plan || ''}">
                        <small class="text-danger">${errors.insurance_plan || ''}</small>
                    </div>
                    <div class="col-md-6">
					<label for="poc_name">Company Name</label>
                        <input type="text" name="insurance_company" class="form-control" placeholder="Company Name" value="${oldValues.insurance_company || ''}">
                        <small class="text-danger">${errors.insurance_company || ''}</small>
                    </div>
                </div>`;
            }// ------------------ FIXED DEPOSIT ------------------
			else if (type === 'Fixed Deposit') {
				html = `
				<div class="form-group">
					<div class="col-md-4">
						<label for="investment_id">Investment ID</label>
						<input type="text" name="investment_id" class="form-control"
							   placeholder="Enter Investment ID" 
							   value="${oldValues.investment_id || ''}">
						<small class="text-danger">${errors.investment_id || ''}</small>
					</div>
					<div class="col-md-4">
						<label for="bank_institution">Bank / Institution</label>
						<input type="text" name="bank_institution" class="form-control"
							   placeholder="Enter Bank / Institution" 
							   value="${oldValues.bank_institution || ''}">
						<small class="text-danger">${errors.bank_institution || ''}</small>
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-4">
						<label for="account_id">Linked Account ID</label>
						<input type="text" name="account_id" class="form-control"
							   placeholder="Enter Linked Account ID" 
							   value="${oldValues.account_id || ''}">
						<small class="text-danger">${errors.account_id || ''}</small>
					</div>
					<div class="col-md-4">
						<label for="investment_number">Investment Number</label>
						<input type="text" name="investment_number" class="form-control"
							   placeholder="Enter Investment Number" 
							   value="${oldValues.investment_number || ''}">
						<small class="text-danger">${errors.investment_number || ''}</small>
					</div>
					<div class="col-md-2">
						<label for="start_date">Start Date</label>
						<input type="date" name="start_date" class="form-control"
							   value="${oldValues.start_date || ''}">
						<small class="text-danger">${errors.start_date || ''}</small>
					</div>
					<div class="col-md-2">
						<label for="maturity_date">Maturity Date</label>
						<input type="date" name="maturity_date" class="form-control"
							   value="${oldValues.maturity_date || ''}">
						<small class="text-danger">${errors.maturity_date || ''}</small>
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-4">
						<label for="amount">Amount (₹)</label>
						<input type="number" name="amount" class="form-control"
							   placeholder="Enter Amount" 
							   value="${oldValues.amount || ''}">
						<small class="text-danger">${errors.amount || ''}</small>
					</div>
					<div class="col-md-4">
						<label for="rate">Rate (%)</label>
						<input type="text" name="rate" class="form-control"
							   placeholder="Enter Rate %" 
							   value="${oldValues.rate || ''}">
						<small class="text-danger">${errors.rate || ''}</small>
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-6">
						<label for="poc_name">POC Name</label>
						<input type="text" name="poc_name" class="form-control"
							   placeholder="Enter POC Name" 
							   value="${oldValues.poc_name || ''}">
						<small class="text-danger">${errors.poc_name || ''}</small>
					</div>
					<div class="col-md-6">
						<label for="poc_number">POC Number</label>
						<input type="text" name="poc_number" class="form-control"
							   placeholder="Enter POC Number" 
							   value="${oldValues.poc_number || ''}">
						<small class="text-danger">${errors.poc_number || ''}</small>
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-12">
						<label for="remarks">Remarks</label>
						<textarea name="remarks" class="form-control" 
								  placeholder="Enter Remarks">${oldValues.remarks || ''}</textarea>
						<small class="text-danger">${errors.remarks || ''}</small>
					</div>
				</div>`;
			}


            $("#extra-fields").html(html);
        }

        // On dropdown change
        $("select[name='investment_type']").change(function() {
            loadExtraFields($(this).val());
        });

        // Load existing type on refresh/edit
        loadExtraFields($("select[name='investment_type']").val());
    });
</script>

</body>
</html>
