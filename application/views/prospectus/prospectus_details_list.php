<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<style>

   
</style>

<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Masters</a></li>
        <li class="active"><a href="#">Student Prospectus Fees</a></li>
    </ul>
    <div class="page-header">     
        <div class="row">
            <h1 class="col-xs-12 col-sm-6 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Student Prospectus Fees List</h1>
            <div class="col-xs-12 col-sm-6">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                   
                    <div class="pull-right col-xs-6 col-sm-auto"><a style="width: 100%;" class="btn btn-primary btn-labeled" href="<?=base_url($currentModule."/student_prospectus_add")?>"><span class="btn-label icon fa fa-plus"></span>Add Student Prospectus</a></div>
                 

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
                     <div class="row ">
                        
                    </div>
                        
                </div><?php
                if(!empty($this->session->flashdata('message1'))){
                ?>
                    <span style="color:green; padding-left:20px;"><b><?php echo $this->session->flashdata('message1'); ?></b></span>
                    <?php 
                }elseif (!empty($this->session->flashdata('message2'))) {?>
                    <span style="color:Red; padding-left:20px;"><b><?php echo $this->session->flashdata('message2'); ?></b></span>
                    <?php }
                    ?>
                    
                <div class="panel-body" style="overflow:scroll;height:800px;">
                    <div class="row ">
					<?php 
						$seg= $this->uri->segment(3);
						if($seg=='online'){
							$btn_cls ='btn-success';
                            $btn_cls1='';
						}else{
							$btn_cls1 ='btn-success';
                            $btn_cls='';
						}
					?>
                             <div class="col-sm-1"><a href="<?=base_url()?>Prospectus_fee_details/"><button id="texport" class="<?=$btn_cls1?> btn">Offline</button></a> </div> 
                            <div class="col-md-7">
									<a href="<?=base_url()?>Prospectus_fee_details/index/online"><button id="texport" class="<?=$btn_cls?> btn">Online</button></a>
							</div>
                            <div class="col-sm-2">  
                             <input id="system-search" name="q" placeholder="Search for" required class="form-control pull-right">
                            </div>
                            <div class="col-sm-2"> 
                            <!--button id="texport" class="btn-warning btn">Export</button--> 
                             
                            </div>  
                     </div> 
                     <br/>
                    <div class="table-info">    
                    <?php// if(in_array("View", $my_privileges)) { ?>
                    <table class="table table-bordered table-list-search">
                        <thead>
                            <tr>
                                    <th>#</th>
                                     <?php if($this->session->userdata("role_id")=='1'){?>
									 <?php 
										if($seg !='online'){ ?>
                                    <th>IC User Name</th>
										<?php }}?>
										<?php 
										if($seg =='online'){ ?>
                                    <th>Receipt No</th>
										<?php }?>
                                    <th>Student name</th>             
                                    
                                    <th>Course</th>
                                    <th>Form No</th>
                                     <th>Amount</th>
                                     <th>Mobile no</th>
                                    <th>Email</th>
									<?php 
										if($seg !='online'){ ?>
                                    <th>Action</th>
									<?php } ?>
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php
                           
                            $j=1;  
                            //print_r($eventList);
                            if(!empty($student_prospectus_fee_details)){
                            for($i=0;$i<count($student_prospectus_fee_details);$i++)
                            {
                           // echo $student_prospectus_fee_details[$i]['sprogramm_name'];
                            ?>
                            <tr>
                                <td><?=$j?></td>
                                <?php if($this->session->userdata("role_id")=='1'){?>
								<?php 
										if($seg !='online'){ ?>
                                    <td><?=$student_prospectus_fee_details[$i]['fname']."&nbsp;".$student_prospectus_fee_details[$i]['lname']?></td>
										<?php } }?> 
<?php 
										if($seg =='online'){ ?>
                                    <td><?=$student_prospectus_fee_details[$i]['receipt_no']?></td>     
										<?php }?>										
                                <td><?=$student_prospectus_fee_details[$i]['student_name']?></td>                      
                                <!-- <td><?php if($student_prospectus_fee_details[$i]['course_type']=='P') 
                                {echo 'Part time';}  
                                else { echo 'Regular';} ?>
                                </td>  -->  
                                <td><?=$student_prospectus_fee_details[$i]['sprogramm_name']?></td>   
                                <td><?=$student_prospectus_fee_details[$i]['adm_form_no']?></td>
                                <td><?=$student_prospectus_fee_details[$i]['amount']?></td> 
                                <td><?=$student_prospectus_fee_details[$i]['mobile1']?></td> 
                                <td><?=$student_prospectus_fee_details[$i]['email']?></td>   
								
                                <?php 
								if($seg !='online'){
								if($student_prospectus_fee_details[$i]['admission_mode']=='P') 
                                { 
								  $data='1';
                                 $id=base64_encode($data);
								 
                                 $adm_form_no=base64_encode($student_prospectus_fee_details[$i]['adm_form_no']);
                                 $pid=base64_encode($student_prospectus_fee_details[$i]['id']);?> 
                                     <td><?php echo $data='1'; ?>
                                        <!--a href="<?=base_url($currentModule.'/student_prospectus_downloadpdf/'.$id.'/'.$adm_form_no.'')?>" class="btn btn-sm btn-primary"><span class="fa fa-download"></span></a-->&nbsp;<a href="<?=base_url($currentModule.'/student_prospectus_receiptpdf/'.$pid."/".$adm_form_no."")?>" target="_blank" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i></a></td>

                                <?php  } else { 
								 $data='2';
                                $id=base64_encode($data);
                                $barcode=base64_encode($student_prospectus_fee_details[$i]['adm_form_no']);
                                $pid=base64_encode($student_prospectus_fee_details[$i]['id']);
								$adm_form_no=base64_encode($student_prospectus_fee_details[$i]['adm_form_no']);
								?>
                                     <td><?php  $adm_form_no; ?><!--a href="<?=base_url($currentModule.'/student_prospectus_downloadpdf/'.$id."/".$adm_form_no."")?>" class="btn btn-sm btn-primary"><span class="fa fa-download"></span></a--><a href="<?=base_url($currentModule.'/student_prospectus_receiptpdf/'.$pid."/".$adm_form_no."")?>" target="_blank"class="btn btn-sm btn-primary"><i class="fa fa-eye"></i></a></td>
                                    <?php }
								}
									?>
                               
                            </tr>
                            <?php
                            $j++;
                            }
                            }else{
                                echo '<tr><td colspan="7">No data found</td></tr>';
                            }
                            ?>                            
                        </tbody>
                    </table>                    
                    <?php //} ?>
                </div>
                </div>
            </div>
            </div>    
        </div>
    </div>
