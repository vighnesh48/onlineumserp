<?php //error_reporting(E_ALL); ini_set('display_errors', 1);?>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<script src="<?=base_url('assets/javascripts')?>/jquery.table2excel.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Student</a></li>
        <li class="active"><a href="#">Payment History</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Payment List</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                    <?php //if(in_array("Add", $my_privileges)) { ?>
                       
                    <div class="visible-xs clearfix form-group-margin"></div>
                    <?php// } ?>
                    <?php //if(in_array("Search", $my_privileges)) { ?>
                   <!--<form class="pull-right col-xs-12 col-sm-6" action="">
                        <div class="input-group no-margin">
                            <span style="border:none;background: #fff;background: rgba(0,0,0,.05);" class="input-group-addon"><i class="fa fa-search"></i></span>
                            <select id="search_me" name="search_me" style="border:none;background: #fff;background: rgba(0,0,0,.05);" class="form-control no-padding-hr" placeholder="Search...">
                                <option value="">Select Title</option>
                                
                            </select>
                        </div>
                    </form>-->
                    <?php //} ?>
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-sm-12">&nbsp;</div>
        </div>
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
         
            <div class="table-info panel-body" style="overflow:scroll;height:800px;">  
	
			
                <div class="col-lg-12">
                    <div class="table-info" id="stddata" >    
				<?php 	
					if(count($pay_list)>0){
				//fees_paid_type receipt_no,amount,academic_year,college_receiptno,chq_cancelled,is_deleted,bank_ref_num,
				?>
			
                   <table class="table table-bordered" id="example">
                        <thead>
                            <tr>
                                   
                                    <th>S.No.</th>
                                    <th>Receipt No.</th>
                                    <th>Fee Type</th>
                                    <th>Academic year</th>
                                    <th>Amount</th>
                                    <th>Payment Mode </th>
									<th>Payment Date</th>
<!--									<th>Payment Status </th>
-->                                    <th>Verification Status</th>
                                    <th>Receipt</th>
								
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php
                            
                          
                            $j=1;                            
                            for($i=0;$i<count($pay_list);$i++)
                            {
                                
                            ?>
							 <?php //if($pay_list[$i]['ro_flag']=='on')
							 // $bg="bgcolor='#e6eaf2'";
								//  else $bg="";
								  ?>								
                            <tr <?php //$bg ?> <?php //$pay_list[$i]["payment_status"]=="N"?"style='background-color:#FBEFF2'":""?>>
                               <td><?=$j?></td>
                        
                                 <td><?=$pay_list[$i]['college_receiptno']?></td> 
								 <td><?php if($pay_list[$i]['type_id']=="2"){ echo 'Admission Fee';}elseif($pay_list[$i]['type_id']=="5"){echo 'Exam Fee';}?></td> 
                                <td><?php
								echo $pay_list[$i]['academic_year'];
								?></td>
                                <td>
							
							<?php
								echo $pay_list[$i]['amount'];
								?>
								</td> 
								 
								<td><?=$pay_list[$i]['fees_paid_type']?></td> 
								<td><?=$pay_list[$i]['created_on']?></td> 
										
<!--								<td><?=$pay_list[$i]['is_deleted']?></td>                                                    
-->                                <td>
							<?php if($pay_list[$i]['is_deleted']=="N"){echo "Approved";} else{ echo "Pending";}?></td>
								<td>
								   
<!--				 <a href="<?php //echo base_url();?>/uploads/online_payment/<?php //echo $pay_list[$i]['bank_ref_num']?>.pdf" target="_blank"><i class="fa fa-file-pdf-o" style="color:red"></i></a>
-->								   
								    
								    </td>								
                           
                             
                            </tr>
                            <?php
                            $j++;
                            }
                            ?>                            
                        </tbody>
                    </table>               
                    <?php }
                    
                    ?>
                </div>
                </div>
                </div>
            </div>
            </div>    
        </div>
    </div>
</div>
