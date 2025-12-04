<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<?php //print_r($my_privileges); die; ?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Masters</a></li>
         <li class="active"><a href="<?=base_url($currentModule)?>">Canteen </a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Canteen List</h1>
			
			<div class="col-xs-12 col-sm-8">
                <div class="row"> 
					   <hr class="visible-xs no-grid-gutter-h">
                    
                    <div class="pull-right col-xs-12 col-sm-auto"><a style="width: 100%;" class="btn btn-primary btn-labeled" href="<?=base_url($currentModule."/add_canteen")?>"><span class="btn-label icon fa fa-plus"></span>Add </a></div>                        
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
                        <span class="panel-title">Canteen Details</span>
                        
                </div>
				
                <div class="panel-body" style="overflow-x:scroll;height:500px;">
                    <div class="table-info" >    
                       <table class="table table-bordered">
                        <thead>
                            <tr>
                                    <th width="5%">#</th>
                                    <th width="15%">Canteen Name</th>
                                    <th width="15%">Contact</th>
                                    <th width="12%">Allocated Students Breakfast</th>
                                    <th width="12%">Allocated Students Lunch</th>
                                    <th width="12%">Allocated Students Dinner</th>
                                    <th width="7%">Allocated Students</th>
                                    
                                    <th width="7%">Action</th>
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php
                            $j=1;    
                          //  var_dump($_SESSION);
                            foreach ($canteens as $canteen)
                            {
                                
                            ?>
                            <tr>
                                <td><?=$j?></td>
                                <td><?= $canteen['cName'] ?></td>
                                <td><?= $canteen['cPhone'] ?></td>
                                <td><?= $canteen['breakfast_count'] ?></td>
                                <td><?= $canteen['lunch_count'] ?></td>
                                <td><?= $canteen['dinner_count'] ?></td>
                                <td><a style="width: 40%;" title="Edit Hostel Details" class="btn btn-primary btn-xs" href="<?=base_url($currentModule."/view_allocated_students/".base64_encode($canteen['id']))?>">View</a></td>
                             
                                <td>
								   <a style="color:blue; font-size: 18px; padding-left: 10px;"   href="<?=base_url($currentModule."/edit_canteen/".base64_encode($canteen['id']))?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
								   
								</td>
                            </tr>
                            <?php
                            $j++;
                            }
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


