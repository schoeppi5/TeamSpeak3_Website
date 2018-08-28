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

    private $host = null;
    private $port = null;
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
          $this->host = $host;
          $this->port = $port;
        }
        catch(Exception $e){
          echo $e->getMessage();
        }
      }
      else {
        $this->version = $version;
        try{
          $this->server = new MinecraftPing($host, $port);
          $this->host = $host;
          $this->port = $port;
        }
        catch(MinecraftPingException $e){
        }
      }
    }

    public function queryServerInfo(){
      if($this->type == 1){
        try{
          $res = array("serverinfo" => $this->formatServerInfo($this->server->getServerInfo()));
        }
        catch(Exception $e){
          $res = new response("500", "Internal server error");
          $res->addErrorMessage($e);
        }
      }
      else {
        if($this->version == 16){
          try{
            $res = array("serverinfo" => $this->formatServerInfo($this->server->QueryOldPre17()));
          }
          catch(Exception $e){
            $res = new response("500", "Internal server error");
            $res->addErrorMessage($e);
          }
        }
        else {
          try{
            $res = array("serverinfo" => $this->formatServerInfo($this->server->Query()));
          }
          catch(Exception $e){
            $res = new response("500", "Internal server error");
            $res->addError($e);
          }
        }
      }

      return $res;
    }

    public function formatServerInfo($info){
      if($this->type == 1){
        $res = array(
                    "name" => $info["serverName"],
                    "host" => $this->host,
                    "port" => $this->port,
                    "player" => $info["numberOfPlayers"],
                    "maxplayer" => $info["maxPlayers"],
                    "gamedesc" => $info["gameDesc"],
                    "connectlink" => "steam://connect/" . $this->host . ":" . $this->port,
                    "version" => $info["gameVersion"]);
      }
      else {
        $res = array(
                    "name" => "Minecraft-Server (" . $this->host . ":" . $this->port . ")",
                    "host" => $this->host,
                    "port" => $this->port,
                    "player" => $info["players"]["online"],
                    "maxplayer" => $info["players"]["max"],
                    "gamedesc" => $info["description"]["text"],
                    "version" => $info["version"]["name"]);
      }

      return $res;
    }

    public function isConnected(){
      return $this->server !== null;
    }
  }
?>
