<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<script src="<?=base_url('assets/javascripts')?>/jquery.table2excel.js"></script>

<style>
.isoStickerWidget {
    width: 100%;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-align: stretch;
    align-items: stretch;
    overflow: hidden;
    border-radius: 5px;
}

.isoStickerWidget .isoIconWrapper {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-align: center;
    align-items: center;
    -ms-flex-pack: center;
    justify-content: center;
    width: 80px;
    -ms-flex-negative: 0;
    flex-shrink: 0;
    background-color: rgba(0, 0, 0, 0.1);
}
.isoStickerWidget .isoContentWrapper {
    width: 100%;
    padding: 20px 15px 20px 20px;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-direction: column;
    flex-direction: column;
}
.isoStickerWidget .isoContentWrapper .isoStatNumber {
    font-size: 20px;
    font-weight: 500;
    line-height: 1.1;
    margin: 0 0 5px;
}
.isoStickerWidget .isoContentWrapper .isoLabel {
    font-size: 16px;
    font-weight: 400;
    margin: 0;
    line-height: 1.2;
}
.isoStickerWidget .isoIconWrapper i {
    font-size: 30px;
    color: rgb(255, 255, 255)
}
.ant-col-md-6 {
    display: block;
    width: 20%; float:left;
}
.isoWidgetsWrapper {
    margin: 0 10px;color:#fff;
}
.isoSaleWidget {
    width: 100%;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-direction: column;
    flex-direction: column;
    padding: 30px;
    background-color: #ffffff;
    overflow: hidden;
    border: 1px solid #ebebeb;
}
.isoSaleWidget .isoSaleLabel {
    font-size: 14px;
    font-weight: 700;
    line-height: 1.2;
    text-transform: uppercase;
    color: #323332;
    margin: 0 0 20px;
}
.isoSaleWidget .isoSalePrice {
    font-size: 28px;
    font-weight: 300;
    line-height: 1.2;
    margin: 0 0 20px;
color: rgb(247, 93, 129);
}
.isoSaleWidget .isoSaleDetails {
    font-size: 13px;
    font-weight: 400;
    line-height: 1.5;
    color: #979797;
    margin: 0;
}
/**/
a:hover,a:focus{
    outline: none;
    text-decoration: none;
}
.tab .nav-tabs{
    border: 1px solid #1fc1dd;
}
.tab .nav-tabs li{
    margin: 0;
}
.tab .nav-tabs li a{
    font-size: 14px;
    color: #999898;
    background: #fff;
    margin: 0;
    padding: 10px 25px;
    border-radius: 0;
    border: none;
    border-right: 1px solid #ddd;
    text-transform: uppercase;
    position: relative;
}
.tab .nav-tabs li a:hover{
    border-top: none;
    border-bottom: none;
    border-right-color: #ddd;
}
.tab .nav-tabs li.active a,
.tab .nav-tabs li.active a:hover{
    color: #fff;
    border: none;
    background: #1fc1dd;
    border-right: 1px solid #ddd;
}
.tab .nav-tabs li.active a:before{
    content: "";
    width: 68%;
    height: 4px;
    background: #fff;
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    margin: 0 auto;
}
.tab .nav-tabs li.active a:after{
    content: "";
    border-top: 10px solid #1fc1dd;
    border-left: 10px solid transparent;
    border-right: 10px solid transparent;
    position: absolute;
    bottom: -10px;
    left: 43%;
}
.tab .tab-content{
    font-size: 13px;
    color: #999898;
    line-height: 25px;
    background: #fff;
    padding: 20px;
    border: 1px solid #1fc1dd;
    border-top: none;
}
.tab .tab-content h3{
    font-size: 24px;
    color: #999898;
    margin-top: 0;
}
@media only screen and (max-width: 480px){
    .tab .nav-tabs li{
        width: 100%;
        text-align: center;
    }
    .tab .nav-tabs li.active a,
    .tab .nav-tabs li.active a:after,
    .tab .nav-tabs li.active a:hover{
        border: none;
    }
}
</style>
			
	<style>
	.table{width: 100%;}
	table{max-width: 100%;}
	</style>


