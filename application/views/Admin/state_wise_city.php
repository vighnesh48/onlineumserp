<?php
//print_r($deptBYschool_list);
 
if(!empty($city_list)){
	echo "<option  value='' >Select </option>";
	foreach($city_list as $ec ){
	echo "<option  value=".$ec['city_id'].">".$ec['city_name']."</option>";
	}
}else{
	echo "<option  value='' >Select </option>";
}


	?>
