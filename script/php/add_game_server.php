<?php
  include("./libs/game_server_helper.php");
  include("./login_config.php");
	include("./libs/generate_key.php");

  try{
    if(isset($_POST) && !empty($_POST["server_host"]) && !empty($_POST["server_port"]) && !empty($_POST["server_config_type"]))
    {
      ($_POST["server_config_type"] == "2" ? $version = $_POST["server_version"] : $version = NULL);
      $server = new ServerHelper($_POST["server_host"], $_POST["server_port"], $_POST["server_config_type"], $version);

      if($server->isConnected()){
        $key = helper::getKey(10);
        $statement = $pdo->prepare("INSERT INTO gameserverconfig (host, port, type, version, uid) VALUES (:host, :port, :type, :version, :key)");
        $statement->execute(array("host" => $_POST["server_host"], "port" => $_POST["server_port"], "type" => $_POST["server_config_type"], "version" => $version, "key" => $key));
        $res = new response("200", "Server added");
      }
      else {
        $res = new response("400", "No server found");
      }
    }
    else {
      $res = new response("400", "Missing parameters");
    }
  }
  catch(Exception $e){
    $res = new response("500", "Internal server error");
    $res->addErrorMessage($e);
  }

  echo $res->getJSON();
?>
