<?php

class EcrRenumerationController extends CI_Controller {

    /////////////////////////////////////////////////// code by JP ////////////////////////////////////////////////


    public function __construct() {
        parent::__construct();
        $this->load->model('EcrRenumerationModel'); // Load the model
        $this->load->model('EcrEmpRegModel');

        $menu_name = $this->uri->segment(1);
        $this->data['my_privileges'] = $this->retrieve_privileges($menu_name);
		        $user_name = $this->session->userdata('name'); // this should be email
        // echo $user_name;
    
        // Store center_id in session if matching active entry exists

        $centerData = $this->EcrEmpRegModel->getCenterIdIfUserExists($user_name);

        if (!empty($centerData)) {
            $center_ids = array_column($centerData, 'center_id'); // extract only center_id values
            $this->session->set_userdata('center_ids', $center_ids);
        }
        $center_ids = $this->session->userdata('center_ids');

    }

    // Load View with all records
    public function index() {
        $data['renum_data'] = $this->EcrRenumerationModel->getRenumData(); // Fetch renumeration records

        // Fetch dropdown data for roles and exam sessions
        $data['ecr_roles'] = $this->EcrRenumerationModel->getEcrRoles();
        $data['exam_sessions'] = $this->EcrRenumerationModel->getExamSessions();

        $this->load->view('header', $this->data); // Assuming you have a header view
        $this->load->view('Ecr/ecr_renum_view', $data); // Load the main view
        $this->load->view('footer', $this->data); // Assuming you have a footer view
    }

    // Insert a new record
    public function createRenum() {
        // Get the user ID (logged-in user)
        $user_id = $this->session->userdata('uid');
        
        // Get data from the POST request
        $ecr_role_id = $this->input->post('ecr_role_id');
        $exam_id = $this->input->post('exam_id');
        

            // Check if an entry already exists for the given exam_id and ecr_role_id
            $existingEntry = $this->EcrRenumerationModel->checkExistingEntry($exam_id, $ecr_role_id);
            
            if ($existingEntry) {
                // Entry exists, do not allow insertion and return an error message
                $this->session->set_flashdata('error', 'Entry already exists for the selected exam and role.');
                redirect('EcrRenumerationController'); // Redirect back to the view
                return; // Exit the function to prevent further execution
            }
    
        // Prepare data for insertion
        $data = [
            'ecr_role_id' => $ecr_role_id,
            'exam_id' => $exam_id,
            'academic_year' => $this->input->post('academic_year'),
            'renum' => $this->input->post('renum'),
            'additional_ssn_count' => $this->input->post('add_ssn_count'),
            'created_by' => $user_id // Assuming logged-in user ID
        ];
    
        // Insert the data into the database
        $this->EcrRenumerationModel->insertRenum($data);
        
        // Redirect back to the controller/view after the insertion
        redirect('EcrRenumerationController');
    }
    
    
    public function updateRenum($id) {
        $data = [

            'renum' => $this->input->post('renum'),
            'additional_ssn_count' => $this->input->post('add_ssn_count')
        ];
        $this->EcrRenumerationModel->updateRenum($id, $data);
        redirect('EcrRenumerationController');
    }

    public function payment1() {
        // Fetch dropdown options for roles and exam sessions
        $data['exam_sessions'] = $this->EcrRenumerationModel->getExamSessions();
        $data['ecr_roles'] = $this->EcrRenumerationModel->getEcrRoles();
        
        // Initialize data for display
        $data['employee_payments'] = [];

        // Get filtered employee payment data if filters are applied
        if ($this->input->get()) {
            $exam_id = $this->input->get('exam_id');
            $role_id = $this->input->get('role_id');
            $date = $this->input->get('date');
            
            // Fetch employees and calculate payment
            $data['employee_payments'] = $this->EcrRenumerationModel->getEmployeePaymentData($exam_id, $role_id, $date);
        }

        $this->load->view('header', $this->data); // Assuming you have a header view
        $this->load->view('Ecr/ecr_payment_listing', $data);  // Load the view
        $this->load->view('footer', $this->data); // Assuming you have a footer view
    }

