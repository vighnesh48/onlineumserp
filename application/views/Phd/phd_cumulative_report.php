
<?php //echo  "<pre>"; print_r($unittest); die;
$role_id = $this->session->userdata('role_id');
 ?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#"></a></li>
        <li class="active"><a href="#"></a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp; Ph.D. Registration Cumulative Report</h1>
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
                     <div class="row ">
                             <div class="col-sm-9">
                                  <!--form method="post12"-->

			<div class="col-sm-2 from-group"><h4>Academic Year</h4></div>
				<div class="col-sm-2">
				    <select id="pstatus" name="pstatus" class="form-control" >
				      <!--option value="">select</option--> 
					  <option value="2018" selected>2019-20</option> 
					</select>                                                            
				</div>

		
			<div class="col-sm-4"><input type="button" value="Search" class="btn btn-primary" id="btnsearch">
			
			</div>	
<!--/form-->
                             </div>   
                     </div> 
                </div>
      
                <div class="panel-body" style="overflow:scroll;height:800px;">
                    <div class="table-info">    
                    <?php //if(in_array("View", $my_privileges)) { ?>
                    <table  id="search-table" class="table table-bordered table-list-search">
                        <thead>
                            <tr>
                                    <th>#</th>
                                    
                                  <th>Department</th>
                                  <th>No. Registration</th>     
                            </tr>
                            
                        </thead>
                        <tbody id="itemContainer">
                            <?php
                            $j=1; 
$tot =array();							
						if(!empty($phd_data)){							
                            for($i=0;$i<count($phd_data);$i++)
                            {
                               $tot[] = $phd_data[$i]['dept_stud_cnt'];
                            ?>
                            <tr  class="myHead">
                                <td><?=$j?></td>          
								<td><?=$phd_data[$i]['department']?></td> 
								<td><?=$phd_data[$i]['dept_stud_cnt']?></td> 
                            </tr>
                            <?php
                            $j++;
                            }
						}else{ echo "<tr><td colspan=3>No data found</td></tr>";}
                            ?>  
							<tr >
                                <td colspan="2">Total:</td>  
								<td><b><?php echo array_sum($tot);?></b></td> 
                            </tr>
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<script type="text/javascript">
$(document).ready(function() { 
	$("#btnsearch").on('click',function(){
		location.reload();
	});	
});
</script>
