<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">


 <style>
/* =========================
   THEME VARIABLES (4 PALETTES)
   Apply via <body data-theme="warm|futuristic|aesthetic|vibrant">
   ========================= */
:root{
  /* Fallbacks (Warm-ish) */
  --bg-body-grad-start:#fff7f1; --bg-body-grad-end:#fef4e6;
  --font-family:'Inter','Segoe UI',sans-serif;

  /* Container card */
  --container-bg:#ffffff;
  --container-shadow:0 6px 30px rgba(255,170,90,0.25);
  --container-shadow-hover:0 8px 40px rgba(255,170,90,0.35);

  /* Text + borders */
  --text:#3e3e3e; --muted-border:#ffc57f; --muted-border-strong:#ffcc80; --muted-bg:#fffdf9;

  /* Primary accents */
  --primary:#ff7b00; --primary-2:#ffb84d; --primary-strong:#ff9f43;

  /* Header gradient */
  --header-grad-start:#ff8800; --header-grad-end:#ffb84d;

  /* Seat card */
  --seat-bg-1:#fff8ee; --seat-bg-2:#ffe9ca; --seat-border:#ffb84d;
  --seat-shadow:2px 4px 10px rgba(255,165,60,0.3);
  --seat-hover-1:#ffecc3; --seat-hover-2:#fff6dc;
  --seat-tag-bg:#ff8c00; --seat-text:#4b2e05;

  /* Status chips (lists/legend) */
  --ok:#79ff9c99; --warn:#f4b04fa6; --neutral:#ffffff;

  /* Icon accents */
  --icon:#ff9f43; --icon-hover:#ff6f00;

  /* Button gradients */
  --btn-grad-1:#1e3c72; --btn-grad-2:#2a5298;
  --btn-grad-hover-1:#2a5298; --btn-grad-hover-2:#1e3c72;

  /* Secondary button gradients */
  --warn-1:#ff9900; --warn-2:#ffc266;
  --warn-1h:#ffb84d; --warn-2h:#ff8a00;
  --danger-1:#ff4d4f; --danger-2:#ff767a;
  --danger-1h:#ff6b6d; --danger-2h:#ff4d4f;
  --success-1:#2ecc71; --success-2:#58d68d;
  --success-1h:#58d68d; --success-2h:#2ecc71;

  /* Hall container */
  --hall-bg-start:#fff9f3; --hall-bg-end:#fff3e0;
  --hall-card-border:#ffddaa;
  --hall-card-shadow:0 6px 18px rgba(255,170,90,0.3);
  --hall-card-shadow-hover:0 10px 25px rgba(255,170,90,0.45);
}

/* 🟠 Warm */
body[data-theme="warm"]{
  --bg-body-grad-start:#fff7f1; --bg-body-grad-end:#fef4e6;
  --container-bg:#ffffff;
  --container-shadow:0 6px 30px rgba(255,170,90,0.25);
  --container-shadow-hover:0 8px 40px rgba(255,170,90,0.35);
  --text:#3e3e3e; --muted-border:#ffc57f; --muted-border-strong:#ffcc80; --muted-bg:#fffdf9;
  --primary:#ff7b00; --primary-2:#ffb84d; --primary-strong:#ff9f43;
  --header-grad-start:#ff8800; --header-grad-end:#ffb84d;
  --seat-bg-1:#fff8ee; --seat-bg-2:#ffe9ca; --seat-border:#ffb84d;
  --seat-shadow:2px 4px 10px rgba(255,165,60,0.3);
  --seat-hover-1:#ffecc3; --seat-hover-2:#fff6dc;
  --seat-tag-bg:#ff8c00; --seat-text:#4b2e05;
  --ok:#79ff9c99; --warn:#f4b04fa6; --neutral:#ffffff;
  --icon:#ff9f43; --icon-hover:#ff6f00;
  --btn-grad-1:#1e3c72; --btn-grad-2:#2a5298; --btn-grad-hover-1:#2a5298; --btn-grad-hover-2:#1e3c72;
  --warn-1:#ff9900; --warn-2:#ffc266; --warn-1h:#ffb84d; --warn-2h:#ff8a00;
  --danger-1:#ff4d4f; --danger-2:#ff767a; --danger-1h:#ff6b6d; --danger-2h:#ff4d4f;
  --success-1:#2ecc71; --success-2:#58d68d; --success-1h:#58d68d; --success-2h:#2ecc71;
  --hall-bg-start:#fff9f3; --hall-bg-end:#fff3e0; --hall-card-border:#ffddaa;
  --hall-card-shadow:0 6px 18px rgba(255,170,90,0.3); --hall-card-shadow-hover:0 10px 25px rgba(255,170,90,0.45);
  --.form-control, select, .select2{border:1px solid var(--muted-border); border-radius:8px; transition:.3s ease; background:var(--muted-bg);}

}

