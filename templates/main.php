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
								<th>Тип</th>
								<th>Прибор</th>
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
									echo "<td>{$work->getType()}</td>";
									echo "<td>{$work->getDevice()}</td>";
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
					
				</div>
			</div>
		</div>
	</body>
</html>