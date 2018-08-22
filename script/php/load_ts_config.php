<?php
  include("./messageHandler.php");
  include("./login_config.php");

  $array = $pdo->query("SELECT * FROM tsconfig")->fetch();
  if(count($array) > 8){
    $res = new response("200", "Data queried");
    $res->mergeArray(array("ts" =>array("username" => $array["username"],
                                        "host" => $array["host"],
                                        "port" => $array["port"],
                                        "queryport" => $array["queryport"],
                                        "admingroup" => $array["admingroup"],
                                        "moderatorgroup" => $array["moderatorgroup"],
                                        "membergroup" => $array["membergroup"])));
  }
  else {
    $res = new response("404", "Server not jet configured");
  }

  echo $res->getJSON();
?>
