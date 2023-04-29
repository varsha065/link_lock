<?php
include('../config.php');

    /**************Target Vs Achived - getmonthwise  JSON**************/

	if (!file_exists('../json/target_achived_getmonthwise')) {
		mkdir('../json/target_achived_getmonthwise', 0777, true);
	}

	$array_data = array();

	$financial_year = mysqli_query($sql, "SELECT * FROM `fy_year`");
	while($list_year = mysqli_fetch_object($financial_year))
	{
		$fy_year = $list_year->fy_year;

		$data= explode('-', $fy_year);
		$first_year = trim($data[0]);
		$next_year = $first_year+1;

		for($permo=4;$permo<=12;$permo++){
			$permo = sprintf("%02d", $permo);
			$inv_amount = mysqli_query($sql, "SELECT sum(amount) as amount FROM `invoice` where `inv_date` like '" . $first_year . "-" . $permo . "%'");
			while ($getdata_json = mysqli_fetch_object($inv_amount)) {
				$json_data = array(
					'financial_year' => $fy_year,
					'year' => $first_year,
					'month' => $permo,
					'pgamount' => $getdata_json->amount,
				);
				$array_data[] = $json_data;	
			}
		}

		for($permo=1;$permo<=3;$permo++){
			$inv_amount = mysqli_query($sql, "SELECT sum(amount) as amount FROM `invoice` where `inv_date` like '" . $next_year . "-" . $permo . "%'");
			while ($getdata_json = mysqli_fetch_object($inv_amount)) {
				$json_data = array(
					'financial_year' => $fy_year,
					'year' => $next_year,
					'month' => $permo,
					'pgamount' => $getdata_json->amount,
				);
				$array_data[] = $json_data;	
			}
		}

		$final_data = json_encode($array_data);

		file_put_contents('../json/target_achived_getmonthwise/target_achived_getmonthwise.json', $final_data);

	}

	echo ("Target Vs Achived - getmonthwise JSON Data Updated Successfully !!");
		

?>