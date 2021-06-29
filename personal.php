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

if(!isset($_REQUEST['staffId'])){
    header('Location: staff.php');
}

$staffRepo = new StaffRepository($host, $user, $password, $database);
$workRepo = new WorkRepository($host, $user, $password, $database);

$id = $_REQUEST['staffId'];
$currentStaffPerson = $staffRepo->getById($id);

$verificationWork = new Work();
$managingWork = new Work();
$verificationWork->setVerificator($currentStaffPerson);
$managingWork->setManager($currentStaffPerson);
$verifications = $workRepo->getByExample($verificationWork);
$managing = $workRepo->getByExample($managingWork);

if(isset($_REQUEST['editMainInfo'])){
    $currentStaffPerson->setName($_REQUEST['name']);
    $currentStaffPerson->setSurname($_REQUEST['surname']);
    $currentStaffPerson->setPatronimyc($_REQUEST['patronimyc']);
    $currentStaffPerson->setPass($_REQUEST['pass']);
    
    try{
        $staffRepo->modify($currentStaffPerson);
        $_SESSION['username'] = $currentStaffPerson->getFullName();
    } 
    catch (Exception $exception){
        $errorMsg = $exception->getMessage();
    }
    
}

include "./templates/personPage.php";