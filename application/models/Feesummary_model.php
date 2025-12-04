<?php
class Feesummary_model extends CI_Model {

    protected $umsdb;

    public function __construct() {
        parent::__construct();
    }
	private function setCampusDB($campus_id) {
        switch ($campus_id) {
            case 1:
                $this->umsdb = $this->load->database('umsdb', TRUE); // Nashik
                break;
            case 2:
                $this->umsdb = $this->load->database('sjumsdb', TRUE); // Sijoul
                break;
            case 3:
                $this->umsdb = $this->load->database('sfumsdb', TRUE); // SF
                break;
            default:
                $this->umsdb = $this->load->database('umsdb', TRUE); // fallback
        }
    }
    /**
     * Build/refresh fee summary table
     */
  public function rebuild_summary($academic_year = null,$campus_id, $batchSize = 1000)
{
	$this->setCampusDB($campus_id);
    $whereAY = "";
    if ($academic_year) {
        $whereAY = " AND ad.academic_year=" . $this->umsdb->escape($academic_year);
    }

    // 1. Pre-fetch paid/cancel charges into array
    $feesPaid = [];
    $q1 = $this->umsdb->query("
        SELECT 
            student_id,
            academic_year,
            SUM(CASE WHEN chq_cancelled = 'N' THEN amount ELSE 0 END) AS paid,
            SUM(CASE WHEN chq_cancelled = 'Y' THEN canc_charges ELSE 0 END) AS canc_charges
        FROM fees_details
        WHERE is_deleted = 'N' AND type_id = '2'
        GROUP BY student_id, academic_year
    ");
    foreach ($q1->result_array() as $row) {
        $feesPaid[$row['student_id']][$row['academic_year']] = $row;
    }

    // 2. Pre-fetch refunds into array
    $feesRefund = [];
    $q2 = $this->umsdb->query("
        SELECT student_id, academic_year, SUM(amount) AS refund
        FROM fees_refunds
        WHERE is_deleted='N'
        GROUP BY student_id, academic_year
    ");
    foreach ($q2->result_array() as $row) {
        $feesRefund[$row['student_id']][$row['academic_year']] = $row['refund'];
    }
	// 3. Pre-fetch hostel fees (NEW)
    $hostelFees = [];
    $qHostel = $this->umsdb->query("
        SELECT 
            enrollment_no,
            academic_year,student_id,
            SUM(CASE WHEN chq_cancelled = 'N' THEN amount ELSE 0 END) AS hostel_paid
        FROM sandipun_erp.sf_fees_details
        WHERE is_deleted = 'N'
          AND type_id = '1'   -- 🔹 Change this to your actual hostel type_id
        GROUP BY enrollment_no, academic_year
    ");
    foreach ($qHostel->result_array() as $row) {
        $hostelFees[$row['enrollment_no']][$row['academic_year']] = $row['hostel_paid'];
    }

    // 4. Count total students
    $countSql = "
        SELECT COUNT(*) AS total
        FROM admission_details ad
        JOIN student_master sm ON sm.stud_id = ad.student_id
        WHERE sm.admission_confirm='Y' AND ad.cancelled_admission='N' {$whereAY}
    ";
	//echo  $countSql;exit; //sm.admission_session='2025' and sm.package_name='Reddy' // sm.admission_confirm='Y'
    $totalRows = $this->umsdb->query($countSql)->row()->total;

    $offset = 0;
    while ($offset < $totalRows) {
        // 4. Fetch batch of students
        $batchSql = "
            SELECT ad.actual_fee,ad.applicable_fee,ad.opening_balance,ad.student_id,ad.academic_year,ad.stream_id, sm.enrollment_no, sm.stud_id,ad.year,ad.hostel_required
            FROM admission_details ad
            JOIN student_master sm ON sm.stud_id = ad.student_id
            WHERE  sm.admission_confirm='Y' AND ad.cancelled_admission='N' {$whereAY}
            LIMIT {$batchSize} OFFSET {$offset}
        ";
			//echo  $batchSql;exit;
        $students = $this->umsdb->query($batchSql)->result_array();

        if (empty($students)) break;

        // 5. Build VALUES block
        $values = [];
        foreach ($students as $s) {
            $studId  = $s['student_id'];
			$enrollment_no  = $s['enrollment_no'];
            $ay      = $s['academic_year'];

            $paidRow = isset($feesPaid[$studId][$ay]) ? $feesPaid[$studId][$ay] : ['paid'=>0,'canc_charges'=>0];
            $refund  = isset($feesRefund[$studId][$ay]) ? $feesRefund[$studId][$ay] : 0;
			 // 🔹 Fetch hostel paid amount only if required
            $hostel_paid = ($s['hostel_required'] === 'Y' && isset($hostelFees[$enrollment_no][$ay]))
                ? $hostelFees[$enrollment_no][$ay]
                : 0;

            $scholarship = ($s['actual_fee'] != $s['applicable_fee']) 
                            ? ($s['actual_fee'] - $s['applicable_fee']) : 0;
			$netapplicable = ($s['opening_balance'] + $s['applicable_fee'] + $paidRow['canc_charges']);
            $netpaid = $paidRow['paid'] - $refund;
			
            $balance = ($netapplicable - $netpaid);
            

            $values[] = "(" .
                (int)$studId . "," .
                (int)$s['stream_id'] . "," .
                $this->umsdb->escape($s['enrollment_no']) . "," .
                $this->umsdb->escape($ay) . "," .
                (int)$s['year'] . "," .
                (float)$s['actual_fee'] . "," .
                (float)$scholarship . "," .
                (float)$s['applicable_fee'] . "," .
                (float)$s['opening_balance'] . "," .
                (float)$paidRow['paid'] . "," .
                (float)$refund . "," .
				(float)$hostel_paid . "," . // 🔹 NEW COLUMN VALUE
                (float)$netpaid . "," .
                (float)$balance . "," .
                $this->umsdb->escape($s['hostel_required'] === 'Y' ? 'Y' : 'N') . "," .
                (float)$paidRow['canc_charges'] . "," .
                (float)$netapplicable .
            ")";
        }
	/* echo '<pre>';
	print_r($values);exit; */
        if (!empty($values)) {
            $insertSql = "
                INSERT INTO student_fee_summary (
                    student_id, stream_id, enrollment_no, academic_year, year,
                    actual_fee, scholarship, applicable, opening_balance,
                    paid, refund,hostel_fee_paid, netpaid, balance, hostel, canc_charges, netapplicable_fee
                ) VALUES " . implode(",", $values) . "
                ON DUPLICATE KEY UPDATE
                    stream_id=VALUES(stream_id),
					enrollment_no=VALUES(enrollment_no),
                    actual_fee=VALUES(actual_fee),
                    scholarship=VALUES(scholarship),
                    applicable=VALUES(applicable),
                    netapplicable_fee=VALUES(netapplicable_fee),
                    opening_balance=VALUES(opening_balance),
                    canc_charges=VALUES(canc_charges),
                    paid=VALUES(paid),
                    refund=VALUES(refund),
					hostel_fee_paid=VALUES(hostel_fee_paid), -- 🔹 UPDATE ON DUPLICATE
                    netpaid=VALUES(netpaid),
                    balance=VALUES(balance),
                    hostel=VALUES(hostel),
                    updated_at=NOW()
            ";
			//echo $insertSql;exit;
            $this->umsdb->query($insertSql);
        }

        $offset += $batchSize;
    }

    return true;
}

    /**
     * Get pivoted fee summary for report
     */
    public function get_pivot_report($filters = []) {
		$this->umsdb = $this->load->database('umsdb', TRUE);
		$admission_session=$this->umsdb->escape($filters['admission_session']);
        $where = " WHERE sm.admission_session=$admission_session and sm.package_name='Reddy' ";
        if (!empty($filters['academic_year'])) {
            $where .= " AND s.academic_year=" . $this->umsdb->escape($filters['academic_year']);
        }
        if (!empty($filters['enrollment_no'])) {
            $where .= " AND s.enrollment_no=" . $this->umsdb->escape($filters['enrollment_no']);
        }
		if (!empty($filters['admission_type'])) {
            $where .= " AND sm.admission_year=" . $this->umsdb->escape($filters['admission_type']);
        }
        $sql = "
        SELECT 
            s.enrollment_no,sm.first_name,sm.mobile,sm.gender,vw.school_short_name,vw.course_short_name,vw.stream_name,sm.uniform_status,
            MAX(CASE WHEN year=1 THEN s.academic_year END) AS y1_ay,
            MAX(CASE WHEN year=1 THEN opening_balance END) AS y1_opbal,
            MAX(CASE WHEN year=1 THEN actual_fee END) AS y1_actual,
            MAX(CASE WHEN year=1 THEN scholarship END) AS y1_scholarship,
            MAX(CASE WHEN year=1 THEN applicable END) AS y1_applicable,
            MAX(CASE WHEN year=1 THEN paid END) AS y1_paid,
            MAX(CASE WHEN year=1 THEN refund END) AS y1_refund,
            MAX(CASE WHEN year=1 THEN netpaid END) AS y1_netpaid,
            MAX(CASE WHEN year=1 THEN balance END) AS y1_balance,
            MAX(CASE WHEN year=1 THEN hostel END) AS y1_hostel,
            MAX(CASE WHEN year=1 THEN hostel_fee_paid END) AS y1_hostel_fee,

            MAX(CASE WHEN year=2 THEN s.academic_year END) AS y2_ay,
            MAX(CASE WHEN year=2 THEN opening_balance END) AS y2_opbal,
            MAX(CASE WHEN year=2 THEN actual_fee END) AS y2_actual,
            MAX(CASE WHEN year=2 THEN scholarship END) AS y2_scholarship,
            MAX(CASE WHEN year=2 THEN applicable END) AS y2_applicable,
            MAX(CASE WHEN year=2 THEN paid END) AS y2_paid,
            MAX(CASE WHEN year=2 THEN refund END) AS y2_refund,
            MAX(CASE WHEN year=2 THEN netpaid END) AS y2_netpaid,
            MAX(CASE WHEN year=2 THEN balance END) AS y2_balance,
            MAX(CASE WHEN year=2 THEN hostel END) AS y2_hostel,
			MAX(CASE WHEN year=2 THEN hostel_fee_paid END) AS y2_hostel_fee,
			
			MAX(CASE WHEN year=3 THEN s.academic_year END) AS y3_ay,
            MAX(CASE WHEN year=3 THEN opening_balance END) AS y3_opbal,
            MAX(CASE WHEN year=3 THEN actual_fee END) AS y3_actual,
            MAX(CASE WHEN year=3 THEN scholarship END) AS y3_scholarship,
            MAX(CASE WHEN year=3 THEN applicable END) AS y3_applicable,
            MAX(CASE WHEN year=3 THEN paid END) AS y3_paid,
            MAX(CASE WHEN year=3 THEN refund END) AS y3_refund,
            MAX(CASE WHEN year=3 THEN netpaid END) AS y3_netpaid,
            MAX(CASE WHEN year=3 THEN balance END) AS y3_balance,
            MAX(CASE WHEN year=3 THEN hostel END) AS y3_hostel,
			MAX(CASE WHEN year=3 THEN hostel_fee_paid END) AS y3_hostel_fee,
			
			
			MAX(CASE WHEN year=4 THEN s.academic_year END) AS y4_ay,
            MAX(CASE WHEN year=4 THEN opening_balance END) AS y4_opbal,
            MAX(CASE WHEN year=4 THEN actual_fee END) AS y4_actual,
            MAX(CASE WHEN year=4 THEN scholarship END) AS y4_scholarship,
            MAX(CASE WHEN year=4 THEN applicable END) AS y4_applicable,
            MAX(CASE WHEN year=4 THEN paid END) AS y4_paid,
            MAX(CASE WHEN year=4 THEN refund END) AS y4_refund,
            MAX(CASE WHEN year=4 THEN netpaid END) AS y4_netpaid,
            MAX(CASE WHEN year=4 THEN balance END) AS y4_balance,
            MAX(CASE WHEN year=4 THEN hostel END) AS y4_hostel,
			MAX(CASE WHEN year=4 THEN hostel_fee_paid END) AS y4_hostel_fee,
			
			
			MAX(CASE WHEN year=5 THEN s.academic_year END) AS y5_ay,
            MAX(CASE WHEN year=5 THEN opening_balance END) AS y5_opbal,
            MAX(CASE WHEN year=5 THEN actual_fee END) AS y5_actual,
            MAX(CASE WHEN year=5 THEN scholarship END) AS y5_scholarship,
            MAX(CASE WHEN year=5 THEN applicable END) AS y5_applicable,
            MAX(CASE WHEN year=5 THEN paid END) AS y5_paid,
            MAX(CASE WHEN year=5 THEN refund END) AS y5_refund,
            MAX(CASE WHEN year=5 THEN netpaid END) AS y5_netpaid,
            MAX(CASE WHEN year=5 THEN balance END) AS y5_balance,
            MAX(CASE WHEN year=5 THEN hostel END) AS y5_hostel,
			MAX(CASE WHEN year=5 THEN hostel_fee_paid END) AS y5_hostel_fee

            /* repeat blocks for year=3,4,5 */
        FROM student_fee_summary s
		JOIN student_master sm ON sm.stud_id = s.student_id
		left join vw_stream_details vw ON sm.admission_stream = vw.stream_id
        {$where}
        GROUP BY s.enrollment_no
        ORDER BY vw.school_short_name,vw.course_short_name,vw.stream_name
        ";
//echo $sql;exit;
        return $this->umsdb->query($sql)->result_array();
    }
	public function get_challan_list($filters = [])
    {
        // ✅ Campus-wise DB selection
		if (!empty($filters['status']) && $filters['status']=='Academic') {
			//echo 1;exit;
			$campus = isset($filters['campus']) ? strtolower($filters['campus']) : 'nashik';
			if ($campus === 'sijoul') {
				$umsdb = $this->load->database('sjumsdb', TRUE);
				$tbl = 'sandipun_ums_sijoul';
				$tbl_erp = 'sandipun_erp_sijoul';
			} elseif ($campus === 'sf') {
				$umsdb = $this->load->database('sfumsdb', TRUE);
				 $tbl = 'sandipun_ums_sf';
				 $tbl_erp = 'sandipun_erp_sf';
			} else {
				$umsdb = $this->load->database('umsdb', TRUE); // default Nashik
				$tbl = 'sandipun_ums';
				$tbl_erp = 'sandipun_erp';
			}

			$umsdb->select("
				fd.fees_id, sm.enrollment_no, fd.amount, fd.created_on, fd.fees_paid_type,fd.receipt_no,fd.college_receiptno,fd.academic_year,
				sm.first_name, sm.middle_name, sm.last_name, sm.academic_year as smacademic_year,
				st.stream_name, st.stream_short_name,
				ub.bank_name AS student_bank, sb.bank_name AS su_bank_name
			");
			$umsdb->from("$tbl.fees_details AS fd");
			$umsdb->join("$tbl.student_master AS sm", "sm.stud_id = fd.student_id", "left");
			$umsdb->join("$tbl.stream_master AS st", "st.stream_id = sm.admission_stream", "left");
			$umsdb->join("$tbl.bank_master AS ub", "fd.bank_id = ub.bank_id", "left");
			$umsdb->join("$tbl_erp.bank_master AS sb", "fd.bank_id = sb.bank_id", "left");

			// ✅ Date filter with 5 PM cutoff
			if (!empty($filters['fdate']) && !empty($filters['tdate'])) {
				$fdate = DateTime::createFromFormat('Y-m-d', date('Y-m-d', strtotime(str_replace('/', '-', $filters['fdate']))));
				$tdate = DateTime::createFromFormat('Y-m-d', date('Y-m-d', strtotime(str_replace('/', '-', $filters['tdate']))));
				$start = (clone $fdate)->modify('-1 day')->setTime(17, 0, 0);
				$end   = (clone $tdate)->setTime(17, 0, 0);
				$umsdb->where('fd.created_on >=', $start->format('Y-m-d H:i:s'));
				$umsdb->where('fd.created_on <',  $end->format('Y-m-d H:i:s'));
			}

			// Single date
			if (!empty($filters['tdate']) && empty($filters['fdate'])) {
				$tdate = DateTime::createFromFormat('Y-m-d', date('Y-m-d', strtotime(str_replace('/', '-', $filters['tdate']))));
				$end   = (clone $tdate)->setTime(17, 0, 0);
				$start = (clone $end)->modify('-1 day');
				$umsdb->where('fd.created_on >=', $start->format('Y-m-d H:i:s'));
				$umsdb->where('fd.created_on <',  $end->format('Y-m-d H:i:s'));
			}

        
           // $umsdb->where('fd.fees_paid_type', $filters['status']);

			$umsdb->where('fd.is_deleted', 'N');
			$umsdb->where('fd.type_id', '2');
			$umsdb->order_by('fd.fees_id', 'DESC');

			$query = $umsdb->get();
			//echo $umsdb->last_query();exit;
			return $query->result_array();
		}elseif(!empty($filters['status']) && $filters['status']=='Uniform'){

			
		}
    }
	
}
