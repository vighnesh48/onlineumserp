<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<script src="<?=site_url()?>assets/javascripts/jspdf/jspdf.js" type="text/javascript"></script>
<style>
.attexl table {
  border: 1px solid black;
}
.attexl table th {
  border: 1px solid black;
  padding: 5px;
  background-color: grey;
  color: white;
}
.attexl table td {
  border: 1px solid black;
  padding: 5px;
}
.result-table td{
border: 0px solid black !important;
text-align: center;
font-size: 13px;
font-weight: 600;
	}
.result-table{
 border: 1px solid black !important;
 background: #ddd;margin: 15px 0;	
}
.result-count{
background-color: #ddd;
width: 42%;
margin: 5px auto;
padding: 5px 0;
color: #000;
font-size: 15px; border: 1px solid #b0b0b0 !important;	
	}
	.highlight{color:red;font-weight: bold;}
</style>
<script>
 /* $(document).ready(function()
    { 
        $('#form').bootstrapValidator
        ({  
            message: 'This value is not valid',
            group: 'form-group',
            feedbackIcons: 
            {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
       row: {
        valid: 'field-success',
        invalid: 'field-error'
    },
            fields: 
            {
                attend_date:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Select month'
                      }
                    }
                }
            }       
        })
    
}); */
  
</script>
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
      $d = date_parse_from_format("Y-m-d",$attend_date);
        $msearch=$d["month"];//month number
        $ysearch1=date("Y",strtotime($attend_date));
    $monthName1 = date('F', mktime(0, 0, 0, $msearch, 10));// month name
?>
<div id="content-wrapper">
  <ul class="breadcrumb breadcrumb-page">
    <div class="breadcrumb-label text-light-gray">You are here: </div>
    <li><a href="#">Masters</a></li>
    <li class="active"><a href="#">Attendance </a></li>
  </ul>
  <div class="page-header">
    <div class="row">
      <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;In-Out Time Details</h1>
      <div class="col-xs-12 col-sm-8">
        <div class="row">
          <hr class="visible-xs no-grid-gutter-h">
        </div>
      </div>
    </div>
    <div class="row ">
      <div class="col-sm-12">&nbsp;</div>
    </div>
    <div class="row ">
      <div class="col-sm-12">
      
      <div class="panel panel-warning panel-dark">
          <div class="panel-heading">
            <span class="panel-title">Attendance</span>
          </div>
          <div class="panel-body">
            <form id="form" name="form" action="<?=base_url($currentModule.'Monthly_attendance/view_monthly_attendance')?>" method="POST" enctype="multipart/form-data">
                            <div class="form-body">
                                <div class="col-md-3"></div>
                              <div class="form-group">
                                <label class="col-md-2"><strong>Select Month</strong></label>
                                <div class="col-md-2" >
                                  <input id="dob-datepicker" required class="form-control form-control-inline date-picker" name="attend_date" value="" placeholder="Enter Month" type="text">
                                </div>
                                <div class=" col-md-2">
                                  <button type="submit" class="btn btn-primary form-control" >Submit</button>
                                </div>
                                <div class="col-md-3"></div>
                              </div>
                              
                            </div>
                          </form>
          </div>
        </div>
                
                
                <div class="panel panel-warning panel-dark">
          <div class="panel-heading">
            <span class="panel-title"><b><center>In-Out Time Report   &nbsp;&nbsp;&nbsp;<?php echo $monthName1.'-'. $ysearch1;?></center></b></span>
          </div>
          <div class="panel-body">
                    <div class="pagination" style="float:right;">
                          <?php  echo $paginglinks['navigation']; ?>
                        </div>
                        <div class="pagination" style="float:left;"> <?php echo (!empty($pagermessage) ? $pagermessage : ''); ?></div>
            <form action="exporttoexcel" method="post" 
onsubmit='$("#datatodisplay").val( $("<div>").append( $("#ReportTable").eq(0).clone() ).html() )'>
                          <div class="attexl" id="ReportTable" style="">
                            <table class="table table-bordered" style="width:90%;" >
                              <tr>
                                <th>DATE</th>
                                <th>DAY</th>
                                <th>IN-TIME</th>
                                <th>OUT-TIME</th>
                                <th>DURATION</th>
                <th>STATUS</th>
                <th>LEAVE TYPE</th>
                              </tr>
                              <?php //print_r($attendance);
//exit;
$CI =& get_instance();
$CI->load->model('Admin_model');
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
                                <td><?php 
