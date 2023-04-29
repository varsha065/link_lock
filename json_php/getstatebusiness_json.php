<?php
include('../config.php');

/**************High Performing Regions Fetch JSON**************/

if (!file_exists('../json/high_performance_regions_getstatebusiness')) {
	mkdir('../json/high_performance_regions_getstatebusiness', 0777, true);
}

$array_data = array();

$get_labels= mysqli_query($sql, "SELECT c.*, (SELECT sum(amount) from `invoice` where `state` = c.id) as business FROM `state` as c order by business");

while ($getdata_json = mysqli_fetch_object($get_labels)) {
	$json_data = array(
		'pgamount' => round($getdata_json->business),
		'title' => $getdata_json->title,
	);
	$array_data[] = $json_data;
}

$final_data = json_encode($array_data);

file_put_contents('../json/high_performance_regions_getstatebusiness/high_performance_regions_getstatebusiness.json', $final_data);


echo ("High Performing Regions getstatebusiness- JSON Data Updated Successfully !!");


?>