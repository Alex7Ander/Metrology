<!DOCTYPE html>
<html>
    <head>
        <title>Добавить прибор</title>
        <meta charset="utf-8">
    </head>
    <body>
        <div>
            <h1>Добавить прибор</h1>
        </div>
        <div>
            <a href="/metrology/main.php">На главную</a>
        </div>
        <div>
            <form method="POST" action="addDevice.php">
                <table>
                    <tr><td><label for="device_group">Наименование типа прибора: </label></td><td><input type="text" name="device_group"></td></tr>
                    <tr><td><label for="device_type">Тип прибора: </label></td><td><input type="text" name="device_type"></td></tr>
                    <tr><td><label for="serial_number">Серийный номер: </label></td><td><input type="text" name="serial_number"></td></tr>
                    <tr><td><label for="state_register_number">Номер в ФИФ: </label></td><td><input type="text" name="state_register_number"></td></tr>                   
                </table>
                <input type="submit" name="save" value="Отправить данные">
            </form>
            <?php
            require "device.php";
            require "deviceRepository.php";
            require "connection_config.php";
                if(isset($_REQUEST['save'])){
                    $deviceGroup = $_POST['device_group'];
                    $deviceType = $_POST['device_type'];
                    $serialNumber = $_POST['serial_number'];
                    $stateRegisterNumber = $_POST['state_register_number'];
                    $device = new Device($deviceGroup, $deviceType, $serialNumber, $stateRegisterNumber);
                    $deviceRepo = new deviceRepository($host, $user, $password, $database);
                    $deviceRepo->save($device);
                }
            ?>
        </div>
    </body>
</html>