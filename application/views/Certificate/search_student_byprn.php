<html>
<head>
<script>    
	$(document).ready(function(){

    var prn_s= '<?=$this->uri->segment(3)?>';
   // alert(prn_s);

    if(prn_s){
         $("#prn").val(prn_s); 
         $("#prn").prop('readonly',true);  
    }else{
        $("#prn").val('');  
        $("#prn").prop('readonly',false); 
    }
    

      $('#sbutton').click(function(){            
        var base_url = '<?=base_url();?>';
               // alert(type);
        var prn = $("#prn").val();
		var edit_flag = '<?=$this->uri->segment(3)?>';
		//alert(prn);
        prn = prn.trim();
        if(prn=='' )
        {
            alert("Please enter the PRN");
            return false;
        }
        $.ajax({
            'url' : base_url + 'Certificate/search_studentdata',
            'type' : 'POST', //the way you want to send data to your URL
            'data' : {'prn':prn,edit_flag:edit_flag},
            'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
                var container = $('#stddata'); //jquery selector (get element by id)
                if(data){
                    container.html(data);
                    return false;
                }
                  return false;
            }
        });
    });
    if(prn_s !=''){
        $("#sbutton").trigger("click");
    }
});         
</script>
</head>
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
	if($this->session->userdata('role_id')==4){
		$dispay="display:none;";
	}else{
		 $dispay="display:blank;";
	}  

?>
<body>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li class="active"><a href="#">Certificate</a></li>
        <li class="active"><a href="#">Degree Certificate-2016</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Add Degree Certificate Form</h1>
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
                       <span class="panel-title"><i class="panel-title-icon fa fa-fire text-danger"></i>Degree Certificate Form</span>
			    		</div>
			    		<div class="panel-body">
						<br>
						<!--<form id="form1" name="form1" enctype="multipart/form-data" action="<?=base_url($currentModule.'/search_student')?>" method="POST">-->
                        <div class="row" style="<?=$dispay?>">
					   <div class="form-group"> 
					   <label class="col-sm-2">Student PRN</label>
                      <div class="col-sm-3">
					  <input type="text" class="form-control" name="prn" id="prn" placeholder="Enter PRN No."> 
					  </div>
					  <div class="col-sm-2"><button class="btn btn-primary form-control" id="sbutton" type="button" >Search</button> </div>
					  </div>
					 <!-- </form>-->
                </div>
                
                    <div class="table-info" id="stddata">    
                 
                </div>
          
            </div>    
        </div>
    </div>
</div>
</div>
</div>
</body>
</html>