/* 🟣 Futuristic (cyan/purple) */
body[data-theme="futuristic"]{
  --bg-body-grad-start:#0f1023; --bg-body-grad-end:#10152b;
  --container-bg:#121633;
  --container-shadow:0 6px 30px rgba(0,255,255,0.12);
  --container-shadow-hover:0 8px 40px rgba(0,255,255,0.2);
  --text:#e9ecff; --muted-border:#4853a6; --muted-border-strong:#5a67d8; --muted-bg:#161b3e;
  --primary:#00e5ff; --primary-2:#8a2be2; --primary-strong:#7df9ff;
  --header-grad-start:#00d0ff; --header-grad-end:#8a2be2;
  --seat-bg-1:#151a3b; --seat-bg-2:#1b214d; --seat-border:#3341a1;
  --seat-shadow:2px 4px 10px rgba(0,229,255,0.18);
  --seat-hover-1:#192055; --seat-hover-2:#232c6b;
  --seat-tag-bg:#00c7ff; --seat-text:#eaf2ff;
  --ok:#2ea14ce8; --warn:#b78000ad; --neutral:#161b3e;
  --icon:#7df9ff; --icon-hover:#00e5ff;
  --btn-grad-1:#2a2f6b; --btn-grad-2:#1c7fb6; --btn-grad-hover-1:#1c7fb6; --btn-grad-hover-2:#2a2f6b;
  --warn-1:#ffb300; --warn-2:#ffd166; --warn-1h:#ffd166; --warn-2h:#ffb300;
  --danger-1:#ff3b81; --danger-2:#ff6fa6; --danger-1h:#ff6fa6; --danger-2h:#ff3b81;
  --success-1:#18e6a8; --success-2:#59f0c6; --success-1h:#59f0c6; --success-2h:#18e6a8;
  --hall-bg-start:#0f1126; --hall-bg-end:#0f1833; --hall-card-border:#2a368c;
  --hall-card-shadow:0 6px 18px rgba(0,229,255,0.15); --hall-card-shadow-hover:0 10px 25px rgba(0,229,255,0.25);
  --.form-control, select, .select2{border:1px solid var(--muted-border); border-radius:8px; transition:.3s ease; background:var(--muted-bg);color:white;}

}

/* 💗 Aesthetic (pastel pink/lavender) */
body[data-theme="aesthetic"]{
  --bg-body-grad-start:#fff1f7; --bg-body-grad-end:#f6f0ff;
  --container-bg:#ffffff;
  --container-shadow:0 6px 30px rgba(220,120,255,0.18);
  --container-shadow-hover:0 8px 40px rgba(220,120,255,0.26);
  --text:#3b2f40; --muted-border:#f5b1d3; --muted-border-strong:#e3c8ff; --muted-bg:#fffaff;
  --primary:#e56bbf; --primary-2:#b38cff; --primary-strong:#ff93d1;
  --header-grad-start:#e56bbf; --header-grad-end:#b38cff;
  --seat-bg-1:#fff4fb; --seat-bg-2:#f3eaff; --seat-border:#e5c7ff;
  --seat-shadow:2px 4px 10px rgba(179,140,255,0.25);
  --seat-hover-1:#fceeff; --seat-hover-2:#f8f1ff;
  --seat-tag-bg:#cc7ee6; --seat-text:#3b2f40;
  --ok:#79ff9c99; --warn:#f4b04fa6; --neutral:#ffffff;
  --icon:#d97dd8; --icon-hover:#b967e3;
  --btn-grad-1:#b38cff; --btn-grad-2:#e56bbf; --btn-grad-hover-1:#e56bbf; --btn-grad-hover-2:#b38cff;
  --warn-1:#ffad5b; --warn-2:#ffd1a6; --warn-1h:#ffc38a; --warn-2h:#ff9b43;
  --danger-1:#ff6b6d; --danger-2:#ff9aa1; --danger-1h:#ff9aa1; --danger-2h:#ff6b6d;
  --success-1:#8ee6b8; --success-2:#b7f2d2; --success-1h:#b7f2d2; --success-2h:#8ee6b8;
  --hall-bg-start:#fff6fb; --hall-bg-end:#f6f2ff; --hall-card-border:#f0d8ff;
  --hall-card-shadow:0 6px 18px rgba(179,140,255,0.25); --hall-card-shadow-hover:0 10px 25px rgba(179,140,255,0.35);
  --.form-control, select, .select2{border:1px solid var(--muted-border); border-radius:8px; transition:.3s ease; background:var(--muted-bg);}

}

