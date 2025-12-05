<!DOCTYPE html>
<html>
<head>


    <style>
        body { background: #fafafa; }
  .ticket-container {
            background: #ffffff;
            padding: 25px 30px;
            border-radius: 25px;
            margin: 25px auto;
  }
        .header-title {
            font-size: 22px;
            font-weight: 600;
 
        }
hr {
    margin: 10px 0;
    border: 0;
    border-top: 1px solid #f3f3f3!important;
    border-bottom: 0;
}
.btn-view {
    background-color: #1d89cf!important;
    color: white;
    padding: 7px 18px;
    border-radius: 25px;
}
        .assessment-card {
            background: #f4fbff;
            padding: 20px 20px;
            border-radius: 25px;
            border: 1px solid #eee;
            margin-bottom: 25px;
            min-height: 230px;
        }
.nav-tabs > li.active > a {
    color: #ffffff!important;
}
         .btn-submit {
            background: #1c8eb3;
            color: #ffffff;
            padding: 8px 25px;
            border-radius: 25px;
            border: none;
        }
        .card-title {
            font-size: 18px;
            font-weight: bold;
        }

       .label-test {
    background: #1d89cf;
    font-size: 17px;
    padding: 4px 20px;
    border-radius: 20px;
}
        .info-list div { margin-bottom: 5px; }

        .attempted {
            color: #124175;
            font-weight: 600;
        }

        .btn-view {
            background-color: #941333;
            color: white;
            padding: 7px 18px;
        }

        .nav-tabs > li > a { color: #333; font-weight: bold; }


        .top-right-tabs {
            margin-top: 10px;
            float: right;
        }
    </style>

</head>
<body>

<div class="container-fluid" style="padding:40px 25px;margin-top:20px">
    <div class="ticket-container">

    <!-- Title Row -->
    <div class="row">
        <div class="col-xs-12">
            <div class="header-title">Continuous Assessment -ONRDP101-Research Methodology</div>
			
        </div>
    </div>

    <!-- Functional Tabs -->
    <ul class="nav nav-tabs top-right-tabs">
        <li class="active"><a data-toggle="tab" class="btn-submit"  href="#all">ALL</a></li>
        <li><a data-toggle="tab" class="btn-submit" href="#progress">IN PROGRESS</a></li>
        <li><a data-toggle="tab" class="btn-submit" href="#upcoming">UPCOMING</a></li>
        <li><a data-toggle="tab" class="btn-submit" href="#completed">COMPLETED</a></li>
    </ul>

    <div style="clear: both; margin-bottom: 20px;"></div>

    <!-- Tab Content -->
    <div class="tab-content">

        <!-- ALL TAB -->
        <div id="all" class="tab-pane fade in active">
            <div class="row">

                <!-- Card 1 -->
                <div class="col-sm-6">
                    <div class="assessment-card">
                        <div class="card-title">
                            Assignment 1 
                            
                        </div>

                        <br>

                        <div class="info-list">
                            <div><strong>Start Date:</strong> Dec 01, 2025</div><hr/>
                            <div><strong>End Date:</strong> Dec 10, 2025</div><hr/>
                            <div><strong>Duration:</strong> 15 Mins</div><hr/>
                            <div><strong>Total Marks:</strong> 15</div><hr/>
                            <div><strong>Passing Marks:</strong> 6</div><hr/>
                        </div>

                        <br>

                        <span class="attempted"><span class="glyphicon glyphicon-ok-circle"></span> Attempted</span>
                    <a href="subject_assignment_view" class="pull-right">
    <button class="btn btn-view">VIEW</button>
</a>


                    </div>
                </div>

                <!-- Card 2 -->
                <div class="col-sm-6">
                    <div class="assessment-card">
                        <div class="card-title">
                            Assignment 2 
                            
                        </div>

                        <br>

                        <div class="info-list">
                            <div><strong>Start Date:</strong> Dec 05, 2025</div><hr/>
                            <div><strong>End Date:</strong> Dec 15, 2025</div><hr/>
                            <div><strong>Duration:</strong> 20 Mins</div><hr/>
                            <div><strong>Total Marks:</strong> 15</div><hr/>
                            <div><strong>Passing Marks:</strong> 6</div><hr/>
                        </div>

                        <br>

                        <span class="attempted"><span class="glyphicon glyphicon-ok-circle"></span> Attempted</span>
                      <a href="subject_assignment_view" class="pull-right">
    <button class="btn btn-view">VIEW</button>
</a>


                    </div>
                </div>

            </div>
        </div>

        <!-- IN PROGRESS TAB -->
        <div id="progress" class="tab-pane fade">
            <h4>No assignments in progress.</h4>
        </div>

        <!-- UPCOMING TAB -->
        <div id="upcoming" class="tab-pane fade">
            <h4>No upcoming assignments.</h4>
        </div>

        <!-- COMPLETED TAB -->
        <div id="completed" class="tab-pane fade">
            <h4>No completed assessments.</h4>
        </div>

    </div>

</div></div>

</body>
</html>