<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Admin</a></a></li>
        <li class="active"><a href="#">Dashboard</a></li>
    </ul>
   
    <div class="row" style="margin-bottom:20px;">
    <div class="ant-col-md-6">
     <div class="isoWidgetsWrapper">
			<div class="isoStickerWidget" style="background-color: rgb(114, 102, 186);">
			<div class="isoContentWrapper">
			<h3 class="isoStatNumber"><?=$getTotalAdm['new_adm'].'+'.$getTotalAdm['rr_adm'].'='.$getTotalAdm['totstud']?></h3>
			<span class="isoLabel">No.of Admissions</span>
			</div></div></div>   
    </div>
    <?php
    
    if($_SESSION['uid']==1 ||$this->session->userdata('role_id')==6){
    ?>
    <div class="ant-col-md-6">
     <div class="isoWidgetsWrapper">
			<div class="isoStickerWidget" style="background-color: rgb(66, 165, 246);">
			<div class="isoContentWrapper">
			<h3 class="isoStatNumber"><?=money_format('%!.0n',$getTotalfee)?></h3>
			<span class="isoLabel">Fees Applicable</span>
			</div></div></div>   
    </div>
    
    <div class="ant-col-md-6">
     <div class="isoWidgetsWrapper">
			<div class="isoStickerWidget" style="background-color: rgb(126, 211, 32);">
			<div class="isoContentWrapper">
			<h3 class="isoStatNumber"><?=money_format('%!.0n',$getExemfee)?></h3>
			<span class="isoLabel">Scholarship Given</span>
			</div></div></div>  
    </div>
    
    <div class="ant-col-md-6">
     <div class="isoWidgetsWrapper">
			<div class="isoStickerWidget" style="background-color: rgb(255, 191, 0);">
			<div class="isoContentWrapper">
			<h3 class="isoStatNumber"><?=money_format('%!.0n',$getFeeReceived)?></h3>
			<span class="isoLabel">Fees Received</span>
			</div></div></div>    
    </div>
    
<div class="ant-col-md-6">
     <div class="isoWidgetsWrapper">
			<div class="isoStickerWidget" style="background-color: rgb(247, 93, 129);">
			<div class="isoContentWrapper">
			<h3 class="isoStatNumber"><?php echo money_format('%!.0n',$getTotalfee-$getFeeReceived);?></h3>
			<span class="isoLabel">Fees Pending </span>
			</div></div></div>    
    </div>
    
   </div> <!-- / .row -->
   
   
 
     
     
     
     <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
	<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    </head>
 
 
     <div class="row" style="margin-bottom:20px;">
     <div class="col-md-12">
<div class="panel">
					<div class="panel-heading">
						<span class="panel-title">Course wise Admissions</span>
					</div>
					<div class="panel-body">
					<!--	<div class="note note-info">More info and examples at </div>-->

						<div class="graph-container">
							<div id="hero-bar" class="graph"></div>
						</div>
					</div>
				</div>
     </div>
     </div> <!-- / .row --> 
     <div class="row">
     <div class="col-md-12">
          <div class="col-md-8">
        <div class="panel">
        					<div class="panel-heading">
        						<span class="panel-title">Course wise Fees</span>
        					</div>
        					<div class="panel-body">
        					<div class="col-md-12">
        					<table class="table table-bordered table-responsive table-hover" >
        					    <tr class="themecolor">
        					        <th width="2%">#</th>
        					        <th width="8%">Course</th>
        					        <th width="20%">Fees Collected&nbsp;(&nbsp;<i class="fa fa-inr"></i>&nbsp;)</th>
        					        <th width="20%">Fees Pending&nbsp;(&nbsp;<i class="fa fa-inr"></i>&nbsp;)</th>
        					   </tr>
        					   <tbody>
        					    <?php
        					    
								$i=1;
									if(!empty($fees)){
										foreach($fees as $stud){
										
										
								?>
									<tr>
										<td><?=$i?></td>
										<td><?=$stud['course']?></td>

									    <td><i class="fa fa-inr">&nbsp;&nbsp;<?=money_format('%!.0n',$stud['fees_total'])?></i></td>
									    <td><i class="fa fa-inr"></i>&nbsp;&nbsp;<?=money_format('%!.0n',(int)$stud['applicable_total']-(int)$stud['fees_total'])?></td>
										
									</tr>
								<?php
										$i++;
										}
									}
										?>
        					       
        					       
        					   </tbody>
        					    
        					    </table>
        					
     
        					</div>	
        					
        					</div>
        </div>
        </div>
        <div class="col-md-4">
             <div class="col-md-12">
                 <div class="panel">
        		<div class="panel-heading">
        		    <span class="panel-title">Admission Year Wise</span>
        				</div>
        					<div class="panel-body">
        					<div class="col-md-12">
        					<a href="#" class="block padder-v hover"> <span class="i-s i-s-2x pull-left m-r-sm"> <i class="i i-hexagon2 i-s-base text-danger hover-rotate"></i> <i class="i i-plus2 i-1x text-white"></i> </span> <span class="clear"> <i class="fa fa-facebook fa-3x"></i><span class="h3 block m-t-xs text-danger"><?php
        					print_r($admyear['firstyear']);?></span> <small class="text-muted text-u-c"> First Year</small> </span> </a><hr>
        					<a href="#" class="block padder-v hover"> <span class="i-s i-s-2x pull-left m-r-sm"> <i class="i i-hexagon2 i-s-base text-danger hover-rotate"></i> <i class="i i-plus2 i-1x text-white"></i> </span> <span class="clear"><i class="fa fa-usd fa-3x"></i> <span class="h3 block m-t-xs text-danger"><?php
        					print_r($admyear['lateral']);?></span> <small class="text-muted text-u-c"> Direct Second Year </small> </span> </a>
        					
     
        					</div>	
        					
        					</div>
        </div>
            </div>
            <div class="col-md-12">
                 <div class="panel">
        		<div class="panel-heading">
        		    <span class="panel-title"> Admission Gender Wise</span>
        				</div>
        					<div class="panel-body">
        					<div class="col-md-12">
        					<a href="#" class="block padder-v hover"> <span class="i-s i-s-2x pull-left m-r-sm"> <i class="i i-hexagon2 i-s-base text-danger hover-rotate"></i> <i class="i i-plus2 i-1x text-white"></i> </span> <i class="fa fa-male fa-3x"></i><span class="clear"> <span class="h3 block m-t-xs text-danger">	<?php
        					print_r($gender['male']);
        					?></span> <small class="text-muted text-u-c">Total No.of Male</small> </span> </a><hr>
        					<a href="#" class="block padder-v hover"> <span class="i-s i-s-2x pull-left m-r-sm"> <i class="i i-hexagon2 i-s-base text-danger hover-rotate"></i> <i class="i i-plus2 i-1x text-white"></i> </span> <span class="clear"><i class="fa fa-female fa-3x"></i> <span class="h3 block m-t-xs text-danger">	<?php
        					print_r($gender['female']);
        					?></span> <small class="text-muted text-u-c">Total No.of FeMale </small> </span> </a>
        					
     
        					</div>	
        					
        					</div>
        </div>
            </div>
             <div class="col-md-12">
                 <div class="panel">
        		<div class="panel-heading">
        		    <span class="panel-title"> Admission Domacile Wise</span>
        				</div>
        					<div class="panel-body">
        					<div class="col-md-12">
        					<a href="#" class="block padder-v hover">
        					<span class="i-s i-s-2x pull-left m-r-sm"> <i class="i i-hexagon2 i-s-base text-danger hover-rotate"></i> <i class="i i-plus2 i-1x text-white"></i> </span> <i class="fa fa-maxcdn fa-3x"></i><span class="clear"> <span class="h3 block m-t-xs text-danger">	<?php
        					print_r($domacile['ms']);
        					?></span> <small class="text-muted text-u-c">From Maharashtra</small> </span> </a><hr>
        					<a href="#" class="block padder-v hover"> <span class="i-s i-s-2x pull-left m-r-sm"> <i class="i i-hexagon2 i-s-base text-danger hover-rotate"></i> <i class="i i-plus2 i-1x text-white"></i> </span> <span class="clear"><i class="fa fa-globe fa-3x"></i> <span class="h3 block m-t-xs text-danger">	<?php
        					print_r($domacile['oms']);
        					?></span> <small class="text-muted text-u-c">Out of Maharashtra </small> </span> </a>
        					
     
        					</div>	
        					
        					</div>
        </div>
            </div>
             <div class="col-md-12">
                 <div class="panel">
        		<div class="panel-heading">
        		    <span class="panel-title">Cancel Admission</span>
        				</div>
        					<div class="panel-body">
        					<div class="col-md-12">
        					<a href="#" class="block padder-v hover"> <span class="i-s i-s-2x pull-left m-r-sm"> <i class="i i-hexagon2 i-s-base text-danger hover-rotate"></i> <i class="i i-plus2 i-1x text-white"></i> </span> <span class="clear"> <span class="h3 block m-t-xs text-danger"><?=$cancle[0]['cancel_count']?></span> <small class="text-muted text-u-c"> no.of admission</small> </span> </a><hr>
        					<a href="#" class="block padder-v hover"> <span class="i-s i-s-2x pull-left m-r-sm"> <i class="i i-hexagon2 i-s-base text-danger hover-rotate"></i> <i class="i i-plus2 i-1x text-white"></i> </span> <span class="clear"><i class="fa fa-inr"></i> <span class="h3 block m-t-xs text-danger"><?=money_format('%!.0n',$cancle[0]['cancel_fee'])?></span> <small class="text-muted text-u-c"> Cancel Fees. </small> </span> </a>
        					
     
        					</div>	
        					
        					</div>
        </div>
            </div>
        </div>
        
     </div>
     </div> <!-- / .row --> 
		<!--	
		 <div class="row" >
     <div class="col-md-12">
<div class="panel">
					<div class="panel-heading">
						<span class="panel-title">Admission Location wise</span>
					</div>
					<div class="panel-body">
					<div class="container">
    <div class="row">
        <div class="col-sm-10">
            <div class="tab" role="tabpanel">
               
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#Section1" aria-controls="home" role="tab" data-toggle="tab">City Wise</a></li>
                    <li role="presentation"><a href="#Section2" aria-controls="profile" role="tab" data-toggle="tab">District Wise</a></li>
                    <li role="presentation"><a href="#Section3" aria-controls="messages" role="tab" data-toggle="tab">State Wise</a></li>
                    <li role="presentation"><a href="#Section4" aria-controls="messages" role="tab" data-toggle="tab">Stream wise</a></li>
                    <li role="presentation"><a href="#Section4" aria-controls="messages" role="tab" data-toggle="tab">Gender Wise</a></li>
                     <li role="presentation"><a href="#Section4" aria-controls="messages" role="tab" data-toggle="tab">Qualification Wise</a></li>
                </ul>
              
                <div class="tab-content tabs">
                    <div role="tabpanel" class="tab-pane fade in active" id="Section1">
                        <h3>Section 1</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras nec urna aliquam, ornare eros vel, malesuada lorem. Nullam faucibus lorem at eros consectetur lobortis. Maecenas nec nibh congue, placerat sem id, rutrum velit. Phasellus porta enim at facilisis condimentum. Maecenas pharetra dolor vel elit tempor pellentesque sed sed eros. Aenean vitae mauris tincidunt, imperdiet orci semper, rhoncus ligula. Vivamus scelerisque.</p>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="Section2">
                        <h3>Section 2</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras nec urna aliquam, ornare eros vel, malesuada lorem. Nullam faucibus lorem at eros consectetur lobortis. Maecenas nec nibh congue, placerat sem id, rutrum velit. Phasellus porta enim at facilisis condimentum. Maecenas pharetra dolor vel elit tempor pellentesque sed sed eros. Aenean vitae mauris tincidunt, imperdiet orci semper, rhoncus ligula. Vivamus scelerisque.</p>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="Section3">
                        <h3>Section 3</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras nec urna aliquam, ornare eros vel, malesuada lorem. Nullam faucibus lorem at eros consectetur lobortis. Maecenas nec nibh congue, placerat sem id, rutrum velit. Phasellus porta enim at facilisis condimentum. Maecenas pharetra dolor vel elit tempor pellentesque sed sed eros. Aenean vitae mauris tincidunt, imperdiet orci semper, rhoncus ligula. Vivamus scelerisque.</p>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="Section4">
                        <h3>Section 4</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras nec urna aliquam, ornare eros vel, malesuada lorem. Nullam faucibus lorem at eros consectetur lobortis. Maecenas nec nibh congue, placerat sem id, rutrum velit. Phasellus porta enim at facilisis condimentum. Maecenas pharetra dolor vel elit tempor pellentesque sed sed eros. Aenean vitae mauris tincidunt, imperdiet orci semper, rhoncus ligula. Vivamus scelerisque.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
					</div>
				</div>
     </div>
     </div --> 	

			
     </div>
     </div> <!-- / .row --> 
     <?php
    }
    ?>
     
  
	</div> <!-- / #content-wrapper -->
	<div id="main-menu-bg"></div>
</div> <!-- / #main-wrapper -->

<!-- Get jQuery from Google CDN -->
<!--[if !IE]> -->
	<script type="text/javascript"> window.jQuery || document.write('<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js">'+"<"+"/script>"); </script>

<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>

<script type="text/javascript">
	init.push(function () {
		// Javascript code here
	})
	window.PixelAdmin.start(init);
</script>
<!-- 7. $MORRISJS_BARS =============================================================================

				Morris.js Bars
-->
				<!-- Javascript -->
				<script>
					init.push(function () {
						Morris.Bar({
							element: 'hero-bar',
							data:  <?php echo $cdata ?>,
							xkey: 'course',
							ykeys: ['count'],
							labels: ['No Of Admissions'],
							barRatio:0.4,
							xLabelAngle:40,
							hideHover: 'auto',
							barColors: PixelAdmin.settings.consts.COLORS,
							gridLineColor: '#cfcfcf',
							resize: false,
						});
					});
				</script>
				<!-- / Javascript -->
				
