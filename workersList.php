<!DOCTYPE html>
<html>
    <head>
        <title>Распределение метрологических работ - Главная</title>
        <meta charset="utf-8">
        <style>
            table, th, td {
                border: 1px solid black;
            }
        </style>
    </head>
    <body>
        <?php
            require_once "workerRepository.php";
            require_once "connection_config.php";
            $worekerRepo = new workerRepository($host, $user, $password, $database);
            $workers = $worekerRepo->getAll();
            foreach($workers as $key=>$worker){
                echo "$key) " . $worker . "<br>";
            }
        ?>
    </body>
</html>
