<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>

<script>    
    $(document).ready(function(){
     var base_url = 'https://erp.sandipuniversity.com/';

        $('#btnView').click(function(){
               var check_by = $("#check_by").val();
               var ref_no = $("#ref_no").val();
               
                var urldata='check_by='+check_by+'&ref_no='+ref_no;
         
              if(check_by=="0" ||ref_no==""){
                      alert("Please select all proper options ");
                      return false;
                  }
                  else{
                 
                       $("#loader1").html('<div class="loader"></div>');
                    $.ajax({
                            'url' : base_url + '/account/check_payment_status',
                            'type' : 'POST', //the way you want to send data to your URL
                            'data' : urldata,
                            'success':function (str){
                            // alert(str);
                             $("#loader1").html('');
                              $("#reportdata").html(str);
                            }
                      });
               }

        });
      
		
    });

</script>

<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Account</a></li>
        <li class="active">Transaction Status<a href="#"></a></li>
    </ul>

    <div class="page-header">
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-heading">
                            <span class="panel-title form-group"><i class="fa fa-list-alt page-header-icon h3"></i>&nbsp;&nbsp;Transaction Status </span>
                    </div>
                    <div class="panel-body">  
      
                        <div class="table-info">
                             <div class="row">
                                   <div class="form-group">
                                            <div class="col-sm-1"></div>
                						    <label class="col-sm-2 control-label text-right" ><h4>Check By :</h4></label>
                						    <div class="col-sm-3">
                                    	        <select id="check_by" name="check_by" class="form-control"  >
        											<option value="0"> Select Checked By</option>
        												<option value="1">College Receipt No</option>
        													<option value="2">CHQ/DD No.</option>
        													<option value="3">Student PRN</option>
									           	</select>
								            </div>
                                            <div class="col-sm-2"><input type="text" class="form-control" id="ref_no" name="ref_no" placeholder="Enter the value" ></div>
                                           <div class="col-sm-2"><button  class="btn btn-primary form-control" id="btnView" >Check</button>
                                   </div>  
                            </div> 
                        </div>
          
				   </div>    
                </div>
            </div>
            
            
        </div>
    </div>
 <center><div id="loader1"></div> </center>
    <div class="row" id="reportdata">
        
        
    </div>
           
            
</div>
<style>
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
