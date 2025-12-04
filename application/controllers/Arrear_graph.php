<?php
//echo '<pre>';print_r($graph[0]);
//exit;

//$pass=1;
 function array_interlace() {
    $args = func_get_args();
    $total = count($args);

    if($total < 2) {
        return FALSE;
    }

    $i = 0;
    $j = 0;
    $arr = array();

    foreach($args as $arg) {
        foreach($arg as $v) {
            $arr[$j] = $v;
            $j += $total;
        }

        $i++;
        $j = $i;
    }

    ksort($arr);
    return array_values($arr);
}
 $total=count($graph[1]);
 $total_student=count($graph[0]);
//exit;
//$total_student=0;
foreach($graph[1] as $valuee){
	if($valuee['chec']==0){
		$pass +=1;
		}else{
		//$fail+=$value['chec'];
			}
}
$fail=$total -$pass;

$pass_percnts=($pass/$total) * 100;
$fail_percnts=($fail/$total) * 100;
foreach($graph[0] as $value){
	//$total_student+=$value['Total_student'];
}
$newsub='';
$lastcount=count($graph[0]);
$countnew=0;
$keynew=5;
$price = array_column($graph[0], 'failed');

array_multisort($price, SORT, $graph[0]);

//print_r($graph[0]);

//exit;

foreach($graph[0] as $faildlist){
	$countnew++;
	/*if($countnew==$lastcount){$newsub .='array("y" =>'.$faildlist['failed'].', "label" =>'.$faildlist['subject_code_master'].')';}else{
        $newsub .='array("y" =>'.$faildlist['failed'].', "label" =>'.$faildlist['subject_code_master'].'),';
	}*/
	
	if($faildlist['failed']!=0){
	//	echo $faildlist['failed'];
		//if($countnew<15)
		{
	$newarray[$keynew]=array("y" => $faildlist['newd'], "label" => $faildlist['failed']);
	$keynew++;
		}
}
		}
	//echo '<pre>';
//print_r($newarray);	
//exit;
//echo '<br>';//echo '</pre>';
//exit;
//$price = array_column($newarray, 'y');

//array_multisort($price, SORT_DESC, $newarray);

//print_r($newarray);
//exit;
    $newd = array(
        array("y" => $total, "label" => "Total Appeared"),
        array("y" => $pass, "label" => "Total Cleared"),
        array("y" => number_format($pass_percnts,2), "label" => "Overall Pass%"),
        array("y" => $fail, "label" => "Total Failures"),
		array("y" => number_format($fail_percnts, 2), "label" => "Overall Failures%"),
		
       /* array("y" => 6, "label" => "Course2"),
        array("y" => 7, "label" => "Course3"),
        array("y" => 5, "label" => "Course4"),
        array("y" => 4, "label" => "Course5"),
		array("y" => 4, "label" => "Course6"),
		array("y" => 4, "label" => "Course7"),
		array("y" => 4, "label" => "Course8"),
		array("y" => 4, "label" => "Course9"),
	    array("y" => 4, "label" => "Course10"),*/
    );
	$dataPoints= $newd + $newarray;
	
//	array_merge_recursive($dataPoints,$newarray);
	//echo '<pre>';print_r($newd);
//exit;

//exit;
?>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<script type="text/javascript">
function copyAxis(containerId, destId){
  var chartCanvas = $("#chartContainer .canvasjs-chart-canvas").get(0);  
  var destCtx = $("#" + destId).get(0).getContext("2d");
  
  var axisWidth = 30;
  var axisHeight = 335;
  
  destCtx.canvas.width = axisWidth;
  destCtx.canvas.height = axisHeight;

  destCtx.drawImage(chartCanvas, 0, 0, axisWidth, axisHeight, 0, 0, axisWidth, axisHeight);
}
 $(function () {
        var chart = new CanvasJS.Chart("chartContainer", {
            theme: "theme1",
            animationEnabled: false,
			 zoomEnabled: false,
			 showInLegend: true,
            title: {
                text: "PASS AND FAIL DETAILS"
            },
			
			/* legend: {
        horizontalAlign: "right",
        verticalAlign: "center"
      },
      axisY:{
        includeZero: false,
        tickLength: 10
      },
      axisX:{
        minimum: 0,
        maximum: 500
      },*/
            data: [
            {
                type: "column",      
				indexLabel: "{y}",          
                dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
            }
			
            ]
        });
        //chart.render();
		//copyAxis("chartContainer", "overlayedAxis");
    });
	


</script>
<script type="text/javascript">
	init.push(function () {
		// Javascript code here
	})
	window.PixelAdmin.start(init);
</script>
<!-- 7. $MORRISJS_BARS =============================================================================

				Morris.js Bars
-->
				<!-- Javascript -->
				<script>
					init.push(function () {
						Morris.Bar({
							element: 'hero-bar',
							data:  <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>,
							xkey: 'label',
							ykeys: 'y',
							labels: ['No Of Admissions'],
							barRatio:0.4,
							xLabelAngle:40,
							hideHover: 'auto',
							barColors: PixelAdmin.settings.consts.COLORS,
							gridLineColor: '#cfcfcf',
							resize: false,
						});
					});
				</script>
<div style="height: 300px; width: 100%;"></div>
<!--<div class="chartWrapper" style="height: 380px; width: 900px; overflow-x:auto;position:relative;">
  <div class="chartAreaWrapper">-->
    <div id="chartContainer" style="height: 360px; width: 100%;"></div>
    <div class="row" style="margin-bottom:20px;">
     <div class="col-md-12">
<div class="panel">
					<div class="panel-heading">
						<span class="panel-title">Course wise Admissions</span>
					</div>
					<div class="panel-body">
					<!--	<div class="note note-info">More info and examples at </div>-->

						<div class="graph-container">
							<div id="hero-bar" class="graph"></div>
						</div>
					</div>
				</div>
     </div>
     </div>
  <!--</div>
  <canvas id="overlayedAxis"></canvas>
</div>-->