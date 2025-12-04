<link rel="stylesheet" href="<?= base_url('assets') ?>/stylesheets/jPages.css">
<script src="<?= base_url('assets/javascripts') ?>/jPages.js"></script>
<link rel="stylesheet" href="<?= base_url('assets') ?>/stylesheets/select2.css">
<script src="<?= base_url('assets/javascripts') ?>/select2.min.js"></script>

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
    $('#example').DataTable( {
        dom: 'Bfrtip',
		"bPaginate": false,
        buttons: [
            {
                extend: 'excel',
                messageTop: '<?=$subdetails[0]['subject_name']?>',
				filename: 'Consolidated Marks Report-Div-<?=$division?>'
            }
        ]
    } );
} );	
</script>
<?php //echo  "<pre>"; print_r($unittest); die;
$role_id = $this->session->userdata('role_id');
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Lecture</a></li>
        <li class="active"><a href="#">CIA Master</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;CIA</h1>
<a href="<?=base_url($currentModule."/index/".$this->uri->segment(3))?>" class="pull-right">
		<button type="button" class="btn btn-primary ">Back</button>
	</a>
        </div>
        <div class="row ">
            <div class="col-sm-12">&nbsp;</div>
        </div>
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                <div class="panel-heading">
                        <span class="panel-title">Consolidated Report For Subject: <b><?=$subdetails[0]['subject_name']?></b></span>
                        <div class="holder21"></div>
                </div>
                <div class="panel-body">
                    <div class="table-info">    
					
                    <?php //if(in_array("View", $my_privileges)) { 
?>
                    <table class="table table-bordered" id="example">
                        <thead>
                            <tr>
                                    <th>#</th>
                                    <th scope="col" data-orderable="false">PRN.</th>
									<th scope="col" data-orderable="false">Name</th>
									<?php
									$j = 1;
									if (!empty($unittest)) {
										for ($i = 0; $i < count($unittest); $i++) {
									?>
									<th scope="col" data-orderable="false">CIA-<?= $unittest[$i]['test_no'] ?></th>
									<?php
										}
										
									}
									?>
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php
							$CI =& get_instance();
							$CI->load->model('Unittest_model');
							$k = 1;
							if (!empty($allbatchStudent)) {
								foreach ($allbatchStudent as $stud) {
									//check for attendance
							?>
                            <tr>
                                <td><?= $k ?></td>                                                                
                                 <td><?= $stud['enrollment_no_new'] ?></td>
								<td><?= $stud['first_name'] ?> <?= $stud['last_name']?></td>
								<?php
									foreach($unittest as $ut){
										$marks =$this->Unittest_model->fetch_marks($ut['unit_test_id'], $stud['stud_id']);
										//print_r($marks);
										?>
										<td><?=$marks[0]['marks_obtained'] ?></td>
								<?php	}
								?>
                            </tr>
                            <?php
									$k++;
								}
							}
							?>                            
                        </tbody>
                    </table>                    
                    <?php //} 
?>
                </div>
                </div>
            </div>
				
            </div>    
        </div>
    </div>
</div>
