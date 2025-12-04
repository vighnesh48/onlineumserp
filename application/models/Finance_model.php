<?php
class Finance_model extends CI_Model
{
    // 🔹 Active bank accounts
    public function getBankCount()
    {
        return $this->db->where('status', 'Active')
                        ->count_all_results('bank_accounts');
    }

    // 🔹 Active investments
    public function getInvestmentCount()
    {
        return $this->db->where('status', 'Active')
                        ->count_all_results('active_investments');
    }

    // 🔹 Investment list with days left
    public function getInvestments()
    {
        $today = date('Y-m-d');

        $query = $this->db->select("
                id, investment_id, investment_type, bank_institution, account_id,
                start_date, maturity_date, amount,maturity_amount, rate, poc_name, status,
                DATEDIFF(maturity_date, '$today') as days_left
            ")
            ->from('active_investments')
            ->where('status', 'Active')
            ->get();

        return $query->result_array();
    }

    // 🔹 Maturity counts (30/60/90 days)
    public function getMaturityCounts()
    {
        $today = date('Y-m-d');
        $sql = "
            SELECT 
              SUM(CASE WHEN DATEDIFF(maturity_date, ?) BETWEEN 0 AND 30 THEN 1 ELSE 0 END) as due30,
              SUM(CASE WHEN DATEDIFF(maturity_date, ?) BETWEEN 0 AND 60 THEN 1 ELSE 0 END) as due60,
              SUM(CASE WHEN DATEDIFF(maturity_date, ?) BETWEEN 0 AND 90 THEN 1 ELSE 0 END) as due90
            FROM active_investments
            WHERE status='Active'
        ";
        return $this->db->query($sql, [$today, $today, $today])->row_array();
    }

    // 🔹 Fee summary (Applicable / Paid / Balance) campus-wise
    public function getFeeSummary($academicYear, $campus,$drcc='')
    {	
		if($campus == 'nashik'){
			$umsdb = $this->load->database('umsdb', TRUE);
		}else{
			$umsdb = $this->load->database('sjumsdb', TRUE);
		}

        $umsdb->select("count(student_id) as studcnt,
            SUM(netapplicable_fee) as applicable,
            SUM(netpaid) as paid,
            SUM(balance) as balance
        ");
        $umsdb->from('student_fee_summary');
        $umsdb->where('academic_year', $academicYear);

        // Example filter: adjust based on your schema
         if ($drcc == '1') {
            $umsdb->where('drcc', 'Y');
        }

         return $umsdb->get()->row_array();
		  /*  if ($campus == 'nashik') {
		 echo $umsdb->last_query();exit;
		  }  */
    }

    // 🔹 Today’s collection from fees_details with 6:30 cutoff
    public function getTodayCollection_old($academicYear, $campus)
    {
       if($campus == 'nashik'){
			$umsdb = $this->load->database('umsdb', TRUE);
		}else{
			$umsdb = $this->load->database('sjumsdb', TRUE);
		}

        // Day window: 6:30PM yesterday → 6:30PM today
        $now    = new DateTime();
        $cutoff = new DateTime($now->format('Y-m-d') . ' 19:30:00');

        if ($now < $cutoff) {
            $start = (clone $cutoff)->modify('-1 day');
            $end   = $cutoff;
        } else {
            $start = $cutoff;
            $end   = (clone $cutoff)->modify('+1 day');
        }

        $umsdb->select("SUM(amount) as total");
        $umsdb->from('fees_details');
        $umsdb->where('academic_year', $academicYear);
        $umsdb->where('is_deleted', 'N');
        $umsdb->where('chq_cancelled', 'N');
        $umsdb->where('created_on >=', $start->format('Y-m-d H:i:s'));
        $umsdb->where('created_on <', $end->format('Y-m-d H:i:s'));

        // Example filter: adjust to your schema
       /*  if ($campus == 'sijoul') {
            $umsdb->where('bank_city', 'Sijoul');
        } else {
            $umsdb->where('bank_city', 'Nashik');
        } */

        $row = $umsdb->get()->row_array();
		//echo $umsdb->last_query();exit;
        return $row['total'] ?: 0;
    }
	public function getTodayCollection($academicYear, $campus, $tdate=null)
	{
		if($campus == 'nashik'){
			$umsdb = $this->load->database('umsdb', TRUE);
		}elseif($campus == 'sijoul') {
			$umsdb = $this->load->database('sjumsdb', TRUE);
		}else{
			 $umsdb = $this->load->database('sfumsdb', TRUE);
		}

		$umsdb->select("SUM(amount) as total");
		$umsdb->from('fees_details');
		$umsdb->where('academic_year', $academicYear);
		$umsdb->where('is_deleted', 'N');
		$umsdb->where('chq_cancelled', 'N');
		$umsdb->where('type_id', '2');

		if(!empty($tdate)){
			// 🔹 Use 5:00 PM cutoff window for selected date
			$start = date('Y-m-d 17:00:00', strtotime($tdate . ' -1 day'));
			$end   = date('Y-m-d 17:00:00', strtotime($tdate));

			$umsdb->where('created_on >=', $start);
			$umsdb->where('created_on <',  $end);

		} else {
			// 🔹 Default logic based on current time
			$now    = new DateTime();
			$cutoff = new DateTime($now->format('Y-m-d') . ' 17:00:00');

			if ($now < $cutoff) {
				$start = (clone $cutoff)->modify('-1 day');
				$end   = $cutoff;
			} else {
				$start = $cutoff;
				$end   = (clone $cutoff)->modify('+1 day');
			}

			$umsdb->where('created_on >=', $start->format('Y-m-d H:i:s'));
			$umsdb->where('created_on <',  $end->format('Y-m-d H:i:s'));
		}

		$row = $umsdb->get()->row_array();
		//echo $umsdb->last_query();exit;
		return $row['total'] ?: 0;
	}

	public function getFeeSummary_sf($academicYear)
    {	

		//$this->load->database();
        $this->db->select("sum(total) as studcnt,sum(TodayCollection) as TodayCollection,sum(TodayScholarshipReceived) as TodayScholarshipReceived,
            SUM(applicable) as applicable,
            SUM(paid) as paid,
            SUM(balance) as balance
        ");
         $this->db->from('sf_college_finance_summary');
         $this->db->where('academic_year', $academicYear);
         return  $this->db->get()->row_array();
		  // echo $this->db->last_query();exit;
    }
	public function getscholarshipSummary_sf($academicYear)
    {	

		//$this->load->database();
        $this->db->select("sum(total) as studcnt,
            SUM(scholarship_applicable) as applicable,
            SUM(scholarship_paid) as paid,
            SUM(pending_scholarship) as balance
        ");
         $this->db->from('sf_college_finance_summary');
         $this->db->where('academic_year', $academicYear);
         return  $this->db->get()->row_array();
    }
	//Uniform
	
	
	//Hostel & transport todays collection
	public function getTodaysfacilityCollection($academicYear, $facility, $tdate = null)
{
    // --------------------------
    // 🔹 TIME WINDOWS
    // --------------------------
    if (!empty($tdate)) {
        $todayStart = date('Y-m-d 17:00:00', strtotime($tdate . ' -1 day'));
        $todayEnd   = date('Y-m-d 17:00:00', strtotime($tdate));
    } else {
        $now    = new DateTime();
        $cutoff = new DateTime($now->format('Y-m-d') . ' 17:00:00');

        if ($now < $cutoff) {
            $todayStart = (clone $cutoff)->modify('-1 day')->format('Y-m-d H:i:s');
            $todayEnd   = $cutoff->format('Y-m-d H:i:s');
        } else {
            $todayStart = $cutoff->format('Y-m-d H:i:s');
            $todayEnd   = (clone $cutoff)->modify('+1 day')->format('Y-m-d H:i:s');
        }
    }

    $monthStart = date('Y-m-01 00:00:00', strtotime($tdate ?? date('Y-m-d')));
    $monthEnd   = $todayEnd;

    $yearStart = date('Y-04-01 00:00:00', strtotime($academicYear . '-04-01')); // academic year start
    $yearEnd   = date('Y-03-31 23:59:59', strtotime($academicYear . '-03-31 +1 year')); // academic year end

    $typeId = ($facility == '1') ? '1' : '2';

    // --------------------------
    // 🔹 SINGLE QUERY WITH CASE
    // --------------------------
    $row = $this->db
        ->select("
            SUM(CASE WHEN created_on >= '{$todayStart}' AND created_on < '{$todayEnd}' THEN amount ELSE 0 END) AS total_today,
            SUM(CASE WHEN created_on >= '{$monthStart}' AND created_on < '{$monthEnd}' THEN amount ELSE 0 END) AS total_month,
            SUM(CASE WHEN created_on >= '{$yearStart}' AND created_on <= '{$yearEnd}' THEN amount ELSE 0 END) AS total_year
        ")
        ->from('sf_fees_details')
        ->where('academic_year', $academicYear)
        ->where('is_deleted', 'N')
        ->where('chq_cancelled', 'N')
        ->where('type_id', $typeId)
        ->get()
        ->row();

    // --------------------------
    // 🔹 Return totals
    // --------------------------
    return [
        'today'  => round($row->total_today ?? 0, 2),
        'month'  => round($row->total_month ?? 0, 2),
        'yearly' => round($row->total_year ?? 0, 2)
    ];
}

	public function getTodayUniformCollection($academicYear, $campus = null, $tdate = null)
{
    // --------------------------
    // 🔹 TIME WINDOWS (5:00 PM cutoff)
    // --------------------------
    if (!empty($tdate)) {
        $todayStart = date('Y-m-d 17:00:00', strtotime($tdate . ' -1 day'));
        $todayEnd   = date('Y-m-d 17:00:00', strtotime($tdate));
    } else {
        $now    = new DateTime();
        $cutoff = new DateTime($now->format('Y-m-d') . ' 17:00:00');

        if ($now < $cutoff) {
            $todayStart = (clone $cutoff)->modify('-1 day')->format('Y-m-d H:i:s');
            $todayEnd   = $cutoff->format('Y-m-d H:i:s');
        } else {
            $todayStart = $cutoff->format('Y-m-d H:i:s');
            $todayEnd   = (clone $cutoff)->modify('+1 day')->format('Y-m-d H:i:s');
        }
    }

    $monthStart = date('Y-m-01 00:00:00', strtotime($tdate ?? date('Y-m-d')));
    $monthEnd   = $todayEnd;

    // --------------------------
    // 🔹 BUILD QUERY WITH CORRECT BINDINGS
    // --------------------------
    $bindings = [
        $todayStart,  // for total_today start
        $todayEnd,    // for total_today end
        $monthStart,  // for total_month start
        $monthEnd,    // for total_month end
        $academicYear,// academic_year
        'Uniform',    // productinfo
        'success'     // payment_status
    ];

    $sql = "
        SELECT
            SUM(CASE WHEN added_on >= ? AND added_on < ? THEN amount ELSE 0 END) AS total_today,
            SUM(CASE WHEN added_on >= ? AND added_on < ? THEN amount ELSE 0 END) AS total_month,
            SUM(amount) AS total_overall
        FROM online_payment_facilities
        WHERE academic_year = ?
          AND productinfo = ?
          AND payment_status = ?
    ";

    // Campus filter
   /*  if (!empty($campus)) {
        $sql .= " AND campus_id = ?";
        $bindings[] = $campus;
    } */

    $query = $this->db->query($sql, $bindings);
	//echo $this->db->last_query();exit;
    if (!$query) {
        log_message('error', 'Uniform collection query failed: ' . $this->db->last_query());
        return [
            'today' => 0,
            'month' => 0,
            'overall' => 0
        ];
    }

    $row = $query->row();

    return [
        'today'   => round($row->total_today ?? 0, 2),
        'month'   => round($row->total_month ?? 0, 2),
        'overall' => round($row->total_overall ?? 0, 2)
    ];
}





}
