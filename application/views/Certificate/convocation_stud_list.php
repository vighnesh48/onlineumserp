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
        <li class="active"><a href="#">Convocation</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-trophy page-header-icon"></i>&nbsp;&nbsp; Convocation Registration Students List</h1>
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
							   <th>Admit Card</th>
								<th>Student Name</th>
								<th>Enrollment No</th>
								<th>School</th>
								<th>Course</th>
								<th>Stream</th>
								<th>MobileNo</th>
								<th>Email</th>
								<th>Degree Collected</th>
								<th>Physical Presence</th>
								<th>Members</th>
								<th>Members Details</th>
								<th>Members Relation</th>
								<th>Certificate Fees</th>
								<th>Created Date</th>
								<th>Employee Details</th>
								<th>Higher Studies</th>
								
							<!--<th>Payment Status</th>
							    <th>Address</th>-->
								
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
                               <td><a href="https://www.sandipuniversity.edu.in/convocation/admit-card_plain.php?student_id=<?=base64_encode($stud_details[$i]['conv_id'])?>" target="_blank">
										<i class="fa fa-file-pdf-o" aria-hidden="true" style="color:red;cursor:pointer"></i>
									</a></td>   
                                <td><?=$stud_details[$i]['first_name'].' '.$stud_details[$i]['middle_name'].' '.$stud_details[$i]['last_name']?></td>
                                <td><?=$stud_details[$i]['enrollment_no']?></td>
                                <td><?=$stud_details[$i]['school_short_name']?></td>
                                <td><?=$stud_details[$i]['course_short_name']?></td>
                                <td><?=$stud_details[$i]['stream_name']?></td>
                                <td><?=$stud_details[$i]['mobile']?></td>
                                <td><?=$stud_details[$i]['email']?></td>
                                <td><?=$stud_details[$i]['degree_collected']?></td>
                                <td><?=$stud_details[$i]['physical_presence']?></td>
                                <td><?=$stud_details[$i]['no_of_members']?></td>
                                <td><?=$stud_details[$i]['member_details']?></td>
                                <td><?=$stud_details[$i]['member_relations']?></td>
                                
								<td><?=$stud_details[$i]['certificate_fees']?></td>
								<td><?=$stud_details[$i]['created_on']?></td>
								<td><?=$stud_details[$i]['employeer_details']?></td>
                                <td><?=$stud_details[$i]['higher_studies']?></td>
                                
                           <!--<td><?php //$stud_details[$i]['payment_status']?></td>
                                <td><?php //$stud_details[$i]['address']?></td>-->
                                
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
			lengthMenu: [[50,100, 150, -1], [50,100, 150, "All"]],					  
		  });
});
</script>