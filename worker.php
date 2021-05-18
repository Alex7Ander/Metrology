<?php
class Worker{
    private $id;
    private $name;
    private $surname;
    private $patronimyc;
    private $verificatorStatus;
    private $managerStatus;

    public function __construct($id, $name, $surname, $patronimyc, $verificatorStatus=true, $managerStatus=false){
        $this->id = $id;
        $this->name = $name;
        $this->surname = $surname;
        $this->patronimyc = $patronimyc;
    }

    public function __toString(){
        $str = $this->getFullName() . " (id=" . $this->getId() . ")";
        return $str;
    }

    public function getId(){
        return $this->id;
    }

    public function getFullName(){
        return $this->surname . " " . $this->name . " " . $this->patronimyc;
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

}
?>