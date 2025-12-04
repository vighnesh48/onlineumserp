
<?php //echo  "<pre>"; print_r($unittest); die;
$role_id = $this->session->userdata('role_id');
 ?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#"></a></li>
        <li class="active"><a href="#"></a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Attached Documents</h1>
            <div class="col-xs-12 col-sm-8">
                
            </div>
        </div>
        <div class="row ">
            <div class="col-sm-12">&nbsp;</div>
        </div>
        
    
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                    
                <div class="panel-heading">
                    
                </div>
           
                <div class="panel-body" style="overflow:scroll;height:800px;">
                    <div class="table-info">    
                    <?php //if(in_array("View", $my_privileges)) { ?>
                     <div class="row ">
            <div class="col-sm-4"><label name="" id=""><strong>Name :</strong> <?=$appli['student_name'];?></label> </div> 
              <div class="col-sm-4"><label name="" id=""><strong>Department : </strong><?=$appli['department'];?></label> </div> 
               <div class="col-sm-4"><a href="https://erp.sandipuniversity.com/phd" ><label name="" id="" class="pull-right"><input type="button" class="btn btn-primary" value="Back"></label></a> </div> 
        </div>
                    <table  id="search-table" class="table table-bordered table-list-search">
                        <thead>
                            <tr>
                                    <th>Sr. No.</th>
                                    
                                    <th>Name</th>
                                      <th>Document</th>
                            </tr>
                            
                        </thead>
                        <?php
                        $j=1;
                        ?>
                        <tbody id="itemContainer">
                                   <tr  class="myHead">
                                <td><?=$j?></td>          
                                   
                       
                                            <td>Application Form</td> 
                     
                         <td><a href="https://www.sandipuniversity.com/phdsunpet/uploads/payments/admform_<?=$appli['phd_id'];?>.pdf" target="_blank"><i class="fa fa-file-pdf-o" aria-hidden="true" style="font-size:14px;color:red;"></i></a></td> 
                     
                        
                            </tr>
                            <?php
                            $j++;  
						if(!empty($documents)){							
                            for($i=0;$i<count($documents);$i++)
                            {
                               
                            ?>
                            <tr  class="myHead">
                                <td><?=$j?></td>          
                                   
                       
                                            <td><?=$documents[$i]['doc_name']?></td> 
                     
                         <td><a href="https://www.sandipuniversity.com/phdsunpet/uploads/phd/<?=$documents[$i]['doc_file']?>" target="_blank"><i class="fa fa-file-pdf-o" aria-hidden="true" style="font-size:14px;color:red;"></i></a></td> 
                     
                        
                            </tr>
                            <?php
                            $j++;
                            }
						}
                            ?> 
      
                            
                         
                            
                            
                        </tbody>
                    </table>
                    
                          <form name="editfrm" method="POST" action="<?=base_url()?>phd/update_verification_status"  onsubmit="">
                                   
                                   
								   <div class="form-group">
								       <input type="hidden" name="reg_id" value="<?=$appli['phd_id'];?>">
                                            <label class="col-sm-3" for="exampleInputEmail1"> Verification Status </label>
                                             <div class="col-sm-3">
                                              
                                             <select name="upstatus" id="upstatus" class="form-control" required>
                                         
                                             <option value="V" <?php if($appli['verification']=="V"){echo "selected";}  ?>> Verified </option> 
                                             <option value="R" <?php if($appli['verification']=="R"){echo "selected";}  ?>>Rejected </option> 
                                             <option value="P" <?php if($appli['verification']=="P"){echo "selected";}  ?>>Pending</option>  
                                      
                                                 </select>
                                            
                                            
                                            </div>
                                        </div>
										
							
   
                                          <button type="submit" class="btn btn-primary" id="updatePayment1" >Update Status</button>
                                         
                                        </form>
                                   
                    <?php //} ?>
                </div>
                </div>
            </div>
            </div>    
        </div>
    </div>
</div>







<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">






<script type="text/javascript">
		$(document).ready(function() {
   
		    
		    
		    

});
		</script>
