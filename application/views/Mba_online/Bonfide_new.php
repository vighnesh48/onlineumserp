<html>
<head>
<title>Sandip University</title>
<style type="text/css">
<!--
body { font-family: Arial; font-size: 23.3px }
.pos { position: absolute; z-index: 0; left: 0px; top: 0px }
-->
</style>
</head>
<body>
 <?php
       // var_dump($bonafieddata);
        $name= $all_data[0]['student_name'];
        if($all_data[0]['gender']=='M')
        {
            $title ='Mr.';
            $tem='He';
        }
        else
        {
           $title ='Ms.'; 
            $tem='She';
        }
        
        if($all_data[0]['admission_year']==1)
        {
            $crsem ='1st Year';
        }
          if($all_data[0]['admission_year']==2)
        {
            $crsem ='2nd Year';
        }
        if($all_data[0]['admission_year']==3)
        {
            $crsem ='3rd Year';
        }
        if($all_data[0]['admission_year']==4)
        {
            $crsem ='4th Year';
        }
        if($all_data['admission_year']==5)
        {
            $crsem ='V';
        }
        if($all_data['admission_year']==6)
        {
            $crsem ='VI';
        }
        if($all_data['admission_year']==7)
        {
            $crsem ='VII';
        }
        if($all_data['admission_year']==8)
        {
            $crsem ='VII';
        }
        
        ?>
<div style='margin-top:0;margin-right:-.25in;margin-bottom:.0001pt;margin-left:0in;line-height:115%;font-size:15px;font-family:"Calibri","sans-serif";'><strong><span style="font-size:16px;">Reference Number: - <?php echo $all_data[0]['full_ref_no'];?> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Date :-<?php echo $all_data[0]['date_in'];?></span></strong></div>

