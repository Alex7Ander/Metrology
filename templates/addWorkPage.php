<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Сообщество 113</title>
		<meta name="description" content="">
		<meta name="keywords" content="">
		<link rel="stylesheet" type="text/css" href="style.css" media="all">
		<style>
			table td{	
				color: white;			
				font-size: 22px;
				vertical-align: middle;
			}

			table td input[type='file']{
				color: black;
			}
		</style>
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

				</div>

				<div class="rightCol">
					<h1>Добавить работу</h1>
					<form action="addWork.php" method="POST" enctype='multipart/form-data'>
						<table>
							<thead>
							<tr>
								<th>Параметр</th>
								<th>Значение</th>
							</tr>
							</thead>
							<tbody>
							<tr>
								<td>Тип работы:</td>
								<td>
									<select name="work_type">
										<option>Поверка</option>
										<option>Калибровка</option>
									</select>
								</td>
							</tr>
							<tr>
								<td>Номер заявки:</td>
								<td><input type="text" name="request_number"></td>
							</tr>
							<tr>
								<td>Номер счета:</td>
								<td><input type="text" name="account_number"></td>
							</tr>
							<tr>
								<td>Тип поверяемого СИ:</td>
								<td><select name="type_id"><?php                            
									foreach($types as $id => $type){
										echo "<option value=\"$id\">$type</option>";
									}
									?>
									</select>
								</td>
							</tr>
							<tr>
								<td>Серийный номер:</td>
								<td><input type="text" name="device_serial_number"></td>
							</tr>
							<tr>
								<td>Год выпуска:</td>
								<td><input type="text" name="device_prod_year"></td>
							</tr>
							<tr>
								<td>Результат:</td>
								<td>
									<select name="result">
										<option value="1">Годен</option>
										<option value="0">Не годен</option>
									</select>
								</td>
							</tr>
							<tr>
								<td>Место в поверочной схеме:</td>
								<td>
									<select name="standart_type">
										<?php 
										echo "<option selected></option>";
										foreach($standartTypes as $type){
											echo "<option>$type</option>";
										}
										?>
									</select>
								</td>
							</tr>

							<tr colspan = 2>
								<td><h3>Заполняется в случае если поверка уже проведена</h3></td>
							</tr>
							<tr>
								<td>Дата поверки:</td>
								<td><input type="date" name="verification_date"></td>
							</tr>
							<tr>
								<td>Температура:</td>
								<td><input type="text" name="temperature" ></td>
							</tr>
							<tr>
								<td>Влажность:</td>
								<td><input type="text" name="humidity"></td>
							</tr>
							<tr>
								<td>Атмосферное давление:</td>
								<td><input type="text" name="preasure"></td>
							</tr>                   
							<tr>
								<td>Протокол поверки: </td>
								<td><input name='protocol' id='protocolInput' type='file'/></td>
							</tr>
							<tr>
								<td>Свидетельство (извещение): </td>
								<td><input name='document' id='docInput' type='file'/></td>
							</tr>
							<tr colspan = 2>
								<td><h3>Исполнители</h3></td>
							</tr>
							<tr>
								<td>
									Поверитель:
								</td>
								<td><select name="verificator_id"><?php 
										foreach($verificators as $verificatorId => $verificator){
											echo "<option value=\"$verificatorId\">$verificator</option>";
										}
									?>
									</select>
								</td>
							</tr>
							<tr><td>Ответственный за закрытие работы:</td>
								<td><select name="manager_id"><?php 
										foreach($managers as $managerId => $manager){
											echo "<option value=\"$managerId\">$manager</option>";
										}
									?>
									</select>
								</td>
							</tr>
							</tbody>
						</table>
						<button type="submit" class="minWidth" name="save" value="sendData">Отправить данные</button>
					</form>
				</div>
			</div>
			<div class="footer">
				<div class="footerContent">

				</div>
			</div>
		</div>
	</body>
</html>