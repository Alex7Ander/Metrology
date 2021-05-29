<?php
require_once 'connection_config.php';
require_once 'Work.php';
require_once 'WorkRepository.php';

$id = $_POST['id'];
$workRepo = new WorkRepository($host, $user, $password, $database);
$work = $workRepo->getById($id);
$workRepo->delete($work);
echo "<p>Задание успешно удалено</p>";
echo "<a href='main.php'>На главную</a>";
?>