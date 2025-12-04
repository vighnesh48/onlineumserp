<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bankaccount extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('BankAccount_model');
        $this->load->library(['form_validation']);
        $this->load->helper(['form', 'security']); // add helpers
		$menu_name=$this->uri->segment(1);        
        $this->data['my_privileges']=$this->retrieve_privileges($menu_name);
		if (($this->session->userdata("name") !='sunerp' && $this->session->userdata("name")!='suerp_aryan' && $this->session->userdata("name")!='662659' && $this->session->userdata("name")!='310118')) {
            redirect('home');
        }
    }

    public function index() {
        $data['accounts'] = $this->BankAccount_model->get_all();
		$this->load->view('header',$this->data); 
        $this->load->view('bank_accounts/list', $data);
		$this->load->view('footer',$this->data); 
    }

	public function create() {
		if ($this->input->post()) {
			$this->_validate();
			if ($this->form_validation->run() === TRUE) {
				$data = $this->input->post();
				//print_r($data);
				// Check duplicate before insert
				if ($this->BankAccount_model->exists($data['account_number'], $data['ifsc_code'])) {
					$this->session->set_flashdata('error', 'Bank account already exists!');
				} else {
					$this->BankAccount_model->insert($data);
					$this->session->set_flashdata('success', 'Bank account created successfully');
					redirect('bankaccount');
				}
			}
		}

		$this->load->view('header', $this->data); 
		$this->load->view('bank_accounts/create', isset($data) ? $data : []);
		$this->load->view('footer', $this->data); 
	}


   /*  public function edit($id) {
        $data['account'] = $this->BankAccount_model->get($id);
        if (!$data['account']) show_404();
           
        if ($this->input->post()) {
			
            $this->_validate();
			
           // if ($this->form_validation->run()) {
				$dataUpdate = $this->input->post(NULL, TRUE);
                $this->BankAccount_model->update($id, $dataUpdate);
                $this->session->set_flashdata('success', 'Bank account updated successfully');
                return redirect('bankaccount');
            //}
        }
		$this->load->view('header',$this->data); 
        $this->load->view('bank_accounts/edit', $data);
		$this->load->view('footer',$this->data); 
    } */
	
	public function edit($id) {
    $data['account'] = $this->BankAccount_model->get($id);
    if (!$data['account']) show_404();

    if ($this->input->post()) {
        $this->_validate($id); // pass ID to validator

        if ($this->form_validation->run() === TRUE) {
            $dataUpdate = $this->input->post(NULL, TRUE);
            $this->BankAccount_model->update($id, $dataUpdate);
            $this->session->set_flashdata('success', 'Bank account updated successfully');
            return redirect('bankaccount');
        }
    }

    $this->load->view('header',$this->data); 
    $this->load->view('bank_accounts/edit', $data);
    $this->load->view('footer',$this->data); 
}


    public function delete($id) {
        // delete only via POST for safety
        if ($this->input->method(TRUE) !== 'POST') show_error('Invalid request', 405);

        $this->BankAccount_model->delete($id);
        $this->session->set_flashdata('success', 'Bank account deleted successfully');
        redirect('bankaccount');
    }

    private function _validate() {
		//$this->form_validation->set_rules('institute_name', 'Institute Name', 'required|trim');
		$this->form_validation->set_rules('bank_name', 'Bank Name', 'required|trim');
		$this->form_validation->set_rules('branch_name', 'Branch Name', 'required|trim');
		$this->form_validation->set_rules('account_name', 'Account Name', 'required|trim');
		//$this->form_validation->set_rules('signatory_authority', 'Signatory authority type', 'required|trim');
		//$this->form_validation->set_rules('signatory_authority_names1', 'Signatory authority Name 1', 'required|trim');
		//$this->form_validation->set_rules('account_number', 'Account Number', 'required|numeric');
		//$this->form_validation->set_rules('account_no', 'Account Number', 'required|is_unique[bank_accounts.account_no]');

		// IFSC code strict validation
		 $this->form_validation->set_rules(
			'ifsc_code',
			'IFSC Code',
			'required|regex_match[/^[A-Z]{4}0[A-Z0-9]{6}$/]',
			[
				'regex_match' => 'The {field} must be a valid 11-character IFSC (e.g., SBIN0001234).'
			]
		); 
		$this->form_validation->set_rules('account_type', 'Account Type', 'required|in_list[Savings,Current,OD]');
		$this->form_validation->set_rules('poc_name', 'POC Name', 'required|trim');
		$this->form_validation->set_rules('poc_number', 'POC Number', 'required|numeric');
		$this->form_validation->set_rules('status', 'Status', 'required|in_list[Active,Inactive]');
		$this->form_validation->set_rules('remarks', 'Remarks', 'trim');
	}
