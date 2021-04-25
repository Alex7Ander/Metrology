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
            <a href="/metrology/add.php">Добавить работу</a>
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
                        <th>Номер работы</th>
                        <th>Тип прибора</th>
                        <th>зав. №</th>
                        <th>Место по повер. схеме</th>
                        <th>Поверитель</th>
                        <th>Отв. за закрытие</th>
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
                    foreach($record as $value){
                        echo "<td>$value</td>";
                    }
                    echo "</tr>";
                }
                echo"</table>";                
                }
            ?>
        </div>
    </body>
</html>