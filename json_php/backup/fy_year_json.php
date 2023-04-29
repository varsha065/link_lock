<?php
include('../config.php');

    /**************Financial Year Dropdown Fetch JSON**************/
	
	$getyear = mysqli_query($sql, "SELECT * FROM `fy_year`");

		$array_data = array();
	
		while ($getdata_json = mysqli_fetch_object($getyear)) {
	
			$json_data = array(
                'id' => $getdata_json->id,
				'fy_year' => $getdata_json->fy_year,
				'status' => $getdata_json->status,
			);
			$array_data[] = $json_data;
	
			$final_data = json_encode($array_data);
	
			if (!file_exists('../json/fy_year')) {
				mkdir('../json/fy_year', 0777, true);
			}
	
			file_put_contents('../json/fy_year/fy_year.json', $final_data);
		}

		echo ("Financial Year JSON Data Updated Successfully !!");

?>