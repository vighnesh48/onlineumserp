<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Staff IN/OUT DETAILS </title>
<style>
.result-table td{
border: 0px solid black !important;
text-align: center;
font-size:12px;
font-weight: 600;
	}
.result-table{
 border: 1px solid black !important;
 background: #ddd;margin: 15px 0;	
}
.result-count{
background-color: #ddd;
width:60%;
margin: 5px auto;
padding: 0px 0;
color: #000;text-align: center;
font-size:13px; border: 1px solid #b0b0b0 !important;	
	}
	.highlight{color:red;font-weight: bold;}
</style>
</head>

<body>
<?php $CI =& get_instance();
$CI->load->model('Admin_model');?>
<div class="col-lg-12">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top" width="100"><img src="<?php echo site_url();?>assets/images/lg.png" alt="Sandip University" class="img-responsive"></td>
    <td valign="top" align="center">
    <span style="font-size:25px;text-align:center"><b>Sandip University</b></span><br>
    <span style="text-align:center;font-size:11px">Trimbak Road, A/p - Mahiravani, Nashik – 422 213</span><br>
    <span style="font-size:10px;text-align:center">Website : http://www.sandipuniversity.com | Email : info@sandipuniversity.com </span><br>
    <span style="font-size:15px;;text-align:center"><strong>Ph: (02594) 222 541 Fax: (02594) 222 555</strong></span>
    </td>
  </tr>
</table>
<hr  style="border-width:1px;">

</div>

<div style="white-space:nowrap;text-align:center;padding:10px;"><strong>Staff IN/OUT DETAILS FOR THE MONTH OF <?php echo date('M Y',strtotime($attend_date));?></strong></div>
			 		<div style="width:50%;float:left;">Staff Id: <?php echo $this->session->userdata("name"); ?></div>
					<?php $emp= $CI->Admin_model->getEmployeeById($this->session->userdata("name"), 'Y'); ?>
					<div  style="width:50%;float:left;text-align:right;">Department : <?php echo $emp[0]['department_name']; ?></div>
					<div style="margin-bottom:10px;">Name: <?php echo $emp[0]['fname']." ".$emp[0]['mname']." ".$emp[0]['lname'];?></div>
<table  border="1" style="page-break-inside:always;" id="saltab" class="table table-bordered table-hover" width="100%"  cellpadding="3">
								  <thead>
								  <tr>
								  <th width="150">DATE</th>
                                <th width="150">DAY</th>
                                <th width="150">IN-TIME</th>
                                <th width="150">OUT-TIME</th>
                                <th width="150">DURATION</th>
								<th width="150">STATUS</th>
								<th width="150">LEAVE TYPE</th>
						
						</tr></thead><tbody>		
<?php //print_r($attendance);
//exit;

