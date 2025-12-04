<script src="<?php base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?php site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?php site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?php site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/pdfmake-0.1.27/dt-1.10.15/b-1.3.1/b-colvis-1.3.1/b-html5-1.3.1/r-2.1.1/datatables.min.css"/>
 
<script type="text/javascript" src="https://cdn.datatables.net/v/bs/pdfmake-0.1.27/dt-1.10.15/b-1.3.1/b-colvis-1.3.1/b-html5-1.3.1/r-2.1.1/datatables.min.js"></script>
<script type="text/javascript" src="https:////cdn.datatables.net/buttons/1.2.1/js/buttons.print.min.js"></script>
 <script type="text/javascript">
$(document).ready(function(){
	$('#dob-datepicker').datepicker( {format: "yyyy-m",startView: "months",minViewMode: "months",autoclose:true});
	 $('#example').DataTable({
            
            dom: 'Bfrtip',
             buttons: [
            {
                extend: 'pdfHtml5',
                orientation: 'landscape',
				 customize: function ( doc ) {
                // Splice the image in after the header, but before the table
				  doc.content.splice(1, 0, {
                margin: [10, -80, 0, 0],
                fit: [100, 100],
                image: "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAFAAAABPCAYAAAB8kULjAAAABGdBTUEAALGPC/xhBQAAAAlwSFlzAAAOwgAADsIBFShKgAAAIL1JREFUeF7t3Xm4ndP1B3AtiaExC0XMUwiRkNYQMxVDEEOQoFRiSoSaWokkaAxFGjHVlIYSQoWaK2KoeWpRpaXGFjVEBEUMYf/ezzr2zXvPvefek0H7z28/z3ncnHfae+01fNd3rfeYK/3/mC0JzDVbV8/GxV9/ndLnn3+epkyZkh544P503nnnpsMPH5h23HHHtN56XdLyy3dISyyxWHwWX3zRtOSSS6TVV181de++cdpzz97phBOGpKuuGpf+9re/pU8++TR9+eWXszGbWb/0vyrArwup/ec//0kvvPBCuvjii1PfvnulNdfsmJZbbtm04oorpFVWWSmtttqqaY01VksdO65eHFsjrbVWx/j423eEuNpqq6SVV14xrbDCciHojTbaIB199FHptttuTe+8806aNm3arEtkJq/8rwhw+vTp6b333ku///3vC6H1SSuttEJaZpnvhwAIomvXdUOrhg0bln7zmzHp9ttvS4888nD6y1+eTv/4xwvp+ef/nv785z+n++67L02YcF0655xz0pFHDkrbbrtNCHXFFZePTVhmmaVCe4cOPSE9+eSf08cffzyT4pj5079VAdK4d999N11++WVp8803Td///pJp2WWXDg3abrse6cwzzwhBvf/+++mzzz4LM/zqq69aWcXXyYZ88cUX6dNPP03/+te/io25If30p0emH/xg/RDm0ksvFZrZv3+/wj088K0K8lsT4EcffZRuvPHGtNVWWxb+a/EQXNeuXdKQIcenJ554IgTWurDq1wjCf++9KemGG65PffrsHaa+1FLtQzMHDhyQ/vrXv4bQ5/SY4wKkHSbbr1+/0DjasOGGP0xnnXVWeuONN0J76hkWy5fRMh8Cn5lrH3nkkXTooYeET11ssUXCj55//rmFtk+p5/F1nzNHBfjJJ5+kq6++KnzaIossFI5/2LAT0uuvv56Yc63BV7377jsRkbNWXnvtNem0005Nv/jFyWnEiF+k0aNHp0cffSRuQaA2I5t+rfsSOL/Zu/ceqUOHZQpBLpz23nvP9NRTT80x7Z9jAhT9TjhhcJiNzx577F74t0cKwTXv02jUa6+9lm655ZZ0/PE/L3zk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"		});
               doc.content.splice(0, 1, {
                            text: [
							           { text: 'Sandip University \n',bold:true,fontSize:17 },
                                       { text: 'Trimbak Road, A/p - Mahiravani, Nashik – 422 213 \n',bold:true,fontSize:12 },
									   { text: 'Website : http://www.sandipuniversity.com I Email :info@sandipuniversity.com \n',bold:true,fontSize:12 },
									   { text: 'Ph: (02594) 222 541 Fax: (02594) 222 555',bold:true,fontSize:12 }
									   

                            ],
                            margin: [0, 0, 0, 2],
                            alignment: 'center'
                        });
						doc.content.splice(2, 0, {
                margin: [0, 0, 0, 15],
                fit: [930, 800],
                image: "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAADKUAAAAKCAYAAADfewwmAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyJpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoV2luZG93cykiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6MzI5NzZEQTUzMTg3MTFFNzk4MjRFMUFFRDgxN0UyRDMiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6MzI5NzZEQTYzMTg3MTFFNzk4MjRFMUFFRDgxN0UyRDMiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDozMjk3NkRBMzMxODcxMUU3OTgyNEUxQUVEODE3RTJEMyIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDozMjk3NkRBNDMxODcxMUU3OTgyNEUxQUVEODE3RTJEMyIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/PqST9WsAAAC4SURBVHja7NuhDQAhAARB+P57hoR8AazAzZjz53cMAAAAAAAAAAAAAAAAiOa/yxUAAAAAAAAAAAAAAABcOD3K5wcAAAAAAAAAAAAAAAAqUQoAAAAAAAAAAAAAAACZKAUAAAAAAAAAAAAAAIBMlAIAAAAAAAAAAAAAAEAmSgEAAAAAAAAAAAAAACATpQAAAAAAAAAAAAAAAJCJUgAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAID3tgADALPtARBOYWXeAAAAAElFTkSuQmCC"
						});
						 doc.content.splice(3, 0, {
                            text: [
							           { text: 'Monthwise Leave Application List and Status : <?php echo date('M - Y' ,strtotime($attend_date)); ?>\n',bold:true,fontSize:17 }
                                       		   

                            ],
                            margin: [0, 10, 0, 20],
                            alignment: 'center'
                        });
                // Data URL generated by http://dataurl.net/#dataurlmaker
            },
                pageSize: 'LEGAL'
            }
        ]
        });
});
</script>


