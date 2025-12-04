<style>
#edit.disabled {
  pointer-events: none;
  cursor: default;
}
</style>
<?php ?>
<?php // print_r($state_details); die; ?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#"> Masters</a></li>
        <li class="active"><a href="#">Marks Entry</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Marks Entry</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                    <div class="visible-xs clearfix form-group-margin"></div>
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-sm-12">&nbsp;</div>
        </div>
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                <div class="panel-heading">
                        <span class="panel-title">List</span>
                        <div class="holders"></div>
                </div>
                <div class="panel-body">
                <?php if($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $this->session->flashdata('error'); ?>
                    </div>
                <?php endif; ?>
				<?php if($this->session->flashdata('success')): ?>
                            <div class="alert alert-success" role="alert">
                                <?php echo $this->session->flashdata('success'); ?>
                            </div>
                        <?php endif; ?>
    <form action="<?php echo base_url('exam_marks_entry/index'); ?>" method="post" class="form-inline">
    <div class="form-group">
        <select id="examFilter" name="exam_id" class="form-control">
            <?php foreach ($exam_list as $exam): ?>
                <option value="<?php echo $exam['exam_id']; ?>"><?php echo $exam['exam_name'];?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group mx-sm-3">
        <label for="barcode" class="sr-only">Barcode:</label>
        <input type="text" name="barcode" class="form-control" value="<?php echo isset($_POST['barcode']) ? $_POST['barcode'] : ''; ?>" placeholder="Barcode">
    </div>
    <button type="submit" class="btn btn-primary">Search</button>
</form>

<p style="color:red">(Marks entry is active from <?php echo $exam['th_date_start']; ?> to <?php echo $exam['th_date_end']; ?>.)</p>

                    <div class="table-info">    
                    <?php if(isset($exam_data)): ?>
                    <table class="display responsive nowrap" cellspacing="0" width="100%" id="cia_exam_session_data">
                        <thead>
                        <tr>
                            <th class="text-center">Stream</th>
                            <th class="text-center">Enrollement No.</th>
                            <th class="text-center">Subject</th>
                            <th class="text-center">Exam</th>
                            <th class="text-center">Barcode No.</th>
                            <th class="text-center">Maximum Marks</th>
                            <th class="text-center">Marks</th>
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                        <tr>
                            <td class="text-center" ><?php echo $exam_data['stream_name']; ?></td>
                            <td class="text-center" ><?php echo $exam_data['enrollment_no']; ?></td>
                            <td class="text-center" ><?php echo $exam_data['subject_code'].'-'.$exam_data['subject_name']; ?></td>
                            <td class="text-center" ><?php echo $exam_data['exam_name']; ?></td>
                            <td class="text-center" ><?php echo $exam_data['barcode']; ?></td>
                            <td class="text-center" ><?php echo $exam_data['theory_max']; ?></td>
 
                            <td class="text-center" >
                                <form style="padding-top:15px;" action="<?php echo base_url('exam_marks_entry/save_marks'); ?>" method="post">
                                    <input type="hidden" name="exam_id" value="<?php echo $exam_data['exam_id']; ?>">
                                    <input type="hidden" name="barcode" value="<?php echo $exam_data['barcode']; ?>">
                                    <input type="text" name="marks">
                                    <button type="submit" class="btn btn-primary" >Save Marks</button>
                                </form>
                            </td>
                        </tr>       
                        </tbody>
                    </table>                    

                    <?php endif; ?>
                    </div>
                </div>
            </div>
            </div>    
        </div>
    </div>
</div>
<?php ?>

<script>
  $("div.holder").jPages
  ({
    containerID : "itemContainer"
  });
  $(document).ready(function() {
    $('#cia_exam_session_data').DataTable({
    responsive: true
});

    $("#cia_exam_session_data_paginate").removeClass("dataTables_paginate"); 
} );
  
</script>

