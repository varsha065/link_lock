<?php
include('../config.php');

    /**************Categorywise report - product_group_total  JSON**************/
	$startqtr = '2022-10-01 00:00:00';
	$endqtr = '2023-12-31 23:59:00';

	if (!file_exists('../json/categorywise_product_group_total')) {
		mkdir('../json/categorywise_product_group_total', 0777, true);
	}

	$array_data = array();

	$salesytda = mysqli_query($sql, "SELECT * FROM `product_group`");
	while($listdata = mysqli_fetch_object($salesytda))
	{
		$pgid = $listdata->id;

        $salesytd = mysqli_query($sql, "SELECT sum(quantity) as qty FROM `product_cart` where pgid = '$pgid'");
        // $pgidamount = mysqli_fetch_object($salesytd);

        // $pgamount = round($pgidamount->qty);
	
		while ($getdata_json = mysqli_fetch_object($salesytd)) {
			$json_data = array(
				'pid' => $pgid,
				'pgamount' => round($getdata_json->qty),
			);
			$array_data[] = $json_data;				
		}
		//print_r($json_data);
		$final_data = json_encode($array_data);

		file_put_contents('../json/categorywise_product_group_total/categorywise_product_group_total.json', $final_data);

	}

	echo ("Categorywise report - product_group_total JSON Data Updated Successfully !!");
		

?>