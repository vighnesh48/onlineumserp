<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>

<?php //print_r($my_privileges); die; ?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Employee</a></li>
        <li class="active"><a href="#">Notice/Office Order/Circular </a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Notice/Office Order/Circular </h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                  
                    <div class="pull-right col-xs-12 col-sm-auto"><a style="width: 100%;" class="btn btn-primary btn-labeled" href="<?=base_url($currentModule."/add")?>"><span class="btn-label icon fa fa-plus"></span>Add </a></div>                        
                    <div class="visible-xs clearfix form-group-margin"></div>
                   
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
                        <span class="panel-title">#</span><span id="flash-messages" style="color:red;padding-left:110px;"><?php echo $this->session->flashdata('message'); ?></span>
                        <div class="holder"></div>
                </div>
                <div class="panel-body" style="height:700px;overflow-y:scroll;">
			
                    <div class="table-info" >    

                    <table class="table table-bordered table-stripped">
                        <thead>
                            <tr>
                                    <th>#</th>
                                    <th >Title</th>
                                   <th>File Name</th>
                                    <th >Action</th>
                                    
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                              <?php
                              $i=1;
                              if(isset($circulerlist)){
                                  foreach($circulerlist as $row){
                                echo '<tr>
                                <td>'.$i.'</td>
                                 <td>'.$row['title'].'</td>
                                  <td>'.$row['file_attachment'].'</td>
                                    <td><a href="'.base_url($currentModule."/edit/".$row['cid'].'').'" title="Edit"><i class="fa fa-edit"></i></a>
                                    <a  href="'.base_url().$currentModule."/delete_circular/".$row['cid'].'""><i class="fa fa-trash-o" title="Change Status"></i></a></td>
                                    </tr> ';
                                $i++;
                                
                            }
                                 
                              }
                              else{
                                  echo '<tr><td colspan="3">No Records</td></tr>';  
                                  
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
<script>    
    $(document).ready(function(){
		
		
		
		
	});
	
	
</script>