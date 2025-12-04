<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<script src="<?=base_url()?>assets/javascripts/moment.js"></script>
<script src="<?=base_url('assets/javascripts').'/bootstrap-datetimepicker.min.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<!-- <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script type="text/javascript" language="javascript" src="jquery-ui-1.12.1/jquery-ui.js"></script>
<link href="jquery-ui-1.12.1/jquery-ui.css" type="text/css" rel="stylesheet" /> -->
<script>
//var lu = '<?=$this->session->userdata("role_id")?>';
var availableNames = [];
	var availablemobiles = [];
	var availableemails = [];
<?php 
$vname='';$vmobile='';$vemail='';
if(!empty($existed_visitors)){
	foreach($existed_visitors as $visitor){
			$vname=$visitor['visitor_name'];
			$vmobile=$visitor['mobile'];
			$vemail=$visitor['email'];
			
			?>
			
			availableNames.push('<?=$visitor['visitor_name']?>');
			availablemobiles.push('<?=$visitor['mobile']?>');
			availableemails.push('<?=$visitor['email']?>');
			<?php
	}
	$vname=rtrim($vname,",");
	$vmobile=rtrim($vmobile,",");
	$vemail=rtrim($vemail,",");
}
?>   
	
	//alert(availableNames);
    $(document).ready(function()
    {
		$( "#vname" ).autocomplete({
      source: availableNames
    });
	
	$( "#mobile" ).autocomplete({
      source: availablemobiles
    });
	
	$( "#email" ).autocomplete({
      source: availableemails
    });
	
        $('#form').bootstrapValidator
        ({  
            message: 'This value is not valid',
            group: 'form-group',
            feedbackIcons: 
            {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: 
            {
                
				vname:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please Enter Visitor Name'
                      },
                      required: 
                      {
                       message: 'Please Enter Visitor Name'
                      }
                     
                    }
                },
				ref:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please Enter Reference Of'
                      },
                      required: 
                      {
                       message: 'Please Enter Reference Of'
                      }
                     
                    }
                },
				purpose:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please Enter Purpose'
                      },
                      required: 
                      {
                       message: 'Please Enter Purpose'
                      }
                     
                    }
                },
               mobile:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please Enter Mobile'
                      },
                      required: 
                      {
                       message: 'Please Enter Mobile'
                      }
                     
                    }
                },
				email:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please Enter Email'
                      },
                      required: 
                      {
                       message: 'Please Enter Email'
                      }
                     
                    }
                },
				gender:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select Gender'
                      },
                      required: 
                      {
                       message: 'Please select Gender'
                      }
                     
                    }
                },
				 pindate:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select Propose In Date'
                      },
                      required: 
                      {
                       message: 'Please select Propose In Date'
                      }
                     
                    }
                },
				poutdate:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select Propose Out Date'
                      },
                      required: 
                      {
                       message: 'Please select Propose Out Date'
                      }
                     
                    }
                },
				address:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: ' Address should not be empty'
                      },
                      stringLength: 
                        {
                        max: 50,
                        min: 2,
                        message: 'Address should be 2-50 characters.'
                        }
                    }
                },
				pincode:
                {
                    validators: 
                    {
                      /* notEmpty: 
                      {
                       message: ' Pincode should not be empty'
                      }, */
                      stringLength: 
                        {
                        max: 6,
                        min: 6,
                        message: ' Pincode should be 6 digits.'
                        }
                    }
                },
				hstate_id:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please Select State'
                      },
                      required: 
                      {
                       message: 'Please Select State'
                      }
                     
                    }
                },
				hdistrict_id:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please Select District'
                      },
                      required: 
                      {
                       message: 'Please Select District'
                      }
                     
                    }
                },
				hcity:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please Select City'
                      },
                      required: 
                      {
                       message: 'Please Select City'
                      }
                     
                    }
                },
				nop:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please Select No.Of Visitors'
                      },
                      required: 
                      {
                       message: 'Please Select No.Of Visitors'
                      }
                     
                    }
                },
				ischrg:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please Select is chargable?'
                      },
                      required: 
                      {
                       message: 'Please Select is chargable?'
                      }
                     
                    }
                },
                app_by:
				 {
                    validators: 
                    {
            notEmpty: 
                      {
                       message: 'Please Select Approved By'
                      },
                      required: 
                      {
                       message: 'Please Select Approved By'
                      }
                     
                    }
                },
                amob_no: {
                    validators: 
                    {
            notEmpty: 
                      {
                       message: 'Please Enter Approved Person Mobile No'
                      },
                      required: 
                      {
                       message: 'Please Enter Approved Person Mobile No'
                      }
                     
                    }
                },
                chk_in_time:
 {
                    validators: 
                    {
            notEmpty: 
                      {
                       message: 'Please Select Check In Time'
                      },
                      required: 
                      {
                       message: 'Please Select Check In Time'
                      }
                     
                    }
                },
                chk_out_time:
                 {
                    validators: 
                    {
            notEmpty: 
                      {
                       message: 'Please Select Check Out Time'
                      },
                      required: 
                      {
                       message: 'Please Select Check Out Time'
                      }
                     
                    }
                },
                htype:
                 {
                    validators: 
                    {
            notEmpty: 
                      {
                       message: 'Please Select Booking Type'
                      },
                      required: 
                      {
                       message: 'Please Select Booking Type'
                      }
                     
                    }
                }
            }       
        })
		
		
		$('.alphaonly').bind('keyup blur',function(){ 
			var node = $(this);
			node.val(node.val().replace(/[^a-zA-Z. ]/g,'') ); }
		);
		$('.alphanum').bind('keyup blur',function(){ 
			var node = $(this);
			node.val(node.val().replace(/[^a-zA-Z0-9 ]/g,'') ); }
		);
		
		$('#vname').keyup(function() {
		$(this).val($(this).val().toUpperCase());
	});
    });

