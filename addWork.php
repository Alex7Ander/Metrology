<!DOCTYPE html>
<html>
    <head>
        <title>Добавить работу</title>
        <meta charset="utf-8">
    </head>
    <body>
        <?php                   
        require_once "StaffRepository.php";
        require_once "DeviceRepository.php";
        require_once "DeviceTypeRepository.php";
        require_once "WorkRepository.php";
        require_once "Work.php";
        require_once 'Uploader.php';
        require_once "connection_config.php";
        
        $staffRepo = new StaffRepository($host, $user, $password, $database);
        $deviceRepo = new DeviceRepository($host, $user, $password, $database);
        $workRepo = new WorkRepository($host, $user, $password, $database);
        $typesRepo = new DeviceTypeRepository($host, $user, $password, $database);
                            
        $verificators = $staffRepo->getVerificators();
        $managers = $staffRepo->getManagers();
        $types = $typesRepo->getAll();                                  
        
        if(isset($_REQUEST['save'])){  
            $type = $types[$_REQUEST['type_id']];
            $serialNumber = $_REQUEST['device_serial_number'];                        
            $device = $deviceRepo->getByTypeAndSerialNumber($type, $serialNumber);
            if($device == null){
                $device = new Device($type, $serialNumber);
                $deviceRepo->save($device);
            }

            $verificatorId = $_REQUEST['verificator_id'];
            $verificator = $verificators["$verificatorId"];
            $managerId = $_REQUEST['manager_id'];
            $manager = $managers["$managerId"];
            
            $work = new Work();                     
            $work->setDevice($device);
            $work->setVerificator($verificator);
            $work->setManager($manager);                        
            $work->setRequestNumber($_REQUEST['request_number']);
            $work->setAccountNumber($_REQUEST['account_number']);
            $work->setVerificationDate($_REQUEST['verification_date']);
            $work->setStandartType($_REQUEST['standart_type']);
            $work->setTemperature($_REQUEST['temperature']);
            $work->setHumidity($_REQUEST['humidity']);
            $work->setPreasure($_REQUEST['preasure']);
            
            if(isset($_FILES['protocol'])){
                $uploadedLink = removeUploadedFile('protocol', $recordUploadPath);
                $work->setProtocolLink($uploadedLink);
                $work->setTaken(true);
                $work->setMeasured(true);
                $work->setProcessed(true);
            }
            if(isset($_FILES['document'])){
                $uploadedLink = removeUploadedFile('document', $recordUploadPath);
                $work->setDocumentLink($uploadedLink);
            }                       
            $workRepo->save($work);
        }
        ?>
        <div>
            <h1>Добавить работу</h1>
        </div>
        <div>
            <a href="/metrology/main.php">На главную</a>
        </div>
        <div>
            <form action="addWork.php" method="POST" enctype='multipart/form-data'>
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
                            <label>Тип поверяемого СИ:</label>
                        </td>
                        <td><select name="type_id"><?php                            
                            foreach($types as $id => $type){
                                echo "<option value=\"$id\">$type</option>";
                            }
                            ?>
                            </select>
                        </td>
                    </tr>
                    <tr><td><label for="device_serial_number">Серийный номер:</label></td><td><input type="text" name="device_serial_number"></td></tr>
                    <tr><td><label for="standart_type">Место в поверочной схеме:</label></td><td>
                    <select name="standart_type">
                        <option>Рабочее средство измерения</option>
                        <option>Эталон 2-го рязряда</option>
                        <option>Эталон 1-го разряда</option>
                        <option>Вторичный эталон</option>
                    </select></td></tr>

                    <tr colspan = 2><td>Заполняется в слычае если поверка уже проведена</td></tr>
                    <tr><td><label for="temperature">Температура:</label></td><td><input type="text" name="temperature" ></td></tr>
                    <tr><td><label for="humidity">Влажность:</label></td><td><input type="text" name="humidity"></td></tr>
                    <tr><td><label for="preasure">Атмосферное давление:</label></td><td><input type="text" name="preasure"></td></tr>                   
                    <tr><td>Протокол поверки: </td><td><input name='protocol' id='protocolInput' type='file'/></td></tr>
                    <tr><td>Свидетельство (извещение): </td><td><input name='document' id='docInput' type='file'/></td></tr>
                    <tr colspan = 2><td>Исполнители</td></tr>
                    <tr>
                    	<td>
                    		<label for="verificator_id">Поверитель:</label>
                    	</td>
                        <td><select name="verificator_id"><?php 
                                foreach($verificators as $verificatorId => $verificator){
                                    echo "<option value=\"$verificatorId\">$verificator</option>";
                                }
                            ?>
                            </select>
                        </td>
                    </tr>
                    <tr><td><label for="manager_id">Ответственный за закрытие работы:</label></td>
                        <td><select name="manager_id"><?php 
                                foreach($managers as $managerId => $manager){
                                    echo "<option value=\"$managerId\">$manager</option>";
                                }
                            ?>
                            </select>
                        </td>
                    </tr>
                </table>
                <input type="submit" name="save" value="Отправить данные">
            </form>
        </div>
    </body>
</html>