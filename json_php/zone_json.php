<?php
include('../config.php');

    /**************Total Sale YTD Amount Fetch JSON**************/
	if (!file_exists('../json/total_sale_ytd_bar_amount')) {
		mkdir('../json/total_sale_ytd_bar_amount', 0777, true);
	}

	$array_data = array();

	$getzone = mysqli_query($sql, "SELECT * FROM `zone`");
	while($list_zone = mysqli_fetch_object($getzone))
	{
		$zoneid = $list_zone->id;
		$zone_title = $list_zone->title;

		$salesytd = mysqli_query($sql, "SELECT sum(amount) as amount FROM `invoice` where `zone` = '$zoneid'");
	
		while ($getdata_json = mysqli_fetch_object($salesytd)) {
			$json_data = array(
				'zoneid' => $zoneid,
				'zone_title' => $zone_title,
                'zoneamount' => round($getdata_json->amount,0),
			);
			$array_data[] = $json_data;				
		}

		$final_data = json_encode($array_data);

		file_put_contents('../json/total_sale_ytd_bar_amount/total_sale_ytd_bar_amount.json', $final_data);

	}

	echo ("Total Sale YTD Bar Amount JSON Data Updated Successfully !!");
		

?>