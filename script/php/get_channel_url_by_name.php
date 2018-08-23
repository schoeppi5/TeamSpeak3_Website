<?php
  include("./libs/ts3_server_connection_helper.php");

  $server = new ts3Server();
  if($server->getServerConnection() && (isset($_POST["name"]) && !empty($_POST["name"]))){
    $res = new response("200", "ts3server://".$server->getHost().
    "?port=".$server->getPort()."&cid=".$server->getChannelByName($_POST["name"])->cid);
  }
  else {
    $res = new response("404", "Channel not found");
  }

  echo $res->getJSON();
?>
