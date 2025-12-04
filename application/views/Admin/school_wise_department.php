<?php
//print_r($deptBYschool_list);
 
if(!empty($deptBYschool_list)){
	echo "<option  value='' >Select Department </option>";
	foreach($deptBYschool_list as $ec ){
	echo "<option  value=".$ec['department_id'].">".$ec['department_name']."</option>";
	}
}else{
	echo "<option  value='' >Select Department </option>";
}


	?>