</script>
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="<?=base_url($currentModule)?>">Guest House</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-5 text-center text-left-sm">
			<i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Guest House Booking </h1>
        </div>
		  
		<div class="row " >
            <div class="col-sm-12">

                <div class="panel">
                  <form id="form" name="form" enctype="multipart/form-data" action="<?=base_url($currentModule.'/add_visitor_submit')?>" method="POST" onsubmit="return validate_faci_category(event)" >
         
                    <div class="panel-heading">
                    <div class="row " >
                     <div class="col-sm-6">
                            <label >Booking Details</label >
                            </div>
                            <div class="col-sm-6">
                            <?php $r= $this->session->userdata("role_id"); ?>
<?php if($r=='17'){ ?>
              <input type="radio" name="htype" id="htyp" value="h" <?php if($r=='17'){ echo 'checked'; }  ?> /> &nbsp;&nbsp;<b>Hostal</b>&nbsp;&nbsp;&nbsp;
               <?php }elseif($r=='28'){ ?>
               <input type="radio" name="htype" id="htyp" value="t" <?php if($r=='28'){ echo 'checked'; }  ?> />&nbsp;&nbsp;<b>Trustee Office</b>
            <?php } ?>
               <span style="color:RED;" id="errhtyp"></span>
               </div>
                    </div></div>
				           <div class="panel-body">
                        <div class="table-info">  
							
							<!--<div class="well well-sm"><b>Visitor Details</b></div> 	-->					
							<div class="form-group">
								<input type="hidden" id="vid" name="vid" value=""/>
								<div class="col-sm-2">
								<label >Visitor Name:<?=$astrik?></label>
								</div>
								<div class="col-sm-3">
								<input type="text" id="vname" placeholder="Name" value="" name="vname" onchange="check_visitor_exists()" class="ui-widget form-control alphanum"  />
								<span style="color:red;"><?php echo form_error('vname');?></span>
								</div>
								
								<div class="col-sm-2">
								<label>Gender:<?=$astrik?></label>
								
								</div>
								
								<div class="col-sm-3">
								<select id="gender" name="gender" class="form-control" >
											  <option value="">Select Gender</option>
											  <option value="M">MALE</option>
											  <option value="F">FEMALE</option>
                                    </select>                                  
								<span style="color:red;"><?php echo form_error('gender');?></span>
								</div>
								
							</div>
							
							<div class="form-group">
								<div class="col-sm-2">
								<label >Mobile:<?=$astrik?></label>
									</div>
									<div class="col-sm-3">
									<input type="text" onchange="check_visitor_exists()" id="mobile" name="mobile" maxlength="12" required placeholder="Mobile" class="form-control"  />                                     
                                   <span style="color:red;"><?php echo form_error('driver');?></span>
									</div>
									
									<div class="col-sm-2">
									<label>Email:<?=$astrik?></label>
									
								   </div>
								   <div class="col-sm-3">
									
									<input type="email" onchange="check_visitor_exists()" id="email" name="email" placeholder="Email" class="form-control"  />                                  
                                   <span style="color:red;"><?php echo form_error('amobile');?></span>
								   </div>
								   
									
								</div>	
								
							<div class="form-group">
									<div class="col-sm-2">
									<label>Enter Address:<?=$astrik?></label>
								   </div>
								   <div class="col-sm-3">
									<textarea class="form-control" id="address" name="address" ></textarea>                                    
                                   <span style="color:red;"><?php echo form_error('address');?></span>
									
									</div>
								<div class="col-sm-2">
								<label >Enter Pincode:</label>
                                 
                                </div>
								 <div class="col-sm-3">
								<input type="text" id="pincode" name="pincode" placeholder="Pincode" class="form-control"  /><span style="color:red;"><?php echo form_error('pincode');?></span>
                                  
                                </div>
							
								</div>		 
                                
								<div class="form-group">
								<div class="col-sm-2">
								<label >Select Locality: <?=$astrik?></label>
									</div>
									<div class="col-sm-3">
									 <select class="form-control" name="hstate_id" id="hstate_id" >
                                      <option value="">Select State</option>
                                      <?php //echo "state".$state;exit();
                                        if(!empty($state)){
                                            foreach($state as $stat){
                                                ?>
                                              <option value="<?=$stat['state_id']?>"><?=$stat['state_name']?></option>  
                                            <?php 
                                                
                                            }
                                        }
                                      ?>
                                  </select>
								  <span style="color:red;"><?php echo form_error('hstate_id');?></span>
									</div>
									<div class="col-sm-2" style="padding-left:0px;padding-right:0px;">
									<select class="form-control" name="hdistrict_id" id="hdistrict_id" >
                                      <option value="">Select District</option>
                                  </select>
								  <span style="color:red;"><?php echo form_error('hdistrict_id');?></span>
									</div>
									<div class="col-sm-3">
									<select class="form-control" name="hcity" id="hcity" >
                                      <option value="">Select City</option>
                                  </select>
								  <span style="color:red;"><?php echo form_error('hcity');?></span>
									</div>
								</div>
                <?php if($r=='17'){ ?>
								<div id="prfid">
								<div class="form-group" >
								<div class="col-sm-2">
								<label>Id Proof:</label>
								
								</div>
								
								<div class="col-sm-3">
								<select id="pref" name="pref" class="form-control" >
											  <option value="">Select Id Proof</option>
											  <option value="PANCARD">PAN CARD</option>
											  <option value="ADHHAR">ADHHAR CARD</option>
											  <option value="COMPANY-CARD">COMPANY-CARD</option>
											  <option value="DRIVING-LICENSE">DRIVING-LICENSE</option>
											   <option value="OTHER">OTHER</option>
                                    </select>                                  
								<span style="color:red;" id="errpref"><?php echo form_error('pref');?></span>
								</div>
								
								<div class="col-sm-2">
								<label >Id Proof NO.:</label>
								</div>
								<div class="col-sm-3">
								<input type="text" id="pno" placeholder="Id Proof No." value="" name="pno" class="form-control alphanum"  />
								<span style="color:red;" id="errprefno"><?php echo form_error('pno');?></span>
								</div>

							</div>

              <div class="form-group" >
                <div class="col-sm-2">
                <label >Upload Image :</label>
                </div>
                <div class="col-sm-3">
                <input type="file" id="ups" placeholder="Id Proof upload" value="" name="file_up" class="form-control"  />
                <span style="color:red;" id="errprefimg"></span>
                </div>
              </div>
              </div>
								<?php } ?>
								<div class="form-group">
								
								<div class="col-sm-2">
								<label >Requisition Of:<?=$astrik?></label>
								</div>
								<div class="col-sm-3">
								<input type="text" placeholder="Reference Of" id="ref" name="ref" class="form-control"  />
								<span style="color:red;"><?php echo form_error('ref');?></span>
								</div>
								
								<div class="col-sm-2">
								<label>Visiting Purpose:<?=$astrik?></label>
								
								</div>
								
								<div class="col-sm-3">
								<input type="text" id="purpose" placeholder="Visiting Purpose" name="purpose" class="form-control alphanum"  />
								<span style="color:red;"><?php echo form_error('purpose');?></span>
								</div>
								
								</div>
						<div class="form-group">
                
                <div class="col-sm-2">
                <label >Approved By:<?=$astrik?></label>
                </div>
                <div class="col-sm-3">
                <input type="text" placeholder="Approved By" id="app_by" name="app_by" class="form-control"  />
                <span style="color:red;"><?php echo form_error('ref');?></span>
                </div>
                
                <div class="col-sm-2">
                <label>Mobile No:<?=$astrik?></label>
                
                </div>
                
                <div class="col-sm-3">
                <input type="text" id="amob_no" placeholder="Mobile No" name="amob_no" class="form-control alphanum"  />
                <span style="color:red;"><?php echo form_error('purpose');?></span>
                </div>
                
                </div>
              <?php  $exp = explode("_",$this->session->userdata("name"));
  
            if($exp[1]=="nashik")
        {
          ?>
          <div class="form-group">
           <div class="col-sm-2">
            <label>Select School:<?=$astrik?></label>
                </div>
                
                <div class="col-sm-3">
                <select id="sel_sch" name="sel_sch" class="form-control" >
<option value="">Select School</option><option value="SU">Sandip University Nashik</option><option value="SU-PROV">SU-PROV</option><option value="SITRC">SF-SITRC</option><option value="SIEM">SF-SIEM</option><option value="SIPS">SF-SIPS</option><option value="SP">SF-SP</option><option value="SIP">SF-SIP</option><option value="MBA">SF-MBA</option><option value="JrCollege">GLOBAL SCHOOL</option>
          </select></div>
</div>
          <?php
           
        } ?>
						<!--<div class="row ">
							<div class="col-sm-12">
								<div class="panel">
									<div class="panel-heading">
											<span class="panel-title">Visiting Schedule Details</span>
									</div>
									<div class="panel-body">-->
									
						<div class="row well well-sm">
 <div class="col-sm-8">
            <b>Visiting Schedule Details 
						
							<span style="color:red;padding-left:10px;" id="err_msg"></span>
							</b></div>
						</div>
							<div class="form-group">
								
								<div class="col-sm-2" style="padding-right:0px;">
								<label >Check In:<?=$astrik?></label>
								</div>
								<div class="col-sm-3"  style="padding-left:0px;">
                <div class="col-sm-6" style="padding-right:0px;">
								<input type="text" class="form-control" placeholder="Propose In Date" id="doc-sub-datepicker23" name="pindate"  readonly="true"/>
								<span style="color:red;"><?php echo form_error('pindate');?></span></div>
                <div class="col-sm-6" style="padding-left:2px;">
              <div class='input-group date' id='datetimepicker3'>
                    <input type='text' class="form-control" id="chk_in_time" name="chk_in_time" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-time"></span>
                    </span>
                </div></div>
								</div>
								
								<div class="col-sm-1" style="padding-right:0px;">
								<label>Check&nbsp;Out:<?=$astrik?></label>								
								</div>
								
								<div class="col-sm-3" style="padding-left:0px;">
                  <div class="col-sm-6" style="padding-right:0px;">
								<input type="text" class="form-control" placeholder="Propose Out Date" id="doc-sub-datepicker24" name="poutdate"   readonly="true"/>
								<span style="color:red;"><?php echo form_error('poutdate');?></span>
                </div>
                <div class="col-sm-6" style="padding-left:2px;">
              <div class='input-group date' id='datetimepicker4'>
                    <input type='text' class="form-control"  id="chk_out_time" name="chk_out_time" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-time"></span>
                    </span>
                </div></div>
								</div>
								<div class="col-sm-2" style="padding-right:0px;">
								<label >No. Of Days:<?=$astrik?></label>
								</div>
								<div class="col-sm-1" style="padding-left:0px;">
								<input id="nod" name="nod" value="0" class="form-control" readonly />
								 
								<span style="color:red;"><?php echo form_error('nod');?></span>
								</div>
							</div>
							<div class="form-group">
								
								<div class="col-sm-2" style="padding-right:0px;">
								<label >No. Of Visitors:<?=$astrik?></label>
								</div>
								<div class="col-sm-3" >
								<select id="nop" name="nop" class="form-control" onchange="display()" >
								 </select>
								<span style="color:red;"><?php echo form_error('nop');?></span>
								</div>	
                </div>
                <?php if($r=='17'){ ?>
                <div  class="form-group" id="ischrg_div" >								

								<div  class="col-sm-2"  style="padding-right:0px;">               
                <label >Is Chargeble?:<?=$astrik?></label>
                </div>
                <div class="col-sm-3" >
                <select id="ischrg" name="ischrg" class="form-control" onchange="display_charge();display();" >
                <option value="">Select Is Chargeble</option>
                <option value="Y">Yes</option>
                <option value="N">No</option>
                 </select>
                <span style="color:red;"><?php echo form_error('nop');?></span>
                </div>  
                <div id="ischrg_div1" style="display:none;">	
                	 <div  class="col-sm-1"  style="padding-right:0px;">  			
								<label >Charges:<?=$astrik?></label>
								</div>
								<div class="col-sm-2" >
								<input type="text" id="chrg" name="chrg" placeholder="Room Charges" class="form-control"  />
								<span style="color:red;" id="err_roomchr"><?php echo form_error('chrg');?></span>
								</div>	
                
                </div>
								</div>
									<?php }?>
							</div>
							
								<table class="table table-bordered" id="visitors" style="display:none;">
								<thead>
									<tr>
									<th>#</th>
									<th>Visitors Name</th>
									<th>Mobile</th>
									<th>GuestHouse</th>	<th>Bed No</th>	
									</tr>
								</thead>
								
								<tbody id="itemContainer">
								<!--	<tr><td>'+i+'</td><td><input style="width: 150px;"   class="form-control vpname" name="vpname[]" type="text" placeholder="Name" required  /></td><td><input class="numbersOnly form-control"  placeholder="Mobile" style="width: 150px;" name="vpmobile[]" type="text" required /></td><td>'+dropdown+'</td></tr>-->
								</tbody>
								</table>
					<input type="hidden" name="remain_bed_available" id="remain_bed_available" />
									<!--</div>
								</div>
							</div>    
						</div>-->
                          <div class="form-group">
                                   
							<div class="col-sm-2">
								<button class="btn btn-primary form-control" id="btn_submit" type="submit" >Book</button>                                        
							</div>                                    
							<div class="col-sm-2"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule.'/check_availability')?>'">Cancel</button></div>
							
						</div>
                          <div class="col-sm-8">
							<span style="color:red;padding-left:0px;" id="err_msg1"></span>
							</div>  
							
                        </div>
                    </div>
               
				</form>		
                    </div>
                </div>
            </div>    
        </div>
    </div>



