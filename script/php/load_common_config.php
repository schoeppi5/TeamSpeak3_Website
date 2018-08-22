<?php
  include("./messageHandler.php");
  include("./login_config.php");

  $array = $pdo->query("SELECT * FROM admin")->fetch();
  if(count($array) > 2){
    $res = new response("200", "Data queried");
    $res->mergeArray(array("common" =>array("username" => $array["username"])));
  }
  else {
    $res = new response("404", "No admin login found! Please reset your database here: /script/php/database_preparation.php");
  }

  echo $res->getJSON();
?>
