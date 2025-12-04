<?php 
$role_id=$this->session->userdata("role_id");
?>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<style>
  .dropdown {
    xtop:50%;
    transform: translateY(0%);
  }
    a {
    color: #fff;
  }
   .dropdown dd,
  .dropdown dt {
    margin: 0px;
    padding: 0px;
    z-index:99999!important;
  }
   .dropdown{
    z-index:99999!important}
  .dropdown ul {
    margin: -1px 0 0 0;
  }
    .dropdown dd {
    position: relative;
  }
  .dropdown a,
  .dropdown a:visited {
    color: #000;
    text-decoration: none;
    outline: none;
    font-size: 12px;
  }
   .dropdown dt a {
    background-color: #fff;
    display: block;
    padding: 10px;
    overflow: hidden;
    border: 0;
    width: 100%;
    border: 1px solid #aaa;
  }
    .dropdown dt a span,
  .multiSel span {
    cursor: pointer;
    display: inline-block;
    padding: 0 3px 2px 0;
  }
  .dropdown span.value {
    display: none;
  }
   .dropdown dd ul li a {
    padding: 5px;
    display: block;
  }
    .dropdown dd ul li a:hover {
    background-color: #ddd;
  }
  .dropdown dd ul {
    background-color: #fff;
    border: 0;
    color: #000;
    display: none;
    left: 0px;
    padding: 2px 15px 2px 5px;
    position: absolute;
    top: 2px;
    width:300px;
    list-style: none;
    height: 300px;
    overflow-y:scroll;
    border: 1px solid #aaa;
  }	
 .datepicker-dropdown{
    z-index: 999999;
  }
  #main-wrapper{overflow: visible!important;}
  .switch {
  position: relative;
  display: inline-block;
  width: 50px;
  height: 24px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 15px;
  width: 15px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 15px;
}

.slider.round:before {
  border-radius: 50%;
}
</style>

<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Masters</a></li>
        <li class="active"><a href="#">Employee Last Date Details</a></li>
    </ul>
					 <?php 
     if(isset($_SESSION['status']))
    {
        ?>
			<script>
			//alert("Your Details already Submitted.");
			var status="<?php echo $_SESSION['status'] ?>";
			 alert(status);
			</script>
        <?php 
        unset($_SESSION['status']);
       }
   ?>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-money"></i>&nbsp;&nbsp;Employee Last Date Details</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">                       
                    <div class="visible-xs clearfix form-group-margin"></div>
					
                </div>
            </div>
        </div>
        <div class="row ">
           <div class="col-sm-12">&nbsp;</div>
        </div>
        <div class="row ">
            <div class="col-sm-12">			
                <div class="panel">
				 <div class="panel-heading panel-info">
                  <form id="form" name="form" action="<?=base_url($currentModule.'/save_emp_last_date')?>" method="POST"  enctype="multipart/form-data">				 
						            <div class="form-group">
                                  <label class="col-sm-1">Select Employees
                                  </label>
                                  <div class="col-sm-3">                
                                    <dl class="dropdown dropdowns">   
                                      <dt>
                                        <a href="#">
                                          <span class="hida">All Employee
                                          </span>    
                                          <div class="multiSel">
                                          </div>  
                                        </a>
                                      </dt>
                                      <dd>
                                        <div class="mutliSelect" id="mutliSelect">
                                          <ul id="empid">
                                           <li><input type='checkbox'  name="emp_chk_all" onclick='check_all()' > Select All </li>
                                            <?php 
