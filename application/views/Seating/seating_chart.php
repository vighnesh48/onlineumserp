<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
<style>
/* =========================
   THEME VARIABLES (4 PALETTES)
   Apply via <body data-theme="warm|futuristic|aesthetic|vibrant">
   ========================= */
:root {
  /* Fallbacks if no theme set */
  --bg-body-grad-start:#fff7f1; --bg-body-grad-end:#fef4e6 !important;
  --font-family:'Inter','Segoe UI',sans-serif;

  /* Container */
  --container-bg:#ffffff; --container-shadow:0 6px 30px rgba(255,170,90,0.25);
  --container-shadow-hover:0 8px 40px rgba(255,170,90,0.35);

  /* Text + borders */
  --text:#3e3e3e; --muted-border:#ffc57f; --muted-border-strong:#ffcc80;
  --muted-bg:#fffdf9;

  /* Primary accents */
  --primary:#ff7b00; --primary-2:#ffb84d; --primary-strong:#ff9f43;

  /* Header gradient */
  --header-grad-start:#ff8800; --header-grad-end:#ffb84d;

  /* Seat */
  --seat-bg-1:#fff8ee; --seat-bg-2:#ffe9ca; --seat-border:#ffb84d;
  --seat-shadow:2px 4px 10px rgba(255,165,60,0.3); --seat-hover-1:#ffecc3; --seat-hover-2:#fff6dc;
  --seat-tag-bg:#ff8c00; --seat-text:#4b2e05;

  /* Status chips (subject/hall lists) */
  --ok:#79ff9c99; --warn:#f4b04fa6; --neutral:#ffffff;

  /* Icon glow/bounce color */
  --icon:#ff9f43; --icon-hover:#ff6f00;

  /* Button gradient (Filter button) */
  --btn-grad-1:#1e3c72; --btn-grad-2:#2a5298;
  --btn-grad-hover-1:#2a5298; --btn-grad-hover-2:#1e3c72;

  /* Hall container background */
  --hall-bg-start:#fff9f3; --hall-bg-end:#fff3e0;
  --hall-card-border:#ffddaa; --hall-card-shadow:0 6px 18px rgba(255,170,90,0.3);
  --hall-card-shadow-hover:0 10px 25px rgba(255,170,90,0.45);
}

/* 🟠 Warm */
body[data-theme="warm"] {
  --bg-body-grad-start:#fff7f1; --bg-body-grad-end:#fef4e6;
  --container-shadow:0 6px 30px rgba(255,170,90,0.25);
  --container-shadow-hover:0 8px 40px rgba(255,170,90,0.35);
  --text:#3e3e3e; --muted-border:#ffc57f; --muted-border-strong:#ffcc80; --muted-bg:#fffdf9;
  --primary:#ff7b00; --primary-2:#ffb84d; --primary-strong:#ff9f43;
  --header-grad-start:#ff8800; --header-grad-end:#ffb84d;
  --seat-bg-1:#fff8ee; --seat-bg-2:#ffe9ca; --seat-border:#ffb84d;
  --seat-shadow:2px 4px 10px rgba(255,165,60,0.3); --seat-hover-1:#ffecc3; --seat-hover-2:#fff6dc;
  --seat-tag-bg:#ff8c00; --seat-text:#4b2e05;
  --ok:#79ff9c99; --warn:#f4b04fa6; --neutral:#ffffff;
  --icon:#ff9f43; --icon-hover:#ff6f00;
  --btn-grad-1:#1e3c72; --btn-grad-2:#2a5298; --btn-grad-hover-1:#2a5298; --btn-grad-hover-2:#1e3c72;
  --hall-bg-start:#fff9f3; --hall-bg-end:#fff3e0; --hall-card-border:#ffddaa;
  --hall-card-shadow:0 6px 18px rgba(255,170,90,0.3); --hall-card-shadow-hover:0 10px 25px rgba(255,170,90,0.45);
  --.form-control, select, .select2{border:1px solid var(--muted-border); border-radius:8px; transition:.3s ease; background:var(--muted-bg);}
}
 
/* 🟣 Futuristic (cyan/purple) */
body[data-theme="futuristic"] {
  --bg-body-grad-start:#0f1023; --bg-body-grad-end:#10152b;
  --container-bg:#121633; --container-shadow:0 6px 30px rgba(0,255,255,0.12);
  --container-shadow-hover:0 8px 40px rgba(0,255,255,0.2);
  --text:#e9ecff; --muted-border:#4853a6; --muted-border-strong:#5a67d8; --muted-bg:#161b3e;
  --primary:#00e5ff; --primary-2:#8a2be2; --primary-strong:#7df9ff;
  --header-grad-start:#00d0ff; --header-grad-end:#8a2be2;
  --seat-bg-1:#151a3b; --seat-bg-2:#1b214d; --seat-border:#3341a1;
  --seat-shadow:2px 4px 10px rgba(0, 229, 255, 0.18);
  --seat-hover-1:#192055; --seat-hover-2:#232c6b;
  --seat-tag-bg:#00c7ff; --seat-text:#eaf2ff;
  --ok:#2ea14ce8; --warn:#b78000ad; --neutral:#161b3e;
  --icon:#7df9ff; --icon-hover:#00e5ff;
  --btn-grad-1:#2a2f6b; --btn-grad-2:#1c7fb6; --btn-grad-hover-1:#1c7fb6; --btn-grad-hover-2:#2a2f6b;
  --hall-bg-start:#0f1126; --hall-bg-end:#0f1833; --hall-card-border:#2a368c;
  --hall-card-shadow:0 6px 18px rgba(0, 229, 255, 0.15);
  --hall-card-shadow-hover:0 10px 25px rgba(0, 229, 255, 0.25);
  --.form-control, select, .select2{border:1px solid var(--muted-border); border-radius:8px; transition:.3s ease; background:var(--muted-bg);color:white;}
}

