<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      <title>MalPractice Report</title>
      <style>  
         table {  
         font-family: arial, sans-serif;  
         border-collapse: collapse;  
         width: 100%; font-size:12px; margin:0 auto;
         }  
         td{vertical-align: top;}
         .signature{
         text-align: center;
         }
         .marks-table{
         width: 100%;height:650px;
         }
         p{padding:0px;margin:0px;}
         h1, h3{margin:0;padding:0}
         .marks-table td{height:30px;vertical-align:middle;}
         .marks-table th{height:30px;}
         .content-table td{border:1px solid #333;padding:5px;vertical-align:top;}
         .content-table1 td{padding:5px;vertical-align:top;}
         .content-table th{border-left:1px solid #333;border-right:1px solid #333;border-bottom:1px solid #333;}
      </style>
   </head>
   <body>
      <table align="center" width="700">
         <tbody>
            <tr>
               <td valign="top" height="40">
                  <table cellpadding="0" cellspacing="0" border="0" align="center" width="800" style="margin-top:50px;">
                     <tr>
                        <td width="80" align="center" style="text-align:center;padding-top:5px;"><img src="<?=base_url()?>assets/images/logo-7.jpg" alt="" width="70" border="0"></td>
                        <td style="font-weight:normal;text-align:center;">
                           <h1 style="font-size:30px;">Sandip University</h1>
                           <p>Mahiravani, Trimbak Road, Nashik - 422 213</p>
                        </td>
                        <td width="120" align="right" valign="middle" style="text-align:center;padding-top:20px;">
                           <span style="border:0px solid #333;padding:10px;"></span>
                        </td>
                     <tr>
                        <td></td>
                        <td align="center" style="text-align:center;margin:0;padding:0">
                           <h3 style="font-size:14px;">OFFFICE OF THE CONTROLLER OF THE EXAMINATIONS<br>
                              REPORT ON MALPRACTICE / UNFAIR MEANS<br>
                              END SEMESTER PRACTICAL / THEORY EXAMINATIONS - <?=$exam[0]['exam_month']?> <?=$exam[0]['exam_year']?>
                           </h3>
                        </td>
                        <td></td>
                     </tr>
                  </table>
               </td>
            </tr>
            <tr>
               <td style="padding:10px;">
                  <table class="content-table" width="800" cellpadding="0" cellspacing="0" border="0" align="center" style="font-size:12px;height:150px;overflow: hidden;">
                     <tr>
                        <td width="250" height="30"><strong>PRN :</strong></td>
                        <td><?=$emp_per[0]['enrollment_no']?></td>
                     </tr>
                     <tr>
                        <td height="30"><strong>Name of the Candidate :</strong></td>
                        <td><?=$emp_per[0]['last_name']?> <?=$emp_per[0]['first_name']?> <?=$emp_per[0]['middle_name']?></td>
                     <tr>
                     <tr>
                        <td height="30"><strong>Semester of the Course :</strong></td>
                        <td><?=$emp_per[0]['semester']?></td>
                     </tr>
                     <tr>
                        <td height="30"><strong>Stream Name :</strong></td>
                        <td><?=$emp_per[0]['stream_short_name']?></td>
                     </tr>
                     <tr>
                        <td height="30"><strong>Course code &amp; Title:</strong></td>
                        <td><?=$emp_per[0]['subject_code']?> - <?=$emp_per[0]['subject_name']?></td>
                     </tr>
                     <tr>
                        <td height="30"><strong>Date &amp; Session of Exam:</strong></td>						<?php $frmtime = explode(':' ,$emp_per[0]['from_time']); $to_time = explode(':', $emp_per[0]['to_time']);?>
                        <td><?=date('d-m-Y',strtotime($emp_per[0]['date']));?>, <?=$frmtime[0]?>:<?=$frmtime[1]?>-<?=$to_time[0]?>:<?=$to_time[1]?></td>
                     </tr>
                  </table>
               </td>
            </tr>
         </tbody>
      </table>
      <br>
      <table class="content-table1" width="700" cellpadding="0" cellspacing="0" border="0" align="center" style="font-size:12px;">
         <tr>
            <td width="250" height="300" valign="top" style="border-left:1px solid #000;border-right:1px solid #000;border-top:1px solid #000;"><strong>Statement of the Candidate* :</strong></td>
         </tr>
         <tr>
            <td align="right" height="30" style="border-left:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000;">Signature of the Candidate</td>
         </tr>
      </table>
      <br>
      <table class="content-table1" width="700" cellpadding="0" cellspacing="0" border="0" align="center" style="font-size:12px;padding:10px;">
         <tr>
            <td width="250" height="250" valign="top" colspan="2" style="border-left:1px solid #000;border-right:1px solid #000;border-top:1px solid #000;"><strong>Report of Hall Supdt./Internal Examiner of Theory/Practical Exam* :</strong></td>
         </tr>
         <tr>
            <td width="50%" style="border-left:1px solid #000;"></td>
            <td  height="30" style="border-right:1px solid #000;">Signature of Hall Supdt./Internal Examiner</td>
         </tr>
         <tr>
            <td width="50%" style="border-left:1px solid #000;border-bottom:1px solid #000;"></td>
            <td  height="30" style="border-right:1px solid #000;border-bottom:1px solid #000;">Name &amp; Dept.-</td>
         </tr>
      </table>
      <br>
      <table  width="700" cellpadding="0" cellspacing="0" border="0" align="center">
         <tr>
            <td height="50">&nbsp;</td>
         </tr>
      </table>
      <br>
      <table class="content-table1" width="700" cellpadding="0" cellspacing="0" border="0" align="center" style="font-size:12px;">
         <tr>
            <br>
            <td width="250" height="250" valign="top" colspan="2"  style="border-left:1px solid #000;border-right:1px solid #000;border-top:1px solid #000;margin-top:50px;"><strong>Report of Squad Member/ External Examiner of Theory/Practical Exam*:</strong></td>
         </tr>
         <tr>
            <td width="50%" style="border-left:1px solid #000;"></td>
            <td  height="30" style="border-right:1px solid #000;">Signature of Squad Member/External Examiner</td>
         </tr>
         <tr>
            <td width="50%" style="border-left:1px solid #000;border-bottom:1px solid #000;"></td>
            <td  height="30" style="border-right:1px solid #000;border-bottom:1px solid #000;">Name &amp; Dept.-</td>
         </tr>
      </table>
      <br>
      <table class="content-table1" width="700" cellpadding="0" cellspacing="0" border="0" align="center" style="font-size:12px;">
         <tr>
            <td width="250" height="250" colspan="2" valign="top" style="border-left:1px solid #000;border-right:1px solid #000;border-top:1px solid #000;"><strong>Report of the Chief Supdt* :</strong></td>
         </tr>
         <tr>
            <td width="50%" style="border-left:1px solid #000;border-bottom:1px solid #000;"></td>
            <td  height="30" style="border-right:1px solid #000;border-bottom:1px solid #000;">Signature of the Chief Supdt. (With Seal)</td>
         </tr>
      </table>
      <br>
      <table class="content-table1" width="700" cellpadding="0" cellspacing="0" border="0" align="center" style="font-size:12px;height:150px;overflow: hidden;">
         <tr>
            <td width="250" height="250" valign="top" colspan="2" style="border-left:1px solid #000;border-right:1px solid #000;border-top:1px solid #000;"><strong>Report of the Malpractice Committee (after Enquiry)* :</strong></td>
         </tr>
         <tr>
            <td width="50%" style="border-left:1px solid #000;">Committee Members Name and Signature (with date)</td>
            <td  height="30" style="border-right:1px solid #000;"></td>
         </tr>
         <tr>
            <td width="50%" style="border-left:1px solid #000;">1</td>
            <td  height="30" style="border-right:1px solid #000;">2</td>
         </tr>
         <tr>
            <td width="50%" style="border-left:1px solid #000;">3</td>
            <td  height="30" style="border-right:1px solid #000;">4</td>
         </tr>
         <tr>
            <td width="50%" style="border-left:1px solid #000;border-bottom:1px solid #000;">5</td>
            <td  height="30" style="border-right:1px solid #000;border-bottom:1px solid #000;">6</td>
         </tr>
      </table>
   </body>
</html>