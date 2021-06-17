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
    
    public function save(Staff $staff){
        $this->mysqli->begin_transaction();
        try{
            $query = "SELECT COUNT(*) AS staffCount FROM staff WHERE name='{$staff->getName()}' AND surname='{$staff->getSurname()}' AND patronimyc='{$staff->getPatronimyc()}'";
            $result = $this->mysqli->query($query);
            $row = $result->fetch_assoc();
            $count = $row['staffCount'];
            if($count > 0){
                throw new Exception("Пользователь с такими именем, фамилий и отчеством уже зарегитсрирован.");
            }
            $query = "INSERT INTO staff (name, surname, patronimyc, verificator_status, manager_status, pass, access_level)
                        VALUES ('{$staff->getName()}', '{$staff->getSurname()}', '{$staff->getPatronimyc()}', '{$staff->getVerificatorStatus()}', '{$staff->getManagerStatus()}', '{$staff->getPass()}', '{$staff->getAccessLevel()}')";
            $this->mysqli->query($query);
            $query = "SELECT id AS newId FROM staff WHERE name='{$staff->getName()}' AND surname='{$staff->getSurname()}' AND patronimyc='{$staff->getPatronimyc()}'";
            $result = $this->mysqli->query($query);
            $id = $result->fetch_assoc()['newId'];
            $staff->setId($id);
            $this->mysqli->commit();
        }
        catch(mysqli_sql_exception $exception){
            $this->mysqli->rollback();
            throw $exception;
        }        
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
            $worker = new Staff();
            $id = $value['id'];
            $worker->setId($id);
            $worker->setName($value['name']);
            $worker->setSurname($value['surname']);
            $worker->setPatronimyc($value['patronimyc']);
            $worker->setPass($value['pass']);
            $worker->setVerificatorStatus($value['verificator_status']);
            $worker->setManagerStatus($value['manager_status']);
            $worker->setAccessLevel($value['access_level']);
            $workers["$id"] = $worker;
        }
        return $workers;
    }    

}