echo date('d-m-Y',strtotime($attend_date."-".$day_num)); ?></td>
                                <td><?php 
         if($day_name == 'Sun'){
       echo "<b style='color:red;'>".$day_name."</b>"; 
     }else{
     echo $day_name; }?></td>
                                <td><?php 
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
     }  }  }else{
      echo "00:00";
     } 
      ?></td>
                                <td><?php 
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
    } } }   }else{
       echo "--";
     }?></td>
                                  </td>
                                <td><?php 
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
         $tdiff[] = $diff;
    }else{
        if( $time2 == '00:00:00'){
             echo '00:00';
        }else
        {
             echo  $diff; 
        if($dtime[2]=='present'){
         // echo "p";
          $tdiff[] = $diff;
        }elseif($dtime[2]=='leave' && $time2 != '00:00:00'){
$tdiff[] = $diff;
        }
        }
       
    }
   
}
                }}else{
                  echo "00:00";
                }
    ?></td>
    <td>
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
    <td>
    <?php echo $dtime[3];
    //echo $dtime[4];
if($dtime[4] != ''){    
    $str = explode('/',$dtime[4]);
     
     if(trim($str[1])=='0.5' && substr($str[0], -1) !== '*'){
       $present[] = 0.5;
     }
    $ltyp[] = $str[0];
    if($str[2] == 'hrs'){
      $ldur[$str[0]][] = 0.5;
       $present[] = 0.5;
    }else{
 if(substr($str[0], -1) === '*'){
$ldur['LWP'][] = 0.5;
 $ldur[substr($str[0],0,-1)][] = $str[1];  
 }else{

    $ldur[$str[0]][] = $str[1];  
    } 
  }
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
                              <div>
                                <label style="color:red"><b>No Attendance available.....</b></label>
                              </div>
                              <?php } ?>
                            </table>
              
              <div class="text-center result-count"> Early Go Count : <span class="highlight"><?php echo count($early_mark); ?></span>&nbsp;&nbsp; | &nbsp;&nbsp;Late Come Count : <span class="highlight"><?php echo array_sum($late_mark); ?></span></div>
             <div class="clearfix"></div>
              <div class="text-center result-count"> Average Working Duration : <span class="highlight"><?php
             // print_r($tdiff);
              foreach($tdiff as $dff){
                $ex = explode(":",$dff);
                if($ex[1]>0){
                  $mhr = $ex[1]/60 ;
                }else{
                  $mhr = '0.0';
                }
                $tdiff1[] = $ex[0]+$mhr;
               // $tdiff1[] = str_replace(":",".",$dff);
              }
            
              //print_r($tdiff1); echo count($tdiff1);
              $rd =  round(array_sum($tdiff1)/count($tdiff1),2); 
            $tex = explode(".",$rd);
              if($tex[1]>0){
 $tmhr = $tex[1]/60 ;
}else{
                  $tmhr = '0.0';
                }
                echo round($tex[0]+$tmhr,2);
              ?></span></div>
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

              
              
                          
                        </form>
            <form action="<?=base_url($currentModule.'Monthly_attendance/export_pdf')?>" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="attend_date1" value="<?php echo $attend_date; ?>" />
            <div class="col-xs-offset-5 col-md-2 text-center">
                                  <button type="submit" class="btn btn-primary form-control" >Download PDF </button>
                                </div>
             </form>
             </div>
          </div>
        </div>
                
                
      
        
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
  $('#dob-datepicker').datepicker( {format: "yyyy-m",startView: "months",minViewMode: "months",autoclose:true});
  var content = '<tr>'+$('#eduDetTable tbody tr').html()+'</tr>';
  $("#eduDetTable").on("click","input[name='addMore']", function(e){  
  //$("input[name='addMore']").on('click',function(){   
    //var content = $(this).parent().parent('tr').clone('true');
    $(this).parent().parent('tr').after(content);   
  });
  $("#eduDetTable").on("click","input[name='remove']", function(e){ 
  //$("input[name='remove']").on('click',function(){
    var rowCount = $('#eduDetTable tbody tr').length;
    if(rowCount>1){
      $(this).parent().parent('tr').remove();
    }
  }); 
  
   $("#btnExport").click(function(e) {
        window.open('data:application/vnd.ms-excel,' + $('#dvData').html());
    e.preventDefault();
});   
});
</script> 
<style type="text/css">
.table{width:100%;border:1px solid #f4f4f4}
table{max-width:100%;}
</style>