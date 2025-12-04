<script>
$(document).ready(function() {

  $(".toggle-accordion").on("click", function() {
    var accordionId = $(this).attr("accordion-id"),
      numPanelOpen = $(accordionId + ' .collapse.in').length;
    
    $(this).toggleClass("active");

    if (numPanelOpen == 0) {
      openAllPanels(accordionId);
    } else {
      closeAllPanels(accordionId);
    }
  })

  openAllPanels = function(aId) {
    console.log("setAllPanelOpen");
    $(aId + ' .panel-collapse:not(".in")').collapse('show');
  }
  closeAllPanels = function(aId) {
    console.log("setAllPanelclose");
    $(aId + ' .panel-collapse.in').collapse('hide');
  }
     
});
</script>
<style>
.table{width:100%;} 
table{max-width: 100%;}
</style>
    <div class="page-header">
        <div class="row">
             <div class="col-sm-12">
                <div class="fancy-collapse-panel">
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                        <div class="panel panel-default">
                             <div class="table-responsive">
                                <div class="panel-heading" role="tab" id="headingOne">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne1" aria-expanded="true" aria-controls="collapseOne1"><?=$summary_list[0]['student_name']?>
                                        </a>
                                    </h4>
                                </div>
                                    <div id="collapseOne1" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                        <div class="panel-body table-reponsive" style="width:100%;overflow:scroll;height:700px;padding:0px;">

<table id="example" class="table table-bordered table-hover" width="500%">
<thead class="panel-primary">
	<tr>
		<th>Sr.No</th>
		<th>Subject code</th>
		<th>Subject name</th>
		<th>Semester</th>
		<th>Exam session</th>
		<th>Grdae</th>
		<th>Passed</th>
		<th>no_of_attempt</th>
		
	</tr>
	</thead>
	<tbody>
	<?php $x=1; if(! empty($summary_list)){ 
		for($i=0;$i<count($summary_list);$i++){	
		if ($summary_list[$i]['passed'] == 'Y') {
            $passCount++;
        } elseif ($summary_list[$i]['passed'] == 'N') {
            $failCount++;
        }
		?>	 
	<tr <?php if($summary_list[$i]['passed']=='N'){?> style="background-color:#f19b9b;"<?php }?>>

		<th><?php echo $x; 
		$exam_data=explode('-', $exam_session);
		
		?></th>
		<th> <?=$summary_list[$i]['subject_code']; ?> </th>
		<th><?=$summary_list[$i]['subject_name']; ?></th>
		<th><?=$summary_list[$i]['semester']; ?></th>
		<th><?=$summary_list[$i]['exam_month'].'-'.$summary_list[$i]['exam_year']; ?></th>
		<th><?=$summary_list[$i]['grade']; ?></th>
		<th><?=$summary_list[$i]['passed']; ?></th>
		<th><?=$summary_list[$i]['no_of_attempt']; ?></th>
		
	</tr>
	
	
		
	<?php $x++;
} } ?>
	</tbody>
</table>
<!-- Footer totals -->
<div class="row col-md-12" style="text-align:left; margin-top:15px;font-size:16px; font-weight:bold;">
    <div class="col-md-4"> Total Subjects : <?= $passCount + $failCount; ?> </div>
    <div class="col-md-4"> Total Passed Subjects : <?= $passCount; ?> </div>
    <div class="col-md-4"> Total Failed Subjects : <?= $failCount; ?> </div>
</div>
        	                            </div>
                                    </div>				
                            </div>
                        </div>
                    </div>
                </div>
             </div>   
            </div>
        </div>
    </div>
            
   
<style>
tr.collapse.in {
  display:table-row;
}

/* GENERAL STYLES */
body {
    
    font-family: Verdana;
}

/* FANCY COLLAPSE PANEL STYLES */
.fancy-collapse-panel .panel-default > .panel-heading {
padding: 0;

}
.fancy-collapse-panel .panel-heading a {
padding: 12px 35px 12px 15px;
display: inline-block;
width: 100%;
background-color:#136fab;
color: #ffffff;
font-size: 16px;
font-weight: 200;
position: relative;
text-decoration: none;

}
.fancy-collapse-panel .panel-heading a:after {
font-family: "FontAwesome";
content: "\f147";
position: absolute;
right: 20px;
font-size: 20px;
font-weight: 400;
top: 50%;
line-height: 1;
margin-top: -10px;

}

.fancy-collapse-panel .panel-heading a.collapsed:after {
content: "\f196";
}


</style>


