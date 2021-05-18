<!DOCTYPE html>
<html>
	<head>
		<title>Задание на поверку</title>
		<style>
           p {
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
		      $protocolLink = $work->getProtocolLink();
		      $docLink = $work->getDocumentLink();
		      echo "<h1>Задание на поверку № $currentWorkIndex</h1>";
		      echo "<p>Номер заявки:<i class='pValue'> $currentRequestNumber</i></p>";
		      echo "<p>Номер счета:<i class='pValue'> $currentAccountNumber</i></p>";
		      echo "<p>Поверитель:<i class='pValue'> $currentVerificator</i></p>";
		      echo "<p>Ответственный за закрытие работы:<i class='pValue'> $currentManager</i></p>";
		      echo "<p>Прибор:<i class='pValue'> $currentDevice</i></p>";
		      echo "<p>Место по поверочной схеме:<i class='pValue'> $currentStandartType</i></p>";
		      echo "<form method='POST' enctype='multipart/form-data' action='modifyWork.php'><table>
                        <tr>
                            <th>Температура</th>
                            <th>Давление</th>
                            <th>Влажность</th>
                        </tr>
                        <tr>
                            <td><input type='text' name='t' value='$t'></td>
                            <td><input type='text' name='p' value='$p'></td>
                            <td><input type='text' name='h' value='$h'></td>
                        </tr>
                    </table>";
		      echo "<input name='id' type='hidden' value='$workId'/><br>";
		      echo "<input name='protocol' type='file'/><br>";
		      echo "<input name='document' type='file'/><br>";
		      echo "<input type='submit' value='Сохранить'></form><br>";
		  }
		  else{
		      echo "Работа с данным id не найдена";
		  }
		?>
	</body>
</html>