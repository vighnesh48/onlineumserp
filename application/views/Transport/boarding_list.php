<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>

<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Masters</a></li>
        <li class="active"><a href="<?=base_url($currentModule)?>">Transport</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-5 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp; Boarding List</h1>
			<div class="pull-right col-xs-4 col-sm-auto"><a style="width: 100%;" class="btn btn-primary btn-labeled" href="<?=base_url($currentModule."/add_boarding_details")?>"><span class="btn-label icon fa fa-plus"></span>Add </a></div>

		
        </div>

        <div class="row ">
            <div class="col-sm-12">
               <div class="panel">
             	<div class="panel-heading">
                    <span class="panel-title"><b>List Of All Boarding Points</b></span><span id="err_msg" style="color:red;padding-left:50px;"></span>
					
                </div>	
				<div class="panel-body" >
                <h4 id="flash-messages" style="color:Green;padding-left:250px;">
				<?php if(!empty($this->session->flashdata('message1'))){ echo $this->session->flashdata('message1'); } ?></h4>
				<h4 id="flash-messages" style="color:red;padding-left:250px;">
				<?php if(!empty($this->session->flashdata('message2'))){ echo $this->session->flashdata('message2'); } ?></h4>
                 <?php
				if(!empty($boarding_details))
				{
					?>   <div class="table-info table-responsive" >    
                    
                    <table class="table table-bordered" >
                        <thead>
						<tr>
                                    <th>#</th>
                                    
									<th>Campus</th>
									
									<th>Boarding Point</th>
                                    <th>Distance From Campus (Km)</th>
									<!--<th>Pickup timing</th>
									<th>Drop timing</th>-->
                                    <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                              <?php
							  
                            $j=1;                      
                            for($i=0;$i<count($boarding_details);$i++)
                            {
								?>
								<tr>
									<td><?=$j?></td>                                                                
									<td><?=$boarding_details[$i]['campus']?></td>
									<td><?=$boarding_details[$i]['boarding_point']?></td>
									<td><?=$boarding_details[$i]['distance_from_campus']?></td>
									<!--<td><?=$boarding_details[$i]['pickup_timing']?></td>
									<td><?=$boarding_details[$i]['drop_timing']?></td>-->
									<td>
									   <a title="Edit Boarding Details" class="btn btn-primary btn-xs" href="<?=base_url($currentModule."/edit_boarding_details/".$boarding_details[$i]['board_id'])?>">Edit</a>
									</td>
								</tr>
								<?php
								$j++;
                            }
                            ?>                           
                        </tbody>
                    </table>                    
                   
                </div>
				<?php
				}else{
					?>
					<h4 style="color:red;padding-left:200px;">Boarding Points Have Not Found</h4>
					<?php
				}
				  ?>
				   </div>
                </div>
            </div>
			
            </div>    
        </div>
    </div>
</div>

