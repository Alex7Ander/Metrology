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
				<?php 
				if($_SESSION['accessLevel'] == 10){
				    
				?>				
        		<div class="leftCol">
    				<h1>Добавить нового сотрудника</h1>
    				<?php 
    				if(isset($errorMessage)){
    				    echo "<b>$errorMessage</b><br>";
    				}
    				?>
            		<form method="POST" action="staff.php">
						Имя: <input type="text" name="name">
						Фамилия: <input type="text" name="surname">
						Отчество: <input type="text" name="patronimyc">
						Пароль: <input type="text" name="pass">
						<input type="hidden" name="verificator_status" value="0">
						<label><input type="checkbox" name="verificator_status" value="1">Поверитель</label><br>
						<input type="hidden" name="manager_status" value="0">
						<label><input type="checkbox" name="manager_status" value="1">Менеджер</label><br>
						Права доступа:
						<select name="access_level">
							<option value="1" selected>Пользователь</option>
							<option value="10">Администратор</option>
						</select>						
                		<button type="submit" class="minWidth" name="save" value="Сохранить">Сохранить</button>
                		<button type="reset" class="minWidth">Очистить</button>
            		</form>
        		</div>
        		<?php 
				}
        		?>
				<div class="rightCol">
					<h1>Сотрудники</h1>
                    <table>
                        <thead>
                        <tr>
                            <th>№</th>
                            <th>Ф.И.О.</th>
                            <th>Поверитель</th>
                            <th>Менеджер</th>
                            <th>Подробнее</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $index = 1;
                        foreach($staff as $staffPerson){
                            $isverificator = "-";
                            $ismanager = "-";
                            if($staffPerson->getVerificatorStatus()){
                                $isverificator = "+";
                            }
                            if($staffPerson->getManagerStatus()){
                                $ismanager = "+";
                            }
                        ?>
                        <tr>
							<td><?=$index?></td>
                            <td><?=$staffPerson->getFullName()?></td>
                            <td><?=$isverificator?></td>
                            <td><?=$ismanager?></td>
                            <td><input type="button" value="Подробнее" class="simpleSubmit" onclick="document.location='personal.php?staffId=<?=$staffPerson->getId()?>'"></td>
						</tr>
                        <?php        
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
	</body>
</html>