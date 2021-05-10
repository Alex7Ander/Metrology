<?php
require_once "worker.php";
class workerRepository{
    
    private $mysqli;

    public function __construct($host, $user, $password, $database){
        $this->mysqli = new mysqli($host, $user, $password, $database);
        if ($this->mysqli->connect_error) {
            die("Error: creation object of workerRepository class failed (" . $this->mysqli->connect_errno . " - ". $this->mysqli->connect_error . ")");
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
            $worker = new Worker($id, $name, $surname, $patronimyc);
            $workers[] = $worker;
        }
        return $workers;
    }    

}
?>