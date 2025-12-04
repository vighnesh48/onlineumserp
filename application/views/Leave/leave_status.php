<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<script src="<?=base_url('assets/javascripts')?>/jPages_second.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<script src="<?=base_url()?>assets/javascripts/moment.js"></script>

<?php// print_r($all_emp_leave);?>
<style>
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

</style>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Masters</a></li>
        <li class="active"><a href="#">View Leave Status</a></li>
    </ul>
    <div class="page-header">           
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;View Leave Status</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                    <?php //if(in_array("Add", $my_privileges)) { ?>
                                        
                    <div class="visible-xs clearfix form-group-margin"></div>
                    <?php// } ?>
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
          <ul class="nav nav-tabs">
           <?php 
          $a = $_GET['lt'];
          if($a == 'od'){
              $b = 'active';
          }else{
              $a = 'active';
          }
          ?>
          <li class="<?php echo $a; ?>"><a href="#leave" data-toggle="tab">Leave</a></li>
           <li class="<?php echo $b; ?>"><a href="#od" data-toggle="tab">OD</a></li>
            <li class="<?php echo $c; ?>"><a href="#wfh" data-toggle="tab">WFH</a></li>
          
          </ul>
          <div class="tab-content">
              <div class="tab-pane <?php echo $a; ?>" id="leave">
              <div class="col-sm-12">
                <div class="panel">
               <div class="panel-heading "> 
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
               <div class="col-md-6" >
<input type="text" id="monthleave" name="month" class="form-control monthPicker" value="<?php echo $mon; ?>"/> 
</div>
<div class="col-md-3"><input type="button" id="find" onclick="search_emp_leves('leave')"  class="btn btn-primary" value="Search">
</div>
                </div>
                </div>
                </div>
               
                  </div> 
                
            <div class="panel-body">
                    <div class="table-info">    
                    <?php //if(in_array("View", $my_privileges)) { ?>
                    <table class="table table-bordered">
                        <thead>
                          <tr>
                                     <th>S.No</th>                             
                                    <th>Date</th>   
                                    <th>Days</th>
                                    <th>Leave Type</th>
                                    <th>Reason</th>                                 
                                 <th>Applied on</th>
                                    <th>Status</th>
                                    <th>Gate Pass</th>
                                    <th>Office/Movement <br>Order</th>
                                    <th>Details</th>
                                    
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                           <?php if(empty($leave)){?>
                                    <tr id="row441" class="odd" role="row">
                                        <td class="center" colspan=30><?php echo "No Leave Applications Available"; ?></td>
                                        </tr>
                                    <?php }else{
                                        $i=0;
                                        //print_r($leave);
                                        foreach($leave as $key=>$val){
											if( $leave[$key]['leave_type']=="WFH"){}else{
                                            $i++;
                                        ?>
                                    <tr id="row<?php echo $i;?>" class="odd" role="row">
                                        <td class="center"><?php echo $i; //echo $leave[$key]['leave_type'].'k';?></td>
                                    
                                        <td class="center"><?php echo date('d-m-Y',strtotime($leave[$key]['applied_from_date']))." to ".date('d-m-Y',strtotime($leave[$key]['applied_to_date']));?></td>
                                    
                                        <td class="center"><?php
if($leave[$key]['leave_duration'] == 'half-day'){
    echo "0.5";
}else{
                                        echo $leave[$key]['no_days'];
} ?></td>
                        <td class="center">
                            <?php
                                        
                                        if($leave[$key]['leave_apply_type'] == 'OD'){ 
                                            echo "OD";
                                        }else{
                                         if($leave[$key]['leave_type']=='lwp' || $leave[$key]['leave_type']=='LWP'){
                                        echo $this->leave_model->getLeaveTypeById1('9');
                                    }else{
                                         $lt =  $this->leave_model->getLeaveTypeById($leave[$key]['leave_type']);
 if($lt == 'VL'){
            $cnt = $this->leave_model->get_vid_emp_allocation($leave[$key]['leave_type']);
        echo $lt." - ".$cnt[0]['slot_type'];    
        }else{
            echo $lt;
        }
                                         
                                    }
                                        }
                                        //print_r($l);
                                        
                                        ?>              </td>
                                        <td class="center"><?php echo $leave[$key]['reason'];?></td>
                                        <td class="center"><?php echo date('d-m-Y',strtotime($leave[$key]['applied_on_date']));?></td>
                                        <td class="center">
                                        <?php if($leave[$key]['fstatus']=='Approved'){
                                            $var='label label-success';
                                            }elseif($leave[$key]['fstatus']=='Rejected' || $leave[$key]['fstatus']=='Cancel'){ $var='label label-danger';
                                            }elseif($leave[$key]['fstatus']=='Pending'){ $var='label label-warning';
                                            }elseif($leave[$key]['fstatus']=='Forward'){ $var='label label-primary';
                                            }else{ $var=""; }?><span class="<?=$var;?>">

                                            <?php 
if($lt == 'ML'){
                                           $ckml = $this->leave_model->check_ml_status($leave[$key]['lid']);
if($ckml=='false'){
    echo "Original ML Certificate Submission Pending at Admin";
}else{
     echo $leave[$key]['fstatus'];
}

                                        }else{
                                           echo $leave[$key]['fstatus'];
                                        }
                                        

                                            ?></span></td>
                                            <td>
                                        <?php if(($leave[$key]['emp1_reporting_status']!='Approved' || $leave[$key]['fstatus']=='Approved') && $leave[$key]['gate_pass'] == 'Y'){ ?>
                                        
                                            <a href="<?=base_url().'Leave/downloadgetpass/'.$leave[$key]['lid'].'/'.$leave[$key]['emp_id'].'/g'?>"><button type="button" class="btn btn-info btn-sm" style="background-color:#4bb1d0;">
          <span class="glyphicon glyphicon-download-alt"></span> Download
        </button></a>
                                            <?php }?>
                                         </td>  
                                         <td>
                                        <?php if($leave[$key]['fstatus']=='Approved' && $leave[$key]['gate_pass'] == 'Y' && $leave[$key]['leave_apply_type'] == 'OD'){ ?>
<!--<a data-toggle="modal" data-book-id="<?=$leave[$key]['lid']?>" data-target="#myModal"> View</a>-->
                                            <a href="<?=base_url().'Leave/downloadgetpass/'.$leave[$key]['lid'].'/'.$leave[$key]['emp_id'].'/m'?>"><button type="button" class="btn btn-info btn-sm" style="background-color:#4bb1d0;">
          <span class="glyphicon glyphicon-download-alt"></span> Download
        </button></a>
                                            <?php }?>
                                         </td>  
                                         <td><a href='' id='<?php echo $leave[$key]['lid']; ?>' class='edetails' data-toggle='modal' data-target='#myModal' >Details</a></td>
                                         
                        </tr>   
                                        
                                        <?php }} }?>
                          
                        </tbody>
                    </table>                    
                    <?php //} ?>
                </div>
                </div>
              </div>
                </div>
              </div>
              <div class="tab-pane <?php echo $b; ?>" id="od">
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
               <div class="col-md-6" >
