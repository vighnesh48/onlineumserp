<!DOCTYPE html>
<!--[if IE 8]>         <html class="ie8"> <![endif]-->
<!--[if IE 9]>         <html class="ie9 gt-ie8"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="gt-ie8 gt-ie9 not-ie"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Online Education Sandip University ERP System</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">	
	<!--<link href="<?=base_url()?>assets/stylesheets/google.api.css" rel="stylesheet" type="text/css">-->
    <link rel="shortcut icon" type="image/ico" href="<?=base_url()?>assets/images/favicon.ico"/>
<!-- BOOTSTRAP 3 -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

<!-- POPPINS FONT -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">	
	<link rel="stylesheet" href="<?=base_url()?>assets/css/all_minified.css">

	<!--[if lt IE 9]>
		<script src="<?=base_url()?>assets/javascripts/ie.min.js"></script>
	<![endif]-->
                                      
        
        <script src="<?=base_url()?>assets/javascripts/all_minified_js.js"></script>
        <script src="<?=base_url()?>assets/javascripts/common.js"></script>
        <script src="<?=base_url()?>assets/javascripts/default.js"></script>
		
		<!-- Toastr CSS for Project-->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
		<!-- Toastr JS -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
		
        <!--script src="<?=base_url()?>assets/javascripts/jquery.multiple.select.js"></script>
        <script src="<?=base_url()?>assets/javascripts/select2.min.js"></script>
        <script src="<?=base_url('assets/javascripts')?>/bootstrap-datepicker.js "></script>

        <script src="<?=base_url('assets/javascripts')?>/jquery.dataTables.min.js"></script>
		<script src="<?=base_url('assets/javascripts')?>/dataTables.bootstrap.min.js"></script>
		<script src="<?=base_url('assets/javascripts')?>/dataTables.buttons.min.js"></script>
		<script src="<?=base_url('assets/javascripts')?>/jszip.min.js"></script>
		<script src="<?=base_url('assets/javascripts')?>/pdfmake.min.js"></script>
		<script src="<?=base_url('assets/javascripts')?>/vfs_fonts.js"></script>
		<script src="<?=base_url('assets/javascripts')?>/buttons.html5.min.js"></script>
        <!--<script src="<?=base_url()?>assets/javascripts/jquery.dataTables.min.js"></script>-->
        <script type='text/javascript'>
            var base_url = '<?=base_url()?>';
		</script>
		<style>
		#main-navbar .navbar-brand div img{width:180px;height: auto;}
		#main-navbar .navbar-brand{line-height:0px !important;height: 46px !important;}
		#ui-id-1{
		z-index: 9999!important;	
		}
		 .logo-light {
        width:330px;
    }

		 @media (max-width: 991px) {
    .logo-light {
        width: 270px;
    }
}
    .theme-default #main-menu-bg {
    background-color: #23272d!important;
    width: 250px!important;
    background: #fff!important;
    padding: 30px 20px!important;
    border-right: 1px solid #e7edf5!important;
}

.theme-default #main-menu .mm-dropdown.active>a {

    background: #e8f6ff!important;
    color: #167ea5!important;
}
.theme-default #main-menu .mmc-dropdown-open-ul a, .theme-default #main-menu .navigation a {
    color: #808b9c!important;
    position: relative;
    -webkit-transition: all .2s;
    transition: all .2s;
    display: flex!important;
    align-items: center!important;
    padding: 12px 12px!important;
    margin-bottom: 5px!important;
    border-radius: 10px!important;
    cursor: pointer;
    font-weight: 500!important;
    color: #1d334a!important;
}
 .theme-default #main-menu .navigation a:after {
    content: "";
    top: 0;
    bottom: 0;
    width: 4px;
    position: absolute;
    right: auto;
  background:none!important;
    display: none;
    left: 0;
}
.theme-default #main-menu li.active>a {
    background: #93e4fd!important;
    color: #fff!important;
}
#main-menu .mmc-dropdown-open-ul .menu-icon, #main-menu .navigation .menu-icon {
    display: inline-block!important;
    margin-right: 5px!important;
    line-height: 48px!important;
    height: 48px!important;
    width: 48px!important;
    text-align: center!important;
    font-size: 26px!important;
}
.theme-default #main-menu .mm-dropdown>ul, .theme-default #main-menu .mmc-dropdown-open-ul {
       color: #808b9c!important;
    position: relative;
    -webkit-transition: all .2s;
    transition: all .2s;
    align-items: center!important;
    padding: 12px 12px!important;
    margin-bottom: 5px!important;
    border-radius: 10px!important;
    cursor: pointer;
	    background: #e8f6ff!important;
    color: #167ea5!important;
    font-weight: 500!important;
    color: #1d334a!important;
}
#main-menu .mm-dropdown > a::before {
    content: "";
    display: block;
    font-family: FontAwesome;
    font-size: 19px!important;
    line-height: 10px;
    height: 10px;
    width: 10px;
    right: 14px;
    top: 34px!important;
    position: absolute;
    text-align: center;
    margin: 0px;
    transition: 300ms ease-in-out;
}
.theme-default #main-menu .menu-content {
    border-color: #ffffff!important;
}
.theme-default #main-menu li.active>a {
    background: #c7e7f1 !important;
    color: #000000 !important;

