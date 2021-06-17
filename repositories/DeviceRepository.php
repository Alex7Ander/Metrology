<?php
class DeviceRepository{

    private $mysqli;
    private $deviceTypeRepo;
    
    public function __construct($host, $user, $password, $database){
        $this->mysqli = new mysqli($host, $user, $password, $database);
        if ($this->mysqli->connect_error) {
            die("Error: creation object of deviceRepository class failed (" . $this->mysqli->connect_errno . " - ". $this->mysqli->connect_error . ")");
        }
        $this->deviceTypeRepo = new DeviceTypeRepository($host, $user, $password, $database);
        $this->mysqli->set_charset('utf8');
    }

    public function save(Device $device){
        $this->mysqli->begin_transaction();
        try{
            $currentType = $device->getDeviceType();
            $currentSerialNumber = $device->getSerialNumber();
            $query = "SELECT COUNT(*) AS deviceCount FROM devices WHERE device_type_id='{$currentType->getId()}' AND serial_number='$currentSerialNumber'";            
            $result = $this->mysqli->query($query);           
            $row = $result->fetch_assoc();      
            $count = $row['deviceCount'];
            if($count > 0){
                throw new Exception("Прибор данного типа с таким серийным номером уже существует!");
            }
            $query = "INSERT INTO devices (device_type_id, serial_number) VALUES ('{$currentType->getId()}', '$currentSerialNumber')";
            $result = $this->mysqli->query($query);            
            $query = "SELECT id AS newId FROM devices WHERE device_type_id='{$currentType->getId()}' AND serial_number='$currentSerialNumber'";
            $result = $this->mysqli->query($query);            
            $id = $result->fetch_assoc()['newId'];
            $device->setId($id);
            $result->close();
            $this->mysqli->commit();
        }
        catch (mysqli_sql_exception $exception) {
            $this->mysqli->rollback();       
            throw $exception;
        }                  
    }
    
    public function delete($device){
        if(!($device instanceof Device)){
            die("Error: wrong type of parametr in method save (class DeviceRepository)");
        }
        $this->mysqli->begin_transaction();
        try{
            $id = $device->getId();
            $query = "DELETE FROM devices WHERE id = '$id'";
            $this->mysqli->query($query);
            $this->mysqli->commit();
        }
        catch(mysqli_sql_exception $exception){
            $this->mysqli->rollback();
            throw $exception;
        }
    }
    
    public function isExists($device){
        $query = "SELECT COUNT(*) AS deviceCount FROM devices WHERE device_type_id = '{$device->getDeviceType()->getId()}' 
                                                                AND serial_number = '{$device->getSerialNumber()}'";
        $result = $this->mysqli->query($query);
        $row = $result->fetch_assoc();
        $count = $row['deviceCount'];
        if($count > 0){
            return true;
        }
        return false;
    }

    public function getAll(){
        $query = "SELECT * FROM devices";
        $result = $this->mysqli->query($query);
        $devices = $this->getDevicesFromResult($result);
        $result->close();
        return $devices;
    }

    public function getById($id){
        $query = "SELECT COUNT(*) AS devCount FROM devices WHERE id='$id'";
        $result = $this->mysqli->query($query);
        $row = $result->fetch_assoc();
        $count = $row['devCount'];
        if($count == 0){
            $result->close();
            return null;
        }
        $query = "SELECT * FROM devices WHERE id='$id'";
        $result = $this->mysqli->query($query);
        $devices = $this->getDevicesFromResult($result);
        $result->close();
        $device = $devices["$id"];
        return $device;
    }
    
    public function getByTypeAndSerialNumber($type, $serialNumber){
        $query = "SELECT COUNT(*) AS devCount FROM devices WHERE device_type_id='{$type->getId()}' AND serial_number='$serialNumber'";
        $result = $this->mysqli->query($query);
        $row = $result->fetch_assoc();
        $count = $row['devCount'];
        if($count == 0){
            $result->close();
            return null;
        }
        $query = "SELECT * FROM devices WHERE device_type_id='{$type->getId()}' AND serial_number='$serialNumber'";
        $result = $this->mysqli->query($query);
        $devices = $this->getDevicesFromResult($result);
        $result->close();
        return current($devices);
    }

    private function getDevicesFromResult($result){
        $devices = [];
        foreach($result as $value){
            $id = $value['id'];
            $typeId = $value['device_type_id'];
            $serialNumber = $value['serial_number'];
            $deviceType = $this->deviceTypeRepo->getById($typeId);            
            $device = new Device($deviceType, $serialNumber);
            $device->setId($id);
            $devices["$id"] = $device;
        }
        return $devices;
    }


}
?>