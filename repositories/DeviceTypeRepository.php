<?php
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
            $id = $result->fetch_assoc()['id'];
            $type->setId($id);
            $result->close();
            $this->mysqli->commit();
        }
        catch(mysqli_sql_exception $exception){
            $this->mysqli->rollback();
            throw $exception;
        }
    }
    
    public function delete($type){
        if(!($type instanceof DeviceType)){
            die("Error: wrong type of parametr in method save (class DeviceTypeRepository)");
        }
        $this->mysqli->begin_transaction();
        try{
            $id = $type->getId();
            $query = "DELETE FROM device_types WHERE id='$id'";
            $this->mysqli->query($query);
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
    
    public function getById($id){
        $query = "SELECT COUNT(*) AS typesCount FROM device_types WHERE id='$id'";
        $result = $this->mysqli->query($query);
        $row = $result->fetch_assoc();
        $count = $row['typesCount'];
        if($count == 0){
            $result->close();
            return null;
        }
        $query = "SELECT * FROM device_types WHERE id='$id'";
        $result = $this->mysqli->query($query);
        $types = $this->getTypesFromResult($result);
        $type = $types[$id];
        $result->close();
        return $type;
    }
    
    private function getTypesFromResult($result){
        $types = [];
        foreach($result as $value){
            $type = new DeviceType();
            $id = $value['id'];
            $type->setId($id);
            $type->setName($value['name']);
            $type->setDesignation($value['designation']);
            $type->setStateNumber($value['state_number']);
            $types[$id] = $type;
        }
        return $types;
    }
}


?>
