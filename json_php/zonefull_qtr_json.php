<?php
include('../config.php');

    /**************Total Sale QTD Amount Fetch JSON**************/

	$startqtr = "2022-10-01 00:00:00";
	$endqtr = "2023-12-31 23:59:00";
	$get_inv_amt = mysqli_query($sql,"SELECT sum(amount) as amount FROM `invoice` where inv_date >= '$startqtr' and inv_date <= '$endqtr'");

	$array_data = array();

	while ($getdata_json = mysqli_fetch_object($get_inv_amt)) {

		$json_data = array(
			'startqtr' => $startqtr,
			'endqtr' => $endqtr,
			'zoneamount' => round($getdata_json->amount),
		);
		$array_data[] = $json_data;

		$final_data = json_encode($array_data);

		if (!file_exists('../json/total_sale_qtd_amount')) {
			mkdir('../json/total_sale_qtd_amount', 0777, true);
		}

		file_put_contents('../json/total_sale_qtd_amount/total_sale_qtd_amount.json', $final_data);
	}

	echo ("Total Sale QTD Amount JSON Data Updated Successfully !!");
		

?>