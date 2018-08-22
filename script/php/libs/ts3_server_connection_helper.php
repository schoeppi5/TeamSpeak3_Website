<?php
	include("./login_config.php");
  require_once("./libs/ts3phpframework/libraries/TeamSpeak3/TeamSpeak3.php");
  require_once("./messageHandler.php");

  class ts3Server {
    private $username = "";
    private $password = "";
    private $host = "";
    private $port = "";
    private $queryport = "";
    public $adminGroupId = "";
    public $moderatorGroupId = "";
    public $memberGroupId = "";
    private $ts3connection = null;
    public $error = null;

    public function __construct(){
			global $pdo;
			$statement = $pdo->query("SELECT * FROM tsconfig")->fetch();
			$this->username = $statement["username"];
			$this->password = $statement["password"];
			$this->host = $statement["host"];
			$this->port = $statement["port"];
			$this->queryport = $statement["queryport"];
			$this->adminGroupId = $statement["admingroup"];
			$this->moderatorGroupId = $statement["moderatorgroup"];
			$this->memberGroupId = $statement["membergroup"];
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
			global $pdo;
			return $pdo->query("SELECT admingroup FROM tsconfig")->fetch()["admingroup"];
    }

    public function getModeratorGroup(){
			global $pdo;
			return $pdo->query("SELECT moderatorgroup FROM tsconfig")->fetch()["moderatorgroup"];
    }

    public function getMemberGroup(){
			global $pdo;
			return $pdo->query("SELECT membergroup FROM tsconfig")->fetch()["membergroup"];
    }

    public function getError(){
      return $this->error;
    }

    public function getServerConnection(){
      return $this->ts3connection;
    }
  }
?>
