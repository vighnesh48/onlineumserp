<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<script>    
    $(document).ready(function()
    {
        $('#form').bootstrapValidator
        ({  
            message: 'This value is not valid',
            group: 'form-group',
            feedbackIcons: 
            {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
			 row: {
        valid: 'field-success',
        invalid: 'field-error'
    },
            fields: 
            {
                /* lname:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Last name should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[a-zA-Z-/]+$/,
                        message: 'Last name should be alphabate characters'
                      },
                      stringLength: 
                        {
                        max: 50,
                        min: 2,
                        message: 'Last name should be 2-50 characters'
                        }
                    }
                } */
              
            }       
        })
    });
</script>
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="#">Holiday List</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Holiday List</h1>
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
                    
                    <div class="panel-body">
                        <div class="table-info">
                           <!-- <form id="form" name="form" action="<?//=base_url($currentModule.'/submit')?>" method="POST">  -->                                                             
                                <input type="hidden" value="" id="campus_id" name="campus_id" />
                                
                                <!--<div class="form-group">
                                    
                                    <label class="col-sm-2">Admission Date <?=$astrik?></label>
                                    <div class="col-sm-4">
                                    <div id="bs-datepicker-component" class="input-group date">
                                        <input type="text" id="po_date" class="form-control"><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
                                    </div>
                                </div>-->
                                <!--<div class="form-group">               
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('campus_state');?></span></div>
                                </div>-->
                                
                                <div class="form-group">
                                    <div class="col-sm-2">
						<a class="btn btn-primary form-control"id="btnNext" href="create_holiday">Add Holiday <i class="fa fa-plus"></i></a>	
                                    </div> 
                                </div>
                                
                             <div id="dashboard-recent" class="panel-warning">   
                               <div class="panel">
                            	<div class="panel-heading"><strong>Holiday List</strong></div>
                                <div class="panel-body">
								<span id="flash-messages" style="color:red;padding-left:110px;"><?php echo $this->session->flashdata('message1'); ?></span>
                                <div class="panel-padding no-padding-vr">
								<div class="form-group">
								<form id="form" name="form" action="<?=base_url($currentModule.'/holiday_list')?>" method="POST">
								<label class="col-md-3">Select Year</label>
								<div class="col-sm-3" id="month" style="">	                         						
                        <input type="test" class="form-control" placeholder="Select Year " value="" name="search_dt1" id="search_dt1">      
                        </div>
						<div class="col-md-3">
						<button class="btn btn-primary form-control" id="btn_submit1" type="submit">Search </button>
						</div>
						</form>
								</div>
								<br>
								<div class="form-group"><div class="col-md-3"></div><label class="col-md-6"><b style="color:Purple;"><u>Holiday List For Academic Year <?=$year?>-<?=$year+1?></u></b></label></div>
                            <div class="form-group"><br>
                                  <div class="row">
     				<div class="col-md-3">
     					<ul class="ver-inline-menu tabbable margin-bottom-10">
                                                     <li class="active">
                                    <a aria-expanded="true" data-toggle="tab" href="#January">
                                    <i class="fa fa-calendar"></i> January </a>
                                    <span class="after">
                                    </span>
                             </li>
     					                            <li class="">
                                    <a aria-expanded="false" data-toggle="tab" href="#February">
                                    <i class="fa fa-calendar"></i> February </a>
                                    <span class="after">
                                    </span>
                             </li>
     					                            <li class="">
                                    <a aria-expanded="false" data-toggle="tab" href="#March">
                                    <i class="fa fa-calendar"></i> March </a>
                                    <span class="after">
                                    </span>
                             </li>
     					                            <li class="">
                                    <a aria-expanded="false" data-toggle="tab" href="#April">
                                    <i class="fa fa-calendar"></i> April </a>
                                    <span class="after">
                                    </span>
                             </li>
     					                            <li class="">
                                    <a aria-expanded="false" data-toggle="tab" href="#May">
                                    <i class="fa fa-calendar"></i> May </a>
                                    <span class="after">
                                    </span>
                             </li>
     					                            <li>
                                    <a data-toggle="tab" href="#June">
                                    <i class="fa fa-calendar"></i> June </a>
                                    <span class="after">
                                    </span>
                             </li>
     					                            <li class="">
                                    <a aria-expanded="false" data-toggle="tab" href="#July">
                                    <i class="fa fa-calendar"></i> July </a>
                                    <span class="after">
                                    </span>
                             </li>
     					                            <li class="">
                                    <a aria-expanded="false" data-toggle="tab" href="#August">
                                    <i class="fa fa-calendar"></i> August </a>
                                    <span class="after">
                                    </span>
                             </li>
     					                            <li class="">
                                    <a aria-expanded="false" data-toggle="tab" href="#September">
                                    <i class="fa fa-calendar"></i> September </a>
                                    <span class="after">
                                    </span>
                             </li>
     					                            <li>
                                    <a data-toggle="tab" href="#October">
                                    <i class="fa fa-calendar"></i> October </a>
                                    <span class="after">
                                    </span>
                             </li>
     					                            <li>
                                    <a data-toggle="tab" href="#November">
                                    <i class="fa fa-calendar"></i> November </a>
                                    <span class="after">
                                    </span>
                             </li>
     					                            <li>
                                    <a data-toggle="tab" href="#December">
                                    <i class="fa fa-calendar"></i> December </a>
                                    <span class="after">
                                    </span>
                             </li>
     					
     					</ul>
     				</div>
					<?php
					$temp=$year; //assign year for search
					?>
     				<div class="col-md-9">
     					<div class="tab-content">
     					       						<div id="January" class="tab-pane active">
     						<div class="portlet box blue">
                            						<div class="portlet-title">
                            							<div class="caption">
                            								<i class="fa fa-calendar"></i>January
                            							</div>

                            						</div>
                            						<div class="portlet-body">
                            							<div class="table-scrollable">
                            								<table class="table table-hover">
                            								<thead>
                            								<tr>
                            									<th> # </th>
                            									<th> Date </th>
                            									<th> Occasion </th>
                            									<th> Day </th>
                            									<th> Action </th>
                            								</tr>
                            								</thead>
                            								<tbody>
                            								<?php
                                                            $month='January';	
															
															$hol=$this->load->Admin_model->getHolidayListMonthWise($month,$temp);
															$i=0;
															if(!empty($hol)){
															foreach($hol as $key=>$val){
																$i++;
															?>
                                                                
                                                                <tr id="row<?php echo $i;?>">
                                                                    <td> <?php echo $i;?> </td>
                                                                    <td> <?php echo  date("F jS, Y", strtotime($hol[$key]['hdate']));?> </td>
                                                                    <td> <?php echo $hol[$key]['occasion'];?> </td>
                                                                    <td> <?php echo $hol[$key]['hday'];?></td>
                                                                    <td>
                                                                         <a href="del_holiday?id=<?php echo $hol[$key]['hid'];?>" title="Delete" class="">
                                                                           <i class="fa fa-trash-o"></i>
                                                                        </a>
                                                                    </td>
                                                                 </tr>
															<?php } }else{?>
															 <tr id="row">
                                                                    <td colspan="4"> <?php echo "No Holiday For This Month";?> </td>
                                                              </tr>																	
														<?php }?>  
                                                                                   								
                            								</tbody>
                            								</table>
                            							</div>
                            						</div>
                            	</div>
     						</div>
     					     						<div id="February" class="tab-pane">
     						<div class="portlet box blue">
                            						<div class="portlet-title">
                            							<div class="caption">
                            								<i class="fa fa-calendar"></i>February
                            							</div>

                            						</div>
                            						<div class="portlet-body">
                            							<div class="table-scrollable">
                            								<table class="table table-hover">
                            								<thead>
                            								<tr>
                            									<th> # </th>
                            									<th> Date </th>
                            									<th> Occasion </th>
                            									<th> Day </th>
                            									<th> Action </th>
                            								</tr>
                            								</thead>
                            								<tbody>
                            								
                                                             <?php
                                                            $month='February';														
															$hol=$this->load->Admin_model->getHolidayListMonthWise($month,$temp);
															$i=0;
															if(!empty($hol)){
															foreach($hol as $key=>$val){
																$i++;
															?>
                                                                
                                                                <tr id="row<?php echo $i;?>">
                                                                    <td> <?php echo $i;?> </td>
                                                                    <td> <?php echo  date("F jS, Y", strtotime($hol[$key]['hdate']));?> </td>
                                                                    <td> <?php echo $hol[$key]['occasion'];?> </td>
                                                                    <td> <?php echo $hol[$key]['hday'];?></td>
                                                                    <td>
                                                                         <a href="del_holiday?id=<?php echo $hol[$key]['hid'];?>" title="Delete" class="">
                                                                           <i class="fa fa-trash-o"></i>
                                                                        </a>
                                                                    </td>
                                                                 </tr>
															<?php } }else{?>
															 <tr id="row">
                                                                    <td colspan="4"> <?php echo "No Holiday For This Month";?> </td>
                                                              </tr>																	
														<?php }?>                     								
                            								</tbody>
                            								</table>
                            							</div>
                            						</div>
                            	</div>
     						</div>
     					     						<div id="March" class="tab-pane">
     						<div class="portlet box blue">
                            						<div class="portlet-title">
                            							<div class="caption">
                            								<i class="fa fa-calendar"></i>March
                            							</div>

                            						</div>
                            						<div class="portlet-body">
                            							<div class="table-scrollable">
                            								<table class="table table-hover">
                            								<thead>
                            								<tr>
                            									<th> # </th>
                            									<th> Date </th>
                            									<th> Occasion </th>
                            									<th> Day </th>
                            									<th> Action </th>
                            								</tr>
                            								</thead>
                            								<tbody>
                            								
                                                                
                                                               <?php
                                                            $month='March';														
															$hol=$this->load->Admin_model->getHolidayListMonthWise($month,$temp);
															$i=0;
															if(!empty($hol)){
															foreach($hol as $key=>$val){
																$i++;
															?>
                                                                
                                                                <tr id="row<?php echo $i;?>">
                                                                    <td> <?php echo $i;?> </td>
                                                                    <td> <?php echo  date("F jS, Y", strtotime($hol[$key]['hdate']));?> </td>
                                                                    <td> <?php echo $hol[$key]['occasion'];?> </td>
                                                                    <td> <?php echo $hol[$key]['hday'];?></td>
                                                                    <td>
                                                                         <a  href="del_holiday?id=<?php echo $hol[$key]['hid'];?>" title="Delete" class="">
                                                                           <i class="fa fa-trash-o"></i>
                                                                        </a>
                                                                    </td>
                                                                 </tr>
															<?php } }else{?>
															 <tr id="row">
                                                                    <td colspan="4"> <?php echo "No Holiday For This Month";?> </td>
                                                              </tr>																	
														<?php }?>  
                                                                                            								
                            								</tbody>
                            								</table>
                            							</div>
                            						</div>
                            	</div>
     						</div>
     					     						<div id="April" class="tab-pane">
     						<div class="portlet box blue">
                            						<div class="portlet-title">
                            							<div class="caption">
                            								<i class="fa fa-calendar"></i>April
                            							</div>

                            						</div>
                            						<div class="portlet-body">
                            							<div class="table-scrollable">
                            								<table class="table table-hover">
                            								<thead>
                            								<tr>
                            									<th> # </th>
                            									<th> Date </th>
                            									<th> Occasion </th>
                            									<th> Day </th>
                            									<th> Action </th>
                            								</tr>
                            								</thead>
                            								<tbody>
                            								<?php
                                                            $month='April';														
															$hol=$this->load->Admin_model->getHolidayListMonthWise($month,$temp);
															$i=0;
															if(!empty($hol)){
															foreach($hol as $key=>$val){
																$i++;
															?>
                                                                
                                                                <tr id="row<?php echo $i;?>">
                                                                    <td> <?php echo $i;?> </td>
                                                                    <td> <?php echo  date("F jS, Y", strtotime($hol[$key]['hdate']));?> </td>
                                                                    <td> <?php echo $hol[$key]['occasion'];?> </td>
                                                                    <td> <?php echo $hol[$key]['hday'];?></td>
                                                                    <td>
                                                                         <a href="del_holiday?id=<?php echo $hol[$key]['hid'];?>" title="Delete" class="">
                                                                           <i class="fa fa-trash-o"></i>
                                                                        </a>
                                                                    </td>
                                                                 </tr>
															<?php } }else{?>
															 <tr id="row">
                                                                    <td colspan="4"> <?php echo "No Holiday For This Month";?> </td>
                                                              </tr>																	
														<?php }?>                      								
                            								</tbody>
                            								</table>
                            							</div>
                            						</div>
                            	</div>
     						</div>
     					     						<div id="May" class="tab-pane">
     						<div class="portlet box blue">
                            						<div class="portlet-title">
                            							<div class="caption">
                            								<i class="fa fa-calendar"></i>May
                            							</div>

                            						</div>
                            						<div class="portlet-body">
                            							<div class="table-scrollable">
                            								<table class="table table-hover">
                            								<thead>
                            								<tr>
                            									<th> # </th>
                            									<th> Date </th>
                            									<th> Occasion </th>
                            									<th> Day </th>
                            									<th> Action </th>
                            								</tr>
                            								</thead>
                            								<tbody>
                            								<?php
                                                            $month='May';														
															$hol=$this->load->Admin_model->getHolidayListMonthWise($month,$temp);
															$i=0;
															if(!empty($hol)){
															foreach($hol as $key=>$val){
																$i++;
															?>
                                                                
                                                                <tr id="row<?php echo $i;?>">
                                                                    <td> <?php echo $i;?> </td>
                                                                    <td> <?php echo  date("F jS, Y", strtotime($hol[$key]['hdate']));?> </td>
                                                                    <td> <?php echo $hol[$key]['occasion'];?> </td>
                                                                    <td> <?php echo $hol[$key]['hday'];?></td>
                                                                    <td>
                                                                         <a href="del_holiday?id=<?php echo $hol[$key]['hid'];?>" title="Delete" class="">
                                                                           <i class="fa fa-trash-o"></i>
                                                                        </a>
                                                                    </td>
                                                                 </tr>
															<?php } }else{?>
															 <tr id="row">
                                                                    <td colspan="4"> <?php echo "No Holiday For This Month";?> </td>
                                                              </tr>																	
														<?php }?>                         								
                            								</tbody>
                            								</table>
                            							</div>
                            						</div>
                            	</div>
     						</div>
     					     						<div id="June" class="tab-pane ">
     						<div class="portlet box blue">
                            						<div class="portlet-title">
                            							<div class="caption">
                            								<i class="fa fa-calendar"></i>June
                            							</div>

                            						</div>
                            						<div class="portlet-body">
                            							<div class="table-scrollable">
                            								<table class="table table-hover">
                            								<thead>
                            								<tr>
                            									<th> # </th>
                            									<th> Date </th>
                            									<th> Occasion </th>
                            									<th> Day </th>
                            									<th> Action </th>
                            								</tr>
                            								</thead>
                            								<tbody>
                            								<?php
                                                            $month='June';														
															$hol=$this->load->Admin_model->getHolidayListMonthWise($month,$temp);
															$i=0;
															if(!empty($hol)){
															foreach($hol as $key=>$val){
																$i++;
															?>
                                                                
                                                                <tr id="row<?php echo $i;?>">
                                                                    <td> <?php echo $i;?> </td>
                                                                    <td> <?php echo  date("F jS, Y", strtotime($hol[$key]['hdate']));?> </td>
                                                                    <td> <?php echo $hol[$key]['occasion'];?> </td>
                                                                    <td> <?php echo $hol[$key]['hday'];?></td>
                                                                    <td>
                                                                         <a href="del_holiday?id=<?php echo $hol[$key]['hid'];?>" title="Delete" class="">
                                                                           <i class="fa fa-trash-o"></i>
                                                                        </a>
                                                                    </td>
                                                                 </tr>
															<?php } }else{?>
															 <tr id="row">
                                                                    <td colspan="4"> <?php echo "No Holiday For This Month";?> </td>
                                                              </tr>																	
														<?php }?>                        								
                            								</tbody>
                            								</table>
                            							</div>
                            						</div>
                            	</div>
     						</div>
     					     						<div id="July" class="tab-pane">
     						<div class="portlet box blue">
                            						<div class="portlet-title">
                            							<div class="caption">
                            								<i class="fa fa-calendar"></i>July
                            							</div>

                            						</div>
                            						<div class="portlet-body">
                            							<div class="table-scrollable">
                            								<table class="table table-hover">
                            								<thead>
                            								<tr>
                            									<th> # </th>
                            									<th> Date </th>
                            									<th> Occasion </th>
                            									<th> Day </th>
                            									<th> Action </th>
                            								</tr>
                            								</thead>
                            								<tbody>
                            								<?php
                                                            $month='July';														
															$hol=$this->load->Admin_model->getHolidayListMonthWise($month,$temp);
															$i=0;
															if(!empty($hol)){
															foreach($hol as $key=>$val){
																$i++;
															?>
                                                                
                                                                <tr id="row<?php echo $i;?>">
                                                                    <td> <?php echo $i;?> </td>
                                                                    <td> <?php echo  date("F jS, Y", strtotime($hol[$key]['hdate']));?> </td>
                                                                    <td> <?php echo $hol[$key]['occasion'];?> </td>
                                                                    <td> <?php echo $hol[$key]['hday'];?></td>
                                                                    <td>
                                                                         <a href="del_holiday?id=<?php echo $hol[$key]['hid'];?>" title="Delete" class="">
                                                                           <i class="fa fa-trash-o"></i>
                                                                        </a>
                                                                    </td>
                                                                 </tr>
															<?php } }else{?>
															 <tr id="row">
                                                                    <td colspan="4"> <?php echo "No Holiday For This Month";?> </td>
                                                              </tr>																	
														<?php }?>                          								
                            								</tbody>
                            								</table>
                            							</div>
                            						</div>
                            	</div>
     						</div>
     					     						<div id="August" class="tab-pane">
     						<div class="portlet box blue">
                            						<div class="portlet-title">
                            							<div class="caption">
                            								<i class="fa fa-calendar"></i>August
                            							</div>

                            						</div>
                            						<div class="portlet-body">
                            							<div class="table-scrollable">
                            								<table class="table table-hover">
                            								<thead>
                            								<tr>
                            									<th> # </th>
                            									<th> Date </th>
                            									<th> Occasion </th>
                            									<th> Day </th>
                            									<th> Action </th>
                            								</tr>
                            								</thead>
                            								<tbody>
                            							<?php
                                                            $month='August';														
															$hol=$this->load->Admin_model->getHolidayListMonthWise($month,$temp);
															$i=0;
															if(!empty($hol)){
															foreach($hol as $key=>$val){
																$i++;
															?>
                                                                
                                                                <tr id="row<?php echo $i;?>">
                                                                    <td> <?php echo $i;?> </td>
                                                                    <td> <?php echo  date("F jS, Y", strtotime($hol[$key]['hdate']));?> </td>
                                                                    <td> <?php echo $hol[$key]['occasion'];?> </td>
                                                                    <td> <?php echo $hol[$key]['hday'];?></td>
                                                                    <td>
                                                                         <a href="del_holiday?id=<?php echo $hol[$key]['hid'];?>" title="Delete" class="">
                                                                           <i class="fa fa-trash-o"></i>
                                                                        </a>
                                                                    </td>
                                                                 </tr>
															<?php } }else{?>
															 <tr id="row">
                                                                    <td colspan="4"> <?php echo "No Holiday For This Month";?> </td>
                                                              </tr>																	
														<?php }?>                         								
                            								</tbody>
                            								</table>
                            							</div>
                            						</div>
                            	</div>
     						</div>
     					     						<div id="September" class="tab-pane">
     						<div class="portlet box blue">
                            						<div class="portlet-title">
                            							<div class="caption">
                            								<i class="fa fa-calendar"></i>September
                            							</div>

                            						</div>
                            						<div class="portlet-body">
                            							<div class="table-scrollable">
                            								<table class="table table-hover">
                            								<thead>
                            								<tr>
                            									<th> # </th>
                            									<th> Date </th>
                            									<th> Occasion </th>
                            									<th> Day </th>
                            									<th> Action </th>
                            								</tr>
                            								</thead>
                            								<tbody>
                            							<?php
                                                            $month='September';														
															$hol=$this->load->Admin_model->getHolidayListMonthWise($month,$temp);
															$i=0;
															if(!empty($hol)){
															foreach($hol as $key=>$val){
																$i++;
															?>
                                                                
                                                                <tr id="row<?php echo $i;?>">
                                                                    <td> <?php echo $i;?> </td>
                                                                    <td> <?php echo  date("F jS, Y", strtotime($hol[$key]['hdate']));?> </td>
                                                                    <td> <?php echo $hol[$key]['occasion'];?> </td>
                                                                    <td> <?php echo $hol[$key]['hday'];?></td>
                                                                    <td>
                                                                         <a   href="del_holiday?id=<?php echo $hol[$key]['hid'];?>" title="Delete" class="">
                                                                           <i class="fa fa-trash-o"></i>
                                                                        </a>
                                                                    </td>
                                                                 </tr>
															<?php } }else{?>
															 <tr id="row">
                                                                    <td colspan="4"> <?php echo "No Holiday For This Month";?> </td>
                                                              </tr>																	
														<?php }?>                        								
                            								</tbody>
                            								</table>
                            							</div>
                            						</div>
                            	</div>
     						</div>
     					     						<div id="October" class="tab-pane ">
     						<div class="portlet box blue">
                            						<div class="portlet-title">
                            							<div class="caption">
                            								<i class="fa fa-calendar"></i>October
                            							</div>

                            						</div>
                            						<div class="portlet-body">
                            							<div class="table-scrollable">
                            								<table class="table table-hover">
                            								<thead>
                            								<tr>
                            									<th> # </th>
                            									<th> Date </th>
                            									<th> Occasion </th>
                            									<th> Day </th>
                            									<th> Action </th>
                            								</tr>
                            								</thead>
                            								<tbody>
                            								<?php
                                                            $month='October';														
															$hol=$this->load->Admin_model->getHolidayListMonthWise($month,$temp);
															$i=0;
															if(!empty($hol)){
															foreach($hol as $key=>$val){
																$i++;
															?>
                                                                
                                                                <tr id="row<?php echo $i;?>">
                                                                    <td> <?php echo $i;?> </td>
                                                                    <td> <?php echo  date("F jS, Y", strtotime($hol[$key]['hdate']));?> </td>
                                                                    <td> <?php echo $hol[$key]['occasion'];?> </td>
                                                                    <td> <?php echo $hol[$key]['hday'];?></td>
                                                                    <td>
                                                                         <a   href="del_holiday(<?php echo $hol[$key]['hid']?>)" title="Delete" class="">
                                                                           <i class="fa fa-trash-o"></i>
                                                                        </a>
                                                                    </td>
                                                                 </tr>
															<?php } }else{?>
															 <tr id="row">
                                                                    <td colspan="4"> <?php echo "No Holiday For This Month";?> </td>
                                                              </tr>																	
														<?php }?>                        								
                            								</tbody>
                            								</table>
                            							</div>
                            						</div>
                            	</div>
     						</div>
     					     						<div id="November" class="tab-pane ">
     						<div class="portlet box blue">
                            						<div class="portlet-title">
                            							<div class="caption">
                            								<i class="fa fa-calendar"></i>November
                            							</div>

                            						</div>
                            						<div class="portlet-body">
                            							<div class="table-scrollable">
                            								<table class="table table-hover">
                            								<thead>
                            								<tr>
                            									<th> # </th>
                            									<th> Date </th>
                            									<th> Occasion </th>
                            									<th> Day </th>
                            									<th> Action </th>
                            								</tr>
                            								</thead>
                            								<tbody>
                            							<?php
                                                            $month='November';														
															$hol=$this->load->Admin_model->getHolidayListMonthWise($month,$temp);
															$i=0;
															if(!empty($hol)){
															foreach($hol as $key=>$val){
																$i++;
															?>
                                                                
                                                                <tr id="row<?php echo $i;?>">
                                                                    <td> <?php echo $i;?> </td>
                                                                    <td> <?php echo  date("F jS, Y", strtotime($hol[$key]['hdate']));?> </td>
                                                                    <td> <?php echo $hol[$key]['occasion'];?> </td>
                                                                    <td> <?php echo $hol[$key]['hday'];?></td>
                                                                    <td>
                                                                         <a  href="del_holiday?id=<?php echo $hol[$key]['hid'];?>" title="Delete" class="">
                                                                           <i class="fa fa-trash-o"></i>
                                                                        </a>
                                                                    </td>
                                                                 </tr>
															<?php } }else{?>
															 <tr id="row">
                                                                    <td colspan="4"> <?php echo "No Holiday For This Month";?> </td>
                                                              </tr>																	
														<?php }?>                        								
                            								</tbody>
                            								</table>
                            							</div>
                            						</div>
                            	</div>
     						</div>
     					     						<div id="December" class="tab-pane ">
     						<div class="portlet box blue">
                            						<div class="portlet-title">
                            							<div class="caption">
                            								<i class="fa fa-calendar"></i>December
                            							</div>

                            						</div>
                            						<div class="portlet-body">
                            							<div class="table-scrollable">
                            								<table class="table table-hover">
                            								<thead>
                            								<tr>
                            									<th> # </th>
                            									<th> Date </th>
                            									<th> Occasion </th>
                            									<th> Day </th>
                            									<th> Action </th>
                            								</tr>
                            								</thead>
                            								<tbody>
                            							<?php
                                                            $month='December';														
															$hol=$this->load->Admin_model->getHolidayListMonthWise($month,$temp);
															$i=0;
															if(!empty($hol)){
															foreach($hol as $key=>$val){
																$i++;
															?>
                                                                
                                                                <tr id="row<?php echo $i;?>">
                                                                    <td> <?php echo $i;?> </td>
                                                                    <td> <?php echo  date("F jS, Y", strtotime($hol[$key]['hdate']));?> </td>
                                                                    <td> <?php echo $hol[$key]['occasion'];?> </td>
                                                                    <td> <?php echo $hol[$key]['hday'];?></td>
                                                                    <td>
                                                                        <a   href="del_holiday?id=<?php echo $hol[$key]['hid'];?>" title="Delete" class="">
                                                                           <i class="fa fa-trash-o"></i>
                                                                        </a>
                                                                    </td>
                                                                 </tr>
															<?php } }else{?>
															 <tr id="row">
                                                                    <td colspan="4"> <?php echo "No Holiday For This Month";?> </td>
                                                              </tr>																	
														<?php }?>                         								
                            								</tbody>
                            								</table>
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
                                
                              
                                <!--<div class="form-group">
                                    <div class="col-sm-4"></div>
                                    <div class="col-sm-2">
                                        <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Submit</button>                                        
                                    </div>                                    
                                    <div class="col-sm-2"><button class="btn btn-primary form-control" id="btn_cancel" type="button">Cancel</button></div>
                                    <div class="col-sm-4"></div>
                                </div>-->
                            </form>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	
	$('#search_dt1').datepicker( {format: 'yyyy',viewMode: 'years',minViewMode: 'years',startDate: '2016',autoclose: true});
	$('#dob-datepicker').datepicker( {format: 'yyyy-mm-dd'});
	var content = '<tr>'+$('#eduDetTable tbody tr').html()+'</tr>';
	$("#eduDetTable").on("click","input[name='addMore']", function(e){	
	//$("input[name='addMore']").on('click',function(){		
		//var content = $(this).parent().parent('tr').clone('true');
		$(this).parent().parent('tr').after(content);		
	});
	$("#eduDetTable").on("click","input[name='remove']", function(e){	
	//$("input[name='remove']").on('click',function(){
		var rowCount = $('#eduDetTable tbody tr').length;
		if(rowCount>1){
			$(this).parent().parent('tr').remove();
		}
	});	
});
</script>