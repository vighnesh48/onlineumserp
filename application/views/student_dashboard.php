<!DOCTYPE html>
<html>
<head>
    <title>Exact Dashboard Clone (Bootstrap 3)</title>


    <style>

        /* GLOBAL */
        body {
            background: #F6F7FB;
  
        }

        .container-max {
            width: 1280px;      /* exact width like your screenshot */
            margin: auto;
        }

        /* HEADER BANNER */
        .dashboard-header {
            background:  #2fb3d8;
            color: #fff;
            border-radius: 12px;
            padding: 25px 35px;
            margin-top: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .dashboard-header-left {
            font-size: 18px;
        }

        /* PROGRESS SECTION */
     .progress-block {
    margin-top: 20px;
    padding: 20px 30px;
    border-radius: 12px;
    background: linear-gradient(to right, #dbf1ff, #0d96ef);
    font-size: 15px;
}

        /* MAIN WRAPPER */
        .main-row {
            margin-top: 25px;
        }

        /* CARD */
        .card {
            background: #fff;
            border-radius: 12px;
            padding: 25px 30px;
            border: 1px solid #E9E9E9;
            margin-bottom: 25px;
        }

        /* LECTURE THUMB */
        .lecture-thumb {
            width: 100%;
            height: 120px;
            background-size: cover;
            background-position: center;
            border-radius: 12px;
            margin-bottom: 12px;
        }

        /* BUTTONS */
        .btn-round {
            border-radius: 25px;
            padding: 6px 22px;
            font-size: 13px;
        }

        /* CONTINUE LEARNING PROGRESS BARS */
        .custom-progress {
            height: 8px;
            border-radius: 5px;
            background: #E8E8E8;
            margin-top: 5px;
        }

        .custom-progress-bar {
            height: 8px;
            border-radius: 5px;
            background: #C52033;
            width: 100%;
        }

        /* RIGHT SIDEBAR */
        .sidebar-card {
            background: #fff;
            border-radius: 12px;
            padding: 20px;
            border: 1px solid #E9E9E9;
            margin-bottom: 25px;
        }

        /* CALENDAR IMAGE PLACEHOLDER */
        .calendar-box {
            width: 100%;
            height: 260px;
            background: #EFEFEF;
            border-radius: 12px;
            margin-top: 10px;
        }
        .hero-btn { background:#fff; color:#1a8eb4; border-radius:30px; padding:10px 22px; font-weight:500; border:0; }


.sidebar-card {
    background: #fff;
    padding: 15px;
    border-radius: 10px;
    border: 1px solid #ddd;
    box-shadow: 0px 2px 6px rgba(0,0,0,0.1);
}

.analytics-item {
    margin-bottom: 15px;
}

.analytics-item span {
    font-weight: 600;
    display: block;
    margin-bottom: 5px;
}

.rounded-progress {
    height: 10px;
    border-radius: 20px;
    overflow: hidden;
}

.progress-bar {
    border-radius: 20px;
}





    </style>
</head>

<body>
<div class="container-fluid" style="padding:40px 25px;">


    <!-- HEADER -->
    <div class="dashboard-header">
        <div class="dashboard-header-left">
            <h1 style="margin:0;">Welcome back, Harshad</h1>
            <h4 style="margin:0;">Let’s continue your learning journey together!</h4>
        </div>
        <div>
            <!-- Right profile section placeholder -->
        </div>
    </div>

    <!-- PROGRESS SECTION -->
    <div class="progress-block">
        <h3>43% of your batch mates have completed this assignment.<br><br>
        6 Days • 9 Hrs • 42 Mins left to complete.
        <span class="label label-danger" style="margin-left:10px;">18 Assignments Pending</span></h3>
    </div>

    <!-- MAIN CONTENT -->
    <div class="row main-row">
        
        <!-- LEFT CONTENT -->
        <div class="col-md-9">

            <!-- LATEST CARD -->
            <div class="card">
                <h2><strong>Latest</strong></h2>
                <h3><strong>DYP_MBA_Jul’25_Sem1_Principles of Management (MBA)_Session_5</strong></h3>
                <button class="btn btn-md btn-primary">View Recording</button>
                <button class="btn btn-md  btn-primary">Summarize with AI</button>
            </div>

            <!-- RECENT LECTURES -->
            <div class="card">
                <h3><strong>Recent Lectures</strong></h3>

                <div class="row">

                    <div class="col-sm-3">
                        <div class="lecture-thumb" style="background-image:url('https://lms.dypatiledu.com/assets/lecture-card-image.svg');"></div>
                        <button class="btn btn-primary btn-md">Watch</button>
                        <button class="btn btn-primary btn-md">Summarize</button>
                    </div>

                    <div class="col-sm-3">
                        <div class="lecture-thumb" style="background-image:url('https://lms.dypatiledu.com/assets/lecture-card-image.svg');"></div>
                        <button class="btn btn-primary btn-md">Watch</button>
                        <button class="btn btn-md btn-primary">Summarize</button>
                    </div>

                    <div class="col-sm-3">
                        <div class="lecture-thumb" style="background-image:url('https://lms.dypatiledu.com/assets/lecture-card-image.svg');"></div>
                        <button class="btn btn-primary btn-md">Watch</button>
                        <button class="btn btn-primary btn-md">Summarize</button>
                    </div>

                </div>
            </div>













            
            <!-- CONTINUE LEARNING -->
            <div class="card">
                <h4><strong>Continue Learning</strong></h4>

                <div class="row">
                    <div class="col-sm-6"> <svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium css-1m9ymud-MuiSvgIcon-root" focusable="false" aria-hidden="true" viewBox="0 0 30 30" data-testid="VideoIcon" xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M5 3.75C4.33696 3.75 3.70107 4.01339 3.23223 4.48223C2.76339 4.95107 2.5 5.58696 2.5 6.25V23.75C2.5 24.413 2.76339 25.0489 3.23223 25.5178C3.70107 25.9866 4.33696 26.25 5 26.25H25C25.663 26.25 26.2989 25.9866 26.7678 25.5178C27.2366 25.0489 27.5 24.413 27.5 23.75V6.25C27.5 5.58696 27.2366 4.95107 26.7678 4.48223C26.2989 4.01339 25.663 3.75 25 3.75H5ZM10.7812 10.7875C10.809 10.5485 10.8922 10.3193 11.0242 10.1182C11.1563 9.91711 11.3335 9.74965 11.5418 9.62919C11.75 9.50873 11.9835 9.43861 12.2237 9.42443C12.4639 9.41024 12.704 9.45239 12.925 9.5475C13.555 9.8175 14.885 10.425 16.57 11.3975C17.7542 12.0743 18.8978 12.8197 19.995 13.63C20.1879 13.7735 20.3446 13.9602 20.4525 14.1751C20.5605 14.3899 20.6167 14.627 20.6167 14.8675C20.6167 15.108 20.5605 15.3451 20.4525 15.5599C20.3446 15.7748 20.1879 15.9615 19.995 16.105C18.8977 16.9144 17.7541 17.659 16.57 18.335C15.3921 19.023 14.1751 19.6416 12.925 20.1875C12.704 20.2829 12.4638 20.3252 12.2236 20.3112C11.9833 20.2971 11.7497 20.227 11.5413 20.1065C11.333 19.986 11.1558 19.8185 11.0238 19.6172C10.8918 19.4159 10.8087 19.1866 10.7812 18.9475C10.6313 17.5927 10.5578 16.2306 10.5613 14.8675C10.5613 12.9288 10.7013 11.4688 10.7812 10.7875Z" fill="#016FD6"></path></svg><span style=""> Why do Structures Differ?</span></div>
                    <div class="col-sm-6">
                        <div class="custom-progress">
                            <div class="custom-progress-bar"></div>
                        </div>
                    </div>
                </div>

                <br>

                <div class="row">
                    <div class="col-sm-6"><svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium css-1m9ymud-MuiSvgIcon-root" focusable="false" aria-hidden="true" viewBox="0 0 30 30" data-testid="VideoIcon" xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M5 3.75C4.33696 3.75 3.70107 4.01339 3.23223 4.48223C2.76339 4.95107 2.5 5.58696 2.5 6.25V23.75C2.5 24.413 2.76339 25.0489 3.23223 25.5178C3.70107 25.9866 4.33696 26.25 5 26.25H25C25.663 26.25 26.2989 25.9866 26.7678 25.5178C27.2366 25.0489 27.5 24.413 27.5 23.75V6.25C27.5 5.58696 27.2366 4.95107 26.7678 4.48223C26.2989 4.01339 25.663 3.75 25 3.75H5ZM10.7812 10.7875C10.809 10.5485 10.8922 10.3193 11.0242 10.1182C11.1563 9.91711 11.3335 9.74965 11.5418 9.62919C11.75 9.50873 11.9835 9.43861 12.2237 9.42443C12.4639 9.41024 12.704 9.45239 12.925 9.5475C13.555 9.8175 14.885 10.425 16.57 11.3975C17.7542 12.0743 18.8978 12.8197 19.995 13.63C20.1879 13.7735 20.3446 13.9602 20.4525 14.1751C20.5605 14.3899 20.6167 14.627 20.6167 14.8675C20.6167 15.108 20.5605 15.3451 20.4525 15.5599C20.3446 15.7748 20.1879 15.9615 19.995 16.105C18.8977 16.9144 17.7541 17.659 16.57 18.335C15.3921 19.023 14.1751 19.6416 12.925 20.1875C12.704 20.2829 12.4638 20.3252 12.2236 20.3112C11.9833 20.2971 11.7497 20.227 11.5413 20.1065C11.333 19.986 11.1558 19.8185 11.0238 19.6172C10.8918 19.4159 10.8087 19.1866 10.7812 18.9475C10.6313 17.5927 10.5578 16.2306 10.5613 14.8675C10.5613 12.9288 10.7013 11.4688 10.7812 10.7875Z" fill="#016FD6"></path></svg> Models Related to Values</div>
                    <div class="col-sm-6">
                        <div class="custom-progress">
                            <div class="custom-progress-bar" style="background:#4CAF50;"></div>
                        </div>
                    </div>
                </div>

                <br>

                <div class="row">
                    
                    <div class="col-sm-6"><svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium css-1m9ymud-MuiSvgIcon-root" focusable="false" aria-hidden="true" viewBox="0 0 30 30" data-testid="VideoIcon" xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M5 3.75C4.33696 3.75 3.70107 4.01339 3.23223 4.48223C2.76339 4.95107 2.5 5.58696 2.5 6.25V23.75C2.5 24.413 2.76339 25.0489 3.23223 25.5178C3.70107 25.9866 4.33696 26.25 5 26.25H25C25.663 26.25 26.2989 25.9866 26.7678 25.5178C27.2366 25.0489 27.5 24.413 27.5 23.75V6.25C27.5 5.58696 27.2366 4.95107 26.7678 4.48223C26.2989 4.01339 25.663 3.75 25 3.75H5ZM10.7812 10.7875C10.809 10.5485 10.8922 10.3193 11.0242 10.1182C11.1563 9.91711 11.3335 9.74965 11.5418 9.62919C11.75 9.50873 11.9835 9.43861 12.2237 9.42443C12.4639 9.41024 12.704 9.45239 12.925 9.5475C13.555 9.8175 14.885 10.425 16.57 11.3975C17.7542 12.0743 18.8978 12.8197 19.995 13.63C20.1879 13.7735 20.3446 13.9602 20.4525 14.1751C20.5605 14.3899 20.6167 14.627 20.6167 14.8675C20.6167 15.108 20.5605 15.3451 20.4525 15.5599C20.3446 15.7748 20.1879 15.9615 19.995 16.105C18.8977 16.9144 17.7541 17.659 16.57 18.335C15.3921 19.023 14.1751 19.6416 12.925 20.1875C12.704 20.2829 12.4638 20.3252 12.2236 20.3112C11.9833 20.2971 11.7497 20.227 11.5413 20.1065C11.333 19.986 11.1558 19.8185 11.0238 19.6172C10.8918 19.4159 10.8087 19.1866 10.7812 18.9475C10.6313 17.5927 10.5578 16.2306 10.5613 14.8675C10.5613 12.9288 10.7013 11.4688 10.7812 10.7875Z" fill="#016FD6"></path></svg> Attitudes and Behaviour</div>
                    <div class="col-sm-6">
                        <div class="custom-progress">
                            <div class="custom-progress-bar"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- RIGHT SIDEBAR -->
        <div class="col-md-3" text-center>
<button class="btn btn-primary btn-lg btn-block" style="border-radius: 8px; margin-bottom: 15px;">
  Connect with Batchmate
</button>

<button class="btn btn-primary btn-lg btn-block" style="border-radius: 8px; margin-bottom: 15px;">
 Refer & Earn
</button>

           <div class="sidebar-card">
  <h4><strong>Semester Analytics</strong></h4>

  <div class="analytics-item">
    <span>Course Progression</span>
    <div class="progress rounded-progress">
      <div class="progress-bar progress-bar-info" style="width: 60%;"></div>
    </div>
  </div>

  <div class="analytics-item">
    <span>Assignment Marks</span>
    <div class="progress rounded-progress">
      <div class="progress-bar progress-bar-danger" style="width: 0%;"></div>
    </div>
  </div>

  <div class="analytics-item">
    <span>Live Session Attendance</span>
    <div class="progress rounded-progress">
      <div class="progress-bar progress-bar-success" style="width: 11%;"></div>
    </div>
  </div>
</div>
            <div class="sidebar-card">
                <h4><strong>Monthly Challenges</strong></h4>
                <p>Live session streak</p>
                <div class="calendar-box"></div>
            </div>

        </div>

    </div>

</div>

</body>
</html>