/* 	private function _validate($id = null) {
    $this->form_validation->set_rules('institute_name', 'Institute Name', 'required|trim');
    $this->form_validation->set_rules('bank_name', 'Bank Name', 'required|trim');
    $this->form_validation->set_rules('branch_name', 'Branch Name', 'required|trim');
    $this->form_validation->set_rules('account_name', 'Account Name', 'required|trim');
    $this->form_validation->set_rules('signatory_authority', 'Signatory authority type', 'required|trim');
    $this->form_validation->set_rules('signatory_authority_names1', 'Signatory authority Name 1', 'required|trim');
    $this->form_validation->set_rules('account_number', 'Account Number', 'required|numeric');

    // ✅ Allow IFSC regex always, but uniqueness check only on create
    if ($id === null) { // create
        $this->form_validation->set_rules(
            'ifsc_code',
            'IFSC Code',
            'required|regex_match[/^[A-Z]{4}0[A-Z0-9]{6}$/]'
        );
    } else { // edit
        $this->form_validation->set_rules(
            'ifsc_code',
            'IFSC Code',
            'required|regex_match[/^[A-Z]{4}0[A-Z0-9]{6}$/]'
        );
    }

    $this->form_validation->set_rules('account_type', 'Account Type', 'required|in_list[Savings,Current,OD]');
    $this->form_validation->set_rules('poc_name', 'POC Name', 'required|trim');
    $this->form_validation->set_rules('poc_number', 'POC Number', 'required|numeric');
    $this->form_validation->set_rules('status', 'Status', 'required|in_list[Active,Inactive]');
    $this->form_validation->set_rules('remarks', 'Remarks', 'trim');
} */

	          // ✅ Upload bank accounts from Excel
    public function upload_bankaccount_data()
    {
		
        $this->load->view('header', $this->data);
        $this->load->library(['Excel', 'form_validation']);

        if ($_POST) {
            $path = $_FILES["file"]["tmp_name"];
            $object = PHPExcel_IOFactory::load($path);

            $successCount = 0;
            $errorRows = [];

            foreach ($object->getWorksheetIterator() as $worksheet) {
                $highestRow = $worksheet->getHighestRow();

                for ($row = 2; $row <= $highestRow; $row++) {
                    $data = [
                        'institute_name'             => trim($worksheet->getCellByColumnAndRow(1, $row)->getValue()),
                        'account_name'               => trim($worksheet->getCellByColumnAndRow(2, $row)->getValue()),
                        'account_number'             => trim($worksheet->getCellByColumnAndRow(3, $row)->getValue()),
                        'bank_name'                  => trim($worksheet->getCellByColumnAndRow(4, $row)->getValue()),
                        'branch_name'                => trim($worksheet->getCellByColumnAndRow(5, $row)->getValue()),
                        'signatory_authority'        => trim($worksheet->getCellByColumnAndRow(6, $row)->getValue()),
                        'signatory_authority_names1' => trim($worksheet->getCellByColumnAndRow(7, $row)->getValue()),
                        'signatory_authority_names2' => trim($worksheet->getCellByColumnAndRow(8, $row)->getValue()),
                        'ifsc_code'                  => trim($worksheet->getCellByColumnAndRow(9, $row)->getValue()),
                        'account_type'               => trim($worksheet->getCellByColumnAndRow(10, $row)->getValue()),
                        'status'                     => trim($worksheet->getCellByColumnAndRow(11, $row)->getValue()),
                        'poc_name'                   => trim($worksheet->getCellByColumnAndRow(12, $row)->getValue()),
                        'poc_number'                 => trim($worksheet->getCellByColumnAndRow(13, $row)->getValue()),
                        'poc_email'                  => trim($worksheet->getCellByColumnAndRow(14, $row)->getValue()),
                        'remarks'                    => trim($worksheet->getCellByColumnAndRow(15, $row)->getValue())
                    ];

                    // ✅ Validation
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

                    // ✅ Insert
                    //$data['created_at'] = date("Y-m-d H:i:s");
                    if ($this->db->insert('bank_accounts', $data)) {
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

            // ✅ Upload summary
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

            $this->data['upload_summary'] = $summary;
        }

        $this->load->view($this->view_dir . 'bank_accounts/employee_bankaccounts_data_import_excel.php', $this->data);
        $this->load->view('footer');
    }


}
