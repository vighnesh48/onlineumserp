<link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
<style>     
   .panel-default>.panel-heading {
   color: #333;
   background-color: #f5f5f5;
   border-color: #ddd;
   margin-top: 0;
   /* margin-bottom: 20px; */
   background: #ffc844;
   padding: 5px;
   text-transform: uppercase;
   }
   h3 {
    font-size: 23px;
	font-weight:bold;
	margin-top: 10px;
    margin-bottom: 10px;
}

   h4{color: #F44336;}
   #profile-image1 {
   width: 150px;
   height: 150px;
   border: 7px solid #b7b7b7;
   /* background-color: #eee5de; */
   position: relative;
   border-inline-start: 7px #ffc844 solid;
   border-radius: 50%;
   margin: 0 auto;}
   .tital{ font-size:13px; font-weight:500;line-height:24px;padding-left: 0px;}
   .bot-border{ border-bottom:1px #f8f8f8 solid;  margin:5px 0  5px 0}	
   p{    font-family: "Open Sans","Helvetica Neue",Helvetica,Arial,sans-serif;
   font-size: 13px;}
   .panel-default {
   border-color: #ffc844;
   }
   
   .padding-top{padding-top: 67px;}
</style>
<!------ Include the above in your HEAD tag ---------->
<?php    
$prn=$this->session->userdata['name'];	  
$profile = base_url() . "uploads/student_photo/".$prn.".jpg";//exit;
$profile1 ="uploads/student_photo/".$prn.".jpg";
?>
<div id="content-wrapper">
<div class="page-header">
   <div class="row">
   <div class="col-sm-12">
        <div class="panel">
          <div class="panel-body">
   <!--image Upload-->
      <div class="col-md-12">
         <div class="panel panel-default">
            <div class="panel-heading">
               <h3 >User Profile <small style='color:red;'>(This Photo will be printed on Hallticket, Marksheet, ID card)</small></h3>
            </div>
            <div class="panel-body">
               <div class="box box-info">
                  <div class="box-body">
                     <div class="col-sm-6">
                        <div  align="center">
					<?php if(file_exists($profile1)) { ?>
					<img alt="User Pic" src="<?=$profile?>" id="profile-image1" class="img-circle img-responsive">
					<?php }else { ?>
					   <img alt="User Pic" src="https://x1.xingassets.com/assets/frontend_minified/img/users/nobody_m.original.jpg" id="profile-image1" class="img-circle img-responsive"> 
					<?php }?>
                            
							
                           <div style="color:#F44336;"><strong>&nbsp;<br></strong></div>
						   <form method="post" action="<?=base_url()?>Ums_admission/update_student_picsDetails/" enctype="multipart/form-data">
						   <div class="form-group">

                                    <label class="col-sm-6">Upload Photo*:</label>   
                                    <div  class="col-sm-6"><input type="file" name="profile_img" required></div>
									 
                                  </div>
								  <div class="form-group">
									 <div  class="col-sm-2"></div>
									 <div  class="col-sm-10"><button class="btn btn-success btn-sm text-center" type="submit">Upload</button></div>
									
                                  </div>
								  <div class="form-group">
									
									 <h4> <?php echo $error;?> </h4>
									<span  style="color:#3b9c96;"><?php echo $success;?></span>
                                  </div>
							</form>	   
                        </div>
                     </div>
					 <div class="col-sm-6">
                     <h4 >Photo Specification </h4>
                     <hr style="margin:5px 0 5px 0;">
                     <div class="col-sm-12 col-xs-12 tital " ><strong>Size: 51mm x 51mm or 2x2 inches.</div>
                     <div class="clearfix"></div>
                     <div class="bot-border"></div>
                     <div class="col-sm-12 col-xs-12 tital " > <strong>Color:</strong> Natural color so skin tone is clearly visible.</div>
                     <div class="clearfix"></div>
                     <div class="bot-border"></div>
                     <div class="col-sm-12 col-xs-12 tital " ><strong>Head size and position:</strong>  Head needs to be centered and looking at the camera. Head should be 35mm to 40mm.</div>
                     <div class="clearfix"></div>
                     <div class="bot-border"></div>
                     <div class="col-sm-12 col-xs-12 tital " ><strong>Recency:</strong>  Taken in the last 6 months.</div>
                     <div class="clearfix"></div>
                     <div class="bot-border"></div>
                     <div class="col-sm-12 col-xs-12 tital " ><strong>Background:</strong>  Plain white and solid design.</div>
                     <div class="clearfix"></div>
                     <div class="bot-border"></div>
                     <div class="col-sm-12 col-xs-12 tital " ><strong>Smile:</strong>  No smile. Only neutral expression.</div>
                     <div class="clearfix"></div>
                     <div class="bot-border"></div>
                     <div class="col-sm-12 col-xs-12 tital " ><strong>Eyes:</strong>  Open and looking directly at camera.</div>
                     <div class="clearfix"></div>
                     <div class="bot-border"></div>
                     <div class="col-sm-12 col-xs-12 tital " ><strong>Glasses:</strong>  Only prescription glasses are permitted.</div>
                     <div class="clearfix"></div>
                     <div class="bot-border"></div>
                     <div class="col-sm-12 col-xs-12 tital " ><strong>Headgear:</strong>  Religious purposes only and cannot block face.</div>
                     <div class="clearfix"></div>
                     <div class="bot-border"></div>
                     <div class="col-sm-12 col-xs-12 tital " ><strong>Dimensions and size (pixels):</strong>  10KB to 300KB. For pixels: 300x300 pixels and 350x500 maximum.</div>
					 <div class="col-sm-12 col-xs-12 tital " ><strong>File Format :</strong> Only JPG</div>
                     <div class="clearfix"></div>
                     <div class="bot-border"></div>
                     <div class="col-sm-12 col-xs-12 tital " ><strong>Attire, clothing, dress code: </strong> Casual or professional preferred.</div>
                     <div class="clearfix"></div>
                     <div class="bot-border"></div>
                     <div class="col-sm-12 col-xs-12 tital " ><strong>Beard:</strong>  Optional.</div>
                   
                  </div>
                 <!--specification-->
				 </div>
					 </div>
					    <!--image Upload->
					 <!--specification-->
                     <div class="clearfix"></div>
					 
               </div>
			 </div>
            </div>
          </div>
            </div>
         </div>
      </div>
	        </div>
      <script>
         $(function() {
         $('#profile-image1').on('click', function() {
         $('#profile-image-upload').click();
         });
         });     
         $(function() {
         $('#profile-image').on('click', function() {
         $('#profile-image-upload').click();
         });
         }); 		 
      </script> 
   </div>
</div>