<script>
function display_charge()
{
  if($('#ischrg').val()=='Y')
    $('#ischrg_div1').show();
  else
    $('#ischrg_div1').hide();
  $("#chrg").val('');
}
var status=0;
var error_status=0;
  $('#datetimepicker3').datetimepicker({
                    format: 'LT'
                }).on('change dp.change', function(e){ 
   $('#form').bootstrapValidator('revalidateField', 'chk_in_time');
  });
  $('#datetimepicker4').datetimepicker({
                    format: 'LT'
                }).on('change dp.change', function(e){ 
				var fdate='',tdate='';
		fdate = $("#doc-sub-datepicker23").val()+' '+$("#chk_in_time").val();
		tdate = $("#doc-sub-datepicker24").val()+' '+$("#chk_out_time").val();
			
		if ((Date.parse(tdate) < Date.parse(fdate))) 
		{
			error_status=1;$('#err_msg').html("Proposed-Out date should be greater than Proposed-In date");
		}
		else
			{error_status=0;$('#err_msg').html("");}
		var date1 = new Date(fdate);
		var date2 = new Date(tdate);
		//var timeDiff = Math.abs(date2.getTime() - date1.getTime());
		//diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24)); 
		var diffDays1=(( new Date(tdate) - new Date(fdate) ) / 1000 / 60 / 60)/24;
		var diffDays=(Math.ceil(diffDays1));
		//alert(diffDays);
		$('#nod').val(isNaN(diffDays)?0:diffDays);
		 $('#form').bootstrapValidator('revalidateField', 'poutdate');
		 cal_charg();
   $('#form').bootstrapValidator('revalidateField', 'chk_out_time');
  });