<p style='margin-top:0in;margin-right:-.25in;margin-bottom:.0001pt;margin-left:0in;line-height:115%;font-size:15px;font-family:"Calibri","sans-serif";'><strong><span style="font-size:16px;">&nbsp;</span></strong></p>
<p style='margin-top:0in;margin-right:-.25in;margin-bottom:.0001pt;margin-left:0in;line-height:115%;font-size:15px;font-family:"Calibri","sans-serif";'><strong><span style="font-size:16px;">&nbsp;</span></strong></p>
<p style='margin-top:0in;margin-right:0in;margin-bottom:.0001pt;margin-left:25in;line-height:115%;font-size:15px;font-family:"Calibri","sans-serif";text-align:center;'><strong><u><span style="font-size:19px;line-height:115%;">TO WHOMSOEVER IT MAY CONCERN&nbsp;</span></u></strong></p>
<p style='margin-top:0in;margin-right:0in;margin-bottom:.0001pt;margin-left:0in;line-height:115%;font-size:15px;font-family:"Calibri","sans-serif";text-align:center;'><strong><u><span style="font-size:19px;line-height:115%;">Fee Structure for Session 2021-23&nbsp;</span></u></strong></p>
<p style='margin-top:0in;margin-right:0in;margin-bottom:.0001pt;margin-left:0in;line-height:150%;font-size:15px;font-family:"Calibri","sans-serif";text-align:justify;'><span style='font-size:11px;line-height:150%;font-family:"Cambria","serif";'>&nbsp;</span></p>
<p style='margin-top:0in;margin-right:-9.0pt;margin-bottom:.0001pt;margin-left:0in;line-height:115%;font-size:15px;font-family:"Calibri","sans-serif";text-align:justify;'><strong><span style='line-height:115%;font-family:"Cambria","serif";'>&nbsp;</span></strong></p>
<p style='margin-top:0in;margin-right:-9.0pt;margin-bottom:.0001pt;margin-left:0in;line-height:115%;font-size:15px;font-family:"Calibri","sans-serif";text-align:justify;'><span style='line-height:115%;font-family:"Cambria","serif";'>This is to certify that<strong>&nbsp;<?php echo $name;?></strong> D/O <?php echo $all_data[0]['father_name'];?> resident of <?php echo $all_data[0]['village'];?>  <?php echo $all_data[0]['District'];?> has been admitted in <strong><?php echo $crsem;?></strong> in Course:-<strong><?php echo $all_data[0]['stream_name'];?></strong> <strong>for&nbsp;</strong> the Academic Year 2021 &ndash; 22 at Sandip University, Sijoul, Madhubani. <strong>The Course duration is <?php echo $all_data[0]['course_duration'];?> Years.</strong></span></p>
<p style='margin-top:0in;margin-right:-9.0pt;margin-bottom:.0001pt;margin-left:0in;line-height:115%;font-size:15px;font-family:"Calibri","sans-serif";'><span style='font-size:16px;line-height:115%;font-family:"Cambria","serif";'>The approximate expenses for pursuing the above entire course are as under:</span></p>
<p style='margin-top:0in;margin-right:-9.0pt;margin-bottom:.0001pt;margin-left:0in;line-height:115%;font-size:15px;font-family:"Calibri","sans-serif";'><strong><span style='font-size:16px;line-height:115%;font-family:"Cambria","serif";'>Academic Fees</span></strong></p>
<table style="border: none;width:466.05pt;border-collapse:collapse;">
    <tbody>
        <tr>
            <td style="border:solid black 1.0pt;padding:0in 5.4pt 0in 5.4pt;height:18.7pt;">
                <p style='margin-top:0in;margin-right:0in;margin-bottom:10.0pt;margin-left:0in;line-height:115%;font-size:15px;font-family:"Calibri","sans-serif";'><strong><span style="color:black;">Sr.No.</span></strong></p>
            </td>
            <td style="width:171.35pt;border:solid black 1.0pt;border-left:  none;padding:0in 5.4pt 0in 5.4pt;height:18.7pt;">
                <p style='margin-top:0in;margin-right:0in;margin-bottom:10.0pt;margin-left:0in;line-height:115%;font-size:15px;font-family:"Calibri","sans-serif";'><strong><span style="color:black;">Particulars</span></strong></p>
            </td>
            <td style="width:75.1pt;border:solid black 1.0pt;border-left:none;padding:0in 5.4pt 0in 5.4pt;height:18.7pt;">
                <p style='margin-top:0in;margin-right:0in;margin-bottom:10.0pt;margin-left:0in;line-height:115%;font-size:15px;font-family:"Calibri","sans-serif";text-align:center;'><strong><span style="color:black;">1<sup>st</sup>&nbsp; Year</span></strong></p>
            </td>
            <td style="width:86.2pt;border:solid black 1.0pt;border-left:none;padding:0in 5.4pt 0in 5.4pt;height:18.7pt;">
                <p style='margin-top:0in;margin-right:0in;margin-bottom:10.0pt;margin-left:0in;line-height:115%;font-size:15px;font-family:"Calibri","sans-serif";text-align:center;'><strong><span style="color:black;">2<sup>nd</sup> Year</span></strong></p>
            </td>
            <td style="width:83.85pt;border:solid black 1.0pt;border-left:none;padding:0in 5.4pt 0in 5.4pt;height:18.7pt;">
                <p style='margin-top:0in;margin-right:0in;margin-bottom:10.0pt;margin-left:0in;line-height:115%;font-size:15px;font-family:"Calibri","sans-serif";text-align:center;'><strong><span style="color:black;">Total</span></strong></p>
            </td>
        </tr>
        <tr>
            <td style="border:solid black 1.0pt;border-top:none;padding:0in 5.4pt 0in 5.4pt;height:17.9pt;">
                <p style='margin-top:0in;margin-right:0in;margin-bottom:10.0pt;margin-left:0in;line-height:115%;font-size:15px;font-family:"Calibri","sans-serif";'><span style="color:black;">1)</span></p>
            </td>
            <td style="width:171.35pt;border-top:none;border-left:none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:0in 5.4pt 0in 5.4pt;height:17.9pt;">
                <p style='margin-top:0in;margin-right:0in;margin-bottom:10.0pt;margin-left:0in;line-height:115%;font-size:15px;font-family:"Calibri","sans-serif";'><span style="color:black;">Tuition Fee&nbsp;</span></p>
            </td>
            <td style="width:75.1pt;border-top:none;border-left:none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:0in 5.4pt 0in 5.4pt;height:17.9pt;">
                <p style='margin-top:0in;margin-right:0in;margin-bottom:10.0pt;margin-left:0in;line-height:115%;font-size:15px;font-family:"Calibri","sans-serif";text-align:center;'><span style="color:black;">74,750</span></p>
            </td>
            <td style="width:86.2pt;border-top:none;border-left:none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:0in 5.4pt 0in 5.4pt;height:17.9pt;">
                <p style='margin-top:0in;margin-right:0in;margin-bottom:10.0pt;margin-left:0in;line-height:115%;font-size:15px;font-family:"Calibri","sans-serif";text-align:center;'><span style="color:black;">74,750</span></p>
            </td>
            <td style="width:83.85pt;border-top:none;border-left:none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:0in 5.4pt 0in 5.4pt;height:17.9pt;">
                <p style='margin-top:0in;margin-right:0in;margin-bottom:10.0pt;margin-left:0in;line-height:115%;font-size:15px;font-family:"Calibri","sans-serif";text-align:right;'><span style="color:black;">149,500</span></p>
            </td>
        </tr>
        <tr>
            <td style="border:solid black 1.0pt;border-top:none;padding:0in 5.4pt 0in 5.4pt;height:18.7pt;">
                <p style='margin-top:0in;margin-right:0in;margin-bottom:10.0pt;margin-left:0in;line-height:115%;font-size:15px;font-family:"Calibri","sans-serif";'><span style="color:black;">2)</span></p>
            </td>
            <td style="width:171.35pt;border-top:none;border-left:none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:0in 5.4pt 0in 5.4pt;height:18.7pt;">
                <p style='margin-top:0in;margin-right:0in;margin-bottom:10.0pt;margin-left:0in;line-height:115%;font-size:15px;font-family:"Calibri","sans-serif";'><span style="color:black;">Other Fee</span></p>
            </td>
            <td style="width:75.1pt;border-top:none;border-left:none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:0in 5.4pt 0in 5.4pt;height:18.7pt;">
                <p style='margin-top:0in;margin-right:0in;margin-bottom:10.0pt;margin-left:0in;line-height:115%;font-size:15px;font-family:"Calibri","sans-serif";text-align:center;'><span style="color:black;">23,000</span></p>
            </td>
            <td style="width:86.2pt;border-top:none;border-left:none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:0in 5.4pt 0in 5.4pt;height:18.7pt;">
                <p style='margin-top:0in;margin-right:0in;margin-bottom:10.0pt;margin-left:0in;line-height:115%;font-size:15px;font-family:"Calibri","sans-serif";text-align:center;'><span style="color:black;">23,000</span></p>
            </td>
            <td style="width:83.85pt;border-top:none;border-left:none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:0in 5.4pt 0in 5.4pt;height:18.7pt;">
                <p style='margin-top:0in;margin-right:0in;margin-bottom:10.0pt;margin-left:0in;line-height:115%;font-size:15px;font-family:"Calibri","sans-serif";text-align:right;'><span style="color:black;">46,000</span></p>
            </td>
        </tr>
        <tr>
            <td rowspan="2" style="border:solid black 1.0pt;border-top:none;padding:0in 5.4pt 0in 5.4pt;height:18.7pt;">
                <p style='margin-top:0in;margin-right:0in;margin-bottom:10.0pt;margin-left:0in;line-height:115%;font-size:15px;font-family:"Calibri","sans-serif";'><span style="color:black;">3)</span></p>
            </td>
            <td rowspan="2" style="width:171.35pt;border-top:none;border-left:  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:0in 5.4pt 0in 5.4pt;height:18.7pt;">
                <p style='margin-top:0in;margin-right:0in;margin-bottom:10.0pt;margin-left:0in;line-height:115%;font-size:15px;font-family:"Calibri","sans-serif";'><span style="color:black;">Hostel Fooding&nbsp;</span></p>
                <p style='margin-top:0in;margin-right:0in;margin-bottom:10.0pt;margin-left:0in;line-height:115%;font-size:15px;font-family:"Calibri","sans-serif";'><span style="color:black;">Hostel &nbsp;Lodging (Type 01)</span></p>
            </td>
            <td style="width:75.1pt;border-top:none;border-left:none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:0in 5.4pt 0in 5.4pt;height:18.7pt;">
                <p style='margin-top:0in;margin-right:0in;margin-bottom:10.0pt;margin-left:0in;line-height:115%;font-size:15px;font-family:"Calibri","sans-serif";text-align:center;'><span style="color:black;">36,000</span></p>
            </td>
            <td style="width:86.2pt;border-top:none;border-left:none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:0in 5.4pt 0in 5.4pt;height:18.7pt;">
                <p style='margin-top:0in;margin-right:0in;margin-bottom:10.0pt;margin-left:0in;line-height:115%;font-size:15px;font-family:"Calibri","sans-serif";text-align:center;'><span style="color:black;">36,000</span></p>
            </td>
            <td style="width:83.85pt;border-top:none;border-left:none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:0in 5.4pt 0in 5.4pt;height:18.7pt;">
                <p style='margin-top:0in;margin-right:0in;margin-bottom:10.0pt;margin-left:0in;line-height:115%;font-size:15px;font-family:"Calibri","sans-serif";text-align:right;'><span style="color:black;">72,000</span></p>
            </td>
        </tr>
        <tr>
            <td style="width:75.1pt;border-top:none;border-left:none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:0in 5.4pt 0in 5.4pt;height:18.7pt;">
                <p style='margin-top:0in;margin-right:0in;margin-bottom:.0001pt;margin-left:0in;line-height:normal;font-size:15px;font-family:"Calibri","sans-serif";text-align:center;'><span style="color:black;">34,000</span></p>
            </td>
            <td style="width:86.2pt;border-top:none;border-left:none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:0in 5.4pt 0in 5.4pt;height:18.7pt;">
                <p style='margin-top:0in;margin-right:0in;margin-bottom:.0001pt;margin-left:0in;line-height:normal;font-size:15px;font-family:"Calibri","sans-serif";text-align:center;'><span style="color:black;">34,000</span></p>
            </td>
            <td style="width:83.85pt;border-top:none;border-left:none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:0in 5.4pt 0in 5.4pt;height:18.7pt;">
                <p style='margin-top:0in;margin-right:0in;margin-bottom:.0001pt;margin-left:0in;line-height:normal;font-size:15px;font-family:"Calibri","sans-serif";text-align:right;'><span style="color:black;">68,000</span></p>
            </td>
        </tr>
        <tr>
            <td style="border:solid black 1.0pt;border-top:none;padding:0in 5.4pt 0in 5.4pt;height:18.7pt;">
                <p style='margin-top:0in;margin-right:0in;margin-bottom:10.0pt;margin-left:0in;line-height:115%;font-size:15px;font-family:"Calibri","sans-serif";'><span style="color:black;">4)</span></p>
            </td>
            <td style="width:171.35pt;border-top:none;border-left:none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:0in 5.4pt 0in 5.4pt;height:18.7pt;">
                <p style='margin-top:0in;margin-right:0in;margin-bottom:10.0pt;margin-left:0in;line-height:115%;font-size:15px;font-family:"Calibri","sans-serif";'><span style="color:black;">Hostel Caution Money</span></p>
            </td>
            <td style="width:75.1pt;border-top:none;border-left:none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:0in 5.4pt 0in 5.4pt;height:18.7pt;">
                <p style='margin-top:0in;margin-right:0in;margin-bottom:10.0pt;margin-left:0in;line-height:115%;font-size:15px;font-family:"Calibri","sans-serif";text-align:center;'><span style="color:black;">5000</span></p>
            </td>
            <td style="width:86.2pt;border-top:none;border-left:none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:0in 5.4pt 0in 5.4pt;height:18.7pt;">
                <p style='margin-top:0in;margin-right:0in;margin-bottom:10.0pt;margin-left:0in;line-height:115%;font-size:15px;font-family:"Calibri","sans-serif";text-align:center;'><span style="color:black;">&nbsp;-</span></p>
            </td>
            <td style="width:83.85pt;border-top:none;border-left:none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:0in 5.4pt 0in 5.4pt;height:18.7pt;">
                <p style='margin-top:0in;margin-right:0in;margin-bottom:10.0pt;margin-left:0in;line-height:115%;font-size:15px;font-family:"Calibri","sans-serif";text-align:right;'><span style="color:black;">5,000</span></p>
            </td>
        </tr>
        <tr>
            <td style="border:solid black 1.0pt;border-top:none;padding:0in 5.4pt 0in 5.4pt;height:19.55pt;">
                <p style='margin-top:0in;margin-right:0in;margin-bottom:10.0pt;margin-left:0in;line-height:115%;font-size:15px;font-family:"Calibri","sans-serif";'><span style="color:black;">&nbsp;</span></p>
            </td>
            <td style="width:171.35pt;border-top:none;border-left:none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:0in 5.4pt 0in 5.4pt;height:19.55pt;">
                <p style='margin-top:0in;margin-right:0in;margin-bottom:10.0pt;margin-left:0in;line-height:115%;font-size:15px;font-family:"Calibri","sans-serif";'><strong><span style="color:black;">Total Rs.</span></strong></p>
            </td>
            <td style="width:75.1pt;border-top:none;border-left:none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:0in 5.4pt 0in 5.4pt;height:19.55pt;">
                <p style='margin-top:0in;margin-right:0in;margin-bottom:10.0pt;margin-left:0in;line-height:115%;font-size:15px;font-family:"Calibri","sans-serif";text-align:center;'><strong><span style="color:black;">172,750</span></strong></p>
            </td>
            <td style="width:86.2pt;border-top:none;border-left:none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:0in 5.4pt 0in 5.4pt;height:19.55pt;">
                <p style='margin-top:0in;margin-right:0in;margin-bottom:10.0pt;margin-left:0in;line-height:115%;font-size:15px;font-family:"Calibri","sans-serif";text-align:center;'><strong><span style="color:black;">167,750</span></strong></p>
            </td>
            <td style="width:83.85pt;border-top:none;border-left:none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:0in 5.4pt 0in 5.4pt;height:19.55pt;">
                <p style='margin-top:0in;margin-right:0in;margin-bottom:10.0pt;margin-left:0in;line-height:115%;font-size:15px;font-family:"Calibri","sans-serif";text-align:right;'><strong><span style="color:black;">340,500</span></strong></p>
            </td>
        </tr>
    </tbody>
