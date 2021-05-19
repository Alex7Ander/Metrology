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
            require_once "workerRepository.php";
            require_once "connection_config.php";
            $worekerRepo = new workerRepository($host, $user, $password, $database);
            $workers = $worekerRepo->getAll();
            foreach($workers as $key=>$worker){
                echo "$key) " . $worker . "<br>";
            }
        ?>
        </div>
    </body>
</html>
