  <div class="row">
    <div class="col-lg-12">
        <h1>Accounts <small></small></h1>
        <ol class="breadcrumb">
            <li class="active"><i class="fa fa-list"></i> Import Re-registration Fees</li>
        </ol>            
    </div>
</div><!-- /.row -->

						
						
						<form action="<?=base_url()?>Import/save" enctype="multipart/form-data" method="post" accept-charset="utf-8">
<div class="row"><div class="col-lg-12 col-sm-12"><div class="form-group"><label for="image">Choose file</label><input type="file" name="userfile" id="userfile" class="form-control filestyle" value="" data-icon="false">
</div> <span style="color:red;">*Please choose an Excel file(.xls or .xlxs) as Input</span></div><div class="col-lg-12 col-sm-12"><div class="form-group text-right"><input type="submit" name="importfile" value="Import" id="importfile-id" class="btn btn-primary">
</div>
                        </div></div></form>
