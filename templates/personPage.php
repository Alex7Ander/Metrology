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
					<div class="span1">
						<h1>Sed ut</h1>
						<div class="borderBottom"></div>
						<p>Lorem ipsum dolor sit</p>
						<ul class="clock">
							<li>Nights! Absolutely No Extra Charge</li>
							<li>Weekends! Absolutely No Extra Charge</li>
							<li>Holidays! Absolutely No Extra Charge</li>
						</ul>
						<div class="social">
							<div>Мы в социальных сетях: </div><ul><li><a target="newtab" href="http://www.facebook.com/?sk=app_2309869772"><img src="images/facebook.png"></a></li><li><a target="newtab" href="https://twitter.com/psdhtmlcss"><img src="images/twitter.png" /></a></li><li><img src="images/vk.png" /></li></ul>
						</div>
					</div>
					<div class="span1">
						<h1>At vero eos</h1>
						<div class="borderBottom"></div>
						<p>Lorem ipsum dolor sit</p>
						<ul>
							<li>West Hollywood (323) 221-1107</li>
							<li>Beverly Hills (310) 202-5428</li>
							<li>Pasadena (626) 296-2664</li>
							<li>West Hollywood (323) 221-1107</li>
							<li>Beverly Hills (310) 202-5428</li>
						</ul>
						<p><strong>Lorem ipsum dolor sit amet</strong></p>
					</div>
					<div class="span1">
						<h1>Lorem ipsum dolor</h1>
						<div class="borderBottom"></div>
						<p>Lorem ipsum dolor sit</p>
						<ul class="unstyled">
							<li>Hi-Tech Cherry Company</li>
							<li><a href="mailto:psdhtmlcss@mail.ru">infocherry@gmail.com</a></li>
							<li>5104 W. Washington Blvd</li>
							<li>Los Angeles , CA , 90016 United States</li>
						</ul>
					</div>
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