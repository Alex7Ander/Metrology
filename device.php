<?php
class Device{

    private $id;
    private $deviceGroup;
    private $deviceType; 
    private $serialNumber;
    private $stateRegisterNumber;

    public function __construct($deviceGroup, $deviceType, $serialNumber, $stateRegisterNumber){
        $this->deviceGroup = $deviceGroup;
        $this->deviceType = $deviceType; 
        $this->serialNumber = $serialNumber;
        $this->stateRegisterNumber = $stateRegisterNumber;
    }

    public function __toString(){
        return $this->deviceGroup . " " . $this->deviceType . " №" . $this->serialNumber . " (номер в гос реестре " . $this->stateRegisterNumber . ")";
    }

    public function setId($id){
        $this->id = $id;
    }
    public function getId(){
        return $this->id;
    }
    public function getDeviceGroup(){
        return $this->deviceGroup;
    }
    public function getDeviceType(){
        return $this->deviceType;
    }
    public function getSerialNumber(){
        return $this->serialNumber;
    }
    public function getStateRegisterNumber(){
        return $this->stateRegisterNumber;
    }

}
?>