</table>
<p style='margin-top:0in;margin-right:-9.0pt;margin-bottom:.0001pt;margin-left:0in;line-height:115%;font-size:15px;font-family:"Calibri","sans-serif";'><strong><span style="font-size:16px;line-height:115%;">&nbsp;</span></strong><strong><span style="font-size:16px;line-height:115%;">In addition to the academic fees mentioned above, the following will be applicable:</span></strong></p>
<ol style="list-style-type: decimal;margin-left:0in;">
    <li><strong><span style='font-family:"Times New Roman";font-size:16px;'>Hostel fee</span></strong><span style='font-family:"Times New Roman";font-size:16px;'>&nbsp;will be subject to yearly revision.</span></li>
    <li><span style="font-size:12.0pt;">Rs. ___-____ for Computer/Laptop if needed.&nbsp;</span></li>
    <li><span style="font-size:12.0pt;">The Fee once paid will not be Refunded.</span></li>
</ol>
<p style='margin-top:0in;margin-right:-13.5pt;margin-bottom:.0001pt;margin-left:0in;line-height:115%;font-size:15px;font-family:"Calibri","sans-serif";'><strong><span style="font-size:16px;">All fee and charges indicated above are tentative and subject to revision by the Management.</span></strong></p>
<p style='margin-top:0in;margin-right:-13.5pt;margin-bottom:.0001pt;margin-left:0in;line-height:115%;font-size:15px;font-family:"Calibri","sans-serif";'><strong><span style="font-size:16px;">Note:</span></strong></p>
<div style='margin-top:0in;margin-right:0in;margin-bottom:10.0pt;margin-left:0in;line-height:115%;font-size:15px;font-family:"Calibri","sans-serif";'>
    <ol style="margin-bottom:0in;list-style-type: decimal;margin-left:-8.35px;">
        <li style='margin-top:0in;margin-right:0in;margin-bottom:10.0pt;margin-left:0in;line-height:115%;font-size:15px;font-family:"Calibri","sans-serif";'><span style="font-size:12.0pt;">Kindly issue DD/Pay Order in favour of <strong>&ldquo;SANDIP UNIVERSITY&rdquo;</strong> <strong>A/C. No. : 50100212258694</strong></span></li>
    </ol>
