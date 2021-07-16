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
					<h1>Основная информация</h1>
					<p>Прибор: <i><?=$currentDevice?></i></p>
					<p>Номер заявки: <i><?=$currentRequestNumber?></i></p>
                    <p>Номер счета: <i><?=$currentAccountNumber?></i></p>
        		    <p>Поверитель: <i><?=$currentVerificator?></i></p>
                    <p>Ответственный за закрытие работы: <i><?=$currentManager?></i></p>
                    <?php if($_SESSION['accessLevel'] == 10){?>	                        
					<button class="minWidth" onclick="showPopUp('popUpEditMainInfo')">Редактировать</button>
					<button class="minWidth" value="Удалить" onclick="showPopUp('popUp')">Удалить</button>	
					<?php }?>					
				</div>

				<div class="rightCol">
					<h1>Задание на поверку № <?=$currentWorkIndex?></h1>
            		<h3>Ход выполнения работы</h3>
            		<form method='POST' action='' enctype='multipart/form-data'>
            		    <!-- Taken -->
            			<input type='hidden' name='processMods[taken]' value='0'><br>
                		<label><input type='checkbox' name='processMods[taken]' value='1' <?php if($work->isTaken()) echo "checked";?>>Прибор принят в работу</label><br>
                		
                		<!-- Measured -->
                		<input type='hidden' name='processMods[measured]' value='0'><br>
                		<label><input type='checkbox' name='processMods[measured]' value='1' <?php if($work->isMeasured()) echo"checked";?>>Измерения проведены при следующих характеристиках окружающей среды</label><br>
                		<table> 
                			<tr>
                                <th>Температура</th>
                                <th>Давление</th>
                                <th>Влажность</th>
                            </tr>
                            <tr>
                                <td><input type='text' name='inv[t]' value='<?=$t?>'></td>
                                <td><input type='text' name='inv[p]' value='<?=$p?>'></td>
                                <td><input type='text' name='inv[h]' value='<?=$h?>'></td>
                            </tr>
                    	</table>
                    	<p>И на основании результатов поверки определено место по поверочной схеме как:</p>
                        <select name="standart_type">
                        	<?php 
                            	foreach($standartTypes as $type){
                            	    if(strcmp($work->getStandartType(), $type) == 0){
                            	        echo "<option selected>$type</option>";
                            	    }
                            	    else{
                            	        echo "<option>$type</option>";
                            	    }
                            	}
                        	?>
                    	</select>
                    	
                    	<!-- Protocol -->
                		<input type='hidden' name='processMods[processed]' value='0'><br>
            			<label><input type='checkbox' id='protocolCheckbox' name='processMods[processed]' value='1' <?php if($work->isProcessed()) echo"checked";?>>Протокол поверки создан</label><br>                		
            			<?php 
            			if(isset($protocolDownloadingLink)){
            			    echo("<a href='$protocolDownloadingLink' rel='noreferrer'> Ссылка на протокол </a>");
            			}
            			?>
            			<input name='protocol' id='protocolInput' type='file'/><br>
            			
                		<!-- Metrology closing -->
                		<div>
            				<input type='hidden' name='processMods[metrologyClosed]' value='0'>
            				<label><input type='checkbox' name='processMods[metrologyClosed]' value='1' <?php if($work->isMetrologyClosed()) echo"checked";?>>Работа закрыта в метрологии</label>
                		</div>
                		
                		<!-- Doc number -->
                		<div>
            				<input type='hidden' name='processMods[numberTaken]' value='0'>
            				<label><input type='checkbox' name='processMods[numberTaken]' id='numberTaken' value='1' <?php if($work->getDocumentNumber()) echo"checked";?>>Получен номер из системы Аршин</label>
            				<input type='text' name='documentNumber' <?php if($work->getDocumentNumber()) echo "value = {$work->getDocumentNumber()}";?>>
                		</div>
                		
                		<!-- Doc printed -->
                		<div>
                			<input type='hidden' name='processMods[documentPrinted]' value='0'><br>                		
            				<label><input type='checkbox' id='docCheckbox' name='processMods[documentPrinted]' value='1' <?php if($work->isDocumentPrinted()) echo"checked";?>>Свидетельство / извещение выписано</label><br>                		
							<?php if(isset($documentDownloadingLink)){
							    echo("<a href='$documentDownloadingLink' rel='noreferrer'> Ссылка на документ </a>");
							}
           			        ?>
            				<input name='document' id='docInput'  type='file'/><br>
                		</div>
                		
                		<!-- Given away -->
            			<input type='hidden' name='processMods[givenAway]' value='0'><br>
            			<label><input type='checkbox' name='processMods[givenAway]' value='1' <?php if($work->isGivenAway()) echo"checked";?>>Прибор отдан</label><br>
						<button type="submit" class="minWidth" name='processModified' value='Сохранить изменения'>Сохранить изменения</button>
            		</form>
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
				<h1 class="simpleBlackText">Вы уверены, что хотите удалить задание на поверку</h1>
				<p id="typeInfo"></p>
				<form action="work.php" method="POST">
              		<input type="hidden" id="delIdInput" name="workId" value="<?=$work->getId()?>">
              		<input type="submit" class="simpleSubmit" name="del" value="Удалить">
              	</form>
				<input type="button" class="simpleSubmit" value="Отмена" onclick='hidePopUp("popUp");'>
			</div>
		</div>
		<div class="popup" id="popUpEditMainInfo">
			<div class="popup-content">
				<h1 class="simpleBlackText">Редактирование основной информации о задании</h1>
				<form action="work.php" method="POST" class="questionnaire">
					<label class="questionnaire-row">
						<span class="questionnaire-cell">№ задания:</span>
						<span class="questionnaire-cell"><input type="text" name="workIndex" value="<?=$work->getWorkIndex()?>"></span>
					</label>
					<label class="questionnaire-row">
						<input type="hidden" id="modIdInput" name="workId" value="<?=$work->getId()?>">
						<span class="questionnaire-cell">Тип СИ:</span>
						<span class="questionnaire-cell">
		              		 <select name="typeId">
                      			<?php 
                      			foreach($types as $id => $type){
                      			    if($work->getDevice()->getDeviceType()->getId() == $id){
                      			        echo "<option value=$id selected>$type</option>";
                      			    }
                      			    else{
                      			        echo "<option value=$id>$type</option>";
                      			    }
                      			}
                      			?>
                      		</select>
						</span>
					</label>
					<label class="questionnaire-row">
						<span class="questionnaire-cell">Серийный номер:</span>
						<span class="questionnaire-cell"><input type="text" name="serialNumber" value="<?=$work->getDevice()->getSerialNumber()?>"></span>
					</label>
					<label class="questionnaire-row">
						<span class="questionnaire-cell">Номер заявки:</span>
						<span class="questionnaire-cell"><input type="text" name="requestNumber" value="<?=$work->getRequestNumber()?>"></span>
					</label>
					<label class="questionnaire-row">
						<span class="questionnaire-cell">Номер счета:</span>
						<span class="questionnaire-cell"><input type="text" name="accountNumber" value="<?=$work->getAccountNumber()?>"></span>
					</label>               		 
					<label class="questionnaire-row">
						<span class="questionnaire-cell">Поверитель:</span>
						<span class="questionnaire-cell">
							<select name="verificatorId">
                      		    <?php 
                      			foreach($verificators as $id => $verificator){
                      			    if($work->getVerificator()->getId() == $id){
                      			        echo "<option value='$id' selected>$verificator</option>";
                      			    }
                      			    else{
                      			        echo "<option value='$id'>$verificator</option>";
                      			    }
                      			}
                      			?>
              				</select>
						</span>
					</label>
					<label class="questionnaire-row">
						<span class="questionnaire-cell">Ответственный за закрытие работы:</span>
						<span class="questionnaire-cell">
                      		<select name="managerId">
                      			<?php 
                      			foreach($managers as $id => $manager){
                      			    if($work->getManager()->getId() == $id){
                      			        echo "<option value='$id' selected>$manager</option>";
                      			    }
                      			    else{
                      			        echo "<option value='$id'>$manager</option>";
                      			    }
                      			}
                      			?>
                      		</select>
						</span>
					</label>
              		<input type="submit" class="simpleSubmit" name="editMainInfo" value="Редактировать">
              	</form>
				<input type="button" class="simpleSubmit" value="Отмена" onclick='hidePopUp("popUpEditMainInfo");'>
			</div>
		</div>
		<script src="./templates/static/js/scripts.js"></script>
	</body>
</html>