function check_visitor_exists()
{
	var mobile=$('#mobile').val();
	var vname=$('#vname').val();
	var email=$('#email').val();
	var g="",s="",d="",c="";
	var html=0;
	$.ajax({
			type: 'POST',
			url: '<?= base_url() ?>Guesthouse/check_visitor_exists',
			data: {mobile:mobile,vname:vname,email:email},
			success: function (html) {
				//console.log(html);
				if(html !== "{\"visitor_details\":null}")
				{
					$('#err_msg').html('');
					var array=JSON.parse(html);
					len=array.length;
					//alert(array.visitor_details.visitor_name);
					$('#vid').val(array.visitor_details.v_id);
					$('#vname').val(array.visitor_details.visitor_name);
					$('#mobile').val(array.visitor_details.mobile);
					$('#email').val(array.visitor_details.email);
					$('#address').html(array.visitor_details.address);
					$('#pincode').val(array.visitor_details.pincode);
					$('#pno').val(array.visitor_details.id_ref_no);
					s=array.visitor_details.state;
					d=array.visitor_details.district;
					c=array.visitor_details.city;
					g=array.visitor_details.gender;
					p=array.visitor_details.id_proof;
					$('#ref').focus();
					$('#hstate_id option').each(function()
					{              
						 if($(this).val()== s)
						{
							$(this).attr('selected','selected');
							$.ajax({
								type: 'POST',
								url: '<?= base_url() ?>Ums_admission/getStatewiseDistrict',
								data: 'state_id=' + s,
								success: function (html) {
									if(html !='')
									{					
										$('#hdistrict_id').html(html);
										$('#hdistrict_id option').each(function()
										 {              
											 if($(this).val()== d)
											{
												//alert(district_id);
												$(this).attr('selected','selected');
												$.ajax({
													type: 'POST',
													url: '<?= base_url() ?>Ums_admission/getStateDwiseCity',
													data: { state_id: s, district_id : d},
													success: function (html) {
														//alert(html);
														if(html !=''){
														$('#hcity').html(html);
														}else{
														  $('#hcity').html('<option value="">First Select District</option>');  
														}
														$('#hcity option').each(function()
														 {              
															 if($(this).val()== c)
															{
																//alert(district_id);
																$(this).attr('selected','selected');
															}
														 });
													}
												});
											}
										 });
									}
									else
									{
										 $('#hdistrict_id').html('<option value="">First Select State</option>');  
									}			
								}
							});
								
							
						} 
						
					});
					
										
					$('#gender option').each(function()
					{
						if($(this).val()== g)
						{
							$(this).attr('selected','selected');
						}
					});
					$('#pref option').each(function()
					{
						if($(this).val()== p)
						{
							$(this).attr('selected','selected');
						}
					});
				}
			}
	});
}
	
