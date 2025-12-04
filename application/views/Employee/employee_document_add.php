<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>


<style>
.attexl table{
	 border: 1px solid black;
}
.attexl table th{
 border: 1px solid black;
    padding: 5px;
    background-color:grey;
    color: white;
}
.attexl table td{
	 border: 1px solid black;
    padding: 5px;
}
</style>


<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Employee</a></li>
        <li class="active"><a href="#">Employee Document Add</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Employee Document Add</h1>
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
                                                               
                             <div id="dashboard-recent" class="panel-warning">   
                               <div class="panel">
                            	<div class="panel-heading"><strong>Document Add</strong></div>
                                <div class="panel-body">
								<span id="flash-messages" style="color:red;padding-left:110px;"><?php echo $this->session->flashdata('message1'); ?></span>
                                <div class="panel-padding no-padding-vr">
                            <div class="form-group">
                              <div class="row"></div>
							  <div class="portlet-body form">
							  <form id="form" name="form" action="<?=base_url($currentModule.'/employee_document_submit')?>"  method="POST"  enctype="multipart/form-data">
							    <input type="hidden" name="er_id" value="<?php echo $emp_details[0]['emp_reg_id']; ?>"/>
							    <?php 
							   echo $err;
							    ?>
								<div class="form-body">
							
								        <div class="form-group">
										<div class="row">
									
										    
										     <div class="form-group">
                                <label class="col-md-2">Staff Id</label>
                                <div class="col-md-2">
                                  <input type="text" class="form-control" readonly required name="staffid" value="<?php echo $emp_details[0]['emp_id']; ?>" id="staffid" />
                                </div>
                                 <label class="col-md-2">Name</label>
                                 <div class="col-md-4" >
   <input type="text" class="form-control" readonly required name="ename" value="<?php echo $emp_details[0]['fname'].' '.$emp_details[0]['lname']; ?>" id="nameid" />                  
                                       </div>     
                              </div>
										     <div class="form-group">

<table class="table table-bordered">
                        <thead>
                            <tr>
                                    
                                    <th width='5%'>Sr.No</th>
<th width='55%'>Name</th>
                                    <th width='20%'>Status</th>
                                    <th width='15%'>Original or Xerox</th>                                  
                
                                    <th width='15%'>Upload</th>
                  
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
<?php 
$i=1; //print_r($doc_list);
foreach($doc_list as $doc){
	
if($doc['doc_status']=='Submitted'){
    $str1 ='selected';
}else
	$str1 ='';


if($doc['doc_status']=='Pending'){
    $str2 ='selected';
}else
	$str2 ='';

if($doc['doc_status']=='Not Required'){
    $str3 ='selected';
}
else
	$str3 ='';

if($doc['doc_ox']=='O'){
    $ox = 'selected';
}else
	 $ox='';
 
 
if($doc['doc_ox']=='X'){
    $ox1 = 'selected';
}else
	 $ox1='';

echo "<input type='hidden' name='doc_id[]' value='".$doc['did']."' /><tr>";

echo "<td>".$i."</td>";
echo "<td>".$doc['document_name']."</td>";
echo "<td>";
echo "<select class='form-control' required onchange='set_file_validation(".$doc['did'].",this.value)'  name='dstatus_".$doc['did']."'> <option value=''>Select</option><option value='Submitted' ".$str1." >Submitted</option><option value='Pending' ".$str2.">Pending</option><option ".$str3." value='Not Required'>Not Required</option> </select>  ";
echo "</td>";
echo "<td>";
echo '<select class="form-control" name="ox_'.$doc['did'].'" >';
                                    echo '<option value="">Select</option>
                                    <option value="O" '.$ox.'>O</option>
                                    <option value="X" '.$ox1.'>X</option>
                                  </select>';
echo "</td>";
echo "<td>";
echo "<input type='file' accept='application/pdf,application/msword,
  application/vnd.openxmlformats-officedocument.wordprocessingml.document' name='dupload_".$doc['did']."' id='dupload_".$doc['did']."' />" ;
if(!empty($doc['doc_file_path'])){
//echo "<br/>";
    $bucketname = 'uploads/employee_documents/';
    //site_url()."Upload/download_pdfdocument/".$doc['doc_file_path']."?b_name='.$bucketname;
echo "<a target='_blank' class='pull-right' style='margin-top:-20px;' href='" . site_url()."Upload/download_pdfdocument/".$doc['doc_file_path']."?b_name=".$bucketname."' ><i class='fa fa-download' aria-hidden='true' style='font-size:14px;color:#27c9ec;'></i></a>";
}
echo "</td>";
echo "</tr>";
$i++;
}


?>
</tbody>
                    </table>     
                         </div>
										    
										    
									
																	
										</div>
																 
                                  </div>							  
								
<div class="form-group">
								   <div class="col-md-3" ></div>
                                      <div class=" col-md-2">  
                                            <button type="submit" id="submit" class="btn btn-primary form-control" >Save</button>
                                        </div>
                                        <div class=" col-md-2">  
                                            <button type="button" id="cancel" class="btn btn-primary form-control" onclick="window.location='<?=base_url($currentModule)?>/employee_document_list'" >Cancel</button>
                                        </div>
                                    </div>								  
                            
							
								
                                    </form>
									
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
</div>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


<script type="text/javascript">
    function set_file_validation(e,s){
        if(s=='Submitted'){
            $('#dupload_'+e).prop('required',true);
        }else{
            $('#dupload_'+e).prop('required',false);
        }
    }

</script>

