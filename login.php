<?php
require_once './config/connection_config.php';
require_once './domain/Staff.php';
require_once './repositories/StaffRepository.php';

session_start();
$staffRepo = new StaffRepository($host, $user, $password, $database);
$workers = $staffRepo->getAll();

if(isset($_POST['login'])){
    $staffId = $_POST['staffId'];
    $pass = $_POST['pass'];
    
    $currentWorker = $workers[$staffId];
    if($currentWorker->getPass() == $pass){
        $_SESSION['username'] = $currentWorker->getFullName();
        header('Location: index.php');
    }
}

include './templates/loginPage.php';