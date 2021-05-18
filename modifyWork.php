<?php
require 'connection_config.php';
require 'work.php';
require 'workRepository.php';

$id = $_POST["id"];
$t = $_POST["t"];
$p = $_POST["p"];
$h = $_POST["h"];
$workRepo = new WorkRepository($host, $user, $password, $database);
$work = $workRepo->getById($id);
$work->setTemperature($t);
$work->setPreasure($p);
$work->setHumidity($h);
$workRepo->modify($work);

//files uploading
$uploadedProtocolRealName = $_FILES['protocol']['name'];
echo "uploadedProtocolRealName = $uploadedProtocolRealName <br>";
$uploadedDocumentRealName = $_FILES['document']['name'];
echo "uploadedDocumentRealName = $uploadedDocumentRealName <br>";

$uploadPath = "/home/alex/uploads/";
echo "uploadPath = $uploadPath ";

if (move_uploaded_file($_FILES['protocol']['tmp_name'], $uploadPath . $uploadedProtocolRealName)) {
    echo "Протокол успешно загружен <br>";
} 
if (move_uploaded_file($_FILES['document']['tmp_name'], $uploadPath . $uploadedDocumentRealName)) {
    echo "Документ успешно загружен <br>";
}


?>