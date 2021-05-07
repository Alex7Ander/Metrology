<?php
require_once "worker.php";
class workerRepository{
    
    private $link;

    public function __construct($host, $user, $password, $database){
        $this->link = mysqli_connect($host, $user, $password, $database) or die("Error: creation object of workerRepository class failed " . mysqli_error($link));
        mysqli_set_charset($this->link, 'utf8');
    }

    public function getAll(){
        $query = "SELECT * FROM staff";
        $result = mysqli_query($this->link, $query) or die("Error: execution of: $query -  failde " . mysqli_error($this->link));  
        return $this->getWorkersFromResult($result);
    }

    public function getVerificators(){
        $query = "SELECT * FROM staff WHERE verificator_status = TRUE";
        $result = mysqli_query($this->link, $query) or die("Error: execution of: $query -  failde " . mysqli_error($this->link));
        return $this->getWorkersFromResult($result);
    }

    public function getManagers(){
        $query = "SELECT * FROM staff WHERE manager_status = TRUE";
        $result = mysqli_query($this->link, $query) or die("Error: execution of: $query -  failde " . mysqli_error($this->link));
        return $this->getWorkersFromResult($result);
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