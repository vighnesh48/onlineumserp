
<?php //echo  "<pre>"; print_r($unittest); die;
$role_id = $this->session->userdata('role_id');
 ?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#"></a></li>
        <li class="active"><a href="#"></a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp; Receipt Report</h1>
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
                <div class="panel">
                    
                <div class="panel-heading">
                      
                </div>
      
                <div class="panel-body" style="overflow:scroll;height:800px;" id="dtable">
                   
                   <table class="table table-bordered" id="search-table"  style="width:100%;max-width:100%;">
                        <thead>
                            <tr>
                                    <th>#</th>
									<th>Challan No</th>
									<th>Student Name</th>
                                    <th>Student Mobile</th>
                                    <th>Student PRN</th>
                                    <th>Recepit Name</th>
                                    <th>Recepit Mobile</th>
									<th>Amount</th>
									<th>Status</th>
                                    
                                   
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php
							//print_r($challan_details);
                            $j=1; $i=0;  
                            $CI =& get_instance(); 
                           
                                             
                            foreach($receipt_checklist as $list)
                            {
                            	
                               if($list['Result']=="MATCH") {
								   $bg="#fff";
							   }else{
								   $bg="#F63";
							   }
                            ?>
                            <tr style="background-color:<?php echo $bg;?>">
                                <td><?=$j?></td>                                                                
                                <td><?=$list['exam_session']?></td>
							
                                <td><?=$list['real_name']?></td>
                                 <td><?=$list['mobile']?></td>
                                 <td><?=$list['enrollment_no']?></td>
                             
                                 <td><?=$list['student_name']?></td>
                                 <td><?=$list['mobile_no']?></td>
                                 <td><?=$list['ramount']?></td>
								 <td><?=$list['Result']?></td>
							
								
								
							</tr>
								<?php
								$j++;
                            }
                            ?>                            
                        </tbody>
                    </table>
                
                </div>
            </div>
            </div>    
        </div>
    </div>
</div>







<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">






<script type="text/javascript">
		$(document).ready(function() {
		    
			
			
		 $('#search_dt').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
  $('#durationFrom').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
  $('#durationTo').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
		    
		    
		    
		$("#btnsearch").on('click',function(){
			//alert('hh');
		var pst = $("#pstatus").val();
		var styp = $("#styp").val();

    var sdt = $("#search_dt").val();
  var dfrm= $('#durationFrom').val();
   var dto = $('#durationTo').val();
//if(styp==''){
  //alert('Select Duration or Date');
//}else{
		var url  = "<?=base_url($currentModule.'/get_receipt_list')?>";	
		var data = {'pst':pst,'styp':styp,'sdt':sdt,'dfrm':dfrm,'dto':dto};		
		$.ajax({
			type: "POST",
			url: url,
			data: data,
			dataType: "html",
			cache: false,
			crossDomain: true,
			success: function(data){
				//(data);
				$('#dtable').html(data);
			//	$('#block').html('');
			//	return false;
			},
			error: function(data){
				alert("Page Or Folder Not Created..!!");
			}
		});
  //}
	});
	
	
	
	$('#styp').change(function () {
    var dur=$('#styp').val();
    //alert(dur);
              if(dur =='day'){
                $('#day').show();
     
        $('#durationn').hide();
        $('#durationFrom').val('');
        $('#durationTo').val('');
                 
            }else if(dur =='dur'){
                $('#day').hide();       
        $('#durationn').show();
                $('#durationFrom').val('');
                $('#durationTo').val('');
            } 
        });
		    
		    
		    
		    
   
});

		</script>
<script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.colVis.min.js"></script>

<script>
	/*$(document).ready(function() {
$("#btnsearch").trigger("click");
	});*/
</script><script>
$(document).ready(function() {
    $('#search-table').DataTable( {
        dom: 'Bfrtip',
        targets: 'no-sort',
bSort: false,
     bPaginate: false,
        buttons: [
            
            {
                extend: 'excelHtml5',
                title: 'Receipt List'
            },
            {
                extend: 'pdfHtml5',
                title: 'Receipt List'
            }
        ]
    } );

       
} );
</script>