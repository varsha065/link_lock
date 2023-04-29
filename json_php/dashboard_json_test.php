<?php
include('../config.php');

	if (!file_exists('../json/dashboard_json_test')) {
		mkdir('../json/dashboard_json_test', 0777, true);
	}

	$array_data = array();

	$main_array = array();
	$fy_year_array = array();
	$region_array = array();
	$month_array = array();
	$state_array = array();

	$fetch_fy_year = mysqli_query($sql, "SELECT * FROM `fy_year`");
	while ($row_fy_year = mysqli_fetch_assoc($fetch_fy_year)) {
    $fy_year_array['fyearid'] = $row_fy_year['id'];
    $fy_year_array['fyear'] = $row_fy_year['fy_year'];

		$fy_start = $row_fy_year['start_month'];
		$fy_last = $row_fy_year['last_month'];
		$get_fyamount = mysqli_query($sql,"SELECT round(sum(amount)) as amount FROM `invoice` where `inv_date` BETWEEN '$fy_start-01 00:00:00' and '$fy_last-31 23:59:00'");
		$list_fyamount = mysqli_fetch_object($get_fyamount);
		$fy_total_amount = $list_fyamount->amount;

	$fy_year_array['year_amount'] = $fy_total_amount;
	$fy_year_array['region'] = array();
		
		$get_region = mysqli_query($sql,"SELECT * FROM `zone`");
		while($row_region = mysqli_fetch_object($get_region)){
			$region_array['regionid'] = $row_region->id;
			$region_array['region_name'] = $row_region->title;
			
			//$get_regionamount = mysqli_query($sql,"SELECT round(sum(amount)) as amount FROM `invoice` where zone='$row_region->id'");
			$get_regionamount = mysqli_query($sql,"SELECT round(sum(amount)) as amount FROM `invoice` where `zone`='$row_region->id' and `inv_date` BETWEEN '$fy_start-01 00:00:00' and '$fy_last-31 23:59:00'");
			$list_regionamount = mysqli_fetch_object($get_regionamount);
			$region_total_amount = $list_regionamount->amount;

			$region_array['region_amount'] = $region_total_amount;
			$region_array['month'] = array();


			//monthwise json
			$data= explode('-', $row_fy_year['fy_year']);
			$first_year = trim($data[0]);
			$next_year = $first_year+1;

			for($permo=4;$permo<=12;$permo++){
				$permo = sprintf("%02d", $permo);
				
				$start_date = $first_year.'-'.$permo.'-'.'01'.' 00:00:00';
				$end_date = date("Y-m-t", strtotime($start_date)).' 23:59:00';
				$inv_amount = mysqli_query($sql, "SELECT round(sum(amount)) as amount FROM `invoice` where `zone` = '$row_region->id' and  `inv_date` like '" . $first_year . "-" . $permo . "%'");
				//$inv_amount = mysqli_query($sql, "SELECT round(sum(amount)) as amount FROM `invoice` where `zone` = '$row_region->id' and  `inv_date` >= '$start_date' and inv_date <= '$end_date'");
				//echo "SELECT round(sum(amount)) as amount FROM `invoice` where `zone` = '$row_region->id' and  `inv_date` >= '$start_date' and inv_date <= '$end_date'";
				while ($getdata_json = mysqli_fetch_object($inv_amount)) {
					$month_array['month_code'] = $permo;
					$month_array['month_name'] = date('F', mktime(0, 0, 0, $permo, 10));
					$month_array['month_amount'] = $getdata_json->amount;

					//state
					$month_array['state'] = array();
					$get_state = mysqli_query($sql,"SELECT * FROM `state`");
					while($row_state = mysqli_fetch_object($get_state)){
						$state_array['state_id'] = $row_state->id;
						$state_array['state_name'] = $row_state->title;

						$start_date = $first_year.'-'.$permo.'-'.'01'.' 00:00:00';
						$end_date = date("Y-m-t", strtotime($start_date)).' 23:59:00';
						$inv_amount = mysqli_query($sql, "SELECT round(sum(amount)) as amount FROM `invoice` where `zone` = '$row_region->id' and `state`='$row_state->id' and `inv_date` like '" . $first_year . "-" . $permo . "%'");
						//$inv_amount = mysqli_query($sql, "SELECT round(sum(amount)) as amount FROM `invoice` where `zone` = '$row_region->id' and `state`='$row_state->id' and `inv_date` >= '$start_date' and inv_date <= '$end_date'");
						$list_stateamount = mysqli_fetch_object($inv_amount);
						$state_zonewise_amount = $list_stateamount->amount;

						$state_array['state_amount'] = $state_zonewise_amount;
						array_push($month_array['state'],$state_array);

					}
					array_push($region_array['month'],$month_array);

				}
			}

			for($permo=1;$permo<=3;$permo++){
				$permo = sprintf("%02d", $permo);
				$inv_amount = mysqli_query($sql, "SELECT round(sum(amount)) as amount FROM `invoice` where `zone` = '$row_region->id' and `inv_date` like '" . $next_year . "-" . $permo . "%'");
				$start_date = $next_year.'-'.$permo.'-'.'01'.' 00:00:00';
				$end_date = date("Y-m-t", strtotime($start_date)).' 23:59:00';
				//$inv_amount = mysqli_query($sql, "SELECT round(sum(amount)) as amount FROM `invoice` where `zone` = '$row_region->id' and  `inv_date` >= '$start_date' and inv_date <= '$end_date'");

				//echo "SELECT round(sum(amount)) as amount FROM `invoice` where `zone` = '$row_region->id' and  `inv_date` >= '$start_date' and inv_date <= '$end_date'";
				while ($getdata_json = mysqli_fetch_object($inv_amount)) {
					$month_array['month_code'] = $permo;
					$month_array['month_name'] = date('F', mktime(0, 0, 0, $permo, 10));
					$month_array['month_amount'] = $getdata_json->amount;

					//state
					$month_array['state'] = array();
					$get_state = mysqli_query($sql,"SELECT * FROM `state`");
					while($row_state = mysqli_fetch_object($get_state)){
						$state_array['state_id'] = $row_state->id;
						$state_array['state_name'] = $row_state->title;

						$inv_amount = mysqli_query($sql, "SELECT round(sum(amount)) as amount FROM `invoice` where `zone` = '$row_region->id' and `state`='$row_state->id' and `inv_date` like '" . $first_year . "-" . $permo . "%'");
						$start_date = $next_year.'-'.$permo.'-'.'01'.' 00:00:00';
						$end_date = date("Y-m-t", strtotime($start_date)).' 23:59:00';
						//$inv_amount = mysqli_query($sql, "SELECT round(sum(amount)) as amount FROM `invoice` where `zone` = '$row_region->id' and `state`='$row_state->id' and `inv_date` >= '$start_date' and inv_date <= '$end_date'");
						$list_stateamount = mysqli_fetch_object($inv_amount);
						$state_zonewise_amount = $list_stateamount->amount;

						$state_array['state_amount'] = $state_zonewise_amount;

						array_push($month_array['state'],$state_array);

					}
					array_push($region_array['month'],$month_array);
					
				}
			}

			array_push($fy_year_array['region'],$region_array);
	 	}

    $main_array[] = $fy_year_array;
}


//$jsonData = json_encode($main_array, JSON_PRETTY_PRINT);
//echo $jsonData; 

$final_data = json_encode($main_array);
file_put_contents('../json/dashboard_json_test/dashboard_json_test.json', $final_data);
echo ("Successfull !!");

?>