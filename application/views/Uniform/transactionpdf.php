<!DOCTYPE html>
<html lang="en">
   <head>
      <title itemprop="name">Uniform Receipt</title>
      <style type="text/css">
         #snippetContent{    width: 700px;
         margin: auto;
		 margin-top:15px;
       
         }
         .div1 {
         width: 75%;
         float:left;
         overflow:hidden;
         margin-bottom:0px;
         margin-top:10px;
         }
         .div2 {
         width: 24%;
         float: right;
         overflow: hidden;
         margin-bottom:0px;
         margin-top:0px;
         }
		 
		  .div3 {
         width: 75%;
         float:left;
         overflow:hidden;
         margin-bottom:0px;
         margin-top:10px;
         }
         .div4 {
         width: 24%;
         float: right;
         overflow: hidden;
         margin-bottom:50px;
         margin-top:0px;
         }
		 
		 
		 
		 
		 
		 
		 
		 
		 
		 
		 
		 
		 
         table {
         font-family: arial, sans-serif;
         border-collapse: collapse;
         width: 100%!important;
         }
		  .table {
         font-family: arial, sans-serif;
         border-collapse: collapse;
         width: 100%!important;
         }
         td, th {
         border: 1px solid #000;
         text-align: left;
         padding: 3px;
         }
         tr:nth-child(even) {
         background-color: #dddddd;
         }
         body {
         background:#eee;
         font-family: arial, sans-serif;
         }
         p {
         font-family: arial, sans-serif;
         }
         .receipt-main {
         background: #ffffff none repeat scroll 0 0;
         border-bottom: 12px solid #333333;
         border-top: 12px solid #9f181c;
         margin-top: 0px;
         margin-bottom: 0px;
         padding: 0px 30px !important;
         position: relative;
         box-shadow: 0 1px 21px #acacac;
         color: #333333;
         }
         .receipt-main p {
         color: #333333;
         font-family: open sans;
         line-height: 1.42857;
         }
         .receipt-footer h1 {
         font-size: 15px;
         font-weight: 400 !important;
         margin: 0 !important;
         }
         .receipt-main::after {
         background: #414143 none repeat scroll 0 0;
         content: "";
         height: 5px;
         left: 0;
         position: absolute;
         right: 0;
         top: -13px;
         }
         .receipt-main thead {
         background: #414143 none repeat scroll 0 0;
         }
         .receipt-main thead th {
         color:#fff;
         }
         .receipt-right h5 {
         font-size: 15px;
         font-weight: bold;
         margin: 0 0 7px 0;
         }
         .receipt-right p {
         font-size: 13px;
         line-height:18px;
         margin: 0px;
         }
         .receipt-right p i {
         text-align: center;
         width: 18px;
         }
         .receipt-main td {
         padding: 9px 20px !important;
         }
         .receipt-main th {
         padding: 13px 20px !important;
         /* text-align: center; */
         font-size: 14px;
         }
         .receipt-main td {
         font-size: 13px;
         font-weight: initial !important;
         }
         .receipt-main td p:last-child {
         margin: 0;
         padding: 0;
         }	
         .receipt-main td h2 {
         font-size: 20px;
         font-weight: 900;
         margin: 0;
         text-transform: uppercase;
         }
         .receipt-header-mid .receipt-left h1 {
         font-weight: 100;
         margin: 0px 0 0;
         text-align: right;
         text-transform: uppercase;
         }
         .receipt-header-mid {
         margin: 24px 0;
         overflow: hidden;
         }
      </style>
   </head>
   <body>
      <div id="snippetContent" class="receipt-main">
         <div class="div1">
            <div class="receipt-right">
               <p><b>Student Name:</b> <?=$details[0]->firstname ;?></p>
               <p><b>School :</b> <?=$details[0]->org_frm."-".$details[0]->institute ;?></p>
               <p><b>Mobile :</b> <?=$details[0]->phone ;?></p>
               <p><b>Email :</b> <?=$details[0]->email ;?></p>
               
            </div>
         </div>
         <div class="div2">
            <div class="receipt-left">
		 <p>Student Copy</p>
               <h4>Transaction No: <?=$details[0]->transaction_no."-".$details[0]->tno ;?></h4>
            </div>
         </div>
         <div style="clear;both"></div>
         <div style="width:100%;padding:0px 0px!important;">
            <table class="table" style="width:100%!mportant">
       
                  <tr>
                     <td style="width:25%!mportant">Sr No.</td>
                     <td style="width:25%!mportant">Description</td>
					  <td style="width:25%!mportant">Size</td>
                     <td style="width:25%!mportant">Quantity</td>
                   
                  </tr>
           
                 
                 <?php if(!empty($details)){ 
				 $i=1;
				 foreach($details as $row){ ?>
					 <tr>
                     <td ><?=$i ;?></td>
                     <td > <?=$row->product_name ;?></td>
                     <td ><?=$row->size ;?></td>
                     <td ><?=$row->quantity ;?></td>
                  
                  </tr> 
					 
				 <?php $i++; } } ?>
                  
     
            </table><br>
