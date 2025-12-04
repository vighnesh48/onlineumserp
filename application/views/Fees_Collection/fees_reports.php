<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<script src="<?=base_url('assets/javascripts')?>/jquery.table2excel.js"></script>

<!--script type="text/javascript" src="www.sandipuniversity.com/assets/js/export/tableExport.js"></script>
<script type="text/javascript" src="www.sandipuniversity.com/assets/js/export/jquery.base64.js"></script-->
<script>
	$(document).ready(function(){
		
$("#datepick").hide();
$(".tdth").hide();
 $('.rtype').on('change', function(){
    // alert(this.value);
            $('#datepick').toggle(this.value === 'd');
            if(this.value === 'cn'){
                $('#datepick').val('');
            }
        });
$("#datepick").datepicker({       
        autoclose: true,
		format: 'dd-mm-yyyy'		
    });

});
</script>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Masters</a></li>
        <li class="active"><a href="#">Fees Report</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Fees Report</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                    <?php //if(in_array("Add", $my_privileges)) {
                    ?>
                    <div class="pull-right col-xs-12 col-sm-auto"></div>                        
                    <div class="visible-xs clearfix form-group-margin"></div>
                    <?php // } ?>
                    <?php //if(in_array("Search", $my_privileges)) { ?>
                  
                    <?php //} 
                    ?>
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
                      
<?php 
$col = $this->session->userdata('name');
$ex = explode("_",$col);
		if($ex[0]=='sf'){?>

<div class="col-sm-2">
                            <select id="college_name" name="college_name" class="form-control">
                                           <option value="">Select College</option>
										   <?php foreach($college_details as $val){
											    echo '<option value="'.$val['college_name'].'">'.$val['college_name'].'</option>';
										   }
										   ?>
                                        </select>
							
							</div>
							


	<?php	}
?>


						  <div class="col-sm-2">
                            <input type="radio" name="rtype" class="rtype"  value="cn" /> Overall
						
							
							</div>
							<div class="col-sm-2">                            
                            	<input type="radio" name="rtype" class="rtype" value="d" /> Date
							</div>
							<div class="col-sm-3">                            
                              <input type="text" name="date" id="datepick" />							
							</div>
							
							 <div class="col-sm-2">
							
                                        <button class="btn btn-primary form-control" id="searchbtn" type="button" > <i class="fa fa-search"></i>&nbsp;Search</button>                                        
                            </div>   
                    
						</div>
                </div><div class="clearfix"></div>
                <div class="panel-body">
                    <div class="table-info table-responsive">    
                    <?php //if(in_array("View", $my_privileges)) { 
                    ?>
                    <table class="table table-bordered table-hover" id="feestable">
                        <thead>
                            
                            <tr>
                                    <th >S.No</th>
                                    <th >College</th>
                                    <th >Course</th>
                                    <th >Branch</th>
                                    <th >Year</th>
									<th>No. Student</th>
									<th>Total Amount</th>
									<th class="tdth" >Date</th>
								
                                    
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                                            
                        </tbody>
                    </table> 
                     <div class="col-md-10">
                         <div class="holder pull"> </div>
                     </div>
                    <div class="col-md-2">
                        	<button id="exp" class="btn btn-primary pull-left" >Export Excel</button>	
                     </div>
                                 
                        
				
                  
                </div>
                </div>
            </div>
            </div>    
        </div>
    </div>
</div>
<script>
			$("#exp").click(function(){
				$("#feestable").table2excel({
					exclude: ".noExl",
					name: "Excel Document Name",
					filename: "myFileName",
					type: ".xls",
					exclude_img: true,
					exclude_links: true,
					exclude_inputs: true
				});
			});
		</script>
<script>

  $("div.holder").jPages
  ({
    containerID : "itemContainer"
  });
  $("#search_me").select2({
      placeholder: "Enter title",
      allowClear: true
    });
        $("#searchbtn").on('click',function()
        {
            var coll_val = $("input[name='rtype']:checked"). val();  
          // alert(coll_val);
            if(coll_val == null){
				alert('Please select one of the report type.');
			}else{
			var dat = $('#datepick').val();
		   var col_nam = $('#college_name').val();
		   
            var url  = "<?=base_url().strtolower($currentModule).'/search_report/'?>";	
            var data = {colg: coll_val,dt:dat,colnam:col_nam};		
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
                   
                        $("#itemContainer").html(data);
                        if(coll_val == 'd'){
                            $('.tdth').show();
                        }else if(coll_val == 'cn'){
                            $('.tdth').hide();
                        }
                       
                },
                error: function(data)
                {
                    alert("Page Or Folder Not Created..!!");
                }
			
            });
			}
        });
</script>