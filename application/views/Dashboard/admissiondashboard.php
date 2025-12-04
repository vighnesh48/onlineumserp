<style>
   .bgn{    background-color: #f9f5d3;
   color: #130000;
   border-radius: 24px;
   font-size: 24px;
   padding: 0px 20px;}
   .icon-primary {
   color: #6eccfe;
   }
   .icon-info {
   color: #68B3C8;
   }
   .icon-red {
   color: #cf0000;
   }
   .icon-aqua{  color: #007f88;}
   .icon-pink{  color: #eb2554;}
   .icon-success {
   color: #4f8689;
   }
   .icon-green{color:#004d83;}
   .icon-warning {
   color: #F3BB45;
   }
   .icon-gray {
   color: #2b3840;
   }
   .icon-danger {
   color: #EB5E28;
   }
   .icon-purple{color:#a7a503;}
   icon-blue{color:#5201b8;}
   hr {
   border-color: #F1EAE0;
   }
   .card .stats {
   color: #a9a9a9;
   font-weight: 400;
   font-size: 17px;
   }
   .card {
   border-radius: 6px;
   box-shadow: 0 2px 12px rgba(130, 119, 100, 0.5);
   background-color: #FFFFFF;
   color: #252422;
   margin-bottom: 20px;
   position: relative;
   z-index: 1;
   }
   .card .image {
   width: 100%;
   overflow: hidden;
   height: 260px;
   border-radius: 6px 6px 0 0;
   position: relative;
   -webkit-transform-style: preserve-3d;
   -moz-transform-style: preserve-3d;
   transform-style: preserve-3d;
   }
   .card .image img {
   width: 100%;
   }
   .card .content {
   padding: 15px 15px 10px 15px;
   }
   .card .header {
   padding: 20px 20px 0;
   }
   .card .description {
   font-size: 16px;
   color: #66615b;
   }
   .card h6 {
   font-size: 12px;
   margin: 0;
   }
   .card .category,
   .card label {
   font-size: 14px;
   font-weight: 400;
   color: #9A9A9A;
   margin-bottom: 0px;
   }
   .card .category i,
   .card label i {
   font-size: 16px;
   }
   .card label {
   font-size: 15px;
   margin-bottom: 5px;
   }
   .card .title {
   margin: 0;
   color: #252422;
   font-weight: 300;
   }
   .card .avatar {
   width: 50px;
   height: 50px;
   overflow: hidden;
   border-radius: 50%;
   margin-right: 5px;
   }
   .card .footer {
   padding: 0;
   line-height: 30px;
   }
   .card .footer .legend {
   padding: 5px 0;
   }
   .card .footer hr {
   margin-top: 5px;
   margin-bottom: 5px;
   }
   .card .footer div {
   display: inline-block;
   }
   .card .author {
   font-size: 12px;
   font-weight: 600;
   text-transform: uppercase;
   }
   .card .author i {
   font-size: 14px;
   }
   .card.card-separator:after {
   height: 100%;
   right: -15px;
   top: 0;
   width: 1px;
   background-color: #DDDDDD;
   content: "";
   position: absolute;
   }
   .card .ct-chart {
   margin: 30px 0 30px;
   height: 245px;
   }
   .card .table tbody td:first-child,
   .card .table thead th:first-child {
   padding-left: 15px;
   }
   .card .table tbody td:last-child,
   .card .table thead th:last-child {
   padding-right: 15px;
   }
   .card .alert {
   border-radius: 4px;
   position: relative;
   }
   .card .alert.alert-with-icon {
   padding-left: 65px;
   }
   .card .icon-big {
   font-size: 3em;
   min-height: 64px;
   }
   .card .numbers {
   font-size: 2em;
   text-align: right;
   }
   .card .numbers p {
   margin: 0;
   font-size: 17px;
   color: #adb5b1;
   }
   .card ul.team-members li {
   padding: 10px 0px;
   }
   .card ul.team-members li:not(:last-child) {
   border-bottom: 1px solid #F1EAE0;
   }
   .card-user .image {
   border-radius: 8px 8px 0 0;
   height: 150px;
   position: relative;
   overflow: hidden;
   }
   .card-user .image img {
   width: 100%;
   }
   .card-user .image-plain {
   height: 0;
   margin-top: 110px;
   }
   .card-user .author {
   text-align: center;
   text-transform: none;
   margin-top: -65px;
   }
   .card-user .author .title {
   color: #403D39;
   }
   .card-user .author .title small {
   color: #ccc5b9;
   }
   .card-user .avatar {
   width: 100px;
   height: 100px;
   border-radius: 50%;
   position: relative;
   margin-bottom: 15px;
   }
   .card-user .avatar.border-white {
   border: 5px solid #FFFFFF;
   }
   .card-user .avatar.border-gray {
   border: 5px solid #ccc5b9;
   }
   .card-user .title {
   font-weight: 600;
   line-height: 24px;
   }
   .card-user .description {
   margin-top: 10px;
   }
   .card-user .content {
   min-height: 200px;
   }
   .card-user.card-plain .avatar {
   height: 190px;
   width: 190px;
   }
   .card-map .map {
   height: 500px;
   padding-top: 20px;
   }
   .card-map .map > div {
   height: 100%;
   }
   .card-user .footer,
   .card-price .footer {
   padding: 5px 15px 10px;
   }
   .card-user hr,
   .card-price hr {
   margin: 5px 15px;
   }
   .card-plain {
   background-color: transparent;
   box-shadow: none;
   border-radius: 0;
   }
   .card-plain .image {
   border-radius: 4px;
   }
   .ct-label {
   fill: rgba(0, 0, 0, 0.4);
   color: rgba(0, 0, 0, 0.4);
   font-size: 0.9em;
   line-height: 1;
   }
   .ct-chart-line .ct-label,
   .ct-chart-bar .ct-label {
   display: block;
   display: -webkit-box;
   display: -moz-box;
   display: -ms-flexbox;
   display: -webkit-flex;
   display: flex;
   }
   @media (min-width: 992px) {
   .card form [class*="col-"] {
   padding: 6px;
   }
   .card form [class*="col-"]:first-child {
   padding-left: 15px;
   }
   .card form [class*="col-"]:last-child {
   padding-right: 15px;
   }
   }
</style>
<script>
   var init = [];
</script>
<?php
$finalAdmissionCount = $this->data['finalAdmissionCount'];
$academicYear = $this->data['academicYear'];
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Admission</a></li>
        <li class="active"><a href="#">Dashboard</a></li>
    </ul>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel widget-support-tickets">
                <div class="panel-heading">
                    <p class="active"><b><a href="<?=base_url()?>dashboard/superadmin/2020" style="color: #fd0b13;font-size:16px;">Academic Year: <?php echo currentSuccessiveYear($academicYear); ?></a></b></p>
                </div>
                <!-- / .panel-heading -->
                <div class="panel-body" style="background-color: #f4f3ef;">
                    <div class="row">
                        <?php foreach ($finalAdmissionCount as $admissionCount) { ?>
                        <div class="col-lg-3 col-sm-6">
                            <div class="card schoolCard">
                                <div class="content">
                                    <div class="row">
                                        <div class="col-xs-5">
                                            <?php echo "<div class='".getColorForSchool($admissionCount['school_short_name'])."'>"; ?>
                                                <i class='fa fa-graduation-cap' style='font-size:48px'></i>
                                                <i class='fa fa-user' style='font-size:48px'></i>
                                            </div>
                                        </div>
                                        <div class="col-xs-7">
                                            <div class="numbers">
                                                <p>Admission</p>
                                                <span class="bgn">
                                                <?php 
                                                echo ($admissionCount['admissionCount']) ? $admissionCount['admissionCount'] : 0;
                                                ?>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="footer" id="test">
                                        <hr>
                                        <div class="stats">
                                            <?php echo $admissionCount['school_short_name']; ?>
                                        </div>
                                        <input class="school_short_name hidden" value="<?php echo $admissionCount['school_short_name']; ?>"/>
                                        <input class="admissionCount hidden" value="<?php echo $admissionCount['admissionCount']; ?>"/>
                                        <input class="school_id hidden" value="<?php echo $admissionCount['school_id']; ?>"/>
                                        <input class="is_active hidden" value="<?php echo $admissionCount['is_active']; ?>"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                      <?php } ?>
                    </div>
                    <!-- / .panel-body -->
                </div>
            </div>
        </div>
    </div>
</div>

<div id="main-menu-bg"></div>
<script>
    $(".schoolCard").click(function(){
      $school_short_name = $(this).find(".school_short_name").val();
      $admissionCount = $(this).find(".admissionCount").val();
      $school_id = $(this).find(".school_id").val();
      $is_active = $(this).find(".is_active").val();
      $academicYear = "<?php echo $academicYear ?>";

      window.location = '<?=base_url() ?>' + 'Currentyearadmission/index?school_id=' + $school_id + '&academicYear=' + $academicYear;
    });
</script>