var temp_obj={};
var map1 = new Map();
/* 	
function logMapElements(value, key, map) {
  console.log(`m[${key}] = ${value}`);
} */


function validate_faci_category(events)
{
	//alert('coming');
	var array_elements=[];
	var len=$('#nop').val();
	var val;
	err_sts=0;
	var htp=$("input[type=radio][name='htype']:checked").val();
  //alert(htp);
	if(htp==""){
    //alert('1');
		err_sts=1;
		$('#errhtyp').html('Please Select');
		}else{
      // alert('2');
			$('#errhtyp').html('');			
			if(htp=='h'){
				
				var rchr= $('#chrg').val();
			var pmod = $('#mod_of_pay').val();
			var prf = $('#pref').val();
			var ppno = $('#pno').val();
			
			if(rchr==""){
					err_sts=1;
			$('#err_roomchr').html('Please Enter Charges');
				}else{
					$('#err_roomchr').html('');
					}
				if(pmod==""){
					err_sts=1;
			$('#err_roomchrm').html('Please Enter Payment Mode');
				}else{
					$('#err_roomchrm').html('');
					}
					
					if(prf==""){
					err_sts=1;
			$('#errpref').html('Please Select ID Proof');
				}else{
					$('#errpref').html('');
					}
				if(ppno==""){
					err_sts=1;
			$('#errprefm').html('Please Enter ID Proof ');
				}else{
					$('#errprefm').html('');
					}
				
				} //end of htp==h
			
			} // end of htp==""
			
	//if(htp!=""){
	//	if(htp
		
	//	}		
			
	for(i=1;i<=len;i++)
	{
		val=$('#gh_'+i).val();
		array_elements.push(val);
		
		var name_val=$('#name_'+i).val();
		
		if(name_val=="")
		{
			err_sts=1;
			$('#errname_'+i).html('Please Enter Visitor Name');
		}
		else 
			$('#errgh_'+i).html('');
		
		var mobile_val=$('#mobile_'+i).val();
		if(mobile_val=="")
		{
			err_sts=1;
			$('#errmobile_'+i).html('Please Enter Visitor Mobile Number');
		}
		else 
			$('#errgh_'+i).html('');
		
		 var gh_val=$('#gh_'+i).val();
		if(gh_val=="")
		{
			err_sts=1;
			$('#errgh_'+i).html('Please Select Guesthouse');
		}
		else 
			$('#errgh_'+i).html(''); 
			
			 var ghrn_val=$('#ghrn_'+i).val();
		if(ghrn_val=="")
		{
			err_sts=1;
			$('#errghbd_'+i).html('Please Select Bed No');
		}
		else 
			$('#errghbd_'+i).html(''); 
	}

	var frequencies = {};
array_elements.map( 
  function (v) {
    if (frequencies[v]) { frequencies[v] += 1; }
    else { frequencies[v] = 1; }
    return v;
}, frequencies);

/* var result = document.querySelector('#err_msg1');
result.textContent = JSON.stringify(frequencies, 0, 2) +
                     '\nAnd unique \'values\' from the frequencies object:\n[' +
                     Object.keys(frequencies).join(', ') + ']'; */
var temp_arr="";
status=0;					 
$.each(frequencies, function( key, value ) {
	if(key!='')
	{temp_arr+=key+'='+value+'[]';}

	var actual_bed=map1.get(key);
	val=key.split('_');
	if(value > actual_bed)
	{
		status=1;
		$('#err_msg1').html(val[1]+' has only '+val[2]+' beds but u have selected more');
	}
	//alert(JSON.stringify(temp_obj));
	});
	temp_arr=temp_arr.slice(0,-2);
	//alert('temp_arr=='+temp_arr);
	$('#remain_bed_available').val(temp_arr);
	
	if(error_status==1 || status==1 || err_sts==1)
	{
		$(':input[type="submit"]').prop('disabled', false);	return false;
	}
}

