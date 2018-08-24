<?php
  require_once("./libs/rcon/steam-condenser/steam-condenser.php");
  require_once("./libs/rcon/MinecraftPing.php");
  require_once("./libs/rcon/MinecraftPingException.php");
  require_once("./libs/rcon/MinecraftQuery.php");
  require_once("./libs/rcon/MinecraftQueryException.php");
  require_once("./messageHandler.php");

  use xPaw\MinecraftQuery;
	use xPaw\MinecraftQueryException;
	use xPaw\MinecraftPing;
	use xPaw\MinecraftPingException;

  error_reporting(E_ERROR);

  class ServerHelper {

    private $server = null;
    private $type = null;
    private $version = null;

    //type: 1 = sourceServer | 2 = Minecraft
    public function __construct($host, $port, $type = 1, $version = NULL){
      $this->type = $type;
      if($type == 1){
        try{
          $this->server = new SourceServer((string)$host, (int)$port);
          $this->server->initialize();
        }
        catch(Exception $e){
          echo $e->getMessage();
        }
      }
      else {
        $this->version = $version;
        try{
          $this->server = new MinecraftPing($host, $port);
        }
        catch(MinecraftPingException $e){
        }
      }
    }

    public function queryServerInfo(){
      if($this->type == 1){
        try{
          $serverinfo = $this->server->getServerInfo();
          $res = new response("200", "Server queried successfully");
          $res->mergeArray(array("serverinfo" => $serverinfo));
        }
        catch(Exception $e){
          $res = new response("500", "Internal server error");
          $res->addErrorMessage($e);
        }
      }
      else {
        if($this->version == 16){
          try{
            $serverinfo = $this->server->QueryOldPre17();
            $res = new response("200", "Server queried successfully");
            $res->mergeArray(array("serverinfo" => $serverinfo));
          }
          catch(Exception $e){
            $res = new response("500", "Internal server error");
            $res->addErrorMessage($e);
          }
        }
        else {
          try{
            $serverinfo = $this->server->Query();
            $res = new response("200", "Server queried successfully");
            $res->mergeArray(array("serverinfo" => $serverinfo));
          }
          catch(Exception $e){
            $res = new response("500", "Internal server error");
            $res->addError($e);
          }
        }
      }

      return $res;
    }

    public function isConnected(){
      return $this->server !== null;
    }
  }
?>
