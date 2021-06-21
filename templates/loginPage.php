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
				</div>
			</div>
			<div class="slider">
				<div class="itemSlider">
					<div class="bgSlide"><img src="images/bg-slide-2.jpg"></div>
					<div class="descSlide">
                    <form action="login.php" method="POST" class="questionnaire">
                        <div class="questionnaire-row">
                            <b class="questionnaire-cell">Пользователь: </b>
                            <select name="staffId" class="questionnaire-cell"><?php foreach($workers as $id=>$worker){echo"<option value='$id'>$worker</option>";}?></select>
                        </div>
                        <div class="questionnaire-row">
                            <b class="questionnaire-cell">Пароль: </b>
                            <input type="password" name="pass" class="questionnaire-cell">
                        </div>
                        <div class="questionnaire-row">
                        	<span class="questionnaire-cell"><input type="submit" name="login" value="Войти" class="simpleSubmit"></span>
                        </div>
                    </form>
					</div>
				</div>
			</div>
        </div>
    </body>
</html>