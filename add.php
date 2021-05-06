<!DOCTYPE html>
<html>
    <head>
        <title>Добавить работу</title>
        <meta charset="utf-8">
    </head>
    <body>
        <div>
            <h1>Добавить работу</h1>
        </div>
        <div>
            <a href="/metrology/main.php">На главную</a>
        </div>
        <div>
            <form action="save.php">
                <?php
                    require_once "connection_config.php";
                    $link = mysqli_connect($host, $user, $password, $database) or die("Error: " . mysqli_error($link));
                    mysqli_set_charset($link, 'utf8');
                    $query = "SELECT * FROM staff";
                    $result = mysqli_query($link, $query) or die("Error: " . mysqli_error($link));
                    $verificators = [];
                    $managers = [];
                    foreach($result as $value){
                        $id = $value['id'];
                        $fullname = $value['surname'] . " " . $value['name'] . " " . $value['patronimyc'];
                        if($value['verificator_status']) $verificators[$id] = $fullname;
                        if($value['manager_status']) $managers[$id] = $fullname;
                    }
                ?>

                <table>
                    <tr><td><label for="varification_date">Дата поверки:</label></td><td><input type="date" name="varification_date"></td></tr>
                    <tr><td><label for="device_type">Тип прибора:</label></td><td><input type="text" name="device_type"></td></tr>
                    <tr><td><label for="device_serial_number">Серийный номер:</label></td><td><input type="text" name="device_serial_number"></td></tr>
                    <tr><td><label for="device_etalon_type">Место в поверочной схеме:</label></td><td>
                    <select name="device_etalon_type">
                        <option>Рабочее средство измерения</option>
                        <option>Эталон 2-го рязряда</option>
                        <option>Эталон 1-го разряда</option>
                        <option>Вторичный эталон</option>
                    </select></td></tr>
                    <tr><td><label for="verificatorId">Поверитель:</label></td>
                        <td><select name="verificatorId"><?php 
                                foreach($verificators as $verificatorId => $verificator){
                                    echo "<option value=\"$verificatorId\">$verificator</option>";
                                }
                            ?>
                        </td>
                    </tr>
                    <tr><td><label for="temperature">Температура:</label></td><td><input type="text" name="temperature" ></td></tr>
                    <tr><td><label for="humidity">Влажность:</label></td><td><input type="text" name="humidity"></td></tr>
                    <tr><td><label for="preasure">Атмосферное давление:</label></td><td><input type="text" name="preasure"></td></tr>
                    <tr><td><label for="managerId">Ответственный за закрытие работы:</label></td>
                        <td><select name="managerId"><?php 
                                foreach($managers as $managerId => $manager){
                                    echo "<option value=\"$managerId\">$manager</option>";
                                }
                            ?>
                        </td>
                    </tr>
                </table>
                <input type="submit" value="Отправить данные">
            </form>
        </div>
    </body>
</html>