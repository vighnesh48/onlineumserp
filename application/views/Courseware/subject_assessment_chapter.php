<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Courseware Page</title>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

<style>
   .ticket-container {
            background: #ffffff;
            padding: 25px 30px;
            border-radius: 25px;
            margin: 25px auto;
           
        }

    h2 { font-weight:700; color:#0f1b33; margin-top:10px; }

    /* Top Main Tabs */
    .nav-tabs { border-bottom:none; margin-top:10px; }
    .nav-tabs>li>a {
        border:none !important;
        color:#555 !important;
        font-size:16px;
        font-weight:600;
        padding:10px 30px;
            border-radius: 25px;
    }
   .nav-tabs>li.active>a {
    background: #1c8eb3 !important;
    color: #fff !important;
    border-radius: 6px;
    border-radius: 25px;
}

    /* Module slider section */
    .modules-wrapper {
        position:relative; margin-top:10px; padding:0 40px;
    }
    .modules-scroll {
        overflow-x:auto; white-space:nowrap;
        border-bottom:3px solid #d7d7d7; padding:15px 0;
    }
    .modules-scroll::-webkit-scrollbar { display:none; }

    .module-item {
        display:inline-block; padding:10px 35px;
        font-size:15px; font-weight:600; cursor:pointer;
        border-bottom:4px solid transparent; color:#333;
    }
.module-item.active {
    color: #1c8eb3;
    border-bottom: 4px solid #1c8eb3;
}
    .scroll-btn {
        position:absolute; top:50%; transform:translateY(-50%);
        background:#fff; border:none; font-size:26px;
        font-weight:bold; color:#1c8eb3;; cursor:pointer;
    }
    .scroll-left { left:0; }
    .scroll-right { right:0; }

    /* Badges Section */
    .top-badges { margin-top:10px; text-align:right; font-size:14px; }
    .badge-box {
    display: inline-block;
    background: #f4fbff;
    padding: 6px 15px;
    border-radius: 20px;
    margin-left: 10px;
    font-weight: 40;
    border: #bfdded solid 1px;
}
    /* Progress & Section */
    .progress-title { margin-top:20px;font-size:17px;font-weight:600;color:#0f1b33; }
    .progress { height:8px; border-radius:5px; }
    .progress-bar-success { background:#3abb48; }

   .learning-title {
    margin-top: 25px;
    font-size: 22px;
    font-weight: 700;
    color: #1c8eb3;
    border-bottom: 4px solid #1c8eb3;
    width: 250px;
    padding-bottom: 4px;
}

    .resource-card {
    border: 1px solid #bfdded;
    border-radius: 18px;
    margin-top: 18px;
    padding: 22px 28px;
    height: 140px;
    background: #f4fbff;
}
    .resource-title { font-size:18px; font-weight:700; color:#0f1b33; }
    .time-meta { font-size:14px; color:#4a4a4a; margin-top:6px;margin-bottom:8px; }

   .view-btn {
    background: #41a2c4;
    color: #fff;
    padding: 10px 34px;
    border-radius: 25px;
    font-size: 14px;
    font-weight: 700;
    float: right;
    margin-top: -58px;
    border: none;
}
</style>
</head>

<body>
<div class="container-fluid" style="padding:40px 25px;margin-top:20px">
    <div class="ticket-container">

    <h2>Organizational Behavior</h2>

    <!-- Top main tabs -->
    <ul class="nav nav-tabs">
        <li class="active"><a href="#cw" data-toggle="tab">Courseware</a></li>
        <li><a href="#lc" data-toggle="tab">Live Class</a></li>
        <li><a href="#ca" data-toggle="tab">Continuous Assessment</a></li>
    </ul>

    <div class="tab-content">

        <!-- COURSEWARE TAB -->
        <div id="cw" class="tab-pane fade in active">

            <!-- Module slider -->
            <div class="modules-wrapper">
                <button class="scroll-btn scroll-left">&lt;</button>

                <div class="modules-scroll">
                    <span class="module-item active" data-target="m1">Industry Oriented Tutorials</span>
                    <span class="module-item" data-target="m2">Module 1: Introduction</span>
                    <span class="module-item" data-target="m3">Module 2: Diversity in organization...</span>
                    <span class="module-item" data-target="m4">Module 3: Managing Team & Leadership</span>
                    <span class="module-item" data-target="m5">Module 4: Power, Politics, Conflict</span>
                </div>

                <button class="scroll-btn scroll-right">&gt;</button>
            </div>

            <!-- Badges above progress -->
            <div class="top-badges">
                <span class="badge-box"><span class="glyphicon glyphicon-duplicate"></span> 77 Learning Activity</span>
                <span class="badge-box"><span class="glyphicon glyphicon-file"></span> 0 Assignment</span>
                <span class="badge-box"><span class="glyphicon glyphicon-comment"></span> 0 Discussion</span>
            </div>

            <!-- Progress bar -->
            <div class="progress-title">Progress <span style="float:right;">10%</span></div>
            <div class="progress">
                <div class="progress-bar progress-bar-success" style="width:10%"></div>
            </div>

            <!-- Learning Resources Title -->
            <div class="learning-title">Learning Resources</div>

            <!-- MODULE CONTENT SECTIONS -->
            <div id="m1" class="module-content">
                <div class="resource-card">
                    <div style="width:85%;">
                        <div class="resource-title">Big Five Theory of Personality
                            <span class="label label-default">Recorded Video Tutorials</span>
                        </div>
                        <div class="time-meta"><span class="glyphicon glyphicon-time"></span> 6 Mins</div>
                        <strong>Progress <span style="float:right;">100%</span></strong>
                        <div class="progress"><div class="progress-bar progress-bar-success" style="width:100%"></div></div>
                    </div>
                    <button class="view-btn">VIEW</button>
                </div>
            </div>

            <div id="m2" class="module-content" style="display:none;">
                <div class="resource-card"><h4>Module 1 Lessons Coming Soon...</h4></div>
            </div>

            <div id="m3" class="module-content" style="display:none;">
                <div class="resource-card"><h4>Module 2 Resources</h4></div>
            </div>

            <div id="m4" class="module-content" style="display:none;">
                <div class="resource-card"><h4>Module 3 Content</h4></div>
            </div>

            <div id="m5" class="module-content" style="display:none;">
                <div class="resource-card"><h4>Module 4 Content</h4></div>
            </div>

        </div>

    </div>
</div>
</div>
</div>

<script>
    // Scroll buttons
    $(".scroll-right").click(function(){ $(".modules-scroll").animate({scrollLeft:"+=250px"},300); });
    $(".scroll-left").click(function(){ $(".modules-scroll").animate({scrollLeft:"-=250px"},300); });

    // Module Click functionality
    $(".module-item").click(function () {
        $(".module-item").removeClass("active");
        $(this).addClass("active");

        var section = $(this).data("target");
        $(".module-content").hide();
        $("#" + section).show();
    });
</script>
