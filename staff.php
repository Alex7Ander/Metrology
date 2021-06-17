<?php
require_once './config/connection_config.php';

require_once './domain/Staff.php';
require_once './repositories/StaffRepository.php';

session_start();
$username = null;
if(!isset($_SESSION['username'])){
    header('Location: login.php');
}
else{
    $username = $_SESSION['username'];
}

$staffRepo = new StaffRepository($host, $user, $password, $database);

$staff = $staffRepo->getAll();

if(isset($_REQUEST['save'])){
    $newStaff = new Staff();
    $newStaff->setName($_REQUEST['name']);
    $newStaff->setSurname($_REQUEST['surname']);
    $newStaff->setPatronimyc($_REQUEST['patronimyc']);
    $newStaff->setManagerStatus($_REQUEST['manager_status']);
    $newStaff->setVerificatorStatus($_REQUEST['verificator_status']);
    $newStaff->setPass($_REQUEST['pass']);
    $newStaff->setAccessLevel($_REQUEST['access_level']);
    try{
        $staffRepo->save($newStaff);
        $staff[$newStaff->getId()] = $newStaff;
    }
    catch(Exception $exception){
        $errorMessage = $exception->getMessage();
    }    
}



include "./templates/staffPage.php";