/* 🌈 Vibrant (multicolor) */
body[data-theme="vibrant"]{
  --bg-body-grad-start:#fff7ff; --bg-body-grad-end:#e7fbff;
  --container-bg:#ffffff;
  --container-shadow:0 6px 30px rgba(255,99,132,0.18);
  --container-shadow-hover:0 8px 40px rgba(54,162,235,0.25);
  --text:#2b2b2b; --muted-border:#a2d2ff; --muted-border-strong:#ffafcc; --muted-bg:#ffffff;
  --primary:#ff5e7d; --primary-2:#4cc9f0; --primary-strong:#ff9f1c;
  --header-grad-start:#ff5e7d; --header-grad-end:#4cc9f0;
  --seat-bg-1:#fff0f3; --seat-bg-2:#e9f7ff; --seat-border:#a2d2ff;
  --seat-shadow:2px 4px 10px rgba(76,201,240,0.25);
  --seat-hover-1:#ffe6ef; --seat-hover-2:#e1f4ff;
  --seat-tag-bg:#ff7aa2; --seat-text:#2b2b2b;
  --ok:#79ff9c99; --warn:#f4b04fa6; --neutral:#ffffff;
  --icon:#ff6b6b; --icon-hover:#4cc9f0;
  --btn-grad-1:#ff5e7d; --btn-grad-2:#4cc9f0; --btn-grad-hover-1:#4cc9f0; --btn-grad-hover-2:#ff5e7d;
  --warn-1:#ff9f1c; --warn-2:#ffd166; --warn-1h:#ffd166; --warn-2h:#ff9f1c;
  --danger-1:#ef476f; --danger-2:#ff7aa2; --danger-1h:#ff7aa2; --danger-2h:#ef476f;
  --success-1:#06d6a0; --success-2:#33e6b8; --success-1h:#33e6b8; --success-2h:#06d6a0;
  --hall-bg-start:#fff4fb; --hall-bg-end:#edf9ff; --hall-card-border:#ffd6e5;
  --hall-card-shadow:0 6px 18px rgba(76,201,240,0.25); --hall-card-shadow-hover:0 10px 25px rgba(255,94,125,0.35);
  --.form-control, select, .select2{border:1px solid var(--muted-border); border-radius:8px; transition:.3s ease; background:var(--muted-bg);}

}

/* =========================
   BASE (uses variables)
   ========================= */
body{
  background:linear-gradient(180deg,var(--bg-body-grad-start) 0%,var(--bg-body-grad-end) 100%);
  font-family:var(--font-family);
  margin-top:30px; color:var(--text);
}

.container{
  /* keep your layout */
  max-width:40%;
  background:var(--container-bg);
  border-radius:16px;
  box-shadow:var(--container-shadow);
  padding:30px;
  margin-top:70px;
  transition:all .3s ease;
  font-size:14px;
}
.container:hover{ box-shadow:var(--container-shadow-hover); }

h1{
  text-align:center; margin-bottom:20px;
  background:linear-gradient(90deg,var(--primary-2),var(--primary));
  -webkit-background-clip:text; -webkit-text-fill-color:transparent;
  font-weight:800; letter-spacing:1px; animation:fadeInTitle 1.5s ease-in-out;
}
@keyframes fadeInTitle{ from{opacity:0;transform:translateY(-10px)} to{opacity:1;transform:translateY(0)} }

label{ font-weight:700; color:var(--text); letter-spacing:.3px; }


