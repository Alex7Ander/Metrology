<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Сообщество 113</title>
		<meta name="description" content="">
		<meta name="keywords" content="">
		<link rel="stylesheet" type="text/css" href="style.css" media="all">
	</head>
	<body>
		<div class="wrapper">
			<div class="header">
				<div class="headerContent">
					<div class="left"><h1><a href="#">Lab 113 COMMUNITY</a></h1><p>Приватная зона лаборатории 113</p></div>
					<div class="right">
						<a href='logout.php'>Выход</a>
					</div>
				</div>
			</div>
			<div class="slider">
				<div class="itemSlider">
					<div class="bgSlide"><img src="images/bg-slide-2.jpg"></div>
					<div class="descSlide">
						<h1>Лаборатория 113</h1>
						<p></p>
						<span>это как 111 только 3 вместо 1 на конце</span>
						<span>Здравствуйте, <?=$username?></span>
					</div>
				</div>
			</div>
			<div class="nav">
				<ul class="menu">
					<li><a href="index.php">На главную</a></li>
					<li><a href="types.php">Типы СИ</a></li>
					<li><a href="devices.php">Зарегистрированные СИ</a></li>
					<li><a href="staff.php">Сотрудники</a></li>
					<li><a href="addWork.php">Добавить работу</a></li>
				</ul>
			</div>
			<div class="main">
				<div class="leftCol">
					<h1>Информация о СИ</h1>
					<p>Тип: <i><?=$currentDevice->getDeviceType()?></i></p>
					<p>№  <i><?=$currentDevice->getSerialNumber()?></i></p>
                    <p>Год производства: <i><?=$currentDevice->getProdYear()?></i></p>
                    <?php if($_SESSION['accessLevel'] == 10){?>	                        
					<button class="minWidth" value="Редактировать" onclick="showPopUp('popUpEditMainInfo')">Редактировать</button>
					<button class="minWidth" value="Удалить" onclick="showPopUp('popUp')">Удалить</button>	
					<?php }?>					
				</div>

				<div class="rightCol">
					<h1>Поверочные/калибровочные работы СИ</h1>
					<table> 
						<thead>
    						<tr>
                                <th>Дата</th>
                                <th>Заявка/Счет</th>
                                <th>Поверитель</th>
                                <th>Ответственный за закрытие</th>
                                <th>Результат поверки</th>
                                <th>Подробнее</th>
    						</tr>
						</thead>
						<tbody>
							<?php 
							foreach ($works as $work){
							?>
							<tr>
								<td><?= $work->getVerificationDate()?></td>
								<td><?= $work->getRequestNumber()?> / <?= $work->getAccountNumber()?></td>
								<td><?= $work->getVerificator()?></td>
								<td><?= $work->getManager()?></td>
								<td>-</td>
								<td><input type="button" value="Подробнее" class="simpleSubmit" onclick="document.location='work.php?workId=<?=$work->getId()?>'"></td>
							</tr>
							<?php }
							?>
						</tbody>
					</table>
				</div>
			</div>
			<div class="footer">
				<div class="footerContent">

				</div>
			</div>
		</div>
		
		<div class="popup" id="popUp">
			<div class="popup-content">
				<h1 class="simpleBlackText">Вы уверены, что хотите удалить СИ?</h1>
				<p id="typeInfo"></p>
				<form action="work.php" method="POST">
              		<input type="hidden" id="delIdInput" name="deviceId" value="<?=$currentDevice->getId()?>">
              		<input type="submit" class="simpleSubmit" name="del" value="Удалить">
              	</form>
				<input type="button" class="simpleSubmit" value="Отмена" onclick='hidePopUp("popUp");'>
			</div>
		</div>
		
		<div class="popup" id="popUpEditMainInfo">
			<div class="popup-content">
				<h1 class="simpleBlackText">Редактирование информации о СИ</h1>
				<form action="work.php" method="POST" class="questionnaire">
					<label class="questionnaire-row">
						<input type="hidden" id="modIdInput" name="deviceId" value="<?=$currentDevice->getId()?>">
						<span class="questionnaire-cell">Тип СИ:</span>
						<span class="questionnaire-cell">
		              		 <select name="typeId">
                      			<?php 
                      			foreach($types as $id => $type){
                      			    if($currentDevice->getDeviceType()->getId() == $id){
                      			        echo "<option value=$id selected>$type</option>";
                      			    }
                      			    else{
                      			        echo "<option value=$id>$type</option>";
                      			    }
                      			}
                      			?>
                      		</select>
						</span>
					</label>
					<label class="questionnaire-row">
						<span class="questionnaire-cell">Серийный номер:</span>
						<span class="questionnaire-cell"><input type="text" name="serialNumber" value="<?=$currentDevice->getSerialNumber()?>"></span>
					</label>
					<label class="questionnaire-row">
						<span class="questionnaire-cell">Год производства:</span>
						<span class="questionnaire-cell"><input type="text" name="prodYear" value="<?=$currentDevice->getProdYear()?>"></span>
					</label>
              		<input type="submit" class="simpleSubmit" name="editMainInfo" value="Редактировать">
              	</form>
				<input type="button" class="simpleSubmit" value="Отмена" onclick='hidePopUp("popUpEditMainInfo");'>
			</div>
		</div>
		<script src="./templates/static/js/scripts.js"></script>
	</body>
</html>