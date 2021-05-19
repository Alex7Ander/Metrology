<?php
    require_once "connection_config.php";

    $link = mysqli_connect($host, $user, $password, $database) or die("Error: " . mysqli_error($link));

    $query = "SELECT * FROM Metrology";

    $result = mysqli_query($link, $query) or die("Error: " . mysqli_error($link));
    if($result){
        echo "Query result is:<br>";
        foreach($result as $record){
            foreach($record as $fiels => $value){
                echo "$field - $value";
            }
        }
    }
?>