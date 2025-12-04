<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<?php ?>
<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<script src="<?=base_url()?>assets/javascripts/moment.js"></script>
<script src="<?=base_url('assets/javascripts').'/bootstrap-datetimepicker.min.js'?> "></script>

<style type="text/css">
    .table-info {height:700px;overflow-y:scroll;}
.table{width:100%;}
</style>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Leaves</a></li>
        <li class="active"><a href="#">Vacation Master</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Vacation Master</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
         	
                    <div class="pull-right col-xs-12 col-sm-auto"><a style="width: 100%;" class="btn btn-primary btn-labeled" href="<?=base_url($currentModule."/vacation_leave_add")?>"><span class="btn-label icon fa fa-plus"></span>Add </a></div>                        
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
               <div class="panel-heading ">
			    <div class="row">
				<div class="col-md-6" class="form-control">
				<h4>
				For the Academic Year of <span id="year"><b><?php 
				echo $yer ; ?></b></span></h4>
				</div>
				<div class="col-md-6">
				<div class="row">
				<label class="col-sm-8 text-right">Academic Year: </label>
			   <div class="col-md-4" >
			   <select class="form-control" onchange="search_vacation_leves(this.value)" name="ser_year" id="ser_year">
			   <option value="">Select</option>
			                      <option <?php if($yer=='2017-18') { echo 'selected'; } ?> value="2017-18">2017-18</option>
                                    <option <?php if($yer=='2018-19') { echo 'selected'; } ?> value="2018-19">2018-19</option>
    <option <?php if($yer=='2019-20') { echo 'selected'; } ?> value="2019-20">2019-20</option>
   <option <?php if($yer=='2020-21') { echo 'selected'; } ?> value="2020-21">2020-21</option>
    <option <?php if($yer=='2021-22') { echo 'selected'; } ?> value="2021-22">2021-22</option>
	<option <?php if($yer=='2022-23') { echo 'selected'; } ?> value="2022-23">2022-23</option>
	<option <?php if($yer=='2023-24') { echo 'selected'; } ?> value="2023-24">2023-24</option>
    </select>
</div>

				</div>
				</div>
				</div>
               </div>
                <div class="panel-body">
                    <div class="table-info">    
                   
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                    <th>#</th>
                                    <th>Academic Year</th>
									<th>Vacation Type</th>									
									<th>Slot</th>
                                    <th>Date</th>									
                                    <th>Action</th>									
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php
							date_default_timezone_set("Asia/Kolkata");
							  
							if(!empty($vac_leave)){
                            $j=1; 
//$rom = array('I','II','III','IV');							
                            for($i=0;$i<count($vac_leave);$i++)
                            {
                                
							?>
														
                            <tr>
							<td><?=$j?></td> 
                                 
                                <td><?=$vac_leave[$i]['academic_year'];?></td> 
								<td><?=$vac_leave[$i]['vacation_type'];?></td> 
								<td><?php echo $vac_leave[$i]['slot_type'];?></td> 
								<td><?=date('d-m-Y',strtotime($vac_leave[$i]['from_date']))." to ".date('d-m-Y',strtotime($vac_leave[$i]['to_date']));?></td> 
								
							     <td><a href="<?=base_url($currentModule.'/vacation_leave_edit/'.$vac_leave[$i]['vid'].'')?>" title="Edit"><i class="fa fa-edit"></i></a>
								 <a href="" onclick="delete_confirm(<?php echo $vac_leave[$i]['vid']; ?>)" title="Delete"><i class="fa fa-trash-o"></i></a>
                                </td>
                            </tr>
                            <?php
                            $j++;
                            }}else{
								echo"<tr><td colspan='19'><label style='color:red'>Sorry No record.</label></td></tr>";
							}
                            ?>                            
                        </tbody>
                    </table>                    
                    <?php //} ?>
                </div>
                </div>
            </div>
            </div>    
        </div>
    </div>
</div>
<script>
function delete_confirm(vid){
	var r = confirm("Delete this vacation slot ?");
if (r == true) {
      jQuery.ajax({
                type: "POST",
                url: base_url+"leave/vacation_leave_delete/"+vid,              
                success: function(data){
                 alert('Deleted successfully.');            
         window.loction = base_url+"leave/vacation_leave_list" ;
                }   
            });
}

}             
  function search_vacation_leves(vlev){
	   
          url= "<?php echo base_url().$currentModule; ?>/vacation_leave_list/"+vlev;
          window.location = url;
}

   
</script>