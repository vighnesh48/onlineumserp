<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $('[data-toggle="popover"]').popover({
        placement : 'right',
        trigger : 'hover',
	 html:true
    });
     $('[data-toggle="popover1"]').popover({
        placement : 'left',
        trigger : 'hover',
	 html:true
    });
});
</script>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Home</a></li>
        <li class="active"><a href="#">Dashboard</a></li>
    </ul>
    <div id="page-wrapper">
       <?php if($this->session->userdata('role_id')==1 || $this->session->userdata('role_id')==3 ||$this->session->userdata('role_id')==4 ||$this->session->userdata('role_id')==7 ||$this->session->userdata('role_id')==8 ){ //for admin dashboard?> 
        <div class="row">
            <div class="col-lg-3">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-sitemap fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <p class="announcement-heading"><b># Consent Received</b></p>
								<p class="announcement-text">School: <b><?=(!empty($icrepcnt[0]['consent_school_count'])) ? $icrepcnt[0]['consent_school_count']:0 ?></b></p>
								<p class="announcement-text">College: <b><?=(!empty($icrepcnt[0]['consent_collage_count'])) ? $icrepcnt[0]['consent_collage_count'] :0?></b></p>
								<p class="announcement-text">Classes: <b><?=(!empty($icrepcnt[0]['consent_classes_count'])) ? $icrepcnt[0]['consent_classes_count'] : 0?></b></p>
                                

                            </div>
                        </div>
                    </div>
                    <a href="#">
                        <div class="panel-footer announcement-bottom">
                            <div class="row">
                                <div class="col-xs-3 text-left">
                                   Total:  
                                </div>
                                <div class="col-xs-9 text-right">
                                   <b><?=$icrepcnt[0]['consent_total']?></b>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="panel panel-warning">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-2">
                                <i class="fa fa-check fa-5x"></i>
                            </div>
                            <div class="col-xs-10 text-right">                               
                                <p class="announcement-heading"><b># Seminar Conducted</b></p>
								<p class="announcement-text">School: <b><?=(!empty($icrepcnt[0]['seminars_school_count'])) ? $icrepcnt[0]['seminars_school_count'] : 0 ?></b></p>
								<p class="announcement-text">College: <b><?=(!empty($icrepcnt[0]['seminars_collage_count'])) ? $icrepcnt[0]['seminars_collage_count'] : 0?></b></p>
								<p class="announcement-text">Classes: <b><?=(!empty($icrepcnt[0]['seminars_classes_count'])) ? $icrepcnt[0]['seminars_classes_count'] : 0?></b></p>
                            </div>
                        </div>
                    </div>
                    <a href="#">
                        <div class="panel-footer announcement-bottom">
                            <div class="row">
                                <div class="col-xs-3 text-left">
                                   Total: 
                                </div>
                                <div class="col-xs-9 text-right">
                                    <b><?=(!empty($icrepcnt[0]['seminars_total'])) ? $icrepcnt[0]['seminars_total']: 0?></b>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-pencil-square-o fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <p class="announcement-heading"><b># Students Present</b></p>
								<p class="announcement-text">School: <b><?=(!empty($icrepcnt[0]['student_school_count'])) ? $icrepcnt[0]['student_school_count']: 0?></b></p>
								<p class="announcement-text">College: <b><?=(!empty($icrepcnt[0]['student_collage_count'])) ? $icrepcnt[0]['student_collage_count']: 0?></b></p>
								<p class="announcement-text">Classes: <b><?=(!empty($icrepcnt[0]['student_classes_count'])) ? $icrepcnt[0]['student_classes_count']: 0?></b></p>
                            </div>
                        </div>
                    </div>
                    <a href="#">
                        <div class="panel-footer announcement-bottom">
                            <div class="row">
                                <div class="col-xs-3 text-left">
                                    Total:
                                </div>
                                <div class="col-xs-9 text-right">
                                    <b><?=(!empty($icrepcnt[0]['student_total'])) ? $icrepcnt[0]['student_total']: 0?></b>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-2">
                                <i class="fa fa-users fa-5x"></i>
                            </div>
                            <div class="col-xs-10 text-right">
                                <p class="announcement-heading"><b># IC and Campus</b></p>
                                <p class="announcement-text">IC: <b><?=(!empty($icrepcnt[0]['no_ic_faculty'])) ? $icrepcnt[0]['no_ic_faculty']: 0?></b></p>
								<p class="announcement-text">Campus: <b><?=(!empty($icrepcnt[0]['no_compus_faculty'])) ? $icrepcnt[0]['no_compus_faculty']: 0?></b></p>
								<p class="announcement-text">&nbsp;</p>
                            </div>
                        </div>
                    </div>
                    <a href="#">
                        <div class="panel-footer announcement-bottom">
                            <div class="row">
                                <div class="col-xs-6 text-left">
                                   Total:  
                                </div>
                                <div class="col-xs-6 text-right">
                                   <b><?=$icrepcnt[0]['no_ic_faculty'] + $icrepcnt[0]['no_compus_faculty']?></b>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div><!-- /.row -->
	  

        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                <div class="panel-heading">
                        <span class="panel-title"><i class="fa fa-check-square" style="font-size:18px">&nbsp;&nbsp;&nbsp;IC Event Details</i></span>
                      &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;   <?php echo'<i class="fa fa-info-circle"  style="font-size:24px" data-toggle="popover" title="Stream Wise Details" data-content="';
                                                     
                       
				 		for($b=0;$b<count($streamwiseTotalIc);$b++){
						
                      echo $streamwiseTotalIc[$b]['standard_name'].' '.$streamwiseTotalIc[$b]['stream_name'].'-<b>'.$streamwiseTotalIc[$b]['stud_count'].'</b></br>';
                       }

                echo '" ></i>';
	
?>  
                          
                        <div class="pull-right col-xs-12 col-sm-auto"><a style="width: 100%;" class="btn btn-primary btn-labeled" href="<?=base_url('home/get_events_summary_excel')?>" <span="">Export All </a></div>
                        <div class="holder"></div>
                </div>
                <div class="panel-body" style="overflow:scroll;height:800px;">
                    <div class="table-info">    
                  <div >
				  </div>
                    <table class="table table-bordered table-hover table-responsive">
                        <thead>
                            <tr>
                                    <th>SrNo.</th>
                                    <th>IC Name</th>
                                    <th>Location</th>
				                    <th>Total Events</th>
				                    <th>Total Form</th>
                                    <th>Total Entries </th>
                                    <th>Total Admissions</th>
                                   
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php
                            $j=1;  
                            //print_r($applicant);
                            if(!empty($applicant)){
                                $eve=0;
                                $frm=0;
                                $fent=0;
                            for($i=0;$i<count($applicant);$i++)
                            {

                            ?>
                            <tr <?=$applicant[$i]["status"]=="N"?"style='background-color:#FBEFF2'":""?>>
                                <td><?=$j?></td>  
                                <td><?=$applicant[$i]['ic_name']?></td> 
                                <td><?=$applicant[$i]['city_name'].",".$applicant[$i]['state_name']?></td>                                                                
                                <td><?=$applicant[$i]['totalevents']?></td>  
  			                	<td><b><?=$applicant[$i]['event_detail'][0]['form_total']?></b></td>
                                <td><b><?=$applicant[$i]['totalstudents'][0]['studcnt']?></b>
                                  <?php
                        echo '<i class="fa fa-info-circle pull-right"  style="font-size:24px" data-toggle="popover" title="Entries Details" data-content="';
				 	for($a=0;$a<count($applicant[$i]['streamwiseTotal']);$a++){
						
                      echo $applicant[$i]['streamwiseTotal'][$a]['standard_name'].' '.$applicant[$i]['streamwiseTotal'][$a]['stream_name'].'-<b>'.$applicant[$i]['streamwiseTotal'][$a]['stud_count'].'</b><br>';
                       }

                echo '" ></i>';
	
?> </td><td></td>
                            </tr>
                            <?php
                             $eve+= $applicant[$i]['totalevents'];
                             $frm+= $applicant[$i]['event_detail'][0]['form_total'];
                             $fent+= $applicant[$i]['totalstudents'][0]['studcnt'];
                            $j++;
                            }
                            echo'<tr>
                            <td></td>
                             <td></td>
                              <td></td>
                               <td>'.$eve.'</td>
                                <td>'.$frm.'</td>
                                 <td>'.$fent.'<i class="fa fa-info-circle pull-right"  style="font-size:24px" data-toggle="popover" title="Entries Details" 
                                 data-content="';
                                
                                 	for($b=0;$b<count($streamwiseTotalIc);$b++){
						
                      echo $streamwiseTotalIc[$b]['standard_name'].' '.$streamwiseTotalIc[$b]['stream_name'].'-<b>'.$streamwiseTotalIc[$b]['stud_count'].'</b><br>';
                       }
                        
                                 echo'"
                                 ></i>

                                 </td>
                                    <td></td>
                            
                            </tr>';
                            }else{
                                echo '<tr><td colspan="7">No Centers Availables!!</td></tr>';
                            }
                            ?>                            
                        </tbody>
                    </table>                    
                    <?php //} ?>
                </div>
				<div class="holder"></div>
                </div>
            </div>
            </div>    
        </div>
		<!-- for specific search-->
		 
        </div>
		 <?php } //end of admin dashboard?>		


      </div>
