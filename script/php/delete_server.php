<?php
  include("login_config.php");
  include("messageHandler.php");

  if(isset($_POST) && !empty($_POST["uid"])){
    $statement = $pdo->prepare("DELETE FROM gameserverconfig WHERE uid = :uid");
    if($statement->execute(array("uid" => $_POST["uid"]))){
      $res = new response("200", "Server deleted");
    }
    else {
      $res = new response("500", "Unable to delete server");
    }
  }else {
    $res = new response("400", "Bad request");
  }

  echo $res->getJSON();
?>
