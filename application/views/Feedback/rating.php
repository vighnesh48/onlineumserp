<link href="<?=base_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=base_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=base_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>

<link href="<?=base_url()?>assets/javascripts/jquery.mCustomScrollbar.css" rel="stylesheet" type="text/css" />
<script src="<?=base_url()?>assets/javascripts/jquery.mCustomScrollbar.concat.min.js" type="text/javascript"></script>

<style>
.leave-table tr td {
	padding: 6px 8px!important;
}
.padding-sm {
	padding: 0 15px !important;
}
.star-icon .list-group-icon {
	width: auto;
}
.star-icon .fa-star {
	color: #FC6
}
.widget-support-tickets a.ticket-title {
	padding: 0 0 10px 0
}
.widget-support-tickets a.ticket-title {
	font-size: 12.2px
}
.panel .widget-support-tickets .ticket, .panel.widget-support-tickets .ticket {
	padding-left: 0px;
	padding-right: 0px;
	margin: 0;
}
.panel-body {
	padding: 10px;
}
.list-group-item>.badge {
    line-height: 10px!important;
}
.review-box,.review-box1 {
	height: auto!important;
}
.test{height:300px!important;overflow-y: hidden;overflow-x: hidden;}
.star-rating .list-group-item{padding-bottom:0;padding-top:5px;}
.star-rating a{cursor:pointer}
.theme-purple-hills .bordered, .theme-purple-hills .panel, .theme-purple-hills .table, .theme-purple-hills hr{border-color: #e2e2e21a;}
.panel-title-icon{margin-right:0}
</style>

  <div id="content-wrapper" style="margin-top: -50px;"> 
    <!-- Content here -->
      <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Facility Rating</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
          
                    <div class="visible-xs clearfix form-group-margin"></div>
                   
                    
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                    
                <div class="panel-heading">
                     <div class="row ">
                             <div class="col-sm-9">
   <form method="post">

			<!--	<div class="col-sm-3">
					<input type="text" name="fdate" id="fdate" class="form-control" placeholder="From Date"  value=""/>                                                                            
				</div>
					<div class="col-sm-3">
					<input type="text" name="tdate" id="tdate" class="form-control" placeholder="To Date"  value=""/>                                                                            
				</div>
				-->
				
			<div class="col-sm-3">
				    <select id="campaign" name="campaign" class="form-control" >
				      <option value="">Select Campaign</option> 
				 <?php 
							foreach($campaigns as $campaigns){ 
							
								?>
								<option value="<?php echo $campaigns['rating_slot']; ?>" ><?php echo $campaigns['rating_slot']; ?></option>
								<?php } ?>      
				             </select>                                                            
				</div>
				
	
			<div class="col-sm-1"><input type="submit" value="Search" class="btn btn-primary" id="btnsearch"></div>	&nbsp;&nbsp;&nbsp;
			
					

</form>                 
                                
                                
                             </div>  
                            <div class="col-sm-3">  
                             <input id="system-search" name="q" placeholder="Search for" required class="form-control pull-right">
                            </div> 
                     </div> 
                </div>
</div>
</div>
</div>

    <div class="row star-rating">
      <div class="col-md-4">
        <div class="panel panel-danger panel-dark">
          <div class="panel-heading"> <span class="panel-title"><i class="panel-title-icon fa fa-star-o"></i> <strong>Teaching Rating</strong></span> <span style="float:right;font-weight: bold;font-size: 17px;"><?=$rating['tfivestar']+$rating['tfourstar']+$rating['tthreestar']+$rating['ttwostar']+$rating['tonestar'];?></span></div>
          <!-- / .panel-heading -->
          <div class="list-group star-icon"> 
          <a href="#" class="list-group-item"> <i class="fa fa-star list-group-icon"></i> <i class="fa fa-star list-group-icon"></i> <i class="fa fa-star list-group-icon"></i> <i class="fa fa-star list-group-icon"></i> <i class="fa fa-star list-group-icon"></i> <span class="badge badge-info"><?=$rating['tfivestar'];?></span></a> 
          <a href="#" class="list-group-item"> <i class="fa fa-star list-group-icon"></i> <i class="fa fa-star list-group-icon"></i> <i class="fa fa-star list-group-icon"></i> <i class="fa fa-star list-group-icon"></i> <span class="badge badge-info"><?=$rating['tfourstar'];?></span></a> 
          <a href="#" class="list-group-item"> <i class="fa fa-star list-group-icon"></i> <i class="fa fa-star list-group-icon"></i> <i class="fa fa-star list-group-icon"></i> <span class="badge badge-info"><?=$rating['tthreestar'];?></span></a>
          <a href="#" class="list-group-item"> <i class="fa fa-star list-group-icon"></i> <i class="fa fa-star list-group-icon"></i> <span class="badge badge-info"><?=$rating['ttwostar'];?></span></a>
          <a href="#" class="list-group-item"> <i class="fa fa-star list-group-icon"></i> <span class="badge badge-info"><?=$rating['tonestar'];?></span></a> 
            <!--<a href="#" class="list-group-item">Account settings</a>--> </div>
          <div class="panel widget-support-tickets">
            <div style="padding-left:15px;padding-top:5px;"> <span class="panel-title"><i class="panel-title-icon fa fa-pencil"></i> <strong>Review</strong></span> </div>
            <!-- / .panel-heading -->
            <div class="panel-body">
              <div class="review-box rating">
                  <?php
                
                  for($i=0;$i<count($comments);$i++){
                    
                  ?>
                <div class="ticket"><a href="#" title="" class="ticket-title"><?=$comments[$i]['teaching_comment'];?> </span></a></div>
           <?php
           if($i==1)
           {
               ?>
                <div id="demo" class="collapse">
               <?php
           }
                  }
                   if($i>1)
           {
               echo "</div>";
           }
           ?>
           <!--
                <div class="ticket"> <a href="#" title="" class="ticket-title">Lorem2 ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore.</span></a> <span class="ticket-info"> Applied by <a href="#">Denise Steiner</a> 2 days ago </span> </div>
             
                <div id="demo" class="collapse">
                  <div class="ticket"><a href="#" title="" class="ticket-title">Lorem3 ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore. </span></a> <span class="ticket-info"> Applied by <a href="#" title="">Timothy Owens</a> today </span> </div>
                
                  <div class="ticket"><a href="#" title="" class="ticket-title">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore. </span></a> <span class="ticket-info"> Applied by <a href="#" title="">Timothy Owens</a> today </span> </div>
                
                  <div class="ticket"><a href="#" title="" class="ticket-title">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore. </span></a> <span class="ticket-info"> Applied by <a href="#" title="">Timothy Owens</a> today </span> </div>
              
                  <div class="ticket"><a href="#" title="" class="ticket-title">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore. </span></a> <span class="ticket-info"> Applied by <a href="#" title="">Timothy Owens</a> today </span> </div>
              
                  
                </div>-->
                
                
              </div>
              <br>
               <?php
                 if($i>1){
             echo '<a class="pull-right" data-toggle="collapse" data-target="#demo" id="rating" value="" onClick="starrating(this.id)">View All Review</a> </div>';
                 }
                 ?>
            <!-- / .panel-body --> 
            
          </div>
        </div>
        
        <!-- / .panel --> 
        <!-- /5. $PROFILE_WIDGET_LINKS_EXAMPLE --> 
        
      </div>
      <div class="col-md-4">
        <div class="panel panel-info panel-dark">
          <div class="panel-heading"> <span class="panel-title"><i class="panel-title-icon fa fa-star-o"></i> <strong>Transport Rating</strong></span> <span style="float:right;font-weight: bold;font-size: 17px;"><?=$rating['trfivestar']+$rating['trfourstar']+$rating['trthreestar']+$rating['trtwostar']+$rating['tronestar'];?></span></div>
          <!-- / .panel-heading -->
          <div class="list-group star-icon"> 
          <a href="#" class="list-group-item"> <i class="fa fa-star list-group-icon"></i> <i class="fa fa-star list-group-icon"></i> <i class="fa fa-star list-group-icon"></i> <i class="fa fa-star list-group-icon"></i> <i class="fa fa-star list-group-icon"></i> <span class="badge badge-info"><?=$rating['trfivestar'];?></span></a> 
          <a href="#" class="list-group-item"> <i class="fa fa-star list-group-icon"></i> <i class="fa fa-star list-group-icon"></i> <i class="fa fa-star list-group-icon"></i> <i class="fa fa-star list-group-icon"></i> <span class="badge badge-info"><?=$rating['trfourstar'];?></span></a> 
          <a href="#" class="list-group-item"> <i class="fa fa-star list-group-icon"></i> <i class="fa fa-star list-group-icon"></i> <i class="fa fa-star list-group-icon"></i> <span class="badge badge-info"><?=$rating['trthreestar'];?></span></a>
          <a href="#" class="list-group-item"> <i class="fa fa-star list-group-icon"></i> <i class="fa fa-star list-group-icon"></i> <span class="badge badge-info"><?=$rating['trtwostar'];?></span></a>
          <a href="#" class="list-group-item"> <i class="fa fa-star list-group-icon"></i> <span class="badge badge-info"><?=$rating['tronestar'];?></span></a> 
            <!--<a href="#" class="list-group-item">Account settings</a>--> </div>
          <div class="panel widget-support-tickets">
            <div style="padding-left:15px;padding-top:5px;"> <span class="panel-title"><i class="panel-title-icon fa fa-pencil"></i> <strong>Review</strong></span> </div>
            <!-- / .panel-heading -->
            <div class="panel-body">
              <div class="review-box rating-trans">
            <?php
                
                  for($i=0;$i<count($comments);$i++){
                    
                  ?>
                <div class="ticket"><a href="#" title="" class="ticket-title"><?=$comments[$i]['transport_comment'];?> </span></a></div>
           <?php
           if($i==1)
           {
               ?>
                <div id="demo1" class="collapse">
               <?php
           }
                  }
                   if($i>1)
           {
               echo "</div>";
           }
           ?>
              </div>
              <br>
              <?php
                 if($i>1){
             echo '<a class="pull-right" data-toggle="collapse" data-target="#demo1" id="rating-trans" value="" onClick="starrating(this.id)">View All Review</a> </div>';
                 }
                 ?>
          </div>
          <!-- / .panel-body --> 
        </div>
      </div>
      <div class="col-md-4">
        <div class="panel panel-success panel-dark">
          <div class="panel-heading"> <span class="panel-title"><i class="panel-title-icon fa fa-star-o"></i> <strong>Canteen Rating</strong></span> <span style="float:right;font-weight: bold;font-size: 17px;"><?=$rating['cfivestar']+$rating['cfourstar']+$rating['cthreestar']+$rating['ctwostar']+$rating['conestar'];?></div>
          <!-- / .panel-heading -->
       <div class="list-group star-icon"> 
          <a href="#" class="list-group-item"> <i class="fa fa-star list-group-icon"></i> <i class="fa fa-star list-group-icon"></i> <i class="fa fa-star list-group-icon"></i> <i class="fa fa-star list-group-icon"></i> <i class="fa fa-star list-group-icon"></i> <span class="badge badge-info"><?=$rating['cfivestar'];?></span></a> 
          <a href="#" class="list-group-item"> <i class="fa fa-star list-group-icon"></i> <i class="fa fa-star list-group-icon"></i> <i class="fa fa-star list-group-icon"></i> <i class="fa fa-star list-group-icon"></i> <span class="badge badge-info"><?=$rating['cfourstar'];?></span></a> 
          <a href="#" class="list-group-item"> <i class="fa fa-star list-group-icon"></i> <i class="fa fa-star list-group-icon"></i> <i class="fa fa-star list-group-icon"></i> <span class="badge badge-info"><?=$rating['cthreestar'];?></span></a>
          <a href="#" class="list-group-item"> <i class="fa fa-star list-group-icon"></i> <i class="fa fa-star list-group-icon"></i> <span class="badge badge-info"><?=$rating['ctwostar'];?></span></a>
          <a href="#" class="list-group-item"> <i class="fa fa-star list-group-icon"></i> <span class="badge badge-info"><?=$rating['conestar'];?></span></a> 
            <!--<a href="#" class="list-group-item">Account settings</a>--> </div>
            
          <div class="panel widget-support-tickets"  id="accordion-example3">
            <div style="padding-left:15px;padding-top:5px;"> <span class="panel-title"><i class="panel-title-icon fa fa-pencil"></i> <strong>Review</strong></span> </div>
            <!-- / .panel-heading -->
            <div class="panel-body">
              <div class="review-box rating-cant">
              <?php
                
                  for($i=0;$i<count($comments);$i++){
                    
                  ?>
                <div class="ticket"><a href="#" title="" class="ticket-title"><?=$comments[$i]['canteen_comment'];?> </span></a></div>
           <?php
           if($i==1)
           {
               ?>
                <div id="demo2" class="collapse">
               <?php
           }
                  }
                   if($i>1)
           {
               echo "</div>";
           }
           ?>
              </div>
              <br>
               <?php
                 if($i>1){
             echo '<a class="pull-right" data-toggle="collapse" data-target="#demo2" id="rating-cant" value="" onClick="starrating(this.id)">View All Review</a> </div>';
                 }
             ?>
            <!-- / .panel-body --> 
          </div>
        </div>
        
        <!-- / .panel --> 
        <!-- /5. $PROFILE_WIDGET_LINKS_EXAMPLE --> 
        
      </div>
    </div>
    <div class="row star-rating">
      <div class="col-md-4">
        <div class="panel panel-danger panel-dark">
          <div class="panel-heading"> <span class="panel-title"><i class="panel-title-icon fa fa-star-o"></i> <strong>Hostel Rating</strong></span> <span style="float:right;font-weight: bold;font-size: 17px;"><?=$rating['hfivestar']+$rating['hfourstar']+$rating['hthreestar']+$rating['htwostar']+$rating['honestar'];?></div>
          <!-- / .panel-heading -->
               <div class="list-group star-icon"> 
          <a href="#" class="list-group-item"> <i class="fa fa-star list-group-icon"></i> <i class="fa fa-star list-group-icon"></i> <i class="fa fa-star list-group-icon"></i> <i class="fa fa-star list-group-icon"></i> <i class="fa fa-star list-group-icon"></i> <span class="badge badge-info"><?=$rating['hfivestar'];?></span></a> 
          <a href="#" class="list-group-item"> <i class="fa fa-star list-group-icon"></i> <i class="fa fa-star list-group-icon"></i> <i class="fa fa-star list-group-icon"></i> <i class="fa fa-star list-group-icon"></i> <span class="badge badge-info"><?=$rating['hfourstar'];?></span></a> 
          <a href="#" class="list-group-item"> <i class="fa fa-star list-group-icon"></i> <i class="fa fa-star list-group-icon"></i> <i class="fa fa-star list-group-icon"></i> <span class="badge badge-info"><?=$rating['hthreestar'];?></span></a>
          <a href="#" class="list-group-item"> <i class="fa fa-star list-group-icon"></i> <i class="fa fa-star list-group-icon"></i> <span class="badge badge-info"><?=$rating['htwostar'];?></span></a>
          <a href="#" class="list-group-item"> <i class="fa fa-star list-group-icon"></i> <span class="badge badge-info"><?=$rating['honestar'];?></span></a> 
            <!--<a href="#" class="list-group-item">Account settings</a>--> </div>
          <div class="panel widget-support-tickets" id="accordion-example2">
            <div style="padding-left:15px;padding-top:5px;"> <span class="panel-title"><i class="panel-title-icon fa fa-pencil"></i> <strong>Review</strong></span> </div>
            <!-- / .panel-heading -->
            <div class="panel-body">
              <div class="review-box rating-hotel">
           <?php
                
                  for($i=0;$i<count($comments);$i++){
                    
                  ?>
                <div class="ticket"><a href="#" title="" class="ticket-title"><?=$comments[$i]['hostel_comment'];?> </span></a></div>
           <?php
           if($i==1)
           {
               ?>
                <div id="demo3" class="collapse">
               <?php
           }
                  }
                   if($i>1)
           {
               echo "</div>";
           }
           ?>
              </div>
              <br>
               <?php
                 if($i>1){
             echo '<a class="pull-right" data-toggle="collapse" data-target="#demo3" id="rating-hotel" value="" onClick="starrating(this.id)">View All Review</a> </div>';
                 }
             ?>
            <!-- / .panel-body --> 
          </div>
        </div>
        
        <!-- / .panel --> 
        <!-- /5. $PROFILE_WIDGET_LINKS_EXAMPLE --> 
        
      </div>
      <div class="col-md-4">
        <div class="panel panel-info panel-dark">
          <div class="panel-heading"> <span class="panel-title"><i class="panel-title-icon fa fa-star-o"></i> <strong>Cleanliness Rating</strong></span> <span style="float:right;font-weight: bold;font-size: 17px;"><?=$rating['clfivestar']+$rating['clfourstar']+$rating['clthreestar']+$rating['cltwostar']+$rating['clonestar'];?></div>
          <!-- / .panel-heading -->
    <div class="list-group star-icon"> 
          <a href="#" class="list-group-item"> <i class="fa fa-star list-group-icon"></i> <i class="fa fa-star list-group-icon"></i> <i class="fa fa-star list-group-icon"></i> <i class="fa fa-star list-group-icon"></i> <i class="fa fa-star list-group-icon"></i> <span class="badge badge-info"><?=$rating['clfivestar'];?></span></a> 
          <a href="#" class="list-group-item"> <i class="fa fa-star list-group-icon"></i> <i class="fa fa-star list-group-icon"></i> <i class="fa fa-star list-group-icon"></i> <i class="fa fa-star list-group-icon"></i> <span class="badge badge-info"><?=$rating['clfourstar'];?></span></a> 
          <a href="#" class="list-group-item"> <i class="fa fa-star list-group-icon"></i> <i class="fa fa-star list-group-icon"></i> <i class="fa fa-star list-group-icon"></i> <span class="badge badge-info"><?=$rating['clthreestar'];?></span></a>
          <a href="#" class="list-group-item"> <i class="fa fa-star list-group-icon"></i> <i class="fa fa-star list-group-icon"></i> <span class="badge badge-info"><?=$rating['cltwostar'];?></span></a>
          <a href="#" class="list-group-item"> <i class="fa fa-star list-group-icon"></i> <span class="badge badge-info"><?=$rating['clonestar'];?></span></a> 
            <!--<a href="#" class="list-group-item">Account settings</a>--> </div>
            
          <div class="panel widget-support-tickets" id="accordion-example1">
            <div style="padding-left:15px;padding-top:5px;"> <span class="panel-title"><i class="panel-title-icon fa fa-pencil"></i> <strong>Review</strong></span> </div>
            <!-- / .panel-heading -->
            <div class="panel-body">
              <div class="review-box rating-clean">
          <?php
                
                  for($i=0;$i<count($comments);$i++){
                    
                  ?>
                <div class="ticket"><a href="#" title="" class="ticket-title"><?=$comments[$i]['cleanliness_comment'];?> </span></a></div>
           <?php
           if($i==1)
           {
               ?>
                <div id="demo4" class="collapse">
               <?php
           }
                  }
                   if($i>1)
           {
               echo "</div>";
           }
           ?>
              </div>
              <br>
               <?php
                 if($i>1){
             echo '<a class="pull-right" data-toggle="collapse" data-target="#demo4" id="rating-clean" value="" onClick="starrating(this.id)">View All Review</a> </div>';
                 }
                 ?>
             
             
            <!-- / .panel-body --> 
          </div>
        </div>
        
        <!-- / .panel --> 
        <!-- /5. $PROFILE_WIDGET_LINKS_EXAMPLE --> 
        
      </div>
      <div class="col-md-4">
        <div class="panel panel-success panel-dark">
          <div class="panel-heading"> <span class="panel-title"><i class="panel-title-icon fa fa-star-o"></i> <strong>Faculty
            Punctuality Rating</strong></span> <span style="float:right;font-weight: bold;font-size: 17px;"><?=$rating['pfivestar']+$rating['pfourstar']+$rating['pthreestar']+$rating['ptwostar']+$rating['ponestar'];?></div>
          <!-- / .panel-heading -->
    <div class="list-group star-icon"> 
          <a href="#" class="list-group-item"> <i class="fa fa-star list-group-icon"></i> <i class="fa fa-star list-group-icon"></i> <i class="fa fa-star list-group-icon"></i> <i class="fa fa-star list-group-icon"></i> <i class="fa fa-star list-group-icon"></i> <span class="badge badge-info"><?=$rating['pfivestar'];?></span></a> 
          <a href="#" class="list-group-item"> <i class="fa fa-star list-group-icon"></i> <i class="fa fa-star list-group-icon"></i> <i class="fa fa-star list-group-icon"></i> <i class="fa fa-star list-group-icon"></i> <span class="badge badge-info"><?=$rating['pfourstar'];?></span></a> 
          <a href="#" class="list-group-item"> <i class="fa fa-star list-group-icon"></i> <i class="fa fa-star list-group-icon"></i> <i class="fa fa-star list-group-icon"></i> <span class="badge badge-info"><?=$rating['pthreestar'];?></span></a>
          <a href="#" class="list-group-item"> <i class="fa fa-star list-group-icon"></i> <i class="fa fa-star list-group-icon"></i> <span class="badge badge-info"><?=$rating['ptwostar'];?></span></a>
          <a href="#" class="list-group-item"> <i class="fa fa-star list-group-icon"></i> <span class="badge badge-info"><?=$rating['ponestar'];?></span></a> 
            <!--<a href="#" class="list-group-item">Account settings</a>--> </div>
          <div class="panel widget-support-tickets" id="accordion-example">
            <div style="padding-left:15px;padding-top:5px;"> <span class="panel-title"><i class="panel-title-icon fa fa-pencil"></i> <strong>Review</strong></span> </div>
            <!-- / .panel-heading -->
            <div class="panel-body">
              <div class="review-box rating-faculty">
                <?php
                
                  for($i=0;$i<count($comments);$i++){
                    
                  ?>
                <div class="ticket"><a href="#" title="" class="ticket-title"><?=$comments[$i]['punctuality_comment'];?> </span></a></div>
           <?php
           if($i==1)
           {
               ?>
                <div id="demo5" class="collapse">
               <?php
           }
                  }
                   if($i>1)
           {
               echo "</div>";
           }
           ?>
              </div>
              <br>
               <?php
                 if($i>1){
             echo '<a class="pull-right" data-toggle="collapse" data-target="#demo5" id="rating-faculty" value="" onClick="starrating(this.id)">View All Review</a> </div>';
                 }
                 ?>
            <!-- / .panel-body --> 
          </div>
        </div>
        
        <!-- / .panel --> 
        <!-- /5. $PROFILE_WIDGET_LINKS_EXAMPLE --> 
        
      </div>
    </div>
  </div>
  <!-- / #content-wrapper -->
  <script>
		(function($){
			$(window).on("load",function(){
				$(".review-box").mCustomScrollbar({
					setHeight:,
					theme:"dark-3"
				});
			});
		})(jQuery);
	</script>
	<script>
function starrating(id){
		var rate = $("#"+id).val();
	if(rate==""){
	$("."+id).addClass("test");
	$("#"+id).val("rv");
	}
	else{
		$("."+id).removeClass("test");
		$("#"+id).val("");
		}
return true;
	}

</script>
<script>
$('#radioBtn a').on('click', function(){
    var sel = $(this).data('title');
    var tog = $(this).data('toggle');
    $('#'+tog).prop('value', sel);
    $('a[data-toggle="'+tog+'"]').not('[data-title="'+sel+'"]').removeClass('active').addClass('notActive');
    $('a[data-toggle="'+tog+'"][data-title="'+sel+'"]').removeClass('notActive').addClass('active');
});

$(document).ready(function() {
   $("#formbtn").click(function(){
      var tutur=$("#faculty_advisor").val();
        var academic=$("#academic").val();
          var hostel=$("#hostel").val();
            var canteen=$("#canteen").val();
              var transport=$("#transport").val();
                var admin_support=$("#admin_support").val();
                  var comment=$("#comment").val();
  if(tutur=="" ||academic==""||hostel==""||canteen==""||transport==""||transport==""||admin_support==""){
      alert("Please select any one option for all list of facilities");
  }
  else if(comment=="")
  {
     alert("Please provide your suggestion.."); 
  }
  else
  {
      return true;
  }
  
   });
    
});
  	$(document).ready(function() {
		  
  $('#fdate').datepicker({format: 'dd-mm-yyyy',autoclose: true});
	 $('#tdate').datepicker({format: 'dd-mm-yyyy',autoclose: true});
  	});
</script>
