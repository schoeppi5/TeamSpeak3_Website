<?php
  include("./messageHandler.php");
  include("./login_config.php");

  if(isset($_POST)){
      try{
        $statement = $pdo->prepare("UPDATE admin SET
            username = :username,
            password = :password;
        ");
        $result = $statement->execute(array("username" => (!empty($_POST["common_username"]) ? $_POST["common_username"] : $pdo->query("SELECT username FROM admin")->fetch()["username"]),
                                  "password" => (!empty($_POST["common_password"]) ? password_hash($_POST["common_password"], PASSWORD_DEFAULT) : $pdo->query("SELECT password FROM admin")->fetch()["password"])));
        $statement2 = $pdo->prepare("UPDATE config SET name = :name, editor = :editor;");
        $result2 = $statement2->execute(array("name" => (!empty($_POST["common_name"]) ? $_POST["common_name"] : $pdo->query("SELECT name FROM config")->fetch()["name"]),
          "editor" => (!empty($_POST["common_editor"]) ? $_POST["common_editor"] : $pdo->query("SELECT editor FROM config")->fetch()["editor"])));
        if($result !== false && $result2 !== false){
          $res = new response("200", "Config saved");
        }
        else {
          $res = new response("500", "SQL Error");
        }
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
