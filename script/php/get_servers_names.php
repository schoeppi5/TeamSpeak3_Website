<?php
  include("./login_config.php");
  include("./messageHandler.php");

  $statement = $pdo->query("SELECT name, uid FROM gameserverconfig");

  $servers = array();

  if($statement !== false){
    while($array = $statement->fetch(PDO::FETCH_ASSOC)){
      $servers = array_merge($servers, array($array["uid"] => $array["name"]));
    }

    $res = new response("200", "Servers fetched");
    $res->mergeSubArray($servers, "servers");
  }
  else {
    $res = new response("500", "SQL Error");
  }

  echo $res->getJSON();
?>
