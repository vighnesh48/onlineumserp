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
<script src="https:////cdn.datatables.net/buttons/1.4.2/js/buttons.colVis.min.js"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.4.2/css/buttons.dataTables.min.css">
<style>
th, td { white-space: nowrap; }
    
</style>
<script>

$(document).ready(function() {
 
 var table=   $('#example').DataTable( {
        dom: 'Bfrtip',
		  scrollY:      "500px",
        scrollX:        true,
        scrollCollapse: true,
        paging:         false,
        //fixedColumns: true,
        ordering: false,
columnDefs: [
            { width: '100%', targets: 0 }
        ],
       
        buttons: [
            {
                extend: 'excel',
                messageTop: '<?="Admission Statistics-$academic_year"?>',
				filename: 'Admission Statistics'
            },
            {
                extend: 'csv',
                messageTop: '<?="Admission Statistics-$academic_year"?>',
				filename: 'Admission fees List'
            }
            
        ]
         
    } );
} ).columns.adjust();




</script>

<?php
//print_r($adm_data);
?>
      
		  <div class="row ">
		  
            <div class="col-sm-12">
				<div class="panel">
                    
                    <div class="panel-body">
                        <div class="table-info table-responsive ">  

							<table id="example" class="table table-bordered table-hover" width="100%">
							<thead>
							    <?php
							    if(!empty($adm_data)){
							        ?>
								<tr>
									<th>S.No</th>
									<th >Course</th>
									<th >Stream </th>
									<th >Year</th>
									<th >#Male</th>
									<th >#FeMale</th>
									<th >#Total</th>
									<th >#GM-Male</th>
									<th >#GM-FeMale</th>
									<th >#SC-Male</th>
									<th >#SC-FeMale</th>
									<th >#ST-Male</th>
									<th >#ST-FeMale</th>
									<th >#OBC-Male</th>
									<th >$OBC-FeMale</th>
									<th >#Hindu-Male</th>
									<th >#Hindu-FeMale</th>
									<th >#Jain-Male</th>
									<th >#Jain-FeMale</th>
									<th >#Sikh-Male</th>
									<th >$Sikh-FeMale</th>
									<th >#Christian-Male</th>
									<th >#Christian-FeMale</th>
									<th >#Buddhist-Male</th>
									<th >#Buddhist-FeMale</th>
									<th >#Muslim-Male</th>
									<th >#Muslim-FeMale</th>
									<th >#MS-Male</th>
									<th >#MS-FeMale</th>
									<th >#OMS-Male</th>
									<th >#OMS-FeMale</th>
									<th >#NRI-Male</th>
									<th >#NRI-FeMale</th>
									<th >#PHY-Male</th>
									<th >#PHY-FeMale</th>
								
								
								</tr>
								</thead>
								<tbody>
								<?php				
								$i=1;
									
										foreach($adm_data as $stud){
										
										
								?>
									<tr>
										<td><?=$i?></td>
										<td><?=$stud['course_short_name']?></td>
										<td><?=$stud['stream_short_name']?></td>
										<td><?=$stud['year']?></td>
										<td><?=$stud['Male']?></td>
										<td><?=$stud['Female']?></td>
										<td><?=($stud['Male']+$stud['Female'])?></td>
										<td><?=$stud['GM-Male']?></td>
										<td><?=$stud['GM-Female']?></td>
										<td><?=$stud['SC-Male']?></td>
										<td><?=$stud['SC-Female']?></td>
										<td><?=$stud['ST-Male']?></td>
										<td><?=$stud['ST-Female']?></td>
										<td><?=$stud['OBC-Male']?></td>
										<td><?=$stud['OBC-Female']?></td>
										<td><?=$stud['Hind-Male']?></td>
										<td><?=$stud['Hind-Female']?></td>
										<td><?=$stud['Jai-Male']?></td>
										<td><?=$stud['Jai-Female']?></td>
										<td><?=$stud['Sik-Male']?></td>
										<td><?=$stud['Sik-Female']?></td>
										<td><?=$stud['Chri-Male']?></td>
										<td><?=$stud['Chri-Female']?></td>
										<td><?=$stud['Bud-Male']?></td>
										<td><?=$stud['Bud-Female']?></td>
										<td><?=$stud['Mus-Male']?></td>
										<td><?=$stud['Mus-Female']?></td>
										<td><?=$stud['MS-Male']?></td>
										<td><?=$stud['MS-Female']?></td>
										<td><?=$stud['OMS-Male']?></td>
										<td><?=$stud['OMS-Female']?></td>
										<td><?=$stud['NRI-Male']?></td>
										<td><?=$stud['NRI-Female']?></td>
										<td><?=$stud['PHY-Male']?></td>
										<td><?=$stud['PHY-Female']?></td>
									
									</tr>
								<?php
								
										$i++;
										}
										
										?>
										<?php?>
									
								
										
								<?php
									}else{
									    
										echo '
<div class="bs-example">
    <div class="alert alert-dager fade in">

        <a href="#" class="close" data-dismiss="alert">&times;</a>

        <strong>Warning!</strong> There is no data for selected Academic Year.
</div>
    </div>

';
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


