<?php
  class response {
    private $res = null;

    public function __construct($status, $message){
      $this->res = array("status" => $status, "message" => $message);
    }

    public function addErrorMessage($errormessage){
      if(gettype($errormessage) == "string"){
        $this->res = array_merge($this->res, array("errormsg" => $errormessage));
      }
      else {
        $this->res = array_merge($this->res, array("errormsg" => $errormessage->getMessage()));
      }
    }

    public function add($key, $value){
      $this->res = array_merge($this->res, array($key => $value));
    }

    public function mergeArray($array){
      $this->res = array_merge($this->res, $array);
    }

    public function getJSON(){
      return json_encode($this->res);
    }
  }
?>
