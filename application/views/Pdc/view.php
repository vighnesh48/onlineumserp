<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Account</a></li>
        <li class="active"><a href="#">PDC Details</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;PDC</h1>

            <div class="col-xs-12 col-sm-8">
                <div class="row"> 
                                         <?php 
   if($this->session->flashdata('success')){
 ?>
   <div class="alert alert-success"> 
     <?php  echo $this->session->flashdata('success'); ?>
 </div>
<?php }   
else if($this->session->flashdata('error')){
?>
 <div class = "alert alert-danger">
   <?php echo $this->session->flashdata('error'); ?>
 </div>
<?php } ?>                   
                    <hr class="visible-xs no-grid-gutter-h">
                 
                    <div class="pull-right col-xs-12 col-sm-auto"><a style="width: 100%;" class="btn btn-primary btn-labeled" href="<?=base_url($currentModule."/add")?>"><span class="btn-label icon fa fa-plus"></span>Add PDC</a></div>                        
                    <div class="visible-xs clearfix form-group-margin"></div>

                    <!-- <?php if(in_array("Search", $my_privileges)) { ?> -->
                    <!-- <form class="pull-right col-xs-12 col-sm-6" action="">
                        <div class="input-group no-margin">
                            <span style="border:none;background: #fff;background: rgba(0,0,0,.05);" class="input-group-addon"><i class="fa fa-search"></i></span>
                            <select id="search_me" name="search_me" style="border:none;background: #fff;background: rgba(0,0,0,.05);" class="form-control no-padding-hr" placeholder="Search...">
                                <option value="">Select Title</option>
                                <?php print_r($pdc_details);
                                die;
                                    for($i=0;$i<count($pdc_details);$i++)
                                    {
                                ?>
                                <option value="<?=$course_details[$i]['pdc_id']?>"><?=$course_details[$i]['course_name']?></option>
                               <!--  <?php
                                    }
                                ?> -->
                            </select>
                        </div>
                    </form> -->
                   <!--  <?php } ?> -->
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
                        <span class="panel-title">List</span>
                        <!-- <div class="holder"></div> -->
                </div>



                <div class="panel-body">
                    <div class="table-info" style="overflow-x:auto;"> 

             
                    <table class="table table-bordered table-striped" id="example">
                          
                        <thead style="width:100%">
                            <tr>
                                    <th>#</th>
                                     <th>Prn</th>
                                    <th>Student Name</th>
                                    <th>School</th>
                                    <th>Stream</th>
                                    <th  width="5%">year</th>
                                    <th  width="5%">semester</th>
                                    <th  width="5%">Amount</th>
                                    <th>Chq No</th>
                                    <th>Chq Date</th>
                                    <th >Chq Bank</th>
                                    <th  width="5%">Deposite Status</th>
                                    <th  width="5%">Encash Status</th>
                                     <th>Action</th>
                                   
                                    
                            </tr>
                        </thead>
                           <tbody id="itemContainer">
                            <?php
                           
                            $j=1;  
                            if(!empty($pdc_details)){
                            for($i=0;$i<count($pdc_details);$i++)
                            { $pdcid=$pdc_details[$i]['pdc_id'];
                            

                            		$bb=base_url($currentModule."/change_pdc_deposite_status/".$pdcid);
                            		$encash=base_url($currentModule."/change_pdc_encash_status/".$pdcid);
	                               if($pdc_details[$i]['deposite_status']=='P')
	                               {
	                                $v='<a href="'.$bb.'"><button class="btn-primary"> 
	                                    Pending 
	                                </button> </a>';

	                               }
	                               else
	                               { 	$v='<span style="font-weight= bold;">Done <br/>'.date("d-m-Y",strtotime($pdc_details[$i]['deposited_on'])).'</span>';

	                               }
	                               if($pdc_details[$i]['encash_status']=='P' && $pdc_details[$i]['deposite_status']=='Y' )
	                               {
	                                //$encash_status='<a href="'.$encash.'"><button class="btn-primary">Pending </button> </a>';
                                    //$encash_status='<button class="btn btn-success btn-lg"  data-toggle="modal" data-target="#modalForm">
    
                                    $encash_status='<a href="#" data-id="'.$pdcid.'" data-toggle="modal" data-target="#modalForm" class="modalLink"><button class=btn-primary">Pending</button></a>';


	                               }
                                   else if($pdc_details[$i]['encash_status']=='P')
                                   {
                                     $encash_status='Pending';
                                   }
                                   else if($pdc_details[$i]['encash_status']=='N' )
                                   {    
 
                                    
                                        
                                     $encash_status='No<br/>'.date("d-m-Y",strtotime($pdc_details[$i]['encashed_on'])).'<br/>Reason:'.$pdc_details[$i]['remark'];
                                   }
	                               else
	                               { 	$encash_status='<span style="font-weight= bold;">Done <br/>'.date("d-m-Y",strtotime($pdc_details[$i]['encashed_on'])).'</span>';

	                               }
                            ?>

                            <tr <?=$pdc_details[$i]["status"]=="N"?"style='background-color:#006400'":""?>>
                                 <td><?=$j?></td>
                             <td><?=$pdc_details[$i]['enrollment_no']?></td>
                                <td><?=$pdc_details[$i]['first_name'].' '.$pdc_details[$i]['middle_name'].' '.$pdc_details[$i]['last_name']?></td>
                                <td><?=$pdc_details[$i]['school_name']?></td>                              
                                <td><?=$pdc_details[$i]['stream_name']?></td>
                                  <td  width="5%"><?=$pdc_details[$i]['academic_year']?></td>
                                <td  width="5%"><?=$pdc_details[$i]['admission_semester']?></td>
                                <td  width="5%"><?=$pdc_details[$i]['amount']?></td>
                                <td  width="5%"><?=$pdc_details[$i]['chq_dd_no']?></td>
                                <td  width="5%"><?=$pdc_details[$i]['chq_dd_date']?></td>
                                 <td  width="5%"><?=$pdc_details[$i]['bank_name']?></td>
                                  <td  width="5%"><?=$v?></td>
                                  <td  width="5%"><?=$encash_status;?></td>
                                
                                <td>
                                    <?php if($pdc_details[$i]['deposite_status']=='Y' && ($pdc_details[$i]['encash_status']=='Y' || $pdc_details[$i]['encash_status']=='N')) { echo "";} else{ ?>
                                   
                                    <a href="<?=base_url($currentModule."/edit_pdc/".$pdc_details[$i]['pdc_id'])?>" class="<?=$dis_cls?>"><i class="fa fa-edit <?=$dis_cls?>" ></i></a>&nbsp;|&nbsp;
                                      <a href="<?=base_url($currentModule."/delete_pdc/".$pdc_details[$i]['pdc_id'])?>" class="<?=$dis_cls?>"><i class="fa fa-trash <?=$dis_cls?>" ></i></a>
                                  <?php } ?>

                               
                                    
                                </td>
                           
                            </tr>
                            <?php
                            $j++;
                            }
                            }else{
                                echo "<tr><td colspan=11>No data found.</td></tr>";
                            }
                            ?>                            
                        </tbody>
                    </table>                    
                 
                </div>
                </div>


                <!-- Modal -->
