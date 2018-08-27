<?php
  include("./login_config.php");
  include("./messageHandler.php");
  include("./libs/game_server_helper.php");

  $statement = $pdo->query("SELECT * FROM gameserverconfig");

  $res = new response("200", "Server fetched");

  $servers = array();

  while($array = $statement->fetch(PDO::FETCH_ASSOC)){
    $server = new ServerHelper($array["host"], $array["port"], $array["type"], $array["version"]);
    $serverinfo = $server->queryServerInfo();
    $serverinfo->add("host", $array["host"]);
    $servers = array_merge($servers, array($array["uid"] => $serverinfo->getJSON()));
  }

  $res->mergeSubArray($servers, "servers");

  echo $res->getJSON();
?>
