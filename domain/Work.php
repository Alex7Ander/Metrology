<?php
class Work{

    private $id;
    
    private $device;
    private $requestNumber;
    private $accountNumber;
    
    private $workIndex;
    private $verificationDate;
    private $standartType;
    private $temperature; 
    private $humidity; 
    private $preasure;
    private $protocolLink;
    private $documentLink; 
    private $verificator;
    private $manager;
    
    private $taken;
    private $measured;
    private $processed;
    private $metrologyClosed;
    private $documentNumber;
    private $documentPrinted;
    private $givenAway;
    
    public function __toString(){
        return $this->id . " счет " . $this->accountNumber . " заявка " . $this->requestNumber . " прибор " .  $this->device; 
    }    
    public function getId(){
        return $this->id;
    }
    public function setId($id){
        $this->id = $id;
    }
    public function getDevice(){
        return $this->device;
    }
    public function setDevice($device){
        $this->device = $device;
    }
    public function getRequestNumber(){
        return $this->requestNumber;
    }
    public function setRequestNumber($requestNumber){
        $this->requestNumber = $requestNumber;
    }
    public function setAccountNumber($accountNumber){
        $this->accountNumber = $accountNumber;
    }
    public function getAccountNumber(){
        return $this->accountNumber;
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
    public function getStandartType(){
        return $this->standartType;
    }
    public function setStandartType($standartType){
        $this->standartType = $standartType;
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
    public function getDocumentNumber(){
        return $this->documentNumber;
    }
    public function setDocumentNumber($number){
        $this->documentNumber = $number;
    }
    public function isTaken(){
        return $this->taken;
    }
    public function setTaken($taken){
        $this->taken = $taken;
    }
    public function isMeasured(){
        return $this->measured;
    }
    public function setMeasured($measured){
        $this->measured = $measured;
    }
    
    public function isProcessed(){
        return $this->processed;
    }
    public function setProcessed($processed){
        $this->processed = $processed;
    }
    public function isMetrologyClosed(){
        return $this->metrologyClosed;
    }
    public function setMetrologyClosed($metrologyClosed){
        $this->metrologyClosed = $metrologyClosed;
    }   
    public function isDocumentPrinted(){
        return $this->documentPrinted;
    }
    public function setDocumentPrinted($documentPrinted){
        $this->documentPrinted = $documentPrinted;
    }
    public function isGivenAway(){
        return $this->givenAway;
    }
    public function setGivenAway($givenAway){
        $this->givenAway = $givenAway;
    }    
}