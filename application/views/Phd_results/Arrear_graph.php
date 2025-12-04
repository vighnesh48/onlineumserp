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
//exit;https://html2canvas.hertzen.com/dist/html2canvas.js

//exit;
?>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.0.272/jspdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/canvg/1.4/rgbcolor.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/stackblur-canvas/1.4.1/stackblur.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/canvg/1.4/canvg.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.debug.js"></script>
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
 /*$(function () {
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
      },*
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
	*/


</script>
<script type="text/javascript">
	init.push(function () {
		// Javascript code here
		jQuery("#hero-bar").css("height","500")
//(function() {
  var $, MyMorris;

  MyMorris = window.MyMorris = {};
  $ = jQuery;

  MyMorris = Object.create(Morris);

  MyMorris.Bar.prototype.defaults["labelTop"] = false;

  MyMorris.Bar.prototype.drawLabelTop = function(xPos, yPos, text) {
    var label;
    return label = this.raphael.text(xPos, yPos, text).attr('font-size', this.options.gridTextSize).attr('font-family', this.options.gridTextFamily).attr('font-weight', this.options.gridTextWeight).attr('fill', this.options.gridTextColor);
  };

  MyMorris.Bar.prototype.drawSeries = function() {
    var barWidth, bottom, groupWidth, idx, lastTop, left, leftPadding, numBars, row, sidx, size, spaceLeft, top, ypos, zeroPos;
    groupWidth = this.width / this.options.data.length;
    numBars = this.options.stacked ? 1 : this.options.ykeys.length;
    barWidth = (groupWidth * this.options.barSizeRatio - this.options.barGap * (numBars - 1)) / numBars;
    if (this.options.barSize) {
      barWidth = Math.min(barWidth, this.options.barSize);
    }
    spaceLeft = groupWidth - barWidth * numBars - this.options.barGap * (numBars - 1);
    leftPadding = spaceLeft / 2;
    zeroPos = this.ymin <= 0 && this.ymax >= 0 ? this.transY(0) : null;
    return this.bars = (function() {
      var _i, _len, _ref, _results;
      _ref = this.data;
      _results = [];
      for (idx = _i = 0, _len = _ref.length; _i < _len; idx = ++_i) {
        row = _ref[idx];
        lastTop = 0;
        _results.push((function() {
          var _j, _len1, _ref1, _results1;
          _ref1 = row._y;
          _results1 = [];
          for (sidx = _j = 0, _len1 = _ref1.length; _j < _len1; sidx = ++_j) {
            ypos = _ref1[sidx];
            if (ypos !== null) {
              if (zeroPos) {
                top = Math.min(ypos, zeroPos);
                bottom = Math.max(ypos, zeroPos);
              } else {
                top = ypos;
                bottom = this.bottom;
              }
              left = this.left + idx * groupWidth + leftPadding;
              if (!this.options.stacked) {
                left += sidx * (barWidth + this.options.barGap);
              }
              size = bottom - top;
              if (this.options.verticalGridCondition && this.options.verticalGridCondition(row.x)) {
                this.drawBar(this.left + idx * groupWidth, this.top, groupWidth, Math.abs(this.top - this.bottom), this.options.verticalGridColor, this.options.verticalGridOpacity, this.options.barRadius, row.y[sidx]);
              }
              if (this.options.stacked) {
                top -= lastTop;
              }
              this.drawBar(left, top, barWidth, size, this.colorFor(row, sidx, 'bar'), this.options.barOpacity, this.options.barRadius);
              _results1.push(lastTop += size);

              if (this.options.labelTop && !this.options.stacked) {
                label = this.drawLabelTop((left + (barWidth / 2)), top - 10, row.y[sidx]);
                textBox = label.getBBox();
                _results.push(textBox);
              }
            } else {
              _results1.push(null);
            }
          }
          return _results1;
        }).call(this));
      }
      return _results;
    }).call(this);
  };
//}).call(this);

	})
	//window.PixelAdmin.start(init);
</script>
<!-- 7. $MORRISJS_BARS =============================================================================

				Morris.js Bars
-->
				<!-- Javascript -->
				<script type="text/javascript">
				
					init.push(function () {
						Morris.Bar({
							element: 'hero-bar',
							data:  <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>,
							xkey: 'label',
							ykeys: 'y',
							labels: 'label',
							labelTop: true,

							barRatio:10,
							xLabelAngle:40,
							hideHover: 'auto',
							barColors: PixelAdmin.settings.consts.COLORS,
							gridLineColor: '#cfcfcf',
							resize: false,
						});
						//var canvas = $("#hero-bar .canvasjs-chart-canvas").get(0);
//var dataURL = canvas.toDataURL();

					});
					
					
