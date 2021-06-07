<?php
require_once 'connection_config.php';

function removeUploadedFile($index, $to){
    $uploadedFileRealName = $_FILES[$index]['name'];
    $uploadedFileRealName = uniqid(rand()) . "_" . str_replace(" ", "_", $uploadedFileRealName);
    if (move_uploaded_file($_FILES[$index]['tmp_name'], $to . $uploadedFileRealName)) {
        return $to . $uploadedFileRealName;
    }
    return null;
}

class Uploader{
    
    private $token;
    
    public function __construct($token){
        $this->token = $token;
    }
    
    public function getContent($path){
        $fields = '_embedded.items.name,_embedded.items.type';        
        $ch = curl_init('https://cloud-api.yandex.net/v1/disk/resources?path=' . urlencode($path) . '&fields=' . $fields);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: OAuth ' . $this->token));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $res = curl_exec($ch);
        curl_close($ch);
        return $res;
    }
    
    public function createFolder($path){       
        $ch = curl_init('https://cloud-api.yandex.net/v1/disk/resources/?path=' . urlencode($path));
        curl_setopt($ch, CURLOPT_PUT, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: OAuth ' . $this->token));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $res = curl_exec($ch);
        curl_close($ch);
        return $res;
    }
    
    public function uploadFile($pathFrom, $pathTo){
        //Sending GET request for getting uploding url
        $baseName = basename($pathFrom);        
        $ch = curl_init('https://cloud-api.yandex.net/v1/disk/resources/upload?path=' . urlencode($pathTo . $baseName));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: OAuth ' . $this->token));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $res = curl_exec($ch);
        curl_close($ch);        
        $res = json_decode($res, true);
        var_dump($res);        
        if (!empty($res['error'])) {
            throw new Exception();
        }
        //If there is no errors sending file by url
        $fp = fopen($pathFrom, 'r');        
        $ch = curl_init($res['href']);
        curl_setopt($ch, CURLOPT_PUT, true);
        curl_setopt($ch, CURLOPT_UPLOAD, true);
        curl_setopt($ch, CURLOPT_INFILESIZE, filesize($pathFrom));
        curl_setopt($ch, CURLOPT_INFILE, $fp);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);            
        if ($http_code == 201) {
            return true;
        } 
    }
    
    public function delete($path){
        echo "$path<br>";
        $ch = curl_init('https://cloud-api.yandex.net/v1/disk/resources?path=' . urlencode($path) . '&permanently=true');        
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');        
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: OAuth ' . $this->token));        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);        
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);        
        curl_setopt($ch, CURLOPT_HEADER, false);       
        $res = curl_exec($ch);        
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE); 
        curl_close($ch);
        if (!(in_array($http_code, array(202, 204)))) {            
            throw new Exception();
        }
        return true;
    }
    
}

?>