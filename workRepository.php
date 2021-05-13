<?php
class WorkRepository{
    private $mysqli;

    public function __construct($host, $user, $password, $database){
        $this->mysqli = new mysqli($host, $user, $password, $database);
        if($this->mysqli->connect_error){
            die("Error: creation object of workRepository class failed (" . $this->mysqli->connect_errno . " - ". $this->mysqli->connect_error . ")");
        }
        $this->mysqli->set_charset('utf8');
    }

    public function save($work){        
        if(!($work instanceof Work)){
            die("Error: wrong type of parametr in method save (class workRepository)");
        }
        $this->mysqli->begin_transaction();
        try{
            $currentWorkVerificatorId = null;
            if($work->getVerificator() != null){
                $currentWorkVerificatorId = $work->getVerificator()->getId();
            }
            $currentWorkManagerId = null;
            if($work->getVerificator() != null){
                $currentWorkManagerId = $work->getManager()->getId();
            }           
            $currentDeviceId = $work->getDevice()->getId();
            $currentRequestNumber = $work->getRequestNumber();
            $currentAccountNumber = $work->getAccountNumber();  
            $currentWorkIndex = $work->getWorkIndex();
            $currentEtalonType = $work->getEtalonType();
            $temperature = $work->getTemperature();
            $humidity = $work->getHumidity();
            $preasure = $work->getPreasure();
            $protocolLink = $work->getProtocolLink();
            $documentLink = $work->getDocumentLink();
            
            $query = "SELECT COUNT(*) AS workCount FROM works WHERE device_id='$currentDeviceId' AND request_number='$currentRequestNumber' AND account_number='$currentAccountNumber'";
            $result = $this->mysqli->query($query);
            $row = $result->fetch_assoc();
            $count = $row['workCount'];
            if($count > 0){
                echo "<b>Ошибка! Работа с такими же номерами заявки и счета для данного прибора уже зарегистрирована!</b><br>";
                return;
            }
            $query = "INSERT INTO works (verificator_id, manager_id, device_id, request_number, account_number, work_index, device_etalon_type, temperature, humidity, preasure, protocolLink, documentLink) 
                        VALUES ('$currentWorkVerificatorId', '$currentWorkManagerId', '$currentDeviceId', '$currentRequestNumber', '$currentAccountNumber', '$currentWorkIndex', '$currentEtalonType', '$temperature', '$humidity', '$preasure', '$protocolLink', '$documentLink')";
            $this->mysqli->query($query);
            $query = "SELECT id AS newId FROM works WHERE device_id='$currentDeviceId' AND request_number='$currentRequestNumber' AND account_number='$currentAccountNumber'";
            $result = $this->mysqli->query($query);
            $id = $result->fetch_assoc()['newId'];
            $work->setId($id);            
            $result->close();
            $this->mysqli->commit();
            echo "<b>Задание успешно добавлено</b><br>";
        }
        catch(mysqli_sql_exception $exception){
            $this->mysqli->rollback();
            throw $exception;
        }
    }



}
?>