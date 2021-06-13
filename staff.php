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

include "./templates/staffPage.php";