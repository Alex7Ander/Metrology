<?php
class StaffRepository{
    
    private $mysqli;

    public function __construct($host, $user, $password, $database){
        $this->mysqli = new mysqli($host, $user, $password, $database);
        if ($this->mysqli->connect_error) {
            die("Error: creation object of StaffRepository class failed (" . $this->mysqli->connect_errno . " - ". $this->mysqli->connect_error . ")");
        }
        $this->mysqli->set_charset('utf8');
    }

    public function getAll(){
        $query = "SELECT * FROM staff";
        $result = $this->mysqli->query($query);      
        $workers = $this->getWorkersFromResult($result);
        $result->close();
        return $workers;
    }
    
    public function getWorkerById($id){
        $query = "SELECT COUNT(*) AS workersCount FROM staff WHERE id='$id'";
        $result = $this->mysqli->query($query);
        $row = $result->fetch_assoc();
        $count = $row['workersCount'];
        if($count == 0){
            $result->close();
            return null;
        }
        $query = "SELECT * FROM staff WHERE id = '$id'";
        $result = $this->mysqli->query($query);
        $workers = $this->getWorkersFromResult($result);
        $result->close();
        $worker = $workers["$id"];
        return $worker;
    }

    public function getVerificators(){
        $query = "SELECT * FROM staff WHERE verificator_status = TRUE";
        $result = $this->mysqli->query($query);
        $verificators = $this->getWorkersFromResult($result);
        $result->close();
        return $verificators;
    }

    public function getManagers(){
        $query = "SELECT * FROM staff WHERE manager_status = TRUE";
        $result = $this->mysqli->query($query);
        $managers = $this->getWorkersFromResult($result);
        $result->close();
        return $managers;
    }

    private function getWorkersFromResult($result){
        $workers = [];
        foreach($result as $value){
            $id = $value['id'];
            $name = $value['name'];
            $surname = $value['surname'];
            $patronimyc = $value['patronimyc'];
            $pass = $value['pass'];
            $isverificator = $value['verificator_status'];
            $ismanager = $value['manager_status'];
            $worker = new Staff($id, $name, $surname, $patronimyc);
            $worker->setPass($pass);
            $worker->setVerificatorStatus($isverificator);
            $worker->setManagerStatus($ismanager);
            $workers["$id"] = $worker;
        }
        return $workers;
    }    

}