<?php 
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="#">View Leave Application List</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;View Leave Application List</h1>
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
                    
                    <div class="panel-body">
					   <span id="flash-messages" style="color:red;padding-left:110px;"><?php  echo $this->session->flashdata('message1'); ?></span>
                        <div class="table-info">
                            <form id="form" name="form" action="<?php base_url($currentModule)?>" method="POST" enctype="multipart/form-data">
                       <div class="form-group">
								<label class="col-md-2">Select Month</label>
                                             <div class="col-md-3" >
                          <input id="dob-datepicker" required class="form-control form-control-inline input-medium date-picker" name="attend_date" value="" placeholder="Enter Month" type="text">

                                             </div>
											  <div class="col-md-3" >
                            <button type="submit" class="btn btn-primary form-control" >Submit</button>
                                             </div>
                                  </div>
								    </form>
					  <div id="dashboard-recent" class="panel-warning">   
                               <div class="panel">
                            	<div class="panel-heading"><strong>Application List</strong></div>
                                <div class="panel-body">
                                <div class="table-responsive" style="overflow:auto;">
								
							<br>
							
					  <table id="example"  class="table table-bordered">
					  
					  <thead>
					  <tr> 
					  <th>Sr.No</th>
					  <th>Application No.</th>
					  <th>Application Date</th>
					  <th>Employee Id</th>
					  <th>Employee Name</th>
					  <th>Leave Type</th>
					  <th>Form Date</th>
					  <th>To Date</th>
					  <th>No. Of Days</th>
					  <th>Reason</th>
					  <th>Reporting officer <br>Recomm. Date</th>
					  <th>Reporting Officer <br>Recomm. Time</th>
					  <th>Reporting Officer Remark</th>
					  <th>Registrar Recomm. Date</th>
					  <th>Registrar Recomm. Time</th>
					  <th>Registrar Remark</th>
					  <th>Status</th>					 
					  </tr>
					  </thead>
					  <tbody>
					  <?php  $i = 1;
					  $ci =&get_instance();
   $ci->load->model('MonthlyAttendance_model');
   if(!empty($app_data)){
					  foreach($app_data as $val) {
						  $reporting_name = $ci->MonthlyAttendance_model->getROId($val['emp_id']);
						  $rdt = $ci->MonthlyAttendance_model->getRoLeaveDateTime($reporting_name[0]['um_id'],$val['lid']);
						  $reporting_name1 = $ci->MonthlyAttendance_model->getROId($reporting_name[0]['username']);
						  $rdt1 = $ci->MonthlyAttendance_model->getRoLeaveDateTime($reporting_name1[0]['um_id'],$val['lid']);
						  $lev = $ci->MonthlyAttendance_model->getLeaveTypeById($val['leave_type']);
						  echo "<tr>";
						  echo "<td>".$i."</td>";
						  echo "<td></td>";
						   echo "<td>".$val['applied_on_date']."</td>";
						   echo "<td>".$val['emp_id']."</td>";
						   echo "<td>".$val['ename']."</td>";
						   echo "<td>".$lev."</td>";
						   echo "<td>".$val['applied_from_date']."</td>";
						   echo "<td>".$val['applied_to_date']."</td>";
						   echo "<td>".$val['no_days']."</td>";
						   echo "<td>".$val['reason']."</td>";
						   //echo "<td>".$val['applied_from_date']."</td>";
						    echo "<td>".date('Y-m-d',strtotime($rdt[0]['updated_date']))."</td>";
							  echo "<td>".date('H:i:s',strtotime($rdt[0]['updated_date']))."</td>";
							   echo "<td>".$val['ro_recommend']."</td>";
							  echo "<td>".date('Y-m-d',strtotime($rdt1[0]['updated_date']))."</td>";
							   echo "<td>".date('H:i:s',strtotime($rdt1[0]['updated_date']))."</td>";
							     echo "<td>".$val['reg_comment']."</td>";
								 echo "<td>".$val['status']."</td>";
								 echo "</tr>";
					  }
   }else{

echo "<tr  style='color:red;'><td colspan='17'>No Records found</td></tr>";
   }   ?>
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
    </div>
</div>
