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
            require_once "StaffRepository.php";            
            $staffRepo = new StaffRepository($host, $user, $password, $database);
            $workers = $staffRepo->getAll();
            foreach($workers as $key=>$worker){
                echo "$key) " . $worker . "<br>";
            }
        ?>
        </div>
    </body>
</html>
