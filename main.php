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
                require 'connection_config.php';
                require 'workRepository.php';
                require 'work.php';
                $workRepo = new WorkRepository($host, $user, $password, $database);
                $works = $workRepo->getAll();
                if($works){
            ?>
                <table style="width:100%">
                    <tr>
                        <th>Номер работы</th>
                        <th>Номер заявки</th>
                        <th>Номер счета</th>
                        <th>Поверитель</th>
                        <th>Отв. за закрытие</th>
                        <th>Прибор</th>
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
                    $currentId = $work->getId();
                    $currentWorkIndex = $work->getWorkIndex();
                    $currentRequestNumber = $work->getRequestNumber();
                    $currentAccountNumber = $work->getAccountNumber();
                    $currentVerificator = $work->getVerificator();
                    $currentManager = $work->getManager();
                    $currentDevice = $work->getDevice();
                    $currentStandartType = $work->getEtalonType();
                    $t = $work->getTemperature();
                    $h = $work->getHumidity();
                    $p = $work->getPreasure();
                    $protocolLink = $work->getProtocolLink();
                    $docLink = $work->getDocumentLink();
                    
                    echo "<tr>";  
                    echo "<td><p>$currentWorkIndex</p></td>";
                    echo "<td><p>$currentRequestNumber</p></td>";
                    echo "<td><p>$currentAccountNumber</p></td>";
                    echo "<td><p>$currentVerificator</p></td>";
                    echo "<td><p>$currentManager</p></td>";
                    echo "<td><p>$currentDevice</p></td>";
                    echo "<td><p>$currentStandartType</p></td>";                    
                    echo "<td><p>$t</p></td>";
                    echo "<td><p>$h</p></td>";
                    echo "<td><p>$p</p></td>";
                    if($protocolLink){
                        echo "<td><a href=$protocolLink>Протокол</a></td>";
                    } 
                    else {
                        echo "<td><p>-</p></td>";
                    }
                    if($docLink){
                        echo "<td><a href=$docLink>Документ</a></td>";
                    }
                    else{
                        echo "<td><p>-</p></td>";
                    }
                    echo "<td><form method='GET' action='workPage.php'><input type='hidden' name='workId' value='$currentId'><input type='submit' name='$currentId' value='Подробнее'></form></td>";
                    echo "</tr>";
                }
                echo"</table>";                
                }
            ?>
        </div>
    </body>
</html>