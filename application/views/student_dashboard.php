
<style>
    /* Base Styles */
    body {
        background: #f5f7fa;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        padding: 0;
        margin: 0;
        overflow-x: hidden;
    }
    
    /* Main Container */
    .main-container {
        display: flex;
        min-height: calc(100vh - 60px); /* Adjust based on your header height */
    }
    
    /* Content Wrapper - This will be next to the sidebar */
    .content-wrapper {
        flex: 1;
        padding: 20px 0 20px 20px;
        margin-left: 230px; /* Width of the sidebar */
        transition: all 0.3s;
        max-width: calc(100% - 230px); /* Adjust based on sidebar width */
    }
    
    /* Responsive adjustments */
    @media (max-width: 992px) {
        .content-wrapper {
            margin-left: 0;
            max-width: 100%;
            padding: 20px 15px;
        }
    }
    
    /* Card Styles */
    .card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        margin-bottom: 20px;
        border: 1px solid #e8eef3;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .card-header {
        border-bottom: 1px solid #e8eef3;
        padding: 18px 25px;
        display: flex;
        align-items: center;
        background: #fff;
        border-radius: 12px 12px 0 0;
    }
    
    .card-header h3 {
        margin: 0;
        font-size: 16px;
        font-weight: 600;
        color: #2d3b4e;
        display: flex;
        align-items: center;
    }
    
    .card-header i {
        margin-right: 12px;
        color: #1a8eb4;
        font-size: 18px;
    }
    
    .card-body {
        padding: 25px;
    }
    
    /* Welcome Banner */
    .welcome-banner {
        background: linear-gradient(135deg, #1a8eb4, #2fb3d8);
        color: white;
        padding: 30px;
        border-radius: 12px;
        margin-bottom: 25px;
        position: relative;
        overflow: hidden;
    }
    
    .welcome-banner::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 300px;
        height: 300px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
        pointer-events: none;
    }
    
    .welcome-banner h2 {
        margin: 0 0 10px 0;
        font-weight: 600;
        font-size: 24px;
        position: relative;
    }
    
    .welcome-banner p {
        margin: 0;
        opacity: 0.9;
        font-size: 15px;
        max-width: 500px;
        position: relative;
    }
    
    /* Progress Section */
    .progress-section {
        background: linear-gradient(135deg, #e3f5ff, #b8e3ff);
        border-radius: 12px;
        padding: 25px;
        margin-bottom: 30px;
        position: relative;
        overflow: hidden;
    }
    
    .progress-text {
        font-size: 15px;
        margin-bottom: 12px;
        color: #2d3b4e;
        font-weight: 500;
        position: relative;
    }
    
    .progress-time {
        font-size: 14px;
        color: #5a6b82;
        margin-bottom: 20px;
        position: relative;
    }
    
    .progress {
        height: 8px;
        background-color: rgba(255,255,255,0.5);
        border-radius: 4px;
        overflow: visible;
        margin-bottom: 10px;
        box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
    }
    
    .progress-bar {
        background: linear-gradient(90deg, #1a8eb4, #2fb3d8);
        border-radius: 4px;
        position: relative;
        overflow: visible;
    }
    
    .progress-bar::after {
        content: '';
        position: absolute;
        right: 0;
        top: 0;
        height: 100%;
        width: 20px;
        background: rgba(255,255,255,0.3);
        transform: skewX(-15deg);
        animation: progressShine 2s infinite;
    }
    
    @keyframes progressShine {
        0% { right: 100%; }
        100% { right: -20px; }
    }
    
    /* Lecture Card */
    .lecture-card {
        display: flex;
        margin-bottom: 20px;
        padding-bottom: 20px;
        border-bottom: 1px solid #f0f4f8;
        transition: all 0.3s ease;
    }
    
    .lecture-card:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }
    
    .lecture-card:hover {
        transform: translateX(5px);
    }
    
    .lecture-thumb {
        width: 120px;
        height: 70px;
        border-radius: 8px;
        background-color: #f0f4f8;
        background-size: cover;
        background-position: center;
        margin-right: 20px;
        flex-shrink: 0;
        position: relative;
        overflow: hidden;
    }
    
    .lecture-thumb::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(26, 142, 180, 0.2);
        opacity: 0;
        transition: opacity 0.3s;
    }
    
    .lecture-card:hover .lecture-thumb::before {
        opacity: 1;
    }
    
    .lecture-thumb i {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: white;
        font-size: 24px;
        opacity: 0;
        transition: all 0.3s;
    }
    
    .lecture-card:hover .lecture-thumb i {
        opacity: 1;
    }
    
    .lecture-info {
        flex-grow: 1;
        min-width: 0;
    }
    
    .lecture-title {
        font-weight: 500;
        margin: 0 0 8px 0;
        color: #2d3b4e;
        font-size: 15px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .lecture-meta {
        font-size: 13px;
        color: #8a94a6;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
    }
    
    .lecture-meta i {
        margin-right: 5px;
        font-size: 14px;
    }
    
    /* Buttons */
    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 8px 16px;
        font-size: 13px;
        border-radius: 8px;
        border: 1px solid transparent;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.3s;
        font-weight: 500;
        letter-spacing: 0.3px;
    }
    
    .btn i {
        margin-right: 6px;
        font-size: 14px;
    }
    
    .btn-sm {
        padding: 6px 12px;
        font-size: 12px;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #1a8eb4, #2fb3d8);
        border: none;
        color: white;
        box-shadow: 0 2px 5px rgba(26, 142, 180, 0.3);
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(26, 142, 180, 0.4);
    }
    
    .btn-outline-primary {
        color: #1a8eb4;
        border: 1px solid #1a8eb4;
        background: transparent;
    }
    
    .btn-outline-primary:hover {
        background: linear-gradient(135deg, #1a8eb4, #2fb3d8);
        color: white;
        border-color: transparent;
    }
    
    .btn-block {
        display: flex;
        width: 100%;
        margin-bottom: 15px;
        justify-content: center;
    }
    
    /* Progress Items */
    .progress-item {
        margin-bottom: 20px;
    }
    
    .progress-item:last-child {
        margin-bottom: 0;
    }
    
    .progress-label {
        display: flex;
        justify-content: space-between;
        margin-bottom: 8px;
        font-size: 14px;
    }
    
    .progress-percent {
        font-weight: 600;
        color: #2d3b4e;
    }
    
    /* Sidebar Cards */
    .sidebar-card {
        margin-bottom: 25px;
    }
    
    /* Calendar */
    .calendar {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 6px;
        text-align: center;
        margin-bottom: 20px;
    }
    
    .calendar-day {
        padding: 6px;
        font-size: 13px;
        border-radius: 6px;
        transition: all 0.2s;
    }
    
    .calendar-day:hover:not(.inactive) {
        background: #f0f7fb;
    }
    
    .calendar-day.active {
        background: linear-gradient(135deg, #1a8eb4, #2fb3d8);
        color: white;
        font-weight: 600;
        box-shadow: 0 2px 5px rgba(26, 142, 180, 0.3);
    }
    
    .calendar-day.inactive {
        color: #ccc;
    }
    
    .calendar-day-header {
        font-weight: 600;
        color: #5a6b82;
        font-size: 12px;
        text-transform: uppercase;
        padding: 8px 0;
        margin-bottom: 5px;
    }
    
    /* Responsive Adjustments */
    @media (max-width: 1200px) {
        .content-wrapper {
            padding: 15px 0 15px 15px;
            margin-left: 200px;
            max-width: calc(100% - 200px);
        }
    }
    
    @media (max-width: 992px) {
        .content-wrapper {
            margin-left: 0;
            max-width: 100%;
            padding: 15px;
        }
        
        .welcome-banner h2 {
            font-size: 22px;
        }
        
        .card-header {
            padding: 15px 20px;
        }
        
        .card-body {
            padding: 20px;
        }
        
        .lecture-card {
            flex-direction: column;
        }
        
        .lecture-thumb {
            width: 100%;
            height: 160px;
            margin-bottom: 15px;
            margin-right: 0;
        }
    }
    
    @media (max-width: 768px) {
        .welcome-banner {
            padding: 25px 20px;
        }
        
        .welcome-banner h2 {
            font-size: 20px;
        }
        
        .btn {
            padding: 7px 14px;
            font-size: 12px;
        }
        
        .progress-section {
            padding: 20px;
        }
    }
    
    @media (max-width: 576px) {
        .welcome-banner h2 {
            font-size: 18px;
        }
        
        .card-header {
            padding: 12px 15px;
        }
        
        .card-body {
            padding: 15px;
        }
        
        .btn {
            width: 100%;
            margin-bottom: 8px;
        }
        
        .btn-group .btn {
            width: auto;
        }
    }
    
    /* Animation for cards */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .card {
        animation: fadeInUp 0.5s ease-out;
        animation-fill-mode: both;
    }
    
    /* Add delay for each card */
    .card:nth-child(1) { animation-delay: 0.1s; }
    .card:nth-child(2) { animation-delay: 0.2s; }
    .card:nth-child(3) { animation-delay: 0.3s; }
    .card:nth-child(4) { animation-delay: 0.4s; }
</style>

<div class="main-container">
    <div class="content-wrapper">
        <div class="container-fluid" style="padding: 0;">
            <!-- Welcome Banner -->
            <div class="welcome-banner">
                <h2>Welcome back, <?php echo $this->session->userdata('emp_name') ?: 'Student'; ?>!</h2>
                <p>Let's continue your learning journey together!</p>
            </div>
            
            <!-- Progress Section -->
            <div class="progress-section">
                <div class="progress-text">
                    <strong>43% of your batch mates have completed this assignment</strong>
                </div>
                <div class="progress-time">6 Days • 9 Hrs • 42 Mins left to complete. 18 Assignments Pending</div>
                <div class="progress">
                    <div class="progress-bar" style="width: 43%"></div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-8">
                    <!-- Latest Card -->
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-bell"></i>
                            <h3>Latest</h3>
                        </div>
                        <div class="card-body">
                            <h4 style="font-size: 16px; margin-bottom: 15px; color: #2d3b4e;">Why do Structures Differ?</h4>
                            <div class="btn-group">
                                <button class="btn btn-primary">
                                    <i class="fa fa-play-circle"></i> View Recording
                                </button>
                                <button class="btn btn-outline-primary">
                                    <i class="fa fa-magic"></i> Summarize with AI
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Recent Lectures -->
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-video"></i>
                            <h3>Recent Lectures</h3>
                        </div>
                        <div class="card-body">
                            <div class="lecture-card">
                                <div class="lecture-thumb" style="background-image: url('https://lms.dypatiledu.com/assets/lecture-card-image.svg');">
                                    <i class="fa fa-play-circle"></i>
                                </div>
                                <div class="lecture-info">
                                    <h4 class="lecture-title">Why do Structures Differ?</h4>
                                    <div class="lecture-meta">
                                        <i class="fa fa-book"></i> Organizational Behavior • <i class="fa fa-clock-o"></i> 45 min
                                    </div>
                                    <div class="btn-group">
                                        <button class="btn btn-primary btn-sm">Watch</button>
                                        <button class="btn btn-outline-primary btn-sm">Summarize</button>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="lecture-card">
                                <div class="lecture-thumb" style="background-image: url('https://lms.dypatiledu.com/assets/lecture-card-image.svg');">
                                    <i class="fa fa-play-circle"></i>
                                </div>
                                <div class="lecture-info">
                                    <h4 class="lecture-title">Organization Structure</h4>
                                    <div class="lecture-meta">
                                        <i class="fa fa-book"></i> Organizational Behavior • <i class="fa fa-clock-o"></i> 1 hr 15 min
                                    </div>
                                    <div class="btn-group">
                                        <button class="btn btn-primary btn-sm">Watch</button>
                                        <button class="btn btn-outline-primary btn-sm">Summarize</button>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="lecture-card" style="border-bottom: none; margin-bottom: 0; padding-bottom: 0;">
                                <div class="lecture-thumb" style="background-image: url('https://lms.dypatiledu.com/assets/lecture-card-image.svg');">
                                    <i class="fa fa-play-circle"></i>
                                </div>
                                <div class="lecture-info">
                                    <h4 class="lecture-title">Organizational Culture</h4>
                                    <div class="lecture-meta">
                                        <i class="fa fa-book"></i> Organizational Behavior • <i class="fa fa-clock-o"></i> 30 min
                                    </div>
                                    <div class="btn-group">
                                        <button class="btn btn-primary btn-sm">Watch</button>
                                        <button class="btn btn-outline-primary btn-sm">Summarize</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Continue Learning -->
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-book"></i>
                            <h3>Continue Learning</h3>
                        </div>
                        <div class="card-body">
                            <div class="progress-item">
                                <div class="progress-label">
                                    <span>Why do Structures Differ?</span>
                                    <span class="progress-percent">65%</span>
                                </div>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar" style="width: 65%"></div>
                                </div>
                            </div>
                            
                            <div class="progress-item">
                                <div class="progress-label">
                                    <span>Organization Structure</span>
                                    <span class="progress-percent">40%</span>
                                </div>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar" style="width: 40%"></div>
                                </div>
                            </div>
                            
                            <div class="progress-item" style="margin-bottom: 0;">
                                <div class="progress-label">
                                    <span>Organizational Culture</span>
                                    <span class="progress-percent">25%</span>
                                </div>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar" style="width: 25%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Sidebar -->
                <div class="col-md-4">
                    <!-- Action Buttons -->
                    <button class="btn btn-primary btn-block">
                        <i class="fa fa-users"></i> Connect with Batchmate
                    </button>
                    <button class="btn btn-outline-primary btn-block">
                        <i class="fa fa-gift"></i> Refer & Earn
                    </button>
                    
                    <!-- Semester Analytics -->
                    <div class="card sidebar-card">
                        <div class="card-header">
                            <i class="fa fa-chart-bar"></i>
                            <h3>Semester Analytics</h3>
                        </div>
                        <div class="card-body">
                            <div class="progress-item">
                                <div class="progress-label">
                                    <span>Course Progression</span>
                                    <span class="progress-percent">65%</span>
                                </div>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar" style="width: 65%"></div>
                                </div>
                            </div>
                            
                            <div class="progress-item">
                                <div class="progress-label">
                                    <span>Assignment Marks</span>
                                    <span class="progress-percent">78%</span>
                                </div>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar" style="width: 78%"></div>
                                </div>
                            </div>
                            
                            <div class="progress-item" style="margin-bottom: 0;">
                                <div class="progress-label">
                                    <span>Live Session Attendance</span>
                                    <span class="progress-percent">92%</span>
                                </div>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar" style="width: 92%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Monthly Challenges -->
                    <div class="card sidebar-card">
                        <div class="card-header">
                            <i class="fa fa-trophy"></i>
                            <h3>Monthly Challenges</h3>
                        </div>
                        <div class="card-body">
                            <div style="font-size: 14px; color: #5a6b82; margin-bottom: 15px; font-weight: 500;">
                                <i class="fa fa-fire" style="color: #ff6b6b; margin-right: 5px;"></i> Live session streak
                            </div>
                            
                            <div class="calendar">
                                <!-- Calendar Headers -->
                                <div class="calendar-day-header">S</div>
                                <div class="calendar-day-header">M</div>
                                <div class="calendar-day-header">T</div>
                                <div class="calendar-day-header">W</div>
                                <div class="calendar-day-header">T</div>
                                <div class="calendar-day-header">F</div>
                                <div class="calendar-day-header">S</div>
                                
                                <!-- Calendar Days -->
                                <div class="calendar-day inactive">30</div>
                                <div class="calendar-day inactive">31</div>
                                <div class="calendar-day">1</div>
                                <div class="calendar-day">2</div>
                                <div class="calendar-day">3</div>
                                <div class="calendar-day">4</div>
                                <div class="calendar-day">5</div>
                                
                                <div class="calendar-day">6</div>
                                <div class="calendar-day">7</div>
                                <div class="calendar-day">8</div>
                                <div class="calendar-day">9</div>
                                <div class="calendar-day">10</div>
                                <div class="calendar-day">11</div>
                                <div class="calendar-day">12</div>
                                
                                <div class="calendar-day">13</div>
                                <div class="calendar-day">14</div>
                                <div class="calendar-day">15</div>
                                <div class="calendar-day">16</div>
                                <div class="calendar-day">17</div>
                                <div class="calendar-day">18</div>
                                <div class="calendar-day">19</div>
                                
                                <div class="calendar-day">20</div>
                                <div class="calendar-day">21</div>
                                <div class="calendar-day">22</div>
                                <div class="calendar-day active">23</div>
                                <div class="calendar-day active">24</div>
                                <div class="calendar-day">25</div>
                                <div class="calendar-day">26</div>
                                
                                <div class="calendar-day">27</div>
                                <div class="calendar-day">28</div>
                                <div class="calendar-day">29</div>
                                <div class="calendar-day">30</div>
                                <div class="calendar-day inactive">1</div>
                                <div class="calendar-day inactive">2</div>
                                <div class="calendar-day inactive">3</div>
                            </div>
                            
                            <div style="display: flex; justify-content: space-between; margin-top: 20px; font-size: 12px; color: #5a6b82;">
                                <div style="display: flex; align-items: center;">
                                    <span style="display: inline-block; width: 12px; height: 12px; background: linear-gradient(135deg, #1a8eb4, #2fb3d8); border-radius: 2px; margin-right: 8px;"></span>
                                    <span>Attended</span>
                                </div>
                                <div style="display: flex; align-items: center;">
                                    <span style="display: inline-block; width: 12px; height: 12px; background: #e0e6ed; border-radius: 2px; margin-right: 8px;"></span>
                                    <span>Not Attended</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

