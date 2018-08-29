<?php
  include("./login_config.php");
  include("./messageHandler.php");

  $statement = $pdo->query("SELECT * FROM config");

  if($statement !== false){
    $res = new response("200", "Footer info queried");
    $res->mergeSubArray($statement->fetch(PDO::FETCH_ASSOC), "footerinfo");
  }
  else {
    $res = new response("500", "SQL error");
  }

  echo $res->getJSON();
?>
