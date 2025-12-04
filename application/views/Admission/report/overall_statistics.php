<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>

<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.4.2/js/buttons.html5.min.js"></script>
<script src="https:////cdn.datatables.net/buttons/1.4.2/js/buttons.print.min.js"></script>
<script src="https:////cdn.datatables.net/buttons/1.4.2/js/buttons.colVis.min.js"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.4.2/css/buttons.dataTables.min.css">

               
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Admission</a></li>
        <li class="active"><a href="#">Reports</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Admission Reports</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                   
                </div>
            </div>
        </div>
        <br>
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                <div class="panel-heading">
                        <span class="panel-title">
                          <div class="row">
                              <div class="col-sm-2 text-right">Academic Year</div>
                              <div class="col-sm-2">
                                  <select name="academic_year" id="academic_year" class="form-control" required>
                                     <option value="">Select Academic Year</option>
                                    <option value="2016">2016-17</option>
                                    <option value="2017" selected >2017-18</option>
                                 </select>
                                  
                              </div>

                              <div class="col-sm-3">
                                  <select name="report_type" id="report_type" class="form-control" required>
                                     <option value="0">Select Report Type</option>
                                    <option value="1">Statistics</option>
                                    <option value="2">Category</option>
                                    <option value="3">Scholorship List</option>
                                    <option value="4">Cancelled List</option>
                                    <option value="5">Approval  List</option>
                                    <option value="6">Approval Cover</option>
                                  </select>
                              </div>
                              <div class="col-sm-3">
                                <input type="button" id="sbutton" class="btn btn-primary btn-labeled" value="View" > 
                                 <input type="button" id="sbutton" class="btn btn-primary btn-labeled" value="Download"> 
                              </div>
                              
                          </div>
                        
                        </span>
                        
                </div

                          
                              <div class="col-sm-3" id="semest">
                                 <input type="button" id="sbutton" class="btn btn-primary btn-labeled" value="Submit" > 
                            </div>
                            </div>
            <div class="table-info panel-body">  
			<div id="admdata">
			    
			 </div>
			
                
            </div>
                </div>
            </div>
            </div>    
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    
get_page_data();
$("#sbutton").click(function(){
   // alert("click me");
    get_page_data();
   
});

function get_page_data()
{
    var year1=$("#academic_year option:selected" ).val() ;
            var url  = "<?=base_url().strtolower($currentModule).'/get_admission_statistics'?>";	
            var data = {academic_year: year1};		
      $.ajax({
                type: "POST",
                url: url,
                data: data,
                dataType: "html",
                cache: false,
                crossDomain: true,
                success: function(data)
                {  
                    var table = $('#datatable').DataTable();
                table.clear().draw();
                   $("#admdata").html(data);
                    
                },
                error: function(data)
                {
                    alert("Page Or Folder Not Created..!!");
                }
            });
    
}
    
       
   
} );
</script>