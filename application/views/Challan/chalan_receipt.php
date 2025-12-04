
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
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp; Receipt List</h1>
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
                     <div class="row ">
                            
                                  

			<div class="col-sm-1 from-group"><h4>Type</h4></div>
				<div class="col-sm-1">
				    <select id="pstatus" name="pstatus" class="form-control" >
				      <option value="">All</option> 
              <?php foreach ($receipt_typ as $key => $value) {
               echo '<option value="'.$value['fees_paid_type'].'" >'.$value['fees_paid_type'].'</option>';
              } ?>
					
				             </select>                                                            
				</div>

		<div class="col-sm-2 from-group"><h4> Select Duration</h4></div>
				<div class="col-sm-2">
				    <select id="styp" name="styp" class="form-control" >
				      <option value="">Select Created Date</option> 
			<option value="day">Day</option> 
      <option value="dur">Duration</option>								
				             </select>                                                            
				</div>
			<div class="col-sm-3" id="day" style="display:none">                      
                        <input type="text" class="form-control" placeholder="Select Date" value="<?php if(isset($posted['search_dt'])){ echo $posted['search_dt']; } ?>" name="search_dt" id="search_dt">  
                         </div> 
		
<div id="durationn" class="col-sm-4" style="display:none">
                        <div class="col-sm-6">                                               
                        <input type="text"  class="form-control" placeholder="From"  value="<?php if(isset($posted['durationFrom'])){ echo $posted['durationFrom']; } ?>"  name="durationFrom" id="durationFrom">  
                         </div><div class="col-sm-6">    
                        <input type="text"  class="form-control" placeholder="To"  value="<?php if(isset($posted['durationTo'])){ echo $posted['durationTo']; } ?>"  name="durationTo" id="durationTo">   
                        </div>
                        </div>

                       <div class="col-sm-1">
            <input class="btn btn-primary btn-labeled"  id="btnsearch" name="search" type="button" value="Search">
            </div>     
                           
                     </div> 
                </div>
      
                <div class="panel-body" style="overflow:scroll;height:800px;" id="dtable">
                   
                   
                
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
	$(document).ready(function() {
$("#btnsearch").trigger("click");
	});
</script>