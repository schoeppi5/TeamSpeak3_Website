<?php
  include("./login_config.php");
  include("./messageHandler.php");

  if($pdo->query("SELECT * FROM tsconfig")->fetch() !== null){
    $res = new response("200", "false");
  }
  else {
    $res = new response("404" ,"true");
  }

  echo $res->getJSON();
?>
