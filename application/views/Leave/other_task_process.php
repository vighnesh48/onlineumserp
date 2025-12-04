<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<script src="<?=base_url()?>assets/javascripts/moment.js"></script>

<style>
.leavetab{max-width:110% !important;width:110% !important;}
.timeline-centered {
    position: relative;
    margin-bottom: 30px;
}
    .timeline-centered:before, .timeline-centered:after {
        content: " ";
        display: table;
    }
    .timeline-centered:after {
        clear: both;
    }
    .timeline-centered:before, .timeline-centered:after {
        content: " ";
        display: table;
    }

    .timeline-centered:after {
        clear: both;
    }

    .timeline-centered:before {
        content: '';
        position: absolute;
        display: block;
        width: 4px;
        background: #f5f5f6;
        /*left: 50%;*/
        top: 20px;
        bottom: 20px;
        margin-left: 30px;
    }

    .timeline-centered .timeline-entry {
        position: relative;
        /*width: 50%;
        float: right;*/
        margin-top: 5px;
        margin-left: 30px;
        margin-bottom: 30px;
        clear: both;
    }

        .timeline-centered .timeline-entry:before, .timeline-centered .timeline-entry:after {
            content: " ";
            display: table;
        }

        .timeline-centered .timeline-entry:after {
            clear: both;
        }

        .timeline-centered .timeline-entry:before, .timeline-centered .timeline-entry:after {
            content: " ";
            display: table;
        }

        .timeline-centered .timeline-entry:after {
            clear: both;
        }

        .timeline-centered .timeline-entry.begin {
            margin-bottom: 0;
        }

        .timeline-centered .timeline-entry.left-aligned {
            float: left;
        }

            .timeline-centered .timeline-entry.left-aligned .timeline-entry-inner {
                margin-left: 0;
                margin-right: -18px;
            }

                .timeline-centered .timeline-entry.left-aligned .timeline-entry-inner .timeline-time {
                    left: auto;
                    right: -100px;
                    text-align: left;
                }

                .timeline-centered .timeline-entry.left-aligned .timeline-entry-inner .timeline-icon {
                    float: right;
                }

                .timeline-centered .timeline-entry.left-aligned .timeline-entry-inner .timeline-label {
                    margin-left: 0;
                    margin-right: 70px;
                }

                    .timeline-centered .timeline-entry.left-aligned .timeline-entry-inner .timeline-label:after {
                        left: auto;
                        right: 0;
                        margin-left: 0;
                        margin-right: -9px;
                        -moz-transform: rotate(180deg);
                        -o-transform: rotate(180deg);
                        -webkit-transform: rotate(180deg);
                        -ms-transform: rotate(180deg);
                        transform: rotate(180deg);
                    }

        .timeline-centered .timeline-entry .timeline-entry-inner {
            position: relative;
            margin-left: -20px;
        }

            .timeline-centered .timeline-entry .timeline-entry-inner:before, .timeline-centered .timeline-entry .timeline-entry-inner:after {
                content: " ";
                display: table;
            }

            .timeline-centered .timeline-entry .timeline-entry-inner:after {
                clear: both;
            }

            .timeline-centered .timeline-entry .timeline-entry-inner:before, .timeline-centered .timeline-entry .timeline-entry-inner:after {
                content: " ";
                display: table;
            }

            .timeline-centered .timeline-entry .timeline-entry-inner:after {
                clear: both;
            }

            .timeline-centered .timeline-entry .timeline-entry-inner .timeline-time {
                position: absolute;
                left: -100px;
                text-align: right;
                padding: 10px;
                -webkit-box-sizing: border-box;
                -moz-box-sizing: border-box;
                box-sizing: border-box;
            }

                .timeline-centered .timeline-entry .timeline-entry-inner .timeline-time > span {
                    display: block;
                }

                    .timeline-centered .timeline-entry .timeline-entry-inner .timeline-time > span:first-child {
                        font-size: 15px;
                        font-weight: bold;
                    }

                    .timeline-centered .timeline-entry .timeline-entry-inner .timeline-time > span:last-child {
                        font-size: 12px;
                    }

            .timeline-centered .timeline-entry .timeline-entry-inner .timeline-icon {
                background: #fff;
                color: #737881;
                display: block;
                width: 40px;
                height: 40px;
                -webkit-background-clip: padding-box;
                -moz-background-clip: padding;
                background-clip: padding-box;
                -webkit-border-radius: 20px;
                -moz-border-radius: 20px;
                border-radius: 20px;
                text-align: center;
                -moz-box-shadow: 0 0 0 5px #f5f5f6;
                -webkit-box-shadow: 0 0 0 5px #f5f5f6;
                box-shadow: 0 0 0 5px #f5f5f6;
                line-height: 40px;
                font-size: 15px;
                float: left;
            }

                .timeline-centered .timeline-entry .timeline-entry-inner .timeline-icon.bg-primary {
                    background-color: #303641;
                    color: #fff;
                }

                .timeline-centered .timeline-entry .timeline-entry-inner .timeline-icon.bg-secondary {
                    background-color: #ee4749;
                    color: #fff;
                }

                .timeline-centered .timeline-entry .timeline-entry-inner .timeline-icon.bg-success {
                    background-color: #00a651;
                    color: #fff;
                }

                .timeline-centered .timeline-entry .timeline-entry-inner .timeline-icon.bg-info {
                    background-color: #21a9e1;
                    color: #fff;
                }

                .timeline-centered .timeline-entry .timeline-entry-inner .timeline-icon.bg-warning {
                    background-color: #fad839;
                    color: #fff;
                }

                .timeline-centered .timeline-entry .timeline-entry-inner .timeline-icon.bg-danger {
                    background-color: #cc2424;
                    color: #fff;
                }

            .timeline-centered .timeline-entry .timeline-entry-inner .timeline-label {
                position: relative;
                background: #f5f5f6;
                padding: 1em;
                margin-left: 60px;
                -webkit-background-clip: padding-box;
                -moz-background-clip: padding;
                background-clip: padding-box;
                -webkit-border-radius: 3px;
                -moz-border-radius: 3px;
                border-radius: 3px;
            }

                .timeline-centered .timeline-entry .timeline-entry-inner .timeline-label:after {
                    content: '';
                    display: block;
                    position: absolute;
                    width: 0;
                    height: 0;
                    border-style: solid;
                    border-width: 9px 9px 9px 0;
                    border-color: transparent #f5f5f6 transparent transparent;
                    left: 0;
                    top: 10px;
                    margin-left: -9px;
                }

                .timeline-centered .timeline-entry .timeline-entry-inner .timeline-label h2, .timeline-centered .timeline-entry .timeline-entry-inner .timeline-label p {
                    color: #737881;
                    font-family: "Noto Sans",sans-serif;
                    font-size: 12px;
                    margin: 0;
                    line-height: 1.428571429;
                }

                    .timeline-centered .timeline-entry .timeline-entry-inner .timeline-label p + p {
                        margin-top: 15px;
                    }

                .timeline-centered .timeline-entry .timeline-entry-inner .timeline-label h2 {
                    font-size: 16px;
                    margin-bottom: 10px;
                }

                    .timeline-centered .timeline-entry .timeline-entry-inner .timeline-label h2 a {
                        color: #303641;
                    }

                    .timeline-centered .timeline-entry .timeline-entry-inner .timeline-label h2 span {
                        -webkit-opacity: .6;
                        -moz-opacity: .6;
                        opacity: .6;
                        -ms-filter: alpha(opacity=60);
                        filter: alpha(opacity=60);
                    }

