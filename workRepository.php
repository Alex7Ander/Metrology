<?php
require_once 'device.php';
require_once 'deviceRepository.php';
require_once 'worker.php';
require_once 'workerRepository.php';
class WorkRepository{
    private $mysqli;
    private $workerRepo;
    private $deviceRepo;
    
    public function __construct($host, $user, $password, $database){
        $this->mysqli = new mysqli($host, $user, $password, $database);
        if($this->mysqli->connect_error){
            die("Error: creation object of workRepository class failed (" . $this->mysqli->connect_errno . " - ". $this->mysqli->connect_error . ")");
        }
        $this->mysqli->set_charset('utf8');
        $this->workerRepo = new WorkerRepository($host, $user, $password, $database);
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
    
    public function modify($work){
        if(!($work instanceof Work)){
            die("Error: wrong type of parametr in method save (class workRepository)");
        }
        $this->mysqli->begin_transaction();
        try{
            echo "Modifying of $work<br>";
        }
        catch(mysqli_sql_exception $exception){
            $this->mysqli->rollback();
            throw $exception;
        }
    }

    public function getAll(){
        $query = "SELECT * FROM works";
        $result = $this->mysqli->query($query);
        $works = $this->getWorksFromResult($result);
        $result->close();
        return $works;
    }
    
    public function getById($id){
        $query = "SELECT * FROM works WHERE id='$id'";
        $result = $this->mysqli->query($query);
        $works = $this->getWorksFromResult($result);
        $result->close();
        $work = $works["$id"];
        return $work;
    }
    
    private function getWorksFromResult($result){
        $works = [];
        foreach($result as $key=>$value){
            $deviceId = $value['device_id'];
            $verificatorId = $value['verificator_id'];
            $managerId = $value['manager_id'];
            $device = $this->deviceRepo->getById($deviceId);
            $verificator = $this->workerRepo->getWorkerById($verificatorId);
            $manager = $this->workerRepo->getWorkerById($managerId);
            $requestNumber = $value['request_number'];
            $accountNumber = $value['account_number'];
            
            $work = new Work($device, $requestNumber, $accountNumber);
            $work->setVerificator($verificator);
            $work->setManager($manager);
            $id = $value['id'];
            $work->setId($id);
            $work->setVerificator($verificator);
            $work->setManager($manager);            
            $work->setWorkIndex($value['work_index']);            
            $work->setVerificationDate($value['work_index']);            
            $work->setEtalonType($value['device_etalon_type']);
            $work->setTemperature($value['temperature']);
            $work->setHumidity($value['humidity']);
            $work->setPreasure($value['preasure']);
            $work->setProtocolLink($value['protocolLink']);
            $work->setDocumentLink($value['documentLink']);

            $works["$id"] = $work;
        }
        return $works;
    }

}
?>