<style> 
     table{
       display:block;overflow:scroll
     }
   </style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://cdn.datatables.net/buttons/2.0.0/js/dataTables.buttons.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.html5.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.print.min.js" type="text/javascript"></script>
<?php //print_r($my_privileges); die; ?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Phd Degree Certificate Assign</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-trophy page-header-icon"></i>&nbsp;&nbsp; Students List</h1>
			<span id="err_msg1" style="color:red;"></span>
			<div class="col-xs-12 col-sm-8">
                <div class="row"> 
					 <hr class="visible-xs no-grid-gutter-h">
                </div>
            </div>
        </div>     
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel-body">						
                    <div class="table-info" >    <!--id="example" class="display"-->
                       <table class="table table-bordered display" style="width:100%;" id="example">
                        <thead>
                        <tr>
							   <th>#</th>
								<th>Student Name</th>
								<th>Enrollment No</th>
								<th>Exam ID</th>
								<th>Exam Month/Year</th>
								<th>School</th>
								<th>Stream </th>
								<th>semester</th>
								<th>Certificate Dispatch</th>
								<th>Thesis Name</th>
								<th>Faculty Name</th>
								<th>Issued Date</th>
								<th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                           <?php
                            $j=1;  							
                            for($i=0;$i<count($stud_details);$i++)
                            {
                            ?>
                            <tr>
                               <td><?=$j?></td>
                                <td><?=$stud_details[$i]['first_name'].' '.$stud_details[$i]['middle_name'].' '.$stud_details[$i]['last_name']?></td>
                                <td><?=$stud_details[$i]['enrollment_no']?></td>
                                <td><?=$stud_details[$i]['exam_id']?></td>
                                <td><?=$stud_details[$i]['exam_month'].'/'.$stud_details[$i]['exam_year']?></td>
                                <td><?=$stud_details[$i]['school_name']?></td>
                                <td><?=$stud_details[$i]['stream_name']?></td>
                                <td><?=$stud_details[$i]['semester']?></td>
                                <td><?=$stud_details[$i]['certificate_dispatch']?></td>
                                <td><?=$stud_details[$i]['thesis_name']?></td>
                                <td><?=$stud_details[$i]['faculty_name']?></td>
                                <td><?=$stud_details[$i]['issued_date']?></td>
                                <td><a href="<?=base_url()?>Phd_results/phd_cert_edit/<?=$stud_details[$i]['gc_id']?>" target="_blank"><i class="fa fa-edit"></i></a> || <a href="<?=base_url()?>Phd_results/generate_degree_certificate_dispatch_pdf/<?php echo base64_encode($stud_details[$i]['gc_id']);?>" target="_blank">
							    <i class="fa fa-file-pdf-o" aria-hidden="true" style="color:red;cursor:pointer"></i>
									</a>
</td>
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
<script>
  $(document).ready(function() {
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
			lengthMenu: [[50, 100, 150, -1], [50, 100, 150, "All"]],					  
		  });
});
</script>