/* 💗 Aesthetic (pastel pink/lavender) */
body[data-theme="aesthetic"] {
  --bg-body-grad-start:#fff1f7; --bg-body-grad-end:#f6f0ff;
  --container-bg:#ffffff; --container-shadow:0 6px 30px rgba(220,120,255,0.18);
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
  --hall-bg-start:#fff6fb; --hall-bg-end:#f6f2ff; --hall-card-border:#f0d8ff;
  --hall-card-shadow:0 6px 18px rgba(179,140,255,0.25);
  --hall-card-shadow-hover:0 10px 25px rgba(179,140,255,0.35);
  --.form-control, select, .select2{border:1px solid var(--muted-border); border-radius:8px; transition:.3s ease; background:var(--muted-bg);}
}

/* 🌈 Vibrant (multicolor gradient) */
body[data-theme="vibrant"] {
  --bg-body-grad-start:#fff7ff; --bg-body-grad-end:#e7fbff;
  --container-bg:#ffffff; --container-shadow:0 6px 30px rgba(255,99,132,0.18);
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
  --hall-bg-start:#fff4fb; --hall-bg-end:#edf9ff; --hall-card-border:#ffd6e5;
  --hall-card-shadow:0 6px 18px rgba(76,201,240,0.25);
  --hall-card-shadow-hover:0 10px 25px rgba(255,94,125,0.35);
  --.form-control, select, .select2{border:1px solid var(--muted-border); border-radius:8px; transition:.3s ease; background:var(--muted-bg);}
}

/* =========================
   BASE (uses variables only)
   ========================= */
body{
  background:linear-gradient(180deg,var(--bg-body-grad-start) 0%,var(--bg-body-grad-end) 100%);
  font-family:var(--font-family);
  margin-top:30px;
  color:var(--text);
}
.container{
  background:var(--container-bg);
  border-radius:16px;
  box-shadow:var(--container-shadow);
  padding:5rem;
  margin-top:30px;
  transition:all .3s ease;
}
.container:hover{ box-shadow:var(--container-shadow-hover); }

/* Title (gradient text kept) */
h1{
  background:linear-gradient(90deg,var(--primary-2), var(--primary));
  -webkit-background-clip:text; -webkit-text-fill-color:transparent;
  font-weight:800; text-align:center; letter-spacing:1px; margin-bottom:1rem;
  animation:fadeInTitle 1.5s ease-in-out; height:50px;
}
@keyframes fadeInTitle{ from{opacity:0;transform:translateY(-10px)} to{opacity:1;transform:translateY(0)} }

/* Labels + form controls */
label{ color:var(--text); font-weight:600; letter-spacing:.4px; display:flex; align-items:center; gap:6px; }

.form-control:focus, select:focus{ border-color:var(--primary-strong); box-shadow:0 0 10px color-mix(in srgb, var(--primary-strong) 30%, transparent); }

/* Buttons (Filter) */
.btn-primary{
  background:linear-gradient(90deg,var(--btn-grad-1),var(--btn-grad-2)); border:none; color:#fff; font-weight:600;
  padding:.7rem 1.8rem; border-radius:8px; box-shadow:0 4px 10px color-mix(in srgb, var(--primary) 30%, transparent);
  transition:all .3s ease;
}
.btn-primary:hover{
  background:linear-gradient(90deg,var(--btn-grad-hover-1),var(--btn-grad-hover-2));
  transform:translateY(-2px);
  box-shadow:0 6px 14px color-mix(in srgb, var(--primary) 40%, transparent);
}

/* Icons */
.icon-animated{ color:var(--icon); transition:transform .3s ease, color .3s ease; }
.icon-animated:hover{ transform:scale(1.3) rotate(-5deg); color:var(--icon-hover); }
.fa-chair,.fa-layer-group,.fa-user-graduate,.fa-calendar-days,.fa-book-open-reader,.fa-clock,.fa-building-columns,.fa-th-large{
  animation:chairBounce 2s infinite ease-in-out;
}
@keyframes chairBounce{ 0%,100%{transform:translateY(0)} 50%{transform:translateY(-6px)} }

/* Halls area */
.exam-hall-container{
  display:flex; flex-wrap:wrap; justify-content:space-around; gap:20px;
  background:linear-gradient(180deg,var(--hall-bg-start) 0%,var(--hall-bg-end) 100%);
  padding:20px; border-radius:12px;
}
.exam-hall{
  justify-content:center; background:var(--container-bg); border-radius:16px; overflow:hidden;
  border:1px solid var(--hall-card-border); box-shadow:var(--hall-card-shadow);
  transition:transform .2s ease-in-out, box-shadow .3s ease;
}
.exam-hall:hover{ transform:translateY(-5px); box-shadow:var(--hall-card-shadow-hover); }

.exam-hall-header{
  background:linear-gradient(90deg,var(--header-grad-start),var(--header-grad-end));
  color:#fff; padding:12px; font-size:18px; text-align:center; font-weight:bold; letter-spacing:.5px;
  animation:hallGradientMove 8s ease infinite; background-size:200% 200%;
}
@keyframes hallGradientMove{ 0%{background-position:0% 50%} 50%{background-position:100% 50%} 100%{background-position:0% 50%} }

.hall-matrix{ display:grid; grid-gap:12px; padding:20px; justify-content:center; align-content:center; text-align:center; }
.seat-row{ display:flex; justify-content:center; gap:15px; }

/* Seat */
.seat{
  width:200px; height:100px; display:flex; flex-direction:column; justify-content:center; align-items:center;
  border-radius:10px; position:relative; overflow:hidden; padding:5px;
  background:linear-gradient(145deg,var(--seat-bg-1),var(--seat-bg-2));
  border:2px solid var(--seat-border); box-shadow:var(--seat-shadow);
  color:var(--seat-text); font-weight:600; transition:all .3s ease-in-out;
}
.seat:hover{
  background:linear-gradient(145deg,var(--seat-hover-1),var(--seat-hover-2));
  transform:scale(1.03);
  box-shadow:3px 5px 14px color-mix(in srgb, var(--primary-2) 45%, transparent);
}

