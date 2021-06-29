<?php 
require_once './config/connection_config.php';

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

$workRepo = new WorkRepository($host, $user, $password, $database);
$staffRepo = new StaffRepository($host, $user, $password, $database);
$typesRepo = new DeviceTypeRepository($host, $user, $password, $database);

$verificators = $staffRepo->getVerificators();
$managers = $staffRepo->getManagers();
$types = $typesRepo->getAll();

if(isset($_REQUEST['search'])){ 
    $exampleWork = new Work();
    $exampleWork->setRequestNumber($_REQUEST['requestNumber']);
    $exampleWork->setAccountNumber($_REQUEST['accountNumber']);
    $exampleWork->setStandartType($_REQUEST['standartType']);
    
    if($_REQUEST['typeId'] != ""){
        $exDevice = new Device($types[$_REQUEST['typeId']]);
        $exampleWork->setDevice($exDevice);
    }       
    
    $exManager = $staffRepo->getById($_REQUEST['managerId']);
    $exampleWork->setManager($exManager);
    $exVarificator = $staffRepo->getById($_REQUEST['verificatorId']);
    $exampleWork->setVerificator($exVarificator);
    $works = $workRepo->getByExample($exampleWork);
}
else{
    $works = $workRepo->getAll();
}

include "./templates/main.php";