$("input[name='htype']").click(function () {

	if($(this).val()=='h'){
		$('#ischrg_div').show();
		cal_charg();
	}else{
		$('#ischrg_div').hide();
	}
});

function match_count(id)
{
	status=0;
	var selected_val=$('#'+id).val();
	/* if(selected_val!="")
		$('#err'+id).html('');
	else
		$('#err'+id).html('Please Select Visitor Guesthouse'); */
	
	var len=$('#itemContainer select[name="ghouse[]"]').length;
	var cnt=0,i;
	
	for(i=1;i<=len;i++)
	{
		val=$('#gh_'+i).val();
		if(selected_val==val)
		{cnt++;}
	}
	var actual_bed=map1.get(selected_val);
	val=selected_val.split('_');
	if(cnt > actual_bed)
	{
		status=1;
		$('#err_msg1').html(val[1]+' has only '+val[2]+' beds but u have selected more');
		//$('#err_msg1').html(val[0]+' has only '+val[2]+' beds');
	}else{
		get_rooms(id);
	}
}
function get_rooms(id){
	//alert(id);
	var f = id.split("_");
	var srm = $('#ghrn_'+f[1]).val();
	var ghi = $('#'+id).val();
	var gh = ghi.split("_");
  var ft = $('#chk_in_time').val();
  var tt = $('#chk_out_time').val();
var fd = $('#doc-sub-datepicker23').val();
var td = $('#doc-sub-datepicker24').val();

var ps = $('#nop').val();
	$.ajax({
													type: 'POST',
													url: '<?= base_url() ?>Guesthouse/get_hostel_room',
													data: {gh_id: gh[0],fd:fd,td:td,ps:ps,ft:ft,tt:tt},
													success: function (html) {
														//alert(html);
														//if(html !=''){
														$('#ghrn_'+f[1]).html(html);
														//}else{
														//  $('#hcity').html('<option value="">First Select District</option>');  
														//}
														
													}
												});
	
}
var ghouses = {};

<?php 
$content='';
if(!empty($get_beds_available_gh)){
	foreach($get_beds_available_gh as $gh){
	  $content.='<option value="'.$gh['gh_id'].'_'.$gh['guesthouse_name'].'_'.$gh['bed_available'].'">'.$gh['guesthouse_name'].'</option>';?>

	  ghouses['<?=$gh['gh_id'].'_'.$gh['guesthouse_name'].'_'.$gh['bed_available']?>'] = '<?=$gh['bed_available']?>';	
		
	map1.set('<?=$gh['gh_id'].'_'.$gh['guesthouse_name'].'_'.$gh['bed_available']?>', '<?=$gh['bed_available']?>');
	
<?php 
	}
	//$content.='</select>';
}
?>

