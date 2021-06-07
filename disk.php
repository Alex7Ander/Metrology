<?php
require_once 'connection_config.php';
require_once 'Uploader.php';

$yandexDiskToken = "";
$uploader = new Uploader($yandexDiskToken);
//Getting content of the folder
$res = $uploader->getContent("/ApplicationsFolder/Metrology");
var_dump($res);

if(isset($_REQUEST['create_folder'])){
    $newFolderFullPath = "/ApplicationsFolder/Metrology/" . $_REQUEST['folder_name'];
    $res = $uploader->createFolder($newFolderFullPath);
    var_dump($res);
}

if(isset($_REQUEST['upload_file'])){
    $uploadedFileRealName = $_FILES['doc']['name'];
    $uploadedFileRealName = uniqid(rand()) . "_" . str_replace(" ", "_", $uploadedFileRealName);
    if (move_uploaded_file($_FILES['doc']['tmp_name'], $recordUploadPath . $uploadedFileRealName)) {
        echo "Файл загружен локально<br>";
        try{
            $uploader->uploadFile($recordUploadPath . $uploadedFileRealName, "/ApplicationsFolder/Metrology/" . $uploadedFileRealName);
        }
        catch(Exception $exception){
            echo "$exception";
        }       
    }
}

if(isset($_REQUEST['delete'])){
    $path = $_REQUEST['path'];
    $uploader->delete($path);
}
?>
<br>
<form method='POST' action='disk.php'>
	<input type='text' name='folder_name'><br>
	<input type='submit' name='create_folder' value='Создать папку'>
</form>
<br>
<form method='POST' action='disk.php' enctype='multipart/form-data'>
	<input type='file' name='doc'>
	<input type='submit' name='upload_file' value='Загрузить файл'>
</form>
<br>
<form method='POST' action='disk.php'>
	<input type='text' name='path'>
	<input type='submit' name='delete' value='Удалить'>
</form>













