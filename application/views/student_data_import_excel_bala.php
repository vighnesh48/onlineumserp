<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Sandip University</title>
<script src="<?=site_url()?>assets/javascripts/numbertowords.js" type="text/javascript"></script>
 <body>

<div class="xcontainer xpanel-body" id="content-wrapper">
  <div class="row main-wrapper head-add">
    </div>
  
  <div class="row detail-bg panel-body">

                <form class="" action="<?= base_url($currentModule.'/upload_excel_for_marks_entry') ?>" method="post" name="upload_excel" enctype="multipart/form-data">
                    <fieldset>
 
                        <!-- Form Name -->
                        <legend>Upload exceldata for marks entry: <?=$ex[0]['exam_month']?>-<?=$ex[0]['exam_year']?></legend>                      						
						
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="filebutton">Select File</label>
                            <div class="col-md-4">
                                <input type="file" name="file" id="file" class="input-large" required>
                            </div>
                        </div>
 
                        <!-- Button -->
                        <div class="form-group">
                            
                            <div class="col-md-4">
                                <button type="submit" id="submit" name="Import" class="btn btn-primary button-loading" data-loading-text="Loading...">Submit</button>
                            </div>
                        </div>
 
                    </fieldset>
                </form>
				</div>

</div><script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>			