function only_number(id)
{
	var r_no=$('#'+id).val();
	r_no = r_no.replace(/[^0-9]/g, '');
	
	if(r_no!="")
		$('#err'+id).html('');
	else
		$('#err'+id).html('Please Enter Visitor Mobile Number');
	
	$('#'+id).val(r_no);
	//$(':input[type="submit"]').prop('disabled', false);return true;
}

function only_alpha(id)
{
	var r_no=$('#'+id).val();
	r_no = r_no.replace(/[^a-zA-Z ]/g, '');
	r_no=(r_no.toUpperCase());
	if(r_no!="")
	$('#err'+id).html('');
	else
		$('#err'+id).html('Please Enter Visitor Name');

	$('#'+id).val(r_no);
	//$(':input[type="submit"]').prop('disabled', false);return true;
}
function cal_charg(){
	//alert('rr');
	   var st = $("input[name='htype']:checked").val();
	   var nod = $("#nod").val();
	   var nop = $('#nop').val();
	if(st=='h'){
        var hf ='<?=$hostal_fee?>';
     // alert(hf);
	 // alert(st);
	  // alert(nod);
      ff1 = hf*nop;
	 // alert(ff1);
	  ff = ff1*nod;
      $('#chrg').val(ff);
    }else{
       $('#chrg').val('');
    }
}

