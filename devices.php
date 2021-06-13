<?php
require_once './config/connection_config.php';

require_once './domain/DeviceType.php';
require_once './repositories/DeviceTypeRepository.php';
require_once './domain/Device.php';
require_once './repositories/DeviceRepository.php';

session_start();
$username = null;
if(!isset($_SESSION['username'])){
    header('Location: login.php');
}
else{
    $username = $_SESSION['username'];
}

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
    }
}

include "./templates/devicesPage.php";