/*$("#exportButton").click(function(){
    var pdf = new jsPDF();
    pdf.addImage(dataURL, 'JPEG', 0, 0);
    pdf.save("download.pdf");
});*/ 



function save() {
	
	/*html2canvas(document.querySelector("#hero-bar")).then(canvas => {
    document.body.appendChild(canvas)
	 //onrendered: function(canvas) {
      var img = canvas.toDataURL();
	  alert(img);
      var doc = new jsPDF();
      doc.addImage(img, 10, 10);
      doc.save('test.pdf');
    //   }
      });*/
	  
	   //alert();  

     
     /*   var svg = $("#hero-bar").html();        
        canvg(document.getElementById('hero-bar'), svg.split("<div")[0]);
        html2canvas($("#canvas"), {
            onrendered: function(canvas) {         
                var imgData = canvas.toDataURL(
                    'image/png');              
                var doc = new jsPDF('p', 'mm');
                doc.addImage(imgData, 'PNG', 10, 10);
                doc.save('sample-file.pdf'); 
                console.log(imgData);
            }
        });*/
        
        
         var svg = $("#hero-bar").html();        
        canvg(document.getElementById('canvas'), svg.split("<div")[0]);
        html2canvas($("#canvas"), {
            onrendered: function(canvas) {         
                var imgData = canvas.toDataURL(
                    'image/png');              
                var doc = new jsPDF('l', 'mm');
                doc.addImage(imgData, 'PNG', -35, 5);
               // doc.rotate(90); 
               // doc.addImage('imageData :' imgData,'PNG','angle :' -20,'x :' 10,'y :' 78,'w :' 45,'h :' 58);
                doc.save('sample-file.pdf'); 

       /*   var doc = new jsPDF({
  orientation: 'landscape',
  unit: 'in',
  format: [4, 2]
})
 
//doc.text('Hello world!', 1, 1)
doc.save('two-by-four.pdf')*/

                console.log(imgData);
            }
        });





		/*var svg = $("#hero-bar").html();        
       // canvas(document.getElementById('canvas'), svg.split("<div")[0]);
        html2canvas($("#canvas"), {
            onrendered: function(canvas) {         
                var imgData = canvas.toDataURL(
                    'image/png');              
                /*var doc = new jsPDF('p', 'mm');
                doc.addImage(imgData, 'PNG', 10, 10);
                doc.save('sample-file.pdf'); 
                console.log(imgData);
                $("#imgBinary").html(imgData);
            }
        });*/
	  
	  
	  
      /*html2canvas(document.getElementById('hero-bar'), {
      onrendered: function(canvas) {
      var img = canvas.toDataURL();
	  alert(img);
      var doc = new jsPDF();
      doc.addImage(img, 10, 10);
      doc.save('test.pdf');
        }
     });*/
	/* var canvas = $("#hero-bar .canvasjs-chart-canvas").get(0);
    var dataURL = canvas.toDataURL();
	   var pdf = new jsPDF();
    pdf.addImage(dataURL, 'JPEG', 0, 0);
    pdf.save("download.pdf");*/
   }


   (function() {
   
   $('#convert').click(function() { 
  
        
        
        
});});

				</script>
<style>
#hero-bar > svg{
    height: 800px !important;
    width: 1072px !important;
}svg:not(:root) { height: 800px !important; }


</style>
<!--<div class="chartWrapper" style="height: 380px; width: 900px; overflow-x:auto;position:relative;">
  <div class="chartAreaWrapper">-->
    <!--<div id="chartContainer" style="height: 160px; width: 100%;"></div>-->
    <div class="row">
     <div class="col-md-12">
<div class="panel" style="margin-bottom:10px;">
					<div class="panel-heading">
						<span class="panel-title">PASS AND FAIL DETAILS</span>
					</div>
					<div class="panel-body">
					<!--	<div class="note note-info">More info and examples at </div>-->

						<div class="graph-container">
							<div id="hero-bar" class="graph" style="margin-bottom:10px;"></div>
						</div>
					</div>
                    
				</div>
     </div>
     </div><div class="row">
     <div class="col-md-3"></div>
     <div class="col-md-3">
     <div id="imgBinary">

</div><!--onclick="save()"-->

    <button id="convert" type="button" onclick="save()">Export as PDF</button></div></div>

    <canvas id="canvas"></canvas>
  <!--</div>
  <canvas id="overlayedAxis"></canvas>
</div>-->