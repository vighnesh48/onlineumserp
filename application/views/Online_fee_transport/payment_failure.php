<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<script src="<?=base_url('assets/javascripts')?>/jquery.table2excel.js"></script>


<script src="<?=base_url('assets/javascripts')?>/bootstrap-datepicker.js "></script>
 									
	<style>
	.table{width: 125%;}
	table{max-width: 125%;}
	</style>

<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Fee Payment</a></li>
        <li class="active"><a href="#">Online Fee</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Payment </h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                    <?php //if(in_array("Add", $my_privileges)) { ?>
                    <div class="visible-xs clearfix form-group-margin"></div>
                    <?php// } ?>
                    <?php //if(in_array("Search", $my_privileges)) { ?>
                   <!--<form class="pull-right col-xs-12 col-sm-6" action="">
                        <div class="input-group no-margin">
                            <span style="border:none;background: #fff;background: rgba(0,0,0,.05);" class="input-group-addon"><i class="fa fa-search"></i></span>
                            <select id="search_me" name="search_me" style="border:none;background: #fff;background: rgba(0,0,0,.05);" class="form-control no-padding-hr" placeholder="Search...">
                                <option value="">Select Title</option>
                                <?php
                                    for($i=0;$i<count($emp_list);$i++)
                                    {
                                ?>
                                <option value="<?=$emp_list[$i]['emp_id']?>"><?=$emp_list[$i]['fname'].' '.$emp_list[$i]['lname']?></option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>
                    </form>-->
                    <?php //} ?>
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-sm-12">&nbsp;</div>
        </div>
       <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                <div class="panel-heading">
                        <span class="panel-title">Payment List</span>
                        <div class="holder"></div>
                </div>

            <div class="table-info panel-body">  
             <style>
.contact_des h4 {
    font-size: 28px;font-weight:bold;
    margin: 7px 0px 7px 0px;text-transform: uppercase;
}
.contact_des p{font-size: 17px;}
.contact_des h4 span {
    color:green;
}
.contact_des button{font-size:21px;margin-bottom:0;}
section{padding-bottom:0px;}
.inputs_des{margin-bottom:0;}
.form-group{margin-bottom:10px;}
.kf_inr_banner{background-image:url(../images/inrbg-form.jpg);}
.kf_inr_banner:before{background: rgba(0,0,0,0.5);}
.contact_2_headung{margin-bottom:0px;border-bottom:0px;}
.contact_2_headung::before{display:none;}
.pay-form-bg{margin-bottom:40px;}
</style>
<body>
	<!--KF KODE WRAPPER WRAP START-->
    <div class="kode_wrapper">
    <!-- register Modal -->

<!--HEADER END-->

    

    	<!--Content Wrap Start-->
    	<div class="kf_content_wrap pay-online-bg" >
    		<section>
    			
				<div class="container">
				
                    <div class="contct_wrap">
                        <div class="row">
                            
                            <div class="col-md-12">
                                <div class="row">
                                   <div class="col-md-1"></div>
                                    <div class="col-lg-10 pay-form-bg">
                                        <!--<div class="col-md-4"><img src="../images/form-bg.png" class="img-responsive"/></div>-->
                                       
                                <?php
                                
   /*                             
		$user_mobile = $udf4;
		
       $ch = curl_init();
   
   
   $sms=urlencode("Dear Student
Your last transaction is failed. Please check and try again later
Thanks
Sandip University");
$query="?username=SANDIP03&password=SANDIP@2018&from=SANDIP&to=$user_mobile&text=$sms&coding=0";
    curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_URL,'http://49.50.67.32/smsapi/httpapi.jsp' . $query); 
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_TIMEOUT, 3);
$content = trim(curl_exec($ch));
curl_close($ch);*/


                                
                                ?>
                                <div class="contact_des">
                                        <h4 class="text-center"><span> Transaction Failure </span></h4>
                                 
        
                                <p class="text-center">Sorry Your Lat Transaction Failed</p>
                                <p class="text-center"></p>
                               <p class="text-center">Try again</p>
                              

                         
                             

                            </div>

                     
	    			</div>
	    			<div class="col-md-1"></div>
				</div>
    		</section>
    	</div>
           </div>
            </div>    
        </div>
    </div>
</div>

