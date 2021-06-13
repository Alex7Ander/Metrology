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
$types = $deviceTypeRepo->getAll();	    
if(isset($_REQUEST['add'])){
    $name = $_REQUEST['name'];
    $designation = $_REQUEST['designation'];
    $stateNumber = $_REQUEST['stateNumber'];    		    
    $newType = new DeviceType();   		    
    $newType->setName($name);
    $newType->setDesignation($designation);
    $newType->setStateNumber($stateNumber);    		       		    
    try{
        $deviceTypeRepo->save($newType);
        $id = $newType->getId();
        $types[$id] = $newType; 
    }
    catch(Exception $exception){
        //
    }
}
if(isset($_REQUEST['del'])){
    $id = $_REQUEST['id'];
    $deletingType = $types[$id];
    try{
        $deviceTypeRepo->delete($deletingType);
        unset($types[$id]);
    }
    catch(Exception $exception){
        $msg = $exception->getMessage();
        echo "$msg";
    }
}

include './templates/typesPage.php';