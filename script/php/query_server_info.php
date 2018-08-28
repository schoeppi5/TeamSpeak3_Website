<?php
  include("./login_config.php");
  include("./messageHandler.php");
  include("./libs/game_server_helper.php");

  if(isset($_POST) && !empty($_POST["uid"])){
    $statement = $pdo->prepare("SELECT * FROM gameserverconfig WHERE uid = :uid");
    $statement->execute(array("uid" => $_POST["uid"]));
    $serverDB = $statement->fetch(PDO::FETCH_ASSOC);

    $res = new response("200", "Server fetched");
    $server = new ServerHelper($serverDB["host"], $serverDB["port"], $serverDB["type"], $serverDB["version"]);

    if($server->isConnected()){
      $res->mergeArray($server->queryServerInfo());
    }
    else {
      $res = new response("500", "Unable to connect to server");
    }
  }
  else {
    $res = new response("400", "Bad request");
  }

  echo $res->getJSON();
?>
