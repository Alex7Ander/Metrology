<?php
class Device{

    private $id;
    private $deviceType; 
    private $serialNumber;
    private $prodYear;

    public function __construct($deviceType, $serialNumber = 0, $prodYear = 0){
        $this->deviceType = $deviceType; 
        $this->serialNumber = $serialNumber;
        $this->prodYear = $prodYear;
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
    public function getProdYear(){
        return $this->prodYear;
    }
    public function setProdYear($prodYear){
        $this->prodYear = $prodYear;
    }
}