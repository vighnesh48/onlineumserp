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
		<th>Type</th>
		<th>Sem</th>
		<th>Exam session</th>
		<th>CIA</th>
		<th>TH</th>
		<th>PR</th>
		<th>Att Marks</th>
		<th>TH Max</th>
		<th>TH Min</th>
		<th>INT Max</th>
		<th>INT Min</th>
		<th>PR Max</th>
		<th>PR Min</th>
		<th>Sub Max</th>
		<th>Sub Min</th>
		

		
	</tr>
	</thead>
	<tbody>
	<?php $x=1; if(! empty($summary_list)){ 
		for($i=0;$i<count($summary_list);$i++){	?>	 
	<tr <?php if($summary_list[$i]['subject_component']=='EM'){?> style="background-color:#98f388;"<?php }?>>

		<td><?php echo $x; 
		$exam_data=explode('-', $exam_session);
		
		?></td>
		<td> <?=$summary_list[$i]['subject_code']; ?> <?=$summary_list[$i]['subject_id']; ?></td>
		<td><?=$summary_list[$i]['subject_name']; ?></td>
		<td><?=$summary_list[$i]['subject_component']; ?></td>
		<td><?=$summary_list[$i]['semester']; ?></td>
		<td><?=$summary_list[$i]['exam_month'].'-'.$summary_list[$i]['exam_year']; ?></td>
		<td><?=$summary_list[$i]['cia_marks']; ?></td>
		<td><?=$summary_list[$i]['marks']; ?></td>
		<td><?=$summary_list[$i]['pr_marks']; ?></td>
		<td><?=$summary_list[$i]['attendance_marks']; ?></td>
		<td><?=$summary_list[$i]['theory_max']; ?></td>
		<td><?=$summary_list[$i]['theory_min_for_pass']; ?></td>
		<td><?=$summary_list[$i]['internal_max']; ?></td>
		<td><?=$summary_list[$i]['internal_min_for_pass']; ?></td>
		<td><?=$summary_list[$i]['practical_max']; ?></td>
		<td><?=$summary_list[$i]['practical_min']; ?></td>
		<td><?=$summary_list[$i]['sub_max']; ?></td>
		<td><?=$summary_list[$i]['sub_min']; ?></td>
		
				
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


