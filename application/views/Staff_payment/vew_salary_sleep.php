<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>


<style>
.attexl table{
	 border: 1px solid black;
}
.attexl table th{
 border: 1px solid black;
    padding: 5px;
    background-color:grey;
    color: white;
}
.attexl table td{
	 border: 1px solid black;
    padding: 5px;
}

th, td { white-space: nowrap;  }
td>input { white-space: nowrap;width:100%;padding:2px 3px }
element {
    width: 19.2333px;
}
.table.table-bordered thead > tr > th {
    border-bottom: 0;
        border-bottom-color: currentcolor;
}
table.dataTable thead th{padding: 5px 30px;}
.cal-table tr th{padding:4px 20px!important;}
</style>

<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Staff Payment</a></li>
        <li class="active"><a href="#">Staff Salary Details </a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Staff Salary Details </h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                </div>
            </div>
        </div>
      
        <div class="row ">
            <div class="col-sm-12">                
                        <div class="table-info">	 
									 <div class="panel panel-warning">
              <div class="panel-heading ">
              <div class="row">
<div class="col-md-6 text-left">
              <strong>Staff Salary <?php //if(isset($fordepart) && isset($forschool)){echo $fordepart.'Department['.$forschool."]"; } else{ unset($forschool);unset($fordepart);echo "All Deartment and All School";}?> For 
								<?php echo date("F", mktime(0, 0, 0, $month_name, 10))." ".$year_name;
                               /*  $d = date_parse_from_format("Y-m-d", $inc_dt);
								//print_r($d);
								$msearch=$d["month"];
							$month_name = date("F", mktime(0, 0, 0, $msearch, 10));
                                $ysearch=$d["year"];
								 */?>
								</strong>
</div>
<div class="col-md-6 text-left">
								<label class="col-md-5">Select Month And Year</label>
								 <form id="form" name="form" action="<?=base_url($currentModule.'/download_salary_slip')?>" method="POST" >
							
								  <input id="dob-datepicker" required class="date-picker col-md-4" name="attend_date" value="<?=$attend_date?>" placeholder="Month & Year" type="text">
                        
                          <input type="submit" class="btn btn-primary btn-xs col-md-2 pull-right" name="submit" value="View">
                        </form>            
</div>
</div>
								</div>
								                        
                        </div>
                    </div>
                </div>
            </div>    
        </div>
   

<script type="text/javascript">
$(document).ready(function(){
	 
	$('#dob-datepicker').datepicker( {format: "yyyy-m",startView: "months",minViewMode: "months",autoclose:true});
	var content = '<tr>'+$('#eduDetTable tbody tr').html()+'</tr>';
	$("#eduDetTable").on("click","input[name='addMore']", function(e){	
	//$("input[name='addMore']").on('click',function(){		
		//var content = $(this).parent().parent('tr').clone('true');
		$(this).parent().parent('tr').after(content);		
	});
	$("#eduDetTable").on("click","input[name='remove']", function(e){	
	//$("input[name='remove']").on('click',function(){
		var rowCount = $('#eduDetTable tbody tr').length;
		if(rowCount>1){
			$(this).parent().parent('tr').remove();
		}
	});	
	
	 $("#btnExport").click(function(e) {
		    window.open('data:application/vnd.ms-excel,' + $('#dvData').html());
    e.preventDefault();
});   
});
</script>


