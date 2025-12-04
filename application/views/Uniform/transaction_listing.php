<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<script src="<?=base_url('assets/javascripts')?>/jquery.table2excel.js"></script>


<script src="<?=base_url('assets/javascripts')?>/bootstrap-datepicker.js "></script>
                 <script>
                
           $(document).ready(function(){
               $('#sbutton').click(function(){
            
         // alert("hi");
             var base_url = '<?=base_url()?>';
                   // alert(type);
                   var pdate = $("#pdate").val();
                    var tdate = $("#tdate").val();
                  //  var ayear = $("#admission-year").val();
                    
            
                $.ajax({
                    'url' : base_url + 'Uniform/load_transactionlist',
                    'type' : 'POST', //the way you want to send data to your URL
                    'data' : {'pdate':pdate,'tdate':tdate},
                    'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
                        var container = $('#stddata'); //jquery selector (get element by id)
                        if(data){
                            
                        //  alert(data);
                            //alert("Marks should be less than maximum marks");
                            //$("#"+type).val('');
                            container.html(data);
                            	return false;
                        }
                          return false;
                    }
                });
            });
            });
            
            
            
                                    </script>
									
	<style>
	.table{width:100%;}
	table{max-width: 100%;}
	</style>

<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Uniform</a></li>
        <li class="active"><a href="#">Transactions</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                    <?php //if(in_array("Add", $my_privileges)) { ?>
                    <div class="visible-xs clearfix form-group-margin"></div>
                    <?php// } ?>
                    <?php //if(in_array("Search", $my_privileges)) { ?>
                   <!--<form class="pull-right col-xs-12 col-sm-6" action="">
                        <div class="input-group no-margin">
                            <span style="border:none;background: #fff;background: rgba(0,0,0,.05);" class="input-group-addon"><i class="fa fa-search"></i></span>
                            <select id="search_me" name="search_me" style="border:none;background: #fff;background: rgba(0,0,0,.05);" class="form-control no-padding-hr" placeholder="Search...">
                                <option value="">Select Title</option>
                                <?php
                                    for($i=0;$i<count($emp_list);$i++)
                                    {
                                ?>
                                <option value="<?=$emp_list[$i]['emp_id']?>"><?=$emp_list[$i]['fname'].' '.$emp_list[$i]['lname']?></option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>
                    </form>-->
                    <?php //} ?>
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-sm-12">&nbsp;</div>
        </div>
        <?php
        if($this->session->userdata('role_id')==54 || $this->session->userdata('role_id')==5 || $this->session->userdata('role_id')==6){?>
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                <div class="panel-heading">
                        <span class="panel-title">   <div class="form-group">
                           
                             
                              
                            
                              <div class="col-sm-3" id="" >
                               <input type="text" name="pdate" id="pdate" class="form-control" Placeholder="Transaction From Date">
                              </div>
							  
							  <div class="col-sm-3" id="" >
                               <input type="text" name="tdate" id="tdate" class="form-control" Placeholder="Transaction To Date">
                              </div>
                                
                             
                              <div class="col-sm-2" id="semest">
                                 <input type="button" id="sbutton" class="btn btn-primary btn-labeled" value="Search" > 
                                  </div>
                            </div></span>
                        
                </div>

            <div class="table-info panel-body" style="overflow:scroll;height:500px;">  
                <form id="filterdata" method="post" action ="">
                
          
              
              
              
                
                </form>

                <div class="col-lg-12">
                    <div class="table-info table-responsive" id="stddata" >    
                  
                  
                  <table class="table table-bordered" id="table2excel">
                        <thead>
                            <tr>
                                   
                                    <th width="5%"> Sr. No.</th>
                                    <th  width="5%">Transaction No</th>
                                     <th  width="10%">Enrollment no</th>
                                    <th  width="20%">Student Name</th>
                 <!-- *********<th  width="10%">REMARK</th>******************* -->
                                    <th  width="10%">Remark</th>
                                    <th  width="5%">Action</th>
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                           </tbody>
                    </table>   
                    <form method="post" action="<?=base_url()?>Ums_admission/generatepdf/">
                    <input type="hidden" name="dcourse" value="<?=$dcourse;?>">
                     <input type="hidden" name="dyear" value="<?=$dyear;?>">
                   <!--  <input type="submit" value="Generate PDF" class="btn btn-primary btn-labeled">-->
                     
                      <input type="button" id="expdata" value="Export as Excel" class="btn btn-primary btn-labeled">
                     </form>
                
                </div>
                </div>
                </div>
            </div>
            </div>    
        </div>
    </div>
</div>
<?php }
else
{
    
  echo "You dont have permission  to access this page";  
}
?>
<script>

                     $("#expdata").click(function(){

  $("#table2excel").table2excel({

    exclude: ".noExl",

    name: "Worksheet Name",
  filename: "Payment" //do not include extension

  });

});

                       

  $("div.holder").jPages
  ({
    containerID : "itemContainer"
  });
  
    $('#pdate').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
	$('#tdate').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $("#search_me").select2({
      placeholder: "Enter Event name",
      allowClear: true
    });    
       </script>
