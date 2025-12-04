   <script>
/*  $('#tt').DataTable({
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
  </script><div style="height:100px"></div>       <div id="pagination">

<!-- Show pagination links -->
<?php foreach ($links as $link) {
echo  $link ;
} ?>

</div>    
 <table class="table table-bordered" id="getdata" style="width:100%;max-width:100%;">
                        <thead>
                            <tr>
                                    <th>#</th>
                                    <th>Receipt No</th>
                                    
                                    <th>Name</th>
                                    <th>erp Name</th>
                                    <th>Mobile</th>
                                    <th>Prn No</th>
                                    <th>Erp Prn </th>
                                    <th>Amount</th>
                                    <th>Paid Date</th>
                                    
                                    <th>Status</th>
                                    
                                    <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php
                            //print_r($challan_details);
                            $j=1; $i=0;  
                            $CI =& get_instance(); 
                           
                                             
                            foreach($challan_details as $list)
                            {
                                if($list['challan_status']=='VR')
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
                                }
                                
                            ?>
                            <tr <?php echo $bgcolor; ?>>
                                <td><?=$j?></td>                                                                
                                <td><?=$list['exam_session']?></td>
                            
                                <td><?=$list['student_name']?></td>
                                 <td><?=$student_erp_name?></td>
                                 <td><?=$list['mobile_no']?></td>
                              <td><?php 
                                 if(!empty($datas)) { echo $datas[0]['enrollment_no']; } else{
                                    $fromsmdandprov=$CI->Receipt_model->get_student_dataprn_usingmobile_fromsmdandprov($list['mobile_no']);
                                    if(!empty($fromsmdandprov))
                                    {
                                        echo $fromsmdandprov[0]['enrollment_no'];

                                    }
                                    else
                                    {
                                        echo "";
                                    }
                                    
                                 }  ?></td>
                                   <td><?=$erp_enrollment_no?></td>
                                 <td><?=$list['amount']?></td>
                                <td><?php
                                echo date("d/m/Y", strtotime($list['created_on']));
                                ?></td>
                                <td><?php if($list['challan_status']=='VR')echo '<span style="color:Green" >Deposited</span>';
                                            else if($list['challan_status']=='CL')
                                            echo '<span style="color:red" >Cancelled</span>';
                                            else echo '<span style="color:#1d89cf" >Pending</span>';?>
                                            </td>
                                <td>
                                <!--  <a title="View challan Details" class="btn btn-primary btn-xs" onclick="fullview_challan('<?=$list['fees_id']?>')">View</a>
                                -->
                            <?php //if($this->session->userdata("uid")==2){?>
                            <a title="View challan Details" class="btn btn-primary btn-xs" href="<?=base_url($currentModule."/edit_challan/".$list['fees_id'])?>">View</a>
                            <?php //} ?>       
                                <a  href="<?=base_url($currentModule."/download_challan_pdf/".$list['fees_id'])?>" title="View" target="_blank" <?=$disable?>><i class="fa fa-file-pdf-o" aria-hidden="true"  style="font-size:20px;color:red;"></i> </a>
                                </td>
                                
                            </tr>
                                <?php
                                $j++;
                            }
                            ?>                            
                        </tbody>
                        
                        
                        
                        <?php 
						//echo $this->pagination->create_links();
						
						//print_r($links);
						 ///print_r($links->records->navigation);//if (isset($links)) { ?>
                <?php //echo $links['records']['navigation'];?> 
            <?php //} ?>
                    </table> 
             