.form-control:focus, .form-select:focus{
  border-color:var(--primary-strong);
  box-shadow:0 0 10px rgba(0,0,0,0), 0 0 10px color-mix(in srgb, var(--primary-strong) 35%, transparent);
}
/* Icons */
.icon-animated{ color:var(--icon); transition:transform .3s ease, color .3s ease; }
.icon-animated:hover{ transform:scale(1.3) rotate(-5deg); color:var(--icon-hover); }
.fa-chair,.fa-layer-group,.fa-user-graduate,.fa-calendar-days,.fa-book-open-reader,.fa-clock,.fa-building-columns,.fa-th-large,.fa-th-list{
  animation:chairBounce 2s infinite ease-in-out;
}
@keyframes chairBounce{ 0%,100%{transform:translateY(0)} 50%{transform:translateY(-6px)} }
/* Buttons (keep your widths & sizes) */
.btn{ border:none; font-weight:600; border-radius:10px; }
.btn-primary{ width:100%;
  background:linear-gradient(90deg,var(--btn-grad-1),var(--btn-grad-2))!important; border:none!important; color:#fff!important; font-weight:600!important;
  padding:.7rem 1.8rem!important; border-radius:8px!important; box-shadow:0 4px 10px color-mix(in srgb, var(--primary) 30%, transparent)!important;
  transition:all .3s ease!important;
}
.btn-primary:hover{
  background:linear-gradient(90deg,var(--btn-grad-hover-1),var(--btn-grad-hover-2))!important;
  transform:translateY(-1px)!important;

}
.btn-warning{ width:100%; 
  background:linear-gradient(90deg,var(--warn-1),var(--warn-2)) !important; border:none; color:#fff; font-weight:600!important;
  padding:.7rem 1.8rem!important; border-radius:8px!important; box-shadow:0 4px 10px color-mix(in srgb, var(--primary) 30%, transparent)!important;
  transition:all .3s ease!important;
}
.btn-warning:hover{
  background:linear-gradient(90deg,var(--warn-1h),var(--warn-2h))!important;
  transform:translateY(-1px)!important;
}
.btn-danger{ width:100%; 
  background:linear-gradient(90deg,var(--danger-1),var(--danger-2))!important; border:none; color:#fff!important; font-weight:600!important;
  padding:.7rem 1.8rem!important; border-radius:8px!important; box-shadow:0 4px 10px color-mix(in srgb, var(--primary) 30%, transparent)!important;
  transition:all .3s ease!important;
}
.btn-danger:hover{
  background:linear-gradient(90deg,var(--danger-1h),var(--danger-2h))!important;
  transform:translateY(-1px)!important;
}
.btn-success{
  background:linear-gradient(90deg,var(--success-1),var(--success-2))!important;
  border:none; font-weight:700; padding:10px 18px; border-radius:10px!important;
  box-shadow:0 4px 10px rgba(0,0,0,.08)!important;
}
.btn-success:hover{
  background:linear-gradient(90deg,var(--success-1h),var(--success-2h))!important;
  transform:translateY(-1px)!important;
}

/* Seating display wrapper (card look) */
#seatingData, .seatingData{
  background:var(--container-bg);
  border:1px solid var(--hall-card-border);
  border-radius:12px;
  box-shadow:var(--hall-card-shadow);
  padding:16px; margin:10px auto;
  transition:box-shadow .3s ease, transform .2s ease-in-out;
}
#seatingData:hover{ box-shadow:var(--hall-card-shadow-hover); }

/* Seat grid/rows */
.seat-grid{ display:flex; flex-direction:column; gap:5px; }
.seat-row{ display:flex; gap:5px; flex-wrap:nowrap; }

/* Seat box (matches previous seat aesthetics) */
.seat-box{
  width:400px; height:150px; display:flex; flex-direction:column; justify-content:center;
  border-radius:10px; position:relative; overflow:hidden; padding:20px;
  background:linear-gradient(145deg,var(--seat-bg-1),var(--seat-bg-2));
  border:2px solid var(--seat-border); box-shadow:var(--seat-shadow);
  color:var(--seat-text); font-weight:700; transition:all .3s ease-in-out;
}
.seat-box:hover{
  background:linear-gradient(145deg,var(--seat-hover-1),var(--seat-hover-2));
  transform:scale(1.01);
  box-shadow:3px 5px 14px color-mix(in srgb, var(--primary-2) 45%, transparent);
}
.seat-box select{ font-size:14px; border:1px solid var(--muted-border-strong); background:var(--muted-bg); }

/* Section header strip inside dynamic seat renders (optional) */
.seat-box::before{
  content:attr(data-seat); position:absolute; top:-6px; left:50%; transform:translateX(-50%);
  background:var(--seat-tag-bg); color:#fff; font-size:12px; padding:2px 10px; border-radius:6px;
  box-shadow:0 0 6px color-mix(in srgb, var(--seat-tag-bg) 40%, transparent);
}

