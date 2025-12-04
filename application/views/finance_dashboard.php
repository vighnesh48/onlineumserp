<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Sandip Group Finance Dashboard</title>
  <link rel="shortcut icon" type="image/ico" href="<?=base_url()?>assets/images/favicon.ico"/>	
  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    :root {
      --accent:#2152ff;
      --accent-2:#0ea5e9;
      --success:#16a34a;
      --danger:#dc2626;
      --warning:#f59e0b;
      --muted:#6b7280;
      --card-bg:#ffffff;
      --page-bg:#f9fafb;
      --chip:#eef2ff;
      --shadow:0 8px 24px rgba(16,24,40,.06);
      --radius:18px;
	   --page-bg: linear-gradient(135deg, #f0f4ff, #f9fafb);
    }
    html, body {
  height: 100%;
  margin: 0;
  padding: 0;
}

.app-shell {
  min-height: 100vh; /* full viewport height */
  display: flex;
  flex-direction: column;
}

main.content {
  flex: 1; /* take remaining space */
  padding: 28px 24px;
}
    .navbar {
      background:linear-gradient(90deg,#2152ff,#0ea5e9);
      box-shadow:var(--shadow);
    }
    .navbar .navbar-brand {color:#fff;font-weight:700}
    .navbar .badge-soft{background:rgba(255,255,255,.2);color:#fff}
    .navbar .btn{border-color:#fff;color:#fff}

    .content {padding:28px 18px;}
    .card {
      border:0;
      border-radius:var(--radius);
      background:var(--card-bg);
      box-shadow:var(--shadow);
    }
    .hover-rise{transition:all .25s ease}
    .hover-rise:hover{transform:translateY(-5px) scale(1.01);box-shadow:0 20px 40px rgba(16,24,40,.12)}

    /* KPI gradients */
    .kpi-blue{background:linear-gradient(135deg,#3b82f6,#60a5fa);color:#fff;}
    .kpi-green{background:linear-gradient(135deg,#22c55e,#4ade80);color:#fff;}
    .kpi-purple{background:linear-gradient(135deg,#8b5cf6,#a78bfa);color:#fff;}

    .kpi .title{font-size:.95rem;font-weight:600;opacity:.9}
    .kpi .value{font-weight:800;font-size:2rem;line-height:1.2}
    .kpi .sub{font-size:.9rem;opacity:.9}

    .metric-big{font-size:1.7rem;font-weight:800}
    .muted{color:var(--muted)}
    .divider-label{font-size:.8rem;color:var(--muted);text-transform:uppercase;letter-spacing:.12em;font-weight:700}
    .section-title{font-size:1.05rem;font-weight:800}

    /* Collection gradients */
    .card-nashik{background:linear-gradient(135deg,#e0f2fe,#bfdbfe);}
    .card-sijoul{background:linear-gradient(135deg,#dcfce7,#bbf7d0);}
    .card-sf-scholarship {
    background: linear-gradient(135deg, #f3e8ff, #e9d5ff);
}
.card-hostel {
  background: linear-gradient(135deg,#fef9c3,#fde68a); /* soft yellow → gold */
}

.card-transport {
  background: linear-gradient(135deg,#fee2e2,#fecaca); /* soft red → light coral */
}

    /* Table styling */
    .table thead th {
      font-size:.8rem;
      text-transform:uppercase;
      letter-spacing:.08em;
      color:var(--muted);
    }
    .table-striped>tbody>tr:nth-of-type(odd){--bs-table-accent-bg:#f9fafb;}
    .table-hover tbody tr:hover{background:#eef2ff}

    /* Chips (Maturities Due) */
    .chip {
      display:inline-flex;
      gap:.5rem;
      align-items:center;
      padding:.4rem .7rem;
      border-radius:999px;
      background:var(--chip);
      color:#3b3bff;
      border:1px solid #e5e7ff;
      font-weight:600;
      cursor:pointer;
      transition:all .2s ease;
      user-select:none;
    }
    .chip:hover {
      background:#2d44ff;
      color:#fff;
      transform:scale(1.05);
      box-shadow:0 4px 12px rgba(0,0,0,.15);
    }
    .chip:active {
      transform:scale(0.95);
    }
    .chip.active {
      background:#2d44ff;
      color:#fff;
      border-color:#2d44ff;
    }

    footer {background:#fff;border-top:1px solid #e5e7eb}
	.badge-select {
  background: rgba(255,255,255,0.2);
  color: #fff;
  border: 0;
  border-radius: 50px;
  padding: 0.35rem 1rem;
  font-weight: 600;
  width: auto;
  appearance: none; /* hide default arrow */
  cursor: pointer;
}
.badge-select option {
  color: #000; /* dropdown items should be black */
}
/* Hostel Card - new gradient: soft green → lime green */
.card-hostel1 {
    background: linear-gradient(135deg, #d1fae5, #4ade80); /* soft green → lime green */
}

/* Transport Card - new gradient: soft orange → bright orange */
.card-transport1 {
    background: linear-gradient(135deg, #ffe5b4, #fb923c); /* soft orange → bright orange */
}

/* Optional: Hover rise effect for all cards */
.card-hostel1,
.card-transport1 {
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.08);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card-hostel1:hover,
.card-transport1:hover {
    transform: translateY(-6px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
}

  </style>


</head>
<body>
<div class="app-shell">
  <!-- Top Nav -->
  <nav class="navbar navbar-expand-lg sticky-top">
    <div class="container-fluid">
      <a class="navbar-brand d-flex align-items-center gap-2" href="#">
        <i class="bi bi-columns-gap"></i> Finance Dashboard
      </a>
	  
      <div class="ms-auto d-flex align-items-center gap-2">
	  
	  <!-- Academic Year -->
	  <select id="academicYear" class="form-select form-select-sm badge-select d-none d-md-inline">
		<option value="2021" <?php if($academicYear=='2021'){ echo 'selected';}?>>AY 2021–22</option>
		<option value="2022" <?php if($academicYear=='2022'){ echo 'selected';}?>>AY 2022–23</option>
		<option value="2023" <?php if($academicYear=='2023'){ echo 'selected';}?>>AY 2023–24</option>
		<option value="2024" <?php if($academicYear=='2024'){ echo 'selected';}?>>AY 2024–25</option>
		<option value="2025" <?php if($academicYear=='2025'){ echo 'selected';}?>>AY 2025–26</option>
	  </select>

	  <!-- Date Picker -->
	  <input type="date" id="filterDate" class="form-control form-control-sm d-none d-md-inline"
			 value="<?= isset($_GET['date']) ? $_GET['date'] : date('Y-m-d'); ?>">

	  <!--button class="btn btn-sm btn-outline-light">Back to ERP</button-->
	</div>
		&nbsp;<a href="https://erp.sandipuniversity.com/home" class="btn btn-success btn-sm" style="float:right;">Back to ERP</a>
    </div>
  </nav>

  <!-- Content -->
  <main class="content container-fluid">

    <!-- KPI Row -->
    <div class="row g-4 mb-2">
      <!-- Bank Accounts -->
      <div class="col-12 col-lg-4">
        <div class="card kpi kpi-blue hover-rise">
          <div class="card-body d-flex justify-content-between">
            <div>
              <div class="title"><i class="bi bi-building me-1"></i> Total Active Bank Accounts</div>
              <div class="value mt-1"><span><?= $bankCount ?></span></div>
              <div class="sub mt-1"><i class="bi bi-hdd-stack"></i> Salary & Operational A/cs
                &nbsp; <a href="https://erp.sandipuniversity.com/bankaccount" target="_blank" class="text-light"><i class="bi bi-info-circle"></i></a>
              </div>
            </div>
            <span class="display-6"><i class="bi bi-bank"></i></span>
          </div>
        </div>
      </div>

      <!-- Investments -->
      <div class="col-12 col-lg-4">
        <div class="card kpi kpi-green hover-rise">
          <div class="card-body d-flex justify-content-between">
            <div>
              <div class="title"><i class="bi bi-piggy-bank me-1"></i> Total Active Investments</div>
              <div class="value mt-1"><span><?= $invCount ?></span></div>
              <div class="sub mt-1"><i class="bi bi-cash-coin"></i> FD, RD, Liquid funds
                &nbsp; <a href="https://erp.sandipuniversity.com/investment" target="_blank" class="text-light"><i class="bi bi-info-circle"></i></a>
              </div>
            </div>
            <span class="display-6"><i class="bi bi-graph-up"></i></span>
          </div>
        </div>
      </div>

      <!-- Maturities -->
      <div class="col-12 col-lg-4">
        <div class="card kpi kpi-purple hover-rise">
          <div class="card-body d-flex justify-content-between">
            <div class="w-100">
              <div class="title"><i class="bi bi-hourglass-split me-1"></i> Maturities Due</div>
              <div class="d-flex gap-2 mt-2 flex-wrap">
                <span class="chip active" data-range="30" data-bs-toggle="tooltip" title="Investments maturing in next 30 days">
                  30 days <span class="badge text-bg-light ms-1"><?= $maturity['due30'] ?></span>
                </span>
                <span class="chip" data-range="60" data-bs-toggle="tooltip" title="Investments maturing in next 60 days">
                  60 days <span class="badge text-bg-light ms-1"><?= $maturity['due60'] ?></span>
                </span>
                <span class="chip" data-range="90" data-bs-toggle="tooltip" title="Investments maturing in next 90 days">
                  90 days <span class="badge text-bg-light ms-1"><?= $maturity['due90'] ?></span>
                </span>
              </div>
              <div class="sub mt-2"><i class="bi bi-info-circle"></i> Click chips to filter the table</div>
            </div>
            <span class="display-6"><i class="bi bi-calendar-event"></i></span>
          </div>
        </div>
      </div>
    </div>

   <!-- Collections -->
<?php
// Helper function for Indian number formatting
function formatIndianNumber($num) {
    $num = (int)$num;
    $num = (string)$num;
    $lastThree = substr($num, -3);
    $restUnits = substr($num, 0, -3);
    if ($restUnits != '') {
        $restUnits = preg_replace("/\B(?=(\d{2})+(?!\d))/", ",", $restUnits);
        $formatted = $restUnits . "," . $lastThree;
    } else {
        $formatted = $lastThree;
    }
    return $formatted;
}
?>

<div class="mt-4 mb-3">
    <h5 class="fw-bold">Collections vs Pending</h5>
</div>
<div class="collection-wrapper">
<div class="row g-4 flex-nowrap flex-lg-wrap overflow-auto mobile-scroll">
<?php 
$collections = [
    ['title'=>'All Students (Nashik)', 'icon'=>'bi-person-vcard','color'=>'#0d6efd','summary'=>[
        'today'=>$nashikToday ?? 0,
        'applicable'=>$nashikSummary['applicable'] ?? 0,
        'paid'=>$nashikSummary['paid'] ?? 0,
        'balance'=>$nashikSummary['balance'] ?? 0,
        'studcnt'=>$nashikSummary['studcnt'] ?? 0
    ]],
    ['title'=>'All Students (Sijoul)','icon'=>'bi-people','color'=>'#198754','summary'=>[
        'today'=>$sijoulToday ?? 0,
        'applicable'=>$sijoulSummary['applicable'] ?? 0,
        'paid'=>$sijoulSummary['paid'] ?? 0,
        'balance'=>$sijoulSummary['balance'] ?? 0,
        'studcnt'=>$sijoulSummary['studcnt'] ?? 0
    ]],
    ['title'=>'All Students SF','icon'=>'bi-bus-front','color'=>'#dc3545','summary'=>[
        'today'=>$sfToday ?? 0,
        'applicable'=>$sfsummary['applicable'] ?? 0,
        'paid'=>$sfsummary['paid'] ?? 0,
        'balance'=>$sfsummary['balance'] ?? 0,
        'studcnt'=>$sfsummary['studcnt'] ?? 0
    ]],
    ['title'=>'DRCC Student (Sijoul)','icon'=>'bi-house-door','color'=>'#ffc107','summary'=>[
        'today'=>$sijoulToday1 ?? 0,
        'applicable'=>$drccsijoulSummary['applicable'] ?? 0,
        'paid'=>$drccsijoulSummary['paid'] ?? 0,
        'balance'=>$drccsijoulSummary['balance'] ?? 0,
        'studcnt'=>$drccsijoulSummary['studcnt'] ?? 0
    ]],
    ['title'=>'Scholarship Student (SF)','icon'=>'bi-people','color'=>'#0dcaf0','summary'=>[
        'today'=>$sf_schlorship_total ?? 0,
        'applicable'=>$sfscholarship['applicable'] ?? 0,
        'paid'=>$sfscholarship['paid'] ?? 0,
        'balance'=>$sfscholarship['balance'] ?? 0,
        'studcnt'=>$sfscholarship['studcnt'] ?? 0
    ]],
    ['title'=>'Uniform','icon'=>'bi-bag','color'=>'#6f42c1','summary'=>[
        'today'=>$uniformToday['today'] ?? 0,
        'applicable'=>$uniformToday['month'] ?? 0,
        'paid'=>$uniformToday['overall'] ?? 0,
        'balance'=>$sijoulSummary1['balance'] ?? 0,
        'studcnt'=>null
    ]],
    ['title'=>'Hostel','icon'=>'bi-house','color'=>'#fd7e14','summary'=>[
        'today'=>$hostelToday['today'] ?? 0,
        'applicable'=>$hostelToday['month'] ?? 0,
        'paid'=>$hostelToday['yearly'] ?? 0,
        'balance'=>$sijoulSummary1['balance'] ?? 0,
        'studcnt'=>null
    ]],
    ['title'=>'Transport','icon'=>'bi-bus-front','color'=>'#20c997','summary'=>[
        'today'=>$transportToday['today'] ?? 0,
        'applicable'=>$transportToday['month'] ?? 0,
        'paid'=>$transportToday['yearly'] ?? 0,
        'balance'=>$sijoulSummary1['balance'] ?? 0,
        'studcnt'=>null
    ]],
];

foreach($collections as $col): 
    $isFacility = in_array($col['title'], ['Uniform', 'Hostel', 'Transport']);
    $labelApplicable = $isFacility ? 'Monthly Collection' : 'Applicable';
    $labelPaid = $isFacility ? 'Yearly Collection' : 'Paid';
?>
  <div class="col-12 col-lg-3 col-xl-2 card-container">
    <div class="card shadow-sm hover-rise border-0" style="border-radius: 12px; overflow:hidden;">
      <div class="card-header d-flex align-items-center" style="background: <?= $col['color'] ?>; color:white;">
        <i class="bi <?= $col['icon'] ?> fs-4 me-2"></i>
        <span class="fw-semibold">
            <?= $col['title'] ?>
            <?php if(!empty($col['summary']['studcnt'])): ?>
                - <?= formatIndianNumber($col['summary']['studcnt']) ?>
            <?php endif; ?>
        </span>
      </div>
      <div class="card-body p-3">
        <div class="d-flex justify-content-between align-items-center mt-2">
          <span class="text-secondary small"><i class="bi bi-cash-coin text-success"></i> Today’s Collection</span>
          <span class="fw-bold text-success fs-6">₹<?= formatIndianNumber($col['summary']['today']) ?></span>
        </div>
        <div class="d-flex justify-content-between align-items-center mt-2">
          <span class="text-secondary small"><i class="bi bi-currency-rupee text-primary"></i> <?= $labelApplicable ?></span>
          <span class="fw-bold text-primary fs-6">₹<?= formatIndianNumber($col['summary']['applicable']) ?></span>
        </div>
        <div class="d-flex justify-content-between align-items-center mt-2">
          <span class="text-secondary small"><i class="bi bi-check-circle text-success"></i> <?= $labelPaid ?></span>
          <span class="fw-bold text-success fs-6">₹<?= formatIndianNumber($col['summary']['paid']) ?></span>
        </div>
        <div class="d-flex justify-content-between align-items-center mt-2">
          <span class="text-secondary small"><i class="bi bi-hourglass-split text-danger"></i> Pending Balance</span>
          <span class="fw-bold text-danger fs-6">₹<?= formatIndianNumber($col['summary']['balance']) ?></span>
        </div>
      </div>
    </div>
  </div>
<?php endforeach; ?>
</div>
</div>
<style>
/* Hover effect */
.hover-rise {
    transition: transform 0.3s, box-shadow 0.3s;
}
.hover-rise:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}

/* DESKTOP (keep same layout) */
@media(min-width: 992px){
    .col-lg-3 {
        flex: 0 0 25%;
        max-width: 25%;
    }
}
@media(min-width: 1200px){
    .col-xl-2 { 
        flex: 0 0 16.666667%; 
        max-width: 16.666667%; 
    }
}

/* MOBILE: vertical stacking */
@media(max-width: 768px){
    .row.g-4 {
        display: block !important;
    }

    .row.g-4 > div {
        width: 100% !important;
        max-width: 100% !important;
        margin-bottom: 15px;
    }

    .card {
        width: 100%;
    }
}

/* Tablet view (smooth transition) */
@media(min-width: 769px) and (max-width: 991px){
    .row.g-4 > div {
        width: 50%;
        max-width: 50%;
    }
}


</style>



    <!-- Investment Table -->
    <!-- Investment Table -->
<div class="row g-4 mt-4">
  <div class="col-12">
    <div class="card hover-rise">
      <div class="card-body">

        <!-- Section Header -->
        <div class="section-title mb-3 text-primary">
          <i class="bi bi-clock-history"></i> Upcoming Maturities
        </div>

        <!-- 🔹 Summary Bar -->
        <div class="d-flex flex-wrap gap-4 mb-3 p-3 rounded bg-light border">
          <div>
            <i class="bi bi-list-check text-primary me-1"></i>
            <strong>Total Investments:</strong> <?= count($investments) ?>
          </div>
          <div>
            <i class="bi bi-cash-stack text-success me-1"></i>
            <strong>Total Maturity Amount:</strong> ₹<?= number_format(array_sum(array_column($investments,'maturity_amount')),2) ?>
          </div>
          <div>
            <i class="bi bi-calendar-check text-warning me-1"></i>
            <strong>Next Maturity:</strong> 
			
           <?php
				$today = date('Y-m-d');
				$futureDates = array_filter(array_column($investments, 'maturity_date'), function($d) use ($today) {
					return $d >= $today;
				});

				echo $nextMaturity = !empty($futureDates) 
					? date('d-M-Y', strtotime(min($futureDates)))
					: '—';
				?>
          </div>
        </div>

        <!-- 🔹 Maturity Table -->
        <div class="table-responsive">
          <table class="table table-striped table-hover align-middle">
            <thead>
              <tr>
                <th>Investment ID</th>
                <th>Type</th>
                <th>Bank/Institution</th>
                <th>Account</th>
                <th>Start Date</th>
                <th>Maturity Date</th>
                <th>Amount (₹)</th>
                <th>Rate (%)</th>
                <th>Days Left</th>
                <th>POC</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody id="maturityBody">
              <?php foreach($investments as $inv): ?>
              <tr data-days="<?= $inv['days_left'] ?>">
                <td><?= $inv['investment_id'] ?></td>
                <td><?= $inv['investment_type'] ?></td>
                <td><?= $inv['bank_institution'] ?></td>
                <td><?= $inv['account_id'] ?></td>
                <td><?= date('d-M-Y', strtotime($inv['start_date'])) ?></td>
                <td><?= date('d-M-Y', strtotime($inv['maturity_date'])) ?></td>
                <td><?= number_format($inv['amount'],2) ?></td>
                <td><?= $inv['rate'] ?: '—' ?></td>
                <td><span class="badge text-bg-warning"><?= $inv['days_left'] ?></span></td>
                <td><?= $inv['poc_name'] ?></td>
                <td><span class="badge text-bg-success"><?= $inv['status'] ?></span></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <div class="text-muted small">Tip: click a chip above to filter table</div>
      </div>
    </div>
  </div>
</div>

  </main>

  <footer class="py-4 text-center text-muted">
    <small>© <span id="yr"></span> Finance Dashboard</small>
  </footer>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // Footer year
  document.getElementById('yr').textContent = new Date().getFullYear();

  // Maturities filter chips
  const chips = document.querySelectorAll('.chip');
  const tbody = document.getElementById('maturityBody');
  chips.forEach(chip => {
    chip.addEventListener('click', () => {
      chips.forEach(c => c.classList.remove('active'));
      chip.classList.add('active');
      const range = parseInt(chip.dataset.range, 10);
      [...tbody.querySelectorAll('tr')].forEach(row => {
        const days = parseInt(row.getAttribute('data-days'), 10);
        row.style.display = (days <= range && days >= 0) ? '' : 'none';
      });
    });
  });
  document.querySelector('.chip[data-range="30"]').click();

  // Bootstrap tooltips
  var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
  var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
  })
</script>
<script>
document.getElementById('academicYear').addEventListener('change', applyFilters);
document.getElementById('filterDate').addEventListener('change', applyFilters);
function applyFilters() {
  const year = document.getElementById('academicYear').value;
  const date = document.getElementById('filterDate').value;

  let url = "https://erp.sandipuniversity.com/finance/dashboard?academic_year=" + year;
  if(date) {
    url += "&date=" + date;
  }
  window.location.href = url; // 🔹 Page reloads with filters applied
}

</script>
</body>
</html>
