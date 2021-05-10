<?php
class Work{

    private $id;
    private $workIndex; 
    private $etalonType;
    private $temperature; 
    private $humidity; 
    private $preasure;
    private $protocolLink;
    private $documentLink; 
    private $verificator;
    private $manager;

    public function getId(){
        return $this->id;
    }
    public function getWorkIndex(){
        return $this->workIndex;
    }
}
?>