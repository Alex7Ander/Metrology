<?php
    $count = 0;
    if(isset($_COOKIE['count'])) $count = $_COOKIE['count'];
    $count++;
    setcookie("count", $count, 0x7FFFFFFF, "/");
    echo "count = $count";
/*
    $device_type = $_REQUEST['device_type']; 
    $device_serial_number = $_REQUEST['device_serial_number'];
    $device_etalon_type = $_REQUEST['device_etalon_type'];
    $verificator = $_REQUEST['verificator'];
    $temperature = $_REQUEST['temperature'];
    $humidity = $_REQUEST['humidity'];
    $preasure = $_REQUEST['preasure'];

    if($temperature == '') $temperature = 21;
    if($humidity == '') $humidity = 51;
    if($preasure == '') $preasure = 745;
    require_once "connection_config.php";
    $link = mysqli_connect($host, $user, $password, $database) or die("Error: " . mysqli_error($link));
    $query = "INSERT INTO works (device_type, device_serial_number, device_etalon_type, verificator, temperature, humidity, preasure) 
                VALUES ('$device_type','$device_serial_number','$device_etalon_type', '$verificator', '$temperature', '$humidity', '$preasure')";
    echo "$query";
    $result = mysqli_query($link, $query) or die("Error: " . mysqli_error($link));
    mysqli_close($link);
    echo "Data Saved!!!<br><a href='/metrology/main.php'>На главную</a>";
*/
?>