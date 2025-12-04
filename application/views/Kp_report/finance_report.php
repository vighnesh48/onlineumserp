<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<script>
$(document).ready(function() {

  $(".toggle-accordion").on("click", function() {
    var accordionId = $(this).attr("accordion-id"),
      numPanelOpen = $(accordionId + ' .collapse.in').length;
    
    $(this).toggleClass("active");

    if (numPanelOpen == 0) {
      openAllPanels(accordionId);
    } else {
      closeAllPanels(accordionId);
    }
  })

  openAllPanels = function(aId) {
    console.log("setAllPanelOpen");
    $(aId + ' .panel-collapse:not(".in")').collapse('show');
  }
  closeAllPanels = function(aId) {
    console.log("setAllPanelclose");
    $(aId + ' .panel-collapse.in').collapse('hide');
  }
     
});
</script>
<style>
.table{width:100%;} 
table{max-width: 100%;}
</style>
    <div class="page-header">
        <div class="row">
             <div class="col-sm-12">
                <div class="fancy-collapse-panel">
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                        <div class="panel panel-default">
                           
                             <div class="table-responsive">
                            <div class="panel-heading" role="tab" id="headingOne">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne1" aria-expanded="true" aria-controls="collapseOne1">Report Details:
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseOne1" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                <div class="panel-body table-reponsive" style="width:100%;overflow:scroll;height:700px;padding:0px;">
                                   <?php
                                   switch($rpt['report_type']){
                                       case "1":
                                       case "2":
                                       case "4":
                                   
                                   ?>
                                    <table class="table table-bordered">
            						<thead>
            							<tr>
            								<th width="5%">#</th>
            								<th width="10%">PRN</th>
            								<th width="30%">Student Name</th>
            								<th>Stream</th>
            								<th>Year</th>
            								<th>Paid by</th>
            								<th>DD/CHQ No</th>
            								<th>RCPT No</th>
            								<th>Date</th>
            								<th>Amount</th>
            								<th>Late Fees/Fine</th>
            								<th>Bank</th>
            								<th>Branch</th>
            								<th>Enrty By</th>
            								<th>Status</th>
            							</tr>
            						</thead>
            						<tbody class="valign-middle">
                                    <?php
                                    $i=1;
                                    
                                    foreach($acc_data as $row){
                                        if($row['chq_cancelled']=="N"){
                                            $a='<i class="fa fa-check-circle-o fa-2x" aria-hidden="true" style="color:green"></i>';
                                            $t="Accepted";
                                            
                                        }
                                        else{ 
                                            $a='<i class="fa fa-times-circle-o fa-2x" aria-hidden="true" style="color:red"></i>';
                                             $t="Cancelled";
                                        }
                                    echo' <tr data-toggle="collapse" data-target=".order'.$i.'">
                                        <td>'.$i.' </td>
                                         <td>'.$row['enrollment_no'].'</td>
                                         <td>'.$row['first_name'].' '.$row['middle_name'].' '.$row['last_name'].'</td>
                                          <td>'.$row['stream_short_name'].'</td>
                                           <td>'.$row['year'].'</td>
                                         <td>'.$row['fees_paid_type'].'</td>
                                         <td>'.$row['receipt_no'].'</td>
                                         <td>'.$row['college_receiptno'].'</td>
                                         <td>'.$row['fdate'].'</td>
                                         <td>'.$row['amount'].'</td>
                                         <td>'.$row['exam_fee_fine'].'</td>
                                         <td>'.$row['bank_name'].'</td>
                                         <td>'.$row['bank_city'].'</td> 
                                         <td>'.$row['username'].'</td> 
                                          <td data-toggle="tooltip" title="'.$t.'">'.$a.'</td> ';
                                         
                                        $i++;
                                    }
                                    if($i==1){
                                        echo'<tr><td colspan="15">Records not found.. </td></tr>';
                                    }
                                    ?>
                                   </tbody>
                                   </table>
                                   <?php
                                   break;
                                   case"3":
                                       ?>
                                        <table class="table table-bordered table-reponsive" style="width:200%">
            						<thead>
            							<tr>
            								<th width="5%">#</th>
            								<th width="10%">PRN</th>
            								<th width="30%">Student Name</th>
            								<th>Stream</th>
            								<th>Year</th>
            								<th>Paid by</th>
            								<th>DD/CHQ NO</th>
            								<th>RCPT NO</th>
            								<th>Date</th>
            								<th>Amount</th>
            								<th>Bank</th>
            								<th>Branch</th>
            								<th>Enrty By</th>
            								<th>Status</th>
            							</tr>
            						</thead>
            						<tbody class="valign-middle">
                                    <?php
                                    $i=1;
                                    
                                    foreach($acc_data as $row){
                                        if($row['chq_cancelled']=="E"){
                                            $a='Excess';
                                          
                                            
                                        }
                                        else{ 
                                            $a='Carry Forward';
                                        }
                                      echo' <tr data-toggle="collapse" data-target=".order'.$i.'">
                                        <td>'.$i.' </td>
                                         <td>'.$row['enrollment_no'].'</td>
                                         <td>'.$row['first_name'].' '.$row['middle_name'].' '.$row['last_name'].'</td>
                                         <td>'.$row['stream_short_name'].'</td>
                                          <td>'.$row['year'].'</td>
                                         <td>'.$row['fees_paid_type'].'</td>
                                         <td>'.$row['receipt_no'].'</td>
                                         <td>'.$row['college_receiptno'].'</td>
                                         <td>'.$row['fdate'].'</td>
                                         <td>'.$row['amount'].'</td>
                                         <td>'.$row['bank_name'].'</td>
                                         <td>'.$row['bank_city'].'</td> 
                                         <td>'.$row['username'].'</td> 
                                         <td>'.$a.'</td> ';
                                         
                                        $i++;
                                    }
                                    if($i==1){
                                        echo'<tr><td colspan="15">Records not found.. </td></tr>';
                                    }
                                    ?>
                                   </tbody>
                                   </table>
                                       <?php
                                       break;
                                       }
                                   ?>
                                </div>
                                </div>
                            </div>
                           
                        </div>
             </div>   
                       
                    </div>
                </div>
           
        </div>
            
    </div>
<style>
tr.collapse.in {
  display:table-row;
}

/* GENERAL STYLES */
body {
    
    font-family: Verdana;
}

/* FANCY COLLAPSE PANEL STYLES */
.fancy-collapse-panel .panel-default > .panel-heading {
padding: 0;

}
.fancy-collapse-panel .panel-heading a {
padding: 12px 35px 12px 15px;
display: inline-block;
width: 100%;
background-color:#136fab;
color: #ffffff;
font-size: 16px;
font-weight: 200;
position: relative;
text-decoration: none;

}
.fancy-collapse-panel .panel-heading a:after {
font-family: "FontAwesome";
content: "\f147";
position: absolute;
right: 20px;
font-size: 20px;
font-weight: 400;
top: 50%;
line-height: 1;
margin-top: -10px;

}

.fancy-collapse-panel .panel-heading a.collapsed:after {
content: "\f196";
}


</style>