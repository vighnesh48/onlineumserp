  <script>
 /* $('#getdata').DataTable({
	  "paging":   false,
        "ordering": false,
        "info":     false
		
    //"pagingType": "simple" // "simple" option for 'Previous' and 'Next' buttons only
  });*/
  function newajx(n){
	  //alert(n);
	  var type='POST';var url=n;
	 var  datastring={};
	  html_content=ajaxcall(type,url,datastring);
	  display_content(html_content);
  }
  function ajaxcall(type,url,datastring)
{  
	var res;
	$.ajax({
		type:type,
		url:url,
		data:datastring,
		cache:false,
		async:false,
		success: function(result)
	 {
	  res=result;	 
	 }
	});
	return res; 
}
function display_content(html_content)
{

	$("#getdata").html(html_content);
}
  </script>
  
  
  <div><?php foreach ($links as $link) {
echo  $link ;
} ?></div>
 <table class="table table-bordered" id="getdata" style="width:100%;max-width:100%;">
                        <thead>
                            <tr>
                                    <th>#</th>
                                    <th>Receipt No</th>
                                    
                                    <th>Deposite Name</th>
                                    <th>Deposite Amount</th>
                                    <th>Mobile</th>
                                    <th>Recepit Name</th>
                                    <th>Recepit Amount</th>
                                    <th>Mobile</th>
                                    <th>Match</th>
                                    
                                  
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php
                            //print_r($challan_details);
                            $j=1; $i=0;  
                            $CI =& get_instance(); 
                           
                                             
                            foreach($challan_details as $list)
                            {
                               /* if($list['challan_status']=='VR')
                                {
                                    $student_masterdata=$CI->Receipt_model->get_enrollment_no_from_student_master($list['exam_session']);
                                    $datas=$CI->Receipt_model->get_enrollment_no_onthebasis_of_remark_formno($list['student_id']);
                                    
                                    if(!empty($student_masterdata))
                                    {
                                       $student_erp_name= $student_masterdata[0]['first_name'];
                                       $erp_enrollment_no= $student_masterdata[0]['enrollment_no'];
                                       if($erp_enrollment_no!=$datas[0]['enrollment_no'])
                                       {
                                       	$bgcolor="style='color:red'";
                                       }
                                       else
                                       {
                                       	$bgcolor='';
                                       }
                                       
                                     

                                    }
                                    else
                                    {
                                        $student_erp_name='';
                                        $erp_enrollment_no='';
                                        $bgcolor='';
                                    }
                                }*/
                                
                            ?>
                            <tr <?php echo $bgcolor; ?>>
                                <td><?=$j?></td>                                                                
                                <td><?=$list['exam_session']?></td>
                            
                                 <td><?=$list['real_name']?></td>
                                 <td><?=$list['damount']?></td>
                                 <td><?=$list['mobile']?></td>
                                 <td><?=$list['student_name']?></td>
                                 <td><?=$list['ramount']?></td>
                                 <td><?=$list['mobile_no']?></td>
                                 <td><?php if($list['rid']==$list['student_id']){echo 'Proper Deposit';}else{echo '<b style="color:red">Not Proper Deposit<b>';} ?></td>
                               
                                
                                
                            </tr>
                                <?php
                                $j++;
                            }
                            ?>                            
                        </tbody>
                       
                    </table>     
                   