<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<script src="<?=base_url('assets/javascripts')?>/jquery.table2excel.js"></script>


<script src="<?=base_url('assets/javascripts')?>/bootstrap-datepicker.js "></script>
                 <script>
                    var base_url = '<?=base_url()?>';
                 function update_paymentstatus(var1)
                 {
                    var ye = confirm("Are you sure you want to update payment status");
                     if(ye)
                     {
                       $.ajax({
                    'url' : base_url + 'phd/update_phdfstatus',
                    'type' : 'POST', //the way you want to send data to your URL
                    'data' : {'fid' : var1},
                    'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
                        var container = $('#semest'); //jquery selector (get element by id)
                        if(data){
                         //   alert(data);
                            alert("Payment status updated successfully");
                            location.reload();
                            //$("#"+type).val('');
                            //container.html(data);
                        }
                    }
                });
                     }
                 }
                 
                 
                 
                 
                 
                 function remove_list(var1)
                 {
                    var ye = confirm("Are you sure you want to update payment status");
                     if(ye)
                     {
                       $.ajax({
                    'url' : base_url + 'phd/remove_phdstudfeelist',
                    'type' : 'POST', //the way you want to send data to your URL
                    'data' : {'fid' : var1},
                    'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
                        var container = $('#semest'); //jquery selector (get element by id)
                        if(data){
                         //   alert(data);
                            alert("Payment status updated successfully");
                            location.reload();
                            //$("#"+type).val('');
                            //container.html(data);
                        }
                    }
                });
                     }
                 }
                 
                 
                 
                 
                 
                 
                 
                 
                 
                 
                 
                 
                 
                 
                 
                 
                                  
                                      function load_streams(type){
                   // alert(type);
                    
                $.ajax({
                    'url' : base_url + 'Ums_admission/load_streams',
                    'type' : 'POST', //the way you want to send data to your URL
                    'data' : {'course' : type},
                    'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
                        var container = $('#semest'); //jquery selector (get element by id)
                        if(data){
                         //   alert(data);
                            //alert("Marks should be less than maximum marks");
                            //$("#"+type).val('');
                            container.html(data);
                        }
                    }
                });
            }
           $(document).ready(function(){
               $('#sbutton').click(function(){
            
         // alert("hi");
             var base_url = '<?=base_url()?>';
                   // alert(type);
                   var pdate = $("#pdate").val();
                    var pstatus = $("#pstatus").val();
                  //  var ayear = $("#admission-year").val();
                    
            
                $.ajax({
                    'url' : base_url + 'phd/load_phd_feelist',
                    'type' : 'POST', //the way you want to send data to your URL
                    'data' : {'pdate':pdate,'pstatus':pstatus},
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
        <li class="active"><a href="#">Fee Payment</a></li>
        <li class="active"><a href="#">Online Fee</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Payment List</h1>
            
        </div>
        <div class="row ">
            <div class="col-sm-12">&nbsp;</div>
        </div>
        <?php
        if($this->session->userdata('role_id')==5 || $this->session->userdata('role_id')==40 || $this->session->userdata('role_id')==6 || $this->session->userdata('um_id')==120){?>
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                <div class="panel-heading">
                        <span class="panel-title">   <div class="form-group">
                           
                             <div class="col-sm-2"></div>
                              <div class="col-sm-4" id="">
                                <select name="pstatus" id="pstatus" class="form-control" required>
                                  <option value="">Select Status</option>
                                   <option value="V">Approved</option>
                                    <option value="P" selected="selected">Pending</option>
                                    <!-- <option value="R">Removed</option>-->
                                  </select>
                              </div>
                              
                            
                              <!--<div class="col-sm-3" id="" >
                               <input type="text" name="pdate" id="pdate" class="form-control" Placeholder="Payment Date">
                              </div>-->
                                
                             
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
                                    <th  width="5%">Receipt No.</th>
                                     <th  width="10%">Bank Ref No</th>
                                      <th>PRN</th>
                                    <th  width="20%">Name</th>
                                   <th>productinfo</th>
                                    
                                     <th  width="5%">Amount </th>
                                    <th  width="5%"> Mode </th>
                                 <th  width="5%">Trans Status</th>
                                    <th  width="5%">Payment Date</th>
                                     <th  width="5%">Verify Status</th>
                                    
                                    <th  width="5%">Action</th>
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php
                            
                       //   var_dump($phd_stud_list);
                            $j=1;                            
                            for($i=0;$i<count($phd_stud_list);$i++)
                            {
                               if(empty($phd_stud_list[$i]['college_receiptno'])){ 
                            ?>
														
                            <tr >
                               <td><?=$j?></td>
                        
                                 <td>
                                     <?php if($phd_stud_list[$i]['payment_status']=="success")
                                     {
                                         
                                     ?>
                                <!--     <a href="http://www.sandipuniversity.com/PHD18/uploads/payments/receipt_<?=$phd_stud_list[$i]['bank_ref_num']?>.pdf" target="_blank"> <?=$phd_stud_list[$i]['receipt_no']?></a>-->
                                      <?=$phd_stud_list[$i]['receipt_no']?>
                                     <?php
                                     }
                                    else
                                     {
                                    echo $phd_stud_list[$i]['receipt_no'];
                                     }
                                     ?>
                                     
                                     </td> 
                                 
                                  <td><?=$phd_stud_list[$i]['bank_ref_num']?></td> 
                                  <td><?=$phd_stud_list[$i]['enrollment_no']?></td>
                                <td><?php echo $phd_stud_list[$i]['firstname']; ?></td> 
								 
								   <td><?=$phd_stud_list[$i]['productinfo']?></td>
                                                                                              
                            <td><?=$phd_stud_list[$i]['amount']?></td>
                         
                                                      
                                <td><?=$phd_stud_list[$i]['payment_mode'];?></td>    
                                    <td><?=$phd_stud_list[$i]['payment_status']?></td> 
                               
                                  <td><?=$phd_stud_list[$i]['payment_date'];?></td> 
                                 <td><?php if(empty($phd_stud_list[$i]['college_receiptno'])){echo "Pending";} else{ echo "Approved";}?></td> 
                                  
                                       <td>
                                           <?php
                        if(($phd_stud_list[$i]['verification_status']=="P") && ($phd_stud_list[$i]['payment_status']=="success")&&($phd_stud_list[$i]['college_receiptno']=='')){
                                           ?>
                                          <!-- <a href="#" onclick="update_paymentstatus('<?=$phd_stud_list[$i]['payment_id']?>')">Verify</a>-->
                                            <a href="<?=base_url()?>Phd/External_challan/<?=$phd_stud_list[$i]['payment_id']?>/<?=$phd_stud_list[$i]['productinfo']?>" target="_blank">Verify</a>
                                            <?php
                            }else{
								echo $phd_stud_list[$i]['college_receiptno'];
							}
                           // echo $phd_stud_list[$i]['payment_status'];
                          
                           if($phd_stud_list[$i]['payment_status']=="failure"){
                                           ?>
                                           <a href="#" onclick="remove_list('<?=$phd_stud_list[$i]['payment_id']?>')">Remove</a> 
                                            <?php
                            }
                          
                            ?></td> 
                             <!--   <td><a  href="<?php //echo base_url()."ums_admission/viewPayments/".$phd_stud_list[$i]['stud_id'].""?>" title="View" target="_blank"><i class="fa fa-credit-card" aria-hidden="true"></i> </a>&nbsp;&nbsp;&nbsp;&nbsp;</td>                         
                                <td><a  href="<?php //echo base_url()."/Subject_allocation/view_studSubject/".$phd_stud_list[$i]['stud_id'].""?>" title="View" target="_blank"><i class="fa fa-book" aria-hidden="true"></i> </a>&nbsp;&nbsp;&nbsp;&nbsp;</td>                         
                                <td>
                                    <p> 
			<a  href="<?php //echo base_url()."ums_admission/view_studentFormDetails/".$phd_stud_list[$i]['stud_id'].""?>" title="View" target="_blank"><i class="fa fa-eye"></i>  </a>&nbsp;&nbsp;&nbsp;&nbsp;
	        <a  href="<?php //echo base_url()."ums_admission/edit_personalDetails/".$phd_stud_list[$i]['stud_id'].""?>" title="Edit"><i class="fa fa-edit"></i> </a>&nbsp;&nbsp;&nbsp;&nbsp;
                             </td>-->
                            </tr>
                            <?php
                            $j++;
                            }
							}
                            ?>                            
                        </tbody>
                    </table> 
						<?php
						if(!empty($phd_stud_list))
						{
							?>
                    <form method="post" action="<?=base_url()?>Ums_admission/generatepdf/">
                    <input type="hidden" name="dcourse" value="<?=$dcourse;?>">
                     <input type="hidden" name="dyear" value="<?=$dyear;?>">
                   <!--  <input type="submit" value="Generate PDF" class="btn btn-primary btn-labeled">-->
                     
                      <input type="button" id="expdata" value="Export as Excel" class="btn btn-primary btn-labeled">
                     </form>
					 <?php
						}
						?>
                 <!--   <table class="table table-bordered">
                        <thead>
                            <tr>
                                   
                                    <th> Sr. No.</th>
                                     <th>PRN</th>
                                    <th>Name</th>
                                    <th>Course </th>
                                    <th>Stream </th>
                                    <th>DOB</th>
                                    <th>Mobile</th>
                                    <th>Email</th>
                             
                                    <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php
                            
                          
                            $j=1;                            
                            for($i=0;$i<count($phd_stud_list);$i++)
                            {
                                
                            ?>
							 <?php if($phd_stud_list[$i]['ro_flag']=='on') $bg="bgcolor='#e6eaf2'";
								  else $bg="";?>								
                            <tr <?=$bg?> <?=$phd_stud_list[$i]["status"]=="N"?"style='background-color:#FBEFF2'":""?>>
                               <td><?=$j?></td>
                        
                                 <td><?=$phd_stud_list[$i]['enrollment_no']?></td> 
                                <td>
							
							<?php
								echo $phd_stud_list[$i]['first_name']." ".$phd_stud_list[$i]['middle_name']." ".$phd_stud_list[$i]['last_name'];
								?>
								</td> 
								 <td><?=$phd_stud_list[$i]['course_name']?></td> 
								   <td><?=$phd_stud_list[$i]['stream_name']?></td> 
                                                                                              
                            <td><?=$phd_stud_list[$i]['dob']?></td>                               
                                                      
                                <td><?=$phd_stud_list[$i]['mobile'];?></td>    
                                <td><?=$phd_stud_list[$i]['email'];?></td> 
                                                    
                                                        
                                <td>
                                    <p> 
			<a  href="<?php echo base_url()."ums_admission/view_studentFormDetails/".$phd_stud_list[$i]['stud_id'].""?>" title="View" target="_blank"><i class="fa fa-eye"></i>  </a>&nbsp;&nbsp;&nbsp;&nbsp;
	        <a  href="<?php echo base_url()."ums_admission/edit_personalDetails/".$phd_stud_list[$i]['stud_id'].""?>" title="Edit"><i class="fa fa-edit"></i> </a>&nbsp;&nbsp;&nbsp;&nbsp;
                             </td>
                            </tr>
                            <?php
                            $j++;
                            }
                            ?>                            
                        </tbody>
                    </table>  -->                  
                    <?php //} ?>
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
    $("#search_me").select2({
      placeholder: "Enter Event name",
      allowClear: true
    });    
        $("#search_me").on('change',function()
        {
            var search_val = $(this).val();            
            var url  = "<?=base_url().strtolower($currentModule).'/search/'?>";	
            var data = {title: search_val};		
            var type="";
            var type_name="";
            $.ajax
            ({
                type: "POST",
                url: url,
                data: data,
                dataType: "html",
                cache: false,
                crossDomain: true,
                success: function(data)
                {  
                     var array=JSON.parse(data);
                    var str="";
                    for(i=0;i<array.emp_details.length;i++)
                    {
                        str+='<tr style="display: table-row; opacity: 1;">';
                        str+='<td>'+(i+1)+'</td>';                                                                                                
                        str+='<td>'+array.emp_details[i].emp_id+'</td>';
									
                        str+='<td><img src=" <?=base_url();?>uploads/employee_profilephotos/'+array.emp_details[i].profile_pic+' " alt="ProfileImage" height="80px"></td>';
                        str+='<td>'+array.emp_details[i].fname+' '+array.emp_details[i].lname+'</td>';
                        str+='<td>Department:'+array.emp_details[i].department_name+'<br>Designation:'+array.emp_details[i].designation_name+'</td>';
                       //joining date duration calculation
					   var user_date = Date.parse(array.emp_details[i].joiningDate);
                       var today_date = new Date();
                       var diff_date =  user_date - today_date;
                       var num_years = diff_date/31536000000;
                       var num_months = (diff_date % 31536000000)/2628000000;
                       var num_days = ((diff_date % 31536000000) % 2628000000)/86400000;
				    
						str+='<td>'+Math.abs(Math.ceil(num_years))+"years,"+Math.abs(Math.ceil(num_months))+"months,"+Math.abs(Math.ceil(num_days))+"days"+'</td>';                            
					    str+='<td>'+array.emp_details[i].mobileNumber+'</td>';
                         if(array.emp_details[i].emp_status=='Y')                        
                        str+='<td><span class="btn btn-success"> active </span></td>';
                       else
						   str+='<td><span class="btn btn-danger"> Inactive </span></td>';
                        str+='<td>';
                        str+='<a href="<?=base_url(strtolower($currentModule))?>/view_emp?id='+array.emp_details[i].emp_id+"&status="+array.emp_details[i].emp_status+'"><i class="fa fa-eye"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;';
                        str+='<a href="<?=base_url(strtolower($currentModule))?>/create_employee?id='+array.emp_details[i].emp_id+"&status="+array.emp_details[i].emp_status+'"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;';
                        str+='<a href="<?=base_url(strtolower($currentModule))?>/deact_emp?id='+array.emp_details[i].emp_id+"&status="+array.emp_details[i].emp_status+'"> <i title="Disable" class="fa fa-ban"></i></a>';
                        str+='</td>';
                        str+='</tr>';
                        $("#itemContainer").html(str);
                    }
                },
                error: function(data)
                {
                    alert("Page Or Folder Not Created..!!");
                }
            });
        });
</script>