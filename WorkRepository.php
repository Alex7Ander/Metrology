<?php
require_once 'Device.php';
require_once 'DeviceRepository.php';
require_once 'Staff.php';
require_once 'StaffRepository.php';
class WorkRepository{
    private $mysqli;
    private $staffRepo;
    private $deviceRepo;
    
    public function __construct($host, $user, $password, $database){
        $this->mysqli = new mysqli($host, $user, $password, $database);
        if($this->mysqli->connect_error){
            die("Error: creation object of workRepository class failed (" . $this->mysqli->connect_errno . " - ". $this->mysqli->connect_error . ")");
        }
        $this->mysqli->set_charset('utf8');
        $this->staffRepo = new StaffRepository($host, $user, $password, $database);
        $this->deviceRepo = new Devicerepository($host, $user, $password, $database);
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
            
            $query = "SELECT COUNT(*) AS workCount FROM works WHERE device_id='{$work->getDevice()->getId()}' AND request_number='{$work->getRequestNumber()}' AND account_number='{$work->getAccountNumber()}'";
            $result = $this->mysqli->query($query);
            $row = $result->fetch_assoc();
            $count = $row['workCount'];
            if($count > 0){
                echo "<b>Ошибка! Работа с такими же номерами заявки и счета для данного прибора уже зарегистрирована!</b><br>";
                return;
            }
            $query = "INSERT INTO works (device_id,
                                        verificator_id, 
                                        manager_id,                                     
                                        verification_date,
                                        request_number, 
                                        account_number, 
                                        work_index, 
                                        standart_type, 
                                        temperature, 
                                        humidity, 
                                        preasure, 
                                        protocol_link, 
                                        document_link) 
                                        VALUES ('{$work->getDevice()->getId()}',
                                                '$currentWorkVerificatorId', 
                                                '$currentWorkManagerId', 
                                                '{$work->getVerificationDate()}',
                                                '{$work->getRequestNumber()}', 
                                                '{$work->getAccountNumber()}', 
                                                '{$work->getWorkIndex()}', 
                                                '{$work->getStandartType()}', 
                                                '{$work->getTemperature()}', 
                                                '{$work->getHumidity()}', 
                                                '{$work->getPreasure()}', 
                                                '{$work->getProtocolLink()}', 
                                                '{$work->getDocumentLink()}')";            
            $this->mysqli->query($query);                        
            $query = "SELECT id AS newId FROM works WHERE device_id='{$work->getDevice()->getId()}' AND request_number='{$work->getRequestNumber()}' AND account_number='{$work->getAccountNumber()}'";
            $result = $this->mysqli->query($query);            
            $id = $result->fetch_assoc()['newId'];
            $work->setId($id);            
            $result->close();
            $this->mysqli->commit();
        }
        catch(mysqli_sql_exception $exception){
            $this->mysqli->rollback();
            throw $exception;
        }
    }
    
    public function modify($work){
        if(!($work instanceof Work)){
            die("Error: wrong type of parametr in method save (class workRepository)");
        }
        $this->mysqli->begin_transaction();
        try{
            $query = "UPDATE works SET device_id = '{$work->getDevice()->getId()}', 
                verificator_id='{$work->getVerificator()->getId()}', 
                manager_id = '{$work->getManager()->getId()}',
                verification_date = '{$work->getVerificationDate()}',
                request_number = '{$work->getRequestNumber()}',
                account_number = '{$work->getAccountNumber()}',
                work_index = '{$work->getWorkIndex()}',
                standart_type = '{$work->getStandartType()}',
                temperature = '{$work->getTemperature()}',
                humidity = '{$work->getHumidity()}',
                preasure = '{$work->getPreasure()}',
                protocol_link = '{$work->getProtocolLink()}',
                document_link = '{$work->getDocumentLink()}',
                taken = {$work->isTaken()},
                measured = {$work->isMeasured()},
                processed = {$work->isProcessed()},
                metrology_closed = {$work->isMetrologyClosed()},
                document_printed = {$work->isDocumentPrinted()},
                given_away = {$work->isGivenAway()},
                document_number = '{$work->getDocumentNumber()}'
                WHERE id='{$work->getId()}'";
            $this->mysqli->query($query);
            $this->mysqli->commit();
        }
        catch(mysqli_sql_exception $exception){
            $this->mysqli->rollback();
            throw $exception;
        }
    }
    
    public function delete($work){
        if(!($work instanceof Work)){
            die("Error: wrong type of parametr in method save (class workRepository)");
        }
        $this->mysqli->begin_transaction();
        try{
            $id = $work->getId();
            $query = "DELETE FROM works WHERE id='$id'";
            $this->mysqli->query($query);
            $this->mysqli->commit();
        }
        catch(mysqli_sql_exception $exception){
            $this->mysqli->rollback();
            throw $exception;
        }
    }
    
    public function getByExample($work){
        if(!($work instanceof Work)){
            die("Error: wrong type of parametr in method getByExample (class workRepository)");
        }
        $exVerificatorId = '';
        if($work->getVerificator() != null){
            $exVerificatorId = $work->getVerificator()->getId();
        }
        $exManagerId = '';
        if($work->getManager() != null){
            $exManagerId = $work->getManager()->getId();
        }
        $exDeviceId = '';
        if($work->getDevice() != null){
            $exDeviceId = $work->getDevice()->getId(); 
        }       
        $query = "SELECT * FROM works WHERE request_number LIKE '%{$work->getRequestNumber()}%' 
                    AND account_number LIKE '%{$work->getAccountNumber()}%' 
                    AND work_index LIKE '%{$work->getWorkIndex()}%' 
                    AND standart_type LIKE '%{$work->getStandartType()}%' 
                    AND verificator_id LIKE '%$exVerificatorId%' 
                    AND manager_id LIKE '%$exManagerId%' 
                    AND device_id LIKE '%$exDeviceId%'";
        $result = $this->mysqli->query($query);
        $works = $this->getWorksFromResult($result);
        $result->close();
        return $works;
    }

    public function getAll(){
        $query = "SELECT * FROM works";
        $result = $this->mysqli->query($query);       
        $works = $this->getWorksFromResult($result);
        $result->close();
        return $works;
    }
    
    public function getById($id){
        $query = "SELECT COUNT(*) AS workCount FROM works WHERE id='$id'";
        $result = $this->mysqli->query($query);
        $row = $result->fetch_assoc();
        $count = $row['workCount'];
        if($count == 0){
            $result->close();
            return null;
        }
        $query = "SELECT * FROM works WHERE id='$id'";
        $result = $this->mysqli->query($query);
        $works = $this->getWorksFromResult($result);
        $result->close();
        $work = $works["$id"];
        return $work;
    }
    
    private function getWorksFromResult($result){
        $works = [];
        foreach($result as $value){
            $deviceId = $value['device_id'];
            $verificatorId = $value['verificator_id'];
            $managerId = $value['manager_id'];
            $device = $this->deviceRepo->getById($deviceId);
            $verificator = $this->staffRepo->getWorkerById($verificatorId);
            $manager = $this->staffRepo->getWorkerById($managerId);
            $requestNumber = $value['request_number'];
            $accountNumber = $value['account_number'];
            
            $work = new Work();
            $work->setDevice($device);
            $work->setVerificator($verificator);
            $work->setManager($manager);
            $work->setAccountNumber($accountNumber);
            $work->setRequestNumber($requestNumber);
            $id = $value['id'];
            $work->setId($id);
            $work->setVerificator($verificator);
            $work->setManager($manager);            
            $work->setWorkIndex($value['work_index']);            
            $work->setVerificationDate($value['verification_date']);            
            $work->setStandartType($value['standart_type']);
            $work->setTemperature($value['temperature']);
            $work->setHumidity($value['humidity']);
            $work->setPreasure($value['preasure']);
            $work->setProtocolLink($value['protocol_link']);
            $work->setDocumentLink($value['document_link']);
            $work->setTaken($value['taken']);
            $work->setMeasured($value['measured']);
            $work->setProcessed($value['processed']);
            $work->setMetrologyClosed($value['metrology_closed']);
            $work->setDocumentNumber($value['document_number']);
            $work->setDocumentPrinted($value['document_printed']);
            $work->setGivenAway($value['given_away']);
            $works["$id"] = $work;
        }
        return $works;
    }

}
?>