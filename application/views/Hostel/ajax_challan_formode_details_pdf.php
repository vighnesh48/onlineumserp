<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
  <style>
.table-bordered>tbody>tr>td{
	    border-color: #160101!important;
}    
table  th{
  border-spacing: 20px;
  
  border-collapse: collapse;
  text-align: center; 
  padding:5px;
}
td {

  padding: 10px;
  
  text-align: center; 
  padding:5px;
}
.bold
{
  font-weight: bold !important;

  
}
.bolddd
{
  font-weight: 500 !important;

  
}
</style>
</head>


<body>

<div class="container">

 <table width="100%" border="0" cellspacing="0" cellpadding="0" id="maintable">
   <tr >
    <td align="center">
    <img src="http://sandipuniversity.com/erp/assets/images/sf_logo.png" width="300" />
    </td>
  </tr>
</table>

 <h4 class='text-center '>DATE :<?php echo  $_POST['selectdate'];?></h4>
         
  <table class="table table-striped table-bordered" style="border: #160101 SOLID 1PX!important;">
    <thead>
      <tr style="border: #160101 SOLID 1PX!important;">
        <!-- <th>Sr No</th> -->
        <th style="border: #160101 SOLID 1PX!important;">Mode</th>
        <th style="border: #160101 SOLID 1PX!important;">Amount</th>
      </tr>
    </thead>
    <tbody>
    
    <?php
            $j=1;                      
            for($i=0;$i<count($challan_details_mode); $i++)
            {
              $arr[]=$challan_details_mode[$i]['amt'];
            
                                
                         ?>
                      <tr style="border: #160101 SOLID 1PX!important;">
      <!--  <td><?=$j?></td> -->
    <td style="border: #160101 SOLID 1PX!important;"><?php  if($challan_details_mode[$i]['fees_paid_type']=='CASH'){echo "BANK CHALLAN";}else { echo $challan_details_mode[$i]['fees_paid_type'];}?></td>
    <td><?=$challan_details_mode[$i]['amt'];?></td>
      </tr>
      <?php
          $j++;
         }
          ?>
          <tr style="border: #160101 SOLID 1PX!important;"><td style="border: #160101 SOLID 1PX!important;"><span class='bold'>Total</span></td><td><span class='bold'><?php echo array_sum($arr);?></span></td></tr>      
  
    </tbody>
  </table>


    <table class="table table-bordered" id="search-table" style="width:100%;max-width:100%;border:#000 solid 1px!important;">
                        <thead style="border-color: #160101!important;">
                            <tr style="border: #160101 SOLID 1PX!important;">
                            <th style="border: #160101 SOLID 1PX!important;">#</th>
                            <th style="border: #160101 SOLID 1PX!important;">Receipt No</th>  
							<th style="border: #160101 SOLID 1PX!important;">PRN</th>
                            <th style="border: #160101 SOLID 1PX!important;">Student Name</th> 
							<th style="border: #160101 SOLID 1PX!important;">Org.</th>							
                            <th style="border: #160101 SOLID 1PX!important;">school Name</th>
							<th style="border: #160101 SOLID 1PX!important;">Amount</th>  
                            <th style="border: #160101 SOLID 1PX!important;">Mode</th>
                            <th style="border: #160101 SOLID 1PX!important;">Trans Date</th>     
                            <th style="border: #160101 SOLID 1PX!important;">Transaction No</th>
                            <th style="border: #160101 SOLID 1PX!important;">Year</th>  
                            <!-- <th>Bank</th>  
                            <th>Status</th> -->            
                            </tr>
                        </thead>
                        <tbody id="itemContainer" style="border: #160101 SOLID 1PX!important;">
                            <?php
                            $j=1;                      
                            for($i=0;$i<count($challan_details);$i++)
                            {
                                
                            ?>
                            <tr style="border: #160101 SOLID 1PX!important;">
                                <td style="border: #160101 SOLID 1PX!important;"><?=$j?></td>                                                                
                                <td style="border: #160101 SOLID 1PX!important;"><?=$challan_details[$i]['exam_session'];?></td>
								<td style="border: #160101 SOLID 1PX!important;"><?=$challan_details[$i]['enrollment_no'];?></td>
                                <td style="border: #160101 SOLID 1PX!important;"><?=$challan_details[$i]['first_name']."".$challan_details[$i]['last_name']?></td>
                                <td style="border: #160101 SOLID 1PX!important;"><?=$challan_details[$i]['organisation'];?></td>
                                <td style="border: #160101 SOLID 1PX!important;"><?=$challan_details[$i]['school_name'];?></td>
								<td style="border: #160101 SOLID 1PX!important;"><?=$challan_details[$i]['amount'];?></td>
                                <td style="border: #160101 SOLID 1PX!important;"><?=$challan_details[$i]['fees_paid_type']?></td>
								<td style="border: #160101 SOLID 1PX!important;"><?php if($challan_details[$i]['fees_date']!=''){ echo date('d-m-Y',strtotime($challan_details[$i]['fees_date'])); }else{echo "-";}?></td>
                               <td style="border: #160101 SOLID 1PX!important;"><?=$challan_details[$i]['receipt_no']?></td>
                                <td style="border: #160101 SOLID 1PX!important;"><?=$challan_details[$i]['current_year']?></td>
                                
                               <!--  <td><?php  echo date('d-m-Y',strtotime($challan_details[$i]['created_on'])); ?></td> -->
                                <!--   <td><?=$challan_details[$i]['su_bank_name']?></td> -->


                              <!--   <td><?php if($challan_details[$i]['challan_status']=='VR')echo '<span style="color:Green" >Deposited</span>';
                                            else if($challan_details[$i]['challan_status']=='CL')echo '<span style="color:red" >Cancelled</span>';else echo '<span style="color:#1d89cf" >Pending</span>';?></td> -->
                               
                               
                               
                              
                                
                            </tr>
                                <?php
                                $j++;
                            }
                            ?>                            
                        </tbody>
                    </table>
</div>

</body>
</html>