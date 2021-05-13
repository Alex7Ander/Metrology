<?php
class Work{

    private $id;
    
    private $device;
    private $requestNumber;
    private $accountNumber;
    
    private $workIndex;
    private $verificationDate;
    private $etalonType;
    private $temperature; 
    private $humidity; 
    private $preasure;
    private $protocolLink;
    private $documentLink; 
    private $verificator;
    private $manager;
    
    public function __construct($device, $requestNumber, $accountNumber){
        $this->device = $device;
        $this->requestNumber = $requestNumber;
        $this->accountNumber = $accountNumber;
    }

    public function getDevice(){
        return $this->device;
    }
    public function getRequestNumber(){
        return $this->requestNumber;
    }
    public function getAccountNumber(){
        return $this->accountNumber;
    }

    public function getId(){
        return $this->id;
    }
    public function setId($id){
        $this->id = $id;
    }

    public function getWorkIndex(){
        return $this->workIndex;
    }
    public function setWorkIndex($index){
        $this->workIndex = $index;
    }

    public function getVerificationDate(){
        return $this->verificationDate;
    }
    public function setVerificationDate($verificationDate){
        $this->verificationDate = $verificationDate;
    }
    
    public function getEtalonType(){
        return $this->etalonType;
    }
    public function setEtalonType($etalonType){
        $this->etalonType = $etalonType;
    }

    public function getTemperature(){
        return $this->temperature;
    }
    public function setTemperature($temperature){
        $this->temperature=$temperature;
    }

    public function getHumidity(){
        return $this->humidity;
    }
    public function setHumidity($humidity){
        $this->humidity =$humidity;
    }

    public function getPreasure(){
        return $this->preasure;
    }
    public function setPreasure($preasure){
        $this->preasure = $preasure;
    }

    public function getVerificator(){
        return $this->verificator;
    }
    public function setVerificator($verificator){
        $this->verificator = $verificator;
    }
    
    public function getManager(){
        return $this->manager;
    }
    public function setManager($manager){
        $this->manager = $manager;
    }

    public function getProtocolLink(){
        return $this->protocolLink;
    }
    public function setProtocolLink($protocolLink){
        $this->protocolLink = $protocolLink;
    }

    public function getDocumentLink(){
        return $this->documentLink;
    }
    public function setDocumentLink($documentLink){
        $this->documentLink = $documentLink;
    }

}
?>