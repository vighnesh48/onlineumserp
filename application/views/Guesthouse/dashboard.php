<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<style> .panel{
   margin-bottom: 20px;
   margin-bottom: 30px;
   background: #fff;
   border: 1px solid #eaeaea;
   border-radius: 1px;
   position: relative;
   box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0), 0 3px 1px -2px rgba(0, 0, 0, 0), 0 1px 5px 0 rgba(0, 0, 0, 0.12);
   }
   .row {
   margin-right: 0px!important;
   margin-left: 0px!important;
   }
   .panel-heading1 {
   padding: 10px 15px;
   border-bottom: 1px solid transparent;
   border-top-left-radius: 3px;
   border-top-right-radius: 3px;
   background: #1d89cf;
   font-size: 18px;
   color: #fff;
   }
   .panel-body {
   padding: 0px!important;
   }
   h4 {
   color: #1d89cf!important;
   font-weight: bold;
   font-size: 16px;
   }
   .hostel-logo {
   width: 90px;
   height: 90px;
   border-radius: 50%;
   background: linear-gradient(60deg, #ffa726, #fb8c00);
   text-align: center;
   color: #fff;
   margin-left: 16%!important;
   padding: 20px 10px;
   margin-left: 10px;
   box-shadow: 0 4px 20px 0px rgba(0, 0, 0, 0.45), 0 7px 10px -5px rgba(255, 152, 0, 0.4);
   }
   .padding-lr-5{padding:0px 5px;}
   .padding-tb-15{padding:15px 0px;}
   .border-rgt {
   border-right: 1px dashed #ccc;
   }
   .datecircle {
   color: #fff;
   height: 53px;
   width: 52px;
   line-height: 52px;
   background-color: #4CAF50;
   border-radius: 50%;
   display: inline-block;
   padding-left: 11%!important;
   margin-left: 13%;
   box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.14), 0 3px 1px -2px rgba(0, 0, 0, 0.2), 0 1px 5px 0 rgba(0, 0, 0, 0.12);
   }
   .details{    border: 0;
   margin-bottom: 30px;
   margin-top: 30px;
   border-radius: 6px;
   color: #333333;
   padding: 10px 0px;
   background: #fff;
   width: 100%;
   box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.14), 0 3px 1px -2px rgba(0, 0, 0, 0.2), 0 1px 5px 0 rgba(0, 0, 0, 0.12);}
   .sidebar{background:dodgerblue;height:100%;position:fixed;z-index:1000}
   .margin-0{margin:20px 0px;}
   .
   .padding-tb-5{padding:5px 0px}
   .main{padding-left:11em;}
   .fa{font-size:0.8em}
   .dash-icon{color:white;}
   .hoverbg{background-color:transparent}
   .hoverbg:hover{background-color:#157ee5;cursor:pointer}.
   .text-center{text-align:left}
   .stik-side{position:fixed}
   .border-rgt{border-right: 1px dashed #ccc;min-height: 100px;}
   @media (max-width:768px){
   .sidebar{height:15%;width:100%}
   .main{padding-left:2em;padding-top:5em}
   .mg-tp{margin-top:1em}
   }
   .badge {
   font-size: 11px !important;
   font-weight: 300;
   text-align: center;
   /* height: 18px; */
   padding: 0px 7px;
   -webkit-border-radius: 12px !important;
   -moz-border-radius: 12px !important;
   border-radius: 12px !important;
   text-shadow: none !important;
   text-align: center;
   vertical-align: middle;
   border: #1d89cf solid 1px;
   background-color: #1d89cf;
   }
</style>
<script>
   $(document).ready(function(){
   	$('#header').html('All');
   	$('#gtype').change(function() {
   		common_call();
   	});
   	
   	$('#nperson').change(function() {
   		//common_call();
   	}); 
   	
   	$('#doc-sub-datepicker21').on('changeDate', function (e) {
   		//common_call();
   	}); 
   			
   	$('#doc-sub-datepicker22').on('changeDate', function (e) {
   		//common_call();
   	}); 
   	
   	$('#doc-sub-datepicker21').datepicker( {
     todayHighlight: true,
     format: 'dd/mm/yyyy',
     autoclose: true,
     setDate: new Date()
     });
   	$('#doc-sub-datepicker22').datepicker( {
     todayHighlight: true,
     format: 'dd/mm/yyyy',
     autoclose: true,
     setDate: new Date()
     });
   	
   }); 
   var bed_available=0;
   var gtype=0;
   function common_call()
   {
   	var ghouse=$('#gtype').val();
   	if(ghouse=='')
   	{
   		alert('Please Select Guesthouse');
   		return false;
   	}
   	else
   	{
   		$('#header').html($("#gtype option:selected").text());
   		var arr=ghouse.split("_");
   		gtype=arr[0];
   		bed_available=arr[1];
   	/* 	var nperson=$('#nperson').val();
   		var fdate=$('#doc-sub-datepicker21').val();
   		var tdate=$('#doc-sub-datepicker22').val(); */
   
   		type='POST',url='<?= base_url() ?>Guesthouse/dashboard_details_by_id';
   		datastring={gtype:gtype};//,nperson:nperson,cin:fdate,cout:tdate
   		html_content=ajaxcall(type,url,datastring);
   		//display_content(html_content);
   		$('#Container').html(html_content);
   	}	
   }
   
   
   
   function ajaxcall(type,url,datastring)
   {  
   	var res;
   	$.ajax({
   		type:type,
   		url:url,
   		data:datastring,
   		cache:false,
   		async:false,
   		success: function(result)
   	 {
   	  res=result;	 
   	 }
   	});
   	return res; 
   }
</script>
<div id="content-wrapper">
   <ul class="breadcrumb breadcrumb-page">
      <div class="breadcrumb-label text-light-gray">You are here: </div>
      <li class="active"><a href="#">Masters</a></li>
      <li class="active"><a href="<?=base_url($currentModule)?>">Guest House</a></li>
   </ul>
   <div class="page-header">
      <div class="row">
         <h1 class="col-xs-12 col-sm-5 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp; Dash Board</h1>
      </div>
      <div class="row ">
         <div class="col-sm-12">
            <div class="panel">
               <div class="panel-heading" style="margin-bottom: 20px;">
                  <div class="row ">
                     <div class="col-sm-5">
                        <span class="panel-title">
                           <h4>Guest House: <b><span id="header"></span></b></h4>
                        </span>
                     </div>
                     <div class="col-sm-2 pull-right" style="padding-left:0px;">
                        <select id="gtype" name="gtype" class="form-control" >
                           <option value="">Select Guest House</option>
                           <?php 
                              if(!empty($guesthouse_details)){
                              	foreach($guesthouse_details as $gh){
                              		?>
                           <option value="<?=$gh['gh_id'].'_'.$gh['bed_available']?>"><?=$gh['guesthouse_name']?></option>
                           <?php 
                              }
                              }
                              ?>
                        </select>
                     </div>
                     <!-- <div class="col-sm-2" style="padding-left:0px;">
                        <input type="text" class="form-control" placeholder="CheckIn Date" id="doc-sub-datepicker21" name="fdate"  readonly="true"/>
                        </div>
                        <div class="col-sm-2" style="padding-left:0px;">
                        <input type="text" class="form-control" placeholder="CheckOut Date" id="doc-sub-datepicker22" name="tdate"  readonly="true"/>
                        </div>
                        -->
                  </div>
               </div>
               <div class="panel-body" >
			         <!--New Code-->
                  <div class="row ">
                     <div class="col-sm-12" style="padding:0px 20px">
                        <!--panel1 -->
                        <div class="panel">
                           <div class="panel-heading1">Hotel Name</div>
                           <div class="panel-body">
                              <!-- Row-->
                              <Div Class="row">
                                 <div Class="col-md-2" style="padding-top:10px">
                                    <div class="hostel-logo">
                                       NASHIK<br>Trustee Office1
                                    </div>
                                    <h4 class="text-center">Room No. 102</h4>
                                 </div>
                                 <div Class="col-md-7 " style="padding-top:10px">
                                    <h4 class="text-left">Xyz</h4>
                                    <h6> <strong>Address: </strong>UTTARANCHAL,  Didihat </h6>
                                    <h6>  <strong>Pin Code: </strong></h6>
                                    <h6>  <strong>Charges: </strong></h6>
                                    <h6> <span><strong>Booking Date : </strong> <span class="glyphicon glyphicon-calendar "></span> 22 Oct 2019 10:03  <strong>TO</strong>  23 Oct 2019 10:03 </span>      <span class="padding-lr-5"><strong>Days: </strong><span class="badge budge-info"> 3  </span></span>      <span class="padding-lr-5"><strong>Bed No.: </strong><span class="badge budge-info">1</span></span></h6>
                                 </div>
                                 <div Class="col-md-3">
                                    <div class="row">
                                       <div class="col-md-6 " style="border-right:1px solid #ededed ; ;padding-top:10px;padding-bottom: 0px;">
                                          <h5 class="text-center"><strong>CHECK-IN</strong></h5>
                                          <p class="datecircle"><strong><span class="glyphicon glyphicon-calendar" ></span> 22</strong></p>
                                          <p class="text-center"><strong>October </strong></p>
                                          <p class="text-center">Today</p>
                                       </div>
                                       <div class="col-md-6 " style="padding-top:10px;">
                                          <h5 class="text-center"><strong>CHECK-Out</strong></h5>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <!-- Row-->
                        </div>
                     </div>
                     <!--panel1 -->
                  </div>
               </div>
               <!--New Code--> 
                  <!--New Code-->
                  <div class="row ">
                     <div class="col-sm-12" style="padding:0px 20px">
                        <!--panel1 -->
                        <div class="panel">
                           <div class="panel-heading1">Hotel Name</div>
                           <div class="panel-body">
                              <!-- Row-->
                              <Div Class="row">
                                 <div Class="col-md-2" style="padding-top:10px">
                                    <div class="hostel-logo">
                                       NASHIK<br>Trustee Office1
                                    </div>
                                    <h4 class="text-center">Room No. 102</h4>
                                 </div>
                                 <div Class="col-md-7 " style="padding-top:10px">
                                    <h4 class="text-left">Xyz</h4>
                                    <h6> <strong>Address: </strong>UTTARANCHAL,  Didihat </h6>
                                    <h6>  <strong>Pin Code: </strong></h6>
                                    <h6>  <strong>Charges: </strong></h6>
                                    <h6> <span><strong>Booking Date : </strong> <span class="glyphicon glyphicon-calendar "></span> 22 Oct 2019 10:03  <strong>TO</strong>  23 Oct 2019 10:03 </span>      <span class="padding-lr-5"><strong>Days: </strong><span class="badge budge-info"> 3  </span></span>      <span class="padding-lr-5"><strong>Bed No.: </strong><span class="badge budge-info">1</span></span></h6>
                                 </div>
                                 <div Class="col-md-3">
                                    <div class="row">
                                       <div class="col-md-6 " style="border-right:1px solid #ededed ; ;padding-top:10px;padding-bottom: 0px;">
                                          <h5 class="text-center"><strong>CHECK-IN</strong></h5>
                                          <p class="datecircle"><strong><span class="glyphicon glyphicon-calendar" ></span> 22</strong></p>
                                          <p class="text-center"><strong>October </strong></p>
                                          <p class="text-center">Today</p>
                                       </div>
                                       <div class="col-md-6 " style="padding-top:10px;">
                                          <h5 class="text-center"><strong>CHECK-Out</strong></h5>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <!-- Row-->
                        </div>
                     </div>
                     <!--panel1 -->
                  </div>
               </div>
               <!--New Code-->  
            </div>
         </div>
      </div>
   </div>
</div>