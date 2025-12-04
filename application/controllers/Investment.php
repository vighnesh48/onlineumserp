<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Investment extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Investment_model');
        $this->load->library(['form_validation','session','encryption']);
        $this->load->helper(['url','form','encryption']);
		$menu_name=$this->uri->segment(1);        
        $this->data['my_privileges']=$this->retrieve_privileges($menu_name);
		if (($this->session->userdata("name") !='sunerp' && $this->session->userdata("name")!='suerp_aryan' && $this->session->userdata("name")!='662659' && $this->session->userdata("name")!='310118')) {
            redirect('home');
        }
    }

    public function index() {
        $data['investments'] = $this->Investment_model->get_all();
		$this->load->view('header',$this->data); 
        $this->load->view('investments/list', $data);
		$this->load->view('footer',$this->data); 
    }

    public function create() {
        if ($this->input->post()) {
            $this->_validate();
            if ($this->form_validation->run()) {
                $data = $this->input->post(NULL, TRUE);
                $this->Investment_model->insert($data);
                $this->session->set_flashdata('success', 'Investment added successfully!');
                return redirect('investment');
            }
        }
		$this->load->view('header',$this->data); 
        $this->load->view('investments/create');
		$this->load->view('footer',$this->data);
    }

    public function edit($encoded_id) {
        $id = decrypt_id($encoded_id);
        if (!$id || !is_numeric($id)) {
            show_error("Invalid request", 403);
        }

        $data['investment'] = $this->Investment_model->get_by_id($id);
        if (!$data['investment']) {
            show_404();
        }

        if ($this->input->post()) {
            $this->_validate();
            if ($this->form_validation->run()) {
                $update = $this->input->post(NULL, TRUE);
                $this->Investment_model->update($id, $update);
                $this->session->set_flashdata('success', 'Investment updated successfully!');
                return redirect('investment');
            }
        }

        $data['encoded_id'] = encrypt_id($id);
		$this->load->view('header',$this->data); 
        $this->load->view('investments/edit', $data);
		$this->load->view('footer',$this->data);
    }

    public function delete() {
        if (!$this->input->post()) {
            show_error("Invalid request", 405);
        }

        $encoded_id = $this->input->post('id');
        $id = decrypt_id($encoded_id);
        if (!$id || !is_numeric($id)) {
            show_error("Invalid request", 403);
        }

        $this->Investment_model->delete($id);
        $this->session->set_flashdata('success', 'Investment deleted successfully!');
        return redirect('investment');
    }

    private function _validate() {
		
		$this->form_validation->set_rules('status', 'Status', 'required|in_list[Active,Closed,Matured]');
		$this->form_validation->set_rules('investment_type', 'Investment Type', 'required|trim');
       /*  $this->form_validation->set_rules('investment_id', 'Investment ID', 'required|trim|max_length[20]');
        $this->form_validation->set_rules('bank_institution', 'Bank/Institution', 'required|trim|max_length[100]');
        $this->form_validation->set_rules('account_id', 'Account ID', 'required|integer');
        $this->form_validation->set_rules('investment_number', 'Investment Number', 'required|trim|max_length[50]');
        $this->form_validation->set_rules('start_date', 'Start Date', 'required|callback__valid_date');
        $this->form_validation->set_rules('maturity_date', 'Maturity Date', 'required|callback__valid_date|callback__check_maturity_date');
        $this->form_validation->set_rules('amount', 'Amount', 'required|numeric|greater_than[0]');
        $this->form_validation->set_rules('maturity_amount', 'Maturity Amount', 'numeric|greater_than[0]');
        $this->form_validation->set_rules('rate', 'Rate (%)', 'required|decimal|greater_than[0]|less_than[100]');
        $this->form_validation->set_rules('poc_name', 'POC Name', 'required|trim|max_length[100]');
        $this->form_validation->set_rules('poc_number', 'POC Number', 'required|regex_match[/^[0-9]{10}$/]');
        $this->form_validation->set_rules('remarks', 'Remarks', 'trim|max_length[255]'); */
		 // Dynamic rules
     $type = $this->input->post('investment_type');
     switch ($type) {
        case 'Equity':
            $this->form_validation->set_rules('company_name', 'Company Name', 'required');
            $this->form_validation->set_rules('purchase_date', 'Purchase Date', 'required|callback__valid_date');
            $this->form_validation->set_rules('stock_code', 'Stock Code', 'required');
            $this->form_validation->set_rules('no_of_shares', 'No. of Shares', 'required|integer');
            $this->form_validation->set_rules('market_value', 'Market Value', 'required|numeric');
            $this->form_validation->set_rules('total_value', 'Total Value', 'required|numeric');
            $this->form_validation->set_rules('broker_name', 'Broker Name', 'required');
            break;

        case 'Mutual Fund':
            $this->form_validation->set_rules('mf_company', 'MF Company', 'required');
            $this->form_validation->set_rules('mf_purchase_date', 'Purchase Date', 'required|callback__valid_date');
            $this->form_validation->set_rules('mf_code', 'MF Code', 'required');
            $this->form_validation->set_rules('no_of_units', 'Units', 'required|integer');
            $this->form_validation->set_rules('price_per_unit', 'Price/Unit', 'required|numeric');
            $this->form_validation->set_rules('mf_total_value', 'Total Value', 'required|numeric');
            $this->form_validation->set_rules('mf_broker', 'Broker Name', 'required');
            break;

        case 'Mediclaim':
            $this->form_validation->set_rules('insured_since', 'Insured Since', 'required|callback__valid_date');
            $this->form_validation->set_rules('renewal_date', 'Renewal Date', 'required|callback__valid_date');
            $this->form_validation->set_rules('policy_no', 'Policy No', 'required');
            $this->form_validation->set_rules('policy_holder', 'Policy Holder', 'required');
            $this->form_validation->set_rules('premium_amt', 'Premium Amount', 'required|numeric');
            $this->form_validation->set_rules('sum_assured', 'Sum Assured', 'required|numeric');
            $this->form_validation->set_rules('plan_name', 'Plan', 'required');
            break;

        case 'Insurance':
            $this->form_validation->set_rules('policy_date', 'Policy Date', 'required|callback__valid_date');
            $this->form_validation->set_rules('maturity_year', 'Maturity Year', 'required');
            $this->form_validation->set_rules('insurance_maturity_date', 'Maturity Date', 'required|callback__valid_date');
            $this->form_validation->set_rules('insurance_policy_holder', 'Policy Holder', 'required');
            $this->form_validation->set_rules('nominee', 'Nominee', 'required');
            $this->form_validation->set_rules('insurance_policy_number', 'Policy Number', 'required');
            $this->form_validation->set_rules('insurance_premium_amt', 'Premium Amount', 'required|numeric');
            $this->form_validation->set_rules('insurance_sum_assured', 'Sum Assured', 'required|numeric');
            $this->form_validation->set_rules('insurance_plan', 'Plan Name', 'required');
            $this->form_validation->set_rules('insurance_company', 'Company Name', 'required');
            break; 
			
			case 'Fixed Deposit':
            $this->form_validation->set_rules('investment_id', 'Investment ID', 'required|trim|max_length[20]');
			$this->form_validation->set_rules('bank_institution', 'Bank/Institution', 'required|trim|max_length[100]');
			$this->form_validation->set_rules('account_id', 'Account ID', 'required|integer');
			$this->form_validation->set_rules('investment_number', 'Investment Number', 'required|trim|max_length[50]');
			$this->form_validation->set_rules('start_date', 'Start Date', 'required|callback__valid_date');
			$this->form_validation->set_rules('maturity_date', 'Maturity Date', 'required|callback__valid_date|callback__check_maturity_date');
			$this->form_validation->set_rules('amount', 'Amount', 'required|numeric|greater_than[0]');
			$this->form_validation->set_rules('maturity_amount', 'Maturity Amount', 'numeric|greater_than[0]');
			$this->form_validation->set_rules('rate', 'Rate (%)', 'required|decimal|greater_than[0]|less_than[100]');
			$this->form_validation->set_rules('poc_name', 'POC Name', 'required|trim|max_length[100]');
			$this->form_validation->set_rules('poc_number', 'POC Number', 'required|regex_match[/^[0-9]{10}$/]');
			$this->form_validation->set_rules('remarks', 'Remarks', 'trim|max_length[255]');
            break;
        }
    }

    public function _valid_date($date) {
        if (DateTime::createFromFormat('Y-m-d', $date) === FALSE) {
            $this->form_validation->set_message('_valid_date', 'The {field} is not a valid date.');
            return FALSE;
        }
        return TRUE;
    }

    public function _check_maturity_date($maturity_date) {
        $start_date = $this->input->post('start_date');
        if (strtotime($maturity_date) <= strtotime($start_date)) {
            $this->form_validation->set_message('_check_maturity_date', 'Maturity Date must be later than Start Date.');
            return FALSE;
        }
        return TRUE;
    }

