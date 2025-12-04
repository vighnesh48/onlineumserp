<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>AttendSheet</title>
    <style>  
            table {  
                font-family: arial, sans-serif;  
                border-collapse: collapse;  
                width: 100%; font-size:12px; xmargin:0 auto;
            }  
      td{vertical-align: top;}
                      
            .signature{
            text-align: center;
            }
            .marks-table{
            width: 100%;xxheight:650px;
            }
            p{padding:0px;margin:0px;}
            h1, h3{margin:0;padding:0}
            .marks-table td{height:30px;vertical-align:middle;}
            .marks-table th{height:30px;}
.content-table tr td{border:1px solid #333;vertical-align:middle;}
.content-table th{border-left:1px solid #333;border-right:1px solid #333;border-bottom:1px solid #333;}
        </style>  

</head>




<body>



  <?php
//echo "<pre>";
//print_r($sublist);exit;
for($i=0;$i<count($sublist);$i++){
	$sublist[$i]['subject_code'];
	//echo $emp_list[$i]['emp_per'][0]['form_number'];
	$studlist = $sublist[$i]['studlist'];
	//print_r($studlist);
?>
  <table width="700" border="0" cellspacing="0" cellpadding="0" height="100%" style="font-size:13px;margin:50px 50px">
            <tbody>  
            <tr>
            <td valign="top"  height="40">
            <table cellpadding="0" cellspacing="0" border="0" align="center" width="800" style="margin-top:50px;">
            <tr>
<td width="80" align="center" style="text-align:center;padding-top:5px;"><img src="<?=base_url()?>assets/images/logo-7.jpg" alt="" width="70" border="0"></td>
<td style="font-weight:normal;text-align:center;">
<h1 style="font-size:30px;">Sandip University</h1>
<p>Mahiravani, Trimbak Road, Nashik – 422 213</p>

</td>
<td width="120" align="right" valign="middle" style="text-align:center;padding-top:20px;">
<span style="border:0px solid #333;padding:10px;"></span></td>

<tr>
<td></td>
<td align="center" style="text-align:center;margin:0;padding:0"><h3 style="font-size:18px;">Seating Arrangement <?=$exam_session[0]['exam_month']?> - <?=$exam_session[0]['exam_year']?></h3></td>
<td></td>
</tr>
            
 </table>
            </td>
            </tr>

            <tr>
            <td style="padding:0;">
            <table class="content-table" width="800" cellpadding="0" cellspacing="0" border="1" align="center" style="font-size:12px;height:150px;overflow: hidden;">
            <tr>
            <td width="100" height="30">&nbsp;<strong>Subject Code:</strong></td>
            <td height="30">&nbsp;<?=$sublist[$i]['subject_name']?> - <?=$sublist[$i]['subject_code']?></td>
            <td width="80" height="30">&nbsp;<strong>Date:</strong> </td>
           <td height="30">&nbsp;<?=date('d/m/Y', strtotime($sublist[$i]['date']));?></td>
            </td>
            
            </tr>
           
            <tr>
            <td height="30" valign="middle">&nbsp;<strong>School Name:</strong></td>
            <td height="30" valign="middle">&nbsp;<?=$sublist[$i]['school_short_name']?></td>
            <td height="30" valign="middle">&nbsp;<strong>Time:</strong></td>
            <td height="30" valign="middle">&nbsp;<?php 
				$frmtime = explode(':', $sublist[$i]['from_time']);
				$totime = explode(':', $sublist[$i]['to_time']);
				echo $frmtime[0].':'.$frmtime[1].'-'.$totime[0].':'.$totime[1];
			?></td>
            </tr>
            <tr>
            <td width="100" height="30" valign="middle">&nbsp;<strong>Stream:</strong></td>
            <td  valign="middle">&nbsp;<?=$sublist[$i]['stream_name'];?></td>
            <td width="80" height="30" valign="middle">&nbsp;<strong>Semester</strong> </td>
           <td height="30" valign="middle">&nbsp;<?=$sublist[$i]['semester'];?></td>
            </td>
            </tr>
             </table>
           
            </td>
            </tr>
            
            
           <tr>
            <td class="marks-table"  align="left" width="800" height="900" style="padding:0;margin-top:10px">
            <table border="0"  align="left">
            <tr>
            <td valign="top" align="left">
            <table  border="0" class="content-table">
            <tr>   
             <th width="200" style="border-top:1px solid #000;" align="left">Room No:</th>           
            </tr>
			<tr>
			<th width="200" style="border-top:1px solid #000" align="left">PRN</th>     
            
            </tr>
             <?php
			$count=0;
		
				if(!empty($studlist)){
					foreach($studlist as $stud){
						if($count ==20) {
                $count = 0;
                echo "</table></td><td valign='top'><table class='content-table'><tr><th width='200' style='border-top:1px solid #000' align='left'>Room No:</th></tr>
				<tr><th width='200' style='border-top:1px solid #000' align='left'>PRN</th></tr>
				";
			}
			//echo $stud['enrollment_no'];
			?>
            <tr>
            
            <td><?=$stud['enrollment_no']?></td>
           
            </tr>
			<?php 

			$count++;
				}
				}else{
					//echo "<tr><td colspan=4>No data found.</td></tr>";
				}
			?>


            </table>
            </td>
            
            
            
            
            

            </tr>
            
             
            </table>
            
            </td>
            </tr>

           
          
          

            </tbody>
            </table>
  
 
        
         
  
  <?php //exit;
}
//exit;?>
    </form> 








    <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>  
       <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script>  
    <script>  
        (function () {  
            var  
             form = $('.form'),  
             cache_width = form.width(),  
             a4 = [595.28, 841.89]; // for a4 size paper width and height  
      
            $('#create_pdf').on('click', function () {  
                $('body').scrollTop(0);  
                createPDF();  
            });  
            //create pdf  
            function createPDF() {  
                getCanvas().then(function (canvas) {  
                    var  
                     img = canvas.toDataURL("image/png"),  
                     doc = new jsPDF({  
                         unit: 'px',  
                         format: 'a4'  
                     });  
                    doc.addImage(img, 'JPEG', 20, 20);  
                    doc.save('Bhavdip-html-to-pdf.pdf');  
                    form.width(cache_width);  
                });  
            }  
      
            // create canvas object  
            function getCanvas() {  
                form.width((a4[0] * 1.33333) - 80).css('max-width', 'none');  
                return html2canvas(form, {  
                    imageTimeout: 2000,  
                    removeContainer: true  
                });  
            }  
      
        }());  
    </script>  
    <script>  
        /* 
     * jQuery helper plugin for examples and tests 
     */  
        (function ($) {  
            $.fn.html2canvas = function (options) {  
                var date = new Date(),  
                $message = null,  
                timeoutTimer = false,  
                timer = date.getTime();  
                html2canvas.logging = options && options.logging;  
                html2canvas.Preload(this[0], $.extend({  
                    complete: function (images) {  
                        var queue = html2canvas.Parse(this[0], images, options),  
                        $canvas = $(html2canvas.Renderer(queue, options)),  
                        finishTime = new Date();  
      
                        $canvas.css({ position: 'absolute', left: 0, top: 0 }).appendTo(document.body);  
                        $canvas.siblings().toggle();  
      
                        $(window).click(function () {  
                            if (!$canvas.is(':visible')) {  
                                $canvas.toggle().siblings().toggle();  
                                throwMessage("Canvas Render visible");  
                            } else {  
                                $canvas.siblings().toggle();  
                                $canvas.toggle();  
                                throwMessage("Canvas Render hidden");  
                            }  
                        });  
                        throwMessage('Screenshot created in ' + ((finishTime.getTime() - timer) / 1000) + " seconds<br />", 4000);  
                    }  
                }, options));  
      
                function throwMessage(msg, duration) {  
                    window.clearTimeout(timeoutTimer);  
                    timeoutTimer = window.setTimeout(function () {  
                        $message.fadeOut(function () {  
                            $message.remove();  
                        });  
                    }, duration || 2000);  
                    if ($message)  
                        $message.remove();  
                    $message = $('<div ></div>').html(msg).css({  
                        margin: 0,  
                        padding: 0,  
                        background: "#000",  
                        opacity: 0.7,  
                        position: "fixed",  
                        top: 10,  
                        right: 10,  
                        fontFamily: 'open sans',  
                        color: '#fff',  
                        fontSize: 12,  
                        borderRadius: 12,  
                        width: 'auto',  
                        height: 'auto',  
                        textAlign: 'center',  
                        textDecoration: 'none'  
                    }).hide().fadeIn().appendTo('body');  
                }  
            };  
        })(jQuery);  
      
    </script>  

</body>
</html>
