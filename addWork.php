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
            <form action="addWork.php" method="POST">
                <?php                   
                    require_once "StaffRepository.php";
                    require_once "DeviceRepository.php";
                    require_once "WorkRepository.php";
                    require_once "Work.php";
                    require_once "connection_config.php";
                    $staffRepo = new StaffRepository($host, $user, $password, $database);
                    $deviceRepo = new Devicerepository($host, $user, $password, $database);
                    $workRepo = new WorkRepository($host, $user, $password, $database);
                    $verificators = $staffRepo->getVerificators();
                    $managers = $staffRepo->getManagers();
                    $devices = $deviceRepo->getAll();
                    if(isset($_REQUEST['save'])){
                        $requestNumber = $_REQUEST['request_number'];
                        $accountNumber = $_REQUEST['account_number'];                         
                        $deviceId= $_REQUEST['device_id'];
                        $device = $devices["$deviceId"];
                        
                        $verificatorId = $_REQUEST['verificator_id'];
                        $verificator = $verificators["$verificatorId"];
                        $managerId = $_REQUEST['manager_id'];
                        $manager = $managers["$managerId"];

                        $verificationDate = $_REQUEST['verification_date'];
                        $deviceEtalonType = $_REQUEST['device_etalon_type'];
                        $temperature = $_REQUEST['temperature'];
                        $humidity = $_REQUEST['humidity'];
                        $preasure = $_REQUEST['preasure'];

                        $work = new Work();
                        $work->setDevice($device);
                        $work->setRequestNumber($requestNumber);
                        $work->setAccountNumber($accountNumber);
                        $work->setVerificator($verificator);
                        $work->setManager($manager);
                        $work->setVerificationDate($verificationDate);
                        $work->setEtalonType($deviceEtalonType);
                        $work->setTemperature($temperature);
                        $work->setHumidity($humidity);
                        $work->setPreasure($preasure);
                        $work->setDocumentLink(null);
                        $work->setprotocolLink(null);
                        
                        $workRepo->save($work);
                    }
                ?>

                <table>
                    <tr>
                        <td>
                            <label for="verification_date">Дата поверки:</label>
                        </td>
                        <td>
                            <input type="date" name="verification_date">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="request_number">Номер заявки:</label>
                        </td>
                        <td>
                            <input type="text" name="request_number">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="account_number">Номер счета:</label>
                        </td>
                        <td>
                            <input type="text" name="account_number">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="device_type">Прибор:</label>
                        </td>
                        <td><select name="device_id"><?php 
                                foreach($devices as $deviceId => $device){
                                    echo "<option value=\"$deviceId\">$device</option>";
                                }
                            ?>
                        </td>
                    </tr>
                    <tr><td><label for="device_serial_number">Серийный номер:</label></td><td><input type="text" name="device_serial_number"></td></tr>
                    <tr><td><label for="device_etalon_type">Место в поверочной схеме:</label></td><td>
                    <select name="device_etalon_type">
                        <option>Рабочее средство измерения</option>
                        <option>Эталон 2-го рязряда</option>
                        <option>Эталон 1-го разряда</option>
                        <option>Вторичный эталон</option>
                    </select></td></tr>
                    <tr>
                    	<td>
                    		<label for="verificator_id">Поверитель:</label>
                    	</td>
                        <td><select name="verificator_id"><?php 
                                foreach($verificators as $verificatorId => $verificator){
                                    echo "<option value=\"$verificatorId\">$verificator</option>";
                                }
                            ?>
                        </td>
                    </tr>
                    <tr><td><label for="temperature">Температура:</label></td><td><input type="text" name="temperature" ></td></tr>
                    <tr><td><label for="humidity">Влажность:</label></td><td><input type="text" name="humidity"></td></tr>
                    <tr><td><label for="preasure">Атмосферное давление:</label></td><td><input type="text" name="preasure"></td></tr>
                    <tr><td><label for="manager_id">Ответственный за закрытие работы:</label></td>
                        <td><select name="manager_id"><?php 
                                foreach($managers as $managerId => $manager){
                                    echo "<option value=\"$managerId\">$manager</option>";
                                }
                            ?>
                        </td>
                    </tr>
                </table>
                <input type="submit" name="save" value="Отправить данные">
            </form>
        </div>
    </body>
</html>