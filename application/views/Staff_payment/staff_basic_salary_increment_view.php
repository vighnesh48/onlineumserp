<?php 
$role_id=$this->session->userdata("role_id");
?>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>


<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Masters</a></li>
        <li class="active"><a href="#">Staff Increment Details</a></li>
    </ul>
					 <?php 
     if(isset($_SESSION['status']))
    {
        ?>
			<script>
			//alert("Your Details already Submitted.");
			var status="<?php echo $_SESSION['status'] ?>";
			 alert(status);
			</script>
        <?php 
        unset($_SESSION['status']);
       }
   ?>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-money"></i>&nbsp;&nbsp;Staff Increment Details</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">                       
                    <div class="visible-xs clearfix form-group-margin"></div>
					
                </div>
            </div>
        </div>
        <div class="row ">
           <div class="col-sm-12">&nbsp;</div>
        </div>
        <div class="row ">
            <div class="col-sm-12">			
                <div class="panel">
				 <div class="panel-heading panel-info">
                  <form id="form" name="form" action="" method="POST"  enctype="multipart/form-data">				 
                       <div class="form-group">
					   <label class="col-sm-1">Academic Year<?=$astrik?></label>     
                           <div class="col-sm-3">
                           	<select  name="acad_year" id="acad_year" class="form-control" >
								<option value="">Select Year</option>	   
								<option value="2024-25">2024-25</option>	   
								<option selected='' value="2023-24">2023-24</option>	   
								</select>
                           </div>
						   <label class="col-sm-1">From Date<?=$astrik?></label>     
                           <div class="col-sm-3">
                             <input type="text" id="from_date" name="from_date" class="form-control" placeholder="Enter From Date" />
                           </div><div class="col-sm-6"></div>
						   </div>
						    <div class="form-group">
						   <label class="col-sm-1">To Date<?=$astrik?></label>     
                           <div class="col-sm-3">
                              <input type="text" id="to_date" name="to_date" class="form-control" placeholder="Enter To Date"/>
                           </div>
                   <div class="col-md-2"><button type="button" id="bd_search" class="btn-primary btn">Search</button></div>
                  <div class="holder"></div></div>
               </div>
                <div class="panel-body">
                   <div class="table-info" id='load_tbl'>    					
                    </div>
                 </div>
              </div>
            </div>    
        </div>
    </div>
</div>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.flash.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js" type="text/javascript"></script>
<script>
$(document).ready(function (){
	
	$('#from_date').datepicker( {format: 'dd-mm-yyyy',autoclose:true,endDate: new Date()});
	$('#to_date').datepicker( {format: 'dd-mm-yyyy',autoclose:true,endDate: new Date()});
		$('#example').DataTable({
						orderCellsTop: true,
                        fixedHeader: true,
						dom: 'lBfrtip',
					    destroy: true,
						retrieve:true,
						paging:true,
						buttons: [
							 'excel'
						],
						lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],					  
					  });
					  
					  
	           }); 
 
$(document).ready(function(){	 	
    $("#bd_search").trigger("click");	
});
	$("#bd_search").click(function(){		
	$('#load_tbl').empty();
    $('#example').dataTable().fnDestroy();      
   var acad_year=$('#acad_year').val(); 
   var from_date=$('#from_date').val(); 
   var to_date=$('#to_date').val(); 
   if(from_date > to_date)
   {
	  alert("From Date Must be Less Than To Date"); 
	  return false;
   }
   var url  = "<?=base_url().strtolower($currentModule).'/fetch_staff_increment_data/'?>";
   var data= {acad_year:acad_year,from_date:from_date,to_date:to_date};  
    $.ajax({ 
                   type:"POST",
                   url:url,
                   data:data,
                   success: function(html)
   				   {
                   $('#load_tbl').html(html);	 				   
				   }	   				   
				});		   
		    });			
		//});		   		 
</script>
