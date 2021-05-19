<?php
require 'connection_config.php';
require 'work.php';
require 'workRepository.php';

$id = $_POST['id'];
$workRepo = new WorkRepository($host, $user, $password, $database);
$work = $workRepo->getById($id);
$workRepo->delete($work);
echo "<p>Задание успешно удалено</p>";
echo "<a href='main.php'>На главную</a>";
?>