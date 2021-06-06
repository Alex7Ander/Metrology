<!DOCTYPE html>
<html>
    <head>
        <title>Средства измерения</title>
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
            require_once "Device.php";
            require_once "DeviceRepository.php";
            require_once "DeviceTypeRepository.php";
            require_once "connection_config.php";
            
            $deviceTypeRepo = new DeviceTypeRepository($host, $user, $password, $database);
            $devicesRepo = new DeviceRepository($host, $user, $password, $database);
            $devices = $devicesRepo->getAll();
            $types = $deviceTypeRepo->getAll();
            
            if(isset($_REQUEST['save'])){
                $deviceTypeId = $_REQUEST['type_id'];
                $serialNumber = $_REQUEST['serial_number'];
                $deviceType = $deviceTypeRepo->getById($deviceTypeId);
                $device = new Device($deviceType, $serialNumber);
                
                $devicesRepo->save($device);
                $deviceId = $device->getId();
                $devices[$deviceId] = $device;
            }
            if(isset($_REQUEST['del'])){
                $id = $_REQUEST['id'];
                $deletingDevice = $devices[$id];
                try{
                    $devicesRepo->delete($deletingDevice);
                    unset($devices[$id]);
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
                    <h1>Средства измерения</h1>
                    <a href='/metrology/main.php'>На главную</a>
                </div>
            </div>
            
            <div class="row">          	
            	<div class="col-md-6">
            		<h3>Добавить новое СИ</h3>
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
                		<input type="submit" name="save" value="Сохранить">
            		</form>
            	</div>
                <div class="col-md-6">
                	<h3>Зарегистрированные СИ</h3>
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
                		      echo "<td>{$device->getSerialNumber()}</td>";
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
                <p>Вы уверены, что хотиет удалить этот прибор?</p>
              </div>
              <div class="modal-footer">
              	<form action="addDevice.php" method="POST">
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