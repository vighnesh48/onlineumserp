   <?php
  // var_dump($_SESSION);
   ?>

 <script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<style>
.panel-heading {
    color: #8a6d3b;
    background-color: #fcf8e3;
    border-color: #faebcc;
}
</style>
<script>

$('#canc').click(function(){

//alert(var1);
var  dat= $("#doc-sub-datepicker20").val();
var remark = $("#cremark").val();
var cfee = $("#cfee").val();
var stid = $("#stid").val();
var stenrl = $("#stenrl").val();
var stayear = $("#stayear").val();
var sprn = $("#sprn").val();

                     if(cfee=='')
                    {
                        alert("Please Enter Cancellation Fee");
                        return false;
                    }
                    
                    
                     if(dat=='')
                    {
                        alert("Please Select Cancellation Date");
                        return false;
                    }
                    
                     if(remark=='')
                    {
                        alert("Please Enter Cancellation Remark");
                        return false;
                    }
                    
var text='';

  text = "Are you sure you want to cancel Admission";  

//var txt;
    if (confirm(text) == true) {
       // txt = "You pressed OK!";
        
    } 
    else
    {
        return false;
    }


 $.ajax({
                    'url' : base_url + 'Ums_admission/cancel_stud_adm',
                    'type' : 'POST', //the way you want to send data to your URL
                    'data' : {'stid':stid,'remark':remark,'cfee':cfee,'dat':dat,'stenrl':stenrl,'stayear':stayear,'sprn':sprn},
                    'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
                       //if(type1=="S"){var container = $('#stest');}else{var container = $('#ptest');} //jquery selector (get element by id)
                        if(data){
                            
                       // alert(data);
                            alert("Admission Cancelled Successfully");
                            $("#makepmnt").hide();
                            $("#hidet").hide();
                            //$("#"+type).val('');
                          //  container.html(data);
                          //location.reload();
                              return false;
                        }
                          return false;
                    }
                });
});







