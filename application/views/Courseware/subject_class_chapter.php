
<style>

    h2 { font-weight:700; color:#0f1b33; margin-top:20px; }

    /* TOP TABS */
    .nav-tabs { border-bottom:none; margin-top:10px; }
 .nav-tabs>li>a {
    border: none !important;
    color: #555 !important;
    font-size: 16px;
    font-weight: 600;
    padding: 10px 30px;
    border-radius: 25px;
}
  .nav-tabs>li.active>a {
    background: #1c8eb3;
    color: #000000 !important;
    border-radius: 25px;
}
.theme-default .nav-tabs>li.active>a, .theme-default .nav-tabs>li.active>a:focus, .theme-default .nav-tabs>li.active>a:hover {
    background: #1c8eb3!important;

}

    /* SECOND-LEVEL FILTER TABS */
    .filter-tabs { border-bottom:2px solid #dcdcdc; margin-top:15px; }
    .filter-tabs>li>a {
        font-weight:700;
        padding:8px 25px;
        border:none !important;
        background:none !important;
        color:#333;
        font-size:14px;
    }
    .filter-tabs>li.active>a,
    .filter-tabs>li.active>a:focus {
        color:#1c8eb3; !important;
        border-bottom:3px solid #1c8eb3; !important;
    }

    /* CARD */
    .live-card {
        border:1px solid #dcdcdc;
        border-radius:12px;
        padding:25px 30px;
        margin-top:20px;
        background:#fff;
        min-height:200px;
    }

    .session-title {
        font-size:18px;
        font-weight:700;
        color:#0f1b33;
    }
    .subtitle { font-size:15px; margin-bottom:10px; color:#444; font-weight:600; }

    .info-label { font-size:14px; font-weight:700; color:#0f1b33; }
    .info-value { font-size:14px; }

    .btn-record {
    background: #1c8eb3;
    color: #fff;
    border-radius: 25px;
    padding: 10px 30px;
    margin-top: 15px;
    font-weight: 700;
    border: none;
}
     .ticket-container {
            background: #ffffff;
            padding: 25px 30px;
            border-radius: 25px;
            margin: 25px auto;
           
        }
   .btn-summarize {
    border: 2px solid #1c8eb3;
    color: #1c8eb3;
    padding: 10px 30px;
    border-radius: 25px;
    font-weight: 700;
    margin-top: 15px;
    background: #fff;
    margin-left: 10px;
}
</style>



<div class="container-fluid" style="padding:40px 25px;margin-top:20px">
    <div class="ticket-container">

    <h2>Organizational Behavior</h2>

    <!-- TOP NAV TABS -->
    <ul class="nav nav-tabs">
        <li><a href="#">Courseware</a></li>
        <li class="active"><a href="#">Live Class</a></li>
        <li><a href="#">Continuous Assessment</a></li>
    </ul>

    <!-- FILTER TAB -->
    <ul class="nav nav-tabs filter-tabs">
        <li class="active"><a data-toggle="tab" href="#all">ALL</a></li>
        <li><a data-toggle="tab" href="#about">ABOUT TO START</a></li>
        <li><a data-toggle="tab" href="#upcoming">UPCOMING</a></li>
        <li><a data-toggle="tab" href="#concluded">CONCLUDED</a></li>
        <li><a data-toggle="tab" href="#cancelled">CANCELLED</a></li>
    </ul>

    <!-- TAB CONTENT -->
    <div class="tab-content">

        <!-- ALL -->
        <div id="all" class="tab-pane fade in active">
            <div class="row">

                <div class="col-md-4">
                    <div class="live-card">
                        <div class="session-title">DYP_MBA_Sem1_Organizational Behaviour (MBA)_Session_9</div>
                        <div class="subtitle">Live class</div>

                        <div class="row">
                            <div class="col-xs-6">
                                <div class="info-label">Starts On</div>
                                <div class="info-value">Nov 08, 2025 | 6:00 PM</div>
                            </div>
                            <div class="col-xs-6">
                                <div class="info-label">Duration</div>
                                <div class="info-value">1 Hrs 0 Mins</div>
                            </div>
                        </div>

                        <button class="btn-record">VIEW RECORDED</button>
                        <button class="btn-summarize"><span class="glyphicon glyphicon-flash"></span> Summarize</button>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="live-card">
                        <div class="session-title">DYP_MBA_Sem1_Organizational Behaviour (MBA)_Session_8</div>
                        <div class="subtitle">Live class</div>

                        <div class="row">
                            <div class="col-xs-6">
                                <div class="info-label">Starts On</div>
                                <div class="info-value">Nov 01, 2025 | 6:00 PM</div>
                            </div>
                            <div class="col-xs-6">
                                <div class="info-label">Duration</div>
                                <div class="info-value">1 Hrs 0 Mins</div>
                            </div>
                        </div>

                        <button class="btn-record">VIEW RECORDED</button>
                        <button class="btn-summarize"><span class="glyphicon glyphicon-flash"></span> Summarize</button>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="live-card">
                        <div class="session-title">DYP_MBA_Sem1_Organizational Behaviour (MBA)_Session_7</div>
                        <div class="subtitle">Live class</div>

                        <div class="row">
                            <div class="col-xs-6">
                                <div class="info-label">Starts On</div>
                                <div class="info-value">Oct 25, 2025 | 6:00 PM</div>
                            </div>
                            <div class="col-xs-6">
                                <div class="info-label">Duration</div>
                                <div class="info-value">1 Hrs 0 Mins</div>
                            </div>
                        </div>

                        <button class="btn-record">VIEW RECORDED</button>
                        <button class="btn-summarize"><span class="glyphicon glyphicon-flash"></span> Summarize</button>
                    </div>
                </div>

            </div>
        </div>

        <!-- OTHER FILTER TABS -->
        <div id="about" class="tab-pane fade">
            <h3>No sessions about to start</h3>
        </div>

        <div id="upcoming" class="tab-pane fade">
            <h3>No upcoming classes</h3>
        </div>

        <div id="concluded" class="tab-pane fade">
            <h3>Recently concluded classes will appear here.</h3>
        </div>

        <div id="cancelled" class="tab-pane fade">
            <h3>No cancelled sessions.</h3>
        </div>

    </div>

</div>
