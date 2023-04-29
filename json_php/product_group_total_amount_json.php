<?php
include('../config.php');

    /**************Categorywise report - product_group_total_amount  JSON**************/

	if (!file_exists('../json/categorywise_product_group_total_amount')) {
		mkdir('../json/categorywise_product_group_total_amount', 0777, true);
	}

	$array_data = array();

	$salesytda = mysqli_query($sql, "SELECT * FROM `product_group`");
	while($listdata = mysqli_fetch_object($salesytda))
	{
		$pgid = $listdata->id;

        $salesytd = mysqli_query($sql, "SELECT sum(amount_before_tax) as qty FROM `product_cart` where pgid = '$pgid'");
	
		while ($getdata_json = mysqli_fetch_object($salesytd)) {
			$json_data = array(
				'pid' => $pgid,
				'pgamount' => round($getdata_json->qty),
			);
			$array_data[] = $json_data;				
		}
		$final_data = json_encode($array_data);

		file_put_contents('../json/categorywise_product_group_total_amount/categorywise_product_group_total_amount.json', $final_data);

	}

	echo ("Categorywise report - product_group_total_amount JSON Data Updated Successfully !!");
		

?>