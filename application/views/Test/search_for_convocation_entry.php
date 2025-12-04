
<style>
.model{overflow: hidden !important;}
.clickable{
    cursor: pointer;   
    	margin-top: 12px;
	   font-size: 15px;
}


    .modal-dialog {
      width: 100%;
      padding: 0;
      margin:0;
    }
    
    .modal-body{
    max-height:calc(100vh - 100px);
    overflow-y: auto;
    }
.modal-open {
    overflow: hidden;
}

.loader {
  border: 6px;
  border-radius: 50%;
  border-top: 6px solid pink;
  border-bottom: 6px solid pink;
  width: 90px;
  height: 90px;
  -webkit-animation: spin 2s linear infinite;
  animation: spin 2s linear infinite;
}

@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

</style>
<?php $prn=$this->uri->segment(3);?>
<script>


    var base_url = '<?=base_url();?>';

$(document).ready(function(){
	
const input = document.querySelector("input");
//const log = document.getElementById("values");
input.addEventListener("input", updateValue);

function updateValue(e) {
	console.log(e);
  var prn = e.target.value;
  //alert(prn);
}

	var username= '<?=$prn?>';
	if(username !=''){
	//alert(username);
	$("#prn").val(username);
	var stud=1;
	
}else{
	var stud=0;
}
	
 $('#btnView').click(function(){
                var prn = $("#prn").val();
               
                
                  if(prn==""){
                      alert("Please select All  Options ");
                  }
                  else {
                      $("#loader1").html('<div class="loader"></div>');
                      $.ajax({
                                'url' : base_url + 'Test/student_conv_entry_list',
                                'type' : 'POST', //the way you want to send data to your URL
                                'data' : {'prn':prn},
                                'success':function (str) {
                                 //alert(str);
                                 
                                  $("#rowdata").css('display','');
                                  $("#reportdata").html(str);
                                   $("#loader1").html("");
                                }
                          });
                      
                  }
                     
                  
        });
//
  if(stud==1){
        $("#btnView").trigger("click");
    }
});	
</script>
<?php 
if(isset($role_id) && $role_id==1 ){
?>
<style>
	.table{width: 150%;}
	table{max-width: 150%;}
</style>									
<?php }else{ ?>
	<style>
	table.dataTable{width: 210%;}</style>
<?php }?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Exam</a></li>
        <li class="active"><a href="#">Reports</a></li>
    </ul>
	
<div class="col-sm-12" >
      <div class="page-header">	
		<div class="panel">
                <div class="panel-heading">
                        <span class="panel-title">  Search Convocation Entry:</span>
				</div>						

        <div class="row panel-body">
                         
                            <div class="form-group">
                             <!-- <label class="col-sm-2">Course<sup class="redasterik" style="color:red">*</sup></label>-->
							  <div class="col-sm-2">
								<input type="text" name="prn" id="prn" class="form-control" value="" placeholder="Enter PRN" required >
                              </div>

                               <div class="col-sm-2" id="semest">
								<button class="btn btn-primary" id="btnView" value="view">view</button>
							</div>
                            </div>
							</div>
                       
            </div> 
<div id="loader12"> </div></center>			
    <div class="row" id="reportdata"> </div>
        </div>
    </div>
</div>