#main-menu .mmc-dropdown-open-ul .menu-icon, #main-menu .navigation .menu-icon {
    display: inline-block !important;
    margin-right: 5px !important;
    line-height: 48px !important;
    height: 48px !important;
    width: 48px !important;
    text-align: center !important;
    font-size: 26px !important;
    color: #1d89cf !important;
	color: #1d89cf!important;
}
.menu-icon {

    background: #f5faff!important;

}

		</style>
		<style>
body { font-family: 'Poppins', sans-serif; background:#f2f7fd;font-size:16px }
.layout { display:flex; border-radius:20px; overflow:hidden; margin:25px; background:#fff; box-shadow:0 8px 30px rgba(0,0,0,0.05); }

/* SIDEBAR */
.sidebar { width:250px; background:#fff; padding:30px 20px; border-right:1px solid #e7edf5; }
.brand-title { font-size:22px; font-weight:700; color:#167ea5; margin-bottom:30px; }
.menu-title { margin-top:30px; margin-bottom:10px; color:#90a4b8; font-size:13px; text-transform:uppercase; }
.menu-item { display:flex; align-items:center; padding:12px 12px; margin-bottom:5px; border-radius:10px; cursor:pointer; font-weight:500; color:#1d334a; }
.menu-item.active { background:#e8f6ff; color:#167ea5; }
.menu-item:hover { background:#edf8ff; }
.menu-icon { width:38px; height:38px; border-radius:10px; background:#f5faff; display:flex; align-items:center; justify-content:center; margin-right:10px; color:#9bb4c8; }

/* TOP NAV */
.topbar { padding:20px 30px; border-bottom:1px solid #e6edf5; display:flex; justify-content:space-between; align-items:center; }
.profile-box { display:flex; align-items:center; }
.profile-box img { border-radius:50%; width:42px; height:42px; }
.profile-info { margin-left:10px; line-height:1.1; }
.profile-info small { color:#8da4b8; }

/* HERO BANNER */
.hero-box { background:linear-gradient(90deg, #1a8eb4, #2fb3d8); padding:30px; border-radius:15px; color:#fff; display:flex; justify-content:space-between; align-items:center; }
.hero-box h3 { font-weight:700; }
.hero-box p { opacity:0.9; max-width:350px; }
.hero-btn { background:#fff; color:#1a8eb4; border-radius:30px; padding:10px 22px; font-weight:500; border:0; }

/* LESSONS */
.lessons-section { background:#f4fbff; padding:20px; border-radius:15px; margin-top:30px; }
.lesson-card { background:#fff; border-radius:15px; padding:20px; display:flex; align-items:center; box-shadow:0 4px 12px rgba(0,0,0,0.03); margin-bottom:15px; }
.progress-circle { width:70px; height:70px; background:#fff; border-radius:50%; display:flex; align-items:center; justify-content:center; border:4px solid #e0edf5; font-weight:600; margin-right:15px; }

/* RANK CARD */
.rank-box { background:#e9f6ff; padding:20px; border-radius:15px; margin-bottom:20px; }
.rank-user { display:flex; align-items:center; margin-bottom:12px; }
.rank-user img { width:40px; height:40px; border-radius:50%; }
.rank-user div { margin-left:10px; }
.rank-user small { color:#8baac0; }

/* CHART */
.chart-box { background:#f4fbff; padding:20px; border-radius:15px; margin-top:20px; text-align:center; }
.bar { width:24px; border-radius:8px; display:block; }

.logo-light {
  width:200px;
}

@media (max-width: 991px) {
  .logo-light { width:200px; }
}
</style>
</head>
<body class="theme-default main-menu-animated page-profile">
<?php
if($this->session->userdata('role_id')=='6'){ 
	$result=fetch_searching_data();
	$search_arr = array();
	foreach ($result as $value) {
		$search_arr[] =$value['menu_name'].' ||'.$value['path'];
		//$search_arr[] =$value['menu_name'];
	}
}
 ?>
<script>var init = [];</script>
<div id="main-wrapper">






















	<div id="main-navbar" class="navbar navbar-inverse" role="navigation">
		<button type="button" id="main-menu-toggle"><i class="navbar-icon fa fa-bars icon"></i><span class="hide-menu-text">HIDE MENU</span></button>		
		<div class="navbar-inner">
			<div class="navbar-header">
				<!-- Logo -->
				<a href="<?=site_url('home')?>" class="navbar-brand"><div><img  class="logo-light"  alt="LMS" src="https://onlineeducation.sandipuniversity.edu.in/images/logo.png"></div></a>
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-navbar-collapse"><i class="navbar-icon fa fa-bars"></i></button>
			</div>
			<div id="main-navbar-collapse" class="collapse navbar-collapse main-navbar-collapse">
			<div>
					
					<div class="right clearfix">
					   
						<ul class="nav navbar-nav pull-right right-navbar-nav">
						<?php
					if($this->session->userdata('role_id')=='6'){
					 
						?>
						<li class="nav-icon-btn nav-icon-btn-danger dropdown">
						<div class="dropdown-toggle" data-toggle="dropdown" style="padding:12px 10px;">
								<form>
								  <input type="text" placeholder="Search.." name="search" id="search" >
								  <button type="button" onclick='search_function()'><i class="fa fa-search"></i></button>
								</form>
							</div>
								<!-- NOTIFICATIONS -->
								
								<!-- Javascript -->
							
							</li>
						<li class="nav-icon-btn nav-icon-btn-danger dropdown" style="display:none">
								<a href="#notifications" class="dropdown-toggle" data-toggle="dropdown">
									<span class="label" style="top:9px;font-size:10px">5</span>
									<i class="nav-icon fa fa-bell fa-2x" style="font-size:17px"></i>
									<span class="small-screen-text">Notifications</span>
								</a>

								<!-- NOTIFICATIONS -->
								
								<!-- Javascript -->
								<script>
									init.push(function () {
										$('#main-navbar-notifications').slimScroll({ height: 250 });
									});
								</script>
								<!-- / Javascript -->

								<div class="dropdown-menu widget-notifications no-padding" style="width: 300px">
									<div class="notifications-list" id="main-navbar-notifications">
                                    	<div class="notification">
											<div class="notification-title text-info">Leave Appliction:1243</div>
											<div class="notification-description">You have <strong>CL</strong>Leave application.</div>
											<div class="notification-ago">on 28 Feb-18</div>
									     		<div class="notification-icon fa fa-truck bg-info"></div>
										</div> <!-- / .notification -->

										<div class="notification">
											<div class="notification-title text-info">OD Appliction:1243</div>
											<div class="notification-description">You have <strong>OD  </strong>Leave application from staff Arvind Thasal.</div>
											<div class="notification-ago">on 28 Feb-18</div>
											<div class="notification-icon fa fa-truck bg-info"></div>
										</div> <!-- / .notification -->

										<div class="notification">
											<div class="notification-title text-success">SYSTEM</div>
											<div class="notification-description">Server <strong>up</strong>.</div>
											<div class="notification-ago">12h ago</div>
											<div class="notification-icon fa fa-hdd-o bg-success"></div>
										</div> <!-- / .notification -->

									

									</div> <!-- / .notifications-list -->
									<a href="#" class="notifications-link">MORE NOTIFICATIONS</a>
								</div> <!-- / .dropdown-menu -->
							</li>
						
						<?php
				        	}
				    	?>
							
							<li class="dropdown">
								<a href="#" class="dropdown-toggle user-menu" data-toggle="dropdown">
                                  <span>Welcome:<strong><?php 
                                                 
 // echo $this->session->userdata('emp_name');
                                  if($this->session->userdata('role_id')=='9'){
                                       echo 'Parent('.ucfirst($this->session->userdata('name')).')';
                                      
                                  }
                                  else if($this->session->userdata('role_id')=='10'){
                                       echo 'School ('.ucfirst($this->session->userdata('name')).')';
                                      
                                  }
                                  else
                                  {
                                       echo $this->session->userdata('emp_name').'('.ucfirst($this->session->userdata('name')).')';
                                  }
                                 ?> 
                                 </strong></span>
								</a> 
								<ul class="dropdown-menu">
                                <?php if($this->session->userdata('role_id')=='5' || $this->session->userdata('role_id')=='40' || $this->session->userdata('role_id')=='15' || $this->session->userdata('role_id')=='6'){?>
								    <li><a href="<?=site_url('login/Go_iilp')?>"><i class="dropdown-icon fa fa-power-off"></i>&nbsp;&nbsp;Go IILP</a></li>
									<li><a href="<?=site_url('login/Go_bvoc')?>"><i class="dropdown-icon fa fa-power-off"></i>&nbsp;&nbsp;Go BVOC</a></li>
                                    <?php } ?>
									<li><a href="<?=site_url('login/logoff')?>"><i class="dropdown-icon fa fa-power-off"></i>&nbsp;&nbsp;Log Out</a></li>
								</ul>
							</li>
						</ul> <!-- / .navbar-nav -->
					</div> <!-- / .right -->
				</div>
			</div> <!-- / #main-navbar-collapse -->
		</div> <!-- / .navbar-inner -->
	</div> <!-- / #main-navbar -->

	<div id="main-menu" role="navigation" >
		<div id="main-menu-inner sidebar" >
			<div class="menu-content top" id="menu-content-demo">
			</div>
		
			
		
			
			<?php
		//	var_dump($_SESSION);
			?>
		</div> <!-- / #main-menu-inner -->
	</div> <!-- / #main-menu -->
<!-- /4. $MAIN_MENU -->
<script> 
  function search_function()
{ 
    var url='';
	var search=$("#search").val();
	var result =search.split("||");	
	var url =result[1];

    //window.open(url, '_blank');
    window.open("<?=base_url()?>"+url);	
}
   
 $(document).ready(function(){
    var tempArray = <?php echo json_encode($search_arr); ?>;

    var dataSrc = tempArray;
 
    $("#search").autocomplete({
        source:dataSrc
    });
});

</script>
