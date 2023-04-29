<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$jsondata = '../json/dashboard_json_test/dashboard_json_test.json';


// function fy_year($sql, $fy)
// {

//     $getyear = mysqli_query($sql, "SELECT * FROM `fy_year`");

//     while ($listyear = mysqli_fetch_object($getyear)) {
//         echo '<option value="' . $listyear->fy_year . '"';
//         if ($listyear->status == 1) {
//             echo ' selected="selected" ';
//         }
//         echo '>' . $listyear->fy_year . '</option>';
//     }

// }

if (file_exists($jsondata)) { 

    $data = file_get_contents($jsondata);
    $json = json_decode($data);

    $fyyear =  $json[0]->fyear;

    /* Sale YTD Graph For financial Year */
    echo "-----------Sale YTD Graph----------".'<br>';

    $eastl =  $json[0]->region[0]->region_name;
    $westl =  $json[0]->region[4]->region_name;
    $southl =  $json[0]->region[3]->region_name;
    $northl =  $json[0]->region[2]->region_name;
    $expl =  $json[0]->region[1]->region_name;
    
    $eastr =  round(($json[0]->region[0]->region_amount)/100000);
    $westr =  round(($json[0]->region[4]->region_amount)/100000);
    $southr =  round(($json[0]->region[3]->region_amount)/100000);
    $northr =  round(($json[0]->region[2]->region_amount)/100000);
    $expr =  round(($json[0]->region[1]->region_amount)/100000);


    $graphlabel = "'".$northl."','".$southl."','".$eastl."','".$westl."'";
    $graphvalue = $northr.', '.$southr.', '. $eastr.', '.$westr;

   $totalytd =  $json[0]->region[0]->region_amount+$json[0]->region[4]->region_amount+$json[0]->region[3]->region_amount+$json[0]->region[2]->region_amount+$json[0]->region[1]->region_amount;

   $english_format_number = round($totalytd/10000000);

    echo $english_format_number.'<br>';
    echo $graphvalue.'<br>';
    echo $graphlabel;

/* Total Sale QTD */
echo '<hr>';
echo "-----------Sale QTD Graph----------".'<br>';
    $totalytd = $json[0]->region[1]->month[6]->month_amount+
                $json[0]->region[1]->month[7]->month_amount+
                $json[0]->region[1]->month[8]->month_amount+
                $json[0]->region[2]->month[6]->month_amount+
                $json[0]->region[2]->month[7]->month_amount+
                $json[0]->region[2]->month[8]->month_amount+
                $json[0]->region[3]->month[6]->month_amount+
                $json[0]->region[3]->month[7]->month_amount+
                $json[0]->region[3]->month[8]->month_amount+
                $json[0]->region[0]->month[6]->month_amount+
                $json[0]->region[0]->month[7]->month_amount+
                $json[0]->region[0]->month[8]->month_amount+
                $json[0]->region[4]->month[6]->month_amount+
                $json[0]->region[4]->month[7]->month_amount+
                $json[0]->region[4]->month[8]->month_amount;

    $english_format_number = round(round($totalytd)/10000000);

    echo $english_format_number.'<br>';

    //3rd quarter data
    $northqtr = round(($json[0]->region[2]->month[6]->month_amount+
                $json[0]->region[2]->month[7]->month_amount+
                $json[0]->region[2]->month[8]->month_amount)/100000);

    $southqtr = round(($json[0]->region[3]->month[6]->month_amount+
                $json[0]->region[3]->month[7]->month_amount+
                $json[0]->region[3]->month[8]->month_amount)/100000);

    $eastqtr = round(($json[0]->region[0]->month[6]->month_amount+
                $json[0]->region[0]->month[7]->month_amount+
                $json[0]->region[0]->month[8]->month_amount)/100000);

    $westqtr = round(($json[0]->region[4]->month[6]->month_amount+
                $json[0]->region[4]->month[7]->month_amount+
                $json[0]->region[4]->month[8]->month_amount)/100000);

    $graphvalue = $northqtr.', '.$southqtr.', '. $eastqtr.', '.$westqtr;
    echo $graphvalue;
} 


/* Target Vs Achived */
echo '<hr>';
echo 'Only product titles fetched from sql... rest all data is statically coded under sales-dashboard-js.php :- myBarChart4';

$region_array = array('East','West');
echo '<br>'.array_search('East',$region_array,true); 

?>

