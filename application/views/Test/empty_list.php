<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
</head>
<?php
/*function url_exists($url) {

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    return ($code == 200); // verifica se recebe "status OK"
}*/

  $CI =& get_instance();
?>
<body>
<div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                <div class="panel-heading">
                    <span class="panel-title"><b>Programme List </b> <a href="<?=base_url()?>subject/downloadstreamPdf" target="_blank"><button class="btn btn-primary pull-right">Download PDF </button></a></span>
                </div>
                <div id="show_list" class="panel-body" style="overflow-x:scroll;height:550px;">
                    <div class="table-info" >    
                    
                    <table class="table table-bordered" id="table" style="width:100%;max-width:100%;">
                        <thead>
						<tr>
                                    <th>#</th>
							
									<th>PRN</th>
                                    <th>First&nbsp;Name</th>
									<th>Academic</th>
									<th>Session</th>
									<th>School&nbsp;Name</th>
									<th>Stream&nbsp;Name</th>
									<th>email</th>
									<th>mobile</th>
                                    <th>dob</th>
                                    <th>Photo</th>
                                    <th>mother&nbsp;name</th>
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                              <?php
							  
                            $j=1;                      
                            for($i=0;$i<count($stream_details);$i++)
                            {
                                
                            ?>
                            <tr>
                                <td><?=$j?></td>                                                                
                                <td><?=$stream_details[$i]['enrollment_no']?></td>
								<td><?=$stream_details[$i]['first_name']?></td>
								<td><?=$stream_details[$i]['academic_year']?></td>
                                <td><?=$stream_details[$i]['admission_session']?></td>
								<td><?=$stream_details[$i]['school_short_name']?></td>
                                <td><?=$stream_details[$i]['stream_name']?></td>
								<td><?=$stream_details[$i]['email']?></td>
								<td><?=$stream_details[$i]['mobile']?></td>
                                <td><?=$stream_details[$i]['dob']?></td>
                               <td><?php if($CI->url_exists("https://erp.sandipuniversity.com/uploads/student_photo/".$stream_details[$i]['enrollment_no'].".jpg")) { echo 'yes'; }else{echo 'no'; }?></td>
                               <td><?=$stream_details[$i]['mother_name']?></td>
                            </tr>
                            <?php
                            $j++;
                            }
                            ?>                           
                        </tbody>
                    </table>  
					
                   
                </div>
                </div>
            </div>
			
            </div>    
        </div>
        <script type="text/javascript">
$(document).ready(function() {
	
	 $('#table').DataTable({ 
	  "pageLength": 100,
	dom: 'Bfrtip',
        buttons: [
           'excel'
        ]
	});
	
});
</script>
</body>
</html>