<!DOCTYPE html>
<html>
    <head>
        <title>Распределение метрологических работ - Главная</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
	</head>
	<body>
		<div class = "container-fluid">
			<div class="row">
    	        <div>
                    <h1>Добавление нового типа средства измерения</h1>
                    <a href='/metrology/main.php'>На главную</a>
                </div>
            </div>
            <div class="row">
            	<div class="col-md3">
            		<form action='addDeviceType.php'>
            			<label for="name">Наименование типа:</label>
            			<input type="text" name="name"><br>
            			<label for="designation">Обозначение типа:</label>
            			<input type="text" name="designation"><br>
            			<label for="stateNumber">Номер в гос. реестре:</label>
            			<input type="text" name="stateNumber"><br>
            			<input type="submit" name="add" value="Добавить новый тип">
            		</form>	
            	</div>
            </div>
		</div>
		<?php 
		    require_once 'connection_config.php';
		    require_once 'DeviceType.php';
		    require_once 'DeviceTypeRepository.php';
    		if(isset($_REQUEST['add'])){
    		    $name = $_REQUEST['name'];
    		    $designation = $_REQUEST['designation'];
    		    $stateNumber = $_REQUEST['stateNumber'];    		    
    		    $newType = new DeviceType();   		    
    		    $newType->setName($name);
    		    $newType->setDesignation($designation);
    		    $newType->setStateNumber($stateNumber);    		    
    		    $deviceTypeRepo = new DeviceTypeRepository($host, $user, $password, $database);
    		    try{
    		        $deviceTypeRepo->save($newType);
    		        echo "Тип средства измерения $newType успешно сохранен";
    		    }
    		    catch(Exception $exception){
    		        echo "В процессе сохранения нового типа средства измерения произошла ошибка: " . $exception->getMessage();
    		    }
    		}
		?>
	</body>
</html>
