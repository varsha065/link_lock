<?php
include('../config.php');

    /**************Total Sale YTD Amount Fetch JSON**************/
	if (!file_exists('../json/total_sale_ytd_amount')) {
		mkdir('../json/total_sale_ytd_amount', 0777, true);
	}

	$getyear = mysqli_query($sql, "SELECT * FROM `fy_year`");
	while($list_year = mysqli_fetch_object($getyear))
	{
		$year= $list_year->fy_year;
		$filename = 'total_sale_ytd_amount'.'_'.$year;

		//SELECT * FROM `invoice` where YEAR(inv_date) between '2022-04-01 00:00:00' and '2023-03-01 00:00:00'
		$fy_start = $list_year->start_month;
		$fy_last = $list_year->last_month;

		$get_inv_amt = mysqli_query($sql,"SELECT sum(amount) as amount FROM `invoice` where `inv_date` BETWEEN '$fy_start-01 00:00:00' and '$fy_last-31 23:59:00'");

		$array_data = array();
	
		while ($getdata_json = mysqli_fetch_object($get_inv_amt)) {
	
			$json_data = array(
                'zoneamount' => $getdata_json->amount,
			);
			$array_data[] = $json_data;
	
			$final_data = json_encode($array_data);
	
			file_put_contents('../json/total_sale_ytd_amount/'.$filename.'.json', $final_data);
		}

	}

	echo ("Total Sale YTD Amount JSON Data Updated Successfully !!");
		

?>