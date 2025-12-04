<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<script src="<?=site_url()?>assets/javascripts/jquery.table2excel.js"></script>
<script>  var base_url = '<?=site_url()?>';
      var prn= '<?=$this->uri->segment(3)?>';
	 // alert(prn);

$(document).ready(function(){
	 $('#sbutton').click(function(){
          //  alert("xxx");
         // alert("hi");
             var base_url = '<?=base_url()?>';
                   // alert(type);
                   var prn = $("#prn").val();
                    var mobile = $("#mobile").val();
                    var fname = $("#fname").val();
                     var mname = $("#mname").val();
                      var lname = $("#lname").val();
                    var fnum = $("#fnum").val();
                    var type = "refund";
                     if(prn=='')
                    {
                        alert("Please Enter PRN Number");
                        return false;
                    }
                    
                    
           
                $.ajax({
                    'url' : base_url + 'Account/stud_search_refunddata',
                    'type' : 'POST', //the way you want to send data to your URL
                    'data' : {'prn':prn,'mobile':mobile,'fname':fname,'mname':mname,'lname':lname,'fnum':fnum,'type':type},
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
        
	if(prn !=''){
		
		 $("#prn").val(prn);		 
		 $("#sbutton").trigger("click");
      }else{
		 
	  }	  
	   
});	  
function common_call()
{
	var refund_for=$('#campus').val();

	type='POST',url='<?= base_url() ?>Account/fees_refund_list_by_creteria';
	datastring={refund_for:refund_for};
	html_content=ajaxcall(type,url,datastring);
	//alert('html_content='+html_content);
	display_content(html_content);		
}

function display_content(html_content)
{
	var content='';
	var content1='';
	if(html_content === "{\"refund_list\":[]}")
	{
		$('#itemContainer').html('');
		$('#expdata').hide();
		$('#err_msg1').html('Records Not Found Please change search criteria and try again');
	}
	else
	{
		$('#err_msg1').html('');
		$('#expdata').show();
		var array=JSON.parse(html_content);
		len=array.refund_list.length;
		//alert(len+"==="+html_content);
		var j=1;
		for(i=0;i<len;i++)
		{
			content+='<tr><td>'+j+'</td><td>'+array.refund_list[i].enrollment_no+'</td><td>'+array.refund_list[i].first_name+' '+array.refund_list[i].middle_name+' '+array.refund_list[i].last_name+'</td><td>'+array.refund_list[i].academic_year+'</td><td>'+array.refund_list[i].stream_short_name+'</td><td>'+array.refund_list[i].year+'</td><td>'+array.refund_list[i].amount+'</td><td>'+array.refund_list[i].total_fee+'</td><td>'+array.refund_list[i].actual_fee+'</td><td>'+array.refund_list[i].applicable_fee+'</td>';
			
			//<td style="color: red;"><?=  date('d-m-Y',strtotime($emp_list[$i]['refund_date']));?></td> 
			
			fdate = new Date(array.refund_list[i].refund_date);
			fdate_dd = fdate.getDate();
			fdate_mm = fdate.getMonth()+1;
			tdate_yy = new Date(array.refund_list[i].refund_date).getFullYear();
			if(fdate_dd<10){
			fdate_dd='0'+fdate_dd;
			} 
			if(fdate_mm<10){
			fdate_mm='0'+fdate_mm;
			}
			//alert(fdate_dd+' '+fdate_mm+' '+tdate_yy);
			content+='<td style="color: red;">'+fdate_dd+'/'+fdate_mm+'/'+tdate_yy+'</td>';
			
			content+='<td>'+array.refund_list[i].remark+'</td><td>'+array.refund_list[i].refund_paid_type+'</td><td>'+array.refund_list[i].receipt_no+'</td>';
			
			//<td><?php if($emp_list[$i]['refund_for']=="C"){echo "Cancellation";}if($emp_list[$i]['refund_for']=="E"){echo "Excess Payment";}?></td> 
			if(array.refund_list[i].refund_for=='C')
			rtype="Cancellation";
		else
			rtype="Excess Payment";
			
			content+='<td>'+rtype+'</td><td>'+array.refund_list[i].bank_name+'</td><td>'+array.refund_list[i].bank_city+'</td><td class="noExl"><p><a href="'+base_url+'Account/edit_refund/'+array.refund_list[i].fees_id+'" title="Edit" ><i class="fa fa-edit"></i> &nbsp; </a><a href="javascript:void(0);" title="Delete"   onclick="deletethis('+array.refund_list[i].fees_id+')"><i class="fa fa-trash-o"></i>&nbsp;  </a></p></td></tr>';
			
			j++;
		}
		$('#itemContainer').html(content);
	}
	
}

function ajaxcall(type,url,datastring)
{  
	var res;
	$.ajax({
		type:type,
		url:url,
		data:datastring,
		cache:false,
		async:false,
		success: function(result)
	 {
	  res=result;	 
	 }
	});
	return res; 
}



    $(document).ready(function()
    {
		$('#campus').change(function() {
		common_call();
	});
		
	$('#form1').bootstrapValidator	
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
					search_id:	
                         {
                             validators: 
                               {
                                    notEmpty: 
                                       {
                                        message: 'Please Enter Student Id,this should not be empty'
                                         }                     
                                }
						  }
				  }
})	
	});
	
	
	
	
function deletethis(var2){
//alert(var2);
//return false;
//alert(var1);

                    
var text='';

  text = "Are you sure you want to  Delete";  

//var txt;
    if (confirm(text) == true) {
       // txt = "You pressed OK!";
        
    } 
    else
    {
        return false;
    }


 $.ajax({
                    'url' : base_url + 'Account/delete_refund',
                    'type' : 'POST', 
                    'data' : {'fid':var2},
                    'success' : function(data){ 
                       //if(type1=="S"){var container = $('#stest');}else{var container = $('#ptest');} //jquery selector (get element by id)
                        if(data){
                            
                    //   alert(data);
                            alert("Record deleted Successfully");
                          //  $("#makepmnt").hide();
                           // $("#hidet").hide();
                            //$("#"+type).val('');
                          //  container.html(data);
                          location.reload();
                            	return false;
                        }
                          return false;
                    }
                });
}


	
	
	
	
	
	
	
	
	
	
	 $(document).ready(function(){
	    //  $('#table2excel tr > *:nth-child(2)').hide();
                  });
            
</script>
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="#">Account</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Fees Refund</h1>
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
                     

                    <div id="dashboard-recent" class="panel panel-warning">        
                     <div class="panel-heading">
                       <span class="panel-title"><i class="panel-title-icon fa fa-fire text-danger"></i>Fees Refund</span>
			    		</div>
			    		<div class="panel-body">
						
						<!--<form id="form1" name="form1" enctype="multipart/form-data" action="<?=base_url($currentModule.'/search_student')?>" method="POST">-->
						
					  <div class="row">
					   <div class="form-group">
					   <div class="col-sm-3"></div>
					   <div class="col-sm-6">
					   <?php 
					   echo "<span style='color:red;padding-left:110px;'>".@$this->session->flashdata('message1')."</span>";
					   ?>
					   </div>
					 </div>                      
                      </div>
                       <div class="row">
					<div class="col-sm-12">
					  <label class="col-sm-2 control-label">Student PRN</label>
                      <div class="col-sm-3"><input type="text" class="form-control" name="prn" id="prn" placeholder="Enter Student PRN No."></div>
                      <div class="col-sm-2"><button class="btn btn-primary form-control" id="sbutton" type="button" >Search</button></div>
					   <div class="col-sm-2"></div>
				</div>
					  </div>
					  <br>
					  <!--div class="row">
					  
					   <div class="col-sm-12">
							<label class="col-sm-2 control-label">Refund Type:</label>
                      <div class="col-sm-3">
					  <select id="campus" name="campus" class="form-control" >
								  <option value="">Select Refund Type</option>
								  <option value="C">Cancelled</option>
								  <option value="E">Excess Amount</option>
						</select>
						</div>
						 <div class="col-sm-3"><button class="btn btn-primary form-control" id="expdata" type="button" >Download Excel</button></div>
						
					   </div>
					                      
                      </div>
					 <br-->
					 <!-- </form>-->
                
                
   
               
                    <div class="table-info" id="stddata" style="overflow: auto;">  
                    <?php
             //   var_dump($emp_list);
                    if(count($emp_list)>0)
                    {
                        
                    ?>
                    <style>
                   
                    /*.table-info thead th, .table-info thead tr{background: #774545;border-color:#FFFFFF !important}*/
                    </style>
                    
                    <table class="table table-bordered" id="table2excel">
                        <thead>
                            <tr style="">
                                 <th>Sr No</th>
                                    <th>PRN</th>
                                    
                                    <th>Name</th>
                                      <th>Academic Year</th>
                                    <th>Stream </th>
                                  <th>Year </th>
                                  
                                     <th>Amount Refunded</th>
                                       <th>Fee Received</th>
                                        <th>Actual Fee</th>
                                         <th>Applicable Fee</th>
                                    <th>Refund Date</th>
                                     <th>Remark</th>
                                      <th>Refund Mode</th>
                                      <th>CHQ/DD Number</th>
                                       <th>Refund For</th>
                                       <th>Bank</th>
                                       <th>Bank Branch</th>
                                  <th class="noExl" >Action</th>
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php
                          //  var_dump($emp_list);
                          
                            $j=1;                            
                            for($i=0;$i<count($emp_list);$i++)
                            {
                                
                            ?>
							 <?php if($emp_list[$i]['ro_flag']=='on') $bg="bgcolor='#e6eaf2'";
								  else $bg="";?>								
                            <tr <?=$bg?> <?=$emp_list[$i]["status"]=="N"?"style='background-color:#FBEFF2'":""?>>
                               
		<td><?=$j?></td>
		<td><?=$emp_list[$i]['enrollment_no']?></td> 


		<td>
		<?php
		echo $emp_list[$i]['first_name']." ".$emp_list[$i]['middle_name']." ".$emp_list[$i]['last_name'];
		?>
		</td> 
		<td><?=$emp_list[$i]['academic_year']?></td> 
		<td><?=$emp_list[$i]['stream_short_name']?></td> 
		<td><?=$emp_list[$i]['year']?></td>                                                          



		<td><?=$emp_list[$i]['amount'];?></td> 


		<td><?=$emp_list[$i]['total_fee']?></td>
		<td><?=$emp_list[$i]['actual_fee']?></td> 
		<td><?=$emp_list[$i]['applicable_fee']?></td> 





		<td style="color: red;"><?=  date('d-m-Y',strtotime($emp_list[$i]['refund_date']));?></td> 
		<td><?=$emp_list[$i]['remark'];?></td> 


		<td><?=$emp_list[$i]['refund_paid_type'];?></td> 
		<td><?=$emp_list[$i]['receipt_no'];?></td> 
		<td><?php if($emp_list[$i]['refund_for']=="C"){echo "Cancellation";}if($emp_list[$i]['refund_for']=="E"){echo "Excess Payment";}?></td> 
		<td><?=$emp_list[$i]['bank_name'];?></td> 
		<td><?=$emp_list[$i]['bank_city'];?></td> 


		<td class="noExl" >
		<p> 



		<a href="<?php echo base_url()."Account/edit_refund/".$emp_list[$i]['fees_id'].""?>" title="Edit" ><i class="fa fa-edit"></i> &nbsp; </a>
		<a href="javascript:void(0);" title="Delete"   onclick="deletethis('<?=$emp_list[$i]['fees_id'];?>')"><i class="fa fa-trash-o"></i>&nbsp;  </a>



		</p>  
		</td>
                              <!--  <td class="noExl" style="padding:0px;" align="center">
                                    <p> 
			<a  href="<?php echo base_url()."ums_admission/view_studentFormDetails/".$emp_list[$i]['stud_id'].""?>" title="View" target="_blank"><i class="fa fa-eye"></i>&nbsp;  </a>
	       
	      
                             </td>-->
                            </tr>
                            <?php
                            $j++;
                            }
                            ?>                            
                        </tbody>
                    </table>
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
<script>
$("#expdata").click(function(){

  $('#table2excel tr > *:nth-child(2)').show();
  $("#table2excel").table2excel({

    exclude: ".noExl",

    name: "Worksheet Name",
  filename: "Student List" //do not include extension

  });
   // $('#table2excel tr > *:nth-child(2)').hide();

});
</script>