if(!empty($attendance)){
	$d = date_parse_from_format("Y-m-d",$attend_date);
        $msearch=$d["month"];//month number
        $ysearch=date("Y",strtotime($attend_date));
		$monthName = date('F', mktime(0, 0, 0, $msearch, 10));// month name
	//echo '<div class="col-lg-12" style="margin-bottom:10px;padding:0px;font-size:16px;"><label ><b>Monthly Attendance Report Of '.$monthName.' '.$ysearch.'</b></label></div><br>';

//echo $attend_date;
$date =  $attend_date."-01";
$lt=date('t', strtotime($attend_date)); //get end date of month
$end = $attend_date."-".$lt;
$time=strtotime($attend_date);
		$d = date_parse_from_format("Y-m-d",$attend_date);
        $msearch=$d["month"];//month number
        $ysearch=date("Y",strtotime($attend_date));
		$monthName = date('F', mktime(0, 0, 0, $msearch, 10));// month name
$i = 1;
 while(strtotime($date) <= strtotime($end)) {
        $day_num = date('d', strtotime($date));
		$day_name = date('D', strtotime($date));
		$totaldays['total'][]=$day_num;
		$totaldays['weekd'][]=$day_name ;
		//echo $attendance[$i];
		$dtime = explode(',',$attendance[$i]); 
        $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
$dname =  $attend_date."-".$day_num;
	   $dname = date('Y-m-d',strtotime($dname));
	   $check_holiday=$CI->Admin_model->checkHoliday($dname);
?>
                              <tr style="border: 1px solid black;">
                                <td style="text-align:center;"><?php 
echo date('d-m-Y',strtotime($attend_date."-".$day_num)); ?></td>
                                <td style="text-align:center;"><?php 
	   	   if($day_name == 'Sun'){
		   echo "<b style='color:red;'>".$day_name."</b>"; 
	   }else{
	   echo $day_name; }?></td>
                                <td style="text-align:center;"><?php 
	    //echo "kk".$dtime[0];
	   if($dtime[0]!=''){
	   if($check_holiday=='true' && date('H:i:s',strtotime($dtime[0])) == '00:00:00'){
					
			 echo "<b style='color:red;'>00.00</b>";	
	   }else{
	   if($day_name == 'Sun' && date('H:i:s',strtotime($dtime[0])) == '00:00:00'){
		   echo "<b style='color:red;'>00.00</b>";
	   }else{
		   //echo $dtime[0];
             if($dtime[0] == '0000-00-00 00:00:00'){
echo "00:00";
}else{
	   if(($check_holiday=='true' || $day_name == 'Sun' )&& date('H:i:s',strtotime($dtime[0])) != '00:00:00'){
         echo  "<span style='color:red;' >".date('H:i:s',strtotime($dtime[0]))."</span>"; 
    }else{
	   echo  date('H:i:s',strtotime($dtime[0])); 
    }
} 
	   }	}  }else{
		  echo "00:00";
	   } 
      ?></td>
                                <td style="text-align:center;"><?php 
								if($dtime[1]!=''){
	   if($check_holiday=='true' && date('H:i:s',strtotime($dtime[1])) == '00:00:00' ){
					
			 echo "<b style='color:red;'>00.00</b>";	
	   }else{
	   if($day_name == 'Sun' && date('H:i:s',strtotime($dtime[1])) == '00:00:00'){
		   echo "<b style='color:red;'>00.00</b>";
	   }else{
 if($dtime[1] == '0000-00-00 00:00:00'){
echo "00:00";
}else{
    
    if(($check_holiday=='true' || $day_name == 'Sun' )&& $dtime[1] != ''){
         echo  "<span style='color:red;' >".date('H:i:s',strtotime($dtime[1]))."</span>"; 
    }else{
		
		if($dtime[1] != '0000-00-00 00:00:00'){
	   echo  date('H:i:s',strtotime($dtime[1])); 
		}else{
			echo "--";
		}
    }
	  } }	}   }else{
		   echo "--";
	   }?></td>
                                  </td>
                                <td style="text-align:center;"><?php 
								if($dtime[1]!='0000-00-00 00:00:00'){
	  $time1 = date('H:i:s',strtotime($dtime[0]));
	  $time2 = date('H:i:s',strtotime($dtime[1]));
	    if($check_holiday=='true' && date('H:i:s',strtotime($dtime[0])) == '00:00:00'){
		  
		  echo "<b style='color:red;'>00.00</b>";
	  }elseif($day_name == 'Sun' && date('H:i:s',strtotime($dtime[0])) == '00:00:00'){
		   echo "<b style='color:red;'>00.00</b>";
		   
	   }else{
	      
$diff= $CI->Admin_model->get_time_difference($time1, $time2); 

             if($diff == '00:00:00'){
echo "00:00";
}else{
     if(($check_holiday=='true' || $day_name == 'Sun' )&& date('H:i:s',strtotime($dtime[0])) != '00:00:00'){
         echo  "<span style='color:red;' >".$diff."</span>"; 
    }else{
        if( $time2 == '00:00:00'){
             echo '00:00';
        }else
        {
             echo  $diff;
        }
	     
    }
	 
}
								}}else{
									echo "00:00";
								}
	  ?></td>
	  <td style="text-align:center;">
	  <?php echo $dtime[2]; 
	  if($dtime[2]=='present'){
		  $present[] ='1';
	  }elseif($dtime[2]=='holiday'){
		  $hol[]='1';
	  }elseif($dtime[2]=='sunday'){
		  $sun[]='1';
	  }
	  
	  ?>
	  </td>
	  <td style="text-align:center;">
	 <?php echo $dtime[3];
if($dtime[4] != ''){    
    $str = explode('/',$dtime[4]);
     
     if($str[1]=='0.5'){
       $present[] = '0.5';
     }
    $ltyp[] = $str[0];
    $ldur[$str[0]][] = $str[1];   
}
//echo "kk".$dtime[6];
if($dtime[5] == '1'){
$late_mark[] = $dtime[5];
}
if($dtime[6] == 'Y'){
$early_mark[] = $dtime[6];
}
    ?>
	  </td>
                              </tr>
                              <?php $i= $i+1; }
   
} else{?>
                              <?php } ?>
                             
                            </table>
							 <div class="text-center result-count" style="margin-top:20px;">Early Go Count : <span class="highlight"><?php echo count($early_mark); ?></span>&nbsp;&nbsp; | &nbsp;&nbsp;Late Come Count : <span class="highlight"><?php echo array_sum($late_mark); ?></span></div>
             <div class="clearfix"></div>
              <div class="text-center result-count"> Average Working Duration : <span class="highlight"><?php
              foreach($tdiff as $dff){
                $tdiff1[] = str_replace(":",".",$dff);
              }
              //print_r($tdiff1); echo count($tdiff1); 
              echo round(array_sum($tdiff1)/count($tdiff1),2); ?></span></div>
              
<table summary="" class="result-table" width="100%">
<tr>
<td>(WD)<?php echo array_sum($present);?> </td>
<td>+</td>
<td>(CL)<?php echo array_sum($ldur['CL']);?>  </td>
<td>+</td>
<td>(ML)<?php echo array_sum($ldur['ML']);?> </td>
<td>+</td>
<td>(EL)<?php echo array_sum($ldur['EL']);?></td>
<td>+</td>
<td>(COFF)<?php echo array_sum($ldur['C-OFF']);?> </td>
<td>+</td>
<td>(SL)<?php echo array_sum($ldur['SL']);?> </td>
<td>+</td>

<td>(VL)<?php echo array_sum($ldur['VL']);?></td>
<td>+</td>
<td>(LWP)<?php echo array_sum($ldur['LWP']);?> </td>
<td>+</td>
<td>(S)<?php echo array_sum($sun);?></td>
<td>+</td>
<td>(H)<?php echo array_sum($hol);?></td>
<td>+</td>
<td>(OD)<?php echo array_sum($ldur['OD']);?>  </td><td>+</td>
<td>(LV)<?php  echo array_sum($ldur['Leave']);?> </td><td>=</td>

<td>(Total Days For Salary) <?php           
              echo (array_sum($present)+array_sum($ldur['CL'])+array_sum($ldur['Leave'])+array_sum($ldur['ML'])+array_sum($ldur['EL'])+array_sum($ldur['C-OFF'])+array_sum($ldur['SL'])+array_sum($ldur['VL'])+array_sum($ldur['OD'])+array_sum($sun)+array_sum($hol)); ?></td>
</tr>
</table>              
              
              
              
             
              	
							
	</div>
</body>
</html>
