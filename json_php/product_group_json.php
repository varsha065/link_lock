<?php
include('../config.php');

/**************Total Categorywise product group labels Fetch JSON**************/

if (!file_exists('../json/categorywise_product_group_labels')) {
	mkdir('../json/categorywise_product_group_labels', 0777, true);
}

$array_data = array();

$get_labels= mysqli_query($sql, "SELECT * FROM `product_group`");

while ($getdata_json = mysqli_fetch_object($get_labels)) {
	$json_data = array(
		'product_grp_id' => $getdata_json->id,
		'product_grp_title' => $getdata_json->title,
	);
	$array_data[] = $json_data;
}

$final_data = json_encode($array_data);

file_put_contents('../json/categorywise_product_group_labels/categorywise_product_group_labels.json', $final_data);


echo ("Total Categorywise product group labels JSON Data Updated Successfully !!");


?>