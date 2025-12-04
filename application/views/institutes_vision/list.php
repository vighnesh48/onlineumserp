<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>



<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Masters</a></li>
    </ul>

    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm">
                <i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp; Institutes Vision
            </h1>
            <span id="err_msg" style="color:red;"></span>
			
			<div class="pull-right col-xs-4 col-sm-auto">
				<a style="width: 100%;" class="btn btn-primary btn-labeled" href="<?=base_url('institutes_vision/create')?>"><span class="btn-label icon fa fa-plus"></span>Add</a>
			</div>

			<span id="flash-messages" style="color:Green;">
				<?php if(!empty($this->session->flashdata('message1'))){ echo $this->session->flashdata('message1'); } ?>
			</span>
			<span id="flash-messages" style="color:red;">
				<?php if(!empty($this->session->flashdata('message2'))){ echo $this->session->flashdata('message2'); } ?>
			</span>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-heading">
                        <span class="panel-title"><b>List</b></span>
                    </div>

                    <div id="show_list" class="panel-body" >
                        <div class="table-info">    
                            <table class="table table-bordered" style="width:100%;max-width:100%;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Institute Name</th>
                                        <th>Vision</th>
                                        <th>Mission</th>
                                        <th>Academic Year</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="itemContainer">
                                    <?php
                                    $j = 1;
                                    foreach ($visions as $row):
									//echo $row->institutes_id;
									//print_r($row);exit;
                                    ?>
                                    <tr>
                                        <td><?=$j?></td>
                                        <td><?=$row->school_name?></td> <!-- You can replace with name if needed -->
                                        <td><?=$row->vision?></td>
                                        <td><?=$row->mission?></td>
                                        <td><?=$row->academic_year?></td>
                                        <td><?=$row->status == 1 ? 'Active' : 'Inactive'?></td>
                                        <td>
                                            <a title="Edit Vision" class="btn btn-primary btn-xs" href="<?=base_url('institutes_vision/edit/'.$row->id.'/1')?>">Edit</a>
                                            <a title="Delete Vision" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure?')" href="<?=base_url('institutes_vision/delete/'.$row->id)?>">Delete</a>
                                        </td>
                                    </tr>
                                    <?php $j++; endforeach; ?>
                                </tbody>
                            </table>                    
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </div>
</div>
