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
            <a href="/metrology/devices.php">Приборы (для поверки)</a><br>
            <a href="/metrology/addDevice.php">Добавить прибор (для поверки)</a>
        </div>
        <div>
            <?php
                require_once "connection_config.php";
                $link = mysqli_connect($host, $user, $password, $database) or die("Error: " . mysqli_error($link));
                $query = "SELECT * FROM works";
                $result = mysqli_query($link, $query) or die("Error: " . mysqli_error($link));
                if($result){
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
                foreach($result as $record){
                    echo "<tr>";
                    $id = $record['id'];
                    $protLink = $record['protocolLink'];
                    $docLink = $record['documentLink'];
                    foreach($record as $key=>$value){
                        if($key == 'protocolLink') break;
                        echo "<td>$value</td>";
                    }
                    if($protLink != ""){
                        echo "<td style=\"text-align: center;\"><a href='$protLink'>Протокол</a></td>";
                    }
                    else{
                        echo "<td style=\"text-align: center;\">-</td>";
                    }
                    if($docLink != ""){
                        echo "<td style=\"text-align: center;\"><a href='$docLink'>Документ</a></td>";
                    }
                    else{
                        echo "<td style=\"text-align: center;\">-</td>";
                    }
                    echo "<td><input type='button' name='$id'></td>";
                    echo "</tr>";
                }
                echo"</table>";                
                }
            ?>
        </div>
    </body>
</html>