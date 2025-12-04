<?php
class Feesummary extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Feesummary_model');
    }

    /** Refresh summary table */
    public function rebuild($academic_year = null, $campus_id=1) {
        $this->Feesummary_model->rebuild_summary($academic_year, $campus_id);
        //echo "Summary rebuilt successfully.";
    }
	
	public function fetch_api_and_store($ay="2025-26")
	{
		if($ay=='2025-26'){
			$academicYear = "2025";
		}else if($ay=='2024-25'){
			$academicYear = "2024";
		}else if($ay=='2023-24'){
			$academicYear = "2023";
		}else if($ay=='2022-23'){
			$academicYear = "2022";
		}else if($ay=='2021-22'){
			$academicYear = "2021";
		}else{
			$academicYear = "2025";
		}
		$apiUrl = "https://sandiperp.com/requestApi.aspx?ApiType=104&AyName=$ay&UserTypeId=1"; 
		$json   = file_get_contents($apiUrl);
		$data   = json_decode($json, true);

		 // Or fetch dynamically

		$this->load->database();

		foreach ($data as $row) {
			$record = [
				'college'                  => $row['College'],
				'academic_year'            => $academicYear,
				'admission'                => $row['Admission'],
				'registration'             => $row['Registration'],
				'total'                    => $row['Total'],
				'TodayCollection'          => $row['TodayCollectionCurr'],
				'applicable'          => $row['ReceivableCurr'],
				'paid'           => $row['TotalCollectionCurr'],
				'balance'        => $row['PendingFeesCurr'],
				'TodayScholarshipReceived'         => $row['TodayScholarshipReceivedCurr'],
				'scholarship_applicable'         => $row['ScholarshipAmountCurr'],
				'scholarship_paid'         => $row['TotalScholarshipReceivedCurr'],				
				'pending_scholarship' => $row['PendingScholarshipCurr'],
				'total_pending'            => $row['TotalPendingAmount'],
				'api_date'                 => date("Y-m-d H:i:s")
			];

			// Check if row exists for this college + academic year
			$this->db->where('college', $row['College']);
			$this->db->where('academic_year', $academicYear);
			$exists = $this->db->get('sf_college_finance_summary')->row();

			if ($exists) {
				// ✅ Update
				$this->db->where('id', $exists->id);
				$this->db->update('sf_college_finance_summary', $record);
			} else {
				// ✅ Insert
				$record['college']       = $row['College'];
				$record['academic_year'] = $academicYear;
				$this->db->insert('sf_college_finance_summary', $record);
			}
		}

		echo "Data synced successfully!";
	}
	public function syncCollectionReport($ay='2025')
{
    $url = "https://www.sandipuniversity.com/api/reports/collection.php";

    // Request payload
    $data = [
        "request"       => "data_set",
        "school"        => "SITRC",
        "academic_year" => $ay,
        "date"          => date('Y-m-d')
    ];

    // ✅ API KEY
    $apiKey = "aas123456";

    // Call API using cURL
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'api_key: ' . $apiKey   // ✅ exact header name as required
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
	
	

    if (curl_errno($ch)) {
        echo "cURL Error: " . curl_error($ch);
        return;
    }

    curl_close($ch);

    // Decode response
  $result = json_decode($response, true);
 $row =$result['data'];

   

    if (!$result || !isset($result['data'])) {
        echo "❌ API response invalid or empty\n";
        return;
    }

    $academicYear = $data['academic_year'];

   // foreach ($result['data'] as $row) {
	
        $record = [
            'college'               => $row['College'],
            'academic_year'         => $academicYear,
            'admission'             => $row['Admission'],
            'registration'          => $row['Registration'],
            'total'                 => $row['Total'],
			'TodayCollection'       => $row['TodayCollectionCurr'],
            'applicable'            => $row['ReceivableCurr'],
            'paid'                  => $row['TotalCollectionCurr'],
            'balance'               => $row['PendingFeesCurr'],
			'TodayScholarshipReceived'         => $row['TodayScholarshipReceivedCurr'],
            'scholarship_applicable'=> $row['ScholarshipAmountCurr'],
            'scholarship_paid'      => $row['TotalScholarshipReceivedCurr'],
            'pending_scholarship'   => $row['PendingScholarshipCurr'],
            'total_pending'         => $row['TotalPendingAmount'],
            'api_date'              => date("Y-m-d H:i:s")
        ];


        // ✅ Check if record exists
        $this->db->where('college', $row['College']);
        $this->db->where('academic_year', $academicYear);
        $exists = $this->db->get('sf_college_finance_summary')->row();

        if ($exists) {
            $this->db->where('id', $exists->id);
            $this->db->update('sf_college_finance_summary', $record);
        } else {
            $this->db->insert('sf_college_finance_summary', $record);
        }
   // }

    echo "✅ Sync completed successfully!";
}
    /** Show pivot report */
    public function report() {
        $filters = [];
		//print_r($filters);exit;
        if ($this->input->get('admission_session')) {
            $filters['admission_session'] = $this->input->get('admission_session');
            $filters['admission_type'] = $this->input->get('admission_type');
            $_POST['admission_session'] = $this->input->get('admission_session');
            $_POST['admission_type'] = $this->input->get('admission_type');
        }
        if ($this->input->get('enrollment_no')) {
            $filters['enrollment_no'] = $this->input->get('enrollment_no');
        }
		if(!empty($_POST)){
			$filters['admission_session']=$_POST['admission_session'];
			$filters['admission_type']=$_POST['admission_type'];
			$data['admission_session']=$_POST['admission_session'];
			$data['admission_type']=$_POST['admission_type'];
			$data['rows'] = $this->Feesummary_model->get_pivot_report($filters);
		}
		
		$this->load->view('header',$this->data);
        if ($this->input->get('export') !== 'excel') {
			$this->load->view('fees/report', $data);
		} else {
			$this->export_excel($data['rows']);
		}
		$this->load->view('footer',$this->data); 
    }
	private function export_excel($rows) {
    $this->load->library('Excel');
    $spreadsheet = new PHPExcel();
    $sheet = $spreadsheet->getActiveSheet();

    // ========================
    // 1. Headers
    // ========================
    $fixedHeaders = ["PRN","Student Name","Mobile","Gender","School","Course","Stream","Uniform"];
    $yearHeaders  = ["AY","OpBal","Actual","Scholarship","Applicable","Paid","Refund","NetPaid","Balance","Hostel","Hostel Paid"];

    // Fixed headers (merged)
    $colIndex = 0;
    foreach ($fixedHeaders as $h) {
        $cell = PHPExcel_Cell::stringFromColumnIndex($colIndex);
        $sheet->mergeCells("{$cell}1:{$cell}2");
        $sheet->setCellValue("{$cell}1", $h);
        $colIndex++;
    }

    // Year headers
    foreach ([1,2,3,4,5] as $y) {
        $startCol = PHPExcel_Cell::stringFromColumnIndex($colIndex);
        foreach ($yearHeaders as $h) {
            $sheet->setCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex)."2", $h);
            $colIndex++;
        }
        $endCol = PHPExcel_Cell::stringFromColumnIndex($colIndex-1);
        $sheet->mergeCells("{$startCol}1:{$endCol}1");
        $sheet->setCellValue($startCol."1", "{$y} Year");
    }

    // Header styling
    $headerStyle = [
        'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'name' => 'Calibri', 'size' => 11],
        'fill' => ['type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => ['rgb' => '1F4E78']],
        'alignment' => ['horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER],
        'borders' => ['allborders' => ['style' => PHPExcel_Style_Border::BORDER_THIN]]
    ];
    $sheet->getStyle("A1:".$sheet->getHighestColumn()."2")->applyFromArray($headerStyle);

    // ========================
    // 2. Fill Data
    // ========================
    $rowNum = 3;
    foreach ($rows as $r) {
        $sheet->fromArray([
            $r['enrollment_no'],$r['first_name'],$r['mobile'],$r['gender'],$r['school_short_name'],$r['course_short_name'],$r['stream_name'],$r['uniform_status'],

            $r['y1_ay'],$r['y1_opbal'],$r['y1_actual'],$r['y1_scholarship'],$r['y1_applicable'],$r['y1_paid'],$r['y1_refund'],$r['y1_netpaid'],$r['y1_balance'],$r['y1_hostel'],$r['y1_hostel_fee'],
            $r['y2_ay'],$r['y2_opbal'],$r['y2_actual'],$r['y2_scholarship'],$r['y2_applicable'],$r['y2_paid'],$r['y2_refund'],$r['y2_netpaid'],$r['y2_balance'],$r['y2_hostel'],$r['y2_hostel_fee'],
            $r['y3_ay'],$r['y3_opbal'],$r['y3_actual'],$r['y3_scholarship'],$r['y3_applicable'],$r['y3_paid'],$r['y3_refund'],$r['y3_netpaid'],$r['y3_balance'],$r['y3_hostel'],$r['y3_hostel_fee'],
            $r['y4_ay'],$r['y4_opbal'],$r['y4_actual'],$r['y4_scholarship'],$r['y4_applicable'],$r['y4_paid'],$r['y4_refund'],$r['y4_netpaid'],$r['y4_balance'],$r['y4_hostel'],$r['y4_hostel_fee'],
            $r['y5_ay'],$r['y5_opbal'],$r['y5_actual'],$r['y5_scholarship'],$r['y5_applicable'],$r['y5_paid'],$r['y5_refund'],$r['y5_netpaid'],$r['y5_balance'],$r['y5_hostel'],$r['y5_hostel_fee'],
        ], NULL, "A{$rowNum}");
        $rowNum++;
    }
    $lastRow = $sheet->getHighestRow();

    // ========================
    // 3. Format Columns
    // ========================
    $netpaidCols = [];
    $balanceCols = [];
    $numericCols = [];
    $applicableCols = [];

    $startDataCol = count($fixedHeaders)+1; 
    foreach ([1,2,3,4,5] as $yr) {
        for ($i=0;$i<count($yearHeaders);$i++) {
            $col = PHPExcel_Cell::stringFromColumnIndex($startDataCol+$i-1);
            if ($i == 0) continue; // AY text
            if ($i == 4) $applicableCols[] = $col; 
            if ($i == 7) $netpaidCols[] = $col; 
            if ($i == 8) $balanceCols[] = $col; 
            $numericCols[] = $col;
        }
        $startDataCol += count($yearHeaders);
    }

    foreach ($numericCols as $col) {
        $sheet->getStyle("{$col}3:{$col}{$lastRow}")
              ->getNumberFormat()->setFormatCode('#,##0.00');
        $sheet->getStyle("{$col}3:{$col}{$lastRow}")
              ->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    }
	$applicableStyle = [
        'fill' => ['type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => ['rgb' => 'FCD8BB']],
        'font' => ['bold' => true]
    ];	
    $netpaidStyle = [
        'fill' => ['type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => ['rgb' => 'C6EFCE']],
        'font' => ['bold' => true]
    ];
    $balanceStyle = [
        'fill' => ['type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => ['rgb' => 'FFC7CE']],
        'font' => ['bold' => true]
    ];
	foreach ($applicableCols as $col) {
        $sheet->getStyle("{$col}3:{$col}{$lastRow}")->applyFromArray($applicableStyle);
    }
    foreach ($netpaidCols as $col) {
        $sheet->getStyle("{$col}3:{$col}{$lastRow}")->applyFromArray($netpaidStyle);
    }
    foreach ($balanceCols as $col) {
        $sheet->getStyle("{$col}3:{$col}{$lastRow}")->applyFromArray($balanceStyle);
    }

    // ========================
    // 4. Grand Total Row
    // ========================
    $totalRow = $lastRow + 1;
    $sheet->setCellValue("A{$totalRow}", "Grand Total");
    $sheet->mergeCells("A{$totalRow}:G{$totalRow}");

    foreach ($numericCols as $col) {
        $sheet->setCellValue("{$col}{$totalRow}", "=SUM({$col}3:{$col}{$lastRow})");
        // Apply amount format to totals too
        $sheet->getStyle("{$col}{$totalRow}")
              ->getNumberFormat()->setFormatCode('#,##0.00');
        $sheet->getStyle("{$col}{$totalRow}")
              ->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    }

    $sheet->getStyle("A{$totalRow}:".$sheet->getHighestColumn()."{$totalRow}")->applyFromArray([
        'font' => ['bold' => true],
        'fill' => ['type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => ['rgb' => 'D9E1F2']],
        'borders' => ['allborders' => ['style' => PHPExcel_Style_Border::BORDER_THIN]]
    ]);

    // ========================
    // 5. Autosize
    // ========================
    foreach (range('A', $sheet->getHighestColumn()) as $col) {
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    // ========================
    // 6. Output
    // ========================
    $filename = "Fee_Report_" . date('Ymd_His') . ".xls";
    header('Content-Type: application/vnd.ms-excel');
    header("Content-Disposition: attachment; filename=\"$filename\"");
    header('Cache-Control: max-age=0');

    $spreadsheet->setActiveSheetIndex(0);
    $objWriter = PHPExcel_IOFactory::createWriter($spreadsheet, 'Excel5');
    $objWriter->setPreCalculateFormulas(true);
    $objWriter->save('php://output');
    exit;
}
public function deposited_fees_challan_list()
    {
        $data = [];
        $data['results'] = [];

        if ($this->input->post('search')) {
            $filters = [
                'fdate'  => $this->input->post('fdate'),
                'tdate'  => $this->input->post('tdate'),
                'status' => $this->input->post('status'),
                'campus' => $this->input->post('campus')
            ];
            $data['results'] = $this->Feesummary_model->get_challan_list($filters);
        }

        $this->load->view('Account/deposited_fees_challan_list.php', $data);
    }

public function export_excel_challan()
{
    $filters = [
        'fdate'  => $this->input->get('fdate'),
        'tdate'  => $this->input->get('tdate'),
        'status' => $this->input->get('status'),
        'campus' => $this->input->get('campus')
    ];

    $records = $this->Feesummary_model->get_challan_list($filters);
    $total_amount = 0;
    foreach ($records as $r) {
        $total_amount += (float)$r['amount'];
    }

    /* $objPHPExcel = new PHPExcel();
    $objPHPExcel->setActiveSheetIndex(0);
    $sheet = $objPHPExcel->getActiveSheet(); */
	
	$this->load->library('Excel');
    $objPHPExcel = new PHPExcel();
    $sheet = $objPHPExcel->getActiveSheet();
	
    $sheet->setTitle('Challan Report');
	
    // Headers
    $headers = ['Challan No','Bank Ref No','Enrollment No', 'Name', 'Stream', 'Amount', 'Payment Type', 'Created On', 'Student Bank', 'SU Bank', 'Academic Year', 'Campus'];
    $col = 'A';
    foreach ($headers as $header) {
        $sheet->setCellValue($col.'1', $header);
        $sheet->getStyle($col.'1')->getFont()->setBold(true);
        $sheet->getStyle($col.'1')->getFill()
            ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
            ->getStartColor()->setRGB('DDEBF7');
        $sheet->getStyle($col.'1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $col++;
    }

    // Body rows
    $row = 2;
    foreach ($records as $r) {
        $sheet->setCellValue("A$row", $r['college_receiptno']);
        $sheet->setCellValue("B$row", $r['receipt_no']);
        $sheet->setCellValue("C$row", $r['enrollment_no']);
        $sheet->setCellValue("D$row", $r['first_name'].' '.$r['last_name']);
        $sheet->setCellValue("E$row", $r['stream_short_name']);
        $sheet->setCellValueExplicit("F$row", $r['amount'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $sheet->setCellValue("G$row", $r['fees_paid_type']);
        $sheet->setCellValue("H$row", date('d-M-Y H:i', strtotime($r['created_on'])));
        $sheet->setCellValue("I$row", $r['student_bank']);
        $sheet->setCellValue("G$row", $r['su_bank_name']);
        $sheet->setCellValue("K$row", $r['academic_year']);
        $sheet->setCellValue("L$row", ucfirst($filters['campus']));
        $row++;
    }

    // ✅ Total Row (highlighted)
    $sheet->setCellValue("C$row", "Total");
    $sheet->setCellValue("F$row", $total_amount);
    $sheet->getStyle("C$row:F$row")->getFont()->setBold(true);
    $sheet->getStyle("C$row:F$row")->getFill()
        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
        ->getStartColor()->setRGB('FFF2CC');

    // ✅ Format currency in Indian style ₹
    $currencyFormat = '_("₹"* #,##0.00_);_("₹"* \(#,##0.00\);_("₹"* "-"??_);_(@_)';
    $sheet->getStyle("F2:D$row")->getNumberFormat()->setFormatCode($currencyFormat);

    // ✅ Borders for neatness
    $styleArray = [
        'borders' => [
            'allborders' => [
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => ['rgb' => '999999']
            ]
        ]
    ];
    $sheet->getStyle("A1:L$row")->applyFromArray($styleArray);

    // ✅ Center align headers and data
    $sheet->getStyle("A1:L1")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle("E2:E$row")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle("L2:L$row")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    // ✅ Auto-fit columns
    foreach(range('A','L') as $columnID) {
        $sheet->getColumnDimension($columnID)->setAutoSize(true);
    }

    // ✅ Freeze header row
    $sheet->freezePane('A2');

    // ✅ Output to browser
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="fees_challan_report_'.$filters['campus'].'_'.date('Ymd_His').'.xls"');
    header('Cache-Control: max-age=0');
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');
    exit;
}

public function export_fee_summary_excel()
{
    $this->umsdb = $this->load->database('umsdb', TRUE);
    $this->load->library('excel'); // Make sure you have PHPExcel library loaded

    // Create new PHPExcel object
   $this->load->library('Excel');
    $objPHPExcel = new PHPExcel();
   // $sheet = $objPHPExcel->getActiveSheet();
    $objPHPExcel->getProperties()->setCreator("YourApp")
        ->setTitle("Student Fee Summary Report");

    // Get distinct academic years
    $years = $this->umsdb->select('DISTINCT(academic_year)')
                      ->order_by('academic_year', 'ASC')
                      ->get('student_fee_summary')
                      ->result();

    $sheetIndex = 0;

    foreach ($years as $y) {
        $academic_year = $y->academic_year;

        // Fetch data for this academic year
        $query = $this->umsdb->query("
            SELECT 
                s.enrollment_no,
                sm.first_name,
                sm.mobile,
                sm.gender,
                sm.belongs_to,
                sm.package_name,
                vw.school_short_name,
                vw.course_short_name,
                vw.stream_name,
                s.year,
                s.actual_fee,
                s.applicable,
                s.scholarship,
                s.opening_balance,
                s.canc_charges,
                s.netapplicable_fee,
                s.paid,
                s.refund,
                s.netpaid,
                s.balance,
                s.hostel
            FROM student_fee_summary s
            LEFT JOIN student_master sm ON sm.stud_id = s.student_id
            LEFT JOIN vw_stream_details vw ON vw.stream_id = s.stream_id
            WHERE s.academic_year = '$academic_year' and sm.package_name='Reddy'
            ORDER BY sm.first_name ASC
        ");

        $data = $query->result_array();

        // Create new sheet per academic year
        if ($sheetIndex > 0) {
            $objPHPExcel->createSheet();
        }

        $objPHPExcel->setActiveSheetIndex($sheetIndex);
        $sheet = $objPHPExcel->getActiveSheet();
        $sheet->setTitle($academic_year);

        // Set header row
        $headers = [
            'Enrollment No', 'First Name', 'Mobile', 'Gender', 'Belongs To', 'Package Name',
            'School', 'Course', 'Stream', 'Year',
            'Actual Fee', 'Applicable', 'Scholarship', 'Opening Balance',
            'Cancel Charges', 'Net Applicable', 'Paid', 'Refund', 'Net Paid', 'Balance', 'Hostel'
        ];

        $col = 0;
        foreach ($headers as $header) {
            $sheet->setCellValueByColumnAndRow($col, 1, $header);
            $sheet->getStyleByColumnAndRow($col, 1)->getFont()->setBold(true);
            $col++;
        }

        // Fill data rows
        $row = 2;
        foreach ($data as $d) {
            $col = 0;
            foreach ($d as $value) {
                $sheet->setCellValueByColumnAndRow($col, $row, $value);
                $col++;
            }
            $row++;
        }

        // Auto-size columns
        foreach (range('A', $sheet->getHighestColumn()) as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $sheetIndex++;
    }

    // Set active sheet to first one
    $objPHPExcel->setActiveSheetIndex(0);

    // Output the Excel file
    $filename = 'student_fee_summary_' . date('Ymd_His') . '.xls';
    header('Content-Type: application/vnd.ms-excel');
    header("Content-Disposition: attachment; filename=\"$filename\"");
    header('Cache-Control: max-age=0');

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');
    exit;

}


}
