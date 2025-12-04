<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<script src="<?=base_url('assets/javascripts')?>/jquery.table2excel.js"></script>

                 <script>
                                     var base_url = 'https://erp.sandipuniversity.com/';
                                      function load_streams(type){
                   // alert(type);
                    
                $.ajax({
                    'url' : base_url + '/Ums_admission/load_streams',
                    'type' : 'POST', //the way you want to send data to your URL
                    'data' : {'course' : type},
                    'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
                        var container = $('#semest'); //jquery selector (get element by id)
                        if(data){
                         //   alert(data);
                            //alert("Marks should be less than maximum marks");
                            //$("#"+type).val('');
                            container.html(data);
                        }
                    }
                });
            }
           $(document).ready(function(){
               $('#sbutton').click(function(){
            
         // alert("hi");
             var base_url = 'https://erp.sandipuniversity.com/';
                   // alert(type);
                   var acourse = $("#admission-course").val();
                    var astream = $("#admission-stream").val();
                    var ayear = $("#admission-year").val();
                    
                     if(acourse=='')
                    {
                        alert("Please Select Course");
                        return false;
                    }
                    
                    
                    if(astream=='')
                    {
                          alert("Please Select Stream");
                        return false;
                        
                    }
                    
                    if(ayear=='')
                    {
                          alert("Please Select Year");
                        return false;
                        
                    }
                    
                $.ajax({
                    'url' : base_url + '/Ums_admission/load_studentlist',
                    'type' : 'POST', //the way you want to send data to your URL
                    'data' : {'astream':astream,'ayear':ayear},
                    'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
                        var container = $('#stddata'); //jquery selector (get element by id)
                        if(data){
                            
                        //  alert(data);
                            //alert("Marks should be less than maximum marks");
                            //$("#"+type).val('');
                            container.html(data);
                            	return false;
                        }
                          return false;
                    }
                });
            });
            });
</script>
<?php 
if(isset($role_id) && $role_id==1 ){
?>
<style>
	.table{width: 150%;}
	table{max-width: 150%;}
</style>									
<?php }else{ ?>
	<style>
	table.dataTable{width:100%;}</style>
<?php }?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Admission</a></li>
        <li class="active"><a href="#">Scholarship List</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Schalorship List</h1>
            <div class="col-xs-12 col-sm-8">
                
            </div>
        </div>
        <div class="row ">
            <div class="col-sm-12">&nbsp;</div>
        </div>
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                <div class="panel-heading">
                      


            <div class="table-info table-responsive panel-body">  
		
             <form id="filterdata" action="<?php echo base_url('Ums_admission/scholorship_list'); ?>" method="post">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <select id="academic_year" name="academic_year" class="form-control">
                                    <option value="0">Select Academic Year</option>
                                       <?php foreach ($years as $year): ?>
                                        <option value="<?php echo htmlspecialchars($year->academic_year, ENT_QUOTES, 'UTF-8'); ?>"
                                            <?php echo ($year->academic_year == $selected_year) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($year->academic_year, ENT_QUOTES, 'UTF-8'); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </div>
                    </div>
                </form>
				<?php if($this->session->userdata('name')=='211530'){?>
							<a href="https://erp.sandipuniversity.com/Ums_admission/import_concession_fee_excel" style="float:right;margin-top:-50px;"><button type="submit" class="btn btn-success w-100" fdprocessedid="uudugx">
                                <i class="fa fa-download"></i> Import Scholarship Excel Data
                            </button></a>
				<?php }?>
                   <table class="table table-bordered" id="example">
                        <thead>
                            <tr>
                                   
                                    <th>#</th>
                                    <th width="5%">PRN</th>
                                    <th width="25%">Name</th>
                                    <th  width="25%">Stream </th>
									<th>Admission Year</th>
									<th>Academic Year</th>
									<th>Year</th>
                                    <th>Actual Fees</th>
                                    <th>Exemp.Fees</th>
									<th>Appl. Fees</th>
									<th>Concession Type</th>
									<th>Duration</th>
									<th>Concession Remark</th>
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php
                            $actual_total=0;
                            $exemted_total=0;
                            $appl_total=0;
                          $filehaeder="Sandip University";
                            $j=1;                            
                            for($i=0;$i<count($emp_list);$i++)
                            {
                                $actual_total+=(int)$emp_list[$i]['actual_fee'];
                                $exemted_total+=(int)$emp_list[$i]['actual_fee']-(int)$emp_list[$i]['applicable_fee'];
                                $appl_total+=(int)($emp_list[$i]['applicable_fee']);
                                
                            ?>
							 <?php if($emp_list[$i]['ro_flag']=='on') $bg="bgcolor='#e6eaf2'";
								  else $bg="";?>								
                            <tr>
                               <td><?=$j?></td>
                        
                                 <td><?=$emp_list[$i]['enrollment_no']?></td> 
                                  
								 
                                <td>
							
							<?php
								echo $emp_list[$i]['first_name']." ".$emp_list[$i]['middle_name']." ".$emp_list[$i]['last_name'];
								?>
								</td> 
								
								<td><?=$emp_list[$i]['stream_short_name']?></td> 
								<td><?=$emp_list[$i]['admission_session']?></td>
								<td><?=$emp_list[$i]['academic_year']?></td>
								<td><?=$emp_list[$i]['year']?></td> 
                                <td><?=$emp_list[$i]['actual_fee'];?></td>
                                <td><?=(int)$emp_list[$i]['actual_fee']-(int)$emp_list[$i]['applicable_fee'];?></td>
								<td><?=$emp_list[$i]['applicable_fee'];?></td>	 
								<td><?=$emp_list[$i]['concession_type'];?></td>	 
								<td><?=$emp_list[$i]['duration'];?></td>	 
								<td><?=$emp_list[$i]['concession_remark'];?></td>	 
                            </tr>
                            <?php
                            $j++;
                            }
                            ?> 
                            
                        </tbody>
                        <tr style=" font-weight: bold; "><td colspan="7" style="  text-align: center; "><b>Total:</td><td><?=$actual_total ;?></td><td><?=$exemted_total ;?></td><td><?=$appl_total;?></b></td></tr>
                    </table>
             



					
                 
                </div>
                </div>
                </div>
            </div>
            </div>    
        </div>
    </div>
</div>
<script>
  $("div.holder").jPages
  ({
    containerID : "itemContainer"
  });
       
       
</script>
<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/pdfmake.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.3.1/css/buttons.dataTables.min.css">


<<script>
$(document).ready(function() {
    $('#example').DataTable( {
        
       "language": {
              "search": "Filter Records:"
                },
        "pageLength": 50,
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excel',
                messageTop: 'arv',
                title: 'Scholarship List For Year <?php echo htmlspecialchars($selected_year, ENT_QUOTES, 'UTF-8'); ?>', // Set the Excel title dynamically
                                filename: 'Scholarship_List_<?php echo htmlspecialchars($selected_year, ENT_QUOTES, 'UTF-8'); ?>' // Set the filename dynamically
            },
            {
                extend: 'csv',
                messageTop: 'arv',
                title: 'Scholarship List For Year <?php echo htmlspecialchars($selected_year, ENT_QUOTES, 'UTF-8'); ?>', // Set the CSV title dynamically
                                filename: 'Scholarship_List_<?php echo htmlspecialchars($selected_year, ENT_QUOTES, 'UTF-8'); ?>' // Set the filename dynamically
            },
        ],
       
    } );
} );
</script>