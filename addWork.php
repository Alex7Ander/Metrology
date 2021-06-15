<?php 
require_once './config/connection_config.php';
require_once './business/Uploader.php';

require_once './domain/DeviceType.php';
require_once './repositories/DeviceTypeRepository.php';
require_once './domain/Device.php';
require_once './repositories/DeviceRepository.php';
require_once './domain/Staff.php';
require_once './repositories/StaffRepository.php';
require_once './domain/Work.php';
require_once './repositories/WorkRepository.php';

session_start();
$username = null;
if(!isset($_SESSION['username'])){
    header('Location: login.php');
}
else{
    $username = $_SESSION['username'];
}

$standartTypes = Array("Рабочее средство измерения", "Эталон 2-го рязряда", "Эталон 1-го разряда", "Вторичный эталон");

$ydUploader = new Uploader($yandexDiskToken);        
$staffRepo = new StaffRepository($host, $user, $password, $database);
$deviceRepo = new DeviceRepository($host, $user, $password, $database);
$workRepo = new WorkRepository($host, $user, $password, $database);
$typesRepo = new DeviceTypeRepository($host, $user, $password, $database);
                    
$verificators = $staffRepo->getVerificators();
$managers = $staffRepo->getManagers();
$types = $typesRepo->getAll();                                  

if(isset($_REQUEST['save'])){  
    $type = $types[$_REQUEST['type_id']];
    $serialNumber = $_REQUEST['device_serial_number'];                        
    $device = $deviceRepo->getByTypeAndSerialNumber($type, $serialNumber);
    if($device == null){
        $device = new Device($type, $serialNumber);
        $deviceRepo->save($device);
    }

    $verificatorId = $_REQUEST['verificator_id'];
    $verificator = $verificators["$verificatorId"];
    $managerId = $_REQUEST['manager_id'];
    $manager = $managers["$managerId"];
    
    $work = new Work();                     
    $work->setDevice($device);
    $work->setVerificator($verificator);
    $work->setManager($manager);                        
    $work->setRequestNumber($_REQUEST['request_number']);
    $work->setAccountNumber($_REQUEST['account_number']);
    $work->setVerificationDate($_REQUEST['verification_date']);
    $work->setStandartType($_REQUEST['standart_type']);
    $work->setTemperature($_REQUEST['temperature']);
    $work->setHumidity($_REQUEST['humidity']);
    $work->setPreasure($_REQUEST['preasure']);

    if(isset($_FILES['protocol'])){
        $pathFrom = $_FILES['protocol']['tmp_name'];
        if($pathFrom != ''){
            $fileName = $_FILES['protocol']['name'];
            $fileName = uniqid(rand()) . "_" . str_replace(" ", "_", $fileName);
            $pathTo = "/ApplicationsFolder/Metrology/Protocols/";
            $ydUploader->uploadFile($pathFrom, $fileName, $pathTo);
            $work->setProtocolLink($pathTo . $fileName);
            $work->setTaken(true);
            $work->setMeasured(true);
            $work->setProcessed(true);
        }
    }
    if(isset($_FILES['document'])){
        $pathFrom = $_FILES['document']['tmp_name'];
        if($pathFrom != ''){
            $fileName = $_FILES['document']['name'];
            $fileName = uniqid(rand()) . "_" . str_replace(" ", "_", $fileName);
            $pathTo = "/ApplicationsFolder/Metrology/Documents/";
            $ydUploader->uploadFile($pathFrom, $fileName, $pathTo);
            $work->setDocumentLink($pathTo . $fileName);
        }
    }                       
    $workRepo->save($work);
    header('Location: index.php');
}

include "./templates/addWorkPage.php";