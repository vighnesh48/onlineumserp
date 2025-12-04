<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
  <style>
    
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
   <tr>
    <td align="center">
    <img src="http://sandipuniversity.com/erp/assets/images/SU_Logo-01.png" width="300" />
    <!-- <p style="margin-top:0"><strong>Mahiravani, Trimbak Road, Nashik – 422 213,</strong></p><br/>
        <p style="margin-top:20; font-size:18px !important;"><b><?php echo $school_name;?>.</b></p> -->

    </td>
  </tr>
</table>

 <h3 class='text-center bolddd'>DATE :<?php echo  $_POST['selectdate'];?></h3>
         
  <table class="table table-striped table-bordered" >
    <thead>
      <tr>
        <!-- <th>Sr No</th> -->
        <th>Mode</th>
        <th>Amount</th>
      </tr>
    </thead>
    <tbody>
    
    <?php
            $j=1;                      
            for($i=0;$i<count($challan_details_mode); $i++)
            {
              $arr[]=$challan_details_mode[$i]['amt'];
            
                                
                         ?>
                      <tr>
      <!--  <td><?=$j?></td> -->
    <td><?php  if($challan_details_mode[$i]['fees_paid_type']=='CASH'){echo "BANK CHALLAN";}else { echo $challan_details_mode[$i]['fees_paid_type'];}?></td>
    <td><?=$challan_details_mode[$i]['amt'];?></td>
      </tr>
      <?php
          $j++;
         }
          ?>
          <tr><td><span class='bold'>Total</span></td><td><span class='bold'><?php echo array_sum($arr);?></span></td></tr>      
  
    </tbody>
  </table>


    <table class="table table-bordered" id="search-table" style="width:100%;max-width:100%;">
                        <thead>
                            <tr>
                            <th>#</th>
                            <th>Receipt No</th>                                    
                            <th>Student Name</th>
                            <th>Amount</th>  
                            <th>Course Name</th>
                            <th>Year</th>
                            <th>Mode</th>
                            <th>Trans Date</th>
                            <th>Student Bank </th>
                            <th>Transaction No</th>
                               
                            <!-- <th>Bank</th>  
                            <th>Status</th> -->            
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php
                            $j=1;                      
                            for($i=0;$i<count($challan_details);$i++)
                            {
                                
                            ?>
                            <tr>
                                <td><?=$j?></td>                                                                
                                <td><?=$challan_details[$i]['exam_session'];?></td>
                                <td><?=$challan_details[$i]['first_name']."".$challan_details[$i]['last_name']?>
                                </td>
                                <td><?=$challan_details[$i]['amount'];?></td>
                                  <td><?=$challan_details[$i]['stream_short_name'];?></td>
                                  <td><?=$challan_details[$i]['current_year'];?></td>
                                  
                                <td><?=$challan_details[$i]['fees_paid_type']?></td>
                            
                                <td><?php if($challan_details[$i]['TransactionDate']!=''){ echo date('d-m-Y',strtotime($challan_details[$i]['TransactionDate'])); }?></td>
                               
                                <td><?=$challan_details[$i]['student_bank']?></td>
                                <td><?=$challan_details[$i]['TransactionNo']?></td>
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