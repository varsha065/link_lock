<?php
include('../config.php');

    /**************Category Wise Total Sale JSON**************/

	$permo = 'DESC';
	$getclbus = mysqli_query($sql,"SELECT c.*, (SELECT sum(amount_before_tax) from `product_cart` where `pcid` = c.id) as business FROM `product_category` as c order by business $permo LIMIT 5");

	$array_data = array();

	while ($getdata_json = mysqli_fetch_object($getclbus)) {

		$json_data = array(
			'title' => $getdata_json->title,
			'amount' => $getdata_json->business,
		);
		$array_data[] = $json_data;

		$final_data = json_encode($array_data);

		if (!file_exists('../json/categorywise_sale')) {
			mkdir('../json/categorywise_sale', 0777, true);
		}

		file_put_contents('../json/categorywise_sale/categorywise_sale.json', $final_data);
	}

	echo ("Category Wise Total Sale JSON Data Updated Successfully !!");
		

?>