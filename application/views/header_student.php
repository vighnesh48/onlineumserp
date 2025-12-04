<!DOCTYPE html>
<!--[if IE 8]>         <html class="ie8"> <![endif]-->
<!--[if IE 9]>         <html class="ie9 gt-ie8"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="gt-ie8 gt-ie9 not-ie"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Sandip University ERP System</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">	
	<!--<link href="<?=base_url()?>assets/stylesheets/google.api.css" rel="stylesheet" type="text/css">-->
    <link rel="shortcut icon" type="image/ico" href="<?=base_url()?>assets/images/favicon.ico"/>
	<link rel="stylesheet" href="<?=base_url()?>assets/css/all_minified.css">

	<!--[if lt IE 9]>
		<script src="<?=base_url()?>assets/javascripts/ie.min.js"></script>
	<![endif]-->
                                      
        
        <script src="<?=base_url()?>assets/javascripts/all_minified_js.js"></script>
        <script src="<?=base_url()?>assets/javascripts/common.js"></script>
        <script src="<?=base_url()?>assets/javascripts/default.js"></script>
		
		
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
		#main-navbar .navbar-brand div img{width:150px;height: auto;}
		#main-navbar .navbar-brand{line-height:0px !important;height: 46px !important;}
		#ui-id-1{
		z-index: 9999!important;	
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
				<a href="<?=site_url('home')?>" class="navbar-brand"><div><img alt="LMS" src="<?=base_url()?>assets/images/logo-admin.png"></div></a>
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

	<div id="main-menu" role="navigation">
		<div id="main-menu-inner">
			<div class="menu-content top" id="menu-content-demo">
			</div>
			<ul class="navigation">
			<?php
			if($this->session->userdata('role_id')==4) {
			  $uId=$this->session->userdata('name');
        
                $DB1 = $this->load->database('umsdb', TRUE);
                $sql = "
                                SELECT vsd.course_id,vsd.course_duration,sm.current_year,sm.enrollment_no,sm.admission_school
                                from student_master sm 
                                left join admission_details ad on ad.enrollment_no = sm.enrollment_no 
                                left join vw_stream_details vsd on vsd.stream_id = sm.admission_stream
                                where  sm.academic_year = '2025' AND  sm.enrollment_no = '$uId' 
                ";
                $stud_det = $DB1->query($sql)->row_array();
				// echo "<pre>";
               //  print_r($stud_det);exit;

               /* if($stud_det['course_duration'] == $stud_det['current_year']){ */
				   if (
						(!empty($stud_det) && $stud_det['admission_school'] == 6 && $stud_det['current_year'] == 3) ||
						(!empty($stud_det) && $stud_det['course_duration'] == $stud_det['current_year'])
					){
                        $enroll = base64_encode($uId);
                        // echo "<pre>";
                        // print_r($enroll);exit;
                
                // print_r($enroll);exit;
                $href = 'https://sg-connect.sandipuniversity.com/apply-student-Drive-Registration/'.$enroll;
				
			?>
			<li class="mm-dropdown mm-dropdown-root open">
                                <a href="<?=$href ?>"><i class="menu-icon fa fa fa-edit" target="_blank"></i><span class="mm-text mmc-dropdown-delay animated fadeIn">Apply for Career</span></a>                                        
                                    
                            </li>
			
				<?php  } }
								
								$uni_type=$this->session->userdata('uni_type'); 
								$universalid=$this->session->userdata('universalid');
								if($this->session->userdata('role_id')!=4){								
								?>
								
						      <li class="dropdown">
								<a target="_blank" href="https://sandiperp.com/TicketMasterNew.aspx?UserTypeId=Mw==&EmpsId=<?=$universalid?>" class="dropdown-toggle user-menu" data-toggle="">
                                <span class="fa fa-ticket" ></span> Create Ticket<span id='remid'><sup></sup></span>
								</a>
								</li>
						<?php }?>
			<?php if($_SESSION['name']=="662496" || $this->session->userdata('role_id')=='6'){ ?>
			<li class="mm-dropdown mm-dropdown-root open">
                                <a href="https://erp.sandipuniversity.com/Mba_online/Mba_online_view"><i class="menu-icon fa fa fa-edit"></i><span class="mm-text mmc-dropdown-delay animated fadeIn">Online SU-DAT/LAT/MAT Registration 2025-26</span></a>                                        
                                    
                            </li>
			<?php }?>
			<?php if($_SESSION['name']=="662496" || $_SESSION['name']=="hostel_nashik" || $_SESSION['name']=="662640"){ ?>
			<li class="mm-dropdown mm-dropdown-root open">
                                <a href="hostel/hostel_wise_late_punching"><i class="menu-icon fa fa fa-edit"></i><span class="mm-text mmc-dropdown-delay animated fadeIn">Hostel punching report</span></a>                                        
                                    
                            </li>
			<?php }?>
			<?php if($_SESSION['name']=="210708"){ ?>
			<li class="mm-dropdown mm-dropdown-root open">
                                <a href="https://erp.sandipuniversity.com/Account/stud_feelist"><i class="menu-icon fa fa fa-edit"></i><span class="mm-text mmc-dropdown-delay animated fadeIn">Scolarship Updation</span></a>                                        
                                    
                            </li>
			<li class="mm-dropdown mm-dropdown-root open">
                                <a href="<?=base_url()?>ums_admission/scholorship_list"><i class="menu-icon fa fa fa-edit"></i><span class="mm-text mmc-dropdown-delay animated fadeIn">Scolarship List</span></a>                                        
                                    
                            </li>
			<?php }?>
			<?php if($this->session->userdata('role_id')!=22 && $this->session->userdata('role_id')!=45 && $this->session->userdata('role_id')!=6  && $this->session->userdata('role_id')!=4 && $this->session->userdata('role_id')!=15 && $this->session->userdata('role_id')!=12 && $this->session->userdata('role_id')!=49 && $this->session->userdata('role_id')!=9 && $this->session->userdata('role_id')!=50 && $this->session->userdata('role_id')!=51 && $this->session->userdata('role_id')!=52 && $this->session->userdata('role_id')!=54 && $this->session->userdata('role_id')!=55 && $this->session->userdata('role_id')!=56 && $this->session->userdata('role_id')!=53 && $this->session->userdata('role_id')!=57 && $this->session->userdata('role_id')!=10 && $this->session->userdata('role_id')!=25 && $this->session->userdata('role_id')!=62){ ?>
			<li class="mm-dropdown mm-dropdown-root open">
                                <a href="https://icerp.sandipuniversity.com/login/switchtoref_erp/<?=base64_encode($this->session->userdata('name'))?>"><i class="menu-icon fa fa fa-edit"></i><span class="mm-text mmc-dropdown-delay animated fadeIn">Add FOU/Staff Reference</span></a>                                        
                                    
                            </li>
							<li class="mm-dropdown mm-dropdown-root open">
                                <a href="https://icerp.sandipuniversity.com/login/staffadd"><i class="menu-icon fa fa fa-edit"></i><span class="mm-text mmc-dropdown-delay animated fadeIn">Registration for Staff Reference</span></a>                                        
                                    
                            </li>
			<?php } 
