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
					<form method='GET' action='addDeviceType.php'>
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

		<div class="popup" id="popUp">
			<div class="popup-content">
				<h1 class="simpleBlackText">Вы уверены, что хотите удалить следующий тип СИ</h1>
				<p id="typeInfo"></p>
				<form action="types.php" method="POST">
              		<input type="hidden" id="delIdInput" name="id">
              		<input type="submit" class="simpleSubmit" name="del" value="Удалить">
              	</form>
				<input type="button" class="simpleSubmit" value="Отмена" onclick='hidePopUp();'>
			</div>
		</div>
		<script src="./templates/static/js/scripts.js"></script>
	</body>
</html>