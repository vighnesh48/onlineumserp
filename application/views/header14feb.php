<!DOCTYPE html>
<!--[if IE 8]>         <html class="ie8"> <![endif]-->
<!--[if IE 9]>         <html class="ie9 gt-ie8"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="gt-ie8 gt-ie9 not-ie"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Sandip Foundation ERP System</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">	
	<!--<link href="<?=base_url()?>assets/stylesheets/google.api.css" rel="stylesheet" type="text/css">-->
    <link rel="shortcut icon" type="image/ico" href="<?=base_url()?>assets/images/favicon.ico"/>	
	<link href="<?=base_url()?>assets/stylesheets/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="<?=base_url()?>assets/stylesheets/pixel-admin.min.css" rel="stylesheet" type="text/css">
	<link href="<?=base_url()?>assets/stylesheets/widgets.min.css" rel="stylesheet" type="text/css">
	<link href="<?=base_url()?>assets/stylesheets/pages.min.css" rel="stylesheet" type="text/css">
	<link href="<?=base_url()?>assets/stylesheets/rtl.min.css" rel="stylesheet" type="text/css">
	<link href="<?=base_url()?>assets/stylesheets/themes.min.css" rel="stylesheet" type="text/css">
	<link href="<?=base_url()?>assets/stylesheets/multiple-select.css" rel="stylesheet" type="text/css">
	<link href="<?=base_url()?>assets/stylesheets/components.css" rel="stylesheet" type="text/css">
	<link href="<?=base_url()?>assets/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
	<link href="<?=base_url()?>assets/css/bootstrap-fileinput.css" rel="stylesheet" type="text/css">
	<!--[if lt IE 9]>
		<script src="<?=base_url()?>assets/javascripts/ie.min.js"></script>
	<![endif]-->
        <script src="<?=base_url()?>assets/javascripts/jquery.min.js"></script>
        <script src="<?=base_url()?>assets/javascripts/common.js"></script>
        <script src="<?=base_url()?>assets/javascripts/default.js"></script>
        <script src="<?=base_url()?>assets/javascripts/jquery.multiple.select.js"></script>
        <script src="<?=base_url()?>assets/javascripts/select2.min.js"></script>
        <!--<script src="<?=base_url()?>assets/javascripts/jquery.dataTables.min.js"></script>-->
        <script type='text/javascript'>
            var base_url = '<?=base_url()?>';
	</script>
</head>
<body class="theme-default main-menu-animated page-profile">
<script>var init = [];</script>
<div id="main-wrapper">
	<div id="main-navbar" class="navbar navbar-inverse" role="navigation">
		<button type="button" id="main-menu-toggle"><i class="navbar-icon fa fa-bars icon"></i><span class="hide-menu-text">HIDE MENU</span></button>		
		<div class="navbar-inner">
			<div class="navbar-header">
				<!-- Logo -->
				<a href="<?=site_url('home')?>" class="navbar-brand"><div><img alt="LMS" src="<?=base_url()?>assets/images/logo.png"></div>LMS System</a>
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-navbar-collapse"><i class="navbar-icon fa fa-bars"></i></button>
			</div>
			<div id="main-navbar-collapse" class="collapse navbar-collapse main-navbar-collapse">
				<div>
					
					<div class="right clearfix">
						<ul class="nav navbar-nav pull-right right-navbar-nav">
							
							
							<li class="dropdown">
								<a href="#" class="dropdown-toggle user-menu" data-toggle="dropdown">
                                  <span>Welcome:<strong><?php echo ucfirst($this->session->userdata('name'));?></strong></span>
								</a>
								<ul class="dropdown-menu">
								
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
/*  echo"<pre>";
 print_r($my_menu_details['level_1']);
 echo"</pre>";
die();  */ 		
//echo $this->session->userdata('name');
//echo $this->session->userdata('ro');
                            for($i=0;$i<count($my_menu_details['level_0']);$i++)
                            {
								if($this->session->userdata('role_id')==3){ //if role of user Employee
								if(!empty($this->session->userdata('ro')) && ($this->session->userdata('ro')=='on'))//if user is RO then display all menu
								{							
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
			<?php  }else{ if($my_menu_details['level_0'][$i]['menu_name']!='Leave Applications'){ //else employee is not RO then hide Leave applications Menu?>
								
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
			<? }}}else{ // else role other than employee?>
								
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
								
							<?php }} ?>
			</ul>                  
		</div> <!-- / #main-menu-inner -->
	</div> <!-- / #main-menu -->
<!-- /4. $MAIN_MENU -->