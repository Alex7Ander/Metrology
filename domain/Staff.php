<?php 
class Staff{
    private $id;
    private $name;
    private $surname;
    private $patronimyc;
    private $verificatorStatus;
    private $managerStatus;
    private $pass;
    private $accessLevel;
    
    public function __toString(){
        return $this->getFullName();
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
    
    public function getSurname(){
        return $this->surname;
    }
    public function setSurname($surname){
        $this->surname = $surname;
    }
    
    public function getPatronimyc(){
        return $this->patronimyc;
    }
    public function setPatronimyc($patronimyc){
        $this->patronimyc = $patronimyc;
    }

    public function setVerificatorStatus($status){
        $this->verificatorStatus = $status;
    }
    public function getVerificatorStatus(){
        return $this->verificatorStatus;
    }

    public function setManagerStatus($status){
        $this->managerStatus = $status;
    }
    public function getManagerStatus(){
        return $this->managerStatus;
    }
    
    public function getPass(){
        return $this->pass;
    }
    public function setPass($pass){
        $this->pass = $pass;
    }
    
    public function getAccessLevel(){
        return $this->accessLevel;
    }
    public function setAccessLevel($accessLevel){
        $this->accessLevel = $accessLevel;
    }
    
    public function getFullName(){
        return $this->surname . " " . $this->name . " " . $this->patronimyc;
    }
}