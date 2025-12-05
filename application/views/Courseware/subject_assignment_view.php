
<style>
.ticket-container {
            background: #ffffff;
            padding: 25px 30px;
            border-radius: 25px;
            margin: 25px auto;
           
        }

    .assessment-card {
        background:#fff;
        border:1px solid #dcdcdc;
        border-radius:12px;
        padding:20px 25px;
        margin-top:20px;
    }

    .info-row {
        background:#fafafa;
        padding:12px 15px;
        margin-bottom:8px;
        border-radius:5px;
        font-size:16px;
        font-weight:500;
        border:1px solid #eeeeee;
    }
.label-bold {
    font-weight: 700;
    color: #070f21;
}
  .attempt-link {
    color: #1492b5;
    font-weight: 700;
    cursor: pointer;
    text-decoration: none;
}
    .attempt-link:hover { text-decoration:underline; }

    .status-box {
        display:inline-block;
        font-weight:700;
        color:#3abb48;
        font-size:16px;
        margin-right:10px;
    }
    .status-icon {
        width:20px;
        vertical-align:middle;
        margin-right:5px;
    }

    .btn-start {
        background:#c8c8c8;
        color:#333;
        padding:10px 35px;
        border-radius:8px;
        font-weight:700;
        border:none;
        font-size:16px;
    }
     .btn-submit {
            background: #1c8eb3;
            color: #ffffff;
            padding: 8px 25px;
            border-radius: 25px;
            border: none;
        }
</style>
</head>

<body>

<div class="container-fluid" style="padding:40px 25px;margin-top:20px">
    <div class="ticket-container">


    <div class="assessment-card">

        <div class="info-row"><span class="label-bold">Assessment Type:</span> REAL</div>
        <div class="info-row"><span class="label-bold">Total Question:</span> 15</div>
        <div class="info-row"><span class="label-bold">Marks:</span> 15</div>
        <div class="info-row"><span class="label-bold">Best of luck for your Assessment.</span></div>
        <div class="info-row"><span class="label-bold">Time Limit:</span> 15</div>
        <div class="info-row"><span class="label-bold">Negative Marking:</span> NO</div>
        <div class="info-row"><span class="label-bold">End Date:</span> 10/12/2025</div>

      <!-- MODAL TRIGGER -->
        <div class="info-row">
            <a class="attempt-link" data-toggle="modal" data-target="#attemptModal">VIEW PREVIOUS ATTEMPTS</a>
        </div>

        <div class="info-row">
            <span class="label-bold">User Last Attempt:</span>
            Dec 04, 2025 | 4:42 PM
        </div>

        <!-- Footer buttons -->
        <div class="row" style="margin-top:15px;">
            <div class="col-xs-6"></div>
            <div class="col-xs-6 text-right">
                <span class="status-box">
                    <img src="https://cdn-icons-png.flaticon.com/512/845/845646.png" class="status-icon">
                    Passed
                </span>
               <a href="assignments_guidelines_view" style="text-decoration: none; color: inherit;">  <button class="btn-start">START</button></a>
            </div>
        </div>

    </div>

</div>
</div>

<!-- MODAL POPUP -->
<div id="attemptModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <div class="modal-content">
      <div class="modal-header" style="border-bottom:1px solid #ddd;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Previous Attempts</h4>
      </div>

      <div class="modal-body">
        <table class="table table-bordered">
          <thead>
            <tr style="background:#f2f2f2;">
              <th>Attempt Date</th>
              <th>Duration</th>
              <th>Score</th>
              <th>Result</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Dec 04, 2025 | 4:42 PM</td>
              <td>12 Mins</td>
              <td>14 / 15</td>
              <td style="color:#3abb48;font-weight:700;">Passed</td>
            </tr>
            <tr>
              <td>Dec 01, 2025 | 5:10 PM</td>
              <td>14 Mins</td>
              <td>11 / 15</td>
              <td style="color:#d42f2f;font-weight:700;">Failed</td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-submit " data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
