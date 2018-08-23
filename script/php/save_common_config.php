<?php
  include("./messageHandler.php");
  include("./login_config.php");

  function isValid($var){
    return isset($var) && !empty($var);
  }

  if(isValid($_POST["common-username"]) && isValid($_POST["common-password"])){
      try{
        $pdo->exec("DELETE FROM admin");
        $statement = $pdo->prepare("INSERT INTO admin (
                                      username,
                                      password)
                                    VALUES (
                                      :username,
                                      :password)
                                  ");
        $statement->execute(array("username" => $_POST["common-username"],
                                  "password" => password_hash($_POST["common-password"], PASSWORD_DEFAULT)));
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