var dropdown='<?=$content?>';
function display()
	{
		var nop = $('#nop').val();
		var dropdown1='';
      var st = $("input[name='htype']:checked").val();
		var data="";
		if(nop!="")
		{

			var vistr_name=$('#vname').val();
			var vistr_mobile=$('#mobile').val();

      var sd = $('#doc-sub-datepicker23').val();
      var sdt = $('#chk_in_time').val();
      var frm_dt = sd+" "+sdt+":00";
      var td = $('#doc-sub-datepicker24').val();
      var tdt = $('#chk_out_time').val();
  var td_dt = td+" "+tdt+":00";
  if(sd!='' && sdt!='' && td!='' && tdt!='' && st!=''){
	  cal_charg();
      $.ajax({
        type: 'POST',
        url: '<?= base_url() ?>Guesthouse/getghouse_list_creteria',
        data: { host_typ: st, frmdt :frm_dt,todt:td_dt,nop:nop,vistr_name:vistr_name,vistr_mobile:vistr_mobile},
        success: function (data1) {
       $('#itemContainer').html(data1); 
        }
      });
    }else{
      alert('Please Select Booking type, Checkin Date/time ,checkout Date/time');
      $('#itemContainer').html('');$('#visitors').hide();

    }
		//	alert('pp'+dropdown1);
			// for (i=1;i<=nop;i++)
			// {
			// 	if(i==1)
			// 	{
			// 		data+='<tr><td>'+i+'</td><td><input style="width: 200px;" id="name_'+i+'" class="vsname form-control" onkeyup="only_alpha(this.id)" name="vpname[]" type="text" placeholder="Name" value="'+vistr_name+'" data-rule-required="true"  /><span style="color:RED;" id="errname_'+i+'"></span></td><td><input id="mobile_'+i+'" value="'+vistr_mobile+'" class="vmobile form-control"  maxlength="10"   onkeyup="only_number(this.id)" placeholder="Mobile" style="width: 200px;" name="vpmobile[]" type="text"  data-rule-required="true" /><span style="color:RED;" id="errmobile_'+i+'"></span></td><td><select  data-rule-required="true" style="width: 150px;" id="gh_'+i+'" class="vsghouse form-control" name="ghouse[]" onchange="match_count(this.id)"><option value="">Select GuestHouse</option>'+dropdown1+'</select><span style="color:RED;" id="errgh_'+i+'"></span></td><td><select   style="width: 150px;" id="ghrn_'+i+'" class="vsghouse form-control" name="ghousebed[]"  ><option value="">Select Bed No</option></select><span style="color:RED;" id="errgh_'+i+'"></span></td></tr>';
			// 	}
			// 	else
			// 	data+='<tr><td>'+i+'</td><td><input style="width: 200px;" id="name_'+i+'" class="vsname form-control" name="vpname[]" onkeyup="only_alpha(this.id)"  type="text" placeholder="Name"  data-rule-required="true"  /><span style="color:RED;" id="errname_'+i+'"></span></td><td><input id="mobile_'+i+'" class="vmobile form-control"  maxlength="10" onkeyup="only_number(this.id)"  placeholder="Mobile" style="width: 200px;" name="vpmobile[]" type="text"  data-rule-required="true" /><span style="color:RED;" id="errmobile_'+i+'"></span></td><td><select  data-rule-required="true" style="width: 150px;" id="gh_'+i+'" class="vsghouse form-control" name="ghouse[]" onchange="match_count(this.id)" ><option value="">Select GuestHouse</option>'+dropdown1+'</select><span style="color:RED;" id="errgh_'+i+'"></span></td><td><select   style="width: 150px;" id="ghrn_'+i+'" class="vsghouse form-control" name="ghousebed[]"  ><option value="">Select Bed No</option></select><span style="color:RED;" id="errgh_'+i+'"></span></td></tr>';
			// }
		//	$('#itemContainer').html(data1); 
			$('#err_msg1').html('');
			$('#visitors').show();
      
      
		}
		else
		{
			$('#itemContainer').html('');$('#visitors').hide();
		}
	}

	var diffDays =0;
	$(document).ready(function(){
	$('input[type=radio][name=htype]').on('change', function() {
//alert('hh');
var ht = $(this).val();
if(ht=='h'){
  $('#prfid').show();
}else{
  $('#prfid').hide();
}

  });
	var input_data='<option value="">Select No. Of Person</option>';
	//var input_data1='<option value="">Select No. Of Day</option>';
	for (i=1;i<=30;i++)
	{
		input_data+='<option value="'+i+'"> '+i+'</option>';
		//input_data1+='<option value="'+i+'"> '+i+'</option>';
	}
	//$('#nod').html(input_data1);
	$('#nop').html(input_data);
	
	$('.numbersOnly').keyup(function () {
		//alert('qwrwq');
		if (this.value != this.value.replace(/[^0-9]/g, '')) {
		   this.value = this.value.replace(/[^0-9]/g, '');
		} 
		});
	
 // City by State
	$('#hstate_id').on('change', function () {
		 stateID = $(this).val();
			var state_ID = $("#hstate_id").val();
			$("#state").val($("#hstate_id option:selected").text());
		//alert("called==="+stateID);
		if (stateID) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Ums_admission/getStatewiseDistrict',
				data: 'state_id=' + stateID,
				success: function (html) {
					//alert(html);
					$('#hdistrict_id').html(html);
				}
			});
		} else {
			$('#hdistrict_id').html('<option value="">Select State First</option>');
		}
	});
	
    // City by State
	$('#hdistrict_id').on('change', function () {
		var district_id = $(this).val();
		var state_ID = $("#hstate_id").val();
		$("#district").val($("#hdistrict_id option:selected").text());
	//	alert(state_ID);alert(district_id);
		if (district_id) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Ums_admission/getStateDwiseCity',
				data: { state_id: state_ID, district_id : district_id},
				success: function (html) {
					//alert(html);
					if(html !=''){
					$('#hcity').html(html);
					}else{
					  $('#hcity').html('<option value="">No City Found</option>');  
					}
				}
			});
		} else {
			$('#hcity').html('<option value="">Select District First</option>');
		}
	});

		 $("#hcity").change(function(){
      $("#city").val($("#hcity option:selected").text());
    });
	
	
	var today = new Date();
	var dd = today.getDate();
	var mm = today.getMonth()+1; //January is 0!
	var mmm= today.getMonth();
	var yyyy = today.getFullYear();
	if(dd<10){
	dd='0'+dd;
	} 
	if(mm<10){
	mm='0'+mm;
	} 
	var today = dd+'-'+mm+'-'+yyyy;
	
	$('#doc-sub-datepicker23').datepicker({
	todayHighlight: true,
	format: 'yyyy/mm/dd',
	autoclose: true,
	startDate: new Date()
	}).on('changeDate', function (e) {
		var fdate='',tdate='';
		fdate = $("#doc-sub-datepicker23").val();
		tdate = $("#doc-sub-datepicker24").val();
		
		if ((Date.parse(tdate) < Date.parse(fdate))) 
		{
			error_status=1;$('#err_msg').html("Proposed-Out date should be greater than Proposed-In date");
		}
		else
			{error_status=0;$('#err_msg').html("");}
		
		var date1 = new Date(fdate);
		var date2 = new Date(tdate);
		var timeDiff = Math.abs(date2.getTime() - date1.getTime());
		diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24)); 
		//alert(diffDays);
		$('#nod').val(isNaN(diffDays)?0:diffDays);
		$('#form').bootstrapValidator('revalidateField', 'pindate');
		cal_charg();
	});
	
	$('#doc-sub-datepicker24').datepicker( {
	todayHighlight: true,
	format: 'yyyy/mm/dd',
	autoclose: true,
	startDate: new Date()
	}).on('changeDate', function (e) {
		var fdate='',tdate='';
		fdate = $("#doc-sub-datepicker23").val()+' '+$("#chk_in_time").val();
		tdate = $("#doc-sub-datepicker24").val()+' '+$("#chk_out_time").val();
			
		if ((Date.parse(tdate) < Date.parse(fdate))) 
		{
			error_status=1;$('#err_msg').html("Proposed-Out date should be greater than Proposed-In date");
		}
		else
			{error_status=0;$('#err_msg').html("");}
		var date1 = new Date(fdate);
		var date2 = new Date(tdate);
		//var timeDiff = Math.abs(date2.getTime() - date1.getTime());
		//diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24)); 
		var diffDays1=(( new Date(tdate) - new Date(fdate) ) / 1000 / 60 / 60)/24;
		var diffDays=(Math.ceil(diffDays1));
		//alert(diffDays);
		$('#nod').val(isNaN(diffDays)?0:diffDays);
		 $('#form').bootstrapValidator('revalidateField', 'poutdate');
		 cal_charg();
	});	
	});	
//$("input[name='htype']").trigger("change",'h');
//$('input[name="htype"][value=t]').prop('checked', 'checked');
</script>