/* Legend/status helpers (if server renders bg-*) */
.bg-success{ background-color:var(--ok) !important; color:#000; }
.bg-warning{ background-color:var(--warn) !important; color:#000; }
.bg-white{ background-color:var(--neutral) !important; }

/* =========================
   FLOATING THEME SWITCHER
   ========================= */
.theme-fab{
  position:fixed; right:22px; bottom:22px; width:54px; height:54px; border-radius:50%;
  background:linear-gradient(135deg,var(--primary),var(--primary-2)); color:#fff;
  display:flex; align-items:center; justify-content:center;
  box-shadow:0 10px 25px color-mix(in srgb, var(--primary) 30%, transparent);
  cursor:pointer; z-index:9999; transition:transform .2s ease, box-shadow .3s ease;
}
.theme-fab:hover{ transform:translateY(-2px) scale(1.03); box-shadow:0 12px 30px color-mix(in srgb, var(--primary) 40%, transparent); }

.theme-palette{
  position:fixed; right:22px; bottom:86px; background:var(--container-bg);
  border:1px solid var(--muted-border-strong); box-shadow:var(--container-shadow-hover);
  border-radius:12px; padding:10px 12px; display:none; z-index:9999; min-width:230px;
}
.theme-row{ display:flex; gap:10px; align-items:center; justify-content:space-between; }
.theme-group{ display:flex; flex-direction:column; align-items:center; gap:6px; flex:1; }
.theme-chip{
  flex:1; height:32px; width:100%; border-radius:20px; cursor:pointer; position:relative; overflow:hidden;
  border:1px solid var(--muted-border-strong); transition:transform .12s ease;
}
.theme-chip:hover{ transform:translateY(-1px); }
.theme-chip[data-theme="warm"]{ background:linear-gradient(90deg,#ff8800,#ffb84d); }
.theme-chip[data-theme="futuristic"]{ background:linear-gradient(90deg,#00d0ff,#8a2be2); }
.theme-chip[data-theme="aesthetic"]{ background:linear-gradient(90deg,#e56bbf,#b38cff); }
.theme-chip[data-theme="vibrant"]{ background:linear-gradient(90deg,#ff5e7d,#4cc9f0); }
.theme-label{ font-size:12px; color:var(--text); opacity:.85; }

.theme-palette.show{ display:block; animation:fadeSlide .18s ease-out; }
@keyframes fadeSlide{ from{opacity:0; transform:translateY(6px)} to{opacity:1; transform:translateY(0)} }
</style>
<script>
(function(){
  const THEMES = ["warm","futuristic","aesthetic","vibrant"];
  const STORAGE_KEY = "seating_report_theme";

  // Apply saved or default theme
  const saved = localStorage.getItem(STORAGE_KEY) || "warm";
  document.body.setAttribute("data-theme", saved);

  // Floating FAB (inline SVG palette icon)
  const fab = document.createElement("div");
  fab.className = "theme-fab";
  fab.innerHTML = `
    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" aria-hidden="true">
      <path d="M12 3a9 9 0 100 18h2.5a2.5 2.5 0 000-5H14a2 2 0 01-2-2v-.5a1.5 1.5 0 011.5-1.5H15a3 3 0 000-6h-1a2 2 0 01-2-2z" stroke="white" stroke-width="1.5"/>
      <circle cx="8" cy="8" r="1.3" fill="white"/>
      <circle cx="16" cy="7" r="1.3" fill="white"/>
      <circle cx="9" cy="14" r="1.3" fill="white"/>
    </svg>`;
  document.body.appendChild(fab);

  // Palette
  const pal = document.createElement("div");
  pal.className = "theme-palette";
  pal.innerHTML = `
    <div class="theme-row">
      ${THEMES.map(t => `
        <div class="theme-group">
          <div class="theme-chip" data-theme="${t}" title="${t}"></div>
          <div class="theme-label">${t.charAt(0).toUpperCase()+t.slice(1)}</div>
        </div>
      `).join("")}
    </div>
  `;
  document.body.appendChild(pal);

  fab.addEventListener("click", ()=> pal.classList.toggle("show"));
  document.addEventListener("click", (e)=>{
    if(!pal.contains(e.target) && !fab.contains(e.target)) pal.classList.remove("show");
  });
  pal.addEventListener("click", (e)=>{
    const chip = e.target.closest(".theme-chip");
    if(!chip) return;
    const theme = chip.getAttribute("data-theme");
    document.body.setAttribute("data-theme", theme);
    localStorage.setItem(STORAGE_KEY, theme);
    pal.classList.remove("show");
  });
})();
</script>

<div class="container">
  <h1 class="mb-4">Seating Arrangement Report</h1>

  <form action="<?= base_url('SeatingReport/generateReport') ?>" method="POST">
    <!-- Exam -->
    <div class="form-group mb-3">
      <label for="exam">
        <i class="fa-solid fa-user-graduate icon-animated"></i> Select Exam:
      </label>
      <select id="exam" name="exam_id" class="form-control select2" style="font-size:12px">
        <?php foreach ($exams as $exam): ?>
          <option value="<?= $exam['exam_id'] ?>"><?= $exam['exam_name'] ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <!-- Date -->
    <div class="form-group mb-3">
      <label for="exam_date">
        <i class="fa-solid fa-calendar-days icon-animated"></i> Select Date:
      </label>
      <input type="date" id="exam_date" name="exam_date" class="form-control" style="font-size:12px">
    </div>

    <!-- Session -->
    <div class="form-group mb-3">
      <label for="session">
        <i class="fa-solid fa-clock icon-animated"></i> Select Exam Session:
      </label>
      <select id="session" name="session" class="form-control select2" style="font-size:12px">
        <option value="FN">FN</option>
        <option value="AN">AN</option>
      </select>
    </div>

    <!-- Building -->
    <div class="form-group mb-3">
      <label for="building">
        <i class="fa-solid fa-building-columns icon-animated"></i> Select Building:
      </label>
      <select id="building" name="building_id" class="form-control select2" style="font-size:12px">
        <option value="">Select Building</option>
        <?php foreach ($buildings as $building): ?>
          <option value="<?= $building['id'] ?>"><?= $building['building_name'] ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <!-- Floor -->
    <div class="form-group mb-3">
      <label for="floor">
        <i class="fa-solid fa-layer-group icon-animated"></i> Select Floor:
      </label>
      <select id="floor" name="floor_id" class="form-control select2" style="font-size:12px">
        <option value="">Select Floor</option>
      </select>
    </div>

    <!-- Hall -->
    <div class="form-group mb-3">
      <label for="hall">
        <i class="fa-solid fa-chair icon-animated"></i> Select Hall:
      </label>
      <select id="hall" name="hall_id" class="form-control select2" style="font-size:12px">
        <option value="">Select Hall</option>
      </select>
    </div>

    <!-- Report Type -->
    <div class="form-group mb-3">
      <label>
        <i class="fa-solid fa-th-list icon-animated"></i> Report Type:
      </label>
      <div class="mt-2">
        <div class="form-check mb-1">
          <input class="form-check-input" type="radio" name="report_type" id="rt_seating" value="seating" checked>
          <label class="form-check-label" for="rt_seating">Consolidated Seating For Student</label>
        </div>
        <div class="form-check mb-1">
          <input class="form-check-input" type="radio" name="report_type" id="rt_subjectwise" value="subjectwise">
          <label class="form-check-label" for="rt_subjectwise">Student Attendance Sheet</label>
        </div>
        <!--
        <div class="form-check mb-1">
          <input class="form-check-input" type="radio" name="report_type" id="rt_hallwise" value="hallwise">
          <label class="form-check-label" for="rt_hallwise">Hall-wise Report</label>
        </div>
        -->
        <div class="form-check">
          <input class="form-check-input" type="radio" name="report_type" id="rt_doorwise" value="doorwise">
          <label class="form-check-label" for="rt_doorwise">Door-wise Report</label>
        </div>
      </div>
    </div>

    <button type="submit" class="btn btn-primary">
      <i class="fa-solid fa-file-pdf icon-animated"></i> Generate PDF
    </button>
  </form>
	</br>
    <button id="searchSeating" class="btn btn-warning">
      <i class="fa-solid fa-pen-to-square icon-animated"></i> Edit Seating
    </button> 
	</br>
	</br>
    <button id="softDeleteSeating" class="btn btn-danger">
      <i class="fa-solid fa-trash icon-animated"></i> Delete Seating
    </button>

</div>

<!-- Display Seating Data -->
<div id="seatingData" class="mt-2"></div>
<center>
  <button type="button" id="saveSeatingArrangement" class="btn btn-success" style="padding:10px;font-size:14px;">
    <i class="fa-solid fa-floppy-disk icon-animated"></i> Update Seating
  </button>
</center>


<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {
    // Fetch floors when building changes
    $('#building').change(function() {
        var buildingId = $(this).val();
        if (buildingId) {
            $.ajax({
                url: '<?= base_url("SeatingReport/get_floors") ?>',
                type: 'GET',
                data: { building_id: buildingId },
                dataType: 'json',
                success: function(response) {
                    var floorOptions = '<option value="">Select Floor</option>';
                    $.each(response.floors, function(index, floor) {
                        floorOptions += `<option value="${floor.floor}">${floor.floor}</option>`;
                    });
                    $('#floor').html(floorOptions);
                    $('#hall').html('<option value="">Select Hall</option>'); // Reset halls
                }
            });
        } else {
            $('#floor').html('<option value="">Select Floor</option>');
            $('#hall').html('<option value="">Select Hall</option>');
        }
    });

    // Fetch halls when floor changes
    $('#floor').change(function() {
        var floorId = $(this).val();
        var buildingId = $('#building').val();
        if (floorId) {
            $.ajax({
                url: '<?= base_url("SeatingReport/get_halls") ?>',
                type: 'GET',
                data: { floor_id: floorId, building_id: buildingId },
                dataType: 'json',
                success: function(response) {
                    var hallOptions = '<option value="">Select Hall</option>';
                    $.each(response.halls, function(index, hall) {
                        hallOptions += `<option value="${hall.hall_no}">${hall.hall_no}</option>`;
                    });
                    $('#hall').html(hallOptions);
                }
            });
        } else {
            $('#hall').html('<option value="">Select Hall</option>');
        }
    });





        // Fetch seating arrangement when "Search" button is clicked
        $('#searchSeating').click(function(e) {
        e.preventDefault();

        var examId = $('#exam').val();
        var examDate = $('#exam_date').val();
        var session = $('#session').val();
        var buildingId = $('#building').val();
        var floorId = $('#floor').val();
        var hallId = $('#hall').val();
        let allocatedStudents = []; // Store allocated students

        if (!examId || !examDate || !session || !buildingId || !floorId || !hallId) {
            alert("Please select all required fields.");
            return;
        }

        $.ajax({
            url: '<?= base_url("SeatingReport/fetchSeatingData") ?>',
            type: 'POST',
            data: {
                exam_id: examId,
                exam_date: examDate,
                session: session,
                building_id: buildingId,
                floor_id: floorId,
                hall_id: hallId
            },
            dataType: 'json',
            beforeSend: function() {
                $('#seatingData').html('<p>Loading...</p>');
            },
            success: function(response) {
                if (response.status === 'success') {
                    $('#seatingData').html(response.html);
                    allocatedStudents = response.allocated_students; // Store allocated students
                } else {
                    $('#seatingData').html('<p class="text-danger">' + response.message + '</p>');
                }
            },
            error: function() {
                $('#seatingData').html('<p class="text-danger">Error fetching seating arrangement.</p>');
            }
        });
    });
    // Fetch students dynamically when subject changes
    $(document).on('change', '.subject-dropdown', function () {
        var subjectDropdown = $(this);
        var studentDropdown = subjectDropdown.closest('.seat-box').find('.student-dropdown');
        var subjectId = subjectDropdown.val();
        var seatIndex = subjectDropdown.data('seat-index');

        if (subjectId) {
            $.ajax({
                url: '<?= base_url("SeatingReport/fetchStudentsForSubject") ?>',
                type: 'POST',
                data: {
                    subject_id: subjectId,
                    exam_id: $('#exam').val(),
                    exam_date: $('#exam_date').val(),
                    session: $('#session').val(),
                    allocated_students: allocatedStudents // Send allocated students
                },
                dataType: 'json',
                success: function (response) {
                    if (response.status === 'success') {
                        studentDropdown.html(response.html);
                    }
                }
            });
        } else {
            studentDropdown.html('<option value="">Select Student</option>'); // Reset if no subject selected
        }
    });

    // Handle student selection & prevent duplicate assignments
    $(document).on('change', '.student-dropdown', function () {
        var studentDropdown = $(this);
        var selectedStudent = studentDropdown.val();

        // Remove student from other dropdowns except the selected one
        $('.student-dropdown').each(function () {
            if ($(this).val() === selectedStudent && this !== studentDropdown[0]) {
                $(this).val('');
            }
        });

        // Update allocatedStudents array
        allocatedStudents = [];
        $('.student-dropdown').each(function () {
            var val = $(this).val();
            if (val) {
                allocatedStudents.push(val);
            }
        });
    });
});

$(document).on('change', '.subject-dropdown', function () {
    var subjectDropdown = $(this);
    var studentDropdown = subjectDropdown.closest('.seat-box').find('.student-dropdown');
    var subjectId = subjectDropdown.val();
  //  alert(subjectId);
    var exam_id = $('#exam').val();
    var date = $('#exam_date').val();
    var session = $('#session').val();

    fetchStudentsForSubject(exam_id, date, session, subjectId, studentDropdown, studentDropdown.val());
	
});




function fetchStudentsForSubject(exam_id, date, session, subjectId, dropdown, selectedStudent) {
    $.ajax({
        url: '<?= base_url("SeatingReport/fetchStudentsForSubject") ?>',
        type: 'POST',
        data: {
            subject_id: subjectId,
            exam_id: exam_id,
            date: date,
            session: session
        },
        dataType: 'json',
        success: function (data) {
            let options = '<option value="">Select Student</option>';
            let selectedList = subjectWiseSelectedStudents[subjectId] || [];

            data.students.forEach(function (student) {
                const isSelected = (student.enrollment_no === selectedStudent);
                const isDisabled = !isSelected && selectedList.includes(student.enrollment_no);
                const disabledAttr = isDisabled ? 'disabled' : '';
                const selectedAttr = isSelected ? 'selected' : '';

                options += `<option value="${student.enrollment_no}" ${disabledAttr} ${selectedAttr}>
                                ${student.enrollment_no}
                            </option>`;
            });

            dropdown.html(options);
        },
        error: function () {
            alert('Error loading students');
            dropdown.html('<option value="">No students available</option>');
        }
    });
}



// Maintain subject-wise selections globally
let subjectWiseSelectedStudents = {};

// Update subject-wise student selections on change
$(document).on('change', '.student-dropdown', function () {
    const $dropdown = $(this);
    const seatBox = $dropdown.closest('.seat-box');
    const subjectId = seatBox.find('.subject-dropdown').val();
    const selectedStudent = $dropdown.val();

    // Rebuild subject-wise selections
    subjectWiseSelectedStudents = {};
    $('.seat-box').each(function () {
        const sid = $(this).find('.subject-dropdown').val();
        const stu = $(this).find('.student-dropdown').val();
        if (!subjectWiseSelectedStudents[sid]) subjectWiseSelectedStudents[sid] = [];
        if (stu) subjectWiseSelectedStudents[sid].push(stu);
    });

    // Refresh dropdowns for this subject
    $('.seat-box').each(function () {
        const $sb = $(this);
        const sbSubjectId = $sb.find('.subject-dropdown').val();
        if (sbSubjectId === subjectId) {
            const $studentDropdown = $sb.find('.student-dropdown');
            const currentVal = $studentDropdown.val();
            fetchStudentsForSubject(
                $('#exam').val(),
                $('#exam_date').val(),
                $('#session').val(),
                subjectId,
                $studentDropdown,
                currentVal
            );
        }
    });
});


	$('#saveSeatingArrangement').click(function (e) {
		e.preventDefault();

		var data = {
			exam_id: $('#exam').val(),
			exam_date: $('#exam_date').val(),
			session: $('#session').val(),
			building: $('#building').val(),
			floor: $('#floor').val(),
			hall: $('#hall').val(),
			seats: []
		};

        $('.seat-box').each(function () {
        let subject = $(this).find('.subject-dropdown').val() || "";
        let student = $(this).find('.student-dropdown').val() || "";
        let seat_no = $(this).data('seat-no') || "";       
        let selectedValue = $(this).val(); // e.g., "17741~266"

        let parts = subject.split('~');
        let subjectId = parts[0] || '';
        let streamId = parts[1] || '';

        data.seats.push({
            seat_no: seat_no.toString(),
            subject_id: subjectId,
            // stream_id: streamId,
            enrollment_no: student
        });
	});

   // console.log(JSON.stringify(data));

    $.ajax({
        url: '<?= base_url("SeatingReport/updateSeatingJson") ?>',
        method: 'POST',
        data: { seating_data: JSON.stringify(data) },
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                alert('Seating updated successfully!');
            } else {
                alert('Update failed!');
            }
        },
        error: function () {
            alert('Error updating data.');
        }
    });
});

$('#softDeleteSeating').click(function (e) {
    e.preventDefault();

    var examId = $('#exam').val();
    var examDate = $('#exam_date').val();
    var session = $('#session').val();
    var building = $('#building').val();
    var floor = $('#floor').val();
    var hall = $('#hall').val();

    if (!examId || !examDate || !session || !building || !floor || !hall) {
        alert("Please select all required fields to delete.");
        return;
    }

    if (!confirm("Are you sure you want to soft delete the seating arrangement for the selected criteria?")) {
        return;
    }

    $.ajax({
        url: '<?= base_url("SeatingReport/softDeleteSeating") ?>',
        method: 'POST',
        data: {
            exam_id: examId,
            exam_date: examDate,
            session: session,
            building: building,
            floor: floor,
            hall: hall
        },
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                alert('Seating arrangement soft deleted.');
                $('#seatingData').html('');
            } else {
                alert('Delete failed: ' + response.message);
            }
        },
        error: function () {
            alert('Error during delete request.');
        }
    });
});


</script>

