<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<?php //print_r($my_privileges); die; ?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Masters</a></li>
         <li class="active"><a href="<?=base_url($currentModule)?>">ICEMELT-2018 </a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;ICEMELT Payment Details</h1>
			
			<div class="col-xs-12 col-sm-8">
                <div class="row"> 
					   <hr class="visible-xs no-grid-gutter-h">
                    
                    <div class="pull-right col-xs-12 col-sm-auto">
					
							<input type="text" class="form-control" name="sss" id="sss" placeholder="Search">                                     
			
					</div>                        
                    <div class="visible-xs clearfix form-group-margin"></div>
                    
                    
                   
                </div>
            </div>
			
			<span id="flash-messages" style="color:Green;padding-left:50px;">
						 <?php if(!empty($this->session->flashdata('message1'))){ echo $this->session->flashdata('message1'); } ?></span>
					<span id="flash-messages" style="color:red;padding-left:50px;">
						 <?php if(!empty($this->session->flashdata('message2'))){ echo $this->session->flashdata('message2'); } ?></span>

        </div>
       
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                <div class="panel-heading">
                        <span class="panel-title">ICEMELT Student List</span>
                        
                </div>
				
                <div class="panel-body" style="overflow-x:scroll;height:500px;">
                    <div class="table-info" >    
                       <table class="table table-bordered" style="width:2000px;">
                        <thead>
                            <tr>
								<th>#</th>
								<th>Paper ID</th>
								<th>Paper Title</th>
								<th>Author Name</th>
								<th>Gender</th>
								<th>Mobile</th>
								<th>Email</th>
								<th>Nationality</th>
								<th>Category</th>
								<th>Receipt No.</th>
								<th>Transaction Id</th>
								<th>Amount</th>
								<th>Payment Mode</th>
								<th>Bank Ref No.</th>
								<th>Payment Status</th>
                            </tr>
                            
                        </thead>
                        <tbody id="itemContainer">
                            <?php
                            $j=1;  //'DI','DA','S','OS','VP','AP'
							$q_arr=array("DI"=>'Delegate from Industry',"DA"=>'Delegate from Academic & Research Institute',"S"=>'Student (PG & above)',"OS"=>'Other student ( other than above mentioned)',"AP"=>'Accompanying person',"VP"=>'Virtual Presenter');
						if(!empty($phd_data)){							
                            for($i=0;$i<count($phd_data);$i++)
                            {
                               
                            ?>
                            <tr  class="myHead">
								<td><?=$j?></td>
								
								<td><?=$phd_data[$i]['paper_id']?></td>
								<td><?=$phd_data[$i]['ptitle']?></td>
								
								<td><?=$phd_data[$i]['author_name']?></td> 
								<td><?=$phd_data[$i]['gender']=='M'?'Male':'Female'?></td>
								<td><?=$phd_data[$i]['mobile1']?></td> 
								<td><?=$phd_data[$i]['email']?></td>
								 
								<td><?=$phd_data[$i]['nationality']=='I'?'Indian':'Foreigner'?></td>
								<td><?=$q_arr[$phd_data[$i]['reg_category']]?></td> 
								<td><?=$phd_data[$i]['receipt_no']?></td>
								<td><?=$phd_data[$i]['txtid']?></td>
								 <td><?=$phd_data[$i]['amount']?></td>
								
								 
								<td><?=$phd_data[$i]['payment_mode']?></td>
								
								
								<td><?=$phd_data[$i]['bank_ref_num']?></td>
                                <td><?=$phd_data[$i]['payment_status']?></td>
                            </tr>
                            <?php
                            $j++;
                            }
						}else{ echo "<tr><td colspan=8>No data found</td></tr>";}
                            ?>                            
                        </tbody>
                    </table>                   
                
                </div>
                </div>
            </div>
            </div>    
        </div>
    </div>
</div>
<script>

$(document).ready(function(){
	    // Num check logic
  	$('.numbersOnly').keyup(function () {
    if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
       this.value = this.value.replace(/[^0-9\.]/g, '');
    } 
  	});
	
	
	$('#sss').keyup( function() {
    //alert('gg');
       var that = this;
        // affect all table rows on in systems table
        var tableBody = $('.table-bordered tbody');
        var tableRowsClass = $('.table-bordered tbody tr');
        $('.search-sf').remove();
        tableRowsClass.each( function(i, val) {        
            //Lower text for case insensitive
            var rowText = $(val).text().toLowerCase();
            var inputText = $(that).val().toLowerCase();
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