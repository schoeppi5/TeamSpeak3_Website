<?php
  include("./login_config.php");
  include("./messageHandler.php");

  $statement = $pdo->query("SELECT name, uid FROM gameserverconfig");

  $res = new response("200", "Servers fetched");

  $servers = array();

  while($array = $statement->fetch(PDO::FETCH_ASSOC)){
    $servers = array_merge($servers, array($array["uid"] => $array["name"]));
  }

  $res->mergeSubArray($servers, "servers");

  echo $res->getJSON();
?>
