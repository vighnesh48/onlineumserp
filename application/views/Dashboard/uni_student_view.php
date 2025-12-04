<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
	
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
$(document).ready(function(){
      var acad_year='<?php echo $this->uri->segment(3);?>';

	  if(acad_year != '')
	  {
	  $('#acad_year').val(acad_year);
	  }
	  else
	  {
		$('#acad_year').val(<?=C_RE_REG_YEAR?>);  
	  }
	 $('#acad_year').change(function(){      
	 var acad_year=$('#acad_year').val(); 
    // var get=btoa(acad_year);
     var url='<?=base_url()?>dashboard/transport_fees_report/'+acad_year;
      // window.location.href=url+'?acad_year='+acad_year;
       window.location.href=url;
	 });
   });

</script>
<?php //print_r($my_privileges); die; ?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Masters</a></li>
        <li class="active"><a href="#">Reports</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Transport Summary Reports </h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">                 
                    <div class="visible-xs clearfix form-group-margin"></div>
                </div>
            </div>
        </div>
  
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">				
                <div class="panel-heading">
				<div class="col-sm-2">
                           <select  name="acad_year" id="acad_year" class="form-control">
                        <option value="">Select Academic Year</option>
                        <option value="2017"> 2017-18</option>
						<option value="2018"> 2018-19</option>
						<option value="2019"> 2019-20</option>
						<option value="2020"> 2020-21</option>
						<option value="2021"> 2021-22</option>
						<option value="2022"> 2022-23</option>
						<option value="2023"> 2023-24</option>
						<option value="2024" selected> 2024-25</option>
                              </select>
                           </div><br>
                        <span class="panel-title"> </span>
                        <div class="holder"></div>
                </div>
                <div class="panel-body">
                    <div class="table-info">              
                    <table class="table table-bordered" id="example">
                        <thead>
                            <tr>
								<th>#</th>
								<th>Organisation</th>
								<th>Institute Name</th>
								<th>Student Count</th>
								<th>Actual Fees</th>
								<th>Paid Fees</th>
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php
                            $j=1;
                            $stud_count=0;
                  			$stud_ac_fees=0;
                            $stud_paid =0;							
                            for($i=0;$i<count($student_data);$i++)
                            { 
						       $count=$student_data[$i]['std_count'];
							   $actual_sum=$student_data[$i]['actual_fees'];
							   $paid_sum=$student_data[$i]['fees_paid'];
                            ?>
                            <tr>
							<td><?=$j?></td> 
							<td><?=$student_data[$i]['organisation']?></td>
							<td><?=$student_data[$i]['instute_name']?></td>
							<td><?=$student_data[$i]['std_count']?></td>
							<td><?= preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $student_data[$i]['actual_fees'])?></td>
							<td><?=preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $student_data[$i]['fees_paid']) ?></td>
                            </tr>
                            <?php
                            $j++;
							$stud_count=$stud_count+$count;
							$stud_ac_fees=$stud_ac_fees+$actual_sum;
							$stud_paid=$stud_paid+$paid_sum;
                            }
                            ?> 							
                          </tbody>
						   <tr><td></td><td></td><td><b>Total :-</b></td><td><b><?php echo $stud_count?></b></td><td><b><?php echo preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,",$stud_ac_fees)?></b></td><td><b><?php echo preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,",$stud_paid)?></b></td></tr>
                        </table>                     	
                    </div>
                 </div>
               </div>
            </div>    
        </div>
    </div>
</div>
 <script type='text/javascript'>	
$(document).ready(function () {
    var table = $('#example').DataTable({
        orderCellsTop: true,
        fixedHeader: true,
		dom: 'lBfrtip',
	    "bPaginate": false,
		"bInfo": false,
        buttons: [
            'excel'
        ],
		lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
    });
});
 </script>