/*  echo"<pre>";
 print_r($my_menu_details['level_1']);
 echo"</pre>";
die();  */ 		
//echo $this->session->userdata('name');
//echo $this->session->userdata('ro');
                            for($i=0;$i<count($my_menu_details['level_0']);$i++)
                            {
								if($this->session->userdata('role_id')==3){ //if role of user Employee
							//	if(!empty($this->session->userdata('ro')) && ($this->session->userdata('ro')=='on'))//if user is RO then display all menu
							//	{							
			?>            
                            <li class="mm-dropdown">
                                <a href="<?=base_url($my_menu_details['level_0'][$i]['path'])?>"><i class="menu-icon fa <?=$my_menu_details['level_0'][$i]['icon']?>"></i><span class="mm-text"><?=$my_menu_details['level_0'][$i]['menu_name']?></span></a>                                        
                                    <ul>
                                        <?php
                                        $sub_menu=$my_menu_details['level_1'][$my_menu_details['level_0'][$i]['menu_id']];
                                        for($j=0;$j<count($sub_menu);$j++)
                                        {
                                        ?>
                                            <li>
                                                <a href="<?=base_url($sub_menu[$j]['path'])?>"><i class="menu-icon <?=$sub_menu[$j]['icon']?>"></i><span class="mm-text"><?=$sub_menu[$j]['menu_name']?></span></a>                                        
                                            </li>
                                        <?php
                                        }
                                        ?>    
                                    </ul>
                            </li>
			
			<? }elseif($this->session->userdata('role_id')==1){//for admin
			
			if($my_menu_details['level_0'][$i]['menu_name']=="Dashboard"){?>
								<li >
                                <a href="<?=base_url($my_menu_details['level_0'][$i]['path'])?>"><i class="menu-icon fa <?=$my_menu_details['level_0'][$i]['icon']?>"></i><span class="mm-text"><?=$my_menu_details['level_0'][$i]['menu_name']?></span></a>                                        
                                    <ul>
                                        <?php
                                        $sub_menu=$my_menu_details['level_1'][$my_menu_details['level_0'][$i]['menu_id']];
                                        for($j=0;$j<count($sub_menu);$j++)
                                        {
                                        ?>
                                            <li>
                                                <a href="<?=base_url($sub_menu[$j]['path'])?>"><i class="menu-icon <?=$sub_menu[$j]['icon']?>"></i><span class="mm-text"><?=$sub_menu[$j]['menu_name']?></span></a>                                        
                                            </li>
                                        <?php
                                        }
                                        ?>    
                                    </ul>
                            </li>
									
							<?php	}else{?>
							<li class="mm-dropdown">
                                <a href="<?=base_url($my_menu_details['level_0'][$i]['path'])?>"><i class="menu-icon fa <?=$my_menu_details['level_0'][$i]['icon']?>"></i><span class="mm-text"><?=$my_menu_details['level_0'][$i]['menu_name']?></span></a>                                        
                                    <ul>
                                        <?php
                                        $sub_menu=$my_menu_details['level_1'][$my_menu_details['level_0'][$i]['menu_id']];
                                        for($j=0;$j<count($sub_menu);$j++)
                                        {
                                        ?>
                                            <li>
                                                <a href="<?=base_url($sub_menu[$j]['path'])?>"><i class="menu-icon <?=$sub_menu[$j]['icon']?>"></i><span class="mm-text"><?=$sub_menu[$j]['menu_name']?></span></a>                                        
                                            </li>
                                        <?php
                                        }
                                        ?>    
                                    </ul>
                            </li>								
							<?php	}}else{ // else role other than employee?>
							 	
								<li class="mm-dropdown">
                                <a href="<?=base_url($my_menu_details['level_0'][$i]['path'])?>"><i class="menu-icon fa <?=$my_menu_details['level_0'][$i]['icon']?>"></i><span class="mm-text"><?=$my_menu_details['level_0'][$i]['menu_name']?></span></a>                                        
                                    <ul>
                                        <?php
                                        $sub_menu=$my_menu_details['level_1'][$my_menu_details['level_0'][$i]['menu_id']];
                                        for($j=0;$j<count($sub_menu);$j++)
                                        {
                                        ?>
                                            <li>
                                                <a href="<?=base_url($sub_menu[$j]['path'])?>"><i class="menu-icon <?=$sub_menu[$j]['icon']?>"></i><span class="mm-text"><?=$sub_menu[$j]['menu_name']?></span></a>                                        
                                            </li>
                                        <?php
                                        }
                                        ?>    
                                    </ul>
                            </li>
								
							<?php }} 
							
							if($_SESSION['name']=="110081" || $_SESSION['name']=="110077" || $_SESSION['name']=="110156" || $_SESSION['name']=="110071" || $_SESSION['name']=="110129"
							 || $_SESSION['name']=="110148" || $_SESSION['name']=="110048")
							{
							?>
							
					
						   <li class="mm-dropdown mm-dropdown-root open">
                                <a href="<?=base_url()?>conference"><i class="menu-icon fa fa fa-edit"></i><span class="mm-text mmc-dropdown-delay animated fadeIn">ICEMELTS Conference</span></a>                                        
                                    <ul class="mmc-dropdown-delay animated fadeInLeft" style="">
                                            <li>
                                                <a href="<?=base_url()?>conference"><i class="menu-icon fa fa-list"></i><span class="mm-text">Registration List</span></a>                                        
                                            </li>
                                            <li>
                                                <a href="<?=base_url()?>conference/icemelt_registration_2018"><i class="menu-icon fa fa-list"></i><span class="mm-text">Payment List</span></a>                                        
                                            </li>                                       
                                    </ul>
                            </li>	
                            <?php
                            }
                            ?>
                            <?php 
							
							if($_SESSION['name']=="210002")
							{
							?>
							
					
						   <li class="mm-dropdown mm-dropdown-root open">
                                <a href="<?=base_url()?>conference"><i class="menu-icon fa fa fa-edit"></i><span class="mm-text mmc-dropdown-delay animated fadeIn">Post Examination</span></a>                                        
                                    <ul class="mmc-dropdown-delay animated fadeInLeft" style="">
                                            <li>
                                                <a href="<?=base_url()?>Reval/list_applied"><i class="menu-icon fa fa-list"></i><span class="mm-text">Photocopy/Revaluation List</span></a>                                        
                                            </li>
                                                                                 
                                    </ul>
                            </li>	
                            <?php
                            }
                            ?>
			</ul>    
			
		
			
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
