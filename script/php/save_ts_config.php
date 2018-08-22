<?php
  include("./messageHandler.php");
  include("./login_config.php");

  function isValid($var){
    return isset($var) && !empty($var);
  }

  if(isValid($_POST["username"]) && isValid($_POST["password"])
    && isValid($_POST["host"]) && isValid($_POST["port"]) && isValid($_POST["queryport"])
    && isValid($_POST["admingroup"]) && isValid($_POST["moderatorgroup"])
    && isValid($_POST["membergroup"])){
      try{
        $pdo->exec("DELETE FROM tsconfig");
        $statement = $pdo->prepare("INSERT INTO tsconfig (
                                      username,
                                      password,
                                      host,
                                      port,
                                      queryport,
                                      admingroup,
                                      moderatorgroup,
                                      membergroup)
                                    VALUES (
                                      :username,
                                      :password,
                                      :host,
                                      :port,
                                      :queryport,
                                      :admingroup,
                                      :moderatorgroup,
                                      :membergroup)
                                  ");
        $statement->execute(array("username" => $_POST["username"],
                                  "password" => $_POST["password"],
                                  "host" => $_POST["host"],
                                  "port" => $_POST["port"],
                                  "queryport" => $_POST["queryport"],
                                  "admingroup" => $_POST["admingroup"],
                                  "moderatorgroup" => $_POST["moderatorgroup"],
                                  "membergroup" => $_POST["membergroup"]));
        $res = new response("200", "Config saved");
      }
      catch(Exception $e){
        $res = new response("500", "Internal server error");
        $res->addErrorMessage($e);
      }
    }
    else {
      $res = new response("400", "bad request");
      $res->addErrorMessage("No or to less parameters given");
    }

    echo $res->getJSON();
?>
