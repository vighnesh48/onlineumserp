<!----------------- COMBINED LISTING VIEW (PREMIUM UI) ----------------->

<style>
body {
    background: linear-gradient(135deg, #eaf3ff, #ffffff);
}

/* ---------------- TAB BUTTONS ---------------- */
.section-tabs {
    margin-bottom: 25px;
    text-align: center;
}
.section-tabs button {
    background: rgba(255,255,255,0.55);
    border: 1px solid #c6daff;
    padding: 12px 32px;
    margin: 5px;
    border-radius: 30px;
    font-weight: 700;
    font-size: 15px;
    letter-spacing: .3px;
    color: #004aad;
    transition: 0.35s;
    backdrop-filter: blur(12px);
}
.section-tabs button.active {
    background: #004aad !important;
    color: white !important;
    transform: scale(1.06);
    box-shadow: 0 6px 15px rgba(0,0,0,0.25);
}

/* TAB CONTENT ANIMATION */
.tab-section {
    animation: fade .45s ease-in;
}
@keyframes fade {
    from { opacity:0; transform:translateY(15px); }
    to { opacity:1; transform:translateY(0px); }
}

/* ---------------- PREMIUM CARD DESIGN ---------------- */
.panel-card {
    padding: 26px;
    border-radius: 25px;
    margin-bottom: 22px;
    background: linear-gradient(145deg, rgba(255,255,255,.95), rgba(240,247,255,.92));
    backdrop-filter: blur(12px);
    transition: 0.35s;
    box-shadow: 0 8px 18px rgba(0,0,0,0.18);
    position: relative;
    overflow: hidden;
    border: 1px solid rgba(255,255,255,0.4);
}
.panel-card:hover {
    transform: translateY(-6px) scale(1.01);
    box-shadow: 0 15px 30px rgba(0,0,0,0.25);
}

/* LEFT ACCENT STRIPS */
.panel-card:before {
    content: '';
    position: absolute;
    top:0; left:0;
    height: 100%;
    width: 7px;
}
.ann-card:before { background: linear-gradient(#0078d7, #74c2ff); }
.rem-card:before { background: linear-gradient(#ff9800, #ffd393); }
.blog-card:before { background: linear-gradient(#4caf50, #a7e1b4); }
.flash-card:before { background: linear-gradient(#7600ff, #d9b8ff); }

/* ICON BUBBLE */
.card-icon {
    width: 55px;
    height: 55px;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:24px;
    font-weight:800;
    color:#fff;
    float:right;
    margin-bottom: 6px;
}
.icon-ann { background:#0078d7; }
.icon-rem { background:#ff9800; }
.icon-blog { background:#4caf50; }
.icon-flash { background:#7600ff; }

/* TITLE */
.card-title {
    font-size: 22px;
    font-weight: 900;
    color: #002b5c;
    margin-bottom: 8px;
    letter-spacing: .4px;
}

/* DATE BOX */
.card-date {
    font-size: 14px;
    padding: 4px 14px;
    border-radius:18px;
    font-weight:600;
    background: #eef6ff;
    display:inline-block;
    margin-bottom:14px;
    color:#003a78;
}

/* DESCRIPTION */
.card-desc {
    font-size: 15px;
    color: #222;
    line-height: 22px;
    margin: 12px 0 15px;
    padding-left: 14px;
    border-left: 3px solid #cbe2ff;
}

/* BUTTONS */
.card-actions .btn {
    border-radius: 25px !important;
    padding: 7px 18px !important;
    font-size: 13px;
    font-weight:700;
}

/* SECTION TITLE */
.section-title-header {
    font-size: 28px;
    font-weight: 900;
    margin-bottom: 22px;
    color: #004aad;
    text-align:center;
    text-transform:uppercase;
    letter-spacing: .8px;
}
</style>

<div id="content-wrapper">

<!------------ TAB SELECTOR BUTTONS ------------>
<div class="section-tabs">
    <button class="tabBtn active" data-target="ann">📢 Announcements</button>
    <button class="tabBtn" data-target="rem">⏰ Reminders</button>
    <button class="tabBtn" data-target="blog">📝 Blogs</button>
    <button class="tabBtn" data-target="flash">⚡ Flash Messages</button>
</div>

<!------------ ANNOUNCEMENTS SECTION ------------>
<div id="ann" class="tab-section">
    <div class="section-title-header">Latest Announcements</div>

    <?php if(empty($announcements)) { ?>
        <div class="panel-card ann-card text-center">No announcements available</div>
    <?php } ?>

    <?php foreach($announcements as $row){ ?>
    <div class="panel-card ann-card">
        <div class="card-icon icon-ann">📢</div>
        <div class="card-title"><?= $row['title']; ?></div>
        <span class="card-date"><?= $row['announcement_date']; ?></span>

        <div class="card-desc"><?= substr(strip_tags($row['description']),0,160)."..." ?></div>

        <div class="card-actions">
            <?= ($row['announcement_url']) ? '<a href="'.$row['announcement_url'].'" class="btn btn-info btn-sm" target="_blank">View More</a>' : '' ?>
        </div>
    </div>
    <?php } ?>
</div>

<!------------ REMINDERS SECTION ------------>
<div id="rem" class="tab-section" style="display:none;">
    <div class="section-title-header">Upcoming Reminders</div>

    <?php if(empty($reminders)) { ?>
        <div class="panel-card rem-card text-center">No reminders available</div>
    <?php } ?>

    <?php foreach($reminders as $r){ ?>
    <div class="panel-card rem-card">
        <div class="card-icon icon-rem">⏰</div>

        <div class="card-title"><?= $r['title']; ?></div>
        <span class="card-date"><?= $r['reminder_date']; ?> - <?= $r['reminder_time']; ?></span>

        <div class="card-desc"><?= substr(strip_tags($r['description']),0,160)."..." ?></div>
    </div>
    <?php } ?>
</div>

<!------------ BLOGS SECTION ------------>
<div id="blog" class="tab-section" style="display:none;">
    <div class="section-title-header">Latest Blogs</div>

    <?php if(empty($blogs)) { ?>
        <div class="panel-card blog-card text-center">No blogs available</div>
    <?php } ?>

    <?php foreach($blogs as $b){ ?>
    <div class="panel-card blog-card">
        <div class="card-icon icon-blog">📝</div>

        <div class="card-title"><?= $b['title']; ?></div>
        <span class="card-date"><?= date("d M Y", strtotime($b['created_at'])); ?></span>

        <div class="card-desc"><?= substr(strip_tags($b['description']),0,160)."..." ?></div>

        <div class="card-actions">
            <?= ($b['blog_url']) ? '<a href="'.$b['blog_url'].'" target="_blank" class="btn btn-info btn-sm">Read Blog</a>' : '' ?>
        </div>
    </div>
    <?php } ?>
</div>

<!------------ FLASH MESSAGES SECTION ------------>
<div id="flash" class="tab-section" style="display:none;">
    <div class="section-title-header">Flash Messages</div>

    <?php if(empty($flash)) { ?>
        <div class="panel-card flash-card text-center">No flash messages available</div>
    <?php } ?>

    <?php foreach($flash as $f){ ?>
    <div class="panel-card flash-card">
        <div class="card-icon icon-flash">⚡</div>

        <div class="card-title"><?= $f['title']; ?></div>
        <span class="card-date"><?= $f['show_from'].' → '.$f['show_to']; ?></span>

        <div class="card-desc"><?= substr(strip_tags($f['message']),0,160)."..." ?></div>
    </div>
    <?php } ?>
</div>

</div>

<script>
$(".tabBtn").click(function(){
    $(".tabBtn").removeClass("active");
    $(this).addClass("active");
    $(".tab-section").hide();
    $("#" + $(this).data("target")).fadeIn();
});
</script>
