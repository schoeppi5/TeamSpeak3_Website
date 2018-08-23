<?php
  include("./messageHandler.php");
  include("./login_config.php");

  function isValid($var){
    return isset($var) && !empty($var);
  }

  if(isValid($_POST["ts-username"]) && isValid($_POST["ts-host"])
    && isValid($_POST["ts-port"]) && isValid($_POST["ts-queryport"])
    && isValid($_POST["ts-admingroup"]) && isValid($_POST["ts-moderatorgroup"])
    && isValid($_POST["ts-membergroup"])){
      if(isValid($_POST["ts-password"]) || $pdo->query("SELECT password FROM tsconfig")->fetch() !== false)
      {
        (isValid($_POST["ts-password"]) ? $password = $_POST["ts-password"] : $password = $pdo->query("SELECT password FROM tsconfig")->fetch()["password"]);
        $password = base64_encode($password);
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
        $statement->execute(array("username" => $_POST["ts-username"],
                                  "password" => $password,
                                  "host" => $_POST["ts-host"],
                                  "port" => $_POST["ts-port"],
                                  "queryport" => $_POST["ts-queryport"],
                                  "admingroup" => $_POST["ts-admingroup"],
                                  "moderatorgroup" => $_POST["ts-moderatorgroup"],
                                  "membergroup" => $_POST["ts-membergroup"]));
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
