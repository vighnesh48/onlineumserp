

<style>
@keyframes shake {
  0% { transform: translateX(0px); }
  25% { transform: translateX(-4px); }
  50% { transform: translateX(4px); }
  75% { transform: translateX(-4px); }
  100% { transform: translateX(0px); }
}

.shake-alert {
    animation: shake 0.6s ease-in-out 1;
}

.blink-border {
    border: 2px solid #ffbf00 !important;
}
</style>
<div class="layout">

<!-- SIDEBAR -->


<!-- MAIN CONTENT -->
<div style="flex-grow:1;">

  <!-- TOPBAR -->




  <!-- PAGE CONTENT -->
  <div class="container-fluid" style="padding:40px 25px;">

    <div class="row">

      <!-- LEFT SECTION -->
      <div class="col-md-9">

        <!-- HERO BOX -->
        <div class="hero-box">
          <div>
            <h3>New Exams Available Now!</h3>
            <p>Welcome to the latest exams. Check your performance and boost your score with new practice sets.</p>
            <button class="hero-btn">Explore More →</button>
          </div>
          <img src="https://i.imgur.com/4AiXzf8.png" width="150">
        </div>

        <!-- LESSONS -->
        <div class="lessons-section">
          <div class="clearfix" style="margin-bottom:10px;">
            <h4 style="float:left; margin:0;">Popular Lessons</h4>
            <button class="btn btn-sm" style="background:#1c8eb3; color:#fff; float:right; border-radius:25px;">View All</button>
          </div>

          <div class="row">
            
            <!-- Repeat Cards -->
            <div class="col-md-6">
              <div class="lesson-card">
                <div class="progress-circle">72%</div>
                <div style="flex-grow:1;">
                  <strong>Cardiovascular Pro Exam</strong><br>
                  <small class="text-muted">12 Topics • 200 Students • 03/29/2023</small>
                </div>
                <button class="btn btn-sm" style="background:#1c8eb3; color:#fff; border-radius:25px;">Enroll Now</button>
              </div>
            </div>

            <!-- Duplicate 7 Times (same layout from original) -->
            <div class="col-md-6">
              <div class="lesson-card">
                <div class="progress-circle">72%</div>
                <div style="flex-grow:1;">
                  <strong>Cardiovascular Pro Exam</strong><br>
                  <small class="text-muted">12 Topics • 200 Students • 03/29/2023</small>
                </div>
                <button class="btn btn-sm" style="background:#1c8eb3; color:#fff; border-radius:25px;">Enroll Now</button>
              </div>
            </div>

            <div class="col-md-6">
              <div class="lesson-card">
                <div class="progress-circle">72%</div>
                <div style="flex-grow:1;">
                  <strong>Cardiovascular Pro Exam</strong><br>
                  <small class="text-muted">12 Topics • 200 Students • 03/29/2023</small>
                </div>
                <button class="btn btn-sm" style="background:#1c8eb3; color:#fff; border-radius:25px;">Enroll Now</button>
              </div>
            </div>

            <div class="col-md-6">
              <div class="lesson-card">
                <div class="progress-circle">72%</div>
                <div style="flex-grow:1;">
                  <strong>Cardiovascular Pro Exam</strong><br>
                  <small class="text-muted">12 Topics • 200 Students • 03/29/2023</small>
                </div>
                <button class="btn btn-sm" style="background:#1c8eb3; color:#fff; border-radius:25px;">Enroll Now</button>
              </div>
            </div>
			 <div class="col-md-6">
              <div class="lesson-card">
                <div class="progress-circle">72%</div>
                <div style="flex-grow:1;">
                  <strong>Cardiovascular Pro Exam</strong><br>
                  <small class="text-muted">12 Topics • 200 Students • 03/29/2023</small>
                </div>
                <button class="btn btn-sm" style="background:#1c8eb3; color:#fff; border-radius:25px;">Enroll Now</button>
              </div>
            </div>
			
			
			 <div class="col-md-6">
              <div class="lesson-card">
                <div class="progress-circle">72%</div>
                <div style="flex-grow:1;">
                  <strong>Cardiovascular Pro Exam</strong><br>
                  <small class="text-muted">12 Topics • 200 Students • 03/29/2023</small>
                </div>
                <button class="btn btn-sm" style="background:#1c8eb3; color:#fff; border-radius:25px;">Enroll Now</button>
              </div>
            </div>
			
			
			
			
			
			
			

          </div>

        </div>

      </div>

      <!-- RIGHT SIDE -->
      <div class="col-md-3">

        <!-- RANK BOX -->
        <!--div class="rank-box">
          <div class="clearfix" style="margin-bottom:10px;">
            <strong style="float:left;">My ranking</strong>
            <button class="btn btn-sm" style="background:#1c8eb3; color:#fff; float:right; border-radius:25px;">View All</button>
          </div>

          <div class="rank-user">
            <img src="https://randomuser.me/api/portraits/men/60.jpg">
            <div><strong>Joe Doe</strong><br><small>50th</small></div>
          </div>

          <div class="rank-user">
            <img src="https://randomuser.me/api/portraits/women/65.jpg">
            <div>Bella<br><small>1st</small></div>
          </div>
        </div-->
	<div class="rank-box" style="background:#fff; padding:20px; border-radius:18px; box-shadow:0 3px 10px rgba(0,0,0,0.15);" id="notifBox">

    <div class="clearfix" style="margin-bottom:10px;">
        <strong style="float:left; font-size:18px;color:#004aad;">📢 Notifications</strong>

        <button id="toggleNotif" class="btn btn-sm" 
        style="background:#1c8eb3; color:#fff; float:right; border-radius:25px;">
        View
        </button>
    </div>

    <!-- Content initially hidden -->
    <div id="notifContent" style="display:none;">
        
        <?php if(!empty($notifications)) { ?>
            <?php foreach($notifications as $row){ ?>
                <div class="rank-user" style="display:flex; align-items:center; gap:12px; padding:12px 0; border-bottom:1px solid #eee;">
                    <img src="<?= base_url('assets/images/bell-icon.png') ?>" style="width:32px;height:32px;">
                    <div style="flex-grow:1;">
                        <strong><?= $row['subject']; ?></strong><br>
                        <small><?= $row['description']; ?></small>
                        <?php if(!empty($row['notification_url'])) { ?>
                            <br><a href="<?= $row['notification_url'] ?>" target="_blank" style="color:#0078d7;font-weight:600;">Open Link</a>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        <?php } else { ?>

        <div style="padding:15px; text-align:center; color:#777; font-size:15px;">
            <i class="glyphicon glyphicon-info-sign" style="color:#0078d7;"></i>
            No notifications available currently
        </div>

        <?php } ?>
    </div>
</div>





        <!-- BAR CHART -->
        <div class="chart-box">
          <h4>Your exam progress</h4>

          <div style="height:180px; display:flex; justify-content:space-around; align-items:flex-end;">

            <div>
              <div class="bar" style="height:110px; background:#2ba2c8;"></div>
              <small>1 w</small>
            </div>

            <div>
              <div class="bar" style="height:150px; background:#1c6f8a;"></div>
              <small>2 w</small>
            </div>

            <div>
              <div class="bar" style="height:190px; background:#2ba2c8;"></div>
              <small>3 w</small>
            </div>

          </div>

        </div>

      </div>

    </div>

  </div>


  <!-- PAGE CONTENT -->
</div>

</div>
<script>
$(document).ready(function() {

    //  By default = closed
    $("#notifContent").hide();
    $("#toggleNotif").text("View");

    // If notifications exist -> shake to attract attention
    <?php if(!empty($notifications)) { ?>
        $("#notifBox").addClass("shake-alert blink-border");
        setTimeout(function(){
            $("#notifBox").removeClass("shake-alert");
        }, 800);
    <?php } ?>

    // Toggle Show / Hide
    $("#toggleNotif").click(function(){
        let content = $("#notifContent");

        if(content.is(":visible")){
            content.slideUp();
            $(this).text("View");
        } else {
            content.slideDown();
            $(this).text("Close");
        }
    });

});
</script>