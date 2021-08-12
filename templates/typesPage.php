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
					<form method='GET' action='types.php'>
						<h2>Добавить новый тип СИ</h2>
						Наименование типа: <input type="text" name="name">
            			Обозначение типа: <input type="text" name="designation">
            			Номер в гос. реестре: <input type="text" name="stateNumber">
						<button type="reset" class="minWidth">Сбросить</button>
						<button type="submit" class="minWidth" name="add" value="save">Сохранить</button>						
					</form>
				</div>
				<div class="rightCol">
					<h1>Типы СИ</h1>
					<table>
						<thead>
							<tr>
								<th>№</th>
								<th>Наименование типа</th>
								<th>Обозначение типа</th>
								<th>Номер в гос реестре</th>
								<th>Удалить</th>
							</tr>
						</thead>
						<tbody>
						<?php 
                			$index = 1; 
                			foreach($types as $id=>$type){
                			    echo "<tr>";
                			    echo "<td>$index</td>";
                			    echo "<td>{$type->getName()}</td>";
                			    echo "<td>{$type->getDesignation()}</td>";
                			    echo "<td>{$type->getStateNumber()}</td>";
                			    echo "<td><input type='button' value='Удалить' data-toggle='modal' data-target='#delModal' onclick='setInfo($id)' class='simpleSubmit'></td>";
                			    echo "</tr>";
                			    $index++;
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

		<div class="popup" id="popUp">
			<div class="popup-content">
				<h1 class="simpleBlackText">Вы уверены, что хотите удалить следующий тип СИ</h1>
				<p id="typeInfo"></p>
				<form action="types.php" method="POST">
              		<input type="hidden" id="delIdInput" name="id">
              		<input type="submit" class="simpleSubmit" name="del" value="Удалить">
              	</form>
				<input type="button" class="simpleSubmit" value="Отмена" onclick="hidePopUp('popUp')">
			</div>
		</div>
		<script src="./templates/static/js/scripts.js"></script>
	</body>
</html>