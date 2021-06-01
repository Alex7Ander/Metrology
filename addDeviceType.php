<!DOCTYPE html>
<html>
    <head>
        <title>Распределение метрологических работ - Главная</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
		<style>
            table, td, th{
                border: 1px solid black;               
            }
            .noBorder{
                border: none;
            }
        </style>
	</head>
	<body>
		<?php 
		    require_once 'connection_config.php';
		    require_once 'DeviceType.php';
		    require_once 'DeviceTypeRepository.php';
		    
		    $deviceTypeRepo = new DeviceTypeRepository($host, $user, $password, $database);
		    $types = $deviceTypeRepo->getAll();	    
    		if(isset($_REQUEST['add'])){
    		    $name = $_REQUEST['name'];
    		    $designation = $_REQUEST['designation'];
    		    $stateNumber = $_REQUEST['stateNumber'];    		    
    		    $newType = new DeviceType();   		    
    		    $newType->setName($name);
    		    $newType->setDesignation($designation);
    		    $newType->setStateNumber($stateNumber);    		       		    
    		    try{
    		        $deviceTypeRepo->save($newType);
    		        echo "Тип средства измерения $newType успешно сохранен";
    		        $id = $newType->getId();
    		        $types[$id] = $newType; 
    		    }
    		    catch(Exception $exception){
    		        echo "В процессе сохранения нового типа средства измерения произошла ошибка: " . $exception->getMessage();
    		    }
    		}
    		if(isset($_REQUEST['del'])){
    		    $id = $_REQUEST['id'];
    		    $deletingType = $types[$id];
    		    try{
    		        $deviceTypeRepo->delete($deletingType);
    		        unset($types[$id]);
    		    }
    		    catch(Exception $exception){
    		        $msg = $exception->getMessage();
    		        echo "$msg";
    		    }
    		}
		?>
		<div class = "container-fluid">
			<div class="row">
    	        <div>
                    <h1>Добавление нового типа средства измерения</h1>
                    <a href='/metrology/main.php'>На главную</a>
                </div>
            </div>
            <div class="row">
            	<div class="col-md-3">
            		<form action='addDeviceType.php'>
            			<label for="name">Наименование типа:</label>
            			<input type="text" name="name"><br>
            			<label for="designation">Обозначение типа:</label>
            			<input type="text" name="designation"><br>
            			<label for="stateNumber">Номер в гос. реестре:</label>
            			<input type="text" name="stateNumber"><br>
            			<input type="submit" name="add" value="Добавить новый тип">
            		</form>	
            	</div>
            	<div class="col-md-9">
            		<table>
            			<tr>
            				<th>№</th>
            				<th>Наименование типа</th>
            				<th>Обозначение типа</th>
            				<th>Номер в гос реестре</th>
            				<th>Удалить</th>
            			</tr>
            			<?php 
                			$index = 1; 
                			foreach($types as $id=>$type){
                			    echo "<tr>";
                			    echo "<td>$index</td>";
                			    echo "<td>{$type->getName()}</td>";
                			    echo "<td>{$type->getDesignation()}</td>";
                			    echo "<td>{$type->getStateNumber()}</td>";
                			    echo "<td><input type='button' value='Удалить' data-toggle='modal' data-target='#delModal' onclick='setId($id)'></td>";
                			    echo "</tr>";
                			    $index++;
                			}
            			?>
            		</table>
            	</div>
            </div>
		</div>		
        <div class="modal" id="delModal" tabindex="-1" role="dialog">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Удаление СИ</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <p>Вы уверены, что хотиет удалить этот тип средства измерения?</p>
              </div>
              <div class="modal-footer">
              	<form action="addDeviceType.php" method="POST">
              		<input type="hidden" id="delIdInput" name="id">
              		<input type="submit" class="btn btn-primary" name="del" value="Удалить">
              	</form>                
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
              </div>
            </div>
          </div>
        </div>
        <script>
			function setId(id){
				document.getElementById('delIdInput').value = id;				
			}
        </script>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	</body>
</html>
