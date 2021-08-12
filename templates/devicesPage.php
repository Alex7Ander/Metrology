<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Средства измерения</title>
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
					<h1>Добавить новое СИ</h1>
            		<form method="POST" action="addDevice.php">
						<p>
							Тип прибора:<select name='type_id'>
                    		   <?php 
                    		   foreach($types as $id => $type){
                    		       echo "<option value=\"$id\">$type</option>";
                    		   }
                    	       ?>
                        	</select>
                        </p>
                        <p>
                        	Серийный номер: <input type="text" name="serial_number">
                        </p>
                		<button type="submit" class="minWidth" name="save" value="Сохранить">Сохранить</button>
            		</form>
				</div>

				<div class="rightCol">
					<h1>Зарегистрированные СИ</h1>
                	<table>
                		<tr>
                			<th>№</th>
                			<th>Тип</th>
                			<th>Заводской №</th>
                			<th>Удалить</th>
                		</tr>
                		<?php 
                		  $index = 1;
                		  foreach($devices as $id => $device){
                		      echo "<tr>";
                		      echo "<td>$index</td>";
                		      echo "<td>{$device->getDeviceType()}</td>";
                		      echo "<td><a href='single_device.php?deviceId=$id'>{$device->getSerialNumber()}</a></td>";
                		      echo "<td><input type='button' value='Удалить' onclick='setInfo($id)' class='simpleSubmit'></td>";
                		      echo "</tr>";
                		      $index++;
                		  }
                		?>
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
				<h1 class="simpleBlackText">Вы уверены, что хотите удалить СИ</h1>
				<p id="typeInfo"></p>
				<form action="devices.php" method="POST">
              		<input type="hidden" id="delIdInput" name="id">
              		<input type="submit" class="simpleSubmit" name="del" value="Удалить">
              	</form>
				<input type="button" class="simpleSubmit" value="Отмена" onclick="hidePopUp('popUp')">
			</div>
		</div>
		<script src="./templates/static/js/scripts.js"></script>
	</body>
</html>