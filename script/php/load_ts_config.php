<?php
  include("./messageHandler.php");
  include("./login_config.php");

  $res = new response("200", "Data queried");
  $array = $pdo->query("SELECT * FROM tsconfig")->fetch(PDO::FETCH_ASSOC);
  unset($array["password"]);
  $res->mergeArray(array("ts" => $array));

  echo $res->getJSON();
?>
