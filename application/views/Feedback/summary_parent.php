<style>
#chartdiv {
	width		: 100%;
	height		: 200px;
	font-size	: 11px;
}						
</style>

<!-- Resources -->
<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
<script src="https://www.amcharts.com/lib/3/funnel.js"></script>
<script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
<link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
<script src="https://www.amcharts.com/lib/3/themes/none.js"></script>

<!-- Chart code -->
<script>

var chart = AmCharts.makeChart( "chartdiv", {
  "type": "funnel",
  "theme": "none",
  "dataProvider": [ {
    "title": "Excellent",
    "value": 12
  }, {
    "title": "Good",
    "value": 8
  }, {
    "title": "Average",
    "value": 7
  }, {
    "title": "poor",
    "value": 2
  }, {
    "title": "NA",
    "value": 3
  }],
  "balloon": {
    "fixedPosition": true
  },
  "valueField": "value",
  "titleField": "title",
  "marginRight": 200,
  "marginLeft": 200,
  "startX": -500,
  "rotate": true,
  "labelPosition": "right",
  "balloonText": "[[title]]: [[value]] [[description]]",
  "export": {
    "enabled": true
  }
} );
</script>
<?php

$faculty_advisor=array();
$academic=[];
$transport=[];
$hostel=[];
$canteen=[];
$admin_supportr=[];
foreach($summary as $row){
  
    if($row['facility']='faculty_advisor'){
         $faculty_advisor[]=$row;
    
  }
}




?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">feedback</a></li>
        <li class="active"><a href="#"><?=$ed?> Summary</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-comments fa-2x"></i>&nbsp;&nbsp;<?=$ed?> Parent Feedback Summary</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                </div>
            </div>
        </div>
       
        <div class="row ">
            <div class="col-sm-12">&nbsp;</div>
        </div>
        <div class="row ">
            <div class="col-sm-12">
 
                <div class="panel">
                    <div class="panel-heading">
                         <div class="row">
                             <div class="col-sm-10">
                                 <span class="panel-title"><i class="fa fa-file fa-2x"></i> Feedback Summary Details</span>
                            </div>
                           <div class="col-sm-2">
                                 <a href="<?=base_url($currentModule.'/excel_parent_feedback')?>" class="btn btn-primary form-control pull-right" id="button_excel" type="button">Export Excel</a>
                            </div>
                         </div>
                            
                    </div>
                    <div class="panel-body">
                        <div class="row">
                               <table class="table table-bordered  table-responsive" style="margin:18px; font-family:cambria;font-size:14px;">
                    <thead>
                        <tr>
                            <th width="5%">S.No</th>
                             <th width="20%">Facilities</th>
                              <th width="75%" colsapn="5"></th>
                               
                        </tr>
                    </thead>
                    <tbody>
                       <tr>
                            <td>1</td> 
                            <td><i class="fa fa-users "></i> &nbsp;Faculty Advisor</td>
                           
                             <td colspan="5">
                                <div class="col-xs-12">
                                     <div class="form-group">
                            		<div class="col-sm-11 col-md-11">
                            			<div class="graph-container">
							              <div id="piechart"></div>
					                   	</div>
                            		</div>
                            	</div>
    </div>
                               </td>
                        </tr>
                       <tr>
                            <td>2</td>
                            <td><i class="fa fa-check-square-o" aria-hidden="true"></i> &nbsp;Academic</td>
                             <td colspan="5">
                                <div class="col-xs-12">
                                     <div class="form-group">
                            		<div class="col-sm-12 col-md-12">
                            			<div class="graph-container">
						                <div id="chartdiv"></div>	
					                	</div>
                            		</div>
                            	</div>
    </div>
                               </td>
                        </tr>
                       <tr>
                            <td>3</td>
                            <td><i class="fa fa-bed" aria-hidden="true"></i>&nbsp;Hostel</td>
                             <td colspan="5">
                                <div class="col-xs-12">
                                     <div class="form-group">
                            		<div class="col-sm-12 col-md-12">
                            		<div id="piechart"></div>
                            		</div>
                            	</div>
    </div>
                               </td>
                        </tr>
                       <tr>
                            <td>4</td>
                            <td><i class="fa fa-cutlery" aria-hidden="true"></i>&nbsp;Canteen</td>
                             <td colspan="5">
                                <div class="col-xs-12">
                                     <div class="form-group">
                            		<div class="col-sm-12 col-md-12">
                            			<div id="piechart"></div>
                            		</div>
                            	</div>
    </div>
                               </td>
                        </tr>
                       <tr>
                            <td>5</td>
                            <td><i class="fa fa-bus"></i>&nbsp;Transport</td>
                             <td colspan="5">
                                <div class="col-xs-12">
                                     <div class="form-group">
                            		<div class="col-sm-12 col-md-12">
                            			<div id="piechart"></div>
                            		</div>
                            	</div>
    </div>
                               </td>
                        </tr>
                       <tr>
                            <td>6</td>
                            <td>Admin Support</td>
                             <td colspan="5">
                                <div class="col-xs-12">
                                     <div class="form-group">
                            		<div class="col-sm-12 col-md-12">
                            			<div id="piechart"></div>
                            		</div>
                            	</div>
    </div>
                               </td>
                        </tr>
                       
                    </tbody>
                    </table>
                          <?php
                        var_dump($faculty_advisor);
                          ?>
                            
                        </div>
                        <div class="panel-footer">
                    <center><button type="submit" class="btn btn-primary btn-md" id="formbtn">
                        Export Excel</button></center>
                   </div>
            </div>    
        </div>

		       
    
    
    </div>
</div>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
// Load google charts
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

// Draw the chart and set the chart values
function drawChart() {
  var data = google.visualization.arrayToDataTable([
  ['Excellent', '12'],
  ['Excellent', 8],
  ['Good', 2],
  ['Average', 4],
  ['Poor', 2],
  ['NA', 8]
]);

  // Optional; add a title and set the width and height of the chart
  var options = { 'width':500, 'height':400};

  // Display the chart inside the <div> element with id="piechart"
  var chart = new google.visualization.PieChart(document.getElementById('piechart'));
  chart.draw(data, options);
}
</script>
