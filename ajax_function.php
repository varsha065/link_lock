<?php
include('config.php');

if(isset($_POST['getcity'])) {

    $zoneid = $_POST['getcity'];
    
     $query = mysqli_query($conn, "SELECT * FROM `awt_city` where zone = '$zoneid' and deleted != 1 ");

     echo '<option value="">Select City</option>';

    while($listdata = mysqli_fetch_object($query)) {

        echo '<option value="'.$listdata->id.'">'.$listdata->city.'</option>';

    }

}

if(isset($_POST['getspare'])) {

    $machineid = $_POST['getspare'];
    
     $query = mysqli_query($conn, "SELECT * FROM `awt_spareparts` where machine = '$machineid' and deleted != 1 ");

     echo '<option value="">Select Spare</option>';

    while($listdata = mysqli_fetch_object($query)) {

        echo '<option value="'.$listdata->id.'">'.$listdata->spare_name.'</option>';

    }

}

if(isset($_POST['getsuper'])) {

    $cityid = $_POST['getsuper'];
    
     $query = mysqli_query($conn, "SELECT * FROM `awt_user` where city = '$cityid' and deleted != 1 ");

     echo '<option value="">Select Supervisor</option>';

    while($listdata = mysqli_fetch_object($query)) {

        echo '<option value="'.$listdata->id.'">'.$listdata->name.'</option>';

    }

}

// User already exist

if(isset($_POST['checkuser'])) {

    $user_name=$_POST['checkuser'];
    $eid=$_POST['eid'];

    if($eid == ''){
        $query=mysqli_query($conn,"SELECT `id` from `awt_user` WHERE `user_name` = '$user_name'");
        $num=mysqli_num_rows($query);
    }else{
        $query=mysqli_query($conn,"SELECT `id` from `awt_user` WHERE `user_name` = '$user_name' and `id` != '$eid'");
        $num=mysqli_num_rows($query);
    }
    
    echo $num;
    
}

// status Ajax ----------

if(isset($_POST['statusid'])) 
{
    $statusid= $_POST['statusid'];
    $query= mysqli_query($conn,"SELECT * FROM `awt_user` WHERE `id`='$statusid'");
    
    $num=mysqli_num_rows($query);
    if($num == 1)
    {
        $row=mysqli_fetch_object($query);
        $status=$row->status;
        $id=$row->id;
        if($status == 1)
        {
            $chkwish = mysqli_query($conn,"UPDATE `awt_user` SET `status`= 0 WHERE `id`='$id'");
        } else {
            $chkwish = mysqli_query($conn,"UPDATE `awt_user` SET `status`= 1 WHERE `id`='$id'");
        }
    }
}


?>