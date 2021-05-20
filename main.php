<!DOCTYPE html>
<html>
    <head>
        <title>Распределение метрологических работ - Главная</title>
        <meta charset="utf-8">
        <style>

            table, td, th{
                border: 1px solid black;
            }
            .noBorder{
                border: none;
            }
            .linksblock{
                float:left;
                background: #ccc;
                width: 29%;
                margin: 1%;
                padding: 1%;
            }
            .links:after{
                content:"";
                display: block;
                clear: both;
            }
            .content{
                padding: 100 px;                
                clear: left;
                margin-top: 100 px;
            }
        </style>
    </head>
    <body>
        <div>
            <h1>Распределение метрологических работ - Главная</h1>
        </div>
        <div class="links">
        	<div class="linksblock">
        		<h3>Приборы: </h3>
        		<a href="/metrology/devicesList.php">Приборы (для поверки)</a>
        		<a href="/metrology/addDevice.php">Добавить прибор (для поверки)</a>
        	</div>
        	<div class="linksblock">
        		<h3>Сотрудники: </h3>
        		<a href="/metrology/workersList.php">Список работников</a>
        		<a href="/metrology/addWorker.php">Добавить сотрудника</a>
        	</div>
        	<div class="linksblock">
        		<h3>Задания: </h3>
            	<a href="/metrology/addWork.php">Добавить работу</a>
            </div>
        </div>
        <div class="content">
            <?php
                require 'connection_config.php';
                require 'workRepository.php';
                require 'work.php';
                $workRepo = new WorkRepository($host, $user, $password, $database);
                $workerRepo = new WorkerRepository($host, $user, $password, $database);
                $deviceRepo = new Devicerepository($host, $user, $password, $database);
                                
                $verificators = $workerRepo->getVerificators();
                $managers = $workerRepo->getManagers();
                $devices = $deviceRepo->getAll();
                
                if(isset($_REQUEST['search'])){ 
                    $exampleWork = new Work();
                    $exampleWork->setRequestNumber($_REQUEST['requestNumber']);
                    $exampleWork->setAccountNumber($_REQUEST['accountNumber']);
                    $exampleWork->setWorkIndex($_REQUEST['workIndex']);
                    $exampleWork->setEtalonType($_REQUEST['etalonType']);
                    $exDevice = $deviceRepo->getById($_REQUEST['deviceId']);
                    $exampleWork->setDevice($exDevice);
                    $exManager = $workerRepo->getWorkerById($_REQUEST['managerId']);
                    $exampleWork->setManager($exManager);
                    $exVarificator = $workerRepo->getWorkerById($_REQUEST['verificatorId']);
                    $exampleWork->setVerificator($exVarificator);
                    $works = $workRepo->getByExample($exampleWork);
                }
                else{
                    $works = $workRepo->getAll();
                }
                
                if($works){
            ?>
                <table style="width:100%">
                    <tr>
                    	<th>Дата поверки</th>
                        <th>Номер работы</th>
                        <th>Номер заявки</th>
                        <th>Номер счета</th>
                        <th>Поверитель</th>
                        <th>Отв. за закрытие</th>
                        <th>Прибор</th>
                        <th>Место по повер. схеме</th>                        
                        <th>Параметры среды</th>
                        <th>Подробнее</th>
                    </tr>
                    <tr>
                    	<th colspan='10'>Фильтры</th>
                    </tr>
					<tr>
						<form method='GET' action='main.php' name='filters'>
						<td><input type = 'date' name='date' class='noBorder'></td>
                        <td><input type = 'text' name='workIndex' class='noBorder'></td>
                        <td><input type = 'text' name='requestNumber' class='noBorder'></td>
                        <td><input type = 'text' name='accountNumber' class='noBorder'></td>
                        <td><select name="verificatorId" class='noBorder'>
                        <?php 
                            echo "<option value=''></option>";
                            foreach ($verificators as $verificator){
                                $currentVerificatorId = $verificator->getId();
                                echo "<option value='$currentVerificatorId'>$verificator</option>";
                            }
                        ?></select></td>
                        <td><select name="managerId" class='noBorder'>
                        <?php 
                            echo "<option value=''></option>";
                            foreach ($managers as $manager){
                                $currentManagerId = $manager->getId();
                                echo "<option value='$currentManagerId'>$manager</option>";
                            }
                        ?></select></td>
                        <td><select name="deviceId" class='noBorder'>
                        <?php 
                            echo "<option value=''></option>";
                            foreach ($devices as $device){
                                $currentDeviceId = $device->getId();
                                echo "<option value='$currentDeviceId'>$device</option>";
                            }
                        ?></select></td>
                        <td><select name="etalonType" class='noBorder'>
                        	<option></option>
                        	<option>Рабочее средство измерения</option>
                        	<option>Эталон 2-го рязряда</option>
                        	<option>Эталон 1-го разряда</option>
                        	<option>Вторичный эталон</option>
                    	</select></td>                        
                        <td>-</td>
                        <td><input type='submit' name='search' value='Искать'></td>
                        </form>
                    </tr>                  
                    <tr>
                    	<th colspan='10'>Список работ</th>
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
                    
                    echo "<tr>";  
                    echo "<td><p>-</p></td>";
                    echo "<td><p>$currentWorkIndex</p></td>";
                    echo "<td><p>$currentRequestNumber</p></td>";
                    echo "<td><p>$currentAccountNumber</p></td>";
                    echo "<td><p>$currentVerificator</p></td>";
                    echo "<td><p>$currentManager</p></td>";
                    echo "<td><p>$currentDevice</p></td>";
                    echo "<td><p>$currentStandartType</p></td>";                    
                    echo "<td>t = $t С;<br>p = $p мм рт ст;<br>h = $h %</td>";
                    echo "<td><form method='GET' action='workPage.php'><input type='hidden' name='workId' value='$currentId'><input type='submit' name='$currentId' value='Подробнее'></form></td>";
                    echo "</tr>";
                }
                echo"</table>";                
                }
            ?>
        </div>
    </body>
</html>