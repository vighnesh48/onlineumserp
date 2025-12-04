<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<?php //print_r($my_privileges); die; ?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Masters</a></li>
        <li class="active"><a href="#">User Master</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;User_Details</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">                 
                    <div class="visible-xs clearfix form-group-margin"></div>
                    <form class="pull-right col-xs-12 col-sm-6" action="">
                        <div class="input-group no-margin">
                            <span style="border:none;background: #fff;background: rgba(0,0,0,.05);" class="input-group-addon"><i class="fa fa-search"></i></span>
                            <select id="search_me" name="search_me" style="border:none;background: #fff;background: rgba(0,0,0,.05);" class="form-control no-padding-hr" placeholder="Search...">
                                <option value="">Select Title</option>
                                <?php
                                    for($i=0;$i<count($user_master_data);$i++)
                                    {
                                ?>
                                <option value="<?=$user_master_data[$i]['um_id']?>"><?=$user_master_data[$i]['username']?></option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>
                    </form>
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
                        <div class="holder"></div>
                </div>
                <div class="panel-body">
                    <div class="table-info">              
                    <table class="table table-bordered" id="example">
                        <thead>
                            <tr>
								<th>#</th>
								<th>UserName</th>
								<th>Password</th>
								<th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php
                            $j=1;                            
                            for($i=0;$i<count($user_master_data);$i++)
                            {   
                            ?>
                            <tr <?=$user_master_data[$i]["status"]=="N"?"style='background-color:#FBEFF2'":""?>>
                                <td><?=$j?></td>                                                                
                                <td><?=$user_master_data[$i]['username']?></td>
                                <td><?=$user_master_data[$i]['password']?></td>                                
                                <td>
                                  <a href='<?=base_url($currentModule)."/user_status/"?><?=$user_master_data[$i]["status"]=="Y"?"disable/".$user_master_data[$i]["um_id"]:"enable/".$user_master_data[$i]["um_id"]?>'><i class='fa <?=$user_master_data[$i]["status"]=="N"?"fa-ban":"fa-check"?>' title='<?=$user_master_data[$i]["status"]=="N"?"Enable":"Disable"?>'></i></a>
                                </td>
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
    </div>
</div>
<script>
  $("div.holder").jPages
  ({
    containerID : "itemContainer"
  });
  $("#search_me").select2({
      placeholder: "Enter UserName",
      allowClear: true
    });
        $("#search_me").on('change',function()
        {
            var search_val = $(this).val();            
            var url  = "<?=base_url().strtolower($currentModule).'/user_search/'?>";	
            var data = {title: search_val};		
            var type="";
            var type_name="";
            $.ajax
            ({
                type: "POST",
                url: url,
                data: data,
                dataType: "html",
                cache: false,
                crossDomain: true,
                success: function(data)
                {                       
                    var array=JSON.parse(data);
                    var str="";	
                   
                    for(i=0;i<array.user_master_data.length;i++)
                    {
						 var color="";
                         var status='<a href="<?=base_url(strtolower($currentModule))?>/user_status/disable/'+array.user_master_data[i].um_id+'"><i title="Disable" class="fa fa-ban"></i></a>';
					   if(array.user_master_data[i].status=="N")
						{
							status='<a href="<?=base_url(strtolower($currentModule))?>/user_status/enable/'+array.user_master_data[i].um_id+'"><i title="enable" class="fa fa-check"></i></a>';
                             var color='background-color:#FBEFF2';
						}
                        str+='<tr style="display: table-row; opacity: 1;'+color+'">';
                        str+='<td>'+(i+1)+'</td>';
                        str+='<td>'+array.user_master_data[i].username+'</td>';
                        str+='<td>'+array.user_master_data[i].password+'</td>';                        
                        str+='<td>'+status+'</td>';
                        str+='</tr>';
                        $("#itemContainer").html(str);
                    }
					  $("div.holder").jPages
					  ({
						containerID : "itemContainer"
					  });
                },
                error: function(data)
                {
                    alert("Page Or Folder Not Created..!!");
                }
            });
        });
</script>