
<script src="<?= base_url('assets/javascripts') . '/bootstrap-datepicker.js' ?> "></script>
<link href="<?= site_url() ?>assets/css/pick.css" rel="stylesheet" type="text/css" />
<script src="<?= site_url() ?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<script type="text/javascript">
   <!--
   function copyBilling (f) {
       var s, i = 0;
       if(f.same.checked == true) {
   
       while (s = ['A', 'B', 'C', 'D', 'country', 'pc'][i++]) {f.elements['shipping_' + s].value = f.elements['bill_' + s].value};
       }
       if(f.same.checked == false) {
       // alert(false);
       while (s = ['A', 'B', 'C', 'D', 'country', 'pc'][i++]) {f.elements['shipping_' + s].value ="";};
       }
   }
   // -->
</script>
<div id="content-wrapper">
<ul class="breadcrumb breadcrumb-page">
   <div class="breadcrumb-label text-light-gray">You are here: </div>
   <li><a href="#">Masters</a></li>
   <li class="active"><a href="#">Admission Form</a></li>
</ul>
<div class="page-header">
   <div class="row">
      <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Admission Form</h1>
      <div class="col-xs-12 col-sm-8">
         <div class="row">
            <hr class="visible-xs no-grid-gutter-h">
         </div>
      </div>
   </div>
   <div class="row ">
      <div class="col-sm-12">
         <div class="panel">
            <div class="panel-body">
               <div class="xtable-info">
                  <div id="dashboard-recent" class="panel panel-warning">
                     <?php include 'stepbar.php';?>
                     <div class="tab-content">
                        <form method="post" action="<?=base_url()?>Question_paper/update_docDetails" enctype="multipart/form-data">
                        <!--start  of documents-certificates -->
                          <div id="documents-certificates" class="setup-content widget-threads panel-body tab-pane">
                              <div class="panel">
                                <div class="panel-heading">List Of Documents To Be Submitted
                                  <?= $astrik ?>
                               </div>
                                <div class="panel-body">
                                  <div class="table-responsive">
                                    <table class="doc-tbl table-bordered">
                                      <input type="hidden" name="qp_id" id="qp_id"   value="<?php echo $qp_data['0']['id']; ?>">
                                      <tr>
                                          
                                <th>Set No.</th>
                                <th>Upload</th>
                                 <th colspan="2">View</th>
                                      </tr>                                    
                                     <?php
                                    
                                    //echo count($qp_data_docs);
                                    //exit;
                                    /*if(count($qp_data_docs) > 0){*/
                                    
                                           $i =1;
                                 foreach($qp_data_docs as $key => $qp_data_doc) {
                                
                                 ?>
                                     <tr>
                                         <td><?= $i ?>
                                         <input type="hidden" name="doc_id[<?= $i; ?>]" value="<?= $qp_data_doc['id'] ?>"></td>
                                         
                                        <td><input type="file" name="scandoc[<?= $i; ?>]"></td>
                                        <td colspan="2">
										<?php
										if(trim($qp_data_doc['doc_path'])!=''){
										$b_name = "uploads/student_document/questionpaper/";
										 $dwnld_url = base_url()."Upload/download_s3file/".$qp_data_doc['doc_path'].'?b_name='.$b_name;
										?>
										<a href="<?php echo $dwnld_url ?>" download >View</a>
										<?php
										}
										?>
										</td>
                                    
                                      </tr>
                                      <?php
                                      $i++;
        }
        ?>


                              <th class="text-center" colspan="4">Check List</th>

        <?php


                      
                              
                               $i =1;
                                 foreach($qp_check_lists as $key => $qp_check_list) {
                                    $id = 'check_list'.$i;
                                     
                                 ?>
                                    
                                 <tr>
                                     <td><?= $i;?></td>
                                     <td><?= $qp_check_list['description'];?></td>
                                     <td><input type = 'radio' name='check_list<?= $i;?>' value= '1' <?php if (isset($qp_data['0'][ $id]) && $qp_data['0'][ $id] == 1): ?>checked='checked'<?php endif; ?> required>Yes</td>
                                     <td><input type = 'radio' name='check_list<?= $i;?>' value= '0' <?php if (isset($qp_data['0'][ $id]) && $qp_data['0'][ $id] == 0): ?>checked='checked'<?php endif; ?>required>No</td>
                                 </tr>


                                      <?php
                                      $i++;
        }  ?>  

    
                                   </table>
                                  </div>
                                </div>
                              </div>
                              
                                <div class="col-sm-8">
                                <table class="doc-tbl table-bordered">
                        
                   </table>
                                </div>
                               <div class="col-sm-2">
                                  <button class="btn btn-primary nextBtn form-control" type="submit" >Update</button>
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
<script type="text/javascript">
 

</script>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    $(document).ready(function(){
        /*$('input[type="file"]').change(function(e){
            var fileName = e.target.files[0].name;
            alert('The file "' + fileName +  '" has been selected.');
        });*/
    });
</script>
<!-- steps logic-->