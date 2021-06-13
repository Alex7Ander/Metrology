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
					<li><a href="types.php">Типы СИ</a></li>
					<li><a href="devices.php">Зарегистрированные СИ</a></li>
					<li><a href="staff.php">Сотрудники</a></li>
					<li><a href="addWork.php">Добавить работу</a></li>
				</ul>
			</div>
			<div class="main">
				<div class="leftCol">
					<form method='GET' action='index.php' name='filters'>
						<h2>Фильтры поиска</h2>
						Дата поверки:
						<input type = 'date' name='date'>
						Тип поверяемого СИ:
						<select name='typeId'>
							<?php 
								echo "<option value=''></option>";
								foreach ($types as $type){
									$currentTypeId = $type->getId();
									echo "<option value='$currentTypeId'>$type</option>";
								}
							?>
						</select>
						Серийный номер:
						<input type = 'text' name='serialNumber'>
						Номер заявки:
						<input type = 'text' name='requestNumber'>
						Номер счета: 
                        <input type = 'text' name='accountNumber'>
						Поверитель:
						<select name="verificatorId">
							<?php 
								echo "<option value=''></option>";
								foreach ($verificators as $verificator){
									$currentVerificatorId = $verificator->getId();
									echo "<option value='$currentVerificatorId'>$verificator</option>";
								}
							?>
						</select>
						Ответственный за закрытие:
						<select name="managerId" class='noBorder'>
							<?php 
								echo "<option value=''></option>";
								foreach ($managers as $manager){
									$currentManagerId = $manager->getId();
									echo "<option value='$currentManagerId'>$manager</option>";
								}
							?>
						</select>
						Место по поверочной схеме:
						<select name="standartType" class='noBorder'>
							<option></option>
							<option>Рабочее средство измерения</option>
							<option>Эталон 2-го рязряда</option>
							<option>Эталон 1-го разряда</option>
							<option>Вторичный эталон</option>
						</select>
						<button type="submit" class="minWidth" name='search' value='Искать'>Поиск</button>
						<button type="reset" class="minWidth">Очистить</button>
					</form>
				</div>

				<div class="rightCol">
				<h1>Поверочные работы</h1>
					<table>
						<thead>
							<tr>
								<th>#</th>
								<th>Дата поверки</th>
								<th>Прибор</th>
								<th>Номер заявки / счета</th>
								<th>Поверитель</th>                        
								<th>Подробнее</th>
							</tr>
						</thead>
						<tbody>
						<?php
							if($works){
								$index = 1;
								foreach($works as $work){  
									$currentId = $work->getId();
									echo "<tr>";  
									echo "<td>$index (id: $currentId)</td>";
									echo "<td>{$work->getVerificationDate()}</td>";
									echo "<td>{$work->getDevice()}</td>";
									echo "<td>{$work->getRequestNumber()} / {$work->getAccountNumber()}</td>";
									echo "<td>{$work->getVerificator()}</td>";                   
									echo "<td><form method='GET' action='work.php'><input type='hidden' name='workId' value='$currentId'><input type='submit' class='simpleSubmit' name='$currentId' value='Подробнее'></form></td>";
									echo "</tr>";
									$index++;
								}               
							}
                        ?>
						</tbody>
					</table>
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
	</body>
</html>