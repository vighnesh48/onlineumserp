<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>

<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.4.2/js/buttons.html5.min.js"></script>
<script src="https:////cdn.datatables.net/buttons/1.4.2/js/buttons.print.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.4.2/css/buttons.dataTables.min.css">
<script>

$(document).ready(function() {
	

    var printCounter = 0;
 
    // Append a caption to the table before the DataTables initialisation
    //$('#example').append('<caption style="caption-side: bottom">A fictional company\'s staff table.</caption>');
 
    $('#example').DataTable( {
        dom: 'Bfrtip',
		"bPaginate": false,
		deferRender:   true,
        scrollY:    500,
        scrollCollapse: true,
        scroller:       true,
        ordering: false,
        buttons: [
            {
                extend: 'excel',
                messageTop: '<?="Bonafied List"?>.',
				filename: 'Bonafied List'
            },
            
           
        ]
    } );
} );
</script>

<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Account</a></li>
        <li class="active"><a href="#">Admission fees</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp; Bonafied Certificate List</h1>
            <div class="col-xs-12 col-sm-8">
                                 
                    <hr class="visible-xs no-grid-gutter-h">
                                        <div class="pull-right col-xs-12 col-sm-auto"><a style="width: 100%;" class="btn btn-primary btn-labeled" href="<?=base_url($currentModule.'/add_bonafied/')?>"><span class="btn-label icon fa fa-plus"></span>Add Bonafied</a></div>                        
                    <div class="visible-xs clearfix form-group-margin"></div>
            </div>
        </div>
     
      <br>
		  <div class="row ">
		 
            <div class="col-sm-12">
				<div class="panel">
                    
                    <div class="panel-body">
                        <div class="table-info">  

							<table id="example" class="table table-bordered display">
							<thead>
								<tr>
									<th data-orderable="false">#</th>
									<th data-orderable="false"> PRN</th>
								     <th data-orderable="false"> Name</th>
									<th data-orderable="false">Reference No</th>
									<th>Issue Date</th>
									<th data-orderable="false">Purpose</th>
									<th data-orderable="false">Action</th>
								
								</tr>
								</thead>
								<tbody>
							 <?php
                 
                          
                            $j=1;                            
                            foreach($student_list as $emp_list)
                            {
                                
                            ?>
							 <?php if($emp_list['ro_flag']=='on') $bg="bgcolor='#e6eaf2'";
								  else $bg="";?>								
                            <tr <?=$bg?> <?=$emp_list["status"]=="N"?"style='background-color:#FBEFF2'":""?>>
                               
                        <td><?=$j?></td>
                                 <td><?=$emp_list['enrollment_no']?></td> 
                                  <td><?=$emp_list['first_name'].'  '.$emp_list['last_name'] ?></td> 

								   <td><?=$emp_list['cert_reg']?></td> 
                                                                                              
                            <td><?=$emp_list['cert_date']?></td>                               
                                                      
                                <td><?=$emp_list['purpose'];?></td> 
                                
                      <td><a href="<?=base_url($currentModule.'/regenerate_bonafide/'.$emp_list['bc_id'].'/'.$emp_list['enrollment_no'])?>" target="_blank" class="btn btn-primary btn-sm">view </a></button> </td> 
                            
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
</div>

<script>
$(document).ready(function () {
	
	///////////////////////////////
	// fetch stream form course
	var stream_id = $("#semester").val();
	if(stream_id !=''){
		$("#sem_id").val(stream_id);
	}
		// fetch subject of sem_acquire
		$("#stream_id").change(function(){
			//alert("hi");
		  $('#semester option').attr('selected', false);
		});
		
		$("#division").change(function(){
			var streamId = $("#stream_id").val();
			var course_id = $("#course_id").val();
			var semesterId = $("#semester").val();
			var divs = $("#division").val();
			$.ajax({
				'url' : base_url + 'Batch_allocation/load_subject',
				'type' : 'POST', //the way you want to send data to your URL
				'data' : {'course' : course_id,'streamId':streamId,'semesterId':semesterId,'division':divs},
				'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
					var container = $('#subject'); //jquery selector (get element by id)
					if(data){
						//alert(data);
						container.html(data);
						//$("#semest option[value='" + stream_id + "']").attr("selected", "selected");
					}
				}
			});
		});
		
  });

</script>
