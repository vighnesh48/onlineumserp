<?php //echo  "<pre>"; print_r($unittest); die;
$role_id = $this->session->userdata('role_id');
//var_dump($_SESSION);
 ?>
 <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"rel="stylesheet" type="text/css" />
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css"rel="stylesheet" type="text/css" />
 <script src="<?=base_url('assets/javascripts')?>/jquery.table2excel.js"></script>
 <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
 <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
<div id="content-wrapper">
<ul class="breadcrumb breadcrumb-page">
   <div class="breadcrumb-label text-light-gray">You are here: </div>
   <li class="active"><a href="#">Admission</a></li>
   <li class="active"><a href="#">Provisional Admissions 2020-21</a></li>
</ul>

    <div class="page-header">	
        
        
        <div class="row ">
            <div class="col-sm-12">
  <strong> <span id="flash-messages" style="color:Green;padding-left:50px;">
						 <?php if(!empty($this->session->flashdata('message1'))){ echo $this->session->flashdata('message1'); } ?></span></strong>
        
        </div>
        </div>
   
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                    
                <div class="panel-heading">
                     <div class="row ">
                             <div class="col-sm-5">Send login details</b></div>                          
                                
                       	  
                             
                     </div> <div class="row">
						<div class="col-sm-3">
							<input type="text" class="form-control" required name="prn" id="prn" pattern="[0-9.]+" placeholder="PRN No." onkeypress="return isNumberKey(event);"/>
						</div>
                        <div class="col-sm-2">
						<button class="btn btn-primary form-control " id="sbutton" type="button" >Submit</button>
						</div>
                        
						<div class="col-sm-5">
							<span style="color:red;" id="err_msg"></span>
						</div>
					</div>
                </div>
                <div class="panel-heading">
                     <div class="row ">
                             <div class="col-sm-5">Create login details</b></div>                          
                                
                       	  
                             
                     </div> <div class="row">
						<div class="col-sm-3">
							<input type="text" class="form-control" required name="login" id="login" pattern="[0-9.]+" placeholder="PRN No." onkeypress="return isNumberKey(event);"/>
						</div>
                        <div class="col-sm-2">
						<button class="btn btn-primary form-control " id="lbutton" type="button" >Submit</button>
						</div>
                        
						<div class="col-sm-5">
							<span style="color:red;" id="err_msg2"></span>
						</div>
					</div>
                </div>
</div>
</div>
</div> 



        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                <div class="panel-body" style="overflow:scroll;height:800px;">
                    
                   
                    <div class="table-info">    
                    <?php //if(in_array("View", $my_privileges)) { ?>
                                        
                    <?php //} ?>
                     <p><?php // echo $links; ?></p>
                </div>
                </div>
            </div>
            </div>    
        </div>
    </div>
</div>


     
     


<script type="text/javascript">
function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : evt.keyCode
    if((charCode > 31 && (charCode < 48 || charCode > 57))){
		$('#err_msg').html("Only Number allowed");
		return false;
	}else{
		$('#err_msg').html("");
			return true;
	}
}
$(document).ready(function() {
  //  $('#search-table').DataTable();
} );
/*$(document).ready(function () {
  $('#search-table').DataTable({
    "paging": false // false to disable pagination (or any other option)
  });
  $('.dataTables_length').addClass('bs-select');
});*/

		$(document).ready(function() {
		    
	       $('#sbutton').click(function()
	{
		// alert("hi");
		var base_url = '<?=base_url();?>';
		// alert(type);
		var prn = $("#prn").val();
		
		
		
		
		
		

		if(prn=='' )
		{
			$('#err_msg').html("Please enter PRN Number.");
			$('#std_details').hide();
			$('#fee_details').hide();
			    //    $("#form").trigger("reset");

			$('#btns').hide();
			return false;
		}
        else
		{  
			$.ajax({
				'url' : base_url + 'Provisional_admission/send_login',
				'type' : 'POST', //the way you want to send data to your URL
				'data' : {'enrollment_no':prn},
				'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
					//var container = $('#stddata'); //jquery selector (get element by id)
					//alert(data);
					if(data==1)
					{
						
						
						$('#err_msg').html('Login to Send');
						
							
					}
					else
					{
						//$('#std_details').hide();
						//$('#fee_details').hide();
						$('#err_msg').html('Faild');
						//return false;
					}
				}
			});
		}
    });		     
	
	
	   
	       $('#lbutton').click(function()
	{
		// alert("hi");
		var base_url = '<?=base_url();?>';
		// alert(type);
		var prn = $("#login").val();
		
		
		
		
		
		

		if(prn=='' )
		{
			$('#err_msg2').html("Please enter PRN Number.");
			$('#std_details').hide();
			$('#fee_details').hide();
			    //    $("#form").trigger("reset");

			$('#btns').hide();
			return false;
		}
        else
		{  
			$.ajax({
				'url' : base_url + 'Provisional_admission/create_login',
				'type' : 'POST', //the way you want to send data to your URL
				'data' : {'enrollment_no':prn},
				'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
					//var container = $('#stddata'); //jquery selector (get element by id)
					//alert(data);
					if(data!='')
					{
						
						
						$('#err_msg2').html(data);
						
							
					}
					else
					{
						//$('#std_details').hide();
						//$('#fee_details').hide();
						$('#err_msg2').html('Faild');
						//return false;
					}
				}
			});
		}
    });		         
	
	
	
	
	
	    
