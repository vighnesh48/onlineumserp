<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>

<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
	//print_r($hostel_details);
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="#">Add Item</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Challan</h1>
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
                    <div class="panel-heading">
                            <span class="panel-title">Challan Details</span>
                    </div>
                    
                    
                    
                    <div class="panel-body">
                    <div class="table-info">    
                    <?php  //if(in_array("View", $my_privileges)) { ?>
                    <table class="table table-bordered" id="example">
                        <thead>
                            <tr>
                                    <th>#</th>
                                    <th>Caution&nbsp;No</th>
                                    <th>Hostel</th>
                                    <th>Floor</th>
                                    <th>Room&nbsp;No</th>
                                    <th>prn</th>
                                    <th>student&nbsp;name</th>      
                                    <th>Item&nbsp;type</th> 
                                    <th>Item&nbsp;Name</th>                               
                                    <th>Item&nbsp;Amount</th>                                    
                                    <th>academic&nbsp;year</th>
                                   
                                    <th>Deposite</th>
                                    <th>Pay</th>
                                    <th>remark</th>
                                                                                                                                        
                                    <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php
                            $j=1;                            
                            foreach($university_challan_list as $list)
                            {
                                
                            ?>
                            <tr <?=$list["status"]=="N"?"style='background-color:#FBEFF2'":""?>>
                                <td><?=$j?></td>       
                                <td><?=$list['caution_no']?></td> 
                                <td><?=$list['hostel_id']?></td>
                                <td><?=$list['floor']?></td>
                                <td><?=$list['room_no']?></td>                                                        
                                <td><?=$list['enrollment_no']?></td>
                                <td><?=$list['first_name'].''.$list['last_name']?></td>
                                <td><?=$list['Item_type']?></td>
                                <td><?=$list['itname']?></td> 
                                <td><?=$list['Item_Amount']?></td>                               
                                <td><?=$list['academic_year']?></td> 
                               
                                <td><?=$list['caution_dposite']?></td> 
                                <td><?=$list['current_pay']?></td> 
                                <td><?=$list['remark']?></td> 
                                
                                <td>
                                    <?php //if(in_array("Edit", $my_privileges)) { ?>
                               <a href="<?=base_url($currentModule."/Challan_university/".$list['caution_hid'])?>">Pay</a>                                                                        
                                    <?php //} ?>
                                    <?php // if(in_array("Delete", $my_privileges)) { ?>
                                    <!--<a href='<?=base_url($currentModule)."/"?><?=$list["status"]=="Y"?"disable/".$list["caution_hid"]:"enable/".$list["item_id"]?>'><i class='fa <?=$list["status"]=="Y"?"fa-ban":"fa-check"?>' title='<?=$list["status"]=="Y"?"Disable":"Enable"?>'></i></a>-->
                                    <?php //} ?>
                                </td>
                            </tr>
                            <?php
                            $j++;
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
<script type="text/javascript">
$("#Hostel").on('change',function(){
	//alert();
	var id=$(this).val();
	$.ajax({
		'url': '<?php echo base_url()?>Caution_money/Get_floor',
		'type':'POST',
		'data':'id='+id,
		'success' : function(data){ 
	    $("#HFloor").html(data);
		}
		});
	
	
	
})
$(document).ready(function () {
    var table = $('#example').DataTable({
        orderCellsTop: true,
        fixedHeader: true,
		dom: 'lBfrtip',
	    "bPaginate": false,
		"bInfo": false,
        buttons: [
            'excel'
        ],
		lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
    });
});
</script>