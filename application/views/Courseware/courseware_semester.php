



  <style>
    .section-title {
        font-size: 18px;
        font-weight: 700;
        margin-top: 30px;
        margin-bottom: 15px;
    }
    h5 {
    font-size: 19px;
    font-weight:600;
    padding:7px;
}

 .exc {
    font-size: 19px;
    font-weight:bold;
}
    .custom-card {
    border-radius: 17px;
    padding: 0px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
    height: 100%;
    background: #fff;
    border: #CED7DB solid 1px;
    height: 250px;
}
 .card-div {

    padding: 20px;
 
}

    .icon-box {
        font-size: 26px;
        color: #b40000;
        margin-right: 8px;
    }
    .status-pill {
        background: #e3ffe3;
        color: #008000;
        font-size: 12px;
        padding: 3px 7px;
        border-radius: 10px;
    }
    .pending-bar {
        background: #f0f2ff;
        padding: 8px;
        text-align: center;
        font-weight: 500;
        color: #4a4a9d;
        border-bottom-left-radius: 8px;
        border-bottom-right-radius: 8px;
    }
    .calc{
    background: #f0f2ff;
    padding: 20px;
    border-radius: 100%;
}

hr {
    margin: 10px 0;
    border: 0;
    border-top: 1px solid #838080;
    border-bottom: 0;
}
  </style>

</head>
<body class="bg-light">

  <div class="container-fluid" style="padding:40px 25px;">

    <!-- ORG BEHAVIOR -->
    <div class="section-title">Organizational Behavior</div>

    <div class="row g-4">

        <!-- Courseware -->
        <div class="col-md-4">
            <div class="custom-card bg-white">
                <h5><i class="icon-box bi bi-journals"></i> Courseware</h5><hr/>
                  <div class="card-div "> <p class="mt-3 mb-1">📘 185 Learning Activity</p>
                <p class="mb-1">📝 5 Assignment</p>
                <p>💬 0 Discussion</p></div>
            </div>
        </div>

        <!-- Live Class -->
        <div class="col-md-4">
            <div class="custom-card bg-white text-center">
                <h5><i class="icon-box bi bi-broadcast"></i> Live Class</h5><hr/>
               <div style="padding:10px; overflow:visible; text-align:center;">
  <img src="https://cdn-icons-png.flaticon.com/512/747/747310.png" 
       width="95" 
       class="my-3 calc"
       style="display:inline-block; max-width:100%; height:auto;">
</div>
                <div class="exc">No Live Class Scheduled For Upcoming Week</div>
            </div>
        </div>

        <!-- Continuous Assessment -->
        <div class="col-md-4">
            <div class="custom-card bg-white p-0">
                <div class="p-3">
                    <h5><i class="icon-box bi bi-pencil-square"></i> Continuous Assessment</h5><hr/>

                  <div class="card-div ">  <p class="mt-3 mb-1 fw-medium">DUE DATE – 10/12/2025</p>

                    <p class="mb-1">
                        Assignment 1
                        <span class="status-pill">Graded</span>
                    </p>

                    <p class="text-muted">Duration: 15 Minutes | 15 Marks</p>
</div>
                </div>

                <div class="pending-bar">1 more assessment pending</div>
            </div>
        </div>

    </div>

    <!-- PRINCIPLES OF ACCOUNTING -->
    <div class="section-title">Principles of Accounting</div>

    <div class="row g-4">

        <!-- Courseware -->
        <div class="col-md-4">
    <a href="subject_assessment_chapter" 
       style="display:block; text-decoration:none; color:inherit;">
       
        <div class="custom-card bg-white" 
             style="padding:15px; border-radius:6px; box-shadow:0 2px 6px rgba(0,0,0,0.1);">

            <h5><i class="icon-box bi bi-journals"></i> Courseware</h5>
            <hr/>

            <div class="card-div">
                <p class="mt-3 mb-1">📘 158 Learning Activity</p>
                <p class="mb-1">📝 5 Assignment</p>
                <p>💬 0 Discussion</p>
            </div>

        </div>
        
    </a>
</div>


   <!-- Live Class -->
<div class="col-md-4">
    <a href="subject_class_chapter" 
       class="custom-card bg-white text-center" 
       style="display:block; text-decoration:none; color:inherit; padding:15px; border-radius:6px; box-shadow:0 2px 6px rgba(0,0,0,0.1);">
       
        <h5><i class="icon-box bi bi-broadcast"></i> Live Class</h5>
        <hr/>
        
        <div style="padding:10px; overflow:visible; text-align:center;">
            <img src="https://cdn-icons-png.flaticon.com/512/747/747310.png" 
                 width="95" 
                 class="my-3 calc"
                 style="display:inline-block; max-width:100%; height:auto;">
        </div>
        
        <div class="exc">No Live Class Scheduled For Upcoming Week</div>
    </a>
</div>


        <!-- Assessment -->
        <div class="col-md-4">
  <a href="subject_assessment" style="text-decoration: none; color: inherit;">
    <div class="custom-card bg-white p-0">
      <div class="p-3">
        <h5><i class="icon-box bi bi-pencil-square"></i> Continuous Assessment</h5><hr/>

        <div class="card-div">
          <p class="mt-3 mb-1 fw-medium">DUE DATE – 10/12/2025</p>

          <p class="mb-1">
            Assignment 1
            <span class="status-pill">Graded</span>
          </p>

          <p class="text-muted">Duration: 15 Minutes | 15 Marks</p>
        </div>
      </div>

      <div class="pending-bar">1 more assessment pending</div>
    </div>
  </a>
</div>


    </div>

</div>

<!-- BOOTSTRAP JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