/* Dropdowns inside seat */
.seat select{
  width:100%; font-size:12px; height:25px; padding:2px; margin-top:4px; text-align:center;
  border-radius:4px; border:1px solid var(--muted-border-strong); background:var(--muted-bg); color:var(--text);
}
.seat select:focus{ border-color:var(--primary-strong); box-shadow:0 0 6px color-mix(in srgb, var(--primary-strong) 40%, transparent); }
.subject-dropdown,.student-dropdown{ background:var(--muted-bg); border:1px solid var(--muted-border-strong); border-radius:5px; }

/* Seat number tag */
.seat::before{
  content:attr(data-seat); position:absolute; top:-6px; left:50%; transform:translateX(-50%);
  background:var(--seat-tag-bg); color:#fff; font-size:12px; padding: 2px 70px; margin-top: 2px; border-radius:5px; font-weight:600;
  box-shadow:0 0 6px color-mix(in srgb, var(--seat-tag-bg) 40%, transparent);
}

.seat.empty{ background:#fafafa; border:2px dashed #ccc; color:#b9b9b9; }
.seat.selected{ background:linear-gradient(145deg, color-mix(in srgb, var(--primary-2) 35%, #fff), color-mix(in srgb, var(--primary) 20%, #fff)); border-color:var(--primary-2); }

/* Responsive */
@media (max-width:768px){
  .seat{ width:120px; height:85px; }
  .seat select{ font-size:10px; }
}

/* Select2 */
.select2-container--default .select2-selection--single,
.select2-container--default .select2-selection--multiple{
  border:1px solid var(--muted-border-strong); border-radius:.5rem; min-height:38px; background-color:var(--muted-bg);
}
.select2-container .select2-selection--single .select2-selection__rendered{ padding:6px 12px; color:var(--text); }
.select2-container .select2-selection--multiple .select2-selection__choice{
  background-color:var(--primary-strong); border:1px solid var(--primary); color:#fff;
}

/* Subject/hall status chips (your legend & lists) */
.bg-success{ background-color:var(--ok) !important;color:black; }
.bg-warning{ background-color:var(--warn) !important;color:black; }
.bg-white{ background-color:var(--neutral) !important;color: }

/* =========================
   FLOATING THEME SWITCHER
   ========================= */
.theme-fab{
  position:fixed; right:22px; bottom:22px; width:54px; height:54px; border-radius:50%;
  background:linear-gradient(135deg,var(--primary),var(--primary-2)); color:#fff; display:flex; align-items:center; justify-content:center;
  box-shadow:0 10px 25px color-mix(in srgb, var(--primary) 30%, transparent);
  cursor:pointer; z-index:9999; transition:transform .2s ease, box-shadow .3s ease;
}
.theme-fab:hover{ transform:translateY(-2px) scale(1.03); box-shadow:0 12px 30px color-mix(in srgb, var(--primary) 40%, transparent); }

.theme-palette{
  position:fixed; right:22px; bottom:86px; background:var(--container-bg); border:1px solid var(--muted-border-strong);
  box-shadow:var(--container-shadow-hover); border-radius:12px; padding:10px 12px; display:none; z-index:9999; min-width:210px;
}
.theme-row{ display:flex; gap:10px; align-items:center; justify-content:space-between; }
.theme-chip{
  flex:1; height:32px; border-radius:20px; cursor:pointer; position:relative; overflow:hidden; border:10px solid var(--muted-border);
  transition:transform .12s ease;
}
.theme-chip:hover{ transform:translateY(-1px); }
.theme-chip[data-theme="warm"]{ background:linear-gradient(90deg,#ff8800,#ffb84d); }
.theme-chip[data-theme="futuristic"]{ background:linear-gradient(90deg,#00d0ff,#8a2be2); }
.theme-chip[data-theme="aesthetic"]{ background:linear-gradient(90deg,#e56bbf,#b38cff); }
.theme-chip[data-theme="vibrant"]{ background:linear-gradient(90deg,#ff5e7d,#4cc9f0); }

.theme-label{ font-size:12px; color:var(--text); margin-top:8px; text-align:center; opacity:.8; }
.theme-group{ display:flex; flex-direction:column; align-items:center; gap:6px; flex:1; }
.theme-chip::after{ content:attr(data-theme); position:absolute; inset:0; color:#fff; font-weight:700; font-size:11px; display:flex; align-items:center; justify-content:center; mix-blend-mode:overlay; letter-spacing:.3px; }

/* show state */
.theme-palette.show{ display:block; animation:fadeSlide .18s ease-out; }
@keyframes fadeSlide{ from{opacity:0; transform:translateY(6px)} to{opacity:1; transform:translateY(0)} }
</style>

<script>
(function(){
  const THEMES = ["warm","futuristic","aesthetic","vibrant"];
  const STORAGE_KEY = "seating_theme";

  // Apply saved or default theme
  const saved = localStorage.getItem(STORAGE_KEY) || "warm";
  document.body.setAttribute("data-theme", saved);

  // Build floating button
  const fab = document.createElement("div");
  fab.className = "theme-fab";
  fab.title = "Switch theme";
  fab.innerHTML = '<i class="fa-solid fa-palette"></i>';
  document.body.appendChild(fab);

  // Build palette
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

  // Toggle palette
  fab.addEventListener("click", () => pal.classList.toggle("show"));

  // Click outside to close
  document.addEventListener("click", (e)=>{
    if(!pal.contains(e.target) && !fab.contains(e.target)) pal.classList.remove("show");
  });

  // Theme selection
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

    <script>

        
        var selectedSubjects = <?= json_encode($selected_subjects) ?>;
        // alert(isChecked);
        var selected_floor = "<?= isset($selected_floor_id) ? $selected_floor_id : '' ?>";
        var selected_halls = "<?= isset($selected_hall_id) ? $selected_hall_id : '' ?>";
        $(document).ready(function () {
            // Define the selectedSubjects array globally if not already done
            var selectedSubjects = <?= json_encode($selected_subjects) ?>;  // Ensure this is outputting a valid JavaScript array

            function fetchAndCheckSubjects() {
                if ($('#exam').val() && $('#date').val() && $('#session').val()) {
                    $.ajax({
                        url: '<?= base_url("Seating/get_subjects") ?>',
                        type: 'POST',
                        data: {
                            exam_id: $('#exam').val(),
                            date: $('#date').val(),
                            session: $('#session').val()
                        },
                        dataType: 'json',
                        success: function (data) {
                            let subjectOptions = '';

                            data.subjects.forEach(function (subject) {
                                // Determine the color class based on remaining_students
                                let colorClass = "bg-white"; // Default white
                                let isDisabled = ""; // Default enabled
                                let style = "";

                                if (subject.remaining_students == 0) {
                                    colorClass = "bg-success"; // Green for allocated
                                    isDisabled = "disabled"; // Disable the checkbox
                                    style = 'style="color: black !important;"';
                                } else if (subject.remaining_students > 0 && subject.remaining_students < subject.stud_count) {
                                    colorClass = "bg-warning"; // Yellow for partially assigned
                                }

                                // Check if the subject is selected
                                let isChecked = selectedSubjects.includes(`${subject.sub_id}~${subject.stream_id}`) ? 'checked' : '';

                                // Add the subject with conditional coloring and disabled checkbox if required
                                subjectOptions += `<li class="subject-item ${colorClass}" style="padding: 10px; border-radius: 5px; margin-bottom: 5px;">
                                    <label ${style}>
                                        <input type="checkbox" name="subject_ids[]" value="${subject.sub_id}~${subject.stream_id}" class="subject-checkbox" ${isChecked} ${isDisabled}>
                                        ${subject.subject_code} - ${subject.subject_name} 
                                        (Batch: ${subject.batch}, Sem: ${subject.semester}, 
                                        Student count: ${subject.stud_count}, 
                                        Remaining count: ${subject.remaining_students}) 
                                        ${subject.stream_short_name}
                                    </label>
                                </li>`;

                            });


                            if (subjectOptions === '') {
                                subjectOptions = '<li>No subjects available</li>';
                            }

                            $('#subjectList').html(subjectOptions);
                        },
                        error: function () {
                            alert('Error loading subjects');
                            $('#subjectList').html('<li>No subjects available</li>');
                        }
                    });
                }
            }

            // Bind the change event to fetch subjects
            $('#exam, #date, #session').change(fetchAndCheckSubjects);

            // Trigger the fetch operation on page load if both exam and date have pre-set values
            if ($('#exam').val() && $('#date').val() && $('#session').val()) {
                fetchAndCheckSubjects(); // Trigger this function on page load to handle pre-selected values
            }

            var buildingSelect = $('#building');
            var floorSelect = $('#floor');
            var hallSelect = $('#hall');

            // When a building is selected, fetch floors for that building
            buildingSelect.change(function () {
                var buildingId = $(this).val(); // Store building ID
                $.ajax({
                    url: '<?= base_url("Seating/get_floors") ?>', // Assuming you have a route setup
                    type: 'GET',
                    data: { building_id: buildingId },
                    dataType: 'json',
                    success: function (data) {
                        let floorOptions = '<option value="">Select a floor</option>';
                        data.floors.forEach(function (floor) {
                            floorOptions += `<option value="${floor.floor}" ${floor.floor == selected_floor ? 'selected' : ''}>${floor.floor}</option>`;
                        });
                        floorSelect.html(floorOptions);
                        floorSelect.trigger('change'); // May need to trigger change to load halls
                    },
                    error: function () {
                        alert('Error loading floors');
                        floorSelect.html('<option value="">No floors available</option>');
                    }
                });
            });



            var selected_halls = "<?= isset($selected_halls) ? $selected_halls : '' ?>";

            //    alert(selected_halls);

            var buildingSelect = $('#building');
            var floorSelect = $('#floor');
            var hallList = $('#hallList'); // This is your list element for halls
            var examSelect = $('#exam');
            var dateSelect = $('#date');
            var sessionSelect = $('#session');

            // Function to fetch and render halls
            function fetchAndRenderHalls() {
                var floorId = floorSelect.val();
                var buildingId = buildingSelect.val();
                var examId = examSelect.val();
                var date = dateSelect.val();
                var session = sessionSelect.val();
                if (floorId && buildingId) {
                    $.ajax({
                        url: '<?= base_url("Seating/get_halls") ?>',
                        type: 'GET',
                        data: {
                            floor_id: floorId,
                            building_id: buildingId,
                            exam_id: examId,
                            exam_date: date,
                            session: session
                        },
                        dataType: 'json',
                        success: function (data) {
                            let hallOptions = '';
                            data.halls.forEach(function (hall) {
                                let isChecked = selected_halls.includes(hall.id.toString()) ? 'checked' : '';

                                // Determine row color based on 'used' value
                                let rowColorClass = hall.used == 1 ? 'bg-success' : 'bg-white';

                                let style = hall.used == 1 ? 'style="color: black;"' : '';
                                // Disable checkbox for used halls
                                let isDisabled = hall.used == 1 ? 'disabled' : '';

                                hallOptions += `<li class="hall-item ${rowColorClass}" style="padding: 10px; border-radius: 5px; margin-bottom: 5px;">
                                    <label ${style}>
                                        <input type="checkbox" name="hall_ids[]" value="${hall.id}" class="hall-checkbox" data-rows="${hall.matrix_rows}" ${isChecked} ${isDisabled}>
                                        ${hall.hall_no} - Total Seats : ${hall.capacity}
                                    </label>
                                </li>`;
                            });

                            hallList.html(hallOptions);
                        },
                        error: function () {
                            alert('Error loading halls');
                            hallList.html('<li>No halls available</li>');
                        }
                    });
                }
            }

            // Bind change event to building and floor selectors
            buildingSelect.change(fetchAndRenderHalls);
            floorSelect.change(fetchAndRenderHalls);
            sessionSelect.change(fetchAndRenderHalls);

            // Initial fetch if values are pre-selected
            if (buildingSelect.val() && floorSelect.val() && sessionSelect.val()) {
                fetchAndRenderHalls();
            }

            // Add submit button click handler
            $("form").submit(function (event) {
                event.preventDefault(); // Prevent form submission

                let isInvalid = false;

                // Count the number of selected subjects
                var selectedSubjectsCount = $("#subjectList input:checked").length;

                // Loop through each selected hall to check rows against subject count
                $("#hallList input:checked").each(function () {
                    var hallRows = parseInt($(this).data("rows")) || 0;

                    // If any hall rows match the selected subjects count, set `isInvalid` to true
                    if (hallRows === selectedSubjectsCount) {
                        isInvalid = true;
                        return false; // Break out of the loop
                    }
                });

                // Show alert and stop submission if the condition is met
                if (isInvalid) {
                    alert(
                        "The number of selected subjects should not match the rows of any single hall. Please adjust your selection."
                    );
                    return false; // Stop form submission
                }

                // If validation passes, allow form submission
                this.submit();
            });

            let selectedStudents = {}; // Track selected students per subject

            function fetchStudentsForSubject(exam_id, date, session, subjectId, dropdown, selectedStudent) {
                if (!subjectId) {
                    dropdown.html('<option value="">No students available</option>');
                    return;
                }

                $.ajax({
                    url: '<?= base_url("Seating/get_students_by_subject") ?>',
                    type: 'POST',
                    data: {
                        subject_id: subjectId,
                        exam_id: exam_id,
                        date: date,
                        session: session
                    },
                    dataType: 'json',
                    success: function (data) {
                        let studentOptions = '<option value="">Select a student</option>';
                        let selectedSet = new Set();

                        // Add all selected students from different dropdowns
                        Object.values(selectedStudents).forEach(arr => arr.forEach(student => selectedSet.add(student)));

                        data.students.forEach(function (student) {
                            let isSelected = student.enrollment_no === selectedStudent;

                            // Keep the selected student in its dropdown while removing it from others
                            if (isSelected || !selectedSet.has(student.enrollment_no)) {
                                studentOptions += `<option value="${student.enrollment_no}" 
                            ${isSelected ? 'selected' : ''}>
                            ${student.enrollment_no}
                        </option>`;
                            }
                        });

                        dropdown.html(studentOptions);
                        if (selectedStudent) dropdown.val(selectedStudent);
                    },
                    error: function () {
                        alert('Error loading students');
                        dropdown.html('<option value="">No students available</option>');
                    }
                });
            }

            // **Handle subject selection**
            $(document).on('change', '.subject-dropdown', function () {
                var subjectDropdown = $(this);
                var studentDropdown = subjectDropdown.closest('.seat').find('.student-dropdown');
                var subjectId = subjectDropdown.val();
                var exam_id = $('#exam').val();
                var date = $('#date').val();
                var session = $('#session').val();

                fetchStudentsForSubject(exam_id, date, session, subjectId, studentDropdown, studentDropdown.val());
            });

            // **Handle student selection & prevent duplicates**
            $(document).on('change', '.student-dropdown', function () {
                var studentDropdown = $(this);
                var subjectDropdown = studentDropdown.closest('.seat').find('.subject-dropdown');
                var subjectId = subjectDropdown.val();
                var selectedStudent = studentDropdown.val();

                if (subjectId) {
                    if (!selectedStudents[subjectId]) selectedStudents[subjectId] = [];

                    // Remove student from other dropdowns but keep it in its original seat
                    Object.keys(selectedStudents).forEach(key => {
                        selectedStudents[key] = selectedStudents[key].filter(student => student !== selectedStudent);
                    });

                    if (selectedStudent) selectedStudents[subjectId].push(selectedStudent);
                }

                // Refresh all dropdowns for the same subject
                $('.subject-dropdown').each(function () {
                    var otherSubjectId = $(this).val();
                    var otherStudentDropdown = $(this).closest('.seat').find('.student-dropdown');

                    if (otherSubjectId === subjectId) {
                        fetchStudentsForSubject($('#exam').val(), $('#date').val(), $('#session').val(), subjectId, otherStudentDropdown, otherStudentDropdown.val());
                    }
                });
            });

            // **Initialize dropdowns for preselected values**
            $('.seat').each(function () {
                var subjectDropdown = $(this).find('.subject-dropdown');
                var studentDropdown = $(this).find('.student-dropdown');

                var subjectId = subjectDropdown.val();
                var existingStudent = studentDropdown.data('selected');

                if (subjectId) {
                    fetchStudentsForSubject($('#exam').val(), $('#date').val(), $('#session').val(), subjectId, studentDropdown, existingStudent);
                }
            });
        });
// Utility function to debounce AJAX calls
function debounce(func, wait) {
    let timeout;
    return function (...args) {
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(this, args), wait);
    };
}



    </script>

    <div class="container">
        <h1 class="mb-6">Exam Seating Arrangement</h1>
			<form action="<?= base_url('seating/index'); ?>" method="POST">
				<div class="form-group">
					<label for="exam"><i class="fa-solid fa-user-graduate icon-animated"></i> Select Exam:</label>
					<select id="exam" name="exam_id" class="form-control select2">
						<?php foreach ($exams as $exam): ?>
							<option value="<?= $exam['exam_id'] ?>" <?= ($exam['exam_id'] == $selected_exam) ? 'selected' : '' ?>><?= $exam['exam_name'] ?></option>
						<?php endforeach; ?>
					</select>
				</div>

				<div class="form-group">
					<label for="date"><i class="fa-solid fa-calendar-days icon-animated"></i> Select Date:</label>
					<input type="date" id="date" name="date" class="form-control" value="<?= $selected_date ?>">
				</div>

				<div class="form-group">
					<label for="session"><i class="fa-solid fa-clock icon-animated"></i> Select Exam Session:</label>
					<select id="session" name="session" class="form-control select2">
						<option value="" <?= empty($selected_sesion) ? 'selected' : '' ?>>Select Session</option>
						<option value="AN" <?= (trim($selected_session) == 'AN') ? 'selected' : '' ?>>AN</option>
						<option value="FN" <?= (trim($selected_session) == 'FN') ? 'selected' : '' ?>>FN</option>
					</select>
				</div>

				<div class="form-group">
					<label for="subject"><i class="fa-solid fa-book-open-reader icon-animated"></i> Select Subjects:</label>
					<span style="margin-left: 10px;">
						<span style="display:inline-block;width:12px;height:12px;background-color:green;border:1px solid #000;margin-right:5px;"></span> Seating completed,
						<span style="display:inline-block;width:12px;height:12px;background-color:#f4b04f;border:1px solid #000;margin:0 5px 0 15px;"></span> Seating Partially completed,
						<span style="display:inline-block;width:12px;height:12px;background-color:white;border:1px solid #000;margin:0 5px 0 15px;"></span> Seating Incomplete
					</span>
					<input type="text" id="searchSubject" placeholder="Search subjects..." class="form-control mb-2">
					<ul id="subjectList" style="height:150px;overflow-y:scroll;list-style-type:none;padding:0;"></ul>
				</div>

				<div class="form-group">
					<label for="building"><i class="fa-solid fa-building-columns icon-animated"></i> Select Building:</label>
					<select id="building" name="building_id" class="form-control select2">
						<option value="">Select Building</option>
						<?php foreach ($buildings as $building): ?>
							<option value="<?= $building['id'] ?>" <?= ($building['id'] == $selected_building) ? 'selected' : '' ?>><?= $building['building_name'] ?></option>
						<?php endforeach; ?>
					</select>
				</div>

				<div class="form-group">
					<label for="floor"><i class="fa-solid fa-layer-group icon-animated"></i> Select Floor:</label>
					<select id="floor" name="floor_id" class="form-control select2">
						<?php foreach ($floors as $floor): ?>
							<option value="<?= $floor['floor'] ?>" <?= ($floor['floor'] == $selected_floor) ? 'selected' : '' ?>><?= $floor['floor'] ?></option>
						<?php endforeach; ?>
					</select>
				</div>

				<div class="form-group">
					<label for="hall"><i class="fa-solid fa-chair icon-animated"></i> Select Halls (no selection limit):</label>
					<ul id="hallList" style="height:150px;overflow-y:scroll;list-style-type:none;padding:0;"></ul>
				</div>

				<div class="form-group">
					<label for="seating_type"><i class="fa-solid fa-th-large icon-animated"></i> Select Seating Arrangement Type:</label>
					<select id="seating_type" name="seating_type" class="form-control select2" required>
						<option value="" <?= empty($selected_seating_type) ? 'selected' : '' ?>>Select type</option>
						<option value="alternet" <?= (trim($selected_seating_type) == 'alternet') ? 'selected' : '' ?>>Alternet</option>
						<option value="normal" <?= (trim($selected_seating_type) == 'normal') ? 'selected' : '' ?>>Normal</option>
					</select>
				</div>

				<button type="submit" class="btn btn-primary"><i class="fa-solid fa-filter icon-animated"></i> Filter</button>
			</form>
    </div>
        <form id="seatingForm" action="<?= base_url('Seating/index'); ?>" method="POST">
            <input type="hidden" name="exam_id" value="<?= $selected_exam ?>">
            <input type="hidden" name="exam_date" value="<?= $selected_date ?>">
            <input type="hidden" name="session" value="<?= $selected_session ?>">
            <input type="hidden" name="building_id" value="<?= $selected_building ?>">
            <input type="hidden" name="floor_id" value="<?= $selected_floor ?>">
            <input type="hidden" name="seating_type" value="<?= $selected_seating_type ?>">
            <div class="exam-hall-container">
                <?php // echo"<pre>";print_r($seatingArrangement); exit; ?>

                <?php foreach ($seatingArrangement as $floor => $halls): ?>
                    <?php foreach ($halls as $hall_no => $info): ?>
                        <div class="exam-hall">
                            <div class="exam-hall-header">
                                Hall: <?= $hall_no ?> - Floor: <?= $floor ?>
                            </div>
                            <div style="grid-template-columns: repeat(<?= $info['rows'] ?>, 1fr);" class="hall-matrix">

                                <?php if ($selected_seating_type == "normal") { ?>
                                    <?php
                                    $seat_index = 1;
                                    $total_seats = ($info['rows'] * $info['columns']) + $info['extra'];
                                    $students = $info['seats']; // Assuming $info['seats'] contains all students for the hall
                        
                                    // Fill seats based on total_seats
                                    for ($seat_no = 0; $seat_no < $total_seats; $seat_no++) {
                                        $seat = isset($students[$seat_no]) ? $students[$seat_no] : null; // Fetch student or null for empty seat
                                        ?>
                                        <div class="seat" data-seat="<?= $seat_index ?>">
                                            <input type="hidden" name="seat[]" value="<?= $seat_index ?>">
                                            <?php if (!empty($seat)) { ?>
                                                <!-- Pre-allocated Student -->
                                                <label
                                                    style="font-size: 14px; padding-top: 25px; color:black;"><?= htmlspecialchars($seat['enrollment_no']) ?></label>
                                                <input type="hidden" name="student[]"
                                                    value="<?= htmlspecialchars($seat['enrollment_no'], ENT_QUOTES, 'UTF-8') ?>">
                                                <label
                                                    style="font-size: 12px; padding-top: 1px; color:black;"><?= htmlspecialchars($seat['subject_name']) ?></label>
                                                <input type="hidden" name="subject[]"
                                                    value="<?= $seat['subject_id'] . '~' . $seat['stream_id']  ?>">
                                            <?php } else { ?>
                                                <!-- Empty Seat with Dropdowns -->
                                                <select name="subject[]" class="subject-dropdown subject-<?= $seat_index ?>"
                                                    data-seat-index="<?= $seat_index ?>">
                                                    <option value="">Select Subject</option>
                                                    <?php foreach ($subjects as $subject): ?>
                                                        <option value="<?= htmlspecialchars($subject['sub_id'], ENT_QUOTES, 'UTF-8') ?>">
                                                            <?= htmlspecialchars($subject['subject_name'], ENT_QUOTES, 'UTF-8') ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>

                                                <select name="student[]" class="student-dropdown student-<?= $seat_index ?>"
                                                    data-seat-index="<?= $seat_index ?>" data-selected="">
                                                    <option value="">Select Student</option>
                                                </select>
                                            <?php } ?>
                                        </div>
                                        <?php
                                        $seat_index++;
                                    }
                                    ?>
                                <?php } else { ?>

                                    <?php
                                    $total_seats = ($info['rows'] * $info['columns']) + $info['extra'];
                                    $seat_index = 0;

                                    // Group students by subject_id for the current hall
                                    $grouped_students = [];
                                    foreach ($info['seats'] as $student) {
                                        if (!empty($student)) {
                                            $grouped_students[$student['subject_id'] . '~' . $student['stream_id']][] = $student;
                                        }
                                    }

                                    // Sort subjects by student count (most frequent first)
                                    uasort($grouped_students, function ($a, $b) {
                                        return count($b) - count($a);
                                    });

                                    $subject_ids = array_keys($grouped_students);
                                    //   print_r($subject_ids);exit;
                                    $subject_count = count($subject_ids);

                                    // Prevent division by zero
                                    if ($subject_count == 0) {
                                        echo "<p class='text-danger'>No subjects available for Hall $hall_no.</p>";
                                        continue;
                                    }

                                    $assigned_seats = [];
                                    if ($subject_count == 1) {
                                        // One subject: Alternate with spaces
                                        $subject_id = $subject_ids[0];
                                        for ($row = 0; $row < $info['columns']; $row++) {
                                            for ($col = 0; $col < $info['rows']; $col++) {
                                                if (($row + $col) % 2 == 0 && !empty($grouped_students[$subject_id])) {
                                                    $assigned_seats[] = array_shift($grouped_students[$subject_id]);
                                                } else {
                                                    $assigned_seats[] = null; // Space
                                                }
                                            }
                                        }
                                    } elseif ($subject_count == 2) {
                                        // Two subjects: Alternate between A and B diagonally
                                        $subject_rotation = $subject_ids; // Use subjects A and B
                                        $subject_index = 0;
                                        for ($row = 0; $row < $info['columns']; $row++) {
                                            for ($col = 0; $col < $info['rows']; $col++) {
                                                $current_subject_id = $subject_rotation[($row + $col) % 2];
                                                if (!empty($grouped_students[$current_subject_id])) {
                                                    $assigned_seats[] = array_shift($grouped_students[$current_subject_id]);
                                                } else {
                                                    $assigned_seats[] = null; // Space if no students available
                                                }
                                            }
                                        }
                                    } else {
                                        // More than two subjects: Diagonal seating
                                        $subject_keys = array_keys($grouped_students);
                                        $subject_index = 0;
                                        for ($row = 0; $row < $info['columns']; $row++) {
                                            for ($col = 0; $col < $info['rows']; $col++) {
                                                $current_subject_id = $subject_keys[$subject_index % $subject_count];
                                                if (!empty($grouped_students[$current_subject_id])) {
                                                    $assigned_seats[] = array_shift($grouped_students[$current_subject_id]);
                                                } else {
                                                    $assigned_seats[] = null; // Empty seat if no student available
                                                }
                                                $subject_index++;
                                            }
                                        }
                                    }
                                    // **Ensure extra seats are included**
                                    $extra_seats_needed = $info['extra'];
                                    for ($i = 0; $i < $extra_seats_needed; $i++) {
                                        $assigned_seats[] = null; // Add empty placeholders for extra seats
                                    }
                                    $seat_index = 1;
                                    // **Render the seating arrangement with dropdowns and input fields**
                                    foreach ($assigned_seats as $seat): ?>
                                        <div class="seat" data-seat="<?= $seat_index ?>">
                                            <input type="hidden" name="seat[]" value="<?= $seat_index ?>">
                                            <?php if (!empty($seat)) { ?>
                                                <label
                                                    style="font-size: 14px;padding-top:25px;"><?= htmlspecialchars($seat['enrollment_no']) ?></label>
                                                <input type="hidden" name="student[]"
                                                    value="<?= htmlspecialchars($seat['enrollment_no'], ENT_QUOTES, 'UTF-8') ?>">
                                                <label
                                                    style="font-size: 12px;padding-top:1px;"><?= htmlspecialchars($seat['subject_name']) ?></label>
                                                    <input type="hidden" name="subject[]" value="<?= $seat['subject_id'] . '~' . $seat['stream_id'] ?>">
                                            
                                            <?php } else { ?>
                                                <!-- Subject Dropdown -->
                                                <select name="subject[]" class="subject-dropdown subject-<?= $seat_index ?>" data-seat-index="<?= $seat_index ?>">
                                                    <option value="">Select Subject</option>
                                                    <?php foreach ($subjects as $subject): ?>
                                                        <?php
                                                        // Determine the color class and disabled state
                                                        $colorClass = "bg-white"; // Default white
                                                        $isDisabled = ""; // Default enabled
                                                        $isSelected = ($seat && $seat['subject_id'] == $subject['sub_id']) ? 'selected' : '';

                                                        if ($subject['remaining_students'] == 0) {
                                                            $colorClass = "bg-success text-white"; // Green for fully allocated
                                                            $isDisabled = "disabled"; // Disable the dropdown option
                                                        } elseif ($subject['remaining_students'] > 0 && $subject['remaining_students'] < $subject['stud_count']) {
                                                            $colorClass = "bg-warning"; // Yellow for partially assigned
                                                        }
                                                        ?>
                                                        <option value="<?= htmlspecialchars($subject['sub_id'] . '~' . $subject['stream_id'], ENT_QUOTES, 'UTF-8') ?>" 
                                                            class="text-left <?= $colorClass ?>" <?= $isSelected ?> <?= $isDisabled ?>>

                                                            <?= htmlspecialchars($subject['subject_name'], ENT_QUOTES, 'UTF-8') ?>
                                                            <?= htmlspecialchars($subject['subject_code'], ENT_QUOTES, 'UTF-8') ?> - 
                                                            <?= htmlspecialchars($subject['subject_name'], ENT_QUOTES, 'UTF-8') ?> 
                                                            (Batch: <?= htmlspecialchars($subject['batch'], ENT_QUOTES, 'UTF-8') ?>, 
                                                            Sem: <?= htmlspecialchars($subject['semester'], ENT_QUOTES, 'UTF-8') ?>, 
                                                            Stream: <?= htmlspecialchars($subject['stream_short_name'], ENT_QUOTES, 'UTF-8') ?>, 
                                                            Remaining: <?= $subject['remaining_students'] ?> / Total: <?= $subject['stud_count'] ?>)
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>


                                                <!-- Student Dropdown -->
                                                <select name="student[]" class="student-dropdown student-<?= $seat_index ?>"
                                                    data-seat-index="<?= $seat_index ?>"
                                                    data-selected="<?= htmlspecialchars($seat['enrollment_no'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                                                    <option value="">Select Student</option>
                                                    <?php
                                                        $subject_stream_key = $seat ? $seat['subject_id'] . '~' . $seat['stream_id'] : '';
                                                        if ($seat && isset($students[$subject_stream_key])):
                                                            foreach ($students[$subject_stream_key] as $student):
                                                    ?>
                                                        <option value="<?= htmlspecialchars($student['enrollment_no'], ENT_QUOTES, 'UTF-8') ?>"
                                                            <?= ($seat['enrollment_no'] === $student['enrollment_no']) ? 'selected' : '' ?>>
                                                            <?= htmlspecialchars($student['enrollment_no'], ENT_QUOTES, 'UTF-8') ?>
                                                        </option>
                                                    <?php
                                                            endforeach;
                                                        endif;
                                                    ?>
                                                </select>
                                            <?php } ?>
                                            <?php $seat_index++; ?>
                                        </div>
                                    <?php endforeach;

                                } ?>

                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </div>
            <button type="submit" class="btn btn-success mt-3">Save Seating Arrangement</button>
        </form>



<script>
$(document).ready(function () {
    $("#seatingForm").submit(function (event) {
        event.preventDefault(); // Prevent default form submission

        let seatingData = [];

        $(".exam-hall").each(function () {
            let hall = $(this).find(".exam-hall-header").text().trim().split(": ")[1].split(" -")[0];
            let hallEntry = {
                exam_id: $("input[name='exam_id']").val(),
                exam_date: $("input[name='exam_date']").val(),
                session: $("select[name='session']").val(),
                building: $("select[name='building_id']").val(),
                floor: $("select[name='floor_id']").val(),
                hall: hall,
                seating_arrangement: []
            };

            $(this).find(".seat").each(function () {
                let subjectInput = $(this).find("input[name='subject[]']");
                let studentInput = $(this).find("input[name='student[]']");
                let seatIndex = $(this).find("input[name='seat[]']").val();
                let subject = null, student = null, stream_id = null;

                // If seat is preassigned, use hidden input values
                if (subjectInput.length && studentInput.length) {
                    subject = subjectInput.val();
                    student = studentInput.val();

                    // Extract stream_id from the pre-filled hidden subject value (if stored like sub_id~stream_id)
                    if (subject.includes("~")) {
                        stream_id = subject.split("~")[1];
                        subject = subject.split("~")[0];
                    }
                } else {
                    subject = $(this).find(".subject-dropdown").val();
                    student = $(this).find(".student-dropdown").val();

                    if (subject && subject.includes("~")) {
                        stream_id = subject.split("~")[1];
                        subject = subject.split("~")[0];
                    }
                }


                // Add the seat to the arrangement, including empty seats
                if (seatIndex) {
                    hallEntry.seating_arrangement.push({
                        seat_no: seatIndex,
                        subject_id: subject || null,
                        stream_id: stream_id || null,
                        enrollment_no: student || null
                    });
                }
            });

            if (hallEntry.seating_arrangement.length > 0) {
                seatingData.push(hallEntry);
            }
        });

        console.log(seatingData); // Debug: Check JSON structure in console

        // Send JSON data to backend
        $.ajax({
            url: "<?= base_url('Seating/saveSeatingArrangement') ?>",
            type: "POST",
            data: JSON.stringify({ seating_data: seatingData }), // Proper JSON structure
            contentType: "application/json", // Ensure JSON format
            processData: false,
            success: function (response) {
                let res = JSON.parse(response);

                alert(res.message); // Show message in an alert box

                // Refresh the page after 3 seconds
                setTimeout(() => {
                    location.reload();
                }, 3000);
            },
            error: function () {
                alert("Error saving seating arrangement.");
                setTimeout(() => {
                    location.reload();
                }, 3000);
            }
        });
    });
});


</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var searchBox = document.getElementById('searchSubject');
        searchBox.addEventListener('input', function () {
            var searchText = this.value.toLowerCase();
            var items = document.querySelectorAll('#subjectList .subject-item');
            items.forEach(item => {
                var text = item.textContent.toLowerCase();
                item.style.display = text.includes(searchText) ? "" : "none";
            });
        });
    });
    document.addEventListener("DOMContentLoaded", function () {
        var checkboxes = document.querySelectorAll('#subjectList .subject-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function () {
                var checkedCheckboxes = document.querySelectorAll('#subjectList .subject-checkbox:checked');
                if (checkedCheckboxes.length > 3) {
                    alert('You can only select up to 3 subjects.');
                    checkbox.checked = false;
                }
            });
        });
    });
</script>