public function upload_investment_data()
{
    $this->load->view('header', $this->data);
    $this->load->library(['Excel', 'form_validation']);

    if ($_POST) {
        $path = $_FILES["file"]["tmp_name"];
        $object = PHPExcel_IOFactory::load($path);

        $allowedTypes = [
            'Fixed Deposit','Mutual Fund','Bond','Equity','Insurance','Mediclaim','Others'
        ];

        $successCount = 0;
        $errorRows = [];

        foreach ($object->getWorksheetIterator() as $worksheet) {
            $highestRow = $worksheet->getHighestRow();

            for ($row = 2; $row <= $highestRow; $row++) {
                $data = [];
                // ---------------- Common fields ----------------
				$data['investment_type']    = trim($worksheet->getCellByColumnAndRow(1, $row)->getValue());
				$data['status']             = trim($worksheet->getCellByColumnAndRow(2, $row)->getValue());
				
				
				if($data['investment_type']=='Fixed Deposit'){
				// ---------------- Fix Deposit ----------------
                $data['investment_id']      = trim($worksheet->getCellByColumnAndRow(3, $row)->getValue());
                $data['bank_institution']   = trim($worksheet->getCellByColumnAndRow(4, $row)->getValue());
                $data['account_id']         = trim($worksheet->getCellByColumnAndRow(5, $row)->getValue());
                $data['investment_number']  = trim($worksheet->getCellByColumnAndRow(6, $row)->getValue());
                $data['start_date']         = $this->convertExcelDate($worksheet->getCellByColumnAndRow(7, $row)->getValue());
                $data['maturity_date']      = $this->convertExcelDate($worksheet->getCellByColumnAndRow(8, $row)->getValue());
                $data['amount']             = trim($worksheet->getCellByColumnAndRow(9, $row)->getValue());
                $data['rate']               = trim($worksheet->getCellByColumnAndRow(10, $row)->getValue());
                $data['maturity_amount']    = trim($worksheet->getCellByColumnAndRow(11, $row)->getValue());
                $data['poc_name']           = trim($worksheet->getCellByColumnAndRow(12, $row)->getValue());
                $data['poc_number']         = trim($worksheet->getCellByColumnAndRow(13, $row)->getValue());
                $data['remarks']            = trim($worksheet->getCellByColumnAndRow(14, $row)->getValue());
				}
				if($data['investment_type']=='Equity'){
                // ---------------- Equity ----------------
                $data['company_name']       = trim($worksheet->getCellByColumnAndRow(3, $row)->getValue());
                $data['purchase_date']      = $this->convertExcelDate($worksheet->getCellByColumnAndRow(4, $row)->getValue());
                $data['stock_code']         = trim($worksheet->getCellByColumnAndRow(5, $row)->getValue());
                $data['no_of_shares']       = trim($worksheet->getCellByColumnAndRow(6, $row)->getValue());
                $data['market_value']       = trim($worksheet->getCellByColumnAndRow(7, $row)->getValue());
                $data['total_value']        = trim($worksheet->getCellByColumnAndRow(8, $row)->getValue());
                $data['broker_name']        = trim($worksheet->getCellByColumnAndRow(9, $row)->getValue());
                $data['broker_address']     = trim($worksheet->getCellByColumnAndRow(10, $row)->getValue());
                $data['broker_contact']     = trim($worksheet->getCellByColumnAndRow(11, $row)->getValue());
				}
				if($data['investment_type']=='Mutual Fund'){
                // ---------------- Mutual Fund ----------------
                $data['mf_company']         = trim($worksheet->getCellByColumnAndRow(3, $row)->getValue());
                $data['mf_purchase_date']   = $this->convertExcelDate($worksheet->getCellByColumnAndRow(4, $row)->getValue());
                $data['mf_code']            = trim($worksheet->getCellByColumnAndRow(5, $row)->getValue());
                $data['no_of_units']        = trim($worksheet->getCellByColumnAndRow(6, $row)->getValue());
                $data['price_per_unit']     = trim($worksheet->getCellByColumnAndRow(7, $row)->getValue());
                $data['mf_total_value']     = trim($worksheet->getCellByColumnAndRow(8, $row)->getValue());
                $data['mf_broker']          = trim($worksheet->getCellByColumnAndRow(9, $row)->getValue());
                $data['mf_broker_address']  = trim($worksheet->getCellByColumnAndRow(10, $row)->getValue());
                $data['mf_broker_contact']  = trim($worksheet->getCellByColumnAndRow(11, $row)->getValue());
                }
				if($data['investment_type']=='Mediclaim'){
                // ---------------- Mediclaim ----------------
                $data['insured_since']      = $this->convertExcelDate($worksheet->getCellByColumnAndRow(3, $row)->getValue());
                $data['renewal_date']       = $this->convertExcelDate($worksheet->getCellByColumnAndRow(4, $row)->getValue());
                $data['policy_no']          = trim($worksheet->getCellByColumnAndRow(5, $row)->getValue());
                $data['policy_holder']      = trim($worksheet->getCellByColumnAndRow(6, $row)->getValue());
                $data['premium_amt']        = trim($worksheet->getCellByColumnAndRow(7, $row)->getValue());
                $data['sum_assured']        = trim($worksheet->getCellByColumnAndRow(8, $row)->getValue());
                $data['plan_name']          = trim($worksheet->getCellByColumnAndRow(9, $row)->getValue());
                $data['policy_name']        = trim($worksheet->getCellByColumnAndRow(10, $row)->getValue());
                }
                 
                 if($data['investment_type']=='Insurance'){				 
                // ---------------- Insurance ----------------
                $data['policy_date']            = $this->convertExcelDate($worksheet->getCellByColumnAndRow(3, $row)->getValue());
                $data['maturity_year']          = trim($worksheet->getCellByColumnAndRow(4, $row)->getValue());
                $data['insurance_maturity_date']= $this->convertExcelDate($worksheet->getCellByColumnAndRow(5, $row)->getValue());
                $data['insurance_policy_holder']= trim($worksheet->getCellByColumnAndRow(6, $row)->getValue());
                $data['nominee']                = trim($worksheet->getCellByColumnAndRow(7, $row)->getValue());
                $data['insurance_policy_number']= trim($worksheet->getCellByColumnAndRow(8, $row)->getValue());
                $data['insurance_premium_amt']  = trim($worksheet->getCellByColumnAndRow(9, $row)->getValue());
                $data['insurance_sum_assured']  = trim($worksheet->getCellByColumnAndRow(10, $row)->getValue());
                $data['insurance_plan']         = trim($worksheet->getCellByColumnAndRow(11, $row)->getValue());
                $data['insurance_company']      = trim($worksheet->getCellByColumnAndRow(12, $row)->getValue());
                 }
                // ---------------- Validation ----------------
                if (!in_array($data['investment_type'], $allowedTypes)) {
                    $errorRows[] = [
                        'row' => $row,
                        'errors' => "Invalid Investment Type ({$data['investment_type']})"
                    ];
                    continue;
                }

                $this->form_validation->reset_validation();
                $this->form_validation->set_data($data);
                $this->_validate();

                if ($this->form_validation->run() == FALSE) {
                    $errorRows[] = [
                        'row' => $row,
                        'errors' => strip_tags(validation_errors())
                    ];
                    continue;
                }

                // ---------------- Insert ----------------
                $data['created_at'] = date("Y-m-d H:i:s");
                if ($this->db->insert('active_investments', $data)) {
					//echo $this->db->last_query();exit;
                    $successCount++;
                } else {
                    $errorRows[] = [
                        'row' => $row,
                        'errors' => "Database Insert Failed"
                    ];
                }
            }
        }

        // ✅ Prepare summary for view
        $summary  = "<h3>Upload Completed</h3>";
        $summary .= "<p><b>Successful Inserts:</b> {$successCount}</p>";
        $summary .= "<p><b>Failed Rows:</b> ".count($errorRows)."</p>";

        if (!empty($errorRows)) {
            $summary .= "<table class='table table-bordered'>";
            $summary .= "<tr class='danger'><th>Row</th><th>Error(s)</th></tr>";
            foreach ($errorRows as $err) {
                $summary .= "<tr><td>{$err['row']}</td><td>{$err['errors']}</td></tr>";
            }
            $summary .= "</table>";
            $summary .= "<br><p>Please correct these rows in Excel and re-upload only those.</p>";
        }

        // Pass to view
        $this->data['upload_summary'] = $summary;
    }

    $this->load->view($this->view_dir . 'investments/employee_investment_data_import_excel.php', $this->data);
    $this->load->view('footer');
}

// Helper for converting Excel dates
private function convertExcelDate($excelValue) {
    if (empty($excelValue)) return null;

    if (is_numeric($excelValue)) {
        return date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($excelValue));
    } else {
        return date('Y-m-d', strtotime($excelValue));
    }
}

}
