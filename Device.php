<?php
class Device{

    private $id;
    private $deviceType; 
    private $serialNumber;

    public function __construct($deviceType, $serialNumber){
        $this->deviceType = $deviceType; 
        $this->serialNumber = $serialNumber;
    }

    public function __toString(){
        return $this->deviceType . " № " . $this->serialNumber;
    }
        
    public function getId(){
        return $this->id;
    }
    public function setId($id){
        $this->id = $id;
    }
    public function getDeviceType(){
        return $this->deviceType;
    }
    public function setDeviceType($type){
        $this->deviceType = $type;
    }
    public function getSerialNumber(){
        return $this->serialNumber;
    }
    public function setSerialNumber($serialNumber){
        $this->serialNumber = $serialNumber;
    }
}
?>