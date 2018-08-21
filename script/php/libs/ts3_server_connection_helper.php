<?php
	include("./login_config.php");
  require_once("./libs/ts3phpframework/libraries/TeamSpeak3/TeamSpeak3.php");
  require_once("./messageHandler.php");

  class ts3Server {
    private $username = "ServerQuery";
    private $password = "ATJSH+fE";
    private $host = "37.120.184.91";
    private $port = "9987";
    private $queryport = "10011";
    public $adminGroupId = "6";
    public $moderatorGroupId = "12";
    public $memberGroupId = "7";
    private $ts3connection = null;
    public $error = null;

    public function __construct(){
      $server = null;
      try
      {
        $server = TeamSpeak3::factory("serverquery://".$this->username.":".$this->password."@".$this->host.":".$this->queryport."/?server_port=".$this->port."#no_query_clients");
      }
      catch (TeamSpeak3_Adapter_ServerQuery_Exception $e)
      {
    		$this->error = new response("502", "Unable to connect to query");
    		$this->error->addErrorMessage($e);
      }
      catch (TeamSpeak3_Exception $e)
      {
        $this->error = new response("500", "Internal server error");
    		$this->error->addErrorMessage($e);
      }
      catch (Exception $e)
      {
    		$this->error = new response("400", "Bad Request");
    		$this->error->addErrorMessage($e);
      }
      finally{
        $this->ts3connection = $server;
        return $server == null;
      }
    }

    public function getAdminGroup(){
      return $this->adminGroupId;
    }

    public function getModeratorGroup(){
      return $this->moderatorGroupId;
    }

    public function getMemberGroup(){
      return $this->memberGroupId;
    }

    public function getError(){
      return $this->error;
    }

    public function getServerConnection(){
      return $this->ts3connection;
    }
  }
?>