<!--/************************start *********************-->
            <div class="form-group">
               <label for="remark">Remark : </label>
               <label for="remark_value"><?php echo $row->remark ;?></label>
            </div>
            <!--/************************END *********************-->
         </div>
		
		 
         <div style="clear;both"></div>
		 
         <div class="div3">
            <div class="receipt-right">
                <p><b>Date :</b> <?=$row->tcreated_at ;?></p>
			       <!-- <p> I received about product by checking sizes and i am comfortable with this. </p> -->
                <p> I received Correct size product and i am comfortable with this. </p>
               
            </div>
         </div>
         <div class="div4">
            <div class="receipt-left">
                  <h5>Student Name & Signature</h5>
            </div>
         </div>
      </div>
      </div>

	   <hr/>
	   	
	   <div id="snippetContent" class="receipt-main">
         <div class="div1">
            <div class="receipt-right">
               <p><b>Student Name:</b> <?=$details[0]->firstname ;?></p>
               <p><b>School :</b> <?=$details[0]->org_frm."-".$details[0]->institute ;?></p>
               <p><b>Mobile :</b> <?=$details[0]->phone ;?></p>
               <p><b>Email :</b> <?=$details[0]->email ;?></p>
			  
             
            </div>
         </div>
         <div class="div2">
            <div class="receipt-left">
			<p>Office Copy </p>
               <h4>Transaction No: <?=$details[0]->transaction_no."-".$details[0]->tno ;?></h4>
            </div>
         </div>
         <div style="clear;both"></div>
         <div style="width:100%;padding:0px 0px!important;">
            <table class="table" style="width:100%!mportant">
       
                  <tr>
                     <td style="width:25%!mportant">Sr No.</td>
                     <td style="width:25%!mportant">Description</td>
					  <td style="width:25%!mportant">Size</td>
                     <td style="width:25%!mportant">Quantity</td>
                     
                   
                  </tr>
           
                 
                 <?php if(!empty($details)){ 
				 $i=1;
				 foreach($details as $row){ ?>
					 <tr>
                     <td ><?=$i ;?></td>
                     <td > <?=$row->product_name ;?></td>
                     <td ><?=$row->size ;?></td>
                     <td ><?=$row->quantity ;?></td>
                    
                  </tr> 
					 
				 <?php $i++; } } ?>
                  
     
            </table><br>
<!--/************************start *********************-->
            <div class="form-group">
               <label for="remark">Remark : </label>
               <label for="remark_value"><?php echo $row->remark ;?></label>
            </div>
<!--/************************END *********************-->
         </div>
	
		 
         <div style="clear;both"></div>
         <div class="div3">
            <div class="receipt-right">
                <p><b>Date :</b> <?=$row->tcreated_at ;?></p>
                  <!-- <p> I received about product by checking sizes and i am comfortable with this. </p> -->
                  <p> I received Correct size product and i am comfortable with this. </p>
            </div>
         </div>
         <div class="div4">
            <div class="receipt-left">
               <h5>Student Name & Signature</h5>
            </div>
         </div>
      </div>
      </div>
	  
	  
	  
	  
	  
	  
	  
	  
	  
   </body>
</html>