$("#expdata").click(function(){

  $("#search-table").table2excel({

    exclude: ".noExl",

    name: "Worksheet Name",
  filename: "Student List" //do not include extension

  });

});	    
		    
		     $(document).on("click", '#editpayment', function () {

         //   var fees_id = $(this).attr("data-fees_id");
	
var stud_id = $(this).attr("data-reg_id");
var stud_name = $(this).attr("data-stud_name");
var stud_reg_no = $(this).attr("data-prov_regno");
var stud_prog = $(this).attr("data-prog_name");


			$("#stud_name").html(stud_name);
$("#reg_no").html(stud_reg_no);
$("#freg_no").val(stud_reg_no);
$("#course_name").html(stud_prog);
$("#fstud_id").val(stud_id);

      
    									    

    });		    
		    	    
		$("#btnsearch").on('click',function(){
	//	var ic = $("#ic").val();
		var doa = $("#doa").val();
	    var reftype = $("#reftype").val();
		var refby = $("#refby").val();
		var url  = '<?=base_url()?>/Provisional_admission/search_admissions';	
		var data = {'reftype':reftype,'refby':refby,'doa':doa};		
		$.ajax({
			type: "POST",
			url: url,
			data: data,
			dataType: "html",
			cache: false,
			crossDomain: true,
			success: function(data){
				$('#itemContainer').html(data);
			//	$('#block').html('');
			//	return false;
			},
			error: function(data){
				alert("Page Or Folder Not Created..!!");
			}
		});
	});

		$("#reftype").on('change',function(){
		var reftype = $(this).val();
	//	alert(reftype);
	//	var doa = $("#doa").val();
		var url  = '<?=base_url()?>/Provisional_admission/get_references';	
		var data = {'reftype':reftype};		
		$.ajax({
			type: "POST",
			url: url,
			data: data,
			dataType: "html",
			cache: false,
			crossDomain: true,
			success: function(data){
				$('#refby').html(data);
			//	$('#block').html('');
			//	return false;
			},
			error: function(data){
				alert("Page Or Folder Not Created..!!");
			}
		});
	});	
		    
		  $('.numbersOnly').keyup(function () {
			if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
				this.value = this.value.replace(/[^0-9\.]/g, '');
			}
		});  
		    
		    
		    
		    
		    
		    
		    
		    $('#doa').datepicker({format: 'dd/mm/yyyy',autoclose: true});
		      $('#canc_date').datepicker({format: 'dd/mm/yyyy',autoclose: true});
    var activeSystemClass = $('.list-group-item.active');

    //something is entered in search form
    $('#system-search').keyup( function() {
       var that = this;
        // affect all table rows on in systems table
        var tableBody = $('.table-list-search tbody');
        var tableRowsClass = $('.table-list-search tbody tr');
        $('.search-sf').remove();
        tableRowsClass.each( function(i, val) {
        
            //Lower text for case insensitive
            var rowText = $(val).text().toLowerCase();
            var inputText = $(that).val().toLowerCase();
            if(inputText != '')
            {
                $('.search-query-sf').remove();
                tableBody.prepend('<tr class="search-query-sf"><td colspan="9"><strong>Searching for: "'
                    + $(that).val()
                    + '"</strong></td></tr>');
            }
            else
            {
                $('.search-query-sf').remove();
            }

            if( rowText.indexOf( inputText ) == -1 )
            {
                //hide rows
                tableRowsClass.eq(i).hide();
                
            }
            else
            {
                $('.search-sf').remove();
                tableRowsClass.eq(i).show();
            }
        });
        //all tr elements are hidden
        if(tableRowsClass.children(':visible').length == 0)
        {
            tableBody.append('<tr class="search-sf"><td class="text-muted" colspan="8">No records  found.</td></tr>');
        }
    });
});
		</script>