//print_r($emp_list)
									foreach($emp_list as $key=>$val){ 
									echo '<li>
									<input type="checkbox" name="empsid[]" id="'.$emp_list[$key]['emp_id'].'" onclick="onclick_checkbox_emp('.$emp_list[$key]['emp_id'].');" value="'.$emp_list[$key]['emp_id'].'" /> '.$emp_list[$key]['emp_id'].' - '.$emp_list[$key]['fname'].' '.$emp_list[$key]['lname'].' </li>';
									} ?> 
                                          </ul>
                                        </div>
                                      </dd>
                                    </dl>           
                                  </div>
                                </div>
								<div class="form-group">
                            <label class="col-sm-1">Last Date<?=$astrik?></label>     
                           <div class="col-sm-3">
                             <input type="text" id="last_date" name="last_date" class="form-control" placeholder="Enter Last Date" required />
                           </div><div class="col-sm-6"></div>
						   </div>
						    <div class="form-group">
                   <div class="col-md-2"><button type="submit" id="bd_search" class="btn-primary btn">Submit</button></div>
                  <div class="holder"></div></div>
				  </form>
               </div>
                <div class="panel-body">
                    <div class="table-info">    
                    <table class="table table-bordered" id="example">
                        <thead>
                            <tr>
                            <th>sno</th>
                            <th>Employee ID</th>
                            <th>Employee Name</th>
                            <th>Last Date</th>
                            <th>Status</th>
                            </tr>
                        </thead>
					 <tbody id="itemContainer">
                            <?php 							
                            $j=1;                           
                            for($i=0;$i<count($emp_det);$i++){?>                          
                            <tr>
							    <td><?=$j?></td>                               		
								<td><?=$emp_det[$i]['emp_id']?></td>
                                <td><?=$emp_det[$i]['fname'].' '.$emp_det[$i]['lname']?></td>
                                <td><?=$emp_det[$i]['last_date']?></td>
								<td><?=$emp_det[$i]['status']?>
								 <label class="switch">
								  <?php if($emp_det[$i]['status']=="Y") { $abs="checked";}else{$abs=''; }?>
									  <input type="checkbox" <?=$abs?> onclick="is_last_date_statuschng(<?=$emp_det[$i]['eid']?>,'<?=$emp_det[$i]['status']?>')">
									  <span class="slider round"></span>
									</label>								
								</td>
                            </tr>
							<?php $j++;
							}?>
                          </tbody> 							
                      </table> 					
                    </div>
                 </div>
              </div>
            </div>    
        </div>
    </div>
</div>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.flash.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js" type="text/javascript"></script>
<script>
$(document).ready(function (){
	
	$('#last_date').datepicker( {format: 'dd-mm-yyyy',autoclose:true,endDate: new Date()});
	$('#to_date').datepicker( {format: 'dd-mm-yyyy',autoclose:true,endDate: new Date()});
		$('#example').DataTable({
						orderCellsTop: true,
                        fixedHeader: true,
						dom: 'lBfrtip',
					    destroy: true,
						retrieve:true,
						paging:true,
						buttons: [
							 'excel'
						],
						lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],					  
					  });
					  
					  
	           }); 
			   
  function onclick_checkbox_emp(eid){
    //$('#mutliSelect input[type="checkbox"]').on('click', function() {
    //alert('gg');
    var title = $(this).closest('.mutliSelect').find('input[type="checkbox"]').val(),
        title = eid + ",";
    //alert(title);
    if ($('#'+eid).is(':checked')) {
      var html = '<span title="' + title + '">' + title + '</span>';
      //alert(html);
      $('.multiSel').append(html);
      $(".hida").hide();
    }
    else {
      $('span[title="' + title + '"]').remove();
      var ret = $(".hida");
      $('.dropdown dt a').append(ret);
    }
    //});
  }
  function check_all(){
    if($('input:checkbox[name="emp_chk_all"]').prop("checked")) {
  $('input:checkbox[name="empsid[]"]').prop('checked', true);
  
  $('.emp_amty').prop('disabled',false);
   } else {
     $('input:checkbox[name="empsid[]"]').prop('checked', false);
   $('.emp_amty').prop('disabled',true);
            }    
}
  function is_last_date_statuschng(eid,status)
  {
	 // alert(status);
	  if(eid !='' && status !==''){
		var checkstr =  confirm('Are you sure you want to Change this?');
        if(checkstr == true){
	 	$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Staff_payment/change_emp_last_date_status',
				data: 'eid=' + eid+'&status='+status,
				success: function (sucess) {
                      location.reload();
				}
			});
		}
		//location.reload();
	  }
	  else
	  {
		  alert("Something Wrong");
	  }
  }

  $(document).ready(function()
                    {
    $(".dropdowns dt a").on('click', function() {
      $(".dropdowns dd ul").slideToggle('fast');
    }
                          );
    $(".dropdowns dd ul li a").on('click', function() {
      $(".dropdowns dd ul").hide();
    }
                                );
    function getSelectedValue(id) {
      return $("#" + id).find("dt a span.value").html();
    }
    $(document).bind('click', function(e) {
      var $clicked = $(e.target);
      if (!$clicked.parents().hasClass("dropdowns")) $(".dropdowns dd ul").hide();
    }
                    );
          
           $(".dropdownv dt a").on('click', function() {
      $(".dropdownv dd ul").slideToggle('fast');
    }
                          );
    $(".dropdownv dd ul li a").on('click', function() {
      $(".dropdownv dd ul").hide();
    }
                                );
    function getSelectedValuev(id) {
      return $("#" + id).find("dt a span.value").html();
    }
    $(document).bind('click', function(e) {
      var $clicked = $(e.target);
      if (!$clicked.parents().hasClass("dropdownv")) $(".dropdownv dd ul").hide();
    }
                    );   
  });
  
 
</script>