</div>
 <div id="myModal" class="modal fade">
        <div class="modal-dialog"  style="width:950px;" >
            <div class="modal-content" >
                <!-- Content will be loaded here from "remote.php" file -->
            </div>
        </div>
    </div>
   
<script>
$('.modal').on('hidden.bs.modal', function(e)
    { 
        $(this).removeData();
    }) ;
$("#texport").click(function(){  
       
            var url  = "<?=base_url().strtolower($currentModule).'/export_excel_forprospectus/'?>";    
          window.location.href = url;
    });
    
    $('#ic_list').change(function(e){

var ic = $('#ic_list').val(); 
      
            var url  = "<?=base_url().strtolower($currentModule).'/get_event_list_search/'?>"; 
            var data = {ic:ic};    
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
                    
                },
                error: function(data)
                {
                    alert("Page Or Folder Not Created..!!");
                }
            });

});
  $("div.holder").jPages
  ({
    containerID : "itemContainer"
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

<script type="text/javascript">
    $(document).ready(function() {
    var activeSystemClass = $('.list-group-item.active');

    //something is entered in search form
    $('#system-search').keyup( function() {
       var that = this;
        // affect all table rows on in systems table
        var tableBody = $('.table-list-search tbody');
        var tableRowsClass = $('.table-list-search tbody tr');
        $('.search-sf').remove();
        tableRowsClass.each( function(i, val) {
        
            //Lower text for case insensitive
            var rowText = $(val).text().toLowerCase();
            var inputText = $(that).val().toLowerCase();
            if(inputText != '')
            {
                $('.search-query-sf').remove();
                tableBody.prepend('<tr class="search-query-sf"><td colspan="9"><strong>Searching for: "'
                    + $(that).val()
                    + '"</strong></td></tr>');
            }
            else
            {
                $('.search-query-sf').remove();
            }

            if( rowText.indexOf( inputText ) == -1 )
            {
                //hide rows
                tableRowsClass.eq(i).hide();
                
            }
            else
            {
                $('.search-sf').remove();
                tableRowsClass.eq(i).show();
            }
        });
        //all tr elements are hidden
        if(tableRowsClass.children(':visible').length == 0)
        {
            tableBody.append('<tr class="search-sf"><td class="text-muted" colspan="8">No records  found.</td></tr>');
        }
    });
});
    </script>