<input type="text" id="monthod" name="month" class="form-control monthPicker" value="<?php echo $mon; ?>"/> 
</div>
<div class="col-md-3"><input type="button" id="find" onclick="search_emp_leves('od')"  class="btn btn-primary" value="Search">
</div>
                </div>
                </div>
                </div>
               
              </div>
                
            <div class="panel-body" style="overflow-x:scroll;height:550px;">
                    <div class="table-info">    
                    <?php //if(in_array("View", $my_privileges)) { ?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                    <th>S.No</th>                              
                                    <th>Date</th>   
                                    <th>Days</th>
                                    <th>Leave Type</th>
                                    <th>Reason</th>                                 
                                    <th>Applied on</th>
                                    <th>Status</th>
                                    <th>Gate Pass</th>
                                    <th>Office/Movement <br>Order</th>
                                    <th>Details</th>    
                                    
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                          <?php if(empty($leaveod)){?>
                                    <tr id="row441" class="odd" role="row">
                                        <td class="center" colspan=30><?php echo "No Leave Applications Available"; ?></td>
                                        </tr>
                                    <?php }else{
                                        $i=0;
                                        //print_r($leave);
                                        foreach($leaveod as $key=>$val){
                                            $i++;
                                        ?>
                                    <tr id="row<?php echo $i;?>" class="odd" role="row">
                                        <td class="center"><?php echo $i;?></td>
                                    
                                        <td class="center"><?php echo date('d-m-Y',strtotime($leaveod[$key]['applied_from_date']))." to ".date('d-m-Y',strtotime($leaveod[$key]['applied_to_date']));?></td>
                                    
                                        <td class="center"><?php
if($leaveod[$key]['leave_duration'] == 'half-day'){
    echo "0.5";
}elseif($leaveod[$key]['leave_duration'] == 'hrs'){
  echo $leaveod[$key]['no_hrs'] .'Hrs';
}else{
                                        echo $leaveod[$key]['no_days'];
} ?></td>
                        <td class="center">
                            <?php
                                        
                                        if($leaveod[$key]['leave_apply_type'] == 'OD'){ 
                                            echo "OD";
                                        }else{
                                        echo $this->leave_model->getLeaveTypeById1($leaveod[$key]['leave_type']);
                                        }
                                        //print_r($l);
                                        
                                        ?>              </td>
                                        <td class="center"><?php echo $leaveod[$key]['reason'];?></td>
                                        <td class="center"><?php echo date('d-m-Y',strtotime($leaveod[$key]['applied_on_date']));?></td>
                                        <td class="center">
                                        <?php if($leaveod[$key]['fstatus']=='Approved'){
                                            $var='label label-success';
                                            }elseif($leaveod[$key]['fstatus']=='Rejected' || $leaveod[$key]['fstatus']=='Cancel'){ $var='label label-danger';
                                            }elseif($leaveod[$key]['fstatus']=='Pending'){ $var='label label-warning';
                                            }elseif($leaveod[$key]['fstatus']=='Forward'){ $var='label label-primary';
                                            }else{ $var=""; }?><span class="<?=$var;?>"><?php echo $leaveod[$key]['fstatus'];?></span></td>
                                            <td>
                                        <?php if(($leaveod[$key]['emp1_reporting_status']!='Approved' || $leaveod[$key]['fstatus']=='Approved') && $leaveod[$key]['gate_pass'] == 'Y'){ ?>
                                        
                                            <a href="<?=base_url().'Leave/downloadgetpass/'.$leaveod[$key]['lid'].'/'.$leaveod[$key]['emp_id'].'/g'?>"><button type="button" class="btn btn-info btn-sm" style="background-color:#4bb1d0;">
          <span class="glyphicon glyphicon-download-alt"></span> Download
        </button></a>
                                            <?php }?>
                                         </td>  
                                         <td>
                                        <?php if($leaveod[$key]['fstatus']=='Approved' && $leaveod[$key]['leave_apply_type'] == 'OD'){ ?>
<!--<a data-toggle="modal" data-book-id="<?=$leave[$key]['lid']?>" data-target="#myModal"> View</a>-->
                                            <a href="<?=base_url().'Leave/downloadgetpass/'.$leaveod[$key]['lid'].'/'.$leaveod[$key]['emp_id'].'/m'?>"><button type="button" class="btn btn-info btn-sm" style="background-color:#4bb1d0;">
          <span class="glyphicon glyphicon-download-alt"></span> Download
        </button></a>
                                            <?php }?>
                                         </td>  
                                         <td><a href='' id='<?php echo $leaveod[$key]['lid']; ?>' class='edetails' data-toggle='modal' data-target='#myModal' >Details</a></td>
                                         
                        </tr>   
                                        
                                        <?php }}?>
                                          
                        </tbody>
                    </table>                    
                    <?php //} ?>
                </div>
                </div>
              </div>
                </div>
              </div>
              <div class="tab-pane <?php echo $c; ?>" id="wfh">
              
              <div class="col-sm-12">
                <div class="panel">
               <div class="panel-heading "> 
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
               <div class="col-md-6" >