    public function payment() {
        // Fetch dropdown options for roles and exam sessions
        $data['exam_sessions'] = $this->EcrRenumerationModel->getExamSessions();
        $data['ecr_roles'] = $this->EcrRenumerationModel->getEcrRoles();
    
        // Initialize data for display
        $data['employee_payments'] = [];
        $data['selected_exam_id'] = $this->input->get('exam_id');
        $data['selected_role_id'] = $this->input->get('role_id');
        $data['selected_emp_id'] = $this->input->get('employee_id');
        
        // Fetch employees based on selected exam session and role
        if ($data['selected_exam_id'] && $data['selected_role_id']) {
            $data['employees'] = $this->EcrRenumerationModel->getEmployeesByExamAndRole($data['selected_exam_id'], $data['selected_role_id']);
        }
    
        // Fetch employee payment data if filters are applied
        if ($this->input->get()) {
            $exam_id = $data['selected_exam_id'];
            $role_id = $data['selected_role_id'];
            $emp_id = $data['selected_emp_id'];
            
            // Fetch employees and calculate payment
            $data['employee_payments'] = $this->EcrRenumerationModel->getEmployeePaymentData($exam_id, $role_id, $emp_id);
        }
    
        $this->load->view('header', $this->data);
        $this->load->view('Ecr/ecr_payment_listing', $data);
        $this->load->view('footer', $this->data);
    }

public function paymentSessionDate() {
    // Fetch dropdown options for roles and exam sessions
    $data['exam_sessions'] = $this->EcrRenumerationModel->getExamSessions();
    $data['ecr_roles'] = $this->EcrRenumerationModel->getEcrRoles();
    $data['exam_centers'] = $this->EcrEmpRegModel->getExamCenters();
    // Initialize data for display
    $data['employee_payments'] = [];
    $data['selected_exam_id'] = $this->input->get('exam_id');
    $data['selected_role_id'] = $this->input->get('role_id');
    $data['selected_date'] = $this->input->get('date');
    $data['selected_session'] = $this->input->get('session');
    $data['selected_center'] = $this->input->get('center_id');  
    
    // Fetch employee payment data if filters are applied
    if ($this->input->get()) {
        $exam_id = $data['selected_exam_id'];
        $role_id = $data['selected_role_id'];
        $date = $data['selected_date'];
        $session = $data['selected_session'];
        $center = $data['selected_center'];
        
        $data['employee_payments'] = $this->EcrRenumerationModel->getEmployeePaymentDataBySessionDate($exam_id, $role_id, $date, $session, $center);
    }

    $this->load->view('header', $this->data);
    $this->load->view('Ecr/ecr_payment_details_report', $data);
    $this->load->view('footer', $this->data);
}



public function downloadEmployeePaymentPDF() {
    $this->load->library('m_pdf');

    $exam_id = $this->input->get('exam_id');
    $role_id = $this->input->get('role_id');
    $date = $this->input->get('date');
    $session = $this->input->get('session');
    $center_id = $this->input->get('center_id');
     $center_data = $this->EcrEmpRegModel->getExamCentersById($center_id);


    // Fetch employee payment data
    $employee_payments = $this->EcrRenumerationModel->getEmployeePaymentDataBySessionDate($exam_id, $role_id, $date, $session, $center_id);

    $role = $this->EcrEmpRegModel->getRoleName($role_id);
    $exam_session = $this->EcrEmpRegModel->getExamName($exam_id);

    // Set data for the view
    $data = [
        'role_id' => $role_id,
        'exam_session' => $exam_session['exam_name'],
        'role' => $role['role_name'],
        'date' => $date,
        'session' => $session,
        'employee_payments' => $employee_payments,
		'center' => $center_data['center_name'],

    ];
    $logo_url = base_url('assets/images/SU_Logo-01.png');

    // Capture HTML from view
    $html = $this->load->view('Ecr/employee_payment_pdf_view', $data, true);

    // Initialize mPDF
    $mpdf = new mPDF('L', 'A4', '', '', 10, 10, 35, 15, 5, 5);

    $mpdf->SetHTMLHeader('
    <table style="width: 100%; border: 1px solid black; border-collapse: collapse; font-size: 12px;">
            <tr>
                <td style="width: 20%; border: none; text-align: center;">
                    <img src="' . base_url('assets/images/su-logo.png') . '" style="width: 80px; height: auto;">
                </td>
                <td style="width: 60%; border-left: 1px solid black;border-right: 1px solid black; text-align: center;">
                    <div style="font-size: 24px; font-weight: bold;color: red;">Sandip University</div>
                    <div style="font-size: 12px; color: #242424;">Mahiravani, Trimbak Road, Nashik - 422 213</div>
                    <div style="font-weight: bold; font-size: 14px;">Office of the Controller of Examinations</div>
                </td>
                <td style="width: 20%; border: none; text-align: center;">
                    <div style="font-size: 30px; font-weight: bold;">COE</div>
                </td>
            </tr>
        </table>
        <hr>');
    // Set footer with page numbering
    $mpdf->SetHTMLFooter("<div style='text-align: center; font-size: 10px;'>Page {PAGENO} of {nbpg}</div>");

    // Write HTML to PDF and output as download
    $mpdf->WriteHTML($html);                                

    $mpdf->Output('Employee_Payment_Report.pdf', 'D');
}


    public function consolidated_renum_view() {
        // Fetch dropdown options for roles and exam sessions
        $data['exam_sessions'] = $this->EcrRenumerationModel->getExamSessions();
        $data['ecr_roles'] = $this->EcrRenumerationModel->getEcrRoles();
    
        // Initialize data for display
        $data['consolidated_payments'] = [];
        $data['selected_exam_id'] = $this->input->get('exam_id');
        $data['selected_role_id'] = $this->input->get('role_id');
        
        if ($data['selected_exam_id'] || $data['selected_role_id']) {
            $exam_id = $data['selected_exam_id'];
            $role_id = $data['selected_role_id'];
    
            // Fetch consolidated payment data
            $data['consolidated_payments'] = $this->EcrRenumerationModel->getConsolidatedPaymentData($exam_id, $role_id);
        }
    
        $this->load->view('header', $this->data);
        $this->load->view('Ecr/consolidated_renum_view', $data);
        $this->load->view('footer', $this->data);
    }
    
    public function downloadRoleWisePaymentPDF() {
        $this->load->library('m_pdf');
    
         $exam_id = $this->input->get('exam_id');
         $date = $this->input->get('date');
         $session = $this->input->get('session');
		 $center_id = $this->input->get('center_id');
          $center_data = $this->EcrEmpRegModel->getExamCentersById($center_id);

    
        // Fetch role-wise payment data
        $role_payments = $this->EcrRenumerationModel->getRoleWisePaymentData($exam_id, $date, $session);

      //  print_r($center_data);exit;
    
        $exam_session = $this->EcrEmpRegModel->getExamName($exam_id);
    
        // Set data for the view
        $data = [
            'exam_session' => $exam_session['exam_name'],
            'date' => $date,
            'session' => $session,
            'role_payments' => $role_payments,
			'center' => $center_data['center_name'],

        ];
        $logo_url = base_url('assets/images/SU_Logo-01.png');
    
        // Capture HTML from view
        $html = $this->load->view('Ecr/role_payment_pdf_view', $data, true);
    
        // Initialize mPDF
        $mpdf = new mPDF('L', 'A4', '', '', 10, 10, 35, 15, 5, 5);
    
        $mpdf->SetHTMLHeader('
        <table style="width: 100%; border: 1px solid black; border-collapse: collapse; font-size: 12px;">
            <tr>
                <td style="width: 20%; border: none; text-align: center;">
                    <img src="' . base_url('assets/images/su-logo.png') . '" style="width: 80px; height: auto;">
                </td>
                <td style="width: 60%; border-left: 1px solid black;border-right: 1px solid black; text-align: center;">
                    <div style="font-size: 24px; font-weight: bold;color: red;">Sandip University</div>
                    <div style="font-size: 12px; color: #242424;">Mahiravani, Trimbak Road, Nashik - 422 213</div>
                    <div style="font-weight: bold; font-size: 14px;">Office of the Controller of Examinations</div>
                </td>
                <td style="width: 20%; border: none; text-align: center;">
                    <div style="font-size: 30px; font-weight: bold;">COE</div>
                </td>
            </tr>
        </table>
        <hr>

    ');
        // Set footer with page numbering
        $mpdf->SetHTMLFooter("<div style='text-align: center; font-size: 10px;'>Page {PAGENO} of {nbpg}</div>");
    
        // Write HTML to PDF and output as download
        $mpdf->WriteHTML($html);
        $mpdf->Output('Role_Wise_Payment_Report.pdf', 'D');
    }
    
        /////////////////////////////////////////////////// end ////////////////////////////////////////////////

	private function amountToIndianCurrencyWords($number)
	{
		$no = floor($number);
		$point = round($number - $no, 2) * 100;

		$words = [
			0 => '', 1 => 'One', 2 => 'Two', 3 => 'Three', 4 => 'Four', 5 => 'Five',
			6 => 'Six', 7 => 'Seven', 8 => 'Eight', 9 => 'Nine', 10 => 'Ten',
			11 => 'Eleven', 12 => 'Twelve', 13 => 'Thirteen', 14 => 'Fourteen',
			15 => 'Fifteen', 16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen', 19 => 'Nineteen',
			20 => 'Twenty', 30 => 'Thirty', 40 => 'Forty', 50 => 'Fifty',
			60 => 'Sixty', 70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety'
		];

		$digits = ['', 'Thousand', 'Lakh', 'Crore'];
		$str = [];
		$i = 0;

		while ($no > 0) {
			$divider = ($i == 0) ? 1000 : 100;
			$number_chunk = $no % $divider;
			$no = (int) floor($no / $divider);

			if ($number_chunk) {
				$text = '';

				// handle hundreds
				if ($number_chunk > 99) {
					$text .= $words[(int)($number_chunk / 100)] . ' Hundred ';
					$number_chunk = $number_chunk % 100;
				}

				// handle tens and ones
				if ($number_chunk > 0) {
					if ($number_chunk < 20) {
						$text .= $words[$number_chunk] . ' ';
					} else {
						$text .= $words[((int)($number_chunk / 10)) * 10] . ' ' . $words[$number_chunk % 10] . ' ';
					}
				}

				// append Thousand / Lakh / Crore
				if ($i > 0 && isset($digits[$i])) {
					$text .= $digits[$i] . ' ';
				}

				array_unshift($str, trim($text));
			}

			$i++;
		}

		$result = trim(implode(' ', $str));
		if ($result === '') {
			$result = 'Zero';
		}

		// Handle paise
		$paise = '';
		if ($point > 0) {
			$paise_num = (int)$point;
			if ($paise_num < 20) {
				$paise = $words[$paise_num];
			} else {
				$paise = $words[((int)($paise_num / 10)) * 10] . ' ' . $words[$paise_num % 10];
			}
			$paise = trim($paise);
		}

		if ($paise !== '') {
			return 'Rupees ' . $result . ' and ' . $paise . ' Paise Only';
		}
		return 'Rupees ' . $result . ' Only';
	}



	public function export_consolidated_pdf()
	{
		$exam_id = $this->input->get('exam_id', true);
		$role_id = $this->input->get('role_id', true);

		// 1) Fetch the same data you use in the view
		// Replace with your model call:
		 $consolidated_payments = $this->EcrRenumerationModel->getConsolidatedPaymentData($exam_id, $role_id);
		// $consolidated_payments = $this->getConsolidatedPaymentData($exam_id, $role_id); // <-- replace

		// 2) Build totals
		$total_sessions = 0;
		$total_amount   = 0.0;
		foreach ($consolidated_payments as $r) {
			$total_sessions += (int)$r['total_present_sessions'];
			$total_pr_sessions += (int)$r['pr_ssn'];
			$total_extra_sessions += (int)$r['extra_ssn'];
			$total_amount   += (float)$r['total_payment'];
		}

		// 3) Prepare HTML (static header styles for PDF; gradient/animation removed)
		$theadBg = '#f4b6c2'; // soft red banner for PDF header row (since gradients/animations don't render)
		$border  = '1px solid #000';

		$header = '
			<table style="width:100%; border: 1px solid black; border-collapse: collapse; font-size: 12px;">
				<tr>
					<td style="width: 20%; border: none; text-align: center;">
						<img src="'. base_url('assets/images/su-logo.png') .'" style="width: 80px; height: auto;">
					</td>
					<td style="width: 60%; border-left: 1px solid black;border-right: 1px solid black; text-align: center;">
						<div style="font-size: 24px; font-weight: bold; color: red;">Sandip University</div>
						<div style="font-size: 12px; color: #242424;">Mahiravani, Trimbak Road, Nashik - 422 213</div>
						<div style="font-weight: bold; font-size: 14px;">Office of the Controller of Examinations</div>
					</td>
					<td style="width: 20%; border: none; text-align: center;">
						<div style="font-size: 30px; font-weight: bold;">COE</div>
					</td>
				</tr>
			</table>
			<hr style="margin:6px 0 10px;">
		';

		$footer = '
			<table width="100%" style="font-size:10px; border-top:1px solid #aaa;">
			  <tr>
				<td width="40%">Printed on: '. date('d-m-Y H:i:s') .'</td>
				<td width="20%" align="center">Page {PAGENO} of {nb}</td>
			  </tr>
			</table>
		';

		// Table CSS for PDF output (simple & print-friendly)
		$css = '
		  <style>
			.title { text-align:center; font-weight:bold; font-size:16px; margin:4px 0 10px; }
			.renum_per_ssn { text-align:right; font-weight:bold; font-size:12px; margin:4px 0 10px; }
			table { width:100%; border-collapse: collapse; }
			th, td { border: '.$border.'; padding:6px; font-size:12px; text-align:center; }
			thead th { background: '.$theadBg.'; color:#3c1c1c; }
			.totals td { font-weight:bold; background:#fde2e4; }
			.left { text-align:left; }
			.right { text-align:right; }
		  </style>
		';

		$title = '<div class="title">'.$consolidated_payments[0]['role_name'].' Consolidated Employee Payment List</div>';

		// Build table body
		$renum_per_ssn = '<div class="renum_per_ssn">Remuneration Per Session : '.$consolidated_payments[0]['renum'].'</div>';
		$rows = '';
		foreach ($consolidated_payments as $r) {
			$rows .= '
				<tr>
					<td>'. htmlspecialchars($r["effective_emp_id"]) .'</td>
					<td class="left">'. htmlspecialchars($r["name"]) .'</td>
					<td>'. (int)$r["pr_ssn"] .'</td>
					<td>'. (int)$r["extra_ssn"] .'</td>
					<td>'. (int)$r["total_present_sessions"] .'</td>
					<td class="right">'. number_format((float)$r["total_payment"], 2) .'</td>
				</tr>
			';
		}

		// Totals row (traditional footer)
		$rows .= '
			<tr class="totals">
				<td colspan="2" class="right">Total</td>
				<td>'. (int)$total_pr_sessions .'</td>
				<td>'. (int)$total_extra_sessions .'</td>
				<td>'. (int)$total_sessions .'</td>
				<td class="right">'. number_format($total_amount, 2) .'</td>
			</tr>
		';

		$table = '
		  <table>
			<thead>
			  <tr>
				<th>Employee ID</th>
				<th>Employee Name</th>
				<th>Present Sessions</th>
				<th>Extra Sessions(if any)</th>
				<th>Total Present Sessions</th>
				<th>Total Payment</th>
			  </tr>
			</thead>
			<tbody>'.$rows.'</tbody>
		  </table>
		';
			$amount_words = $this->amountToIndianCurrencyWords($total_amount);

			$amountWordsCss = '
			<style>
			  .amount-words {
				margin-top: 10px;
				font-size: 12px;
				font-weight: bold;
				text-align: right;
			  }
			  .amount-words span {
				display: inline-block;
				padding: 6px 10px;
			  }			  
			  .note {
				margin-top: 10px;
				font-size: 12px;
				text-align: left;
			  }
			  .note span {
				display: inline-block;
				padding: 6px 10px;
			  }			  
			  .sign {
				margin-top: 50px;
				font-size: 12px;
				text-align: right;
				font-weight: bold;
			  }
			  .sign span {
				display: inline-block;
				padding: 6px 10px;
			  }
			</style>';

		// 4) mPDF output
		$this->load->library('m_pdf'); // ensure you’ve autoloaded mpdf wrapper or adjusted to your setup
		$mpdf = new mPDF('L', 'A4', '', '', 15, 15, 35, 10, 5, 5);

		if (!is_dir(FCPATH.'application/cache/mpdf_temp')) {
			@mkdir(FCPATH.'application/cache/mpdf_temp', 0777, true);
		}

		$mpdf->SetTitle('Consolidated Payment List');
		$mpdf->SetHTMLHeader($header);
		$mpdf->SetHTMLFooter($footer);

		$mpdf->WriteHTML($css);
		$mpdf->WriteHTML($title);
		$mpdf->WriteHTML($renum_per_ssn);
		$mpdf->WriteHTML($table);
		$mpdf->WriteHTML($amountWordsCss);

		$mpdf->WriteHTML('<div class="amount-words"><span>Total Amount (in words): '. htmlspecialchars($amount_words) . '</span></div>');
		$mpdf->WriteHTML('<div class="sign"><span>Signature Of Chief Superintendent</span></div>');
		$mpdf->WriteHTML('<div class="note"><span>NOTE : This is a system generated Report </span></div>');
		// Clean buffer & output
		while (ob_get_level() > 0) { ob_end_clean(); }
		$mpdf->Output('consolidated_payment_list.pdf', 'I'); // or 'D' to force download
	}


	public function export_consolidated_excel()
	{
		$exam_id = $this->input->get('exam_id', true);
		$role_id = $this->input->get('role_id', true);

		// Fetch data
		$consolidated_payments = $this->EcrRenumerationModel->getConsolidatedPaymentData($exam_id, $role_id);
		// $consolidated_payments = $this->getConsolidatedPaymentData($exam_id, $role_id); // <-- replace

		// Get exam name from DB
		$data['exam'] = $this->EcrRenumerationModel->getExamSessions(); // create this function

		// print_r($data['exam']);exit;
		$this->load->library('excel');
		$object = new PHPExcel();
		$sheet  = $object->getActiveSheet();
		$sheet->setTitle('Consolidated Payments');

		// ===== Header title with exam name =====
		$title = "Consolidated Ecr Payments - {$data['exam'][0]['exam_name']} Examination";
		$sheet->mergeCells('A1:J1');
		$sheet->setCellValue('A1', $title);
		$sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
		$sheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle('A1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
			  ->getStartColor()->setRGB('D6EAF8'); // soft blue

		// ===== Column headers start from row 2 =====
		$headers = ['Employee ID', 'Employee Name', 'Total Present Sessions', 'Remuneration per Session', 'Total Payment', 'Bank Name', 'Bank Account No.', 'Bank IFSC Code', 'Bank Branch Name','Mobile'];
		$sheet->fromArray($headers, null, 'A2');

		// Bold header + fill
		$sheet->getStyle('A2:J2')->getFont()->setBold(true);
		$sheet->getStyle('A2:J2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
			  ->getStartColor()->setRGB('F4B6C2'); // soft red

		// ===== Data starts from row 3 =====
		$row = 3;
		$total_sessions = 0;
		$total_amount   = 0.0;

		foreach ($consolidated_payments as $r) {
			$sheet->setCellValueExplicit("A{$row}", $r['effective_emp_id'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValue("B{$row}", $r['name']);
			$sheet->setCellValue("C{$row}", (int)$r['total_present_sessions']);
			$sheet->setCellValue("D{$row}", (float)$r['renum']);
			$sheet->setCellValue("E{$row}", (float)$r['total_payment']);
			$sheet->setCellValue("F{$row}", $r['bank_name']);
			$sheet->setCellValue("G{$row}", $r['acc_no']);
			$sheet->setCellValue("H{$row}", $r['ifsc']);
			$sheet->setCellValue("I{$row}", $r['branch_name']);
			$sheet->setCellValue("J{$row}", $r['mobile']);
			
			$total_sessions += (int)$r['total_present_sessions'];
			$total_amount   += (float)$r['total_payment'];
			$row++;
		}

		// Totals row
		$sheet->setCellValue("A{$row}", 'Total');
		$sheet->mergeCells("A{$row}:B{$row}");
		$sheet->setCellValue("C{$row}", $total_sessions);
		$sheet->setCellValue("D{$row}", '—');
		$sheet->setCellValue("E{$row}", $total_amount);

		// Style totals
		$sheet->getStyle("A{$row}:E{$row}")->getFont()->setBold(true);
		$sheet->getStyle("A1:J{$row}")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

		// Number formats
		$sheet->getStyle("D3:D{$row}")->getNumberFormat()->setFormatCode('#,##0.00');
		$sheet->getStyle("E3:E{$row}")->getNumberFormat()->setFormatCode('#,##0.00');

		// Autosize
		foreach (range('A','J') as $col) {
			$sheet->getColumnDimension($col)->setAutoSize(true);
		}

		// Output
		while (ob_get_level() > 0) { ob_end_clean(); }
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="consolidated_payment_list.xlsx"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel2007');
		$objWriter->save('php://output');
		exit;

	}



}
