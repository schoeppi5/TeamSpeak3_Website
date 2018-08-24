<?php
  include("./messageHandler.php");
  include("./login_config.php");

  function isValid($var){
    return isset($var) && !empty($var);
  }

  if(isValid($_POST["ts_username"]) && isValid($_POST["ts_host"])
    && isValid($_POST["ts_port"]) && isValid($_POST["ts_queryport"])
    && isValid($_POST["ts_admingroup"]) && isValid($_POST["ts_moderatorgroup"])
    && isValid($_POST["ts_membergroup"])){
      if(isValid($_POST["ts_password"]) || $pdo->query("SELECT password FROM tsconfig")->fetch() !== false)
      {
        (isValid($_POST["ts_password"]) === true ? $password = base64_encode($_POST["ts_password"]) : $password = $pdo->query("SELECT password FROM tsconfig")->fetch()["password"]);
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
        $statement->execute(array("username" => $_POST["ts_username"],
                                  "password" => $password,
                                  "host" => $_POST["ts_host"],
                                  "port" => $_POST["ts_port"],
                                  "queryport" => $_POST["ts_queryport"],
                                  "admingroup" => $_POST["ts_admingroup"],
                                  "moderatorgroup" => $_POST["ts_moderatorgroup"],
                                  "membergroup" => $_POST["ts_membergroup"]));
        $res = new response("200", "Config saved");
        }
        catch(Exception $e){
          $res = new response("500", "Internal server error");
          $res->addErrorMessage($e);
        }
      }
      else{
        $res = new response("404", "Password needed!");
      }
    }
    else {
      $res = new response("400", "bad request");
      $res->addErrorMessage("No or to less parameters given");
    }

    echo $res->getJSON();
?>
