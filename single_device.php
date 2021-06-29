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

if(!isset($_REQUEST['deviceId'])){
    header('Location: devices.php');
}

$id = $_REQUEST['deviceId'];
$deviceRepo = new DeviceRepository($host, $user, $password, $database);
$deviceTypeRepo = new DeviceTypeRepository($host, $user, $password, $database);
$workRepo = new WorkRepository($host, $user, $password, $database);

$currentDevice = $deviceRepo->getById($id);
$exampleWork = new Work();
$exampleWork->setDevice($currentDevice);
$works = $workRepo->getByExample($exampleWork);
$types = $deviceTypeRepo->getAll();

if(isset($_REQUEST['editMainInfo'])){
    $type = $types['typeId'];
    $currentDevice->setDeviceType($type);
    $currentDevice->setSerialNumber($_REQUEST['serialNumber']);
    $currentDevice->setProdYear($_REQUEST['prodYear']); 
    $deviceRepo->modify($currentDevice);
}



include './templates/devicePage.php';