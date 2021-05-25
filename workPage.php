<!DOCTYPE html>
<html>
	<head>
		<title>Задание на поверку</title>
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous"> 
		<style>
            p{
            color: indigo;
           }
           .pValue{
            color: black;
           }
           .bordered {
                border: 4px double black; /* Параметры границы */
                background: #fc3; /* Цвет фона */
                padding: 10px; /* Поля вокруг текста */
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
		<div class = "container-fluid">
			<div class="row">
				<div class="col-md">
                	<h1>Задание на поверку №<?=$currentWorkIndex?></h1>
                	<br>
                	<a href='main.php'>На главную</a>
            	</div>
            </div>
            <div class="row">
            	<div class="col-md-6">
            		<h3>Основная информация</h3>
            		<div class="bordered">
                		<p>Номер заявки:<i class='pValue'><?=$currentRequestNumber?></i></p>
                        <p>Номер счета:<i class='pValue'><?=$currentAccountNumber?></i></p>
            		    <p>Поверитель:<i class='pValue'><?=$currentVerificator?></i></p>
                        <p>Ответственный за закрытие работы:<i class='pValue'><?=$currentManager?></i></p>
                        <p>Прибор:<i class='pValue'><?=$currentDevice?></i></p>
                        <p>Место по поверочной схеме:<i class='pValue'><?=$currentStandartType?></i></p>
                        <input type='button' value='Редактировать'>
                        <form action='deleteWork.php' method='POST'>
    						<input type='hidden' name='id' value=<?=$workId?>>
    						<input type='submit' value='Удалить работу' name='delete' style={width: 100%;}>
    					</form>
					</div>
            	</div>
            	<div class="col-md-6">
            		<h3>Ход выполнения работы</h3>
            		<form method='POST' action='' enctype='multipart/form-data'>
            		    <!-- Taken -->
            		    <div class=bordered>
            			<input type='hidden' name='processMods[taken]' value='0'>
                		<label><input type='checkbox' name='processMods[taken]' value='1'>Прибор принят в работу</label><br>
                		</div>
                		<!-- Measured -->
                		<div class=bordered>
                		<input type='hidden' name='processMods[measured]' value='0'>
                		<label><input type='checkbox' name='processMods[measured]' value='1' checked>Измерения проведены при следующих характеристиках окружающей среды</label><br>
                		<table> 
                			<tr>
                                <th>Температура</th>
                                <th>Давление</th>
                                <th>Влажность</th>
                            </tr>
                            <tr>
                                <td><input type='text' name='inv[t]' value='<?=$t?>'></td>
                                <td><input type='text' name='inv[p]' value='<?=$p?>'></td>
                                <td><input type='text' name='inv[h]' value='<?=$h?>'></td>
                            </tr>
                    	</table>
                    	</div>
                    	<!-- Protocol -->
                    	<div class=bordered>
                    	<input type='hidden' name='processMods[processed]' value='0'>
                		<label><input type='checkbox' id='protocolCheckbox' name='processMods[processed]' value='1'>Протокол поверки создан</label><br>                		
                		<input name='protocol' id='protocolInput' type='file'/><br>
                		</div>
                		<!-- Metrology closing -->
                		<div class=bordered>
                		<input type='hidden' name='processMods[metrologyClosed]' value='0'>
                		<label><input type='checkbox' name='processMods[metrologyClosed]' value='1'>Работа закрыта в метрологии</label><br>
                		</div>
                		<!-- Doc number -->
                		<div class=bordered>
                		<label><input type='checkbox' name='numberTaken' id='numberTaken' value='1'>Получен номер из системы Аршин</label>
                		<input type='text' name='documentNumber'><br>
                		</div>
                		<!-- Doc printed -->
                		<div class=bordered>
                		<input type='hidden' name='processMods[documentPrinted]' value='0'>
                		<label><input type='checkbox' id='docCheckbox' name='processMods[documentPrinted]' value='1'>Свидетельство / извещение выписано</label><br>                		
                		<input name='document' id='docInput'  type='file'/><br>
                		</div>
                		<!-- Given away -->
                		<div class=bordered>
                		<input type='hidden' name='processMods[givenAway]' value='0'>
                		<label><input type='checkbox' name='processMods[givenAway]' value='1'>Прибор отдан</label><br>
                		</div>
                		<input type='submit' value='Сохранить изменения' name='processModified' style={width: 100%;}>
            		</form>
            	</div>
            </div>         
		</div>
		<?php
		  }else{
		      echo "<p>Работа с данным id = $workId не найдена</p>";
		      echo "<a href='main.php'>На главную</a>";
		  }
		  
		  if(isset($_REQUEST['processModified'])){		      
		      if(isset($_REQUEST['processMods'])){
		          $mods = $_REQUEST['processMods'];
		          $work->setTaken($mods['taken']);
		          $work->setMeasured($mods['measured']);
		          $work->setProcessed($mods['processed']);
		          $work->setDocumentPrinted($mods['documentPrinted']);
		          $work->setMetrologyClosed($mods['metrologyClosed']);
		          $work->setGivenAway($mods['givenAway']);
		      }
		      if(isset($_REQUEST['inv'])){
		          $inv = $_REQUEST['inv'];
		          var_dump($inv);
		          $work->setTemperature($inv['t']);
		          $work->setPreasure($inv['p']);
		          $work->setHumidity($inv['h']);
		          $workRepo->modify($work);
		      }
		      //files uploading
		      $uploadPath = "/home/alex/uploads/";
		      echo "uploadPath = $uploadPath ";
		      //if protocol uploaded
		      if(isset($_FILES['protocol'])){
		          $uploadedProtocolRealName = $_FILES['protocol']['name'];
		          echo "uploadedProtocolRealName = $uploadedProtocolRealName <br>";
		          if (move_uploaded_file($_FILES['protocol']['tmp_name'], $uploadPath . $uploadedProtocolRealName)) {
		              echo "Протокол успешно загружен <br>";
		          }
		      }
		      //if document uploaded
		      if(isset($_FILES['document'])){
		          $uploadedDocumentRealName = $_FILES['document']['name'];
		          echo "uploadedDocumentRealName = $uploadedDocumentRealName <br>";
		          if (move_uploaded_file($_FILES['document']['tmp_name'], $uploadPath . $uploadedDocumentRealName)) {
		              echo "Документ успешно загружен <br>";
		          }
		      }
		  }
		?>
		<script type="text/javascript">
			var protocolInput = document.getElementById('protocolInput');
			var documentInput = document.getElementById('docInput');
			
			protocolInput.onclick = function () {
			    this.value = null;
			    document.getElementById('protocolCheckbox').checked = false;
			};			
			documentInput.onclick = function () {
			    this.value = null;
			    document.getElementById('docCheckbox').checked = false;
			};
			
			protocolInput.onchange = function () {
				document.getElementById('protocolCheckbox').checked = true;
			};
			documentInput.onchange = function () {
				document.getElementById('docCheckbox').checked = true;
			}
		</script>
	</body>
</html>