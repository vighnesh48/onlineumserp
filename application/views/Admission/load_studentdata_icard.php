   <?php
//  var_dump($_SESSION);
   ?>
    <form method="post" action="<?=base_url()?>Ums_admission/generateID/">
 
 <table class="table table-bordered" id="testTable">
                        <thead>
                            <tr>
                              
                                    <th>S.No.</th>
                                    <th>PRN</th>
                                    <th>PRN Old</th>
                                    <th>Name</th>
                               
                                      <th>Photo</th>
                                      <th>QR Code</th>
                                    
                                       <th>DOB</th>
                                       <th>Address</th>
                                          <th>Department </th>
                                              <th>Blood Group</th>
                                                <th>Contact</th>
                                     <th>Parent Contact</th>
                                     <th> Institute Contact </th>
                                     
                                     
                                  
                                 
                                   
                                  
                                
                                   
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php
                            
                          
                            $j=1;                            
                            for($i=0;$i<count($emp_list);$i++)
                            {
                                if($emp_list[$i]["cancelled_admission"]=="Y")
                                {
                                    
                                }
                                else
                                {
                                
                            ?>
							 <?php if($emp_list[$i]['ro_flag']=='on') $bg="bgcolor='#e6eaf2'";
								  else $bg="";?>								
                            <tr height="150" <?=$emp_list[$i]["cancelled_admission"]=="Y"?"style='background-color:#f5b9a1'":""?>>
                            
                               <td><?=$j?></td>
                        
                                 <td>'<?=$emp_list[$i]['enrollment_no']?></td> 
                                  <td><?="'".$emp_list[$i]['enrollment_no_new']?></td> 
                                   <td>	<?php
								echo $emp_list[$i]['first_name']." ".$emp_list[$i]['middle_name']." ".$emp_list[$i]['last_name'];
								?>
								</td> 
								    
                                   <td  class="noExl" width="100">
                                       <?php
                                    /*
                                       if (file_exists('uploads/2017-18/'.$emp_list[$i]['form_number'].'/' . $emp_list[$i]['form_number'].'_PHOTO.bmp')) {
                                        
                                           $ext = 'bmp';
                                       }
                                       else
                                       {
                                             $ext = 'jpg';
                                       }
                                       */
                                       ?>
                                      <!-- 
                                       <img src="https://erp.sandipuniversity.com/uploads/2017-18/<?=$emp_list[$i]['form_number']?>/<?=$emp_list[$i]['form_number']?>_PHOTO.<?=$ext?>" alt="" width="80" height="80"/>
                                       -->
                                       
                                        <img src="https://erp.sandipuniversity.com/uploads/student_photo/<?=$emp_list[$i]['enrollment_no']?>.jpg" alt="" width="80" height="80"/>
                                    
                                       
                                       </td> 
                             
                             
							  <td width="100"> <img src="https://erp.sandipuniversity.com/qrcodes/qrcode_<?=$emp_list[$i]['enrollment_no']?>.jpg" width="100" height="100"/></td> 
							      
							      <td><?=$emp_list[$i]['dob']?></td> 
							          <td><?=$emp_list[$i]['add']?></td> 
								   <td><?=$emp_list[$i]['stream_name']?></td> 
                                                <td><?=$emp_list[$i]['blood_group'];?></td>      
                                                <td><?=$emp_list[$i]['mobile'];?></td>    
                                
                                         <td><?=$emp_list[$i]['pmobile']?></td>
                                     <td> 9545453255 </td>
                            </tr>
                            <?php
                            $j++;
                                }
                            }
                            ?>                            
                        </tbody>
                    </table>  
                    
                       <input type="hidden" name="dcourse" value="<?=$dcourse;?>">
                     <input type="hidden" name="dyear" value="<?=$dyear;?>">
                    
                     <!-- <input type="submit" value="Apply Fees" class="btn btn-primary btn-labeled">-->
                     
                     
                     </form><br><br>
                    <form method="post" action="<?=base_url()?>Ums_admission/generatepdf/" style="float: left;margin-top: -29px;margin-left: 150px;">
                    <input type="hidden" name="dcourse" value="<?=$dcourse;?>">
                     <input type="hidden" name="dyear" value="<?=$dyear;?>">
            
                      <input type="button" onclick="tableToExcel('testTable', 'Student List')" value="Export as Excel" class="btn btn-primary btn-labeled">
                     </form>
                     
                     <script>
                     
                     
                     
                     
$(document).ready(function () {
    $("#ckbCheckAll").click(function () {
        $(".checkBoxClass").prop('checked', $(this).prop('checked'));
    });
    
    $(".checkBoxClass").change(function(){
        if (!$(this).prop("checked")){
            $("#ckbCheckAll").prop("checked",false);
        }
    });
});
                     
                     
                   
var tableToExcel = (function() {
  var uri = 'data:application/vnd.ms-excel;name:"student List";base64,'
    , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
    , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
    , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
  return function(table, name) {
    if (!table.nodeType) table = document.getElementById(table)
    var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
    window.location.href = uri + base64(format(template, ctx))
  }
})()

                     
    //                 link.download = downloadName + ".xls";
  //  link.href = uri + base64(format(template, ctx));
  //  link.click();
                     
                     
                     
                     
                     
                     
                     
$("#expdata").click(function(){

  $("#table2excel").table2excel({

    exclude: ".noExl",

    name: "Worksheet Name",
  filename: "Student List" //do not include extension

  });

});

                     </script>
                     
                     
	    