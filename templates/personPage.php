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
						<?php 
						if(isset($errorMsg)){
						    echo "<span>$errorMsg</span>";
						}
						?>
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
					<h1>Основная информация</h1>
					<p>Фамилия: <i><?=$currentStaffPerson->getSurname()?></i></p>
					<p>Имя: <i><?=$currentStaffPerson->getName()?></i></p>
                    <p>Отчество: <i><?=$currentStaffPerson->getPatronimyc()?></i></p>
                    <?php if($_SESSION['userId'] == $currentStaffPerson->getId() || $_SESSION['accessLevel'] == 10){?>	                        
					<button class="minWidth" onclick="showPopUp('popUpEditMainInfo')">Редактировать</button>	
					<?php }?>					
				</div>

				<div class="rightCol">
					<?php 
					if($currentStaffPerson->getVerificatorStatus()){
					?>
					<h1>Пользователь задействован в качестве поверителя в: </h1>
					<table>
						<thead>
							<tr>
								<th>#</th>
								<th>Дата поверки</th>
								<th>Прибор</th>
								<th>Номер заявки / счета</th>                        
								<th>Подробнее</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							$index = 1;
							foreach($verifications as $verification){
							?>
    						<tr>
    						    <td><?= $index?></td>
    						    <td><?= $verification->getVerificationDate()?></td>
    						    <td><?= $verification->getDevice()?></td>
    						    <td><?= $verification->getRequestNumber()?> / <?= $verification->getAccountNumber()?></td>
    						    <td><input type="button" value="Подробнее" class="simpleSubmit" onclick="document.location='work.php?workId=<?=$verification->getId()?>'"></td>
    						</tr>
							<?php 
							$index++;
							}
							?>
						</tbody>
					</table>
					<?php 
					}
					if($currentStaffPerson->getManagerStatus()){
					?>
					<h1>Пользователь ответственен за закрытие следующих работ: </h1>
					<table>
						<thead>
							<tr>
								<th>#</th>
								<th>Дата поверки</th>
								<th>Прибор</th>
								<th>Номер заявки / счета</th>                        
								<th>Подробнее</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							$index = 1;
							foreach($managing as $managedWork){
							?>
							<tr>
							    <td><?= $index?></td>
							    <td><?= $managedWork->getVerificationDate()?></td>
							    <td><?= $managedWork->getDevice()?></td>
							    <td><?= $managedWork->getRequestNumber()?> / <?= $managedWork->getAccountNumber()?></td>
							    <td><input type="button" value="Подробнее" class="simpleSubmit" onclick="document.location='work.php?workId=<?=$managedWork->getId()?>'"></td>
							</tr>
							<?php 
							$index++;
							}
							?>
						</tbody>
					</table>
					<?php 
					}
					?>
				</div>
			</div>
			<div class="footer">
				<div class="footerContent">
					
				</div>
			</div>
		</div>

		<div class="popup" id="popUpEditMainInfo">
			<div class="popup-content">
				<h1 class="simpleBlackText">Редактирование основной информации</h1>
				<form action="personal.php" method="POST" class="questionnaire">
					<input type="hidden" name="staffId" value="<?=$currentStaffPerson->getId()?>">
					<label class="questionnaire-row">
						<span class="questionnaire-cell">Фамилия:</span>
						<span class="questionnaire-cell"><input type="text" name="surname" value="<?=$currentStaffPerson->getSurname()?>"></span>
					</label>
					<label class="questionnaire-row">
						<span class="questionnaire-cell">Имя:</span>
						<span class="questionnaire-cell"><input type="text" name="name" value="<?=$currentStaffPerson->getName()?>"></span>
					</label>
					<label class="questionnaire-row">
						<span class="questionnaire-cell">Отчество:</span>
						<span class="questionnaire-cell"><input type="text" name="patronimyc" value="<?=$currentStaffPerson->getPatronimyc()?>"></span>
					</label>
					<label class="questionnaire-row">
						<span class="questionnaire-cell">Пароль:</span>
						<span class="questionnaire-cell"><input type="text" name="pass" value="<?=$currentStaffPerson->getPass()?>"></span>
					</label>
              		<input type="submit" class="simpleSubmit" name="editMainInfo" value="Редактировать">
              	</form>
				<input type="button" class="simpleSubmit" value="Отмена" onclick='hidePopUp("popUpEditMainInfo");'>
			</div>
		</div>
		<script src="./templates/static/js/scripts.js"></script>
	</body>
</html>