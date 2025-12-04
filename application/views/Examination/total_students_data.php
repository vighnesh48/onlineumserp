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
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne1" aria-expanded="true" aria-controls="collapseOne1">Total Student Count:
                                        </a>
                                    </h4>
                                </div>
                                    <div id="collapseOne1" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                        <div class="panel-body table-reponsive" style="width:100%;overflow:scroll;height:700px;padding:0px;">

<table id="example" class="table table-bordered table-hover" width="500%">
<thead class="panel-primary">
	<tr>
		<th>Sr.No</th>
		<th>School name</th>
		<th>Stream Name</th>
		<th>Semester</th>
		<th>Total students </th>
		<th>Exam Applied Count </th>
		<th>Pending Count </th>
	</tr>
	</thead>
	<tbody>
	<?php $x=1; if(! empty($summary_list)){ 
		for($i=0;$i<count($summary_list);$i++){	?>	 
	<tr>

		<th><?php echo $x; 
		$exam_data=explode('-', $exam_session);
		
		?></th>
		<th> <?=$summary_list[$i]['school_short_name']; ?> </th>
		<th><?=$summary_list[$i]['stream_name']; ?></th>
		<th><?=$summary_list[$i]['current_semester']; ?></th>
		<th><a target="_blank" href='<?php echo base_url($currentModule .'/details_of_students/'.$exam_id.'/'.$exam_data[1].'/'.$summary_list[$i]['current_semester'].'/'.$summary_list[$i]['admission_stream'].'/0/'.$type); ?>'><?=$summary_list[$i]['total_students']; ?></a> </th>
		<th><a target="_blank" href='<?php echo base_url($currentModule .'/details_of_students/'.$exam_id.'/'.$exam_data[1].'/'.$summary_list[$i]['current_semester'].'/'.$summary_list[$i]['admission_stream'].'/1/'.$type); ?>'><?=$summary_list[$i]['applied']; ?></a>  </th>
		<th><a target="_blank" href='<?php echo base_url($currentModule .'/details_of_students/'.$exam_id.'/'.$exam_data[1].'/'.$summary_list[$i]['current_semester'].'/'.$summary_list[$i]['admission_stream'].'/2/'.$type); ?>'><?=$summary_list[$i]['total_students']-$summary_list[$i]['applied']; ?></a>  </th>
	</tr>
	
	
		
	<?php $x++;
} } ?>
	</tbody>
</table>

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


