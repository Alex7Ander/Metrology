<!DOCTYPE html>
<html>
    <head>
        <title>Распределение метрологических работ - Главная</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">       
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
            .digitalField{
                width: 100px;
            }
        </style>
    </head>
    <body>
    	<div class = "container-fluid">
			<div class="row">
    	        <div>
                    <h1>Распределение метрологических работ - Главная</h1>
                </div>
            </div>
            <div class="row">
            	<div class="col-md-3 linksblock">
            		<h3>Приборы: </h3>
            		<a href="/metrology/addDeviceType.php">Добавить тип СИ</a><br>
            		<a href="/metrology/addDevice.php">Добавить СИ (для поверки)</a><br>
            	</div>
            	<div class="col-md-3 linksblock">
            		<h3>Сотрудники: </h3>
            		<a href="/metrology/workersList.php">Список работников</a><br>
            		<a href="/metrology/addWorker.php">Добавить сотрудника</a><br>
            	</div>
            	<div class="col-md-3 linksblock">
            		<h3>Задания: </h3>
                	<a href="/metrology/addWork.php">Добавить работу</a>
                </div>
                <div class="col-md-3">
                </div>
			</div>
            <?php
                require_once 'connection_config.php';
                require_once 'StaffRepository.php';
                require_once 'WorkRepository.php';
                require_once 'Work.php';
                
                $workRepo = new WorkRepository($host, $user, $password, $database);
                $staffRepo = new StaffRepository($host, $user, $password, $database);
                $deviceRepo = new Devicerepository($host, $user, $password, $database);
                                
                $verificators = $staffRepo->getVerificators();
                $managers = $staffRepo->getManagers();
                $devices = $deviceRepo->getAll();
                
                if(isset($_REQUEST['search'])){ 
                    $exampleWork = new Work();
                    $exampleWork->setRequestNumber($_REQUEST['requestNumber']);
                    $exampleWork->setAccountNumber($_REQUEST['accountNumber']);
                    $exampleWork->setWorkIndex($_REQUEST['workIndex']);
                    $exampleWork->setStandartType($_REQUEST['standartType']);
                    $exDevice = $deviceRepo->getById($_REQUEST['deviceId']);
                    $exampleWork->setDevice($exDevice);
                    $exManager = $staffRepo->getWorkerById($_REQUEST['managerId']);
                    $exampleWork->setManager($exManager);
                    $exVarificator = $staffRepo->getWorkerById($_REQUEST['verificatorId']);
                    $exampleWork->setVerificator($exVarificator);
                    $works = $workRepo->getByExample($exampleWork);
                }
                else{
                    $works = $workRepo->getAll();
                }
            ?>
            <div class="row">
            	<div class="col-md-auto">
                	<table>
                        <tr>
                        	<th>Дата поверки</th>
                            <th>Номер работы</th>
                            <th>Номер заявки / счета</th>
                            <th>Поверитель</th>
                            <th>Отв. за закрытие</th>
                            <th>Прибор</th>
                            <th>Место по повер. схеме</th>                        
                            <th>Подробнее</th>
                        </tr>
                        <tr>
                        	<th colspan='8'>Фильтры</th>
                        </tr>
    					<tr>
    						<form method='GET' action='main.php' name='filters'>
    						<td><input type = 'date' name='date' class='noBorder'></td>
                            <td><input type = 'text' name='workIndex' class='digitalField'></td>
                            <td>
                            	<input type = 'text' name='requestNumber' class='digitalField'> / 
                            	<input type = 'text' name='accountNumber' class='digitalField'>
                            </td>
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
                            <td><select name="standartType" class='noBorder'>
                            	<option></option>
                            	<option>Рабочее средство измерения</option>
                            	<option>Эталон 2-го рязряда</option>
                            	<option>Эталон 1-го разряда</option>
                            	<option>Вторичный эталон</option>
                        	</select></td>                        
                            <td><input type='submit' name='search' value='Искать'></td>
                            </form>
                        </tr>                  
                        <tr>
                        	<th colspan='8'>Список работ</th>
                        </tr>                                            
                    	<?php
                        if($works){
                            foreach($works as $work){
                                $currentId = $work->getId();
                                $currentWorkIndex = $work->getWorkIndex();
                                $currentRequestNumber = $work->getRequestNumber();
                                $currentAccountNumber = $work->getAccountNumber();
                                $currentVerificator = $work->getVerificator();
                                $currentManager = $work->getManager();
                                $currentDevice = $work->getDevice();
                                $currentStandartType = $work->getStandartType();                                
                                echo "<tr>";  
                                echo "<td><p>-</p></td>";
                                echo "<td><p>$currentWorkIndex</p></td>";
                                echo "<td>$currentRequestNumber / $currentAccountNumber</td>";
                                echo "<td><p>$currentVerificator</p></td>";
                                echo "<td><p>$currentManager</p></td>";
                                echo "<td><p>$currentDevice</p></td>";
                                echo "<td><p>$currentStandartType</p></td>";                    
                                echo "<td><form method='GET' action='workPage.php'><input type='hidden' name='workId' value='$currentId'><input type='submit' name='$currentId' value='Подробнее'></form></td>";
                                echo "</tr>";
                            }               
                        }
                        ?>
                	</table>
                </div>
        	</div>
        </div>
    </body>
</html>