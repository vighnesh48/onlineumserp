<html>
<head>
<script>    
	$(document).ready(function(){

    var prn_s= '<?=$this->uri->segment(3)?>';
	var exam_id= '<?=$this->uri->segment(4)?>';
	var revaltype= '<?=$this->uri->segment(5)?>';
    var roleid= '<?=$this->session->userdata('role_id')?>';
    var username= '<?=$this->session->userdata('name')?>';
   // alert(prn_s);
   var stud =0;
    if(roleid =='4'){
        $("#prn").val(username);
        $("#prn").prop('readonly',true);
       var stud =1;
    }else if(prn_s){
         $("#prn").val(prn_s); 
         $("#prn").prop('readonly',false);  
    }else{
        $("#prn").val('');  
        $("#prn").prop('readonly',false); 
    }
    

      $('#sbutton').click(function(){            
        var base_url = '<?=base_url();?>';
               // alert(type);
        var prn = $("#prn").val();
		var exam_id = $("#exam_id").val();
		var reval_type = $("#reval_type").val();
		//alert(exam_id);
        prn = prn.trim();
        if(prn=='' )
        {
            alert("Please enter the PRN");
            return false;
        }
        $.ajax({
            'url' : base_url + '/Reval_phd/search_studentdata_admin',
            'type' : 'POST', //the way you want to send data to your URL
            'data' : {'prn':prn,'exam_id':exam_id,'reval_type':reval_type},
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
    if(prn_s !='' || stud==1){
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
	$rv = $this->uri->segment(5);
	if($rv !=''){
		$reval = $rv;
		$this->session->set_userdata('reval', $reval);
	}else{
		$reval = $this->session->set_userdata('reval');
	}
	
    if($reval==0){
        $report_name="PHOTOCOPY";
        $reportName="Photocopy";
    }else{
        $report_name="REVALUATION";
        $reportName="Revaluation";
    }  
?>
<body>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Results</a></li>
        <li class="active"><a href="#"><?=$reportName?></a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;<?=$reportName?> Form</h1>
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
                       <span class="panel-title"><i class="panel-title-icon fa fa-fire text-danger"></i>Exam Session : <?=$exam[0]['exam_month']?>-<?=$exam[0]['exam_year']?></span>
			    		</div>
			    		<div class="panel-body">
						<br>
						<!--<form id="form1" name="form1" enctype="multipart/form-data" action="<?=base_url($currentModule.'/search_student')?>" method="POST">-->
                        <div class="row" style="<?=$dispay?>">
					   <div class="form-group">
					   <div class="col-sm-1 ">Type</div>
                       <div class="col-sm-2 ">
                           <select name="reval_type" id="reval_type" class="form-control">
                               <option value="">--Select--</option>
                               <option value="0" <?php if($reval==0){ echo "selected";}?>>Photocopy</option>
                               <option value="1" <?php if($reval==1){ echo "selected";}?>>Revaluation</option>
                           </select>
                       </div>
					   <label class="col-sm-2">Student PRN</label>
                      <div class="col-sm-3">
					  <input type="text" class="form-control" name="prn" id="prn" placeholder="Enter PRN No.">
					  <input type="hidden" class="form-control" name="exam_id" id="exam_id" value="<?=$exam[0]['exam_id']?>">
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