<input type="text" id="monthleave" name="month" class="form-control monthPicker" value="<?php echo $mon; ?>"/> 
</div>
<div class="col-md-3"><input type="button" id="find" onclick="search_emp_leves('leave')"  class="btn btn-primary" value="Search">
</div>
                </div>
                </div>
                </div>
               
                  </div> 
                
            <div class="panel-body">
                    <div class="table-info">    
                    <?php //if(in_array("View", $my_privileges)) { ?>
                    <table class="table table-bordered">
                        <thead>
                          <tr>
                                     <th>S.No</th>                             
                                    <th>Date</th>   
                                    <th>Days</th>
                                    <th>Leave Type</th>
                                    <th>Reason</th>                                 
                                 <th>Applied on</th>
                                    <th>Status</th>
                                    <th>Gate Pass</th>
                                    <th>Office/Movement <br>Order</th>
                                    <th>Details</th>
                                    
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                           <?php if(empty($leave)){?>
                                    <tr id="row441" class="odd" role="row">
                                        <td class="center" colspan=30><?php echo "No Leave Applications Available"; ?></td>
                                        </tr>
                                    <?php }else{
                                        $i=0;
                                        //print_r($leave);
                                        foreach($leave as $key=>$val){
											if($leave[$key]['leave_type']=='WFH'){
                                            $i++;
                                        ?>
                                    <tr id="row<?php echo $i;?>" class="odd" role="row">
                                        <td class="center"><?php echo $i;?></td>
                                    
                                        <td class="center"><?php echo date('d-m-Y',strtotime($leave[$key]['applied_from_date']))." to ".date('d-m-Y',strtotime($leave[$key]['applied_to_date']));?></td>
                                    
                                        <td class="center"><?php
if($leave[$key]['leave_duration'] == 'half-day'){
    echo "0.5";
}else{
                                        echo $leave[$key]['no_days'];
} ?></td>
                        <td class="center">
                            <?php
                                        
                                        if($leave[$key]['leave_apply_type'] == 'OD'){ 
                                            echo "OD";
                                        }else{
                                         if($leave[$key]['leave_type']=='WFH'){
                                        echo $this->leave_model->getLeaveTypeById1('13');
                                    }else{
                                         $lt =  $this->leave_model->getLeaveTypeById($leave[$key]['leave_type']);
 if($lt == 'VL'){
            $cnt = $this->leave_model->get_vid_emp_allocation($leave[$key]['leave_type']);
        echo $lt." - ".$cnt[0]['slot_type'];    
        }else{
            echo $lt;
        }
                                         
                                    }
                                        }
                                        //print_r($l);
                                        
                                        ?>              </td>
                                        <td class="center"><?php echo $leave[$key]['reason'];?></td>
                                        <td class="center"><?php echo date('d-m-Y',strtotime($leave[$key]['applied_on_date']));?></td>
                                        <td class="center">
                                        <?php if($leave[$key]['fstatus']=='Approved'){
                                            $var='label label-success';
                                            }elseif($leave[$key]['fstatus']=='Rejected' || $leave[$key]['fstatus']=='Cancel'){ $var='label label-danger';
                                            }elseif($leave[$key]['fstatus']=='Pending'){ $var='label label-warning';
                                            }elseif($leave[$key]['fstatus']=='Forward'){ $var='label label-primary';
                                            }else{ $var=""; }?><span class="<?=$var;?>">

                                            <?php 
if($lt == 'ML' && strtotime(date('d/m/Y',strtotime($leave[$key]['applied_on_date']))) <= strtotime(date('d/m/Y',strtotime('20/10/2018')))){
                                           $ckml = $this->leave_model->check_ml_status($applicant_leave[$key]['lid']);
if($ckml=='false'){
    echo "Original ML Certificate Submission Pending at Admin";
}else{
     echo $leave[$key]['fstatus'];
}

                                        }else{
                                           echo $leave[$key]['fstatus'];
                                        }
                                        

                                            ?></span></td>
                                            <td>
                                        <?php if(($leave[$key]['emp1_reporting_status']!='Approved' || $leave[$key]['fstatus']=='Approved') && $leave[$key]['gate_pass'] == 'Y'){ ?>
                                        
                                            <a href="<?=base_url().'Leave/downloadgetpass/'.$leave[$key]['lid'].'/'.$leave[$key]['emp_id'].'/g'?>"><button type="button" class="btn btn-info btn-sm" style="background-color:#4bb1d0;">
          <span class="glyphicon glyphicon-download-alt"></span> Download
        </button></a>
                                            <?php }?>
                                         </td>  
                                         <td>
                                        <?php if($leave[$key]['fstatus']=='Approved' && $leave[$key]['gate_pass'] == 'Y' && $leave[$key]['leave_apply_type'] == 'OD'){ ?>
<!--<a data-toggle="modal" data-book-id="<?=$leave[$key]['lid']?>" data-target="#myModal"> View</a>-->
                                            <a href="<?=base_url().'Leave/downloadgetpass/'.$leave[$key]['lid'].'/'.$leave[$key]['emp_id'].'/m'?>"><button type="button" class="btn btn-info btn-sm" style="background-color:#4bb1d0;">
          <span class="glyphicon glyphicon-download-alt"></span> Download
        </button></a>
                                            <?php }?>
                                         </td>  
                                         <td><a href='' id='<?php echo $leave[$key]['lid']; ?>' class='edetails' data-toggle='modal' data-target='#myModal' >Details</a></td>
                                         
                        </tr>   
                                        
                                        <?php }} }?>
                          
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
            
        </div>
        <!-- /tabs -->
           
                
               
              
        </div>
    </div>
</div>
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width:800px;">

    <!-- Modal content-->
    <div class="modal-content">
      
      <div class="modal-body">
        <p id="edata" ></p>
      </div>
      
    </div>

  </div>
</div>
<script>
function search_emp_leves(lt){
    var month = $('#month'+lt).val();    
          url= "<?php echo base_url().$currentModule; ?>/check_leave_status/"+month+"/?lt="+lt;
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
    
  
        $(".edetails").on('click', function() {
  // alert();
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
        });
</script>