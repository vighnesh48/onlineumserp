<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<?php// print_r($all_emp_leave);
?>
<style type="text/css">
    .table-info {height:700px;overflow-y:scroll;}
.table{width:100%;}
</style>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Employees</a></li>
        <li class="active"><a href="#">Employee Documents List</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Employees Documents list</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                   
                </div>
            </div>
        </div>
      
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
               <div class="panel-heading" >
                        <span class="panel-title">
                              <div class="row">
                                List
                            </div>
                       </span>
                    </div>
                <div class="panel-body table-info">
                  
                              <table class="table table-bordered">
                        <thead>
                            <tr>
                                    <th>#</th>
                                    <th>Emp.ID</th>
<th>Name</th>
                                    <th>Department</th>
                                    <th>School</th>		
                                        
							
                                    <th>Action</th>
									
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php
							if(!empty($emplisty)){
                            $j=1;            
                            
							//$ci =&get_instance();
  // $ci->load->model('admin_model');
                            foreach($emplisty as $emp)
                            {
                              //$department =  $ci->admin_model->getDepartmentById($emplisty[$i]['department']); 
								// $school =  $ci->admin_model->getSchoolById($emplisty[$i]['emp_school']); 
								//  $shift =  $ci->admin_model->getshifttime($emplisty[$i]['shift']); 
			//				$doc = $this->Employee_model->get_emp_document_list($emp['emp_reg_id']);
              ?>
														
                            <tr>
							<td><?=$j?></td> 
                                 <?php if($emp['gender'] == 'male'){ $m = 'Mr.'; }elseif($emp['gender'] == 'female'){ $m='Mrs.'; } ?>
                                <td><?=$emp['emp_id']?></td> 
                                <td><?=$m." ".$emp['fname']." ".$emp['lname']?></td>
                                <td>

                                <p>Dept.: <strong><?php  
                                $res=$this->Admin_model->getDepartmentById($emp['department']);
                                                         // print_r($res);                                
                                                          echo $res[0]['department_name'];
                                                          ?></strong></p>
                                                          <p>Desig.: <strong><?php 
                                                          $res=$this->Admin_model->getDesignationById($emp['designation']);
                                                         // print_r($res);                                                          
                                                          echo $res[0]['designation_name'];
                                                          ?></strong></p>
                                                          </td>
                                <td><?php  $school =  $this->Admin_model->getSchoolById($emp['emp_school']); 
                                echo $school[0]['college_name']; ?></td>
                                                       
							
                                <td>
 <?php //if(in_array("Edit", $my_privileges)) { ?>
                                <a href="<?=base_url($currentModule.'/employee_document_add/'.$emp['emp_reg_id'].'')?>" title="Edit"><i class="fa fa-edit"></i></a>
								<?php //} ?>
                                
                                 <a href="#" class=" emp_view" title="<?=$emp['emp_id']?>" id="<?=$emp['emp_reg_id']?>" data-toggle="modal"  data-target="#myModal"><i class="fa fa-eye"></i></a> 
                                </td>
                            </tr>
                            <?php
                            $j++;
                            }}else{
								echo"<tr><td colspan='19'><label style='color:red'>Sorry No records.</label></td></tr>";
							}
                            ?>                            
                        </tbody>
                    </table>                    
                   
                </div>
            </div>
            </div>    
        </div>
    
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width:60%;">

    <!-- Modal content-->
    <div class="modal-content" >
       <div class="modal-header">
        <button type="button" class="btn btn-default pull-right" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" >Emp Id: <strong><span id="empid"></span></strong> 
        </h4>
      </div>
      <div class="modal-body" >
      <div class="row table-responsive">
        <table class="table table-bordered"  >
                        <thead>
                            <tr>
                             <th>#</th>
                                    <th>Document Name</th>                                    
                                    <th>Original or Xerox</th>                                                        
                                    <th>Status</th>                                    
                            </tr>
                        </thead>
                        <tbody id="emp_cnt">                        
                        </tbody>
                        </table>
                        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
    </div>
    </div>
<script>
   $(".emp_view").on('click',function()
        {
            var eid = $(this).attr('id'); 
            //alert(eid);
            var emid = $(this).attr('title');
             var url  = "<?=base_url().strtolower($currentModule).'/get_emp_document/'?>"+eid; 
        
            $.ajax
            ({
                type: "POST",
                url: url,
               // data: data,
                dataType: "html",
                cache: false,
                crossDomain: true,
                success: function(data)
                {  
                $("#empid").text(emid);                 
                        $("#emp_cnt").html(data);                  
                },
                error: function(data)
                {
                    alert("Page Or Folder Not Created..!!");
                }
            });
        });
</script>