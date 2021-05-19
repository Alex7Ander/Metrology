<!DOCTYPE html>
<html>
	<head>
		<title>Задание на поверку</title>
		<style>
            p{
            color: indigo;
           }
           .pValue{
            color: black;
           }
        </style>
	</head>
	<body>
		<?php
		  require_once 'connection_config.php';
		  require_once 'work.php';
		  require_once 'workRepository.php';
		  $workId = $_REQUEST["workId"];
		  $workRepo = new WorkRepository($host, $user, $password, $database);
		  $work = $workRepo->getById($workId);
		  if($work){
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
		?>
		<div>
            <h1>Задание на поверку №<?=$currentWorkIndex?></h1>
            <p>Номер заявки:<i class='pValue'><?=$currentRequestNumber?></i></p>
            <p>Номер счета:<i class='pValue'><?=$currentAccountNumber?></i></p>
		    <p>Поверитель:<i class='pValue'><?=$currentVerificator?></i></p>
            <p>Ответственный за закрытие работы:<i class='pValue'><?=$currentManager?></i></p>
            <p>Прибор:<i class='pValue'><?=$currentDevice?></i></p>
            <p>Место по поверочной схеме:<i class='pValue'><?=$currentStandartType?></i></p>
            <form method='POST' enctype='multipart/form-data' action='modifyWork.php'><table>
                    <tr>
                        <th>Температура</th>
                        <th>Давление</th>
                        <th>Влажность</th>
                    </tr>
                    <tr>
                        <td><input type='text' name='t' value='<?=$t?>'></td>
                        <td><input type='text' name='p' value='<?=$p?>'></td>
                        <td><input type='text' name='h' value='<?=$h?>'></td>
                    </tr>
                </table>
            <input name='id' type='hidden' value='<?=$workId?>'/><br>
            <input name='protocol' type='file'/><br>
            <input name='document' type='file'/><br>
            <input type='submit' value='Сохранить'></form><br>
		</div>
		<div>
			<form action='deleteWork.php' method='POST'>
				<input type='hidden' name='id' value=<?=$workId?>>
				<input type='submit' value='Удалить работу' name='delete'>
			</form>
		</div>
		<?php
		  }else{
		      echo "<p>Работа с данным id = $workId не найдена</p>";
		      echo "<a href='main.php'>На главную</a>";
		  }
		?>
	</body>
</html>