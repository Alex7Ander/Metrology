<?php
require_once './config/connection_config.php';
require_once './domain/Staff.php';
require_once './repositories/StaffRepository.php';

session_start();
$staffRepo = new StaffRepository($host, $user, $password, $database);
$staff = $staffRepo->getAll();

if(isset($_POST['login'])){
    $staffId = $_POST['staffId'];
    $pass = $_POST['pass'];
    
    $currentStaffPerson = $staff[$staffId];
    if($currentStaffPerson->getPass() == $pass){
        $_SESSION['username'] = $currentStaffPerson->getFullName();
        $_SESSION['userId'] = $currentStaffPerson->getId();
        $_SESSION['accessLevel'] = $currentStaffPerson->getAccessLevel();
        header('Location: index.php');
    }
}

include './templates/loginPage.php';