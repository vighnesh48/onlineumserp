

<style>

    .guideline-box {
        background:#ffffff;


        padding:25px 35px;
        margin-top:20px;
    }

    .guideline-title {
        font-size:22px;
        font-weight:700;
        color:#0f1b33;
        margin-bottom:15px;
    }

    .guideline-box ul {
        font-size:18px;
        padding-left:18px;
        list-style-type:disc;
        line-height:29px;
        margin-bottom:20px;
    }

    .checkbox-area {
        margin-top:10px;
        font-size:16px;
        font-weight:600;
    }

    input[type="checkbox"] {
        width:18px;
        height:18px;
        margin-right:8px;
        cursor:pointer;
    }

    .btn-okay {
        background:#cccccc;
        color:#333;
        border:none;
        border-radius:8px;
        padding:10px 30px;
        font-size:16px;
        font-weight:700;
        margin-top:15px;
        cursor:not-allowed;
    }
  .ticket-container {
            background: #ffffff;
            padding: 25px 30px;
            border-radius: 25px;
            margin: 25px auto;
           
        }
        label {
    font-weight: 400;
    font-size: 15px;
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

    <div class="guideline-box">

        <div class="guideline-title">General Guidelines for Assignments:</div>

        <ul>
            <li>Every provisionally registered students have been provided the access to LMS for learning purpose only.</li>
            <li>The student need to ensure that their mandatory documents required as per eligibility norms for selected program has been submitted by student for admission process to the university.</li>
            <li>The students in provisional admission category; their assignment scores would not be considered for evaluation purpose.</li>
            <li>Student undertakes to abide the university guidelines for provisional admissions and understands that in case the student does not meet the eligibility norms, or non submission of mandatory documents the said provisional admission may get cancelled.</li>
            <li>Student undertakes to get minimum access of 512 kbps internet connectivity before submission of assignments through LMS.</li>
            <li>Student undertakes that he/she would not open any new window or navigate to other window or browse while submitting the assignment, as any query occurrence due to this would not be accepted by university and student would have to re-appear for said assignment. Note the assignment may be auto submitted if the student opens any other window or navigates to other windows.</li>
            <li>Students would not submit the assignment through Mobile phone or Tablet PC. The assignments has to be submitted through Desktop and Laptop only.</li>
            <li>Student undertakes to abide the solution provided by the university for any technical query related to said assignment if any, if such a technical query has not occurred due to university systems. The students may have to re-appear for said assignments.</li>
            <li>Before 5 minutes of completion of Assignments a pop up alert will appear as a reminder for student and student should ensure all questions are submitted and no request for pending submission would be accepted.</li>
            <li>Students to share the screen shot of error occurred with the support team for query resolution.</li>
            <li>Assignments would not be reset for improvisation of assignment scores.</li>
            <li>Students to refer the guidelines and passing criteria on university website.</li>
        </ul>

        <div class="checkbox-area">
            <label><input type="checkbox" id="agreeCheck"> I agree</label>
        </div>

        <a href="solve_assignments" style="text-decoration: none; color: inherit;"> <button class="btn-okay btn-submit" id="btnSubmit" disabled>OKAY</button></a>

    </div>

</div>
    </div>

</div>

<script>
    // Enable button if checkbox checked
    $('#agreeCheck').change(function () {
        if ($(this).is(':checked')) {
            $('#btnSubmit').prop('disabled', false)
                           .css({"background":"#1c8eb3","color":"#fff","cursor":"pointer"});
        } else {
            $('#btnSubmit').prop('disabled', true)
                           .css({"background":"#ccc","color":"#333","cursor":"not-allowed"});
        }
    });
</script>

