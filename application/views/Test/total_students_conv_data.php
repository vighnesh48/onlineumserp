<style>
.table{width:100%;} 
table{max-width: 100%;}
tbody, td, tfoot, th, thead, tr {
      padding: 5px!important;
      text-align: left;
      }
</style>
    <div class="page-header">
        <div class="row">
             <div class="col-sm-12">
                <div class="fancy-collapse-panel">
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                        <div class="panel panel-default">
                             <div class="table-responsive">
                                <div class="panel-heading" role="tab" id="headingOne">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne1" aria-expanded="true" aria-controls="collapseOne1"><?=$summary_list[0]['student_name']?>
                                        </a>
                                    </h4>
                                </div>
                                    <div id="collapseOne1" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                        <div class="panel-body table-reponsive" style="width:100%;overflow:scroll;height:700px;padding:0px;">
<table width="100%" border="0">
                                    <tbody>
                                       <tr>
									     <td rowspan="8" width="10%">
                                             <div class="" style="width: 100pxpx;
                                                height: 100pxpx;border:#ccc Solid 1px
                                                ">
												<?php
			    $bucket_key = 'https://erp.sandipuniversity.com/uploads/student_photo/'.$summary_list[0]['enrollment_no'].'.jpg';
			    //$imageData = $this->awssdk->getsignedurl($bucket_key);
			    //$imageData = '';
				if($imageData !=''){
					$imageData='';
				}else{
					$imageData="photo.jpg";
				}
				$member_details=ucfirst($summary_list[0]['member_details']);
				$member_relations=ucfirst($summary_list[0]['member_relations']);
			?>
                                                <img src="<?=$bucket_key?>" width="200px" height="200PX" >
                                             </div>
                                          </td>
                                          <td >
                                             PRN No: <strong><?=$summary_list[0]['enrollment_no'];?></strong><hr/>
                                          </td>
                                         
                                        
                                       </tr>
                                       <tr>
                                          <td width="">
                                            Graduand Name : <strong><?=$summary_list[0]['first_name'];?> <?=$summary_list[0]['middle_name'];?> <?=$summary_list[0]['last_name'];?></strong><hr/>
                                          </td>
                                         
                                       </tr>
                                       <tr>
                                          <td width="">
                                            Programme Name : <strong><?=$summary_list[0]['stream_name'];?></strong><hr/>
                                          </td>
                                        
                                       </tr>
									    <tr>
                                          <td width="">
                                            Total Members : <strong><?=1+$summary_list[0]['no_of_members'];?></strong><hr/>
                                          </td>
                                        
                                       </tr>
									    <tr>
                                          <td width="">
                                             Member details : <strong><?php if($member_details !=''){ echo $member_details;}else{echo '-';};?></strong><hr/>
                                          </td>
                                        
                                       </tr>
									    <tr>
                                          <td width="">
                                             Member Relations : <strong><?php if($member_relations !=''){ echo $member_relations;}else{echo '-';};?></strong><hr/>
                                          </td>
                                        
                                       </tr>
									   <?php if($this->session->userdata('name')=='su_canteen'){ ?>
									    <tr>
                                          <td width="">
											<?php if($summary_list[0]['allow_for_canteen'] =='Y'){ echo '<span style="color:red;"><b>Allowed for meal</b></span>';}else{?>
                                             <a href="<?=base_url()?>test/updatecanteenstatus/<?=$summary_list[0]['enrollment_no']?>"><button class="btn btn-primary" onclick="return confirm('Are you sure you want to allow?');">Allow for Meal </button>
											<?php }?>
                                          </td>
                                       </tr>
									   <?php }if($this->session->userdata('name')=='su_convocation'){?>
									   <tr>
                                        <td width="">
                                            <?php if($summary_list[0]['allow_for_convocation_hall'] =='Y'){ echo '<span style="color:red;"><b>Allowed for Convocation</b></span>';}else{?>
                                             <a href="<?=base_url()?>test/updateconvcationstatus/<?=$summary_list[0]['enrollment_no']?>"><button class="btn btn-primary" onclick="return confirm('Are you sure you want to allow?');">Allow for Convocation hall</button>
											<?php }?> 
                                          </td>
                                       </tr>
									   <?php }?>
                                    </tbody>
                                 </table>
								 					
        	                            </div>
                                    </div>				
                            </div>
                        </div>
                    </div>
                </div>
             </div>   
            </div>
        </div>
    </div>
            
   
<style>
	  hr {
    margin-top: 0rem!important;
    margin-bottom: 0rem!important;
    border: 0;
    border-top: 1px dashed rgb(255 255 255 / 90%)!important;
}
         .facility {
         box-shadow: none!important;
         }
         .btn-light:hover {
         color: #000!important;
         background-color: #fcc806!important;
         border-color: #fcc806!important;
         }
         .form-control{
         border:1px solid #e6e6e6!important;
         margin-bottom: 10px!important;
         background: #ffffff!important;
         height: 33px !important;
         }
         .why-reason:hover .why-description{    background: transparent!important;}
		 .cardpad{padding:10px; Margin:0px 0px 10px 0px;
      </style>

   <!--Head--> 
   <style>
      tbody, td, tfoot, th, thead, tr {
      padding: 5px!important;
      text-align: left;
      }
      .myDiv,.myDiv1,.myDiv2,.myDiv3{
      display:none;
      }  
      #showOne{
      }
      #showTwo{
		  display:block;
      }
      #showThree{
      }
      #showFour{
      }
      #showFive{
      } 
      #showSix{
      } 
      .ap-form-sec{padding:40px;}
      .pp{
      padding:120px 30px 50px 30px}
      @media screen and (max-width: 767px){
      .mobimg {
      display: none;
      }
      .pp {
      padding: 21px;
      }
      h2 {
      font-size: 17px!important;
      }
      }
      /* Simple CSS3 Fade-in-down Animation */
      .fadeInDown {
      -webkit-animation-name: fadeInDown;
      animation-name: fadeInDown;
      -webkit-animation-duration: 1s;
      animation-duration: 1s;
      -webkit-animation-fill-mode: both;
      animation-fill-mode: both;
      }
      @-webkit-keyframes fadeInDown {
      0% {
      opacity: 0;
      -webkit-transform: translate3d(0, -100%, 0);
      transform: translate3d(0, -100%, 0);
      }
      100% {
      opacity: 1;
      -webkit-transform: none;
      transform: none;
      }
      }
      @keyframes fadeInDown {
      0% {
      opacity: 0;
      -webkit-transform: translate3d(0, -100%, 0);
      transform: translate3d(0, -100%, 0);
      }
      100% {
      opacity: 1;
      -webkit-transform: none;
      transform: none;
      }
      }
   </style>