.view-btn{padding:0px;}
.view-btn i{padding: 3px 0;list-style:none;width:35px;text-align: center;color:#fff;background:#4bb1d0;xpadding: 5px 10px;margin:2px;}
.view-btn i a{color:#fff;font-weight:bold;}

</style>
<?php// print_r($all_emp_leave);?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Leave</a></li>
        <li class="active"><a href="#">Allocated Task List</a></li>
    </ul>
    <div class="page-header">           
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Allocated Task List</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                    <?php if(in_array("Add", $my_privileges)) { ?>
                         <div class="pull-right col-xs-12 col-sm-auto"><a style="width: 100%;" class="btn btn-primary btn-labeled" href="<?=base_url($currentModule."/allocate_faculty_for_other_tasks")?>"><span class="btn-label icon fa fa-plus"></span>Allocate Task</a></div>                     
                    <div class="visible-xs clearfix form-group-margin"></div>
                    <?php } ?>
                    <?php //if(in_array("Search", $my_privileges)) { ?>
                
                    <?php //} ?>
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-sm-12">&nbsp;</div>
        </div>
        <div class="row ">
            <!-- tabs -->
        <div class="tabbable">
         
          <div class="tab-content">           
            <div class="tab-pane active " id="leave">            
             <div class="col-sm-12">
                <div class="panel">
               <div class="panel-heading"> 

 <div class="row">
                <div class="col-md-6" class="form-control">
                <h4>
                For the Month of <span id="mon"><b><?php 
                date_default_timezone_set('Asia/Kolkata');
                //echo $mon;
                $ex = explode('-',$mon);
                $st = $ex[1].'-'.$ex[0];
                if($st != '-'){
                echo date('F Y',strtotime($st)); 
                }else{
                    echo date('F Y');
                }?></b></span></h4>
                </div>
                <div class="col-md-6">
                <div class="row">
                <label class="col-sm-3 text-right">Month: </label>
               <div class="col-md-3" >
<input type="text" id="monthleave" name="month" class="form-control monthPicker" value="<?php echo $mon; ?>"/> 
</div>
<div class="col-md-3"><input type="button" id="find" onclick="search_emp_leves('leave')"  class="btn btn-primary" value="Search">
</div>
                </div>
                </div>
                </div>

               </div>
                
            <div class="panel-body"  style="overflow-x:scroll;height:700px;">
                    <div class="table-info">    
                    <?php //if(in_array("View", $my_privileges)) { ?>
                    <table class="table table-bordered leavetab">
                        <thead>
                          <tr>
                                    <th width="3%">S.No</th>                                   
                                    <th width="5%">Emp.Id</th>
                                    <th width="15%">Name</th>
                                    <th width="5%">School</th>
                                    <th width="10%">Department</th>
                                    <th width="8%"> From Date</th>    
                                     <th width="8%"> To Date</th> 									
                                    <th width="30%">Reason</th>
                                    <th width="2%">Days</th>                                    
                                   <th width="8%">Applied on</th>
                                  <th width="3%">Action</th>
                            
                                    
                            </tr>
                        </thead>
                        <tbody id="itemContainer1">
                              <?php 
//print_r($applicant_leave);

                              if(empty($other_tsk_list)){?>
                                    <tr id="row441" class="odd" role="row">
                                        <td colspan="13" class="center"><?php echo "No Leave Applications Available"; ?></td>
                                        </tr>
                                    <?php }else{
                                        $i=0;
                                        //print_r($applicant);
                                        foreach($other_tsk_list as $key=>$val){
                                            $i++;
                                        ?>
                                    <tr id="row<?php echo $i;?>" class="odd" role="row">
                                        <td class="center"><?php echo $i;?></td>
                                       
                                           <td class="center"><?php echo $other_tsk_list[$key]['emp_id'];?></td>
                                       <td class="center sorting_1"><?php if($other_tsk_list[$key]['gender']=='male'){echo 'Mr.';}else if($other_tsk_list[$key]['gender']=='female'){ echo 'Mrs.';} ?><?php echo $other_tsk_list[$key]['fname']." ".$other_tsk_list[$key]['lname'];?></td>
                                        <td class="center"><?=$other_tsk_list[$key]['college_code']?></td>
                                <td class="center"><?=$other_tsk_list[$key]['department_name']?></td>
                               <td class="center"><?php 
                                            echo date('d/m/Y',strtotime($other_tsk_list[$key]['from_date']));
                                        ?></td>
										 <td class="center"><?php 
                                            echo date('d/m/Y',strtotime($other_tsk_list[$key]['to_date']));
                                        ?></td>
                                      
                                      
                                        <td class="center"><?php echo $other_tsk_list[$key]['reason'];?></td>
                                       
                                        <td class="center"><?php echo $other_tsk_list[$key]['no_days'];?></td>
                                 
                                        <td class="center"><?php echo date('d/m/Y',strtotime($other_tsk_list[$key]['inserted_datetime']));?></td>
                                       
                                            <td class="">
                                             <a href='<?=base_url($currentModule)."/"?><?= $other_tsk_list[$key]['status']=="Y"?"disable_request/".$other_tsk_list[$key]['id'] :"enable_request/".$other_tsk_list[$key]['id']  ?>'><i class='fa <?=$other_tsk_list[$key]['status'] =="Y"?"fa-ban":"fa-check"?>' title='<?= $other_tsk_list[$key]['status']=="Y"?"Disable":"Enable"?>'></i></a>
                                            </td>
                                        </tr>   
                                        
                                        <?php }}?>             
                        </tbody>
                    </table>     
                   <?php if($this->session->userdata("role_id")==1 || $this->session->userdata("role_id")==6 || $this->session->userdata("role_id")==11 ){  }else{?>
                   
                    <div class="col-md-3"><select id="selsts" class="form-control"><option value="">Select</option><option value="approved">Action Taken</option><option value="pending">Action Pending</option></select></div><div class="col-md-1"><button id="tapexport" class="btn-primary btn">PDF</button></div>  <div class="col-md-2">  <button id="taexport" class="btn-primary btn">Excel</button></div>         
                
                    <?php } ?>
                </div>
                </div>
              </div>
                </div>  
            
            </div>
                </div>
        <!-- /tabs -->              
               
              
        </div>
    </div>
</div>
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content" id="edata" >
     
    </div>

  </div>
</div>
<script>
<?php if($_GET['sf']!=''){ ?>
filter_table('<?php echo $_GET['sf']; ?>');
<?php } ?>
function filter_table(s){
//alert(s);	
	 var target = $("ul#emptab li.active a").attr('href');
    // alert(target);
var tableBody = $(target+" .table-bordered tbody").attr('id');
 var k=1;
        var tableRowsClass = $(target+" .table-bordered tbody tr");		
		 tableRowsClass.each( function(i, val) {      
         // alert('h');
           var rowText = $(this).find("td").eq(11).find("span").attr('id');
			//alert(rowText);
			if(s!=''){
			        if(s==rowText){  
					
$(this).find("td").eq(0).html(k);		
var sf = $(this).find("td").eq(13).find("a").attr('href'); 
//alert(sf); 
 $(this).find("td").eq(13).find("a").attr('href',sf+'/'+s); 
				   tableRowsClass.eq(i).show();		
k = k+1;				   
          
					}else{                 
					tableRowsClass.eq(i).hide();                		
               
            }
        }else{
            	 tableRowsClass.eq(i).show();		
            }
			
			 });   
		
}
function search_emp_leves(lt){
    var month = $('#month'+lt).val();    
          url= "<?php echo base_url().$currentModule; ?>/allocated_task_list/"+month;
          
          window.location = url;
}
$(function () {
    $('.monthPicker').datepicker({
       autoclose: true,
    minViewMode: 1,
    format: 'mm-yyyy',
        onClose: function (dateText, inst) {
            var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
            $(this).datepicker('setDate', new Date(year, month, 1));
        }
    });
});
$(document).ready(function(){
    $('#taexport').click(function(){
	var mon = $('#monthleave').val();
    var selsts = $('#selsts').val();
    if(mon == ''){
        var d = new Date();
        var m = d.getMonth();
        m = m+1;
        mon = m+"-"+d.getFullYear();
        //alert(mon);
    }
var url  = "<?=base_url().strtolower($currentModule).'/export_emp_application_lev/exl/'?>"+mon+"/"+selsts;        
          //alert(url);
          window.location.href = url;
});	
$('#tapexport').click(function(){
	var mon = $('#monthleave').val();
    var selsts = $('#selsts').val();
    //alert(mon);
    
    if(mon == ''){
        var d = new Date();
        var m = d.getMonth();
        m = m+1;
        mon = m+"-"+d.getFullYear();
        //alert(mon);
    }
var url  = "<?=base_url().strtolower($currentModule).'/export_emp_application_lev/pdf/'?>"+mon+"/"+selsts;     
          //alert(url);
          window.location.href = url;
});	
 $('#taexportod').click(function(){
    var mon = $('#monthofficial').val();
    var selsts = $('#selstsod').val();
    if(mon == ''){
        var d = new Date();
        var m = d.getMonth();
        m = m+1;
        mon = m+"-"+d.getFullYear();
        //alert(mon);
    }
var url  = "<?=base_url().strtolower($currentModule).'/export_emp_application_lev/exl-od/'?>"+mon+"/"+selsts;        
          //alert(url);
          window.location.href = url;
}); 
$('#tapexportod').click(function(){
    var mon = $('#monthofficial').val();
    var selsts = $('#selstsod').val();
    //alert(mon);
    
    if(mon == ''){
        var d = new Date();
        var m = d.getMonth();
        m = m+1;
        mon = m+"-"+d.getFullYear();
        //alert(mon);
    }
var url  = "<?=base_url().strtolower($currentModule).'/export_emp_application_lev/pdf-od/'?>"+mon+"/"+selsts;     
          //alert(url);
          window.location.href = url;
}); 
    $(".edetails").on('click', function() {
   //alert();
  var post_data = $(this).attr('id');
  //alert(post_data);
    jQuery.ajax({
                type: "POST",
                url: base_url+"leave/view_application_forward_details/"+post_data,              
                success: function(data){
                //  alert(data);          
            $('#edata').html(data);
         
                }   
            });
});

  
      
        $(".emp_view").on('click',function()
        {
            var eid = $(this).attr('id');   

            var url  = "<?=base_url().strtolower($currentModule).'/get_emp_history/'?>"+eid;    
         //   var data = {title: search_val};       
         //   var type="";
         //   var type_name="";
            $.ajax
            ({
                type: "POST",
                url: url,
               // data: data,
                dataType: "html",
                cache: false,
                crossDomain: true,
                success: function(data)
                {  
                   $("#empname").text(eid);
                        $("#emp_cnt").html(data);
                  
                },
                error: function(data)
                {
                    alert("Page Or Folder Not Created..!!");
                }
            });
        });
        });
</script>