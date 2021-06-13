<?php
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
    
    //Uploading files to yandex disk
    //$pathFrom - path (full) to the file on the server where the script is running
    //$fileName - name, which should be used on yandex disk
    //$pathTo - target folder on yandex disk
    public function uploadFile($pathFrom, $fileName, $pathTo){
        //Sending GET request for getting uploding url        
        $ch = curl_init('https://cloud-api.yandex.net/v1/disk/resources/upload?path=' . urlencode($pathTo . $fileName));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: OAuth ' . $this->token));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $res = curl_exec($ch);
        curl_close($ch);        
        $res = json_decode($res, true);        
        if (!empty($res['error'])) {
            throw new Exception($res['error']);
        }
        //If there is no errors - sending file by url
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
    
    public function getDownloadingLink($ydPath){       
        $ch = curl_init('https://cloud-api.yandex.net/v1/disk/resources/download?path=' . urlencode($ydPath));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: OAuth ' . $this->token));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $res = curl_exec($ch);
        curl_close($ch);        
        $res = json_decode($res, true);
        if (!(empty($res['error']))) {
            throw new Exception($res['error']);
        }
        return $res['href'];
    }
    
    public function delete($path){
        echo "$path<br>";
        $ch = curl_init('https://cloud-api.yandex.net/v1/disk/resources?path=' . urlencode($path) . '&permanently=true');        
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');        
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: OAuth ' . $this->token));        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);        
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);        
        curl_setopt($ch, CURLOPT_HEADER, false);       
        curl_exec($ch);        
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE); 
        curl_close($ch);
        if (!(in_array($http_code, array(202, 204)))) {            
            throw new Exception();
        }
        return true;
    }
    
}

?>