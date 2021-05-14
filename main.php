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
        <div>
            <h1>Распределение метрологических работ - Главная</h1>
        </div>
        <div>
            <a href="/metrology/add.php">Добавить работу</a><br>
            <a href="/metrology/workersList.php">Список работников</a><br>
            <a href="/metrology/devicesList.php">Приборы (для поверки)</a><br>
            <a href="/metrology/addDevice.php">Добавить прибор (для поверки)</a>
        </div>
        <div>
            <?php
                require_once 'connection_config.php';
                require_once 'workRepository.php';
                require_once 'work.php';
                $workRepo = new WorkRepository($host, $user, $password, $database);
                //print_r($workRepo);
                $works = $workRepo->getAll();
                print_r($works);
                if($works){
            ?>
                <table style="width:100%">
                    <tr>
                        <th>id</th>
                        <th>Поверитель</th>
                        <th>Отв. за закрытие</th>
                        <th>Номер работы</th>
                        <th>Тип прибора</th>
                        <th>зав. №</th>
                        <th>Место по повер. схеме</th>                        
                        <th>Температура</th>
                        <th>Влажность</th>
                        <th>Давление</th>
                        <th>Протокол</th>
                        <th>Свидетельство</th>
                        <th>Подробнее</th>
                    </tr>
            <?php
                foreach($works as $work){
                    echo "<tr>";
                    echo "<td><p>$work->getId()</p></td>";
                    echo "<td><p>$work->getVerificator()</p></td>";
                    echo "<td><input type='button' name='$id'></td>";
                    echo "</tr>";
                }
                echo"</table>";                
                }
            ?>
        </div>
    </body>
</html>