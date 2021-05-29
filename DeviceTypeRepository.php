<?php
require_once 'DeviceType.php';

class StateNumberAlreadyUsedException extends Exception {
    public function __construct(){
        $this->message = "Тип средства измерения с данным государственным регистриционным номером в ФИФ уже существует";
    }
}

class DeviceTypeAlreadyExistingException extends Exception {
    public function __construct($type){
        $this->message = "Данный тип средства измерения: $type - уже зарегистрирован";
    }
}

class DeviceTypeRepository
{
    private $mysqli;
    
    public function __construct($host, $user, $password, $database){
        $this->mysqli = new mysqli($host, $user, $password, $database);
        if($this->mysqli->connect_error){
            die("Error: creation object of deviceRepository class failed (" . $this->mysqli->connect_errno . " - ". $this->mysqli->connect_error . ")");
        }
        $this->mysqli->set_charset('utf8');
    }
    
    public function save($type){
        if(!($type instanceof DeviceType)){
            die("Error: wrong type of parameter in method save (class DeviceTypeRepository)");
        }        
        $currentName = $type->getName();
        $currentDesignation = $type->getDesignation();
        $currentStateNumber = $type->getStateNumber();         
        $this->mysqli->begin_transaction();
        try{
            $query = "SELECT COUNT(*) AS typesCount FROM device_types  WHERE name='$currentName' AND designation='$currentDesignation' AND state_number='$currentStateNumber'";
            $result = $this->mysqli->query($query);
            $row = $result->fetch_assoc();
            $count = $row['typesCount'];
            if($count > 0){
                throw new DeviceTypeAlreadyExistingException($type);
            }
            $query = "INSERT INTO device_types (name, designation, state_number) VALUES ('$currentName', '$currentDesignation', '$currentStateNumber')";
            $this->mysqli->query($query);           
            $query = "SELECT id FROM device_types WHERE name='$currentName' AND designation='$currentDesignation' AND state_number='$currentStateNumber'";
            $result = $this->mysqli->query($query);
            $id = $result->fetch_assoc()['newId'];
            $type->setId($id);
            $result->close();
            $this->mysqli->commit();
        }
        catch(mysqli_sql_exception $exception){
            $this->mysqli->rollback();
            throw $exception;
        }
    }
    
    public function getAll(){
        $query = "SELECT * FROM device_types";
        $result = $this->mysqli->query($query);
        $types = $this->getTypesFromResult($result);
        return $types;
    }
    
    private function getTypesFromResult($result){
        $types = [];
        foreach($result as $value){
            $type = new DeviceType();
            $type->setId($value['id']);
            $type->setType($value['name']);
            $type->setDesignation($value['designation']);
            $type->setStateNumber($value['state_number']);
            $types[$type->getId()] = $type;
        }
        return $types;
    }
}


?>
