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

$ydUploader = new Uploader($yandexDiskToken);          
$standartTypes = Array("Рабочее средство измерения", "Эталон 2-го рязряда", "Эталон 1-го разряда", "Вторичный эталон");
$workId = $_REQUEST["workId"];
$workRepo = new WorkRepository($host, $user, $password, $database);
$work = $workRepo->getById($workId);

if($work){
    if(isset($_REQUEST['del'])){
        echo "DELETING <br>";
        $workRepo->delete($work);
        header('Location: index.php');
    }
    
    if(isset($_REQUEST['processModified'])){
        $mods = $_REQUEST['processMods'];
        $work->setTaken($mods['taken']);
        $work->setMeasured($mods['measured']);
        $work->setStandartType($_REQUEST['standart_type']);
        $work->setProcessed($mods['processed']);		          
        $work->setMetrologyClosed($mods['metrologyClosed']);		          
        $work->setDocumentNumber($_REQUEST['documentNumber']);
        $work->setDocumentPrinted($mods['documentPrinted']);
        $work->setGivenAway($mods['givenAway']);		          
        $inv = $_REQUEST['inv'];
        $work->setTemperature($inv['t']);
        $work->setPreasure($inv['p']);
        $work->setHumidity($inv['h']);
                
        //files uploading		         
        //if protocol uploaded		          		          
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
        //if document uploaded
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
        $workRepo->modify($work);
    }
    $currentWorkIndex = $work->getWorkIndex();
    $currentRequestNumber = $work->getRequestNumber();
    $currentAccountNumber = $work->getAccountNumber();
    $currentVerificator = $work->getVerificator();
    $currentManager = $work->getManager();
    $currentDevice = $work->getDevice();
    $currentStandartType = $work->getStandartType();
    $t = $work->getTemperature();
    $h = $work->getHumidity();
    $p = $work->getPreasure();
    if($work->getProtocolLink()){
        $protocolDownloadingLink = $ydUploader->getDownloadingLink($work->getProtocolLink());
    }
    if($work->getDocumentLink()){
        $documentDownloadingLink = $ydUploader->getDownloadingLink($work->getDocumentLink());
    }    
}

include "./templates/workPage.php";