<div class="modal fade" id="modalForm" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Encash Status</h4>
            </div>
            
            <!-- Modal Body -->
            <div class="modal-body">
                <p class="statusMsg"></p>
               <div class="row">
                <div class="col-sm-12"><div class="col-sm-4"></div><div class="col-sm-4"><button class="btn-primary" id="yes"> 
                                        Yes 
                                    </button>&nbsp;<button class="btn-primary" id="No"> 
                                       NO
                                    </button></div><div class="col-sm-4"></div>
               </div>
           </div>
           <br/>
                <div id="form_show" style="display:none;">
                <form action="<?php echo base_url();?>pdc/submit_pdc_data"  method="post">
                    <input type="hidden" id="getpdcid" name="getpdcid" />
                    <input type="hidden" id="yesdata" name="yesdata" />
                    <input type="hidden" id="nodata" name="nodata" />
                 
                    <div class="form-group" id="getmsg">
                      
                    </div>
                     <input type="submit" class="btn btn-primary" value="Submit">
                </form>
            </div>
            </div>
            
            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
               <!--  <button type="button" class="btn btn-primary submitBtn" onclick="submitContactForm()">SUBMIT</button> -->
            </div>
        </div>
    </div>
</div>

            
            </div>
            </div>    
        </div>
    </div>
</div>
<script>
  $("div.holder").jPages
  ({
    containerID : "itemContainer"
  });
  $("#search_me").select2({
      placeholder: "Enter title",
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
                    for(i=0;i<array.course_details.length;i++)
                    {
                        str+='<tr style="display: table-row; opacity: 1;">';
                        str+='<td>'+(i+1)+'</td>';                                                                                                
                        str+='<td>'+array.course_details[i].course_code+'</td>';
                        str+='<td>'+array.course_details[i].course_name+'</td>';
                        switch (array.course_details[i].course_type)
                        {
                            case "E":
                                str2= "Engineering";
                                break;
                            case "P":
                                str2= "Polytechnic";
                                break;
                            case "PH":
                                str2= "Pharmacy";
                                break;
                            case "M":
                                str2= "Management";
                                break;
                        }
                        //str+='<td>'+array.course_details[i].course_type+'</td>';
                        str+='<td>'+str2+'</td>';
                        str+='<td>'+array.course_details[i].duration+" Years "+'</td>';
                        str+='<td>';
                        str+='<a href="<?=base_url(strtolower($currentModule))?>/edit/'+array.course_details[i].course_id+'"><i class="fa fa-edit"></i></a>';
                        str+='<a href="disable/'+array.course_details[i].course_id+'"><i title="Disable" class="fa fa-ban"></i></a>';
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

<script>

    $(".modalLink").click(function () {
    var passedID=$(this).attr('data-id');
    $("#getpdcid").val(passedID);
    });

      $("#yes").click(function () {
        $("#form_show").show();
        $("#yesdata").val('Yes');
        $("#nodata").val('');
        $("#getmsg").html('<label for="inputMessage">Message</label><textarea class="form-control" id="inputMessage" name="inputMessage" placeholder="Enter your message"></textarea>');
    });

       $("#No").click(function () {
        $("#form_show").show();
        $("#yesdata").val('');
        $("#nodata").val('No');
        $("#getmsg").html('<label for="inputMessage">Message</label><textarea class="form-control" id="inputMessage" name="inputMessage" placeholder="Enter your message" required></textarea>');
    });

    $('#example').DataTable( {
        dom: 'Bfrtip',
        "pageLength": 50,

        buttons: [
            {
                extend: 'excel',
                messageTop: 'pdc student list',
                exportOptions: {
                     columns: [ 0,1,2,3,4,5,6,7,8,9,10,11]
                }
            }
        ]
    } );
    </script>