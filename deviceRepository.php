<?php
require_once "device.php";
class deviceRepository{

    private $mysqli;

    public function __construct($host, $user, $password, $database){
        $this->mysqli = new mysqli($host, $user, $password, $database);
        if ($this->mysqli->connect_error) {
            die("Error: creation object of deviceRepository class failed (" . $this->mysqli->connect_errno . " - ". $this->mysqli->connect_error . ")");
        }
        $this->mysqli->set_charset('utf8');
    }

    public function save($device){
        if(!($device instanceof Device)){
            die("Error: wrong type of parametr in method save (class deviceRepository)");
        }
        echo "Start saving<br>Cheking such device existing<br>";

        $currentGroup = $device->getDeviceGroup();
        $currentType = $device->getDeviceType();
        $currentSerialNumber = $device->getSerialNumber();
        $currentStateRegisterNumber =  $device->getStateRegisterNumber();
        $query = "SELECT COUNT(*) FROM devices WHERE device_group='$currentGroup' AND device_type='$currentType' AND serial_number='$currentSerialNumber'";
        $result = $this->mysqli->query($query) or die("Error: execution of: $query -  failed " . mysqli_error($this->link));
        echo "$query<br>";
        echo "count = $result->num_rows <br>";
        if($result->num_rows > 0){
            echo "<b>Ошибка! Прибор данного типа с таким серийным номером уже существует!</b><br>";
            return;
        }
        $query = "INSERT INTO devices (device_group, device_type, serial_number, state_register_number) 
                    VALUES ('$currentGroup', '$currentType', '$currentSerialNumber', '$currentStateRegisterNumber')";
        $result = $this->mysqli->query($query) or die("Error: execution of: $query -  failed " . mysqli_error($this->link));
        $query = "SELECT id FROM devices WHERE device_group='$currentGroup' AND device_type='$currentType' AND serial_number='$currentSerialNumber'";
        $result = $this->mysqli->query($query) or die("Error: execution of: $query -  failed " . mysqli_error($this->link));
        $id = $result['id'];
        $device->setId($id);          
    }

    public function getAll(){
        $query = "SELECT * FROM devices";
        $result = $this->mysqli->query($this->link, $query) or die("Error: execution of: $query -  failed " . mysqli_error($this->link));
        $result->close();
    }


    private function getDevicesFromResult($result){
        $devices = [];
        foreach($result as $value){
            $id = $value['id'];
            $deviceGroup = $value['device_groups'];
            $deviceType = $value['device_type'];
            $serialNumber = $value['serial_number'];
            $stateRegisterNumber = $value['state_register_number'];
            $device = new Device($deviceGroup, $deviceType, $serialNumber, $stateRegisterNumber);
            $device->setId($id);
            $devices[] = $device;
        }
        return $devices;
    }
}
?>