</script>
<?php
if($emp_list['enrollment_no']!='')
{
?>
 <table class="table table-bordered" id="table2excel">
                        <thead>
                            <tr>
                                
                                    <th>PRN</th>
                                     <th class="noExl">Photo</th>
                                    <th>Name</th>
                                    <th>Stream </th>
                                      <th>Total Fee Paid </th>
                                          <th>Applicable Fee </th>
                                              <th>Actual Fee  </th>
                                    <th>Year</th>
                                    <th>Mobile</th>
                                    
                                    <th class="noExl">Action</th>
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php
                          //  var_dump($emp_list);
                          
                            $j=1;                            
                         //   for($i=0;$i<count($emp_list);$i++)
                            //{
                               
                            ?>
               <?php if($emp_list['ro_flag']=='on') $bg="bgcolor='#e6eaf2'";
                  else $bg="";?>                
                            <tr <?=$bg?> <?=$emp_list["status"]=="N"?"style='background-color:#FBEFF2'":""?>>
                               
                        
                                 <td><?=$emp_list['enrollment_no']?></td> 
                                 
                                   <td  class="noExl">
                                       <?php
                                     //  $tep = base_url().'uploads/2017-18/'.$emp_list[$i]['form_number'].'/' . $emp_list[$i]['form_number'].'_PHOTO.bmp';
                                     //  echo $tep;
                                       if (file_exists('uploads/2017-18/'.$emp_list['form_number'].'/' . $emp_list['form_number'].'_PHOTO.bmp')) {
                                         //  echo "yES";
                                           $ext = 'bmp';
                                       }
                                       else
                                       {
                                             $ext = 'jpg';
                                       }
                                       ?>
                                       
                                       <img src="https://erp.sandipuniversity.com/uploads/2017-18/<?=$emp_list['form_number']?>/<?=$emp_list['form_number']?>_PHOTO.<?=$ext?>" alt="" width="60"/></td> 
                                <td>
              
              <?php
                echo $emp_list['first_name']." ".$emp_list['middle_name']." ".$emp_list['last_name'];
                ?>
                </td> 
              
                   <td><?=$emp_list['stream_name']?> <input type="hidden" value="<?=$emp_list['enrollment_no']?>" name="sprn"></td>
                    <td><?=$emp_list['total_fee'][0]['tot_fee_paid']?></td>
                                  <td><?=$emp_list['actual_fee']?></td> 
                                   <td><?=$emp_list['applicable_fee']?></td> 
                            <td><?=$emp_list['admission_year']?></td>                               
                                                      
                                <td><?=$emp_list['mobile'];?></td>    
                                          
                                <td class="noExl" style="padding:0px;" align="center">
                                    <p> 
      <a  href="<?php echo base_url()."ums_admission/view_studentFormDetails/".$emp_list['stud_id'].""?>" title="View" target="_blank"><i class="fa fa-eye"></i>&nbsp;  </a>
         
          <?php
                                 //   if(($_SESSION['role_id']=='1' || $_SESSION['role_id']=='2'  || $_SESSION['role_id']=='6'   || $_SESSION['role_id']=='5' ) && $emp_list['cancelled_admission']=='N' )
                                  //  {
                                    ?>  
                                    <?php if($emp_list['cancelreq']!='N' && $emp_list['cancelreq']!='Y') {?>    
        <span id="hidet">
          <a  href="javascript:void(0)" title="Cancel Admission" id="pmnt" ><i class="fa fa-trash-o"></i> </a>
         <!--  <a href="<?php echo base_url()."ums_admission/cancel_stud_adm_request/".$emp_list['stud_id'].""?>" title="Cancel Admission" id="pmnts" ><i class="fa fa-trash-o"></i> </a> -->
          
          </span>
                                
                       
                       
                          <?php }
                                 else if($emp_list['cancelreq']=='Y'){ echo "Approved";}
                                 else { echo "Requested";}
                          ?>
                             </td>
                            </tr>
                            <?php
                            $j++;
                        //    }
                            ?>                            
                        </tbody>
                    </table>  
            <?php
}
else
{
   echo "Record Not Found";       
}
            ?>
                       <input type="hidden" name="dcourse" value="<?=$dcourse;?>">
                     <input type="hidden" name="dyear" value="<?=$dyear;?>">
                    
                     <!-- <input type="submit" value="Apply Fees" class="btn btn-primary btn-labeled">-->
                     
                     
                     </form>
                     
                     
                     
                     
                       <div class="panel" id="makepmnt" style="display:none">
                            <div class="panel-heading">
                <span class="panel-title">Cancel Admission</span>
              </div>
                                <div class="panel-body">
                
                                 <div class="form-group">
                  
                 <!--  <label class="col-sm-3">Cancellation Fee</label>
                                    <div class="col-sm-3">
                                      <input type="text" name="cfee" id="cfee" class="form-control"  value="" placeholder="Cancellation Fee" required>
                                    </div>-->
                  
                                    <label class="col-sm-3">Cancellation Date</label>
                                    <div class="col-sm-3">
                                      <input type="text" class="form-control" id="doc-sub-datepicker20" name="cdate"  required value="" placeholder="Cancellation  Date" required readonly="true"/>
                                    </div>
                                   
                                  </div>
                                  <div class="form-group">
                                    <label class="col-sm-3">Remark</label>
                                    <div class="col-sm-3">
                                    <textarea class="form-control" name="cremark" id="cremark" ></textarea>
<input type="hidden" name="stid" id="stid" value="<?=$emp_list['stud_id']?>">
<input type="hidden" name="stenrl" id="stenrl" value="<?=$emp_list['enrollment_no']?>">
<input type="hidden" name="stayear" id="stayear" value="<?=$emp_list['admission_session']?>">
                                    </div>
                                   
                                  </div>
                                  

                  <div class="form-group">
                   <label class="col-sm-6"></label>
                                    <div class="col-sm-6"><button type="submit" name="Make_Payment" id="canc" value="Cancel Admission" class="btn btn-primary">Cancel Admission</button>
                                    </div>
                                  </div>
                                  
                                </div>
                            </div>
                     
                     
                     
                     
                     
                     
                     
                     
                     
                   
                     <script>
                     
                     
                     
                     
$(document).ready(function () {
    $("#ckbCheckAll").click(function () {
        $(".checkBoxClass").prop('checked', $(this).prop('checked'));
    });
    
    $(".checkBoxClass").change(function(){
        if (!$(this).prop("checked")){
            $("#ckbCheckAll").prop("checked",false);
        }
    });
});
                     
                     
        $('#pmnt').on('click', function () {
    $("#makepmnt").show();
  });              
                     
                     
                     
                     
                     
                     
            $('#doc-sub-datepicker20').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
        $('#doc-sub-datepicker21').datepicker( {format: 'yyyy-mm-dd',autoclose: true});           
                     
                     
$("#expdata").click(function(){

  $("#table2excel").table2excel({

    exclude: ".noExl",

    name: "Worksheet Name",
  filename: "Student List" //do not include extension

  });

});

                     </script>
                     
                     
      