</div>
<p style='margin-top:0in;margin-right:-13.5pt;margin-bottom:.0001pt;margin-left:1.65pt;line-height:115%;font-size:15px;font-family:"Calibri","sans-serif";'><strong><span style="font-size:16px;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; HDFC Bank, IFSC Code: HDFC0000118&nbsp;</span></strong><span style="font-size:16px;">payable at Mumbai for academic fees.</span></p>
<p style='margin-top:0in;margin-right:-13.5pt;margin-bottom:.0001pt;margin-left:0in;line-height:115%;font-size:15px;font-family:"Calibri","sans-serif";'><span style="font-size:16px;">2.&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Kindly issue DD/Pay Order in favour of <strong>&ldquo;SANDIP FOUNDATION&rdquo;</strong>&nbsp; <strong>A/C No.: 912010059716140,&nbsp;</strong></span></p>
<p style='margin-top:0in;margin-right:-13.5pt;margin-bottom:.0001pt;margin-left:0in;line-height:115%;font-size:15px;font-family:"Calibri","sans-serif";'><strong><span style="font-size:16px;">&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Axis Bank, IFSC Code: UTIB0001486 Payable at Madhubani,&nbsp;</span></strong><span style="font-size:16px;">for Hostel fee.</span></p>
<p style='margin-top:0in;margin-right:-13.5pt;margin-bottom:.0001pt;margin-left:0in;line-height:115%;font-size:15px;font-family:"Calibri","sans-serif";'><span style="font-size:16px;">3.&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Kindly issue DD/Pay Order in favour of <strong>&ldquo;____________________&rdquo;</strong> payable at ________ for &nbsp; &nbsp; &nbsp; &nbsp;transport charges.</span></p>
<p style='margin-top:0in;margin-right:-13.5pt;margin-bottom:.0001pt;margin-left:4.5pt;line-height:115%;font-size:15px;font-family:"Calibri","sans-serif";'><span style="font-size:11px;">&nbsp;</span></p>
<p style='margin-top:0in;margin-right:-13.5pt;margin-bottom:.0001pt;margin-left:4.5pt;line-height:115%;font-size:15px;font-family:"Calibri","sans-serif";'><span style="font-size:16px;">This certificate is issued to him / her for the Loan purpose on his / her own request.</span></p>
<p style='margin-top:0in;margin-right:-13.5pt;margin-bottom:.0001pt;margin-left:4.5pt;line-height:115%;font-size:15px;font-family:"Calibri","sans-serif";'><span style="font-size:16px;">&nbsp;</span></p>
<p style='margin-top:0in;margin-right:-13.5pt;margin-bottom:.0001pt;margin-left:0in;line-height:115%;font-size:15px;font-family:"Calibri","sans-serif";'><span style="font-size:16px;">&nbsp;</span></p>
<p style='margin-top:0in;margin-right:-13.5pt;margin-bottom:.0001pt;margin-left:4.5pt;line-height:115%;font-size:15px;font-family:"Calibri","sans-serif";'><strong><span style="font-size:16px;">Authorized Signatory</span></strong></p>
<p style='margin-top:0in;margin-right:-13.5pt;margin-bottom:.0001pt;margin-left:4.5pt;line-height:115%;font-size:15px;font-family:"Calibri","sans-serif";'><strong><span style="font-size:16px;">Sandip University</span></strong></p>
<p style='margin-top:0in;margin-right:-9.0pt;margin-bottom:.0001pt;margin-left:0in;line-height:115%;font-size:15px;font-family:"Calibri","sans-serif";'>&nbsp;</p>
<p style='margin-top:0in;margin-right:-13.5pt;margin-bottom:.0001pt;margin-left:4.5pt;line-height:115%;font-size:15px;font-family:"Calibri","sans-serif";'>&nbsp;</p></body>
</html>