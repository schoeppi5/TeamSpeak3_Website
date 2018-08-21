<?php
  include("./messageHandler.php");
  include("./libs/ts3_server_connection_helper.php");
  include("./libs/db_user_helper.php");

  $uidPoked = $_POST["uid"];
  $msg = $_POST["msg"];
  $uidPoker = $_COOKIE["uid"];

  if(!isset($uidPoked)){
    $res = new response("400", "Bad request");
    $res->addErrorMessage("No uid submitted");
    die($res->getJSON());
  }

  if(!isset($uidPoker)){
    $res = new response("400", "Bad request");
    $res->addErrorMessage("No user logged in");
    die($res->getJSON());
  }

  try {
    $server = new ts3Server();
    if($server){
      $server->getServerConnection()->clientGetByUid($uidPoked)->poke(user::fetchTsUserWithId($uidPoker)->client_nickname . ($msg == "" ? " poked you" : ": ".$msg));
      $res = new response("200", "Client poked");
    }
    else {
      $res = $server->getError();
    }
  } catch (Exception $e) {
    $res = new response("500", "Internal server error");
    $res->addErrorMessage($e);
  }
  finally{
    echo $res->getJSON();
  }

?>