</div>
<script>
$(document).ready(function(){
	$('#search_dt').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
	$('#search_dt1').datepicker( {format: 'yyyy-mm',minViewMode: 1,autoclose: true});
	$('#search_dt2').datepicker( {format: 'yyyy',viewMode: 'years',minViewMode: 'years',startDate: '2015',autoclose: true});
	$("#ic_code").select2({
        placeholder: "Select Center Code",
        allowClear: true
    });
	$("#executive_id").select2({
        placeholder: "Select Executive",
        allowClear: true
    });
	$("#duration").select2({
        placeholder: "Select Duration",
        allowClear: true
    });
	
	//advance selection day/montn/year wise
	$('#duration').change(function () {
		var dur=$('#duration').val();
		//alert(dur);
             if ( dur == 'month') {
                $('#month').show();
				$('#day').hide();
				$('#year').hide();
				
            }else if(dur == 'year'){
                $('#year').show();
				$('#month').hide();
				$('#day').hide();
            }else if(dur =='day'){
                $('#day').show();
				$('#month').hide();
				$('#year').hide();
            }else if(dur ==''){
                $('#day').hide();
				$('#month').hide();
				$('#year').hide();
            }  
        });
	
});



  $("div.holder").jPages
  ({
    containerID : "CitemContainer"
  }); 
  $("#temp.holder").jPages
  ({
    containerID : "CitemContainer1"
  });
    $("#search_me").select2({
      placeholder: "Enter Event name",
      allowClear: true
    });    
        $("#search_me").on('change',function()
        {
            var search_val = $(this).val();            
            var url  = "<?=base_url().strtolower($currentModule).'/search/'?>";	
            var data = {title: search_val};		
            var type="";
            var type_name="";
            $.ajax
            ({
                type: "POST",
                url: url,
                data: data,
                dataType: "html",
                cache: false,
                crossDomain: true,
                success: function(data)
                {                       
                    var array=JSON.parse(data);
                    var str="";
                    var str2="";
                    for(i=0;i<array.city_details.length;i++)
                    {
                        str+='<tr style="display: table-row; opacity: 1;">';
                        str+='<td>'+(i+1)+'</td>';                                                                                                                        
                        str+='<td>'+array.city_details[i].state_name+'</td>';                        
                        str+='<td>'+array.city_details[i].city_name+'</td>';                        
                        str+='<td>';
                        str+='<a href="<?=base_url(strtolower($currentModule))?>/edit/'+array.city_details[i].event_id+'"><i class="fa fa-edit"></i></a>';
                        str+=' <a href="<?=base_url(strtolower($currentModule))?>/disable/'+array.city_details[i].event_id+'"><i title="Disable" class="fa fa-ban"></i></a>';
                        str+='</td>';
                        str+='</tr>';
                        $("#itemContainer").html(str);
                    }
                },
                error: function(data)
                {
                    alert("Page Or Folder Not Created..!!");
                }
            });
        });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.0.272/jspdf.min.js"></script>
<script src="https://rawgit.com/someatoms/jsPDF-AutoTable/master/dist/jspdf.plugin.autotable.js"></script>

<script>
function generate() {

  var doc = new jsPDF('p', 'pt');

  var res = doc.autoTableHtmlToJson(document.getElementById("basic-table"));
  doc.autoTable(res.columns, res.data, {margin: {top: 80}});

  var header = function(data) {
    doc.setFontSize(18);
    doc.setTextColor(40);
    doc.setFontStyle('normal');
    //doc.addImage(headerImgData, 'JPEG', data.settings.margin.left, 20, 50, 50);
    doc.text("Testing Report", data.settings.margin.left, 50);
  };

 var options = {
    beforePageContent: header,
    margin: {
      top: 80
    },
    startY: doc.autoTableEndPosY() + 20
  };

 //doc.autoTable(res.columns, res.data, options);

  doc.save("table.pdf");
}
</script>
