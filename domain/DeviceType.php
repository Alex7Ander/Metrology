<?php
class DeviceType{
    
    private $id;
    private $name;
    private $designation;
    private $stateNumber;
    
    public function __toString(){
        return $this->name . " " . $this->designation;  
    }
    
    public function getId(){
        return $this->id;
    }
    public function setId($id){
        $this->id = $id;
    }
    public function getName(){
        return $this->name;
    }
    public function setName($name){
        $this->name = $name;
    }
    public function getDesignation(){
        return $this->designation;
    }
    public function setDesignation($designation){
        $this->designation = $designation;
    }    
    public function getStateNumber(){
        return $this->stateNumber;
    }
    public function setStateNumber($stateNumber){
        $this->stateNumber = $stateNumber;
    }
}