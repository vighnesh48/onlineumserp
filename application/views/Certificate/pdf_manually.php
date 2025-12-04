<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Certificate</title>
<style>
body{font-family:"Times New Roman", Times, serif}
.wrapper{ width:100%;}
.logo{width:15%;float:left;}
.midd{float:left;width:65%;text-align:center;}
.prfpic{width:100px;float:left;text-align:center;border:1px solid #333;}
.contain h2,.midd h2{text-align:center;font-weight:normal;font-size:18px;margin:0;font-style:italic;}
.contain{height:555px;}
.prn{font-size:15px;margin-bottom:20px;}
.idate{font-size:15px;width:100%;}
#maintable_one,#table2excel{ font-size:12px;}
#maintable{ font-size:16px;}
</style>
</head>



<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="maintable">
  <tr>
    <td align="center">
    <img src="http://sandipuniversity.com/erp/assets/images/logo_form.png" width="300" />
    <p style="margin-top:0"><strong>SANDIP UNIVERSITY,NASHIK</strong></p>
    <p style="margin-top:0"><strong>OFFICE OF THE CONTROLLER OF EXAMINATIONS</strong></p>
    <p style="margin-top:5; font-size:15px !important;"><b>DEGREE DETAILS</b></p>  </td>
  </tr>
</table>
<div><br /></div>
<table width="100%" border="1" cellspacing="0" cellpadding="0" id="maintable_one">
  <tr>
    <td><b>Regulation</b></td>
    <td><b>Year&nbsp;of&nbsp;Passing</b></td>
    <td><b>School&nbsp;Name</b></td>
  </tr>
  <tr>
    <td><?php print_r($regulation);?></td>
    <td><?php print_r($exam_new);?></td>
    <td><?php  print_r($schoolname_new);?></td>
  </tr>
   <tr>
    <td><b>Course</b></td>
    <td><b>Stream</b></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><?php print_r($admissioncourse_new);?></td>
    <td><?php print_r($admissionbranch_new);?></td>
    <td>&nbsp;</td>
  </tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0" id="maintable_one">
 
 <br />
</table>
<div><br /></div>
<table id="table2excel" border="1" class="display nowrap" style="width:100%">
                         
              
                        <thead>
                                  <!--<tr> <th>&nbsp;</th>
<th colspan="1">Regulation:</th>									
<th colspan="1">Year&nbsp;of&nbsp;Passing</th>
<th colspan="1">School&nbsp;Name</th>
<th colspan="1">Course</th>
<th colspan="1">Stream</th>
                                    <th>&nbsp;</th>
                                    <th>&nbsp;</th>
                                    <th>&nbsp;</th>
</tr>-->
<!--<tr><td>&nbsp;</td>
<td colspan="1"><?php ////print_r($regulation);?></td>									
<td colspan="1"><?php //print_r($exam_new);?></td>
<td colspan="1"><?php //print_r($schoolname_new);?></td>
<td colspan="1"><?php // print_r($admissioncourse_new);?></td>
<td colspan="1"><?php //print_r($admissionbranch_new);?></td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>-->

 
                             
                            <tr>
                                    <th>S.No.</th>
									
                                    <th>&nbsp;PRN&nbsp;</th>
                                    <th>Student Name</th>
                                    <th>&nbsp;Photo&nbsp;</th>
									<th>&nbsp;Classification&nbsp;</th>
                                    <th>&nbsp;CGPA&nbsp;</th>
                                   <!-- <th>Session</th>-->
                                    <th>&nbsp;Attempt&nbsp;</th>
                                   
                                    

                                    
                            </tr>
                        </thead>
                        <tbody id="studtbl">
                        	
                            <?php
                            //echo "<pre>";
							//print_r($stud_list);
                          
                            $j=1;  $Honours='0'; $Distinction='0';  $FirstClass='0';     $SecondClass='0';   $ThirdClass='0';                
                            for($i=0;$i<count($stud_list);$i++)
                            {
								if(!empty($stud_list[$i]['Result'])){
                            ?>
	
							 
                            <tr>
						<!--<td class="noExl">
                            
                            <input type="hidden" name="stream_idn[]" id='resstream_id' value="<?=$stud_list[$i]['stream_id']?>">
                            <input type="hidden" name="exam_idn[]" id='resstream_id' value="<?=$stud_list[$i]['exam_id']?>">
                            </td>-->
                              <td><?=$j?></td>
                        		<!--input type="hidden" name="stud_prn[]" style="width:30px" value="<?=$stud_list[$i]['enrollment_no']?>">
                        		<input type="hidden" name="stud_id[]" style="width:30px" value="<?=$stud_list[$i]['student_id']?>"-->
                                <td><?=$stud_list[$i]['enrollment_no']?></td> 
                                <td align="center"><?=$stud_list[$i]['stud_name'];?></td> 	
                                <td><img src="<?=base_url()?>uploads/student_photo/<?=$stud_list[$i]['enrollment_no']?>.jpg" alt="<?=$stud_list[$i]['student_id']?>" width="50" ></td>
								<td><?php //$stud_list[$i]['Result'];
								   if(($stud_list[$i]['Result']=="Honours")){
									echo "FCH";
									}else if($stud_list[$i]['Result']=="Distinction") {
									echo "FWD";
									}else if($stud_list[$i]['Result']=="First Class") {
									echo "FC";	
									}else if($stud_list[$i]['Result']=="Second Class") {
									echo "SC";	
									}else if($stud_list[$i]['Result']=="Third Class") {
									echo "TC";	
									}
								
								?>
                                <?php if(($stud_list[$i]['Result']=="Honours")){
									$Honours +=1;
									}else if($stud_list[$i]['Result']=="Distinction") {
									$Distinction +=1;
									}else if($stud_list[$i]['Result']=="First Class") {
									$FirstClass +=1;	
									}else if($stud_list[$i]['Result']=="Second Class") {
									$SecondClass +=1;	
									}else if($stud_list[$i]['Result']=="Third Class") {
									$ThirdClass +=1;		
									}
									?>
                                </td> 
                                
                                <td><?=$stud_list[$i]['cumulative_gpa'];?></td>
<!--                                <td><?=$stud_list[$i]['exam_month'].'-'.$stud_list[$i]['exam_year'];?></td>
-->                                <td><?php if($stud_list[$i]['checb']==0){ echo 'First Attempt'; }else{ echo '-';} ?></td>
                             							
                            </tr>
                            <?php
                            $j++;
								}}
                            ?>  
                        
                       

 

</tbody> 
</table>
<div><br /></div>

<table width="100%" border="1" cellspacing="0" cellpadding="0" id="maintable_one">
  <tr>
    <td><b>FCH</b></td>
    <td><b>FWD</b></td>
    <td><b>FC</b></td>
    <td><b>SC</b></td>
    <td><b>TC</b></td>
  </tr>
  <tr>
    <td><?php print_r($Honours);?></td>
    <td><?php print_r($Distinction);?></td>
    <td><?php print_r($FirstClass);?></td>
    <td><?php echo $SecondClass; ?></td>
<td><?php echo $ThirdClass; ?></td>
  </tr>
   
</table>
</body>
</html>