<style>
         input[type=button] {
         background-color: #ea1f28;
         border: none;
         color: #fff;
         padding: 11px 32px !important;
         text-align: center;
         text-decoration: none;
         display: inline-block;
         text-transform: uppercase;
         font-size: 13px;
         -webkit-box-shadow: 0 10px 30px 0 rgba(95, 186, 233, 0.4);
         box-shadow: 0 10px 30px 0 rgba(95, 186, 233, 0.4);
         -webkit-border-radius: 5px 5px 5px 5px;
         border-radius: 5px 5px 5px 5px;
         margin: 5px 20px 40px;
         -webkit-transition: all .3s ease-in-out;
         -moz-transition: all .3s ease-in-out;
         -ms-transition: all .3s ease-in-out;
         -o-transition: all .3s ease-in-out;
         transition: all .3s ease-in-out
         }
         .bg-gra-03 {
         width: 100%;
         float: left;
         /* background-image: url(bg.jpg);*/
         height: auto;
         background-size: cover;
         padding-bottom: 90px;
         padding-bottom: 90px;
         background-position: center
         }
         .card-5 .card-body {
         background-image: url(logo-bg.jpg);
         background-position: center;
         background-size: cover
         }
         .card-5 .card-body {
         padding: 33px!important;
         }
         .card {
         -webkit-border-radius: 3px;
         -moz-border-radius: 3px;
         border-radius: 3px;
         background: #fff
         }
         .card-5 {
         background: #fff;
         margin-top: 30px;
         -webkit-border-radius: 10px;
         -moz-border-radius: 10px;
         border-radius: 10px;
         -webkit-box-shadow: 0 8px 20px 0 rgba(0, 0, 0, 0.15);
         -moz-box-shadow: 0 8px 20px 0 rgba(0, 0, 0, 0.15);
         box-shadow: 0 8px 20px 0 rgba(0, 0, 0, 0.15)
         }
         .card-5 .card-heading {
         padding: 4px 0;
         background: #ea1f28;
         -webkit-border-top-left-radius: 10px;
         -moz-border-radius-topleft: 10px;
         border-top-left-radius: 10px;
         -webkit-border-top-right-radius: 10px;
         -moz-border-radius-topright: 10px;
         border-top-right-radius: 10px;
         text-align: center
         }
         h2 {
         font-size: 28px
         }
         .card-5 .card-body {
         padding-bottom: 73px
         }
         @media (max-width: 767px) {
         .card-5 .card-body {
         padding: 40px 30px;
         padding-bottom: 50px
         }
         }
         .text360c {
         color: var(--text-color-off-gray);
         font-size: 12px;
         font-family: var(--secondary-sub-font);
         margin-left: 5px;
         position: relative
         }
         .upper-menu {
         justify-content: space-between
         }
         .step-one-menu>li>a {
         color: #161616
         }
         header::before {
         background: red !important
         }
         header.dark-grey-bg .white-call-box {
         height: 54px;
         margin-top: 2px
         }
         header.dark-grey-bg .side-call {
         background: #ea1f28
         }
         @media (max-width:1399px) {
         .step-one-menu>li>a {
         padding: 22px 8.9px
         }
         }
         @media (max-width:1599px) {
         .white-call-box {
         top: 12px;
         height: 49px
         }
         .dd-menu>a::before {
         right: 2px;
         top: 32px;
         color: #ff0
         }
		 tbody, td, tfoot, th, thead, tr {
    padding: 0px 10px!important;
    text-align: left;
}
         .step-two-menu {
         top: 70px
         }
         header.dark-grey-bg .white-call-box {
         height: 54px
         }
         }
         .topnav {
         overflow: hidden;
         background-color: #333
         }
         .topnav a {
         float: left;
         display: block;
         color: #f2f2f2;
         text-align: center;
         padding: 14px 16px;
         text-decoration: none;
         font-size: 17px
         }
         .topnav a:hover {
         background-color: #ddd;
         color: #000
         }
         .topnav a.active {
         background-color: #04aa6d;
         color: #fff
         }
         .topnav .icon {
         display: none
         }
         @media screen and (max-width:600px) {
         .topnav a:not(:first-child) {
         display: none
         }
         .topnav a.icon {
         float: right;
         display: block
         }
         .topnav.responsive {
         position: relative
         }
         .topnav.responsive .icon {
         position: absolute;
         right: 0;
         top: 0
         }
         .topnav.responsive a {
         float: none;
         display: block;
         text-align: left
         }
         }
         @media screen and (min-width:1024px) {
         .sticky {
         top: -46px
         }
         }
      </style>