<!DOCTYPE html>
<html>
    <head>
        <title>Распределение метрологических работ - Главная</title>
        <meta charset="utf-8">
    </head>
    <body>
        <div>
            <a href="/metrology/main.php">На главную</a><br>
        </div>
        <div>
        <?php
            require_once "connection_config.php";
            require_once "device.php";
            require_once "deviceRepository.php";

            $deviceRepo = new deviceRepository($host, $user, $password, $database);
            $devices = $deviceRepo->getAll();
            foreach($devices as $key=>$device){
                echo "$key - $device<br>";
            }
        ?>
        </div>
    </body>
</html>