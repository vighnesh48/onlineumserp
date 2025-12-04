<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<script src="<?=site_url()?>assets/javascripts/jspdf/jspdf.js" type="text/javascript"></script>
<style>
  .attexl table {
    border: 1px solid black;
  }
  .attexl table th {
    border: 1px solid black;
    padding: 5px;
    background-color: grey;
    color: white;
  }
  .attexl table td {
    border: 1px solid black;
    padding: 5px;
  text-align:center;
  }
  .dropdown {
    xtop:50%;
    transform: translateY(0%);
  }
  a {
    color: #fff;
  }
  .dropdown dd,
  .dropdown dt {
    margin: 0px;
    padding: 0px;
    z-index:99999!important;
  }
  .dropdown{
    z-index:99999!important}
  .dropdown ul {
    margin: -1px 0 0 0;
  }
  .dropdown dd {
    position: relative;
  }
  .dropdown a,
  .dropdown a:visited {
    color: #000;
    text-decoration: none;
    outline: none;
    font-size: 12px;
  }
  .dropdown dt a {
    background-color: #fff;
    display: block;
    padding: 10px;
    overflow: hidden;
    border: 0;
    width: 100%;
    border: 1px solid #aaa;
  }
  .dropdown dt a span,
  .multiSel span {
    cursor: pointer;
    display: inline-block;
    padding: 0 3px 2px 0;
  }
  .dropdown dd ul {
    background-color: #fff;
    border: 0;
    color: #000;
    display: none;
    left: 0px;
    padding: 2px 15px 2px 5px;
    position: absolute;
    top: 2px;
    width:300px;
    list-style: none;
    height: 300px;
    overflow-y:scroll;
    border: 1px solid #aaa;
  }
  .dropdown span.value {
    display: none;
  }
  .dropdown dd ul li a {
    padding: 5px;
    display: block;
  }
  .dropdown dd ul li a:hover {
    background-color: #ddd;
  }
  .datepicker-dropdown{
    z-index: 999999;
  }
  #main-wrapper{overflow: visible!important;}
</style>

<div id="content-wrapper">
  <ul class="breadcrumb breadcrumb-page">
    <div class="breadcrumb-label text-light-gray">You are here: 
    </div>
    <li>
      <a href="#">Attendance
      </a>
    </li>
    <li class="active">
      <a href="#">IN-OUT Missing Report 
      </a>
    </li>
  </ul>
  <div class="page-header">
    <div class="row">
      <h1 class="col-xs-12 col-sm-4 text-center text-left-sm">
        <i class="fa fa-dashboard page-header-icon">
        </i>&nbsp;&nbsp;IN-OUT Missing Report
      </h1>
      <div class="col-xs-12 col-sm-8">
        <div class="row">
          <hr class="visible-xs no-grid-gutter-h">
        </div>
      </div>
    </div>   
    <div class="row ">
      <div class="col-sm-12">
        <div class="col-sm-6">
            <div class="table-info">
              <div id="dashboard-recent" class="panel-warning">
                <div class="panel">
                  <div class="panel-heading">
                    <strong> Regular Staff Attendance 
                    </strong>
                  </div>
                  <div class="panel-body"> 
                     <span id="flash-messages" style="color:red;padding-left:110px;">
                    </span>
                    <div class="panel-padding no-padding-vr">
                      <div class="form-group">
                        
                        <div class="portlet-body form">
                          <form id="form" name="form" action="<?=base_url($currentModule.'/inoutmissing_report_show')?>" method="POST" enctype="multipart/form-data">
                            <div class="form-body">
                              <div class="row">
                                <div class="form-group">
                                  <label class="col-md-4">Select Month
                                    <?=$astrik?>
                                  </label>
                                  <div class="col-md-8" >
                                    <input id="dob-datepicker" required class="form-control form-control-inline  date-picker" name="attend_date" placeholder="Enter Month" type="text" value="">
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="form-group">
                                  <div class="col-md-3" >
                                  </div>
                                  <div class=" col-md-3">
                                    <button type="submit" class="btn btn-primary form-control" >Submit
                                    </button>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </form>
                        </div>
                       </div>
				   </div>
				</div>
			  </div>
			</div>
		  </div>
	 </div>
<script>
$(document).ready(function(){
    $('#dob-datepicker').datepicker( {
      format: "yyyy-m",startView: "months",minViewMode: "months",autoclose:true}
                                   );
								   });
</script>

